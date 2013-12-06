<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Who is on page
$sth = mysql_query("select U.Age, C.Name, U.Level,U.Username,UNIX_TIMESTAMP()-UNIX_TIMESTAMP(U.LastAccessed) as IdleTime,DATE_FORMAT(U.LastAccessed,'%b %D. %r') as LastAccessed from user as U left join clans as C on C.ClanID=U.ClanID where DATE_ADD(U.LastAccessed,INTERVAL 1 HOUR) > NOW() order by IdleTime");
print "<table class=Box1>";
print "<tr><td class=Header colspan=5>Whos on within the last hour</td></tr>";
print "<tr><td class=menu>Username</td><Td class=Menu>Level</td><td class=Menu>Age</td><Td class=menu>Clan</td><Td class=Menu>Idle Time</td></tr>";

while ($UData = mysql_fetch_array($sth)) {
	$Age_Years = floor($UData[Age] / 365);
	$Age_Days = $UData[Age] - ($Age_Years * 365); # 2
	if ($Age_Days < 30) { $Age_Months = 0; } else { $Age_Months = floor($Age_Days / 30); }
 	$Age_Days = $UData[Age] - (($Age_Years * 365) + ($Age_Months * 30));
	if ($UData[IdleTime] < 60) { $IdleAmount = $UData[IdleTime]." seconds"; } else { $IdleAmount = floor($UData[IdleTime] / 60)." minutes"; }
	print "<Tr><td>$UData[Username]</TD><TD>$UData[Level]</TD><TD>$Age_Years years $Age_Months months $Age_Days days</TD><TD>$UData[Name]</TD><TD>$IdleAmount</TD></TR>";
}
print "</TABLE><P>";

?>