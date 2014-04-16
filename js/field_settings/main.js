// JavaScript Document
/*
for (var j = 0; j < settings_array.length; j++)
		{
		var num_current_val = 0;
		var current_val = jQuery(obj).css(settings_array[j]);
		if(current_val)
			num_current_val = current_val.replace('px','').replace('%','')
			
			//console.log(current_val);
			/*if(settings_array[j]=='font-family')
				{
				
				var set_font = Array();
				var get_font = '';
				if(num_current_val)
					var get_font = num_current_val.replace('"','');
				if(get_font)
					var set_font = get_font.split(',');
				//console.log(format_font_name(set_font[0]));	
				if(!set_font[0])
					{
					jQuery('select.sfm').find('option.'+format_font_name(set_font)).attr('selected',true);
					jQuery('select.sfm').trigger('change');	
					jQuery('select.sfm').change( function(){
						$(this).data('stylesFontDropdown').set_selected_option();
					});
					}
				else
					{
					jQuery('select.sfm').find('option.'+format_font_name(set_font[0])).attr('selected',true);
					jQuery('select.sfm').trigger('change');
					jQuery('select.sfm').change( function(){
						jQuery(this).data('stylesFontDropdown').set_selected_option();
					});		
					}
				}
				
				
		}
*/
var settings_array = new Array('padding-top', 'padding-right', 'padding-bottom', 'padding-left', 'margin-top', 'margin-right', 'margin-bottom', 'margin-left', 'font-size','border', 'font-family', 'width', 'height', 'border-width', 'border-style', 'color', 'background-color','background', 'border-color', 'border', 'border-radius', 'border-radius', 'font-weight', 'font-style', 'text-decoration', 'line-height', 'text-align', 'letter-spacing', 'text-transform', 'float');
var css = '';
var style_keys = new Array(); 
var style_values = new Array();

function format_font_name(font){
	
	font = font.toLowerCase();
	font = font.replace(' ','');
	font = font.replace('"','');
		
	return font;	
}

function populate_label_settings(obj){

		//Alingment
		jQuery('.align-label button').removeClass('btn-primary');
		if(obj.hasClass('align_left'))
			jQuery('.align-label button.left').addClass('btn-primary');	
		else if(obj.hasClass('align_right'))
			jQuery('.align-label button.right').addClass('btn-primary');
		else if(obj.hasClass('align_center'))
			jQuery('.align-label button.center').addClass('btn-primary');
		else
			jQuery('.align-label button.left').addClass('btn-primary');
		
		//Required Star
		jQuery('.required-star button').removeClass('btn-primary');
		if(obj.find('.is_required').hasClass('glyphicon-star-empty'))
			jQuery('.required-star button.empty').addClass('btn-primary');
		else if(obj.find('.is_required').hasClass('glyphicon-asterisk'))
			jQuery('.required-star button.asterisk').addClass('btn-primary');
		else
			jQuery('.required-star button.full').addClass('btn-primary');
		
		//Bold
		jQuery('.label-bold').removeClass('label-primary');
			if(obj.find('span.the_label').hasClass('style_bold'))
				jQuery('.label-bold').addClass('label-primary');
		jQuery('.sub-label-bold').removeClass('label-primary');
			if(obj.find('small.sub-text').hasClass('style_bold'))
				jQuery('.sub-label-bold').addClass('label-primary');
		//Italic
		jQuery('.label-italic').removeClass('label-primary');
			if(obj.find('span.the_label').hasClass('style_italic'))
				jQuery('.label-italic').addClass('label-primary');
		jQuery('.sub-label-italic').removeClass('label-primary');
			if(obj.find('small.sub-text').hasClass('style_italic'))
				jQuery('.sub-label-italic').addClass('label-primary');
		
		//Position
		jQuery('.show-label button').removeClass('btn-primary');	
		if(obj.parent().attr('style')=='display: none;')
			jQuery('.show-label button.none').addClass('btn-primary');
		else if(obj.parent().hasClass('col-sm-12'))
			jQuery('.show-label button.top').addClass('btn-primary');
		else
			jQuery('.show-label button.left').addClass('btn-primary');
		
		//Size	
		jQuery('.label-size button').removeClass('btn-primary');
		if(obj.hasClass('input-lg'))
			jQuery('.label-size button.large').addClass('btn-primary');
		else if(obj.hasClass('input-sm'))
			jQuery('.label-size button.small ').addClass('btn-primary');
		else
			jQuery('.label-size button.normal').addClass('btn-primary');
		
		
		//Label Color
		jQuery('#label-color').bscolorpicker('setValue',colorToHex(obj.find('span.the_label').css('color')))
		//Sub label Color
		jQuery('#label-subtext').bscolorpicker('setValue',colorToHex(obj.find('small.sub-text').css('color')))
}

function populate_input_settings(obj){
		
		//Required
		jQuery('.required button').removeClass('btn-primary');
		if(obj.closest('.form_field').hasClass('required'))
			jQuery('.required button.yes').addClass('btn-primary');
		else
			jQuery('.required button.no').addClass('btn-primary');
		
	
	 
        jQuery('button.validate-as').html(jQuery('ul.validate-as li:first a').html());	    
		if(obj.hasClass('email'))
			jQuery('button.validate-as').html(jQuery('ul.validate-as li a.email').html());
		else if(obj.hasClass('phone_number'))
			jQuery('button.validate-as').html(jQuery('ul.validate-as li a.phone_number').html());
		else if(obj.hasClass('url'))
			jQuery('button.validate').html(jQuery('ul.validate-as li a.url').html());
		else if(obj.hasClass('numbers_only'))
			jQuery('button.validate').html(jQuery('ul.validate-as li a.numbers_only').html());
		else if(obj.hasClass('text_only'))
			jQuery('button.validate-as').html(jQuery('ul.validate-as li a.text_only').html());
		else
			jQuery('button.validate-as').html(jQuery('ul.validate-as li:first a').html());
			
		//cornres
		jQuery('.input-corners button').removeClass('btn-primary');
		if(obj.closest('.form_field').hasClass('square'))
			jQuery('.input-corners .square').addClass('btn-primary');
		else if(obj.closest('.form_field').hasClass('full_rounded'))
			jQuery('.input-corners .full_rounded').addClass('btn-primary');
		else
			jQuery('.input-corners .normal').addClass('btn-primary');
			
		//Bold
		jQuery('.input-bold').removeClass('label-primary');
			if(obj.hasClass('style_bold'))
				jQuery('.input-bold').addClass('label-primary');
		//Italic
		jQuery('.input-italic').removeClass('label-primary');
			if(obj.hasClass('style_italic'))
				jQuery('.input-italic').addClass('label-primary');
		
		//Alingment
		jQuery('.align-input button').removeClass('btn-primary');
		if(obj.hasClass('align_left'))
			jQuery('.align-input button.left').addClass('btn-primary');	
		else if(obj.hasClass('align_right'))
			jQuery('.align-input button.right').addClass('btn-primary');
		else if(obj.hasClass('align_center'))
			jQuery('.align-input button.center').addClass('btn-primary');
		else if(obj.hasClass('align_justify'))
			jQuery('.align-input button.justify').addClass('btn-primary');
		else
			jQuery('.align-input button.left').addClass('btn-primary');
			
		
		
			
		
		//Size	
		jQuery('.input-size button').removeClass('btn-primary');
		if(obj.hasClass('input-lg'))
			jQuery('.input-size button.large').addClass('btn-primary');
		else if(obj.hasClass('input-sm'))
			jQuery('.input-size button.small').addClass('btn-primary');
		else
			jQuery('.input-size button.normal').addClass('btn-primary');
			
		//Text Color
		jQuery('#input-color').bscolorpicker('setValue',colorToHex(obj.css('color')))
		//Background color
		jQuery('#input-bg-color').bscolorpicker('setValue',colorToHex(obj.css('background-color')))
		//Border color
		jQuery('#input-border-color').bscolorpicker('setValue',colorToHex(obj.css('border-top-color')))
		//Border color on focus
		jQuery('#input-onfocus-color').bscolorpicker('setValue',colorToHex(obj.attr('data-onfocus-color')))
		
}

function populate_validation_settings(obj){

	//Validation position
		jQuery('.error-position button').removeClass('btn-primary');
		if(obj.attr('data-placement')=='top')
			jQuery('.error-position .top').addClass('btn-primary');	
		else if(obj.attr('data-placement')=='right')
			jQuery('.error-position .right').addClass('btn-primary');
		else if(obj.attr('data-placement')=='left')
			jQuery('.error-position .left').addClass('btn-primary');
		else
			jQuery('.error-position .bottom').addClass('btn-primary');
			
		//Validation Color
		jQuery('.validation-color i').attr('class','');
			jQuery('.validation-color i').addClass(obj.attr('data-error-class')).removeClass('label');	
	
}
function populate_help_text_settings(obj){

		//Alingment
		jQuery('.align-help-text button').removeClass('btn-primary');
		if(obj.hasClass('align_left'))
			jQuery('.align-help-text button.left').addClass('btn-primary');	
		else if(obj.hasClass('align_right'))
			jQuery('.align-help-text button.right').addClass('btn-primary');
		else if(obj.hasClass('align_center'))
			jQuery('.align-help-text button.center').addClass('btn-primary');
		else
			jQuery('.align-help-text button.left').addClass('btn-primary');
		
		//Position
		jQuery('.show-help-text button').removeClass('btn-primary');	
		
		if(obj.hasClass('hidden') && obj.closest('.row').find('label .bs-tooltip').attr('class'))
			jQuery('.show-help-text button.show-tooltip').addClass('btn-primary');
		else if(obj.hasClass('hidden') && !obj.closest('.row').find('label .bs-tooltip').attr('class'))
			jQuery('.show-help-text button.none').addClass('btn-primary');
		else
			jQuery('.show-help-text button.bottom').addClass('btn-primary');
		
		//Bold
		jQuery('.help-text-bold').removeClass('label-primary');
			if(obj.hasClass('style_bold'))
				jQuery('.help-text-bold').addClass('label-primary');
		//Italic
		jQuery('.help-text-italic').removeClass('label-primary');
			if(obj.hasClass('style_italic'))
				jQuery('.help-text-italic').addClass('label-primary');
		
		//Size	
		jQuery('.help-text-size button').removeClass('btn-primary');
		if(obj.hasClass('input-lg'))
			jQuery('.help-text-size button.large').addClass('btn-primary');
		else if(obj.hasClass('input-sm'))
			jQuery('.help-text-size button.small ').addClass('btn-primary');
		else
			jQuery('.help-text-size button.normal').addClass('btn-primary');
		
		//Label Color
		jQuery('#help-text-color').bscolorpicker('setValue',colorToHex(obj.css('color')))
}

