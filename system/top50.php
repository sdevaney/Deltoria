<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Top 50 players
global $db, $CoreUserData;;

$sth = mysql_query("select U.XP, C.Name, U.Level,U.Username,UNIX_TIMESTAMP()-UNIX_TIMESTAMP(U.LastAccessed) as IdleTime,DATE_FORMAT(U.LastAccessed,'%b %D. %r') as LastAccessed from user as U left join clans as C on C.ClanID=U.ClanID where Admin != 'Y' && CoreID != 5221 && CoreID != 8447 && CoreID != 8448 && DATE_ADD(U.LastAccessed,INTERVAL 7 DAY) > NOW() order by U.XP DESC limit 10");
print "<table class=Box1>";
print "<tr><td class=Header colspan=5>Top 10 - Active Players</td></tr>";
print "<tr><td class=menu>Rank</td><td class=menu>Username</td><Td class=Menu>Level</td><td class=Menu>Total XP</td><Td class=menu>Clan</td></tr>";
$Rank = 0;
while ($UData = mysql_fetch_array($sth)) {
	$Rank++;
//	$Age_Years = floor($UData[Age] / 365);
//	$Age_Days = $UData[Age] - ($Age_Years * 365); # 2
//	if ($Age_Days < 30) { $Age_Months = 0; } else { $Age_Months = floor($Age_Days / 30); }
// 	$Age_Days = $UData[Age] - (($Age_Years * 365) + ($Age_Months * 30));
	if ($UData[IdleTime] < 60) { $IdleAmount = $UData[IdleTime]." seconds"; } else { $IdleAmount = floor($UData[IdleTime] / 60)." minutes"; }
	print "<Tr><td>$Rank</td><td>$UData[Username]</TD><TD>$UData[Level]</TD><TD>$UData[XP]</TD><TD>$UData[Name]</TD></TR>";
}
print "</TABLE><P>";

$sth = mysql_query("select U.XP, C.Name, U.Level,U.Username,UNIX_TIMESTAMP()-UNIX_TIMESTAMP(U.LastAccessed) as IdleTime,DATE_FORMAT(U.LastAccessed,'%b %D. %r') as LastAccessed from user as U left join clans as C on C.ClanID=U.ClanID where Admin != 'Y' && CoreID != 5221 && CoreID != 8447 && CoreID != 8448 order by U.XP DESC limit 50");
print "<table class=Box1>";
print "<tr><td class=Header colspan=5>Top 50 - All Players</td></tr>";
print "<tr><td class=menu>Rank</td><td class=menu>Username</td><Td class=Menu>Level</td><td class=Menu>Total XP</td><Td class=menu>Clan</td></tr>";
$Rank = 0;
while ($UData = mysql_fetch_array($sth)) {
	$Rank++;
//	$Age_Years = floor($UData[Age] / 365);
//	$Age_Days = $UData[Age] - ($Age_Years * 365); # 2
//	if ($Age_Days < 30) { $Age_Months = 0; } else { $Age_Months = floor($Age_Days / 30); }
// 	$Age_Days = $UData[Age] - (($Age_Years * 365) + ($Age_Months * 30));
	if ($UData[IdleTime] < 60) { $IdleAmount = $UData[IdleTime]." seconds"; } else { $IdleAmount = floor($UData[IdleTime] / 60)." minutes"; }
	print "<Tr><td>$Rank</td><td>$UData[Username]</TD><TD>$UData[Level]</TD><TD>$UData[XP]</TD><TD>$UData[Name]</TD></TR>";
}
print "</TABLE><P>";

?>