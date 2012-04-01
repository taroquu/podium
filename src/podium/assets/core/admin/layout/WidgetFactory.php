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
 * Factory for creating widget panels and widget config panels,
 * 
 * @author Martin Cassidy
 */
class WidgetFactory
{
    public static function getWidget($id, ConfigurableWidgetItem $item, $page)
    {
        $className = $item->class;
        $reflection = new ReflectionClass($className);
        return $reflection->newInstanceArgs(array($id, $item, $page));
    }
    
    public static function getEditableWidget($id, ConfigurableWidgetItem $item, $editCallback, $deleteCallback)
    {
        return new EditableWidgetWrappingPanel($id, self::getWidget(EditableWidgetWrappingPanel::INNER_PANEL_ID, $item), $item, $editCallback, $deleteCallback);
    }
    
    public static function getModalWindowWidgetConfigPanel(WidgetElementItem $item, picon\ModalWindow $mw, \picon\Component $updateComponent)
    {
        $panel = self::getWidgetConfigPanel(ModalWidgetSetupPanel::INNER_PANEL_ID, $item);
        return new ModalWidgetSetupPanel($mw->getContentId(), $mw, $updateComponent, new \picon\BasicModel($item->config), $panel);
    }
    
    public static function getWidgetConfigPanel($id, WidgetElementItem $item)
    {
        $className = $item->setupClass;
        return new $className($id, new \picon\PropertyModel($item, 'config'));
    }
    
    public static function newWidgetConfig(WidgetItem $item)
    {
        $configClassName = $item->configClass;
        $reflection = new ReflectionClass($configClassName);
        return $reflection->newInstance();
    }
}

?>
