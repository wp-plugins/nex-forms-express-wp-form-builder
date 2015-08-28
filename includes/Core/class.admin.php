<?php
if(!class_exists('Module_Admin'))
	{
	class Module_Admin{
		
		public  $config,
				$data_fields,
				$db,
				$template,
				$filter,
				$modules,
				$edit;
		
		public function __construct($config){
			$this->config 			= $config;
			$this->db 				= new IZC_Database();
			$this->template 		= new IZC_Template();
			$this->modules 			= new IZC_Modules();
			$this->edit 			= (isset($_REQUEST['Id'])) ? true : false;
			
			$this->add_new();
		}
		
		public function add_new(){
	
		
			$this->db->module_table = $this->config->module_alias;
			$this->db->get_module_table();
			
			$this->template->table = $this->config->module_table;
			$this->template->plugin_alias = $this->config->get_plugin_alias();
			$this->template->component_table = $this->config->module_table;
	
			$this->template->form_fields = 
				array
					(
					'Title'=> 
						array
							(
							'type'	=>'text',
							'name'	=>'title',
							),
					'Description'=> 
						array
							(
							'type'	=>'textarea',
							'name'	=>'description',
							),
					
					'Parent'=> $this->template->build_dropdown()	
					);
			
			//Overwite above default fields
			if($this->config->default_fields)
				$this->template->form_fields = $this->config->default_fields;
			
			//Add linked modules to end of array		
			$this->modules->get_linked_modules($this->db->module_table,$this->config->get_plugin_alias(),$this->template);
	
			$this->data_fields = $this->template->form_fields;
			return $this->template->build_form();
		}
		
		
		public function list_data(){
			
			global $wpdb;
	
			
			$this->template->table = $this->config->module_table;
			
			$i = 0;
			foreach($this->data_fields as $header=>$val)	
				{ 
				if($header!='Parent')
					{
					$get_is_foreing_key = $wpdb->prepare('SHOW FIELDS FROM '.$wpdb->prefix . $this->template->table. ' LIKE "'.IZC_Functions::format_name($header).'_Id"');
					$is_foreing_key = $wpdb->query($get_is_foreing_key);
					$headers[$i] = ($is_foreing_key) ? IZC_Functions::format_name($header).'_Id': $header;
					$i++;
					}
				}
			
			$this->template->data_fields = $headers;
			
			//$output  .= $this->template->build_data_list();
			
			/*
			 * populate_list(args,table,page,plugin_alias,additional_params)
			 * args = json encoded array of headers
			 * table = tables to be selected
			 * page = used on edit to send get array
			 * plugin_alias = used to retrieve records related to this module
			 * additional params = used by filters mainly to munipulate WHERE clause
			 */
			//$output .= IZC_Functions::add_js_function('populate_list(\''.json_encode($headers).'\',\''.$this->config->module_table.'\',\''.$_GET['page'].'\',\''.$this->config->plugin_alias.'\')');
			
			return $output;
		}
		
		
	}
}

