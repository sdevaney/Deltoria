<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

{include file="./includes/logged_top.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.QuestID eq ""}
	<DIV CLASS="Title">Available Quests</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a quest from the list below or <A HREF="quests.php?QuestID=0" CLASS="ContentLink">create a new one</A><P>
			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Quest Name</TH>
				<TH CLASS="DataBox">Requested Item</TH>
				<TH CLASS="DataBox">Reward Item</TH>
				{foreach from=$quest_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?QuestID={$data.QuestID}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.ig_name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=true}">{$data.ir_name}</TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{if $smarty.get.QuestID gt 0}{editor_get table=questdata column=QuestID value=$smarty.get.QuestID return=questdata}{/if}
	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Quest<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="quests.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="quests.php?QuestID={$smarty.get.QuestID}" METHOD="POST">
				<INPUT TYPE=HIDDEN NAME=QuestID VALUE="{$smarty.get.QuestID}">
				<INPUT TYPE=HIDDEN NAME=save VALUE=y>
				{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$questdata}
				<P>
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Quest">
		</TD></TR>
	</TABLE><P>

	<DIV STYLE="TEXT-ALIGN: RIGHT;"><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Quest"></DIV>

	</FORM>
{/if}
