<div class="reactivateFees form">
<?php echo $this->Form->create('ReactivateFee');?>
	<fieldset>
 		<legend><?php __('Add Reactivate Fee'); ?></legend>
	<?php
		echo $this->Form->input('order_id');
		echo $this->Form->input('notary_fee1');
		echo $this->Form->input('notary_fee2');
		echo $this->Form->input('notary_fee3');
		echo $this->Form->input('notary_fee4');
		echo $this->Form->input('notary_fee5');
		echo $this->Form->input('notary_fee6');
		echo $this->Form->input('client_fee1');
		echo $this->Form->input('client_fee2');
		echo $this->Form->input('client_fee3');
		echo $this->Form->input('client_fee4');
		echo $this->Form->input('client_fee5');
		echo $this->Form->input('client_fee6');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Reactivate Fees', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Orders', true), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order', true), array('controller' => 'orders', 'action' => 'add')); ?> </li>
	</ul>
</div>