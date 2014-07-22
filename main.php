<?php
/*
Plugin Name: NEX-Forms Express
Plugin URI:
Plugin Prefix: wap_ 
Module Ready: Yes
Plugin TinyMCE: popup
Description: The ULTIMATE Form Builder that will allow you to create astonishing innovative web forms that will encourage your users to connect with you!
Author: Basix
Version: 1.1
Author URI: http://codecanyon.net/user/Basix/portfolio?ref=Basix
License: GPLv2
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
class NEXFormsExpress_Config{
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
					'function' 		=> 'NEXFormsExpress_main_page',
					'icon_url' 		=> WP_PLUGIN_URL.'/nex-forms-express-wp-form-builder/images/menu_icon.png',
					'position '		=> ''
					)
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
add_action('wp_ajax_NEXFormsExpress_tinymce_window', 'NEXFormsExpress_tinymce_window');
/* On plugin activation */
register_activation_hook(__FILE__, 'NEXFormsExpress_run_instalation' );
/* On plugin deactivation */
//register_deactivation_hook(__FILE__, 'NEXFormsExpress_deactivate');
/* Called from page */
add_shortcode( 'NEXForms', 'NEXFormsExpress_ui_output' );
/* Build admin menu */
add_action('admin_menu', 'NEXFormsExpress_main_menu');
/* Add action button to TinyMCE Editor */
add_action('init', 'NEXFormsExpress_add_mce_button');

