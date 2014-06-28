jQuery(document).ready(
function ()
	{
	'use strict';
	/*jQuery('div.input_holder').each(
			function()
				{
				var get_span 			= jQuery(this).find('span');
				var get_input 			= jQuery(this).find('input');
				
				var input_offset 		= 0;
				var span_offset 		= get_input.offset();
				
				var set_input_height 	= (get_input.outerHeight()-11);
				var set_input_width 	= (get_input.outerWidth()+get_span.outerWidth()-13);
				
				var set_span_height 	= (get_span.outerHeight()-12);
				var set_span_width 		= (get_span.outerWidth()-11);
				
				//Drawing input with no PRE-Suffix
				if(jQuery(this).hasClass('no-pre-suffix'))
					{
					jQuery(this).append('<svg id="demo-input-1" style="top:'+ input_offset.top  +'px;left:'+ input_offset.left +'px;" class="line-drawing" width="'+ (set_input_width+40) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>');
					}
					
				//Drawing Stars
				else if(jQuery(this).hasClass('star'))
					{
					var count = 1;
					jQuery(this).find('img').each(
					function(index)
							{
							count 					= 24*index;
							var get_input 			= jQuery(this);
							var set_input_height 	= (get_input.outerHeight()-3);
							var set_input_width 	= (get_input.outerWidth()-4);
							jQuery(this).parent().parent().append('<svg id="demo-input-1" style="top:0px;left:'+ count +'px;" class="line-drawing" width="200" height="200" xmlns="http://www.w3.org/2000/svg"><path fill="none" stroke="#000" d="m12.5,0.5 3,8.5h9l-7,5.5 2.5,8.5-7.5-5-7.5,5 2.5-8.5-7-5.5h9z"/></svg>');
							}
						);
					}
					
				//Drawing Sliders
				else if(jQuery(this).hasClass('slider'))
					{
					jQuery(this).find('#slider').each(
					function()
							{
							var get_input 			= jQuery(this);
							var set_input_height 	= (get_input.outerHeight()-2);
							var set_input_width 	= (get_input.outerWidth()-29);
							jQuery(this).parent().parent().append('<svg id="demo-input-1" style="top:2px;" class="line-drawing" width="'+ (set_input_width+20) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>');
							}
						);
					}
				
				//Drawing Selects
				else if(jQuery(this).hasClass('select'))
					{
					jQuery(this).find('select').each(
					function()
							{
							var get_input 			= jQuery(this);
							var set_input_height 	= (get_input.outerHeight()-9);
							var set_input_width 	= (get_input.outerWidth()-4);
							jQuery(this).parent().parent().append('<svg id="demo-input-1" style="" class="line-drawing" width="'+ (set_input_width+20) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>');
							}
						);
					}
				
				//Drawing Textarea
				else if(jQuery(this).hasClass('textarea'))
					{
					jQuery(this).find('textarea').each(
					function()
							{
							var get_input 			= jQuery(this);
							var set_input_height 	= (get_input.outerHeight()-9);
							var set_input_width 	= (get_input.outerWidth()-4);
							jQuery(this).parent().parent().append('<svg id="demo-input-1" style="" class="line-drawing" width="'+ (set_input_width+20) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>');
							}
						);
					}
				
				//Drawing Radios
				else if(jQuery(this).hasClass('radio-group'))
					{
					jQuery(this).find('input').each(
					function()
							{
							jQuery(this).parent().parent().append('<svg id="demo-input-1" style="" class="line-drawing" width="300" height="100" xmlns="http://www.w3.org/2000/svg"><path d="M 20,10.5 C 20,15.75 15.75,20.25 10.25,20.25 5,20.25 0.625,15.75 0.625,10.25 0.625, 5 5,0.5 10.25,0.5 c 5.25,0 9.75,4.25 9.75,9.75z" class="darker" style="stroke-dasharray: 100, 100; stroke-dashoffset: 0;"/></svg>');	
							}
						);
					}
				
				//Drawing Checkboxes
				else if(jQuery(this).hasClass('checkbox-group'))
					{
					jQuery(this).find('input').each(
					function()
							{
							var get_input 			= jQuery(this);
							var set_input_height 	= (get_input.outerHeight()-9);
							var set_input_width		= (get_input.outerWidth()-4);
							jQuery(this).parent().parent().append('<svg id="demo-input-1" style="" class="line-drawing" width="'+ (set_input_width+20) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>');
							}
						);
					}
					
				//Drawing inputs with pre-suffix's
				else
					{
					if(get_span.hasClass('right'))
						var set_left = 'style="left:'+ (set_input_width-set_span_width) +'px;"';

					jQuery(this).append('<svg id="demo-input-1" style="top:'+ input_offset.top  +'px;left:'+ input_offset.left +'px;" class="line-drawing" width="'+ (set_input_width+40) +'" height="'+ (set_input_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path class="" d="m 7,2 '+ set_input_width +',0 c 2,0 5,2 5,5 l 0,'+ set_input_height +' c 0,2 -2,5 -5,5 l -'+ set_input_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_input_height +' c 0,-2 2,-5 5,-5z" /></svg>');
					jQuery(this).append('<svg id="demo-span-1"  class="line-drawing" '+ set_left +'width="'+ (set_span_width+40) +'" height="'+ (set_span_height+40) +'" xmlns="http://www.w3.org/2000/svg"><path class="" d="m 7,2 '+ set_span_width +',0 c 2,0 5,2 5,5 l 0,'+ set_span_height +' c 0,2 -2,5 -5,5 l -'+ set_span_width +',0 c -2,0 -5,-2 -5,-5 l 0,-'+ set_span_height +' c 0,-2 2,-5 5,-5z" /></svg>');
					}
				}
		);
	
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
	
	var svgs = Array.prototype.slice.call( document.querySelectorAll( 'svg' ) ),
		hidden = Array.prototype.slice.call( document.querySelectorAll( '.do_hide' ) ),
		current_frame = 0,
		total_frames = 10,
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

	function draw() {
		var progress = current_frame/total_frames;
		if (progress > 1) {
			window.cancelAnimFrame(handle);
			showPage();
		} else {
			current_frame++;
			for(var j=0; j<path.length;j++){
				path[j].style.strokeDashoffset = Math.floor(length[j] * (1 - progress));
			}
			handle = window.requestAnimFrame(draw);
		}
	}

	function showPage() {
		svgs.forEach( function( el, i ) {
			el.setAttribute( 'class', el.getAttribute('class') + ' do_hide' );
		} );
		hidden.forEach( function( el, i ) {
			classie.remove( el, 'do_hide' );
			classie.add( el, 'do_show' );
		} );
	}
	init();
	draw();*/
	}
);
