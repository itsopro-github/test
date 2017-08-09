<?php 
$html->addCrumb("Users", array());
if($admindata['Admin']['type']=='S'){
?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Users');?></h1>
			<ul>
		       	<li><?php __($html->link('search','#',array('onclick'=>"loadSearchBox('search');")));?></li>
		      	<li><?php echo $html->link(__('Add new user', true), array('action' => 'add')); ?></li>
	       </ul>
       	</div>
		<div id="searchdiv" <?=(@$_SESSION['search']['params']=='') ? 'style="display:none;"' : 'style="display:block;"'?>>
			<?php echo $form->create('admins',array('action'=>'search'));?>
				<table border="0" cellspacing="0" cellpadding="0" class="search_box">
					<tr> 
						<td>Name</td>
						<td><?php echo $form->input('name', array('class'=>'text small', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['name']));?></td>
						<td>Username</td>
						<td><?php echo $form->input('username', array('class'=>'text small', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['username']));?></td>
						<td>Type</td>
						<td><?php echo $form->input('type', array('class'=>'select_box small', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$admintypeoptions, 'empty'=>'--Select--','selected'=>@$_SESSION['search']['params']['type']));?></td>
						<td>Status</td>
						<td><?php echo $form->input('status', array('class'=>'select_box small', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$statusoptions, 'empty'=>'--Select--','selected'=>@$_SESSION['search']['params']['status']));?></td>
						<td><?php echo $form->submit('Search', array('div'=>false,'class'=>'submit small fleft'));echo $html->link('Clear', array('action'=>'clear'), array('div'=>false,'class'=>'normalbutton fright'),null,false); ?></td>
					</tr>
				</table>
			<?php echo $form->end(); ?>
		</div>
		<?php if($admin) { ?>
       	<div class="block_content">
			<table cellpadding="0" cellspacing="0" class="tablelist">
				<thead>
						<th width="10%">Sl No</th>
						<th width="25%"><?php echo $this->Paginator->sort('name');?></th>
						<th width="15%"><?php echo $this->Paginator->sort('Username','username');?></th>
						<th width="15%"><?php echo $this->Paginator->sort('Type');?></th>
						<th width="10%"><?php echo $this->Paginator->sort('status');?></th>
						<th width="15%"><?php echo $this->Paginator->sort('created');?></th>
						<th width="10%" class="actions"><?php __('Actions');?></th>
				</thead>
				<?php
				$i = 0;
				foreach ($admin as $admins):
					$class = null;
					if ($i++ % 2 != 0) {
						$class = 'class="altrow"';
					}
				?>
				<tr <?php echo $class;?> title="<?php __($admins['Admin']['name']); ?>">
					<td><?php echo $counter->counters($i); ?></td>
					<td><?php echo $admins['Admin']['name']; ?></td>
					<td><?php echo $admins['Admin']['username']; ?></td>
					<td><?php echo $admintypeoptions[$admins['Admin']['type']]; ?></td>
					<td><?php echo $statusoptions[$admins['Admin']['status']]; ?></td>
					<td><?php echo $counter->formatdate('nsdatetime',$admins['Admin']['created']); ?></td>
					<td class="actions">
						
						<?php echo $html->link(__('Edit', true), array('action' => 'edit', $admins['Admin']['id']), array('class'=>'edit_btn', 'title'=>'Edit', 'alt'=>'Edit')); ?>
						<?php echo $html->link(__('Delete', true), array('action' => 'delete', $admins['Admin']['id']), array('class'=>'delete_btn', 'title'=>'Delete', 'alt'=>'Delete'),sprintf('Are you sure you want to delete \''.$admins['Admin']['name'].'\'?', $admins['Admin']['id'])); ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>
		</div>
		<?php __($this->element('pagination')); ?>
		<?php } else { ?>
		<?php __($this->element('nobox')); ?>
		<?php } ?>
	</div>
</div>
<?php
}else{
		__($this->element('nopermission')); 
}?>