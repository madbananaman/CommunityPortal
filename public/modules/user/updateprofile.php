<?php
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;
use classes\business\Validation;
use classes\business\SubscribeManager;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';
?>

<?php

$formErr="";
$id="";
$firstName="";
$firstNameErr="";
$lastName="";
$lastNameErr="";
$email="";
$emailErr ="";
$password="";
$passwordErr ="";
$cPassword="";
$passwordMismatch ="";
$formError="";
$role="";
$subscribe=''; //To check against tb_subscribe
$validate=new Validation(); //From classes\business\Validation

if(!isset($_POST["submitted"])){
  $UM=new UserManager();
  $existuser=$UM->getUserByEmail($_SESSION["email"]);
  $id=$existuser->id;
  $_SESSION['$id'] = $id;
  $firstName=$existuser->firstName;
  $lastName=$existuser->lastName;
  $email=$existuser->email;
  //$password=$existuser->password;
  $password='';
  $role=$existuser->role;
  $SM=new SubscribeManager();
  //Check of existence of user's email in tb_subscribe
  if ($SM->getUserByEmail($email)){
      $subscribe=1; //$subscribe==1 => checkbox to be 'checked'
      $_SESSION["subscribe"]=$subscribe; //Store status of $subscribe in $_SESSION
  } else {
      $subscribe=''; //$subscribe=='' => checkbox NOT 'checked'
      unset($_SESSION["subscribe"]); //Clears the $_SESSION["subscribe"]
  }

}else{
  $firstName=$_POST["firstName"];
  $lastName=$_POST["lastName"];
  $email=$_POST["email"];
  $password=$_POST["password"];
  $cPassword=$_POST["cPassword"];
  if(isset($_POST["subscribe"])){
      $subscribe=1;      
  } else {
      $subscribe='';
  }	
  /*
   * 1. Validate inputs
   * 2. Set $update flag to true upon success
   * 3. If email is altered
   *    a) alter $_SESSION['email'] to prevent loggin out
   *    b) Check whether email exists in tb_subscribe through $_SESSION['subscribe']
   *        - Subscribe user if $subscribe == true OR
   *        - Create new instance of SubscribeManager, and alter email if email exists
   * 4. Create new instance of UserManager for update into tb_user
   */
  if ($validate->check_name($firstName, $firstNameErr)
		&& $validate->check_name($lastName, $lastNameErr) 
		&& $validate->email($email, $emailErr)
		&& $validate->check_password($password, $passwordErr)
		&& $validate->comparePassword($password, $cPassword, $passwordMismatch)
		){
       $update=true;
       $UM=new UserManager();
       //Check for duplication of email
       if($email!=$_SESSION["email"]){
           $existuser=$UM->getUserByEmail($email);
           if(is_null($existuser)==false){
               $formError="User Email already in use, unable to update email";
               $update=false;
           }
       }
       if($update){
           //tb_subscribe portion for subscription -START
            //Unsubscribe user if $subscribe == '';
            if (!$subscribe){
               $hashkey = '';
               $SM = new SubscribeManager();
               $SM->unsubscribe($_SESSION['$id'], $hashkey);
               unset($_SESSION["subscribe"]); //Clears the $_SESSION["subscribe"]
            } 
            /*Check whether email exists in tb_subscribe through $_SESSION['subscribe']
             * -subscribe user id user not in tb_subscribe
             * -alter email if user exist in tb_subscr
             */
                else if (isset($subscribe)){
                    $SM = new SubscribeManager();
                    $SM->subscribe($_SESSION['$id'],$email);
                } else if ($email!=$_SESSION["email"]){
                //Code to change email in tb_subscribe to new $email
                    $SM = new SubscribeManager();
                    $SM->updateEmail($_SESSION['$id'],$email);
                } //tb_subscribe portion for subscription -END                            
     
//Update of details into TB_User          
           $existuser=$UM->getUserByEmail($_SESSION["email"]);
           $existuser->firstName=$firstName;
           $existuser->lastName=$lastName;
           $existuser->email=$email;
           //$existuser->password=$password;
           //$existuser->password=password_hash($password, PASSWORD_DEFAULT); Only Hash
           //SALT == strlower($email). Concat strlower($email).$password to be stored in DB.
            $existuser->password=password_hash(strtolower($email).$password, PASSWORD_DEFAULT); 
           $UM->saveUser($existuser);
           //If user edits his email, alters $_SESSION["email"] to prevent user from getting logged out
            if ($_SESSION["email"] != $email){
                $_SESSION["email"]=$email;
           }
		   $formError="Profile updated successfully";
           //Redirection to home.php after editing profile
           //header("Location:../../home.php");
		   header( "Refresh:2; url=../../home.php", true, 303);
       }
  } else{
      $formError="Please provide required values";
  }
}
?>

 

<center>
    <div class='container'>
	<div class='jumbotron'>
	<form name="myForm" method="post" class="pure-form pure-form-stacked">
        <h1>Update Profile</h1>
        <!--<?php echo "Email " . $_SESSION["email"]?>-->
        <div style="color:red"><?=$formError?></div>
        <table>
          <tr>
            <td><i class="fas fa-user"></i></i>First Name</td>
            <td><input type="text" name="firstName" value="<?=$firstName?>" size="50" onclick="this.select();"></td>
                <td style="color:red"><?php echo $firstNameErr; ?></td>
          </tr>
          <tr>
            <td><i class="fas fa-user"></i></i>Last Name</td>
            <td><input type="text" name="lastName" value="<?=$lastName?>" size="50" onclick="this.select();"></td>
                <td style="color:red"><?php echo $lastNameErr; ?></td>
          </tr>
          <tr>
            <td><i class="far fa-envelope">Email</td>
            <td><input type="text" name="email" value="<?=$email?>" size="50" onclick="this.select();"></td>
                <td style="color:red"><?php echo $emailErr;?></td>
          </tr>
          <tr>
            <td><i class="fas fa-lock"></i>Password</td>
            <td><input type="password" name="password" value="<?=$password?>" size="20" onclick="this.select();"></td>
                <td style="color:red"><?php echo $passwordErr;?></td>
          </tr>
          <tr>
            <td><i class="fas fa-lock"></i>Confirm Password</td>
            <td><input type="password" name="cPassword" value="<?=$cPassword?>" size="20" onclick="this.select();"></td>
                <td style="color:red"><?php echo $passwordMismatch;?></td>
          </tr>
          <tr>
              <td></td>
              <td>
                  <label>
                      <input type="checkbox" id="subscribe" name="subscribe" <?php if ($subscribe) {echo "checked";}?>>
                      Subscribe to mailing list
                  </label>
              </td>
          </tr>
          <tr>
                <td></td>
            <td><input type="submit" name="submitted" value="Submit" class="pure-button pure-button-primary">
                <input type="submit" name="reset" value="Reset" class="pure-button pure-button-primary"></td><!--Form will not reset to old values if type='reset'-->
            </td>
          </tr>
        </table>
    </form>
	</div>
	</div>
</center>

<?php
include '../../includes/footer.php';
?>