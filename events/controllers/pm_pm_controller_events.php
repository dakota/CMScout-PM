<?php
class PmPmControllerEvents extends AppControllerEvents
{
	function onReminderMessage($event)
	{
		$controller =&$event->Controller;
		$user = $controller->Auth->user('id');
		
		if ($user !== null)
		{
			if (!isset($controller->PmMessage))
				$controller->LoadModel('Pm.PmMessage');
			
			$count = $controller->PmMessage->countNewMessages($user);
			
			if ($count == 1)
			{
				return array('message' => 'You have a new personal message', 
							'link' => array('plugin' => 'pm', 'controller' => 'pm', 'action' => 'received'), 
							'persist' => true);	
			}
			elseif ($count > 1)
			{
				return array('message' => 'You have '. $count . ' new personal messages', 
							'link' => array('plugin' => 'pm', 'controller' => 'pm', 'action' => 'received'), 
							'persist' => true);
			}
			else
			{
				return false;	
			}
		}
	}
}
?>