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
           return new WidgetItem($row->id, $row->name, $row->class, $row->setup, $row->config);
        });
        
        return $this->getTemplate()->query("SELECT * FROM widgets where category_id = %d", $mapper, array($categoryId));
    }
    
    public function getWidgetItem($widgetId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
           return new WidgetItem($row->id, $row->name, $row->class, $row->setup, $row->config);
        });
        
        $items = $this->getTemplate()->query("SELECT * FROM widgets where id = %d", $mapper, array($widgetId));
        
        if(count($items)!=1)
        {
            throw new IllegalStateException('Expected only 1 widget item');
        }
        return $items[0];
    }
}

?>
