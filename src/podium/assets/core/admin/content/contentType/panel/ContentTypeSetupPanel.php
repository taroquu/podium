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
 * Modal window content panel for setup of a content type attribute
 * 
 * @author Martin Cassidy
 */
class ContentTypeSetupPanel extends \picon\Panel
{
    private $attribute;
    
    public function __construct($id, ContentTypeAttribute $attribute, $saveCallback)
    {
        parent::__construct($id);
        $this->attribute = $attribute;
        $form = new \picon\Form('form', new picon\CompoundPropertyModel($this, 'attribute'));
        $this->add($form);
        $form->add(new \picon\RequiredTextField('name'));
        $feedback = new PodiumFeedbackPanel('feedback');
        $form->add($feedback);
        $feedback->setOutputMarkupId(true);
        $form->add(new picon\AjaxButton('button', function(\picon\AjaxRequestTarget $target) use ($saveCallback, $attribute)
        {
            $saveCallback($target, $attribute);
        },
        function(\picon\AjaxRequestTarget $target) use($feedback)
        {
            $target->add($feedback);
        }));
    }
}

?>
