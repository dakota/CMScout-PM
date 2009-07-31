<table>
	<tr>
		<th width="5%"></th>
		<th>Subject</th>
		<th width="20%">From</th>
		<th width="10%">Sent date</th>
	</tr>
	<?php $i=0; foreach($messages as $message) :?>
		<tr <?php echo ($i++%2?'class="altrow':'');?> id="<?php echo $message['Message']['id']; ?>">
			<td><?php echo $message['MessagesUser']['read'] == 0 ? 'Read' : 'Unread'; ?></td>
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