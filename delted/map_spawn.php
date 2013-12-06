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

	$spawn_data = array();
	$sth = SQL_QUERY("select * from monster_groupdata order by Name");
	while ($data = SQL_ASSOC_ARRAY($sth)) {
		$spawn_data[] = $data;
	}
	$smarty->assign("spawn_data",$spawn_data);

	$smarty->display("map_spawn.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>