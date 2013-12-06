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
		$id = editor_save($section_data,"merchant","MerchantID",$_GET['MerchantID'],0);
		manytomany_save($_POST['Selected_save'],"merchantdata","MerchantID","ItemID",$id);
		header("location: merchant.php?MerchantID=".$id);
		exit;
	}

	$merchant = array();
	$sth = mysql_query("select * from merchant order by Name");
	while ($data = mysql_fetch_assoc($sth)) {
    	$merchant[] = $data;
	}
	$smarty->assign("merchant",$merchant);

	$smarty->display("merchant.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>