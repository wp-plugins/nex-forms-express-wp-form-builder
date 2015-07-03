<?php
//This is a action for an AJAX function to get table records
add_action('wp_ajax_populate',array('IZC_Database','build_admin_table'));
//This is a action for an AJAX function to delete table records
add_action('wp_ajax_delete_record',array('IZC_Database','delete_record'));

//DB actions
add_action('wp_ajax_do_insert', array('IZC_Database','do_insert'));
add_action('wp_ajax_do_edit', array('IZC_Database','update'));
add_action('wp_ajax_duplicate_record', array('IZC_Database','duplicate_record'));

add_action('wp_ajax_nopriv_do_insert', array('IZC_Database','insert'));
add_action('wp_ajax_nopriv_do_edit', array('IZC_Database','update'));
add_action('wp_ajax_nopriv_duplicate_record', array('IZC_Database','duplicate_record'));


add_action('wp_ajax_insert_nex_form', array('IZC_Database','insert_nex_form'));
add_action('wp_ajax_edit_form', array('IZC_Database','update_form'));

add_action('wp_ajax_load_nex_form', array('IZC_Database','load_nex_form'));
add_action('wp_ajax_load_nex_form_attr', array('IZC_Database','load_nex_form_attr'));
add_action('wp_ajax_load_nex_form_hidden_fields', array('IZC_Database','load_nex_form_hidden_fields'));

add_action('wp_ajax_populate_dropdown',array('IZC_Database','populate_dropdown_list'));