function populate_panel_settings(obj){
	//heading Color
	jQuery('#panel_heading_color').bscolorpicker('setValue',colorToHex(obj.find('.panel-heading').css('color')))
	//heading background
	jQuery('#panel_heading_background').bscolorpicker('setValue',colorToHex(obj.find('.panel-heading').css('background-color')))
	//Body Background
	jQuery('#panel_body_background').bscolorpicker('setValue',colorToHex(obj.find('.panel-body').css('background-color')))
	//Border Color
	jQuery('#panel_border_color').bscolorpicker('setValue',colorToHex(obj.css('border-top-color')))
	
	//Bold
	jQuery('.panel-head-bold').removeClass('label-primary');
		if(obj.find('.panel-heading').hasClass('style_bold'))
			jQuery('.panel-head-bold').addClass('label-primary');
	//Italic
	jQuery('.panel-head-italic').removeClass('label-primary');
		if(obj.find('.panel-heading').hasClass('style_italic'))
			jQuery('.panel-head-italic').addClass('label-primary');
			
	//Size	
		jQuery('.panel-heading-size button').removeClass('btn-primary');
		if(obj.find('.panel-heading').hasClass('btn-lg'))
			jQuery('.panel-heading-size button.large').addClass('btn-primary');
		else if(obj.find('.panel-heading').hasClass('btn-sm'))
			jQuery('.panel-heading-size button.small ').addClass('btn-primary');
		else
			jQuery('.panel-heading-size button.normal').addClass('btn-primary');
}

function populate_text_settings(obj){
	//show max count
	jQuery('input[name="show-max-count"]').prop('checked',false);
	if(obj.attr('data-maxlength-show')=='true')
		jQuery('input[name="show-max-count"]').prop('checked',true);
	//show max count	
	jQuery('.max-count-position li a').removeClass('alert-info');
		jQuery('.max-count-position li.'+obj.attr('data-maxlength-position') +' a').addClass('alert-info')
	
	jQuery('.max-count-color i').attr('class','');
		jQuery('.max-count-color i').addClass(obj.attr('data-maxlength-color')).removeClass('label');
	
}
function populate_select_settings(obj){
	//Size	
		jQuery('.input-size button').removeClass('btn-primary');
		if(obj.attr('data-input-size')=='btn-lg')
			jQuery('.input-size button.large').addClass('btn-primary');
		else if(obj.attr('data-input-size')=='btn-sm')
			jQuery('.input-size button.small').addClass('btn-primary');
		else
			jQuery('.input-size button.normal').addClass('btn-primary');	
}

function populate_radio_settings(obj){
		//Text Color\
		jQuery('#radio-label-color').bscolorpicker('setValue',colorToHex(obj.find('.input-label').css('color')))
		//Background color
		//jQuery('#radio-background-color').bscolorpicker('setValue',colorToHex(obj.find('a.fa').css('background-color')));
		//Border color
		//jQuery('#radio-border-color').bscolorpicker('setValue',colorToHex(obj.find('a.fa').css('border-top-color')))
		jQuery('.setting-radio.icons span#radio-icon').attr('class','current-icon fa '+ obj.attr('data-checked-class'));
		jQuery('.setting-radio.icons .icon_set li').removeClass('btn-primary');
		jQuery('.setting-radio.icons .icon_set li.'+obj.attr('data-checked-class')).addClass('btn-primary');
		
		jQuery('.radio-color-class i').attr('class',obj.attr('data-checked-color'));
		jQuery('.selected-radio-color li').removeClass('selected');
		jQuery('.selected-radio-color li a.'+obj.attr('data-checked-color')).parent().addClass('selected');
		
		
}
function populate_slider_settings(obj){
		jQuery('.setting-slider.icons .current-icon').attr('class','current-icon '+ obj.attr('data-dragicon'));
		jQuery('.setting-slider.icons .icon_set li').removeClass('btn-primary');
		if(obj.attr('data-dragicon'))
		jQuery('.setting-slider.icons .icon_set li.'+obj.attr('data-dragicon')).addClass('btn-primary');
		
		jQuery('.slider-color-class i').attr('class',obj.attr('data-dragicon-class'));
		jQuery('.slider-color-class i').removeClass('btn').removeClass('label');
		jQuery('.selected-slider-handel-color li').removeClass('selected');
		if(obj.attr('data-dragicon-class'))
			jQuery('.selected-slider-handel-color li a.'+obj.attr('data-dragicon-class')).parent().addClass('selected');
		//handel
		jQuery('#slide-handel-text-color').bscolorpicker('setValue',colorToHex(obj.attr('data-text-color')));
		jQuery('#slider-handel-background-color').bscolorpicker('setValue',colorToHex(obj.attr('data-handel-background-color')));
		jQuery('#slider-handel-border-color').bscolorpicker('setValue',colorToHex(obj.attr('data-handel-border-color')));
		//slide
		jQuery('#slider-background-color').bscolorpicker('setValue',colorToHex(obj.attr('data-background-color')));
		jQuery('#slider-border-color').bscolorpicker('setValue',colorToHex(obj.attr('data-slider-border-color')));
		jQuery('#slider-fill-color').bscolorpicker('setValue',colorToHex(obj.attr('data-fill-color')));	
}
function populate_spinner_settings(obj){
		//down
		jQuery('.setting-spinner.icons #down-icon').attr('class','current-icon '+ obj.attr('data-down-icon'));
		jQuery('.setting-spinner.icons .down_icon li').removeClass('btn-primary');
		
		jQuery('.spinner-down i').attr('class',obj.attr('data-down-class'));
		jQuery('.spinner-down i').removeClass('btn').removeClass('label');
		
		//up
		jQuery('.setting-spinner.icons #up-icon').attr('class','current-icon '+ obj.attr('data-up-icon'));
		jQuery('.setting-spinner.icons .up_icon li').removeClass('btn-primary');
		
		jQuery('.spinner-up i').attr('class',obj.attr('data-up-class'));
		jQuery('.spinner-up i').removeClass('btn').removeClass('label');
}
function populate_tag_settings(obj){
		jQuery('.setting-tags.icons #prefix-icon').attr('class','current-icon '+ obj.attr('data-tag-icon'));
		jQuery('.setting-tags.icons .icons li').removeClass('btn-primary');
		
		jQuery('.tag-color-class i').attr('class',obj.attr('data-tag-class'));
		jQuery('.tag-color-class i').removeClass('btn').removeClass('label');
		
		jQuery('#tags-text-color').bscolorpicker('setValue',colorToHex(obj.attr('data-text-color')));
		jQuery('#tags-border-color').bscolorpicker('setValue',colorToHex(obj.attr('data-border-color')));
		jQuery('#tags-background-color').bscolorpicker('setValue',colorToHex(obj.attr('data-background-color')));	
}

function populate_prefix_settings(obj){
		jQuery('.setting-prefix.icons #prefix-icon').attr('class','current-icon '+ obj.parent().find('.prefix').find('span').attr('class'));
		jQuery('.prefix-color-class i').attr('class',obj.parent().find('.prefix').attr('class'));
		jQuery('.prefix-color-class i').removeClass('input-group-addon').removeClass('prefix');
}
function populate_postfix_settings(obj){
		jQuery('.setting-postfix.icons #postfix-icon').attr('class','current-icon '+ obj.parent().find('.postfix').find('span').attr('class'));
		jQuery('.postfix-color-class i').attr('class',obj.parent().find('.postfix').attr('class'));
		jQuery('.postfix-color-class i').removeClass('input-group-addon').removeClass('postfix');
}



jQuery(document).ready(
function()
		{
		setTimeout('loading_nex_forms()',300);
		
		}
	);
var status = 0;
function loading_nex_forms()
	{	 
	setTimeout(
		function()
			{
			jQuery('.progress-bar-primary').attr('style','width:'+status+'%');
			}
	),300;
	status += 1;	
	if(status<=100)
	loading_nex_forms();
	}

 
