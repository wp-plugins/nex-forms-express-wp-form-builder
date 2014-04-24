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
				jQuery('div.ui-nex-forms-container label#title').hide('hidden');
				jQuery('div.ui-nex-forms-container .help-block').hide('hidden');
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
					the_slider.parent().find( 'input' ).val(ui.value);
					the_slider.parent().find( 'input' ).trigger('change');
					},
				create: function( event, ui ) {	
					count_text = '<span class="count-text">'+ the_slider.attr('data-count-text').replace('{x}',((set_start) ? set_start : set_min)) +'</span>';	
					the_slider.parent().find( 'input' ).val(set_start);
					}
				
			});
			setTimeout(function(){
					count_text = '<span class="count-text">'+ the_slider.attr('data-count-text').replace('{x}',((set_start) ? set_start : set_min)) +'</span>';
					the_slider.find( 'a.ui-slider-handle' ).html( '<span id="icon" class="'+ the_slider.attr('data-dragicon') +'"></span> '+ count_text).addClass(the_slider.attr('data-dragicon-class')).removeClass('ui-state-default');
					},200);
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
		obj.find('#star input').addClass('the_input_element').addClass('hidden').addClass('star_rating');
		obj.find('#star input').prop('type','text');
		if(obj.hasClass('required'))
			obj.find('#star input').addClass('required');
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
		obj.find(".selectpicker").addClass('error_message');
		obj.find(".selectpicker").attr('data-placement',the_select.attr('data-placement'));
		obj.find(".selectpicker").attr('data-error-class',the_select.attr('data-error-class'));
		obj.find(".selectpicker").attr('data-content',the_select.attr('data-content'));
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
		
		obj.find('.bootstrap-tagsinput').addClass('error_message');
		obj.find(".bootstrap-tagsinput").attr('data-placement',the_tag_input.attr('data-placement'));
		obj.find(".bootstrap-tagsinput").attr('data-error-class',the_tag_input.attr('data-error-class'));
		obj.find(".bootstrap-tagsinput").attr('data-content',the_tag_input.attr('data-content'));
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
}