<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2009 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Navigation screen info
global $db,$CoreUserData,$SCRIPT_NAME,$PlayerData;
#PlayerInfo(14120);

$BattleStatus = Check_Battle($PlayerData);

$tiledir = "./images/tiles";
// if ($PlayerData->Username == "RazM") $tiledir = "c:/tiles";
if ($BattleStatus == 0) {

	if ($PlayerData->WID > 0) {
		$sth = mysql_query("select * from clan_warriors where ClanID=$PlayerData->ClanID and WID=$PlayerData->WID");
		if (mysql_num_rows($sth) == 0) {
			$PlayerData->WID = 0;
		}
	}

	if ($PlayerData->WID == 0) {
	        $Player_UserPic = $PlayerData->UserPic;
	        $Player_X = $PlayerData->X;
	        $Player_Y = $PlayerData->Y;
	        $Player_MapID = $PlayerData->MapID;
		$Player_Turns = $PlayerData->Turns;
	} else {
	        $sth = mysql_query("select CW.X,CW.Y,CW.MapID,TD.Image,C.Name as ClanName,W.Name,CW.Amount,CW.Turns from clan_warriors as CW left join clans as C on C.ClanID=CW.ClanID left join warriors as W on W.WarriorID=CW.WarriorID left join tiledata as TD on W.TileID=TD.TileID where WID=$PlayerData->WID and CW.ClanID=$PlayerData->ClanID");
		print mysql_error();
		if (mysql_num_rows($sth) == 0) {
	                $Player_UserPic = $PlayerData->UserPic;
	                $Player_X = $PlayerData->X;
	                $Player_Y = $PlayerData->Y;
	                $Player_MapID = $PlayerData->MapID;
			$Player_Turns = $PlayerData->Turns;
	                $PlayerData->AdjustValue("WID",0);
	        } else {
			$WData = mysql_fetch_array($sth);

	                $Player_UserPic = $tiledir."/".$WData[Image];
	                $Player_X = $WData[X];
	                $Player_Y = $WData[Y];
	                $Player_MapID = $WData[MapID];
			$Player_Turns = $WData[Turns];
		}

	}




?>
	<script language="JScript">
	<!--
	function document.onkeyup() {
	{
	 if (event)
	  if (event.srcElement.tagName != "INPUT")
	  with(event)
	   if(37==keyCode||100==keyCode)
		document.location = "start.php?RD=<? print rand(1,9999999);?>&MoveX=<?=$Player_X-1?>&MoveY=<?=$Player_Y?>&WID=<?=intval($PlayerData->WID);?>";
	   else if(101==keyCode)
		document.location = "start.php?RD=<? print rand(1,999999);?>";
	   else if(38==keyCode||104==keyCode)
		document.location = "start.php?RD=<? print rand(1,9999999);?>&MoveX=<?=$Player_X?>&MoveY=<?=$Player_Y-1?>&WID=<?=intval($PlayerData->WID);?>";
	   else if(39==keyCode||102==keyCode)
		document.location = "start.php?RD=<? print rand(1,9999999);?>&MoveX=<?=$Player_X+1?>&MoveY=<?=$Player_Y?>&WID=<?=intval($PlayerData->WID);?>";
	   else if(40==keyCode||98==keyCode)
		document.location = "start.php?RD=<? print rand(1,9999999);?>&MoveX=<?=$Player_X?>&MoveY=<?=$Player_Y+1?>&WID=<?=intval($PlayerData->WID);?>";
	   else if(103==keyCode)
		document.location = "start.php?RD=<? print rand(1,9999999);?>&MoveX=<?=$Player_X-1?>&MoveY=<?=$Player_Y-1?>&WID=<?=intval($PlayerData->WID);?>";
	   else if(105==keyCode)
		document.location = "start.php?RD=<? print rand(1,9999999);?>&MoveX=<?=$Player_X+1?>&MoveY=<?=$Player_Y-1?>&WID=<?=intval($PlayerData->WID);?>";
	   else if(97==keyCode)
		document.location = "start.php?RD=<? print rand(1,9999999);?>&MoveX=<?=$Player_X-1?>&MoveY=<?=$Player_Y+1?>&WID=<?=intval($PlayerData->WID);?>";
	   else if(99==keyCode)
		document.location = "start.php?RD=<? print rand(1,9999999);?>&MoveX=<?=$Player_X+1?>&MoveY=<?=$Player_Y+1?>&WID=<?=intval($PlayerData->WID);?>";
	  }
	}
	//-->
	</script>
	<?
}

