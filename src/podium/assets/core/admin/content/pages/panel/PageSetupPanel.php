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
 * Description of PageSetupPanel
 * 
 * @author Martin Cassidy
 */
class PageSetupPanel extends \picon\Panel
{
    /**
     * @Resource
     */
    private $pageService;
    
    public function __construct($id, $page)
    {
        parent::__construct($id);
        $this->add(new picon\RequiredTextField('name'));
        $pages = $this->pageService->getPagesStack();
        $this->add(new picon\DropDown('parent_page', $pages, new \picon\ChoiceRenderer(function($choice, $index)
        {
            return 'v'.$index;
        }, function($choice, $index)
        {
            return $choice->name;
        })));
        
        if($page->contentType==null)
        {
            $this->add(new SelectContentTypePanel('contentType', 'page'));
        }
        else
        {
            $this->add(new picon\EmptyPanel('contentType'));
        }
        
        $this->add(new picon\TextField('seoTitle'));
        $this->add(new picon\TextField('metaKeys'));
        $this->add(new picon\TextField('metaDescription'));
    }
}

?>