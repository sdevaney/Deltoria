<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_function_editor_get($params, &$smarty)
{
	$sql = "select *";
	if ($params['sql'] != "") $sql .= ",".$params['sql'];
	$sql .= " from ".$params['table']." where ".$params['column']."='".$params['value']."'";
	$sth = mysql_query($sql);
	$data = mysql_fetch_assoc($sth);
	$smarty->assign($params['return'],$data);
}

/* vim: set expandtab: */

?>