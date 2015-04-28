<?php
	// Load Google Fonts and scripts only once and as late as possible
	$this->print_scripts();

	// Passed arguments: do_action( 'styles_font_menu', $attributes, $value );
?>

<div class="get_google_menu" style="display:none;" ><select <?php echo $attributes ?> class="sample <?php echo $this->menu_class ?> form-control" data-selected="<?php esc_attr_e( $value ) ?>" data-placeholder="Select a Font...">
	<option value=""></option>

	<?php /* 
		Fonts loaded by styles-font-menu.js

		This is done for performance reasons. The list is 600+ fonts.
		In cases where the dropdown is used multiple times on one page,
		outputting the HTML server-side can result in a page of several megabytes.

		This avoids that by outputting the list once in javascript,
		then building the menus with javascript on the client-side.
	*/ ?>

</select></div>