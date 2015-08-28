function run_count(selector, to)
{
  var from = jQuery(selector).text()=='' ? 0 : parseFloat(jQuery(selector).text());
  jQuery({someValue: from}).animate({someValue: parseFloat(to)}, {
    duration: 500,
    easing:'swing',
    step: function() {
      jQuery(selector).text(Math.ceil(this.someValue));
    }
  });
  setTimeout(function(){
    jQuery(selector).text(parseFloat(to));
  }, 550);
}

function set_up_math_logic(target){
	
	var get_math = target.attr('data-original-math-equation');
	var pattern = /\[(.*?)\]/g;
	while ((match = pattern.exec(get_math)) != null)
		{
		var element = document.getElementsByName(match[1]);
		 jQuery(element).on('change',
			function()
				{
				run_math_logic(target);
				}
			);
		}
}

function run_math_logic(target,reset_math){

	if(!strstr(target.attr('data-math-equation'),'['))
		target.attr('data-math-equation',target.attr('data-original-math-equation'));
		
	var get_math = target.attr('data-math-equation');
	var set_result = '';
	var match_array = []
	var pattern = /\[(.*?)\]/g;
	var set_val = '';
	var clean_math ='';
	var i = 0;
	var check_val = 0;
	var select_val = 0;
	
	while ((match = pattern.exec(get_math)) != null)
		{
		match_array[i] = match[1];
		i++;
		}
		
	var arrayLength = match_array.length;
	
	for (var j = 0; j < arrayLength; j++)
		{
		 var set_match = match_array[j];
		 var element = document.getElementsByName(match_array[j]);
		 select_val = 0;
		 if(jQuery(element).is('select'))
			{
			jQuery('select[name="'+match_array[j]+'"] option:selected').each(
				function()
					{
					if(jQuery(this).prop('selected')==true)
						{
						if(jQuery(element).attr('multiple')=='multiple')
							select_val += parseInt(jQuery(this).val());
						else
							select_val = parseInt(jQuery(this).val());	
						}
					else
						select_val = 0;
					}
				);
			set_val = select_val;	
			}
		 else if(jQuery(element).attr('type')=='checkbox')
		 	{
			jQuery('input[name="'+match_array[j]+'"]').each(
				function()
					{
					if(jQuery(this).prop('checked')==true)
						check_val += parseInt(jQuery(this).val());
					}
				);
			set_val = check_val;
			}
		 else if(jQuery(element).attr('type')=='radio')
		 	{
			if(jQuery('input[name="'+match_array[j]+'"]:checked').val())
				set_val = jQuery('input[name="'+match_array[j]+'"]:checked').val();	
			else
				set_val = 0;
			}
		else if(jQuery(element).is('textarea'))
			{
			set_val = (jQuery('textarea[name="'+match_array[j]+'"]').val()) ? jQuery('textarea[name="'+match_array[j]+'"]').val() : 0;
			}
		 else
		 	set_val = (jQuery(element).val()) ? jQuery(element).val() : 0;
			
		 clean_math = target.attr('data-math-equation').replace(set_match,set_val).replace('[','').replace(']','');
		 target.attr('data-math-equation',clean_math)
		}
	run_count(target,math.eval(clean_math));
}

function strstr(haystack, needle, bool) {
    var pos = 0;

    haystack += "";
    pos = haystack.indexOf(needle); if (pos == -1) {
       return false;
    } else {
       return true;
    }
}

jQuery(document).ready(
function ()
	{// JavaScript Document
	
	set_up_math_logic(jQuery('.result'));
	
	run_math_logic(jQuery('.result'));
	}
);