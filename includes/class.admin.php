<?php
/***************************************/
/***********   Ajax Calls   ************/
/***************************************/

add_action('wp_ajax_get_lang_settings',  array('NEXForms_admin','get_lang_settings') );
add_action('wp_ajax_get_event_info',  array('NEXForms_admin','get_event_info') );
add_action('wp_ajax_get_events',  array('NEXForms_admin','NEXForms_get_events') );
add_action('wp_ajax_get_event_information',  array('NEXForms_admin','get_event_information') );
add_action('wp_ajax_load_nex_event_calendars',  array('NEXForms_admin','get_calendars') );
add_action('wp_ajax_build_form_data_table', array('NEXForms_form_entries','build_form_data_table'));
add_action('wp_ajax_populate_form_data_list', array('NEXForms_form_entries','get_form_data'));
add_action( 'wp_ajax_do_upload_image', array('NEXForms_admin','do_upload_image'));
add_action( 'wp_ajax_do_upload_image_select', array('NEXForms_admin','do_upload_image_select'));


add_action( 'wp_ajax_save_email_config', array('NEXForms_admin','save_email_config'));
add_action( 'wp_ajax_save_script_config', array('NEXForms_admin','save_script_config'));
add_action( 'wp_ajax_save_style_config', array('NEXForms_admin','save_style_config'));
add_action( 'wp_ajax_save_other_config', array('NEXForms_admin','save_other_config'));

add_action('wp_ajax_delete_form_entry', array('NEXForms_form_entries','delete_form_entry'));

class NEXForms_admin{

	/***************************************/
	/*******   Customizing Forms   *********/
	/***************************************/
	
	
	public function submit_nex_form(){
		echo 'test';
		
		die();	
	}
	
	public function save_email_config() {
		update_option('nex-forms-email-config',$_POST);
		die();
	}
	
	public function save_script_config() {
		//print_r($_POST);
		
		
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
			
		update_option('nex-forms-script-config',$_POST);
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

		update_option('nex-forms-style-config',$_POST);
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
		
		
		update_option('nex-forms-other-config',$_POST);
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
		$calendars = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms ORDER BY Id DESC');
		//$i=1;
		foreach($calendars as $calendar)
			{
			$output .= '<a class="list-group-item" href="#" id="'.$calendar->Id.'">';
				$output .= '<span class="fa fa-bars"></span>&nbsp;&nbsp;<span class="calendar_title open_calendar style_bold">'.$calendar->title.'</span><br />';
				$output .= '<span class="calendar_description"><em><small style="color:#999; margin-left: 20px">'.$calendar->description.'</small></em></span>';
				$output .= '<div class="btn-group btn-group-xs">
				  <button type="button" class="btn alert-success open_calendar" data-dismiss="modal" data-toggle="tooltip" data-placement="top" title="Open" id="'.$calendar->Id.'">&nbsp;<span class="fa fa-file"></span>&nbsp;</button>
				  <button type="button" class="btn alert-info duplicate_record" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Duplicate" id="'.$calendar->Id.'">&nbsp;<span class="fa fa-files-o"></span>&nbsp;</button>
				  <button type="button" class="btn alert-warning edit_the_calendar" data-toggle="modal" data-target="#editCalendar" data-toggle="tooltip" data-placement="top" title="Edit" id="'.$calendar->Id.'">&nbsp;<span class="fa fa-pencil"></span>&nbsp;</button>
				  <button type="button" class="btn alert-info use_calendar" data-toggle="modal" data-target="#useCalendar" data-toggle="tooltip" data-placement="top" title="Use" id="'.$calendar->Id.'">&nbsp;<span class="fa fa-code"></span>&nbsp;</button>
				  <button type="button" class="btn alert-danger delete_the_calendar" data-toggle="modal" data-target="#deleteCalendar" data-placement="top" title="Delete" id="'.$calendar->Id.'">&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;</button>
				</div>';
			$output .= '</a>';
			//$i++;
			}
			//$output .= '<li id="'.$calendar->Id.'" class="nex_event_calendar"><a href="#"><span class="the_form_title">'.$calendar->title.'</span></a>&nbsp;&nbsp;<i class="fa fa-trash-o delete_the_calendar" data-toggle="modal" data-target="#deleteCalendar" id="'.$calendar->Id.'"></i></li>';	
		echo $output;
		die();
	}
	
