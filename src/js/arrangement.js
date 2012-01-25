(function($) 
{
    $.fn.podiumArrangementButton = function(settings) 
    {
        var options = $.extend( {
          width : 100,
          height : 100
        }, settings);
        
        $(this).each(function()
        {
            $(this).draggable(
            {
                helper: function()
                {
                    var $element = $('<div class="widgetPlaceholder" style="width:'+options.width+'px;height:'+options.height+'px;"/>');
                    $('body').append($element);
                    return $element;
                },
                connectToSortable: '.layoutBlock ul'
            });
        });
    };
    
    
    $.fn.podiumArrangement = function(settings) 
    {
        var options = $.extend( {
          newElement : function(blockId, widgetId, index){},
          moved : function(blockId, elementId, index){},
          removed : function(elementId) {}
        }, settings);
        
        $(this).each(function()
        {
            $('.layoutBlock ul', this).sortable(
            {
                placeholder : 'widgetPlaceholder',
                forcePlaceholderSize : true,
                connectWith : '.layoutBlock ul',
                handle: '.dragHandle',
                beforeStop: function(event, ui) 
                {
                    var blockId = $('input[type=hidden]', $(ui.item).parents('.layoutBlock')).attr('value');
                    var index = ui.item.index();
                    if(ui.item.hasClass('newItem'))
                    {
                        var widgetId = $('input[type=hidden]', ui.item).attr('value');
                        options.newElement(blockId, widgetId,index);
                    }
                    else
                    {
                        var elementId = $('input[type=hidden]', ui.item).first().attr('value');
                        options.moved(blockId, elementId, index);
                    }
                }
            });
            
            $('.layoutBlock ul li', this).each(function()
            {
                $(this).append('<div class="dragHandle blockControl" />');
                var remove = $('<div class="remove blockControl" />');
                $(this).append(remove);
                
                remove.click(function()
                {
                    var elementId = $('input[type=hidden]', $(this).parents('li').first()).first().attr('value');
                    options.removed(elementId);
                    $(this).parents('li').remove();
                });
            });
        });
    };
    
})(jQuery);