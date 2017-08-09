<div class="orderEdocs index">
	<h2><?php __('Order Edocs');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('order_id');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('ptype');?></th>
			<th><?php echo $this->Paginator->sort('edocfile');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($orderEdocs as $orderEdoc):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $orderEdoc['OrderEdoc']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($orderEdoc['Order']['id'], array('controller' => 'orders', 'action' => 'view', $orderEdoc['Order']['id'])); ?>
		</td>
		<td><?php echo $orderEdoc['OrderEdoc']['title']; ?>&nbsp;</td>
		<td><?php echo $orderEdoc['OrderEdoc']['ptype']; ?>&nbsp;</td>
		<td><?php echo $orderEdoc['OrderEdoc']['edocfile']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $orderEdoc['OrderEdoc']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $orderEdoc['OrderEdoc']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $orderEdoc['OrderEdoc']['id']), null, sprintf('Are you sure you want to delete # %s?', $orderEdoc['OrderEdoc']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Order Edoc', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Orders', true), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order', true), array('controller' => 'orders', 'action' => 'add')); ?> </li>
	</ul>
</div>