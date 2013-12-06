<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Player log
	global $DelLog,$PlayerData;
	if ($DelLog > 0) {
		$sth = mysql_query("delete from user_log where CoreID=$PlayerData->CoreID and LogID <= $DelLog");
	}

	$LogID = 0;
	$sth = mysql_query("select DATE_FORMAT(TS,'%b %D %h:%i %p') as TS,Type,Message,LogID from user_log where CoreID=$PlayerData->CoreID order by TS");
	if (mysql_num_rows($sth) > 0) {
		TableTop("Your Notices");
		
		print "<table border=0 width=562 background=./i/bigbox_background.jpg>";
		print "<Tr BGCOLOR=#333333><td NOWRAP><B>Message Type</TD><TD><B>Message Body</TD></tr>";
		while ($data = mysql_fetch_array($sth)) {
			if ($data[LogID] > $LogID) { $LogID = $data[LogID]; }
			print "<tr><td valign=top NOWRAP><b>$data[Type]</b></td><td valign=top>$data[Message]</td></tr>";
		}
		print "<tr><td colspan=2 BGCOLOR=#333333 ALIGN=RIGHT><A CLASS=sidelink HREF=$SCRIPT_NAME?DelLog=$LogID>Clear Messages</A></TD></TR>";
		print "</TABLE>\n";
		TableBottom();
		print "<P>";
	}
?>