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
 * Description of FormWidgetConfigPanel
 * 
 * @author Martin Cassidy
 */
class FormWidgetConfigPanel extends AbstractWidgetSetupPanel
{
    /**
     * @Resource
     */
    private $formService;
    
    private $chosenForm;
    private $forms;
    
    public function __construct($id, $model)
    {
        parent::__construct($id, $model);
        $this->forms = $this->formService->getForms(0, $this->formService->getSize());
        
        $drop = new picon\DropDown('form', $this->forms, new \picon\ChoiceRenderer(function($choice, $index)
        {
            return $choice->id;
        }, function($choice, $index)
        {
            return $choice->name;
        }), new \picon\PropertyModel($this, 'chosenForm'));
        
        $this->add($drop);
        $self = $this;
        $drop->add(new picon\AjaxFormComponentUpdateBehavior('onChange', function (picon\AjaxRequestTarget $target) use ($self)
        {
            $self->setForm();
        }));
    }
    
    protected function onInitialize()
    {
        parent::onInitialize();
        foreach($this->forms as $form)
        {
            if($form->id==$this->getModelObject()->form)
            {
                $this->chosenForm = $form;
            }
        }
    }
    
    public function setForm()
    {
        $this->getModelObject()->form = $this->chosenForm->id;
    }
    
    public function __get($name)
    {
        if($name!='chosenForm')
        {
            return parent::__get($name);
        }
        return $this->$name;
    }
    
    public function __set($name, $value)
    {
        if($name!='chosenForm')
        {
            parent::__set($name, $value);
        }
        $this->$name = $value;
    }
}

?>
