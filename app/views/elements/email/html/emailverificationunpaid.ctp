<p>Dear <?php __($this->data['Notary']['first_name']); ?>,<br /><br />A <?php __(Configure::read('sitename')); ?> team member will contact you to confirm your registration details. <br /><br /><b>Details of Registration</b><br /><br />Name: <?php echo $this->data['Notary']['first_name']." ".$this->data['Notary']['last_name']; ?><br />Email address: <?php __($this->data['Notary']['email']); ?><br />Cell phone: <?php __($counter->tousphone($this->data['Notary']['cell_phone'])); ?><br />Document delivery address: <?php __($this->data['Notary']['dd_address']); ?>, <?php __($this->data['Notary']['dd_city']); ?>, <?php __($this->data['Notary']['dd_state']); ?>, <?php __($this->data['Notary']['dd_zip']); ?><br />Payment address: <?php __($this->data['Notary']['p_address']); ?>, <?php __($this->data['Notary']['p_city']); ?>, <?php __($this->data['Notary']['p_state']); ?>, <?php __($this->data['Notary']['p_zip']); ?><br />Commission: <?php __($this->data['Notary']['commission']); ?><br />Expiration: <?php __($counter->formatdate('nsdate',$this->data['Notary']['expiration'])); ?><br /><br />To your success,<br />
<?php __(Configure::read('ceo')); ?><br />
<?php __(Configure::read('sitename')); ?><br />
<?php __(Configure::read('PARENT_WEB_URL')); ?><br />
<?php __(Configure::read('tollfreenumber')); ?>