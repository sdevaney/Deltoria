<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="./includes/logged_top.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.FrontID eq ""}
	<DIV CLASS="Title">Available News</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select news from the list below or <A HREF="news.php?FrontID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Name</TH>
				<TH CLASS="DataBox">Date</TH>
				{foreach from=$news_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?FrontID={$data.FrontID}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=true}">{$data.NewsDate}</TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=frontnews column=FrontID value=$smarty.get.FrontID return=newsdata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing News<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="news.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE>
		<TR><TD WIDTH=500>

			<TABLE Class="ContentBox" width="100%">
				<TR><TD CLASS="ContentBox">
					<FORM ACTION="news.php?FrontID={$smarty.get.FrontID}" METHOD="POST">
						<INPUT TYPE=HIDDEN NAME=FrontID VALUE="{$smarty.get.FrontID}">
						<INPUT TYPE=HIDDEN NAME=save VALUE=y>
						{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$newsdata}
						<P>
						<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this News">
					</FORM>
				</TD></TR>
			</TABLE>
		</TD></TR>
	</TABLE>
{/if}

