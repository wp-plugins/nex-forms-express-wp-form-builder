<?php
/*
Plugin Name: NEX-Forms
Plugin URI:
Plugin Prefix: wap_ 
Module Ready: Yes
Plugin TinyMCE: popup
Description: The ULTIMATE Form Builder that will allow you to create astonishing web forms that will encourage your users to connect with you instead of running away at the thought of completing a form!
Author: Basix
Version: 1.0.6
Author URI: http://codecanyon.net/user/Basix/portfolio?ref=Basix
License: GPL
*/

//ini_set('error_reporting',0);
error_reporting(1);
wp_enqueue_script('jquery');


require( dirname(__FILE__) . '/includes/Core/includes.php');
require( dirname(__FILE__) . '/includes/class.admin.php');
require( dirname(__FILE__) . '/includes/class.form-entries.php');

define('SESSION_ID',rand(0,99999999999));


/***************************************/
/**********  Configuration  ************/
/***************************************/
class NEXForms_Config{
	/*************  General  ***************/
	/************  DONT EDIT  **************/
	public $plugin_version;
	/* The displayed name of your plugin */
	public $plugin_name;
	/* The alias of the plugin used by external entities */
	public $plugin_alias;
	/* Enable or disable external modules */
	public $enable_modules;
	/* Plugin Prefix */
	public $plugin_prefix;
	/* Plugin table */
	public $plugin_table, $component_table;
	/* Admin Menu */
	public $plugin_menu;
	/* Add TinyMCE */
	public $add_tinymce;
	
	
	/************* Database ****************/
	/* Sets the primary key for table created above */
	public $plugin_db_primary_key = 'Id';
	/* Database table fields array */
	public $plugin_db_table_fields = array
			(
			'title'								=>	'text',
			'description'						=>	'text',
			'mail_to'							=>  'text',
			'confirmation_mail_body'			=>  'longtext',
			'confirmation_mail_subject'			=>	'text',
			'from_address'						=>  'text',
			'from_name'							=>  'text',
			'on_screen_confirmation_message'	=>  'longtext',
			'confirmation_page'					=>  'text',
			'form_fields'						=>	'longtext',
			'visual_settings'					=>	'text',
			'google_analytics_conversion_code'  =>  'text',
			'colour_scheme'  					=>  'text',
			'send_user_mail'					=>  'text',
			'user_email_field'					=>  'text',
			'on_form_submission'				=>  'text',
			'date_sent'							=>  'datetime',
			'is_form'							=>  'text',
			'is_template'						=>  'text'
			);
			
	public $addtional_table_fields = array
			(
			'nex_forms_Id'			=>	'text',
			'meta_key'				=>	'text',
			'meta_value'			=>  'text',
			'time_added'			=>	'text'
			);	
	/************* Admin Menu **************/
	public function build_plugin_menu(){
	
		$plugin_alias  = $this->plugin_alias;
		$plugin_name  = $this->plugin_name;
				
		$this->plugin_menu = array
			(
			$this->plugin_name => array
				(
				'menu_page'	=>	array
					(
					'page_title' 	=> $this->plugin_name,
					'menu_title' 	=> $this->plugin_name,
					'capability' 	=> 'administrator',
					'menu_slug' 	=> ''.$plugin_alias.'-main',
					'function' 		=> 'NEXForms_main_page',
					'icon_url' 		=> WP_PLUGIN_URL.'/Nex-Forms/images/menu_icon.png',
					'position '		=> ''
					),
				/*'sub_menu_page'		=>	array
					(
					'Modules' => array
						(
						'parent_slug' 	=> ''.$plugin_alias.'-main',
						'page_title' 	=> 'Support',
						'menu_title' 	=> 'Support',
						'capability' 	=> 'administrator',
						'menu_slug' 	=> 'basix-support',
						'function' 		=> 'NEXForms_support_page',
						)
					)*/
				)		
			);
		}
	
