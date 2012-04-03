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
 * Database access object for working with menus
 * 
 * @author Martin Cassidy
 * @Repository
 */
class MenuDao extends AbstractDao
{
    public function getMenu($menuId)
    {
        $mapper = function($row)
        {
            return new UserMenu($row->name, $row->id);
        };
        $menus = $this->getTemplate()->query("SELECT * FROM navigation_menu WHERE id = %d", new \picon\CallbackRowMapper($mapper), array($menuId));
        
        if(count($menus)!=1)
        {
            throw new InvalidArgumentException('Expected only 1 menu');
        }
        return $menus[0];
    }
    
    public function getMenuElements($menuId)
    {
        $mapper = function($row)
        {
            return new MenuElement($row->id, $row->title, $row->type, $row->page_id, $row->post_id, $row->url);
        };
        return $this->getTemplate()->query("SELECT * FROM navigation_menu_elements WHERE menu_id = %d", new \picon\CallbackRowMapper($mapper), array($menuId));
    }
    
    public function createMenu($name)
    {
        return $this->getTemplate()->insert("INSERT INTO navigation_menu (`name`) values('%s');", array($name));
    }
    
    public function updateMenu($name, $menuId)
    {
        return $this->getTemplate()->update("UPDATE navigation_menu SET `name` = '%s' WHERE id = %d;", array($name, $menuId));
    }
    
    public function createMenuElement($menuId, MenuElement $element)
    {
        $page = $element->type==MenuElement::MENU_ELEMENT_TYPE_PAGE?$element->page->id:'NULL';
        $post = $element->type==MenuElement::MENU_ELEMENT_TYPE_POST?$element->post->id:'NULL';
        $url = $element->type==MenuElement::MENU_ELEMENT_TYPE_EXTERNAL?sprintf("'%s'", $element->externalUrl):'NULL';
        $this->getTemplate()->insert("INSERT INTO navigation_menu_elements (`menu_id`, `title`, `type`, `page_id`, `post_id`, `url`) values(%d, '%s', '%s', %s, %s, %s);", array($menuId, $element->title, $element->type, $page, $post, $url));
    }
    
    public function clearMenuElements($menuId)
    {
        return $this->getTemplate()->update("DELETE FROM navigation_menu_elements WHERE menu_id = %d;", array($menuId));
    }
}

?>
