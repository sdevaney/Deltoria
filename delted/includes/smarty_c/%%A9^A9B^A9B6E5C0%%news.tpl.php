<?php /* Smarty version 2.6.9, created on 2010-01-29 20:12:11
         compiled from news.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'formtool_init', 'news.tpl', 10, false),array('function', 'cycle', 'news.tpl', 24, false),array('function', 'editor_get', 'news.tpl', 34, false),)), $this); ?>
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


<?php if ($_GET['FrontID'] == ""): ?>
	<DIV CLASS="Title">Available News</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select news from the list below or <A HREF="news.php?FrontID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Name</TH>
				<TH CLASS="DataBox">Date</TH>
				<?php $_from = $this->_tpl_vars['news_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
					<TR>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><A HREF="<?php echo $this->_tpl_vars['self']; ?>
?FrontID=<?php echo $this->_tpl_vars['data']['FrontID']; ?>
" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Name']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => true), $this);?>
"><?php echo $this->_tpl_vars['data']['NewsDate']; ?>
</TD>
					</TR>
				<?php endforeach; endif; unset($_from); ?>
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
<?php else: ?>
	<?php echo smarty_function_editor_get(array('table' => 'frontnews','column' => 'FrontID','value' => $_GET['FrontID'],'return' => 'newsdata'), $this);?>


	<DIV CLASS="Title" STYLE="width: 500px;">Editing News<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="news.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE>
		<TR><TD WIDTH=500>

			<TABLE Class="ContentBox" width="100%">
				<TR><TD CLASS="ContentBox">
					<FORM ACTION="news.php?FrontID=<?php echo $_GET['FrontID']; ?>
" METHOD="POST">
						<INPUT TYPE=HIDDEN NAME=FrontID VALUE="<?php echo $_GET['FrontID']; ?>
">
						<INPUT TYPE=HIDDEN NAME=save VALUE=y>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./includes/ed_section.tpl", 'smarty_include_vars' => array('section_data' => $this->_tpl_vars['section_data'],'editdata' => $this->_tpl_vars['newsdata'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						<P>
						<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this News">
					</FORM>
				</TD></TR>
			</TABLE>
		</TD></TR>
	</TABLE>
<?php endif; ?>
