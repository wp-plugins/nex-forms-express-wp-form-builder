var the_field ='';
//var z_index = 1000;
jQuery(document).ready(
function()
	{
	//jQuery('.the_input_element, .bootstrap-tagsinput, .radio-group a, .check-group a').addClass('ui-state-default')
	//jQuery('.form_field .input-group-addon, .bootstrap-touchspin .btn').addClass('ui-state-active')
	jQuery('.ui-state-default').live('mouseover',
		function()
			{
			jQuery(this).addClass('ui-state-hover');
			}
		);
	jQuery('.ui-state-default').live('mouseleave',
		function()
			{
			jQuery(this).removeClass('ui-state-hover');
			}
		);
	jQuery('div.radio_button_group label,div.check_box_group label').live('mouseleave',
		function()
			{
			jQuery(this).removeClass('ui-state-hover');
			}
		);
	
	jQuery('div.ui-nex-forms-container .nex-step').live('click',
		function()
			{
			jQuery(this).closest('.step').hide();
			jQuery(this).closest('.step').next('.step').show();
			}
		);
	jQuery('div.ui-nex-forms-container .prev-step').live('click',
		function()
			{
			jQuery(this).closest('.step').hide();
			jQuery(this).closest('.step').prev('.step').show();
			}
		);
	
	jQuery('.selectpicker').live('click',
		function()
		{
		jQuery(this).closest('.bootstrap-select').addClass('open');
		}
		);
	
	//create_form();	
	
	jQuery('#star img').live('click',
		function()
			{
			jQuery(this).parent().find('input').trigger('change');
			}
		);	
		
	jQuery('#nex-forms select').each(
		function()
			{
			jQuery(this).val('0');
			jQuery(this).parent().find('ul.dropdown-menu li').removeClass('selected');
			jQuery(this).parent().find('ul.dropdown-menu li:first-child').addClass('selected');
			}
		);		
	
	jQuery('.bootstrap-touchspin-down, bootstrap-touchspin-up').on('click',
		function()
			{
			jQuery(this).parent().parent().find('input').trigger('change');
			}
		);
			
	}
	);
