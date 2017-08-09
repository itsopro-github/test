<?php __($html->tag('h3', 'Account Details'));?>
<div class="form_block required">
	<p><label class="form_label">Company<span class="mandatory">*</span></label>
<?php echo $form->input('Client.company',array('id'=>'Company','label'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block">
	<p><label class="form_label">Division</label>
	<?php echo $form->input('Client.division',array('id'=>'Division','label'=>false,'error'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">First Name<span class="mandatory">*</span></label>
	<?php echo $form->input('Client.first_name',array('id'=>'FirstName','label'=>false,'error'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">Last Name<span class="mandatory">*</span></label>
	<?php echo $form->input('Client.last_name',array('id'=>'LastName','label'=>false,'error'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">Email Address<span class="mandatory">*</span></label>
	<?php echo $form->input('Client.email',array('id'=>'EmailAddress','label'=>false,'error'=>false,'class'=>'text_area')); ?>
	</p>
</div>
<div class="form_block  required">
	<p><label class="form_label">Company Phone<span class="mandatory">*</span></label>
	<?php echo $form->input('Client.company_phone1',array('maxlength'=>'3','id'=>'CompanyPhone1','label'=>false,'error'=>false,'class'=>'text_box tiny1 fleft', 'value'=>$misc->splitphone(@$this->data['Client']['company_phone'], 0, 3))); ?>
	<?php echo $form->input('Client.company_phone2',array('maxlength'=>'3','id'=>'CompanyPhone2','label'=>false,'error'=>false,'class'=>'text_box tiny1 fleft', 'value'=>$misc->splitphone(@$this->data['Client']['company_phone'], 3, 3))); ?>
	<?php echo $form->input('Client.company_phone3',array('maxlength'=>'4','id'=>'CompanyPhone3','label'=>false,'error'=>false,'class'=>'text_box tiny1', 'value'=>$misc->splitphone(@$this->data['Client']['company_phone'], 6, 4))); ?>
	</p></div>
<div class="form_block">
	<p><label class="form_label">Company Fax</label>
	<?php echo $form->input('Client.company_fax1',array('maxlength'=>'3','id'=>'CompanyFax1','label'=>false,'error'=>false,'class'=>'text_box tiny1 fleft', 'value'=>$misc->splitphone(@$this->data['Client']['company_fax'], 0, 3))); ?>
	<?php echo $form->input('Client.company_fax2',array('maxlength'=>'3','id'=>'CompanyFax2','label'=>false,'error'=>false,'class'=>'text_box tiny1 fleft', 'value'=>$misc->splitphone(@$this->data['Client']['company_fax'], 3, 3))); ?>
	<?php echo $form->input('Client.company_fax3',array('maxlength'=>'4','id'=>'CompanyFax3','label'=>false,'error'=>false,'class'=>'text_box tiny1', 'value'=>$misc->splitphone(@$this->data['Client']['company_fax'], 6, 4))); ?>
	</p>
</div>
<div class="form_block">
	<p><label class="form_label">Shipping Carrier</label>
	<?php 
	echo $form->input('Client.shipping_carrier',array('id'=>'Shipping_Carrier','label'=>false,'error'=>false,'class'=>'select_box','options'=>$clientscdata, 'onchange'=>'showtxtother()','empty'=>'Select')); 
	//echo $form->input('Client.shipping_carrier',array('id'=>'Shipping_Carrier','label'=>false,'class'=>'text_area')); ?>
	</p>
</div>
<div style="display: none;" id="other">
	<p><label class="form_label">Other</label>
	<?php echo $form->input('Client.shipping_carrier_other',array('id'=>'shipping_carrier_other','error'=>false,'label'=>false,'class'=>'text_box','maxlength'=>20)); ?>
	</p>
</div>
<div class="form_block">
	<p><label class="form_label">Shipping Account #</label>
	<?php echo $form->input('Client.shipping_account',array('id'=>'Shipping_Account','label'=>false,'error'=>false,'class'=>'text_area')); ?>
	</p>
</div>
<?php __($html->tag('h3', 'Office Address'));?>
<div class="form_block required">
	<p><label class="form_label">Street Address<span class="mandatory">*</span></label>
	<?php echo $form->input('Client.of_street_address',array('id'=>'OfficeAddress','label'=>false,'error'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">City<span class="mandatory">*</span></label>
	<?php echo $form->input('Client.of_city',array('id'=>'OfficeCity','label'=>false,'error'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">State<span class="mandatory">*</span></label>
	<?php echo $form->input('Client.of_state',array('id'=>'OfficeState','label'=>false,'error'=>false,'class'=>'select_box','options'=>$states)); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">Zip Code<span class="mandatory">*</span></label>
	<?php echo $form->input('Client.of_zip',array('id'=>'OfficeZipcode','label'=>false,'error'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
    <label class="log_label"></label>
	<p><input type="checkbox" value="1" id="terms" onchange='showval()' name="data[User][terms]">
	Click if Return Document Address is the same as Office Address</p>
</div>
<?php __($html->tag('h3', 'Return Document Address'));?>
<div class="form_block">
	<p><label class="form_label">Street Address<span class="mandatory">*</span></label>
	<?php echo $form->input('Client.rd_street_address',array('id'=>'ReturnAddress','error'=>false,'label'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">City<span class="mandatory">*</span></label>
	<?php echo $form->input('Client.rd_city',array('id'=>'ReturnCity','label'=>false,'error'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">State<span class="mandatory">*</span></label>
	<?php echo $form->input('Client.rd_state',array('id'=>'ReturnState','label'=>false,'error'=>false,'class'=>'select_box','options'=>$states)); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">Zip Code<span class="mandatory">*</span></label>
	<?php echo $form->input('Client.rd_zip',array('id'=>'ReturnZipcode','error'=>false,'label'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block">
	<p><label class="form_label">How did you hear about us?</label>
	<?php echo $form->input('Client.how_hear', array('class'=>'select_box', 'onchange'=>'showtxtb()','id'=>'how_did_u_hear', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$hearoptions)); ?> 
	</p>
</div>

<div style="display: none;" id="ref">
	<p><label class="form_label">Referred by<span class="mandatory">*</span></label>
	<?php echo $form->input('Client.how_hear_ref',array('id'=>'how_hear_ref','error'=>false,'label'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<input type="hidden" name="c_falg" value="1" id="c_falg">
<script>$("#CompanyPhone").keydown(function(e){var keycode =  e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#CompanyPhone").val();test = test.replace('-','').replace('-','');$("#CompanyPhone").val(test);}});$("#CompanyFax").keydown(function(e){var keycode =  e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#CompanyFax").val();test = test.replace('-','').replace('-','');$("#CompanyFax").val(test);}});function showval(){document.getElementById('ReturnAddress').value = document.getElementById("OfficeAddress").value;document.getElementById('ReturnCity').value = document.getElementById("OfficeCity").value;document.getElementById('ReturnState').value = document.getElementById("OfficeState").value;document.getElementById('ReturnZipcode').value = document.getElementById("OfficeZipcode").value;}function showtxtb(){if(document.getElementById('how_did_u_hear').value =='R'){document.getElementById('ref').style.display = "block";}else{document.getElementById('ref').style.display = "none";}}function showtxtother(){if(document.getElementById('Shipping_Carrier').value =='O'){document.getElementById('other').style.display="block";}else{document.getElementById('other').style.display="none";}}</script>