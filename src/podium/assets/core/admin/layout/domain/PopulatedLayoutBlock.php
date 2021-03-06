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
 * A layout block which is populated with widgets
 * @author Martin Cassidy
 */
class PopulatedLayoutBlock extends LayoutBlock
{
    private $widgets = array();
    
    public function addWidget(WidgetElementItem $widget, $index = null)
    {
        if($index==null)
        {
            array_push($this->widgets, $widget);
        }
        else
        {
            array_splice($this->widgets, $index, count($this->widgets), array_merge(array($widget), array_slice($this->widgets, $index))); 
        }
    }
    
    public function getWidgets()
    {
        return $this->widgets;
    }
    
    public function removeWidget(WidgetElementItem $item)
    {
        foreach($this->widgets as $index => $widget)
        {
            if($item==$widget)
            {
                unset($this->widgets[$index]);
            }
        }
    }
}

?>
