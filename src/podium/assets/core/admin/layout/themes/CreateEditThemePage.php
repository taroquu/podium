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
 * Description of CreateEditThemePage
 * 
 * @author Martin Cassidy
 */
class CreateEditThemePage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $themeService;
    
    private $theme;
    
    public function __construct($theme)
    {
        parent::__construct();
        if($theme==null)
        {
            $theme = new PopulatedTheme();
        }
        $this->theme = $theme;

        $this->add(new PodiumFeedbackPanel('feedback'));
        $form = new picon\Form('form', new picon\CompoundPropertyModel($this, 'theme'));
        $this->add($form);
        
        $tabs = array();
        $tabs[] = new picon\Tab('General', function($id)
        {
            return new ThemeGeneralPanel($id);
        });
        $tabs[] = new picon\Tab('Headings', function($id)
        {
            return new ThemeHeadingPanel($id);
        });
        $tabs[] = new picon\Tab('Links', function($id)
        {
            return new ThemeLinksPanel($id);
        });
        
        $tabCollection = new \picon\TabCollection($tabs);
        $form->add(new \picon\StaticTabPanel('tabs', $tabCollection));
        
        $self = $this;
        $form->add(new picon\Button('save', function() use($self, $form)
        {
            $self->getThemeService()->createOrUpdateTheme($self->getTheme());
            $self->setPage(ThemeListPage::getIdentifier());
        }));
    }
    
    protected function getTitle()
    {
        return 'Create Theme';
    }
    
    public function getThemeService()
    {
        return $this->themeService;
    }
    
    public function getTheme()
    {
        return $this->theme;
    }
}

?>
