<?php
class PmController extends PmAppController
{
	var $name = "Pm";
	var $uses = array('Pm.PmMessage');
	var $ucpLinks = array('index' => 'Private messages');
	var $helpers = array('Bbcode');
	
	function index()
	{
		
	}
	
	function received()
	{
		$this->set('messages', $this->PmMessage->fetchReceivedMessages($this->Auth->user('id')));
	}
	
	function read($messageSlug)
	{
		$message = $this->PmMessage->findBySlug($messageSlug, array('FromUser'));
		
		$this->PmMessage->PmMessagesUser->updateAll(array('PmMessagesUser.new' => 0, 'PmMessagesUser.read' => 0), array('PmMessagesUser.pm_message_id' => $message['PmMessage']['id']));
		$this->set('message', $message);
	}
	
	function sent()
	{
		$this->set('messages', $this->PmMessage->fetchSentMessages($this->Auth->user('id')));
	}

	function drafts()
	{
		$this->set('messages', $this->PmMessage->fetchDraftMessages($this->Auth->user('id')));
	}
	
	function newMessage()
	{
		$this->set('ToUser', $this->PmMessage->ToUser->find('list', array('conditions' => array('ToUser.id NOT' => $this->Auth->user('id')))));
		if(isset($this->data))
		{
			if(isset($this->params['form']['save']) || $this->data['PmMessage']['submit'] == 'save')
			{
				$this->data['PmMessage']['message_type'] = 'draft';
				$this->data['PmMessage']['from_user_id'] = $this->Auth->user('id');
				if($this->PmMessage->saveAll($this->data))
				{
					if ($this->RequestHandler->isAjax())
					{
			        	$this->view = 'Json';
			        	$this->set('userInfo', array ('allOk' => true));
			        	$this->set('json', 'userInfo');
					}
				}
				
			}
			elseif(isset($this->params['form']['send']) || $this->data['PmMessage']['submit'] == 'send')
			{
				$this->data['PmMessage']['message_type'] = 'received';
				$this->data['PmMessage']['from_user_id'] = $this->Auth->user('id');
				if($this->PmMessage->saveAll($this->data))
				{
					$messageId = $this->PmMessage->id;
					$this->PmMessage->PmMessagesUser->updateAll(array('PmMessagesUser.read' => 1, 'PmMessagesUser.new' => 1), array('PmMessagesUser.pm_message_id' => $messageId));
					
					$this->PmMessage->create();
					$this->data['PmMessage']['message_type'] = 'sent';
					$this->PmMessage->saveAll($this->data);
					
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