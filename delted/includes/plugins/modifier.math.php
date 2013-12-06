<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_modifier_math($value,$type,$amount) {
	if ($type == "add" || $type == "+" || $type == "plus" || $type == "addition") {
		return ($value+$amount);
	}
	if ($type == "sub" || $type == "-" || $type == "substract" || $type == "subtraction") {
		return ($value-$amount);
	}
}
?>