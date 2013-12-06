<HTML>
<HEAD>
<LINK rel="stylesheet" href="styles/default.css">
</HEAD>

<BODY>

{include file="./includes/logged_top.tpl"}

{addsection label="X" db_column="X" edtype="TEXT" size="5"}
{addsection label="Y" db_column="Y" edtype="TEXT" size="5"}
{addsection NEW="1"}
{addsection label="ModCode" db_column="ModCode" edtype="TEXTAREA" size="25"}
{addsection NEW="1"}
{if $smarty.post.save eq "y"}
	{editor_save sections=$section_data table=map column=MapID value=$smarty.get.MapID}
	<script>
		window.location = "map code.php?MapID={$smarty.get.MapID}";
	</script>
{/if}


{if $smarty.get.MapID eq ""}

	<DIV CLASS="Title">Available Locs</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="map code.php">
			<SELECT NAME="filter">
			{foreach from=$codes_list item=data}
				<OPTION VALUE="{$smarty.get.MapID}" {if $smarty.get.filter eq "{$smarty.get.MapID}"}SELECTED{/if}>{$smarty.get.MapID}</OPTION>
				</SELECT><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Filter"></FORM>
			{/foreach}
			Select a location from the list below.
			<P>
			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">X</TH>
				<TH CLASS="DataBox">Y</TH>
				<TH CLASS="DataBox">MapID</TH>
				{foreach from=$map_codes_list item=data}
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

{elseif $smarty.get.MapID gt "0"}
	{editor_get table=map column=MapID  value=$smarty.get.MapID return=codedata}
		<FORM ACTION="map code.php?MapID={$smarty.get.MapID}" METHOD="POST">
		<INPUT TYPE=HIDDEN NAME="MapID" VALUE="{$smarty.get.MapID}">
		<INPUT TYPE=HIDDEN NAME="save" VALUE="y">

		<DIV CLASS="Title">Modify a Tile</DIV>
		<IMG SRC="images/line_white.gif" WIDTH="100%" HEIGHT="1" STYLE="padding: 0px; margin-top: 0px;"><BR>

		{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$codedata}

	
		<BR>
		<DIV STYLE="TEXT-ALIGN: LEFT;"><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Code"></DIV>

		</FORM>

{/if}

</TD></TR>
</TABLE>

</BODY>
</HTML>
