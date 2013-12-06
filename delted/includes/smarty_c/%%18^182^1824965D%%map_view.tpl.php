<?php /* Smarty version 2.6.9, created on 2010-01-27 20:13:29
         compiled from map_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'map_view.tpl', 18, false),)), $this); ?>
<HTML>
<BODY STYLE="margin: 0px; padding: 0px; background-color: #FFFFFF;">

<FONT COLOR ="#FF6600"><DIV STYLE="z-index: 5;position: absolute; top: 10; left: 10; font-size: 12px; font-weight: bold;" ID="xcoord">X</DIV>
<DIV STYLE="z-index: 5;position: absolute; top: 25; left: 10; font-size: 12px; font-weight: bold;" ID="ycoord">Y</DIV></FONT>


<SCRIPT>
	var onImage = false;
</SCRIPT>

<!-- Tiles -->
<?php $this->assign('numb', 0);  $_from = $this->_tpl_vars['zonedata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fheight'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fheight']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['map_y']):
        $this->_foreach['fheight']['iteration']++;
 $this->assign('fwidth', 0);  $_from = $this->_tpl_vars['map_y']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fwidth'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fwidth']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['map_x']):
        $this->_foreach['fwidth']['iteration']++;
 $this->assign('numb', $this->_tpl_vars['numb']+1); ?>
<IMG WIDTH="<?php echo $this->_tpl_vars['tile_width']; ?>
" HEIGHT="<?php echo $this->_tpl_vars['tile_height']; ?>
" SRC="/images/tiles/<?php echo ((is_array($_tmp=@$this->_tpl_vars['map_x']['Image'])) ? $this->_run_mod_handler('default', true, $_tmp, 'blank.jpg') : smarty_modifier_default($_tmp, 'blank.jpg')); ?>
" STYLE="border: 0px; margin: 0px; padding: 0px; z-index: 1; position: absolute; top: <?php echo $this->_foreach['fheight']['iteration']*$this->_tpl_vars['tile_height']-$this->_tpl_vars['tile_height']; ?>
px; left: <?php echo $this->_foreach['fwidth']['iteration']*$this->_tpl_vars['tile_width']-$this->_tpl_vars['tile_width']; ?>
px;">
<IMG WIDTH="<?php echo $this->_tpl_vars['tile_width']; ?>
" HEIGHT="<?php echo $this->_tpl_vars['tile_height']; ?>
" ID="target_<?php echo $this->_tpl_vars['numb']; ?>
" onmouseover="settarget(<?php echo $this->_tpl_vars['numb']; ?>
,<?php echo $this->_tpl_vars['map_x']['X']; ?>
,<?php echo $this->_tpl_vars['map_x']['Y']; ?>
);" onmouseout="cleartarget(<?php echo $this->_tpl_vars['numb']; ?>
);" onclick="setmap(<?php echo $this->_tpl_vars['map_x']['X']; ?>
,<?php echo $this->_tpl_vars['map_x']['Y']; ?>
,<?php echo $this->_tpl_vars['map_x']['MapID']; ?>
);" SRC="./images/clear.gif" style="z-index: 2; margin: 0px; padding: 0px; position: absolute; top: <?php echo $this->_foreach['fheight']['iteration']*$this->_tpl_vars['tile_height']-$this->_tpl_vars['tile_height']; ?>
px; left: <?php echo $this->_foreach['fwidth']['iteration']*$this->_tpl_vars['tile_width']-$this->_tpl_vars['tile_width']; ?>
px;">
<SPAN style="font-size: 10px; font-weight: bold; color: #FFFFFF; z-index: 3; margin: 0px; padding: 0px; position: absolute; top: <?php echo $this->_foreach['fheight']['iteration']*$this->_tpl_vars['tile_height']-$this->_tpl_vars['tile_height']; ?>
px; left: <?php echo $this->_foreach['fwidth']['iteration']*$this->_tpl_vars['tile_width']-$this->_tpl_vars['tile_width']; ?>
px;"><?php echo $this->_tpl_vars['map_x']['Danger']; ?>
%</SPAN>
<?php if ($this->_tpl_vars['map_x']['GroupID'] > 0): ?><IMG SRC="./images/m.gif" STYLE="z-index: 3; margin: 0px; border: 0px; padding: 0px; position: absolute; top: <?php echo $this->_foreach['fheight']['iteration']*$this->_tpl_vars['tile_height']-13; ?>
px; left: <?php echo $this->_foreach['fwidth']['iteration']*$this->_tpl_vars['tile_width']-$this->_tpl_vars['tile_width']; ?>
px;" OnClick="setgroup(<?php echo $this->_tpl_vars['map_x']['GroupID']; ?>
);return false;"><?php endif;  if ($this->_tpl_vars['map_x']['PortalID'] > 0): ?><IMG SRC="./images/p.gif" STYLE="z-index: 3; margin: 0px; border: 0px; padding: 0px; position: absolute; top: <?php echo $this->_foreach['fheight']['iteration']*$this->_tpl_vars['tile_height']-$this->_tpl_vars['tile_height']+$this->_tpl_vars['tile_height']-13; ?>
px; left: <?php echo $this->_foreach['fwidth']['iteration']*$this->_tpl_vars['tile_width']-$this->_tpl_vars['tile_width']+$this->_tpl_vars['tile_width']-13; ?>
px;" OnClick="setportal(<?php echo $this->_tpl_vars['map_x']['PortalID']; ?>
);return false;"><?php endif;  endforeach; endif; unset($_from); ?>
<BR>
<?php endforeach; endif; unset($_from); ?>
<!-- End Tiles -->


<SCRIPT>
	<?php echo '
	function settarget(numb,x,y) {
		document.getElementById(\'target_\' + numb).src = "./images/box.gif";
		document.getElementById(\'xcoord\').innerHTML = "X: " + x;
		document.getElementById(\'ycoord\').innerHTML = "Y: " + y;
	}

	function cleartarget(numb) {
		document.getElementById(\'target_\' + numb).src = "./images/clear.gif";
	}
	
	function setmap(x,y,map_id) {
		if (parent.document.getElementById("Tile").checked == true) {
			parent.document.getElementById("MapView").src = "map_view.php?zoom=';  echo $_GET['zoom'];  echo '&set=y&set_x=" + x + "&set_y=" + y + "&set_map_id=" + map_id + "&brush=" + parent.document.getElementById("brush").value + "&X=" + parent.document.getElementById("X").value + "&Y=" + parent.document.getElementById("Y").value + "&MapID=" + parent.document.getElementById("MapID").value + "&TileID=" + parent.document.getElementById("TileID").value + "&Danger=" + parent.document.getElementById("Danger").value;
		} else if (parent.document.getElementById("Portal").checked == true) {
			parent.document.getElementById("MapView").src = "map_view.php?zoom=';  echo $_GET['zoom'];  echo '&set=y&set_x=" + x + "&set_y=" + y + "&set_map_id=" + map_id + "&X=" + parent.document.getElementById("X").value + "&Y=" + parent.document.getElementById("Y").value + "&zone_id=" + parent.document.getElementById("MapID").value + "&PortalID=" + parent.document.getElementById("PortalID").value;
		} else if (parent.document.getElementById("Spawn").checked == true) {
			parent.document.getElementById("MapView").src = "map_view.php?zoom=';  echo $_GET['zoom'];  echo '&set=y&set_x=" + x + "&set_y=" + y + "&set_map_id=" + map_id + "&X=" + parent.document.getElementById("X").value + "&Y=" + parent.document.getElementById("Y").value + "&MapID=" + parent.document.getElementById("MapID").value + "&GroupID=" + parent.document.getElementById("GroupID").value;
		} else if (parent.document.getElementById("Danger").checked == true) {
			parent.document.getElementById("MapView").src = "map_view.php?zoom=';  echo $_GET['zoom'];  echo '&set=y&set_x=" + x + "&set_y=" + y + "&set_map_id=" + map_id + "&X=" + parent.document.getElementById("X").value + "&Y=" + parent.document.getElementById("Y").value + "&MapID=" + parent.document.getElementById("MapID").value + "&Danger=" + parent.document.getElementById("Danger").value;
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
	'; ?>

</SCRIPT>

</BODY>
</HTML>
