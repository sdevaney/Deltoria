<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// This is where all the battle stuff takes place on the page
	########################
	## Make us our connection
	global $db,$CurNote;
	include ("./system/top.php");
	print "<table border=0 class=pageContainer>";
	print "<tr><td class=pageCell valign=top>";
	include ("./system/attack.php");
	print "</td><td class=pageCell valign=top align=left>";

	print "<Table border=0 width=456 class=box1>";
	print "<Tr><Td class=header>**Warning**</td></tr>";
	print "<Tr><Td>";
	print "Rapidly clicking the attack link or refreshing the page quickly will result in a ban from Deltoria. Please do not load up the server by flooding.";
	print "</td></tr>";
	print "</table><p>";

	include ("./system/chatter.php");

	include ("./system/obj_area.php");

	if ($CurNote != "") {
		print "<table border=0 width=456 class=Box1>";
		print "<tr><td class=header>Attack Message</td></tr>";
		print "<Tr><td>";
		print str_replace("<br><br>","",$CurNote);
		print "</td></tr></table><p>";
	}
	if ($BattleInfo[BattleText] != "") {
		if ($DispLog == "Y" || $DispLog == "N") {
			$PlayerData->DispLog = $DispLog;
			$sth = mysql_query("update user set DispLog='$DispLog' where CoreID=$PlayerData->CoreID");
		}

		print "<table border=0 width=456 class=Box1>";
		print "<tr><td width=100% class=header>Battle Text</td><td NOWRAP class=header>";
		if ($PlayerData->DispLog == "Y") {
			print "<A HREF=$SCRIPT_NAME?DispLog=N><img src=./images/buttons/show_log.jpg border=0></A>";
		} else {
			print "<A HREF=$SCRIPT_NAME?DispLog=Y><img src=./images/buttons/hide_log.jpg border=0></A>";
		}
		print "</td></tr>";
		if ($PlayerData->DispLog == "Y") {
			print "<Tr><td colspan=2>";
			print $BattleInfo[BattleText];
			print "</td></tr>";
		}
		print "</table><p>";
	}
	print "</td></tr></table>";
	include ("./system/bottom.php");

?>