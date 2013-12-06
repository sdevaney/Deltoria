<?php 
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
    function smarty_function_exec_code($params, &$smarty) { 
		exec_code($params['code_id'],$params['code_param_a'],$params['code_param_b'],$params['code_param_c'],$params['code_param_d'],$params['code_param_e']);
	}
?> 