function IsSafari() {

  var is_safari = navigator.userAgent.toLowerCase().indexOf('safari/') > -1;
 
  if(navigator.userAgent.toLowerCase().indexOf('chrome/') >-1)
  	is_safari = false;
  if(navigator.userAgent.toLowerCase().indexOf('opera/') >-1)
  	is_safari = false;
	
  return is_safari;

}
function create_form(){
			
	//run_conditions();
	
	jQuery('div.ui-nex-forms-container form').html(jQuery('div.nex-forms-container').html())
	
	jQuery('div.ui-nex-forms-container .nex_success_message').html(jQuery('#nex_autoresponder_on_screen_confirmation_message').val())
	
	jQuery('div.ui-nex-forms-container .grid').removeClass('grid-system')
	jQuery('div.ui-nex-forms-container .editing-field-container').removeClass('.editing-field-container')
	jQuery('div.ui-nex-forms-container #slider').html('');
	jQuery('div.ui-nex-forms-container #star' ).raty('destroy');
	jQuery('div.ui-nex-forms-container .bootstrap-touchspin-prefix').remove();
	jQuery('div.ui-nex-forms-container .bootstrap-select').remove();
	jQuery('div.ui-nex-forms-container .bootstrap-touchspin-postfix').remove();
	jQuery('div.ui-nex-forms-container .bootstrap-touchspin .input-group-btn').remove();
	jQuery('div.ui-nex-forms-container .bootstrap-tagsinput').remove();
	jQuery('div.ui-nex-forms-container div#the-radios input').prop('checked',false);
	jQuery('div.ui-nex-forms-container div#the-radios a').attr('class','');
	
	jQuery('div.ui-nex-forms-container .editing-field').removeClass('editing-field')
	jQuery('div.ui-nex-forms-container .editing-field-container').removeClass('.editing-field-container')
	jQuery('div.ui-nex-forms-container').find('div.trash-can').remove();
	jQuery('div.ui-nex-forms-container').find('div.draggable_object').hide();
	jQuery('div.ui-nex-forms-container').find('div.draggable_object').remove();
	jQuery('div.ui-nex-forms-container').find('div.form_object').show();
	jQuery('div.ui-nex-forms-container').find('div.form_field').removeClass('field');
	
	jQuery('div.ui-nex-forms-container .zero-clipboard').remove();
	
	jQuery('div.ui-nex-forms-container .step').hide()
	jQuery('div.ui-nex-forms-container .step').first().show();	
	
	jQuery('div.ui-nex-forms-container .tab-pane').removeClass('tab-pane');

	jQuery('#nex-forms .form_field').each(
		function(index)
			{
			jQuery(this).css('z-index',1000-index)

			setup_ui_element(jQuery(this));
			if(jQuery(this).hasClass('text') || jQuery(this).hasClass('textarea'))
				{
				if(jQuery(this).find('.the_input_element').attr('data-maxlength-show')=='true')
					jQuery(this).find('.the_input_element').maxlength({ placement:(jQuery(this).find('.the_input_element').attr('data-maxlength-position')) ? jQuery(this).find('.the_input_element').attr('data-maxlength-position') : 'bottom', alwaysShow: true , set_ID: jQuery(this).attr('id'), warningClass: 'label '+ jQuery(this).find('.the_input_element').attr('data-maxlength-color') });
				}
			}
		);
		
	
	
	jQuery('div.ui-nex-forms-container .help-block.hidden, div.ui-nex-forms-container .is_required.hidden').remove();
	jQuery('div.ui-nex-forms-container .has-pretty-child,div.ui-nex-forms-container  .slider').removeClass('svg_ready')
	jQuery('div.ui-nex-forms-container .input-group').removeClass('date');
	
	jQuery('div.ui-nex-forms-container .the_input_element,div.ui-nex-forms-container  .row, .svg_ready,div.ui-nex-forms-container  .radio-inline').each(
		function()
			{
			if(jQuery(this).parent().hasClass('input-inner') || jQuery(this).parent().hasClass('input_holder')){
				jQuery(this).unwrap();
				}	
			}
		);
	
	jQuery('div.ui-nex-forms-container div').each(
		function()
			{
			if(jQuery(this).parent().hasClass('svg_ready') || jQuery(this).parent().hasClass('form_object') || jQuery(this).parent().hasClass('input-inner')){
				jQuery(this).unwrap();
				}
			}
		);
		
	jQuery('div.ui-nex-forms-container  div.form_field').each(
		function()
			{
			if(jQuery(this).parent().parent().hasClass('panel-default') && !jQuery(this).parent().prev('div').hasClass('panel-heading')){
				jQuery(this).parent().unwrap();
				jQuery(this).unwrap();
				}
			}
		);
		
	jQuery('div.ui-nex-forms-container .help-block').each(
		function()
			{
			if(!jQuery(this).text())
				jQuery(this).remove()
			}
		);
	
	jQuery('div.ui-nex-forms-container  .sub-text').each(
		function()
			{
			if(jQuery(this).text()=='')
				{
				jQuery(this).parent().find('br').remove()
				jQuery(this).remove();
				}
			}
		);
	
	jQuery('div.ui-nex-forms-container  .label_container').each(
		function()
			{
			if(jQuery(this).css('display')=='none')
				{
				jQuery(this).parent().find('.input_container').addClass('full_width');
				jQuery(this).remove()
				}
			}
		);
	
		
	jQuery('div.ui-nex-forms-container .ui-draggable').removeClass('ui-draggable');
	jQuery('div.ui-nex-forms-container .ui-draggable-handle').removeClass('ui-draggable-handle')
	jQuery('div.ui-nex-forms-container .dropped').removeClass('dropped')
	jQuery('div.ui-nex-forms-container .ui-sortable-handle').removeClass('ui-sortable-handle');
	jQuery('div.ui-nex-forms-container .ui-sortable').removeClass('ui-sortable-handle');
	jQuery('div.ui-nex-forms-container .ui-droppable').removeClass('ui-sortable-handle');
	jQuery('div.ui-nex-forms-container .over').removeClass('ui-sortable-handle');
	jQuery('div.ui-nex-forms-container .the_input_element.bs-tooltip').removeClass('bs-tooltip') 
	jQuery('div.ui-nex-forms-container .bs-tooltip.glyphicon').removeClass('glyphicon');
	jQuery('div.ui-nex-forms-container .grid-system.panel').removeClass('panel-body');
	jQuery('div.ui-nex-forms-container .grid-system.panel').removeClass('panel');
	jQuery('div.ui-nex-forms-container .form_field.grid').removeClass('grid').removeClass('form_field').addClass('is_grid');
	jQuery('div.ui-nex-forms-container .grid-system').removeClass('grid-system');
	
	
	jQuery('div.ui-nex-forms-container .input-group-addon.btn-file span').attr('class','fa fa-cloud-upload');
	jQuery('div.ui-nex-forms-container .input-group-addon.fileinput-exists span').attr('class','fa fa-close');
	
	jQuery('div.ui-nex-forms-container .checkbox-inline').addClass('radio-inline');
	jQuery('div.ui-nex-forms-container .check-group').addClass('radio-group');
	
	
	jQuery('div.ui-nex-forms-container .submit-button br').remove();
	jQuery('div.ui-nex-forms-container .submit-button small.svg_ready').remove();
	
	jQuery('div.ui-nex-forms-container .radio-group a,div.ui-nex-forms-container  .check-group a').addClass('ui-state-default')
	jQuery('div.ui-nex-forms-container .is_grid .panel-body').removeClass('ui-widget-content');
	jQuery('div.ui-nex-forms-container .bootstrap-select.ui-state-default').removeClass('ui-state-default');
	jQuery('div.ui-nex-forms-container .bootstrap-select').removeClass('form-control').addClass('full_width');
	jQuery('div.ui-nex-forms-container .selectpicker,div.ui-nex-forms-container  .dropdown-menu.the_input_element').addClass('ui-state-default');
	jQuery('div.ui-nex-forms-container .selectpicker').removeClass('dropdown-toggle')
	jQuery('div.ui-nex-forms-container .is_grid .panel-body').removeClass('ui-widget-content');
	jQuery('div.ui-nex-forms-container .bootstrap-select.ui-state-default').removeClass('ui-state-default');
	
	jQuery('div.ui-nex-forms-container .is_grid .panel-body').removeClass('ui-sortable').removeClass('ui-droppable').removeClass('ui-widget-content').removeClass('');
	
	
	
	jQuery('.radio-group a, .check-group a').addClass('ui-state-default')
	jQuery('.grid-system .panel-body').removeClass('ui-widget-content');
	jQuery('.bootstrap-select.ui-state-default').removeClass('ui-state-default');
	jQuery('.bootstrap-select').removeClass('form-control').addClass('full_width');
	jQuery('.selectpicker, .dropdown-menu.the_input_element').addClass('ui-state-default')
					jQuery('.grid-system .panel-body').removeClass('ui-widget-content');
					jQuery('.bootstrap-select.ui-state-default').removeClass('ui-state-default');
	
}
function isNumber(n) {
   if(n!='')
		return !isNaN(parseFloat(n)) && isFinite(n);
	
	return true;
}
function run_con_action(target,action){
			
	if(action=='show')
		jQuery('#'+target).show();
	if(action=='hide')
		jQuery('#'+target).hide();
	if(action=='slideDown')
		jQuery('#'+target).slideDown('slow');
	if(action=='slideUp')
		jQuery('#'+target).slideUp('slow');
	if(action=='fadeIn')
		jQuery('#'+target).fadeIn('slow');
	if(action=='fadeOut')
		jQuery('#'+target).fadeOut('slow');
	
}
function reverse_con_action(target,action){
	if(action=='show')
		jQuery('#'+target).hide();
	if(action=='hide')
		jQuery('#'+target).show();
	if(action=='slideDown')
		jQuery('#'+target).slideUp('slow');
	if(action=='slideUp')
		jQuery('#'+target).slideDown('slow');
	if(action=='fadeIn')
		jQuery('#'+target).fadeOut('slow');
	if(action=='fadeOut')
		jQuery('#'+target).fadeIn('slow');
}

