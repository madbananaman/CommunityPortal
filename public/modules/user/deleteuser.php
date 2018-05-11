<?php
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';
?>

<?php

$formMessage="";
$firstName="";
$lastName="";
$email="";
$password="";
$deleteflag=false;
$role="";

/*$UM=new UserManager();
  $existuser=$UM->getUserByEmail($_SESSION["email"]);
  $firstName=$existuser->firstName;
  $lastName=$existuser->lastName;
  $email=$existuser->email;
  $password=$existuser->password;
  $role=$existuser->role;*/

if(isset($_POST["submitted"])){
  if(isset($_GET["id"])){
       $UM=new UserManager();
       $existuser=$UM->getUserById($_GET["id"]);
	   $role=$existuser->role;
	   if ($role == "admin"){$formMessage="Unable to delete administrator. Please contact the Database administrator if necessary.";
	   }else {$existuser=$UM->deleteAccount($_GET["id"]);
        $formMessage="User deleted successfully.";
		$deleteflag=true;
		header("Location:../../modules/user/userlist.php");
		}	   
	}
}else if(isset($_POST["cancelled"])){
	header("Location:../../home.php");
}else{
	if(isset($_GET["id"]))
	{
	  $UM=new UserManager();
	  $existuser=$UM->getUserById($_GET["id"]);
	  $firstName=$existuser->firstName;
	  $lastName=$existuser->lastName;
	  $email=$existuser->email;
	  $password=$existuser->password;
	}
}
?>
<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
<center>
    <form name="deleteUser" method="post" class="pure-form pure-form-stacked">
    <h1>Delete User</h1>
    <div style="color:red"><?=$formMessage?></div>
<?php
if (!$deleteflag)
{
?>
<?php echo $_SESSION["email"]?>
<table width="800">
  <tr>
    <td style='color:red'>Are you sure that you want to delete the following record?</td>
  </tr>
   <tr>
    <td><?=$email?></td>
  </tr>
  <tr>
	<td></td>
    <td><input type="submit" name="submitted" value="Delete" class="pure-button pure-button-primary">
    <input type="submit" name="cancelled" value="Cancel" class="pure-button pure-button-primary"></td>
    </td>
  </tr>
</table>
<?php
}
?>
    </form>
</center>

<?php
include '../../includes/footer.php';