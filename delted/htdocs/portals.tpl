<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="./includes/logged_top.tpl"}

{formtool_init src="/jscript/formtool.js"}

{if $smarty.get.PortalID eq ""}
	<DIV CLASS="Title">Available Portals</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a portal from the list below or <A HREF="portals.php?PortalID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Portal Name</TH>
				<TH CLASS="DataBox">X</TH>
				<TH CLASS="DataBox">Y</TH>
				<TH CLASS="DataBox">MapID</TH>
				<TH CLASS="DataBox">Zone</TH>
				<TH CLASS="DataBox">Level</TH>
				<TH CLASS="DataBox">Subscriber</TH>
				<TH CLASS="DataBox">Comments</TH>
				{foreach from=$portals_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?PortalID={$data.PortalID}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.TargetX}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.TargetY}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.TargetMapID}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.zone_name}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Level}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=true}">{$data.Subscriber}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.Comments}</TD>
					</TR>
				{/foreach}
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
{else}
	{editor_get table=portals column=PortalID value=$smarty.get.PortalID return=portaldata}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Portal<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="portals.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="portals.php?PortalID={$smarty.get.PortalID}" METHOD="POST">
				<INPUT TYPE=HIDDEN NAME=PortalID VALUE="{$smarty.get.PortalID}">
				<INPUT TYPE=HIDDEN NAME=save VALUE=y>
				{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$portaldata}
				<P>
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Portal">
			</FORM>
		</TD></TR>
	</TABLE>

{/if}

