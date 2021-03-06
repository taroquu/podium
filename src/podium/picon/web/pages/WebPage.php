<?php

/**
 * Picon Framework
 * http://code.google.com/p/picon-framework/
 *
 * Copyright (C) 2011-2012 Martin Cassidy <martin.cassidy@webquub.com>

 * Picon Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * Picon Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with Picon Framework.  If not, see <http://www.gnu.org/licenses/>.
 * */

namespace picon;

/**
 * Super class for all web pages
 * 
 * @author Martin Cassidy
 * @package web/pages
 */
class WebPage extends MarkupContainer implements RequestablePage
{
    private $autoIndex = 0;
    
    public function __construct()
    {
        parent::__construct(PageMap::getNextPageId());
    }
    
    protected function onRender()
    {
        $pageMarkup = $this->getMarkup(); 
        parent::renderAll(array(&$pageMarkup));
    }
    
    public function renderPage()
    {
        $this->render();
    }
    
    public function isPageStateless()
    {
        $stateless = $this->isStateless();
        
        if(!$stateless)
        {
            return $stateless;
        }
        
        $reflection = new \ReflectionClass(get_called_class());
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();
        
        //@todo also add page params to this when in place
        $stateless = count($params)==0;
        
        if(!$stateless)
        {
            return $stateless;
        }
        
        $callback = function($component) use (&$stateless)
        {
            if(!$component->isStateless())
            {
                $stateless = false;
                return Component::VISITOR_STOP_TRAVERSAL;
            }
            return Component::VISITOR_CONTINUE_TRAVERSAL;
        };
        $this->visitChildren(Component::getIdentifier(), $callback);
        return $stateless;
    }
    
    public function afterPageRender()
    {
        parent::afterPageRender();
        if(!$this->isPageStateless())
        {
            PageMap::get()->addOrUpdate($this);
        }
        FeedbackModel::get()->cleanup();
    }
    
    public function beforePageRender()
    {
        parent::beforePageRender();
        if(!$this->isInitialized())
        {
            $this->internalInitialize();
        }
    }
    
    public function getAutoIndex()
    {
        $this->autoIndex++;
        return $this->autoIndex;
    }
}

?>
