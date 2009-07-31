<?php
class Message extends PmAppModel
{
	var $name = "Message";
	var $belongsTo = array('FromUser' => array('className' => 'User',
												'fields' => array('FromUser.id', 'FromUser.username', 'FromUser.signature', 'FromUser.avatar')));
	var $hasAndBelongsToMany = array('ToUser' => array('className' => 'User',
														'with' => 'Pm.MessagesUser',
														'fields' => array('ToUser.id', 'ToUser.username')));
	var $actsAs = array('Sluggable' => array('label' => 'subject'));
	
	function fetchReceivedMessages($userId)
	{
		$this->bindModel(array('hasOne' => array('Pm.MessagesUser')));
		$messages = $this->find('all', array(
				'contain' => array('MessagesUser', 'FromUser'),
				'fields' => array('Message.*', 'MessagesUser.read', 'MessagesUser.new'),
				'conditions'=>array('MessagesUser.user_id'=>$userId, 'Message.message_type' => 'received')
		));
		
		$messageIds = array();
		foreach($messages as $message)
		{
			$messageIds[] = $message['Message']['id'];	
		}
		
		$this->MessagesUser->updateAll(array('MessagesUser.new' => 0), array('MessagesUser.message_id' => $messageIds));
		
		return $messages;
	}
	
	function countNewMessages($userId)
	{
		$this->bindModel(array('hasOne' => array('MessagesUser')));
		$count = $this->find('count', array(
				'contain' => array('MessagesUser'),
				'conditions'=>array('MessagesUser.user_id'=>$userId, 'MessagesUser.new' => 1, 'Message.message_type' => 'received')
		));
		
		return $count;
	}
	
	function fetchSentMessages($userId)
	{
		$messages = $this->find('all', array(
				'contain' => array('FromUser', 'ToUser'),
				'conditions'=>array('Message.from_user_id'=>$userId, 'Message.message_type' => 'sent')
		));
		
		return $messages;
	}

	function fetchDraftMessages($userId)
	{
		$messages = $this->find('all', array(
				'contain' => array('FromUser', 'ToUser'),
				'conditions'=>array('Message.from_user_id'=>$userId, 'Message.message_type' => 'draft')
		));
		
		return $messages;
	}	
}
?>