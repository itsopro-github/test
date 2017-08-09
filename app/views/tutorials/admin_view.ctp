<?php $html->addCrumb("Tutorials", array('controller'=>'tutorials','action'=>'index'));?><?php $html->addCrumb($tutorial['Tutorial']['title'], array());?> 
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __($tutorial['Tutorial']['title']);?></h1>
			<ul>
		      	<li><?php echo $html->link(__('List tutorials', true), array('action' => 'index')); ?></li>
		      	<li><?php echo $html->link(__('Edit this tutorial', true), array('action' => 'edit',$tutorial['Tutorial']['id'])); ?></li>
	       </ul>
       	</div>
		<div class="block_content fleft" style="width:64%;">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			  <tr>
			     <th width="30%"><?php __('Title'); ?></th>
			     <td><?php echo $tutorial['Tutorial']['title']; ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Tutorial'); ?></th>
			     <td><object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="400" height="250"><param name="movie" value="<?php __(Configure::read('WEB_URL'));?>img/player.swf" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="flashvars" value="file=<?php __(Configure::read('WEB_URL').Configure::read('TUTORIAL_PATH').$tutorial['Tutorial']['tutorialfile']); ?>&image=<?php __(Configure::read('WEB_URL')); ?>img/logo.png" /><embed type="application/x-shockwave-flash" id="player2" name="player2" src="<?php __(Configure::read('WEB_URL'));?>img/player.swf" width="400" height="250" allowscriptaccess="always" allowfullscreen="true" flashvars="file=<?php __(Configure::read('WEB_URL').Configure::read('TUTORIAL_PATH').$tutorial['Tutorial']['tutorialfile']); ?>&image=<?php __(Configure::read('WEB_URL')); ?>img/logo.png" /></object><br /><?php __($tutorial['Tutorial']['tutorialfile']); ?></td>
			  </tr>
			  <tr>
			     <th><?php __('Description'); ?></th>
			     <td><?php echo $tutorial['Tutorial']['description']; ?></td>
			  </tr>
			   <tr>
			     <th><?php __('Category'); ?></th>
			     <td><?php echo $useroptions[$tutorial['Tutorial']['category']]; ?></td>
			  </tr>
			  
			  </table>
		</div>
		<div class="mainBox subBoxborder fleft" style="width:31%;">
			<div class="header"><h1>More Information</h1></div>
			<div class="block_content">
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
				  <tr>
				     <th width="30%"><?php __('Added by'); ?></th>
				     <td><?php echo $tutorial['Tutorial']['addedby']; ?></td>
				  </tr>
				  <tr>
				     <th><?php __('Status'); ?></th>
				     <td><?php echo $statusoptions[$tutorial['Tutorial']['status']]; ?></td>
				  </tr>
				  <tr>
				     <th><?php __('Created'); ?></th>
				     <td><?php echo $counter->formatdate('nsdatetime',$tutorial['Tutorial']['created']); ?></td>
				  </tr>
				  <tr>
				     <th><?php __('Modified'); ?></th>
				     <td ><?php echo $counter->formatdate('nsdatetime',$tutorial['Tutorial']['modified']); ?></td>
				  </tr>
			  </table>
			</div>
		</div>
	</div>
</div>
