<?php
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use classes\business\SubscribeManager;
use classes\business\MessageManager;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';
//Load Composer's autoloader for phpmailer
include '../../../classes/phpmailer/vendor/autoload.php';
$ini = parse_ini_file("$dir/../../config/config.ini");

$UM=new UserManager();
$users=$UM->getAllUsers();
$SM=new SubscribeManager();
$subscribedEmail=$SM->subscribedEmailArray();
$dataArray=$SM->dataArray();
$_SESSION["dataArray"] = $dataArray;
if(isset($users)){
?>

<br/><br/>
<center>
<h1>Below is the list of Developers registered in community portal</h1>
<h3 style='color:blue'>Corresponding checkbox for users unsubscribed to mass mailing is disabled</h3>

<form method='post' name='mail' onsubmit="window.location.href = '#mailList'">			
    <table class="pure-table pure-table-bordered" width="800">
        <tr>
            <thead>	
                <th><b><i class="fas fa-user"></i></i>Id</b></th>
                <th><b><i class="fas fa-user"></i></i>First Name</b></th>
                <th><b><i class="fas fa-user"></i></i>Last Name</b></th>
                <th><b><i class="far fa-envelope"></i>Email</b></th>
                <th colspan="2"><b><i class="fas fa-briefcase"></i>Operation</b></th>
                <th><b><i class="far fa-envelope"></i>Mail</b></th>
            </thead>
        </tr>		
<?php 

foreach ($users as $user) {
    if($user!=null){
        //array_push($selectAll, $user->email); //Fill *ALL* email addresses in TB_user into $selectAll array
?>    
        <tr>
            <td><?=$user->id?></td>
            <td><?=$user->firstName?></td>
            <td><?=$user->lastName?></td>
            <td><?=$user->email?></td>
            <td><a href='deleteuser.php?id=<?=$user->id;?>'><?php if($user->role != 'admin'){echo 'Delete';}?></a></td>
            <td><a href='edituser.php?id=<?=$user->id;?>'><?php if($user->role != 'admin'){echo 'Edit';}?></a></td>				
            <!-- Javascript code inserted to make box easier to click -->
            <td onclick="easyCheckBoxClick('<?=$user->email;?>')">
                <input onclick="this.checked = !this.checked;" 
                       id='<?=$user->email;?>' 
                       type='checkbox' 
                       class='checkbox' 
                       name='checkbox[]' 
                       value='<?=$user->email;?>' 
                       <?php if (!in_array($user->email, $subscribedEmail)){
                           echo "disabled";}
                       ?>
                       >
            </td>
        </tr>					
<?php 
        }
    } 
?>
        <tr>
            <td colspan=4></td>
            <!--<td><input type='submit' name='selectAll' value='Select All' href='#mailList'></td>--><!--Send message to ALL personnel-->
            <td><input type='submit' name='allSubscribed' value='All Subscribed' href='#mailList'></td>
            <td><input type='submit' name='mail' value='Mailing list'></td>
            <td><input type='submit' name='reset' value='Reset'></td>
        </tr>
    </table>
</form>
</center>
<br>
<?php	
$checkbox=array(); //Selected emails from Checkbox
if(!empty($_REQUEST['mail'])){    
    if (!empty($_POST['checkbox'])){    
        $checkbox = $_POST['checkbox'];       
    }else {
        $checkbox=array();
        unset($_SESSION["checkbox"]);
        echo "<center><p style='color:red'>Please check one or more boxes above to select the recipients of the message.</p></center>";	}// END -- if (!empty($_POST['checkbox']))
        } else if (!empty($_POST['allSubscribed'])){
            $checkbox = $subscribedEmail; //Assigning all subscribed emails in tb_subscribe to $checkbox
        }/*
        else if (!empty($_POST['selectAll'])){
                $checkbox = $selectAll; //Assigning all emails in TB_Users to $checkbox DISABLED
        } */ 
 //Clears entry in mailingList when reset button is pressed
if (!empty($_POST['reset'])){
    $checkbox=array();
    unset($_SESSION["checkbox"]); 
}
?>	
	
	
<!--For sending Messages to selected personnels-->
<center>
<form name='mailList' method='POST'>
    <table id='mailList' class="pure-table pure-table-bordered" width="800">
        <thead>
            <th colspan='2'><center><b><i class="far fa-envelope"></i>Message sending</b></center></th>
        </thead>
        <tr><td><b>Recipients</b></td>
            <td style='color:blue'>
                <?php 
                if ($checkbox){
                    $_SESSION['checkbox'] = $checkbox; //To include input for checkbox
                    echo(implode("; ",$checkbox));
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td><b>Subject</b></td>
            <td><input type=text name='subject' size=50></td></tr>
        <tr>
            <td>
                <b>Message</b>
            </td>
            <td>
                <textarea rows="5" cols="50" name='message'>
                </textarea>
            </td>
        </tr>			
        <tr>
            <td></td>
            <td>
                <Input type='submit' name='mailList'>
                <Input type='reset' name='mailList'>
            </td>
        </tr>
    </table>
</form>
</center>
<?php 
}
?>

<?php
//$SM = new SubscribeManager(); for use with Method2 mass mailing loop
//For sending out messages
if (isset($_POST['mailList'])){
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    //PHPMailer code
    $mail = new PHPMailer(true);
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
        $mail->Port = 465;										//TCP port to connect to.Gmail SMTP port (TLS): 587. Gmail SMTP port (SSL): 465			

        //Recipients
        $mail->setFrom('USERNAME@gmail.com', 'USERNAME');			//Sender's details
        //Add recipient by getting information from $_SESSION["checkbox"]
        $mail->isHTML(true);            // Set email format to HTML
        
        if (!empty($_SESSION["checkbox"])){
            //SQL code for inserting into TB_Message
            $authorID=$_SESSION['id'];
            $author=$_SESSION['email'];
            $recipients=implode("; ",$_SESSION['checkbox']);
            $MM = new MessageManager();
            $MM->saveMessage($authorID, $author, $recipients, $subject, $message);
            //Mass mailing section looping method
            for($i=0;$i<count($_SESSION["checkbox"]);$i++){
                $recipient=$_SESSION["checkbox"][$i];
                //print_r($i . " : " . $recipient . "<br>");                
                $link = $ini['path']."public/modules/user/unsubscribe.php?id={$_SESSION["dataArray"][$recipient][0]}&hashkey={$_SESSION["dataArray"][$recipient][1]}";
                $mail->addBCC($recipient); //BCC to prevent recipeint from viewing all the email address
                $mail->Subject = $subject;
                $mail->Body = "<p>Dear Sir/Madam,</p>
                <p>{$message}</p>
                <p>Thanks and regards</p>
                <p>ABC Jobs Pte Ltd</p>
                <p>To unsubscribe to mass mailing, kindly click on the link below:</p>
                <a href='{$link}'><p style='color:blue'>LINK to unsubscribe</p></a>";
                //Code for sending out messages
                if (!$mail->send()) {
                    $msg .= "Mailer Error: " . $mail->ErrorInfo;
                }else {
                //echo "Message sent to {$recipient}";
                    $mail->clearAllRecipients(); //Clear recipients per cycle
                }
            }
            /*
            //Mass mailing Method2- Retrieve data from Database. Performance is slower if there are a lot of addresses involved
            foreach($_SESSION["checkbox"] as $recipient){
                $id=$SM->getUserByEmail($recipient)->id;
                $hashkey=$SM->getUserByEmail($recipient)->hashkey;;
                $link = $ini['path']."public/module/user/unsubscribe.php?id={$id}&hashkey={$hashkey}";
                $mail->addBCC($recipient); //BCC to prevent recipeint from viewing all the email address
                $mail->Subject = $subject;
                $mail->Body = "<p>Dear Sir/Madam,</p>
                <p>{$message}</p>
                <p>Thanks and regards</p>
                <p>ABC Jobs Pte Ltd</p>
                <p>To unsubscribe to mass mailing, kindly click on the link below:</p>
                <a href='{$link}'><p style='color:blue'>LINK to unsubscribe</p></a>";
                //Code for sending out messages            
                //Code for sending out messages
                if (!$mail->send()) {
                    $msg .= "Mailer Error: " . $mail->ErrorInfo;
                }else {
                //echo "Message sent to {$recipient}";
                    $mail->clearAllRecipients(); //Clear recipients per cycle
                }
            }
            //End - retrieve from Database method
            */
            
        } else {
            echo "<p style='color:red'>No email in Recipient list</p>";
        }
        
        //Unregister $_SESSION["checkbox"]
        unset($_SESSION["checkbox"]); 
        $mail->clearAllRecipients();
        $mail->clearAttachments();        
        } catch (Exception $e) {
        echo "<p style='color=red'>Message could not be sent. Mailer Error: ", $mail->ErrorInfo . "</p>";
        }

}
?>

<?php
include '../../includes/footer.php';