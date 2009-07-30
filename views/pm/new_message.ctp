<?php
	if(!isset($ajaxLoad))
	{
		echo $javascript->link('tiny_mce/tiny_mce_gzip');
		echo $javascript->link('tinyMCE.gz.bbcode');
		echo $javascript->link('tinyMCE.init.bbcode');	
	}

	echo $javascript->link('jquery.form');
	echo $form->create('PmMessage', array('action' => 'newMessage', 'url' => array('controller' => 'pm', 'action' => 'newMessage')));
	echo $form->input('submit', array('type' => 'hidden'));
	echo $form->input('ToUser', array('options' => $ToUser));
	echo $form->input('subject');
	echo $form->input('message', array('class' => 'mceEditor'));
?>
<div class="submit">
	<input type="submit" value="Send" name="send"></input>&nbsp;
	<input type="submit" value="Save as Draft" name="save"></input>&nbsp;
</div>
</form>
<?php 
	echo $javascript->codeBlock("tinyMCE.execCommand('mceAddControl', true, 'PmMessageMessage');");
?>
<?php if(isset($ajaxLoad)):?>
<script type="text/javascript">
	$("#PmMessageNewMessageForm").submit(function (e) {
		var $this = $(this);
		var type = e.originalEvent.explicitOriginalTarget.name;
		$('#PmMessageSubmit').val(e.originalEvent.explicitOriginalTarget.name);
		$this.ajaxSubmit({
			beforeSubmit: function() {
				tinyMCE.triggerSave();
				$(".error").remove();
				if (type == 'save')
				{
					$.jGrowl('Saving');
				}
				else
				{
					$.jGrowl('Sending');
				}
			},
			success: function(responseText, statusText) {
				if (responseText['allOk'] == true)
				{
					var textBox = $this.find('textarea');
					tinyMCE.execCommand('mceRemoveControl', null, textBox.attr('id'));
					if (type == 'save')
					{					
						$.jGrowl('Saved');
						$("#pmTabs").tabs('select', 2);
					}
					else
					{
						$.jGrowl('Sent');
						$("#pmTabs").tabs('select', 0);
					}
				}
				else
				{
					$.jGrowl('Errors found');
					$.each(responseText, function (id, value) {
						$("#" + id).after('<div class="error">' + value + '</div>');
					});
				}
			},
			dataType:  'json'
		});

		
		return false;
	});
</script>
<?php endif;?>