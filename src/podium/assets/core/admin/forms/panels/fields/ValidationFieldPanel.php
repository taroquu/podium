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
 * Panel for configuring a form field which can have a validator attached to it
 * 
 * @author Martin Cassidy
 */
class ValidationFieldPanel extends RequireableFieldPanel
{
    private $optionWrap;
    public function __construct($id, \picon\ModalWindow $mw, $update, Model $model = null)
    {
        parent::__construct($id, $mw, $update, $model);
        $validator = new picon\DropDown('validator', FieldFactory::getValidators(), new \picon\ChoiceRenderer(function($choice, $index)
        {
            return 'v'.$index;
        }, 
        function($choice, $index)
        {
            return $choice->name;  
        }));
        $this->getForm()->add($validator);
        
        $this->optionWrap = new \picon\MarkupContainer('optionWrap');
        $this->optionWrap->setOutputMarkupId(true);
        $this->getForm()->add($this->optionWrap);
        $self = $this;
        $validator->add(new picon\AjaxFormComponentUpdateBehavior('onChange', function(\picon\AjaxRequestTarget $target) use ($self)
        {
            $field = $self->getModelObject();
            $self->getOptionWrap()->addOrReplace(FieldFactory::getValidatorSetupPanel('options', $field->validator));
            $target->add($self->getOptionWrap());
        }));
    }
    
    public function beforePageRender()
    {
        parent::beforePageRender();
        $this->getOptionWrap()->addOrReplace(FieldFactory::getValidatorSetupPanel('options', $this->getModelObject()->validator));
    }
    
    public function getOptionWrap()
    {
        return $this->optionWrap;
    }
}

?>
