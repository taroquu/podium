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
 * Description of LayoutService
 *
 * @author Martin Cassidy
 * @Service
 */
class LayoutService
{
    /**
     * @Resource
     */
    private $layoutDao;
    
    public function getLayouts($start, $count)
    {
        $layouts = $this->layoutDao->getLayouts($start, $count);
        
        foreach($layouts as $index => $layout)
        {
            $this->populateLayout($layout);
        }
        return $layouts;
    }
    
    public function getLayoutsSize()
    {
        return $this->layoutDao->getLayoutSize();
    }
    
    public function getLayout($id)
    {
        $layout = $this->layoutDao->getLayout($id);
        $this->populateLayout($layout);
        return $layout;
    }
    
    private function populateLayout(Layout &$layout)
    {
        $blocks = $this->layoutDao->getBlocks($layout->id);
        
        foreach($blocks as $block)
        {
            $attributes = $this->layoutDao->getBlockAttributes($block->id);
            $block->setAttributes($attributes);
            if($block->parent==0)
            {
                $layout->addBlock($block);
            }
        }
        
        /**
         * @todo Sort out block nesting
         * -should be recursive
         * -this currently assumes that all parents are column blocks and
         * all blocks with parents are column elements
         */
        foreach($blocks as $block)
        {
            if($block->parent!=0)
            {
                foreach($layout->getBlocks() as $parent)
                {
                    if($parent->id==$block->parent)
                    {
                        $parent->addColumn($block);
                    }
                }
            }
        }
    }
    
    public function createOrUpdateLayout(Layout $layout)
    {
        $id = null;
        if($layout->id==null)
        {
            $id = $this->layoutDao->createLayout($layout->name);
        }
        else
        {
            $id = $layout->id;
            //update name
            $this->layoutDao->deleteBlocks($id);
        }
        
        foreach($layout->getBlocks() as $index => $block)
        {
            $blockid = $this->layoutDao->createBlock($id, $block, $index);
            $this->createAttributes($block, $blockid);
            if($block instanceof ColumnBlock)
            {
                foreach($block->getColumns() as $colIndex => $column)
                {
                    $colId = $this->layoutDao->createBlock($id, $column, $colIndex, $blockid);
                    $this->createAttributes($column, $colId);
                }
            }
        }
    }
    
    private function createAttributes(AbstractLayoutBlock $block, $blockId)
    {
        foreach($block->getAttributes() as $attribute)
        {
            $this->layoutDao->addBlockAttribute($attribute, $blockId);
        }
    }
}

?>
