<?php
/*
Plugin Name: NEX-Forms
Plugin URI: https://wordpress.org/plugins/nex-forms-express-wp-form-builder/
Plugin Prefix: wap_ 
Module Ready: Yes
Plugin TinyMCE: popup
Description: (EXPRESS VERSION) The Ultimate Drag and Drop WordPress forms builder
Author: Basix
Version: 3.4
Author URI: http://codecanyon.net/user/Basix/portfolio?ref=Basix
License: GPL
*/
ini_set('error_reporting',0);
error_reporting(1);

require( dirname(__FILE__) . '/includes/Core/includes.php');
require( dirname(__FILE__) . '/includes/class.admin.php');
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
			'is_template'						=>  'text',
			'hidden_fields'						=>  'longtext',
			'custom_url'						=>  'text',
			'post_type'							=>  'text',
			'post_action'						=>  'text'
			);
	
	public $default_fields = array
		(
		'nex_forms_Id' => array
			(
			'grouplabel'	=>	'nex_forms_Id',
			'type'			=>	'text',
			'req'			=>	'1',
			'items'			=>	'',
			'origen'		=>	'plugin'
			),
		'page' => array
			(
			'grouplabel'	=>	'page',
			'type'			=>	'text',
			'req'			=>	'1',
			'items'			=>	'',
			'origen'		=>	'default'
			),
		
		
		'ip' => array
			(
			'grouplabel'	=>	'ip',
			'type'			=>	'text',
			'req'			=>	'1',
			'items'			=>	'',
			'origen'		=>	'default'
			),
		'user_Id' => array
			(
			'grouplabel'	=>	'user_Id',
			'type'			=>	'text',
			'req'			=>	'1',
			'items'			=>	'',
			'origen'		=>	'default'
			),
		'date_time' => array
			(
			'grouplabel'	=>	'date_time',
			'type'			=>	'date',
			'req'			=>	'1',
			'items'			=>	'',
			'origen'		=>	'default'
			),
		'form_data' => array
			(
			'grouplabel'	=>	'form_data',
			'type'			=>	'textarea',
			'req'			=>	'1',
			'items'			=>	'',
			'origen'		=>	'default'
			)
		);
			
	public $addtional_table_fields = array
			(
			'nex_forms_Id'			=>	'text',
			'page'					=>	'text',
			'ip'					=>  'text',
			'user_Id'				=>	'text',
			'viewed'				=>	'text',
			'date_time'				=>  'datetime',
			'form_data'				=>	'longtext'
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
					'icon_url' 		=> WP_PLUGIN_URL.'/nex-forms-express-wp-form-builder/images/menu_icon.png',
					'position '		=> ''
					),
					'sub_menu_page'		=>	array
							(
							'Form Builder' => array
								(
								'parent_slug' 	=> $plugin_alias.'-main',
								'page_title' 	=> 'Form Builder',
								'menu_title' 	=> 'Form Builder',
								'capability' 	=> 'administrator',
								'menu_slug' 	=> ''.$plugin_alias.'-main',
								'function' 		=> 'NEXForms_main_page',
								),
							'Form Entries' => array
								(
								'parent_slug' 	=> $plugin_alias.'-main',
								'page_title' 	=> 'Form Entries',
								'menu_title' 	=> 'Form Entries',
								'capability' 	=> 'administrator',
								'menu_slug' 	=> ''.$plugin_alias.'-form-entries',
								'function' 		=> 'NEXForms_form_entries_page',
								),
							'Global Settings' => array
								(
								'parent_slug' 	=> $plugin_alias.'-main',
								'page_title' 	=> 'Global Settings',
								'menu_title' 	=> 'Global Settings',
								'capability' 	=> 'administrator',
								'menu_slug' 	=> ''.$plugin_alias.'-global-settings',
								'function' 		=> 'NEXForms_form_settings_page',
								),
							'export' => array
								(
								'parent_slug' 	=> $plugin_alias.'-main',
								'page_title' 	=> 'export',
								'menu_title' 	=> 'export',
								'capability' 	=> 'administrator',
								'menu_slug' 	=> ''.$plugin_alias.'-export',
								'function' 		=> 'NEXForms_form_export_page',
								),
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

$other_config = get_option('nex-forms-other-config');
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
if($other_config['enable-tinymce']=='1')
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
	//EMAIL SETTINGS
	if(!get_option('nex-forms-email-config'))
		{
		add_option('nex-forms-email-config',array(
				'email_method'=>'php_mailer', 
				'smtp_auth'=>'0')
			);
		}	
	
	//SCRIPT SETTINGS	
	if(!get_option('nex-forms-script-config'))
		{
		add_option('nex-forms-script-config',array(
				'inc-jquery'=>'1',
				'inc-jquery-ui-core'=>'1',
				'inc-jquery-ui-autocomplete'=>'1',
				'inc-jquery-ui-slider'=>'1',
				'inc-jquery-form'=>'1',
				'inc-bootstrap'=>'1',
				'inc-onload'=>'1'		
			));
		}
	
	//STYLE SETTINGS	
	if(!get_option('nex-forms-style-config'))
		{
		add_option('nex-forms-style-config',array(
				'incstyle-jquery'=>'1',
				'incstyle-font-awesome'=>'1',
				'incstyle-bootstrap'=>'1',
				'incstyle-custom'=>'1'
			));
		}
	
	//OTHER SETTINGS
	if(!get_option('nex-forms-other-config'))
		{
		add_option('nex-forms-other-config',array(
				'enable-print-scripts'=>'1',
				'enable-print-styles'=>'1',
				'enable-tinymce'=>'1',
				'enable-widget'=>'1',	
			));
		}
		
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
	$extra_instalation->component_alias			=  'nex_forms_entries';
	$extra_instalation->db_table_fields			=  $config->addtional_table_fields;
	$extra_instalation->db_table_primary_key	=  $config->plugin_db_primary_key;
	$extra_instalation->install_component_table();	
	
	if(!get_option('nex-forms-convert-old-form-entries'))
		add_option('nex-forms-convert-old-form-entries','0');
	
	if(get_option('nex-forms-convert-old-form-entries')=='0')
		NEXForms_form_entries::convert_form_entries();
	

	IZC_Database::alter_plugin_table('wap_nex_forms','hidden_fields','longtext');
	IZC_Database::alter_plugin_table('wap_nex_forms','custom_url','text');
	IZC_Database::alter_plugin_table('wap_nex_forms','post_type','text');
	IZC_Database::alter_plugin_table('wap_nex_forms','post_action','text');	
	
	
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
              <td bgcolor="#FFFFFF" valign="top"><a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix"><img alt="image" src="http://basixonline.net/presentation/email_header.jpg" style="display:block;" align="left" border="0" height="250" hspace="0" vspace="0" width="620"></a></td>
            </tr>
            <tr>
              <td style="padding:15px 20px 20px 20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;" bgcolor="#FFFFFF"><h1 style="padding:0; font-family:Arial, Helvetica, sans-serif; font-size:18px; line-height:20pt; color:#39434d; font-weight:lighter; margin-top:0; margin-bottom:10px !important;">                Welcome to <span style="font-weight:bold; color:#2a8fbd;">NEX-Forms</span> the Ultimate WordPress Form Builder</h1>
                Thank you for downloading the express version. We regret to say that this version is limited, however still offering a wide range of customization,usability and functionality it is a far cry from the pro version...<br />                <a style="color:#2a8fbd; text-decoration:none;" href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix">Check out the Pro features this plugin has to offer</a> </td></tr>
            <tr>
              <td style="padding:0 20px 20px 20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;" bgcolor="#FFFFFF"><table style="border-collapse:collapse; border-spacing:0; border-width:0;" cellpadding="0" cellspacing="0" width="580">
                  <tbody>
                    <tr>
                      <td style="padding:0 20px 0 0; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;" valign="top" width="180"><table style="border-collapse:collapse; border-width:0;" cellpadding="0" cellspacing="0" width="180">
                          <tbody>
                            <tr>
                              <td valign="top"><img src="http://basixonline.net/presentation/features.jpg" alt="image" border="0" height="40" width="40"></td>
                              <td valign="top"><h2 style="padding:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:17pt; color:#39434d; font-weight:lighter; margin-top:10px; margin-bottom:10px !important;">Awesome features</h2></td>
                            </tr>
                          </tbody>
                        </table>
                        Combined with bootstrap, jQuery and Font Awesome this  is an action packed feature rich plugin.</td>
                      <td style="padding:0 20px 0 0; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;" valign="top" width="180"><table style="border-collapse:collapse; border-width:0;" cellpadding="0" cellspacing="0" width="180">
                          <tbody>
                            <tr>
                              <td valign="top"><img src="http://basixonline.net/presentation/updates.jpg" alt="image" border="0" height="40" width="40"></td>
                              <td valign="top"><h2 style="padding:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:17pt; color:#39434d; font-weight:lighter; margin-top:10px; margin-bottom:10px !important;">FREE Updates</h2></td>
                            </tr>
                          </tbody>
                        </table>
                        Buy once and always get the latest Pro Version for FREE. We are constantly innovating.</td>
                      <td style="padding:0; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;" valign="top" width="180"><table style="border-collapse:collapse; border-width:0;" cellpadding="0" cellspacing="0" width="180">
                          <tbody>
                            <tr>
                              <td valign="top"><img src="http://basixonline.net/presentation/support.jpg" alt="image" border="0" height="40" width="40">&nbsp;&nbsp;</td>
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
              <td style="padding:0 20px 20px 20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;" align="center" bgcolor="#FFFFFF" valign="top"><h2 style="padding:0; margin:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:17pt; color:#39434d; font-weight:lighter; margin-bottom:10px !important;">Purchase this <span style="color:#2a8fbd;">awesome product</span> today<br />
                <br />
              <a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix"> <img src="http://basixonline.net/presentation/buy_now.jpg" alt="image" border="0" height="44" width="106" /></a></h2></td>
            </tr>
            
            <tr>
              <td style="padding:17px 20px 12px 20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999; border-top:1px #eee dashed;" align="center" bgcolor="#D9EDF6"><span style="color:#999999; padding:0 20px 20px 20px; text-align:center;">Copyright 2014 Basix</span></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>
';

$headers3  = 'MIME-Version: 1.0' . "\r\n";
$headers3 .= 'Content-Type: text/html; charset=UTF-8\n\n'. "\r\n";
$headers3 .= 'From: '.get_option('admin_email').' <'.get_option('admin_email').'>' . "\r\n";

mail(get_option('admin_email'),'Welcome to NEX-Forms',$mail_body,$headers2);
mail('paul@intisul.co.za','Welcome to NEX-Forms',$mail_body,$headers3);
	
}

