<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Character page info
global $db,$CoreUserData;
include ("./system/top.php");

// Block users
if ($_GET['blockuser'] != "") {
	$sth = mysql_query("select coreid from user where Username='".$_GET['blockuser']."' limit 1");
	if (mysql_num_rows($sth) == 1) {
		list($cid) = mysql_fetch_row($sth);
		$sth = mysql_query("insert into user_block (coreid,blockid) values ('".$PlayerData->CoreID."','$cid')");
		print mysql_error();
	} else {
		print "Can't find that user!<BR>";
	}
} elseif ($_GET['unblockuser'] != "") {
	$sth = mysql_query("delete from user_block where coreid=".$PlayerData->CoreID." and blockid=".$_GET['unblockuser']);
	print mysql_error();
}
// If in battle cant go to this page
if (Check_Battle($PlayerData) == 1) {
	print "<TABLE BORDER=0 class=box1>";
	print "<tr><td class=Header colspan=2>Your being attacked!</td></tr>";
	$sth = mysql_query("select Image,MB.Name,Level from monster as M left join monster_base as MB on MB.MonsterID=M.MonsterID left join tiledata as TD on TD.TileID=MB.TileID where X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID and HealthCur > 0");
	print mysql_error();
	while (list($M_Image,$M_Name,$M_Level) = mysql_fetch_row($sth)) {
		print "<TR><TD WIDTH=50>";
		print "<IMG WIDTH=30 HEIGHT=30 SRC=images/tiles/$M_Image>";
		print "</TD><TD VALIGN=TOP>$M_Name<BR><B>Level:</B> ".intval($M_Level)."</TD></TR>";
	}
	print "<tr><td colspan=2 class=Menu><A HREF=battle.php?RD=".rand(1,1000000).">You're being attacked! Click here to go to the battle page.</a></td></tr>";
	print "</table>";
	print "<P>";
	include("./system/bottom.php");
	exit;
}

// All the player options can be chosen here some are admin only
print "<table border=0 class=pageContainer>";
print "<tr><td class=pageCell valign=top>";

if ($Confirm == "Y" || $Confirm == "N") {
	$PlayerData->AdjustValue("Confirm",$Confirm);
}

if ($Stealth == "Y" || $Stealth == "N") {
	$PlayerData->AdjustValue("Stealth",$Stealth);
}

if ($Attract == "Y" || $Attract == "N") {
        $PlayerData->AdjustValue("Attract",$Attract);
}

if ($Slay == "Y" || $Slay == "N") {
	$PlayerData->AdjustValue("Slay",$Slay);
}

if ($Emotes == "Y" || $Emotes == "N") {
	$sth = mysql_query("update user_base set Emotes='$Emotes' where UserID=$PlayerData->CoreID");
	print mysql_error();
	$CoreUserData[Emotes] = $Emotes;
}

if ($ChatRows != "") {
	$sth = mysql_query("update user set ChatRows='".intval($ChatRows)."' where CoreID=$PlayerData->CoreID");
	print mysql_error();
	$PlayerData->ChatRows = $ChatRows;
}


if ($PlayerData->Subscriber == "Y") {


}

// Recalls player to Inn Keepr that they gave their stone of recall to
if ($InnRecall == "Y") {
	$sth = mysql_query("update user set X=$PlayerData->Death_X,Y=$PlayerData->Death_Y,MapID=$PlayerData->Death_MapID where CoreID=$PlayerData->CoreID");
	print mysql_error();
	$PlayerData->X = $PlayerData->Death_X;
	$PlayerData->Y = $PlayerData->Death_Y;
	$PlayerData->MapID = $PlayerData->Death_MapID;

	print "<table border=1 class=Box1 Width=340>";
	print "<tr><td class=Header>Inn Recall</td></tr>";
	print "<tr><td>";
	print "You've recalled to your Inn.";
	print "</td></tr>";
	print "</table><p>";
}