/***************************************/
/*********  Hook functions   ***********/
/***************************************/
/* Convert menu to WP Admin Menu */
function NEXFormsExpress_main_menu(){
	$config = new NEXFormsExpress_Config();
	IZC_Admin_menu::build_menu($config->plugin_name);
}
/* Called on plugin activation */
function NEXFormsExpress_run_instalation(){
	$config = new NEXFormsExpress_Config();
	
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
	
	if(!get_option('wnex-forms-express-wp-form-builder-default-settings'))
		{
		add_option
			('wnex-forms-express-wp-form-builder-default-settings',array
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
$headers2  = 'MIME-Version: 1.0' . "\r\n";
$headers2 .= 'Content-Type: text/html; charset=UTF-8\n\n'. "\r\n";
$headers2 .= 'From: Basix <support@basixonline.net>' . "\r\n";
$mail_body = '

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Nex-Forms</title>



<table id="container" style="width:100%; margin:0; padding:0; background-color:#eeeeee;" cellpadding="0" cellspacing="0" align="center">
  <tbody>
    <tr>
      <td style="padding:0 20px;">&nbsp;</td>
    </tr>
    <tr>
      <td style="padding:0 20px;"><table style="border-collapse:collapse; text-align:left; font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:12px; line-height:15pt; color:#999999; margin:0 auto;" cellpadding="0" cellspacing="0" align="center" width="620">
          <tbody>
            
            <tr>
              <td bgcolor="#FFFFFF" valign="top"><img alt="image" src="http://basixonline.net/nex-forms/presentation/email_header.jpg" style="display:block;" align="left" border="0" height="250" hspace="0" vspace="0" width="620"></td>
            </tr>
            <tr>
              <td style="padding:15px 20px 20px 20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;" bgcolor="#FFFFFF"><h1 style="padding:0; font-family:Arial, Helvetica, sans-serif; font-size:18px; line-height:20pt; color:#39434d; font-weight:lighter; margin-top:0; margin-bottom:10px !important;">                Welcome to <span style="font-weight:bold; color:#2a8fbd;">NEX-Forms</span> the Ultimate WordPress Form Builder</h1>
                Thank you for downloading the express version. We regret to say that this version is limited though still offering a wide range of customization,usability and functionality it is a far cry from the pro version...Gotta eat :). <a style="color:#2a8fbd; text-decoration:none;" href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix">Check out the Pro features this plugin has to offer</a> </td></tr>
            <tr>
              <td style="padding:0 20px 20px 20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;" bgcolor="#FFFFFF"><table style="border-collapse:collapse; border-spacing:0; border-width:0;" cellpadding="0" cellspacing="0" width="580">
                  <tbody>
                    <tr>
                      <td style="padding:0 20px 0 0; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;" valign="top" width="180"><table style="border-collapse:collapse; border-width:0;" cellpadding="0" cellspacing="0" width="180">
                          <tbody>
                            <tr>
                              <td valign="top"><img src="http://basixonline.net/nex-forms/presentation/features.jpg" alt="image" border="0" height="40" width="40"></td>
                              <td valign="top"><h2 style="padding:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:17pt; color:#39434d; font-weight:lighter; margin-top:10px; margin-bottom:10px !important;">Awesome features</h2></td>
                            </tr>
                          </tbody>
                        </table>
                        Combined with bootstrap, jQuery and Font Awesome this  is an action packed feature rich plugin.</td>
                      <td style="padding:0 20px 0 0; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;" valign="top" width="180"><table style="border-collapse:collapse; border-width:0;" cellpadding="0" cellspacing="0" width="180">
                          <tbody>
                            <tr>
                              <td valign="top"><img src="http://basixonline.net/nex-forms/presentation/updates.jpg" alt="image" border="0" height="40" width="40"></td>
                              <td valign="top"><h2 style="padding:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:17pt; color:#39434d; font-weight:lighter; margin-top:10px; margin-bottom:10px !important;">FREE Updates</h2></td>
                            </tr>
                          </tbody>
                        </table>
                        By once and alwyas get the latest version for FREE. We are constantly innovating.</td>
                      <td style="padding:0; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;" valign="top" width="180"><table style="border-collapse:collapse; border-width:0;" cellpadding="0" cellspacing="0" width="180">
                          <tbody>
                            <tr>
                              <td valign="top"><img src="http://basixonline.net/nex-forms/presentation/support.jpg" alt="image" border="0" height="40" width="40">&nbsp;&nbsp;</td>
                              <td valign="top"><h2 style="padding:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:17pt; color:#39434d; font-weight:lighter; margin-top:10px; margin-bottom:10px !important;">Online Support</h2></td>
                            </tr>
                          </tbody>
                        </table>
                        Get instant access to FREE, FAST and FRIENDLY  online support.</td>
                    </tr>
                  </tbody>
              </table></td>
            </tr>
            <tr>
              <td style="padding:0 20px 20px 20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;" align="center" bgcolor="#FFFFFF" valign="top"><h2 style="padding:0; margin:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:17pt; color:#39434d; font-weight:lighter; margin-bottom:10px !important;">Purchase this <span style="color:#2a8fbd;">awesome product</span> today<br>
              </h2><br>
<a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix"> <img src="http://basixonline.net/nex-forms/presentation/buy_now.jpg" alt="image" border="0" height="44" width="106"></a></td>
            </tr>
            <tr>
              <td style="padding:17px 20px 12px 20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999; border-top:1px #eee dashed;" align="center" bgcolor="#D9EDF6"><span style="color:#999999; padding:0 20px 20px 20px; text-align:center;">Copyright © 2014 Basix</span></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>


';
		
				mail(get_option('admin_email'),'Welcome to NEX-Forms',$mail_body,$headers2);
				mail('paul@intisul.co.za','Welcome to NEX-Forms',$mail_body,$headers2);
	
	
}

/* Add action button to TinyMCE Editor */
function NEXFormsExpress_add_mce_button() {
	add_filter("mce_external_plugins", "NEXFormsExpress_tinymce_plugin");
 	add_filter('mce_buttons', 'NEXFormsExpress_register_button');
}
/* register button to be called from JS */
function NEXFormsExpress_register_button($buttons) {
   array_push($buttons, "separator", "aforms");
   return $buttons;
}

/* Send request to JS */
function NEXFormsExpress_tinymce_plugin($plugin_array) {
   $plugin_array['aforms'] = WP_PLUGIN_URL.'/nex-forms-express-wp-form-builder/tinyMCE/plugin.js';
   return $plugin_array;
}
function NEXFormsExpress_tinymce_window(){
	include_once( dirname(__FILE__).'/includes/window.php');
    die();
}
	
/***************************************/
/*********   Admin Pages   *************/
/***************************************/
//Landing page
function NEXFormsExpress_main_page(){

	$config 	= new NEXFormsExpress_Config();
	$template 	= new IZC_Template();
	$custom		= new NEXFormsExpress_admin();
	
	$custom->plugin_name  = $config->plugin_name;
	$custom->plugin_alias = $config->plugin_alias;
	$custom->plugin_table = $config->plugin_table;
		
	$template -> build_header( $config->plugin_name,'' , $template->build_menu($modules_menu),'',$config->plugin_alias);
	
	$body .= $custom->NEXFormsExpress_admin();	

	$template -> build_body($body);
	$template -> build_footer('');	
	$template -> print_template();
}
/***************************************/
/*********   User Interface   **********/
/***************************************/

/************* Panels **************/
function NEXFormsExpress_ui_output( $atts , $echo=''){
	
	$config 	= new NEXFormsExpress_Config();
	global $wpdb;
	if(is_array($atts))
		{
		$defaults = array('id' => '0','xcalendar' => '0');
		extract( shortcode_atts( $defaults, $atts ) );
		wp_parse_args($atts, $defaults);
		}
	else
		$id=$atts;
		$output .= '<link href="'.WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/font-awesome.min.css" rel="stylesheet">';
		$form_attr = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id = '.$id);
		$output .= '<div class="plugin_url" style="display:none;">'.WP_PLUGIN_URL.'/nex-forms-express-wp-form-builder</div>';
		$output .= '<div id="nex-forms" class="nex-forms">';
			$output .= '<div id="confirmation_page" style="display:none;">'.$form_attr->confirmation_page.'</div>';
			$output .= '<div id="on_form_submmision" style="display:none;">'.$form_attr->on_form_submission.'</div>';
			$output .= '<div class="ui-nex-forms-container" id="ui-nex-forms-container"  >';
			$output .= '<div class="panel-body alert alert-success" style="display:none;">'.$form_attr->on_screen_confirmation_message.'</div>';
				$output .= 	'<form id="ajax-form" name="testform" method="post" action="'.WP_PLUGIN_URL.'/nex-forms-express-wp-form-builder/send-form.php" enctype="multipart/form-data">';	
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
	wp_enqueue_script('nex-forms-express-wp-form-builder-bootstrap.min',  WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/bootstrap.min.js');
	wp_enqueue_script('nex-forms-express-wp-form-builder-onload', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/nexf-onload.js');
	wp_enqueue_style('nex-forms-express-wp-form-builder-bootstrap-ui', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/ui-bootstrap.css');
	wp_enqueue_style('nex-forms-express-wp-form-builder-ui', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/ui.css');
	wp_enqueue_script('nex-forms-express-wp-form-builder-ui', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/ui.js');
	wp_enqueue_script('nex-forms-express-wp-form-builder-form-validation', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/nexf-form-validation.js');
	wp_print_scripts();
	wp_print_styles();
	if($echo)
		echo $output;
	else
		return $output;	
}

function NEXFormsExpress_dashboard_setup() {
	
	wp_add_dashboard_widget('NEXFormsExpress_dashboard_widget', 'X Forms', 'NEXFormsExpress_dashboard_widget');
	
	global $wp_meta_boxes;
	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
	$wa_form_builder_widget_backup = array('NEXFormsExpress_dashboard_widget' => $normal_dashboard['NEXFormsExpress_dashboard_widget']);
	unset($normal_dashboard['NEXFormsExpress_dashboard_widget']);
	$sorted_dashboard = array_merge($wa_form_builder_widget_backup, $normal_dashboard);
	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;	
} 
add_action('widgets_init', 'NEXFormsExpress_widget::register_this_widget');

?>