<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Character Page

    $header_image = "icon-guard.gif";
    $header_about = join("\n",file("./text/charpage_left.html"));
    $header_directions = join("\n",file("./text/charpage_right.html"));
    include_once("./system/header.php");
	include_once("./system/genmap.php");


	$Pass = "N";
	$sth = mysql_query("select * from user where UserID=$CoreUserData[CoreID]");
	$CurUsers = mysql_num_rows($sth);
	if ($CoreUserData[Subscriber] == "Yes") $CoreUserData[Subscriber] = "Y";
	if ($CoreUserData[Subscriber] == "No") $CoreUserData[Subscriber] = "N";

	if ($CoreUserData[Subscriber] != "Y" && $CurUsers < 2) {
		$Pass = "Y";
	} elseif ($CoreUserData[Subscriber] == "Y" && $CurUsers <= 3) {
		$Pass = "Y";
	}
// Makes sure your register stuff is correct
	if ($Register == "New" && $Pass == "Y") {
		DispReg();
	} elseif ($Register != "" && $Register != "New" && $Pass == "Y") {
		$Register_Pass = 1;
		if (strstr($Register, '<')) 
		{
			DispReg();
			$Register_Pass = 0;
			print "You cannot use symbols or numbers in your character names other than _ and spaces.";
		}
		if (strstr($Register, '`'))
		{
			DispReg();
			$Register_Pass = 0;
			print "You cannot use symbols or numbers in your character names other than _ and spaces.";
		}
                if (strstr($Register, '~'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '1'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '!'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '2'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '@'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '3'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '#'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '4'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '$'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '5'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '%'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '6'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '^'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '7'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '&'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '8'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '*'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '9'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '('))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '0'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, ')'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '-'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '+'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '='))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '['))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '{'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, ']'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '}'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '\\'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '|'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, ';'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, ':'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '\''))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '"'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, ','))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '.'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '>'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '/'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }
                if (strstr($Register, '?'))
                {
                        DispReg();
                        $Register_Pass = 0;
                        print "You cannot use symbols or numbers in your character names other than _ and spaces.";
                }

		$Register = trim($Register);
		$sth = mysql_query("select * from clans where Name='$Register'");
		if (mysql_num_rows($sth) != 0) {
			DispReg();
			$Register_Pass = 0;
		}

		print "<tr><td colspan=4 class=Footer><A HREF=$SCRIPT_NAME?Register=New>Create new Player</A></td></tr>";

		$sth = mysql_query("select * from user where Username='$Register'");
		if (mysql_num_rows($sth) != 0) {
			DispReg();
			$Register_Pass = 0;
		}

		if ($Register_Pass == 1) {
			print "<table border=1 class=Box1 width=98%>";
			print "<Tr><td class=Header>Welcome to Deltoria!</td></tr>";
			print "<tr><td>";
			print "Your registration is complete!";
			$str = rand(5,20);
			$int = rand(5,20);
			$dex = rand(5,20);
			$agi = rand(5,20);
			$wis = rand(5,20);
			$con = rand(5,20);
			$luk = rand(5,20);
			$sth = mysql_query("insert into user (UserID,Username,Strength,Intelligence,Dexterity,Agility,Wisdom,Constitution,Luck) values ($CoreUserData[CoreID],'$Register',$str,$int,$dex,$agi,$wis,$con,$luk)");
			print mysql_error();
			$NewCoreID = mysql_insert_id($db);
			$Subject1 = "Welcome to Deltoria!";
			$Message1 = "The community of Deltoria likes to welcome our new players to the world of quests, clans and adventure. Deltoria is a family-friendly website, and as such, communications are G-rated. We hope you enjoy your stay with us. 

Note: All game forums can be found at http://deltoria.techby2guys.com/forums.php (Down At The Moment) so please register for the forums and read all that is there. All announcements, new in game, game guide, etc are all right there for the players to read. 

Now you are ready to explore the vast world of Deltoria. You begin at the inn, and as you walk out into the world read what the advisors have to say. They will give you information to start you on your way. 
After that, walk around, find monsters, kill them and pick up what they drop. Some items are useful, other items are just good for coins. 

But most of all...explore, experiment and enjoy the game.";
/*			$Subject2 = "Getting started...Tips and Hints";
			$Message2 = "We know you are ready to get started, but to keep from wishing you didn\'t do something, take the time to read 
these tips and hints. 

Check out the Character, Inventory, Who is on, Game mail, Forums, Skills Pages. These are your main pages that you will be dealing with. Game guide 
is old and not complete or completely correct but that page can be opened and viewed by right clicking and opening it in a new window, that way you 
don\'t lose the game page. We had a nice guide but the player that was keeping it up for us doesn\'t play anymore and took the site down... so we 
were left without a guide. A new one is in the process of being made. 

Any time you see a NPC (non-playing character), step on it and find out if he will give you something in trade, or if he will just offer information 
about the game. 

When you want to equip a weapon or armor, you go to your Inventory page and for your first weapon look at the item. Notice it gives you the name of 
item, the Level needed, Sub or not, Value if you salvage it, Armor level or Weapon stats, and skill needed. Train the skill on the Skills page, go 
back to inventory and wield or wear the item. All items have level requirements that must be met. If you already have armor or weapons equipped you 
must unequip the item you wish to replace. 

About skills... Don\'t use all your skill credits at once. Save them up and use them when items you want to combine call for a certain skill. 
Personally I left skills like Brewing alone until all the real important skills were trained. Brewing takes many items for each drink made and will 
take over your inventory. But that is just my opinion.  

On the Character Page you can recall to the Inn in the town where you gave the Priest of Dreams the Stone of Recall. Or you can recall to the last 
portal you used. It is handy as it will save steps and you will not waste move points walking to towns or portals. If you die in battle you will be 
revived at the Inn where you gave the Stone. If you were down a portal you can recall to that portal to continue your quest. 

Forums have different categories. General, Suggestions, Game Information, Bugs, Clan Advertisements and Clan Warfare. When and if you join a clan 
there will be Clan Forums for you to access. In Game Information, under the heading Players Rules, are all the not to do\'s and the consequences of 
breaking them. They may sound strict to some, but it has made the game more enjoyable for our players when they can chat and joke and not put up with 
a zoo.  

You can increase chat lines up to 99 by clicking on Character Page and scrolling down to that feature. Normally you might want between 10 and 15 
lines. If you want to check public chat or clan chat this feature is handy. You can also block any chat from a player that is annoying you. But never 
block an administrator\'s name. That will get you lots of trouble.  

Skill credits should be carefully used as there are some skills you may never use. Skills can use between 1 and 25 credits each. Some of the most 
important skills to have in the beginning is Cooking, Simple Blades, Melee, Defense, Crafting, Clubs and Hammers, Leather Crafting, Iron Crafting. 
Always train Armorsmith and Weaponsmith or you will never be able to make new armor/weapons. If at any time you aren\'t sure what to train, you can 
always send a list of your trained/untrained skills and how many credits you have to Granny, Justme, Whitemecloud or [CA]Spinner and I will be happy 
to advise you. Don\'t spend your credits just to train something as at times you may need 5 credits for something like Portal Tie, which is a very 
important skill to have as you explore the lands more and more. 

The most important thing is to explore everywhere and everything. There will be times you meet monsters that will kill you. That is part of the game. 
Don\'t be in a hurry to get to new places as you may miss something in the rush. 

Now a few tips, you didn\'t think I would have you reading this and not offer a little help, did you. 

1. If you die, all coins in hand disappear. So bank your coins often. If there is no bank, buy health potions to protect your coins. 
2. You will find the crafter close by. Buy a Hammer, train clubs and hammers, equip your hammer. then go between the crafter wall and the fence and 
fight bees. Flowers are a good way to get a head start on coins. The banker is south of the first buildings... follow the path. 
3. Going south and a little east from the banker is something that looks like a cross. That is a portal, step on it and click the name of the Portal 
just above your health bar. Some portals look like a stairway or a hill with a hole in it. You will be transported to a new place. Go south and fight 
deer picking up the items dropped. You will need a lot of tattered skins in this game for crafting, so fight a lot of deer.";*/
			$sth = mysql_query("insert into mail (CoreID, Time, From_CoreID, From_Username, Subject, Body, ToString) values ($NewCoreID, 
Now(), 7442, '[HCA]Spinner', '$Subject1', '$Message1', '$Register')");
			/*$sth = mysql_query("insert into mail (CoreID, Time, From_CoreID, From_Username, Subject, Body, ToString) values ($NewCoreID, 
Now(), 7442, '[HCA]Spinner', '$Subject2', '$Message2', '$Register')");*/			
			$sth = mysql_query("insert into user_skills (SkillID,CoreID,Level) values (1,$NewCoreID,5)");
			$sth = mysql_query("insert into user_skills (SkillID,CoreID,Level) values (9,$NewCoreID,5)");
			$sth = mysql_query("insert into user_skills (SkillID,CoreID,Level) values (11,$NewCoreID,5)");
			LootGen(0,$NewCoreID,0,0,0,415,1,10,0); // Health Elixer
			print mysql_error();			
			print "</td></tr>";
			print "</table><p>";
		} else {
			print "That name is taken.";
		}
	}

	// Deletes Character
	if ($DelUser != "" && $Accept == "N") {
		$sth = mysql_query("select * from user where CoreID=$DelUser and UserID=$CoreUserData[CoreID] and ClanID=0");
		print mysql_error();
		if (mysql_num_rows($sth) == 1) {
			$UData = mysql_fetch_array($sth);
			print "Are you sure you wish to delete $UData[Username]?<BR><A HREF=$SCRIPT_NAME?DelUser=$DelUser&Accept=Y><IMG BORDER=0 SRC=./images/buttons/yes.jpg></A>";
		} else {
			print "Unable to locate that user";
		}
	} elseif ($DelUser != "" && $Accept == "Y") {
		$sth = mysql_query("select * from user where CoreID=$DelUser and UserID=$CoreUserData[CoreID] and ClanID=0");
		if (mysql_num_rows($sth) == 1) {
			$sth = mysql_query("delete from chatter where CoreID=$DelUser");
			$sth = mysql_query("delete from mail where CoreID=$DelUser");
			$sth = mysql_query("delete from mail where From_CoreID=$DelUser");
			$sth = mysql_query("delete from forums_posts where CoreID=$DelUser");
			$sth = mysql_query("delete from chatter where CoreID=$DelUser");
			$sth = mysql_query("select ObjectID from items where CoreID=$DelUser");
			while (list($ObjID) = mysql_fetch_row($sth)) {
				$sth_del = mysql_query("delete from itemspells where ObjectID=$ObjID");
			}
			$sth = mysql_query("delete from items where CoreID=$DelUser");
		
			$sth = mysql_query("delete from user_block where CoreID=$DelUser");
			$sth = mysql_query("delete from user where CoreID=$DelUser");
			$sth = mysql_query("delete from user_kills where CoreID=$DelUser");
			$sth = mysql_query("delete from user_log where CoreID=$DelUser");
			$sth = mysql_query("delete from user_quest where CoreID=$DelUser");
			$sth = mysql_query("delete from user_skills where CoreID=$DelUser");
			print "Deleted.<BR>";
		} else {
			print "Unable to locate that eligable user.";
		}
	}

