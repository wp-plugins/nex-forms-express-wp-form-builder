jQuery(document).ready(
function()
	{
		
		
		
		jQuery(document).on('click', '.verify_purchase_code', function(){
		var data =
				{
				action	:  'get_data' ,
				eu		:	jQuery('#envato_username').val(),
				pc		:	jQuery('#purchase_code').val()
				};
			
			
			jQuery('.verify_purchase_code').html('<span class="fa fa-spin fa-spinner"></span> Verifying')
							
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					jQuery('.show_code_response').html(response);
					jQuery('.verify_purchase_code').html('Activate');
					}
				);
			}
		);
		
		jQuery('#the_form_title').val('');
		jQuery('.alert .close').click(
			function()
				{
				jQuery(this).parent().slideUp('slow')
				}
			);
		

		jQuery('input[name="email_method"]').click(
			function()
				{
				if(jQuery(this).val()=='smtp')
					jQuery('.smtp_settings').show();
				else
					jQuery('.smtp_settings,.smtp_auth_settings').hide();
				}
			);
		
		jQuery('input[name="smtp_auth"]').click(
			function()
				{
				if(jQuery(this).val()=='1')
					jQuery('.smtp_auth_settings').show();
				else
					jQuery('.smtp_auth_settings').hide();
				}
			);
		/*console.log(jQuery('input[name="email_method"]:checked').val());	
		jQuery('input#'+ jQuery('input[name="email_method:checked"]').val() +'').trigger('click');
		jQuery('input#'+ jQuery('input[name="smtp_auth"]:checked').val() +'').trigger('click');
		*/
		jQuery('#email_config').ajaxForm({
			data: {
			   action: 'save_email_config'
			},
			//dataType: 'json',
			beforeSubmit: function(formData, jqForm, options) {
				//alert('test');
				//console.log($('input[name="do_image_upload_preview"]').val())
				jQuery('#email_config button').html('&nbsp;&nbsp;&nbsp;<span class="fa fa-spin fa-spinner"></span>&nbsp;Saving...&nbsp;&nbsp;&nbsp;')
			},
		   success : function(responseText, statusText, xhr, $form) {
			   jQuery('#email_config button').html('&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;');
			   jQuery('#email_config .alert').first().slideDown('slow');
			   
			},
			 error: function(jqXHR, textStatus, errorThrown)
				{
				   console.log(errorThrown)
				}
		});
		
		
		jQuery('#script_config').ajaxForm({
			data: {
			   action: 'save_script_config'
			},
			//dataType: 'json',
			beforeSubmit: function(formData, jqForm, options) {
				//alert('test');
				//console.log($('input[name="do_image_upload_preview"]').val())
				jQuery('#script_config button').html('&nbsp;&nbsp;&nbsp;<span class="fa fa-spin fa-spinner"></span>&nbsp;Saving...&nbsp;&nbsp;&nbsp;')
			},
		   success : function(responseText, statusText, xhr, $form) {
			   jQuery('#script_config button').html('&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;');
			   jQuery('#script_config .alert').first().slideDown('slow');
			   
			},
			 error: function(jqXHR, textStatus, errorThrown)
				{
				   console.log(errorThrown)
				}
		});
		
		jQuery('a#import_form').click(
			function()
				{
				jQuery('input[name="form_html"]').trigger('click');
				}
			);
		
		jQuery('input[name="form_html"]').change(
			function()
				{
				jQuery('#import_form').submit();
				//console.log(jQuery(this).val());	
				}
		)
		
		jQuery('#import_form').ajaxForm({
			data: {
			   action: 'do_form_import'
			},
			//dataType: 'json',
			beforeSubmit: function(formData, jqForm, options) {
				//alert('test');
				//console.log($('input[name="do_image_upload_preview"]').val())
				//jQuery('#script_config button').html('&nbsp;&nbsp;&nbsp;<span class="fa fa-spin fa-spinner"></span>&nbsp;Saving...&nbsp;&nbsp;&nbsp;')
				jQuery('div.nex-forms-container').html('<div class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
			},
		   success : function(responseText, statusText, xhr, $form) {
			 
			   jQuery('.saved_forms a.bs-tooltip').tooltip();
					if(jQuery('.nex-forms-field-settings').hasClass('open'))
						jQuery('div.nex-forms-field-settings .close').trigger('click');
					jQuery('div.nex-forms-container').html(responseText)
					jQuery('div.nex-forms-container div#the-radios input').prop('checked',false);
					jQuery('div.nex-forms-container').find('#star' ).raty('destroy');
					jQuery('div.nex-forms-container div#the-radios a').attr('class','');
					jQuery('.editing-field').removeClass('editing-field');
					jQuery('.form_field').removeClass('edit-field')
					jQuery('#field_container .col-sm-2').addClass('label_container');
					jQuery('#field_container .col-sm-10').addClass('input_container');
					jQuery('div.nex-forms-container').find('div.trash-can').remove();
					jQuery('.editing-field-container').removeClass('editing-field-container');
					setTimeout(function(){ jQuery('.editing-field').removeClass('editing-field'); },1000)
					setTimeout(function(){ jQuery('.editing-field-container').removeClass('.editing-field-container'); },1000)
					
					jQuery('div.nex-forms-container .field_settings').html('<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div><div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>')
					
					var set_current_fields = '';
						jQuery('div.nex-forms-container div.form_field .the_label').each(
							function()
								{
								set_current_fields += '<option value="{{'+ format_illegal_chars(jQuery(this).text())  +'}}">'+ jQuery(this).text() +'</option>';
								}
							);
					
						
					jQuery('select[name="current_fields"]').html(set_current_fields);
					
						
					
					if(!jQuery('link.color_scheme').attr('class'))
						{
						jQuery('.nex-forms-container').prepend('<div class="active_theme" style="display:none;">default</div>');
						}
					else
						{
						jQuery('.overall-form-settings li.'+jQuery('.active_theme').text()).trigger('click');
						}
					jQuery('div.nex-forms-container .form_field').each(
						function(index)
							{
							//jQuery(this).css('z-index',1000-index)
							setup_form_element(jQuery(this))
							
							//jQuery('.move_field').remove();
							//if(!jQuery(this).find('.move_field').length<0)
								//jQuery(this).find('.field_settings').prepend('<div title="Edit Field Attributes" class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>')
							
							
							if(jQuery(this).hasClass('text') || jQuery(this).hasClass('textarea'))
								{
								if(jQuery(this).find('.the_input_element').attr('data-maxlength-show')=='true')
									jQuery(this).find('.the_input_element').maxlength({ placement:(jQuery(this).find('.the_input_element').attr('data-maxlength-position')) ? jQuery(this).find('.the_input_element').attr('data-maxlength-position') : 'bottom', alwaysShow: true , set_ID: jQuery(this).attr('id'), warningClass: 'label '+ jQuery(this).find('.the_input_element').attr('data-maxlength-color') });
								}
							/*if(jQuery(this).hasClass('grid-system'))
								{
								jQuery(this).find('.input-inner').first().append('<div class="field_settings bs-callout bs-callout-info" style="display:none;"><div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div></div>');
								}*/
							}
						);
					reset_zindex();
					jQuery('.radio-group a, .check-group a').addClass('ui-state-default')
					jQuery('.grid-system .panel-body').removeClass('ui-widget-content');
					jQuery('.bootstrap-select.ui-state-default').removeClass('ui-state-default');
					jQuery('.bootstrap-select').removeClass('form-control').addClass('full_width');
					jQuery('.selectpicker, .dropdown-menu.the_input_element').addClass('ui-state-default')
					jQuery('.grid-system .panel-body').removeClass('ui-widget-content');
					jQuery('.bootstrap-select.ui-state-default').removeClass('ui-state-default');
					
					
					jQuery('.panel-heading .btn').trigger('click');
					
			   
			   
			},
			 error: function(jqXHR, textStatus, errorThrown)
				{
				   console.log(errorThrown)
				}
		});
		
		
		jQuery('#style_config').ajaxForm({
			data: {
			   action: 'save_style_config'
			},
			//dataType: 'json',
			beforeSubmit: function(formData, jqForm, options) {
				//alert('test');
				//console.log($('input[name="do_image_upload_preview"]').val())
				jQuery('#style_config button').html('&nbsp;&nbsp;&nbsp;<span class="fa fa-spin fa-spinner"></span>&nbsp;Saving...&nbsp;&nbsp;&nbsp;')
			},
		   success : function(responseText, statusText, xhr, $form) {
			   jQuery('#style_config button').html('&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;');
			   jQuery('#style_config .alert').first().slideDown('slow');
			   
			},
			 error: function(jqXHR, textStatus, errorThrown)
				{
				   console.log(errorThrown)
				}
		});
		
		
		
		jQuery('#other_config').ajaxForm({
			data: {
			   action: 'save_other_config'
			},
			//dataType: 'json',
			beforeSubmit: function(formData, jqForm, options) {
				//alert('test');
				//console.log($('input[name="do_image_upload_preview"]').val())
				jQuery('#other_config button').html('&nbsp;&nbsp;&nbsp;<span class="fa fa-spin fa-spinner"></span>&nbsp;Saving...&nbsp;&nbsp;&nbsp;')
			},
		   success : function(responseText, statusText, xhr, $form) {
			   jQuery('#other_config button').html('&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;');
			   jQuery('#other_config .alert').first().slideDown('slow');
			   
			},
			 error: function(jqXHR, textStatus, errorThrown)
				{
				   console.log(errorThrown)
				}
		});
		
	}
);
jQuery(document).ready(
function()
	{
	//load_nex_event_calendars('');
	/*jQuery('#nex_autoresponder_confirmation_mail_body').jqte(
		{
		sub:false,
		sup:false,
		strike: false
		}
	);*/
	
	 jQuery('#nex_autoresponder_confirmation_mail_body').tinymce({
      script_url : jQuery('#site_url').text()+'/js/tiny_mce/tiny_mce.js',
      theme : "advanced"
   });
    jQuery('#nex_autoresponder_admin_mail_body').tinymce({
      script_url : jQuery('#site_url').text()+'/js/tiny_mce/tiny_mce.js',
      theme : "advanced"
   });


	
	jQuery('.get-add-on').popover({html:true});
	
/*************************************************************************************/
/******************************** SAVE FORM ******************************************/
/*************************************************************************************/

jQuery('input#the_form_title').keyup(
		function()
			{
			jQuery(this).popover('destroy')
			if(jQuery(this).val()=='')
				{
				jQuery(this).popover({trigger:'manual'});
				jQuery(this).popover('show');
				}
			else
				jQuery(this).popover('destroy')
			}
		);
jQuery('#the_form_title').popover({trigger:'manual'});
	jQuery('#save_nex_form').live('click',
		function()
			{
			
		var clicked = jQuery(this);
		var current_button = jQuery(this).html()
			
		if(jQuery('#the_form_title').val()=='')
			{
			jQuery('#the_form_title').popover('show');
			setTimeout(function(){jQuery('#the_form_title').popover('hide'); jQuery('#the_form_title').popover('destroy');},1500)
			return;
			}
	
		jQuery('div.admin_html').html(jQuery('div.nex-forms-container').html())
		jQuery('div.clean_html').html(jQuery('div.nex-forms-container').html())
		
		clean_html = jQuery('div.clean_html');
		admin_html = jQuery('div.admin_html');
		
		admin_html.find('#slider').html('');
		admin_html.find('#star' ).raty('destroy');
		admin_html.find('.bootstrap-touchspin-prefix').remove();
		admin_html.find('.bootstrap-touchspin-postfix').remove();
		admin_html.find('.bootstrap-touchspin .input-group-btn').remove();
		admin_html.find('.bootstrap-tagsinput').remove();
		admin_html.find('.popover').remove();
		admin_html.find('div.cd-dropdown').remove();
		admin_html.find('.form_field').removeClass('edit-field');
		admin_html.find('.bootstrap-select').remove();
		admin_html.find('.popover').remove();
		
		var hidden_fields = '';	
		jQuery('.hidden_fields .hidden_field').each(
			function()
				{
				hidden_fields += jQuery(this).find('input.field_name').val();
				hidden_fields += '[split]';
				hidden_fields += jQuery(this).find('input.field_value').val();
				hidden_fields += '[end]';
				}
			);
				
				
	jQuery('.nex-forms-field-settings').removeClass('opened');
	jQuery('.form_field').removeClass('edit-field');
	jQuery('.current_id').text('');
	
	
	
	clean_html = jQuery('div.clean_html');
		
		
	clean_html.find('#star' ).raty('destroy');		
	clean_html.find('.zero-clipboard, div.ui-nex-forms-container .field_settings').remove();
	clean_html.find('.grid').removeClass('grid-system')		
	clean_html.find('.editing-field-container').removeClass('.editing-field-container')
	clean_html.find('.bootstrap-touchspin-prefix').remove();
	clean_html.find('.bootstrap-select').remove();
	clean_html.find('.bootstrap-touchspin-postfix').remove();
	clean_html.find('.bootstrap-touchspin .input-group-btn').remove();
	clean_html.find('.bootstrap-tagsinput').remove();
	clean_html.find('div#the-radios input').prop('checked',false);
	clean_html.find('div#the-radios a').attr('class','');
	clean_html.find('.editing-field').removeClass('editing-field')
	clean_html.find('.editing-field-container').removeClass('.editing-field-container')
	clean_html.find('div.trash-can').remove();
	clean_html.find('div.draggable_object').hide();
	clean_html.find('div.draggable_object').remove();
	clean_html.find('div.form_field').removeClass('field');
	clean_html.find('.zero-clipboard').remove();
	clean_html.find('.tab-pane').removeClass('tab-pane');	
	clean_html.find('.help-block.hidden, .is_required.hidden').remove();
	clean_html.find('.has-pretty-child, .slider').removeClass('svg_ready')
	clean_html.find('.input-group').removeClass('date');
	clean_html.find('.popover').remove();
	clean_html.find('.the_input_element, .row, .svg_ready, .radio-inline').each(
		function()
			{
			if(jQuery(this).parent().hasClass('input-inner') || jQuery(this).parent().hasClass('input_holder')){
				jQuery(this).unwrap();
				}	
			}
		);
	clean_html.find('.form_field').each(
		function()
			{
			obj = jQuery(this);
			clean_html.find('.customcon').each(
					function()
						{
						if(obj.attr('id')==jQuery(this).attr('data-target') && (jQuery(this).attr('data-action')=='show' || jQuery(this).attr('data-action')=='slideDown' || jQuery(this).attr('data-action')=='fadeIn'))
							clean_html.find('#'+obj.attr('id')).hide();
						}
					);
				}
			);
	clean_html.find('div').each(
		function()
			{
			if(jQuery(this).parent().hasClass('svg_ready') || jQuery(this).parent().hasClass('form_object') || jQuery(this).parent().hasClass('input-inner')){
				jQuery(this).unwrap();
				}
			}
		);
	clean_html.find('div.form_field').each(
		function()
			{
			if(jQuery(this).parent().parent().hasClass('panel-default') && !jQuery(this).parent().prev('div').hasClass('panel-heading')){
				jQuery(this).parent().unwrap();
				jQuery(this).unwrap();
				}
			}
		);
		
	clean_html.find('.help-block').each(
		function()
			{
			if(!jQuery(this).text())
				jQuery(this).remove()
			}
		);
	clean_html.find('.sub-text').each(
		function()
			{
			if(jQuery(this).text()=='')
				{
				jQuery(this).parent().find('br').remove()
				jQuery(this).remove();
				}
			}
		);
	clean_html.find('.label_container').each(
		function()
			{
			if(jQuery(this).css('display')=='none')
				{
				jQuery(this).parent().find('.input_container').addClass('full_width');
				jQuery(this).remove()
				}
			}
		);
	clean_html.find('.ui-draggable').removeClass('ui-draggable');
	clean_html.find('.ui-draggable-handle').removeClass('ui-draggable-handle')
	clean_html.find('.dropped').removeClass('dropped')
	clean_html.find('.ui-sortable-handle').removeClass('ui-sortable-handle');
	clean_html.find('.ui-sortable').removeClass('ui-sortable-handle');
	clean_html.find('.ui-droppable').removeClass('ui-sortable-handle');
	clean_html.find('.over').removeClass('ui-sortable-handle');
	clean_html.find('.the_input_element.bs-tooltip').removeClass('bs-tooltip') 
	clean_html.find('.bs-tooltip.glyphicon').removeClass('glyphicon');
	clean_html.find('.grid-system.panel').removeClass('panel-body');
	clean_html.find('.grid-system.panel').removeClass('panel');
	clean_html.find('.form_field.grid').removeClass('grid').removeClass('form_field').addClass('is_grid');
	clean_html.find('.grid-system').removeClass('grid-system');
	clean_html.find('.move_field').remove();
	clean_html.find('.input-group-addon.btn-file span').attr('class','fa fa-cloud-upload');
	clean_html.find('.input-group-addon.fileinput-exists span').attr('class','fa fa-close');
	clean_html.find('.checkbox-inline').addClass('radio-inline');
	clean_html.find('.check-group').addClass('radio-group');
	clean_html.find('.submit-button br').remove();
	clean_html.find('.submit-button small.svg_ready').remove();
	clean_html.find('.radio-group a, .check-group a').addClass('ui-state-default')
	clean_html.find('.is_grid .panel-body').removeClass('ui-widget-content');
	clean_html.find('.bootstrap-select.ui-state-default').removeClass('ui-state-default');
	clean_html.find('.bootstrap-select').removeClass('form-control').addClass('full_width');
	clean_html.find('.selectpicker, .dropdown-menu.the_input_element').addClass('ui-state-default');
	clean_html.find('.selectpicker').removeClass('dropdown-toggle')
	clean_html.find('.is_grid .panel-body').removeClass('ui-widget-content');
	clean_html.find('.bootstrap-select.ui-state-default').removeClass('ui-state-default');
	clean_html.find('.is_grid .panel-body').removeClass('ui-sortable').removeClass('ui-droppable').removeClass('ui-widget-content').removeClass('');
	clean_html.find('.step').hide()
	clean_html.find('.step').first().show();	
		
				
		clicked.html('<span class="fa fa-refresh fa-spin"></span>&nbsp;&nbsp;Saving...')
			var data =
				{
				action	 							: (jQuery('.form_update_id').text()) ? 'edit_form' : 'insert_nex_form' ,
				table								: 'wap_nex_forms',
				edit_Id								: jQuery('.form_update_id').text().trim(),
				plugin								: 'shared',
				title								: jQuery('#the_form_title').val(),
				form_fields							: admin_html.html(),
				clean_html							: clean_html.html(),
				is_form								: '1',
				is_template							: '0',
				post_type							: jQuery('input[name="post_type"]:checked').val(),
				post_action							: jQuery('input[name="post_action"]:checked').val(),
				custom_url							: jQuery('#on_form_submission_custum_url').val(),
				mail_to								: jQuery('#nex_autoresponder_recipients').val(),
				from_address						: jQuery('#nex_autoresponder_from_address').val(),
				from_name							: jQuery('#nex_autoresponder_from_name').val(),
				on_screen_confirmation_message		: jQuery('#nex_autoresponder_on_screen_confirmation_message').val(),
				google_analytics_conversion_code	: jQuery('#google_analytics_conversion_code').val(),
				confirmation_page					: jQuery('#nex_autoresponder_confirmation_page').val(),
				user_email_field					: jQuery('#nex_autoresponder_user_email_field').val(),
				confirmation_mail_subject			: jQuery('#nex_autoresponder_confirmation_mail_subject').val(),
				confirmation_mail_body				: jQuery('#nex_autoresponder_confirmation_mail_body').val(),
				on_form_submission					: jQuery('input[name="on_form_submission"]:checked').val(),
				hidden_fields						: hidden_fields,
				admin_email_body					: jQuery('#nex_autoresponder_admin_mail_body').val(),
				bcc									: jQuery('#nex_admin_bcc_recipients').val(),
				bcc_user_mail						: jQuery('#nex_autoresponder_bcc_recipients').val(),
				custom_css							: jQuery('#set_custom_css').val(),
				is_paypal							: (jQuery('.slide_in_paypal_setup input[name="is_paypal"]:checked').val()) ? jQuery('.slide_in_paypal_setup  input[name="is_paypal"]:checked').val() : 'no',
				};
				
			if(jQuery(this).hasClass('template_only'))
				{
				data.is_form = '0';
				data.is_template = '1';
				data.action = 'insert_nex_form';
				}
			else
				{
				data.is_template = '0';
				}
							
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					jQuery('div.clean_html').html('');
					jQuery('div.admin_html').html('');
					setTimeout(function(){ clicked.html(current_button);},1500);
					clicked.html('<span class="fa fa-thumbs-up"></span>&nbsp;&nbsp;Saved!');
					
						
						
							
									
								var product_array = '';
								
								jQuery('.paypal_products .paypal_product').each(
									function(index)
										{
										
										product_array += '[start_product]';
										
											product_array += '[item_name]';
												product_array += jQuery(this).find('input[name="item_name"]').val();
											product_array += '[end_item_name]';
											
											product_array += '[item_qty]';
												product_array += jQuery(this).find('input[name="item_quantity"]').val();
											product_array += '[end_item_qty]';
											
											product_array += '[map_item_qty]';
												product_array += jQuery(this).find('select[name="map_item_quantity"]').val();
											product_array += '[end_map_item_qty]';
											
											product_array += '[set_quantity]';
												product_array += jQuery(this).find('input[name="set_quantity"]').val();
											product_array += '[end_set_quantity]';
											
											product_array += '[item_amount]';
												product_array += jQuery(this).find('input[name="item_amount"]').val();
											product_array += '[end_item_amount]';
											
											product_array += '[map_item_amount]';
												product_array += jQuery(this).find('select[name="map_item_amount"]').val();
											product_array += '[end_map_item_amount]';
											
											product_array += '[set_amount]';
												product_array += jQuery(this).find('input[name="set_amount"]').val();
											product_array += '[end_set_amount]';
																					
										product_array += '[end_product]';
										
										
										}
									);
								
								var data =
									{
									action	 							: (jQuery('.form_update_id').text()) ? 'update_paypal' : 'insert_nex_form' ,
									table								: 'wap_nex_forms_paypal',
									nex_forms_Id						: (jQuery('.form_update_id').text()) ? jQuery('.form_update_id').text().trim() : response.trim(),
									plugin								: 'shared',
									title								: jQuery('#the_form_title').val(),
									products							: product_array,
									currency_code						: (jQuery('.slide_in_paypal_setup select[name="currency_code"]').val()) ? jQuery('.slide_in_paypal_setup select[name="currency_code"]').val() : 'USD',
									business							: jQuery('.slide_in_paypal_setup input[name="business"]').val(),
									cmd									: '_cart',
									return_url							: jQuery('.slide_in_paypal_setup input[name="return"]').val(),
									lc									: (jQuery('.slide_in_paypal_setup select[name="paypal_language_selection"]').val()) ? jQuery('.slide_in_paypal_setup select[name="paypal_language_selection"]').val() : 'US',
									environment							: (jQuery('.slide_in_paypal_setup input[name="paypal_environment"]:checked').val()) ? jQuery('.slide_in_paypal_setup  input[name="paypal_environment"]:checked').val() : 'sandbox',
									};
								
											
								jQuery.post
										(ajaxurl, data, function(response)
											{
											
											}
									);
						if(response)
						{
						jQuery('.form_update_id').text(response.trim())
						}
					}
				);
			}
		);
	
	jQuery('.send_test_email').click(
		function()
			{
			get_btn_text = jQuery('.send_test_email').html();
			jQuery('.send_test_email').html('<span class="fa fa-spinner fa-spin"></span>&nbsp;Sending...');
			var data =
				{
				action			: 'nf_send_test_email',
				email_address  	: jQuery('input[name="test_email_address"]').val()
				};
		jQuery.post
			(
			ajaxurl, data, function(response)
				{
					jQuery('.send_test_email').html('Done, check your inbox!')
					setTimeout( function(){ jQuery('.send_test_email').html(get_btn_text); },2000 )
				}
			);
			}
		);
	
	
