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
 * Panel which shows a button for use by the form widget
 * 
 * @author Martin Cassidy
 */
class ButtonPanel extends AbstractFormFieldPanel
{
    private $submit;
    private $error;
    
    public function __construct($id, ButtonField $field, $submit, $error)
    {
        parent::__construct($id, $field);
        $this->submit = $submit;
        $this->error = $error;
    }
    
    protected function getFieldComponent()
    {
        $self = $this;
        $button = new \picon\Button('button', function() use($self)
        {
            $callable = $self->submit;
            $callable();
        }, function () use($self)
        {
            $callable = $self->error;
            $callable();
        });
        $button->add(new picon\AttributeModifier('value', new picon\BasicModel($this->getField()->text)));
        $button->add(new picon\AttributeModifier('type', new picon\BasicModel($this->getField()->type)));
        return $button;
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
}

?>
