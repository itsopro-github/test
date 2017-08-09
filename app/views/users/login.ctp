<div class="form index">
	<?php __($content['Contentpage']['content']); ?>
	<p>If you already use <?php __(Configure::read('sitename')); ?>, you can login now from this page. If not signup now with <?php __(Configure::read('sitename')); ?> from the below options.</p>
	<div>
		<?php echo $form->create('User');?>
		<div class="form_block required">
			<p><label class="form_label">Username<span class="mandatory">*</span></label>
			<?php echo $form->input('username',array('class'=>'text_box','label'=>false,"id"=>"Username",'maxlength'=>'50')); ?>
			</p>
		</div>
		<div class="form_block required">
			<p>
				<label class="form_label">Password<span class="mandatory">*</span></label>
				<?php echo $form->input('password',array('type'=>'password','label'=>false,"id"=>"Password",'class'=>'text_box','maxlength'=>'25')); ?>
			</p>
		</div>
		<div class="form_block required">
			<p>By selecting the <b>LOGIN</b> button, I agree to the <?php __($html->link('Terms and Conditions', 'http://www.1hoursignings.com/terms-and-condition', array('target'=>'_blank'))); ?></p>
		</div>
		<div>
<?php
		__($form->submit('Login',array('div'=>false,'class'=>'submitbtn fleft')));
		__($form->end());
?>
			<p><label class="form_label"><?php __($html->link('Forgot Password',array('controller'=>'users','action'=>'forgotpassword'))); ?></label></p>
		</div>
		
	</div>
</div>
<div class="imagediv">
	<?php __($html->image('become_client.png', array('alt'=>'Become a Client', 'title'=>'Become a Client','url'=>array('controller'=>'users','action'=>'signup','type'=>Inflector::slug('become a client'),'who'=>'client')))); ?>
	<?php __($html->image('notary.png', array('alt'=>'Become a 1Hr Notary', 'title'=>'Become a 1Hr Notary', 'url'=>array('controller'=>'users','action'=>'signup','type'=>Inflector::slug('become a 1hr notary'),'who'=>'beginner')))); ?>
	<?php __($html->image('join.png', array('alt'=>'Join Our Professional Network', 'title'=>'Join Our Professional Network','url'=>array('controller'=>'users','action'=>'signup','type'=>Inflector::slug('join our professional network'),'who'=>'professional')))); ?>
</div>