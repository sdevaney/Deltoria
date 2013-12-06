<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
//	$Skills = new Skills();
//	$MyPlayer = new Player(14120);
//
//
//	$Melee = $MyPlayer->GetSkillByName("Melee Something");
//	print $Melee->Level;
//	print "\n";
//
//	print $MyPlayer->GetSkillLevelByName("Melee Something");
//	print "\n";


// **********************************************************************
// Raw Skill Class
// **********************************************************************
class SkillsData {
	var $SkillID;
	var $Name;
	var $ParentID;
	var $Cost;
	function Skillsdata($SkillID) {
		$sth = mysql_query("select * from skills where SkillID=$SkillID");
		while ($SData = mysql_fetch_array($sth)) {
			$this->Name = $SData[Name];
			$this->SkillID = $SData[SkillID];
			$this->ParentID = $SData[ParentID];
			$this->Cost = $SData[Cost];
		}
	}
}

class ClanData {
	var $ClanID;
	var $Name;
	var $Letters;
	var $Founder;
	var $Founder_Name;
	var $Password;
	var $CreationDate;
	var $Description;
	var $HomeX;
	var $HomeY;
	var $HomeMapID;
	var $ClanBank;

	function ClanData($ClanID) {
		$sth = mysql_query("select C.*,U.Username from clans as C left join user as U on C.Founder = U.CoreID where C.ClanID=$ClanID");
		if (mysql_num_rows($sth) == 0) { return 0; }
		$CData = mysql_fetch_array($sth);
		$this->ClanID = $CData[ClanID];
		$this->Name = $CData[Name];
		$this->Letters = $CData[Letters];
		$this->Founder = $CData[Founder];
		$this->CreationDate = $CData[CreationDate];
		$this->Description = $CData[Description];
		$this->HomeX = $CData[HomeX];
		$this->HomeY = $CData[HomeY];
		$this->HomeMapID = $CData[HomeMapID];
		$this->ClanBank = $CData[ClanBank];
	}
}


class Player_Skills {
	var $Level;
	var $XP_Spent;
	var $XP_Cost;
	var $CoreID;
	var $SkillID;
	var $BonusLevel;
	function Player_Skills($CoreID,$SkillID,$Level) {
		$this->SkillID = $SkillID;
		$this->CoreID = $CoreID;

		$sth = mysql_query("select US.*,S.Name from user_skills as US left join skills as S on S.SkillID=US.SkillID where US.CoreID=$CoreID and US.SkillID=$SkillID");
		$SkillData = mysql_fetch_array($sth);

		$this->Level = $SkillData[Level];

		$sth = mysql_query("select sum(XP) from skill_curve where Inc <= $SkillData[Level]");
		list($XP_Spent) = mysql_fetch_row($sth);
		$this->XP_Spent = $XP_Spent;

		$sth = mysql_query("select XP from skill_curve where Inc = ".($SkillData[Level] + 1));
		list($XP_Cost) = mysql_fetch_row($sth);
		$this->XP_Cost = $XP_Cost;

		$this->BonusLevel = intval($Level * .2);
	}
	function ResetSkill() {
		global $PlayerData;

		if ($PlayerData->CoreID != $this->CoreID) {
			print "<B>Error:</B> ResetSkill may only be called on the current players skills<br>";
			return 0;
		} else {
			$XP_Return = $this->XP_Spent;

			$this->Level = 0;
			$this->XP_Spent = 0;

			$sth = mysql_query("select XP from skill_curve where Inc = 1");
			list($XP_Cost) = mysql_fetch_row($sth);
			$this->XP_Cost = $XP_Cost;

			$sth = mysql_query("update user_skills set Level=0 where SkillID=$this->SkillID and CoreID=$this->CoreID");
			$sth = mysql_query("update user set SkillCredits=SkillCredits-1,UnassignedXP=UnassignedXP+$XP_Return where CoreID=$this->CoreID and SkillCredits > 0");

			$PlayerData->AdjustValue("SkillCredits",($PlayerData->SkillCredits - 1));
			$PlayerData->AdjustValue("UnassignedXP",($PlayerData->UnassignedXP + $XP_Return));
			return 1;
		}
	}
	function RaiseSkill() {
		global $PlayerData,$Skills;

		if ($PlayerData->CoreID != $this->CoreID) {
			print "<B>Error:</B> RaiseSkill may only be called on the current players skills<br>";
			return 0;
		} else {
			if ($this->XP_Cost > $PlayerData->UnassignedXP) {
				print "<B>Error:</B> RaiseSkill is unable to raise a skill due to lack of unassigned XP<BR>";
				return 0;
			} else {
				$this->Level = $this->Level + 1;
				$this->XP_Spent = $this->XP_Spent + $this->XP_Cost;


				$PlayerData->AdjustValue("UnassignedXP",($PlayerData->UnassignedXP - $this->XP_Cost));

				$sth = mysql_query("select XP from skill_curve where Inc = $this->Level");
				list($XP_Cost) = mysql_fetch_row($sth);
				$this->XP_Cost = $XP_Cost;

				$sth = mysql_query("update user_skills set Level=$this->Level where CoreID=$this->CoreID and SkillID=$this->SkillID");
				print mysql_error();

				return 1;
			}
		}
	}
}


