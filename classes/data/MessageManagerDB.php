<?php
//For saving message sent through mass mailing into TB_Message
namespace classes\data;
use classes\util\DBUtil;

class MessageManagerDB{
    //$conn=DBUtil::getConnection();
    public static function saveMessage($authorID,$author,$recipients,$subject,$message){
        $conn=DBUtil::getConnection();
        $authorID=mysqli_real_escape_string($conn,$authorID);
		$author=mysqli_real_escape_string($conn,$author);
        $recipients=mysqli_real_escape_string($conn,$recipients);
        $subject=mysqli_real_escape_string($conn,$subject);
        $message=mysqli_real_escape_string($conn,$message);
        $sql="INSERT INTO `tb_message`(`authorID`, `author`, `recipients`, `subject`, `message`) 
        VALUES ('$authorID', '$author','$recipients','$subject','$message')";
        //print_r($sql);
        if ($conn->query($sql) == TRUE) {
            echo "<script>alert(Record deleted successfully)</script>";
            } else {
            echo "<p>Error updating record: " . $conn->error . "</p>";
                }
        $conn->close();

        }	    
}