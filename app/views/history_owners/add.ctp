<div class="historyOwners form">
<?php echo $this->Form->create('HistoryOwner');?>
	<fieldset>
 		<legend><?php __('Add History Owner'); ?></legend>
	<?php
		echo $this->Form->input('admin_id');
		echo $this->Form->input('order_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List History Owners', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Admins', true), array('controller' => 'admins', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin', true), array('controller' => 'admins', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders', true), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order', true), array('controller' => 'orders', 'action' => 'add')); ?> </li>
	</ul>
</div>