class Inventory_Item {
	var $Name;
	var $ObjectID;
	var $ItemID;
	var $Equiped;
	var $WearSlot;
	var $Image;
	var $SkillID;
	var $SkillType;
	var $Use_Effect;
	var $Description;
	var $Enchantable;
	var $Droppable;
	var $Battle_Use;
	var $Stackable;
	var $ItemType;
	var $Defined_LevelReq;
	var $Level;
	var $Value;
	var $ItemStack;
	var $AL;
	var $DamageMod;
	var $AttackBonus;
	var $MeleeBonus;
	var $MinDam;
	var $MaxDam;
	var $Inscription;
	var $Inscriber_CoreID;
	var $Banked;

	function Inventory_Item($CoreID,$ObjectID) {
		$sth = mysql_query("select TD.Image,IB.Defined_LevelReq,S.Name as SkillType,I.*,IB.Name,IB.Stackable,IB.ItemType,IB.WearSlot from items as I left join items_base as IB on IB.ItemID=I.ItemID left join skills as S on S.SkillID=IB.SkillID left join tiledata as TD on TD.TileID=IB.TileID where I.ObjectID=$ObjectID and I.CoreID=$CoreID");
		if (mysql_error() != "") {
		//	print "Error. Please post this in the bug forums:<HR>";
			print mysql_error();
		//	print "<BR><BR>";
		//	print ("select TD.Image,IB.Defined_LevelReq,S.Name as SkillType,I.*,IB.Name,IB.Stackable,IB.ItemType,IB.WearSlot from items as I left join items_base as IB on IB.ItemID=I.ItemID left join skills as S on S.SkillID=IB.SkillID left join tiledata as TD on TD.TileID=IB.TileID where I.ObjectID=$ObjectID and I.CoreID=$CoreID<HR>");
		}
		$ItemData = mysql_fetch_array($sth);

		if ($ItemData[Equiped] == 'Y') {
			$sth = mysql_query("select S.*,ISS.Adjustment from itemspells as ISS left join spells as S on ISS.SpellID=S.SpellID where ISS.ObjectID=$ItemData[ObjectID]");
			print mysql_error();
			while ($SpellData = mysql_fetch_array($sth)) {
				eval($SpellData[ModCode]);
//				print "Executing $SpellData[ModCode]<BR>";
			}
		}
		else {
			$PlayerData->HealthMax = ((($PlayerData->Level+1) * 15) + 25);
			$sth = mysql_query("update user set HealthMax=$PlayerData->HealthMax where CoreID=$PlayerData->CoreID");
		}

		$this->Name = $ItemData[Name];
		$this->ObjectID = $ItemData[ObjectID];
		$this->ItemID = $ItemData[ItemID];
		$this->Equiped = $ItemData[Equiped];
		$this->WearSlot = $ItemData[WearSlot];
		$this->Image = $ItemData[Image];
		$this->SkillID = $ItemData[SkillID];

		$this->SkillType = $ItemData[SkillType];

		$this->Use_Effect = $ItemData[Use_Effect];
		$this->Description = $ItemData[Description];
		$this->Enchantable = $ItemData[Enchantable];
		$this->Droppable = $ItemData[Droppable];
		$this->Battle_Use = $ItemData[Battle_Use];
		$this->Stackable = $ItemData[Stackable];
		$this->ItemType = $ItemData[ItemType];
		$this->Level = $ItemData[Defined_LevelReq];
		$this->Defined_LevelReq = $ItemData[Defined_LevelReq];
		$this->Value = $ItemData[Value];

		$this->ItemStack = $ItemData[ItemStack];
		$this->AL = $ItemData[AL];

		$this->DamageMod = $ItemData[DamageMod];
		$this->AttackBonus = $ItemData[AttackBonus];
		$this->MeleeBonus = $ItemData[MeleeBonus];
		$this->MinDam = $ItemData[MinDam];
		$this->MaxDam = $ItemData[MaxDam];

		$this->Inscription = $ItemData[Inscription];
		$this->Inscriber_CoreID = $ItemData[Inscriber_CoreID];
		$this->Banked = $ItemData[Banked];


	}
}


