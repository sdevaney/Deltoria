<?php /* Smarty version 2.6.9, created on 2010-01-27 20:22:45
         compiled from ./includes/ed_section.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', './includes/ed_section.tpl', 15, false),array('function', 'sql_dropdown', './includes/ed_section.tpl', 21, false),array('function', 'optionsplit', './includes/ed_section.tpl', 27, false),)), $this); ?>
<TABLE BORDER=0>
	<?php $_from = $this->_tpl_vars['section_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['dsection'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['dsection']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['data']):
        $this->_foreach['dsection']['iteration']++;
?>
		<?php if (($this->_foreach['dsection']['iteration'] <= 1)): ?><TR><?php endif; ?>
		<?php if ($this->_tpl_vars['data'] == 'NEW'): ?>
			</TR><TR>
		<?php elseif ($this->_tpl_vars['data']['edtype'] == 'HIDDEN'): ?>
			<INPUT TYPE=HIDDEN ID="<?php echo $this->_tpl_vars['data']['db_column']; ?>
" NAME="<?php echo $this->_tpl_vars['data']['db_column']; ?>
" VALUE="<?php echo $this->_tpl_vars['editdata'][$this->_tpl_vars['data']['db_column']]; ?>
">
		<?php else: ?>
			<?php if ($this->_tpl_vars['data']['NEW'] != "" && $this->_tpl_vars['data']['title'] != ""): ?>
				</TR><TR>
				<TD COLSPAN="<?php echo $this->_tpl_vars['data']['colspan']; ?>
" STYLE="padding-top: 10px;"><DIV CLASS="Title"><?php echo $this->_tpl_vars['data']['title']; ?>
</DIV><IMG SRC="images/line_white.gif" WIDTH="100%" HEIGHT="1" STYLE="padding: 0px; margin-top: 0px;"><BR><?php if ($this->_tpl_vars['data']['desc']):  echo $this->_tpl_vars['data']['desc']; ?>
<P><?php endif; ?></TD></TR>
				<TR>
			<?php else: ?>
				<TD STYLE="padding-left: 5px;"><?php echo $this->_tpl_vars['data']['label']; ?>
:</TD>
				<TD COLSPAN="<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['colspan'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1)); ?>
" ROWSPAN="<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['rowspan'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1)); ?>
" STYLE="padding-left: 5px;">
				<?php if ($this->_tpl_vars['data']['edtype'] == 'CHECKBOX'): ?>
					<INPUT NAME="<?php echo $this->_tpl_vars['data']['db_column']; ?>
" TYPE="CHECKBOX" VALUE="Y" <?php if ($this->_tpl_vars['editdata'][$this->_tpl_vars['data']['db_column']] == 'Y'): ?>CHECKED<?php endif; ?>>
				<?php elseif ($this->_tpl_vars['data']['edtype'] == 'DROPDOWN_SQL'): ?>
					<SELECT <?php if ($this->_tpl_vars['data']['id']): ?>ID="<?php echo $this->_tpl_vars['data']['id']; ?>
"<?php endif; ?> <?php if ($this->_tpl_vars['data']['onchange']): ?>OnChange="<?php echo $this->_tpl_vars['data']['onchange']; ?>
"<?php endif; ?> NAME="<?php echo $this->_tpl_vars['data']['db_column']; ?>
">
						<?php if ($this->_tpl_vars['data']['blank_option']): ?><OPTION VALUE="0">None Selected</OPTION><?php endif; ?>
						<?php echo smarty_function_sql_dropdown(array('sql' => $this->_tpl_vars['data']['query'],'key_column' => $this->_tpl_vars['data']['key_column'],'value_column' => $this->_tpl_vars['data']['value_column'],'selected' => $this->_tpl_vars['editdata'][$this->_tpl_vars['data']['db_column']]), $this);?>

					</SELECT>
				<?php elseif ($this->_tpl_vars['data']['edtype'] == 'TEXTAREA'): ?>
					<TEXTAREA STYLE="width: 100%;" NAME="<?php echo $this->_tpl_vars['data']['db_column']; ?>
" ROWS="<?php if ($this->_tpl_vars['data']['rows'] != ""):  echo $this->_tpl_vars['data']['rows'];  else:  echo ((is_array($_tmp=@$this->_tpl_vars['data']['rowspan'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1));  endif; ?>"><?php echo $this->_tpl_vars['editdata'][$this->_tpl_vars['data']['db_column']]; ?>
</TEXTAREA>
				<?php elseif ($this->_tpl_vars['data']['edtype'] == 'DROPDOWN'): ?>
					<SELECT STYLE="width: 100%;" <?php if ($this->_tpl_vars['data']['id']): ?>ID="<?php echo $this->_tpl_vars['data']['id']; ?>
"<?php endif; ?> <?php if ($this->_tpl_vars['data']['onchange']): ?>OnChange="<?php echo $this->_tpl_vars['data']['onchange']; ?>
"<?php endif; ?> NAME="<?php echo $this->_tpl_vars['data']['db_column']; ?>
">
						<?php echo smarty_function_optionsplit(array('options' => $this->_tpl_vars['data']['options'],'return' => 'options'), $this);?>

						<?php $_from = $this->_tpl_vars['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['optdata']):
?>
							<?php if (count ( $this->_tpl_vars['optdata'] ) == 2): ?>
								<OPTION VALUE="<?php echo $this->_tpl_vars['optdata']['key']; ?>
" <?php if ($this->_tpl_vars['editdata'][$this->_tpl_vars['data']['db_column']] == $this->_tpl_vars['optdata']['key']): ?>SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['optdata']['value']; ?>
</OPTION>
							<?php else: ?>
								<OPTION VALUE="<?php echo $this->_tpl_vars['optdata']; ?>
" <?php if ($this->_tpl_vars['editdata'][$this->_tpl_vars['data']['db_column']] == $this->_tpl_vars['optdata']): ?>SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['optdata']; ?>
</OPTION>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</SELECT>
				<?php else: ?>
					<INPUT TYPE=TEXT <?php if ($this->_tpl_vars['data']['size'] != ""): ?>SIZE="<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['size'])) ? $this->_run_mod_handler('default', true, $_tmp, 20) : smarty_modifier_default($_tmp, 20)); ?>
"<?php else: ?>STYLE="width: 100%;"<?php endif; ?> NAME="<?php echo $this->_tpl_vars['data']['db_column']; ?>
" ID="<?php echo $this->_tpl_vars['data']['db_column']; ?>
" VALUE="<?php echo $this->_tpl_vars['editdata'][$this->_tpl_vars['data']['db_column']]; ?>
">
				<?php endif; ?>
				</TD>
			<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
</TABLE>