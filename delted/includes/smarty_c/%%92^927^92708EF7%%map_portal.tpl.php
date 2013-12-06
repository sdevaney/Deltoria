<?php /* Smarty version 2.6.9, created on 2010-01-28 19:34:15
         compiled from map_portal.tpl */ ?>
<HTML>
<HEAD>
<LINK rel="stylesheet" href="styles/default.css">
</HEAD>

<BODY>

<?php if ($_GET['PortalID'] != ""): ?>
	<SCRIPT>
		parent.document.getElementById("PortalID").value = <?php echo $_GET['PortalID']; ?>
;
	</SCRIPT>
<?php endif; ?>

<?php if ($_GET['PortalID'] == '0'): ?>*<?php endif; ?> <A HREF="map_portal.php?PortalID=0">None</A><BR>
<?php $_from = $this->_tpl_vars['portal_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pdata']):
?>
	<?php if ($this->_tpl_vars['pdata']['PortalID'] == $_GET['PortalID']): ?>*<?php endif; ?> <A HREF="map_portal.php?PortalID=<?php echo $this->_tpl_vars['pdata']['PortalID']; ?>
"><?php echo $this->_tpl_vars['pdata']['Name']; ?>
</A><BR>
<?php endforeach; endif; unset($_from); ?>

</BODY>
</HTML>