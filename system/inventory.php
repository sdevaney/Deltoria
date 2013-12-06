<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2009 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Future enable fort drops, max items you can carry
global $db,$PlayerData;
$FortDrop = "N";
$MaxItems = 30;
// Salvage items
if ($Salvage > 0 && $Accept != "Y") {
	$sth = mysql_query("select I.*,IB.Name,T.Image,IB.Stackable,IB.SkillID,S.Name as SkillName,IB.WearSlot,IB.Use_Effect,IB.ItemType from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.CoreID=$PlayerData->CoreID and I.ObjectID=$Salvage");
	$data = mysql_fetch_array($sth);
	print "<TABLE width=330 BORDER=0 CLASS=Box1>";
	print "<TR><TD CLASS=HEADER>Are you sure?</TD></TR>";
	print "<TR><TD>";
	print "<table border=0 class=pagecontainer><tr><td width=35 class=pageCell>";
	print "<IMG SRC=./images/tiles/$data[Image] WIDTH=35 HEIGHT=35 ALT=$data[ItemID]>";
	print "</td><td class=pageCell>";
	DispItem($data[ObjectID]);
	print "</td></tr></table>";
	print "<P>Are you positive that you want to salvage your $data[Name]?<P><DIV ALIGN=RIGHT>";
	print "<A HREF=$SCRIPT_NAME?Salvage=$Salvage&Accept=Y&ItemType=$ItemType><IMG SRC=./images/buttons/yes.jpg BORDER=0></A>";
	print "<A HREF=$SCRIPT_NAME><IMG SRC=./images/buttons/no.jpg BORDER=0></A></DIV>";
	print "</TD></TR></TABLE><P>";
} elseif ($Salvage > 0 && $Accept == "Y") {
	$sth = mysql_query("select I.*,IB.Name,T.Image,IB.Stackable,IB.SkillID,S.Name as SkillName,IB.WearSlot,IB.Use_Effect,IB.ItemType, 
IB.Salvage_Price from items 
as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.CoreID=$PlayerData->CoreID and I.ObjectID=$Salvage");
	$data = mysql_fetch_array($sth);
	print "<TABLE width=330 BORDER=0 CLASS=Box1>";
	print "<TR><TD CLASS=HEADER>Salvaged</TD></TR>";
	print "<TR><TD>";
	print "<table border=0 class=pagecontainer><tr><td width=35 class=pageCell>";
	print "<IMG SRC=./images/tiles/$data[Image] WIDTH=35 HEIGHT=35 ALT=$data[ItemID]>";
	print "</td><td class=pageCell>";
	DispItem($data[ObjectID]);
	print "</td></tr></table>";
	print "<P>Your $data[Name] has been salvaged for ".($data[Salvage_Price] * $data[ItemStack])." coins.<P>";
	print "</TD></TR></TABLE><P>";
	$sth = mysql_query("delete from items where CoreID=$PlayerData->CoreID and ObjectID=$Salvage");
	print mysql_error();
	$sth = mysql_query("delete from itemspells where ObjectID=$Salvage");
	print mysql_error();
	$sth = mysql_query("update user set Coins=Coins+".($data[Salvage_Price] * $data[ItemStack])." where CoreID=$PlayerData->CoreID");
	print mysql_error();
}
// Fort vault not in game yet
if ($FortDrop == "Y") {
	print "<b><FONT COLOR=WHITE>Notice:</FONT></b> You're on a fort. To access your fort inventory click <B><A CLASS=sidelink HREF=fort_inv.php>here</A></b>.<P>";
}

$sth = mysql_query("select ItemID from items where CoreID=$PlayerData->CoreID and Banked='N'");
print mysql_error();
$NumbItems = mysql_num_rows($sth);

if ($DropToFort != "" && $FortDrop == "Y") {
	$sth = mysql_query("update items set Equiped='N',Banked='N' where ObjectID=$DropToFort and CoreID=$PlayerData->CoreID and Banked='N'");
	print mysql_error();
	print "Item has been placed in the fort.<BR>";
}

// Equip items
if ($WearObj > 0) {
	$sth = mysql_query("select I.*,IB.Name,T.Image,IB.Stackable,IB.SkillID,S.Name as SkillName, IB.Subscriber as Subitem, IB.WearSlot,IB.Use_Effect,IB.ItemType, IB.Defined_LevelReq as LevelReq from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.CoreID=$PlayerData->CoreID and I.Banked='N' and I.ObjectID=$WearObj");
	$data = mysql_fetch_array($sth);

	$SkillName = $data[SkillName];
	if ($data[ItemType] == "Weapon" && $PlayerData->GetSkillLevelByName($SkillName) <= 0) {
		print "Sorry but you are not trained in the use of this weapon.<BR>";
	} elseif ($data[LevelReq] > $PlayerData->Level ){
		print "You are not of the required level needed to wield that item.<BR>";
	} elseif ($data[Subitem] != $PlayerData->Subscriber && $data[Subitem] == 'Y') {
		print "You need to be a subscriber to equip this item.<BR>";
	} else {	
		if ($PlayerData->WearSlotAvailable($data[WearSlot]) == 1) {
			$PlayerData->Inventory[$WearObj]->Equiped='Y';
			$sth = mysql_query("update items set Equiped='Y' where ObjectID=$WearObj");
		}
	}
}
// Unequip items
if ($RemoveObj > 0) {
	$sth = mysql_query("update items set Equiped='N' where ObjectID=$RemoveObj and CoreID=$PlayerData->CoreID and Banked='N'");
	$PlayerData->Inventory[$WearObj]->Equiped='N';
}


// Useable items
if ($UseObj > 0) 
{
	$sth = mysql_query("select I.*,IB.Subscriber,IB.Admin,IB.Multistep,IB.Name,IB.Defined_LevelReq, T.Image,IB.Stackable,IB.SkillID,S.Name as SkillName,IB.WearSlot,IB.Use_Effect from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.ObjectID=$UseObj and I.CoreID=$PlayerData->CoreID and I.Banked='N'");
	print mysql_error();
	if (mysql_num_rows($sth) > 0) 
	{
		$data = mysql_fetch_array($sth);
		if ($PlayerData->Admin != "Y" && $data[Admin] == "Y") 
		{
			print "You don't have permission to use this item.";
		} 
		elseif ($PlayerData->Subscriber != "Y" && $data[Subscriber] == "Y") 
		{
			print "This item is limited to subscribers only.";
		}
		elseif ($data[Defined_LevelReq] > $PlayerData->Level)
		{
			print "You are too low level to use that.";
		} 
		else 
		{
			$StepEnd = "N";
			$EndStep = "N";
			eval($data[Use_Effect]);
			print "<br>";
			if ($data[Multistep] == "N" || ($data[Multistep] == "Y" && ($StepEnd == "Y" || $EndStep == "Y"))) 
			{
				if ($data[ItemStack] > 1) 
				{ 
					$sth = mysql_query("update items set ItemStack=ItemStack-1 where ObjectID=$data[ObjectID]");
				} 
				else 
				{
					$sth = mysql_query("delete from items where ObjectID=$data[ObjectID]");
				}
			}
		}
	} 
	else 
	{
		print "We're unable to locate that item.";
	}
}
// Drop item to ground like when you want to give to another player
if (intval($DropObj) > 0 && $Auth != "Y") {
	$sth = mysql_query("select I.*,IB.Name,T.Image,IB.Stackable,IB.SkillID,S.Name as SkillName,IB.WearSlot,IB.Use_Effect,IB.ItemType,IB.Droppable from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.CoreID=$PlayerData->CoreID and I.ObjectID=$DropObj and I.Banked='N'");
	$data = mysql_fetch_array($sth);
	print "<TABLE width=330 BORDER=0 CLASS=Box1>";
	print "<TR><TD CLASS=HEADER>Are you sure?</TD></TR>";
	print "<TR><TD>";
	print "<table border=0 class=pagecontainer><tr><td width=35 class=pageCell>";
	print "<IMG SRC=./images/tiles/$data[Image] WIDTH=35 HEIGHT=35 ALT=$data[ItemID]>";
	print "</td><td class=pageCell>";
	DispItem($data[ObjectID]);
	print "</td></tr></table>";

	if ($data[Droppable] == "Y") {
		if ($data[ItemStack] > 1) {
			print "<P>You have many of those items in this stack. How many do you wish to drop? You have $data[ItemStack] presently.<BR>";
			print "<FORM ACTION=$SCRIPT_NAME>";
			print "<INPUT TYPE=HIDDEN NAME=DropObj VALUE=$DropObj>";
			print "<INPUT TYPE=HIDDEN NAME=Auth VALUE=Y>";
			print "<B>Amount: </B> <INPUT TYPE=TEXT SIZE=3 MAXLEGTH=3 NAME=DropAmount VALUE=$data[ItemStack]>";
			print "<INPUT TYPE=SUBMIT VALUE=Drop NAME=SUBMIT>";
			print "</FORM>";
		} else {
			print "<P>Are you positive that you want to drop your $data[Name] to the ground?<P><DIV ALIGN=RIGHT>";
			print "<A HREF=$SCRIPT_NAME?DropObj=$DropObj&Auth=Y&ItemType=$ItemType><IMG SRC=./images/buttons/yes.jpg BORDER=0></A>";
			print "<A HREF=$SCRIPT_NAME?ItemType=$ItemType><IMG SRC=./images/buttons/no.jpg BORDER=0></A></DIV>";
		}
	} else {
		print "I'm sorry but you can't drop that item.<BR>";
	}
	print "</TD></TR></TABLE><P>";
} elseif (intval($DropObj) > 0 && $Auth == "Y") {
	$sth = mysql_query("select I.*,IB.Name,T.Image,IB.Stackable,IB.SkillID,S.Name as SkillName,IB.WearSlot,IB.Use_Effect,IB.ItemType,IB.Droppable from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.CoreID=$PlayerData->CoreID and I.ObjectID=$DropObj and I.Banked='N'");
	$data = mysql_fetch_array($sth);
	print "<TABLE width=330 BORDER=0 CLASS=Box1>";
	print "<TR><TD CLASS=HEADER>Dropping your $data[Name]</TD></TR>";
	print "<TR><TD>";
	print "<table border=0 class=pagecontainer><tr><td width=35 class=pageCell>";
	print "<IMG SRC=./images/tiles/$data[Image] WIDTH=35 HEIGHT=35 ALT=$data[ItemID]>";
	print "</td><td class=pageCell>";
	DispItem($data[ObjectID]);
	print "</td></tr></table>";

	if ($data[Droppable] == "Y") {
		$sth = mysql_query("select * from items where CoreID=$PlayerData->CoreID and ObjectID=$DropObj and Banked='N'");
		print mysql_error();
		if (mysql_num_rows($sth) > 0) {
	// Drop a stack of items
			if ($data[ItemStack] <= 1 || $data[ItemStack] == $DropAmount) {
				$sth = mysql_query("update items set Equiped='N',CoreID=0,X=$PlayerData->X,Y=$PlayerData->Y,MapID=$PlayerData->MapID,DecayTime=DATE_ADD(NOW(),INTERVAL 20 MINUTE) where ObjectID=$DropObj");
				print mysql_error();
				print "You've dropped this object.<BR>";
			} elseif ($data[ItemStack] > 1 && $DropAmount < $data[ItemStack] && intval($DropAmount) > 0) {
				$ItemID = LootGen(0,0,$PlayerData->X,$PlayerData->Y,$PlayerData->MapID,$data[ItemID],1,$DropAmount,1);
				$sth = mysql_query("update items set ItemStack=ItemStack-$DropAmount where ObjectID=$DropObj and ItemStack > $DropAmount");
				print mysql_error();
				print "You've dropped $DropAmount this object.<BR>";
			} else {
				print "Unable to drop that many!";
			}
		} else {
			print "Error: We were unable to locate that object<br>";
		}
	} else {
		print "I'm sorry but you can't drop that item.<BR>";
	}
	print "</TD></TR></TABLE><P>";
}
// Use the item
if ($UseSource > 0 && $UseTarget > 0) {
	$sth = mysql_query("select I.*,IB.Name from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.CoreID=$PlayerData->CoreID and I.Banked='N' and I.ObjectID=$UseSource order by I.Equiped DESC");
	$SourceData = mysql_fetch_array($sth);

	$sth = mysql_query("select I.*,IB.Name from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.CoreID=$PlayerData->CoreID and I.Banked='N' and I.ObjectID=$UseTarget order by I.Equiped DESC");
	$TargetData = mysql_fetch_array($sth);
// Combining items
	if ($SourceData[ObjectID] > 0 && $TargetData[ObjectID] > 0) {
		$ItemAmt = "Y";
		$sth = mysql_query("select * from items_merge where ItemA=$SourceData[ItemID] and ItemB=$TargetData[ItemID]");
		if ($SourceData[ItemID] == $TargetData[ItemID]) {
			$ItemCount = mysql_query("select ItemStack, CoreID, ItemID from items where CoreID = $PlayerData->CoreID && ItemID = $SourceData[ItemID]");
			$ItemData = mysql_fetch_array($ItemCount);
			if (($ItemData[ItemStack] < 2) && (mysql_num_rows($ItemCount) < 2)) {
				print "You do not have enough of the item to combine them";
				$ItemAmt = "N";
			}
		}
		if ((mysql_num_rows($sth) > 0)  && ($ItemAmt == "Y")) {
			$MergeData = mysql_fetch_array($sth);
// If they combine you get new item. If you fail possible destory of usable item.
			$Success = "Y";
			if ($MergeData[SkillLevel] > 0) {
				if (SkillCheck($PlayerData->GetSkillLevelByID($MergeData[SkillID]),$MergeData[SkillLevel]) == 0) { $Success = "N"; }
			}

			if ($MergeData[PreserveItemB] != "Y") {
				if ($TargetData[ItemStack] > 1) {
					$sth_del = mysql_query("update items set ItemStack=ItemStack-1 where ObjectID=$TargetData[ObjectID] and ItemStack > 1");
					print mysql_error();
					$TargetData[ItemStack]--;
					if ($TargetData[ObjectID] == $SourceData[ObjectID]) { $SourceData[ItemStack]--; }
				} else {
					$sth_del = mysql_query("delete from items where ObjectID=$TargetData[ObjectID]");
					print mysql_error();
				}
			}
	

			if ($MergeData[PreserveItemA] != "Y") {
				if ($SourceData[ItemStack] > 1) {
					$sth_del = mysql_query("update items set ItemStack=ItemStack-1 where ObjectID=$SourceData[ObjectID] and ItemStack > 1");
					print mysql_error();
				} else {
					$sth_del = mysql_query("delete from items where ObjectID=$SourceData[ObjectID]");
					print mysql_error();
				}
			}

			if ($Success == "Y") {
				$sth_comb = mysql_query("select * from items_base where ItemID=$MergeData[ResultID]");
				$NewData = mysql_fetch_array($sth_comb);
				print "You combine your $SourceData[Name] with your $TargetData[Name] and create a $NewData[Name]<BR>";
				LootGen(0,$PlayerData->CoreID,$PlayerData->X,$PlayerData->Y,$PlayerData->MapID,$MergeData[ResultID],1,1,0);
			} else {
				print "You have failed to combine your $SourceData[Name] with your $TargetData[Name]<BR>";
			}
		}
	}
}

$CurItem = 0;


print "<table border=0 class=Box1 width=330 cellpading=0 cellspacing=0>";
print " <TR>";
print "<TD COLSPAN=3>";


print "<TABLE BORDER=0 CLASS=pageContainer WIDTH=100%>";
print "<TR>";

if ($ItemType == "Equiped") {
	print "  <TD CLASS=MENU>Equipped</TD>";
} else {
	print "  <TD CLASS=HEADER><A HREF=$SCRIPT_NAME?ItemType=Equiped>Equipped</A></TD>";
}

if ($ItemType != "Equiped") {
	print "  <TD CLASS=MENU>Non-Equipped</TD>";
} else {
	print "  <TD CLASS=HEADER><A HREF=$SCRIPT_NAME?ItemType=NonEquiped>Non-Equipped</A></TD>";
}

/*
if ($ItemType == "1") {
	print "  <TD CLASS=MENU NOWRAP>Pack 1</TD>";
} else {
	print "  <TD CLASS=HEADER><A HREF=$SCRIPT_NAME?ItemType=1>Pack 1</A></TD>";
}
*/


print "</TR></TABLE>";






print " </TD></TR>";


if ($ItemType == "Equiped") { 
	$sth = mysql_query("select I.*,IB.Description,IB.Droppable,IB.Name,T.Image,IB.Stackable,IB.SkillID,S.Name as SkillName,IB.WearSlot,IB.Use_Effect,IB.ItemType from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.CoreID=$PlayerData->CoreID and I.Banked='N' and I.Equiped='Y' order by IB.ItemType,IB.Name");
} else {
	$sth = mysql_query("select I.*,IB.Description,IB.Droppable,IB.Name,T.Image,IB.Stackable,IB.SkillID,S.Name as SkillName,IB.WearSlot,IB.Use_Effect,IB.ItemType from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.CoreID=$PlayerData->CoreID and I.Banked='N' and I.Equiped='N' order by IB.Name");
}
print mysql_error();

while ($data = mysql_fetch_array($sth)) {
	print "<TR><TD VALIGN=TOP class=pageCell width=1 NOWRAP>";
	if ($data[Equiped] == "Y") {
		if ($data[ItemType] == "Weapon") {
			print "<b>Equiped</b><br>";
		} else {
			print "<b>Worn</b><br>";
		}
	}
	print "<IMG SRC=./images/tiles/$data[Image] WIDTH=35 HEIGHT=35 ALT=$data[ItemID]>";
	print "</TD><TD VALIGN=TOP class=PageCell>";
	DispItem($data[ObjectID]);

	$questread = "";
	$quester = 0;
	$sth_merge = mysql_query("select ItemA,ItemB,SkillID,SkillLevel,OptItem from items_merge as M where ItemA=$data[ItemID]");
	while (list($ItemA,$ItemB,$SkillID,$SkillLevel,$OptItem) = mysql_fetch_row($sth_merge)) {
		if ($ItemA == $data[ItemID]) {
			$SearchItem = $ItemB;
		} else {
			$SearchItem = $ItemA;
		}
		$sthtool = mysql_query("select * from items where ItemID=$OptItem && CoreID = $PlayerData->CoreID");
		if (($OptItem == 0) || (mysql_num_rows($sthtool) > 0)) {
			if (mysql_num_rows($sthtool) > 0) {
				$sthuse = mysql_query("select Use_Effect from items_base where ItemID = $OptItem");
				list($questr) = mysql_fetch_row($sthuse);
				if ($questr <> "") {
					$qarea = stristr($questr,"check_quest");
					$qstring = strstr($qarea,'"');
					$qquote = substr($qstring,1);
					$qcount = strpos($qquote,'"');
					$qname = substr($qquote,0,$qcount);
					if (Check_Quest($qname,$PlayerData->CoreID) == 1) {
						$questread = 1;
					} else {
						$quester = 1;
					}
				}
			} else {
				$questread = "";
			}
			if ($quester == 1) { 
				print "";
			 } elseif (($questread == 1) || ($questread == "" && $quester == 0)) {
				$sth_comb = mysql_query("select IB.Name,I.ObjectID from items as I left join items_base as IB on IB.ItemID=I.ItemID where I.CoreID=$PlayerData->CoreID and I.Banked='N' and I.ItemID=$SearchItem and (I.ObjectID != $data[ObjectID] || $data[ItemStack] > 1)");
				print mysql_error();
				if (mysql_num_rows($sth_comb) > 0) {
					$CombData = mysql_fetch_array($sth_comb);
					print "<BR><A class=\"sidelink\" HREF=inventory.php?UseSource=$data[ObjectID]&UseTarget=$CombData[ObjectID]&ItemType=$ItemType>Use this on your $CombData[Name]</A>";
					if ($SkillLevel > 0) { 
						print "<br>(Level $SkillLevel skill suggested)"; 
						$sthskill = mysql_query("select Name from skills where SkillID=$SkillID");
						list($SName) = mysql_fetch_row($sthskill);
						print "<br>($SName required)";
					}
				}
			}
		}
	}
	/*$sth_merge = mysql_query("select ItemA,ItemB,SkillID,SkillLevel from items_merge as M where ItemA=$data[ItemID]");
	while (list($ItemA,$ItemB,$SkillID,$SkillLevel) = mysql_fetch_row($sth_merge)) {
		if ($ItemA == $data[ItemID]) {
			$SearchItem = $ItemB;
		} else {
			$SearchItem = $ItemA;
		}
		$sth_comb = mysql_query("select IB.Name,I.ObjectID from items as I left join items_base as IB on IB.ItemID=I.ItemID where I.CoreID=$PlayerData->CoreID and I.Banked='N' and I.ItemID=$SearchItem and (I.ObjectID != $data[ObjectID] || $data[ItemStack] > 1)");
		print mysql_error();
		if (mysql_num_rows($sth_comb) > 0) {
			$CombData = mysql_fetch_array($sth_comb);
			print "<BR><A class=\"sidelink\" HREF=inventory.php?UseSource=$data[ObjectID]&UseTarget=$CombData[ObjectID]&ItemType=$ItemType>Use this on your $CombData[Name]</A>";
			if ($SkillLevel > 0) { 
				print "<br>(Level $SkillLevel skill suggested)"; 
				$sthskill = mysql_query("select Name from skills where SkillID=$SkillID");
				list($SName) = mysql_fetch_row($sthskill);
				print "<br>($SName required)";
			}
			
		}
	}*/

	// Different options for items
	print "</TD><TD valign=top class=pageCell>";

	if ($data[Droppable] == "Y") {
		print "<A class=\"sidelink\" HREF=inventory.php?DropObj=$data[ObjectID]&ItemType=$ItemType";
		if ($PlayerData->Confirm == "N" && $data[ItemStack] <= 1) { print "&Auth=Y"; }
		print "><IMG BORDER=0 SRC=./images/buttons/drop_to_ground.jpg></A><BR>";
	}
	if ($data[Use_Effect] != "") {
		print "<A class=\"sidelink\" HREF=inventory.php?UseObj=$data[ObjectID]&ItemType=$ItemType><IMG BORDER=0 SRC=./images/buttons/use_item.jpg></A><BR>";
	}
	if ($FortDrop == "Y") {
		print "<A class=\"sidelink\" HREF=inventory.php?DropToFort=$data[ObjectID]&ItemType=$ItemType><IMG BORDER=0 SRC=./images/buttons/put_in_fort.jpg></A><BR>";
	}

	print "<A class=\"sidelink\" HREF=$SCRIPT_NAME?Salvage=$data[ObjectID]&ItemType=$ItemType";
	if ($PlayerData->Confirm == "N") { print "&Accept=Y"; }
	print "><IMG BORDER=0 SRC=./images/buttons/convert_to_gold.jpg></A><BR>";

	if ($data[WearSlot] != "No" && $data[WearSlot] != "None" && $data[WearSlot] != "") {
		$data[WearSlot] = ereg_replace("\n","",$data[WearSlot]);
		$data[WearSlot] = ereg_replace("\r","",$data[WearSlot]);

		$SlotTaken = "N";
		$Splitter = split(" ",$data[WearSlot]);
		while (list($key,$val) = each ($Splitter)) {
			$val = ereg_replace(" ","",$val);
			if (!$PlayerData->WearSlotAvailable($data[WearSlot])) {
				$SlotTaken = "Y";
			}
		}
		reset($Splitter);
		if ($data[Equiped] == "N") {
			if ($SlotTaken == "N") {
				if ($data[ItemType] == "Weapon") {
					print "<A class=\"sidelink\" HREF=inventory.php?WearObj=$data[ObjectID]&ItemType=$ItemType><IMG BORDER=0 SRC=./images/buttons/wield.jpg></A><BR>";
				} else {
					print "<A class=\"sidelink\" HREF=inventory.php?WearObj=$data[ObjectID]&ItemType=$ItemType><IMG BORDER=0 SRC=./images/buttons/wear.jpg></A><BR>";
				}
			}
		} else {
			if ($data[ItemType] == "Weapon") {
				print "<A class=\"sidelink\" HREF=inventory.php?RemoveObj=$data[ObjectID]&ItemType=$ItemType><IMG BORDER=0 SRC=./images/buttons/unwield.jpg></A><BR>";
			} else {
				print "<A class=\"sidelink\" HREF=inventory.php?RemoveObj=$data[ObjectID]&ItemType=$ItemType><IMG BORDER=0 SRC=./images/buttons/unwear.jpg></A><BR>";
			}
		}

	}
	if ($data[Description] != "") { Description($data[Name],$data[Description]); }



	print "</TD></TR>";
	print "<tr><td colspan=3 class=pagecell><hr></td></tr>";

}
print "</TABLE><P>";


?>