/*************************************************************************************/
/******************************** LOAD FORMS *****************************************/
/*************************************************************************************/
	function load_nex_event_calendars(cal_id){
		var data =
				{
				action	: 'load_nex_event_calendars',
				cal_id  : cal_id
				};
		var the_id = cal_id;
		jQuery.post
			(
			ajaxurl, data, function(response)
				{
				jQuery('div.saved_forms').html(response);
				jQuery('.saved_forms button').tooltip();
				if(the_id)
					{
					/*var cal_item = jQuery('.saved_forms a#'+ the_id);
							
					cal_item.addClass('edited');
					setTimeout(function(){cal_item.removeClass('edited')},2000)*/
					}
				if(jQuery('.form_update_id').text())
						jQuery('.saved_forms a#'+jQuery('.form_update_id').text().trim()).addClass('active');
				}
			);
		}
		
	function load_form_templates(cal_id){
		var data =
				{
				action	: 'load_templates',
				cal_id  : cal_id
				};
		var the_id = cal_id;
		jQuery.post
			(
			ajaxurl, data, function(response)
				{
				jQuery('div.template_forms').html(response);
				}
			);
		}

function switch_slide_in(btn){
	jQuery('.top-strip .active').removeClass('active');
	btn.addClass('active');
	jQuery('.slide_in_container').removeClass('opened');
	jQuery('.slide_in_page').removeClass('opened');	
}
function switch_slide_page(btn){
	jQuery('.slide_in_container .active').removeClass('active');
	btn.addClass('active');
	jQuery('.slide_in_page').removeClass('opened');
		
}
jQuery('#collapseFormsCanvas').click(
	function()
		{
		jQuery('.top-strip .active').removeClass('active');
		jQuery('.slide_in_container').removeClass('opened');
		jQuery('.slide_in_page').removeClass('opened');	
		}
	);
