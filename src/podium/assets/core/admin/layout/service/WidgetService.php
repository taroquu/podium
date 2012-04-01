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
 * Description of WidgetService
 * 
 * @author Martin Cassidy
 * @Service
 */
class WidgetService implements IWidgetService
{
    /**
     * @Resource
     */
    private $widgetDao;

    public function getWidgetCategories()
    {
        $categories = $this->widgetDao->getWidgetCategories();
        
        foreach($categories as $category)
        {
            $category->widgets = $this->widgetDao->getWidgets($category->id);
        }
        
        return $categories;
    }

    public function getWidget($widgetId)
    {
        return $this->widgetDao->getWidgetItem($widgetId);
    }

    public function createOrUpdateWidgetConfig(ConfigurableWidgetItem $item)
    {
        $config = $item->config;
        if($config->widgetConfigId==null)
        {
            $config->widgetConfigId = $this->widgetDao->createWidgetConfig($item->id);
        }
        
        $this->widgetDao->clearWidgetConfigDetail($config->widgetConfigId, $item->widgetTargetTable);
        
        $reflection = new ReflectionClass($config);
        $details = array();
        foreach($reflection->getProperties() as $property)
        {
            $property->setAccessible(true);
            $details[$property->getName()] = $property->getValue($config);
        }
        $this->widgetDao->createWidgetConfigDetail($item->widgetTargetTable, $config->widgetConfigId, $details);
        return $config;
    }

    public function getWidgetConfig(WidgetItem $item, $configId)
    {
        return $this->widgetDao->getWidgetConfig($item, $item->widgetTargetTable, $configId);
    }

    public function deleteWidgetConfig(WidgetItem $item, $configId)
    {
        $this->widgetDao->clearWidgetConfigDetail($configId, $item->widgetTargetTable);
        $this->widgetDao->deleteWidgetConfig($configId);
    }
}

?>
