<?php echo $html->css(array('styleiframe')); ?>
<div class="signinghistories index">
	<div class="block" style="background:white;">
<?php
if($signinghistories) {	
?>
	<table cellpadding="0" cellspacing="0" class="tablelist">			
		<thead>
			<th width="5%">No</th>
			<th width="25%">Appointment</th>
			<th width="50%">Notes</th>
			<th width="50%">Tracking #</th>
			<th width="20%">Sender</th>
			<th width="20%">Created</th>
		</thead>
<?php
$j = 0;
foreach ($signinghistories as $signinghistory):
	$class = null;
	if ($j++ % 2 == 0) {$class = ' class="altrow"';}
?>
	<tr <?php __($class);?>>
		<td><?php __($counter->counters($j)); ?></td>
		<td><?php if($signinghistory['Orderstatus']['status']=="SCHEDULED" || $signinghistory['Orderstatus']['status']=="SIGNING COMPLETED"){ __($signinghistory['Signinghistory']['appointment_time']);}else{ echo " "; }  ?>&nbsp;</td>
		<td><?php __($signinghistory['Orderstatus']['status'].' : '.nl2br($signinghistory['Signinghistory']['notes'])); ?>
<?php 
		if($signinghistory['Signinghistory']['orderstatus_id'] >= '7') { 
			echo "<br />[ Tracking # : ".$misc->gettracking($signinghistory['Signinghistory']['order_id'], true)." ]";
		}
?>
		</td>
		<td><?php echo $misc->getsender($signinghistory['Signinghistory']['added_by'],$signinghistory['Signinghistory']['user_id']); ?></td>
		<td><?php __($counter->formatdate('nsdatetime',$signinghistory['Signinghistory']['created'])); ?></td>
	</tr>
<?php 
endforeach;
?>		
	</table>
<?php
} else {
	__($this->element('nobox', array('displaytext'=>'No status updates found')));		
}
?>
	</div>
</div>