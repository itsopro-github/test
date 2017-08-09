<div class="reactivateFees index">
	<h2><?php __('Reactivate Fees');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('order_id');?></th>
			<th><?php echo $this->Paginator->sort('notary_fee1');?></th>
			<th><?php echo $this->Paginator->sort('notary_fee2');?></th>
			<th><?php echo $this->Paginator->sort('notary_fee3');?></th>
			<th><?php echo $this->Paginator->sort('notary_fee4');?></th>
			<th><?php echo $this->Paginator->sort('notary_fee5');?></th>
			<th><?php echo $this->Paginator->sort('notary_fee6');?></th>
			<th><?php echo $this->Paginator->sort('client_fee1');?></th>
			<th><?php echo $this->Paginator->sort('client_fee2');?></th>
			<th><?php echo $this->Paginator->sort('client_fee3');?></th>
			<th><?php echo $this->Paginator->sort('client_fee4');?></th>
			<th><?php echo $this->Paginator->sort('client_fee5');?></th>
			<th><?php echo $this->Paginator->sort('client_fee6');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($reactivateFees as $reactivateFee):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $reactivateFee['ReactivateFee']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($reactivateFee['Order']['id'], array('controller' => 'orders', 'action' => 'view', $reactivateFee['Order']['id'])); ?>
		</td>
		<td><?php echo $reactivateFee['ReactivateFee']['notary_fee1']; ?>&nbsp;</td>
		<td><?php echo $reactivateFee['ReactivateFee']['notary_fee2']; ?>&nbsp;</td>
		<td><?php echo $reactivateFee['ReactivateFee']['notary_fee3']; ?>&nbsp;</td>
		<td><?php echo $reactivateFee['ReactivateFee']['notary_fee4']; ?>&nbsp;</td>
		<td><?php echo $reactivateFee['ReactivateFee']['notary_fee5']; ?>&nbsp;</td>
		<td><?php echo $reactivateFee['ReactivateFee']['notary_fee6']; ?>&nbsp;</td>
		<td><?php echo $reactivateFee['ReactivateFee']['client_fee1']; ?>&nbsp;</td>
		<td><?php echo $reactivateFee['ReactivateFee']['client_fee2']; ?>&nbsp;</td>
		<td><?php echo $reactivateFee['ReactivateFee']['client_fee3']; ?>&nbsp;</td>
		<td><?php echo $reactivateFee['ReactivateFee']['client_fee4']; ?>&nbsp;</td>
		<td><?php echo $reactivateFee['ReactivateFee']['client_fee5']; ?>&nbsp;</td>
		<td><?php echo $reactivateFee['ReactivateFee']['client_fee6']; ?>&nbsp;</td>
		<td><?php echo $reactivateFee['ReactivateFee']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $reactivateFee['ReactivateFee']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $reactivateFee['ReactivateFee']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $reactivateFee['ReactivateFee']['id']), null, sprintf('Are you sure you want to delete # %s?', $reactivateFee['ReactivateFee']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Reactivate Fee', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Orders', true), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order', true), array('controller' => 'orders', 'action' => 'add')); ?> </li>
	</ul>
</div>