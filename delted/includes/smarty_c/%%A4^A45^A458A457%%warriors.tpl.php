<?php /* Smarty version 2.6.9, created on 2011-09-23 00:25:00
         compiled from warriors.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'formtool_init', 'warriors.tpl', 10, false),array('function', 'cycle', 'warriors.tpl', 27, false),array('function', 'editor_get', 'warriors.tpl', 40, false),)), $this); ?>
<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<BODY>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./includes/logged_top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo smarty_function_formtool_init(array('src' => "/jscript/formtool.js"), $this);?>


<?php if ($_GET['WarriorID'] == ""): ?>
	<DIV CLASS="Title">Available Warriors</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a warrior from the list below or <A HREF="warriors.php?WarriorID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Warrior Name</TH>
				<TH CLASS="DataBox">Strength</TH>
				<TH CLASS="DataBox">Armor</TH>
				<TH CLASS="DataBox">Cost</TH>
				<TH CLASS="DataBox">Image</TH>
				<?php $_from = $this->_tpl_vars['warriors_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
					<TR>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><A HREF="<?php echo $this->_tpl_vars['self']; ?>
?WarriorID=<?php echo $this->_tpl_vars['data']['WarriorID']; ?>
" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Name']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Strength']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Armor']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Cost']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><IMG WIDTH="22" HEIGHT="14" SRC="http://www.deltoria.com/images/tiles/<?php echo $this->_tpl_vars['data']['Image']; ?>
"></TD>
					</TR>
				<?php endforeach; endif; unset($_from); ?>
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
<?php else: ?>
	<?php echo smarty_function_editor_get(array('table' => 'warriors','column' => 'WarriorID','value' => $_GET['WarriorID'],'return' => 'warriordata'), $this);?>


	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Warrior<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="warriors.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE>
		<TR><TD WIDTH=500>

			<TABLE Class="ContentBox" width="100%">
				<TR><TD CLASS="ContentBox">
					<FORM ACTION="warriors.php?WarriorID=<?php echo $_GET['WarriorID']; ?>
" METHOD="POST">
						<INPUT TYPE=HIDDEN NAME=WarriorID VALUE="<?php echo $_GET['WarriorID']; ?>
">
						<INPUT TYPE=HIDDEN NAME=save VALUE=y>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./includes/ed_section.tpl", 'smarty_include_vars' => array('section_data' => $this->_tpl_vars['section_data'],'editdata' => $this->_tpl_vars['warriordata'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						<P>
						<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Warrior">
					</FORM>
				</TD></TR>
			</TABLE>

		</TD><TD STYLE="padding-left: 10px;">
			<TABLE Class="ContentBox">
				<TR><TD CLASS="ContentBox">
					<TABLE><TR><TD CLASS=ContentBox>Selected Tile:</TD><TD><IMG WIDTH="32" HEIGHT="24" ID="TileImage" SRC="http://www.deltoria.com/images/tiles/<?php echo $this->_tpl_vars['tile_image']; ?>
"></TD></TR></TABLE>
					<HR STYLE="margin-bottom: 0px;">
					<IFRAME FRAMEBORDER=0 SRC="tile_picker.php?/*image_type=Actor&*/selected=<?php echo $this->_tpl_vars['eddata']['TileID']; ?>
&return_image=TileImage&return_id=TileID" WIDTH="160px" HEIGHT="300px"></IFRAME>
				</TD></TR>
			</TABLE>
		</TD></TR>
	</TABLE>
<?php endif; ?>