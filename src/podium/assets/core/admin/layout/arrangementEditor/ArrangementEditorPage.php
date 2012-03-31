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
 * Description of ArrangementEditorPage
 * 
 * @author Martin Cassidy
 */
class ArrangementEditorPage extends AbstractAdminToolbarPage
{
    /**
     * @Resource
     */
    private $arrangementService;
    
    private $arrangment;
    
    public function __construct($arrangement = null)
    {
        parent::__construct();
        $mw = new \picon\ModalWindow('configMw');
        $mw->setHeight(600);
        $mw->setWidth(500);
        $this->add($mw);
        
        if($arrangement==null)
        {
            $this->arrangment = new Arrangement(null, '');
            $self = $this;
            $onSave = function() use ($self, $mw)
            {
                $layout = $self->arrangment->layout;
                $self->arrangment = $self->arrangementService->prePopulate($self->arrangment);
                $editor = new ArrangementEditorPanel('panel', $self->arrangment, $mw);
                $self->addOrReplace($editor);
                $editor->toolbarRender($self->getToolbar());
            };
            $this->add(new ArrangementFormPanel('panel', new picon\PropertyModel($this, 'arrangment'), $onSave));
        }
        else
        {
            $this->add(new ArrangementEditorPanel('panel', $arrangement, $mw));
        }
    }
    
    protected function getTitle()
    {
        return ($this->arrangment->id==null?'Create':'Edit')." Arrangement";
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
