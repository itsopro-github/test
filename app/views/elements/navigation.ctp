<?php
$homehlight = $aboutushlight = $serviceshlight = $clientareahlight = $notarieshlight = $contacthlight = $loginhlight = $myaccounthlight = "";
if(isset($this->params['url']) and $this->params['url']['url']=='/') {
	$homehlight = 'active';
} elseif(isset($this->params['name']) and $this->params['name']=='aboutus') {
	$aboutushlight = 'active';
} elseif(isset($this->params['name']) and $this->params['name']=='services') {
	$serviceshlight = 'active';
} elseif(isset($this->params['name']) and $this->params['name']=='clients') {
	$clientareahlight = 'active';
} elseif(isset($this->params['name']) and $this->params['name']=='notaries') {
	$notarieshlight = 'active';
} elseif(isset($this->params['action']) and $this->params['action']=='contact') {
	$contacthlight = 'active';
} elseif(isset($this->params['action']) and  $this->params['action']=='login') {
	$loginhlight = 'active';
} elseif(isset($this->params['type']) and $this->params['type']=='clients' and $this->params['action']=='myaccount') {
	$myaccounthlight = 'active';
}

$model = ($usersession['Client']['id'] == '') ? 'Notary' : 'Client';
$model_for_myaccount = ($usersession['Client']['id'] == '') ? 'notaries' : 'clients';
?>
<div class="menu_resize">
    <div class="menu">
      	<ul>
<?php
		if(isset($usersession['User']['id']) != '' and $usersession['User']['type'] =='C') {
?>
			<li><?php __($link->spanlink('Dashboard',array('controller'=>'users', 'action'=>'myaccount','type'=>$model_for_myaccount))); ?></li>
			<li><?php __($link->spanlink('Request Notary',array('controller'=>'orders','action'=>'addorder','type'=>$model_for_myaccount))); ?></li>
			<li><?php __($link->spanlink('Current Signings', array('controller'=>'orders','action'=>'index','type'=>$model_for_myaccount))); ?></li>
			<li><?php __($link->spanlink('Invoices', array('controller'=>'invoices','action'=>'index','type'=>$model_for_myaccount))); ?></li>
			<li><?php __($link->spanlink('Tutorials',array('controller'=>'tutorials','action'=>'index','type'=>$model_for_myaccount))); ?></li>
			<li><?php __($link->spanlink('Archived',array('controller'=>'orders','action'=>'archived','type'=>$model_for_myaccount))); ?></li>
			<li><?php __($link->spanlink('Update Account', array('controller'=>'users','action'=>'edit','type'=>$model_for_myaccount))); ?></li>
			<li><?php __($link->spanlink(Configure::read('sitename'),  Configure::read('PARENT_WEB_URL'), array('class'=>$homehlight)));  ?></li>
<?php
     	}
     	if(isset($usersession['User']['id']) == '') { 
?>
			<li><?php __($link->spanlink('Home', Configure::read('PARENT_WEB_URL'), array('class'=>$homehlight))); ?></li>
			<li><?php __($link->spanlink('About Us',Configure::read('PARENT_WEB_URL').'about-us', array('class'=>$aboutushlight))); ?></li>
			<li><?php __($link->spanlink('Services',Configure::read('PARENT_WEB_URL').'services', array('class'=>$serviceshlight))); ?></li>
			<li><?php __($link->spanlink('Clients', Configure::read('PARENT_WEB_URL').'clients', array('class'=>$clientareahlight))); ?></li>
			<li><?php __($link->spanlink('Notaries', Configure::read('PARENT_WEB_URL').'notaries', array('class'=>$notarieshlight))); ?></li>
			<li><?php __($link->spanlink('Contact Us', Configure::read('PARENT_WEB_URL').'contact-us', array('class'=>$contacthlight))); ?></li>
			<li><?php __($link->spanlink('Login', array('controller'=>'users', 'action'=>'login'), array('class'=>$loginhlight))); ?></li>
<?php
     	}
		if(isset($usersession['User']['id']) != '' and $usersession['User']['type'] <>'C') {
?>
			<li><?php __($link->spanlink('Dashboard',array('controller'=>'users', 'action'=>'myaccount','type'=>$model_for_myaccount))); ?></li>
			<li><?php __($link->spanlink('Messages',array('controller'=>'messages','action'=>'index','type'=>$model_for_myaccount))); ?></li>
			<li><?php __($link->spanlink('Current Signings', array('controller'=>'orders','action'=>'index','type'=>$model_for_myaccount))); ?></li>
			
			<li><?php __($link->spanlink('Tutorials',array('controller'=>'tutorials','action'=>'index','type'=>$model_for_myaccount))); ?></li>
			
			<li><?php __($link->spanlink('Archived',array('controller'=>'orders','action'=>'archived','type'=>$model_for_myaccount))); ?></li>
			<li><?php __($link->spanlink('Resources',array('controller'=>'resources','action'=>'index','type'=>$model_for_myaccount))); ?></li>
			
			<li><?php __($link->spanlink('Update Account', array('controller'=>'users','action'=>'edit','type'=>$model_for_myaccount))); ?></li>
			<li><?php __($link->spanlink(Configure::read('sitename'),  Configure::read('PARENT_WEB_URL'), array('class'=>$homehlight)));  ?></li>
<?php
	}
?>
			<li><?php if(isset($usersession['User']['id']) != '') { __($link->spanlink('Logout', array('controller'=>'users', 'action'=>'logout'), array('class'=>''))); } ?></li>
		</ul>
	</div>
</div>