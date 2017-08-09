<?php
if(!isset($searchresults) and empty($searchresults)) {
?>
<p></p>
<div class="form">
	<div>
		<?php __($form->create('Order',array('url'=>array('controller'=>'orders','action'=>'search')))); ?>
		<div class="form_block required"><p><label class="form_label">First Name<span class="mandatory">*</span></label><?php __($form->input('first_name',array('error'=>false,'label'=>false,'id'=>'FirstName','class'=>'text_box'))); ?></p></div>
		<?php __($form->submit('Search', array('class'=>'submitbtn fleft')));	__($form->end()); ?>
	</div>
</div>
<?php
} else {
?>
<div class="orders index">
	<div class="block">
<?php
		if(isset($_SESSION['signings']) and $_SESSION['signings'] != '') {
			__($this->element('listorders', array('orders'=>$searchresults,'ordertitle'=>'search results','statusid'=>'1')));
		}
?>		
		<?php __($this->element('pagination')); ?>
	</div>
</div>
<?php
}
?>