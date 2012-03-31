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
 * Prints out raw CSS generated from a them
 * @todo this is temperary only
 * @author Martin Cassidy
 */
class ThemeStyle extends picon\MarkupContainer
{
    private $theme;
    
    public function __construct($id, PopulatedTheme $theme)
    {
        parent::__construct($id);
        $this->theme = $theme;
    }
    
    protected function onComponentTag(ComponentTag $tag)
    {
        parent::onComponentTag($tag);
        $this->checkComponentTag($tag, 'style');
    }
    
    protected function onComponentTagBody(ComponentTag $tag)
    {
        $contents = @file_get_contents('css/theme.css');
        $values = null;
        preg_match_all("/value\([\w\.\[\]]*\)/", $contents, $values);
        $replace = array();
        foreach($values[0] as $property)
        {
            $property = substr($property, strpos($property, '(')+1);
            $property = substr($property, 0, strpos($property, ')'));
            $replace[] = $this->getPropertyValue($property, $this->theme);
        }
        $contents = str_replace($values[0], $replace, $contents);
        $this->getResponse()->write($contents);
    }
    
    private function getPropertyValue($property, $object)
    {
        if(!strpos($property, '['))
        {
            return picon\PropertyResolver::get($object, $property);
        }
        else
        {
            $properties = explode('.', $property);
            if(!strpos($properties[0], '['))
            {
                $value = picon\PropertyResolver::get($object, $properties[0]);
                unset($properties[0]);
                return $this->getPropertyValue(implode('.', $properties), $value);
            }
            else
            {
                $actual = substr($properties[0], 0, strpos($properties[0], '['));
                $value = picon\PropertyResolver::get($object, $actual);
                $index = substr($properties[0], strpos($properties[0], '[')+1);
                $index = substr($index, 0, strpos($index, ']'));
                
                if(!is_array($value))
                {
                    throw new IllegalStateException(sprintf('Expected property %s inside class %s to be an array', $actual, get_class($object)));
                }
                if(count($properties)==1)
                {
                    return $value[$index];
                }
                else
                {
                    unset($properties[0]);
                    return $this->getPropertyValue(implode('.', $properties), $value[$index]);
                }
            }
        }
    }
}

?>
