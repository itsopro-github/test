<p></p>
<div class="assignments index">
	<div class="block">
<?php if($assignments) { ?>
	<table cellpadding="0" cellspacing="0" class="tablelist">
	<thead>
		<th width="3%">No</th>
		<th width="25%">Borrower</th>
		<th width="22%">City,State</th>
		<th width="23%">Company</th>
		<th width="15%">File #</th>
		<th width="10%">Date</th>
		<th width="2%" class="actions"></th>
	</thead>
<?php
	$i = 0;
	foreach ($assignments as $assignment):
		$class = null;
		if ($i++ % 2 == 0) {$class = ' class="altrow"';}
?>
	<tr<?php echo $class;?>>
		<td><?php echo $counter->counters($i) ?></td>	
		<td><?php echo $html->link($assignment['Order']['first_name']." ".$assignment['Order']['last_name'], array('controller' => 'orders', 'action' => 'view', $assignment['Order']['id'])); ?></td>
		<td><?php __($assignment['Order']['sa_city'].", ".$assignment['Order']['sa_state']); ?></td>
		<td><?php __('company name'); ?></td>
		<td><?php __($assignment['Order']['file']); ?></td>
		<td><?php __($counter->formatdate('nsdatetime',$assignment['Assignment']['created'])); ?></td>
		<td class="actions"><?php echo $html->link(__('View', true),array('action'=>'view',$assignment['Assignment']['id']), array('class'=>'view_btn','title'=>'View details','alt'=>'View details')); ?></td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php __($this->element('pagination')); ?>
<?php } else {?>
<?php __($this->element('nobox', array('displaytext'=>'No assignments yet'))); ?>	
<?php } ?>
</div>
</div>