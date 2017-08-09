<?php $html->addCrumb("News", array('controller'=>'news','action'=>'index'));?>
<?php $html->addCrumb($news['News']['title'], array());?> 
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __($news['News']['title']);?></h1>
			<ul>
		      	<li><?php echo $html->link(__('List news', true), array('action' => 'index')); ?></li>
		      	<li><?php echo $html->link(__('Edit this news', true), array('action' => 'edit',$news['News']['id'])); ?></li>
	       </ul>
       	</div>
		<div class="block_content fleft" style="width:64%;">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			  <tr>
			     <th><?php __('Title'); ?></th>
			     <td><?php echo $news['News']['title']; ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Image'); ?></th>
			     <td><?php __($html->image(Configure::read('WEB_URL').Configure::read('NEWS_THUMB_IMAGE_PATH').$news['News']['image'],array('alt'=>$news['News']['title'], 'title'=>$news['News']['title']))); ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Description'); ?></th>
			     <td><?php echo $news['News']['description']; ?></td>
			  </tr>
			  </table>
		</div>
		<div class="mainBox subBoxborder fleft" style="width:31%;">
			<div class="header"><h1>More Information</h1></div>
			<div class="block_content">
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
				   <tr>
			     <th><?php __('Added by'); ?></th>
			     <td><?php echo $news['News']['addedby']; ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Status'); ?></th>
			     <td><?php echo $statusoptions[$news['News']['status']]; ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Created'); ?></th>
			     <td><?php echo $counter->formatdate('nsdatetimemeridiem',$news['News']['created']); ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Modified'); ?></th>
			     <td ><?php echo $counter->formatdate('nsdatetimemeridiem',$news['News']['modified']); ?></td>
			  </tr>
			  </table>
			</div>
		</div>
	</div>
</div>
