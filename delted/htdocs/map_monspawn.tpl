<HTML>
<HEAD>
<LINK rel="stylesheet" href="styles/default.css">
</HEAD>

<BODY>

{if $smarty.get.GroupID ne ""}
	<SCRIPT>
		parent.document.getElementById("GroupID").value = {$smarty.get.GroupID|default:0};
	</SCRIPT>
{/if}


{if $smarty.get.GroupID eq "0"}*{/if} <A HREF="map_monspawn.php?GroupID=0">None</A><BR>
{foreach from=$spawn_data item="pdata"}
	{if $pdata.GroupID eq $smarty.get.GroupID}*{/if} <A HREF="map_monspawn.php?GroupID={$pdata.GroupID}">{$pdata.Name}</A><BR>
{/foreach}

</BODY>
</HTML>