if(!class_exists('Plugin_Admin'))
	{
	class Plugin_Admin{
		
		public 	$config,
				$db,
				$template,
				$filter,
				$modules,
				$filters ,
				$get_session,
				$edit;
		
		public function __construct($config){
			
			$this->config 			= $config;
			$this->db 				= new IZC_Database();
			$this->template 		= new IZC_Template();
			//$this->filter 			= new IZC_Filter();
			//$this->modules 			= new IZC_Modules();
			$this->filters 			= get_option('iz-filters',array());
			$this->get_session 		= SESSION_ID;
			$this->edit 			= (isset($_REQUEST['Id'])) ? true : false;
		}
		
		public function add_new()
			{
			global $wpdb;
			$output .= '<div id="ajax-response" class="iz-ajax-response"></div>';
			$output .= 	'<div id="col-left">';
				$output .= '<div class="col-wrap">';
					$output .= '<div class="form-wrap">';
					$output .= '<h3>'.(($this->edit) ? 'Edit '.IZC_Database::get_title($_REQUEST['Id'], $this->config->plugin_table) : 'Add item').'</h3>';
						
						/* link dynamic forms to categories */
						$output .= '<form id="addtag" class="validate" action="" method="post" name="addItem" enctype="multipart/form-data">';
						$output .= '<input type="hidden" name="action" value="'.((isset($_REQUEST['Id'])) ? 'do_edit' : 'do_insert' ).'">';
						$output .= '<input type="hidden" name="edit_Id" value="'.$_REQUEST['Id'].'">';
						$output .= '<input type="hidden" name="edit_status" value="">';
						
						
						$output .= '<input type="hidden" name="session_Id" value="'.$this->get_session.'">';
						
						$output .= '<input type="hidden" name="page" value="'.$_REQUEST['page'].'">';
						$output .= '<input type="hidden" name="table" value="'.$this->config->plugin_table.'">';
	
						$output .= '<input type="hidden" name="orderby" value="'.$_REQUEST['orderby'].'">';
						$output .= '<input type="hidden" name="order" value="'.$_REQUEST['order'].'">';
						$output .= '<input type="hidden" name="current_page" value="'.$_REQUEST['current_page'].'">';
	
						//Hidden fields used by EDIT
						//$output .= $this->filter->add_hidden_fields($this->filters[$this->config->plugin_alias],$this->config->plugin_table);
						
						//$output .= '<div class="iz-forms-holder">';
							$output .= '<div class="iz-ajax-response" id="ajax-response"></div>';
							$output .= '<div class="module-fields">';
								//populated by link-purpose response
							$output .= '</div>';
							//$output .= '<div class="form-fields">';
								//Module filters installed
								//$output .= $this->filter->add_filters_to_form($this->filters[$this->config->plugin_alias],$this->template,$this->config->plugin_alias);
										
								//Default Fields		
								foreach($this->config->default_fields as $form_elements)
									{
									//$output .= '<fieldset class="'.$form_elements['type'].' '.IZC_Functions::format_name($form_elements['grouplabel']).'">';
										$output .= '<div class="form-field '.$form_elements['type'].'">';
												$output .= '<label>'.IZC_Functions::unformat_name($form_elements['grouplabel']).'</label>';
											
												$output .= $this->template->build_field($form_elements);
											$output .= '</div>';
									//$output .= '</fieldset>';
									}
							//$output .= '</div>';
						$output .= '</div>';
						
						$output .= '<div class="submit">';
						$output .=	'<p class="submit"><input type="submit" value="        '.(($edit) ? 'Save' : 'Add item').'        " class="iz-submit button-primary iz-plugin-submit" data-action="'.((isset($_REQUEST['Id'])) ? 'iz-update' : 'iz-insert').'" id="submit" name="submit">';
							$output .= ($edit) ? '&nbsp;&nbsp;&nbsp;<input type="button" class="cancel" value="   Cancel   " onclick="window.location.href = \''.get_option('siteurl').'/wp-admin/admin.php?page='.$_GET['page'].'\';">' : '';
							$output .= '</p>';
						$i=0;
						foreach($this->config->default_fields as $key=>$val)	
							{
							$table_fields[$i] = $key;
							$i++;
							}
						
						$filters = array_reverse(get_option('iz-filters',array()));
						
						if(!is_array($filters[IZC_Functions::format_name($this->config->plugin_name)]))
							$filters[IZC_Functions::format_name($this->config->plugin_name)] = array();
						
						$j = $i;
						foreach($filters[IZC_Functions::format_name($this->config->plugin_name)] as $filter=>$val){
						
							if($val['admin_display'])
								{
								if($val['type']=='dropdown')
									$table_fields[$j] = $filter.'_Id';
	
								else
									$table_fields[$j] = $filter;
								$j++;	
								}
						}
						
						$output .= '<input type="hidden" name="fields" value=\''.json_encode($table_fields).'\'>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
			
			return $output;
			}
		
		public function list_data(){
			
			global $wpdb;
			$i = 1;
			foreach($this->config->default_fields as $header=>$val)	
				{ 
				$headers[$i] = IZC_Functions::format_name($header);
				$i++;
				}
			
			$filters = array_reverse(get_option('iz-filters',array()));
			
			if(!is_array($filters[IZC_Functions::format_name($this->config->plugin_name)]))
				$filters[IZC_Functions::format_name($this->config->plugin_name)] = array();
			
			$j = $i;
			foreach($filters[IZC_Functions::format_name($this->config->plugin_name)] as $filter=>$val)
				{
				if($val['admin_display'])
					{
					if($val['type']=='dropdown')
						$headers[$j] = $filter.'_Id';
					else
						$headers[$j] = $filter;
					$j++;	
					}
				}
			
			$this->template->component_table = $this->config->component_table;
			
			$this->template->data_fields = $headers;
			$output  = $this->template->build_data_list();
			
			
			//$output .= IZC_Functions::add_js_function('populate_list(\''.json_encode($headers).'\',\''.$this->config->plugin_table.'\',\''.$_GET['page'].'\')');
			
			return $output;
		}
		
		public function get_all_records(){
		}
		public function get_public_records(){
		}
		public function get_private_records(){
		}
		public function count_all_records(){
		}
		public function count_public_records(){
		}
		public function count_private_records(){
		}
	}
}
?>