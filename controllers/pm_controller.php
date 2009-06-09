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
		$this->set('message', $this->PmMessage->findBySlug($messageSlug));
	}
}
?>