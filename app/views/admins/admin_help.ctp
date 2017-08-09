<?php 
	$html->addCrumb("Helpdesk", array());
?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft"><?php __('Helpdesk');?></h1>
			<ul>
		       	<li></li>
	       </ul>
       	</div>
       	<div class="content"><?php __(nl2br(@$helptext['Contentpage']['content'])); ?></div>
	</div>
</div>