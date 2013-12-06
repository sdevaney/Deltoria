<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
//If maintenance put YES will disable logins
$MaintDown = "No";

include_once ("./system/dbconnect.php");
include ("./system/lootgen.php");
include ("./system/dispitem.php");
include ("./system/class.php");
include ("./system/smilies.php");

global $CoreUserData,$CoreData,$db,$REMOTE_ADDR,$PlayerData,$Skills;
// Gives us our session
if ($_SESSION[userid] != "") {
	$sql = "select *,UserID as CoreID,Email as Username from user_base where UserID=".intval($_SESSION[userid])." and LastAccessed > Date_Sub(NOW(),INTERVAL 2 HOUR)";
	$sth = mysql_query($sql);
	print mysql_error();
	$CoreUserData = mysql_fetch_array($sth);

	if ($CoreUserData[Subscriber] == "Yes") $CoreUserData[Subscriber] = "Y";
	if ($CoreUserData[Subscriber] != "Y") $CoreUserData[Subscriber] = "N";

	$CoreUserData[LayoutID] = 1;
	$sth = mysql_query("select LastAccessed,Date_Sub(NOW(),INTERVAL 2 HOUR) from user_base where UserID=$_SESSION[userid]");
	list($lastaccessed,$datesub) = mysql_fetch_row($sth);

	if ($CoreUserData[Locked] != "") {
		print "<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=704>";
		print "<TR><TD VALIGN=TOP><IMG SRC=images\HTTPGames_Left.gif>";
		print "</TD><TD VALIGN=TOP><IMG SRC=images\HTTPGames_Right.gif></TD></TR>";
		print "</TABLE>";
		print "<P>";
		print "<table border=1 bgcolor=dfdfdf cellspacing=0 cellpadding=3 bordercolor=black bordercolordark=white width=704>";
		print "<TR><td bgcolor=f4f4f4>ERROR: <B>You're account has been banned</B></TD></TR>";
		print "<TR><TD>";
		print "Your account has been banned with the following notice:<P><B>$CoreUserData[Locked]</B><P>If you wish to dispute this claim, or explain why you believe you where banned. Please contact support@techby2guys.com<P>";
		print "</TD></TR></TABLE>";
		exit;
	}

	if ($MaintDown == "Yes" && $CoreUserData[Access] < 10) {
		print "<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=704>";
		print "<TR><TD VALIGN=TOP><IMG SRC=images\banner_left.gif>";
		print "</TD><TD VALIGN=TOP><IMG SRC=images\banner_right.gif></TD></TR>";
		print "</TABLE>";
		print "<P>";
		print "<table border=1 bgcolor=dfdfdf cellspacing=0 cellpadding=3 bordercolor=black bordercolordark=white width=704>";
		print "<TR><td bgcolor=f4f4f4>ERROR: <B>Deltoria is currently down!</B></TD></TR>";
		print "<TR><TD>";
		print "Deltoria is currently down for routine maintenance.<BR>";
		print "Please check back soon!";
		print "</TD></TR></TABLE>";
		exit;
	}
// Sets last login time
	if (!stristr($SCRIPT_NAME,"charpage.php") && !stristr($SCRIPT_NAME,"newchat.php")) {
		$sql = "update user set LastAccessed = NOW() where CoreID=".intval($CoreUserData[DeltoriaID]);
		$sth = mysql_query($sql);
		print mysql_error();
	}

	list( $ip1, $ip2, $ip3, $ip4 ) = split( '\.', $REMOTE_ADDR );
	$sth = mysql_query("update user_base set LastAccessed = NOW(),IP_Number_Full='$ip1.$ip2.$ip3.$ip4',IP_Number_Part='$ip1.$ip2.$ip3' where UserID=$CoreUserData[CoreID]");
	print mysql_error();

	$Skills = new Skills;
	$PlayerData = new Player($CoreUserData[DeltoriaID]);

	ereg("\/([a-z.A-Z0-9]+)$",$SCRIPT_NAME,$regs);
}

if (!ereg("register.php",$PHP_SELF)) { 
	if ($PlayerData->Username == "" && !stristr($SCRIPT_NAME,"charpage.php")) {
		print "Registered Users Only";
		exit;
	}
}

