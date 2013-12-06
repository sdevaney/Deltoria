<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
	########################
	## Make us our connection
	global $db;
	include ("./system/top.php");
// If in battle cant go to this page
        if (Check_Battle($PlayerData) == 1) {
                print "<TABLE BORDER=0 class=box1>";
                print "<tr><td class=Header colspan=2>Your being attacked!</td></tr>";
                $sth = mysql_query("select Image,MB.Name,Level from monster as M left join monster_base as MB on MB.MonsterID=M.MonsterID left join tiledata as TD on TD.TileID=MB.TileID where X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID and HealthCur > 0");
                print mysql_error();
                while (list($M_Image,$M_Name,$M_Level) = mysql_fetch_row($sth)) {
                        print "<TR><TD WIDTH=50>";
                        print "<IMG WIDTH=30 HEIGHT=30 SRC=/images/tiles/$M_Image>";
                        print "</TD><TD VALIGN=TOP>$M_Name<BR><B>Level:</B> ".intval($M_Level)."</TD></TR>";
                }
                print "<tr><td colspan=2 class=Menu><A HREF=battle.php?RD=".rand(1,1000000).">You're being attacked! Click here to go to the battle page.</a> </td></tr>";
                print "</table>";
                print "<P>";
                include("./system/bottom.php");
                exit;
        }


	include ("./system/clan.php");

	include ("./system/bottom.php");

?>