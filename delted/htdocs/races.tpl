<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="../../htdocs/includes/logged_top.tpl"}
{include file="../../htdocs/includes/administrator.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.race_id eq ""}
	<DIV CLASS="Title">Available Races</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a race from the list below or <A HREF="races.php?race_id=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Race Name</TH>
				{foreach from=$races_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?race_id={$data.race_id}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=true}">{$data.race_name}</TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=races column=race_id value=$smarty.get.race_id return=racedata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Race<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="races.php" CLASS="ContentLink">Return to listing</A> | <A HREF="races.php?race_id=0" CLASS="ContentLink">New</A></DIV></DIV>

	<TABLE>
		<TR><TD WIDTH=500>

			<TABLE Class="ContentBox" width="100%">
				<TR><TD CLASS="ContentBox">
					<FORM ACTION="races.php?race_id={$smarty.get.race_id}" METHOD="POST">
						<INPUT TYPE=HIDDEN NAME=class_id VALUE="{$smarty.get.race_id}">
						<INPUT TYPE=HIDDEN NAME=save VALUE=y>
						{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$racedata}
						<P>
						<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Race">
					</FORM>
				</TD></TR>
			</TABLE>
		</TD></TR>
	</TABLE>
{/if}

