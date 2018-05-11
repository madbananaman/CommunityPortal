<?php
use classes\business\UserManager;
use classes\business\Validation;
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'includes/autoload.php';
include 'includes/header.php';

//Load Composer's autoloader
include '../classes/phpmailer/vendor/autoload.php';

$formStatus="";

$email="";
$password="";
$error_auth="";
$error_name="";
$error_passwd="";
$error_email="";
$validate=new Validation();
$ini = parse_ini_file("$dir/../config/config.ini");

if(isset($_POST["submitted"])){
    $email=$_POST["email"];
	$UM=new UserManager();
	$existuser=$UM->getUserByEmail($email);
	if(isset($existuser)){
			//generate new password using randomPassword($length,$count,$characters). Returns an array.
			$newpassword=$UM->randomPassword(8,1,"lower_case,upper_case,numbers,special_symbols");
			//update database with new password
			//$UM->updatePassword($email,$newpassword[0]); //Original unhash and unsalted. SALT==$email
			$UM->updatePassword($email,password_hash(strtolower($email).$newpassword[0], PASSWORD_DEFAULT));
			//$formStatus="Valid email user. password: ".$newpassword[0];
			//coding for sending email (PHPMailer)-Start
			$mail = new PHPMailer(true);                             // Passing `true` enables exceptions
		try {
			//Server settings
		    $mail->SMTPDebug = 0;                                 // Enable verbose debug output 0 - No output 1-Minimal 4-max
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';                     // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->SMTPKeepAlive = true;                        // SMTP connection will not close after each email sent, reduces SMTP overhead
			$mail->Username = 'USERNAME';                 // SMTP username GMAIL
			$mail->Password = 'USERPASSWORD';                           // SMTP password GMAIL
			$mail->SMTPAutoTLS = false;								//OR $mail->SMTPSecure = TLS or SSL
			$mail->Port = 465;									//TCP port to connect to.Gmail SMTP port (TLS): 587. Gmail SMTP port (SSL): 465			
			
			//Recepients
			$mail->setFrom('USERNAME@gmail.com', 'USERNAME');			//Sender as according to mailjet account
			$mail->addAddress($email);               // Add a recipient

			//Content
			$link = $ini['path']."\login.php?email={$email}&password={$newpassword[0]}"; //Link for user to click to log in
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Password Recovery for ABC Jobs Pte Ltd';
			$mail->Body    = "<p>Dear Sir/Madam,</p>
			<p>Below are the email and password for ABC Jobs Pte Ltd.</p>
			<p>Email: <b>{$email}</b></p>
			<p>Password: <b>{$newpassword[0]}</b></p>
			<a href='$link'><p style='color:blue'>Link to LogIn</p></a>";
			//$mail->AltBody = 'Email: {$email}';

			$mail->send();
			echo 'Message has been sent';
		} catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
		//End of PHPMailer				
			
			// do work here			
			$formStatus="A new password has been sent to ".$email;
			header("Location:login.php");
	}else{
			$formStatus="Invalid email user";
	}
}

?>
<html>
<link rel="stylesheet" href=".\css\pure-release-1.0.0\pure-min.css">
<body>
<center>
<h1>Forget Password</h1>
<form name="myForm" method="post" class="pure-form pure-form-stacked">
<table border='0'>
  <tr>    
    <td><i class="far fa-envelope"></i>Email</td>
    <td><input type="email" name="email" value="<?=$email?>" pattern=".{1,}"   required title="Cannot be empty field" size="30"></td>
	<td><?php echo $error_name?>
  </tr> 
  <tr>
    <td></td>
    <td><br><input type="submit" name="submitted" value="Submit" class="pure-button pure-button-primary">
    </td>
  </tr>
  <tr>
	</tr>
  <tr>
	<td></td>
	<td><p style="color:red;"> <?php echo $formStatus?></p></td>
  </tr>
  <tr>
	<td></td>
	<td><a class="pure-button" href="./login.php">Log in</a></td>
  </tr>
</table>
</form>
</center>

<?php
include 'includes/footer.php';