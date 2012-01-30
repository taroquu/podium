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
 * Description of AbstractWidgetSetupPanel
 * 
 * @author Martin Cassidy
 */
class AbstractWidgetSetupPanel extends picon\Panel
{
    private $form;
    private $config;
    
    public function __construct($id, \picon\ModalWindow $mw, $updateComponent, Model $model = null)
    {
        parent::__construct($id, $model);
        $this->config = $model->getModelObject();
        $this->form = new \picon\Form('form', new picon\CompoundPropertyModel($this, 'config'));
        $this->add($this->form);
        $this->form->add(new \picon\AjaxButton('save', function(\picon\AjaxRequestTarget $target) use ($mw, $updateComponent)
        {
            $mw->hide($target);
            $target->add($updateComponent);
        }));
    }
    
    protected function getForm()
    {
        return $this->form;
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
