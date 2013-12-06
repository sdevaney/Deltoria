<?PHP

global $db,$config,$gamedata;

$db = mysql_connect($config['db_host'],$config['db_user'],$config['db_pass']);

$config['Smarty_Cache'] = "/includes/smarty/cache/";

mysql_select_db($config['db_database']);
SQL_DB($config['db_database']);

// Setup Prefix Information
if (preg_match("/^(.*?)\./",$_SERVER['HTTP_HOST'],$matches)) {
    $config['url_prefix'] = $matches[1];
} else {
    $config['url_prefix'] = "www";
}

function SQL_DB($dbname) {
	global $db;
	if ( @mysql_select_db($dbname,$db) ) 
		return true;
	else 
		echo "Could not connect to the '".$dbname."' Database.";
}

function SQL_QUERY($sql) {
	global $db;
	//echo $sql."<BR>";
	$result = mysql_query($sql,$db);
	if (!$result) {
		global $errorString;
		$errorString .= "<FONT CLASS='error'>Error :: ".mysql_errno($db)." :: ".mysql_error($db)."<BR>".$sql."<BR></FONT>\n";
		echo "<BR>".$errorString."<BR>";
	}
	return $result;
}

function SQL_NUM_ROWS($rslt) {
	if ($rslt)
		return mysql_num_rows($rslt);
	else
		return false;
}

function SQL_ASSOC_ARRAY($rslt) {
	if ($rslt)
		return mysql_fetch_assoc($rslt);
	else
		return false;
}

function SQL_ROW($rslt) {
	if ($rslt)
		return mysql_fetch_row($rslt);
	else
		return false;
}

function SQL_INSERT_ID() {
	global $db;
	return mysql_insert_id($db);
}

function SQL_FREE($rslt) {
	if ($rslt)
		return mysql_free_result($rslt);
	else
		return false;
}
?>