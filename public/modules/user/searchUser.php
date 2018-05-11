<?php
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';

$UM=new UserManager();
$users=$UM->getAllUsers();

if(isset($users)){
    ?>

<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
<center>   
    <h1>Search users located registered with the Community Portal</h1>
    <h3 style='color:blue'>Click on the respective row to view individual profile.</h3>
        <form class="pure-form" method="post">    
            <b>First Name </b><input type="text" name="qSearch[firstname]" onclick="this.select();">
            <b>Last Name</b></th><th><input type="text" name="qSearch[lastname]" onclick="this.select();">
            <b>Email</b></th><th><input type="text" name="qSearch[email]" onclick="this.select();"> 
            <button input type="submit" name ="search"  value="Search"><i class="fas fa-search"></i>Search</button>	
        </form>       
	<br>
</center>    
    
<?php
if(!empty($_REQUEST['search'])){    
    if (!empty($_POST['qSearch'])){    
        $qSearch = $_POST['qSearch'];       
        $UM = new UserManager();
        //Output of NULL if the input is absent. Returns the condtion e.g. firstName LIKE %% OR lastName like %%
        $stmt = $UM->searchFunction($qSearch); 
        //print("Conditon: {$stmt}"); //Output for condition
        if ($stmt){
            $UM=new UserManager();
            $b=$UM->searchUser($stmt);
    } else {
        echo "<p style='color:red'>Please enter some search input.</p>";
    }
        }// END -- if (!empty($_POST['qSearch']))
}
?>
                    
<center>
    <table class="pure-table pure-table-bordered" width="800">
        <tr><h1>All Registered Users</h1></tr>    
        <tr>
            <thead>
               <!--<th><b>Id</b></th>-->
               <th><i class="fas fa-user"></i><b>First Name</b></th>
               <th><i class="fas fa-user"></i><b>Last Name</b></th>
               <th><i class="far fa-envelope"></i><b>Email</b></th>	   
            </thead>
        </tr>    
    <?php 
    foreach ($users as $user) {
        if($user!=null){
            ?>
            
            <tr onclick='directToProfile("<?=$user->email?>")'>
               <!--<td><?=$user->id?></td>-->
               <td><?=$user->firstName?></td>
               <td><?=$user->lastName?></td>
               <td><?=$user->email?></td>
            </tr>
            <?php 
        }
    }
    ?>
    </table><br/><br/>
    </center>
    <?php 
}
?>

<?php
include '../../includes/footer.php';
?>