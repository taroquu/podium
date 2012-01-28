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
 * Description of FieldFactory
 * 
 * @author Martin Cassidy
 */
class FieldFactory
{
    public static function getFieldNames()
    {
        $fields = array();
        $fields[] = new TextField('Text Box');
        $fields[] = new TextAreaField('Text Area');
        $fields[] = new DropDownField('Drop Down');
        $fields[] = new RadioField('Radio Buttons');
        $fields[] = new CheckBoxField('Check Box');
        $fields[] = new CheckGroupField('Check Box Group');
        $fields[] = new ButtonField('Button');
        return $fields;
    }
    
    public static function mapField($row)
    {
        switch($row->type)
        {
            case 'TextField':
            return new TextField($row->name, $row->required==1, array(), $row->id);
            break;
            case 'TextAreaField':
            return new TextAreaField($row->name, $row->required==1, $row->id);
            break;
            case 'DropDownField':
            return new DropDownField($row->name, $row->required==1, array(), $row->id);
            break;
            case 'RadioField':
            return new RadioField($row->name, $row->required==1, array(), $row->id);
            break;
            case 'CheckBoxField':
            return new CheckBoxField($row->name, $row->required==1, $row->label, $row->id);
            break;
            case 'CheckGroupField':
            return new CheckGroupField($row->name, $row->required==1, array(), $row->id);
            break;
            case 'ButtonField':
            return new ButtonField($row->name, $row->function, $row->label, $row->id);
            break;
        }
    }
    
    public static function getSetupPanel(FormField $field, \picon\ModalWindow $mw, $fields)
    {
        if($field instanceof TextField)
        {
            return new ValidationFieldPanel($mw->getContentId(), $mw, $fields, new \picon\BasicModel($field));
        }
        else if($field instanceof TextAreaField)
        {
            return new RequireableFieldPanel($mw->getContentId(), $mw, $fields, new \picon\BasicModel($field));
        }
        else if($field instanceof CheckBoxField)
        {
            return new LabeledRequiredFieldPanel($mw->getContentId(), $mw, $fields, new \picon\BasicModel($field));
        }
        else if($field instanceof DropDownField || $field instanceof CheckGroupField || $field instanceof RadioField)
        {
            return new OptionsFieldPanel($mw->getContentId(), $mw, $fields, new \picon\BasicModel($field));
        }
        else if($field instanceof ButtonField)
        {
            return new ButtonFieldPanel($mw->getContentId(), $mw, $fields, new \picon\BasicModel($field));
        }
    }
}

?>
