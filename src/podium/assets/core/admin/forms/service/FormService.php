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
 * Description of FormService
 * 
 * @author Martin Cassidy
 * @Service
 */
class FormService
{
    /**
     * @Resource
     */
    private $formDao;
    
    public function getRecords($start, $count)
    {
        return $this->formDao->getRecords($start, $count);
    }
    
    public function getSize()
    {
        return $this->formDao->getSize();
    }
    
    public function getPopulatedForm(Form $form)
    {
        $populated = $this->formDao->getForm($form->id);
        $populated->fields = $this->formDao->getFormFields($form->id);
        
        foreach($populated->fields as $field)
        {
            if($field instanceof AbstractOptionField)
            {
                $field->options = $this->formDao->getOptions($field->id);
            }
        }
        return $populated;
    }
    
    public function createOrUpdate(PopulatedForm $form)
    {
        $formId = null;
        if($form->id==null)
        {
            $formId = $this->formDao->create($form);
        }
        else
        {
            $formId = $form->id;
            $this->formDao->update($form);
        }
        
        $oldForm = $this->getPopulatedForm($form);
        
        foreach($oldForm->fields as $oldField)
        {
            $found = false;
            foreach($form->fields as $field)
            {
                if($field->id==$oldField->id)
                {
                    $found = true;
                }
            }
            if(!$found)
            {
                $this->formDao->deleteField($oldField->id);
            }
        }
        
        foreach($form->fields as $index => $field)
        {
            if($field->id==null)
            {
                $field->id = $this->formDao->createField($field, $formId, $index);
            }
            else
            {
                $this->formDao->updateField($field, $index);
            }
            
            if($field instanceof AbstractOptionField)
            {
                $this->formDao->deleteOptions($field->id);
                foreach($field->options as $option)
                {
                    $this->formDao->createOption($field->id, $option);
                }
            }
        }
    }
    
    public function deleteForm(Form $form)
    {
        $this->formDao->deleteForm($form->id);
    }
}

?>