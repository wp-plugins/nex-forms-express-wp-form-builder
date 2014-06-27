var the_field ='';
//var z_index = 1000;
jQuery(document).ready(
function()
	{
	
	run_animation();	
		jQuery('#star img').live('click',
		function()
			{
			jQuery(this).parent().find('input').trigger('change');
			}
		);		
	
	jQuery('.bootstrap-touchspin-down, bootstrap-touchspin-up').live('click',
		function()
			{
			jQuery(this).parent().parent().find('input').trigger('change');
			}
		);	
			
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
			jQuery('div.ui-nex-forms-container #slider').html('');
			jQuery('div.ui-nex-forms-container #star' ).raty('destroy');
			jQuery('div.ui-nex-forms-container .bootstrap-touchspin-prefix').remove();
			jQuery('div.ui-nex-forms-container .bootstrap-select').remove();
			jQuery('div.ui-nex-forms-container .bootstrap-touchspin-postfix').remove();
			jQuery('div.ui-nex-forms-container .bootstrap-touchspin .input-group-btn').remove();
			jQuery('div.ui-nex-forms-container .bootstrap-tagsinput').remove();
			jQuery('div.ui-nex-forms-container div#the-radios input').prop('checked',false);
			jQuery('div.ui-nex-forms-container div#the-radios a').attr('class','');

			if((jQuery('div.run_animation').html()=='true' || jQuery('div.run_animation').html()=='truetrue') && !IsSafari())
				{
				jQuery('div.ui-nex-forms-container .svg_ready').addClass('do_hide');
				jQuery('div.ui-nex-forms-container label#title').hide();
				jQuery('div.ui-nex-forms-container .help-block').hide();
				}
			else{
				jQuery('div.ui-nex-forms-container').css('visibility','visible');
				jQuery('label#title').show();
				jQuery('.help-block').show();	
			}
			//jQuery('div.ui-nex-forms-container').prepend('<i class="fake_loader fa fa-spinner fa-spin"></i>');
			jQuery('div.ui-nex-forms-container .form_field').each(
				function()
					{
					setup_ui_element(jQuery(this));
					//jQuery(this).addClass('animated');
					//jQuery(this).attr('data-animation-delay','1000');
					//jQuery(this).attr('data-animation','fadeInLeft')
					if((jQuery('div.run_animation').html()=='true' || jQuery('div.run_animation').html()=='truetrue') && !IsSafari())
						{
						jQuery('div.ui-nex-forms-container .selectpicker').addClass('do_hide');
						jQuery('div.ui-nex-forms-container .bootstrap-touchspin').addClass('do_hide');
						jQuery('div.ui-nex-forms-container .bootstrap-tagsinput').addClass('do_hide');
						}
					if(jQuery(this).hasClass('text') || jQuery(this).hasClass('textarea'))
						{
						//console.log('text');
						if(jQuery(this).find('.the_input_element').attr('data-maxlength-show')=='true')
							jQuery(this).find('.the_input_element').maxlength({ placement:(jQuery(this).find('.the_input_element').attr('data-maxlength-position')) ? jQuery(this).find('.the_input_element').attr('data-maxlength-position') : 'bottom', alwaysShow: true , set_ID: jQuery(this).attr('id'), warningClass: 'label '+ jQuery(this).find('.the_input_element').attr('data-maxlength-color') });
						}
					
					}
				);
					
	if((jQuery('div.run_animation').html()=='true' || jQuery('div.run_animation').html()=='truetrue') && !IsSafari())
		{	
		setTimeout(
			function()
				{		
				jQuery('div.ui-nex-forms-container .fake_loader').remove();
				  
				  
				 jQuery('div.ui-nex-forms-container div.form_field').each(
					function()
					{
					var get_span 			= jQuery(this).find('span');
					var get_input 			= jQuery(this).find('input');
					
					var input_offset 		= 0;
					var span_offset 		= get_input.offset();
					
					var set_input_height 	= (get_input.outerHeight()-11);
					var set_input_width 	= (get_input.outerWidth()+get_span.outerWidth()-15);
					
					var set_span_height 	= (get_span.outerHeight()-12);
					var set_span_width 		= (get_span.outerWidth()-11);
					
					//Drawing input with no PRE-Suffix
					if(jQuery(this).hasClass('text') || jQuery(this).hasClass('autocomplete') )
						{
						jQuery('<svg id="demo-input-1" style="top:'+ input_offset.top  +'px;left:'+ input_offset.left +'px;" class="line-drawing" width="'+ (set_input_width+40) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input);
						}
					if(jQuery(this).hasClass('submit-button'))
						{
						var get_input = jQuery(this).find('.nex-submit');
						var set_input_height 	= (get_input.outerHeight()-11);
						var set_input_width 	= (get_input.outerWidth()+get_span.outerWidth()-15);						
						var set_pos = get_input.css('margin-left');
						if(get_input.hasClass('align_right'))
							set_pos = (get_input.parent().outerWidth() - get_input.outerWidth()) + 'px';
						if(get_input.hasClass('align_center'))
							set_pos = (get_input.parent().outerWidth()/2 - get_input.outerWidth()/2) + 'px';	
						
						jQuery('<svg id="demo-input-1" style="left:'+ set_pos +'" class="line-drawing" width="'+ (set_input_width+40) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input);
						}
					if(jQuery(this).hasClass('textarea'))
						{
						var get_input 			= jQuery(this).find('textarea');
						var set_input_height 	= (get_input.outerHeight()-11);
						var set_input_width 	= (get_input.outerWidth()+get_span.outerWidth()-15);
						jQuery('<svg id="demo-input-1" style="top:'+ input_offset.top  +'px;left:'+ input_offset.left +'px;" class="line-drawing" width="'+ (set_input_width+40) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input);
						}
					if(jQuery(this).hasClass('select') || jQuery(this).hasClass('multi-select'))
						{
						var get_input 			= jQuery(this).find('.the_input_element');
						var set_input_height 	= (get_input.outerHeight()-11);
						var set_input_width 	= (get_input.outerWidth()+get_span.outerWidth()-15);
						jQuery('<svg id="demo-input-1" style="top:'+ input_offset.top  +'px;left:'+ input_offset.left +'px;" class="line-drawing" width="'+ (set_input_width+40) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(jQuery(this).find('select'));
						}
					else if(jQuery(this).hasClass('radio-group'))
						{
						jQuery(this).find('input').each(
						function()
								{
								jQuery('<svg id="demo-input-1" style="" class="line-drawing" width="300" height="100" xmlns="http://www.w3.org/2000/svg"><path id="the_path" d="M 20,10.5 C 20,15.75 15.75,20.25 10.25,20.25 5,20.25 0.625,15.75 0.625,10.25 0.625, 5 5,0.5 10.25,0.5 c 5.25,0 9.75,4.25 9.75,9.75z" class="darker" style="stroke-dasharray: 100, 100; stroke-dashoffset: 0;"/></svg>').insertAfter(jQuery(this).closest('span.svg_ready'));	
								}
							);
						}
					else if(jQuery(this).hasClass('check-group'))
						{
						jQuery(this).find('a').each(
						function()
								{
								var get_input 			= jQuery(this);
								var set_input_height 	= (get_input.outerHeight()-12);
								var set_input_width		= (get_input.outerWidth()-11);
								jQuery('<svg id="demo-input-1" style="" class="line-drawing" width="'+ (set_input_width+20) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(jQuery(this).closest('span.svg_ready'));
								}
							);
						}
					else if(jQuery(this).hasClass('star-rating'))
						{
						var count = 1;
						jQuery(this).find('img').each(
						function(index)
								{
								count 					= 27*index;
								var get_input 			= jQuery(this);
								var set_input_height 	= (get_input.outerHeight()-3);
								var set_input_width 	= (get_input.outerWidth()-4);
								jQuery(this).parent().parent().append('<svg id="demo-input-1" style="top:0px;left:'+ count +'px;" class="line-drawing" width="200" height="200" xmlns="http://www.w3.org/2000/svg"><path id="the_path" fill="none" stroke="#000" d="m12.5,0.5 3,8.5h9l-7,5.5 2.5,8.5-7.5-5-7.5,5 2.5-8.5-7-5.5h9z"/></svg>');
								}
							);
						}
					else if(jQuery(this).hasClass('slider'))
						{
						jQuery(this).find('#slider').each(
						function()
								{
								var get_input 			= jQuery(this);
								var set_input_height 	= (get_input.outerHeight()-12);
								var set_input_width 	= (get_input.outerWidth()-4);
								jQuery('<svg id="demo-input-1" style="top:0px;" class="line-drawing" width="'+ (set_input_width+20) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(jQuery(this));
								
								var get_handel 			= jQuery(this).find('.ui-slider-handle');
								var set_handel_height 	= (get_handel.outerHeight()-12);
								get_handel.attr('data-svg',"demo-input-1")
								var set_handel_width 	= (get_handel.outerWidth()-12);
								jQuery('<svg id="demo-input-1" style="top:-10px;left:'+ get_handel.css('left')  +'" class="line-drawing" width="'+ (set_handel_width+20) +'" height="'+ (set_handel_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_handel_width +',0 c 2,0 5,2 5,5 l 0,'+ set_handel_height +' c 0,2 -2,5 -5,5 l -'+ set_handel_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_handel_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(jQuery(this));
								}
							);
						}
					if(jQuery(this).hasClass('touch_spinner'))
						{
						var get_input 			= jQuery(this).find('.bootstrap-touchspin');
						var set_input_height 	= (get_input.outerHeight()-11);
						var set_input_width 	= (get_input.outerWidth()-12);
						jQuery('<svg id="demo-input-1" style="top:'+ input_offset.top  +'px;left:'+ input_offset.left +'px;" class="line-drawing" width="'+ (set_input_width+40) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input);
						
						var get_touch_up 			= jQuery(this).find('.bootstrap-touchspin-up');
						var set_touch_up_height 	= (get_touch_up.outerHeight()-11);
						var set_touch_up_width 		= (get_touch_up.outerWidth()-12);
						jQuery('<svg id="demo-input-1" style="left:'+ (set_input_width-set_touch_up_width) +'px;" class="line-drawing" width="'+ (set_touch_up_width+40) +'" height="'+ (set_touch_up_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_touch_up_width +',0 c 2,0 5,2 5,5 l 0,'+ set_touch_up_height +' c 0,2 -2,5 -5,5 l -'+ set_touch_up_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_touch_up_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input);
						
						var get_touch_down 			= jQuery(this).find('.bootstrap-touchspin-down');
						var set_touch_down_height 	= (get_touch_down.outerHeight()-11);
						var set_touch_down_width 		= (get_touch_down.outerWidth()-12);
						jQuery('<svg id="demo-input-1" style="left:0px;" class="line-drawing" width="'+ (set_touch_down_width+40) +'" height="'+ (set_touch_down_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_touch_down_width +',0 c 2,0 5,2 5,5 l 0,'+ set_touch_down_height +' c 0,2 -2,5 -5,5 l -'+ set_touch_down_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_touch_down_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input);
						
						}
					if(jQuery(this).hasClass('tags'))
						{
						var get_input 			= jQuery(this).find('.bootstrap-tagsinput');
						var set_input_height 	= (get_input.outerHeight()-11);
						var set_input_width 	= (get_input.outerWidth()-12);
						jQuery('<svg id="demo-input-1" style="top:'+ input_offset.top  +'px;left:'+ input_offset.left +'px;" class="line-drawing" width="'+ (set_input_width+40) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input);
						}
						
					if(jQuery(this).hasClass('color_pallet') || jQuery(this).hasClass('datetime') || jQuery(this).hasClass('date') || jQuery(this).hasClass('time') || jQuery(this).hasClass('custom-prefix'))
						{
						var get_prefix 				= jQuery(this).find('.input-group-addon');
						var set_prefix_height 		= (get_prefix.outerHeight()-11);
						var set_prefix_width 		= (get_prefix.outerWidth()-12);
						jQuery('<svg id="demo-input-1" style="left:0px;" class="line-drawing" width="'+ (set_prefix_width+40) +'" height="'+ (set_prefix_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_prefix_width +',0 c 2,0 5,2 5,5 l 0,'+ set_prefix_height +' c 0,2 -2,5 -5,5 l -'+ set_prefix_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_prefix_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input.closest('.svg_ready'));
	
						var get_input 			= jQuery(this).find('.the_input_element');
						var set_input_height 	= (get_input.outerHeight()-11);
						var set_input_width 	= (get_input.outerWidth()+set_prefix_width);
						jQuery('<svg id="demo-input-1" style="top:'+ input_offset.top  +'px;left:'+ input_offset.left +'px;" class="line-drawing" width="'+ (set_input_width+40) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input.closest('.svg_ready'));
						}
					
					if(jQuery(this).hasClass('custom-postfix') || jQuery(this).hasClass('upload-single'))
						{
						var get_postfix 			= jQuery(this).find('.input-group-addon');
						var set_postfix_height 		= (get_postfix.outerHeight()-11);
						var set_postfix_width 		= (get_postfix.outerWidth()-12);
						
						var get_input 			= jQuery(this).find('.the_input_element');
						var set_input_height 	= (get_input.outerHeight()-11);
						var set_input_width 	= (get_input.outerWidth()+set_postfix_width);
						jQuery('<svg id="demo-input-1" style="left:'+ (set_input_width-set_postfix_width) +'px;" class="line-drawing" width="'+ (set_postfix_width+40) +'" height="'+ (set_postfix_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_postfix_width +',0 c 2,0 5,2 5,5 l 0,'+ set_postfix_height +' c 0,2 -2,5 -5,5 l -'+ set_postfix_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_postfix_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input.closest('.svg_ready'));
						jQuery('<svg id="demo-input-1"  class="line-drawing" width="'+ (set_input_width+40) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input.closest('.svg_ready'));
						}
						
					
					if(jQuery(this).hasClass('custom-pre-postfix'))
						{
						var get_postfix 			= jQuery(this).find('.input-group-addon.postfix');
						var set_postfix_height 		= (get_postfix.outerHeight()-11);
						var set_postfix_width 		= (get_postfix.outerWidth()-12);
						
						var get_prefix 				= jQuery(this).find('.input-group-addon.prefix');
						var set_prefix_height 		= (get_prefix.outerHeight()-11);
						var set_prefix_width 		= (get_prefix.outerWidth()-12);
						
						var get_input 			= jQuery(this).find('.the_input_element');
						var set_input_height 	= (get_input.outerHeight()-11);
						var set_input_width 	= (get_input.outerWidth()+set_prefix_width+set_postfix_width+14);
						jQuery('<svg id="demo-input-1" style="left:'+ (set_input_width-set_postfix_width) +'px;" class="line-drawing" width="'+ (set_postfix_width+40) +'" height="'+ (set_postfix_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_postfix_width +',0 c 2,0 5,2 5,5 l 0,'+ set_postfix_height +' c 0,2 -2,5 -5,5 l -'+ set_postfix_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_postfix_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input.closest('.svg_ready'));
						jQuery('<svg id="demo-input-1"  class="line-drawing" width="'+ (set_input_width+40) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input.closest('.svg_ready'));
						jQuery('<svg id="demo-input-1" style="left:0px;" class="line-drawing" width="'+ (set_prefix_width+40) +'" height="'+ (set_prefix_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_prefix_width +',0 c 2,0 5,2 5,5 l 0,'+ set_prefix_height +' c 0,2 -2,5 -5,5 l -'+ set_prefix_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_prefix_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input.closest('.svg_ready'));
						}
					
					if(jQuery(this).hasClass('upload-image'))
						{
						var get_input 			= jQuery(this).find('.the_input_element');
						var set_input_height 	= (get_input.outerHeight()-11);
						var set_input_width 	= (get_input.outerWidth()+set_postfix_width);
						jQuery('<svg id="demo-input-1"  class="line-drawing" width="'+ (set_input_width+40) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path id="the_path" class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>').insertAfter(get_input.closest('.svg_ready'));
						}
				
							
				jQuery('.form_field').appear(function() {
					
					var the_field = jQuery(this);
					window.requestAnimFrame = function(){
						return (
							window.requestAnimationFrame       || 
							window.webkitRequestAnimationFrame || 
							window.mozRequestAnimationFrame    || 
							window.oRequestAnimationFrame      || 
							window.msRequestAnimationFrame     || 
							function(callback){
								window.setTimeout(callback, 1000 / 60);
							}
						);
					}();
					window.cancelAnimFrame = function(){
						return (
							window.cancelAnimationFrame       || 
							window.webkitCancelAnimationFrame || 
							window.mozCancelAnimationFrame    || 
							window.oCancelAnimationFrame      || 
							window.msCancelAnimationFrame     || 
							function(id){
								window.clearTimeout(id);
							}
						);
					}();
					
					var 
					hidden = Array.prototype.slice.call( document.querySelectorAll( '.do_hide' ) ),
						current_frame = 0,
						total_frames = jQuery('div.animation_time').html() ? jQuery('div.animation_time').html() : 60,
						path = new Array(),
						length = new Array(),
						handle = 0;
				
					function init() {
						[].slice.call( document.querySelectorAll( 'path' ) ).forEach( function( el, i ) {
							path[i] = el;
							var l = path[i].getTotalLength();
							length[i] = l;
							path[i].style.strokeDasharray = l + ' ' + l; 
							path[i].style.strokeDashoffset = l;
						} );
				
					}
				
					function draw(){
						var progress = current_frame/total_frames;
						if (progress > 1)
							{
							window.cancelAnimFrame(handle);
							the_field.find('svg').attr('class','line-drawing do_hide');
							the_field.find('.do_hide').removeClass('do_hide').addClass('do_show');
							} 
						else
							{
							current_frame++;
							for(var j=0; j<path.length;j++)
								path[j].style.strokeDashoffset = Math.floor(length[j] * (1 - progress));
								
							handle = window.requestAnimFrame(draw);
							}
					}
				init();
				draw();
			 jQuery('div.ui-nex-forms-container').css('visibility','visible');
				the_field.find('label#title').fadeIn(2500);
				the_field.find('.help-block').fadeIn(2500);
				}
			);		
					 				
									
									
									
									
									
					}
				);	
			},300);					  
			
	}
}


jQuery(document).ready(
function()
	{
	
	jQuery('.tutorial').live('click',
		function(){
			
			bootstro.start();
		}
	);
//NEW FORM			
	jQuery('#new_form .blank').click(
		function()
			{
			jQuery('.btn').blur();
			jQuery('.nex-forms-entries').html('No entries yet...');
			jQuery('.badge.entry-count').text('0');
			jQuery('#the_form_title').val('');
			jQuery('.form_update_id').text('')
			jQuery('div.nex-forms-container').html('<div class="run_animation hidden">true</div><div class="animation_time hidden">60</div><div class="trash-can form_field grid ui-draggable dropped" style="display: block;" id="_73800"><div style="" class="form_object" id="form_object"><div data-svg="demo-input-1" class="input-inner do_show"><div class="row"><div class="input_holder col-sm-12"><div class="panel panel-default"><div class="panel-body ui-droppable ui-sortable"><span class="glyphicon glyphicon-trash"></span></div></div></div></div></div></div></div></div>');
			jQuery('#the_form_title').popover('hide');
			jQuery('.forms-entries').hide();
			jQuery('.forms-auto-responder').hide();
			jQuery('.forms-canvas').show();
			}
		);
	jQuery('#new_form .nex_form_templates').live('click',
		function()
			{
			jQuery('.btn').blur();
			jQuery('#the_form_title').val('');
			jQuery('.form_update_id').text('')
			jQuery('#the_form_title').popover('hide');
			
			var data =
				{
				action	 							: 'load_nex_form',
				form_Id								: jQuery(this).attr('id')
				};		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					jQuery('div.nex-forms-container').html(response)
					jQuery('div.nex-forms-container div#the-radios input').prop('checked',false);
					jQuery('div.nex-forms-container div#the-radios a').attr('class','');
					jQuery('div.nex-forms-container .form_field').each(
						function()
							{
							setup_form_element(jQuery(this))
							if(jQuery(this).hasClass('text') || jQuery(this).hasClass('textarea'))
								{
								if(jQuery(this).find('.the_input_element').attr('data-maxlength-show')=='true')
									jQuery(this).find('.the_input_element').maxlength({ placement:(jQuery(this).find('.the_input_element').attr('data-maxlength-position')) ? jQuery(this).find('.the_input_element').attr('data-maxlength-position') : 'bottom', alwaysShow: true , set_ID: jQuery(this).attr('id'), warningClass: 'label '+ jQuery(this).find('.the_input_element').attr('data-maxlength-color') });
								}
							}
						);
					}
				);
			
			}
		);
	jQuery('#the_form_title').val('');
	jQuery('.form_update_id').text('')
	
//POPULATE MY FORMS	
	function load_nex_form_items(){
		var data =
				{
				action	: 'load_nex_form_items'
				};		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					jQuery('li.nex_form_itmes').remove();
					setTimeout(function(){ jQuery(response).insertAfter('li.my_forms') },200 );
					}
				);
	}
	function load_nex_form_templates(){
		var data =
				{
				action	: 'load_nex_form_templates'
				};		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					jQuery('li.nex_form_templates').remove();
					setTimeout(function(){ jQuery(response).insertAfter('li.my_templates'); },200 );
					}
				);
	}
	load_nex_form_items();
	load_nex_form_templates();
	
//SAVE FORM	
	jQuery('#the_form_title').keyup(
		function()
			{
			if(!jQuery(this).val())
				{
				jQuery('#the_form_title').popover({trigger:'manual'});
				jQuery('#the_form_title').popover('show');
				jQuery('#the_form_title').parent().find('.popover ').addClass('alert-success');	
				}
			else
				{
				jQuery('#the_form_title').popover('hide');	
				}
			}
		);
	jQuery('#save_nex_form').live('click',
		function()
			{
			jQuery('.btn').blur();
			jQuery('.bootstrap-select').remove();
			var clicked = jQuery(this);
			var current_button = jQuery(this).html()
			if(!jQuery('#the_form_title').val())
				{
				jQuery('#the_form_title').popover({trigger:'manual'});
				jQuery('#the_form_title').popover('show');
				jQuery('#the_form_title').parent().find('.popover ').addClass('alert-success');
				jQuery('#the_form_title').focus();
				
				return;
				}
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
					
					load_nex_form_items();
					load_nex_form_templates();
					
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
									function()
										{
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
//DELETE FORM
jQuery('.delete_the_form').live('click',
		function()
			{
			jQuery('#deleteForm').find('.do_delete').attr('data-form-id',jQuery(this).attr('id'))
			jQuery('#deleteForm').find('span.get_form_title').text(jQuery(this).parent().find('.the_form_title').text())
			}
		);

jQuery('.do_delete').live('click',
		function()
			{
			
			var data =
				{
				action	 						: 'delete_record',
				table							: 'wap_nex_forms',
				Id								: jQuery(this).attr('data-form-id')
				};		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					jQuery('#new_form .blank').trigger('click');
					load_nex_form_items();
					load_nex_form_templates();
					}
				);
			}
		);
	
	 

	
	
//OPEN FORM	
jQuery('div.form_field').find('input[type="radio"]').nexchecks();
jQuery('div.form_field').find('input[type="checkbox"]').nexchecks();
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
	jQuery('#load_next_form li').live('click',
		function()
			{
			jQuery('.btn').blur();
			jQuery('#the_form_title').popover('hide');
			jQuery('#the_form_title').val(jQuery(this).find('.the_form_title').text())	
			jQuery('.form_update_id').text(jQuery(this).attr('id'))
			
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
			jQuery('div.nex-forms-container').html('<h2><i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;Loading Form - "'+ jQuery(this).find('.the_form_title').text() +'"...</h2>')
			var data =
				{
				action	 							: 'load_nex_form',
				form_Id								: jQuery(this).attr('id')
				};		
			jQuery.post
				(
				ajaxurl, data, function(response)
					{
					jQuery('div.nex-forms-container').html(response)
					jQuery('div.nex-forms-container div#the-radios input').prop('checked',false);
					jQuery('div.nex-forms-container div#the-radios a').attr('class','');
					jQuery('.editing-field').removeClass('editing-field');
					setTimeout(function(){ jQuery('.editing-field').removeClass('editing-field'); },1000)
					jQuery('div.nex-forms-container .form_field').each(
						function()
							{
							setup_form_element(jQuery(this))
							if(jQuery(this).hasClass('text') || jQuery(this).hasClass('textarea'))
								{
								if(jQuery(this).find('.the_input_element').attr('data-maxlength-show')=='true')
									jQuery(this).find('.the_input_element').maxlength({ placement:(jQuery(this).find('.the_input_element').attr('data-maxlength-position')) ? jQuery(this).find('.the_input_element').attr('data-maxlength-position') : 'bottom', alwaysShow: true , set_ID: jQuery(this).attr('id'), warningClass: 'label '+ jQuery(this).find('.the_input_element').attr('data-maxlength-color') });
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
	
	
		
	jQuery('.preview_form').live('click',
		function()
			{
			jQuery('.btn').blur();
			change_device(jQuery(this));
			run_animation();
			
			run_conditions();
							
			}
		);
	}
);

function run_con_action(target,action){
			
	if(action=='show')
		jQuery('#'+target).show();
	if(action=='hide')
		jQuery('#'+target).hide();
	if(action=='slideDown')
		jQuery('#'+target).slideDown('slow');
	if(action=='slideUp')
		jQuery('#'+target).slideUp('slow');
	if(action=='fadeIn')
		jQuery('#'+target).fadeIn('slow');
	if(action=='fadeOut')
		jQuery('#'+target).fadeOut('slow');
	
}
function reverse_con_action(target,action){
	if(action=='show')
		jQuery('#'+target).hide();
	if(action=='hide')
		jQuery('#'+target).show();
	if(action=='slideDown')
		jQuery('#'+target).slideUp('slow');
	if(action=='slideUp')
		jQuery('#'+target).slideDown('slow');
	if(action=='fadeIn')
		jQuery('#'+target).fadeOut('slow');
	if(action=='fadeOut')
		jQuery('#'+target).fadeIn('slow');
}

function convert_time_to_24h(time){

var hours = Number(time.match(/^(\d+)/)[1]);
var minutes = Number(time.match(/:(\d+)/)[1]);
var AMPM = time.match(/\s(.*)$/)[1];
if(AMPM == "PM" && hours<12) hours = hours+12;
if(AMPM == "AM" && hours==12) hours = hours-12;
var sHours = hours.toString();
var sMinutes = minutes.toString();
if(hours<10) sHours = "0" + sHours;
if(minutes<10) sMinutes = "0" + sMinutes;
return sHours + ":" + sMinutes;

	
}

function run_conditions(){
	jQuery('div.ui-nex-forms-container div.form_field').find('input[type="text"], textarea').keyup(
				function()
					{
					if(jQuery(this).hasClass('has_con'))
						{
						var val = jQuery(this).val();
						jQuery('.field_'+jQuery(this).closest('.form_field').attr('id')).each(
							function()
								{
								var condition = jQuery(this).attr('data-condition');
								var action = jQuery(this).attr('data-action');
								var target = jQuery(this).attr('data-target');
								var value = jQuery(this).attr('data-value');
								switch(condition)
									{
									case 'Equal to':
										if(val==value)
											{
											run_con_action(target,action);
											}
										else
											reverse_con_action(target,action);
									break;
									case 'Greater than':
										if(isNumber)
											{
											if(parseInt(val)>parseInt(value))
												{
												run_con_action(target,action);
												}
												
											}
									break;
									case 'Less than':
										if(isNumber)
											{
											if(parseInt(val)<parseInt(value))
												{
												run_con_action(target,action);
												}
											}
									break;
									}
								}
							);
						}
					}
				);	
		jQuery('div.ui-nex-forms-container div.form_field').find('input[type="text"], input[type="hidden"], textarea').live('change',
				function()
					{
					if(jQuery(this).hasClass('has_con'))
						{
						var val = jQuery(this).val();
						jQuery('.field_'+jQuery(this).closest('.form_field').attr('id')).each(
							function()
								{
								var condition = jQuery(this).attr('data-condition');
								var action = jQuery(this).attr('data-action');
								var target = jQuery(this).attr('data-target');
								var value = jQuery(this).attr('data-value');
								switch(condition)
									{
									case 'Equal to':
										if(val==value)
											{
											run_con_action(target,action);
											}
										else
											reverse_con_action(target,action);
									break;
									case 'Greater than':
										if(isNumber)
											{
											if(parseInt(val)>parseInt(value))
												{
												run_con_action(target,action);
												}
												
											}
									break;
									case 'Less than':
										if(isNumber)
											{
											if(parseInt(val)<parseInt(value))
												{
												run_con_action(target,action);
												}
											}
									break;
									}
								}
							);
						}
					}
				);
		
		
		
		
		
		jQuery('div.ui-nex-forms-container div.form_field').find('#datetimepicker').on('change', function(e) {
		  if(jQuery(this).find('input').hasClass('has_con'))
						{
						var the_input = jQuery(this).find('input');
						var val = jQuery(this).find('input').val();
						jQuery('.field_'+jQuery(this).closest('.form_field').attr('id')).each(
							function()
								{
								var condition = jQuery(this).attr('data-condition');
								var action = jQuery(this).attr('data-action');
								var target = jQuery(this).attr('data-target');
								var value = jQuery(this).attr('data-value');
								switch(condition)
									{
									case 'Equal to':
										if(val==value)
											{
											run_con_action(target,action);
											}
										else
											reverse_con_action(target,action);
									break;
									case 'Greater than':
										if(the_input.closest('.form_field').hasClass('time'))
											{
											var firstValue = convert_time_to_24h(value);
											var secondValue = convert_time_to_24h(val);
											if(Date.parse('01/01/2011 '+ secondValue +':00') > Date.parse('01/01/2011 '+firstValue +':00'))
												run_con_action(target,action);
											}
										else if(the_input.closest('.form_field').hasClass('datetime')){
											var splitdatetime1 = value.split(' ');
											var splitdatetime2 = val.split(' ');
											if(Date.parse(splitdatetime1[0] + ' '+ convert_time_to_24h(splitdatetime1[1] +' '+ splitdatetime1[2])+':00') < Date.parse(splitdatetime2[0] + ' '+ convert_time_to_24h(splitdatetime2[1] +' '+ splitdatetime2[2])+':00'))
												run_con_action(target,action);
										}
										else
											{
											if(Date.parse(value+' 00:00:00') < Date.parse(val+' 00:00:00'))
												run_con_action(target,action);
											}
									break;
									case 'Less than':
										
										if(the_input.closest('.form_field').hasClass('time'))
											{
											var firstValue = convert_time_to_24h(value);
											var secondValue = convert_time_to_24h(val);
											if(Date.parse('01/01/2011 '+ secondValue +':00') < Date.parse('01/01/2011 '+firstValue +':00'))
												run_con_action(target,action);
											}
										else if(the_input.closest('.form_field').hasClass('datetime')){
												var splitdatetime1 = value.split(' ');
												var splitdatetime2 = val.split(' ');
												if(Date.parse(splitdatetime1[0] + ' '+ convert_time_to_24h(splitdatetime1[1] +' '+ splitdatetime1[2])+':00') > Date.parse(splitdatetime2[0] + ' '+ convert_time_to_24h(splitdatetime2[1] +' '+ splitdatetime2[2])+':00'))
													run_con_action(target,action);
											}
										else
											{
											if(Date.parse(value+' 00:00:00') > Date.parse(val+' 00:00:00'))
												run_con_action(target,action);
										  	
											}
									break;
									}
								}
							);
						}
		});	
			
		jQuery('div.ui-nex-forms-container div.form_field').find('select').change(
				function()
					{
					if(jQuery(this).hasClass('has_con'))
						{
						var val = jQuery(this).val();
						jQuery('.field_'+jQuery(this).closest('.form_field').attr('id')).each(
							function()
								{
								var action = jQuery(this).attr('data-action');
								var target = jQuery(this).attr('data-target');
								var value = jQuery(this).attr('data-value');
								
								if(val==value)
									run_con_action(target,action);
								else
									reverse_con_action(target,action);
								
								}
							);
						}
					}
				);	
		jQuery('div.ui-nex-forms-container div.form_field').find('.prettyradio a, span.radio-label').live('click',
				function()
					{
					var the_radio = jQuery(this).parent().find('input[type="radio"]');
					if(the_radio.hasClass('has_con'))
						{
						var val = the_radio.val();
						jQuery('.field_'+the_radio.closest('.form_field').attr('id')).each(
							function()
								{
								var action = jQuery(this).attr('data-action');
								var target = jQuery(this).attr('data-target');
								var value = jQuery(this).attr('data-value');
								
								if(val==value)
									run_con_action(target,action);
								else
									reverse_con_action(target,action);
								
								}
							);
						}
					}
				);	
		
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
	
	jQuery('div.ui-nex-forms-container').find('.customcon').each(
		function()
			{
			if(obj.attr('id')==jQuery(this).attr('data-target') && (jQuery(this).attr('data-action')=='show' || jQuery(this).attr('data-action')=='slideDown' || jQuery(this).attr('data-action')=='fadeIn'))
				obj.hide();
			}
	);
	
	jQuery('div.ui-nex-forms-container').find('.bs-tooltip').tooltip();
	
	if(obj.hasClass('text') || obj.hasClass('textarea'))
		obj.find('.the_input_element').val(obj.find('.the_input_element').attr('data-default-value'));
					
	if(obj.hasClass('datetime'))
		{
		obj.find('#datetimepicker').datetimepicker();	
		}
	if(obj.hasClass('date'))
		{
		obj.find('#datetimepicker').datetimepicker( { pickTime:false } );	
		}
	if(obj.hasClass('time'))
		{
		obj.find('#datetimepicker').datetimepicker( { pickDate:false });
		}
	
	if(obj.hasClass('touch_spinner'))
		{
		var the_spinner = obj.find("#spinner");
		the_spinner.TouchSpin({
			initval: parseInt(the_spinner.attr('data-starting-value')),
			min:  parseInt(the_spinner.attr('data-minimum')),
			max:  parseInt(the_spinner.attr('data-maximum')),
			step:  parseInt(the_spinner.attr('data-step')),
			decimals:  parseInt(the_spinner.attr('data-decimals')),
			boostat: 5,
			maxboostedstep: 10,
			postfix: (the_spinner.attr('data-postfix-icon')) ? '<span class="'+ the_spinner.attr('data-postfix-icon') +' '+ the_spinner.attr('data-postfix-class') +'">' + the_spinner.attr('data-postfix-text') + '</span>' : '',
			prefix: (the_spinner.attr('data-prefix-icon')) ? '<span class="'+ the_spinner.attr('data-prefix-icon') +' '+ the_spinner.attr('data-prefix-class') +'">' + the_spinner.attr('data-prefix-text') + '</span>' : '',
			buttondown_class:  'btn ' + the_spinner.attr('data-down-class'),
			buttonup_class: 'btn ' + the_spinner.attr('data-up-class')
		});
		obj.find(".bootstrap-touchspin .bootstrap-touchspin-down").html('<span class="icon '+   the_spinner.attr('data-down-icon') +'"></span>');
		obj.find(".bootstrap-touchspin .bootstrap-touchspin-up").html('<span class="icon '+   the_spinner.attr('data-up-icon') +'"></span>');
		}
	if(obj.hasClass('color_pallet'))
		{
		
		obj.find('#colorpalette').colorPalette().on('selectColor', function(e) {
		obj.find('#selected-color').val(e.color);
		obj.find('#selected-color').trigger('change');
		obj.find('.input-group-addon').css('background',e.color);
		});	
		}
	
	if(obj.hasClass('slider'))
		{
		var count_text = obj.find( "#slider" ).attr('data-starting-value');
		var the_slider = obj.find( "#slider" )
		var set_min = the_slider.attr('data-min-value');
		var set_max = the_slider.attr('data-max-value')
		var set_start = the_slider.attr('data-starting-value')

		obj.find( "#slider" ).slider({
				range: "min",
				min: parseInt(set_min),
				max: parseInt(set_max),
				value: parseInt(set_start),
				slide: function( event, ui ) {	
					count_text = '<span class="count-text">' + the_slider.attr('data-count-text').replace('{x}',ui.value) + '</span>';	
					the_slider.find( 'a.ui-slider-handle' ).html( '<span id="icon" class="'+ the_slider.attr('data-dragicon') +'"></span> '+ count_text).addClass(the_slider.attr('data-dragicon-class')).removeClass('ui-state-default');
				},
				create: function( event, ui ) {	
					count_text = '<span class="count-text">'+ the_slider.attr('data-count-text').replace('{x}',((set_start) ? set_start : set_min)) +'</span>';	
					the_slider.find( 'a.ui-slider-handle' ).html( '<span id="icon" class="'+ the_slider.attr('data-dragicon') +'"></span> '+ count_text).addClass(the_slider.attr('data-dragicon-class')).removeClass('ui-state-default');
				}
				
			});
			//the_slider.find( 'a.ui-slider-handle' ).html('<span id="icon" class="'+ the_slider.attr('data-dragicon') +'"></span>' + count_text);
			
			//Slider text color
			the_slider.find('a.ui-slider-handle').css('color',the_slider.attr('data-text-color'));
			//Handel border color
			the_slider.find('a.ui-slider-handle').css('border-color',the_slider.attr('data-handel-border-color'));
			//Handel Background color
			the_slider.find('a.ui-slider-handle').css('background-color',the_slider.attr('data-handel-background-color'));
			//Slider border color
			the_slider.find('.ui-widget-content').css('border-color',the_slider.attr('data-slider-border-color'));
			//Slider background color
			//Slider fill color
			the_slider.find('.ui-slider-range:first-child').css('background',the_slider.attr('data-fill-color'));
			the_slider.find('.ui-slider-range:last-child').css('background',the_slider.attr('data-background-color'));
		}			
	if(obj.hasClass('star-rating'))
		{
		obj.find('#star').raty({
		  size     : 24,
		  number   : parseInt(obj.find('#star').attr('data-total-stars')),
		  starHalf : jQuery('.plugin_url').text()+'/images/star-half-big.png',
		  starOff  : jQuery('.plugin_url').text()+'/images/star-off-big.png',
		  starOn   : jQuery('.plugin_url').text()+'/images/star-on-big.png',
		  scoreName: format_illegal_chars(obj.find('.the_label').text()),
		  half: (obj.find('#star').attr('data-enable-half')=='false') ? false : true 
		});
		}
		
		
	if(obj.hasClass('multi-select') || obj.hasClass('select'))
		{	
		var the_select = obj.find("#select");
		the_select.selectpicker();
		var font_family = (the_select.attr('data-font-family')) ? the_select.attr('data-font-family') : '';
		font_family = font_family.replace('sf','');
		font_family = font_family.replace('gf','');
		obj.find(".selectpicker").css('color', the_select.attr('data-text-color'))
		obj.find(".selectpicker a").css('color', the_select.attr('data-text-color'))
		obj.find(".selectpicker").removeClass('align_left').removeClass('align_right').removeClass('align_center')
		obj.find(".selectpicker").addClass(the_select.attr('data-text-alignment'))
		obj.find(".selectpicker").addClass(the_select.attr('data-input-size'))
		obj.find(".selectpicker").css('font-family',font_family);
		
		obj.find(".selectpicker").css('border-color', the_select.attr('data-border-color'));
		obj.find(".selectpicker").css('background', the_select.attr('data-background-color'))
		
		}
	if(obj.hasClass('email'))
		{
		}
	if(obj.hasClass('tags'))
		{	
		var the_tag_input = obj.find('input#tags');
		 the_tag_input.tagsinput( {maxTags: (the_tag_input.attr('data-max-tags')) ? the_tag_input.attr('data-max-tags') : '' });
		 
		obj.find('.bootstrap-tagsinput input').css('color',the_tag_input.attr('data-text-color'));
		obj.find('.bootstrap-tagsinput').css('border-color',the_tag_input.attr('data-border-color'));
		obj.find('.bootstrap-tagsinput').css('background-color',the_tag_input.attr('data-background-color'));
		}
		
	if(obj.hasClass('autocomplete'))
		{
		var items = obj.find('div.get_auto_complete_items').text();
		items = items.split('\n');
		obj.find("#autocomplete").autocomplete({
			source: items
			});	
		}
	if(obj.hasClass('radio-group'))
		{
		obj.find('input[type="radio"]').nexchecks()
		}
	if(obj.hasClass('check-group'))
		{
		obj.find('input[type="checkbox"]').nexchecks()
		}	
	
	
	if(jQuery('.field_'+obj.attr('id')).attr('data-target'))
		{
		obj.find('input[type="text"]').addClass('has_con');
		obj.find('input[type="hidden"]').addClass('has_con');
		obj.find('textarea').addClass('has_con');
		obj.find('select').addClass('has_con');
		obj.find('input[type="radio"]').addClass('has_con');
		}
	
	if(jQuery('.field_'+obj.attr('id')).attr('data-target'))
		{
		obj.find('input[type="text"]').addClass('has_con');
		obj.find('input[type="hidden"]').addClass('has_con');
		obj.find('textarea').addClass('has_con');
		obj.find('select').addClass('has_con');
		obj.find('input[type="radio"]').addClass('has_con');
		}
}


/******************************************************/
/*VIEW CHANGER */
jQuery(document).ready(
function()
	{
	jQuery('a.export_csv').live('click',
		function()
			{
			document.export_csv.submit();
			}
		);
	jQuery('a.autoRespond').live('click',
		function()
			{
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