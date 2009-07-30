<h2 class="dialogTitle">Private Message: <?php echo $message['PmMessage']['subject'];?></h2>
<table>
	<tr class="pmRow">
		<td>
			<div class="username"><?php echo $message['FromUser']['username'];?></div>

			<?php if($message['FromUser']['username'] != ''):?>
				<div class="avatar">
					<?php echo $html->image('/avatars/' . $message['FromUser']['username']); ?>
				</div>
			<?php endif;?>
		</td>
		<td width="80%">
			<a name="<?php echo $message['PmMessage']['id']; ?>"></a>

			<?php if ($message['PmMessage']['subject'] != '') :?>
				<div class="subject">
					<?php echo $message['PmMessage']['subject'];?>
				</div>
			<?php endif; ?>

			<div class="created">
				<?php echo $time->niceShort($message['PmMessage']['created']); ?>
			</div>

			<div class="pm" rel="<?php echo $message['FromUser']['username'];?>" id="<?php echo $message['PmMessage']['id']; ?>">
				<?php echo $bbcode->parse($message['PmMessage']['message']);?>
			</div>
			<div class="editor" style="display:none;">
			</div>

			<?php if($message['FromUser']['signature'] != ''):?>
				<div class="signature">
					<?php echo $message['FromUser']['signature']; ?>
				</div>
			<?php endif;?>
		</td>
	</tr>
</table>
<?php if ($message['PmMessage']['message_type'] == 'received') :?>
	<div id="quickReply">
	<h2>Reply</h2>
	<?php
		 echo $form->create('Pm', array('url' => array('controller' => 'pm', 'action' => 'sendMessage', $message['PmMessage']['slug'])));
		 echo $form->input('subject', array('value' => 'Re: ' . $message['PmMessage']['subject']));
		 echo $form->input('message', array('type' => 'textbox', 'class' => 'mceEditor','value' => '[quote='.$message['FromUser']['username'].']'.$message['PmMessage']['message'].'[/quote]'));
	?>
		<div class="submit">
			<input type="submit" id="replyButton" name="send" value="Send message">&nbsp;
			<input type="submit" name="advanced" value="Goto advanced mode">
		</div>
	</div>
	
	<script type="text/javascript">
	
	</script>
<?php endif; ?>

<?php 
	$css->link('/pm/css/pm', null, array(), false);
	if ($message['PmMessage']['message_type'] == 'received')
	{
		if ($this->params['isAjax'])
			echo $javascript->codeBlock("tinyMCE.execCommand('mceAddControl', true, 'PmMessage');");
		else
		{
			$javascript->link('tiny_mce/tiny_mce_gzip', false);
			$javascript->link('tinyMCE.gz.bbcode', false);
			$javascript->link('tinyMCE.init.bbcode', false);
		}
	}
?>