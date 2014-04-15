<?php

class NEXFormsExpress_form_entries{
	
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
		
		if(!get_option('wnex-forms-express-wp-form-builder-default-settings'))
			add_option('wnex-forms-express-wp-form-builder-default-settings',array());
		
		update_option('wnex-forms-express-wp-form-builder-default-settings',$_POST);
		
		IZC_Functions::print_message( 'updated' , 'Settings Updated' );
		die();
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
		
		
		
		$output .= NEXFormsExpress_form_entries::biuld_form_data_table();
		
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
					$output .= '<a class="btn btn-disabled"><span class="fa fa-rocket"></span>&nbsp;&nbsp;Export Form Entries (csv)</a> <span data-original-title="This feature is locked! Click on \'Upgade to Pro\' top right to activate." class="bs-tooltip fa fa-lock text-danger" data-placement="bottom" data-toggle="tooltip" title="">&nbsp;</span><br />
';
					$output	.= '<div class="tablenav-pages">';
					
					$total_records = NEXFormsExpress_form_entries::get_total_form_entries($form_id);
		
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

		
		$total_records = NEXFormsExpress_form_entries::get_total_form_entries($_POST['wa_form_Id']);
		
		$total_pages = ((is_float($total_records/10)) ? (floor($total_records/10))+1 : $total_records/10);
		
		$output .= '<span class="displaying-num"><strong>'.NEXFormsExpress_form_entries::get_total_form_entries($_POST['wa_form_Id']).'</strong> entries</span>';
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