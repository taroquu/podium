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
 * Implementation of the arrangement service
 * 
 * @author Martin Cassidy
 * @Service
 */
class ArrangementService implements IArrangementService
{
    /**
     * @Resource
     */
    private $arrangementDao;
    
    /**
     * @Resource
     */
    private $layoutService;
    
    /**
     * @Resource
     */
    private $widgetService;

    public function getArrangementsForLayout(Layout $layout, $start, $count)
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
            $configId = $this->arrangementDao->getElementConfigId($widget->elementId);
            $widget->config = $this->widgetService->getWidgetConfig($widget, $configId);
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
            //@todo update name
            $oldArrangement = $this->getArrangement($arrangement->id);
            $this->deleteWidgets($arrangement->layout, $oldArrangement->layout);
        }

        foreach($arrangement->layout->getBlocks() as $block)
        {
            $this->processElements($block, $arrangement->id);
            foreach($block->getNestedBlocks() as $nested)
            {
                $this->processElements($nested, $arrangement->id);
            }
        }
    }
    
    private function deleteWidgets(PopulatedLayout $current, PopulatedLayout $old)
    {
        $currentWidgets = array();
        foreach($old->getBlocks() as $block)
        {
            $currentWidgets = array_merge($currentWidgets, $block->getWidgets());
            foreach($block->getNestedBlocks() as $nested)
            {
                $currentWidgets = array_merge($currentWidgets, $nested->getWidgets());
            }
        }

        foreach($currentWidgets as $widget)
        {
            if($current->locateWidget($widget->elementId)==null)
            {
                $this->deleteWidget($widget);
            }
        }
    }
    
    private function deleteWidget($widget)
    {
        $this->arrangementDao->deleteElement($widget->elementId);
        $this->widgetService->deleteWidgetConfig($widget, $widget->config->widgetConfigId);
    }
    
    private function processElements(PopulatedLayoutBlock $block, $arrangementId)
    {
        foreach($block->getWidgets() as $index => $widget)
        {
            $config = $this->widgetService->createOrUpdateWidgetConfig($widget);
            if($widget->elementId==null)
            {
                $widget->elementId = $this->arrangementDao->createElement($widget, $block->id, $index, $arrangementId, $config->widgetConfigId);
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

    public function deleteArrangement(Arrangement $arrangement)
    {
        $currentWidgets = array();
        $populated = $this->getArrangement($arrangement->id);
        foreach($populated->layout->getBlocks() as $block)
        {
            $currentWidgets = array_merge($currentWidgets, $block->getWidgets());
            foreach($block->getNestedBlocks() as $nested)
            {
                $currentWidgets = array_merge($currentWidgets, $nested->getWidgets());
            }
        }

        foreach($currentWidgets as $widget)
        {
            $this->deleteWidget($widget);
        }
        $this->arrangementDao->deleteArrangement($arrangement->id);
    }
    
    public function inUse($arrangementId)
    {
        return $this->arrangementDao->getArrangementUseageCount($arrangementId)>0;
    }
    
    public function checkNameExists($name, $id = null)
    {
        $arrangements = $this->arrangementDao->getArrangementByName($name);

        if(count($arrangements)==0)
        {
            return false;
        }
        else
        {
            return $id==null?true:$arrangements[0]->id!=$id;
        }
    }
}

?>
