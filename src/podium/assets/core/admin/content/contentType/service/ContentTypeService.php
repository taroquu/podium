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
 * Description of ContentTypeService
 * 
 * @author Martin Cassidy
 * @Service
 */
class ContentTypeService implements IContentTypeService
{
    /**
     * @Resource
     */
    private $contentTypeDao;
    
    /**
     * @Resource
     */
    private $widgetService;
    
    /**
     * @Resource
     */
    private $arrangementService;
    
    /**
     * @Resource
     */
    private $themeService;
    
    public function getContentTypes($start, $count)
    {
        return $this->contentTypeDao->getContentTypes($start, $count);
    }
    
    public function getContentTypeSize()
    {
        return $this->contentTypeDao->getContentTypeSize();
    }
    
    public function getAttributes()
    {
        $attributes = $this->contentTypeDao->getAttributes();
        krsort($attributes);
        foreach($attributes as $index => $attribute)
        {
            $attributes[$index]->name = ucwords(strtolower($attribute->name));
        }
        return $attributes;
    }
    
    public function getContentType($typeId)
    {
        $type = $this->contentTypeDao->getContentType($typeId);
        $type->attributes = $this->getContentTypeAttributes($type->id);
        $type->arrangement = $this->arrangementService->getArrangement($this->contentTypeDao->getContentTypeArrangementId($typeId));
        $type->theme = $this->themeService->getTheme($this->contentTypeDao->getContentTypeThemeId($typeId));
        return $type;
    }
    
    public function getContentTypeAttributes($typeId)
    {
        $attributes = $this->contentTypeDao->getContentTypeAttributes($typeId);
        
        foreach($attributes as $attribute)
        {
            $attribute->widget = $this->widgetService->getWidget($attribute->widget);
        }
        
        return $attributes;
    }
    
    public function deleteContentType($typeId)
    {
        $type = $this->contentTypeDao->deleteContentType($typeId);
    }
    
    public function getContentTypeByType($requiredType)
    {
        $types = $this->getContentTypes(0, $this->getContentTypeSize());
        $selected = array();
        foreach($types as $type)
        {
            if($type->type==$requiredType)
            {
                array_push($selected, $type);
            }
        }
        return $selected;
    }
    
    public function createOrUpdate(PopulatedContentType $type)
    {
        if($type->id==null)
        {
            $type->id = $this->contentTypeDao->createContentType($type);
        }
        else
        {
            $this->contentTypeDao->updateContentType($type);
        }
        
        $oldType = $this->getContentType($type->id);
        
        foreach($oldType->attributes as $oldAttribute)
        {
            $found = false;
            foreach($type->attributes as $attribute)
            {
                if($attribute->attributeId==$oldAttribute->attributeId)
                {
                    $found = true;
                }
            }
            if(!$found)
            {
                $this->contentTypeDao->deleteContentTypeAttribute($oldAttribute->attributeId);
            }
        }
        
        foreach($type->attributes as $index => $attribute)
        {
            if($attribute->attributeId==null)
            {
                $this->contentTypeDao->addContentTypeAttribute($attribute, $index, $type->id);
            }
            else
            {
                $this->contentTypeDao->updateContentTypeAttribute($attribute, $index);
            }
        }
    }
    
    public function inUse($contentTypeId)
    {
        return $this->contentTypeDao->getUsingEntryCount($contentTypeId)>0;
    }
}

?>
