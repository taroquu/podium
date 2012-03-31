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
 * Description of ThemeService
 * 
 * @author Martin Cassidy
 * @Service
 */
class ThemeService
{
    /**
     * @Resource
     */
    private $themeDao;
    
    public function getThemes($start, $count)
    {
        return $this->themeDao->getThemes($start, $count);
    }
    
    public function getThemeSize()
    {
        return $this->themeDao->getThemeSize();
    }
    
    public function createOrUpdateTheme(PopulatedTheme $theme)
    {
        if($theme->id==null)
        {
            $theme->id = $this->themeDao->createTheme($theme->name);
        }
        else
        {
            $this->themeDao->updateTheme($theme->name, $theme->id);
            $elements = $this->themeDao->getElements($theme->id);
            foreach($elements as $element)
            {
                $this->themeDao->deleteAttributes($element['id']);
            }
            $this->themeDao->deleteElements($theme->id);
        }
        
        $reflection = new ReflectionClass($theme);
        $nonElement = array('name', 'id');
        
        foreach($reflection->getProperties() as $property)
        {
            if(!in_array($property->getName(), $nonElement))
            {
                $this->createElement($property, $theme, $theme->id);
            }
        }
    }
    
    private function createElement(ReflectionProperty $property, $object, $themeId, $parent = null)
    {
        $property->setAccessible(true);
        $value = $property->getValue($object);
        
        if(is_array($value))
        {
            foreach($value as $index => $element)
            {
                $elementId = $this->themeDao->createThemeElement($property->getName(), $themeId, ThemeDao::THEME_ELEMENT_TYPE_ARRAY, get_class($element), ($index+1), $parent);
                $this->processElement($element, $elementId, $themeId);
            }
        }
        elseif(is_object($value))
        {
            $elementId = $this->themeDao->createThemeElement($property->getName(), $themeId, ThemeDao::THEME_ELEMENT_TYPE_OBJECT, get_class($value), null, $parent);
            $this->processElement($value, $elementId, $themeId);
        }
    }
    
    private function processElement($element, $elementId, $themeId)
    {
        if($element==null) return;
        $reflection = new ReflectionClass($element);
        
        foreach($reflection->getProperties() as $property)
        {
            $property->setAccessible(true);
            $value = $property->getValue($element);
            
            if(is_array($value) || is_object($value))
            {
                $this->createElement($property, $element, $themeId, $elementId);
            }
            else
            {
                $this->themeDao->createThemeAttribute($elementId, $property->getName(), $value);
            }
        }
    }
    
    public function getTheme($themeId)
    {
        $theme = $this->themeDao->getTheme($themeId);
        $this->insertElements($theme, $themeId);
        return $theme;
    }
    
    private function insertElements($object, $themeId, $parent = null)
    {
        $elements = $this->themeDao->getElements($themeId, $parent);
        $reflection = new ReflectionClass($object);
        foreach($elements as $entry)
        {
            $property = $reflection->getProperty($entry['name']);
            $property->setAccessible(true);
            $elementValue = null;
            $className = $entry['class'];
            $newClass = new $className();
            $this->populateElementAttributes($newClass, $entry['id']);
            $this->insertElements($newClass, $themeId, $entry['id']);

            if($entry['type']==ThemeDao::THEME_ELEMENT_TYPE_ARRAY)
            {
                $elementValue = array();
                if(is_array($property->getValue($object)) && $entry['index']>1)
                {
                    $elementValue = $property->getValue($object);
                }
                $elementValue[] = $newClass;
            }
            else
            {
                $elementValue = $newClass;
            }
            $property->setValue($object, $elementValue);
        }
    }
    
    private function populateElementAttributes($element, $elementId)
    {
        $attributes = $this->themeDao->getAttribute($elementId);
        $reflection = new ReflectionClass($element);
        foreach($attributes as $attribute)
        {
            $property = $reflection->getProperty($attribute['name']);
            $property->setAccessible(true);
            $property->setValue($element, $attribute['value']);
        }
    }
    
    public function deleteTheme(Theme $theme)
    {
        $elements = $this->themeDao->getElements($theme->id);
        foreach($elements as $element)
        {
            $this->themeDao->deleteAttributes($element['id']);
        }
        $this->themeDao->deleteElements($theme->id);
        $this->themeDao->delete($theme->id);
    }
}

?>
