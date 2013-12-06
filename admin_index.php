<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Allows admins to edit player info like email, admins status, manager status, and allows locking of accounts
########################
## Make us our connection
global $db;
include ("./system/top.php");
//include ("ajax2.php");
if ($CoreUserData[Manager] != "Y") {
	print "Notice. This area is restricted to managers only.";
	include("./system/bottom.php");
	exit;
}

if ($_POST['pass'] != "") {
	if ($_POST['pass'] == ('password')) {
		$_SESSION['manage_auth'] = "Y";
	}
}

if ($_SESSION['manage_auth'] != "Y") {
	print "Please authenticate: ";
	print "<FORM ACTION=admin_index.php METHOD=POST>";
	print "<INPUT TYPE=PASSWORD NAME=pass> <INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Go>";
	print "</FORM>";
	include("./system/bottom.php");
	exit;
}


if ($View != "") {
	if (strstr($View, "@")) {
		$sth1 = mysql_query("select * from user_base where Email like '%$View%'");
		$edata = mysql_fetch_array($sth1);

		$sth1 = mysql_query("select * from user_base where UserID=$edata[UserID]");
		$cdata = mysql_fetch_array($sth1);
	} else {	
		$sth = mysql_query("select * from user where CoreID=$View");
		$udata = mysql_fetch_array($sth);

		$sth = mysql_query("select * from user_base where UserID=$udata[UserID]");
		$cdata = mysql_fetch_array($sth);
	}

	if ($Action == "EdCore") {
		$sth = mysql_query("update user_base set Locked='$Locked',Administrator='$Administrator',Manager='$Manager' where UserID=$cdata[UserID]");
		print "Updated User<BR>";
		if ($Password != "") { $sth = mysql_query("update user_base set Password=old_password('$Password') where UserID=$cdata[UserID]"); print "Updated Password<BR>"; }

		$sth = mysql_query("select * from user_base where UserID=$cdata[UserID]");
		$cdata = mysql_fetch_array($sth);
	}
	
	print "Email: $cdata[Email]<BR>";
	print "Account Created: $cdata[CreateDate]<BR>";
	print "Subscriber: $cdata[Subscriber] / $cdata[FundDate]<BR>";
	print "Last Logon: $cdata[LastAccessed]<BR>";
	print "Admin: $cdata[Administrator]<BR>";
	print "Manager: $cdata[Manager]<BR>";
	print "Locked: $cdata[Locked]<BR>";
	print "<HR>";
	
	print "<B>Users Registered With this Email</B><BR>";
	$sth = mysql_query("select Username, Level from user where UserID=$cdata[UserID]");
	while (list($uname, $ulevel) = mysql_fetch_row($sth)) {
		print $uname." Level ".$ulevel."<BR>";
	}
	print "<HR>";


	print "<FORM ACTION=$SCRIPT_NAME METHOD=POST>";
	print "<INPUT TYPE=HIDDEN NAME=SearchUser VALUE='$SearchUser'>";
	print "<INPUT TYPE=HIDDEN NAME=View VALUE='$View'>";
	print "<INPUT TYPE=HIDDEN NAME=Action VALUE='EdCore'>";
	print "Locked: <INPUT TYPE=TEXT NAME=Locked VALUE='$cdata[Locked]'><BR>";
	print "Manager: <INPUT TYPE=TEXT NAME=Manager VALUE='$cdata[Manager]'><BR>";
	print "Admin: <INPUT TYPE=TEXT NAME=Administrator VALUE='$cdata[Administrator]'><BR>";
	print "Password: <INPUT TYPE=TEXT NAME=Password VALUE=''> (Only enter a password if you want to change their password)<BR>";
	print "<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Save><BR>";
	print "</FORM>";

}




?>
<TABLE CLASS=BOX1>
<FORM ACTION=<?=$SCRIPT_NAME?> METHOD=POST>
<TR><TD CLASS=HEADER>Search Users</TD><TD CLASS=HEADER ALIGN=RIGHT>
<INPUT TYPE=TEXT NAME=SearchUser VALUE="<?=$SearchUser?>">
<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Search>
</TD></TR>
<TR><TD CLASS=HEADER>Search E-Mail Addresses</TD><TD CLASS=HEADER ALIGN=RIGHT>
<INPUT TYPE=TEXT NAME=SearchEmail VALUE="<?=$SearchEmail?>">
<INPUT TYPE=SUBMIT NAME=SUBMIT2 VALUE=Search>
</TD></TR>
</FORM>
<?php


if ($SearchUser == "" and $SearchEmail == "") {
	print "<TR><TD COLSPAN=2>Please search for a game name or E-Mail Address</TD></TR>";
} else {
	if ($SearchUser != "") {
		$sth = mysql_query("select * from user where Username like '%$SearchUser%'");
		if (mysql_num_rows($sth) == 0) {
			print "<TR><TD COLSPAN=2>No users matched your search criteria</TD></TR>";
		} else {
			while ($udata = mysql_fetch_array($sth)) {
				print "<TR><TD><A HREF=admin_index.php?SearchUser=$SearchUser&View=$udata[CoreID]>View</A></TD><TD>$udata[Username]</TD></TR>";
			}
		}
	} else {
		$sth1 = mysql_query("select * from user_base where Email like '%$SearchEmail%'");
		if (mysql_num_rows($sth1) == 0) {
			print "<TR><TD COLSPAN=2>No users matched your search criteria</TD></TR>";
		} else {
			while($edata = mysql_fetch_array($sth1)) {
				print "<TR><TD><A HREF=admin_index.php?SearchEmail=$SearchEmail&View=$edata[Email]>View</A></TD><TD>$edata[Email]</TD></TR>";
			}
		}
	}
}
?>
</TABLE>
<?php

include ("./system/bottom.php");

?>