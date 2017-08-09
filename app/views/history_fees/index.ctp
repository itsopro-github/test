<div class="historyFees index">
	<h2><?php __('History Fees');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('fees');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($historyFees as $historyFee):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $historyFee['HistoryFee']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($historyFee['User']['id'], array('controller' => 'users', 'action' => 'view', $historyFee['User']['id'])); ?>
		</td>
		<td><?php __(Configure::read('currency').$historyFee['HistoryFee']['fees']); ?></td>
		<td><?php echo $counter->formatdate('nsdatetimemeridiem',$historyFee['HistoryFee']['created']); ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $historyFee['HistoryFee']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $historyFee['HistoryFee']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $historyFee['HistoryFee']['id']), null, sprintf('Are you sure you want to delete # %s?', $historyFee['HistoryFee']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New History Fee', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>