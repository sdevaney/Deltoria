<?php
// Makes sure gd_info is installed
 if (extension_loaded('gd') && function_exists('gd_info')) {    echo "It looks like GD is installed";}?>
