<?php
//JS Dependancies
wp_enqueue_script('jquery');

/***************************************/
/**********  CORE CLASSES  *************/
/***************************************/
include_once( 'class.install.php');
include_once( 'class.db.php');
include_once( 'class.admin_menu.php');
include_once( 'class.template.php');
include_once( 'class.functions.php');
include_once( 'class.admin.php');
include('styles-font-menu/plugin.php');

/***************************************/
/**************  ADMIN  ****************/
/***************************************/
if(is_admin() && ( isset($_GET['page']) && stristr($_GET['page'],'nex-forms') ) ){
/***************/
/*** WP Core ***/
/***************/
/* JS */
wp_enqueue_script('wp-admin-response');
wp_enqueue_script('admin-tags');
wp_enqueue_style('widgets');
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-widget');
wp_enqueue_script('jquery-ui-mouse');
wp_enqueue_script('jquery-ui-resizable');
wp_enqueue_script('jquery-ui-position');
wp_enqueue_script('jquery-ui-sortable');
wp_enqueue_script('jquery-ui-draggable');
wp_enqueue_script('jquery-ui-droppable');
wp_enqueue_script('jquery-ui-accordion');
wp_enqueue_script('jquery-ui-autocomplete');
wp_enqueue_script('jquery-ui-menu');
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_script('jquery-ui-slider');
wp_enqueue_script('jquery-ui-spinner');
wp_enqueue_script('jquery-ui-button');
wp_enqueue_script('jquery-ui-tooltip');
wp_enqueue_script('jquery-hotkeys');
wp_enqueue_script('backbone');
wp_enqueue_script('underscore');
//}
/* CSS */
//JQUERY
wp_enqueue_style('jquery-ui');

/***************/
/*** CUSTOM  ***/
/***************/	
/* CSS */
//HOLY GRAIL
wp_enqueue_style('Nex-Forms-admin-holy-grail.min', WP_PLUGIN_URL . '/Nex-Forms/css/holy-grail.css');
//JQUERY
wp_enqueue_style('Nex-Forms-jquery-custom', WP_PLUGIN_URL . '/Nex-Forms/css/ui-themes/default/jquery.ui.theme.css');
//FONT-AWSOME (doesnt work with enqueue)????
//wp_enqueue_style('Nex-Forms-fontawesome.min', WP_PLUGIN_URL . '/Nex-Forms/css/font-awesome.min.css');
//BOOTSTRAP
wp_enqueue_style('Nex-Forms-bootstrap.min', WP_PLUGIN_URL . '/Nex-Forms/css/bootstrap.min.css');
wp_enqueue_style('Nex-Forms-bootstrap-datepicker', WP_PLUGIN_URL . '/Nex-Forms/css/datepicker.css');
wp_enqueue_style('Nex-Forms-bootstrap-nexchecks', WP_PLUGIN_URL . '/Nex-Forms/css/nexchecks.css');
//Nex-Forms ADMIN
wp_enqueue_style('Nex-Forms-admin', WP_PLUGIN_URL . '/Nex-Forms/css/admin.css');
//Nex-Forms UI
wp_enqueue_style('Nex-Forms-ui', WP_PLUGIN_URL . '/Nex-Forms/css/ui.css');
//JQUERY UI
wp_enqueue_style('Nex-Forms-jQuery-UI',WP_PLUGIN_URL . '/Nex-Forms/css/jquery-ui.min.css');


//SVG DRAWING
//RATY
wp_enqueue_style('Nex-Forms-raty', WP_PLUGIN_URL . '/Nex-Forms/css/raty.css');
//SELECT
wp_enqueue_style('Nex-Forms-select', WP_PLUGIN_URL . '/Nex-Forms/css/bootstrap-select.css');
//SINGLE FILE UPLOAD
wp_enqueue_style('Nex-Forms-single-file-uplaod', WP_PLUGIN_URL . '/Nex-Forms/css/bootstrap.singlefile.upload.css');
//TAGS
wp_enqueue_style('Nex-Forms-tags', WP_PLUGIN_URL . '/Nex-Forms/css/bootstrap-tagsinput.css');
//COLOR PALLET
wp_enqueue_style('Nex-Forms-bootstrap-colorpalette', WP_PLUGIN_URL . '/Nex-Forms/css/bootstrap-colorpalette.css');
//COLOR PICKER
wp_enqueue_style('Nex-Forms-bootstrap-color-picker', WP_PLUGIN_URL . '/Nex-Forms/css/bootstrap-colorpicker.css');
//ISOTOP
wp_enqueue_style('Nex-Forms-isotope', WP_PLUGIN_URL . '/Nex-Forms/css/isotope.css');
//BOOTSTRO
wp_enqueue_style('Nex-Forms-bootstro.min', WP_PLUGIN_URL . '/Nex-Forms/css/bootstro.min.css');


/* JS */
//BOOTSTRAP
wp_enqueue_script('Nex-Forms-bootstrap.min',  WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap.min.js');
wp_enqueue_script('Nex-Forms-bootstrap-datepicker.min', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap-datepicker.js');
wp_enqueue_script('Nex-Forms-bootstrap-nexchecks', WP_PLUGIN_URL . '/Nex-Forms/js/nexchecks.js');

//SVG DRAWING
wp_enqueue_script('Nex-Forms-svg-1-admin', WP_PLUGIN_URL . '/Nex-Forms/js/classie.js');
wp_enqueue_script('Nex-Forms-svg-2-admin', WP_PLUGIN_URL . '/Nex-Forms/js/svganimations.js');

//RATY
wp_enqueue_script('Nex-Forms-raty', WP_PLUGIN_URL . '/Nex-Forms/js/jquery.raty.min.js');

//TOUCH SPIN
wp_enqueue_script('Nex-Forms-spinner', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap.touchspin.js');

//SELECT
wp_enqueue_script('Nex-Forms-select', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap-select.js');


//SINGLE FILE UPLOAD
wp_enqueue_script('Nex-Forms-single-file-uplaod', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap.singlefile.upload.js');

//TYPE AHEAD AUTO COMPLETE
//wp_enqueue_script('Nex-Forms-type-ahead', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap.typeahead.js');

//TAGS
wp_enqueue_script('Nex-Forms-tags', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap-tagsinput.js');

//COLOR PALLET
wp_enqueue_script('Nex-Forms-bootstrap-colorpalette', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap-colorpalette.js');

//COLOR PICKER
wp_enqueue_script('Nex-Forms-bootstrap-color-picker', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap-colorpicker.js');

//MAX LENGHT
wp_enqueue_script('Nex-Forms-bootstrap-maxlength', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap-maxlength.min.js');

//ISOTOP
wp_enqueue_script('Nex-Forms-jquery.isotope.min', WP_PLUGIN_URL . '/Nex-Forms/js/jquery.isotope.min.js');

//APPEAR
wp_enqueue_script('Nex-Forms-appear', WP_PLUGIN_URL . '/Nex-Forms/js/jquery.appear.js');
wp_enqueue_script('Nex-Forms-waypoints.min', WP_PLUGIN_URL . '/Nex-Forms/js/waypoints.min.js');

//WISYWIG
wp_enqueue_script('Nex-Forms-bootstrap-wysiwyg', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap-wysiwyg.js');

//BOOTSTRO
wp_enqueue_script('Nex-Forms-bootstro.min', WP_PLUGIN_URL . '/Nex-Forms/js/bootstro.min.js');


//CUSTOM
wp_enqueue_script('Nex-Forms-ui', WP_PLUGIN_URL . '/Nex-Forms/js/ui.js');
wp_enqueue_script('Nex-Forms-onload', WP_PLUGIN_URL . '/Nex-Forms/js/nexf-onload.js');
wp_enqueue_script('Nex-Forms-form-validation', WP_PLUGIN_URL . '/Nex-Forms/js/nexf-form-validation.js');
wp_enqueue_script('Nex-Forms-drag-and-drop', WP_PLUGIN_URL . '/Nex-Forms/js/nexf-admin-drag-and-drop.js');
wp_enqueue_script('Nex-Forms-form-controls', WP_PLUGIN_URL . '/Nex-Forms/js/nexf-controls.js');


//FIELD SETTINGS
wp_enqueue_script('Nex-Forms-field-settings-main', WP_PLUGIN_URL . '/Nex-Forms/js/field_settings/main.js');

wp_print_scripts();
wp_print_styles();
}
?>