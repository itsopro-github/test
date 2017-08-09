<div class="orders index">
	<p><?php __($content['Contentpage']['content']); ?></p>
	<div class="block">
		<?php __($html->link(__('I agree', true), array('controller'=>'orders','action'=>'terms',$Orderid,'yes'), array('class'=>'cancel','title'=>'Agree','alt'=>'Agree'))); ?>
		<?php __($html->link(__('I do not agree', true), array('controller'=>'orders','action'=>'terms',$Orderid,'no'), array('class'=>'cancel','title'=>'Cancel','alt'=>'Cancel'))); ?>
	</div>
</div>