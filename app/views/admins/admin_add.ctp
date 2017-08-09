<?php $html->addCrumb("Users", array('controller'=>'admins','action'=>'index'));?><?php $html->addCrumb("Add new user", array());
if($admindata['Admin']['type']=='S'){ 
?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header">
			<h1 class="fleft">Add new user</h1>
			<ul>
		      	<li><?php echo $html->link(__('List Users', true), array('action' => 'index')); ?></li>
	       </ul>
		</div>
		<div class="block_content">
			<?php echo $form->create('Admin');?>
			<table class="formtable">
				<tr>
					<td width="25%"><label>Name <span class="mandatory">*</span></label></td>
					<td width="25%"><?php __($form->input('name', array('class'=>'text','maxlength'=>'25','error'=>false,'div'=>false,'label'=>false))); ?></td>
					<td width="25%"><label>Email<span class="mandatory">*</span></label></td>
					<td width="25%"><?php __($form->input('email', array('div'=>false,'error'=>false,'class'=>'text','label'=>false)));?></td>
				</tr>
				<tr>
					<td><label>Username <span class="mandatory">*</span></label></td>
					<td><?php __($form->input('username', array('class'=>'text','maxlength'=>'15','error'=>false,'div'=>false,'label'=>false))); ?></td>
					<td><label>Password <span class="mandatory">*</span></label></td>
					<td><?php __($form->input('password',array('type'=>'password','class'=>'text','maxlength'=>'10','error'=>false,'div'=>false,'label'=>false)));?></td>
				</tr>
				<tr>
					<td><label>Confirm password <span class="mandatory">*</span></label></td>
					<td><?php __($form->input('confirmpassword',array('type'=>'password','class'=>'text','maxlength'=>'10','error'=>false,'div'=>false,'label'=>false)));?></td>
				</tr>
				<tr>
					<td><label>Status</label></td>
					<td><?php echo $form->input('status', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$statusoptions));?></td>
					<td><label>Type<span class="mandatory">*</span></label></td>
					<td><?php echo $form->input('type', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$admintypeoptions, 'empty'=>'--Select--'));?></td>
				</tr>
				<tr>
					<td colspan="4"><hr />
						<?php __($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft'))); ?>
						<?php __($html->link('Cancel',array('controller'=>'admins','action'=>'index'),array('div'=>false,'class'=>'normalbutton fleft'))); ?>
					</td>
				</tr>
			</table>
			<?php echo $form->end();?>
		</div>	
	</div>
</div>
<?php
} else {
	__($this->element('nopermission')); 
}
?>