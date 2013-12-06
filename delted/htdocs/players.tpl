<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="../../htdocs/includes/logged_top.tpl"}
{include file="../../htdocs/includes/administrator.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.player_id eq ""}
	<DIV CLASS="Title">Available Players</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a player from the list below<P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Player Name</TH>
				<TH CLASS="DataBox">Zone</TH>
				<TH CLASS="DataBox">XP</TH>
				<TH CLASS="DataBox">Image</TH>
				{foreach from=$players_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?player_id={$data.player_id}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.player_name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.zone}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.xp|number_format}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><IMG WIDTH="22" HEIGHT="14" SRC="/images/tiles/{$data.image}"></TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=users column=player_id value=$smarty.get.player_id return=playerdata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Player<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="players.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE>
		<TR><TD WIDTH=500>

			<TABLE Class="ContentBox" width="100%">
				<TR><TD CLASS="ContentBox">
					<FORM ACTION="players.php?player_id={$smarty.get.player_id}" METHOD="POST">
						<INPUT TYPE=HIDDEN NAME=player_id VALUE="{$smarty.get.player_id}">
						<INPUT TYPE=HIDDEN NAME=save VALUE=y>
						{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$playerdata}
						<P>
						<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Player">
					</FORM>
				</TD></TR>
			</TABLE>

		</TD><TD STYLE="padding-left: 10px;">
			<TABLE Class="ContentBox">
				<TR><TD CLASS="ContentBox">
					<TABLE><TR><TD CLASS=ContentBox>Selected Tile:</TD><TD><IMG WIDTH="32" HEIGHT="24" ID="TileImage" SRC="/images/tiles/{$tile_image}"></TD></TR></TABLE>
					<HR STYLE="margin-bottom: 0px;">
					<IFRAME FRAMEBORDER=0 SRC="tile_picker.php?image_type=actor&selected={$eddata.tile_id}&return_image=TileImage&return_id=tile_id" WIDTH="160px" HEIGHT="300px"></IFRAME>
				</TD></TR>
			</TABLE>
		</TD></TR>
	</TABLE>
{/if}

