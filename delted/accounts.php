<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/

session_start();
global $userdata,$config;

require_once("/delted/includes/config.php");
require_once("../includes/common.php");
require_once("../includes/db_connect.php");
require_once("../includes/smarty.php");
require_once("../includes/user.php");

$accounts = array();
$sth = mysql_query("select * from users_base order by email");
while ($data = mysql_fetch_assoc($sth)) {
    $accounts[] = $data;
}
$smarty->assign("accounts_list",$accounts);

if ($_GET['user_id'] > 0) {
	$players = array();
	$sth = mysql_query("select * from users where user_id=".$_GET['user_id']);
	while ($data = mysql_fetch_assoc($sth)) {
		$players[] = $data;
	}
	$smarty->assign("players",$players);

	if ($_POST['NewV'] == $_POST['NewP'] && $_POST['NewP'] != "") {
		mysql_query("update users_base set Password=MD5('".$_POST['NewP']."') where user_id=".$_GET['user_id']);
		$smarty->assign("pass_change","1");
	}

}

$smarty->display("accounts.tpl");

?>