	public function NEXForms_field_settings()
		{
		$lock = '&nbsp;&nbsp;<span title="" data-toggle="tooltip" data-placement="bottom" class="bs-tooltip fa fa-lock text-danger" data-original-title="This feature is locked! Click on \'Upgade to Pro\' top right to activate.">&nbsp;</span>';
		$lock2 = '&nbsp;&nbsp;<span title="" data-toggle="tooltip" data-placement="bottom" class="bs-tooltip fa fa-lock" data-original-title="This feature is locked! Click on \'Upgade to Pro\' top right to activate.">&nbsp;</span>';
		
		do_action( 'styles_font_menu' );
		$output .= '<form enctype="multipart/form-data" method="post" action="'.get_option('siteurl').'/wp-admin/admin-ajax.php" id="do_upload_image_selection" name="do_upload_image_selection" style="display:none;">
								<div data-provides="fileinput" class="fileinput fileinput-new">
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
tiff</div></div></form><div id="nex-forms-field-settings" class="nex-forms-field-settings bs-callout bs-callout-info bootstro" data-bootstro-title="Editing Panel" data-bootstro-content="This is where you will edit all available settings for form elements. This panel will slide open on adding a new field or by clicking on a specific element\'s attributes: the label, the input or the help text. The current element is highlighted by a green dotted border (see the text field label to your left)<br /><br /> Note that different fields have different validation and input settings." data-bootstro-placement="left" data-bootstro-step="17">';
					$output .= '<div class="current_id hidden" ></div>';
					$output .= '<div class="blogname hidden" >'.get_option('blogname').'</div>';
					$output .= '<div class="admin_email hidden" >'.get_option('admin_email').'</div>';
						$output .= '<div class="panel panel-default admin-panel">';
							$output .= '<div class="panel-heading">';
								$output .= '<h4 class="panel-title label-primary">';									
									$output .= '<a><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Edit Field&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="btn btn-info copy-field bs-tooltip" title="Duplicate field" data-placement="right" data-toggle="tooltip"><span class="glyphicon fa fa-files-o"></span></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="btn btn-danger delete-field bs-tooltip" title="Delete field" data-placement="right" data-toggle="tooltip"><span class="glyphicon fa fa-trash-o"></span></span><span class="close glyphicon glyphicon-remove"></span></a>';
								$output .= '</h4>';
							$output .= '</div>';
							$output .= '<div>';
								$output .= '<div class="">';
									$output .= '<div class="clearfix" id="options">
													  <ul data-option-key="filter" class="option-set  nav nav-tabs alert-info clearfix" id="filters">
														<li class="active bootstro" data-bootstro-title="Label settings" data-bootstro-content="Label settings are mostly the same for elements and contains: Label text and color, sublabel text and color, label position (top, left, hidden), text alignment (left, center, right), font style with over 1400 fonts to choose from and label size" data-bootstro-placement="right" data-bootstro-step="18"><a class="the-label" data-option-value=".settings-label" href="#filter">Label</a></li>
														<li class="bootstro" data-bootstro-title="Input settings" data-bootstro-content="These setting differ for each type of field and are focused on the input element itself" data-bootstro-placement="right" data-bootstro-step="19"><a class="input-element" data-option-value=".settings-input" href="#filter">Input</a></li>
														<li class="bootstro" data-bootstro-title="Help text settings" data-bootstro-content="Help text settings are mostly the same for elements and contains: the help text and color, position (tooltip, bottom or hidden), alignment (left,center,right), font style with over 1400 fonts to choose from and text size" data-bootstro-placement="right" data-bootstro-step="20"><a class="help-text" data-option-value=".settings-help-text" href="#filter">Help Block</a></li>
														<li class="bootstro" data-bootstro-title="Validation settings" data-bootstro-content="Validation settings are also mostly the same for elements and contains: required (yes, no), required indicator(full star, empty star, asterisk), position to popup (top, right, bottom, left) and the error message to be displayed. Text and custom fields will contain extra validation settings namely: maximum characters, and format vaidation (email, url, number, digists only, text only)" data-bootstro-placement="bottom" data-bootstro-step="21" ><a class="validation" data-option-value=".settings-validation" href="#filter">Validation</a></li>
														<li><a class="logic" class="selected" data-option-value=".settings-logic" href="#filter">Logic '.$lock.'</a></li>
													  </ul>
												  </div>';
									
									$output .= '<div id="field-settings-inner">';
                  						$output .= '<div class="clearfix row isotope" id="isotope_container" style="position: relative; height: 606px;">';

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
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-prefix icons" style="z-index:1000005 !important;">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Prefix Icon</label>';
														$output .= '<div class="btn-group">';
															$output .= '<button type="button"  data-toggle="dropdown" class="btn btn-default">';
																$output .= '<span id="prefix-icon" class="current-icon fa fa-check"></span>';
															$output .= '</button>';
															$output .= '<div class="btn-group">';
																$output .= '<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">';
																	$output .= 'Icon';
																$output .= '</button>';
																$output .= '<div role="menu" class="icon_set prefix-icon dropdown-menu">';
																	$output .= NEXForms_admin::show_icons();
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
													$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-prefix icons selected-color" style="z-index:1000004 !important;">';
														$output .= '<div class="input_holder ">';											
															$output .= '<label>Prefix Color</label>';
															$output .= '<div class="btn-group">
																		<button type="button"  data-toggle="dropdown" class="btn btn-default prefix-color-class colorpicker-element">
																		<i class="btn-default"></i>
																		</button>
																		<div class="btn-group">
																		<button data-toggle="dropdown" class="btn btn-default down_icon dropdown-toggle" type="button">
																		Color
																		</button><ul class="dropdown-menu prefix-color">
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
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';	
											$output .= '</div>';

/******************************************************************************************************************************/
//POSTFIX             							 
											//text
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-postfix icons" style="z-index:1000003 !important;">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Postfix Icon</label>';
														$output .= '<div class="btn-group">';
															$output .= '<button type="button"  data-toggle="dropdown" class="btn btn-default">';
																$output .= '<span id="postfix-icon" class="current-icon fa fa-check"></span>';
															$output .= '</button>';
															$output .= '<div class="btn-group">';
																$output .= '<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">';
																	$output .= 'Icon';
																$output .= '</button>';
																$output .= '<div role="menu" class="icon_set postfix-icon dropdown-menu">';
																	$output .= NEXForms_admin::show_icons();
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
													$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-postfix icons selected-color" style="z-index:1000002 !important;">';
														$output .= '<div class="input_holder ">';											
															$output .= '<label>Postfix Color</label>';
															$output .= '<div class="btn-group">
																		<button type="button" data-toggle="dropdown" class="btn btn-default postfix-color-class colorpicker-element">
																		<i class="btn-default"></i>
																		</button>
																		<div class="btn-group">
																		<button data-toggle="dropdown" class="btn btn-default down_icon dropdown-toggle" type="button">
																		Color
																		</button><ul class="dropdown-menu postfix-color">
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
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';	
											$output .= '</div>';											
											
											
                  
/******************************************************************************************************************************/
//LABEL SETTINGS                							 
											//text
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-label isotope-item">';
													$output .= '<div class="input_holder ">';					
														$output .= '<label>Text</label>';
														$output .= '<div class="input-group">';
															$output .= '<input id="set_label" type="text" name="set_label" class="form-control">';
														    $output .= '<span class="input-group-addon label-bold label-primary"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon label-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-label isotope-item">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Color</label>';
														$output .= '<div id="label-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#000000" class="form-control" />
																		<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											
											//Subtext
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-label isotope-item">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Sub Label</label>';
														$output .= '<div class="input-group">';
															$output .= '<input id="set_subtext" type="text" name="set_subtext" class="form-control">';
														    $output .= '<span class="input-group-addon sub-label-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon sub-label-italic label-primary"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-label isotope-item">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Color</label>';
															$output .= '<div id="label-subtext" class="input-group colorpicker-component demo demo-auto">
																	<span class="input-group-addon"><i></i></span>
																	<input type="text" value="#999999" class="form-control" />
																	<span class="input-group-addon reset" data-default="#999999"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';	
											
											//Position / alingment
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-label isotope-item">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Position</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group show-label">
																		<button class="btn btn-default  left" type="button"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Left</button>
																		<button class="btn btn-default  top" type="button"><span class="glyphicon glyphicon-arrow-up"></span>&nbsp;&nbsp;Top</button>
																		<button class="btn btn-default  none" type="button"><span class=" glyphicon glyphicon-eye-close"></span>&nbsp;&nbsp;Hide</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-label isotope-item">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Alignment</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group align-label">
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
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-label isotope-item" style="z-index:1000">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Font</label>';
														$output .=	'<div class="google-fonts-dropdown-label input-group"><select name="label-fonts" class="sfm form-control"></select><span class="input-group-addon"><i><input type="checkbox" checked="checked" title="Show Preview" data-placement="top" data-toggle="tooltip" class="bs-tooltip" name="show-font-preview"></i></span></div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-label isotope-item">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Size</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group label-size">
																		<button class="btn btn-default small" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Small</button>
																		<button class="btn btn-default  normal" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Normal</button>
																		<button class="btn btn-default  large" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Large</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';

/******************************************************************************************************************************/
//PARAGRAPH SETTINGS												
											$output .= '<div class="row">';
												
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-paragraph">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Paragraph text</label>';
														$output .= '<textarea name="set_paragraph" id="set_paragraph" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												
											$output .= '</div>';

/******************************************************************************************************************************/
//HEADING SETTINGS												
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-heading">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Heading Text</label>';
														$output .= '<div class="input-group">';
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
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Heading</label>';
														$output .= '<div class="input-group">';
															$output .= '<input name="set_panel_heading" id="set_panel_heading" class="form-control">';
															$output .= '<span class="input-group-addon panel-head-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon panel-head-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Heading Size</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group panel-heading-size">
																		<button class="btn btn-default small" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Small</button>
																		<button class="btn btn-default normal" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Normal</button>
																		<button class="btn btn-default large" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Large</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												
												
												
												
												
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Heading Color</label>';
														$output .= '<div id="panel_heading_color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#333333" class="form-control" />
																		<span class="input-group-addon reset" data-default="#333333"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Heading Background Color</label>';
														$output .= '<div id="panel_heading_background" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#F5F5F5" class="form-control" />
																		<span class="input-group-addon reset" data-default="#F5F5F5"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Body Background Color</label>';
														$output .= '<div id="panel_body_background" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Border Color</label>';
														$output .= '<div id="panel_border_color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#DDDDDD" class="form-control" />
																		<span class="input-group-addon reset" data-default="#DDDDDD"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-panel" style="z-index:1000">';
													$output .= '<div class="input_holder">';
														$output .= '<label>Font '.$lock.'</label>';
														$output .=	'<div class="google-fonts-dropdown-panel input-group"><select name="panel-fonts" class="sfm form-control"></select><span class="input-group-addon"><i><input type="checkbox" checked="checked" title="Show Preview" data-placement="top" data-toggle="tooltip" class="bs-tooltip" name="show-font-preview"></i></span></div>';
													$output .= '</div>'; 
												$output .= '</div>';
												
											$output .= '</div>';


                
/******************************************************************************************************************************/
//FIELD INPUT SETTINGS
	/******************************************************************************************************************************/
//TAGS SETTINGS												
											$output .= '<div class="row">';
												//tags
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-tags icons" style="z-index:1000001 !important;">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Tag Icon</label>';
														$output .= '
														<div class="btn-group">
														<button type="button"  data-toggle="dropdown" class="btn btn-default">
														<span  id="tag-icon" class="current-icon fa fa-check"></span>
														</button>
														<div class="btn-group">
														<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
															Tag Icon
														</button>
													    <div role="menu" class="icon_set dropdown-menu">';
														$output .= NEXForms_admin::show_icons();
														$output .= '</div></div></div></div>';
														$output .= '</div>';
														$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-tags icons selected-color" style="z-index:1000000 !important;">';
															$output .= '<div class="input_holder ">';											
																$output .= '<label>Color</label>';
																$output .= '<div class="btn-group">
																			<button type="button"  data-toggle="dropdown" class="btn btn-default tag-color-class colorpicker-element">
																			<i class="btn-default"></i>
																			</button>
																			<div class="btn-group">
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
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-autocomplete">';
													$output .= '<div class="input_holder prepopulate_target">';											
														$output .= '<label>Selection</label>';
														$output .= '<textarea id="set_selections" name="set_selections" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												//autocomplete
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-date-time">';										
														$output .= '<label>Date Format</label>';
														$output .= '<select id="select_date_format" class="form-control">
																	<option value="DD/MM/YYYY hh:mm A">DD/MM/YYYY hh:mm A</option>
																	<option value="YYYY/MM/DD hh:mm A">YYYY/MM/DD hh:mm A</option>
																	<option value="DD-MM-YYYY hh:mm A">DD-MM-YYYY hh:mm A</option>
																	<option value="YYYY-MM-DD hh:mm A">YYYY-MM-DD hh:mm A</option>
																	<option value="custom">Custom</option>
																</select>';
														$output .= '<br /><input id="set_date_format" type="text" name="set_date_format" value="" class="form-control hidden"><span class="help-block">See <a href="http://momentjs.com/docs/#/displaying/format/">momentjs\' docs</a> for valid formats</span>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-date-time">';										
														$output .= '<label>Select Language</label>';
														$output .= '<select id="date-picker-lang-selector" class="form-control"><option value="en">en</option><option value="ar-ma">ar-ma</option><option value="ar-sa">ar-sa</option><option value="ar-tn">ar-tn</option><option value="ar">ar</option><option value="bg">bg</option><option value="ca">ca</option><option value="cs">cs</option><option value="da">da</option><option value="de-at">de-at</option><option value="de">de</option><option value="el">el</option><option value="en-au">en-au</option><option value="en-ca">en-ca</option><option value="en-gb">en-gb</option><option value="es">es</option><option value="fa">fa</option><option value="fi">fi</option><option value="fr-ca">fr-ca</option><option value="fr">fr</option><option value="he">he</option><option value="hi">hi</option><option value="hr">hr</option><option value="hu">hu</option><option value="id">id</option><option value="is">is</option><option value="it">it</option><option value="ja">ja</option><option value="ko">ko</option><option value="lt">lt</option><option value="lv">lv</option><option value="nb">nb</option><option value="nl">nl</option><option value="pl">pl</option><option value="pt-br">pt-br</option><option value="pt">pt</option><option value="ro">ro</option><option value="ru">ru</option><option value="sk">sk</option><option value="sl">sl</option><option value="sr-cyrl">sr-cyrl</option><option value="sr">sr</option><option value="sv">sv</option><option value="th">th</option><option value="tr">tr</option><option value="uk">uk</option><option value="vi">vi</option><option value="zh-cn">zh-cn</option><option value="zh-tw">zh-tw</option></select>';
														$output .= '';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition populate setting-autocomplete">';
													$output .= '<div class="input_holder">';											
														$output .= '<label>Presets</label>';
														$output .= '<div class="btn-group">
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
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-color-pallet">';
													$output .= '<div class="input_holder prepopulate_target">';											
														$output .= '<label>Color Selection</label>';
														$output .= '<textarea id="set_color_selection" name="set_color_selection" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												
											
												//select
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-select setting-multi-select">';
													$output .= '<div class="input_holder prepopulate_target">';	
														$output .= '<label>Default Value</label>';
														$output .= '<input id="set_default_value" type="text" name="set_default_value" value="--- Select ---" class="form-control">
															<span class="help-block">This will send a "0" value or triggers required validation.</span>';										
														$output .= '<label>Select Options</label>';
														
														$output .= '<textarea id="set_options" name="set_options" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition populate setting-select setting-multi-select">';
													$output .= '<div class="input_holder">';											
														$output .= '<label>Presets</label>';
														$output .= '<div class="btn-group">
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
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-validation-file-input" >';
													$output .= '<div class="input_holder prepopulate_target">';
													$output .= '<label>Allowed Extensions</label>';
														$output .= '<textarea id="set_extensions" name="set_extensions" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition populate setting-validation-file-input" style="z-index:1000000 !important;">';
													$output .= '<div class="input_holder">';											
														$output .= '<label>Presets</label>';
														$output .= '<div class="btn-group">
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
												
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-text setting-textarea">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Place Holder</label>';
														$output .= '<input id="set_place_holder" type="text" name="set_place_holder" class="form-control">';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-all">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Input Name</label><small>This is used to identify your field and will be used to label your entry value on form submission</small>';
														$output .= '<input id="set_input_name" type="text" name="set_input_name" class="form-control">';
													$output .= '</div>';
												$output .= '</div>';
												
											$output .= '</div>';
											
											//Input value / max chars
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-text setting-textarea setting-button">';
													
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Input Value</label>';
														$output .= '<div class="input-group">';
															$output .= '<input id="set_val" type="text" name="set_val" class="form-control">';
														    $output .= '<span class="input-group-addon input-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon input-italic"><span class="glyphicon glyphicon-italic"></span></span>';

														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';	
											
											
											
											
											$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-button">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Width</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group button-width">
																		<button class="btn btn-default normal" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Normal</button>
																		<button class="btn btn-default full_button" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Full</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
														
													
													
											$output .= '</div>';
											
											
											$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-bg-image setting-panel">';
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
												
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-bg-image setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Size</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group panel-background-size">
																		<button class="btn btn-default auto" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Auto</button>
																		<button class="btn btn-default cover" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Cover</button>
																		<button class="btn btn-default contain" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Contain</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-bg-image setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Repeat</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group panel-background-repeat">
																		<button class="btn btn-default no-repeat" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;No Repeat</button>
																		<button class="btn btn-default repeat" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Repeat</button>
																		<button class="btn btn-default repeat-x" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Repeat-X</button>
																		<button class="btn btn-default repeat-y" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Repeat-Y</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-bg-image setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Position</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group panel-background-position">
																		<button class="btn btn-default left" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Left</button>
																		<button class="btn btn-default center" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Center</button>
																		<button class="btn btn-default right" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Right</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											
											
											
											//Colors
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-paragraph setting-heading settings-input setting-button">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Color</label>';
														$output .= '<div id="input-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#000000" class="form-control" />
																		<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-input setting-button">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Color</label>';
														$output .= '<div id="input-bg-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											
											//Border
											$output .= '<div class="row ">';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-input setting-button setting-divider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Border Color</label>';
														$output .= '<div id="input-border-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#DDDDDD" class="form-control" />
																		<span class="input-group-addon reset" data-default="#DDDDDD"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-input">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Border Color On Focus</label>';
														$output .= '<div id="input-onfocus-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#66AFE9" class="form-control" />
																		<span class="input-group-addon" ><i><input type="checkbox" checked="checked" name="drop-focus-swadow" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="Drop shadow?"></i></span>
																		<span class="input-group-addon reset" data-default="#66AFE9"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											
											
											//Size / Alignment
											$output .= '<div class="row">';
												//paragraph
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-paragraph">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Alignment</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group align-input">
																		<button class="btn btn-default left" type="button"><span class="glyphicon glyphicon-align-left"></span>&nbsp;&nbsp;Left</button>
																		<button class="btn btn-default center" type="button"><span class="glyphicon glyphicon-align-center"></span>&nbsp;&nbsp;Center</button>
																		<button class="btn btn-default right" type="button"><span class="glyphicon glyphicon-align-right"></span>&nbsp;&nbsp;Right</button>																		
																		<button class="btn btn-default justify" type="button"><span class="glyphicon glyphicon-align-justify"></span>&nbsp;&nbsp;Justify</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-input setting-heading setting-button">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Alignment</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group align-input">
																		<button class="btn btn-default left" type="button"><span class="glyphicon glyphicon-align-left"></span>&nbsp;&nbsp;Left</button>
																		<button class="btn btn-default right" type="button"><span class="glyphicon glyphicon-align-right"></span>&nbsp;&nbsp;Right</button>
																		<button class="btn btn-default center" type="button"><span class="glyphicon glyphicon-align-center"></span>&nbsp;&nbsp;Center</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-input setting-button">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Size</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group input-size">
																		<button class="btn btn-default small" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Small</button>
																		<button class="btn btn-default normal" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Normal</button>
																		<button class="btn btn-default large" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Large</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											//font
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-input setting-paragraph setting-heading setting-button" style="z-index:1000">';
													$output .= '<div class="input_holder">';
														$output .= '<label>Font '.$lock.'</label>';
														$output .=	'<div class="google-fonts-dropdown-input input-group"><select name="input-fonts" class="sfm form-control"></select><span class="input-group-addon"><i><input type="checkbox" checked="checked" title="Show Preview" data-placement="top" data-toggle="tooltip" class="bs-tooltip" name="show-font-preview"></i></span></div>';
													$output .= '</div>'; 
												$output .= '</div>';
											$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-input setting-slider setting-panel setting-tags setting-button">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Corners</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group input-corners">
																		<button class="btn btn-default square" type="button">Square</button>
																		<button class="btn btn-default btn-primary normal" type="button">Rounded</button>
																		<!--<button class="btn btn-default full_rounded" type="button">Fully rounded</button>-->
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';

/******************************************************************************************************************************/
//HELP TEXT SETTINGS
										
											//Text
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-help-text">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Text</label>';														
														$output .= '<div class="input-group">';
															$output .= '<input id="set_help_text" type="text" name="set_help_text" class="form-control">';
														    $output .= '<span class="input-group-addon help-text-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon help-text-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-help-text">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Color</label>';
														$output .= '<div id="help-text-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#737373" class="form-control" />
																		<span class="input-group-addon reset" data-default="#737373"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											
											//Position / alignment
											$output .= '<div class="row">';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-help-text">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Position</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group show-help-text">
																		<button class="btn btn-default btn-primary bottom" type="button"><span class="glyphicon glyphicon-arrow-down"></span>&nbsp;&nbsp;Bottom</button>
																		<button class="btn btn-default show-tooltip" type="button"><span class="glyphicon fa fa-question-circle"></span>&nbsp;&nbsp;Tip</button>
																		<button class="btn btn-default none" type="button"><span class=" glyphicon glyphicon-eye-close"></span>&nbsp;&nbsp;Hide</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-help-text">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Alignment</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group align-help-text">
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
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-help-text" style="z-index:1000">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Font '.$lock.'</label>';
														$output .=	'<div class="google-fonts-dropdown-help-text input-group"><select name="help-text-fonts" class="sfm form-control"></select><span class="input-group-addon"><i><input type="checkbox" checked="checked" title="Show Preview" data-placement="top" data-toggle="tooltip" class="bs-tooltip" name="show-font-preview"></i></span></div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-help-text">';
													$output .= '<div class="input_holder">';
														$output .= '<label>Size</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group help-text-size">
																		<button class="btn btn-default small" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Small</button>
																		<button class="btn btn-default  normal" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Normal</button>
																		<button class="btn btn-default  large" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Large</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';											
											              
/******************************************************************************************************************************/
//ERROR MESSAGE SETTINGS			               
											//Text / position
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-validation">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Required</label>';
														$output .= '<div class="btn-toolbar" role="toolbar">
																	<div class="btn-group required">
																		<button type="button" class="btn btn-default btn-sm yes"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;Yes</button>
																		<button type="button" class="btn btn-default btn-sm no btn-primary">&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>&nbsp;&nbsp;No</button>
																	  </div>
																	<div class="btn-group required-star">
																		<button type="button" class="btn btn-default btn-sm full btn-primary">&nbsp;<span class="glyphicon glyphicon-star"></span>&nbsp;</button>
																		<button type="button" class="btn btn-default btn-sm empty">&nbsp;<span class="glyphicon glyphicon-star-empty"></span>&nbsp;</button>
																	  	<button type="button" class="btn btn-default btn-sm asterisk">&nbsp;<span class="glyphicon glyphicon-asterisk"></span>&nbsp;</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-validation error_color">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Required Message</label>';
														$output .= '<div class="input-group"><input id="the_error_mesage" type="text" value="" name="the_error_mesage" class="form-control">
																		<div class="input-group-btn">
																			<button type="button" class="btn btn-default dropdown-toggle validation-color colorpicker-element" style="padding-top:7px !important;" data-toggle="dropdown"><i class="btn-default"></i></button>
																			<ul class="dropdown-menu error-color">
																			  <li><a href="#" style="border:1px solid #ccc"></a></li>	
																			  <li><a href="#" class="alert-info"></a></li>
																			  <li><a href="#" class="alert-success"></a></li>
																			  <li><a href="#" class="alert-warning"></a></li>
																			  <li><a href="#" class="alert-danger"></a></li>
																			</ul>
																	  </div></div>
														';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-validation-text" style="z-index:100;">';
													$output .= '<div class="input_holder">';											
														$output .= '<label>Validate as: '.$lock.'</label>';
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
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-validation-text setting-validation-file-input">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Secondary message</label>';
														$output .= '<input id="set_secondary_error" type="text" value="" name="set_secondary_error" class="form-control">';
													$output .= '</div>';
												$output .= '</div>';
												
												
													
											
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition settings-validation">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Popup Position</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group error-position">
																		<button class="btn btn-default btn-primary top" type="button"><span class="glyphicon glyphicon-arrow-up"></span>&nbsp;&nbsp;Top</button>
																		<button class="btn btn-default  right" type="button"><span class="glyphicon glyphicon-arrow-right"></span>&nbsp;&nbsp;Right</button>
																		<button class="btn btn-default  bottom" type="button"><span class="glyphicon glyphicon-arrow-down"></span>&nbsp;&nbsp;Bottom</button>
																		<button class="btn btn-default  left" type="button"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Left</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											
											
											$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-text setting-textarea setting-validation-text setting-validation-textarea" style="">';
													$output .= '<div class="input_holder">';											
														$output .= '<label>Maximum Characters '.$lock.'</label>';
														$output .= '<div class="input-group"><input id="set_max_length" type="text" name="set_max_length" class="form-control">
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
											
/******************************************************************************************************************************/
//RADIO SETTINGS												
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-radio setting-image-select icons">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Icons</label>';
														$output .= '
														<div class="btn-group">
														<button type="button"  data-toggle="dropdown" class="btn btn-default">
														<span id="radio-icon" class="current-icon fa fa-check"></span>
														</button>
														<div class="btn-group">
														<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
														Selected&nbsp;Icon
														</button>
																	  
																	  <div role="menu" class="icon_set dropdown-menu">';
																		$output .= NEXForms_admin::show_icons();
														$output .= '</div></div></div></div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-radio setting-image-select icons selected-color">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Color</label>';
														
														
														$output .= '
														<div class="btn-group">
														<button type="button"  data-toggle="dropdown" class="btn btn-default radio-color-class colorpicker-element">
														<i class="btn-default"></i>
														</button>
														<div class="btn-group">
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
						$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-radio">';
									$output .= '<div class="input_holder">';											
										$output .= '<label>Radios</label>';
										$output .= '<textarea id="set_radios" name="set_radios" class="form-control"></textarea>';
									$output .= '</div>';
								$output .= '</div>';
						
								
						
						$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-image-select">';
									$output .= '<div class="input_holder">';											
										$output .= '<label>Thumbs</label>';
										$output .= '<textarea id="set_image_selection" name="set_image_selection" class="form-control"></textarea>';
									$output .= '</div>';
								$output .= '</div>';
						
						
						$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-image-select">';
									$output .= '<div class="input_holder ">';
														$output .= '<label>Thumb Size</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group thumb-size">
																		<button class="btn btn-default small" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Small</button>
																		<button class="btn btn-default  normal" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Normal</button>
																		<button class="btn btn-default  large" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;Large</button>
																		<button class="btn btn-default  xlarge" type="button"><span class="glyphicon glyphicon-font"></span>&nbsp;&nbsp;X-Large</button>
																	  </div>
																	</div>';
													$output .= '</div>';
								$output .= '</div>';
						
						
						$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-radio setting-image-select">';
							$output .= '<div class="input_holder ">';
								$output .= '<label>Label Color</label>';
								$output .= '<div id="radio-label-color" class="input-group colorpicker-component demo demo-auto">
												<span class="input-group-addon"><i></i></span>
												<input type="text" value="#000000" class="form-control" />
												<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
											</div>';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="row">';	
						$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-radio setting-image-select">';
							$output .= '<div class="input_holder ">';
								$output .= '<label>Background Color</label>';
								$output .= '<div id="radio-background-color" class="input-group colorpicker-component demo demo-auto">
												<span class="input-group-addon"><i></i></span>
												<input type="text" value="#FFF" class="form-control" />
												<span class="input-group-addon reset" data-default="#FFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
											</div>';
							$output .= '</div>';
						$output .= '</div>';
						
						$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-radio setting-image-select">';
							$output .= '<div class="input_holder ">';
								$output .= '<label>Border Color</label>';
								$output .= '<div id="radio-border-color" class="input-group colorpicker-component demo demo-auto">
												<span class="input-group-addon"><i></i></span>
												<input type="text" value="#CCCCCC" class="form-control" />
												<span class="input-group-addon reset" data-default="#CCCCCC"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
											</div>';
							$output .= '</div>';
						$output .= '</div>';
						
						$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-radio setting-image-select">';
							$output .= '<div class="input_holder ">';
								$output .= '<label>Display</label>';
								$output .= '<div role="toolbar" class="btn-toolbar">
											  <div class="btn-group display-radios-checks">
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
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-slider icons">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Dragicon</label>';
														$output .= '
														<div class="btn-group">
														<button type="button"  data-toggle="dropdown" class="btn btn-default">
														<span class="current-icon fa fa-check"></span>
														</button>
														<div class="btn-group">
														<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
															Handel&nbsp;Icon
														</button>
													    <div role="menu" class="icon_set dropdown-menu">';
														$output .= NEXForms_admin::show_icons();
														$output .= '</div></div></div></div>';
														$output .= '</div>';
														$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-slider icons selected-color">';
															$output .= '<div class="input_holder ">';											
																$output .= '<label>Color</label>';
														
														
														$output .= '
														<div class="btn-group">
														<button type="button"  data-toggle="dropdown" class="btn btn-default slider-color-class colorpicker-element">
														<i class="btn-default"></i>
														</button>
														<div class="btn-group">
														<button data-toggle="dropdown" class="btn btn-default slider-handel-color dropdown-toggle" type="button">
														Handel Color
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
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-slider">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Minimum value</label>';
															$output .= '<input type="text" name="minimum_value" id="minimum_value" class="form-control" />';
														$output .= '</div>';
													$output .= '</div>';
												
												
												
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Maximum value</label>';
														$output .= '<input type="text" name="maximum_value" id="maximum_value" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Starting value</label>';
														$output .= '<input type="text" name="start_value" id="start_value" class="form-control" />';
													$output .= '<span class="help-block">&nbsp;</span></div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-slider">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Step value</label>';
															$output .= '<input type="text" name="step_value" id="step_value" class="form-control" />';
														$output .= '</div>';
													$output .= '</div>';
												
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-slider">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Count Text</label>';
															$output .= '<div class="input-group">';
															$output .= '<input type="text" name="count_text" id="count_text" class="form-control" />';
														 //   $output .= '<span class="input-group-addon count-text-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															//$output .= '<span class="input-group-addon count-text-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div><span class="help-block">Use {x} for count value substitution. HTML enabled.</span>';
															
														$output .= '</div>';
													$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-slider">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Handel Text Color</label>';
															$output .= '<div id="slide-handel-text-color" class="input-group colorpicker-component demo demo-auto">
																			<span class="input-group-addon"><i></i></span>
																			<input type="text" value="#000000" class="form-control" />
																			<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																		</div>';
														$output .= '</div>';
													$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Handel Background Color</label>';
														$output .= '<div id="slider-handel-background-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Handel Border Color</label>';
														$output .= '<div id="slider-handel-border-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#CCCCCC" class="form-control" />
																		<span class="input-group-addon reset" data-default="#CCCCCC"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Slider Border Color</label>';
														$output .= '<div id="slider-border-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#CCCCCC" class="form-control" />
																		<span class="input-group-addon reset" data-default="#CCCCCC"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Color</label>';
														$output .= '<div id="slider-background-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Fill Color</label>';
														$output .= '<div id="slider-fill-color" class="input-group colorpicker-component demo demo-auto">
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
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-star">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Total Stars</label>';
														$output .= '<input type="text" name="total_stars" id="total_stars" class="form-control">';
														$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-star">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Enable Half Stars</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
															  <div class="btn-group enable-half-star">
																<button class="btn btn-default yes" type="button"><span class="fa fa-star-half-o"></span>&nbsp;&nbsp;Yes</button>
																<button class="btn btn-default  btn-primary no" type="button"><span class="fa fa-star"></span>&nbsp;&nbsp;No</button>
															  </div>
															</div>';
														$output .= '</div>';
												$output .= '</div>';
																	
										$output .= '</div>';


/******************************************************************************************************************************/
//SPINNER SETTINGS												
											$output .= '<div class="row">';
												//down arrow
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-spinner icons" style="z-index:1000001 !important;">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Touch Down Icon</label>';
														$output .= '
														<div class="btn-group">
														<button type="button"  data-toggle="dropdown" class="btn btn-default">
														<span id="down-icon" class="current-icon fa fa-check"></span>
														</button>
														<div class="btn-group">
														<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
															Icon
														</button>
													    <div role="menu" class="icon_set down_icon dropdown-menu">';
														$output .= NEXForms_admin::show_icons();
														$output .= '</div></div></div></div>';
														$output .= '</div>';
														$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-spinner icons selected-color" style="z-index:1000000 !important;">';
															$output .= '<div class="input_holder ">';											
																$output .= '<label>Color</label>';
														
														
														$output .= '
														<div class="btn-group">
														<button type="button"  data-toggle="dropdown" class="btn btn-default spinner-down colorpicker-element">
														<i class="btn-default"></i>
														</button>
														<div class="btn-group">
														<button data-toggle="dropdown" class="btn btn-default down_icon dropdown-toggle" type="button">
														Color
														</button><ul class="dropdown-menu spinner-down-color">
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
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-spinner icons">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Touch Up Icon</label>';
														$output .= '
														<div class="btn-group">
														<button type="button"  data-toggle="dropdown" class="btn btn-default">
														<span id="up-icon" class="current-icon fa fa-check"></span>
														</button>
														<div class="btn-group">
														<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
															Icon
														</button>
													    <div role="menu" class="icon_set up_icon dropdown-menu">';
														$output .= NEXForms_admin::show_icons();
														$output .= '</div></div></div></div>';
														$output .= '</div>';
														$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-spinner icons selected-color">';
															$output .= '<div class="input_holder ">';											
																$output .= '<label>Color</label>';
														
														
														$output .= '
														<div class="btn-group">
														<button type="button"  data-toggle="dropdown" class="btn btn-default spinner-up colorpicker-element">
														<i class="btn-default"></i>
														</button>
														<div class="btn-group">
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
												
												
												
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-spinner">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Minimum value</label>';
															$output .= '<input type="text" name="spin_minimum_value" id="spin_minimum_value" class="form-control" />';
														$output .= '</div>';
													$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-spinner">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Maximum value</label>';
														$output .= '<input type="text" name="spin_maximum_value" id="spin_maximum_value" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-spinner">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Starting value</label>';
														$output .= '<input type="text" name="spin_start_value" id="spin_start_value" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-spinner">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Step value</label>';
														$output .= '<input type="text" name="spin_step_value" id="spin_step_value" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-spinner">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Decimal places</label>';
														$output .= '<input type="text" name="spin_decimal" id="spin_decimal" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
																	
										$output .= '</div>';

												
												
											
/******************************************************************************************************************************/
//TAG SETTINGS												
											$output .= '<div class="row">';
												
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-tags">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Maximum Tags</label>';
														$output .= '<input type="text" name="max_tags" id="max_tags" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-tags">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Color</label>';
															$output .= '<div id="tags-text-color" class="input-group colorpicker-component demo demo-auto">
																			<span class="input-group-addon"><i></i></span>
																			<input type="text" value="#000000" class="form-control" />
																			<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																		</div>';
														$output .= '</div>';
													$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-tags">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Color</label>';
														$output .= '<div id="tags-background-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 isotope-item isotope-hidden no-transition setting-tags">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Border Color</label>';
														$output .= '<div id="tags-border-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#CCCCCC" class="form-control" />
																		<span class="input-group-addon reset" data-default="#CCCCCC"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
											$output .= '</div>';		
										$output .= '</div>';				
                    
                  					$output .= '</div> <!-- #isotope_container -->';
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
		
		$lock = '&nbsp;&nbsp;<span title="" data-toggle="tooltip" data-placement="bottom" class="bs-tooltip fa fa-lock text-danger" data-original-title="This feature is locked! Click on \'Upgade to Pro\' top right to activate.">&nbsp;</span>';
		$lock2 = '&nbsp;&nbsp;<span title="" data-toggle="tooltip" data-placement="bottom" class="bs-tooltip fa fa-lock" data-original-title="This feature is locked! Click on \'Upgade to Pro\' top right to activate.">&nbsp;</span>';
		
		$output .= '<div id="site_url" class="site_url" style="display:none;">'.get_option('siteurl').'</div>';
		$output .= '<div class="db_details" style="display:none;">';
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
					<div class="plugin_url" style="display:none;">'.WP_PLUGIN_URL.'/nex-forms</div>';
		//NEX ATTR
		$output .= '<div class="nex_form_attr" style="display:none;"></div>';
		
		
		
		$output .= '<div id="nex-forms"><div class="modal fade" data-backdrop="static"  id="express_msg" data-show="true" style="z-index:10010 !important;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header btn-primary">
								<h4 class="modal-title" id="myModalLabel">Thank you for downloading NEX-Forms Express version 3.4</h4>
							  </div>
							  <div class="modal-body">
							  <div class="alert alert-danger"><strong>PLEASE NOTE:</strong> This express version is missing features and settings respresented by a '.$lock.' and are only available in the pro version</div>
								<br />
								<div class="alert alert-success"><h2>Why Go Pro?</h2><br />
								<ul>
									<li><span class="fa fa-check text-success">&nbsp;</span>&nbsp;&nbsp;Enable form data in e-mails</li>
									<li><span class="fa fa-check text-success">&nbsp;</span>&nbsp;&nbsp;Enable anti-spam control</li>
									<li><span class="fa fa-check text-success">&nbsp;</span>&nbsp;&nbsp;Enable view and export of form entry data</li>
									<li><span class="fa fa-check text-success">&nbsp;</span>&nbsp;&nbsp;Enable user confirmation e-mails</li>
									<li><span class="fa fa-check text-success">&nbsp;</span>&nbsp;&nbsp;Get FREE online support</li>
									<li><span class="fa fa-check text-success">&nbsp;</span>&nbsp;&nbsp;Get FREE item updates for life</li>
								</ul>
								</div>
								<br />
								<div class="alert alert-info"><h2>Express and Pro version add-ons</h2><br />
								<p alert alert-info><strong>NOTE: </strong>Add-ons are available for this express version as well as the pro version!</p><br />
								';								
								
								$output .= '<div class="dashboard_wrapper">';
									$output .= '<div class="item_logo "><a href="http://codecanyon.net/item/form-themes-for-nexforms/10037800?ref=Basix" target="_blank"><img width="80" height="80" border="0" title="" src="http://basixonline.net/add-ons/themes/logo.jpg" ></a><div class="cover_image"><img src="http://basixonline.net/add-ons/themes/cover.png" itemprop="image" alt="Form Themes for NEX-Forms - CodeCanyon Item for Sale"></div></div>';
									$output .= '<div class="item_logo "><a href="http://codecanyon.net/item/export-to-pdf-for-nexforms/11220942?ref=Basix" target="_blank"><img width="80" height="80" border="0" title="" src="http://basixonline.net/add-ons/pdf/logo.jpg" ></a><div class="cover_image"><img src="http://basixonline.net/add-ons/pdf/cover.png" itemprop="image" alt="Export to PDF for NEX-Forms - CodeCanyon Item for Sale"></div></div>';
								$output .= '<div style="clear:both;"></div>';
									
								$output .= '</div></div>';
								
								$output .= '
							  </div>
							  <div class="modal-footer align_center">
								<a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix" class="btn btn-sm btn-success">Go pro for a one time purchase of only $33</a><br /><br />
								<a href="http://codecanyon.net/item/form-themes-for-nexforms/10037800?ref=Basix" class="btn btn-sm btn-warning">Get Form Themes add-on for a one time purchase of only $12</a><br /><br />
								<a href="http://codecanyon.net/item/export-to-pdf-for-nexforms/11220942?ref=Basix" class="btn btn-sm btn-warning">Get Export to PDF add-on for a one time purchase of only $10</a><br /><br />
								
								<button type="button" class="btn btn-default btn-sm use_express" data-dismiss="modal" data-form-id="">Use Express Version</button>
							  </div>
							  
							  
							 
							</div>
						  </div>
						</div>';
		$output .= '<button type="button" class="btn btn-sm btn-primary express_msg hidden" data-toggle="modal" data-backdrop="static" data-target="#express_msg">&nbsp;</button></div>';
		
		
		//Welcome Message
		$output .= '<div id="nex-forms"><div class="modal fade" data-backdrop="static"  id="welcomeMessage" data-show="true" style="z-index:10000 !important;">
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
									  <div class="list-group saved_calendars">
									  <span class="fa fa-refresh fa-spin"></span>&nbsp;&nbsp;Loading Forms...
									  </div>
							  
							  
							 
							</div>
						  </div>
						</div>';
		$output .= '<button type="button" class="btn btn-sm btn-primary show_welcome_message hidden" data-toggle="modal" data-backdrop="static" data-target="#welcomeMessage">&nbsp;</button></div>';
		
		
		//Edit Calendar
		$output .= '<div class="modal fade" id="editCalendar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:10001 !important;">
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
		$output .= '<div class="modal fade" id="calendarSettings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:10001 !important;">
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
		$output .= '<div class="modal fade" id="useCalendar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:10001 !important;">
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
									
									<div class="alert alert-warning"><span class="fa fa-info-circle"></span>&nbsp;&nbsp;Change the text "Open Form" to your desire</div>
									<div class="alert alert-info"><span class="fa fa-info-circle"></span>&nbsp;&nbsp;You can also use the tinyMCE editor button to generate this shortcode</div>

									
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
										 
										<div class="alert alert-warning"><span class="fa fa-info-circle"></span>&nbsp;&nbsp;Change the text "Open Form" to your desire</div>
										<div class="alert alert-info"><span class="fa fa-info-circle"></span>&nbsp;&nbsp;To return (not echo) the value change true to false</div>
										 
									 <h3>Widget</h3>
									Go to Appearance->Widgets and drag the NEX-Forms widget into the desired sidebar. You will be able to select this calendar from the dropdown options. 
									
									 
									 
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
		$output .= '<div class="modal fade" id="deleteCalendar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:10001 !important;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-danger">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Confirm Form Deletion</h4>
							  </div>
							  <div class="modal-body">
								Are you sure you want to delete calendar<strong><span class="get_calendar_title"></span></strong>?
							  </div>
							  <div class="modal-footer align_center">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="button" class="btn btn-danger do_delete" data-dismiss="modal" data-table="" data-id="">Yes, delete permanantly</button>
							  </div>
							</div>
						  </div>
						</div>';
						
		
	
		
		
		
		//MAKE MONEY
		$output .= '<div class="modal fade" id="makeMoney" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
		$output .= '<div class="modal fade" id="previewForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:1000000000 !important;">
						  <div class="modal-dialog preview-modal">
							<div class="modal-content">
							  <div class="modal-header alert alert-info">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;Preview <span class="get_form_title"></span></h4>
								<span class="btn btn-info change_device full"><span class="glyphicon fa fa-arrows-alt"></span></span>
								<span class="btn btn-info change_device desktop"><span class="glyphicon fa fa-desktop"></span></span>
								<span class="btn btn-info change_device laptop"><span class="glyphicon fa fa-laptop"></span></span>
								<span class="btn btn-info change_device tablet"><span class="glyphicon fa fa-tablet"></span></span>
								<span class="btn btn-info change_device mobile"><span class="glyphicon fa fa-mobile-phone"></span></span>
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
								<button type="button" class="btn btn-success" data-dismiss="modal" data-form-id="">Done</button>
							  </div>
							</div>
						  </div>
						</div>';
		
		//DELETE CONFIRM
		$output .= '<div class="modal fade" id="animationSettings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-warning">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Form Animation Settings</h4>
							  </div>
							  <div class="modal-body">
								  <div class="row">	
								  	<div class="controls col-sm-6" >
										<label>Run form drawing Animation?</label>
										<div class="btn-group animate_form">
											<button class="btn btn-default btn-sm yes" type="button"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;Yes</button>
											<button class="btn btn-default btn-sm no btn-primary" type="button">&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>&nbsp;&nbsp;No</button>
										  </div>
									    </div>
									<div class="controls col-sm-6" >
										<label><span class="glyphicon glyphicon-time"></span>&nbsp;&nbsp;Animation Time (in seconds)</label>
										<div class="btn-group animate_time">
											<button class="btn btn-default btn-sm 30_frames" type="button">0.5</button>
											<button class="btn btn-default btn-sm 60_frames btn-primary" type="button">1</button>
											<button class="btn btn-default btn-sm 90_frames" type="button">1.5</button>
											<button class="btn btn-default btn-sm 120_frames" type="button">2</button>
											<button class="btn btn-default btn-sm 150_frames" type="button">2.5</button>
											<button class="btn btn-default btn-sm 180_frames" type="button">3</button>
										  </div>
									    </div>
								  </div>
							  </div>
							  <div class="modal-footer align_center">
								<button type="button" class="btn btn-success" data-dismiss="modal" data-form-id="">Done</button>
							  </div>
							</div>
						  </div>
						</div>';
		
		
		//NEX CONTAINER
		$output .= '<div id="nex-forms"><div class="form_update_id hidden"></div><link href="'.plugins_url('/nex-forms-express-wp-form-builder/css/font-awesome.min.css').'" rel="stylesheet">';
		
			
			
			$output .= '<div class="top-strip">';
			
				$output .= '<div class="row">';
					$output .= '<div class="controls col-sm-12" >';
								$output .= '<div class="row">';
									$output .= '<div class="col-sm-12" >';
									
									$output .= '<div class="btn-group bootstro" data-bootstro-title="Preview forms" data-bootstro-content="Click here to preview your form at any stage in your progress. Click the different devices to see how the form will behave on smaller and larger screens" data-bootstro-placement="bottom" data-bootstro-step="2">
											 
											  <button type="button" class="btn btn-sm btn-info dropdown-toggle tab_view" data-toggle="dropdown">
												<span class="glyphicon glyphicon-fire"></span>&nbsp;&nbsp;NEX-Forms
											  </button>
											  <ul class="dropdown-menu" role="menu">
												<!--<li><a href="#" class="tutorial"><i class="glyphicon glyphicon-comment"></i>&nbsp;&nbsp;Tutorial<br /><em><small>Using this builder</small></em></a></li>-->
												<li><a href="'.WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/documentation/index.html" target="_blank"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;&nbsp;Documentation<br /><em><small>All you need to know</small></em></a></li>
												<li><a href="http://basix.ticksy.com" target="_blank"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Support<br /><em><small>Let us help you</small></em></a></li>
												<li><a href="http://codecanyon.net/user/Basix/portfolio" target="_blank"><i class="glyphicon glyphicon-link"></i>&nbsp;&nbsp;Visit Basix<br /><em><small>Check out more items</small></em></a></li>
											  </ul>
											</div>';
									
									
									$output .= '<div class="btn-group bootstro" id="new_form" data-bootstro-title="Create a new form" data-bootstro-content="Click this button to start a blank form. If you have saved templates you can load them from this dropdown menu." data-bootstro-placement="bottom" data-bootstro-step="0">
											  <button type="button" class="btn btn-sm  btn-primary" data-toggle="modal" data-target="#welcomeMessage" ><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Form Manager</button>
											 
											</div>';
											
									
									$output .= '<div class="btn-group bootstro" data-bootstro-title="Save your form" data-bootstro-content="Click here to save your form. Click on the arrow to save your form as a template or to be used as both" data-bootstro-placement="bottom" data-bootstro-step="4">
											  <button type="button" class="btn btn-sm btn-success form_preview" id="save_nex_form"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Save Form</button>
											  <!--<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											  </button>
											  <ul class="dropdown-menu" role="menu">
												<li class="disabled"><a href="#">Save as template:</a></li>
												<li class="divider"></li>
												<li><a href="#" id="save_nex_form"  class="template_only">Template only</a></li>
												<li><a href="#" id="save_nex_form"  class="form_and_template">Form and Template</a></li>
											  </ul>-->
											</div>';		
									
									
									$output .= '<a href="#" class="visible_form_title btn-group"></a>';
									
									$output .= '</div>';
									
								$output .= '</div>';
						$output .= '</div>';					
				$output .= '</div>';
					
				$output .= '</div>';
			$output .= '<div style="clear:both;"></div>';
			
			
			
			$output .= '<div class="row admin-layout alert-info">';
			
			
			
			$output .= '<div class="col-sm-12 admin-layout">';
				
				
				$output .= '<div class="colmask rightmenu forms-canvas">';
					$output .= '<div class="colleft">';
						$output .= '<div class="col1 bootstro" data-bootstro-title="Form Elements" data-bootstro-content="Find all you need to create forms in this menu. Simply click or drag an element from here to the open space on the right." data-bootstro-placement="right" data-bootstro-step="7">';
							
						$output .= '<div class="clonable">';
					
					
						
/****************************************************/	
/****************************************************/
/*******************DROPPABLES **********************/	
/****************************************************/
/****************************************************/					
								
						
						
						$output .= '<ul id="available_fields" class="nav nav-tabs label-primary" role="tablist">
							  <li class="active"><a href="#" data-option-value=".form_field" class="input-element bs-tooltip" title="Show all fields"			data-placement="right"><span class="glyphicon fa fa-reply-all"></span></a></li>	
							  <li><a href="#" data-option-value=".custom-fields" 			 class="input-element bs-tooltip" title="Action fields" 			data-placement="bottom"><span class="glyphicon fa fa-play"></span></a></li>
							  <li><a href="#" data-option-value=".grid-system" 				 class="input-element bs-tooltip" title="Grid System"				data-placement="bottom"><span class="glyphicon glyphicon-th" ></span></a></li>
							  <li><a href="#" data-option-value=".common-fields" 			 class="input-element bs-tooltip" title="Common Fields" 			data-placement="bottom"><span class="glyphicon fa fa-bars" ></span></a></a></li>
							  <li><a href="#" data-option-value=".extended-fields" 			 class="input-element bs-tooltip" title="Extended Fields" 			data-placement="bottom"><span class="glyphicon fa fa-thumbs-o-up"></span></a></li>
							  <li><a href="#" data-option-value=".uploader-fields"  		 class="input-element bs-tooltip" title="Uploaders" 				data-placement="bottom"><span class="glyphicon fa fa-cloud-upload"></span></a></li>
							  <li><a href="#" data-option-value=".other-elements"  			 class="input-element bs-tooltip" title="Other Elements" 			data-placement="bottom"><span class="glyphicon fa fa-bolt"></span></a></li>
							</ul>';
/****************************************************/	
/****************************************************/							
	//GRID SYSTEM
								//
								$output .= '<h4 class="current_field_selection">&nbsp;&nbsp;All Fields</h4><hr>';
								
								
								$output .= '<div class="field form_field custom-fields grid step" style="width:99%">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-warning btn-sm form-control" style="background:#563d7c; border:1px solid #563d7c;"><i class=" fa fa-fast-forward"></i>&nbsp;&nbsp;<span class="field_title">Add Step</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input-inner" data-svg="demo-input-1">';
												$output .= '<div class="row">';
													$output .= '<div class="col-sm-12">';
														$output .= '<div class="tab-pane grid-system grid-system panel panel-default"><div class="zero-clipboard"><span class="btn-clipboard btn-clipboard-hover">Step&nbsp;<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div></span></div>';
															$output .= '<div class="panel-body">';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								$output .= '<div class="field form_field custom-fields submit-button" style="width:33%">';
									$output .= '<div class="draggable_object input-group-sm ">';
										$output .= '<div class="btn btn-warning btn-sm form-control"><i class=" fa fa-step-forward"></i>&nbsp;&nbsp;<span class="field_title">Next Step</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																		$output .= '<div class="nex-step the_input_element btn btn-primary">Next</div>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								$output .= '<div class="field form_field custom-fields submit-button" style="width:33%">';
									$output .= '<div class="draggable_object input-group-sm ">';
										$output .= '<div class="btn btn-warning btn-sm form-control"><i class=" fa fa-step-backward"></i>&nbsp;&nbsp;<span class="field_title">Prev Step</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
											
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																		$output .= '<div class="prev-step the_input_element btn btn-primary">Prev</div>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
														
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								$output .= '<div class="field form_field custom-fields submit-button" style="width:33%">';
									$output .= '<div class="draggable_object input-group-sm ">';
										$output .= '<div class="btn btn-warning available btn-sm form-control"><i class=" glyphicon glyphicon glyphicon-send"></i>&nbsp;&nbsp;<span class="field_title">Submit Button</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																		$output .= '<button class="nex-submit svg_ready the_input_element btn btn-primary">Submit</div><br />
																		<small class="svg_ready"><a href="http://codecanyon.net/user/Basix/portfolio?ref=Basix" target="_blank"></a></small>';
																	$output .= '</button>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
								
								
								
								$output .= '<div style="clear:both"></div>';
								// 1 Column
								$output .= '<div class="field form_field grid grid-system">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-primary btn-sm form-control">1 Col</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input-inner" data-svg="demo-input-1">';
												$output .= '<div class="row">';
													$output .= '<div class="input_holder col-sm-12">';
														$output .= '<div class="panel grid-system grid-system panel-default">';
															$output .= '<div class="panel-body">';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															//$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								//2 Columns
								$output .= '<div class="field form_field grid grid-system">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-primary btn-sm form-control">2 Cols</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
												$output .= '<div class="input-inner" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="input_holder col-sm-6">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="input_holder col-sm-6">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															//$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								$output .= '<div class="field form_field grid grid-system">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-primary btn-sm form-control">3 Cols</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
												$output .= '<div class="input-inner" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="input_holder col-sm-4">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="input_holder col-sm-4">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="input_holder col-sm-4">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															//$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								$output .= '<div class="field form_field grid grid-system">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-primary btn-sm form-control">4 Cols</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
												$output .= '<div class="input-inner" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="input_holder col-sm-3">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-3">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-3">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-3">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
														//	$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								$output .= '<div class="field form_field grid grid-system">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-primary btn-sm form-control">6 Cols</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
												$output .= '<div class="input-inner" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="input_holder col-sm-2">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-2">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-2">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-2">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-2">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-2">';
															$output .= '<div class="panel grid-system panel-default">';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															//$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
											$output .= '</div>';	
									$output .= '</div>';
								$output .= '</div>';			
											
							$output .= '<div style="clear:both"></div>';	
								
						
								
						//TEXT FIELD
								$output .= '<div class="field form_field common-fields text">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control available"><i class=" glyphicon glyphicon-minus"></i>&nbsp;&nbsp;<span class="field_title">Text Field</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Text Field</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																		$output .= '<input id="ve_text" type="text" name="text_field" placeholder="Text Field" data-maxlength-color="label label-success" data-maxlength-position="bottom" data-maxlength-show="false" data-default-value="" maxlength="200" class="error_message svg_ready the_input_element text pre-format form-control" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" data-secondary-message="" title="">';
																		$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';								
								
						//TEXT AREA
								$output .= '<div class="field form_field common-fields textarea">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn available btn-info btn-sm form-control"><i class=" glyphicon glyphicon-align-justify"></i>&nbsp;&nbsp;<span class="field_title">Text Area</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Text Area</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<textarea name="textarea" id="textarea" placeholder="Text Area"  data-maxlength-color="label label-success" data-maxlength-position="bottom" data-maxlength-show="false" data-default-value="" class="error_message svg_ready the_input_element textarea pre-format form-control" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title=""></textarea>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
						
								
								
						//SELECT
								$output .= '<div class="field form_field common-fields select">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;<span class="field_title">Select</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Select</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
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
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';							
						
								//MULTI SELECT
								$output .= '<div class="field form_field common-fields multi-select">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-sort-by-attributes-alt"></i>&nbsp;&nbsp;<span class="field_title">Multi-Select</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Multi Select</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
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
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
								
						
						//RADIO BUTTONS
							$output .= '<div class="field form_field common-fields radio-group">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-ok-circle"></i>&nbsp;&nbsp;<span class="field_title">Radio Buttons</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Radio Group</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10 the-radios error_message" id="the-radios" data-checked-color="" data-checked-class="fa-check" data-unchecked-class="" data-placement="bottom" data-content="Please select one" title="" >';
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
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
													$output .= '</div>';
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
								

						
						//CHECK BOXES
							$output .= '<div class="field form_field common-fields check-group">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class=" glyphicon glyphicon-check"></i>&nbsp;&nbsp;<span class="field_title">Check Boxes</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder radio-group no-pre-suffix">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Checbox Group</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10 the-radios error_message" id="the-radios" data-checked-color="alert-success" data-checked-class="fa-check" data-unchecked-class="" data-placement="bottom" data-content="Please select one" title="" >';
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
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											
										$output .= '</div>';	
								$output .= '</div>';			
					
					
					
					
					//SINGLE IMAGE BUTTONS
							$output .= '<div class="field form_field uploader-fields single-image-select-group">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="fa fa-image"></i>&nbsp;&nbsp;<span class="field_title">Single select image</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">
									';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Radio Group</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10 the-radios error_message" id="the-radios" data-checked-color="" data-checked-class="fa-check" data-unchecked-class="" data-placement="bottom" data-content="Please select one" title="" >';
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
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="fa fa-image"></i>&nbsp;&nbsp;<span class="field_title">Multi select image</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">
									';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Check Group</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10 the-radios error_message" id="the-radios" data-checked-color="" data-checked-class="fa-check" data-unchecked-class="" data-placement="bottom" data-content="Please select one" title="" >';
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
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
													$output .= '</div>';
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
					
					
					
					//CUSTOM PREFIX
								$output .= '<div class="field form_field custom-prefix common-fields" >';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="glyphicon fa fa-arrow-left"></i>&nbsp;&nbsp;<span class="field_title">Icon Before</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Custom field</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date">';
																$output .= '<span class="input-group-addon prefix"><span class="glyphicon"></span></span>';
																$output .= '<input type="text" class="error_message  form-control the_input_element bs-tooltip" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message=""/>';
																$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Custom field</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group">';
															
															$output .= '<input type="text" class="error_message form-control the_input_element bs-tooltip" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message="" />';
															$output .= '<span class="input-group-addon postfix"><span class="glyphicon"></span></span>';
															$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Custom field</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date">';
															$output .= '<span class="input-group-addon prefix"><span class="glyphicon"></span></span>';
															$output .= '<input type="text" class="error_message form-control the_input_element bs-tooltip" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message="" />';
															$output .= '<span class="input-group-addon postfix"><span class="glyphicon"></span></span>';
															$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
													$output .= '</div>';												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';					
					
						
					$output .= '<div style="clear:both"></div>'; 		
						
//EXTENDED						
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
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Star Rating</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<div id="star" data-total-stars="5" data-enable-half="false" class="error_message svg_ready bs-tooltip" style="cursor: pointer;" data-placement="bottom" data-content="Please select a star" title=""></div>';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Slider</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<div class="error_message slider svg_ready" id="slider" data-fill-color="#f2f2f2" data-min-value="0" data-max-value="100" data-starting-value="0" data-background-color="#ffffff" data-slider-border-color="#CCCCCC" data-handel-border-color="#CCCCCC" data-handel-background-color="#FFFFFF" data-text-color="#000000" data-dragicon="" data-dragicon-class="btn btn-default" data-count-text="{x}"  data-placement="bottom" data-content="Please select a value" title=""></div>';
																	$output .= '<input name="slider" class="hidden the_input_element the_slider" type="text">';
																	$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Spinner</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<input name="spinner" type="text" id="spinner" class="error_message the_spinner svg_ready the_input_element form-control bs-tooltip" data-minimum="0" data-maximum="100" data-step="1" data-starting-value="0" data-decimals="0"  data-postfix-icon="" data-prefix-icon="" data-postfix-text="" data-prefix-text="" data-postfix-class="btn-default" data-prefix-class="btn-default" data-down-icon="fa fa-minus" data-up-icon="fa fa-plus" data-down-class="btn-default" data-up-class="btn-default" data-placement="bottom" data-content="Please supply a value" title="" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" />';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Tags</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<input id="tags" value="" name="tags" type="text" class="tags error_message bs-tooltip the_input_element" data-max-tags="" data-tag-class="label-info" data-tag-icon="fa fa-tag" data-border-color="#CCCCCC" data-background-color="#FFFFFF" data-placement="bottom" data-content="Please enter a value" title="">';
																
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Auto Complete</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<input id="autocomplete" value="" name="autocomplete" type="text" class="error_message svg_ready form-control bs-tooltip the_input_element" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-text-color="#000000" data-border-color="#CCCCCC" data-background-color="#FFFFFF" data-placement="bottom" data-content="Please enter a value" title="">';
																$output .= '<div style="display:none;" class="get_auto_complete_items"></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Color Pallet</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<div class="svg_ready input-group">
																			<span data-toggle="dropdown" class="input-group-addon color-select"><span class="caret"></span></span>
																				  <ul class="dropdown-menu">
																					<li><div id="colorpalette"></div></li>
																				  </ul>
																				  <input type="text" id="selected-color" value="" name="color_pallet"  type="text" class="svg_ready error_message form-control bs-tooltip the_input_element" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please select a color" title="">
																			</div>
																			 ';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Date Time</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date" id="datetimepicker" data-format="MM/DD/YYYY hh:mm A" data-language="en">';
															$output .= '<span class="input-group-addon prefix"><span class="glyphicon glyphicon-calendar"></span></span>';
															$output .= '<input type="text" class="error_message form-control the_input_element bs-tooltip" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please select a date and time" title="" />';
															$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Date</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date" id="datetimepicker" data-format="MM/DD/YYYY" data-language="en">';
																$output .= '<span class="input-group-addon prefix"><span class="glyphicon glyphicon-calendar"></span></span>';
																$output .= '<input type="text" class="error_message form-control the_input_element bs-tooltip" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please select a date" title="" />';
																$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Time</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date" id="datetimepicker" data-format="hh:mm A" data-language="en">';
															$output .= '<span class="input-group-addon prefix"><span class="fa fa-clock-o"></span></span>';
															$output .= '<input type="text" class="error_message form-control the_input_element bs-tooltip" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please select a time" title="" />';
															$output .= '</div></div>';
																$output .= '<span class="help-block hidden">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
						
						
						
						
//UPLAODERS

$output .= '<div style="clear:both"></div>'; 						
						
						//PASSWORD FIELD
								$output .= '<div class="field form_field common-fields text">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-info btn-sm form-control"><i class="fa fa-key"></i>&nbsp;&nbsp;<span class="field_title">Password Field</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Password</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																		$output .= '<input id="ve_text" type="password" name="text_field" data-maxlength-color="label label-success" data-maxlength-position="bottom" data-maxlength-show="false" data-default-value="" maxlength="200" class="error_message svg_ready the_input_element text pre-format form-control" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" data-secondary-message="" title="">';
																		$output .= '<span class="help-block hidden">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';		
						//SINGLE FILE
								$output .= '<div class="field form_field upload-single common-fields">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-success btn-sm form-control"><i class="glyphicon glyphicon-file"></i>&nbsp;&nbsp;<span class="field_title">File Upload</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">File Upload</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
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
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>&nbsp;';
								
								
								
								//IMAGE
								$output .= '<div class="field form_field upload-image common-fields">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-success btn-sm form-control"><i class="glyphicon glyphicon-picture"></i>&nbsp;&nbsp;<span class="field_title">Image Upload</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="nexf_title" class="nexf_title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Image Upload</span><br /><small class="sub-text style_italic"></small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
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
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
						
										
						
//OTHER ELEMENTS

$output .= '<div style="clear:both"></div>'; 						
						
				//Panel
								$output .= '<div class="field form_field grid other-elements">';
									$output .= '<div class="draggable_object input-group-sm">';
										$output .= '<div class="btn btn-default btn-sm form-control"><i class="fa fa-square-o"></i>&nbsp;&nbsp;Panel</div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input-inner" data-svg="demo-input-1">';
												$output .= '<div class="row">';
													$output .= '<div class="input_holder col-sm-12">';
														$output .= '<div class="panel panel-default ">';
															$output .= '<div class="panel-heading">Column</div>';
															$output .= '<div class="panel-body">';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
										$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
											$output .= '<div class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></div>';
											$output .= '<div class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></div>';
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
																$output .= '<div class="input-group date svg_ready">';
																	$output .= '<p class="the_input_element">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p><div style="clear:both;"></div>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
																$output .= '<div class="input-group date svg_ready">';
																	$output .= '<p class="the_input_element">Add HTML</p><div style="clear:both;"></div>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
										$output .= '<div class="btn btn-default btn-sm form-control"><span class="field_title">H1</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready">';
																	$output .= '<h1 class="the_input_element"><span id="heading_icon" class=""></span>Heading 1</h1>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
										$output .= '<div class="btn btn-default btn-sm form-control"><span class="field_title">H2</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready">';
																	$output .= '<h2 class="the_input_element"><span id="heading_icon" class=""></span>Heading 2</h2>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
										$output .= '<div class="btn btn-default btn-sm form-control"><span class="field_title">H3</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready">';
																	$output .= '<h3 class="the_input_element"><span id="heading_icon" class=""></span>Heading 3</h3>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
										$output .= '<div class="btn btn-default btn-sm form-control"><span class="field_title">H4</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready">';
																	$output .= '<h4 class="the_input_element"><span id="heading_icon" class=""></span>Heading 4</h4>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
										$output .= '<div class="btn btn-default btn-sm form-control"><span class="field_title">H5</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready">';
																	$output .= '<h5 class="the_input_element"><span id="heading_icon" class=""></span>Heading 5</h5>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
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
										$output .= '<div class="btn btn-default btn-sm form-control"><span class="field_title">H6</span></div>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready">';
																	$output .= '<h6 class="the_input_element"><span id="heading_icon" class=""></span>Heading 6</h6>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<div class="btn btn-info btn-sm edit "   title="Edit Field Attributes"><i class="glyphicon glyphicon-pencil"></i></div>';
															$output .= '<div class="btn btn-danger btn-sm delete " title="Delete field"><i class="glyphicon glyphicon-remove"></i></div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';		
						
						
						
				
					
				
				
				
				
				
				
			
			//PANELS
			
						
			
			
			
			
							
			//CLIPBOARD
			/*				$output .= '<div class="panel-heading  bootstro" data-bootstro-title="The Clipboard" data-bootstro-content="After a field has been created to perfection you can add it to the clipboard to be used in a different form as well! Click on the clipboard icon while editing a field to see it here." data-bootstro-placement="right" data-bootstro-step="14">';
								$output .= '<h4 class="panel-title " style="background-color:#5BC0DE !important;color:#FFF;">';
									$output .= '<a data-toggle="collapse" href="#collapseclipboard">';
									$output .= '<span class="glyphicon fa fa-clipboard"></span>&nbsp;&nbsp;Clipboard<span class="caret"></span><br /><em><small style="color:#FFF;">Reusable fields</small></em>';
									$output .= '</a>';
								$output .= '</h4>';
							$output .= '</div>';
							$output .= '<div id="collapseclipboard" class="panel-collapse in">';
								$output .= '<div class="panel-body clip-board">';
							//.panel-body	
							$output .= '</div>';
						$output .= '</div>';*/
							
							
					$output .= '</div>';
								
							$output .= '</div>';
							
							
							$output .= '<div class="col2">';
						
							$output .= NEXForms_admin::NEXForms_field_settings();
								$output .= '<div class="panel panel-default admin-panel">';
								$output .= '<ul id="canvas_view" class="nav nav-tabs alert-info" >
											  <li class="active">
												  <a href="#" class="form_canvas"><span class="glyphicon fa fa-wrench"></span>&nbsp;&nbsp;Form Canvas&nbsp;&nbsp;<button class="btn btn-primary btn-xs bs-tooltip preview_form" data-placement="bottom" data-target="#previewForm" data-toggle="modal" title="" data-original-title="Preview Form"><span class="fa fa-eye"></span>&nbsp;Preview</button></a></li> 
											  <li><a href="#" class="autoRespond bs-tooltip" data-placement="bottom" title="Form Auto-Responder"><span class="glyphicon glyphicon-send"></span>&nbsp;&nbsp;Autoresponder</a></li>
											  <li><a href="#" class="on_submit bs-tooltip" data-placement="bottom" title="Form Submission Settings"><span class="glyphicon fa fa-gear"></span>&nbsp;&nbsp;Options</a></li>	
											  <li><a href="#" class="form_entries bs-tooltip" data-placement="bottom" title="Submitted Form Data"><span class="badge entry-count">0</span>&nbsp;&nbsp;Form Entries</a></li>
											</ul>';
								/*$output .= '<div class="canvas_view_settings view_settings">';	
										$output .= '<button href="#" class="btn btn-default preview_form bs-tooltip" data-toggle="tooltip" data-placement="right" title="Use Steps"><span class="fa fa-step-forward"></span></button>';
										$output .= '<button href="#" class="btn btn-default preview_form bs-tooltip"><span class="fa fa-step-forward"></span></button>';
										$output .= '<button href="#" class="btn btn-default preview_form bs-tooltip"><span class="fa fa-step-forward"></span></button>';
										$output .= '<button href="#" class="btn btn-default preview_form bs-tooltip" disabled="disabled"><span class="fa fa-paypal"></span></button>';
									
									$output .= '</div>';*/
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
									
									
									$output .= '<div class="panel-heading" style="display:none;">';
										$output .= '<span class="btn btn-primary glyphicon glyphicon-hand-down"></span>';
									$output .= '</div>';
									$output .= '<div id="collapseFormsCanvas" class="panel-collapse in" >';
									
									
									$output .= '<div class="panel-body panel_view" id="onSubmit" style="display:none">';
									
									
										$output .= '<ul class="nav nav-tabs" role="tablist">';
											$output .= '<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Form Submmision</a></li>';
											$output .= '<li role="presentation"><a href="#view_hidden_fields" aria-controls="home" role="tab" data-toggle="tab">Hidden Fields</a></li>';
										$output .= '</ul>';
									
										$output .= '<div class="tab-content panel">';
											$output .= '<div role="tabpanel" class="tab-pane active" id="home">';
												$output .= '<div class="row">';
													$output .= '<div class="col-xs-12">';
														$output .= '<h3>Post Action</h3><br />';
														$output .= '<label for="ajax"><input type="radio" name="post_action" id="ajax" value="ajax" checked="checked">&nbsp;Ajax</label><br />';
														$output .= '<label for="custom"><input type="radio" name="post_action" value="custom" id="custom">&nbsp;Custom</label>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="row ajax_posting hidden">';
												
													$output .= '<div class="col-xs-12">';
														$output .= '<br /><label>On Form Submission</label><br />';
														$output .= '<label for="on_form_submission_message"><input type="radio" name="on_form_submission" id="on_form_submission_message" value="message" checked="checked">&nbsp;Show message</label><br />';
														$output .= '<label for="on_form_submission_redirect"><input type="radio" name="on_form_submission" value="redirect" id="on_form_submission_redirect">&nbsp;Redirect to URL</label>';
													$output .= '</div>';										
												
													$output .= '<div class="confirmation_message">';
														$output .= '<div class="col-xs-12">';
															$output .= '<br /><label>Show confirmation message</label><br />';
															$output .= '<textarea id="nex_autoresponder_on_screen_confirmation_message" name="on_screen_confirmation_message" class="form-control">Thank you for connecting with us.</textarea>';
														$output .= '</div>';
													$output .= '</div>';
													
													$output .= '<div class="redirect_to_url hidden">';
														$output .= '<div class="col-xs-12">';
															$output .= '<br /><label>Redirect To URL</label>';
															$output .= '<input data-tag-class="label-info" id="nex_autoresponder_confirmation_page" type="text" name="confirmation_page"  value="" class="form-control">';
														$output .= '</div>';
													$output .= '</div>';
													
													/*$output .= '<div class="col-xs-12">';
														$output .= '<br /><label>Google Analytics Conversion Code</label>';
														$output .= '<textarea id="google_analytics_conversion_code" name="google_analytics_conversion_code" class="form-control"></textarea>';
													$output .= '</div>';*/
													
												$output .= '</div>';
												
												
												$output .= '<div class="row custom_posting hidden">';
													$output .= '<div class="col-xs-12">';
														$output .= '<br /><label>Enter Custom URL for form action</label>';
														$output .= '<input data-tag-class="label-info" id="on_form_submission_custum_url" type="text" name="custum_url"  value="" class="form-control">';
														$output .= '<br /><label>Post Method</label><br />';
														$output .= '<label for="post_method"><input type="radio" name="post_type" id="post_method" value="POST" checked="checked">&nbsp;POST</label><br />';
														$output .= '<label for="get_method"><input type="radio" name="post_type" value="GET" id="get_method">&nbsp;GET';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											
											$output .= '<div role="tabpanel" class="tab-pane" id="view_hidden_fields">';
												
												$output .= '<div class="row">';
													$output .= '<div class="col-sm-6">';
													
														$output .= '<div class="row">';
															$output .= '<div class="col-sm-12">';
																$output .= '<div class="btn btn-primary add_hidden_field"><span class="fa fa-eye-slash"></span>&nbsp;Add hidden Field</div><br /><br />';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="row hidden_field_clone hidden">';
															$output .= '<div class="col-sm-5 ">';
																$output .= '<label>Field Name</label><br />';
																$output .= '<input type="text" class="form-control field_name" value="">';
															$output .= '</div>';
															$output .= '<div class="col-sm-5">';
																$output .= '<label>Field Value</label><br />';
																$output .= '<input type="text" class="form-control field_vlaue" value="">';
															$output .= '</div>';
															$output .= '<div class="col-sm-2">';
																$output .= '<label>&nbsp;</label><br />';
																$output .= '<div class="btn btn-danger remove_hidden_field"><span class="fa fa-close"></span></div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="hidden_fields"></div>';
														
													$output .= '</div>';
												$output .= '</div>';
												
											$output .= '</div>';
											
										$output .= '</div>';
									$output .= '</div>';
									
									$output .= '<div class="panel-body panel_view" id="formEntries" style="display:none"><div class="nex-forms-entries">';
									
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
									
									$output .= '<div class="panel-body panel_view" id="autoRespond" style="display:none">';	
										$output .= '<div class="row">
											<div class="col-xs-6">
											<label><span title="" data-toggle="tooltip" data-placement="top" class="bs-tooltip glyphicon fa fa-question-circle" data-original-title="Enter a comma separated list of recipients to recieve the default \'New Form Entry\' email.">&nbsp;</span>Recipients</label>
										
											<div class="input-group ">
											<i class="input-group-addon prefix alert-warning"><i class="glyphicon fa fa-group"></i></i>
									   		<input data-tag-class="label-info" id="nex_autoresponder_recipients" type="text" name="recipients"  value="'.get_option('admin_email').'" class="form-control">
											</div>
									</div>
									<div class="col-xs-6">
											<label><span title="" data-toggle="tooltip" data-placement="top" class="bs-tooltip glyphicon fa fa-question-circle" data-original-title="Specify the address to where a recipient will reply to">&nbsp;</span>From Address</label>
										
											<div class="input-group ">
												<i class="input-group-addon prefix alert-info"><i class="glyphicon fa fa-envelope"></i></i>
												<input data-tag-class="label-info" id="nex_autoresponder_from_address" type="text" name="from_address"  value="'.get_option('admin_email').'" class="form-control">
											</div>
									</div>
									<div class="col-xs-6">
											<label><span title="" data-toggle="tooltip" data-placement="top" class="bs-tooltip glyphicon fa fa-question-circle" data-original-title="Specify what the confirmation email subject line should read">&nbsp;</span>Email Subject</label>
										
											<div class="input-group">
												<i class="input-group-addon prefix  alert-danger"><i class="glyphicon fa fa-user"></i></i>
												<input data-tag-class="label-info" id="nex_autoresponder_confirmation_mail_subject" type="text" name="confirmation_mail_subject"  value="'.get_option('blogname').' NEX-Forms submission" class="form-control">
											</div>
											
									</div>
									<div class="col-xs-6">
										<div class="input-group ">
												<label><span title="" data-toggle="tooltip" data-placement="top" class="bs-tooltip glyphicon fa fa-question-circle" data-original-title="Specify from where the email came from...for example, your company name.">&nbsp;</span>From Name</label>
											</div>
											<div class="input-group ">
												<i class="input-group-addon prefix alert-success"><i class="glyphicon fa fa-envelope"></i></i>
												<input data-tag-class="label-info" id="nex_autoresponder_from_name" type="text" name="from_name"  value="'.get_option('blogname').'" class="form-control">
											</div>
											
									</div>
											<div class="col-xs-6">
												<div class="input-group ">
														<label><span title="" data-toggle="tooltip" data-placement="top" class="bs-tooltip glyphicon fa fa-question-circle" data-original-title="Select one of your email fields (set to be validated as email) to send a custom confirmation mail to the user that completed the form.">&nbsp;</span>Send confirmation to user email address via this field\'s value '.$lock.'</label>
													</div>
													<span class="text-danger no-email hidden">You do not have any fields set to be validated as email format. Please add a text or custom field and set it to be validated as email and it will be available in the below list.</span>
													<select name="posible_email_fields" id="nex_autoresponder_user_email_field" class="form-control">
													</select>
													
											</div>
											<div class="col-xs-6">
											</div>
										<div class="row"></div>
										<div class="col-sm-3">
											<label><span title="" data-toggle="tooltip" data-placement="top" class="bs-tooltip glyphicon fa fa-question-circle" data-original-title="Double click the fields below to be added to the custom mail body to the right. These will act as placeholders for the actual values that the user has submitted.">&nbsp;</span>Current Form Fields '.$lock.'</label>
									   		<select multiple="multiple" name="current_fields" class="form-control">
											</select>
										</div>
										<div class="col-sm-9">
											<label><span title="" data-toggle="tooltip" data-placement="top" class="bs-tooltip glyphicon fa fa-question-circle" data-original-title="Add your confirmation message here. This is HTML enabled and new lines will automatically break">&nbsp;</span>Confirmation Mail body (message) '.$lock.'</label>
									   		<textarea id="nex_autoresponder_confirmation_mail_body" name="confirmation_mail_body" class="form-control">Thank you for connecting with us. We will respond to you shortly.</textarea>
										</div>
								  </div></div>';
									
									
									if ( !is_plugin_active( 'nex-forms-themes-add-on/main.php' ) ) {
										$output .= '<link rel="stylesheet" class="color_scheme_test" type="text/css" href="http://basixonline.net/theme_testing/" />';
										?>
                                        
                                        <script type="text/javascript">
											
											jQuery(document).ready(
															function ()
																{
																jQuery('.overall-form-settings .dropdown-menu li').click(
																	function()
																		{
																		jQuery(this).removeClass('active');
																		if(jQuery(this).attr('class')!='default')
																			{																				
																				jQuery('link.color_scheme_test').attr('href','http://basixonline.net/theme_testing/'+ jQuery(this).attr('class') +'/jquery.ui.theme.css');
																				jQuery('.the_input_element, .bootstrap-tagsinput, .radio-group a, .check-group a').addClass('ui-state-default')
																				jQuery('.form_field .input-group-addon, .bootstrap-touchspin .btn').addClass('ui-state-active')
																				jQuery('p.the_input_element, .heading .the_input_element').removeClass('ui-state-default');
																				jQuery('.panel-heading').addClass('ui-widget-header');
																				
																				jQuery('.other-elements .panel-body').addClass('ui-widget-content');
																				jQuery('label.title').find('span').css('color','inherit');
																				jQuery('.ui-slider-handle').addClass('ui-state-default');
																		
																		jQuery('.panel-body').each(
																			function()
																					{
																						if(jQuery(this).prev('div').hasClass('panel-heading'))
																							jQuery(this).addClass('ui-widget-content');
																					}
																				);
																		
																			}
																		else
																			{
																			jQuery('link.color_scheme').attr('href',"#");
																			jQuery('.ui-state-default').removeClass('ui-state-default');
																			jQuery('.ui-state-active').removeClass('ui-state-active')
																			jQuery('.ui-widget-content').removeClass('ui-widget-content');
																			jQuery('.ui-widget-header').removeClass('ui-widget-header')	
																			}			
																		jQuery('.overall-form-settings li').removeClass('active');
																		
																		jQuery('.overall-form-settings .current_selected_theme').text(jQuery(this).find('a').text());
																		jQuery('.active_theme').text(jQuery(this).attr('class'));
																		
																		jQuery(this).addClass('active');
																		jQuery('.grid-system .panel-body').removeClass('ui-widget-content');
																		jQuery('.bootstrap-select.ui-state-default').removeClass('ui-state-default');
																		
																		
																		}
																	);
																}
															);
											
										</script>
                                        
                                        <?php
									
									}
										$output .= '<div class="panel-body panel_view nex-forms-container  bootstro" data-bootstro-title="Form Canvas" data-bootstro-content="This is where you will construct your forms. Drag form elements here or click them to be appended at the end of existing form content." data-bootstro-placement="left" data-bootstro-step="15">
														
														<div class="run_animation hidden">false</div>
														<div class="animation_time hidden">60</div>
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
		$get_forms = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms ORDER BY Id DESC');
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
			$wpdb->query('DELETE FROM ' .$wpdb->prefix. 'wap_nex_forms WHERE Id = '.$_POST['Id']);
			die();
		}

