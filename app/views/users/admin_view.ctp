<?php $html->addCrumb(ucfirst($type), array('controller'=>'users','type'=>$type,'action'=>'index'));?>
<?php $html->addCrumb($user[$model]['first_name'].' '.$user[$model]['last_name']);?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header">
<?php 
		if($usertype=='clients') { 
?>
        <h1 class="fleft"><?php __($model.' Details');?> [ <?php echo $user[$model]['company'];?> ]</h1>
<?php 	} else { ?>
         <h1 class="fleft"><?php __($model.' Details');?> [ <?php echo $user[$model]['first_name'].' '.$user[$model]['last_name'];?> ]</h1>
<?php
		}
?>
			<ul>
		    	<li><?php echo $html->link(__('Back to '.$type.' List', true), array('controller'=>'users','action'=>'index','type'=>$usertype,'param'=>'s:n')); ?></li>
				<li><?php echo $html->link(__('Edit this '.$model, true), array('action'=>'edit','id'=>$user['User']['id'],'type'=>$usertype)); ?></li>
	       </ul>
       	</div>
		<div class="block_content fleft" style="width:64%;">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
<?php 
			if($usertype=='clients') { 
?>
		  		<tr>
			     	<th width="40%"><?php __('Company'); ?> </th> <td class="first_row"><?php echo $user[$model]['company']; ?> </td>
			  	</tr>
		 	 	<tr>
			     	<th><?php __('Division'); ?> </th> <td class="first_row"><?php echo $user[$model]['division']; ?> </td>
			  	</tr>
<?php
			}
?>
			  	<tr>
			     	<th width="40%"><?php __('First name'); ?> </th> <td class="first_row"><?php echo $user[$model]['first_name']; ?> </td>
			  	</tr>
			  	<tr>
			     	<th><?php __('Last name'); ?> </th> <td class="first_row"><?php echo $user[$model]['last_name']; ?> </td>
			  	</tr>
<?php 
			if($usertype=='clients') { 
?>
				 <tr>
					<th><?php __('Email address'); ?> </th> <td class="first_row"><?php echo $user[$model]['email']; ?> </td>
			  </tr>
			   <tr>
			     <th><?php __('Company phone'); ?> </th> <td class="first_row">
			    <?php echo  substr($user[$model]['company_phone'],0,3).'-'.substr($user[$model]['company_phone'],3,3).'-'.substr($user[$model]['company_phone'],6,4); ?> </td>
			    
			  </tr>
			  <tr>
			     <th><?php __('Company fax'); ?> </th> <td class="first_row"><?php __($counter->tousphone(@$user[$model]['company_fax'])); ?> </td>
			  </tr>
			     <tr>
			     <th><?php __('Shipping carrier'); ?> </th> <td class="first_row"><?php echo $clientscdata[$user[$model]['shipping_carrier']]; ?> </td>
			  </tr>
			  	<?php if($user[$model]['shipping_carrier']=="O" && $user[$model]['shipping_carrier_other']<>"") { ?>
			   <tr>
			     <th><?php __('Shipping carrier - other'); ?> </th> <td class="first_row"><?php echo $user[$model]['shipping_carrier_other']; ?> </td>
			  </tr>
			  <? }?>
			  <tr>
			     <th><?php __('Shipping account #'); ?> </th> <td class="first_row"><?php echo $user[$model]['shipping_account']; ?> </td>
			  </tr>
					<?php if($admindata['Admin']['type']!='E'){?>
					<tr>
					<th><?php __('Signing fees'); ?> </th> <td class="first_row"><?php __(Configure::read('currency')); ?><?php echo $user[$model]['fees']; ?> </td>
						
					</tr>
					<?php }?>	
					 <tr>
			     <th><?php __('How did you hear about us?'); ?> </th> <td class="first_row">
			     <?php echo $hearoptions[$user[$model]['how_hear']]; ?> </td>
			  </tr>
<?php 
 		if($user[$model]['how_hear']=='R' && $user[$model]['how_hear_ref']<>""){
?>
 			<tr>
		     	<th><?php __('Referred by'); ?></th>
		     	<td class="first_row"><?php echo $user[$model]['how_hear_ref']; ?></td>
		  	</tr>
<?php 
 		}
?>
					
			  <tr>
			     <th><?php __('Office address'); ?> </th> <td class="first_row"><?php echo $user[$model]['of_street_address'].", ".$user[$model]['of_city'].", ".$user[$model]['of_state'].", ".$user[$model]['of_zip'] ?> </td>
			  </tr>
			   <tr>
			     <th><?php __('Return document address'); ?> </th> <td class="first_row"><?php echo $user[$model]['rd_street_address'].", ".$user[$model]['rd_city'].", ".$user[$model]['rd_state'].", ".$user[$model]['rd_zip'] ?> </td>
			  </tr>
			  <tr>
					<th><?php __('Client requirements'); ?></th>
					<td>
 <?php
		  			if(!empty($creqs)){
						foreach ($creqs as $key=>$creq):
							__(($key+1).'. '.nl2br($creq['ClientRequirements']['requirements'])."<br><br>");
						endforeach;
					}
?>						
					</td>
				</tr>
<?php				
			}
