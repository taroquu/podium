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
 *
 * @author Martin Cassidy
 */
interface IWidgetService
{    
    /**
     * Get the widget categories
     * @return array
     */
    function getWidgetCategories();
    
    /**
     * Get a widget by its id
     * @param int $widgetId
     * @return WidgetItem
     */
    function getWidget($widgetId);

    /**
     * Create a configuration for the widget item (element), if it does exist
     * already, update otherwise
     * @param ConfigurableWidgetItem $item
     * @return type 
     */
    function createOrUpdateWidgetConfig(ConfigurableWidgetItem $item);
    
    /**
     * Get the config for a widget
     * @param WidgetItem $item
     * @param int $configId
     * @return WidgetConfig
     */
    function getWidgetConfig(WidgetItem $item, $configId);
    
    /**
     * Delete the config for a widget item (element)
     * @param WidgetItem $item
     * @param int $configId 
     */
    function deleteWidgetConfig(WidgetItem $item, $configId);
}

?>
