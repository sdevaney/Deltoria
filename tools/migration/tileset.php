#!/usr/bin/php -q
<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
$db = mysql_connect("localhost","dbuser","dbpass");
mysql_select_db("dbname");

$sql = "
	select

		m.RowID,
		m.TileID as m_TileID,
		o.TileID as o_TileID

	from 

		map as m

	left join overlay as o on o.x=m.x and o.y=m.y and o.mapid=m.mapid

	where m.TileID is not NULL
";

$sth = mysql_query($sql);

while ($data = mysql_fetch_assoc($sth)) {
	if ($data['o_TileID'] > 0) {
		$sql = "select * from tiledata where Image='n_".$data['m_TileID']."_".$data['o_TileID'].".jpg' limit 1";
	} else {
		$sql = "select * from tiledata where Image='n_".$data['m_TileID'].".jpg' limit 1";
	}
	$sthi = mysql_query($sql);
	if (mysql_num_rows($sthi) == 0) {
		print "Unable to load tile information for 'n_".$data['m_TileID']."_".$data['o_TileID'].".jpg'\n";
		sleep(5);
	} else {
		$tdata = mysql_fetch_array($sthi);
		$sql = "update map set TileID=".$tdata['TileID']." where RowID=".$data['RowID'];
		mysql_query($sql);
		print $sql."\n";
	}
}

?>