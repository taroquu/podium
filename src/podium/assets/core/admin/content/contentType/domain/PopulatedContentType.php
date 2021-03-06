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
 * Fully populated content type domain
 * 
 * @author Martin Cassidy
 */
class PopulatedContentType extends ContentType
{
    private $attributes = array();
    private $arrangement;
    private $theme;
    
    public function addAttribute(ContentTypeAttribute $attribute, $index = null)
    {
        if($index==null)
        {
            array_push($this->attributes, $attribute);
        }
        else
        {
            array_splice($this->attributes, $index, count($this->attributes), array_merge(array($attribute), array_slice($this->attributes, $index))); 
        }
    }
    
    public function removeAttribute(ContentTypeAttribute $attribute)
    {
        foreach($this->attributes as $index => $sattribute)
        {
            if($sattribute==$attribute)
            {
                unset($this->attributes[$index]);
            }
        }
    }
}

?>
