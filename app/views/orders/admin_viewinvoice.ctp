<?php $html->addCrumb("Invoices", array('controller' => 'orders','action' => 'invoices')); $html->addCrumb('View', array());
$result=$this->Session->read('WBSWAdmin');
	$admintype=$result['Admin']['type'];
	if($admintype!='E'){ 
?> 
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header">
			<h1 class="fleft"><?php echo "Invoice details [".$order['Order']['first_name']." ".$order['Order']['last_name']."]" ?></h1>
			<ul>
				<li><a href="<?=Configure::read('WEB_URL')?>admin/orders/print/<?=$order['Order']['id']?>" target="_blank">Print Invoice</a></li>
			</ul>
		</div>
		<div class="block_content">		
		<table cellpadding="1" cellspacing="1" class="tablelist">
			<tr>
				<th><?php __('Name'); ?></th>
				<td><?php echo $order['Order']['first_name']." ".$order['Order']['last_name']; ?></td>	
			</tr>		
			
			
			<tr>
				<th><?php __('Signing  Zipcode'); ?></th>
				<td><?php echo $order['Order']['sa_zipcode']; ?></td>
			</tr>
			<tr>
				<th><?php __('Fees'); ?></th>
				<td><?php  __(Configure::read('currency').$order['Assignment'][0]['fee']); ?></td>
			</tr>
			<tr>
				<th><?php __('Details'); ?></th>
				<td><?php echo nl2br($order['Assignment'][0]['details']); ?></td>
			</tr>
<?php
		$os = $order['Assignment'][0]['status'];
		if($os == 'P'){ $s = 'Pending'; }
		elseif($os == 'A'){ $s = 'Accepted'; }
		elseif($os == 'R'){ $s = 'Rejected'; }
?>
			<tr>
				<th><?php __('Status'); ?></th>
				<td><?php echo $s; ?></td>
			</tr>
		</table>	
		</div>
	</div>
</div>
<?php	}
	else{
		__($this->element('nopermission')); 
}?>