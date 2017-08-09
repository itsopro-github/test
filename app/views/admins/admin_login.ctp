<?php echo $form->create('Admin',array('controller'=>'admins','action'=>'login'));?>
<p><?php echo $form->input('username',array('class'=>'text medium','maxlength'=>'15','error'=>false,'error'=>false,'div'=>false,'value'=>'')); ?></p>
<p><?php echo $form->input('password',array('class'=>'text medium','maxlength'=>'15','error'=>false,'div'=>false,'value'=>''));?></p>
<p style="margin:15px;"><?php echo $form->submit('Login',array('div'=>false,'class'=>'submit')); ?></p>
<?php echo $form->end();?>