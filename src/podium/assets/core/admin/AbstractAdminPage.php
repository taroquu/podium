<?php

use picon\WebPage;
use picon\HeaderResponse;
use picon\ResourceReference;
use picon\Link;
use picon\ListView;
use picon\ArrayModel;
use picon\BasicModel;

/**
 * Description of AbstractAdminPage
 *
 * @author Martin Cassidy
 */
abstract class AbstractAdminPage extends WebPage
{
    public function __construct()
    {
        parent::__construct();
        $self = $this;
        $this->add(new Link('home', function() use($self)
        {
            $self->setPage(AdminHomePage::getIdentifier());
        }));
        
        $menuItems = array('dashboard', 'content', 'layout', 'forms', 'users');
        
        $this->add(new ListView('menuItem', function(picon\ListItem $item)
        {
            $entry = $item->getModelObject();
            $link = new Link('itemLink', function()
            {
            });
            $item->add($link);
            $link->add(new picon\Label('itemName', new picon\BasicModel(ucwords($entry))));
        }, new ArrayModel($menuItems)));
    }
    
    public function renderHead(HeaderResponse $headerResponse)
    {
        $headerResponse->renderCSSResourceReference(new ResourceReference('main.css', self::getIdentifier()));
    }
}

?>
