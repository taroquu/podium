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
 * Business service for working with submissions
 * @author Martin Cassidy
 */
interface ISubmissionService
{
    /**
     * Insert a form submission
     * @param string $formName
     * @param array $values 
     */
    function submit(Form $form, $values);
    
    
    /**
     * Get form submissions
     * @param int $start
     * @param int $count 
     * @return array
     */
    function getSubmissions($start, $count);
    
    
    /**
     * Get the total number of submissions
     * @return int
     */
    function getSubmissionSize();
    
    /**
     * Delete the given submission
     * @param Submission $submission
     */
    function delete(Submission $submission);
    
    /**
     * Get a submission by its Id
     * @param type $submissionId 
     * @return Submission
     */
    function getSubmission($submissionId);
}

?>
