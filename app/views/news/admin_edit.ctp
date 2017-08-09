<?php $html->addCrumb("News", array('controller'=>'news','action'=>'index'));?><?php $html->addCrumb("Edit news", array());?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Edit news');?></h1>
			<ul>
		      	<li><?php echo $html->link(__('List news', true), array('action' => 'index')); ?></li>
	       </ul>
       	</div>
		<div class="block_content">
			<?php echo $form->create('News',array('enctype'=>'multipart/form-data'));?>
			<?php __($form->input('img', array('label'=>false,'value'=>@$this->data['News']['image'],'type'=>'hidden','div'=>false))); ?>
				<table class="formtable">
					<tr>
						<td width="20%"><label>Title<span class="mandatory">*</span></label></td>
						<td><?php __($form->input('title', array('label'=>false,'class'=>'text','maxlength'=>'125','error'=>false,'div'=>false))); ?></td>
						<td><label>Thumbnail Image</label></td>
						<td><?php __($form->input('image', array('label'=>false,'type'=>'file','class'=>'text','error'=>false,'div'=>false))); ?><span class="mandatory">[Recommended type: 'jpg','jpeg','gif','png', dimension: 84px × 86px]</span></td>
					</tr>
					<tr>
						<td><label>Description<span class="mandatory">*</span></label></td>
						<td colspan="3"><?php __($form->input('description', array('label'=>false,'class'=>'text','cols'=>115,'error'=>false,'div'=>false))); ?></td>
					</tr>
					<tr>
						<td><label>Status</label></td>
						<td><?php echo $form->input('status', array('label'=>false,'class'=>'select_box','error'=>false,'div'=>false,'options'=>$statusoptions));?></td>
					</tr>
					<tr>
						<td colspan="4"><hr /><?php __($form->submit('Submit', array('div'=>false,'class'=>'submit fleft'))); ?>
				<?php __($html->link('Cancel',array('controller'=>'news','action'=>'index'),array('div'=>false,'class'=>'normalbutton fleft'))); ?></td>
					</tr>
				</table>
				
				<?php echo $form->input('id'); echo $form->end();?>
		</div>
	</div>
</div>