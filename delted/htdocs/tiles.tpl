<HTML>
<HEAD>
<LINK rel="stylesheet" href="styles/default.css">
</HEAD>

<BODY>

{include file="./includes/logged_top.tpl"}

{addsection label="Name" db_column="Name" edtype="TEXT" size="25"}
{addsection label="Keyword" db_column="Keywords" edtype="TEXT" size="25"}
{addsection NEW="1"}
{addsection label="Walkable" db_column="Walkable" edtype="CHECKBOX"}
{addsection label="Type" db_column="ImageType" edtype="DROPDOWN" options="Map;Object;Actor;Item;NPC;Monster;NewTiles;Building;Special"}
{addsection NEW="1"}
{if $smarty.post.save eq "y"}
	{editor_save sections=$section_data table=tiledata column=TileID value=$smarty.get.TileID}
	<script>
		window.location = "tiles.php?TileID={$smarty.get.TileID}";
	</script>
{/if}


{if $smarty.get.TileID == "0"}
	<FORM ACTION="tiles.php" METHOD="POST" ENCTYPE="multipart/form-data">
	<INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="2000000">
	<INPUT TYPE=HIDDEN NAME="new" VALUE="y">
	Filename: <INPUT NAME='userfile' TYPE='file' SIZE=25><BR>
	Walkable: <INPUT TYPE="CHECKBOX" VALUE="Y" NAME="Walkable" CHECKED><BR>
	Image Type: <SELECT NAME="ImageType"><OPTION VALUE="Map">Map</OPTION><OPTION VALUE="Object">Object</OPTION><OPTION VALUE="Actor">Actor</OPTION><OPTION VALUE="Item">Item</OPTION><OPTION VALUE = "NPC">NPC</OPTION><OPTION VALUE="Monster">Monster</OPTION><OPTION VALUE="NewTiles">NewTiles</OPTION><OPTION VALUE="Building">Building</OPTION><OPTION VALUE="Special">Special</OPTION></SELECT><BR>
	<DIV STYLE="text-align: right;"><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Create Tile"></DIV>
	</FORM>
{/if}


{if $smarty.get.TileID eq ""}

	<DIV CLASS="Title">Available Tiles</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="tiles.php">
				<SELECT NAME="filter">
					<OPTION VALUE="" {if $smarty.get.filter eq ""}SELECTED{/if}>None</OPTION>
					<OPTION VALUE="Map" {if $smarty.get.filter eq "Map"}SELECTED{/if}>Map</OPTION>
					<OPTION VALUE="Object" {if $smarty.get.filter eq "Object"}SELECTED{/if}>Object</OPTION>
					<OPTION VALUE="Actor" {if $smarty.get.filter eq "Actor"}SELECTED{/if}>Actor</OPTION>
					<OPTION VALUE="Item" {if $smarty.get.filter eq "Item"}SELECTED{/if}>Item</OPTION>
					<OPTION VALUE="NPC" {if $smarty.get.filter eq "NPC"}SELECTED{/if}>NPC</OPTION>
					<OPTION VALUE="Monster" {if $smarty.get.filter eq "Monster"}SELECTED{/if}>Monster</OPTION>
					<OPTION VALUE="NewTiles" {if $smarty.get.filter eq "NewTiles"}SELECTED{/if}>NewTiles</OPTION>
					<OPTION VALUE="Building" {if $smarty.get.filter eq "Building"}SELECTED{/if}>Building</OPTION>
					<OPTION VALUE="Special" {if $smarty.get.filter eq "Special"}SELECTED{/if}>Special</OPTION>
				</SELECT>
				<INPUT TYPE='TEXT' NAME='filtkey' SIZE=10 />
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Filter">
			</FORM>

			Select a title from the list below or <A HREF="tiles.php?TileID=0" CLASS="ContentLink">create a new one</A>
			<P>
			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Image</TH>
				<TH CLASS="DataBox">Name</TH>
				<TH CLASS="DataBox">Keywords</TH>
				<TH CLASS="DataBox">Type</TH>
				<TH CLASS="DataBox">Walkable</TH>
				{foreach from=$page_tiles_list item=data}
					<tr>
						<td CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="tiles.php?TileID={$data.TileID}"><IMG BORDER=0 WIDTH="30" HEIGHT="30" SRC="/images/tiles/{$data.Image}"></A></td>
						<td CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="tiles.php?TileID={$data.TileID}">{$data.Image}</A></td>
						<td CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Name}</td>
						<td CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Keywords}</d>
						<td CLASS="DataRow{cycle values='A,B' advance=false}">{$data.ImageType}</d>
						<td CLASS="DataRow{cycle values='A,B' advance=true}">{$data.Walkable|default:"N"}</d>
					</tr>
				{/foreach} 
			</TABLE>
			<DIV STYLE="text-align: right; margin-right: 10px;">
			    {$paginate.first}-{$paginate.last} out of {$paginate.total}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    {paginate_prev style="margin-right; 5px;"} {paginate_middle format="page" page_limit="5" style="margin-left: 5px; margin-right: 5px;" } {paginate_next style="margin-left: 5px;"}
			</DIV>	
		</TD></TR>
	</TABLE>

{elseif $smarty.get.TileID gt "0"}
	{editor_get table=tiledata column=TileID  value=$smarty.get.TileID return=tiledata}
		<FORM ACTION="tiles.php?TileID={$smarty.get.TileID}" METHOD="POST">
		<INPUT TYPE=HIDDEN NAME="TileID" VALUE="{$smarty.get.TileID}">
		<INPUT TYPE=HIDDEN NAME="save" VALUE="y">

		{if $smarty.get.del_auth gt "0"}
			Are you sure? <A HREF="tiles.php?delete={$smarty.get.TileID}">Yes Delete this tile</A><HR>
		{else}
			<A HREF="tiles.php?TileID={$smarty.get.TileID}&del_auth={$smarty.get.TileID}">Delete this tile</A> {if $in_use gt "0"}(<b>NOTICE - This tile is in use!</b>){/if}<HR>
		{/if}

		<DIV CLASS="Title">Modify / Add a Tile</DIV>
		<IMG SRC="images/line_white.gif" WIDTH="100%" HEIGHT="1" STYLE="padding: 0px; margin-top: 0px;"><BR>
		<IMG BORDER=0 WIDTH="30" HEIGHT="30" SRC="/images/tiles/{$tiledata.Image}"><BR>

		{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$tiledata}

	
		<BR>
		<DIV STYLE="TEXT-ALIGN: LEFT;"><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Tile"></DIV>

		</FORM>
		(This tile is used {$in_use} times)<BR>
		{foreach from=$locations item="ldata"}
			<A HREF="map.php?X={$ldata.X}&Y={$ldata.Y}&MapID={$ldata.MapID}">{$ldata.X}, {$ldata.Y} : {$ldata.MapID}</A><BR>
		{/foreach}

	{/if}

</TD></TR>
</TABLE>

</BODY>
</HTML>
