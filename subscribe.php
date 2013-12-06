<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Your player subscription page
########################
## Make us our connection
global $db, $CoreUserData;;
include ("./system/top.php");

include ("./system/move.php");
	
print "<table border=0 class=pageContainer>";
print "<tr><td class=pageCell valign=top>";
include ("./system/subscribe.php");
print "</td><td class=pageCell valign=top>";
print "</td></tr>";
print "</table>";
	
include ("./system/bottom.php");



?>