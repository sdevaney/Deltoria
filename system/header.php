<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
	global $header_image,$header_about,$header_directions,$header_skipsuite;

	include_once ("./system/dbconnect.php");

	session_start();

	$time = microtime();
	$time = explode(" ",$time);
	$microtime = $time[1]+$time[0];
	$transaction_start = $microtime;

	########################
	## Make us our connection
	global $CoreUserData,$CoreData,$db,$REMOTE_ADDR,$PlayerData,$Skills;
	if (!$header_skipsuite) include ("./system/suite.php");

	if ($PlayerData) {
		ereg("\/([a-z.A-Z0-9]+)$",$_SERVER['SCRIPT_NAME'],$regs);
		$sth = mysql_query("select sec_id from user_security where CoreID='".intval($PlayerData->CoreID)."' and Page='$regs[1]' limit 1");
		if (mysql_num_rows($sth) > 0) {
		        list($SecID) = mysql_fetch_row($sth);
		        header("Location: access_denied.php?ID=$SecID"); exit();
		}
	}




?>
<HEAD>
<LINK REL="STYLESHEET" TYPE="text/css" HREF="./styles/deltoria.css">
</HEAD>
<HTML>
<SCRIPT SRC="./system/popup_help.js"></SCRIPT>

<BODY BGCOLOR=WHITE STYLE="margin: 0px;">
<? include("./system/popup_help.html"); ?>

<table border=0 cellpadding=0 cellspacing=0 height=100% width=100%>
<tr>
<td CLASS=banner_left>&nbsp;</td>
<td width=800px class=body_table>

<table border=0 width=100% cellpadding=0 cellspacing=0>
<tr>
	<td valign=top rowspan=2 width=170><img src=./images/header-dragon.gif></td>
	<td height=21 width=100% background=./images/header-bar.gif bgcolor=#ADB9CE><img src=./images/header-bar.gif></td>
	<td width=1><img width=1 height=21 src=./images/dot-black.gif></td>
	<td background=./images/header-bar.gif bgcolor=#9AA9C3 nowrap>&nbsp;</td>
</tr>
<tr><td colspan=3 height=100%><img width=1 height=63 src=./images/dot-clear.gif></td></tr>
</table>


<P>






<TABLE STYLE="BORDER: 1PX #000000 SOLID" WIDTH=100% CELLPADDING=0 CELLSPACING=0><TR><TD>

<TABLE BORDER=0 CELLPADDING=0 WIDTH=100% CELLSPACING=0>
<TR>
	<TD BACKGROUND=./images/top-left.gif STYLE="HEIGHT: 2px;"><IMG SRC=./images/top-left.gif></TD>
	<TD ROWSPAN=2 HEIGHT=60 BACKGROUND=./images/center-background.gif WIDTH=10 VALIGN=TOP><IMG SRC=./images/center-top.gif></TD>
	<TD BACKGROUND=./images/top-right.gif STYLE="HEIGHT: 2px;"><IMG SRC=./images/top-right.gif></TD>
</TR>
<TR>
	<TD BGCOLOR="#1B17CF" HEIGHT="100%" WIDTH=50% BACKGROUND="./images/<?=$header_image?>" STYLE="background-repeat: no-repeat; background-position: center top; vertical-align: top; color: white">
	<table border=0 cellpadding=0 cellspacing=0><tr><td width=1><img src=./images/dot-clear.gif height=56 width=1></td><td style="vertical-align: top; color: white">
	<?=$header_about?>
	</td></tr></table>
	</TD>
	<TD BGCOLOR=#6873B4 WIDTH=50% HEIGHT="100%" STYLE="font-size: 12px; vertical-align: top;">
		<?=$header_directions?>
	</TD>
</TR>
<TR>
	<TD COLSPAN=2 BACKGROUND=./images/bottom-left.gif HEIGHT=2><IMG SRC=./images/dot-clear.gif></TD>
	<TD BACKGROUND=./images/bottom-right.gif HEIGHT=2><IMG SRC=./images/dot-clear.gif></TD>
</TR>
</TABLE>

</TD></TR></TABLE><P>