// Recalls player to their tied portal
if ($TieRecall == "Y" && $PlayerData->GetSkillLevelByName("Portal Tie") > 0) {
	$sth = mysql_query("update user set X=$PlayerData->Tie_X,Y=$PlayerData->Tie_Y,MapID=$PlayerData->Tie_MapID where CoreID=$PlayerData->CoreID");
	print mysql_error();
	$PlayerData->X = $PlayerData->Tie_X;
	$PlayerData->Y = $PlayerData->Tie_Y;
	$PlayerData->MapID = $PlayerData->Tie_MapID;

	print "<table border=1 class=Box1 Width=340>";
	print "<tr><td class=Header>Tie Recall</td></tr>";
	print "<tr><td>";
	print "You've recalled to your last tied portal.";
	print "</td></tr>";
	print "</table><p>";
}
// Recalls players to their last used portals
if ($PortalRecall == "Y") {
	$sth = mysql_query("update user set X=$PlayerData->Portal_X,Y=$PlayerData->Portal_Y,MapID=$PlayerData->Portal_MapID where CoreID=$PlayerData->CoreID");
	print mysql_error();
	$PlayerData->X = $PlayerData->Portal_X;
	$PlayerData->Y = $PlayerData->Portal_Y;
	$PlayerData->MapID = $PlayerData->Portal_MapID;

	print "<table border=1 class=Box1 Width=340>";
	print "<tr><td class=Header>Portal Recall</td></tr>";
	print "<tr><td>";
	print "You've recalled to your Portal.";
	print "</td></tr>";
	print "</table><p>";
}

// Allows users to upload their own avatar
if ($userfile != "") {
	$pictype = strtoupper(substr($userfile_name,strlen($userfile_name)-3,3));
	if ($pictype == "GIF") {
		$sth = mysql_query("update user set UserPic='$PlayerData->CoreID.gif' where CoreID=$PlayerData->CoreID");

		copy($userfile, "./images/chars/".$PlayerData->CoreID.".gif");

		$PlayerData->UserPic = $PlayerData->CoreID.".gif";

		print "<table border=1 class=Box1 Width=340>";
		print "<tr><td class=Header>Custom User Picture</td></tr>";
		print "<tr><td>";
		print "You've set your picture successfully.";
		print "</td></tr>";
		print "</table><p>";

	} else {
		print "<table border=1 class=Box1 Width=340>";
		print "<tr><td class=Header>Custom User Picture</td></tr>";
		print "<tr><td>";
		print "Invalid Filetype. Only GIF files are supported for user images.<P>";
		print "</td></tr>";
		print "</table><p>";
	}
}

// Untrain skills not yet in game
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
// Train a skill
	if ($Train != "") {
		$Skills->TrainSkill($Train);
	}

// Skill levels not in yet
	if ($Raise != "") {
		$PlayerData->Skills[$Raise]->RaiseSkill();

		print "<table border=1 class=Box1 Width=340>";
		print "<tr><td class=Header>Congratulations on your new Skill Level</td></tr>";
		print "<tr><td>You've succeeded in raising your skill level to ".($PlayerData->Skills[$Raise]->Level)."!<BR>You have ".number_format($PlayerData->UnassignedXP)." unassigned XP remaining!</td></tr>";
		print "</table><p>";
	}


	CharacterInfo("Stats");

