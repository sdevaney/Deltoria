<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

{include file="../../htdocs/includes/logged_top.tpl"}
{include file="../../htdocs/includes/administrator.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.group_id eq ""}
	<DIV CLASS="Title">Available Groups</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a groupn from the list below or <A HREF="groups.php?group_id=0" CLASS="ContentLink">create a new one</A><P>
			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Group Name</TH>
				{foreach from=$groups item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?group_id={$data.group_id}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=true}">{$data.group_name}</TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{if $smarty.get.group_id gt 0}{editor_get table=groups column=group_id value=$smarty.get.group_id return=groupdata}{/if}
	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Group<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="groups.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="groups.php?group_id={$smarty.get.group_id}" METHOD="POST">
				<INPUT TYPE=HIDDEN NAME=group_id VALUE="{$smarty.get.group_id}">
				<INPUT TYPE=HIDDEN NAME=save VALUE=y>
				{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$groupdata}
				<P>
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Group">
		</TD></TR>
	</TABLE><P>

	{manytomany cor_table="items_groups" parent_pk="group_id" parent_fk="group_id" parent_table="groups" child_pk="item_id" child_fk="item_id" child_name="item_name" child_table="items_base" current=$smarty.get.group_id all=all_data selected=selected_data}

	<DIV CLASS="Title">Assign Items to this Group</DIV>
	<TABLE BORDER=0>
		<TR><TD STYLE="padding: 10px;">
			All Items<BR>
			<SELECT NAME=All[] SIZE=10>
				{foreach from=$all_data item=sdata}
					<OPTION VALUE="{$sdata.item_id}">{$sdata.item_name}</OPTION>
				{/foreach}
			</SELECT>
			<INPUT TYPE="HIDDEN" NAME="All_save" VALUE="{foreach from=$all_data item=sdata name=saveloop}{$sdata.item_id}{if !$smarty.foreach.saveloop.last},{/if}{/foreach}">
		</TD><TD STYLE="padding: 10px;">
			{formtool_move style="width: 50px; margin-top: 5px;" all=true from="All[]" to="Selected[]" button_text="&gt&gt;" save_from="All_save" save_to="Selected_save"}<br>
			{formtool_move style="width: 50px; margin-top: 5px;" from="All[]" to="Selected[]" button_text="&gt;" save_from="All_save" save_to="Selected_save"}<br>
			{formtool_move style="width: 50px; margin-top: 5px;" from="Selected[]" to="All[]" button_text="&lt;" save_from="Selected_save" save_to="All_save"}<br>
			{formtool_moveall style="width: 50px; margin-top: 5px;" from="Selected[]" to="All[]" button_text="&lt&lt;" save_from="Selected_save" save_to="All_save"}<BR>
		</TD><TD STYLE="padding: 10px;">
			Selected Items<BR>
			<SELECT NAME=Selected[] SIZE=10>
				{foreach from=$selected_data item=sdata}
					<OPTION VALUE="{$sdata.item_id}">{$sdata.item_name}</OPTION>
				{/foreach}
			</SELECT>
			<INPUT TYPE="HIDDEN" NAME="Selected_save" VALUE="{foreach from=$selected_data item=sdata name=saveloop}{$sdata.item_id}{if !$smarty.foreach.saveloop.last},{/if}{/foreach}">
		</TD></TR>
	</TABLE>

	<DIV STYLE="TEXT-ALIGN: RIGHT;"><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Group"></DIV>

	</FORM>
{/if}
