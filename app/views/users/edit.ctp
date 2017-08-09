<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core'));?>
<?php e($javascript->link('ui.datepicker')); ?>
<script type="text/javascript">$(function(){$('#Expiration').datepicker({changeMonth: true,changeYear: true,yearRange: '2010:2022'});});</script>
<div class="form index">
	<p></p>
	<div>
		<?php __($form->create('User', array('url'=>array('action'=>'edit', 'type'=>low($counter->usertypes($usersession['User']['type']))),'id'=>'signupFrm'))); ?>
		<input type="hidden" name="adm_falg" value="1" id="adm_falg" >
		<input type="hidden" name="p_falg" value="0" id="p_falg" >
		<input type="hidden" name="a_falg" value="1" id="a_falg" >
<?php
		if($usersession['User']['type'] == 'N') {
			__($this->element('notaryupdate'));
		} elseif($usersession['User']['type'] == 'C') {
			__($this->element('clientupdate'));
		}
		__($form->submit('Submit', array('div'=>false,'class'=>'submitbtn fleft')));
		__($html->link('Cancel',array('controller'=>'users','action'=>'myaccount','type'=>low($counter->usertypes($usersession['User']['type']))),array('div'=>false,'class'=>'normalbutton fleft')));
		__($form->end());
?>
	</div>
</div>
<script>function showval() {document.getElementById('ReturnAddress').value = document.getElementById("OfficeAddress").value;document.getElementById('ReturnCity').value = document.getElementById("OfficeCity").value;document.getElementById('ReturnState').value = document.getElementById("OfficeState").value;document.getElementById('ReturnZipcode').value = document.getElementById("OfficeZipcode").value;}function showvals() {document.getElementById('PaymentAddress').value=document.getElementById('DocumentAddress').value;document.getElementById('PaymentState').value = document.getElementById('DocumentState').value;document.getElementById('PaymentCity').value = document.getElementById('DocumentCity').value;document.getElementById('PaymentZipcode').value = document.getElementById('DocumentZipcode').value;}function showtxtb() {if(document.getElementById('how_did_u_hear').value =='R'){document.getElementById('ref').style.display = "block";}else{document.getElementById('ref').style.display = "none";	}}$('#Email').focusout(function() {var un= $('#Email').val();$("#Username").val(un);});$('#EmailAddress').focusout(function() {var un=$('#EmailAddress').val();$("#Username").val(un);});</script>