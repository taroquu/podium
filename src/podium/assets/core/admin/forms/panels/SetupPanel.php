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
 * Description of SetupPanel
 * 
 * @author Martin Cassidy
 */
class SetupPanel extends picon\Panel
{
    private $fieldList;
    
    public function __construct($id, PopulatedForm $form)
    {
        parent::__construct($id);
        
        $this->add(new picon\RequiredTextField('name'));
        
        $fields = new \picon\MarkupContainer('fieldList');
        $sortable = new picon\SortableBehavior();
        $fields->add($sortable);
        $this->add($fields);
        
        $mw = new \picon\ModalWindow('mw');
        $this->add($mw);
        $mw->setHeight(500);
        $mw->setWidth(700);
        
        $self = $this;
        $deleteCallback = function(picon\AjaxRequestTarget $target, AbstractFormField $field) use ($form, $self, $fields)
        {
            $form->removeField($field);
            $self->fieldList->setModel(new \picon\ArrayModel($form->fields));
            $target->add($fields);
        };
        
        $this->fieldList = new picon\ListView('field', function(\picon\ListItem $item) use ($mw, $fields, $deleteCallback)
        {
            $item->add(new FormFieldPanel('fieldPanel', $mw, $fields, $deleteCallback, $item->getModel()));
            $indexValue = new \picon\MarkupContainer('index');
            $item->add($indexValue);
            $indexValue->add(new \picon\AttributeModifier('value', new picon\BasicModel($item->getIndex())));
        }, new \picon\ArrayModel($form->fields));

        $fields->add($this->fieldList);
        $fields->setOutputMarkupId(true);
        
        $sortable->setReceiveCallback(function(picon\AjaxRequestTarget $target) use($fields, $form, $self, $mw)
        {
            $type = $fields->getRequest()->getParameter('type');
            $index = $fields->getRequest()->getParameter('index');
            $field = new $type();
            $form->addField($field, $index);
            $target->add($fields);
            $self->fieldList->setModel(new \picon\ArrayModel($form->fields));
            $mw->setContent(FieldFactory::getSetupPanel($field, $mw, $fields));
            $mw->show($target);
        }, 'callBackURL += \'&type=\'+$(\'input[type=hidden]\', ui.item).attr(\'value\')+\'&index=\'+ui.item.index();');
        
        $sortable->setStopCallback(function(picon\AjaxRequestTarget $target) use($fields, $form, $self, $mw)
        {
            $oldindex = $fields->getRequest()->getParameter('oldIndex');
            $index = $fields->getRequest()->getParameter('index');
            $toRemove = $form->fields[$oldindex];
            $form->removeField($toRemove);
            $form->addField($toRemove, $index);
            $target->add($fields);
            $self->fieldList->setModel(new \picon\ArrayModel($form->fields));
        }, "if(ui.item.hasClass('newItem'))return; callBackURL += '&oldIndex='+$('input[type=hidden]', ui.item).val()+'&index='+ui.item.index();");
        
        $this->add(new picon\ListView('fields', function(\picon\ListItem $item) use ($fields)
        {
            $item->add(new picon\Label('fieldName', new \picon\BasicModel($item->getModelObject()->name)));
            $draggable = new \picon\DraggableBehaviour();
            $draggable->setHelper('clone');
            $draggable->setRevert(true);
            $draggable->setConnectToSortable($fields);
            $item->add($draggable);
            $fieldType = new \picon\MarkupContainer('fieldType');
            $item->add($fieldType);
            $fieldType->add(new picon\AttributeModifier('value', new \picon\BasicModel(get_class($item->getModelObject()))));
        }, new \picon\ArrayModel(FieldFactory::getFieldNames())));
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
