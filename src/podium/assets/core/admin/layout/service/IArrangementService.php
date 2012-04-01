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
 *
 * @author Martin Cassidy
 */
interface IArrangementService
{    
    /**
     * Get an array of the arrangements created on a layout
     * @param Layout $layout
     * @param int $start
     * @param int $count
     * @return array 
     */
    function getArrangementsForLayout(Layout $layout, $start, $count);
          

    /**
     * Get the total number of arrangements for a layout
     * @param int $layoutId
     * @return int
     */
    function getArrangementCount($layoutId);
    
    /**
     * Get an arrangement by id
     * @param int $arrangementId
     * @return PopulatedArrangement
     */
    function getArrangement($arrangementId);

    /**
     * Create the arrangement if it does not exist already,
     * update otherwise
     * @param Arrangement $arrangement
     */
    function createOrUpdateArrangement(Arrangement $arrangement);
    

    /**
     * Populate an arrangement with full domain objects
     * @param Arrangement $arrangement
     * @todo need some sub classing here to make this more obvious
     * @return Arrangement 
     */
    function prePopulate(Arrangement $arrangement);
    
    
    /**
     * Delete the given arrangement
     * @param Arrangement $arrangement 
     */
    function deleteArrangement(Arrangement $arrangement);
    
    
    /**
     * Is the arrangement in use or not
     * @param int $arrangementId
     * @return boolean
     */
    function inUse($arrangementId);
}

?>
