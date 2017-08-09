<?php $paginator->options(array('url' => $this->passedArgs));?> 
<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php e($javascript->link('ui.datepicker')); ?>
<script type="text/javascript">$(function(){$('#DateOfSigning').datepicker();});</script>
<?php
	$html->addCrumb("Invoices", array());
	$result = $this->Session->read('WBSWAdmin');
	$admintype = $result['Admin']['type'];
	if($admintype!='E') { 
?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header">
			<h1 class="fleft"><?php __('Invoices');?></h1>
			<ul><li><?php __($html->link('search', '#', array('onclick' => "loadSearchBox('search');"))); ?></li></ul>
       	</div>
       	<!--SEARCH - start-->
		<div id="searchdiv" <?= (@$_SESSION['search']['params'] == '') ? 'style="display:none;"' : 'style="display:block;"' ?>>
			<?php echo $form->create('Orders', array('action' => 'invoices')); ?>
			<table border="0" cellspacing="0" cellpadding="0" class="search_box">
				<tr>
					<td>First Name</td>
					<td><?php echo $form->input('first_name', array('class' => 'text small', 'error' => false, 'label' => false, 'div' => false, 'id' => 'FirstName'));?></td>						
					<td>Signing Zipcode</td>
					<td><?php echo $form->input('sa_zipcode', array('class' => 'text small', 'error' => false, 'label' => false, 'div' => false,'id'=>'SigningZipcode'));?></td>
				</tr>
				<tr>
					<td>Date of Signing</td>
					<td><?php echo $form->input('date_signing', array('class' => 'text small', 'error' => false, 'label' => false, 'div' => false, 'id' => 'DateOfSigning'));?></td>
					<td>&nbsp;
					</td>
					<td><?php 
					echo $form->submit('Search', array('div' => false, 'class' => 'submit small'));
					echo $html->link('Clear', array('action' => 'clear'), array('div' => false, 'class' => 'normalbutton fright'), null, false); 
					?></td>
				</tr>
			</table>
			<?php echo $form->end(); ?>
		</div>
		<!--SEARCH - end-->	
       	<?php if($assignment){ ?>
		<div class="block_content">
			<table cellpadding="0" cellspacing="0" class="tablelist">
				<thead>
					<th>Sl No</th>
					<th><?php echo $this->Paginator->sort('First Name','Order.first_name');?></th>
					<th><?php echo $this->Paginator->sort('Last Name','Order.last_name');?></th>
					<th><?php echo $this->Paginator->sort('Signing Zipcode','Order.sa_zipcode');?></th>
					<th>Notary</th>
					<th><?php echo $this->Paginator->sort('Fees','Assignment.fee');?></th>
					
					<th><?php echo $this->Paginator->sort('Signing date','Assignment.date_signing');?></th>
					<th class="actions"><?php __('Actions');?></th>
				</thead>
		<?php
			$i = 0;
			foreach ($assignment as $order):
				$class = null;
				if($i++ % 2 == 0){	$class = ' class="altrow"';		}
		?>
				<tr <?php echo $class;?>>
					<td><?php echo $counter->counters($i); ?></td>
					<td><?php echo $order['Order']['first_name']; ?>&nbsp;</td>		
					<td><?php echo $order['Order']['last_name']; ?>&nbsp;</td>				
					<td><?php echo $order['Order']['sa_zipcode']; ?>&nbsp;</td>
					<td><?php echo $misc->getUserName($order['Assignment']['user_id']); ?>&nbsp;</td>
					<td><?php echo $order['Assignment']['fee']; ?>&nbsp;</td>
					
					<td><?php echo $counter->formatdate('nsdatetimemeridiem',$order['Order']['date_signing']); ?>&nbsp;</td>
					<td class="actions">
				
						<?php echo $html->link(__('View', true), array('action' => 'viewinvoice', $order['Order']['id']), array('class' => 'view_btn', 'title' => 'View', 'alt' => 'View')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<?php __($this->element('pagination')); ?>
		<?php } else { ?>
		<?php __($this->element('nobox')); ?>
		<?php } 	
	}
	else{
		__($this->element('nopermission')); 
}
?>
	</div>
</div>