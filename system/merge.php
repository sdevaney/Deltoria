#!/usr/bin/php -q
<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Merging of two items to create new
        $db = mysql_connect("localhost","dbuser","dbpass");
        mysql_select_db("dbname");
	include("lootgen.php");

	$usth = mysql_query("select CoreID,Username from user where CoreID=262");
	print mysql_error();
	while (list($CoreID,$Username) = mysql_fetch_row($usth)) {
		print "Fixing $Username\n";
		$sth = mysql_query("select ItemID,sum(ItemStack) from items where OwnerID=$CoreID and ItemID in (19,20,149,150,151,152,153,154,329,330,331,332,333,334,339) group by ItemID");
		print mysql_error();
		while (list($ItemID,$StackAmount) = mysql_fetch_row($sth)) {
			$sth_del = mysql_query("delete from items where OwnerID=$CoreID and ItemID=$ItemID");
			print mysql_error();
		        $numb = LootGen(0,$CoreID,5,5,1,$ItemID,1,$StackAmount,25);
		}
	}


        function make_seed() {
            list($usec, $sec) = explode(' ', microtime());
            return (float) $sec + ((float) $usec * 100000);
        }

?>