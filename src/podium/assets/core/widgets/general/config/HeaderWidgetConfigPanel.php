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
 * Description of HeaderWidgetConfigPanel
 * 
 * @author Martin Cassidy
 */
class HeaderWidgetConfigPanel extends AbstractWidgetSetupPanel
{
    public function __construct($id, $model)
    {
        parent::__construct($id, $model);
        
        $this->add(new picon\RequiredTextField('text'));
        $types = array('Heading 1', 'Heading 2', 'Heading 3', 'Heading 4', 'Heading 5', 'Heading 6');
        $drop = new picon\DropDown('type', $types);
        $drop->setRequired(true);
        $this->add($drop);
    }
}

?>
