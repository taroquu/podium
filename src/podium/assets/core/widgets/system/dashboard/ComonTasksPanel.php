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
 * Common tasks dashbaord panel
 * 
 * @author Martin Cassidy
 */
class ComonTasksPanel extends \picon\Panel
{
    public function __construct($id, Model $model = null)
    {
        parent::__construct($id, $model);
        $self = $this;
        $this->add(new \picon\Link('createPage', function() use ($self)
        {
            $self->setPage(CreatePage::getIdentifier());
        }));
        $this->add(new \picon\Link('createPost', function() use ($self)
        {
            $self->setPage(CreatePost::getIdentifier());
        }));
        $this->add(new \picon\Link('createType', function() use ($self)
        {
            $self->setPage(CreateEditContentTypePage::getIdentifier());
        }));
        $this->add(new \picon\Link('createForm', function() use ($self)
        {
            $self->setPage(CreateEditFormPage::getIdentifier());
        }));
    }
}

?>
