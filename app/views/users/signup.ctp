<div class="form index">
	<p><?php __(nl2br($contentpage['Contentpage']['content'])); ?></p>
	<div>
<?php
	__($form->create('User',array('id'=>'signupFrm','url'=>$html->url(array('controller'=>'users','action'=>'signup','type'=>$this->params['type'],'who'=>$this->params['who']),true))));
	//depends on the user type
	__($this->element($this->params['who']));
	__($form->submit('Submit', array('div'=>false, 'class'=>'submitbtn fleft')));
	__($html->link('Cancel',array('controller'=>'users','action'=>'login'),array('div'=>false,'class'=>'normalbutton fleft')));
	__($form->end());
?>
	</div>
</div>