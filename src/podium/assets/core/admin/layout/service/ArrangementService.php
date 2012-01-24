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
 * Description of ArrangementService
 * 
 * @author Martin Cassidy
 * @Service
 */
class ArrangementService
{
    /**
     * @Resource
     */
    private $arrangementDao;
    
    /**
     * @Resource
     */
    private $layoutService;
    
    public function getArrangementsForLayout($layout, $start, $count)
    {
        return $this->arrangementDao->getArrangementsForLayout($layout, $start, $count);
    }
    
    public function getArrangementCount($layoutId)
    {
        return $this->arrangementDao->getArrangementCount($layoutId);
    }
    
    public function getArrangement($arrangementId)
    {
        $arrangement = $this->arrangementDao->getArrangement($arrangementId);
        $layout = $this->layoutService->getLayout($arrangement->layout);
        $playout = new PopulatedLayout();
        $playout->id = $layout->id;
        $playout->name = $layout->name;
        $arrangement->layout = $playout;
        $blocks = array();
        foreach($layout->getBlocks() as $index => $block)
        {
            array_push($blocks, $this->populateBlock($arrangementId, $block));
        }
        $arrangement->layout->blocks = $blocks;
        return $arrangement;
    }
    
    private function populateBlock($arrangementId, AbstractLayoutBlock $block)
    {
        $pblock = new PopulatedLayoutBlock($block->type);
        $pblock->id = $block->id;
        $pblock->attributes = $block->attributes;
        $cols = array();
        foreach($block->getNestedBlocks() as $index => $col)
        {
            array_push($cols, $this->populateBlock($arrangementId, $col));
        }
        $pblock->nestedBlocks = $cols;
            
        $widgets = $this->arrangementDao->getBlockContents($arrangementId, $block->id);
        foreach($widgets as $widget)
        {
            $pblock->addWidget($widget);
        }
        return $pblock;
    }
}

?>
