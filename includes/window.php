<?php
wp_enqueue_script('jquery');
wp_register_script('wa-tinymce-functions', plugins_url('/tinyMCE/functions.js',dirname(__FILE__)));
wp_enqueue_script('wa-tinymce-functions');
wp_register_script('wa-tinymce-tiny_mce_popup', get_option('siteurl').'/wp-includes/js/tinymce/tiny_mce_popup.js');
wp_enqueue_script('wa-tinymce-tiny_mce_popup');
wp_register_script('wa-tinymce-mctabs', get_option('siteurl').'/wp-includes/js/tinymce/utils/mctabs.js');
wp_enqueue_script('wa-tinymce-mctabs');
wp_register_script('wa-tinymce-form_utils', get_option('siteurl').'/wp-includes/js/tinymce/utils/form_utils.js');
wp_enqueue_script('wa-tinymce-form_utils');
wp_print_scripts();

function build_dropdown($table=''){
		$output .= '<div class="form-field">';
			$output .= '<select id="'.(($table) ? $table.'_Id' : 'parent_Id' ).'" name="wap_nex_forms_Id">';
			$output .= '<option value="0">---- Select ----</option>';
			$output .= populate_dropdown_list($table);
			$output .= '</select>';
		$output .= '</div>';
		return $output;
	}
function populate_dropdown_list($table){
		
		global $wpdb;
		
		$sql	= $wpdb->prepare('SELECT * FROM '. $wpdb->prefix . filter_var($table,FILTER_SANITIZE_STRING));
		$results	= $wpdb->get_results($sql);

		if($results)
			{			
			foreach($results as $data)
				$output .= '<option value="'.$data->Id.'" '.(($selected==$data->Id) ? 'selected="selected"' : '' ).'>'.$data->title.'</option>';
			}
		return $output;
	}
$output .= '<body onLoad="tinyMCEPopup.executeOnLoad(\'init();\');">';
		$output .= '<div class="wrap">';
			$output .= '<h2>NEX-Forms</h2>';
			$output .= '<form name="add_form_to_post" action="">';
				$output .= '<table cellpadding="5" cellspacing="1" width="100%" bgcolor="#CCC" style="font-size:11px;">';
					$output .= '<tr>';
						$output .= '<td bgcolor="#F2F2F2" width="30%">';
							$output .= '<label>Select Form to insert:</label>';
						$output .= '</td>';

						$output .= '<td bgcolor="#F2F2F2" width="30%">';
							$output .= build_dropdown('wap_nex_forms').'';
						$output .= '</td>';
						
					$output .= '</tr>';
					$output .= '<tr>';
						
						$output .= '<td bgcolor="#F2F2F2" width="30%">';
							$output .= '<label>Display</label>';
						$output .= '</td>';
						$output .= '<td bgcolor="#F2F2F2" width="30%">';
							$output .= '<input type="radio" name="open_trigger" value="normal">&nbsp;Normal<input type="radio" name="open_trigger" value="popup">&nbsp;Modal Popup';
						$output .= '</td>';
						
					$output .= '</tr>';
					$output .= '<tr>';
						$output .= '<td bgcolor="#F2F2F2" width="30%">';
							$output .= '<label>Popover Trigger</label>';
						$output .= '</td>';
						$output .= '<td bgcolor="#F2F2F2" width="30%">';
							$output .= '<input type="radio" name="type" value="button">&nbsp;Button<input type="radio" name="type" value="link">&nbsp;Link';
						$output .= '</td>';
						
					$output .= '</tr>';
					$output .= '<tr>';
						$output .= '<td bgcolor="#F2F2F2" width="30%">';
							$output .= '<label>Button/link Text</label>';
						$output .= '</td>';
						$output .= '<td bgcolor="#F2F2F2" width="30%">';
							$output .= '<input type="text" name="text" value="">';
						$output .= '</td>';
						
					$output .= '</tr>';								
				$output .= '</table>';
				$output .= '<br><input type="button" name="Insert form" value="   Insert into post   " onClick="insert_a_form();">';		
			$output .= '</form>';
	$output .= '</div>';
$output .= '</body>';
echo $output;
?>