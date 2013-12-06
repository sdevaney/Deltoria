<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
global $db,$PlayerData;

// Show item and display all available info about item
function DispItem($ObjectID) {
	global $PlayerData;
	$sth = mysql_query("select I.*,IB.Name, IB.Defined_LevelReq as Level, TD.Image,IB.Stackable,IB.SkillID,S.Name as SkillName,IB.WearSlot,IB.Use_Effect,IB.ItemType,IB.Description, IB.Subscriber as SubItem, IB.Salvage_Price from items as I left join items_base as IB on IB.ItemID=I.ItemID left join tiledata as TD on TD.TileID=IB.TileID left join skills as S on S.SkillID=IB.SkillID where I.ObjectID=$ObjectID");
	print mysql_error();
	$ItemData = mysql_fetch_array($sth);

	if ($ItemData[Equiped] == "Y") {
		$sth2 = mysql_query("select S.*,I.Adjustment from itemspells as I left join spells as S on I.SpellID=S.SpellID left join items as IT on IT.ObjectID=I.ObjectID where I.ObjectID=$ItemData[ObjectID]");
		print mysql_error();
		while ($SpellData = mysql_fetch_array($sth2)) {
//			print $SpellData[ModCode];
			eval($SpellData[ModCode]);
		}
	}
	$ObjectID = $ItemData[ObjectID];
	print "<B>".$ItemData[Name]."</B> ";
	if ($ItemData[ItemStack] > 1) {
		print "(<b>$ItemData[ItemStack]</b>) ";
	}
	print "<BR><B>Level:</B> ".$ItemData[Level]." Required";
	print "<BR><B>Sub only:</B> ".$ItemData[SubItem];
	print "<BR><B>Value:</B> ".number_format($ItemData[Value])." coins<BR>";
	print "<B>Salvage Value:</B> ".number_format($ItemData[Salvage_Price])." coins<BR>";
	
	if ($ItemData[ItemType] == "Weapon") {
		print $ItemData[MinDam]."-".$ItemData[MaxDam]." $ItemData[DamageType] damage<BR>";
	} elseif ($ItemData[ItemType] == "Armor") {
		print "<B>Armor Level:</B> $ItemData[AL]<br>";
	}

	if ($ItemData[AttackBonus] > 0 && $ItemData[MeleeBonus] == 0) {
		print "+$ItemData[AttackBonus] attack<br>";
	} elseif ($ItemData[AttackBonus] == 0 && $ItemData[MeleeBonus] > 0) {
		print "+$ItemData[MeleeBonus] defence<br>";
	} elseif ($ItemData[AttackBonus] > 0 && $ItemData[MeleeBonus] > 0) {
		print "+$ItemData[AttackBonus] attack +$ItemData[MeleeBonus] defence<br>";
	}

	if ($ItemData[AttunementReq] > 0 || $ItemData[Use_SkillType] != "") {
		print "<B>Requirements:</B><br>";
		if ($ItemData[AttunementReq] > 0) {
			print "Magic Basic Level<BR>";
		}
		if ($ItemData[Use_SkillType] != "") {
			print "$ItemData[Use_SkillType] skill<BR>";
		}
	}

	$sth2 = mysql_query("select S.Name,I.Adjustment, I.SpellID from itemspells as I left join spells as S on I.SpellID=S.SpellID where I.ObjectID=$ItemData[ObjectID]");
	print mysql_error();
	if (mysql_num_rows($sth2) > 0) {
		$dispflag = 0;
		while ($spelldata = mysql_fetch_array($sth2)) {
			if ($spelldata[SpellID] != 0 && $dispflag == 0) {
				print "<B>Spells:</B><BR>";
				$dispflag = 1;
			}
			if ($spelldata[SpellID] != 0) {
				print "$spelldata[Name] ($spelldata[Adjustment])<BR>";
			}
		}
	}

	if ($ItemData[ItemType] == "Armor") {
		print "<B>Covers:</B>$ItemData[WearSlot]<BR>";
	}
	if ($ItemData[SkillID] > 0) {
		Help("Skills","To use this item effectivly you must be 
skilled in the skill displayed. You may train skills from the skills 
page.");
		print " <B>Skill:</B> $ItemData[SkillName]</BR>";
	}
}


?>
