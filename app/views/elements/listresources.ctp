<div class="titler">
	<div class="title"><h3 class="fleft"><?php __($category); ?></h3></div>
	<div class="titleactions"></div>
</div>
<?php
	$resourceexist = false;
	$j=0;
	foreach ($resources as $resource):
		if($resource['Resource']['category'] == $categoryid){
			$resourceexist = true;
			if($j==0) {
?>
			<table cellpadding="0" cellspacing="0" class="tablelist">
				<thead>
					<th width="10%">Sl No</th>
					<th width="30%">Resource available</th>
					<th width="50%">Description</th>
					<th width="10%"></th>
				</thead>
<?php
			}
			$class = null;
			if ($j++ % 2 == 0) {$class = ' class="altrow"';}
?>	
				<tr <?php __($class);?>>
					<td><?php __($counter->counters($j)); ?></td>
					<td><?php 	if(!empty($resource['Resource']['helplink'])){
					$help_url=$resource['Resource']['helplink'];
					if (false === strpos($help_url, '://')) {
					    $help_url = 'http://' . $help_url;
					}

					__($html->link($resource['Resource']['title'], $help_url, array('target'=>'_blank'))); 
					}else{
						if(!empty($resource['Resource']['resourcefile'])) {
					__($html->link($resource['Resource']['title'],array('controller'=>'resources','action'=>'download',$resource['Resource']['resourcefile']), array('target'=>'_blank'))); 
						}}?>
					</td>
					<td><?php __($resource['Resource']['description']); ?></td>
					<td><?php if(!empty($resource['Resource']['resourcefile'])) {
						__($html->link(__('',true),array('controller'=>'resources','action'=>'download',$resource['Resource']['resourcefile']),array('class'=>'dnld_btn','alt'=>'Download','title'=>'Download'))); } ?>
		</td>		</tr>
<?php
		} 
	endforeach;
	if($j!=0) {
?>		
			</table>
<?php
	}
	if(!$resourceexist) {
		__($this->element('nobox', array('displaytext'=>'No resources found')));
	}
?>
</table>

