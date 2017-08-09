<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php echo $html->css(array('jquery-ui-1.7.2.custom')); ?>
<?php e($javascript->link('jquery-ui-1.7.2.custom.min')); ?>
<?php e($javascript->link('timepicker')); ?>
<script type="text/javascript">$(function(){$('#AppointmentTime').timepicker({ampm:true});});</script>
<div class="mainBox subBoxborder" style="width:98%;">
	<div class="header"><h3>Approve Status</h3></div>
	<div class="content">
<?php 
	__($form->create('Signinghistory',array('id'=>'odrstatus','url'=>array('controller'=>'signinghistories','action'=>'edit')))); 
	__($form->input('Signinghistory.order_id',array('type'=>'hidden','value'=>$order['Order']['id'])));?>
	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<th width="20%">Status<span class="mandatory">*</span></th>
			<td><div class="input select required"><?php __($form->input('Signinghistory.orderstatus_id',array('error'=>false,'label'=>false,'div'=>false,'id'=>'OrderStatus','onchange'=>'showAppttime()','options'=>$Orderstatus, 'class'=>'select_box'))); ?></div></td>
			
		<td>
			<div id="ApptTime" style="display:none">	
				<p class="fleft"><label class="form_label">Appointment Time<span class="mandatory">*</span></label></p>
<?php
			$start = strtotime('12:00am');
			$end = strtotime('11:30pm');
			$crntapttime = (isset($crntapttime)=='') ? '8:00 am' : $crntapttime;
			echo '<select name="data[Signinghistory][appointment_time]" id="AppointmentTime" class="select_box">';
			for ($i = $start; $i <= $end; $i += 1800) {
				if(date('g:i a', $i) != $crntapttime) {
					echo '<option value="'.date('g:i a', $i).'">'.date('g:i a', $i).'</option>';
				} else {
					echo '<option value="'.date('g:i a', $i).'" selected="selected">'.$crntapttime.'</option>';
				}
			}
			echo '</select>';
?>
			</div>
				</td>
				</tr>
				<tr>
					<th width="20%">Notes</th>
					<td colspan="3"><div class="input textarea"><?php __($form->input('Signinghistory.notes',array('cols'=>'109','rows'=>'5','error'=>false,'label'=>false,'div'=>false,'id'=>'Notes','class'=>'text_area'))); ?></div></td>
				</tr>
				<tr>
					<td colspan="4" align="center"><?php __($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft'))); ?><?php __($html->link('Cancel','#',array('onclick'=>"loadBlock('statusdiv');",'class'=>'normalbutton fleft'))); ?></td>
				</tr>
			</table>
<?php
			__($form->end());
?>			
	</div>
</div>
<script>function showAppttime(){if(document.getElementById('OrderStatus').value =='4'){document.getElementById('ApptTime').style.display="block";}else{document.getElementById('ApptTime').style.display="none";document.getElementById('AppointmentTime').value =' ';}}</script>