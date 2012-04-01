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
 * Panel for configuring a form field which has options
 * 
 * @author Martin Cassidy
 */
class OptionsFieldPanel extends RequireableFieldPanel
{
    private $newOption;
    private $optionList;
    
    public function __construct($id, \picon\ModalWindow $mw, $update, Model $model = null)
    {
        parent::__construct($id, $mw, $update, $model);
        
        $form = new picon\Form('opForm');
        $this->getForm()->add($form);
        $options = new \picon\MarkupContainer('options');
        $options->setOutputMarkupId(true);
        $form->add($options);
        $self = $this;
        $this->optionList = new picon\ListView('option', function(\picon\ListItem $item) use($model, $self, $options)
        {
            $item->add(new picon\Label('value', $item->getModel()));
            $item->add(new \picon\AjaxLink('delete', function(picon\AjaxRequestTarget $target) use ($item, $options, $model, $self)
            {
                $target->add($options);
                $model->getModelObject()->remove($item->getModelObject());
                $self->optionList->setModel(new \picon\ArrayModel($model->getModelObject()->options));
            }));
        }, new \picon\ArrayModel($model->getModelObject()->options));
        $options->add($this->optionList);
        
        $feedback = new PodiumFeedbackPanel('feedback');
        $options->add($feedback);
        $options->add(new picon\RequiredTextField('newOption', new picon\PropertyModel($this, 'newOption')));
        
        $options->add(new picon\AjaxButton('add', function(picon\AjaxRequestTarget $target) use ($self, $options, $model)
        {
            $target->add($options);
            $model->getModelObject()->addOption($self->newOption);
            $self->newOption = '';
            $self->optionList->setModel(new \picon\ArrayModel($model->getModelObject()->options));
        },
        function(picon\AjaxRequestTarget $target) use ($feedback)
        {
            $target->add($feedback);
        }));
    }
    
    /**
     * @todo need to do something about the get and set, similar to comon domain base
     * @param type $name
     * @return type 
     */
   public function __get($name)
    {
        if($name=='newOption' || $name=='optionList')
        {
            return $this->$name;
        }
        else
        {
            return parent::__get($name);
        }
    }
    
    public function __set($name, $value)
    {
        if($name=='newOption' || $name=='optionList')
        {
            $this->$name = $value;
        }
        else
        {
            parent::__set($name, $value);
        }
    }
}

?>
