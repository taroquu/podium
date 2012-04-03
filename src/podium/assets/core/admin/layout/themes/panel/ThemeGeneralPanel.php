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
 * Tab panel for general theme options (theme name and page options)
 * 
 * @author Martin Cassidy
 */
class ThemeGeneralPanel extends \picon\Panel
{
    /**
     * @Resource
     */
    private $themeService;
    
    public function __construct($id, Theme $theme)
    {
        parent::__construct($id);
        $name = new picon\RequiredTextField('name');
        $self = $this;
        $name->add(new NameExistsValidator(function($name) use ($self, $theme)
        {
            return $self->getThemeService()->checkNameExists($name, $theme->id);
        }));
        $this->add($name);
        $this->add(new ColourPicker('page.background'));
        $this->add(new ColourPicker('page.fontcolour'));
        $this->add(ThemeFieldFactory::newFontSize('page.fontsize'));
    }
    
    public function getThemeService()
    {
        return $this->themeService;
    }
}

?>
