<?php /* Smarty version 2.6.9, created on 2010-01-27 21:39:45
         compiled from map_spawn.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'map_spawn.tpl', 10, false),)), $this); ?>
<HTML>
<HEAD>
<LINK rel="stylesheet" href="styles/default.css">
</HEAD>

<BODY>

<?php if ($_GET['GroupID'] != ""): ?>
	<SCRIPT>
		parent.document.getElementById("GroupID").value = <?php echo ((is_array($_tmp=@$_GET['GroupID'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
;
	</SCRIPT>
<?php endif; ?>


<?php if ($_GET['GroupID'] == '0'): ?>*<?php endif; ?> <A HREF="map_spawn.php?GroupID=0">None</A><BR>
<?php $_from = $this->_tpl_vars['spawn_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pdata']):
?>
	<?php if ($this->_tpl_vars['pdata']['GroupID'] == $_GET['GroupID']): ?>*<?php endif; ?> <A HREF="map_spawn.php?GroupID=<?php echo $this->_tpl_vars['pdata']['GroupID']; ?>
"><?php echo $this->_tpl_vars['pdata']['Name']; ?>
</A><BR>
<?php endforeach; endif; unset($_from); ?>

</BODY>
</HTML>