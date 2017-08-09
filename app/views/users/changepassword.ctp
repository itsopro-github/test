<div class="form index">
	<p>Fill out the form below to change your password. When you create your new password, please make sure you create a unique password to help keep someone from entering in to your account. If your password is changed, you will receive an e-mail noting the password change. If it doesn't fit our requirements, you will be prompted to create a different password.</p><div>
		<?php __($form->create(array('action'=>'changepassword'))); ?>
		<div class="form_block required">
			<p><label class="form_label">Current password<span class="mandatory">*</span></label>
			<?php echo $form->text('currentpassword',array('type'=>'password','value'=>'','class'=>'text_box',"id"=>"Current_password",'maxlength'=>'50'));  ?></p></div>
		<div class="form_block required">
			<p><label class="form_label">New Password<span class="mandatory">*</span></label>
			<?php echo $form->text('password',array('type'=>'password','value'=>'','class'=>'text_box',"id"=>"Password",'maxlength'=>'50'));  ?></p>
		</div>
		<div class="form_block required">
			<p><label class="form_label">Confirm password<span class="mandatory">*</span></label>
			<?php echo $form->text('confirmpassword',array('type'=>'password','value'=>'','class'=>'text_box',"id"=>"ConfirmPassword",'maxlength'=>'50'));  ?></p>
		</div>
<?php
	__($form->submit('Submit', array('div'=>false,'class'=>'submitbtn fleft')));
	__($html->link('Cancel',array('controller'=>'users','action'=>'myaccount', 'type'=>low($counter->usertypes($usersession['User']['type']))),array('div'=>false,'class'=>'normalbutton fleft')));
	__($form->end());
?>
	</div>
</div>	