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
include('styles-font-menu/plugin.php');
//include('styles-font-menu/plugin.php');
/***************************************/
/**************  ADMIN  ****************/
/***************************************/
if(is_admin() && ( isset($_GET['page']) && strstr($_GET['page'],'nex-forms'))){
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
wp_enqueue_style('nex-forms-admin-holy-grail.min', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/holy-grail.css');
//BOOTSTRAP
wp_enqueue_style('nex-forms-bootstrap.min', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/bootstrap.min.css');
wp_enqueue_style('nex-forms-bootstrap-fields', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/fields.css');
//nex-forms ADMIN
wp_enqueue_style('nex-forms-admin', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/admin.css');
//nex-forms UI
wp_enqueue_style('nex-forms-ui', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/ui.css');
//JQUERY UI
wp_enqueue_style('nex-forms-jQuery-UI',WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/jquery-ui.min.css');
/* JS */
//BOOTSTRAP
wp_enqueue_script('nex-forms-bootstrap.min',  WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/bootstrap.min.js');
wp_enqueue_script('nex-forms-fields', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/fields.js');
//ISOTOP
wp_enqueue_script('nex-forms-jquery.isotope.min', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/jquery.isotope.min.js');
//CUSTOM
wp_enqueue_script('nex-forms-ui', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/ui.js');
wp_enqueue_script('nex-forms-onload', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/nexf-onload.js');
wp_enqueue_script('nex-forms-form-validation', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/nexf-form-validation.js');
wp_enqueue_script('nex-forms-drag-and-drop', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/nexf-admin-drag-and-drop.js');
wp_enqueue_script('nex-forms-form-controls', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/nexf-controls.js');
//FIELD SETTINGS
wp_enqueue_script('nex-forms-field-settings-main', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/main.js');
//LOGIC
wp_enqueue_script('nex-forms-field-logic', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/logic.js');
wp_print_scripts();
wp_print_styles();
}
?>