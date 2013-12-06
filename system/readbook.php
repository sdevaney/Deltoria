<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Read books to learn
if ($PlayerData->WID == 0) {
	$sth = mysql_query("select IB.Name, IB.Use_Effect from items as I left join items_base as IB on IB.ItemID=I.ItemID  where I.ObjectID=$UseObj and I.CoreID=$PlayerData->CoreID");

	print mysql_error();
	if (mysql_num_rows($sth) > 0) {
		$data = mysql_fetch_array($sth);
		print "<Table border=0 class=Box1>";
		print "<TR><TD COLSPAN=5 CLASS=Header>$data[Name]</TD>";
			print "<td width=33 align=center>";
			print "<br>$data[Use_Effect]";
			print "</td>";
		}
		print "</TR>";
		print "</TABLE><P>";
}
?>