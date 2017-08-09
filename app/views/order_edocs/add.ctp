<div class="orderEdocs form">
<?php echo $this->Form->create('OrderEdoc');?>
	<fieldset>
 		<legend><?php __('Add Order Edoc'); ?></legend>
	<?php
		echo $this->Form->input('order_id');
		echo $this->Form->input('title');
		echo $this->Form->input('ptype');
		echo $this->Form->input('edocfile');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Order Edocs', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Orders', true), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order', true), array('controller' => 'orders', 'action' => 'add')); ?> </li>
	</ul>
</div>