<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Clan page if not in clan show clan list
if ($Join != "" && $Password == "" && $PlayerData->Level >= 10) {
	print "<table border=1 class=Box1>";
	print "<tr><td class=Header colspan=5>Join Clan</td></tr>";
	print "<FORM ACTION=$SCRIPT_NAME METHOD=GET>";
	print "<tr><td colspan=5>";
	$sth = mysql_query("select Name,Founder from clans where ClanID=$Join");
	list($ClanName,$ClanFounder) = mysql_fetch_row($sth);
	print "You've like to join the $ClanName clan? Please enter the password below:<P>";
	print "<INPUT TYPE=PASSWORD NAME=Password SIZE=15 MAXLENGTH=15>";
	print "<INPUT TYPE=HIDDEN NAME=Join VALUE=$Join>";
	print "<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Join>";
	print "</td></tr>";
	print "</FORM>";	
	print "</table><p>";
} elseif ($Join != "" && $Password != "" && $PlayerData->Level >= 10) {
	$sth = mysql_query("select Name,Founder from clans where ClanID=$Join and Password=password('$Password')");
	print mysql_error();
	if (mysql_num_rows($sth) == 0) {
		print "<table border=1 class=Box1>";
		print "<tr><td class=Header colspan=5>Join Clan Error</td></tr>";
		print "<tr><td colspan=5>";
		print "Invalid Clan Selection or Clan Password<BR>";
		print "</td></tr>";
		print "</table><p>";
	} else {
		list($ClanName,$ClanFounder) = mysql_fetch_row($sth);
		$sth = mysql_query("select count(Username) from user where ClanID=$Join");
		list ($ClanCount) = mysql_fetch_row($sth);
//		if ($ClanCount < 10) {
			$sth = mysql_query("update user set ClanID=$Join where CoreID=$PlayerData->CoreID");
			print mysql_error();
			print "<table border=1 class=Box1>";
			print "<tr><td class=Header colspan=5>Leave Clan</td></tr>";
			print "<FORM ACTION=$SCRIPT_NAME METHOD=POST>";
			print "<tr><td colspan=5>";
			print "Welcome to the $ClanName $PlayerData->Username!<BR>";
			print "</td></tr>";
			print "</table><p>";
			$PlayerData->ClanID = $Join;
//		} else {
//			print "<table border=1 class=Box1>";
//			print "<tr><td class=Header colspan=5>Join Clan Error</td></tr>";
//			print "<tr><td colspan=5>";
//			print "Clans are limited to 10 members. The clan you tried to join has reached this limit.<BR>";
//			print "</td></tr>";
//			print "</table><p>";
//		}
	}
} elseif ($Leave == "Yes") {
	print "<table border=1 class=Box1>";
	print "<tr><td class=Header colspan=5>Leave Clan</td></tr>";
	print "<tr><td colspan=5>";
	$sth = mysql_query("select Name,Founder from clans where ClanID=$PlayerData->ClanID");
	list($ClanName,$ClanFounder) = mysql_fetch_row($sth);
	if ($ClanFounder == $PlayerData->CoreID) {
		print "You have disbanded the <?=$ClanName?>.";
		$sth = mysql_query("update user set ClanID=0,ClanFlags='' where ClanID=$PlayerData->ClanID");
		print mysql_error();
		$sth = mysql_query("delete from overlay_clan where ClanID=$PlayerData->ClanID");
		print mysql_error();
		$sth = mysql_query("delete from clans where ClanID=$PlayerData->ClanID");
		print mysql_error();
		$sth = mysql_query("delete from clan_buildings where ClanID=$PlayerData->ClanID");
		print mysql_error();
		$sth = mysql_query("delete from clan_warriors where ClanID=$PlayerData->ClanID");
		print mysql_error();
// Leaving clan
		$sth = mysql_query("delete from forums_index where ClanID=$PlayerData->ClanID and ClanID > 0");
		print mysql_error();

		$PlayerData->ClanID = 0;
	} else {
		print "You have packed your bags and parted from the <?=$ClanName?> guild.";
		$sth = mysql_query("update user set ClanID=0,ClanFlags='' where CoreID=$PlayerData->CoreID");
		print mysql_error();
		$PlayerData->ClanID = 0;
	}
} elseif ($Leave == "No") {
	print "<table border=1 class=Box1>";
	print "<tr><td class=Header colspan=5>Leave Clan</td></tr>";
	print "<tr><td colspan=5>";
// Disbanding clan
	$sth = mysql_query("select Name,Founder from clans where ClanID=$PlayerData->ClanID");
	list($ClanName,$ClanFounder) = mysql_fetch_row($sth);
	if ($ClanFounder == $PlayerData->CoreID) {
		?>
		According to my records you're the founder of <?=$ClanName?>.<p>

		Because you are the founder when you leave the clan the clan will be left without a leader.<p>
		
		If the clan is disbanded any fort built by the clan 
		will be destroyed. None of the gold used to build the city will be refunded.<p>

		Are you sure that you wish to continue and disband this clan?<br>
		<center>
			<a href=<?=$SCRIPT_NAME?>?Leave=Yes><img border=0 src=./images/buttons/yes.jpg></A>
		</center>
		<?
	} else {
		?>
		Are you sure that you wish to leave the <?=$ClanName?>?<p>
		<center>
			<a href=<?=$SCRIPT_NAME?>?Leave=Yes><img border=0 src=./images/buttons/yes.jpg></A>
		</center>
		<?
	}


	print "</td></tr>";
	print "</table><p>";
} elseif ($Create == "Blank" && $PlayerData->Level >= 17) {
	print "<table border=1 class=Box1 width=700>";
	print "<tr><td class=Header colspan=5>Create New Clan</td></tr>";
	print "<tr><td colspan=5>";
	?>
	Clans (or Factions) are how players in Deltoria really become 
part of a community or family. 
	Factions can start up for the cost of 50,000 gold and must accumulate at least 5 members within 
	one weeks time. If a faction can not recruit 5 members within a single week the faction will 
	be disbanded and all funds used to build the faction will be lost.<P>

	After building a faction and reaching the 5 member requirement the clan leader may use Seeds of Building 
	which may be purchased for 2,000 gold. The Faction leader will then need to take the seed to a proposed 
	building ground for the clan fort and use the seed. If the seed 
takes hold the tile will be dotted red. This means that the faction owns this land. Adjoining parcels of land (tiles) may be purchased at the cost of 1,000 gold for each tile. Factions may own any number of tiles up to 15 tiles away from the initial starting location.<P>

	Clan members will always know where other clan members are and 
they will be able to also view their stats and what the player is equipped with.<P>
	
	As a clan leader is your soul responsibility to manage your 
clan. To act fairly and just and to mitigate arguments between clan 
members and other clans. It is your responsibility to ensure that your 
clan members enjoy the game to its fullest by scheduling quests that can 
be done as a group, or promoting team work between members for a common 
goal.<P>
	Clan names are to be no longer than 25 characters and 
symbols cannot be used.<BR> 
	<?
	print "</td></tr>";
// Player creates new clan
	if ($PlayerData->Coins >= 50000) {
		print "<tr>";
		print " <td colspan=2 class=Menu>Name</td>";
		print " <td class=Menu>Call Sign</td>";
		print " <td class=Menu>Password</td>";
		print " <td class=Menu>Create</td>";
		print "</tr>";

		print "<form action=$SCRIPT_NAME method=POST>";
		
		print "<tr>";
		print "<td colspan=2><input type=text size=15 maxlength=25 name=NewClan></td>";
		print "<td><input type=letters size=3 maxlength=3 name=Call></td>";
		print "<td><input type=password size=10 maxlength=10 name=Password></td>";
		print "<td rowspan=2 align=center><input type=submit name=submit value=Create></td>";
		print "</tr>";

		print "<tr><td class=Menu>Description</td><td colspan=3>";
		print "<input type=text size=50 maxlength=50 name=Description>";
		print "</td></tr>";
			
		print "</form>";
	} else {
		print "<tr><td colspan=5>";
		print "Notice. You do not have the 50,000 coins required to create a clan.";
		print "</td></tr>";
	}
	print "</table><p>";
} elseif ($NewClan != "" && $PlayerData->Coins >= 50000 && $PlayerData->Level >= 17) {
	if (strlen($NewClan) < 4 || strlen($NewClan) > 25 || 
strlen($Call) < 
3) {
		print "<table border=1 class=Box1>";
		print "<Tr><td class=Header>Error Creating Clan</td></tr>";
		print "<tr><td>Clan names must be between 4-26 
characters and the 
clan call sign must be 3 letters in length.</td></tr>";
		print "</table><p>";
	} else {
		$sth = mysql_query("select Name from clans where Name='$NewClan' or Letters='$Call'");
		print mysql_error();
		if (mysql_num_rows($sth) == 0) {
			$sth = mysql_query("insert into clans (Name,Letters,Founder,Password,CreationDate,Description) values ('$NewClan','$Call',$PlayerData->CoreID,password('$Password'),NOW(),'$Description')");
			print mysql_error();
			if (mysql_affected_rows() > 0) {
				$ClanID = mysql_insert_id();
				$Startupamt = mysql_query("update user set Coins = $PlayerData->Coins - 5000 where CoreID = $PlayerData->CoreID");
				print "<table border=1 class=Box1>";
				print "<Tr><td class=Header>Clan Creation Successful</td></tr>";
				print "<tr><td>Welcome $PlayerData->Username. Your clan has been created.</td></tr>";
				print "</table><p>";
				$PlayerData->AdjustValue("ClanID",$ClanID);
			} else {
				print "<table border=1 class=Box1>";
				print "<Tr><td class=Header>Error Creating Clan</td></tr>";
				print "<tr><td>There was an error while recording your clan.</td></tr>";
				print "</table><p>";
			}
		} else {
			print "<table border=1 class=Box1>";
			print "<Tr><td class=Header>Error Creating Clan</td></tr>";
			print "<tr><td>That clan name appears to be taken already.</td></tr>";
			print "</table><p>";
		}
	}
}

