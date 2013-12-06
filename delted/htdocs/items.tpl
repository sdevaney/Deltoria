<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="./includes/logged_top.tpl"}

{formtool_init src="./jscript/formtool.js"}

{if $smarty.get.ItemID eq ""}
	<DIV CLASS="Title">Available Items</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a item from the list below or <A HREF="items.php?ItemID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Item Name</TH>
				<TH CLASS="DataBox">Type</TH>
				<TH CLASS="DataBox">Subscriber</TH>
				<TH CLASS="DataBox">Level</TH>
				<TH CLASS="DataBox">Administrator</TH>
				<TH CLASS="DataBox">Image</TH>
				{foreach from=$items_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?ItemID={$data.ItemID}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.ItemType}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Subscriber}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Defined_LevelReq}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Admin}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><IMG WIDTH="22" HEIGHT="14" SRC="../images/tiles/{$data.Image}"></TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=items_base column=ItemID value=$smarty.get.ItemID return=itemdata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Item<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="items.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE>
		<TR><TD WIDTH=500>

			<TABLE Class="ContentBox" width="100%">
				<TR><TD CLASS="ContentBox">
					<FORM ACTION="items.php?ItemID={$smarty.get.ItemID}" METHOD="POST">
						<INPUT TYPE=HIDDEN NAME=ItemID VALUE="{$smarty.get.ItemID}">
						<INPUT TYPE=HIDDEN NAME=save VALUE=y>
						{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$itemdata}
						<P>
						<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Item">
				</TD></TR>
			</TABLE>

{manytomany cor_table="items_base_spells" parent_pk="ItemID" parent_fk="ItemID" parent_table="items_base" child_pk="SpellID" child_fk="SpellID" child_name="Name" child_table="spells" current=$smarty.get.ItemID all="all_data" selected="selected_data"}

<DIV CLASS="Title">Assign Spells to this Item</DIV>
<TABLE BORDER=0>
<TR><TD STYLE="padding: 10px;">
All Spells<BR>
<SELECT NAME=All[] SIZE=10>
{foreach from=$all_data item=sdata}
<OPTION VALUE="{$sdata.SpellID}">{$sdata.Name}</OPTION>
{/foreach}
</SELECT>


<INPUT TYPE="HIDDEN" NAME="All_save" VALUE="{foreach from=$all_data item=sdata name=saveloop}{$sdata.SpellID}{if !$smarty.foreach.saveloop.last},{/if}{/foreach}">
</TD><TD STYLE="padding: 10px;">        
{formtool_move style="width: 50px; margin-top: 5px;" all=true from="All[]" to="Selected[]" button_text="&gt&gt;" save_from="All_save" save_to="Selected_save"}<br>
{formtool_move style="width: 50px; margin-top: 5px;" from="All[]" to="Selected[]" button_text="&gt;" save_from="All_save" save_to="Selected_save"}<br>
{formtool_move style="width: 50px; margin-top: 5px;" from="Selected[]" to="All[]" button_text="&lt;" save_from="Selected_save" save_to="All_save"}<br>
{formtool_moveall style="width: 50px; margin-top: 5px;" from="Selected[]" to="All[]" button_text="&lt&lt;" save_from="Selected_save" save_to="All_save"}<BR>

</TD><TD STYLE="padding: 10px;">        
Selected Spells<BR>            
<SELECT NAME=Selected[] SIZE=10>
{foreach from=$selected_data item=sdata}
<OPTION VALUE="{$sdata.SpellID}">{$sdata.Name}</OPTION>
{/foreach}                
</SELECT>            
<INPUT TYPE="HIDDEN" NAME="Selected_save" VALUE="{foreach from=$selected_data item=sdata name=saveloop}{$sdata.SpellID}{if !$smarty.foreach.saveloop.last},{/if}{/foreach}">
</TD></TR>
</TABLE>

</FORM>




		</TD><TD STYLE="padding-left: 10px;">
			<TABLE Class="ContentBox">
				<TR><TD CLASS="ContentBox">
					<TABLE><TR><TD CLASS=ContentBox>Selected Tile:</TD><TD><IMG WIDTH="32" HEIGHT="24" ID="TileImage" SRC="../images/tiles/{$tile_image}"></TD></TR></TABLE>
					<HR STYLE="margin-bottom: 0px;">
					<IFRAME FRAMEBORDER=0 SRC="tile_picker.php?image_type=Object&selected={$eddata.TileID}&return_image=TileImage&return_id=TileID" WIDTH="160px" HEIGHT="300px"></IFRAME>
				</TD></TR>
			</TABLE>
		</TD></TR>
	</TABLE>
{/if}

