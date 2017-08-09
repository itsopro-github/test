<div><h2><?php __(Inflector::humanize($ordertitle)); ?></h2><hr width="100%"></div>
<?php
$j = 0;
foreach ($orders as $order):
	$class = null;

		if ($j++ % 2 == 0) {$class = ' class="altrow"';}
			if($j==1) {
?>
	<table cellpadding="0" cellspacing="0" class="tablelist">			
		<thead>
			<th>No</th>
			<th>Borrower</th>
			<th>City,State</th>
			<th>File#</th>
		
<?php if($usersession['User']['type']=='IN') { ?><th>Company</th><?php } ?>
<?php if($usersession['User']['type']=='C' and $statusid>1) { ?><th>Notary</th><?php } ?>
<?php if($statusid==4 OR $statusid==7) { ?><th>Appointment</th><?php } ?>
			<th>Posted</th>
			<th class="actions"></th>
		</thead>
<?php } ?>		
	<tr <?php __($class);?>>
		<td><?php __($counter->counters($j)); ?></td>
		<td><?php __($order['Orders']['first_name'].' '.$order['Orders']['last_name']); ?></td>
		<td><?php __($order['Orders']['sa_city'].', '.$order['Orders']['sa_state']); ?></td>
		<td><?php __($order['Orders']['file']); ?></td>
		<?php if($usersession['User']['type']=='IN') { ?><td><?php __($order['Client']['Company']); ?></td><?php } ?>
<?php if($usersession['User']['type']=='C' and $statusid>1) { ?><td><?php __($html->link(@$notaries[$order['Assignment']['user_id']],array('controller'=>'users', 'action'=>'view','id'=>@$order['Assignment']['user_id'],'name'=>Inflector::slug(@$notaries[$order['Assignment']['user_id']])))); ?></td><?php } ?>
<?php if($statusid==4 OR $statusid==7) { ?><td><?php echo $misc->getApptdttime($order['Orders']['id']); } ?>
		<td><?php __($counter->formatdate('nsdate',$order['Orders']['created'])); ?></td>
		<td class="actions">
		<?php __($html->link(__('View',true),array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($order['Orders']['first_name'].' '.$order['Orders']['last_name']),'id'=>$order['Orders']['id']),array('class'=>'view_btn','title'=>'View Details','alt'=>'View Details'))); ?>
		</td>
	</tr>
<?php 

endforeach;
if($j!=0) {
?>		
	</table>
<?php
}
?>		
<div>
<?php
if($j==0) {
	__($this->element('nobox', array('displaytext'=>'No '.$ordertitle.' orders found')));		
}
?>
</div>
