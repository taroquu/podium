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
 * Database access object for working with themes
 * 
 * @author Martin Cassidy
 * @Repository
 */
class ThemeDao extends AbstractDao
{
    const THEME_ELEMENT_TYPE_ARRAY = 'array';
    const THEME_ELEMENT_TYPE_OBJECT = 'object';
    
    public function getThemeSize()
    {
        return $this->getTemplate()->queryForInt("SELECT count(*) FROM theme");
    }
    
    public function getThemes($start, $count)
    {
        $mapper = function($row)
        {
            return new Theme($row->name, $row->id);
        };
        return $this->getTemplate()->query("SELECT * FROM theme LIMIT %d, %d", new picon\CallbackRowMapper($mapper), array($start, $count));
    }
    
    public function getTheme($themeId)
    {
        $mapper = function($row)
        {
            return new PopulatedTheme($row->name, $row->id);
        };
        $themes = $this->getTemplate()->query("SELECT * FROM theme WHERE id = %d", new picon\CallbackRowMapper($mapper), array($themeId));
        
        if(count($themes)!=1)
        {
            throw new IllegalStateException(sprintf('Expecting only 1 theme, actual %d', count($themes)));
        }
        return $themes[0];
    }
    
    public function createTheme($name)
    {
        return $this->getTemplate()->insert("INSERT INTO theme (name) VALUES ('%s');", array($name));
    }
    
    public function updateTheme($name, $id)
    {
        return $this->getTemplate()->update("UPDATE theme SET name = '%s' WHERE id = %d;", array($name, $id));
    }
    
    public function delete($id)
    {
        return $this->getTemplate()->update("DELETE FROM theme WHERE id = %d;", array( $id));
    }
    
    public function createThemeElement($name, $themeId, $type, $class, $index = null, $parent_element = null)
    {
        return $this->getTemplate()->insert("INSERT INTO theme_elements (name, theme_id, type, class, `index`, parent_element) VALUES ('%s', %d,'%s','%s', %s, %s);", array($name,$themeId, $type, $class, $index==null?'NULL':$index, $parent_element==null?'NULL':$parent_element));
    }
    
    public function createThemeAttribute($elementId, $name, $value)
    {
        return $this->getTemplate()->insert("INSERT INTO theme_attributes (theme_element_id, name, value) VALUES (%d,'%s','%s');", array($elementId, $name, $value));
    }
    
    public function getElements($themeId, $parent = null)
    {
        $mapper = function($row)
        {
            return array('id' => $row->id, 'name' => $row->name, 'class' => $row->class, 'type' => $row->type, 'index' => $row->index);
        };
        return $this->getTemplate()->query("SELECT * FROM theme_elements WHERE theme_id = %d AND parent_element %s ORDER BY `index` ASC", new picon\CallbackRowMapper($mapper), array($themeId, $parent==null?' IS NULL':' = '.$parent));
    }
    
    public function getAttribute($elementId)
    {
        $mapper = function($row)
        {
            return array('name' => $row->name, 'value' => $row->value);
        };
        return $this->getTemplate()->query("SELECT * FROM theme_attributes WHERE theme_element_id = %d", new picon\CallbackRowMapper($mapper), array($elementId));
    }
    
    public function deleteAttributes($elementId)
    {
        return $this->getTemplate()->update("DELETE FROM theme_attributes WHERE theme_element_id = %d;", array($elementId));
    }
    
    public function deleteElement($elementId)
    {
        return $this->getTemplate()->update("DELETE FROM theme_elements WHERE id = %d;", array($elementId));
    }
    
    public function getThemeUseageCount($themeId)
    {
        return $this->getTemplate()->queryForInt("SELECT count(*) FROM theme WHERE id = %d AND (id IN (SELECT theme_id FROM content_type) OR id IN (SELECT theme_id FROM page))", array($themeId));
    }
}

?>