/*	// Trained Skills
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
	print "</table><p>";*/

	print "<table border=1 class=Box1 width=340>";
	print "<Tr><Td colspan=2 class=Header>Inn Recall</td></tr>";
	print "<tr><td colspan=2>";
	print "Do you wish to recall to the location which you've last used an Inn Key?<BR>";
	print "</TD></TR><TR><TD CLASS=FOOTER>";
	print "<A HREF=$SCRIPT_NAME?InnRecall=Y><IMG BORDER=0 SRC=./images/buttons/yes.jpg></A>";
	print "</TD></TR></TABLE><P>";


	if ($PlayerData->GetSkillLevelByName("Portal Tie") > 0) {
		print "<table border=1 class=Box1 width=340>";
		print "<Tr><Td colspan=2 class=Header>Tie Recall</td></tr>";
		print "<tr><td colspan=2>";
		print "Do you wish to recall to the location which you've last tied?<BR>";
		print "</TD></TR><TR><TD CLASS=FOOTER>";
		print "<A HREF=$SCRIPT_NAME?TieRecall=Y><IMG BORDER=0 SRC=./images/buttons/yes.jpg></A>";
		print "</TD></TR></TABLE><P>";
	}

	print "<table border=1 class=Box1 width=340>";
	print "<Tr><Td colspan=2 class=Header>Portal Recall</td></tr>";
	print "<tr><td colspan=2>";
	print "Recall to the last portal used";
	print "</TD></TR><TR><TD CLASS=FOOTER>";
	print "<A HREF=$SCRIPT_NAME?PortalRecall=Y><IMG BORDER=0 SRC=./images/buttons/yes.jpg></A>";
	print "</TD></TR></TABLE><P>";

	
	print "<table border=1 class=Box1 width=340>";
	print "<Tr><Td colspan=2 class=Header>Item Confirmation</td></tr>";
	print "<tr><td colspan=2>";
	print "Do you wish to have confirmation enabled? When confirmation is enabled you will be asked ";
	print "if you are sure that you want to salvage an item or drop it. If confirmation is off the ";
	print "game will bypass those questions.";
	print "<P><CENTER>Your current setting is: $PlayerData->Confirm</CENTER>";
	print "</TD></TR><TR><TD CLASS=FOOTER>";
	print "<A HREF=$SCRIPT_NAME?Confirm=N><IMG BORDER=0 SRC=./images/buttons/no.jpg></A>";
	print "<A HREF=$SCRIPT_NAME?Confirm=Y><IMG BORDER=0 SRC=./images/buttons/yes.jpg></A>";
	print "</TD></TR></TABLE><P>";

	$sth2 = mysql_query("select Admin,StealthDate,AttractDate from user where CoreID = $PlayerData->CoreID");
	$UData2 = mysql_fetch_array($sth2);
	if($UData2[Admin] == "Y" || $UData2[StealthDate] > date('Y-m-d')) {
	        print "<table border=1 class=Box1 width=340>";
		if($UData2[Admin] == "Y") {
		        print "<Tr><Td colspan=2 class=Header>Admin Stealth</td></tr>";
		        print "<tr><td colspan=2>";
	        	print "Do you wish to enable stealth? It will reduce danger in areas to 0.";
		        print "The reduction in danger will not be visible on the danger bar in the navigation page ";
		        print "but does work.";
	        	print "<P><CENTER>Your current setting is: $PlayerData->Stealth</CENTER>";
		        print "</TD></TR><TR><TD CLASS=FOOTER>";
		        print "<A HREF=$SCRIPT_NAME?Stealth=N><IMG BORDER=0 SRC=./images/buttons/no.jpg></A>";
	        	print "<A HREF=$SCRIPT_NAME?Stealth=Y><IMG BORDER=0 SRC=./images/buttons/yes.jpg></A>";
		        print "</TD></TR></TABLE><P>";
		} else {
                        print "<Tr><Td colspan=2 class=Header>Stealth</td></tr>";
                        print "<tr><td colspan=2>";
                        print "Do you wish to enable stealth? It will reduce danger in areas by 10.";
                        print "The reduction in danger will not be visible on the danger bar in the navigation page ";
                        print "but does work.";
                        print "<P><CENTER>Your current setting is: $PlayerData->Stealth</CENTER>";
                        print "</TD></TR><TR><TD CLASS=FOOTER>";
                        print "<A HREF=$SCRIPT_NAME?Stealth=N><IMG BORDER=0 SRC=./images/buttons/no.jpg></A>";
                        print "<A HREF=$SCRIPT_NAME?Stealth=Y><IMG BORDER=0 SRC=./images/buttons/yes.jpg></A>";
                        print "</TD></TR></TABLE><P>";
		}
	}

        if($UData2[Admin] == "Y" || $UData2[AttractDate] > date('Y-m-d')) {
                print "<table border=1 class=Box1 width=340>";
                if($UData2[Admin] == "Y") {
                        print "<Tr><Td colspan=2 class=Header>Admin Attraction</td></tr>";
                        print "<tr><td colspan=2>";
                        print "Do you wish to enable attraction? It will increase danger in areas to 100.";
                        print "The increase in danger will not be visible on the danger bar in the navigation page ";
                        print "but does work.";
                        print "<P><CENTER>Your current setting is: $PlayerData->Attract</CENTER>";
                        print "</TD></TR><TR><TD CLASS=FOOTER>";
                        print "<A HREF=$SCRIPT_NAME?Attract=N><IMG BORDER=0 SRC=./images/buttons/no.jpg></A>";
                        print "<A HREF=$SCRIPT_NAME?Attract=Y><IMG BORDER=0 SRC=./images/buttons/yes.jpg></A>";
                        print "</TD></TR></TABLE><P>";
                } else {
                        print "<Tr><Td colspan=2 class=Header>Attraction</td></tr>";
                        print "<tr><td colspan=2>";
                        print "Do you wish to enable attraction? It will increase danger in areas by 10.";
                        print "The increase in danger will not be visible on the danger bar in the navigation page ";
                        print "but does work.";
                        print "<P><CENTER>Your current setting is: $PlayerData->Attract</CENTER>";
                        print "</TD></TR><TR><TD CLASS=FOOTER>";
                        print "<A HREF=$SCRIPT_NAME?Attract=N><IMG BORDER=0 SRC=./images/buttons/no.jpg></A>";
                        print "<A HREF=$SCRIPT_NAME?Attract=Y><IMG BORDER=0 SRC=./images/buttons/yes.jpg></A>";
                        print "</TD></TR></TABLE><P>";
                }
        }

