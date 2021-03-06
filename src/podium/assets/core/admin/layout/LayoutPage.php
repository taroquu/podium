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
 * Page for listing layouts
 *
 * @author Martin Cassidy
 */
class LayoutPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $layoutService;
    
    public function __construct()
    {
        parent::__construct();
        $this->add(new PodiumFeedbackPanel('feedback'));
        
        $self = $this;
        $panelCallback = function($id, $layoutModel) use ($self)
        {
            return new LinkPanel($id, 'Edit', function() use ($self, $layoutModel)
            {
                $self->setPage(new CreateLayoutPage($layoutModel->getModelObject()));
            });
        };
        
        $arranagementPanelCallback = function($id, $layoutModel) use ($self)
        {
            return new LinkPanel($id, 'Arranagements', function() use ($self, $layoutModel)
            {
                $self->setPage(new ArrangementPage($layoutModel->getModelObject()));
            });
        };
        
        $deletePanelCallback = function($id, $layoutModel) use ($self)
        {
            return new LinkPanel($id, 'Delete', function() use ($self, $layoutModel)
            {
                $layout = $layoutModel->getModelObject();
                if($self->getLayoutService()->inUse($$layout->id))
                {
                    $self->error($layout->name.' cannot be deleted because it is in use');
                    return;
                }
                $self->getLayoutService()->delete($layout);
                $self->success($layout->name.' deleted successfully');
            });
        };
        
        $inUseCallback = function($id, $layoutModel) use ($self)
        {
            return new InUsePanel($id, $self->getLayoutService()->inUse($layoutModel->getModelObject()->id));
        };
        
        $columns = array();
        $columns[] = new picon\PropertyColumn('Layout Name', 'name');
        $columns[] = new PanelColumn('', $arranagementPanelCallback);
        $columns[] = new PanelColumn('In Use', $inUseCallback);
        $columns[] = new PanelColumn('', $panelCallback);
        $columns[] = new PanelColumn('', $deletePanelCallback);
        
        $proivder = new LayoutDataProvider();
        $this->add(new \picon\DefaultDataTable('layouts',$proivder, $columns));
        
        $this->add(new ButtonLink('newLayout', function() use ($self)
        {
            $self->setPage(CreateLayoutPage::getIdentifier());
        }));
    }
    
    protected function getTitle()
    {
        return 'Layouts';
    }
    
    public function getLayoutService()
    {
        return $this->layoutService;
    }
}

?>
