<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_function_addsection($params, &$smarty) {
	$section_data = $smarty->get_template_vars("section_data");
	if ($section_data == "") $section_data = array();

	if ($params['NEW'] != "" && $params['title'] == "") {
		$section_data[] = "NEW";
	} else {
		if ($params['options_array']) {
			$options_array = array();
			$optsplit = explode(";",$params['options_array']);
		}
		$section_data[] = $params;
	}

	$smarty->assign("section_data",$section_data);
}
/* vim: set expandtab: */

?>