// Add new clan to clan page
print "<table border=1 class=Box1 WIDTH=700>";
print "<tr><td class=Header colspan=5>Clans</td></tr>";
print "<tr>";
print " <td class=Menu>Name (Call)</td>";
print " <td class=Menu>Founder</td>";
print " <td class=Menu>Members</td>";
print " <td class=Menu>Founding Date</td>";
print " <td class=Menu>Join</td>";
print "</tr>";

if ($PlayerData->ClanID != 0 && $ShowClan != "Y") {
	print "<TR><TD COLSPAN=5 ALIGN=CENTER><B><A HREF=$SCRIPT_NAME?ShowClan=Y>Display Clan Listings</A></TD></TR>";
} else {
	$sth = mysql_query("select C.CreationDate,C.ClanID,C.Name,C.Founder,U.Username as FounderName,C.Description,C.Letters from clans as C left join user as U on U.CoreID=C.Founder order by C.Name");
	while ($ClanData = mysql_fetch_array($sth)) {
		$sth_mem = mysql_query("select count(CoreID) from user where ClanID=$ClanData[ClanID]");
		list($ClanCount) = mysql_fetch_row($sth_mem);
	
		print "<TR>";
		print " <TD>$ClanData[Name] ($ClanData[Letters])</TD>";
		print " <TD>$ClanData[FounderName]</TD>";
		print " <TD>$ClanCount</TD>";
		print " <TD>$ClanData[CreationDate]</TD>";
		print " <TD>";
		if ($PlayerData->ClanID == 0 /*&& $ClanCount < 10*/) {
			print " <a href=$SCRIPT_NAME?Join=$ClanData[ClanID]><img border=0 src=./images/buttons/join_clan.jpg></a>";
		} else {
			print "&nbsp;";
		}
		print " </TD>";
		print "</TR>";
		print "<tr><td colspan=5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ClanData[Description]</td></tr>";
	}
	if ($PlayerData->ClanID == 0) {
		if ($PlayerData->Level >= 17) {
			print "<tr>";
			print " <td colspan=5 class=footer>";
			print " <a href=$SCRIPT_NAME?Create=Blank><img border=0 src=./images/buttons/create_clan.jpg></a>";
			print " </td>";
			print "</tr>";
		}
	} else {
		print "<tr>";
		print " <td colspan=5 class=footer>";
		print " <a href=$SCRIPT_NAME?Leave=No><img border=0 src=./images/buttons/leave_clan.jpg></a>";
		print " </td>";
		print "</tr>";
	}
}
print "</table><p>";

