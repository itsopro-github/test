<div class="mainBox mainBoxborder curveEdges fleft" style="width:65%;">
	<div class="header"><h1>Quick Shortcuts</h1></div>
	<div class="content">
		<div class="quickShortcut fleft"><?php __($link->spanlink($html->image('dashboard/icn_clients.png', array('alt'=>'Clients management','title'=>'Clients management')), array('controller'=>'users','action'=>'index','type'=>'clients','param'=>'s:n'),null,null,null,'Clients management')); ?></div>
		<div class="quickShortcut fleft"><?php __($link->spanlink($html->image('dashboard/icn_notary.gif',array('alt'=>'Notaries management','title'=>'Notaries management')), array('controller'=>'users','action'=>'index','type'=>'notaries','param'=>'s:n'),null,null,null,'Notaries management')); ?></div>
		<div class="quickShortcut fleft"><?php __($link->spanlink($html->image('dashboard/icn_order.png', array('alt'=>'Orders management','title'=>'Orders management')), array('controller'=>'orders','action'=>'index','s'=>'n'),null,null,null,'Orders management')); ?></div>
<?php if($admindata['Admin']['type']!='E'){?>
		<div class="quickShortcut fleft"><?php __($link->spanlink($html->image('dashboard/icn_invoice.png', array('alt'=>'Invoices management','title'=>'Invoices management')), array('controller'=>'invoices','action'=>'index','s'=>'n'),null,null,null,'Invoices management')); ?></div>
<?php }?>
		<div class="quickShortcut fleft"><?php __($link->spanlink($html->image('dashboard/icn_mail.png', array('alt'=>'Messages management','title'=>'Messages management')), array('controller'=>'messages','action'=>'index','s'=>'n'),null,null,null,'Messages management')); ?></div>
		<div class="quickShortcut fleft"><?php __($link->spanlink($html->image('dashboard/icn_news.png', array('alt'=>'News management','title'=>'News management')), array('controller'=>'news','action'=>'index','s'=>'n'),null,null,null,'News management')); ?></div>
		<div class="quickShortcut fleft"><?php __($link->spanlink($html->image('dashboard/icn_reports.png', array('alt'=>'Reports management','title'=>'Reports management')), array('controller'=>'orders','action'=>'reports','param'=>'s:n'),null,null,null,'Reports management')); ?></div>
		<div class="quickShortcut fleft"><?php __($link->spanlink($html->image('dashboard/icn_resources.png', array('alt'=>'Resources management','title'=>'Resources management')), array('controller'=>'resources','action'=>'index','s'=>'n'),null,null,null,'Resources management')); ?></div>
		<div class="quickShortcut fleft"><?php __($link->spanlink($html->image('dashboard/icn_tutorials.png', array('alt'=>'Tutorials management','title'=>'Tutorials management')), array('controller'=>'tutorials','action'=>'index','s'=>'n'),null,null,null,'Tutorials management')); ?></div>
		<div class="quickShortcut fleft"><?php __($link->spanlink($html->image('dashboard/icn_text.png', array('alt'=>'Content page management','title'=>'Content page management')), array('controller'=>'contentpages','action'=>'index','s'=>'n'),null,null,null,'Content page management')); ?></div>
		<div class="quickShortcut fleft"><?php __($link->spanlink($html->image('dashboard/icn_security.png', array('alt'=>'Administrator security management','title'=>'Administrator security management')), array('controller'=>'admins','action'=>'settings'),null,null,null,'Administrator security settings')); ?></div>
<?php if($admindata['Admin']['type']=='S'){?>
		<div class="quickShortcut fleft"><?php __($link->spanlink($html->image('dashboard/icn_user.png', array('alt'=>'Manage users','title'=>'Manage users')), array('controller'=>'admins','action'=>'index/s:n'),null,null,null,'Manage users')); ?></div>
<?php }?>
		<div class="quickShortcut fleft"><?php __($link->spanlink($html->image('dashboard/icn_help.png', array('alt'=>'Administrator helpdesk','title'=>'Administrator helpdesk')), array('controller'=>'admins','action'=>'help'),null,null,null,'Administrator helpdesk')); ?></div>
	</div>
