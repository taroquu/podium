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
 * The dashboard page
 * @author Martin Cassidy
 * @Path(path='admin')
 */
class AdminHomePage extends AbstractAdminPage
{
    public function __construct()
    {
        parent::__construct();
        $cols = array(array('Common Tasks' => ComonTasksPanel::getIdentifier()), array('System Status' => StatusPanel::getIdentifier()));
        
        $columns = new \picon\RepeatingView('col');
        $this->add($columns);
        
        foreach($cols as $name => $elements)
        {
            $container = new \picon\RepeatingView($columns->getNextChildId());
            $columns->add($container);
            
            foreach($elements as $title => $element)
            {
                $wrapper = new DashbaordWidgetBox($container->getNextChildId(), $title);
                $container->add($wrapper);
                $panelClass = $element->getFullyQualifiedName();
                $wrapper->add(new $panelClass('content'));
            }

        }
    }
}

?>
