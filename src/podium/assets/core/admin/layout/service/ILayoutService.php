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
 * Business service for layouts
 * @author Martin Cassidy
 */
interface ILayoutService
{    
    /**
     * Get an array of layous
     * @param int $start
     * @param int $count
     * @return array
     */
    function getLayouts($start, $count);
    
    /**
     * Get the total number of layouts
     * @return int
     */
    function getLayoutsSize();
    
    /**
     * Get a layout by its id
     * @param int $id
     * @return PopulatedLayout
     */
    function getLayout($id);
    
    
    /**
     * Create the layout if it does not exist,
     * update otherwise
     * @param Layout $layout 
     */
    function createOrUpdateLayout(Layout $layout);
    
    /**
     * Delete the given layout
     * @param Laout $layout 
     */
    function delete(Laout $layout);
    
    /**
     * Get an array of layouts each of which contains an array of its
     * arrangements
     * @return array 
     */
    function getLayoutsAndArrangement();
    
    /**
     * Whether the layout is in use
     * @param int $layoutId
     * @return boolean
     */
    function inUse($layoutId);
}

?>
