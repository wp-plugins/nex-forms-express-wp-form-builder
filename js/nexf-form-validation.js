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
		
	jQuery('.the-radios a, .the-radios .input-label').live('click', 
			function(e)
				{
				jQuery(this).closest('#the-radios').popover('destroy');
				}
			);
	
	jQuery('#select').live('change', 
			function(e)
				{
				jQuery(this).parent().find('.error_message').popover('destroy');
				}
			);
	
	
	
	jQuery("#ajax-form").submit(function(e)
		{
		var formObj = jQuery(this);
		var formURL = formObj.attr("action");
		var formData = new FormData(this);
		
		if(validate_form(jQuery(this)))
			{
			var submit_val = formObj.find('.nex-submit').html();
			//var get_padding = formObj.find('input[type="submit"]').css('padding-left');
			//formObj.find('input[type="submit"]').css('padding-left','20px');
			//jQuery('<span class="fa fa-spinner fa-spin"></span>').insertBefore(formObj.find('input[type="submit"]'));
			//formObj.find('.fa-spinner').css('color',formObj.find('input[type="submit"]').css('color'));
			
			jQuery('.nex-submit').html('<span class="fa fa-spinner fa-spin"></span>&nbsp;&nbsp;' + submit_val);
			
			jQuery.ajax(
				{
				url: formURL,
				type: 'POST',
				data:  formData,
				mimeType:"multipart/form-data",
				contentType: false,
				cache: false,
				processData:false,
				success: function(data, textStatus, jqXHR)
					{
					
					if(jQuery('#nex-forms #on_form_submmision').text()=='redirect')
						{
						formObj.fadeOut('fast');
						var url = '' + jQuery('#nex-forms #confirmation_page').text()+'';    
						jQuery(location).attr('href',url);
						//window.location.replace('"' + jQuery('#nex-forms #confirmation_page').text()+'"');
						}
					else
						{
						formObj.fadeOut('fast',
							function(){
							jQuery('.panel-body.alert-success').fadeIn('slow');
							}
						);
						var offset = jQuery('.panel-body.alert-success').offset();
						jQuery("html, body").animate(
								{
								scrollTop:offset.top-100
								},500
							);
						}
					},
				error: function(jqXHR, textStatus, errorThrown)
					{
					}         
				}
			);
			}
		e.preventDefault(); //Prevent Default action.
		});
	}
);


function show_popover(obj){
		
}
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
					if(input.hasClass('required')) {
					
						if(input.hasClass('the_slider') && val==input.parent().find('#slider').attr('data-starting-value'))
							{
							settings.errors++;
							input.parent().find('.error_message').popover({trigger:'manual'});
							input.parent().find('.error_message').popover('show');
							input.parent().find('.error_message').parent().find('.popover').addClass(input.parent().find('.error_message').attr('data-error-class'));
							}
						
						
						if(input.hasClass('the_spinner') && val==input.attr('data-starting-value'))
							{
							settings.errors++;
							input.parent().find('.error_message').popover({trigger:'manual'});
							input.parent().find('.error_message').popover('show');
							input.parent().find('.error_message').parent().find('.popover').addClass(input.parent().find('.error_message').attr('data-error-class'));
							
							}
						
						
						
						if(val.length < 1 || val=='')
							{
								settings.errors++;                               
								if(input.hasClass('star_rating'))
									{
									input.closest('.error_message').popover({trigger:'manual'});
									input.closest('.error_message').popover('show');
									input.closest('.error_message').parent().find('.popover').addClass(input.closest('.error_message').attr('data-error-class'));
									}
								else if(input.hasClass('tags'))
									{
									input.parent().find('.error_message').popover({trigger:'manual'});
									input.parent().find('.error_message').popover('show');
									input.parent().find('.popover').addClass(input.parent().find('.error_message').attr('data-error-class'));
									}
								else
									{
									input.popover({trigger:'manual'});
									input.popover('show');
									input.parent().find('.popover').addClass(input.attr('data-error-class'));
									}
									
								break;
							}
						 else
							{
							input.popover('destroy');
							input.closest('.error_message').popover('destroy');
							}
					}
				jQuery(this).popover('destroy')
				break;
				
				
				case 'radio':
					//avoid checking the same radio group more than once                                    
					var radioData = formdata.radios;
						if(input.closest('.radio-group').hasClass('required'))
							{
							if(radioData)
								{
								if(jQuery.inArray(name, radioData) >= 0) 
									break;
								else
									{
									var checked = false;
									input.closest('#the-radios').find('input[type="radio"]').each(
										function()
											{
											if(jQuery(this).prop('checked')==true)
												checked = true;	
											}
										);
									if(!checked)
										{
										settings.errors++;
										input.closest('.error_message').popover({trigger:'manual'});
										input.closest('.error_message').popover('show');
										input.closest('.error_message').parent().find('.popover').addClass(input.closest('.error_message').attr('data-error-class'));
										}
									 else
										{
										input.closest('.error_message').popover('destroy');
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
				   
					if(input.closest('.check-group').hasClass('required'))
							{
							if(checkData)
								{
								if(jQuery.inArray(name, checkData) >= 0) 
									break;
								else
									{
									var checked = false;
									input.closest('#the-radios').find('input[type="checkbox"]').each(
										function()
											{
											if(jQuery(this).prop('checked')==true)
												checked = true;	
											}
										);
									if(!checked)
										{
										settings.errors++;
										input.closest('.error_message').popover({trigger:'manual'});
										input.closest('.error_message').popover('show');
										input.closest('.error_message').parent().find('.popover').addClass(input.closest('.error_message').attr('data-error-class'));
										}
									 else
										{
										input.closest('.error_message').popover('destroy');
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
		if(jQuery(this).hasClass('required'))
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
	
	jQuery(current_form).find('select').each( function() {	
		if(jQuery(this).hasClass('required'))
			{
			if(jQuery(this).val() == 0) {
				settings.errors++;
				
				jQuery(this).popover({trigger:'manual'});
				jQuery(this).popover('show');
				jQuery(this).addClass(jQuery(this).attr('data-error-class'));
				}
			 else
				{
				jQuery(this).popover('destroy');
				}
			}
  		 }
   	);
if(settings.errors == 0) 
	return true;

return false;
}