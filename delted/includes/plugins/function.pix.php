<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_function_pix($params, &$smarty) {
?>

<table STYLE="background-image: url('/images/interface/photo.gif'); border: 0px; width: 92px; height: 92px; background-repeat: no-repeat;">
<tr>
<td style="padding-left: 6px; padding-top: 6px;">
	<?PHP if (!empty($params['link'])) { ?><A HREF="<?=$params['link']?>"><?PHP } ?>
		<IMG BORDER=0 SRC="/pix/<?=$params['photo_id']?>/75.jpg">
	<?PHP if (!empty($params['link'])) { ?></A><?PHP } ?>
</td>
</tr>
</table>

<?PHP if ($params['footer'] || $params['footer_nolink']) {?>
	<?=$params['footer_nolink']?> 
	<?PHP if (!empty($params['footer_link'])) { ?><A CLASS="tiny" HREF="<?=$params['footer_link']?>"><?PHP } ?>
	<?=$params['footer']?>
	<?PHP if (!empty($params['footer_link'])) { ?></A><?PHP } ?>
<?PHP }?>


<?PHP
}
?>