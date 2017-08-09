<?php $html->addCrumb("Messages", array('controller'=>'messages','action'=>'index'));?><?php $html->addCrumb("Add Messages", array());?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Admin Add Message'); ?></h1>
		<ul>
		      	<li><?php echo $html->link(__('List Messages', true), array('action' => 'index')); ?></li>
	 </ul>
 	</div>
<div class="block_content">
<?php echo $form->create('Message');?>
	<table class="formtable">
					<tr>
						<td width="20%"><label>From<span class="mandatory">*</span></label></td>
						<td width="80%"> <?php echo $fromname ?></td>
					</tr>
					<tr>
						<td width="20%"><label>To<span class="mandatory">*</span></label></td>
						<td width="30%"><?php __($form->input('to_id', array('label'=>false,'class'=>'select_box','error'=>false,'div'=>false,'options'=>$toidoptions))); ?></td>
					</tr> 
					<tr>
						<td width="20%"><label>Subject<span class="mandatory">*</span></label></td>
						<td width="80%"><?php __($form->input('subject', array('label'=>false,'class'=>'text','error'=>false))); ?></td>
					</tr>
					<tr>
						<td width="20%"><label>Message<span class="mandatory">*</span></label></td>
						<td><?php __($form->input('body', array('label'=>false,'class'=>'text','cols'=>117,'error'=>false,'div'=>false))); ?></td>
					</tr>
					<tr>
						<td colspan="2"><hr /><?php __($form->submit('Send', array('div'=>false,'class'=>'submit small fleft'))); ?>
				<?php __($html->link('Cancel',array('controller'=>'messages','action'=>'index'),array('div'=>false,'class'=>'normalbutton fleft'))); ?></td>
					</tr> 			
	</table>
<?php echo $form->end();?>
</div>
</div>
</div>