<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
/* $Id: localtime.php,v 1.1 2002/07/29 23:32:41 shaggy Exp $ */

// you can start the session in the calling page too
session_start();


function set_timezone($offset) {
	if ($offset) {
		$offset = -$offset;
		$_SESSION['GMT_offset'] = 60 * $offset;
		$GMT_offset_str = ( $offset > 0 ) ? '+' : '-';
		$GMT_offset_str .= floor($offset / 60) . ':';
		$GMT_offset_str .= (($offset % 60) < 10 ) ? '0' . $offset % 60 : $offset % 60;
		$_SESSION['GMT_offset_str'] = $GMT_offset_str;
	}
}


function format_datetime($date) {
	return (gmdate('j M Y g:ia', $date + $_SESSION['GMT_offset']) . ' GMT ' . $_SESSION['GMT_offset_str']);
}


function format_date($date) {
	return date('j M Y', $date);
}


/////////////////////////////////////////////////////////////////////////////////////


if (!isset($_SESSION['GMT_offset']) ) {
	$_SESSION['GMT_offset'] = 0;
	$_SESSION['GMT_offset_str'] = '';
}


if (isset($_GET['offset']) ) {
	$_SESSION['offset'] = $_GET['offset'];
	set_timezone($_GET['offset']);
}



if ( !isset($_SESSION['offset']) ) {
?>
	<script type="text/javascript">
		window.onload = setLinks

		function setLinks() {
			var base_url = location.protocol + '//' + location.hostname;
			var now = new Date()
			var offset = now.getTimezoneOffset();

			for (i = 0; document.links.length > i; i++) {
				with (document.links[i]) {
					if (href.indexOf(base_url) == 0) {
						if (href.indexOf('?') == -1) {
							href += '?offset=' + offset;
						} else {
							href += ';offset=' + offset;
						}
					}
				}
			}
		}
	</script>

<?php
}

?>