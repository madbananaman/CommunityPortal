<?php
session_start();
include 'includes/security.php';
include 'includes/header.php';
?>

<center>
    <br>
    
	<div class="banner">
        <h1 class="banner-head">Welcome to ABC Jobs Portal
            <div style="color:red"><?php echo $_SESSION["email"];?></div>
        </h1>
    </div>
</center>

<?php
include 'includes/footer.php';
?>
