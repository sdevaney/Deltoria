<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_function_manytomany($params, &$smarty) {
	$selected_data = array();
	$sql = "select C.".$params['child_pk'].",C.".$params['child_name']." from ".$params['cor_table']." as COR left join ".$params['child_table']." as C on C.".$params['child_pk']."=COR.".$params['child_fk']." where COR.".$params['parent_fk']."=".$params['current']." order by C.".$params['child_name'];
	$sth = mysql_query($sql);
	print mysql_error();
	while ($data = mysql_fetch_assoc($sth)) {
		$selected_data[] = $data;
		$selist .= ",".$data[$params['child_pk']];
	}
	$smarty->assign($params['selected'],$selected_data);
	$selist = preg_replace("/^(,+)/","",$selist);

	if ($selist == "") $selist = 0;

	$all_data = array();
	$sql = "select C.".$params['child_pk'].",C.".$params['child_name']." from ".$params['child_table']." as C where C.".$params['child_fk']." not in (".$selist.") order by C.".$params['child_name']."";
	$sth = mysql_query($sql);
	while ($data = mysql_fetch_assoc($sth)) {
		$all_data[] = $data;
	}
	$smarty->assign($params['all'],$all_data);
}
/* vim: set expandtab: */

?>