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
 * Business service for working with content types
 * 
 * @author Martin Cassidy
 */
interface IContentTypeService
{
    /**
     * Get an array of content types
     */
    function getContentTypes($start, $count);

    /**
     * Get the total number of content types
     * @return type 
     */
    function getContentTypeSize();
    
    /**
     * Get the available attributes for use on a content type
     * @return array 
     */
    function getAttributes();
    
    /**
     * Get a content type by its id
     * @param int $typeId
     * @return PopulatedContentType 
     */
    function getContentType($typeId);
    
    /**
     * Checks whether the content type name exists, ensuring it is not itself
     * @param string $name
     * @param int $id The id of the content type (if it exists)
     * @return boolean 
     */
    function checkNameExists($name, $id = null);
    
    /**
     * Get the fully populated attributes (include widget) for a content type
     * @param int $typeId
     * @return array 
     */
    function getContentTypeAttributes($typeId);
    
    /**
     * Delete a content type
     * @param int $typeId 
     */
    function deleteContentType($typeId);
    
    /**
     * Get the content types for either page or post type
     * @todo this needs to be an enum
     * @param string $requiredType
     * @return array 
     */
    function getContentTypeByType($requiredType);
    
    /**
     * Create the content type if it does not yet exist,
     * update otherwise
     * @param PopulatedContentType $type 
     */
    function createOrUpdate(PopulatedContentType $type);
    
    /**
     * Whether the content type is being user
     * @param int $contentTypeId
     * @return boolean 
     */
    function inUse($contentTypeId);
}

?>
