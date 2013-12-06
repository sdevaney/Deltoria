<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Nothing to see here
	$mya = RetTest();
	foreach (RetTest() as $blah => $halab) {
		print "Running: $blah --- $halab\n";
	}

	function RetTest() {
		$this = array();
		$this[1] = "this";
		$this[2] = "is";
		$this[3] = "a";
		$this[4] = "test";
		return $this;
	}
?>