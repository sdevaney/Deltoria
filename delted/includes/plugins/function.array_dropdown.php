<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_function_array_dropdown($params, &$smarty) {
	$options = explode("|",$params['Array']);
	while (list($k,$v) = each($options)) {
		print "<OPTION NAME=\"$v\"";
		if ($params['Selected'] == $v) print " SELECTED";
		print ">$v</OPTION>\n";
	}

}
?>