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
 * Feedback panel with a bit of extra css,
 * Panel hides itself if no messages are present
 * 
 * @todo get a message icon in here
 * @author Martin Cassidy
 */
class PodiumFeedbackPanel extends picon\FeedbackPanel
{
    private $style;
    public function __construct($id)
    {
        parent::__construct($id);
        $this->add(new picon\AttributeModifier('class', new \picon\BasicModel('feedbackMessage')));
        $this->add(new picon\AttributeModifier('style', new \picon\PropertyModel($this, 'style')));
    }
    
    public function beforeComponentRender()
    {
        $messages = picon\FeedbackModel::get()->getModelObject();
        if(count($messages)==0)
        {
            $this->style = 'display:none;';
        }
        else
        {
            $this->style = '';
        }
        parent::beforeComponentRender();
    }
}

?>
