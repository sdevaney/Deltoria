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
	$section_data[] = array("label" => "Loot Group", "db_column" => "LootGroup", "edtype" => "DROPDOWN_SQL", "query" => "select GroupID,Name from lootgroup order by Name", "key_column" => "GroupID", "value_column" => "Name", "size" => "25", "blank_option" => "1");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Weapon Min", "db_column" => "WeaponMin", "edtype" => "TEXT", "size" => "25");
	$section_data[] = array("label" => "Weapon Max", "db_column" => "WeaponMax", "edtype" => "TEXT", "size" => "25");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Tell Enter Area", "colspan" => "3", "db_column" => "TELL_EnterArea", "rows" => "5", "edtype" => "TEXTAREA");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "MOD EnterArea", "colspan" => "3", "db_column" => "MOD_EnterArea", "rows" => "5", "edtype" => "TEXTAREA");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Weapon Skill", "db_column" => "WeaponSkill", "edtype" => "TEXT");
	$section_data[] = array("label" => "AL", "db_column" => "AL", "edtype" => "TEXT");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Hostile", "db_column" => "Hostile", "edtype" => "CHECKBOX");
	$section_data[] = array("label" => "Quest", "db_column" => "QuestID", "edtype" => "DROPDOWN_SQL", "query" => "select QuestID,Name from questdata order by Name", "key_column" => "QuestID", "value_column" => "Name", "blank_option" => "1");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Merchant", "db_column" => "MerchantID", "edtype" => "DROPDOWN_SQL", "query" => "select MerchantID,Name from merchant order by Name", "key_column" => "MerchantID", "value_column" => "Name", "blank_option" => "1");
	$section_data[] = array("label" => "Melee Defence", "db_column" => "MeleeD", "edtype" => "TEXT");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Base Health", "db_column" => "BaseHealth", "edtype" => "TEXT");
	$section_data[] = array("label" => "Weapon Type", "db_column" => "WeaponType", "edtype" => "TEXT");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Level", "db_column" => "Level", "edtype" => "TEXT");
	$section_data[] = array("label" => "Max Items", "db_column" => "MaxItems", "edtype" => "TEXT");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "XP", "db_column" => "XP", "edtype" => "TEXT");
	$section_data[] = array("label" => "Poisonous", "db_column" => "Poison", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Poison Turns", "db_column" => "PsnTurns", "edtype" => "TEXT");
	$section_data[] = array("label" => "Poison Damage", "db_column" => "PsnDmg", "edtype" => "TEXT");


	$smarty->assign("section_data",$section_data);
	if ($_POST['save'] == "y") editor_save($section_data,"monster_base","MonsterID",$_GET['MonsterID']);

	$monsters = array();
	$sth = mysql_query("select m.*,t.Image from monster_base as m left join tiledata as t on t.TileID=m.TileID order by m.Name");
	while ($data = mysql_fetch_assoc($sth)) {
    	$monsters[] = $data;
	}
	$smarty->assign("monsters_list",$monsters);

	if ($_GET['MonsterID'] > 0) {
		$sth = mysql_query("select t.Image from monster_base as m left join tiledata as t on t.TileID=m.TileID where m.MonsterID=".$_GET['MonsterID']);
		list($tile_image) = mysql_fetch_row($sth);
		$smarty->assign("tile_image",$tile_image);
	}

	$smarty->display("monsters.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>