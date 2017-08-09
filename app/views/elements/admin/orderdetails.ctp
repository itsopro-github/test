<div class="mainBox subBoxborder" style="width:98%;">
	<div class="header"><h3>Order Information</h3></div>
	<div class="content">
		<table border="0" cellspacing="0" cellpadding="0" class="tableview">
			<tr>
				<th width="20%"><?php __('Borrower'); ?></th>
				<td><?php __($order['Order']['first_name'].' '.$order['Order']['last_name']); ?></td>	
				<th width="20%"><?php __('Email'); ?></th>
				<td><?php __($order['Order']['email']); ?></td>	
			</tr>
			<tr>
				<th width="20%"><?php __('City,State'); ?></th>
				<td><?php echo $order['Order']['sa_city'].', '.$order['Order']['sa_state']; ?></td>
				<th width="20%"><?php __('Zip Code'); ?></th>
				<td colspan="3"><?php  echo $order['Order']['sa_zipcode'];  ?></td>
			</tr>
			<tr>
				<th width="20%"><?php __('File Number'); ?></th>
				<td><?php echo $order['Order']['file']; ?></td>
				<th width="20%"><?php __('Date of Signing'); ?></th>
				<td><?php echo $counter->formatdate('nsdate',$order['Order']['date_signing']); ?></td>
			</tr>
		</table>
	</div>
</div>