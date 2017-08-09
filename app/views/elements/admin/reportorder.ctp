<div class="mainBox subBoxborder" style="width:98%;">
<div class="header"><h3>Report Generated for: <?php __($title);?></h3></div>
<div style="padding:10px">
	<p>
<?php 
	if(isset($date)) { echo " Date:  ".$date."<br /> ";}
	if(isset($time1) && isset($time2)) { echo " Between   ".$time1." and ".$time2."<br /> ";}
	if(isset($fromdate) && isset($todate)) { echo " Date: from ".$fromdate." to ".$todate."<br /> ";}
	if(isset($company)) { echo "  Company: ".$company." <br />  "; }
	if(isset($month)) { echo "  Month: ".$monthoptns[$month]." <br />  ";}
	if(isset($year)) {echo "  Year: ".$year."<br />  ";}
	if(isset($notary)) {echo "  Mistake: ".$notary." <br />  ";}
	if(isset($notarytype)) { echo " <br /> Notary Type: ".$ntype[$notarytype]."<br />  ";}
	if(isset($heartype)) { echo " <br /> How did you hear: ".$hearoptions[$heartype]."<br />  ";}
?>
	</p>
</div>
<table cellpadding="0" cellspacing="0" class="tablelist">	
<?php
$j = 0;
if(!empty($orders)){
	foreach ($orders as $order):
		$class = ' class="'.$classappend.'"';
		if ($j++ % 2 == 0) {$class = ' class="altrow '.$classappend.'"';}
		if($j==1) {
?>
		
		<thead>
			<th width="5%">Sl No</th>
			<th width="16%"><?php echo 'Borrower'?></th>
			<th width="21%"><?php echo 'City,State';?></th>
			<th width="16%"><?php echo 'Company/Division';?></th>
			<th width="7%"><?php echo 'File#';?></th>
			<th width="14%"><?php echo 'Notary';?></th>
			<th width="7%"><?php echo 'Appt.Time';?></th>
			<th width="7%"><?php echo 'Posted';?></th>
			<th width="7%"><?php echo 'Modified';?></th>
		</thead>
<?php 
		}
?>		
		<tr <?php echo $class;?>>
			<td><?php echo $counter->counters($j); ?></td>
			<td><?php echo $order['o']['first_name'].' '.$order['o']['last_name']; ?></td>
			<td><?php echo $order['o']['sa_city'].', '.$order['o']['sa_state']; ?></td>
			<td><?php echo $misc->getCompName($order['o']['user_id'])." / ".$misc->getDivName($order['o']['user_id']);?></td>
			<td><?php echo $order['o']['file']; ?></td>
			<td><?php echo $misc->getNotaryName($order['o']['id']); ?></td>
			<td><?php echo $misc->getApptdttime($order['o']['id']);?></td>			
			<td><?php echo $counter->formatdate('nsdatetimemeridiem',$order['o']['created']); ?></td>
			<td><?php echo $counter->formatdate('nsdatetimemeridiem',$order['o']['modified']); ?></td>
		</tr>
<?php 
	endforeach;
}
$j = 0;
if(!empty($getmstk)){
	foreach ($getmstk as $gm):
		$class = ' class="'.$classappend.'"';
		if ($j++ % 2 == 0) {$class = ' class="altrow '.$classappend.'"';}
		if($j==1) {
?>
		<thead>
			<th width="5%">Sl No</th>
			<th width="16%"><?php echo 'Notary'?></th>
			<th width="16%"><?php echo 'Notary type'?></th>
			<th width="7%"><?php echo 'Posted';?></th>
			<th width="7%"><?php echo 'Modified';?></th>
		</thead>
<?php 
		}
?>		
		<tr <?php echo $class;?>>
			<td><?php echo $counter->counters($j); ?></td>
			<td><?php  __($html->link($gm['Notary']['first_name'].' '.$gm['Notary']['last_name'], array('controller'=>'users','action'=>'view','type'=>'notaries','id'=>$gm['Notary']['user_id']), array( 'title'=>'View', 'alt'=>'View'))); ?></td>
			<td><?php echo $notaryoptions[$gm['Notary']['userstatus']]; ?></td>
			<td><?php echo $counter->formatdate('nsdatetimemeridiem', $gm['Notary']['created']); ?></td>
			<td><?php echo $counter->formatdate('nsdatetimemeridiem', $gm['Notary']['modified']); ?></td>
		</tr>
<?php 
	endforeach;
}
if(isset($resnum)) {
?>
		<thead><th colspan="9"><?php echo "Total Number : ".$resnum;?></th></thead>
<?php
}
?>
	</table>
<div>
<?php
if(empty($orders) and empty($resnum) and empty($getmstk)) {
	__($this->element('nobox', array('displaytext'=>'No '.$ordertitle.' found')));		
}
?>
</div>
</div>