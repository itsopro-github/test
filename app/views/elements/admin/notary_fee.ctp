<div class="mainBox subBoxborder" style="width:98%;">
	<div class="header"><h3><?php if(empty($nfee)) echo "Add "; ?>Notary Fee</h3></div>
	<div class="content">
<?php 
	if($nfee) {
		$cntNot = 1;
?>
	<div id="nfeeview">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
			<thead>
				<tr>
<?php 
		$cnt=1;
		foreach ($nfee as $aval){?>
				<th width="25%"><?php __($notfee[$aval['NotaryFees']['fee_type']])?></th>
				<input type="hidden" id="fee_type" name="data[NotaryFees][fee_type][]" value="<?php __($aval['NotaryFees']['fee_type']);?>"/>
				<td width="25%"><?php __(Configure::read('currency').$aval['NotaryFees']['fees']) ?></td>
<?php 
			if($cnt %2=='0') {
				echo "</tr><tr>";
			}
			$cnt++;
		}
?>
				<tr>
					<th colspan="4"><hr /></th>
				</tr>
				<tr>
					<th>Total</th>
					<td colspan="3"><b><?php echo Configure::read('currency').@$order['Order']['fee_total'];?></b></td>
				</tr>
				<tr>
					<th>Notes</th>
					<td colspan="3" class="noborder"><?php echo nl2br(@$order['Order']['fee_notes']);?></td>
				</tr>
				<tr>
					<td colspan="4" class="noborder">
<?php 
	if($order['Order']['attended_by']!="0" and ($admindata['Admin']['id']==$order['Order']['attended_by'])) {
		__($html->link('Edit Notary Fee', '#', array('class'=>'normalbutton_big fright','onclick'=>'showNotaryFeeview()')));
	}
?>
					</td>
				</tr>
			</thead>
		</table>
	</div>
<?php 
}
	if(empty($nfee)) {
		$cntNot = 1;
		if($order['Order']['attended_by']=="0" or ($admindata['Admin']['id']==$order['Order']['attended_by'])) {
			__($form->create('NotaryFees',array('action'=>'add')));
?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
			<thead>
			<tr>
<?php 
	$cnt=1;
	foreach ($notfee as $key=>$aval) { 
?>
				<th><?php __($aval)?> (<?php __(Configure::read('currency'))?>)</th>
				<td>
<?php 
		if($cnt=='1') { 
			__($form->input('fees', array('label'=>false,'class'=>'text','name'=>'data[NotaryFees][fees][]','error'=>false,'div'=>false,'value'=>@$assign[0]['User']['Notary']['fees'])));
		} else { 
			__($form->input('fees', array('label'=>false,'class'=>'text','name'=>'data[NotaryFees][fees][]','error'=>false,'div'=>false)));
		}
?>
					<input id="fee_type" type="hidden" name="data[NotaryFees][fee_type][]" value="<?php __($key);?>"/>
				</td>
<?php
		if($cnt %2=='0') {
			echo "</tr><tr>";
		}
		$cnt++;
	}
?>	
				<input type="hidden" id="order_id" name="data[NotaryFees][order_id]" value="<?php __($order['Order']['id']);?>"/>
				<tr>
					<th>Notes</th><td colspan="3"><?php __($form->input('fee_notes',array('error'=>false,'label'=>false,'id'=>'fee_notes','class' => 'text', 'rows'=>'4', 'cols'=>'115','name'=>'data[Order][fee_notes]'))); ?></td>
				</tr>			
			</thead>
			<tbody>
				<tr>
					<th></th>
					<td colspan="3" class="noborder">
						<?php __($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft'))); ?>
						<?php __($html->link('Cancel', '#', array('onclick'=>"loadBlock('nfeediv');",'div'=>false,'class'=>'normalbutton fleft'))); ?>
					</td>
				</tr>
			</tbody>
		</table>
<?php 
	echo $form->end();
	}
} 
if($order['Order']['attended_by']=="0" or ($admindata['Admin']['id']==$order['Order']['attended_by'])){
?>
	<div id="nfeeedit" style="display:none;">
	<?php __($form->create('NotaryFees',array('action'=>'edit'))); ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
			<thead><tr>
<?php 
	$cnt = 1; 
		foreach ($nfee as $aval) { 
?>
				<th width="20%"><?php __($notfee[$aval['NotaryFees']['fee_type']])?> (<?php __(Configure::read('currency'))?>)</th>
				<td width="20%"><?php __($form->input('fees', array('label'=>false,'class'=>'text','error'=>false,'div'=>false,'name'=>'data[NotaryFees][fees][]','value'=>$aval['NotaryFees']['fees']))); ?>
				<input type="hidden" id="fee_type" name="data[NotaryFees][fee_type][]" value="<?php __($aval['NotaryFees']['fee_type']);?>"/>
				<input type="hidden" id="id" name="data[NotaryFees][id][]" value="<?php __($aval['NotaryFees']['id']);?>"/>
				</td>
<?php
			if($cnt %2=='0'){
				echo "</tr><tr>";
			}
			$cnt++;
		}
?>
				<input type="hidden" id="order_id" name="data[NotaryFees][order_id]" value="<?php __($order['Order']['id']);?>"/>	
				<tr>
					<th>Notes</th>
					<td colspan="3"><?php __($form->input('fee_notes',array('error'=>false,'label'=>false,'id'=>'fee_notes','class'=>'text','rows'=>'2','cols'=>'115','name'=>'data[Order][fee_notes]','value'=>@$order['Order']['fee_notes']))); ?></td>
				</tr>				
				<tr>
					<th></th>
					<td class="noborder" colspan="3">
						<?php __($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft'))); ?>
						<?php __($html->link('Cancel', '#nfeediv', array('onclick'=>"showNotaryFee()",'div'=>false,'class'=>'normalbutton fleft'))); ?>
					</td>
				</tr>
			</tbody>
		</table>
<?php echo $form->end();?>
	</div>
<?php 
	}
?>
</div>
</div>
<script>function showNotaryFeeview() {document.getElementById('nfeeedit').style.display = "block";document.getElementById('nfeeview').style.display = "none";}function showNotaryFee() {document.getElementById('nfeeview').style.display = "block";document.getElementById('nfeeedit').style.display = "none";}</script>