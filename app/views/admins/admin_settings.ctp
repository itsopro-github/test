<?php $html->addCrumb("Edit Settings", array());?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft">Edit Settings</h1></div>
			<div class="block_content">
				<?php echo $form->create('Admin', array('action'=>'settings'));?>
				<table class="formtable">
					<tr>
						<td width="20%"><label>Name<span class="mandatory">*</span></label></td>
						<td><?php __($form->input('name', array('label'=>false,'class'=>'text','maxlength'=>'25','error'=>false,'div'=>false))); ?></td>
						<td><label>Email<span class="mandatory">*</span></label></td>
						<td><?php __($form->input('email', array('label'=>false,'div'=>false,'class'=>'text')));?></td>
					</tr>
					<tr>
						<td><label>Username<span class="mandatory">*</span></label></td>
						<td><?php __($form->input('username', array('label'=>false,'class'=>'text','maxlength'=>'15','error'=>false,'div'=>false))); ?><span class="mandatory"></span></td>
					
						<td><label>Current Password<span class="mandatory">*</span></label></td>
						<td><?php __($form->input('currentpassword',array('label'=>false,'type'=>'password','value'=>'','class'=>'text','maxlength'=>'10','error'=>false,'div'=>false)));?></td>
					</tr>
					<tr>
						<td><label>New password<span class="mandatory">*</span></label></td>
						<td><?php __($form->input('password',array('label'=>false,'type'=>'password','value'=>'','class'=>'text','maxlength'=>'10','error'=>false,'div'=>false)));?></td>
						<td><label>Confirm Password<span class="mandatory">*</span></label></td>
						<td><?php __($form->input('confirmpassword',array('label'=>false,'type'=>'password','value'=>'','class'=>'text','maxlength'=>'10','error'=>false,'div'=>false)));?></td>
					</tr>
				</table>
				<hr>
				<p><?php __($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft'))); ?>
				<?php __($html->link('Cancel',array('controller'=>'admins','action'=>'dashboard'),array('div'=>false,'class'=>'normalbutton fleft'))); ?></p>
				<?php echo $form->end();?>
			</div>	
		</div>
	</div>
</div>	