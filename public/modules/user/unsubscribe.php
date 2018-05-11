<?php
//For unsubscription from mass mailing services
///DOMAIN/testUnSubscribe.php?id=VALUE&hashkey=VALUE

use classes\business\SubscribeManager;
use classes\data\SubscribeManagerDB;
use classes\DBUtil\DBUtil;

$ini = parse_ini_file("../../../config/config.ini");
include_once $_SERVER["DOCUMENT_ROOT"].$ini['directory'].'classes/business/SubscribeManager.php';
include_once $_SERVER["DOCUMENT_ROOT"].$ini['directory'].'classes/data/SubscribeManagerDB.php';
include_once $_SERVER["DOCUMENT_ROOT"].$ini['directory'].'classes/util/DBUtil.php';

//Header
include '../../includes/header.php';
?>
<center>
<div class='container'>
<div class='jumbotron'>
<h1>Unsubscription Page</h1>

<form name="unsubscribe" method="post" class="pure-form pure-form-stacked">
    <table border='0'>
    <p>Do you wish to unsubscribe from the mailing list?</p>
    <tr>
        <td>
            <input type="submit" id='yes' name="yes" value="Yes" class="pure-button pure-button-primary" onclick="style.visibility = 'hidden'">
        </td>
        <td>
            <a href="../../login.php">
                <input type="button" value="No" class="pure-button pure-button-primary">
            </a>
        </td>
    </tr>
    
    </table>
</form>


<?php
/*
 * 1) Check $result from form. Proceed if $_POST['result']=='yes'
 * 2) Retrieve id and hashkey from url using $_GET
 * 3) Check existence of both keys
 * 4) Connect to SubscribeManager to execute unsubscribe($id,$hashkey)
*/
if(isset($_POST["yes"])){    
    $result='yes';

    if ($result=='yes'){
        if (isset($_GET['id'])){
                $id = $_GET['id'];
        	//echo 'id: '. $id . '<br>';
        }
        if (isset($_GET['hashkey'])){
                $hashkey = $_GET['hashkey'];
        	//echo 'Hashkey: ' . $hashkey . '<br>';
        }
        if (isset($id) && isset($hashkey)){
            //Check for presence of both id and hashkey    
            //Code to delete entry from tb_subscribe
                try{
                    $SM = new SubscribeManager();
                    $SM->unsubscribelink($id, $hashkey);
					//Feedback + Disable 'Yes' button
                    print "<p style='color:blue'>Successfully Unsubscribed</p>
                    <p>To resubscribe to mailing list, kindly login and update the profile page</p>
                    <script>
                        /*document.getElementById('yes').style.visibility = 'hidden';*/
                        document.getElementById('yes').disabled = 'true';
                    </script>";
                   //header( "Refresh:3; url=../../login.php", true, 303);
					 print('<meta http-equiv="Refresh" content="3; url=../../login.php">');
                } catch (Exception $e){
                    echo '<p>Failed: ',  $e->getMessage(), "\n</p>";
                        }
                } else {
                echo '<p style="color:red">Failed!!!</p>';
        }
    }
}
?>
<p>Proceed with <a style='color:blue' href='../../login.php'>login</a></p>
</div>
</div>
</center>
<?php
//Footer
include '../../includes/footer.php';