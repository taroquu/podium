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
 * Implementation of the post service
 * 
 * @author Martin Cassidy
 * @Service
 */
class PostService implements IPostService
{
    /**
     * @Resource
     */
    private $postDao;
    
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
    
    public function getPosts($start, $count)
    {
        $posts = $this->postDao->getRecords($start, $count);
        
        foreach($posts as $post)
        {
            $contentTypeId = $this->contentDao->getContentTypeId($post->contentId);
            $post->contentType = $this->contentTypeService->getContentType($contentTypeId);
        }
        
        return $posts;
    }
    
    public function getPostSize()
    {
        return $this->postDao->getPostSize();
    }
    
    public function getPost($postId)
    { 
        $post = $this->postDao->getPost($postId);
        $contentTypeId = $this->contentDao->getContentTypeId($post->contentId);
        
        $post->contentType = $this->contentTypeService->getContentType($contentTypeId);
        foreach($post->contentType->attributes as $attribute)
        {
            $item = $attribute->widget;
            $configId = $this->contentDao->getConfigId($post->contentId, $attribute->attributeId);
            $config = $this->widgetService->getWidgetConfig($item, $configId);
            $attribute->widget = new ConfigurableWidgetItem($item->id, $item->name, $item->class, $item->setupClass, $item->configClass, $item->widgetTargetTable, $config);
        }
        
        return $post;
    }
    
    public function preparePopulatedPost(Post $post)
    {
        $post->contentType = $this->contentTypeService->getContentType($post->contentType->id);
        foreach($post->contentType->attributes as $attribute)
        {
            $item = $attribute->widget;
            $config = WidgetFactory::newWidgetConfig($item);
            $attribute->widget = new ConfigurableWidgetItem($item->id, $item->name, $item->class, $item->setupClass, $item->configClass, $item->widgetTargetTable, $config);
        }
    }
    
    public function createOrUpdatePost(Post $post)
    {
        if($post->id==null)
        {
            $post->contentId = $this->contentDao->createContent($post->name, $post->contentType);
            $this->postDao->createPost($post);
        }
        else
        {
            $this->contentDao->updateContent($post->name, $post->contentId);
            $this->postDao->updatePost($post);
        }
        
        foreach($post->contentType->attributes as $attribute)
        {
            $createEntry = $attribute->widget->config->widgetConfigId==null; 
            $config = $this->widgetService->createOrUpdateWidgetConfig($attribute->widget);
            
            if($createEntry)
            {
                $this->contentDao->createContentEntry($post->contentId, $attribute->attributeId, $config->widgetConfigId);
            }
        }
    }
    
    public function deletePost($post)
    {
        foreach($post->contentType->attributes as $attribute)
        {
            $configs[$attribute->attributeId] = $this->contentDao->getConfigId($post->contentId, $attribute->attributeId);
        }
        $this->contentDao->deleteContentEntry($post->contentId);
        $this->postDao->deletePost($post->id);
        
        foreach($post->contentType->attributes as $attribute)
        {
            $this->widgetService->deleteWidgetConfig($attribute->widget, $configs[$attribute->attributeId]);
        }
    }
    
    public function getPostByContentType($typeId)
    {
        return $this->postDao->getPostByContentType($typeId);
    }
}

?>
