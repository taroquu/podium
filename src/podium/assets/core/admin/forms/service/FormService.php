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
        $populated->fields = $this->getFields($form->id);
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
                    $this->deleteField($oldField);
                }
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
            
            if($field instanceof TextField)
            {
                $validator = $this->getValidator($field);
                $this->deleteValidator($validator);
                
                if($field->validator!=null)
                {
                    $this->createValidator($field->id, $field->validator);
                }
            }
        }
    }
    
    public function deleteValidator($validator)
    {
        $this->formDao->deleteValidatorOptions($validator->id);
        $this->formDao->deleteValidator($validator->id);
    }
    
    public function getFields($formId)
    {
        $fields = $this->formDao->getFormFields($formId);
        
        foreach($fields as $field)
        {
            if($field instanceof AbstractOptionField)
            {
                $field->options = $this->formDao->getOptions($field->id);
            }
            
            if($field instanceof TextField)
            {
                $field->validator = $this->getValidator($field);
            }
        }
        return $fields;
    }
    
    public function deleteForm(Form $form)
    {
        $fields = $this->getFields($form->id);
        
        foreach($fields as $field)
        {
            $this->deleteField($field);
        }
        $this->formDao->deleteForm($form->id);
    }
    
    public function createValidator($fieldId, AbstractValidator $validator)
    {
        $validatorId = $this->formDao->addValidator($fieldId, $validator);
        
        if($validator instanceof MinValidator)
        {
            $this->formDao->addValidatorOption($validatorId, 'min', $validator->min);
        }
        else if($validator instanceof MaxValidator)
        {
            $this->formDao->addValidatorOption($validatorId, 'max', $validator->max);
        }
        else if($validator instanceof RangeValidator)
        {
            $this->formDao->addValidatorOption($validatorId, 'min', $validator->min);
            $this->formDao->addValidatorOption($validatorId, 'max', $validator->max);
        }
        else if($validator instanceof SingleValueValidator)
        {
            $this->formDao->addValidatorOption($validatorId, 'value', $validator->value);
        }
    }
    
    private function getValidator(TextField $field)
    {
        //@todo add support for multiple validators
        $validator = $this->formDao->getValidators($field->id);
        $validator = $validator[0];
        
        if($validator instanceof MinValidator)
        {
            $validator->min = $this->formDao->getValidatorOptions($validator->id, 'min');
        }
        else if($validator instanceof MaxValidator)
        {
            $validator->max = $this->formDao->getValidatorOptions($validator->id, 'max');
        }
        else if($validator instanceof RangeValidator)
        {
            $validator->min = $this->formDao->getValidatorOptions($validator->id, 'min');
            $validator->max = $this->formDao->getValidatorOptions($validator->id, 'max');
        }
        else if($validator instanceof SingleValueValidator)
        {
            $validator->value = $this->formDao->getValidatorOptions($validator->id, 'value');
        }
        
        return $validator;
    }
    
    public function deleteField($field)
    {
        if($field instanceof TextField)
        {
            $validator = $this->getValidator($field);
            $this->deleteValidator($validator);
        }
        $this->formDao->deleteOptions($field->id);
        $this->formDao->deleteField($field->id);
    }
    
    public function inUse($formId)
    {
        return $this->formDao->getFormUseageCount($formId)>0;
    }
}

?>
