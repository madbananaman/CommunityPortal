<?php
session_start();

use classes\business\UserManager;
use classes\business\Validation;

require_once __DIR__.'/includes/autoload.php';
include_once __DIR__.'/includes/header.php';

$formerror="";

if(isset($_GET['email'])){
    $email=$_GET['email'];
} else {
    $email='';}
if(isset($_GET['password'])){
    $password=$_GET['password'];
} else {
    $password='';
}
$error_auth="";
$error_name="";
$error_passwd="";
$error_email="";
$validate=new Validation();

if(isset($_POST["submitted"])){
    $email=$_POST["email"];
    $password=$_POST["password"];	
    if($validate->check_password($password, $error_passwd)){
        $UM=new UserManager();
        $existuser=$UM->getUserByEmail($email);
        if (isset($existuser)){
            //SALT == $email
            $hashedPassword = $existuser->password; //hashed password in Database
            if(password_verify(strtolower($email).$password, $hashedPassword)){
            $_SESSION['email']=$email;
            $_SESSION['id']=$existuser->id;
            $_SESSION['role']=$existuser->role; //To retrieve role of logged in personnel.
            echo '<meta http-equiv="Refresh" content="1; url=home.php">';
            }else{
            $formerror="Invalid Email or Password"; //Displays a message if either email or password is wrong
            }	
            } //Check existence of email
            else{
                $formerror="Invalid Email or Password"; //Displays a message if either email or password is wrong
            }
    }
}

?>
<br>
<div class='background-login'>
<center>    
    <h1 class="banner-head">ABC Jobs Portal Log In Page</h1>
    <br>
    <form name="myForm" method="post" class="pure-form pure-form-stacked">
        <table border='0'>
          <tr>    
            <td style='color:orange'><i class="far fa-envelope"></i>Email</td>
            <td><input type="email" name="email" value="<?=$email;?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required title="Cannot be empty field" size="30" onclick="this.select();" placeholder="e.g.johnsmith@abc.com"></td>
            <td><?=$error_name;?></td>
          </tr>
          <tr>    
            <td style='color:orange'><i class="fas fa-lock"></i>Password</td>
            <td><input type="password" name="password" value="<?=$password;?>"  size="30" onclick="this.select();" placeholder='e.g. !@Qw12as'></td>
            <td></td>
          </tr> 
          <tr>
            <td></td>
            <td style="color:red"><?php echo $error_passwd?><?=$formerror;?></td>
          </tr>
          <tr>
            <td></td>
            <td><br>
                <input type="submit" name="submitted" value="Submit" class="pure-button pure-button-primary">
                <input type="submit" name="reset" value="Reset" class="pure-button pure-button-primary"></td>
            </td>
          </tr>
          <tr></tr>
          <tr>
          <td></td>
            <td>
               <br>
				<a class="pure-button" href="modules/user/register.php">Register Now</a>
				<a class="pure-button" href="./forgetpassword.php">Forget Password</a>
            </td>
          </tr>   
        </table>
    </form>

    <br>
    <div>
        <h2 style='color:red'>Community Job Portal for Programmers and Employers</h2>
    </div>
    <br>
    <br>
</div>
</center>
<?php
include 'includes/footer.php';
?>