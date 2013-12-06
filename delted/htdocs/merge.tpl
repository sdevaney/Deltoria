<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="./includes/logged_top.tpl"}

{formtool_init src="./jscript/formtool.js"}

{if $smarty.get.MergeID eq ""}
	<DIV CLASS="Title">Available Items</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a merge group from the list below or <A HREF="merge.php?MergeID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Item A</TH>
				<TH CLASS="DataBox">Item B</TH>
				<TH CLASS="DataBox">Result</TH>
				{foreach from=$merge_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?MergeID={$data.MergeID}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.ItemA_Name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.ItemB_Name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Result_Name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=true}">{$data.Admin}</TD>
					</TR>
				{/foreach}
			</TABLE><P>
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=items_merge column=MergeID value=$smarty.get.MergeID return=itemdata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Merge<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="merge.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE Class="ContentBox" width="100%">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="merge.php?MergeID={$smarty.get.MergeID}" METHOD="POST">
				<INPUT TYPE=HIDDEN NAME=MergeID VALUE="{$smarty.get.MergeID}">
				<INPUT TYPE=HIDDEN NAME=save VALUE=y>
				{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$itemdata}
				<P>
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Merge">
			</FORM>
		</TD></TR>
	</TABLE>
{/if}

