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
 * Page for listing users
 *
 * @author Martin Cassidy
 */
class UserPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $userService;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->add(new PodiumFeedbackPanel('feedback'));
        
        $self = $this;
        
        $editCallback = function($id, $userModel) use ($self)
        {
            return new LinkPanel($id, 'Edit', function() use ($self, $userModel)
            {
                $self->setPage(new CreateEditUserPage($userModel->getModelObject()));
            });
        };
        
        $deleteCallback = function($id, $userModel) use ($self)
        {
            return new LinkPanel($id, 'Delete', function() use ($self, $userModel)
            {
                if($_SESSION['user']->id==$userModel->getModelObject()->id)
                {
                    $self->error('You cannot delete your own user whilst you are logged in');
                }
                else
                {
                    $self->getUserService()->deleteUser($userModel->getModelObject()->id);
                    $self->success('User delete successfully');
                }
            });
        };
        
        $columns = array();
        $columns[] = new \picon\PropertyColumn('Username', 'username');
        $columns[] = new PanelColumn('', $editCallback);
        $columns[] = new PanelColumn('', $deleteCallback);
        
        $provider = new UserDataProvider();
        
        $this->add(new picon\DefaultDataTable('users', $provider, $columns));
        
        $this->add(new ButtonLink('create', function() use ($self)
        {
            $self->setPage(new CreateEditUserPage(new User()));
        }));
    }
    
    protected function getTitle()
    {
        return 'Users';
    }
    
    public function getUserService()
    {
        return $this->userService;
    }
}

?>