jQuery('.close_slide_in').live('click',
	function()
		{
		jQuery('.top-strip .active').removeClass('active');
		jQuery('.slide_in_container, .slide_in_page').removeClass('opened');
		}
	);
jQuery('.close_slide_in_right').click(
	function()
		{
		jQuery('.edit-field').removeClass('edit-field');
		jQuery('.top-strip .active').removeClass('active');
		jQuery('.slide_in_right').removeClass('opened')
		jQuery('#nex-forms-field-settings').removeClass('opened')
		}
	);
jQuery('.view_styling_options').click(
	function()	
		{
		jQuery('.edit-field').removeClass('edit-field');
		jQuery('.top-strip .active').removeClass('active');
		jQuery('.slide_in_container').removeClass('opened');
		jQuery('.slide_in_page').removeClass('opened');	
		jQuery('.slide_in_right').removeClass('opened');
		jQuery(this).addClass('active');
		jQuery('#nex-forms-field-settings').removeClass('opened')
		jQuery('.slide_in_styling_options').addClass('opened')
		}
	);

jQuery('.view_logic').click(
	function()	
		{
		jQuery('.top-strip .active').removeClass('active');
		jQuery('.slide_in_container').removeClass('opened');
		jQuery('.slide_in_right').removeClass('opened');	
		jQuery('.slide_in_page').removeClass('opened');	
		jQuery(this).addClass('active');
		jQuery('.slide_in_logic').addClass('opened')
		}
	);

