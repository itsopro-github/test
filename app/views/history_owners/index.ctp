<div class="historyOwners index">
	<h2><?php __('History Owners');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('admin_id');?></th>
			<th><?php echo $this->Paginator->sort('order_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($historyOwners as $historyOwner):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $historyOwner['HistoryOwner']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($historyOwner['Admin']['name'], array('controller' => 'admins', 'action' => 'view', $historyOwner['Admin']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($historyOwner['Order']['id'], array('controller' => 'orders', 'action' => 'view', $historyOwner['Order']['id'])); ?>
		</td>
		<td><?php echo $counter->formatdate('nsdatetime',$historyOwner['HistoryOwner']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $historyOwner['HistoryOwner']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $historyOwner['HistoryOwner']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $historyOwner['HistoryOwner']['id']), null, sprintf('Are you sure you want to delete # %s?', $historyOwner['HistoryOwner']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New History Owner', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Admins', true), array('controller' => 'admins', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Admin', true), array('controller' => 'admins', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders', true), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order', true), array('controller' => 'orders', 'action' => 'add')); ?> </li>
	</ul>
</div>