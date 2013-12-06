<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Show players current skills, skills they can learn, and how much it costs to learn the skill
global $db, $CoreUserData;;

if ($UnTrain != "" && $Accept == "Y" && $PlayerData->SkillCredits > 0) {
	if ($PlayerData->Skills[$UnTrain]->ResetSkill() == 1) {
		print "<table border=1 class=Box1 Width=340>";
		print "<tr><td class=Header>Skill Reset</td></tr>";
		print "<tr><td>";
		print "You have successfully reset that skill.";
		print "</td></tr>";
		print "</table><p>";
	} else {
		print "<table border=1 class=Box1 Width=340>";
		print "<tr><td class=Header>Skill Reset</td></tr>";
		print "<tr><td>";
		print "An error occured while resetting that skill.";
		print "</td></tr>";
		print "</table><p>";
	}
} elseif ($UnTrain != "" && $Accept != "Y" && $PlayerData->SkillCredits > 0) {
	print "<table border=1 class=Box1 Width=340>";
	print "<tr><td class=Header>Skill Reset</td></tr>";
	print "<tr><td>";
	print "Are you sure you wish to reset your ".$Skills->Skill[$UnTrain]->Name." skill? It costs one skill credit to reset a skill however you get all the XP you've spent in that skill back.<P>";
	print "<A HREF=$SCRIPT_NAME?Accept=Y&UnTrain=$UnTrain><IMG BORDER=0 SRC=./images/buttons/yes.jpg></A>";
	print "</td></tr>";
	print "</table><p>";
}

	if ($Train != "") {
		$Skills->TrainSkill($Train);
	}


	if ($Raise != "") {
		$PlayerData->Skills[$Raise]->RaiseSkill();

		print "<table border=1 class=Box1 Width=340>";
		print "<tr><td class=Header>Congratulations on your new Skill Level</td></tr>";
		print "<tr><td>You've succeeded in raising your skill level to ".($PlayerData->Skills[$Raise]->Level)."!<BR>You have ".number_format($PlayerData->UnassignedXP)." unassigned XP remaining!</td></tr>";
		print "</table><p>";
	}

// Number of Skill Credits Player has
CharacterInfo("Stats");

// Trained Skills
print "<table border=1 class=Box1 Width=340>";
print "<tr><td class=Header colspan=4>Trained Skills</td></tr>";
print "<tr><td class=Menu colspan=4>Skill Name</td></tr>";
$TrainedList = "0";
foreach ($PlayerData->Skills as $key => $val) {
	print "<tr><td colspan=4>".$Skills->Skill[$key]->Name."</td></tr>";
}

// Untrained Skills
print "<tr><td colspan=4 class=Header>Untrained Skills</td></tr>";
print "<Tr><td class=Menu>Name</td><td class=Menu>Skill Credits</td><td colspan=2 class=Menu>&nbsp;</td></tr>";

foreach ($Skills->Skill as $key => $val) {
	if ($PlayerData->Skills[$key]->SkillID != $key && ($PlayerData->Skills[$Skills->Skill[$key]->ParentID]->SkillID > 0 || $Skills->Skill[$key]->ParentID == 0)) {
		print "<tr><td>".$Skills->Skill[$key]->Name."</td><td>".$Skills->Skill[$key]->Cost."</td><td colspan=2 align=center><A HREF=$SCRIPT_NAME?RD=".rand(1,999999)."&Train=$key>Train this Skill</A></TD></TR>";
	}
}
print "</table><p>";

?>