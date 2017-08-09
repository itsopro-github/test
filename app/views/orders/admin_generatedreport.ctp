<?php 
if(isset($title)) {
	$html->addCrumb("Reports", array('controller'=>'orders','admin'=>'1','action'=>'reports','type'=>'requests'));
	$html->addCrumb("$title", array());
} else {
	$html->addCrumb("Reports", array());
}
?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
	<div class="header">
		<h1 class="fleft"><?php __('Reports');?></h1>
       	<ul>
       		<li><?php __($html->link('Print','#',array('onclick'=>"javascript:window.print();"))); ?></li>
		</ul>
	</div>
	<?php __($this->element('admin/reportorder', array('ordertitle'=>' Result','statusid'=>range(1, 10, 1),'classappend'=>substr(Inflector::slug(low(crypt('SCHEDULED', Configure::read('Security.salt'))), ''),0,4)))); ?>
	</div>
</div>
