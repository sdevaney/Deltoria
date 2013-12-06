<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="./includes/logged_top.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.MonsterID eq ""}
	<DIV CLASS="Title">Available Monsters</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a monster from the list below or <A HREF="monsters.php?MonsterID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Monster Name</TH>
				<TH CLASS="DataBox">Hostile</TH>
				<TH CLASS="DataBox">XP</TH>
				<TH CLASS="DataBox">Level</TH>
				<TH CLASS="DataBox">Poison</TH>
				<TH CLASS="DataBox">Image</TH>
				{foreach from=$monsters_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?MonsterID={$data.MonsterID}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Hostile}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.XP|number_format}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Level|number_format}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Poison}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><IMG WIDTH="22" HEIGHT="14" SRC="/images/tiles/{$data.Image}"></TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=monster_base column=MonsterID value=$smarty.get.MonsterID return=monsterdata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Monster<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="monsters.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE>
		<TR><TD WIDTH=500>

			<TABLE Class="ContentBox" width="100%">
				<TR><TD CLASS="ContentBox">
					<FORM ACTION="monsters.php?MonsterID={$smarty.get.MonsterID}" METHOD="POST">
						<INPUT TYPE=HIDDEN NAME=MonsterID VALUE="{$smarty.get.MonsterID}">
						<INPUT TYPE=HIDDEN NAME=save VALUE=y>
						{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$monsterdata}
						<P>
						<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Monster">
					</FORM>
				</TD></TR>
			</TABLE>

		</TD><TD STYLE="padding-left: 10px;">
			<TABLE Class="ContentBox">
				<TR><TD CLASS="ContentBox">
					<TABLE><TR><TD CLASS=ContentBox>Selected Tile:</TD><TD><IMG WIDTH="32" HEIGHT="24" ID="TileImage" SRC="/images/tiles/{$tile_image}"></TD></TR></TABLE>
					<HR STYLE="margin-bottom: 0px;">
					<IFRAME FRAMEBORDER=0 SRC="tile_picker.php?/*image_type=Actor&*/selected={$eddata.TileID}&return_image=TileImage&return_id=TileID" WIDTH="160px" HEIGHT="300px"></IFRAME>
				</TD></TR>
			</TABLE>
		</TD></TR>
	</TABLE>
{/if}
