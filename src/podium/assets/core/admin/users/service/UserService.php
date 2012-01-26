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
 * Description of UserService
 * 
 * @author Martin Cassidy
 * @Service
 */
class UserService
{
    /**
     * @Resource
     */
    private $userDao;
    
    public function userLogin($username, $password)
    {
        $encrypted = $this->encryptPassword($password);
        $user = $this->userDao->getUserByName($username);
        
        if($user->password==$encrypted)
        {
            return $user;
        }
        return false;
    }
    
    public function userExists($username)
    {
        return $this->userDao->userExists($username);
    }
    
    public function getUserByName($username)
    {
        return $this->userDao->getUserByName($username);
    }
    
    private function encryptPassword($password)
    {
        return crypt($password, '_J9..rasm');
    }
    
    public function getUsers($start, $count)
    {
        return $this->userDao->getUsers($start, $count);
    }
    
    public function getUserSize()
    {
        return $this->userDao->getUserSize();
    }
    
    public function createOrUpdateUser(User $user)
    {
        if($user->id==null)
        {
            $this->userDao->createUser($user, $this->encryptPassword($user->password));
        }
        else
        {
            $this->userDao->updateUser($user);
            
            if($user->password!='')
            {
                $this->userDao->updatePassword($user->id, $this->encryptPassword($user->password));
            }
        }
    }
    
    public function deleteUser($userId)
    {
        $this->userDao->deleteUser($userId);
    }
}

?>
