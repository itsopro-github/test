<?php 
	$model = ($usersession['Client']['id'] == '') ? 'Notary' : 'Client';
	$model_for_myaccount = ($usersession['Client']['id'] == '') ? 'notaries' : 'clients';
?>
<div class="users index">
	<p style="font-size:14px !important;">Hello <?php __($usersession[$model]['first_name']); ?>,</p>
	<p style="font-size:14px !important;"><b>Welcome to your <?php __(Configure::read('sitename')); ?> dashboard!</b></p><br />
<?php if($usersession['Client']['id'] <> '') { ?>
	<div class="content fleft">
	
		<div class="fleft" ><?php __($html->link(__('',true),array('controller'=>'orders','action'=>'addorder','type'=>$model_for_myaccount),array('class'=>'notary_btn')));  ?></div>
		 <div class="fleft" ><?php __($html->link(__('',true),array('controller'=>'orders','action'=>'index','type'=>$model_for_myaccount),array('class'=>'signings_btn')));  ?></div>
		
		<div class="fleft" ><?php __($html->link(__('',true),array('controller'=>'orders','action'=>'archived','type'=>$model_for_myaccount),array('class'=>'archived_btn')));  ?></div>
		<div  class="fleft"><?php __($html->link(__('',true),array('controller'=>'invoices','action'=>'index','type'=>$model_for_myaccount),array('class'=>'invoice_btn')));  ?></div>
		<div class="fleft"><?php __($html->link(__('',true),array('controller'=>'tutorials','action'=>'index','type'=>$model_for_myaccount),array('class'=>'tutorial_btn')));  ?></div>
		<div class="fleft"><?php __($html->link(__('',true),array('controller'=>'users','action'=>'edit','type'=>$model_for_myaccount),array('class'=>'updateaccnt_btn')));  ?></div>
		<div class="fleft" ><?php __($html->link(__('',true),array('controller'=>'users','action'=>'changepassword','type'=>$model_for_myaccount),array('class'=>'changepswd_btn')));  ?></div>
		
	</div>
<?php } else { ?>
	<div class="content fleft">
		 <div class="fleft"><?php __($html->link(__('',true),array('controller'=>'messages','action'=>'index','type'=>'notaries'),array('class'=>'message_btn')));  ?></div>
		
	   	 <div class="fleft" ><?php __($html->link(__('',true),array('controller'=>'orders','action'=>'index','type'=>$model_for_myaccount),array('class'=>'signings_btn')));  ?></div>
		
	    <div class="fleft" ><?php __($html->link(__('',true),array('controller'=>'orders','action'=>'archived','type'=>$model_for_myaccount),array('class'=>'archived_btn')));  ?></div>
		<div class="fleft" ><?php __($html->link(__('',true),array('controller'=>'tutorials','action'=>'index','type'=>$model_for_myaccount),array('class'=>'tutorial_btn')));  ?></div>
		<div class="fleft"><?php __($html->link(__('',true),array('controller'=>'resources','action'=>'index','type'=>$model_for_myaccount),array('class'=>'resource_btn')));  ?></div>
		
		<div class="fleft"><?php __($html->link(__('',true),array('controller'=>'users','action'=>'edit','type'=>$model_for_myaccount),array('class'=>'updateaccnt_btn')));  ?></div>
		<div class="fleft" style="clear: both;"><?php __($html->link(__('',true),array('controller'=>'users','action'=>'changepassword','type'=>$model_for_myaccount),array('class'=>'changepswd_btn')));  ?></div>
		</div>
<?php } ?>
	<div class="fleft"><p style="font-size:14px !important;">If you need assistance, please e-mail <?php __($html->link(Configure::read('displayemail'), 'mailto:'.Configure::read('displayemail'))); ?>, call <?php __(Configure::read('tollfreenumber'));?>.</p>
	<p style="font-size:14px !important;" align="right"><b>To your success,</b><br />
	<b><?php __(Configure::read('ceo'));?></b><br />
	<b><?php __(Configure::read('sitename'));?></b></p></div><br />
	
</div>