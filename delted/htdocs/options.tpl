<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="../../htdocs/includes/logged_top.tpl"}
{include file="../../htdocs/includes/administrator.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.option_id eq ""}
	<DIV CLASS="Title">Available Options</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a option from the list below or <A HREF="options.php?option_id=0">create a new option</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Option Name</TH>
				<TH CLASS="DataBox">Options</TH>
				{foreach from=$options_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?option_id={$data.option_id}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.option_name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=true}">{$data.options}</TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=options column=option_id value=$smarty.get.option_id return=optiondata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Option<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="options.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE Class="ContentBox" width="500px">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="options.php?option_id={$smarty.get.option_id}" METHOD="POST">
				<INPUT TYPE=HIDDEN NAME=option_id VALUE="{$smarty.get.option_id}">
				<INPUT TYPE=HIDDEN NAME=save VALUE=y>
				{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$optiondata}
				<P>
				(<B>Note:</B> Options are comma seperated.)<BR>
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Option">
			</FORM>
		</TD></TR>
	</TABLE>
{/if}

