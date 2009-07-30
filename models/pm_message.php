<?php
class PmMessage extends PmAppModel
{
	var $name = "PmMessage";
	var $belongsTo = array('FromUser' => array('className' => 'User',
												'fields' => array('FromUser.id', 'FromUser.username', 'FromUser.signature', 'FromUser.avatar')));
	var $hasAndBelongsToMany = array('ToUser' => array('className' => "User",
														'fields' => array('ToUser.id', 'ToUser.username')));
	var $actsAs = array('Sluggable' => array('label' => 'subject'));
	
	function fetchReceivedMessages($userId)
	{
		$this->bindModel(array('hasOne' => array('PmMessagesUser')));
		$messages = $this->find('all', array(
				'contain' => array('PmMessagesUser', 'FromUser'),
				'fields' => array('PmMessage.*', 'PmMessagesUser.read', 'PmMessagesUser.new'),
				'conditions'=>array('PmMessagesUser.user_id'=>$userId, 'PmMessage.message_type' => 'received')
		));
		
		$messageIds = array();
		foreach($messages as $message)
		{
			$messageIds[] = $message['PmMessage']['id'];	
		}
		
		$this->PmMessagesUser->updateAll(array('PmMessagesUser.new' => 0), array('PmMessagesUser.pm_message_id' => $messageIds));
		
		return $messages;
	}
	
	function countNewMessages($userId)
	{
		$this->bindModel(array('hasOne' => array('PmMessagesUser')));
		$count = $this->find('count', array(
				'contain' => array('PmMessagesUser'),
				'conditions'=>array('PmMessagesUser.user_id'=>$userId, 'PmMessagesUser.new' => 1, 'PmMessage.message_type' => 'received')
		));
		
		return $count;
	}
	
	function fetchSentMessages($userId)
	{
		$messages = $this->find('all', array(
				'contain' => array('FromUser', 'ToUser'),
				'conditions'=>array('PmMessage.from_user_id'=>$userId, 'PmMessage.message_type' => 'sent')
		));
		
		return $messages;
	}

	function fetchDraftMessages($userId)
	{
		$messages = $this->find('all', array(
				'contain' => array('FromUser', 'ToUser'),
				'conditions'=>array('PmMessage.from_user_id'=>$userId, 'PmMessage.message_type' => 'draft')
		));
		
		return $messages;
	}	
}
?>