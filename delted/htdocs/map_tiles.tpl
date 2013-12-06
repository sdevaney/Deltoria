<HTML>
<BODY STYLE="padding: 0px; margin: 0px; background-color: #F5F5F5; color: #000000;">

<FORM ACTION=map_tiles.php STYLE="margin: 0px;">
<INPUT TYPE=TEXT NAME=search SIZE=15 VALUE="{$smarty.get.search}">
<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Search>
</FORM>

<DIV STYLE="overflow: auto; height: 500px;">
	<IMG SRC="images/tiles/blank.jpg" ONCLICK="setmaptile('images/tiles/blank.jpg',0);">
	{foreach from=$tiles item="data"}
		<IMG SRC="/images/tiles/{$data.Image}" ONCLICK="setmaptile('/images/tiles/{$data.Image}',{$data.TileID});">
	{/foreach}
</DIV>

<SCRIPT>
{literal}
	function setmaptile(tile,tileid) {
		parent.document.getElementById("TileID").value = tileid;
		parent.document.getElementById("Image").src = tile;
	}
{/literal}
</SCRIPT>



</BODY>
</HTML>
