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
 * Business service for themes
 * @author Martin Cassidy
 */
interface IThemeService
{
    /**
     * Get an array of themes
     * @param int $start
     * @param int $count
     * @return array 
     */
    function getThemes($start, $count);
    
    /**
     * Get the total number of themes
     * @return int
     */
    function getThemeSize();
    
    /**
     * Create the given theme if it does exist,
     * update otherwise
     * @param PopulatedTheme $theme 
     */
    function createOrUpdateTheme(PopulatedTheme $theme);
    
    /**
     * Get a theme by its id
     * @param int $themeId
     * @return PopulatedTheme
     */
    function getTheme($themeId);
    
    /**
     * Delete the given theme
     * @param Theme $theme 
     */
    function deleteTheme(Theme $theme);
    
    /**
     * Whether or not the theme is in use
     * @param int $themeId
     * @return boolean
     */
    function inUse($themeId);
    
    /**
     * Checks whether the theme name exists, ensuring it is not itself
     * @param string $name
     * @param int $id The id of the theme (if it exists)
     * @return boolean 
     */
    function checkNameExists($name, $id = null);
}

?>
