<?php
namespace classes\util;
include_once 'Config.php';
use classes\util\Config;
use mysqli;

class DBUtil
{
    public static function getConnection(){
        $config=Config::getConfig();
        $conn = new mysqli($config->mysqlServer, $config->mysqlUser, $config->mysqlPassword,$config->mysqlDB);
		if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		} else{
			//echo "Connected successfully";}
		return $conn;
    }
}
}