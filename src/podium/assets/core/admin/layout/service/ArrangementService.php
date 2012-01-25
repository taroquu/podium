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

        $blocks = array();
        foreach($layout->getBlocks() as $index => $block)
        {
            array_push($blocks, $this->populateBlock($arrangementId, $block));
        }
        $playout = new PopulatedLayout($layout->name, $blocks, $layout->id);
        $arrangement->layout = $playout;
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
    
    public function createOrUpdateArrangement(Arrangement $arrangement)
    {
        if($arrangement->id==null)
        {
            $id = $this->arrangementDao->createArrangement($arrangement);
            $arrangement->id = $id;
        }
        else
        {
            //update name
        }
        $oldArrangement = $this->getArrangement($arrangement->id);
        
        foreach($arrangement->layout->getBlocks() as $block)
        {
            $this->deleteWidgets($block, $this->locateBlock($oldArrangement->layout, $block->id));
            $this->processElements($block, $arrangement->id);
            foreach($block->getNestedBlocks() as $nested)
            {
                $this->deleteWidgets($nested, $this->locateBlock($oldArrangement->layout, $nested->id));
                $this->processElements($nested, $arrangement->id);
            }
        }
    }
    
    private function deleteWidgets(PopulatedLayoutBlock $current, PopulatedLayoutBlock $old)
    {
        foreach($old->getWidgets() as $widget)
        {
            $found = false;
            foreach($current->getWidgets() as $search)
            {
                if($widget->elementId==$search->elementId)
                {
                    $found = true;
                }
            }
            if(!$found)
            {
                $this->arrangementDao->deleteElement($widget->elementId);
            }
        }
    }
    
    private function locateBlock(Layout $layout, $blockId)
    {
        foreach($layout->getBlocks() as $block)
        {
            if($block->id==$blockId)
            {
                return $block;
            }
            foreach($block->getNestedBlocks() as $nested)
            {
                if($nested->id==$blockId)
                {
                    return $nested;
                }
            }
        }
        return false;
    }
    
    private function processElements(PopulatedLayoutBlock $block, $arrangementId)
    {
        foreach($block->getWidgets() as $index => $widget)
        {
            if($widget->elementId==null)
            {
                $this->arrangementDao->createElement($widget, $block->id, $index, $arrangementId);
            }
            else
            {
                $this->arrangementDao->updateElement($widget, $block->id, $index, $arrangementId);
            }
        }
    }
    
    public function prePopulate(Arrangement $arrangement)
    {
        $layout = $arrangement->layout;
        
        $blocks = array();
        foreach($layout->getBlocks() as $block)
        {
            $nblock = new PopulatedLayoutBlock($block->type);
            $nblock->id = $block->id;
            $nblock->setAttributes($block->getAttributes());
            array_push($blocks, $nblock);
            foreach($block->getNestedBlocks() as $nested)
            {
                $nnest = new PopulatedLayoutBlock($nested->type);
                $nnest->id = $nested->id;
                $nnest->setAttributes($nested->getAttributes());
                $nblock->addNestedBlock($nnest);
            }
        }
        
        $playout = new PopulatedLayout($layout->name, $blocks, $layout->id);
        $arrangement->layout = $playout;
        return $arrangement;
    }
}

?>