if ($PlayerData->ClanID != 0) {
	if (FlagCheck("A",$PlayerData->ClanFlags) == 1) {
		/*----------------------------------------*/
		/* Boot Members				  */
		/*----------------------------------------*/
		if ($Boot > 0) { 
			print "<table border=0 class=Box1>";
			print "<tr><td class=header>Boot Member</td></tr>";
			print "<tr><td valign=center>";
		}
		if ($Boot > 0 && $Auth != "Y") {
			$sth = mysql_query("select * from user where CoreID=$Boot and ClanID=$PlayerData->ClanID");
			if (mysql_num_rows($sth) == 0) {
				print "Error: That user can't be located or is not part of the clan.";
			} else {
				$UData = mysql_fetch_array($sth);

				if ($UData[ClanFlags] == "") {
					PlayerInfo($UData[CoreID],$UData[UserPic]);
					print "Are you sure you wish to boot $UData[Username]? <A HREF=$SCRIPT_NAME?Boot=$Boot&Auth=Y>Yes</A>";
				} else {
					print "Error: That user has access flags. These must be removed first.";
				}
				print "<P>";
			}
		} elseif ($Boot > 0 && $Auth == "Y") {
			$sth = mysql_query("select * from user where CoreID=$Boot and ClanID=$PlayerData->ClanID");
			if (mysql_num_rows($sth) == 0) {
				print "Error: That user can't be located or is not part of the clan.";
			} else {
				$UData = mysql_fetch_array($sth);
				if ($UData[ClanFlags] == "") {
					PlayerInfo($UData[CoreID],$UData[UserPic]);
					print "You have booted $UData[Username]";
					$sth = mysql_query("update user set ClanID=0,ClanFlags='' where CoreID=$Boot");
					print mysql_error();
					SendNote($Boot,"Clan Boot","You have been booted out of your clan by ".$PlayerData->Username);
				} else {
					print "Error: That user has access flags. These must be removed first.";
				}
				print "<P>";
			}
		}
		if ($Boot > 0) {
			print "</td></tr></table><p>";
		}
	}


	if (FlagCheck("H",$PlayerData->ClanFlags) == 1 && $PlayerData->Level >= 17 && FlagCheck("P",$PlayerData->ClanFlags) == 0) {
		/*----------------------------------------*/
		/* Hero Warp				  */
		/*----------------------------------------*/
		if ($Warp > 0) { 
			print "<table border=0 class=Box1>";
			print "<tr><td class=header>Warp to Member</td></tr>";
			print "<tr><td valign=center>";
		}
		if ($Warp > 0 && $Auth != "Y") {
			$WarpL = $PlayerData->Level - 250;
			$sth = mysql_query("select * from user where CoreID=$Warp and ClanID=$PlayerData->ClanID and Level >= $WarpL and Level <= ".$PlayerData->Level);
			if (mysql_num_rows($sth) == 0) {
				print "Error: That user can't be located, is not part of the clan or is a higher level than you are or not within 25 levels of you.";
			} else {
				$UData = mysql_fetch_array($sth);
				PlayerInfo($UData[CoreID],$UData[UserPic]);
				print "Are you sure you wish to warp to $UData[Username]? This will cost 250,000 gold or 1% of the gold in the vault: <A HREF=$SCRIPT_NAME?Warp=$Warp&Auth=Y>Yes</A>";
				print "<P>";
			}
		} elseif ($Warp > 0 && $Auth == "Y") {
			$sth = mysql_query("select * from user where CoreID=$Warp and ClanID=$PlayerData->ClanID and Level <= ".$PlayerData->Level);
			$totvault = mysql_query("select ClanBank from clans where ClanID=$PlayerData->ClanID");
			$totcost = mysql_fetch_array($totvault);
			$cost = $totcost[ClanBank]*.01;
			if ($cost >= 250000) {
				$cost = 250000;
			}
			if (mysql_num_rows($sth) == 0) {
				print "Error: That user can't be located, is not part of the clan or is a higher level than you are.";
			} elseif ($totcost[ClanBank] < $cost) {
				print "Error: You can't afford to warp. You need at least $cost coins in the vault.";
			} else {
				$UData = mysql_fetch_array($sth);
				PlayerInfo($UData[CoreID],$UData[UserPic]);
				print "You have warped to $UData[Username]";
				$sth = mysql_query("update clans set ClanBank=ClanBank-$cost where ClanID =".$PlayerData->ClanID);
				$sth = mysql_query("update user set X=$UData[X],Y=$UData[Y],MapID=$UData[MapID] where CoreID=".$PlayerData->CoreID);
				print mysql_error();
				SendNote($Warp,"Clan Warp",$PlayerData->Username." has warped to you");
				print "<P>";
			}
		}
		if ($Warp > 0) {
			print "</td></tr></table><p>";
		}
	}

	if (FlagCheck("P",$PlayerData->ClanFlags) == 1 && $PlayerData->Level >= 36) {
		/*----------------------------------------*/
		/* Paladin Warp				  */
		/*----------------------------------------*/
		if ($Warp > 0) { 
			print "<table border=0 class=Box1>";
			print "<tr><td class=header>Warp to Member</td></tr>";
			print "<tr><td valign=center>";
		}
		if ($Warp > 0 && $Auth != "Y") {
			$sth = mysql_query("select * from user where CoreID=$Warp and ClanID=$PlayerData->ClanID and Level <= ".$PlayerData->Level);
			if (mysql_num_rows($sth) == 0) {
				print "Error: That user can't be located, is not part of the clan or is a higher level than you are.";
			} else {
				$UData = mysql_fetch_array($sth);
				PlayerInfo($UData[CoreID],$UData[UserPic]);
				print "Are you sure you wish to warp to $UData[Username]? This will cost 250,000 gold or 5% of the gold in the clan vault: <A HREF=$SCRIPT_NAME?Warp=$Warp&Auth=Y>Yes</A>";
				print "<P>";
			}
		} elseif ($Warp > 0 && $Auth == "Y") {
			$sth = mysql_query("select * from user where CoreID=$Warp and ClanID=$PlayerData->ClanID and Level <= ".$PlayerData->Level);
			$totvault = mysql_query("select ClanBank from clans where ClanID=$PlayerData->ClanID");
			$totcost = mysql_fetch_array($totvault);
			$cost = $totcost[ClanBank]*.05;
			if ($cost >= 250000) {
				$cost = 250000;
			}
			if (mysql_num_rows($sth) == 0) {
				print "Error: That user can't be located, is not part of the clan or is a higher level than you are.";
			} elseif ($totcost[ClanBank] < $cost) {
				print "Error: You can't afford to warp. You need at least $cost coins in the vault.";
			} else {
				$UData = mysql_fetch_array($sth);
				PlayerInfo($UData[CoreID],$UData[UserPic]);
				print "You have warped to $UData[Username]";
				$sth = mysql_query("update clans set ClanBank=ClanBank-$cost where ClanID =".$PlayerData->ClanID);
				$sth = mysql_query("update user set X=$UData[X],Y=$UData[Y],MapID=$UData[MapID] where CoreID=".$PlayerData->CoreID);
				print mysql_error();
				SendNote($Warp,"Clan Warp",$PlayerData->Username." has warped to you");
				print "<P>";
			}
		}
		if ($Warp > 0) {
			print "</td></tr></table><p>";
		}
	}


	print "<table border=1 class=Box1 width=700>";
	print "<tr><td colspan=5 class=Header>Member Managment</td>";

	print "<td width=15 class=header>";
	Help("Advisor","An advisor has the abiliy to grant/deny ranks, boot players from the clan, and almost all functions that the founder has.");
	print "</td><td width=15 class=header>";
	Help("General","A general has the ability to control military units belonging to the clan and to attack rival alleigances kingdoms.");
	print "</td><td width=15 class=header>";
	Help("Hero","A Hero has the ability to warp to any clan member within 25 levels below the player with the rank of Hero. Using this ability costs the clan 1% of the coins in the clan vault or 250,000 coins each time is it used.");
	print "</td><td width=15 class=header>";
	Help("Builder","Builders have the ability to build buildings and to develop your clans kingdom.");
	print "</td><td width=15 class=header>";
	Help("Paladin","Paladins have the ability to warp to any clan member from 10 to the level of the player with the rank of Paladin. Using this ability costs the clan 5% of the coins in the clan vault or 1,250,000 coins each time it is used.");
	print "</td><td class=header>&nbsp;</td>";
	print "</tr>";
// Clan flags explained just above but heres where the work happens
	if ((FlagCheck("A",$PlayerData->ClanFlags) == 1 || $PlayerData->ClanData->Founder == $PlayerData->CoreID) && $Toggle != "") {
		$Approve = "Y";

		if ($State == "On") {
			$sth = mysql_query("select Username from user where ClanFlags like '%$Toggle%' and ClanID=$PlayerData->ClanID");
			$NumUsers = mysql_num_rows($sth);
			if ($Toggle == "H" && $NumUsers >= 6) { $Approve = "N"; }
			if ($Toggle == "A" && $NumUsers >= 2) { $Approve = "N"; }
			if ($Toggle == "B" && $NumUsers >= 5) { $Approve = "N"; }
			if ($Toggle == "G" && $NumUsers >= 5) { $Approve = "N"; }
			if ($Toggle == "P" && $NumUsers >= 1) { $Approve = "N"; }
		}
// Only Advisor or Founder can add/remove ranks
		if ($Approve == "Y") {
			if ($Toggle == "H") {
				$sth = mysql_query("select * from user where ClanID=$PlayerData->ClanID and CoreID=$User and ClanFlag_Change < DATE_SUB(NOW(),INTERVAL 3 HOUR)");
			} elseif ($Toggle == "P") {
				$sth = mysql_query("select * from user where ClanID=$PlayerData->ClanID and CoreID=$User and ClanFlag_Change < DATE_SUB(NOW(),INTERVAL 6 HOUR)");
			} else {
				$sth = mysql_query("select * from user where ClanID=$PlayerData->ClanID and CoreID=$User");
			}
			if (mysql_num_rows($sth) == 0) {
				print "<Tr><td colspan=5><FONT COLOR=RED><B>Error:</B></FONT> Either that user couldn't be located or they have had their clan rank changed too soon</td></tr>";
			} else {
				$UData = mysql_fetch_array($sth);
				if ($State == "On") {
					if (FlagCheck($Toggle,$UData[ClanFlags]) == 0) {
						$UData[ClanFlags] = $UData[ClanFlags].$Toggle;
						if ($Toggle == "H" || $Toggle == "P") {
							$sth = mysql_query("update user set ClanFlags='$UData[ClanFlags]',ClanFlag_Change=NOW() where CoreID=$UData[CoreID]");
						} else {
							$sth = mysql_query("update user set ClanFlags='$UData[ClanFlags]' where CoreID=$UData[CoreID]");
						}
					}
				} else {
					$UData[ClanFlags] = str_replace($Toggle,"",$UData[ClanFlags]);
					if ($Toggle == "H" || $Toggle == "P") {
						$sth = mysql_query("update user set ClanFlags='$UData[ClanFlags]',ClanFlag_Change=NOW() where CoreID=$UData[CoreID]");
					} else {
						$sth = mysql_query("update user set ClanFlags='$UData[ClanFlags]' where CoreID=$UData[CoreID]");
					}
				}
			}	
		} else {
				print "<Tr><td colspan=5><FONT COLOR=RED><B>Error:</B></FONT> You have too many of those types of users</td></tr>";	
		}
	}
	print "<tr><td class=menu>&nbsp;</td><td class=menu>Player Name</td><td class=menu>Level</td><td class=Menu>Age</td><td class=menu>Idle Time</td><td class=Menu>A</td><td class=Menu>G</TD><TD class=Menu>H</td><Td class=Menu>B</td><Td class=Menu>P</td><td class=Menu>Managment</tr>";
	$sth = mysql_query("select *,UNIX_TIMESTAMP()-UNIX_TIMESTAMP(LastAccessed) as IdleTime from user where ClanID=$PlayerData->ClanID");
	print mysql_error();
	while ($UData = mysql_fetch_array($sth)) {
// Get idle time from last login to game and display it on clan page
$IdleTime = $UData[IdleTime];
$IdleMod = "sec";
if ($IdleTime > 60) {
	$IdleTime = intval($IdleTime / 60);
	$IdleMod = "min";
}
if ($IdleTime > 60 && $IdleMod == "min") {
	$IdleTime = intval($IdleTime / 60);
	$IdleMod = "hr";
}
if ($IdleTime > 24 && $IdleMod == "hr") {
	$IdleTime = intval($IdleTime / 24);
	$IdleMod = "day";
}
$IdleTime = intval($IdleTime);



		print "<tr>";
		print "<td width=30>";
		PlayerInfo($UData[CoreID],$UData[UserPic]);
		print "</td><td>$UData[Username]</td><td>$UData[Level]</TD><TD>$UData[Age]</TD><TD>$IdleTime $IdleMod</TD>";

		print "<td>";
		PrintToggle("A",$UData);
		print "</td>";

		print "<td>";
		PrintToggle("G",$UData);
		print "</td>";

		print "<td>";
		PrintToggle("H",$UData);
		print "</td>";

		print "<td>";
		PrintToggle("B",$UData);
		print "</td>";

		print "<td>";
		PrintToggle("P",$UData);
		print "</td>";
		print "<td>";
		if (FlagCheck("A",$PlayerData->ClanFlags) == 1) {
			print "[ ";
			print "<A HREF=$SCRIPT_NAME?Boot=$UData[CoreID]>Boot</A>";
			print " ]<BR>";
		}
		$WLevel = $PlayerData->Level - 25;
		if ((FlagCheck("H",$PlayerData->ClanFlags) == 1 && $PlayerData->Level >= 17 && $UData[Level] >= $WLevel && $UData[Level] <= $PlayerData->Level) || (FlagCheck("P",$PlayerData->ClanFlags) == 1 && $PlayerData->Level >= 36 && $UData[Level] <= $PlayerData->Level)) {
			print "[ ";
			print "<A HREF=$SCRIPT_NAME?Warp=$UData[CoreID]>Warp</A>";
			print " ]<BR>";
		}

		print "&nbsp;</td>";
		print "</TR>";

	}
	print "</table><p>";
}
// Reset clan password
if ($PlayerData->ClanID != 0 && $PlayerData->ClanData->Founder == $PlayerData->CoreID) {
	print "<table border=1 class=Box1 WIDTH=700>";
	print "<tr><td class=Header>Reset Clan Password</td></tr>";
	print "<form action=$SCRIPT_NAME>";
	print "<tr><td>";
	print "To reset your clan password please fill out the fields below. A clan password is required by users in order to join your clan.<p>";
	print "<table border=0 class=box1>";
	print "<tr><td class=Menu>";
	print "New Password";
	print "</td><td class=menu>";
	print "Verify Password";
	print "</td></tr>";
	if ($NewPassA == $NewPassB && $NewPassA != "") {
		$sth = mysql_query("update clans set Password=password('$NewPassA') where ClanID=$PlayerData->ClanID");
		print mysql_error();
		print "<tr><td colspan=2>";
		print "<B>Notice:</B> Your clan password has been updated.";
		print "</td></tr>";
	} else {
		print "<Tr><Td>";
		print "<INPUT TYPE=PASSWORD NAME=NewPassA WIDTH=15 MAXLENGTH=15>";
		print "</td><td>";
		print "<INPUT TYPE=PASSWORD NAME=NewPassB WIDTH=15 MAXLENGTH=15>";
		print "</td></tr><tr><td colspan=2 class=footer><input type=submit name=submit value=\"Reset Password\"></table><br>";
		print "</td></tr>";
	}
	print "</table></form>";
	print "</td></tr></table><p>";
}
// Set clan recall point
$sth = mysql_query("select * from overlay_clan where X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID and ClanID=$PlayerData->ClanID and ClanID > 0");
print mysql_error();
if (mysql_num_rows($sth) > 0 && $PlayerData->ClanData->Founder == $PlayerData->CoreID) {
	print "<TABLE BORDER=0 class=BOX1 WIDTH=700>";
	print "<TR><TD CLASS=HEADER>Clan Recall Location</TD></TD>";
	print "<TR><TD>";
	if ($SetRecall == "Y") {
		$sth = mysql_query("update clans set HomeX=$PlayerData->X,HomeY=$PlayerData->Y,HomeMapID=$PlayerData->MapID where ClanID=$PlayerData->ClanID");
                print mysql_error();
                $PlayerData->ClanData->HomeX = $PlayerData->X;
                $PlayerData->ClanData->HomeY = $PlayerData->Y;
                $PlayerData->ClanData->HomeMapID = $PlayerData->MapID;
		print "<B>Notice:</B> Clan Recall Location Updated<P>";
	}



	print "Clan Members have the option to recall directly to your clans land. Since you own this section of land you may mark ";
	print "this as a valid recall location. A clan may only have one recall location at a time. The recall location once set may ";
	print "be changed from the clan menu while standing on clan owned land.<BR>";
	print "</TD></TR>";
	print "<TR><TD CLASS=Footer>";
	print "[ <A HREF=$SCRIPT_NAME?SetRecall=Y>Set Recall Location</A> ] </TD></TR>";
	print "</TABLE><P>";
}


