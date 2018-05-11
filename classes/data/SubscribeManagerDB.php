<?php
namespace classes\data;
use classes\entity\User;
use classes\util\DBUtil;


class SubscribeManagerDB {
    public static function fillUser($row){
     //Array Method
    $user = array();
    $user["id"]=$row["id"];
    $user["email"]=$row["email"];
    $user["hashkey"]=$row["hashkey"];
    $user["subscribe_date"]=$row["subscribe_date"];
    return $user;
    
    /*Using class User Method*/
    /*$user=new User();
    $user->id=$row["id"];
    $user->email=$row["email"];
    $user->hashkey=$row["hashkey"];
    $user->subscribe_date = $row["subscribe_date"];
    return $user;*/
    }
	
    //For subscribing to mass mail service
    public static function subscribe($id, $email, $hashkey){
    $conn=DBUtil::getConnection();
    $id=mysqli_real_escape_string($conn,$id);
    $email=mysqli_real_escape_string($conn,$email);
    $sql="INSERT INTO tb_subscribe (`id`, `email`, `hashkey`) VALUES ('$id', '$email', '$hashkey')";
    $result = $conn->query($sql);
    $conn->close();
    }
	
    //For unsubscription to mass mail service
    public static function unsubscribe($id, $hashkey){
        $conn=DBUtil::getConnection();
        $id=mysqli_real_escape_string($conn,$id);
        $hashkey=mysqli_real_escape_string($conn,$hashkey);
        $sql="DELETE FROM tb_subscribe where id='$id' and hashkey='$hashkey'";
        $result = $conn->query($sql);
        $conn->close();
    }
	
//For retrieval of record through email
public static function getUserByEmail($email){
    $user=NULL;
    $conn=DBUtil::getConnection();
    $email=mysqli_real_escape_string($conn,$email);
    $sql="select * from tb_subscribe where email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        if($row = $result->fetch_assoc()){
            $user=self::fillUser($row);
        }
    }
    $conn->close();
    return $user;
}

//For updating of email
public static function updateEmail($id, $email){
    $user=NULL;
    $conn=DBUtil::getConnection();
    $email=mysqli_real_escape_string($conn,$email);
    $sql="UPDATE tb_subscribe SET email='$email' WHERE id=$id;";		
    $result = $conn->query($sql);
    $conn->close();
}

//For retrieval of all records in tb_subscribe NOT used at the moment
public static function getAllUsers(){
    $users[]=array();
    $conn=DBUtil::getConnection();   
    $sql="SELECT * FROM tb_subscribe";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            $user=self::fillUser($row);
            $users[]=$user;
        }
    }
    $conn->close();
    return $users;
}

//To return result as array
public static function getAllUsersArray(){
    $users[]=array();
    $conn=DBUtil::getConnection();
    $sql="SELECT * FROM tb_subscribe";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

    //Return user through $hashkey NOT USED
public static function getUserByHashkey($hashkey){
    $array =array();
    $conn=DBUtil::getConnection();
    $hashkey=mysqli_real_escape_string($conn,$hashkey);
    $sql="SELECT * FROM tb_subscribe WHERE hashkey='$hashkey'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}
}
