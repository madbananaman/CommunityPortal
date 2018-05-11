<?php
namespace classes\business;

use classes\entity\User;
use classes\data\UserManagerDB;

class Validation
{
	//For first and last name entry
	public function check_name($input, &$error){
		if (empty($input)){
			$error = "Please enter your name";
			return false;
		} else if (!preg_match("/^[a-zA-Z ]*$/",$input)){ 
			$error = "Only letters and white space allowed"; 
			return false;
		} return true;
	}
	//For email entry
	public function email($input, &$error){
		if (!filter_var($input, FILTER_VALIDATE_EMAIL) == false){ 
			//echo "Email input: " . $input;
			return true;
		} else {
		$error = "Invalid email address";
		return false;}
	}
	//For comparison of password and cPassword
		public function comparePassword($input, $input2, &$error){
		if ($input != $input2){ 
			$error = "Passwords do not match. Please re-enter the passwords.";
			return false;
		} else {
		return true;}
		}
	
	//For password entry
	public function check_password($input, &$error){
		/*Original code
		if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/",$input)){ 
			$error = "Password must consist of at least 6 characters with at least one uppercase letter, one lowercase letter and one digit."; 
			return false;
		}*/
		//Password cannot be blank
		if(strlen($input) == 0){
				$error = 'Please key in your password.';
				return false;
			}
		//Password to be at least 8 digits	
			if(strlen($input) < 8){
				$error = 'Password must be at least 8 characters.';
				return false;
			}
		//Password to contain one uppercase	
			if (!preg_match("@[A-Z]@",$input)) {
				$error = "Password must contain an Uppercase character. E.g. A, B, C, etc.";
				return false;
			}
		//Password to contain one lowercase
			if (!preg_match("@[a-z]@",$input)) {
				$error = "Password must contain a lowercase character. E.g. a, b, c, etc."; 
				return false;
			}
		//Password to contain one number	
			if (!preg_match("@[0-9]@",$input)) {
				$error = "Password must contain a number. e.g. 1, 2, 3, etc."; 
				return false;
			}
		/*	Disabled for easy entry of password.	
		//Password to contain one special character (!@#$%^)
			if (!preg_match("@[^\w]@",$_POST['password'])) {
				$error = "Password must contain a special character. e.g. !, @, #, %, ^ etc.";
				return false;
			}
		*/			
		return true;
	}
}