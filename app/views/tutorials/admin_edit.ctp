<?php $html->addCrumb("Tutorials", array('controller'=>'tutorials','action'=>'index'));?><?php $html->addCrumb("Edit tutorial", array());?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Edit tutorial');?></h1>
			<ul>
		      	<li><?php echo $html->link(__('List tutorials', true), array('action' => 'index')); ?></li>
	       </ul>
       	</div>
		<div class="block_content">
			<?php echo $form->create('Tutorial',array('enctype'=>'multipart/form-data'));?>
			<?php __($form->input('tutorial', array('label'=>false,'value'=>@$this->data['Tutorial']['tutorialfile'],'type'=>'hidden','div'=>false))); ?>
				<table class="formtable">
					<tr>
						<td width="20%"><label>Title<span class="mandatory">*</span></label></td>
						<td width="20%"><?php __($form->input('title', array('label'=>false,'class'=>'text','maxlength'=>'125','error'=>false,'div'=>false))); ?></td>
						<td width="20%"><label>Category<span class="mandatory">*</span></label></td>
						<td width="20%"><?php echo $form->input('category', array('label'=>false,'class'=>'select_box','error'=>false,'div'=>false,'options'=>$useroptions));?></td>
					</tr>
					<tr>
						<td><label>Description<span class="mandatory">*</span></label></td>
						<td colspan="4"><?php __($form->input('description', array('label'=>false,'class'=>'text','cols'=>'115','error'=>false,'div'=>false))); ?></td>
					</tr>
					<tr>
						<td><label>Upload tutorial</label></td>
						<td><?php __($form->input('tutorialfile', array('label'=>false,'type'=>'file','class'=>'text','error'=>false,'div'=>false))); ?></td>
						<td><label>Status</label></td>
						<td><?php echo $form->input('status', array('label'=>false,'class'=>'select_box','error'=>false,'div'=>false,'options'=>$statusoptions));?></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="3"><span class="mandatory">[Recommended file types are FLV, MP4, MP3, AAC]</span></td>
					</tr>
					<tr>
						<td colspan="4"><hr /><?php __($form->submit('Submit', array('div'=>false,'class'=>'submit fleft'))); ?>
				<?php __($html->link('Cancel',array('controller'=>'tutorials','action'=>'index'),array('div'=>false,'class'=>'normalbutton fleft'))); ?></td>
					</tr>
				</table>
				<?php echo $form->input('id'); echo $form->end();?>
		</div>
	</div>
</div>