<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {update_user} function plugin
 *
 * File:       function.update_user.php<br>
 * Type:       function<br>
 * Name:       save_bugs<br>
 * Date:       21.Dec.2009<br>
 * Purpose:    Returns an array of bugs<br>
 * Input:<br>
 *           - return     (required) - smarty array to return the results set into
 * Examples:
 * <pre>
 * {save_bugs return='bugs'}
 * </pre>
 * @author     Scott Devaney
 * @version    1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_count_array($params, &$smarty)
{
	print count($params['array']);
}


?>