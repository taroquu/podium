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
 * Widget panel for forms
 * @todo update the form to use a compound model
 * @author Martin Cassidy
 */
class FormWidget extends Widget
{
    /**
     * @Resource
     */
    private $formService;
    
    /**
     * @Resource
     */
    private $submissionService;
    
    private $formFields;
    
    public function __construct($id, WidgetItem $item)
    {
        parent::__construct($id, $item);
        
        $fullForm = $this->formService->getForm($item->config->form);
        
        $this->formFields = array();
        $form = new picon\Form('form');
        $this->add($form);
        
        $this->add(new \picon\FeedbackPanel('feedback'));
        
        $fields = new picon\RepeatingView('field');
        $form->add($fields);
        
        $self = $this;
        $onSubmit = function() use ($self, $form, $fullForm)
        {
            $values = array();
            foreach($self->getFormFields() as $field)
            {
                $values[$field->getField()->name] = $field->getInternalFormField()->getConvertedInput();
            }
            $self->getSubmissionService()->submit($fullForm, $values);
            
            if($fullForm->sumitActionType==1)
            {
                $self->success($fullForm->message);
                $form->setVisible(false);
            }
            else
            {
                $self->setPage(new FrontPage($fullForm->page->id));
            }
        };
        
        $onError = function()
        {
            //nothing
        };
        
        if($item->config->form!=null)
        {
            $formFields = $fullForm->fields;
            
            foreach($formFields as $field)
            {
                $element = new \picon\MarkupContainer($fields->getNextChildId());
                $fields->add($element);
                $label = new picon\Label('label', new picon\BasicModel($field->name));
                $element->add($label);
                
                $fieldElement = null;
                
                //@todo turn this into a factory
                if($field instanceof DropDownField)
                {
                    $fieldElement = new DropDownPanel('element', $field);
                }
                else if($field instanceof TextField)
                {
                    $fieldElement = new TextFieldPanel('element', $field);
                }
                else if($field instanceof TextAreaField)
                {
                    $fieldElement = new TextAreaPanel('element', $field);
                }
                else if($field instanceof CheckBoxField)
                {
                    $fieldElement = new CheckBoxPanel('element', $field);
                }
                else if($field instanceof CheckGroupField)
                {
                    $fieldElement = new CheckChoicePanel('element', $field);
                }
                else if($field instanceof RadioField)
                {
                    $fieldElement = new RadioChoicePanel('element', $field);
                }
                else if($field instanceof ButtonField)
                {
                    $fieldElement = new ButtonPanel('element', $field, $onSubmit, $onError);
                    $label->setVisible(false);
                }
                $this->formFields[] = $fieldElement;
                $element->add($fieldElement);
            }
        }
    }
    
    public function getSubmissionService()
    {
        return $this->submissionService;
    }
    
    public function getFormFields()
    {
        return $this->formFields;
    }
}

?>
