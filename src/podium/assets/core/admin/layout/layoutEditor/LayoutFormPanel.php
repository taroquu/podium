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

use picon\Panel;
use picon\Form;

/**
 * Description of LayoutFormPanel
 *
 * @author Martin
 */
class LayoutFormPanel extends Panel
{
    private $layout;
    
    public function __construct($id, Model $model, $onSubmit)
    {
        parent::__construct($id, $model);
        $this->add(new PodiumFeedbackPanel('feedback'));
        $this->layout = $model->getModelObject();
        $form = new Form('form', new picon\CompoundPropertyModel($this, 'layout'));
        $this->add($form);
        $name = new picon\TextField('name');
        $name->setRequired(true);
        $form->add($name);
        $self = $this;
        $form->add(new \picon\Button('submit', function() use ($onSubmit, $self)
        {
            $onSubmit();
        },
        function()
        {
        }));
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}

?>
