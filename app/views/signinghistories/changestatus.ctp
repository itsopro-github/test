<div class="mainBox subBoxborder" style="width:98%;">
	<div class="header"><h3>Change Status</h3></div>
	<div class="content">
<?php 
		__($form->create('Signinghistory',array('id'=>'odrstatus', 'action'=>'changestatus')));
		__($form->input('Signinghistory.order_id',array('type'=>'hidden', 'value'=>$this->data['Order']['id'])));
		__($form->input('Signinghistory.id',array('type'=>'hidden', 'value'=>$this->data['Signinghistory']['id'])));
		__($form->input('Signinghistory.appointment_time',array('type'=>'hidden', 'value'=>$this->data['Signinghistory']['appointment_time'])));
		__($form->input('Signinghistory.appointment_date',array('type'=>'hidden', 'value'=>$counter->formatdate('nsdate', strtotime($this->data['Signinghistory']['created'])))));
		__($form->input('Signinghistory.orderstatus_id',array('type'=>'hidden', 'value'=>$this->data['Signinghistory']['orderstatus_id'])));
?>		
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
<?php
					if($this->data['Signinghistory']['appointment_time']) {
?>
						<th width="25%">Appointment</th>
						<td width="25%"><?php __($this->data['Signinghistory']['appointment_time']); ?></td>
<?php
					}
?>
					<th width="25%">Sender</th>
					<td width="25%"><?php __($misc->getUserName($this->data['Signinghistory']['user_id']));?></td>
				</tr>
				<tr>
					<th width="20%">Notes</th>
					<td colspan="3"><?php __($form->input('Signinghistory.notes',array('error'=>false,'label'=>false,'div'=>false,'id'=>'Notes','class'=>'text', 'rows'=>'2', 'cols'=>'107'))); ?></td>
				</tr>
				<tr>
					<th width="25%">Status</th>
					<td width="25%" class="noborder"><?php __($form->input('Signinghistory.status',array('error'=>false,'label'=>false,'div'=>false, 'id'=>'Status', 'options'=>$statusOptions, 'class'=>'select_box', 'onchange'=>'checkStatus();'))); ?></td>
					
					<th colspan="2" width="25%"><div id="sendmail" style="display:none">Send mail notification<?php __($form->checkbox('Signinghistory.mail',array('error'=>false,'label'=>false,'div'=>false))); ?></div></th>
				</tr>
				<tr>
					<td colspan="4" class="noborder"><hr /><?php __($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft'))); ?>
					<?php __($html->link('Cancel','#',array('onclick'=>"hidestatus('".$this->data['Signinghistory']['id']."');",'div'=>false,'class'=>'normalbutton fleft')));?></td>
				</tr>
			</table>
<?php
		__($form->end());
?>		
	</div>
</div>
<script>
function checkStatus() {if(document.getElementById('Status').value == 1) { $('#sendmail').css("display","block");} else {$('#sendmail').css("display","none");}}</script>