jQuery(document).ready(
function()
	{
	
	jQuery('.tutorial').live('click',
		function(){
			
			bootstro.start();
		}
	);

jQuery('.get-add-on').popover({html:true});

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
				mail_to								: jQuery('#nex_autoresponder_recipients').val(),
				from_address						: jQuery('#nex_autoresponder_from_address').val(),
				from_name							: jQuery('#nex_autoresponder_from_name').val(),
				on_screen_confirmation_message		: jQuery('#nex_autoresponder_on_screen_confirmation_message').val(),
				confirmation_page					: jQuery('#nex_autoresponder_confirmation_page').val(),
				user_email_field					: jQuery('#nex_autoresponder_user_email_field').val(),
				confirmation_mail_subject			: jQuery('#nex_autoresponder_confirmation_mail_subject').val(),
				confirmation_mail_body				: jQuery('#nex_autoresponder_confirmation_mail_body').val(),
				on_form_submission					: jQuery('input[name="on_form_submission"]:checked').val()
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
					
					//load_nex_form_items();
					//load_nex_form_templates();
					
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
								jQuery('.the_input_element, .bootstrap-tagsinput, .radio-group a, .check-group a').addClass('ui-state-default')
								jQuery('.form_field .input-group-addon, .bootstrap-touchspin .btn').addClass('ui-state-active');
								jQuery('p.the_input_element').removeClass('ui-state-default');
								jQuery('.form_field.other-elements .panel-body').addClass('ui-widget-content');
								jQuery('.form_field.grid-system .panel-body').removeClass('ui-widget-content');
								}
							);
						}
					else
						clicked.html(current_button);
					
					}
				);
			}
		);
	

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

	load_nex_event_calendars('');
	

//DELETE FORM
jQuery('.delete_the_calendar').live('click',
		function()
			{
			jQuery('#deleteCalendar').find('.do_delete').attr('data-id',jQuery(this).attr('id'));
			jQuery('#deleteCalendar').find('.do_delete').attr('data-table','wap_nex_forms')
			jQuery('#deleteCalendar').find('span.get_calendar_title').text(jQuery(this).parent().find('.the_form_title').text())
			}
		);
		
jQuery('.calendar_settings').live('click',
		function()
			{
			jQuery('#calendarSettings').find('.save_settings').attr('data-id',jQuery(this).attr('id'));
			jQuery('#calendarSettings').find('.save_settings').attr('data-table','wap_nex_forms');
			
			var data =
				{
				action	 						: 'get_lang_settings',
				table							: 'wap_nex_forms',
				Id								: jQuery(this).attr('id')
				};		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					jQuery('#calendarSettings .settings').html(response);
					}
				);
			
			}
		);
		
jQuery('#calendarSettings .save_settings').live('click',
		function()
			{
			var set_month_lang = '';
			var set_month_lang_abbr = '';
			jQuery('#calendarSettings .set_month').each(
				function()
					{
					set_month_lang += jQuery(this).val() + ',';
					}
				);
			jQuery('#calendarSettings .set_month_abbr').each(
				function()
					{
					set_month_lang_abbr += jQuery(this).val() + ',';
					}
				);
				
			var set_week_lang = '';
			var set_week_lang_abbr = '';
			jQuery('#calendarSettings .set_week').each(
				function()
					{
					set_week_lang += jQuery(this).val() + ',';
					}
				);
			jQuery('#calendarSettings .set_week_abbr').each(
				function()
					{
					set_week_lang_abbr += jQuery(this).val() + ',';
					}
				);
			
			var data =
				{
				action	 						: 'do_edit',
				table							: jQuery(this).attr('data-table'),
				edit_Id							: jQuery(this).attr('data-id'),
				month_lang						: set_month_lang,
				month_abr_lang					: set_month_lang_abbr,
				week_lang						: set_week_lang,
				week_abr_lang					: set_week_lang_abbr,
				use_month_abbr					: jQuery('#calendarSettings input[name="use_month_abbr"]:checked').val(),
				use_day_abbr					: jQuery('#calendarSettings input[name="use_day_abbr"]:checked').val(),
				week_start						: jQuery('#calendarSettings input[name="week_start"]:checked').val(),
				use_theme						: jQuery('#calendarSettings input[name="use_theme"]:checked').val()
				};		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{					
					}
				);
			
			}
		);
		
