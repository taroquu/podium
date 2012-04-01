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
 * Widget panel for images
 * 
 * @author Martin Cassidy
 */
class ImageWidget extends Widget
{
    public function __construct($id, WidgetItem $item, $page = null)
    {
        parent::__construct($id, $item, $page);
        $image = new \picon\MarkupContainer('images');
        $image->add(new \picon\AttributeModifier('src', new \picon\BasicModel($item->config->path)));
        $image->add(new \picon\AttributeModifier('style', new \picon\BasicModel(sprintf('height:%dpx;width:%dpx;', $item->config->height, $item->config->width))));
        $this->add($image);
    }
}

?>
