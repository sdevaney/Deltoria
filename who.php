<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Who is on page, lots of old commented code need to clean up
########################
## Make us our connection
global $db;
include ("./system/top.php");

include ("./system/chatter.php");

include ("./system/move.php");

/*if ($Cloak=="N" || $Cloak=="Y") {
	$sth3 = mysql_query("select Admin from user where CoreID = $PlayerData->CoreID");
	$UData3 = mysql_fetch_array($sth3);
        if($UData3[Admin] == "Y") {
		$PlayerData->AdjustValue("cloak",$Cloak);
	} else {
		print "You are not an admin so you cannot hide from anyone :p";
	}
}*/

/*($ChatRows != "") {
        $sth = mysql_query("update user set ChatRows='".intval($ChatRows)."' where CoreID=$PlayerData->CoreID");
        print mysql_error();
        $PlayerData->ChatRows = $ChatRows;
}*/

$sth = mysql_query("select UB.FundDate,UB.Subscriber, U.Age, C.Name, U.Level,U.Username, U.cloak, UNIX_TIMESTAMP()-UNIX_TIMESTAMP(U.LastAccessed) as IdleTime,DATE_FORMAT(U.LastAccessed,'%b %D. %r') as LastAccessed from user as U left join clans as C on C.ClanID=U.ClanID left join user_base as UB on UB.UserID=U.UserID where U.cloak != 'Y' && DATE_ADD(U.LastAccessed,INTERVAL 1 HOUR) > NOW() order by IdleTime");
print "<table class=Box1>";
print "<tr><td class=Header colspan=6>Whos on within the last hour</td></tr>";
print "<tr><td class=menu>Username</td><Td class=Menu>Level</td><td class=Menu>Age</td><Td class=menu>Clan</td><td class=menu>Sub</td><Td class=Menu>Idle Time</td></tr>";
$NumLogged = mysql_num_rows($sth);

while ($UData = mysql_fetch_array($sth)) {
	$Age_Years = floor($UData[Age] / 365);
	$Age_Days = $UData[Age] - ($Age_Years * 365); # 2
	if ($Age_Days < 30) { $Age_Months = 0; } else { $Age_Months = floor($Age_Days / 30); }
 	$Age_Days = $UData[Age] - (($Age_Years * 365) + ($Age_Months * 30));
	if ($UData[IdleTime] < 60) { $IdleAmount = $UData[IdleTime]." seconds"; } else { $IdleAmount = floor($UData[IdleTime] / 60)." minutes"; }
	print "<Tr><td>$UData[Username]</TD><TD>$UData[Level]</TD><TD>$Age_Years years $Age_Months months $Age_Days days</TD><TD>$UData[Name]</TD><TD>$UData[Subscriber] ";
	if ($PlayerData->Admin == "Y" && $UData[Subscriber] == "Y") print $UData['FundDate'];
	print"</TD><TD>$IdleAmount</TD></TR>";
}
print "<Tr><Td class=footer colspan=6>$NumLogged users listed</td></tr>";
print "</TABLE><P>";

$sth2 = mysql_query("select Admin from user where CoreID = $PlayerData->CoreID");
$UData2 = mysql_fetch_array($sth2);
/*	if($UData2[Admin] == "Y") {
		print "<table border=1 class=Box1 width=340>";
		print "<Tr><Td colspan=2 class=Header>Hide</td></tr>";
		print "<tr><td colspan=2>";
		print "Do you wish to hide yourself from being seen on Who's On:";
		print "<P><CENTER>Your current setting is: $PlayerData->Cloak</CENTER>";
		print "</TD></TR><TR><TD CLASS=FOOTER>";
		print "<A HREF=$SCRIPT_NAME?Cloak=N><IMG BORDER=0 SRC=./images/buttons/Show.jpg></A>";
		print "<A HREF=$SCRIPT_NAME?Cloak=Y><IMG BORDER=0 SRC=./images/buttons/Hide.jpg></A>";
		print "</TD></TR></TABLE><P>";
	}
*/

