<div class="mainBox subBoxborder" style="width:98%;">
<?php
$j = 0;
$opentab = "details";
if($orders) {
	foreach ($orders as $order):
		if ($order['Order']['track_shipping_info']=='F') {
			$trackingno = '<a href="'.Configure::read('fedextracking').$order['Order']['tracking_no'].'" target="_blank">'. $order['Order']['tracking_no'] .'</a>';
		} elseif ($order['Order']['track_shipping_info']=='U') {
			$trackingno = '<a href="'.Configure::read('upstracking').$order['Order']['tracking_no'].'" target="_blank">'. $order['Order']['tracking_no'] .'</a>';
		} elseif ($order['Order']['track_shipping_info']=='D') {
			$trackingno = '<a href="'.Configure::read('dhltracking').'" target="_blank">'. $order['Order']['tracking_no'] .'</a>';
		} elseif ($order['Order']['track_shipping_info']=='G') {
			$trackingno = '<a href="'.Configure::read('gsotracking').'" target="_blank">'. $order['Order']['tracking_no'] .'</a>';
		} elseif ($order['Order']['track_shipping_info']=='E') {
			$trackingno = '<a href="'.Configure::read('overniteexpress').'" target="_blank">'. $order['Order']['tracking_no'] .'</a>';
		} else {
			$trackingno = $order['Order']['tracking_no'];
		}
		if($order['Order']['orderstatus_id']==$statusid) {
			$class = ' class="'.$classappend.' ordertitle"';
			if($j++ % 2 == 0){
				$class = ' class="'.$classappend.' ordertitle"';$class1 =''.$classappend;
				$classhead = ' class="'.$classappend.' ordertitle"';$classhead1 =''.$classappend;
			}
			if($j==1) {
?>
<div <?php echo $classhead;?>><h3><?php __(Inflector::humanize($ordertitle)); ?>
<span style="font-size:11px;padding-left: 8px;"><?php __(@$ordersubtitle);?></span></h3></div>
	<table cellpadding="0" cellspacing="0" class="tablelist">			
		<thead <?php echo $class;?>>
			<th width="4%">#</th>
			<th width="6%"><?php echo 'Received';?></th>
			<th width="6%"><?php echo 'Updated';?></th>
			<th width="13%"><?php echo 'Borrower'?></th>
			<th width="13%"><?php echo 'City,State';?></th>
			<th width="5%"><?php echo 'File#';?></th>
			<th width="14%"><?php echo 'Company/Division';?></th>
			<th width="6%"><?php echo 'Appt date/Time';?></th>
			<th width="12%"><?php echo 'Notary';?></th>
			<th width="6%"><?php echo 'Ownership';?></th>
			<th width="1%">Update</th>
<?php 
		if($order['Order']['orderstatus_id']=='7') { 
			$opentab = 'track';
?>
			<th width="7%">Tracking #</th>
<?php
		}
?>
		</thead>
<?php } ?>	
	<tr <?php echo $class;?>><a alt="Update" class=<?=$class1?> title="Update" href="/WBSW/admin/orders/view/".<?=$order['Order']['id']?>>	
		<td><?php echo $html->link($counter->counters($j), array('controller'=>'orders','action'=>'view', $order['Order']['id'], $opentab), array( 'title'=>'Update','alt'=>'Update')); ?> </td>
		<td><?php echo $html->link($counter->formatdate('nsdatetimemeridiem',$order['Order']['created']), array('controller'=>'orders','action'=>'view', $order['Order']['id'], $opentab), array( 'title'=>'Update','alt'=>'Update')); ?></td>
		<td><?php echo $html->link($counter->formatdate('nsdatetimemeridiem',$order['Order']['modified']), array('controller'=>'orders','action'=>'view', $order['Order']['id'], $opentab), array( 'title'=>'Update','alt'=>'Update')); ?></td>
		<td><?php echo $html->link($order['Order']['first_name'].' '.$order['Order']['last_name'], array('controller'=>'orders','action'=>'view', $order['Order']['id'], $opentab), array( 'title'=>'Update','alt'=>'Update')); ?></td>
		<td><?php echo $html->link($order['Order']['sa_city'].', '.$order['Order']['sa_state'], array('controller'=>'orders','action'=>'view', $order['Order']['id'], $opentab), array('title'=>'Update','alt'=>'Update')); ?></td>
		<td><?php echo $html->link($order['Order']['file'], array('controller'=>'orders','action'=>'view', $order['Order']['id'], $opentab), array( 'title'=>'Update','alt'=>'Update')); ?></td>
		<td><?php echo $html->link($misc->getCompName($order['Order']['user_id'])." / ".$misc->getDivName($order['Order']['user_id'], $opentab), array('controller'=>'orders','action'=>'view', $order['Order']['id'], $opentab), array( 'title'=>'Update','alt'=>'Update'));?></td>
		<td><?php echo $html->link($misc->getApptdttime($order['Order']['id']), array('controller'=>'orders','action'=>'view', $order['Order']['id'], $opentab), array( 'title'=>'Update','alt'=>'Update'));?></td>	
		<td><?php echo $html->link($misc->getNotaryName($order['Order']['id']), array('controller'=>'orders','action'=>'view', $order['Order']['id'], $opentab), array( 'title'=>'Update','alt'=>'Update')); ?></td>
		<td><?php if($order['Order']['attended_by']<>"0"){
			echo $html->link($misc->getAdminName($order['Order']['attended_by']), array('controller'=>'orders','action'=>'edit', $order['Order']['id']), array( 'title'=>'Update','alt'=>'Update'));
		} else {
			echo $html->link('(Select Admin)', array('controller'=>'orders','action'=>'edit', $order['Order']['id']), array( 'title'=>'Update','alt'=>'Update'));
		}
?>
		</td>
		<td class="actions" nowrap="nowrap">
			<?php
			$val = $misc->getAdminupdate($order['Order']['id']);
			if($val == 'true') {
			?>
				<?php echo $html->link(__('View', true), array('controller'=>'orders', 'action'=>'view', $order['Order']['id'], $opentab, 'history'), array('class'=>'inactive_btn', 'title'=>'Change Status', 'alt'=>'Change Status'));?>
			<?php
			}
			?>
		</td>
		<?php if($order['Order']['orderstatus_id']=='7') { ?>
		<td width="6%">
			<?php if($order['Order']['tracking_no']){echo $trackingno;} else { ?> 
			<span class="mandatory"><b><?php echo $html->link(__('ADD TRACKING #', true), array('controller'=>'orders','action'=>'view',$order['Order']['id'], $opentab), array('class'=>'mandatory','title'=>'Change Status', 'alt'=>'Change Status') );?></b></span>
			<?php } ?>
		</td>
		<?php } ?>
	</a></tr>
<?php 
		}
	endforeach;
}
if($j!=0) {
?>		
	</table>
<?php
}
?>		
<div>
<?php
if($j==0) {
	__($this->element('nobox', array('displaytext'=>'No '.$ordertitle.' found')));		
}
?>
</div>
</div>
