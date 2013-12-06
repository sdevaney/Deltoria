<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
global $PlayerData;
// Do db stuff to build clan fort
$sth = mysql_query("select TD.* from map as OC left join tiledata as TD on TD.TileID=OC.TileID where OC.X=$PlayerData->X and OC.Y=$PlayerData->Y and OC.MapID=$PlayerData->MapID");
$TileData = mysql_fetch_array($sth);

$sth = mysql_query("select cb.ClanID,cb.Armor,cb.KeyID,cb.Flags,b.*,td.Image from clan_buildings as cb left join buildings as b on b.BID=cb.BID left join tiledata as td on td.TileID=b.TileID where cb.X=$Player_X and cb.Y=$Player_Y and cb.MapID=$Player_MapID");
if (mysql_num_rows($sth) > 0) {
	$BuildingData = mysql_fetch_array($sth);
}

$sth = mysql_query("select C.Name as ClanName,TD.Name,TD.Image,OC.TileID,OC.Armor,OC.ClanID from overlay_clan as OC left join clans as C on C.ClanID=OC.ClanID left join tiledata as TD on TD.TileID=OC.TileID where OC.X=$Player_X and OC.Y=$Player_Y and OC.MapID=$Player_MapID");
print mysql_error();
if (mysql_num_rows($sth) > 0) {
	$OverlayData = mysql_fetch_array($sth);
	if ($OverlayData[TileID] == "0" || $OverlayData[TileID] == "1") {
		$OverlayData[Image] = "clan_good.gif";
	}
}
// Player buys clan buildings and places them on the map
if ($PlayerData->WID  == 0 && $PlayerData->ClanID > 0) {
	if ((FlagCheck("B",$PlayerData->ClanFlags) || $PlayerData->CoreID == $PlayerData->ClanData->Founder)) {
		if ($OverlayData[ClanID] == $PlayerData->ClanID && $BuildingData[ClanID] == 0 && $PurchaseTile > 0 && $OverlayData[TileID] <= 1) {
			$sth = mysql_query("select TD.Image,OC.TileID from overlay_clan as OC left join tiledata as TD on TD.TileID=OC.TileID where OC.X >= ".($PlayerData->X-1)." and OC.X <= ".($PlayerData->X+1)." and OC.Y >= ".($PlayerData->Y-1)." and OC.Y <= ".($PlayerData->Y+1)." and OC.MapID=$PlayerData->MapID and OC.ClanID=$PlayerData->ClanID");
			print mysql_error();
			if (mysql_num_rows($sth) >= 2) {
				$sth = mysql_query("update overlay_clan set TileID=$PurchaseTile where X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID and ClanID=$PlayerData->ClanID");
				print mysql_error();
				print "This tile has been purchased.<BR>";
			} else {
				print mysql_num_rows($sth);
				print "Note: You must own most surrounding tiles to place an object.<BR>";
			}
		}
		if ($OverlayData[ClanID] == $PlayerData->ClanID && $SellTile != "" && $OverlayData[ClanID] > 0) {
			if ($SellTile == "N") {
				print "<table WIDTH=468 class=Box1>";
				print "<Tr><Td class=Header>Are you sure that you wish to destroy the structure on this tile?</td></tr>";
				print "<tr><td>";
				print "Destroying this structure will remove the structure from this tile opening it up for another structure. Note though that you ";
				print "will not get any coins back from the purchase of the item on here now.<P>";
				print "<a href=$SCRIPT_NAME?SellTile=Y><img border=0 src=./images/buttons/yes.jpg></a>";
				print "</td></tr>";
				print "</table><p>";
			} elseif ($SellTile == "Y") {
				$sth = mysql_query("select * from overlay_clan where ClanID=$PlayerData->ClanID");
				if (mysql_num_rows($sth) >= 2) {
					$sth = mysql_query("update overlay_clan set TileID=1 where X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID and ClanID=$PlayerData->ClanID");
					print "This tile has been demolished.<BR>";
				}
			}
		}
	}


// Destory clan building
	if ($BuildingData[ClanID] == "" && $OverlayData[ClanID] == $PlayerData->ClanID) {
		if ($OverlayData[TileID] <= 1 && (FlagCheck("B",$PlayerData->ClanFlags) || $PlayerData->CoreID == $PlayerData->ClanData->Founder) && $DelTile == "N") {
			print "<table WIDTH=468 class=Box1>";
			print "<Tr><Td class=Header>Are you sure that you wish to destroy the owned land?</td></tr>";
			print "<tr><td>";
			print "<a href=$SCRIPT_NAME?DelTile=Y><img border=0 src=./images/buttons/yes.jpg></a>";
			print "</td></tr>";
			print "</table><p>";
		} elseif ($OverlayData[TileID] <= 1 && (FlagCheck("B",$PlayerData->ClanFlags) || $PlayerData->CoreID == $PlayerData->ClanData->Founder) && $DelTile == "Y") {
			$sth = mysql_query("delete from overlay_clan where X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID and ClanID=$PlayerData->ClanID");
			print "This tile has been demolished.<BR>";
		}
		print "<table WIDTH=468 class=box1>";
		print "<tr><td class=header height=15>Tile Managment</td></tr>";
		if ($OverlayData[TileID] <= 1 && (FlagCheck("B",$PlayerData->ClanFlags) || $PlayerData->CoreID == $PlayerData->ClanData->Founder)) {
			print "<tr><td colspan=2 valign=top>";
			$sth = mysql_query("select * from tiledata where Clan='Y'");
			while ($TData = mysql_fetch_array($sth)) {
				print "<A HREF=$SCRIPT_NAME?PurchaseTile=$TData[TileID]><IMG SRC=./images/tiles/$TData[Image] BORDER=0></A>&nbsp;";
			}
			print "</td></tr>";
			print "<tr><td class=header colspan=2>Destroy Land</td></tr>";
			print "<Tr><Td>";
			print "Would you like to destroy this land which is owned by your sworn to clan?<BR>";
			print "<DIV ALIGN=RIGHT><A HREF=$SCRIPT_NAME?DelTile=N>Yes</A></DIV>";
			print "</td></tr>";
		} else {
			if ($Armor_Wall < 0 && $Armor_Wall != "") { $Armor_Wall = 0; }
// Add armor to building
			print "<TR><TD COLSPAN=2 valign=top>";
			if ($Armor_Wall == "0") {
				print "<BR>";
				print "How much armor do you wish to add to your wall? Max is 500. Each unit of armor takes 1 turn.<BR>";
				print "<FORM ACTION=$SCRIPT_NAME><INPUT TYPE=TEXT SIZE=3 MAXLENGTH=3 NAME=Armor_Wall VALUE=0><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Add></FORM>";
			} elseif (intval($Armor_Wall) > 0 && intval($Armor_Wall)+$BData[Armor] <= 500) {
				$sth = mysql_query("update overlay_clan set Armor=Armor+".intval($Armor_Wall)." where X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID");
				print mysql_error();
				$OverlayData[Armor] = $OverlayData[Armor] + $Armor_Wall;
				$PlayerData->AdjustValue("Actions",($PlayerData->Actions-$Armor_Wall));
			}
			if ($OverlayData[Armor] < 500) {
				print "[ <A HREF=$SCRIPT_NAME?Armor_Wall=0>Increase</A> ]";
			}
			print "<B>Armor:</B> $OverlayData[Armor]<BR>";
			print "</TD></TR>";
		}

		if ((FlagCheck("B",$PlayerData->ClanFlags) || $PlayerData->CoreID == $PlayerData->ClanData->Founder)) {
			print "<Tr><Td colspan=2 class=menu height=15><a href=$SCRIPT_NAME?SellTile=N>Sell Structure</A></td></tr>";
		}
		print "</table><p>";
	}
// Clan building error handleing
	if ($OverlayData[ClanID] == $PlayerData->ClanID && $OverlayData[TileID] != "" && $BuildingData[ClanID] == "" && (FlagCheck("B",$PlayerData->ClanFlags) || $PlayerData->CoreID == $PlayerData->ClanData->Founder)) {
		if ($BuildBuilding > 0) {
			$sth = mysql_query("select b.*,td.Image from buildings as b left join tiledata as td on td.TileID=b.TileID where b.Cost <= $PlayerData->Coins and b.BID=$BuildBuilding");
			print mysql_error();
			if (mysql_num_rows($sth) > 0) {
				$PlayerData->AdjustValue("Coins",($PlayerData->Coins-$BData[Cost]));
				$BData = mysql_fetch_array($sth);
				print "Building $BData[Name]<BR>";
				$sth = mysql_query("insert into clan_buildings (ClanID,BID,X,Y,MapID,Armor) values ($PlayerData->ClanID,$BuildBuilding,$PlayerData->X,$PlayerData->Y,$PlayerData->MapID,".intval($BData[MaxArmor] * .5).")");
				print mysql_error();				
			} else {
				print "Unable to locate that building to build.<BR>";
			}
		} else {
			print "<table border=0 class=Box2 WIDTH=468>";
			print "<TR><TD height=15 class=Header COLSPAN=5>Build Building</TD></TR>";
			print "<Tr><Td class=menu>Build</td><Td class=menu>Name</td><td class=menu>Cost</td><td class=menu>Maint</td><td class=Menu>Description</td></tr>";
			$sth = mysql_query("select b.*,td.Image from buildings as b left join tiledata as td on td.TileID=b.TileID where b.Cost <= $PlayerData->Coins");
			if (mysql_num_rows($sth) > 0) {
				while ($BData = mysql_fetch_array($sth)) {
					print "<TR><TD WIDTH=30BACKGROUND=./images/tiles/$TileData[Image]><A HREF=$SCRIPT_NAME?BuildBuilding=$BData[BID]><IMG BORDER=0 SRC=./images/tiles/$BData[Image]></A></TD><TD>$BData[Name]</TD><TD>$BData[Cost]</TD><TD>$BData[BaseMaint]</TD><TD>$BData[Description]</TD></TR>";
				}
			}
			print "</table><p>";
		}
	}

// Set recall point
	if ($OverlayData[ClanID] == "" && $PlayerData->ClanData->Founder == $PlayerData->CoreID && $SetRecall == "Y") { 
		$sth = mysql_query("update clans set HomeX=$PlayerData->X,HomeY=$PlayerData->Y,HomeMapID=$PlayerData->MapID where ClanID=$PlayerData->ClanID");
		print mysql_error();
		$PlayerData->ClanData->HomeX = $PlayerData->X;
		$PlayerData->ClanData->HomeY = $PlayerData->Y;
		$PlayerData->ClanData->HomeMapID = $PlayerData->MapID;
	} elseif ($BuildingData[ClanID] == $PlayerData->ClanID || $OverlayData[ClanID] == $PlayerData->ClanID && $PlayerData->ClanData->Founder == $PlayerData->CoreID && $SetRecall != "Y") { 
		if ($PlayerData->ClanData->HomeX == 0 && $PlayerData->ClanData->HomeY == 0 && $PlayerData->ClanData->HomeMapID == 0) {
			print "<TABLE BORDER=0 class=BOX1 WIDTH=468>";
			print "<TR><TD CLASS=HEADER>Clan Recall Location</TD></TD>";
			print "<TR><TD>";
			print "Clan Members have the option to recall directly to your clans land. Since you own this section of land you may mark ";
			print "this as a valid recall location. A clan may only have one recall location at a time. The recall location once set may ";
			print "be changed from the clan menu while standing on clan owned land.<BR>";
			print "</TD></TR>";
			print "<TR><TD CLASS=Footer>";
			print "[ <A HREF=$SCRIPT_NAME?SetRecall=Y>Set Recall Location</A> ] </TD></TR>";
			print "</TABLE><P>";
		}
	}
}



