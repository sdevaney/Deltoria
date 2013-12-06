<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>
<BODY>

{if $smarty.get.hideform != "1"}
<FORM ACTION=tile_picker.php STYLE="margin: 0px;">
	<INPUT TYPE=HIDDEN NAME=return_id VALUE="{$smarty.get.return_id}">
	<INPUT TYPE=HIDDEN NAME=image_type VALUE="{$smarty.get.image_type}">
	<INPUT TYPE=HIDDEN NAME=return_image VALUE="{$smarty.get.return_image}">
	<INPUT TYPE=TEXT NAME=search SIZE=10 VALUE="{$smarty.get.search}">
	<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Search>
</FORM>
{/if}

	<IMG WIDTH="32" HEIGHT="24" SRC="/images/tiles/blank.jpg" ONCLICK="setmaptile('/images/tiles/blank.jpg',0);">
	{foreach from=$tiles item="data"}
		<IMG WIDTH="32" HEIGHT="24" SRC="/images/tiles/{$data.Image}" ONCLICK="setmaptile('/images/tiles/{$data.Image}',{$data.TileID});">
	{/foreach}

<SCRIPT>
{literal}
	function setmaptile(tile,tileid) {
		parent.document.getElementById("{/literal}{$smarty.get.return_image}{literal}").src = tile;
		parent.document.getElementById("{/literal}{$smarty.get.return_id}{literal}").value = tileid;
	}
{/literal}
</SCRIPT>



</BODY>
</HTML>
