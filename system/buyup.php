<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
global $db,$PlayerData;
?>
<A HREF = "WEBSITE TO LEVEL REQUIREMENTS"><b>Click here for Level Reqs on items</b></A><BR>

<b><u>Please NOTE:</u></b><BR>

When buying an item note the level in which to be able to USE the item(see link above).<BR> 

As well it might be easier to simply calculate (add the items together) come up with a final<BR> 

total $ and then send a gmail to YOUR_ADMIN_NAME and then send a paypal payment to YOUR_PAYPAL_ADDRESS<BR> 

with a total figure for all the items you require.<P>

There is usually a fairly quick reaction time to all requests.  However, there may be longer periods<BR> 

of response.<P>

ALL SALES are FINAL, so please do your research, thank you.<P>

<b><u>CHARACTER UPGRADES</u></b><P>

INVENTORY INCREASE - 6 Months<P> 

more items will be added as time allows.<P>

<b><u>ITEM PURCHASES</u></b><P>

Once bought and placed in inventory they are now the ownership of the player to do with what they want.<BR>
However, once these items are used, destroyed, deleted or otherwise removed from inventory, these items are<BR>
gone, and will not be replaced.<BR>


<P>
<b><u>Purchase Items:</u></b><P>
  <form action="https://www.paypal.com/cgi-bin/webscr" methd="post">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="YOUR_PAYPAL_ADDRESS">
	I would like to purchase 
	<select name="item_name">
	  <option value="No item">Please select</option>
	  <?php
	    $sth = mysql_query("select Name, Price from items_base where Buyable = 'Y' order by Name");
	      while ($i = mysql_fetch_array($sth)) {
	        print "<option value=\"".$PlayerData->Username." - ".$i['Name']." $".$i['Price'].".00\">".$i['Name']." $".$i['Price']."</OPTION>";
		  }
	print "</select>";
	print "<input type=\"hidden\" name=\"no_shipping\" value=\"1\">";
    print "<input type=\"hidden\" name=\"return\" value=\"http://www.your_game.com/\">";
    print "<input type=\"hidden\" name=\"no_note\" value=\"1\">";
      ?>
    <input type="hidden" name="p3" value="1">
    <input type="hidden" name="t3" value="M">
    <input type="image" src="http://images.paypal.com/images/x-click-but02.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
  </form>
