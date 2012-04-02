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
 * Database access object for submits
 * 
 * @author Martin Cassidy
 * @Repository
 */
class SubmitDao extends AbstractDao
{
    public function createSubmission($formName, $date)
    {
        return $this->getTemplate()->insert("INSERT INTO `submits` (`formName`, `date`) VALUES ('%s', '%s');", array($formName, $date));
    }
    
    public function insertSubmissionAttribute($submissionId, $name, $value)
    {
        return $this->getTemplate()->insert("INSERT INTO `submit_attributes` (`submit_id`, `name`,`value`) VALUES (%d, '%s', '%s');", array($submissionId, $name, $value));
    }
    
    public function getSubmissionSize()
    {
        return $this->getTemplate()->queryForInt("SELECT count(*) FROM submits;");
    }
    

    public function getSubmissions($start, $count)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return new Submission($row->id, $row->formName, $row->date);
        });
        return $this->getTemplate()->query("SELECT * FROM submits LIMIT %d, %d", $mapper, array($start, $count));
    }
    
    public function getSubmission($submissionId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return new Submission($row->id, $row->formName, $row->date);
        });
        $submission = $this->getTemplate()->query("SELECT * FROM submits WHERE id = %d", $mapper, array($submissionId));
        
        if(count($submission)!=1)
        {
            throw new IllegalStateException('Expected only one submission');
        }
        return $submission[0];
    }
    
    public function getSubmissionAttributes($submissionId)
    {
        $mapper = new picon\CallbackRowMapper(function($row)
        {
            return array('name' => $row->name, 'value' => $row->value);
        });
        return $this->getTemplate()->query("SELECT * FROM submit_attributes WHERE submit_id = %d", $mapper, array($submissionId));
    }
    
    public function deleteAttributes($submissionId)
    {
        $this->getTemplate()->update("DELETE FROM submit_attributes WHERE submit_id = %d", array($submissionId));
    }
    
    public function delete($submissionId)
    {
        $this->getTemplate()->update("DELETE FROM submits WHERE id = %d", array($submissionId));
    }
}

?>
