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
 * Page for creating a post
 * 
 * @author Martin Cassidy
 */
class CreatePost extends AbstractAdminTitlePage
{
    private $post;
    private $state = 1;
    
    /**
     * @Resource
     */
    private $postService;
    
    public function __construct()
    {
        parent::__construct();
        $this->post = new PopulatedPost();
        $this->add(new PodiumFeedbackPanel('feedback'));
        $form = new picon\Form('form', new picon\CompoundPropertyModel($this, 'post'));
        $this->add($form);
        
        $form->add(new PostSetupPanel('panel', $this->post));
        
        $self = $this;
        $form->add(new picon\Button('save', function() use($self, $form)
        {
            if($self->getState()==1)
            {
                $self->getPostService()->preparePopulatedPost($form->getModelObject());
                $form->addOrReplace(new ContentSetupPanel('panel', $form->getModelObject()));
                $self->setState(2);
            }
            else
            {
                $form->get('panel')->preProcess();
                $self->getPostService()->createOrUpdatePost($form->getModelObject());
                $self->setPage(PostListPage::getIdentifier());
            }
        }));
        
        $form->add(new ButtonLink('cancel', function() use($self)
        {
            $self->setPage(PostListPage::getIdentifier());
        }, 'grey'));
    }
    
    protected function getTitle()
    {
        return "Create Post";
    }
    
    public function setState($newState)
    {
        $this->state = $newState;
    }
    
    public function getState()
    {
        return $this->state;
    }
    
    public function getPostService()
    {
        return $this->postService;
    }
}

?>