add_action('wp_ajax_populate_form_entry',array('IZC_Database','populate_form_entry'));

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
			$tree 		= $wpdb->query('SHOW FIELDS FROM '. $wpdb->prefix .$_POST['table'].' LIKE "parent_Id"');
			
			$additional_params = json_decode(str_replace('\\','',$_POST['additional_params']),true);
			
			if(is_array($additional_params))
				{
				foreach($additional_params as $column=>$val)
					$where_str .= ' AND '.$column.'="'.$val.'"';
				}
			
			if($_POST['nex_forms_id'])
				$where_str .= ' AND nex_forms_Id='.$_POST['nex_forms_id'];
			
			
			$sql = 'SELECT * FROM '. $wpdb->prefix . $_POST['table'].' WHERE Id <> "" 
											'.(($tree) ? ' AND parent_Id="0"' : '').' 
											'.(($_POST['plugin_alias']) ? ' AND (plugin="'.$_POST['plugin_alias'].'" || plugin="shared")' : '').' 
											'.$where_str.'   
											ORDER BY 
											'.((isset($_POST['orderby']) && !empty($_POST['orderby'])) ? $_POST['orderby'].' 
											'.$_POST['order'] : 'Id DESC').' 
											LIMIT '.((isset($_POST['current_page'])) ? $_POST['current_page']*10 : '0'  ).',10 ';
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
						$output .= (($k==1) ? '<div class="row-actions"></span><span class="delete"><a href="javascript:delete_record(\''.$data->Id.'\',\''.$_POST['table'].'\');" >Delete</a></span></div>' : '' ).'</td>';
						$k++;
						//<span class="edit"><a href="?page='.$_POST['page'].'&Id='.$data->Id.'&table='.$_POST['table'].'" class="edit-tag">Edit</a> | 
						}
					if ( is_plugin_active( 'nex-forms-export-to-pdf/main.php' ) )
						$output .= '<td class="expand" scope="row"><a target="_blank" title="PDF [new window]" href="'.WP_PLUGIN_URL . '/nex-forms-export-to-pdf/examples/main.php?entry_ID='.$data->Id.'" class="btn btn-default"><span class="fa fa-file-pdf-o"></span> PDF</div></a></td>';
					else
						$output .= '<td class="expand" scope="row"><a target="_blank" title="Get export to PDF add-on" href="http://codecanyon.net/item/export-to-pdf-for-nexforms/11220942?ref=Basix" class="btn btn-success buy">Buy</a></td>';
					$output .= '</tr>';	
					
					if($tree)
						$output .= IZC_Database::build_descendants_list($data->Id, $headings, $_POST['table']);
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

			if($email_config['email_method']=='smtp' || $email_config['email_method']=='php_mailer')
				{
				date_default_timezone_set('Etc/UTC');
				require 'PHPMailerAutoload.php';
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
					$mail->SMTPDebug = 2;
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
				//Set an alternative reply-to address
			
				$mail->setFrom($_POST['email_address'], 'You');
				$mail->addCC($_POST['email_address'], 'You');
				//Set the subject line
				$mail->Subject = 'NEX-Forms Test Mail';
				//Read an HTML message body from an external file, convert referenced images to embedded,
				//convert HTML into a basic plain-text alternative body
				if($email_config['email_content']=='html')	
					$mail->msgHTML('This is a test message in <strong>HTML</strong>. If you received this your email settings are working correctly :)');
				else
					$mail->Body = 'This is a test message in PLAIN TEXT. If you received this your email settings are working correctly :)';
				//Replace the plain text body with one created manually
				//$mail->AltBody = 'This is a plain-text message body';
				//Attach an file
				//send the message, check for errors
				if (!$mail->send()) {
				    echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
				   echo "Message sent!";
					//echo print_r($mail);
				}
			}
					
		die();
		}
		
		
		public function load_nex_form(){
			global $wpdb;
			$form = $wpdb->get_row('SELECT form_fields FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id='.$_POST['form_Id']);
			echo str_replace('\\','',$form->form_fields);
			die();	
		}
		
		public function populate_form_entry(){
			global $wpdb;
			echo 'Sorry, form entries can only be viewed and exported with the <a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix" class="btn btn-xs btn-success">Pro Version</a>';
			
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
			
			$form = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id='.$_POST['form_Id']);
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
			
			echo $output;
			die();	
		}
		
		
		public function load_nex_form_hidden_fields(){
			global $wpdb;
			$form = $wpdb->get_row('SELECT hidden_fields FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id='.$_POST['form_Id']);
			
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
		/********   Dropdown Records   *********/
		/***************************************/
		public function populate_dropdown_list(){
			global $wpdb;
			$table 		= (isset($_POST['table'])) ? $_POST['table'] : $this->module_table;
			$plugin		= (isset($_POST['plugin_alias'])) ? $_POST['plugin_alias'] : $this->plugin_alias;
			$tree 		= $wpdb->query('SHOW FIELDS FROM '. $wpdb->prefix . $table .' LIKE "parent_Id"');
			
			
			
			$sql = 'SELECT * FROM '. $wpdb->prefix . $table .'  WHERE 1=1 
											'.(($tree) ? ' 		AND parent_Id="0"' : '').'
											'.(($plugin) ? ' 	AND (plugin="'.$plugin.'" || plugin="shared" )' : '');
			$results	= $wpdb->get_results($sql);
			//echo $sql;
			if(isset($_REQUEST['Id'])){
				global $wpdb;
				$selected  = $wpdb->get_var('SELECT '.$table.'_Id FROM '.$wpdb->prefix . $_REQUEST['table'] .' WHERE Id='.$_REQUEST['Id']);
			}
			
			//$output .= '<option value="0">---- Select ----</option>';
			
			if($results)
				{			
				foreach($results as $data)
					{
					$output .= '<option value="'.$data->Id.'" '.(($selected==$data->Id) ? 'selected="selected"' : '' ).'>'.(($data->title) ? $data->title : (($data->_name) ? $data->_name : (($data->mb_lacquer_ref) ? $data->mb_lacquer_ref : $data->code)) ).'</option>';
					if($tree)
						$output .= IZC_Database::build_descendants_list($data->Id, $headings, $table,0,'dropdown');
					}
				}
	
			if(isset($_POST['ajax'])) { echo $output; die(); }
			return $output;
		}
		
		public function populate_custom_dropdown_list($table,$field){
			
			global $wpdb;
	
			$results = $wpdb->get_results('SELECT '.$field.' FROM '. $wpdb->prefix . $table);
		
			$output .= '<option value="0">---- Select ----</option>';
			
			if($results)
				{			
				foreach($results as $data)
					{
					$output .= '<option value="'.$data->$field.'" '.(($selected==$data->$field) ? 'selected="selected"' : '' ).'>'.$data->$field.'</option>';
					}
				}
			return $output;
		}
		
		
		/***************************************/
		/**********   List Records   ***********/
		/***************************************/
		public function list_items(){
			
			global $wpdb;
			
			$table = (isset($_POST['table'])) ? $_POST['table'] : $this->module_table;
			
			$tree 		= $wpdb->query('SHOW FIELDS FROM '. $wpdb->prefix . $table .' LIKE "parent_Id"');
			$results 	= $wpdb->get_results('SELECT * FROM '. $wpdb->prefix . $table .' '.(($tree) ? ' WHERE parent_Id="0"' : '') );
			
			if($results)
				{			
				foreach($results as $data)
					{
	
					$output .= '<li value="'.$this->get_title($data->Id,$table).'"><a href="'.get_option('siteurl').'/listings/'.$this->get_title($data->Id,$table).'-'.$table.'_Id~'.$data->Id.'">'.$data->title.'</a>';
					/*if($tree)
						{
						if(IZC_Database::has_child($data->Id,$table))
							{
							$output .= '<ul class="children '.((IZC_Database::count_children($data->Id,$table)>5) ? 'col2' : 'col1' ).'">';
							}
						$output .= IZC_Database::build_descendants_list($data->Id, $headings, $table,0,'list');
						
						if(IZC_Database::has_child($data->Id,$table))
							{
							$output .= '<li class="seam"> </li>';
							$output .= '</ul>';
							}
						}*/
					$output .= '</li>';
					}
				}
				
			if(isset($_POST['ajax'])) { echo $output; die(); }
			
			return $output;
		}
		
		
		
		public function build_descendants_list($Id, $headings, $table, $level=0, $view='table'){
	
			IZC_Database::get_ancestors($Id,$table);
	
			$ancestors 		= explode(',',$_SESSION['ancestors_ids']);
			$total_count 	= count($ancestors)-1;
			
			for($i=1;$i<=$total_count;$i++)
				$indent .= ($view=='table') ? '&mdash; ' : '&nbsp;&nbsp; ' ; $level = $i-1;;
				
	
			/*if(IZC_Database::has_child($Id,$table))
				{
				switch($view)
					{
					case 'table': 
						foreach(IZC_Database::get_children($Id,$table) as $child)
							{	
							$output .= '<tr id="tag-'.$child->Id.'" class="'.((IZC_Database::has_child($child->Id,$table)) ? 'has-child' : '').' row child '.IZC_Database::get_origen($child->Id,$table).'-level-'.$level.' level-'.$Id.'-'.$level.'" onClick="showHide(this,\'level-'.$child->Id.'\','.($level+1).',10,\''.IZC_Database::get_origen($child->Id,$table).'\');">';
							$output .= '<th class="check-column" scope="row"><input type="checkbox" value="'.$child->Id.'" name="checked[]"></th>';
							$k=1;
							foreach($headings as $heading)	
								{
								$heading = IZC_Functions::format_name($heading);
								$heading = str_replace('_id','_Id',$heading);
								
								$val = (stristr($heading,'id')) ? IZC_Database::get_title($child->$heading,str_replace('_Id','',$heading)) : $child->$heading;
	
								$output .= '<td class="manage-column   column-'.$val.'">'.(($k==1) ? $indent.' <strong><a href="" class="row-title">'.$val.'</a></strong>' : $val).'';
								$output .= (($k==1) ? '<div class="row-actions"><span class="edit"><a href="?page='.$_POST['page'].'&Id='.$child->Id.'&table='.$_POST['table'].'" class="edit-tag">Edit</a> | </span><span class="delete"><a href="javascript:delete_record(\''.$child->Id.'\',\''.$_POST['table'].'\');" >Delete</a></span></div>' : '' ).'</td>';
								$k++;
								}
							$output .= '<th class="expand" scope="row"></th>';
							$output .= '</tr>';
							$output .= IZC_Database::build_descendants_list($child->Id,$headings,$table,$level);
							}
					break;
					
					case 'dropdown': 
						foreach(IZC_Database::get_children($Id,$table) as $child)
							{	
							$output .= '<option value="'.$child->Id.'" >'.$indent.$child->title.'</option>';
							$output .= IZC_Database::build_descendants_list($child->Id,$headings,$table,$level,$view);
							}
					break;
					
					case 'list': 
						foreach(IZC_Database::get_children($Id,$table) as $child)
							{
							$output .= '<li class="col1" id="item-'.$child->Id.'"><a href="'.get_option('siteurl').'/listings/'.$this->get_title($child->Id,$table).'-'.$table.'_Id~'.$child->Id.'">'.$child->title.'</a>';
							
							if(IZC_Database::has_child($child->Id,$table))
								{
								$output .= '<ul class="children">';
								$output .= IZC_Database::build_descendants_list($child->Id,$headings,$table,$level,$view);
								$output .= '</ul>';
								}
								
							$output .= '</li>';
							}
					break;
					}
				return $output;
				}*/
		}
		
		
		/***************************************/
		/**********   Tree Traversal   *********/
		/***************************************/
		public function get_descendants($Id,$table){
			/*if(IZC_Database::has_child($Id,$table))
				{
				foreach(IZC_Database::get_children($Id,$table) as $child)
					{
					$_SESSION['decendants'] .= $child->Id.',';
					IZC_Database::get_descendants($child->Id,$table);
					}
				}*/
		}
		
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
			return $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . $table ." WHERE parent_Id = '".$Id."'");
		}
		public function count_children($Id,$table){
			global $wpdb;
			return $wpdb->get_var("SELECT count(*) FROM " . $wpdb->prefix . $table ." WHERE parent_Id = '".$Id."'");
		}
		public function is_child($Id,$table){
			global $wpdb;
			return $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . $table ." WHERE Id = '".$Id."'");
		}
		public function get_parent($Id,$table){
			global $wpdb;
			return $wpdb->get_var("SELECT parent_Id FROM " . $wpdb->prefix . $table ." WHERE Id = '".$Id."'");
		}
		
		
		/***************************************/
		/**********   Defualt Fields   *********/
		/***************************************/
		
		public function get_title($Id,$table){
			global $wpdb;
			
			$the_title = $wpdb->get_var("SELECT title FROM " . $wpdb->prefix . $table ." WHERE Id = '".$Id."'");
	
			if(!$the_title)
				$the_title = $wpdb->get_var("SELECT _name FROM " . $wpdb->prefix . $table ." WHERE Id = '".$Id."'");
		
			return $the_title;
		}
		
		public function get_username($Id){
			global $wpdb;
			$username = $wpdb->get_var("SELECT display_name FROM " . $wpdb->prefix . "users WHERE ID = '".$Id."'");
			return $username;
		}
		
		public function get_description($Id,$table){
			global $wpdb;
			return $wpdb->get_var("SELECT description FROM " . $wpdb->prefix . $table ." WHERE Id = '".$Id."'");
		}
		
		
		
		/***************************************/
		/*********   Database Actions   ********/
		/***************************************/	
		public function insert_nex_form(){
			
			global $wpdb;
			
			
			$fields 	= $wpdb->get_results("SHOW FIELDS FROM " . $wpdb->prefix . $_POST['table']);
			$field_array = array();
			foreach($fields as $field)
				{
				if(isset($_POST[$field->Field]))
					{
					$field_array[$field->Field] = $_POST[$field->Field];
					}	
				}
			$insert = $wpdb->insert ( $wpdb->prefix . $_POST['table'], $field_array );
			
			echo mysql_insert_id();
			
			die();
		}
		
		public function do_insert(){
			global $wpdb;
			$fields 	= $wpdb->get_results("SHOW FIELDS FROM " . $wpdb->prefix . $_POST['table']);
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
			$insert = $wpdb->insert ( $wpdb->prefix . $_POST['table'], $field_array );
			echo mysql_insert_id();
			die();
		}
		public function update(){
		global $wpdb;
		$fields 	= $wpdb->get_results("SHOW FIELDS FROM " . $wpdb->prefix . $_POST['table']);
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
		$update = $wpdb->update ( $wpdb->prefix . $_POST['table'], $field_array, array(	'Id' => $_POST['edit_Id']) );
		echo $_POST['edit_Id'];
		die();
		}
		public function update_form(){
			global $wpdb;
			
			$fields 	= $wpdb->get_results("SHOW FIELDS FROM " . $wpdb->prefix . $_POST['table']);
			$field_array = array();
			foreach($fields as $field)
				{
				if(isset($_POST[$field->Field]) && $field->Field!='fields' )
					{
					
					$field_array[$field->Field] = $_POST[$field->Field];
					}	
				}
			$update = $wpdb->update ( $wpdb->prefix . $_POST['table'], $field_array, array(	'Id' => $_POST['edit_Id']) );
			die();
		}
		
		public function duplicate_record(){
		global $wpdb;

		$record = $wpdb->get_row('SELECT * FROM ' .$wpdb->prefix. $_POST['table']. ' WHERE Id = '.$_POST['Id']);
		$fields 	= $wpdb->get_results("SHOW FIELDS FROM " . $wpdb->prefix . $_POST['table']);
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
		$insert = $wpdb->insert ( $wpdb->prefix . $_POST['table'], $field_array );
		
		//header("Location: http://localhost/db_thermal/wp-admin/admin.php?page=WA-documents-contacts&Id=".mysql_insert_id()."&table=wam_contacts");
		//IZC_Functions::print_message( 'updated' , 'Record Duplicated' );
		//echo mysql_insert_id();
		die();
	}
		
		public function delete_record(){
			global $wpdb;
			IZC_Database::get_descendants($_POST['Id'],$_POST['table']);
			$decendents = explode(',',$_SESSION['decendants']);
			foreach($decendents as $child)
				{
				$wpdb->query('DELETE FROM ' .$wpdb->prefix. $_POST['table']. ' WHERE Id = '.$child);
				}
			$wpdb->query('DELETE FROM ' .$wpdb->prefix. $_POST['table']. ' WHERE Id = '.$_POST['Id']);
			$_SESSION['decendants'] = '';
			IZC_Functions::print_message( 'updated' , 'Item deleted' );
			die();
		}
	
		public function batch_delete_records($records,$table){
			global $wpdb;
			foreach($records as $record_Id)
				{
				IZC_Database::get_descendants($record_Id,$_POST['table']);
				$decendents = explode(',',$_SESSION['decendants']);
				foreach($decendents as $child)
					{
					$wpdb->query('DELETE FROM ' .$wpdb->prefix. $table. ' WHERE Id = '.$child);
					}
				$delete = $wpdb->query('DELETE FROM ' .$wpdb->prefix. $table. ' WHERE Id = '.$record_Id);
				}
			if($delete)
				IZC_Functions::add_js_function( 'print_msg(\'updated\' , \'Items deleted\')' );
		}
		
		public function alter_plugin_table($table='', $col = '', $type='text'){
			global $wpdb;
			
			$result = $wpdb->query("ALTER TABLE ".$wpdb->prefix . $table ." ADD ".$col." ".$type);
			
		}
		
		public function alter_module_table(){
			global $wpdb;
			
			$linked_modules = get_option('iz-linked-modules', array());
			
			if(!is_array($linked_modules))
				$linked_modules = array();
			
			$i = 0;
			if(is_array($this->link_modules))
				{
				foreach($this->link_modules as $link_module=>$val)
					{
					$links[$i] = $link_module;
					$result = $wpdb->query("ALTER TABLE ".$wpdb->prefix . $link_module ." ADD ".$this->foreign_key." INT(11) unsigned NOT NULL");
					$i++;
					IZC_Modules::create_link_purpose($link_module,$val);
					}
				}
	
			$link_array[$this->module_table] = $links; 
			$new_linked_modules = array_merge($linked_modules,$link_array);
			update_option('iz-linked-modules',$new_linked_modules);
			
			
		}
		
		public function share_item(){
			global $wpdb;
			
			$is_multi = $wpdb->get_results('SELECT distinct(plugin) FROM ' . $wpdb->prefix . $this->plugin_table);
			
			if(count($is_multi)>1)
				{
				//<div class="form-field form-required"><label for="Title">Title</label><div class="iz-form-item"><input type="text" value="" name="title"></div></div>
				//$output .= '<div class="form-field ">';
					$output .= '<label >&nbsp;&nbsp;Share Item</label>';
					$output .= '<div class="iz-form-item">';
						$output .= '<input id="shared" type="radio" name="set_plugin" value="shared"><lable for="shared">&nbsp;&nbsp;Yes</label><br />';
						$output .= '<input id="private" type="radio" name="set_plugin" value="'.$this->plugin_alias.'" checked="checked"><lable for="private">&nbsp;&nbsp;No</label>';	
					$output .= '</div>';
				//$output .= '</div>';
				}
			
			return $output;
		}
		
		public function get_plugin_table(){
			global $wpdb;
			$fields = $wpdb->get_results("SHOW FIELDS FROM " . $wpdb->prefix . $this->plugin_table);
			
			foreach($fields as $field)
				{
				$table_fields .= $field->Field.'<br />';
				}
			return $table_fields;
		}
		
		public function get_foreign_fields($key){
			global $wpdb;
			$fields = $wpdb->get_results("SHOW FIELDS FROM " . $wpdb->prefix . $this->plugin_table . " LIKE '%".$key."%'");
			
			$foreign_fields = array();
			
			foreach($fields as $field)
				{
				array_push($foreign_fields,$field->Field);
				}
			return $foreign_fields;
		}
		
		public function get_foreign_Id($Id,$foreign_key,$table){
			global $wpdb;
			return $wpdb->get_var("SELECT ".$foreign_key." FROM " . $wpdb->prefix . $table ." WHERE Id = '".$Id."'");
		}
		
		public function get_module_table(){
			global $wpdb;
			$fields = $wpdb->get_results("SHOW FIELDS FROM " . $wpdb->prefix . $this->module_table);
			$table_fields = '';
			foreach($fields as $field)
				{
				$table_fields .= $field->Field.'<br />';
				}
			return $table_fields;
		}	
	}
}
?>