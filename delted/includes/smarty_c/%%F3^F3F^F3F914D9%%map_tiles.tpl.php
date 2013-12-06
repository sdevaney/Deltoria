<?php /* Smarty version 2.6.9, created on 2010-01-27 20:13:29
         compiled from map_tiles.tpl */ ?>
<HTML>
<BODY STYLE="padding: 0px; margin: 0px; background-color: #F5F5F5; color: #000000;">

<FORM ACTION=map_tiles.php STYLE="margin: 0px;">
<INPUT TYPE=TEXT NAME=search SIZE=15 VALUE="<?php echo $_GET['search']; ?>
">
<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=Search>
</FORM>

<DIV STYLE="overflow: auto; height: 500px;">
	<IMG SRC="images/tiles/blank.jpg" ONCLICK="setmaptile('images/tiles/blank.jpg',0);">
	<?php $_from = $this->_tpl_vars['tiles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
		<IMG SRC="/images/tiles/<?php echo $this->_tpl_vars['data']['Image']; ?>
" ONCLICK="setmaptile('/images/tiles/<?php echo $this->_tpl_vars['data']['Image']; ?>
',<?php echo $this->_tpl_vars['data']['TileID']; ?>
);">
	<?php endforeach; endif; unset($_from); ?>
</DIV>

<SCRIPT>
<?php echo '
	function setmaptile(tile,tileid) {
		parent.document.getElementById("TileID").value = tileid;
		parent.document.getElementById("Image").src = tile;
	}
'; ?>

</SCRIPT>



</BODY>
</HTML>