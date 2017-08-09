<?php
	$paginator->options(array('url'=>array_merge(array('type'=>$usertype),$this->passedArgs)));
	if($usertype=='Notary'){
		$usertype='notaries';
	}
	if($usertype=='Client'){
		$usertype='clients';
	}
	$html->addCrumb(ucfirst($usertype), array());?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __(ucfirst($usertype));?></h1>
			<ul>
		       	<li><?php __($html->link('import','#',array('onclick'=>"loadBlock('importdiv');")));?></li>
		      	<li><?php __($html->link('search','#',array('onclick'=>"loadSearchBox('search');")));?></li>
		      	<li><?php echo $html->link(__('Add new '.Inflector::singularize(ucfirst($usertype)), true), array('controller'=>'users','action'=>'add','type'=>$usertype)); ?></li>
	       </ul>
       	</div>
		<div id="importdiv" <?=(@$this->params['named']['s']=='') ? 'style="display:none;"' : 'style="display:block;"'?>>
			<?php echo $form->create('User',array('action'=>'import','enctype'=>'multipart/form-data'));?>
				<table border="0" cellspacing="0" cellpadding="0" class="search_box">
					<tr> 
						<td width="20%">Upload the file to be imported</td>
						<td><?php echo $form->hidden('importype', array('value'=>$usertype));?><?php echo $form->input('importfile', array('class'=>'text', 'maxlength'=>'50','type'=> 'file', 'error'=>false, 'label'=>false, 'div'=>false));?></td>
						<td colspan="7"><?php echo $form->submit('Submit', array('div'=>false,'class'=>'submit small fleft'));echo $html->link('Cancel', '#', array('div'=>false, 'class'=>'normalbutton fleft', 'onclick'=>"loadBlock('importdiv');"),null,false); ?></td>
					</tr>
				</table>
			<?php echo $form->end();?>
		</div>
		<div id="searchdiv" <?=(@$_SESSION['search']['params']=='') ? 'style="display:none;"' : 'style="display:block;"'?>>
			<?php echo $form->create('User',array('controller'=>'users','action'=>'search'));?>
				<table border="0" cellspacing="0" cellpadding="0" class="search_box">
					<tr> 
						<td>Name</td>
						<td><?php echo $form->input('name', array('class'=>'text medium', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['name']));?></td>
<?php if($usertype=='clients') { ?>
						<td>Company</td>
						<td><?php echo $form->input('company', array('class'=>'text medium', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['company']));?></td>
<?php }?>
						<td>City</td>
						<td><?php echo $form->input('of_city', array('class'=>'text medium', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['of_city']));?></td>
						<td>State</td>
						<td><?php __($form->input('of_state', array('id'=>'OfficeState','label'=>false,'class'=>'select_box smedium','options'=>$states, 'value'=>@$_SESSION['search']['params']['of_state'],'empty'=>'All')));?></td>
					</tr>
					<tr>	
						<?php if($usertype=='notaries') { ?>
						<td>Zip code covered</td>
						<td><?php echo $form->input('zipcode', array('class'=>'text medium', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['zipcode']));?></td>
						<?php }?>
						<td>Email address</td>
						<td><?php echo $form->input('email', array('class'=>'text medium', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['email']));?></td>
					
						<?php echo $form->hidden('type', array('id' => 'type', 'value' => $usertype));?>
						<?php echo $form->hidden('model', array('id' => 'type', 'value' => $usermodel));?>
						<td>Status</td>
						<td><?php echo $form->input('status', array('class'=>'select_box smedium', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$statusoptns,'empty'=>'--Select--','selected'=>@$_SESSION['search']['params']['status']));?></td>
<?php if($usertype=='notaries') { ?>
					</tr>
					<tr>	
						<td>Language</td>
						<td><?php echo $form->input('languages', array('class'=>'select_box smedium', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$langoptions,'empty'=>'--Select--','selected'=>@$_SESSION['search']['params']['languages']));?></td>
						<td>Work with an attorney</td>
						<td><?php echo $form->input('attorney', array('class'=>'select_box smedium', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$yesnooptions,'empty'=>'--Select--','selected'=>@$_SESSION['search']['params']['attorney']));?></td>
						<td colspan="7"><?php echo $form->submit('Search', array('div'=>false,'class'=>'submit small fleft'));echo $html->link('Clear', array('action'=>'clear'), array('div'=>false,'class'=>'normalbutton fleft'),null,false); ?></td>
<?php } else { ?>
						<td colspan="8"><?php echo $form->submit('Search', array('div'=>false,'class'=>'submit small fleft'));echo $html->link('Clear', array('action'=>'clear'), array('div'=>false,'class'=>'normalbutton fleft'),null,false); ?></td>
<?php } ?>
					</tr>
				</table>
			<?php echo $form->end(); ?>
		</div>
