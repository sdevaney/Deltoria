<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Admins only
    $header_image = "icon-guard.gif";
    $header_about = join("\n",file("./text/heartbeat_left.html"));
    $header_directions = join("\n",file("./text/heartbeat_right.html"));
    include_once("./system/header.php");

	print "<center>";

	if ($_POST['Save'] == "0") {
		$sth = mysql_query("insert into heartbeat (Name,RunEvery,ModCode,Enabled) values ('".$_POST['Name']."','".$_POST['Interval']."','".$_POST['ModCode']."','N')");
		print mysql_error();
		$_GET['Edit'] = mysql_insert_id();
	} elseif ($_POST['Save'] > 0) {
		$sth = mysql_query("update heartbeat set Name='".$_POST['Name']."',ModCode='".$_POST['ModCode']."',RunEvery='".$_POST['RunEvery']."' where HeartID=".$_POST['Save']);
		print mysql_error();
		$_GET['Edit'] = $_POST['Save'];
	}

	if ($_GET['Enable'] > 0) {
		$sth = mysql_query("update heartbeat set Enabled='Y' where HeartID=".$_GET['Enable']);
		print mysql_error();
	} elseif ($_GET['Disable'] > 0) {
		$sth = mysql_query("update heartbeat set Enabled='N' where HeartID=".$_GET['Disable']);
		print mysql_error();
	}

	if ($_GET['Edit'] != "") {
		$sth = mysql_query("select * from heartbeat where HeartID=".$_GET['Edit']);
		$data = mysql_fetch_array($sth);
		print "<FORM STYLE='margin: 0px;' ACTION=admin_heartbeat.php METHOD=POST>";
		print "<INPUT TYPE=HIDDEN NAME=Save VALUE=".$_GET['Edit'].">";
		print "<table border=1 class=Box1 WIDTH=95%>";
		if ($_GET['Edit'] > 0) {
			print "<tr><td class=Header colspan=2>Editing: ".$data['Name']."</td></tr>";
		} else {
			print "<tr><td class=Header colspan=2>New Heartbeat</td></tr>";
		}
		print "<tr><td class=Menu>Name</td><td class=Menu>Interval</td></tr>";
		print "<tr>";
		print "    <td class=Text><input type=text style='width: 100%;' name=Name value=\"$data[Name]\"></td>";
		print "    <td class=Text><input type=text style='width: 100%;' name=RunEvery value=\"$data[RunEvery]\"></td>";
		print "</tr>";
		print "<tr><td colspan=2 class=Menu>PHP Code</td></tr>";
		print "<tr><td colspan=2><textarea NAME=ModCode STYLE='width: 100%;' ROWS=10>$data[ModCode]</TEXTAREA></TD></TR>";
		print "<tr><td colspan=2 class=Footer><input type=submit name=submit value=Save></td></tr>";
		print "</table><p>";
	}


	print "<table border=1 class=Box1 WIDTH=95%>";
	print "<tr><td class=Header colspan=5>Heartbeat Overview</td></tr>";
	print "<tr>";
	print "   <td class=Menu>&nbsp;</td>";
	print "   <td class=Menu>Enabled</td>";
	print "   <td class=Menu>Name</td>";
	print "   <td class=Menu>Interval</td>";
	print "   <td class=Menu>Time Left</td>";
	print "</tr>";

	$sth = mysql_query("select * from heartbeat order by Name");
	while ($data = mysql_fetch_array($sth)) {
		print "<tr>";
		print "    <td class=Text><A HREF=admin_heartbeat.php?Edit=".$data[HeartID].">Edit</A></td>";
		print "    <td class=Text>";
		if ($data[Enabled] == "Y") {
			print "<A HREF=admin_heartbeat.php?Disable=".$data[HeartID].">Yes</A>";
		} else {
			print "<A HREF=admin_heartbeat.php?Enable=".$data[HeartID].">No</A>";
		}
		print "    </td>";
		print "    <td class=Text>$data[Name]</td>";
		print "    <td class=Text>$data[RunEvery] mins</td>";
		print "    <td class=Text>$data[RunTime] mins</td>";
		print "</tr>";
	}
	print "<tr><td class=Footer colspan=5><A HREF=admin_heartbeat.php?Edit=0>New Heartbeat</A></td></tr>";
	print "</table>";


	print "</center>";

	include ("./system/footer.php");

?>