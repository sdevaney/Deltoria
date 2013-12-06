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
	$section_data[] = array("label" => "Item A", "db_column" => "ItemA", "edtype" => "DROPDOWN_SQL", "query" => "select ItemID,Name from items_base order by Name", "key_column" => "ItemID", "value_column" => "Name", "blank_option" => "1");
	$section_data[] = array("label" => "Item B", "db_column" => "ItemB", "edtype" => "DROPDOWN_SQL", "query" => "select ItemID,Name from items_base order by Name", "key_column" => "ItemID", "value_column" => "Name", "blank_option" => "1");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Preserve A", "db_column" => "PreserveItemA", "edtype" => "CHECKBOX");
	$section_data[] = array("label" => "Preserve B", "db_column" => "PreserveItemB", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Skill", "db_column" => "SkillID", "edtype" => "DROPDOWN_SQL", "query" => "select SkillID,Name from skills order by Name", "key_column" => "SkillID", "value_column" => "Name", "blank_option" => "1");
	$section_data[] = array("label" => "Skill Level", "db_column" => "SkillLevel", "edtype" => "TEXT", "size" => "25");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Result", "db_column" => "ResultID", "edtype" => "DROPDOWN_SQL", "query" => "select ItemID,Name from items_base order by Name", "key_column" => "ItemID", "value_column" => "Name", "blank_option" => "1");
	$section_data[] = array("label" => "2nd tool", "db_column" => "OptItem", "edtype" => "DROPDOWN_SQL", "query" => "select ItemID,Name from items_base order by Name", "key_column" => "ItemID", "value_column" => "Name", "blank_option" => "1");
	$section_data[] = "NEW";

	$smarty->assign("section_data",$section_data);
	if ($_POST['save'] == "y") {
		$id = editor_save($section_data,"items_merge","MergeID",$_GET['MergeID']);
	}

	$items = array();
	$sth = mysql_query("select m.*,a.Name as ItemA_Name,b.Name as ItemB_Name,r.Name as Result_Name from items_merge as m left join items_base as a on a.ItemID=m.ItemA left join items_base as b on b.ItemID=m.ItemB left join items_base as r on r.ItemID=m.ResultID order by a.Name");
	print mysql_error();
	while ($data = mysql_fetch_assoc($sth)) {
    	$items[] = $data;
	}
	$smarty->assign("merge_list",$items);
	$smarty->display("merge.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>
