<?php
class PrivateMessagesController extends PrivateMessageAppController
{
	var $name = "Pm";
	var $uses = array('PrivateMessage.Message');
	var $ucpLinks = array('index' => 'Private messages');
	var $helpers = array('Bbcode');
	
	function index()
	{
		
	}
	
	function received()
	{
		$this->set('messages', $this->Message->fetchReceivedMessages($this->Auth->user('id')));
	}
	
	function read($messageSlug)
	{
		$message = $this->Message->findBySlug($messageSlug, array('FromUser'));
		
		$this->Message->MessagesUser->updateAll(array('MessagesUser.new' => 0, 'MessagesUser.read' => 0), array('MessagesUser.message_id' => $message['Message']['id']));
		$this->set('message', $message);
	}
	
	function sent()
	{
		$this->set('messages', $this->Message->fetchSentMessages($this->Auth->user('id')));
	}

	function drafts()
	{
		$this->set('messages', $this->Message->fetchDraftMessages($this->Auth->user('id')));
	}
	
	function newMessage()
	{
		$this->set('ToUser', $this->Message->ToUser->find('list', array('conditions' => array('ToUser.id NOT' => $this->Auth->user('id')))));
		if(isset($this->data))
		{
			if(isset($this->params['form']['save']) || $this->data['Message']['submit'] == 'save')
			{
				$this->data['Message']['message_type'] = 'draft';
				$this->data['Message']['from_user_id'] = $this->Auth->user('id');
				if($this->Message->saveAll($this->data))
				{
					if ($this->RequestHandler->isAjax())
					{
			        	$this->view = 'Json';
			        	$this->set('userInfo', array ('allOk' => true));
			        	$this->set('json', 'userInfo');
					}
				}
				
			}
			elseif(isset($this->params['form']['send']) || $this->data['Message']['submit'] == 'send')
			{
				$this->data['Message']['message_type'] = 'received';
				$this->data['Message']['from_user_id'] = $this->Auth->user('id');
				if($this->Message->saveAll($this->data))
				{
					$messageId = $this->Message->id;
					$this->Message->MessagesUser->updateAll(array('MessagesUser.read' => 1, 'MessagesUser.new' => 1), array('MessagesUser.message_id' => $messageId));
					
					$this->Message->create();
					$this->data['Message']['message_type'] = 'sent';
					$this->Message->saveAll($this->data);
					
					if ($this->RequestHandler->isAjax())
					{
			        	$this->view = 'Json';
			        	$this->set('userInfo', array ('allOk' => true));
			        	$this->set('json', 'userInfo');
					}
				}
			}
		}
	}
}
?>