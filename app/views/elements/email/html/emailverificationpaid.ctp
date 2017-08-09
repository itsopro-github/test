<p>Dear <?php __($mailcdata['Notary']['first_name']); ?>,<br /><br />
A <?php __(Configure::read('sitename')); ?> team member will contact you to confirm your registration details. <br />
<?php $payamt = explode("|",$mailcdata['Notary']['payment']); ?>
 You have successfully paid <?php __(Configure::read('currency').$payamt['0']);?> to join <?php __(Configure::read('sitename'));?> professional network for a period of one <?php __($payamt['1'])?>.<br/>
<br /><br />
<b>Details of Registration</b><br /><br />
Name: <?php echo $mailcdata['Notary']['first_name']." ".$mailcdata['Notary']['last_name']; ?><br /><br />
Email address: <?php __($mailcdata['Notary']['email']); ?><br /><br />
Cell phone: <?php __($counter->tousphone($mailcdata['Notary']['cell_phone'])); ?><br /><br />
Document delivery address: <?php __($mailcdata['Notary']['dd_address']); ?>, <?php __($mailcdata['Notary']['dd_city']); ?>, <?php __($mailcdata['Notary']['dd_state']); ?>, <?php __($mailcdata['Notary']['dd_zip']); ?><br />
Payment address: <?php __($mailcdata['Notary']['p_address']); ?>, <?php __($mailcdata['Notary']['p_city']); ?>, <?php __($mailcdata['Notary']['p_state']); ?>, <?php __($mailcdata['Notary']['p_zip']); ?><br />
Commission: <?php __($mailcdata['Notary']['commission']); ?><br /><br />
Expiration: <?php __($counter->formatdate('nsdate',$mailcdata['Notary']['expiration'])); ?><br /><br /><br />
Thank you for your interest.<br />
</p>
<br /><br />To your success,<br />
<?php __(Configure::read('ceo')); ?><br />
<?php __(Configure::read('sitename')); ?><br />
<?php __(Configure::read('PARENT_WEB_URL')); ?><br />
<?php __(Configure::read('tollfreenumber')); ?>