$sth = mysql_query("select M.*,T.Image from map as M left join tiledata as T on T.TileID=M.TileID where M.X=$Player_X and M.Y=$Player_Y and M.MapID=$Player_MapID");
print mysql_error();
$mapdata = mysql_fetch_array($sth);

if ($mapdata[ModCode] != "") {
	eval($mapdata[ModCode]);
}

print "<table border=0 class=Box1>";





// If player knows portal tie skill they can tie to a portal
if ($PlayerData->GetSkillLevelByName("Portal Tie") > 0  && $TiePortal != "" && $PlayerData->WID == 0) {
	if ($mapdata[PortalID] == $TiePortal) { 
		$sth = mysql_query("select TargetX,TargetY,TargetMapID from portals where PortalID=$TiePortal");
		print mysql_error();
		if (mysql_num_rows($sth) > 0) {
			$PData = mysql_fetch_array($sth);
			print "<tr><td colspan=6 class=header>You've tied to this portal.</td></tr>";
			$sth = mysql_query("update user set Tie_X=$PData[TargetX],Tie_Y=$PData[TargetY],Tie_MapID=$PData[TargetMapID] where CoreID=$PlayerData->CoreID");
			print mysql_error();
		} else {
			print "<tr><td colspan=6 class=header>Unable to locate this portal</td></tr>";
		}
	} else {
		print "<tr><td colspan=4>Unable to locate this portal</td></tr>";
	}
}


$sth = mysql_query("select * from overlay_clan where ClanID=$PlayerData->ClanID and X=$Player_X and Y=$Player_Y and MapID=$Player_MapID");
print mysql_error();
if (mysql_num_rows($sth) == 1) { $mapdata[Danger] = 0; }

if ($mapdata[PortalID] > 0) {
	$sth = mysql_query("select * from portals where PortalID=$mapdata[PortalID]");
	$PortalData = mysql_fetch_array($sth);
	print "<tr><td colspan=4 class=Menu>";
	if ($PortalData[Subscriber] == "Y" && $PlayerData->Subscriber != "Y") {
			print "$PortalData[Name]<BR>(Subscribers Only)";
	} else {
		if ($PortalData[Level] > $PlayerData->Level) {
			print "$PortalData[Name]<BR>(Level $PortalData[Level] Requirement)";
		} else {
			print "<A HREF=$SCRIPT_NAME?UsePortal=$PortalData[PortalID]>$PortalData[Name]</A> ";
			if ($PlayerData->GetSkillLevelByName("Portal Tie") > 0) {
				print "( <A HREF=$SCRIPT_NAME?TiePortal=$PortalData[PortalID]>Tie</A> )";
			}
		}
	}
	Help("Portals","Portals allow an adventurer to travel from place to place quickly. The destination can be anything, it can be a town, a dungeon, or the outdoors somewhere.<P>It is suggested never to blindly jump into a portal unless you know what is on the other side.");
} else {
	print "<tr><td colspan=4 class=Header>";
}
print $mapdata[Name];
print "</td><td colspan=2 class=Menu>Loc: $Player_X,$Player_Y</td>";
print"</tr>";

print "<tr>";
print "<td class=pageCell align=center>Health</td><td class=PageCell align=center>$PlayerData->HealthCur/$PlayerData->HealthMax</td>";

$sth = mysql_query("select XP from level_curve where Level=".($PlayerData->Level));
list($XPBottom) = mysql_fetch_row($sth);

$sth = mysql_query("select XP from level_curve where Level=".($PlayerData->Level+1));
list($XPTop) = mysql_fetch_row($sth);

$LevelXP = $XPTop - $XPBottom;

$CurXP = $XPBottom-$PlayerData->XP;
$NeededXP = $XPTop - $PlayerData->XP;


$CurXP = $PlayerData->XP - $XPBottom;
$XPTop = $XPTop - $XPBottom;


// Generate health and xp bar
print "<td class=pageCell align=center colspan=2>To level ".($PlayerData->Level+1)."</td>";
print "<td class=pageCell align=center>Mana</td><td class=PageCell align=center>".$PlayerData->ManaCur."/".$PlayerData->ManaMax."</td>";
print "</tr>";
print "<tr><td colspan=2 class=PageCell>";
GenBar_Lite($PlayerData->HealthCur,$PlayerData->HealthMax,100,"health");
print "</td><td colspan=2 class=PageCell>";

