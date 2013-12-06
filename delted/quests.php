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
	$section_data[] = array("label" => "Requested Item", "db_column" => "Take_ItemID", "edtype" => "DROPDOWN_SQL", "query" => "select ItemID,Name from items_base order by Name", "key_column" => "ItemID", "value_column" => "Name", "size" => "25", "blank_option" => "0");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Reward", "db_column" => "Return_ItemID", "edtype" => "DROPDOWN_SQL", "query" => "select ItemID,Name from items_base order by Name", "key_column" => "ItemID", "value_column" => "Name", "size" => "25", "blank_option" => "1");
	$section_data[] = array("label" => "Merchant", "db_column" => "MerchantID", "edtype" => "DROPDOWN_SQL", "query" => "select MerchantID,Name from merchant order by Name", "key_column" => "MerchantID", "value_column" => "Name", "size" => "25", "blank_option" => "0");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Givable", "db_column" => "Givable", "edtype" => "CHECKBOX", "size" => "25");
	$section_data[] = array("label" => "Timer (hours)", "db_column" => "QuestTimer", "edtype" => "TEXT", "size" => "25");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Tell Quest Give", "colspan" => "3", "db_column" => "TELL_QuestGive", "rows" => "5", "edtype" => "TEXTAREA");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Tell Item Give", "colspan" => "3", "db_column" => "TELL_ItemGive", "rows" => "5", "edtype" => "TEXTAREA");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "MOD Item Give", "colspan" => "3", "db_column" => "MOD_ItemGive", "rows" => "5", "edtype" => "TEXTAREA");



	$smarty->assign("section_data",$section_data);
	if ($_POST['save'] == "y") editor_save($section_data,"questdata","QuestID",$_GET['QuestID']);

	$quests = array();
	$sth = mysql_query("select q.*,ig.Name as ig_name,ir.Name as ir_name from questdata as q left join items_base as ig on ig.ItemID=q.Take_ItemID left join items_base as ir on ir.ItemID=q.Return_ItemID order by q.Name");
	while ($data = mysql_fetch_assoc($sth)) {
    	$quests[] = $data;
	}
	$smarty->assign("quest_list",$quests);

	$smarty->display("quests.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>