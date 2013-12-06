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

//if($session->isAdmin()){

	$section_data = array();
	$section_data[] = array("label" => "1st Item", "db_column" => "a_item_id", "edtype" => "DROPDOWN_SQL", "query" => "select item_id,item_name from items_base order by item_name", "key_column" => "item_id", "value_column" => "item_name", "size" => "25");
	$section_data[] = array("label" => "2nd Item", "db_column" => "b_item_id", "edtype" => "DROPDOWN_SQL", "query" => "select item_id,item_name from items_base order by item_name", "key_column" => "item_id", "value_column" => "item_name");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "1st Preserve", "db_column" => "a_preserve", "edtype" => "CHECKBOX");
	$section_data[] = array("label" => "2nd Preserve", "db_column" => "b_preserve", "edtype" => "CHECKBOX");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Item", "db_column" => "result_item_id", "edtype" => "DROPDOWN_SQL", "query" => "select item_id,item_name from items_base order by item_name", "key_column" => "item_id", "value_column" => "item_name");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Skill", "db_column" => "skill_id", "edtype" => "DROPDOWN_SQL", "query" => "select skill_id,skill_name from skills order by skill_name", "key_column" => "skill_id", "value_column" => "skill_name");
	$section_data[] = array("label" => "Skill Level", "db_column" => "skill_level", "edtype" => "TEXT", "size" => "25");

	$smarty->assign("section_data",$section_data);

	if ($_POST['save'] == "y") {
    	$id = editor_save($section_data,"items_merge","merge_id",$_GET['merge_id'],0);
	    header("location: items_merge.php?merge_id=".$id);
	    exit;
	}


	$items = array();
	$sql = "select m.*, s.skill_name, ai.item_name as a_item_name, bi.item_name as b_item_name, ri.item_name as result_item_name from items_merge as m left join items_base as ai on ai.item_id=m.a_item_id left join items_base as bi on bi.item_id=m.b_item_id left join items_base as ri on ri.item_id=m.result_item_id left join skills as s on s.skill_id=m.skill_id";
	$sth = mysql_query($sql);
	while ($data = mysql_fetch_assoc($sth)) {
    	$merges[] = $data;
	}
	$smarty->assign("merge_list",$merges);

	$smarty->display("items_merge.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>