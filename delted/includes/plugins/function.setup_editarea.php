<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
require_once("classes/api/msdr_api.php");

function smarty_function_setup_editarea($params, &$smarty) {
	$api = new msdr_api($smarty);
	$sections = explode(";",$_GET['setup']);
	$disp_blocks = array();
	$cols = 8;
	foreach ($sections as $value) {
		list ($label,$db_column,$spaces,$edtype,$edmod) = explode(",",$value);
		if ($cols - ($spaces+1) < 0) {
			$cols = 8;
			$disp_blocks[] = "new";
		}
		$cols = $cols - $spaces+1;
		$disp_blocks[] = array("label"=>$label, "db_column"=>$db_column, "spaces" => $spaces, "edtype" => $edtype, "edmod" => $edmod);
	}
	$smarty->assign($params['return'],$disp_blocks);
}

?>