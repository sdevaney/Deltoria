<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
global $db,$CoreUserData,$PlayerData,$Skills,$BNote,$CurNote;

$BNote = "N";

mt_srand(make_seed());

$BattleActions = 20;

// Gather the battle information.
$sth = mysql_query("select BU.ItemUses,BU.Flee,BI.* from battle_info as BI left join battle_user as BU on BU.BattleID=BI.BattleID and BU.CoreID=$PlayerData->CoreID where BI.X=$PlayerData->X and BI.Y=$PlayerData->Y and BI.MapID=$PlayerData->MapID");
if (mysql_num_rows($sth) == 0) {
	$sth = mysql_query("select * from monster where HealthCur > 0 and X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID");
	if (mysql_num_rows($sth) == 0) {
		print "No Battle Data Found (And no targets located)<P>[ <A HREF=start.php?RD=".rand(1,1000000)." class=sidelink>Return to Nav</A> ]";
		print "</td></tr></table>";
		include ("./system/bottom.php");
		exit;
	} else {
		$sth = mysql_query("insert into battle_info (X,Y,MapID,Active,BattleText,ActionDate) values ($PlayerData->X,$PlayerData->Y,$PlayerData->MapID,'Yes','',NOW())");
		print mysql_error();
	}
} else {
	$BattleInfo = mysql_fetch_array($sth);
	if ($BattleInfo[ItemUses] == "") {
		$sth = mysql_query("insert into battle_user (BattleID,CoreID) values ($BattleInfo[BattleID],$PlayerData->CoreID)");
		print mysql_error();
		$BattleInfo[ItemUses] = 20;
		$BattleInfo[Flee] = "No";
	}
}

// Gather TargetData information
if ($TargetID > 0) {
	$TargetData = GetMonsterInformation($TargetID);
}


// Use Potion
if ($Drink != "" && $BattleInfo[ItemUses] > 0) 
{
	$sth = mysql_query("select ib.MultiStep,ib.Defined_LevelReq, ib.Subscriber, Name,ObjectID from items as i left join items_base as ib on ib.ItemID=i.ItemID where i.CoreID=$PlayerData->CoreID and (Battle_Use='Y') and ib.ItemID=$Drink limit 1");
	list ($MultiStep,$ILevel,$Subitem,$UseName,$UseObj) = mysql_fetch_row($sth);
	if ($Subitem == 'N' || $PlayerData->Subscriber == 'Y') {
		$Allow = 'Y';
	} else {
		$Allow = 'N';
	}
	if($ILevel <= $PlayerData->Level && $Allow == 'Y')
	{
		$sth = mysql_query("select * from battle_user where BattleID=$BattleInfo[BattleID] and CoreID=$PlayerData->CoreID");
		if (mysql_num_rows($sth) == 0) 
		{
			$sth = mysql_query("insert into battle_user (CoreID,BattleID,ItemUses,ActionDate) values ($PlayerData->CoreID,$BattleInfo[BattleID],19,NOW())");
		} 
		else 
		{
			$sth = mysql_query("update battle_user set ItemUses=ItemUses-1 where BattleID=$BattleInfo[BattleID] and CoreID=$PlayerData->CoreID and ItemUses >= 1");
		}
		print mysql_error();

		BattleNote($BattleInfo[BattleID],"<img src=./images/battle/action.jpg>$PlayerData->Username uses a $UseName<br>");
		$BattleInfo[ItemUses]--;

		$sth = mysql_query("select IB.MultiStep,I.*,IB.Name,IB.Stackable,IB.Use_Effect from items as I left join items_base as IB on IB.ItemID=I.ItemID where I.ObjectID=$UseObj and I.CoreID=$PlayerData->CoreID and I.Banked='N'");
		print mysql_error();
		if (mysql_num_rows($sth) > 0) 
		{
			$data = mysql_fetch_array($sth);
			eval($data[Use_Effect]);
			if ($data[MultiStep] == "N" || ($data[MultiStep] == "Y" && ($StepEnd == "Y" || $EndStep == "Y"))) 
			{
				if ($data[ItemStack] > 1) 
				{
					$sth = mysql_query("update items set ItemStack=ItemStack-1 where ObjectID=$data[ObjectID]");
					print mysql_error();
				} 
				else 
				{
					$sth = mysql_query("delete from items where ObjectID=$data[ObjectID]");	
					print mysql_error();
				}
			}
		}
	}
	else
	{
		print "You are too low level to use that item or you are not a subscriber.";
	}
} 
elseif ($Drink != "" && $BattleInfo[ItemUses] <= 0) 
{
	print "NOTICE: You don't have enough item uses remaining!<BR>";
}