<?php if($users) { ?>
<?php echo $form->create('User',array('action'=>'export'),array('id'=>'frminvoice'));?>
		<input type='hidden' name='checkmodel' value='<?=$usermodel?>'>
       	<div class="block_content">
			<table cellpadding="0" cellspacing="0" class="tablelist">
				<thead>
					<th width="5%">Sl No</th>
					<th width="3%"><input type='checkbox' name='checkall' onclick="checkedAll('UserExportForm');"></th>
					<th width="17%"><?php echo $this->Paginator->sort('Name',$usermodel.'.first_name');?></th>
<?php if($usertype=='clients') { ?>
					<th width="20%"><?php echo $this->Paginator->sort('Company',$usermodel.'.company');?></th>
<?php } ?>					
					<th width="12%"><?php echo $this->Paginator->sort('Username','User.username');?></th>
<?php if($usertype=='clients') { ?>
					<th width="16%"><?php echo $this->Paginator->sort('Zip code',$usermodel.'.of_zip');?></th>
<?php } if($usertype=='notaries') { ?>
					<th width="26%"><?php echo $this->Paginator->sort('Zip code ',$usermodel.'.zipcode');?></th>
<?php } if($usertype=='notaries') { ?>
					<th width="10%"><?php echo $this->Paginator->sort('Type',$usermodel.'.userstatus');?></th>
<?php } ?>
					<th width="6%"><?php echo $this->Paginator->sort('Status','User.status');?></th>
					<th width="12%"><?php echo $this->Paginator->sort('Created','User.created');?></th>
					<th width="9%" class="actions"><?php __('Actions');?></th>
				</thead>
<?php
				$i = 0;
				foreach ($users as $user):
					$class = null;
					if ($i++ % 2 != 0) {
						$class = 'class="altrow"';
					}
?>
				<tr <?php echo $class;?> title="<?php __($user[$usermodel]['first_name']." ".$user[$usermodel]['last_name']); ?>">
					<td><?php __($counter->counters($i)); ?></td>
					<td><input type="checkbox" name="data[User][chkb][]" value="<?php echo $user['User']['id']?>"></td>
					<td><?php __($user[$usermodel]['first_name'].' '.$user[$usermodel]['last_name']) ?></td>
<?php if($usertype=='clients') { ?>
					<td><?php __($user[$usermodel]['company']); ?></td>
<?php } ?>					
					<td><?php __($user['User']['username']); ?></td>
<?php if($usertype=='clients') { ?>
					<td><?php __(str_replace('|', ', ', $user[$usermodel]['of_zip'])); ?></td>
<?php } if($usertype=='notaries') {  ?>
					<td><?php __(str_replace('|', ', ', $user[$usermodel]['zipcode'])); ?></td>
<?php } if($usertype=='notaries') { ?>
					<td><?php if($user[$usermodel]['userstatus']<>"") { __($notaryoptions[$user[$usermodel]['userstatus']]); }  ?></td>
<?php } ?>
					<td><?php __($statusoptns[$user['User']['status']]); ?></td>
					<td> <?php if($user['User']['created']<>'0000-00-00 00:00:00') { __($counter->formatdate('nsdatetimemeridiem',$user['User']['created'])); } ?></td>
					<td class="actions">
						<?php __($html->link(__('View', true), array('action'=>'view','type'=>$usertype,'id'=>$user['User']['id']), array('class'=>'view_btn', 'title'=>'View', 'alt'=>'View'))); ?>
						<?php __($html->link(__('Edit', true), array('action'=>'edit','type'=>$usertype,'id'=>$user['User']['id']), array('class'=>'edit_btn', 'title'=>'Edit', 'alt'=>'Edit'))); ?>
						<?php __($html->link(__('Delete', true), array('action'=>'delete','type'=>$usertype,'id'=>$user['User']['id']), array('class'=>'delete_btn', 'title'=>'Delete', 'alt'=>'Delete'),sprintf('Are you sure you want to delete \''.$user[$usermodel]['first_name'].' '.$user[$usermodel]['last_name'].'\'?', $user['User']['id']))); ?>
					</td>
				</tr>
<?php endforeach; ?>
			</table>
			<?php echo $form->submit('Export', array('div'=>false,'class'=>'submit small fleft'));?>
			<?php echo $form->end(); ?>
		</div>
		<?php __($this->element('pagination')); ?>
		<?php } else { ?>
		<?php __($this->element('nobox')); ?>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">checked=false;function checkedAll(UserExportForm) {var chk= document.getElementById('UserExportForm');if (checked == false){checked = true}else{checked = false}for (var i =0; i < chk.elements.length; i++) {chk.elements[i].checked = checked;}}</script>