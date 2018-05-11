<?php
//For subscription to mass mailing services
namespace classes\business;
use classes\entity\User;
use classes\data\UserManagerDB;
use classes\data\SubscribeManagerDB;

class SubscribeManager
{	
	//For populating $selectAll array in userlist.php for bulk mailing
	public static function getAllUsers(){
        return SubscribeManagerDB::getAllUsers();
    }
	//For entry into tb_subscribe
    public static function subscribe($id, $email){
		//$hashkey to be stored as token for subscription/unsubscription
		$hashkey = md5($id);
		return SubscribeManagerDB::subscribe($id, $email, $hashkey);
	}
	
	//For deletion of entry in tb_subscribe in editprofile.php
	public static function unsubscribe($id, $hashkey){
		/*$hashkey to be stored as token for subscription/unsubscription
		 * To include a salt or other encryption algorithm to complicate the $hashkey if necessary
		 * $hashkey = md5($id);
		*/
		if ($hashkey == ''){			
			$hashkey = md5($id);
		}
		return SubscribeManagerDB::unsubscribe($id, $hashkey);
	}
        
        //Unsubscribe.php
        public static function unsubscribelink($id, $hashkey){
		return SubscribeManagerDB::unsubscribe($id, $hashkey);
	}
        
	//For retrival of email entry from tb_subscribe
	public function getUserByEmail($email){
        return SubscribeManagerDB::getUserByEmail($email);
    }
	//For update of email in tb_subscribe
	public function updateEmail($id, $email){
		return SubscribeManagerDB::updateEmail($id, $email);
	}
	//Returns all details as array format - NOT used
	public static function getAllUsersArray(){
            return SubscribeManagerDB::getAllUsersArray();
    }
	//To retrieve entry in tb_subscribe
	public function getUserByHashkey($hashkey){
        return SubscribeManagerDB::getUserByHashkey($hashkey);
    }
	public static function subscribedEmailArray(){
		$subscribedUsersResult=SubscribeManagerDB::getAllUsersArray();
		$subscribedUsersArray = array(); //Array containing all information (e.g. id, email, hashkey) of subscribed users in TB_subscribe.
		foreach ($subscribedUsersResult as $entry) {
		array_push($subscribedUsersArray, $entry); //Array to send email to **ALL** users in TB_subscribe. Tied to Select All button
		}
		$subscribedEmail = array_column($subscribedUsersArray, 'email'); 
		return $subscribedEmail;
    }
	public static function dataArray(){
		/* $dataArray = array($email1 => array($id1,$hashkey1), $email2 => array($id2,$hashkey2), $email3 => array($id3,$hashkey3));
		 * Stores information in $_SESSION["dataArray"] for use in sending out id and hashkey in mass mailing deactivation link.
		 * Deactivation link: url/unsubscribe.php?id=$id&hashkey=$hashkey
		*/
		$subscribedUsersResult=SubscribeManagerDB::getAllUsersArray();
		$subscribedUsersArray = array(); //Array containing all information (e.g. id, email, hashkey) of subscribed users in TB_subscribe.
		foreach ($subscribedUsersResult as $entry) {
			array_push($subscribedUsersArray, $entry); //Array to send email to **ALL** users in TB_subscribe. Tied to Select All button
		}
		$subscribedEmail = array_column($subscribedUsersArray, 'email');
		$subscribedId = array_column($subscribedUsersArray, 'id'); //Stores all the subscribed ids in TB_subscribe in array.
		$subscribedHashkey = array_column($subscribedUsersArray, 'hashkey'); //Stores all the subscribed hashkey ids in TB_subscribe in array.
		$dataArray = array();
		for($i=0; $i<count($subscribedEmail); $i++){
			$dataArray[$subscribedEmail[$i]] = array($subscribedId[$i],$subscribedHashkey[$i]);
		}
		return $dataArray;
}
    
}