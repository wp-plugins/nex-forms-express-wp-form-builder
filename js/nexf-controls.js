jQuery(document).ready(
function()
	{
	load_nex_event_calendars('');
	
	jQuery('.get-add-on').popover({html:true});
	
/*************************************************************************************/
/******************************** SAVE FORM ******************************************/
/*************************************************************************************/
	jQuery('#save_nex_form').live('click',
		function()
			{
			jQuery('.btn').blur();
			jQuery('.bootstrap-select').remove();
			var clicked = jQuery(this);
			var current_button = jQuery(this).html()
			
			jQuery('div.nex-forms-container #slider').html('');
			jQuery('div.nex-forms-container #star' ).raty('destroy');
			jQuery('div.nex-forms-container .bootstrap-touchspin-prefix').remove();
			jQuery('div.nex-forms-container .bootstrap-touchspin-postfix').remove();
			jQuery('div.nex-forms-container .bootstrap-touchspin .input-group-btn').remove();
			jQuery('div.nex-forms-container .bootstrap-tagsinput').remove();
			jQuery('div.nex-forms-container .popover').remove();
			var hidden_fields = '';
			
			jQuery('.hidden_fields .hidden_field').each(
				function()
					{
					hidden_fields += jQuery(this).find('input.field_name').val();
					hidden_fields += '[split]';
					hidden_fields += jQuery(this).find('input.field_vlaue').val();
					hidden_fields += '[end]';
					}
				);
			clicked.html('<span class="fa fa-refresh fa-spin"></span>&nbsp;&nbsp;Saving...')
			var data =
				{
				action	 							: (jQuery('.form_update_id').text()) ? 'edit_form' : 'insert_nex_form' ,
				table								: 'wap_nex_forms',
				edit_Id								: jQuery('.form_update_id').text(),
				plugin								: 'shared',
				title								: jQuery('#the_form_title').val(),
				form_fields							: jQuery('div.nex-forms-container').html(),
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
				hidden_fields						: hidden_fields
				};
				
			if(jQuery(this).hasClass('template_only'))
				{
				data.is_form = '0';
				data.is_template = '1';
				}
			if(jQuery(this).hasClass('form_and_template'))
				data.is_template = '1';
							
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					if(jQuery('.form_update_id').text())
						{
						var reload_data =
							{
							action	 							: 'load_nex_form',
							form_Id								: jQuery('.form_update_id').text()
							};		
						jQuery.post
							(
							ajaxurl, reload_data, function(response)
								{
								clicked.html(current_button);
								jQuery('div.nex-forms-container').html(response)
								jQuery('div.nex-forms-container .form_field').each(
									function(index)
										{
										jQuery(this).css('z-index',1000-index)
										setup_form_element(jQuery(this))
										}
									);
								}
							);
							
						}
					else
						clicked.html(current_button);
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
				jQuery('div.saved_calendars').html(response);
				jQuery('.saved_calendars button').tooltip();
				if(the_id)
					{
					var cal_item = jQuery('.saved_calendars a#'+ the_id);
							
					cal_item.addClass('edited');
					setTimeout(function(){cal_item.removeClass('edited')},2000)
					}
				if(jQuery('.form_update_id').text())
					jQuery('.saved_calendars a#'+jQuery('.form_update_id').text()).addClass('active');
				}
			);
		}


/*************************************************************************************/
/******************************* DELETE FORMS ****************************************/
/*************************************************************************************/
jQuery('.delete_the_calendar').live('click',
		function()
			{
			jQuery('#deleteCalendar').find('.do_delete').attr('data-id',jQuery(this).attr('id'));
			jQuery('#deleteCalendar').find('.do_delete').attr('data-table','wap_nex_forms')
			jQuery('#deleteCalendar').find('span.get_calendar_title').text(jQuery(this).parent().find('.the_form_title').text())
			}
		);
jQuery('.do_delete').live('click',
		function()
			{
			if(jQuery('.do_delete').attr('data-id') == jQuery('.form_update_id').text())
				{
				jQuery('div.nex-forms-container').html('');
				jQuery('#welcomeMessage .close').hide();
				}
			jQuery('.saved_calendars #'+jQuery('.do_delete').attr('data-id')).css('background','#d9534f')
			jQuery('.saved_calendars #'+jQuery('.do_delete').attr('data-id')).fadeOut();
			
			var data =
				{
				action	 						: 'delete_record',
				table							: jQuery(this).attr('data-table'),
				Id								: jQuery(this).attr('data-id')
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
			
			if(jQuery('.do_edit').attr('data-id') == jQuery('.form_update_id').text())  
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
					load_nex_event_calendars(jQuery('#editCalendar .do_edit').attr('data-id'));
					}
				);
			}
		);