if ($PlayerData->ClanID != 0 && $PlayerData->ClanData->HomeX != 0 && $PlayerData->ClanData->HomeY != 0 && $PlayerData->ClanData->HomeMapID != 0) {
	$sthc = mysql_query("select Founder, HomeMapID from clans where ClanID = ".$PlayerData->ClanID);
	list($leader, $hmap) = mysql_fetch_row($sthc);
	$sthl = mysql_query("select level from user where coreid=$leader");
	list($mini) = mysql_fetch_row($sthl);
	if (($mini < 36 && $PlayerData->Level >= 10) || ($mini > 35 && $PlayerData->Level >= 36)) {
		print "<table border=1 class=Box1 WIDTH=700>";
		print "<Tr><Td class=header>Clan Recall</td></tr>";
		print "<tr><td>";
		if ($HomeRecall == "Y") {
			$sth = mysql_query("update user set X=".$PlayerData->ClanData->HomeX.",Y=".$PlayerData->ClanData->HomeY.",MapID=".$PlayerData->ClanData->HomeMapID." where CoreID=$PlayerData->CoreID");
			print mysql_error();
			$PlayerData->X = $PlayerData->ClanData->HomeX;
			$PlayerData->Y = $PlayerData->ClanData->HomeY;
			$PlayerData->MapID = $PlayerData->ClanData->HomeMapID;
			print "<b>Notice:</B> You have recalled home.<P>";
		} 

		print "The clan which you belong to has selected a recall point. If you would like to recall to the clan city click on the button below.";
		print "</td></tr><tr><td class=footer>";
		print "<a href=$SCRIPT_NAME?HomeRecall=Y>Recall Home</A>";
		print "</td></tr>";
		print "</table><p>";
	}
}





