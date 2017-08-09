<?php 
	/**********************************************
	*	For highlighting the selected menu
	***********************************************/
	$hlight = $clienthlight = $notarieshlight = $cmghlght = $customershlight = $ordershlight = $invoicehlight = $reportshlight =  $archsignhlight = $messageshlight = $newshlight = $tuthlight = $cphlight = "";
	if($this->params['controller']=='admins' and ($this->params['action']== 'admin_dashboard' or $this->params['action']== 'admin_settings')){
		$hlight = 'class="selected nomarginleft"';
	} elseif($this->params['controller']=='users' && $usertype=='clients'){
		$clienthlight = 'class="selected nomarginleft"';
	} elseif($this->params['controller']=='users' && $usertype=='notaries'){
		$notarieshlight = 'class="selected nomarginleft"';
	} elseif($this->params['controller']=='news'){
		$newshlight = 'class="selected nomarginleft"';
	} elseif($this->params['controller']=='invoices'){
		$invoicehlight = 'class="selected nomarginleft"';
	} elseif($this->params['controller']=='orders' and $this->params['action']=='admin_reports'){
		$reportshlight = 'class="selected nomarginleft"';
	} elseif($this->params['controller']=='orders' and $this->params['action']=='admin_generatedreport'){
		$reportshlight = 'class="selected nomarginleft"';
	} elseif($this->params['controller']=='orders' and (!isset($this->params['status']))){
		$ordershlight = 'class="selected nomarginleft"';
	} elseif($this->params['controller']=='orders' and $this->params['status']=='archived'){
		$archsignhlight = 'class="selected nomarginleft"';
	} elseif($this->params['controller']=='messages'){
		$messageshlight = 'class="selected nomarginleft"';
	} elseif($this->params['controller']=='admins' and $this->params['action']!= 'admin_dashboard' and $this->params['action']!= 'admin_help' and $this->params['action']!= 'admin_settings'){
		$cmghlght = 'class="selected nomarginleft"';
	}
	$admintype = $admindata['Admin']['type'];
?>
<div class="siteNav">
	<ul>
		<li <?php __($hlight); ?>><?php echo $html->link('Home',array('controller'=>'admins','action'=>'dashboard'));?></li>
	    <li <?php __($clienthlight); ?>><?php echo $html->link('Clients',array('controller'=>'users','action'=>'index','type'=>'clients','param'=>'s:n'));?></li>
		<li <?php __($notarieshlight); ?>><?php echo $html->link('Notaries',array('controller'=>'users','action'=>'index','type'=>'notaries','param'=>'s:n'));?> </li>
		<li <?php __($ordershlight); ?>><?php echo $html->link('Orders', array('controller'=>'orders','action'=>'index/s:n'));?></li>
		<?php if($admintype!='E'){?>
		<li <?php __($invoicehlight); ?>><?php echo $html->link('Invoices', array('controller'=>'invoices','action'=>'index/s:n'));?></li>
		<li <?php __($reportshlight); ?>><?php echo $html->link('Reports', array('controller'=>'orders','action'=>'reports','type'=>'requests','param'=>'s:n'));?></li>
		
		<?php }?>
		<li <?php __($archsignhlight); ?>><?php echo $html->link('Archive', array('controller'=>'orders','action'=>'index','status'=>'archived','param'=>'s:n'));?></li>
		<li <?php __($messageshlight); ?>><?php echo $html->link('Messages', array('controller'=>'messages','action'=>'index/s:n'));?></li>
		<li <?php __($newshlight); ?>><?php echo $html->link('News',array('controller'=>'news','action'=>'index/s:n'));?></li>
<?php if($admintype!='E'){?>
		<li>
			<div id="morelinks" title="More Links"></div>
			<div class="morelinksdiv" id="morelinksdiv">
				<div class="header_tag">
					<div onclick="closebox('morelinksdiv');" class="closebtn fright clear" title="Close" alt="Close"><!-- --></div>
					<div>
						<div class="moreli"><?php echo $html->link('Resources', array('controller'=>'resources','action'=>'index','s'=>'n'));?></div>
							<div class="moreli"><?php echo $html->link('Tutorials', array('controller'=>'tutorials','action'=>'index','s'=>'n'));?></div>
							<div class="moreli"><?php echo $html->link('Content Pages', array('controller'=>'contentpages','action'=>'index','s'=>'n'));?></div>
							<div class="moreli"><?php echo $html->link('Users', array('controller'=>'admins','action'=>'index/s:n'));?></div>
					</div>
				</div>
			</div>
		</li>
<?php } ?>
	</ul>
</div>
