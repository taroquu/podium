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
 * A widget which shows a menu of links for navigation to pages, posts or
 * external sites
 * 
 * @author Martin Cassidy
 */
class NavigationMenuWidget extends Widget
{
    /**
     * @Resource
     */
    private $menuService;
    
    public function __construct($id, WidgetItem $item, $page = null)
    {
        parent::__construct($id, $item, $page);
        $config = $this->getConfig();
        $menuId = $config->menu_id;
        if($menuId==null)
        {
            $menu = new UserMenu();
        }
        else
        {
            $menu = $this->menuService->getMenu($menuId);
        }
        
        
        $style = $config->orientation==0?'':'float:left;padding-left:5px;';
        $self = $this;
        $this->add(new picon\ListView('element', function(picon\ListItem $item) use ($self, $style)
        {
            $element = $item->getModelObject();
            $item->add(new \picon\AttributeModifier('style', new picon\BasicModel($style)));
            $link = new \picon\Link('link', function() use ($element, $self)
            {
                switch($element->type)
                {
                    case MenuElement::MENU_ELEMENT_TYPE_EXTERNAL:
                        $self->getRequestCycle()->addTarget(new picon\RedirectRequestTarget('http://'.$element->externalUrl));
                        break;
                    case MenuElement::MENU_ELEMENT_TYPE_PAGE:
                        $self->setPage(new FrontPage($element->page->id));
                        break;
                    case MenuElement::MENU_ELEMENT_TYPE_POST:
                        $self->setPage(new PostPage($element->post->id));
                        break;
                }
            });
            $item->add($link);
            $link->add(new \picon\Label('title', new picon\BasicModel($element->title)));
        }, new picon\ArrayModel($menu->elements)));
    }
}

?>
