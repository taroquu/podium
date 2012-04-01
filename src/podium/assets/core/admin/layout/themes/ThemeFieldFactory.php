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
 * Factory for theme form fields
 * 
 * @author Martin Cassidy
 */
class ThemeFieldFactory
{
    public static function newFontSize($id)
    {
        $sizes = array(8,9,10,11,12,14,16,18,24,36,48,72);
        $drop = new picon\DropDown($id, $sizes);
        $drop->setRequired(true);
        return $drop;
    }
    
    public static function newFontWeight($id)
    {
        $weights = array('normal', 'bold', 'bolder', 'lighter');
        $field = new \picon\RadioChoice($id, $weights);
        $field->setRequired(true);
        return $field;
    }
    
    public static function newTextDecoration($id)
    {
        $decorations = array('none', 'underline', 'overline', 'line-through');
        $field = new \picon\RadioChoice($id, $decorations);
        $field->setRequired(true);
        return $field;
    }
}

?>
