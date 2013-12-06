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
	$section_data[] = array("label" => "Max Armor", "db_column" => "MaxArmor", "edtype" => "TEXT", "size" => "5");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Description", "colspan" => "3", "db_column" => "Description", "rows" => "5", "edtype" => "TEXTAREA");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Mod_Code", "colspan" => "3", "db_column" => "ModCode", "rows" => "5", "edtype" => "TEXTAREA");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Cost", "db_column" => "Cost", "edtype" => "TEXT");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Base Maint", "db_column" => "BaseMaint", "edtype" => "TEXT");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Maint Per Flag", "db_column" => "MaintPerFlag", "edtype" => "TEXT");
	$section_data[] = "NEW";

	$smarty->assign("section_data",$section_data);
	if ($_POST['save'] == "y") {
		$id = editor_save($section_data,"buildings","BID",$_GET['BID']);
	}

	$building = array();
	$sth = mysql_query("select b.*,t.Image from buildings as b left join tiledata as t on t.TileID=b.TileID order by b.Name");
	while ($data = mysql_fetch_assoc($sth)) {
   		$building[] = $data;
	}
	$smarty->assign("buildings_list",$building);

	if ($_GET['BID'] > 0) {
		$sth = mysql_query("select t.Image from buildings as b left join tiledata as t on t.TileID=b.TileID where b.BID=".$_GET['BID']);
		list($tile_image) = mysql_fetch_row($sth);
		$smarty->assign("tile_image",$tile_image);
	}

	$smarty->display("buildings.tpl");
//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>