class Skills {
	function Skills() {
		$sth = mysql_query("select SkillID from skills");
		while (list($SkillID) = mysql_fetch_row($sth)) {
			$this->Skill[$SkillID] = new SkillsData($SkillID);
		}
	}
	function GetByName($Name) {
		foreach ($this->Skill as $key => $val) {
			if ($this->Skill[$key]->Name == $Name) { return $this->Skill[$key]; }
		}
		return 0;
	}
	function GetIDByName($Name) {
		foreach ($this->Skill as $key => $val) {
			if ($this->Skill[$key]->Name == $Name) { return $key; }
		}
		return 0;
	}

	function TrainSkill($SkillID) {
		global $PlayerData,$Skills;
		if ($PlayerData->Skills[$SkillID]->SkillID == $SkillID) {
			print "<B>Error:</B> TrainSkill called but you are already trained in that skill.<BR>";
		} elseif ($PlayerData->SkillCredits < $Skills->Skill[$SkillID]->Cost) {
			print "<B>Error:</B> TrainSkill called but you don't have enough available skill credits.<BR>";
		} else {
			if ($PlayerData->Skills[$Skills->Skill[$SkillID]->ParentID]->SkillID < 1 && $Skills->Skill[$SkillID]->ParentID > 0) {
				print "<B>Error:</B> TrainSkill can't train that skill because its parent isn't trained.<BR>";
			} else {
				$PlayerData->AdjustValue("SkillCredits",($PlayerData->SkillCredits - $Skills->Skill[$SkillID]->Cost));
				$sth = mysql_query("insert into user_skills (CoreID,SkillID) values ($PlayerData->CoreID,$SkillID)");
				print mysql_error();
				$PlayerData->Skills[$SkillID] = new Player_Skills($PlayerData->CoreID,$SkillID,$PlayerData->Level);
				print "Training.";
			}
		}
	}
}



class Player
{
	var $CoreID;
	var $Username;
	var $ClanID;
	var $ClanName;
	var $ClanFounder;
	var $Coins;
	var $Level;
	var $XP;
	var $UnassignedXP;
	var $X;
	var $Y;
	var $MapID;
	var $Death_X;
	var $Death_Y;
	var $Death_MapID;
	var $Portal_X;
	var $Portal_Y;
	var $Portal_MapID;
	var $Slay;

	var $Advertisment;

	var $LastTell;

	var $Admin;
	var $Manager;

	var $DispLog;

	var $Tie_X;
	var $Tie_Y;
	var $Tie_MapID;

