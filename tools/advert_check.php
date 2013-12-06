#!/usr/local/bin/php -q
<? 
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Checks to see if player wants to see adverts or not. Only availavle to subscribers.
	print date('D F jS Y h:mA')."\n";
	$Path = explode("/",realpath($_SERVER['PHP_SELF']));
	array_pop($Path);
	$Path = implode("/",$Path);

	include("$Path/../system/dbconnect.php");

	$sth = mysql_query("select U.Advertisment,UB.Subscriber,U.UserID,U.CoreID from user as U left join user_base as UB on UB.UserID=U.UserID where U.Advertisment='N' and UB.Subscriber='N'");
	while ($data = mysql_fetch_array($sth)) {
		mysql_query("update user set Advertisment='Y' where CoreID='".$data['CoreID']."' limit 1");
		print mysql_error();
	}

	$sth = mysql_query("select U.Advertisment,UB.Subscriber,U.UserID,U.CoreID from user as U left join user_base as UB on UB.UserID=U.UserID where U.Advertisment='Y' and UB.Subscriber='Y'");
	while ($data = mysql_fetch_array($sth)) {
		mysql_query("update user set Turns=Turns+1,Actions=Actions+1 where CoreID='".$data['CoreID']."' limit 1");
		print mysql_error();
	}


?>
