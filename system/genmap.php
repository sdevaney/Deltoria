<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Generate Map and navigation area, can be adjusted to be bigger or smaller
function GenMap($Player_X, $Player_Y, $Player_MapID, $Width = 11, $Height = 11, $Player_UserPic) {
	$tiledir = "./images/tiles";



	$MinX = $Player_X - round($Width / 2);
	$MaxX = $Player_X + round($Width / 2);

	$MinY = $Player_Y - round($Height / 2);
	$MaxY = $Player_Y + round($Height / 2);

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

	$sth = mysql_query("select T.Image,M.* from overlay_clan as M left join tiledata as T on M.TileID=T.TileID where M.X >= $MinX and M.X <= $MaxX and M.Y >= $MinY and M.Y <= $MaxY and M.MapID=$Player_MapID");
	print mysql_error();
	while ($MData = mysql_fetch_array($sth)) {
		$MapX = $MData[X];
		$MapY = $MData[Y];
		if ($MData[Walkable] == "N") { $MapData[$MapX][$MapY][Walkable] = "N"; }
		$MapData[$MapX][$MapY][Clan_Image] = $MData[Image];
		$MapData[$MapX][$MapY][ClanID] = intval($MData[ClanID]);
		if (($MData[TileID] == "1" || $MData[TileID] == "0") && $MData[ClanID] > 0) {
			$MapData[$MapX][$MapY][Clan_Image] = "clan_bad.gif";
		}
	}

	$sth = mysql_query("select T.Image,CB.*,B.Name from clan_buildings as CB left join buildings as B on B.BID=CB.BID left join tiledata as T on T.TileID=B.TileID where CB.X >= $MinX and CB.X <= $MaxX and CB.Y >= $MinY and CB.Y <= $MaxY and CB.MapID=$Player_MapID");
	print mysql_error();
	while ($MData = mysql_fetch_array($sth)) {
		$MapX = $MData[X];
		$MapY = $MData[Y];
		$MapData[$MapX][$MapY][Building_Image] = $MData[Image];
	}


	print "<table border=0 cellpadding=0 cellspacing=0>";

	for ($MapY = -round($Height / 2); $MapY <= round($Height / 2); $MapY++) {
		print "<tr>";

		for ($MapX = -round($Width / 2); $MapX <= round($Width / 2); $MapX++) {
			$CurX = $Player_X + $MapX;
			$CurY = $Player_Y + $MapY;
	
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
				print "<td width=30 height=30 class=pageCell align=center background='$tiledir/".$MapData[$CurX][$CurY][Image]."'>";
				print "<img src=./images/chars/$Player_UserPic>";
			} elseif ($MapX != 0 || $MapY != 0) {
				if ($MapData[$CurX][$CurY][Warrior_Image] != "") {
					print "<td height=30 width=30 class=pageCell align=center background='$tiledir/".$MapData[$CurX][$CurY][Image]."'><IMG SRC='$tiledir/".$MapData[$CurX][$CurY][Warrior_Image]."'>";
				} elseif ($MapData[$CurX][$CurY][Corpse] != "") {
					print "<td height=30 width=30 class=pageCell align=center background='$tiledir/".$MapData[$CurX][$CurY][Image]."'><IMG SRC='$tiledir/".$MapData[$CurX][$CurY][MOBImage]."'>";
				} elseif ($MapData[$CurX][$CurY][MOBImage] != "") {
					print "<td height=30 width=30 class=pageCell align=center background='$tiledir/".$MapData[$CurX][$CurY][Image]."'><IMG SRC='$tiledir/".$MapData[$CurX][$CurY][MOBImage]."'>";
				} elseif ($MapData[$CurX][$CurY][Building_Image] != "") {
					print "<td height=30 width=30 class=pageCell align=center background='$tiledir/".$MapData[$CurX][$CurY][Image]."'><IMG SRC='$tiledir/".$MapData[$CurX][$CurY][Building_Image]."'>";
				} elseif ($MapData[$CurX][$CurY][UPic] != "") {
					print "<td height=30 width=30 class=pageCell align=center background='$tiledir/".$MapData[$CurX][$CurY][Image]."'><IMG SRC='$tiledir/".$MapData[$CurX][$CurY][UPic]."'>";
				} elseif ($MapData[$CurX][$CurY][ClanID] > 0) {
					print "<td height=30 width=30 class=pageCell align=center background='$tiledir/".$MapData[$CurX][$CurY][Image]."'><IMG SRC='$tiledir/".$MapData[$CurX][$CurY][Clan_Image]."'>";
				} else {
					print "<td height=30 width=30 class=pageCell align=center background='$tiledir/".$MapData[$CurX][$CurY][Image]."'>";
				}
			}
			print "</td>";
		}
		print "</tr>";
	}
	print "</table>";
}

?>