if ($BuildingData[ClanID] == $PlayerData->ClanID && $BuildingData[ClanID] > 0) {
	$sth = mysql_query("select cb.Armor,cb.KeyID,cb.Flags,b.*,td.Image from clan_buildings as cb left join buildings as b on b.BID=cb.BID left join tiledata as td on td.TileID=b.TileID where cb.X=$PlayerData->X and cb.Y=$PlayerData->Y and cb.MapID=$PlayerData->MapID");
	if (mysql_num_rows($sth) > 0) {
		$BData = mysql_fetch_array($sth);
// Adding armor costs action points
		print "<Table border=1 class=box3 WIDTH=468>";
		print "<Tr><td height=15 class=Header>$BData[Name]</td></tr>";
		print "<Tr><td colspan=2 valign=top><b>";
		print $BData[Name];
		print "</b><br>";
		print "<B>Armor:</B> $BData[Armor] / $BData[MaxArmor] ";
		GenBar_Lite($BData[Armor],$BData[MaxArmor],100,"health");
		if ($BData[Armor] < $BData[MaxArmor]) {
			if ($AddArmor) {
				print "How much armor would you like to add?";
				print "<form action=$SCRIPT_NAME>";
				print "Amount: (1 turn = 1 armor point) <input type=text size=4 maxlength=4 name=ArmorAmount value=0><br>";
				print "<input type=submit name=submit value=Add>";
				print "</form>";
			} elseif (intval($ArmorAmount) > 0 && intval($ArmorAmount) <= $PlayerData->Actions && intval($ArmorAmount) + $BData[Armor] <= $BData[MaxArmor]) {
				$ArmorAmount = intval($ArmorAmount);
				print "Adding $ArmorAmount armor units.<p>";
				$BData[Armor] = $BData[Armor] + $ArmorAmount;
				$sth = mysql_query("update clan_buildings set Armor=Armor+$ArmorAmount where KeyID=$BData[KeyID]");
				print mysql_error();
				$PlayerData->AdjustValue("Actions",($PlayerData->Actions-$ArmorAmount));
			} else {
				print "Your $BData[Name] is not fully armored. Click <A HREF=$SCRIPT_NAME?AddArmor=$BData[KeyID]>here</A> to add armor.<P>";
			}
		}
		print "<p>";
		eval($BData[ModCode]);
		print "</td></tr></table><p>";
	}
}


