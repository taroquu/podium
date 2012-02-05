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
 * Description of SelectContentTypePanel
 * 
 * @author Martin Cassidy
 */
class SelectContentTypePanel extends \picon\Panel
{
    /**
     * @Resource
     */
    private $contentTypeService;
    
    public function __construct($id, $type)
    {
        parent::__construct($id);
        $types = $this->contentTypeService->getContentTypeByType($type);
        $contentTypes = new picon\DropDown('contentType', $types, new \picon\ChoiceRenderer(function($choice, $index)
        {
            return 'v'.$index;
        },
        function($choice, $index)
        {
            return $choice->name;
        }));
        $contentTypes->setRequired(true);
        $this->add($contentTypes);
        
        $this->add(new picon\DropDown('arrangement', array()));
    }
}

?>
