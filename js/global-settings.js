jQuery(document).ready(
function()
	{
		
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
		
		jQuery('#script_config2').ajaxForm({
			data: {
			   action: 'save_script_config2'
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
		
		
		jQuery('#import_form_html').ajaxForm({
			data: {
			   action: 'import_form_html'
			},
			//dataType: 'json',
			beforeSubmit: function(formData, jqForm, options) {
				alert('test');
				//console.log($('input[name="do_image_upload_preview"]').val())
				//jQuery('#script_config button').html('&nbsp;&nbsp;&nbsp;<span class="fa fa-spin fa-spinner"></span>&nbsp;Saving...&nbsp;&nbsp;&nbsp;')
			},
		   success : function(responseText, statusText, xhr, $form) {
			  // jQuery('#script_config button').html('&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;');
			  // jQuery('#script_config .alert').first().slideDown('slow');
			   
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