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
 * Description of PostListPage
 * 
 * @author Martin Cassidy
 */
class PostListPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $postService;
    
    public function __construct()
    {
        parent::__construct();
        
        $self = $this;
        $editCallback = function($id, $postModel) use ($self)
        {
            return new LinkPanel($id, 'Edit', function() use ($self, $postModel)
            {
                $populatedPost = $self->getPostService()->getPost($postModel->getModelObject()->id);
                $self->setPage(new PostEditPage($populatedPost));
            });
        };
        
        $deleteCallback = function($id, $postModel) use ($self)
        {
            return new LinkPanel($id, 'Delete', function() use ($self, $postModel)
            {
                $self->getPostService()->deletePost($postModel->getModelObject()->id);
            });
        };
        
        $columns = array();
        $columns[] = new picon\PropertyColumn('Post Name', 'name');
        $columns[] = new PanelColumn('', $editCallback);
        $columns[] = new PanelColumn('', $deleteCallback);
        
        $provider = new PostDataProvider();
        $this->add(new picon\DefaultDataTable('posts', $provider, $columns));
    }
    
    protected function getTitle()
    {
        return "Posts";
    }
    
    public function getPostService()
    {
        return $this->postService;
    }
}

?>
