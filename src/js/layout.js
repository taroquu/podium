$.ui.plugin.add("draggable", "connectToSortable", 
{
    drag: function(event, ui) 
    {
        var inst = $(this).data("draggable"), self = this;

        var checkPos = function(o) 
        {
            var dyClick = this.offset.click.top, dxClick = this.offset.click.left;
            var helperTop = this.positionAbs.top, helperLeft = this.positionAbs.left;
            var itemHeight = o.height, itemWidth = o.width;
            var itemTop = o.top, itemLeft = o.left;

            return $.ui.isOver(helperTop + dyClick, helperLeft + dxClick, itemTop, itemLeft, itemHeight, itemWidth);
        };
        
        var wasOver = function(instance, inst)
        {
            //If it doesn't intersect with the sortable, and it intersected before,
            //we fake the drag stop of the sortable, but make sure it doesn't remove the helper by using cancelHelperRemoval
            if(instance.isOver) 
            {
                instance.isOver = 0;
                instance.cancelHelperRemoval = true;

                //Prevent reverting on this forced stop
                instance.options.revert = false;

                // The out event needs to be triggered independently
                instance._trigger('out', event, instance._uiHash(instance));

                instance._mouseStop(event, true);
                instance.options.helper = instance.options._helper;

                //Now we remove our currentItem, the list group clone again, and the placeholder, and animate the helper back to it's original size
                instance.currentItem.remove();
                if(instance.placeholder) instance.placeholder.remove();

                inst._trigger("fromSortable", event);
                inst.dropped = false; //draggable revert needs that
            }
        };
        
        var intersections = new Array();
        $.each(inst.sortables, function(i) 
        {
            //Copy over some variables to allow calling the sortable's native _intersectsWith
            this.instance.positionAbs = inst.positionAbs;
            this.instance.helperProportions = inst.helperProportions;
            this.instance.offset.click = inst.offset.click;

            if(this.instance._intersectsWith(this.instance.containerCache)) 
            {
                intersections.push(this.instance);
            }
            else
            {
                wasOver(this.instance, inst);
            }
        });
        
        var onIntersection = function(instance, ui, inst)
        {
            //If it intersects, we use a little isOver variable and set it once, so our move-in stuff gets fired only once
            if(!instance.isOver) 
            {
                instance.isOver = 1;
                //Now we fake the start of dragging for the sortable instance,
                //by cloning the list group item, appending it to the sortable and using it as inst.currentItem
                //We can then fire the start event of the sortable with our passed browser event, and our own helper (so it doesn't create a new one)
                instance.currentItem = $(self).clone().removeAttr('id').appendTo(instance.element).data("sortable-item", true);
                instance.options._helper = instance.options.helper; //Store helper option to later restore it
                instance.options.helper = function() {return ui.helper[0];};

                event.target = instance.currentItem[0];
                instance._mouseCapture(event, true);
                instance._mouseStart(event, true, true);

                //Because the browser event is way off the new appended portlet, we modify a couple of variables to reflect the changes
                instance.offset.click.top = inst.offset.click.top;
                instance.offset.click.left = inst.offset.click.left;
                instance.offset.parent.left -= inst.offset.parent.left - instance.offset.parent.left;
                instance.offset.parent.top -= inst.offset.parent.top - instance.offset.parent.top;

                inst._trigger("toSortable", event);
                inst.dropped = instance.element; //draggable revert needs that
                //hack so receive/update callbacks work (mostly)
                inst.currentItem = inst.element;
                instance.fromOutside = inst
            }

            //Provided we did all the previous steps, we can fire the drag event of the sortable on every draggable drag, when it intersects with the sortable
            if(instance.currentItem) instance._mouseDrag(event);
        }
        
        if(intersections.length==1)
        {
            onIntersection(intersections[0], ui, inst);
        }
        else
        {
            var columnBlock = new Array();
            var layoutBlock = new Array(); //should be only one
            for(var i = 0; i < intersections.length;i++)
            {
                if(intersections[i].widget().hasClass('horizontal'))
                {
                    columnBlock.push(intersections[i]);
                }
                else
                {
                    layoutBlock.push(intersections[i]);
                }
            }
            var done = false;
            for(i = 0; i < columnBlock.length;i++)
            {
                if(columnBlock[i]._intersectsWithPointer(columnBlock[i].containerCache))
                {
                    done = true;
                    onIntersection(intersections[i], ui, inst);
                    if(layoutBlock.length>0)
                    {
                        wasOver(layoutBlock[0], inst);
                    }
                }
                else
                {
                    if(columnBlock[i].isOver)
                    {
                        wasOver(columnBlock[i], inst);
                    }
                }
            }
            
            if(!done && layoutBlock.length>0)
            {
                onIntersection(layoutBlock[0], ui, inst);
            }

        }
    }
});

var cleanup = function()
{
    $('.layoutEditor li.columnBlock ul').each(function()
    {
        if($('li', $(this)).length==0)
        {
            $(this).closest('li').remove();
        }
    });
}

