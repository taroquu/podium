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
 *
 * @author Martin Cassidy
 */
interface IUserService
{
    /**
     * Validate the user login credentials
     * @return boolean true if the credentials were valid
     */
    function userLogin($username, $password);
    
    /**
     * Get an array of users
     */
    function getUsers($start, $count);
    
    /**
     * Get the total amount of users
     * @return int
     */
    function getUserSize();
    
    /**
     * @return boolean true if the usernam exists
     */
    function userExists($username);
    
    /**
     * Get a user by username
     * @return User the user
     */
    function getUserByName($username);
    
    /**
     * Create the user if it does not exist already,
     * updated otherwise
     */
    function createOrUpdateUser(User $user);
    
    /**
     * Delete the user
     * @param int $userId The userid to delete
     */
    function deleteUser($userId);
    
    /**
     * Retreive a user by their id
     * @param int $userId The id to look for
     */
    function getUserById($userId);
}

?>
