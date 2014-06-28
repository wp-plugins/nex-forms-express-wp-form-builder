var the_field ='';
//var z_index = 1000;
jQuery(document).ready(
function()
	{
	
	run_animation();	
			
		
	}
	);
function IsSafari() {

  var is_safari = navigator.userAgent.toLowerCase().indexOf('safari/') > -1;
 
  if(navigator.userAgent.toLowerCase().indexOf('chrome/') >-1)
  	is_safari = false;
  if(navigator.userAgent.toLowerCase().indexOf('opera/') >-1)
  	is_safari = false;
	
  return is_safari;

}
function run_animation(){

			jQuery('div.ui-nex-forms-container').html(jQuery('div.nex-forms-container').html())
			
			jQuery('div.ui-nex-forms-container div#the-radios input').prop('checked',false);
			jQuery('div.ui-nex-forms-container div#the-radios a').attr('class','');


			
			//jQuery('div.ui-nex-forms-container').prepend('<i class="fake_loader fa fa-spinner fa-spin"></i>');
			jQuery('div.ui-nex-forms-container .form_field').each(
				function()
					{
					setup_ui_element(jQuery(this));
					}
				);
					
			jQuery('div.ui-nex-forms-container').css('visibility','visible');
}


function setup_ui_element(obj){
	
	jQuery('div.ui-nex-forms-container .editing-field').removeClass('editing-field')
	jQuery('div.ui-nex-forms-container').find('div.trash-can').remove();
	jQuery('div.ui-nex-forms-container').find('div.draggable_object').hide();
	jQuery('div.ui-nex-forms-container').find('div.draggable_object').remove();
	jQuery('div.ui-nex-forms-container').find('div.form_object').show();
	jQuery('div.ui-nex-forms-container').find('div.form_field').removeClass('field');
	obj.removeClass('field');
	//obj.attr('id','');
	
	jQuery('div.ui-nex-forms-container').find('.bs-tooltip').tooltip();
	
	if(obj.hasClass('text') || obj.hasClass('textarea'))
		obj.find('.the_input_element').val(obj.find('.the_input_element').attr('data-default-value'));
	
	if(obj.hasClass('upload-single')){obj.remove();}
	if(obj.hasClass('upload-image')){obj.remove();}
	if(obj.hasClass('custom-prefix')){obj.remove();}
	if(obj.hasClass('custom-postfix')){obj.remove();}
	if(obj.hasClass('custom-pre-postfix')){obj.remove();}
	if(obj.hasClass('datetime')){obj.remove();}
	if(obj.hasClass('date')){obj.remove();}
	if(obj.hasClass('time')){obj.remove();}	
	if(obj.hasClass('touch_spinner')){ obj.remove();}
	if(obj.hasClass('color_pallet')){obj.remove();}
	if(obj.hasClass('slider')){obj.remove();}			
	if(obj.hasClass('star-rating')){obj.remove();}	
	if(obj.hasClass('tags')){obj.remove();}	
	if(obj.hasClass('autocomplete')){obj.remove();}
	
	
}