function TableNotice($Title,$Message) {
	print "<table border=0 class=box1>";
	print "<tr><td class=header>$Title</td></tr>";
	print "<tr><td>$Message</td></tr>";
	print "<tr><td class=footer>&lt;message&gt;</td></tr>";
	print "</table><p>";
}

function SetLength ($InStr,$Length) {
	$NewStr = $InStr;
	while (strlen($NewStr) < $Length) {
		$NewStr = $NewStr." ";
	}
	return $NewStr;
}

function NiceHost($host) {
        if (ereg('^([0-9]{1,3}\.){3}[0-9]{1,3}$', $host)) {
                return(ereg_replace('\.[0-9]{1,3}$', '.*', $host));
        } else {
                return(ereg_replace('^.{' . strpos($host, '.') . '}', '*', $host));
        }
}

function ChangeLevel($Level) {
	global $PlayerData;
	$sth = mysql_query("select XP from level_curve where Level=$Level");
	list($XPGrant) = mysql_fetch_row($sth);
	$XPGrant++;
	$sth = mysql_query("update user set XP=$XPGrant,Level=$Level where CoreID=$PlayerData->CoreID");
	$PlayerData->Level = $Level;
	$PlayerData->XP = $XPGrant;
}

// Level up
function SetLevel($CoreID) {
	global $PlayerData;
	$sth = mysql_query("select Username,Level,XP from user where CoreID=$CoreID");
	print mysql_error();
	list($CurUsername,$CurLevel,$XP) = mysql_fetch_row($sth);
	$sth = mysql_query("select min(Level-1) from level_curve where XP > $XP");
	print mysql_error();
	list($Level) = mysql_fetch_row($sth);

	if ($Level != $CurLevel && $Level != "") {
		$sth = mysql_query("update user set Level=$Level where CoreID=$CoreID");
		print mysql_error();
		if ($PlayerData->CoreID == $CoreID) { print "<table border=1 class=Box1 width=340><tr><td class=Header>Level Increase</td></tr><tr><td>"; }
		for ($LevLook = $CurLevel; $LevLook < $Level; $LevLook++) {
			$sth = mysql_query("update user set HealthMax=".((($LevLook+1) * 15) + 25)." where CoreID=$CoreID");
			print mysql_error();
			$sth2 = mysql_query("select Admin from user where CoreID = $PlayerData->CoreID");
			$UData2 = mysql_fetch_array($sth2);
			if (($LevLook+1) == 10 && $UData2[Admin] == "N") { AddNews("Welcome $CurUsername to the ranks of Deltorian citizenship! Level 10 reached!"); }
			if ($PlayerData->CoreID == $CoreID) { print "Level up! You are now ".($LevLook+1).". "; }
			if (fmod($LevLook+1,25) == 0 && $UData2[Admin] == "N") { AddNews("$CurUsername has reached level ".($LevLook+1)."! Congrats!"); }

			if ($LevLook+1 <= 10 || $LevLook+1 == 12 || $LevLook+1 == 14 || $LevLook+1 == 17 || $LevLook+1 == 20 || (fmod($LevLook+1,5) == 0 || $LevLook+1 > 20)) {
				if ($PlayerData->CoreID == $CoreID) { print "You have gained a skill credit!"; }
				$sth = mysql_query("update user set SkillCredits=SkillCredits+1 where CoreID=$CoreID");	
				print mysql_error();
			}

			if ($PlayerData->CoreID == $CoreID) { print "<BR>"; }			
		}
		if ($PlayerData->CoreID == $CoreID) { print "</TD></TR></TABLE><P>"; }
		return $Level;
	} else {
		return 0;
	}
}
	

function make_seed() {
	list($usec, $sec) = explode(' ', microtime());
	return (float) $sec + ((float) $usec * 100000);
}
// Allows use of portals
function Use_Portal($PortalID,$CoreID) {
	global $PlayerData;

	$sth = mysql_query("select TargetX,TargetY,TargetMapID from portals where PortalID=$PortalID");
	print mysql_error();
	if (mysql_num_rows($sth) == 0) { return 0; }
	list ($X,$Y,$MapID) = mysql_fetch_row($sth);
	$sth = mysql_query("update user set X=$X,Y=$Y,MapID=$MapID where CoreID=$CoreID");
	print mysql_error();
	if ($PlayerData[CoreID] == $CoreID) {
		$PlayerData[X] = $X;
		$PlayerData[Y] = $Y;
		$PlayerData[MapID] = $MapID;
	}
	return 1;
}

