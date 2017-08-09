<?php
if($order['Order']['shipping_info']=='F') {
	$tracking = '<a href="'.Configure::read('fedextracking').$order['Order']['tracking'].'" target="_blank">'. $order['Order']['tracking'] .'</a>';
} elseif($order['Order']['shipping_info']=='U') {
	$tracking =	'<a href="'.Configure::read('upstracking').$order['Order']['tracking'].'" target="_blank">'.$order['Order']['tracking'].'</a>';
} elseif($order['Order']['shipping_info']=='D') {
	$tracking =	'<a href="'.Configure::read('dhltracking').'"  target="_blank">'. $order['Order']['tracking'] .'</a>';
} elseif($order['Order']['shipping_info']=='G') {
	$tracking =	'<a href="'.Configure::read('gsotracking').'"  target="_blank">'.$order['Order']['tracking'] .'</a>';
} elseif($order['Order']['shipping_info']=='E') {
	$tracking =	'<a href="'.Configure::read('overniteexpress').'"  target="_blank">'. $order['Order']['tracking'] .'</a>';
} else {
	$tracking =	$order['Order']['tracking'];
}
if($order['Order']['track_shipping_info']=='F') {
	$trackingno = '<a href="'.Configure::read('fedextracking').$order['Order']['tracking_no'].'" target="_blank">'. $order['Order']['tracking_no'] .'</a>';
} elseif($order['Order']['track_shipping_info']=='U') {
	$trackingno = '<a href="'.Configure::read('upstracking').$order['Order']['tracking_no'].'"  target="_blank">'. $order['Order']['tracking_no'] .'</a>';
} elseif($order['Order']['track_shipping_info']=='D') {
	$trackingno = '<a href="'.Configure::read('dhltracking').'"  target="_blank">'.$order['Order']['tracking_no'] .'</a>';
} elseif($order['Order']['track_shipping_info']=='G') {
	$trackingno = '<a href="'.Configure::read('gsotracking').'"  target="_blank">'.$order['Order']['tracking_no'] .'</a>';
} elseif($order['Order']['track_shipping_info']=='E') {
	$trackingno = '<a href="'.Configure::read('overniteexpress').'"  target="_blank">'. $order['Order']['tracking_no'] .'</a>';
} else {
	$trackingno = $order['Order']['tracking_no'];
}

$admin_data = $this->Session->read('WBSWAdmin');
$admin_id = $admin_data['Admin']['id'];

