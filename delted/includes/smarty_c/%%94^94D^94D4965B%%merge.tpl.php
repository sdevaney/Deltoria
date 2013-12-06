<?php /* Smarty version 2.6.9, created on 2010-01-27 21:54:39
         compiled from merge.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'formtool_init', 'merge.tpl', 10, false),array('function', 'cycle', 'merge.tpl', 25, false),array('function', 'editor_get', 'merge.tpl', 36, false),)), $this); ?>
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

<?php echo smarty_function_formtool_init(array('src' => "./jscript/formtool.js"), $this);?>


<?php if ($_GET['MergeID'] == ""): ?>
	<DIV CLASS="Title">Available Items</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a merge group from the list below or <A HREF="merge.php?MergeID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Item A</TH>
				<TH CLASS="DataBox">Item B</TH>
				<TH CLASS="DataBox">Result</TH>
				<?php $_from = $this->_tpl_vars['merge_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
					<TR>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><A HREF="<?php echo $this->_tpl_vars['self']; ?>
?MergeID=<?php echo $this->_tpl_vars['data']['MergeID']; ?>
" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['ItemA_Name']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['ItemB_Name']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Result_Name']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => true), $this);?>
"><?php echo $this->_tpl_vars['data']['Admin']; ?>
</TD>
					</TR>
				<?php endforeach; endif; unset($_from); ?>
			</TABLE><P>
		</TD></TR>
	</TABLE>
<?php else: ?>
	<?php echo smarty_function_editor_get(array('table' => 'items_merge','column' => 'MergeID','value' => $_GET['MergeID'],'return' => 'itemdata'), $this);?>


	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Merge<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="merge.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE Class="ContentBox" width="100%">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="merge.php?MergeID=<?php echo $_GET['MergeID']; ?>
" METHOD="POST">
				<INPUT TYPE=HIDDEN NAME=MergeID VALUE="<?php echo $_GET['MergeID']; ?>
">
				<INPUT TYPE=HIDDEN NAME=save VALUE=y>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./includes/ed_section.tpl", 'smarty_include_vars' => array('section_data' => $this->_tpl_vars['section_data'],'editdata' => $this->_tpl_vars['itemdata'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<P>
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Merge">
			</FORM>
		</TD></TR>
	</TABLE>
<?php endif; ?>
