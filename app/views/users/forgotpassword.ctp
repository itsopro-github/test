<div class="users form index">
<?php __($form->create(array('action'=>'forgotpassword'))); ?>
	<p>If you have lost your password, please enter your email address here and we will send you a new one!</p>
	<div class="form_block required">
		<p>
			<label class="form_label">Email Address<span class="mandatory">*</span></label>
			<?php echo $form->text('email',array('class'=>'text_box',"id"=>"Email_address",'maxlength'=>'50'));  ?>
		</p>
	</div>
<?php 
	__($form->submit('Submit', array('id' => 'submit','class'=>'submitbtn fleft')));
	__($html->link('Cancel',array('controller'=>'users','action'=>'login'),array('div'=>false,'class'=>'normalbutton fleft')));
	__($form->end());
?>
</div>