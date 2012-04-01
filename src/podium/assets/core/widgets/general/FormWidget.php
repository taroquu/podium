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
 * 
 * @author Martin Cassidy
 */
class FormWidget extends Widget
{
    /**
     * @Resource
     */
    private $formService;
    
    public function __construct($id, WidgetItem $item)
    {
        parent::__construct($id, $item);
        $form = new picon\Form('form');
        $this->add($form);
        
        $fields = new picon\RepeatingView('field');
        $form->add($fields);
        
        if($item->config->form!=null)
        {
            $formFields = $this->formService->getFields($item->config->form);
            
            foreach($formFields as $field)
            {
                $element = new \picon\MarkupContainer($fields->getNextChildId());
                $fields->add($element);
                $label = new picon\Label('label', new picon\BasicModel($field->name));
                $element->add($label);
                
                $fieldElement = null;
                
                if($field instanceof DropDownField)
                {
                    $fieldElement = new DropDownPanel('element', $field->options);
                }
                else if($field instanceof TextField)
                {
                    $fieldElement = new TextFieldPanel('element');
                }
                else if($field instanceof TextAreaField)
                {
                    $fieldElement = new TextAreaPanel('element');
                }
                else if($field instanceof CheckBoxField)
                {
                    $fieldElement = new CheckBoxPanel('element', $field->label);
                }
                else if($field instanceof CheckGroupField)
                {
                    $fieldElement = new \picon\CheckChoice('element', $field->options);
                }
                else if($field instanceof RadioField)
                {
                    $fieldElement = new \picon\RadioChoice('element', $field->options);
                }
                else if($field instanceof ButtonField)
                {
                    $fieldElement = new ButtonPanel('element', $field->type, $field->text);
                    $label->setVisible(false);
                }

                $element->add($fieldElement);
            }
        }
    }
}

?>
