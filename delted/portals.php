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

	$section_data = array();
	$section_data[] = array("label" => "Name", "db_column" => "Name", "edtype" => "TEXT", "size" => "25");
	$section_data[] = array("label" => "Zone", "db_column" => "TargetMapID", "edtype" => "DROPDOWN_SQL", "query" => "select MapID,Name from mapid_background order by Name", "key_column" => "MapID", "value_column" => "Name", "size" => "25", "blank_option" => "1");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "X", "db_column" => "TargetX", "edtype" => "TEXT", "size" => "25");
	$section_data[] = array("label" => "Y", "db_column" => "TargetY", "edtype" => "TEXT", "size" => "25");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Level", "db_column" => "Level", "edtype" => "TEXT");
	$section_data[] = array("label" => "Subscriber", "db_column" => "Subscriber", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Comments", "db_column" => "Comments", "edtype" => "TEXTAREA", "size" => "50");
	$smarty->assign("section_data",$section_data);

	if ($_POST['save'] == "y") editor_save($section_data,"portals","PortalID",$_GET['PortalID']);

	$portals = array();
	$sth = mysql_query("select p.*,z.Name as zone_name from portals as p left join mapid_background as z on z.MapID=p.TargetMapID order by p.Name");
	while ($data = mysql_fetch_assoc($sth)) {
    	$portals[] = $data;
	}
	$smarty->assign("portals_list",$portals);

	$smarty->display("portals.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>