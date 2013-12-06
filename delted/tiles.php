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

	if ($_GET['delete'] > 0) {
		mysql_query("delete from tiledata where TileID='".$_GET['delete']."'");
		mysql_query("delete from map where TileID='".$_GET['delete']."'");
	}

	if (is_array($_FILES)){ 
		while (list($k,$v) = each($_FILES)) {
			$pictype = strtolower(substr($v['name'],(strlen($v['name'])-3),3));
			if ($pictype == "jpg" || $pictype == "gif" || $pictype == "png") {
				$name = str_replace(".".$pictype,"",$v['name']);
				$sql = "insert into tiledata (Name,Keywords,Walkable,ImageType) values ('".$name."','".$tile_name."','".$_POST['Walkable']."','".$_POST['ImageType']."')";
				mysql_query($sql);
				$img_id = mysql_insert_id();
			
				copy($v['tmp_name'],"/home/techbygu/public_html/delt/images/tiles/{$img_id}.{$pictype}");
				mysql_query("update tiledata set Image='{$img_id}.{$pictype}' where TileID='{$img_id}'");
			}
		}
	}


	SmartyPaginate::connect();
	SmartyPaginate::setLimit(15);
	SmartyPaginate::setUrl("tiles.php?filter=".$_GET['filter']."&filtkey=".$_GET['filtkey']);

	$tiles = array();
	$sql = "select SQL_CALC_FOUND_ROWS * from tiledata";
	if ($_GET['filter'] != "" || $_GET['filtkey'] != "") {
		$sql .=" where ImageType='".$_GET['filter']."' and Keywords like '%".$_GET['filtkey']."%'";
	}
	$sql .= " order by Name limit ".SmartyPaginate::getCurrentIndex().",".SmartyPaginate::getLimit();
	$sth = mysql_query($sql);
	while ($data = mysql_fetch_assoc($sth)) {
    	$tiles[] = $data;
	}
	$smarty->assign("page_tiles_list",$tiles);

	$_query = "SELECT FOUND_ROWS()";
	$_result = mysql_query($_query);
	$_row = mysql_fetch_array($_result);
	SmartyPaginate::setTotal($_row['FOUND_ROWS()']);

	SmartyPaginate::assign($smarty);

	/*
	$tiles = array();
	$sql = "select * from tiles order by tile_name";
	$sth = mysql_query($sql);
	while ($data = mysql_fetch_assoc($sth)) {
    	$tiles[] = $data;
	}
	$smarty->assign("tiles_list",$tiles);
	*/

	if ($_GET['TileID'] > 0) {
		$sth = mysql_query("select ImageType from tiledata where TileID='".$_GET['TileID']."'");
		while (list($imagetype) = mysql_fetch_row($sth)) {
		   print $imagetype."<br>";
		   $tiletype = $imagetype;
		}
		if ($tiletype == 'Map') {
			$sth = mysql_query("select X,Y,MapID from map where TileID='".$_GET['TileID']."'");
			$in_use = mysql_num_rows($sth);
			$smarty->assign("in_use",$in_use);
			$locations = array();
		                       while ($data = mysql_fetch_array($sth)) {
                                $locations[] = $data;
                        }
                        $smarty->assign("locations",$locations);
		} 
		if ($tiletype == 'Object') {
			$sth = mysql_query("select Name from items_base where TileID='".$_GET['TileID']."'");
			$in_use = mysql_num_rows($sth);
			$smarty->assign("in_use",$in_use);
		} 
		if ($tiletype == 'Actor') {
			$sth = mysql_query("select Name from monster_base where TileID='".$_GET['TileID']."'");
			$in_use = mysql_num_rows($sth);
			$smarty->assign("in_use",$in_use);
		} 
		if ($tiletype == 'Item') {
        	$sth = mysql_query("select Name from items_base where TileID='".$_GET['TileID']."'");
	        $in_use = mysql_num_rows($sth);
    	    $smarty->assign("in_use",$in_use);
		}
		if ($tiletype == 'Monster') {
    	    $sth = mysql_query("select MonsterID from monster_base where TileID='".$_GET['TileID']."'");
        	$in_use = mysql_num_rows($sth);
	        $smarty->assign("in_use",$in_use);
                list($MID) = mysql_fetch_row($sth);
                $sth = mysql_query("select GroupID from monster_groups where MonsterID = $MID");
                print mysql_error();
                $locations = array();
                while(list($GroupsID) = mysql_fetch_row($sth)) {
                        $sth1 = mysql_query("select X,Y,MapID from map where GroupID = $GroupsID");
                        while ($data = mysql_fetch_array($sth1)) {
                                $locations[] = $data;
                        }
                }
                $smarty->assign("locations",$locations);
    	}
	if ($tiletype == 'NPC') {
    	    $sth1 = mysql_query("select MonsterID from monster_base where TileID='".$_GET['TileID']."'");
        	$in_use = mysql_num_rows($sth1);
	        $smarty->assign("in_use",$in_use);
		list($MID) = mysql_fetch_row($sth1);
		$sth = mysql_query("select GroupID from monster_groups where MonsterID = $MID");
		print mysql_error();
		$locations = array();
		while(list($GroupsID) = mysql_fetch_row($sth)) {
			$sth1 = mysql_query("select X,Y,MapID from map where GroupID = $GroupsID");
			while ($data = mysql_fetch_array($sth1)) {
				$locations[] = $data;
			}
		}
		$smarty->assign("locations",$locations);
    	}
		if ($tiletype == 'Building') {
			$sth = mysql_query("select Name from buildings where TileID='".$_GET['TileID']."'");
			$in_use = mysql_num_rows($sth);
			$smarty->assign("in_use",$in_use);
		}
	}


	$smarty->display("tiles.tpl");
	SmartyPaginate::disconnect();

//} else {
//   echo "You are either not logged in or not an admin";
//   exit();
//}

?>