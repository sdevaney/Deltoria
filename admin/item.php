<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
$db = mysql_connect("localhost","db_user","db_pass");
mysql_select_db("db_name");

if ($DelItem > 0) {
	if ($auth != "y") {
		$sth = mysql_query("select ItemID, Name from items_base where ItemID=$DelItem");
		list ($ItemID,$Name) = mysql_fetch_row($sth);
		print "Are you sure you want to delete ($ItemID) $Name?<BR>";
		print "<A HREF=$SCRIPT_NAME?DelItem=$DelItem&auth=y>Yes</A>";
	} else {
		$sth = mysql_query("select ItemID, Name from items_base where ItemID=$DelItem");
		list ($ItemID,$Name) = mysql_fetch_row($sth);
//		$sth = mysql_query("delete from items_base where ItemID=$DelItem");
//		print mysql_error();
		$sth = mysql_query("delete from items where ItemID=$DelItem");
		print mysql_error();
	}
} else {
	$sth = mysql_query("select ItemID, Name from items_base order by ItemID");
	print mysql_error();
	print "<FORM ACTION=$SCRIPT_NAME>";
	print "<SELECT NAME=DelItem>";
	while (list($ItemID,$Name) = mysql_fetch_row($sth)) {
		print "<OPTION VALUE=$ItemID>($ItemID) $Name";
	}
	print "</SELECT>";
	print "<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Delete>";
	print "</FORM>";
}

?>