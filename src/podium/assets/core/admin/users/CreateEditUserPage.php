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
 * Description of CreateEditUserPage
 * 
 * @author Martin Cassidy
 */
class CreateEditUserPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $userService;
    
    private $user;
    private $retype;
    
    public function __construct(User $user)
    {
        parent::__construct();
        
        if($user==null)
        {
            $user = new User();
        }
        $user->password = '';
        $this->user = $user;
        
        $this->add(new PodiumFeedbackPanel('feedback'));
        $form = new picon\Form('form', new \picon\CompoundPropertyModel($this, 'user'));
        $this->add($form);
        
        $username = new picon\RequiredTextField('username');
        $password = new picon\TextField('password');
        $form->add($password);
        $again = new picon\TextField('retypepassword', new picon\PropertyModel($this, 'retype'));
        $password->add(new \picon\IdenticalValueValidator($again));
        $form->add($again);
        $form->add($username);
        
        if($this->user->id!=null)
        {
            $username->setDisabled(true);
        }
        else
        {
            $password->setRequired(true);
            $again->setRequired(true);
        }
        
        $self = $this;
        $form->add(new picon\Button('save', function() use ($self)
        {
            if($self->userService->userExists($self->user->username)&&$self->user->id==null)
            {
                $self->error('The username is already in use');
            }
            else
            {
                $self->userService->createOrUpdateUser($self->user);
                $self->setPage(UserPage::getIdentifier());
            }
        }));
    }
    
    protected function getTitle()
    {
        return $this->user->id==null?'Create User':'Edit User';
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}

?>
