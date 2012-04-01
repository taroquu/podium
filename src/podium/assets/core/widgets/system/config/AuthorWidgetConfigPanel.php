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
 * Config panel for author widget
 * 
 * @author Martin Cassidy
 */
class AuthorWidgetConfigPanel extends AbstractWidgetSetupPanel
{
    /**
     * @Resource
     */
    private $userService;
    
    private $users;
    
    public function __construct($id, Model $model)
    {
        parent::__construct($id, $model);
        $users = $this->userService->getUsers(0, $this->userService->getUserSize());
        
        $ids = array();
        $fullusers = array();
        foreach($users as $user)
        {
            $fullusers[$user->id] = $user;
            $ids[] = $user->id;
        }
        
        $drop = new picon\DropDown('user_id', $ids, new \picon\ChoiceRenderer(function($choice, $index)
        {
            return $choice;
        }, function($choice, $index) use($fullusers)
        {
            return $fullusers[$choice]->username;
        }));
        
        $this->add($drop);
        $self = $this;
    }
    
    protected function onInitialize()
    {
        parent::onInitialize();

        if($this->getModelObject()->user_id==null)
        {
            $this->getModelObject()->user_id = $_SESSION['user']->id;
        }
    }
    
}

?>
