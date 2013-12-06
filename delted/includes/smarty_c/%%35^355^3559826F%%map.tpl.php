<?php /* Smarty version 2.6.9, created on 2010-01-27 20:13:28
         compiled from map.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'map.tpl', 17, false),array('modifier', 'truncate', 'map.tpl', 28, false),)), $this); ?>
<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY >

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./includes/logged_top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<TABLE>
	<TR><TD>

		<FORM STYLE="margin: 0px;">
			<TABLE WIDTH="100%">
				<TH>X</TH><TH>Y</TH><TH>Zone</TH><TH>Zoom Out</TH><TH>Brush</TH><TH>Danger</TH><TH>&nbsp;</TH><TH ROWSPAN="2" WIDTH="100%" STYLE="background-color: #F5F5F5; text-align: right;"><IMG ID="Image" SRC="../images/tiles/grass.jpg"></TH>
				<TR>
					<TD><INPUT TYPE="TEXT" NAME="X" ID="X" SIZE=3 VALUE="<?php echo ((is_array($_tmp=@$_GET['X'])) ? $this->_run_mod_handler('default', true, $_tmp, 311) : smarty_modifier_default($_tmp, 311)); ?>
"></TD>
					<TD><INPUT TYPE="TEXT" NAME="Y" ID="Y" SIZE=3 VALUE="<?php echo ((is_array($_tmp=@$_GET['Y'])) ? $this->_run_mod_handler('default', true, $_tmp, 311) : smarty_modifier_default($_tmp, 311)); ?>
"></TD>
					<TD><SELECT ID="MapID" NAME="MapID"><?php $_from = $this->_tpl_vars['zones']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['zdata']):
?><OPTION VALUE="<?php echo $this->_tpl_vars['zdata']['MapID']; ?>
" <?php if ($_GET['MapID'] == $this->_tpl_vars['zdata']['MapID']): ?>SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['zdata']['Name']; ?>
</OPTION><?php endforeach; endif; unset($_from); ?></SELECT></TD>
					<TD><INPUT ID="zoom" NAME="zoom" TYPE="CHECKBOX" VALUE="0" ONCLICK="zoomclick()"></TD>
					<TD nowrap><SELECT ID="brush" NAME="brush"><OPTION VALUE="1">1</OPTION><OPTION VALUE="2">2</OPTION><OPTION VALUE="3">3</OPTION><OPTION VALUE="4">4</OPTION><OPTION VALUE="5">5</OPTION><OPTION VALUE="6">6</OPTION></SELECT></TD>
					<TD><INPUT TYPE="TEXT" NAME="Danger" ID="Danger" SIZE=3 VALUE="<?php echo ((is_array($_tmp=@$_GET['Danger'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
"></TD>

					<TD><A HREF="#" ONCLICK="void loadmap();">Go</A></TD>
				</TR>
			</TABLE>

			<SELECT NAME=PortalID ID=PortalID STYLE="width: 100%; display: none;"><OPTION VALUE="0">None</OPTION><?php $_from = $this->_tpl_vars['portals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pdata']):
?><OPTION VALUE="<?php echo $this->_tpl_vars['pdata']['PortalID']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['pdata']['Name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 12) : smarty_modifier_truncate($_tmp, 12)); ?>
</OPTION><?php endforeach; endif; unset($_from); ?></SELECT>
			<SELECT NAME=GroupID ID=GroupID STYLE="width: 100%; display: none;"><OPTION VALUE="0">None</OPTION><?php $_from = $this->_tpl_vars['spawns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sdata']):
?><OPTION VALUE="<?php echo $this->_tpl_vars['sdata']['GroupID']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['sdata']['Name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 12) : smarty_modifier_truncate($_tmp, 12)); ?>
</OPTION><?php endforeach; endif; unset($_from); ?></SELECT>
			<INPUT TYPE="HIDDEN" NAME="M_X">
			<INPUT TYPE="HIDDEN" NAME="M_Y">
			<SELECT NAME=Action ID=Action STYLE="width: 100%; display: none;">
			<OPTION VALUE="map_tiles.php">Tiles</OPTION>
			<OPTION VALUE="map_portal.php">Portals</OPTION>
			<OPTION VALUE="map_spawn.php">Spawns</OPTION>
			//<OPTION VALUE="map_npcspawn.php">NPC</OPTION>
			</SELECT>
			<INPUT TYPE="HIDDEN" ID="TileID" NAME="TileID" VALUE="11">
		</FORM>
	
		<IFRAME ID="MapView" SRC="map_view.php?X=<?php echo $_GET['X']; ?>
&Y=<?php echo $_GET['Y']; ?>
&MapID=<?php echo $_GET['MapID']; ?>
" WIDTH="576" HEIGHT="432" SCROLLING="NO" FRAMEBORDER=0></IFRAME>
		<P>

		<TABLE BORDER=0>
			<TR>
				<TD>&nbsp;</TD>
				<TD><A HREF="#" ONCLICK="void move_up();"><IMG SRC="./images/navigation_n.gif" BORDER=0></A></TD>
				<TD>&nbsp;</TD>
			</TR><TR>
				<TD><A HREF="#" ONCLICK="void move_left();"><IMG SRC="./images/navigation_w.gif" BORDER=0></A></TD>
				<TD><IMG SRC="./images/navigation.gif"></TD>
				<TD><A HREF="#" ONCLICK="void move_right();"><IMG SRC="./images/navigation_e.gif" BORDER=0></A></TD>
			</TR><TR>
				<TD>&nbsp;</TD>
				<TD <A HREF="#" ONCLICK="void move_down();"><IMG SRC="./images/navigation_s.gif" BORDER=0></A></TD>
				<TD>&nbsp;</TD>
			</TR>
		</TABLE>

		

	</TD><TD>
		<FORM STYLE="margin: 0px;">
			<INPUT TYPE=RADIO ID="Tile" ONCLICK="get_right('map_tiles.php');" NAME="RightOpt" ID="RightOpt" CHECKED> Tile 
			<INPUT TYPE=RADIO ID="Portal" ONCLICK="get_right('map_portal.php');" NAME="RightOpt" ID="RightOpt" VALUE="Portal"> Portal
			<INPUT TYPE=RADIO ID="Spawn" ONCLICK="get_right('map_spawn.php');" NAME="RightOpt" ID="RightOpt"> Monster
			<INPUT TYPE=RADIO ID="Danger" ONCLICK="get_right('map_danger.php');" NAME="RightOpt" ID="RightOpt"> Danger
		</FORM>
		
		<IFRAME ID="RightView" SRC="map_tiles.php" WIDTH="220" HEIGHT="600" FRAMEBORDER=0 STYLE="margin-left: 5px;">
		</IFRAME>

	</TD></TR>
</TABLE>


<SCRIPT>
	<?php echo '

	function get_right(URL) {
		document.getElementById("RightView").src = URL;
		document.getElementById("Action").value = URL;
	}

	function loadmap() {
		document.getElementById("MapView").src = "map_view.php?zoom=" + document.getElementById("zoom").value + "&X=" + document.getElementById("X").value + "&Y=" + document.getElementById("Y").value + "&MapID=" + document.getElementById("MapID").value
	}

	function move_up() {
		document.getElementById("Y").value = parseInt(document.getElementById("Y").value) - 3;
		loadmap();
	}

	function move_down() {
		document.getElementById("Y").value = parseInt(document.getElementById("Y").value) + 3;
		loadmap();
	}

	function move_left() {
		document.getElementById("X").value = parseInt(document.getElementById("X").value) - 3;
		loadmap();
	}

	function move_right() {
		document.getElementById("X").value = parseInt(document.getElementById("X").value) + 3;
		loadmap();
	}
	function zoomclick() {
		if (document.getElementById("zoom").value == 1) {
			document.getElementById("zoom").value = 0;
		} else {
			document.getElementById("zoom").value = 1;
		}
	}

	'; ?>

</SCRIPT>

</BODY>
</HTML>