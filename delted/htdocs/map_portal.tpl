<HTML>
<HEAD>
<LINK rel="stylesheet" href="styles/default.css">
</HEAD>

<BODY>

{if $smarty.get.PortalID ne ""}
	<SCRIPT>
		parent.document.getElementById("PortalID").value = {$smarty.get.PortalID};
	</SCRIPT>
{/if}

{if $smarty.get.PortalID eq "0"}*{/if} <A HREF="map_portal.php?PortalID=0">None</A><BR>
{foreach from=$portal_data item="pdata"}
	{if $pdata.PortalID eq $smarty.get.PortalID}*{/if} <A HREF="map_portal.php?PortalID={$pdata.PortalID}">{$pdata.Name}</A><BR>
{/foreach}

</BODY>
</HTML>
