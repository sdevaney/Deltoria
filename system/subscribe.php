<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Subscription page
global $db, $CoreUserData;;

	// Subscription
	print "<table border=1 class=box1 width=340>";
	print "<tr><td class=header>Donation Status</td></tr>";
	print "<tr><td>";
	if ($CoreUserData[Subscriber] == "Y" || $CoreUserData[Subscriber] == "Yes") {
		print "<B>You're currently a donator.<BR>You last donated on ".$CoreUserData['FundDate'].".</B>";
	} else {
		print "You're currently not a donator.";
	}
	print "<HR>";
	print "Deltoria is funded only by donations from you the community.";


    print "If you would like to donate any amount then please use the following button.";
?>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="UURU4RJKFABNU">
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>



	<?

	print "<P>";
	print "If you don't have a credit/debit card or can't use PayPal feel free to send a check or money order in USD to:<P>";
	print "<BR>";
print "<B>";

print "</B>";
print "Be sure to include the email you registered with as well as your character name(s)";
	print "</td></tr>";
	print "<tr><td class=footer>&nbsp;</td></tr>";
	print "</table><P>";

?>