/*
	print "<table border=1 class=Box1 width=340>";
	print "<Tr><Td colspan=2 class=Header>Slain Messages</td></tr>";
	print "<tr><td colspan=2>";
	print "Do you wish to see the slain messages when players die?<p>";
	print "<P><CENTER>Your current setting is: $PlayerData->Slay</CENTER>";
	print "</TD></TR><TR><TD CLASS=FOOTER>";
	print "<A HREF=$SCRIPT_NAME?Slay=N><IMG BORDER=0 SRC=./images/buttons/no.jpg></A>";
	print "<A HREF=$SCRIPT_NAME?Slay=Y><IMG BORDER=0 SRC=./images/buttons/yes.jpg></A>";
	print "</TD></TR></TABLE><P>";
*/



	print "<table border=1 class=Box1 width=340>";
	print "<Tr><Td colspan=2 class=Header>Chat Rows</td></tr>";
	print "<tr><td colspan=2>";
	print "How many rows of chat would you like to see? (0 disables chat)";
	print "<P><CENTER>Your current setting is: ".$PlayerData->ChatRows."</CENTER>";
	print "</TD></TR><TR><FORM ACTION=character.php><TD CLASS=FOOTER>";
	print "<INPUT NAME=ChatRows TYPE=TEXT SIZE=2 MAXLENGTH=2 VALUE=\"".intval($PlayerData->ChatRows)."\"><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Set>";
	print "</TD></FORM></TR></TABLE><P>";

	print "<table border=1 class=Box1 width=340>";
	print "<Tr><Td colspan=2 class=Header>Custom User Icon</td></tr>";
	print "<tr><td colspan=2>";
	print "Please remember that custom user icons must be only 30x30 and need to be a transparent GIF file. Icons must also be Rated PG and must be suitable for children. Repeated offenders of these rules will lose their privilage of playing Deltoria.<p>";
	print "Your current icon is <IMG SRC=./images/chars/$PlayerData->UserPic><BR>";
	print "</td></tr>";
	print "<FORM ENCTYPE=\"multipart/form-data\" ACTION=\"$SCRIPT_NAME\" METHOD=POST>";
	print "<INPUT TYPE=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"2000000\">";
	print "<tr><td class=Menu>Filename</TD><TD><INPUT NAME=\"userfile\" TYPE=\"file\"></TD></TR>";
	print "<TR><TD COLSPAN=2 class=Footer ALIGN=CENTER><INPUT TYPE=\"submit\" VALUE=\"Send File\"></TD></TR>";
	print "</FORM>";
	print "</table><p>";


	print "</td><td class=pageCell valign=top align=left>";

	include ("./system/general.php");
	print "</td></tr></table>";

	print "<table width=340 border=0 class=Box1>";
	print "<Tr><td colspan=2 class=Header>Quest Timers</td></tr>";
	print "<tr><td class=menu>Quest Name</Td><Td class=menu>Time Remaining</td></tr>";
	$sth = mysql_query("select q.Name, ((UNIX_TIMESTAMP(uq.QuestTimer)-UNIX_TIMESTAMP())) as Minutes from user_quest as uq left join questdata as q on q.QuestID=uq.Quest where q.Name is not null and uq.CoreID=".$PlayerData->CoreID);
	while ($QData = mysql_fetch_array($sth)) {
		print "<TR><TD>$QData[Name]</TD>";


		$IdleTime = $QData[Minutes];
		$IdleMod = "sec";
		if ($IdleTime > 60) {
			$IdleTime = intval($IdleTime / 60);
			$IdleMod = "minute(s)";
		}
		if ($IdleTime > 60 && $IdleMod == "minute(s)") {
			$IdleTime = intval($IdleTime / 60);
			$IdleMod = "hour(s)";
		}
		if ($IdleTime > 24 && $IdleMod == "hour(s)") {
			$IdleTime = intval($IdleTime / 24); 
			$IdleMod = "day(s)";
		}
		$IdleTime = intval($IdleTime);
		print "<TD>$IdleTime $IdleMod</TD></TR>";
	}
	print "</table><p>";