jQuery('.edit_the_calendar').live('click',
		function()
			{
			jQuery('#editCalendar').find('.do_edit').attr('data-id',jQuery(this).attr('id'));
			jQuery('#editCalendar').find('.do_edit').attr('data-table','wap_nex_forms')
			jQuery('#editCalendar').find('input[name="new_calendar_title"]').val(jQuery(this).closest('.list-group-item').find('.calendar_title').text());
			jQuery('#editCalendar').find('input[name="new_calendar_description"]').val(jQuery(this).closest('.list-group-item').find('.calendar_description').text());
			}
		);
		
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
					//jQuery('#new_form .blank').trigger('click');
					//load_nex_form_items();
					//load_nex_event_calendars('');
					}
				);
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
				action	 						: 'do_insert',
				table							: 'wap_nex_forms',
				title							: jQuery('#welcomeMessage input[name="new_calendar_title"]').val(),
				description						: jQuery('#welcomeMessage input[name="new_calendar_description"]').val(),
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
					//jQuery('.current_calendar_Id').text(response);
					
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
		
	jQuery('.open_calendar').live('click',
		function()
			{
			jQuery('#welcomeMessage .close').show();
			jQuery('.btn').blur();
			jQuery('#the_form_title').popover('hide');
			jQuery('#the_form_title').val(jQuery(this).find('.the_form_title').text())	
			jQuery('.form_update_id').text(jQuery(this).attr('id'))
			jQuery('a.visible_form_title').html('<span class="fa fa-file"></span>&nbsp;&nbsp;'+jQuery(this).closest('.list-group-item').find('.calendar_title').text());
			var data =
				{
				action	 							: 'load_nex_form_attr',
				form_Id								: jQuery(this).attr('id')
				};		
				jQuery.post
					(
					ajaxurl, data, function(response)
						{
						
						jQuery('.nex_form_attr').html(response);
						jQuery('input#nex_autoresponder_recipients').val(jQuery('.nex_form_attr .mail_to').text());
						jQuery('input#nex_autoresponder_from_adress').val(jQuery('.nex_form_attr .from_address').text());
						jQuery('input#nex_autoresponder_from_name').val(jQuery('.nex_form_attr .from_name').text());
						jQuery('#nex_autoresponder_on_screen_confirmation_message').val(jQuery('.nex_form_attr .on_screen_confirmation_message').text());
						jQuery('#nex_autoresponder_confirmation_page').val(jQuery('.nex_form_attr .confirmation_page').text());
						jQuery('input#nex_autoresponder_confirmation_mail_subject').val(jQuery('.nex_form_attr .confirmation_mail_subject').text());
						jQuery('#nex_autoresponder_confirmation_mail_body').val(jQuery('.nex_form_attr .confirmation_mail_body').html());
						
						
						
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
			var data =
				{
				action		: 'build_form_data_table',
				form_Id		: jQuery('.form_update_id').text()
				};		
				jQuery('div.nex-forms-entries').html('<i class="fa fa-refresh fa-spin"></i>Loading form entries...');
				jQuery.post
					(
					ajaxurl, data, function(response)
						{
						jQuery('.nex-forms-entries').html(response);
						jQuery('.entry-count').text(jQuery('span.displaying-num strong').html());
						
						}
					);	
			
			jQuery('.saved_calendars .list-group-item').removeClass('active');
			
			jQuery('div.nex-forms-container').html('<h2><i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;Loading Form - "'+ jQuery(this).closest('.list-group-item').find('.calendar_title').text() +'"...</h2>')
			jQuery(this).closest('.list-group-item').addClass('active');
			var data =
				{
				action	 							: 'load_nex_form',
				form_Id								: jQuery(this).closest('.list-group-item').attr('id')
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
					jQuery('select[name="current_fields"]').html(set_current_fields);		
					
					if(!jQuery('link.color_scheme').attr('class'))
						{
						jQuery('.nex-forms-container').prepend('<link href="' + jQuery('#site_url').text() + '/wp-content/plugins/nex-forms-themes-add-on/css/default/jquery.ui.theme.css" title="color_scheme" class="color_scheme" rel="stylesheet">');
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
					jQuery('.the_input_element, .bootstrap-tagsinput, .radio-group a, .check-group a').addClass('ui-state-default')
					jQuery('.form_field .input-group-addon, .bootstrap-touchspin .btn, .form_field .panel-heading').addClass('ui-state-active');
					jQuery('.form_field.other-elements .panel-body').addClass('ui-widget-content');
					jQuery('p.the_input_element, .heading .the_input_element').removeClass('ui-state-default');
					jQuery('.form_field.grid-system .panel-body').removeClass('ui-widget-content');
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
	
	
	jQuery('#on_form_submission_redirect').click(
	function()
		{
		jQuery('.row.confirmation_message').addClass('hidden')
		jQuery('.row.redirect_to_url').removeClass('hidden')	
		
		}
	);
	jQuery('#on_form_submission_message').click(
	function()

		{
		jQuery('.row.confirmation_message').removeClass('hidden')
		jQuery('.row.redirect_to_url').addClass('hidden')	
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