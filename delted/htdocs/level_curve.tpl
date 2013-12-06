<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="../../htdocs/includes/logged_top.tpl"}
//{include file="../../htdocs/includes/administrator.tpl"}

<TABLE BORDER=0>
<TR><TD>

<DIV CLASS="Title">Levels</DIV>
<TABLE Class="ContentBox" width="250">
	<TR><TD CLASS="ContentBox">
		<TABLE CLASS="DataBox" WIDTH="100%">
			<TH CLASS="DataBox">Level</TH>
			<TH CLASS="DataBox">XP</TH>
			{foreach from=$levels item=data}
				<tr>
					<td CLASS="DataRow{cycle values='A,B' advance=false}">{$data.level}</td>
					<td CLASS="DataRow{cycle values='A,B' advance=true}">{$data.xp|number_format}</d>
				</tr>
			{/foreach} 
		</TABLE>
		<DIV STYLE="text-align: right; margin-right: 10px;">
		    {$paginate.first}-{$paginate.last} out of {$paginate.total}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    {paginate_prev style="margin-right; 5px;"} {paginate_middle format="page" page_limit="5" style="margin-left: 5px; margin-right: 5px;" } {paginate_next style="margin-left: 5px;"}
		</DIV>	
	</TD></TR>
</TABLE>

</TD><TD STYLE="padding-left: 10px;">


<DIV CLASS="Title">Reset Curve</DIV>

<TABLE Class="ContentBox">
	<TR><TD CLASS="ContentBox">

		<FORM ACTION="level_curve.php" METHOD="GET">

		<TABLE CLASS="DataBox" WIDTH="100%">
			<TH CLASS="DataBox">XP Req for Lvl 2</TH>
			<TH CLASS="DataBox">Curve</TH>
			<TR><TD CLASS="DataRowA"><INPUT TYPE=TEXT NAME=start_xp VALUE=1500 MAXLENGTH=6></TD><TD><INPUT TYPE=TEXT NAME=reset_curve VALUE=1.05 MAXLENGTH=6></TD></TR>
			<TR><TD COLSPAN=2 CLASS="DataRowB" STYLE="text-align: right;">
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Reset Curve">
			</TD></TR>
		</TABLE>

		</FORM>
	</TD></TR>
</TABLE>


</BODY>
</HTML>
