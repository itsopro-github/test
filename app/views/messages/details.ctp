<div class="messages view">
<h3><?php __($message['Message']['subject']);?></h3>
	<?php if($message) { ?>
	<div class="block">
		<p>From: <?php __(Configure::read('sitename')); ?></p>
		<p>Subject: <?php __($message['Message']['subject']); ?></p>
		<p>Sent date: <?php __($counter->formatdate('nsdatetimemeridiem',$message['Message']['created'])); ?></p>
		<p>Message: <?php __(nl2br($message['Message']['body'])); ?></p>
	</div>
	<?php } else { ?>
		<?php __($this->element('nobox',array('displaytext'=>'The details of this message cannot be displayed'))); ?>
	<?php } ?>
	<p><?php __($html->link('Send message to Administrator', array('controller'=>'messages', 'action'=>'add', 'type'=>'notaries'))); ?></p>
	<p><?php __($html->link('Back to messages', array('controller'=>'messages', 'action'=>'index', 'type'=>'notaries'))); ?></p>
	
</div>