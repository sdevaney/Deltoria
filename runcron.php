#!/usr/bin/php
<?
// Runs our cron jobs very important
include ("./system/dbconnect.php");

$sth1 = mysql_query("select HeartID, RunEvery, RunTime, ModCode from heartbeat where Enabled like '%Y%'") or die ('Error: '.mysql_error ());

while($datab = mysql_fetch_array($sth1))
{
	$time = $datab['RunTime'];
	$time = $time-1;

	if ($time <= 0) 
	{
		$runcode = $datab['ModCode'];
		eval($runcode);
		$time = $datab['RunEvery'];
	}
	$sth2 = mysql_query("update heartbeat set RunTime=$time where HeartID=".$datab['HeartID']."");
}

?>