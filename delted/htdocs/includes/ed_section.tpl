<TABLE BORDER=0>
	{foreach from=$section_data item=data name=dsection}
		{if $smarty.foreach.dsection.first}<TR>{/if}
		{if $data eq "NEW"}
			</TR><TR>
		{elseif $data.edtype eq "HIDDEN"}
			<INPUT TYPE=HIDDEN ID="{$data.db_column}" NAME="{$data.db_column}" VALUE="{$editdata[$data.db_column]}">
		{else}
			{if $data.NEW ne "" and $data.title ne ""}
				</TR><TR>
				<TD COLSPAN="{$data.colspan}" STYLE="padding-top: 10px;"><DIV CLASS="Title">{$data.title}</DIV><IMG SRC="images/line_white.gif" WIDTH="100%" HEIGHT="1" STYLE="padding: 0px; margin-top: 0px;"><BR>{if $data.desc}{$data.desc}<P>{/if}</TD></TR>
				<TR>
			{else}
				<TD STYLE="padding-left: 5px;">{$data.label}:</TD>
				<TD COLSPAN="{$data.colspan|default:1}" ROWSPAN="{$data.rowspan|default:1}" STYLE="padding-left: 5px;">
				{if $data.edtype eq "CHECKBOX"}
					<INPUT NAME="{$data.db_column}" TYPE="CHECKBOX" VALUE="Y" {if $editdata[$data.db_column] eq "Y"}CHECKED{/if}>
				{elseif $data.edtype eq "DROPDOWN_SQL"}
					<SELECT {if $data.id}ID="{$data.id}"{/if} {if $data.onchange}OnChange="{$data.onchange}"{/if} NAME="{$data.db_column}">
						{if $data.blank_option}<OPTION VALUE="0">None Selected</OPTION>{/if}
						{sql_dropdown sql=$data.query key_column=$data.key_column value_column=$data.value_column selected=$editdata[$data.db_column]}
					</SELECT>
				{elseif $data.edtype eq "TEXTAREA"}
					<TEXTAREA STYLE="width: 100%;" NAME="{$data.db_column}" ROWS="{if $data.rows ne ""}{$data.rows}{else}{$data.rowspan|default:1}{/if}">{$editdata[$data.db_column]}</TEXTAREA>
				{elseif $data.edtype eq "DROPDOWN"}
					<SELECT STYLE="width: 100%;" {if $data.id}ID="{$data.id}"{/if} {if $data.onchange}OnChange="{$data.onchange}"{/if} NAME="{$data.db_column}">
						{optionsplit options=$data.options return="options"}
						{foreach from=$options item=optdata}
							{if count($optdata) eq 2}
								<OPTION VALUE="{$optdata.key}" {if $editdata[$data.db_column] eq $optdata.key}SELECTED{/if}>{$optdata.value}</OPTION>
							{else}
								<OPTION VALUE="{$optdata}" {if $editdata[$data.db_column] eq $optdata}SELECTED{/if}>{$optdata}</OPTION>
							{/if}
						{/foreach}
					</SELECT>
				{else}
					<INPUT TYPE=TEXT {if $data.size ne ""}SIZE="{$data.size|default:20}"{else}STYLE="width: 100%;"{/if} NAME="{$data.db_column}" ID="{$data.db_column}" VALUE="{$editdata[$data.db_column]}">
				{/if}
				</TD>
			{/if}
		{/if}
	{/foreach}
</TABLE>
