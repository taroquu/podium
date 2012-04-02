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
 * Web page to show a specified post
 * 
 * @author Martin Cassidy
 */
class PostPage extends picon\WebPage
{
    /**
     * @Resource
     */
    private $postService;
    
    public function __construct($postId)
    {
        parent::__construct();

        $post = $this->postService->getPost($postId);
        $this->add(new \picon\Label('title', new picon\BasicModel($post->name)));
        
        $view = new picon\RepeatingView('layoutBlock');
        $this->add($view);
        foreach($post->contentType->arrangement->layout->getBlocks() as $block)
        {
            $view->add(LayoutFactory::newPageLayoutBlockPanel($view->getNextChildId(), $block, $post));
        }
        
        $this->add(new ThemeStyle('style', $post->contentType->theme));
    }
    
    public function renderHead(picon\HeaderResponse $headerResponse)
    {
        parent::renderHead($headerResponse);
        $headerResponse->renderCSSFile('css/style.css');
    }
}

?>
