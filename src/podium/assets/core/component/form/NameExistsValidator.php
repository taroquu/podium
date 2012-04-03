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
 * Validates that the value of a string text field is not already in use
 * 
 * @author Martin Cassidy
 */
class NameExistsValidator extends picon\StringValidator
{
    private $nameCallback;
    
    public function __construct($nameCallback)
    {
        picon\Args::callBackArgs($nameCallback, 1, 'nameCallback');
        $this->nameCallback = new \picon\SerializableClosure($nameCallback);
    }
    
    public function validateValue(picon\Validatable $validateable)
    {
        parent::validateValue($validateable);
        $callable = $this->nameCallback;
        if($callable($validateable->getValue()))
        {
            return new picon\ValidationResponse($this->getKeyName(get_called_class()));
        }
    }
}

?>
