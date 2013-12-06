<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Allows Admins to edit player info and upload new tiles to server
	global $PlayerData;
	if ($PlayerData->Admin == "Y") { 
		print "<br><B>[ </B><A HREF=deltupload.php>Upload Tiles</a><B> ]</B>";
	}
	if ($PlayerData->Manager == "Y") { 
		print "<br><B>[ </B><A HREF=admin_index.php>User Manager</a><B> ]</B>";
	}

$newtime = microtime();
$newtime = explode(" ",$newtime);
$newmicrotime = $newtime[1]+$newtime[0];
$elapsed_time = number_format(($newmicrotime - $transaction_start),3);
echo "<p><font size=1>Page completed in ".$elapsed_time." seconds!</font>";
print "<p><font size=1>Copyright 2003-2010 2 Guys Technical Solutions, LLC; Scott Devaney , All rights reserved.</font>"

?>
</body>
</html>