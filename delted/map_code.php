<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
session_start();
global $userdata,$config;

require_once("./includes/config.php");
require_once("./includes/common.php");
require_once("./includes/db_connect.php");
require_once("./includes/user.php");

print "<SELECT NAME=CodeLoc>";
$sth = mysql_query("select MapID, Name from mapid_background order by Name");
while(list($MapID, $Name)=mysql_fetch_row($sth)) {
	print "<OPTION VALUE=$MapID>$Name";
}

?>