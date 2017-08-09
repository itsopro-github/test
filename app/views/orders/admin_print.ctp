<?php
$result=$this->Session->read('WBSWAdmin');
	$admintype=$result['Admin']['type'];
	if($admintype!='E'){ ?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="block_content">		
		<table width="100%" border="0" cellpadding="1" cellspacing="1" class="tablelist">
			<tr>
				<th><?php __('Name'); ?></th>
				<td><?php echo $order['Order']['first_name']." ".$order['Order']['last_name'];  ?></td>	
			</tr>		
			<tr>
				<th><?php __('Signing  Zipcode'); ?></th>
				<td><?php echo $order['Order']['sa_zipcode']; ?></td>
			</tr>
			<tr>
				<th><?php __('Fees'); ?></th>
				<td><?php echo $order['Assignment'][0]['fee']; ?></td>
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
	<?}
	else{
		__($this->element('nopermission')); 
}?>