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
	$section_data[] = array("label" => "Body", "colspan" => "3", "db_column" => "Body", "rows" => "5", "edtype" => "TEXTAREA");

	$smarty->assign("section_data",$section_data);

	if ($_POST['save'] == "y") editor_save($section_data,"frontnews","FrontID",$_GET['FrontID']);

	$news = array();
	$sth = mysql_query("select s.* from frontnews as s order by s.NewsDate DESC");
	while ($data = mysql_fetch_assoc($sth)) {
    	$news[] = $data;
	}
	$smarty->assign("news_list",$news);


	$smarty->display("news.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>