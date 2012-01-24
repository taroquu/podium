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
                    return $element;
                },
                connectToSortable: '.layoutBlock ul'
            });
        });
    };
    
    
    $.fn.podiumArrangement = function() 
    {
        $(this).each(function()
        {
            $('.layoutBlock ul', this).sortable(
            {
                placeholder : 'widgetPlaceholder',
                forcePlaceholderSize : true,
                connectWith : '.layoutBlock ul',
                handle: '.dragHandle'
            });
            
            $('.layoutBlock ul li', this).each(function()
            {
                $(this).append('<div class="dragHandle blockControl" />');
                $(this).append('<div class="remove blockControl" />');
            });
        });
    };
    
})(jQuery);