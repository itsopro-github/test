<?php $html->addCrumb("Invoices", array());?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Invoices');?></h1>
			<ul>
				<li><?php __($html->link('search','#',array('onclick'=>"loadSearchBox('search');")));?></li>
			</ul>
		</div>
		<div id="searchdiv" <?php echo (@$_SESSION['search']['params']=='') ? 'style="display:none;"' : 'style="display:block;"'?>>
			<?php echo $form->create('Invoice',array('controller'=>'Invoice','action'=>'search'));?>
			<table border="0" cellspacing="0" cellpadding="0" class="search_box">
				<tr>
					<td>Borrower </td>
					<td><?php echo $form->input('Order.first_name', array('class'=>'text medium', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['first_name']));?></td> 
					<td>Month</td>
					<td><?php echo $form->month('',@$_SESSION['search']['params']['month'],array('class'=>'select_box', 'empty'=>'--Month--'));?></td>
					<td>Year</td>
					<td><?php echo $form->year('', 2010, date('Y')+1, @$_SESSION['search']['params']['year'], array('class'=>'select_box', 'empty'=>'--Year--')); ?></td>
					<td>Status</td>
					<td><?php echo $form->input('status', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$paidoptions, 'empty'=>'--Select--','selected'=>@$_SESSION['search']['params']['status']));?></td>
					<td><?php echo $form->submit('Search', array('div'=>false,'class'=>'submit small fleft'));echo $html->link('Clear', array('action'=>'clear'), array('div'=>false,'class'=>'normalbutton fright'),null,false); ?></td>
				</tr>
			</table>
			<?php echo $form->end(); ?>
			</div>
			<?php if($invoices) { ?>
			<?php echo $form->create('Invoice',array('action'=>'export'),array('id'=>'frminvoice'));?>
			<div class="block_content">
				<table cellpadding="0" cellspacing="0" class="tablelist">
				<thead>
					<th width="5%">Sl No</th>
					<th width="5%"><input type='checkbox' name='checkall' onclick="checkedAll('InvoiceExportForm');"></th>
					<th width="18%"><?php echo $paginator->sort('Borrower');?></th>
					<th width="10%"><?php echo $paginator->sort('File number','Order.file');?></th>
					<th width="18%"><?php echo $paginator->sort('Client (Company)','Client.company');?></th>
					<th width="16%"><?php echo $paginator->sort('Notary','Notary.first_name');?></th>
					<th width="8%"><?php  echo $paginator->sort('Paid','status');?></th>
					<th width="15%"><?php echo $paginator->sort('Invoice date','created');?></th>
					<th width="5%" class="actions"><?php __('Actions');?></th>
				</thead>
<?php
				$i = 0;
				
				foreach ($invoices as $invoice):
					$class = null;
					if ($i++ % 2 != 0) {
						$class = 'class="altrow"';
					}
?>
				<tr <?php echo $class;?> title="<?php __($invoice['Order']['first_name']." ".$invoice['Order']['last_name']);?>">
					<td><?php __($counter->counters($i)); ?></td>
					<td><input type="checkbox" name="data[Invoice][chkb][]" value="<?php echo $invoice['Invoice']['id']?>"></td>
					<td><?php __($html->link(__($invoice['Order']['first_name'].' '.$invoice['Order']['last_name'],true),array('controller'=>'orders','action'=>'view',$invoice['Order']['id'])));?></td>
					<td><?php __($invoice['Order']['file']); ?></td>
					<td><?php echo $misc->getCompName($invoice['Order']['user_id']); ?></td>
					<td><?php echo $misc->getNotaryName($invoice['Invoice']['order_id']); ?></td>
					<td><?php __($paidoptions[$invoice['Invoice']['status']]); ?></td>
					<td><?php __($counter->formatdate('nsdatetimemeridiem',$invoice['Invoice']['created'])); ?></td>
					<td class="actions">
					<?php echo $html->link(__('View', true), array('action'=>'view', $invoice['Invoice']['id']), array('class'=>'view_btn', 'title'=>'View', 'alt'=>'View')); ?>
					<?php echo $html->link(__('Edit', true), array('action'=>'edit', $invoice['Invoice']['id']), array('class'=>'edit_btn', 'title'=>'Edit', 'alt'=>'Edit')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
				</table>
				<?php echo $form->submit('Export', array('div'=>false,'class'=>'submit small fleft','alt'=>'Export to Quickbook','title'=>'Export to Quickbook'));?>
		</div>
			<?php echo $form->end(); ?>
		<?php 	__($this->element('pagination')); ?>
		<?php } else { ?>
		<?php 	__($this->element('nobox')); ?>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">checked=false;function checkedAll(InvoiceExportForm){var chk=document.getElementById('InvoiceExportForm');if(checked==false){checked=true;}else{checked=false;}for(var i=0; i<chk.elements.length; i++){chk.elements[i].checked=checked;}}</script>