<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2009 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
global $db,$CoreUserData,$SCRIPT_NAME,$PlayerData;

// Give item to NPC as in quest or something else
	if ($ActorGive != "") {
		$sth = mysql_query("select M.*,B.*,TD.Image from monster as M left join monster_base as B on B.MonsterID=M.MonsterID left join tiledata as TD on TD.TileID=B.TileID where M.X=$PlayerData->X and M.Y=$PlayerData->Y and M.MapID=$PlayerData->MapID and M.HealthCur > 0 and B.Hostile='N' and M.SpawnID=$ActorGive");
		print mysql_error();
		if (mysql_num_rows($sth) > 0) {
			$MonsterData = mysql_fetch_array($sth);
			if ($MonsterData[MOD_EnterArea] != "" || $MonsterData[TELL_EnterArea]) {
				print "<table border=0 class=Box1>";
				print "<tr><td width=100 valign=top>";
				print "<img src=./images/tiles/$MonsterData[Image]><br>$MonsterData[Name]";

				$sth = mysql_query("select I.*,B.Name from items as I left join items_base as B on B.ItemID=I.ItemID where I.CoreID=$PlayerData->CoreID and I.ItemID=$ItemID and I.Banked='N'");
				$ItemData = mysql_fetch_array($sth);

				print "</td><td valign=top>";
				if ($ItemData[ItemID] > 0) {
					$sth = mysql_query("select * from questdata where Take_ItemID=$ItemID and MerchantID=$MonsterData[MerchantID] and QuestID=$Quest");
					print mysql_error();
					if (mysql_num_rows($sth) == 0) {
						print "This MOB doesn't take this type of item.<P>";
					} else {
						$QuestData = mysql_fetch_array($sth);
// Checks quest timer
						if (Check_Quest($QuestData[QuestID],$PlayerData->CoreID) == 1) {
							print "It is too soon before you may do this quest over again.<P>";
						} else {
							if ($QuestData[QuestTimer] > 0) {
								Set_Quest($QuestData[QuestID],$PlayerData->CoreID,$QuestData[QuestTimer]);
							}
							if ($QuestData[TELL_ItemGive] != "") { print $QuestData[TELL_ItemGive]."<P>"; }
							if ($QuestData[MOD_ItemGive] != "") { eval($QuestData[MOD_ItemGive]); print "<P>"; }
	
							if ($ItemData[ItemStack] > 1) {
								$sth = mysql_query("update items set ItemStack=ItemStack-1 where ItemID=$QuestData[Take_ItemID] and CoreID=$PlayerData->CoreID and ItemStack > 1 limit 1");
								print mysql_error();
							} else {
								$sth = mysql_query("delete from items where ItemID=$QuestData[Take_ItemID] and CoreID=$PlayerData->CoreID limit 1");
								print mysql_error();
							}
							
							if ($QuestData[Return_ItemID] > 0) {
								$RetGen = LootGen(0,$PlayerData->CoreID,$PlayerData->X,$PlayerData->Y,$PlayerData->MapID,$QuestData[Return_ItemID],$MonsterData[Level],1,$MonsterData[MagicSkill]);
								while ($RetGen == 0) {
									$RetGen = LootGen(0,$PlayerData->CoreID,$PlayerData->X,$PlayerData->Y,$PlayerData->MapID,$QuestData[Return_ItemID],$MonsterData[Level],1,$MonsterData[MagicSkill]);
								}
	// Try to give wrong item or dont have item NPC wants
								$sth = mysql_query("select I.*,IB.Name,T.Image,IB.Stackable,IB.SkillID,S.Name as SkillName,IB.WearSlot,IB.Use_Effect,IB.ItemType from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.CoreID=$PlayerData->CoreID and I.ObjectID=$RetGen");
								$data = mysql_fetch_array($sth);
								print "<TABLE width=330 BORDER=0 CLASS=Box1>";
								print "<TR><TD CLASS=HEADER>Item Returned</TD></TR>";
								print "<TR><TD>";
								print "<table border=0 class=pagecontainer><tr><td width=35 class=pageCell>";
								print "<IMG SRC=./images/tiles/$data[Image] WIDTH=35 HEIGHT=35 ALT=$data[ItemID]>";
								print "</td><td class=pageCell>";
								DispItem($RetGen);
								print "</td></tr></table>";
								print "</td></tr></table>";
							}
						}
					}
				} else {
					print "The $MonsterData[Name] looks at you and growls<P>";
					print "<I>You lousy cheater! You don't have that item!</I>";
				}
				print "</td></tr></table><P>";
			}
		} else {
			print "<FONT COLOR=RED>Notice:</FONT> We're unable to locate that target.<BR>";
		}
	
	}

	$sth = mysql_query("select M.*,B.*,TD.Image from monster as M left join monster_base as B on B.MonsterID=M.MonsterID left join tiledata as TD on TD.TileID=B.TileID where M.X=$PlayerData->X and M.Y=$PlayerData->Y and M.MapID=$PlayerData->MapID and M.HealthCur > 0 and B.Hostile='N'");
	print mysql_error();
	if (mysql_num_rows($sth) > 0) {
		$MonsterData = mysql_fetch_array($sth);
		if ($MonsterData[MOD_EnterArea] != "" || $MonsterData[TELL_EnterArea]) {
			print "<table border=0 width=456 class=Box1>";
			print "<Tr><td colspan=2 class=header>$MonsterData[Name]</td></tr>";
			print "<tr><td width=100 valign=top class=Menu>";
			print "<img src=./images/tiles/$MonsterData[Image]><br>";
			print "</td><td valign=top>";
// Buy from NPC
			if ($MerchantBuy > 0 && $Amount >= 1) {
				$sth = mysql_query("select * from merchantdata where MerchantID=$MonsterData[MerchantID] and ItemID=$MerchantBuy");
				if (mysql_num_rows($sth) > 0) {
					$sth = mysql_query("select * from items_base where ItemID=$MerchantBuy");
					$ItemData = mysql_fetch_array($sth);
					if ($ItemData[Defined_Value] * intval($Amount) > $PlayerData->Coins) {
						print "<P><B>You can't afford that!</B><BR>";
					} else {
						print "<P><B>You've purchased ".intval($Amount)." of that item.</B><BR>";
						$sth = mysql_query("update user set Coins=Coins-".($ItemData[Defined_Value] * intval($Amount))." where CoreID=$PlayerData->CoreID and Coins >= ".($ItemData[Defined_Value] * intval($Amount))."");
						$PlayerData->Coins = $PlayerData->Coins - ($ItemData[Defined_Value] * intval($Amount));
						LootGen(0,$PlayerData->CoreID,$PlayerData->X,$PlayerData->Y,$PlayerData->MapID,$MerchantBuy,1,$Amount,0);
					}
				}
			}


			$sth_quest = mysql_query("select QuestID,Take_ItemID,Return_ItemID from questdata where MerchantID=$MonsterData[MerchantID]");
			print mysql_error();
			if (mysql_num_rows($sth_quest) > 0) {
				$CountGive = 0;
				print "<center><br><table border=0 width=95% class=box1>";
				print "<tr><td colspan=4 class=Header>Give Options</td></tr>";
				print "<tr><td class=Menu>&nbsp;</td><Td class=menu>Give Item</tD><Td class=Menu>Get Item</td></tr>";
				while (list($QuestID,$Take_ItemID,$Return_ItemID) = mysql_fetch_row($sth_quest)) {
					if ($Return_ItemID == 0) {
						$Return_Name = "Reward";
					} else {
						$sth_get = mysql_query("select Name from items_base where ItemID=$Return_ItemID");
						list ($Return_Name) = mysql_fetch_row($sth_get);
					}
					$sth = mysql_query("select I.*,B.Name from items as I left join items_base as B on B.ItemID=I.ItemID where I.CoreID=$PlayerData->CoreID and I.ItemID=$Take_ItemID and I.Banked='N'");
					if (mysql_num_rows($sth) > 0) {
						$CountGive++;
						$ItemData = mysql_fetch_array($sth);
						print "<tr><td class=menu><a class=\"sidelink\" href=start.php?Quest=$QuestID&ActorGive=$MonsterData[SpawnID]&ItemID=$Take_ItemID>Give</A></td><td>$ItemData[Name]</td><td>$Return_Name.</td></tr>";
					}
				}
				print "<tr><td colspan=4 class=footer>$CountGive options listed</td></tr>";
				print "</table></center><p>";
			}

// Take quest from NPC
			if ($TakeQuest != "") {
				$sth = mysql_query("select * from questdata where MerchantID=$MonsterData[MerchantID] order by rand() limit 1");
				print mysql_error();
				if (mysql_num_rows($sth) > 0) {
					$QuestData = mysql_fetch_array($sth);
					print str_replace("\r\n\r\n","<P>",$QuestData[TELL_QuestGive]."<P>");
				}
			} else {
				if ($MonsterData[TELL_EnterArea] != "") { print $MonsterData[TELL_EnterArea]."<P>"; }
				if ($MonsterData[MOD_EnterArea] != "") { eval($MonsterData[MOD_EnterArea]); print "<P>"; }
			}

// Shows merchant info for NPC and what you can buy from them as well as your coins
			if ($MonsterData[MerchantID] > 0) {
				$sth = mysql_query("select IB.ItemID,IB.Name,IB.Defined_Value as Value from merchantdata as MD left join items_base as IB on IB.ItemID=MD.ItemID where MD.MerchantID=$MonsterData[MerchantID]");
				if (mysql_num_rows($sth) > 0) {
					print "<P>";
					print "<FORM ACTION=\"$SCRIPT_NAME\">";
					print "<B>Note:</B> You have ".number_format($PlayerData->Coins)." coin(s).<BR>";
					print "<SELECT NAME=MerchantBuy CLASS=formfield>";
					print mysql_error();
					while ($MerchantData = mysql_fetch_array($sth)) {
						print "<OPTION VALUE=\"$MerchantData[ItemID]\">$MerchantData[Name] ($MerchantData[Value])";
					}
					print "</SELECT><br><b>Amount: <input type=text name=Amount Value=1 size=4 maxlength=4><br>";
					print "<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Purchase CLASS=formfield></FORM>";
				}
				$sth = mysql_query("select * from questdata where Givable='Y' and MerchantID=$MonsterData[MerchantID]");
				if (mysql_num_rows($sth) > 0) {
					print "<A HREF=$SCRIPT_NAME?TakeQuest=$MonsterData[MerchantID]&RD=".rand(1,99999999)."><IMG BORDER=0 SRC=./images/buttons/request_quest.jpg></A><BR>";
				}
			}
			
			print "</td></tr></table><p>";
		}
	}
?>