#!/usr/bin/php -q
<? 
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Used like in game cron jobs
	print date('D F jS Y h:mA')."\n";
	$Path = explode("/",realpath(__FILE__));
	array_pop($Path);
	$Path = implode("/",$Path);

	include("$Path/../system/dbconnect.php");
	$sth = mysql_query("update heartbeat set RunTime=RunEvery where RunTime=0");
	print mysql_error();
	$sth = mysql_query("update heartbeat set RunTime = RunTime -1 where RunTime > 0");
	print mysql_error();
	$sth_GETCODE = mysql_query("select Name,ModCode from heartbeat where RunTime = 0");
	print mysql_error();
	while ($HeartData = mysql_fetch_array($sth_GETCODE)) {
		print "  Running $HeartData[Name]\n";
		eval($HeartData[ModCode]);
	}
	print "\n";
      
?>