	var $Deaths;
	var $HealthCur;
	var $HealthMax;
	var $FellowID;
	var $ManaCur;
	var $ManaMax;
	var $SkillCredits;
	var $UserPic;
	var $BankedCoins;
	var $Confirm;
	var $Stealth;
	var $Attract;
	var $Age;
	var $WID;
	var $Turns;
	var $Actions;
	var $ChatRows;
	var $ChatType;
	var $ForumType;
	var $Subscriber;
	var $ClanFlags;
	var $AttackBonus;
	var $MeleeBonus;
	var $InvenSpace;
	var $InvIncreaseDate;
	var $Cloak;
	var $Strength;
	var $Intelligence;
	var $Dexterity;
	var $Agility;
	var $Wisdom;
	var $Constitution;
	var $Luck;

	function Player($CoreID) {
		$sth = mysql_query("select * from user where CoreID=$CoreID");

		if (mysql_num_rows($sth) > 0) {
			$UData = mysql_fetch_array($sth);

			$shiz = mysql_query("select * from user_base where UserID=$UData[UserID]");
			$CData = mysql_fetch_array($shiz);


			$this->LastTell = $UData[LastTell];

			$this->CoreID = $UData[CoreID];
			$this->Admin = $CData[Administrator];
			$this->Manager = $CData[Manager];
			$this->Username = $UData[Username];
			$this->ClanID = $UData[ClanID];
			$this->Coins = $UData[Coins];
			$this->Level = $UData[Level];
			$this->Age = $UData[Age];
			$this->Turns = $UData[Turns];
			$this->Actions = $UData[Actions];
			$this->Advertisment = $UData['Advertisment'];

			$this->XP = $UData[XP];
			$this->Slay = $UData[Slay];
			$this->UnassignedXP = $UData[UnassignedXP];
			$this->X = $UData[X];
			$this->Y = $UData[Y];
			$this->MapID = $UData[MapID];
			$this->Death_X = $UData[Death_X];
			$this->Death_Y = $UData[Death_Y];
			$this->Death_MapID = $UData[Death_MapID];
			
			$this->DispLog = $UData[DispLog];

			$this->Portal_X = $UData[Portal_X];
			$this->Portal_Y = $UData[Portal_Y];
			$this->Portal_MapID = $UData[Portal_MapID];

			$this->Tie_X = $UData[Tie_X];
			$this->Tie_Y = $UData[Tie_Y];
			$this->Tie_MapID = $UData[Tie_MapID];

			$this->Deaths = $UData[Deaths];
			$this->HealthCur = $UData[HealthCur];
			$this->HealthMax = $UData[HealthMax];
			$this->FellowID = $UData[FellowID];
			$this->ManaCur = $UData[ManaCur];
			$this->ManaMax = $UData[ManaMax];
			$this->SkillCredits = $UData[SkillCredits];
			$this->UserPic = $UData[UserPic];
			$this->BankedCoins = $UData[BankedCoins];
			$this->Confirm = $UData[Confirm];
			$this->WID = $UData[WID];
			$this->ClanFlags = $UData[ClanFlags];

			$this->ChatRows = $UData[ChatRows];
			$this->ForumType = $UData[ForumType];
			$this->ChatType = $UData[ChatType];
			$this->InvenSpace = $UData[InvenSize];
			$this->InvIncreaseDate = $UData[InvenIncDate];
			$this->Cloak = $UData[cloak];
			$this->Stealth = $UData[Stealth];
			$this->Attract = $UData[Attract];
			$this->Strength = $UData[Strength];
			$this->Intelligence = $UData[Intelligence];
			$this->Dexterity = $UData[Dexterity];
			$this->Agility = $UData[Agility];
			$this->Wisdom = $UData[Wisdom];
			$this->Constitution = $UData[Constitution];
			$this->Luck = $UData[Luck];

			if ($this->ClanID == 0) { $this->ChatType = "public"; }

			$this->ClanData = new ClanData($this->ClanID);

			$sth = mysql_query("select AttackBonus,MeleeBonus from items where CoreID=$CoreID and Equiped='Y' and Banked='N' and (AttackBonus > 0 or MeleeBonus > 0)");
			print mysql_error();
			while (list($AttackBonus,$MeleeBonus) = mysql_fetch_row($sth)) {
				$this->AttackBonus = $this->AttackBonus + $AttackBonus;
				$this->MeleeBonus = $this->MeleeBonus + $MeleeBonus;
			}

			$sth = mysql_query("select ObjectID from items where CoreID=$CoreID and Banked='N'");
			while (list($ObjID) = mysql_fetch_row($sth)) {
				$this->Inventory[$ObjID] = new Inventory_Item($CoreID,$ObjID);
			}

			$sth = mysql_query("select SkillID from user_skills where CoreID=$CoreID");
			while (list($SkillID) = mysql_fetch_row($sth)) {
				$this->Skills[$SkillID] = new Player_Skills($CoreID,$SkillID,$this->Level);
			}

			$sth = mysql_query("select * from user_base where UserID=$UData[UserID]");
			$CoreData = mysql_fetch_array($sth);
			if ($CoreData[Subscriber] == "Yes") $CoreData[Subscriber] = "Y";
			if ($CoreData[Subscriber] != "Y") $CoreData[Subscriber] = "N";
			$this->Subscriber = $CoreData[Subscriber];

			$sth = mysql_query("select * from items as I where I.CoreID=$UData[CoreID] and I.Equiped='Y'");
			while ($ItemData = mysql_fetch_array($sth)) {
				$sth_get = mysql_query("select S.*,ISS.Adjustment from itemspells as ISS left join spells as S on ISS.SpellID=S.SpellID where ISS.ObjectID=".$ItemData[ObjectID]);
				print mysql_error();
				while ($SpellData = mysql_fetch_array($sth_get)) {
					print eval($SpellData[ModCode]);
				//	print "NEW $SpellData[ModCode]<BR>";
				}
			}

			if ($PlayerData->HealthCur > $PlayerData->HealthMax) { $PlayerData->HealthMax = $PlayerData->HealthCur; } 

		} else {
//			print "Error: Unable to find a user with the ID of: $CoreID<BR>";
		}
	}