	public function __construct()
		{ 
		$header_info = IZC_Functions::get_file_headers(dirname(__FILE__).DIRECTORY_SEPARATOR.'main.php');
		
		$this->plugin_version 	= $header_info['Version'];
		$this->plugin_name 		= $header_info['Plugin Name'];
		$this->enable_modules 	= ($header_info['Module Ready']='Yes') ? true : false ;
		$this->plugin_alias		= IZC_Functions::format_name($this->plugin_name);
		$this->plugin_prefix	= $header_info['Plugin Prefix'];
		$this->plugin_table		= $this->plugin_prefix.$this->plugin_alias;
		$this->component_table	= $this->plugin_table;
		$this->add_tinymce		= $header_info['Plugin TinyMCE'];
		$this->build_plugin_menu(); 
		}
}


/***************************************/
/*************  Hooks   ****************/
/***************************************/
add_action('wp_ajax_NEXForms_tinymce_window', 'NEXForms_tinymce_window');
/* On plugin activation */
register_activation_hook(__FILE__, 'NEXForms_run_instalation' );
/* On plugin deactivation */
//register_deactivation_hook(__FILE__, 'NEXForms_deactivate');
/* Called from page */
add_shortcode( 'NEXForms', 'NEXForms_ui_output' );
/* Build admin menu */
add_action('admin_menu', 'NEXForms_main_menu');
/* Add action button to TinyMCE Editor */
add_action('init', 'NEXForms_add_mce_button');

/***************************************/
/*********  Hook functions   ***********/
/***************************************/
/* Convert menu to WP Admin Menu */
function NEXForms_main_menu(){
	$config = new NEXForms_Config();
	IZC_Admin_menu::build_menu($config->plugin_name);
}
/* Called on plugin activation */
function NEXForms_run_instalation(){
	$config = new NEXForms_Config();
	
	update_option('nex-forms-version',$config->plugin_version);
	if(!get_option('basix-client-id'))
		add_option('basix-client-id',rand(10000000,99999999));
		
	$instalation = new IZC_Instalation();
	$instalation->component_name 			=  $config->plugin_name;
	$instalation->component_prefix 			=  $config->plugin_prefix;
	$instalation->component_alias			=  'nex_forms';
	$instalation->component_default_fields	=  $config->default_fields;
	$instalation->component_menu 			=  $config->plugin_menu;	
	$instalation->db_table_fields			=  $config->plugin_db_table_fields;
	$instalation->db_table_primary_key		=  $config->plugin_db_primary_key;
	$instalation->run_instalation('full');
	
	/************************************************/
	/************  Additional Table   ***************/
	/************************************************/
	$extra_instalation = new IZC_Instalation();
	$extra_instalation->component_prefix 		=  $config->plugin_prefix;
	$extra_instalation->component_alias			=  'nex_forms_meta';
	$extra_instalation->db_table_fields			=  $config->addtional_table_fields;
	$extra_instalation->db_table_primary_key	=  $config->plugin_db_primary_key;
	$extra_instalation->install_component_table();
	
	if(!get_option('wNex-Forms-default-settings'))
		{
		add_option
			('wNex-Forms-default-settings',array
				(
				'send_user_mail' => 'No',
				'mail_to' => get_option('admin_email'),
				'confirmation_mail_subject' => get_option('blogname').' XForm Submission',
				'confirmation_mail_body' => 'Thank you for connecting with us. We will respond to you shortly.[form_data]',
				'from_address' => get_option('admin_email'),
				'from_name' => get_option('blogname'),
				'on_screen_confirmation_message' => 'Thank you for connecting with us. We will respond to you shortly.',
				)
			);
		}
	
	
}

/* Add action button to TinyMCE Editor */
function NEXForms_add_mce_button() {
	add_filter("mce_external_plugins", "NEXForms_tinymce_plugin");
 	add_filter('mce_buttons', 'NEXForms_register_button');
}
/* register button to be called from JS */
function NEXForms_register_button($buttons) {
   array_push($buttons, "separator", "aforms");
   return $buttons;
}

/* Send request to JS */
function NEXForms_tinymce_plugin($plugin_array) {
   $plugin_array['aforms'] = WP_PLUGIN_URL.'/Nex-Forms/tinyMCE/plugin.js';
   return $plugin_array;
}
function NEXForms_tinymce_window(){
	include_once( dirname(__FILE__).'/includes/window.php');
    die();
}
	
