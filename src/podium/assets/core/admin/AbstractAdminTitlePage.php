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

use picon\Label;
use picon\BasicModel;
use picon\MarkupContainer;

/**
 * Description of AbstractAdminInnerPage
 *
 * @author Martin Cassidy
 */
abstract class AbstractAdminTitlePage extends AbstractAdminPage
{
    protected function onInitialize()
    {
        parent::onInitialize();
        $this->add(new Label('title', new BasicModel($this->getTitle())));
        $seperator = new MarkupContainer('seperator');
        $seperator->setVisible($this->isSeperatorVisible());
        $this->add($seperator);
    }
    
    protected function isSeperatorVisible()
    {
        return true;
    }
    
    protected abstract function getTitle();
}

?>
