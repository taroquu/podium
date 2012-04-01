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
 * Page for editing pages
 * 
 * @author Martin Cassidy
 */
class EditPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $pageService;
    private $page;
    
    public function __construct(PopulatedPage $page)
    {
        parent::__construct();
        $this->page = $page;
        $this->add(new PodiumFeedbackPanel('feedback'));
        $form = new picon\Form('form', new picon\CompoundPropertyModel($this, 'page'));
        $this->add($form);
        
        $tabs = array();
        $tabs[] = new picon\Tab('Page Setup', function($id) use($page)
        {
            return new PageSetupPanel($id, $page);
        });
        $tabs[] = new picon\Tab('Content', function($id) use($page)
        {
            return new ContentSetupPanel($id, $page);
        });
        
        $tabCollection = new \picon\TabCollection($tabs);
        $form->add(new \picon\StaticTabPanel('tabs', $tabCollection));
        
        $self = $this;
        $form->add(new picon\Button('save', function() use($self, $form)
        {
            $self->getPageService()->createOrUpdatePage($form->getModelObject());
            $self->setPage(PagesListPage::getIdentifier());
        }));
        
        $form->add(new ButtonLink('cancel', function() use($self)
        {
            $self->setPage(PagesListPage::getIdentifier());
        }, 'grey'));
    }
    
    protected function getTitle()
    {
        return "Edit Page";
    }
    
    public function getPageService()
    {
        return $this->pageService;
    }
}

?>
