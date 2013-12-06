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
	$section_data[] = array("label" => "Parent", "db_column" => "ParentID", "edtype" => "DROPDOWN_SQL", "query" => "select SkillID,Name from skills order by Name", "key_column" => "SkillID", "value_column" => "Name", "blank_option" => "1");
	$section_data[] = array("label" => "Cost", "db_column" => "Cost", "edtype" => "TEXT", "size" => "25");

	$smarty->assign("section_data",$section_data);

	if ($_POST['save'] == "y") editor_save($section_data,"skills","SkillID",$_GET['SkillID']);

	$skills = array();
	$sth = mysql_query("select s.*,(select Name from skills where SkillID=s.ParentID) as ParentName from skills as s order by s.Name");
	while ($data = mysql_fetch_assoc($sth)) {
    	$skills[] = $data;
	}
	$smarty->assign("skills_list",$skills);


	$smarty->display("skills.tpl");
//} else { 
//	echo "You are either not logged in or not an admin";
//	exit();
//}
?>