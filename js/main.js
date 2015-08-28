var current_image_selection = '';
jQuery(document).ready(
function()
		{
		jQuery('.bootstrap-select li').live('click',
			function()
				{
				jQuery(this).closest('.form_field').find('select').trigger('change');
				}
		)
jQuery('.the-radios a').live('click',
			function()
				{
				jQuery(this).parent().find('input').trigger('change');
				}
		)
		//jQuery('.show_welcome_message').trigger('click');
		//jQuery('#welcomeMessage').modal().appendTo('body');
		jQuery('#set_custom_css').keyup(
			function()
				{
				jQuery('style.custom_css').html(jQuery(this).val())
				}
			);
		
		//loading_nex_forms();
		jQuery('select[name="fonts"]').html(jQuery('select.sfm.sample').html());
		jQuery('select[name="fonts"]').stylesFontDropdown();
		//Input
		/*jQuery('select[name="label-fonts"]').html(jQuery('select.sfm.sample').html());
		jQuery('select[name="label-fonts"]').stylesFontDropdown();
		//Help text
		jQuery('select[name="help-text-fonts"]').html(jQuery('select.sfm.sample').html());
		jQuery('select[name="help-text-fonts"]').stylesFontDropdown();
		//Panel heading
		jQuery('select[name="panel-fonts"]').html(jQuery('select.sfm.sample').html());
		jQuery('select[name="panel-fonts"]').stylesFontDropdown();
		*/
		
		jQuery('li a.math_logic').click(
		function()
			{
			var set_current_fields_math_logic = '';
						set_current_fields_math_logic += '<optgroup label="Text Fields">';
						jQuery('div.nex-forms-container div.form_field input[type="text"]').each(
							function()
								{
								set_current_fields_math_logic += '<option value="{'+ format_illegal_chars(jQuery(this).attr('name'))  +'}">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						set_current_fields_math_logic += '<optgroup label="Radio Buttons">';
						jQuery('div.nex-forms-container div.form_field input[type="radio"]').each(
							function()
								{
								set_current_fields_math_logic += '<option value="{'+ format_illegal_chars(jQuery(this).attr('name'))  +'}">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						
						set_current_fields_math_logic += '<optgroup label="Check Boxes">';
						jQuery('div.nex-forms-container div.form_field input[type="checkbox"]').each(
							function()
								{
								set_current_fields_math_logic += '<option value="{'+ jQuery(this).attr('name')  +'}">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						set_current_fields_math_logic += '<optgroup label="Selects">';
						jQuery('div.nex-forms-container div.form_field select').each(
							function()
								{
								set_current_fields_math_logic += '<option value="{'+ jQuery(this).attr('name')  +'}">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
						set_current_fields_math_logic += '<optgroup label="Text Areas">';
						jQuery('div.nex-forms-container div.form_field textarea').each(
							function()
								{
								set_current_fields_math_logic += '<option value="{'+ format_illegal_chars(jQuery(this).attr('name'))  +'}">'+ jQuery(this).attr('name') +'</option>';
								}
							);	
						set_current_fields_math_logic += '</optgroup>';
						
					jQuery('#nex-forms-field-settings select[name="current_fields"]').html(set_current_fields_math_logic);
			}
		);
		}
	); 
(function($)
	{
	$(document).ready
		(
		function()
			{ 	
			
			
			$('.add_hidden_field').click(
				function()
					{
					var hf_clone = $('.hidden_field_clone').clone();
					hf_clone.removeClass('hidden').removeClass('hidden_field_clone').addClass('hidden_field');
					
					$('.hidden_fields').prepend(hf_clone);
					
					}
				);
				
			$('.remove_hidden_field').live('click',
				function()
					{
					$(this).closest('.hidden_field').remove();
					}
				);
			
			$('.nex-forms-container .single-image-select-group .radio-label, .nex-forms-container .multi-image-select-group .radio-label').live('click',
				function()
					{
					current_image_selection = $(this);
					$('#do_upload_image_selection .fileinput input').trigger('click');
					}
				);
			
			
			$('#do_upload_image_selection .fileinput input').change(
						function()
							{	
							jQuery('#do_upload_image_selection').submit();
							console.log(jQuery(this).val());	
							}
					)
			
			jQuery('#do_upload_image_selection').ajaxForm({
				data: {
				   action: 'do_upload_image_select',
				   mimeType: "multipart/form-data"
				},
				//dataType: 'json',
				beforeSubmit: function(formData, jqForm, options) {
					//alert('test');
					//console.log($('input[name="do_image_upload_preview"]').val())
				},
			   success : function(responseText, statusText, xhr, $form) {
				 //current_image_selection.css('background','url("'+ responseText +'")');
				 current_image_selection.find('img').remove();
				 current_image_selection.append('<img src="'+ responseText +'" class="radio-image">')
				},
				 error: function(jqXHR, textStatus, errorThrown)
					{
					   console.log(errorThrown)
					}
			});
			
			
			
		
			
			$('#previewForm').on('hidden.bs.modal', 
				function ()
					{
			  		$('.modal-body.ui-nex-forms-container form').html('').show();
					$('.ui-nex-forms-container .nex_success_message').hide();
					});
			$('div.nex-forms-container .form_field').live('mouseover',
			function()
				{
				if(!jQuery('div.nex-forms-container').hasClass('selecting_conditional_target') && !jQuery(this).hasClass('step') && !jQuery(this).hasClass('grid'))
					{
					//$(this).find('.field_settings').first().show();
					
					//$(this).prevAll('div').find('.move_field').hide();
					
					//$(this).find('.btn-lg.move_field').first().show();
					}
				})
			
			$('div.nex-forms-container .form_field.grid').live('mouseover',
			function()
				{
				if(!$(this).hasClass('step'))
				$(this).find('.field_settings').last().show();
				//$(this).find('.btn-lg.move_field').last().show();
				}
			);
			$('div.nex-forms-container .form_field').live('mouseout',
				function()
					{
					$(this).find('.field_settings').hide();
					//$(this).find('.btn-lg.move_field').hide();
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
			var promotext = '';
			promotext1 = promotext.split('ref=');
			$('#envato_username').val(promotext1[1])
			$('#envato_username').keyup(
				function()
					{
					$('.submit-button small a').attr('href','http://codecanyon.net/user/Basix/portfolio?ref=' + $(this).val());
					}
				);
		var current_id = '';
		var current_formcontainer_width = '';

		jQuery('div.nex-forms-container label .the_label, div.nex-forms-container div.form_field.submit-button, div.nex-forms-container  label small, .field_settings .edit').live('click',function(){ if(!jQuery('div.nex-forms-container').hasClass('selecting_conditional_target')) { jQuery('a.the-label').trigger('click').tab('show'); } });
		jQuery('div.nex-forms-container div.input-inner .the_input_element, div.nex-forms-container #the-radios a, div.nex-forms-container .ui-slider-handle, div.nex-forms-container .bootstrap-tagsinput').live('click',function(){  if(!jQuery('div.nex-forms-container').hasClass('selecting_conditional_target')) {jQuery('#filters li:eq(1) a').trigger('click').tab('show'); $(this).popover('hide'); setTimeout(function(){ jQuery('#filters li:eq(1) a').trigger('click'); },200) } });
		jQuery('div.nex-forms-container div.input-inner .help-block, div.nex-forms-container div.input-inner label .the_label .bs-tooltip').live('click',function(){  if(!jQuery('div.nex-forms-container').hasClass('selecting_conditional_target')) { jQuery('#filters li:eq(2) a').trigger('click').tab('show');} });
		jQuery('.field_settings .logic').live('click',function(){  if(!jQuery('div.nex-forms-container').hasClass('selecting_conditional_target')) { jQuery('#filters li:eq(4) a').trigger('click').tab('show');} });
		jQuery('.field_settings .edit').live('click',function(){  if(!jQuery('div.nex-forms-container').hasClass('selecting_conditional_target')) { jQuery('#filters li:eq(0) a').trigger('click').tab('show'); setTimeout(function(){jQuery('a.the-label').trigger('click').tab('show'); },100) } });
		jQuery('.field_settings .set-validation').live('click',function(){  if(!jQuery('div.nex-forms-container').hasClass('selecting_conditional_target')) { jQuery('#filters li:eq(3) a').trigger('click').tab('show');} });
		
	jQuery('div.nex-forms-container div.form_object div.edit,  div.nex-forms-container div.form_field.submit-button, div.nex-forms-container input, div.nex-forms-container label#nexf_title, div.nex-forms-container label#title,div.nex-forms-container .ui-slider-handle,div.nex-forms-container .bootstrap-tagsinput, div.nex-forms-container #the-radios a, div.nex-forms-container .grid .panel-heading, div.nex-forms-container div.input-inner .the_input_element, div.nex-forms-container div.input-inner .help-block').live('click',
		function(e)
			{
			
			$('div.slide_in_right').removeClass('opened')
			setTimeout(function(){ $('div#nex-forms-field-settings').addClass('opened'); },300)
			e.preventDefault();
			
			$('.form_field').removeClass('edit-field')
			
			$(this).closest('.form_field').addClass('edit-field')	
			
			
			
			if(!current_formcontainer_width)
				current_formcontainer_width = jQuery('div#collapseFormsCanvas').outerWidth();
				
			if(!jQuery('div.nex-forms-container').hasClass('selecting_conditional_target'))
				{
				jQuery('div#nex-forms-field-settings .current_id').text($(this).closest('.form_field').attr('id'));
				current_id = $('div#nex-forms-field-settings .current_id').text();
				}
				
			$('.option-set li a').hide();
			if(jQuery('#'+current_id).hasClass('submit-button'))
				{
				$('.option-set li a.input-element').show().trigger('click');
				setTimeout(function(){$('.option-set li a.input-element').trigger('click'); },100);
				}
			else if(jQuery('#'+current_id).hasClass('grid'))
				{
				$('.option-set li a.input-element').show().trigger('click');
				setTimeout(function(){$('.option-set li a.input-element').trigger('click'); },100);
				}
			else if(jQuery('#'+current_id).hasClass('heading') || jQuery('#'+current_id).hasClass('paragraph'))
				{
				$('.option-set li a.input-element').show().trigger('click');
				setTimeout(function(){$('.option-set li a.input-element').trigger('click'); },100);
				}
			else if(jQuery('#'+current_id).hasClass('divider'))
				{
				$('.option-set li a.input-element').show().trigger('click');
				 setTimeout(function(){$('.option-set li a.input-element').trigger('click'); },100);
				}
			else
				$('.option-set li a').show();

			if(jQuery('#'+current_id).hasClass('multi-select')
				|| jQuery('#'+current_id).hasClass('check-group')
				|| jQuery('#'+current_id).hasClass('submit-button')
				|| jQuery('#'+current_id).hasClass('tags')
				|| jQuery('#'+current_id).hasClass('upload-single')
				|| jQuery('#'+current_id).hasClass('upload-image')
				)
				$('.option-set li a.logic').hide();
			
			if(jQuery('#'+current_id).hasClass('paragraph')
				|| jQuery('#'+current_id).hasClass('heading')
				)
				$('.option-set li a.math_logic').show();
			else
				$('.option-set li a.math_logic').hide();
			
			if(jQuery('#'+current_id).hasClass('md-field'))
				$('.help-text').parent().hide();
				
			//if(!$('div#nex-forms-field-settings').hasClass('opened'))
				//{
				
				//}
			
				
			var current_obj = jQuery(this);
			
			
			
			if(!jQuery('div.nex-forms-container').hasClass('selecting_conditional_target')){
			setTimeout(
			function()
				{
				if(!jQuery('#'+current_id).hasClass('grid'))
					{
					populate_logic(current_id);
					populate_label_settings(jQuery('#'+current_id).find('label'));
					
					populate_label_width_settings(jQuery('#'+current_id));
					populate_input_width_settings(jQuery('#'+current_id));
					
					populate_input_settings(jQuery('#'+current_id).find('.the_input_element'));
					populate_help_text_settings(jQuery('#'+current_id).find('.help-block'));
					populate_validation_settings(jQuery('#'+current_id).find('.error_message'))
					}
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
				if(jQuery('#'+current_id).hasClass('grid-system'))	
					populate_grid_system_settings(jQuery('#'+current_id));
				if(jQuery('#'+current_id).hasClass('submit-button'))	
					populate_button_settings(jQuery('#'+current_id).find('.the_input_element'));
				
				
				//jQuery('.editing-field').removeClass('editing-field');
				
				
				},50
			);
		}
		
		
		/*$("#do-upload-image").submit(function(e)
{
    var postData = $(this).serializeArray();
    var formURL = $(this).attr("action");
    $.ajax(
    {
        url : formURL,
        type: "POST",
		data: postData,
		mimeType:"multipart/form-data",
        success:function(data, textStatus, jqXHR)
        {
            //data: return data from server
			console.log(data)
			$('#'+current_id).find('.panel-body').css('background','url("'+ data +'")');
			
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            //if fails     
			alert('false')
        }
    });
    e.preventDefault(); //STOP default action
    
});*/

jQuery('#do-upload-image').ajaxForm({
    data: {
       action: 'do_upload_image'
    },
    //dataType: 'json',
    beforeSubmit: function(formData, jqForm, options) {
		//alert('test');
		//console.log($('input[name="do_image_upload_preview"]').val())
    },
   success : function(responseText, statusText, xhr, $form) {
	   if($('#'+current_id).hasClass('other-elements') && $('#'+current_id).hasClass('grid'))
      	 $('#'+current_id).find('.panel-heading').next('.panel-body').css('background','url("'+ responseText +'")');
    	else
		  $('#'+current_id).find('.the_input_element').css('background','url("'+ responseText +'")');
	},
	 error: function(jqXHR, textStatus, errorThrown)
        {
           console.log(errorThrown)
        }
});


	jQuery('input[name="do_image_upload_preview"]').change(
		function()
			{
			jQuery('#do-upload-image').submit();
			//console.log(jQuery(this).val());	
			}
	)
/***************/	

/********** MD FIELD SETTINGS ******************/
var md_effects_array = ['haruki','hoshi','jiro','nariko'];
jQuery('select[name="md-effect"]').change(
	function()
		{
		
		for (var i = 0; i < md_effects_array.length; i++)
			{
			$('#'+current_id).find('.md-wrapper').removeClass('input--'+md_effects_array[i]);
			$('#'+current_id).find('.md-input').removeClass('input__field--'+md_effects_array[i]);
			$('#'+current_id).find('.md-label').removeClass('input__label--'+md_effects_array[i]);
			$('#'+current_id).find('.md-label-content').removeClass('input__label-content--'+md_effects_array[i]);
			//console.log(md_effects_array[i]);
			}
		$('#'+current_id).find('.md-wrapper').addClass('input--'+jQuery(this).val());
		$('#'+current_id).find('.md-input').addClass('input__field--'+jQuery(this).val());
		$('#'+current_id).find('.md-label').addClass('input__label--'+jQuery(this).val());
		$('#'+current_id).find('.md-label-content').addClass('input__label-content--'+jQuery(this).val());
		
		}
	);

jQuery('select[name="md-select-effect"]').change(
	function()
		{
		
		$('#'+current_id).find('select').attr('data-effect',$(this).val());
		
		build_md_select($('#'+current_id).find('#cd-dropdown'));
		}
	);



/******* DATE TIME */

jQuery('select#select_date_format').change(
		function()
			{
			if($(this).val()!='custom')
				{
				$('#'+current_id).find('#datetimepicker').attr('data-format',$(this).val())
				$('div#nex-forms-field-settings #set_date_format').addClass('hidden');
				}
			else
				{
				$('#'+current_id).find('#datetimepicker').attr('data-format',$('div#nex-forms-field-settings #set_date_format').val())
				$('div#nex-forms-field-settings #set_date_format').removeClass('hidden');
				}
			$('#'+current_id).find('#datetimepicker').datetimepicker({ format: $('#'+current_id).find('#datetimepicker').attr('data-format') });
			}
	)

$('div#nex-forms-field-settings #set_date_format').val($('#'+current_id).find('#datetimepicker').attr('data-format'))
			$('div#nex-forms-field-settings #set_date_format').keyup(
				function()
					{
					$('#'+current_id).find('#datetimepicker').attr('data-format',$(this).val())
					}
				);
				

jQuery('select#date-picker-lang-selector').change(
		function()
			{
			$('#'+current_id).find('#datetimepicker').attr('data-language',$(this).val())
			}
	)				
/*** PRE-POSTFIX ****/	
			
			$('.icon_search').keyup(
				function()
					{
					var search_term = $(this).val();
					$('.iconSet i').each(
						function()
							{
							if(!strstr($(this).attr('class'),search_term))
								$(this).hide();
							else
								$(this).show();
							}
						);
					}
			)
	
			$('button.set_icon').click(
				function()
					{
					$('#iconSet').modal().appendTo('body');
					$('.iconSet').attr('class','modal iconSet '+$(this).attr('data-set-class'));
					$('.iconSet i').removeClass('btn-primary');
					$('.iconSet i').show();
					$('.icon_search').val('');
					setTimeout(function(){ $('.modal-backdrop').remove(); },100);
					}
				);		
			$('.iconSet.set_prefix i').live('click',
				function()
					{
					$('#iconSet i').removeClass('btn-primary');
					$('#'+current_id).find('.prefix span').attr('class',$(this).attr('class'));
					
					$('button.set_prefix_icon').closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
					$(this).addClass('btn-primary');
					}
				);
			$('.iconSet.set_postfix i').live('click',
				function()
					{
					$('#iconSet i').removeClass('btn-primary');
					$('#'+current_id).find('.postfix span').attr('class',$(this).attr('class'));
					
					$('button.set_postfix_icon').closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
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
				
			$('.dropdown-menu.button-color li a').click(
				function()
					{
					$('.dropdown-menu.button-color li').removeClass('selected')
					$(this).parent().addClass('selected');
					var current_class = $('#'+current_id).find('.the_input_element').attr('class');
					current_class = current_class.replace('alert-danger','');
					current_class = current_class.replace('alert-warning','');
					current_class = current_class.replace('alert-info','');
					current_class = current_class.replace('alert-success','');
					current_class = current_class.replace('btn-danger','');
					current_class = current_class.replace('btn-warning','');
					current_class = current_class.replace('btn-primary','');
					current_class = current_class.replace('btn-info','');
					current_class = current_class.replace('btn-success','');					
					current_class = current_class.replace('btn-default','');
					
					$('#'+current_id).find('.the_input_element').attr('class',current_class)
					$('#'+current_id).find('.the_input_element').addClass($(this).attr('class'));
					$(this).closest('.input_holder').find('.colorpicker-element i').attr('class',$(this).attr('class'));
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
					
					var formated_value = format_illegal_chars($(this).val());
					$('#'+current_id).find('.the_input_element').attr('name',formated_value)
					$('#'+current_id).find('input[type="file"]').attr('name',formated_value)
					
					$('div#nex-forms-field-settings #set_input_name').val(formated_value);
						
					if($('#'+current_id).hasClass('check-group') || $('#'+current_id).hasClass('multi-select') || $('#'+current_id).hasClass('classic-check-group') || $('#'+current_id).hasClass('classic-multi-select'))
							$('#'+current_id).find('.the_input_element').attr('name',formated_value+'[]')
						
					}
				);
				
			$('div#nex-forms-field-settings #set_input_name').val(format_illegal_chars($('#'+current_id).find('.the_input_element').attr('name')))
			$('div#nex-forms-field-settings #set_input_name').keyup(
				function()
					{
					var formated_value = format_illegal_chars($(this).val());
					$('#'+current_id).find('.the_input_element').attr('name',formated_value)
					$('#'+current_id).find('input[type="file"]').attr('name',formated_value)
					
					$('div#nex-forms-field-settings #set_input_name').val(formated_value);
					
					if($('#'+current_id).hasClass('check-group') || $('#'+current_id).hasClass('multi-select') || $('#'+current_id).hasClass('classic-check-group') || $('#'+current_id).hasClass('classic-multi-select'))
							$('#'+current_id).find('.the_input_element').attr('name',format_illegal_chars($(this).val())+'[]')
					}
				);
				
			$('div#nex-forms-field-settings #set_math_input_name').val(format_illegal_chars($('#'+current_id).find('.set_math_result').attr('name')))
			$('div#nex-forms-field-settings #set_math_input_name').keyup(
				function()
					{
					var formated_value = format_illegal_chars($(this).val());
					$('div#nex-forms-field-settings #set_math_input_name').val(formated_value);
					$('#'+current_id).find('.set_math_result').attr('name',formated_value)
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
					var get_label = $('#'+current_id).find('label.ve_title');
					get_label.parent().show();
					
					if($(this).hasClass('top'))
						{
						get_label.parent().addClass('full_width');
						$('#'+current_id).find('.input_container').addClass('full_width');
						$('#'+current_id).find('.input_container').removeClass('col-sm-10').addClass('col-sm-12');
						}
					if($(this).hasClass('left'))
						{
						//get_label.parent().attr('class','');
						get_label.parent().removeClass('full_width');
						$('#'+current_id).find('.input_container').removeClass('full_width');
						$('#'+current_id).find('.input_container').removeClass('col-sm-12').addClass('col-sm-10');
						}
					if($(this).hasClass('none'))
						{
						$('#'+current_id).find('.input_container').addClass('full_width');
						get_label.parent().hide();
						}
					if($(this).hasClass('inside'))
						{
						$('#'+current_id).find('.input_container').addClass('full_width');
						$('#'+current_id).find('.label_container').hide();
						$('#'+current_id).find('.input_container').each(
							function()
								{
								$(this).find('.the_input_element').attr('placeholder',$(this).closest('.form_field').find('.the_label').text())
								}							
							);
						}
					}
				);
			
			
			//LABEL WIDTH
			$('.label-width button').click(
				function()
					{
					$('.label-width button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_label = $('#'+current_id).find('.label_container');
					get_label.removeClass('col-sm-1');
					get_label.removeClass('col-sm-2');
					get_label.removeClass('col-sm-3');
					get_label.removeClass('col-sm-4');
					get_label.removeClass('col-sm-5');
					get_label.removeClass('col-sm-6');
					get_label.removeClass('col-sm-7');
					get_label.removeClass('col-sm-8');
					get_label.removeClass('col-sm-9');
					get_label.removeClass('col-sm-10');
					get_label.removeClass('col-sm-11');
					get_label.removeClass('col-sm-12');
					
					get_label.addClass(jQuery(this).attr('data-col-width'))

					}
				);
				
			//INPUT WIDTH
			$('.input-width button').click(
				function()
					{
					$('.input-width button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_input = $('#'+current_id).find('.input_container');
					get_input.removeClass('full_width');
					get_input.removeClass('col-sm-1');
					get_input.removeClass('col-sm-2');
					get_input.removeClass('col-sm-3');
					get_input.removeClass('col-sm-4');
					get_input.removeClass('col-sm-5');
					get_input.removeClass('col-sm-6');
					get_input.removeClass('col-sm-7');
					get_input.removeClass('col-sm-8');
					get_input.removeClass('col-sm-9');
					get_input.removeClass('col-sm-10');
					get_input.removeClass('col-sm-11');
					get_input.removeClass('col-sm-12');
					
					get_input.addClass(jQuery(this).attr('data-col-width'))

					}
				);
				
		//COL-1 WIDTH
			$('.col-1-width button').click(
				function()
					{
					$('.col-1-width button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_input = $('#'+current_id).find('.row .grid_input_holder:eq(0)');
					get_input.removeClass('col-sm-1');
					get_input.removeClass('col-sm-2');
					get_input.removeClass('col-sm-3');
					get_input.removeClass('col-sm-4');
					get_input.removeClass('col-sm-5');
					get_input.removeClass('col-sm-6');
					get_input.removeClass('col-sm-7');
					get_input.removeClass('col-sm-8');
					get_input.removeClass('col-sm-9');
					get_input.removeClass('col-sm-10');
					get_input.removeClass('col-sm-11');
					get_input.removeClass('col-sm-12');
					
					get_input.addClass(jQuery(this).attr('data-col-width'))

					}
				);
		//COL-2 WIDTH
			$('.col-2-width button').click(
				function()
					{
					$('.col-2-width button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_input = $('#'+current_id).find('.row .grid_input_holder:eq(1)');
					get_input.removeClass('col-sm-1');
					get_input.removeClass('col-sm-2');
					get_input.removeClass('col-sm-3');
					get_input.removeClass('col-sm-4');
					get_input.removeClass('col-sm-5');
					get_input.removeClass('col-sm-6');
					get_input.removeClass('col-sm-7');
					get_input.removeClass('col-sm-8');
					get_input.removeClass('col-sm-9');
					get_input.removeClass('col-sm-10');
					get_input.removeClass('col-sm-11');
					get_input.removeClass('col-sm-12');
					
					get_input.addClass(jQuery(this).attr('data-col-width'))

					}
				);
		//COL-3 WIDTH
			$('.col-3-width button').click(
				function()
					{
					$('.col-3-width button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_input = $('#'+current_id).find('.row .grid_input_holder:eq(2)');
					get_input.removeClass('col-sm-1');
					get_input.removeClass('col-sm-2');
					get_input.removeClass('col-sm-3');
					get_input.removeClass('col-sm-4');
					get_input.removeClass('col-sm-5');
					get_input.removeClass('col-sm-6');
					get_input.removeClass('col-sm-7');
					get_input.removeClass('col-sm-8');
					get_input.removeClass('col-sm-9');
					get_input.removeClass('col-sm-10');
					get_input.removeClass('col-sm-11');
					get_input.removeClass('col-sm-12');
					
					get_input.addClass(jQuery(this).attr('data-col-width'))

					}
				);
		
		//COL-4 WIDTH
			$('.col-4-width button').click(
				function()
					{
					$('.col-4-width button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_input = $('#'+current_id).find('.row .grid_input_holder:eq(3)');
					get_input.removeClass('col-sm-1');
					get_input.removeClass('col-sm-2');
					get_input.removeClass('col-sm-3');
					get_input.removeClass('col-sm-4');
					get_input.removeClass('col-sm-5');
					get_input.removeClass('col-sm-6');
					get_input.removeClass('col-sm-7');
					get_input.removeClass('col-sm-8');
					get_input.removeClass('col-sm-9');
					get_input.removeClass('col-sm-10');
					get_input.removeClass('col-sm-11');
					get_input.removeClass('col-sm-12');
					
					get_input.addClass(jQuery(this).attr('data-col-width'))

					}
				);
		//COL-5 WIDTH
			$('.col-5-width button').click(
				function()
					{
					$('.col-5-width button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_input = $('#'+current_id).find('.row .grid_input_holder:eq(4)');
					get_input.removeClass('col-sm-1');
					get_input.removeClass('col-sm-2');
					get_input.removeClass('col-sm-3');
					get_input.removeClass('col-sm-4');
					get_input.removeClass('col-sm-5');
					get_input.removeClass('col-sm-6');
					get_input.removeClass('col-sm-7');
					get_input.removeClass('col-sm-8');
					get_input.removeClass('col-sm-9');
					get_input.removeClass('col-sm-10');
					get_input.removeClass('col-sm-11');
					get_input.removeClass('col-sm-12');
					
					get_input.addClass(jQuery(this).attr('data-col-width'))

					}
				);
		//COL-6 WIDTH
			$('.col-6-width button').click(
				function()
					{
					$('.col-6-width button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_input = $('#'+current_id).find('.row .grid_input_holder:eq(5)');
					get_input.removeClass('col-sm-1');
					get_input.removeClass('col-sm-2');
					get_input.removeClass('col-sm-3');
					get_input.removeClass('col-sm-4');
					get_input.removeClass('col-sm-5');
					get_input.removeClass('col-sm-6');
					get_input.removeClass('col-sm-7');
					get_input.removeClass('col-sm-8');
					get_input.removeClass('col-sm-9');
					get_input.removeClass('col-sm-10');
					get_input.removeClass('col-sm-11');
					get_input.removeClass('col-sm-12');
					
					get_input.addClass(jQuery(this).attr('data-col-width'))

					}
				);
				
		//ALIGNMENT
			$('.align-label button').click(
				function()
					{
					$('.align-label button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_label = $('#'+current_id).find('label').parent();
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
					get_label.removeClass('text-lg').removeClass('text-sm');
					
					if($(this).hasClass('small'))
						get_label.addClass('text-sm');
					if($(this).hasClass('large'))
						get_label.addClass('text-lg');
					}
				);
			
			$('.thumb-size button').click(
				function()
					{
					$('.thumb-size button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_obj = $('#'+current_id);
					get_obj.removeClass('thumb-xlg').removeClass('thumb-lg').removeClass('thumb-sm');
					
					if($(this).hasClass('small'))
						get_obj.addClass('thumb-sm');
					if($(this).hasClass('large'))
						get_obj.addClass('thumb-lg');
					if($(this).hasClass('xlarge'))
						get_obj.addClass('thumb-xlg');
					}
				);
			
		//FONT
			$('select[name="fonts"]').change( function(){
				$(this).data('stylesFontDropdown').preview_font_change( $('#collapseFormsCanvas .nex-forms-container').find('div, label, span.sub-text, button') );
				
			});
//SET RADIOS / CHECKS
				var current_inputs = ''
				if($('#'+current_id).hasClass('check-group') || $('#'+current_id).hasClass('classic-check-group'))
					{
					$('#'+current_id).find('div span.check-label').each(
						function()
							{
							if($(this).text()!=$(this).parent().find('input').val())
								current_inputs += $(this).parent().find('input').val()+'=='+$(this).text() +'\n';	
							else
								current_inputs += $(this).text() +'\n';	
							}
						);	
					}
				else
					{
					$('#'+current_id).find('div span.radio-label').each(
						function()
							{
							if($(this).text()!=$(this).parent().find('input').val())
								current_inputs += $(this).parent().find('input').val()+'=='+$(this).text() +'\n';	
							else
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
										if($('#'+current_id).hasClass('check-group') || $('#'+current_id).hasClass('classic-check-group'))
											{
											if(strstr(items[i],'=='))
												{
												var split_option = items[i].split('==')
												set_inputs += '<label class="checkbox-inline" for="'+ format_illegal_chars(items[i]) +'"  data-svg="demo-input-1"><span class="svg_ready"><input class="check the_input_element" type="checkbox" name="'+ format_illegal_chars($('#'+current_id).find('.the_label').text()) +'[]" id="'+format_illegal_chars(items[i])+'" value="'+split_option[0]+'"><span class="input-label check-label">'+split_option[1]+'</span></span></label>';
												}
											else
										    	set_inputs += '<label class="checkbox-inline" for="'+ format_illegal_chars(items[i]) +'"  data-svg="demo-input-1"><span class="svg_ready"><input class="check the_input_element" type="checkbox" name="'+ format_illegal_chars($('#'+current_id).find('.the_label').text()) +'[]" id="'+format_illegal_chars(items[i])+'" value="'+items[i]+'"><span class="input-label check-label">'+items[i]+'</span></span></label>';
											}
										else
											{
											if(strstr(items[i],'=='))
												{
												var split_option = items[i].split('==')
												set_inputs += '<label class="radio-inline" for="'+ format_illegal_chars(items[i]) +'"  data-svg="demo-input-1"><span class="svg_ready"><input class="radio the_input_element" type="radio" name="'+ format_illegal_chars($('#'+current_id).find('.the_label').text()) +'" id="'+format_illegal_chars(items[i])+'" value="'+split_option[0]+'"><span class="input-label radio-label">'+split_option[1]+'</span></span></label>';
												}
											else
												set_inputs += '<label class="radio-inline" for="'+ format_illegal_chars(items[i]) +'"  data-svg="demo-input-1"><span class="svg_ready"><input class="radio the_input_element" type="radio" name="'+ format_illegal_chars($('#'+current_id).find('.the_label').text()) +'" id="'+format_illegal_chars(items[i])+'" value="'+items[i]+'"><span class="input-label radio-label">'+items[i]+'</span></span></label>';
											}
										}
									}	
								$('#'+current_id).find('div#the-radios .input-inner').html(set_inputs);
								if(!$('#'+current_id).hasClass('classic-check-group') && !$('#'+current_id).hasClass('classic-radio-group'))
									$('#'+current_id).find('div#the-radios input').nexchecks();
							}
						);	
				
				$('div#nex-forms-field-settings #set_image_selection').val(current_inputs)
					$('div#nex-forms-field-settings #set_image_selection').live('change',
						function()
							{
								var items = jQuery(this).val();
								var set_inputs = '';
								items = items.split('\n');
								for (var i = 0; i < items.length; i++)
									{
									if(items[i]!='')
										{
										if($('#'+current_id).find('div#the-radios .input-inner label:eq('+ i +') img').attr('src'))
											var the_image = '<img class="radio-image" src="' + $('#'+current_id).find('div#the-radios .input-inner label:eq('+ i +') img').attr('src') + '">';
										else
											var the_image = '';
										if($('#'+current_id).hasClass('multi-image-select-group'))
											{											
											if(strstr(items[i],'=='))
												{
												var split_option = items[i].split('==')
												set_inputs += '<label class="radio-inline" for="'+ format_illegal_chars(items[i]) +'"  data-svg="demo-input-1"><span class="svg_ready has-pretty-child"><input class="radio the_input_element" type="checkbox" name="'+ format_illegal_chars($('#'+current_id).find('.the_label').text()) +'[]" id="'+format_illegal_chars(items[i])+'" value="'+split_option[0]+'"><span class="input-label radio-label  img-thumbnail">'+split_option[0]+ the_image +'</span></span></label>';
												}
											else
												{
												set_inputs += '<label class="radio-inline" for="'+ format_illegal_chars(items[i]) +'"  data-svg="demo-input-1"><span class="svg_ready has-pretty-child"><input class="radio the_input_element" type="checkbox" name="'+ format_illegal_chars($('#'+current_id).find('.the_label').text()) +'[]" id="'+format_illegal_chars(items[i])+'" value="'+items[i]+'"><span class="input-label radio-label  img-thumbnail">'+items[i]+ the_image +'</span></span></label>';
												}
											}
										else
											{
											if(strstr(items[i],'=='))
												{
												var split_option = items[i].split('==')
												set_inputs += '<label class="radio-inline" for="'+ format_illegal_chars(items[i]) +'"  data-svg="demo-input-1"><span class="svg_ready has-pretty-child"><input class="radio the_input_element" type="radio" name="'+ format_illegal_chars($('#'+current_id).find('.the_label').text()) +'" id="'+format_illegal_chars(items[i])+'" value="'+split_option[0]+'"><span class="input-label radio-label  img-thumbnail">'+split_option[1]+the_image +'</span></span></label>';
												}
											else
												{
												set_inputs += '<label class="radio-inline" for="'+ format_illegal_chars(items[i]) +'"  data-svg="demo-input-1"><span class="svg_ready has-pretty-child"><input class="radio the_input_element" type="radio" name="'+ format_illegal_chars($('#'+current_id).find('.the_label').text()) +'" id="'+format_illegal_chars(items[i])+'" value="'+items[i]+'"><span class="input-label radio-label  img-thumbnail">'+items[i]+the_image +'</span></span></label>';
												}
											
											}
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
			
			
			$('div#nex-forms-field-settings #step_value').val($('#'+current_id).find('#slider').attr('data-step-value'))
			$('div#nex-forms-field-settings #step_value').change(
				function()
					{
					$('#'+current_id).find( "#slider" ).attr('data-step-value',$(this).val());
					$('#'+current_id).find( "#slider" ).slider('option','step',parseInt($(this).val()))						
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
			$('.iconSet.set_slider_icon i').live('click',
				function()
					{
					$('#iconSet i').removeClass('btn-primary');
					$('#'+current_id).find('#slider').attr('data-dragicon',$(this).attr('class'));
					
					$('#'+current_id).find('.ui-slider-handle span#icon').attr('class',$(this).attr('class'))
					
					$('button.set_slider_icon').closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
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
				$('#'+current_id).find('#slider .ui-slider-handle span.count-text').html($(this).val());
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
				$('#'+current_id).find('#slider .ui-slider-handle span.count-text').html($(this).val());
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
			
			$('.iconSet.set_spinner_down_icon i').live('click',
				function()
					{
					$('#iconSet i').removeClass('btn-primary');
					$('#'+current_id).find('#spinner').attr('data-down-icon',$(this).attr('class'));
					$('#'+current_id).find('.bootstrap-touchspin-down .icon').attr('class','icon ' + $(this).attr('class'));
					
					$('button.set_spinner_down_icon').closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
					$(this).addClass('btn-primary');
					}
				);
			
			$('.iconSet.set_spinner_up_icon i').live('click',
				function()
					{
					$('#iconSet i').removeClass('btn-primary');
					$('#'+current_id).find('#spinner').attr('data-up-icon',$(this).attr('class'));
					$('#'+current_id).find('.bootstrap-touchspin-up .icon').attr('class','icon ' + $(this).attr('class'));
					
					$('button.set_spinner_up_icon').closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
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
	
	$('.iconSet.set_tag_icon i').live('click',
				function()
					{
					$('#iconSet i').removeClass('btn-primary');
					$('#'+current_id).find('#tags').attr('data-tag-icon',$(this).attr('class'));
					
					$('#'+current_id).find('.bootstrap-tagsinput #tag-icon').attr('class',$(this).attr('class'))
					
					$('button.set_tag_icon').closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
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
						if($('#'+current_id).hasClass('md-select'))
						{
						//$('div.cd-dropdown').remove();
						build_md_select($('#'+current_id).find('#cd-dropdown'))
						}
					else if($('#'+current_id).hasClass('classic-select') || $('#'+current_id).hasClass('classic-multi-select') || $('#'+current_id).hasClass('classic-multi-select'))
						{
						}
					else
						{
						$('#'+current_id).find('select').selectpicker('refresh');
						}
						
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
		
		$('div#nex-forms-field-settings #set_math_logic_equation').val($('#'+current_id).find('.the_input_element').attr('data-math-equation'))
		$('div#nex-forms-field-settings #set_math_logic_equation').keyup(
			function()
				{
				$('#'+current_id).find('.the_input_element').attr('data-math-equation',$(this).val());
				$('#'+current_id).find('.the_input_element').attr('data-original-math-equation',$(this).val());
				}
			);
		$('div#nex-forms-field-settings #set_math_logic_equation').blur(
			function()
				{
				$('#'+current_id).find('.the_input_element').attr('data-math-equation',$(this).val());
				$('#'+current_id).find('.the_input_element').attr('data-original-math-equation',$(this).val());
				}
			);
		
/***************/			
/* HEADING */
		$('div#nex-forms-field-settings #set_heading').val($('#'+current_id).find('.the_input_element').html())
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
			
			$('.show-panel-heading button').click(
				function()
					{
					$('.show-panel-heading button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_obj = $('#'+current_id).find('.panel-heading');
				
						if($(this).hasClass('yes'))
							get_obj.show();
						if($(this).hasClass('no'))
							get_obj.hide();
					}
				);	
				
			$('.panel-background-size button').click(
				function()
					{
					$('.panel-background-size button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					
					if($('#'+current_id).hasClass('other-elements') && $('#'+current_id).hasClass('grid'))
						var get_obj = $('#'+current_id).find('.panel-body');
					else
						var get_obj = $('#'+current_id).find('.the_input_element');
						
						if($(this).hasClass('auto'))
							get_obj.css('background-size','auto');
						if($(this).hasClass('cover'))
							get_obj.css('background-size','cover');
						if($(this).hasClass('contain'))
							get_obj.css('background-size','contain');
					}
				);	
			$('.panel-background-repeat button').click(
				function()
					{
					$('.panel-background-repeat button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					if($('#'+current_id).hasClass('other-elements') && $('#'+current_id).hasClass('grid'))
						var get_obj = $('#'+current_id).find('.panel-body');
					else
						var get_obj = $('#'+current_id).find('.the_input_element');
					
						if($(this).hasClass('no-repeat'))
							get_obj.css('background-repeat','no-repeat');
						if($(this).hasClass('repeat'))
							get_obj.css('background-repeat','repeat');
						if($(this).hasClass('repeat-x'))
							get_obj.css('background-repeat','repeat-x');
						if($(this).hasClass('repeat-y'))
							get_obj.css('background-repeat','repeat-y');	
						
					}
				);	
			$('.panel-background-position button').click(
				function()
					{
					$('.panel-background-position button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					if($('#'+current_id).hasClass('other-elements') && $('#'+current_id).hasClass('grid'))
						var get_obj = $('#'+current_id).find('.panel-body');
					else
						var get_obj = $('#'+current_id).find('.the_input_element');
					
						if($(this).hasClass('right'))
							get_obj.css('background-position','right');
						if($(this).hasClass('left'))
							get_obj.css('background-position','left');
						if($(this).hasClass('center'))
							get_obj.css('background-position','center');	
						
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
				
				
			
			$('.input-field-alignment button').click(
				function()
					{
					$('.input-field-alignment  button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_obj = $('#'+current_id).find('.input_container');
					get_obj.removeClass('align_left').removeClass('align_right').removeClass('align_center');
					var set_class =  ''
					if($(this).hasClass('left'))
						set_class = 'align_left';
					if($(this).hasClass('right'))
						set_class = 'align_right';
					if($(this).hasClass('center'))
						set_class = 'align_center';
					
					get_obj.addClass(set_class);
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
					if($('#'+current_id).hasClass('submit-button'))
						{
						if($(this).hasClass('small'))
							get_obj.addClass('btn-sm');
						if($(this).hasClass('large'))
							get_obj.addClass('btn-lg');
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
						{
						if($(this).text()!=$(this).attr('value'))
							current_options += $(this).attr('value')+'=='+$(this).text() +'\n';
						else
							current_options += $(this).text() +'\n';
						
						}
							
					}
				);
			$('div#nex-forms-field-settings #set_default_value').val(($('#'+current_id).find('select option:selected').text()) ? $('#'+current_id).find('select option:selected').text() : 'Choose Option')
			$('div#nex-forms-field-settings #set_default_value').change(
				function()
					{
					//$(this).closest('#categorize_it_container').find('.prepopulate_target textarea').trigger('change');
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
								if(strstr(items[i],'=='))
									{
									var split_option = items[i].split('==')
									set_options += '<option value="'+ split_option[0] +'">'+ split_option[1] +'</option>';
									}
								else
									set_options += '<option value="'+ items[i] +'">'+ items[i] +'</option>';
								}
							}	
							
					$('#'+current_id).find('select').html(set_options);
					
					if($('#'+current_id).hasClass('md-select'))
						{
						//$('div.cd-dropdown').remove();
						build_md_select($('#'+current_id).find('#cd-dropdown'))
						}
					else if($('#'+current_id).hasClass('classic-select') || $('#'+current_id).hasClass('classic-multi-select'))
						{
						//$('div.cd-dropdown').remove();
						}
					else
						{
						$('#'+current_id).find('select').selectpicker('refresh');
						}
						
						
					}
				);
		
		$('ul.prepopulate li a').live('click',
			function()
				{
				var container = $(this).closest('#categorize_it_container').find('.prepopulate_target textarea');
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
				
		//BUTTON WIDTH
			$('.button-width button').click(
				function()
					{
					$('.button-width button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_button = $('#'+current_id).find('.the_input_element');
					
					if($(this).hasClass('normal'))
						get_button.removeClass('full_width');
					if($(this).hasClass('full_button'))
						get_button.addClass('full_width');
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
						get_label.addClass('text-sm');
					if($(this).hasClass('large'))
						get_label.addClass('text-lg');
					}
				);
		//FONT
			$('select[name="error-fonts"]').change( function(){
				$(this).data('stylesFontDropdown').preview_font_change( $('#'+current_id).find('label') );
			});	
			
/**********************/					
/*** RADIO BUTTONS ****/
		
		$('.iconSet.set_radio i').live('click',
				function()
					{
					$('#iconSet i').removeClass('btn-primary');
					$('#'+current_id).find('.prefix span').attr('class',$(this).attr('class'));
					
					$('button.set_radio_icon').closest('.input_holder').find('.current-icon').attr('class','current-icon '+$(this).attr('class'));
					
					
					var get_class = $(this).attr('class') + ' fa ' + $('.dropdown-menu.selected-radio-color li.selected a').attr('class') ;
					
					
					var radio_group = $('#'+current_id).find('.the-radios');
					
					$('#'+current_id).find('input').each(function(index, el){
						if($(el).prop('checked')==true)
						 $(el).parent().find('a:first').attr('class','checked ui-state-active fa '+ get_class)
						else
						 $(el).parent().find('a:first').attr('class','fa ui-state-default')
						
						$(el).parent().find('a').addClass('fa ui-state-default')
						}
					);
					radio_group.attr('data-checked-class',get_class);
					
					$(this).addClass('btn-primary');
					
					}
				);
				
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
						 $(el).parent().find('a:first').attr('class','checked ui-state-active fa '+ get_class)
						else
						 $(el).parent().find('a:first').attr('class','fa ui-state-default')
						
						$(el).parent().find('a').addClass('fa ui-state-default')
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
						 $(el).parent().find('a:first').attr('class','checked ui-state-active fa '+ new_class)
						else
						 $(el).parent().find('a:first').attr('class','ui-state-default')	
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
						$('#'+current_id).find('.ui-slider-handle span.count-text').addClass('style_bold');
						$(this).addClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('.ui-slider-handle span.count-text').removeClass('style_bold');
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
						$('#'+current_id).find('.ui-slider-handle').addClass('style_italic');
						$(this).addClass('label-primary');
						}
					else
						{
						$('#'+current_id).find('.ui-slider-handle').removeClass('style_italic');
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
				
//OVERALL SETTINGS 

//INPUT

			$('.overall-align-input button').click(
				function()
					{
					$('.overall-align-input button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_obj = $('#collapseFormsCanvas .nex-forms-container .the_input_element');
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
					$('#collapseFormsCanvas .nex-forms-container').find('select').attr('data-text-alignment',set_class);
					}
				);
				
			$('.overall-input-corners button').click(
				function()
					{
					$('.overall-input-corners button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_obj = $('#collapseFormsCanvas .nex-forms-container .form_field');
					var set_class ='';
					get_obj.removeClass('square').removeClass('full_rounded');
					if($(this).hasClass('square'))
						set_class = 'square';
					if($(this).hasClass('full_rounded'))
						set_class = 'full_rounded';
					
					get_obj.addClass(set_class);
					}
				);
//Input Color
			jQuery('#overall-input-color').bscolorpicker().on('changeColor', function(ev){
			 $('#collapseFormsCanvas .nex-forms-container .the_input_element').css('color',ev.color.toHex());
			 $('#collapseFormsCanvas .nex-forms-container').find('select').attr('data-text-color',ev.color.toHex());
			  $('#collapseFormsCanvas .nex-forms-container').find('.selectpicker a').css('color',ev.color.toHex());			 
			});
			  
		//Input BG Color
			jQuery('#overall-input-bg-color').bscolorpicker().on('changeColor', function(ev){
			  $('#collapseFormsCanvas .nex-forms-container .the_input_element').css('background',ev.color.toHex());
			  
				 $('#collapseFormsCanvas .nex-forms-container').find('select').attr('data-background-color',ev.color.toHex());
			});
			
		//Input border Color
			jQuery('#overall-input-border-color').bscolorpicker().on('changeColor', function(ev){
			 $('#collapseFormsCanvas .nex-forms-container .the_input_element').css('border-color',ev.color.toHex());
			 $('#collapseFormsCanvas .nex-forms-container').find('select').attr('data-border-color',ev.color.toHex());
			});
			
		//Input border on focus Color
			jQuery('#overall-input-onfocus-color').bscolorpicker().on('changeColor', function(ev){
			$('#collapseFormsCanvas .nex-forms-container .the_input_element').attr('data-onfocus-color',ev.color.toHex());
			});


//LABEL

		

		

		$('.overall-show-label button').click(
				function()
					{	
					$('.overall-show-label button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					if($(this).hasClass('top'))
						{
						$('#collapseFormsCanvas .nex-forms-container .label_container').show();
						$('#collapseFormsCanvas .nex-forms-container .label_container').addClass('full_width');
						$('#collapseFormsCanvas .nex-forms-container .input_container').addClass('full_width');
						$('#collapseFormsCanvas .nex-forms-container .input_container').removeClass('col-sm-10').addClass('col-sm-12');
						}
					if($(this).hasClass('left'))
						{
						$('#collapseFormsCanvas .nex-forms-container .label_container').show();
						$('#collapseFormsCanvas .nex-forms-container .label_container').removeClass('full_width');
						$('#collapseFormsCanvas .nex-forms-container .input_container').removeClass('full_width');
						$('#collapseFormsCanvas .nex-forms-container .input_container').removeClass('col-sm-12').addClass('col-sm-10');
						}
						
					if($(this).hasClass('none'))
						{
						$('#collapseFormsCanvas .nex-forms-container .input_container').addClass('full_width');
						$('#collapseFormsCanvas .nex-forms-container .label_container').hide();
						}
					if($(this).hasClass('inside'))
						{
						
						$('#collapseFormsCanvas .nex-forms-container .form_field').each(
							function()
								{
								if(!$(this).hasClass('star-rating') 
								&& !$(this).hasClass('slider') 
								&& !$(this).hasClass('radio-group')
								&& !$(this).hasClass('check-group')
								&& !$(this).hasClass('classic-radio-group')
								&& !$(this).hasClass('classic-check-group')
								&& !$(this).hasClass('single-image-select-group')
								&& !$(this).hasClass('multi-image-select-group')
								&& !$(this).hasClass('tags'))
									{
									$(this).find('.input_container').addClass('full_width');
									$(this).find('.label_container').hide();
									$(this).find('.the_input_element').attr('placeholder',$(this).closest('.form_field').find('.the_label').text())	
									}
								else
									{
									$(this).find('.input_container').addClass('full_width');
									$(this).find('.label_container').show();
									}
								
								}							
							);
						}
					}
				);
		
		$('.overall-align-label button').click(
				function()
					{
					$('.overall-align-label button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					$('#collapseFormsCanvas .nex-forms-container .label_container').removeClass('align_left').removeClass('align_right').removeClass('align_center');
					
					if($(this).hasClass('left'))
						$('#collapseFormsCanvas .nex-forms-container .label_container').addClass('align_left');
					if($(this).hasClass('right'))
						$('#collapseFormsCanvas .nex-forms-container .label_container').addClass('align_right');
					if($(this).hasClass('center'))
						$('#collapseFormsCanvas .nex-forms-container .label_container').addClass('align_center');
					}
				);
		$('.show-sub-label button').click(
				function()
					{
					$('.show-sub-label button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					if($(this).hasClass('hide_subs'))
						$('#collapseFormsCanvas .nex-forms-container .sub-text').hide();
					if($(this).hasClass('show_subs'))
						$('#collapseFormsCanvas .nex-forms-container .sub-text').show();
					}
				);
		$('.overall-label-width button').click(
				function()
					{	
				
					$('.overall-label-width button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
									
					var get_label = $('#collapseFormsCanvas .nex-forms-container .label_container');;
					get_label.removeClass('col-sm-1');
					get_label.removeClass('col-sm-2');
					get_label.removeClass('col-sm-3');
					get_label.removeClass('col-sm-4');
					get_label.removeClass('col-sm-5');
					get_label.removeClass('col-sm-6');
					get_label.removeClass('col-sm-7');
					get_label.removeClass('col-sm-8');
					get_label.removeClass('col-sm-9');
					get_label.removeClass('col-sm-10');
					get_label.removeClass('col-sm-11');
					get_label.removeClass('col-sm-12');
					
					get_label.addClass(jQuery(this).attr('data-col-width'))

					}
				);
			$('.overall-label-size button').click(
				function()
					{
					$('.overall-label-size button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
					
					var get_label = $('#collapseFormsCanvas .nex-forms-container label');
					get_label.removeClass('text-lg').removeClass('text-sm');
					
					if($(this).hasClass('small'))
						get_label.addClass('text-sm');
					if($(this).hasClass('large'))
						get_label.addClass('text-lg');
					}
				);
			
				
			//INPUT WIDTH
			$('.overall-input-width button').click(
				function()
					{	
					
					$('.overall-input-width button').removeClass('btn-primary');
					$(this).addClass('btn-primary');
									
					var get_input = $('#collapseFormsCanvas .nex-forms-container .input_container');
					get_input.removeClass('full_width');
					get_input.removeClass('col-sm-1');
					get_input.removeClass('col-sm-2');
					get_input.removeClass('col-sm-3');
					get_input.removeClass('col-sm-4');
					get_input.removeClass('col-sm-5');
					get_input.removeClass('col-sm-6');
					get_input.removeClass('col-sm-7');
					get_input.removeClass('col-sm-8');
					get_input.removeClass('col-sm-9');
					get_input.removeClass('col-sm-10');
					get_input.removeClass('col-sm-11');
					get_input.removeClass('col-sm-12');
					
					get_input.addClass(jQuery(this).attr('data-col-width'))

					}
				);
		
		
		
			
		
		jQuery('#overall-label-color').bscolorpicker().on('changeColor', function(ev){
			 $('#collapseFormsCanvas .nex-forms-container label span.the_label').css('color',ev.color.toHex());
			 $('#collapseFormsCanvas .nex-forms-container label span.input-label').css('color',ev.color.toHex());
			 $('#collapseFormsCanvas .nex-forms-container .is_required').css('color',ev.color.toHex());
			});
		
		jQuery('#overall-sub-label-color').bscolorpicker().on('changeColor', function(ev){
			 $('#collapseFormsCanvas .nex-forms-container .sub-text').css('color',ev.color.toHex());
			});
		
			
///////END OVERALL SETTINGS ///////////////////////				
				
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
			 $('#'+current_id).find('.ui-slider-handle').css('color',ev.color.toHex());
			 $('#'+current_id).find('#slider').attr('data-text-color',ev.color.toHex());
			});	
		//Handel border color
			jQuery('#slider-handel-border-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.ui-slider-handle').css('border-color',ev.color.toHex());
			 $('#'+current_id).find('#slider').attr('data-handel-border-color',ev.color.toHex());
			});	
		
		//Handel Background color
			jQuery('#slider-handel-background-color').bscolorpicker().on('changeColor', function(ev){
			 $('#'+current_id).find('.ui-slider-handle').css('background-color',ev.color.toHex());
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
			jQuery(this).removeClass('btn-default').addClass('btn-success');
			var duplication = $('#'+current_id).clone();
			$(duplication).insertAfter($('#'+current_id));
			duplication.attr('id','_' + Math.round(Math.random()*99999));
			duplication.find('.form_field').each(
				function()
					{
					$(this).attr('id','_' + Math.round(Math.random()*99999));
					}
				);
			jQuery(duplication).find('.edit').trigger('click');
			
			if(duplication.hasClass('select') || duplication.hasClass('multi-select'))
				{
				duplication.find('.bootstrap-select').remove();
				duplication.find('select').selectpicker('refresh');
				}
			
			if(duplication.hasClass('md-select'))
				{
				//duplication.find('div.cd-dropdown').remove();
				build_md_select(duplication.find('#cd-dropdown'))
				}
			
		
			
			
			setTimeout(function(){ $('span.copy-field').removeClass('btn-success').addClass('btn-default'); },1000);
			setTimeout(function(){ jQuery('.col2 .admin-panel .panel-heading .btn.glyphicon-hand-down').trigger('click');},300 );
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
			duplication.removeClass('edit-field')
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
	jQuery('.field_settings .btn.delete').live('click',
		function()
			{
			jQuery(this).closest('.form_field').fadeOut('fast',
			function()
				{
				jQuery(this).remove();	
				}
			);
		}
	);
	jQuery('.step .zero-clipboard .btn.delete').live('click',
		function()
			{
			jQuery(this).closest('.step').fadeOut('fast',
			function()
				{
				jQuery(this).remove();	
				}
			);
		}
	);
	
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
		);
	
	jQuery('#available_fields a').live('click',
		function()
			{
			var class_name = jQuery(this).attr('data-option-value');
			var field_heading = jQuery('.current_field_selection');
			jQuery('.field').hide();	
			jQuery('.field'+class_name).show();	
			if(class_name=='.form_field')
				field_heading.html('&nbsp;&nbsp;All Fields')
			if(class_name=='.grid-system')
				field_heading.html('&nbsp;&nbsp;Grid System')
			if(class_name=='.common-fields')
				field_heading.html('&nbsp;&nbsp;Common Fields')
			if(class_name=='.extended-fields')
				field_heading.html('&nbsp;&nbsp;Extended Fields')
			if(class_name=='.uploader-fields')
				field_heading.html('&nbsp;&nbsp;Uploaders')
			if(class_name=='.custom-fields')
				field_heading.html('&nbsp;&nbsp;Action Fields')
			if(class_name=='.other-elements')
				field_heading.html('&nbsp;&nbsp;Other Elements')
			}
		);
	//CATEGOTRIZE IT
	 var $container = jQuery('#categorize_it_container');

	  $container.categorize_it({
		itemSelector : '.col-sm-6, .col-sm-12'
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
				if($this.hasClass('logic')){}
				
				if($this.hasClass('the-label'))
					{
					$this.attr('data-option-value','.settings-label');
					if(jQuery('#'+current_id).hasClass('md-text'))
						$this.attr('data-option-value','.setting-md-label')
					}
			
				if($this.hasClass('input-element'))
					{
					$this.attr('data-option-value','.settings-input');
					
					if(jQuery('#'+current_id).hasClass('text'))
						$this.attr('data-option-value','.settings-input, .setting-text, .setting-bg-image, .settings-all');
					
					if(jQuery('#'+current_id).hasClass('textarea'))
						$this.attr('data-option-value','.settings-input, .setting-textarea, .setting-bg-image, .settings-all')
					
					if(jQuery('#'+current_id).hasClass('select') || jQuery('#'+current_id).hasClass('classic-select'))
						$this.attr('data-option-value','.settings-input, .setting-select, .settings-all')
					
					if(jQuery('#'+current_id).hasClass('md-select'))
						$this.attr('data-option-value','.setting-select, .settings-all, .setting-md-select')
						
					if(jQuery('#'+current_id).hasClass('multi-select') || jQuery('#'+current_id).hasClass('classic-multi-select'))
						$this.attr('data-option-value','.settings-input, .setting-multi-select, .settings-all')
						
					if(jQuery('#'+current_id).hasClass('radio-group') || jQuery('#'+current_id).hasClass('check-group'))
						$this.attr('data-option-value','.setting-radio, .settings-all')
					if(jQuery('#'+current_id).hasClass('classic-check-group') || jQuery('#'+current_id).hasClass('classic-radio-group'))
						$this.attr('data-option-value','.setting-classic-radio, .settings-all')
						
					if(jQuery('#'+current_id).hasClass('single-image-select-group') || jQuery('#'+current_id).hasClass('multi-image-select-group'))
						$this.attr('data-option-value','.setting-image-select, .settings-all')
						
					if(jQuery('#'+current_id).hasClass('slider'))
						$this.attr('data-option-value','.setting-slider, .settings-all')
						
					if(jQuery('#'+current_id).hasClass('star-rating'))
						$this.attr('data-option-value','.setting-star, .settings-all')
					
					if(jQuery('#'+current_id).hasClass('touch_spinner'))
						$this.attr('data-option-value','.setting-spinner, .settings-input, .setting-bg-image, .settings-all')
						
					if(jQuery('#'+current_id).hasClass('tags'))
						$this.attr('data-option-value','.setting-tags')
						
					if(jQuery('#'+current_id).hasClass('autocomplete'))
						$this.attr('data-option-value','.setting-autocomplete, .settings-input, .setting-bg-image, .settings-all')
					
					if(jQuery('#'+current_id).hasClass('submit-button') || jQuery('#'+current_id).hasClass('classic-submit-button'))
						$this.attr('data-option-value','.setting-button, .setting-bg-image')
					
					if(jQuery('#'+current_id).hasClass('other-elements') && jQuery('#'+current_id).hasClass('grid'))
						$this.attr('data-option-value','.setting-bg-image')
						
					if(jQuery('#'+current_id).hasClass('date') || jQuery('#'+current_id).hasClass('datetime') || jQuery('#'+current_id).hasClass('time'))
						$this.attr('data-option-value','.setting-prefix, .settings-input, .settings-date-time, .setting-bg-image, .settings-all')
					
					if(jQuery('#'+current_id).hasClass('upload-single'))
						$this.attr('data-option-value','.setting-postfix, .settings-input, .setting-text, .settings-all');
					
					if(jQuery('#'+current_id).hasClass('custom-prefix'))
						$this.attr('data-option-value','.setting-prefix, .settings-input, .setting-text, .setting-bg-image, .settings-all')
					
					if(jQuery('#'+current_id).hasClass('custom-postfix'))
						$this.attr('data-option-value','.setting-postfix, .settings-input, .setting-text, .setting-bg-image, .settings-all')
						
					if(jQuery('#'+current_id).hasClass('custom-pre-postfix'))
						$this.attr('data-option-value','.setting-prefix, .setting-postfix, .settings-input, .setting-text, .setting-bg-image, .settings-all')
						
					if(jQuery('#'+current_id).hasClass('paragraph'))
						$this.attr('data-option-value','.setting-paragraph')
					
					if(jQuery('#'+current_id).hasClass('heading'))
						$this.attr('data-option-value','.setting-heading')
						
					if(jQuery('#'+current_id).hasClass('grid'))
						$this.attr('data-option-value','.setting-panel')
						
					if(jQuery('#'+current_id).hasClass('md-text'))
						$this.attr('data-option-value','.setting-md-input, .settings-all')
					
					if(jQuery('#'+current_id).hasClass('grid-system'))
						{	
						if(jQuery('#'+current_id).hasClass('grid-system-1'))
							$this.attr('data-option-value','.settings-col-1')					
						else if(jQuery('#'+current_id).hasClass('grid-system-2'))
							$this.attr('data-option-value','.settings-col-1, .settings-col-2')						
						else if(jQuery('#'+current_id).hasClass('grid-system-3'))
							$this.attr('data-option-value','.settings-col-1, .settings-col-2, .settings-col-3')					
						else if(jQuery('#'+current_id).hasClass('grid-system-4'))
							$this.attr('data-option-value','.settings-col-1, .settings-col-2, .settings-col-3, .settings-col-4')
						else if(jQuery('#'+current_id).hasClass('grid-system-6'))
							$this.attr('data-option-value','.settings-col-1, .settings-col-2, .settings-col-3, .settings-col-4, .settings-col-5, .settings-col-6')
						else
							$this.attr('data-option-value','.setting-grid-system')
						}
					if(jQuery('#'+current_id).hasClass('divider'))
						$this.attr('data-option-value','.setting-divider')
					
					}
				if($this.hasClass('validation'))
					{
					$this.attr('data-option-value','.settings-validation');
					if(jQuery('#'+current_id).hasClass('text') || jQuery('#'+current_id).hasClass('classic-text') || jQuery('#'+current_id).hasClass('custom-prefix') || jQuery('#'+current_id).hasClass('custom-postfix') || jQuery('#'+current_id).hasClass('custom-pre-postfix'))
						$this.attr('data-option-value','.settings-validation, .setting-validation-text');
					
					if(jQuery('#'+current_id).hasClass('textarea') || jQuery('#'+current_id).hasClass('classic-radio'))
						$this.attr('data-option-value','.settings-validation, .setting-validation-textarea')
					
					if(jQuery('#'+current_id).hasClass('upload-image') || jQuery('#'+current_id).hasClass('upload-single'))
						$this.attr('data-option-value','.settings-validation, .setting-validation-file-input')
					
					if(jQuery('#'+current_id).hasClass('md-text'))
						$this.attr('data-option-value','.settings-validation, .settings-validation-md-text')	
						
					}
				
				//jQuery('.editing-field').attr('style','');
				jQuery('.editing-field').removeClass('editing-field')
					/*
					jQuery('#'+current_id).addClass('editing-field');
					
						if($this.hasClass('the-label'))
							jQuery('#'+current_id).find('label').addClass('editing-field')
						if($this.hasClass('input-element'))
							jQuery('#'+current_id).find('.the_input_element').addClass('editing-field')
						if($this.hasClass('help-text'))
							jQuery('#'+current_id).find('.help-block').addClass('editing-field')
*/
						
				
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
							  $container.categorize_it( options );
							}
							
							return false;
						
			  });

	$('div#nex-forms-field-settings  span.close, div#nex-forms-field-settings .delete-field ').live('click',
		function()
			{
			$('.form_field').removeClass('edit-field')
			$('div#nex-forms-field-settings').removeClass('opened')	
			}
			
		);
	});
	
	
	$('#autoRespond select[name="current_fields"]').live('dblclick',
		function(){
			jQuery('#nex_autoresponder_confirmation_mail_body').trigger('focus');
			insertAtCaret('nex_autoresponder_confirmation_mail_body', jQuery(this).val());
		}
	);
	
	$('#nex-forms-field-settings select[name="current_fields"]').live('dblclick',
		function(){
			jQuery('#set_math_logic_equation').trigger('focus');
			insertAtCaret('set_math_logic_equation', jQuery(this).val());
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
function format_font_name(font){
	font = font.toLowerCase();
	font = font.replace(' ','');
	font = font.replace('"','');	
	return font;	
}

function populate_button_settings(obj){
	
	
	jQuery('.button-width button').removeClass('btn-primary');
		if(obj.hasClass('full_width'))
			jQuery('.button-width  button.full_button').addClass('btn-primary');	
		else
			jQuery('.button-width button.normal').addClass('btn-primary');
	
}


function populate_label_settings(obj){

		//Alingment
		jQuery('.align-label button').removeClass('btn-primary');
		if(obj.parent().hasClass('align_left'))
			jQuery('.align-label button.left').addClass('btn-primary');	
		else if(obj.parent().hasClass('align_right'))
			jQuery('.align-label button.right').addClass('btn-primary');
		else if(obj.parent().hasClass('align_center'))
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
			jQuery('.show-label button.inside').addClass('btn-primary');
		else if(obj.parent().hasClass('col-sm-12'))
			jQuery('.show-label button.top').addClass('btn-primary');
		else
			jQuery('.show-label button.left').addClass('btn-primary');
		
		//Size	
		jQuery('.label-size button').removeClass('btn-primary');
		if(obj.hasClass('text-lg'))
			jQuery('.label-size button.large').addClass('btn-primary');
		else if(obj.hasClass('text-sm'))
			jQuery('.label-size button.small ').addClass('btn-primary');
		else
			jQuery('.label-size button.normal').addClass('btn-primary');
			
		//Label Color
		//jQuery('#label-color').bscolorpicker('setValue',colorToHex(obj.find('span.the_label').css('color')))
		//Sub label Color
		//jQuery('#label-subtext').bscolorpicker('setValue',colorToHex(obj.find('small.sub-text').css('color')))
}

function populate_input_settings(obj){	
	//Required
	jQuery('.required button').removeClass('btn-primary');
	if(obj.closest('.form_field').hasClass('required'))
		jQuery('.required button.yes').addClass('btn-primary');
	else
		jQuery('.required button.no').addClass('btn-primary');
	//validatation
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
	if(obj.hasClass('input-lg') || obj.hasClass('btn-lg'))
		jQuery('.input-size button.large').addClass('btn-primary');
	else if(obj.hasClass('input-sm') || obj.hasClass('btn-sm'))
		jQuery('.input-size button.small').addClass('btn-primary');
	else
		jQuery('.input-size button.normal').addClass('btn-primary');
		
	//Text Color
	//jQuery('#input-color').bscolorpicker('setValue',colorToHex(obj.css('color')))
	//Background color
	//jQuery('#input-bg-color').bscolorpicker('setValue',colorToHex(obj.css('background-color')))
	//Border color
	//jQuery('#input-border-color').bscolorpicker('setValue',colorToHex(obj.css('border-top-color')))
	//Border color on focus
	//jQuery('#input-onfocus-color').bscolorpicker('setValue',colorToHex(obj.attr('data-onfocus-color')))	
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
	//jQuery('#help-text-color').bscolorpicker('setValue',colorToHex(obj.css('color')))
}

function populate_panel_settings(obj){
	//heading Color
	//jQuery('#panel_heading_color').bscolorpicker('setValue',colorToHex(obj.find('.panel-heading').css('color')))
	//heading background
	//jQuery('#panel_heading_background').bscolorpicker('setValue',colorToHex(obj.find('.panel-heading').css('background-color')))
	//Body Background
	//jQuery('#panel_body_background').bscolorpicker('setValue',colorToHex(obj.find('.panel-body').css('background-color')))
	//Border Color
	//jQuery('#panel_border_color').bscolorpicker('setValue',colorToHex(obj.css('border-top-color')))
	
	//Bold
	
	
	//jQuery('.panel-head-bold').removeClass('label-primary');
	
	jQuery('.show-panel-heading button').removeClass('btn-primary');
	
	if(obj.find('.panel-heading').css('display')=='none')
		jQuery('.show-panel-heading button.no').addClass('btn-primary');
	else
		jQuery('.show-panel-heading button.yes').addClass('btn-primary');
	
	
	jQuery('.panel-background-size button').removeClass('btn-primary');
	
	if(obj.find('.panel-body').css('background-size')=='cover')
		jQuery('.panel-background-size button.cover').addClass('btn-primary');
	else if(obj.find('.panel-body').css('background-size')=='contain')
		jQuery('.panel-background-size button.contain').addClass('btn-primary');
	else
		jQuery('.panel-background-size button.auto').addClass('btn-primary');
		
		
	jQuery('.panel-background-position button').removeClass('btn-primary');
	if(obj.find('.panel-body').css('background-position')=='right')
		jQuery('.panel-background-position button.right').addClass('btn-primary');
	else if(obj.find('.panel-body').css('background-position')=='left')
		jQuery('.panel-background-position button.left').addClass('btn-primary');
	else
		jQuery('.panel-background-size button.center').addClass('btn-primary');
		
	
	jQuery('.panel-background-repeat button').removeClass('btn-primary');
	if(obj.find('.panel-body').css('background-repeat')=='cover')
		jQuery('.panel-background-repeat button.repeat-y').addClass('btn-primary');
	else if(obj.find('.panel-body').css('background-repeat')=='repeat-x')
		jQuery('.panel-background-repeat button.repeat-x').addClass('btn-primary');
	else if(obj.find('.panel-body').css('background-repeat')=='repeat')
		jQuery('.panel-background-repeat button.repeat').addClass('btn-primary');
	else
		jQuery('.panel-background-repeat button.no-repeat').addClass('btn-primary');
	
		
			var image = obj.find('.panel-body').css('background-image');
			var image2 = image.replace( 'url("','');
			var image3 = image2.replace( '")','');
			
			//jQuery('#do-upload-image .fileinput-preview').prepend('<img src="'+ image3 +'">');
			//jQuery('#do-upload-image .fileinput-exists').show();
			
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
	//jQuery('#radio-label-color').bscolorpicker('setValue',colorToHex(obj.find('.input-label').css('color')))
	
	jQuery('.setting-radio.icons span#radio-icon').attr('class','current-icon fa '+ obj.attr('data-checked-class'));
	jQuery('.setting-radio.icons .icon_set li').removeClass('btn-primary');
	//jQuery('.setting-radio.icons .icon_set li.'+obj.attr('data-checked-class')).addClass('btn-primary');
	
	jQuery('.radio-color-class i').attr('class',obj.attr('data-checked-color'));
	jQuery('.selected-radio-color li').removeClass('selected');
	//jQuery('.selected-radio-color li a.'+obj.attr('data-checked-color')).parent().addClass('selected');	
	
	
	jQuery('.thumb-size button').removeClass('btn-primary');
	if(obj.hasClass('thumb-lg'))
		jQuery('.thumb-size button.large').addClass('btn-primary');
	else if(obj.hasClass('thumb-sm'))
		jQuery('.thumb-size button.small').addClass('btn-primary');
	else if(obj.hasClass('thumb-xlg'))
		jQuery('.thumb-size button.xlarge').addClass('btn-primary');
	else
		jQuery('.thumb-size button.normal').addClass('btn-primary');
			
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
	//jQuery('#slide-handel-text-color').bscolorpicker('setValue',colorToHex(obj.attr('data-text-color')));
	//jQuery('#slider-handel-background-color').bscolorpicker('setValue',colorToHex(obj.attr('data-handel-background-color')));
	//jQuery('#slider-handel-border-color').bscolorpicker('setValue',colorToHex(obj.attr('data-handel-border-color')));
	//slide
	//jQuery('#slider-background-color').bscolorpicker('setValue',colorToHex(obj.attr('data-background-color')));
	//jQuery('#slider-border-color').bscolorpicker('setValue',colorToHex(obj.attr('data-slider-border-color')));
	//jQuery('#slider-fill-color').bscolorpicker('setValue',colorToHex(obj.attr('data-fill-color')));	
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
	
	//jQuery('#tags-text-color').bscolorpicker('setValue',colorToHex(obj.attr('data-text-color')));
	//jQuery('#tags-border-color').bscolorpicker('setValue',colorToHex(obj.attr('data-border-color')));
	//jQuery('#tags-background-color').bscolorpicker('setValue',colorToHex(obj.attr('data-background-color')));	
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


function populate_grid_system_settings(obj){
	
	
	
	for(var i=0;i<=5;i++)
		{
		jQuery('.col-'+(i+1)+'-width button').removeClass('btn-primary');
		var grid_col = obj.find('.row .grid_input_holder:eq('+i+')');
		if(grid_col)
			{
			var grid_class = grid_col.attr('class');
			if(grid_class)
				var grid_class2 = grid_class.replace('grid_input_holder','');
			if(grid_class2)
				var grid_class3 = grid_class2.replace('-sm','');
			if(grid_class3)
				{
				jQuery('.col-'+(i+1)+'-width button.'+grid_class3.trim()).addClass('btn-primary');
				}
			}
		}
}

function populate_label_width_settings(obj){
	
		jQuery('.label-width button').removeClass('btn-primary');
		var label = obj.find('.label_container');
		if(label)
			{
			var label_class = label.attr('class');
			if(label_class)
				var label_class2 = label_class.replace('label_container','').replace('align_left','').replace('align_center','').replace('align_right','').replace('full_width','');
			if(label_class2)
				var label_class3 = label_class2.replace('-sm','');
			if(label_class3)
				{
				jQuery('.label-width button.'+label_class3.trim()).addClass('btn-primary');
				}
			}
}

function populate_input_width_settings(obj){
	
		jQuery('.input-width button').removeClass('btn-primary');
		var input = obj.find('.input_container');
		if(input)
			{
			var input_class = input.attr('class');
			if(input_class)
				var input_class2 = input_class.replace('input_container','');
			if(input_class2)
				var input_class3 = input_class2.replace('-sm','');
			if(input_class3)
				{
				jQuery('.input-width button.'+input_class3.trim()).addClass('btn-primary');
				}
			}
}



function populate_logic(obj_id){
	var output2 = '';
	var output = '<button style="margin-bottom:15px; !important" class="add_condition btn btn-primary"><span class="fa fa-plus">&nbsp;</span> Add Condition</button>';
		
	if(jQuery('#'+obj_id).hasClass('select') || jQuery('#'+obj_id).hasClass('radio-group'))
		output += '<div class="input_holder field_condition_template hidden"><div class="row"><div class="col-xs-4"><label>If the selected option is: <em class="setcondition"></em></label></div><div class="col-xs-3"><label>Action <em class="setaction"></em></label></div><div class="col-xs-3"><label>Target:<em class="targetname"></em></label></div><div class="col-xs-2"></div></div><div class="row"><div class="col-xs-4"><div class="">';
	else
		output += '<div class="input_holder field_condition_template hidden"><div class="row"><div class="col-xs-4"><label>If this field\'s value is: <em class="setcondition"></em></label></div><div class="col-xs-3"><label>Action <em class="setaction"></em></label></div><div class="col-xs-3"><label>Target:<em class="targetname"></em></label></div><div class="col-xs-2"></div></div><div class="row"><div class="col-xs-4"><div class="input-group">';
		
		if(!jQuery('#'+obj_id).hasClass('select') && !jQuery('#'+obj_id).hasClass('radio-group'))
			{
			output += '<div class="input-group-btn">';
			
			output += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>';
			
			output += '<ul class="dropdown-menu set_conditional_action" role="menu">';
			output += '<li><a href="#">Equal to</a></li>';
			output += '<li><a href="#">Greater than</a></li>';
			output += '<li><a href="#">Less than</a></li>';
			output += '</ul>';
			output += '</div><!-- /btn-group -->';
			}
		if(jQuery('#'+obj_id).hasClass('select') || jQuery('#'+obj_id).hasClass('radio-group') || jQuery('#'+obj_id).hasClass('single-image-select-group'))
				{
				var get_select = jQuery('#'+obj_id).find('select');
				
					output += '<select name="set_conditional_value" class="form-control">';
					
					if(jQuery('#'+obj_id).hasClass('select'))
						{
						jQuery(get_select).find('option').each(
							function()
								{
								output += '<option value="'+jQuery(this).text()+'">'+jQuery(this).text()+'</option>';	
								}
							);
						}
					if(jQuery('#'+obj_id).hasClass('radio-group') || jQuery('#'+obj_id).hasClass('single-image-select-group'))
						{
						jQuery('#'+obj_id).find('input[type="radio"]').each(
							function()
								{
								output += '<option value="'+jQuery(this).val()+'">'+jQuery(this).val()+'</option>';	
								}
							);
						}
					output += '</select>';
				}
		else
			output += '<input type="text" name="set_conditional_value" class="form-control">';
	output += '</div><!-- /input-group -->';
	output += '</div><div class="col-xs-3"><select name="con_action" class="form-control"><option value="show">Show</option><option value="hide">Hide</option><option value="slideDown">Slide Down (shows)</option><option value="slideUp">Slide Up (hides)</option><option value="fadeIn">Fade In (shows)</option><option value="fadeOut">Fade Out (hides)</option></select></div><div class="col-xs-3"><div class="dropdown"><button class="make_con_selection btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">Select Target</button><ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1"><li><a href="#" class="target_field target_type_field">Select Field</a></li><li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="target_field target_type_panel">Select Panel</a></li></ul></div></div><div class="col-xs-1"><button class="btn btn-danger form-control remove_condition"><span class="glyphicon glyphicon-remove"></span></button></div></div></div>';
	
jQuery('.nex-forms-container .field_'+obj_id).each(
	function()
		{
		var get_id = jQuery(this).attr('id');
		var set_id = get_id.replace('con_','');
		
		var con_value = jQuery(this).attr('data-value');

		if(jQuery('#'+obj_id).hasClass('select') || jQuery('#'+obj_id).hasClass('radio-group'))
			output2 += '<div class="input_holder field_condition" id="'+ set_id +'"><div class="row"><div class="col-xs-4"><label>If the selected option is: </label></div><div class="col-xs-3"><label>Action: <em class="setaction"></em></label></div><div class="col-xs-3"><label>Target:<em class="targetname" data-target-id="'+ jQuery(this).attr('data-target') +'">'+ jQuery(this).attr('data-target-name') +'</em></label></div><div class="col-xs-2"></div></div><div class="row"><div class="col-xs-4"><div class="">';
		else
			output2 += '<div class="input_holder field_condition" id="'+ set_id +'"><div class="row"><div class="col-xs-4"><label>If this field\'s value is: <em class="setcondition">'+ jQuery(this).attr('data-condition') +'</em></label></div><div class="col-xs-3"><label>Action: <em class="setaction"></em></label></div><div class="col-xs-3"><label>Target:<em class="targetname" data-target-id="'+ jQuery(this).attr('data-target') +'">'+ jQuery(this).attr('data-target-name') +'</em></label></div><div class="col-xs-2"></div></div><div class="row"><div class="col-xs-4"><div class="input-group">';
		
		if(!jQuery('#'+obj_id).hasClass('select') && !jQuery('#'+obj_id).hasClass('radio-group'))
			{
			output2 += '<div class="input-group-btn">';
			output2 += '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>';
			output2 += '<ul class="dropdown-menu set_conditional_action" role="menu">';
			output2 += '<li><a href="#">Equal to</a></li>';
			output2 += '<li><a href="#">Greater than</a></li>';
			output2 += '<li><a href="#">Less than</a></li>';
			output2 += '</ul>';
			output2 += '</div><!-- /btn-group -->';
			}
		if(jQuery('#'+obj_id).hasClass('select') || jQuery('#'+obj_id).hasClass('radio-group'))
			{
			var get_select = jQuery('#'+obj_id).find('select');
			
				output2 += '<select name="set_conditional_value" class="form-control">';
				
				if(jQuery('#'+obj_id).hasClass('select'))
					{
					jQuery(get_select).find('option').each(
						function()
							{
							output2 += '<option value="'+jQuery(this).text()+'" '+ ((con_value==jQuery(this).val()) ? 'selected="selected"' : ''  ) +'>'+jQuery(this).text()+'</option>';	
							}
						);
					}
				if(jQuery('#'+obj_id).hasClass('radio-group'))
					{
					jQuery('#'+obj_id).find('input[type="radio"]').each(
						function()
							{
							output2 += '<option value="'+jQuery(this).val()+'" '+ ((con_value==jQuery(this).val()) ? 'selected="selected"' : ''  ) +'>'+jQuery(this).val()+'</option>';	
							}
						);
					}
				output2 += '</select>';
			}
		else
			output2 += '<input type="text" name="set_conditional_value" class="form-control" value="'+ ((jQuery(this).attr('data-value')) ? jQuery(this).attr('data-value') : '') +'">';
		output2 += '</div><!-- /input-group -->';
		output2 += '</div><div class="col-xs-3"><select name="con_action" class="form-control"><option value="show" '+ ((jQuery(this).attr('data-action')=='show') ? 'selected="selected"' : '') +'>Show</option><option value="hide" '+ ((jQuery(this).attr('data-action')=='hide') ? 'selected="selected"' : '') +'>Hide</option><option value="slideDown" '+ ((jQuery(this).attr('data-action')=='slideDown') ? 'selected="selected"' : '') +'>Slide Down (shows)</option><option value="slideUp" '+ ((jQuery(this).attr('data-action')=='slideUp') ? 'selected="selected"' : '') +'>Slide Up (hides)</option><option value="fadeIn" '+ ((jQuery(this).attr('data-action')=='fadeIn') ? 'selected="selected"' : '') +'>Fade In (shows)</option><option value="fadeOut" '+ ((jQuery(this).attr('data-action')=='fadeOut') ? 'selected="selected"' : '') +'>Fade Out (hides)</option></select></div><div class="col-xs-3"><div class="dropdown"><button class="make_con_selection btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">Select Target</button><ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1"><li><a href="#" class="target_field target_type_field">Select Field</a></li><li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="target_field target_type_panel">Select Panel</a></li></ul></div></div><div class="col-xs-1"><button class="btn btn-danger form-control remove_condition"><span class="glyphicon glyphicon-remove"></span></button></div></div></div>';
		}
	);
	jQuery('.settings-logic').html(output+output2);
}
var status = 0;
function loading_nex_forms(){	 
	setTimeout
		(
		function()
			{
			jQuery('.progress-bar-primary').attr('style','width:'+status+'%');
			}
		,90);
	status += 1;	
	if(status<=100)
	loading_nex_forms();
}

/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 * 
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

( function( window ) {

'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

function classReg( className ) {
  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
}

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
var hasClass, addClass, removeClass;

if ( 'classList' in document.documentElement ) {
  hasClass = function( elem, c ) {
    return elem.classList.contains( c );
  };
  addClass = function( elem, c ) {
    elem.classList.add( c );
  };
  removeClass = function( elem, c ) {
    elem.classList.remove( c );
  };
}
else {
  hasClass = function( elem, c ) {
    return classReg( c ).test( elem.className );
  };
  addClass = function( elem, c ) {
    if ( !hasClass( elem, c ) ) {
      elem.className = elem.className + ' ' + c;
    }
  };
  removeClass = function( elem, c ) {
    elem.className = elem.className.replace( classReg( c ), ' ' );
  };
}

function toggleClass( elem, c ) {
  var fn = hasClass( elem, c ) ? removeClass : addClass;
  fn( elem, c );
}

var classie = {
  // full names
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  toggleClass: toggleClass,
  // short names
  has: hasClass,
  add: addClass,
  remove: removeClass,
  toggle: toggleClass
};

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( classie );
} else {
  // browser global
  window.classie = classie;
}

})( window );
