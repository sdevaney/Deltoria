#!/usr/bin/php -q
<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
$db = mysql_connect("localhost","dbuser","dbpass");
mysql_select_db("dbname");

mysql_query("alter table tiledata change Image Image varchar(100) not null");
mysql_query("alter table tiledata change Name Name varchar(60) not null");

$sql = "
	select

		DISTINCT

		m.TileID as m_TileID,
		o.TileID as o_TileID,

		tdm.Name as tdm_Name,
		tdo.Name as tdo_Name,

		tdm.Walkable as tdm_Walkable,
		tdo.Walkable as tdo_Walkable,

		tdm.Keywords as tdm_Keywords,
		tdo.Keywords as tdo_Keywords,

		tdm.Image as tdm_Image,
		tdo.Image as tdo_Image

	from 

		map as m

	left join overlay as o on o.x=m.x and o.y=m.y and o.mapid=m.mapid
	left join tiledata as tdm on tdm.TileID=m.TileID
	left join tiledata as tdo on tdo.TileID=o.TileID

	where m.TileID is not NULL
";

$sth = mysql_query($sql);
print mysql_error();
while ($data = mysql_fetch_assoc($sth)) {

	if ($data['tdm_Walkable'] == "N" || $data['tdo_Walkable'] == "N") { $Walkable = "N"; } else { $Walkable = "Y"; }

	if ($data['o_TileID'] > 0) {
		$sql = "insert into tiledata (Image,Name,Keywords,Walkable,ImageType,NewTile) values ('n_".$data['m_TileID']."_".$data['o_TileID'].".jpg"."','".$data['tdm_Name']."_".$data['tdo_Name']."','".$data['tdm_Keywords']."_".$data['tdo_Keywords']."','".$Walkable."','Map','Y')";
		mysql_query($sql);
		print mysql_error();

//		$cmd = "convert -flatten \"/var/virtual/deltoria.com/htdocs/images/tiles/".$data['tdm_Image']."\" \"/var/virtual/deltoria.com/htdocs/images/tiles/".$data['tdo_Image']."\" ./tiles/n_".$data['m_TileID']."_".$data['o_TileID'].".jpg";
//		system($cmd);
//		print $cmd."\n\n";
	} else {
		$sql = "insert into tiledata (Image,Name,Keywords,Walkable,ImageType,NewTile) values ('n_".$data['m_TileID'].".jpg"."','".$data['tdm_Name']."','".$data['tdm_Keywords']."','".$Walkable."','Map','Y')";
		mysql_query($sql);
		print mysql_error();

//		$cmd = "convert -flatten \"/var/virtual/deltoria.com/htdocs/images/tiles/".$data['tdm_Image']."\" ./tiles/n_".$data['m_TileID'].".jpg";
//		system($cmd);
//		print "\n\n";
	}

}
?>