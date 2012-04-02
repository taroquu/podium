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
 * Panel which shows a check box for use by the form widget
 * 
 * @author Martin Cassidy
 */
class CheckBoxPanel extends AbstractFormFieldPanel
{
    public function __construct($id, CheckBoxField $field)
    {
        parent::__construct($id, $field);
        $this->add(new picon\Label('checkLabel', new picon\BasicModel($field->label)));
    }
    
    protected function getFieldComponent()
    {
        return new picon\CheckBox('check');
    }
}

?>