if(!isset($style1)){
	$style1="display:none";
}
$html->addCrumb("Orders", array('controller' => 'orders','action'=>'index')); 
$html->addCrumb($order['Order']['first_name'], array());
?> 
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php echo $statList[$order['Order']['orderstatus_id']]." : ".$order['Order']['first_name'].' '.$order['Order']['last_name'];?></h1></div>	
		<div class="header1">
			<ul>
				<?php if($order['Order']['attended_by']=="0" or ($admin_id==$order['Order']['attended_by']) or ($admindata['Admin']['type']!='E')){?>
				<li><?php __($html->link(__('Edit', true), array('controller'=>'orders','action'=>'edit',$order['Order']['id']),array('alt'=>'EDIT DETAILS OF ORDER','title'=>'EDIT DETAILS OF ORDER'))); ?></li>
				<? }?>
				<li><?php __($html->link('Update Status', '#',array('onclick'=>"loadBlock('statusdiv');",'alt'=>'UPDATE STATUS OF ORDER','title'=>'UPDATE STATUS OF ORDER'))); ?></li>
				<li><?php __($html->link('Status History', '#history',array('onclick'=>"loadBlock('history');",'alt'=>'HISTORY OF CHANGES IN STATUS','title'=>'HISTORY OF CHANGES IN STATUS'))); ?></li>
				<li><?php __($html->link('Notary Details', '#',array('onclick'=>"loadBlock('searchdiv');",'alt'=>'NOTARY INFO and CHANGE NOTARY','title'=>'NOTARY INFO and CHANGE NOTARY'))); ?></li>
				<?php if($order['Order']['orderstatus_id']>=2 || !empty($nfee)){?>
				<li><?php __($html->link('Notary Fees', '#',array('onclick'=>"loadBlock('nfeediv');",'alt'=>' VIEW and EDIT NOTARY FEE','title'=>' VIEW and EDIT NOTARY FEE'))); ?></li>
				<?php } if(($order['Order']['attended_by']=='0') or (($order['Order']['attended_by']!='0') and (!empty($cfee))) or ($admin_id==$order['Order']['attended_by'])){?>
				<li><?php __($html->link('Client Fees', '#',array('onclick'=>"loadBlock('cfeediv');",'alt'=>'VIEW and EDIT CLIENT FEE','title'=>' VIEW and EDIT CLIENT FEE'))); ?></li>
				<? }?>
				<li><?php __($html->link('Print','#',array('onclick'=>"javascript:window.print();",'alt'=>'PRINT INFO CURRENTLY ON SCREEN','title'=>'PRINT INFO CURRENTLY ON SCREEN'))); ?></li>
				<li>
					<?php if($order['Order']['attended_by']=="0"){?>
					<?php __($html->link(__('Accept to Update', true), array('controller'=>'orders','action'=>'accept_ownership',$order['Order']['id']),array('alt'=>'ACCEPT TO CHANGE NOTARY,UPDATE STATUS or ADD NOTES','title'=>'ACCEPT TO CHANGE NOTARY,UPDATE STATUS or ADD NOTES'))); ?></li>
					<?php }if($admin_id==$order['Order']['attended_by']){?>
					<?php __($html->link(__('Remove', true), array('controller'=>'orders','action'=>'reject_ownership',$order['Order']['id']),array('alt'=>'REMOVE OWNERSHIP','title'=>'REMOVE OWNERSHIP'))); ?>
				</li>	
				<?php } ?>
				<?php if($order['Order']['orderstatus_id']=='6' or $order['Order']['orderstatus_id']=='9' or $order['Order']['orderstatus_id']=='10'){ ?>
				<li><?php __($html->link(__('List archive', true), array('controller'=>'orders','action'=>'index','status'=>'archived','param'=>'s:n'),array('alt'=>'ARCHIVED ORDERS','title'=>'ARCHIVED ORDERS'))); ?></li>
				<?php }else{?>
				<?php }?>
				
				<li><?php __($html->link('Edoc Audit Trail', '#',array('onclick'=>"loadBlock('edoc-trail-div');",'alt'=>'e-Doc Audit Trail','title'=>'e-Doc Audit Trail'))); ?></li>
				<li><?php __($html->link(__('Back to All Orders', true), array('controller'=>'orders','action'=>'index'),array('alt'=>'Back to Orders Dashboard','title'=>'Back to Orders Dashboard'))); ?></li>
				
			</ul></div>
		<div id="searchdiv" style="display:none;">
			<?php __($this->element('admin/assignnotary')); ?>
		</div>
		<div id="edoc-trail-div" style="padding:10px;display:none;">
		
		<?php 
		
		   echo "<table>";	
		   
		  echo '<tr><td colspan="4" class="blockhead">eDoc Audit Trail</td></tr>';
		   echo "<tr>";
			echo "<th>Id</th>";
			echo "<th>User</th>";
			echo "<th>Document</th>";
			echo "<th>Document Type</th>";
			echo "<th>Action</th>";
			echo "<th>Date</th>";
		   echo "</tr>";

		foreach ($eDocs_audit_trail as &$trail) {

		   echo "<tr>";
			echo "<td>" . $trail["edocs_audit_trail"]["id"] . "</td>";
			echo "<td>" . $trail["edocs_audit_trail"]["client_name"] . " (id: " . $trail["edocs_audit_trail"]["client_user_id"]  .  ")" . "</td>";
			echo "<td>" . $trail["edocs_audit_trail"]["edoc_file_name"] . "</td>";
			echo "<td>" . ($trail["edocs_audit_trail"]["edoc_file_type"] == "C" ? "Escrow Docs" : ($trail["edocs_audit_trail"]["edoc_file_type"] == "M" ? "Misc" : "Loan Documents" )). "</td>";
			echo "<td>" . ($trail["edocs_audit_trail"]["action"] == "R" ? "Remove" : "Add") . "</td>";
			echo "<td>" . $trail["edocs_audit_trail"]["action_time"] . "</td>";
		   echo "</tr>";

		}
		   echo "</table>";


		?>
		
		</div>
       	<div id="statusdiv" <?php __((isset($assigned) and $assigned == 'track') ? 'style="display:block;"' : 'style="display:none;"');?>>
			<?php __($this->element('admin/changestatus')); ?>
		</div>
       	<div id="history" <?php if(isset($this->params['pass'][2])!='history') { ?>style="display:none;" <?php } ?>>
			<?php __($this->element('admin/statushistory')); ?>
		</div>
		<div id="nfeediv" <?php __((isset($assigned) and $assigned == 'yes') ? 'style="display:block;"' : 'style="display:none;"');?>>
			<?php __($this->element('admin/notary_fee')); ?>
		</div>
		<div id="cfeediv" style="display:none;">
			<?php __($this->element('admin/client_fee')); ?>
		</div>
       	<div class="block_content">
	       	<table cellpadding="1" cellspacing="1" class="tableview">
				<tr><td colspan="4" class="blockhead">Borrower Details</td></tr>
	       		<tr>
					<th width="25%"><?php __('Borrower'); ?></th>
					<td width="25%"><?php __($order['Order']['first_name'].' '.$order['Order']['last_name']); ?></td>	
					<th width="25%"><?php __('Email address'); ?></th>
					<td width="25%"><?php __($order['Order']['email']); ?></td>
				</tr>
				<tr>
					<th><?php __('Home phone'); ?></th>
					<td><?php __($counter->tousphone($order['Order']['home_phone'])); ?></td>
					<th><?php __('Cell phone'); ?></th>
					<td><?php __($counter->tousphone($order['Order']['cell_phone'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Work phone'); ?></th>
					<td><?php __($counter->tousphone($order['Order']['work_phone'])); ?></td>	
					<th><?php __('Alternative phone'); ?></th>
					<td><?php __($counter->tousphone($order['Order']['alternative_phone'])); ?></td>
				</tr>
				<tr>
					<th><?php __('File number'); ?></th>
					<td><?php __($order['Order']['file']); ?></td>
					<th><?php __('Date of signing'); ?></th>
					<td><?php __($counter->formatdate('nsdate',$order['Order']['date_signing'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Added by'); ?></th>
					<td ><?php if($order['Order']['addedby']=='0'){echo $clientdetails['Client']['first_name']." ".$clientdetails['Client']['last_name'];} else { echo $misc->getAdminName($order['Order']['addedby']); } ?></td>
					<?php if($order['Order']['attended_by']<>'0'){?>
					<th><?php __('Owned by'); ?></th>
					<td><?php __($misc->getAdminName($order['Order']['attended_by'])); ?></td>
					<?php }?>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr><td colspan="4" class="blockhead">Client Details</td></tr>
			    <tr>
					<th width="25%"><?php __('Company'); ?></th>
					<td width="25%"><?php __($clientdetails['Client']['company']); ?></td>	
					<th width="25%"><?php __('Name'); ?></th>
					<td width="25%"><?php __($clientdetails['Client']['first_name']." ".$clientdetails['Client']['last_name']); ?></td>
				</tr>
				<tr>
					<th><?php __('Email address'); ?></th>
					<td><?php __($clientdetails['Client']['email']); ?></td>
					<th><?php __('Work phone'); ?></th>
					<td><?php __($counter->tousphone($clientdetails['Client']['company_phone'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Company address'); ?></th>
					<td colspan="3"><?php echo $clientdetails['Client']['of_street_address'].", ".$clientdetails['Client']['of_city'].", ".$clientdetails['Client']['of_state'].", ".$clientdetails['Client']['of_zip']; ?></td>
				</tr>
				<tr>
					<th><?php __('Shipping Carrier'); ?></th>
					<td>
<?php
	if($clientdetails['Client']['shipping_carrier']=='O') { __($clientdetails['Client']['shipping_carrier_other']); } else {__($counter->shippingcarrier($clientdetails['Client']['shipping_carrier'])); } ?></td>
					<th><?php __('Shipping Account #'); ?></th>
					<td><?php __($counter->tousphone($clientdetails['Client']['shipping_account'])); ?></td>
				</tr>
				
				<tr>
					<td colspan="4"></td>
				</tr>
<?php if(!empty($assign)){ ?>
				<tr><td colspan="4"  class="blockhead">Notary Details</td></tr>
				<tr>
					<th><?php __('Name'); ?></th>
					<td><?php __($assign[0]['User']['Notary']['first_name']." ".$assign[0]['User']['Notary']['last_name']); ?></td>	
					<th><?php __('Email address'); ?></th>
					<td><?php __($assign[0]['User']['Notary']['email']); ?></td>
				</tr>
				<tr>
					<th><?php __('Contact'); ?></th>
					<td><?php __($counter->tousphone($assign[0]['User']['Notary']['cell_phone'])); ?></td>
					<th><?php __('Document delivery address'); ?></th>
					<td><?php echo $assign[0]['User']['Notary']['dd_address'].", ".$assign[0]['User']['Notary']['dd_city'].", ".$assign[0]['User']['Notary']['dd_state'].", ".$assign[0]['User']['Notary']['dd_zip'];?></td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
<?php }?>
				<tr><td colspan="4" class="blockhead">Client Requirements</td></tr>
				<tr>
					<th><?php __('Client Requirements'); ?></th>
					<td colspan="3" class="noborder">
<?php
					if(!empty($creqs)){
						foreach ($creqs as $key=>$creq):
							__(($key+1).'. '.$creq['ClientRequirements']['requirements'].'<br />');
						endforeach;
					}
?>				
					</td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr><td colspan="4" class="blockhead">Signing Instructions</td></tr>
				<tr>
					<th><?php __('Specific signing instructions'); ?></th>
					<td colspan="3"><?php __(nl2br($order['Order']['signing_instrn'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Additional notes'); ?></th>
					<td colspan="3"><?php __(nl2br($order['Order']['addtnl_notes'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Additional notification emails'); ?></th>
					<td colspan="3"><?php __(nl2br($order['Order']['addtnl_emails'])); ?></td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr><td colspan="4" class="blockhead">Signing Location</td></tr>
				<tr>
					<th><?php __('Signing street address'); ?></th>
					<td colspan="3" class="noborder"><?php __($order['Order']['sa_street_address']); ?>, <?php __($order['Order']['sa_city']); ?>, <?php __($order['Order']['sa_state']); ?>, <?php __($order['Order']['sa_zipcode']); ?></td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td colspan="4" class="blockhead">Property Address</td>
				</tr>
				<tr>
					<th><?php __('Property street address'); ?></th>
					<td colspan="3" class="noborder"><?php __($order['Order']['pa_street_address']); ?>, <?php __($order['Order']['pa_city']); ?>, <?php __($order['Order']['pa_state']); ?>, <?php __($order['Order']['pa_zipcode']); ?></td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr><td colspan="4" class="blockhead">Document Delivery Information</td></tr>
				<tr>
					<th><?php __('New request / re-sign'); ?></th>
					<td><?php __($docinfooptions[$order['Order']['doc_info']]); ?></td>
					<th><?php __('Type of loan documents'); ?></th>
					<td><?php __($doc_typesoptions[$order['Order']['doc_type']]); ?></td>
				</tr>
				<tr>
					<th><?php __('Delivery of docs'); ?></th>
					<td><?php __($doctypeoptions[$order['Order']['doc_submit']]); ?></td>
				</tr>
<?php
				if($order['Order']['doc_submit']=='E'){
					if(!empty($orderedocs)){
						foreach ($orderedocs as $key=>$orderedoc):
?>
				<tr>
					<th><?php __('E-Document '.++$key); ?></th>
					<td colspan="3"><?php if(isset($orderedoc['OrderEdocs']['edocfile']) && $orderedoc['OrderEdocs']['edocfile']<>""){?>
					<a href="<?php __(Configure::read('WEB_URL')); ?>files/edocs/<?php __($orderedoc['OrderEdocs']['edocfile']); ?>" target="_blank"><?php __($orderedoc['OrderEdocs']['edocfile']); ?></a><? }?>&nbsp;<?php if(isset($orderedoc['OrderEdocs']['ptype']) && $orderedoc['OrderEdocs']['ptype']<>""){?> [ <?php __($pdftypeoptions[$orderedoc['OrderEdocs']['ptype']]); ?> ]<? }?></td>
				</tr>
<?php 
						endforeach;
					}
				} else if($order['Order']['doc_submit']=='P'){
?>
				<tr>
					<th><?php __('Pick up address'); ?></th>
					<td colspan="3" class="noborder"><?php __($order['Order']['pickup_address']); ?>, <?php __($order['Order']['pickup_city']); ?>, <?php __($order['Order']['pickup_state']); ?>, <?php __($order['Order']['pickup_zip']); ?></td>
				</tr>
<?php 			
				} else { 
?>
				<tr>
					<th><?php __('Shipping info'); ?></th>
					<td><?php __($shipoptions[$order['Order']['shipping_info']]); ?></td>
				</tr>
<?php  
				} 
				if($tracking && $order['Order']['doc_submit']=='O') {
?>
				<tr>
					<th><?php __('Tracking #'); ?></th>
					<td><?php __($tracking)?></td>
				</tr>
<?php 
				}
				if($trackingno && $order['Order']['orderstatus_id']>='7'){
?>
				<tr>
					<th><?php __('Tracking # (after signing completed)'); ?></th>
					<td><?php __($trackingno)?></td>
				</tr>
<?php 
				}
?>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr>
					<th><?php __('Posted date'); ?></th>
					<td class="noborder"><?php __($counter->formatdate('nsdatetimemeridiem',$order['Order']['created'])); ?></td>
					<th><?php __('Status'); ?>  </th>
					<td class="noborder"><?php __($order['Orderstatus']['status']); ?></td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
			</table>
		</div>
<?php
		if($history) {
?>		
		<div class="mainBox subBoxborder fleft">
  			<div class="header"><h1>Ownership History of <?php __($order['Order']['first_name']); ?></h1>
  			</div>
  			<table cellpadding="0" cellspacing="0" class="tablelist">
				<thead>
					<th width="10%">Sl No</th>
					<th width="20%">Admin</th>
					<th width="35%">Rejected Date</th>
				</thead>
<?php
				$i = 0;
				foreach ($history as $ohistory):
				$class = null;
				if ($i++ % 2 == 0) { $class = ' class="altrow"'; }
?>
					<tr <?php echo $class;?>>
					<td><?php echo $counter->counters($i) ?></td>	
					<td><?php __($misc->getAdminName($ohistory['HistoryOwners']['admin_id'])); ?></td>
					<td><?php __($counter->formatdate('nsdatetimemeridiem', $ohistory['HistoryOwners']['created'])); ?></td>
				</tr>
			<?php endforeach; ?>
				</table>
  		</div>
<?php
		}
?>
	</div>
</div>