// If we're attacking a user we should see if we're allowed to..
if ($Action == "Attack" && ($TargetData[X] != $PlayerData->X || $TargetData[Y] != $PlayerData->Y || $TargetData[MapID] != $PlayerData->MapID || $TargetData[HealthCur] < 1)) {
	BattleNote($BattleInfo[BattleID],"$PlayerData->Username tried to hit $TargetData[Username] but the target isn't here (or its dead)!<br>");
	ActiveCheck($BattleInfo);
} elseif ($Action == "Attack") {
	sleep(1.5);
        $sth = mysql_query("select PsnRemain, PsnDmg from user where CoreID=$PlayerData->CoreID");
	list($PsnRemain,$PsnDmg) = mysql_fetch_row($sth);

	if ($PsnRemain > 0) {
		$PlayerData->AdjustHealth(-$PsnDmg);
		BattleNote($BattleInfo[BattleID],"<img src=./images/battle/status.jpg>You receive $PsnDmg damage from poison<BR>");
		$PsnRemain=$PsnRemain-1;
		$statrem = mysql_query("update user set PsnRemain = $PsnRemain where CoreID=$PlayerData->CoreID");
		if ($PsnRemain == 0) {
			
			$statrem = mysql_query("update user set PsnDmg = 0 where CoreID=$PlayerData->CoreID");
		}
	}
	list($DamDelt,$DamDiff) = AttackMonster($TargetData);
	if ($DamDelt > $TargetData[HealthCur]) { $DamDelt = $TargetData[HealthCur]; }

	CheckBattleData($BattleInfo);

	// Set Damage.
	$sth = mysql_query("update battle_user set Amount=Amount+$DamDelt where CoreID=$PlayerData->CoreID and BattleID=$BattleInfo[BattleID]");
	print mysql_error();

	// ************************************************
	// Target Unit DIES
	// ************************************************
	if ($DamDelt >= $TargetData[HealthCur]) {
		$DamDelt = $TargetData[HealthCur];
		$TargetData[HealthCur] = 0;
		$sth = mysql_query("select * from user_kills where MonsterID=$TargetData[MonsterID] and CoreID=$PlayerData->CoreID");
		print mysql_error();
		if (mysql_num_rows($sth) == 0) {
			$sth = mysql_query("insert into user_kills (MonsterID,CoreID,Counter) values ($TargetData[MonsterID],$PlayerData->CoreID,1)");
			print mysql_error();
		} else {
			$sth = mysql_query("update user_kills set Counter=Counter+1 where CoreID=$PlayerData->CoreID and MonsterID=$TargetData[MonsterID]");
		}



                        $WeaponID = $PlayerData->GetWeapon();
                        if ($WeaponID == 0) {
                                $WeaponName = "fists";
                        } else {
                                $WeaponName = $PlayerData->Inventory[$WeaponID]->Name;
                        }


		BattleNote($BattleInfo[BattleID],"<img src=./images/battle/action.jpg>$PlayerData->Username pummels $TargetData[Username] to death with a $WeaponName!<br>");

		$sth = mysql_query("select sum(Amount) from battle_user where BattleID=$BattleInfo[BattleID]");
		print mysql_error();
		list ($Total_Amount) = mysql_fetch_row($sth);

		$sth = mysql_query("select U.Subscriber,U.Level,U.CoreID,U.Username,B.Amount from battle_user as B left join user as U on U.CoreID=B.CoreID where B.BattleID=$BattleInfo[BattleID] and B.Amount > 0");
		$Total_Players = mysql_num_rows($sth);
		$Total_Players = (($Total_Players - 1) * 3) / 100;
		while ($DamData = mysql_fetch_array($sth)) {
			$XP_Amount = $TargetData[XP];
			$ringxp = mysql_query("select * from battle_info where BattleID=$BattleInfo[BattleID] and BattleText like '%Minor Ring of Damage%'");
			if(mysql_fetch_row($ringxp) > 0) {
				$XP_Amount = $XP_Amount - ($XP_Amount*.1);
			} 
			$ringxp = mysql_query("select * from battle_info where BattleID=$BattleInfo[BattleID] and BattleText like '%Ring of Damage%' and BattleText not like '%Minor Ring of Damage%'");
			if(mysql_fetch_row($ringxp) > 0) {
				$XP_Amount = $XP_Amount - ($XP_Amount*.15);
			}
			$ringxp = mysql_query("select * from battle_info where BattleID=$BattleInfo[BattleID] and BattleText like '%Minor Ring of Slaying%' and BattleText not like '%Minor Ring of Damage%' and BattleText not like '%Ring of Damage%'");
			if(mysql_fetch_row($ringxp) > 0) {
				$XP_Amount = $XP_Amount - ($XP_Amount*.2);
			}
			// print "DEBUG: You've done ".intval($DamData[Amount] / $Total_Amount)." damage.<BR>";
			$XP_Amount = $XP_Amount * $DamData[Amount] / $Total_Amount + $Total_Players;
			if ($DamData['Subscriber'] == "Y") {
				$XP_Amount = $XP_Amount * 1.1;
				BattleNote($BattleInfo[BattleID],"<img src=./images/battle/action.jpg><B>$DamData[Username] (a subscriber!) is rewarded ".number_format($XP_Amount)." XP</B>! (10% bonus!)<br>");
			} else {
				BattleNote($BattleInfo[BattleID],"<img src=./images/battle/action.jpg><B>$DamData[Username] is rewarded ".number_format($XP_Amount)." XP</B>!<br>");
			}
			GiveXP($DamData[CoreID],$XP_Amount,0);
			$NewLevel = SetLevel($DamData[CoreID]);
			if ($NewLevel > 0) {
				$sth_Update = mysql_query("update battle_info set BattleText=concat(\"<img src=./images/battle/action.jpg>$DamData[Username] has made level $NewLevel!<br>\",BattleText) where BattleID=$BattleInfo[BattleID]");
			}				
		}
		$sth = mysql_query("select max(Amount) from battle_user where BattleID=$BattleInfo[BattleID]");
		list($DamMax_Battle) = mysql_fetch_row($sth);

		$sth = mysql_query("select CoreID from battle_user where BattleID=$BattleInfo[BattleID] and Amount=$DamMax_Battle limit 1");
		list($Killer_CoreID) = mysql_fetch_row($sth);

		// Drop items, flush monster/user.
		$sth = mysql_query("update monster set HealthCur=0,DecayTime=DATE_ADD(NOW(),INTERVAL 2 MINUTE),SpawnTime=DATE_ADD(NOW(),INTERVAL 5 MINUTE),Killer_CoreID=$Killer_CoreID where SpawnID=$TargetID");
		$sth_Spawn = mysql_query("select l.ItemID from lootgroupmap as l left join items_base as i on i.ItemID=l.ItemID where i.DropRate = 0 and l.GroupID=$TargetData[LootGroup] order by rand() limit ".mt_rand(1,$TargetData[MaxItems]));
		while ($NewItem = mysql_fetch_array($sth_Spawn)) {
			$ItemID = LootGen(0,0,$PlayerData->X,$PlayerData->Y,$PlayerData->MapID,$NewItem[ItemID],$TargetData[Level],1,$TargetData[MagicSkill]);
		}

		$sth_Spawn = mysql_query("select l.ItemID from lootgroupmap as l left join items_base as i on i.ItemID=l.ItemID where i.DropRate >= 1 and l.GroupID=$TargetData[LootGroup]");
		while ($NewItem = mysql_fetch_array($sth_Spawn)) {
			$ItemID = LootGen(0,0,$PlayerData->X,$PlayerData->Y,$PlayerData->MapID,$NewItem[ItemID],$TargetData[Level],1,$TargetData[MagicSkill]);
		}
	} else {
		if ($DamDelt > 0) {
			if ($DamDiff > 0) {
				$Deflect = "($DamDiff points deflected)";
			} elseif ($DamDiff < 0) {
				$Deflect = "(".abs($DamDiff)." boosted damage points!)";
				} else {
				$Deflect = "";
			}
			$WeaponID = $PlayerData->GetWeapon();
			if ($WeaponID == 0) {
				$WeaponName = "fists";
			} else {
				$WeaponName = $PlayerData->Inventory[$WeaponID]->Name;
			}
			BattleNote($BattleInfo[BattleID],"<img src=./images/battle/hit.jpg>$PlayerData->Username hits $TargetData[Username] with their $WeaponName for <b>$DamDelt points of damage</b> $Deflect<br>\n");
		} else {
			BattleNote($BattleInfo[BattleID],"<img src=./images/battle/miss.jpg>$TargetData[Username] evades $PlayerData->Username<br>\n");
		}
	}
	$TargetData[HealthCur] = $TargetData[HealthCur] - $DamDelt;
	$sth = mysql_query("update monster set HealthCur=$TargetData[HealthCur] where SpawnID=$TargetData[SpawnID]");
	print mysql_error();
	ActiveCheck($BattleInfo);
	
	##################################################
	### MONSTER HITS
	##################################################

	$sth_atk = mysql_query("select SpawnID from monster as M left join monster_base as B on B.MonsterID=M.MonsterID where M.HealthCur > 0 and B.Hostile='Y' and M.X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID");
	print mysql_error();
	while (list($MSpawn) = mysql_fetch_row($sth_atk)) {
		if ($PlayerData->HealthCur <= 0) { continue; }
		$TargetData = GetMonsterInformation($MSpawn);

		// Monster Hits
		list($DamDelt,$DamDiff) = AttackPlayer($TargetData);

		if ($TargetData[MOD_EnterArea] != "") { eval($TargetData[MOD_EnterArea]); }

		if ($DamDelt > $PlayerData->HealthCur) { $DamDelt = $PlayerData->HealthCur; }

		// You've died!
		if ($PlayerData->HealthCur - $DamDelt <= 0) {
			$PlayerData->HealthCur = 0;
	
			// Remove coins from user.
			$CoinLost = intval($PlayerData->Coins * .25);
			$PlayerData->Coins = $PlayerData->Coins-$CoinLost;
			//$PlayerData->Coins = 0;
	
			// Add 14 days to users age.
			$curage = $PlayerData->Age;
			$newage = $curage + 14;
			$aging = mysql_query("update user set Age=$newage where CoreID=$PlayerData->CoreID");

			// Remove poison from user
			$statrem = mysql_query("update user set PsnRemain = 0 where CoreID=$PlayerData->CoreID");
			$statrem = mysql_query("update user set PsnDmg = 0 where CoreID=$PlayerData->CoreID");

			// Remove user from the battle.
			ActiveCheck($BattleInfo);
				
			// Notify anyone in a fellowship.
			if ($PlayerData->FellowID > 0) {
				FellowNote($PlayerData,"$PlayerData->Username has died at $PlayerData->X,$PlayerData->Y:$PlayerData->MapID to a $TargetData[Name]");
			}
	
			// Display the dreadfull message.

			
			// Destroy the monsters
			//$battledel = mysql_query("delete from battle_user where CoreID = $PlayerData->CoreID");
			//$battledel = mysql_query("delete from battle_info where BattleID not in (Select BattleID from battle_user)");
			//$battledel = mysql_query("delete from monster where X = $PlayerData->X and Y = $PlayerData->Y and MapID = 
//$PlayerData->MapID");
			$sth = mysql_query("insert into overlay_corpse (CoreID,CreateTime,X,Y,MapID) values ($PlayerData->CoreID,NOW(),$PlayerData->X,$PlayerData->Y,$PlayerData->MapID)");

			print "<B>YOU HAVE DIED</B><BR>";
			print "<B>You have lost $CoinLost gold coins.</B><BR>";
			// Let everyone in the battle know but appending this to the battle log!
			BattleNote($BattleInfo[BattleID],"<B>$TargetData[Username] stares at $PlayerData->Username before making its final killing blow!</b><br>");

			$sth = mysql_query("select * from user where X=".$PlayerData->X." and Y=".$PlayerData->Y." and MapID=".$PlayerData->MapID." and CoreID != ".$PlayerData->CoreID." limit 1");
			$testing = mysql_fetch_array($sth);
			if (mysql_num_rows($sth) == 0) {
				// No players are in the area
				// $sth = mysql_query("delete from monster where SpawnID=".$TargetData['SpawnID']);
			}

			// Revive the player at their deathstone.
			$PlayerData->X = $PlayerData->Death_X;
			$PlayerData->Y = $PlayerData->Death_Y;
			$PlayerData->MapID = $PlayerData->Death_MapID;
			$sth = mysql_query("update user set Deaths=Deaths+1,Coins=Coins-$CoinLost,X=$PlayerData->Death_X,Y=$PlayerData->Death_Y,MapID=$PlayerData->Death_MapID,HealthCur=".$PlayerData->HealthMax." where CoreID=$PlayerData->CoreID");
			print mysql_error();

			$sth = mysql_query("insert into user_deaths (CoreID,MonsterID) values ($PlayerData->CoreID,$TargetData[MonsterID])");
			print mysql_error();
			$displevel = $TargetData[Level];
			$sth2 = mysql_query("select Admin from user where CoreID = $PlayerData->CoreID");
			$UData2 = mysql_fetch_array($sth2);
			if($UData2[Admin] != "Y") {
			GlobalChat($PlayerData->Username." (Level ".$PlayerData->Level.") has been slain by a $TargetData[Username] (Level ".intval($displevel).")");
			//GlobalChat($PlayerData->Username." has been slain by a $TargetData[Username]");
			}
		} else {
			if ($DamDelt > 0) {
				//check for status effects
				$sth = mysql_query("select Poison, PsnTurns, PsnDmg from monster_base where Name = '$TargetData[Username]'");
			while (list($Poison,$PsnTurns,$PsnDmg) = mysql_fetch_row($sth)) {
				if($Poison == 'Y' && rand(1,100) <= 25) {
 					$sth1 = mysql_query("update user set PsnRemain=PsnRemain+$PsnTurns where 
CoreID=$PlayerData->CoreID");
					$sth1 = mysql_query("update user set PsnDmg=$PsnDmg where PsnDmg < $PsnDmg and 
CoreID=$PlayerData->CoreID");
					BattleNote($BattleInfo[BattleID],"<img src = ./images/battle/Poison.jpg> $TargetData[Username] poisons $PlayerData->Username<BR>");
				}
			}
					
				if ($DamDiff > 0) {
					$Deflect = "($DamDiff points deflected)";
				} elseif ($DamDiff < 0) {
					$Deflect = "($DamDiff points shocked)";
				} else {
					$Deflect = "";
				}
				
				// Save damage done.
				$PlayerData->AdjustHealth(-$DamDelt);

				BattleNote($BattleInfo[BattleID],"<img src=./images/battle/hit.jpg>$TargetData[Username] hits $PlayerData->Username with their $TargetData[WeaponType] for <b>$DamDelt points of damage</b> $Deflect<br>");
			} else {
				BattleNote($BattleInfo[BattleID],"<img src=./images/battle/miss.jpg>$PlayerData->Username evades the $TargetData[Name]<br>");
			}
		}
	}
}

















/*
Section: Display Battle Page
*/

if ($BNote == "Y") {
	BattleNote($BattleInfo[BattleID],"<br>");
}



$sth = mysql_query("select M.*,T.Image from overlay as M left join tiledata as T on T.TileID=M.TileID where M.X=$PlayerData->X and M.Y=$PlayerData->Y and M.MapID=$PlayerData->MapID");
print mysql_error();
$overlaydata = mysql_fetch_array($sth);

$sth = mysql_query("select M.*,T.Image from map as M left join tiledata as T on T.TileID=M.TileID where M.X=$PlayerData->X and M.Y=$PlayerData->Y and M.MapID=$PlayerData->MapID");
print mysql_error();
$mapdata = mysql_fetch_array($sth);

print "<table border=0 class=Box1 width=340>";
print "<tr><td align=right>";

// Display Top Stats


        $sth = mysql_query("select XP from level_curve where Level=".($PlayerData->Level));
        list($XPBottom) = mysql_fetch_row($sth);

        $sth = mysql_query("select XP from level_curve where Level=".($PlayerData->Level+1));
        list($XPTop) = mysql_fetch_row($sth);

	$CurXP = $PlayerData->XP - $XPBottom;
	$XPTop = $XPTop - $XPBottom;

        $LevelXP = $XPTop - $XPBottom;

        $CurXP = $PlayerData->XP - $XPBottom;
        $NeededXP = $XPTop - $PlayerData->XP;

print "<table border=0 cellpadding=0 cellspacing=0 class=pageContainer>";
print "<tr>";

print "<td rowspan=3 width=30 height=30 background=\"./images/tiles/$mapdata[Image]\">";
if ($overlaydata[Image] != "") { print "<img src=./images/tiles/$overlaydata[Image]>"; }
print "</td>";

print "<td class=Header colspan=4>&nbsp</td>";
print "<td class=Menu colspan=2>Loc: $PlayerData->X,$PlayerData->Y</td>";
print "</tr>";
print "<tr>";


print "<td class=pageCell align=center>Health</td><td class=PageCell align=center>$PlayerData->HealthCur/$PlayerData->HealthMax</td>";
print "<td class=pageCell align=center colspan=2>To level ".($PlayerData->Level+1)."</td>";
print "<td class=pageCell align=center>Mana</td><td class=PageCell align=center>".$PlayerData->ManaCur."/".$PlayerData->ManaMax."</td>";
print "</tr>";
print "<tr><td colspan=2 class=PageCell>";
GenBar_Lite($PlayerData->HealthCur,$PlayerData->HealthMax,100,"health");
print "</td><td colspan=2 class=PageCell>";
GenBar_Lite($CurXP,$XPTop,100,"health");
print "</td><td colspan=2 class=PageCell>";
GenBar_Lite($PlayerData->ManaCur,$PlayerData->ManaMax,100,"mana");
print "</td></tr>";
print "</table>";


print "</td></tr>";
//Flee from battle not yet implimented fully
if (Check_Battle($PlayerData) == 1) {
	if ($PlayerData->FT > 0) {
		print "<TR><TD CLASS=MENU COLSPAN=6><A class=\"sidelink\" HREF=$SCRIPT_NAME?Action=Flee&RD=".rand(1,1000000).">Flee</A></b> ]  (<B>$PlayerData->FT</B> flee turns left</b>)</TD></TR>";
	}
} else {
	print "<tr><td class=header>Battle Complete</td></tr>";
	
	print "<tr><td>";
	print "This battle is over. Please return to the navigation page to claim any loot.<P>";
	print "</td></tr>";
        $statrem = mysql_query("update user set PsnRemain=0 where CoreID=$PlayerData->CoreID");
        $statrem = mysql_query("update user set PsnDmg=0 where CoreID=$PlayerData->CoreID");

	print "<tr><td class=Menu colspan=6 align=center>";
	print "<br><b><A CLASS=sidelink HREF=start.php?RD=".rand(1,1000000).">Click here to return to the navigation window</A></b><p>";
	print "</td></tr>";
}

if ($BattleInfo[Flee] != "Yes") {
//	print "<tr><td class=Header>Battle</td></tr>";
	print "<tr><td>";
// Generate player and monster health bar
	print "<table border=0 class=pageContainer width=100%>";
	$sth = mysql_query("select TD.Image,M.*,B.Name,B.BaseHealth,B.Level from monster as M left join monster_base as B on B.MonsterID=M.MonsterID left join tiledata as TD on TD.TileID=B.TileID where M.X=$PlayerData->X and M.Y=$PlayerData->Y and M.MapID=$PlayerData->MapID and M.HealthCur > 0 and B.Hostile='Y'");
	print mysql_error();
	while ($MData = mysql_fetch_array($sth)) {
		print "<tr><td class=pageCell><b>$MData[Name] (</b>Monster level ".number_format($MData[Level])."<b>)</b></td><td rowspan=2 width=30 class=pagecell><img src=./images/tiles/$MData[Image]></td><td align=right class=pageCell>[<b> <A HREF=$SCRIPT_NAME?Action=Attack&TargetType=Monster&TargetID=$MData[SpawnID] CLASS=sidelink>Attack</A> </b>]</TD></TR>";
		print "<tr><td class=pageCell>";
		GenBar_Lite($MData[HealthCur],$MData[BaseHealth],100,"health");
		print "</td><td class=pageCell>";
		print "Health: <B>".$MData[HealthCur]." / ".$MData[BaseHealth]."</B>";
		print "</td></tr>";
	}

	$sth = mysql_query("select U.*,C.Name as ClanName from user as U left join clans as C on C.ClanID=U.ClanID where U.X=$PlayerData->X and U.Y=$PlayerData->Y and U.MapID=$PlayerData->MapID and U.HealthCur > 0 AND U.CoreID != $PlayerData->CoreID and U.LastAccessed > DATE_SUB(NOW(),INTERVAL 10 MINUTE)");
	print mysql_error();
	if (mysql_num_rows($sth) > 0) {
		print "<tr><td colspan=3 class=pageCell><hr></td></tr>";
		while ($TData = mysql_fetch_array($sth)) {
			$UData = new Player($TData[CoreID]);
			print "<tr>";
			print "<td class=pageCell><b>$UData->Username (</b>".$UData->ClanData->Name."<b>)</b></td>";

			print "<td rowspan=2 class=pageCell width=30>";
			PlayerInfo($UData->CoreID,$UData->UserPic);
			print "</td>";

			print "<td align=right class=pageCell>";
			print "&nbsp;";
			print "</TD></TR>";
			print "<tr><td class=pageCell>";
			GenBar_Lite($UData->HealthCur,$UData->HealthMax,100,"health");
			print "</td><td class=pageCell>";
			print "Health: <B>".$UData->HealthCur." / ".$UData->HealthMax."</B>";
			print "</td></tr>";
		}
	}
	print "</table>";

	print "</td></tr>";
// Load in battle item uses
	if ($BattleActions - $BattleInfo[Actions] > 0) {
		$sth = mysql_query("select ib.ItemID,sum(ItemStack),ib.Name,Image from items as i left join items_base as ib on ib.ItemID=i.ItemID left join tiledata as td on td.TileID=ib.TileID where i.CoreID=$PlayerData->CoreID and i.Banked='N' and (Battle_Use='Y') group by i.ItemID");
		if (mysql_num_rows($sth) > 0) {
			print "<tr><td class=Header>Use Items</td></tr>";
			$CurItem = 0;
			while (list($ItemID,$ItemStack,$ItemName,$ItemImage) = mysql_fetch_row($sth)) {
				print "<tr><Td><table class=pageContainer WIDTH=100%><tr><td class=pageCell><img src=\"./images/tiles/$ItemImage\" WIDTH=30 HEIGHT=30></td><td class=pageCell><B>$ItemName</b> ($ItemStack)</BR>";
				print "<A CLASS=sidelink HREF=$SCRIPT_NAME?Drink=$ItemID>Use Item</A>";
				print "</TD></tr></table></td></tr>";
			}
			print "<tr><td colspan=2 class=Menu>".($BattleInfo[ItemUses])." item uses left in this battle.</td></tr>";

		}

		$sth = mysql_query("select S.Name,US.Adjustment,US.Expire from userspell as US left join spells as S on S.SpellID=US.SpellID where US.CoreID=$PlayerData->CoreID and US.Expire > NOW() order by US.Expire");
		if (mysql_num_rows($sth) > 0) {
			print "<tr><td colspan=2 class=Header>Spells in effect</td></tr><tr><td>";
			while (list($SpellName,$SpellAdjust,$SpellExpire) = mysql_fetch_row($sth)) {
				print "$SpellName ($SpellAdjust) expires at $SpellExpire<BR>";
			}
			print "</td></tr>";
		}
	}
}
//print "<tr><td colspan=2 class=Header>Battle Text</td></tr><tr><td colspan=2>";
//print "$BattleInfo[BattleText]&nbsp;";
//print "</td></tr>";
print "</table>";
// Get monster info from db
function GetMonsterInformation($SpawnID) {
	if ($SpawnID == "") { return 0; }
	$sth = mysql_query("select M.X,M.Y,M.MapID,M.SpawnID,M.HealthCur,M.BattleText,B.* from monster as M left join monster_base as B on B.MonsterID=M.MonsterID where M.SpawnID=$SpawnID");
	print mysql_error();
	$MonsterData = mysql_fetch_array($sth);
	$MonsterData[Username] = $MonsterData[Name];
	$sth = mysql_query("select MS.Adjustment,S.* from monsterspell as MS left join spells as S on S.SpellID=MS.SpellID where MS.SpawnID=$MonsterData[SpawnID] and MS.Expire > NOW()");
	print mysql_error();
	while ($spelldata = mysql_fetch_array($sth)) {
		# print "THIS MONSTER HAS $spelldata[Name] ON IT! ($spelldata[Affected] / $spelldata[Adjustment])<BR>";

		if ($spelldata[War] == "Yes") {
			if ($MonsterData[Vuln][$spelldata[Affected]] < $spelldata[Adjustment]) {
				$MonsterData[Vuln][$spelldata[Affected]] = $spelldata[Adjustment];
			}
		} else {
			if ($MonsterData[Prot][$spelldata[Affected]] < $spelldata[Adjustment]) {
				$MonsterData[Prot][$spelldata[Affected]] = $spelldata[Adjustment];
			}
		}
	}
	$MonsterData[AL] = $MonsterData[AL] - intval($MonsterData[Vuln][AL]);
	if ($MonsterData[AL] < 0) { $MonsterData[AL] = 0; }

	$MonsterData[Username] == $MonsterData[Name];

	$MonsterData[WeaponData][Name] = $MonsterData[WeaponType];
	$MonsterData[WeaponData][WeaponType] = $MonsterData[WeaponType];
	$MonsterData[WeaponData][MinDam] = $MonsterData[WeaponMin];
	$MonsterData[WeaponData][MaxDam] = $MonsterData[WeaponMax];

	return $MonsterData;
}
//Calculate damage
function DamageCalc($DamMin,$DamMax,$AL) {
	// Chance of a Critical Strike
	if (mt_rand(0,100) > 95) { $DamMax = $DamMax * 5; }

	$ArmorMOD = 1 / (1 + ($AL / (66 + (2 / 3))));
	$DamVariance = (1 - ($DamMin / $DamMax)) * 100;

	$DamMin = (1 - ($DamVariance / 100)) * $DamMax;

	$DamCrit = (0.9 * (($DamMin + $DamMax) / 2)) + (0.1 * $DamMax * 2);

	$DamMod = $DamCrit * $ArmorMOD;
	$DamMin = $DamMod * 0.5;
	$DamMax = $DamMod * 1.5;

	if ($DamMin < 0) { $DamMin = 0; }
	if ($DamMax < 0) { $DamMax = 0; }
	if ($DamMin > $DamMax) { $DamMax = $DamMin; }

	$DamDelt = mt_rand($DamMin,$DamMax);
	return $DamDelt;
}
// Actual attacking monster
function AttackMonster($TargetData) {
	global $PlayerData;
	$WeaponID = $PlayerData->GetWeapon();
	if ($WeaponID == 0) {
		$DamMin = 5;
		$DamMax = 7;
		$WeaType = "Melee";
		$WeaSkill = $PlayerData->GetSkillLevelByName($WeaType);
		$WeaSkill = $WeaSkill + $PlayerData->AttackBonus;
	} else {
		$DamMin = $PlayerData->Inventory[$WeaponID]->MinDam;
		$DamMax = $PlayerData->Inventory[$WeaponID]->MaxDam;
		$WeaType = $PlayerData->Inventory[$WeaponID]->SkillType;
		$WeaSkill = $PlayerData->GetSkillLevelByName($WeaType);
		$WeaSkill = $WeaSkill + $PlayerData->AttackBonus;
	}

	$DamMin = $DamMin + intval($WeaSkill * .5);
	$DamMax = $DamMax + intval($WeaSkill * .5);

#	print "Attack: $WeaSkill against $TargetData[MeleeD]<br>";

	$DamDelt = DamageCalc($DamMin,$DamMax,$TargetData[AL]);

	if (SkillCheck($WeaSkill,$TargetData[MeleeD]) == 0) { $DamDelt = 0; }
	$DamBefore = $DamDelt;
	if ($DamDelt > 0) { $DamDiff = $DamBefore - $DamDelt; }
	if ($DamDelt < 0) { $DamDelt = 0; }
	return array($DamDelt,$DamDiff);
}
// Monster attacks back
function AttackPlayer($MonsterData) {
	global $PlayerData;
	$DamMin = $MonsterData[WeaponData][MinDam];
	$DamMax = $MonsterData[WeaponData][MaxDam];
	$WeaSkill = $MonsterData[WeaponSkill];

	$DamMin = $DamMin + intval($WeaSkill * .5);
	$DamMax = $DamMax + intval($WeaSkill * .5);
	$DamDelt = DamageCalc($DamMin,$DamMax,$PlayerData->GetAL());
	$Defence = $PlayerData->GetSkillLevelByName("Defence");
	$Defence = $Defence + $PlayerData->MeleeBonus;

	if (SkillCheck($WeaSkill,$Defence) == 0) { $DamDelt = 0; }
	$DamBefore = $DamDelt;
	if ($DamDelt > 0) { $DamDiff = $DamBefore - $DamDelt; }
	if ($DamDelt < 0) { $DamDelt = 0; }
	return array($DamDelt,$DamDiff);
}
// Show info in battle log if player has it on
function BattleNote($BattleID,$String) {
	global $BattleInfo,$BNote,$CurNote;
	$BNote = "Y";
	$BattleInfo[BattleText] = $String.$BattleInfo[BattleText];
	$CurNote = $CurNote.$String;
	$sth = mysql_query("update battle_info set ActionDate=NOW(),BattleText=concat(\"$String\",BattleText) where BattleID=$BattleID");
}
// Player has battle log off
function ActiveCheck($BattleInfo) {
//	print "grape";
	global $PlayerData;
	$sth = mysql_query("select * from monster where HealthCur > 0 and X=$BattleInfo[X] and Y=$BattleInfo[Y] and MapID=$BattleInfo[MapID]");
	print mysql_error();
//	print "apple";
	if (mysql_num_rows($sth) == 0) {
		$sth1 = mysql_query("update battle_info set Active='No' where BattleID=$BattleInfo[BattleID]");
		print mysql_error();
//		print "orange";
	}
}
// Adds someone else entering battle to battle log
function CheckBattleData($BattleInfo) {
	global $PlayerData;
	$sth = mysql_query("select * from battle_user where CoreID=".intval($PlayerData->CoreID)." and BattleID=".intval($BattleInfo[BattleID]));
	if (mysql_num_rows($sth) == 0) {
		$sth = mysql_query("insert into battle_user (BattleID,CoreID) values ($BattleInfo[BattleID],$PlayerData->CoreID)");
		$sth = mysql_query("update battle_info set BattleText=concat(\"<img src=./images/battle/action.jpg>$PlayerData->Username enters the battle<br>\",BattleText) where BattleID=$BattleInfo[BattleID]");
		print mysql_error();
	}
}

?>
