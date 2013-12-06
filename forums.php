<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// In game forums
// To enable remove some commented code
        ########################
        ## Make us our connection
        global $db;
        include ("./system/top.php");
        include ("./system/move.php");
	//include("./spaw/spaw_control.class.php");

// Admins can delete posts
	if ($PlayerData->Admin == "Y" && $Delete > 0) {
		$sth = mysql_query("delete from forums_index where ForumID=$Delete");
		print mysql_error();
		$sth = mysql_query("delete from forums_posts where ForumID=$Delete");
		print mysql_error();
		$sth = mysql_query("delete from forums_posts where forums_posts.PostID=$Delete");
		print mysql_error();
	}

	if ($oldpost > 0) {


		$postreply = str_replace("<","&GALT;",$postreply);
		$postreply = str_replace(">","&GAGT;",$postreply);
		$postreply = ereg_replace("&GALT;STRONG&GAGT;","<STRONG>",$postreply);
		$postreply = ereg_replace("&GALT;/STRONG&GAGT;","</STRONG>",$postreply);
		$postreply = ereg_replace("&GALT;EM&GAGT;","<EM>",$postreply);
		$postreply = ereg_replace("&GALT;/EM&GAGT;","</EM>",$postreply);
		$postreply = ereg_replace("&GALT;U&GAGT;","<U>",$postreply);
		$postreply = ereg_replace("&GALT;/U&GAGT;","</U>",$postreply);
		$postreply = ereg_replace("&GALT;P&GAGT;","<P>",$postreply);
		$postreply = ereg_replace("&GALT;/P&GAGT;","</P>",$postreply);
		$postreply = preg_replace("/&GALT;FONT color=#(\w{6})&GAGT;/","<FONT color=\${1}>",$postreply);
		$postreply = ereg_replace("&GALT;/FONT&GAGT;","</FONT>",$postreply);
		$postreply = ereg_replace("&GALT;","&lt;",$postreply);
		$postreply = ereg_replace("&GAGT;","&gt;",$postreply);
		$postreply = ereg_replace("  ","&nbsp;&nbsp;",$postreply);
		$postreply = ereg_replace("&GALT;BR&GAGT;","",$postreply);

		$postreply = ereg_replace("\%color=red%","<FONT COLOR=RED>",$postreply);
		$postreply = ereg_replace("\%/color%","</FONT>",$postreply);
		$postreply = ereg_replace("\%color=green%","<FONT COLOR=GREEN>",$postreply);
		$postreply = ereg_replace("\%color=blue%","<FONT COLOR=BLUE>",$postreply);
		$postreply = ereg_replace("\%b%","<B>",$postreply);
		$postreply = ereg_replace("\%/b%","</B>",$postreply);
		$postreply = ereg_replace("\%i%","<I>",$postreply);
		$postreply = ereg_replace("\%/i%","</I>",$postreply);
		$postreply = ereg_replace("\%u%","<U>",$postreply);
		$postreply = ereg_replace("\%/u%","</U>",$postreply);

//		$postreply = ereg_replace("\n","<BR>",$postreply);
		$postreply = ereg_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$postreply);

		$sth = mysql_query("select * from forums_index where ForumID=$oldpost order by sticky");
		if (mysql_num_rows($sth) > 0) {
			$index_data = mysql_fetch_array($sth);
			if ($index_data[Locked] != "Y" && ($index_data[ClanID] == 0 || $index_data[ClanID] == $PlayerData->ClanID)) {
				if ($Poll_Answer != "") {
					$sth = mysql_query("select * from forums_poll where ForumID=$oldpost and CoreID=$PlayerData->CoreID");
					print mysql_error();
					if (mysql_num_rows($sth) == 0) {
						$sth = mysql_query("insert into forums_poll (ForumID,CoreID,AnswerID) values ($oldpost,$PlayerData->CoreID,$Poll_Answer)");
						print mysql_error();
					}
				}
				if ($postreply != "") {
					$sth = mysql_query("insert into forums_posts (Username,IP_Addr,CoreID,Body,ForumID,Time,ClanID) values ('$PlayerData->Username','".nicehost(gethostbyaddr($REMOTE_ADDR))."',$PlayerData->CoreID,'$postreply',$oldpost,NOW(),'$index_data[ClanID]')");
					$sth = mysql_query("update forums_index set Last_Username='$PlayerData->Username',ClanID='0',Last_CoreID=$PlayerData->CoreID,Last_Time=NOW() where ForumID=$oldpost");
					set_ts($oldpost);
					$sth = mysql_query("update HTTPGames.Core_Users set Posts=Posts+1 where CoreID=".$PlayerData->CoreID);
				}
			}
		}
	}

	function set_ts($curparent) {
		global $db,$CoreUserData,$PlayerData;
		$CoreID = $PlayerData->CoreID;
		while ($curparent > 0) {
			$sth = mysql_query ("select * from forums_index where ForumID=$curparent and ClanID='0'");
			$data = mysql_fetch_array($sth);
			$sth = mysql_query("update forums_index set Last_Username='$PlayerData->Username',Total=Total+1,Last_Time=NOW(),Last_CoreID=$PlayerData->CoreID where ForumID=$curparent");
			$curparent = $data[ParentID];
		}
	}

	if ($newpost > 0) {

		$post = str_replace("<","&GALT;",$post);
		$post = str_replace(">","&GAGT;",$post);
		$post = ereg_replace("&GALT;STRONG&GAGT;","<STRONG>",$post);
		$post = ereg_replace("&GALT;/STRONG&GAGT;","</STRONG>",$post);
		$post = ereg_replace("&GALT;EM&GAGT;","<EM>",$post);
		$post = ereg_replace("&GALT;/EM&GAGT;","</EM>",$post);
		$post = ereg_replace("&GALT;U&GAGT;","<U>",$post);
		$post = ereg_replace("&GALT;/U&GAGT;","</U>",$post);
		$post = ereg_replace("&GALT;P&GAGT;","<P>",$post);
		$post = ereg_replace("&GALT;/P&GAGT;","</P>",$post);
		$post = preg_replace("/&GALT;FONT color=#(\w{6})&GAGT;/","<FONT color=\${1}>",$post);
		$post = ereg_replace("&GALT;/FONT&GAGT;","</FONT>",$post);
		$post = ereg_replace("&GALT;","&lt;",$post);
		$post = ereg_replace("&GAGT;","&gt;",$post);
		$post = ereg_replace("  ","&nbsp;&nbsp;",$post);

		$post = ereg_replace("&GALT;BR&GAGT;","",$post);

		$post = ereg_replace("\%color=red%","<FONT COLOR=RED>",$post);
		$post = ereg_replace("\%/color%","</FONT>",$post);
		$post = ereg_replace("\%color=green%","<FONT COLOR=GREEN>",$post);
		$post = ereg_replace("\%color=blue%","<FONT COLOR=BLUE>",$post);
		$post = ereg_replace("\%b%","<B>",$post);
		$post = ereg_replace("\%/b%","</B>",$post);
		$post = ereg_replace("\%i%","<I>",$post);
		$post = ereg_replace("\%/i%","</I>",$post);
		$post = ereg_replace("\%u%","<U>",$post);
		$post = ereg_replace("\%/u%","</U>",$post);

//		$post = ereg_replace("\n","<BR>",$post);
		$post = ereg_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$post);

		$subject = ereg_replace(" ","&nbsp;",$subject);
		$subject = ereg_replace(">","&gt;",$subject);
		$subject = ereg_replace("<","&lt;",$subject);
		$subject = ereg_replace("\n","<BR>",$subject);
		$subject = ereg_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$subject);

		$sth = mysql_query("select * from forums_index where ForumID=$newpost and (ClanID=0 or ClanID=$PlayerData->ClanID)");
		print mysql_error();
		if (mysql_num_rows($sth) > 0) {
			$FPData = mysql_fetch_array($sth);
			if ($Poll_00 != "") {
				$Poll = "Y";
			} else {
				$Poll = "N";
			}

			$sth = mysql_query("insert into forums_index (Username,Last_Username,CoreID,Last_CoreID,ParentID,Topic,Total,Last_Time,ClanID,Poll,Poll_Q0,Poll_Q1,Poll_Q2,Poll_Q3,Poll_Q4,Poll_Q5,Poll_Q6,Poll_Q7,Poll_Q8,Poll_Q9) values ('$PlayerData->Username','$PlayerData->Username',$PlayerData->CoreID,$PlayerData->CoreID,$newpost,'$subject',1,NOW(),'$FPData[ClanID]','$Poll','$Poll_00','$Poll_01','$Poll_02','$Poll_03','$Poll_04','$Poll_05','$Poll_06','$Poll_07','$Poll_08','$Poll_09')");
			if (!$sth) { print mysql_error(); }
			$post_forum = mysql_insert_id($db);

			$sth = mysql_query("insert into forums_posts (Username,IP_Addr,ClanID,CoreID,Body,ForumID,Time) values ('$PlayerData->Username','".nicehost(gethostbyaddr($REMOTE_ADDR))."','0',$PlayerData->CoreID,'$post',$post_forum,NOW())");
			if (!$sth) { print mysql_error(); }
			$read = $post_forum;
			set_ts($newpost);

			$sth = mysql_query("update HTTPGames.Core_Users set Posts=Posts+1 where CoreID=".$PlayerData->CoreID);
		}
	}


	if ($Edit > 0 && $Save == "N") {
		if ($PlayerData->Admin == "Y") {
			$sth = mysql_query("select * from forums_posts where PostID=$Edit");
		} else {
			$sth = mysql_query("select * from forums_posts where PostID=$Edit and CoreID=$PlayerData->CoreID");
		}
		if (mysql_num_rows($sth) > 0) {
			$data = mysql_fetch_array($sth);
			print "<table border=0 class=Box1 width=700>";
			print "<Form action=$SCRIPT_NAME METHOD=POST>";
			print "<input type=hidden name=Edit VALUE=$Edit>";
			print "<input type=hidden name=Save VALUE=Y>";
			print "<input type=hidden name=tree VALUE=$tree>";
			print "<input type=hidden name=read VALUE=$read>";
			print "<tr><td class=Header>Edit Posting</td></tr>";
			print "<Tr><td><textarea name=EditBody COLS=60 ROWS=5>";
			print Forum2Post($data[Body]);
			print "</textarea></td></tr>";
			print "<tr><td class=Footer><input type=submit name=submit value=Save></td></tr>";
			print "</FORM>";
			print "</table><p>";
		}
	} elseif ($Edit > 0 && $Save == "Y") {
		$EditBody = Post2Forum($EditBody);
		$EditBody = $EditBody."<P><B>Edited on ".date("D M j G:i:s T Y")."</B>";
		if ($PlayerData->Admin == "Y") {
			$sth = mysql_query("update forums_posts set Body='$EditBody' where PostID=$Edit");
		} else {
			$sth = mysql_query("update forums_posts set Body='$EditBody' where PostID=$Edit and CoreID=$PlayerData->CoreID");
		}
		print mysql_error();
	}



	##########################
	## If we're reading a topic list it here
	##########################
	if ($read > 0) {
		if ($PlayerData->Admin == "Y") {
			if ($Lock == $read) {
				$sth = mysql_query("update forums_index set Locked='Y' where ForumID=$read");
				$data[Locked] = "Y";
			} elseif ($Unlock == $read) {
				$sth = mysql_query("update forums_index set Locked='N' where ForumID=$read");
				$data[Locked] = "N";
			}

			if ($Sticky == $read) {
				$sth = mysql_query("update forums_index set Sticky='Y' where ForumID=$read");
				$data[Sticky] ="Y";
			} elseif ($Unsticky == $read) {
				$sth = mysql_query("update forums_index set Sticky='N' where ForumID=$read");
				$data[Sticky] ="N";
			}

			if ($Importaint == $read) {
				$sth = mysql_query("update forums_index set Importaint=1 where ForumID=$read");
				$data[Importaint] = 1;
			} elseif ($Unimportaint == $read) {
				$sth = mysql_query("update forums_index set Importaint=0 where ForumID=$read");
				$data[Importaint] = 0;
			}

		}


		$sth = mysql_query("select * from forums_index where ForumID=$read and (ClanID=0 or ClanID='$PlayerData->ClanID')");
		$data = mysql_fetch_array($sth);
		$Locked = $data[Locked];
		$Sticky = $data[Sticky];
		$Importaint = $data[Importaint];
		$TheParent = $data[ParentID];
		$sth1 = mysql_query("select * from forums_index where ForumID='".$TheParent."'");
		print mysql_error();
		if ($current['ClanID'] != 0 && $current['ClanID'] != $PlayerData->ClanID) exit;
		$data1 = mysql_fetch_array($sth1);
		$Clan = $data1[ClanID];
		if ($PlayerData->ClanID <> $Clan && $Clan <> 0) { exit; }
		$sth = mysql_Query("select Topic from forums_index where ForumID='".$TheParent."'");
		list($TheParentTopic) = mysql_fetch_row($sth);

		if ($data[Locked] == "Y" && $PlayerData->Admin == "Y") {
			print "<A HREF=$SCRIPT_NAME?tree=".intval($tree)."&read=$read&Unlock=$data[ForumID]>Unlock</A> | ";
		} elseif ($data[Locked] == "N" && $PlayerData->Admin == "Y") {
			print "<A HREF=$SCRIPT_NAME?tree=".intval($tree)."&read=$read&Lock=$data[ForumID]>Lock</A> | ";
		}

		if ($data[Sticky] =="Y" && $PlayerData->Admin == "Y") {
			print "<A HREF=$SCRIPT_NAME?tree=".intval($tree)."&read=$read&Unsticky=$data[ForumID]>Unsticky</A> | ";
		} elseif ($data[Sticky] =="N" && $PlayerData->Admin == "Y") {
			print "<A HREF=$SCRIPT_NAME?tree=".intval($tree)."&read=$read&Sticky=$data[ForumID]>Sticky</A> | ";
		}

		if ($data[Importaint] == 1 && $PlayerData->Access >= 2) {
			print "<A HREF=$SCRIPT_NAME?tree=".intval($tree)."&read=$read&Unimportaint=$data[ForumID]>Unimportant</A> | ";
		} elseif ($data[Importaint] == 0 && $PlayerData->Access >= 2) {
			print "<A HREF=$SCRIPT_NAME?tree=".intval($tree)."&read=$read&Importaint=$data[ForumID]>Important</A> | ";
		}
		$Forum_Poll = $data[Poll];
		$Forum_Poll_00 = $data[Poll_Q0];
		$Forum_Poll_01 = $data[Poll_Q1];
		$Forum_Poll_02 = $data[Poll_Q2];
		$Forum_Poll_03 = $data[Poll_Q3];
		$Forum_Poll_04 = $data[Poll_Q4];
		$Forum_Poll_05 = $data[Poll_Q5];
		$Forum_Poll_06 = $data[Poll_Q6];
		$Forum_Poll_07 = $data[Poll_Q7];
		$Forum_Poll_08 = $data[Poll_Q8];
		$Forum_Poll_09 = $data[Poll_Q9];

		print "<table border=1 class=Box1 width=700>";
		print "<TR><td class=Header COLSPAN=2>";
		print "Reading: $data[Topic]!</TD></TR>";

		if ($Forum_Poll == "Y") {
			$sth = mysql_query("select count(*) from forums_poll where ForumID=$data[ForumID]");
			list($Answers) = mysql_fetch_row($sth);

			$sth = mysql_query("select AnswerID,count(CoreID) from forums_poll where ForumID=$data[ForumID] group by AnswerID");
			while (list($AnswerID,$Picks) = mysql_fetch_row($sth)) {
				$Poll[$AnswerID] = $Picks;
			}


			print "<tr><td colspan=2>";
			print "<TABLE class=Pagecontainer border=0>";

			print "<tr><td class=pageCell>$Forum_Poll_00 [<B>".intval($Poll[0])."</B>]</td><td class=pageCell>";
			GenBar_Lite($Poll[0],$Answers,200,"health");
			print "</td></tr>";

			if ($Forum_Poll_01 != "") {
				print "<tr><td class=pageCell>$Forum_Poll_01 [<B>".intval($Poll[1])."</B>]</td><td class=pageCell>";
				GenBar_Lite($Poll[1],$Answers,200,"health");
				print "</td></tr>";
			}

			if ($Forum_Poll_02 != "") {
				print "<tr><td class=pageCell>$Forum_Poll_02 [<B>".intval($Poll[2])."</B>]</td><td class=pageCell>";
				GenBar_Lite($Poll[2],$Answers,200,"health");
				print "</td></tr>";
			}

			if ($Forum_Poll_03 != "") {
				print "<tr><td class=pageCell>$Forum_Poll_03 [<B>".intval($Poll[3])."</B>]</td><td class=pageCell>";
				GenBar_Lite($Poll[3],$Answers,200,"health");
				print "</td></tr>";
			}

			if ($Forum_Poll_04 != "") {
				print "<tr><td class=pageCell>$Forum_Poll_04 [<B>".intval($Poll[4])."</B>]</td><td class=pageCell>";
				GenBar_Lite($Poll[4],$Answers,200,"health");
				print "</td></tr>";
			}

			if ($Forum_Poll_05 != "") {
				print "<tr><td class=pageCell>$Forum_Poll_05 [<B>".intval($Poll[5])."</B>]</td><td class=pageCell>";
				GenBar_Lite($Poll[5],$Answers,200,"health");
				print "</td></tr>";
			}

			if ($Forum_Poll_06 != "") {
				print "<tr><td class=pageCell>$Forum_Poll_06 [<B>".intval($Poll[6])."</B>]</td><td class=pageCell>";
				GenBar_Lite($Poll[6],$Answers,200,"health");
				print "</td></tr>";
			}

			if ($Forum_Poll_07 != "") {
				print "<tr><td class=pageCell>$Forum_Poll_07 [<B>".intval($Poll[7])."</B>]</td><td class=pageCell>";
				GenBar_Lite($Poll[7],$Answers,200,"health");
				print "</td></tr>";
			}

			if ($Forum_Poll_08 != "") {
				print "<tr><td class=pageCell>$Forum_Poll_08 [<B>".intval($Poll[8])."</B>]</td><td class=pageCell>";
				GenBar_Lite($Poll[8],$Answers,200,"health");
				print "</td></tr>";
			}

			if ($Forum_Poll_09 != "") {
				print "<tr><td class=pageCell>$Forum_Poll_09 [<B>".intval($Poll[9])."</B>]</td><td class=pageCell>";
				GenBar_Lite($Poll[9],$Answers,200,"health");
				print "</td></tr>";
			}

			print "</table></td></tr>";
		}

		if ($Forum_Poll == "Y") { 
			$sth = mysql_query("select * from forums_poll where ForumID=$data[ForumID] and CoreID=$PlayerData->CoreID");
			if (mysql_num_rows($sth) > 0) {
				$Forum_Poll = "N";
			}
		}

		$sth = mysql_query("select P.IP_Addr,P.PostID,P.Username,P.CoreID,P.ForumID,DATE_FORMAT(P.Time,'%b %D\, %Y %h:%i %p') as ts,Body from 
forums_posts as P left join user as U on U.CoreID=P.CoreID where ForumID=$read and P.ClanID=0 order by Time");
		print mysql_error();
		while ($data = mysql_fetch_array($sth)) {
			$data[Body] = ereg_replace("&nbsp;"," ",$data[Body]);

			# Smiley face picture replacing function
			# $data[Body] = smileys($data[Body]);
			print "<TR><TD VALIGN=TOP WIDTH=150 class=Informative>$data[Username]<BR>$data[ts]<BR>";
			print "$data[IP_Addr]<BR>";
			if ($PlayerData->Access >=2 ) { print "CoreID: $data[CoreID]<BR>"; }
			print "<BR>";

			if ($data[UserIcon] != "") {
				print "<IMG SRC=/images/icons/$data[UserIcon]>";
			}

			$BlockSTH = mysql_query("select * from user_block where CoreID=$PlayerData->CoreID and BlockID=$data[CoreID]");
			if (mysql_num_rows($BlockSTH) == 0) {
				if ($PlayerData->Subscriber == 'Y') {
					$data[Body] = smilies($data[Body]);
				}
				print "</TD><TD VALIGN=TOP><font SIZE=1 face=\"Verdana, Arial, Sans-Serif, Helvetica\" color=\"BLACK\">$data[Body]</FONT>";
				if ($data[CoreID] == $PlayerData->CoreID || $PlayerData->Admin == "Y") {
					print "<BR>[ <A HREF=$SCRIPT_NAME?Edit=$data[PostID]&Save=N&tree=$tree&read=$read>Edit</A> ]"; 
				}
				print "</TD></TR>";
			} else {
				print "</TD><TD VALIGN=TOP><font SIZE=1 face=\"Verdana, Arial, Sans-Serif, Helvetica\" color=\"BLACK\">*** BLOCKED ***</FONT></TD></TR>";
			}
		}
		print "<TR><TD BGCOLOR=#f4f4f4 ALIGN=RIGHT COLSPAN=2><FONT SIZE=-1 COLOR=BLACK>Return To: <B><A HREF=forums.php?CoreID=$PlayerData->CoreID&Verify=$Verify&Tree=$TheParent>$TheParentTopic</A></TD></TR></TABLE><P>";
		if ($Locked != "Y") {
			print "<FORM ACTION=forums.php METHOD=POST><INPUT TYPE=HIDDEN NAME=CoreID VALUE=$PlayerData->CoreID><INPUT TYPE=HIDDEN NAME=Verify VALUE=$Verify>";
			print "<FONT SIZE=-1><B>Add to this Thread</B></FONT><BR>";


			if ($Forum_Poll == "Y") {
				print "<INPUT TYPE=RADIO NAME=Poll_Answer VALUE=0> $Forum_Poll_00<BR>";
				if ($Forum_Poll_01 != "") { print "<INPUT TYPE=RADIO NAME=Poll_Answer VALUE=1> $Forum_Poll_01<BR>"; }
				if ($Forum_Poll_02 != "") { print "<INPUT TYPE=RADIO NAME=Poll_Answer VALUE=2> $Forum_Poll_02<BR>"; }
				if ($Forum_Poll_03 != "") { print "<INPUT TYPE=RADIO NAME=Poll_Answer VALUE=3> $Forum_Poll_03<BR>"; }
				if ($Forum_Poll_04 != "") { print "<INPUT TYPE=RADIO NAME=Poll_Answer VALUE=4> $Forum_Poll_04<BR>"; }
				if ($Forum_Poll_05 != "") { print "<INPUT TYPE=RADIO NAME=Poll_Answer VALUE=5> $Forum_Poll_05<BR>"; }
				if ($Forum_Poll_06 != "") { print "<INPUT TYPE=RADIO NAME=Poll_Answer VALUE=6> $Forum_Poll_06<BR>"; }
				if ($Forum_Poll_07 != "") { print "<INPUT TYPE=RADIO NAME=Poll_Answer VALUE=7> $Forum_Poll_07<BR>"; }
				if ($Forum_Poll_08 != "") { print "<INPUT TYPE=RADIO NAME=Poll_Answer VALUE=8> $Forum_Poll_08<BR>"; }
				if ($Forum_Poll_09 != "") { print "<INPUT TYPE=RADIO NAME=Poll_Answer VALUE=9> $Forum_Poll_09<BR>"; }
			}

			print "<INPUT TYPE=HIDDEN NAME=oldpost VALUE=$read><INPUT TYPE=HIDDEN NAME=read VALUE=$read><INPUT TYPE=HIDDEN NAME=tree VALUE=".intval($tree).">";

//			$swreply = new SPAW_Wysiwyg('postreply' /*name*/,stripslashes($HTTP_POST_VARS['post']) /*value*/,'en' /*language*/, 'deltoria' /*toolbar mode*/, '' /*theme*/,'500px' /*width*/, '150px' /*height*/);
//			$swreply->show();


			print "<TEXTAREA WRAP=HARD COLS=60 ROWS=5 NAME=postreply>";
//	                if ($PlayerData->Footer != "") {
//	                        print "\n\n--------------------------\n$PlayerData->Footer";
//	                }
			print "</TEXTAREA>";
			print "<BR><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=\"Submit Post\"><P>";
			print "</FORM>";
		} elseif ($Locked == "Y") {
			print "<B>This thread is locked</B><P>";
		}
	}
	if ($Read == "") {
		##########################
		## Show Current Location
		##########################
		print "<table border=1 class=Box1 width=700>";
		if ($PlayerData->ClanData->Founder == $PlayerData->CoreID && $NewParent != "") {
			$sth = mysql_query("insert into forums_index (Topic,ClanID) values ('$NewParent',$PlayerData->ClanID)");
			print mysql_error();
		}

		if (intval($tree) != 0) {
			$sth = mysql_query("select * from forums_index where ForumID='".intval($tree)."'");
			print mysql_error();
			$current = mysql_fetch_array($sth);
			if ($current['ClanID'] != 0 && $current['ClanID'] != $PlayerData->ClanID) exit;
			if ($current['ParentID'] > 0) {
				$sth = mysql_query("select * from forums_index where ForumID='".intval($current['ParentID'])."' and (ClanID=0 or ClanID=".$PlayerData->ClannID.")");
				if (mysql_num_rows($sth) == 0) exit;
			}
			print "<tr><td COLSPAN=7 class=Header>You're currently viewing: <B>$current[Topic]</B></TD></TR>";
			print "<tr><td class=Menu>Last Post Date</td><td class=Menu>Topic</td><td class=Menu>Last Poster</td><Td class=Menu>Author</td><td class=Menu>Posts</td></tr>";
		} else {
			print "<tr><td COLSPAN=6 class=Header>You're currently viewing: <B>Main Forums</B></TD></TR>";
			print "<tr><td class=Menu>Last Post Date</td><td class=Menu>Topic</td><td class=Menu>Last Poster</td><td class=Menu>Posts</td></tr>";
		}
		##########################
		## Display Categories
		##########################
		// print("select A.Username as Author,U.Username as Last_Username,F.*,DATE_FORMAT(F.Last_Time,'%b %D %h:%i %p') as ts from forums_index as F left join user as A on A.CoreID=F.CoreID left join user as U on U.CoreID=F.Last_CoreID where F.ParentID=".intval($tree)." and (F.ClanID=$PlayerData->ClanID or F.ClanID=0) order by F.Sticky,F.Last_Time DESC");
		$sth = mysql_query("select A.Username as Author,U.Username as Last_Username,F.*,DATE_FORMAT(F.Last_Time,'%b %D\, %Y %h:%i %p') as ts 
from 
forums_index as F left join user as A on A.CoreID=F.CoreID left join user as U on U.CoreID=F.Last_CoreID where F.ParentID=".intval($tree)." and (F.ClanID=$PlayerData->ClanID or F.ClanID=0) order by F.Sticky,F.Last_Time DESC");
		print mysql_error();
		while ($data = mysql_fetch_array($sth)) {

			if ($data[ParentID] != 0) {
				print "<TR><TD WIDTH=170 NOWRAP>";
				print "$data[ts]</TD><TD valign=center>";
				if ($data[Locked] == "Y") {
					print "<IMG SRC=./images/padlock.gif>";
				}
				if ($data[Sticky] == "Y") {
					print "<IMG SRC=./images/sticky.gif>";
				}
				if ($data[Importaint] == 1) {
					print "<IMG SRC=./images/importaint.gif>";
				}
				if ($data[Poll] == "Y") {
					print "<IMG SRC=./images/poll.gif>";
				}

				print "<A HREF=forums.php?CoreID=$PlayerData->CoreID&Verify=$Verify&tree=".intval($tree)."&read=$data[ForumID]&Rand=".rand(1,999999).">$data[Topic]</A></TD>";
				print "</TD><TD ALIGN=CENTER>$data[Last_Username]</TD><TD>$data[Author]</td><TD ALIGN=CENTER><B>$data[Total] </B>posts</TD>";
                                if ($PlayerData->Admin == "Y") {
                                      print "<TD>[<A HREF=forums.php?Delete=$data[ForumID]&tree=$tree><font color=red>DELETE</font></A>]</TD></TR>";
				}
			} else {
				print "<TR><TD WIDTH=170 NOWRAP>$data[ts]</TD><TD>[<A HREF=forums.php?CoreID=$PlayerData->CoreID&Verify=$Verify&tree=$data[ForumID]>Read</A> ";
				if ($data[ClanID] > 0) {
					print "<FONT COLOR=RED><b>CLAN FORUM</b></FONT>";
				}
				print "] $data[Topic]</TD><TD ALIGN=CENTER>$data[Last_Username]</TD><TD ALIGN=CENTER><B>$data[Total] </B>posts</TD></TR>";
			}
		}
		if (intval($tree) != 0) {
			print "<TR><TD ALIGN=CENTER COLSPAN=5><A HREF=forums.php?CoreID=$PlayerData->CoreID&Verify=$Verify&tree=0>Return to main</A></TD></TR>";
		} else {
			if ($PlayerData->ClanData->Founder == $PlayerData->CoreID) {
				print "<TR><FORM ACTION=$SCRIPT_NAME METHOD=POST><TD ALIGN=RIGHT COLSPAN=5><INPUT TYPE=TEXT SIZE=20 MAXLENGTH=20 NAME=NewParent><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Create></TD></FORM></TR>";
			}
		}
		print "<TR><TD COLSPAN=5 class=Footer>End of Topic Listings</TD></TR>";
		print "</TABLE><P>";
		if (intval($tree) != 0) {
			print "<FORM ACTION=forums.php METHOD=POST><INPUT TYPE=HIDDEN NAME=CoreID VALUE=$PlayerData->CoreID><INPUT TYPE=HIDDEN NAME=Verify VALUE=$Verify>";
			print "<FONT SIZE=-1><B>Create a New Thread</B></FONT><BR>";
			print "<INPUT TYPE=HIDDEN NAME=newpost VALUE=".intval($tree)."><INPUT TYPE=HIDDEN NAME=tree VALUE=".intval($tree).">";
			print "<FONT SIZE=-1><B>Subject: </B></FONT><INPUT TYPE=TEXT NAME=subject><BR>";

//			$sw = new SPAW_Wysiwyg('spaw4' /*name*/,stripslashes($HTTP_POST_VARS['post']) /*value*/,'en' /*language*/, 'deltoria' /*toolbar mode*/, '' /*theme*/,500px' /*width*/, '150px' /*height*/);
//			$sw->show();

//			$sw = new SPAW_Wysiwyg('post' /*name*/,stripslashes($HTTP_POST_VARS['post']) /*value*/,'en' /*language*/, 'deltoria' /*toolbar mode*/, '' /*theme*/,'500px' /*width*/, '150px' /*height*/);
//			$sw->show();


			print "<TEXTAREA WRAP=HARD COLS=60 ROWS=5 NAME=post>";	
	                // if ($PlayerData->Footer != "") {
	                //         print "\n\n--------------------------\n$PlayerData->Footer";
	                // }
			print "</TEXTAREA><BR>";

//                        print "<textarea name=Body COLS=60 ROWS=5>";
//                        print "</textarea>";

			print "If this post is a poll please enter the poll options below<BR>";
			print "<Table border=0 class=box1>";
			print "<tr><td class=Menu>Option 1</td><td class=Menu>Option 2</td><td class=Menu>Option 3</td><Td class=Menu>Option 4</td><td class=Menu>Option 5</td></tr>";
			print "<tr>";
			print "<td><input type=text size=15 name=Poll_00></td>";
			print "<td><input type=text size=15 name=Poll_01></td>";
			print "<td><input type=text size=15 name=Poll_02></td>";
			print "<td><input type=text size=15 name=Poll_03></td>";
			print "<td><input type=text size=15 name=Poll_04></td>";
			print "</tr>";
			print "<tr><td class=Menu>Option 6</td><td class=Menu>Option 7</td><td class=Menu>Option 8</td><Td class=Menu>Option 9</td><td class=Menu>Option 10</td></tr>";
			print "<tr>";
			print "<td><input type=text size=15 name=Poll_05></td>";
			print "<td><input type=text size=15 name=Poll_06></td>";
			print "<td><input type=text size=15 name=Poll_07></td>";
			print "<td><input type=text size=15 name=Poll_08></td>";
			print "<td><input type=text size=15 name=Poll_09></td>";
			print "</tr>";
			print "</table>";
			print "<BR>";
			print "<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=\"Submit Post\"><P>";
			print "</FORM>";
		}
	}

        include ("./system/bottom.php");



	function Post2Forum($Text) {
		$Text = ereg_replace("  ","&nbsp;&nbsp;",$Text);
		$Text = ereg_replace(">","&gt;",$Text);
		$Text = ereg_replace("<","&lt;",$Text);

		$Text = ereg_replace("\%color=red%","<FONT COLOR=RED>",$Text);
		$Text = ereg_replace("\%/color%","</FONT>",$Text);
		$Text = ereg_replace("\%color=green%","<FONT COLOR=GREEN>",$Text);
		$Text = ereg_replace("\%color=blue%","<FONT COLOR=BLUE>",$Text);
		$Text = ereg_replace("\%b%","<B>",$Text);
		$Text = ereg_replace("\%/b%","</B>",$Text);
		$Text = ereg_replace("\%i%","<I>",$Text);
		$Text = ereg_replace("\%/i%","</I>",$Text);
		$Text = ereg_replace("\%u%","<U>",$Text);
		$Text = ereg_replace("\%/u%","</U>",$Text);

		$Text = ereg_replace("\n","<BR>",$Text);
		$Text = ereg_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$Text);
		return $Text;
	}

	function Forum2Post($Text) {
		$Text = ereg_replace("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","\t",$Text);
		$Text = ereg_replace("&nbsp;&nbsp;","  ",$Text);

		$Text = ereg_replace("<FONT COLOR=RED>","%color=red%",$Text);
		$Text = ereg_replace("</FONT>","%/color%",$Text);
		$Text = ereg_replace("<FONT COLOR=GREEN>","%color=green%",$Text);
		$Text = ereg_replace("<FONT COLOR=BLUE>","%color=blue%",$Text);
		$Text = ereg_replace("<B>","%b%",$Text);
		$Text = ereg_replace("</B>","%/b%",$Text);
		$Text = ereg_replace("<I>","%i%",$Text);
		$Text = ereg_replace("</I>","%/i%",$Text);
		$Text = ereg_replace("<U>","%u%",$Text);
		$Text = ereg_replace("</U>","%/u%",$Text);

		$Text = ereg_replace("<BR>","\n",$Text);
		$Text = ereg_replace("<P>","\n\n",$Text);

		$Text = ereg_replace("&gt;",">",$Text);
		$Text = ereg_replace("&lt;","<",$Text);

		return $Text;
	}

?>
