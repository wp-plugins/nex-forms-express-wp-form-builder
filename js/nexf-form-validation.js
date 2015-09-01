var file_inputs= new Array();
var file_ext= new Array();
jQuery(document).ready(
function ()
	{
	
	
	jQuery('#previewForm  input.email').live('blur',
		function()
			{
			if(!IsValidEmail(jQuery(this).val()) && jQuery(this).val()!='')
				{
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).attr('data-secondary-message'));
				}
			else if(jQuery(this).hasClass('required') && jQuery(this).val()=='')
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).attr('data-content'));
			else
				hide_nf_error(jQuery(this).closest('.form_field'));
			}
		);
	jQuery('#previewForm   input.phone_number').live('blur',
		function()
			{
			if(!allowedChars(jQuery(this).val(), 'tel') && jQuery(this).val()!='')
				{
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).attr('data-secondary-message'));
				}
			else if(jQuery(this).hasClass('required') && jQuery(this).val()=='')
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).attr('data-content'));
			else
				hide_nf_error(jQuery(this).closest('.form_field'));
			}
		);
		
	jQuery('#previewForm  input.numbers_only').live('blur',
		function()
			{
			if(!isNumber(jQuery(this).val()) && jQuery(this).val()!='')
				{
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).attr('data-secondary-message'));
				}
			else if(jQuery(this).hasClass('required') && jQuery(this).val()=='')
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).attr('data-content'));
			else
				hide_nf_error(jQuery(this).closest('.form_field'));
			}
		);
	
	jQuery('#previewForm  input.text_only').live('blur',
		function()
			{
			if(!allowedChars(jQuery(this).val(), 'text') && jQuery(this).val()!='') {
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).attr('data-secondary-message'));
				}
			else if(jQuery(this).hasClass('required') && jQuery(this).val()=='')
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).attr('data-content'));
			else
				hide_nf_error(jQuery(this).closest('.form_field'));
			}
		);
	
	jQuery('#previewForm  input.url').live('blur',
		function()
			{
			if(!validate_url(jQuery(this).val()) && jQuery(this).val()!='') {
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).attr('data-secondary-message'));
				}
			else if(jQuery(this).hasClass('required') && jQuery(this).val()=='')
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).attr('data-content'));
			else
				hide_nf_error(jQuery(this).closest('.form_field'));
			}
		);
	
	
	
	jQuery('#previewForm  input[type="text"].required, #previewForm   input[type="password"].required,#previewForm   textarea.required').live('keyup',
		function()
			{
			if(
			!jQuery(this).hasClass('email') 
			&& !jQuery(this).hasClass('phone_number') 
			&& !jQuery(this).hasClass('numbers_only')
			&& !jQuery(this).hasClass('text_only')
			&& !jQuery(this).hasClass('url'))
			{
			
			if(jQuery(this).val()=='')
				{
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).attr('data-content'));
				}
			else
				hide_nf_error(jQuery(this).closest('.form_field'));
			}
			}
			
		);
	
	jQuery('#previewForm  input[type="text"].required, #previewForm  input[type="password"].required, #previewForm  textarea.required').live('blur',
		function()
			{
			if(
			!jQuery(this).hasClass('email') 
			&& !jQuery(this).hasClass('phone_number') 
			&& !jQuery(this).hasClass('numbers_only')
			&& !jQuery(this).hasClass('text_only')
			&& !jQuery(this).hasClass('url'))
			{
			if(jQuery(this).val()=='')
				{
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).attr('data-content'));
				}
			else
				hide_nf_error(jQuery(this).closest('.form_field'));
			}
			}
		);
	
		
	jQuery('#previewForm  .the-radios a, .the-radios .input-label').live('click', 
			function(e)
				{
				hide_nf_error(jQuery(this).closest('.form_field'));
				}
			);
	jQuery('#previewForm  #star img').live('click', 
			function(e)
				{
				hide_nf_error(jQuery(this).closest('.form_field'));
				}
			);
	jQuery('#previewForm  select').live('change', 
			function(e)
				{
				hide_nf_error(jQuery(this).closest('.form_field'));
				}
			);
	jQuery('#previewForm  input.the_slider').live('change',
		function()
			{
			hide_nf_error(jQuery(this).closest('.form_field'));
			}
		);

	jQuery('#previewForm  .bootstrap-touchspin .btn').live('click',
		function()
			{
			hide_nf_error(jQuery(this).closest('.form_field'));
			}
		);
	jQuery('#previewForm  #tags').live('change',
		function()
			{
			hide_nf_error(jQuery(this).closest('.form_field'));
			}
		);
	jQuery('#previewForm  input#selected-color').live('blur',
		function()
			{
			hide_nf_error(jQuery(this).closest('.form_field'));
			}
		);
	
		
	
	jQuery('#previewForm  div.nex-submit').click(
		function()
			{
			jQuery(this).closest('form').submit();
			}
		)
	
	jQuery('#previewForm  .nex-step').live('click',
		function()
			{
			var the_form = jQuery(this).closest('form');
			if(validate_form(jQuery(this).closest('form')))
				{
				jQuery(this).closest('.step').hide();
				var current_step = parseInt(jQuery(this).closest('#previewForm').find('.current_step').text());
				current_step = current_step+1;
				
				jQuery('.current_step').text(current_step);
				jQuery('.ui-nex-forms-container .step:eq('+ (current_step-1) +')').show();
				var offset = the_form.find('.step:eq('+ (current_step-1) +')').offset();
				jQuery("html, body").animate(
					{
					scrollTop:offset.top-100
					},200
				);
				}
			}
		);
	jQuery('#previewForm  .prev-step').live('click',
		function()
			{
			var the_form = jQuery(this).closest('form');
			jQuery('.step').hide();
			var current_step = parseInt(jQuery(this).closest('#previewForm').find('.current_step').text());
			current_step = current_step-1;
			
			jQuery('.current_step').text(current_step);
			jQuery('.ui-nex-forms-container .step:eq('+ (current_step-1) +')').show();
			var offset = the_form.find('.step:eq('+ (current_step-1) +')').offset();
			jQuery("html, body").animate(
					{
					scrollTop:offset.top-100
					},200
				);
			}
		);
		
			
	jQuery('form.submit-nex-form').ajaxForm({
    data: {
       action: 'submit_nex_form'
    },
    //dataType: 'json',
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
	
      if($form.closest('.nex-forms').find('.on_form_submmision').text()=='redirect')
			{
			$form.fadeOut('fast');
			var url = '' + $form.closest('.nex-forms').find('.confirmation_page').text()+'';    
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
		
		//input.closest('.form_field').find('.error_msg').remove();
		
		if(input.is('input'))
			{
			
			var type = input.attr('type');
			switch(type)
				{
				
				case 'hidden':	
						if(input.closest('.form_field').hasClass('star-rating')  && input.closest('.form_field').is(':visible'))
							{
							if(val.length < 1 || val=='')
								{
								settings.errors++;                   
								show_nf_error(input.closest('.form_field'),input.closest('.form_field').find('.error_message').attr('data-content'))
								}
							else
								{
								hide_nf_error(input.closest('.form_field'));
								}
							}
							
				break	
				;
				case 'text':
					if(input.hasClass('required') && input.closest('.form_field').is(':visible')) {
					
						if(input.hasClass('the_slider') && (val==input.parent().find('#slider').attr('data-starting-value') || val==''))
							{
							settings.errors++;
							console.log('test');
							show_nf_error(input.closest('.form_field'),'Please select a value')
							}
						
						
						else if(input.hasClass('the_spinner') && (val==input.attr('data-starting-value') || val==''))
							{
							settings.errors++;
							show_nf_error(input.closest('.form_field'),input.closest('.form_field').find('.error_message').attr('data-content'))
							}
						
						else if(input.hasClass('tags') && val=='')
							{
							settings.errors++;
							show_nf_error(input.closest('.form_field'),input.closest('.form_field').find('.error_message').attr('data-content'))
							}
						
						
						
						else if(val.length < 1 || val=='')
							{
								settings.errors++;        
								show_nf_error(input.closest('.form_field'),input.closest('.form_field').find('.error_message').attr('data-content'))
								break;
							}
					 else 
							{
													
							if(input.hasClass('email') && input.is(':visible'))
								{
								if(!IsValidEmail(val))
									{   
									settings.errors++;
									//input.closest('.form_field').append('<div class="error_msg"><span class="fa fa-warning"></span> '+ input.attr('data-content') +'</div>');
									if(input.attr('data-secondary-message'))
										show_nf_error(input.closest('.form_field'),input.attr('data-secondary-message'))
									
									
									break;
									}
								else
									{
									hide_nf_error(input.closest('.form_field'));
									break;
									}
								}
							else if(input.hasClass('phone_number') && input.is(':visible'))
								{
								if(!allowedChars(val, 'tel'))
									{
									settings.errors++;
									//input.closest('.form_field').append('<div class="error_msg"><span class="fa fa-warning"></span> '+ input.attr('data-content') +'</div>');
									if(input.attr('data-secondary-message'))
										show_nf_error(input.closest('.form_field'),input.attr('data-secondary-message'))
									
									break;
									} 
								else
									{
									hide_nf_error(input.closest('.form_field'));
									break;
									}  
								}
							else if(input.hasClass('numbers_only') && input.is(':visible'))
								{
								if(!isNumber(val))
									{
									settings.errors++;
									//input.closest('.form_field').append('<div class="error_msg"><span class="fa fa-warning"></span> '+ input.attr('data-content') +'</div>');
									if(input.attr('data-secondary-message'))
										show_nf_error(input.closest('.form_field'),input.attr('data-secondary-message'))
									
									break;
									} 
								else
									{
									hide_nf_error(input.closest('.form_field'));
									break;
									} 
								}
							else if(input.hasClass('text_only') && input.is(':visible'))
								{
								if(!allowedChars(val, 'text'))
									{
									settings.errors++;
									//input.closest('.form_field').append('<div class="error_msg"><span class="fa fa-warning"></span> '+ input.attr('data-content') +'</div>');
									if(input.attr('data-secondary-message'))
										show_nf_error(input.closest('.form_field'),input.attr('data-secondary-message'))
									
									break;
									} 
								else
									{
									hide_nf_error(input.closest('.form_field'));
									break;
									} 
								}
							else if(input.hasClass('url') && input.is(':visible'))
								{
								if(!validate_url(val))
									{
									settings.errors++;
									//input.closest('.form_field').append('<div class="error_msg"><span class="fa fa-warning"></span> '+ input.attr('data-content') +'</div>');
									if(input.attr('data-secondary-message'))
										show_nf_error(input.closest('.form_field'),input.attr('data-secondary-message'))
									
									break;
									} 
								else
									{
									hide_nf_error(input.closest('.form_field'));
									break;
									}  
								}
							}
						}
				    else if(input.hasClass('email') && val!='' && input.is(':visible')) {
					   if(!IsValidEmail(val)) {  
							settings.errors++;
							//input.closest('.form_field').append('<div class="error_msg"><span class="fa fa-warning"></span> '+ input.attr('data-content') +'</div>');
									if(input.attr('data-secondary-message'))
										show_nf_error(input.closest('.form_field'),input.attr('data-secondary-message'))
									
							break;
					   }
					}
					else if(input.hasClass('phone_number') && val!='' && input.is(':visible')) {
					   if(!allowedChars(val, 'tel')) {
							settings.errors++;
							//input.closest('.form_field').append('<div class="error_msg"><span class="fa fa-warning"></span> '+ input.attr('data-content') +'</div>');
									if(input.attr('data-secondary-message'))
										show_nf_error(input.closest('.form_field'),input.attr('data-secondary-message'))
									
							break;
					   }
					}
					else if(input.hasClass('numbers_only') && val!='' && input.is(':visible')) {
					   if(!isNumber(val)) {
							settings.errors++;
							//input.closest('.form_field').append('<div class="error_msg"><span class="fa fa-warning"></span> '+ input.attr('data-content') +'</div>');
									if(input.attr('data-secondary-message'))
										show_nf_error(input.closest('.form_field'),input.attr('data-secondary-message'))
									
							break;
					   }
					}
					else if(input.hasClass('text_only') && val!='' && input.is(':visible')) {
					   if(!allowedChars(val, 'text')) {
							settings.errors++;
							//input.closest('.form_field').append('<div class="error_msg"><span class="fa fa-warning"></span> '+ input.attr('data-content') +'</div>');
									if(input.attr('data-secondary-message'))
										show_nf_error(input.closest('.form_field'),input.attr('data-secondary-message'))
									
							break;
					   }
					}
					else if(input.hasClass('url') && val!='' && input.is(':visible')) {
					   if(!validate_url(val)) {
							settings.errors++;
							//input.closest('.form_field').append('<div class="error_msg"><span class="fa fa-warning"></span> '+ input.attr('data-content') +'</div>');
									if(input.attr('data-secondary-message'))
										show_nf_error(input.closest('.form_field'),input.attr('data-secondary-message'))
									
							break;
					   }   
					}
				else
					hide_nf_error(input.closest('.form_field'));
				break;
				case 'password':
					if(input.hasClass('required') && input.is(':visible'))
						{						
						if(val.length < 1 || val=='')
							{
							settings.errors++;      
							show_nf_error(input.closest('.form_field'),input.attr('data-content'))
							
							}
						}
					else
						{
							hide_nf_error(input.closest('.form_field'));
						}
				break;							
				case 'file':
					if(input.closest('.form_field').hasClass('required') && input.parent().parent().find('.the_input_element').is(':visible')) {
						if(val.length < 1 || val=='' )
							{
							//console.log('no value');
							settings.errors++;                               
							show_nf_error(input.closest('.form_field'),input.closest('.form_field').find('.error_message').attr('data-content'))
						
							break;
							}
						 else
							{
							for (var i = 0; i < file_inputs.length; i++)
								{
								var fname = val;
							    var ext = fname.substr((~-fname.lastIndexOf(".") >>> 0) + 2);
								if(input.attr('name')==file_inputs[i][0])
									{
									if(jQuery.inArray(ext,file_inputs[i][1])<0)
										{
										//console.log('in array');
										settings.errors++;
										//input.closest('.form_field').append('<div class="error_msg"><span class="fa fa-warning"></span> '+ input.attr('data-content') +'</div>');
										if(input.closest('.form_field').find('.error_message').attr('data-secondary-message'))
											show_nf_error(input.closest('.form_field'),input.attr('data-secondary-message'))
										}
									else
										{
										hide_nf_error(input.closest('.form_field'));
										break;
										}
									}
								}
							break;
							}
						}
				break;
				
				
				case 'radio':
					//avoid checking the same radio group more than once                                    
					var radioData = formdata.radios;
						if(input.closest('.form_field').hasClass('required') && input.closest('.form_field').is(':visible'))
							{
							if(radioData)
								{
								if(jQuery.inArray(name, radioData) >= 0) 
									break;
								else
									{
									var checked = false;
									input.closest('.form_field').find('input[type="radio"]').each(
										function()
											{
											if(jQuery(this).prop('checked')==true)
												checked = true;	
											}
										);
									if(!checked)
										{
										settings.errors++;
										show_nf_error(input.closest('.form_field'),input.closest('.form_field').find('.error_message').attr('data-content'))
										}
									 else
										{
										hide_nf_error(input.closest('.form_field'));
										break;
										}                                           
									radioData.push(name);
									} 
								}                                
							}	
					break;
				
				 case 'checkbox':
					//avoid checking the same radio group more than once                                    
					var checkData = formdata.checkboxes;
					//console.log(radioData);
					if(input.closest('.form_field').hasClass('required') && input.closest('.form_field').is(':visible'))
							{
							if(checkData)
								{
								if(jQuery.inArray(name, checkData) >= 0) 
									break;
								else
									{
									var checked = false;
									input.closest('.form_field').find('input[type="checkbox"]').each(
										function()
											{
											if(jQuery(this).prop('checked')==true)
												checked = true;	
											}
										);
									if(!checked)
										{
										settings.errors++;
										show_nf_error(input.closest('.form_field'),input.closest('.form_field').find('.error_message').attr('data-content'))
										}
									 else
										{
										hide_nf_error(input.closest('.form_field'));
										break;
										}                                           
									checkData.push(name);
									} 
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
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).closest('.form_field').find('.error_message').attr('data-content'))
				}
			 else
				{
				hide_nf_error(jQuery(this).closest('.form_field'));
				}
			}
  		 }
   	);
	
	jQuery(current_form).find('select').each( function() {	
		if(jQuery(this).hasClass('required') && jQuery(this).closest('.form_field').is(':visible'))
			{
			if(jQuery(this).val() == 0) {
				show_nf_error(jQuery(this).closest('.form_field'),jQuery(this).closest('.form_field').find('.error_message').attr('data-content'))
				settings.errors++;
				}
			 else
				{
				hide_nf_error(jQuery(this).closest('.form_field'));
				}
			}
  		 }
   	);
if(settings.errors == 0) {
	return true;
	
}
else{

	setTimeout(function(){ jQuery('.error_msg').addClass('animate_right') },100);

	
var offset = jQuery('div.error_msg').offset();
	jQuery("html, body").animate(
			{
			scrollTop:offset.top-180
			},700
		)
	return false;

}

}
function show_nf_error(obj, error){
	
	if(!obj.find('.error_msg span').attr('class'))
		{
		obj.append('<div class="error_msg"><span class="fa fa-warning"></span> '+ error +'</div>');
		setTimeout(function(){ obj.find('.error_msg').addClass('animate_right') },100);
		}
		
}
function hide_nf_error(obj){
	obj.find('.error_msg').removeClass('animate_right');
	setTimeout(function(){obj.find('.error_msg').remove()},300);
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