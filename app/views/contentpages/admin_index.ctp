<?php $html->addCrumb("Content pages", array());?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Content pages');?></h1>
			<ul>
		       	<li><?php __($html->link('search','#',array('onclick'=>"loadSearchBox('search');")));?></li>
		      	<li><?php echo $html->link(__('Add new page', true), array('action' => 'add')); ?></li>
	       </ul>
       	</div>
		<!--SEARCH - start-->
		<div id="searchdiv" <?=(@$_SESSION['search']['params']=='') ? 'style="display:none;"' : 'style="display:block;"'?>>
			<?php echo $form->create('Contentpage',array('action'=>'search'));?>
				<table border="0" cellspacing="0" cellpadding="0" class="search_box">
					<tr> 
						<td>Name</td>
						<td><?php echo $form->input('name', array('class'=>'text', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['name']));?></td>
						<td>Title</td>
						<td><?php echo $form->input('pagetitle', array('class'=>'text', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['pagetitle']));?></td>
						<td><?php echo $form->submit('Search', array('div'=>false,'class'=>'submit small fleft'));echo $html->link('Clear', array('action'=>'clear'), array('div'=>false,'class'=>'normalbutton fright'),null,false); ?></td>
					</tr>
				</table>
			<?php echo $form->end(); ?>
		</div>
		<!--SEARCH - end-->	
		<?php if($contentpages) { ?>
       	<div class="block_content">
			<table cellpadding="0" cellspacing="0" class="tablelist">
				<thead>
					<th width="7%">Sl No</th>
					<th width="32%"><?php echo $this->Paginator->sort('name');?></th>
					<th width="25%"><?php echo $this->Paginator->sort('Page title', 'pagetitle');?></th>
					<th width="10%"><?php echo $this->Paginator->sort('status');?></th>
					<th width="17%"><?php echo $this->Paginator->sort('created');?></th>
					<th width="8%" class="actions"><?php __('Actions');?></th>
				</thead>
				<?php
				$i = 0;
				foreach ($contentpages as $contentpage):
					$class = null;
					if ($i++ % 2 != 0) {
						$class = 'class="altrow"';
					}
				?>
				<tr <?php echo $class;?> title="<?php __($contentpage['Contentpage']['name']); ?>">
					<td><?php echo $counter->counters($i); ?></td>
					<td><?php echo $contentpage['Contentpage']['name']; ?></td>
					<td><?php echo $contentpage['Contentpage']['pagetitle']; ?></td>
					<td><?php echo $statusoptions[$contentpage['Contentpage']['status']]; ?></td>
					<td><?php echo $counter->formatdate('nsdatetimemeridiem',$contentpage['Contentpage']['created']); ?></td>
					<td class="actions">
						<?php echo $html->link(__('View', true), array('action' => 'view', $contentpage['Contentpage']['id']), array('class'=>'view_btn', 'title'=>'View', 'alt'=>'View')); ?>
						<?php echo $html->link(__('Edit', true), array('action' => 'edit', $contentpage['Contentpage']['id']), array('class'=>'edit_btn', 'title'=>'Edit', 'alt'=>'Edit')); ?>
						<?php echo $html->link(__('Delete', true), array('action' => 'delete', $contentpage['Contentpage']['id']), array('class'=>'delete_btn', 'title'=>'Delete', 'alt'=>'Delete'),sprintf('Are you sure you want to delete \''.$contentpage['Contentpage']['name'].'\'?', $contentpage['Contentpage']['id'])); ?>
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