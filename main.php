<?php
/*
Plugin Name: NEX-Forms
Plugin URI: http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix
Plugin Prefix: wap_ 
Module Ready: Yes
Plugin TinyMCE: popup
Description: Premium WordPress Plugin - Ultimate Drag and Drop WordPress Forms Builder.
Author: Basix
Version: 4.5
Author URI: http://codecanyon.net/user/Basix/portfolio?ref=Basix
License: GPL
*/

//my_deregister_javascript();
if($_REQUEST['page']=="nex-forms-main")
	{
	add_action( 'wp_print_scripts', 'nf_deregister_javascript',100);
	add_action( 'wp_print_styles', 'nf_deregister_stylesheets',100);
	add_action( 'init', 'nf_deregister_javascript',100);
	add_action( 'init', 'nf_deregister_stylesheets',100);
	}

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
			'admin_email_body'					=>  'longtext',
			'confirmation_mail_subject'			=>	'text',
			'from_address'						=>  'text',
			'from_name'							=>  'text',
			'on_screen_confirmation_message'	=>  'longtext',
			'confirmation_page'					=>  'text',
			'form_fields'						=>	'longtext',
			'clean_html'						=>	'longtext',
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
			'post_action'						=>  'text',
			'bcc'								=>  'text',
			'bcc_user_mail'						=>  'text',
			'custom_css'						=>  'longtext',
			'is_paypal'							=>  'text',
			'total_views'						=>  'text',
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
		/*'payment_status' => array
			(
			'grouplabel'	=>	'payment_status',
			'type'			=>	'textarea',
			'req'			=>	'1',
			'items'			=>	'',
			'origen'		=>	'default'
			),*/
		'paypal_data' => array
			(
			'grouplabel'	=>	'form_data',
			'type'			=>	'textarea',
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
			),
		
		
		);
			
	public $addtional_table_fields = array
			(
			'nex_forms_Id'			=>	'text',
			'page'					=>	'text',
			'ip'					=>  'text',
			'user_Id'				=>	'text',
			'viewed'				=>	'text',
			'date_time'				=>  'datetime',
			'paypal_invoice'		=>	'text',
			'payment_status'		=>  'text',
			'form_data'				=>	'longtext',
			'paypal_data'			=>	'longtext',
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
					'icon_url' 		=> plugins_url('/images/menu_icon.png',__FILE__),
					'position '		=> ''
					),
					'sub_menu_page'		=>	array
							(
							'test' => array
								(
								'parent_slug' 	=> $plugin_alias.'-main',
								'page_title' 	=> 'test',
								'menu_title' 	=> 'test',
								'capability' 	=> 'administrator',
								'menu_slug' 	=> ''.$plugin_alias.'-test',
								'function' 		=> 'NEXForms_form_test_page',
								),
							'export' => array
								(
								'parent_slug' 	=> $plugin_alias.'-main',
								'page_title' 	=> 'export',
								'menu_title' 	=> 'export',
								'capability' 	=> 'administrator',
								'menu_slug' 	=> ''.$plugin_alias.'-form-export',
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
	global $wpdb;
	update_option('nex-forms-version',$config->plugin_version);
	//EMAIL SETTINGS
	if(!get_option('nex-forms-email-config'))
		{
		add_option('nex-forms-email-config',array(
				'email_method'=>'php_mailer', 
				'email_content'=>'html', 
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
				'enable-color-adapt'=>'1',	
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
	IZC_Database::alter_plugin_table('wap_nex_forms','clean_html','longtext');
	IZC_Database::alter_plugin_table('wap_nex_forms','custom_url','text');
	IZC_Database::alter_plugin_table('wap_nex_forms','admin_email_body','longtext');
	IZC_Database::alter_plugin_table('wap_nex_forms','bcc','text');
	IZC_Database::alter_plugin_table('wap_nex_forms','bcc_user_mail','text');
	IZC_Database::alter_plugin_table('wap_nex_forms','post_type','text');
	IZC_Database::alter_plugin_table('wap_nex_forms','post_action','text');	
	IZC_Database::alter_plugin_table('wap_nex_forms','custom_css','longtext');
	IZC_Database::alter_plugin_table('wap_nex_forms','is_paypal','text');
	IZC_Database::alter_plugin_table('wap_nex_forms','total_views','text');
	
	IZC_Database::alter_plugin_table('wap_nex_forms_entries','paypal_invoice','text');
	IZC_Database::alter_plugin_table('wap_nex_forms_entries','payment_status','text');
	IZC_Database::alter_plugin_table('wap_nex_forms_entries','paypal_data','longtext');

}



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
   $plugin_array['nexforms'] = plugins_url( '/tinyMCE/plugin.js',__FILE__);
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

function NEXForms_hex2RGB($hexStr, $returnAsString = true, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ?  'rgba('.implode($seperator, $rgbArray).',0.98)' : $rgbArray;
}
function NEXForms_main_page(){
	
	
	global $_wp_admin_css_colors; 
	
	$get_colors = $_wp_admin_css_colors[get_user_option( 'admin_color' )]->colors;
	
	//echo '<pre>'; print_r($get_colors); echo '</pre>'; 
	
	//echo NEXForms_hex2RGB($get_colors[0]);
	
	$color_1 =  NEXForms_hex2RGB($get_colors[0]);
	$color_2 =  NEXForms_hex2RGB($get_colors[1]);
	$color_3 =  NEXForms_hex2RGB($get_colors[2]);
	$color_4 =  NEXForms_hex2RGB($get_colors[3]);
	
	$color_flat_1 =  $get_colors[0];
	$color_flat_2 =  $get_colors[1];
	$color_flat_3 =  $get_colors[2];
	$color_flat_4 =  $get_colors[3];
	
	$font_color_1 =  $_wp_admin_css_colors[get_user_option( 'admin_color' )]->icon_colors['base'];
	$font_color_2 =  $_wp_admin_css_colors[get_user_option( 'admin_color' )]->icon_colors['focus'];
	$font_color_3 =  $_wp_admin_css_colors[get_user_option( 'admin_color' )]->icon_colors['current'];
	$font_color_4 =  '#eee';
	

	$background_color = '#fff';
	$background_color_2 =  $color_flat_2;
	$text_colors = '#444';
	$box_shadow = $color_flat_1;
	
	switch(get_user_option( 'admin_color' ))
		{
		case 'fresh':
				$background_color = '#fff';
		break;
		case 'light':
			$color_1 =  NEXForms_hex2RGB($get_colors[0]);
			$color_2 =  NEXForms_hex2RGB($get_colors[1]);
			$color_3 =  NEXForms_hex2RGB($get_colors[2]);
			$color_4 =  NEXForms_hex2RGB($get_colors[3]);
			
			$color_flat_1 =  $get_colors[0];
			$color_flat_2 =  $get_colors[1];
			$color_flat_3 =  $get_colors[2];
			$color_flat_4 =  $get_colors[3];
			
			$font_color_1 =  '#666';
			$font_color_2 =  '#fff';
			$font_color_3 =  '#fff';
			$font_color_4 =  '#666';
			
			$box_shadow = '#888';
			$background_color_2 =  '#f9f9f9';
		break;
		case 'blue':
				
		break;
		case 'coffee':
		
		break;
		case 'midnight':
			$color_1 =  NEXForms_hex2RGB($get_colors[0]);
			$color_2 =  NEXForms_hex2RGB($get_colors[1]);
			$color_3 =  NEXForms_hex2RGB($get_colors[3]);
			$color_4 =  NEXForms_hex2RGB($get_colors[2]);
			
			$color_flat_1 =  $get_colors[0];
			$color_flat_2 =  $get_colors[1];
			$color_flat_3 =  $get_colors[3];
			$color_flat_4 =  $get_colors[2];
			
			$font_color_1 =  $_wp_admin_css_colors[get_user_option( 'admin_color' )]->icon_colors['base'];
			$font_color_2 =  $_wp_admin_css_colors[get_user_option( 'admin_color' )]->icon_colors['focus'];
			$font_color_3 =  $_wp_admin_css_colors[get_user_option( 'admin_color' )]->icon_colors['current'];
			$font_color_4 =  '#eee';
			
		break;
		}
	
	
	$other_config = get_option('nex-forms-other-config');
	if($other_config['enable-color-adapt']==1 || !array_key_exists('enable-color-adapt',$other_config))
	{
	?>
    
    <style type="text/css" title="admin_styles">
	
	#wpadminbar, #adminmenuback{
		box-shadow: 2px 2px 4px  <?php echo $box_shadow; ?> !important;
	}
	
	div#nex-forms div.top-strip{
		background:<?php echo $color_1; ?> !important;
		box-shadow: 0 0 5px <?php echo $color_2; ?> !important;
	}
	.top-strip span.fa, .top-strip span.glyphicon {
		color:<?php echo $font_color_1; ?> !important;
	}
	.top-strip button {
		color:<?php echo $font_color_4; ?> !important;
	}
	.top-strip button:hover{
		background:<?php echo $color_flat_4; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	.top-strip  button:hover span.fa, .top-strip  button:hover span.glyphicon{
	
		color:<?php echo $font_color_3; ?> !important;
	}
	.top-strip  button span.badge{
		background:<?php echo $color_flat_4; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	.top-strip  button:hover span.badge{
		background:<?php echo $color_flat_1; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	.top-strip .nav_divider{
		background:<?php echo $color_2; ?> !important;
	}
	.top-strip button.active {
		background: <?php echo $color_flat_3; ?> !important;
		border-left: 1px solid <?php echo $color_flat_3; ?>;
		border-right: 1px solid <?php echo $color_flat_3; ?>;
		box-shadow: none !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	.top-strip  button.active span.fa, .top-strip  button.active span.glyphicon{
		color:<?php echo $font_color_3; ?> !important;
	}
	
	
	.top-strip  .btn-group.help_documentation button {
		background:<?php echo $color_2; ?> !important;
	}
	.top-strip  .btn-group.open_global_settings button {
		border-left: 1px solid <?php echo $color_1; ?> !important;
		border-right: 1px solid <?php echo $color_1; ?> !important;
		background:<?php echo $color_2; ?> !important;
	}
	.rightmenu .colleft .col1 .panel-heading{
		background:<?php echo $color_1; ?> !important;
		border:none !important;
	}
	.rightmenu .colleft .col1 .panel-heading:hover{
		background:<?php echo $color_2; ?> !important;
	}
	.rightmenu .colleft .col1 .panel-heading a, .col1 .panel-heading .fa, .col1 .panel-heading .glyphicon{
		color:<?php echo $font_color_4; ?> !important;
	}
	.rightmenu .colleft .col1 .panel-heading:hover a, .col1 .panel-heading:hover .fa, .col1 .panel-heading:hover .glyphicon{
		color:<?php echo $font_color_2; ?> !important;
	}
	.rightmenu .colleft .col1 .panel-default{
		border: none !important;
	}
	.rightmenu .colleft .col1 .panel-heading {
		border-bottom: 1px solid <?php echo $color_2; ?> !important;
		border-top-left-radius: 0px !important;
		border-top-right-radius: 0px !important;
	}
	
	.rightmenu .colleft, .slide_in_container, .slide_in_page{
		background: <?php echo $background_color_2; ?> !important;
	}
	
	.rightmenu .colleft .col1 .panel-body{
		background: <?php echo $background_color; ?>;
	}
	
	#fields_accordion .form_field .draggable_object .btn {
		background:none !important;
		border-bottom: 1px solid #ddd;
		border-left: medium none !important;
		border-radius: 0;
		border-right: 1px solid #ddd;
		border-top: medium none !important;
		color:#444 !important;
		box-shadow:none;
	}
	#fields_accordion .form_field .draggable_object .btn:hover{
		background:<?php echo $color_flat_4; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	.form_holder .list-group-item{
		background: <?php echo $color_1; ?> !important;
		border-top:none !important;
		border-left:none !important;
		border-bottom: 2px solid <?php echo $color_2; ?> !important;
		border-right:none !important;
		color:<?php echo $font_color_4; ?> !important;
	}
	.form_holder .list-group-item .fa{
		color:<?php echo $font_color_4; ?> !important;
	}
	.form_holder .list-group-item.active, .form_holder .list-group-item.active:active{
		background: <?php echo $color_3; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	
	.form_holder .list-group-item.active span.badge{
		background:<?php echo $color_1; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	.form_holder .list-group-item.active span.fa{
		color:<?php echo $font_color_3; ?> !important;
	}
	.form_holder .list-group-item:hover{
		background:<?php echo $color_flat_4; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	.form_holder .list-group-item:hover span.fa{
	
		color:<?php echo $font_color_3; ?> !important;
	}
	.form_holder .list-group-item span.badge{
		background:<?php echo $color_flat_4; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	.form_holder .list-group-item:hover span.badge{
		background:<?php echo $color_flat_1; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	.do_permanent_delete{
		background:<?php echo $color_flat_4; ?> !important;
	}
	.close_slide_in, .close_slide_in_right {
		background: <?php echo $color_flat_1; ?> !important;
		border: 1px solid <?php echo $color_flat_1; ?> !important;
		box-shadow: 2px -3px 4px  <?php echo $box_shadow; ?> !important;
	}
	.close_slide_in .fa, .close_slide_in_right .fa{
		color: <?php echo $font_color_4; ?> !important;
	}
	.template_forms .form_holder_heading{
		background:<?php echo $color_2; ?> !important;
		color:<?php echo $font_color_4; ?> !important;
	}
	.template_forms .form_holder_heading .fa{
		color:<?php echo $font_color_4; ?> !important;
	}
	
	.slide_in_container, .slide_in_page{
		box-shadow: 2px -3px 4px  <?php echo $box_shadow; ?> !important;
	}
	.slide_in_on_submit label, .slide_in_paypal_setup label, .slide_in_page .input-group-addon,
	.slide_in_page input.hidden_field_name, .slide_in_page input.hidden_field_name:focus,
	.data_select div{
		background: <?php echo $color_flat_1; ?> !important;
		color:<?php echo $font_color_4; ?> !important;
		border: 1px solid <?php echo $color_2; ?> !important;
	}
	.data_select div.active{
		background: <?php echo $color_flat_3; ?> !important;
	}
	label.settings{
		background: <?php echo $font_color_3; ?> !important;
		color:<?php echo $color_1; ?> !important;
		border: 1px solid <?php echo $color_flat_1; ?> !important;
	}
	.slide_in_right h4, #nex-forms-field-settings h4{
		background: <?php echo $color_1; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
		border-bottom: 1px solid <?php echo $color_flat_1; ?> !important;
	}
	/*.slide_in_right .nav-tabs li.active a, #nex-forms-field-settings .nav-tabs li.active a{
		background: <?php echo $color_2; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	.slide_in_right .nav-tabs li:hover a,  #nex-forms-field-settings .nav-tabs li:hover a{
		background: <?php echo $color_flat_4; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	.slide_in_right, #field-settings-inner{
		background: <?php echo $color_2; ?> !important;
	}
	.slide_in_right label, #field-settings-inner label{
		color:<?php echo $font_color_3; ?> !important;
	}*/
	.slide_in_right .btn.btn-primary, .slide_in_right .btn.btn-primary:hover, #field-settings-inner .input-group-addon.label-primary, #field-settings-inner .input-group-addon.label-primary:hover{
		background: <?php echo $color_flat_3; ?> !important;
		border-color: <?php echo $color_flat_3; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	.slide_in_right .btn:hover{
		background: <?php echo $color_flat_4; ?> !important;
		border-color: <?php echo $color_flat_4; ?> !important;
		color:<?php echo $font_color_3; ?> !important;
	}
	</style>
    
    <?php
	}
	
	$config 	= new NEXForms_Config();
	$template 	= new IZC_Template();
	$custom		= new NEXForms_admin();
	
	$custom->plugin_name  = $config->plugin_name;
	$custom->plugin_alias = $config->plugin_alias;
	$custom->plugin_table = $config->plugin_table;
		
	$template -> build_header( $config->plugin_name,'' , $template->build_menu($modules_menu),'',$config->plugin_alias);
	
	$body .= $custom->NEXForms_admin();	

	echo $template -> build_body($body);
	global $wp_styles;
	$include_style_array = array('colors','wp-admin','login','install','wp-color-picker','customize-controls','customize-widgets','press-this','ie','buttons','dashicons','open-sans','admin-bar','wp-auth-check','editor-buttons','media-views','wp-pointer','imgareaselect','wp-jquery-ui-dialog','mediaelement','wp-mediaelement','thickbox','media','farbtastic','jcrop','colors-fresh','nex-forms-admin-holy-grail.min','nex-forms-bootstrap.min','nex-forms-bootstrap-fields','nex-forms-font-awesome','nex-forms-admin','nex-forms-ui','nex-forms-jQuery-UI','defaults','styles-chosen','styles-font-menu');
	
	echo '<div class="unwanted_css_array" style="display:none;">';
	foreach($wp_styles->registered as $wp_style=>$array)
		{
		
		if(!in_array($array->handle,$include_style_array))
			{
			echo '<div class="unwanted_css">'.$array->handle.'-css</div>';
			}
		}	
	echo '</div>';

}


function nf_deregister_javascript(){
	global $wp_scripts; 
	
	$include_script_array = array('utils','common','wp-a11y','sack','quicktags','colorpicker','editor','wp-fullscreen','wp-ajax-response','wp-pointer','autosave','heartbeat','wp-auth-check','wp-lists','prototype','scriptaculous-root','scriptaculous-builder','scriptaculous-dragdrop','scriptaculous-effects','scriptaculous-slider','scriptaculous-sound','scriptaculous-controls','scriptaculous','cropper','jquery','jquery-core','jquery-migrate','jquery-ui-core','jquery-effects-core','jquery-effects-blind','jquery-effects-bounce','jquery-effects-clip','jquery-effects-drop','jquery-effects-explode','jquery-effects-fade','jquery-effects-fold','jquery-effects-highlight','jquery-effects-puff','jquery-effects-pulsate','jquery-effects-scale','jquery-effects-shake','jquery-effects-size','jquery-effects-slide','jquery-effects-transfer','jquery-ui-accordion','jquery-ui-autocomplete','jquery-ui-button','jquery-ui-datepicker','jquery-ui-dialog','jquery-ui-draggable','jquery-ui-droppable','jquery-ui-menu','jquery-ui-mouse','jquery-ui-position','jquery-ui-progressbar','jquery-ui-resizable','jquery-ui-selectable','jquery-ui-selectmenu','jquery-ui-slider','jquery-ui-sortable','jquery-ui-spinner','jquery-ui-tabs','jquery-ui-tooltip','jquery-ui-widget','jquery-form','jquery-color','suggest','schedule','jquery-query','jquery-serialize-object','jquery-hotkeys','jquery-table-hotkeys','jquery-touch-punch','masonry','jquery-masonry','thickbox','jcrop','swfobject','plupload','plupload-all','plupload-html5','plupload-flash','plupload-silverlight','plupload-html4','plupload-handlers','wp-plupload','swfupload','swfupload-swfobject','swfupload-queue','swfupload-speed','swfupload-all','swfupload-handlers','comment-reply','json2','underscore','backbone','wp-util','wp-backbone','revisions','imgareaselect','mediaelement','wp-mediaelement','froogaloop','wp-playlist','zxcvbn-async','password-strength-meter','user-profile','language-chooser','user-suggest','admin-bar','wplink','wpdialogs','word-count','media-upload','hoverIntent','customize-base','customize-loader','customize-preview','customize-models','customize-views','customize-controls','customize-widgets','customize-preview-widgets','accordion','shortcode','media-models','media-views','media-editor','media-audiovideo','mce-view','admin-tags','admin-comments','xfn','postbox','tags-box','post','press-this','editor-expand','link','comment','admin-gallery','admin-widgets','theme','inline-edit-post','inline-edit-tax','plugin-install','updates','farbtastic','iris','wp-color-picker','dashboard','list-revisions','media-grid','media','image-edit','set-post-thumbnail','nav-menu','custom-header','custom-background','media-gallery','svg-painter','nex-forms-bootstrap.min','nex-forms-moment.min','nex-forms-locales.min','nex-forms-bootstrap-datetimepicker','nex-forms-fields','nex-forms-ui','nex-forms-onload','nex-forms-form-validation','nex-forms-drag-and-drop','nex-forms-form-controls','nex-forms-math.min','nex-forms-jquery.tinymce','nex-forms-field-settings-main','nex-forms-field-logic','core-functions','nex-forms-jquery.dropdown','nex-forms-themes-add-on','styles-chosen','styles-font-menu');
	
	foreach($wp_scripts->registered as $wp_script=>$array)
		{
		if(!in_array($array->handle,$include_script_array))
			{
			wp_deregister_script($array->handle);
			wp_dequeue_script($array->handle);
			wp_scripts()->remove($array->handle);
			}
		}	
}

function nf_deregister_stylesheets(){
	global $wp_styles;
	$include_style_array = array('colors','wp-admin','login','install','wp-color-picker','customize-controls','customize-widgets','press-this','ie','buttons','dashicons','open-sans','admin-bar','wp-auth-check','editor-buttons','media-views','wp-pointer','imgareaselect','wp-jquery-ui-dialog','mediaelement','wp-mediaelement','thickbox','media','farbtastic','jcrop','colors-fresh','nex-forms-admin-holy-grail.min','nex-forms-bootstrap.min','nex-forms-bootstrap-fields','nex-forms-font-awesome','nex-forms-admin','nex-forms-ui','nex-forms-jQuery-UI','defaults','styles-chosen','styles-font-menu');

	foreach($wp_styles->registered as $wp_style=>$array)
		{
		if(!in_array($array->handle,$include_style_array))
			{
			wp_deregister_style($array->handle);
			wp_dequeue_style($array->handle);
			}
	}	
//wp_print_scripts();
}




//add_action('init', 'removeScripts');





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
header("content-type:application/csv;charset=UTF-8");
header("Content-Disposition: attachment; filename=\"report.csv\";" );
header("Content-Transfer-Encoding: base64");
echo "\xEF\xBB\xBF";
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

	$get_form_data = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_entries WHERE nex_forms_Id = '.filter_var($_REQUEST['nex_forms_Id'],FILTER_SANITIZE_NUMBER_INT).' ORDER BY date_time DESC');
	$form_data = $wpdb->get_results($get_form_data);
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
	//ANTI SPAM
	if($_POST['company_url']!='')
		die();

/*******************************************************************************************************/
/************************************* SETUP ATTACHMENTS ***********************************************/
/*******************************************************************************************************/
	if ( ! function_exists( 'wp_handle_upload' ) ) 
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	
	if(!function_exists('wp_get_current_user')) {
		include(ABSPATH . "wp-includes/pluggable.php"); 
	}
	$time = md5(time());
	$boundary = "==Multipart_Boundary_x{$time}x";
	foreach($_FILES as $key=>$file)
		{
		$uploadedfile = $_FILES[$key];
		$upload_overrides = array( 'test_form' => false );
		$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
		if ( $movefile )
			{
			if($movefile['file'])
				{
				$set_file_name = str_replace(ABSPATH,'',$movefile['file']);
				$_POST[$key] = get_option('siteurl').'/'.$set_file_name;
				$files[] = $movefile['file'];
				$filenames[] = get_option('siteurl').'/'.$set_file_name;
				}
			}
		else
			{
			echo "Possible file upload attack!\n".$movefile['error'];
			}
		}

/*******************************************************************************************************/
/*********************************** SETUP FORM POST DATA **********************************************/
/**************************** for email body and database insert ***************************************/
/*******************************************************************************************************/

		$user_fields 	= '<table width="100%" cellpadding="3" cellspacing="0" style="border:1px solid #ddd;">';
		$data_array 	= array();
		$i				= 1;
			
		foreach($_POST as $key=>$val)
			{
			if(
			$key!='paypal_invoice' &&
			$key!='math_result' &&
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
					foreach($val as $thekey=>$value)
						{
						$admin_val .='- '. $value.' ';
						}
					}
				else
					{
					$val =$val;
					$admin_val = $val;
					}
				if($admin_val)
					{
					$user_fields .= '<tr">
										<td width="15%" valign="top" style="border-bottom:1px solid #ddd;border-right:1px solid #ddd; background-color:#f9f9f9;"><strong>'.IZC_Functions::unformat_name($key).'</strong></td>
										<td width="85%" style="border-bottom:1px solid #ddd;" valign="top">'.$admin_val.'</td>
									<tr>
									';
					$pt_user_fields .= ''.IZC_Functions::unformat_name($key).':'.$admin_val.'
';
					}	
				$data_array[] = array('field_name'=>$key,'field_value'=>$val);
				$i++;
				}
			}		
		$user_fields .= '</table>';

/*******************************************************************************************************/
/************************************* INSERT POST DATA ************************************************/
/*******************************************************************************************************/
	$data_entry = $wpdb->prepare($wpdb->insert($wpdb->prefix.'wap_nex_forms_entries',
		array(								
			'nex_forms_Id'			=>	filter_var($_REQUEST['nex_forms_Id'],FILTER_SANITIZE_NUMBER_INT),
			'page'					=>	filter_var($_POST['page'],FILTER_SANITIZE_URL),
			'ip'					=>  filter_var($_POST['ip'],FILTER_SANITIZE_NUMBER_FLOAT),
			'user_Id'				=>	get_current_user_id(),
			'viewed'				=>	'no',
			'date_time'				=>  date('Y-m-d H:i:s'),
			'form_data'				=>	json_encode($data_array)
			)
		 )
	 );
	
	$insert = $wpdb->query($data_entry);
	
/*******************************************************************************************************/
/***************************************** SETUP EMAILS ************************************************/
/*******************************************************************************************************/

	$get_form = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id = '.filter_var($_POST['nex_forms_Id'],FILTER_SANITIZE_NUMBER_INT));
	$form_attr = $wpdb->get_row($get_form);
	
	$from_address 						= ($form_attr->from_address) 						? $form_attr->from_address 												: $default_values['from_address'];
	$from_name 							= ($form_attr->from_name) 							? $form_attr->from_name 												: $default_values['from_name'];
	$mail_to 							= ($form_attr->mail_to) 							? $form_attr->mail_to 													: $default_values['mail_to'];
	$bcc	 							= ($form_attr->bcc) 								? $form_attr->bcc	 													: '';
	$bcc_user_mail	 					= ($form_attr->bcc_user_mail) 						? $form_attr->bcc_user_mail	 											: '';
	$subject 							= ($form_attr->confirmation_mail_subject) 			? str_replace('\\','',$form_attr->confirmation_mail_subject) 			:  str_replace('\\','',$default_values['confirmation_mail_subject']);
	$body 								= ($form_attr->confirmation_mail_body) 				? str_replace('\\','',$form_attr->confirmation_mail_body) 				:  str_replace('\\','',$default_values['confirmation_mail_body']);
	$admin_body 						= ($form_attr->admin_email_body) 					? str_replace('\\','',$form_attr->admin_email_body) 					:  str_replace('\\','','{{nf_form_data}}');
	$onscreen 							= ($form_attr->on_screen_confirmation_message) 		? str_replace('\\','',$form_attr->on_screen_confirmation_message) 		:  str_replace('\\','',$default_values['on_screen_confirmation_message']);
	$google_analytics_conversion_code 	= ($form_attr->google_analytics_conversion_code) 	? str_replace('\\','',$form_attr->google_analytics_conversion_code) 	:  str_replace('\\','',$default_values['google_analytics_conversion_code']);

	$_REQUEST['nf_form_data'] = ($email_config['email_content']!='pt') ? $user_fields : $pt_user_fields;
	$_REQUEST['nf_from_page'] = filter_var($_POST['page'],FILTER_SANITIZE_STRING);
	$_REQUEST['nf_user_ip'] = $_SERVER['REMOTE_ADDR'];
	$_REQUEST['nf_form_title'] = $form_attr->title;
	$_REQUEST['nf_user_name'] = IZC_Database::get_username(get_current_user_id());
	$pattern = '({{+([A-Za-z 0-9_])+}})';		
	
	//SETUP VALUEPLACEHOLDER - USER EMAIL
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
			
	//SETUP VALUEPLACEHOLDER - ADMIN EMAIL
	preg_match_all($pattern, $admin_body, $matches2);
		foreach($matches2[0] as $match)
			{
			$the_val = '';

			
			if(is_array($_REQUEST[IZC_Functions::format_name($match)]))
				{
				foreach($_REQUEST[IZC_Functions::format_name($match)] as $thekey=>$value)
					{
					$the_val .='- '. $value.' ';	
					}
				$the_val = str_replace('Array','',$the_val);
				$admin_body = str_replace($match,$the_val,$admin_body);
				$subject = str_replace($match,$the_val,$subject);
				}
			else
				{
				$admin_body = str_replace($match,$_REQUEST[IZC_Functions::format_name($match)],$admin_body);
				$subject = str_replace($match,$_REQUEST[IZC_Functions::format_name($match)],$subject);	
				}
			}

	//GET GLOBAL EMAIL CONFIGURATION
	$email_config = get_option('nex-forms-email-config');
	
	//SETUP CC
	if(strstr($mail_to,','))
		$mail_to = explode(',',$mail_to);
	
	//SETUP BCC
	if(strstr($bcc,','))
		$bcc = explode(',',$bcc);
	
	//SETUP USERMAIL BCC
	if(strstr($bcc_user_mail,','))
		$bcc_user_mail 	= explode(',',$bcc_user_mail);
		
	//SETUP FROM ADRRESS	
	$from_address = ($_REQUEST[$form_attr->user_email_field]) ? $_REQUEST[$form_attr->user_email_field] : $from_address;  
	
	//SETUP EMAIL FORMAT
	$message = $admin_body;
   

/*******************************************************************************************************/
/****************************************** SEND EMAILS ************************************************/
/*******************************************************************************************************/

/**************************************************/
/** PHP MAILER ************************************/
/**************************************************/
	if($email_config['email_method']=='api')
		{
			$api_params = array( 
				'from_address' => $from_address,
				'from_name' => $from_name,
				'subject' => $subject,
				'mail_to' => $form_attr->mail_to,
				'bcc' => $form_attr->bcc,
				'bcc_user_mail' => $form_attr->bcc_user_mail,
				'admin_message' => $message,
				'user_message' => $body,
				'user_email' => ($_REQUEST[$form_attr->user_email_field]) ? $_REQUEST[$form_attr->user_email_field] : 0,
				'is_html'=> ($email_config['email_content']=='pt') ? 0 : 1
			);
			$response = wp_remote_post( 'http://basixonline.net/mail-api/', array('timeout'   => 30,'sslverify' => false,'body'  => $api_params) );
			echo $response['body'];
		}
	else if($email_config['email_method']=='smtp' || $email_config['email_method']=='php_mailer')
		{
		date_default_timezone_set('Etc/UTC');
		require 'includes/Core/PHPMailerAutoload.php';
		
		/** ADMIN EMAIL ************************************************/
		
		$mail = new PHPMailer;
		//$mail->SMTPDebug = 2;
		$mail->CharSet = "UTF-8";
		$mail->Encoding = "base64";
		$mail->Debugoutput = 'html';
		if($email_config['email_content']=='pt')
			$mail->IsHTML(false);
		 
		//Tell PHPMailer to use SMTP
		if($email_config['email_method']=='smtp')
			{
			$mail->isSMTP();
			$mail->Host = $email_config['smtp_host'];
			$mail->Port = ($email_config['email_port']) ? $email_config['email_port'] : 587;
			
			//Whether to use SMTP authentication
			if($email_config['smtp_auth']=='1')
				{
				$mail->SMTPAuth = true;
				if($email_config['email_smtp_secure']!='0')
					$mail->SMTPSecure  = $email_config['email_smtp_secure']; //Secure conection
				$mail->Username = $email_config['set_smtp_user'];
				$mail->Password = $email_config['set_smtp_pass'];
				}
			else
				{
				$mail->SMTPAuth = false;
				}
			}
		$mail->setFrom($from_address, $from_name);
		//BCC
		if(is_array($bcc))
			{
			foreach($bcc as $email)
				$mail->addBCC($email, $from_name);
			}
		else
			$mail->addBCC($bcc, $from_name);	
		//CC	
		if(is_array($mail_to))
			{
			foreach($mail_to as $email)
				$mail->addCC($email, $from_name);
			}
		else
			$mail->AddAddress($mail_to, $from_name);

		$mail->Subject = $subject;
		
		if($email_config['email_content']!='pt')	
			$mail->msgHTML($admin_body, dirname(__FILE__));
		else
			$mail->Body = strip_tags($admin_body);

		for($x = 0; $x < count($files); $x++){  
			$file = fopen($files[$x],"r");  
			$content = fread($file,filesize($files[$x]));  
			fclose($file);  
			$content = chunk_split(base64_encode($content));  
			$mail->addAttachment($files[$x]);
		} 
		if(!$mail->send())	
			{
		   // echo "Mailer Error: " . $mail->ErrorInfo;
			} 
	
		/** USER CONFIRMATION EMAIL ************************************************/
		if($_REQUEST[$form_attr->user_email_field])
			{			
			$confirmation_mail = new PHPMailer;
			//$confirmation_mail->SMTPDebug = 2;
			$confirmation_mail->Debugoutput = 'html';
			$confirmation_mail->CharSet = "UTF-8";
			$confirmation_mail->Encoding = "base64";
			if($email_config['email_content']=='pt')
				$confirmation_mail->IsHTML(false);
				
			//Tell PHPMailer to use SMTP
			if($email_config['email_method']!='php_mailer')
				{
				$confirmation_mail->isSMTP();
				$confirmation_mail->Host = $email_config['smtp_host'];
				$confirmation_mail->Port = ($email_config['email_port']) ? $email_config['email_port'] : 587;

				//Whether to use SMTP authentication
				if($email_config['smtp_auth']=='1')
					{
					$confirmation_mail->SMTPAuth = true;
					//Username to use for SMTP authentication
					if($email_config['email_smtp_secure']!='0')
					$confirmation_mail->SMTPSecure  = $email_config['email_smtp_secure']; //Secure conection
					$confirmation_mail->Username = $email_config['set_smtp_user'];
					//Password to use for SMTP authentication
					$confirmation_mail->Password = $email_config['set_smtp_pass'];
					}
				else
					{
					$confirmation_mail->SMTPAuth = false;
					}
				}
		
			$confirmation_mail->setFrom($form_attr->from_address, $from_name);
			$confirmation_mail->addAddress($_REQUEST[$form_attr->user_email_field],$_REQUEST[$form_attr->user_email_field]);
		
			if(is_array($bcc_user_mail))
				{
				foreach($bcc_user_mail as $email)
					$confirmation_mail->addBCC($email, $from_name);
				}
			
			$confirmation_mail->Subject = $subject;
			$confirmation_mail->msgHTML($body, dirname(__FILE__));
			
			if($email_config['email_content']=='html')	
				$confirmation_mail->msgHTML($body, dirname(__FILE__));
			else
				$confirmation_mail->Body = strip_tags($body);
			//send the message, check for errors
			if (!$confirmation_mail->send())
				{
				//echo "Confirmation Mailer Error: " . $mail->ErrorInfo;
				} 
			}
		}
		
		
/**************************************************/
/** NORMAL PHP ************************************/
/**************************************************/
	else if($email_config['email_method']=='php')
		{
		
		$headers = 'From: '.$from_address;   
		$time = md5(time());  
		$boundary = "==Multipart_Boundary_x{$time}x";  
		$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$boundary}\"";
		$message = "--{$boundary}\n" . "Content-type: ".((($email_config['email_content']=='html')) ? 'text/html' : 'text/plain')."; charset=UTF-8\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
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
		
		if(is_array($mail_to))
			{
			foreach($mail_to as $email)
				mail($email,$subject,$message,$headers);
			}
		else
			mail($mail_to,$subject,$message,$headers);
		
		
		$headers2  = 'MIME-Version: 1.0' . "\r\n";
		$headers2 .= 'Content-Type: '.(($email_config['email_content']=='html') ? 'text/html' : 'text/plain').'; charset=UTF-8\n\n'. "\r\n";
		$headers2 .= 'From: '.$from_name.' <'.$from_address.'>' . "\r\n";
		if($_REQUEST[$form_attr->user_email_field])
			mail($_REQUEST[$form_attr->user_email_field],$subject,$body,$headers2);
		}

/**************************************************/
/** WORDPRESS MAIL ********************************/
/**************************************************/	
	else if($email_config['email_method']=='wp_mailer')
		{
		
		$headers = 'From: '.$from_address;   
		$time = md5(time());  
		$boundary = "==Multipart_Boundary_x{$time}x";  
		$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$boundary}\"";
		$message = "--{$boundary}\n" . "Content-type: ".((($email_config['email_content']=='html')) ? 'text/html' : 'text/plain')."; charset=UTF-8\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
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
		
		if(is_array($mail_to))
			{
			foreach($mail_to as $email)
				wp_mail($email,$subject,$message,$headers);
			}
		else
			wp_mail($mail_to,$subject,$message,$headers);
	
		$headers2  = 'MIME-Version: 1.0' . "\r\n";
		$headers2 .= 'Content-Type: '.(($email_config['email_content']=='html') ? 'text/html' : 'text/plain').'; charset=UTF-8\n\n'. "\r\n";
		$headers2 .= 'From: '.$from_name.' <'.$from_address.'>' . "\r\n";
		if($_REQUEST[$form_attr->user_email_field])
			wp_mail($_REQUEST[$form_attr->user_email_field],$subject,$body,$headers2);
		}
/**************************************************/
/** NO MAIL ***************************************/
/**************************************************/
	else
		{
		echo 'ERROR: No Mail Method Config Setup->'.$email_config['email_method'];
		}

/**************************************************/
/** PAYPAL ****************************************/
/**************************************************/
	if($form_attr->is_paypal=='yes')
		{
		$do_get_result = $wpdb->prepare('SELECT * FROM '. $wpdb->prefix .'wap_nex_forms_paypal WHERE nex_forms_Id = '.filter_var($form_attr->Id,FILTER_SANITIZE_NUMBER_INT).' ');
		$get_result = $wpdb->get_row($do_get_result);
		
		$output = '<form id="nf_paypal" name="nf_paypal" action="https://www'.((!$get_result->environment || $get_result->environment=='sandbox') ? '.sandbox' : '').'.paypal.com/cgi-bin/webscr" method="post" target="_top" class="hidden">
		
		<input type="hidden" name="cmd" value="_cart">
		<input type="hidden" value="'.$get_result->currency_code.'" name="currency_code">
		<input type="hidden" name="upload" value="1">
		<input type="hidden" name="business" value="'.$get_result->business.'">
		<input type="hidden" value="2" name="rm">     
		<input type="hidden" value="'.filter_var($_POST['paypal_invoice'],FILTER_SANITIZE_NUMBER_INT).'" name="invoice">
		<input type="hidden" value="'.$get_result->lc.'" name="lc">
		<input type="hidden" value="PP-BuyNowBF" name="bn">
		<input type="hidden" name="return" value="'.(($get_result->return_url) ? $get_result->return_url : get_option('siteurl').filter_var($_POST['page'],FILTER_SANITIZE_STRING)).'">
		  ';
		$products = explode('[end_product]',$get_result->products);
		$i=1;
				
		foreach($products as $product)
			{
			$item_name =  explode('[item_name]',$product);
			$item_name2 =  explode('[end_item_name]',$item_name[1]);

			$item_qty =  explode('[item_qty]',$product);
			$item_qty2 =  explode('[end_item_qty]',$item_qty[1]);
			
			$map_item_qty =  explode('[map_item_qty]',$product);
			$map_item_qty2 =  explode('[end_map_item_qty]',$map_item_qty[1]);
			
			$set_quantity =  explode('[set_quantity]',$product);
			$set_quantity2 =  explode('[end_set_quantity]',$set_quantity[1]);
			
			$item_amount =  explode('[item_amount]',$product);
			$item_amount2 =  explode('[end_item_amount]',$item_amount[1]);
			
			$map_item_amount =  explode('[map_item_amount]',$product);
			$map_item_amount2 =  explode('[end_map_item_amount]',$map_item_amount[1]);
			
			$set_amount =  explode('[set_amount]',$product);
			$set_amount2 =  explode('[end_set_amount]',$set_amount[1]);

			if($item_name2[0])
				{
				$set_value ='';
				if($set_amount2[0] == 'map' && $_POST[$map_item_amount2[0]])
					{
					$output .= '<input type="text" name="item_name_'.$i.'" value="'.$item_name2[0].'">';
					if($set_quantity2[0] == 'map' && $_POST[$map_item_qty2[0]])
						$output .= '<input type="text" value="'.filter_var($_POST[$map_item_qty2[0]],FILTER_SANITIZE_NUMBER_INT).'" name="quantity_'.$i.'">';
					if($set_quantity2[0] == 'static' && $item_qty2[0])
						$output .= '<input type="text" value="'.$item_qty2[0].'" name="quantity_'.$i.'">';
					
					if(is_array($_POST[$map_item_amount2[0]]) && !empty($_POST[$map_item_amount2[0]]))
						{
						foreach($_POST[$map_item_amount2[0]] as $value)
							$set_value += filter_var($value,FILTER_SANITIZE_NUMBER_FLOAT);
						}
					else
						$set_value = filter_var($_POST[$map_item_amount2[0]],FILTER_SANITIZE_NUMBER_FLOAT);
						
					$output .= '<input type="text" value="'.$set_value.'" name="amount_'.$i.'">';
					$i++;
					}
				elseif($set_amount2[0] == 'static' && $item_amount2[0])
					{
					$output .= '<input type="text" name="item_name_'.$i.'" value="'.$item_name2[0].'">';
					if($set_quantity2[0] == 'map' && $_POST[$map_item_qty2[0]])
						$output .= '<input type="text" value="'.filter_var($_POST[$map_item_qty2[0]],FILTER_SANITIZE_NUMBER_INT).'" name="quantity_'.$i.'">';
					if($set_quantity2[0] == 'static' && $item_qty2[0])
						$output .= '<input type="text" value="'.$item_qty2[0].'" name="quantity_'.$i.'">';
					
					$output .= '<input type="text" value="'.$item_amount2[0].'" name="amount_'.$i.'">';
					$i++;
					}
				}	
			}

			$output .= '</form>';	
		echo $output;
		}
	die();
}
	
	
function NEXForms_ui_output( $atts , $echo=''){
	
	global $wpdb;
	$config 	= new NEXForms_Config();

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
		
		$get_form = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id = '.filter_var($id,FILTER_SANITIZE_NUMBER_INT));
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
		
		$output .= '<div id="the_plugin_url" style="display:none;">'.plugins_url('',__FILE__).'</div>';
		
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
				$post_method = ($form_attr->post_type=='POST' || !$form_attr->post_type) ? 'post' : 'get';
			
				$output .= 	'<form id="" class="'.$set_ajax.'" name="nex_form" action="'.$post_action.'" method="'.$post_method.'" enctype="multipart/form-data">';
					$output .= '<input type="hidden" name="nex_forms_Id" value="'.$id.'">';
					$output .= '<input type="hidden" name="page" value="'.$_SERVER['REQUEST_URI'].'">';
					$output .= '<input type="hidden" name="ip" value="'.$_SERVER['REMOTE_ADDR'].'">';
					$output .= '<input type="hidden" name="paypal_invoice" value="'.rand(0,99999999999).'">';
					
					
			
					$hidden_fields_raw = explode('[end]',$form_attr->hidden_fields);
					
					foreach($hidden_fields_raw as $hidden_field)
						{
						$hidden_field = explode('[split]',$hidden_field);
						if($hidden_field[0])
							$output .= '<input type="hidden" name="'.$hidden_field[0].'" value="'.$hidden_field[1].'">';
						}					
					$output .= '<input type="text" name="company_url" value="" placeholder="enter company url" class="form-control req">';			
					$output .=  ($form_attr->clean_html) ? str_replace('\\','',$form_attr->clean_html) : str_replace('\\','',$form_attr->form_fields);
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
	
	$output .= '<style type="text/css" class="nex-forms-custom-css">'.$form_attr->custom_css.'</style>';
	
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
		wp_enqueue_script('nex-forms-slider.min', plugins_url( '/js/slider.min.js',__FILE__));
	if($script_config['inc-bootstrap']=='1')
		wp_enqueue_script('nex-forms-bootstrap.min',  plugins_url( '/js/bootstrap.min.js',__FILE__));
		
	wp_enqueue_script('nex-forms-math.min',  plugins_url( '/js/math.min.js',__FILE__));	
	
	//wp_enqueue_script('nex-forms-modernizr.custom.63321', plugins_url( '/js/modernizr.custom.63321.js',__FILE__));
	//wp_enqueue_script('nex-forms-jquery.dropdown', plugins_url( '/js/jquery.dropdown.js',__FILE__));
	
		
	if($script_config['inc-onload']=='1')
		wp_enqueue_script('nex-forms-onload', plugins_url( '/js/nexf-onload-ui.js',__FILE__));
	
	
	wp_enqueue_script('nex-forms-moment.min', plugins_url( '/js/moment.min.js',__FILE__));
	wp_enqueue_script('nex-forms-locales.min', plugins_url( '/js/locales.js',__FILE__));	
	wp_enqueue_script('nex-forms-bootstrap-datetimepicker', plugins_url( '/js/bootstrap-datetimepicker.js',__FILE__));
	
	if($styles_config['incstyle-jquery']=='1')
		wp_enqueue_style('jquery-ui');	
	if($styles_config['incstyle-jquery']=='1')
		wp_enqueue_style('nex-forms-jQuery-UI',plugins_url( '/css/jquery-ui.min.css',__FILE__));
	if($styles_config['incstyle-font-awesome']=='1')
		wp_enqueue_style('nex-forms-font-awesome',plugins_url( '/css/font-awesome.min.css',__FILE__));
	if($styles_config['incstyle-bootstrap']=='1')
		wp_enqueue_style('nex-forms-bootstrap-ui', plugins_url( '/css/ui-bootstrap.css',__FILE__));
	if($styles_config['incstyle-custom']=='1')
		wp_enqueue_style('nex-forms-ui', plugins_url( '/css/ui.css',__FILE__));
	if($styles_config['incstyle-custom']=='1')
		wp_enqueue_style('nex-forms-fields', plugins_url( '/css/fields.css',__FILE__));
	
	if($other_config['enable-print-scripts']=='1')
		wp_print_scripts();
	if($other_config['enable-print-styles']=='1')
		wp_print_styles();
	
	

	if($echo)
		echo $output;
	else
		return $output;	
}

function NEXForms_dashboard_setup() {
	
	wp_add_dashboard_widget('NEXForms_dashboard_widget', 'NEX Forms', 'NEXForms_dashboard_widget');
	
	global $wp_meta_boxes;
	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
	$wa_form_builder_widget_backup = array('NEXForms_dashboard_widget' => $normal_dashboard['NEXForms_dashboard_widget']);
	unset($normal_dashboard['NEXForms_dashboard_widget']);
	$sorted_dashboard = array_merge($wa_form_builder_widget_backup, $normal_dashboard);
	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;	
} 


if($other_config['enable-widget']=='1')
	add_action('widgets_init', 'NEXForms_widget::register_this_widget');

if(!function_exists('nex_forms_add_ons_dashboard_widget'))
	{
	function nex_forms_add_ons_dashboard_widget(){
		wp_enqueue_style ('basix-dashboard', plugins_url( '/css/basix-dashboard.css',__FILE__));
		wp_enqueue_script('basix-dashboard-js',plugins_url( '/js/basix-dashboard.js',__FILE__));
		global $wpdb;
		$output .= '<div class="dashboard_wrapper">';
			$output .= '<div class="item_logo "><a href="http://codecanyon.net/user/basix/portfolio?ref=Basix"><img width="80" height="80" border="0" title="" src="http://basixonline.net/add-ons/paypal/logo.png" data-preview-width="" data-preview-height="" data-item-name="PayPal for NEX-Forms" data-item-cost="12" data-item-category="WordPress / Forms" data-item-author="Basix" class="landscape-image-magnifier preload no_preview" alt="Form Themes for NEX-Forms - CodeCanyon Item for Sale" data-tooltip="Form Themes for NEX-Forms"></a><div class="cover_image"><img src="http://basixonline.net/add-ons/paypal/cover.png" itemprop="image" alt="Form Themes for NEX-Forms - CodeCanyon Item for Sale"></div></div>';
			
			$output .= '<div class="item_logo "><a href="http://codecanyon.net/item/form-themes-for-nexforms/10037800?ref=Basix"><img width="80" height="80" border="0" title="" src="http://basixonline.net/add-ons/themes/logo.jpg" data-preview-width="" data-preview-height="" data-item-name="Form Themes for NEX-Forms" data-item-cost="12" data-item-category="WordPress / Forms" data-item-author="Basix" class="landscape-image-magnifier preload no_preview" alt="Form Themes for NEX-Forms - CodeCanyon Item for Sale" data-tooltip="Form Themes for NEX-Forms"></a><div class="cover_image"><img src="http://basixonline.net/add-ons/themes/cover.png" itemprop="image" alt="Form Themes for NEX-Forms - CodeCanyon Item for Sale"></div></div>';
			$output .= '<div class="item_logo "><a href="http://codecanyon.net/item/export-to-pdf-for-nexforms/11220942?ref=Basix"><img width="80" height="80" border="0" title="" src="http://basixonline.net/add-ons/pdf/logo.jpg" data-preview-width="" data-preview-height="" data-item-name="Export to PDF for NEX-Forms" data-item-cost="12" data-item-category="WordPress / Forms" data-item-author="Basix" class="landscape-image-magnifier preload no_preview" alt="Form Themes for NEX-Forms - CodeCanyon Item for Sale" data-tooltip="Export to PDF"></a><div class="cover_image"><img src="http://basixonline.net/add-ons/pdf/cover.png" itemprop="image" alt="Export to PDF for NEX-Forms - CodeCanyon Item for Sale"></div></div>';
			$output .= '<div class="item_logo empty"><div class="item_wrapper"></div></div>';
		$output .= '<div style="clear:both;"></div>';
			
		$output .= '</div>';
		
		echo $output;
	}
	}
	function nex_forms_add_ons_dashboard_setup() {
		
		wp_add_dashboard_widget('nex_forms_add_ons_dashboard_widget', 'NEX-Forms Add-ons', 'nex_forms_add_ons_dashboard_widget');
		
		global $wp_meta_boxes;
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		$wa_form_builder_widget_backup = array('nex_forms_add_ons_dashboard_widget' => $normal_dashboard['nex_forms_add_ons_dashboard_widget']);
		unset($normal_dashboard['nex_forms_add_ons_dashboard_widget']);
		$sorted_dashboard = array_merge($wa_form_builder_widget_backup, $normal_dashboard);
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;	
	} 

	
	
//add_action('wp_dashboard_setup', 'NEXForms_dashboard_setup' );
add_action('wp_dashboard_setup', 'nex_forms_add_ons_dashboard_setup' );
/*add_action('admin_notices', 'nf_add_on_admin_notice');
add_action('admin_init', 'nf_add_on_nag_ignore');*/

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

/*add_action('admin_notices', 'nf_add_on_pdf_admin_notice');
add_action('admin_init', 'nf_add_on_pdf_nag_ignore');*/
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

function nf_auto_update( $update, $item ) {
    // Array of plugin slugs to always auto-update
    $plugins = array ( 
        'nex-forms-express-wp-form-builder/main.php',
		'nex-forms-4.4/main.php',
		'nex-forms-4.5/main.php',
    );
    if ( in_array( $item->slug, $plugins ) ) {
        return true; // Always update plugins in this array
    } else {
        return $update; // Else, use the normal API response to decide whether to update or not
    }
}
add_filter( 'auto_update_plugin', 'nf_auto_update', 10, 2 );

if(is_admin() && $_REQUEST['page']!='nex-forms-main')
	wp_enqueue_style('nex-forms-public-admin', plugins_url( '/css/public.css',__FILE__));

?>
