<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
global $db,$PlayerData,$CoreUserData;

if ($_GET[GetObj] > 0) {
	GetObject($_GET[GetObj]);
}
// Salvage all objects from battle
if ($_GET[SalvageAll] == 1) {
	print "<table border=0 width=456 class=Box1>";
	print "<tr><Td class=header>Salvage</td></tr>";
	print "<Tr><td>";

	$sth = mysql_query("select ObjectID from items where CoreID=0 and Banked='N' and X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID");
	while ($data = mysql_fetch_array($sth)) {
		SalvageObject($data[ObjectID]);
	}

	print "</td></tr></table><p>";
}
// Pick up all objects from battle
if ($_GET[PickupAll] == 1) {
	print "<table border=0 width=456 class=Box1>";
	print "<tr><Td class=header>Pick up items</td></tr>";
	print "<Tr><td>";

	$sth = mysql_query("select ObjectID from items where Banked='N' and CoreID=0 and X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID");
	print mysql_error();
	while ($ItemData = mysql_fetch_array($sth)) {
		GetObject($ItemData[ObjectID]);
	}
	print "</td></tr></table><p>";
}


if ($PlayerData->WID == 0) {
	$sth = mysql_query("select o.Description,td.Image from overlay as o left join tiledata as td on td.TileID=o.TileID where Description != \"\" and X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID");
	if (mysql_num_rows($sth)  > 0) {
		$OverlayData = mysql_fetch_array($sth);
	
		$sth = mysql_query("select td.Image from map as o left join tiledata as td on td.TileID=o.TileID where X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID");
		if (mysql_num_rows($sth) > 0) { $MapData = mysql_fetch_array($sth); }
	
		print "<table border=0 width=456 class=Box1>";
		print "<tr><td class=Menu background=./images/tiles/$MapData[Image]><img src=./images/tiles/$OverlayData[Image]></td><td class=Header>$OverlayData[Description]</td></tr>";
		print "</table><p>";
	}
	
	$sth = mysql_query("select I.*,IB.Name,T.Image,S.Name as SkillName,IB.Stackable,IB.SkillID from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.CoreID=0 and Banked='N' and I.X=$PlayerData->X and I.Y=$PlayerData->Y and I.MapID=$PlayerData->MapID");
	if (mysql_num_rows($sth) > 0) {
		print "<table border=1 class=box1 width=100%>";
		print "<tr><td class=Header colspan=2>Items Detected</td></tr>";
		while ($data = mysql_fetch_array($sth)) {
			print "<tr>";
			print "<TD VALIGN=TOP><IMG SRC=./images/tiles/$data[Image] WIDTH=35 HEIGHT=35><BR><A class=\"sidelink\" HREF=$SCRIPT_NAME?GetObj=$data[ObjectID]>Pick up</A></TD>";
			print "<TD VALIGN=TOP>";
			DispItem($data[ObjectID]);
			print "</TD></TR>";
		}
		if (mysql_num_rows($sth) > 0) {
			print "<tr><td colspan=2>";
			print "<A HREF=$SCRIPT_NAME?PickupAll=1><img border=0 src=./images/buttons/pickupall.jpg></A>";
			print "<A HREF=$SCRIPT_NAME?SalvageAll=1><img border=0 src=./images/buttons/salvageall.jpg></A>";
			print "</td></tr>";
		}
		print "</table><p>";
	}
}
// Salvage individual object
function SalvageObject($ObjectID) {
	global $PlayerData;
	$sth = mysql_query("select I.*,IB.Name,T.Image,IB.Stackable,IB.SkillID,S.Name as SkillName,IB.WearSlot,IB.Use_Effect,IB.ItemType, IB.Salvage_Price from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.CoreID=0 and I.Banked='N' and X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID and ObjectID=$ObjectID");
	if (mysql_error()) { print mysql_error(); }
	while ($data = mysql_fetch_array($sth)) {
		$Counted = $data[ItemStack];
		if ($Counted < 1) { $Counted = 1; }

		if ($_GET[SalvageAll] == "") {
			print "<table border=0 width=456 class=Box1>";
			print "<tr><Td class=header>Salvage</td></tr>";
			print "<Tr><td>";
		}

		print "The $data[Name] has been salvaged for ".($data[Salvage_Price] * $Counted)." coins.<BR>";
		$sth_del = mysql_query("delete from items where ObjectID=$data[ObjectID]");
		print mysql_error();
		$sth_del = mysql_query("delete from itemspells where ObjectID=$data[ObjectID]");
		print mysql_error();
		$sth_update = mysql_query("update user set Coins=Coins+".($data[Salvage_Price] * $Counted)." where CoreID=$PlayerData->CoreID");
		print mysql_error();

		if ($_GET[SalvageAll] == "") {
			print "</td></tr>";
			print "</table><p>";
		}
	}
}

// Pickup individual object
function GetObject ($ObjectID) {
	global $PlayerData;

	if ($_GET[PickupAll] == "") {
		print "<table border=0 width=456 class=Box1>";
		print "<tr><Td class=header>Pick up items</td></tr>";
		print "<Tr><td>";
	}
// Make sure player has enough space in their inventory
	if ($PlayerData->Subscriber == 'Y') {
		$sth = mysql_query("select ItemID from items where CoreID=$PlayerData->CoreID and Banked='N' and ItemID NOT IN (Select ItemID from items_base where ItemType ='Tool')");
	} else {
		$sth = mysql_query("select ItemID from items where CoreID=$PlayerData->CoreID and Banked='N'");
	}
	if (mysql_num_rows($sth) >= $PlayerData->InvenSpace) {
		print "Error: You can only hold up to $PlayerData->InvenSpace items!<BR>";
	} else {
		$sth = mysql_query("select I.*,IB.Name,T.Image,IB.Stackable,IB.SkillID,S.Name as SkillName,IB.WearSlot,IB.Use_Effect,IB.ItemType from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as T on T.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.Banked='N' and I.CoreID=0 and I.X=$PlayerData->X and I.Y=$PlayerData->Y and I.MapID=$PlayerData->MapID and I.ObjectID=$ObjectID");
	if (mysql_error()) { print mysql_error(); }
		if (mysql_num_rows($sth) > 0) {
			$ItemData = mysql_fetch_array($sth);
			$sth = mysql_query("select ObjectID from items where CoreID=$PlayerData->CoreID and ItemID=$ItemData[ItemID] and Banked='N'");
			if (mysql_num_rows($sth) > 0 && $ItemData[Stackable] == "Y") {
				list($ObjID) = mysql_fetch_row($sth);
				$sth_update = mysql_query("update items set ItemStack=ItemStack+$ItemData[ItemStack] where ObjectID=$ObjID");
				print mysql_error();
				$sth_del = mysql_query("delete from items where ObjectID=$ObjectID");
				print mysql_error();
			} else {
				$sth_update = mysql_query("update items set CoreID=$PlayerData->CoreID,Equiped='N' where ObjectID=$ObjectID");
				print mysql_error();
			}
			print "You've picked up the $ItemData[Name].<BR>";
		} else {
				print "Error: We were unable to locate that object<br>";
		}
	}

	if ($_GET[PickupAll] == "") {
		print "</td></tr></table><p>";
	}

}

?>
