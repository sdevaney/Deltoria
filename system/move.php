<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Player movement
global $db,$CoreUserData,$SCRIPT_NAME,$PlayerData;
// If player in battle cant move
$BattleStatus = Check_Battle($PlayerData);

        if ($PlayerData->WID == 0) {
                $Player_UserPic = $PlayerData->UserPic;
                $Player_X = $PlayerData->X;
                $Player_Y = $PlayerData->Y;
                $Player_MapID = $PlayerData->MapID;
		$Player_Turns = $PlayerData->Turns;
        } else {
                $sth = mysql_query("select X,Y,MapID,Image,CW.Turns from clan_warriors as CW left join warriors as W on W.WarriorID=CW.WarriorID left join tiledata as TD on W.TileID=TD.TileID where WID=$PlayerData->WID and ClanID=$PlayerData->ClanID");
                 if (mysql_num_rows($sth) == 0) {
                        $Player_UserPic = $PlayerData->UserPic;
                        $Player_X = $PlayerData->X;
                        $Player_Y = $PlayerData->Y;
                        $Player_MapID = $PlayerData->MapID;
                        $PlayerData->AdjustValue("WID",0);
			$Player_Turns = $PlayerData->Turns;
                } else {
                        $WData = mysql_fetch_array($sth);

                        $Player_UserPic = "../tiles/".$WData[Image];
                        $Player_X = $WData[X];
                        $Player_Y = $WData[Y];
                        $Player_MapID = $WData[MapID];
			$Player_Turns = $WData[Turns];
                }

        }



