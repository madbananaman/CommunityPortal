<?php

//add_message.php

$conn = new PDO('mysql:host=localhost;dbname=phpcrudsample', 'root', '!QAZ2wsx');

$error = '';
$forumMessage_Author_Email = '';
$forumMessage = '';

if(empty($_POST["forumMessage_Author_Email"])){
	//To change to $_SESSION['email'];
	//If empty ($_SESSION['email'];){Do not proceed}
 $error .= '<p class="text-danger">Name is required</p>';
}
else{
//To change to $_SESSION['email'];
 $forumMessage_Author_Email = $_POST["forumMessage_Author_Email"];
}

if(empty($_POST["forumMessage"])){
 $error .= '<p class="text-danger">Please enter some input</p>';
}
else{
 $forumMessage = $_POST["forumMessage"];
}

if($error == ''){
 $sql = "
 INSERT INTO TB_Forum 
 (parent_Forum_id, forumMessage, forumMessage_Author_id, forumMessage_Author_Email) 
 VALUES (:parent_Forum_id, :forumMessage, :forumMessage_author_id, :forumMessage_Author_Email)";
 $statement = $conn->prepare($sql);
 $statement->execute(
  array(
   ':parent_Forum_id' => $_POST["forum_id"],
   ':forumMessage'    => $forumMessage,
   ':forumMessage_author_id' => 52, /*To replace with $UM->getUserByEmail($_SESSION['email']->id)*/
   ':forumMessage_Author_Email' => 'admin@gmail.com'
#':forumMessage_Author_Email' => $_SESSION['email']
      #':forumMessage_Author_Email' => $forumMessage_Author_Email
  )
 );
 //$error = '<label class="text-success">Message Added</label>';
$error = " AUTHOR: " . $forumMessage_Author_Email . " Message: " . $forumMessage;
}

$data = array(
 'error'  => $error
);

echo json_encode($data);