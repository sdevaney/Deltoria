<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/

global $config;

/*
*  Database Configuration and Definition
*/

$config['db_host'] = "localhost";
$config['db_user'] = "dbuser";
$config['db_pass'] = "dbpass!";
$config['db_database'] = "dbname";
/*
*  Smarty Options and Definitions
*/
$config['Smarty_Class'] = "/includes/smarty/libs/Smarty.class.php";
$config['Smarty_Plugins'] = array("/includes/smarty/libs/plugins/","/public_html/delt/delted/includes/plugins");
$config['Smarty_Compile_Dir'] = "/delted/includes/smarty_c/";
$config['Smarty_Configs'] = "/delted/includes/smarty/smarty_configs/";
$config['Smarty_Cache'] = "./includes/smarty/smarty_cache/";
$config['Smarty_Templates'] = "/delted/htdocs/";
$config['Smarty_Pagination'] = "/delted/includes/smarty/libs/SmartyPaginate.class.php";
	
/*
*  Email Options
*/
$config['from_email'] = "Support <support@support.com>";
$config['email_enabled'] = true;

/*
* Security
*/
//$config['security'] = array("/login.php","/index.php","/authenticate.php","/register.php");


?>