var placeHolderElement = function(item)
{
    var placeholder = $('<li class="panelPlaceholder"></li>');
    placeholder.css('height', item.height());
    placeholder.css('width', item.width());

    if(item.parents('.columnBlock'))
    {
        placeholder.addClass('columnElement');
    }
    if(item.hasClass('createRow'))
    {
        placeholder.css('height', '50px');
        placeholder.css('width', '100%');
    }
    if(item.hasClass('createColumn'))
    {
        placeholder.css('width', '50px');
        placeholder.css('height', $('.newColum').height());
    }
    return placeholder;
};

var placeHolderUpdate = function(container, p)
{
    if(container.element.hasClass('createColumn'))
    {
        placeholder.css('height', $('.newColum').height());
    }
    return;
};

var serialize = function(block)
{
    var getType = function (object)
    {
        if(object.hasClass('rowBlock')) return 'rowBlock';
        else if(object.hasClass('columnBlock')) return 'columnBlock';
        else if(object.hasClass('columnElement')) return 'columnElement';
        else if(object.hasClass('floating')) return 'floatingBlock';
    };
    
    var appendCSS = function(object, str, prepend)
    {
        var css = $(object).attr('style');
        var attributes = css.split(';');
        for(var i = 0; i < attributes.length; i++)
        {
            if(attributes[i]!="")
            {
                var value = attributes[i].split(':');
                str.push(prepend+'[attributes]['+value[0]+']='+value[1]);
            }
        }
    }
    
    var str = [];
    $(block).children('li').each(function()
    {
        var type = getType($(this));
        var index = $(block).children('li').index($(this));
        str.push('blocks['+index+'][type]='+type);
        var blockId = $('input[type=hidden]', this).first().attr('value');
        str.push('blocks['+index+'][id]='+ (blockId==undefined?'':blockId));
        appendCSS(this, str, 'blocks['+index+']');
        
        var item = $('ul', $(this));
        $(item).children('li').each(function()
        {
            var innerIndex = $(item).children('li').index($(this));
            str.push('blocks['+index+'][children]['+innerIndex+'][type]='+getType($(this)));
            appendCSS(this, str, 'blocks['+index+'][children]['+innerIndex+']');
        });
    });
    return str.join('&');
};

