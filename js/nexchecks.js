;(function ( $, window, document, undefined ) {
    'use strict';
	var count_click = 0;
    var pluginName = 'nexchecks',
        dataPlugin = 'plugin_' + pluginName,
        defaults = {
            label: '',
            labelPosition: 'right',
            customClass: '',
            color: 'blue'
        };
		jQuery('.the-radios a, .the-radios .input-label').live('click', 
			function(e)
				{
				e.preventDefault();
				var clickedParent = ($(this).hasClass('input-label')) ? $(this).parent().find('.clearfix') : $(this).closest('.clearfix');
				var	input = clickedParent.find('input');
				var	nexCheckable = clickedParent.find('a:first');
				if(input.prop('type') === 'radio')
					{
					$('input[name="' + input.attr('name') + '"]').each(
						function(index, el)
							{
							$(el).prop('checked', false).parent().find('a:first').removeClass('checked').removeClass($(el).closest('.the-radios').attr('data-checked-class'));
							nexCheckable.attr('class','checked fa '+ nexCheckable.closest('.the-radios').attr('data-checked-class') );
							}
						);
					}
				
					if(input.prop('checked'))
						{
						input.prop('checked', false);
						nexCheckable.attr('class','');
						} 
					else 
						{
						input.prop('checked', true);
						nexCheckable.attr('class','checked fa '+ nexCheckable.closest('.the-radios').attr('data-checked-class') );
						}	
					}		
				
			);
    var Plugin = function ( element ) {
        this.element = element;
        this.options = $.extend( {}, defaults );
    };
    Plugin.prototype = {
        init: function ( options ) {
            $.extend( this.options, options );
            var el = $(this.element);
            el.parent().addClass('has-pretty-child');
			var rerun = el.parent().find('a').length;
			if(rerun>0)
				return;
            el.css('display', 'none');
            var classType = el.data('type') !== undefined ? el.data('type') : el.attr('type');
            var label = el.data('label') !== undefined ? el.data('label') : this.options.label;
            var labelPosition = el.data('labelposition') !== undefined ? 'label' + el.data('labelposition') : 'label' + this.options.labelPosition;
            var customClass = el.data('customclass') !== undefined ? el.data('customclass') : this.options.customClass;
            var color =  el.data('color') !== undefined ? el.data('color') : this.options.color;
            var disabled = el.prop('disabled') === true ? 'disabled' : '';
            var containerClasses = ['pretty' + classType, labelPosition, customClass, color].join(' ');
            el.wrap('<div class="clearfix ' + containerClasses + '"></div>').parent().html();
            var dom = [];
            var isChecked = el.prop('checked') ? 'checked' : '';
			dom.push('<a class="fa ' + isChecked + ' ' + disabled + '"></a>');
			el.parent().append(dom.join('\n'));
        },
        enable: function () {
            $(this.element).removeAttr('disabled').parent().find('a:first').removeClass('disabled');
        },
        disable: function () {
            $(this.element).attr('disabled', 'disabled').parent().find('a:first').addClass('disabled');
        },
        destroy: function () {
            var el = $(this.element),
                clonedEl = el.clone();
            clonedEl.removeAttr('style').insertBefore(el.parent());
            el.parent().remove();
        }
    };
    $.fn[ pluginName ] = function ( arg ) {
        var args, instance;
        if (!( this.data( dataPlugin ) instanceof Plugin )) {
            this.data( dataPlugin, new Plugin( this ) );
        }
        instance = this.data( dataPlugin );
        instance.element = this;
        if (typeof arg === 'undefined' || typeof arg === 'object') {
            if ( typeof instance.init === 'function' ) {
                instance.init( arg );
            }
        } else if ( typeof arg === 'string' && typeof instance[arg] === 'function' ) {
            args = Array.prototype.slice.call( arguments, 1 );
            return instance[arg].apply( instance, args );
        } else {
            $.error('Method ' + arg + ' does not exist on jQuery.' + pluginName);
        }
    };
}(jQuery, window, document));