// Select User
	if ($SelUser == "") {

	$sql = "select u.*,c.Name as ClanName from user as u left join clans as c on c.ClanID=u.ClanID where u.UserID=$CoreUserData[CoreID]";
	$sth = mysql_query($sql);
	$CurUsers = mysql_num_rows($sth);
	while ($UData = mysql_fetch_array($sth)) {
		print "<table border=0 width=98%>";
		print "<tr><td width=150>";
		GenMap($UData[X], $UData[Y], $UData[MapID], 3, 3, $UData[UserPic]);
		print "</td><td valign=top class=Text>";
		print "<center>";
		print "<table border=1 class=Box1 width=100%>";
		print "<tr><td colspan=5 class=Header>";
		print "Viewing $UData[Username] ";
		if ($UData[ClanID] == 0) print "(<A HREF=charpage.php?DelUser=$UData[CoreID]&Accept=N>Remove this Player</A>)";
		print "</td></tr>";
		print "<tr><td class=Menu>Clan</td><td class=Menu>Coins</td><td class=menu>Level</td><Td class=menu>Turns</td><td class=Menu>Actions</td></tr>";
		print "<tr>";
		print "<td class=text>";
		if ($UData[ClanID] == 0) print "None"; else print $UData[ClanName];
		print "</td>";
		print "<td class=text>".number_format($UData[Coins])." (".number_format($UData[BankedCoins])." banked)</td>";
		print "<td class=text>$UData[Level]</td>";
		print "<td class=text>$UData[Turns]</td>";
		print "<td class=text>$UData[Actions]</td>";
		print "</tr>";
		print "<tr><td colspan=2 valign=top>";

	    print "<table width=100% border=0 cellpadding=0 cellspacing=0>";
	    print "<Tr><td colspan=2 class=Header>Quest Timers</td></tr>";
	    print "<tr><td class=menu>Quest Name</Td><Td class=menu>Time Remaining</td></tr>";
	    $sth_quest = mysql_query("select ((UNIX_TIMESTAMP(uq.QuestTimer)-UNIX_TIMESTAMP())) as Minutes,q.Name from user_quest as uq left join questdata as q on q.QuestID=uq.Quest where q.Name is not null and uq.CoreID=".$UData[CoreID]);
		if (mysql_num_rows($sth_quest) == 0) print "<tr><td class=text colspan=2>You have no quests taken</td></tr>";
	
    	while ($QData = mysql_fetch_array($sth_quest)) {
    	    print "<TR><TD class=text>$QData[Name]</TD>";

// Gets idle time
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
	        print "<TD class=text>$IdleTime $IdleMod</TD></TR>";
	    }
		print "</table>";


		print "</td>";
		print "<td colspan=3 valign=top>";
		print "<table cellpadding=0 cellspacing=0 border=0 width=100%>";
		print "<tr>";
		print "<td colspan=4 class=header>Unread Messages</td>";
		print "<tr><td class=menu>Sent</td><td class=menu>From</td><td class=Menu>Subject</td></tr>";
		$sth_gmail = mysql_query("select Subject,date_format(Time,'%m-%d-%Y') as Time,From_Username from mail where CoreID=$UData[CoreID] and Deleted='N' and Status='Unread' order by Time DESC limit 5");
		print mysql_error();
		while (list($M_Subj,$M_Time,$M_From) = mysql_fetch_row($sth_gmail)) {
			print "<tr>";
			print "<td class=text>$M_Time</td>";
			print "<td class=text>$M_From</td>";
			print "<td class=text>$M_Subj</td>";
			print "</tr>";
		}
		print "</table>";
		print "</td>";
		print "</tr>";
		print "<tr><td colspan=5 CLASS=Menu>";
		print "[ <A HREF=$SCRIPT_NAME?SelUser=$UData[CoreID]>Login as $UData[Username]</A> ] ";
		print "</td></tr>";

		print "</table>";
		print "</center>";
		print "</td></tr>";
		print "</table><p>";
	}

// Create new player, you can change the ammount of players someone can create here
		if ($CoreUserData[Subscriber] != "Y" && $CurUsers < 2) {
			print "<TABLE WIDTH=98%>";
			print "<Tr><td class=HEADER>Create a new player!</td></tr>";
			print "<tr><td class=Footer><A HREF=$SCRIPT_NAME?Register=New>Create new Player</A></td></tr>";
			print "</table>";
		} elseif ($CoreUserData[Subscriber] == "Y" && $CurUsers <= 3) {
			print "<TABLE WIDTH=98%>";
			print "<Tr><td class=HEADER>Create a new player!</td></tr>";
			print "<tr><td class=Footer><A HREF=$SCRIPT_NAME?Register=New>Create new Player</A></td></tr>";
			print "</table>";
		}

		print "<p>";
// Change your password
		print "<table class=box1 width=98%>";
		print "<FORM ACTION=$SCRIPT_NAME METHOD=POST>";
		print "<tr><td class=header>Change Password</td></tr>";
		print "<tr><td>";
		if ($Password_New != "") {
			$sth = mysql_query("select * from user_base where UserID=$CoreUserData[CoreID] and Password=old_password('$Password_Old')");
			if ($Password_New != $Password_New_Two) {
				print "<FONT COLOR=RED>ERROR:</FONT> Your two new passwords failed to match.<p>";
			} elseif (mysql_num_rows($sth) == 0) {
				print "<FONT COLOR=RED>ERROR:</FONT> You failed to enter your current password correctly.<p>";
			} else {
				$sth = mysql_query("update user_base set Password=old_password('$Password_New') where UserID=$CoreUserData[CoreID]");
				print mysql_error();
				print "<B>Your password has been changed.</B><P>";
			}
		}
		print "<table class=pagecontainer>";
		print "<tr><td class=text>Old Password</td><td class=pagecell><input type=PASSWORD name=Password_Old></td></tr>";
		print "<tr><td class=text>New Password</td><td class=pagecell><input type=PASSWORD name=Password_New></td></tr>";
		print "<tr><td class=text>Re-Enter New Password</td><td class=pagecell><input type=PASSWORD name=Password_New_Two></td></tr>";
		print "</table>";
		print "</td></tr>";
		print "<tr><td class=footer><input type=submit name=submit value=\"Change my Password\"></td></tr>";
		print "</FORM>";
		print "</table><p>";

// Show NEWS posted from the editor
		print "<table border=0 class=Box1 width=98%>";
		print "<Tr><td class=Header colspan=2>News</td></tr>";
//		$sth = mysql_query("select count(*)-10 from news order by Date");
//		list($NewsCount) = mysql_fetch_row($sth);
//		if ($NewsCount < 0) { $NewsCount = 0; }


//		$sth = mysql_query("select DATE_FORMAT(Date,'%b %D %h:%i %p') as Date,Text from news limit $NewsCount,10");
		$sth = mysql_query("select DATE_FORMAT(Date,'%b %D %h:%i %p') as Date,Text from news order by NewsID desc limit 10");
		print mysql_error();

//		for ($i = mysql_num_rows($sth) - 1; $i >= 0; $i--) {
		for ($i = 0; $i <= mysql_num_rows($sth) - 1; $i++) {
			if (!mysql_data_seek($sth, $i)) {
				echo "Cannot seek to row $i: " . mysql_error() . "\n";
				continue;
			}
			if (!list($News_Date,$News_Text) = mysql_fetch_row($sth)) continue;
			print "<tr><td class=text>$News_Date</td><td class=text>$News_Text</td></tr>";
		}
		print "</table><p>";

	} else {
		$sth = mysql_query("select * from user where UserID=$CoreUserData[CoreID] and CoreID=$SelUser");
		if (mysql_num_rows($sth) == 0) { 
			print "We were unable to locate that user.<P>";
		} else {
			$sth = mysql_query("update user_base set DeltoriaID=$SelUser where UserID=$CoreUserData[CoreID]");
			print mysql_error();
			$CoreUserData[DeloriaID] = $SelUser;
			print "<center>";
			print "<table border=0 class=Box1 Width=98%>";
			print "<tr><td class=Header>News Items</td></tr>";
			print "<tr><td colspan=2 class=text>";

			$sth = mysql_query("select * from frontnews order by NewsDate DESC limit 5");
			while ($data = mysql_fetch_array($sth)) {
				print "<B>".$data['Name']."</B> (<I>Updated on ".$data['NewsDate'].")</I><BR>";
				print $data['Body']."<HR>";
			}





			print "</td></tr>";
			print "<tr><td colspan=2 class=footer>";
			print "<A HREF=./start.php>Enter Deltoria</A>";
			print "</td></tr></table>";
		}

	}
	include ("./system/footer.php");

// Rules and such
function DispReg() {
		print "<table border=1 class=Box1>";
		print "<tr><td class=header colspan=2>Rules</td></tr>";
		print "<tr><td colspan=2>Please do not make inappropriate names.<br>
English is to be spoken at all times.<br>
Swearing of any kind or the use of symbols to mask swearing is not allowed.<br>
No selling or buying of any accounts.<br>
Cheating or an attempt to cheat will be harshly dealt with.<br>
Do not give out game information on public chat.<br>
Do not share personal information on public chat.<br>
Only one email account. Do not make multi accounts.<br>
<br>
A detailed list of rules and penalties are found in Game Information forum. Please read them as the rules are strictly applied.</br></td></tr>";

		print "<tr><td class=Menu>What do you wish to be called?</td><td class=Menu>Register</td></tr>";
		print "<FORM ACTION=$SCRIPT_NAME>";
		print "<tr><td><input type=text size=25 name=Register maxlength=25></td><td><input type=submit name=submit value=Create></td></tr>";
		print "</table><P>";
}


?>