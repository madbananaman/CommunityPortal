<?php
$dir = __DIR__;
$ini = parse_ini_file("$dir/../../config/config.ini");
$login = $ini['path'].'public/login.php';

if(!isset($_SESSION['email'])){
    header("Location: $login");
}