	public function update_form_settings(){
		
		if(!get_option('wNex-Forms-default-settings'))
			add_option('wNex-Forms-default-settings',array());
		
		update_option('wNex-Forms-default-settings',$_POST);
		
		IZC_Functions::print_message( 'updated' , 'Settings Updated' );
		die();
	}
	
	
	public function convert_form_entries(){
	
	
			global $wpdb;
			
		$forms = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms');
		
		foreach($forms as $form)
			{
			$form_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE nex_forms_Id='.$form->Id);
			
			$form_field_array = json_decode($form_fields->form_fields,true);
			
			foreach($form_data as $set_header)	
					{ 
					$headers[$set_header->meta_key] = ''.IZC_Functions::format_name($set_header->meta_key);
					}
				array_unique($headers);	
				
				
				$sql = 'SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE nex_forms_Id='.$form->Id.' GROUP BY time_added  ORDER BY time_added';
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
								$check_field = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE meta_key="'.$heading.'" AND time_added="'.$data->time_added.'"');
								if($check_field)
									{
									$val[] = array('field_name'=>$heading,'field_value'=>$check_field->meta_value);
									}
								$k++;
								}
						if($new_record!=$old_record)
							{
							
							$insert = $wpdb->insert($wpdb->prefix.'wap_nex_forms_entries',
								array(								
									'nex_forms_Id'			=>	$data->nex_forms_Id,
									'page'					=>	'undefined',
									'ip'					=>  'undefined',
									'user_Id'				=>	'1',
									'viewed'				=>	'no',
									'date_time'				=>   date('Y-m-d H:i:s',$data->time_added),
									'form_data'				=>	json_encode($val,true)
									)
							 );					
							}
						
						
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
	
	public function forms_data(){
		
		global $wpdb;
		
		
		$output = '';
		
		$output .= '<div class="">';
			$output .= '<div id="widgets-right" style="width:100%;">';
				$output .= '<div class="widgets-holder-wrap " id="available-widgets">';
					$output .= '<div class="sidebar-name">';
						$output .= '<div class="sidebar-name-arrow">';
						$output .= '<br>';
						$output .= '</div>';
							$output .= '<h3>';
								$output .= 'Forms';
							$output .= '</h3>';
					$output .= '</div>';

					$output .= '<div class="widget-holder draggable_forms">';
						$output .= '<p class="description">Drag the forms below to the dropable area (table).</p>';
						
						$forms = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wap_wa_form_builder');

						foreach($forms as $form)
							{
							$output .= '<div id="'.$form->Id.'" class="widget draggable-form ui-draggable" data-form-id="'.$form->Id.'">
								<div class="widget-top"><div class="widget-title"><h4 style="float:left;">'.$form->title.'</h4>
								</div></div></div>';	
							}

						$output .= '<br class="clear">';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		
		$output .= '<div class="col-wrap">';
		
		
		
		$output .= NEXForms_form_entries::biuld_form_data_table();
		
		$output .= 	'</div>';
		
		
		
		return $output;
				
	}
	
	public function build_form_data_table($form_id=''){
		
		global $wpdb;
		if(!$form_id)
			$form_id = $_POST['form_Id'];

		$csv_data = '';
		
		$form_fields = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms WHERE Id='.$form_id);
		$form_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE nex_forms_Id='.$form_id);
		
		$form_field_array = json_decode($form_fields->form_fields,true);
		
		foreach($form_data as $set_header)	
				{ 
				$headers[$set_header->meta_key] = ''.IZC_Functions::format_name($set_header->meta_key);
				}
			array_unique($headers);		
			$output .= '<form method="post" action="" id="posts-filter">';

				$output .= '<div class="tablenav top">';
					$output .= '<a class="btn btn-primary"><span class="fa fa-cloud-download"></span>&nbsp;&nbsp;Export Form Entries (csv)</a><br />
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
							$output .= '<span class="current-page">'.($_POST['current_page']+1).'</span> of <span class="total-pages">'.$total_pages.'</span>&nbsp;</span>';
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
			
			$sql = 'SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE nex_forms_Id='.$form_id.' GROUP BY time_added ORDER BY time_added DESC
								LIMIT '.((isset($_POST['current_page'])) ? $_POST['current_page']*10 : '0'  ).',10 ';
			$results 	= $wpdb->get_results($sql);
			
			$sql2 = 'SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE nex_forms_Id='.$form_id.' GROUP BY time_added ORDER BY time_added DESC';
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
							$check_field = $wpdb->get_row('SELECT meta_key,meta_value FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE meta_key="'.$heading.'" AND time_added="'.$data->time_added.'"');
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
							$check_field = $wpdb->get_row('SELECT meta_key,meta_value FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE meta_key="'.$heading.'" AND time_added="'.$data->time_added.'"');
							
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
				$output .= '<input type="hidden" name="wa_form_Id" value="'.$_POST['form_Id'].'">';

			$output .= '<form name="export_csv" method="post" action="'.get_option('siteurl').'/wp-content/plugins/nex-forms-express-wp-form-builder/includes/export.php" id="posts-filter" style="display:none;">';
				$output .= '<textarea name="csv_content">'.$csv_data.'</textarea>';	
				$output .= '<input name="_title" value="'.IZC_Database::get_title($form_id,'wap_nex_forms').'">';	
			$output .= '</form>';
			
		if($_POST['form_Id'])	{
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

		
		$sql = 'SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE nex_forms_Id='.$_POST['form_Id'].' GROUP BY time_added ORDER BY time_added DESC
										LIMIT '.((isset($_POST['current_page'])) ? $_POST['current_page']*10 : '0'  ).',10 ';
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
							$check_field = $wpdb->get_row('SELECT meta_key,meta_value FROM '.$wpdb->prefix.'wap_nex_forms_meta WHERE meta_key="'.$heading.'" AND time_added="'.$data->time_added.'"');
							
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
			$output .= '<tr>';	
			$output .= '<td class="manage-column" colspan="'.(count($headings)).'">Sorry, No entires found</td>';
			$output .= '</tr>';
			}
			
		echo $output;
		die();
	}
	
	
	public function from_entries_table_pagination(){

		
		$total_records = NEXForms_form_entries::get_total_form_entries($_POST['wa_form_Id']);
		
		$total_pages = ((is_float($total_records/10)) ? (floor($total_records/10))+1 : $total_records/10);
		
		$output .= '<span class="displaying-num"><strong>'.NEXForms_form_entries::get_total_form_entries($_POST['wa_form_Id']).'</strong> entries</span>';
		if($total_pages>1)
			{				
			$output .= '<span class="pagination-links">';
			$output .= '<a class="first-page wafb-first-page">&lt;&lt;</a>&nbsp;';
			$output .= '<a title="Go to the next page" class="wafb-prev-page prev-page">&lt;</a>&nbsp;';
			$output .= '<span class="paging-input"> ';
			$output .= '<span class="current-page">'.($_POST['current_page']+1).'</span> of <span class="total-pages">'.$total_pages.'</span>&nbsp;</span>';
			$output .= '<a title="Go to the next page" class="wafb-next-page next-page">&gt;</a>&nbsp;';
			$output .= '<a title="Go to the last page" class="wafb-last-page last-page">&gt;&gt;</a></span>';
			}
		echo $output;
		die();
	}
	
	public function get_total_form_entries($wa_form_Id){
		global $wpdb;
		$get_count  = $wpdb->get_results('SELECT Id FROM '.$wpdb->prefix .'wap_nex_forms_meta WHERE nex_forms_Id='.$wa_form_Id.' GROUP BY time_added');

		return count($get_count);
	}
	
	public function delete_form_entry(){
		global $wpdb;
		
		$wpdb->query('DELETE FROM ' .$wpdb->prefix. 'wap_nex_forms_meta WHERE time_added = "'.$_POST['last_update'].'"');

		IZC_Functions::print_message( 'updated' , 'Item deleted' );
		die();
	}	
}

?>