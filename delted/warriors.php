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
	$section_data[] = array("label" => "Strength", "db_column" => "Strength", "edtype" => "TEXT", "size" => "25");
	$section_data[] = array("label" => "Armor", "db_column" => "Armor", "edtype" => "TEXT", "size" => "25");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Cost", "db_column" => "TrainCost", "edtype" => "TEXT");
	$section_data[] = "NEW";

	$smarty->assign("section_data",$section_data);
	if ($_POST['save'] == "y") editor_save($section_data,"warriors","WarriorID",$_GET['WarriorID']);

	$warrior = array();
	$sth = mysql_query("select w.*,t.Image from warriors as w left join tiledata as t on t.TileID=w.TileID order by w.Name");
	while ($data = mysql_fetch_assoc($sth)) {
    	$warrior[] = $data;
	}
	$smarty->assign("warriors_list",$warrior);

	if ($_GET['WarriorID'] > 0) {
		$sth = mysql_query("select t.Image from warriors as w left join tiledata as t on t.TileID=w.TileID where w.WarriorID=".$_GET['WarriorID']);
		list($tile_image) = mysql_fetch_row($sth);
		$smarty->assign("tile_image",$tile_image);
	}

	$smarty->display("warriors.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>