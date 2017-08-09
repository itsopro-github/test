<?php $html->addCrumb("Resources", array('controller'=>'resources','action'=>'index'));?><?php $html->addCrumb($resource['Resource']['title'], array());?> 
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __($resource['Resource']['title']);?></h1>
			<ul>
		      	<li><?php echo $html->link(__('List resources', true), array('action' => 'index')); ?></li>
		      	<li><?php echo $html->link(__('Edit this resource', true), array('action' => 'edit',$resource['Resource']['id'])); ?></li>
	       </ul>
       	</div>
		<div class="block_content fleft" style="width:64%;">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<th width="30%"><?php __('Title'); ?></th>
					<td><?php echo $resource['Resource']['title']; ?></td>
				</tr>
				<tr>
					<th><?php __('Resource file'); ?></th>
					<td><?php __($html->link($resource['Resource']['resourcefile'], Configure::read('WEB_URL').Configure::read('RESOURCE_PATH').$resource['Resource']['resourcefile'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Description'); ?></th>
					<td><?php echo $resource['Resource']['description']; ?></td>
				</tr>
				<tr>
					<th><?php __('Help link'); ?></th>
					<td><?php echo $resource['Resource']['helplink']; ?></td>
				</tr>
				<tr>
					<th><?php __('Category'); ?></th>
					<td><?php echo $resourcescategory[$resource['Resource']['category']]; ?></td>
				</tr>
			</table>
		</div>
		<div class="mainBox subBoxborder fleft" style="width:31%;">
			<div class="header"><h1>More Information</h1></div>
			<div class="block_content">
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
					<tr>
						<th width="30%"><?php __('Added by'); ?></th>
						<td><?php echo $resource['Resource']['addedby']; ?></td>
					</tr>
					<tr>
						<th><?php __('Status'); ?></th>
						<td><?php echo $statusoptions[$resource['Resource']['status']]; ?></td>
					</tr>
					<tr>
						<th><?php __('Created'); ?></th>
						<td><?php echo $counter->formatdate('nsdatetimemeridiem',$resource['Resource']['created']); ?></td>
					</tr>
					<tr>
						<th><?php __('Modified'); ?></th>
						<td><?php echo $counter->formatdate('nsdatetimemeridiem',$resource['Resource']['modified']); ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
