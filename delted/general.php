<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/

session_start();
global $userdata,$config,$gamedata;

require_once("../includes/config.php");
require_once("../includes/common.php");
require_once("../includes/db_connect.php");
require_once("../includes/smarty.php");
require_once("../includes/user.php");

if ($_POST['save'] == "y") {
	$sql = "update gamecater.games set attack_skill_id='".$_POST['attack_skill_id']."',defence_skill_id='".$_POST['defence_skill_id']."',start_x='".$_POST['start_x']."',start_y='".$_POST['start_y']."',start_zone_id='".$_POST['start_zone_id']."' where game_id='".$gamedata['game_id']."' limit 1";
	mysql_query($sql);
	$sth = mysql_query("select * from gamecater.games where game_id='".$gamedata['game_id']."' limit 1");
	print mysql_error();
	$gamedata = mysql_fetch_array($sth);
	$smarty->assign("gamedata",$gamedata);
}

$zones = array();
$sth = mysql_query("select zone_id,zone_name from zones order by zone_name");
while ($data = mysql_fetch_array($sth)) {
	$zones[] = $data;
}
$smarty->assign("zones",$zones);

$skills = array();
$sth = mysql_query("select skill_id,skill_name from skills order by skill_name");
while ($data = mysql_fetch_array($sth)) {
	$skills[] = $data;
}
$smarty->assign("skills",$skills);

$smarty->display("general.tpl");

?>