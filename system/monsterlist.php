<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// A list of all monsters a player has killed and the kill count
global $db, $CoreUserData;;

print "<table border=0 class=Box1 width=340>";
print "<Tr><Td class=header colspan=2>Kill Counters</td></tr>";
print "<Tr><Td class=menu>Monster</td><td class=Menu>Kills</td></tr>";
$sth = mysql_query("select uk.Counter,mb.Name from user_kills as uk left join monster_base as mb on mb.MonsterID=uk.MonsterID where uk.CoreID=".$PlayerData->CoreID." order by mb.Name");
while ($MData = mysql_fetch_array($sth)) {
	print "<Tr><Td>$MData[Counter]</td><Td>$MData[Name]</td></tr>";
}
print "</table><p>";

?>