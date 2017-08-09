<div class="orders index">
	<div>
		<?php __($html->clean(nl2br($contentpage['Contentpage']['content']))); ?>
	</div>
	<div class="block">
<?php
		if($resourcescategory) {	
			foreach ($resourcescategory as $resourcecategoryid=>$resourcecategory) {
				__($this->element('listresources', array('categoryid'=>$resourcecategoryid,'category'=>$resourcecategory)));
			}
		} else {
			__($this->element('nobox',array('displaytext'=>'No resources available')));
		}
?>
	<div>
</div>
</div>
</div>