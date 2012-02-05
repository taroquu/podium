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
 * Description of WidgetDao
 * 
 * @author Martin Cassidy
 * @Repository
 */
class WidgetDao extends AbstractDao
{
    public function getWidgetCategories()
    {
        $mapper = new \picon\CallbackRowMapper(function($row)
        {
            return new WidgetCategory($row->id, $row->name);
        });
        return $this->getTemplate()->query("SELECT * FROM widget_category", $mapper);
    }
    
    public function getWidgets($categoryId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
           return new WidgetItem($row->id, $row->name, $row->class, $row->setup, $row->config, $row->target_table);
        });
        
        return $this->getTemplate()->query("SELECT * FROM widgets where category_id = %d", $mapper, array($categoryId));
    }
    
    public function getWidgetItem($widgetId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
           return new WidgetItem($row->id, $row->name, $row->class, $row->setup, $row->config, $row->target_table);
        });
        
        $items = $this->getTemplate()->query("SELECT * FROM widgets where id = %d", $mapper, array($widgetId));
        
        if(count($items)!=1)
        {
            throw new IllegalStateException('Expected only 1 widget item');
        }
        return $items[0];
    }
    
    public function createWidgetConfig($widgetId)
    {
        return $this->getTemplate()->insert("INSERT INTO widget_config (widget_id) VALUES (%d);", array($widgetId));
    }
    
    public function clearWidgetConfigDetail($configId, $widgetTableTarget)
    {
        $this->getTemplate()->update("DELETE FROM %s WHERE config_id = %d;", array($widgetTableTarget, $configId));
    }
    
    public function createWidgetConfigDetail($widgetTableTarget, $configId, $details)
    {
        $fields = array();
        $values = array();
        foreach($details as $field => $value)
        {
            $fields[] = '`'.$field.'`';
            $values[] = is_numeric($value)?$value:"'".$value."'";
        }
        $fields = implode(', ', $fields);
        $values = implode(', ', $values);
        $this->getTemplate()->insert("INSERT INTO %s (config_id, %s) VALUES (%d, %s);", array($widgetTableTarget, $fields, $configId, $values));
    }
    
    public function getWidgetConfig($item, $targetTable, $configId)
    {
        $mapper = new \picon\CallbackRowMapper(function($row) use ($item)
        {
            $config = WidgetFactory::newWidgetConfig($item);
            foreach($row as $field => $value)
            {
                if($field!='id' && $field!='config_id')
                {
                    $config->$field = $value;
                }
            }
            $config->widgetConfigId = $row->config_id;
            return $config;
        });
        $configs = $this->getTemplate()->query("SELECT d.* FROM widget_config AS c INNER JOIN %s AS d ON c.id = d.config_id WHERE c.id = %d", $mapper, array($targetTable, $configId));
        
        if(count($configs)!=1)
        {
            throw new IllegalStateException('Expected only one config');
        }
        return $configs[0];
    }
}

?>
