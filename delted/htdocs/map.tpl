<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY {* ONLOAD="void loadmap();"*}>

{include file="./includes/logged_top.tpl"}

<TABLE>
	<TR><TD>

		<FORM STYLE="margin: 0px;">
			<TABLE WIDTH="100%">
				<TH>X</TH><TH>Y</TH><TH>Zone</TH><TH>Zoom Out</TH><TH>Brush</TH><TH>Danger</TH><TH>&nbsp;</TH><TH ROWSPAN="2" WIDTH="100%" STYLE="background-color: #F5F5F5; text-align: right;"><IMG ID="Image" SRC="../images/tiles/grass.jpg"></TH>
				<TR>
					<TD><INPUT TYPE="TEXT" NAME="X" ID="X" SIZE=3 VALUE="{$smarty.get.X|default:311}"></TD>
					<TD><INPUT TYPE="TEXT" NAME="Y" ID="Y" SIZE=3 VALUE="{$smarty.get.Y|default:311}"></TD>
					<TD><SELECT ID="MapID" NAME="MapID">{foreach from=$zones item="zdata"}<OPTION VALUE="{$zdata.MapID}" {if $smarty.get.MapID eq $zdata.MapID}SELECTED{/if}>{$zdata.Name}</OPTION>{/foreach}</SELECT></TD>
					<TD><INPUT ID="zoom" NAME="zoom" TYPE="CHECKBOX" VALUE="0" ONCLICK="zoomclick()"></TD>
					<TD nowrap><SELECT ID="brush" NAME="brush"><OPTION VALUE="1">1</OPTION><OPTION VALUE="2">2</OPTION><OPTION VALUE="3">3</OPTION><OPTION VALUE="4">4</OPTION><OPTION VALUE="5">5</OPTION><OPTION VALUE="6">6</OPTION></SELECT></TD>
					<TD><INPUT TYPE="TEXT" NAME="Danger" ID="Danger" SIZE=3 VALUE="{$smarty.get.Danger|default:0}"></TD>

					<TD><A HREF="#" ONCLICK="void loadmap();">Go</A></TD>
				</TR>
			</TABLE>

			<SELECT NAME=PortalID ID=PortalID STYLE="width: 100%; display: none;"><OPTION VALUE="0">None</OPTION>{foreach from=$portals item=pdata}<OPTION VALUE="{$pdata.PortalID}">{$pdata.Name|truncate:12}</OPTION>{/foreach}</SELECT>
			<SELECT NAME=GroupID ID=GroupID STYLE="width: 100%; display: none;"><OPTION VALUE="0">None</OPTION>{foreach from=$spawns item=sdata}<OPTION VALUE="{$sdata.GroupID}">{$sdata.Name|truncate:12}</OPTION>{/foreach}</SELECT>
			<INPUT TYPE="HIDDEN" NAME="M_X">
			<INPUT TYPE="HIDDEN" NAME="M_Y">
			<SELECT NAME=Action ID=Action STYLE="width: 100%; display: none;">
			<OPTION VALUE="map_tiles.php">Tiles</OPTION>
			<OPTION VALUE="map_portal.php">Portals</OPTION>
			<OPTION VALUE="map_spawn.php">Spawns</OPTION>
			//<OPTION VALUE="map_npcspawn.php">NPC</OPTION>
			</SELECT>
			<INPUT TYPE="HIDDEN" ID="TileID" NAME="TileID" VALUE="11">
		</FORM>
	
		<IFRAME ID="MapView" SRC="map_view.php?X={$smarty.get.X}&Y={$smarty.get.Y}&MapID={$smarty.get.MapID}" WIDTH="576" HEIGHT="432" SCROLLING="NO" FRAMEBORDER=0></IFRAME>
		<P>

		<TABLE BORDER=0>
			<TR>
				<TD>&nbsp;</TD>
				<TD><A HREF="#" ONCLICK="void move_up();"><IMG SRC="./images/navigation_n.gif" BORDER=0></A></TD>
				<TD>&nbsp;</TD>
			</TR><TR>
				<TD><A HREF="#" ONCLICK="void move_left();"><IMG SRC="./images/navigation_w.gif" BORDER=0></A></TD>
				<TD><IMG SRC="./images/navigation.gif"></TD>
				<TD><A HREF="#" ONCLICK="void move_right();"><IMG SRC="./images/navigation_e.gif" BORDER=0></A></TD>
			</TR><TR>
				<TD>&nbsp;</TD>
				<TD <A HREF="#" ONCLICK="void move_down();"><IMG SRC="./images/navigation_s.gif" BORDER=0></A></TD>
				<TD>&nbsp;</TD>
			</TR>
		</TABLE>

		

	</TD><TD>
		<FORM STYLE="margin: 0px;">
			<INPUT TYPE=RADIO ID="Tile" ONCLICK="get_right('map_tiles.php');" NAME="RightOpt" ID="RightOpt" CHECKED> Tile 
			<INPUT TYPE=RADIO ID="Portal" ONCLICK="get_right('map_portal.php');" NAME="RightOpt" ID="RightOpt" VALUE="Portal"> Portal
			<INPUT TYPE=RADIO ID="Spawn" ONCLICK="get_right('map_spawn.php');" NAME="RightOpt" ID="RightOpt"> Monster
			<INPUT TYPE=RADIO ID="Danger" ONCLICK="get_right('map_danger.php');" NAME="RightOpt" ID="RightOpt"> Danger
		</FORM>
		
		<IFRAME ID="RightView" SRC="map_tiles.php" WIDTH="220" HEIGHT="600" FRAMEBORDER=0 STYLE="margin-left: 5px;">
		</IFRAME>

	</TD></TR>
</TABLE>


<SCRIPT>
	{literal}

	function get_right(URL) {
		document.getElementById("RightView").src = URL;
		document.getElementById("Action").value = URL;
	}

	function loadmap() {
		document.getElementById("MapView").src = "map_view.php?zoom=" + document.getElementById("zoom").value + "&X=" + document.getElementById("X").value + "&Y=" + document.getElementById("Y").value + "&MapID=" + document.getElementById("MapID").value
	}

	function move_up() {
		document.getElementById("Y").value = parseInt(document.getElementById("Y").value) - 3;
		loadmap();
	}

	function move_down() {
		document.getElementById("Y").value = parseInt(document.getElementById("Y").value) + 3;
		loadmap();
	}

	function move_left() {
		document.getElementById("X").value = parseInt(document.getElementById("X").value) - 3;
		loadmap();
	}

	function move_right() {
		document.getElementById("X").value = parseInt(document.getElementById("X").value) + 3;
		loadmap();
	}
	function zoomclick() {
		if (document.getElementById("zoom").value == 1) {
			document.getElementById("zoom").value = 0;
		} else {
			document.getElementById("zoom").value = 1;
		}
	}

	{/literal}
</SCRIPT>

</BODY>
</HTML>
