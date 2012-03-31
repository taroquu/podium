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
 * Description of LinksPanel
 * 
 * @author Martin Cassidy
 * @todo remove duplication with a repeating view
 */
class ThemeLinksPanel extends \picon\Panel
{
    public function __construct($id)
    {
        parent::__construct($id);
        $this->add(new ColourPicker('links.normal.fontcolour'));
        $this->add(ThemeFieldFactory::newFontSize('links.normal.fontsize'));
        $this->add(ThemeFieldFactory::newFontWeight('links.normal.weight'));
        $this->add(ThemeFieldFactory::newTextDecoration('links.normal.decoration'));
        
        $this->add(new ColourPicker('links.active.fontcolour'));
        $this->add(ThemeFieldFactory::newFontSize('links.active.fontsize'));
        $this->add(ThemeFieldFactory::newFontWeight('links.active.weight'));
        $this->add(ThemeFieldFactory::newTextDecoration('links.active.decoration'));
        
        $this->add(new ColourPicker('links.hover.fontcolour'));
        $this->add(ThemeFieldFactory::newFontSize('links.hover.fontsize'));
        $this->add(ThemeFieldFactory::newFontWeight('links.hover.weight'));
        $this->add(ThemeFieldFactory::newTextDecoration('links.hover.decoration'));
    }
}

?>
