<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Work in progress of new lootgen
function LootGen($SpawnID,$CoreID,$X,$Y,$MapID,$ItemID,$Level,$Stack,$Magic) {
	mt_srand(make_seed());

	$sth = mysql_query("select * from items_base where ItemID=$ItemID");
	print mysql_error();
	$ItemData = mysql_fetch_array($sth);

	if ($ItemData[ItemStack] < 1) { $ItemData[ItemStack] = 1; }
	if ($ItemData[MaxStack] < 1) { $ItemData[MaxStack] = 1; }

	if ($ItemData[DropRate] > 0) {
		mt_srand(make_seed());
		$RndRate = mt_rand(1,100);
		if ($ItemData[DropRate] <= $RndRate) { return 0; }
	}

	if ($ItemData[ItemType] == "Armor") {
		if ($ItemData[MaxAL] == 0) { $ItemData[MaxAL] = 30; }
		$AL = $Level + mt_rand(1,$Level * 5);
		if ($AL > $ItemData[MaxAL]) {
			$AL = mt_rand(intval($ItemData[MaxAL] / 3),$ItemData[MaxAL]);
		}
		$PierceMod = GenMod();
		$SlashMod = GenMod();
		$BludgMod = GenMod();
		$FireMod = GenMod();
		$ColdMod = GenMod();
		$ElecMod = GenMod();
		$AcidMod = GenMod();
		if ($ItemData[Defined_Value] == 0) {
			$Value = ($AL + $SlashMod + $BludgMod + $FireMod + $ColdMod + $ElecMod + $AcidMod) * 10;
			$Value = mt_rand($Value / 2,$Value);
		} else {
			$Value = $ItemData[Defined_Value];
		}

		if ($ItemData[Defined] == "Y") {
			$AL = $ItemData[Defined_AL];
			$PierceMod = $ItemData[Defined_PierceMod];
			$SlashMod = $ItemData[Defined_SlashMod];
			$BludgMod = $ItemData[Defined_BludgMod];
			$FireMod = $ItemData[Defined_FireMod];
			$ColdMod = $ItemData[Defined_ColdMod];
			$ElecMod = $ItemData[Defined_ElecMod];
			$AcidMod = $ItemData[Defined_AcidMod];
		}
		
		
		$sth = mysql_query("insert into items values (0,$ItemID,$Stack,$AL,$SlashMod,$PierceMod,$BludgMod,$FireMod,$ColdMod,$ElecMod,$AcidMod,0,0,0,0,0,0,'',0,$Value,DATE_ADD(NOW(),INTERVAL 10 MINUTE),$X,$Y,$MapID,$CoreID,'No',0,'',0,'',0,NULL,$SpawnID,0,0,255)");
		print mysql_error();
	} elseif ($ItemData[ItemType] == "Weapon") {
		$MinDam = mt_rand(1,5);
		$MaxDam = mt_rand($MinDam + 3,($Level * 2));
		
		if (mt_rand(0,100) > 90) { $DamageMod = mt_rand(0,100); } else { $DamageMod = 0; }
		if (mt_rand(0,100) > 90) { $AttackBonus = mt_rand(0,10); } else { $AttackBonus = 0; }
		if (mt_rand(0,100) > 90) { $MeleeBonus = mt_rand(0,10); } else { $MeleeBonus = 0; }

		if ($ItemData[DamageType] == "Random") {
			if (rand(1,100) < 15) {
				$Types = array('Fire','Ice','Lightning','Acid');
				$HitType = $Types[mt_rand(0,3)];			
			} else {
				$Types = array('Pierce','Slashing','Bludgeon');
				$HitType = $Types[mt_rand(0,2)];			
			}
		} elseif (mt_rand(1,100) > 90) {
			$Types = array('Fire','Ice','Lightning','Acid');
			$HitType = $Types[mt_rand(0,3)];
		} else {
			$HitType = $ItemData[DamageType];
		}

		$Value = ($MinDam + ($MaxDam * 100) + $DamageMod + $AttackBonus + $MeleeBonus * 20);
		$Value = mt_rand($Value / 2,$Value);

		if ($ItemData[Defined] == "Y") {
			$MinDam = $ItemData[Defined_MinDam];
			$MaxDam = $ItemData[Defined_MaxDam];
			$Value = $ItemData[Defined_Value];
			$MeleeBonus = $ItemData[Defined_MeleeBonus];
			$AttackBonus = $ItemData[Defined_AttackBonus];
			$DamageMod = $ItemData[Defined_DamageMod];
		}

		
		$sth = mysql_query("insert into items (ObjectID,ItemID,ItemStack,DamageMod,AttackBonus,MeleeBonus,MinDam,MaxDam,Value,DecayTime,X,Y,MapID,OwnerID,Equiped,PackID,DamageType,SpawnID) values (0,$ItemID,$Stack,$DamageMod,$AttackBonus,$MeleeBonus,$MinDam,$MaxDam,$Value,DATE_ADD(NOW(),INTERVAL 10 MINUTE),$X,$Y,$MapID,$CoreID,'No',0,'$HitType',$SpawnID)");
		print mysql_error();
		$sth = mysql_query("select LAST_INSERT_ID()");
		print mysql_error();
		list($Item) = mysql_fetch_row($sth);

		if ($Magic > 0) {
			$RndNum = mt_rand(0,100);
			if ($RndNum > 95) {
				$sth = mysql_query("select * from spells where Family=12 and SkillReq <= $Magic order by rand() limit 1");
				$SpellData = mysql_fetch_array($sth);
				$AddValue = mt_rand($SpellData[SkillReq],$SpellData[SkillReq] * 5);
				$sth = mysql_query("update items set AttunementReq = $SpellData[SkillReq],Value=Value+$AddValue where ObjectID=$Item");
				print mysql_error();
				$sth = mysql_query("insert into itemspells (ObjectID,SpellID) values ($Item,$SpellData[SpellID])");
				print mysql_error();
			}
		}
	
	} else {
		if ($ItemData[ItemType] == "Potion" || $ItemData[ItemType] == "Usable") {

			$sth = mysql_query("select ObjectID from items where OwnerID=$CoreID and ItemID=$ItemData[ItemID] and ItemStack < $ItemData[MaxStack]");
			print mysql_error();
			if (mysql_num_rows($sth) > 0) {
				list($ObjID) = mysql_fetch_row($sth);
				$sth = mysql_query("update items set ItemStack=ItemStack+$Stack where ObjectID=$ObjID");
			} else {
				$sth = mysql_query("insert into items values (0,$ItemID,$Stack,0,0,0,0,0,0,0,0,1,1,1,1,1,0,'',0,$ItemData[Defined_Value],DATE_ADD(NOW(),INTERVAL 10 MINUTE),$X,$Y,$MapID,$CoreID,'No',0,'',0,'',0,NULL,$SpawnID,0,0,255)");
			}
		} else {		
			$sth = mysql_query("insert into items values (0,$ItemID,$Stack,0,0,0,0,0,0,0,0,1,1,1,1,1,0,'',0,".intval($ItemData[Defined_Value]).",DATE_ADD(NOW(),INTERVAL 10 MINUTE),$X,$Y,$MapID,$CoreID,'No',0,'',0,'',0,NULL,$SpawnID,0,0,255)");
			print mysql_error();
		}
	}
	return 1;
}

function GenMod() {
	mt_srand(make_seed());
	$ModID = mt_rand(1,100);
	if ($ModID <= 5) { return .5; }		# Poor

	if ($ModID > 5 && $ModID <= 80) { return .75; }	# Below Average

	if ($ModID > 80 && $ModID <= 85) { return 1; }		# Average
	if ($ModID > 85 && $ModID <= 97) { return 1.25; }	# Above Average
	if ($ModID > 97) { return 1.50; }			# Excelent
}

?>