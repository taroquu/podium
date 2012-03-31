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
 * Description of CreateEditContentTypePage
 * 
 * @author Martin Cassidy
 */
class CreateEditContentTypePage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $contentTypeService;
    
    /**
     * @Resource
     */
    private $layoutService;
    
    /**
     * @Resource
     */
    private $themeService;
    
    private $contentType;
    
    private $attributes;
    
    public function __construct(PopulatedContentType $type)
    {
        parent::__construct();
        
        if($type==null)
        {
            $type = new PopulatedContentType();
        }
        
        $this->contentType = $type;
        
        $this->add(new PodiumFeedbackPanel('feedback'));
        $form = new \picon\Form('form', new picon\CompoundPropertyModel($this, 'contentType'));
        $this->add($form);
        $form->add(new picon\RequiredTextField('name'));
        $typeDrop = new \picon\DropDown('type', array('page', 'post'), new \picon\ChoiceRenderer(function($choice, $index)
        {
            return $choice;
        },
        function($choice, $index)
        {
            return ucwords($choice);
        }));
        $typeDrop->setDisabled($type->id!=null);
        $typeDrop->setRequired(true);
        $form->add($typeDrop);
        
        $arrangements = $this->layoutService->getLayoutsAndArrangement();
        
        foreach($arrangements as $name => $arranement)
        {
            $arrangements[ucwords($name)] = $arranement;
            unset($arrangements[$name]);
        }
        
        $arrangementDrop = new picon\DropDown('arrangement', $arrangements, new picon\ChoiceRenderer(function($choice, $index)
        {
            return $index;
        },
        function($choice, $index)
        {
            return ucwords($choice->name);
        }));
        $arrangementDrop->setRequired(true);
        $form->add($arrangementDrop);
        
        $themeDrop = new picon\DropDown('theme', $this->themeService->getThemes(0, $this->themeService->getThemeSize()), new picon\ChoiceRenderer(function($choice, $index)
        {
            return $index;
        },
        function($choice, $index)
        {
            return ucwords($choice->name);
        }));
        $themeDrop->setRequired(true);
        $form->add($themeDrop);
        
        $mw = new \picon\ModalWindow('mw');
        $this->add($mw);
        $mw->setHeight(300);
        $mw->setWidth(500);
        
        $attributeList = new \picon\MarkupContainer('attributeList');
        $attributeList->setOutputMarkupId(true);
        $sortable = new picon\SortableBehavior();
        $attributeList->add($sortable);
        $form->add($attributeList);
        
        $self = $this;
        $settingSubmitCallback = function(\picon\AjaxRequestTarget $target, ContentTypeAttribute $attribute) use ($mw, $attributeList)
        {
            $target->add($attributeList);
            $mw->hide($target);
        };
        
        $this->attributes = new picon\ListView('attribute', function(\picon\ListItem $item) use ($mw, $fields, $type, $self, $attributeList, $settingSubmitCallback)
        {
            $item->add(new \picon\Label('attributeName', new \picon\BasicModel($item->getModelObject()->name)));
            $indexValue = new \picon\MarkupContainer('index');
            $item->add($indexValue);
            $indexValue->add(new \picon\AttributeModifier('value', new picon\BasicModel($item->getIndex())));
            
            $item->add(new \picon\AjaxLink('edit', function(\picon\AjaxRequestTarget $target) use($mw, $item, $settingSubmitCallback)
            {
                $mw->setContent(new ContentTypeSetupPanel($mw->getContentId(), $item->getModelObject(), $settingSubmitCallback));
                $mw->show($target);
            }));
            $item->add(new \picon\AjaxLink('delete', function(\picon\AjaxRequestTarget $target) use($attributeList, $type, $item, $self)
            {
                $type->removeAttribute($item->getModelObject());
                $self->getAttributesPanel()->setModel(new \picon\ArrayModel($type->attributes));
                $target->add($attributeList);
            }));
        }, new \picon\ArrayModel($type->attributes));
        $attributeList->add($this->attributes);
        
        $sortable->setReceiveCallback(function(picon\AjaxRequestTarget $target) use($attributeList, $attributes, $type, $mw, $self, $settingSubmitCallback)
        {
            $attributeId = $attributeList->getRequest()->getParameter('attributeId');
            $index = $attributeList->getRequest()->getParameter('index');
            //@todo alter this to use the full attribute object
            $newAttribute = new ContentTypeAttribute($attributeId, '');
            $type->addAttribute($newAttribute, $index);
            $target->add($attributeList);
            $self->getAttributesPanel()->setModel(new \picon\ArrayModel($type->attributes));
            $mw->setContent(new ContentTypeSetupPanel($mw->getContentId(), $newAttribute, $settingSubmitCallback));
            $mw->show($target);
        }, 'callBackURL += \'&attributeId=\'+$(\'input[type=hidden]\', ui.item).attr(\'value\')+\'&index=\'+ui.item.index();');
        
        $sortable->setStopCallback(function(picon\AjaxRequestTarget $target) use($attributeList, $type, $self)
        {
            $oldindex = $attributeList->getRequest()->getParameter('oldIndex');
            $index = $attributeList->getRequest()->getParameter('index');
            $toRemove = $type->attributes[$oldindex];
            $type->removeAttribut($toRemove);
            $type->addAttribute($toRemove, $index);
            $target->add($attributeList);
            $self->getAttributesPanel()->setModel(new \picon\ArrayModel($type->attributes));
        }, "if(ui.item.hasClass('newItem'))return; callBackURL += '&oldIndex='+$('input[type=hidden]', ui.item).val()+'&index='+ui.item.index();");
        
        
        $availableAttributes = $this->contentTypeService->getAttributes();
        $form->add(new \picon\ListView('attributes', function(\picon\ListItem $item) use ($attributeList)
        {
            $attribute = $item->getModelObject();
            $item->add(new picon\Label('attributeName', new \picon\BasicModel($attribute->name)));
            $draggable = new \picon\DraggableBehaviour();
            $draggable->setHelper('clone');
            $draggable->setRevert(true);
            $draggable->setConnectToSortable($attributeList);
            $item->add($draggable);
            $attributeId = new \picon\MarkupContainer('attributeId');
            $item->add($attributeId);
            $attributeId->add(new picon\AttributeModifier('value', new \picon\BasicModel($attribute->id)));
        }, new \picon\ArrayModel($availableAttributes)));
        
        $form->add(new picon\Button('save', function() use($self, $type)
        {
            $self->getContentTypeService()->createOrUpdate($type);
            $self->setpage(ContentTypeListPage::getIdentifier());
        }));
        
        $form->add(new ButtonLink('cancel', function() use($self)
        {
            $self->setpage(ContentTypeListPage::getIdentifier());
        },'grey'));
    }
    
    protected function getTitle()
    {
        return $this->contentType->id==null?'Create Content Type':'Edit Content Type';
    }
    
    public function getAttributesPanel()
    {
        return $this->attributes;
    }
    
    public function getContentTypeService()
    {
        return $this->contentTypeService;
    }
}

?>
