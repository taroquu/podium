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
 * Tab panel for theme heading options
 * 
 * @author Martin Cassidy
 */
class ThemeHeadingPanel extends \picon\Panel
{
    public function __construct($id)
    {
        parent::__construct($id);
        
        $this->add(new picon\ListView('headings', function(\picon\ListItem $item)
        {
            $item->setModel(new picon\CompoundPropertyModel($item->getModel()));
            $item->add(new picon\Label('headingTitle', new \picon\BasicModel('Heading '.($item->getIndex()+1))));
            $item->add(new ColourPicker('textColour'));
            $item->add(ThemeFieldFactory::newFontSize('textSize'));
            $item->add(ThemeFieldFactory::newFontWeight('weight'));
            $item->add(ThemeFieldFactory::newTextDecoration('decoration'));
        }));
    }
}

?>
