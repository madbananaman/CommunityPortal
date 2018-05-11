<?php
//fetch_message.php

if (isset($_GET['forum_id'])){
	$forum_id = $_GET['forum_id'];
	}

$conn = new PDO('mysql:host=localhost;dbname=phpcrudsample', 'root', '!QAZ2wsx');

//To replace Parent_Forum_id with that of the 'Parent_Forum_id' to get the message corresponding to that particular message
$sql = "
SELECT * FROM TB_Forum 
WHERE Parent_Forum_id = 1 
ORDER BY forum_id ASC
";

$statement = $conn->prepare($sql);

$statement->execute();

$result = $statement->fetchAll();

$output = '';
foreach($result as $row){
    $output .= '
    <div class="panel panel-default">
        <div class="panel-heading">By <b>'.$row["forumMessage_Author_email"].'</b> on <i>'.$row["createdDate"].'</i></div>
        <div class="panel-body">'.$row["forumMessage"].'</div>
        <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["forum_id"].'">Reply</button></div>
    </div>
 ';
 $output .= get_reply_message($conn, $row["forum_id"]);
}

//For outputing all the stored messages belong to the forum_id
echo $output;

//To change $parent_id = $_GET['parent_id']
function get_reply_message($conn, $parent_id = 0, $marginleft = 0){
    $sql = "
    SELECT * FROM TB_Forum WHERE parent_message_id = '".$parent_id."'
    ";
    $output = '';
    $statement = $conn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $count = $statement->rowCount();
    if($parent_id == 0){
        $marginleft = 0;
    } else {
        $marginleft = $marginleft + 48;
    } if($count > 0){
        foreach($result as $row){
            $output .= '
            <div class="panel panel-default" style="margin-left:'.$marginleft.'px">
            <div class="panel-heading">By <b>'.$row["forumMessage_author_email"].'</b> on <i>'.$row["date"].'</i></div>
            <div class="panel-body">'.$row["message"].'</div>
            <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["forum_id"].'">Reply</button></div>
            </div>
            ';
            $output .= get_reply_message($conn, $row["forum_id"], $marginleft);
     }
 }
    return $output;
}