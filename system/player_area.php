<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
if ($PlayerData->WID == 0) {
	$sth = mysql_query("select U.*,C.Name as ClanName from user as U left join clans as C on C.ClanID=U.ClanID where U.X=$PlayerData->X and U.Y=$PlayerData->Y and U.MapID=$PlayerData->MapID and U.CoreID != $PlayerData->CoreID and LastAccessed > DATE_SUB(NOW(),INTERVAL 2 HOUR)");

	print mysql_error();
	if (mysql_num_rows($sth) > 0) {
		print "<Table border=0 class=Box1>";
		print "<TR><TD COLSPAN=5 CLASS=Header>Players Detected</TD>";
		$NumbLeft = 0;
		while ($data = mysql_fetch_array($sth)) {
			if ($NumbLeft == 0) { print "</tr><tr>"; $NumbLeft = 5; }
			print "<td width=33 align=center>";
			PlayerInfo($data[CoreID],$data[UserPic]);
			print "<br>$data[Username] ";
			print "</td>";
			$NumbLeft--;
		}
		if (mysql_num_rows($sth) > 1) {
			if ($NumbLeft > 0) {
				print "<TD colspan=$NumbLeft>&nbsp;</TD>";
			}
		}
		print "</TR>";
		print "</TABLE><P>";
	}
}
?>