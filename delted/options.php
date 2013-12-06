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
	$section_data[] = array("label" => "Name", "db_column" => "option_name", "edtype" => "TEXT", "size" => "25");
	$section_data[] = array("label" => "Options", "db_column" => "options", "edtype" => "TEXT", "size" => "25");
	$smarty->assign("section_data",$section_data);

	if ($_POST['save'] == "y") editor_save($section_data,"options","option_id",$_GET['option_id']);

	$options = array();
	$sth = mysql_query("select * from options order by option_name");
	while ($data = mysql_fetch_assoc($sth)) {
    	$options[] = $data;
	}
	$smarty->assign("options_list",$options);

	$smarty->display("options.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>