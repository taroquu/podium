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
 * Fully populated page domain
 * 
 * @author Martin Cassidy
 */
class PopulatedPage extends Page
{
    private $arrangement;
    private $theme;
    private $seoTitle;
    private $metaKeys;
    private $metaDescription;
    
    public function __construct($id, $contentId, $name, $arrangement, $seoTitle, $metaKeys, $metaDesc)
    {
        parent::__construct($id, $contentId, $name);
        $this->arrangement = $arrangement;
        $this->seoTitle = $seoTitle;
        $this->metaKeys = $metaKeys;
        $this->metaDescription = $metaDesc;
    }
}

?>
