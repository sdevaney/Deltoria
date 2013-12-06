<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/

session_start();
global $userdata,$config;

require_once("../includes/config.php");
require_once("../includes/common.php");
require_once("../includes/db_connect.php");
require_once("../includes/smarty.php");
require_once("../includes/user.php");

$section_data = array();
$section_data[] = array("label" => "Race", "db_column" => "race_id", "edtype" => "DROPDOWN_SQL", "query" => "select race_id,race_name from races order by race_name", "key_column" => "race_id", "value_column" => "race_name", "size" => "25", "blank_option" => "0");
$section_data[] = array("label" => "Class", "db_column" => "class_id", "edtype" => "DROPDOWN_SQL", "query" => "select class_id,class_name from classes order by class_name", "key_column" => "class_id", "value_column" => "class_name", "size" => "25", "blank_option" => "0");
$section_data[] = "NEW";
$section_data[] = array("label" => "Skill", "db_column" => "skill_id", "edtype" => "DROPDOWN_SQL", "query" => "select skill_id,skill_name from skills order by skill_name", "key_column" => "skill_id", "value_column" => "skill_name", "size" => "25", "blank_option" => "0");
$section_data[] = array("label" => "Parent Skill", "db_column" => "parent_skill_id", "edtype" => "DROPDOWN_SQL", "query" => "select skill_id,skill_name from skills order by skill_name", "key_column" => "skill_id", "value_column" => "skill_name", "size" => "25", "blank_option" => "1");
$section_data[] = "NEW";
$section_data[] = array("label" => "Skill Cost", "db_column" => "skill_cost", "edtype" => "TEXT", "size" => "25");
$section_data[] = array("label" => "Skill Level Req", "db_column" => "skill_level_req", "edtype" => "TEXT", "size" => "25");
$section_data[] = "NEW";
$section_data[] = array("label" => "Start", "db_column" => "skill_start", "edtype" => "CHECKBOX");
$section_data[] = array("label" => "XP Per Success", "db_column" => "xp_success", "edtype" => "TEXT");
$smarty->assign("section_data",$section_data);
if ($_POST['save'] == "y") editor_save($section_data,"race_data","data_id",$_GET['data_id']);

$rdata = array();
$sth = mysql_query("
select 
*,
(select race_name from races where race_id=rd.race_id) as race_name,
(select class_name from classes where class_id=rd.class_id) as class_name,
(select skill_name from skills where skill_id=rd.skill_id) as skill_name,
(select skill_name from skills where skill_id=rd.parent_skill_id) as parent_skill_name
from race_data as rd order by rd.race_id,rd.class_id
");
while ($data = mysql_fetch_assoc($sth)) {
    $rdata[] = $data;
}
$smarty->assign("data_list",$rdata);

$smarty->display("race_link.tpl");

?>