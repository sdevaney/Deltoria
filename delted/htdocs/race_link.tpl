<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="../../htdocs/includes/logged_top.tpl"}
{include file="../../htdocs/includes/administrator.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.data_id eq ""}
	<DIV CLASS="Title">Available Linkings</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a link from the list below or <A HREF="race_link.php?data_id=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Race</TH>
				<TH CLASS="DataBox">Class</TH>
				<TH CLASS="DataBox">Skill</TH>
				<TH CLASS="DataBox">Required Skill</TH>
				<TH CLASS="DataBox">XP Success</TH>
				<TH CLASS="DataBox">Start</TH>
				{foreach from=$data_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?data_id={$data.data_id}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.race_name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.class_name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.skill_name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.required_skill_name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.xp_success|number_format}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=true}">{$data.skill_start}</TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=race_data column=data_id value=$smarty.get.data_id return=rdata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Race Link<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="race_link.php" CLASS="ContentLink">Back to listing</A> | <A HREF="race_link.php?data_id=0" CLASS="CONTENTLINK">New</A></DIV></DIV>

	<TABLE Class="ContentBox" width="300px">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="race_link.php?data_id={$smarty.get.data_id}" METHOD="POST">
				<INPUT TYPE=HIDDEN NAME=data_id VALUE="{$smarty.get.data_id}">
				<INPUT TYPE=HIDDEN NAME=save VALUE=y>
				{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$rdata}
				<P>
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Linking">
			</FORM>
		</TD></TR>
	</TABLE>
{/if}

