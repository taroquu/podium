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
 * Panel showing a form field on the field list of the form setup page
 * 
 * @author Martin Cassidy
 */
class FormFieldPanel extends picon\Panel
{
    public function __construct($id, \picon\ModalWindow $mw, $update, $deleteCallback, Model $model = null)
    {
        parent::__construct($id, $model);
        
        $this->add(new picon\Label('name', new \picon\BasicModel($model->getModelObject()->name)));
        
        $this->add(new \picon\AjaxLink('edit', function(picon\AjaxRequestTarget $target) use($mw, $model, $update)
        {
            $mw->setContent(FieldFactory::getSetupPanel($model->getModelObject(), $mw, $update));
            $mw->show($target);
        }));
        
        $this->add(new \picon\AjaxLink('delete', function(picon\AjaxRequestTarget $target) use($deleteCallback, $model)
        {
            $deleteCallback($target, $model->getModelObject());
        }));
    }
}

?>