// Clan battles start here
if ($PlayerData->WID > 0) {
	print "<table border=0 class=box1 WIDTH=468>";
	$sth = mysql_query("select cw.*,w.* from clan_warriors as cw left join warriors as w on cw.WarriorID=w.WarriorID where cw.ClanID=$PlayerData->ClanID and cw.WID=$PlayerData->WID");
	$WData = mysql_fetch_array($sth);

	if ($WData[Turns] >= 5) {
//		if ($BuildingData[ClanID] == "" && $TileData[ClanID] == $PlayerData->ClanID && $OverlayData[TileID] > 1 && $OverlayData[ClanID] != $PlayerData->ClanID) {
		if ($BuildingData[ClanID] == "" && $OverlayData[TileID] > 1 && $OverlayData[ClanID] != $PlayerData->ClanID) {
			if ($AssumeAttack != "Y") {
				print "<TR><TD height=15 class=Header>Attack Tile</TD></TR>";
				print "<TR><TD>$OverlayData[ClanName] owns a structure here with $OverlayData[Armor].</TD></TR>";
				print "<TR><TD height=15 class=Footer><A HREF=$SCRIPT_NAME?AssumeAttack=Y>Attack</A></TD></TR>";
			} else {
				$sth = mysql_query("update clan_warriors set Turns=Turns-5 where WID=$WData[WID]");
				print mysql_error();
				print "<TR><TD height=15 class=Header>Attack Tile</TD></TR>";
				print "<tr><td>";
				$TDamage = intval(floor(($WData[Strength] * $WData[Amount]) * .05));
				if ($TDamage > $OverlayData[Armor]) { $TDamage = $OverlayData[Armor]; }
				print "You damage $OverlayData[ClanName]s structure for $TDamage points!<P>";	
				if ($TDamage == $OverlayData[Armor]) { 
					print "You have destroyed the structure located here!<br>";

					$sth = mysql_query("update overlay_clan set Armor=250,TileID=0 where X=$Player_X and Y=$Player_Y and MapID=$Player_MapID and ClanID=$OverlayData[ClanID]");
					print mysql_error();
					$sth = mysql_query("select CoreID from user where ClanID=$OverlayData[ClanID]");
					while (list($ClanCoreID) = mysql_fetch_row($sth)) {
						$sth_int = mysql_query("insert into user_log (CoreID,Type,Message) values ($ClanCoreID,'Structure Attacked','".str_replace("'","\'","$PlayerData->Username has attacked a structure with some $WData[Name]s and destroyed it!")."')");
						print mysql_error();
					}
				} else {
					print "You have damaged the structure located here!<br>";

					$sth = mysql_query("update overlay_clan set Armor=Armor-$TDamage where X=$Player_X and Y=$Player_Y and MapID=$Player_MapID and ClanID=$OverlayData[ClanID]");
					print mysql_error();
					$sth = mysql_query("select CoreID from user where ClanID=$OverlayData[ClanID]");
					while (list($ClanCoreID) = mysql_fetch_row($sth)) {
						$sth_int = mysql_query("insert into user_log (CoreID,Type,Message) values ($ClanCoreID,'Structure Attacked','".str_replace("'","\'","$PlayerData->Username has attacked a structure with some $WData[Name]s. They have done $TDamage points of damage.")."')");
						print mysql_error();
					}
				}
				print "</td></tr>";
			}
		}

		if ($AttackWarrior == "") {
	                $sth = mysql_query("select c.Name as ClanName,cw.*,w.* from clan_warriors as cw left join warriors as w on cw.WarriorID=w.WarriorID left join clans as c on c.ClanID=cw.ClanID where cw.ClanID != $PlayerData->ClanID and cw.X=$WData[X] and cw.Y=$WData[Y] and cw.MapID=$WData[MapID]");
			while ($TData = mysql_fetch_array($sth)) {
				print "Attack: $TData[Amount] $TData[Name]'s owned by $TData[ClanName] guild. [ <A HREF=$SCRIPT_NAME?AttackWarrior=$TData[WID]>Attack</A> ]<BR>";
			}
		} else {
			$sth = mysql_query("update clan_warriors set Turns=Turns-5 where WID=$WData[WID]");
			print mysql_error();
			
			print "<tr><td class=Header height=15>Battle Results</td></tr>";
			print "<tr><td>";
	                $sth = mysql_query("select c.Name as ClanName,cw.*,w.* from clan_warriors as cw left join warriors as w on cw.WarriorID=w.WarriorID left join clans as c on c.ClanID=cw.ClanID where cw.ClanID != $PlayerData->ClanID and cw.X=$WData[X] and cw.Y=$WData[Y] and cw.MapID=$WData[MapID] and cw.WID=$AttackWarrior");
			$TData = mysql_fetch_array($sth);
	
			$TDamage = intval(floor(($WData[Strength] * $WData[Amount]) * .5));
			$TDeath = intval($TDamage / $TData[Armor] + 1);
			if ($TDeath > $TData[Amount]) { $TDeath = $TData[Amount]; }
			print "You damage $TData[ClanName]s $TData[Name]s killing $TDeath units.<BR>";	
			$WDamage = intval(floor(($TData[Strength] * $TData[Amount]) * .5))	;
			$WDeath = intval($WDamage / $WData[Armor] + 1);
			if ($WDeath > $WData[Amount]) { $WDeath = $WData[Amount]; }
			print "$TData[ClanName]s $TData[Name]s hit your $WData[Name]s killing $WDeath units.<BR>";
			$sth = mysql_query("update clan_warriors set Amount=Amount-$WDeath where WID=$WData[WID]");
			print mysql_error();
			$sth = mysql_query("update clan_warriors set Amount=Amount-$TDeath where WID=$TData[WID]");
			print mysql_error();
			$sth = mysql_query("delete from clan_warriors where Amount=0");
			print mysql_error();
			print "</td></tr>";
	
			$sth = mysql_query("select CoreID from user where ClanID=$TData[ClanID]");
			print mysql_error();
			while (list($ClanCoreID) = mysql_fetch_row($sth)) {
				$sth_int = mysql_query("insert into user_log (CoreID,Type,Message) values ($ClanCoreID,'Units Attacked','".str_replace("'","\'","$PlayerData->Username has attacked your $TData[Name] with some $WData[Name]s. They have killed $TDeath of your units and you have killed $WDeath of their units in self defence.")."')");
				print mysql_error();
			}
		}
	}


// Some of your warriors die in the battle
	if ($WData[Amount] >= 100 && $WData[Turns] >= 50 && $BuildingData[ClanID] == "" && $WData[Amount] > 100) {
		if ($AttackTile == "") {
			$sth = mysql_query("select OC.RowID,C.Name as ClanName,TD.Image,OC.TileID,OC.Armor,OC.ClanID from overlay_clan as OC left join clans as C on C.ClanID=OC.ClanID left join tiledata as TD on TD.TileID=OC.TileID where OC.ClanID != $PlayerData->ClanID and OC.X=$WData[X] and OC.Y=$WData[Y] and OC.MapID=$WData[MapID] and OC.TileID <= 1");
			while ($TData = mysql_fetch_array($sth)) {
				print "Attack: $TData[ClanName]'s tile. [ <A HREF=$SCRIPT_NAME?AttackTile=$TData[RowID]>Attack</A> ]<BR>";
			}
		} else {
			$sth = mysql_query("select C.Name as ClanName,TD.Image,OC.TileID,OC.Armor,OC.ClanID from overlay_clan as OC left join clans as C on C.ClanID=OC.ClanID left join tiledata as TD on TD.TileID=OC.TileID where OC.ClanID != $PlayerData->ClanID and OC.X=$WData[X] and OC.Y=$WData[Y] and OC.MapID=$WData[MapID] and OC.TileID <= 1 and OC.RowID=$AttackTile");
			$TData = mysql_fetch_array($sth);

			print "<tr><td class=Header height=15>Battle Results</td></tr>";
			print "<tr><td valign=top>";
			
			$WData[Amount] = $WData[Amount] - 100;
			$WData[Turns] = $WData[Turns] - 50;
			$sth = mysql_query("update clan_warriors set Amount=Amount-100,Turns=Turns-50 where WID=$WData[WID]");
			print mysql_error();
			$sth = mysql_query("delete from overlay_clan where RowID=$AttackTile");
			print mysql_error();

			AddNews($PlayerData->ClanData->Name." clan has waged war on $TData[ClanName] clan! Land has been detroyed!");

			print "100 of your $WData[Name]s perish in the pitched battle with the residents of the $TData[ClanName] clan peasants. In the end you are victorious though. The land is once again unowned!";
				
			print "</td></tr>";
	
			$sth = mysql_query("select CoreID from user where ClanID=$TData[ClanID]");
			print mysql_error();
			while (list($ClanCoreID) = mysql_fetch_row($sth)) {
				$sth_int = mysql_query("insert into user_log (CoreID,Type,Message) values ($ClanCoreID,'Land Lost','".str_replace("'","\'","$PlayerData->Username has laid siege on your guilds land at $WData[X],$WData[Y].")."')");
				print mysql_error();
			}
		}
	}

// merge two groups of soldiers
	$sth = mysql_query("select cb.ClanID,cb.Armor,cb.KeyID,cb.Flags,b.*,td.Image from clan_buildings as cb left join buildings as b on b.BID=cb.BID left join tiledata as td on td.TileID=b.TileID where cb.X=$WData[X] and cb.Y=$WData[Y] and cb.MapID=$WData[MapID] and cb.ClanID != $PlayerData->ClanID");
	if (mysql_num_rows($sth) > 0) {
		$BuildingData = mysql_fetch_array($sth);

		if ($Attack == "Y" && $WData[Turns] >= 10) {
			$sth = mysql_query("update clan_warriors set Turns=Turns-10 where WID=$WData[WID]");
			$Damage = floor(($WData[Strength] * $WData[Amount]) * .1);
			if ($Damage > $BuildingData[Armor]) {
				$sth = mysql_query("select CoreID from user ClanID=$BuildingData[ClanID]");
				print mysql_error();
				while (list($ClanCoreID) = mysql_fetch_row($sth)) {
					$sth_int = mysql_query("insert into user_log (CoreID,Type,Message) values ($ClanCoreID,'Building Destroyed','$PlayerData->Username has attacked your $BuildingData[Name] with $WData[Amount] $WData[Name]s and has destroyed it!')");
					print mysql_error();
				}
				$sth = mysql_query("delete from clan_buildings where KeyID=$BuildingData[KeyID]");
				print mysql_error();
				print "You have destroyed this building!<BR>";
			} else {
				$sth = mysql_query("select CoreID from user where ClanID=$BuildingData[ClanID]");
				print mysql_error();
				while (list($ClanCoreID) = mysql_fetch_row($sth)) {
					$sth_int = mysql_query("insert into user_log (CoreID,Type,Message) values ($ClanCoreID,'Building Damage','$PlayerData->Username has attacked your $BuildingData[Name] with $WData[Amount] $WData[Name]s and has done $Damage units of damage')");
					print mysql_error();
				}
				$sth = mysql_query("update clan_buildings set Armor=Armor-$Damage where KeyID=$BuildingData[KeyID]");
				print mysql_error();
				print "You have done $Damage damage to this building!<BR>";
			}
		} else {
			if ($WData[Turns] >= 10) { print "<A HREF=$SCRIPT_NAME?Attack=Y>ATTACK</A> ($BuildingData[Armor] armor)"; }
		}
	} else {
		$sth = mysql_query("select * from clan_warriors where ClanID=$PlayerData->ClanID and WID != $PlayerData->WID and WarriorID=$WData[WarriorID] and X=$WData[X] and Y=$WData[Y] and MapID=$WData[MapID]");
		if (mysql_num_rows($sth) > 0) {
			$MData = mysql_fetch_array($sth);
			$sth = mysql_query("select * from user where WID=$MData[WID]");
			if (mysql_num_rows($sth) == 0) {
				if ($Merge == "Y") {
					$sth = mysql_query("update clan_warriors set Amount=Amount + $MData[Amount] where WID=$PlayerData->WID");
					print mysql_error();
					$sth = mysql_query("delete from clan_warriors where WID=$MData[WID]");
					print mysql_error();
				} else {
					print "Would you like to merge these units? ";
					print "<A HREF=$SCRIPT_NAME?Merge=Y>Merge</A>";
				}
			}
		} else {
			if ($Split > 0 && intval($NumSplit) < $WData[Amount] && intval($NumSplit) > 0) {
				$NumSplit = intval($Split);
// split soldiers
				$sth = mysql_query("insert into clan_warriors (WarriorID,ClanID,X,Y,MapID,Amount) values ($WData[WarriorID],$WData[ClanID],$WData[X],$WData[Y],$WData[MapID],$NumSplit)");
				print mysql_error();
				$sth = mysql_query("update clan_warriors set Amount=Amount-$NumSplit where WID=$PlayerData->WID");
				print mysql_error();
			} else {
				print "<TR><TD HEIGHT=15 CLASS=HEADER>Split</TD></TR>";
				print "<TR><TD valign=top>";
				print "Would you like to split your units up? The new group will have zero turns.<BR>";
				print "<FORM ACTION=$SCRIPT_NAME>";
				print "<INPUT TYPE=TEXT SIZE=5 MAXLENGTH=5 NAME=Split>";
				print "<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=SUBMIT>";
				print "</FORM>";
				print "</TD></TR>";
			}
		}
	}
	print "</table><p>";
}


$sth = mysql_query("select td.Image,c.Name as ClanName,w.Name,cw.Amount from clan_warriors as cw left join clans as c on c.ClanID=cw.ClanID left join warriors as w on w.WarriorID=cw.WarriorID left join tiledata as td on td.TileID=w.TileID where cw.X=$Player_X and cw.Y=$Player_Y and cw.MapID=$Player_MapID");
print mysql_error();
if (mysql_num_rows($sth) > 0) {
	print "<table border=0 class=box3 WIDTH=468>";
	print "<tr><td class=Header height=15 colspan=4>Clan Warriors in the Area</td></tr>";
	print "<tr><td class=Menu>&nbsp;</td><Td class=menu>Clan Name</td><td class=Menu>Warrior Name</td><Td class=Menu>Count</td></tr>";
	while ($WData = mysql_fetch_array($sth)) {
		print "<tr><td width=30><IMG SRC=./images/tiles/$WData[Image]></td><td>$WData[ClanName]</td><td>$WData[Name]</td><td>$WData[Amount]</td></tr>";
	}
	print "</table><p>";
}

?>