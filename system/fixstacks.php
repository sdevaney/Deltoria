#!/usr/bin/php -q
<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
Allows stackable item
        $db = mysql_connect("localhost","db_user","db_pass");
        mysql_select_db("db_name");
	include("lootgen.php");



#+-----------------------+--------+
#| Name                  | ItemID |
#+-----------------------+--------+
#| Lightless Helm        |     53 |
#| Lightless Boots       |     54 |
#| Lightless Bracers     |     55 |
#| Lightless Breastplate |     56 |
#| Lightless Gauntlets   |     57 |
#| Lightless Leggings    |     58 |
#| Lightless Sleeves     |     59 |
#+-----------------------+--------+

	$UID = $argv[1]; # '39
	$ItemID = $argv[2];  # 121=DeathstoneRecall      28=Ancient Jewel   153=Titan Health
	$Number = 1;

        $numb = LootGen(0,$UID,5,5,1,$ItemID,20,$Number,25);
	while ($numb == 0) {
	        $numb = LootGen(0,$UID,5,5,1,$ItemID,20,$Number,25);
	}
        function make_seed() {
            list($usec, $sec) = explode(' ', microtime());
            return (float) $sec + ((float) $usec * 100000);
        }


# LootGen($SpawnID,$CoreID,$X,$Y,$MapID,$ItemID,$Level,$Stack,$Magic) 
?>