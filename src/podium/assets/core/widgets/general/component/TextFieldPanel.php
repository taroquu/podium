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
 * Panel which shows a text field for use by the form widgetDescription of TextAreaPanel
 * 
 * @author Martin Cassidy
 */
class TextFieldPanel extends AbstractFormFieldPanel
{
    public function __construct($id, TextField $field)
    {
        parent::__construct($id, $field);
    }
    
    protected function getFieldComponent()
    {
        $field = new picon\TextField('textField');
        
        if($this->getField()->validator!=null)
        {
            $field->add($this->validatorFactory($this->getField()->validator));
        }
        
        return $field;
    }
    
    private function validatorFactory($validator)
    {
        switch($validator->name)
        {
            case 'Minimum Text Validator':
                return new picon\MinimumLengthValidator($validator->min);
            break;
            case 'Minimum Number Validator':
                return new \picon\MinimumValidator($validator->min);
            break;
            case 'Maximum Text Validator':
                return new \picon\MaximumLengthValidator($validator->max);
            break;
            case 'Maximum Number Validator':
                return new picon\MaximumValidator($validator->max);
            break;
            case 'Range Text Validator':
                return new picon\RangeLengthValidator($validator->min, $validator->max);
            break;
            case 'Range Number Validator':
                return new picon\RangeValidator($validator->max);
            break;
            case 'Pattern Validator':
                return new picon\PatternValidator($validator->value);
            break;
            case 'Email Validator':
                return new \picon\EmailAddressValidator();
            break;
            default:
                throw new InvalidArgumentException(sprintf('Validator %s does not exist', $validator->name));
        }
    }
}

?>