/*$sth = mysql_query("select U.Age, C.Name, U.Level,U.Username,UNIX_TIMESTAMP()-UNIX_TIMESTAMP(U.LastAccessed) as IdleTime,DATE_FORMAT(U.LastAccessed,'%b %D. %r') as LastAccessed from user as U left join clans as C on C.ClanID=U.ClanID where Admin != 'Y' && CoreID != 5221 && CoreID != 8447 && CoreID != 3833 && CoreID != 8448 order by Level DESC limit 50");
print "<table class=Box1>";
print "<tr><td class=Header colspan=5>Top 50</td></tr>";
print "<tr><td class=menu>Rank</td><td class=menu>Username</td><Td class=Menu>Level</td><td class=Menu>Age</td><Td class=menu>Clan</td></tr>";
$Rank = 0;
while ($UData = mysql_fetch_array($sth)) {
	$Rank++;
	$Age_Years = floor($UData[Age] / 365);
	$Age_Days = $UData[Age] - ($Age_Years * 365); # 2
	if ($Age_Days < 30) { $Age_Months = 0; } else { $Age_Months = floor($Age_Days / 30); }
 	$Age_Days = $UData[Age] - (($Age_Years * 365) + ($Age_Months * 30));
	if ($UData[IdleTime] < 60) { $IdleAmount = $UData[IdleTime]." seconds"; } else { $IdleAmount = floor($UData[IdleTime] / 60)." minutes"; }
	print "<Tr><td>$Rank</td><td>$UData[Username]</TD><TD>$UData[Level]</TD><TD>$Age_Years years $Age_Months months $Age_Days days</TD><TD>$UData[Name]</TD></TR>";
}
print "</TABLE><P>";*/

/*	print "<table border=1 class=Box1 width=340>";
	print "<Tr><Td colspan=2 class=Header>Chat Rows</td></tr>";
	print "<tr><td colspan=2>";
	print "How many rows of chat would you like to see? (0 disables chat)";
	print "<P><CENTER>Your current setting is: ".$PlayerData->ChatRows."</CENTER>";
	print "</TD></TR><TR><FORM ACTION=who.php><TD CLASS=FOOTER>";
	print "<INPUT NAME=ChatRows TYPE=TEXT SIZE=3 MAXLENGTH=3 VALUE=\"".intval($PlayerData->ChatRows)."\"><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Set>";
	print "</TD></FORM></TR></TABLE><P>";
*/

/*$sth = mysql_query("select U.Deaths,U.Age, C.Name, U.Level,U.Username,UNIX_TIMESTAMP()-UNIX_TIMESTAMP(U.LastAccessed) as IdleTime,DATE_FORMAT(U.LastAccessed,'%b %D. %r') as LastAccessed from user as U left join clans as C on C.ClanID=U.ClanID order by Deaths DESC limit 25");
print "<table class=Box1>";
print "<tr><td class=Header colspan=6>Top 25 Deaths</td></tr>";
print "<tr><td class=menu>Ranks</td><td class=menu>Deaths</td><td class=menu>Username</td><Td class=Menu>Level</td><td class=Menu>Age</td><Td class=menu>Clan</td></tr>";
$Rank = 0;
while ($UData = mysql_fetch_array($sth)) {
	$Rank++;
	$Age_Years = floor($UData[Age] / 365);
	$Age_Days = $UData[Age] - ($Age_Years * 365); # 2
	if ($Age_Days < 30) { $Age_Months = 0; } else { $Age_Months = floor($Age_Days / 30); }
	$Age_Days = $UData[Age] - (($Age_Years * 365) + ($Age_Months * 30));
	if ($UData[IdleTime] < 60) { $IdleAmount = $UData[IdleTime]." seconds"; } else { $IdleAmount = floor($UData[IdleTime] / 60)." minutes"; }
	print "<Tr><td>$Rank</td><Td>$UData[Deaths]</td><td>$UData[Username]</TD><TD>$UData[Level]</TD><TD>$Age_Years years $Age_Months months $Age_Days days</TD><TD>$UData[Name]</TD></TR>";
}
print "</TABLE><P>";*/


include ("./system/bottom.php");


?>