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

	$zones = array();
	$sth = SQL_QUERY("select * from mapid_background order by Name");
	while ($data = SQL_ASSOC_ARRAY($sth)) {
		$zones[] = $data;
	}
	$smarty->assign("zones",$zones);


	$portals = array();
	$sth = SQL_QUERY("select PortalID,Name from portals order by Name");
	while ($data = SQL_ASSOC_ARRAY($sth)) {
		$portals[] = $data;
	}
	$smarty->assign("portals",$portals);

	$spawns = array();
	$sth = SQL_QUERY("select GroupID,Name,Hostile from monster_groupdata order by Name");
	while ($data = SQL_ASSOC_ARRAY($sth)) {
		$spawns[] = $data;
	}
	$smarty->assign("spawns",$spawns);

/*        $spawns = array();
        $sth = SQL_QUERY("select GroupID,Name,Hostile from monster_groupdata where Hostile='N' order by Name");
        while ($data = SQL_ASSOC_ARRAY($sth)) {
                $spawns[] = $data;
        }
        $smarty->assign("spawns",$spawns);*/

	$smarty->display("map.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>