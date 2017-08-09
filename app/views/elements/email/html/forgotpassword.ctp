<p>Dear <?php __($forgotpassworddata['User']['name']); ?>,<br /><br />Your new password for <?php __(Configure::read('sitename')); ?> account will be <?php __($forgotpassworddata['User']['newpassword']);?><br /><br />This is an auto generated password so kindly change it as you login.<br />Click here to view your account: <?php __($html->link('My Account', Configure::read('WEB_URL').$forgotpassworddata['User']['dtype']."/myaccount"));?><br /><br /></p><br /><br />To your success,<br />
<?php __(Configure::read('ceo')); ?><br />
<?php __(Configure::read('sitename')); ?><br />
<?php __(Configure::read('PARENT_WEB_URL')); ?><br />
<?php __(Configure::read('tollfreenumber')); ?>