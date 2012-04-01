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
 * Description of AuthorWidgetConfigPanel
 * 
 * @author Martin Cassidy
 */
class AuthorWidgetConfigPanel extends AbstractWidgetSetupPanel
{
    /**
     * @Resource
     */
    private $userService;
    private $chosenUser;
    private $users;
    
    public function __construct($id, Model $model)
    {
        parent::__construct($id, $model);
        $this->users = $this->userService->getUsers(0, $this->userService->getUserSize());
        
        $drop = new picon\DropDown('author', $this->users, new \picon\ChoiceRenderer(function($choice, $index)
        {
            return $choice->id;
        }, function($choice, $index)
        {
            return $choice->username;
        }), new \picon\PropertyModel($this, 'chosenUser'));
        
        $this->add($drop);
        $self = $this;
        $drop->add(new picon\AjaxFormComponentUpdateBehavior('onChange', function (picon\AjaxRequestTarget $target) use ($self)
        {
            $self->setUser();
        }));
    }
    
    protected function onInitialize()
    {
        parent::onInitialize();
        foreach($this->users as $user)
        {
            if($user->id==$this->getModelObject()->user_id)
            {
                $this->chosenUser = $user;
            }
        }
        if($this->chosenUser==null)
        {
            $this->chosenUser = $_SESSION['user'];
        }
    }
    
    public function setUser()
    {
        $this->getModelObject()->user_id = $this->chosenUser->id;
    }
}

?>
