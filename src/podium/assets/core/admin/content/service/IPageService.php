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
 * Business service for pages
 * @author Martin Cassidy
 */
interface IPageService
{
    /**
     * Gets all of the pages, in a recursive hierarchial array
     * @return array 
     */
    function getPages();
    
    /**
     * Update the page hierarchy with the new recursive hierarchial array
     * @param array $pages
     */
    function updateHierarchy($pages);
    
    /**
     * Get a non recursive array of all of the page names, child pages
     * will be prefixed with hyphens
     * @todo this should be removed and getPages() should be used instead to remove duplication.
     * Hyphens to be handled in the presentation layer
     * @return array 
     */
    function getPagesStack();
    
    /**
     * Get a page by its ID
     * @param int $pageId
     * @return PopulatedPage
     */
    function getPage($pageId);
    
    /**
     * Create the page if it does not exist,
     * update otherwise
     * @param PopulatedPage $page
     */
    function createOrUpdatePage(PopulatedPage $page);
    
    /**
     * Prepare a page by replacing simple domain values with 
     * their full complex populated ones
     * @todo sub class Populated page to make this more obvious
     * @param PopulatedPage $page 
     * @return PopulatedPage $page 
     */
    function preparePopulatedPage(PopulatedPage $page);
    
    /**
     * Delete a page
     * @param Page $page 
     */
    function deletePage(Page $page);
    
    /**
     * Get the id of the homepage
     * @return int
     */
    function getHomePageId();
    
    /**
     * Get the page id for a given path
     * @param string $path
     * @return int
     */
    function getPageIdForPath($path);
    
    /**
     * Get the arrangement for a page id
     * @param int $pageId
     * @return PopulatedArrangement 
     */
    function getArrangementForPage($pageId);
    
    /**
     * Get the theme for a page id
     * @param int $pageId
     * @return PopulatedTheme
     */
    function getThemeForPage($pageId);
    
    /**
     * Set the given page id as the homepage, replacing the current
     * @param int $pageId 
     */
    function setAsHomePage($pageId);
    
    /**
     * Checks whether the page name exists, ensuring it is not itself
     * @param string $name
     * @param int $id The id of the page (if it exists)
     * @return boolean 
     */
    function checkNameExists($name, $id = null);
    
    /**
     * The the total number of pages
     * @return int
     */
    function getPageSize();
}

?>
