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
 * Description of ThemeListPage
 * 
 * @author Martin Cassidy
 */
class ThemeListPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $themeService;
    
    public function __construct()
    {
        parent::__construct();
        $self = $this;
        $editCallback = function($id, $themeModel) use ($self)
        {
            return new LinkPanel($id, 'Edit', function() use ($self, $themeModel)
            {
                $populated = $self->getThemeService()->getTheme($themeModel->getModelObject()->id);
                $self->setPage(new CreateEditThemePage($populated));
            });
        };
        
        $deletePanelCallback = function($id, $themeModel) use ($self)
        {
            return new LinkPanel($id, 'Delete', function() use ($self, $themeModel)
            {
                $self->getThemeService()->deleteTheme($themeModel->getModelObject());
            });
        };
        
        $inUseCallback = function($id, $themeModel) use ($self)
        {
            return new InUsePanel($id, $self->getThemeService()->inUse($themeModel->getModelObject()->id));
        };
        
        $columns = array();
        $columns[] = new picon\PropertyColumn('Theme Name', 'name');
        $columns[] = new PanelColumn('In Use', $inUseCallback);
        $columns[] = new PanelColumn('', $editCallback);
        $columns[] = new PanelColumn('', $deletePanelCallback);
        
        $proivder = new ThemeDataProvider();
        $this->add(new \picon\DefaultDataTable('themes',$proivder, $columns));
        
        $this->add(new ButtonLink('newTheme', function() use ($self)
        {
            $self->setPage(new CreateEditThemePage(null));
        }));
    }
    
    protected function getTitle()
    {
        return 'Themes';
    }
    
    public function getThemeService()
    {
        return $this->themeService;
    }
}

?>
