<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
//Enables stuff to be equiped and displays it
$sth = mysql_query("select ItemID,Wear_Hands,Wear_Head,Wear_Torso,Wear_Arms,Wear_Feet,Wear_Legs,Wear_Necklace,Wear_Ring,Wear_Bracelet,Wear_Wielded  from items_base");
while ($data = mysql_fetch_array($sth)) {
	$wearslot = "";
	if ($data['Wear_Head'] == "Y") $wearslot .= " Head";
	if ($data['Wear_Torso'] == "Y") $wearslot .= " Torso";
	if ($data['Wear_Arms'] == "Y") $wearslot .= " Arms";
	if ($data['Wear_Feet'] == "Y") $wearslot .= " Feet";
	if ($data['Wear_Legs'] == "Y") $wearslot .= " Legs";
	if ($data['Wear_Necklace'] == "Y") $wearslot .= " Necklace";
	if ($data['Wear_Ring'] == "Y") $wearslot .= " Ring";
	if ($data['Wear_Bracelet'] == "Y") $wearslot .= " Bracelet";
	if ($data['Wear_Hands'] == "Y") $wearslot .= " Hands";
	if ($data['Wear_Wielded'] == "Y") $wearslot .= " Wielded";
	$wearslot = preg_replace("/^ /","",$wearslot);
	$sql = "update items_base set WearSlot='$wearslot' where ItemID='$data[ItemID]' limit 1";
	mysql_query($sql);}
?>