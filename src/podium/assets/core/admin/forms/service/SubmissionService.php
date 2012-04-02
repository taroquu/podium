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
 * Implementation of submission service
 * 
 * @author Martin Cassidy
 * @Service
 */
class SubmissionService implements ISubmissionService
{
    /**
     * @Resource
     */
    private $submitDao;
    
    public function submit(Form $form, $values)
    {
        $submitId = $this->submitDao->createSubmission($form->name, date('Y-m-d H:i:s'));
        
        foreach($form->fields as $field)
        {
            if(!($field instanceof ButtonField))
            {
                $value = $values[$field->name];
                if($field instanceof CheckBoxField)
                {
                    $value = $value?'Checked':'Not Checked';
                }
                elseif($field instanceof CheckGroupField)
                {
                    $value = implode(',', $value);
                }
                $this->submitDao->insertSubmissionAttribute($submitId, $field->name, $value);
            }
        }
    }

    public function getSubmissionSize()
    {
        return $this->submitDao->getSubmissionSize();
    }

    public function getSubmissions($start, $count)
    {
        return $this->submitDao->getSubmissions($start, $count);
    }

    public function getSubmission($submissionId)
    {
        $submission = $this->submitDao->getSubmission($submissionId);
        $attributes = array();
        
        foreach($this->submitDao->getSubmissionAttributes($submissionId) as $element)
        {
            $attributes[$element['name']] = $element['value'];
        }
        $submission->attributes = $attributes;
        return $submission;
    }
    
    public function delete(Submission $submission)
    {
        $this->submitDao->deleteAttributes($submission->id);
        $this->submitDao->delete($submission->id);
    }
}

?>
