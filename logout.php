<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Logout of the game goes to index
session_start();
$_SESSION[CoreID] = "";
header("Location: index2.php");
?>