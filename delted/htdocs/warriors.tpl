<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="./includes/logged_top.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.WarriorID eq ""}
	<DIV CLASS="Title">Available Warriors</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a warrior from the list below or <A HREF="warriors.php?WarriorID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Warrior Name</TH>
				<TH CLASS="DataBox">Strength</TH>
				<TH CLASS="DataBox">Armor</TH>
				<TH CLASS="DataBox">Cost</TH>
				<TH CLASS="DataBox">Image</TH>
				{foreach from=$warriors_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?WarriorID={$data.WarriorID}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Strength}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Armor}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Cost}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><IMG WIDTH="22" HEIGHT="14" SRC="http://www.deltoria.com/images/tiles/{$data.Image}"></TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=warriors column=WarriorID value=$smarty.get.WarriorID return=warriordata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Warrior<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="warriors.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE>
		<TR><TD WIDTH=500>

			<TABLE Class="ContentBox" width="100%">
				<TR><TD CLASS="ContentBox">
					<FORM ACTION="warriors.php?WarriorID={$smarty.get.WarriorID}" METHOD="POST">
						<INPUT TYPE=HIDDEN NAME=WarriorID VALUE="{$smarty.get.WarriorID}">
						<INPUT TYPE=HIDDEN NAME=save VALUE=y>
						{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$warriordata}
						<P>
						<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Warrior">
					</FORM>
				</TD></TR>
			</TABLE>

		</TD><TD STYLE="padding-left: 10px;">
			<TABLE Class="ContentBox">
				<TR><TD CLASS="ContentBox">
					<TABLE><TR><TD CLASS=ContentBox>Selected Tile:</TD><TD><IMG WIDTH="32" HEIGHT="24" ID="TileImage" SRC="http://www.deltoria.com/images/tiles/{$tile_image}"></TD></TR></TABLE>
					<HR STYLE="margin-bottom: 0px;">
					<IFRAME FRAMEBORDER=0 SRC="tile_picker.php?/*image_type=Actor&*/selected={$eddata.TileID}&return_image=TileImage&return_id=TileID" WIDTH="160px" HEIGHT="300px"></IFRAME>
				</TD></TR>
			</TABLE>
		</TD></TR>
	</TABLE>
{/if}