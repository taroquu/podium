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

use picon\RepeatingView;
use picon\HeaderResponse;

/**
 * Description of ArrangementEditorPanel
 * 
 * @author Martin Cassidy
 */
class ArrangementEditorPanel extends picon\Panel implements ToolbarContributor
{
    /**
     * @Resource
     */
    private $widgetService;
    
    /**
     * @Resource
     */
    private $arrangementService;
   
    private $view;
    
    private $onDelete;
    private $onEdit;
    
    public function __construct($id, Arrangement $arrangement, \picon\ModalWindow $mw)
    {
        parent::__construct($id);
        
        $feedback = new PodiumFeedbackPanel('feedback');
        $feedback->setOutputMarkupId(true);
        $this->add($feedback);
        
        $self = $this;
        $this->onEdit = function(\picon\AjaxRequestTarget $target, WidgetElementItem $item) use($mw, $self)
        {
            $mw->setContent(WidgetFactory::getModalWindowWidgetConfigPanel($item, $mw, $self));
            $mw->show($target);
        };
        
        $this->onDelete = function(\picon\AjaxRequestTarget $target, WidgetElementItem $item) use ($self)
        {
            $block = $self->locateBlockOfItem($self->getModelObject()->layout, $item->elementId);
            $block->removeWidget($item);
            $target->add($self);
        };
        
        $this->setModel(new \picon\BasicModel($arrangement));
        $podiumArrangement = new \picon\DefaultJQueryUIBehaviour('podiumArrangement');
        $this->add($podiumArrangement);
        $this->setOutputMarkupId(true);
        $options = $podiumArrangement->getOptions();
        
        $options->add(new \picon\CallbackFunctionOption('newElement', function(\picon\AjaxRequestTarget $target) use ($self)
        {
            $blockId = $self->getRequest()->getParameter('blockId');
            $widgetId = $self->getRequest()->getParameter('widgetId');
            $block = $self->locateBlock($self->getModelObject()->layout, $blockId);
            $item = $self->getWidgetService()->getWidget($widgetId);
            $config = WidgetFactory::newWidgetConfig($item);
            $item = new WidgetElementItem($item->id, $item->name, $item->class, $item->setupClass, $item->configClass, $item->widgetTargetTable, null, $config);
            $block->addWidget($item, $index);
            $target->add($self);
            $edit = $self->onEdit;
            $edit($target, $item);
        }, 'callBackURL+= \'&blockId=\'+blockId+\'&widgetId=\'+widgetId+\'&index=\'+index+\'\'; ', 'blockId', 'widgetId', 'index'));
        
        $options->add(new picon\CallbackFunctionOption('moved', function(picon\AjaxRequestTarget $target) use ($self)
        {
            $blockId = $self->getRequest()->getParameter('blockId');
            $elementid = $self->getRequest()->getParameter('elementId');
            $dest = $self->locateBlock($self->getModelObject()->layout, $blockId);
            $source = $self->locateBlockOfItem($self->getModelObject()->layout, $elementid);
            
            $widget = null;
            foreach($source->getWidgets() as $entry)
            {
                if($entry->elementId==$elementid)
                {
                    $widget = $entry;
                }
            }
            $source->removeWidget($widget);
            $dest->addWidget($widget, $index);
            
        }, 'callBackURL+= \'&blockId=\'+blockId+\'&elementId=\'+elementId+\'&index=\'+index+\'\'; ', 'blockId', 'elementId', 'index'));
        
        $this->view = new RepeatingView('layoutBlock');
        $this->add($this->view);
    }
    
    public function locateBlockOfItem(PopulatedLayout $layout, $elementId)
    {
        foreach($layout->getBlocks() as $block)
        {
            foreach($block->getWidgets() as $widget)
            {
                if($widget->elementId==$elementId)
                {
                    return $block;
                }
            }
            
            foreach($block->getNestedBlocks() as $nested)
            {
                foreach($nested->getWidgets() as $widget)
                {
                    if($widget->elementId==$elementId)
                    {
                        return $nested;
                    }
                }
            }
        }
    }
    
    /**
     * @todo make private in 5.4
     * @param Layout $layout 
     */
    public function locateBlock(Layout $layout, $blockId)
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
    
    public function beforePageRender()
    {
        parent::beforePageRender();
        foreach($this->view->getChildren() as $child)
        {
            $this->view->remove($child);
        }
        foreach($this->getModelObject()->layout->getBlocks() as $block)
        {
            $panel = LayoutFactory::newEditablePopulatedLayoutBlock($this->view->getNextChildId(), $block, $this->onEdit, $this->onDelete);
            $this->view->add($panel);
        }
    }
    
    public function toolbarRender(RepeatingView &$toolbar)
    {
        $categories = $this->widgetService->getWidgetCategories();
        foreach($categories as $category)
        {
            $toolbar->add(new ToolbarDropLink($toolbar->getNextChildId(), $category));
        }
        
        $self = $this;
        $toolbar->add(new ToolbarLink($toolbar->getNextChildId(), 'Save', function() use ($self)
        {
            //@todo tidy this logic up a LOT
            $arrangement = $self->getModelObject();
            $content = 0;print_r($arrangement);
            foreach($arrangement->layout->blocks as $block)
            {
                foreach($block->getWidgets() as $widget)
                {
                    if($widget->name=='Content Block')
                    {
                        $content++;
                    }
                }
                foreach ($block->getNestedBlocks() as $nested)
                {
                    foreach($nested->getWidgets() as $widget)
                    {
                        if($widget->name=='Content Block')
                        {
                            $content++;
                        }
                    }
                }
            }
            
            if($content!=1)
            {
                $self->error('An arrangement must have a one content widget.');
                return;
            }
            
            $self->getArrangementService()->createOrUpdateArrangement($arrangement);
            $self->setPage(new ArrangementPage($arrangement->layout));
        }, true));
        
        $toolbar->add(new ToolbarLink($toolbar->getNextChildId(), 'Cancel', function() use ($self)
        {
            $arrangement = $self->getModelObject();
            $self->setPage(new ArrangementPage($arrangement->layout));
        }, true, 'grey'));
    }
    
    public function renderHead(picon\HeaderResponse $headerResponse)
    {
        parent::renderHead($headerResponse);
        $headerResponse->renderCSSFile('css/arrangement.css');
        $headerResponse->renderJavaScriptFile('js/arrangement.js');
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function getArrangementService()
    {
        return $this->arrangementService;
    }
    
    public function getWidgetService()
    {
        return $this->widgetService;
    }
}

?>
