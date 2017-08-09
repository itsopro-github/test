<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php echo $html->css(array('jquery-ui-1.7.2.custom')); ?>
<?php e($javascript->link('jquery-ui-1.7.2.custom.min')); ?>
<?php e($javascript->link('timepicker')); ?>
<script type="text/javascript">$(function(){$('#datetime').datepicker({duration:'',showTime:true,constrainInput:false,stepMinutes:1,stepHours:1,altTimeField:'',time24h:true});});</script>
<p></p>
<div class="block">
	<?php __($form->create('Order',array('id'=>'odrstatus','url'=>array('controller'=>'orders','action'=>'changestatus'))));?>
		<table border="0" cellspacing="0" cellpadding="0" class="tableview">
		<tr>
			<th width="20%"><?php __('Borrower'); ?></th>
			<td><?php __($order['Order']['first_name'].' '.$order['Order']['last_name']); ?></td>	
			<th width="20%"><?php __('File Number'); ?></th>
			<td><?php __($order['Order']['file']); ?></td>
		</tr>
		<tr>
			<th width="20%"><?php __('Date of Signing'); ?></th>
			<td><?php __($counter->formatdate('nsdate', $order['Order']['date_signing'])); ?></td>
			<th width="20%"><?php __('City, State'); ?></th>
			<td><?php __($order['Order']['sa_city'].', '.$order['Order']['sa_state']); ?></td>
		</tr>
		<tr>
			<th width="20%"><?php __('Zip Code'); ?></th>
			<td colspan="3"><?php __($order['Order']['sa_zipcode']); ?></td>
		</tr>
		<tr>
			<th width="40%">Change Status<span class="mandatory">*</span></th>
			<td colspan="3"><?php __($form->input('orderstatus_id',array('error'=>false,'label'=>false,'id'=>'SigningAddress','options'=>$Orderstatus, 'class'=>'select_box'))); ?></td>						
		</tr>
		<tr>
			<th width="40%">Notes</th>
			<td colspan="3"><?php __($form->input('Order.notes',array('cols'=>'76','rows'=>'5','error'=>false,'label'=>false,'id'=>'SigningAddress','class'=>'text_area'))); ?></td>						
		</tr>
		<tr>
			<th width="40%">Appointment date and time<span class="mandatory">*</span></th>
			<td colspan="3"><?php __($form->input('Order.appointment_time',array('id'=>'datetime','label'=>false,'class'=>'text_box','type'=>'text','readonly'=>true)));?></td>						
		</tr>
		<tr>
			<td  colspan="4" align="center">
			<input type="hidden"  name="data[Order][order_id]" value="<?php echo $Orderid;?>" />
<?php 	
	__($form->submit('Submit',array('div'=>false,'class'=>'submitbtn fleft','onclick'=>'return confirm("Are you sure you want to change the status?")' )));
	__($html->link(__('Cancel', true), array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($order['Order']['first_name'].' '.$order['Order']['last_name']),'id'=>$Orderid), array('class'=>'cancel','title'=>'Cancel','alt'=>'Cancel')));
?>
			</td>
		</tr>
	</table>
<?php
	__($form->end());
?>
</div>