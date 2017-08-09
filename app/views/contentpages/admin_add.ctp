<?php $html->addCrumb("Content pages", array('controller'=>'contentpages','action'=>'index'));?><?php $html->addCrumb("Add content page", array());?> 
<?php e($javascript->link('fckeditor/fckeditor')); ?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Add content page');?></h1>
			<ul>
		      	<li><?php echo $html->link(__('List content pages', true), array('action' => 'index')); ?></li>
	       </ul>
       	</div>
		<div class="block_content">
			<?php echo $form->create('Contentpage');?>
			<table class="formtable">
				<tr>
					<td width="20%"><label>Name<span class="mandatory">*</span></label></td>
					<td width="20%"><?php __($form->input('name', array('label'=>false,'class'=>'text','maxlength'=>'50','error'=>false,'div'=>false))); ?></td>
					<td width="20%"><label>Page title<span class="mandatory">*</span></label></td>
					<td width="20%"><?php __($form->input('pagetitle', array('label'=>false,'class'=>'text','maxlength'=>'50','error'=>false,'div'=>false))); ?></td>
				</tr>
				<tr>
					<td><label>Meta keywords</label></td>
					<td><?php __($form->input('metakey', array('label'=>false,'class'=>'text','error'=>false,'div'=>false))); ?></td>
					<td><label>Status</label></td>
					<td><?php echo $form->input('status', array('label'=>false,'class'=>'select_box','error'=>false,'div'=>false,'options'=>$statusoptions));?></td>
				</tr>
				
				<tr>
					<td><label>Meta description</label></td>
					<td colspan="3"><?php __($form->input('metadesc', array('label'=>false,'class'=>'text','error'=>false,'div'=>false, 'cols'=>'115'))); ?></td>
				</tr>
				<tr>
					<td><label>Content<span class="mandatory">*</span></label></td>
					<td colspan="3"><?php __($fck->fckeditor(array('Contentpage', 'content'), $html->base, $this->data['Contentpage']['content'])); ?></td>
				</tr>
				<tr>
					<td colspan="4"> 
					<hr>
					<p><?php __($form->submit('Submit', array('div'=>false,'class'=>'submit fleft'))); ?>
				<?php __($html->link('Cancel',array('controller'=>'contentpages','action'=>'index'),array('div'=>false,'class'=>'normalbutton fleft'))); ?></p>
					</td>
				</tr>
			</table>
			
				<?php echo $form->end();?>
		</div>
	</div>
</div>