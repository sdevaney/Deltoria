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


$monster_groups = array();
$sth = mysql_query("select * from monster_groupdata");
while ($data = mysql_fetch_assoc($sth)) {
	$monster_groups[] = $data;
}
$smarty->assign("monster_groups",$monster_groups);

$smarty->display("index.tpl");

?>