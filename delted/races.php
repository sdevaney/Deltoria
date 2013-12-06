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

$section_data = array();
$section_data[] = array("label" => "Name", "db_column" => "race_name", "edtype" => "TEXT", "size" => "25");
$smarty->assign("section_data",$section_data);

if ($_POST['save'] == "y") editor_save($section_data,"races","race_id",$_GET['race_id']);

$races = array();
$sth = mysql_query("select s.* from races as s order by s.race_name");
while ($data = mysql_fetch_assoc($sth)) {
    $races[] = $data;
}
$smarty->assign("races_list",$races);


$smarty->display("races.tpl");

?>

