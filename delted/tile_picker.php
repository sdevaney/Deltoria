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
		/*if (!stristr($_GET['image_type'],",")) {
			$img_type = "'".$_GET['image_type']."'";
		} else {
			$img_type = $_GET['image_type'];
		}*/

		$sql = "select * from tiledata where (Name like '%".$_GET['search']."%' or Keywords like '%".$_GET['search']."%' or Image like '%".$_GET['search']."%') /*and ImageType in (".$img_type.")*/";
		$sth = mysql_query($sql);
		print mysql_error();
		while ($data = mysql_Fetch_array($sth)) {
			$tiles[] = $data;
		}
	}
	$smarty->assign("tiles",$tiles);

	$smarty->display("tile_picker.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>