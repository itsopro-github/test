<?php
$pagemodel = (isset($pagemodel) == '') ? $this->params['models'][0] : $pagemodel;
if(@$paginator->params['paging'][$pagemodel]['count'] > @$paginator->params['paging'][$pagemodel]['options']['limit']) {
?>
<div class="pagination clear">
	<?php echo $paginator->prev(__('PREV', true), array(), null, array('class'=>'disabled'));?>
  	<?php echo $paginator->numbers(array('separator' => ' '));?>
	<?php echo $paginator->next(__('NEXT', true), array(), null, array('class' => 'disabled'));?>
</div>
<?php
}
?>