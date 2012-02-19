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

use picon\Panel;
use picon\RepeatingView;
use picon\AttributeAppender;
use picon\BasicModel;

/**
 * Description of ColumnBlockPanel
 *
 * @author Martin Cassidy
 */
class ColumnBlockPanel extends LayoutBlockPanel
{
    public function __construct($id, ColumnBlock $block, $cssClass, $innerClass, $includeId = false)
    {
        parent::__construct($id, $block, $cssClass, $includeId);
        $this->addClass('columnBlock');
        $view = new RepeatingView('columns');
        $this->add($view);
        
        foreach($block->getNestedBlocks() as $column)
        {
            $view->add($this->newColumnElement($view->getNextChildId(), $column, $innerClass, $includeId));
        }
    }
    
    protected function newColumnElement($id, $column, $innerClass, $includeId)
    {
        return new LayoutBlockPanel($id, $column, $innerClass, $includeId);
    }
}

?>
