<?php
class PmMessage extends PmAppModel
{
	var $name = "PmMessage";
	var $belongsTo = array('FromUser' => array('className' => 'User',
												'fields' => array('FromUser.id', 'FromUser.username', 'FromUser.signature', 'FromUser.avatar')));
	var $hasAndBelongsToMany = array('ToUser' => array('className' => "User",
														'fields' => array('ToUser.id', 'ToUser.username')));
	var $actsAs = array('Sluggable');
	
	function fetchReceivedMessages($userId)
	{
		$this->bindModel(array('hasOne' => array('PmMessagesUser')));
		$messages = $this->find('all', array(
				'contain' => array('PmMessagesUser', 'FromUser'),
				'fields' => array('PmMessage.*, PmMessagesUser.read'),
				'conditions'=>array('PmMessagesUser.user_id'=>$userId, 'PmMessage.message_type' => 'message') // id of Dessert
		));
		
		return $messages;
	}
}
?>