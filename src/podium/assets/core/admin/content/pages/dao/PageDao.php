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
 * Description of PageDao
 * 
 * @author Martin Cassidy
 * @Repository
 */
class PageDao extends AbstractDao
{
    public function getPages($parentId = null)
    {
        if($parentId==null)
        {
            $where = 'IS NULL';
        }
        else
        {
            $where = sprintf('= %d', $parentId);
        }
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return new Page($row->id, $row->content_id, $row->name);
        });
        return $this->getTemplate()->query("SELECT page.*, content.name FROM page INNER JOIN content ON page.content_id = content.id WHERE parent_id %s ORDER BY `index` ASC;", $mapper, array($where));
    }
    
    public function updateIndex($pageId, $parentId, $index)
    {
        $this->getTemplate()->update("UPDATE page SET parent_id = %s, `index` = %d WHERE id = %d", array($parentId, $index, $pageId));
    }
    
    public function createPage(PopulatedPage $page, $index)
    {
        $parent = $page->parent_page==null?'NULL':$page->parent_page->id;
        $arrangement = $page->arrangement==null?'NULL':$page->arrangement->id;

        return $this->getTemplate()->insert("INSERT INTO page (content_id, parent_id, `index`, arrangement_id, seo_title, meta_keys, meta_desc) VALUES (%d, %s, %d, %s, '%s', '%s', '%s');", array($page->contentId, $parent, $index, $arrangement, $page->seoTitle, $page->metaKeys, $page->metaDescription));
    }
    
    public function updatePage(PopulatedPage $page)
    {
        $parent = $page->parent_page==null?'NULL':$page->parent_page->id;
        return $this->getTemplate()->update("UPDATE page SET parent_id = %s, seo_title = '%s', meta_keys = '%s', meta_desc = '%s' WHERE id = %d;", array($parent, $page->seoTitle, $page->metaKeys, $page->metaDescription, $page->id));
    }
    
    public function getLastIndex($parentId)
    {
        $where = $parentId==null?'IS NULL':sprintf('= %d', $parentId);
        return $this->getTemplate()->queryForInt("SELECT count(*) FROM page WHERE parent_id %s;", array($where));
    }
    
    public function deletePage($pageId)
    {
        $this->getTemplate()->update("DELETE FROM page WHERE id = %d;", array($pageId));
    }
    
    public function deleteChildPage($pageId)
    {
        $this->getTemplate()->update("DELETE FROM page WHERE parent_id = %d;", array($pageId));
    }
    
    public function getPage($pageId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            $page = new PopulatedPage($row->id, $row->content_id, $row->name, null, $row->seo_title, $row->meta_keys, $row->meta_desc);
            $page->parent_page = $row->parent_id;
            return $page;
        });
        $pages = $this->getTemplate()->query("SELECT page.*, content.name FROM page INNER JOIN content ON page.content_id = content.id WHERE page.id = %d;", $mapper, array($pageId));
        
        if(count($pages)!=1)
        {
            throw new IllegalStateException('Expected only one page');
        }
        return $pages[0];
    }
}

?>
