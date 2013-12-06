<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/

session_start();
global $userdata,$config;

require_once("./includes/config.php");
require_once("./includes/common.php");
require_once("./includes/db_connect.php");
require_once("./includes/smarty.php");
require_once("./includes/user.php");

//if($session->isAdmin()){

	if ($_GET['X'] == "") $_GET['X'] = 311;
	if ($_GET['Y'] == "") $_GET['Y'] = 311;
	if ($_GET['MapID'] == "") $_GET['MapID'] = 1;

	if ($_GET['set'] == "y") {
		if ($_GET['TileID'] != "") {
			$strokes_y = $_GET['brush'];
			$strokes_x = $_GET['brush'];

			$strokes  = $_GET['brush'] * $_GET['brush'];

			while ($strokes > 0) {
				if ($_GET['TileID'] == "0") {
					$sth = mysql_query("delete from map where X=".$_GET['set_x']." and Y=".$_GET['set_y']." and MapID=".$_GET['set_map_id']);
				} else {
					$sth = mysql_query("select * from map where X=".$_GET['set_x']." and Y=".$_GET['set_y']." and MapID=".$_GET['set_map_id']);
					if (mysql_num_rows($sth) == 0) {
						$sql = "insert into map (X,Y,MapID,TileID,GroupID,PortalID,Danger) values ('".$_GET['set_x']."','".$_GET['set_y']."','".$_GET['set_map_id']."','".$_GET['TileID']."','".$_GET['GroupID']."','".$_GET['PortalID']."','".intval($_GET['Danger'])."')";
					} else {
						$sql = "update map set Danger='".$_GET['Danger']."',TileID='".$_GET['TileID']."' where X=".$_GET['set_x']." and Y=".$_GET['set_y']." and MapID=".$_GET['set_map_id'];
					}
					SQL_QUERY($sql);
				}

				$strokes_x--;
				if ($strokes_x == 0) {
					$strokes_y--;
					$_GET['set_y']++;
					$_GET['set_x'] = $_GET['set_x'] - $_GET['brush'];
					$strokes_x = $_GET['brush'];
				}
				$_GET['set_x']++;
				$strokes--;
			}
		}

		if ($_GET['GroupID'] != "") {
			$sql = "update map set GroupID='".$_GET['GroupID']."' where X=".$_GET['set_x']." and Y=".$_GET['set_y']." and MapID=".$_GET['set_map_id'];
			SQL_QUERY($sql);
		}

		if ($_GET['PortalID'] != "") {
			$sql = "update map set PortalID='".$_GET['PortalID']."' where X=".$_GET['set_x']." and Y=".$_GET['set_y']." and MapID=".$_GET['set_map_id'];
			SQL_QUERY($sql);
		}

		if ($_GET['Danger'] != "") {
			$sql = "update map set Danger='".$_GET['Danger']."' where X=".$_GET['set_x']." and Y=".$_GET['set_y']." and MapID=".$_GET['set_map_id'];
			SQL_QUERY($sql);
		}

	}

	$sth = mysql_query("select z.Image from mapid_background as z where z.MapID=".intval($_GET['MapID']));
	list($default) = mysql_fetch_row($sth);

	$map_size = 8;
	$smarty->assign("tile_width","30");
	$smarty->assign("tile_height","30");

	$zonedata = array();
	for ($y = $_GET['Y'] - $map_size; $y <= $_GET['Y'] + $map_size; $y++) {
		for ($x = $_GET['X'] - $map_size; $x <= $_GET['X'] + $map_size; $x++) {
			$zonedata[$y][$x]['Image'] = $default;
			$zonedata[$y][$x]['X'] = $x;
			$zonedata[$y][$x]['Y'] = $y;
			$zonedata[$y][$x]['MapID'] = $_GET['MapID'];
		}
	}

	$sql = "
		select
			m.TileID,
			m.GroupID,
			m.Danger,
			m.PortalID,
			t.Image,
			m.X,
			m.Y,
			m.MapID
		from
			map as m
		left join
			tiledata as t on t.TileID=m.TileID
		where
			m.X >= '".($_GET['X']-$map_size)."' and
			m.X <= '".($_GET['X']+$map_size)."' and
			m.Y >= '".($_GET['Y']-$map_size)."' and
			m.Y <= '".($_GET['Y']+$map_size)."' and
			m.MapID='".$_GET['MapID']."'
	";

	$sth = SQL_QUERY($sql);
	while ($data = SQL_ASSOC_ARRAY($sth)) {
		$x = $data['X'];
		$y = $data['Y'];
		$zonedata[$y][$x]['X'] = $data['X'];
		$zonedata[$y][$x]['Y'] = $data['Y'];
		$zonedata[$y][$x]['GroupID'] = $data['GroupID'];
		$zonedata[$y][$x]['PortalID'] = $data['PortalID'];
		$zonedata[$y][$x]['MapID'] = $data['MapID'];
		$zonedata[$y][$x]['Image'] = $data['Image'];
		$zonedata[$y][$x]['TileID'] = $data['TileID'];
		$zonedata[$y][$x]['Danger'] = $data['Danger'];
	}
	$smarty->assign("zonedata",$zonedata);

	$smarty->display("map_view.tpl");

//} else {
//    echo "You are either not logged in or not an admin";
//    exit();
//}

?>