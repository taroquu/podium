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
 * Helper for mapping virtual pages
 * 
 * @author Martin Cassidy
 */
class PageMountingHelper
{
    /**
     * Mount all the passed page in the page map
     * @param array $pages
     * @param picon\PageMap $map
     * @param string $parent 
     */
    public static function mountPages($pages, picon\PageMap $map)
    {
        self::internalMountPages($pages, $map);
    }
    
    private static function internalMountPages($pages, picon\PageMap $map, $parent = '')
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
                self::internalMountPages($page->nestedPages, $map, $path.'/');
            }
        }
    }
    
    /**
     * Re mounts all pages, replacing the old ones, 
     * including those that no longer exist
     * @param array $pages
     * @param picon\PageMap $map 
     */
    public static function updateMount($pages, picon\PageMap $map)
    {
        $mounted = $map->getMounted();
        
        foreach($mounted as $path)
        {
            $map->unMount($path);
        }
        self::internalMountPages($pages, $map);
    }
}

?>
