<div>
	<div class="block">
	<?php __($form->create(array('action'=>'mailcontact', 'id'=>'mailContactForm'))); ?>
		
		<div class="form_block required">
			<p><label class="form_label">Name<span class="mandatory">*</span></label>
				<?php echo $form->text('name',array('class'=>'text_box',"id"=>"Name",'maxlength'=>'50')); ?>
			</p></div>

	<div class="form_block required">
			<p><label class="form_label">Email Address<span class="mandatory">*</span></label>
				<?php echo $form->text('email',array('class'=>'text_box',"id"=>"Email_address",'maxlength'=>'50'));  ?>
			</p></div>
				<div class="form_block ">
			<p><label class="form_label">Company</label>
				<?php echo $form->text('company',array('class'=>'text_box',"id"=>"Company",'maxlength'=>'50')); ?>
			</p></div>
				<div class="form_block ">
			<p><label class="form_label">Subject</label>
				<?php echo $form->text('subject',array('class'=>'text_box',"id"=>"Subject",'maxlength'=>'50')); ?>
			</p></div>
				<div class="form_block required">
			<p>
			<label class="form_label">Message<span class="mandatory">*</span></label>
			<?php __($form->input('message', array('class'=>'text','label'=>false,"id"=>"Message",'cols'=>'62','rows'=>'6','error'=>false,'div'=>false))); ?>
			</p></div>
			<?php echo $form->submit('Submit', array('id' => 'submit')); ?>
		<?php echo $form->end();?>
	</div>
</div>