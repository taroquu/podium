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
 * Widget which shows a list of posts
 * 
 * @author Martin Cassidy
 */
class PostListWidget extends Widget
{
    /**
     * @Resource
     */
    private $postService;
    
    public function __construct($id, WidgetItem $item, $page = null) 
    {
        parent::__construct($id, $item, $page);

        $self = $this;
        $this->add(new picon\ListView('post', function(\picon\ListItem $item) use ($self)
        {
            $post = $item->getModelObject();
            
            $link = new \picon\Link('postLink', function() use ($self, $post)
            {
                $self->setPage(new PostPage($post->id));
            });
            $item->add($link);
            $link->add(new \picon\Label('name', new \picon\BasicModel($post->name)));
        }, new \picon\ArrayModel($this->getPosts())));
    }
    
    public function beforeComponentRender()
    {
        parent::beforeComponentRender();
        $this->get('post')->setModelObject($this->getPosts());
    }
    
    private function getPosts()
    {
        $posts = $this->postService->getPostByContentType($this->getConfig()->content_type_id);
        
        //@todo should limit via service
        $posts = array_slice($posts, 0, $item->config->amount);
        return $posts;
    }
}

?>
