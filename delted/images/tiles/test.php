#!/usr/bin/php -q
<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/

$files1 = scandir(".");
while (list($k,$v) = each($files1)) {
	if (substr($v,strlen($v)-4,4) == ".gif") {
		print "insert into tiles (image,tile_name,keywords,walkable,image_type) values ('$v','$v','$v','N','item');\n";
	}
}
?>
