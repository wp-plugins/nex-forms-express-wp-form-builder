<?php
/***************************************/
/***********   Ajax Calls   ************/
/***************************************/


add_action('wp_ajax_populate_form_data_list', array('NEXFormsExpress_form_entries','get_form_data'));

add_action('wp_ajax_delete_form_entry', array('NEXFormsExpress_form_entries','delete_form_entry'));

add_action('wp_ajax_from_entries_table_pagination', array('NEXFormsExpress_form_entries','from_entries_table_pagination'));

add_action('wp_ajax_build_form_data_table', array('NEXFormsExpress_form_entries','build_form_data_table'));

add_action('wp_ajax_update_form_settings', array('NEXFormsExpress_form_entries','update_form_settings'));

add_action('wp_ajax_',  'export_csv' );


add_action('wp_ajax_load_nex_form_items',  array('NEXFormsExpress_admin','get_forms') );
add_action('wp_ajax_load_nex_form_templates',  array('NEXFormsExpress_admin','get_templates') );

class NEXFormsExpress_admin{

	/***************************************/
	/*******   Customizing Forms   *********/
	/***************************************/
	public function get_forms(){
		global $wpdb;
		$forms = $wpdb->get_results('SELECT Id,title FROM '.$wpdb->prefix.'wap_nex_forms WHERE is_form="1"');
		foreach($forms as $form)
			$output .= '<li id="'.$form->Id.'" class="nex_form_itmes"><a href="#"><span class="fa fa-file-o">&nbsp;&nbsp;</span><span class="the_form_title">'.$form->title.'</span></a>&nbsp;&nbsp;<i class="fa fa-trash-o btn-sm btn alert-danger delete_the_form" data-toggle="modal" data-target="#deleteForm" id="'.$form->Id.'"></i></li>';	
		echo $output;
		die();
	}
	public function get_templates(){
		global $wpdb;
		$forms = $wpdb->get_results('SELECT Id,title FROM '.$wpdb->prefix.'wap_nex_forms WHERE is_template="1"');
		foreach($forms as $form)
			$output .= '<li id="'.$form->Id.'" class="nex_form_templates"><a href="#"><span class="fa fa-file-o">&nbsp;&nbsp;</span><span class="the_form_title">'.$form->title.'</span></a>&nbsp;&nbsp;<i class="fa fa-trash-o btn-sm btn alert-danger delete_the_form" data-toggle="modal" data-target="#deleteForm" id="'.$form->Id.'"></i></li>';	
		echo $output;
		die();
	}
	public function NEXFormsExpress_field_settings()
		{
		do_action( 'styles_font_menu' );
		    $lock = '&nbsp;&nbsp;<span title="" data-toggle="tooltip" data-placement="right" class="bs-tooltip fa fa-lock text-danger" data-original-title="This feature is locked! Click on \'Upgade to Pro\' top right to activate.">&nbsp;</span>';
					
			$output .= '<div id="nex-forms-field-settings" class="nex-forms-field-settings bs-callout bs-callout-info bootstro" data-bootstro-title="Editing Panel" data-bootstro-content="This is where you will edit all available settings for form elements. This panel will slide open on adding a new field or by clicking on a specific element\'s attributes: the label, the input or the help text. The current element is highlighted by a green dotted border (see the text field label to your left)<br /><br /> Note that different fields have different validation and input settings." data-bootstro-placement="left" data-bootstro-step="17">';
					$output .= '<div class="current_id hidden" ></div>';
						$output .= '<div class="panel panel-default admin-panel">';
							$output .= '<div class="panel-heading">';
								$output .= '<h4 class="panel-title label-primary">';									
									$output .= '<a><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Edit Field&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="btn btn-info copy-field bs-tooltip" title="Dupplicate field" data-placement="right" data-toggle="tooltip"><span class="glyphicon fa fa-files-o"></span></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="btn btn-info copy-to-clipboard bs-tooltip" title="Copy to Clipboard" data-placement="right" data-toggle="tooltip"><span class="glyphicon fa fa-clipboard"></span></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="btn btn-danger delete-field bs-tooltip" title="Delete field" data-placement="right" data-toggle="tooltip"><span class="glyphicon fa fa-trash-o"></span></span><span class="close glyphicon glyphicon-remove"></span></a>';
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
														<!--<li><a class="logic" class="selected" data-option-value=".settings-logic" href="#filter">Logic</a></li>-->
													  </ul>
												  </div>';
									
									$output .= '<div id="field-settings-inner">';
                  						$output .= '<div class="clearfix row categorize" id="categorize_container" style="position: relative; height: 606px;">';

/******************************************************************************************************************************/
//PREFIX             							 
											//text
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 setting-prefix icons" style="z-index:1000005 !important;">';
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
																	$output .= NEXFormsExpress_admin::show_icons();
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
													$output .= '<div class="col-sm-6 setting-prefix icons selected-color" style="z-index:1000004 !important;">';
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
												$output .= '<div class="col-sm-6 setting-postfix icons" style="z-index:1000003 !important;">';
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
																	$output .= NEXFormsExpress_admin::show_icons();
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
													$output .= '<div class="col-sm-6 setting-postfix icons selected-color" style="z-index:1000002 !important;">';
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
												$output .= '<div class="col-sm-6 settings-label categorize-item">';
													$output .= '<div class="input_holder ">';					
														$output .= '<label>Text</label>';
														$output .= '<div class="input-group">';
															$output .= '<input id="set_label" type="text" name="set_label" class="form-control">';
														    $output .= '<span class="input-group-addon label-bold label-primary"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon label-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 settings-label categorize-item">';
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
												$output .= '<div class="col-sm-6 settings-label categorize-item">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Sub Label</label>';
														$output .= '<div class="input-group">';
															$output .= '<input id="set_subtext" type="text" name="set_subtext" class="form-control">';
														    $output .= '<span class="input-group-addon sub-label-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon sub-label-italic label-primary"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 settings-label categorize-item">';
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
												$output .= '<div class="col-sm-6 settings-label categorize-item">';
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
												$output .= '<div class="col-sm-6 settings-label categorize-item">';
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
												$output .= '<div class="col-sm-6 settings-label categorize-item">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Font'.$lock.'</label>';
														$output .=	'<div class="google-fonts-dropdown-label input-group"><select name="label-fonts" class="sfm form-control"></select><span class="input-group-addon"><i><input type="checkbox" checked="checked" title="Show Preview" data-placement="top" data-toggle="tooltip" class="bs-tooltip" name="show-font-preview"></i></span></div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 settings-label categorize-item">';
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
												
												
												$output .= '<div class="col-sm-6 setting-paragraph">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Paragraph text</label>';
														$output .= '<textarea name="set_paragraph" id="set_paragraph" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												
											$output .= '</div>';

/******************************************************************************************************************************/
//HEADING SETTINGS												
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 setting-heading">';
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
												$output .= '<div class="col-sm-6 setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Heading</label>';
														$output .= '<div class="input-group">';
															$output .= '<input name="set_panel_heading" id="set_panel_heading" class="form-control">';
															$output .= '<span class="input-group-addon panel-head-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon panel-head-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 setting-panel">';
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
												
												$output .= '<div class="col-sm-6 setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Heading Color</label>';
														$output .= '<div id="panel_heading_color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#333333" class="form-control" />
																		<span class="input-group-addon reset" data-default="#333333"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Heading Background Color</label>';
														$output .= '<div id="panel_heading_background" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#F5F5F5" class="form-control" />
																		<span class="input-group-addon reset" data-default="#F5F5F5"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												
												$output .= '<div class="col-sm-6 setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Body Background Color</label>';
														$output .= '<div id="panel_body_background" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-panel">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Border Color</label>';
														$output .= '<div id="panel_border_color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#DDDDDD" class="form-control" />
																		<span class="input-group-addon reset" data-default="#DDDDDD"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-panel">';
													$output .= '<div class="input_holder">';
														$output .= '<label>Font'.$lock.'</label>';
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
												$output .= '<div class="col-sm-6 setting-tags icons" style="z-index:1000001 !important;">';
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
														$output .= NEXFormsExpress_admin::show_icons();
														$output .= '</div></div></div></div>';
														$output .= '</div>';
														$output .= '<div class="col-sm-6 setting-tags icons selected-color" style="z-index:1000000 !important;">';
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
												$output .= '<div class="col-sm-6 setting-autocomplete">';
													$output .= '<div class="input_holder prepopulate_target">';											
														$output .= '<label>Selection</label>';
														$output .= '<textarea id="set_selections" name="set_selections" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												//autocomplete
												$output .= '<div class="col-sm-6 setting-date">';										
														$output .= '<label>Date Format</label>';
														$output .= '<select id="format_date" class="form-control">
																	<option value="DD/MM/YYYY">DD/MM/YYYY</option>
																	<option value="YYYY/MM/DD">YYYY/MM/DD</option>
																	<option value="DD-MM-YYYY">DD-MM-YYYY</option>
																	<option value="YYYY-MM-DD">YYYY-MM-DD</option>
																</select>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 populate setting-autocomplete">';
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
												
												//color-pallet
												$output .= '<div class="col-sm-6 setting-color-pallet">';
													$output .= '<div class="input_holder prepopulate_target">';											
														$output .= '<label>Color Selection</label>';
														$output .= '<textarea id="set_color_selection" name="set_color_selection" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												
											
												//select
												$output .= '<div class="col-sm-6 setting-select setting-multi-select">';
													$output .= '<div class="input_holder prepopulate_target">';	
														$output .= '<label>Default Value</label>';
														$output .= '<input id="set_default_value" type="text" name="set_default_value" value="--- Select ---" class="form-control">
															<span class="help-block">This will send a "0" value or triggers required validation.</span>';										
														$output .= '<label>Select Options</label>';
														
														$output .= '<textarea id="set_options" name="set_options" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 populate setting-select setting-multi-select">';
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
												$output .= '<div class="col-sm-6 setting-validation-file-input">';
													$output .= '<div class="input_holder prepopulate_target">';
													$output .= '<label>Allowed Extensions</label>';
														$output .= '<textarea id="set_extensions" name="set_extensions" class="form-control"></textarea>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 populate setting-validation-file-input">';
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
												
												
												$output .= '<div class="col-sm-6 setting-text setting-textarea">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Place Holder</label>';
														$output .= '<input id="set_place_holder" type="text" name="set_place_holder" class="form-control">';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
											
											//Input value / max chars
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 setting-text setting-textarea setting-button">';
													
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Input Value</label>';
														$output .= '<div class="input-group">';
															$output .= '<input id="set_val" type="text" name="set_val" class="form-control">';
														    $output .= '<span class="input-group-addon input-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon input-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';	
														
													
													
											$output .= '</div>';
											
											//Colors
											$output .= '<div class="row">';
												$output .= '<div class="col-sm-6 setting-paragraph setting-heading settings-input setting-button">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Color</label>';
														$output .= '<div id="input-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#000000" class="form-control" />
																		<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 settings-input setting-button">';
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
												$output .= '<div class="col-sm-6 settings-input setting-button setting-divider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Border Color</label>';
														$output .= '<div id="input-border-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#DDDDDD" class="form-control" />
																		<span class="input-group-addon reset" data-default="#DDDDDD"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 settings-input">';
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
												$output .= '<div class="col-sm-6 setting-paragraph">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Alignment</label>';
														$output .= '<div role="toolbar" class="btn-toolbar">
																	  <div class="btn-group align-input">
																		<button class="btn btn-default left" type="button"><span class="glyphicon glyphicon-align-left"></span>&nbsp;&nbsp;Left</button>
																		<button class="btn btn-default right" type="button"><span class="glyphicon glyphicon-align-right"></span>&nbsp;&nbsp;Right</button>
																		<button class="btn btn-default center" type="button"><span class="glyphicon glyphicon-align-center"></span>&nbsp;&nbsp;Center</button>
																		<button class="btn btn-default justify" type="button"><span class="glyphicon glyphicon-align-justify"></span>&nbsp;&nbsp;Justify</button>
																	  </div>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 settings-input setting-heading setting-button">';
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
												$output .= '<div class="col-sm-6 settings-input setting-button">';
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
												$output .= '<div class="col-sm-6 settings-input setting-paragraph setting-heading setting-button">';
													$output .= '<div class="input_holder">';
														$output .= '<label>Font'.$lock.'</label>';
														$output .=	'<div class="google-fonts-dropdown-input input-group"><select name="input-fonts" class="sfm form-control"></select><span class="input-group-addon"><i><input type="checkbox" checked="checked" title="Show Preview" data-placement="top" data-toggle="tooltip" class="bs-tooltip" name="show-font-preview"></i></span></div>';
													$output .= '</div>'; 
												$output .= '</div>';
											$output .= '<div class="col-sm-6 settings-input setting-slider setting-panel setting-tags setting-button">';
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
												$output .= '<div class="col-sm-6 settings-help-text">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Text</label>';														
														$output .= '<div class="input-group">';
															$output .= '<input id="set_help_text" type="text" name="set_help_text" class="form-control">';
														    $output .= '<span class="input-group-addon help-text-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															$output .= '<span class="input-group-addon help-text-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 settings-help-text">';
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
												
												$output .= '<div class="col-sm-6 settings-help-text">';
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
												
												$output .= '<div class="col-sm-6 settings-help-text">';
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
												$output .= '<div class="col-sm-6 settings-help-text">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Font'.$lock.'</label>';
														$output .=	'<div class="google-fonts-dropdown-help-text input-group"><select name="help-text-fonts" class="sfm form-control"></select><span class="input-group-addon"><i><input type="checkbox" checked="checked" title="Show Preview" data-placement="top" data-toggle="tooltip" class="bs-tooltip" name="show-font-preview"></i></span></div>';
													$output .= '</div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 settings-help-text">';
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
												$output .= '<div class="col-sm-6 settings-validation">';
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
												$output .= '<div class="col-sm-6 settings-validation error_color">';
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
												
												$output .= '<div class="col-sm-6 setting-validation-text" style="z-index:100;">';
													$output .= '<div class="input_holder">';											
														$output .= '<label>Validate as:'.$lock.'</label>';
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
												
												$output .= '<div class="col-sm-6 setting-validation-text setting-validation-file-input">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Secondary message'.$lock.'</label>';
														$output .= '<input id="set_secondary_error" type="text" value="" name="set_secondary_error" class="form-control">';
													$output .= '</div>';
												$output .= '</div>';
												
												
													
											
												$output .= '<div class="col-sm-6 settings-validation">';
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
											
											
											$output .= '<div class="col-sm-6 setting-text setting-textarea setting-validation-text setting-validation-textarea" style="z-index:100;">';
													$output .= '<div class="input_holder">';											
														$output .= '<label>Maximum Characters'.$lock.'</label>';
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
												$output .= '<div class="col-sm-6 setting-radio icons">';
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
																		$output .= NEXFormsExpress_admin::show_icons();
														$output .= '</div></div></div></div>';
												$output .= '</div>';
												$output .= '<div class="col-sm-6 setting-radio icons selected-color">';
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
						$output .= '<div class="col-sm-6 setting-radio">';
									$output .= '<div class="input_holder">';											
										$output .= '<label>Radios</label>';
										$output .= '<textarea id="set_radios" name="set_radios" class="form-control"></textarea>';
									$output .= '</div>';
								$output .= '</div>';
						$output .= '<div class="col-sm-6 setting-radio">';
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
						$output .= '<div class="col-sm-6 setting-radio">';
							$output .= '<div class="input_holder ">';
								$output .= '<label>Background Color</label>';
								$output .= '<div id="radio-background-color" class="input-group colorpicker-component demo demo-auto">
												<span class="input-group-addon"><i></i></span>
												<input type="text" value="#FFF" class="form-control" />
												<span class="input-group-addon reset" data-default="#FFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
											</div>';
							$output .= '</div>';
						$output .= '</div>';
						
						$output .= '<div class="col-sm-6 setting-radio">';
							$output .= '<div class="input_holder ">';
								$output .= '<label>Border Color</label>';
								$output .= '<div id="radio-border-color" class="input-group colorpicker-component demo demo-auto">
												<span class="input-group-addon"><i></i></span>
												<input type="text" value="#CCCCCC" class="form-control" />
												<span class="input-group-addon reset" data-default="#CCCCCC"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
											</div>';
							$output .= '</div>';
						$output .= '</div>';
						
						$output .= '<div class="col-sm-6 setting-radio">';
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
												$output .= '<div class="col-sm-6 setting-slider icons">';
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
														$output .= NEXFormsExpress_admin::show_icons();
														$output .= '</div></div></div></div>';
														$output .= '</div>';
														$output .= '<div class="col-sm-6 setting-slider icons selected-color">';
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
												
												$output .= '<div class="col-sm-6 setting-slider">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Minimum value</label>';
															$output .= '<input type="text" name="minimum_value" id="minimum_value" class="form-control" />';
														$output .= '</div>';
													$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Maximum value</label>';
														$output .= '<input type="text" name="maximum_value" id="maximum_value" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Starting value</label>';
														$output .= '<input type="text" name="start_value" id="start_value" class="form-control" />';
													$output .= '<span class="help-block">&nbsp;</span></div>';
												$output .= '</div>';
												
												
												$output .= '<div class="col-sm-6 setting-slider">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Count Text</label>';
															$output .= '<div class="input-group">';
															$output .= '<input type="text" name="count_text" id="count_text" class="form-control" />';
														 //   $output .= '<span class="input-group-addon count-text-bold"><span class="glyphicon glyphicon-bold"></span></span>';
															//$output .= '<span class="input-group-addon count-text-italic"><span class="glyphicon glyphicon-italic"></span></span>';
														$output .= '</div><span class="help-block">Use {x} for count value substitution. HTML enabled.</span>';
															
														$output .= '</div>';
													$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-slider">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Handel Text Color</label>';
															$output .= '<div id="slide-handel-text-color" class="input-group colorpicker-component demo demo-auto">
																			<span class="input-group-addon"><i></i></span>
																			<input type="text" value="#000000" class="form-control" />
																			<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																		</div>';
														$output .= '</div>';
													$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Handel Background Color</label>';
														$output .= '<div id="slider-handel-background-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Handel Border Color</label>';
														$output .= '<div id="slider-handel-border-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#CCCCCC" class="form-control" />
																		<span class="input-group-addon reset" data-default="#CCCCCC"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Slider Border Color</label>';
														$output .= '<div id="slider-border-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#CCCCCC" class="form-control" />
																		<span class="input-group-addon reset" data-default="#CCCCCC"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-slider">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Color</label>';
														$output .= '<div id="slider-background-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-slider">';
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
												$output .= '<div class="col-sm-6 setting-star">';
													$output .= '<div class="input_holder ">';											
														$output .= '<label>Total Stars</label>';
														$output .= '<input type="text" name="total_stars" id="total_stars" class="form-control">';
														$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-star">';
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
												$output .= '<div class="col-sm-6 setting-spinner icons" style="z-index:1000001 !important;">';
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
														$output .= NEXFormsExpress_admin::show_icons();
														$output .= '</div></div></div></div>';
														$output .= '</div>';
														$output .= '<div class="col-sm-6 setting-spinner icons selected-color" style="z-index:1000000 !important;">';
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
												$output .= '<div class="col-sm-6 setting-spinner icons">';
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
														$output .= NEXFormsExpress_admin::show_icons();
														$output .= '</div></div></div></div>';
														$output .= '</div>';
														$output .= '<div class="col-sm-6 setting-spinner icons selected-color">';
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
												
												
												
												
												$output .= '<div class="col-sm-6 setting-spinner">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Minimum value</label>';
															$output .= '<input type="text" name="spin_minimum_value" id="spin_minimum_value" class="form-control" />';
														$output .= '</div>';
													$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-spinner">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Maximum value</label>';
														$output .= '<input type="text" name="spin_maximum_value" id="spin_maximum_value" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-spinner">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Starting value</label>';
														$output .= '<input type="text" name="spin_start_value" id="spin_start_value" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-spinner">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Step value</label>';
														$output .= '<input type="text" name="spin_step_value" id="spin_step_value" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-spinner">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Decimal places</label>';
														$output .= '<input type="text" name="spin_decimal" id="spin_decimal" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
																	
										$output .= '</div>';

												
												
											
/******************************************************************************************************************************/
//TAG SETTINGS												
											$output .= '<div class="row">';
												
												
												$output .= '<div class="col-sm-6 setting-tags">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Maximum Tags</label>';
														$output .= '<input type="text" name="max_tags" id="max_tags" class="form-control" />';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-tags">';
														$output .= '<div class="input_holder ">';
															$output .= '<label>Color</label>';
															$output .= '<div id="tags-text-color" class="input-group colorpicker-component demo demo-auto">
																			<span class="input-group-addon"><i></i></span>
																			<input type="text" value="#000000" class="form-control" />
																			<span class="input-group-addon reset" data-default="#000000"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																		</div>';
														$output .= '</div>';
													$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-tags">';
													$output .= '<div class="input_holder ">';
														$output .= '<label>Background Color</label>';
														$output .= '<div id="tags-background-color" class="input-group colorpicker-component demo demo-auto">
																		<span class="input-group-addon"><i></i></span>
																		<input type="text" value="#FFFFFF" class="form-control" />
																		<span class="input-group-addon reset" data-default="#FFFFFF"><span class="glyphicon glyphicon-retweet bs-tooltip" data-toggle="tooltip" data-placement="top" title="Reset"></span></span>
																	</div>';
													$output .= '</div>';
												$output .= '</div>';
												
												$output .= '<div class="col-sm-6 setting-tags">';
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
                    
                  					$output .= '</div> <!-- #categorize_container -->';
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				
			$output .= '</div>';
			
			return $output;
		}
	
