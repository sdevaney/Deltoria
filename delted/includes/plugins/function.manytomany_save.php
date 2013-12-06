<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_function_manytomany_save($params, &$smarty) {
	$selected = explode(",",$params['selected']);

	$sql = "delete from ".$params['cor_table']." where ".$params['parent_fk']."=".$params['current'];
	SQL_QUERY($sql);

	foreach ($selected as $data) {
		$sql = "insert into ".$params['cor_table']." (".$params['parent_fk'].",".$params['child_fk'].") values ('".$params['current']."','".$data."')";
		print $sql."<br>";
		SQL_QUERY($sql);
	}
}
/* vim: set expandtab: */

?>