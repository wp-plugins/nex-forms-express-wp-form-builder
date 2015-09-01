<?php
//JS Dependancies
wp_enqueue_script('jquery');
/***************************************/
/**********  CORE CLASSES  *************/
/***************************************/
include_once( 'class.admin.php');
include_once( 'class.install.php');
include_once( 'class.db.php');
include_once( 'class.admin_menu.php');
include_once( 'class.template.php');
include_once( 'class.functions.php');
include('styles-font-menu/plugin.php');
/***************************************/
/**************  ADMIN  ****************/
/***************************************/
if(is_admin() && ( isset($_GET['page']) && ($_GET['page']=='nex-forms-main') || $_GET['page']=='nex-forms-form-builder')){
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
wp_enqueue_script('jquery-form');
//}
/* CSS */
//JQUERY
wp_enqueue_style('jquery-ui');

/***************/
/*** CUSTOM  ***/
/***************/	
/* CSS */
//HOLY GRAIL
wp_enqueue_style('nex-forms-admin-holy-grail.min', plugins_url('/css/holy-grail.css',dirname(dirname(__FILE__))));
//BOOTSTRAP
wp_enqueue_style('nex-forms-bootstrap.min', plugins_url( '/css/bootstrap.min.css',dirname(dirname(__FILE__))));
wp_enqueue_style('nex-forms-bootstrap-fields', plugins_url( '/css/fields.css',dirname(dirname(__FILE__))));
wp_enqueue_style('nex-forms-font-awesome',plugins_url('/css/font-awesome.min.css',dirname(dirname(__FILE__))));

//nex-forms ADMIN
$other_config = get_option('nex-forms-other-config');
if($other_config['enable-color-adapt']==1 || !array_key_exists('enable-color-adapt',$other_config))
	wp_enqueue_style('nex-forms-admin', plugins_url('/css/admin.css',dirname(dirname(__FILE__))));
else
	wp_enqueue_style('nex-forms-admin', plugins_url('/css/admin-color-adapt.css',dirname(dirname(__FILE__))));
//nex-forms UI
wp_enqueue_style('nex-forms-ui', plugins_url( '/css/ui.css',dirname(dirname(__FILE__))));
//JQUERY UI
wp_enqueue_style('nex-forms-jQuery-UI',plugins_url( '/css/jquery-ui.min.css',dirname(dirname(__FILE__))));
/* JS */


//BOOTSTRAP
wp_enqueue_script('nex-forms-bootstrap.min',  plugins_url( '/js/bootstrap.min.js',dirname(dirname(__FILE__))));

wp_enqueue_script('nex-forms-moment.min', plugins_url( '/js/moment.min.js',dirname(dirname(__FILE__))));
wp_enqueue_script('nex-forms-locales.min', plugins_url( '/js/locales.js',dirname(dirname(__FILE__))));

wp_enqueue_script('nex-forms-bootstrap-datetimepicker', plugins_url( '/js/bootstrap-datetimepicker.js',dirname(dirname(__FILE__))));
wp_enqueue_script('nex-forms-fields', plugins_url( '/js/fields.js',dirname(dirname(__FILE__))));
//CUSTOM
wp_enqueue_script('nex-forms-ui', plugins_url( '/js/ui.js',dirname(dirname(__FILE__))));
wp_enqueue_script('nex-forms-onload', plugins_url( '/js/nexf-onload.js',dirname(dirname(__FILE__))));
wp_enqueue_script('nex-forms-form-validation', plugins_url( '/js/nexf-form-validation.js',dirname(dirname(__FILE__))));
wp_enqueue_script('nex-forms-drag-and-drop', plugins_url( '/js/nexf-admin-drag-and-drop.js',dirname(dirname(__FILE__))));
wp_enqueue_script('nex-forms-form-controls', plugins_url( '/js/nexf-controls.js',dirname(dirname(__FILE__))));
wp_enqueue_script('nex-forms-math.min',  plugins_url( '/js/math.min.js',dirname(dirname(__FILE__))));
wp_enqueue_script('nex-forms-jquery.tinymce',  plugins_url( '/js/tiny_mce/jquery.tinymce.js',dirname(dirname(__FILE__))));

//FIELD SETTINGS
wp_enqueue_script('nex-forms-field-settings-main', plugins_url( '/js/main.js',dirname(dirname(__FILE__))));
//LOGIC
wp_enqueue_script('nex-forms-field-logic', plugins_url( '/js/logic.js',dirname(dirname(__FILE__))));

wp_register_script('core-functions', plugins_url( '/includes/Core/js/functions.js',dirname(dirname(__FILE__))));
	wp_enqueue_script('core-functions');

//wp_enqueue_script('nex-forms-modernizr.custom.63321', plugins_url( '/js/modernizr.custom.63321.js',dirname(dirname(__FILE__))));
wp_enqueue_script('nex-forms-jquery.dropdown', plugins_url( '/js/jquery.dropdown.js',dirname(dirname(__FILE__))));

/***************************************/
/**************  PUBLIC  ***************/
/***************************************/
//JS


//CSS
wp_register_style('defaults', plugins_url( '/includes/Core/css/defaults.css',dirname(dirname(__FILE__))));
wp_enqueue_style('defaults');

wp_print_scripts();
wp_print_styles();
}



?>