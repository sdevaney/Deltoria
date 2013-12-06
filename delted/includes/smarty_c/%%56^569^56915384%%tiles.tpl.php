<?php /* Smarty version 2.6.9, created on 2010-01-27 20:19:36
         compiled from tiles.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'addsection', 'tiles.tpl', 10, false),array('function', 'editor_save', 'tiles.tpl', 17, false),array('function', 'cycle', 'tiles.tpl', 69, false),array('function', 'paginate_prev', 'tiles.tpl', 80, false),array('function', 'paginate_middle', 'tiles.tpl', 80, false),array('function', 'paginate_next', 'tiles.tpl', 80, false),array('function', 'editor_get', 'tiles.tpl', 86, false),array('modifier', 'default', 'tiles.tpl', 74, false),)), $this); ?>
<HTML>
<HEAD>
<LINK rel="stylesheet" href="styles/default.css">
</HEAD>

<BODY>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./includes/logged_top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo smarty_function_addsection(array('label' => 'Name','db_column' => 'Name','edtype' => 'TEXT','size' => '25'), $this);?>

<?php echo smarty_function_addsection(array('label' => 'Keyword','db_column' => 'Keywords','edtype' => 'TEXT','size' => '25'), $this);?>

<?php echo smarty_function_addsection(array('NEW' => '1'), $this);?>

<?php echo smarty_function_addsection(array('label' => 'Walkable','db_column' => 'Walkable','edtype' => 'CHECKBOX'), $this);?>

<?php echo smarty_function_addsection(array('label' => 'Type','db_column' => 'ImageType','edtype' => 'DROPDOWN','options' => "Map;Object;Actor;Item;NPC;Monster;NewTiles;Building;Special"), $this);?>

<?php echo smarty_function_addsection(array('NEW' => '1'), $this);?>

<?php if ($_POST['save'] == 'y'): ?>
	<?php echo smarty_function_editor_save(array('sections' => $this->_tpl_vars['section_data'],'table' => 'tiledata','column' => 'TileID','value' => $_GET['TileID']), $this);?>

	<script>
		window.location = "tiles.php?TileID=<?php echo $_GET['TileID']; ?>
";
	</script>
<?php endif; ?>


<?php if ($_GET['TileID'] == '0'): ?>
	<FORM ACTION="tiles.php" METHOD="POST" ENCTYPE="multipart/form-data">
	<INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="2000000">
	<INPUT TYPE=HIDDEN NAME="new" VALUE="y">
	Filename: <INPUT NAME='userfile' TYPE='file' SIZE=25><BR>
	Walkable: <INPUT TYPE="CHECKBOX" VALUE="Y" NAME="Walkable" CHECKED><BR>
	Image Type: <SELECT NAME="ImageType"><OPTION VALUE="Map">Map</OPTION><OPTION VALUE="Object">Object</OPTION><OPTION VALUE="Actor">Actor</OPTION><OPTION VALUE="Item">Item</OPTION><OPTION VALUE = "NPC">NPC</OPTION><OPTION VALUE="Monster">Monster</OPTION><OPTION VALUE="NewTiles">NewTiles</OPTION><OPTION VALUE="Building">Building</OPTION><OPTION VALUE="Special">Special</OPTION></SELECT><BR>
	<DIV STYLE="text-align: right;"><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Create Tile"></DIV>
	</FORM>
<?php endif; ?>


<?php if ($_GET['TileID'] == ""): ?>

	<DIV CLASS="Title">Available Tiles</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="tiles.php">
				<SELECT NAME="filter">
					<OPTION VALUE="" <?php if ($_GET['filter'] == ""): ?>SELECTED<?php endif; ?>>None</OPTION>
					<OPTION VALUE="Map" <?php if ($_GET['filter'] == 'Map'): ?>SELECTED<?php endif; ?>>Map</OPTION>
					<OPTION VALUE="Object" <?php if ($_GET['filter'] == 'Object'): ?>SELECTED<?php endif; ?>>Object</OPTION>
					<OPTION VALUE="Actor" <?php if ($_GET['filter'] == 'Actor'): ?>SELECTED<?php endif; ?>>Actor</OPTION>
					<OPTION VALUE="Item" <?php if ($_GET['filter'] == 'Item'): ?>SELECTED<?php endif; ?>>Item</OPTION>
					<OPTION VALUE="NPC" <?php if ($_GET['filter'] == 'NPC'): ?>SELECTED<?php endif; ?>>NPC</OPTION>
					<OPTION VALUE="Monster" <?php if ($_GET['filter'] == 'Monster'): ?>SELECTED<?php endif; ?>>Monster</OPTION>
					<OPTION VALUE="NewTiles" <?php if ($_GET['filter'] == 'NewTiles'): ?>SELECTED<?php endif; ?>>NewTiles</OPTION>
					<OPTION VALUE="Building" <?php if ($_GET['filter'] == 'Building'): ?>SELECTED<?php endif; ?>>Building</OPTION>
					<OPTION VALUE="Special" <?php if ($_GET['filter'] == 'Special'): ?>SELECTED<?php endif; ?>>Special</OPTION>
				</SELECT>
				<INPUT TYPE='TEXT' NAME='filtkey' SIZE=10 />
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Filter">
			</FORM>

			Select a title from the list below or <A HREF="tiles.php?TileID=0" CLASS="ContentLink">create a new one</A>
			<P>
			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Image</TH>
				<TH CLASS="DataBox">Name</TH>
				<TH CLASS="DataBox">Keywords</TH>
				<TH CLASS="DataBox">Type</TH>
				<TH CLASS="DataBox">Walkable</TH>
				<?php $_from = $this->_tpl_vars['page_tiles_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
					<tr>
						<td CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><A HREF="tiles.php?TileID=<?php echo $this->_tpl_vars['data']['TileID']; ?>
"><IMG BORDER=0 WIDTH="30" HEIGHT="30" SRC="/images/tiles/<?php echo $this->_tpl_vars['data']['Image']; ?>
"></A></td>
						<td CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><A HREF="tiles.php?TileID=<?php echo $this->_tpl_vars['data']['TileID']; ?>
"><?php echo $this->_tpl_vars['data']['Image']; ?>
</A></td>
						<td CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Name']; ?>
</td>
						<td CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Keywords']; ?>
</d>
						<td CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['ImageType']; ?>
</d>
						<td CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => true), $this);?>
"><?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['Walkable'])) ? $this->_run_mod_handler('default', true, $_tmp, 'N') : smarty_modifier_default($_tmp, 'N')); ?>
</d>
					</tr>
				<?php endforeach; endif; unset($_from); ?> 
			</TABLE>
			<DIV STYLE="text-align: right; margin-right: 10px;">
			    <?php echo $this->_tpl_vars['paginate']['first']; ?>
-<?php echo $this->_tpl_vars['paginate']['last']; ?>
 out of <?php echo $this->_tpl_vars['paginate']['total']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    <?php echo smarty_function_paginate_prev(array('style' => "margin-right; 5px;"), $this);?>
 <?php echo smarty_function_paginate_middle(array('format' => 'page','page_limit' => '5','style' => "margin-left: 5px; margin-right: 5px;"), $this);?>
 <?php echo smarty_function_paginate_next(array('style' => "margin-left: 5px;"), $this);?>

			</DIV>	
		</TD></TR>
	</TABLE>

<?php elseif ($_GET['TileID'] > '0'): ?>
	<?php echo smarty_function_editor_get(array('table' => 'tiledata','column' => 'TileID','value' => $_GET['TileID'],'return' => 'tiledata'), $this);?>

		<FORM ACTION="tiles.php?TileID=<?php echo $_GET['TileID']; ?>
" METHOD="POST">
		<INPUT TYPE=HIDDEN NAME="TileID" VALUE="<?php echo $_GET['TileID']; ?>
">
		<INPUT TYPE=HIDDEN NAME="save" VALUE="y">

		<?php if ($_GET['del_auth'] > '0'): ?>
			Are you sure? <A HREF="tiles.php?delete=<?php echo $_GET['TileID']; ?>
">Yes Delete this tile</A><HR>
		<?php else: ?>
			<A HREF="tiles.php?TileID=<?php echo $_GET['TileID']; ?>
&del_auth=<?php echo $_GET['TileID']; ?>
">Delete this tile</A> <?php if ($this->_tpl_vars['in_use'] > '0'): ?>(<b>NOTICE - This tile is in use!</b>)<?php endif; ?><HR>
		<?php endif; ?>

		<DIV CLASS="Title">Modify / Add a Tile</DIV>
		<IMG SRC="images/line_white.gif" WIDTH="100%" HEIGHT="1" STYLE="padding: 0px; margin-top: 0px;"><BR>
		<IMG BORDER=0 WIDTH="30" HEIGHT="30" SRC="/images/tiles/<?php echo $this->_tpl_vars['tiledata']['Image']; ?>
"><BR>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./includes/ed_section.tpl", 'smarty_include_vars' => array('section_data' => $this->_tpl_vars['section_data'],'editdata' => $this->_tpl_vars['tiledata'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	
		<BR>
		<DIV STYLE="TEXT-ALIGN: LEFT;"><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Tile"></DIV>

		</FORM>
		(This tile is used <?php echo $this->_tpl_vars['in_use']; ?>
 times)<BR>
		<?php $_from = $this->_tpl_vars['locations']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ldata']):
?>
			<A HREF="map.php?X=<?php echo $this->_tpl_vars['ldata']['X']; ?>
&Y=<?php echo $this->_tpl_vars['ldata']['Y']; ?>
&MapID=<?php echo $this->_tpl_vars['ldata']['MapID']; ?>
"><?php echo $this->_tpl_vars['ldata']['X']; ?>
, <?php echo $this->_tpl_vars['ldata']['Y']; ?>
 : <?php echo $this->_tpl_vars['ldata']['MapID']; ?>
</A><BR>
		<?php endforeach; endif; unset($_from); ?>

	<?php endif; ?>

</TD></TR>
</TABLE>

</BODY>
</HTML>