<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Main index page after splash page
//error_reporting(E_ALL)
global $header_image,$header_about,$header_directions,$header_skipsuite;
session_start();
require_once("./system/dbconnect.php");
echo mysql_error();
if ($register_email != "" && $register_email != $register_email_two) {
	header("Location: $SCRIPT_NAME?register_step=1&Error=".base64_encode("The email addresses you entered did not match."));
	exit();
}
echo mysql_error();
if ($login_name != "") {
	$sth = mysql_query("select UserID from user_base where Email='$login_name' and Password=old_password('$login_pass')");
	if (mysql_num_rows($sth) == 0 ) {
	die(mysql_error());
		header("Location: $SCRIPT_NAME?Error=".base64_encode("Invalid Email or Password"));
		exit;
	} else {
		list($userid) = mysql_fetch_row($sth);
		$sth = mysql_query("update user_base set LastAccessed=NOW() where UserID=$userid");
		$_SESSION[userid] = $userid;
		header("Location: ./charpage.php");
		exit;
	}
} else {
	$header_image = "icon-guard.gif";
	$header_about = join("\n",file("./text/login_left.html"));
	$header_directions = join("\n",file("./text/login_right.html"));
	$header_skipsuite = true;
	include_once("./system/header.php");
	?>
	<center>
	<table class=box1 width=95%>
	<FORM ACTION="<?=$SCRIPT_NAME?>" METHOD=POST>
	<tr><td class=header>Login to Deltoria</td></tr>
	<tr><td>
	<table class=pagecontainer>
	<tr><td class=Text>Email</td><td class=pagecell><INPUT TYPE=TEXT NAME=login_name STYLE="width: 150px;"></td><td rowspan=2 class=Text valign=top width="100%">
	<?php
		if ($_GET[Error]) print "<div width=100% style=\"border: 1px dashed; background=E99898; padding: 2px; margin: 2px;\"><FONT COLOR=RED><B>Notice:</B></FONT> ".base64_decode($_GET[Error])."</div><br>";
		print join("\n",file("./text/login_text.html"));
	?>
	</td></tr>
	<tr><td class=Text>Password</td><td class=pagecell><INPUT TYPE=PASSWORD NAME=login_pass STYLE="width: 150px;"></td></tr>
	</table>
	</td></tr>
	<tr><td class=footer style="border-top: 1px black solid">
	<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Login STYLE="width: 150px;">
	</td></tr>
	</FORM>
	<TR><TD><A HREF=passreset.php>Forgot Password?</A>
	</table>
	
	<p>

	<table class=box1 width=95%>
	<tr><td class=text style="padding: 5px;">
	Don't have a login yet? Don't worry! Just jump over to our <A HREF=register.php>register</A> page and register for free! It only takes a couple of minutes and a valid email address!
	</td></tr>
	</table>

	<?php
	include_once("./system/footer.php");
	exit;
}
?>