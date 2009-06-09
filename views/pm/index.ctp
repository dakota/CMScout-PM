<div id="pmTabs">
	<ul>
		<li><?php echo $html->link('Received', array('plugin' => 'pm', 'controller' => 'pm', 'action' => 'received'));?></li>
		<li><?php echo $html->link('Sent', array('plugin' => 'pm', 'controller' => 'pm', 'action' => 'sent'));?></li>
		<li><?php echo $html->link('Drafts', array('plugin' => 'pm', 'controller' => 'pm', 'action' => 'drafts'));?></li>	
		<li><?php echo $html->link('New message', array('plugin' => 'pm', 'controller' => 'pm', 'action' => 'newMessage'));?></li>	
	</ul>
</div>

<script type="text/javascript">
	$("#pmTabs").tabs({
		selected: 0
	});

	$("#pmTabs a").live('click', function() {
		console.log(this);
		$("#pmTabs div:visible").load($(this).attr('href'));
		return false;
	});
</script>