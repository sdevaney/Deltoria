<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
$db = mysql_connect("localhost","db_user","db_pass");
mysql_select_db("db_name");

	if ($Lock != "") {
		$sth_mod = mysql_query("insert into user_security (coreid,page) values ($Lock,\"$Page\")");
		print mysql_error();
	} elseif ($UnLock != "") {
		$sth = mysql_query("delete from user_security where sec_id=$UnLock");
		print mysql_error();
	}


	  print "<TABLE BORDER=1 CLASS=BOX>";
		print "<TR><TD><B>Action</TD><TD><B>Page</TD><TD><B>User</TD></TR>";
	  $sth_mod = mysql_query("select s.sec_id,u.Username,s.page from user_security as s left join user as u on u.CoreID=s.coreid");
	  while (list($SecID,$LockUser,$Page) = mysql_fetch_row($sth_mod)) {
		  print "<TR><TD><A HREF=$SCRIPT_NAME?UnLock=$SecID>UnLock</A></TD><TD>$Page</TD><TD>$LockUser</TD></TR>";
	  }
	  print "</TABLE><P>";


	  print "<TABLE BORDER=0 CLASS=BOX>";
	  print "<tr><td class=header>Add New Security Lock</td></tr>";
	  print "<tr><td>";
	  print "<form action=$SCRIPT_NAME security.php?METHOD=POST>";
	  print "<SELECT NAME=Lock>";
	  $sth_mod = mysql_query("select CoreID,Username from user order by Username");
	  while ($UData = mysql_fetch_array($sth_mod)) {
		print "<OPTION VALUE=$UData[CoreID]>$UData[Username]";
	  }
	  print "</SELECT>";
	
		print "<SELECT NAME=Page>";
		print "<OPTION VALUE=chat.php>Chat";
		print "<OPTION VALUE=forums.php>Forums";
		print "<OPTION VALUE=mail.php>Mail";
		print "<OPTION VALUE=album.php>Album";
		print "</SELECT>";

	  print "<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Block>";
	  print "</FORM>";
	  print "</td></tr>";
	  print "</table>";


?>