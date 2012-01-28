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
 * Description of PopulatedForm
 * 
 * @author Martin Cassidy
 */
class PopulatedForm extends Form
{
    private $fields = array();
    private $sumitActionType = 1;
    private $message;
    private $page;
    
    public function addField(FormField $field, $index = null)
    {
        if($index==null)
        {
            array_push($this->fields, $field);
        }
        else
        {
            array_splice($this->fields, $index, count($this->fields), array_merge(array($field), array_slice($this->fields, $index))); 
        }
    }
    
    public function removeField(FormField $field)
    {
        foreach($this->fields as $index => $sfield)
        {
            if($sfield==$field)
            {
                unset($this->fields[$index]);
            }
        }
    }
}

?>