/***************************************/
/*********   Admin Pages   *************/
/***************************************/
//Landing page
function NEXForms_main_page(){

	$config 	= new NEXForms_Config();
	$template 	= new IZC_Template();
	$custom		= new NEXForms_admin();
	
	$custom->plugin_name  = $config->plugin_name;
	$custom->plugin_alias = $config->plugin_alias;
	$custom->plugin_table = $config->plugin_table;
		
	$template -> build_header( $config->plugin_name,'' , $template->build_menu($modules_menu),'',$config->plugin_alias);
	
	$body .= $custom->NEXForms_admin();	

	$template -> build_body($body);
	$template -> build_footer('');	
	$template -> print_template();
}

function NEXForms_support_page(){
 	$config 	= new NEXForms_Config();
	$template 	= new IZC_Template();
	$custom		= new NEXForms_admin();
	
	$custom->plugin_name  = $config->plugin_name;
	$custom->plugin_alias = $config->plugin_alias;
	$custom->plugin_table = $config->plugin_table;
		
	$template -> build_header( 'sdfasdf','' , $template->build_menu($modules_menu),'',$config->plugin_alias);

	$body .= '
	
	<form name="basix_support" method="post" action="http://basixonline.net/support/">
		<input type="hidden" name="basix_client_id" value="'.get_option('basix-client-id').'">
		<div class="wrap"><h1 class="">NEX-Forms - Support</h1><br class="clear"><div class="header_info"></div><div class="iz-ajax-response" id="ajax-response"></div><div id="col-container">
	  </div>
	  <div id="col-left">
		<div class="col-wrap">
          <input type="hidden" name="action" value="xpsk_create_new_plugin">
		  <h2>Basix Client ID: #'.get_option('basix-client-id').'</h2>
			<div class="iz-ajax-response" id="ajax-response"></div>
			<div class="form-fields">			
				<h3>Ticket Information</h3>
				
				<div class="form-field">
					<label for="envato_username">Envato Username</label><input type="text" name="envato_username" value="" id="envato_username" class="">
					<p class="description">Please provide for reference</p><br />
				</div>
				<div class="form-field">
					<label for="client_name">Name</label><input type="text" name="client_name" value="" id="client_name" class="">
					<p class="description">Please provide so we can address you properly</p><br />
				</div>
				<div class="form-field">
					<label for="email">Email Address</label><input type="text" name="email" value="'.get_bloginfo('admin_email').'" id="email" class="">
					<p class="description">We will send updates to this address!</p><br />
				</div>
				<div class="form-field">
					<label for="problem_category">Category</label><br />
					<select name="problem_category" id="problem_category" class="">
						<option value="">--- Please select ---</option>
						<optgroup label="General Enquery">
							<option value="Suggetions">Using NEX-Forms</option>
							<option value="Suggetions">Suggetions (feature improvements)</option>
						</optgroup>
						<optgroup label="Bugs">
							<option value="Styling issues">Styling issues (CSS)</option>
							<option value="Field Settings not working">Field Settings not working (javascript)</option>
							<option value="javascript">Form Settings not working (javascript)</option>
							<option value="javascript">Autoresponder email problems (serverside)</option>
							<option value="javascript">Problems with Animations (javascript + CSS)</option>
							<option value="javascript">Other (please be descritive in your comment)</option>
						</optgroup>
					</select>
					<p class="description">Help us to get to the problem faster</p><br />
				</div>
				
				<div class="form-field">
					<label for="comment">Comment</label><textarea name="comment" id="comment"></textarea>
					<p class="description">Please be very descriptive to encourage fast results</p><br />
				</div>
				<div class="form-field">
					<label for="test_page">Website Test Link</label><input type="text" name="test_page" value="" id="test_page" class="">
					<p class="description">Add a link to your website were a form has been added</p>	<br />			  
				</div>
				
				<h3>Systems Information</h3>
				<div class="form-field">
					<label for="plugin_author">Browser</label><input type="text" name="browser" value="" id="browser" class="">
					<p class="description">Please specify what browser(s) you are using</p><br />
				</div>
				
				<div class="form-field">
					<label for="wp_version">WordPress Version</label><input type="text" name="wp_version" value="'.get_bloginfo('version').'" id="wp_version" class="">
					<p class="description">This is the current wordpress version you are using</p><br />
				</div>
				
				<div class="form-field">
					<label for="plugin_version">Plugin Version</label><input type="text" name="plugin_version" value="'.get_option('nex-forms-version').'" id="plugin_version" class="">
					<p class="description">This is the current plugin version you are using</p><br />
				</div>
				
				<h3>Admin Information</h3>
				<p class="description">Note: You should delete temp access as soon as this ticket is resolved.</p><br />
				<div class="form-field">
					<label for="backend_link">Backend Link</label><input type="text" name="backend_link" value="'.get_option('siteurl').'" id="backend_link" class="">
					<p class="description">The link to your backend (if needed)</p><br />			  
				</div>
				<div class="form-field">
					<label for="temp_username">Temporary username</label><input type="text" name="temp_username" value="basix" id="temp_username" class="">
					<p class="description">Temporary username to resolve problems (this speeds up the process)</p><br />
				</div>
				
				<div class="form-field">
					<label for="temp_password">Temporary password</label><input type="password" name="temp_password" value="" id="temp_password" class="">
					<p class="description">Temporary password to resolve problems (this speeds up the process)</p>
				</div>
			</div>
          </div>
          <div class="submit">
            <p class="submit">
              <input type="submit" value="      Create Ticket       " class="iz-submit button-primary iz-plugin-submit" data-action="iz-insert" id="submit" name="submit">
            </p>
          </div>
        
  </div>
</div><div class="footer" style="clear:both"></div></div>
	
	</form>
	<style type="text/css">
	#wpfooter{
		display:none;
	</style>
	';	

	$template -> build_body($body);
	$template -> build_footer('');	
	$template -> print_template();	
}
/***************************************/
/*********   User Interface   **********/
/***************************************/

