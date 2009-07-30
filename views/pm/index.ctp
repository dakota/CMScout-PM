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
		selected: 0,
		cache: true,
		spinner: 'Please wait...'
	});

	$('#pmTabs a.readLink').live('click', function() {
		var id = new Date().getTime();	
		$("#pmTabs").after('<div id="dialog_'+id+'"></div>');

		$("#dialog_"+id)
			.html('Loading')
			.load($(this).attr('href'), function(){$("#dialog_"+id).dialog('option', 'title', $("#dialog_"+id).find('.dialogTitle').text())})
			.dialog({
				width: 500, 
				resizable: false, 
				close: function(event, ui){
					$("#dialog_"+id).dialog('destroy');
				}
			});
		
		return false;
	});

	$("#pmTabs a:not(.readLink)").live('click', function() {
		$("#pmTabs div:visible").load($(this).attr('href'));
		return false;
	});	
</script>