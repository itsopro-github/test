<div class="historyFees view">
<h2><?php  __('History Fee');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $historyFee['HistoryFee']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($historyFee['User']['id'], array('controller' => 'users', 'action' => 'view', $historyFee['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Fees'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $historyFee['HistoryFee']['fees']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $counter->formatdate('nsdatetimemeridiem',$historyFee['HistoryFee']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit History Fee', true), array('action' => 'edit', $historyFee['HistoryFee']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete History Fee', true), array('action' => 'delete', $historyFee['HistoryFee']['id']), null, sprintf('Are you sure you want to delete # %s?', $historyFee['HistoryFee']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List History Fees', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New History Fee', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
