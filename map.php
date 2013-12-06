<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Not used now
	########################
	## Make us our connection
	global $db;
	include ("./system/top.php");
	include ("./system/move.php");



#test

#
# Not very efficient - hard coded till some time in the
# future when map info will be moved into database. Till
# then, this is easy.
#
        if ($PlayerData->MapID == 8)
        {
 	 $MapImage = "./images/maps/mainland.jpg";
	 $MapScale = 2;
        }

        if ($PlayerData->MapID == 1)
        {
	 $MapImage = "./images/maps/island_of_man.jpg";
	 $MapScale = 4;
        }
	
	$MapOffsetX = 5;
        $MapOffsetY = 78;

	$PPOffsetX = 3;
        $PPOffsetY = 23;

#
# Only allow user to see 2 maps other wise display error.
#
	if ($PlayerData->MapID != 1 && $PlayerData->MapID != 8)
		print "You have not found the map for this area of the world!<br>";
	else
	{

	print "<A HREF=$PHP_SELF>";
	print "<IMG SRC=$MapImage border=0 style=position:absolute;top:".$MapOffsetY.";left:".$MapOffsetX."; ISMAP>";
	print "</A>";

	$sth = mysql_query("select min(x),min(y),max(x),max(y) from map where MapID=$PlayerData->MapID");
	list($MinX,$MinY,$MaxX,$MaxY) = mysql_fetch_row($sth);


#
# insert pin coord's and description into database.
#
if ($AreaDesc != "") {
	$sth = mysql_query("insert into user_pin (CoreID,X,Y,MapID,Description) values ($PlayerData->CoreID,$x,$y,$mapid,'$AreaDesc')");
	print mysql_error();
}


#
# If user is trying to place a pin, calculate actual coordinates.
# 
#  
#
if ( $_SERVER["QUERY_STRING"] != "" )
{

	#
        # Remove pin if user specified pin to delete
        #
	if(isset($delpin))
	{
		mysql_query("delete from user_pin where pinid=$delpin and coreid=$PlayerData->CoreID");
		print mysql_error();
	}
	elseif(!isset($RD))
	{

	list($pixel_X, $pixel_Y) = split(",", $_SERVER["QUERY_STRING"]);

        $ppX = $MinX+floor(($pixel_X+$PPOffsetX)/$MapScale);
        $ppY = $MinY+floor(($pixel_Y+$PPOffsetY)/$MapScale);

	print "<img src=maptest/lyellow.gif width=31 height=38 border=0 style=position:absolute;top:".($pixel_Y+$MapOffsetY-$PPOffsetY)."px;left:".($pixel_X+$MapOffsetX-$PPOffsetX)."px;z-index:999;>";

	print "<div style=\"filter:alpha(opacity=85);-moz-opacity:.7;z-index:995;position:absolute;top:".($pixel_Y+$MapOffsetY+17)."px;left:".($pixel_X+$MapOffsetX-2-3)."px;width:300px;padding:5px;border:1px solid #444444;background-color:#f9f9f9\">";

	print "<table cellpadding=0 border=0 cellspacing=0 style=\"width: 100%; border: 1px solid #bbbbbb;\"><tr><td style=\"padding: 5px 0px 5px 5px;\">";

	print "<b>Mark Location $ppX, $ppY.</b>";

print "<form action=$_SERVER[PHP_SELF] method=post>";
print "<input type=hidden name=mapid value=$PlayerData->MapID>";
print "<input type=hidden name=x value=$ppX>";
print "<input type=hidden name=y value=$ppY>";

print "Enter Location Notes<br>";
print "<textarea name=AreaDesc rows=3 cols=40></textarea><br>";
print "<input type=button value=Cancel onclick=\"location.href='$_SERVER[PHP_SELF]';\">";
print "<input type=submit value=\"Stick The Pin\"> ";

print "</form>";

print "</td></tr></table>";



	print "</div>";



	}
}



#
# Calculate character position and write image
#
#
	$pixel_X = (($PlayerData->X-$MinX)*$MapScale)+$MapOffsetX-15;
        $pixel_Y = (($PlayerData->Y-$MinY)*$MapScale)+$MapOffsetY-15; 

        print "<IMG SRC=./images/chars/$PlayerData->UserPic STYLE=position:absolute;top:".$pixel_Y."px;left:".$pixel_X."px onmouseover=\"ShowInfo('$PlayerData->Username','That is you dummie!')\" onmouseout=\"HideInfo()\">";

#
# Load pushpins from the database, calculate pixel positions, and 
# write image.
#
        $sth = mysql_query("select pinid, x, y, description from user_pin where coreid=$PlayerData->CoreID and mapid=$PlayerData->MapID;");
	while ( list($pid, $ppX, $ppY, $ppDesc) = mysql_fetch_row($sth) )
        {
		$pixel_X = ((($ppX-$MinX)*$MapScale)-($PPOffsetX*2))+$MapOffsetX;
		$pixel_Y = ((($ppY-$MinY)*$MapScale)-($PPOffsetY*2))+$MapOffsetY;

		if ( $pixel_X > 0 && $pixel_Y > 0 )
		{
                        print "<a href=$_SERVER[PHP_SELF]?delpin=$pid&RD=".rand(10000,1000000).">";
			print "<img src=./images/lred.gif width=31 height=38 border=0 style=cursor:no-drop;position:absolute;top:".$pixel_Y."px;left:".$pixel_X."px;z-index:".(299+$pid)."; onmouseover=\"ShowInfo('Marked Location $ppX, $ppY','$ppDesc')\" onmouseout=\"HideInfo()\">";
			print "</a>";
	        }    
	}


 	}


	include ("./system/bottom.php");


?>