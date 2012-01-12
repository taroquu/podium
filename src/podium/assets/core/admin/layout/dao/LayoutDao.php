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

use picon\CallbackRowMapper;

/**
 * Description of LayoutDao
 *
 * @author Martin
 * @Repository
 */
class LayoutDao extends AbstractDao
{
    public function getLayoutSize()
    {
        return $this->getTemplate()->queryForInt("SELECT count(*) FROM layout");
    }
    
    public function getLayouts($start, $count)
    {
        $mapper = function($row)
        {
            $layout = new Layout();
            $layout->id = $row->id;
            $layout->name = $row->name;
            return $layout;
        };
        return $this->getTemplate()->query("SELECT * FROM layout LIMIT %d, %d", new CallbackRowMapper($mapper), array($start, $count));
    }
    
    public function createLayout($name)
    {
        return $this->getTemplate()->insert("INSERT INTO layout (name) VALUES ('%s')", array($name));
    }
    
    public function createBlock($layouterId, AbstractLayoutBlock $block, $index, $parentBlockId = null)
    {
        return $this->getTemplate()->insert("INSERT INTO layout_blocks (layout_id, type, parent_block_id, position) VALUES (%d, '%s', %d, %d)", array($layouterId, get_class($block), $parentBlockId, $index));
    }
    
    public function deleteBlocks($id)
    {
        $this->getTemplate()->update("DELETE FROM layout_blocks WHERE layout_id = %d", array($id));
    }
    
    public function getLayout($id)
    {
        $mapper = function($row)
        {
            $layout = new Layout();
            $layout->id = $row->id;
            $layout->name = $row->name;
            return $layout;
        };
        $layout = $this->getTemplate()->query("SELECT * FROM layout WHERE id = %d", new CallbackRowMapper($mapper), array($id));
        
        if(count($layout)==1)
        {
            return $layout[0];
        }
        else
        {
            throw new IllegalStateException('Expected only one layout');
        }
    }
    
    public function getBlocks($layoutId)
    {
        $mapper = function($row)
        {
            $className = $row->type;
            $block = new $className();
            $block->parent = $row->parent_block_id;
            $block->id = $row->id;
            return $block;
        };
        
        return $this->getTemplate()->query("SELECT * FROM layout_blocks WHERE layout_id = %d ORDER BY position ASC", new CallbackRowMapper($mapper), array($layoutId));
    }
    
    public function getBlockAttributes($blockId)
    {
        $mapper = function($row)
        {
            return new LayoutBlockAttribute($row->name, $row->value);
        };
        
        return $this->getTemplate()->query("SELECT * FROM layout_block_attributes WHERE block_id = %d", new CallbackRowMapper($mapper), array($blockId));
    }
    
    public function addBlockAttribute(LayoutBlockAttribute $attribute, $blockId)
    {
        return $this->getTemplate()->insert("INSERT INTO layout_block_attributes (block_id, name, value) VALUES (%d, '%s', '%s')", array($blockId, $attribute->name, $attribute->value));
    }
}

?>
