<div class="orderEdocs form">
<?php echo $this->Form->create('OrderEdoc');?>
	<fieldset>
 		<legend><?php __('Edit Order Edoc'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('OrderEdoc.id')), null, sprintf('Are you sure you want to delete # %s?', $this->Form->value('OrderEdoc.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Order Edocs', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Orders', true), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order', true), array('controller' => 'orders', 'action' => 'add')); ?> </li>
	</ul>
</div>