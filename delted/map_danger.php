<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/

session_start();
global $userdata,$config;

require_once("./includes/config.php");
require_once("./includes/common.php");
require_once("./includes/db_connect.php");
require_once("./includes/smarty.php");
require_once("./includes/user.php");

//if($session->isAdmin()){

	$danger_data = array();
	$sthd = SQL_QUERY("select * from map order by danger");
	while ($data = SQL_ASSOC_ARRAY($sthd)) {
		$danger_data[] = $data;
	}
	$smarty->assign("danger_data",$danger_data);
	$smarty->display("map_danger.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>