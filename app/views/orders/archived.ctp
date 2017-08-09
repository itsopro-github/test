<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php e($javascript->link('ui.datepicker')); ?>
<script type="text/javascript">$(function(){$('#DateOfSigning').datepicker();});</script>	
<?php if(!isset($searchresults) and empty($searchresults)) { ?>
<div class="block form index">
	<div>
		<?php __($html->clean(nl2br($contentpage['Contentpage']['content']))); ?>
	</div>
	<div>
		<?php __($form->create('Order',array('url'=>array('controller'=>'orders','action'=>'archived')))); ?>
		<div class="titler">
		<div class="title"><h3 class="fleft"><?php __('Date & File Number'); ?></h3></div>
		<div class="titleactions"><span></span></div>
		</div>
		<div class="fieldblock">
		<table border="0" cellspacing="0" cellpadding="0" class="tablelistnw">
			<tr>
				<td>Date of Signing</td>
				<td><?php __($form->input('Order.date_signing',array('error'=>false,'label'=>false,'id'=>'DateOfSigning','div'=>false,'class'=>'text_box','type'=>'text','readonly'=>true))); ?></td>						
				<td>File Number</td>
				<td><?php __($form->input('Order.file',array('error'=>false,'label'=>false,'id'=>'File','div'=>false,'class'=>'text_box'))); ?></td>
			</tr>
			</table>
			</div>
			<div class="titler">
		<div class="title"><h3 class="fleft"><?php __('Borrower Name'); ?></h3></div>
		<div class="titleactions"><span></span></div>
		</div>
		<div class="fieldblock">
		<table border="0" cellspacing="0" cellpadding="0" class="tablelistnw">
			<tr>
				<td width="18%">First Name</td>
				<td><?php __($form->input('Order.first_name',array('error'=>false,'label'=>false,'id'=>'FirstName','div'=>false,'class'=>'text_box'))); ?></td>						
				<td width="15%">Last Name</td>
				<td><?php __($form->input('Order.last_name',array('error'=>false,'label'=>false,'id'=>'LastName','div'=>false,'class'=>'text_box'))); ?></td>
			</tr>
			</table>
			</div>
<?php /* As requested Notary View: should not have Notary Name in Search ?>			
			<div class="titler">
				<div class="title"><h3 class="fleft"><?php __('Notary Name'); ?></h3></div>
				<div class="titleactions"><span></span></div>
			</div>
			<div class="fieldblock">
				<table border="0" cellspacing="0" cellpadding="0" class="tablelistnw">
					<tr>
						<td>Notary First Name</td>
						<td><?php __($form->input('Notary.first_name',array('error'=>false,'label'=>false,'id'=>'NotaryFirstName','div'=>false,'class'=>'text_box'))); ?></td>						
						<td>Notary Last Name</td>
						<td><?php __($form->input('Notary.last_name',array('error'=>false,'label'=>false,'id'=>'NotaryLastName','div'=>false,'class'=>'text_box'))); ?></td>
					</tr>
				</table>
			</div>
<?php */ ?>			
			<div class="titler">
				<div class="title"><h3 class="fleft"><?php __('Signing Address'); ?></h3></div>
				<div class="titleactions"><span></span></div>
			</div>
			<div class="fieldblock">
			<table border="0" cellspacing="0" cellpadding="0" class="tablelistnw">
				<tr>
					<td>Signing Address</td>
					<td><?php __($form->input('Order.sa_street_address',array('type'=>'text','error'=>false,'label'=>false,'id'=>'SigningAddress','class'=>'text_area'))); ?></td>						
					<td>Signing State</td>
					<td><?php __($form->input('Order.sa_state',array('error'=>false,'label'=>false,'id'=>'SigningState','div'=>false,'class'=>'text_box'))); ?></td>						
				</tr>
				<tr>
				<td>Signing City</td>
					<td><?php __($form->input('Order.sa_city',array('error'=>false,'label'=>false,'id'=>'SigningCity','div'=>false,'class'=>'text_box'))); ?></td>							
					<td>Signing  Zip Code</td>
					<td><?php __($form->input('Order.sa_zipcode',array('error'=>false,'label'=>false,'id'=>'SigningZipcode','div'=>false,'class'=>'text_box'))); ?></td>						
				</tr>
			</table>
			</div>
			<div class="titler">
		<div class="title"><h3 class="fleft"><?php __('Property Address'); ?></h3></div>
		<div class="titleactions"><span></span></div>
		</div>
		<div class="fieldblock">
		<table border="0" cellspacing="0" cellpadding="0" class="tablelistnw">
			<tr>
				
			<td>Property Address</td>
				<td><?php __($form->input('Order.pa_street_address',array('type'=>'text','error'=>false,'label'=>false,'id'=>'PropertyAddress','class'=>'text_area'))); ?></td>
				
				<td>Property State</td>
				<td><?php __($form->input('Order.pa_state',array('error'=>false,'label'=>false,'id'=>'PropertyState','div'=>false,'class'=>'text_box'))); ?></td>	
			</tr>
			<tr>
				
				<td>Property City</td>
				<td><?php __($form->input('Order.pa_city',array('error'=>false,'label'=>false,'id'=>'PropertyCity','div'=>false,'class'=>'text_box'))); ?></td>
				<td>Property Zip Code</td>
				<td><?php __($form->input('Order.pa_zipcode',array('error'=>false,'label'=>false,'id'=>'PropertyZipcode','div'=>false,'class'=>'text_box'))); ?></td>
			</tr>
			
		
			
			<tr>
				<td  colspan="4" align="center"><?php __($form->submit('Search', array('div'=>false, 'class'=>'submitbtn fleft'))); ?></td>
			</tr>
		</table>
			</div>
	<?php __($form->end()); ?>
	</div>
</div>
<?php
} else {
?>
<div class="orders index">
	<div class="block">
<?php
		if(isset($_SESSION['signings']) and $_SESSION['signings'] != '') {
			__($this->element('listorders', array('ordertitle'=>'search results','desc'=>'Archived Signings.','statusid'=>array('6','9','10'),'orders'=>$searchresults,'classappend'=>'','classappendhead'=>'')));
		}
?>		
		<?php __($this->element('pagination')); ?>
	</div>
</div>
<?php
}
?>