// Shows if you have a quest and how much time before you can do it again
function Check_Quest($Quest,$CoreID) {
	if ($Quest == "") { return 1; }
	$sth = mysql_query("select * from user_quest as uq left join questdata as q on q.QuestID=uq.Quest where uq.CoreID=$CoreID and uq.Quest='$Quest'");
	if (mysql_num_rows($sth) == 0) {
		return 0;
	} else {
		return 1;
	}
}
// Make sure no bad stuff in inventory
function Check_Inventory($Items,$CoreID) {
	if ($Items == "") { return 0; }
	$sth = mysql_query("select * from items join items_base on items.ItemID=items_base.ItemID where items.CoreID=$CoreID and 
items_base.Name='$Items'");
	if (mysql_num_rows($sth) == 0) {
		return 0;
	} else {
		return 1;
	}
}
// Sets your quest  timer
function Set_Quest($Quest,$CoreID,$Timer) {
	if ($Quest == "") { return 0; }
	if ($Timer == 0) { return 0; }

	$sth = mysql_query("select * from user_quest where CoreID=$CoreID and Quest='$Quest'");
	if (mysql_num_rows($sth) == 0) {
		if ($Timer > 0) {
			$sth = mysql_query("insert into user_quest (Quest,CoreID,QuestTimer) values ('$Quest',$CoreID,DATE_ADD(NOW(),INTERVAL $Timer DAY))");
			print mysql_error();
		} else {
			$sth = mysql_query("insert into user_quest (Quest,CoreID) values ('$Quest',$CoreID)");
			print mysql_error();
		}
	} else {
		if ($Timer > 0) {
			$sth = mysql_query("update user_quest set QuestTimer=DATE_ADD(NOW(),INTERVAL $Timer DAY) where Quest='$Quest' and CoreID=$CoreID");
			print mysql_error();
		}
	}
}
// Give xp and coins. Subscribers get a 10% bonus
function GiveXP($CoreID,$Amount) {
	$sth = mysql_query("select ClanID,Subscriber from user where CoreID=$CoreID");
	list ($ClanID,$Subscriber) = mysql_fetch_row($sth);
	if ($ClanID > 0) {
		$BankAmount = floor($Amount * .03);
		if ($BankAmount > 0) {
			$sth = mysql_query("update clans set ClanBank=ClanBank + $BankAmount where ClanID=$ClanID");
		}
	}

	// if ($Subscriber == "Y") $Amount = $Amount * 1.1;

	$sth = mysql_query("update user set XP=XP+$Amount,UnassignedXP=UnassignedXP+$Amount where CoreID=$CoreID");
	print mysql_error();

}
// Checks to see if your in battle
function Check_Battle($PlayerData) {
	$sth = mysql_query("select M.* from monster as M left join monster_base as B on B.MonsterID=M.MonsterID where M.HealthCur > 0 and M.X=$PlayerData->X and M.Y=$PlayerData->Y and M.MapID=$PlayerData->MapID and B.Hostile='Y'");
	if (mysql_num_rows($sth) > 0) {
		$sth = mysql_query("select * from battle_info where X=$PlayerData->X and Y=$PlayerData->Y and MapID=$PlayerData->MapID");
		if (mysql_num_rows($sth) > 0) {
			$BattleData = mysql_fetch_array($sth);
			$sth = mysql_query("select * from battle_user where BattleID=$BattleData[BattleID] and CoreID=$PlayerData->CoreID and Flee='Yes'");
			if (mysql_num_rows($sth) > 0) {
				return 0;
			}
		}
		return 1;
	} else {
		return 0;
	}
}
// Shows errors
function DebugPrint($Message) {
	global $CoreUserData,$DebugMode;
	if ($CoreUserData[Access] > 0 && $DebugMode == "Yes") {
		print "<B><FONT COLOR=WHITE>Debug:</FONT></B> $Message<BR>";
	}
}
// Makes sure you have skill
function SkillCheck ($Skill, $SkillReq) {
	if ($SkillReq == 0) { $SkillReq = 1; }
#        print "Checking $Skill against $SkillReq\n";
        $SkillDiff = ($Skill / $SkillReq) * 100 - 100;
        # print "Difference: $SkillDiff%\n";
        mt_srand(make_seed());
        $Perc = rand(-100,100);
        if ($SkillDiff > $Perc) { return 1; } else { return 0; }
}
// Adds to battle log
function AddLog($Message) {
	global $PlayerData,$CoreUserData;
}
// Shows health and XP bars
function GenBar_Lite($Cur,$Max,$Width,$BarType) {
	if ($Max < 1) { $Max = 1; }
	if ($Min < 1) { $Min = 1; }
	print "<table border=1 cellpadding=0 cellspacing=0 width=$Width>";
	print "<TR><TD>";
	print "<img name=$BarType src=./images/bar/bar_$BarType.jpg height=5 width=";
	$perc = intval(($Cur / $Max) * 100);
	if ($perc > 100) { $perc = 100; }
	$perc = $Width * ($perc / 100);
	print "$perc";
	print "></td></tr>";
	print "</table>";
}

function GenBar_Width($Cur,$Max,$Width,$BarType) {
	if ($Max < 1) { $Max = 1; }
	if ($Min < 1) { $Min = 1; }
	$perc = intval(($Cur / $Max) * 100);
	if ($perc > 100) { $perc = 100; }
	$perc = $Width * ($perc / 100);
	return "$perc";
}

// Displays all char info
function CharacterInfo($DispType) {
	global $PlayerData,$Skills;

	print "<table border=1 class=Box1 Width=330>";
	if ($DispType == "All" || $DispType == "Stats") {
		print "<tr><td class=Header colspan=2>Personal Stats</td></tr>";
		print "<tr><td class=Menu>Name</td><td><B>".$PlayerData->Username."</td></tr>";
		print "<tr><td class=Menu>Level</td><td>".$PlayerData->Level."</td></tr>";

		$Age_Years = intval($PlayerData->Age / 365);
		$Age_Days = $PlayerData->Age - ($Age_Years * 365);

		print "<Tr><td class=Menu>Age</td><td>$Age_Years years and $Age_Days days</td></tr>";


		print "<tr><td class=Menu>Health</td><td>";
		print "<table border=0 width=100% class=pageContainer>";
		print "<tr><td class=pageCell>";
		print "$PlayerData->HealthCur / $PlayerData->HealthMax";
		print "</td><td class=pageCell align=right>";		
		GenBar_Lite($PlayerData->HealthCur,$PlayerData->HealthMax,100,"health");
		print "</td></tr></table>";
		print "</td></tr>";
		print "<tr><td class=Menu>Gold Coins</td><td>".number_format($PlayerData->Coins)."</td></tr>";
		print "<tr><td class=Menu>Banked Coins</td><td>".number_format($PlayerData->BankedCoins)."</td></tr>";
		print "<tr><td class=Menu>Skill Credits</td><td>$PlayerData->SkillCredits</td></tr>";
		print "<tr><td class=Menu>Total XP</td><td>".number_format($PlayerData->XP)."</td></tr>";
		print "<tr><td class=Menu>XP For Level</td><td>";
		$sth = mysql_query("select XP from level_curve where Level=".($PlayerData->Level));
		list($XPBottom) = mysql_fetch_row($sth);
	
		$sth = mysql_query("select XP from level_curve where Level=".($PlayerData->Level+1));
		list($XPTop) = mysql_fetch_row($sth);

		$LevelXP = $XPTop - $XPBottom;
	
		$CurXP = $XPBottom-$PlayerData->XP;
		$NeededXP = $XPTop - $PlayerData->XP;

		$CurXP = $PlayerData->XP - $XPBottom;
		$XPTop = $XPTop - $XPBottom;


		print "<table border=0 width=100% class=pageContainer>";
		print "<tr><td class=pageCell>";
		print number_format($NeededXP)." needed ";
		print "</td><td class=pageCell align=right>";		
		GenBar_Lite($CurXP,$XPTop,100,"health");
		print "</td></tr></table>";

		print "<tr><td class=Menu>Burden</td><td>";
	
		if ($PlayerData->Subscriber == 'Y') {
			$sth = mysql_query("select count(ItemID) from items where CoreID=$PlayerData->CoreID and Banked='N' and ItemID NOT IN (Select ItemID from items_base where ItemType='Tool')");
		} else {
			$sth = mysql_query("select count(ItemID) from items where CoreID=$PlayerData->CoreID and Banked='N'");
		}
		list($ItemCount) = mysql_fetch_row($sth);

		print "<table border=0 width=100% class=pageContainer>";
		print "<tr><td class=pageCell>";
		print $ItemCount." of $PlayerData->InvenSpace items ";
		print "</td><td class=pageCell align=right>";		
		GenBar_Lite($ItemCount,$PlayerData->InvenSpace,100,"health");
		print "</td></tr></table>";
	// Shows if you are wearing items and what parts
		print "</td></tr>";
		print "<tr><td class=menu>Armor Rating</td><td>".$PlayerData->GetAL()."</td></tr>";
		print "<tr><td class=Menu>Deaths</td><td>$PlayerData->Deaths</td></tr>";
	}
	if ($DispType == "All" || $DispType == "Player") {
		$Slot[Head] = "N";
		$Slot[Torso] = "N";
		$Slot[Legs] = "N";
		$Slot[Arms] = "N";
		$Slot[Hands] = "N";
		$Slot[Feet] = "N";
	
		$sth = mysql_query("select WearSlot from items as i left join items_base as ib on ib.ItemID=i.ItemID where i.CoreID=$PlayerData->CoreID and i.Equiped='Y'");
		while (list($SlotData) = mysql_fetch_row($sth)) {
			if (preg_match("/Head/i",$SlotData)) { $Slot[Head] = "Y"; }
			if (preg_match("/Torso/i",$SlotData)) { $Slot[Torso] = "Y"; }
			if (preg_match("/Legs/i",$SlotData)) { $Slot[Legs] = "Y"; }
			if (preg_match("/Arms/i",$SlotData)) { $Slot[Arms] = "Y"; }
			if (preg_match("/Hands/i",$SlotData)) { $Slot[Hands] = "Y"; }
			if (preg_match("/Feet/i",$SlotData)) { $Slot[Feet] = "Y"; }
			if (preg_match("/Wielded/i",$SlotData)) { $Slot[Wielded] = "Y"; }
			if (preg_match("/Necklace/i",$SlotData)) { $Slot[Necklace] = "Y"; }
			if (preg_match("/Bracelet/i",$SlotData)) { $Slot[Bracelet] = "Y"; }
			if (preg_match("/Ring/i",$SlotData)) { $Slot[Ring] = "Y"; }
		}

		print "<tr><td colspan=2>";
		print "<table border=0 class=pageContainer cellpadding=0 cellspacing=0>";
		print "<tr><td colspan=5 class=pageCell>";
		if ($Slot[Head] == "N") {
			print "<IMG SRC=./images/avitar/face.gif>";
		} else {
			print "<IMG SRC=./images/avitar/face_glow.gif>";
		}
		print "</td>";
		print "<td rowspan=4 width=226 class=pageCell align=right>";
		print "[ RING ]<BR>";
		print "[ BRACELET ]<BR>";
		print "[ NECKLACE ]<BR>";
		print "</td>";
		print "</tr>";

		print "<tr>";
		print "<td class=pageCell>";
		if ($Slot[Hands] == "N") {
			print "<IMG SRC=./images/avitar/left_hand.gif>";
		} else{
			print "<IMG SRC=./images/avitar/left_hand_glow.gif>";
		}
		print "</td><td class=pageCell>";
		if ($Slot[Arms] == "N") {
			print "<IMG SRC=./images/avitar/left_arm.gif>";
		} else{
			print "<IMG SRC=./images/avitar/left_arm_glow.gif>";
		}
		print "</td><td class=pageCell>";
		if ($Slot[Torso] == "N") {
			print "<IMG SRC=./images/avitar/torso.gif>";
		} else{
			print "<IMG SRC=./images/avitar/torso_glow.gif>";
		}
		print "</td><td class=pageCell>";
		if ($Slot[Arms] == "N") {
			print "<IMG SRC=./images/avitar/right_arm.gif>";
		} else{
			print "<IMG SRC=./images/avitar/right_arm_glow.gif>";
		}
		print "</td><td class=pageCell>";
		if ($Slot[Hands] == "N") {
			print "<IMG SRC=./images/avitar/right_hand.gif>";
		} else{
			print "<IMG SRC=./images/avitar/right_hand_glow.gif>";
		}
		print "</td>";
		print "</tr>";
	
		print "<tr><td colspan=5 class=pageCell>";
		if ($Slot[Legs] == "N") {
			print "<IMG SRC=./images/avitar/legs.gif>";
		} else{
			print "<IMG SRC=./images/avitar/legs_glow.gif>";
		}
		print "</td></tr>";	
	
		print "<tr><td colspan=5 class=pageCell>";
		if ($Slot[Feet] == "N") {
			print "<IMG SRC=./images/avitar/feet.gif>";
		} else{
			print "<IMG SRC=./images/avitar/feet_glow.gif>";
		}
		print "</td></tr>";	
		print "</table>";

		print "</td></tr>";
	}

	print "</table><p>";

}
// Menu bar displays
function DispMenu() {
	global $PlayerData,$Skills,$SCRIPT_NAME;
	if (stristr($SCRIPT_NAME,"charpage.php")) { return 0; }
	print "<DIV ALIGN=RIGHT><FONT COLOR=RED><B></B></FONT> <A HREF=album.php>Album</A></DIV>";
	print "<table cellspacing=0 cellpadding=0 border=0 width=560 class=pageContainer bgcolor=#E7BB4E>";
//	print "<tr  bgcolor=#E7BB4E>";
	print "<td rowspan=25% align=center class=pageCell background=./images/buttons/menu/menus/basic780x60bar.jpg>";
	print "<td rowspan=25% align=center class=pageCell background=.images/buttons/menu/http_back.jpg>";
		print "<img src=./images/chars/$PlayerData->UserPic>";
		print "<BR><B>$PlayerData->Username</B>";
	print "</td>";

	PrintMenuCell("character","character.php");
	PrintMenuCell("whoson","who.php");
	PrintMenuCell("clans","clans.php");
	PrintMenuCell("gameguide","http://deltoria.com/forums/index.php/board,35.0.html");
	PrintMenuCell("subscribe","subscribe.php");

	print "<td rowspan=25% class=pageCell>";
//	print "<img src=./images/buttons/menu/menus/squillandpen.gif>";
//	print "<img src=./images/buttons/menu/http_logo.jpg>";
	print "</td>";
	print "</tr><tr bgcolor=#E7BB4E>";

	PrintMenuCell("navigation","start.php");
	$sth = mysql_query("select MailID from mail where CoreID=$PlayerData->CoreID and Status='Unread'");
	if (mysql_num_rows($sth) > 0) {
		PrintMenuCell("newmail","mail.php");
	} else {
		PrintMenuCell("mail","mail.php");
	}
	PrintMenuCell("skills","skillpage.php");
	PrintMenuCell("monsterlist","monsterlist.php");
	PrintMenuCell("top50","top50.php");


	print "</tr><tr bgcolor=#E7BB4E>";
	PrintMenuCell("inventory","inventory.php");
	PrintMenuCell("forums","forums.php");
        PrintMenuCell("charpage","charpage.php");
	PrintMenuCell("logout","logout.php");

	print "<A TARGET=_top HREF=\"charpage.php\">";
//	print "<img border=0 src=./images/buttons/menu/char_selection.jpg>";
//	print "<img border=0 src=./images/buttons/menu/menus/character selection page off copy.gif>";
	print "</A></td>";

	print "<td rowspan=25% class=pageCell>";
	print "<A TARGET=_top HREF=\"charpage.php\">";
//	print "<img border=0 src=./images/buttons/menu/httpgames_home.jpg>";
//	print "<img border=0 src=./images/buttons/menu/menus/httphomeoff.jpg>";
	print "</A></td>";

	print "</tr>";

	print "</table>";

	if ($PlayerData->Advertisment == "Y") {
?>  
<?PHP
}
}
//Send message to whole clan
function FellowNote($FellowID,$Message) {
	if ($FellowID < 1) { return 0; }
	$sth = mysql_query("select CoreID from user where FellowID=$FellowID");
	while (list($InCoreID) = mysql_fetch_row($sth)) {
		$sth_post = mysql_query("insert into user_log (CoreID,Type,Message) values ($InCoreID,'Fellowship','$Message')");
	}
}

function SendNote($CoreID,$Type,$Message) {
	if ($CoreID < 1) { return 0; }
	$sth_post = mysql_query("insert into user_log (CoreID,Type,Message) values ($CoreID,'$Type','$Message')");
}


/*
+---------+------------------+------+-----+---------+----------------+
| Field   | Type             | Null | Key | Default | Extra          |
+---------+------------------+------+-----+---------+----------------+
| CoreID  | int(10) unsigned |      |     | 0       |                |
| TS      | timestamp(14)    | YES  |     | NULL    |                |
| Type    | varchar(25)      | YES  |     | NULL    |                |
| Message | text             | YES  |     | NULL    |                |
| LogID   | int(10) unsigned |      | PRI | NULL    | auto_increment |
+---------+------------------+------+-----+---------+----------------+
*/
// If in clan show clan page if not show list of clans
function ClanCheck($ClanID) {
	global $PlayerData;
	if ($PlayerData->ClanID == $ClanID) { return 1; }
	if ($PlayerData->ClanID == 0) { return 0; }

	$sth = mysql_query("select * from clan_alliance where (ClanA = $ClanID and ClanB = $PlayerData->Clan) or (ClanA = $PlayerData->Clan and ClanB=$ClanID)");
	print mysql_errror();
	if (mysql_num_rows($sth) == 0) { 
		return 0;
	} else {
		return 1;
	}
}


function PrintMenuCell($image,$target) {
	global $SCRIPT_NAME;

	if ($image == "charpage") {
		print "<td colspan=2 class=pageCell>";
	} else {
		print "<td class=pageCell>";
	}
	print "<A HREF=\"$target?RD=".rand(1,9393958)."\">";
	if (!stristr($SCRIPT_NAME,"$target")) {
		print "<img border=0 src=./images/buttons/menu/menus/".$image."off.gif>";
	} else {
		print "<img border=0 src=./images/buttons/menu/menus/".$image."on.gif>";
	}
	print "</A>";
	print "</td>";

/*	print "<td class=pageCell>";
	print "<A HREF=\"$target?RD=".rand(1,9393958)."\">";
	if (!stristr($SCRIPT_NAME,"$target")) {
		print "<img border=0 src=./images/buttons/menu/".$image."_up.jpg>";
	} else {
		print "<img border=0 src=./images/buttons/menu/".$image."_down.jpg>";
	}
	print "</A></TD>";*/

}
// Post NEWS
function AddNews($Message) {
	$sth = mysql_query("select * from news where Text='".str_replace("'","\'",$Message)."' and Date > DATE_SUB(NOW(),INTERVAL 5 HOUR)");
	print mysql_error();
	if (mysql_num_rows($sth) == 0) {
		$sth = mysql_query("insert into news (Text) values ('".str_replace("'","\'",$Message)."')");
		print mysql_error();
		$sth = mysql_query("insert into chatter (Message) values ('".str_replace("'","\'",$Message)."')");
		print mysql_error();
	}
}
// Public chat
function GlobalChat($Message) {
	$sth = mysql_query("insert into chatter (Message) values ('".str_replace("'","\'",$Message)."')");
	print mysql_error();
}

function FlagCheck ($FlagCheck,$Flags) {
	if (ereg($FlagCheck,$Flags)) {
		return 1;
	} else {
		return 0;
	}
}

function GetItemIDFromName($Name) {
	$sth = mysql_query("select ItemID from items_base where Name='".str_replace("'","\'",$Name)."'");
	if (mysql_num_rows($sth) == 0) { return 0; }
	list ($ItemID) = mysql_fetch_row($sth);
	return $ItemID;
}
?>