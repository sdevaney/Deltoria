<?php /* Smarty version 2.6.9, created on 2010-01-27 22:09:07
         compiled from quests.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'formtool_init', 'quests.tpl', 8, false),array('function', 'cycle', 'quests.tpl', 22, false),array('function', 'editor_get', 'quests.tpl', 33, false),)), $this); ?>
<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./includes/logged_top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo smarty_function_formtool_init(array('src' => "/jscript/formtool.js"), $this);?>


<?php if ($_GET['QuestID'] == ""): ?>
	<DIV CLASS="Title">Available Quests</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a quest from the list below or <A HREF="quests.php?QuestID=0" CLASS="ContentLink">create a new one</A><P>
			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Quest Name</TH>
				<TH CLASS="DataBox">Requested Item</TH>
				<TH CLASS="DataBox">Reward Item</TH>
				<?php $_from = $this->_tpl_vars['quest_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
					<TR>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><A HREF="<?php echo $this->_tpl_vars['self']; ?>
?QuestID=<?php echo $this->_tpl_vars['data']['QuestID']; ?>
" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Name']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['ig_name']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => true), $this);?>
"><?php echo $this->_tpl_vars['data']['ir_name']; ?>
</TD>
					</TR>
				<?php endforeach; endif; unset($_from); ?>
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
<?php else: ?>
	<?php if ($_GET['QuestID'] > 0):  echo smarty_function_editor_get(array('table' => 'questdata','column' => 'QuestID','value' => $_GET['QuestID'],'return' => 'questdata'), $this); endif; ?>
	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Quest<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="quests.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			<FORM ACTION="quests.php?QuestID=<?php echo $_GET['QuestID']; ?>
" METHOD="POST">
				<INPUT TYPE=HIDDEN NAME=QuestID VALUE="<?php echo $_GET['QuestID']; ?>
">
				<INPUT TYPE=HIDDEN NAME=save VALUE=y>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./includes/ed_section.tpl", 'smarty_include_vars' => array('section_data' => $this->_tpl_vars['section_data'],'editdata' => $this->_tpl_vars['questdata'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<P>
				<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Quest">
		</TD></TR>
	</TABLE><P>

	<DIV STYLE="TEXT-ALIGN: RIGHT;"><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Quest"></DIV>

	</FORM>
<?php endif; ?>