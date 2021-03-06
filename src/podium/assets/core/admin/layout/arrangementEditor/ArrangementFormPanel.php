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
 * Panel for the initial step of creating an arrangement
 * 
 * @author Martin Cassidy
 */
class ArrangementFormPanel extends picon\Panel
{
    /**
     * @Resource
     */
    private $arrangementService;
    
    /**
     * @Resource
     */
    private $layoutService;
    
    private $arrangement;
    
    public function __construct($id, Model $model, $onSave)
    {
        parent::__construct($id, $model);
        $this->arrangement = $model->getModelObject();
        $this->add(new PodiumFeedbackPanel('feedback'));
        $form = new picon\Form('form', new picon\CompoundPropertyModel($this, 'arrangement'));
        $this->add($form);
        $name = new \picon\RequiredTextField('name');
        $self = $this;
        //This will need altering when names are editable
        $name->add(new NameExistsValidator(function($name) use($self)
        {
            return $self->getArrangementService()->checkNameExists($name);
        }));
        $form->add($name);
        
        $layoutDrop = new picon\DropDown('layout', $this->layoutService->getLayouts(0, $this->layoutService->getLayoutsSize()), new picon\ChoiceRenderer(function($item, $index)
        {
            return $item->id;
        }, function($item, $index)
        {
            return $item->name;
        }));
        $layoutDrop->setRequired(true);
        $form->add($layoutDrop);
        
        $form->add(new \picon\Button('submit', function() use ($self, $onSave)
        {
            $onSave();
        }));
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    
    public function getArrangementService()
    {
        return $this->arrangementService;
    }
}

?>
