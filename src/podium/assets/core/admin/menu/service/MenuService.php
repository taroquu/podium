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
 * Implementation of the the menu service
 * 
 * @author Martin Cassidy
 * @Service
 */
class MenuService implements IMenuService
{
    /**
     * @Resource
     */
    private $postService;
    
    /**
     * @Resource
     */
    private $pageService;
    
    /**
     * @Resource
     */
    private $menuDao;

    public function createOrUpdateMenu(UserMenu $menu)
    {
        if($menu->id==null)
        {
            $menu->id = $this->menuDao->createMenu($menu->name);
        }
        else
        {
            $this->menuDao->updateMenu($menu->name, $menu->id);
            $this->menuDao->clearMenuElements($menu->id);
        }
        
        foreach($menu->elements as $element)
        {
            $this->menuDao->createMenuElement($menu->id, $element);
        }
    }
    
    public function getMenu($menuId)
    {
        $menu = $this->menuDao->getMenu($menuId);
        $menu->elements = $this->menuDao->getMenuElements($menuId);
        
        foreach($menu->elements as $element)
        {
            $element->page = $element->page==null?null:$this->pageService->getPage($element->page);
            $element->post = $element->post==null?null:$this->postService->getPost($element->post);
        }
        return $menu;
    }
}

?>
