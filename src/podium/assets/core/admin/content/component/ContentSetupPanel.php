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
 * Form panel for insertion of a content value
 * 
 * @author Martin Cassidy
 */
class ContentSetupPanel extends \picon\Panel
{
    private $panels;
    
    public function __construct($id, PopulatedPage $page)
    {
        parent::__construct($id);
        $this->panels = array();
        $view = new picon\RepeatingView('element');
        $this->add($view);

        foreach($page->contentType->attributes as $attribute)
        {
            $container = new \picon\MarkupContainer($view->getNextChildId());
            $view->add($container);
            $configPanel = WidgetFactory::getWidgetConfigPanel('configEdit', $attribute->widget);
            $configPanel->setModel(new \picon\CompoundPropertyModel($attribute, 'widget.config'));
            $container->add($configPanel);
            $this->panels [] = $configPanel;
            $container->add(new \picon\Label('name', new picon\BasicModel($attribute->name)));
        }
        
    }
    
    public function preProcess()
    {
        foreach($this->panels as $panel)
        {
            $panel->preProcess();
        }
    }
}

?>
