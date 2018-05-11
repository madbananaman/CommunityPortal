<?php
namespace classes\business;
use classes\data\MessageManagerDB;

class MessageManager{
    //For saving of message in tb_message after sending mass mail
	public static function saveMessage($authorID,$author,$recipients,$subject,$message){
        return MessageManagerDB::saveMessage($authorID,$author,$recipients,$subject,$message);
    }
}