(function($){
	
	$(window).load(function() { // makes sure the whole site is loaded

	   $('#status').delay(1500).fadeOut(); // will first fade out the loading animation
	   $('#preloader').delay(1501).fadeOut('fast'); // will fade out the white DIV that covers the website.
	   $('body').delay(1500).css({'overflow':'visible'});
	   
	   $('.express_msg').trigger('click');
	   
		////ANIMATION SETTINGS
		$('.animate_form button').live('click',
				function()
					{
					$('.animate_form button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					if($(this).hasClass('yes'))
						$('div.run_animation').text('true');
					else
						$('div.run_animation').text('false');
					
					}
				);
		

		
		
		$('.animate_time button').live('click',
				function()
					{
					$('.animate_time button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					if($(this).hasClass('30_frames'))
						$('div.animation_time').text('30');
					else if($(this).hasClass('60_frames'))
						$('div.animation_time').text('60');
					else if($(this).hasClass('90_frames'))
						$('div.animation_time').text('90');
					else if($(this).hasClass('120_frames'))
						$('div.animation_time').text('120');
					else if($(this).hasClass('150_frames'))
						$('div.animation_time').text('150');
					else if($(this).hasClass('180_frames'))
						$('div.animation_time').text('180');
					else
						$('div.animation_time').text('60');
					
					}
				);
	//AFILIATION SETTINGS
	$('#promo_text').val($('.submit-button small a').text())
			$('#promo_text').keyup(
				function()
					{
					$('.submit-button small a').text($(this).val());
					}
				);
	var promotext = $('.submit-button small a').attr('href');
	promotext1 = promotext.split('ref=');
	$('#envato_username').val(promotext1[1])
			$('#envato_username').keyup(
				function()
					{
					$('.submit-button small a').attr('href','http://codecanyon.net/user/Basix/portfolio?ref=' + $(this).val());
					}
				);
	
	
	setTimeout(
		function()
			{
				
			
			//LOAD GOOGLE FONTS
			jQuery('select.sfm.sample').stylesFontDropdown();
			//Label
			jQuery('select[name="input-fonts"]').html(jQuery('select.sfm.sample').html());
			jQuery('select[name="input-fonts"]').stylesFontDropdown();
			//Input
			jQuery('select[name="label-fonts"]').html(jQuery('select.sfm.sample').html());
			jQuery('select[name="label-fonts"]').stylesFontDropdown();
			//Help text
			jQuery('select[name="help-text-fonts"]').html(jQuery('select.sfm.sample').html());
			jQuery('select[name="help-text-fonts"]').stylesFontDropdown();
			//Panel heading
			jQuery('select[name="panel-fonts"]').html(jQuery('select.sfm.sample').html());
			jQuery('select[name="panel-fonts"]').stylesFontDropdown();
			
			},500
		);

	
	
	
	var current_id = '';
	var current_formcontainer_width = '';
	jQuery('div.nex-forms-container label .the_label, div.nex-forms-container  label small').live('click',function(){jQuery('.nav a:first').trigger('click').tab('show');});
	jQuery('div.nex-forms-container div.input-inner .the_input_element, div.nex-forms-container #the-radios a, div.nex-forms-container a.ui-slider-handle, div.nex-forms-container .bootstrap-tagsinput').live('click',function(){jQuery('.nav li:eq(1) a').trigger('click').tab('show'); $(this).popover('hide'); setTimeout(function(){ jQuery('.nav li:eq(1) a').trigger('click'); },200) });
	jQuery('div.nex-forms-container div.input-inner .help-block, div.nex-forms-container div.input-inner label .the_label .bs-tooltip').live('click',function(){jQuery('.nav li:eq(2) a').trigger('click').tab('show');});
	
	jQuery('div.nex-forms-container div.form_object button.edit, div.nex-forms-container label#title,div.nex-forms-container a.ui-slider-handle,div.nex-forms-container .bootstrap-tagsinput, div.nex-forms-container #the-radios a, div.nex-forms-container .grid .panel-heading, div.nex-forms-container div.input-inner .the_input_element, div.nex-forms-container div.input-inner .help-block').live('click',
		function(e)
			{
			
			
				
			if(!current_formcontainer_width)
				current_formcontainer_width = jQuery('div.nex-forms-container').outerWidth();

			jQuery('div#nex-forms-field-settings .current_id').text($(this).closest('.form_field').attr('id'));
			current_id = $('div#nex-forms-field-settings .current_id').text();

			
			$('.option-set li a').hide();
			if(jQuery('#'+current_id).hasClass('submit-button'))
				$('.option-set li a.input-element').show().trigger('click');
			else if(jQuery('#'+current_id).hasClass('grid'))
				$('.option-set li a.input-element').show().trigger('click');
			else if(jQuery('#'+current_id).hasClass('heading') || jQuery('#'+current_id).hasClass('divider') || jQuery('#'+current_id).hasClass('paragraph'))
				$('.option-set li a.input-element').show().trigger('click');
			else
				$('.option-set li a').show();
			
			
			
			
			if(!$('div#nex-forms-field-settings').hasClass('open'))
				{
				$('div#nex-forms-field-settings').animate(
					{
					right:0
					},500
				);
			
				$('div#nex-forms-field-settings').addClass('open');
				
				$('div.nex-forms-container').animate(
						{
						width:($('div.nex-forms-container').outerWidth()/2)
						},500
					);
				}	
				
			var current_obj = jQuery(this);
			setTimeout(
			function()
				{
				populate_label_settings(jQuery('#'+current_id).find('label#title'));
				populate_input_settings(jQuery('#'+current_id).find('.the_input_element'));
				populate_help_text_settings(jQuery('#'+current_id).find('.help-block'));
				populate_validation_settings(jQuery('#'+current_id).find('.error_message'))
				
				if(jQuery('#'+current_id).hasClass('text') || jQuery('#'+current_id).hasClass('textarea'))
					populate_text_settings(jQuery('#'+current_id).find('.the_input_element'));
				if(jQuery('#'+current_id).hasClass('select') || jQuery('#'+current_id).hasClass('multi-select'))
					populate_select_settings(jQuery('#'+current_id).find('#select'))
				if(jQuery('#'+current_id).hasClass('radio-group') || jQuery('#'+current_id).hasClass('multi-select'))	
					populate_radio_settings(jQuery('#'+current_id).find('.the-radios'));
				if(jQuery('#'+current_id).hasClass('slider'))	
					populate_slider_settings(jQuery('#'+current_id).find('#slider'));
				if(jQuery('#'+current_id).hasClass('touch_spinner'))	
					populate_spinner_settings(jQuery('#'+current_id).find('.the_input_element'));
				if(jQuery('#'+current_id).hasClass('tags'))	
					populate_tag_settings(jQuery('#'+current_id).find('.the_input_element'));
				if(jQuery('#'+current_id).hasClass('date') || jQuery('#'+current_id).hasClass('datetime') || jQuery('#'+current_id).hasClass('time') || jQuery('#'+current_id).hasClass('custom-prefix') || jQuery('#'+current_id).hasClass('custom-pre-postfix'))	
					populate_prefix_settings(jQuery('#'+current_id).find('.the_input_element'));
				if(jQuery('#'+current_id).hasClass('upload-single') || jQuery('#'+current_id).hasClass('custom-postfix') || jQuery('#'+current_id).hasClass('custom-pre-postfix'))	
					populate_postfix_settings(jQuery('#'+current_id).find('.the_input_element'));
				if(jQuery('#'+current_id).hasClass('grid'))	
					populate_panel_settings(jQuery('#'+current_id).find('.panel'));
				
				jQuery('.editing-field').removeClass('editing-field');
				current_obj.addClass('editing-field');
				
				jQuery('.nex-forms-field-settings input#set_label').trigger('focus');
				//jQuery('.editing-field').attr('style','');
				jQuery('.editing-field').animate(
						{
						outlineOffset:0,
						outlineWidth:1
						},300
					);	
				},50
			);

			


/***************/					
/*** PRE-POSTFIX ****/				
			$('.setting-prefix .icon_set i').click(
				function()
					{
					$('.icon_set i').removeClass('btn-primary');
					$('#'+current_id).find('.prefix span').attr('class',$(this).attr('class'));
					
					$(this).closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
					$(this).addClass('btn-primary');
					}
				);
			
				
			$('.dropdown-menu.prefix-color li a').click(
				function()
					{
					$('.dropdown-menu.prefix-color li').removeClass('selected')
					$(this).parent().addClass('selected');
					var current_class = $('#'+current_id).find('.prefix').attr('class');
					current_class = current_class.replace('alert-danger','');
					current_class = current_class.replace('alert-warning','');
					current_class = current_class.replace('alert-info','');
					current_class = current_class.replace('alert-success','');
					current_class = current_class.replace('label-danger','');
					current_class = current_class.replace('label-warning','');
					current_class = current_class.replace('label-primary','');
					current_class = current_class.replace('label-info','');
					current_class = current_class.replace('label-success','');
					
					$('#'+current_id).find('.prefix').attr('class',current_class)
					$('#'+current_id).find('.prefix').addClass($(this).attr('class'));
					$(this).closest('.input_holder').find('.colorpicker-element i').attr('class',$(this).attr('class'));
					}
				);	
				
			$('.setting-postfix .icon_set i').click(
				function()
					{
					$('.icon_set i').removeClass('btn-primary');
					$('#'+current_id).find('.postfix span').attr('class',$(this).attr('class'));
					
					$(this).closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
					$(this).addClass('btn-primary');
					}
				);
			
				
			$('.dropdown-menu.postfix-color li a').click(
				function()
					{
					$('.dropdown-menu.postfix-color li').removeClass('selected')
					$(this).parent().addClass('selected');
					var current_class = $('#'+current_id).find('.postfix').attr('class');
					current_class = current_class.replace('alert-danger','');
					current_class = current_class.replace('alert-warning','');
					current_class = current_class.replace('alert-info','');
					current_class = current_class.replace('alert-success','');
					current_class = current_class.replace('label-danger','');
					current_class = current_class.replace('label-warning','');
					current_class = current_class.replace('label-primary','');
					current_class = current_class.replace('label-info','');
					current_class = current_class.replace('label-success','');
					
					$('#'+current_id).find('.postfix').attr('class',current_class)
					$('#'+current_id).find('.postfix').addClass($(this).attr('class'));
					$(this).closest('.input_holder').find('.colorpicker-element i').attr('class',$(this).attr('class'));
					}
				);					
				
/***************/					
/*** LABELS ****/			
		//TEXT
			$('div#nex-forms-field-settings #set_label').val($('#'+current_id).find('label span.the_label').text())
			$('div#nex-forms-field-settings #set_label').keyup(
				function()
					{
					$('#'+current_id).find('label span.the_label').text($(this).val());
					$('#'+current_id).find('.draggable_object span.field_title').text($(this).val())
					$('#'+current_id).find('.the_input_element').attr('name',format_illegal_chars($(this).val()))
					
					if($('#'+current_id).hasClass('check-group') || $('#'+current_id).hasClass('multi-select'))
							$('#'+current_id).find('.the_input_element').attr('name',format_illegal_chars($(this).val())+'[]')
					
					}
				);
		//SUB TEXT
			$('div#nex-forms-field-settings #set_subtext').val($('#'+current_id).find('label small.sub-text').text())
			$('div#nex-forms-field-settings #set_subtext').keyup(
				function()
					{
					$('#'+current_id).find('label small.sub-text').text($(this).val())
					}
				);
		//POSITION
			$('.show-label button').click(
				function()
					{
					$('.show-label button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					var get_label = $('#'+current_id).find('label#title');
					
					get_label.parent().show();
					
					if($(this).hasClass('top'))
						{
						get_label.parent().attr('class','');
						get_label.parent().addClass('col-sm-12');
						$('#'+current_id).find('#field_container .row .col-sm-10').removeClass('col-sm-10').addClass('col-sm-12');
						}
					if($(this).hasClass('left'))
						{
						get_label.parent().attr('class','');
						get_label.parent().addClass('col-sm-2');
						$('#'+current_id).find('#field_container .row .col-sm-12').removeClass('col-sm-12').addClass('col-sm-10');
						}
					if($(this).hasClass('none'))
						{
						get_label.parent().hide();
						$('#'+current_id).find('#field_container .row .col-sm-10').removeClass('col-sm-10').addClass('col-sm-12');
						}
					
					}
				);
				
		//ALIGNMENT
			$('.align-label button').click(
				function()
					{
					$('.align-label button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_label = $('#'+current_id).find('label');
					get_label.removeClass('align_left').removeClass('align_right').removeClass('align_center');
					
					if($(this).hasClass('left'))
						get_label.addClass('align_left');
					if($(this).hasClass('right'))
						get_label.addClass('align_right');
					if($(this).hasClass('center'))
						get_label.addClass('align_center');
					}
				);
		//SIZE
			$('.label-size button').click(
				function()
					{
					$('.label-size button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_label = $('#'+current_id).find('label');
					get_label.removeClass('input-lg').removeClass('input-sm');
					
					if($(this).hasClass('small'))
						get_label.addClass('input-sm');
					if($(this).hasClass('large'))
						get_label.addClass('input-lg');
					}
				);
		//FONT
			$('select[name="label-fonts"]').change( function(){
				$(this).data('stylesFontDropdown').preview_font_change( $('#'+current_id).find('label#title') );
			});
			
			
//SET RADIOS / CHECKS

				var current_inputs = ''
				if($('#'+current_id).hasClass('check-group'))
					{
					$('#'+current_id).find('div#the-radios span.check-label').each(
						function()
							{
							current_inputs += $(this).text() +'\n';	
							}
						);	
					}
				else
					{
					$('#'+current_id).find('div#the-radios span.radio-label').each(
						function()
							{
							current_inputs += $(this).text() +'\n';	
							}
						);
					}
				$('div#nex-forms-field-settings #set_radios').val(current_inputs)
					$('div#nex-forms-field-settings #set_radios').live('change',
						function()
							{
								var items = jQuery(this).val();
								var set_inputs = '';
								items = items.split('\n');
								for (var i = 0; i < items.length; i++)
									{
									if(items[i]!='')
										{
										if($('#'+current_id).hasClass('check-group'))
										    set_inputs += '<label class="checkbox-inline" for="'+ format_illegal_chars(items[i]) +'"  data-svg="demo-input-1"><span class="svg_ready"><input class="check the_input_element" type="checkbox" name="'+ format_illegal_chars($('#'+current_id).find('.the_label').text()) +'" id="'+format_illegal_chars(items[i])+'" value="'+items[i]+'"><span class="input-label check-label">'+items[i]+'</span></span></label>';
										else
											set_inputs += '<label class="radio-inline" for="'+ format_illegal_chars(items[i]) +'"  data-svg="demo-input-1"><span class="svg_ready"><input class="radio the_input_element" type="radio" name="'+ format_illegal_chars($('#'+current_id).find('.the_label').text()) +'[]" id="'+format_illegal_chars(items[i])+'" value="'+items[i]+'"><span class="input-label radio-label">'+items[i]+'</span></span></label>';
										}
									}	
								$('#'+current_id).find('div#the-radios .input-inner').html(set_inputs);
								$('#'+current_id).find('div#the-radios input').nexchecks();
							}
						);	
						
/***************/			
/* FILE */						
						
			$('div#nex-forms-field-settings #set_extensions').val($('#'+current_id).find('div.get_file_ext').text())
			$('div#nex-forms-field-settings #set_extensions').live('change',
				function()
					{
					$('#'+current_id).find('div.get_file_ext').html(jQuery(this).val());
					}
				);			
				
/***************/			
/* SLIDER */
			
			//TEXT
			$('div#nex-forms-field-settings #minimum_value').val($('#'+current_id).find('#slider').attr('data-min-value'))
			$('div#nex-forms-field-settings #minimum_value').change(
				function()
					{
					$('#'+current_id).find( "#slider" ).attr('data-min-value',$(this).val());
					$('#'+current_id).find( "#slider" ).slider('option','min',parseInt($(this).val()))						
					}
				);
			
			$('div#nex-forms-field-settings #maximum_value').val($('#'+current_id).find('#slider').attr('data-max-value'))
			$('div#nex-forms-field-settings #maximum_value').change(
				function()
					{
					$('#'+current_id).find( "#slider" ).attr('data-max-value',$(this).val());
					$('#'+current_id).find( "#slider" ).slider('option','max',parseInt($(this).val()))					
					}
				);
			
			$('div#nex-forms-field-settings #start_value').val($('#'+current_id).find('#slider').attr('data-starting-value'))
			$('div#nex-forms-field-settings #start_value').change(
				function()
					{
					$('#'+current_id).find( "#slider" ).attr('data-starting-value',$(this).val());	
					$('#'+current_id).find( "#slider" ).slider('value',parseInt($(this).val()))				
					}
				);

			$('.setting-slider .icon_set i').click(
				function()
					{
					$('.icon_set i').removeClass('btn-primary');
					$('#'+current_id).find('#slider').attr('data-dragicon',$(this).attr('class'));
					
					$('#'+current_id).find('.ui-slider-handle span#icon').attr('class',$(this).attr('class'))
					
					$(this).closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
					$(this).addClass('btn-primary');
					
					}
				);
			$('.dropdown-menu.selected-slider-handel-color li a').click(
				function()
					{
					$('.dropdown-menu.selected-radio-color li').removeClass('selected')
					$(this).parent().addClass('selected');
					var current_class = $('#'+current_id).find('.ui-slider-handle').attr('class');
					current_class = current_class.replace('alert-danger','');
					current_class = current_class.replace('alert-warning','');
					current_class = current_class.replace('alert-info','');
					current_class = current_class.replace('alert-success','');
					current_class = current_class.replace('label-danger','');
					current_class = current_class.replace('label-warning','');
					current_class = current_class.replace('label-primary','');
					current_class = current_class.replace('label-info','');
					current_class = current_class.replace('label-success','');
					
					$('#'+current_id).find('.ui-slider-handle').attr('class',current_class)
					$('#'+current_id).find('.ui-slider-handle').addClass($(this).attr('class'));
					$('#'+current_id).find('#slider').attr('data-dragicon-class',$(this).attr('class'));
					$(this).closest('.input_holder').find('.colorpicker-element i').attr('class',$(this).attr('class'));
					}
				);	
		//COUNT TEXT
		$('div#nex-forms-field-settings #count_text').val($('#'+current_id).find('#slider').attr('data-count-text'))
		$('div#nex-forms-field-settings #count_text').keyup(
			function()
				{
				$('#'+current_id).find('#slider a.ui-slider-handle span.count-text').html($(this).val());
				$('#'+current_id).find('#slider').attr('data-count-text',$(this).val());
				}
			);
			

			
			$('div#nex-forms-field-settings #start_value').val($('#'+current_id).find('#slider').attr('data-starting-value'))
			$('div#nex-forms-field-settings #start_value').change(
				function()
					{
					$('#'+current_id).find( "#slider" ).attr('data-starting-value',$(this).val());	
					$('#'+current_id).find( "#slider" ).slider('value',parseInt($(this).val()))				
					}
				);
			

			$('.setting-slider .icon_set i').click(
				function()
					{
					$('.icon_set i').removeClass('btn-primary');
					$('#'+current_id).find('#slider').attr('data-dragicon',$(this).attr('class'));
					
					$('#'+current_id).find('.ui-slider-handle span#icon').attr('class',$(this).attr('class'))
					
					$(this).closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
					$(this).addClass('btn-primary');
					
					}
				);
			$('.dropdown-menu.selected-slider-handel-color li a').click(
				function()
					{
					$('.dropdown-menu.selected-radio-color li').removeClass('selected')
					$(this).parent().addClass('selected');
					var current_class = $('#'+current_id).find('.ui-slider-handle').attr('class');
					current_class = current_class.replace('alert-danger','');
					current_class = current_class.replace('alert-warning','');
					current_class = current_class.replace('alert-info','');
					current_class = current_class.replace('alert-success','');
					current_class = current_class.replace('label-danger','');
					current_class = current_class.replace('label-warning','');
					current_class = current_class.replace('label-primary','');
					current_class = current_class.replace('label-info','');
					current_class = current_class.replace('label-success','');
					
					$('#'+current_id).find('.ui-slider-handle').attr('class',current_class)
					$('#'+current_id).find('.ui-slider-handle').addClass($(this).attr('class'));
					$('#'+current_id).find('#slider').attr('data-dragicon-class',$(this).attr('class'));
					$(this).closest('.input_holder').find('.colorpicker-element i').attr('class',$(this).attr('class'));
					}
				);	
		//COUNT TEXT
		$('div#nex-forms-field-settings #count_text').val($('#'+current_id).find('#slider').attr('data-count-text'))
		$('div#nex-forms-field-settings #count_text').keyup(
			function()
				{
				$('#'+current_id).find('#slider a.ui-slider-handle span.count-text').html($(this).val());
				$('#'+current_id).find('#slider').attr('data-count-text',$(this).val());
				}
			);
			
/***************/			
/* STARS */
			
			//NUMBER OF STARS
			$('div#nex-forms-field-settings #total_stars').val($('#'+current_id).find('#star').attr('data-total-stars'))
			$('div#nex-forms-field-settings #total_stars').change(
				function()
					{
					$('#'+current_id).find( "#star" ).attr('data-total-stars',$(this).val());
					$('#'+current_id).find( "#star" ).raty('set',{ number: $(this).val() })					
					}
				);
			$('.enable-half-star button').click(
				function()
					{
					$('.enable-half-star button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					if($(this).hasClass('yes'))
						{
						$('#'+current_id).find( "#star" ).attr('data-enable-half','true');
						$('#'+current_id).find( "#star" ).raty('set',{ half: true });
						}
					else
						{
						$('#'+current_id).find( "#star" ).raty('set',{ half: false });
						$('#'+current_id).find( "#star" ).attr('data-enable-half','false');
						}
					
					}
				);
/***************/			
/* SPINNER */
			
			//TEXT
			$('div#nex-forms-field-settings #spin_minimum_value').val($('#'+current_id).find('#spinner').attr('data-minimum'))
			$('div#nex-forms-field-settings #spin_minimum_value').change(
				function()
					{
					$('#'+current_id).find( "#spinner" ).attr('data-minimum',$(this).val());
					$('#'+current_id).find( "#spinner" ).trigger("touchspin.updatesettings"	, {min:parseInt($(this).val())});				
					}
				);
			
			$('div#nex-forms-field-settings #spin_maximum_value').val($('#'+current_id).find('#spinner').attr('data-maximum'))
			$('div#nex-forms-field-settings #spin_maximum_value').change(
				function()
					{
					$('#'+current_id).find( "#spinner" ).attr('data-maximum',$(this).val());
					$('#'+current_id).find( "#spinner" ).trigger("touchspin.updatesettings"	, {max:parseInt($(this).val())});				
					}
				);
				
			$('div#nex-forms-field-settings #spin_start_value').val($('#'+current_id).find('#spinner').attr('data-starting-value'))
			$('div#nex-forms-field-settings #spin_start_value').change(
				function()
					{
					$('#'+current_id).find( "#spinner" ).attr('data-starting-value',$(this).val());
					$('#'+current_id).find( "#spinner" ).trigger("touchspin.updatesettings"	, { initval:parseInt($(this).val()) } );				
					}
				);
				
			$('div#nex-forms-field-settings #spin_step_value').val($('#'+current_id).find('#spinner').attr('data-step'))
			$('div#nex-forms-field-settings #spin_step_value').change(
				function()
					{
					$('#'+current_id).find( "#spinner" ).attr('data-step',$(this).val());
					$('#'+current_id).find( "#spinner" ).trigger("touchspin.updatesettings"	, { step:parseFloat($(this).val()) } );				
					}
				);
				
			$('div#nex-forms-field-settings #spin_decimal').val($('#'+current_id).find('#spinner').attr('data-decimals'))
			$('div#nex-forms-field-settings #spin_decimal').change(
				function()
					{
					$('#'+current_id).find( "#spinner" ).attr('data-decimals',$(this).val());
					$('#'+current_id).find( "#spinner" ).trigger("touchspin.updatesettings"	, { decimals:parseInt($(this).val()) } );				
					}
				);

			
			$('.dropdown-menu.spinner-down-color li a').click(
				function()
					{
					$('.dropdown-menu.spinner-down-color li').removeClass('selected')
					$(this).parent().addClass('selected');
					var current_class = $('#'+current_id).find('.bootstrap-touchspin-down').attr('class');
					current_class = current_class.replace('alert-danger','');
					current_class = current_class.replace('alert-warning','');
					current_class = current_class.replace('alert-info','');
					current_class = current_class.replace('alert-success','');
					current_class = current_class.replace('label-danger','');
					current_class = current_class.replace('label-warning','');
					current_class = current_class.replace('label-primary','');
					current_class = current_class.replace('label-info','');
					current_class = current_class.replace('label-success','');
					
					$('#'+current_id).find('.bootstrap-touchspin-down').attr('class',current_class)
					$('#'+current_id).find('.bootstrap-touchspin-down').addClass($(this).attr('class'));
					$('#'+current_id).find('#spinner').attr('data-down-class',$(this).attr('class'));
					$(this).closest('.input_holder').find('.colorpicker-element i').attr('class',$(this).attr('class'));
					}
				);	
			
			$('.setting-spinner .icon_set.down_icon i').click(
				function()
					{
					$('.icon_set.down_icon i').removeClass('btn-primary');
					$('#'+current_id).find('#spinner').attr('data-down-icon',$(this).attr('class'));
					$('#'+current_id).find('.bootstrap-touchspin-down .icon').attr('class','icon ' + $(this).attr('class'));
					
					$(this).closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
					$(this).addClass('btn-primary');
					}
				);
			
				
			$('.dropdown-menu.spinner-up-color li a').click(
				function()
					{
					$('.dropdown-menu.spinner-up-color li').removeClass('selected')
					$(this).parent().addClass('selected');
					var current_class = $('#'+current_id).find('.bootstrap-touchspin-up').attr('class');
					current_class = current_class.replace('alert-danger','');
					current_class = current_class.replace('alert-warning','');
					current_class = current_class.replace('alert-info','');
					current_class = current_class.replace('alert-success','');
					current_class = current_class.replace('label-danger','');
					current_class = current_class.replace('label-warning','');
					current_class = current_class.replace('label-primary','');
					current_class = current_class.replace('label-info','');
					current_class = current_class.replace('label-success','');
					
					$('#'+current_id).find('.bootstrap-touchspin-up').attr('class',current_class)
					$('#'+current_id).find('.bootstrap-touchspin-up').addClass($(this).attr('class'));
					$('#'+current_id).find('#spinner').attr('data-up-class',$(this).attr('class'));
					$(this).closest('.input_holder').find('.colorpicker-element i').attr('class',$(this).attr('class'));
					}
				);	
			
			$('.setting-spinner .icon_set.up_icon i').click(
				function()
					{
					$('.icon_set.up_icon  i').removeClass('btn-primary');
					$('#'+current_id).find('#spinner').attr('data-up-icon',$(this).attr('class'));
					$('#'+current_id).find('.bootstrap-touchspin-up .icon').attr('class','icon ' + $(this).attr('class'));
					
					$(this).closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
					$(this).addClass('btn-primary');
					}
				);
			
/***************/			
/* TAGS */
	
		
	$('div#nex-forms-field-settings #max_tags').val($('#'+current_id).find('#tags').attr('data-max-tags'))
	$('div#nex-forms-field-settings #max_tags').change(
		function()
			{
			$('#'+current_id).find( "#tags" ).attr('data-max-tags',$(this).val());				
			}
		);
	
	$('.dropdown-menu.tag-color li a').click(
		function()
			{
			$('.dropdown-menu.tag-color li').removeClass('selected')
			$(this).parent().addClass('selected');
			$('#'+current_id).find('#tags').attr('data-tag-class',$(this).attr('class'));
			
			$('#'+current_id).find('.bootstrap-tagsinput span.tag').attr('class','tag label '+ $(this).attr('class'))
			$(this).closest('.input_holder').find('.colorpicker-element i').attr('class',$(this).attr('class'));
			}
		);	
	
	$('.setting-tags .icon_set i').click(
				function()
					{
					$('.setting-tags .icon_set i').removeClass('btn-primary');
					$('#'+current_id).find('#tags').attr('data-tag-icon',$(this).attr('class'));
					
					$('#'+current_id).find('.bootstrap-tagsinput #tag-icon').attr('class',$(this).attr('class'))
					
					$(this).closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
					$(this).addClass('btn-primary');
					}
				);
/***************/			
/* Auto complete */

	$('div#nex-forms-field-settings #set_selections').val($('#'+current_id).find('.get_auto_complete_items').text())
			$('div#nex-forms-field-settings #set_selections').live('change',
				function()
					{
						$('#'+current_id).find('.get_auto_complete_items').text($(this).val());
						$('#'+current_id).find('select').selectpicker('refresh');
						
						var items = $(this).val();
							//console.log(items);
							items = items.split('\n');
							$('#'+current_id).find("#autocomplete").autocomplete({
							source: items
							});	
						
					}
				);	
/***************/			
/* PARAGRAPH */
		$('div#nex-forms-field-settings #set_paragraph').val($('#'+current_id).find('p.the_input_element').html())
		$('div#nex-forms-field-settings #set_paragraph').keyup(
			function()
				{
				$('#'+current_id).find('p.the_input_element').html($(this).val());
				}
			);
/***************/			
/* HEADING */
		$('div#nex-forms-field-settings #set_heading').val($('#'+current_id).find('.the_input_element').text())
		$('div#nex-forms-field-settings #set_heading').keyup(
			function()
				{
				$('#'+current_id).find('.the_input_element').html($(this).val());
				}
			);
/**********************/					
/*** PANEL SETTINGS ****/	
			//text
			$('div#nex-forms-field-settings #set_panel_heading').val($('#'+current_id).find('.panel-heading:first').html())
			$('div#nex-forms-field-settings #set_panel_heading').keyup(
				function()
					{
					$('#'+current_id).find('.panel-heading:first').text($(this).val());
					}
				);
			//font
			$('select[name="panel-fonts"]').change( function(){
				$(this).data('stylesFontDropdown').preview_font_change( $('#'+current_id).find('.panel-heading:first') );
			});	
			//size
			$('.panel-heading-size button').click(
				function()
					{
					$('.panel-heading-size button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_obj = $('#'+current_id).find('.panel-heading');
					get_obj.removeClass('input-lg').removeClass('input-sm').removeClass('btn-lg').removeClass('btn-sm');
					
						if($(this).hasClass('small'))
							get_obj.addClass('btn-sm');
						if($(this).hasClass('large'))
							get_obj.addClass('btn-lg');
					}
				);	
				
/***************/			
/* FIELD INPUT */	
		//REQUIRED
			$('.required button').click(
				function()
					{
					$('.required button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_input = $('#'+current_id).find('.the_input_element');
					var get_obj = $('#'+current_id).find('label');
					$('#'+current_id).removeClass('required')
					
					get_input.removeClass('required');
					get_obj.parent().find('.is_required').addClass('hidden')
						
					if($('#'+current_id).hasClass('select') || $('#'+current_id).hasClass('multi-select'))
						$('#'+current_id).find('select').attr('data-required','false').removeClass('required');
					
					if($(this).hasClass('yes'))
						{
						jQuery('#'+current_id).find('.error_message').popover('show');	
						jQuery('#'+current_id).find('.popover').addClass(jQuery('#'+current_id).find('.error_message').attr('data-error-class'));
						$('#'+current_id).addClass('required')
						get_input.addClass('required');
						get_obj.parent().find('.is_required').removeClass('hidden');
						
						if($('#'+current_id).hasClass('select') || $('#'+current_id).hasClass('multi-select'))
							$('#'+current_id).find('select').attr('data-required','true').addClass('required');
						
						}
					else
						{
						jQuery('#'+current_id).find('.error_message').popover('hide');
						}
					}
				);
		//REQUIRED STAR
			$('.required-star button').click(
				function()
					{
					$('.required-star button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					var get_obj = $('#'+current_id).find('label');
					
					if($(this).hasClass('empty'))
						get_obj.parent().find('.is_required').removeClass('glyphicon-star').removeClass('glyphicon-asterisk').addClass('glyphicon-star-empty');
					else if($(this).hasClass('asterisk'))
						get_obj.parent().find('.is_required').removeClass('glyphicon-star-empty').removeClass('glyphicon-star').addClass('glyphicon-asterisk');
					else
						get_obj.parent().find('.is_required').removeClass('glyphicon-star-empty').removeClass('glyphicon-asterisk').addClass('glyphicon-star');	
					}
				);
		
		
		//VALIDATE AS
		$('div#nex-forms-field-settings #set_secondary_error').val($('#'+current_id).find('.error_message').attr('data-secondary-message'))
			$('div#nex-forms-field-settings #set_secondary_error').keyup(
				function()
					{
					$('#'+current_id).find('.error_message').attr('data-secondary-message',$(this).val());
					}
				);
		$('ul.validate-as li a').live('click',
			function()
				{
				$('#'+current_id).find('input').removeClass('email').removeClass('url').removeClass('phone_number').removeClass('numbers_only').removeClass('text_only');
				$('#'+current_id).removeClass('email').removeClass('url').removeClass('phone_number').removeClass('numbers_only').removeClass('text_only');	
				
				$(this).closest('.input_holder').find('button.validate-as').html($(this).html());
				$('#'+current_id).find('input').addClass($(this).attr('class'));
				$('#'+current_id).addClass($(this).attr('class'));
				
				if($(this).hasClass('email'))
					$('#'+current_id).find('.error_message').attr('data-secondary-message','Invalid e-mail format');
				if($(this).hasClass('url'))
					$('#'+current_id).find('.error_message').attr('data-secondary-message','Invalid url format');
				if($(this).hasClass('phone_number'))
					$('#'+current_id).find('.error_message').attr('data-secondary-message','Invalid phone number format');
				if($(this).hasClass('numbers_only'))
					$('#'+current_id).find('.error_message').attr('data-secondary-message','Only numbers are allowed');
				if($(this).hasClass('text_only'))
					$('#'+current_id).find('.error_message').attr('data-secondary-message','Only text are allowed');
				
				$('div#nex-forms-field-settings #set_secondary_error').val($('#'+current_id).find('.error_message').attr('data-secondary-message'));
				
				}
		)
				
						
		//PLACE HOLDER
			$('div#nex-forms-field-settings #set_place_holder').val($('#'+current_id).find('.the_input_element').attr('placeholder'))
			$('div#nex-forms-field-settings #set_place_holder').keyup(
				function()
					{
					$('#'+current_id).find('.the_input_element').attr('placeholder', $(this).val());
					}
				);
			
		//DEFAULT VALUE
			$('div#nex-forms-field-settings #set_val').val( ($('#'+current_id).find('.the_input_element').val()) ? $('#'+current_id).find('.the_input_element').val() : $('#'+current_id).find('.the_input_element').text())
			$('div#nex-forms-field-settings #set_val').keyup(
				function()
					{
					$('#'+current_id).find('.the_input_element').val($(this).val());
					$('#'+current_id).find('.the_input_element').attr('data-default-value',$(this).val());
					
					if($('#'+current_id).hasClass('submit-button'))
						$('#'+current_id).find('.the_input_element').text($(this).val());
					
					}
				);
		  
		//MAX LENTGH
			$('div#nex-forms-field-settings #set_max_length').val($('#'+current_id).find('.the_input_element').attr('maxlength'))
			$('div#nex-forms-field-settings #set_max_length').keyup(
				function()
					{
					$('#'+current_id).find('.the_input_element').attr('maxlength',$(this).val());
					$('#'+current_id).find('.the_input_element').maxlength({ placement:($('#'+current_id).find('.the_input_element').attr('data-maxlength-position')) ? $('#'+current_id).find('.the_input_element').attr('data-maxlength-position') : 'bottom', alwaysShow: true, set_ID: current_id, warningClass: 'label' + ($('#'+current_id).find('.the_input_element').attr('data-maxlength-color')) ? $('#'+current_id).find('.the_input_element').attr('data-maxlength-color') : 'label-success' });
					}
				);
			$('.dropdown-menu.max-count-position li').click(
				function()
					{
					$('.dropdown-menu.max-count-position li a').removeClass('alert-info');
					$(this).find('a').addClass('alert-info');
					$('#'+current_id).find('.the_input_element').attr('data-maxlength-position',$(this).attr('class'));
					$('#'+current_id).find('.the_input_element').maxlength({ placement:$(this).attr('class'), alwaysShow: true, set_ID: current_id, warningClass: 'label' + ($('#'+current_id).find('.the_input_element').attr('data-maxlength-color')) ? $('#'+current_id).find('.the_input_element').attr('data-maxlength-color') : 'label-success' });
					}
				);
			$('.dropdown-menu.count-color li a').click(
				function()
					{
					$(this).closest('.input-group-btn').find('.colorpicker-element i').attr('class',$(this).attr('class'));
					$('#'+current_id).find('.the_input_element').attr('data-maxlength-color','label '+$(this).attr('class'));
					$('#'+current_id).find('.the_input_element').maxlength({ placement:($('#'+current_id).find('.the_input_element').attr('data-maxlength-position')) ? $('#'+current_id).find('.the_input_element').attr('data-maxlength-position') : 'bottom', alwaysShow: true, set_ID: current_id, warningClass: 'label '+ $(this).attr('class') });
					
					}
				);
			$( 'input[name="show-max-count"]' ).live('click',
				function()
					{
					if($(this).prop( "checked" ))
					   {	
					   $(this).closest('.input-group').find('.input-group-btn').show()
					   $('#'+current_id).find('.the_input_element').maxlength({ placement:($('#'+current_id).find('.the_input_element').attr('data-maxlength-position')) ? $('#'+current_id).find('.the_input_element').attr('data-maxlength-position') : 'bottom', alwaysShow: true, set_ID: current_id, warningClass: 'label' +($('#'+current_id).find('.the_input_element').attr('data-maxlength-color')) ? $('#'+current_id).find('.the_input_element').attr('data-maxlength-color') : 'label-success' });
					   $('#'+current_id).find('.the_input_element').attr('data-maxlength-show','true');
					   }
					else
						{
					  	$(this).closest('.input-group').find('.input-group-btn').hide();
						$('#'+current_id).find('.the_input_element').maxlength({ alwaysShow: false, set_ID: current_id });
						$('#'+current_id).find('.the_input_element').attr('data-maxlength-show','false');
						}
					}
				);
		//ALIGNMENT
			$('.align-input button').click(
				function()
					{
					$('.align-input button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_obj = $('#'+current_id).find('.the_input_element');
					get_obj.removeClass('align_left').removeClass('align_right').removeClass('align_center').removeClass('align_justify');
					var set_class =  ''
					if($(this).hasClass('left'))
						set_class = 'align_left';
					if($(this).hasClass('right'))
						set_class = 'align_right';
					if($(this).hasClass('center'))
						set_class = 'align_center';
					if($(this).hasClass('justify'))
						set_class = 'align_justify';
					
					get_obj.addClass(set_class);
						
					if($('#'+current_id).hasClass('select') || $('#'+current_id).hasClass('multi-select'))
							$('#'+current_id).find('select').attr('data-text-alignment',set_class);
							
					if($('#'+current_id).hasClass('multi-select'))
							get_obj.parent().attr('data-text-alignment',set_class);
					
					if($('#'+current_id).hasClass('submit-button'))
						{
						get_obj.parent().removeClass('align_left').removeClass('align_right').removeClass('align_center').removeClass('align_justify');
						get_obj.parent().find('small').attr('class',set_class);
						get_obj.parent().addClass(set_class);
						}
					}
				);
		
		//CORNERS
		$('.input-corners button').click(
				function()
					{
					$('.input-corners button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_obj = $('#'+current_id);
					var set_class ='';
					get_obj.removeClass('square').removeClass('full_rounded');
					if($(this).hasClass('square'))
						set_class = 'square';
					if($(this).hasClass('full_rounded'))
						set_class = 'full_rounded';
					
					get_obj.addClass(set_class);
					}
				);
		//SIZE
		
		
			$('.input-size button').click(
				function()
					{
					$('.input-size button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_obj = $('#'+current_id).find('.the_input_element');
					get_obj.removeClass('input-lg').removeClass('input-sm').removeClass('btn-lg').removeClass('btn-sm');
					
						
					if($('#'+current_id).hasClass('select') || $('#'+current_id).hasClass('multi-select'))
						{
						$('#'+current_id).find('select').attr('data-input-size','');
						if($(this).hasClass('small'))
							{
							$('#'+current_id).find('select').attr('data-input-size','btn-sm');
							$('#'+current_id).find('.selectpicker').addClass('btn-sm')
							} 
						if($(this).hasClass('large'))
							{
							$('#'+current_id).find('select').attr('data-input-size','btn-lg');
							$('#'+current_id).find('.selectpicker').addClass('btn-lg')
							}
						}
					else
						{
						if($(this).hasClass('small'))
							get_obj.addClass('input-sm');
						if($(this).hasClass('large'))
							get_obj.addClass('input-lg');	
						}
					}
				);	
		//FONT
			$('select[name="input-fonts"]').change( function(){
				$(this).data('stylesFontDropdown').preview_font_change( $('#'+current_id).find('.the_input_element') );
				if($('#'+current_id).hasClass('select') || $('#'+current_id).hasClass('multi-select'))
					$('#'+current_id).find('select').attr('data-font-family',$('select[name="input-fonts"] option:selected').attr('class'));
			});
			
			$( 'input[name="show-font-preview"]' ).live('click',
				function()
					{
					if($(this).prop( "checked" ))	
					   $(this).closest('.input-group').find('.chosen-container').addClass('sfm')
					else
					  $(this).closest('.input-group').find('.chosen-container').removeClass('sfm')
					}
				);
			
		//BORDER
			$( 'input[name="drop-focus-swadow"]' ).live('click',
				function()
					{
					if($(this).prop( "checked" ))	
					  $('#'+current_id).find('.the_input_element').attr('data-drop-focus-swadow','1')
					else
						 $('#'+current_id).find('.the_input_element').attr('data-drop-focus-swadow','0')
					}
				);
			
		//SELECT OPTIONS
			var current_options = ''
			$('#'+current_id).find('select option').each(
				function()
					{
					if($(this).val()!='0')
					current_options += $(this).text() +'\n';	
					}
				);
			$('div#nex-forms-field-settings #set_default_value').val($('#'+current_id).find('#select option:selected').text())
			$('div#nex-forms-field-settings #set_default_value').change(
				function()
					{
					$(this).closest('#categorize_container').find('.prepopulate_target textarea').trigger('change');
					}
				);
			$('div#nex-forms-field-settings #set_options').val(current_options)
			$('div#nex-forms-field-settings #set_options').live('change',
				function()
					{
						var items = jQuery(this).val();
						var set_options = '<option value="0" selected="selected">'+ $('div#nex-forms-field-settings #set_default_value').val() +'</option>';
						var set_selections = '';
						items = items.split('\n');
						for (var i = 0; i < items.length; i++)
							{
							if(items[i]!='')
								{
								set_options += '<option value="'+ items[i] +'">'+ items[i] +'</option>';
								}
							}	
						$('#'+current_id).find('select').html(set_options);
						$('#'+current_id).find('select').selectpicker('refresh');
					}
				);
		
		$('ul.prepopulate li a').live('click',
			function()
				{
				var container = $(this).closest('#categorize_container').find('.prepopulate_target textarea');
				container.val($('div.preload.'+ $(this).attr('class') ).text())
				setTimeout(
					function()
						{
						container.trigger('change');
						},300
					);
				}
			);
		$('#the_error_mesage').val($('#'+current_id).find('.error_message').attr('data-content'))
		$('div#nex-forms-field-settings #the_error_mesage').keyup(
			function()
				{
				$('#'+current_id).find('.error_message').attr('data-content',$(this).val());
				$('#'+current_id).find('.popover-content').html($(this).val());
				}
			);	
/***************/		
/** HELP TEXT **/
		//TEXT
			$('div#nex-forms-field-settings #set_help_text').val($('#'+current_id).find('.help-block').text())
			$('div#nex-forms-field-settings #set_help_text').keyup(
				function()
					{
					$('#'+current_id).find('.help-block').text($(this).val());
					$('#'+current_id).find('.bs-tooltip').attr('title',$(this).val());
					$('#'+current_id).find('.bs-tooltip').attr('data-original-title',$(this).val());
					}
				);
		
		//POSITION
			$('.show-help-text button').click(
				function()
					{
					$('.show-help-text button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					var get_help_block = $('#'+current_id).find('.help-block');
					var get_label = $('#'+current_id).find('label .the_label');
					
					if($(this).hasClass('show-tooltip'))
						{
						get_help_block.addClass('hidden');
						if(!get_label.find('.bs-tooltip').attr('class'))
							{
							get_label.prepend('<span class="bs-tooltip glyphicon fa fa-question-circle" data-placement="top" data-toggle="tooltip" title="'+ get_help_block.text() +'">&nbsp;</span>')
							get_label.find('.bs-tooltip').tooltip();
							}
						}
					if($(this).hasClass('bottom'))
						{
						get_help_block.removeClass('hidden');
						get_label.find('.bs-tooltip').remove();
						}
					if($(this).hasClass('none'))
						{
						get_help_block.addClass('hidden');
						get_label.find('.bs-tooltip').remove();
						}
					}
				);
		
		
		//ALIGNMENT
			$('.align-help-text button').click(
				function()
					{
					$('.align-help-text button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_label = $('#'+current_id).find('.help-block');
					get_label.removeClass('align_left').removeClass('align_right').removeClass('align_center');
					
					if($(this).hasClass('left'))
						get_label.addClass('align_left');
					if($(this).hasClass('right'))
						get_label.addClass('align_right');
					if($(this).hasClass('center'))
						get_label.addClass('align_center');
					}
				);			
		//SIZE
			$('.help-text-size button').click(
				function()
					{
					$('.help-text-size button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_label = $('#'+current_id).find('.help-block');
					get_label.removeClass('input-lg').removeClass('input-sm');
					
					if($(this).hasClass('small'))
						get_label.addClass('input-sm');
					if($(this).hasClass('large'))
						get_label.addClass('input-lg');
					}
				);
		//FONT
			$('select[name="help-text-fonts"]').change( function(){
				$(this).data('stylesFontDropdown').preview_font_change( $('#'+current_id).find('.help-block') );
			});			
		}
	);

/***********************/					
/*** ERROR MESSAGES ****/			
		//TEXT
		
				
		//Title
		/*setTimeout(
			function()
				{
				$('div#nex-forms-field-settings #set_error_title').val($('#'+current_id).find('.the_input_element').attr('title'))
				},100
			);
			$('div#nex-forms-field-settings #set_error_title').keyup(
				function()
					{
					$('#'+current_id).find('.error_message').attr('title',$(this).val());
					$('#'+current_id).find('.popover-title').html($(this).val());
					}
				);*/
			$('.dropdown-menu.error-color li a').click(
				function()
					{
					$(this).closest('.input-group-btn').find('.colorpicker-element i').attr('class',$(this).attr('class'));
					$('#'+current_id).find('.popover').removeClass('alert-success').removeClass('alert-warning').removeClass('alert-danger').removeClass('alert-info')
					$('#'+current_id).find('.popover').addClass($(this).attr('class'));
					$('#'+current_id).find('.error_message').attr('data-error-class',$(this).attr('class'));
					}
				);
		
		//POSITION
			$('.error-position button').click(
				function()
					{
					$('.error-position button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					var get_input = $('#'+current_id).find('.error_message');
					var current_class = get_input.parent().find('.popover').attr('data-class');
					get_input.popover('destroy');
					if($(this).hasClass('top'))
						{
						get_input.attr('data-placement','top');
						get_input.popover({placement:'top',html:true});
						}
					if($(this).hasClass('right'))
						{
						get_input.attr('data-placement','right');
						get_input.popover({placement:'right',html:true});
						}
					if($(this).hasClass('bottom'))
						{
						get_input.attr('data-placement','bottom');
						get_input.popover({placement:'bottom', html:true});
						}
					if($(this).hasClass('left'))
						{
						get_input.attr('data-placement','left');
						get_input.popover({placement:'left',html:true});
						}
					
					get_input.popover('show');
					get_input.parent().find('.popover').addClass(get_input.attr('data-error-class'));
					}
				);
		//ALIGNMENT
			$('.align-label button').click(
				function()
					{
					$('.align-label button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_label = $('#'+current_id).find('label');
					get_label.removeClass('align_left').removeClass('align_right').removeClass('align_center');
					
					if($(this).hasClass('left'))
						get_label.addClass('align_left');
					if($(this).hasClass('right'))
						get_label.addClass('align_right');
					if($(this).hasClass('center'))
						get_label.addClass('align_center');
					}
				);
		//SIZE
			$('.label-size button').click(
				function()
					{
					$('.label-size button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_label = $('#'+current_id).find('label');
					get_label.removeClass('input-lg').removeClass('input-sm');
					
					if($(this).hasClass('small'))
						get_label.addClass('input-sm');
					if($(this).hasClass('large'))
						get_label.addClass('input-lg');
					}
				);
		//FONT
			$('select[name="error-fonts"]').change( function(){
				$(this).data('stylesFontDropdown').preview_font_change( $('#'+current_id).find('label') );
			});	
			
/**********************/					
/*** RADIO BUTTONS ****/		
		$('.setting-radio .icon_set i').click(
				function()
					{
					$('.icon_set i').removeClass('btn-primary');
					$(this).closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
					
					var get_class = $(this).attr('class') + ' fa ' + $('.dropdown-menu.selected-radio-color li.selected a').attr('class') ;
					$(this).addClass('btn-primary');
					
					var radio_group = $('#'+current_id).find('.the-radios');
					
					$('#'+current_id).find('input').each(function(index, el){
						if($(el).prop('checked')==true)
						 $(el).parent().find('a:first').attr('class','checked fa '+ get_class)
						else
						 $(el).parent().find('a:first').attr('class','fa ')
						
						$(el).parent().find('a').addClass('fa')
						}
					);
					radio_group.attr('data-checked-class',get_class);
					
					}
				);
		$('.dropdown-menu.selected-radio-color li a').click(
				function()
					{
					var radio_group = $('#'+current_id).find('.the-radios');
					var current_attr = radio_group.attr('data-checked-class');
					$('.dropdown-menu.selected-radio-color li').removeClass('selected')
					$(this).parent().addClass('selected');
					
					$(this).closest('.input_holder').find('.colorpicker-element i').attr('class',$(this).attr('class'));
					current_attr = current_attr.replace('alert-danger','');
					current_attr = current_attr.replace('alert-warning','');
					current_attr = current_attr.replace('alert-info','');
					current_attr = current_attr.replace('alert-success','');
					current_attr = current_attr.replace('label-danger','');
					current_attr = current_attr.replace('label-warning','');
					current_attr = current_attr.replace('label-primary','');
					current_attr = current_attr.replace('label-info','');
					current_attr = current_attr.replace('label-success','');
					
					var new_class = current_attr + ' fa ' + $(this).attr('class');
					radio_group.attr('data-checked-class', new_class);
					radio_group.attr('data-checked-color', $(this).attr('class'))
					
					$('#'+current_id).find('input').each(function(index, el){
						if($(el).prop('checked')==true)
						 $(el).parent().find('a:first').attr('class','checked fa '+ new_class)
						else
						 $(el).parent().find('a:first').attr('class','')	
						}
					);
					
					}
				);	
		$('.display-radios-checks button').click(
				function()
					{
					$('.display-radios-checks button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					$('#'+current_id).find('.the-radios label').removeClass('col-sm-3').removeClass('col-sm-4').removeClass('col-sm-6')	.removeClass('col-sm-12');				
					
					if($(this).hasClass('1c'))
						$('#'+current_id).find('.the-radios label').addClass('col-sm-12').addClass('display-block');
					else if($(this).hasClass('2c'))
						$('#'+current_id).find('.the-radios label').addClass('col-sm-6').addClass('display-block');
					else if($(this).hasClass('3c'))
						$('#'+current_id).find('.the-radios label').addClass('col-sm-4').addClass('display-block');
					else if($(this).hasClass('4c'))
						$('#'+current_id).find('.the-radios label').addClass('col-sm-3').addClass('display-block');
					else
						$('#'+current_id).find('.the-radios label').removeClass('display-block');
					}
				);


/**********************/		
/** BOLD AND ITALICS **/		
	 
		 //LABEL BOLD
			$('span.label-bold').live('click',
				function()
					{
					if($('#'+current_id).find('span.the_label').hasClass('style_bold'))
						{
						$('#'+current_id).find('span.the_label').removeClass('style_bold');
						$(this).removeClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('span.the_label').addClass('style_bold');
						$(this).addClass('label-primary');
						}
					}
				);
		//LABEL ITALIC
			$('span.label-italic').live('click',
				function()
					{
					if(!$(this).hasClass('label-primary'))
						{
						$('#'+current_id).find('label span.the_label').addClass('style_italic');
						$(this).addClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('label span.the_label').removeClass('style_italic');
						$(this).removeClass('label-primary');
						}
					}
				);
	 	//SUB LABEL BOLD
			$('span.sub-label-bold').live('click',
				function()
					{
					if(!$(this).hasClass('label-primary'))
						{
						$('#'+current_id).find('label small.sub-text').addClass('style_bold');
						$(this).addClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('label small.sub-text').removeClass('style_bold');
						$(this).removeClass('label-primary');
						}
					}
				);
		//SUB LABEL ITALIC
			$('span.sub-label-italic').live('click',
				function()
					{
					if(!$(this).hasClass('label-primary'))
						{
						$('#'+current_id).find('label small.sub-text').addClass('style_italic');
						$(this).addClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('label small.sub-text').removeClass('style_italic');
						$(this).removeClass('label-primary');
						}
					}
				);
	 	//INPUT BOLD
			$('span.input-bold').live('click',
				function()
					{
					if(!$(this).hasClass('label-primary'))
						{
						$('#'+current_id).find('.the_input_element').addClass('style_bold');
						$(this).addClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('.the_input_element').removeClass('style_bold');
						$(this).removeClass('label-primary');
						}
					}
				);
		//INPUT ITALIC
			$('span.input-italic').live('click',
				function()
					{
					if(!$(this).hasClass('label-primary'))
						{
						$('#'+current_id).find('.the_input_element').addClass('style_italic');
						$(this).addClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('.the_input_element').removeClass('style_italic');
						$(this).removeClass('label-primary');
						}
					}
				);	
	    //HELP TEXT BOLD
			$('span.help-text-bold').live('click',
				function()
					{
					if(!$(this).hasClass('label-primary'))
						{
						$('#'+current_id).find('.help-block').addClass('style_bold');
						$(this).addClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('.help-block').removeClass('style_bold');
						$(this).removeClass('label-primary');
						}
					}
				);
		//HELP TEXT  ITALIC
			$('span.help-text-italic').live('click',
				function()
					{
					if(!$(this).hasClass('label-primary'))
						{
						$('#'+current_id).find('.help-block').addClass('style_italic');
						$(this).addClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('.help-block').removeClass('style_italic');
						$(this).removeClass('label-primary');
						}
					}
				);	
				
		
		//SLIDER COUNT TEXT BOLD
			$('span.count-text-bold').live('click',
				function()
					{
					if(!$(this).hasClass('label-primary'))
						{
						$('#'+current_id).find('a.ui-slider-handle span.count-text').addClass('style_bold');
						$(this).addClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('a.ui-slider-handle span.count-text').removeClass('style_bold');
						$(this).removeClass('label-primary');
						}
					}
				);
		//SLIDER COUNT TEXT  ITALIC
			$('span.count-text-italic').live('click',
				function()
					{
					if(!$(this).hasClass('label-primary'))
						{
						$('#'+current_id).find('a.ui-slider-handle').addClass('style_italic');
						$(this).addClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('a.ui-slider-handle').removeClass('style_italic');
						$(this).removeClass('label-primary');
						}
					}
				);	
		//PANEL HEAD BOLD
			$('span.panel-head-bold').live('click',
				function()
					{
					if($('#'+current_id).find('.panel .panel-heading').hasClass('style_bold'))
						{
						$('#'+current_id).find('.panel .panel-heading').removeClass('style_bold');
						$(this).removeClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('.panel .panel-heading').addClass('style_bold');
						$(this).addClass('label-primary');
						}
					}
				);
		//PANEL HEAD ITALIC
			$('span.panel-head-italic').live('click',
				function()
					{
					if(!$(this).hasClass('label-primary'))
						{
						$('#'+current_id).find('.panel .panel-heading').addClass('style_italic');
						$(this).addClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('.panel .panel-heading').removeClass('style_italic');
						$(this).removeClass('label-primary');
						}
					}
				);
/*****************/	 
/* COLOR PICKERS */
	setTimeout(
		function()
			{
			jQuery('.nex-forms-field-settings input').focus(function() { jQuery(this).select() });

		//Label
			jQuery('#label-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('label span.the_label').css('color',ev.color.toHex());
			 $('#'+current_id).find('.is_required').css('color',ev.color.toHex());
			});
			
		//Subtext
			jQuery('#label-subtext').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('label small').css('color',ev.color.toHex());
			});
			
		//Input Color
			jQuery('#input-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.the_input_element').css('color',ev.color.toHex());
			 
			 if($('#'+current_id).hasClass('select') || $('#'+current_id).hasClass('multi-select'))
				{
				$('#'+current_id).find('select').attr('data-text-color',ev.color.toHex());
				$('#'+current_id).find('.selectpicker a').css('color',ev.color.toHex());
				}
			 
			});
			  
		//Input BG Color
			jQuery('#input-bg-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.the_input_element').css('background',ev.color.toHex());
			  if($('#'+current_id).hasClass('select') || $('#'+current_id).hasClass('multi-select'))
				$('#'+current_id).find('select').attr('data-background-color',ev.color.toHex());
			});
			
		//Input border Color
			jQuery('#input-border-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.the_input_element').css('border-color',ev.color.toHex());
			 	if($('#'+current_id).hasClass('select') || $('#'+current_id).hasClass('multi-select'))
					$('#'+current_id).find('select').attr('data-border-color',ev.color.toHex());
			});
			
		//Input border on focus Color
			jQuery('#input-onfocus-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.the_input_element').attr('data-onfocus-color',ev.color.toHex());
			});
			
		//Help Text Color
			jQuery('#help-text-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.help-block').css('color',ev.color.toHex());
			});
		
		//Radio Check Text Color
			jQuery('#radio-label-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.input-label').css('color',ev.color.toHex());
			});
		
		//Radio Check background color
			jQuery('#radio-background-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('a').css('background',ev.color.toHex());
			});
		
		//Radio Check border color
			jQuery('#radio-border-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('a').css('border-color',ev.color.toHex());
			});	
			
		
		//Slider text color
			jQuery('#slide-handel-text-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('a.ui-slider-handle').css('color',ev.color.toHex());
			 $('#'+current_id).find('#slider').attr('data-text-color',ev.color.toHex());
			});	
		//Handel border color
			jQuery('#slider-handel-border-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('a.ui-slider-handle').css('border-color',ev.color.toHex());
			 $('#'+current_id).find('#slider').attr('data-handel-border-color',ev.color.toHex());
			});	
		
		//Handel Background color
			jQuery('#slider-handel-background-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('a.ui-slider-handle').css('background-color',ev.color.toHex());
			  $('#'+current_id).find('#slider').attr('data-handel-background-color',ev.color.toHex());
			});	
		
		//Slider border color
			jQuery('#slider-border-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.ui-widget-content').css('border-color',ev.color.toHex());
			 $('#'+current_id).find('#slider').attr('data-slider-border-color',ev.color.toHex());
			});	
		//Slider background color
			jQuery('#slider-background-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('#slider').css('background',ev.color.toHex())
			 $('#'+current_id).find('#slider').attr('data-background-color',ev.color.toHex());
			});	
		//Slider fill color
			jQuery('#slider-fill-color').bscolorpicker().on('changeColor', function(ev){
	
			$('#'+current_id).find('.ui-slider-range').css('background',ev.color.toHex());
			 $('#'+current_id).find('#slider').attr('data-fill-color',ev.color.toHex());
			});	
		
		
		
		//Tags text color
			jQuery('#tags-text-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.bootstrap-tagsinput input').css('color',ev.color.toHex());
			  $('#'+current_id).find('#tags').attr('data-text-color',ev.color.toHex());
			});	
		
		//Tags border color
			jQuery('#tags-border-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.bootstrap-tagsinput').css('border-color',ev.color.toHex());
			 $('#'+current_id).find('#tags').attr('data-border-color',ev.color.toHex());
			});	
		//Tags background color
			jQuery('#tags-background-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.bootstrap-tagsinput').css('background',ev.color.toHex());
			 $('#'+current_id).find('#tags').attr('data-background-color',ev.color.toHex());
			});	
		
		//Panel Heading Color
			jQuery('#panel_heading_color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.panel-heading:first').css('color',ev.color.toHex());
			});	
		//Panel Heading Background
			jQuery('#panel_heading_background').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.panel-heading:first').css('background',ev.color.toHex());
			});	
		//Panel body Background
			jQuery('#panel_body_background').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.panel-body:first').css('background',ev.color.toHex());
			});	
		//Panel border color
			jQuery('#panel_border_color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.panel:first').css('border-color',ev.color.toHex());
			});	
		
			
		//RESET COLOR TO DEFAULT
			$('.colorpicker-component').find('.reset').live('click',
				function()
					{
					$(this).closest('.colorpicker-component').bscolorpicker('setValue',$(this).attr('data-default'))
					}
				);
				
			},1500
		);
	
	
	
	
	//Duplicate field
	$('span.copy-field').live('click',
		function()
			{
			jQuery(this).removeClass('btn-info').addClass('btn-success');
			var duplication = $('#'+current_id).clone();
			$(duplication).insertAfter($('#'+current_id));
			duplication.attr('id','_' + Math.round(Math.random()*99999));
			jQuery(duplication).find('label#title').trigger('click');
			if(duplication.hasClass('select') || duplication.hasClass('multi-select'))
				{
				duplication.find('.bootstrap-select').remove();
				duplication.find('select').selectpicker('refresh');
				}
			
			setTimeout(function(){ $('span.copy-field').removeClass('btn-success').addClass('btn-info'); },1000);
			}
		);
	
	//Duplicate field
	$('span.copy-to-clipboard').live('click',
		function()
			{
			
			jQuery(this).removeClass('btn-info').addClass('btn-success');
			var duplication = $('#'+current_id).clone();
			duplication.addClass('field');
			duplication.removeClass('dropped');
			duplication.removeClass('editing-field');
			duplication.find('div.draggable_object').attr('style','');
			duplication.find('div.form_object').hide();
			if(duplication.hasClass('select') || duplication.hasClass('multi-select'))
				{
				duplication.find('.bootstrap-select').remove();
				}
			duplication.draggable(
			{
			drag: function( event, ui ) { },
			stop: function( event, ui ) { setTimeout(function(){ jQuery('.col2 .admin-panel .panel-heading .btn.glyphicon-hand-down').trigger('click');},300 ); },
			stack  : '.draggable',
			revert : 'invalid', 
			tolerance: 'intersect',
			connectToSortable:'.nex-forms-container',
			snap:false,
			helper : 'clone',
			}
        );
		setTimeout(function(){ $('span.copy-to-clipboard').removeClass('btn-success').addClass('btn-info'); },1000);
		duplication.attr('id','_' + Math.round(Math.random()*99999));
			$('.panel-body.clip-board').append(duplication);
			}
		);
		
	//Delete Field
	jQuery('span.delete-field').live('click',
		function()
			{
			$('#'+current_id).fadeOut(
				'fast',function()
					{
					jQuery(this).remove();	
					setTimeout(function(){ jQuery('span.delete-field').removeClass('btn-success'); },1500);
					}
				);
			}
		)
	
	
	
			//CATEGORIZE
			 var $container = jQuery('#categorize_container');

			  $container.categorize({
				itemSelector : '.col-sm-6'
			  });
				var $optionSets = jQuery('#options .option-set'),
				  $optionLinks = $optionSets.find('a');
		
			  $optionLinks.click(function(){
				var $this = jQuery(this);
				$this.tab('show');
				// don't proceed if already selected
				if ( $this.hasClass('selected') ) {
				  //return false;
				}
				
				if($this.hasClass('validation') && jQuery('#'+current_id).hasClass('required'))
					{
					jQuery('#'+current_id).find('.error_message').popover('show');	
					jQuery('#'+current_id).find('.popover').addClass(jQuery('#'+current_id).find('.error_message').attr('data-error-class'));
					}
				else
					jQuery('#'+current_id).find('.error_message').popover('hide');	
				
				
					
						if($this.hasClass('input-element'))
							{
							
							$this.attr('data-option-value','.settings-input');
							
							if(jQuery('#'+current_id).hasClass('text'))
								$this.attr('data-option-value','.settings-input, .setting-text');
							
							if(jQuery('#'+current_id).hasClass('textarea'))
								$this.attr('data-option-value','.settings-input, .setting-textarea')
							
							if(jQuery('#'+current_id).hasClass('select'))
								$this.attr('data-option-value','.settings-input, .setting-select')
								
							if(jQuery('#'+current_id).hasClass('multi-select'))
								$this.attr('data-option-value','.settings-input, .setting-multi-select')
								
							if(jQuery('#'+current_id).hasClass('radio-group') || jQuery('#'+current_id).hasClass('check-group'))
								$this.attr('data-option-value','.setting-radio')
								
							if(jQuery('#'+current_id).hasClass('slider'))
								$this.attr('data-option-value','.setting-slider')
								
							if(jQuery('#'+current_id).hasClass('star-rating'))
								$this.attr('data-option-value','.setting-star')
							
							if(jQuery('#'+current_id).hasClass('touch_spinner'))
								$this.attr('data-option-value','.setting-spinner, .settings-input')
								
							if(jQuery('#'+current_id).hasClass('tags'))
								$this.attr('data-option-value','.setting-tags')
								
							if(jQuery('#'+current_id).hasClass('autocomplete'))
								$this.attr('data-option-value','.setting-autocomplete, .settings-input')
							
							if(jQuery('#'+current_id).hasClass('submit-button'))
								$this.attr('data-option-value','.setting-button')
								
							if(jQuery('#'+current_id).hasClass('date') || jQuery('#'+current_id).hasClass('datetime') || jQuery('#'+current_id).hasClass('time'))
								$this.attr('data-option-value','.setting-prefix, .settings-input')
							
							if(jQuery('#'+current_id).hasClass('upload-single'))
								$this.attr('data-option-value','.setting-postfix, .settings-input, .setting-text');
							
							if(jQuery('#'+current_id).hasClass('custom-prefix'))
								$this.attr('data-option-value','.setting-prefix, .settings-input, .setting-text')
							
							if(jQuery('#'+current_id).hasClass('custom-postfix'))
								$this.attr('data-option-value','.setting-postfix, .settings-input, .setting-text')
								
							if(jQuery('#'+current_id).hasClass('custom-pre-postfix'))
								$this.attr('data-option-value','.setting-prefix, .setting-postfix, .settings-input, .setting-text')
								
							if(jQuery('#'+current_id).hasClass('paragraph'))
								$this.attr('data-option-value','.setting-paragraph')
							
							if(jQuery('#'+current_id).hasClass('heading'))
								$this.attr('data-option-value','.setting-heading')
								
							if(jQuery('#'+current_id).hasClass('grid'))
								$this.attr('data-option-value','.setting-panel')
							
							if(jQuery('#'+current_id).hasClass('divider'))
								$this.attr('data-option-value','.setting-divider')
							
							}
						if($this.hasClass('validation'))
							{
							$this.attr('data-option-value','.settings-validation');
							if(jQuery('#'+current_id).hasClass('text') || jQuery('#'+current_id).hasClass('custom-prefix') || jQuery('#'+current_id).hasClass('custom-postfix') || jQuery('#'+current_id).hasClass('custom-pre-postfix'))
								$this.attr('data-option-value','.settings-validation, .setting-validation-text');
							
							if(jQuery('#'+current_id).hasClass('textarea'))
								$this.attr('data-option-value','.settings-validation, .setting-validation-textarea')
							
							if(jQuery('#'+current_id).hasClass('upload-image') || jQuery('#'+current_id).hasClass('upload-single'))
								$this.attr('data-option-value','.settings-validation, .setting-validation-file-input')	
								
							}
				
				//jQuery('.editing-field').attr('style','');
				jQuery('.editing-field').removeClass('editing-field')
			
						if($this.hasClass('the-label'))
							jQuery('#'+current_id).find('label').addClass('editing-field')
						if($this.hasClass('input-element'))
							jQuery('#'+current_id).find('.the_input_element').addClass('editing-field')
						if($this.hasClass('help-text'))
							jQuery('#'+current_id).find('.help-block').addClass('editing-field')
						//if($this.hasClass('validation'))
							//jQuery('#'+current_id).find('input').addClass('editing-field')
						
						
						jQuery('.editing-field').animate(
								{
								outlineOffset:0,
								outlineWidth:1
								},300
							);	
					
					
							var $optionSet = $this.parents('.option-set');
							$optionSet.find('.selected').removeClass('selected');
							$this.addClass('selected');
					  
							// make option object dynamically, i.e. { filter: '.my-filter-class' }
							var options = {},
								key = $optionSet.attr('data-option-key'),
								value = $this.attr('data-option-value');
							// parse 'false' as false boolean
							value = value === 'false' ? false : value;
							options[ key ] = value;
							if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
							  // changes in layout modes need extra logic
							  changeLayoutMode( $this, options )
							} else {
							  // otherwise, apply new options
							  $container.categorize( options );
							}
							
							return false;
						
			  });
			
		
	
	$('div#nex-forms-field-settings  span.close ').live('click',
		function()
			{
			//$('.field_settings').show();
			var field_settings_width = $('div#nex-forms-field-settings').width()+10;
			
			
			$('.editing-field').removeClass('editing-field');
			
			$('div#nex-forms-field-settings').animate(
					{
					right:-field_settings_width
					},500
				);
			$('div#nex-forms-field-settings').removeClass('open')	
			$('div.nex-forms-container').animate(
					{
					width:current_formcontainer_width
					},500
				);
			}
			
		);
	});
	
	
	$('select[name="current_fields"]').live('dblclick',
		function(){
			jQuery('#nex_autoresponder_confirmation_mail_body').trigger('focus');
			insertAtCaret('nex_autoresponder_confirmation_mail_body', jQuery(this).val());
		}
	);
	
})(jQuery);


function insertAtCaret(areaId,text) {
    var txtarea = document.getElementById(areaId);
    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ? 
    	"ff" : (document.selection ? "ie" : false ) );
    if (br == "ie") { 
    	txtarea.focus();
    	var range = document.selection.createRange();
    	range.moveStart ('character', -txtarea.value.length);
    	strPos = range.text.length;
    }
    else if (br == "ff") strPos = txtarea.selectionStart;

    var front = (txtarea.value).substring(0,strPos);  
    var back = (txtarea.value).substring(strPos,txtarea.value.length); 
    txtarea.value=front+text+back;
    strPos = strPos + text.length;
    if (br == "ie") { 
    	txtarea.focus();
    	var range = document.selection.createRange();
    	range.moveStart ('character', -txtarea.value.length);
    	range.moveStart ('character', strPos);
    	range.moveEnd ('character', 0);
    	range.select();
    }
    else if (br == "ff") {
    	txtarea.selectionStart = strPos;
    	txtarea.selectionEnd = strPos;
    	txtarea.focus();
    }
    txtarea.scrollTop = scrollPos;
}
