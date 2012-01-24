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

use picon\ArrayModel;
use picon\ListView;

/**
 * Description of ToolbarDropLink
 * @author Martin Cassidy
 */
class ToolbarDropLink extends AbstractToolbarItem
{
    private $ids = array();
    public function __construct($id, WidgetCategory $widgetCategory)
    {
        parent::__construct($id);
        $this->add(new \picon\Label('dropLink', new picon\BasicModel($widgetCategory->name)));
        
        $ids = &$this->ids;
        $this->add(new ListView('item', function(picon\ListItem $item) use(&$ids)
        {
            $widget = $item->getModelObject();
            $item->add(new picon\Label('name', new \picon\BasicModel($widget->name)));
            $item->setOutputMarkupId(true);
            $item->add(new \picon\DefaultJQueryUIBehaviour('podiumArrangementButton'));
        }, new ArrayModel($widgetCategory->widgets)));
    }
}

?>
