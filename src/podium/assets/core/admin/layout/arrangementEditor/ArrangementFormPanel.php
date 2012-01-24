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
 * Description of ArrangementFormPanel
 * 
 * @author Martin Cassidy
 */
class ArrangementFormPanel extends picon\Panel
{
    /**
     * @Resource
     */
    private $layoutService;
    
    private $arrangement;
    
    public function __construct($id, Arrangement $arrangement)
    {
        parent::__construct($id);
        $this->arrangement = $arrangement;
        $form = new picon\Form('form', new picon\CompoundPropertyModel($this, 'arrangement'));
        $this->add($form);
        $form->add(new \picon\TextField('name'));
        $form->add(new picon\DropDown('layout', $this->layoutService->getLayouts(0, $this->layoutService->getLayoutsSize()), new picon\ChoiceRenderer(null, function($item, $index)
        {
            return $item->name;
        })));
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}

?>
