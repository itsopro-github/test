<?php $html->addCrumb("Invoices", array('controller'=>'invoices','action'=>'index'));?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft">Invoice [<?php __($invoice['Order']['first_name'].' '.$invoice['Order']['last_name']); ?>]</h1>
			<ul>
		      	<li><?php echo $html->link(__('List Invoices', true), array('action' => 'index')); ?></li>
		      	<li><?php echo $html->link(__('Edit this Invoice', true), array('action' => 'edit',$invoice['Invoice']['id'])); ?></li>
	       </ul>
       	</div>
		<div class="block_content fleft" style="width:64%;">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			  <tr>
			     <th width="20%"><?php __('Borrower'); ?></th>
			     <td width="30%"><?php  __($html->link(__($invoice['Order']['first_name'].' '.$invoice['Order']['last_name'],true),array('controller'=>'orders','action'=>'view',$invoice['Order']['id'])));  ?></td>
			  </tr>
			  <tr>
		    	 <th width="20%"><?php __('Client (Company)'); ?></th>
			     <td width="30%"><?php  echo $misc->getCompName($invoice['Order']['user_id']);  ?></td>
			  </tr>
			  <tr>
			     <th><?php __('File number'); ?></th>
			     <td><?php  __($invoice['Order']['file']);  ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Notary'); ?></th>
			     <td><?php  echo $misc->getNotaryName($invoice['Invoice']['order_id']);  ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Fees'); ?></th>
			     <td><?php __(Configure::read('currency')); ?><?php echo $invoice['Invoice']['totalfees']; ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Invoice'); ?></th>
			     <td><a href="<?php __(Configure::read('WEB_URL').Configure::read('INVOICE_FILE_PATH')); ?><?php echo $invoice['Invoice']['invoicedoc']; ?>" target="_blank"><?php echo $invoice['Invoice']['invoicedoc']; ?></a></td>
			  </tr>
			  <tr>
			     <th><?php __('Comments'); ?></th>
			     <td><?php echo nl2br($invoice['Invoice']['comments']); ?></td>
			  </tr>
			</table>
		</div>
		<div class="mainBox subBoxborder fleft" style="width:31%;">
			<div class="header"><h1>More Information</h1></div>
			<div class="block_content">
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
				  <tr>
				     <th><?php __('Status'); ?></th>
				     <td><?php echo $paidoptions[$invoice['Invoice']['status']]; ?></td>
				  </tr>
				  <tr>
				     <th><?php __('Invoice date'); ?></th>
				     <td><?php echo $counter->formatdate('nsdate', $invoice['Invoice']['created']); ?></td>
				  </tr>
<?php
if($invoice['Invoice']['status']==1) {
?>
				  <tr>
				     <th><?php __('Paid date'); ?></th>
				     <td><?php __($counter->formatdate('nsdate', $invoice['Invoice']['paiddate']));?></td>
				  </tr>
<?php
}
?>				  
				  <tr>
				     <th><?php __('Modified'); ?></th>
				     <td ><?php echo $counter->formatdate('nsdatetimemeridiem', $invoice['Invoice']['modified']); ?></td>
				  </tr>
			  </table>
			</div>
		</div>
	</div>
</div>