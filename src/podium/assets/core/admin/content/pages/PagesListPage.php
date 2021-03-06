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
 * Page for showing the page list
 * 
 * @author Martin Cassidy
 */
class PagesListPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $pageService;
    
    public function __construct()
    {
        parent::__construct();
        $this->add(new PodiumFeedbackPanel('feedback'));
        $pages = $this->pageService->getPages();
        $homeId = $this->pageService->getHomePageId();
        $pagePanel = new PageSetPanel('pages', $pages, $homeId);
        $this->add($pagePanel);
        
        $firstContainer = $pagePanel->getContainer();
        $firstContainer->setOutputMarkupId(true);
        $nestedSort = new \picon\DefaultJQueryUIBehaviour('nestedSortable');
        $firstContainer->add($nestedSort);
        
        $options = $nestedSort->getOptions();
        $nestedId = $firstContainer->getMarkupId();
        $options->add(new \picon\PropertyOption('handle', '.dragHandle'));
        $options->add(new \picon\PropertyOption('listType', 'ul'));
        $options->add(new \picon\PropertyOption('placeholder', 'placeholder'));
        $options->add(new \picon\BooleanOption('forcePlaceholderSize', true));
        $options->add(new \picon\PropertyOption('items', 'li'));
        $self = $this;
        $options->add(new picon\CallbackFunctionOption('update', function(picon\AjaxRequestTarget $target) use ($self)
        {
            $self->getPageService()->updateHierarchy($self->getRequest()->getParameter('page'));
        }, 'callBackURL += \'&\'+$(\'#'.$nestedId.'\').nestedSortable(\'serialize\');'));
        
        $this->add(new ButtonLink('create', function() use ($self)
        {
            $self->setPage(CreatePage::getIdentifier());
        }));
    }

    public function renderHead(picon\HeaderResponse $headerResponse)
    {
        $headerResponse->renderJavaScriptFile('js/nestedSortable.js');
        parent::renderHead($headerResponse);
    }
    
    protected function getTitle()
    {
        return 'Web Pages';
    }
    
    public function getPageService()
    {
        return $this->pageService;
    }
}

?>
