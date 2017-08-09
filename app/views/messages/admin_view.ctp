<?php 
if($message['Message']['trashed'] != '0000-00-00 00:00:00') {
	$html->addCrumb("Messages", array('controller'=>'messages','action'=>'index'));
	$html->addCrumb("Trash", array('controller'=>'messages','action'=>'index','trashed'=>'trash'));
	$html->addCrumb($message['Message']['subject'], array());
} 
elseif($message['Message']['user_id'] == '1') {
	$html->addCrumb("Messages", array('controller'=>'messages','action'=>'index'));
	$html->addCrumb("Sent", array('controller'=>'messages','action'=>'index','sent'=>'sent'));
	$html->addCrumb($message['Message']['subject'], array());
} else {
	$html->addCrumb("Messages", array('controller'=>'messages','action'=>'index'));
	$html->addCrumb($message['Message']['subject'], array());
}
if($message['Message']['notified']=='0000-00-00 00:00:00') {$notified = 'Not read';}else {$notified = 'Read';}
($message['Message']['user_id']==1)?$fromname =$adminfo['Admin']['name']:$fromname = $misc->getUserName($message['Message']['user_id']);
($message['Message']['to_id']==1)?$toname =$adminfo['Admin']['name']:$toname = $misc->getUserName($message['Message']['to_id']);
?>
<?php ?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php  __('Message - ' .$message['Message']['subject'])?></h1>
			<ul>
		      	<?php if($message['Message']['trashed'] != '0000-00-00 00:00:00') { ?>
		      	<li><?php echo $html->link(__('Messages Trash', true), array('action' => 'index', 'trashed'=>'trash')); ?></li>		      	
		      	<?php } elseif($message['Message']['user_id'] == '1') { ?>
		      	<li><?php echo $html->link(__('Messages Sent', true), array('action' => 'index', 'sent'=>'sent')); ?></li>		      	
		      	<?php } else { ?>
		      	<li><?php echo $html->link(__('List Messages', true), array('action' => 'index')); ?></li>
		      	<?php } ?>
		 	</ul>
		 	</div>
		 	<div class="block_content fleft" style="width:64%;">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			  <tr>
			     <th><?php __('From'); ?></th>
			     <td><?php echo $fromname; ?></td>
			  </tr>
			  <tr>
			     <th><?php __('To'); ?></th>
			     <td><?php echo $toname; ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Subject'); ?></th>
			     <td><?php echo $message['Message']['subject']; ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Body'); ?></th>
			     <td><?php echo nl2br($message['Message']['body']); ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Notified'); ?></th>
			     <td><?php echo $notified; ?></td>
			  </tr>
			  
			</table>
		</div>
		<div class="mainBox subBoxborder fleft" style="width:31%;">
			<div class="header"><h1>More Information</h1></div>
			<div class="block_content">
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
				  <tr>
				     <th><?php __('IP Address'); ?></th>
				     <td><?php echo $message['Message']['ipaddress']; ?></td>
				  </tr>
				  <?php if($message['Message']['trashed'] != '0000-00-00 00:00:00') { ?>
				  <tr>
				     <th><?php __('Trashed'); ?></th>
				     <td><?php echo $counter->formatdate('nsdatetimemeridiem',$message['Message']['trashed']); ?></td>
				  </tr>
				  <?php } ?>
				  <tr>
				     <th><?php __('Created'); ?></th>
				     <td><?php echo $counter->formatdate('nsdatetimemeridiem',$message['Message']['created']); ?></td>
				  </tr>
				  <tr>
				     <th><?php __('Modified'); ?></th>
				     <td><?php echo $counter->formatdate('nsdatetimemeridiem',$message['Message']['modified']); ?></td>
				  </tr>
			  </table>
			</div>
		</div>
	</div>
</div>
