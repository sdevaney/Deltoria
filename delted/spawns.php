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
	$section_data[] = array("label" => "Hostile", "db_column" => "Hostile", "edtype" => "CHECKBOX");
	$section_data[] = array("label" => "Max Spawn", "db_column" => "MaxSpawn", "edtype" => "TEXT", "size" => "25");
	$smarty->assign("section_data",$section_data);

	if ($_POST['save'] == "y") {
		$id = editor_save($section_data,"monster_groupdata","GroupID",$_GET['GroupID'],0);
		manytomany_save($_POST['Selected_save'],"monster_groups","GroupID","MonsterID",$id);
		header("location: spawns.php?GroupID=".$id);
		exit;
	}

	$spawns = array();
	$sth = mysql_query("select * from monster_groupdata order by Name");
	while ($data = mysql_fetch_assoc($sth)) {
		$spawns[] = $data;
	}
	$smarty->assign("spawns",$spawns);

	$smarty->display("spawns.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>