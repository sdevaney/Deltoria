<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// In game mail system
global $db,$PlayerData;
include ("./system/top.php");
include ("./system/move.php");
// You can put mails in different folders
if ($Folder == "") { $Folder = 0; }
// Create new folder
if ($NewFolder != "") {
	$sth = mysql_query("insert into mail_folder (CoreID,Name) values ($PlayerData->CoreID,'$NewFolder')");
	print mysql_error();
}
// Delete folder
if ($DelFolder != "" && $Auth != "Y") {
	print "Are you sure? All mail in this folder will be deleted too <A HREF=$SCRIPT_NAME?DelFolder=$DelFolder&Auth=Y>Yes</A>";
} elseif ($DelFolder != "" && $Auth == "Y") {
	print "Deleted..<BR>";
	$sth = mysql_query("delete from mail_folder where CoreID=$PlayerData->CoreID and FolderID=$DelFolder");
	$sth = mysql_query("delete from mail where CoreID=$PlayerData->CoreID and FolderID=$DelFolder");
}

$sth = mysql_query("select * from mail_folder where CoreID=$PlayerData->CoreID");

print "<table border=0 class=pagecontainer>";
print "<tr><td valign=top width=200 class=pagecell>";
print "<TABLE CLASS=Box2 width=100%>";

$sth_get = mysql_query("select count(MailID) from mail where CoreID=$PlayerData->CoreID and Status='Unread' and Deleted='N' and FolderID=0");
list($NumFound) = mysql_fetch_row($sth_get);

$sth_get = mysql_query("select count(MailID) from mail where CoreID=$PlayerData->CoreID and Deleted='N' and FolderID=0");
list($NumTotal) = mysql_fetch_row($sth_get);

if ($Folder == 0) {
	print "<TR><TD CLASS=Menu><A HREF=$SCRIPT_NAME?Folder=0>Inbox</A> ($NumFound / $NumTotal)</TD></TR>";
} else {
	print "<TR><TD><A HREF=$SCRIPT_NAME?Folder=0>Inbox</A> ($NumFound / $NumTotal)</TD></TR>";
}
while ($FData = mysql_fetch_array($sth)) {
	$sth_get = mysql_query("select count(MailID) from mail where CoreID=$PlayerData->CoreID and Status='Unread' and Deleted='N' and FolderID=$FData[FolderID]");
	list($NumFound) = mysql_fetch_row($sth_get);

	$sth_get = mysql_query("select count(MailID) from mail where CoreID=$PlayerData->CoreID and Deleted='N' and FolderID=$FData[FolderID]");
	list($NumTotal) = mysql_fetch_row($sth_get);

	if ($Folder == $FData[FolderID]) {
		print "<TR><TD class=menu>[<A HREF=$SCRIPT_NAME?DelFolder=$FData[FolderID]>Del</A>] <A HREF=$SCRIPT_NAME?Folder=$FData[FolderID]>$FData[Name]</A> ($NumFound / $NumTotal)</TD></TR>";
	} else {
		print "<TR><TD><A HREF=$SCRIPT_NAME?Folder=$FData[FolderID]>$FData[Name]</A> ($NumFound / $NumTotal)</TD></TR>";
	}
}

print "<tr>";
print "<FORM ACTION=$SCRIPT_NAME METHOD=POST><TD>";
print "<INPUT TYPE=HIDDEN NAME=Folder VALUE=$Folder>";
print "<INPUT TYPE=HIDDEN NAME=Read VALUE=$Read>";
print "<INPUT TYPE=TEXT SIZE=25 MAXLENGTH=25 NAME=NewFolder><BR>";
print "<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=\"New Folder\">";
print "</TD></FORM>";
print "</tr>";

print "</TABLE>";
print "</td><td width=493 class=pagecell>";

