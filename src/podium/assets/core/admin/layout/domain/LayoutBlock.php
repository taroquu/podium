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

use picon\ComonDomainBase;
use picon\Args;

/**
 * Domain object for a layou block of which a layout is composed
 *
 * @author Martin Cassidy
 */
class LayoutBlock extends ComonDomainBase
{
    private $id;
    private $type;
    private $attributes = array();
    private $nestedBlocks = array();
    
    /**
     *
     * @todo this is only used for mapping at the moment the value becomes
     * stale if updated client side
     */
    private $parent;
    
    public function __construct($type)
    {
        $this->type = $type;
    }
    
    public function addAttribute(LayoutBlockAttribute $attribute)
    {
        array_push($this->attributes, $attribute);
    }
    
    public function setAttributes($attributes)
    {
        Args::isArray($attributes, 'attributes');
        $this->attributes = $attributes;
    }
    
    public function getAttributes()
    {
        return $this->attributes;
    }
    
    public function addNestedBlock(LayoutBlock $nested)
    {
        array_push($this->nestedBlocks, $nested);
    }
    
    public function getNestedBlocks()
    {
        return $this->nestedBlocks;
    }
}

?>
