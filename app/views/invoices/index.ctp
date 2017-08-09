<div class="orders index">
	<div>
		<?php __($html->clean(nl2br($contentpage['Contentpage']['content']))); ?>
	</div>
	<div class="block">
<?php	__($this->element('listinvoices', array('ordertitle'=>'','statusid'=>'7')));?>
	</div>
</div>