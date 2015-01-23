jQuery(document).ready(
function()
	{
	jQuery('.open_nex_forms_popup').click(
		function(e)
			{
			e.preventDefault();
			jQuery('#nexForms_popup_'+jQuery(this).attr('data-popup-id')).modal().appendTo('body');
			}
		)
	jQuery('.ui-state-default').live('mouseover',
		function()
			{
			jQuery(this).addClass('ui-state-hover');
			}
		);
	jQuery('.ui-state-default').live('mouseleave',
		function()
			{
			jQuery(this).removeClass('ui-state-hover');
			}
		);

	jQuery('div.ui-nex-forms-container .zero-clipboard, div.ui-nex-forms-container .field_settings').remove();
	jQuery('div.ui-nex-forms-container .step').remove()
	jQuery('div.ui-nex-forms-container .grid').remove()
	jQuery('div.ui-nex-forms-container .touch_spinner').remove()
	jQuery('div.ui-nex-forms-container .color_pallet').remove()
	jQuery('div.ui-nex-forms-container .slider').remove()
	jQuery('div.ui-nex-forms-container .star-rating').remove()
	jQuery('div.ui-nex-forms-container .select').remove()
	jQuery('div.ui-nex-forms-container .multi-select').remove()
	jQuery('div.ui-nex-forms-container .tags').remove()
	jQuery('div.ui-nex-forms-container .autocomplete').remove()
	jQuery('div.ui-nex-forms-container .radio-group').remove()
	jQuery('div.ui-nex-forms-container .check-group').remove()
	jQuery('div.ui-nex-forms-container .heading').remove()
	jQuery('div.ui-nex-forms-container .paragraph').remove()
	jQuery('div.ui-nex-forms-container .divider').remove()
	jQuery('div.ui-nex-forms-container .upload-single').remove()
	jQuery('div.ui-nex-forms-container .upload-image').remove()
	jQuery('div.ui-nex-forms-container .custom-prefix').remove()
	jQuery('div.ui-nex-forms-container .custom-postfix').remove()
	jQuery('div.ui-nex-forms-container .custom-pre-postfix').remove()
	jQuery('div.ui-nex-forms-container .date').remove()
	jQuery('div.ui-nex-forms-container .time').remove()
	jQuery('div.ui-nex-forms-container .date-time').remove()
	jQuery('div.ui-nex-forms-container .nex-step').remove()
	jQuery('div.ui-nex-forms-container .prev-step').remove()
	
 	jQuery('div.ui-nex-forms-container .grid').removeClass('grid-system')
	jQuery('div.ui-nex-forms-container .editing-field-container').removeClass('.editing-field-container')
	
	jQuery('div.ui-nex-forms-container .editing-field').removeClass('editing-field')
	jQuery('div.ui-nex-forms-container .editing-field-container').removeClass('.editing-field-container')
	jQuery('div.ui-nex-forms-container').find('div.trash-can').remove();
	jQuery('div.ui-nex-forms-container').find('div.draggable_object').hide();
	jQuery('div.ui-nex-forms-container').find('div.draggable_object').remove();
	jQuery('div.ui-nex-forms-container').find('div.form_object').show();
	jQuery('div.ui-nex-forms-container').find('div.form_field').removeClass('field');
	
	jQuery('div.ui-nex-forms-container .tab-pane').removeClass('tab-pane');

	jQuery('div.ui-nex-forms-container .form_field').each(
		function(index)
			{
			jQuery(this).css('z-index',1000-index)
			setup_ui_element(jQuery(this));
			}
		);	
	jQuery('.the_input_element').addClass('ui-state-default')
	}
);
function setup_ui_element(obj){
	jQuery('div.ui-nex-forms-container').find('.bs-tooltip').tooltip();
	if(obj.hasClass('text') || obj.hasClass('textarea'))
		obj.find('.the_input_element').val(obj.find('.the_input_element').attr('data-default-value'));	
}