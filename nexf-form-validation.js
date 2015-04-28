var file_inputs= new Array();
var file_ext= new Array();
jQuery(document).ready(
function ()
	{
	
	
	jQuery('input[type="text"], textarea.required').keyup(
		function()
			{
			jQuery(this).popover('destroy')
			if(jQuery(this).val()=='')
				{
				jQuery(this).popover({trigger:'manual'});
				jQuery(this).popover('show');
				jQuery(this).parent().find('.popover').addClass(jQuery(this).attr('data-error-class'));	
				}
			else
				jQuery(this).popover('destroy')
			}
		);
		
	
	jQuery('div.nex-submit').click(
		function()
			{
			jQuery(this).closest('form').submit();
			}
		)
	
	
		
			
	jQuery('form.submit-nex-form').ajaxForm({
    data: {
       action: 'submit_nex_form'
    },
    dataType: 'json',
    beforeSubmit: function(formData, jqForm, options) {
		 
		 if(validate_form(jqForm))
			{
			var submit_val = jqForm.find('.nex-submit').html();
			//var get_padding = formObj.find('input[type="submit"]').css('padding-left');
			//formObj.find('input[type="submit"]').css('padding-left','20px');
			//jQuery('<span class="fa fa-spinner fa-spin"></span>').insertBefore(formObj.find('input[type="submit"]'));
			//formObj.find('.fa-spinner').css('color',formObj.find('input[type="submit"]').css('color'));
			
			jqForm.find('.nex-submit').html('<span class="fa fa-spinner fa-spin"></span>&nbsp;&nbsp;' + submit_val);
			return true;
			}
		else
			return false;
		 
		 
    },
    success : function(responseText, statusText, xhr, $form) {
      if(jQuery('#nex-forms #on_form_submmision').text()=='redirect')
			{
			$form.fadeOut('fast');
			var url = '' + jQuery('#nex-forms #confirmation_page').text()+'';    
			jQuery(location).attr('href',url);
			}
		else
			{
			$form.fadeOut('fast',
				function(){
				$form.closest('.ui-nex-forms-container').find('.nex_success_message').fadeIn('slow');
				}
			);
			var offset = $form.closest('.ui-nex-forms-container').find('.nex_success_message').offset();
			jQuery("html, body").animate(
					{
					scrollTop:offset.top-100
					},500
				);
			}
		}
	});
	}
);


function validate_form(object){
	
	
	jQuery('.ui-nex-forms-container input[type="file"]').each(
		function()
			{
			var items = jQuery(this).closest('.form_field').parent().find('div.get_file_ext').text();
			var set_name = new Array(jQuery(this).attr('name'))
			set_name.push(items.split('\n'));
			file_inputs.push(set_name);
			}
		);
	
	var current_form = object;
	
	//console.log(current_form)
	
	var formdata = {
                   radios : [], //an array of already validate radio groups
                   checkboxes : [], //an array of already validate checkboxes
                   runCnt : 0, //number of times the validation has been run
                   errors: 0
               }
	
	var defaultErrorMsgs = {
                    email : 'Not a valid email address',
                    number: 'Not a valid phone number',
                    required: 'Please enter a value',
                    text: 'Only text allowed'
                }
	
	var settings = {
                'requiredClass': 'required',
                'customRegex': false,
				'errors' : 0,
                'checkboxDefault': 0,
                'selectDefault': 0,
                'beforeValidation': null,
                'onError': null,
                'onSuccess': null,
                'beforeSubmit': null, 
                'afterSubmit': null,
                'onValidationSuccess': null,
                'onValidationFailed': null
            };
	
	settings.errors = 0;
	jQuery(current_form).find('input').each( function() {
		
		
		var input = jQuery(this);
		var val = input.val();                                                                                
		var name = input.attr('name');
		
		if(input.is('input'))
			{
			
			var type = input.attr('type');
			switch(type)
				{
				case 'text':
					if(input.hasClass('required') && input.is(':visible')) {
					
						
						if(val.length < 1 || val=='')
							{
								settings.errors++;                               
								
									input.popover({trigger:'manual'});
									input.popover('show');
									input.parent().find('.popover').addClass(input.attr('data-error-class'));
								break;
							}
						 else
							{
							input.popover('destroy');
							}
						}
				    
				break;
				}
			}
		}
	);                       
	
   jQuery(current_form).find('textarea').each( function() {	
		if(jQuery(this).hasClass('required') && jQuery(this).is(':visible'))
			{
			if(jQuery(this).val() == '') {
				settings.errors++;
				jQuery(this).popover({trigger:'manual'});
				jQuery(this).popover('show');
				jQuery(this).parent().find('.popover').addClass(jQuery(this).attr('data-error-class'));
				}
			 else
				{
				jQuery(this).popover('destroy');
				}
			}
  		 }
   	);
	
	
if(settings.errors == 0) {
	return true;
	
}
else{
var offset = jQuery('div.popover').offset();
	jQuery("html, body").animate(
			{
			scrollTop:offset.top-180
			},700
		)
	return false;

}

}
function isNumber(n) {
   if(n!='')
		return !isNaN(parseFloat(n)) && isFinite(n);
	
	return true;
}

function IsValidEmail(email){
  if(email!=''){
	var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	return filter.test(email);
  }
	return true;
}
function allowedChars(input_value, accceptedchars){
	var aChars = ' -_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	if(accceptedchars)
		{
		switch(accceptedchars)
			{
			case 'tel': aChars = '1234567890-+() '; break;
			case 'text': aChars = ' abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';break;
			default: aChars = accceptedchars; break;
			}
		}
	var valid = false;
	var txt = input_value.toString();
	
	for(var i=0;i<txt.length;i++) {
		if (aChars.indexOf(txt.charAt(i)) != -1) {
			valid = true;
		} else {
			valid = false;
			break;
		}
	 }
	return valid;
}
function validate_url(get_url) {
        var url = get_url;
        var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        if (pattern.test(url))
            return true;
 
        return false;
}