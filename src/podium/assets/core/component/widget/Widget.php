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

/**
 * Description of Widget
 * 
 * @author Martin Cassidy
 */
abstract class Widget extends Panel
{
    private $editable = false;
    private $item;
    /**
     * @todo take in both the widget item object and the widget config as constructor arguments
     * @param type $id
     * @param Model $model
     * @param type $editable 
     */
    public function __construct($id, WidgetItem $item, Model $model = null, $editable = false)
    {
        parent::__construct($id, $model);
        $this->item = $item;
        $this->editable = $editable;
    }
    
    protected function onComponentTagBody(ComponentTag $tag)
    {
        if($this->editable)
        {
            $this->getResponse()->write('<input type="hidden" value="'.$this->item->elementId.'" />');
        }
        parent::onComponentTagBody($tag);
    }
}

?>
