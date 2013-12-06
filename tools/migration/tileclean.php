#!/usr/bin/php -q
<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
$db = mysql_connect("localhost","db_user","db_pass");
mysql_select_db("db_name");

$sql = "
select * from tiledata where (ImageType='map' or ImageType='overlay') and NewTile='N';
";

$sth = mysql_query($sql);

while ($data = mysql_fetch_assoc($sth)) {
	unlink("/PATH_TO_FILE/images/tiles/".$data['Image']);
	print "Unlinking ".$data['Image']."\n";
}

mysql_query("delete from tiledata where (ImageType='map' or ImageType='overlay') and NewTile='N'");

?>
