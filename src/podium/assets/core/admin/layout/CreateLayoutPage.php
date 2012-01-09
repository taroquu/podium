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
 * Description of CreateLayoutPage
 *
 * @author Martin
 */
class CreateLayoutPage extends AbstractAdminToolbarPage
{
    public function __construct()
    {
        parent::__construct();
        
        $layout = new Layout();
        
        //Adding some dummy data to get going...
        $row = new RowBlock();
        $row->height = 60;
        
        $layout->addBlock($row);
        
        $floating = new FloatingBlock();
        $floating->top = 50;
        $floating->left = 80;
        
        $layout->addBlock($floating);
        
        $colBlock = new ColumnBlock();
        $col1 = new ColumnElement();
        $col1->width = 90;
        $col1->height = 60;
        
        $colBlock->addColumn($col1);
        $col2 = new ColumnElement();
        $col2->width = 40;
        $col2->height = 60;
        
        $colBlock->addColumn($col2);
        
        $layout->addBlock($colBlock);
        
        $this->add(new LayoutEditorPanel('layout', $layout));
    }
    
    protected function getTitle()
    {
        return 'Create Layout';
    }
}

?>
