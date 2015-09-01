<?php
//This is a action for an AJAX function to get table records
add_action('wp_ajax_populate',array('IZC_Database','build_admin_table'));
//This is a action for an AJAX function to delete table records
add_action('wp_ajax_delete_record',array('IZC_Database','delete_record'));

//DB actions
add_action('wp_ajax_do_insert', array('IZC_Database','do_insert'));
add_action('wp_ajax_do_edit', array('IZC_Database','update'));
add_action('wp_ajax_duplicate_record', array('IZC_Database','duplicate_record'));

add_action('wp_ajax_insert_nex_form', array('IZC_Database','insert_nex_form'));
add_action('wp_ajax_edit_form', array('IZC_Database','update_form'));
add_action('wp_ajax_update_paypal', array('IZC_Database','update_paypal'));


add_action('wp_ajax_load_nex_form', array('IZC_Database','load_nex_form'));
add_action('wp_ajax_load_nex_form_attr', array('IZC_Database','load_nex_form_attr'));
add_action('wp_ajax_get_data', array('IZC_Database','NEXForms_get_data'));

add_action('wp_ajax_load_nex_form_hidden_fields', array('IZC_Database','load_nex_form_hidden_fields'));

add_action('wp_ajax_populate_dropdown',array('IZC_Database','populate_dropdown_list'));

add_action('wp_ajax_populate_form_entry',array('IZC_Database','populate_form_entry'));

add_action('wp_ajax_populate_paypal_data',array('IZC_Database','populate_paypal_data'));

add_action('wp_ajax_nf_send_test_email',array('IZC_Database','nf_send_test_email'));

