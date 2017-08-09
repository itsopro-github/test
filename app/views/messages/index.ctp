<div class="messages index">
	<p></p>
	<div class="block">
<?php 
	if($messages) { 
?>
		<table cellpadding="0" cellspacing="0" class="tablelist">
			<thead>
				<th width="10%">Sl No</th>
				<th width="50%">Subject</th>
				<th width="30%">Sent Date</th>
				<th width="10%" class="actions">Details</th>
			</thead>
<?php
			$i = 0;
			foreach ($messages as $message):
				$class = $read = null;
				if($message['Message']['notified']=='0000-00-00 00:00:00') {$class .= ' noreadmsg';}
				if ($i++ % 2 != 0) {$class .= ' altrow';}
				$class = 'class="'.$class.'"';
?>
				<tr <?php echo $class; ?>>
				<td><?php echo $counter->counters($i) ?></td>		
				<td><?php echo $message['Message']['subject']; ?></td>
				<td><?php echo $counter->formatdate('nsdatetimemeridiem',$message['Message']['created']); ?></td>
				<td class="actions"><?php echo $html->link(__('View', true),array('action'=>'details','type'=>'notaries', $message['Message']['id']), array('class'=>'view_btn','title'=>'View details','alt'=>'View details')); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php __($this->element('pagination')); ?>
<?php 
	} else { 
		__($this->element('nobox',array('displaytext'=>'No messages are there for you')));
	}  
?>
	</div>
</div>
