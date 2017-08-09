<?php $html->addCrumb("Resources", array('controller'=>'resources','action'=>'index'));?>
<?php $html->addCrumb("Edit resource", array());?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Edit resource');?></h1>
			<ul>
		      	<li><?php echo $html->link(__('List resources', true), array('action' => 'index')); ?></li>
	       </ul>
       	</div>
		<div class="block_content">
			<?php echo $form->create('Resource',array('enctype'=>'multipart/form-data'));?>
			<?php __($form->input('resource', array('label'=>false,'value'=>@$this->data['Resource']['resourcefile'],'type'=>'hidden','div'=>false))); ?>
				<table class="formtable">
					<tr>
						<td width="20%"><label>Title<span class="mandatory">*</span></label></td>
						<td width="20%"><?php __($form->input('title', array('label'=>false,'class'=>'text','maxlength'=>'125','error'=>false,'div'=>false))); ?></td>
						<td width="20%"><label>Category</label></td>
						<td width="20%"><?php echo $form->input('category', array('label'=>false,'class'=>'select_box','error'=>false,'div'=>false,'options'=>$resourcescategory));?></td>
					</tr>
					<tr>
						<td><label>Description<span class="mandatory">*</span></label></td>
						<td colspan="4"><?php __($form->input('description', array('label'=>false,'cols'=>'115','error'=>false,'div'=>false))); ?></td>
					</tr>
					<tr>
						<td width="15%"><label>Upload resource file</label></td>
						<td><?php __($form->input('resourcefile', array('label'=>false,'type'=>'file','class'=>'text','error'=>false,'div'=>false))); ?></td>
						<td colspan="2"><span class="mandatory">[Recommended file types are 'pdf']</span></td>
					</tr>
					<tr>
						<td><label>Help link</label></td>
						<td><?php __($form->input('helplink', array('label'=>false,'class'=>'text','maxlength'=>'125','error'=>false))); ?></td>
						<td><label>Status</label></td>
						<td><?php echo $form->input('status', array('label'=>false,'class'=>'select_box','error'=>false,'div'=>false,'options'=>$statusoptions));?></td>
					</tr>
					<tr>
						<td colspan="4"><hr /><?php __($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft'))); ?>
				<?php __($html->link('Cancel',array('controller'=>'resources','action'=>'index'),array('div'=>false,'class'=>'normalbutton fleft'))); ?></td>
					</tr>
				</table>
				<?php echo $form->input('id'); echo $form->end();?>
		</div>
	</div>
</div>