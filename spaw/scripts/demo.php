<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Control usage demonstration file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// $Revision: 1.9 $, $Date: 2006/10/18 07:22:15 $
// ================================================

// include the control file
include '../spaw_control.class.php';

// here we add some styles to styles dropdown
$spaw_dropdown_data['style']['default'] = 'No styles';
$spaw_dropdown_data['style']['style1'] = 'Style no. 1';
$spaw_dropdown_data['style']['style2'] = 'Style no. 2';

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Solmetra SPAW Editor usage demonstration page</title>
</head>
<body>
<style type="text/css">
  pre {
    background : #cccccc; 
    padding : 5 5 5 5;
  }
</style>
<p>Hi... this script shows various ways of using <a href="http://www.solmetra.com">Solmetra</a> SPAW web based WYSIWYG editor control.</p>
<p>Below you will see various modes of the control and parameters that caused it to look like this.</p>
<p><i>Note: in case you can't see the editors or get errors, it is most likely that you haven't configured the control properly. Check the documentation details.</i></p>
<p>Pay attention that you can use multiple instances of the control on the same page and with completely different settings... pretty cool ;)</p>
<p>For more info on how to use the control check out the documentation or analyze this script (demo.php) and control's source. You can also try asking in <a href="http://forums.solmetra.com" target="_blank">our forums</a></p>
<form name="spawdemo" method="post" action="demo.php">
<hr width="100%" size="1">
<h2>DEMO #1</h2>
<p>This is the simpliest usage of the control with all the default parameters</p>
<pre>
$sw = new SPAW_Wysiwyg('spaw1',stripslashes($_POST['spaw1']));
$sw->show();
</pre>
<?php 
$sw = new SPAW_Wysiwyg('spaw1' /*name*/,isset($_POST['spaw1'])?stripslashes($_POST['spaw1']):'' /*value*/);
$sw->show();
?>


<hr width="100%" size="1">
<h2>DEMO #2</h2>
<p>Now let's try something else... let's specify width and height of the control, Lithuanian language and "sidetable" toolbar mode.</p>
<pre>
$sw = new SPAW_Wysiwyg('spaw2' /*name*/,stripslashes($_POST['spaw2']) /*value*/,
                       'lt' /*language*/, 'sidetable' /*toolbar mode*/, 'default' /*theme*/,
                       '550px' /*width*/, '350px' /*height*/);
$sw->show();
</pre>
<?php 
$sw = new SPAW_Wysiwyg('spaw2' /*name*/,isset($_POST['spaw2'])?stripslashes($_POST['spaw2']):'' /*value*/,
                       'lt' /*language*/, 'sidetable' /*toolbar mode*/, 'default' /*theme*/,
                       '550px' /*width*/, '350px' /*height*/);
$sw->show();
?>

<hr width="100%" size="1">
<h2>DEMO #3</h2>
<p>This time we will check our 'classic' (not so nice ;) theme with 'full' toolbar.</p>
<pre>
$sw = new SPAW_Wysiwyg('spaw3' /*name*/,stripslashes($_POST['spaw3']) /*value*/,
                       'en' /*language*/, 'full' /*toolbar mode*/, 'classic' /*theme*/,
                       '550px' /*width*/, '150px' /*height*/);
$sw->show();
</pre>
<?php 
$sw = new SPAW_Wysiwyg('spaw3' /*name*/,isset($_POST['spaw3'])?stripslashes($_POST['spaw3']):'' /*value*/,
                       'en' /*language*/, 'full' /*toolbar mode*/, 'classic' /*theme*/,
                       '550px' /*width*/, '150px' /*height*/);
$sw->show();
?>

<hr width="100%" size="1">
<h2>DEMO #4</h2>
<p>There's also a 'mini' toolbar (with minimum features without possibility to switch to code (html) mode) useful for short summary text fields.</p>
<pre>
$sw = new SPAW_Wysiwyg('spaw4' /*name*/,stripslashes($_POST['spaw4']) /*value*/,
                       'en' /*language*/, 'mini' /*toolbar mode*/, '' /*theme*/,
                       '250px' /*width*/, '50px' /*height*/);
$sw->show();
</pre>
<?php 
$sw = new SPAW_Wysiwyg('spaw4' /*name*/,isset($_POST['spaw4'])?stripslashes($_POST['spaw4']):'' /*value*/,
                       'en' /*language*/, 'mini' /*toolbar mode*/, '' /*theme*/,
                       '250px' /*width*/, '50px' /*height*/);
$sw->show();
?>

<hr width="100%" size="1">
<h2>DEMO #5</h2>
<p>You can pass an url of the stylesheet file to be used for control's content to the consturctor like we do below</p>
<pre>
$sw = new SPAW_Wysiwyg('spaw5' /*name*/,stripslashes($_POST['spaw5']) /*value*/,
                       'en' /*language*/, 'mini' /*toolbar mode*/, '' /*theme*/,
                       '250px' /*width*/, '90px' /*height*/, 'scripts/demo_red.css' /*stylesheet file*/);
$sw->show();
</pre>
<?php 
$sw = new SPAW_Wysiwyg('spaw5' /*name*/,isset($_POST['spaw5'])?stripslashes($_POST['spaw5']):'' /*value*/,
                       'en' /*language*/, 'mini' /*toolbar mode*/, '' /*theme*/,
                       '250px' /*width*/, '90px' /*height*/, 'scripts/demo_red.css' /*stylesheet file*/);
$sw->show();
?>

<hr width="100%" size="1">
<h2>DEMO #6</h2>
<p>There is a way to customize the content of the dropdowns like styles, fonts, etc. You can customize it for all instances of the control by modifying $spaw_dropdown_data array in config file or you can do it for all instances of control on the page by modifying same array but this time in your current script or you can specify specific data for dropdowns of one specific instance. This example show how...</p>
<pre>
// make a copy of $spaw_dropdown_data array
$demo_array = $spaw_dropdown_data;
// unset current styles
unset($demo_array['style']);
// set new styles
$demo_array['style']['default'] = 'Default';
$demo_array['style']['crazystyle1'] = 'Crazy style no. 1';
$demo_array['style']['crazystyle2'] = 'Crazy style no. 2';
$demo_array['style']['crazystyle3'] = 'Crazy style no. 3';

// pass $demo_array to the constructor
$sw = new SPAW_Wysiwyg('spaw6' /*name*/,stripslashes($_POST['spaw6']) /*value*/,
                       'en' /*language*/, 'default' /*toolbar mode*/, '' /*theme*/,
                       '550px' /*width*/, '90px' /*height*/, '' /*stylesheet file*/,
                       $demo_array /*dropdown data*/);
$sw->show();
</pre>
<?php 
// make a copy of $spaw_dropdown_data array
$demo_array = $spaw_dropdown_data;
// unset current styles
unset($demo_array['style']);
// set new styles
$demo_array['style']['default'] = 'Default';
$demo_array['style']['crazystyle1'] = 'Crazy style no. 1';
$demo_array['style']['crazystyle2'] = 'Crazy style no. 2';
$demo_array['style']['crazystyle3'] = 'Crazy style no. 3';

// pass $demo_array to the constructor
$sw = new SPAW_Wysiwyg('spaw6' /*name*/,isset($_POST['spaw6'])?stripslashes($_POST['spaw6']):'' /*value*/,
                       'en' /*language*/, 'default' /*toolbar mode*/, '' /*theme*/,
                       '550px' /*width*/, '90px' /*height*/, '' /*stylesheet file*/,
                       $demo_array /*dropdown data*/);
$sw->show();
?>

<input type="submit">
</form>
</body>
</html>
