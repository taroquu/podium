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
 * Business service for working with forms
 * @author Martin Cassidy
 */
interface IFormService
{
    /**
     * Get an array of forms
     * @param int $start
     * @param int $count
     * @return array 
     */
    function getForms($start, $count);
    
    /**
     * Get the total number of forms
     * @return int 
     */
    function getSize();
    
    /**
     * Get a full version of the form
     * @param Form $form
     * @return PopulatedForm 
     */
    function getPopulatedForm(Form $form);
    
    /**
     * Get a form by its id
     * @todo this should replace getPopulatedForm();
     * @param int $formId
     * @return PopulatedForm 
     */
    function getForm($formId);
    
    /**
     * Create the form if it does not exist,
     * update otherwise
     * @param PopulatedForm $form 
     */
    function createOrUpdate(PopulatedForm $form);
    
    /**
     * Delete a validator
     * @param AbstractValidator $validator 
     */
    function deleteValidator($validator);
    
    /**
     * Get the fields on a form
     * @param int $formId
     * @return array 
     */
    function getFields($formId);
    
    
    /**
     * Deelete the given form
     * @param Form $form 
     */
    function deleteForm(Form $form);
    
    /**
     * Attach a validator to the field
     * @param int $fieldId
     * @param AbstractValidator $validator 
     */
    function createValidator($fieldId, AbstractValidator $validator);
    
    /**
     * Delete a field
     * @param TextField $field 
     */
    function deleteField($field);
    
    /**
     * Whether or not the form is in use
     * @param int $formId
     * @return boolean
     */
    function inUse($formId);
    
    /**
     * Checks whether the form name exists, ensuring it is not itself
     * @param string $name
     * @param int $id The id of the form (if it exists)
     * @return boolean 
     */
    function checkNameExists($name, $id = null);
}

?>
