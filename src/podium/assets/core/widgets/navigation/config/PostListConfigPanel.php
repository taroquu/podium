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
 * Config panel for the post list widget
 * 
 * @author Martin Cassidy
 */
class PostListConfigPanel extends AbstractWidgetSetupPanel
{
    /**
     * @Resource
     */
    private $contentTypeService;
    
    private $contentType;
    
    public function __construct($id, Model $model = null)
    {
        parent::__construct($id, $model);
        $amount = new \picon\TextField('amount');
        $amount->add(new picon\MaximumValidator(10));
        $this->add($amount);
        
        $type = new \picon\DropDown('contentType', $this->contentTypeService->getContentTypeByType('post'), new picon\ChoiceRenderer(function($choice, $index)
        {
            return $choice->id;
        }, function($choice, $index)
        {
            return $choice->name;
        }), new \picon\PropertyModel($this, 'contentType'));
        $type->setRequired(true);
        $this->add($type);
    }
    
    public function beforeComponentRender()
    {
        parent::beforeComponentRender();
        if($this->getModelObject()->content_type_id!=null)
        {
            $this->content_type_id = $this->contentTypeService->getContentType($this->getModelObject()->content_type_id);
        }
    }
    
    public function preProcess()
    {
        parent::preProcess();
        $this->getModelObject()->content_type_id = $this->contentType->id;
    }
}

?>