	function WearSlotAvailable($WearSlot) {
		$Worn[Ring] = 0;
		$Worn[Bracelet] = 0;
		foreach ($this->Inventory as $key => $val) {
			if ($this->Inventory[$key]->Equiped == "Y") {
				if (stristr($this->Inventory[$key]->WearSlot,"Wielded")) { $Worn['Wielded'] = "Y"; }
				if (stristr($this->Inventory[$key]->WearSlot,"Head")) { $Worn['Head'] = "Y"; }
				if (stristr($this->Inventory[$key]->WearSlot,"Torso")) { $Worn['Torso'] = "Y"; }
				if (stristr($this->Inventory[$key]->WearSlot,"Legs")) { $Worn['Legs'] = "Y"; }
				if (stristr($this->Inventory[$key]->WearSlot,"Hands")) { $Worn['Hands'] = "Y"; }
				if (stristr($this->Inventory[$key]->WearSlot,"Feet")) { $Worn['Feet'] = "Y"; }
				if (stristr($this->Inventory[$key]->WearSlot,"Arms")) { $Worn['Arms'] = "Y"; }
				if (stristr($this->Inventory[$key]->WearSlot,"Necklace")) { $Worn['Necklace'] = "Y"; }
				if (stristr($this->Inventory[$key]->WearSlot,"Ring")) { $Worn['Ring']++; }
				if (stristr($this->Inventory[$key]->WearSlot,"Bracelet")) { $Worn['Bracelet']++; }
			}
		}
                $Splitter = split(" ",$WearSlot);
                while (list($key,$val) = each ($Splitter)) {
                        $val = ereg_replace(" ","",$val);

			if ($val == "Ring" || $val == "Bracelet") {
				if ($Worn[$val] >= 2) { return 0; }
			} else {
				if ($Worn[$val] == "Y") { return 0; }
			}
                }
		return 1;
 	}

	function GetWeapon() {
		foreach ($this->Inventory as $key => $val) {
			if ($this->Inventory[$key]->Equiped == "Y" && $this->Inventory[$key]->ItemType == "Weapon") {
				return $key;
			}
		}
		return 0;
	}

	function Inv_ObjIDByName($Name) {
		foreach ($this->Inventory as $key => $val) {
			if ($this->Inventory[$key]->Name == $Name) {
				return $key;
			}
		}
		return 0;
	}

