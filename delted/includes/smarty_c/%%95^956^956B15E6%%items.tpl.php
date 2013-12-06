<?php /* Smarty version 2.6.9, created on 2010-01-27 20:07:46
         compiled from items.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'formtool_init', 'items.tpl', 10, false),array('function', 'cycle', 'items.tpl', 28, false),array('function', 'editor_get', 'items.tpl', 42, false),array('function', 'manytomany', 'items.tpl', 60, false),array('function', 'formtool_move', 'items.tpl', 75, false),array('function', 'formtool_moveall', 'items.tpl', 78, false),)), $this); ?>
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


<?php if ($_GET['ItemID'] == ""): ?>
	<DIV CLASS="Title">Available Items</DIV>
	<TABLE Class="ContentBox" width="500">
		<TR><TD CLASS="ContentBox">
			Select a item from the list below or <A HREF="items.php?ItemID=0" CLASS="ContentLink">create a new one</A><P>

			<TABLE CLASS="DataBox">
				<TH CLASS="DataBox">&nbsp;</TH>
				<TH CLASS="DataBox">Item Name</TH>
				<TH CLASS="DataBox">Type</TH>
				<TH CLASS="DataBox">Subscriber</TH>
				<TH CLASS="DataBox">Level</TH>
				<TH CLASS="DataBox">Administrator</TH>
				<TH CLASS="DataBox">Image</TH>
				<?php $_from = $this->_tpl_vars['items_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
					<TR>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><A HREF="<?php echo $this->_tpl_vars['self']; ?>
?ItemID=<?php echo $this->_tpl_vars['data']['ItemID']; ?>
" CLASS="ContentLink">Edit</A></TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Name']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['ItemType']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Subscriber']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Defined_LevelReq']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><?php echo $this->_tpl_vars['data']['Admin']; ?>
</TD>
						<TD CLASS="DataRow<?php echo smarty_function_cycle(array('values' => 'A,B','advance' => false), $this);?>
"><IMG WIDTH="22" HEIGHT="14" SRC="../images/tiles/<?php echo $this->_tpl_vars['data']['Image']; ?>
"></TD>
					</TR>
				<?php endforeach; endif; unset($_from); ?>
			</TABLE><P>
			Text are here describing this editor and what it is for. This area is editable by the administrator so it may contain things like rules, etc.
		</TD></TR>
	</TABLE>
<?php else: ?>
	<?php echo smarty_function_editor_get(array('table' => 'items_base','column' => 'ItemID','value' => $_GET['ItemID'],'return' => 'itemdata'), $this);?>


	<DIV CLASS="Title" STYLE="width: 500px;">Editing a Item<DIV STYLE="float: right;vertical-align: bottom;"><A HREF="items.php" CLASS="ContentLink">Back to listing</A></DIV></DIV>

	<TABLE>
		<TR><TD WIDTH=500>

			<TABLE Class="ContentBox" width="100%">
				<TR><TD CLASS="ContentBox">
					<FORM ACTION="items.php?ItemID=<?php echo $_GET['ItemID']; ?>
" METHOD="POST">
						<INPUT TYPE=HIDDEN NAME=ItemID VALUE="<?php echo $_GET['ItemID']; ?>
">
						<INPUT TYPE=HIDDEN NAME=save VALUE=y>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./includes/ed_section.tpl", 'smarty_include_vars' => array('section_data' => $this->_tpl_vars['section_data'],'editdata' => $this->_tpl_vars['itemdata'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						<P>
						<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE="Save this Item">
				</TD></TR>
			</TABLE>

<?php echo smarty_function_manytomany(array('cor_table' => 'items_base_spells','parent_pk' => 'ItemID','parent_fk' => 'ItemID','parent_table' => 'items_base','child_pk' => 'SpellID','child_fk' => 'SpellID','child_name' => 'Name','child_table' => 'spells','current' => $_GET['ItemID'],'all' => 'all_data','selected' => 'selected_data'), $this);?>


<DIV CLASS="Title">Assign Spells to this Item</DIV>
<TABLE BORDER=0>
<TR><TD STYLE="padding: 10px;">
All Spells<BR>
<SELECT NAME=All[] SIZE=10>
<?php $_from = $this->_tpl_vars['all_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sdata']):
?>
<OPTION VALUE="<?php echo $this->_tpl_vars['sdata']['SpellID']; ?>
"><?php echo $this->_tpl_vars['sdata']['Name']; ?>
</OPTION>
<?php endforeach; endif; unset($_from); ?>
</SELECT>


<INPUT TYPE="HIDDEN" NAME="All_save" VALUE="<?php $_from = $this->_tpl_vars['all_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['saveloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['saveloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['sdata']):
        $this->_foreach['saveloop']['iteration']++;
 echo $this->_tpl_vars['sdata']['SpellID'];  if (! ($this->_foreach['saveloop']['iteration'] == $this->_foreach['saveloop']['total'])): ?>,<?php endif;  endforeach; endif; unset($_from); ?>">
</TD><TD STYLE="padding: 10px;">        
<?php echo smarty_function_formtool_move(array('style' => "width: 50px; margin-top: 5px;",'all' => true,'from' => "All[]",'to' => "Selected[]",'button_text' => "&gt&gt;",'save_from' => 'All_save','save_to' => 'Selected_save'), $this);?>
<br>
<?php echo smarty_function_formtool_move(array('style' => "width: 50px; margin-top: 5px;",'from' => "All[]",'to' => "Selected[]",'button_text' => "&gt;",'save_from' => 'All_save','save_to' => 'Selected_save'), $this);?>
<br>
<?php echo smarty_function_formtool_move(array('style' => "width: 50px; margin-top: 5px;",'from' => "Selected[]",'to' => "All[]",'button_text' => "&lt;",'save_from' => 'Selected_save','save_to' => 'All_save'), $this);?>
<br>
<?php echo smarty_function_formtool_moveall(array('style' => "width: 50px; margin-top: 5px;",'from' => "Selected[]",'to' => "All[]",'button_text' => "&lt&lt;",'save_from' => 'Selected_save','save_to' => 'All_save'), $this);?>
<BR>

</TD><TD STYLE="padding: 10px;">        
Selected Spells<BR>            
<SELECT NAME=Selected[] SIZE=10>
<?php $_from = $this->_tpl_vars['selected_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sdata']):
?>
<OPTION VALUE="<?php echo $this->_tpl_vars['sdata']['SpellID']; ?>
"><?php echo $this->_tpl_vars['sdata']['Name']; ?>
</OPTION>
<?php endforeach; endif; unset($_from); ?>                
</SELECT>            
<INPUT TYPE="HIDDEN" NAME="Selected_save" VALUE="<?php $_from = $this->_tpl_vars['selected_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['saveloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['saveloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['sdata']):
        $this->_foreach['saveloop']['iteration']++;
 echo $this->_tpl_vars['sdata']['SpellID'];  if (! ($this->_foreach['saveloop']['iteration'] == $this->_foreach['saveloop']['total'])): ?>,<?php endif;  endforeach; endif; unset($_from); ?>">
</TD></TR>
</TABLE>

</FORM>




		</TD><TD STYLE="padding-left: 10px;">
			<TABLE Class="ContentBox">
				<TR><TD CLASS="ContentBox">
					<TABLE><TR><TD CLASS=ContentBox>Selected Tile:</TD><TD><IMG WIDTH="32" HEIGHT="24" ID="TileImage" SRC="../images/tiles/<?php echo $this->_tpl_vars['tile_image']; ?>
"></TD></TR></TABLE>
					<HR STYLE="margin-bottom: 0px;">
					<IFRAME FRAMEBORDER=0 SRC="tile_picker.php?image_type=Object&selected=<?php echo $this->_tpl_vars['eddata']['TileID']; ?>
&return_image=TileImage&return_id=TileID" WIDTH="160px" HEIGHT="300px"></IFRAME>
				</TD></TR>
			</TABLE>
		</TD></TR>
	</TABLE>
<?php endif; ?>
