<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="./includes/logged_top.tpl"}

{formtool_init src="./jscript/formtool.js"}

{if $smarty.get.SkillID eq ""}
	<DIV CLASS="Title">Available Skills</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a skill from the list below or <A HREF="skills.php?SkillID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Skill Name</TH>
				<TH CLASS="DataBox">Parent</TH>
				<TH CLASS="DataBox">Cost</TH>
				{foreach from=$skills_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?SkillID={$data.SkillID}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.ParentName}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Cost}</TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=skills column=SkillID value=$smarty.get.SkillID return=skilldata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Skill<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="skills.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE Class="ContentBox" width="100%">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="skills.php?SkillID={$smarty.get.SkillID}" METHOD="POST">
				<INPUT TYPE=HIDDEN NAME=SkillID VALUE="{$smarty.get.SkillID}">
				<INPUT TYPE=HIDDEN NAME=save VALUE=y>
				{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$skilldata}
				<P>
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Item">
			</FORM>
		</TD></TR>
	</TABLE>
{/if}

