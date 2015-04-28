jQuery(document).ready(
function()
	{
	jQuery('.collapse').collapse();
	create_droppable(jQuery('div.nex-forms-container'));
	jQuery('.draggable_object .form-control').live('click',
		function()
			{
			var clone_element = jQuery(this).closest('.form_field ').clone();
			jQuery('div.nex-forms-container').append(clone_element);
			setup_form_element(clone_element);
			}
		);
	
	});

function setup_form_element(obj){
	jQuery('div.nex-forms-container').find('div.draggable_object').hide();
	jQuery('div.nex-forms-container').find('div.form_object').show();
	jQuery('div.nex-forms-container').find('div.form_field').removeClass('field');
	obj.attr('style','');
	obj.removeClass('field');
	obj.css('display','block');
	
	jQuery('div.nex-forms-container').find('.bs-tooltip').tooltip();

	if(obj.hasClass('text') || obj.hasClass('textarea'))
		obj.find('.the_input_element').val(obj.find('.the_input_element').attr('data-default-value'));
					
	if(obj.hasClass('grid'))
		{
		var panel = obj.find('.panel-body');
		create_droppable(panel)
		}
	if(obj.hasClass('datetime'))
		{
		obj.find('#datetimepicker').datetimepicker();	
		}
	if(obj.hasClass('date'))
		{
		obj.find('#datetimepicker').datetimepicker( { pickTime:false } );	
		}
	if(obj.hasClass('time'))
		{
		obj.find('#datetimepicker').datetimepicker( { pickDate:false });
		}
	
	if(obj.hasClass('touch_spinner'))
		{
		var the_spinner = obj.find("#spinner");
		the_spinner.TouchSpin({
			initval: parseInt(the_spinner.attr('data-starting-value')),
			min:  parseInt(the_spinner.attr('data-minimum')),
			max:  parseInt(the_spinner.attr('data-maximum')),
			step:  parseInt(the_spinner.attr('data-step')),
			decimals:  parseInt(the_spinner.attr('data-decimals')),
			boostat: 5,
			maxboostedstep: 10,
			postfix: (the_spinner.attr('data-postfix-icon')) ? '<span class="'+ the_spinner.attr('data-postfix-icon') +' '+ the_spinner.attr('data-postfix-class') +'">' + the_spinner.attr('data-postfix-text') + '</span>' : '',
			prefix: (the_spinner.attr('data-prefix-icon')) ? '<span class="'+ the_spinner.attr('data-prefix-icon') +' '+ the_spinner.attr('data-prefix-class') +'">' + the_spinner.attr('data-prefix-text') + '</span>' : '',
			buttondown_class:  'btn ' + the_spinner.attr('data-down-class'),
			buttonup_class: 'btn ' + the_spinner.attr('data-up-class')
		});
		obj.find(".bootstrap-touchspin .bootstrap-touchspin-down").html('<span class="icon '+   the_spinner.attr('data-down-icon') +'"></span>');
		obj.find(".bootstrap-touchspin .bootstrap-touchspin-up").html('<span class="icon '+   the_spinner.attr('data-up-icon') +'"></span>');
		}
	if(obj.hasClass('color_pallet'))
		{
		
		obj.find('#colorpalette').colorPalette().on('selectColor', function(e) {
		obj.find('#selected-color').val(e.color);
		obj.find('#selected-color').trigger('change');
		obj.find('.input-group-addon').css('background',e.color);
		});	
		}
	
	if(obj.hasClass('slider'))
		{
		var count_text = obj.find( "#slider" ).attr('data-starting-value');
		var the_slider = obj.find( "#slider" )
		var set_min = the_slider.attr('data-min-value');
		var set_max = the_slider.attr('data-max-value')
		var set_start = the_slider.attr('data-starting-value')

		obj.find( "#slider" ).slider({
				range: "min",
				min: parseInt(set_min),
				max: parseInt(set_max),
				value: parseInt(set_start),
				slide: function( event, ui ) {	
					count_text = '<span class="count-text">' + the_slider.attr('data-count-text').replace('{x}',ui.value) + '</span>';	
					the_slider.find( '.ui-slider-handle' ).html( '<span id="icon" class="'+ the_slider.attr('data-dragicon') +'"></span> '+ count_text).addClass(the_slider.attr('data-dragicon-class')).removeClass('ui-state-default');
				},
				create: function( event, ui ) {	
					count_text = '<span class="count-text">'+ the_slider.attr('data-count-text').replace('{x}',((set_start) ? set_start : set_min)) +'</span>';	
					the_slider.find( '.ui-slider-handle' ).html( '<span id="icon" class="'+ the_slider.attr('data-dragicon') +'"></span> '+ count_text).addClass(the_slider.attr('data-dragicon-class')).removeClass('ui-state-default');
				}
				
			});
			//the_slider.find( '.ui-slider-handle' ).html('<span id="icon" class="'+ the_slider.attr('data-dragicon') +'"></span>' + count_text);
			
			//Slider text color
			the_slider.find('.ui-slider-handle').css('color',the_slider.attr('data-text-color'));
			//Handel border color
			the_slider.find('.ui-slider-handle').css('border-color',the_slider.attr('data-handel-border-color'));
			//Handel Background color
			the_slider.find('.ui-slider-handle').css('background-color',the_slider.attr('data-handel-background-color'));
			//Slider border color
			the_slider.find('.ui-widget-content').css('border-color',the_slider.attr('data-slider-border-color'));
			//Slider background color
			//Slider fill color
			the_slider.find('.ui-slider-range:first-child').css('background',the_slider.attr('data-fill-color'));
			the_slider.find('.ui-slider-range:last-child').css('background',the_slider.attr('data-background-color'));
			
			
			
			
		}			
	if(obj.hasClass('star-rating'))
		{
		obj.find('#star').raty({
		  size     : 24,
		  number   : parseInt(obj.find('#star').attr('data-total-stars')),
		  starHalf : jQuery('.plugin_url').text()+'/images/star-half-big.png',
		  starOff  : jQuery('.plugin_url').text()+'/images/star-off-big.png',
		  starOn   : jQuery('.plugin_url').text()+'/images/star-on-big.png',
		  scoreName: format_illegal_chars(obj.find('.the_label').text()),
		  half: (obj.find('#star').attr('data-enable-half')=='false') ? false : true 
		});
		obj.find('#star input').addClass('the_input_element').addClass('hidden');
		obj.find('#star input').prop('type','text');
		}
		
		
	if(obj.hasClass('multi-select') || obj.hasClass('select'))
		{	
		var the_select = obj.find("#select");
		the_select.selectpicker();
		var font_family = (the_select.attr('data-font-family')) ? the_select.attr('data-font-family') : '';
		font_family = font_family.replace('sf','');
		font_family = font_family.replace('gf','');
		obj.find(".selectpicker").css('color', the_select.attr('data-text-color'))
		obj.find(".selectpicker a").css('color', the_select.attr('data-text-color'))
		obj.find(".selectpicker").removeClass('align_left').removeClass('align_right').removeClass('align_center')
		obj.find(".selectpicker").addClass(the_select.attr('data-text-alignment'))
		obj.find(".selectpicker").addClass(the_select.attr('data-input-size'))
		obj.find(".selectpicker").css('font-family',font_family);
		
		obj.find(".selectpicker").css('border-color', the_select.attr('data-border-color'));
		obj.find(".selectpicker").css('background', the_select.attr('data-background-color'))
		obj.find(".selectpicker").addClass('error_message');
		obj.find(".selectpicker").addClass('ui-state-default');
		obj.find(".selectpicker").attr('data-placement',the_select.attr('data-placement'));
		obj.find(".selectpicker").attr('data-error-class',the_select.attr('data-error-class'));
		obj.find(".selectpicker").attr('data-content',the_select.attr('data-content'));
		}
	if(obj.hasClass('email'))
		{
		}
	if(obj.hasClass('tags'))
		{	
		var the_tag_input = obj.find('input#tags');
		 the_tag_input.tagsinput( {maxTags: (the_tag_input.attr('data-max-tags')) ? the_tag_input.attr('data-max-tags') : '' });
		 
		obj.find('.bootstrap-tagsinput input').css('color',the_tag_input.attr('data-text-color'));
		obj.find('.bootstrap-tagsinput').css('border-color',the_tag_input.attr('data-border-color'));
		obj.find('.bootstrap-tagsinput').css('background-color',the_tag_input.attr('data-background-color'));
		obj.find('.bootstrap-tagsinput').addClass('error_message');
		obj.find(".bootstrap-tagsinput").attr('data-placement',the_tag_input.attr('data-placement'));
		obj.find(".bootstrap-tagsinput").attr('data-error-class',the_tag_input.attr('data-error-class'));
		obj.find(".bootstrap-tagsinput").attr('data-content',the_tag_input.attr('data-content'));
		}
		
		
	if(obj.hasClass('autocomplete'))
		{
		var items = obj.find('div.get_auto_complete_items').text();
		//console.log(items);
		items = items.split('\n');
		obj.find("#autocomplete").autocomplete({
		source: items
		});	
		}	
	
	
	if(obj.hasClass('radio-group'))
		{
		obj.find('input[type="radio"]').nexchecks()
		}
	if(obj.hasClass('check-group'))
		{
		obj.find('input[type="checkbox"]').nexchecks()
		}
		
	setTimeout(
		function()
			{
				
			if(!obj.hasClass('dropped'))
				{
				var set_Id = '_' + Math.round(Math.random()*99999);
	
				obj.attr('id',set_Id);	
				jQuery('#filters a:first').trigger('click').tab('show');
				obj.find('div.edit').trigger('click');
				
				obj.addClass('dropped');
				}
		},100
	);
	setTimeout(
		function()
			{
			obj.find('label#nexf_title').addClass('editing-field');
			obj.find('label#nexf_title').animate(
						{
						outlineOffset:0,
						outlineWidth:1
						},300
					);
			},800
		);
		
}

