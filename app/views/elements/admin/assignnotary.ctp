<div class="mainBox subBoxborder" style="width:98%;">
	<div class="header"><h3>Assign Notary</h3></div>
	<div class="content">
<?php
	$admin_data = $this->Session->read('WBSWAdmin');
	$admin_id = $admin_data['Admin']['id'];
	if($assign){
		$cntNot = 1;
?>
		<div id="viewassign">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablelist">
			<thead>
				<th width="5%">No</th>
				<th width="15%">Name</th>
				<th width="15%">Email</th>
				<th width="10%">Phone</th>
				<th width="5%">Fees</th>
				<th width="15%">Assigned Date</th>
				<th width="40%" colspan="2">Details</th>		
			</thead>
<?php
			foreach ($assign as $aval){
?>
			<tr>
				<td><?php __($cntNot); ?></td>
				<td><?php echo $html->link(__($aval['User']['Notary']['first_name']." ".$aval['User']['Notary']['last_name'], true), array('controller'=>'users','action'=>'view','type'=>'notaries','id'=>$aval['User']['id']), array('title'=>'View','alt'=>'View'));?></td>
				<td><?php echo $aval['User']['Notary']['email']; ?></td>
				<td><?php __($counter->tousphone($aval['User']['Notary']['cell_phone'])); ?></td>
				<td><?php echo Configure::read('currency').$aval['User']['Notary']['fees']; ?></td>
				<td><?php echo $counter->formatdate('nsdate',$aval['Assignment']['created']); ?></td>
				<td><?php echo nl2br($aval['Assignment']['details']); ?></td>
				
				<td>
<?php
				if($admin_id==$order['Order']['attended_by'] && $order['Orderstatus']['id']<>1){ 
					echo $form->submit('Change Notary', array('div'=>false,'class'=>'normalbutton_big fright','onclick'=>"showNotary();"));
				}
?>
				</td>
			</tr>
<?php
				$cntNot++;
			}
?>
		</table>
		</div>
<?php
	}
	if($notaries and ($order['Orderstatus']['id']==1) and ($order['Order']['attended_by']=='0')){
		__($this->element('nobox', array('displaytext'=>'Please select the ACCEPT tab above to ASSIGN order')));
	}
	else if($notaries and ($order['Orderstatus']['id']==1) and ($order['Order']['attended_by']!='0') and ($admin_id!=$order['Order']['attended_by'])){
		__($this->element('nobox', array('displaytext'=>'You do not have permission to assign')));
	}else{
	if($notaries and ($order['Orderstatus']['id']==1) and ($admin_id==$order['Order']['attended_by'])){
		
		$cntNot = 1;
?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablelist">
			<thead>
				<th>No</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Fees</th>
<?php if($order['Orderstatus']['id']==1) { ?>				
				<th colspan="2">Details</th>
<?php } ?>				
			</thead>
<?php 
		foreach ($notaries as $notary){
?>				
<?php __($form->create('Assignment',array('action'=>'add'))); ?>
			<tr> 
				<td><?php __($cntNot); ?></td>
				<td>
<?php 
					echo $html->link(__($notary['Notary']['first_name']." ".$notary['Notary']['last_name'], true), array('controller'=>'users','action'=>'view','type'=>'notaries','id'=>$notary['Notary']['user_id']), array('title'=>'View','alt'=>'View'));
					if($order['Orderstatus']['id']==1) { 					
						echo $form->hidden('client_id', array('value'=>$order['Order']['user_id']));
						echo $form->hidden('user_id', array('value'=>$notary['Notary']['user_id']));
						echo $form->hidden('order_id', array('value'=>$order['Order']['id']));
						echo $form->hidden('fee', array('value'=>$notary['Notary']['fees']));
						echo $form->hidden('notified', array('value'=>'0'));
					}
?>
				</td>
				<td><?php echo $notary['Notary']['email']; ?></td>
				<td><?php __($counter->tousphone($notary['Notary']['cell_phone'])); ?></td>
				<td><?php echo $notary['Notary']['fees']; ?></td>
<?php if($order['Orderstatus']['id']==1) { ?>		
				<td><?php echo $form->textarea('details', array('cols'=>35,'style'=>'height:50px;')); ?>
				<td><?php echo $form->submit('Assign', array('div'=>false,'class'=>'normalbutton fright','onclick'=>"return confirm('Are you sure you want to assign the order to ".$notary['Notary']['first_name']."?',true)")); ?></td>
<?php } ?>				
			</tr>
<?php echo $form->end(); ?>
<?php 	
			$cntNot++;
		} 
?>
	</table>
<?php
	}
	}
	
	$cntNot=1;?>	<div id="reassign" style="display:none;">
	
	<?php 
	
	if($notaries and ($admin_id==$order['Order']['attended_by'])){
	 ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablelist">
			<thead>
				<th>No</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Fees</th>
				<th colspan="2">Details</th>
			</thead>
<?php 
		foreach ($notaries as $notary){
?>				
<?php __($form->create('Assignment',array('action'=>'add'))); ?>
			<tr> 
				<td><?php __($cntNot); ?></td>
				<td>
<?php 
					echo $html->link(__($notary['Notary']['first_name']." ".$notary['Notary']['last_name'], true), array('controller'=>'users','action'=>'view','type'=>'notaries','id'=>$notary['Notary']['user_id']), array('title'=>'View','alt'=>'View'));
					echo $form->hidden('client_id', array('value'=>$order['Order']['user_id']));
					echo $form->hidden('user_id', array('value'=>$notary['Notary']['user_id']));
					echo $form->hidden('order_id', array('value'=>$order['Order']['id']));
					echo $form->hidden('fee', array('value'=>$notary['Notary']['fees']));
					echo $form->hidden('notified', array('value'=>'0'));
?>
				</td>
				<td><?php echo $notary['Notary']['email']; ?></td>
				<td><?php __($counter->tousphone($notary['Notary']['cell_phone'])); ?></td>
				<td><?php  __(Configure::read('currency').$notary['Notary']['fees']); ?></td>
				<td><?php echo $form->textarea('details', array('cols'=>35,'style'=>'height:50px;')); ?>
				<td><?php echo $form->submit('Reassign', array('div'=>false,'class'=>'normalbutton fright','onclick'=>"return confirm('Are you sure you want to assign the order to ".$notary['Notary']['first_name']."',true)")); ?></td>
			</tr>
<?php echo $form->end(); ?>
<?php 	
			$cntNot++;
		} 
?>
		</table>
<?php
	} else{
		__($this->element('nobox', array('displaytext'=>'No notaries found to reassign, matching the conditions ')));
	}
?>
	</div>
	
<?php	if(empty($assign) and empty($notaries)){
		__($this->element('nobox', array('displaytext'=>'No notaries found matching the conditions')));
	}
?>
	</div>
</div>
<script>function showNotary(){document.getElementById('reassign').style.display = "block";document.getElementById('viewassign').style.display = "none";}</script>