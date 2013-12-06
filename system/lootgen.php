<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
//Generate Item
function SimpleGen($ItemID) {
	global $PlayerData;

	$numb = LootGen(0,$PlayerData->CoreID,$PlayerData->X,$PlayerData->Y,$PlayerData->MapID,$ItemID,1,1,0);
        while ($numb == 0) {
		$numb = LootGen(0,$PlayerData->CoreID,$PlayerData->X,$PlayerData->Y,$PlayerData->MapID,$ItemID,1,1,0);
        }
}
// Give item to player
function ItemGenToPlayer($CoreID,$ItemID) {
	$numb = LootGen(0,$CoreID,0,0,0,$ItemID,1,1,0);
        while ($numb == 0) {
		$numb = LootGen(0,$CoreID,0,0,0,$ItemID,1,1,0);
        }
}


function LootGen($SpawnID,$CoreID,$X,$Y,$MapID,$ItemID,$Level,$Stack,$Magic) {
	global $PlayerData;

	mt_srand(make_seed());

	$sth = mysql_query("select * from items_base where ItemID=$ItemID");
	print mysql_error();
	$ItemData = mysql_fetch_array($sth);

	if ($CoreID != 0) $ItemData[DropRate] = 0;
	if ($ItemData[DropRate] > 0) {
		mt_srand(make_seed());
		$RndNumb = mt_rand(1,100);
		if ($ItemData[DropRate] <= $RndNumb) { return 0; }
	}
// Armor levels info
	if ($ItemData[ItemType] == "Armor") {
		/*
			Armor Levels
			 0% to 30%  - 50%
			31% to 75%  - 40%
			76% to 90%  - 7%
			92% to 100% - 3%
		*/

		$RndNumb = mt_rand(1,100);

		if ($ItemData[Defined] == "Y") {
			$AL = $ItemData[Defined_AL];
		} else {
			if ($RndNumb <= 50) {
				$AL = mt_rand($ItemData[MaxAL] * .7,$ItemData[MaxAL] * .75);
			} elseif ($RndNumb >= 51 && $RndNumb <= 90) {
				$AL = mt_rand($ItemData[MaxAL] * .75,$ItemData[MaxAL] * .80);
			} elseif ($RndNumb >= 91 && $RndNumb <= 97) {
				$AL = mt_rand($ItemData[MaxAL] * .81,$ItemData[MaxAL] * .9);
			} else {
				$AL = mt_rand($ItemData[MaxAL] * .91,$ItemData[MaxAL]);
			}
		}

		if ($ItemData[Defined_Value] == 0) {
			$Value = ($AL * .1) + ($ItemData[MaxAL] * .1);
		} else {
			$Value = $ItemData[Defined_Value];
		}

		$sth = mysql_query("insert into items (ObjectID,ItemID,ItemStack,AL,Value,DecayTime,X,Y,MapID,CoreID,Equiped) values (0,$ItemID,$Stack,$AL,$Value,DATE_ADD(NOW(),INTERVAL 10 MINUTE),$X,$Y,$MapID,$CoreID,'N')");
		if (mysql_error()) print "Error creating Armor: ".mysql_error()."<BR>";

		$Item = mysql_insert_id();

		$RndNumb = mt_rand(1,100);

		CheckSpells($ItemID,$Item);

		if ($Magic > 0 && $RndNum >= 97) {
			AddSpell("Enchant",$Magic,$Item);
		}
	} elseif ($ItemData[ItemType] == "Weapon") {
		// $ItemData[MaxAL];
		

		if ($ItemData[Defined] != "Y") {
			$RndNumb = mt_rand(1,100);
			if ($RndNumb <= 50) {
				$MaxDam = mt_rand(2,$ItemData[MaxAL] * .3);
			} elseif ($RndNumb >= 51 && $RndNumb <= 90) {
				$MaxDam = mt_rand($ItemData[MaxAL] * .3,$ItemData[MaxAL] * .75);
			} elseif ($RndNumb >= 91 && $RndNumb <= 97) {
				$MaxDam = mt_rand($ItemData[MaxAL] * .76,$ItemData[MaxAL] * .9);
			} else {
				$MaxDam = mt_rand($ItemData[MaxAL] * .91,$ItemData[MaxAL]);
			}
			$MinDam = mt_rand($MaxDam * .2,$MaxDam * .3);
			$LevelReq = 0;
		}
// If item is defined in editor you get to use bonus' and damage mods and enchantments on items
		if (mt_rand(0,100) >= 98) { $DamageMod = mt_rand(0,100); } else { $DamageMod = 0; }
		if (mt_rand(0,100) >= 98) { $AttackBonus = mt_rand(0,10); } else { $AttackBonus = 0; }
		if (mt_rand(0,100) >= 98) { $MeleeBonus = mt_rand(0,10); } else { $MeleeBonus = 0; }


		if ($ItemData[Defined_Value] > 0) {
			$Value = $ItemData[Defined_Value];
		} else {
			$Value = ($MinDam + $MaxDam ) * .05;
		}

		if ($ItemData[Defined] == "Y") {
			$MinDam = $ItemData[Defined_MinDam];
			$MaxDam = $ItemData[Defined_MaxDam];
			$MeleeBonus = $ItemData[Defined_MeleeBonus];
			$AttackBonus = $ItemData[Defined_AttackBonus];
			$DamageMod = $ItemData[Defined_DamageMod];
			$LevelReq = $ItemData[Defined_LevelReq];
		}

		$sth = mysql_query("insert into items (ObjectID,ItemID,ItemStack,DamageMod,AttackBonus,MeleeBonus,MinDam,MaxDam,Value,DecayTime,X,Y,MapID,CoreID,Equiped) values (0,$ItemID,$Stack,$DamageMod,$AttackBonus,$MeleeBonus,$MinDam,$MaxDam,$Value,DATE_ADD(NOW(),INTERVAL 10 MINUTE),$X,$Y,$MapID,$CoreID,'N')");
		if (mysql_error()) print "<B>Error creating Weapon</B>: ".mysql_error()."<BR>";

		$Item = mysql_insert_id();

		$RndNumb = mt_rand(1,100);
		if ($Magic > 0 && $RndNum >= 97) {
			AddSpell("Enhance",$Magic,$Item);
		}
		CheckSpells($ItemID,$Item);

	} elseif ($ItemData[ItemType] == "Jewlery") {
		if ($ItemData[Defined_Value] > 0) {
			$Value = $ItemData[Defined_Value];
		} else {
			$Value = mt_rand(1,5);
		}

		$sth = mysql_query("insert into items (ObjectID,ItemID,ItemStack,Value,DecayTime,X,Y,MapID,CoreID,Equiped) values (0,$ItemID,$Stack,$Value,DATE_ADD(NOW(),INTERVAL 10 MINUTE),$X,$Y,$MapID,$CoreID,'N')");
		if (mysql_error()) print "Error creating Jewlery: ".mysql_error()."<BR>";

		print mysql_error();

		$Item = mysql_insert_id();

		$RndNumb = mt_rand(1,100);
		if ($Magic > 0 && $RndNum >= 97) {
			AddSpell("Enchant",$Magic,$Item);
		}

		CheckSpells($ItemID,$Item);


		// Potion, etc.
	} else {
		if ($ItemData[ItemType] == "Potion" || $ItemData[ItemType] == "Usable" || $ItemData[ItemType] == "Misc" || $ItemData[ItemType] == "Tool") {
			if ($CoreID == 0) {
				$sth = mysql_query("select ObjectID,ItemStack from items where CoreID=$CoreID and Banked='N' and X=$X and Y=$Y and MapID=$MapID and ItemID=$ItemData[ItemID]");
			} else {
				$sth = mysql_query("select ObjectID,ItemStack from items where CoreID=$CoreID and Banked='N' and ItemID=$ItemData[ItemID]");
			}
			print mysql_error();

			if (mysql_num_rows($sth) > 0 && $ItemData[Stackable] == "Y") {	
				list($Item,$ItemStack) = mysql_fetch_row($sth);
				$sth = mysql_query("update items set ItemStack=ItemStack+$Stack where ObjectID=$Item");
				print mysql_error();
			} else {
				$sth = mysql_query("insert into items (ItemID,ItemStack,Value,DecayTime,X,Y,MapID,CoreID) values ($ItemID,$Stack,$ItemData[Defined_Value],DATE_ADD(NOW(),INTERVAL 10 MINUTE),$X,$Y,$MapID,$CoreID)");
				print mysql_error();
				$Item = mysql_insert_id();
			}
		} else {
			$Burden = 10;
			$sth = mysql_query("select ObjectID,ItemStack from items where CoreID=$CoreID and Banked='N' and ItemID=$ItemData[ItemID] and ItemStack < $ItemData[MaxStack]");
			print mysql_error();
			if (mysql_num_rows($sth) > 0 && $ItemData[Stackable] == "Y") {	
				list($Item,$ItemStack) = mysql_fetch_row($sth);
				if ($ItemStack+$Stack > $ItemData[MaxStack]) {
					$Stack = $Stack - $ItemData[MaxStack] - $ItemStack;
					$sth = mysql_query("update items set ItemStack=ItemStack+".intval($ItemData[MaxStack] - $ItemStack)." where ObjectID=$Item");
				} else {
					$sth = mysql_query("update items set ItemStack=ItemStack+$Stack where ObjectID=$Item");
				}
			}

			while ($Stack > 0) {
				if ($Stack > $ItemData[MaxStack]) {
					$sth = mysql_query("insert into items (ItemID,ItemStack,Value,DecayTime,X,Y,MapID,CoreID) values ($ItemID,$ItemData[MaxStack],$ItemData[Defined_Value],DATE_ADD(NOW(),INTERVAL 10 MINUTE),$X,$Y,$MapID,$CoreID)");
					$Stack = $Stack - $ItemData[MaxStack];

					$Item = mysql_insert_id();
				} else {
					$sth = mysql_query("insert into items (ItemID,ItemStack,Value,DecayTime,X,Y,MapID,CoreID) values ($ItemID,$Stack,$ItemData[Defined_Value],DATE_ADD(NOW(),INTERVAL 10 MINUTE),$X,$Y,$MapID,$CoreID)");
					$Stack = 0;

					$Item = mysql_insert_id();
				}
			}

		}
		if (mysql_error()) print "<B>Error creating Potion/Usable</b>: ".mysql_error()."<BR>";
	}

//	if ($CoreID == $PlayerData->CoreID) {
//		$PlayerData->Inventory[$Item] = new Inventory_Item($CoreID,$Item);
//	}

//	print "<BR><B>RETURNING: $Item</B><BR>";
	return $Item;
}

