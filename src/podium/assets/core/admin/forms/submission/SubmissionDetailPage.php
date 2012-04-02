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
 * Page showing details of a form submission
 * 
 * @author Martin Cassidy
 */
class SubmissionDetailPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $submissionService;
    
    public function __construct($submitId)
    {
        parent::__construct();
        $submission = $this->submissionService->getSubmission($submitId);
        
        $this->add(new \picon\Label('form', new \picon\BasicModel($submission->formName)));
        $this->add(new \picon\Label('date', new \picon\BasicModel($submission->date)));
        
        $this->add(new picon\ListView('details', function(\picon\ListItem $item) use ($submission)
        {
            $name = $item->getModelObjectAsString();
            $item->add(new \picon\Label('name', new \picon\BasicModel($name)));
            $item->add(new \picon\Label('value', new \picon\BasicModel($submission->attributes[$name])));
        }, new \picon\ArrayModel(array_keys($submission->attributes))));
        
        $self = $this;
        $this->add(new ButtonLink('back', function() use ($self)
        {
            $self->setPage(SubmissionsListPage::getIdentifier());
        }));
    }
    

    
    protected function getTitle()
    {
        return 'View Submission';
    }
}

?>
