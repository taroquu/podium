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
 * Panel for configuring any form field
 * 
 * @author Martin Cassidy
 */
abstract class AbstractFieldSetupPanel extends picon\Panel
{
    private $field;
    private $form;
    
    public function __construct($id, \picon\ModalWindow $mw, $update, Model $model = null)
    {
        parent::__construct($id, $model);
        $feedback = new PodiumFeedbackPanel('feedback');
        $feedback->setOutputMarkupId(true);
        $this->add($feedback);
        $this->field = $model->getModelObject();
        $this->form = new picon\Form('form', new \picon\CompoundPropertyModel($this, 'field'));
        $this->add($this->form);
        
        $this->form->add(new picon\RequiredTextField('name'));
        
        $this->form->add(new picon\AjaxButton('save', function(picon\AjaxRequestTarget $target) use($mw, $update)
        {
            $target->add($update);
            $mw->hide($target);
        }, function(picon\AjaxRequestTarget $target) use ($feedback)
        {
            $target->add($feedback);
        }));
    }
    
    public function getForm()
    {
        return $this->form;
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
