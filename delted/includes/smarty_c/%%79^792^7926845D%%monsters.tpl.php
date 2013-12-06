<?php /* Smarty version 2.6.9, created on 2010-01-28 09:28:08
         compiled from monsters.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'formtool_init', 'monsters.tpl', 10, false),array('function', 'cycle', 'monsters.tpl', 28, false),array('function', 'editor_get', 'monsters.tpl', 42, false),array('modifier', 'number_format', 'monsters.tpl', 31, false),)), $this); ?>
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


<?php if ($_GET['MonsterID'] == ""): ?>
	<DIV CLASS="Title">Available Monsters</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a monster from the list below or <A HREF="monsters.php?MonsterID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Monster Name</TH>
				<TH CLASS="DataBox">Hostile</TH>
				<TH CLASS="DataBox">XP</TH>
				<TH CLASS="DataBox">Level</TH>
				<TH CLASS="DataBox">Poison</TH>
				<TH CLASS="DataBox">Image</TH>
				<?php $_from = $this->_tpl_vars['monsters_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
					<TR>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><A HREF="<?php echo $this->_tpl_vars['self']; ?>
?MonsterID=<?php echo $this->_tpl_vars['data']['MonsterID']; ?>
" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Name']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Hostile']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['XP'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['Level'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Poison']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><IMG WIDTH="22" HEIGHT="14" SRC="/images/tiles/<?php echo $this->_tpl_vars['data']['Image']; ?>
"></TD>
					</TR>
				<?php endforeach; endif; unset($_from); ?>
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
<?php else: ?>
	<?php echo smarty_function_editor_get(array('table' => 'monster_base','column' => 'MonsterID','value' => $_GET['MonsterID'],'return' => 'monsterdata'), $this);?>


	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Monster<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="monsters.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE>
		<TR><TD WIDTH=500>

			<TABLE Class="ContentBox" width="100%">
				<TR><TD CLASS="ContentBox">
					<FORM ACTION="monsters.php?MonsterID=<?php echo $_GET['MonsterID']; ?>
" METHOD="POST">
						<INPUT TYPE=HIDDEN NAME=MonsterID VALUE="<?php echo $_GET['MonsterID']; ?>
">
						<INPUT TYPE=HIDDEN NAME=save VALUE=y>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./includes/ed_section.tpl", 'smarty_include_vars' => array('section_data' => $this->_tpl_vars['section_data'],'editdata' => $this->_tpl_vars['monsterdata'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						<P>
						<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Monster">
					</FORM>
				</TD></TR>
			</TABLE>

		</TD><TD STYLE="padding-left: 10px;">
			<TABLE Class="ContentBox">
				<TR><TD CLASS="ContentBox">
					<TABLE><TR><TD CLASS=ContentBox>Selected Tile:</TD><TD><IMG WIDTH="32" HEIGHT="24" ID="TileImage" SRC="/images/tiles/<?php echo $this->_tpl_vars['tile_image']; ?>
"></TD></TR></TABLE>
					<HR STYLE="margin-bottom: 0px;">
					<IFRAME FRAMEBORDER=0 SRC="tile_picker.php?/*image_type=Actor&*/selected=<?php echo $this->_tpl_vars['eddata']['TileID']; ?>
&return_image=TileImage&return_id=TileID" WIDTH="160px" HEIGHT="300px"></IFRAME>
				</TD></TR>
			</TABLE>
		</TD></TR>
	</TABLE>
<?php endif; ?>