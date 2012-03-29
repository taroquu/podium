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
 * Description of CreateUpdatePage
 * 
 * @todo this page will need to use the wizard component when it exists
 * @author Martin Cassidy
 */
class CreatePage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $pageService;
    private $page;
    private $state = 1;
    
    public function __construct()
    {
        parent::__construct();
        $this->page = new PopulatedPage(null, null, '');
        $this->add(new PodiumFeedbackPanel('feedback'));
        $form = new picon\Form('form', new picon\CompoundPropertyModel($this, 'page'));
        $this->add($form);
        
        $form->add(new PageSetupPanel('panel', $this->page));
        
        $self = $this;
        $form->add(new picon\Button('save', function() use($self, $form)
        {
            if($self->getState()==1)
            {
                $self->getPageService()->preparePopulatedPage($form->getModelObject());
                $form->addOrReplace(new ContentSetupPanel('panel',$form->getModelObject()));
                $self->setState(2);
            }
            else
            {
                $self->getPageService()->createOrUpdatePage($form->getModelObject());
                $self->setPage(PagesListPage::getIdentifier());
            }
        }));
    }
    
    public function getPageService()
    {
        return $this->pageService;
    }
    
    protected function getTitle()
    {
        return 'Create Page';
    }
    
    public function setState($newState)
    {
        $this->state = $newState;
    }
    
    public function getState()
    {
        return $this->state;
    }
}

?>