function convert_time_to_24h(time){

var hours = Number(time.match(/^(\d+)/)[1]);
var minutes = Number(time.match(/:(\d+)/)[1]);
var AMPM = time.match(/\s(.*)$/)[1];
if(AMPM == "PM" && hours<12) hours = hours+12;
if(AMPM == "AM" && hours==12) hours = hours-12;
var sHours = hours.toString();
var sMinutes = minutes.toString();
if(hours<10) sHours = "0" + sHours;
if(minutes<10) sMinutes = "0" + sMinutes;
return sHours + ":" + sMinutes;

	
}

function run_conditions(){
	jQuery('div.ui-nex-forms-container div.form_field').find('input[type="text"], textarea').keyup(
		function()
			{
			if(jQuery(this).hasClass('has_con'))
				{
				var val = jQuery(this).val();
				jQuery('.field_'+jQuery(this).closest('.form_field').attr('id')).each(
					function()
						{
						var condition = jQuery(this).attr('data-condition');
						var action = jQuery(this).attr('data-action');
						var target = jQuery(this).attr('data-target');
						var value = jQuery(this).attr('data-value');
						switch(condition)
							{
							case 'Equal to':
								if(val==value)
									{
									run_con_action(target,action);
									}
								else
									reverse_con_action(target,action);
							break;
							case 'Greater than':
								if(isNumber)
									{
									if(parseInt(val)>parseInt(value))
										{
										run_con_action(target,action);
										}
										
									}
							break;
							case 'Less than':
								if(isNumber)
									{
									if(parseInt(val)<parseInt(value))
										{
										run_con_action(target,action);
										}
									}
							break;
							}
						}
					);
				}
			}
		);	
	jQuery('div.ui-nex-forms-container div.form_field').find('input[type="text"], input[type="hidden"], textarea').live('change',
		function()
			{
			if(jQuery(this).hasClass('has_con'))
				{
				var val = jQuery(this).val();
				jQuery('.field_'+jQuery(this).closest('.form_field').attr('id')).each(
					function()
						{
						var condition = jQuery(this).attr('data-condition');
						var action = jQuery(this).attr('data-action');
						var target = jQuery(this).attr('data-target');
						var value = jQuery(this).attr('data-value');
						switch(condition)
							{
							case 'Equal to':
								if(val==value)
									{
									run_con_action(target,action);
									}
								else
									reverse_con_action(target,action);
							break;
							case 'Greater than':
								if(isNumber)
									{
									if(parseInt(val)>parseInt(value))
										{
										run_con_action(target,action);
										}
										
									}
							break;
							case 'Less than':
								if(isNumber)
									{
									if(parseInt(val)<parseInt(value))
										{
										run_con_action(target,action);
										}
									}
							break;
							}
						}
					);
				}
			}
		);
	
	jQuery('div.ui-nex-forms-container div.form_field').find('#datetimepicker').live('change', function(e) {
	if(jQuery(this).find('input').hasClass('has_con'))
				{
				var the_input = jQuery(this).find('input');
				var val = jQuery(this).find('input').val();
				jQuery('.field_'+jQuery(this).closest('.form_field').attr('id')).each(
					function()
						{
						var condition = jQuery(this).attr('data-condition');
						var action = jQuery(this).attr('data-action');
						var target = jQuery(this).attr('data-target');
						var value = jQuery(this).attr('data-value');
						switch(condition)
							{
							case 'Equal to':
								if(val==value)
									{
									run_con_action(target,action);
									}
								else
									reverse_con_action(target,action);
							break;
							case 'Greater than':
								if(the_input.closest('.form_field').hasClass('time'))
									{
									var firstValue = convert_time_to_24h(value);
									var secondValue = convert_time_to_24h(val);
									if(Date.parse('01/01/2011 '+ secondValue +':00') > Date.parse('01/01/2011 '+firstValue +':00'))
										run_con_action(target,action);
									}
								else if(the_input.closest('.form_field').hasClass('datetime')){
									var splitdatetime1 = value.split(' ');
									var splitdatetime2 = val.split(' ');
									if(Date.parse(splitdatetime1[0] + ' '+ convert_time_to_24h(splitdatetime1[1] +' '+ splitdatetime1[2])+':00') < Date.parse(splitdatetime2[0] + ' '+ convert_time_to_24h(splitdatetime2[1] +' '+ splitdatetime2[2])+':00'))
										run_con_action(target,action);
								}
								else
									{
									if(Date.parse(value+' 00:00:00') < Date.parse(val+' 00:00:00'))
										run_con_action(target,action);
									}
							break;
							case 'Less than':
								
								if(the_input.closest('.form_field').hasClass('time'))
									{
									var firstValue = convert_time_to_24h(value);
									var secondValue = convert_time_to_24h(val);
									if(Date.parse('01/01/2011 '+ secondValue +':00') < Date.parse('01/01/2011 '+firstValue +':00'))
										run_con_action(target,action);
									}
								else if(the_input.closest('.form_field').hasClass('datetime')){
										var splitdatetime1 = value.split(' ');
										var splitdatetime2 = val.split(' ');
										if(Date.parse(splitdatetime1[0] + ' '+ convert_time_to_24h(splitdatetime1[1] +' '+ splitdatetime1[2])+':00') > Date.parse(splitdatetime2[0] + ' '+ convert_time_to_24h(splitdatetime2[1] +' '+ splitdatetime2[2])+':00'))
											run_con_action(target,action);
									}
								else
									{
									if(Date.parse(value+' 00:00:00') > Date.parse(val+' 00:00:00'))
										run_con_action(target,action);
									
									}
							break;
							}
						}
					);
				}
		});	
			
		jQuery('div.ui-nex-forms-container div.form_field').find('select').change(
				function()
					{
					if(jQuery(this).hasClass('has_con'))
						{
						var val = jQuery(this).val();
						jQuery('.field_'+jQuery(this).closest('.form_field').attr('id')).each(
							function()
								{
								var action = jQuery(this).attr('data-action');
								var target = jQuery(this).attr('data-target');
								var value = jQuery(this).attr('data-value');
								
								if(val==value)
									run_con_action(target,action);
								else
									reverse_con_action(target,action);
								
								}
							);
						}
					}
				);	
		jQuery('div.ui-nex-forms-container div.form_field').find('.prettyradio a, span.radio-label').live('click',
				function()
					{
					var the_radio = jQuery(this).parent().find('input[type="radio"]');
					if(the_radio.hasClass('has_con'))
						{
						var val = the_radio.val();
						jQuery('.field_'+the_radio.closest('.form_field').attr('id')).each(
							function()
								{
								var action = jQuery(this).attr('data-action');
								var target = jQuery(this).attr('data-target');
								var value = jQuery(this).attr('data-value');
								
								if(val==value)
									run_con_action(target,action);
								else
									reverse_con_action(target,action);
								
								}
							);
						}
					}
				);	
		
}

