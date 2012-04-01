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
 * A text field which is designed for colour selction using the jscolor
 * script
 * Extract out the JS into a behaviour
 * @author Martin Cassidy
 */
class ColourPicker extends \picon\TextField
{
    public function __construct($id, Model $model = null)
    {
        parent::__construct($id, $model, \picon\Component::TYPE_STRING);
        picon\PiconApplication::get()->addComponentRenderHeadListener(new picon\JQueryRenderHeadListener());
        $this->setOutputMarkupId(true);
        $this->add(new picon\PatternValidator("^#?([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$"));
    }
    
    public function renderHead(picon\HeaderResponse $headerResponse)
    {
        parent::renderHead($headerResponse);
        $headerResponse->renderJavaScriptFile('js/jscolor.js');
        $script = "$(document).ready(function(){var field = document.getElementById('%s'); var colourPicker = new jscolor.color(field, {});}); ";
        $headerResponse->renderScript(sprintf($script, $this->getMarkupId()));
    }
}

?>