	public function NEXFormsExpress_Admin(){
		
		global $wpdb;
		
		$db 		= new IZC_Database();
		$template 	= new IZC_Template();
		$config 	= new NEXFormsExpress_Config();
		$newform_Id = rand(0,99999999999);
		
		$lock = '&nbsp;&nbsp;<span title="" data-toggle="tooltip" data-placement="bottom" class="bs-tooltip fa fa-lock text-danger" data-original-title="This feature is locked! Click on \'Upgade to Pro\' top right to activate.">&nbsp;</span>';
					
		$output .= '<!-- Preloader -->
					<div id="preloader">
					  <div id="status" class="label-primary">
						<span class="glyphicon glyphicon-fire"></span>NEX-Forms Express<br><small>The Ultimate Wordpress Form Builder</small>
						<div class="progress progress-striped">
							  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width:0%">
								<span class="sr-only">20% Complete</span>
							  </div>
							</div>
						</div>
					</div>
					<div class="plugin_url" style="display:none;">'.WP_PLUGIN_URL.'/nex-forms-express-wp-form-builder</div>';
		//NEX ATTR
		$output .= '<div class="nex_form_attr" style="display:none;"></div>';
		
		//DELETE CONFIRM
		$output .= '<div class="modal fade" id="deleteForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-danger">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Confirm form deletion</h4>
							  </div>
							  <div class="modal-body">
								Are you sure you want to delete <strong><span class="get_form_title"></span></strong>?
							  </div>
							  <div class="modal-footer align_center">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="button" class="btn btn-danger do_delete" data-dismiss="modal" data-form-id="">Yes, delete permanantly</button>
							  </div>
							</div>
						  </div>
						</div>';
	//AUTORESPONDER
		$output .='<div class="modal fade" id="autoRespond" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog" style="width:50%">
							<div class="modal-content">
							  <div class="modal-header alert alert-success">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-send"></span>&nbsp;&nbsp;Autoresponder</h4>
							  </div>
							  <div class="modal-body">
								  <div class="row">
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
												<input data-tag-class="label-info" id="nex_autoresponder_confirmation_mail_subject" type="text" name="confirmation_mail_subject"  value="'.get_option('blogname').' NEX-Forms Express submission" class="form-control">
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
														<label><span title="" data-toggle="tooltip" data-placement="top" class="bs-tooltip glyphicon fa fa-question-circle" data-original-title="Select one of your email fields (set to be validated as email) to send a custom confirmation mail to the user that completed the form.">&nbsp;</span>Send confirmation to user email address via this field\'s value'.$lock.'</label>
													</div>
													<span class="text-danger no-email hidden">You do not have any fields set to be validated as email format. Please add a text or custom field and set it to be validated as email and it will be available in the below list.</span>
													<select name="posible_email_fields" id="nex_autoresponder_user_email_field" class="form-control">
													</select>
													
											</div>
											<div class="col-xs-6">
											</div>
										<div class="row"></div>
										<div class="col-sm-3">
											<label><span title="" data-toggle="tooltip" data-placement="top" class="bs-tooltip glyphicon fa fa-question-circle" data-original-title="Double click the fields below to be added to the custom mail body to the right. These will act as placeholders for the actual values that the user has submitted.">&nbsp;</span>Current Form Fields'.$lock.'</label>
									   		<select multiple="multiple" name="current_fields" class="form-control">
											</select>
										</div>
										<div class="col-sm-9">
											<label><span title="" data-toggle="tooltip" data-placement="top" class="bs-tooltip glyphicon fa fa-question-circle" data-original-title="Add your confirmation message here. This is HTML enabled and new lines will automatically break">&nbsp;</span>Confirmation Mail body (message)'.$lock.'</label>
									   		<textarea id="nex_autoresponder_confirmation_mail_body" name="confirmation_mail_body" class="form-control">Thank you for connecting with us. We will respond to you shortly.</textarea>
										</div>
								  </div>
							  </div>
							  <div class="modal-footer align_center">
								<button type="button" class="btn btn-primary" data-dismiss="modal" data-form-id="">Done</button>
							  </div>
							</div>
						  </div>
						</div>';
		//FORM ENTRIES
		$output .='<div class="modal fade" id="formEntries" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog" style="width:90%">
							<div class="modal-content">
							  <div class="modal-header alert alert-info">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel"><span class="fa fa-cloud-upload"></span>&nbsp;&nbsp;Form Entries</h4>
							  </div>
							  <div class="modal-body nex-forms-entries">
							  No entires yet...					  
							  </div>
							  <div class="modal-footer align_center">
								<button type="button" class="btn btn-primary" data-dismiss="modal" data-form-id="">Done</button>
							  </div>
							</div>
						  </div>
						</div>';
		
		//HIDDEN FIELDS
		$output .= '<div class="modal fade" id="hiddenFields" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-primary">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Hidden Fields</h4>
							  </div>
							  <div class="modal-body">
								
							  </div>
							  <div class="modal-footer align_center">
								<button type="button" class="btn btn-primary" data-dismiss="modal" data-form-id="">Done</button>
							  </div>
							</div>
						  </div>
						</div>';
		
		//ON SUBMIT
		$output .= '<div class="modal fade" id="onSubmit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-success">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">On form submission</h4>
							  </div>
							  <div class="modal-body">
							  <div class="row">	
							  	 <div class="col-xs-12">
								<label>On Form Submission</label><br />
								<input type="radio" name="on_form_submission" id="on_form_submission_message" value="message" checked="checked"> Show message&nbsp;&nbsp;<br /><input type="radio" name="on_form_submission" value="redirect" id="on_form_submission_redirect"> Redirect to URL
								</div><br /><br />&nbsp;
							  </div>
							  <div class="row confirmation_message">	
							  	 <div class="col-xs-12">
								<label>Show confirmation message</label>
								<textarea id="nex_autoresponder_on_screen_confirmation_message" name="on_screen_confirmation_message" class="form-control">Thank you for connecting with us.</textarea>
								</div>
							  </div>
							  <div class="row redirect_to_url hidden">	
							  	 <div class="col-xs-12">
								<label>Redirect To URL</label>
								<input data-tag-class="label-info" id="nex_autoresponder_confirmation_page" type="text" name="confirmation_page"  value="" class="form-control">
								</div>
							  </div>
							  
							  </div>
							  <div class="modal-footer align_center">
								<button type="button" class="btn btn-primary" data-dismiss="modal" data-form-id="">Done</button>
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
								<h4 class="modal-title" id="myModalLabel">Earn money by supporting NEX-Forms Express!</h4>
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
		$output .= '<div class="modal fade" id="previewForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
							  </div>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-success" data-dismiss="modal" data-form-id="">Done</button>
							  </div>
							</div>
						  </div>
						</div>';
		
		//ANIMATION
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
										<label>Run form drawing Animation?'.$lock.'</label>
										<div class="btn-group animate_form">
											<button class="btn btn-default btn-sm yes" type="button"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;Yes</button>
											<button class="btn btn-default btn-sm no btn-primary" type="button">&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>&nbsp;&nbsp;No</button>
										  </div>
									    </div>
									<div class="controls col-sm-6" >
										<label><span class="glyphicon glyphicon-time"></span>&nbsp;&nbsp;Animation Time (in seconds)'.$lock.'</label>
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
		
		
		//EXPRESS MSG
		$output .= '<div class="modal fade" id="express_msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-success">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">NEX-Forms Express</h4>
							  </div>
							  <div class="modal-body">
								<h3>Thank you for downloading NEX-Forms Express</h3>
								<p>You will find you can use the express version of this tool to a great extend that will enable you to create and customize forms. <br /><br />
								You will also notice there are locked features made available here to be tested (if you should need them). For your conveniance these features have not been taken away but are simply activated when you choose the pro-version.<br /><br /> 
								Wherever you see a '.$lock.' means that the feature, or form item, will be disabled(hidden) on your frontend (website) display even thought you can customize it, add it to your forms and even save it. If you decide to upgrade all saved data will still be available and that which where inactive will then be shown!<br /><br />
								You can find an interactive tutorial by clicking the blue button top right corner to help you.<br /><br />
								For any enqueries or support, <a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891/support?ref=Basix">please click here.</a>, but please note...Buyers always comes first.<br /><br />
								Thank you, we hope you enjoy this form builder as much as we did creating it <span class="fa fa-smile-o"></span></p>
							    <strong>Basix</strong>
							  </div>
							  <div class="modal-footer align_center">
								<a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix" class="btn btn-success">Go Pro</a>
								<button type="button" class="btn btn-default" data-dismiss="modal" data-form-id="">Use Express Version</button>
							  </div>
							</div>
						  </div>
						</div>';
		
		
		//NEX CONTAINER
		$output .= '<a href="#" class="express_msg hidden" data-toggle="modal" data-target="#express_msg"><span class="glyphicon fa fa-check"></span>&nbsp;&nbsp;</a><div id="nex-forms"><div class="form_update_id hidden"></div><link href="'.WP_PLUGIN_URL . '/nex-forms-express-wp-form-builder/css/font-awesome.min.css" rel="stylesheet">';
			
			
			
			$output .= '<div class="top-strip">';
			
				$output .= '<div class="row">';
					$output .= '<div class="controls col-sm-10" >';
								$output .= '<div class="row">';
									$output .= '<div class="col-sm-5" >';
									$output .= '<div class="btn-group bootstro" id="new_form" data-bootstro-title="Create a new form" data-bootstro-content="Click this button to start a blank form. If you have saved templates you can load them from this dropdown menu." data-bootstro-placement="bottom" data-bootstro-step="0">
											  <button type="button" class="btn btn-sm  btn-primary blank" ><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Form</button>
											  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											  </button>
											  <ul class="dropdown-menu"  role="menu">
												<li><a href="#" class="blank"><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;Blank</a></li>
												<!--<li class="divider"></li>
												<li><a href="#">Contact us</a></li>
												<li><a href="#">Paypal</a></li>-->
												<li class="divider"></li>
												<li class="disabled my_templates"><a href="#">Load Template</a></li>
											  </ul>
											</div>';
									//OPEN
									$output .= '<div class="btn-group bootstro" data-bootstro-title="Re-opening saved forms" data-bootstro-content="Click this button to find and to re-open your saved forms. Click on the trash icon to delete." data-bootstro-placement="bottom" data-bootstro-step="1">
											  <button type="button" class="btn btn-sm btn-primary "><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;Open</button>
											  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											  </button>
											  <ul class="dropdown-menu" role="menu" id="load_next_form">
											  <li class="disabled my_forms"><a href="#">My Forms</a></li>';
									$output .= '</ul></div>';
									//PREVIEW
									$output .= '<div class="btn-group bootstro" data-bootstro-title="Preview forms" data-bootstro-content="Click here to preview your form at any stage in your progress. Click the different devices to see how the form will behave on smaller and larger screens" data-bootstro-placement="bottom" data-bootstro-step="2">
											  <button type="button" class="btn btn-sm btn-primary preview_form" data-toggle="modal" data-target="#previewForm"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;Preview</button>
											  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											  </button>
											  <ul class="dropdown-menu" role="menu">
												<li><a href="#" class="preview_form full" data-toggle="modal" data-target="#previewForm"><span class="glyphicon fa fa-arrows-alt"></span>&nbsp;&nbsp;Full screen</a></li>
												<li><a href="#" class="preview_form desktop" data-toggle="modal" data-target="#previewForm"><span class="glyphicon fa fa-desktop"></span>&nbsp;&nbsp;Desktop</a></li>
												<li><a href="#" class="preview_form laptop" data-toggle="modal" data-target="#previewForm"><span class="glyphicon fa fa-laptop"></span>&nbsp;&nbsp;Laptop</a></li>
												<li><a href="#" class="preview_form tablet" data-toggle="modal" data-target="#previewForm"><span class="glyphicon fa fa-tablet"></span>&nbsp;&nbsp;Tablet</a></li>
												<li><a href="#" class="preview_form mobile" data-toggle="modal" data-target="#previewForm"><span class="glyphicon fa fa-mobile-phone"></span>&nbsp;&nbsp;Mobile</a></li>
											  </ul>
											</div>';
									//FORM SETTINGS
									$output .= '<div class="btn-group bootstro" data-bootstro-title="Form Settings" data-bootstro-content="Change the form\'s autoresponder(confirmation mails), animation, on form submission settings here. You can also view and export form entries from here. This includes the money making settings aswell!" data-bootstro-placement="bottom" data-bootstro-step="3">
											  <button type="button" class="btn btn-sm btn-primary preview_form" data-toggle="modal" data-target="#previewForm"><span class="glyphicon glyphicon-wrench"></span>&nbsp;&nbsp;Settings</button>
											  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											  </button>
											  <ul class="dropdown-menu" role="menu">
												<li><a href="#" class="autoRespond" data-toggle="modal" data-target="#autoRespond"><span class="glyphicon glyphicon-send"></span>&nbsp;&nbsp;Autoresponder Email</a></li>
												<!--<li><a href="#" class="animation" data-toggle="modal" data-target="#hiddenFields"><span class="glyphicon glyphicon-facetime-video"></span>&nbsp;&nbsp;Hidden Fields</a></li>-->
												
												<li><a href="#" class="onsubmit" data-toggle="modal" data-target="#onSubmit"><span class="glyphicon fa fa-check"></span>&nbsp;&nbsp;On Submit</a></li>
												<li><a href="#" class="animation" data-toggle="modal" data-target="#animationSettings"><span class="glyphicon glyphicon-facetime-video"></span>&nbsp;&nbsp;Form Animation'.$lock.'</a></li>
												<li><a href="#" class="animation" data-toggle="modal" data-target="#makeMoney"><span class="glyphicon fa fa-money"></span>&nbsp;&nbsp;Make Money</a></li>
												<li><a href="#" class="" data-toggle="modal" data-target="#formEntries"><span class="badge entry-count">0</span>&nbsp;&nbsp;Form Entries</a></li>
											  </ul>
											</div>';
									//SAVE
									$output .= '<div class="btn-group bootstro" data-bootstro-title="Save your form" data-bootstro-content="Click here to save your form. Click on the arrow to save your form as a template or to be used as both" data-bootstro-placement="bottom" data-bootstro-step="4">
											  <button type="button" class="btn btn-sm btn-success form_preview" id="save_nex_form"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Save Form</button>
											  <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											  </button>
											  <ul class="dropdown-menu" role="menu">
												<li class="disabled"><a href="#">Save as template:</a></li>
												<li class="divider"></li>
												<li><a href="#" id="save_nex_form"  class="template_only">Template only</a></li>
												<li><a href="#" id="save_nex_form"  class="form_and_template">Form and Template</a></li>
											  </ul>
											</div>';
									$output .= '</div>';
									$output .= '<div class="col-sm-3 bootstro" data-bootstro-title="Form title" data-bootstro-content="Enter or edit your form title here." data-bootstro-placement="bottom" data-bootstro-step="5" >';
										$output .= '<input class="form-control " name="the_form_title" id="the_form_title" placeholder="Add Form Title" data-placement="bottom" data-content="Form title can not be empty" title="">';
									$output .= '</div>';
								$output .= '</div>';
						$output .= '</div>';
					
					
					
					$output .= '<div class="controls col-sm-1" >';
								
								
					$output .= '<div class="btn-group logo bootstro" data-bootstro-title="Help and support" data-bootstro-content="This is where you can find this tutorial as well as documentation and a support form. <br /><br />Check out our profile from time to time as more of this awsomeness will be showcased!!" data-bootstro-placement="bottom" data-bootstro-step="6">
									  <a href="http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix" type="button" class="btn logo btn-success"><span class="glyphicon glyphicon-fire"></span>&nbsp;&nbsp;Go Pro!</a>
									  <button type="button" class="btn logo btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
												<span class="fa fa-question-circle"></span>
												<span class="sr-only">Toggle Dropdown</span>
											  </button>
									  <ul class="dropdown-menu" role="menu">
										<li><a href="#" class="tutorial"><i class="glyphicon glyphicon-comment"></i>&nbsp;&nbsp;Tutorial<br /><em><small>Using this builder</small></em></a></li>
										<li><a href="http://codecanyon.net/user/Basix/portfolio?ref=Basix" target="_blank"><i class="glyphicon glyphicon-link"></i>&nbsp;&nbsp;Visit Basix<br /><em><small>Check out more items</small></em></a></li>
									  </ul>
									</div>';
				$output .= '</div>';
				$output .= '</div>';
				
				
				
				
					
				$output .= '</div>';
			$output .= '<div style="clear:both;"></div>';
			
			
			
			$output .= '<div class="row admin-layout alert-info">';
			
			
				/*$output .= '<div class="col-sm-2 admin-layout">';
									
									$output .= '<div class="panel panel-default admin-panel">';
									
									//FORM SETUP
										$output .= '<div class="panel-heading">';
											$output .= '<h4 class="panel-title label-info">';
												$output .= '<a data-toggle="collapse" data-parent="#accordion3" href="#general_settings">';
													$output .= '<span class="glyphicon glyphicon-wrench"></span>&nbsp;&nbsp;Form Setup<span class="caret"></span>';
												$output .= '</a>';
											$output .= '</h4>';
										$output .= '</div>';
										$output .= '<div id="general_settings" class="panel-collapse in" >';
											$output .= '<div class="panel-body">';
											$output .= '</div>';
										$output .= '</div>';
									
									//STYLING
										$output .= '<div class="panel-heading">';
											$output .= '<h4 class="panel-title label-info">';
												$output .= '<a data-toggle="collapse" data-parent="#accordion3" href="#styling">';
												$output .= '<span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;Styling<span class="caret"></span>';
												$output .= '</a>';
											$output .= '</h4>';
										$output .= '</div>';
										$output .= '<div id="styling" class="panel-collapse  collapse in" >';
											$output .= '<div class="panel-body">';
											$output .= '</div>';
										$output .= '</div>';
									//ANIMATION
										$output .= '<div class="panel-heading">';
											$output .= '<h4 class="panel-title label-info">';
												$output .= '<a data-toggle="collapse" data-parent="#accordion3" href="#animation">';
												$output .= '<span class="glyphicon glyphicon-facetime-video"></span>&nbsp;&nbsp;Animation<span class="caret"></span>';
												$output .= '</a>';
											$output .= '</h4>';
										$output .= '</div>';
										$output .= '<div id="animation" class="panel-collapse collapse in" >';
											$output .= '<div class="panel-body">';
											
											$output .= '</div>';
										$output .= '</div>';
								
								//.panel
								$output .= '</div>';
				
				
			//#col-sx-5
			$output .= '</div>';*/
			
			$output .= '<div class="col-sm-12 admin-layout">';
				/*$output .= '<div class="colmask threecol">';
					$output .= '<div class="colmid">';
						$output .= '<div class="colleft">';
							
							$output .= '</div>';
							$output .= '<div class="col2">';
								$output .= '<div class="panel panel-default">';
									$output .= '<div class="panel-heading">Column</div>';
									$output .= '<div class="panel-body">';
										$output .= ' Panel content';
									$output .= ' </div>';
								$output .= '</div>';
							$output .= '</div>';
							$output .= '<div class="col3">';
								
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';*/
				
				$output .= '<div class="colmask rightmenu forms-canvas">';
					$output .= '<div class="colleft">';
						$output .= '<div class="col1 bootstro" data-bootstro-title="Form Elements" data-bootstro-content="Find all you need to create forms in this menu. Simply click or drag an element from here to the open space on the right." data-bootstro-placement="right" data-bootstro-step="7">';
							
						
					
					$output .= '<div class="panel-group admin-panel" id="accordion">';
					//GRID SYSTEM
						$output .= '<div class="panel-heading bootstro" data-bootstro-title="Grid system" data-bootstro-content="Use the grid system to create any type of layout you desire! Note that grids can be nested so be creative!" data-bootstro-placement="bottom" data-bootstro-step="8">';
							$output .= '<h4 class="panel-title"  style="background-color:#E0D9EA !important;color:#6F5499;">';
								$output .= '<a data-toggle="collapse" href="#collapseGridSystem" data-parent="#accordion">';
								$output .= '<span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Grid System'.$lock.'<span class="caret"></span><br /><em><small >Form Layout made easy</small></em>';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapseGridSystem" class="panel-collapse collapse in">';
							$output .= '<div class="panel-body">';
								
								//1 Column
								$output .= '<div class="field form_field grid grid-system">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control">1 Col&nbsp;&nbsp;&nbsp;<i class="label label-primary">12</i></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
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
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								//2 Columns
								$output .= '<div class="field form_field grid grid-system">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control">2 Cols  <i class="label label-success">6 6</i></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
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
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								$output .= '<div class="field form_field grid grid-system">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control">3 Cols  <i class="label label-warning">4 4 4</i></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
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
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								$output .= '<div class="field form_field grid grid-system">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control">4 Cols  <i class="label label-danger">3 3 3 3</i></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
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
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								$output .= '<div class="field form_field grid grid-system">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control">6 Cols  <i class="label label-default">2 2 2 2 2 2</i></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
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
											$output .= '</div>';								
											//.panel-body	
										$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</div>';
					
				//COMMON FIELDS
						$output .= '<div class="panel-heading alert-warning bootstro"  data-bootstro-title="Common fields" data-bootstro-content="Here you will find your most common fields allthough they look and function much better than the ordinary default.<br /><br />Includes: single line text, multiline text, select dropdown, multi select dropdown, radio buttons and checkboxes." data-bootstro-placement="right" data-bootstro-step="9">';
							$output .= '<h4 class="panel-title alert-warning"  style="background-color:#FAEBCC !important">';
								$output .= '<a class=" " data-toggle="collapse" data-parent="#accordion" href="#collapseOne">';
								$output .= '<span class="glyphicon glyphicon-arrow-right"></span>&nbsp;&nbsp;Common Fields <span class="caret"></span><br /><em><small >And yet, not that common</small></em>';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapseOne" class="panel-collapse  collapse in">';
							$output .= '<div class="panel-body ">';
						
						//BUTTON
								$output .= '<div class="field form_field submit-button">';
									$output .= '<div class="draggable_object input-group ">';
										$output .= '<button class="btn btn-success btn-sm form-control"><i class=" glyphicon glyphicon glyphicon-send"></i>&nbsp;&nbsp;<span class="field_title">Submit Button</span></button>';
										$output .= '<span class="input-group-addon"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																		$output .= '<button class="nex-submit svg_ready the_input_element btn btn-primary">Submit</button><br />
																		<small class="svg_ready"><a href="http://codecanyon.net/user/Basix/portfolio?ref=Basix" target="_blank"></a></small>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
						
								
						//TEXT FIELD
								$output .= '<div class="field form_field text">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon-minus"></i>&nbsp;&nbsp;<span class="field_title">Text Field</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row ">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Text Field</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																	$output .= '<div class="input-inner" data-svg="demo-input-1">';
																		$output .= '<input id="ve_text" type="text" name="text_field" placeholder="Text Field" data-maxlength-color="label label-success" data-maxlength-position="bottom" data-maxlength-show="false" data-default-value="" maxlength="200" class="error_message svg_ready the_input_element text pre-format form-control" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" data-secondary-message="" title="">';
																		$output .= '<span class="help-block">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';								
								
						//TEXT AREA
								$output .= '<div class="field form_field textarea">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon-align-justify"></i>&nbsp;&nbsp;<span class="field_title">Text Area</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Text Area</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<textarea name="textarea" id="textarea" placeholder="Text Area"  data-maxlength-color="label label-success" data-maxlength-position="bottom" data-maxlength-show="false" data-default-value="" class="error_message svg_ready the_input_element textarea pre-format form-control" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title=""></textarea>';
																	$output .= '<span class="help-block">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
						//SELECT
								$output .= '<div class="field form_field select">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;<span class="field_title">Select</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Select</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<select name="select" data-backgound-color="#FFFFFF" data-text-color="#000000" data-input-size="" data-font-family="" data-bold-text="false" data-italic-text="false" data-text-alignment="left" data-border-color="#CCCCCC" data-required="false" class="the_input_element error_message text pre-format form-control" id="select" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-error-class="alert-default"  data-placement="bottom" data-content="Please select an option" title="">
																					<option value="0" selected="selected">--- Select ---</option>
																					<option>Option 1</option>
																					<option>Option 2</option>
																					<option>Option 3</option>
																				</select>';
																	$output .= '<span class="help-block">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';							
						
								//MULTI SELECT
								$output .= '<div class="field form_field multi-select">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon-sort-by-attributes-alt"></i>&nbsp;&nbsp;<span class="field_title">Multi-Select</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Multi Select</span><br /><small class="sub-text style_italic">Sub text</small></label>';
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
																	$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
								
						
						//RADIO BUTTONS
							$output .= '<div class="field form_field radio-group">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon-ok-circle"></i>&nbsp;&nbsp;<span class="field_title">Radio Buttons</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Radio Group</span><br /><small class="sub-text style_italic">Sub text</small></label>';
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
																	$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
													$output .= '</div>';
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
								

						
						//CHECK BOXES
							$output .= '<div class="field form_field check-group">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon-check"></i>&nbsp;&nbsp;<span class="field_title">Check Boxes</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder radio-group no-pre-suffix">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Checbox Group</span><br /><small class="sub-text style_italic">Sub text</small></label>';
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
																	$output .= '<span class="help-block">Help text...</span>';
																	$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											
									$output .= '</div>';
								$output .= '</div>';
						
						
						
								
						
								
							//.panel-body	
							$output .= '</div>';
						$output .= '</div>';
				
				
				//EXTENDED FIELDS
				$output .= '<div class="panel-heading alert-success bootstro" data-bootstro-title="Extended fields" data-bootstro-content="This is where you will find all the fields that provide good looking and easy to use form inputs<br /><br />Includes: Star rating, slider, spinner, tags (keywords) input, autocomplete, colorpallet, data and time" data-bootstro-placement="right" data-bootstro-step="10">';
							$output .= '<h4 class="panel-title alert-success">';
								$output .= '<a class="" data-toggle="collapse" data-parent="#accordion" href="#collapseCoolfields">';
								$output .= '<span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;Extended Fields'.$lock.'<span class="caret"></span><br /><em><small class="">Fields with a cool twist</small></em>';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapseCoolfields" class="panel-collapse collapse in">';
							$output .= '<div class="panel-body">';
								
								
							//STAR RATING
							/*	$output .= '<div class="field form_field star-rating">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon-star"></i>&nbsp;&nbsp;<span class="field_title">reCAPTCHA</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Star Rating</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<div class="the_object"></div><div class="the_container"></div>';
																	$output .= '<span class="help-block">Drag the small sircle into the big circle to prove you are human</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';		*/
								
							//STAR RATING
								$output .= '<div class="field form_field star-rating">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon-star"></i>&nbsp;&nbsp;<span class="field_title">Star Rating</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Star Rating</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																	$output .= '<div id="star" data-total-stars="5" data-enable-half="false" class="error_message svg_ready bs-tooltip" style="cursor: pointer;" data-placement="bottom" data-content="Please select a star" title=""></div>';
																	$output .= '<span class="help-block">Help text...</span>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';		
								
								
								
							//SLIDER
								$output .= '<div class="field form_field slider">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon-resize-horizontal"></i>&nbsp;&nbsp;<span class="field_title">Slider</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Slider</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<div class="error_message slider svg_ready" id="slider" data-fill-color="#f2f2f2" data-min-value="0" data-max-value="100" data-starting-value="0" data-background-color="#ffffff" data-slider-border-color="#CCCCCC" data-handel-border-color="#CCCCCC" data-handel-background-color="#FFFFFF" data-text-color="#000000" data-dragicon="" data-dragicon-class="btn btn-default" data-count-text="{x}"  data-placement="bottom" data-content="Please select a value" title=""></div>';
																	$output .= '<input name="slider" class="hidden the_input_element the_slider" type="text">';
																	$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';	
								
								
								
								//SPINNER
								$output .= '<div class="field form_field touch_spinner">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon glyphicon-resize-vertical"></i>&nbsp;&nbsp;<span class="field_title">Spinner</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Spinner</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<input name="spinner" type="text" id="spinner" class="error_message the_spinner svg_ready the_input_element form-control bs-tooltip" data-minimum="0" data-maximum="100" data-step="1" data-starting-value="0" data-decimals="0"  data-postfix-icon="" data-prefix-icon="" data-postfix-text="" data-prefix-text="" data-postfix-class="btn-default" data-prefix-class="btn-default" data-down-icon="fa fa-minus" data-up-icon="fa fa-plus" data-down-class="btn-default" data-up-class="btn-default" data-placement="bottom" data-content="Please supply a value" title="" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" />';
																$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								//TAGS
								$output .= '<div class="field form_field tags">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon-tags"></i>&nbsp;&nbsp;<span class="field_title">Tags</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Tags</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<input id="tags" value="" name="tags" type="text" class="tags error_message bs-tooltip the_input_element" data-max-tags="" data-tag-class="label-info" data-tag-icon="fa fa-tag" data-border-color="#CCCCCC" data-background-color="#FFFFFF" data-placement="bottom" data-content="Please enter a value" title="">';
																
																$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								
								//AUTO COMPLETE
								$output .= '<div class="field form_field autocomplete">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="glyphicon glyphicon-th-list"></i>&nbsp;&nbsp;<span class="field_title">Auto complete</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Auto Complete</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1">';
																$output .= '<input id="autocomplete" value="" name="autocomplete" type="text" class="error_message svg_ready form-control bs-tooltip the_input_element" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-text-color="#000000" data-border-color="#CCCCCC" data-background-color="#FFFFFF" data-placement="bottom" data-content="Please enter a value" title="">';
																$output .= '<div style="display:none;" class="get_auto_complete_items"></div>';
																$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
														$output .= '</div>';												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								
								
								//COLOR PALLET
								$output .= '<div class="field form_field color_pallet">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="glyphicon glyphicon-th-large"></i>&nbsp;&nbsp;<span class="field_title">Color Pallet</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Color Pallet</span><br /><small class="sub-text style_italic">Sub text</small></label>';
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
																$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
														$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								
								
								//DATE TIME
								$output .= '<div class="field form_field datetime">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon-calendar"></i>&nbsp;&nbsp;<span class="field_title">Date+Time</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Date Time</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date" id="datetimepicker">';
															$output .= '<span class="input-group-addon prefix"><span class="glyphicon glyphicon-calendar"></span></span>';
															$output .= '<input type="text" class="error_message form-control the_input_element bs-tooltip" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please select a date and time" title="" />';
															$output .= '</div></div>';
																$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								//DATE
								$output .= '<div class="field form_field date">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon-calendar"></i>&nbsp;&nbsp;<span class="field_title">Date</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Date</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date" id="datetimepicker">';
																$output .= '<span class="input-group-addon prefix"><span class="glyphicon glyphicon-calendar"></span></span>';
																$output .= '<input type="text" class="error_message form-control the_input_element bs-tooltip" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please select a date" title="" />';
																$output .= '</div></div>';
																$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
														
													
												
												
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								
								
								
								//TIME
								$output .= '<div class="field form_field time">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class=" glyphicon glyphicon-time"></i>&nbsp;&nbsp;<span class="field_title">Time</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Time</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date" id="datetimepicker">';
															$output .= '<span class="input-group-addon prefix"><span class="glyphicon glyphicon-time"></span></span>';
															$output .= '<input type="text" class="error_message form-control the_input_element bs-tooltip" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please select a time" title="" />';
															$output .= '</div></div>';
																$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
				//.panel-body	
							$output .= '</div>';
						$output .= '</div>';
				
					
				//UPLOADERS
						$output .= '<div class="panel-heading alert-info bootstro" data-bootstro-title="File Uploaders" data-bootstro-content="Use these uplaoders to capture files and images from your users. Although both image and file uploaders can accept any file extesion (as specified) the image uploader comes with an image preview." data-bootstro-placement="right" data-bootstro-step="11">';
							$output .= '<h4 class="panel-title alert-info">';
								$output .= '<a class="" data-toggle="collapse" data-parent="#accordion" href="#collapseUploaders">';
								$output .= '<span class="glyphicon glyphicon-upload"></span>&nbsp;&nbsp;Uploaders'.$lock.'<span class="caret"></span><br /><em><small class="">File and image</small></em>';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapseUploaders" class="panel-collapse collapse in">';
							$output .= '<div class="panel-body">';
								
								
								
								//SINGLE FILE
								$output .= '<div class="field form_field upload-single">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="glyphicon glyphicon-file"></i>&nbsp;&nbsp;<span class="field_title">File Upload</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">File Upload</span><br /><small class="sub-text style_italic">Sub text</small></label>';
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
																$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								
								//IMAGE
								$output .= '<div class="field form_field upload-image">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="glyphicon glyphicon-picture"></i>&nbsp;&nbsp;<span class="field_title">Image Upload</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder no-pre-suffix">';
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Image Upload</span><br /><small class="sub-text style_italic">Sub text</small></label>';
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
																$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								
								
				
				//.panel-body	
							$output .= '</div>';
						$output .= '</div>';
				
				
				
				
				
				
				//CUSTOM FIELDS
				
						$output .= '<div class="panel-heading alert-danger bootstro" data-bootstro-title="Custom fields" data-bootstro-content="This gives you freedom to create fields with prefix, postfix or both pre and post fix icons. For example prefix the facebook logo icon and ask for the user\'s FB page link! With just under 450 icons to select you can be very creative with this.<br /><br />These custom fields can be validated as email, url, number, digits only, text only." data-bootstro-placement="right" data-bootstro-step="12">';
							$output .= '<h4 class="panel-title alert-danger">';
								$output .= '<a data-toggle="collapse" data-parent="#accordion" href="#collapsePreformat">';
								$output .= '<span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;Custom Fields'.$lock.'<span class="caret"></span><br /><em><small class="">Create your own!</small></em>';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapsePreformat" class="panel-collapse collapse  in">';
							$output .= '<div class="panel-body ">';
								
								
								
							//CUSTOM PREFIX
								$output .= '<div class="field form_field custom-prefix" >';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="glyphicon fa fa-question-circle"></i>&nbsp;&nbsp;<span class="field_title">Pre-fix</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Custom field</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date">';
																$output .= '<span class="input-group-addon prefix"><span class="glyphicon"></span></span>';
																$output .= '<input type="text" class="error_message  form-control the_input_element bs-tooltip" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message=""/>';
																$output .= '</div></div>';
																$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
														
													$output .= '</div>';
												
												
												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								//CUSTOM POSTFIX
								$output .= '<div class="field form_field custom-postfix">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="glyphicon fa fa-question-circle"></i>&nbsp;&nbsp;<span class="field_title">Post-fix</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Custom field</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group">';
															
															$output .= '<input type="text" class="error_message form-control the_input_element bs-tooltip" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message="" />';
															$output .= '<span class="input-group-addon postfix"><span class="glyphicon"></span></span>';
															$output .= '</div></div>';
																$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								//CUSTOM PRE-POST
								$output .= '<div class="field form_field custom-pre-postfix">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="glyphicon fa fa-question-circle"></i>&nbsp;&nbsp;<span class="field_title">Pre/Post-fix</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												
												
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-2">';
																	$output .= '<label id="title" class="title ve_title"><span class="is_required glyphicon glyphicon-star btn-xs hidden"></span><span class="the_label style_bold">Custom field</span><br /><small class="sub-text style_italic">Sub text</small></label>';
																$output .= '</div>';
																$output .= '<div class="col-sm-10">';
																$output .= '<div class="input-inner" data-svg="demo-input-1"><div class="svg_ready">';
																$output .= '<div class="input-group date">';
															$output .= '<span class="input-group-addon prefix"><span class="glyphicon"></span></span>';
															$output .= '<input type="text" class="error_message form-control the_input_element bs-tooltip" data-onfocus-color="#66AFE9" data-drop-focus-swadow="1" data-placement="bottom" data-content="Please enter a value" title="" data-secondary-message="" />';
															$output .= '<span class="input-group-addon postfix"><span class="glyphicon"></span></span>';
															$output .= '</div></div>';
																$output .= '<span class="help-block">Help text...</span>';
																$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
															
														$output .= '</div>';
													$output .= '</div>';												
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
							
															
							//.panel-body	
							$output .= '</div>';
						$output .= '</div>';
			
			//PANELS
			
						/*$output .= '<div class="panel-heading bootstro" data-bootstro-title="Panel layouts" data-bootstro-content="Panels behave the same (and can do the same) as the grid system accept here you can change a few settings and have your form fields grouped by title" data-bootstro-placement="right" data-bootstro-step="12">';
							$output .= '<h4 class="panel-title" style="background-color:#E0D9EA !important;color:#6F5499;">';
								$output .= '<a data-toggle="collapse" data-parent="#accordion" href="#collapsePanelGroup">';
								$output .= '<span class="glyphicon fa fa-columns"></span>&nbsp;&nbsp;Panels<span class="caret"></span><br /><em><small>Grouping form elements</small></em>';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapsePanelGroup" class="panel-collapse collapse in">';
							$output .= '<div class="panel-body">';
								
								//1 Column
								$output .= '<div class="field form_field grid">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control">1 Col  <span class="label label-default">12</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input-inner" data-svg="demo-input-1">';
												$output .= '<div class="row">';
													$output .= '<div class="input_holder col-sm-12">';
														$output .= '<div class="panel panel-default the_input_element">';
															$output .= '<div class="panel-heading">Column</div>';
															$output .= '<div class="panel-body">';
															$output .= '</div>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
										$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
											$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
											$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
										$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								//2 Columns
								$output .= '<div class="field form_field grid">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control">2 Cols  <span class="label label-default">6 6</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
												$output .= '<div class="input-inner" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="input_holder col-sm-6">';
															$output .= '<div class="panel panel-default">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-6">';
															$output .= '<div class="panel panel-default">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								$output .= '<div class="field form_field grid">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control">3 Cols  <span class="label label-default">4 4 4</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
												$output .= '<div class="input-inner" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="input_holder col-sm-4">';
															$output .= '<div class="panel panel-default">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-4">';
															$output .= '<div class="panel panel-default">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-4">';
															$output .= '<div class="panel panel-default">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								$output .= '<div class="field form_field grid">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control">4 Cols  <span class="label label-default">3 3 3 3</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
												$output .= '<div class="input-inner" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="input_holder col-sm-3">';
															$output .= '<div class="panel panel-default">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-3">';
															$output .= '<div class="panel panel-default">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-3">';
															$output .= '<div class="panel panel-default">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-3">';
															$output .= '<div class="panel panel-default">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								$output .= '<div class="field form_field grid">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control">6 Cols  <span class="label label-default">2 2 2 2 2 2</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
												$output .= '<div class="input-inner" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="input_holder col-sm-2">';
															$output .= '<div class="panel panel-default">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-2">';
															$output .= '<div class="panel panel-default svg_ready">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-2">';
															$output .= '<div class="panel panel-default svg_ready">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-2">';
															$output .= '<div class="panel panel-default svg_ready">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-2">';
															$output .= '<div class="panel panel-default svg_ready">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
													$output .= '<div class="input_holder col-sm-2">';
															$output .= '<div class="panel panel-default">';
																$output .= '<div class="panel-heading">Column</div>';
																$output .= '<div class="panel-body">';
																$output .= '</div>';
															$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
							//.panel-body	
										$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</div>';*/
			
			
			//OTHER ELEMENTS
				
						$output .= '<div class="panel-heading bootstro" data-bootstro-title="Other elements" data-bootstro-content="Use these to spice up your forms even more.<br /><br />Includes: Panels, horizontal divider, paragraph, headings 1-6" data-bootstro-placement="right" data-bootstro-step="13">';
							$output .= '<h4 class="panel-title">';
								$output .= '<a data-toggle="collapse" data-parent="#accordion" href="#collapseOther">';
								$output .= '<span class="glyphicon fa fa-flash"></span>&nbsp;&nbsp;Other Elements<span class="caret"></span><br /><em><small class="">Fine tuning</small></em>';
								$output .= '</a>';
							$output .= '</h4>';
						$output .= '</div>';
						$output .= '<div id="collapseOther" class="panel-collapse collapse  in">';
							$output .= '<div class="panel-body ">';
								
							//Panel
								$output .= '<div class="field form_field grid">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="fa fa-square-o"></i>&nbsp;&nbsp;Panel</button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
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
											$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
											$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
										$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
							//PARAGRAPH
								$output .= '<div class="field form_field paragraph">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="fa fa-align-justify"></i>&nbsp;&nbsp;<span class="field_title">Paragraph</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
									$output .= '</div>';
									$output .= '<div id="form_object" class="form_object" style="display:none;">';
											$output .= '<div class="input_holder">';
												$output .= '<div class="input-inner svg_ready" data-svg="demo-input-1">';
													$output .= '<div class="row">';
														$output .= '<div class="col-sm-12" id="field_container">';
															$output .= '<div class="row">';
																$output .= '<div class="col-sm-12">';
																$output .= '<div class="input-group date svg_ready">';
																	$output .= '<p class="the_input_element">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><div style="clear:both;"></div>';
																	$output .= '</div>';
																$output .= '</div>';
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="field_settings bs-callout bs-callout-info" style="display:none;">';
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
							
						//DIVIDER
								$output .= '<div class="field form_field divider">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="fa fa-minus"></i>&nbsp;&nbsp;<span class="field_title">Divider</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
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
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
							//H1
								$output .= '<div class="field form_field heading">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="glyphicon">H1</i>&nbsp;&nbsp;<span class="field_title">Heading 1</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
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
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
							//H2	
								$output .= '<div class="field form_field heading">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="glyphicon">H2</i>&nbsp;&nbsp;<span class="field_title">Heading 2</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
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
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								//H3	
								$output .= '<div class="field form_field heading">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="glyphicon">H3</i>&nbsp;&nbsp;<span class="field_title">Heading 3</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
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
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								//H4	
								$output .= '<div class="field form_field heading">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="glyphicon">H4</i>&nbsp;&nbsp;<span class="field_title">Heading 4</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
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
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								
								//H5	
								$output .= '<div class="field form_field heading">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="glyphicon">H5</i>&nbsp;&nbsp;<span class="field_title">Heading 5</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
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
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
								
								//H6	
								$output .= '<div class="field form_field heading">';
									$output .= '<div class="draggable_object input-group">';
										$output .= '<button class="btn btn-default btn-sm form-control"><i class="glyphicon">H6</i>&nbsp;&nbsp;<span class="field_title">Heading 6</span></button>';
										$output .= '<span class="input-group-addon btn-default"><i class=" glyphicon glyphicon-move"></i></span>';
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
															$output .= '<button class="btn btn-danger btn-sm delete"><i class="glyphicon glyphicon-remove"></i></button>';
														 	$output .= '<button class="btn btn-info btn-sm edit"><i class="glyphicon glyphicon-pencil"></i></button>';
														$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
											$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
							
															
							//.panel-body	
							$output .= '</div>';
						$output .= '</div>';
			
			
			
							
			//CLIPBOARD
							$output .= '<div class="panel-heading  bootstro" data-bootstro-title="The Clipboard" data-bootstro-content="After a field has been created to perfection you can add it to the clipboard to be used in a different form as well! Click on the clipboard icon while editing a field to see it here." data-bootstro-placement="right" data-bootstro-step="14">';
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
						$output .= '</div>';
							
							
					$output .= '</div>';
							
							
							
							
							
								
							$output .= '</div>';
							$output .= '<div class="col2">';
						
							$output .= NEXFormsExpress_admin::NEXFormsExpress_field_settings();
								$output .= '<div class="panel panel-default admin-panel">';
									$output .= '<div class="panel-heading">';
										$output .= '<span class="btn btn-primary glyphicon glyphicon-hand-down"></span>';
									$output .= '</div>';
									$output .= '<div id="collapseFormsCanvas" class="panel-collapse in" >';
										$output .= '<div class="panel-body nex-forms-container  bootstro" data-bootstro-title="Form Canvas" data-bootstro-content="This is where you will construct your forms. Drag form elements here or click them to be appended at the end of existing form content." data-bootstro-placement="left" data-bootstro-step="15">
														<div class="run_animation hidden">false</div>
														<div class="animation_time hidden">60</div>
														<div class="trash-can form_field grid ui-draggable dropped bootstro" data-bootstro-title="Trash Can" data-bootstro-content="This is just a cool way to dispose of unwanted form elements. You simply drag the element into this trash can and it will be gone. <br /><br />Alternatively you can delete a form element from the editing panel." data-bootstro-placement="top" data-bootstro-step="16" style="display: block;" id="_73800">

														  <div style="" class="form_object" id="form_object">
															<div data-svg="demo-input-1" class="input-inner do_show">
															  <div class="row">
																<div class="input_holder col-sm-12">
																  <div class="panel panel-default">
																	<div class="panel-body ui-droppable ui-sortable"><span class="glyphicon glyphicon-trash"></span></div>
																  </div>
																</div>
															  </div>
															</div>
														  </div>
														</div>
														</div></div>';
										//.panel-body	
										$output .= '</div>';										
									$output .= '</div>';
								$output .= '</div>';
								
							$output .= '</div>';
						
						
						/*********************** FORM ENTRIES ****************************/
						
				
				/*$output .= '<div class="colmask rightmenu forms-entries" style="display:none;padding:20px;">';
					
								$output .= '<div class="panel panel-default">';
									$output .= '<div class="panel-heading">Form Entries';
									$output .= '</div>';
									$output .= '<div id="collapseFormsCanvas" class="panel-collapse in" >';
										$output .= '<div class="panel-body nex-forms-entries">No entries yet...</div>';
										//.panel-body	
										$output .= '</div>';										
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</div>';
						//.col2
					$output .= '</div>';
				$output .= '</div>';
						*/
						
						
						
						
						/*********************** AUTO RESPONDER ****************************/
						
				/*	$output .= '<div class="colmask rightmenu forms-autoresponder" style="display:none;">';
					$output .= '<div class="colleft">';
						$output .= '<div class="col1">Col left';
							$output .= '</div>';
							$output .= '<div class="col2">';
								$output .= '<div class="panel panel-default admin-panel">';
									$output .= '<div class="panel-heading">';
										$output .= '<span class="btn btn-primary glyphicon glyphicon-hand-down"></span>';
									$output .= '</div>';
									$output .= '<div id="collapseFormsCanvas" class="panel-collapse in" >';
										$output .= '<div class="panel-body nex-forms-autoresponder">Cneter</div>';
									
										//.panel-body	
										$output .= '</div>';										
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</div>';
						//.col2
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';*/
						
						
						
						
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
	

$output = '<i class="fa fa-rub "></i>
<i class="fa fa-toggle-left fa-spin"></i>
<i class="fa fa-dot-circle-o fa-spin"></i>
<i class="fa fa-wheelchair"></i>
<i class="fa fa-vimeo-square"></i>
<i class="fa fa-try"></i>
<i class="fa fa-turkish-lira"></i>
<i class="fa fa-plus-square-o"></i>
<i class="fa fa-adjust"></i>
<i class="fa fa-anchor"></i>
<i class="fa fa-archive"></i>
<i class="fa fa-arrows"></i>
<i class="fa fa-arrows-h"></i>
<i class="fa fa-arrows-v"></i>
<i class="fa fa-asterisk"></i>
<i class="fa fa-ban"></i>
<i class="fa fa-bar-chart-o"></i>
<i class="fa fa-barcode"></i>
<i class="fa fa-bars"></i>
<i class="fa fa-beer"></i>
<i class="fa fa-bell"></i>
<i class="fa fa-bell-o"></i>
<i class="fa fa-bolt"></i>
<i class="fa fa-book"></i>
<i class="fa fa-bookmark"></i>
<i class="fa fa-bookmark-o"></i>
<i class="fa fa-briefcase"></i>
<i class="fa fa-bug"></i>
<i class="fa fa-building-o"></i>
<i class="fa fa-bullhorn"></i>
<i class="fa fa-bullseye"></i>
<i class="fa fa-calendar"></i>
<i class="fa fa-calendar-o"></i>
<i class="fa fa-camera"></i>
<i class="fa fa-camera-retro"></i>
<i class="fa fa-caret-square-o-down"></i>
<i class="fa fa-caret-square-o-left"></i>
<i class="fa fa-caret-square-o-right"></i>
<i class="fa fa-caret-square-o-up"></i>
<i class="fa fa-certificate"></i>
<i class="fa fa-check"></i>
<i class="fa fa-check-circle"></i>
<i class="fa fa-check-circle-o"></i>
<i class="fa fa-check-square"></i>
<i class="fa fa-check-square-o"></i>
<i class="fa fa-circle"></i>
<i class="fa fa-circle-o"></i>
<i class="fa fa-clock-o"></i>
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
<i class="fa fa-credit-card"></i>
<i class="fa fa-crop"></i>
<i class="fa fa-crosshairs"></i>
<i class="fa fa-cutlery"></i>
<i class="fa fa-dashboard"></i>
<i class="fa fa-desktop"></i>
<i class="fa fa-dot-circle-o"></i>
<i class="fa fa-download"></i>
<i class="fa fa-edit"></i>
<i class="fa fa-ellipsis-h"></i>
<i class="fa fa-ellipsis-v"></i>
<i class="fa fa-envelope"></i>
<i class="fa fa-envelope-o"></i>
<i class="fa fa-eraser"></i>
<i class="fa fa-exchange"></i>
<i class="fa fa-exclamation"></i>
<i class="fa fa-exclamation-circle"></i>
<i class="fa fa-external-link"></i>
<i class="fa fa-external-link-square"></i>
<i class="fa fa-eye"></i>
<i class="fa fa-eye-slash"></i>
<i class="fa fa-female"></i>
<i class="fa fa-fighter-jet"></i>
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
<i class="fa fa-gamepad"></i>
<i class="fa fa-gavel"></i>
<i class="fa fa-gear"></i>
<i class="fa fa-gears"></i>
<i class="fa fa-gift"></i>
<i class="fa fa-glass"></i>
<i class="fa fa-globe"></i>
<i class="fa fa-group"></i>
<i class="fa fa-hdd-o"></i>
<i class="fa fa-headphones"></i>
<i class="fa fa-heart"></i>
<i class="fa fa-heart-o"></i>
<i class="fa fa-home"></i>
<i class="fa fa-inbox"></i>
<i class="fa fa-info"></i>
<i class="fa fa-info-circle"></i>
<i class="fa fa-key"></i>
<i class="fa fa-keyboard-o"></i>
<i class="fa fa-laptop"></i>
<i class="fa fa-leaf"></i>
<i class="fa fa-legal"></i>
<i class="fa fa-lemon-o"></i>
<i class="fa fa-level-down"></i>
<i class="fa fa-level-up"></i>
<i class="fa fa-lightbulb-o"></i>
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
<i class="fa fa-music"></i>
<i class="fa fa-pencil"></i>
<i class="fa fa-pencil-square"></i>
<i class="fa fa-pencil-square-o"></i>
<i class="fa fa-phone"></i>
<i class="fa fa-phone-square"></i>
<i class="fa fa-picture-o"></i>
<i class="fa fa-plane"></i>
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
<i class="fa fa-refresh"></i>
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
<i class="fa fa-share"></i>
<i class="fa fa-share-square"></i>
<i class="fa fa-share-square-o"></i>
<i class="fa fa-shield"></i>
<i class="fa fa-shopping-cart"></i>
<i class="fa fa-sign-in"></i>
<i class="fa fa-sign-out"></i>
<i class="fa fa-signal"></i>
<i class="fa fa-sitemap"></i>
<i class="fa fa-smile-o"></i>
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
<i class="fa fa-spinner"></i>
<i class="fa fa-square"></i>
<i class="fa fa-square-o"></i>
<i class="fa fa-star"></i>
<i class="fa fa-star-half"></i>
<i class="fa fa-star-half-empty"></i>
<i class="fa fa-star-half-full"></i>
<i class="fa fa-star-half-o"></i>
<i class="fa fa-star-o"></i>
<i class="fa fa-subscript"></i>
<i class="fa fa-suitcase"></i>
<i class="fa fa-sun-o"></i>
<i class="fa fa-superscript"></i>
<i class="fa fa-tablet"></i>
<i class="fa fa-tachometer"></i>
<i class="fa fa-tag"></i>
<i class="fa fa-tags"></i>
<i class="fa fa-tasks"></i>
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
<i class="fa fa-toggle-right"></i>
<i class="fa fa-toggle-up"></i>
<i class="fa fa-trash-o"></i>
<i class="fa fa-trophy"></i>
<i class="fa fa-truck"></i>
<i class="fa fa-umbrella"></i>
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
<i class="fa fa-wrench"></i>
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
<i class="fa fa-bitcoin"></i>
<i class="fa fa-btc"></i>
<i class="fa fa-cny"></i>
<i class="fa fa-dollar"></i>
<i class="fa fa-eur"></i>
<i class="fa fa-euro"></i>
<i class="fa fa-gbp"></i>
<i class="fa fa-inr"></i>
<i class="fa fa-jpy"></i>
<i class="fa fa-krw"></i>
<i class="fa fa-money"></i>
<i class="fa fa-rmb"></i>
<i class="fa fa-rouble"></i>
<i class="fa fa-rub"></i>
<i class="fa fa-ruble"></i>
<i class="fa fa-rupee"></i>
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
<i class="fa fa-indent"></i>
<i class="fa fa-italic"></i>
<i class="fa fa-link"></i>
<i class="fa fa-list"></i>
<i class="fa fa-list-alt"></i>
<i class="fa fa-list-ol"></i>
<i class="fa fa-list-ul"></i>
<i class="fa fa-outdent"></i>
<i class="fa fa-paperclip"></i>
<i class="fa fa-paste"></i>
<i class="fa fa-repeat"></i>
<i class="fa fa-rotate-left"></i>
<i class="fa fa-rotate-right"></i>
<i class="fa fa-save"></i>
<i class="fa fa-scissors"></i>
<i class="fa fa-strikethrough"></i>
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
<i class="fa fa-apple"></i>
<i class="fa fa-bitbucket"></i>
<i class="fa fa-bitbucket-square"></i>
<i class="fa fa-bitcoin"></i>
<i class="fa fa-btc"></i>
<i class="fa fa-css3"></i>
<i class="fa fa-dribbble"></i>
<i class="fa fa-dropbox"></i>
<i class="fa fa-facebook"></i>
<i class="fa fa-facebook-square"></i>
<i class="fa fa-flickr"></i>
<i class="fa fa-foursquare"></i>
<i class="fa fa-github"></i>
<i class="fa fa-github-alt"></i>
<i class="fa fa-github-square"></i>
<i class="fa fa-gittip"></i>
<i class="fa fa-google-plus"></i>
<i class="fa fa-google-plus-square"></i>
<i class="fa fa-html5"></i>
<i class="fa fa-instagram"></i>
<i class="fa fa-linkedin"></i>
<i class="fa fa-linkedin-square"></i>
<i class="fa fa-linux"></i>
<i class="fa fa-maxcdn"></i>
<i class="fa fa-pagelines"></i>
<i class="fa fa-pinterest"></i>
<i class="fa fa-pinterest-square"></i>
<i class="fa fa-renren"></i>
<i class="fa fa-skype"></i>
<i class="fa fa-stack-exchange"></i>
<i class="fa fa-stack-overflow"></i>
<i class="fa fa-trello"></i>
<i class="fa fa-tumblr"></i>
<i class="fa fa-tumblr-square"></i>
<i class="fa fa-twitter"></i>
<i class="fa fa-twitter-square"></i>
<i class="fa fa-vimeo-square"></i>
<i class="fa fa-vk"></i>
<i class="fa fa-weibo"></i>
<i class="fa fa-windows"></i>
<i class="fa fa-xing"></i>
<i class="fa fa-xing-square"></i>
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

class NEXFormsExpress_widget extends WP_Widget{
	public $name = 'NEX-Forms Express';
	public $widget_desc = 'Add NEX-Forms Express to your sidebars.';
	
	public $control_options = array('title' => '','form_id' => '',);
	function __construct(){
		$widget_options = array('classname' => __CLASS__,'description' => $this->widget_desc);
		parent::__construct( __CLASS__, $this->name,$widget_options , $this->control_options);
	}
	function widget($args, $instance){
		NEXFormsExpress_ui_output($instance['form_id'],true);
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
		$current_form = NEXFormsExpress_widget_controls::parse('[+form_id.value+]', $placeholders);
		
		$tpl  = '<input id="[+title.id+]" name="[+title.name+]" value="'.IZC_Database::get_title(NEXFormsExpress_widget_controls::parse('[+form_id.value+]', $placeholders),'wap_x_forms').'" class="widefat" style="width:96%;display:none;" />';
		
		if($get_forms)
			{
			$tpl .= '<label for="[+form_id.id+]">Select Form:</label><br />';
			$tpl .= '<select id="[+form_id.id+]" name="[+form_id.name+] " style="width:100%;">';
				$tpl .= '<option value="0">-- Select form --</option>';
				foreach($get_forms as $form)
					$tpl .= '<option value="'.$form->Id.'" '.(($form->Id==$current_form) ? 'selected="selected"' : '' ).'>'.$form->title.'</option>';
			$tpl .= '</select>';
			}
		else
			$tpl .=  '<p>No forms have been created yet.<br /><br /><a href="'.get_option('siteurl').'/wp-admin/admin.php?page=WA-x_forms-main">Click here</a> or click on "X Forms" on the left-hand menu where you will be able to create a form that would be avialable here to select as a widget.</p>';
		print NEXFormsExpress_widget_controls::parse($tpl, $placeholders);
	}
	static function register_this_widget(){
		register_widget(__CLASS__);
	}
}
   
class NEXFormsExpress_widget_controls {
	static function parse($tpl, $hash){
   	   foreach ($hash as $key => $value)
			$tpl = str_replace('[+'.$key.'+]', $value, $tpl);
	   return $tpl;
	}
}


?>