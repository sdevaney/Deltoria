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
$section_data[] = array("label" => "Name", "db_column" => "group_name", "edtype" => "TEXT", "size" => "25");
$smarty->assign("section_data",$section_data);

if ($_POST['save'] == "y") {
	$id = editor_save($section_data,"groups","group_id",$_GET['group_id'],0);
	manytomany_save($_POST['Selected_save'],"items_groups","group_id","item_id",$id);
	header("location: lootgroup.php?group_id=".$id);
	exit;
}

$groups = array();
$sth = mysql_query("select * from groups order by group_name");
while ($data = mysql_fetch_assoc($sth)) {
    $groups[] = $data;
}
$smarty->assign("groups",$groups);

$smarty->display("groups.tpl");

?>