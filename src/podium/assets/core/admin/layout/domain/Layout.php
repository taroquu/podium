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

/**
 * Domain object for a layout
 *
 * @author Martin Cassidy
 */
class Layout extends ComonDomainBase
{
    const ROW_BLOCK = 1;
    const COLUMN_BLOCK = 2;
    const COLUMN_ELEMENT = 3;
    const FLOATING_BLOCK = 4;
    
    private $id;
    private $name;
    private $blocks = array();
    
    public function __construct($name, $blocks, $id)
    {
        $this->name = $name;
        $this->blocks = $blocks;
        $this->id = $id;
    }
    
    public function addBlock(LayoutBlock $block)
    {
        array_push($this->blocks, $block);
    }
    
    public function getBlocks()
    {
        return $this->blocks;
    }
    
    public function removeAll()
    {
        $this->blocks = array();
    }
}

?>
