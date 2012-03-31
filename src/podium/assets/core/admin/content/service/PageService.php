<?php

/**
 * Podium CMS
 * http://code.google.com/p/podium/
 *
 * Copyright (C) 2011-2012 Martin Cassidy <martin.cassidy@webquub.com>

 * Podium CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * Podium CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with Podium CMS.  If not, see <http://www.gnu.org/licenses/>.
 * */

/**
 * Description of PageService
 * 
 * @author Martin Cassidy
 * @Service
 */
class PageService
{
    /**
     * @Resource
     */
    private $pageDao;
    
    /**
     * @Resource
     */
    private $contentDao;
    
    /**
     * @Resource
     */
    private $contentTypeService;
    
    /**
     * @Resource
     */
    private $widgetService;
    
    /**
     * @Resource
     */
    private $arrangementService;
    
    /**
     * @Resource
     */
    private $themeService;
    
    public function getPages()
    {
        return $this->internalGetPages();
    }
    
    private function internalGetPages($parentId = null)
    {
        $pages = $this->pageDao->getPages($parentId);
        foreach($pages as $page)
        {
            $page->nestedPages = $this->internalGetPages($page->id);
        }
        return $pages;
    }
    
    public function updateHierarchy($pages)
    {
        $counts = array();
        foreach($pages as $pageId => $parentId)
        {
            $index = 0;
            if(array_key_exists($parentId, $counts))
            {
                $index = $counts[$parentId] + 1 ;
            }
            $this->pageDao->updateIndex($pageId, $parentId=='root'?'NULL':$parentId, $index);
            $counts[$parentId] = $index;
        }
    }
    
    public function getPagesStack()
    {
        $pages = $this->getPages();
        return $this->internalGetPagesStack($pages);
    }
    
    private function internalGetPagesStack($pages, $level = 0)
    {
        $stack = array();
        $indent = '';
        for($i=0;$i<$level;$i++)
        {
            $indent .= '-';
        }
        
        foreach($pages as $page)
        {
            $page->name = $indent.$page->name;
            array_push($stack, $page);
            $stack = array_merge($stack, $this->internalGetPagesStack($page->nestedPages, $level +1));
        }
        return $stack;
    }
    
    public function getPage($pageId)
    {
        $page = $this->pageDao->getPage($pageId);
        $contentTypeId = $this->contentDao->getContentTypeId($page->contentId);
        
        if($page->parent_page!=null)
        {
            $page->parent_page = $this->pageDao->getPage($page->parent_page);
        }
        
        $page->contentType = $this->contentTypeService->getContentType($contentTypeId);
        foreach($page->contentType->attributes as $attribute)
        {
            $item = $attribute->widget;
            $configId = $this->contentDao->getConfigId($page->contentId, $attribute->attributeId);
            $config = $this->widgetService->getWidgetConfig($item, $configId);
            $attribute->widget = new ConfigurableWidgetItem($item->id, $item->name, $item->class, $item->setupClass, $item->configClass, $item->widgetTargetTable, $config);
        }
        
        $arrangementId = $this->pageDao->getArrangementIdForPage($pageId);
        $page->arrangement = $arrangementId==null?null:$this->arrangementService->getArrangement($arrangementId);
        
        $themeId = $this->pageDao->getThemeIdForPage($pageId);
        $page->theme = $themeId==null?null:$this->themeService->getTheme($themeId);
        
        return $page;
    }
    
    public function createOrUpdatePage(PopulatedPage $page)
    {
        if($page->id==null)
        {
            $lastIndex = $this->pageDao->getLastIndex($page->parent_page==null?null:$page->parent_page->id);
            $page->contentId = $this->contentDao->createContent($page->name, $page->contentType);
            $this->pageDao->createPage($page, $lastIndex+1);
        }
        else
        {
            $this->contentDao->updateContent($page->name, $page->contentId);
            $this->pageDao->updatePage($page);
        }
        
        foreach($page->contentType->attributes as $attribute)
        {
            $createEntry = $attribute->widget->config->widgetConfigId==null; 
            $config = $this->widgetService->createOrUpdateWidgetConfig($attribute->widget);
            
            if($createEntry)
            {
                $this->contentDao->createContentEntry($page->contentId, $attribute->attributeId, $config->widgetConfigId);
            }
        }
    }
    
    public function preparePopulatedPage(PopulatedPage $page)
    {
        $page->contentType = $this->contentTypeService->getContentType($page->contentType->id);
        foreach($page->contentType->attributes as $attribute)
        {
            $item = $attribute->widget;
            $config = WidgetFactory::newWidgetConfig($item);
            $attribute->widget = new ConfigurableWidgetItem($item->id, $item->name, $item->class, $item->setupClass, $item->configClass, $item->widgetTargetTable, $config);
        }
    }
    
    public function deletePage(Page $page)
    {
        $this->contentDao->deleteContentEntry($page->contentId);
        $this->pageDao->deleteChildPage($page->id);
        $this->pageDao->deletePage($page->id);
        $this->contentDao->deleteContent($page->contentId);
    }
    
    public function getHomePageId()
    {
        return $this->pageDao->getHomePageId();
    }
    
    public function getPageIdForPath($path)
    {
        $pages = $this->getPages();
        $paths = $this->getPagePaths($pages);
        
        if(array_key_exists($path, $paths))
        {
            return $paths[$path]->id;
        }
        return null;
    }
    
    private function getPagePaths($pages, $parent = '')
    {
        $paths = array();
        foreach($pages as $page)
        {
            $path = $parent.$page->name;
            $paths[$path] = $page;
            $paths = array_merge($paths, $this->getPagePaths($page->nestedPages, $path.'/'));
        }
        return $paths;
    }
    
    public function getArrangementForPage($pageId)
    {
        $page = $this->getPage($pageId);
        
        if($page->arrangement==null)
        {
            return $page->contentType->arrangement;
        }
        else
        {
            return $page->arrangement;

        }
    }
    
    public function getThemeForPage($pageId)
    {
        $page = $this->getPage($pageId);
        
        if($page->theme==null)
        {
            return $page->contentType->theme;
        }
        else
        {
            return $page->theme;

        }
    }
}

?>
