<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="../../htdocs/includes/logged_top.tpl"}
{include file="../../htdocs/includes/administrator.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.class_id eq ""}
	<DIV CLASS="Title">Available Classes</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a class from the list below or <A HREF="classes.php?class_id=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Class Name</TH>
				{foreach from=$classes_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?class_id={$data.class_id}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=true}">{$data.class_name}</TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=classes column=class_id value=$smarty.get.class_id return=classdata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Class<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="classes.php" CLASS="ContentLink">Return to listing</A> | <A HREF="classes.php?class_id=0" CLASS="ContentLink">New</A></DIV></DIV>

	<TABLE Class="ContentBox" width="500px">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="classes.php?class_id={$smarty.get.class_id}" METHOD="POST">
				<INPUT TYPE=HIDDEN NAME=class_id VALUE="{$smarty.get.class_id}">
				<INPUT TYPE=HIDDEN NAME=save VALUE=y>
				{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$classdata}
				<P>
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Class">
			</FORM>
		</TD></TR>
	</TABLE>
{/if}

