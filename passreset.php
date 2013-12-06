<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Allows users to reset their password
require_once("./system/dbconnect.php");

//session_start();  // Start Session
//session_register("session");
// This is displayed if all the fields are not filled in
$empty_fields_message = "<p>Please go back and complete all the fields in the form.</p>Click <a class=\"two\" href=\"javascript:history.go(-1)\">here</a> to go back";
// Convert to simple variables  
$email_address = $_POST['email_address'];
if (!isset($_POST['email_address'])) {
?>
<h2>Recover a forgotten password!</h2>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <p class="style3"><label for="email_address">Email:</label>
    <input type="text" title="Please enter your email address" name="email_address" size="30"/></p>
    <p class="style3"><label title="Reset Password">&nbsp</label>
    <input type="submit" value="Submit" class="submit-button"/></p>
</form>
<?php
}
elseif (empty($email_address)) {
    echo $empty_fields_message;
}
else {
$email_address=mysql_real_escape_string($email_address);
$status = "OK";
$msg="";
//error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);
if (!stristr($email_address,"@") OR !stristr($email_address,".")) {
$msg="Your email address is not correct<BR>"; 
$status= "NOTOK";}

echo "<br><br>";
if($status=="OK"){  $query="SELECT email FROM user_base WHERE user_base.email = '$email_address'";
$st=mysql_query($query);
$recs=mysql_num_rows($st);
$row=mysql_fetch_object($st);
$em=$row->email;// email is stored to a variable
 if ($recs == 0) {  echo "<center><font face='Verdana' size='2' color=red><b>No Password</b><br> Sorry Your address is not there in our database . You can signup and login to use our site. <BR><BR><a href='http://www.deltoria.com/register.php'>Register</a> </center>"; exit;}
function makeRandomPassword() { 
          $salt = "abchefghjkmnpqrstuvwxyz0123456789"; 
          srand((double)microtime()*1000000);  
          $i = 0; 
          while ($i <= 7) { 
                $num = rand() % 33; 
                $tmp = substr($salt, $num, 1); 
                $pass = $pass . $tmp; 
                $i++; 
          } 
          return $pass; 
    } 
    $random_password = makeRandomPassword(); 
    $db_password = $random_password; 
     
    $sql = mysql_query("UPDATE user_base SET password=old_password('$db_password') WHERE email='$email_address'"); 
     
    $subject = "Your password at YOUR_GAME"; 
    $message = "Hi, we have reset your password. 
     
    New Password: $random_password 
     
    http://www.YOUR_GAME.com
    Once logged in you can change your password 
     
    Thanks! 
    Staff 
     
    This is an automated response, please do not reply!"; 
     
    mail($email_address, $subject, $message, "From: YOUR_GAME.com <support@YOUR_GAME.com>\n 
        X-Mailer: PHP/" . phpversion()); 
    echo "Your password has been sent! Please check your email!<br />"; 
    echo "<br><br>Click <a href='http://www.YOUR_GAME.com'>here</a> to login";
 } 
 else {echo "<center><font face='Verdana' size='2' color=red >$msg <br><br><input type='button' value='Retry' onClick='history.go(-1)'></center></font>";}
}
?>