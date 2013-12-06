<html>
<head>
<title>Email Sender</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>

<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
$dbhost = 'localhost';
$dbuser = 'db_user';
$dbpass = 'db_pass';

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die                      ('Error connecting to mysql');

$dbname = 'db_name';
mysql_select_db($dbname);
?>

<?
if (isset($_POST['submit']))
{

        $subject = $_POST['subject'];
        $message = $_POST['message'];

       
        $query="SELECT `Email` FROM user_base";  //
        $result=mysql_query($query);
        $num=mysql_num_rows($result);


        $i=0;
        while ($i < $num)
        {
       
                $email=mysql_result($result,$i,"email");
                       
                mail($email, $subject, $message, "From: YourGameName Staff<support@YourDomain.com>\nX-Mailer: PHP/" . phpversion());
       
                echo "Email sent to: " . $email . "<br />";
       
                $i++;
                               
        }
}
?>
<br />

               
<form name="email" action="<?=$_SERVER['email.php']?>" method="post">

Subject
<br />
<input name="subject" type="text" size="50" id="subject"><br /><br />
Message
<br />
<textarea name="message" cols="50" rows="10" id="message"></textarea>
<br /><br />
<input type="submit" name="submit" value="Email!">
       
</body>
</html>