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
 * Description of LayoutFactory
 * 
 * @author Martin Cassidy
 */
class LayoutFactory
{
    public static function newLayoutBlockPanel($id, LayoutBlock $block, $editable = false)
    {
        $panel = null;
        
        if($block instanceof PopulatedLayoutBlock)
        {
            if($editable)
            {
                if($block->type==Layout::ROW_BLOCK)
                {
                    $panel = new EditablePopulatedLayoutBlockPanel($id, $block, 'rowBlock');
                }
                else if($block->type==Layout::COLUMN_BLOCK)
                {
                    $panel = new EditablePopulatedColumnBlockPanel($id, $block, 'columnBlock', 'columnElement');
                }
                else if($block->type==Layout::FLOATING_BLOCK)
                {
                    $panel = new EditablePopulatedLayoutBlockPanel($id, $block, 'floating');
                }
            }
            else
            {
                throw new NotImplementedException();
            }
        }
        else
        {
            if($block->type==Layout::ROW_BLOCK)
            {
                $class = $editable?' s':'';
                $panel = new LayoutBlockPanel($id, $block, 'rowBlock'.$class);
            }
            else if($block->type==Layout::COLUMN_BLOCK)
            {
                $class = $editable?' s e se':'';
                $panel = new ColumnBlockPanel($id, $block, '', 'columnElement'.$class);
            }
            else if($block->type==Layout::FLOATING_BLOCK)
            {
                $class = $editable?' n e s w ne nw se sw':'';
                $panel = new LayoutBlockPanel($id, $block, 'floating'.$class);
            }
        }
        return $panel;
    }
}

?>
