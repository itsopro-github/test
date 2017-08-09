<?php $html->addCrumb("News", array());?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('News');?></h1>
			<ul>
		       	<li><?php __($html->link('search','#',array('onclick'=>"loadSearchBox('search');")));?></li>
		      	<li><?php echo $html->link(__('Add news', true), array('action' => 'add')); ?></li>
	       </ul>
       	</div>
		<!--SEARCH - start-->
		<div id="searchdiv" <?=(@$_SESSION['search']['params']=='') ? 'style="display:none;"' : 'style="display:block;"'?>>
			<?php echo $form->create('News',array('action'=>'search'));?>
				<table border="0" cellspacing="0" cellpadding="0" class="search_box">
					<tr> 
						<td>Title</td>
						<td><?php echo $form->input('title', array('class'=>'text', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false, 'value'=>@$_SESSION['search']['params']['title']));?></td>
						<td><?php echo $html->link('Clear', array('action'=>'clear'), array('div'=>false,'class'=>'normalbutton fright'),null,false);echo $form->submit('Search', array('div'=>false,'class'=>'submit small fright')); ?></td>
					</tr>
				</table>
			<?php echo $form->end(); ?>
		</div>
		<!--SEARCH - end-->	
		<?php if($news) { ?>
       	<div class="block_content">
			<table cellpadding="0" cellspacing="0" class="tablelist">
				<thead>
						<th width="5%">Sl No</th>
						<th width="40%"><?php echo $paginator->sort('title');?></th>
						<th width="10%"><?php echo $paginator->sort('Added by','addedby');?></th>
						<th width="10%"><?php echo $paginator->sort('status');?></th>
						<th width="15%"><?php echo $paginator->sort('created');?></th>
						<th width="10%" class="actions"><?php __('Actions');?></th>
				</thead>
				<?php
				$i = 0;
				foreach ($news as $newnews):
					$class = null;
					if ($i++ % 2 != 0) {
						$class = 'class="altrow"';
					}
				?>
				<tr <?php echo $class;?> title="<?php __($newnews['News']['title']); ?>">
					<td><?php echo $counter->counters($i); ?></td>
					<td><?php echo $newnews['News']['title']; ?></td>
					<td><?php echo $newnews['News']['addedby']; ?></td>
					<td><?php echo $statusoptions[$newnews['News']['status']]; ?></td>
					<td><?php echo $counter->formatdate('nsdatetimemeridiem',$newnews['News']['created']); ?></td>
					<td class="actions">
						<?php echo $html->link(__('View', true), array('action' => 'view', $newnews['News']['id']), array('class'=>'view_btn', 'title'=>'View', 'alt'=>'View')); ?>
						<?php echo $html->link(__('Edit', true), array('action' => 'edit', $newnews['News']['id']), array('class'=>'edit_btn', 'title'=>'Edit', 'alt'=>'Edit')); ?>
						<?php echo $html->link(__('Delete', true), array('action' => 'delete', $newnews['News']['id']), array('class'=>'delete_btn', 'title'=>'Delete', 'alt'=>'Delete'),sprintf('Are you sure you want to delete \''.$newnews['News']['title'].'\'?', $newnews['News']['id'])); ?>
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