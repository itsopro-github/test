<div><h2><?php __(Inflector::humanize($ordertitle)); ?></h2></div>
<?php
$j = 0;
foreach ($invoices as $invoice):
	$class = null;
	//if($invoice['Order']['orderstatus_id']==$statusid) {
		if ($j++ % 2 == 0) {$class = ' class="altrow"';}
		if($j==1) {
?>
	<table cellpadding="0" cellspacing="0" class="tablelist">			
		<thead>
			<th width="3%">No</th>
			<th width="20%">Borrower</th>
			<th width="12%"">File#</th>
			<th width="12%"">Client (Company)</th>
			<th width="25%">Notary</th>
			<th width="23%">Date</th>
			<th width="5%" class="actions">Actions</th>
		</thead>
<?php 	
		}
?>		
		<tr <?php echo $class;?>>
			<td><?php echo $counter->counters($j); ?></td>
			<td><?php  __($html->link($invoice['Order']['first_name'].' '.$invoice['Order']['last_name'],array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($invoice['Order']['first_name'].' '.$invoice['Order']['last_name']),'id'=>$invoice['Order']['id']),array('title'=>'View Details','alt'=>'View Details'))); ?></td>
			<td><?php __($invoice['Order']['file']); ?></td>
			<td><?php __($misc->getCompName($invoice['Order']['user_id'])); ?></td>
			<td><?php __($misc->getNotaryName($invoice['Invoice']['order_id'])); ?></td>
			<td><?php __($counter->formatdate('nsdate',$invoice['Invoice']['created'])); ?></td>
			<td class="actions"><?php __($html->link(__('',true),array('controller'=>'invoices','action'=>'download',$invoice['Invoice']['invoicedoc']),array('class'=>'dnld_btn','alt'=>'Download','title'=>'Download'))); ?></td>
		</tr>
<?php 
	//}
endforeach;
if($j!=0) {
?>		
	</table>
<?php
}
__($this->element('pagination')); 
?>		
<div>
<?php
if($j==0) {
	__($this->element('nobox', array('displaytext'=>'No '.$ordertitle.' invoices found')));		
}
?>
</div>