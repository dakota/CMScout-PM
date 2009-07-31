<table>
	<tr>
		<th>Subject</th>
		<th width="20%">To</th>
		<th width="10%">Saved date</th>
	</tr>
	<?php $i=0; foreach($messages as $message) :?>
		<tr <?php echo ($i++%2?'class="altrow':'');?> id="<?php echo $message['Message']['id']; ?>">
			<td style="text-align:left;">
				<?php echo $html->link($message['Message']['subject'], array('action' => 'read', $message['Message']['slug']), array('class' => 'readLink')); ?><br />
				<?php echo $html->link('&nbsp;', array('action' => 'reply', $message['Message']['slug']), array('class' => 'replyAction icon sprite-important'), false, false)?>
				<?php echo $html->link('&nbsp;', array('action' => 'forward', $message['Message']['slug']), array('class' => 'forwardAction icon sprite-star'), false, false)?>
				<?php echo $html->link('&nbsp;', array('action' => 'delete', $message['Message']['slug']), array('class' => 'deleteAction icon sprite-delete'), false, false)?>
			</td>
			<td><?php echo $message['FromUser']['username']; ?></td>
			<td><?php echo $time->niceShort($message['Message']['created']); ?></td>
		</tr>
	<?php endforeach;?>
</table>