jQuery('a.visible_form_title').click(
	function()
		{
		jQuery('.saved_calendars .list-group-item.active .edit_the_calendar').trigger('click');	
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
			jQuery('.saved_calendars').html('<span class="fa fa-refresh fa-spin"></span>&nbsp;&nbsp;Loading Forms...')		
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
jQuery('.use_calendar').live('click',
		function()
			{
			jQuery('#useCalendar').find('.sc_normal').text('[NEXForms id="'+ jQuery(this).attr('id') +'"]');
			jQuery('#useCalendar').find('.sc_popup_button').text('[NEXForms id="'+ jQuery(this).attr('id') +'" open_trigger="popup" type="button" text="Open Form"]');
			jQuery('#useCalendar').find('.sc_popup_link').text('[NEXForms id="'+ jQuery(this).attr('id') +'" open_trigger="popup" type="link" text="Open Form"]');
			
			jQuery('#useCalendar').find('.php_normal').html('&lt;?php NEXForms_ui_output(array("id"=>'+ jQuery(this).attr('id') +'),true); ?&gt;');
			jQuery('#useCalendar').find('.php_popup_button').html('&lt;?php NEXForms_ui_output(array("id"=>'+ jQuery(this).attr('id') +',"open_trigger"=>"popup", "type"=>"button", "text"=>"Open Form"),true); ?&gt;');
			jQuery('#useCalendar').find('.php_popup_link').html('&lt;?php NEXForms_ui_output(array("id"=>'+ jQuery(this).attr('id') +',"open_trigger"=>"popup", "type"=>"link", "text"=>"Open Form"),true); ?&gt;');
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
			jQuery('.saved_calendars').html('<span class="fa fa-refresh fa-spin"></span>&nbsp;&nbsp;Loading Forms...')
			
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
				confirmation_mail_body				: 'Thank you for connecting with us, we will respond to you shortly'
				};		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					jQuery('#welcomeMessage input[name="new_calendar_title"]').val('')
					jQuery('#welcomeMessage input[name="new_calendar_description"]').val('');
					load_nex_event_calendars(response);
					
					clicked.html(current_button);
					
					jQuery('.saved_calendars').animate(
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
	jQuery('.open_calendar').live('click',
		function()
			{
			jQuery('.saved_calendars .list-group-item').removeClass('active');
			jQuery('div.nex-forms-container').html('<h2><i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;Loading Form - "'+ jQuery(this).closest('.list-group-item').find('.calendar_title').text() +'"...</h2>')
			jQuery(this).closest('.list-group-item').addClass('active');			
			jQuery('#welcomeMessage .close').show();
			jQuery('.btn').blur();
			jQuery('#the_form_title').popover('hide');
			jQuery('#the_form_title').val(jQuery(this).find('.the_form_title').text())
			
			var the_ID = jQuery('.list-group-item.active').attr('id');
			
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
					if(jQuery('.nex-forms-field-settings').hasClass('open'))
						jQuery('div.nex-forms-field-settings .close').trigger('click');
					jQuery('div.nex-forms-container').html(response)
					jQuery('div.nex-forms-container div#the-radios input').prop('checked',false);
					jQuery('div.nex-forms-container div#the-radios a').attr('class','');
					jQuery('.editing-field').removeClass('editing-field');
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
					
					jQuery('.field_settings').before('<div title="Edit Field Attributes" class="btn btn-default btn-lg move_field" style="display:none;"><i class="fa fa-arrows"></i></div>')
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
									
						
						if(jQuery('.nex_form_attr .post_action').text()=='ajax')
							{
							jQuery('#ajax').attr('checked',true);
							jQuery('#ajax').trigger('click');
							}
						if(jQuery('.nex_form_attr .post_action').text()=='custom')
							{
							jQuery('#custom').attr('checked',true);
							jQuery('#custom').trigger('click');
							}
							
						if(jQuery('.nex_form_attr .post_action').text()=='POST')
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
						if(jQuery('.nex_form_attr .on_form_submission').text()=='message')
							{
							jQuery('#on_form_submission_message').attr('checked',true);
							jQuery('#on_form_submission_message').trigger('click');
							}
						}
					);	
					
					
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
			change_device(jQuery(this));
			}
		);
	
	
	jQuery('#onSubmit #ajax').click(
	function()
		{
		jQuery('.row.ajax_posting').removeClass('hidden')
		jQuery('.row.custom_posting').addClass('hidden')
		}
	);
	jQuery('#onSubmit #custom').click(
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