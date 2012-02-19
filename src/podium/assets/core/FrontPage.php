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

use picon\WebPage;

/**
 * Description of FrontPage
 *
 * @author Martin Cassidy
 */
class FrontPage extends WebPage
{
    /**
     * @Resource
     */
    private $pageService;
    
    public function __construct()
    {
        parent::__construct();
        $path = substr(urldecode(str_replace($this->getRequest()->getRootPath(), '', $this->getRequest()->getPath())), 1);
        $pageId = null;
        if(empty($path))
        {
            $pageId = $this->pageService->getHomePageId();
        }
        else
        {
            $pageId = $this->pageService->getPageIdForPath($path);
        }
        $page = $this->pageService->getPage($pageId);
        
        $title = $page->seoTitle==null?$page->name:$page->seoTitle;
        $this->add(new \picon\Label('title', new picon\BasicModel($title)));
        
        $keywords = new \picon\MarkupContainer('keywords');
        $keywords->add(new picon\AttributeModifier('content', new picon\BasicModel($page->metaKeys)));
        $keywords->setVisible($page->metaKeys!=null);
        $this->add($keywords);
        
        $description = new \picon\MarkupContainer('description');
        $description->add(new picon\AttributeModifier('content', new picon\BasicModel($page->metaDescription)));
        $description->setVisible($page->metaDescription!=null);
        $this->add($description);
        
        $title = new \picon\MarkupContainer('metaTitle');
        $title->add(new picon\AttributeModifier('content', new picon\BasicModel($page->seoTitle)));
        $title->setVisible($page->seoTitle!=null);
        $this->add($title);
        
        $arrangement = $this->pageService->getArrangementForPage($pageId);
        $view = new picon\RepeatingView('layoutBlock');
        $this->add($view);
        foreach($arrangement->layout->getBlocks() as $block)
        {
            $view->add(LayoutFactory::newPageLayoutBlockPanel($view->getNextChildId(), $block, $page));
        }
    }
    
    public function renderHead(picon\HeaderResponse $headerResponse)
    {
        parent::renderHead($headerResponse);
        $headerResponse->renderCSSFile('css/style.css');
    }
}

?>
