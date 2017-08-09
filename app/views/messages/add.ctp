<div class="form">
	<div>
		<?php __($form->create('Message'));?>
		<div class="form_block required"><p><label class="form_label">Subject<span class="mandatory">*</span></label><?php __($form->input('subject', array('label'=>false,'error'=>false,'div'=>false,'class'=>'text_box'))); ?></p></div>
		<div class="form_block required"><p><label class="form_label">Message<span class="mandatory">*</span></label><?php __($form->input('body',array('label'=>false,'error'=>false,'div'=>false,'cols'=>'46','class'=>'text_area'))); ?></p></div>
		<?php __($form->submit('Send', array('div'=>false,'class'=>'submitbtn fleft'))); ?>
		<?php __($form->end()); ?>
	</div>
</div>
