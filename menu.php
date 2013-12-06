<body background=./images/buttons/menu/http_back.jpg bgcolor="#ffffff" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">

<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
//Makes us our top menu, this is old and not used anymore
DispMenu();

function DispMenu() {
	global $PlayerData,$Skills,$SCRIPT_NAME;
	if (stristr($SCRIPT_NAME,"index.php")) { return 0; }
	print "<table cellspacing=0 cellpadding=0 border=0 class=pageContainer>";
	print "<tr>";
	print "<td rowspan=3 width=60 align=center class=pageCell background=./images/buttons/menu/http_back.jpg>";
		print "<img src=/images/eltor/chars/$PlayerData->UserPic>";
		print "<BR><B>$PlayerData->Username</B>";
	print "</td>";

	PrintMenuCell("navigation","main.php");
	PrintMenuCell("character","character.php");
	PrintMenuCell("clans","clans.php");
	PrintMenuCell("inventory","inventory.php");


	print "<td rowspan=3 class=pageCell>";
	print "<img src=./images/buttons/menu/http_logo.jpg>";
	print "</td>";
	print "</tr><tr>";


	PrintMenuCell("forums","forums.php");
	PrintMenuCell("whoson","who.php");
	PrintMenuCell("map","map.php");
	PrintMenuCell("mail","mail.php");

	print "</tr><tr>";

	print "<td colspan=2 class=pageCell>";
	print "<A HREF=\"index.php\">";
	print "<img border=0 src=./images/buttons/menu/char_selection.jpg>";
	print "</A></td>";

	print "<td colspan=2 class=pageCell>";
	print "<A HREF=\"http://www.httpgames.com/index.php\">";
	print "<img border=0 src=./images/buttons/menu/httpgames_home.jpg>";
	print "</A></td>";

	print "</tr>";

	print "</table>";



}

function PrintMenuCell($image,$target) {
        global $SCRIPT_NAME;

        print "<td class=pageCell>";
        print "<A HREF=\"$target\" TARGET=MainWin>";
        if (!stristr($SCRIPT_NAME,"$target")) {
                print "<img border=0 src=./images/buttons/menu/".$image."_up.jpg>";
        } else {
                print "<img border=0 src=./images/buttons/menu/".$image."_down.jpg>";
        }
        print "</A></TD>";

}



?>

</body>
