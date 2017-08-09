<div class="users index">
<div class="block">
<p>The currently placed request has been sent successfully to <?php __(Configure::read('sitename')); ?>. To view this signing in the queue and other current signings click <?php __($html->link('Current Signings',array('controller'=>'orders','action'=>'index','type'=>(($usersession['User']['type'] == 'N') ? 'notaries' : 'clients')))); ?>. The further update will be notified to you through email.</p>
<p>To your success,<br />
<?php __(Configure::read('ceo')); ?><br />
<?php __(Configure::read('sitename')); ?></p>
</div></div>