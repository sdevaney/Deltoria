<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function exec_code($code_id,$code_param_a,$code_param_b,$code_param_c,$code_param_d,$code_param_e) {
	$sth = SQL_QUERY("select * from code where code_id=".$code_id);
	$code = SQL_ASSOC_ARRAY($sth);
	if ($code['code_name'] == "grant_xp") grant_xp($code_param_a);
	if ($code['code_name'] == "set_death_location") set_death_location($code_param_a,$code_param_b,$code_param_c,$code_param_d,$code_param_e);
}

function guard($req_type,$req_equation,$req_amount,$body_success,$body_fail) {
	global $playerdata;
	$success = 1;

	if 	(
		($req_equation == "less than" && $playerdata[$req_type] >= $req_amount) || 
		($req_equation == "greater than" && $playerdata[$req_type] <= $req_amount) || 
		($req_equation == "equal to" && $playerdata[$req_type] != $req_amount)
		) {
		print $body_fail;
	} else {
		print $body_success;
	}
}

function set_death_location($name,$ask,$coins,$body,$set_body) {
	global $playerdata;

	if (strtoupper($ask) == "Y" || strtoupper($ask) == "YES" && $_GET['set_death_location'] != "YES") {
		print "<TABLE CLASS='DataBox' WIDTH='300' BORDER='0'>";
		print "<TH CLASS='DataBox'>".$name."</TH>";
		print "<TR><TD>";
		print $body."<P>";
		if ($coins > $playerdata['coins']) {
			print "You don't have enough funds for this.";
		} else {
			print "Are you sure? <A HREF='".$_SERVER['SELF']."?set_death_location=YES'>Yes</A>";
		}
		return;
	}

	if ($coins > $playerdata['coins']) return;

	if ($coins > 0) {
		$playerdata['coins'] = $playerdata['coins'] - $coins;
		SQL_QUERY("update users set coins=coins-'".intval($coins)."' where player_id=".$playerdata['player_id']);
	}

	SQL_QUERY("update users set death_x=x,death_y=y,death_zone_id=zone_id where player_id=".$playerdata['player_id']);

	if ($set_body != "") {
		print "<TABLE CLASS='DataBox' WIDTH='300' BORDER='0'>";
		print "<TH CLASS='DataBox'>".$name."</TH>";
		print "<TR><TD>";
		print $set_body;
		print "</TD></TR>";
		print "</TABLE>";
	}

}



function grant_xp($get_xp) {
	global $playerdata;
	$lvlchk = mysql_query("select max(level) from level_curve where xp <= ".($playerdata['xp']+$get_xp));
	list($new_level) = mysql_fetch_row($lvlchk);
	mysql_query("update users set level='".$new_level."',xp=xp+".$get_xp." where player_id=".$playerdata['player_id']." limit 1");	
}



?>