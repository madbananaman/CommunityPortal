<?php
//For displaying the profile of the individual person in the Community Portal
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
$firstName="";
$lastName="";
$email="";

if (isset($_GET['email'])){
	$profile = $_GET['email'];
	//$profile = 'tanchintong@gmail.com';
	try {
		$info = new UserManager;
		$info -> getUserByEmail($profile);
		$firstName=$info->getUserByEmail($profile)->firstName;
		$lastName=$info->getUserByEmail($profile)->lastName;
		$email=$info->getUserByEmail($profile)->email;
	} catch (Exception $e) {
    echo 'Error exception: ',  $e->getMessage(), "\n";
}
}

?>

<center>
        <h1>Profile of <?=$firstName?> <?=$lastName?></h1>       
        <table class='pure-table'>
          <tr>
            <td><i class="fas fa-user"></i></i>First Name</td>
            <td><input type="text" name="firstName" value="<?=$firstName?>" size="50" readonly></td>
          </tr>
          <tr>
            <td><i class="fas fa-user"></i></i>Last Name</td>
            <td><input type="text" name="lastName" value="<?=$lastName?>" size="50" readonly></td>
          </tr>
          <tr>
            <td><i class="far fa-envelope">Email</td>
            <td><input type="text" name="email" value="<?=$email?>" size="50" readonly></td>
          </tr>
		  <tr>
			<td><i class="fas fa-info"></i>Information</td>
			<!--To replace with Biography of user if information exists in database-->
			<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi hendrerit consectetur est eget ultrices. Sed congue varius pellentesque. Nam laoreet at enim ut elementum. Maecenas sit amet egestas risus, et volutpat ipsum. Nulla ornare quam leo. Nunc vitae aliquet augue. Mauris blandit pellentesque efficitur. Proin rutrum orci est, in varius urna eleifend eget. Donec commodo facilisis pellentesque. Nulla sodales quam sit amet elit accumsan, vitae hendrerit augue mollis. Curabitur augue ante, tincidunt nec nisi et, posuere suscipit sapien. Etiam hendrerit metus rhoncus dui lacinia, eu pharetra erat molestie. Suspendisse potenti.</td>
		  </tr>
        </table>
</center>

<?php
include '../../includes/footer.php';