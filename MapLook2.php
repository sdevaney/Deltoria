<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Allows admins to see whole map areas, takes a lot of bandwidth and cpu power
	$db = mysql_connect("localhost","db_user","db_pass");
	mysql_select_db("db_name");
// Set mapid, tile size, and viewport size all in the url by adding the following to the end of the url
#
# &mapid=#
#
        $MapID = $_REQUEST["mapid"];
	if( !is_numeric($MapID) )
	{
		$MapID = 8;
	}
#
# &tilesize=#
#
        $TileSize = $_REQUEST["tilesize"];
	if ( !is_numeric($TileSize) || $TileSize < 1 )
	{
		$TileSize = 12;
	}

#
# &viewport=###,###,###,###   ( MinX,MinY,MaxX,MaxY )
# 

	list($vpMinX, $vpMinY, $vpMaxX, $vpMaxY) = split(",", $_REQUEST["viewport"]);


#
# Get the Min and Max coordinates for the current map.
#
	$sth = mysql_query("select Min(X), Min(Y), Max(X), Max(Y) from map where MapID=$MapID");
	list($MinX, $MinY, $MaxX, $MaxY) = mysql_fetch_row($sth);

#
# Get MapName and the default background image for the map
#
	$sth = mysql_query("select Name, Image from mapid_background where MapID=$MapID", $db);
	print mysql_error();
	list($MapName, $DefaultTile) = mysql_fetch_row($sth);


#
# Debug Info
#
if (1==0)
{
print "MapID       : $MapID<br>";
print "TileSize    : $TileSize<br>";
print "MinX        : $vpMinX ~ $MinX<br>";
print "MinY        : $vpMinY ~ $MinY<br>";
print "MaxX        : $vpMaxX ~ $MaxX<br>";
print "MaxY        : $vpMaxY ~ $MaxY<br>";
print "MapName     : $MapName<br>";
print "DefaultTile : $DefaultTile<br>";
}




#
# use viewport coordinates if they are correct.
#
	if ( ( is_numeric($vpMinX) && $vpMinX < $vpMaxX && $vpMinX >= $MinX && $vpMinX <= $MaxX )
             && ( is_numeric($vpMinY) && $vpMinY < $vpMaxY && $vpMinY >= $MinY && $vpMinY <= $MaxY )
	     && ( is_numeric($vpMaxX) && $vpMaxX > $vpMinX && $vpMaxX >= $MinX && $vpMaxX <= $MaxX )
	     && ( is_numeric($vpMaxY) && $vpMaxY > $vpMinY && $vpMaxY >= $MinY && $vpMaxY <= $MaxX )
	   )
	{
		$MinX = $vpMinX;
		$MinY = $vpMinY;
		$MaxX = $vpMaxX;
		$MaxY = $vpMaxY;
	}
	elseif ( isset($_REQUEST["viewport"]) )
	{
		print "Invalid viewport coordinates.<br>MapSize : $MinX, $MinY, $MaxX, $MaxY<br>";
		exit;
	}


?>
<HTML>
<HEAD>
<TITLE>YOUR_GAME: <?=$MapName;?></TITLE>
</HEAD>
<BODY>
<?
#
# Allow script to run for 10 minutes
#
	set_time_limit(600);

	$TileBase = "/images/tiles/";

	print "<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0>";
	for ($Y = $MinY; $Y <= $MaxY; $Y++) 
        {
		print "<TR>";
		for ($X = $MinX; $X <= $MaxX; $X++) 
		{
			$sth = mysql_query("select T.Image from map as m left join tiledata as T on T.TileID=m.TileID where m.X=$X and m.Y=$Y and MapID=$MapID");
			print mysql_error();
			if (mysql_num_rows($sth) == 0)
			{
				print "<TD WIDTH=$TileSize HEIGHT=$TileSize><IMG WIDTH=$TileSize HEIGHT=$TileSize SRC=$TileBase$DefaultTile></TD>";
			}
			else 
			{
				list ($TileImage) = mysql_fetch_row($sth);
				$TileImage = $TileBase.$TileImage;

				$sth = mysql_query("select T.Image from overlay as m left join tiledata as T on T.TileID=m.TileID where m.X=$X and m.Y=$Y and MapID=$MapID");
				if (mysql_num_rows($sth) == 0)
				{
		$OverlayImage = "/images/tiles/";
					list ($OverlayImage) = mysql_fetch_row($sth);
					$OverlayImage = $TileBase.$OverlayImage;
				}	
				print "<TD WIDTH=$TileSize HEIGHT=$TileSize BACKGROUND=$TileImage><IMG WIDTH=$TileSize HEIGHT=$TileSize SRC=$OverlayImage></TD>";
			}
		}
		print "</TD>";
	}
	print "</TABLE>";
?>
</BODY>
</HTML>