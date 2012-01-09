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
 * Description of AbstractLayoutBlockPanel
 *
 * @author Martin Cassidy
 */
abstract class AbstractLayoutBlockPanel extends Panel
{
    public function __construct($id, AbstractLayoutBlock $block)
    {
        parent::__construct($id);
        $this->add(new AttributeModifier('class', new BasicModel($this->getClass())));
        
        $style = '';
        $properties = array('width', 'height');
        foreach($properties as $property)
        {
            if($block->$property!=null)
            {
                $style .= sprintf('%s:%dpx;', $property, $block->$property);
            }
        }
        
        $this->add(new AttributeAppender('style', new BasicModel($style), ''));
    }
    
    public abstract function getClass();
}

?>
