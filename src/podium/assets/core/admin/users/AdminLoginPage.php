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
 * Description of LoginPage
 * 
 * @author Martin Cassidy
 */
class AdminLoginPage extends \picon\WebPage
{
    /**
     * @Resource
     */
    private $userService;
    
    private $username;
    private $password;
    
    public function __construct()
    {
        parent::__construct();
        $this->add(new PodiumFeedbackPanel('feedback'));
        
        $form = new picon\Form('form');
        $this->add($form);
        
        $form->add(new picon\RequiredTextField('username', new picon\PropertyModel($this, 'username')));
        $form->add(new picon\RequiredTextField('password', new picon\PropertyModel($this, 'password')));
        
        $self = $this;
        $form->add(new \picon\Button('login', function() use ($self)
        {
            $user = $self->getUserService()->userLogin($self->username, $self->password);
            if(!$user)
            {
                $self->error('Username or password incorrect');
            }
            else
            {
                $_SESSION['user'] = $user;
                $self->setPage(AdminHomePage::getIdentifier());
            }
        }));
    }
    
    public function getUserService()
    {
        return $this->userService;
    }
    
    public function renderHead(picon\HeaderResponse $headerResponse)
    {
        parent::renderHead($headerResponse);
        $headerResponse->renderCSSFile('css/main.css');
        
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