/************* Panels **************/
function NEXForms_ui_output( $atts , $echo=''){
	
	$config 	= new NEXForms_Config();
	global $wpdb;
	
	if(is_array($atts))
		{
		$defaults = array('id' => '0','xcalendar' => '0');
		extract( shortcode_atts( $defaults, $atts ) );
		wp_parse_args($atts, $defaults);
		}
	else
		$id=$atts;
		
		$output .= '<link href="'.WP_PLUGIN_URL . '/Nex-Forms/css/font-awesome.min.css" rel="stylesheet">';
		
		$form_attr = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id = '.$id);
		$output .= '<div class="plugin_url" style="display:none;">'.WP_PLUGIN_URL.'/Nex-Forms</div>';
		$output .= '<div id="nex-forms" class="nex-forms">';
			$output .= '<div id="confirmation_page" style="display:none;">'.$form_attr->confirmation_page.'</div>';
			$output .= '<div id="on_form_submmision" style="display:none;">'.$form_attr->on_form_submission.'</div>';
			$output .= '<div class="ui-nex-forms-container" id="ui-nex-forms-container"  >';
			$output .= '<div class="panel-body alert alert-success" style="display:none;">'.$form_attr->on_screen_confirmation_message.'</div>';
				$output .= 	'<form id="ajax-form" name="testform" method="post" action="'.WP_PLUGIN_URL.'/Nex-Forms/send-form.php" enctype="multipart/form-data">';	
					$output .= '<input type="hidden" name="action" value="insert_data">';
					$output .= '<input type="hidden" name="xform_submit" value="true">';
					$output .= '<input type="hidden" name="nex_forms_Id" value="'.$id.'">';
					$output .= '<input type="hidden" name="current_page" value="'.$current_page.'">';
					$output .= '<input type="hidden" name="ajaxurl" value="'.get_option('siteurl').'/wp-admin/admin-ajax.php">';
					$output .= '<input type="text" name="company_url" value="" placeholder="enter company url" class="form-control req">';			
					$output .=  str_replace('\\','',$form_attr->form_fields);
					$output .= '<div style="clear:both;"></div>';
				$output .= 	'</form>';
			$output .= '</div>';
		$output .= '</div>';
		
	/* UI JS AND STYLE INCLUDES */		
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-mouse');
	wp_enqueue_script('jquery-ui-position');
	wp_enqueue_script('jquery-ui-autocomplete');
	wp_enqueue_script('jquery-ui-menu');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('jquery-ui-spinner');
	wp_enqueue_script('jquery-ui-button');
	wp_enqueue_script('jquery-ui-tooltip');
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
	//TAGS
	wp_enqueue_script('Nex-Forms-tags', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap-tagsinput.js');
	//COLOR PALLET
	wp_enqueue_script('Nex-Forms-bootstrap-colorpalette', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap-colorpalette.js');
	//COLOR PICKER
	wp_enqueue_script('Nex-Forms-bootstrap-color-picker', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap-colorpicker.js');
	//MAX LENGHT
	wp_enqueue_script('Nex-Forms-bootstrap-maxlength', WP_PLUGIN_URL . '/Nex-Forms/js/bootstrap-maxlength.min.js');
	//Onload
	wp_enqueue_script('Nex-Forms-onload', WP_PLUGIN_URL . '/Nex-Forms/js/nexf-onload.js');
	//APPEAR
	wp_enqueue_script('Nex-Forms-appear', WP_PLUGIN_URL . '/Nex-Forms/js/jquery.appear.js');
	wp_enqueue_script('Nex-Forms-waypoints.min', WP_PLUGIN_URL . '/Nex-Forms/js/waypoints.min.js');
	//FONT-AWSOME
	wp_enqueue_style('Nex-Forms-fontawesome.min', WP_PLUGIN_URL . '/Nex-Forms/css/font-awesome.min.css');
	//BOOTSTRAP
	wp_enqueue_style('Nex-Forms-bootstrap-ui', WP_PLUGIN_URL . '/Nex-Forms/css/ui-bootstrap.css');
	wp_enqueue_style('Nex-Forms-bootstrap-datepicker', WP_PLUGIN_URL . '/Nex-Forms/css/datepicker.css');
	wp_enqueue_style('Nex-Forms-bootstrap-nexchecks', WP_PLUGIN_URL . '/Nex-Forms/css/nexchecks.css');
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
	wp_enqueue_script('Nex-Forms-ui', WP_PLUGIN_URL . '/Nex-Forms/js/ui.js');
	//VALIDATIION
	wp_enqueue_script('Nex-Forms-form-validation', WP_PLUGIN_URL . '/Nex-Forms/js/nexf-form-validation.js');
	//LOAD SCRIPTS AND STYLES
	wp_print_scripts();
	wp_print_styles();
	
	if($echo)
		echo $output;
	else
		return $output;	
}

/*function NEXForms_dashboard_widget(){
	
	wp_enqueue_style ('Xf-dashboard',WP_PLUGIN_URL . '/X%20Forms/css/dashboard.css');
	global $wpdb;
	$get_forms = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wap_x_forms ORDER BY title ASC');
	
	$output .= '<div class="dashboard_wrapper">';
		$output .= '<div class="logo_big"></div>';
		
			$output .= '<div class="form_holder header"><div class="form_name"><h4 style="border-right: 1px solid #CCCCCC;">Forms</h4></div><div class="form_entry_count"><h4>Total Entries</h4></div><div style="clear:both;"></div></div>';
			$output .= '';
			$output .= '<div class="table">';
			foreach($get_forms as $form)
				$output .= '<div class="form_holder form"><div class="form_name" ><a href="'.get_option('siteurl').'/wp-admin/admin.php?page=WA-x_forms-main&form_id='.$form->Id.'">'.$form->title.'</a></div><div class="form_entry_count">('.IZFForms::get_total_form_entries($form->Id).')</div><div style="clear:both;"></div></div>';
		$output .= '</div>';
	$output .= '</div>';
	
	echo $output;
}*/

function NEXForms_dashboard_setup() {
	
	wp_add_dashboard_widget('NEXForms_dashboard_widget', 'X Forms', 'NEXForms_dashboard_widget');
	
	global $wp_meta_boxes;
	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
	$wa_form_builder_widget_backup = array('NEXForms_dashboard_widget' => $normal_dashboard['NEXForms_dashboard_widget']);
	unset($normal_dashboard['NEXForms_dashboard_widget']);
	$sorted_dashboard = array_merge($wa_form_builder_widget_backup, $normal_dashboard);
	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;	
} 

//add_action('wp_dashboard_setup', 'NEXForms_dashboard_setup' );
add_action('widgets_init', 'NEXForms_widget::register_this_widget');
?>