GenBar_Lite($CurXP,$XPTop,100,"health");

#GenBar_Lite($NeededXP,$LevelXP,100,"health");

print "</td><td colspan=2 class=PageCell>";
GenBar_Lite($PlayerData->ManaCur,$PlayerData->ManaMax,100,"mana");
print "</td></tr>";

print "<tr><td colspan=6>";
print "<table border=0 class=pageContainer cellpadding=0 cellspacing=0>";

$MinX = $Player_X - 5;
$MaxX = $Player_X + 5;

$MinY = $Player_Y - 5;
$MaxY = $Player_Y + 5;
// Show stuff on nav screen
$sth = mysql_query("select T.Image,M.* from map as M left join tiledata as T on M.TileID=T.TileID where M.X >= $MinX and M.X <= $MaxX and M.Y >= $MinY and M.Y <= $MaxY and M.MapID=$Player_MapID");
print mysql_error();
while ($MData = mysql_fetch_array($sth)) {
	$MapX = $MData[X];
	$MapY = $MData[Y];
	$MData[Image] = str_replace("\\","/",$MData[Image]);
	$MapData[$MapX][$MapY][Image] = $MData[Image];
	$MapData[$MapX][$MapY][ClanID] = "";
	$MapData[$MapX][$MapY][Clan_Image] = "";
	$MapData[$MapX][$MapY][Warrior_Image] = "";
	$MapData[$MapX][$MapY][Corpse] = "";
	$MapData[$MapX][$MapY][Warrior_Clan] = "";
	$MapData[$MapX][$MapY][Warrior_Name] = "";
	$MapData[$MapX][$MapY][Warrior_Amount] = 0;
	$MapData[$MapX][$MapY][Walkable] = $MData[Walkable];
	$MapData[$MapX][$MapY][Fort] = "";
	$MapData[$MapX][$MapY][UName] = "";
	$MapData[$MapX][$MapY][UPic] = "";
	$MapData[$MapX][$MapY][Building_Image] = "";
	$MapData[$MapX][$MapY][CoreID] = "";
	$MapData[$MapX][$MapY][MOBImage] = "";
	$MapData[$MapX][$MapY][MOBName] = "";
	$MapData[$MapX][$MapY][Portal] = $MData[PortalID];
	$MapData[$MapX][$MapY][Portal] = "";
	$MapData[$MapX][$MapY][Stealth] = "";
	$MapData[$MapX][$MapY][Description] = "";
}

$sth = mysql_query("select CW.*,TD.Image,W.Name,C.Name as ClanName from clan_warriors as CW left join warriors as W on W.WarriorID=CW.WarriorID left join tiledata as TD on W.TileID=TD.TileID left join clans as C on C.ClanID=CW.ClanID where CW.X >= $MinX and CW.X <= $MaxX and CW.Y >= $MinY and CW.Y <= $MaxY and CW.MapID=$Player_MapID");
print mysql_error();
while ($WData = mysql_fetch_array($sth)) {
	$MapX = $WData[X];
	$MapY = $WData[Y];
	$MapData[$MapX][$MapY][Warrior_Image] = $WData[Image];
	$MapData[$MapX][$MapY][Warrior_Clan] = $WData[ClanName];
	$MapData[$MapX][$MapY][Warrior_Name] = $WData[Name];
	$MapData[$MapX][$MapY][Warrior_Amount] = $WData[Amount];
}

$sth = mysql_query("select T.Image,M.* from overlay_clan as M left join tiledata as T on M.TileID=T.TileID where M.X >= $MinX and M.X <= $MaxX and M.Y >= $MinY and M.Y <= $MaxY and M.MapID=$Player_MapID");
print mysql_error();
while ($MData = mysql_fetch_array($sth)) {
	$MapX = $MData[X];
	$MapY = $MData[Y];
	if ($MData[Walkable] == "N") { $MapData[$MapX][$MapY][Walkable] = "N"; }
	$MapData[$MapX][$MapY][Clan_Image] = $MData[Image];
	$MapData[$MapX][$MapY][ClanID] = intval($MData[ClanID]);
	if (($MData[TileID] == "1" || $MData[TileID] == "0") && $MData[ClanID] > 0) {
		if ($MapData[$MapX][$MapY][ClanID] == $PlayerData->ClanID) {
			$MapData[$MapX][$MapY][Clan_Image] = "clan_good.gif";
		} else {
			$MapData[$MapX][$MapY][Clan_Image] = "clan_bad.gif";
		}
	}
}





