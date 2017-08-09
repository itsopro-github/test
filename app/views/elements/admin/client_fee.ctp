<?php $admin_data = $this->Session->read('WBSWAdmin');
$admin_id = $admin_data['Admin']['id'];?>
<div class="mainBox subBoxborder" style="width:98%;">
	<div class="header"><h3><?php if(empty($cfee)) echo "Add "; ?>Client Fee</h3></div>
	<div class="content">
<?php
	if($cfee){
		$cntNot = 1;
?>		<div id="cfeeview">

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
			<thead>
				<tr>
<?php 
			$cnt=1;
			foreach ($cfee as $aval) {
?>
				<th width="25%"><?php __($notfee[$aval['ClientFees']['fee_type']])?></th>
				<input type="hidden" id="fee_type" name="data[ClientFees][fee_type][]" value="<?php __($aval['ClientFees']['fee_type']);?>"/>
				<td width="25%"><?php __(Configure::read('currency').$aval['ClientFees']['fees']) ?></td>
<?php 
				if($cnt %2=='0'){
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
					<td colspan="3"><b><?php echo Configure::read('currency').@$order['Order']['cfee_total'];?></b></td>
				</tr>
				<tr>
					<th>Notes</th>
					<td colspan="3" class="noborder"><?php echo nl2br(@$order['Order']['cfee_notes']);?></td>
				</tr>
			</thead>
			<tr>
				<td colspan="4" class="noborder">
<?php
	if($order['Order']['attended_by']!="0" and ($admin_id==$order['Order']['attended_by'])) { 
		__($html->link('Edit Client Fee','#',array('onclick'=>"showClientFeeview()",'class'=>'normalbutton_big fright')));
	}
?>
				</td>
			</tr>
		</table>
	</div>
<?php
	}
	if(empty($cfee)){
		$cntNot = 1;
		if($order['Order']['attended_by']=="0" or ($admin_id==$order['Order']['attended_by'])){
?>
	<?php __($form->create('ClientFees',array('action'=>'add'))); ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
			<thead>
				<tr>
<?php
	$cnt=1;
	foreach ($notfee as $key=>$aval){?>
		<th width="20%"><?php __($aval)?> (<?php __(Configure::read('currency'))?>)</th>
		<td width="20%">
<?php
		if($cnt=='1') {
			__($form->input('fees', array('label'=>false,'class'=>'text','name'=>'data[ClientFees][fees][]','error'=>false,'div'=>false,'value'=>@$clientdetails['Client']['fees'])));
		} else { 
			__($form->input('fees', array('label'=>false,'class'=>'text','name'=>'data[ClientFees][fees][]','error'=>false,'div'=>false)));
		}
?>
		<input id="fee_type" type="hidden" name="data[ClientFees][fee_type][]" value="<?php __($key);?>"/>
	</td>
<?php
		if($cnt %2=='0'){
			echo "</tr><tr>";
		}
		$cnt++;
	}
?>	
				<input type="hidden" id="order_id" name="data[ClientFees][order_id]" value="<?php __($order['Order']['id']);?>"/>
				<tr>
				<th>Notes</th><td colspan="3"><?php __($form->input('cfee_notes',array('error'=>false,'label'=>false,'id'=>'cfee_notes','class'=>'text', 'rows'=>'4', 'cols'=>'115','name'=>'data[Order][cfee_notes]'))); ?></td>
				</tr>			
			</thead>
			<tbody>
	<tr>
	<th></th>
	<td colspan="3" class="noborder">
		<?php __($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft'))); ?>
		<?php __($html->link('Cancel', '#', array('onclick'=>"loadBlock('cfeediv');",'div'=>false,'class'=>'normalbutton fleft'))); ?>
	</td>
	</tr></tbody>
	</table><?php echo $form->end(); ?>
<?php
	}
	} ?>
	<?php if($order['Order']['attended_by']=="0" or ($admin_id==$order['Order']['attended_by'])){?>
	<div id="cfeeedit" style="display:none;">
	<?php __($form->create('ClientFees',array('action'=>'edit'))); ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
	
			<thead><tr>
<?php 
			$cnt=1; 
			foreach ($cfee as $aval){
?>
		
				<th width="20%"><?php __($notfee[$aval['ClientFees']['fee_type']])?> (<?php __(Configure::read('currency'))?>)</th>
				<td width="20%"><?php __($form->input('fees', array('label'=>false,'class'=>'text','error'=>false,'div'=>false,'name'=>'data[ClientFees][fees][]','value'=>$aval['ClientFees']['fees']))); ?>
				<input type="hidden" id="fee_type" name="data[ClientFees][fee_type][]" value="<?php __($aval['ClientFees']['fee_type']);?>"/>
					<input type="hidden" id="id" name="data[ClientFees][id][]" value="<?php __($aval['ClientFees']['id']);?>"/>
				
				</td>
<?php
				if($cnt %2=='0'){
					echo "</tr><tr>";
				}
				$cnt++;}
?>
				<input type="hidden" id="order_id" name="data[ClientFees][order_id]" value="<?php __($order['Order']['id']);?>"/>	
				<tr>
				<th>Notes</th><td colspan="3"><?php __($form->input('cfee_notes',array('error'=>false,'label'=>false,'id'=>'cfee_notes','class'=>'text', 'rows'=>'2', 'cols'=>'115','name'=>'data[Order][cfee_notes]','value'=>@$order['Order']['cfee_notes']))); ?></td>
				</tr>				
			</thead>
	<tbody>
	<tr>
	<th></th>
	<td colspan="3">
		<?php __($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft')));?>
		<?php __($html->link('Cancel', '#cfeediv', array('onclick'=>"showClientFee()",'div'=>false,'class'=>'normalbutton fleft'))); ?>
	</td>
	</tr></tbody>
	</table>
	<?php echo $form->end(); ?>
		</div>
		<?php }
	?>
	</div>
</div>
<script>
function showClientFeeview() {
	document.getElementById('cfeeedit').style.display = "block";
	document.getElementById('cfeeview').style.display = "none";
 }
function showClientFee() {
	document.getElementById('cfeeview').style.display = "block";
	document.getElementById('cfeeedit').style.display = "none";
}
</script>