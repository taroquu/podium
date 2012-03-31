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
 * Description of FormDao
 * 
 * @author Martin Cassidy
 * @Repository
 */
class FormDao extends AbstractDao
{
    public function getRecords($start, $count)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return new Form($row->id, $row->name);
        });
        return $this->getTemplate()->query("SELECT * FROM form LIMIT %d, %d", $mapper, array($start, $count));
    }
    
    public function getSize()
    {
        return $this->getTemplate()->queryForInt("SELECT count(*) FROM form;");
    }
    
    public function getForm($formId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            $form = new PopulatedForm($row->id, $row->name);
            $form->sumitActionType = $row->action;
            
            if($form->sumitActionType==1)
            {
                $form->message = $row->action_value;
            }
            else
            {
                $form->page = $row->action_value;
            }
            return $form;
        });
        
        $forms = $this->getTemplate()->query("SELECT * FROM form WHERE id = %d", $mapper, array($formId));
        
        if(count($forms)!=1)
        {
            throw new IllegalStateException('Expected only one form');
        }
        return $forms[0];
    }
    
    public function getFormFields($formId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return FieldFactory::mapField($row);
        });
        return $this->getTemplate()->query("SELECT * FROM form_elements WHERE form_id = %d ORDER BY `index` ASC", $mapper, array($formId));
    }
    
    public function create(PopulatedForm $form)
    {
        $action = $form->sumitActionType==1?$form->message:$form->page;
        return $this->getTemplate()->insert("INSERT INTO form (name, action, action_value) VALUES ('%s', '%s','%s' )", array($form->name, $form->sumitActionType, $action));
    }
    
    public function update(PopulatedForm $form)
    {
        $action = $form->sumitActionType==1?$form->message:$form->page;
        $this->getTemplate()->update("UPDATE form SET name = '%s', action = '%s', action_value = '%s' WHERE id = %d;", array($form->name, $form->sumitActionType, $action, $form->id));
    }
    
    public function createField(AbstractFormField $field, $formId, $index)
    {
        $label = $field instanceof CheckBoxField?$field->label:'';
        $label = $field instanceof ButtonField?$field->text:$label;
        $function = $field instanceof ButtonField?$field->type:'';
        $required = $field instanceof AbstractRequirableFormField?($field->required?'true':'false'):'false';
        return $this->getTemplate()->insert("INSERT INTO form_elements (form_id, type, name, `index`, required, `label`, `function`) VALUES (%d, '%s', '%s', %d, %s, '%s', '%s')", array($formId, get_class($field), $field->name, $index, $required, $label, $function));
    }
    
    public function updateField(AbstractFormField $field, $index)
    {
        $label = $field instanceof CheckBoxField?$field->label:'';
        $label = $field instanceof ButtonField?$field->text:$label;
        $function = $field instanceof ButtonField?$field->type:'';
        $required = $field instanceof AbstractRequirableFormField?($field->required?'true':'false'):'false';
        $this->getTemplate()->update("UPDATE form_elements SET name = '%s', `index` = %d, required = %s, `label` = '%s', `function` = '%s' WHERE id = %d;", array($field->name, $index, $required, $label, $function, $field->id));
    }
    
    public function deleteForm($formId)
    {
        $this->getTemplate()->update("DELETE FROM form WHERE id = %d", array($formId));
    }
    
    public function deleteField($fieldId)
    {
        $this->getTemplate()->update("DELETE FROM form_elements WHERE id = %d", array($fieldId));
    }
    
    public function deleteOptions($fieldId)
    {
        $this->getTemplate()->update("DELETE FROM form_element_options WHERE form_element_id = %d", array($fieldId));
    }
    
    public function createOption($fieldId, $option)
    {
        return $this->getTemplate()->insert("INSERT INTO form_element_options (form_element_id, `option`) VALUES (%d, '%s')", array($fieldId, $option));
    }
    
    public function getOptions($fieldId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return $row->option;
        });
        return $this->getTemplate()->query("SELECT * FROM form_element_options WHERE form_element_id = %d", $mapper, array($fieldId));
    }
    
    public function deleteValidator($validatorId)
    {
        $this->getTemplate()->update("DELETE FROM form_validation WHERE id = %d", array($validatorId));
    }
    
    public function addValidator($fieldId, AbstractValidator $validator)
    {
        return $this->getTemplate()->insert("INSERT INTO form_validation (form_element_id, `type`) VALUES (%d, '%s')", array($fieldId, $validator->name));
    }
    
    public function addValidatorOption($validatorId, $name, $value)
    {
        return $this->getTemplate()->insert("INSERT INTO form_validation_options (form_validation_id, `name`, `value`) VALUES (%d, '%s', '%s')", array($validatorId, $name, $value));
    }
    
    public function deleteValidatorOptions($validatorId)
    {
        $this->getTemplate()->update("DELETE FROM form_validation_options WHERE form_validation_id = %d;", array($validatorId));
    }
    
    public function getValidators($fieldId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return FieldFactory::mapValidator($row);
        });
        return $this->getTemplate()->query("SELECT * FROM form_validation WHERE form_element_id = %d", $mapper, array($fieldId));
    }
    
    /**
     * @todo Use queryForString when it exists
     * @param type $validatorId
     * @param type $name
     * @return type 
     */
    public function getValidatorOptions($validatorId, $name)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return $row->value;
        });
        $options = $this->getTemplate()->query("SELECT * FROM form_validation_options WHERE form_validation_id = %d AND `name` = '%s'", $mapper, array($validatorId, $name));
        
        if(count($options)!=1)
        {
            throw new IllegalStateException('Expected only one option');
        }
        $option = $options[0];
        
        if(is_numeric($option))
        {
            settype($option, \picon\Component::TYPE_INT);
        }
        
        return $option;
    }
    
    public function getFormUseageCount($formId)
    {
        return $this->getTemplate()->queryForInt("SELECT count(*) FROM form WHERE id = %d AND id IN (SELECT form FROM widget_config_form)", array($formId));
    }
}

?>
