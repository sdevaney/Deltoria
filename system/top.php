<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Top of game pages
session_start();

$time = microtime();
$time = explode(" ",$time);
$microtime = $time[1]+$time[0];
$transaction_start = $microtime;

########################
## Make us our connection
global $CoreUserData,$CoreData,$db,$REMOTE_ADDR,$PlayerData,$Skills;
include ("./system/suite.php");

ereg("\/([a-z.A-Z0-9]+)$",$_SERVER['SCRIPT_NAME'],$regs);
$sth = mysql_query("select sec_id from user_security where CoreID=".$PlayerData->CoreID." and Page='$regs[1]' limit 1");
if (mysql_num_rows($sth) > 0) {
		list($SecID) = mysql_fetch_row($sth);
		header("Location: access_denied.php?ID=$SecID"); exit();
}


include ("./system/help.php");

?>
<HTML>

<HEAD>
<TITLE>Deltoria</TITLE>
<STYLE>
<? include("./styles/style.php"); ?>
</STYLE>
<LINK REL="SHORTCUT ICON" HREF="http://www.deltoria.com/favicon.ico">
<SCRIPT SRC="./system/popup_help.js"></SCRIPT>
</HEAD>

<!-- <BODY STYLE="background-color: #F55BAE; background: url(./images/flower.gif)"> -->
<BODY STYLE="background: #C4B79F;">

<script language="JavaScript">
function UpdateHealth(NewWidth) {
        document.getElementById("health").width = NewWidth;
}
</script>



<? include("./system/popup_help.html"); ?>


<?
if ($PlayerData->Username != "") {
	print "<table border=0 class=pagecontainer width=818>";
	print "<tr><td class=pagecell>";
	DispMenu();
	print "</td></tr></table>";

	print "<tr>";
	if (!stristr($SCRIPT_NAME,"charpage.php") && !stristr($SCRIPT_NAME,"admin_index.php")) {
		if ($ClearLog > 0) {
			$sth = mysql_query("delete from user_log where LogID <= $ClearLog and CoreID=$PlayerData->CoreID");
		}

		$sth = mysql_query("select * from user_log where CoreID=$PlayerData->CoreID");
		if (mysql_num_rows($sth) > 0) {
			$MaxLog = 0;
			print "<TABLE BORDER=0 WIDTH=818 CLASS=Box1>";
			print "<Tr><td colspan=3 class=Header>Message Box</td></tr>";
			while ($LogData = mysql_fetch_array($sth)) {
				print "<TR><TD valign=top>$LogData[Type]</TD><TD valign=top>$LogData[Message]</TD></TR>";
				if ($LogData[LogID] > $MaxLog) { $MaxLog = $LogData[LogID]; }
			}
			print "<TR><TD COLSPAN=2 CLASS=Footer><A HREF=$SCRIPT_NAME?ClearLog=$MaxLog>Clear Messages</A></TD></TR>";
			print "</TABLE><BR>";
		}
	}

}
?>