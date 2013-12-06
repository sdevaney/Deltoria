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
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Description", "colspan" => "3", "db_column" => "Description", "rows" => "5", "edtype" => "TEXTAREA");
	$section_data[] = "NEW";
	$section_data[] = array("label" => "Mod Code", "colspan" => "3", "db_column" => "ModCode", "rows" => "5", "edtype" => "TEXTAREA");

	$smarty->assign("section_data",$section_data);
	if ($_POST['save'] == "y") editor_save($section_data,"spells","SpellID",$_GET['SpellID']);

	$spells = array();
	$sth = mysql_query("select * from spells order by Name");
	while ($data = mysql_fetch_assoc($sth)) {
    	$spells[] = $data;
	}
	$smarty->assign("spells_list",$spells);

	$smarty->display("spells.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>