<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_function_correlation_get($params, &$smarty)
{

	$selist = "";
	$selected_data = array();
	$sql = "select M.".$params['tbl_1_pk'].",M.".$params['tbl_1_name']." from ".$params['correlation_table']." as G left join ".$params['tbl_1_table']." as M on M.".$params['tbl_1_pk']."=G.".$params['tbl_1_fk']." where G.".$params['tbl_2_fk']."=".$_GET['GroupID'];
	$sth = mysql_query($sql);
	while ($data = mysql_fetch_assoc($sth)) {
		$selected_data[] = $data;
		$selist .= ",".$data[$params['tbl_1_pk']];
	}
	$smarty->assign($params['selected'],$selected_data);
	$selist = preg_replace("/^,/","",$selist);

	$all_data = array();
	$sth = mysql_query("select M.".$params['tbl_1_pk'].",M.".$params['tbl_1_name']." from ".$params['tbl_1_table']." as M where M.".$params['tbl_1_pk']." not in ($selist) order by M.".$params['tbl_1_name']);
	print mysql_error();
	while ($data = mysql_fetch_assoc($sth)) {
		$all_data[] = $data;
	}
	$smarty->assign($params['all'],$all_data);


}

/* vim: set expandtab: */

?>