?>
<?php if($usertype=='notaries'){ ?>
			 <tr>
			     <th><?php __('Email address'); ?> </th> <td class="first_row"><?php echo $user[$model]['email'] ?> </td>
			  </tr>	
			  <tr>
			     <th><?php __('Mobile Phone'); ?> </th> <td class="first_row">
			     <?php echo  substr($user[$model]['cell_phone'],0,3).'-'.substr($user[$model]['cell_phone'],3,3).'-'.substr($user[$model]['cell_phone'],6,4); ?>
			      </td>
			  </tr>
			  <tr>
			     <th><?php __('Home Phone'); ?> </th> <td class="first_row">
			       <?php echo  substr($user[$model]['day_phone'],0,3).'-'.substr($user[$model]['day_phone'],3,3).'-'.substr($user[$model]['day_phone'],6,4); ?>
			      </td>
			  </tr>
			  <tr>
			     <th><?php __('Office Phone'); ?> </th> <td class="first_row">
			      <?php echo  substr($user[$model]['evening_phone'],0,3).'-'.substr($user[$model]['evening_phone'],3,3).'-'.substr($user[$model]['evening_phone'],6,4); ?>
			     </td>
			  </tr>
			  <tr>
			     <th><?php __('Website'); ?> </th> <td class="first_row">
			      <?php echo  $user[$model]['website']; ?>
			     </td>
			  </tr>
			  
			  <tr>
			     <th><?php __('Document signing experience'); ?> </th> <td class="first_row">
			      <?php echo  $user[$model]['experience']; ?>
			     </td>
			  </tr>
				<tr>
			     <th> </th>
					<td><?php echo  $user[$model]['experience_other']; ?>  </td>
				</tr>
			   <tr>
			     <th><?php __('Languages'); ?> </th>
			     <td class="first_row"><?php echo str_replace("|",",",$user[$model]['languages']); ?></td>
			  	</tr>
				<tr>
			     <th> </th>
					<td><?php echo  $user[$model]['languages_other']; ?>  </td>
				</tr>
		    	<tr>
			     <th><?php __('Notes'); ?></th>
			     <td class="first_row"><?php echo nl2br($user[$model]['notes']); ?></td>
			  </tr>
				  <tr>
			     <th><?php __('Mailing Address'); ?> </th> <td class="first_row"><?php echo $user[$model]['dd_address'].", ".$user[$model]['dd_city'].", ".$user[$model]['dd_state'].", ".$user[$model]['dd_zip'] ?> </td>
			  </tr>
	

			  
			  <tr>
			     <th><?php __('What year did you receive your notary license?'); ?> </th> <td class="first_row"><?php echo $user[$model]['year_start_notary']; ?> </td>
			  </tr>
			  <tr>
			     <th><?php __('What year did you start conducting loan document signings?'); ?> </th> <td class="first_row">
			      <?php echo  $user[$model]['year_start_signings']; ?>
			     </td>
			  </tr>
			  <tr>
			     <th><?php __('How many loan document signings have you conducted?'); ?> </th> <td class="first_row">
			      <?php echo  $user[$model]['doc_signings_count']; ?>
			     </td>
			  </tr>
			  
			  <tr>
			     <th><?php __('What days are you available for signings?'); ?> </th> <td class="first_row">
			      <?php echo  $user[$model]['days_available']; ?>
			     </td>
			  </tr>
			  <tr>
			     <th><?php __('When are you available to conduct loan document signings?'); ?> </th> <td class="first_row">
			      <?php echo  $user[$model]['time_available']; ?>
			     </td>
			  </tr>
			  
			  
			  <tr>
			     <th><?php __('How many loan document signings can you conduct in a single day?'); ?> </th> <td class="first_row">
			      <?php echo  $user[$model]['signings_per_day']; ?>
			     </td>
			  </tr>
			  
			  
			  <tr>
			     <th><?php __('What do you charge a signing service for a refinance signing (EDOCS)?'); ?> </th> <td class="first_row">
			      <?php echo  $user[$model]['edocs_charge']; ?>
			     </td>
			  </tr>
			  
			  <tr>
			     <th><?php __('If you are on the approved notary list for title companies'); ?> </th>
				 <td class="first_row"><?php echo  $user[$model]['approved_titles']; ?>  </td>
				</tr>
				<tr>
			     <th> </th>
					<td><?php echo  $user[$model]['approved_titles_other']; ?>  </td>
				</tr>
						  
						  
			  <tr>
			     <th><?php __('Do you agree to maintain and provide an annual NNA Certified & Background-Screened Notary Signing Agent Certificate and annual NNA Background Check?'); ?> </th> 
				 <td class="first_row">
				     <?php echo  $user[$model]['agree_nna'] == true ? "Yes" : "No"; ?>
			     </td>
			  </tr>
			  
			  <tr>
			     <th><?php __('Have you had any claims/judgments pertaining to real estate transactions and/or notarial transactions been filed against you in the past 10 years**?'); ?> </th> 
				 <td class="first_row">
				     <?php echo  $user[$model]['claims_against'] == true ? "Yes" : "No"; ?>
			     </td>
			  </tr>
			  
			  <tr>
			     <th><?php __('Have you been convicted of a misdemeanor or felony in the past 10 years?'); ?> </th> 
				 <td class="first_row">
			      <?php echo  $user[$model]['convicted_misdemeanor'] == true ? "Yes" : "No"; ?>
			     </td>
			  </tr>
			  
			  
			  
			  <tr>
			     <th><?php __('What type of smarthphone do you have?'); ?> </th> <td class="first_row">
			      <?php echo  $user[$model]['smartphone_type']; ?>
			     </td>
			  </tr>
			  
			  <tr>
			     <th><?php __('What carrier do you have?'); ?> </th> <td class="first_row">
			      <?php echo  $user[$model]['smartphone_carrier']; ?>
			     </td>
			  </tr>
			  
			  <tr>
			     <th><?php __('How far are you willing to travel?'); ?> </th> <td class="first_row">
			      <?php echo  $user[$model]['travel_distance']; ?>
			     </td>
			  </tr>
			  
			  


  
			  <tr>
			     <th><?php __('Mistakes'); ?> </th> <td class="first_row"><?php echo $user[$model]['mistakes']; ?> </td>
			  </tr>

			  <?php }?>
			  
			</table>
		</div>
 <?php if($usertype=='notaries'){ ?>
 		<div class="mainBox subBoxborder fleft" style="width:31%;">
			<div class="header"><h1>Professional Details</h1></div>
			<div class="block_content">
				<table cellspacing="0" cellpadding="0" border="0" width="100%">

<tr>
			     <th><?php __('Type'); ?> </th>
			     <td class="first_row">
<?php 
		if($user[$model]['userstatus']<>"") {
      		echo $notaryoptions[$user[$model]['userstatus']];
     	} 
?>
				</td>
			</tr>			
				<tr>
			     <th><?php  __('Fees'); ?> </th> <td class="first_row"><?php __(Configure::read('currency')); ?><?php echo $user[$model]['fees']; ?> </td>
			  </tr>
			  <tr>
			     <th><?php __('Commission'); ?> </th> <td class="first_row"><?php echo $user[$model]['commission']; ?> </td>
			  </tr>
			  <tr>
			     <th><?php __('Expiration'); ?> </th> <td class="first_row"><?php echo $counter->formatdate('nsdate',$user[$model]['expiration']); ?> </td>
			  </tr>
			  <tr>
			     <th width="40%"><?php __('Laser printer'); ?> </th>
			     <td class="first_row">
			     <?php echo $ynoptions[$user[$model]['print']]; ?> </td>
			</tr>
			<tr>
			     <th><?php __('E-signing'); ?> </th> <td class="first_row">
			     <?php echo $ynoptions[$user[$model]['esigning']]; ?> </td>
			  </tr>
			   <tr>
			     <th><?php __('Wireless card'); ?> </th> <td class="first_row">
			     <?php echo $ynoptions[$user[$model]['wireless_card']]; ?> </td>
			  </tr>
			   <tr>
			     <th><?php __('Are you an attorney/work with attorney?'); ?> </th> <td class="first_row">
			     <?php echo $ynoptions[$user[$model]['work_with']]; ?> </td>
			  </tr>
			  
			 
    			
<?php 
		if($user[$model]['userstatus']=='P'){
?>
			<tr>
		     	<th><?php __('Payment option'); ?></th>
		     	<td class="first_row">
<?php
				if($user[$model]['payment']<>""){
			     	$pay = explode("|",$user[$model]['payment']);
			    	echo Configure::read('currency').$pay['0'];
			    }
?>
				</td>
			</tr>
			<tr>
			     <th><?php __('Paid'); ?> </th> <td class="first_row"><?php echo $user[$model]['paid']; ?> </td>
			</tr>
			<tr>
		     	<th><?php __('Account expires on'); ?></th>
	     		<td class="first_row"><?php echo $counter->formatdate('nsdatetimemeridiem',$user[$model]['enddate']);?></td>
     		</tr>
<?php
		}
?>
			  </table>
			</div>
		</div>
<?php
}
?>		
		<div class="mainBox subBoxborder fleft" style="width:31%;">
			<div class="header"><h1>More information</h1></div>
			<div class="block_content">
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
			     <th width="40%"><?php __('Status'); ?> </th> <td class="first_row">
    <?php echo $statusoptns[$user['User']['status']];?> </td>
			  </tr>
			<tr>
				<th> <?php __('Created'); ?> </th> <td class="first_row"><?php echo $counter->formatdate('nsdatetimemeridiem',$user[$model]['created']); ?> </td>
			</tr>
			<tr>
				<th> <?php __('Modified'); ?> </th> <td class="first_row"><?php echo $counter->formatdate('nsdatetimemeridiem',$user[$model]['modified']) ; ?> </td>
			</tr>
			  </table>
			</div>
		</div>