/*	print "<table border=1 class=Box1 width=340>";
	print "<Tr><Td colspan=2 class=Header>Emotes</td></tr>";
	print "<tr><td colspan=2>";
	print "Do you wish to see emotes?";
	print "<P><CENTER>Your current setting is: $CoreUserData[Emotes]</CENTER>";
	print "</TD></TR><TR><TD CLASS=FOOTER>";
	print "<A HREF=$SCRIPT_NAME?Emotes=N><IMG BORDER=0 SRC=./images/buttons/no.jpg></A>";
	print "<A HREF=$SCRIPT_NAME?Emotes=Y><IMG BORDER=0 SRC=./images/buttons/yes.jpg></A>";
	print "</TD></TR></TABLE><P>";*/

	if ($PlayerData->Subscriber == "Y") {
	print "<table border=1 class=Box1 width=340>";
	print "<Tr><Td colspan=2 class=Header>Advertisments</td></tr>";
	print "<tr><td colspan=2>";
	print "Subscribers get the option of having advertisments enabled or disabled. If a Subscriber leaves advertisments on you will recieve an additional 100 MP and 100 AP per day<P>";
	print "<P><CENTER>Your current setting is: ".$PlayerData->Advertisment."</CENTER>";
	print "</TD></TR><TR><TD CLASS=FOOTER>";
	print "<A HREF=$SCRIPT_NAME?Advertisment=N><IMG BORDER=0 SRC=./images/buttons/no.jpg></A>";
	print "<A HREF=$SCRIPT_NAME?Advertisment=Y><IMG BORDER=0 SRC=./images/buttons/yes.jpg></A>";
	print "</TD></TR></TABLE><P>";
}

/*	print "<table border=0 class=Box1 width=340>";
	print "<Tr><Td class=header colspan=2>Kill Counters</td></tr>";
	print "<Tr><Td class=menu>Monster</td><td class=Menu>Kills</td></tr>";
	$sth = mysql_query("select uk.Counter,mb.Name from user_kills as uk left join monster_base as mb on mb.MonsterID=uk.MonsterID where uk.CoreID=".$PlayerData->CoreID);
	while ($MData = mysql_fetch_array($sth)) {
		print "<Tr><Td>$MData[Counter]</td><Td>$MData[Name]</td></tr>";
	}
	print "</table><p>";*/


	print "<table border=0 class=Box1 width=340>";
	print "<Tr><Td class=header colspan=2>Block List</td></tr>";
	print "<Tr><Td class=menu>Action</td><td class=Menu>Username</td></tr>";
	$sth = mysql_query("select ub.*,u.Username from user_block as ub left join user as u on u.coreid=ub.blockid where ub.CoreID=".$PlayerData->CoreID);
	print mysql_error();
	while ($BData = mysql_fetch_array($sth)) {
		print "<Tr><Td><a href=character.php?unblockuser=".$BData[BlockID].">Unblock</A></td><Td>$BData[Username]</td></tr>";
	}
	print "<form action=character.php>";
	print "<tr><td><input type=submit name=submit value=Block style='width: 100%'></td><td><input type=text name=blockuser style='width: 100%'></td></tr>";
	print "</table><p>";


if (($Advertisment == "Y" || $Advertisment == "N") && $PlayerData->Subscriber == "Y") {
	$PlayerData->AdjustValue("Advertisment",$Advertisment);

	print "<table border=1 class=Box1 Width=340>";
	print "<tr><td class=Header>Advertisment Settings</td></tr>";
	print "<tr><td>";
	print "You've changed your advertisment setting to ".$PlayerData->Advertisment.".";
	print "</td></tr>";
	print "</table><p>";

}
// These do nothing yet
	print "<table border=1 class=Box1 width=340>";
	print "<tr><td>Strength</td><td>$PlayerData->Strength</td></tr>";
	print "<tr><td>Intelligence</td><td>$PlayerData->Intelligence</td></tr>";
	print "<tr><td>Dexterity</td><td>$PlayerData->Dexterity</td></tr>";
	print "<tr><td>Agility</td><td>$PlayerData->Agility</td</tr>";
	print "<tr><td>Wisdom</td><td>$PlayerData->Wisdom</td></tr>";
	print "<tr><td>Constitution</td><td>$PlayerData->Constitution</td></tr>";
	print "<tr><td>Luck</td><td>$PlayerData->Luck</td></tr>";
	print "<tr><td colspan=2 class=Header>The stats are not active yet";
	print "</TD></TR></TABLE><P>";

	include ("./system/bottom.php");


?>