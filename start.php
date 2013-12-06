<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Our main page, remove some commented code to use in game forums
	########################
	## Make us our connection
	global $db;
	include ("./system/top.php");
	include ("./system/move.php");

	print "<table border=0 class=pageContainer>";
	print "<tr><td class=pageCell valign=top>";
	$sth = mysql_query("select LastAccessed from user where CoreID = $PlayerData->CoreID");
	list($Access) = mysql_fetch_row($sth);
	//$sth = mysql_query("select count(forums_posts.PostID) from forums_posts join user on forums_posts.Time=user.LastAccessed where 
//forums_posts.Time > user.LastAccessed and forums_posts.ClanID=$PlayerData->ClanID or forums_posts.ClanID=0");
	if ($row = mysql_fetch_row($sth)) {
		return $row;
	} else {
		print (mysql_error());
	}
	list($Newposts) = mysql_fetch_row($sth);
	print $Newposts;
	//print "There are $Newposts new posts in the forums.";
	include ("./system/nav.php");
//	if ($PlayerData->Admin == "Y") {
		$zone = mysql_query("select Name from mapid_background where MapID=$PlayerData->MapID");
		$mapname = mysql_fetch_array($zone);
		print $mapname[Name];
//	}
	print "</td><td class=pageCell valign=top align=left>";

	include ("./system/chatter.php");
	include ("./system/clanoptions.php");

	include ("./system/general.php");
	include ("./system/player_area.php");
	include ("./system/obj_area.php");

	print "</td></tr></table>";


	include ("./system/bottom.php");

?>