<?php
		if($history){
?>		
		<div class="mainBox subBoxborder fleft">
  			<div class="header"><h1>Fees History of <?php __($user[$model]['first_name']); ?></h1></div>
  			<table cellpadding="0" cellspacing="0" class="tablelist">
				<thead>
					<th width="10%">Sl no</th>
					<th width="20%">Fees</th>
					<th width="35%">Added date</th>
				</thead>
<?php
				$i = 0;
				foreach ($history as $feehistory):
					$class = null;
					if ($i++ % 2 == 0) { $class = ' class="altrow"'; }
?>
					<tr<?php echo $class;?>>
					<td><?php echo $counter->counters($i) ?></td>	
					<td><?php __(Configure::read('currency').$feehistory['HistoryFees']['fees']);  ?></td>
					<td><?php echo $counter->formatdate('nsdatetimemeridiem',$feehistory['HistoryFees']['created']); ?></td>
				</tr>
			<?php endforeach; ?>
				</table>
  		</div>
<?php
		}
?>
		<div class="mainBox subBoxborder fleft">
  		<div class="header">
<?php 
		if($usertype=='clients') { 
?>
        <h1>Orders History of <?php __($user[$model]['company']); ?> </h1>
<?php	} else { ?>
         <h1>Signing History of <?php __($user[$model]['first_name']); ?></h1>
<?php	} ?>
  		</div>
