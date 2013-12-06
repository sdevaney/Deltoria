<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_function_post_print($params, &$smarty)
{
	print $_POST[$params['post']];
}

/* vim: set expandtab: */

?>