function create_droppable(obj){
	    var the_droppable 	= obj;
        var the_draggable 	= jQuery('div.col1 .form_field');
		//Drag
        the_draggable.draggable(
			{
			drag: function( event, ui ) { },
			stop: function( event, ui ) {  setTimeout(function(){ jQuery('.col2 .admin-panel .panel-heading .btn.glyphicon-hand-down').trigger('click');},300 ); },
			stack  : '.draggable',
			revert : 'invalid', 
			tolerance: 'intersect',
			connectToSortable:obj,
			snap:false,
			helper : 'clone',
			}
        );
		
		
		
		//Enable panel nesting -> find a better way some day
		jQuery('.panel-heading .btn').live('click',
			function()
				{
				jQuery('.panel-heading .btn').removeClass('btn-success').addClass('btn-primary');
					if(jQuery('.trash-can ').droppable())
						{
						jQuery('.trash-can ').droppable('option','drop',
							function(event, ui)
									{
									ui.draggable.remove();
									jQuery('.trash-can ').animate(
										{
										fontSize:70
										},50,
										function()
											{
											jQuery('.trash-can ').animate(
												{
												fontSize:47
												},200);
											}
										)
									}
								);
						jQuery('.trash-can ').droppable('option','over',
							function(event, ui)
									{
									ui.helper.css('opacity','0.6');
									jQuery('.trash-can ').animate(
										{
										fontSize:60
										},200
										)
									}
							);
						jQuery('.trash-can ').droppable('option','out',
							function(event, ui)
									{
									ui.helper.css('opacity','1');
									
									jQuery('.trash-can ').animate(
										{
										fontSize:47
										},200
										)
									}
								);
						}
					else
						{
							
						create_droppable(jQuery('.trash-can'));
						}
				if(jQuery(this).hasClass('btn-success'))
					{
					jQuery(this).removeClass('btn-success');
					jQuery(this).addClass('btn-primary');
					the_draggable.draggable("option", "connectToSortable",the_droppable);
					}
				else
					{
					jQuery(this).addClass('btn-success');
					jQuery(this).removeClass('btn-primary');
					the_draggable.draggable("option", "connectToSortable", jQuery(this).parent().parent().find('.panel-body'));
					}
				}
			);
		the_droppable.droppable(
        	{
            drop   		: function(event, ui)
							{
							
							setup_form_element(ui.draggable);
							//populate_current_form_fields();
							jQuery(this).removeClass('over');							
							},
							
							
            over        : function(){jQuery(this).addClass('over')},
            out         : function(){jQuery(this).removeClass('over')},	  
            tolerance 	: 'fit',
			helper 		: 'clone'	,
			accept      : '.form_field'
        }).sortable(
			{
			start : function(event, ui)
				{ 
				ui.helper.find('div.draggable_object').hide();
				ui.helper.find('div.form_object').show();
				ui.helper.find('div.field_settings').hide();
				ui.helper.removeClass('field');
			 	}, 
			stop : function(event, ui){  setTimeout(function(){ jQuery('.col2 .admin-panel .panel-heading .btn.glyphicon-hand-down').trigger('click');},300 ); },           
			placeholder: 'alert-info place-holder',
			forcePlaceholderSize : true,
			connectWith:'.panel-body'
			}
		);
}
function move_to_container(theObj, newContainer) {
	var set_Id = '_' + Math.round(Math.random()*99999);
	if(theObj.hasClass('wa-sortable'))
		return;
	jQuery(theObj).attr('data-id', set_Id);
	jQuery(theObj).addClass(set_Id);
	theObj.addClass('wa-sortable');
	return true;         
}	