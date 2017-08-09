<div class="orders index">	
	<div class="block">
	<table cellpadding="0" cellspacing="0" class="tableview">
		<tr>
		     <th><?php __('Borrower name'); ?></th>
		     <td><?php echo $invoice['Order']['first_name']." ".$invoice['Order']['last_name']; ?></td>
		  </tr>
		  <tr>
		     <th><?php __('Total fees'); ?></th>
		     <td><?=Configure::read('currency')?><?php echo $invoice['Invoice']['totalfees']; ?></td>
		  </tr>
		 
		  <tr>
		     <th><?php __('Doc'); ?></th>
		     <td><a href="<?=Configure::read('WEB_URL').Configure::read('INVOICE_FILE_PATH')?><?php echo $invoice['Invoice']['invoicedoc']; ?>" target="_blank" class="dnld_btn">download</a></td>
		  </tr>
		    <tr>
		     <th><?php __('Comments'); ?></th>
		     <td><?php echo nl2br($invoice['Invoice']['comments']); ?></td>
		  </tr>
		 
		  <tr>
		     <th><?php __('Status'); ?></th>
		     <td><?php echo $paidoptions[$invoice['Invoice']['status']]; ?></td>
		  </tr>
		  <tr>
		     <th><?php __('Created'); ?></th>
		     <td><?php echo $counter->formatdate('nsdatetimemeridiem', $invoice['Invoice']['created']); ?></td>
		  </tr>
		  <tr>
		     <th><?php __('Modified'); ?></th>
		     <td ><?php echo $counter->formatdate('nsdatetimemeridiem', $invoice['Invoice']['modified']); ?></td>
		  </tr>
	</table>
	<a href="<?=Configure::read('WEB_URL')?>myaccount/invoices">Back</a>
</div></div>
<?php if($session->read('WUBSSEWR.User.type') == 'C'){?>
<script>doEvent();</script>	
<?php } ?>	