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
 * List page to show form submission
 * 
 * @author Martin Cassidy
 */
class SubmissionsListPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $submissionService;
    
    public function __construct()
    {
        parent::__construct();
        $this->add(new PodiumFeedbackPanel('feedback'));
        
        $self = $this;
        $viewCallback = function($id, $submitModel) use ($self)
        {
            return new LinkPanel($id, 'View', function() use ($self, $submitModel)
            {
                $self->setPage(new SubmissionDetailPage($submitModel->getModelObject()->id));
            });
        };
        
        $deleteCallback = function($id, $submitModel) use ($self)
        {
            return new LinkPanel($id, 'Delete', function() use ($self, $submitModel)
            {
                $self->getSubmissionService()->delete($submitModel->getModelObject());
                $self->success('Submission deleted successfully');
            });
        };
        
        $columns = array();
        $columns[] = new picon\PropertyColumn('Form', 'formName');
        $columns[] = new picon\PropertyColumn('Submitted On', 'date');
        $columns[] = new PanelColumn('', $viewCallback);
        $columns[] = new PanelColumn('', $deleteCallback);
        
        
        $provider = new SubmissionsDataProivder();
        $this->add(new \picon\DefaultDataTable('submissions', $provider, $columns));
    }
    
    public function getSubmissionService()
    {
        return $this->submissionService;
    }
    
    protected function getTitle()
    {
        return 'Submissions';
    }
}

?>
