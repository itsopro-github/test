<?php $html->addCrumb("Content pages", array('controller'=>'contentpages','action'=>'index'));?><?php $html->addCrumb($contentpage['Contentpage']['name'], array());?> 
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __($contentpage['Contentpage']['name']);?></h1>
			<ul>
		      	<li><?php echo $html->link(__('List content pages', true), array('action' => 'index')); ?></li>
		      	<li><?php echo $html->link(__('Edit this page', true), array('action' => 'edit',$contentpage['Contentpage']['id'])); ?></li>
	       </ul>
       	</div>
		<div class="block_content fleft" style="width:64%;">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			  <tr>
			     <th width="20%"><?php __('Name'); ?></th>
			     <td><?php echo $contentpage['Contentpage']['name']; ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Page Title'); ?></th>
			     <td><?php echo $contentpage['Contentpage']['pagetitle']; ?></td>
			  </tr>
			   <tr>
			     <th><?php __('Keywords'); ?></th>
			     <td><?php echo $contentpage['Contentpage']['metakey']; ?></td>
			  </tr>
			   <tr>
			     <th><?php __('Description'); ?></th>
			     <td><?php echo $contentpage['Contentpage']['metadesc']; ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Content'); ?></th>
			     <td><?php echo nl2br($contentpage['Contentpage']['content']); ?></td>
			  </tr>
			  </table>
		</div>
		<div class="mainBox subBoxborder fleft" style="width:31%;">
			<div class="header"><h1>More Information</h1></div>
			<div class="block_content">
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
				 <tr>
			     <th><?php __('Status'); ?></th>
			     <td><?php echo $statusoptions[$contentpage['Contentpage']['status']]; ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Created'); ?></th>
			     <td><?php echo $counter->formatdate('nsdatetimemeridiem',$contentpage['Contentpage']['created']); ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Modified'); ?></th>
			     <td ><?php echo $counter->formatdate('nsdatetimemeridiem',$contentpage['Contentpage']['modified']); ?></td>
			  </tr>
			  </table>
			</div>
		</div>
	</div>
</div>