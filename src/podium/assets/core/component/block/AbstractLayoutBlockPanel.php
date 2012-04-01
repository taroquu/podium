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

use picon\Panel;
use picon\AttributeModifier;
use picon\BasicModel;
use picon\AttributeAppender;

/**
 * Panel representing the visual layout block
 *
 * @author Martin Cassidy
 */
abstract class AbstractLayoutBlockPanel extends Panel
{
    public function __construct($id, AbstractLayoutBlock $block, $includeId = false)
    {
        parent::__construct($id);
        $idField = new picon\MarkupContainer('id');
        $idField->setVisible($includeId);
        $this->add($idField);
        $idField->add(new AttributeModifier('value', new BasicModel($block->id)));
        $this->addClass('layoutBlock');
        $style = '';
        
        foreach($block->getAttributes() as $attribute)
        {
            $style .= sprintf('%s:%d;', $attribute->name, $attribute->value);
        }
        
        $this->add(new AttributeModifier('style', new BasicModel($style), ''));
    }
    
    protected function addClass($cssClass)
    {
        $this->add(new AttributeAppender('class', new BasicModel($cssClass), ' '));
    }
    
}
?>
