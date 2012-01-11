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
        
        $layoutUI->getOptions()->add(new \picon\CallbackOption('test2', function(picon\AjaxRequestTarget $target) 
        {
            
        }));
        
        $view = new RepeatingView('layoutBlock');
        $this->add($view);
        
        foreach($layout->getBlocks() as $block)
        {
            $panel = null;
            if($block instanceof RowBlock)
            {
                $panel = new RowBlockPanel($view->getNextChildId(), $block);
            }
            else if($block instanceof ColumnBlock)
            {
                $panel = new ColumnBlockPanel($view->getNextChildId(), $block);
            }
            else if($block instanceof FloatingBlock)
            {
                $panel = new FloatingBlockPanel($view->getNextChildId(), $block);
            }
            $view->add($panel);
        }
    }
    
    public function renderHead(HeaderResponse $headerResponse)
    {
        parent::renderHead($headerResponse);
        $headerResponse->renderJavaScriptResourceReference(new ResourceReference('layout.js', self::getIdentifier()));
        $headerResponse->renderCSSResourceReference(new ResourceReference('layout.css', self::getIdentifier()));
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
        }));
    }
    
    public function getLayoutService()
    {
        return $this->layoutService;
    }
}

?>