if ($Read > 0) {
	$sth = mysql_query("select * from mail where CoreID=$PlayerData->CoreID and FolderID=$Folder and MailID=$Read and CoreID=$PlayerData->CoreID");
	if (mysql_num_rows($sth) > 0) {
		$MData = mysql_fetch_array($sth);

		print "<table class=box2 width=100% height=100%>";
		print "<tr><td height=1 class=Header COLSPAN=4>Reading Message</td></tr>";
		print "<TR><TD CLASS=Menu>From</TD><TD CLASS=MENU>Date Sent</TD><TD CLASS=Menu>Subject</TD></TR>";
		print "<TR><TD NOWRAP><B>$MData[From_Username]</B></TD><TD NOWRAP>$MData[Time]</TD><TD width=100%>$MData[Subject]</TD></TR>";
		if (strtoupper($MData[ToString]) != strtoupper($PlayerData->Username)) { print "<TR><TD NOWRAP CLASS=MENU>To:</TD><TD COLSPAN=3>$MData[ToString]</TD></TR>"; }
		print "<tr><Td colspan=4 class=header>Message Body</td></tr>";
		print "<TR><TD COLSPAN=4>";
		$MData[Body] = smilies($MData[Body]);
		print str_replace("\n","<BR>",$MData[Body]);
		print "</TD></TR>";
		print "<TR><FORM ACTION=$SCRIPT_NAME METHOD=POST><TD COLSPAN=2 CLASS=Footer>";
			if ($Read > 0) { print "<INPUT TYPE=HIDDEN NAME=Read VALUE=$Read>"; }
			print "<INPUT TYPE=HIDDEN NAME=Folder VALUE=$Folder>";
			print "<INPUT TYPE=HIDDEN NAME=Sel_$MData[MailID] VALUE=on>";
			print "<select name=Action>";
			$sth = mysql_query("select * from mail_folder where CoreID=$PlayerData->CoreID and FolderID != $Folder");
			print mysql_error();
			print "<OPTION VALUE=0>Move to Inbox";
			while ($FData = mysql_fetch_array($sth)) {
				print "<OPTION VALUE=$FData[FolderID]>Move to $FData[Name]";
			}
			print "</select>";
			print "<input type=submit name=submit value=Move>";
		print "</TD></FORM><TD COLSPAN=2 CLASS=FOOTER>";
		print "<A HREF=$SCRIPT_NAME?Folder=$Folder&Reply=$MData[MailID]><IMG BORDER=0 SRC=./images/buttons/button_reply.jpg></A>";
		print "<A HREF=$SCRIPT_NAME?Folder=$Folder&ReplyAll=$MData[MailID]><IMG BORDER=0 SRC=./images/buttons/button_reply_all.jpg></A>";
		print "<A HREF=$SCRIPT_NAME?Folder=$Folder&Action=Delete&Sel_$MData[MailID]=on><IMG BORDER=0 SRC=./images/buttons/button_delete.jpg></A>";
		print "</TD></TR>";
		print "</TABLE><P>";
		$sth = mysql_query("update mail set Status='Read' where MailID=$MData[MailID]");
	}
}
// Send your in game mail
if ($MailTo != "") {
	$RawMailTo = $MailTo;

	array ($SentUsers);
	array ($ToUsers);
	$ToUsers = split(",",$MailTo);
	while (list($key,$value) = each($ToUsers)) {
		$value = preg_replace("/^\s+/","",$value);
		$value = preg_replace("/\s+$/","",$value);
		$MailTo = strtoupper($value);
		// Type CLAN in the to field to send a mail to your whole clan
		if ($SentUsers[$MailTo] != "Y") {
			if ($MailTo == "CLAN") {
				$sth = mysql_query("select CoreID,Username from user where ClanID = ".($PlayerData->ClanID)." and ClanID > 0");
			}elseif ($MailTo == "ADMIN" && $PlayerData->Admin == 'Y') {
				$sth = mysql_query("select CoreID,Username from user where Admin='Y'");
			} else {
				$sth = mysql_query("select CoreID,Username from user where Username='$MailTo'");
			}
			if (mysql_num_rows($sth) == 0) {
				print "<B>Warning:</B> Unable to locate that user.<P>";
			} else {
				while (list ($To_CoreID,$To_Username) = mysql_fetch_row($sth)) {
					print "Message delivered to $To_Username<BR>";
// If user blocked user doesnt recive mail
					$BlockSTH = mysql_query("select * from user_block where CoreID='".$To_CoreID."' and BlockID='".$PlayerData->CoreID."'");
					if (mysql_num_rows($BlockSTH) == 0) {
						$sth_send = mysql_query("insert into mail (ToString,CoreID,Time,From_CoreID,From_Username,Subject,Body) values ('$RawMailTo',$To_CoreID,NOW(),$PlayerData->CoreID,'$PlayerData->Username','$Subject','$Body')");
						print mysql_error();
					}
				}
			}
			$SentUsers[$MailTo] = "Y";
		}
	}
}



