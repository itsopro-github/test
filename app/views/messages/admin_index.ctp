<?php 
$paginator->options(array('url'=>array_merge(array('trashed'=>@$this->params['trashed'],'sent'=>@$this->params['sent']),$this->passedArgs)));
if(isset($this->params['trashed'])!='') {
	$html->addCrumb("Messages", array('controller'=>'messages','action'=>'index'));
	$html->addCrumb("Trash", array());
	$messagestype = "Trash";
}
elseif(isset($this->params['sent'])!='') {
	$html->addCrumb("Messages", array('controller'=>'messages','action'=>'index'));
	$html->addCrumb("Sent", array());
	$messagestype = "Sent";
} else {
	$html->addCrumb("Messages", array());
	$messagestype = "";
}

?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Messages '.$messagestype);?></h1>
			<ul>
		       	<li><?php __($html->link('search','#',array('onclick'=>"loadSearchBox('search');")));?></li>
       	    	<li><?php if(isset($this->params['sent'])=='') { __($html->link('Sent',array('action'=>'index','sent'=>'sent','s:n'))); } else { __($html->link('List messages',array('action'=>'index','s:n'))); } ?></li>
       	    	<li><?php if(isset($this->params['trashed'])=='') { __($html->link('Trash',array('action'=>'index','trashed'=>'trash','s:n'))); } else { __($html->link('List messages',array('action'=>'index','s:n'))); } ?></li>
		       	<li><?php __($html->link('Add New Message',array('action'=>'add')));?></li>
	       </ul>
		</div>
		<!--SEARCH - start-->
		<div id="searchdiv" <?=(@$_SESSION['search']['params']=='') ? 'style="display:none;"' : 'style="display:block;"'?>>
			<?php echo $form->create('Message',array('action'=>'search','url'=>array('inbox'=>@$this->params['inbox'],'trashed'=>@$this->params['trashed'],'sent'=>@$this->params['sent'])));?>


				<table border="0" cellspacing="0" cellpadding="0" class="search_box">
					<tr> 
						<td>To</td>
						<td><?php echo $form->input('to_id', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$useroptions, 'empty'=>'--Select--','selected'=>@$_SESSION['search']['params']['to_id']));?></td>
						<td>Subject</td>
						<td><?php echo $form->input('subject', array('class'=>'text', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['subject']));?></td>
						<td><?php echo $html->link('Clear', array('action'=>'clear'), array('div'=>false,'class'=>'normalbutton fright'),null,false);echo $form->submit('Search', array('div'=>false,'class'=>'submit small fright')); ?></td>
					</tr>
				</table>
			<?php echo $form->end(); ?>
		</div>
		<!--SEARCH - end-->	
	<?php if($messages) { ?>
	<div class="block_content">
	<table cellpadding="0" cellspacing="0" class="tablelist">
	<thead>
			<th width="5%">Sl No</th>
			<th width="30%"><?php echo $this->Paginator->sort('subject');?></th>
			<?php if(isset($this->params['sent'])=='' || isset($this->params['trashed'])!='') { ?>
			<th width="15%"><?php echo $this->Paginator->sort('From','user_id');?></th>
			<?php } if(isset($this->params['sent'])!='' || isset($this->params['trashed'])!='') { ?>
			<th width="15%"><?php echo $this->Paginator->sort('To','to_id');?></th>
			<?php } ?>
			<th width="12%"><?php echo $this->Paginator->sort('notified');?></th>
			<?php if(isset($this->params['trashed'])!='') { ?>
			<th width="15%"><?php echo $this->Paginator->sort('trashed');?></th>			
			<?php } else { ?>
			<th width="15%"><?php echo $this->Paginator->sort('Sent Date','created');?></th>	
			<?php } ?>
			<th width="8%" class="actions"><?php __('Actions');?></th>
	</thead>
	<?php
	$i = 0;
	foreach ($messages as $message):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		($message['Message']['user_id']==1)?$fromname =$adminfo['Admin']['name']:$fromname=$useroptions[$message['Message']['user_id']];
		($message['Message']['to_id']==1)?$toname =$adminfo['Admin']['name']:$toname = $useroptions[$message['Message']['to_id']];
		if($message['Message']['notified']=='0000-00-00 00:00:00') {$notified = 'Not read';}else {$notified = 'Read';}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $counter->counters($i); ?></td>
		<td><?php echo $message['Message']['subject']; ?></td>
		<?php if(isset($this->params['sent'])=='' || isset($this->params['trashed'])!='') { ?>
		<td><?php echo $fromname; ?></td>
		<?php } if(isset($this->params['sent'])!='' || isset($this->params['trashed'])!='') { ?>
		<td><?php echo $toname; ?></td>
		<?php } ?>
		<td><?php echo $notified; ?></td>
		<?php if(isset($this->params['trashed'])!='') { ?>
		<td><?php echo $counter->formatdate('nsdatetimemeridiem',$message['Message']['trashed']); ?></td>	
		<?php } else { ?>	
		<td><?php echo $counter->formatdate('nsdatetimemeridiem',$message['Message']['created']); ?></td>
		<?php } ?>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $message['Message']['id']),array('class'=>'view_btn', 'title'=>'View', 'alt'=>'View')); ?>
			<?php if(isset($this->params['trashed']) == '') { ?>			
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $message['Message']['id']), array('class'=>'delete_btn', 'title'=>'Delete', 'alt'=>'Delete'), sprintf('Are you sure you want to delete \''.$message['Message']['subject'].'\'?', $message['Message']['id'])); ?>
			<?php } ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	</div>
	<?php __($this->element('pagination')); ?>
	<?php } else { ?>
	<?php __($this->element('nobox')); ?>
	<?php } ?>
</div>
</div>