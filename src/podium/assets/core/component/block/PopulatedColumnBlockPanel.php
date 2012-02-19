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
 * Description of PopulatedColumnBlockPanel
 * 
 * @author Martin Cassidy
 */
class PopulatedColumnBlockPanel extends ColumnBlockPanel
{    
    private $page;
    
    public function __construct($id, ColumnBlock $block, $cssClass, $innerClass, $includeId = false, $page = null)
    {
        $this->page = $page;
        parent::__construct($id, $block, $cssClass, $innerClass, $includeId);
    }
    
    protected function newColumnElement($id, $column, $innerClass, $includeId)
    {
        return new PopulatedLayoutBlockPanel($id, $column, $innerClass, $includeId, $this->page);
    }
}

?>
