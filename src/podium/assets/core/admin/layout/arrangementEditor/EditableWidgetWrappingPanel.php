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
 * Wraps the contents of a widget so that it has drag/options/delete controls
 * 
 * @author Martin Cassidy
 */
class EditableWidgetWrappingPanel extends picon\Panel
{
    const INNER_PANEL_ID = 'widgetPanel';
    
    public function __construct($id, Widget $widget, WidgetItem $item, $editCallback, $deleteCallback)
    {
        parent::__construct($id); 
        $this->add($widget);
        $widgetId = new \picon\MarkupContainer('widgetId');
        $this->add($widgetId);
        $widgetId->add(new picon\AttributeModifier('value', new \picon\BasicModel($item->elementId)));
        
        $this->add(new picon\AjaxLink('edit', function(\picon\AjaxRequestTarget $target) use ($editCallback, $item)
        {
            $editCallback($target, $item);
        }));
        
        $this->add(new picon\AjaxLink('delete', function(\picon\AjaxRequestTarget $target) use ($deleteCallback, $item)
        {
            $deleteCallback($target, $item);
        }));
    }
}

?>