<?php 
		if($usertype=='clients'){
			__($this->element('admin/listorders', array('ordertitle'=>'New Requests','ordersubtitle'=>'New Notary Requests. Must ASSIGN Notary ASAP.','statusid'=>'1','classappend'=>'new_requests_data','classappendhead'=>'new_requests_head')));
		 	__($this->element('admin/listorders', array('ordertitle'=>'Assigned Requests','ordersubtitle'=>' Notary ASSIGNED. Notary Must Contact Borrower ASAP.','statusid'=>'2','classappend'=>'assigned_data','classappendhead'=>'assigned_head')));
			__($this->element('admin/listorders', array('ordertitle'=>'Unscheduled','ordersubtitle'=>'Appt Has Not Been Confirmed. See History for Details.','statusid'=>'3','classappend'=>'unscheduled_data','classappendhead'=>'unscheduled_head')));
			__($this->element('admin/listorders', array('ordertitle'=>'Scheduled','ordersubtitle'=>'Appt has Been Confirmed.','statusid'=>'4','classappend'=>'scheduled_data','classappendhead'=>'scheduled_head')));
			__($this->element('admin/listorders', array('ordertitle'=>'No Sign','ordersubtitle'=>'The Borrower Refused to Sign at the Signing Table.','statusid'=>'5','classappend'=>'no_sign_data','classappendhead'=>'no_sign_head')));
			__($this->element('admin/listorders', array('ordertitle'=>'Completed Signings','ordersubtitle'=>'File Has Been Signed And Notarized. Obtaining Tracking # is a Priority.','statusid'=>'7','classappend'=>'completed_data','classappendhead'=>'completed_head'))); 
		}
