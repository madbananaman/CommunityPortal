<?php
/*
1) Check for logged in using isset($_SESSION["email"])
2) Check for role of logged-in user in using $_SESSION["role"]=="xxx"
3) else identity == Non-registered
*/

$dir=__DIR__;
$ini = parse_ini_file("$dir/../../config/config.ini");
//Directory to public (view) folder
$siteroot = $ini['path'].'public/';
//Directory to image folder
$images = $ini['path'].'public/images/';
//ABC Logo
$logo = $ini['path'].'public/images/ABC_logo.png';
//JS script
$script = $ini['path'].'public/scripts/script.js';


?>
<!DOCTYPE html>
<head>
	<title>ABC Jobs</title>
        <!--BOOTSTRAP + jQuery-->
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!--PURE CSS-->
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
		<link rel='stylesheet' href='https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css'>
		<link rel='stylesheet' href='https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css'>
		<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.0.10/css/all.css'>        
		<link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--CSS for images and miscellaneous-->
        <link rel='stylesheet' href='<?=$siteroot?>css/layouts/CSS.css'>
	<!--Miscellaneous JS script-->
        <script type="text/javascript" src="<?=$script;?>"></script>
	<?php
	//For generating random background
	$bg = array('programmers.gif', 'scripting.gif', '200w.webp', 'fatman.webp'); // array of filenames
	$i = rand(0, count($bg)-1); // generate random number size of the array
	$selectedBg = "$bg[$i]"; // set variable equal to which random filename was chosen
	?>
        <style type="text/css">
            .banner{
            background: url(images/<?=$selectedBg?>) no-repeat;
            background-origin: content-box;
            background-size: cover;
            background-position: center;
            display: table;
            }
        .background-login{
            background: url(<?=$images?>background.jpg) no-repeat;
            background-origin: content-box;
            background-size: cover;
            background-position: center;  
            }

        .background-register{
            background: url(<?=$images?>register.jpg) no-repeat;
            background-origin: content-box;
            background-size: cover;
            background-position: center;    
        }
        </style>
        

</head>
<?php
/*
 * 1) Check for existence of $_SESSION['email']
 * 2) Check $_SESSION["role"] of logged in personnel ('admin' or 'user'), and display the information accordingly
 */
if (isset($_SESSION["email"])){
    if ($_SESSION["role"]=="admin"){
	
?>

<div class="w3-bar w3-black w3-large">
  <a href="<?=$siteroot?>home.php" class="w3-bar-item w3-button w3-mobile"><img class="pure-img" src="<?=$logo?>" align="left" style="width:55px; height:35px"></a>
  <a href="<?=$siteroot?>home.php" class="w3-bar-item w3-button w3-mobile"><i class="fas fa-home w3-margin-right"></i>Home</a>
  <a href="<?=$siteroot?>modules/user/updateprofile.php" class="w3-bar-item w3-button w3-mobile"><i class="fas fa-edit"></i>Update Profile</a>
  <a href="<?=$siteroot?>modules/user/searchUser.php" class="w3-bar-item w3-button w3-mobile"><i class="fas fa-search"></i>Search Users</a>
  <a href="<?=$siteroot?>modules/user/userlist.php" class="w3-bar-item w3-button w3-mobile"><i class="fas fa-list-ul"></i>View Users</a>
  <a href="<?=$siteroot?>aboutus.php" class="w3-bar-item w3-button w3-mobile"><i class="fas fa-info w3-margin-right"></i>About Us</a>
  <a href="<?=$siteroot?>contactus.php" class="w3-bar-item w3-button w3-mobile"><i class="far fa-envelope"></i>Contact</a>
  <a href="<?=$siteroot?>logout.php" class="w3-bar-item w3-button w3-right w3-light-grey w3-mobile">Logout</a>
</div>

<?php
	} else if($_SESSION["role"]=="user"){
?>

<div class="w3-bar w3-black w3-large">
  <a href="<?=$siteroot?>home.php" class="w3-bar-item w3-button w3-mobile"><img class="pure-img" src="<?=$logo?>" align="left" style="width:55px; height:35px"></a>
  <a href="<?=$siteroot?>home.php" class="w3-bar-item w3-button w3-mobile"><i class="fas fa-home w3-margin-right"></i>Home</a>
  <a href="<?=$siteroot?>modules/user/updateprofile.php" class="w3-bar-item w3-button w3-mobile"><i class="fas fa-edit"></i>Update Profile</a>
  <a href="<?=$siteroot?>modules/user/searchUser.php" class="w3-bar-item w3-button w3-mobile"><i class="fas fa-search"></i>Search Users</a>
  <a href="<?=$siteroot?>aboutus.php" class="w3-bar-item w3-button w3-mobile"><i class="fas fa-info w3-margin-right"></i>About Us</a>
  <a href="<?=$siteroot?>contactus.php" class="w3-bar-item w3-button w3-mobile"><i class="far fa-envelope"></i>Contact</a>
  <a href="<?=$siteroot?>logout.php" class="w3-bar-item w3-button w3-right w3-light-grey w3-mobile">Logout</a>
</div>


<?php
}} else {
	//Non-registered
?>

<div class="w3-bar w3-black w3-large">
  <a href="<?=$siteroot?>home.php" class="w3-bar-item w3-button w3-mobile"><img class="pure-img" src="<?=$logo?>" align="left" style="width:55px; height:35px"></a>
  <a href="<?=$siteroot?>home.php" class="w3-bar-item w3-button w3-mobile"><i class="fas fa-home w3-margin-right"></i>Home</a>
  <a href="<?=$siteroot?>aboutus.php" class="w3-bar-item w3-button w3-mobile"><i class="fas fa-info w3-margin-right"></i>About Us</a>
  <a href="<?=$siteroot?>contactus.php" class="w3-bar-item w3-button w3-mobile"><i class="far fa-envelope"></i>Contact</a>
  <a href="<?=$siteroot?>login.php" class="w3-bar-item w3-button w3-right w3-light-grey w3-mobile">Login</a>
</div>



<?php
}