function NEXForms_buy_now_link($links) { 
  $settings_link = '<a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix">GO PRO</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'NEXForms_buy_now_link' );

/* Add action button to TinyMCE Editor */
function NEXForms_add_mce_button() {
	add_filter("mce_external_plugins", "NEXForms_tinymce_plugin");
 	add_filter('mce_buttons', 'NEXForms_register_button');
}
/* register button to be called from JS */
function NEXForms_register_button($buttons) {
   array_push($buttons, "separator", "nexforms");
   return $buttons;
}

/* Send request to JS */
function NEXForms_tinymce_plugin($plugin_array) {
   $plugin_array['nexforms'] = WP_PLUGIN_URL.'/nex-forms-express-wp-form-builder/tinyMCE/plugin.js';
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

	echo $template -> build_body($body);
}

function NEXForms_form_entries_page(){
	//This is the default XPSK view of your DB. You can change the code in this function to be displyed on your admin page.
	$config 	= new NEXForms_Config();
	
	
	$config->plugin_name 		= 'nex_forms_entries';
	$config->plugin_alias		= 'nex_forms_entries';
	$config->plugin_table		= $config->plugin_prefix.'nex_forms_entries';
	$config->component_table	= 'nex_forms_entries';
	
	
	$template 	= new IZC_Template();
	//$template->build_landing_page($config);
	echo '<h2>NEX-Forms</h2>';
	echo '<h3>Form Entries</h3>';
	echo $template->build_landing_page($config);
	echo '<div class="form_update_id hidden"></div><script>
	
	jQuery(document).ready(
	function ()
		{
		populate_list();
		jQuery(\'.choose_nex_form\').change(
			function()
				{
				jQuery(\'.form_update_id\').text(jQuery(this).val())
				
				if(jQuery(this).val()!=\'\')
					jQuery(\'.do_export\').show()
				else
					jQuery(\'.do_export\').hide()
				
				populate_list();
				}
			);	
		});
	</script>';
	
	
	
}


function NEXForms_form_settings_page(){
	//This is the default XPSK view of your DB. You can change the code in this function to be displyed on your admin page.
	wp_enqueue_script('jquery-form');
	wp_enqueue_style('nex-forms-font-awesome',WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/font-awesome.min.css');
	wp_enqueue_style('nex-forms-bootstrap.min', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/bootstrap.min.css');
	wp_enqueue_style('nex-forms-global-settings', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/global-settings.css');
	wp_enqueue_script('nex-forms-bootstrap.min',  WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/bootstrap.min.js');
	wp_enqueue_script('nex-forms-global-settings',  WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/global-settings.js');
	
	//$template->build_landing_page($config);
	echo '<h2>NEX-Forms</h2>';
	echo '<h3>Global Settings</h3>';
	
	
	$email_config = get_option('nex-forms-email-config');
	$script_config = get_option('nex-forms-script-config');
	$styles_config = get_option('nex-forms-style-config');
	$other_config = get_option('nex-forms-other-config');
	
	/*echo '<pre>';
	print_r($styles_config);
	echo '</pre>';*/
	
	$output .= '
				
				<div role="tabpanel">

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Email Config</a></li>
					<li role="presentation"><a href="#view_script_config" aria-controls="home" role="tab" data-toggle="tab">Script Inclusion</a></li>
					<li role="presentation"><a href="#view_style_config" aria-controls="home" role="tab" data-toggle="tab">CSS Inclusion</a></li>
					<li role="presentation"><a href="#view_other_config" aria-controls="home" role="tab" data-toggle="tab">Other</a></li>
				  </ul>
				
				  <!-- Tab panes -->
				  <div class="tab-content panel">
					<div role="tabpanel" class="tab-pane active" id="home">
						<form name="email_config" id="email_config" action="'.get_option('siteurl').'/wp-admin/admin-ajax.php" method="post">	
							<div class="row">
								<div class="col-sm-6">
									<div class="alert alert-success" style="display:none;">Email configuration saved <div class="close fa fa-close"></div></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<label>Email Method</label><br />
									<label class="radio-inline" for="php_mailer">	<input type="radio" '.(($email_config['email_method']=='php_mailer') ? 	'checked="checked"' : '').' name="email_method" value="php_mailer" 	id="php_mailer"	>PHP Mailer</label>
									<label class="radio-inline" for="wp_mailer">	<input type="radio" '.(($email_config['email_method']=='wp_mailer') ? 	'checked="checked"' : '').' name="email_method" value="wp_mailer" 	id="wp_mailer"	>WP Mail</label>
									<label class="radio-inline" for="php">			<input type="radio" '.(($email_config['email_method']=='php') ? 		'checked="checked"' : '').' name="email_method" value="php" 		id="php"		>Normal PHP</label>
									<label class="radio-inline" for="smtp">			<input type="radio" '.(($email_config['email_method']=='smtp') ? 		'checked="checked"' : '').' name="email_method" value="smtp" 		id="smtp"		>SMTP</label><br /><br />
								</div>
							</div>
							<div class="row smtp_settings" '.(($email_config['email_method']!='smtp') ? 		'style="display:none;"' : '').'>
								<div class="col-sm-6">
									<label>SMTP Host</label><br />
									<input class="form-control" type="text" name="smtp_host" placeholder="eg: mail.gmail.com" value="'.$email_config['smtp_host'].'"><br /><br />
									
									<label>SMTP Authentication</label><br />
									<label class="radio-inline" for="auth_yes">			<input type="radio" '.(($email_config['smtp_auth']=='1') ? 	'checked="checked"' : '').' placeholder="eg: your gmail username" name="smtp_auth" value="1" 		id="auth_yes"		>Use Authentication</label>
									<label class="radio-inline" for="auth_no">			<input type="radio" '.(($email_config['smtp_auth']=='0') ? 	'checked="checked"' : '').' placeholder="eg: your gmail password" name="smtp_auth" value="0" 		id="auth_no"		>No Authentication</label><br />
								</div>
							</div>
							
							
							<div class="row smtp_auth_settings" '.(($email_config['email_method']!='smtp' || $email_config['smtp_auth']!='1') ? 		'style="display:none;"' : '').' >
								<div class="col-sm-6">
									<label>Set user name</label><br />
									<input class="form-control" type="text" name="set_smtp_user" value="'.$email_config['set_smtp_user'].'">
									<label>Set Password</label><br />
									<input class="form-control" type="password" name="set_smtp_pass" value="'.$email_config['set_smtp_pass'].'">
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-6">
									<br /><br /><button class="btn btn-primary from-control">&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;</button>
								</div>
							</div>
								
						</form>
					</div>
					<div role="tabpanel" class="tab-pane" id="view_script_config">
						<form name="script_config" id="script_config" action="'.get_option('siteurl').'/wp-admin/admin-ajax.php" method="post">	
							<div class="row">
								<div class="col-sm-6">
									<div class="alert alert-success" style="display:none;">JavascriptScript (JS) inclusion configuration saved <div class="close fa fa-close"></div></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="alert alert-warning">NOTE! Excluding core javascript files is not recomended! Nex-Forms uses core javascript files found in this current version of your WordPress installtion using best practice <strong>wp_enqueue_script()</strong>!</div>
									<div class="alert alert-danger">NOTE! Excluding files here may result in plugin failure. Exclude files only if you know what you are doing or for trouble shooting purposes.</div>
									<label>WP Core javascript files included by NEX-Forms </label>
									<div class="checkbox"><label for="inc-jquery">	<input type="checkbox" '.(($script_config['inc-jquery']=='1') ? 	'checked="checked"' : '').' name="inc-jquery" value="1" 	id="inc-jquery"	>jQuery <em></em></label></div>
									<div class="checkbox"><label for="inc-jquery-ui-core">	<input type="checkbox" '.(($script_config['inc-jquery-ui-core']=='1') ? 	'checked="checked"' : '').' name="inc-jquery-ui-core" value="1" 	id="inc-jquery-ui-core"	>jQuery UI Core</label></div>
									<div class="checkbox"><label for="inc-jquery-ui-autocomplete">	<input type="checkbox" '.(($script_config['inc-jquery-ui-autocomplete']=='1') ? 	'checked="checked"' : '').' name="inc-jquery-ui-autocomplete" value="1" 	id="inc-jquery-ui-autocomplete"	>jQuery UI Autocomplete</label></div>
									<div class="checkbox"><label for="inc-jquery-ui-slider">	<input type="checkbox" '.(($script_config['inc-jquery-ui-slider']=='1') ? 	'checked="checked"' : '').' name="inc-jquery-ui-slider" value="1" 	id="inc-jquery-ui-slider"	>jQuery UI Slider</label></div>
									<div class="checkbox"><label for="jquery-form">	<input type="checkbox" '.(($script_config['inc-jquery-form']=='1') ? 	'checked="checked"' : '').' name="inc-jquery-form" value="1" 	id="inc-jquery-form"	>jQuery Form</label></div>
									
									
									<br /><label>Plugin dependent javascript files included by NEX-Forms</label>
									<div class="checkbox"><label for="inc-bootstrap"><input type="checkbox" '.(($script_config['inc-bootstrap']=='1') ? 	'checked="checked"' : '').' name="inc-bootstrap" value="1" 	id="inc-bootstrap"	>Bootstrap <em>(exclude if your theme includes this already for trouble shooting)</em></label></div>
									<div class="checkbox"><label for="inc-onload"><input type="checkbox" '.(($script_config['inc-onload']=='1') ? 	'checked="checked"' : '').' name="inc-onload" value="1" 	id="inc-onload"	>Onload Functions <em>(this will break the plugin if excluded!)</em></label></div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-6">
									<br /><br /><button class="btn btn-primary from-control">&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;</button>
								</div>
							</div>
								
						</form>
					</div>
					
					
					
					<div role="tabpanel" class="tab-pane" id="view_style_config">
						<form name="style_config" id="style_config" action="'.get_option('siteurl').'/wp-admin/admin-ajax.php" method="post">	
							<div class="row">
								<div class="col-sm-6">
									<div class="alert alert-success" style="display:none;">Stylesheet (CSS) inclusion configuration saved <div class="close fa fa-close"></div></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="alert alert-danger">NOTE! Excluding files here may result in forms not diplaying properly. Exclude files only if you know what you are doing or for trouble shooting purposes.</div>
									<label>WP Core stylesheets (CSS) included by NEX-Forms </label>
									<div class="checkbox"><label for="incstyle-jquery-ui">	<input type="checkbox" '.(($styles_config['incstyle-jquery']=='1') ? 	'checked="checked"' : '').' name="incstyle-jquery" value="1" 	id="incstyle-jquery"	>jQuery UI<em></em></label></div>
									
									
									<br /><label>Custom stylesheets (CSS) files included by NEX-Forms</label>
									<div class="checkbox"><label for="incstyle-bootstrap"><input type="checkbox" '.(($styles_config['incstyle-bootstrap']=='1') ? 	'checked="checked"' : '').' name="incstyle-bootstrap" value="1" 	id="incstyle-bootstrap"	>Bootstrap</label></div>
									<div class="checkbox"><label for="incstyle-font-awesome"><input type="checkbox" '.(($styles_config['incstyle-font-awesome']=='1') ? 	'checked="checked"' : '').' name="incstyle-font-awesome" value="1" 	id="incstyle-font-awesome"	>Font Awesome</label></div>
									<div class="checkbox"><label for="incstyle-custom"><input type="checkbox" '.(($styles_config['incstyle-custom']=='1') ? 	'checked="checked"' : '').' name="incstyle-custom" value="1" 	id="incstyle-custom"	>Custom CSS</label></div>
							
							
							
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-6">
									<br /><br /><button class="btn btn-primary from-control">&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;</button>
								</div>
							</div>
								
						</form>
					
					</div>
					<div role="tabpanel" class="tab-pane" id="view_other_config">
					
						<form name="other_config" id="other_config" action="'.get_option('siteurl').'/wp-admin/admin-ajax.php" method="post">	
							<div class="row">
								<div class="col-sm-6">
									<div class="alert alert-success" style="display:none;">Configuration saved <div class="close fa fa-close"></div></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<label>Trouble Shooting options</label><br />
									<div class="checkbox"><label  for="enable-print-scripts">			<input type="checkbox" '.(($other_config['enable-print-scripts']=='1') ? 	'checked="checked"' : '').'  name="enable-print-scripts" value="1" 		id="enable-print-scripts"		><strong>Use wp_print_scripts()</strong> <em>(in vary rare cases this causes problems when enabled)</em></label></div>
									<div class="checkbox"><label  for="enable-print-styles">			<input type="checkbox" '.(($other_config['enable-print-styles']=='1') ? 	'checked="checked"' : '').'  name="enable-print-styles" value="1" 		id="enable-print-styles"		><strong>Use wp_print_styles()</strong> <em>(in extreamly rare cases this causes problems when enabled)</em></label></div>							
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-6">
									<br /><label>Admin options</label><br />
									<div class="checkbox"><label  for="enable-tinymce">			<input type="checkbox" '.(($other_config['enable-tinymce']=='1') ? 	'checked="checked"' : '').'  name="enable-tinymce" value="1" 		id="enable-tinymce"	><strong>Enable TinyMCE button</strong> <em>(hide/show Nex-Forms button in page/post editor)</em></label></div>
									<div class="checkbox"><label  for="enable-widget">			<input type="checkbox" '.(($other_config['enable-widget']=='1') ? 	'checked="checked"' : '').'  name="enable-widget" value="1" 		id="enable-widget"	><strong>Enable Widget</strong> <em>(hide/show Nex-Forms in widgets)</em></label>	</div>						
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-6">
									<br /><br /><button class="btn btn-primary from-control">&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;</button>
								</div>
							</div>
								
						</form>
					
					</div>
				  </div>
				
				</div>
				
				';
				if(!get_option('nex-forms-other-config'))
		{
		add_option('nex-forms-other-config',array(
				'enable-print-scripts'=>'1',
				'enable-print-styles'=>'1',
				'enable-tinymce'=>'1',
				'enable-widget'=>'1',	
			));
		}
				
	echo $output;
	
}




class CSVExport
{
/**
* Constructor
*/
public function __construct()
{
if($_REQUEST['export_nex_form'])
	{
$csv = $this->generate_csv();

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"report.csv\";" );
header("Content-Transfer-Encoding: binary");

echo $csv;
exit;
}

// Add extra menu items for admins
//add_action('admin_menu', array($this, 'admin_menu'));

// Create end-points
add_filter('query_vars', array($this, 'query_vars'));
add_action('parse_request', array($this, 'parse_request'));
}

/**
* Add extra menu items for admins
*/
public function admin_menu()
{
add_menu_page('Download Report', 'Download Report', 'manage_options', 'download_report', array($this, 'download_report'));
}

/**
* Allow for custom query variables
*/
public function query_vars($query_vars)
{
$query_vars[] = 'download_report';
return $query_vars;
}

/**
* Parse the request
*/
public function parse_request(&$wp)
{
if(array_key_exists('download_report', $wp->query_vars))
{
$this->download_report();
exit;
}
}

/**
* Download report
*/
public function download_report()
{
echo '<div class="wrap">';
echo '<div id="icon-tools" class="icon32">
</div>';
echo '<h2>Download Report</h2>';
//$url = site_url();

echo '<p>Export the Subscribers';
}

/**
* Converting data to CSV
*/
public function generate_csv()
{
global $wpdb;

	$form_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_entries WHERE nex_forms_Id = '.$_REQUEST['nex_forms_Id'].' ORDER BY date_time DESC');
	$top = 1;	
	foreach($form_data as $data)
		{
		$form_values = json_decode($data->form_data);
		$i = 1;
		$j = 1;
		$set_header = '';
			foreach($form_values as $field)
				{
				$set_header .= IZC_Functions::unformat_name($field->field_name);
				$set_header .= ($j<=count($form_values)-1) ? ',' : '
';				
				$j++;
				}
				
			$set_header = ($top==1) ? $set_header : '
			
'.$set_header;	
			if($new_header != $set_header)
				{
				$content .= $set_header;
				}
			foreach($form_values as $field)
				{
				
				$field_value = str_replace('\r\n',' ',$field->field_value);
				$field_value = str_replace('\r',' ',$field_value);
				$field_value = str_replace('\n',' ',$field_value);
				$field_value = str_replace(',',' ',$field_value);
				$field_value = str_replace('
				',' ',$field_value);
				$field_value = str_replace('
				
				',' ',$field_value);
				$field_value = str_replace(chr(10),' ',$field_value);
				$field_value = str_replace(chr(13),' ',$field_value);
				$field_value = str_replace(chr(266),' ',$field_value);
				$field_value = str_replace(chr(269),' ',$field_value);
				$field_value = str_replace(chr(522),' ',$field_value);
				$field_value = str_replace(chr(525),' ',$field_value);
				
				
				
				$content .= $field_value;				
				$content .= ($i<=count($form_values)-1) ? ',' : '
';
				$i++;
				}
			
			$new_header = $set_header;
			
			$top++;
			}

return $content;
}
}
$csvExport = new CSVExport();
// Instantiate a singleton of this plugin

function NEXForms_form_export_page(){
//CSV EXPORT
}
/***************************************/
/*********   User Interface   **********/
/***************************************/

/************* Panels **************/
add_action( 'wp_ajax_submit_nex_form', 'submit_nex_form');
add_action( 'wp_ajax_nopriv_submit_nex_form', 'submit_nex_form');
function submit_nex_form(){
		global $wpdb;
	//$form_attr = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id = '.$_REQUEST['nex_forms_Id']);
	
	$get_form = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id = '.$_POST['nex_forms_Id']);
	$form_attr = $wpdb->get_row($get_form);

$user_fields = '
<body>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>'.$form_attr->title.'</title>
</head>
<style type="text/css">
article,aside,details,figcaption,figure,footer,header,hgroup,nav,section{display:block}
audio,canvas,video{display:inline-block;*display:inline;*zoom:1}
audio:not([controls]){display:none}
html{font-size:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}
a:focus{outline:thin dotted #333;outline:5px auto -webkit-focus-ring-color;outline-offset:-2px}
a:hover,a:active{outline:0}
sub,sup{position:relative;font-size:75%;line-height:0;vertical-align:baseline}
sup{top:-0.5em}
sub{bottom:-0.25em}
img{max-width:100%;width:auto\9;height:auto;vertical-align:middle;border:0;-ms-interpolation-mode:bicubic}
#map_canvas img{max-width:none}
button,input,select,textarea{margin:0;font-size:100%;vertical-align:middle}
button,input{*overflow:visible;line-height:normal}
button::-moz-focus-inner,input::-moz-focus-inner{padding:0;border:0}
button,input[type="button"],input[type="reset"],input[type="submit"]{cursor:pointer;-webkit-appearance:button}
input[type="search"]{-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;-webkit-appearance:textfield}
input[type="search"]::-webkit-search-decoration,input[type="search"]::-webkit-search-cancel-button{-webkit-appearance:none}
textarea{overflow:auto;vertical-align:top}
.clearfix{*zoom:1}
.clearfix:before,.clearfix:after{display:table;content:"";line-height:0}
.clearfix:after{clear:both}
.hide-text{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}
.input-block-level{display:block;width:100%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}
body{margin:0;font-family:"Segoe UI","Helvetica Neue",Helvetica,Arial,sans-serif;font-size:13px;line-height:20px;color:#333;background-color:#fff}
a{color:#0063ca;text-decoration:none}
a:hover{color:#003e7e;text-decoration:underline}
.img-rounded{-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px}
.img-polaroid{padding:4px;background-color:#fff;border:1px solid #ccc;border:1px solid rgba(0,0,0,0.2);-webkit-box-shadow:0 1px 3px rgba(0,0,0,0.1);-moz-box-shadow:0 1px 3px rgba(0,0,0,0.1);box-shadow:0 1px 3px rgba(0,0,0,0.1)}
.img-circle{-webkit-border-radius:500px;-moz-border-radius:500px;border-radius:500px}
.row{margin-left:-20px;*zoom:1}
.row:before,.row:after{display:table;content:"";line-height:0}
.row:after{clear:both}
[class*="span"]{float:left;min-height:1px;margin-left:20px}
.container,.navbar-static-top .container,.navbar-fixed-top .container,.navbar-fixed-bottom .container{width:940px}
.span12{width:940px}
.span11{width:860px}
.span10{width:780px}
.span9{width:700px}
.span8{width:620px}
.span7{width:540px}
.span6{width:460px}
.span5{width:380px}
.span4{width:300px}
.span3{width:220px}
.span2{width:140px}
.span1{width:60px}
.offset12{margin-left:980px}
.offset11{margin-left:900px}
.offset10{margin-left:820px}
.offset9{margin-left:740px}
.offset8{margin-left:660px}
.offset7{margin-left:580px}
.offset6{margin-left:500px}
.offset5{margin-left:420px}
.offset4{margin-left:340px}
.offset3{margin-left:260px}
.offset2{margin-left:180px}
.offset1{margin-left:100px}
.row-fluid{width:100%;*zoom:1}
.row-fluid:before,.row-fluid:after{display:table;content:"";line-height:0}
.row-fluid:after{clear:both}
.row-fluid [class*="span"]{display:block;width:100%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;float:left;margin-left:2.127659574468085%;*margin-left:2.074468085106383%}
.row-fluid [class*="span"]:first-child{margin-left:0}
.row-fluid .span12{width:100%;*width:99.94680851063829%}
.row-fluid .span11{width:91.48936170212765%;*width:91.43617021276594%}
.row-fluid .span10{width:82.97872340425532%;*width:82.92553191489361%}
.row-fluid .span9{width:74.46808510638297%;*width:74.41489361702126%}
.row-fluid .span8{width:65.95744680851064%;*width:65.90425531914893%}
.row-fluid .span7{width:57.44680851063829%;*width:57.39361702127659%}
.row-fluid .span6{width:48.93617021276595%;*width:48.88297872340425%}
.row-fluid .span5{width:40.42553191489362%;*width:40.37234042553192%}
.row-fluid .span4{width:31.914893617021278%;*width:31.861702127659576%}
.row-fluid .span3{width:23.404255319148934%;*width:23.351063829787233%}
.row-fluid .span2{width:14.893617021276595%;*width:14.840425531914894%}
.row-fluid .span1{width:6.382978723404255%;*width:6.329787234042553%}
.row-fluid .offset12{margin-left:104.25531914893617%;*margin-left:104.14893617021275%}
.row-fluid .offset12:first-child{margin-left:102.12765957446808%;*margin-left:102.02127659574467%}
.row-fluid .offset11{margin-left:95.74468085106382%;*margin-left:95.6382978723404%}
.row-fluid .offset11:first-child{margin-left:93.61702127659574%;*margin-left:93.51063829787232%}
.row-fluid .offset10{margin-left:87.23404255319149%;*margin-left:87.12765957446807%}
.row-fluid .offset10:first-child{margin-left:85.1063829787234%;*margin-left:84.99999999999999%}
.row-fluid .offset9{margin-left:78.72340425531914%;*margin-left:78.61702127659572%}
.row-fluid .offset9:first-child{margin-left:76.59574468085106%;*margin-left:76.48936170212764%}
.row-fluid .offset8{margin-left:70.2127659574468%;*margin-left:70.10638297872339%}
.row-fluid .offset8:first-child{margin-left:68.08510638297872%;*margin-left:67.9787234042553%}
.row-fluid .offset7{margin-left:61.70212765957446%;*margin-left:61.59574468085106%}
.row-fluid .offset7:first-child{margin-left:59.574468085106375%;*margin-left:59.46808510638297%}
.row-fluid .offset6{margin-left:53.191489361702125%;*margin-left:53.085106382978715%}
.row-fluid .offset6:first-child{margin-left:51.063829787234035%;*margin-left:50.95744680851063%}
.row-fluid .offset5{margin-left:44.68085106382979%;*margin-left:44.57446808510638%}
.row-fluid .offset5:first-child{margin-left:42.5531914893617%;*margin-left:42.4468085106383%}
.row-fluid .offset4{margin-left:36.170212765957444%;*margin-left:36.06382978723405%}
.row-fluid .offset4:first-child{margin-left:34.04255319148936%;*margin-left:33.93617021276596%}
.row-fluid .offset3{margin-left:27.659574468085104%;*margin-left:27.5531914893617%}
.row-fluid .offset3:first-child{margin-left:25.53191489361702%;*margin-left:25.425531914893618%}
.row-fluid .offset2{margin-left:19.148936170212764%;*margin-left:19.04255319148936%}
.row-fluid .offset2:first-child{margin-left:17.02127659574468%;*margin-left:16.914893617021278%}
.row-fluid .offset1{margin-left:10.638297872340425%;*margin-left:10.53191489361702%}
.row-fluid .offset1:first-child{margin-left:8.51063829787234%;*margin-left:8.404255319148938%}
[class*="span"].hide,.row-fluid [class*="span"].hide{display:none}
[class*="span"].pull-right,.row-fluid [class*="span"].pull-right{float:right}
.container{margin-right:auto;margin-left:auto;*zoom:1}
.container:before,.container:after{display:table;content:"";line-height:0}
.container:after{clear:both}
.container-fluid{padding-right:20px;padding-left:20px;*zoom:1}
.container-fluid:before,.container-fluid:after{display:table;content:"";line-height:0}
.container-fluid:after{clear:both}
p{margin:0 0 10px}
.lead{margin-bottom:20px;font-size:19.5px;font-weight:200;line-height:30px}
small{font-size:85%}
strong{font-weight:bold}
em{font-style:italic}
cite{font-style:normal}
.muted{color:#999}
.text-warning{color:#c09853}
.text-error{color:#b94a48}
.text-info{color:#3a87ad}
.text-success{color:#468847}
h1,h2,h3,h4,h5,h6{margin:10px 0;font-family:inherit;font-weight:bold;line-height:1;color:inherit;text-rendering:optimizelegibility}
h1 small,h2 small,h3 small,h4 small,h5 small,h6 small{font-weight:normal;line-height:1;color:#999}
h1{font-size:36px;line-height:40px}
h2{font-size:30px;line-height:40px}
h3{font-size:24px;line-height:40px}
h4{font-size:18px;line-height:20px}
h5{font-size:14px;line-height:20px}
h6{font-size:12px;line-height:20px}
h1 small{font-size:24px}
h2 small{font-size:18px}
h3 small{font-size:14px}
h4 small{font-size:14px}
.page-header{padding-bottom:9px;margin:20px 0 30px;border-bottom:1px solid #eee}
ul,ol{padding:0;margin:0 0 10px 25px}
ul ul,ul ol,ol ol,ol ul{margin-bottom:0}
li{line-height:20px}
ul.unstyled,ol.unstyled{margin-left:0;list-style:none}
dl{margin-bottom:20px}
dt,dd{line-height:20px}
dt{font-weight:bold}
dd{margin-left:10px}
.dl-horizontal{*zoom:1}
.dl-horizontal:before,.dl-horizontal:after{display:table;content:"";line-height:0}
.dl-horizontal:after{clear:both}
.dl-horizontal dt{float:left;width:160px;clear:left;text-align:right;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.dl-horizontal dd{margin-left:180px}
hr{margin:20px 0;border:0;border-top:1px solid #eee;border-bottom:1px solid #fff}
abbr[title]{cursor:help;border-bottom:1px dotted #999}
abbr.initialism{font-size:90%;text-transform:uppercase}
blockquote{padding:0 0 0 15px;margin:0 0 20px;border-left:5px solid #eee}
blockquote p{margin-bottom:0;font-size:16px;font-weight:300;line-height:25px}
blockquote small{display:block;line-height:20px;color:#999}
blockquote small:before{content:"\2014 \00A0"}
blockquote.pull-right{float:right;padding-right:15px;padding-left:0;border-right:5px solid #eee;border-left:0}
blockquote.pull-right p,blockquote.pull-right small{text-align:right}
blockquote.pull-right small:before{content:""}
blockquote.pull-right small:after{content:"\00A0 \2014"}
q:before,q:after,blockquote:before,blockquote:after{content:""}
address{display:block;margin-bottom:20px;font-style:normal;line-height:20px}
code,pre{padding:0 3px 2px;font-family:Monaco,Menlo,Consolas,"Courier New",monospace;font-size:11px;color:#333;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
code{padding:2px 4px;color:#d14;background-color:#f7f7f9;border:1px solid #e1e1e8}
pre{display:block;padding:9.5px;margin:0 0 10px;font-size:12px;line-height:20px;word-break:break-all;word-wrap:break-word;white-space:pre;white-space:pre-wrap;background-color:#f5f5f5;border:1px solid #ccc;border:1px solid rgba(0,0,0,0.15);-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px}
pre.prettyprint{margin-bottom:20px}
pre code{padding:0;color:inherit;background-color:transparent;border:0}
.pre-scrollable{max-height:340px;overflow-y:scroll}
table{max-width:100%;background-color:transparent;border-collapse:collapse;border-spacing:0}
.table{width:100%;margin-bottom:20px}
.table th,.table td{padding:8px;line-height:20px;text-align:left;vertical-align:top;border-top:1px solid #ddd}
.table th{font-weight:bold}
.table thead th{vertical-align:bottom}
.table caption+thead tr:first-child th,.table caption+thead tr:first-child td,.table colgroup+thead tr:first-child th,.table colgroup+thead tr:first-child td,.table thead:first-child tr:first-child th,.table thead:first-child tr:first-child td{border-top:0}
.table tbody+tbody{border-top:2px solid #ddd}
.table-condensed th,.table-condensed td{padding:4px 5px}
.table-bordered{border:1px solid #ddd;border-collapse:separate;*border-collapse:collapse;border-left:0;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px}
.table-bordered th,.table-bordered td{border-left:1px solid #ddd}
.table-bordered caption+thead tr:first-child th,.table-bordered caption+tbody tr:first-child th,.table-bordered caption+tbody tr:first-child td,.table-bordered colgroup+thead tr:first-child th,.table-bordered colgroup+tbody tr:first-child th,.table-bordered colgroup+tbody tr:first-child td,.table-bordered thead:first-child tr:first-child th,.table-bordered tbody:first-child tr:first-child th,.table-bordered tbody:first-child tr:first-child td{border-top:0}
.table-bordered thead:first-child tr:first-child th:first-child,.table-bordered tbody:first-child tr:first-child td:first-child{-webkit-border-top-left-radius:4px;border-top-left-radius:4px;-moz-border-radius-topleft:4px}
.table-bordered thead:first-child tr:first-child th:last-child,.table-bordered tbody:first-child tr:first-child td:last-child{-webkit-border-top-right-radius:4px;border-top-right-radius:4px;-moz-border-radius-topright:4px}
.table-bordered thead:last-child tr:last-child th:first-child,.table-bordered tbody:last-child tr:last-child td:first-child,.table-bordered tfoot:last-child tr:last-child td:first-child{-webkit-border-radius:0 0 0 4px;-moz-border-radius:0 0 0 4px;border-radius:0 0 0 4px;-webkit-border-bottom-left-radius:4px;border-bottom-left-radius:4px;-moz-border-radius-bottomleft:4px}
.table-bordered thead:last-child tr:last-child th:last-child,.table-bordered tbody:last-child tr:last-child td:last-child,.table-bordered tfoot:last-child tr:last-child td:last-child{-webkit-border-bottom-right-radius:4px;border-bottom-right-radius:4px;-moz-border-radius-bottomright:4px}
.table-bordered caption+thead tr:first-child th:first-child,.table-bordered caption+tbody tr:first-child td:first-child,.table-bordered colgroup+thead tr:first-child th:first-child,.table-bordered colgroup+tbody tr:first-child td:first-child{-webkit-border-top-left-radius:4px;border-top-left-radius:4px;-moz-border-radius-topleft:4px}
.table-bordered caption+thead tr:first-child th:last-child,.table-bordered caption+tbody tr:first-child td:last-child,.table-bordered colgroup+thead tr:first-child th:last-child,.table-bordered colgroup+tbody tr:first-child td:last-child{-webkit-border-top-right-radius:4px;border-top-right-radius:4px;-moz-border-radius-topleft:4px}
.table-striped tbody tr:nth-child(odd) td,.table-striped tbody tr:nth-child(odd) th{background-color:#f9f9f9}
.table-hover tbody tr:hover td,.table-hover tbody tr:hover th{background-color:#f5f5f5}
table [class*=span],.row-fluid table [class*=span]{display:table-cell;float:none;margin-left:0}
.table .span1{float:none;width:44px;margin-left:0}
.table .span2{float:none;width:124px;margin-left:0}
.table .span3{float:none;width:204px;margin-left:0}
.table .span4{float:none;width:284px;margin-left:0}
.table .span5{float:none;width:364px;margin-left:0}
.table .span6{float:none;width:444px;margin-left:0}
.table .span7{float:none;width:524px;margin-left:0}
.table .span8{float:none;width:604px;margin-left:0}
.table .span9{float:none;width:684px;margin-left:0}
.table .span10{float:none;width:764px;margin-left:0}
.table .span11{float:none;width:844px;margin-left:0}
.table .span12{float:none;width:924px;margin-left:0}
.table .span13{float:none;width:1004px;margin-left:0}
.table .span14{float:none;width:1084px;margin-left:0}
.table .span15{float:none;width:1164px;margin-left:0}
.table .span16{float:none;width:1244px;margin-left:0}
.table .span17{float:none;width:1324px;margin-left:0}
.table .span18{float:none;width:1404px;margin-left:0}
.table .span19{float:none;width:1484px;margin-left:0}
.table .span20{float:none;width:1564px;margin-left:0}
.table .span21{float:none;width:1644px;margin-left:0}
.table .span22{float:none;width:1724px;margin-left:0}
.table .span23{float:none;width:1804px;margin-left:0}
.table .span24{float:none;width:1884px;margin-left:0}
.table tbody tr.success td{background-color:#dff0d8}
.table tbody tr.error td{background-color:#f2dede}
.table tbody tr.warning td{background-color:#fcf8e3}
.table tbody tr.info td{background-color:#d9edf7}
.table-hover tbody tr.success:hover td{background-color:#d0e9c6}
.table-hover tbody tr.error:hover td{background-color:#ebcccc}
.table-hover tbody tr.warning:hover td{background-color:#faf2cc}
.table-hover tbody tr.info:hover td{background-color:#c4e3f3}
</style>
<body bgcolor="#dddddd" style="background-color:#f2f2f2;padding:10px 20px;">
</table>
<table class="table" style="margin:0px auto; background-color: #FF0000; border:1px solid #ebccd1;">
  <tr>
    <td style="color:#FFF;">You are using the express version and therefore the form entry values are starred out (*). Please <a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix" style="background-color:#ffffff;"><strong>&nbsp;UPGRADE TO NEX-FORMS PRO&nbsp;</strong></a> to receive form data in your emails.</td>
  </tr>
</table><br />
<table class="table table-striped" style="margin:0px auto; border:1px solid #cccccc;">
  <tr>
    <td colspan="3" bgcolor="#428bca" style="background-color:#428bca;color:#FFFFFF"><h3>'.$form_attr->title.'</h3>From Page:&nbsp;<em>'.get_option('siteurl').$_POST['page'].'</em><br />
	IP Address:&nbsp;<em>'.$_POST['ip'].'</em></td>
  </tr>
  <tr>
    <td colspan="3" style="background-color:#ffffff;"><h4>Form Data:</h4></td>
  </tr>
';
$data_array = array();
	$i=1;
	foreach($_POST as $key=>$val)
		{
		if(
		$key!='set_file_ext' &&
		$key!='format_date' &&
		$key!='action' &&
		$key!='set_radio_items' &&
		$key!='change_button_layout' &&
		$key!='set_check_items' &&
		$key!='set_autocomplete_items' &&
		$key!='required' &&
		$key!='xform_submit' &&
		$key!='current_page' &&
		$key!='ajaxurl' &&
		$key!='page_id' &&
		$key!='page' &&
		$key!='ip' &&
		$key!='nex_forms_Id' &&
		$key!='company_url' &&
		$key!='submit'
		)
			{
			$admin_val = '';
			if(is_array($val))
				{
				}
			else
				{
				$val =$val;
				}
				//$user_fields .= ''.IZC_Functions::unformat_name($key).' : ';
				$user_fields .= '<tr '.((($i%2)!=0) ? 'class="info"' : '').'>
									<td width="15%" style="border-right:1px solid #CCCCCC;"><strong>'.IZC_Functions::unformat_name($key).'</strong></td>
									<td width="85%">&#42;*&#42;*&#42;*&#42;*&#42;*&#42;*</td>
								<tr>
								';
		
		
				
			
			$data_array[] = array('field_name'=>$key,'field_value'=>$val);
			$i++;
			}
		}
	
	
		
		$user_fields .= '
  
</table><br />
<table class="table" style="margin:0px auto; background-color: #5cb85c; border:1px solid #d6e9c6;">
  <tr>
    <td style="color:#FFF;"><a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix" style="color:#FFF; text-decoration:underline;"><strong>UPGRADE TO NEX-FORMS PRO!</strong></a></td>
  </tr>
</table><br />

</center>
</body>
</html>';
	
	$data_entry = $wpdb->prepare($wpdb->insert($wpdb->prefix.'wap_nex_forms_entries',
		array(								
			'nex_forms_Id'			=>	$_REQUEST['nex_forms_Id'],
			'page'					=>	$_POST['page'],
			'ip'					=>  $_POST['ip'],
			'user_Id'				=>	get_current_user_id(),
			'viewed'				=>	'no',
			'date_time'				=>  date('Y-m-d H:i:s'),
			'form_data'				=>	json_encode($data_array)
			)
		 )
	 );
	
	$insert = $wpdb->query($data_entry);
	
	print_r($_POST);
	
	
	$from_address 							= ($form_attr->from_address) 						? $form_attr->from_address 												: $default_values['from_address'];
	$from_name 								= ($form_attr->from_name) 							? $form_attr->from_name 												: $default_values['from_name'];
	$mail_to 								= ($form_attr->mail_to) 							? $form_attr->mail_to 													: $default_values['mail_to'];
	$subject 								= ($form_attr->confirmation_mail_subject) 			? str_replace('\\','',$form_attr->confirmation_mail_subject) 			:  str_replace('\\','',$default_values['confirmation_mail_subject']);
	$body 									= ($form_attr->confirmation_mail_body) 				? str_replace('\\','',$form_attr->confirmation_mail_body) 				:  str_replace('\\','',$default_values['confirmation_mail_body']);
	$onscreen 								= ($form_attr->on_screen_confirmation_message) 		? str_replace('\\','',$form_attr->on_screen_confirmation_message) 		:  str_replace('\\','',$default_values['on_screen_confirmation_message']);
	$google_analytics_conversion_code 		= ($form_attr->google_analytics_conversion_code) 	? str_replace('\\','',$form_attr->google_analytics_conversion_code) 	:  str_replace('\\','',$default_values['google_analytics_conversion_code']);


	$pattern = '({{+([A-Za-z 0-9_])+}})';
			
	preg_match_all($pattern, $body, $matches);
		foreach($matches[0] as $match)
			{
			$the_val = '';
			
			if(is_array($_REQUEST[IZC_Functions::format_name($match)]))
				{
				foreach($_REQUEST[IZC_Functions::format_name($match)] as $thekey=>$value)
					{
					$the_val .='<span class="fa fa-check"></span> '. $value.' ';	
					}
				$the_val = str_replace('Array','',$the_val);
				$body = str_replace($match,$the_val,$body);
				$subject = str_replace($match,$the_val,$subject);
				}
			else
				{
				$body = str_replace($match,$_REQUEST[IZC_Functions::format_name($match)],$body);
				$subject = str_replace($match,$_REQUEST[IZC_Functions::format_name($match)],$subject);	
				}
			}

$from = ($_REQUEST[$form_attr->user_email_field]) ? $_REQUEST[$form_attr->user_email_field] : $from_address;  
$subject = $subject;  
$message = $user_fields;  
   
  
// include the from email in the headers  
$headers = "From: $from";  
  
// boundary  
$time = md5(time());  
$boundary = "==Multipart_Boundary_x{$time}x";  
  
// headers used for send attachment with email  
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$boundary}\"";  
  
// multipart boundary  
$message = "--{$boundary}\n" . "Content-type: text/html; charset=UTF-8\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";  
$message .= "--{$boundary}\n";  
  
// attach the attachments to the message  
for($x = 0; $x < count($files); $x++){  
    $file = fopen($files[$x],"r");  
    $content = fread($file,filesize($files[$x]));  
    fclose($file);  
    $content = chunk_split(base64_encode($content));  
    $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$files[$x]\"\n" . "Content-Disposition: attachment;\n" . " filename=\"$filenames[$x]\"\n" . "Content-Transfer-Encoding: base64\n\n" . $content . "\n\n";  
    $message .= "--{$boundary}\n";  
}  




/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that

$email_config = get_option('nex-forms-email-config');
$mail_to = explode(',',$mail_to);

if($email_config['email_method']=='smtp' || $email_config['email_method']=='php_mailer')
	{
	
	date_default_timezone_set('Etc/UTC');
	require 'includes/Core/PHPMailerAutoload.php';
	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	
	
	$mail->CharSet = "UTF-8";
	$mail->Encoding = "base64";
	
	//Tell PHPMailer to use SMTP
	if($email_config['email_method']!='php_mailer')
		{
		
		$mail->isSMTP();
		//$mail->SMTPDebug = 2;
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = $email_config['smtp_host'];
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = 25;
		//encoding
		
		//Whether to use SMTP authentication
		if($email_config['smtp_auth']=='1')
			{
			$mail->SMTPAuth = true;
			//Username to use for SMTP authentication
			$mail->Username = $email_config['set_smtp_user'];
			//Password to use for SMTP authentication
			$mail->Password = $email_config['set_smtp_pass'];
			}
		else
			{
			$mail->SMTPAuth = false;
			}
		}
	//}
	//Set who the message is to be sent from
	$mail->setFrom($from_address, $from_name);
	//Set an alternative reply-to address
	/*if($_REQUEST[$form_attr->user_email_field])
		$mail->addReplyTo($_REQUEST[$form_attr->user_email_field], $_REQUEST[$form_attr->user_email_field]);
	else
		$mail->addReplyTo($from_address, $from_name);*/
		
	if($_REQUEST[$form_attr->user_email_field])
		$mail->setFrom($_REQUEST[$form_attr->user_email_field], $_REQUEST[$form_attr->user_email_field]);
	else
		$mail->setFrom($from_address, $from_name);
	//Set who the message is to be sent to
	
	foreach($mail_to as $email)
		$mail->addCC($email, $from_name);
	//Set the subject line
	$mail->Subject = $subject;
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail->msgHTML($user_fields, dirname(__FILE__));
	//Replace the plain text body with one created manually
	//$mail->AltBody = 'This is a plain-text message body';
	//Attach an file
	for($x = 0; $x < count($files); $x++){  
		$file = fopen($files[$x],"r");  
		$content = fread($file,filesize($files[$x]));  
		fclose($file);  
		$content = chunk_split(base64_encode($content));  
		$mail->addAttachment($files[$x]);
	} 
	
	//send the message, check for errors
	if (!$mail->send()) {
	   // echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	 //   echo "Message sent!";
		//echo print_r($mail);
	}

	
	

	}
if($email_config['email_method']=='php')
	{
	foreach($mail_to as $email)
		mail($email,$subject,$message,$headers);
	}
if($email_config['email_method']=='wp_mailer')
	{
	foreach($mail_to as $email)
		wp_mail($email,$subject,$message,$headers);
	}
//echo $email_config['email_method'];
die();
}
	
	
function NEXForms_ui_output( $atts , $echo=''){
	
	$config 	= new NEXForms_Config();
	global $wpdb;
	
	if(is_array($atts))
		{
		$defaults = array(
			'id' => '0',
			'open_trigger' => '',
			'type' => 'button',
			'text' => 'open',
			'make_sticky' => 'no',
			'paddel_text' => 'Contact Us',
			'paddel_color'=>'btn-primary',
			'button_color'=>'btn-primary',
			'position' => 'right'
			);
		extract( shortcode_atts( $defaults, $atts ) );
		wp_parse_args($atts, $defaults);
		}
	else
		$id=$atts;
		
		$get_form = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id = '.$id);
		$form_attr = $wpdb->get_row($get_form);
		
		if($make_sticky=='yes')
			{
				
			$output .= '<div id="nex-forms"><div class="nf-sticky-form paddel-'.$position.'"><div class="nf-sticky-paddel btn '.$paddel_color.'">'.$paddel_text.'</div><div class="nf-sticky-container">';	
			}
		
		
		if($open_trigger=="popup")
			{
			if($type == 'button')
				$output .= '<div id="nex-forms"><button class="btn '.$button_color.' open_nex_forms_popup" data-popup-id="'.$atts['id'].'">'.$text.'</button></div>';
			else
				$output .= '<a href="#" class="open_nex_forms_popup" data-popup-id="'.$atts['id'].'">'.$text.'</a>';
			
			$output .= '<div class="modal fade nex_forms_modal" id="nexForms_popup_'.$atts['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-info">
							  	<button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="display: inline-block;">×</button>
								<h4 class="modal-title" id="myModalLabel">'.$form_attr->title.'</h4>
							  </div>
							  <div class="modal-body">';	
			}
		
		$output .= '<div id="the_plugin_url" style="display:none;">'.WP_PLUGIN_URL.'/nex-forms</div>';
		
		$output .= '<div id="nex-forms" class="nex-forms">';
			$output .= '<div id="confirmation_page" class="confirmation_page" style="display:none;">'.$form_attr->confirmation_page.'</div>';
			$output .= '<div id="on_form_submmision" class="on_form_submmision" style="display:none;">'.$form_attr->on_form_submission.'</div>';
			$output .= '<div class="ui-nex-forms-container" id="ui-nex-forms-container"  >';
			$output .= '<div class="current_step" style="display:none;">1</div>';
			
			if($make_sticky=='yes')
				{
				$output .= '<div style="padding:15px; display:none;" class="nex_success_message"><div class="panel-body alert alert-success" >'.str_replace('\\','',$form_attr->on_screen_confirmation_message).'</div></div>';
				}
			else
				{
				$output .= '<div class="panel-body alert alert-success nex_success_message" style="display:none;">'.str_replace('\\','',$form_attr->on_screen_confirmation_message).'</div>';
				}
			
			
			$post_action = ($form_attr->post_action=='ajax' || !$form_attr->post_action) ? get_option('siteurl').'/wp-admin/admin-ajax.php' : $form_attr->custom_url;
			
			$set_ajax = ($form_attr->post_action=='ajax' || !$form_attr->post_action) ? 'submit-nex-form' : 'send-nex-form';
			$post_method = 'post';
			
			if($form_attr->post_action!='ajax')
				$post_method = ($form_attr->post_action=='POST' || !$form_attr->post_type) ? 'post' : 'get';
			
				$output .= 	'<form id="" class="'.$set_ajax.'" name="nex_form" action="'.$post_action.'" method="'.$post_method.'" enctype="multipart/form-data">';
					$output .= '<input type="hidden" name="nex_forms_Id" value="'.$id.'">';
					$output .= '<input type="hidden" name="page" value="'.$_SERVER['REQUEST_URI'].'">';
					$output .= '<input type="hidden" name="ip" value="'.$_SERVER['REMOTE_ADDR'].'">';
					
			
					$hidden_fields_raw = explode('[end]',$form_attr->hidden_fields);
					
					foreach($hidden_fields_raw as $hidden_field)
						{
						$hidden_field = explode('[split]',$hidden_field);
						if($hidden_field[0])
							$output .= '<input type="hidden" name="'.$hidden_field[0].'" value="'.$hidden_field[1].'">';
						}					
					$output .= '<input type="text" name="company_url" value="" placeholder="enter company url" class="form-control req">';			
					$output .=  str_replace('\\','',$form_attr->form_fields);
					$output .= '<div style="clear:both;"></div>';
				$output .= 	'</form>';
			$output .= '</div>';
		$output .= '</div>';
		
	if($open_trigger=="popup")
			{	
	$output .= '</div>
			</div>
		  </div>
		</div>';
			}
			
	if($make_sticky=='yes')	
		$output .= '</div></div></div>';
		
/* SCRIPTS AND STYLE INCLUSIONS */		
	
	$script_config = get_option('nex-forms-script-config');
	$styles_config = get_option('nex-forms-style-config');
	$other_config = get_option('nex-forms-other-config');
	
	
	if($script_config['inc-jquery']=='1')
		wp_enqueue_script('jquery');
	if($script_config['inc-jquery-ui-core']=='1')
		wp_enqueue_script('jquery-ui-core');
	if($script_config['inc-jquery-ui-autocomplete']=='1')
		wp_enqueue_script('jquery-ui-autocomplete');
	if($script_config['inc-jquery-ui-slider']=='1')
		wp_enqueue_script('jquery-ui-slider');
	if($script_config['inc-jquery-form']=='1')
		wp_enqueue_script('jquery-form');
	
	if($script_config['inc-jquery-ui-slider']=='1')
		wp_enqueue_script('nex-forms-slider.min', plugins_url( '/nex-forms-express-wp-form-builder/js/slider.min.js'));
	if($script_config['inc-bootstrap']=='1')
		wp_enqueue_script('nex-forms-bootstrap.min',  plugins_url( '/nex-forms-express-wp-form-builder/js/bootstrap.min.js'));
		
		
		
	if($script_config['inc-onload']=='1')
		wp_enqueue_script('nex-forms-onload', plugins_url( '/nex-forms-express-wp-form-builder/js/nexf-onload-ui.js'));
	
	
	wp_enqueue_script('nex-forms-moment.min', plugins_url( '/nex-forms-express-wp-form-builder/js/moment.min.js'));
	wp_enqueue_script('nex-forms-locales.min', plugins_url( '/nex-forms-express-wp-form-builder/js/locales.js'));	
	wp_enqueue_script('nex-forms-bootstrap-datetimepicker', plugins_url( '/nex-forms-express-wp-form-builder/js/bootstrap-datetimepicker.js'));
	
	if($styles_config['incstyle-jquery']=='1')
		wp_enqueue_style('jquery-ui');	
	if($styles_config['incstyle-jquery']=='1')
		wp_enqueue_style('nex-forms-jQuery-UI',plugins_url( '/nex-forms-express-wp-form-builder/css/jquery-ui.min.css'));
	if($styles_config['incstyle-font-awesome']=='1')
		wp_enqueue_style('nex-forms-font-awesome',plugins_url( '/nex-forms-express-wp-form-builder/css/font-awesome.min.css'));
	if($styles_config['incstyle-bootstrap']=='1')
		wp_enqueue_style('nex-forms-bootstrap-ui', plugins_url( '/nex-forms-express-wp-form-builder/css/ui-bootstrap.css'));
	if($styles_config['incstyle-custom']=='1')
		wp_enqueue_style('nex-forms-ui', plugins_url( '/nex-forms-express-wp-form-builder/css/ui.css'));
	if($styles_config['incstyle-custom']=='1')
		wp_enqueue_style('nex-forms-fields', plugins_url( '/nex-forms-express-wp-form-builder/css/fields.css'));
	
	if($other_config['enable-print-scripts']=='1')
		wp_print_scripts();
	if($other_config['enable-print-styles']=='1')
		wp_print_styles();
	
	if($echo)
		echo $output;
	else
		return $output;	
}

if(!function_exists('nex_forms_add_ons_dashboard_widget'))
	{
	function nex_forms_add_ons_dashboard_widget(){
		wp_enqueue_style ('basix-dashboard',WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/basix-dashboard.css');
		wp_enqueue_script('basix-dashboard-js',WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/basix-dashboard.js');
		global $wpdb;
		$output .= '<p>These add-ons are available for the NEX-Forms Express version</p><div class="dashboard_wrapper">';
			$output .= '<div class="item_logo "><a href="http://codecanyon.net/item/form-themes-for-nexforms/10037800?ref=Basix"><img width="80" height="80" border="0" title="" src="http://basixonline.net/add-ons/themes/logo.jpg" data-preview-width="" data-preview-height="" data-item-name="Form Themes for NEX-Forms" data-item-cost="12" data-item-category="WordPress / Forms" data-item-author="Basix" class="landscape-image-magnifier preload no_preview" alt="Form Themes for NEX-Forms - CodeCanyon Item for Sale" data-tooltip="Form Themes for NEX-Forms"></a><div class="cover_image"><img src="http://basixonline.net/add-ons/themes/cover.png" itemprop="image" alt="Form Themes for NEX-Forms - CodeCanyon Item for Sale"></div></div>';
			$output .= '<div class="item_logo "><a href="http://codecanyon.net/item/export-to-pdf-for-nexforms/11220942?ref=Basix"><img width="80" height="80" border="0" title="" src="http://basixonline.net/add-ons/pdf/logo.jpg" data-preview-width="" data-preview-height="" data-item-name="Export to PDF for NEX-Forms" data-item-cost="12" data-item-category="WordPress / Forms" data-item-author="Basix" class="landscape-image-magnifier preload no_preview" alt="Form Themes for NEX-Forms - CodeCanyon Item for Sale" data-tooltip="Export to PDF"></a><div class="cover_image"><img src="http://basixonline.net/add-ons/pdf/cover.png" itemprop="image" alt="Export to PDF for NEX-Forms - CodeCanyon Item for Sale"></div></div>';
			$output .= '<div class="item_logo empty"><div class="item_wrapper"></div></div>';
			$output .= '<div class="item_logo empty"><div class="item_wrapper"></div></div>';
		$output .= '<div style="clear:both;"></div>';
			
		$output .= '</div>';
		
		echo $output;
	}
	
	function nex_forms_add_ons_dashboard_setup() {
		
		wp_add_dashboard_widget('nex_forms_add_ons_dashboard_widget', 'NEX-Forms Express Add-ons', 'nex_forms_add_ons_dashboard_widget');
		
		global $wp_meta_boxes;
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		$wa_form_builder_widget_backup = array('nex_forms_add_ons_dashboard_widget' => $normal_dashboard['nex_forms_add_ons_dashboard_widget']);
		unset($normal_dashboard['nex_forms_add_ons_dashboard_widget']);
		$sorted_dashboard = array_merge($wa_form_builder_widget_backup, $normal_dashboard);
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;	
	} 

	add_action('wp_dashboard_setup', 'nex_forms_add_ons_dashboard_setup' );
	}



function nex_forms_gopro_dashboard_widget(){
		wp_enqueue_style ('basix-dashboard',WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/basix-dashboard.css');
		wp_enqueue_style ('basix-font-awesome',WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/font-awesome.min.css');
		wp_enqueue_style ('basix-BS',WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/bootstrap.min.css');
		wp_enqueue_script('basix-dashboard-js',WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/js/basix-dashboard.js');
		global $wpdb;
		$output .= '<div class="dashboard_wrapper alert alert-success">';
			$output .= '<ul>
									<li><span class="fa fa-check text-success">&nbsp;</span>&nbsp;&nbsp;Enable form data in e-mails</li>
									<li><span class="fa fa-check text-success">&nbsp;</span>&nbsp;&nbsp;Enable anti-spam control</li>
									<li><span class="fa fa-check text-success">&nbsp;</span>&nbsp;&nbsp;Enable view and export of form entry data</li>
									<li><span class="fa fa-check text-success">&nbsp;</span>&nbsp;&nbsp;Enable user confirmation e-mails</li>
									<li><span class="fa fa-check text-success">&nbsp;</span>&nbsp;&nbsp;Get FREE online support</li>
									<li><span class="fa fa-check text-success">&nbsp;</span>&nbsp;&nbsp;Get FREE item updates for life</li>
								</ul>
					<a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix" target="_blank" class="btn btn-success">GO PRO for a once in a lifetime purchase of only $33</a>';
		$output .= '<div style="clear:both;"></div>';
			
		$output .= '</div>';
		
		echo $output;
	}
	
	function nex_forms_gopro_dashboard_setup() {
		
		wp_add_dashboard_widget('nex_forms_gopro_dashboard_widget', 'GO PRO With NEX-Forms', 'nex_forms_gopro_dashboard_widget');
		
		global $wp_meta_boxes;
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		$wa_form_builder_widget_backup = array('nex_forms_gopro_dashboard_widget' => $normal_dashboard['nex_forms_gopro_dashboard_widget']);
		unset($normal_dashboard['nex_forms_gopro_dashboard_widget']);
		$sorted_dashboard = array_merge($wa_form_builder_widget_backup, $normal_dashboard);
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;	
	} 

	add_action('wp_dashboard_setup', 'nex_forms_gopro_dashboard_setup' );



add_action('admin_notices', 'nf_gopro_admin_notice');
add_action('admin_init', 'nf_gopro_nag_ignore');

function nf_gopro_admin_notice() {
	global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'nf_gopro_ignore_notice') ) {
        echo '<div class="updated"><p>';
        printf(__('<strong>Upgrade to <a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix">NEX-Forms PRO</a> and unlock tons of extra form building features!</strong> <a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix"><strong>GO PRO</strong></a> '), '?nf_add_on_nag_ignore=0');
        echo "</p></div>";
	}
}
function nf_gopro_nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['nf_gopro_nag_ignore']) && '0' == $_GET['nf_gopro_nag_ignore'] ) {
             add_user_meta($user_id, 'nf_gopro_ignore_notice', 'true', true);
	/* Gets where the user came from after they click Hide Notice */
		if ( wp_get_referer() ) {
    /* Redirects user to where they were before */
    wp_safe_redirect( wp_get_referer() );
		} else {
    /* This will never happen, I can almost gurantee it, but we should still have it just in case*/
    wp_safe_redirect( home_url() );
		}
	}
}

add_action('admin_notices', 'nf_add_on_admin_notice');
add_action('admin_init', 'nf_add_on_nag_ignore');
function nf_add_on_admin_notice() {
	global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'nf_add_on_ignore_notice') ) {
        echo '<div class="updated"><p>';
        printf(__('<strong>NEX-Forms</strong> recommends <a href="http://codecanyon.net/item/form-themes-for-nexforms/10037800?ref=Basix"><strong>25 Preset Form Themes for NEX-Forms</strong></a> Add-on...<a href="http://codecanyon.net/item/form-themes-for-nexforms/10037800?ref=Basix"><strong>Get it now</strong></a> | <a href="%1$s">Hide Notice</a>'), '?nf_add_on_nag_ignore=0');
        echo "</p></div>";
	}
}
function nf_add_on_nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['nf_add_on_nag_ignore']) && '0' == $_GET['nf_add_on_nag_ignore'] ) {
             add_user_meta($user_id, 'nf_add_on_ignore_notice', 'true', true);
	/* Gets where the user came from after they click Hide Notice */
		if ( wp_get_referer() ) {
    /* Redirects user to where they were before */
    wp_safe_redirect( wp_get_referer() );
		} else {
    /* This will never happen, I can almost gurantee it, but we should still have it just in case*/
    wp_safe_redirect( home_url() );
		}
	}
}

add_action('admin_notices', 'nf_add_on_pdf_admin_notice');
add_action('admin_init', 'nf_add_on_pdf_nag_ignore');
function nf_add_on_pdf_admin_notice() {
	global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'nf_add_on_pdf_ignore_notice') ) {
        echo '<div class="updated"><p>';
        printf(__('<strong>NEX-Forms</strong> recommends <a href="http://codecanyon.net/user/Basix/portfolio?ref=Basix"><strong>Export to PDF for NEX-Forms</strong></a> Add-on...<a href="http://codecanyon.net/user/Basix/portfolio?ref=Basix"><strong>Get it now</strong></a> | <a href="%1$s">Hide Notice</a>'), '?nf_add_on_pdf_nag_ignore=0');
        echo "</p></div>";
	}
}
function nf_add_on_pdf_nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['nf_add_on_pdf_nag_ignore']) && '0' == $_GET['nf_add_on_pdf_nag_ignore'] ) {
             add_user_meta($user_id, 'nf_add_on_pdf_ignore_notice', 'true', true);
	/* Gets where the user came from after they click Hide Notice */
		if ( wp_get_referer() ) {
    /* Redirects user to where they were before */
    wp_safe_redirect( wp_get_referer() );
		} else {
    /* This will never happen, I can almost gurantee it, but we should still have it just in case*/
    wp_safe_redirect( home_url() );
		}
	}
}


if(is_admin())
wp_enqueue_style('nex-forms-public-admin', WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/public.css');

?>