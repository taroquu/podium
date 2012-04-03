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
 * Data access object for posts
 * 
 * @author Martin Cassidy
 * @Repository
 */
class PostDao extends AbstractDao
{
    public function getRecords($start, $count)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return new Post($row->post_id, $row->id, $row->name);
        });
        return $this->getTemplate()->query("SELECT content.*, post.id AS post_id FROM post INNER JOIN content ON post.content_id = content.id LIMIT %d, %d", $mapper, array($start, $count));
    }
    
    public function getPostSize()
    {
        return $this->getTemplate()->queryForInt("SELECT count(*) FROM post;");
    }
    
    public function createPost(PopulatedPost $post)
    {
        return $this->getTemplate()->insert("INSERT INTO post (content_id) VALUES (%d);", array($post->contentId));
    }
    
    public function updatePost(PopulatedPost $post)
    {
        
    }
    
    public function deletePost($postId)
    {
        $this->getTemplate()->update("DELETE FROM post WHERE id = %d;", array($postId));
    }
    
    public function getPost($postId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return new Post($row->post_id, $row->id, $row->name);
        });
        
        $posts = $this->getTemplate()->query("SELECT content.*, post.id AS post_id FROM post INNER JOIN content ON post.content_id = content.id WHERE post.id = %d", $mapper, array($postId));
        
        if(count($posts)!=1)
        {
            throw new IllegalStateException('Expected only one post');
        }
        
        return $posts[0];
    }
    
    public function getPostByContentType($typeId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return new Post($row->post_id, $row->id, $row->name);
        });
        return $this->getTemplate()->query("SELECT content.*, post.id AS post_id FROM post INNER JOIN content ON post.content_id = content.id WHERE content_type_id = %d", $mapper, array($typeId));
    }
    
    public function getPostByName($name)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return new Post($row->post_id, $row->id, $row->name);
        });
        
        return $this->getTemplate()->query("SELECT content.*, post.id AS post_id FROM post INNER JOIN content ON post.content_id = content.id WHERE content.name = '%s'", $mapper, array($name));
    }
}

?>
