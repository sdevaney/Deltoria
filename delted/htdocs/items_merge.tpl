<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="../../htdocs/includes/logged_top.tpl"}
{include file="../../htdocs/includes/administrator.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.merge_id eq ""}
	<DIV CLASS="Title">Available Merges</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a merge from the list below or <A HREF="items_merge.php?merge_id=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">1st Item</TH>
				<TH CLASS="DataBox">2nd Item</TH>
				<TH CLASS="DataBox">Resulting Item</TH>
				{foreach from=$merge_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?merge_id={$data.merge_id}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.a_item_name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.b_item_name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=true}">{$data.result_item_name}</TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=items_merge column=merge_id value=$smarty.get.merge_id return=mergedata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Merge<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="items_merge.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

		<TABLE Class="ContentBox" width="500">
			<TR><TD CLASS="ContentBox">
				<FORM ACTION="items_merge.php?merge_id={$smarty.get.merge_id}" METHOD="POST">
					<INPUT TYPE=HIDDEN NAME=merge_id VALUE="{$smarty.get.merge_id}">
					<INPUT TYPE=HIDDEN NAME=save VALUE=y>
					{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$mergedata}
					<P>
					<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Merge">
				</FORM>
			</TD></TR>
		</TABLE>
	</DIV>
{/if}

