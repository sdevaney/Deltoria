<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Register page

session_start();
require_once("./system/dbconnect.php");

if ($register_email != "" && ($REMOTE_ADDR == "62.255.240.221" || $REMOTE_ADDR == '62.183.50.164' || $REMOTE_ADDR == '81.155.238.12' || $REMOTE_ADDR == '81.157.47.95' || $REMOTE_ADDR == '81.155.232.221' || $REMOTE_ADDR == '217.42.152.185')) {
	header("Location: $SCRIPT_NAME?Error=".base64_encode("We are sorry but we are unable to continue the registration for your account. Please email support@techby2guys.com for further information"));
	exit();
} elseif ($register_email != "" && $register_email != $register_email_two) {
	header("Location: $SCRIPT_NAME?Error=".base64_encode("The email addresses you entered did not match."));
	exit();
} elseif ($register_email == $register_email_two && $register_email != "") {
	$sth = mysql_query("select * from user_base where email='$register_email'");
	if (mysql_num_rows($sth) > 0) {
		header("Location: $SCRIPT_NAME?Error=".base64_encode("That email address is already in our system! To login click here!").")");
		exit;
	} else {
		$header_image = "icon-guard.gif";
		$header_about = join("\n",file("./text/register_left.html"));
		$header_directions = join("\n",file("./text/register_right.html"));
		$header_skipsuite = true;
		include_once("./system/header.php");

		$Pass = randPass(6);
		SendMail($register_email,$Pass);

		$sth = mysql_query("insert into user_base (Email,Password,CreateDate) values 
('$register_email',old_password('$Pass'),CURRENT_TIMESTAMP)");
		print mysql_error();

		print "<center>";
		print "<TABLE CLASS=Box1 WIDTH=95%>";
		print "<TR><TD CLASS=HEADER>New User Created</TD></TR>";
		print "<TR><TD class=text>";
		print join("\n",file("./text/register_success.html"));
		print "</TD></TR>";
		print "<TR><TD CLASS=FOOTER><A HREF=index2.php>Login</A></TD></TR>";
		print "</TABLE>";
		print "</center>";
		include_once("./system/footer.php");
		exit;
	}
}


$header_image = "icon-guard.gif";
$header_about = join("\n",file("./text/register_left.html"));
$header_directions = join("\n",file("./text/register_right.html"));
$header_skipsuite = true;
include_once("./system/header.php");

?>

<center>
<table class=box1 width=95%>
<FORM ACTION="<?=$SCRIPT_NAME?>" METHOD=POST>
<tr><td class=header>Register to Deltoria</td></tr>
<tr><td class=text>
<?PHP
	if ($_GET[Error]) print "<div width=100% style=\"border: 1px dashed; background=E99898; padding: 2px; margin: 2px;\"><FONT COLOR=RED><B>Notice:</B></FONT> ".base64_decode($_GET[Error])."</div><br>";
?>


<table class=pagecontainer>

<tr><td class=text>Email</td><td class=pagecell><INPUT TYPE=TEXT MAXLENGTH=50 NAME=register_email></td><td rowspan=2 valign=top width=100% class=text>
<?PHP
	print join("\n",file("./text/register_message.html"));
?>

</td></tr>
<tr><td class=text>Confirm Email</td><td class=pagecell><INPUT TYPE=TEXT MAXLENGTH=50 NAME=register_email_two></td></tr>
</table>

</td></tr>
<tr><td class=footer style="border-top: 1px black solid">
<INPUT TYPE=SUBMIT NAME=SUBMIT STYLE="width=100px;" VALUE=Register>
</td></tr>

</FORM>
</table>

<?php
include_once("./system/footer.php");


function randPass($len)
{
 $pw = ''; //intialize to be blank
 for($i=0;$i<$len;$i++)
 {
   switch(rand(1,3))
   {
     case 1: $pw.=chr(rand(48,57));  break; //0-9
     case 2: $pw.=chr(rand(65,90));  break; //A-Z
     case 3: $pw.=chr(rand(65,90));  break; //A-Z
   }
 }
 return $pw;
}

function SendMail($email,$pass) {
	$headers = "";
	$headers .= "From: Delt <support@support.com>\r\n";
	$subject = "Welcome to Delt $email!";
	$message = "Your randomly generated password has been created and your account is made.\n\n";
	$message .= "You may login at http://blah.com at any time using the password supplied ";
	$message .= "below and your email address. Please note that the password supplied is case ";
	$message .= "sensitive.\n\n";
	$message .= "Your password is $pass";
	mail($email,$subject,$message,$headers);
	//	print "Mail sent to $email with the password to login to Delt with.<br>";
}

?>