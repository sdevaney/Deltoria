#!/usr/local/bin/php -q
<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// This cleans all users
// error_reporting(E_ALL);

include_once("../system/dbconnect.php");
$deluser = mysql_query("select Username,CoreID from user where LastAccessed < DATE_SUB(NOW(),INTERVAL 2 MONTH)");
if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
while (list($Username,$CoreID) = mysql_fetch_row($deluser)) {
	print "$CoreID\t$Username\n";
	$Csth = mysql_query("select ClanID from clans where Founder=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	if (mysql_num_rows($Csth) > 0) {
		while (list($ClanID) = mysql_fetch_row($Csth)) {
			$sth = mysql_query("delete from clans where Founder=$CoreID");
			if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
			$sth = mysql_query("update user set ClanID=0 where ClanID=$ClanID");
			if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
			$sth = mysql_query("delete from clan_buildings where ClanID=$ClanID");
			if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
			$sth = mysql_query("delete from clan_pins where ClanID=$ClanID");
			if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
			$sth = mysql_query("delete from clan_warriors where ClanID=$ClanID");
			if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
			$sth = mysql_query("delete from chatter where ClanID=$ClanID");
			if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
			$sth = mysql_query("delete from forums_index where ClanID=$ClanID");
			if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
			$sth = mysql_query("delete from forums_posts where ClanID=$ClanID");
			if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
		}
	}
	$Isth = mysql_query("select ItemID from items where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	while (list($ItemID) = mysql_fetch_row($Isth)) {
		mysql_query("delete from item_defined_spells where ItemID=$ItemID");
		if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	}
	$sth = mysql_query("delete from battle_user where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from user where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from items where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from mail where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from mail where From_CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from mail_folder where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from user_block where CoreID=$CoreID or BlockID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from user_deaths where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from user_kills where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from user_log where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from user_pin where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from user_quest where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from user_skills where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from user_values where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
	$sth = mysql_query("delete from userspell where CoreID=$CoreID");
	if (mysql_error()) echo "ERROR: 1 : ".mysql_error()."\n";
}

?>