	function GiveObj($Obj,$CoreID,$Count) {
	}

	function GetObj($Obj) {
	}

	function DropObj($Obj,$Count) {
	}

	function GiveItem($ItemID,$Count) {
	        $numb = LootGen(0,$this->CoreID,$this->X,$this->Y,$this->MapID,$ItemID,1,$Count,0);
	        while ($numb == 0) {
		        $numb = LootGen(0,$this->CoreID,$this->X,$this->Y,$this->MapID,$ItemID,1,$Count,0);
	        }
	}

	function GetSkillByName($Name) {
		global $Skills;
		return $this->Skills[$Skills->GetIDByName($Name)];
	}

	function GetSkillByID($SkillID) {
		global $Skills;
		return $this->Skills[$SkillID];
	}

	function GetAL() {
		foreach ($this->Inventory as $key => $val) {
			if ($this->Inventory[$key]->Equiped == "Y" && $this->Inventory[$key]->ItemType == "Armor") {
				$AL = $AL + ($this->Inventory[$key]->AL * (substr_count($this->Inventory[$key]->WearSlot," ")+1));
			}
		}
		return intval($AL / 6);
	}



	function GetSkillLevelByID($SkillID) {
		$Skill = $this->GetSkillByID($SkillID);
		if ($Skill->SkillID > 0) { 
			return $this->Level + 2;
		} else {
			return 0;
		}
	}

	function GetSkillLevelByName($Name) {
		$Skill = $this->GetSkillByName($Name);
		if ($Skill->SkillID > 0) { 
			return $this->Level + 2;
		} else {
			return 0;
		}
	}

	function AdjustHealth($Amount) {
		global $Skills, $PlayerData;

		$this->HealthCur = $this->HealthCur + $Amount;
		if ($this->HealthCur > $this->HealthMax) { $this->HealthCur = $this->HealthMax; }
		if ($this->HealthCur < 0) { $this->HealthCur = 0; }

		// Death
		if ($this->HealthCur == 0) { 
			$CoinLost = intval($PlayerData->Coins * .1);
			$death = mysql_query("update user set PsnRemain = 0 where CoreID=$PlayerData->CoreID");
			$death = mysql_query("update user set PsnDmg = 0 where CoreID=$PlayerData->CoreID");
			// Notify anyone in a fellowship.
			if ($PlayerData->FellowID > 0) {
				FellowNote($PlayerData->FellowID,"$PlayerData->Username has died at $PlayerData->X,$PlayerData->Y:$PlayerData->MapID");
			}

			$sth = mysql_query("insert into overlay_corpse (X,Y,MapID,CoreID) values ($this->X,$this->Y,$this->MapID,$this->CoreID)");
			print mysql_error();


			// Revive the player at their deathstone.
			$PlayerData->X = $PlayerData->Death_X;
			$PlayerData->Y = $PlayerData->Death_Y;
			$PlayerData->MapID = $PlayerData->Death_MapID;
			$sth = mysql_query("update user set Coins=Coins-$CoinLost,X=$PlayerData->Death_X,Y=$PlayerData->Death_Y,MapID=$PlayerData->Death_MapID,HealthCur=".$PlayerData->HealthMax." where CoreID=$PlayerData->CoreID");
                        print mysql_error();
		} else {
			$sth = mysql_query("update user set HealthCur=$this->HealthCur where CoreID=$this->CoreID");
                        print mysql_error();
		}
	}

	function AdjustActions($Amount) {
		$this->Actions = $this->Actions + $Amount;
		$sth = mysql_query("update user set Actions=$this->Actions where CoreID=$this->CoreID");
		print mysql_error();
	}

	function AdjustMove($Amount) {
		$this->Turns = $this->Turns + $Amount;
		$sth = mysql_query("update user set Turns=$this->Turns where CoreID=$this->CoreID");
		print mysql_error();
	}
	function AdjustValue($Key,$Value) {
		$this->$Key = $Value;
		$sth = mysql_query("update user set $Key='$Value' where CoreID=$this->CoreID");
		print mysql_error();
	}


}

?>