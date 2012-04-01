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
 * Page for listing arrangements attached to a layout
 * 
 * @author Martin Cassidy
 */
class ArrangementPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $arrangementService;
    
    private $layout;
    
    public function __construct(Layout $layout)
    {
        parent::__construct();
        $this->add(new PodiumFeedbackPanel('feedback'));
        
        $self = $this;
        $editCallback = function($id, $arrangementModel) use ($self)
        {
            return new LinkPanel($id, 'Edit', function() use ($self, $arrangementModel)
            {
                $arrangement = $arrangementModel->getModelObject();
                $arrangement = $self->arrangementService->getArrangement($arrangement->id);
                $self->setPage(new ArrangementEditorPage($arrangement));
            });
        };
        
        $deleteCallback = function($id, $arrangementModel) use ($self, $layout)
        {
            return new LinkPanel($id, 'Delete', function() use ($self, $arrangementModel, $layout)
            {
                $arrangement = $arrangementModel->getModelObject();
                
                if($self->arrangementService->inUse($arrangement->id))
                {
                    $self->error($arrangement->name.' cannot be deleted because it is in use');
                    return;
                }
                $self->arrangementService->deleteArrangement($arrangement);
                $self->success($arrangement->name.' deleted successfully');
                $self->setPage(new ArrangementPage($layout));
            });
        };
        
        $inUseCallback = function($id, $arrangementModel) use ($self)
        {
            return new InUsePanel($id, $self->arrangementService->inUse($arrangementModel->getModelObject()->id));
        };
        
        $columns = array();
        $columns[] = new \picon\PropertyColumn('Arrangement Name', 'name');
        $columns[] = new PanelColumn('In Use', $inUseCallback);
        $columns[] = new PanelColumn('', $editCallback);
        $columns[] = new PanelColumn('', $deleteCallback);
        
        $provider = new ArrangementDataProvider($layout);
        
        $this->add(new picon\DefaultDataTable('arrangements', $provider, $columns));
        
        $self = $this;
        $this->add(new ButtonLink('create', function() use ($self)
        {
            $self->setPage(new ArrangementEditorPage());
        }));
    }
    
    protected function getTitle()
    {
        return ucwords($this->layout->name)." Arranagements";
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
}

?>
