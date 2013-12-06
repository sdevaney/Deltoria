<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/

session_start();
global $userdata,$config;

require_once("../includes/config.php");
require_once("../includes/common.php");
require_once("../includes/db_connect.php");
require_once("../includes/smarty.php");
require_once("../includes/user.php");

$section_data = array();
$section_data[] = array("label" => "Tile", "db_column" => "tile_id", "edtype" => "HIDDEN");
$section_data[] = array("label" => "Name", "db_column" => "player_name", "edtype" => "TEXT", "size" => "25");
$section_data[] = array("label" => "Race", "db_column" => "race_id", "edtype" => "DROPDOWN_SQL", "query" => "select race_id,race_name from races order by race_name", "key_column" => "race_id", "value_column" => "race_name", "size" => "25", "blank_option" => "0");
$section_data[] = "NEW";
$section_data[] = array("label" => "Class", "db_column" => "class_id", "edtype" => "DROPDOWN_SQL", "query" => "select class_id,class_name from classes order by class_name", "key_column" => "class_id", "value_column" => "class_name", "size" => "25", "blank_option" => "0");
$section_data[] = array("label" => "X", "db_column" => "x", "edtype" => "TEXT", "size" => "25");
$section_data[] = "NEW";
$section_data[] = array("label" => "Y", "db_column" => "y", "edtype" => "TEXT", "size" => "25");
$section_data[] = array("label" => "Zone", "db_column" => "zone_id", "edtype" => "DROPDOWN_SQL", "query" => "select zone_id,zone_name from zones order by zone_name", "key_column" => "zone_id", "value_column" => "zone_name", "size" => "25", "blank_option" => "0");
$section_data[] = "NEW";
$section_data[] = array("label" => "XP", "db_column" => "xp", "edtype" => "TEXT");
$smarty->assign("section_data",$section_data);
if ($_POST['save'] == "y") editor_save($section_data,"users","player_id",$_GET['player_id']);

$players = array();
$sth = mysql_query("select u.*,t.image from users as u left join tiles as t on t.tile_id=u.tile_id order by u.player_name");
while ($data = mysql_fetch_assoc($sth)) {
    $players[] = $data;
}
$smarty->assign("players_list",$players);

if ($_GET['player_id'] > 0) {
	$sth = mysql_query("select t.image from users as u left join tiles as t on t.tile_id=u.tile_id where u.player_id=".$_GET['player_id']);
	list($tile_image) = mysql_fetch_row($sth);
	$smarty->assign("tile_image",$tile_image);
}

$smarty->display("players.tpl");

?>