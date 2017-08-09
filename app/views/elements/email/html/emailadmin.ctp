Hello,<br /><br />

<?php
	/*	When a order is COMPLETED, mail to notary */
			$details = 'Please log in and review the notes. <br /><br />';
			$details .= 'Status: '.$orderdata['stat'].'<br />';
			$details .= 'Notes: '.nl2br($orderdata['notes']).'<br />';
			__($details);
?>
<br /><br />To your success,<br />
<?php __(Configure::read('ceo')); ?><br />
<?php __(Configure::read('sitename')); ?><br />
<?php __(Configure::read('PARENT_WEB_URL')); ?><br />
<?php __(Configure::read('tollfreenumber')); ?>