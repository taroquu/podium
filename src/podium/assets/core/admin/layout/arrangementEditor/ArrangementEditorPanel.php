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
    
    public function __construct($id, Arrangement $arrangement)
    {
        parent::__construct($id);
        $this->add(new \picon\DefaultJQueryUIBehaviour('podiumArrangement'));
        
        $view = new RepeatingView('layoutBlock');
        $this->add($view);
        
        foreach($arrangement->layout->getBlocks() as $block)
        {
            $panel = LayoutFactory::newLayoutBlockPanel($view->getNextChildId(), $block, true);
            $view->add($panel);
        }
    }
    
    public function toolbarRender(RepeatingView &$toolbar)
    {
        $categories = $this->widgetService->getWidgetCategories();
        foreach($categories as $category)
        {
            $toolbar->add(new ToolbarDropLink($toolbar->getNextChildId(), $category));
        }
    }
    
    public function renderHead(HeaderResponse $headerResponse)
    {
        parent::renderHead($headerResponse);
        $headerResponse->renderCSSFile('css/arrangement.css');
        $headerResponse->renderJavaScriptFile('js/arrangement.js');
    }
}

?>
