<?php
namespace classes\business;
use classes\data\ForumManagerDB;

class ForumManager
{
    public function getForumTitleById($forum_id){
        return ForumManagerDB::getForumTitleById($forum_id);
    }
	
	public function deleteMessage($forum_id){
        ForumManagerDB::deleteMessage($forum_id);
    }
	