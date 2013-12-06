<HTML>
<BODY STYLE="margin: 0px; padding: 0px; background-color: #FFFFFF;">

<FONT COLOR ="#FF6600"><DIV STYLE="z-index: 5;position: absolute; top: 10; left: 10; font-size: 12px; font-weight: bold;" ID="xcoord">X</DIV>
<DIV STYLE="z-index: 5;position: absolute; top: 25; left: 10; font-size: 12px; font-weight: bold;" ID="ycoord">Y</DIV></FONT>


<SCRIPT>
	var onImage = false;
</SCRIPT>

<!-- Tiles -->
{assign var=numb value=0}
{foreach from=$zonedata item=map_y name=fheight}
{assign var=fwidth value=0}
{foreach from=$map_y item=map_x name=fwidth}
{assign var=numb value=$numb+1}
<IMG WIDTH="{$tile_width}" HEIGHT="{$tile_height}" SRC="/images/tiles/{$map_x.Image|default:'blank.jpg'}" STYLE="border: 0px; margin: 0px; padding: 0px; z-index: 1; position: absolute; top: {$smarty.foreach.fheight.iteration*$tile_height-$tile_height}px; left: {$smarty.foreach.fwidth.iteration*$tile_width-$tile_width}px;">
<IMG WIDTH="{$tile_width}" HEIGHT="{$tile_height}" ID="target_{$numb}" onmouseover="settarget({$numb},{$map_x.X},{$map_x.Y});" onmouseout="cleartarget({$numb});" onclick="setmap({$map_x.X},{$map_x.Y},{$map_x.MapID});" SRC="./images/clear.gif" style="z-index: 2; margin: 0px; padding: 0px; position: absolute; top: {$smarty.foreach.fheight.iteration*$tile_height-$tile_height}px; left: {$smarty.foreach.fwidth.iteration*$tile_width-$tile_width}px;">
<SPAN style="font-size: 10px; font-weight: bold; color: #FFFFFF; z-index: 3; margin: 0px; padding: 0px; position: absolute; top: {$smarty.foreach.fheight.iteration*$tile_height-$tile_height}px; left: {$smarty.foreach.fwidth.iteration*$tile_width-$tile_width}px;">{$map_x.Danger}%</SPAN>
{if $map_x.GroupID gt 0}<IMG SRC="./images/m.gif" STYLE="z-index: 3; margin: 0px; border: 0px; padding: 0px; position: absolute; top: {$smarty.foreach.fheight.iteration*$tile_height-13}px; left: {$smarty.foreach.fwidth.iteration*$tile_width-$tile_width}px;" OnClick="setgroup({$map_x.GroupID});return false;">{/if}
{if $map_x.PortalID gt 0}<IMG SRC="./images/p.gif" STYLE="z-index: 3; margin: 0px; border: 0px; padding: 0px; position: absolute; top: {$smarty.foreach.fheight.iteration*$tile_height-$tile_height+$tile_height-13}px; left: {$smarty.foreach.fwidth.iteration*$tile_width-$tile_width+$tile_width-13}px;" OnClick="setportal({$map_x.PortalID});return false;">{/if}
{/foreach}
<BR>
{/foreach}
<!-- End Tiles -->


<SCRIPT>
	{literal}
	function settarget(numb,x,y) {
		document.getElementById('target_' + numb).src = "./images/box.gif";
		document.getElementById('xcoord').innerHTML = "X: " + x;
		document.getElementById('ycoord').innerHTML = "Y: " + y;
	}

	function cleartarget(numb) {
		document.getElementById('target_' + numb).src = "./images/clear.gif";
	}
	
	function setmap(x,y,map_id) {
		if (parent.document.getElementById("Tile").checked == true) {
			parent.document.getElementById("MapView").src = "map_view.php?zoom={/literal}{$smarty.get.zoom}{literal}&set=y&set_x=" + x + "&set_y=" + y + "&set_map_id=" + map_id + "&brush=" + parent.document.getElementById("brush").value + "&X=" + parent.document.getElementById("X").value + "&Y=" + parent.document.getElementById("Y").value + "&MapID=" + parent.document.getElementById("MapID").value + "&TileID=" + parent.document.getElementById("TileID").value + "&Danger=" + parent.document.getElementById("Danger").value;
		} else if (parent.document.getElementById("Portal").checked == true) {
			parent.document.getElementById("MapView").src = "map_view.php?zoom={/literal}{$smarty.get.zoom}{literal}&set=y&set_x=" + x + "&set_y=" + y + "&set_map_id=" + map_id + "&X=" + parent.document.getElementById("X").value + "&Y=" + parent.document.getElementById("Y").value + "&zone_id=" + parent.document.getElementById("MapID").value + "&PortalID=" + parent.document.getElementById("PortalID").value;
		} else if (parent.document.getElementById("Spawn").checked == true) {
			parent.document.getElementById("MapView").src = "map_view.php?zoom={/literal}{$smarty.get.zoom}{literal}&set=y&set_x=" + x + "&set_y=" + y + "&set_map_id=" + map_id + "&X=" + parent.document.getElementById("X").value + "&Y=" + parent.document.getElementById("Y").value + "&MapID=" + parent.document.getElementById("MapID").value + "&GroupID=" + parent.document.getElementById("GroupID").value;
		} else if (parent.document.getElementById("Danger").checked == true) {
			parent.document.getElementById("MapView").src = "map_view.php?zoom={/literal}{$smarty.get.zoom}{literal}&set=y&set_x=" + x + "&set_y=" + y + "&set_map_id=" + map_id + "&X=" + parent.document.getElementById("X").value + "&Y=" + parent.document.getElementById("Y").value + "&MapID=" + parent.document.getElementById("MapID").value + "&Danger=" + parent.document.getElementById("Danger").value;
		}
	}

	function setportal(portal_id) {
		parent.document.getElementById("Action").value = "map_portal.php";
		parent.document.getElementById("Portal").checked = true;
		parent.document.getElementById("RightView").src = "map_portal.php?PortalID=" + portal_id;
	}

	function setgroup(spawn_id) {
		parent.document.getElementById("Action").value = "map_spawn.php";
		parent.document.getElementById("Spawn").checked = true;
		parent.document.getElementById("RightView").src = "map_spawn.php?GroupID=" + spawn_id;
	}
	{/literal}
</SCRIPT>

</BODY>
</HTML>

