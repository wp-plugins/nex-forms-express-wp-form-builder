<?php
/*function format_name($str){
			$str = strtolower($str);		
			$str = str_replace('  ',' ',$str);
			$str = str_replace(' ','_',$str);
			$str = str_replace('\\','_',$str);
			$str = str_replace('/','_',$str);
			$str = str_replace('.','_',$str);
			return trim($str);
		}
error_reporting(1);
$content = $_POST['csv_content'];
$filename = 'nexforms-'.format_name($_POST['_title']).'-entries--'.date('m-d-Y',mktime()).'.csv';
header('Content-Type: application/csv'); 
header("Content-length: " . strlen($content)); 
header('Content-Disposition: attachment; filename="' . $filename . '"'); 
echo $content;
exit();*/

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
//include( $parse_uri[0] . 'wp-load.php' );
include '../../../../wp-load.php';
global $wpdb;

	$form_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wap_nex_forms_entries WHERE nex_forms_Id = '.$_REQUEST['nex_forms_Id']);
	//print_r($form_data);
	$j = 0;
	foreach($form_data as $data)
		{
		
		if($j==0)
			{
			$form_values = json_decode($data->form_data);
			$i = 1;
			foreach($form_values as $field)
				{
				$content .= $field->field_name;
				$content .= ($i<=count($form_values)-1) ? ',' : '
';
				$i++;
				}
			}
		$j++;	
		}
		
	foreach($form_data as $data)
		{
		$form_values = json_decode($data->form_data);
		$i = 1;
		foreach($form_values as $field)
			{
			$content .= $field->field_value;
			$content .= ($i<=count($form_values)-1) ? ',' : '
';
			$i++;
			}
		}
		

$filename = 'nexforms.csv';
header('Content-Type: application/csv'); 
header("Content-length: " . strlen($content)); 
header('Content-Disposition: attachment; filename="' . $filename . '"'); 
echo $content;

?>