$sth = mysql_query("select T.Image,CB.*,B.Name from clan_buildings as CB left join buildings as B on B.BID=CB.BID left join tiledata as T on T.TileID=B.TileID where CB.X >= $MinX and CB.X <= $MaxX and CB.Y >= $MinY and CB.Y <= $MaxY and CB.MapID=$Player_MapID");
print mysql_error();
while ($MData = mysql_fetch_array($sth)) {
	$MapX = $MData[X];
	$MapY = $MData[Y];
	$MapData[$MapX][$MapY][Building_Image] = $MData[Image];
}



$sth = mysql_query("select CoreID,Username,X,Y,UserPic from user where X >= $MinX and X <= $MaxX and Y >= $MinY and Y <= $MaxY and MapID=$Player_MapID and CoreID != $PlayerData->CoreID and LastAccessed > DATE_SUB(NOW(),INTERVAL 10 MINUTE)");
print mysql_error();
while ($UData = mysql_fetch_array($sth)) {
	$MapX = $UData[X];
	$MapY = $UData[Y];
	if ($MapData[$MapX][$MapY][UName] == "") {
		if ($MapData[$MapX][$MapY][UPic] == "") { $MapData[$MapX][$MapY][UPic] = $UData[UserPic]; $MapData[$MapX][$MapY][CoreID] = $UData[CoreID]; }
	}
}

$sth = mysql_query("select B.Name,T.Image,M.X,M.Y from monster as M left join monster_base as B on B.MonsterID=M.MonsterID left join tiledata as T on T.TileID=B.TileID where X >= $MinX and X <= $MaxX and Y >= $MinY and Y <= $MaxY and M.MapID=$Player_MapID and B.Hostile='N'");
print mysql_error();
while ($MData = mysql_fetch_array($sth)) {		
	$MapX = $MData[X];
	$MapY = $MData[Y];
	$MapData[$MapX][$MapY][MOBImage] = $MData[Image];
	$MapData[$MapX][$MapY][MOBName] = $MData[Name];
}

$sth = mysql_query("select U.Username,C.X,C.Y,C.MapID from overlay_corpse as C left join user as U on U.CoreID=C.CoreID where C.X >= $MinX and C.X <= $MaxX and C.Y >= $MinY and C.Y <= $MaxY and C.MapID=$Player_MapID");
print mysql_error();
while ($MData = mysql_fetch_array($sth)) {		
	$MapX = $MData[X];
	$MapY = $MData[Y];
	$MapData[$MapX][$MapY][Corpse] = "Y";
	$MapData[$MapX][$MapY][MOBImage] = "corpse.gif";
	$MapData[$MapX][$MapY][MOBName] = $MData[Username];
}



