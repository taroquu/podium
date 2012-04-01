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
interface IPostService
{
    /**
     * Get an array of posts
     * @param int $start
     * @param int $count
     * @return array 
     */
    function getPosts($start, $count);
    
    /**
     * Get the total number of posts
     * @return int 
     */
    function getPostSize();
    
    /**
     * Get a post by its id
     * @param int $postId
     * @return PopulatedPost
     */
    function getPost($postId);
    
    /**
     * Prepare a post by replacing its simple domain values with
     * full populated versions
     * @param Post $post 
     */
    function preparePopulatedPost(Post $post);
    
    /**
     * Create the post if it does exist already,
     * updated otherwise
     * @param Post $post 
     */
    function createOrUpdatePost(Post $post);
    
    /**
     * Delete the given post
     * @param Post $post 
     */
    function deletePost($post);
    
    
}

?>
