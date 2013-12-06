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

	$tiles = array();
	if ($_GET['search'] != "") {
	       $sth=mysql_query("select * from tiledata where (Keywords like '%".$_GET['search']."%') and (ImageType='map' || ImageType='Special')");
		#$sth = mysql_query("select * from tiledata where (Name like '%".$_GET['search']."%' or Keywords like '%".$_GET['search']."%' or Image like '%".$_GET['search']."%') and ImageType='map'");
		print mysql_error();
		while ($data = mysql_Fetch_array($sth)) {
			$tiles[] = $data;
		}
	}
	$smarty->assign("tiles",$tiles);

	$smarty->display("map_tiles.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>