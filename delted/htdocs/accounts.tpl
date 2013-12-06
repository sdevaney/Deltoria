<HTML>
<HEAD>
<LINK rel="stylesheet" href="./styles/default.css">
</HEAD>

<BODY ONLOAD="void loadmap();">

{include file="../../htdocs/includes/logged_top.tpl"}
{include file="../../htdocs/includes/administrator.tpl"}

{formtool_init src="./jscript/formtool.js"}

{addsection label="Email" db_column="email" edtype="TEXT"}
{addsection label="Subscriber" db_column="subscriber" edtype="CHECKBOX" size="10"}
{addsection NEW="1"}
{addsection label="Sub Expiration" db_column="fund_date" edtype="TEXT"}
{addsection label="Locked" db_column="locked" edtype="TEXT" size="10"}
{addsection NEW="1"}
{addsection label="Authorized" db_column="authorized" edtype="CHECKBOX"}
{addsection label="Verify" db_column="verify" edtype="TEXT"}
{addsection NEW="1"}
{addsection label="Last Accessed" db_column="last_accessed" edtype="TEXT"}
{addsection label="IP" db_column="ip_number_full" locked=true edtype="TEXT"}
{addsection NEW="1"}
{addsection label="Administrator" db_column="administrator" edtype="CHECKBOX"}
{addsection label="Manager" db_column="manager" edtype="CHECKBOX"}

{if $smarty.post.save eq "y"}
	{editor_save sections=$section_data table=users_base column=user_id value=$smarty.get.user_id}
{/if}


{if $smarty.get.user_id eq ""}
	<DIV CLASS="Title">Available Accounts</DIV>

	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a account from the list below<P>

			<TABLE CLASS="DataBox" STYLE="width: 99%;">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Account Name</TH>
				<TH CLASS="DataBox">Subscriber</TH>
				<TH CLASS="DataBox">Administrator</TH>
				<TH CLASS="DataBox">IP Address</TH>

				{foreach from=$accounts_list item=data}
					<TR>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}"><A HREF="{$self}?user_id={$data.user_id}" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.email}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.subscriber}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=false}">{$data.administrator}</TD>
						<TD CLASS="DataRow{cycle values='A,B' advance=true}">{$data.ip_number_full}</TD>
					</TR>
				{/foreach}
			</TABLE><P>

			User text here.

		</TD></TR>
	</TABLE>
{else}
	{if $smarty.get.user_id gt "0"} {editor_get table=users_base column=user_id value=$smarty.get.user_id return=eddata} {/if}

	<DIV CLASS="Title" STYLE="width: 500px;">Editing an Account<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="accounts.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE><TR><TD>

	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">

		<TABLE><TR><TD>
		
		<FORM ACTION="accounts.php?user_id={$smarty.get.user_id}" METHOD="POST">
			<INPUT TYPE=HIDDEN NAME=user_id VALUE="{$smarty.get.user_id}">
			<INPUT TYPE=HIDDEN NAME=save VALUE=y>
			{include file="./includes/ed_section.tpl" section_data=$section_data editdata=$eddata}
			<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Account">
		</FORM>

		</TD><TD STYLE="padding-left: 5px;">
		<U>Players</U><BR>
		{foreach from=$players item=pdata}
			<A HREF="players.php?player_id={$pdata.player_id}">{$pdata.player_name}</A><br>
		{foreachelse}
			None
		{/foreach}
		</TD></TR>

		<TR><TD COLSPAN=2><HR>
		{if $pass_change}<B>Note:</B> Password reset successfully!<P>{/if}
		<FORM ACTION="accounts.php?user_id={$smarty.get.user_id}" METHOD=POST>
		<TABLE BORDER=0>
		<TR><TD><B>New Password</B></TD><TD><B>Verify Password</B></TD></TR>
		<TR>
			<TD><INPUT TYPE=PASSWORD NAME=NewP></TD>
			<TD><INPUT TYPE=PASSWORD NAME=NewV></TD>
		</TR>
		</TABLE>
		<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Reset Password">
		</FORM>


		</TD></TR>


		</TABLE>

	</TABLE>

{/if}


</BODY>
</HTML>
