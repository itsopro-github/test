<div class="mainBox subBoxborder" style="width:98%;">
	<div class="header"><h3>Invoice details</h3></div>
	<div class="content">
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
				<th width="20%"><?php __('Borrower'); ?></th>
				<td width="30%"><?php  __($html->link(__($invoice['Order']['first_name'].' '.$invoice['Order']['last_name'],true),array('controller'=>'orders','action'=>'view',@$invoice['Order']['id'])));  ?></td>
				<th width="20%"><?php __('Client (Company)'); ?></th>
				<td width="30%"><?php __($misc->getCompName($invoice['Order']['user_id']));  ?></td>
			</tr>
			<tr>
				<th><?php __('File number'); ?></th>
				<td><?php __($invoice['Order']['file']);  ?></td>
				<th><?php __('Notary'); ?></th>
				<td><?php __($misc->getNotaryName($invoice['Invoice']['order_id']));  ?></td>
			</tr>
			<tr>
				<th><?php __('Fees'); ?></th>
				<td><?php __(Configure::read('currency')); ?><?php echo $invoice['Invoice']['totalfees']; ?></td>
				<th><?php __('Invoice'); ?></th>
				<td>
				<a href="<?php __(Configure::read('WEB_URL').Configure::read('INVOICE_FILE_PATH')); ?><?php echo $invoice['Invoice']['invoicedoc']; ?>" target="_blank"><?php echo $invoice['Invoice']['invoicedoc']; ?></a>
				</td>
			</tr>
			<tr>
				<th><?php __('Status'); ?></th>
				<td><?php echo $paidoptions[$invoice['Invoice']['status']]; ?></td>
				<th><?php __('Paid date'); ?></th>
				<td><?php if($invoice['Invoice']['paiddate']<>"0000-00-00 00:00:00"){ __($counter->formatdate('nsdatetimemeridiem',$invoice['Invoice']['paiddate'])); }?></td>
			</tr>
		</table>
	</div>
</div>