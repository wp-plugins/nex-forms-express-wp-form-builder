jQuery(document).ready(
function ()
	{
		jQuery('.dashboard_wrapper .item_logo').hover(
			function()
				{
				jQuery(this).find('.cover_image').show();
				},
			function()
				{
				jQuery(this).find('.cover_image').hide();
				}
			);
	}
);