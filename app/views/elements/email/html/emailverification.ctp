<p>Dear <?php __($this->data['Client']['first_name']); ?>,<br /><br />
Thank you for your inquiry. <br />
A <?php __(Configure::read('sitename')); ?> representative will contact you to confirm your account details.<br /><br />
<b>Details of Registration</b><br /><br />
 Company: <?php __($this->data['Client']['company']); ?><br />
 Name: <?php echo $this->data['Client']['first_name']." ".$this->data['Client']['last_name']; ?><br />
 Company phone: <?php __($counter->tousphone($this->data['Client']['company_phone'])); ?><br />
 Company fax: <?php __($counter->tousphone(@$this->data['Client']['company_fax'])); ?><br />
 Shipping carrier: <?php __($shipoptions[$this->data['Client']['shipping_carrier']]); ?><br />
 Shipping account #: <?php __($this->data['Client']['shipping_account']); ?><br />
 Office address: <?php __($this->data['Client']['of_street_address']); ?>, <?php __($this->data['Client']['of_city']); ?>, <?php __($this->data['Client']['of_state']); ?>, <?php __($this->data['Client']['of_zip']); ?><br />
 Return document address: <?php __($this->data['Client']['rd_street_address']); ?>, <?php __($this->data['Client']['rd_city']); ?>, <?php __($this->data['Client']['rd_state']); ?>, <?php __($this->data['Client']['rd_zip']); ?><br />
</p>
<br /><br />To your success,<br />
<?php __(Configure::read('ceo')); ?><br />
<?php __(Configure::read('sitename')); ?><br />
<?php __(Configure::read('PARENT_WEB_URL')); ?><br />
<?php __(Configure::read('tollfreenumber')); ?>
