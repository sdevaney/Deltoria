<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Does our style sheets and favicon
$time = microtime();
$time = explode(" ",$time);
$microtime = $time[1]+$time[0];
$transaction_start = $microtime;
?>
<HTML>
<HEAD>
<TITLE>Deltoria</TITLE>
<STYLE>
<? include("./styles/style.php"); ?>
</STYLE>
<LINK REL="SHORTCUT ICON" HREF="http://deltoria.techby2guys.com/favicon.ico">
</HEAD>
<BODY>