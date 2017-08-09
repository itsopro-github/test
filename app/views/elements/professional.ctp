<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php e($javascript->link('ui.datepicker')); ?>
<script type="text/javascript">$(function(){$('#Expiration').datepicker({changeMonth: true,changeYear: true});});</script>	
<?php __($html->tag('h3', 'Personal Details'));?>
<div class="form_block required">
	<p><label class="form_label">First Name<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.first_name',array('id'=>'FirstName','error'=>false,'label'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">Last Name<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.last_name',array('id'=>'LastName','error'=>false,'label'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">Email Address<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.email',array('id'=>'EmailAddress','error'=>false,'label'=>false,'class'=>'text_area')); ?>
	</p>
</div>
<div class="form_block  required">
	<p><label class="form_label">Cell Phone<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.cell_phone1', array('maxlength'=>'3', 'id'=>'CellPhone1','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['cell_phone'], 0, 3)));?>
	<?php echo $form->input('Notary.cell_phone2', array('maxlength'=>'3', 'id'=>'CellPhone2','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['cell_phone'], 3, 3)));?>
	<?php echo $form->input('Notary.cell_phone3', array('maxlength'=>'4', 'id'=>'CellPhone3','error'=>false,'label'=>false, 'class'=>'text_box tiny1','value'=>$misc->splitphone(@$this->data['Notary']['cell_phone'], 6, 4)));?>
	</p></div>
<div class="form_block ">
	<p><label class="form_label">Day Phone</label>
	<?php echo $form->input('Notary.day_phone1', array('maxlength'=>'3','id'=>'DayPhone1','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['day_phone'], 0, 3)));?>
	<?php echo $form->input('Notary.day_phone2', array('maxlength'=>'3','id'=>'DayPhone2','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['day_phone'], 3, 3)));?>
	<?php echo $form->input('Notary.day_phone3', array('maxlength'=>'4','id'=>'DayPhone3','error'=>false,'label'=>false, 'class'=>'text_box tiny1','value'=>$misc->splitphone(@$this->data['Notary']['day_phone'], 6, 4)));?>
	</p></div>
<div class="form_block ">
	<p><label class="form_label">Evening Phone</label>
	<?php echo $form->input('Notary.evening_phone1', array('maxlength'=>'3','id'=>'EveningPhone1','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['evening_phone'], 0, 3)));?>
	<?php echo $form->input('Notary.evening_phone2', array('maxlength'=>'3','id'=>'EveningPhone2','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['evening_phone'], 3, 3)));?>
	<?php echo $form->input('Notary.evening_phone3', array('maxlength'=>'4','id'=>'EveningPhone3','error'=>false,'label'=>false, 'class'=>'text_box tiny1','value'=>$misc->splitphone(@$this->data['Notary']['evening_phone'], 6, 4)));?></p>
</div>
<div class="form_block">
	<p><label class="form_label">Fax</label>
	<?php echo $form->input('Notary.fax1', array('maxlength'=>'3','id'=>'Fax1','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['fax'], 0, 3)));?>
	<?php echo $form->input('Notary.fax2', array('maxlength'=>'3','id'=>'Fax2','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['fax'], 3, 3)));?>
	<?php echo $form->input('Notary.fax3', array('maxlength'=>'3','id'=>'Fax3','error'=>false,'label'=>false, 'class'=>'text_box tiny1','value'=>$misc->splitphone(@$this->data['Notary']['fax'], 6, 4)));?>
	</p>
</div>
<div class="form_block ">
	<p><label class="form_label">Languages</label>
	<?php echo $form->input('Notary.languages',array('id'=>'Languages','error'=>false,'label'=>false,'class'=>'select_box','options'=>$langoptions,'multiple'=>'true', 'size'=>'5','empty'=>'N/A')); ?><span class="mandatory">[ To select multiple languages: push the CTRL button when clicking additional languages ]</span>
	</p>
</div>
<?php __($html->tag('h3', 'Document Delivery Address'));?>
<div class="form_block required">
	<p><label class="form_label">Street Address<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.dd_address',array('id'=>'DocumentAddress','error'=>false,'label'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">City<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.dd_city',array('id'=>'DocumentCity','error'=>false,'label'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">State<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.dd_state',array('id'=>'DocumentState','error'=>false,'label'=>false,'class'=>'select_box','options'=>$states)); ?>
	</p>
</div>

<div class="form_block required">
	<p><label class="form_label">Zip Code<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.dd_zip',array('id'=>'DocumentZipcode','error'=>false,'label'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
    <label class="log_label"></label>
	<p><input type="checkbox" value="1" id="terms" onchange='showval()' name="data[User][terms]">
	Click if Payment Address is the same as Document Delivery Address</p>
</div>
<?php __($html->tag('h3', 'Payment Address'));?>
<div class="form_block">
	<p><label class="form_label">Street Address<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.p_address',array('id'=>'PaymentAddress','error'=>false,'label'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">City<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.p_city',array('id'=>'PaymentCity','label'=>false,'error'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">State<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.p_state',array('id'=>'PaymentState','label'=>false,'error'=>false,'class'=>'select_box','options'=>$states)); ?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">Zip Code<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.p_zip',array('id'=>'PaymentZipcode','label'=>false,'error'=>false,'class'=>'text_box')); ?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">Payment Option<span class="mandatory">*</span> </label>
	<?php echo $form->input('Notary.payment', array('id'=>'PaymentOption','class'=>'select_box','error'=>false,'label'=>false,'div'=>false,'options'=>$payoptions, 'empty'=>'--Select--'));?></p>
</div>
<div class="form_block ">
	<p><label class="form_label">Twitter Account</label>
	<?php echo $form->input('Notary.twitter',array('id'=>'Twitter','label'=>false,'error'=>false,'class'=>'text_box')); ?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">Commission<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.commission',array('id'=>'Commission','label'=>false,'error'=>false,'class'=>'text_box')); ?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">Expiration<span class="mandatory">*</span></label><?php  echo $form->input('Notary.expiration',array('id'=>'Expiration','label'=>false,'error'=>false,'class'=>'text_box','type'=>'text','readonly'=>true)); ?></p>
</div>
<div class="form_block ">
	<p><label class="form_label">Which year did you receive your notary license?</label>
	<?php echo $form->input('Notary.year',array('id'=>'Year','label'=>false,'error'=>false,'class'=>'text_box')); ?></p>
</div>
<div>
	<p>
		<div id="upload_container_zip" >
			<div class="form_block required"  id="divrowzip1" style="margin-bottom:3px;"><p class="" style="margin-right:10px;width:180px;"><label>Zip Code Covered 1<span class="mandatory">*</span></label></p><input type="text" maxlength="50" class="text_box" id="Zipcode1" name="data[Notary][zipcode][]"></div>	
		</div>
		<div style="display:block;" id="fileid" class="addtracks"><p><a href="javascript:void(0)" onclick="javascript:add_rows_zipusr();" id='addMore' class="fright">Add another Zip Code Covered</a></p><input type="hidden" id="upload_count_zip" name="upload_count_zip" value="<?php echo $cnt_total;?>"/></div></p>
</div>
<div class="form_block">
	<p><label class="form_label">Laser Printer</label><?php echo $form->input('Notary.print', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$ynoptions, 'empty'=>'--Select--')); ?></p>
</div>
<div class="form_block">
	<p><label class="form_label">E-signing</label><?php echo $form->input('Notary.esigning', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$ynoptions, 'empty'=>'--Select--')); ?></p>
</div>
<div class="form_block">
	<p><label class="form_label">Wireless Card</label><?php echo $form->input('Notary.wireless_card', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$ynoptions, 'empty'=>'--Select--')); ?></p>
</div>
<div class="form_block">
	<p><label class="form_label">Are you an attorney/work with attorney?</label><?php echo $form->input('Notary.work_with', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$ynoptions, 'empty'=>'--Select--')); ?></p>
</div>
<div class="form_block">
	<p><label class="form_label">How did you hear about us?</label><?php echo $form->input('Notary.how_hear', array('class'=>'select_box', 'onchange'=>'showtxtb()','id'=>'how_did_u_hear', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$hearoptions, 'empty'=>'--Select--')); ?></p>
</div>
<div style="display: none;" id="ref">
	<p><label class="form_label">Referred by<span class="mandatory">*</span></label><?php echo $form->input('Notary.how_hear_ref',array('id'=>'how_hear_ref','label'=>false,'error'=>false,'class'=>'text_box')); ?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">Notify via<span class="mandatory">*</span></label><?php echo $form->input('Notary.notify', array('class'=>'select_box','id'=>'Notify', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$notifyoptions,'empty'=>'--Select--')); ?></p>
</div>
<input type="hidden" name="c_falg" value="0" id="c_falg" >
<?php echo $form->input('Notary.notarytype',array('type'=>'hidden','value'=>'P'));?>
<script>$("#DayPhone").keydown(function(e){var keycode=e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#DayPhone").val();test = test.replace('-','').replace('-','');$("#DayPhone").val(test);}});$("#EveningPhone").keydown(function(e){var keycode=e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#EveningPhone").val();test = test.replace('-','').replace('-','');$("#EveningPhone").val(test);}});$("#CellPhone").keydown(function(e){var keycode=e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#CellPhone").val();test = test.replace('-','').replace('-','');$("#CellPhone").val(test);}});$("#Fax").keydown(function(e){var keycode=e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test = $("#Fax").val();test = test.replace('-','').replace('-','');$("#Fax").val(test);}});function showval(){document.getElementById('PaymentAddress').value=document.getElementById('DocumentAddress').value;document.getElementById('PaymentState').value = document.getElementById('DocumentState').value;document.getElementById('PaymentCity').value = document.getElementById('DocumentCity').value;document.getElementById('PaymentZipcode').value = document.getElementById('DocumentZipcode').value;}function showtxtb(){if(document.getElementById('how_did_u_hear').value =='R'){document.getElementById('ref').style.display="block";}else{document.getElementById('ref').style.display="none";}}</script>