<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
global $db,$PlayerData,$CoreUserData,$GetCorpseObj;

include ("./system/dispitem.php");

// Shows a corpse when a player dies in battle
if ($GetCorpseObj > 0) {
        $sth = mysql_query("select I.*,IB.Name,IB.Image,IB.MaxStack,IB.WeaponType,IB.WearSlot,IB.Use_Effect,IB.Create_ItemID,IB.ItemType from items as I left join items_base as IB on IB.ItemID=I.ItemID where I.X=$PlayerData->X and I.Y=$PlayerData->Y and I.MapID=$PlayerData->MapID and I.OwnerID=0 and I.ObjectID=$GetCorpseObj");
        print mysql_error();
        if (mysql_num_rows($sth) > 0) {
                $ItemData = mysql_fetch_array($sth);
		$sth = mysql_query("select * from monster where Killer_CoreID=$PlayerData->CoreID and X=$PlayerData->X and Y=$PlayerData->Y");
		if (mysql_num_rows($sth) > 0) {
	                if ($ItemData[ItemStack] < 1) { $ItemData[ItemStack] = 1; }
	                if ($ItemData[MaxStack] < 1) { $ItemData[MaxStack] = 1; }
	                if ($ItemData[ItemType] == "Potion" || $ItemData[ItemType] == "Usable" || $ItemData[ItemType] == "Misc") {
	                        $sth = mysql_query("select ObjectID from items where OwnerID=$PlayerData->CoreID and ItemID=$ItemData[ItemID] and ItemStack < $ItemData[MaxStack]");
	                        if (mysql_num_rows($sth) > 0) {
	                                list($ObjID) = mysql_fetch_row($sth);
	                                $sth = mysql_query("update items set ItemStack=ItemStack+$ItemData[ItemStack] where ObjectID=$ObjID");
									print mysql_error();
	                                $sth = mysql_query("delete from items where ObjectID=$GetCorpseObj");
									print mysql_error();
	                        } else {
	                                $sth = mysql_query("update items set OwnerID=$PlayerData->CoreID where ObjectID=$GetCorpseObj");
	                        }
	                } else {
	                        $sth = mysql_query("update items set OwnerID=$PlayerData->CoreID where ObjectID=$GetCorpseObj");
	                        print mysql_error();
	                }
	                print "You've picked up the object.<BR>";
		} else {
			print "Access Denied<BR>";
		}
	} else {
			print "Error: We were unable to locate that object<br>";
	}

}




// Shows items left on ground after death
$sth_corpse = mysql_query("select M.*,MB.Name from monster as M left join monster_base as MB on MB.MonsterID=M.MonsterID where M.HealthCur=0 and M.X=$PlayerData->X and M.Y=$PlayerData->Y and M.MapID=$PlayerData->MapID and M.Killer_CoreID=$PlayerData[CoreID] and M.DecayTime > NOW()");
print mysql_error();

if (mysql_num_rows($sth_corpse) > 0) {
	while ($data_corpse = mysql_fetch_array($sth_corpse)) {
		$sth = mysql_query("select I.*,IB.Name,IB.Image,IB.MaxStack,IB.WeaponType from items as I left join items_base as IB on IB.ItemID=I.ItemID where I.X=$PlayerData->X and I.Y=$PlayerData->Data[Y]' and I.SpawnID=$data_corpse[SpawnID] and I.OwnerID=0");
		print mysql_error();
		while ($data = mysql_fetch_array($sth)) {
			if ($CurItem > 0) {
				print "<IMG SRC=./i/nav_spacer.jpg WIDTH=300 HEIGHT=6><BR>";
			} else {
				print "<table border=0 cellpadding=0 cellspacing=0>";
				print "<tr>";
				print "<td><img src=./i/top_l.jpg></td>";
				print "<td background=./i/top_c.jpg><img src=./i/top_c.jpg></td>";
				print "<td><img src=./i/top_r.jpg></td>";
				print "</tr>";
				print "<tr><td background=./i/left.jpg><img src=./i/left.jpg></td><td>";
				print "<b>The following items reside on the $data_corpse[Name]'s corpse:</b><br>";
		
				$CurItem = 1;
			}	
			print "<TABLE BORDER=0 WIDTH=100%>";
			print "<TR>";
			print "<TD VALIGN=TOP><IMG SRC=./images/items/$data[Image] width=50 height=50><BR><A class=\"sidelink\" HREF=$SCRIPT_NAME?GetCorpseObj=$data[ObjectID]>Pick up</A><TD>";
			print "<TD VALIGN=TOP>";

			DispItem($data[ObjectID]);

		
			print "</TD></TR>";
			print "</TABLE>";
		}
		if ($CurItem == 1) {
			print "</td><td background=./i/right.jpg><img src=./i/right.jpg></td></tr>";
		
			print "<tr>";
			print "<td><img src=./i/bottom_l.jpg></td>";
			print "<td background=./i/bottom_c.jpg><img src=./i/bottom_c.jpg></td>";
			print "<td><img src=./i/bottom_r.jpg></td>";
			print "</tr>";
			
			print "</table>";
		}
	}
}
?>