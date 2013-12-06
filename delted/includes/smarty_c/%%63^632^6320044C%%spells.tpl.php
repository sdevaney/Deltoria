<?php /* Smarty version 2.6.9, created on 2010-01-30 17:29:18
         compiled from spells.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'formtool_init', 'spells.tpl', 10, false),array('function', 'cycle', 'spells.tpl', 23, false),array('function', 'editor_get', 'spells.tpl', 32, false),)), $this); ?>
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


<?php if ($_GET['SpellID'] == ""): ?>
	<DIV CLASS="Title">Available Spells</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a spell from the list below or <A HREF="spells.php?SpellID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Spell Name</TH>
				<?php $_from = $this->_tpl_vars['spells_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
					<TR>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><A HREF="<?php echo $this->_tpl_vars['self']; ?>
?SpellID=<?php echo $this->_tpl_vars['data']['SpellID']; ?>
" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => true), $this);?>
"><?php echo $this->_tpl_vars['data']['Name']; ?>
</TD>
					</TR>
				<?php endforeach; endif; unset($_from); ?>
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
<?php else: ?>
	<?php echo smarty_function_editor_get(array('table' => 'spells','column' => 'SpellID','value' => $_GET['SpellID'],'return' => 'spelldata'), $this);?>


	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Spell<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="spells.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE Class="ContentBox" width="100%">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="spells.php?SpellID=<?php echo $_GET['SpellID']; ?>
" METHOD="POST">
				<INPUT TYPE=HIDDEN NAME=SpellID VALUE="<?php echo $_GET['SpellID']; ?>
">
				<INPUT TYPE=HIDDEN NAME=save VALUE=y>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./includes/ed_section.tpl", 'smarty_include_vars' => array('section_data' => $this->_tpl_vars['section_data'],'editdata' => $this->_tpl_vars['spelldata'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<P>
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Spell">
			</FORM>
		</TD></TR>
	</TABLE>

<?php endif; ?>
