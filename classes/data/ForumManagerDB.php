<?php
namespace classes\data;
use classes\util\DBUtil;

class ForumManagerDB {
	//To obtain data stored in TB_Forum
    public static function fillMessage($row){
        $message = array();
	$message["forum_id"]=$row["forum_id"];
	$message["parent_Forum_id"]=$row["parent_Forum_id"];
	$message["forumMessage"]=$row["forumMessage"];
	$message["forumMessage_Author_id"]=$row["forumMessage_Author_id"];
	$message["forumMessage_Author_email"]=$row["forumMessage_Author_email"];
	$message["createdDate"]=$row["createdDate"];
	$message["category"]=$row["category"];
	$message["forumTitle"]=$row["forumTitle"];
	$message["forumThreadLevel"]=$row["forumThreadLevel"];
    return $message;
    }

	//For retrieval of record through forum_id
	public static function getForumTitleById($forum_id){
    $user=NULL;
    $conn=DBUtil::getConnection();
    $forum_id=mysqli_real_escape_string($conn,$forum_id);
    $sql="select * from tb_forum where forum_id='$forum_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        if($row = $result->fetch_assoc()){
            $message=self::fillMessage($row);
        }
    }
    $conn->close();
    return $message;
}
	
    //For inserting messages into TB_Forum
	//Incomplete
    public static function postMessage($forumTitle, $forumMessage, $authorID){
    $conn=DBUtil::getConnection();
    $id=mysqli_real_escape_string($conn,$id);
    $email=mysqli_real_escape_string($conn,$email);
    $sql="INSERT INTO tb_forum () VALUES ()";
    $result = $conn->query($sql);
    $conn->close();
    }
	
    //For unsubscription to mass mail service
    public static function deleteMessage($forum_id){
        $conn=DBUtil::getConnection();
        $id=mysqli_real_escape_string($conn,$id);
        $hashkey=mysqli_real_escape_string($conn,$hashkey);
        $sql="DELETE FROM tb_forum where id='$forum_id";
        $result = $conn->query($sql);
        $conn->close();
    }
	
//To return result as array
	public static function getAllMessages(){
		$users[]=array();
		$conn=DBUtil::getConnection();
		$sql="SELECT * FROM tb_forum";
		$result = $conn->query($sql);
		$conn->close();
		return $result;
	}

}