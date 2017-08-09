<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php e($javascript->link('ui.datepicker')); ?>
<script type="text/javascript">$(function(){$('#PaidDate').datepicker();});</script>	
<?php $html->addCrumb("Invoices", array('controller'=>'invoices','action'=>'index'));?><?php $html->addCrumb("Add invoices", array());?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Add Invoice');?></h1>
			<ul>
		      	<li><?php echo $html->link(__('List Invoices', true), array('action' => 'index')); ?></li>
	       </ul>
       	</div>
		<div class="block_content">
			<?php echo $form->create('Invoice',array('url'=>array('controller'=>'invoices','action'=>'add','id'=>$invoid),'enctype'=>'multipart/form-data'));?>
			<div><p><label>Fees<span class="mandatory">*</span> (<?php __(Configure::read('currency')); ?>)</label><?php __($form->input('totalfees', array('label'=>false,'class'=>'text','type'=>'text','maxlength'=>'125','error'=>false,'div'=>false))); ?></p></div>
			<div><p><label>Invoice<span class="mandatory">*</span></label><?php __($form->input('invoicedoc', array('label'=>false,'type'=>'file','class'=>'text','error'=>false,'id'=>'InvoiceDoc','div'=>false))); ?><br /><span class="mandatory">[ Recommended file type: pdf ]</span></p></div>
			<div><p><label>Comments</label><?php __($form->input('comments', array('label'=>false,'class'=>'text','cols'=>76,'error'=>false,'div'=>false))); ?></p></div>
			<div><p><label class="fleft">Status</label><?php echo $form->input('status', array('id'=>'status','label'=>false,'onchange'=>'showtxtb()','class'=>'select_box','error'=>false,'div'=>false,'options'=>$paidoptions));?></p></div>
			<div style="display:none;" id="PaidDatediv"><p><label>Paid date</label>
				<?php echo $form->input('Invoice.paiddate',array('id'=>'PaidDate','label'=>false,'div'=>false,'class'=>'text','type'=>'text','value'=>$counter->formatdate('nsdate', $this->data['Invoice']['paiddate']),'readonly'=>true)); ?></p></div>
<?php
			__($form->hidden('track_shipno', array('value'=>$track_shipno)));
			__($form->hidden('track_no', array('value'=>$track_no)));
			__($form->hidden('oid', array('value'=>$invoid)));
			__('<hr /');
			__($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft')));
			__($html->link('Cancel',array('controller'=>'invoices','action'=>'index'),array('div'=>false,'class'=>'normalbutton fleft')));
			__($form->end());
?>
		</div>
	</div>
</div>
<script>function showtxtb(){if(document.getElementById('status').value =='1'){document.getElementById('PaidDatediv').style.display="block";}else{document.getElementById('PaidDatediv').style.display="none";}}</script>

