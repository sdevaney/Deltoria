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
	$smarty->assign("section_data",$section_data);

	if ($_POST['save'] == "y") {
		$id = editor_save($section_data,"lootgroup","GroupID",$_GET['GroupID'],0);
		manytomany_save($_POST['Selected_save'],"lootgroupmap","GroupID","ItemID",$id);
		header("location: lootgroup.php?GroupID=".$id);
		exit;
	}

	$groups = array();
	$sth = mysql_query("select * from lootgroup order by Name");
	while ($data = mysql_fetch_assoc($sth)) {
    	$groups[] = $data;
	}
	$smarty->assign("groups",$groups);

	$smarty->display("lootgroup.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>