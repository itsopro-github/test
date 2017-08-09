<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php e($javascript->link('ui.datepicker')); ?>
<script type="text/javascript">$(function(){$('#PaidDate').datepicker();});</script>	
<?php $html->addCrumb("Invoices", array('controller'=>'invoices','action'=>'index'));?><?php $html->addCrumb("Edit invoice", array());?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Edit Invoice');?></h1>
			<ul>
			<li><?php echo $html->link(__('List Invoice', true), array('action' => 'index')); ?></li>
			</ul>
		</div>
		<div class="block_content">
			<div class="form">
			<?php __($this->element('admin/invoiced')); ?>
			<?php __($form->create('Invoice',array('action'=>'edit/'.$invoice['Invoice']['id'],'enctype'=>'multipart/form-data')));?>
			<table class="formtable">
				<tr>
					<th width="25%"><?php __('Invoice'); ?></th>
					<td width="25%"><?php __($form->input('invoicedoc', array('label'=>false,'type'=>'file','class'=>'text','error'=>false,'id'=>'InvoiceDoc','div'=>false))); ?><br /><span class="mandatory">[ Recommended file type: pdf ]</span></td>
				</tr>
				<tr>
					<th><label>Comments</label></th>
					<td colspan="3"><?php __($form->input('comments', array('label'=>false,'class'=>'text','style'=>'width:98%','error'=>false,'div'=>false))); ?></td>
				</tr>
				<tr>
					<th><?php __('Status'); ?></th>
					<td><?php echo $form->input('status', array('id'=>'status','label'=>false,'onchange'=>'showtxtb()','class'=>'select_box','error'=>false,'div'=>false, 'options'=>$paidoptions, 'selected'=>@$invoice['Invoice']['status']));?></td>
					<td colspan="2">
						<div style="display:none;" id="PaidDatediv">
							<table>
								<tr>
									<th width="25%"><?php __('Paid date'); ?></th>
									<td width="25%" class="noborder"><?php echo $form->input('Invoice.paiddate',array('id'=>'PaidDate','label'=>false,'div'=>false,'class'=>'text','type'=>'text','readonly'=>true)); ?></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				</tbody>
			</table>
<?php 
			__($form->hidden('track_shipno', array('value'=>$track_shipno)));
			__($form->hidden('track_no', array('value'=>$track_no)));
			__($form->hidden('oid', array('value'=>$invoid)));
			__($form->hidden('odrid', array('value'=>$invodrid)));
			__("<hr />");
			__($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft')));
			__($html->link('Cancel',array('controller'=>'invoices','action'=>'index'),array('div'=>false,'class'=>'normalbutton fleft')));
			__($form->hidden('id', array('value'=>$invoice['Invoice']['id'])));
			__($form->end());
?>
			</div>
		</div>
	</div>
</div>
<script>function showtxtb(){if(document.getElementById('status').value =='1'){document.getElementById('PaidDatediv').style.display = "block";}else{document.getElementById('PaidDatediv').style.display="none";}}</script>