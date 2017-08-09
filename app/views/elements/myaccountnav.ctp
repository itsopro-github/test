<div><h2>Quick Links</h2><hr width="100%" /></div>
<?php 
	$model = ($usersession['Client']['id'] == '') ? 'Notary' : 'Client';
	$model_for_myaccount = ($usersession['Client']['id'] == '') ? 'notaries' : 'clients';
?>
<div class="users">
	<?php if($model == 'Client') { ?>
	<p style="padding-left:25px;"><?php __($html->link('Dashboard',array('controller'=>'users', 'action'=>'myaccount','type'=>$model_for_myaccount))); ?></p>
	<p style="padding-left:25px;"><?php __($html->link('Request A Notary',array('controller'=>'orders','action'=>'addorder','type'=>$model_for_myaccount))); ?></p>
	<p style="padding-left:25px;"><?php __($html->link('Current Signings',array('controller'=>'orders','action'=>'index','type'=>$model_for_myaccount))); ?></p>
	<p style="padding-left:25px;"><?php __($html->link('Invoices ',array('controller'=>'invoices','action'=>'index','type'=>$model_for_myaccount))); ?></p>
	<p style="padding-left:25px;"><?php __($html->link('Video Tutorials',array('controller'=>'tutorials','action'=>'index','type'=>$model_for_myaccount))); ?></p>
	<p style="padding-left:25px;"><?php __($html->link('Archived Signings',array('controller'=>'orders','action'=>'archived','type'=>$model_for_myaccount))); ?></p>
<?php } else { ?>
	<p style="padding-left:25px;"><?php __($html->link('Dashboard',array('controller'=>'users', 'action'=>'myaccount','type'=>$model_for_myaccount))); ?></p>
	<p style="padding-left:25px;"><?php __($html->link('Messages',array('controller'=>'messages','action'=>'index','type'=>$model_for_myaccount))); ?></p>
	<p style="padding-left:25px;"><?php __($html->link('Current Signings',array('controller'=>'orders','action'=>'index','type'=>$model_for_myaccount))); ?></p>
	
	<p style="padding-left:25px;"><?php __($html->link('Video Tutorials',array('controller'=>'tutorials','action'=>'index','type'=>$model_for_myaccount))); ?></p>
	<p style="padding-left:25px;"><?php __($html->link('Archived Signings',array('controller'=>'orders','action'=>'archived','type'=>$model_for_myaccount))); ?></p>
<?php } ?>

<?php if($model != 'Client') { ?>	

	<p style="padding-left:25px;"><?php __($html->link('Notary Resources',array('controller'=>'resources','action'=>'index','type'=>$model_for_myaccount))); ?></p>
<?php } ?>	
	<p style="padding-left:25px;"><?php __($html->link('Update My Account',array('controller'=>'users','action'=>'edit','type'=>$model_for_myaccount))); ?></p>
	<p style="padding-left:25px;"><?php __($html->link('Change Password',array('controller'=>'users','action'=>'changepassword','type'=>$model_for_myaccount))); ?></p>
	<p style="padding-left:25px;"><?php __($html->link(Configure::read('sitename').' Website',  Configure::read('PARENT_WEB_URL')));  ?></p>
</div>
  
