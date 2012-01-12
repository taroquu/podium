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
 * Description of CreateLayoutPage
 *
 * @author Martin
 */
class CreateLayoutPage extends AbstractAdminToolbarPage
{    
    private $layout;
    
    public function __construct($layout = null)
    {
        parent::__construct();
        
        if($layout==null)
        {
            $this->layout = new Layout();
            $self = $this;
            $onSavae = function() use ($self)
            {
                $editor = new LayoutEditorPanel('layout', $self->layout);
                $self->addOrReplace($editor);
                $editor->toolbarRender($self->getToolbar());
            };
            $this->add(new LayoutFormPanel('layout', new picon\PropertyModel($this, 'layout'), $onSavae));
        }
        else
        {
            if($layout instanceof Layout)
            {
                $this->layout = $layout;
                $this->add(new LayoutEditorPanel('layout', $this->layout));
            }
            else
            {
                throw new InvalidArgumentException('Expected instance of layout');
            }
        }
    }
    
    protected function getTitle()
    {
        return 'Create Layout';
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