if(!class_exists('IZC_Database'))
	{
	class IZC_Database{
		
		public $plugin_table;
		public $plugin_alias;
		public $module_table;
		public $foreign_key;
		public $link_modules;
		
		function __construct(){
			if(@$_POST['action']=='batch-delete'   || @$_POST['action2']=='batch-delete')  	{ $this -> batch_delete_records(@$_POST['checked'],@$_POST['table']); }
			}
		
		
		/***************************************/
		/***********   Admin Table   ***********/
		/***************************************/
		public function build_admin_table(){
	
			global $wpdb;
			
			$args 		= str_replace('\\','',$_POST['args']);
			$headings 	= json_decode($args);
			$get_tree 	= $wpdb->prepare('SHOW FIELDS FROM '. $wpdb->prefix .filter_var($_POST['table'],FILTER_SANITIZE_STRING).' LIKE "parent_Id"');
			$tree 		= $wpdb->query($get_tree);
			
			$additional_params = json_decode(str_replace('\\','',$_POST['additional_params']),true);
			
			if(is_array($additional_params))
				{
				foreach($additional_params as $column=>$val)
					$where_str .= ' AND '.$column.'="'.$val.'"';
				}
			
			if($_POST['nex_forms_id'])
				$where_str .= ' AND nex_forms_Id='.filter_var($_POST['nex_forms_id'],FILTER_SANITIZE_NUMBER_INT);
			
			
			$sql = $wpdb->prepare('SELECT * FROM '. $wpdb->prefix . filter_var($_POST['table'],FILTER_SANITIZE_STRING).' WHERE Id <> "" 
											'.(($tree) ? ' AND parent_Id="0"' : '').' 
											'.(($_POST['plugin_alias']) ? ' AND (plugin="'.filter_var($_POST['plugin_alias'],FILTER_SANITIZE_STRING).'" || plugin="shared")' : '').' 
											'.$where_str.'   
											ORDER BY 
											'.((isset($_POST['orderby']) && !empty($_POST['orderby'])) ? filter_var($_POST['orderby'],FILTER_SANITIZE_STRING).' 
											'.filter_var($_POST['order'],FILTER_SANITIZE_STRING) : 'Id DESC').' 
											LIMIT '.((isset($_POST['current_page'])) ? filter_var($_POST['current_page'],FILTER_SANITIZE_NUMBER_INT)*10 : '0'  ).',10 ');
			$results 	= $wpdb->get_results($sql);
			
			$output .= '<div class="modal fade" id="viewFormEntry" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:10001 !important;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-info">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Form Entry</h4>
							  </div>
							  <div class="modal-body">
								
							  </div>
							  <div class="modal-footer ">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div>
							</div>
						  </div>
						</div>';
						
			$output .= '<div class="modal fade" id="getPdfAddon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:10001 !important;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-success">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Get Export to PDF add-on</h4>
							  </div>
							  <div class="modal-body">
									If you have a need to export your form entries to profesional looking PDF\'s then you need this add-on.<br />
<br />
<a class="btn btn-success" href="http://codecanyon.net/user/Basix/portfolio?ref=Basix" target="_blank">Get Export to PDF for NEX-Forms</a>
							  </div>
							  
							</div>
						  </div>
						</div>';
			
			
			if($results)
				{			
				foreach($results as $data)
					{	
					$output .= '<tr class="row parent " onClick="showHide(this,\'level-'.$data->Id.'\',1,10,'.$data->Id.');" id="tag-'.$data->Id.'">';
					$output .= '<th class="check-column" scope="row"><input type="checkbox" value="'.$data->Id.'" name="checked[]"></th>';
					
					$k=1;
					foreach($headings as $heading)	
						{
						
						if(is_object($heading))
							{
							$grouplabel = IZC_Functions::format_name($heading->grouplabel);
							$range_type = $heading->type;
							$heading = 'range';
							}
	
						$heading = IZC_Functions::format_name($heading);
						$heading = str_replace('_id','_Id',$heading);
						
						if($heading=='range')
							{
							$range_from = $grouplabel.'_rangefrom';
							$range_to 	= $grouplabel.'_rangeto';
							$val 		= '<strong>from</strong> '.(($data->$range_from) ? IZC_Functions::format_date($data->$range_from) : 'Undefined').' <strong>to</strong> '.(($data->$range_to) ? IZC_Functions::format_date($data->$range_to) : 'Undefined');
							}
						elseif($heading=='user_Id')
							{
							$val = IZC_Database::get_username($data->$heading);	
							}
						elseif($heading=='form_data')
							{
							$val = '<div class="btn btn-default view_form_entry" data-target="#viewFormEntry" data-toggle="modal"  data-id="'.$data->Id.'">View</div>';	
							}
						elseif($heading=='paypal_data')
							{
							$val = '<div class="btn btn-default view_paypal_data" data-target="#viewFormEntry" data-toggle="modal"  data-id="'.$data->Id.'">View</div>';	
							}
						else
							{
							$val = (strstr($heading,'Id')) ? IZC_Database::get_title($data->$heading,'wap_'.str_replace('_Id','',$heading)) : $data->$heading;
							
							
							$val = str_replace('\\', '', IZC_Functions::view_excerpt($val,25));
							}
						
						
						
						//Check if value is a file upload contain traces of allowed images
						if(strstr($data->$heading,'__') && is_numeric(substr($data->$heading,0,9)))
							{
							$get_extension = explode('.',$data->$heading);
							$val = '<img src="'.WP_PLUGIN_URL.'/includes/Core/images/icons/ext/'.$get_extension[count($get_extension)-1].'.png">';
							$image_extensions = array('jpg','jpeg','gif','png','bmp');
							foreach($image_extensions as $image_extension)
								{
								if(stristr($data->$heading,$image_extension))
									{
									$val = '<img src="'.get_option('siteurl').'/wp-content/uploads/wa-core/thumbs/'.$data->$heading.'">';
									}
								}
							}
						
						$output .= '<td class="manage-column column-'.$heading.'">'.(($k==1) ? '<strong>'.$val.'</strong>' : $val).'';
						$output .= (($k==1) ? '<div class="row-actions"></span><span class="delete"><a href="javascript:delete_record(\''.$data->Id.'\',\''.filter_var($_POST['table'],FILTER_SANITIZE_STRING).'\');" >Delete</a></span></div>' : '' ).'</td>';
						$k++;
						//<span class="edit"><a href="?page='.$_POST['page'].'&Id='.$data->Id.'&table='.$_POST['table'].'" class="edit-tag">Edit</a> | 
						}
					if ( is_plugin_active( 'nex-forms-export-to-pdf/main.php' ) )
						$output .= '<td class="expand" scope="row"><a target="_blank" title="PDF [new window]" href="'.WP_PLUGIN_URL . '/nex-forms-export-to-pdf/examples/main.php?entry_ID='.$data->Id.'" class="btn btn-default"><span class="fa fa-file-pdf-o"></span> PDF</div></a></td>';
					else
						$output .= '<td class="expand" scope="row"><a target="_blank" title="Get export to PDF add-on" href="http://codecanyon.net/item/export-to-pdf-for-nexforms/11220942?ref=Basix" class="btn btn-success buy">Buy</a></td>';
					$output .= '</tr>';	
					
					if($tree)
						$output .= IZC_Database::build_descendants_list($data->Id, $headings, filter_var($_POST['table'],FILTER_SANITIZE_STRING));
					}
				}
			else
				{
				$output .= '<tr>';	
				$output .= '<td></td><td class="manage-column" colspan="'.(count($headings)).'">No items found</td>';
				$output .= '</tr>';
				}
				
			echo $output;
			die();
		}
		
		
		public function nf_send_test_email(){
			
			
			$email_config = get_option('nex-forms-email-config');
			
			$from_address 	= filter_var($_POST['email_address'],FILTER_SANITIZE_EMAIL);
			$from_name 		= 'You';
			$subject 		= 'NEX-Forms Test Mail';
			$plain_body		= 'This is a test message in PLAIN TEXT. If you received this your email settings are working correctly :)
			
You are using '.$email_config['email_method'].' as your emailing method';
			$html_body		= 'This is a test message in <strong>HTML</strong>. If you received this your email settings are working correctly :)<br /><br />You are using <strong>'.$email_config['email_method'].'</strong> as your emailing method';
			
			if($email_config['email_method']=='api')
				{
					$api_params = array( 
						'from_address' => $from_address,
						'from_name' => $from_name,
						'subject' => $subject,
						'mail_to' => $from_address,
						'admin_message' => ($email_config['email_content']=='pt') ? $plain_body : $html_body,
						'user_email' => 0,
						'is_html'=> ($email_config['email_content']=='pt') ? 0 : 1
					);
					$response = wp_remote_post( 'http://basixonline.net/mail-api/', array('timeout'   => 30,'sslverify' => false,'body'  => $api_params) );
					//echo $response['body'];
				}
			
			else if($email_config['email_method']=='smtp' || $email_config['email_method']=='php_mailer')
				{
				date_default_timezone_set('Etc/UTC');
				require 'PHPMailerAutoload.php';
				//Create a new PHPMailer instance
				$mail = new PHPMailer;
			
				$mail->CharSet = "UTF-8";
				
				if($email_config['email_content']=='pt')
					$mail->IsHTML(false);
				 
				//Tell PHPMailer to use SMTP
				if($email_config['email_method']=='smtp')
					{
					$mail->isSMTP();
					
					if($email_config['email_smtp_secure']!='0')
						$mail->SMTPSecure  = $email_config['email_smtp_secure']; //Secure conection
					
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
					
					
					
					
					//encoding
					
					//Whether to use SMTP authentication
					
					}
				//}
				//Set who the message is to be sent from
				//Set an alternative reply-to address
			//Set the hostname of the mail server
					$mail->Host = $email_config['smtp_host'];
					//Set the SMTP port number - likely to be 25, 465 or 587
					$mail->Port = ($email_config['email_port']) ? $email_config['email_port'] : 587;
					
				$mail->setFrom($from_address, $from_name);
				$mail->addCC($from_address, $from_name);
				//Set the subject line
				$mail->Subject = $subject;
				//Read an HTML message body from an external file, convert referenced images to embedded,
				//convert HTML into a basic plain-text alternative body
				if($email_config['email_content']=='html')	
					$mail->msgHTML($html_body);
				else
					$mail->Body = $plain_body;
				if (!$mail->send()) {
				    echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
				   echo "Message sent!";
					//echo print_r($mail);
				}
			}
		
/**************************************************/
/** NORMAL PHP ************************************/
/**************************************************/
	else if($email_config['email_method']=='php')
		{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-Type: '.(($email_config['email_content']=='html') ? 'text/html' : 'text/plain').'; charset=UTF-8\n\n'. "\r\n";
		$headers .= 'From: '.$from_name.' <'.$from_address.'>' . "\r\n";
		
		if($email_config['email_content']=='html')	
			$set_body = $html_body;
		else
			$set_body = $plain_body;
		
		mail(filter_var($_POST['email_address'],FILTER_SANITIZE_EMAIL),$subject,$set_body,$headers);
		}

/**************************************************/
/** WORDPRESS MAIL ********************************/
/**************************************************/	
	else if($email_config['email_method']=='wp_mailer')
		{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-Type: '.(($email_config['email_content']=='html') ? 'text/html' : 'text/plain').'; charset=UTF-8\n\n'. "\r\n";
		$headers .= 'From: '.$from_name.' <'.$from_address.'>' . "\r\n";
		
		if($email_config['email_content']=='html')	
			$set_body = $html_body;
		else
			$set_body = $plain_body;
		
		wp_mail(filter_var($_POST['email_address'],FILTER_SANITIZE_EMAIL),$subject,$set_body,$headers);				
		}
					
	die();
	}
		
		
		public function load_nex_form(){
			global $wpdb;
			$get_form = $wpdb->prepare('SELECT form_fields FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id='.filter_var($_POST['form_Id'],FILTER_SANITIZE_NUMBER_INT));
			$form = $wpdb->get_row($get_form);
			echo str_replace('\\','',$form->form_fields);
			die();	
		}
		
		public function populate_form_entry(){
			global $wpdb;
			$get_form_entry = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_entries WHERE Id='.filter_var($_POST['form_entry_Id'],FILTER_SANITIZE_NUMBER_INT));
			$form_entry = $wpdb->get_row($get_form_entry);
			//echo str_replace('\\','',$form->form_fields);
			
			//echo 'test'.$_POST['form_entry_Id'];
			  $form_data = json_decode($form_entry->form_data);
			 /* echo '<pre>';
			  print_r($form_data);
			 echo '</pre>';*/
			 
			 foreach($form_data as $data)
					{
					if($data->field_name!='math_result'){
						echo '<div class="row">';
							echo '<div class="col-sm-4"><strong>';
								echo IZC_Functions::unformat_name($data->field_name);
							echo '</strong></div>';
							echo '<div class="col-sm-1">:</div>';
							echo '<div class="col-sm-7">';
								if(is_array($data->field_value))
									{
									 foreach($data->field_value as $key=>$val)
										{
										echo '<span class="text-success fa fa-check"></span>&nbsp;&nbsp;'.$val.'<br />';
										}
									}
								else
									{
									echo $data->field_value;
									}
							echo '</div>';
							
						echo '</div>';
						echo '<div style="clear:both"></div>';
						}
					}
			
			die();	
		}
		
		public function populate_paypal_data(){
			global $wpdb;

			$get_form_entry = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_entries WHERE Id='.filter_var($_POST['form_entry_Id'],FILTER_SANITIZE_NUMBER_INT));
			$form_entry = $wpdb->get_row($get_form_entry);
			//echo str_replace('\\','',$form->form_fields);
			
			//echo 'test'.$_POST['form_entry_Id'];
			  $form_data = json_decode($form_entry->paypal_data);
			 /* echo '<pre>';
			  print_r($form_data);
			 echo '</pre>';*/
			 
			 foreach($form_data as $data)
					{
					if($data->field_name!='math_result'){
						echo '<div class="row">';
							echo '<div class="col-sm-4"><strong>';
								echo IZC_Functions::unformat_name($data->field_name);
							echo '</strong></div>';
							echo '<div class="col-sm-1">:</div>';
							echo '<div class="col-sm-7">';
								if(is_array($data->field_value))
									{
									 foreach($data->field_value as $key=>$val)
										{
										echo '<span class="text-success fa fa-check"></span>&nbsp;&nbsp;'.$val.'<br />';
										}
									}
								else
									{
									echo $data->field_value;
									}
							echo '</div>';
							
						echo '</div>';
						echo '<div style="clear:both"></div>';
						}
					}
			
			die();	
		}
		
		
		
		public function load_nex_form_attr(){
			global $wpdb;
			
			$default_custom_css = '
/* Container (effect front-end only) */
#nex-forms #ui-nex-forms-container{
	
}
/* Form Element (effect front-end/preview only) */
#nex-forms form {
	
}
/* Form Field Container */
#nex-forms .form_field{
	
}
/* Form Field Label Container */
#nex-forms .form_field .label_container{
	
}
/* Form Field Label Element */
#nex-forms .form_field .label_container label{
	
}
/* Form Field Main Label */
#nex-forms .form_field .label_container label span.the_label{
	
}
/* Form Field Main Label */
#nex-forms .form_field .label_container label span.sub-text{
	
}											
/* 
Form Field Input Container 
Find input select etc inside here
*/
#nex-forms .form_field .input_container{
	
}
/* Form Field Help Block */
#nex-forms .form_field .help-block{
	
}
/**************************/
/* Add more custom styles */
/**************************/';
			
			$get_form = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id='.filter_var($_POST['form_Id'],FILTER_SANITIZE_NUMBER_INT));
			$form = $wpdb->get_row($get_form);
			
			$output .= '<div class="mail_to">'.$form->mail_to.'</div>';
			$output .= '<div class="confirmation_mail_body">'.str_replace('\\','',$form->confirmation_mail_body).'</div>';
			$output .= '<div class="admin_email_body">'.str_replace('\\','',$form->admin_email_body).'</div>';
			$output .= '<div class="confirmation_mail_subject">'.str_replace('\\','',$form->confirmation_mail_subject).'</div>';
			$output .= '<div class="from_address">'.$form->from_address.'</div>';
			$output .= '<div class="from_name">'.$form->from_name.'</div>';
			$output .= '<div class="on_screen_confirmation_message">'.str_replace('\\','',$form->on_screen_confirmation_message).'</div>';
			$output .= '<div class="confirmation_page">'.$form->confirmation_page.'</div>';
			$output .= '<div class="google_analytics_conversion_code">'.str_replace('\\','',$form->google_analytics_conversion_code).'</div>';
			$output .= '<div class="send_user_mail">'.$form->send_user_mail.'</div>';
			$output .= '<div class="user_email_field">'.$form->user_email_field.'</div>';
			$output .= '<div class="on_form_submission">'.$form->on_form_submission.'</div>';
			$output .= '<div class="post_action">'.$form->post_action.'</div>';
			$output .= '<div class="post_type">'.$form->post_type.'</div>';
			$output .= '<div class="custom_url">'.$form->custom_url.'</div>';
			$output .= '<div class="bcc">'.$form->bcc.'</div>';
			$output .= '<div class="bcc_user_mail">'.$form->bcc_user_mail.'</div>';
			$output .= '<div class="set_custom_css">'.(($form->custom_css) ? str_replace('\\','',$form->custom_css) : $default_custom_css).'</div>';
			$output .= '<div class="is_paypal">'.$form->is_paypal.'</div>';
			
			$get_paypal = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_paypal WHERE nex_forms_Id='.filter_var($_POST['form_Id'],FILTER_SANITIZE_NUMBER_INT));
			$paypal = $wpdb->get_row($get_paypal);
			
			$output .= '<div class="paypal-lc">'.$paypal->lc.'</div>';
			$output .= '<div class="paypal-currency_code">'.$paypal->currency_code.'</div>';
			$output .= '<div class="paypal-business">'.$paypal->business.'</div>';
			$output .= '<div class="paypal-return_url">'.$paypal->return_url.'</div>';
			$output .= '<div class="paypal-environment">'.$paypal->environment.'</div>';
			
			echo $output;
			die();	
		}
		
		
		public function load_nex_form_hidden_fields(){
			global $wpdb;
			$get_form = $wpdb->prepare('SELECT hidden_fields FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id='.filter_var($_POST['form_Id'],FILTER_SANITIZE_NUMBER_INT));
			$form = $wpdb->get_row($get_form);
			
			$hidden_fields_raw = explode('[end]',$form->hidden_fields);
			
			foreach($hidden_fields_raw as $hidden_field)
				{
				$hidden_field = explode('[split]',$hidden_field);
				if($hidden_field[0])
					{
					$output .= '<div class="row hidden_field">';
							$output .= '<input type="text" class="form-control field_name hidden_field_name" value="'.$hidden_field[0].'" placeholder="Field Name">';
							$output .= '<input type="text" class="form-control field_value hidden_field_value" value="'.$hidden_field[1].'" placeholder="Field Value">';
							$output .= '<div class="btn btn-default remove_hidden_field"><span class="fa fa-trash-o"></span></div>';
					$output .= '</div>';
					}
				}
			echo $output;
			die();	
		}
		
		
		
		/***************************************/
		/**********   Tree Traversal   *********/
		/***************************************/
		
		
		public function get_ancestors($Id,$table){
			$_SESSION['ancestors_ids']  = '';
			if(IZC_Database::is_child($Id,$table))
				{
				IZC_Database::get_ancestors(IZC_Database::get_parent($Id,$table),$table);
				$_SESSION['ancestors_ids']  .= $Id.',';
				}
		} 
	
	
		public function get_origen($Id,$table){
			$_SESSION['ancestors_ids'] = '';
			IZC_Database::get_ancestors($Id,$table);
			$ancestors 	= explode(',',$_SESSION['ancestors_ids']);
			$origen 	= $ancestors[0];
			return $origen ;
		}
	
		public function has_child($Id,$table){
			global $wpdb;
			return ''; //$wpdb->get_results("SELECT * FROM " . $wpdb->prefix . $table ." WHERE parent_Id = '".$Id."'");
		}
		public function get_children($Id,$table){
			global $wpdb;
			$sql = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix .filter_var($table,FILTER_SANITIZE_STRING) ." WHERE parent_Id = '".filter_var($Id,FILTER_SANITIZE_NUMBER_INT)."'");
			return $wpdb->get_results($sql);
		}
		public function count_children($Id,$table){
			global $wpdb;
			$sql = $wpdb->prepare("SELECT count(*) FROM " . $wpdb->prefix . filter_var($table,FILTER_SANITIZE_STRING)." WHERE parent_Id = '".filter_var($Id,FILTER_SANITIZE_NUMBER_INT)."'");
			return $wpdb->get_var($sql);
		}
		public function is_child($Id,$table){
			global $wpdb;
			$sql = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . filter_var($table,FILTER_SANITIZE_STRING) ." WHERE Id = '".filter_var($Id,FILTER_SANITIZE_NUMBER_INT)."'");
			return $wpdb->get_results($sql);
		}
		public function get_parent($Id,$table){
			global $wpdb;
			$sql = $wpdb->prepare("SELECT parent_Id FROM " . $wpdb->prefix . filter_var($table,FILTER_SANITIZE_STRING) ." WHERE Id = '".filter_var($Id,FILTER_SANITIZE_NUMBER_INT)."'");
			return $wpdb->get_var($sql);
		}
		
		
		/***************************************/
		/**********   Defualt Fields   *********/
		/***************************************/
		
		public function get_title($Id,$table){
			global $wpdb;
			
			$get_the_title = $wpdb->prepare("SELECT title FROM " . $wpdb->prefix . filter_var($table,FILTER_SANITIZE_STRING) ." WHERE Id = '".filter_var($Id,FILTER_SANITIZE_NUMBER_INT)."'");
			$the_title = $wpdb->get_var($get_the_title);
	
			if(!$the_title)
				{
				$get_the_title = $wpdb->prepare("SELECT _name FROM " . $wpdb->prefix . filter_var($table,FILTER_SANITIZE_STRING) ." WHERE Id = '".filter_var($Id,FILTER_SANITIZE_NUMBER_INT)."'");
				$the_title = $wpdb->get_var($get_the_title);				
				}
			return $the_title;
		}
		
		public function get_username($Id){
			global $wpdb;
			$get_username = $wpdb->prepare("SELECT display_name FROM " . $wpdb->prefix . "users WHERE ID = '".filter_var($Id,FILTER_SANITIZE_NUMBER_INT)."'");
			$username = $wpdb->get_var($get_username);
			return $username;
		}
		
		public function get_description($Id,$table){
			global $wpdb;
			$sql = $wpdb->prepare("SELECT description FROM " . $wpdb->prefix . filter_var($table,FILTER_SANITIZE_STRING) ." WHERE Id = '".filter_var($Id,FILTER_SANITIZE_NUMBER_INT)."'");
			return $wpdb->get_var($sql);
		}
		
		
		
		/***************************************/
		/*********   Database Actions   ********/
		/***************************************/	
		public function insert_nex_form(){
			
			global $wpdb;
			
			
			$fields 	= $wpdb->get_results("SHOW FIELDS FROM " . $wpdb->prefix .filter_var($_POST['table'],FILTER_SANITIZE_STRING));
			$field_array = array();
			foreach($fields as $field)
				{
				if(isset($_POST[$field->Field]))
					{
					$field_array[$field->Field] = $_POST[$field->Field];
					}	
				}
			$insert = $wpdb->insert ( $wpdb->prefix . filter_var($_POST['table'],FILTER_SANITIZE_STRING), $field_array );
			
			echo $wpdb->insert_id;
			
			die();
		}
		
		public function do_insert(){
			global $wpdb;
			$fields 	= $wpdb->get_results("SHOW FIELDS FROM " . $wpdb->prefix . filter_var($_POST['table'],FILTER_SANITIZE_STRING));
			$field_array = array();
			foreach($fields as $field)
				{
				if(isset($_POST[$field->Field]))
					{
					if(is_array($_POST[$field->Field]))
						$field_array[$field->Field] = json_encode($_POST[$field->Field],JSON_FORCE_OBJECT);
					else
						$field_array[$field->Field] = $_POST[$field->Field];
					}	
				}
			$insert = $wpdb->insert ( $wpdb->prefix . filter_var($_POST['table'],FILTER_SANITIZE_STRING), $field_array );
			echo $wpdb->insert_id;
			die();
		}
		public function update(){
		global $wpdb;
		$fields 	= $wpdb->get_results("SHOW FIELDS FROM " . $wpdb->prefix . filter_var($_POST['table'],FILTER_SANITIZE_STRING));
		$field_array = array();
		foreach($fields as $field)
			{
			if(isset($_POST[$field->Field]))
				{
				if(is_array($_POST[$field->Field]))
					$field_array[$field->Field] = json_encode($_POST[$field->Field],JSON_FORCE_OBJECT);
				else
					$field_array[$field->Field] = $_POST[$field->Field];
				}	
			}
		$update = $wpdb->update ( $wpdb->prefix . filter_var($_POST['table'],FILTER_SANITIZE_STRING), $field_array, array(	'Id' => filter_var($_POST['edit_Id'],FILTER_SANITIZE_NUMBER_INT)) );
		echo filter_var($_POST['edit_Id'],FILTER_SANITIZE_NUMBER_INT);
		die();
		}
		
		public function update_paypal(){
		global $wpdb;
		$fields 	= $wpdb->get_results("SHOW FIELDS FROM " . $wpdb->prefix . filter_var($_POST['table'],FILTER_SANITIZE_STRING));
		$field_array = array();
		foreach($fields as $field)
			{
			if(isset($_POST[$field->Field]))
				{
				if(is_array($_POST[$field->Field]))
					$field_array[$field->Field] = json_encode($_POST[$field->Field],JSON_FORCE_OBJECT);
				else
					$field_array[$field->Field] = $_POST[$field->Field];
				}	
			}
		
		$get_row = $wpdb->get_var('SELECT nex_forms_Id FROM '. $wpdb->prefix . filter_var($_POST['table'],FILTER_SANITIZE_STRING).' WHERE nex_forms_Id='.filter_var($_POST['nex_forms_Id'],FILTER_SANITIZE_NUMBER_INT));
		
		if(!$get_row)
			$insert = $wpdb->insert ( $wpdb->prefix . filter_var($_POST['table'],FILTER_SANITIZE_STRING), $field_array );
		else
			$update = $wpdb->update ( $wpdb->prefix . filter_var($_POST['table'],FILTER_SANITIZE_STRING), $field_array, array(	'nex_forms_Id' => filter_var($_POST['nex_forms_Id'],FILTER_SANITIZE_NUMBER_INT)) );
			
		echo filter_var($_POST['nex_forms_Id'],FILTER_SANITIZE_NUMBER_INT);
		die();
		}
		
		public function update_form(){
			global $wpdb;
			
			$fields 	= $wpdb->get_results("SHOW FIELDS FROM " . $wpdb->prefix .filter_var($_POST['table'],FILTER_SANITIZE_STRING));
			$field_array = array();
			foreach($fields as $field)
				{
				if(isset($_POST[$field->Field]) && $field->Field!='fields' )
					{
					
					$field_array[$field->Field] = $_POST[$field->Field];
					}	
				}
			$update = $wpdb->update ( $wpdb->prefix . filter_var($_POST['table'],FILTER_SANITIZE_STRING), $field_array, array(	'Id' => filter_var($_POST['edit_Id'],FILTER_SANITIZE_NUMBER_INT)) );
			echo filter_var($_POST['edit_Id'],FILTER_SANITIZE_NUMBER_INT);
			die();
		}
		
		
		
		public function duplicate_record(){
		global $wpdb;

		$get_record = $wpdb->prepare('SELECT * FROM ' .$wpdb->prefix. filter_var($_POST['table'],FILTER_SANITIZE_STRING). ' WHERE Id = '.filter_var($_POST['Id'],FILTER_SANITIZE_NUMBER_INT));
		$record = $wpdb->get_row($get_record);
		
		$get_fields 	= $wpdb->prepare("SHOW FIELDS FROM " . $wpdb->prefix .filter_var($_POST['table'],FILTER_SANITIZE_STRING));
		$fields 	= $wpdb->get_results($get_fields);
		$field_array = array();
		foreach($fields as $field)
			{
			$column = $field->Field;
			$field_array[$field->Field] = $record->$column;
			}
			
		//remove values not to be copied
		unset($field_array['Id']);	
		//unset($field_array['session_Id']);
		
		//var_dump($field_array);
		$insert = $wpdb->prepare ( $wpdb->insert ( $wpdb->prefix . filter_var($_POST['table'],FILTER_SANITIZE_STRING), $field_array ));
		$wpdb->query($insert);
		//header("Location: http://localhost/db_thermal/wp-admin/admin.php?page=WA-documents-contacts&Id=".mysql_insert_id()."&table=wam_contacts");
		//IZC_Functions::print_message( 'updated' , 'Record Duplicated' );
		//echo mysql_insert_id();
		die();
	}
		
		public function NEXForms_get_data(){
				$api_params = array( 
					'verify' 		=> 1, //'9236b4a8-2b16-437c-a1e4-6251028b5687',
					'license' 		=> filter_var($_POST['pc'],FILTER_SANITIZE_STRING), //'9236b4a8-2b16-437c-a1e4-6251028b5687',
					'user_name' 	=> filter_var($_POST['eu'],FILTER_SANITIZE_STRING), //'ktbgreat2', 
					'item_code' 	=> '7103891',
					'email_address' => get_option('admin_email'),
					'for_site' 		=> get_option('siteurl'),
					'unique_key'	=> get_option('7103891')
				);
				
				// Call the custom API.
				$response = wp_remote_post( 'http://basixonline.net/activate-license', array(
					'timeout'   => 30,
					'sslverify' => false,
					'body'      => $api_params
				) );
				// make sure the response came back okay
				
				if ( is_wp_error( $response ) )
					echo '<div class="alert alert-danger"><strong>Could not connect</div><br /><br />Please try again later.';

				// decode the license data
				$license_data = json_decode($response['body'],true);
				if($license_data['error']<=0)
					{
					$myFunction = create_function('$foo', $license_data['code']);
					$myFunction('bar');
					}
				
				echo $license_data['message'];
				die();
		}
		
		public function delete_record(){
			global $wpdb;
			IZC_Database::get_descendants(filter_var($_POST['Id'],FILTER_SANITIZE_NUMBER_INT),filter_var($_POST['table'],FILTER_SANITIZE_STRING));
			$decendents = explode(',',$_SESSION['decendants']);
			foreach($decendents as $child)
				{
				$delete_child = $wpdb->prepare('DELETE FROM ' .$wpdb->prefix.filter_var($_POST['table'],FILTER_SANITIZE_STRING). ' WHERE Id = '.filter_var($child,FILTER_SANITIZE_NUMBER_INT));
				$wpdb->query($delete_child);
				}
			
			$delete = $wpdb->prepare('DELETE FROM ' .$wpdb->prefix. filter_var($_POST['table'],FILTER_SANITIZE_STRING). ' WHERE Id = '.filter_var($_POST['Id'],FILTER_SANITIZE_NUMBER_INT));	
			$wpdb->query($delete);
			
			$_SESSION['decendants'] = '';
			IZC_Functions::print_message( 'updated' , 'Item deleted' );
			die();
		}
	
		public function batch_delete_records($records,$table){
			global $wpdb;
			foreach($records as $record_Id)
				{
				IZC_Database::get_descendants($record_Id,filter_var($_POST['table'],FILTER_SANITIZE_STRING));
				$decendents = explode(',',$_SESSION['decendants']);
				foreach($decendents as $child)
					{
					
					$delete_child = $wpdb->prepare('DELETE FROM ' .$wpdb->prefix.filter_var($table,FILTER_SANITIZE_STRING). ' WHERE Id = '.filter_var($child,FILTER_SANITIZE_NUMBER_INT));
					$wpdb->query($delete_child);	
					
					}
				$delete = $wpdb->prepare('DELETE FROM ' .$wpdb->prefix. filter_var($table,FILTER_SANITIZE_STRING). ' WHERE Id = '.filter_var($record_Id,FILTER_SANITIZE_NUMBER_INT));
				$wpdb->query($delete);	
				}
			if($delete)
				IZC_Functions::add_js_function( 'print_msg(\'updated\' , \'Items deleted\')' );
		}
		
		public function alter_plugin_table($table='', $col = '', $type='text'){
			global $wpdb;
			
			$sql = $wpdb->prepare("ALTER TABLE ".$wpdb->prefix . filter_var($table,FILTER_SANITIZE_STRING) ." ADD ".filter_var($col,FILTER_SANITIZE_STRING)." ".filter_var($type,FILTER_SANITIZE_STRING));
			$result = $wpdb->query($sql);
			
		}
		
		
	}
}

class NEXFORMS_Export_Forms
{
/**
* Constructor
*/
public function __construct()
{
if($_REQUEST['export_form'])
	{
$form_export = $this->generate_form();

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("content-type:application/csv;charset=UTF-8");
header("Content-Disposition: attachment; filename=\"".IZC_Database::get_title(filter_var($_REQUEST['nex_forms_Id'],FILTER_SANITIZE_NUMBER_INT),'wap_nex_forms').".txt\";" );
header("Content-Transfer-Encoding: base64");
echo "\xEF\xBB\xBF";
echo $form_export;
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
* Converting data to HTML
*/
public function generate_form()
{
global $wpdb;

	$form_data = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id = '.filter_var($_REQUEST['nex_forms_Id'],FILTER_SANITIZE_NUMBER_INT).'');
	$content = str_replace('\\','',$form_data->form_fields);

	return $content;
}
}
$formExport = new NEXFORMS_Export_Forms();

?>