function setup_ui_element(obj){
	
	
	jQuery('div.ui-nex-forms-container').find('.customcon').each(
		function()
			{
			if(obj.attr('id')==jQuery(this).attr('data-target') && (jQuery(this).attr('data-action')=='show' || jQuery(this).attr('data-action')=='slideDown' || jQuery(this).attr('data-action')=='fadeIn'))
				jQuery('div.ui-nex-forms-container #'+obj.attr('id')).hide();
			}
	);
	
	//obj.attr('id','');

	jQuery('div.ui-nex-forms-container').find('.bs-tooltip').tooltip();
	
	if(obj.hasClass('text') || obj.hasClass('textarea'))
		obj.find('.the_input_element').val(obj.find('.the_input_element').attr('data-default-value'));
					
	if(obj.hasClass('datetime'))
		{
		obj.find('#datetimepicker').datetimepicker( 
				{ 
				//pickTime:false,
				format: (obj.find('#datetimepicker').attr('data-format')) ? obj.find('#datetimepicker').attr('data-format') : 'MM/DD/YYYY hh:mm A',
				locale: (obj.find('#datetimepicker').attr('data-language')) ? obj.find('#datetimepicker').attr('data-language') : 'en'
				} 
			);	
		}
	if(obj.hasClass('date'))
		{
		obj.find('#datetimepicker').datetimepicker( 
				{ 
				//pickTime:false,
				format: (obj.find('#datetimepicker').attr('data-format')) ? obj.find('#datetimepicker').attr('data-format') : 'MM/DD/YYYY',
				locale: (obj.find('#datetimepicker').attr('data-language')) ? obj.find('#datetimepicker').attr('data-language') : 'en'
				} 
			);	
		}	
	if(obj.hasClass('time'))
		{
		obj.find('#datetimepicker').datetimepicker( 
				{ 
				//pickTime:false,
				format: (obj.find('#datetimepicker').attr('data-format')) ? obj.find('#datetimepicker').attr('data-format') : 'hh:mm A',
				locale:(obj.find('#datetimepicker').attr('data-language')) ? obj.find('#datetimepicker').attr('data-language') : 'en'
				} 
			);	
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
		var set_start = the_slider.attr('data-starting-value');
		var set_step = the_slider.attr('data-step-value')

		obj.find( "#slider" ).slider({
				range: "min",
				min: parseInt(set_min),
				max: parseInt(set_max),
				value: parseInt(set_start),
				step: parseInt(set_step),
				slide: function( event, ui ) {	
					count_text = '<span class="count-text">' + the_slider.attr('data-count-text').replace('{x}',ui.value) + '</span>';	
					the_slider.find( '.ui-slider-handle' ).html( '<span id="icon" class="'+ the_slider.attr('data-dragicon') +'"></span> '+ count_text).addClass(the_slider.attr('data-dragicon-class')).removeClass('ui-state-default');
					obj.find( 'input' ).val(ui.value);
					obj.find( 'input' ).trigger('change');
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
		}
		
	if(obj.hasClass('autocomplete'))
		{
		var items = obj.find('div.get_auto_complete_items').text();
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
	
	
	if(jQuery('.field_'+obj.attr('id')).attr('data-target'))
		{
		obj.find('input[type="text"]').addClass('has_con');
		obj.find('input[type="hidden"]').addClass('has_con');
		obj.find('textarea').addClass('has_con');
		obj.find('select').addClass('has_con');
		obj.find('input[type="radio"]').addClass('has_con');
		}
		
}
