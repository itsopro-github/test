<?php
$paginator->options(array('url'=>array_merge(array('top'=>@$this->params['top'],'medium'=>@$this->params['medium'],'low'=>@$this->params['low']),$this->passedArgs)));

if(isset($this->params['top'])!='') {
	$html->addCrumb("Orders", array('controller'=>'orders','action'=>'index'));
	$html->addCrumb("15 Min Left", array());
	$ordertype = "15 Minutes Left";
} elseif(isset($this->params['medium'])!='') {
	$html->addCrumb("Orders", array('controller'=>'orders','action'=>'index'));
	$html->addCrumb("30 Min Left", array());
	$ordertype = "30 Minutes Left";
} elseif(isset($this->params['low'])!='') {
	$html->addCrumb("Orders", array('controller'=>'orders','action'=>'index'));
	$html->addCrumb("30 Min Left", array());
	$ordertype = "45 Minutes Left";
} else {
 	if(isset($arch_flag) && $arch_flag==0){
		$html->addCrumb("Orders", array());
 	} else {
		$html->addCrumb("Archived Signings", array());
 	}
	$ordertype = "";
}
?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header">
			<h1 class="fleft">
			<?php
			if(isset($arch_flag) && $arch_flag==0) {
				__('Requests '.$ordertype);
			} else {
				__('Archived Signings');
			}
			?>
			</h1>
			<ul>			
		       	<li><?php __($html->link('search','#',array('onclick'=>"loadSearchBox('search');")));?></li>
		      <?php if(isset($arch_flag) && $arch_flag==0){?>
		       	<li><?php if(isset($this->params['top'])=='') { __($html->link('15 Min Left',array('action'=>'index','top'=>'top','s:n'))); } else { __($html->link('List Orders',array('action'=>'index','s:n'))); } ?></li>
		       	<li><?php if(isset($this->params['medium'])=='') { __($html->link('30 Min Left',array('action'=>'index','medium'=>'medium','s:n'))); } else { __($html->link('List Orders',array('action'=>'index','s:n'))); } ?></li>
		       	<li><?php if(isset($this->params['low'])=='') { __($html->link('45 Min Left',array('action'=>'index','low'=>'low','s:n'))); } else { __($html->link('List Orders',array('action'=>'index','s:n'))); } ?></li>
		       	<li><?php __($html->link(__('Add Notary Request', true), array('controller'=>'orders','action'=>'add'))); ?></li>
		       	<?php } ?>
	       </ul>
       	</div>	
		<div id="searchdiv" <?php __((@$_SESSION['search']['params']=='') ? 'style="display:none;"' : 'style="display:block;"');?>>
		<?php if(isset($arch_flag) && $arch_flag==0){?>
			<?php echo $form->create('Orders', array('action' =>'search','url'=>array('all'=>@$this->params['all'],'top'=>@$this->params['top'],'medium'=>@$this->params['medium'],'low'=>@$this->params['low'],'status'=>'')));?>
			<?php } else{?>
			<?php echo $form->create('Orders', array('action' =>'search','url'=>array('all'=>@$this->params['all'],'top'=>@$this->params['top'],'medium'=>@$this->params['medium'],'low'=>@$this->params['low'],'status'=>'archived')));?>
			<?php }?>
				<table border="0" cellspacing="0" cellpadding="0" class="search_box">
					<tr> 
						<td>Borrower First Name</td>
						<td><?php echo $form->input('name', array('class'=>'text small','maxlength'=>'50','error'=>false,'label'=>false,'div'=>false,'value'=>@$_SESSION['search']['params']['name']));?></td>
						<td>Borrower Last Name</td>
						<td><?php echo $form->input('lname', array('class'=>'text small','maxlength'=>'50','error'=>false,'label'=>false,'div'=>false,'value'=>@$_SESSION['search']['params']['lname']));?></td>
						<td>City</td>
						<td><?php echo $form->input('sa_city', array('class'=>'text small', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['sa_city']));?></td>
						<td>State</td>
						<td><?php echo $form->input('sa_state', array('class'=>'select_box', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['sa_state'],'options'=>$states,'empty'=>'All'));?></td>
						<td >File No:</td>
						<td><?php echo $form->input('file', array('class'=>'text small', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['file']));?></td>
					</tr>
					<tr>
						<td>Company</td>
						<td><?php echo $form->input('company', array('class'=>'text small', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['company']));?></td>
						<td>Zip Code</td>
						<td><?php echo $form->input('sa_zipcode', array('class'=>'text small', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['sa_zipcode']));?></td>
						<td>Status</td>
						<td width="15%"><?php echo $form->input('orderstatus_id', array('class'=>'select_box', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['orderstatus_id'],'empty'=>'All'));?></td>
						<td>Ownership</td>
						<td width="18%"><?php __($form->input('attended_by',array('error'=>false,'label'=>false,'id'=>'AttendedBy','class'=>'select_box','options'=>$adminList,'empty'=>'Select'))); ?></td>
						<td colspan="2"></td>
					</tr>
					<tr>
						<td colspan="10" align="center"><?php echo $form->submit('Search', array('div' => false,'class'=>'submit small fleft'));echo $html->link('Clear', array('action'=>'clear'), array('div'=>false,'class'=>'normalbutton fleft'),null,false);?></td>
					</tr>
				</table>
			<?php echo $form->end(); ?>
		</div>
