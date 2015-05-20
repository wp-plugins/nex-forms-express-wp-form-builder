// JavaScript Document
jQuery(document).ready(
function ()
	{
	
	
	
	
	/*jQuery('.overall-form-settings .dropdown-menu li').click(
		function()
			{
			
			
			jQuery('.overall-form-settings li').removeClass('active');
			
			jQuery('.overall-form-settings .current_selected_theme').text(jQuery(this).find('a').text());
			jQuery('.active_theme').text(jQuery(this).attr('class'));
			
			jQuery(this).addClass('active');
			
			if(jQuery(this).attr('class')=='default')
				{
				jQuery('link.color_scheme').attr('href',"#");
				jQuery('.ui-state-default').removeClass('ui-state-default');
				jQuery('.ui-state-active').removeClass('ui-state-active');
				jQuery('.ui-widget-content').removeClass('ui-widget-content');
				jQuery('.ui-widget-header').removeClass('ui-widget-header');
				}
			}
		);*/
		
		
	
	
	
	
	jQuery('.open_nex_forms_popup').click(
		function(e)
			{
			e.preventDefault();
			jQuery('#nexForms_popup_'+jQuery(this).attr('data-popup-id')).modal().appendTo('body');
			}
		)
	/*******************************/
	/********* FORM FIELDS *********/
	/*******************************/
	
	//Awsome Checks
	jQuery('div.checkbox-group input').each(
		function()
			{
			jQuery(this).prettyCheckable();	
			}
		);
	jQuery('#available_fields a, #canvas_view a').click(function (e) {
	  e.preventDefault()
	  jQuery(this).tab('show')
	})
	
	
	jQuery('.bs-tooltip').tooltip();

	/*********************************/
	/********* ADMIN BUILDER *********/
	/*********************************/
	//Boostrap Accordion
	
	
	var get_input_style = '';
	jQuery('.the_input_element.form-control').on('focus',
		function()
			{
			get_input_style = jQuery(this).attr('style');
			if(jQuery(this).attr('data-drop-focus-swadow')=='1')
				jQuery(this).attr('style',get_input_style + 'box-shadow:inset 0 1px 1px rgba(0,0,0,0.075), 0 0 7px ' +  jQuery(this).attr('data-onfocus-color') +' !important;border-color:'+ jQuery(this).attr('data-onfocus-color') +' !important;')
			else
				jQuery(this).attr('style',get_input_style + 'border-color:'+ jQuery(this).attr('data-onfocus-color') +' !important;')
			}
		);
	jQuery('.the_input_element.form-control').on('blur',
		function()
			{
			jQuery(this).attr('style',get_input_style);
			}
		);
		
	jQuery('.input-group-addon.prefix, .input-group-addon.postfix').click(
		function()
			{
			jQuery(this).parent().find('input').trigger('focus');
			}
		);
	
	}
);

function format_illegal_chars(input_value){
	
	input_value = input_value.toLowerCase();
	if(input_value=='name' || input_value=='page' || input_value=='post' || input_value=='id')
		input_value = '_'+input_value;
		
	var illigal_chars = '-+=!@#$%^&*()*{}[]:;<>,.?~`|/\'';
	
	var new_value ='';
	
    for(i=0;i<input_value.length;i++)
		{
		if (illigal_chars.indexOf(input_value.charAt(i)) != -1)
			{
			input_value.replace(input_value.charAt(i),'');
			}
		else
			{
			if(input_value.charAt(i)==' ')
			new_value += '_';
			else
			new_value += input_value.charAt(i);
			}
		}
	return new_value;	
}


function colorToHex(color) {
	if(!color)
		return;
	
    if (color.substr(0, 1) === '#') {
        return color;
    }
    var digits = /(.*?)rgb\((\d+), (\d+), (\d+)\)/.exec(color);
    if(!digits)
		return '#FFF';
	
    var red = parseInt(digits[2]);
    var green = parseInt(digits[3]);
    var blue = parseInt(digits[4]);
    
    var rgb = blue | (green << 8) | (red << 16);
    return digits[1] + '#' + rgb.toString(16);
};

function strstr(haystack, needle, bool) {
    var pos = 0;

    haystack += "";
    pos = haystack.indexOf(needle); if (pos == -1) {
       return false;
    } else {
       return true;
    }
}