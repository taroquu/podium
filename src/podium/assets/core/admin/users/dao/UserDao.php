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
 * Description of UserDao
 * 
 * @author Martin Cassidy
 * @Repository
 */
class UserDao extends AbstractDao
{
    public function userExists($username)
    {
        return $this->getTemplate()->queryForInt("SELECT count(*) FROM users WHERE username = '%s';", array($username))==1;
    }
    
    public function getUserByName($username)
    {
        $mapper = new \picon\CallbackRowMapper(function($row)
        {
            return new User($row->id, $row->username, $row->password);
        });
        
        $users = $this->getTemplate()->query("SELECT * FROM users WHERE username = '%s';", $mapper, array($username));
        
        if(count($users)!=1)
        {
            throw new IllegalStateException('Expected only one result');
        }
        return $users[0];
    }
    
    public function getUsers($start, $count)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return new User($row->id, $row->username, $row->password);
        });
        
        return $this->getTemplate()->query("SELECT * FROM users LIMIT %d, %d", $mapper, array($start, $count));
    }
    
    public function getUserSize()
    {
        return $this->getTemplate()->queryForInt("SELECT count(*) FROM users;");
    }
    
    public function createUser(User $user, $password)
    {
        return $this->getTemplate()->insert("INSERT INTO users (username, password) VALUES ('%s', '%s');", array($user->username, $password));
    }
    
    public function updateUser(User $user)
    {
        $this->getTemplate()->update("UPDATE users SET username = '%s' WHERE id = %d;", array($user->username, $user->id));
    }
    
    public function updatePassword($userId, $password)
    {
        $this->getTemplate()->update("UPDATE users SET password = '%s' WHERE id = %d;", array($password, $userId));
    }
   
    public function deleteUser($userId)
    {
        $this->getTemplate()->update("DELETE FROM users WHERE id = %d;", array($userId));
    }
}

?>