<?php if(isset($arch_flag) && $arch_flag==0){ ?>
		<?php __($this->element('admin/listorders', array('ordertitle'=>'New Requests','ordersubtitle'=>'New Notary Requests. Must ASSIGN Notary ASAP.','statusid'=>'1','classappend'=>'new_requests_data','classappendhead'=>'new_requests_head'))); ?>
		<?php __($this->element('admin/listorders', array('ordertitle'=>'Assigned Requests','ordersubtitle'=>' Notary ASSIGNED. Notary Must Contact Borrower ASAP.','statusid'=>'2','classappend'=>'assigned_data','classappendhead'=>'assigned_head'))); ?>
		<?php __($this->element('admin/listorders', array('ordertitle'=>'Unscheduled','ordersubtitle'=>'Appt Has Not Been Confirmed. See History for Details.','statusid'=>'3','classappend'=>'unscheduled_data','classappendhead'=>'unscheduled_head'))); ?>
		<?php __($this->element('admin/listorders', array('ordertitle'=>'Scheduled','ordersubtitle'=>'Appt has Been Confirmed.','statusid'=>'4','classappend'=>'scheduled_data','classappendhead'=>'scheduled_head'))); ?>
		<?php __($this->element('admin/listorders', array('ordertitle'=>'No Sign','ordersubtitle'=>'The Borrower Refused to Sign at the Signing Table.','statusid'=>'5','classappend'=>'no_sign_data','classappendhead'=>'no_sign_head'))); ?>
		<?php __($this->element('admin/listorders', array('ordertitle'=>'Completed Signings','ordersubtitle'=>'File Has Been Signed And Notarized. Obtaining Tracking # is a Priority.','statusid'=>'7','classappend'=>'completed_data','classappendhead'=>'completed_head'))); ?>
<?php } else { ?>
		<?php __($this->element('admin/listorders', array('ordertitle'=>'Pending signings','statusid'=>'6','classappend'=>substr(Inflector::slug(low(crypt('PENDING', Configure::read('Security.salt'))), ''),0,4),'classappendhead'=>''))); ?>
		<?php __($this->element('admin/listorders', array('ordertitle'=>'Closed signings','statusid'=>'9','classappend'=>substr(Inflector::slug(low(crypt('CLOSED', Configure::read('Security.salt'))), ''),0,4),'classappendhead'=>''))); ?>
		<?php __($this->element('admin/listorders', array('ordertitle'=>'Canceled signings','statusid'=>'10','classappend'=>substr(Inflector::slug(low(crypt('CANCELED', Configure::read('Security.salt'))), ''),0,4),'classappendhead'=>''))); ?>
<?php } ?>
	</div>
</div>
