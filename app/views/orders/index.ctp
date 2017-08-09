<div class="orders index">
	<div>
		<?php __($html->clean(nl2br($contentpage['Contentpage']['content']))); ?>
	</div>
	<div class="block">
		<div class="no_sign_head ordertitle" style="padding-left:5px;"><h2><?php echo "Search"; ?><span style="font-size:11px;padding-left: 8px;color:#000000;">Enter info in corresponding field below to find the specific file you are trying to locate.</span></h2></div>
		<?php echo $form->create('Orders', array('action'=>'search'));?>
			<table border="0" cellspacing="0" cellpadding="0" class="tablelistnw">
				<tr class="no_sign_data">
					<td width="20%">Borrower First Name</td>
					<td><?php echo $form->input('firstname', array('class'=>'text_box','maxlength'=>'50','error'=>false,'label'=>false,'div'=>false,'value'=>@$_SESSION['search']['params']['firstname']));?></td>
					<td width="20%">Borrower Last Name</td>
					<td><?php echo $form->input('lastname', array('class'=>'text_box','maxlength'=>'50','error'=>false,'label'=>false,'div'=>false,'value'=>@$_SESSION['search']['params']['lastname']));?></td>
				</tr>
				<tr class="no_sign_data">
					<td width="20%">City</td>
					<td width="30%"><?php echo $form->input('sa_city', array('class'=>'text_box', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['sa_city']));?></td>
					<td width="20%">State</td>
					<td width="30%"><?php echo $form->input('sa_state', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['sa_state'],'options'=>$states,'empty'=>'All'));?></td>
				</tr>
				<tr class="no_sign_data">
					<td width="20%" >File Number</td>
					<td><?php echo $form->input('file', array('class'=>'text_box', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['file']));?></td>
					<td width="20%">Status</td>
					<td><?php echo $form->input('orderstatuses', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['orderstatuses'],'empty'=>'All'));?></td>
				</tr>
				<tr class="no_sign_data">
<?php if($usersession['User']['type']=='C') { ?>
					<td width="20%">Notary</td>
					<td colspan="3"><?php echo $form->input('user_id', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false,'value'=>@$_SESSION['search']['params']['user_id'],'options'=>$notList,'empty'=>'--Select--')); ?></td>
<?php }?>					
				</tr>
				<tr class="no_sign_data">
					<td colspan="4"><?php __($form->submit('Search',array('div'=>false,'class'=>'submitbtn fleft')));echo $html->link('Clear', array('action'=>'clear'), array('div'=>false,'class'=>'normalbutton fleft'),null,false);?></td>
				</tr>
			</table>
		<?php echo $form->end(); ?>
	</div>
	<div class="block">
<?php 
	if($usersession['User']['type']=='C') {
		__($this->element('listorders', array('ordertitle'=>'new requests', 'ordersubtitle'=>'Notary Request placed. Notary is being located.','desc'=>'Notary Request placed. Notary is being located.','statusid'=>array('1'),'classappend'=>'new_requests_data','classappendhead'=>'new_requests_head')));
	}
	if($usersession['User']['type']=='C') {
		__($this->element('listorders', array('ordertitle'=>'Assigned', 'ordersubtitle'=>'Notary Assigned To Request. Notary Will Contact Borrower ASAP.','desc'=>'Notary assigned to request. Notary will contact borrower.','statusid'=>array('2'),'classappend'=>'assigned_data','classappendhead'=>'assigned_head')));
	}
	if($usersession['User']['type']=='N') {
		__($this->element('listorders', array('ordertitle'=>'new Assignments', 'ordersubtitle'=>'Please contact the borrower ASAP to schedule. Details in file.','desc'=>'Notary assigned to request. Notary will contact borrower.','statusid'=>array('2'),'classappend'=>'assigned_data','classappendhead'=>'assigned_head'))); 
	}
	__($this->element('listorders', array('ordertitle'=>'unscheduled', 'ordersubtitle'=>'Appointment Time Is Not Yet Confirmed. See History for details.','desc'=>'Appointment time is not yet confirmed.','statusid'=>array('3'),'classappend'=>'unscheduled_data','classappendhead'=>'unscheduled_head')));
	__($this->element('listorders', array('ordertitle'=>'scheduled', 'ordersubtitle'=>'Appointment Time is Confirmed. Please See Corresponding Appointment Time Below.','desc'=>'Appointment time is confirmed.','statusid'=>array('4'),'classappend'=>'scheduled_data','classappendhead'=>'scheduled_head')));
	__($this->element('listorders', array('ordertitle'=>'no sign', 'ordersubtitle'=>'Borrower Did Not Sign Documents At The Signing Table.','desc'=>'Borrower did not sign documents at the signing table.','statusid'=>array('5'),'classappend'=>'no_sign_data','classappendhead'=>'no_sign_head')));
	//__($this->element('listorders', array('ordertitle'=>'completed Signings', 'ordersubtitle'=>'File Has Been Signed And Notarized. Tracking # will be provided shortly ','desc'=>'File has been signed and notarized. Tracking # will be provided shortly ','statusid'=>array('7'),'classappend'=>'completed_data','classappendhead'=>'completed_head')));
	if($usersession['User']['type']=='C') {
		__($this->element('listorders', array('ordertitle'=>'completed Signings', 'ordersubtitle'=>'File Has Been Signed And Notarized. Tracking # will be provided shortly ','desc'=>'File has been signed and notarized. Tracking # will be provided shortly ','statusid'=>array('7'),'classappend'=>'completed_data','classappendhead'=>'completed_head')));
	}
	if($usersession['User']['type']=='N') {
		__($this->element('listorders', array('ordertitle'=>'completed Signings', 'ordersubtitle'=>'File Has Been Signed And Notarized. Please add tracking # below ','desc'=>'File has been signed and notarized. Please add tracking # below ','statusid'=>array('7'),'classappend'=>'completed_data','classappendhead'=>'completed_head')));
	}
?>
	</div>
</div>