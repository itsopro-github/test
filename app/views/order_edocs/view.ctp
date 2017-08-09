<div class="orderEdocs view">
<h2><?php  __('Order Edoc');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderEdoc['OrderEdoc']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($orderEdoc['Order']['id'], array('controller' => 'orders', 'action' => 'view', $orderEdoc['Order']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderEdoc['OrderEdoc']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ptype'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderEdoc['OrderEdoc']['ptype']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Edocfile'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderEdoc['OrderEdoc']['edocfile']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order Edoc', true), array('action' => 'edit', $orderEdoc['OrderEdoc']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Order Edoc', true), array('action' => 'delete', $orderEdoc['OrderEdoc']['id']), null, sprintf('Are you sure you want to delete # %s?', $orderEdoc['OrderEdoc']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Edocs', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Edoc', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders', true), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order', true), array('controller' => 'orders', 'action' => 'add')); ?> </li>
	</ul>
</div>