</div>
<div class="mainBox subBoxborder fright" style="width:31%;">
	<div class="header"><h1>New Requests</h1></div>
	<?php
	$i = $top = $med = $low = 0;
	if(count($ordercount) > 0) {
		foreach ($ordercount as $countval){
			$min = $countval[0]['timeleft'];
			if($min<45 && $min>30) {
				$top +=1;
			} elseif ($min<30 && $min>15) {
				$med +=1;
			} elseif ($min<15) {
				$low +=1;
			}
			$i++;
		}
	}
	?>
	<div class="block" style="margin-bottom:0px !important">
		<div class="block_content">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			  <tbody>
				  <tr>
				     <td><span style="float:left;color:#D3390B">Requests 15 minutes left: <?php echo $top.'</span><span style="float:right;padding-left:15px;">'.$html->link('View',array('controller'=>'orders','action'=>'index','top'=>'top'),array('class'=>'view_btn','title'=>'View requests 15 minutes left','alt'=>'View requests 15 minutes left'));?></span></td>
				    </tr>
				    <tr>
				    	<td><span style="color:#133FA2">Requests 30 minutes left: <?php echo $med.'</span><span style="float:right;padding-left:15px;">'.$html->link('View', array('controller'=>'orders','action'=>'index','medium'=>'medium'), array('class'=>'view_btn','title'=>'View requests 30 minutes left','alt'=>'View requests 30 minutes left'));?></span></td>
				    </tr>
				    <tr>
				    	<td><span style="color:#4B7413">Requests 45 minutes left: <?php echo $low.'</span><span style="float:right;padding-left:15px;">'.$html->link('View',array('controller'=>'orders','action'=>'index','low'=>'low'),array('class'=>'view_btn','title'=>'View requests 45 minutes left','alt'=>'View requests 45 minutes left'));?></span></td>
				    </tr>
				  </tbody>
			 </table>
		</div>
	</div>
</div>
<?php if($admindata['Admin']['type']=='S') { ?>
<div class="mainBox subBoxborder fright" style="width:31%;">
	<div class="header"><h1>SMS Settings</h1></div>
	<div class="block" style="margin-bottom:0px !important">
		<div class="block_content">
			<?php __($form->create('Admin', array('action'=>'notary'))); ?>
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			  <tbody>
				  <tr>
				     <td># of notaries who will recieve SMS - <b><?php __($notariescnt['Msgsetting']['notarycount']); ?></b>
				     	<?php __($html->image('btn_edit.png', array('onclick'=>'updateNotary()','class'=>'edit_btn', 'title'=>'Update # of notaries', 'alt'=>'Update # of notaries', 'style'=>'float:right;cursor:pointer;'))); ?>
				     	<div id="msgcnt" style="display: none;">
				     	<p><?php __($form->input('notarycount', array('value'=>$notariescnt['Msgsetting']['notarycount'],'error'=>false,'div'=>false,'label'=>false,'class'=>'text small')));?>
							<?php __($form->submit('Update', array('div'=>false,'class'=>'submit'))); ?></p>
						</div>
					</td>
				  </tr>
				  <tr>
				     <td>Last updated by <b><?php __($notariescnt['Msgsetting']['lastupdated']); ?></b></td>
				  </tr>
				  <tr>
				     <td>Last updated on <b><?php __($counter->formatdate('nsdatetimemeridiem',$notariescnt['Msgsetting']['modified'])); ?></b></td>
				  </tr>
			  </tbody>
			</table>
			<?php __($form->end()); ?>
		</div>
	</div>
</div>
<?php } ?>
<div class="mainBox subBoxborder fright" style="width:31%;">
	<div class="header"><h1>More Information</h1></div>
	<div class="block" style="margin-bottom:0px !important">
		<div class="block_content">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			  <tbody>
				  <tr>
				     <td>You are logged in as <b><?php __($loggedindata['Admin']['name']); ?></b></td>
				  </tr>
				  <tr>
				     <td>Last logged in <b><?php __($counter->formatdate('nsdatetimemeridiem',$loggedindata['Admin']['lastlogin'])); ?></b></td>
				  </tr>
			  </tbody>
			</table>
		</div>
	</div>
</div>
