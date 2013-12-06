<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_modifier_session($session,$value = "") {
	global $smarty;

	if ($value != "") {
		$_SESSION[$session] = $value;
	}

	$smarty->assign("_SESSION",$_SESSION);

	if ($value == "") return $_SESSION[$session];
}
?>