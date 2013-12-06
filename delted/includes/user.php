<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/

global $userdata,$gamedata,$playerdata;

/*
if (!empty($_SESSION['user_id'])) {
	SQL_QUERY("update users_base set last_accessed=NOW() where user_id=".$_SESSION['user_id']);
	$userdata = get_user($_SESSION['user_id']);
	$smarty->assign("userdata",$userdata);

	if (!empty($_SESSION['player_id'])) {
		mysql_query("update users set last_accessed=NOW() where player_id=".$_SESSION['player_id']);
		$playerdata = get_player($_SESSION['player_id']);
		$smarty->assign("playerdata",$playerdata);
	}

} else {
	if (!in_array($_SERVER['PHP_SELF'],$config['security'])) {
		header("location: /login.php");
		exit;
	}
}
*/
?>