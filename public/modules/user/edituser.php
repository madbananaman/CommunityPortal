<?php
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;
use classes\business\Validation;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';

$formErr="";
$firstName="";
$firstNameErr="";
$lastName="";
$lastNameErr="";
$email="";
$oldEmail="";
$emailErr ="";
$password="";
$passwordErr ="";
$cPassword="";
$passwordMismatch ="";
$formError="";
$update=0;
$validate=new Validation(); //From classes\business\Validation
$UM=new UserManager();

if(!isset($_POST["submitted"])){
//Retrieve details of user from database through getUserById($_GET["id"]).

$existuser=$UM->getUserById($_GET["id"]);
$firstName=$existuser->firstName;
$lastName=$existuser->lastName;
$email=$existuser->email;
$oldEmail=$existuser->email; //Old Email in database
//$password=$existuser->password;
$password='';
$role=$existuser->role;

} else {
        $firstName=$_POST["firstName"];
	$lastName=$_POST["lastName"];
        $email=$_POST["email"];
	$password=$_POST["password"];
	$cPassword=$_POST["cPassword"];
        $UM=new UserManager();
	//Validation of inputs
        if ($validate->check_name($firstName, $firstNameErr) 
		&& $validate->check_name($lastName, $lastNameErr) 
		&& $validate->email($email, $emailErr)
		&& $validate->check_password($password, $passwordErr)
		&& $validate->comparePassword($password, $cPassword, $passwordMismatch)
		){        
		/*
		 *Check whether newly input email exist in database $oldEmail=(getUserByEmail($_GET["id"])). 
		 *  Check for new versus old email 
		 *      $oldemail = $newemail => Allow update 
                 *      Duplicate email => Do not update
		*/ 		
		//Check for existence of entry with new $email
                $existEmailCheck=$UM->getUserByEmail($email);
                $existuser=$UM->getUserById($_GET["id"]);
                $oldEmail=$existuser->email; //Old Email in database
		//Check whether newly input email exist in database
                if(!$existEmailCheck){
                    //Allow update if no duplicate email found in DB
                    $update=1;
                } else if($existEmailCheck){
                    if($oldEmail == $email){
                        //Allow update if $oldmail == $email
                        $update=1;
                    } else {
			//Do not update if duplicate email
			$formError="User Email already in use, unable to update email";
			$update=0;
			} 
                } 
		
        //Perform update of database if $update == true
        if($update){
           echo "Updating {$update} <br><br>";
           $existuser=$UM->getUserById($_GET["id"]);
           $existuser->firstName=$firstName;
           $existuser->lastName=$lastName;
           $existuser->email=$email;
           //$existuser->password=$password; //Non-hash version
		   //SALT == strlower($email). Concat strlower($email).$password to be stored in DB.
		   $existuser->password=password_hash(strtolower($email).$password, PASSWORD_DEFAULT); //SALT=$email
           $UM->saveUser($existuser);
           //print "FirstName: {$firstName} LastName: {$lastName} Email: {$email}";
           header("Location:../../modules/user/userlist.php");
		    
       } 
                }
       }
?>
<?php //echo "Session-email " . $_SESSION["email"] . "<br>"; ?>
<?php //echo "get-id " . $_GET["id"] . "<br>";?>
<center>
    <form name="myForm" method="post" class="pure-form pure-form-stacked">
        <h1>Edit User</h1>
        <div style="color:red"><?=$formError?></div>
        <table width="800">
          <tr>
            <td><i class="fas fa-user">First Name</td>
            <td><input type="text" name="firstName" value="<?=$firstName?>" size="50" onclick="this.select();"></td>
                <td style="color:red"><?php echo $firstNameErr; ?></td>
          </tr>
          <tr>
            <td><i class="fas fa-user">Last Name</td>
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
            <td><input type="submit" name="submitted" value="Submit" class="pure-button pure-button-primary">
            <input type="submit" name="reset" value="Reset" class="pure-button pure-button-primary"></td><!--Form will not reset to old values if type='reset'-->
            </td>
          </tr>
        </table>
    </form>
</center>

<?php
include '../../includes/footer.php';