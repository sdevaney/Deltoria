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
	$section_data[] = array("label" => "Tile", "db_column" => "TileID", "edtype" => "HIDDEN");
	$section_data[] = array("label" => "Name", "db_column" => "Name", "edtype" => "TEXT", "size" => "25");
	$section_data[] = "NEW";


	$smarty->assign("section_data",$section_data);
	if ($_POST['save'] == "y") editor_save($section_data,"mapid_background","MapID",$_GET['MapID']);

	$maps = array();
	$sth = mysql_query("select m.*,t.Image from mapid_background as m left join tiledata as t on t.TileID=m.TileID order by m.Name");
	while ($data = mysql_fetch_assoc($sth)) {
    	$maps[] = $data;
	}
	$smarty->assign("maps_list",$maps);

	if ($_GET['MapID'] > 0) {
		$sth = mysql_query("select t.Image from mapid_background as m left join tiledata as t on t.TileID=m.TileID where m.MapID=".$_GET['MapID']);
		list($tile_image) = mysql_fetch_row($sth);
		$smarty->assign("tile_image",$tile_image);
	}

	$smarty->display("zones.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>