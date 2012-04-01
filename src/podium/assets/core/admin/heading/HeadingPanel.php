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
use picon\BasicModel ;
use picon\MarkupContainer;
use picon\Label;
use picon\AttributeModifier;

/**
 * Main layout panel for showing the heading at the top of the page
 *
 * @author Martin Cassidy
 */
class HeadingPanel extends Panel
{
    private $rule;
    
    public function __construct($id, $title, $showRule = true)
    {
        parent::__construct($id);
        $this->add(new AttributeModifier('class', new BasicModel('secondaryHeader')));
        $this->add(new Label('title', new BasicModel($title)));
        $this->rule = new MarkupContainer('rule');
        $this->rule->setVisible($showRule);
        $this->add($this->rule);
    }
    
    public function setRuleVisible($showRule)
    {
        $this->rule->setVisible($showRule);
    }
}

?>