// Clan warriors to wage war with other clans
	print "<table border=0 class=Box1 width=700>";
	print "<tr><td class=Header colspan=5>Warrior Groupings</td></tr>";
	print "<tr><td class=Menu>Name</td><td class=Menu>Count</td><td class=Menu>X</td><td class=Menu>Y</td><td class=Menu>Control</td></tr>";
	
	if ($PlayerData->ClanData->Founder == $PlayerData->CoreID || FlagCheck("G",$PlayerData->ClanFlags)) {
		if ($Control > 0) {
			$sth = mysql_query("select CW.* from clan_warriors as CW left join user as U on U.WID=CW.WID where CW.ClanID=$PlayerData->ClanID and U.CoreID is NOT NULL and CW.WID=$Control");
			print mysql_error();
			if (mysql_num_rows($sth) == 0) {
				$PlayerData->AdjustValue("WID",$Control);
			}
		}
		if ($Release > 0) {
			$sth = mysql_query("select CW.* from clan_warriors as CW left join user as U on U.WID=CW.WID where CW.ClanID=$PlayerData->ClanID and U.CoreID=$PlayerData->CoreID and CW.WID=$PlayerData->WID");
			print mysql_error();
			if (mysql_num_rows($sth) > 0) {
				$PlayerData->AdjustValue("WID","0");
			}
		}
	}
	
	$sth = mysql_query("select CW.*,W.Name,U.Username from clan_warriors as CW left join warriors as W on W.WarriorID=CW.WarriorID left join user as U on U.WID=CW.WID where CW.ClanID=$PlayerData->ClanID");
	print mysql_error();
	while ($WData = mysql_fetch_array($sth)) {
		print "<tr><td>$WData[Name]</TD><TD>$WData[Amount]</TD><TD>$WData[X]</TD><TD>$WData[Y]</TD><TD>";
		if ($PlayerData->ClanData->Founder == $PlayerData->CoreID || FlagCheck("G",$PlayerData->ClanFlags)) {
			if ($WData[Username] == "") {
				if ($PlayerData->WID == 0) {
					print "<A HREF=$SCRIPT_NAME?Control=$WData[WID]>Take Control</A>";
				} else {
					print "&nbsp;";
				}
			} else {
				if ($PlayerData->Username == $WData[Username]) {
					print "<A HREF=$SCRIPT_NAME?Release=$WData[WID]>Release Control</A>";
				} else {
					print $WData[Username];
				}
			}
		} else {
			print $WData[Username]."&nbsp;";			
		}
		print "</TD></tr>";
	}
	print "</td></tr>";
	print "</table><p>";

#}


function PrintToggle($Toggle,$UData) {
	global $PlayerData;
	if (FlagCheck("A",$PlayerData->ClanFlags) == 1 || $PlayerData->ClanData->Founder == $PlayerData->CoreID) {
		if (FlagCheck($Toggle,$UData[ClanFlags]) == 1) {
			print "<A HREF=$SCRIPT_NAME?Toggle=$Toggle&User=$UData[CoreID]&State=Off><IMG border=0 SRC=./images/toggle_on.gif></A>";
		} else {
			print "<A HREF=$SCRIPT_NAME?Toggle=$Toggle&User=$UData[CoreID]&State=On><IMG border=0 SRC=./images/toggle_off.gif></A>";
		}
	} else {
		if (FlagCheck($Toggle,$UData[ClanFlags]) == 1) {
			print "<IMG border=0 SRC=./images/toggle_on.gif>";
		} else {
			print "<IMG border=0 SRC=./images/toggle_off.gif>";
		}
	}

}



?>