?>
<?php 
		if($usertype=='notaries'){
?>
	<div class="assignments index">
	<div class="block">
<?php if($assignments) { ?>
	<table cellpadding="0" cellspacing="0" class="tablelist">
	<thead>
		<th width="10%">Sl no</th>
		<th width="20%">Borrower</th>
		<th width="30%">Status</th>
		<th width="35%">Signed date</th>
		<th width="5%" class="actions">Details</th>
	</thead>
	<?php
	$i = 0;
	foreach ($assignments as $assignment):
		$class = null;
		if ($i++ % 2 == 0) {	$class = ' class="altrow"';		}
	?>
	<tr <?php echo $class;?>>
		<td><?php echo $counter->counters($i) ?></td>	
		<td><?php echo $assignment['Order']['first_name']." ".$assignment['Order']['last_name']; ?></td>
		<td><?php echo $misc->_orderStatus($assignment['Order']['orderstatus_id']); ?></td>
		<td><?php echo $counter->formatdate('nsdatetimemeridiem',$assignment['Assignment']['created']); ?></td>
		<td class="actions"><?php echo $html->link(__('View', true),array('controller'=>'orders','action'=>'view', $assignment['Order']['id']), array('class'=>'view_btn','title'=>'Order details','alt'=>'Order details')); ?></td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php __($this->element('pagination')); ?>
<?php } else { ?>
<?php __($this->element('nobox', array('displaytext'=>'No assignments yet'))); ?>	
<?php } ?>
</div></div>
<?php } ?>
    	</div> 
	</div>
</div>

