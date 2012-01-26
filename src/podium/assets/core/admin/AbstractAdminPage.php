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

use picon\WebPage;
use picon\HeaderResponse;
use picon\ResourceReference;
use picon\Link;
use picon\ListView;
use picon\ArrayModel;
use picon\BasicModel;
use picon\EmptyPanel;

/**
 * Description of AbstractAdminPage
 *
 * @author Martin Cassidy
 */
abstract class AbstractAdminPage extends WebPage
{
    public function __construct()
    {
        parent::__construct();
        $self = $this;
        $this->add(new Link('home', function() use($self)
        {
            $self->setPage(AdminHomePage::getIdentifier());
        }));
        
        //@todo this will need to be generated more dynamically to allow
        //modules to add menu items
        $menuItems = array();
        $menuItems[] = new MenuItem('dashboard', AdminHomePage::getIdentifier());
        
        $contentMenu = array();
        $contentMenu[] = new MenuItem('Pages', ContentPage::getIdentifier());
        $contentMenu[] = new MenuItem('Posts', ContentPage::getIdentifier());
        $contentMenu[] = new MenuItem('Create Page', ContentPage::getIdentifier());
        $contentMenu[] = new MenuItem('Create Post', ContentPage::getIdentifier());
        $contentMenu[] = new MenuItem('Content Types', ContentPage::getIdentifier());
        $menuItems[] = new MenuItem('content', ContentPage::getIdentifier(), $contentMenu);
        
        $layoutMenu = array();
        $layoutMenu[] = new MenuItem('Layouts', LayoutPage::getIdentifier());
        $layoutMenu[] = new MenuItem('Themes', LayoutPage::getIdentifier());
        $layoutMenu[] = new MenuItem('Create Layout', CreateLayoutPage::getIdentifier());
        $layoutMenu[] = new MenuItem('Create Arrangement', ArrangementEditorPage::getIdentifier());
        $layoutMenu[] = new MenuItem('Create Theme', LayoutPage::getIdentifier());
        $menuItems[] = new MenuItem('layout', LayoutPage::getIdentifier(), $layoutMenu);
        
        $formMenu = array();
        $formMenu[] = new MenuItem('view forms', FormPage::getIdentifier(), $formMenu);
        $formMenu[] = new MenuItem('create form', FormPage::getIdentifier(), $formMenu);
        $formMenu[] = new MenuItem('view submissions', FormPage::getIdentifier(), $formMenu);
        $menuItems[] = new MenuItem('forms', FormPage::getIdentifier(), $formMenu);
        
        $userMenu = array();
        $userMenu[] = new MenuItem('view users', UserPage::getIdentifier(), $userMenu);
        $userMenu[] = new MenuItem('create user', CreateEditUserPage::getIdentifier(), $userMenu);
        $menuItems[] = new MenuItem('users', UserPage::getIdentifier(), $userMenu);
        
        $self = $this;
        $this->add(new ListView('menuItem', function(picon\ListItem $item) use ($self)
        {
            $menuItem = $item->getModelObject();
            $link = new picon\Link('itemLink', function() use($self, $menuItem)
            {
                $self->setPage($menuItem->page);
            });
            $item->add($link);
            $link->add(new picon\Label('itemName', new picon\BasicModel(ucwords($menuItem->name))));
            
            $item->add(new picon\ListView('submenu', function(picon\ListItem $item) use ($self)
            {
                $menuItem = $item->getModelObject();
                $link = new picon\Link('itemLink', function() use($self, $menuItem)
                {
                    $self->setPage($menuItem->page);
                });
                $item->add($link);
                $link->add(new picon\Label('itemName', new picon\BasicModel(ucwords($menuItem->name))));
            }, new picon\ArrayModel($menuItem->subMenu)));
        }, new ArrayModel($menuItems)));
        
        $this->add(new Link('logout', function() use ($self)
        {
            $_SESSION['user'] = null;
            $self->setPage(AdminHomePage::getIdentifier());
        }));
    }
    
    protected function onInitialize()
    {
        parent::onInitialize();
        $this->add($this->getSecondaryHead('secondaryHeader'));
    }
    
    protected function getSecondaryHead($id)
    {
        $panel = new EmptyPanel($id);
        $panel->setVisible(false);
        return $panel;
    }
    
    public function renderHead(HeaderResponse $headerResponse)
    {
        parent::renderHead($headerResponse);
        $headerResponse->renderCSSFile('css/main.css');
    }
}

?>
