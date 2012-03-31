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
 * Description of ContentTypeDao
 * 
 * @author Martin Cassidy
 * @Repository
 */
class ContentTypeDao extends AbstractDao
{
    public function getContentTypes($start, $count)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return new ContentType($row->name, $row->type, $row->id);
        });
        
        return $this->getTemplate()->query("SELECT * FROM content_type LIMIT %d, %d;", $mapper, array($start, $count));
    }
    
    public function getContentTypeSize()
    {
        return $this->getTemplate()->queryForInt("SELECT count(*) FROM content_type;");
    }
    
    public function getAttributes()
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return new ContentTypeAttribute($row->id, $row->name, $row->widget_id);
        });
        return $this->getTemplate()->query("SELECT * FROM content_attributes;", $mapper);
    }
    
    public function createContentType(PopulatedContentType $contentType)
    {
        return $this->getTemplate()->insert("INSERT INTO content_type (name, type, arrangement_id, theme_id) VALUES('%s', '%s', %d, %d);", array($contentType->name, $contentType->type, $contentType->arrangement->id, $contentType->theme->id));
    }
    
    public function updateContentType(PopulatedContentType $contentType)
    {
        $this->getTemplate()->update("UPDATE content_type SET name= '%s', arrangement_id = %d, theme_id = %d WHERE id = %d;", array($contentType->name, $contentType->arrangement->id, $contentType->theme->id, $contentType->id));
    }
    
    public function getContentType($typeId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return new PopulatedContentType($row->name, $row->type, $row->id);
        });
        
        $types = $this->getTemplate()->query("SELECT * FROM content_type WHERE id = %d;", $mapper, array($typeId));
        
        if(count($types)!=1)
        {
            throw new IllegalStateException('Expected only one content type');
        }
        return $types[0];
    }
    
    public function deleteContentType($typeId)
    {
        $this->getTemplate()->update("DELETE FROM content_type WHERE id = %d;", array($typeId));
    }
    
    public function addContentTypeAttribute(ContentTypeAttribute $attribute, $index, $contentTypeId)
    {
        return $this->getTemplate()->insert("INSERT INTO content_type_attributes (name, content_type_id, attribute_id, `index`) VALUES('%s', %d, %d, %d);", array($attribute->name, $contentTypeId, $attribute->id, $index));
    }
    
    public function updateContentTypeAttribute(ContentTypeAttribute $attribute, $index)
    {
        $this->getTemplate()->update("UPDATE content_type_attributes SET name = '%s', `index` = %d WHERE id = %d;", array($attribute->name, $index, $attribute->attributeId));
    }
    
    public function deleteContentTypeAttribute($attributeId)
    {
        $this->getTemplate()->update("DELETE FROM content_type_attributes WHERE id = %d;", array($attributeId));
    }
    
    public function getContentTypeAttributes($contentTypeId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return new ContentTypeAttribute($row->attribute_id, $row->name, $row->widget_id, $row->id);
        });
        return $this->getTemplate()->query("SELECT content_type_attributes.*, content_attributes.widget_id FROM content_type_attributes INNER JOIN content_attributes ON content_type_attributes.attribute_id = content_attributes.id WHERE content_type_id = %d;", $mapper, array($contentTypeId));
    }
    
    public function getContentTypeArrangementId($contentTypeId)
    {
        return $this->getTemplate()->queryForInt("SELECT arrangement_id FROM content_type WHERE id = %d;", array($contentTypeId));
    }
    
    public function getContentTypeThemeId($contentTypeId)
    {
        return $this->getTemplate()->queryForInt("SELECT theme_id FROM content_type WHERE id = %d;", array($contentTypeId));
    }
    
    public function getUsingEntryCount($contentTypeId)
    {
        return $this->getTemplate()->queryForInt("SELECT count(*) FROM content WHERE content_type_id = %d;", array($contentTypeId));
    }
}

?>
