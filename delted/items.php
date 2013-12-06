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
	$section_data[] = array("label" => "Type", "db_column" => "ItemType", "edtype" => "DROPDOWN", "options" => "Armor;Weapon;Usable;Misc;Jewlery;Tool");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Skill", "db_column" => "SkillID", "edtype" => "DROPDOWN_SQL", "query" => "select SkillID,Name from skills order by Name", "key_column" => "SkillID", "value_column" => "Name", "blank_option" => "1");
	$section_data[] = array("label" => "Max AL", "db_column" => "MaxAL", "edtype" => "TEXT", "size" => "3");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Description", "colspan" => "3", "db_column" => "Description", "rows" => "5", "edtype" => "TEXTAREA");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Use Effect", "colspan" => "3", "db_column" => "Use_Effect", "rows" => "5", "edtype" => "TEXTAREA");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Defined", "db_column" => "Defined", "edtype" => "CHECKBOX");
	$section_data[] = array("label" => "AL", "db_column" => "Defined_AL", "edtype" => "TEXT");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Damage Mod", "db_column" => "Defined_DamageMod", "edtype" => "TEXT");
	$section_data[] = array("label" => "Attack Bonus", "db_column" => "Defined_AttackBonus", "edtype" => "TEXT");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Melee Bonus", "db_column" => "Defined_MeleeBonus", "edtype" => "TEXT");
	$section_data[] = "NEW";
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Value", "db_column" => "Defined_Value", "edtype" => "TEXT");
	$section_data[] = array("label" => "Salvage Value", "db_column" => "Salvage_Price", "edtype" => "TEXT");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Min Dam", "db_column" => "Defined_MinDam", "edtype" => "TEXT");
	$section_data[] = array("label" => "Max Dam", "db_column" => "Defined_MaxDam", "edtype" => "TEXT");
	$section_data[] = "NEW";
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Drop Rate", "db_column" => "DropRate", "edtype" => "TEXT");
	$section_data[] = array("label" => "Droppable", "db_column" => "Droppable", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Enchantable", "db_column" => "Enchantable", "edtype" => "CHECKBOX");
	$section_data[] = array("label" => "Battle Use", "db_column" => "Battle_Use", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Level Req", "db_column" => "Defined_LevelReq", "edtype" => "TEXT");
	$section_data[] = array("label" => "Stackable", "db_column" => "Stackable", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Multi Step", "db_column" => "MultiStep", "edtype" => "CHECKBOX");
	$section_data[] = array("label" => "Subscriber", "db_column" => "Subscriber", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Admin", "db_column" => "Admin", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Wear Head", "db_column" => "Wear_Head", "edtype" => "CHECKBOX");
	$section_data[] = array("label" => "Wear Chest", "db_column" => "Wear_Torso", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Wear Arms", "db_column" => "Wear_Arms", "edtype" => "CHECKBOX");
	$section_data[] = array("label" => "Wear Legs", "db_column" => "Wear_Legs", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Wear Hands", "db_column" => "Wear_Hands", "edtype" => "CHECKBOX");
	$section_data[] = array("label" => "Wear Feet", "db_column" => "Wear_Feet", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Wear Neck", "db_column" => "Wear_Necklace", "edtype" => "CHECKBOX");
	$section_data[] = array("label" => "Wear Wrist", "db_column" => "Wear_Bracelet", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Wear Finger", "db_column" => "Wear_Ring", "edtype" => "CHECKBOX");
	$section_data[] = array("label" => "Wear Wield", "db_column" => "Wear_Wielded", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Buyable", "db_column" => "Buyable", "edtype" => "CHECKBOX");
	$section_data[] = array("label" => "Price", "db_column" => "Price", "edtype" => "TEXT");
	#$section_data[] = "NEW";
	#$section_data[] = array("label" => "Wear Armor", "db_column" => "Wear_Armor", "edtype" => "CHECKBOX");
	#$section_data[] = array("label" => "Wear Shield", "db_column" => "Wear_Shield", "edtype" => "CHECKBOX");
	#$section_data[] = "NEW";

	$smarty->assign("section_data",$section_data);
	if ($_POST['save'] == "y") {
		$id = editor_save($section_data,"items_base","ItemID",$_GET['ItemID']);
		manytomany_save($_POST['Selected_save'],"items_base_spells","ItemID","SpellID",$id,true);
		include("EnableEquip.php");
	}

	$items = array();
	$sth = mysql_query("select m.*,t.Image from items_base as m left join tiledata as t on t.TileID=m.TileID order by m.Name");
	while ($data = mysql_fetch_assoc($sth)) {
   		$items[] = $data;
	}
	$smarty->assign("items_list",$items);

	if ($_GET['ItemID'] > 0) {
		$sth = mysql_query("select t.Image from items_base as m left join tiledata as t on t.TileID=m.TileID where m.ItemID=".$_GET['ItemID']);
		list($tile_image) = mysql_fetch_row($sth);
		$smarty->assign("tile_image",$tile_image);
	}

	$smarty->display("items.tpl");
//} else {
   // echo "You are either not logged in or not an admin";
   // exit();
//}

?>