<?php
require( (dirname(dirname(dirname(dirname( __FILE__ ))))) . '/wp-load.php' );
global $wpdb;
//ANTI SPAM
if($_POST['company_url']!='')
	die();
	
/*echo '<pre>';
print_r($_REQUEST);
echo '</pre>';*/

	$form_attr = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id = '.$_REQUEST['nex_forms_Id']);
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
						$filenames[] = $file['name'];
						}
			} else {
				//echo "Possible file upload attack!\n";
				//$_POST[$key] = 'Error on uplaod: '.$movefile['error'];
			}
		}



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
		$key!='nex_forms_Id' &&
		$key!='company_url' &&
		$key!='submit'
		)
			{
			if(is_array($val))
				{
				foreach($val as $thekey=>$value)
					{
					$val .='<span class="fa fa-check"></span> '. $value.' ';
					$admin_val .='- '. $value.' ';
						
					}
				$val = str_replace('Array','',$val);
				}
			else
				{
				$val =$val;
				$admin_val = $val;
				}
				$user_fields .= ''.IZC_Functions::unformat_name($key).' : ';
				$user_fields .= ''.$admin_val.'
';
				
			$insert = $wpdb->insert($wpdb->prefix.'wap_nex_forms_meta',
					array(
						'nex_forms_Id'=>$_REQUEST['nex_forms_Id'],
						'meta_key'=>$key,
						'meta_value'=>$val,
						'time_added' => mktime()
						)
				 );
			}
		}
	
	$from_address 							= ($form_attr->from_address) 						? $form_attr->from_address 												: $default_values['from_address'];
	$from_name 								= ($form_attr->from_name) 							? $form_attr->from_name 												: $default_values['from_name'];
	$mail_to 								= ($form_attr->mail_to) 							? $form_attr->mail_to 													: $default_values['mail_to'];
	$subject 								= ($form_attr->confirmation_mail_subject) 			? str_replace('\\','',$form_attr->confirmation_mail_subject) 			:  str_replace('\\','',$default_values['confirmation_mail_subject']);
	$body 									= ($form_attr->confirmation_mail_body) 				? str_replace('\\','',$form_attr->confirmation_mail_body) 				:  str_replace('\\','',$default_values['confirmation_mail_body']);
	$onscreen 								= ($form_attr->on_screen_confirmation_message) 		? str_replace('\\','',$form_attr->on_screen_confirmation_message) 		:  str_replace('\\','',$default_values['on_screen_confirmation_message']);
	$google_analytics_conversion_code 		= ($form_attr->google_analytics_conversion_code) 	? str_replace('\\','',$form_attr->google_analytics_conversion_code) 	:  str_replace('\\','',$default_values['google_analytics_conversion_code']);


	$pattern = '({{+([A-Za-z _])+}})';
			
	preg_match_all($pattern, $body, $matches);
	//print_r($matches);
		foreach($matches[0] as $match){
			$the_val = '';
			
			if(is_array($_REQUEST[IZC_Functions::format_name($match)]))
				{
				foreach($_REQUEST[IZC_Functions::format_name($match)] as $thekey=>$value)
					{
					$the_val .='<span class="fa fa-check"></span> '. $value.' ';	
					}
				$the_val = str_replace('Array','',$the_val);
				$body = str_replace($match,$the_val,$body);
				}
			else
				{
				$body = str_replace($match,$_REQUEST[IZC_Functions::format_name($match)],$body);	
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
$message = "--{$boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";  
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
		
$mail_to = explode(',',$mail_to);

foreach($mail_to as $email)
	mail($email,'New Form Entry ('.$subject.')',$message,$headers);


$headers2  = 'MIME-Version: 1.0' . "\r\n";
$headers2 .= 'Content-Type: text/html; charset=utf-8\n\n'. "\r\n";
$headers2 .= 'From: '.$from_name.' <'.$from_address.'>' . "\r\n";
mail($_REQUEST[$form_attr->user_email_field],$subject,nl2br($body),$headers2);

?>