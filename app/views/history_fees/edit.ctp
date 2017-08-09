<div class="historyFees form">
<?php echo $this->Form->create('HistoryFee');?>
	<fieldset>
 		<legend><?php __('Edit History Fee'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('fees');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('HistoryFee.id')), null, sprintf('Are you sure you want to delete # %s?', $this->Form->value('HistoryFee.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List History Fees', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>