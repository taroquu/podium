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
 * Page for editing posts
 * 
 * @author Martin Cassidy
 */
class PostEditPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $postService;
    private $post;
    
    public $contentPanel;
    
    public function __construct(PopulatedPost $post)
    {
        parent::__construct();
        $this->post = $post;
        $this->add(new PodiumFeedbackPanel('feedback'));
        $form = new picon\Form('form', new picon\CompoundPropertyModel($this, 'post'));
        $this->add($form);
        
        $self = $this;
        $tabs = array();
        $tabs[] = new picon\Tab('Post Setup', function($id) use($post)
        {
            return new PostSetupPanel($id, $post);
        });
        $tabs[] = new picon\Tab('Content', function($id) use($post, $self)
        {
            $self->contentPanel = new ContentSetupPanel($id, $post);
            return $self->contentPanel;
        });
        
        $tabCollection = new \picon\TabCollection($tabs);
        $form->add(new \picon\StaticTabPanel('tabs', $tabCollection));
        
        
        $form->add(new picon\Button('save', function() use($self, $form)
        {
            $self->contentPanel->preProcess();
            $self->getPostService()->createOrUpdatePost($form->getModelObject());
            $self->setPage(PostListPage::getIdentifier());
        }));
        
        $form->add(new ButtonLink('cancel', function() use($self)
        {
            $self->setPage(PostListPage::getIdentifier());
        }, 'grey'));
    }
    
    public function getPostService()
    {
        return $this->postService;
    }
    
    protected function getTitle()
    {
        return "Edit Post";
    }
}

?>
