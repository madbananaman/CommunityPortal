<?php
//session_start();
require_once '../../includes/autoload.php';
include '../../includes/header.php';
use classes\util\DBUtil;
use classes\business\UserManager;
use classes\entity\User;
use classes\business\Validation;
use classes\business\SubscribeManager;

//Variables
$formErr="";
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
$subscribe="on"; //Subscription to mass mail. Default set to 'checked'
$validate=new Validation(); //From classes\business\Validation

if(isset($_REQUEST["regSubmit"])){
    //Retrieve data upon clicking of submit button
    $firstName=$_REQUEST["firstName"];
    $lastName=$_REQUEST["lastName"];
    $email=$_REQUEST["email"];
    $password=$_REQUEST["password"];
    $cPassword=$_REQUEST["cPassword"];
    if(isset($_REQUEST["subscribe"]))
        {$subscribe='on';}
        else {$subscribe='';}	
	    
	//Validation of inputs
	if ($validate->check_name($firstName, $firstNameErr) 
            && $validate->check_name($lastName, $lastNameErr) 
            && $validate->email($email, $emailErr)
            && $validate->check_password($password, $passwordErr)
            && $validate->comparePassword($password, $cPassword, $passwordMismatch)
            ){
	
            $UM=new UserManager();
            $user=new User();
            $user->firstName=$firstName;
            $user->lastName=$lastName;
            $user->email=$email;
            //$user->password=$password; UnHashed version
            //$user->password=password_hash($password, PASSWORD_DEFAULT);
            //SALT == strlower($email). Concat strlower($email).$password to be stored in DB.
            $user->password=password_hash(strtolower($email).$password, PASSWORD_DEFAULT);
            $user->role="user";	//Default role of registrants: "user"
            $existuser=$UM->getUserByEmail($email); 
    
            //Check for dupplicate entry of email in database
            if(!isset($existuser)){
                //Save the Data to Database
                $UM->saveUser($user);
                //id of new entry
                $id = $UM->getUserByEmail($email)->id;
                //Add entry to TB_Subscribe if checkbox is checked				
                if ($subscribe){
                    $subscribeManager = new SubscribeManager();
                    $subscribeManager->subscribe($id,$email);
                }
                //For redirection to registerthankyou.php
                    header("Location:registerthankyou.php");
                    echo '<meta http-equiv="Refresh" content="1; url=./registerthankyou.php">';
            }
             else{
                $formError="Email entry already exist.";		
            }
            //Insertion of data into TB_Subscribe table         
	}//End of Insert
	
	
}//End of $_REQUEST["regSubmit"]


?>
<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">

<div class='background-register'>
<center>
    <form name="myForm" method="post" class="pure-form pure-form-stacked">
    <h1 class='banner-head'>ABC Jobs Portal Registration Form</h1>
    <div style="color: red; font-weight:bold"><?=$formError?></div>
        <table width="800">
          <tr>
            <td style='color:orange'><i class="fas fa-user"></i></i>First Name</td>
            <td><input type="text" name="firstName" value="<?=$firstName?>" size="50" onclick="this.select();" placeholder='e.g. John'></td>
                <td style="color:red"><?php echo $firstNameErr; ?></td>
          </tr>
          <tr>
            <td style='color:orange'><i class="fas fa-user"></i></i>Last Name</td>
            <td><input type="text" name="lastName" value="<?=$lastName?>" size="50" onclick="this.select();" placeholder='e.g. Smith'></td>
                <td style="color:red"><?php echo $lastNameErr; ?></td>
          </tr>
          <tr>    
            <td style='color:orange'><i class="far fa-envelope">Email</td>
            <td><input type="text" name="email" value="<?=$email?>" size="50" onclick="this.select();" placeholder='e.g. johnsmith@abc.com'></td>
                <td style="color:red"><?php echo $emailErr;?></td>
          </tr>
          <tr>    
            <td style='color:orange'><i class="fas fa-lock"></i>Password</td>
            <td><input type="password" name="password" value="<?=$password?>" size="20" onclick="this.select();" placeholder='e.g. !@QwAs12'></td>
                <td style="color:red"><?php echo $passwordErr;?></td>
          </tr>  
          <tr>    
            <td style='color:orange'><i class="fas fa-lock"></i>Confirm Password</td>
            <td><input type="password" name="cPassword" value="<?=$cPassword?>" size="20" onclick="this.select();" placeholder='e.g. !@QwAs12'></td>
            <td style="color:red"><?php echo $passwordMismatch;?></td>
          </tr>
          <tr>
              <td>
              </td>
              <td>
                  <label class="pure-checkbox" style='color:orange'>
                      <input type="checkbox" id="subscribe" name="subscribe" <?php if ($subscribe) {echo "checked";}?>>
                      Subscribe to mailing list
                  </label>
              </td>
          </tr>
          <tr>
              <td></td>
              <td>
               <input type="submit" name="regSubmit" value="Submit">
               <input type="submit" name="reset" value="Reset">
            </td>
          </tr>
        </table>
    </form>
    <br>
    <div>
        <h2 style='color:red'>Community Job Portal for Programmers and Employers</h2>
    </div>   
</div>    
</center>
<?php
include '../../includes/footer.php';