for ($MapY = -5; $MapY <= 5; $MapY++) {
	print "<tr>";
	for ($MapX = -5; $MapX <= 5; $MapX++) {
		$CurX = $Player_X + $MapX;
		$CurY = $Player_Y + $MapY;
// If in battle show battle suprise screen
		if ($MapX == -5 && $MapY == 0 && $BattleStatus == 1) {
			$sth = mysql_query("select MB.Name,TD.Image from monster as M left join monster_base as MB on MB.MonsterID=M.MonsterID left join tiledata as TD on TD.TileID=MB.TileID where M.X = $Player_X and M.Y=$Player_Y and M.MapID=$Player_MapID and MB.Hostile='Y'");
			$NumMon = mysql_num_rows($sth);
			$MonsterData = mysql_fetch_array($sth);
			print "<TD COLSPAN=1 HEIGHT=30><IMG SRC='$tiledir/$MonsterData[Image]'></TD>";
			print "<TD COLSPAN=9 VALIGN=TOP ALIGN=CENTER>";
			print "You're surprised by a $MonsterData[Name]";
			if ($NumMon > 1) { 
				print "<BR>";
				print " and ".($NumMon - 1)." others"; 
			}
			print "!<BR> To go to the battle screen click <A HREF=battle.php?RD=".rand(1,99999).">here</A>";
			print "</TD>";
			print "<TD COLSPAN=1 HEIGHT=30><IMG SRC='$tiledir/$MonsterData[Image]'></TD>";
			$MapX = $MapX + 10;
			continue;
		} else {
			if ($MapData[$CurX][$CurY] == "") {
				$sth = mysql_query("select Image from mapid_background where MapID=$Player_MapID");
				if (mysql_num_rows($sth) == 0) {
					$MapData[$CurX][$CurY][Image] = "dungeon_wall_top.jpg";
				} else {
					list($MapData[$CurX][$CurY][Image]) = mysql_fetch_row($sth);
				}
				$data[Walkable] = "N";
				$MapData[$MapX][$MapY][Walkable] = "N";
			}


			if ($MapX == 0 && $MapY == 0) {
				print "<td width=30 height=30 class=pageCell align=center background='$tiledir/".$MapData[$CurX][$CurY][Image]."' onClick=\"document.location='$SCRIPT_NAME?RD=".rand(1,1000000)."'\";>";

				print "<img src=./images/chars/$Player_UserPic>";

			} elseif ($MapX >= -1 && $MapX <= 1 && $MapY >= -1 && $MapY <= 1) {
				print "<td height=30 width=30 class=pageCell align=center background='$tiledir/".$MapData[$CurX][$CurY][Image]."' onClick=\"document.location='$SCRIPT_NAME?RD=".rand(1,1000000)."&MoveX=".($Player_X + $MapX)."&MoveY=".($Player_Y + $MapY)."&WID=".intval($PlayerData->WID)."'\";>";
			} else {
				print "<td height=30 width=30 class=pageCell align=center background='$tiledir/".$MapData[$CurX][$CurY][Image]."'>";
			}

			if ($MapX != 0 || $MapY != 0) {
				if ($MapData[$CurX][$CurY][Warrior_Image] != "") {
					Popup_Pic($MapData[$CurX][$CurY][Warrior_Name],"Owned by ".$MapData[$CurX][$CurY][Warrior_Clan]."<BR>You see ".$MapData[$CurX][$CurY][Warrior_Amount]." of them","$tiledir/".$MapData[$CurX][$CurY][Warrior_Image]);
					#print "<img src='$tiledir/".$MapData[$CurX][$CurY][MOBImage]."' HEIGHT=30 WIDTH=30>";
				} elseif ($MapData[$CurX][$CurY][Corpse] != "") {
					Popup_Pic("Corpse",$MapData[$CurX][$CurY][MOBName],"$tiledir/".$MapData[$CurX][$CurY][MOBImage]);
				} elseif ($MapData[$CurX][$CurY][MOBImage] != "") {
					Popup_Pic("NPC",$MapData[$CurX][$CurY][MOBName],"$tiledir/".$MapData[$CurX][$CurY][MOBImage]);
				} elseif ($MapData[$CurX][$CurY][Building_Image] != "") {
					print "<IMG SRC='$tiledir/".$MapData[$CurX][$CurY][Building_Image]."'>";
				} elseif ($MapData[$CurX][$CurY][UPic] != "") {
					PlayerInfo($MapData[$CurX][$CurY][CoreID],$MapData[$CurX][$CurY][UPic]);
				} elseif ($MapData[$CurX][$CurY][ClanID] > 0) {
					print "<IMG SRC='$tiledir/".$MapData[$CurX][$CurY][Clan_Image]."'>";
				} else {
					print "&nbsp;";
				}
			}
			print "</td>";
		}
	}
	print "</tr>";
}
print "</table></td></tr>";

print "<tr>";
print "<td class=pageCell align=center>Move</td><td class=PageCell align=center>".number_format($Player_Turns)."</td>";
print "<td class=pageCell align=center>Action</td><td class=PageCell align=center>".number_format($PlayerData->Actions)."</td>";
print "<td class=pageCell align=center>Danger</td><td class=PageCell align=center>".number_format($mapdata[Danger])."%</td>";
print "</tr>";
print "<tr><td colspan=2 class=PageCell>";
GenBar_Lite($Player_Turns,2000,100,"health");
print "</td><td colspan=2 class=PageCell>";
GenBar_Lite($PlayerData->Actions,500,100,"health");
print "</td><td colspan=2 class=PageCell>";
GenBar_Lite($mapdata[Danger],100,100,"health");
print "</td>";
print "</tr>";

print "<tr>";
print "</table>";

?>