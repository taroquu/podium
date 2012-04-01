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
 * Page for creating or editing a form
 * 
 * @author Martin Cassidy
 */
class CreateEditFormPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $formService;
    
    private $form;
    
    public function __construct(PopulatedFormForm $form)
    {
        parent::__construct();
        
        $this->add(new PodiumFeedbackPanel('feedback'));
        
        if($form==null)
        {
            $form = new PopulatedForm();
        }
        
        $this->form = $form;
        
        $pageForm = new picon\Form('form', new \picon\CompoundPropertyModel($this, 'form'));
        $this->add($pageForm);
        
        $tabs = array();
        $tabs[] = new picon\Tab('Form Setup', function($id) use($form)
        {
            return new SetupPanel($id, $form);
        });
        $tabs[] = new picon\Tab('Submit Options', function($id)
        {
            return new OptionsPanel($id);
        });
        
        $tabCollection = new \picon\TabCollection($tabs);
        
        $pageForm->add(new \picon\StaticTabPanel('tabs', $tabCollection));
        
        $self = $this;
        $pageForm->add(new picon\Button('save', function() use ($self, $pageForm)
        {
            $buttoncount = 0;
            $fieldcount = 0;
            //@todo this logic is a mess
            foreach($self->form->fields as $field)
            {
                if($field instanceof ButtonField)
                {
                    if($field->type=='Submit')
                    {
                        $buttoncount++;
                    }
                }
                else
                {
                    $fieldcount++;
                }
            }
            if($fieldcount==0 || $buttoncount==0)
            {
                $self->error('A form must have at least one field and at least one submit button');
                return;
            }
            $self->formService->createOrUpdate($self->form);
            $self->setPage(FormPage::getIdentifier());
        }));
        
        $pageForm->add(new ButtonLink('cancel', function() use($self)
        {
            $self->setPage(FormPage::getIdentifier());
        }, 'grey'));
    }
    
    protected function getTitle()
    {
        return $this->form->id==null?'Create Form':'Edit Form';
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
