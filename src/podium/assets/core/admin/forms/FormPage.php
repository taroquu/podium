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
 * Description of FormPage
 *
 * @author Martin Cassidy
 */
class FormPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $formService;
    
    public function __construct()
    {
        parent::__construct();
        
        $self = $this;
        $editCallback = function($id, $formModel) use ($self)
        {
            return new LinkPanel($id, 'Edit', function() use ($self, $formModel)
            {
                $populatedForm = $self->getFormService()->getPopulatedForm($formModel->getModelObject());
                $self->setPage(new CreateEditFormPage($populatedForm));
            });
        };
        
        $deleteCallback = function($id, $formModel) use ($self)
        {
            return new LinkPanel($id, 'Delete', function() use ($self, $formModel)
            {
                $self->getFormService()->deleteForm($formModel->getModelObject());
            });
        };
        
        $columns = array();
        $columns[] = new \picon\PropertyColumn('Form Name', 'name');
        $columns[] = new PanelColumn('', $editCallback);
        $columns[] = new PanelColumn('', $deleteCallback);
        
        $provider = new FormDataProvider();
        
        $this->add(new picon\DefaultDataTable('forms', $provider, $columns));
        
        $self = $this;
        $this->add(new ButtonLink('create', function() use ($self)
        {
            $self->setPage(new CreateEditFormPage(new PopulatedForm()));
        }));
    }
    
    protected function getTitle()
    {
        return 'Forms';
    }
    
    public function getFormService()
    {
        return $this->formService;
    }
}

?>
