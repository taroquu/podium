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
 * Description of ContentTypeListPage
 * 
 * @author Martin Cassidy
 */
class ContentTypeListPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $contentTypeService;
    
    public function __construct()
    {
        parent::__construct();
        $columns = array();
        
        $self = $this;
        $editCallback = function($id, $contentTypeModel) use ($self)
        {
            return new LinkPanel($id, 'Edit', function() use ($self, $contentTypeModel)
            {
                $populatedContentType = $self->getContentTypeService()->getContentType($contentTypeModel->getModelObject()->id);
                $self->setPage(new CreateEditContentTypePage($populatedContentType));
            });
        };
        
        $deleteCallback = function($id, $contentTypeModel) use ($self)
        {
            return new LinkPanel($id, 'Delete', function() use ($self, $contentTypeModel)
            {
                $self->getContentTypeService()->deleteContentType($contentTypeModel->getModelObject()->id);
            });
        };
        
        $inUseCallback = function($id, $contentTypeModel) use ($self)
        {
            return new InUsePanel($id, $self->getContentTypeService()->inUse($contentTypeModel->getModelObject()->id));
        };
        
        $columns[] = new \picon\PropertyColumn('Name', 'name');
        $columns[] = new \picon\PropertyColumn('Type', 'type');
        $columns[] = new PanelColumn('In Use', $inUseCallback);
        $columns[] = new PanelColumn('', $editCallback);
        $columns[] = new PanelColumn('', $deleteCallback);
        
        $provider = new ContentTypeDataProvider();
        
        $this->add(new picon\DefaultDataTable('types', $provider, $columns));
        
        $self = $this;
        $this->add(new ButtonLink('create', function() use($self)
        {
            $self->setPage(CreateEditContentTypePage::getIdentifier());
        }));
    }
    
    protected function getTitle()
    {
        return "Content Types";
    }
    
    public function getContentTypeService()
    {
        return $this->contentTypeService;
    }
}

?>
