<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
global $gamedata;

require_once($config['Smarty_Class']);
$smarty = new Smarty;

$smarty->plugins_dir = $config['Smarty_Plugins'];
$smarty->template_dir = $config['Smarty_Templates'];
$smarty->compile_dir = $config['Smarty_Compile_Dir'];
$smarty->config_dir = $config['Smarty_Configs'];
$smarty->cache_dir = $config['Smarty_Cache'];
$smarty->assign("config",$config);
if (!empty($_SERVER["HTTP_REFERER"])) $smarty->assign("HTTP_REFERER",$_SERVER["HTTP_REFERER"]);
require_once($config['Smarty_Pagination']);

?>