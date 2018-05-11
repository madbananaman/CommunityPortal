<?php
//forum_Message.php
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;
use classes\business\ForumManager;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';

if (isset($_GET['forum_id'])){
    $forum_id = $_GET['forum_id'];
    $FM = new ForumManager();
    $forumArray = $FM -> getForumTitleById($forum_id);
    $forumTitle = $forumArray['forumTitle'];
    $forumMessage = $forumArray['forumMessage'];
    $forumMessage_Author_email = $forumArray['forumMessage_Author_email'];
    $createdDate = $forumArray['createdDate'];
    //var_dump($forumArray);
?>

<h2 align="center"><?=$forumTitle?></h2>
    <div class="container">   
    <!--for error or feedback messages-->
    <span id="message_message"></span>
<br>
    <form method="POST" id="message_form">
        <div class="panel panel-success">
            <div class="panel-heading">By <b><?=$forumMessage_Author_email?></b> on <i><?=$createdDate?></i></div>
            <div class="panel-body"><?=$forumMessage?></div>
            <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="<?=$forum_id?>">Reply</button></div>
        </div>
    </form>
    <!--For displaying the corresponding messages with parent_Forum_id = $_GET['forum_id']-->
    <div id="display_message"></div>
    </div>
<?php    
}
?>




    
        <!--
    <form method="POST" id="message_form">
        <div class="form-group">
            <textarea name="forumMessage" id="forumMessage" class="form-control" placeholder="Enter Message" rows="5"></textarea>
        </div>
        <div class="form-group">
            <input type="hidden" name="forum_id" id="forum_id" value="0" />
    <input type="hidden" name="forum_id" id="forum_id" value="<?php//$forum-id?>" />
            <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
        </div>
    </form>-->

    


<script>
$(document).ready(function(){
//Submission of form 
    $('#message_form').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        alert(form_data);
        $.ajax({
            url:"add_message.php",
            method:"POST",
            data:form_data,
            dataType:"JSON",
            success:function(data){
                if(data.error != ''){
                    $('#message_message').html(data.error); //Displays feedback or erro message
                    //$('#message_form')[0].reset(); To create another textArea box 
                    //$('#forum_id').val('0');
                    load_message();
                }
   }
  })
 });

 load_message();

 function load_message(){
    $.ajax({
        url:"fetch_message.php",
        method:"POST",
        success:function(data){
            $('#display_message').html(data);
        }
    })
 }

$(document).on('click', '.reply', function(){
    var forum_id = $(this).attr("id");
    
    print(
            );
    
    $('#forum_id').val(forum_id);
    $('#forumMessage_Author_Email_Author_Email').focus();
 });
 
});
</script>

<?php
include '../../includes/footer.php';
?>