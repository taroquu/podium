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
 * Extra listener for the page map, mounts all web page types found
 * in the database
 * 
 * @author Martin Cassidy
 */
class PageMapMountingListener implements \picon\PageMapInitializationListener
{
    /**
     * @Resource
     */
    private $pageService;
    
    /**
     * @todo This injection should be done in some other way
     * @param picon\PageMap $map
     */
    public function onInitialize(picon\PageMap $map)
    {
        if($this->pageService==null)
        {
            \picon\Injector::get()->inject($this);
        }
        
        $pages = $this->pageService->getPages();
        $this->mountPages($pages, $map);
    }
    
    private function mountPages($pages, picon\PageMap $map, $parent = '')
    {
        foreach($pages as $page)
        {
            $path = $parent.$page->name;
            if(!$map->isMounted($path))
            {
                $map->mount($path, FrontPage::getIdentifier());
            }
            if(count($page->nestedPages)>0)
            {
                $this->mountPages($page->nestedPages, $map, $path.'/');
            }
        }
    }
}

?>
