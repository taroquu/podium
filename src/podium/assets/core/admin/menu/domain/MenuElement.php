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
 * Domain object for an element on a user defined menu
 * 
 * @author Martin Cassidy
 */
class MenuElement extends \picon\ComonDomainBase
{
    const MENU_ELEMENT_TYPE_PAGE = 'page';
    const MENU_ELEMENT_TYPE_POST = 'post';
    const MENU_ELEMENT_TYPE_EXTERNAL = 'external';
    
    private $type;
    private $page;
    private $post;
    private $externalUrl;
    private $title;
    private $id;
    
    public function __construct($id = null, $title = null, $type = null, $page = null, $post = null, $url = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
        $this->page = $page;
        $this->post = $post;
        $this->externalUrl = $url;
    }
}

?>
