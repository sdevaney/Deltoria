<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_function_sql_dropdown($params, &$smarty) {
	$sth = SQL_QUERY($params['sql']);
	while ($data = SQL_ASSOC_ARRAY($sth)) {
		print "<OPTION VALUE='".$data[$params['key_column']]."'";
		if ($data[$params['key_column']] == $params['selected']) print " SELECTED";
		print ">";
		print $data[$params['value_column']];
		print "</OPTION>";
	}
}
?>