(function($) 
{
    $.fn.layoutBlock = function(settings)
    {
        var options = $.extend( {
          'updated' : function(data){ }
        }, settings);
        
       $(this).each(function()
       {
           var status = jQuery.data($(this), 'status');

            if(status==null)
            {
                var available = new Array('n', 's', 'e', 'w', 'nw', 'sw', 'ne', 'se');
                var handles = '';
                for(var i = 0; i < available.length; i++)
                {
                    if($(this).hasClass(available[i]))
                    {
                        handles += available[i]+',';
                    }
                }
                if(handles.charAt(handles.length-1)==',')
                {
                    handles = handles.substr(0,handles.length-1);
                }
                if(handles!='')
                {
                    $(this).resizable({ 
                        handles: handles, 
                        autoHide: true, 
                        start : function(event, ui)
                        {
                            var columnBlock = $(this).parents('.columnBlock');
                            if(columnBlock.length > 0)
                            {
                                var totalWidth = 0;
                                $('.columnElement', columnBlock).each(function()
                                {
                                    totalWidth += $(this).outerWidth(true);
                                });
                                totalWidth -= $(this).width();
                                $(this).resizable("option" , 'maxWidth' , columnBlock.outerWidth(true)-totalWidth);
                            }
                        },
                        resize: function(event, ui) 
                        {
                            var columnBlock = $(this).parents('.columnBlock');
                            if(columnBlock.length > 0)
                            {
                                columnBlock.css('height', ui.size.height+'px');
                                $('.columnElement', columnBlock).css('height', ui.size.height+'px');
                            }
                        },
                        stop: function(event, ui) 
                        { 
                            if(!$(this).hasClass('floating'))
                            {
                                $(this).css('top', '');
                                $(this).css('left', '');
                            }
                            options.updated(serialize($(this).parents('ul.vertical')));
                        }
                    });
                }
                $(this).append('<div class="dragHandle blockControl"><img src="images/move.png" class="dragger" /></div>');
                $(this).append('<div class="remove blockControl"><img src="images/delete.png" /></div>');
                $('.remove', $(this)).click(function()
                {
                    var parent = $(this).parents('ul.vertical');
                    $(this).parent().remove();
                    options.updated(serialize(parent));
                    cleanup();
                });
                jQuery.data(this, 'status', true);
                
                //add horizontal sorting
                $('ul.horizontal', $(this)).sortable(
                {
                    opacity : 0.5,
                    handle: '.dragHandle',
                    placeholder: 
                    {
                        element: placeHolderElement,
                        update: placeHolderUpdate
                    },
                    revert: true,
                    sort : function(event, ui)
                    {
                        if(ui.helper)
                        {
                            ui.helper.css('height', ui.placeholder.parents('.columnBlock').height()+'px');
                        }
                        ui.placeholder.css('height', ui.placeholder.parents('.columnBlock').height()+'px');
                    },
                    beforeStop : function(event, ui)
                    {
                        if (ui.item.hasClass("new")) 
                        {
                            var $newItem = $('<li/>');
                            $newItem.insertBefore(ui.item);

                            $newItem.attr('class', 'layoutBlock columnElement s e se');
                            $newItem.css('width', '50px');
                            $newItem.css('height', $newItem.parents('.columnBlock').height()+'px');
                            $newItem.layoutBlock(options);
                        }
                        else
                        {
                            ui.item.css('height', ui.item.parents('.columnBlock').height()+'px');
                        }
                        cleanup();
                    },
                    stop: function(event, ui)
                    {
                        if (ui.item.hasClass("new")) 
                        {
                            ui.item.remove();
                        }
                        else
                        {
                            ui.item.css('height', ui.item.parents('.columnBlock').height()+'px');
                        }
                        cleanup();
                        options.updated(serialize($(this).parents('ul.vertical')));
                    },
                    connectWith: 'ul.horizontal'
                });
                if($(this).hasClass('floating'))
                {
                    $(this).draggable(
                    {
                        handle: '.dragHandle',
                        containment: '.layoutEditor',
                        stop : function(event, ui)
                        {
                            options.updated(serialize($(this).parents('ul.vertical')));
                        }
                    });
                }
            }
        });
    }

    $.fn.podiumLayout = function(settings) 
    {
        var options = $.extend( {
          'updated' : function(data){}
        }, settings);

       $(this).each(function()
       {
            //Force the layout editor to be the full height available
            if($(this).height()<$(window).height()-$(this).offset().top)
            {
                $(this).css('height', ($(window).height()-$(this).offset().top) + 'px')
            }

            $('.floating', $(this)).each(function()
            {
                $(this).draggable(
                {
                    handle: '.dragHandle',
                    containment: '.layoutEditor'
                });
            });

            //Create new row button
            $( ".createRow" ).draggable({
                connectToSortable: ".layoutEditor ul.vertical",
                helper: function()
                {
                    var $element = $('<li class="newRow" style="height:50px;width:100%;"/>');
                    return $element;
                },
                zIndex:50
            });

            //Create new column button
            $( ".createColumn" ).draggable({
                connectToSortable: ".layoutEditor ul",
                helper: function()
                {
                    var $element = $('<li class="newColum" style="height:50px;width:50px;"/>');
                    return $element;
                },
                revert: "invalid",
                zIndex:50
            });

            //Create new floating block
            $( ".createFloating" ).draggable({
                helper: function()
                {
                    var $element = $('<li class="newColum" style="height:50px;width:50px;"/>');
                    return $element;
                },
                revert: "invalid",
                zIndex:50,
                start : function()
                {
                    $('.layoutEditor').droppable( "enable" )
                },
                stop : function()
                {
                    $('.layoutEditor').droppable( "disable" )
                    $('.layoutEditor').removeClass('ui-droppable-disabled');
                    $('.layoutEditor').removeClass('ui-state-disabled');
                }
            });

            $(this).droppable(
            {
                disabled: true,
                drop: function( event, ui ) 
                {
                    $newFloating = $('<li class="layoutBlock floating n e s w ne nw se sw"/>');
                    $('ul.vertical', $(this)).append($newFloating)
                    $newFloating.css('height', '50px');
                    $newFloating.css('width', '50px');
                    $newFloating.css('top', ui.helper.css('top'));
                    $newFloating.css('left', ui.helper.css('left'));
                    options.updated(serialize($('ul.vertical', $(this))));
                    $newFloating.layoutBlock(options);
                }
            });

            //Add verticle sorting
            $('ul.vertical').sortable(
            {
                opacity : 0.5,
                handle: '.dragHandle',
                placeholder: 
                {
                    element: placeHolderElement,
                    update: placeHolderUpdate
                },
                cancel: 'li.columnElement,li.floating',
                revert: true,
                beforeStop: function(event, ui)
                {
                    if (ui.item.hasClass("new")) 
                    {
                        var $newItem = $('<li/>');
                        $newItem.insertBefore(ui.item);
                        if(ui.item.hasClass('createRow'))
                        {
                            $newItem.attr('class', 'layoutBlock rowBlock s');
                            $newItem.css('height', '50px');
                        }
                        if(ui.item.hasClass('createColumn'))
                        {
                            $newItem.attr('class', 'layoutBlock columnElement s e se');
                            $newItem.css('width', '50px');
                            $newItem.css('height', ui.placeholder.height());
                            $newItem.wrap('<li class="layoutBlock columnBlock" />');
                            $newItem.wrap('<ul class="horizontal" />');
                            $newItem.parent().parent().layoutBlock(options);
                            $newItem.parents('.columnBlock').css('height', ui.placeholder.height());
                        }
                        $newItem.layoutBlock(options);
                    }
                },
                stop : function(event, ui)
                {
                    if (ui.item.hasClass("new")) 
                    {
                        ui.item.remove();
                    }
                    options.updated(serialize($(this)));
                }
            });

            $('ul', $(this)).disableSelection();

            $('.layoutBlock', $(this)).layoutBlock(options);
       });
    };

})(jQuery);
