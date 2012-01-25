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
 * Description of ArranagementDao
 * 
 * @author Martin Cassidy
 * @Repository
 */
class ArrangementDao extends AbstractDao
{
    public function getArrangementsForLayout($layout, $start, $count)
    {
        $mapper = new \picon\CallbackRowMapper(function($row) use ($layout)
        {
            return new Arrangement($layout, $row->name, $row->id);
        });
        return $this->getTemplate()->query('SELECT * FROM arrangement WHERE layout_id = %d LIMIT %d, %d', $mapper, array($layout->id, $start, $count));
    }
    
    public function getArrangementCount($layoutId)
    {
        return $this->getTemplate()->queryForInt('SELECT count(*) FROM arrangement WHERE layout_id = %d', array($layoutId));
    }
    
    /**
     * @todo layout should not be the id, but the full object
     * @param type $arrangementId
     * @return type 
     */
    public function getArrangement($arrangementId)
    {
        $mapper = new \picon\CallbackRowMapper(function($row) use ($layout)
        {
            return new Arrangement($row->layout_id, $row->name, $row->id);
        });
        $results = $this->getTemplate()->query('SELECT * FROM arrangement WHERE id = %d', $mapper, array($arrangementId));
        
        if(count($results)!=1)
        {
            throw new IllegalStateException('Expecting only 1 arrangement');
        }
        return $results[0];
    }
    
    public function getBlockContents($arrangementId, $blockId)
    {
        $mapper = new \picon\CallbackRowMapper(function($row)
        {
            return new WidgetItem($row->widget_id, $row->name, $row->class, $row->element_id);
        });
        return $this->getTemplate()->query('SELECT * FROM arrangement_elements a INNER JOIN widgets w ON a.widget_id = w.id WHERE a.arrangement_id = %d AND a.block_id = %d ORDER BY a.index ASC', $mapper, array($arrangementId, $blockId));
    }
    
    public function createArrangement(Arrangement $arrangement)
    {
        return $this->getTemplate()->insert("INSERT INTO arrangement (layout_id, name) VALUES (%d, '%s')", array($arrangement->layout->id, $arrangement->name));
    }
    
    public function createElement(WidgetItem $item, $blockId, $index, $arrangmentId)
    {
        return $this->getTemplate()->update('INSERT INTO arrangement_elements (arrangement_id, block_id, `index`, widget_id) VALUES (%d, %d, %d, %d);', array($arrangmentId, $blockId, $index, $item->id));
    }
    
    public function updateElement(WidgetItem $item, $blockId, $index, $arrangmentId)
    {
        return $this->getTemplate()->update('UPDATE arrangement_elements SET block_id = %d, `index` = %d WHERE element_id = %d;', array($blockId, $index, $item->elementId));
    }
    
    public function deleteElement($elementId)
    {
        $this->getTemplate()->update('DELETE FROM arrangement_elements WHERE element_id = %d;', array($elementId));
    }
}

?>