// Adding enchantments to items
Function AddSpell($SpellType,$Magic,$Item) {
	return 0;
	$Magic = rand($Magic * .5,$Magic * 1.25);
	$sth = mysql_query("select * from spells where SpellType='$SpellType' and War='No' order by rand() limit 1");
	$SpellData = mysql_fetch_array($sth);

	if ($SpellData[Family] == "Protections") {
		$Adjustment = $Magic / 5 + 10;
	} elseif ($SpellData[Family] == "Attributes") {
		$Adjustment = $Magic / 5 + 5;
	} elseif ($SpellData[Family] == "Drains") {
		$Adjustment = $Magic / 10 + 5;
	} elseif ($SpellData[Family] == "Direct_Damage") {
		$Adjustment = $Magic * 2;
	} elseif ($SpellData[Family] == "Skills") {
		$Adjustment = $Magic / 5 + 5;
	} elseif ($SpellData[Family] == "Direct") {
		$Adjustment = $Magic / 2 + 25;
	} elseif ($SpellData[Family] == "Transportation") {
		$Adjustment = $Magic;
	} else {
		DebugPrint("$SpellData[Name] has an invalid Family: $SpellData[Name]");
		$Adjustment = 0;  // Invalid Family
	}

	$SkillReq = mt_rand($Magic * .1,$Magic * .2);
	$sth = mysql_query("update items set AttunementReq = $SkillReq where ObjectID=$Item");
	print mysql_error();
	$sth = mysql_query("insert into itemspells (Adjustment,ObjectID,SpellID) values ($Adjustment,$Item,$SpellData[SpellID])");
	print mysql_error();
}

function CheckSpells($ItemID,$Item) {
	$sth = mysql_query("select * from items_base_spells where ItemID=$ItemID");
	print mysql_error();
	while ($data = mysql_fetch_array($sth)) {
		$sth_ins = mysql_query("insert into itemspells (ObjectID,SpellID,Adjustment) values ($Item,$data[SpellID],$data[Adjustment])");
		print mysql_error();
	}
}


?>