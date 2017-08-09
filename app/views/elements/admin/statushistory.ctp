<div class="mainBox subBoxborder" style="width:98%;">
	<div class="header"><h3>Order History</h3></div>
	<div class="content">
<?php
	if($signinghistories) {
?>
	<table cellpadding="0" cellspacing="0" class="">			
		<thead>
			<th width="5%">No</th>
			<th width="9%">Appointment</th>
			<th width="50%">Notes</th>
			<th width="10%">Sender</th>
			<th width="17%">Created</th>
			<th width="4%">Status</th>
			<th width="5%">Action</th>
		</thead>
<?php
		$j = 0;
		foreach ($signinghistories as $signinghistory):
			$class = null;
			$assignee = "";
			if ($j++ % 2 == 0) {$class = ' class="altrow"';}
			if($signinghistory['Orderstatus']['status']=='ASSIGNED') {
				$currentassignee = $misc->getsender('NN', $signinghistory['Signinghistory']['id']);
				$assignee = ' [ <span style="color: #FC770A;">'.$currentassignee.'</span> ]';
			}
?>
		<tr <?php  __($class);?>>
			<td><?php __($counter->counters($j)); ?></td>
			<td><?php if($signinghistory['Orderstatus']['status']=="SCHEDULED" || $signinghistory['Orderstatus']['status']=="SIGNING COMPLETED"){ __($signinghistory['Signinghistory']['appointment_time']);} else { echo " "; } ?></td>
			<td><?php __($signinghistory['Orderstatus']['status'].$assignee.' : '.nl2br($signinghistory['Signinghistory']['notes'])); ?>
<?php
			if($signinghistory['Signinghistory']['orderstatus_id']>='7'){ 
				echo "<br />[ Tracking #: ".$misc->gettracking($signinghistory['Signinghistory']['order_id'], true)." ]";
			}
?>
			</td>
			<td><?php echo $misc->getsender($signinghistory['Signinghistory']['added_by'], $signinghistory['Signinghistory']['user_id']);?></td>
			<td><?php __($counter->formatdate('nsdatetimemeridiem',$signinghistory['Signinghistory']['created'])); ?></td>
			<td>
				<?php
				if ($signinghistory['Signinghistory']['added_by']=='N') { ?>
				<span class="<?php __(low($statusOptions[$signinghistory['Signinghistory']['status']])); ?>_btn" onclick="approvenotes('<?php __($signinghistory['Signinghistory']['id']);?>')" alt="Change Status" title="Change Status">Edit</span>
				<?php 
				} else { 
					echo $statusOptions[$signinghistory['Signinghistory']['status']];
				}
				?>
			</td>
			<td><?php echo $html->link(__('Delete', true), array('controller'=>'signinghistories','action' => 'delete', $signinghistory['Signinghistory']['id'],$signinghistory['Signinghistory']['order_id']), array('class'=>'delete_btn', 'title'=>'Delete', 'alt'=>'Delete'),sprintf('Are you sure you want to delete \''.$signinghistory['Signinghistory']['notes'].'\'?', $signinghistory['Signinghistory']['id'])); ?></td>
		</tr>
		<tr class="notr" id="notr<?php __($signinghistory['Signinghistory']['id']);?>"><td colspan="7"><div id=<?php __("changestatusdiv".$signinghistory['Signinghistory']['id']);?>></div></td></tr>	
<?php 
		endforeach;
		if($reactivateFees){
?>
		<tr>
			<td colspan="8" class="noborder">
				<table width="100%" border="0">
					<tr> 
				 		<td class="blockhd"><?php __("Notary Fee");?></td>
				 		<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td width="10%"><b><?php __('Basic fees');?></b></td>
						<td width="10%"><b><?php __('Second');?></b></td>
						<td width="10%"><b><?php __('Excess mileage');?></b></td>
						<td width="10%"><b><?php __('Edocs');?></b></td>
						<td width="10%"><b><?php __('Additional trip');?></b></td>
						<td width="10%"><b><?php __('No sign');?></b></td>
						<td width="20%"><b><?php __('Total fees');?></b></td>
						<td width="20%"><b><?php __('Notary');?></b></td>
					</tr>
<?php
				foreach ($reactivateFees as $rval):
?>
					<tr>
						<td><?php __(Configure::read('currency').$rval['reactivateFees']['notary_fee1']); ?></td>
						<td><?php __(Configure::read('currency').$rval['reactivateFees']['notary_fee3']); ?></td>
						<td><?php __(Configure::read('currency').$rval['reactivateFees']['notary_fee5']); ?></td>
						<td><?php __(Configure::read('currency').$rval['reactivateFees']['notary_fee2']); ?></td>
						<td><?php __(Configure::read('currency').$rval['reactivateFees']['notary_fee4']); ?></td>
						<td><?php __(Configure::read('currency').$rval['reactivateFees']['notary_fee6']); ?></td>
						<td><?php __(Configure::read('currency').($rval['reactivateFees']['notary_fee1']+$rval['reactivateFees']['notary_fee2']+$rval['reactivateFees']['notary_fee3']+$rval['reactivateFees']['notary_fee4']+$rval['reactivateFees']['notary_fee5']+$rval['reactivateFees']['notary_fee6'])); ?></td>
						<td><?php __($currentassignee); ?></td>
					</tr>
<?php
				endforeach;
?>
					<tr>
						<td class="blockhd"><?php __("Client Fee");?></td>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td width="10%"><b><?php __('Basic fees'); ?></b></td>
						<td width="10%"><b><?php __('Second'); ?></b></td>
						<td width="10%"><b><?php __('Excess mileage'); ?></b></td>
						<td width="10%"><b><?php __('Edocs'); ?></b></td>
						<td width="10%"><b><?php __('Additional trip'); ?></b></td>
						<td width="10%"><b><?php __('No sign'); ?></b></td>
						<td colspan="2" width="40%"><b><?php __('Total fees'); ?></b></td>
					</tr>
<?php
				foreach ($reactivateFees as $rval):
?>
					<tr>
						<td><?php __(Configure::read('currency').$rval['reactivateFees']['client_fee1']); ?></td>
						<td><?php __(Configure::read('currency').$rval['reactivateFees']['client_fee3']); ?></td>
						<td><?php __(Configure::read('currency').$rval['reactivateFees']['client_fee5']); ?></td>
						<td><?php __(Configure::read('currency').$rval['reactivateFees']['client_fee2']); ?></td>
						<td><?php __(Configure::read('currency').$rval['reactivateFees']['client_fee4']); ?></td>
						<td><?php __(Configure::read('currency').$rval['reactivateFees']['client_fee6']); ?></td>
						<td colspan="2"><?php __(Configure::read('currency').($rval['reactivateFees']['client_fee1']+$rval['reactivateFees']['client_fee2']+$rval['reactivateFees']['client_fee3']+$rval['reactivateFees']['client_fee4']+$rval['reactivateFees']['client_fee5']+$rval['reactivateFees']['client_fee6'])); ?></td>
					</tr>
<?php 
				endforeach;
?>
				</table>
			</td>
<?php
		}
?>
		</tr>
	</table>
<?php
	} else {
		__($this->element('nobox', array('displaytext'=>'No order history')));		
	}
	__($form->end()); 
?>
	</div>
</div>