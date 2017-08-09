<?php $html->addCrumb("Order", array('controller'=>'order','action'=>'index'));?><?php $html->addCrumb("Signing History", array());?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Signing History');?></h1>
			<ul>
		       	<li><?php __($html->link('search','#',array('onclick'=>"loadSearchBox('search');")));?></li>
		      	<li><?php echo $html->link(__('List Order', true), array('controller'=>'orders','action' => 'index')); ?></li>
	       </ul>
       	</div>
       		<div id="searchdiv" <?=(@$_SESSION['search']['params']=='') ? 'style="display:none;"' : 'style="display:block;"'?>>
			<?php echo $form->create('Signinghistories', array('controller'=>'Signinghistories','action' =>'search'));?>
				<table border="0" cellspacing="0" cellpadding="0" class="search_box">
					
					<tr>
						
						<td>Status</td>
						<td><?php __($form->input('Signinghistory.orderstatus_id',array('error'=>false,'label'=>false,'div'=>false,'id'=>'OrderStatus','options'=>$Orderstatus, 'selected'=>@$_SESSION['search']['params']['orderstatus_id'], 'class'=>'select_box'))); ?></td>
						<td colspan="4"><?php echo $form->submit('Search', array('div' => false,'class'=>'submit small fright'));echo $html->link('Clear', array('action'=>'clear'), array('div'=>false,'class'=>'normalbutton fright'),null,false);?></td>
					</tr>
				</table>
			<?php echo $form->end(); ?>
		</div>
  	<div class="block_content">
<?php
if($signinghistories) {	
?>
	<table cellpadding="0" cellspacing="0" class="tablelist">			
		<thead>
			<th width="5%">No</th>
			<th width="25%">Appointment</th>
			<th width="50%">Notes</th>
			<th width="20%">Sender</th>
		</thead>
<?php
$j = 0;
foreach ($signinghistories as $signinghistory):
	$class = null;
	if ($j++ % 2 == 0) {$class = ' class="altrow"';}
?>

	<tr <?php __($class);?>>
		<td><?php __($counter->counters($j)); ?></td>
		<td><?php __($signinghistory['Signinghistory']['appointment_time']); ?></td>
		<td><?php
		 __($signinghistory['Orderstatus']['status'].' : '.nl2br($signinghistory['Signinghistory']['notes'])); ?></td>
		<td><?php if($signinghistory['Signinghistory']['user_id']==0){ echo "Administrator";}  __($signinghistory['Notary']['first_name'].' '.$signinghistory['Notary']['last_name']); ?><?php __($signinghistory['Client']['first_name'].' '.$signinghistory['Client']['last_name']); ?></td>
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
</div>