// Use portal to go to different map
if ($UsePortal > 0 && $BattleStatus == 0 && $PlayerData->WID == 0) {
        $sth = mysql_query("select * from portals where PortalID=$UsePortal");
        print mysql_error();
	
        if (mysql_num_rows($sth) > 0) {
   	            $data = mysql_fetch_array($sth);
				$sth = mysql_query("select * from map where PortalID=$UsePortal and X=$Player_X and Y=$Player_Y and MapID=$Player_MapID");
				if (mysql_num_rows($sth) == 0) {
					print "Error: Invalid Portal<BR>";
				} else {
					if ($data[Level] <= $PlayerData->Level || ($data[Subscriber] == "Y" && $PlayerData->Subscriber != "Y")) {			
						print "You've been teleported by the $data[Name] portal!<BR>";
						$Player_X = $data[TargetX];
						$Player_Y = $data[TargetY];
						$Player_MapID = $data[TargetMapID];
						if ($PlayerData->WID == 0) {
							$sth = mysql_query("update user set Portal_X=$Player_X,Portal_Y=$Player_Y,Portal_MapID=$Player_MapID,X=$Player_X,Y=$Player_Y,MapID=$Player_MapID where CoreID=$PlayerData->CoreID");
							print mysql_error();
							$PlayerData->X = $Player_X;
							$PlayerData->Y = $Player_Y;
							$PlayerData->MapID = $Player_MapID;
						}
					} else {
						print "You are a cheater! Back to the beginning with you!";
						$Dest_X = 311;
						$Dest_Y = 295;
						$Dest_MapID = 23;
						$PlayerData->X = $Dest_X;
						$PlayerData->Y = $Dest_Y;
						$PlayerData->MapID = $Dest_MapID;
						$sth_up = mysql_query("update user set X=$Dest_X, Y=$Dest_Y, MapID=$Dest_MapID, Portal_X=$Dest_X, Portal_Y=$Dest_Y, Portal_MapID=$Dest_MapID, Tie_X=$Dest_X, Tie_Y=$Dest_Y, Tie_MapID=$Dest_MapID where CoreID=".$PlayerData->CoreID);

					}	
				}
		} else {
				print "Error: Invalid Portal<BR>";
      	}
	
}
// Moving YAY
if ($MoveX != "" && $MoveY != "" && $BattleStatus == 0 && $Player_Turns > 0) {
	if (abs($MoveX - $Player_X) > 1 || abs($MoveY - $Player_Y) > 1) {
		print "Error: That move is invalid - Too Far<BR>";
	} elseif (abs($MoveX - $Player_X) == 0 && abs($MoveY - $Player_Y) == 0) {
		print "Notice: Instead of refreshing the page with the refresh button please use the refresh link in the chat window.<BR>";
	} else {
			$sth = mysql_query("select td.Walkable from overlay as m left join tiledata as td on td.TileID=m.TileID where m.X=$MoveX and m.Y=$MoveY and m.MapID=$Player_MapID and td.Walkable='N'");
			if (mysql_num_rows($sth) > 0) {
				$Walkable = "N";
			} else {
				$Walkable = "Y";
			}

			$sth = mysql_query("select td.Walkable from map as m left join tiledata as td on td.TileID=m.TileID where m.X=$MoveX and m.Y=$MoveY and m.MapID=$Player_MapID and td.Walkable='N'");
			print mysql_error();
			if (mysql_num_rows($sth) > 0) {
				$Walkable = "N";
			}

			$sth = mysql_query("select * from overlay_clan where ClanID != $PlayerData->ClanID and X=$Player_X and Y=$Player_Y and MapID=$Player_MapID");
			if (mysql_num_rows($sth) > 0) {
				$sth = mysql_query("select * from overlay_clan where ClanID != $PlayerData->ClanID and X=$MoveX and Y=$MoveY and MapID=$Player_MapID");
				if (mysql_num_rows($sth) > 0) {
					print "You must destroy this land block before moving deeper!<BR>";
					$Walkable = "N";
				}			
			}
			// Makes sure tile is set to walkable if not cant move there
			if ($Walkable == "Y" || $PlayerData->Access >= 10) {
				if ($PlayerData->WID == 0) {
					$PlayerData->AdjustValue("Turns",($PlayerData->Turns-1));
					$Player_Turns = $Player_Turns - 1;
				} else {
					$sth = mysql_query("update clan_warriors set Turns=Turns - 1 where Turns > 0 and WID=$PlayerData->WID");
					$Player_Turns = $Player_Turns - 1;
				}
				$Player_X = $MoveX;
				$Player_Y = $MoveY;

				$sth = mysql_query("select TileID,Danger,ModCode from map where X=$MoveX and Y=$MoveY and MapID=$Player_MapID");
				list($TileID,$Danger,$ModCode) = mysql_fetch_row($sth);	
				// if ($ModCode != "") { eval($ModCode); }

				if ($TileID > 0) {
					$sth = mysql_query("select ModCode from tiledata where TileID=$TileID");
					list($ModCode) = mysql_fetch_row($sth);
					if ($ModCode != "") { eval($ModCode); }
				}
// Movement of clan warriors
				$sth = mysql_query("select * from overlay_clan where ClanID=$PlayerData->ClanID and X=$MoveX and Y=$MoveY and MapID=$Player_MapID");
				if (mysql_num_rows($sth) == 1) { $Danger = 0; }				
				
				if ($PlayerData->WID == 0) {
					$PlayerData->X = $MoveX;
					$PlayerData->Y = $MoveY;
					$sth = mysql_query("update user set X=$MoveX,Y=$MoveY where CoreID=$PlayerData->CoreID");
					print mysql_error();
				} else {
					$sth = mysql_query("update clan_warriors set X=$MoveX,Y=$MoveY where WID=$PlayerData->WID");
				}
// Admin movement stealth is no monsters, attract is 100% danger all the time.
$sth2 = mysql_query("select Admin,Stealth,StealthDate,Attract,AttractDate from user where CoreID = $PlayerData->CoreID");
$UData2 = mysql_fetch_array($sth2);
if($UData2[Admin] == "Y" && $UData2[Stealth] == "Y") {
	$Danger = 0;
} elseif($UDdata2[StealthDate] > date('Y-m-d') && $UData2[Stealth] == "Y") {
	$Danger = $Danger - 10;
	if ($Danger < 0) {
		$Danger = 0;
	}
}

if($UData2[Admin] == "Y" && $UData2[Attract] == "Y") {
        $Danger = 100;
} elseif($UDdata2[AttractDate] > date('Y-m-d') && $UData2[Attract] == "Y") {
        $Danger = $Danger + 10;
        if ($Danger > 100) {
                $Danger = 100;
        }
}

$Attack = rand(1,100);
if ($Attack < $Danger && $PlayerData->WID == 0) {
$sth = mysql_query("select * from monster where X=$MoveX and Y=$MoveY and MapID=$Player_MapID");
print mysql_error();
if (mysql_num_rows($sth) == 0) {
// We need to clear out any battle_info from previous battles that haven't been cleaned up yet.
$sth = mysql_query("select * from battle_info where X=$Player_X and Y=$Player_Y and MapID=$Player_MapID");
if (mysql_num_rows($sth) > 0) {
$sth = mysql_query("delete from battle_info where X=$Player_X and Y=$Player_Y and MapID=$Player_MapID");
}

$sth = mysql_query("select GD.MaxSpawn,M.GroupID,abs(X-$Player_X)+abs(Y-$Player_Y) as Distance from map as M left join monster_groupdata 
as GD on GD.GroupID=M.GroupID where abs(X-$Player_X)+abs(Y-$Player_Y) and MapID=$Player_MapID and M.GroupID > 0 and Hostile = 'Y' order by 
Distance limit 1");

print mysql_error();
if (mysql_num_rows($sth) > 0) {
list($MaxSpawn,$GroupID,$Distance) = mysql_fetch_row($sth);
for ($CurMon = 0; $CurMon < rand(1,$MaxSpawn); $CurMon++) {

$sth_mon = mysql_query("select M.MonsterID,M.BaseHealth,M.Name from monster_groups as MG left join monster_base as M on M.MonsterID=MG.MonsterID 
where M.Hostile='Y' and MG.GroupID=$GroupID order by rand() limit 1");

print mysql_error();
if (mysql_num_rows($sth_mon) > 0 && $GroupID > 0) {
list($MonsterID,$BaseHealth,$MonName) = mysql_fetch_row($sth_mon);
$sth_ins = mysql_query("insert into monster values (0,$MonsterID,0,NOW(),$BaseHealth,$Player_X,$Player_Y,$Player_MapID,'',NOW(),NOW(),0,NOW())");
print mysql_error();
$sth_ins = mysql_query("insert into battle_info (BattleText,X,Y,MapID) values ('',$Player_X,$Player_Y,$Player_MapID)");
print mysql_error();
}
}
}
					}
				}
			} else {
					print "Error: That move is not allowed<BR>";
			}
	}
}
?>