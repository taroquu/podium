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
 * Description of OptionsPanel
 * 
 * @author Martin Cassidy
 */
class OptionsPanel extends picon\Panel
{
    public function __construct($id)
    {
        parent::__construct($id);
    }
    
    protected function onInitialize()
    {
        parent::onInitialize();
        $radioGroup = new \picon\RadioGroup('sumitActionType');
        $this->add($radioGroup);
        
        $message = new \picon\Radio('message', new \picon\BasicModel(1));
        $page = new \picon\Radio('page', new \picon\BasicModel(2));
        $radioGroup->add($message);
        $radioGroup->add($page);
        
        $action = new \picon\MarkupContainer('action');
        $action->setOutputMarkupId(true);
        $this->add($action);
        
        $messageField = new picon\TextArea('message');
        $pageField = new picon\DropDown('page', array('example page'));
        $action->add($messageField);
        $action->add($pageField);
        
        $messageField->setVisible($radioGroup->getModelObject()==1);
        $pageField->setVisible($radioGroup->getModelObject()==2);
        
        
        $message->add(new picon\AjaxEventBehaviour('onChange', function(picon\AjaxRequestTarget $target) use($messageField, $pageField, $action, $radioGroup)
        {
            $messageField->setVisible(true);
            $pageField->setVisible(false);
            $target->add($action);
        }));
        $page->add(new picon\AjaxEventBehaviour('onChange', function(picon\AjaxRequestTarget $target) use($messageField, $pageField, $action, $radioGroup)
        {
            $messageField->setVisible(false);
            $pageField->setVisible(true);
            $target->add($action);
        }));
    }
}

?>
