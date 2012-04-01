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

use picon\AbstractColumn;
use picon\Args;
use picon\GridItem;
use picon\Model;
use picon\Panel;
use picon\SerializableClosure;

/**
 * A column for a data table which contains a panel
 *
 * @author Martin Cassidy
 */
class PanelColumn extends AbstractColumn
{
    private $callback;
    
    public function __construct($heading, $callback)
    {
        parent::__construct($heading);
        Args::callBackArgs($callback, 2, 'callback');
        $this->callback = new SerializableClosure($callback);
    }
    
    public function populateCell(GridItem $item, $componentId, Model $model)
    {
        $callable = $this->callback;
        $panel = $callable($componentId, $model);
        
        if($panel instanceof Panel)
        {
            $item->add($panel);
        }
        else
        {
            throw new IllegalStateException('Callback for panel column must return a panel');
        }
    }
}

?>
