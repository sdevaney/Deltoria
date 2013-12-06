<?php /* Smarty version 2.6.9, created on 2010-01-27 21:47:31
         compiled from tile_picker.tpl */ ?>
<HTML>
<HEAD>
<LINK rel="stylesheet" href="/styles/default.css">
</HEAD>
<BODY>

<?php if ($_GET['hideform'] != '1'): ?>
<FORM ACTION=tile_picker.php STYLE="margin: 0px;">
	<INPUT TYPE=HIDDEN NAME=return_id VALUE="<?php echo $_GET['return_id']; ?>
">
	<INPUT TYPE=HIDDEN NAME=image_type VALUE="<?php echo $_GET['image_type']; ?>
">
	<INPUT TYPE=HIDDEN NAME=return_image VALUE="<?php echo $_GET['return_image']; ?>
">
	<INPUT TYPE=TEXT NAME=search SIZE=10 VALUE="<?php echo $_GET['search']; ?>
">
	<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Search>
</FORM>
<?php endif; ?>

	<IMG WIDTH="32" HEIGHT="24" SRC="/images/tiles/blank.jpg" ONCLICK="setmaptile('/images/tiles/blank.jpg',0);">
	<?php $_from = $this->_tpl_vars['tiles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
		<IMG WIDTH="32" HEIGHT="24" SRC="/images/tiles/<?php echo $this->_tpl_vars['data']['Image']; ?>
" ONCLICK="setmaptile('/images/tiles/<?php echo $this->_tpl_vars['data']['Image']; ?>
',<?php echo $this->_tpl_vars['data']['TileID']; ?>
);">
	<?php endforeach; endif; unset($_from); ?>

<SCRIPT>
<?php echo '
	function setmaptile(tile,tileid) {
		parent.document.getElementById("';  echo $_GET['return_image'];  echo '").src = tile;
		parent.document.getElementById("';  echo $_GET['return_id'];  echo '").value = tileid;
	}
'; ?>

</SCRIPT>



</BODY>
</HTML>