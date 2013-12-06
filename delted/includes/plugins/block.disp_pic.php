<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_block_disp_pic($params, $content, &$smarty) {
    if (is_null($content)) {
		?>
<TABLE CLASS="pc">
<TR>
<TD CLASS="pc_tl"></TD>
<TD CLASS="pc_t"></TD>
<TD CLASS="pc_tr"></TD>
</TR>
<TR>
<TD CLASS="pc_l"></TD>
<TD>
		<?PHP
        return;
    } else {
		print $content;
?>
</TD>
<TD CLASS="pc_r"></TD>
</TR>
<TR>
<TD CLASS="pc_bl"></TD>
<TD CLASS="pc_b"></TD>
<TD CLASS="pc_br"></TD>
</TR>
</TABLE>

		<?PHP
		return;
	}

}

?>