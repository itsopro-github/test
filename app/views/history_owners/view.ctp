<div class="historyOwners view">
<h2><?php  __('History Owner');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $historyOwner['HistoryOwner']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Admin'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($historyOwner['Admin']['name'], array('controller' => 'admins', 'action' => 'view', $historyOwner['Admin']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($historyOwner['Order']['id'], array('controller' => 'orders', 'action' => 'view', $historyOwner['Order']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $counter->formatdate('nsdatetime',$historyOwner['HistoryOwner']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit History Owner', true), array('action' => 'edit', $historyOwner['HistoryOwner']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete History Owner', true), array('action' => 'delete', $historyOwner['HistoryOwner']['id']), null, sprintf('Are you sure you want to delete # %s?', $historyOwner['HistoryOwner']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List History Owners', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New History Owner', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Admins', true), array('controller' => 'admins', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin', true), array('controller' => 'admins', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders', true), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order', true), array('controller' => 'orders', 'action' => 'add')); ?> </li>
	</ul>
</div>
