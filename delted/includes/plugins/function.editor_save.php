<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_function_editor_save($params, &$smarty)
{
	$columns = array();

	if ($params['value'] == "new" || $params['value'] == "0") {
		foreach ($params['sections'] as $data) {
			if ($data == "NEW" || $data['NEW'] != "") continue(0);
			if ($data['edtype'] == "CHECKBOX" && $_POST[$data['db_column']] == "" ){
				$_POST[$data['db_column']] = "N";
			}
			$keys .= ",".$data['db_column'];
			$values .= ",'".$_POST[$data['db_column']]."'";
		}
		$keys = preg_replace("/^,/","",$keys);
		$values = preg_replace("/^,/","",$values);

		reset($columns);

		$sql = "insert into ".$params['table']." (".$keys.") values (".$values.")";
		SQL_QUERY($sql);
		print mysql_error();
		
	} else {
		foreach ($params['sections'] as $data) {
			if ($data == "NEW" || $data['NEW'] != "") continue(0);
			if ($data['edtype'] == "CHECKBOX" && $_POST[$data['db_column']] == "" ){
				$_POST[$data['db_column']] = "N";
			}
			$columns[] = array("key" => $data['db_column'], "value" => $_POST[$data['db_column']]);
		}
		reset($columns);

		$sql = "update ".$params['table']." set ";
		foreach ($columns as $data) {
			$sql .= $data['key']."='".$data['value']."', ";
		}
		$sql = preg_replace("/, $/"," ",$sql);
		$sql .= "where ".$params['column']."='".$params['value']."'";
		SQL_QUERY($sql);
	}
}

/* vim: set expandtab: */

?>