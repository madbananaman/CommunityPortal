<?php
session_start();
session_destroy();
$dir=__DIR__;
$ini = parse_ini_file("$dir/../config/config.ini");
$login = $ini['path'].'/public/login.php';
header("Location: $login");
?>