<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_function_onetomany($params, &$smarty) {
	$api = new msdr_api($smarty);

	$selected_data = array();
	$sql = "select C.".$params['child_pk'].",C.".$params['child_name']." from ".$params['child_table']." as C where C.Audited='Audited' and C.".$params['parent_fk']."=".$params['current'];
	$sth = $api->db->query($sql);
	while ($data = $sth->fetchRow()) {
		$selected_data[] = $data;
		$selist .= ",".$data[$params['child_pk']];
	}
	$smarty->assign($params['selected'],$selected_data);
	$selist = preg_replace("/^,/","",$selist);

	if ($selist == "") $selist = 0;

	$all_data = array();
	$sql = "select C.".$params['child_pk'].",C.".$params['child_name']." from ".$params['child_table']." as C where C.Audited='Audited' and C.".$params['child_pk']." not in (".$selist.") order by C.".$params['child_name']."";
	$sth = $api->db->query($sql);
	while ($data = $sth->fetchRow()) {
		$all_data[] = $data;
	}
	$smarty->assign($params['all'],$all_data);
}
/* vim: set expandtab: */

?>