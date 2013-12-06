<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Chat screen
global $SCRIPT_NAME,$PlayerData;
if ($_GET[Chatter] != "") { $Chatter = $_GET[Chatter]; }
if ($_POST[Chatter] != "") { $Chatter = $_POST[Chatter]; }
if ($ChatType != "") {
	if ($ChatType == "clan" && $PlayerData->ClanID == 0) { 
		$ChatType = "public";
	}
	if ($ChatType == "clan" || $ChatType == "public") {
		$PlayerData->AdjustValue("ChatType",$ChatType);
	}
}
// PM function type /tell username, message. or use the bubble
function myfunction(){
	echo("/tell $Username,");
}

$MaxLines = $PlayerData->ChatRows;

$sth = mysql_query("select sec_id from user_security where CoreID=$PlayerData->CoreID and Page='chat.php' limit 1");
if (mysql_num_rows($sth) > 0) 
{
	$MaxLines = 0;
}


if ($MaxLines > 0) 
  {

// Make chat look nice
  if (strtoupper($Chatter) == "ADMIN:MASTER") 
    {
        $sth = mysql_query("update $Database.user set X=376,Y=311,MapID=1 where CoreID=$PlayerData->CoreID");
        $PlayerData->X = 304;
        $PlayerData->Y = 266;
        $PlayerData->MapID = 1;
    } 
  elseif ($Chatter != "" and strlen($Chatter) <= 255) 
    {
	$Chatter = ereg_replace("<","&lt;",$Chatter);
	$Chatter = addslashes($Chatter);
	$Chatter = ereg_replace(">","&gt;",$Chatter);
	if ($PlayerData->ChatType == "clan") 
          {
		$ClanID = $PlayerData->ClanID;
	  } 
         else 
          {
		$ClanID = 0;
	  }
	if (preg_match("/^\/(?:msg|tell|t|m) (.+?),(.+)/",$Chatter,$Matches) == 1) 
	  {
		$sth = mysql_query("select CoreID from user where Username=\"$Matches[1]\"");
		print mysql_error();
		list ($TargetID) = mysql_fetch_row($sth);
		if ($TargetID == "") 
		  { 
			$TargetID = 0; $Chatter = "";
		  } 
		else 
		  { 
			$Chatter = $Matches[2]; 
		  }
	  } 
	elseif (preg_match("/^\/(?:reply|r) (.+)/",$Chatter,$Matches) == 1) 
	  {
		$sql = "select CoreID from chatter where TargetID=$PlayerData->CoreID order by TS DESC limit 1";
		$sth = mysql_query($sql);
		if (mysql_num_rows($sth) == 0) 
		  { 
			$TargetID == 0; 
		  } 
		else 
		  {
			list($TargetID) = mysql_fetch_row($sth); 
			$Chatter = $Matches[1];
		  }
	  } 
	elseif (preg_match("/^\/(?:send|s) (.+)/",$Chatter,$Matches) == 1) 
	  {
		$TargetID = $PlayerData->LastTell;
		$Chatter = $Matches[1];
	  }
	 elseif (preg_match("/^\/(?:clan|c) (.+)/",$Chatter,$Matches) == 1) 
	  {
		$ClanID = $PlayerData->ClanID;
		$Chatter = $Matches[1];
		$TargetID = 0;
	  }
	 else 
	  {
		$TargetID = 0;
	  }
	if ($Chatter != "") 
	  {
		if ($TargetID != 0) 
		  {
			$sth = mysql_query("update user set LastTell=$TargetID where CoreID=$PlayerData->CoreID");
			$sql = "insert into chatter (TargetID,CoreID,ClanID,Message) values ($TargetID,$PlayerData->CoreID,$ClanID,\"$Chatter\")";
			$sth = mysql_query($sql);
			print mysql_error();
	     	  }
	  }
	if (stristr($SCRIPT_NAME,"clans.php") || stristr($SCRIPT_NAME,"forums.php") || stristr($SCRIPT_NAME,"mail.php") || 		    		     	    stristr($SCRIPT_NAME,"who.php") || stristr($SCRIPT_NAME,"map.php")) 
	  {
		print "<TABLE BORDER=1 WIDTH=100% class=Box1>";
	  } 
	else 
	  {
		print "<TABLE BORDER=1 WIDTH=100% class=Box1>";
	  }
	print "<tr>";
	print "<td class=pageCell colspan=2>";
	print "<table border=0 cellpadding=0 cellspacing=0 width=100%>";
	print "<tr><td class=menu>";
	print "<a href=$SCRIPT_NAME?RD=".rand(1,100000)." class=\"sidelink\">Refresh</A>";
	print "</td>";
	print "<td class=pageCell>";
	print "<A HREF=$SCRIPT_NAME?ChatType=public>";
	if ($PlayerData->ChatType == "public") 
	  { 
		print "<IMG BORDER=0 SRC=./images/chat/public_down.jpg>";
	  }
	else 
	  {
		print "<IMG BORDER=0 SRC=./images/chat/public_up.jpg>";
	  }
	print "</A>";
	print "<A HREF=$SCRIPT_NAME?ChatType=clan>";
	if ($PlayerData->ChatType == "clan") 
	  { 
		print "<IMG BORDER=0 SRC=./images/chat/clan_down.jpg>";
	  }
	else
	  {
		print "<IMG BORDER=0 SRC=./images/chat/clan_up.jpg>";
	  }
	print "</A>";
	print "</td>";
	print "<td colspan=1 class=Header>Place To Talk - Please be Nice!</td>";
	print "</tr>";
	print "</table>";
	print "</td></tr>";
	if ($PlayerData->ChatType == "clan") 
	  {
		$sth = mysql_query("select count(Message) from chatter where (ClanID=$PlayerData->ClanID or TargetID=$PlayerData->CoreID) and 			 		 (TargetID=0 or TargetID=".$PlayerData->CoreID." or CoreID=".$PlayerData->CoreID.")");
		list($ChatCount) = mysql_fetch_row($sth);
		if ($ChatCount < $MaxLines) 
		  { 
			$ChatCount = $MaxLines; 
		  }
		$sql = ("select C.ClanID,C.TargetID,C.CoreID,U.Username,C.Message,DATE_FORMAT(C.TS,'%b %D %h:%i %p') as Date from chatter as C left 			 	 join user as U on U.CoreID=C.CoreID where (C.ClanID=$PlayerData->ClanID or C.TargetID=$PlayerData->CoreID) and 						  (C.TargetID=$PlayerData->CoreID or C.TargetID=0 or C.CoreID=$PlayerData->CoreID) order by C.TS limit ".($ChatCount - 						  $MaxLines).",$MaxLines");
		$sth = mysql_query($sql);
	  } 
	else 
	  {
		$sth = mysql_query("select count(Message) from chatter where (ClanID=0 or ClanID=$PlayerData->ClanID or TargetID=$PlayerData->CoreID) 				  and (TargetID=0 or TargetID=".$PlayerData->CoreID." or CoreID=".$PlayerData->CoreID.")");
		list($ChatCount) = mysql_fetch_row($sth);
		if ($ChatCount < $MaxLines) 
		  { 
			$ChatCount = $MaxLines; 
		  }
		$sql = ("select C.ClanID,C.TargetID,C.CoreID,U.Username,C.Message,DATE_FORMAT(C.TS,'%b %D %h:%i %p') as Date from chatter as C left 				  join user as U on U.CoreID=C.CoreID where (C.ClanID=$PlayerData->ClanID or C.ClanID=0 or C.TargetID=$PlayerData->CoreID) and 					  (C.TargetID=$PlayerData->CoreID or C.TargetID=0 or C.CoreID=$PlayerData->CoreID) order by C.TS limit ".($ChatCount - 						  $MaxLines).",$MaxLines");
		$sth = mysql_query($sql);
		print mysql_error();
		while (list($ChatClanID,$ChatTargetID,$ChatCoreID,$Username,$Message,$Date) = mysql_fetch_row($sth)) 
		  {
			$Message = ereg_replace("\'","'",$Message);
			$Message = wordwrap($Message,25);
			if ($ChatCoreID == 0) 
			  {
				print "<TR><TD VALIGN=TOP COLSPAN=3><B><FONT COLOR=RED>*NEWS*</FONT></B> $Message</TD></TR>";
		  	  }
			else 
			  {
				print "<TR>";
				print "<TD WIDTH=1>";
				Popup_Pic("<IMG SRC=/images/chat/clock.gif> Date of Message",$Date,"/images/chat/clock.gif");
				print "</TD>";
				print "<TD>";
				print "<img="<?php echo("$PHP_SELF?execute=myfunction")?>">/images/chat/whisper.gif </img>";
				print "<p>";
				if ( isset($execute) ){
				myfunction($Username);
				}
				print "</TD>";
				print "	<TD>";
				$Message = str_replace("\\","",$Message);
				$BlockSTH = mysql_query("select * from user_block where CoreID=$PlayerData->CoreID and BlockID=$ChatCoreID");
				if (mysql_num_rows($BlockSTH) > 0) 
				  {

		 		  }
				 else 
				  {
					$Message = smilies($Message);
	                                if ($ChatTargetID != 0) 
					  {
	        	                        if ($ChatTargetID == $PlayerData->CoreID) 
						  { 
							print "[<FONT COLOR=RED>INCOMING PRIV</FONT>] "; 
						  }
	                                        if ($ChatTargetID != $PlayerData->CoreID) 
						  {
	                                	        $usth = mysql_query("select Username from user where CoreID=$ChatTargetID");
							print mysql_error();
                	                                list ($ToUser) = mysql_fetch_row($usth);
                        	                        print "[<FONT COLOR=RED>OUTGOING TO $ToUser</FONT>] ";
                                	          }
                                          }
					if ($ChatClanID != 0 && $PlayerData->ChatType != "clan") 
					  {
						print "[<FONT COLOR=BLUE>CLAN</FONT>] ";
					  }
					if (stristr($Message,"/me")) 
					  {
						$Message = ereg_replace("/me","",$Message);
						print "<B>*$Username</B> $Message";
					  }
					else
					  {
						print "<B>$Username</B> :: $Message";
					  }
			 	  }
				print "</TD>\n";
				print "</TR>\n";
			    }
		  }
		print "<TR>\n";
		print "	<TD CLASS=Menu COLSPAN=2>";
		print "Send Message";
		print "</TD>\n";
		print "</TR>\n";
		print "<TR>\n";
		print " <FORM ACTION=$SCRIPT_NAME>";
		print "	<TD COLSPAN=3 VALIGN=TOP class=pageCell>";
		print "<INPUT CLASS=formfield TYPE=TEXT SIZE=70 MAXLENGTH=240 NAME=Chatter><INPUT TYPE=SUBMIT CLASS=formfield NAME=SUBMIT 			  		  VALUE=Chat>";
		print "</TD>\n";
		print "</FORM>";
		print "</TR>\n";
		print "</TABLE><P>";
	  }
  }
}
?>