<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="./includes/logged_top.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.SpellID eq ""}
	<DIV CLASS="Title">Available Spells</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a spell from the list below or <A HREF="spells.php?SpellID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Spell Name</TH>
				{foreach from=$spells_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?SpellID={$data.SpellID}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=true}">{$data.Name}</TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=spells column=SpellID value=$smarty.get.SpellID return=spelldata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Spell<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="spells.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE Class="ContentBox" width="100%">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="spells.php?SpellID={$smarty.get.SpellID}" METHOD="POST">
				<INPUT TYPE=HIDDEN NAME=SpellID VALUE="{$smarty.get.SpellID}">
				<INPUT TYPE=HIDDEN NAME=save VALUE=y>
				{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$spelldata}
				<P>
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Spell">
			</FORM>
		</TD></TR>
	</TABLE>

{/if}

