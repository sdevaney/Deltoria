<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Still working on this part
function Help_DB($HelpID) {
	$sth = mysql_query("select * from help where HelpID=$HelpID");
	$data = mysql_fetch_array($sth);
	$Topic = $data[Topic];
	$Body = str_replace("\n","",$data[Body]);
	$Body = str_replace("\r","",$Body);
	$Body = str_replace("'","\\'",$Body);
	Help($Topic,$Body);
}

function PlayerInfo($CoreID,$UserImage) {
	$sth = mysql_query("select U.Age,U.Username,U.Level,C.Name,M.Username as Leader from user as U left join clans as C on C.ClanID=U.ClanID left join user as M on M.CoreID=C.Founder where U.CoreID=$CoreID");
	$UData = mysql_fetch_array($sth);

        $Age_Years = intval($UData[Age] / 365);
        $Age_Days = $UData[Age] - ($Age_Years * 365);


	$Body = "<B>Clan:</B> $UData[Name]<BR>";
	$Body = $Body."<B>Leader:</B> $UData[Leader]<BR>";
	$Body = $Body."<B>Level:</B> $UData[Level]<BR>";
	$Body = $Body."<B>Age:</B> $Age_Years years and $Age_Days days.<bR>";
	// Load all Armor AL information
	$sth = mysql_query("select MinDam,MaxDam,ItemType,AL,IB.Name,TD.Image from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as TD on TD.TileID=IB.TileID where I.CoreID=$CoreID and I.Banked='N' and I.Equiped = 'Y' and (IB.ItemType='Armor' or IB.ItemType='Weapon')");
	print mysql_error();
	if (mysql_num_rows($sth) > 0) {
		$Body = $Body."<TABLE BORDER=0 CLASS=Box1><TR><TD class=Header COLSPAN=".mysql_num_rows($sth).">Armor Pieces Worn</TD></TR><TR>";
		while (list($armor_min,$armor_max,$itemtype,$armor_AL,$armor_Name,$armor_Image) = mysql_fetch_row($sth)) {
			if ($itemtype == "Weapon") {
				$Body = $Body."<TD align=center><IMG SRC=./images/tiles/$armor_Image><BR>$armor_Name<br><b>($armor_min - $armor_max)</TD>";
			} else {
				$Body = $Body."<TD align=center><IMG SRC=./images/tiles/$armor_Image><BR>$armor_Name<br><b>($armor_AL)</TD>";
			}
		}
		$Body = $Body."</TR></TABLE>";
	}

	print "<IMG onmouseover=\"ShowInfo('".str_replace("'","\'",$UData[Username])."','$Body')\" onmouseout=\"HideInfo()\" 
src=./images/chars/$UserImage BORDER=0>";
}


function Help($Topic,$Body) {
	$Body = str_replace("\n","",$Body);
	$Body = str_replace("\r","",$Body);
	$Body = str_replace("'","\\'",$Body);
	print "<IMG onmouseover=\"ShowInfo('$Topic','$Body')\" onmouseout=\"HideInfo()\" src=./images/help.jpg WIDTH=10 HEIGHT=10 BORDER=0>";
}

function Description($Topic,$Body) {
	$Body = str_replace("\n","",$Body);
	$Body = str_replace("\r","",$Body);
	$Body = str_replace("'","\\'",$Body);
	print "<IMG onmouseover=\"ShowInfo('$Topic','$Body')\" onmouseout=\"HideInfo()\" src=./images/buttons/description.jpg BORDER=0>";
}

function Popup_Pic($Topic,$Body,$Picture) {
	$Body = str_replace("\n","",$Body);
	$Body = str_replace("\r","",$Body);
	$Body = str_replace("'","\\'",$Body);
	print "<IMG onmouseover=\"ShowInfo('$Topic','$Body')\" onmouseout=\"HideInfo()\" src=\"$Picture\" BORDER=0>";
}

function Whisper($Username) {
	print "<img onclick=\"document.chatter.Chatter.value = '/tell $Username, ' + document.chatter.Chatter.value\" src=./images/chat/whisper.gif>";
}

?>