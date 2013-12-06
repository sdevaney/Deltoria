<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

{include file="../../htdocs/includes/logged_top.tpl"}
{include file="../../htdocs/includes/administrator.tpl"}

{formtool_init src="/jscript/formtool.js"}

<FORM ACTION="general.php" METHOD="POST">
<INPUT TYPE=HIDDEN NAME="save" VALUE="y">

<DIV CLASS="Title">Game Data</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">

			Starting coordinates for new players.<BR>
			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">X</TH>
				<TH CLASS="DataBox">Y</TH>
				<TH CLASS="DataBox">Zone</TH>
				<TR>
					<TD CLASS="DataRow{cycle values='A,B' advance=false}"><INPUT TYPE=TEXT NAME="start_x" VALUE="{$gamedata.start_x}"></TD>
					<TD CLASS="DataRow{cycle values='A,B' advance=false}"><INPUT TYPE=TEXT NAME="start_y" VALUE="{$gamedata.start_y}"></TD>
					<TD CLASS="DataRow{cycle values='A,B' advance=true}">
					<SELECT NAME="start_zone_id">
					{foreach from=$zones item="zdata"}
					<OPTION VALUE="{$zdata.zone_id}" {if $zdata.zone_id eq $gamedata.start_zone_id}SELECTED{/if}>{$zdata.zone_name}</OPTION>
					{/foreach}
					</SELECT>
					</TD>
				</TR>
			</TABLE><P>

			Default skills. These are used for the default defence and the attack skill used when the player is carrying no weapon.
			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">Defence</TH>
				<TH CLASS="DataBox">Attack (Melee)</TH>
				<TR>
					<TD CLASS="DataRow{cycle values='A,B' advance=false}">
					<SELECT NAME="defence_skill_id">
					{foreach from=$skills item="sdata"}
					<OPTION VALUE="{$sdata.skill_id}" {if $sdata.skill_id eq $gamedata.defence_skill_id}SELECTED{/if}>{$sdata.skill_name}</OPTION>
					{/foreach}
					</SELECT>
					</TD>

					<TD CLASS="DataRow{cycle values='A,B' advance=false}">
					<SELECT NAME="attack_skill_id">
					{foreach from=$skills item="sdata"}
					<OPTION VALUE="{$sdata.skill_id}" {if $sdata.skill_id eq $gamedata.attack_skill_id}SELECTED{/if}>{$sdata.skill_name}</OPTION>
					{/foreach}
					</SELECT>
					</TD>
				</TR>
				<TR><TD COLSPAN=3><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Save></TD></TR>
			</TABLE><P>



			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>

</FORM>

