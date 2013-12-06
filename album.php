<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Allows users to upload pictures to an album
global $db,$CoreUserData;
include ("./system/top.php");


print "<table border=0 class=pageContainer>";
print "<tr><td class=pageCell valign=top>";

include ("./system/chatter.php");

if ($_GET['delete'] > 0) mysql_query("delete from album where pic_id='".$_GET['delete']."'");

if ($_GET['core_id'] == "") $_GET['core_id'] == $PlayerData->CoreID;

if ($userfile != "") {
	$pictype = strtoupper(substr($userfile_name,strlen($userfile_name)-3,3));
	if ($pictype == "GIF" || $pictype == "PNG" || $pictype == "JPG" || $pictype == "BMP" || $pictype == "JPEG") {
		print "<img src=\"$userfile\"></img>";
		$sth = mysql_query("insert into album (core_id,title,uploaded) values ($PlayerData->CoreID,'".$_POST['title']."',NOW())");
		$picid = mysql_insert_id($db);
		$cmd = "convert $userfile -flatten ./images/album/full/$picid.jpg";
		exec($cmd);
		$cmd = "convert $userfile -flatten -resize 100x100 ./images/album/thumb/$picid.jpg";
		exec($cmd);
	}
}
print "<FONT SIZE=4>Latest Uploaded Photos</FONT><BR>";
print "<TABLE><TR>";
$sth = mysql_query("select u.Username,a.pic_id,a.core_id,a.title from album as a left join user as u on u.CoreID=a.core_id order by a.uploaded DESC limit 10");
if (mysql_num_rows($sth) == 0) {
	print "<TD STYLE='border: 0px;'>No photos</TD>";
}
while ($data = mysql_fetch_array($sth)) {
	print "<TD STYLE='border: 0px;'>";
	print "<A HREF=album.php?core_id=".$data['core_id'].">";
	print "<IMG BORDER=0 SRC=\"./images/album/thumb/".$data['pic_id'].".jpg\"><BR>";
	print $data['Username'];
	print "</A>";
	print "</TD>";
}
print "</TR></TABLE><P>";

print "<B>Select a users album to view:</B><FORM STYLE='MARGIN: 0px;' ACTION=album.php METHOD=GET><SELECT NAME=core_id>";
$sth = mysql_query("select distinct u.Username,a.core_id from album as a left join user as u on u.CoreID=a.core_id order by u.Username");
while ($data = mysql_fetch_array($sth)) {
	print "<OPTION ";
	if ($data['core_id'] == $_GET['core_id']) print "SELECTED";
	print " VALUE=$data[core_id]>$data[Username]</OPTION>";
}
print "</SELECT><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=View><P>";
print "</FORM>";

print "<FONT SIZE=4>Viewing Album</FONT><BR>";
print "<TABLE><TR>";
$sth = mysql_query("select u.Username,a.pic_id,a.core_id,a.title from album as a left join user as u on u.CoreID=a.core_id where a.core_id='".$_GET['core_id']."' order by a.uploaded DESC");
if (mysql_num_rows($sth) == 0) {
	print "<TD STYLE='border: 0px;'>No photos</TD>";
}
while ($data = mysql_fetch_array($sth)) {
	print "<TD STYLE='border: 0px;'>";
	print "<A TARGET=_NEW HREF=./images/album/full/".$data['pic_id'].".jpg>";
	print "<IMG BORDER=0 SRC=\"./images/album/thumb/".$data['pic_id'].".jpg\"><BR>";
	print $data['Username'];
	print "</A>";
	if ($data['core_id'] == $PlayerData->CoreID || $PlayerData->Admin == 'Y') print " (<A HREF='album.php?delete=".$data['pic_id']."'>delete</A>)";
	print "</TD>";
}
print "</TR></TABLE><P>";

print "<FONT SIZE=4>Upload a Photo</FONT><BR>";

print "<FORM ENCTYPE=\"multipart/form-data\" ACTION=\"$SCRIPT_NAME\" METHOD=POST>";
print "<TABLE STYLE='border: 0px;'>";
print "<INPUT TYPE=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"2000000\">";
print "<TR><TD STYLE='border: 0px;'><B>Title:</B></TD><TD STYLE='border: 0px;'><input type=text size=25 style='width: 100%;' name=title></TD></TR>";
print "<TR><TD STYLE='border: 0px;'><B>Filename:</B></TD><TD STYLE='border: 0px;'><INPUT NAME=\"userfile\" TYPE=\"file\" SIZE=25></TD></TR>";
print "<TR><TD STYLE='border: 0px;' COLSPAN=2 ALIGN=RIGHT><INPUT TYPE=\"submit\" VALUE=\"Send File\"></TD></TR>";
print "</TABLE>";
print "</FORM>";





print "</td></tr>";
print "</table>";

include ("./system/bottom.php");


?>