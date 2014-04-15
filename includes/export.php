<?php
function format_name($str){
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
$filename = 'nexforms-'.format_name($_POST['_title']).'-entries--'.date('d-m-Y',mktime()).'.csv';
header('Content-Type: application/csv'); 
header("Content-length: " . strlen($content)); 
header('Content-Disposition: attachment; filename="' . $filename . '"'); 
echo $content;
exit();
?>