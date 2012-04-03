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
 * Dashboard widget for showing the system status
 * 
 * @author Martin Cassidy
 */
class StatusPanel extends \picon\Panel
{
    /**
     * @Resource
     */
    private $pageService;
    
    /**
     * @Resource
     */
    private $postService;
    
    /**
     * @Resource
     */
    private $userService;
    
    public function __construct($id, Model $model = null)
    {
        parent::__construct($id, $model);
        $this->add(new \picon\Label('posts', new picon\BasicModel($this->postService->getPostSize())));
        $this->add(new \picon\Label('pages', new picon\BasicModel($this->pageService->getPageSize())));
        $this->add(new \picon\Label('users', new picon\BasicModel($this->userService->getUserSize())));
    }
}

?>
