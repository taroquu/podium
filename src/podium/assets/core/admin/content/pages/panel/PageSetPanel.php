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
 * Description of PageSetPanel
 * 
 * @author Martin Cassidy
 */
class PageSetPanel extends \picon\Panel
{
    /**
     * @Resource
     */
    private $pageService;
    
    private $container;
    public function __construct($id, $pages)
    {
        parent::__construct($id);
        
        $this->container = new \picon\MarkupContainer('container');
        $this->add($this->container);
        $self = $this;
        $this->container->add(new \picon\ListView('page', function(picon\ListItem $item) use ($self)
        {
            $page = $item->getModelObject();
            $item->setMarkupId('page_'.$page->id);
            $item->setOutputMarkupId(true);
            $item->add(new picon\Label('name', new picon\BasicModel($page->name)));
            
            $item->add(new \picon\Link('edit', function() use ($self, $page)
            {
                $self->setPage(new EditPage($self->getPageService()->getPage($page->id)));
            }));
            
            $item->add(new \picon\Link('delete', function() use ($self, $page)
            {
                $self->getPageService()->deletePage($page);
                $self->setPage(PagesListPage::getIdentifier());
            }));
            
            $item->add(new PageSetPanel('nested', $page->nestedPages));
        }, new picon\ArrayModel($pages)));
    }
    
    public function getContainer()
    {
        return $this->container;
    }
    
    public function getPageService()
    {
        return $this->pageService;
    }
}

?>
