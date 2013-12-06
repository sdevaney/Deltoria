<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

{include file="./includes/logged_top.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.GroupID eq ""}
	<DIV CLASS="Title">Available Groups</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a groupn from the list below or <A HREF="lootgroup.php?GroupID=0" CLASS="ContentLink">create a new one</A><P>
			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Group Name</TH>
				{foreach from=$groups item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?GroupID={$data.GroupID}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=true}">{$data.Name}</TD>
					</TR>
				{/foreach}
			</TABLE><P>
		</TD></TR>
	</TABLE>
{else}
	{if $smarty.get.GroupID gt 0}{editor_get table=lootgroup column=GroupID value=$smarty.get.GroupID return=groupdata}{/if}
	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Group<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="lootgroup.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="lootgroup.php?GroupID={$smarty.get.GroupID}" METHOD="POST">
			<INPUT TYPE=HIDDEN NAME=GroupID VALUE="{$smarty.get.GroupID}">
			<INPUT TYPE=HIDDEN NAME=save VALUE=y>
			{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$groupdata}
			<P>
		</TD></TR>
	</TABLE><P>

	{manytomany cor_table="lootgroupmap" parent_pk="GroupID" parent_fk="GroupID" parent_table="lootgroup" child_pk="ItemID" child_fk="ItemID" child_name="Name" child_table="items_base" current=$smarty.get.GroupID all=all_data selected=selected_data}

	<DIV CLASS="Title">Assign Items to this Group</DIV>
	<TABLE BORDER=0>
		<TR><TD STYLE="padding: 10px;">
			All Items<BR>
			<SELECT NAME=All[] SIZE=10>
				{foreach from=$all_data item=sdata}
					<OPTION VALUE="{$sdata.ItemID}">{$sdata.Name}</OPTION>
				{/foreach}
			</SELECT>
			<INPUT TYPE="HIDDEN" NAME="All_save" VALUE="{foreach from=$all_data item=sdata name=saveloop}{$sdata.ItemID}{if !$smarty.foreach.saveloop.last},{/if}{/foreach}">
		</TD><TD STYLE="padding: 10px;">
			{formtool_move style="width: 50px; margin-top: 5px;" all=true from="All[]" to="Selected[]" button_text="&gt&gt;" save_from="All_save" save_to="Selected_save"}<br>
			{formtool_move style="width: 50px; margin-top: 5px;" from="All[]" to="Selected[]" button_text="&gt;" save_from="All_save" save_to="Selected_save"}<br>
			{formtool_move style="width: 50px; margin-top: 5px;" from="Selected[]" to="All[]" button_text="&lt;" save_from="Selected_save" save_to="All_save"}<br>
			{formtool_moveall style="width: 50px; margin-top: 5px;" from="Selected[]" to="All[]" button_text="&lt&lt;" save_from="Selected_save" save_to="All_save"}<BR>
		</TD><TD STYLE="padding: 10px;">
			Selected Items<BR>
			<SELECT NAME=Selected[] SIZE=10>
				{foreach from=$selected_data item=sdata}
					<OPTION VALUE="{$sdata.ItemID}">{$sdata.Name}</OPTION>
				{/foreach}
			</SELECT>
			<INPUT TYPE="HIDDEN" NAME="Selected_save" VALUE="{foreach from=$selected_data item=sdata name=saveloop}{$sdata.ItemID}{if !$smarty.foreach.saveloop.last},{/if}{/foreach}">
		</TD></TR>
	</TABLE>

	<DIV STYLE="TEXT-ALIGN: RIGHT;"><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Group"></DIV>

	</FORM>
{/if}
