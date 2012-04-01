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
 * Data access object for content types
 * 
 * @author Martin Cassidy
 * @Repository
 */
class ContentDao extends AbstractDao
{
    public function createContent($name, ContentType $type)
    {
        return $this->getTemplate()->insert("INSERT INTO content (name, content_type_id) VALUES ('%s', %d);", array($name, $type->id));
    }
    
    public function updateContent($name, $contentId)
    {
        $this->getTemplate()->update("UPDATE content SET name = '%s' WHERE id = %d;", array($name, $contentId));
    }
    
    public function createContentEntry($contentId, $contentTypeAttributeId, $widgetConfigId)
    {
        return $this->getTemplate()->insert("INSERT INTO content_entries (content_id, content_type_attribute_id, widget_config_id) VALUES(%d, %d, %d);", array($contentId, $contentTypeAttributeId, $widgetConfigId));
    }
    
    public function deleteContentEntry($contentId)
    {
        $this->getTemplate()->update("DELETE FROM content_entries WHERE content_id = %d;", array($contentId));
    }
    
    public function deleteContent($contentId)
    {
        $this->getTemplate()->update("DELETE FROM content WHERE id = %d;", array($contentId));
    }
    
    public function getContentTypeId($contentId)
    {
        return $this->getTemplate()->queryForInt("SELECT content_type_id FROM content WHERE id = %d;", array($contentId));
    }
    
    public function getConfigId($contentId, $attributeId)
    {
        return $this->getTemplate()->queryForInt("SELECT widget_config_id FROM content_entries WHERE content_id = %d AND content_type_attribute_id = %d;", array($contentId, $attributeId));
    }
}

?>
