<?php
/*
Plugin Name: NEX-Forms
Plugin URI: http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix
Plugin Prefix: wap_ 
Module Ready: Yes
Plugin TinyMCE: popup
Description: (EXPRESS VERSION) The Ultimate Drag and Drop WordPress forms builder
Author: Basix
Version: 4.0
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
			'custom_css'						=>  'longtext'
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
					'icon_url' 		=> plugins_url('/images/menu_icon.png',__FILE__),
					'position '		=> ''
					),
					'sub_menu_page'		=>	array
							(
							
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

	
	
	$get_form = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id = '.$_POST['nex_forms_Id']);
	$form_attr = $wpdb->get_row($get_form);
	
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
			if ( $movefile ) {
				//echo "File is valid, and was successfully uploaded.\n";
					if($movefile['file'])
						{
						$set_file_name = str_replace(ABSPATH,'',$movefile['file']);
						$_POST[$key] = get_option('siteurl').'/'.$set_file_name;
						$files[] = $movefile['file'];
						$filenames[] = get_option('siteurl').'/'.$set_file_name;
						}
			} else {
				//echo "Possible file upload attack!\n";
				//$_POST[$key] = 'Error on uplaod: '.$movefile['error'];
			}
		}


$user_fields = '
<table width="100%" cellpadding="3" cellspacing="0" style="border:1px solid #ddd;">
<tr>
	<td width="15%" colspan="2" valign="top" style="border:1px solid #ddd;border-bottom:none; background-color:#ffff;"><h3><a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix">To view form data in your emails you need to GO PRO</a></h3></td>
<tr>
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
				$user_fields .= '<tr>
									<td width="15%" valign="top" style="border-bottom:1px solid #ddd;border-right:1px solid #ddd; background-color:#f9f9f9;"><strong>'.IZC_Functions::unformat_name($key).'</strong></td>
									<td width="85%" style="border-bottom:1px solid #ddd;" valign="top">&#42;*&#42;*&#42;*&#42;*&#42;*&#42;*</td>
								<tr>
								';
				$pt_user_fields .= ''.IZC_Functions::unformat_name($key).':&#42;*&#42;*&#42;*&#42;*&#42;*&#42;*
';
				
		
		
				
			
			$data_array[] = array('field_name'=>$key,'field_value'=>$val);
			$i++;
			}
		}
	
	
		
		$user_fields .= '
  
</table>';



	
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
	
	$from_address 							= ($form_attr->from_address) 						? $form_attr->from_address 												: $default_values['from_address'];
	$from_name 								= ($form_attr->from_name) 							? $form_attr->from_name 												: $default_values['from_name'];
	$mail_to 								= ($form_attr->mail_to) 							? $form_attr->mail_to 													: $default_values['mail_to'];
	$subject 								= ($form_attr->confirmation_mail_subject) 			? str_replace('\\','',$form_attr->confirmation_mail_subject) 			:  str_replace('\\','',$default_values['confirmation_mail_subject']);
	$body 									= ($form_attr->confirmation_mail_body) 				? str_replace('\\','',$form_attr->confirmation_mail_body) 				:  str_replace('\\','',$default_values['confirmation_mail_body']);
	$admin_body 							= ($form_attr->admin_email_body) 					? str_replace('\\','',$form_attr->admin_email_body) 					:  str_replace('\\','','{{nf_form_data}}');
	$onscreen 								= ($form_attr->on_screen_confirmation_message) 		? str_replace('\\','',$form_attr->on_screen_confirmation_message) 		:  str_replace('\\','',$default_values['on_screen_confirmation_message']);
	$google_analytics_conversion_code 		= ($form_attr->google_analytics_conversion_code) 	? str_replace('\\','',$form_attr->google_analytics_conversion_code) 	:  str_replace('\\','',$default_values['google_analytics_conversion_code']);

	$body = str_replace('{{nf_form_data}}',$user_fields,$body);
	$admin_body = str_replace('{{nf_form_data}}',$user_fields,$admin_body);
	

$from = ($_REQUEST[$form_attr->user_email_field]) ? $_REQUEST[$form_attr->user_email_field] : $from_address;  
$subject = $subject;  
if($email_config['email_content']=='html')
	$message = $admin_body;  
else
	$message = $pt_user_fields;   
  
// include the from email in the headers  
$headers = "From: $from";  
  
// boundary  
$time = md5(time());  
$boundary = "==Multipart_Boundary_x{$time}x";  
  
// headers used for send attachment with email  
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$boundary}\"";  
  
// multipart boundary  
if($email_config['email_content']=='html')
	$message = "--{$boundary}\n" . "Content-type: text/html; charset=UTF-8\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
else
	$message = "--{$boundary}\n" . "Content-type: text/plain; charset=UTF-8\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
	
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
$bcc = explode(',',$form_attr->bcc);
$bcc_user_mail = explode(',',$form_attr->bcc_user_mail);

if($email_config['email_method']=='smtp' || $email_config['email_method']=='php_mailer')
	{
	
	date_default_timezone_set('Etc/UTC');
	require 'includes/Core/PHPMailerAutoload.php';
	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	
	
	$mail->CharSet = "UTF-8";
	$mail->Encoding = "base64";
	
	if($email_config['email_content']=='pt')
		$mail->IsHTML(false);
	 
	//Tell PHPMailer to use SMTP
	if($email_config['email_method']!='php_mailer')
		{
		
		$mail->isSMTP();
		//$mail->SMTPDebug = 2;
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = $email_config['smtp_host'];
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = ($email_config['email_port']) ? $email_config['email_port'] : 25;
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
	
	foreach($bcc as $email)
		$mail->addBCC($email, $from_name);
		
	foreach($mail_to as $email)
		$mail->addCC($email, $from_name);
	//Set the subject line
	$mail->Subject = $subject;
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	if($email_config['email_content']=='html')	
		$mail->msgHTML($admin_body, dirname(__FILE__));
	else
		$mail->Body = $pt_user_fields;
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

	
	if($_REQUEST[$form_attr->user_email_field])
		{
		$confirmation_mail = new PHPMailer;
		
		$confirmation_mail->CharSet = "UTF-8";
		$confirmation_mail->Encoding = "base64";
		//Tell PHPMailer to use SMTP
		if($email_config['email_method']!='php_mailer')
			{
			$confirmation_mail->isSMTP();
			//$confirmation_mail->SMTPDebug = 2;
			$confirmation_mail->Debugoutput = 'html';
			//Set the hostname of the mail server
			$confirmation_mail->Host = $email_config['smtp_host'];
			//Set the SMTP port number - likely to be 25, 465 or 587
			$confirmation_mail->Port = ($email_config['email_port']) ? $email_config['email_port'] : 25;
		
		
		//Whether to use SMTP authentication
		if($email_config['smtp_auth']=='1')
			{
			$confirmation_mail->SMTPAuth = true;
			//Username to use for SMTP authentication
			$confirmation_mail->Username = $email_config['set_smtp_user'];
			//Password to use for SMTP authentication
			$confirmation_mail->Password = $email_config['set_smtp_pass'];
			}
		else
			{
			$confirmation_mail->SMTPAuth = false;
			}
		}
	//}
	//Set who the message is to be sent from
	$confirmation_mail->setFrom($from_address, $from_name);
		//$confirmation_mail->addReplyTo($from_address, $from_name);
		//Set who the message is to be sent to
		$confirmation_mail->addAddress($_REQUEST[$form_attr->user_email_field],$_REQUEST[$form_attr->user_email_field]);
	
		foreach($bcc_user_mail as $email)
			$confirmation_mail->addBCC($email, $from_name);
		//Set the subject line
		$confirmation_mail->Subject = $subject;
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$confirmation_mail->msgHTML($body, dirname(__FILE__));
		//send the message, check for errors
			if (!$confirmation_mail->send()) {
			   // echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
			   // echo "Message sent!";
			}	
		}

	}
if($email_config['email_method']=='php')
	{
	foreach($mail_to as $email)
		mail($email,$subject,$message,$headers);
	
	
	$headers2  = 'MIME-Version: 1.0' . "\r\n";
	$headers2 .= 'Content-Type: text/html; charset=UTF-8\n\n'. "\r\n";
	$headers2 .= 'From: '.$from_name.' <'.$from_address.'>' . "\r\n";
	if($_REQUEST[$form_attr->user_email_field])
		mail($_REQUEST[$form_attr->user_email_field],$subject,$body,$headers2);
	}
if($email_config['email_method']=='wp_mailer')
	{
	foreach($mail_to as $email)
		wp_mail($email,$subject,$message,$headers);

	$headers2  = 'MIME-Version: 1.0' . "\r\n";
	$headers2 .= 'Content-Type: text/html; charset=UTF-8\n\n'. "\r\n";
	$headers2 .= 'From: '.$from_name.' <'.$from_address.'>' . "\r\n";
	if($_REQUEST[$form_attr->user_email_field])
		wp_mail($_REQUEST[$form_attr->user_email_field],$subject,$body,$headers2);
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
		
		$output .= '<div id="the_plugin_url" style="display:none;">'.plugins_url('',dirname(__FILE__)).'</div>';
		
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
	
	wp_enqueue_script('nex-forms-modernizr.custom.63321', plugins_url( '/js/modernizr.custom.63321.js',__FILE__));
	wp_enqueue_script('nex-forms-jquery.dropdown', plugins_url( '/js/jquery.dropdown.js',__FILE__));
	
		
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


if(is_admin() && $_REQUEST['page']!='nex-forms-main')
	wp_enqueue_style('nex-forms-public-admin', plugins_url( '/css/public.css',__FILE__));

?>