print "<table class=box2 width=100% height=100%>";
print "<FORM ACTION=$SCRIPT_NAME METHOD=POST>";
if ($Read > 0) { print "<INPUT TYPE=HIDDEN NAME=Read VALUE=$Read>"; }
print "<INPUT TYPE=HIDDEN NAME=Folder VALUE=$Folder>";
// Select reply or reply all
if ($Reply > 0) {
	$sth = mysql_query("select * from mail where CoreID=$PlayerData->CoreID and MailID=$Reply");
	$MData = mysql_fetch_array($sth);
} elseif ($ReplyAll > 0) {
	$sth = mysql_query("select * from mail where CoreID=$PlayerData->CoreID and MailID=$ReplyAll");
	$MData = mysql_fetch_array($sth);
}

print "<tr><td height=1 class=Header COLSPAN=4>Post Message</td></tr>";
print "<tr>";
print "<td>Message To:</TD><TD><INPUT Name=MailTo TYPE=TEXT SIZE=15 MAXLENGTH=25";
if ($ReplyAll > 0) { print " VALUE=\"".str_replace(strtolower($PlayerData->Username),"",strtolower($MData[From_Username])).",".str_replace(strtolower($PlayerData->Username),"",strtolower($MData[ToString]))."\""; }
if ($Reply > 0) { print " VALUE=\"$MData[From_Username]\""; }
print "></td>";
print "<td>Subject:</TD><TD><INPUT NAME=Subject TYPE=TEXT SIZE=40 MAXLENGTH=80 ";
if ($Reply > 0 || $ReplyAll > 0) {
	if (!ereg("Re:",$MData[Subject])) {
		$MData[Subject] = "Re: $MData[Subject]";
	}
	print "VALUE=\"$MData[Subject]\"";
}
print "></td>";
print "</tr>";
print "<tr><td colspan=4><textarea name=Body COLS=63 ROWS=5>";
if ($Reply > 0 || $ReplyAll > 0) {
	print "\n\nOn $MData[Time] $MData[From_Username] sent the following:\n-=================-\n";
	print $MData[Body];
}
print "</textarea></td></tr>";
print "<tr><td colspan=4 class=footer><input type=submit name=submit value=Submit></td></tr>";
print "</FORM>";
print "</table><p>";


print "<table class=box2 width=100% height=100%>";
print "<FORM ACTION=$SCRIPT_NAME METHOD=POST>";
if ($Read > 0) { print "<INPUT TYPE=HIDDEN NAME=Read VALUE=$Read>"; }
print "<INPUT TYPE=HIDDEN NAME=Folder VALUE=$Folder>";

print "<tr><td height=1 class=Header COLSPAN=5>Listed Messages</td></tr>";
print "<TR><TD COLSPAN=2 CLASS=MENU>&nbsp</TD><TD CLASS=Menu>From</TD><TD CLASS=MENU>Date</TD><TD CLASS=MENU>Subject</TD></TR>";
$sth = mysql_query("select DATE_FORMAT(Time,'%b %D %h:%i %p') as ts,mail.* from mail where CoreID=$PlayerData->CoreID and FolderID=$Folder order by Time DESC");
print mysql_error();
while ($MData = mysql_fetch_array($sth)) {
	$SelCheck = "Sel_$MData[MailID]";
	if ($$SelCheck != "" && $Action == "Delete") {
		$sth_del = mysql_query("delete from mail where MailID=$MData[MailID]");
	} elseif ($$SelCheck != "" && intval($Action) > 0 || $Action == "0") {
		$sth_del = mysql_query("update mail set FolderID=$Action where MailID=$MData[MailID]");
		print mysql_error();
	} else {
		print "<TR>";
		print "<TD><INPUT TYPE=CHECKBOX NAME=Sel_$MData[MailID]></TD>";
		if ($MData[Status] == "Unread") {
			print "<TD WIDTH=5><B>*</B></TD>";
		} else {
			print "<TD WIDTH=5>&nbsp;</TD>";
		}
		print "<TD NOWRAP><A HREF=$SCRIPT_NAME?Folder=$Folder&Read=$MData[MailID]>$MData[From_Username]</A></TD><TD NOWRAP>$MData[ts]</TD><TD width=100%>$MData[Subject]</TD></TR>";
	}
}
print "<tr><td colspan=5 class=footer><select name=Action>";
print "<option value=Delete>Delete";
$sth = mysql_query("select * from mail_folder where CoreID=$PlayerData->CoreID and FolderID != $Folder");
print mysql_error();
print "<OPTION VALUE=0>Move to Inbox";
while ($FData = mysql_fetch_array($sth)) {
	print "<OPTION VALUE=$FData[FolderID]>Move to $FData[Name]";
}
print "</select>";
print "<input type=submit name=submit value=Execute>";
print "</td></tr>";
print "</FORM>";
print "</table>";



print "</td></tr>";
print "</table>";

include ("./system/bottom.php");
exit;
?>