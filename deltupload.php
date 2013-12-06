<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Upload new tiles
	########################
	## Make us our connection
	global $db;
	include ("./system/top.php");

	if ($PlayerData->Admin != "Y") {
		print "Administrator access is required to access this page.";
	} else {
		if ($userfile != "") {
			$sth = mysql_query("select * from tiledata where Image='$userfile_name'");
			if (mysql_num_rows($sth) > 0) {
				print "Notice: An image already exists with that name.";
			} else {
				$pictype = strtoupper(substr($userfile_name,strlen($userfile_name)-3,3));
				if ($pictype == "GIF" || $pictype == "PNG" || $pictype == "JPG") {
					$sth = mysql_query("insert into tiledata (Image,Name,Keywords,Walkable,CoreID,ImageType,Clan,Cost, NewTile) values ('$userfile_name','$TileName','$TileKeywords','$TileWalkable','$PlayerData->CoreID','$TileImageType','$TileClan','$TileCost','$NewTile')");
					print mysql_error();
					$picid = mysql_insert_id($db);
					copy($userfile, "./images/tiles/$userfile_name");
					print "Picture uploaded. <img src=./images/tiles/$userfile_name><p>";
				} else {
					print "Invalid picture type. We only support GIF, JPG, and PNG<br>";
				}
			}
		}
		
		print "<FORM ENCTYPE=\"multipart/form-data\" ACTION=\"$SCRIPT_NAME\" METHOD=POST>";
		print "<Table border=0 class=box1>";
		print "<tr><td class=Header colspan=7>Upload Tile</td></tr>";
		print "<tr><td class=Menu>Name</td><Td class=menu>Keywords</td><Td class=menu>Walkable</td><Td class=menu>Clan</td><td class=menu>Cost</td><Td class=menu>Type</td><Td class=menu>Filename</td></tr>";

		print "<INPUT TYPE=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"2000000\">";
		print "<INPUT TYPE=HIDDEN NAME=CoreID VALUE=$CoreID>";
		print "<INPUT TYPE=HIDDEN NAME=Verify VALUE='$Verify'>";

		print "<tr>";

		print "<td><input type=text size=10 name=TileName></td>";
		print "<td><input type=text size=10 name=TileKeywords></td>";
		print "<td><select name=TileWalkable><option selected value=Y>Y<option value=N>N</select></td>";
		print "<td><select name=TileClan><option selected value=Y>Y<option value=N>N</select></td>";
		print "<td><input type=text size=5 name=TileCost></td>";
		print "<td><select name=TileImageType>";
		print "<option selected value=NewTiles>New Tiles";
/*		print "<option value=Actor>Actor";
		print "<option value=Map>Map";
		print "<option value=Overlay>Overlay";
		print "<option value=Warrior>Warrior";
		print "<option value=Building>Building";
		print "<option value=NewTiles>New Tiles";
*/		print "</select></td>";
		print "<td><INPUT NAME=\"userfile\" TYPE=\"file\"></td>";
		print "</tr>";
		print "<Tr><td class=footer colspan=7><INPUT TYPE=\"submit\" VALUE=\"Send File\"></td></tr>";
		print "</FORM>";
		print "</table>";
	}


	include ("./system/bottom.php");

?>