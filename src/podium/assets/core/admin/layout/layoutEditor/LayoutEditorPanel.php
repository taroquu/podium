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
use picon\ResourceReference;
use picon\RepeatingView;
use picon\HeaderResponse;
use picon\DefaultJQueryUIBehaviour;
use picon\AttributeModifier;
use picon\BasicModel;
use picon\Link;

/**
 * Description of LayoutEditorPanel
 *
 * @author Martin Cassidy
 */
class LayoutEditorPanel extends Panel implements ToolbarContributor
{
    /**
     * @Resource
     */
    private $layoutService;
    
    public function __construct($id, Layout $layout)
    {
        parent::__construct($id, null);
        $this->setModel(new BasicModel($layout));
        
        $this->add(new AttributeModifier('class', new BasicModel('layoutEditor')));
        $layoutUI = new DefaultJQueryUIBehaviour('podiumLayout');
        $this->add($layoutUI);
        
        $self = $this;
        $layoutUI->getOptions()->add(new picon\CallbackFunctionOption('updated', function(picon\AjaxRequestTarget $target) use ($self)
        {
            $layout = $self->getModelObject();
            $layout->removeAll();
            
            $types = array('columnBlock' => Layout::COLUMN_BLOCK, 
                'rowBlock' => Layout::ROW_BLOCK, 
                'columnElement' => Layout::COLUMN_ELEMENT, 
                'floatingBlock' => Layout::FLOATING_BLOCK);
            
            /**
             * Very bad atm as it assumes that all inner blocks are column elements
             * and all parent blocks are column blocks
             */
            foreach($_GET['blocks'] as $block)
            {
                $dblock = new LayoutBlock($types[$block['type']]);
                $dblock->id = $block['id'];
                $layout->addBlock($dblock);
                
                foreach($block['attributes'] as $name => $value)
                {
                    $dblock->addAttribute(new LayoutBlockAttribute($name, strval($value)));
                }
                
                if(array_key_exists('children', $block))
                {
                    foreach($block['children'] as $child)
                    {
                        $type = $types[$child['type']];
                        $col = new LayoutBlock($type);
                        $col->id = $child['id'];
                        $dblock->addNestedBlock($col);
                        foreach($child['attributes'] as $name => $value)
                        {
                            $col->addAttribute(new LayoutBlockAttribute($name, strval($value)));
                        }
                    }
                }
            }
            
        }, 'callBackURL += \'&\'+data;', 'data'));
        
        $view = new RepeatingView('layoutBlock');
        $this->add($view);
        
        foreach($layout->getBlocks() as $block)
        {
            $panel = null;
            $view->add(LayoutFactory::newLayoutBlockPanel($view->getNextChildId(), $block, true));
        }
    }
    
    public function renderHead(picon\HeaderResponse $headerResponse)
    {
        parent::renderHead($headerResponse);
        $headerResponse->renderCSSFile('css/layout.css');
        $headerResponse->renderJavaScriptFile('js/layout.js');
    }
    
    public function toolbarRender(RepeatingView &$toolbar)
    {
        $toolbar->add(new NewElementToolbarPanel($toolbar->getNextChildId(), 'createRow', 'New Row'));
        $toolbar->add(new NewElementToolbarPanel($toolbar->getNextChildId(), 'createColumn', 'New Column'));
        $toolbar->add(new NewElementToolbarPanel($toolbar->getNextChildId(), 'createFloating', 'New Floating Block'));
        
        $self = $this;
        $toolbar->add(new ToolbarLink($toolbar->getNextChildId(), 'Save', function() use ($self)
        {
            $self->getLayoutService()->createOrUpdateLayout($self->getModelObject());
            $self->setPage(LayoutPage::getIdentifier());
        }, true));
        
        $toolbar->add(new ToolbarLink($toolbar->getNextChildId(), 'Cancel', function() use ($self)
        {
            $self->setPage(LayoutPage::getIdentifier());
        }, true, 'grey'));
    }
    
    public function getLayoutService()
    {
        return $this->layoutService;
    }
}

?>
