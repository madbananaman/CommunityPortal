<?php
namespace classes\business;

use classes\entity\User;
use classes\data\UserManagerDB;


class UserManager
{
    public static function getAllUsers(){
        return UserManagerDB::getAllUsers();
    }
    public function getUserByEmailPassword($email,$password){
        return UserManagerDB::getUserByEmailPassword($email,$password);
    }
    public function getUserByEmail($email){
        return UserManagerDB::getUserByEmail($email);
    }
    public function getUserById($id){
        return UserManagerDB::getUserById($id);
    }
    
    public function searchUser($condition){
        $result = UserManagerDB::searchUser($condition);
        if ($result->num_rows > 0) {
            //Start creation of <table>
            echo "<center><table class='pure-table pure-table-bordered' width='800'>
                <thead>
                   <th><b><i class='fas fa-user'></i></i>First Name</b></th>
                   <th><b><i class='fas fa-user'></i></i>Last Name</b></th>
                   <th><b><i class='far fa-envelope'></i>Email</b></th>
                </thead>";    
             while($row = $result->fetch_assoc()) { 
                $link = '"link"';
                $email = $row['email'];
                $output = str_replace("link",$email,$link);;
                print("<tr onclick='directToProfile($output)'>");
                print("<td>{$row['firstname']}</td>"
                        . "<td>{$row['lastname']}</td>"
                        . "<td>{$row['email']}</td>"
                        . "</tr>");
            } print("</table></center>");
		} else {
			print("<center><p style='color:red'>Sorry, 0 result found.</p></center>");
		}
    }
    
    public function saveUser(User $user){
        UserManagerDB::saveUser($user);
    }
	
	public function updatePassword($email,$password){
        UserManagerDB::updatePassword($email,$password);
    }
	
	public function deleteAccount($id){
        UserManagerDB::deleteAccount($id);
    }
	public function randomPassword($length,$count,$characters) 
	{
		// $length - the length of the generated password
		// $count - number of passwords to be generated
		// $characters - types of characters to be used in the password
		 
		// define variables used within the function    
		$symbols = array();
		$passwords = array();
		$used_symbols = '';
		$pass = '';
 
		// an array of different character types    
		$symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
		$symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$symbols["numbers"] = '1234567890';
		$symbols["special_symbols"] = '!?~@#-_<>[]{}';
 
		$characters = explode(",",$characters); // get characters types to be used for the passsword
		foreach ($characters as $key=>$value) {
                    $used_symbols .= $symbols[$value]; // build a string with all characters
		}
		$symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1
		 
		for ($p = 0; $p < $count; $p++) {
                    $pass = '';
                    for ($i = 0; $i < $length; $i++) {
                        $n = rand(1, $symbols_length); // get one minimum random character from the string with all characters
                        $pass .= $used_symbols[$n]; // add the character to the password string
                    }
                    $passwords[] = $pass;
		}
		return $passwords; // return the generated password
	} //end of generate random password function
	
	//Function to retrieve key and value from qSearch[]. For use in SearchUser.php
	public function searchFunction(array $pair){
	//Prevent nonsensical data in case HTML failed to catch it. Redundant? if regex pattern is set up in HTML tags.	
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data, ENT_COMPAT);
			return $data;
			}
			$condition = array(); 
			//Convert the key-value array to normal array ["keyvalue1", "keyvalue2", "keyvalue3"]
			foreach ($pair as $key => $value){
				if ($value != ""){
					//$condition[] = "{$key} LIKE '%{$value}%'"; //Unstripped version
					$condition[] = $key . " LIKE '%" . test_input($value) . "%'";
				}           
			} 
			// Separate by ' OR ' delimiter if there are more than 1 pair 
			$condition = join(' OR ', $condition); //OR use implode      
			//print ("CONDITION: " . $condition);
			// Return prepared string:
			return ($condition);            
		}//function create_sql_select END	
}