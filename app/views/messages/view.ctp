<div class="messages view ">
	<div class="block">
<table cellpadding="0" cellspacing="0" class="tablelist">
		<tr>
			<th><?php __('Subject'); ?></th>
			<td><?php echo $message['Message']['subject']; ?></td>	
		</tr>
		<tr>
			<th><?php __('Message'); ?></th>
			<td><?php echo nl2br($message['Message']['body']); ?></td>	
		</tr>	
		<tr>
			<th><?php __('Sent Date'); ?></th>
			<td><?php echo $counter->formatdate('nsdatetimemeridiem',$message['Message']['created']); ?></td>	
		</tr>	
		</table>
	
	<a href="<?=Configure::read('WEB_URL')?>myaccount/messages">Back</a>
</div>
</div>