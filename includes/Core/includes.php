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
wp_enqueue_style('nex-forms-express-wp-form-builder-admin-holy-grail.min', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/holy-grail.css');
//JQUERY
wp_enqueue_style('nex-forms-express-wp-form-builder-jquery-custom', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/ui-themes/default/jquery.ui.theme.css');
//FONT-AWSOME (doesnt work with enqueue)????
//wp_enqueue_style('nex-forms-express-wp-form-builder-fontawesome.min', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/font-awesome.min.css');
//BOOTSTRAP
wp_enqueue_style('nex-forms-express-wp-form-builder-bootstrap.min', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/bootstrap.min.css');
wp_enqueue_style('nex-forms-express-wp-form-builder-bootstrap-datepicker', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/datepicker.css');
wp_enqueue_style('nex-forms-express-wp-form-builder-bootstrap-nexchecks', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/nexchecks.css');
//nex-forms-express-wp-form-builder ADMIN
wp_enqueue_style('nex-forms-express-wp-form-builder-admin', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/admin.css');
//nex-forms-express-wp-form-builder UI
//JQUERY UI
wp_enqueue_style('nex-forms-express-wp-form-builder-jQuery-UI',WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/jquery-ui.min.css');
//SVG DRAWING
//RATY
wp_enqueue_style('nex-forms-express-wp-form-builder-raty', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/raty.css');
//SELECT
wp_enqueue_style('nex-forms-express-wp-form-builder-select', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/bootstrap-select.css');
//SINGLE FILE UPLOAD
wp_enqueue_style('nex-forms-express-wp-form-builder-single-file-uplaod', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/bootstrap.singlefile.upload.css');
//TAGS
wp_enqueue_style('nex-forms-express-wp-form-builder-tags', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/bootstrap-tagsinput.css');
//COLOR PALLET
wp_enqueue_style('nex-forms-express-wp-form-builder-bootstrap-colorpalette', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/bootstrap-colorpalette.css');
//COLOR PICKER
wp_enqueue_style('nex-forms-express-wp-form-builder-bootstrap-color-picker', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/bootstrap-colorpicker.css');
//BOOTSTRO
wp_enqueue_style('nex-forms-express-wp-form-builder-bootstro.min', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/bootstro.min.css');
/* JS */
//BOOTSTRAP
wp_enqueue_script('nex-forms-express-wp-form-builder-bootstrap.min',  WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/bootstrap.min.js');
wp_enqueue_script('nex-forms-express-wp-form-builder-bootstrap-datepicker.min', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/bootstrap-datepicker.js');
wp_enqueue_script('nex-forms-express-wp-form-builder-bootstrap-nexchecks', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/nexchecks.js');
//SVG DRAWING
wp_enqueue_script('nex-forms-express-wp-form-builder-svg-1-admin', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/classie.js');
wp_enqueue_script('nex-forms-express-wp-form-builder-svg-2-admin', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/svganimations.js');
//RATY
wp_enqueue_script('nex-forms-express-wp-form-builder-raty', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/jquery.raty.min.js');
//TOUCH SPIN
wp_enqueue_script('nex-forms-express-wp-form-builder-spinner', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/bootstrap.touchspin.js');
//SELECT
wp_enqueue_script('nex-forms-express-wp-form-builder-select', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/bootstrap-select.js');
//SINGLE FILE UPLOAD
wp_enqueue_script('nex-forms-express-wp-form-builder-single-file-uplaod', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/bootstrap.singlefile.upload.js');
//TAGS
wp_enqueue_script('nex-forms-express-wp-form-builder-tags', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/bootstrap-tagsinput.js');
//COLOR PALLET
wp_enqueue_script('nex-forms-express-wp-form-builder-bootstrap-colorpalette', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/bootstrap-colorpalette.js');
//COLOR PICKER
wp_enqueue_script('nex-forms-express-wp-form-builder-bootstrap-color-picker', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/bootstrap-colorpicker.js');
//MAX LENGHT
wp_enqueue_script('nex-forms-express-wp-form-builder-bootstrap-maxlength', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/bootstrap-maxlength.min.js');
//APPEAR
wp_enqueue_script('nex-forms-express-wp-form-builder-appear', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/jquery.appear.js');
wp_enqueue_script('nex-forms-express-wp-form-builder-waypoints.min', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/waypoints.min.js');
//BOOTSTRO
wp_enqueue_script('nex-forms-express-wp-form-builder-bootstro.min', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/bootstro.min.js');
//CUSTOM
wp_enqueue_script('nex-forms-express-wp-form-builder-onload', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/nexf-onload.js');
wp_enqueue_script('nex-forms-express-wp-form-builder-form-validation', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/nexf-form-validation.js');
wp_enqueue_script('nex-forms-express-wp-form-builder-drag-and-drop', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/nexf-admin-drag-and-drop.js');
wp_enqueue_script('nex-forms-express-wp-form-builder-form-controls', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/nexf-controls.js');
//FIELD SETTINGS
wp_enqueue_script('nex-forms-express-wp-form-builder-field-settings-main', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/field_settings/main.js');
wp_print_scripts();
wp_print_styles();
}
?>