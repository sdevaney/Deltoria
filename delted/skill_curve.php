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

SmartyPaginate::connect();
SmartyPaginate::setLimit(25);

if ($_GET['reset_curve'] > 1) {
	mysql_query("delete from skill_curve");
	mysql_query("insert into skill_curve (level,xp) (1,0)");
	$level = 1;
	for($z = $_GET['start_xp']; $z <= 4000000000; $z = $z * $_GET['reset_curve']) {
		$level++;
		mysql_query("insert into skill_curve (level,xp) values ($level,$z)");
	}
}

$levels = array();
$sql = "select SQL_CALC_FOUND_ROWS * from skill_curve order by level limit ".SmartyPaginate::getCurrentIndex().",".SmartyPaginate::getLimit();
$sth = mysql_query($sql);
while ($data = mysql_fetch_assoc($sth)) {
    $levels[] = $data;
}
$smarty->assign("levels",$levels);

$_query = "SELECT FOUND_ROWS()";
$_result = mysql_query($_query);
$_row = mysql_fetch_array($_result);
SmartyPaginate::setTotal($_row['FOUND_ROWS()']);

SmartyPaginate::assign($smarty);

$smarty->display("skill_curve.tpl");

SmartyPaginate::disconnect();
?>