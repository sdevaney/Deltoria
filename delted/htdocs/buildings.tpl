<HTML>
<HEAD>
<LINK rel="stylesheet" href="./styles/default.css">
</HEAD>

<BODY>

{include file="./includes/logged_top.tpl"}

{formtool_init src="./jscript/formtool.js"}

{if $smarty.get.BID eq ""}
	<DIV CLASS="Title">Available Buildings</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a building from the list below or <A HREF="buildings.php?BID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Building Name</TH>
				<TH CLASS="DataBox">Cost</TH>
				<TH CLASS="DataBox">Max Armor</TH>
				<TH CLASS="DataBox">Base Maint</TH>
				<TH CLASS="DataBox">Image</TH>
				{foreach from=$buildings_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?BID={$data.BID}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Cost}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.MaxArmor}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.BaseMaint}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><IMG WIDTH="22" HEIGHT="14" SRC="http://www.deltoria.com/images/tiles/{$data.Image}"></TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=buildings column=BID value=$smarty.get.BID return=buildingdata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Building<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="buildings.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE>
		<TR><TD WIDTH=500>

			<TABLE Class="ContentBox" width="100%">
				<TR><TD CLASS="ContentBox">
					<FORM ACTION="buildings.php?BID={$smarty.get.BID}" METHOD="POST">
						<INPUT TYPE=HIDDEN NAME=BID VALUE="{$smarty.get.BID}">
						<INPUT TYPE=HIDDEN NAME=save VALUE=y>
						{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$buildingdata}
						<P>
						<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Building">
				</TD></TR>
			</TABLE>

		</TD><TD STYLE="padding-left: 10px;">
			<TABLE Class="ContentBox">
				<TR><TD CLASS="ContentBox">
					<TABLE><TR><TD CLASS=ContentBox>Selected Tile:</TD><TD><IMG WIDTH="32" HEIGHT="24" ID="TileImage" SRC="../images/tiles/{$tile_image}"></TD></TR></TABLE>
					<HR STYLE="margin-bottom: 0px;">
					<IFRAME FRAMEBORDER=0 SRC="tile_picker.php?image_type=Object&selected={$eddata.TileID}&return_image=TileImage&return_id=TileID" WIDTH="160px" HEIGHT="300px"></IFRAME>
				</TD></TR>
			</TABLE>
		</TD></TR>
	</TABLE>
{/if}
