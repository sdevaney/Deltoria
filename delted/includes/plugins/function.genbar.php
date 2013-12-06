<?php 
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
    function smarty_function_genbar($params, &$smarty) { 
		extract($params);
	    if ($Max < 1) { $Max = 1; }
	    if ($Min < 1) { $Min = 1; }
	    print "<table border=1 cellpadding=0 cellspacing=0 width=$Width>";
	    print "<TR><TD>";
	    print "<img name=$BarType src=/images/bar_$BarType.jpg height=5 width=";
	    $perc = intval(($Cur / $Max) * 100);
	    if ($perc > 100) { $perc = 100; }
	    $perc = $Width * ($perc / 100);
	    print "$perc";
	    print "></td></tr>";
	    print "</table>";
	}
?> 