/* PAYPAL OPTIONS */
jQuery('.view_paypal_options').click(
				function()
					{
					switch_slide_in(jQuery(this));
					jQuery('.paypal_options').addClass('opened');
					jQuery('#paypal_setup').trigger('click');
					
					jQuery('.slide_in_right').removeClass('opened')
					jQuery('#nex-forms-field-settings').removeClass('opened')
					}
				);

jQuery('.paypal_products').sortable(
			{
			start : function(event, ui)
				{ 
			 	}, 
			stop : function(event, ui){ 
					jQuery('.paypal_products .paypal_product').each(
						function(index)
							{
							jQuery(this).find('.product_number').text('Item '+ (index+1));
							}
						);
			  },           
			placeholder: 'alert-warning place-holder',
			forcePlaceholderSize : true,
			connectWith:'.paypal_products'
			}
		);


jQuery('#paypal_setup').click(
	function()
		{
		switch_slide_page(jQuery(this));
		jQuery('.slide_in_paypal_setup').addClass('opened');
		}
);


jQuery('#paypal_products_setup').click(
	function()
		{
		switch_slide_page(jQuery(this));
		jQuery('.slide_in_paypal_product_setup').addClass('opened');
		
			
			var set_current_fields_math_logic = '<option value="0" selected="selected">--- Map Field --</option>';
						set_current_fields_math_logic += '<optgroup label="Text Fields">';
						jQuery('div.nex-forms-container div.form_field input[type="text"]').each(
							function()
								{
								set_current_fields_math_logic += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						set_current_fields_math_logic += '<optgroup label="Radio Buttons">';
						
						var old_radio = '';
						var new_radio = '';
						
						jQuery('div.nex-forms-container div.form_field input[type="radio"]').each(
							function()
								{
								old_radio = jQuery(this).attr('name');
								if(old_radio != new_radio)
									set_current_fields_math_logic += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								
								new_radio = old_radio;
								
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						var old_check = '';
						var new_check = '';
						set_current_fields_math_logic += '<optgroup label="Check Boxes">';
						jQuery('div.nex-forms-container div.form_field input[type="checkbox"]').each(
							function()
								{
								old_check = jQuery(this).attr('name');
								if(old_check != new_check)
									set_current_fields_math_logic += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								new_check = old_check;
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						set_current_fields_math_logic += '<optgroup label="Selects">';
						jQuery('div.nex-forms-container div.form_field select').each(
							function()
								{
								set_current_fields_math_logic += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						set_current_fields_math_logic += '<optgroup label="Text Areas">';
						jQuery('div.nex-forms-container div.form_field textarea').each(
							function()
								{
								set_current_fields_math_logic += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
					
						set_current_fields_math_logic += '<optgroup label="Hidden Fields">';
						jQuery('div.nex-forms-container div.form_field input[type="hidden"]').each(
							function()
								{
								set_current_fields_math_logic += '<option value="'+ format_illegal_chars(jQuery(this).attr('name'))  +'">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						
						
					jQuery('.paypal_products').find('select').html(set_current_fields_math_logic);
					jQuery('.paypal_products .paypal_product').each(
						function()
							{
							jQuery(this).find('select[name="map_item_quantity"] option[value="'+ jQuery(this).find('input[name="selected_qty_field"]').val() +'"]').attr('selected','selected');
							jQuery(this).find('select[name="map_item_quantity"] option[value="'+ jQuery(this).find('input[name="selected_qty_field"]').val() +'"]').trigger('click');
							jQuery(this).find('select[name="map_item_quantity"]').trigger('change');
							console.log('select[name="map_item_quantity"] option[value="'+ jQuery(this).find('input[name="selected_qty_field"]').val() +'"]');
							
							jQuery(this).find('select[name="map_item_amount"] option[value="'+ jQuery(this).find('input[name="selected_amount_field"]').val() +'"]').attr('selected','selected');
							jQuery(this).find('select[name="map_item_amount"] option[value="'+ jQuery(this).find('input[name="selected_amount_field"]').val() +'"]').trigger('click');
							jQuery(this).find('select[name="map_item_amount"]').trigger('change');
							console.log('select[name="map_item_amount"] option[value="'+ jQuery(this).find('input[name="selected_amount_field"]').val() +'"]');
							}
						);
		
		}
	);



jQuery('.view_saved_forms').click(
				function()
					{
					switch_slide_in(jQuery(this));
					jQuery('.saved_forms_container').addClass('opened');
					load_nex_event_calendars('');
					}
				);
jQuery('.create_new_form').click(
				function()
					{
					switch_slide_in(jQuery(this));
					jQuery('.new_form_container').addClass('opened');
					load_form_templates('');
					}
				);
jQuery('.autoRespond').click(
				function()
					{
					switch_slide_in(jQuery(this));
					jQuery('.auto_responder_settings').addClass('opened');
					jQuery('#message_attr').trigger('click');
					
					jQuery('.slide_in_right').removeClass('opened')
					jQuery('#nex-forms-field-settings').removeClass('opened')
					}
				);		

jQuery('.view_forms_options').click(
				function()
					{
					switch_slide_in(jQuery(this));
					jQuery('.form_options').addClass('opened');
					jQuery('#on_form_submit').trigger('click');
					
	jQuery('.slide_in_right').removeClass('opened')
	jQuery('#nex-forms-field-settings').removeClass('opened')
					}
				);

jQuery('#hidden_fields').click(
	function()
		{
		switch_slide_page(jQuery(this));
		jQuery('.slide_in_form_hidden_fields').addClass('opened');
		}
	);
	
jQuery('#on_form_submit').click(
	function()
		{
		switch_slide_page(jQuery(this));
		jQuery('.slide_in_on_submit').addClass('opened');
		
		}
	);


jQuery('#message_attr').click(
	function()
		{
		switch_slide_page(jQuery(this));
		jQuery('.slide_in_autoresponder_settings').addClass('opened');
		}
	);
jQuery('#admin_setup').click(
	function()
		{
		switch_slide_page(jQuery(this));
		jQuery('.slide_in_autoresponder_admin_email').addClass('opened');
		var set_current_fields = '';
						jQuery('div.nex-forms-container div.form_field .the_label').each(
							function()
								{
								set_current_fields += '<div class="input_name">'+ jQuery(this).text() + '</div><div class="input_placeholder"><input name="get_place_holder_value"  value="' + '{{' + format_illegal_chars(jQuery(this).text()) + '}}" type="text"></div>';
								}
							);
					
					jQuery('.available_fields_holder').html(set_current_fields);
		}
	);

jQuery('#autoresponder_setup').click(
	function()
		{
		switch_slide_page(jQuery(this));
		jQuery('.slide_in_autoresponder_user_email').addClass('opened');
		var set_current_fields = '';
						jQuery('div.nex-forms-container div.form_field .the_label').each(
							function()
								{
								set_current_fields += '<div class="input_name">'+ jQuery(this).text() + '</div><div class="input_placeholder"><input name="get_place_holder_value"  value="' + '{{' + format_illegal_chars(jQuery(this).text()) + '}}" type="text"></div>';
								}
							);
		var posible_email_fields = '<option value="">Dont send confirmation mail to user</option>';	
			var has_email_fields = false;
			jQuery('div.nex-forms-container div.form_field input.email').each(
				function()
					{
					has_email_fields = true;
					posible_email_fields += '<option value="'+  jQuery(this).attr('name') +'" '+ ((jQuery('.nex_form_attr .user_email_field').text()==jQuery(this).attr('name')) ? 'selected="selected"' : '') +' >'+ jQuery(this).closest('div.form_field').find('.the_label').text() +'</option>';
					}
				);
			if(!has_email_fields)
				jQuery('.no-email').removeClass('hidden');
			else
				jQuery('.no-email').addClass('hidden');
				
			jQuery('select[name="posible_email_fields"]').html(posible_email_fields);		
					jQuery('.available_fields_holder').html(set_current_fields);
		}
	);
	
jQuery('.show_form_entries').click(
	function()
		{
		
	jQuery('.slide_in_right').removeClass('opened')
	jQuery('#nex-forms-field-settings').removeClass('opened')
		if(jQuery(this).find('.entry-count').text()=='0')
			{
			jQuery(this).popover({trigger:'manual'});
			jQuery(this).popover('show');
			setTimeout(function(){jQuery('.show_form_entries').popover('hide'); jQuery('.show_form_entries').popover('destroy');},1500)	
			}
		else
			{
			jQuery(this).popover('destroy');
			switch_slide_page(jQuery(this));
			switch_slide_in(jQuery(this));
			
			jQuery('.form_entries_slide_in').addClass('opened');
			
			
			if(jQuery('#paypal_yes').prop('checked'))
				{
					jQuery('.wp-list-table th:nth-child(7)').show();
					jQuery('.wp-list-table td:nth-child(7)').show();
				}
			else
				{
					jQuery('.wp-list-table th:nth-child(7)').hide();
					jQuery('.wp-list-table td:nth-child(7)').hide();
				}
				console.log(jQuery('#paypal_yes').prop('checked'));
			
			}
		//jQuery('.form_entry_settings').toggleClass('opened');
		
		}
	);


	
jQuery('.data_select div').click(
	function()
		{
		jQuery('.data_select div').removeClass('active')
		jQuery(this).addClass('active')
		if(jQuery(this).hasClass('form_data'))
			{
			jQuery('.available_server_data').slideUp();
			jQuery('.available_fields_holder').slideDown()
			}
		else
			{
			jQuery('.available_server_data').slideDown();
			jQuery('.available_fields_holder').slideUp()
			}
		}
	);
jQuery('input[name="get_place_holder_value"]').live('click',function(){ this.select(); });
				
						
jQuery('#blank_form').click(
	function()
		{
		jQuery('#collapseFormsCanvas .nex-forms-container').html('');
		jQuery('.form_update_id').text('');
		jQuery('#the_form_title').val('');
		jQuery('.entry-count').text('0');
		}
	);

/*************************************************************************************/
/******************************* DELETE FORMS ****************************************/
/*************************************************************************************/
jQuery('.delete_the_calendar').live('click',
		function()
			{		
			jQuery(this).closest('.list-group-item').find('.do_permanent_delete').addClass('opened');
			}
		);

jQuery('.dont_delete, .do_delete').live('click',
		function()
			{		
			jQuery(this).closest('.list-group-item').find('.do_permanent_delete').removeClass('opened');
			}
		);

		
jQuery('.do_delete').live('click',
		function()
			{
			if(jQuery(this).attr('id') == jQuery('.form_update_id').text().trim())
				{
				jQuery('.form_update_id').text('');
				jQuery('#the_form_title').val('');
				jQuery('div.nex-forms-container').html('');
				}
			//jQuery(this).closest('a').css('background','#d9534f')
			jQuery(this).closest('.list-group-item').fadeOut('slow');
			
			var data =
				{
				action	 						: 'delete_record',
				table							: 'wap_nex_forms',
				Id								: jQuery(this).attr('id')
				};		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{					
					}
				);
			}
		);
		
		
/*************************************************************************************/
/******************************* EDIT FORMS ******************************************/
/*************************************************************************************/
jQuery('.edit_the_calendar').live('click',
		function()
			{
			jQuery('#editCalendar').find('.do_edit').attr('data-id',jQuery(this).attr('id'));
			jQuery('#editCalendar').find('.do_edit').attr('data-table','wap_nex_forms')
			jQuery('#editCalendar').find('input[name="new_calendar_title"]').val(jQuery(this).closest('.list-group-item').find('.calendar_title').text());
			jQuery('#editCalendar').find('input[name="new_calendar_description"]').val(jQuery(this).closest('.list-group-item').find('.calendar_description').text());
			}
		);

jQuery('#editCalendar .do_edit').live('click',
		function()
			{
			if(!jQuery('#editCalendar input[name="new_calendar_title"]').val())
				{
				jQuery('#editCalendar input[name="new_calendar_title"]').popover({trigger:'manual'});
				jQuery('#editCalendar input[name="new_calendar_title"]').popover('show');
				jQuery('#editCalendar input[name="new_calendar_title"]').parent().find('.popover ').addClass('alert-info');
				jQuery('#editCalendar input[name="new_calendar_title"]').focus();
				return;
				}
			
			if(jQuery('.do_edit').attr('data-id') == jQuery('.form_update_id').text().trim())  
					jQuery('a.visible_form_title').html('<span class="fa fa-file"></span>&nbsp;&nbsp;'+jQuery('#editCalendar input[name="new_calendar_title"]').val());	
			
			var data =
				{
				action	 						: 'do_edit',
				edit_Id							: jQuery('#editCalendar .do_edit').attr('data-id'),
				table							: 'wap_nex_forms',
				title							: jQuery('#editCalendar input[name="new_calendar_title"]').val(),
				description						: jQuery('#editCalendar input[name="new_calendar_description"]').val()
				};		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					load_nex_event_calendars('');
					}
				);
			}
		);
jQuery('a.visible_form_title').click(
	function()
		{
		jQuery('.saved_forms .list-group-item.active .edit_the_calendar').trigger('click');	
		}
	);		
		
/*************************************************************************************/
/***************************** DUPLICATE FORMS ***************************************/
/*************************************************************************************/
jQuery('.duplicate_record').live('click',
		function()
			{
			var data =
				{
				action	 						: 'duplicate_record',
				table							: 'wap_nex_forms',
				Id								: jQuery(this).attr('id')
				};
			jQuery('.saved_forms').html('<div class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>')		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					load_nex_event_calendars(response);
					}
				);
			}
		);

/*************************************************************************************/
/*********************************** USE FORMS ***************************************/
/*************************************************************************************/	
jQuery('.embed_form').live('click',
		function()
			{
			if(jQuery('.form_update_id').text().trim()=='')
				{
				jQuery(this).popover({trigger:'manual'});
				jQuery(this).popover('show');
				setTimeout(function(){jQuery('.embed_form').popover('hide'); jQuery('.embed_form').popover('destroy');},1500)	
				}
			else
				{
				jQuery('#useForm').modal('toggle')
				jQuery(this).popover('destroy');
				jQuery('#useForm').find('.sc_normal').text('[NEXForms id="'+ jQuery('.form_update_id').text().trim() +'"]');
				jQuery('#useForm').find('.sc_popup_button').text('[NEXForms id="'+ jQuery('.form_update_id').text().trim() +'" open_trigger="popup" type="button" text="Open Form"]');
				jQuery('#useForm').find('.sc_popup_link').text('[NEXForms id="'+ jQuery('.form_update_id').text().trim() +'" open_trigger="popup" type="link" text="Open Form"]');
				
				jQuery('#useForm').find('.php_normal').html('&lt;?php NEXForms_ui_output(array("id"=>'+ jQuery('.form_update_id').text().trim() +'),true); ?&gt;');
				jQuery('#useForm').find('.php_popup_button').html('&lt;?php NEXForms_ui_output(array("id"=>'+ jQuery('.form_update_id').text().trim() +',"open_trigger"=>"popup", "type"=>"button", "text"=>"Open Form"),true); ?&gt;');
				jQuery('#useForm').find('.php_popup_link').html('&lt;?php NEXForms_ui_output(array("id"=>'+ jQuery('.form_update_id').text().trim() +',"open_trigger"=>"popup", "type"=>"link", "text"=>"Open Form"),true); ?&gt;');
				}
			}
		);


jQuery('input[name="new_calendar_title"]').val('');
jQuery('input[name="new_calendar_description"]').val('');

jQuery('.create_new_calendar').live('click',
		function()
			{
			if(!jQuery('#welcomeMessage input[name="new_calendar_title"]').val())
				{
				jQuery('#welcomeMessage input[name="new_calendar_title"]').popover({trigger:'manual'});
				jQuery('#welcomeMessage input[name="new_calendar_title"]').popover('show');
				jQuery('#welcomeMessage input[name="new_calendar_title"]').parent().find('.popover ').addClass('alert-info');
				jQuery('#welcomeMessage input[name="new_calendar_title"]').focus();
				return;
				}
				
			var clicked = jQuery(this);
			var current_button = jQuery(this).html();		
			
			clicked.html('<span class="fa fa-refresh fa-spin"></span>&nbsp;&nbsp;Saving...')
			jQuery('.saved_forms').html('<span class="fa fa-refresh fa-spin"></span>&nbsp;&nbsp;Loading Forms...')
			
			var data =
				{
				action	 							: 'do_insert',
				table								: 'wap_nex_forms',
				title								: jQuery('#welcomeMessage input[name="new_calendar_title"]').val(),
				description							: jQuery('#welcomeMessage input[name="new_calendar_description"]').val(),
				mail_to								: jQuery('.admin_email').text(),
				from_address						: jQuery('.admin_email').text(),
				from_name							: jQuery('.blogname').text(),
				on_screen_confirmation_message		: 'Thank you for connecting with us, we will respond to you shortly',
				confirmation_mail_subject			: jQuery('.blogname').text() + ' form submmision',
				confirmation_mail_body				: 'Thank you for connecting with us, we will respond to you shortly',
				admin_email_body					: '{{form_data}}'
				};		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					jQuery('#welcomeMessage input[name="new_calendar_title"]').val('')
					jQuery('#welcomeMessage input[name="new_calendar_description"]').val('');
					load_nex_event_calendars(response);
					
					clicked.html(current_button);
					
					jQuery('.saved_forms').animate(
							{
								scrollTop:0
							},500
						);
					}
				);
			}
		);


	
	 

	
	

/*************************************************************************************/
/********************************* OPEN FORM *****************************************/
/*************************************************************************************/			
	jQuery('.saved_forms .calendar_title').live('click',
		function()
			{
			jQuery('.saved_forms .list-group-item').removeClass('active');
			//jQuery('div.nex-forms-container').html('<h2><i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;Loading Form - "'+ jQuery(this).closest('.list-group-item').find('.calendar_title').text() +'"...</h2>')
			jQuery('div.nex-forms-container').html('<div class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>')
			jQuery(this).closest('.list-group-item').addClass('active');	
			jQuery('.btn').blur();
			jQuery('#the_form_title').popover('hide');
			jQuery('#the_form_title').val(jQuery(this).text())
			
			var the_ID = jQuery(this).closest('.list-group-item').attr('id').trim();
			
			jQuery('input[name="nex_forms_Id"]').val(the_ID);
			
			jQuery('#nex-forms .form_update_id').text(the_ID);

			var data =
				{
				action	 							: 'load_nex_form_hidden_fields',
				form_Id								: the_ID
				};
			jQuery.post
					(
					ajaxurl, data, function(response)
						{
						jQuery('div.hidden_fields').html(response)
						}
					);
					
			
			
			
					
			
			populate_list();
				
			jQuery('select.choose_nex_form option[value='+jQuery(this).attr('id') +']').attr('selected',true);
			jQuery('select.choose_nex_form').trigger('change');
			//
			jQuery('a.visible_form_title').html('<span class="fa fa-file"></span>&nbsp;&nbsp;'+jQuery(this).closest('.list-group-item').find('.calendar_title').text());
			
			
			
			
			var data =
				{
				action	 							: 'load_nex_form',
				form_Id								: the_ID
				};		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					jQuery('.saved_forms a.bs-tooltip').tooltip();
					if(jQuery('.nex-forms-field-settings').hasClass('open'))
						jQuery('div.nex-forms-field-settings .close').trigger('click');
					jQuery('div.nex-forms-container').html(response)
					jQuery('div.nex-forms-container div#the-radios input').prop('checked',false);
					jQuery('div.nex-forms-container').find('#star' ).raty('destroy');
					jQuery('div.nex-forms-container div#the-radios a').attr('class','');
					jQuery('.editing-field').removeClass('editing-field');
					jQuery('.form_field').removeClass('edit-field')
					jQuery('#field_container .col-sm-2').addClass('label_container');
					jQuery('#field_container .col-sm-10').addClass('input_container');
					jQuery('div.nex-forms-container').find('div.trash-can').remove();
					jQuery('.editing-field-container').removeClass('editing-field-container');
					setTimeout(function(){ jQuery('.editing-field').removeClass('editing-field'); },1000)
					setTimeout(function(){ jQuery('.editing-field-container').removeClass('.editing-field-container'); },1000)
					
					jQuery('div.nex-forms-container .field_settings').html('<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div><div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>')
					
					var set_current_fields = '';
						jQuery('div.nex-forms-container div.form_field .the_label').each(
							function()
								{
								set_current_fields += '<option value="{{'+ format_illegal_chars(jQuery(this).text())  +'}}">'+ jQuery(this).text() +'</option>';
								}
							);
					
						
					jQuery('select[name="current_fields"]').html(set_current_fields);
					
						
					
					if(!jQuery('link.color_scheme').attr('class'))
						{
						jQuery('.nex-forms-container').prepend('<div class="active_theme" style="display:none;">default</div>');
						}
					else
						{
						jQuery('.overall-form-settings li.'+jQuery('.active_theme').text()).trigger('click');
						}
					jQuery('div.nex-forms-container .form_field').each(
						function(index)
							{
							//jQuery(this).css('z-index',1000-index)
							setup_form_element(jQuery(this))
							
							//jQuery('.move_field').remove();
							//if(!jQuery(this).find('.move_field').length<0)
								//jQuery(this).find('.field_settings').prepend('<div title="Edit Field Attributes" class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>')
							
							
							if(jQuery(this).hasClass('text') || jQuery(this).hasClass('textarea'))
								{
								if(jQuery(this).find('.the_input_element').attr('data-maxlength-show')=='true')
									jQuery(this).find('.the_input_element').maxlength({ placement:(jQuery(this).find('.the_input_element').attr('data-maxlength-position')) ? jQuery(this).find('.the_input_element').attr('data-maxlength-position') : 'bottom', alwaysShow: true , set_ID: jQuery(this).attr('id'), warningClass: 'label '+ jQuery(this).find('.the_input_element').attr('data-maxlength-color') });
								}
							/*if(jQuery(this).hasClass('grid-system'))
								{
								jQuery(this).find('.input-inner').first().append('<div class="field_settings bs-callout bs-callout-info" style="display:none;"><div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div></div>');
								}*/
							}
						);
					reset_zindex();
					jQuery('.radio-group a, .check-group a').addClass('ui-state-default')
					jQuery('.grid-system .panel-body').removeClass('ui-widget-content');
					jQuery('.bootstrap-select.ui-state-default').removeClass('ui-state-default');
					jQuery('.bootstrap-select').removeClass('form-control').addClass('full_width');
					jQuery('.selectpicker, .dropdown-menu.the_input_element').addClass('ui-state-default')
					jQuery('.grid-system .panel-body').removeClass('ui-widget-content');
					jQuery('.bootstrap-select.ui-state-default').removeClass('ui-state-default');
					
					
					jQuery('.panel-heading .btn').trigger('click');
					
					
					
					
					
					var data =
				{
				action	 							: 'load_nex_form_attr',
				form_Id								: the_ID
				};		
				jQuery.post
					(
					ajaxurl, data, function(response)
						{
						
						jQuery('.nex_form_attr').html(response);
						jQuery('input#nex_autoresponder_recipients').val(jQuery('.nex_form_attr .mail_to').text());
						jQuery('input#nex_autoresponder_from_address').val(jQuery('.nex_form_attr .from_address').text());
						jQuery('input#nex_autoresponder_from_name').val(jQuery('.nex_form_attr .from_name').text());
						jQuery('#nex_autoresponder_on_screen_confirmation_message').val(jQuery('.nex_form_attr .on_screen_confirmation_message').text());
						jQuery('#nex_autoresponder_confirmation_page').val(jQuery('.nex_form_attr .confirmation_page').text());
						jQuery('input#nex_autoresponder_confirmation_mail_subject').val(jQuery('.nex_form_attr .confirmation_mail_subject').text());
						jQuery('input#on_form_submission_custum_url').val(jQuery('.nex_form_attr .custom_url').text());
						jQuery('#google_analytics_conversion_code').val(jQuery('.nex_form_attr .google_analytics_conversion_code').text());
						jQuery('#nex_autoresponder_confirmation_mail_body').val(jQuery('.nex_form_attr .confirmation_mail_body').html());
						jQuery('#nex_autoresponder_admin_mail_body').val(jQuery('.nex_form_attr .admin_email_body').html());
						jQuery('#nex_admin_bcc_recipients').val(jQuery('.nex_form_attr .bcc').html());
						jQuery('#nex_autoresponder_bcc_recipients').val(jQuery('.nex_form_attr .bcc_user_mail').html());
						jQuery('#set_custom_css').val(jQuery('.nex_form_attr .set_custom_css').html());
						jQuery('style.custom_css').html(jQuery('.nex_form_attr .set_custom_css').html())
						
						
						if(jQuery('.nex_form_attr .is_paypal').text()=='no' || jQuery('.nex_form_attr .is_paypal').text()=='')
							{
							jQuery('.slide_in_paypal_setup #paypal_no').attr('checked',true);
							jQuery('.slide_in_paypal_setup #paypal_no').trigger('click');
							}
						if(jQuery('.nex_form_attr .is_paypal').text()=='yes')
							{
							jQuery('.slide_in_paypal_setup #paypal_yes').attr('checked',true);
							jQuery('.slide_in_paypal_setup #paypal_yes').trigger('click');
							}
						
						
						jQuery('.slide_in_paypal_setup input[name="business"]').val(jQuery('.nex_form_attr .paypal-business').text());
						jQuery('.slide_in_paypal_setup input[name="return"]').val(jQuery('.nex_form_attr .paypal-return_url').text());
						
						if(jQuery('.nex_form_attr .paypal-environment').text()=='sandbox' || jQuery('.nex_form_attr .paypal-environment').text()=='')
							{
							jQuery('.slide_in_paypal_setup #sandbox').attr('checked',true);
							jQuery('.slide_in_paypal_setup #sandbox').trigger('click');
							}
						if(jQuery('.nex_form_attr .paypal-environment').text()=='live')
							{
							jQuery('.slide_in_paypal_setup #live').attr('checked',true);
							jQuery('.slide_in_paypal_setup #live').trigger('click');
							}
						
						jQuery('.slide_in_paypal_setup select[name="currency_code"] option[value="'+ jQuery('.nex_form_attr .paypal-currency_code').text() +'"]').attr('selected','selected');
						jQuery('.slide_in_paypal_setup select[name="currency_code"] option[value="'+ jQuery('.nex_form_attr .paypal-currency_code').text() +'"]').trigger('click');
						jQuery('.slide_in_paypal_setup select[name="currency_code"]').trigger('change');
						
						jQuery('.slide_in_paypal_setup select[name="paypal_language_selection"] option[value="'+ jQuery('.nex_form_attr .paypal-lc').text() +'"]').attr('selected','selected');
						jQuery('.slide_in_paypal_setup select[name="paypal_language_selection"] option[value="'+ jQuery('.nex_form_attr .paypal-lc').text() +'"]').trigger('click');
						jQuery('.slide_in_paypal_setup select[name="paypal_language_selection"]').trigger('change');
						
						var posible_email_fields = '<option value="">Dont send confirmation mail to user</option>';	
						var has_email_fields = false;
						jQuery('div.nex-forms-container div.form_field input.email').each(
							function()
								{
								has_email_fields = true;
								posible_email_fields += '<option value="'+  jQuery(this).attr('name') +'" '+ ((jQuery('.nex_form_attr .user_email_field').text()==jQuery(this).attr('name')) ? 'selected="selected"' : '') +' >'+ jQuery(this).closest('div.form_field').find('.the_label').text() +'</option>';
								}
							);
						
						jQuery('select[name="posible_email_fields"]').html(posible_email_fields);
						
						if(!has_email_fields)
							jQuery('.no-email').removeClass('hidden');
						else
							jQuery('.no-email').addClass('hidden');
									
						if(jQuery('.nex_form_attr .post_action').text()=='ajax' || jQuery('.nex_form_attr .post_action').text()=='')
							{
							jQuery('#ajax').attr('checked',true);
							jQuery('#ajax').trigger('click');
							}
						if(jQuery('.nex_form_attr .post_action').text()=='custom')
							{
							jQuery('#custom').attr('checked',true);
							jQuery('#custom').trigger('click');
							}
			
		if(jQuery('.nex_form_attr .post_action').text()=='POST' || jQuery('.nex_form_attr .post_action').text()=='')
			{
			jQuery('#post_method').attr('checked',true);
			}
		if(jQuery('.nex_form_attr .post_type').text()=='GET')
			{
			jQuery('#get_method').attr('checked',true);
			}
		
		
		if(jQuery('.nex_form_attr .on_form_submission').text()=='redirect')
			{
			jQuery('#on_form_submission_redirect').attr('checked',true);
			jQuery('#on_form_submission_redirect').trigger('click');
			}
		if(jQuery('.nex_form_attr .on_form_submission').text()=='message' || jQuery('.nex_form_attr .on_form_submission').text()=='')
			{
			jQuery('#on_form_submission_message').attr('checked',true);
			jQuery('#on_form_submission_message').trigger('click');
			}
						
						}
					);	
				
				var data =
				{
				action	 							: 'buid_paypal_products',
				nex_forms_Id						: the_ID
				};
			jQuery.post
					(
					ajaxurl, data, function(response)
						{
						jQuery('div.paypal_products').html(response)
						}
					);
					
					
					}
				);
			}
		);
		
	
	
	jQuery('.template_forms .calendar_title').live('click',
		function()
			{
			jQuery('.template_forms .list-group-item').removeClass('active');
			//jQuery('div.nex-forms-container').html('<h2><i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;Loading Form - "'+ jQuery(this).closest('.list-group-item').find('.calendar_title').text() +'"...</h2>')
			jQuery('div.nex-forms-container').html('<div class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>')
			jQuery(this).closest('.list-group-item').addClass('active');	
			jQuery('.btn').blur();
			jQuery('#the_form_title').popover('hide');
			jQuery('#the_form_title').val(jQuery(this).text())
			jQuery('.form_update_id').text('');
			jQuery('.entry-count').text('0');
			
			var the_ID = jQuery(this).closest('.list-group-item').attr('id');
			
			var data =
				{
				action	 							: 'load_nex_form',
				form_Id								: the_ID
				};		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					if(jQuery('.nex-forms-field-settings').hasClass('open'))
						jQuery('div.nex-forms-field-settings .close').trigger('click');
					jQuery('div.nex-forms-container').html(response)
					jQuery('div.nex-forms-container div#the-radios input').prop('checked',false);
					jQuery('div.nex-forms-container div#the-radios a').attr('class','');
					jQuery('.editing-field').removeClass('editing-field');
					jQuery('.form_field').removeClass('edit-field')
					jQuery('#field_container .col-sm-2').addClass('label_container');
					jQuery('#field_container .col-sm-10').addClass('input_container');
					jQuery('div.nex-forms-container').find('div.trash-can').remove();
					jQuery('.editing-field-container').removeClass('editing-field-container');
					setTimeout(function(){ jQuery('.editing-field').removeClass('editing-field'); },1000)
					setTimeout(function(){ jQuery('.editing-field-container').removeClass('.editing-field-container'); },1000)
					
					jQuery('div.nex-forms-container .field_settings').html('<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div><div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>')
					
				
						
					
					if(!jQuery('link.color_scheme').attr('class'))
						{
						jQuery('.nex-forms-container').prepend('<link href="' + jQuery('#site_url').text() + '/wp-content/plugins/nex-forms-themes-add-on/css/default/jquery.ui.theme.css" title="color_scheme" class="color_scheme" rel="stylesheet" />');
						jQuery('.nex-forms-container').prepend('<div class="active_theme" style="display:none;">default</div>');
						}
					else
						{
						jQuery('.overall-form-settings li.'+jQuery('.active_theme').text()).trigger('click');
						}
					jQuery('div.nex-forms-container .form_field').each(
						function(index)
							{
							jQuery(this).css('z-index',1000-index)
							setup_form_element(jQuery(this))

							if(jQuery(this).hasClass('text') || jQuery(this).hasClass('textarea'))
								{
								if(jQuery(this).find('.the_input_element').attr('data-maxlength-show')=='true')
									jQuery(this).find('.the_input_element').maxlength({ placement:(jQuery(this).find('.the_input_element').attr('data-maxlength-position')) ? jQuery(this).find('.the_input_element').attr('data-maxlength-position') : 'bottom', alwaysShow: true , set_ID: jQuery(this).attr('id'), warningClass: 'label '+ jQuery(this).find('.the_input_element').attr('data-maxlength-color') });
								}
							if(jQuery(this).hasClass('grid-system'))
								{
								jQuery(this).find('.input-inner').first().append('<div class="field_settings bs-callout bs-callout-info" style="display:none;"><div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div></div>');
								}
							}
						);
					jQuery('.radio-group a, .check-group a').addClass('ui-state-default')
					jQuery('.grid-system .panel-body').removeClass('ui-widget-content');
					jQuery('.bootstrap-select.ui-state-default').removeClass('ui-state-default');
					jQuery('.bootstrap-select').removeClass('form-control').addClass('full_width');
					jQuery('.selectpicker, .dropdown-menu.the_input_element').addClass('ui-state-default')
					jQuery('.grid-system .panel-body').removeClass('ui-widget-content');
					jQuery('.bootstrap-select.ui-state-default').removeClass('ui-state-default');
					
					
					jQuery('.panel-heading .btn').trigger('click');

					}
				);
			}
		);
	
	
		
	//PREVIEW FORM	
	function change_device(obj){
		jQuery('.preview-modal').attr('class','modal-dialog preview-modal');
		if(obj.hasClass('full'))
			jQuery('.preview-modal').css('width','100%').addClass('full-preview');
		if(obj.hasClass('desktop'))
			jQuery('.preview-modal').animate({width:1199},300).addClass('desktop-preview');
		if(obj.hasClass('laptop'))
			jQuery('.preview-modal').animate({width:991},300).addClass('laptop-preview');
		if(obj.hasClass('tablet'))
			jQuery('.preview-modal').animate({width:767},300).addClass('tablet-preview');
		if(obj.hasClass('mobile'))
			jQuery('.preview-modal').animate({width:320},300).addClass('mobile-preview');
	}
	jQuery('.change_device').live('click',
		function()
			{
			jQuery('.change_device').removeClass('active');
			jQuery(this).addClass('active');
			change_device(jQuery(this));
			}
		);
	
	
	jQuery('.slide_in_on_submit #ajax').click(
	function()
		{
		jQuery('.row.ajax_posting').removeClass('hidden')
		jQuery('.row.custom_posting').addClass('hidden')
		}
	);
	jQuery('.slide_in_on_submit #custom').click(
	function()
		{
		jQuery('.row.ajax_posting').addClass('hidden')
		jQuery('.row.custom_posting').removeClass('hidden')
		}
	);
	
	jQuery('#on_form_submission_redirect').click(
		function()
			{
			jQuery('.confirmation_message').addClass('hidden')
			jQuery('.redirect_to_url').removeClass('hidden')
			}
	);
	jQuery('#on_form_submission_message').click(
		function()
			{
			jQuery('.confirmation_message').removeClass('hidden')
			jQuery('.redirect_to_url').addClass('hidden')	
			}
	);
	
	jQuery('.preview_form').live('click',
		function()
			{
			change_device(jQuery(this));
			create_form();	
			run_conditions();						
			}
		);
	
	
	
	jQuery('a.export_csv, button.export_csv').live('click',
		function()
			{
			document.export_csv.submit();
			}
		);
	
	jQuery('.form_canvas').click(
		function()
			{
			if(jQuery('.nex-forms-field-settings').hasClass('open'))
				jQuery('div.nex-forms-field-settings .close').trigger('click');
			jQuery('div#collapseFormsCanvas .panel-body.panel_view').hide();
			jQuery('div.nex-forms-container, .overall-form-settings').show();
			}
		);
	jQuery('.on_submit').click(
		function()
			{
			if(jQuery('.nex-forms-field-settings').hasClass('open'))
				jQuery('div.nex-forms-field-settings .close').trigger('click');
			jQuery('div#collapseFormsCanvas .panel-body.panel_view, .overall-form-settings').hide();
			jQuery('div#onSubmit').show();
			}
		);
		
	jQuery('.form_entries').click(
		function()
			{
			if(jQuery('.nex-forms-field-settings').hasClass('open'))
				jQuery('div.nex-forms-field-settings .close').trigger('click');
			jQuery('div#collapseFormsCanvas .panel-body.panel_view, .overall-form-settings').hide();
			jQuery('div#formEntries').show();
			
			
			
			
			}
		);
		
	jQuery('#nex_autoresponder_user_email_field').change(
		function()
			{
			jQuery('.nex_form_attr .user_email_field').text(jQuery(this).val())
			}
		);
	
	
	
	
	jQuery('a.autoRespond').live('click',
		function()
			{
			var set_current_fields = '';
			
			if(jQuery('.nex-forms-field-settings').hasClass('open'))
				jQuery('div.nex-forms-field-settings .close').trigger('click');
			
			jQuery('div#collapseFormsCanvas .panel-body.panel_view, .overall-form-settings').hide();
			jQuery('div#autoRespond').show();
				
			jQuery('div.nex-forms-container div.form_field .the_label').each(
				function()
					{
					set_current_fields += '<option value="{{'+ format_illegal_chars(jQuery(this).text())  +'}}">'+ jQuery(this).text() +'</option>';
					}
				);
			var posible_email_fields = '<option value="">Dont send confirmation mail to user</option>';	
			var has_email_fields = false;
			jQuery('div.nex-forms-container div.form_field input.email').each(
				function()
					{
					has_email_fields = true;
					posible_email_fields += '<option value="'+  jQuery(this).attr('name') +'" '+ ((jQuery('.nex_form_attr .user_email_field').text()==jQuery(this).attr('name')) ? 'selected="selected"' : '') +' >'+ jQuery(this).closest('div.form_field').find('.the_label').text() +'</option>';
					}
				);
			if(!has_email_fields)
				jQuery('.no-email').removeClass('hidden');
			else
				jQuery('.no-email').addClass('hidden');
				
			jQuery('select[name="posible_email_fields"]').html(posible_email_fields);
			jQuery('select[name="current_fields"]').html(set_current_fields);
			
					/*	jQuery('input#nex_autoresponder_recipients').val(jQuery('.nex_form_attr .mail_to').text());
						jQuery('input#nex_autoresponder_from_address').val(jQuery('.nex_form_attr .from_address').text());
						jQuery('input#nex_autoresponder_from_name').val(jQuery('.nex_form_attr .from_name').text());
						jQuery('#nex_autoresponder_on_screen_confirmation_message').val(jQuery('.nex_form_attr .on_screen_confirmation_message').text());
						jQuery('#nex_autoresponder_confirmation_page').val(jQuery('.nex_form_attr .confirmation_page').text());
						jQuery('input#nex_autoresponder_confirmation_mail_subject').val(jQuery('.nex_form_attr .confirmation_mail_subject').text());
						jQuery('#nex_autoresponder_confirmation_mail_body').val(jQuery('.nex_form_attr .confirmation_mail_body').html());*/
						
						
						
						
						
						
			}
		);
		
		jQuery('a.animation').live('click',
		function()
			{
		jQuery('.animate_form button').removeClass('btn-primary');
					if(jQuery('div.run_animation').text()=='true' || jQuery('div.run_animation').text()=='truetrue' || jQuery('div.run_animation').text()=='falsetrue')
						jQuery('.animate_form button.yes').addClass('btn-primary');
					else
						jQuery('.animate_form button.no').addClass('btn-primary');
						
					jQuery('.animate_time button').removeClass('btn-primary');
					if(jQuery('div.animation_time').text()=="30" || jQuery('div.animation_time').text()=="3030")
						jQuery('.30_frames').addClass('btn-primary');
					if(jQuery('div.animation_time').text()=="60" || jQuery('div.animation_time').text()=="6060")
						jQuery('.60_frames').addClass('btn-primary');
					if(jQuery('div.animation_time').text()=="90" || jQuery('div.animation_time').text()=="9090")
						jQuery('.90_frames').addClass('btn-primary');
					if(jQuery('div.animation_time').text()=="120" || jQuery('div.animation_time').text()=="120120")
						jQuery('.120_frames').addClass('btn-primary');
					if(jQuery('div.animation_time').text()=="180" || jQuery('div.animation_time').text()=="180180")
						jQuery('.180_frames').addClass('btn-primary');
			}
		);
		
		
	}
);
function delete_form_entry(last_update,Id){
	
	var get_color = jQuery('tr#tag-'+Id).css('background-color');
	jQuery('tr#tag-'+Id).css('background-color','#FFEBE8');
	if(confirm('Are your sure you want to permanently delete this record?'))
		{
		jQuery('tr#tag-'+Id).fadeOut('slow', function()
			{
			jQuery('tr#tag-'+Id).remove();	
			}
		);
		
		var data = 	
			{
			action	 	: 'delete_form_entry',
			last_update	: last_update
			};

		jQuery.post
			(
			ajaxurl, data, function(response)
				{ 
				core_object.trigger("update_form_entry"); 
				}
			);
		}
	else
		{
		jQuery('tr#tag-'+Id).css('background-color',get_color);
		}
}