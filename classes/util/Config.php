<?php
namespace classes\util;

class Config
{
    public static $config;
    public $mysqlServer;
    public $mysqlUser;
    public $mysqlPassword;
    public $mysqlDB;
    
    public static function getConfig($reload = false){
        if(isset($config)==false || $reload==true){
			$path = dirname(__FILE__);
			$ini=parse_ini_file($path."/../../config/config.ini");
			//$ini=parse_ini_file("../../config/config.ini");
			$config=new Config();
            $config->mysqlServer=$ini['mysqlServer'];
            $config->mysqlUser=$ini['mysqlUser'];
            $config->mysqlPassword=$ini['mysqlPassword'];
            $config->mysqlDB=$ini['mysqlDB'];
            return $config;
        }
        return $config;
    }
    
}