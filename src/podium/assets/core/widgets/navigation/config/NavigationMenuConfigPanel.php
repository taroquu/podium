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
 * Config panel for the navigation menu widget
 * 
 * @author Martin Cassidy
 */
class NavigationMenuConfigPanel extends AbstractWidgetSetupPanel
{
    /**
     * @Resource
     */
    private $postService;
    
    /**
     * @Resource
     */
    private $pageService;
    
    /**
     * @Resource
     */
    private $menuService;
    
    private $orientation;
    private $menu;
    private $newElement;
    
    public function __construct($id, Model $model = null)
    {
        parent::__construct($id, $model);
        $updateBlock = new \picon\MarkupContainer('updateBlock');
        $updateBlock->setOutputMarkupId(true);
        $this->add($updateBlock);
        $this->newElement = new MenuElement();
        $menuId = $this->getModelObject()->menu_id;
        if($menuId==null)
        {
            $this->menu = new UserMenu();
        }
        else
        {
            $this->menu = $this->menuService->getMenu($menuId);
        }
        
        $this->add(new \picon\DropDown('orientation', array('vertical', 'horizontal'), null, new \picon\PropertyModel($this, 'orientation')));
        
        $self = $this;
        $updateBlock->add(new picon\ListView('elements', function(picon\ListItem $item) use ($self, $updateBlock)
        {
            $element = $item->getModelObject();
            $item->add(new \picon\Label('title', new picon\BasicModel($element->title)));
            $item->add(new \picon\Label('type', new picon\BasicModel($element->type)));
            $value = $element->type==MenuElement::MENU_ELEMENT_TYPE_PAGE?$element->page->name:'';
            $value = $element->type==MenuElement::MENU_ELEMENT_TYPE_POST?$element->post->name:$value;
            $value = $element->type==MenuElement::MENU_ELEMENT_TYPE_EXTERNAL?$element->externalUrl:$value;
            $item->add(new \picon\Label('value', new picon\BasicModel($value)));
            
            $item->add(new picon\AjaxLink('delete', function(\picon\AjaxRequestTarget $target) use ($element, $updateBlock, $self)
            {
                $self->menu->deleteElement($element);
                $target->add($updateBlock);
            }));
        }, new \picon\PropertyModel($this, 'menu.elements')));
        
        $form = new \picon\Form('elementForm', new picon\CompoundPropertyModel($this, 'newElement'));
        $this->add($form);
        $form->add(new \picon\RequiredTextField('title'));
        $typeDrop = new \picon\DropDown('type', array(MenuElement::MENU_ELEMENT_TYPE_PAGE, MenuElement::MENU_ELEMENT_TYPE_POST, MenuElement::MENU_ELEMENT_TYPE_EXTERNAL),
        new \picon\ChoiceRenderer(function($choice, $index)
        {
            return 'v'.$index;
        }, function($choice, $index)
        {
            return ucwords($choice);
        }));
        $typeDrop->setRequired(true);
        $form->add($typeDrop);
        $form->setOutputMarkupId(true);
        $feedback = new PodiumFeedbackPanel('feedback');
        $feedback->setOutputMarkupId(true);
        $form->add($feedback);
        $fields = new \picon\MarkupContainer('fields');
        $fields->setOutputMarkupId(true);
        $form->add($fields);
        $pages = $self->getPageService()->getPagesStack();
        $pageDrop = new picon\DropDown('page', $pages, new \picon\ChoiceRenderer(function($choice, $index)
        {
            return 'v'.$index;
        }, function($choice, $index)
        {
            return $choice->name;
        }));
        $fields->add($pageDrop);
        $posts = $self->getPostService()->getPosts(0, $self->getPostService()->getPostSize());
        $postDrop = new picon\DropDown('post', $posts, new \picon\ChoiceRenderer(function($choice, $index)
        {
            return 'v'.$index;
        }, function($choice, $index)
        {
            return $choice->name;
        }));
        $fields->add($postDrop);
        $urlField = new \picon\TextField('externalUrl');
        $fields->add($urlField);
        $pageDrop->setVisible(false);
        $postDrop->setVisible(false);
        $urlField->setVisible(false);
        $pageDrop->setRequired(false);
        $postDrop->setRequired(false);
        $urlField->setRequired(false);
        $visibilityCallback = function(\picon\AjaxRequestTarget $target) use ($fields, $pageDrop, $postDrop, $urlField, $typeDrop)
        {
            $type = $typeDrop->getModelObject();
            $pageDrop->setVisible($type==MenuElement::MENU_ELEMENT_TYPE_PAGE);
            $postDrop->setVisible($type==MenuElement::MENU_ELEMENT_TYPE_POST);
            $urlField->setVisible($type==MenuElement::MENU_ELEMENT_TYPE_EXTERNAL);
            $pageDrop->setRequired($type==MenuElement::MENU_ELEMENT_TYPE_PAGE);
            $postDrop->setRequired($type==MenuElement::MENU_ELEMENT_TYPE_POST);
            $urlField->setRequired($type==MenuElement::MENU_ELEMENT_TYPE_EXTERNAL);
            $target->add($fields);
        };
        $typeDrop->add(new picon\AjaxFormComponentUpdateBehavior('onChange', $visibilityCallback));
        
        $form->add(new picon\AjaxButton('add', function(\picon\AjaxRequestTarget $target) use ($form, $self, $updateBlock, $pageDrop)
        {
            $self->menu->addElement($self->newElement);
            $self->newElement = new MenuElement();
            $target->add($updateBlock);
            $target->add($form);
        }, function(\picon\AjaxRequestTarget $target) use ($feedback)
        {
            $target->add($feedback);
        }));
    }
    
    public function beforeComponentRender()
    {
        parent::beforeComponentRender();
        $this->orientation = $this->getModelObject()->orientation==null?null:$this->getModelObject()->orientation==0?'vertical':'horizontal';
    }
    
    public function preProcess()
    {
        parent::preProcess();
        $this->getModelObject()->orientation = $this->orientation=='vertical'?0:1;
        
        $this->menuService->createOrUpdateMenu($this->menu);
        $this->getModelObject()->menu_id = $this->menu->id;
    }
    
    public function getPageService()
    {
        return $this->pageService;
    }
    
    public function getPostService()
    {
        return $this->postService;
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}

?>
