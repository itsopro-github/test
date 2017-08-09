<?php
$j = 0;
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
if ($usersession['User']['type'] == 'C' && $classappendhead == 'completed_head') {
	$stylew = 'style="padding-left:5px;width:681px;"';
} else {
	$stylew = 'style="padding-left:5px;"'	;
}
	$class = null;
	if(in_array($order['Order']['orderstatus_id'],$statusid)) {
		$class = ' class="'.$classappend.'"';
		if ($j++ % 2 == 0) { 
			$class = ' class="'.$classappend.' "';
			$class1 =''.$classappend;
			$classhead = ' class="'.$classappendhead.' ordertitle"';
			$classhead1 =''.$classappend;
			$listheader = ' class="'.$classappendhead.' listheader"';
		}
		
		if($j==1) {
?>
	<table cellpadding="0" cellspacing="0" class="tablelist">	
		<tr class="listtop">
			<td colspan="9"><div <?php echo $classhead;?>><h2>&nbsp;<?php __(Inflector::humanize($ordertitle)); ?><span style="font-size:11px;padding-left: 8px;color:#000000"><?php __(@$ordersubtitle);?></span></h2></div></td>
		</tr>
		<tr id="listorderhead" <?php __($listheader);?>>
			<td width="5%">No</td>
			<td>Borrower</td>
			<td width="15%">City,State</td>
			<td width="10%">File#</td>
			<?php if($usersession['User']['type']=='IN') { ?><td>Company</td><?php } ?>
			<td width="10%">Appt.date/ Time</td>
			<?php if($usersession['User']['type']=='C' and $statusid>1) { ?><td width="15%">Notary</td><?php } ?>
			<?php if($usersession['User']['type']=='C'){?><td width="10%">Request Sent</td><td width="15%">Last Updated</td><?php } ?>
			<?php if($order['Order']['orderstatus_id']=='7') {?><td width="5%">Tracking #</td><?php }?>
		</tr>
<?php } ?>		
		<tr <?php __($class);?>>
			<td><?php  __($html->link($counter->counters($j),array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($order['Order']['first_name'].' '.$order['Order']['last_name']),'id'=>$order['Order']['id']),array('title'=>'View Details','alt'=>'View Details')));  ?></td>
			<td  style="width:'auto' !important;"><?php __($html->link($order['Order']['first_name'].' '.$order['Order']['last_name'],array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($order['Order']['first_name'].' '.$order['Order']['last_name']),'id'=>$order['Order']['id']),array('title'=>'View Details','alt'=>'View Details'))); ?></td>
			<td><?php __($html->link($order['Order']['sa_city'].', '.$order['Order']['sa_state'],array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($order['Order']['first_name'].' '.$order['Order']['last_name']),'id'=>$order['Order']['id']),array('title'=>'View Details','alt'=>'View Details')));  ?></td>
			<td><?php __($html->link($order['Order']['file'],array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($order['Order']['first_name'].' '.$order['Order']['last_name']),'id'=>$order['Order']['id']),array('title'=>'View Details','alt'=>'View Details')));  ?></td>
		<?php if($usersession['User']['type']=='IN') { ?><td><?php __($order['Client']['Company'],array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($order['Order']['first_name'].' '.$order['Order']['last_name']),'id'=>$order['Order']['id']),array('title'=>'View Details','alt'=>'View Details'));  ?></td><?php } ?>
			<td><?php __($html->link($misc->getApptdttime($order['Order']['id']),array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($order['Order']['first_name'].' '.$order['Order']['last_name']),'id'=>$order['Order']['id']),array('title'=>'View Details','alt'=>'View Details'))); ?></td>
<?php if($usersession['User']['type']=='C') { ?><td><?php __($html->link($misc->getNotaryName($order['Order']['id']),array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($order['Order']['first_name'].' '.$order['Order']['last_name']),'id'=>$order['Order']['id']),array('title'=>'View Details','alt'=>'View Details'))); ?></td><?php } ?>

		<?php	if($usersession['User']['type']=='C'){?><td><?php __($html->link($counter->formatdate('nsdatetimemeridiem',$order['Order']['created']),array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($order['Order']['first_name'].' '.$order['Order']['last_name']),'id'=>$order['Order']['id']),array('title'=>'View Details','alt'=>'View Details')));  ?></td><? }?>
		<?php	if($usersession['User']['type']=='C'){?><td><?php __($html->link($counter->formatdate('nsdatetimemeridiem',$order['Order']['modified']),array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($order['Order']['first_name'].' '.$order['Order']['last_name']),'id'=>$order['Order']['id']),array('title'=>'View Details','alt'=>'View Details')));  ?></td><? }?>
<?php 
		if($order['Order']['orderstatus_id']=='7' && $usersession['User']['type']=='N') {
?>
			<td>
<?php 
			if ($order['Order']['tracking_no']) {
				$trackingno;
			} else { 
?>
			<span class="mandatory"><b><?php echo $html->link(__('ADD TRACKING #', true), array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($order['Order']['first_name'].' '.$order['Order']['last_name']),'id'=>$order['Order']['id']), array('class'=>'mandatory','title'=>'Change Status', 'alt'=>'Change Status') ); ?></b></span>
<?php
			}
?>
			</td>
<?php 
		} 
		if($order['Order']['orderstatus_id'] == '7' && $usersession['User']['type'] == 'C') {
?>
			<td><?php __(($order['Order']['tracking_no'])? $trackingno:  'In Progress'); ?></td>
<?php 
		}
?>
	</tr>
<?php 
	}
endforeach;
if($j!=0) {
?>		
</table>
<?php
}
if($j==0) {
	$class = ' class="'.$classappend.'"';$class1 =''.$classappend;
		$classhead = ' class="'.$classappendhead.' ordertitle"';$classhead1 =''.$classappend;
__('<div>');?>
<div <?php echo $classhead;?> style="padding-left:5px;"><h2><?php __(Inflector::humanize(@$ordertitle)); ?><span style="font-size:11px;padding-left: 8px;color:#000000"><?php __(@$ordersubtitle);?></span></h2></div>
	<?php if($ordertitle=='no sign') { $ordertitle = '"No Sign" files';}
	__($this->element('nobox', array('displaytext'=>'All files have been updated. There are no '.$ordertitle.' at this time.')));
__('</div>');		
}

?>
