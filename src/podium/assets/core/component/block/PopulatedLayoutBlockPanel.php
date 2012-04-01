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
 * A layout block panel populated with widgets
 * 
 * @author Martin Cassidy
 */
class PopulatedLayoutBlockPanel extends LayoutBlockPanel
{
    public function __construct($id, PopulatedLayoutBlock $block, $cssClass = '', $includeId = false, $page = null)
    {
        parent::__construct($id, $block, $cssClass, $includeId);
        $widgets = new picon\RepeatingView('widget');
        $this->add($widgets);
        foreach($block->widgets as $widgetItem)
        {
            $widgets->add($this->getWidget($widgetItem, $widgets->getNextChildId(), $page));
        }
    }
    
    protected function getWidget(WidgetItem $item, $id, $page)
    {
        return WidgetFactory::getWidget($id, $item, $page);
    }
}

?>
