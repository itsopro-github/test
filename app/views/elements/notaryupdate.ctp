<div class="form_block required">
	<p><label class="form_label">First Name<span class="mandatory">*</span></label>
<?php __($form->input('Notary.first_name', array('id'=>'FirstName','error'=>false,'label'=>false, 'class'=>'text_box')));?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">Last Name<span class="mandatory">*</span></label>
	<?php __($form->input('Notary.last_name', array('id'=>'LastName','error'=>false,'label'=>false, 'class'=>'text_box')));?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">Email Address<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.email', array('id'=>'Email','error'=>false,'label'=>false, 'class'=>'text_box'));?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">Cell Phone <span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.cell_phone1', array('maxlength'=>'3', 'id'=>'CellPhone1','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['cell_phone'], 0, 3)));?>
	<?php echo $form->input('Notary.cell_phone2', array('maxlength'=>'3', 'id'=>'CellPhone2','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['cell_phone'], 3, 3)));?>
	<?php echo $form->input('Notary.cell_phone3', array('maxlength'=>'4', 'id'=>'CellPhone3','error'=>false,'label'=>false, 'class'=>'text_box tiny1','value'=>$misc->splitphone(@$this->data['Notary']['cell_phone'], 6, 4)));?>
	</p></div>
	<div class="form_blocks">
	<p><label class="form_label">Day Phone</label>
		<?php echo $form->input('Notary.day_phone1', array('maxlength'=>'3','id'=>'DayPhone1','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['day_phone'], 0, 3)));?>
		<?php echo $form->input('Notary.day_phone2', array('maxlength'=>'3','id'=>'DayPhone2','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['day_phone'], 3, 3)));?>
		<?php echo $form->input('Notary.day_phone3', array('maxlength'=>'4','id'=>'DayPhone3','error'=>false,'label'=>false, 'class'=>'text_box tiny1','value'=>$misc->splitphone(@$this->data['Notary']['day_phone'], 6, 4)));?>
	</p></div>
	<div class="form_block">
	<p><label class="form_label">Evening Phone</label>
		<?php echo $form->input('Notary.evening_phone1', array('maxlength'=>'3','id'=>'EveningPhone1','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['evening_phone'], 0, 3)));?>
		<?php echo $form->input('Notary.evening_phone2', array('maxlength'=>'3','id'=>'EveningPhone2','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['evening_phone'], 3, 3)));?>
		<?php echo $form->input('Notary.evening_phone3', array('maxlength'=>'4','id'=>'EveningPhone3','error'=>false,'label'=>false, 'class'=>'text_box tiny1','value'=>$misc->splitphone(@$this->data['Notary']['evening_phone'], 6, 4)));?>
	</p></div>
	<div class="form_block">
	<p><label class="form_label">Fax</label>
		<?php echo $form->input('Notary.fax1', array('maxlength'=>'3','id'=>'Fax1','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['fax'], 0, 3)));?>
		<?php echo $form->input('Notary.fax2', array('maxlength'=>'3','id'=>'Fax2','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['fax'], 3, 3)));?>
		<?php echo $form->input('Notary.fax3', array('maxlength'=>'3','id'=>'Fax3','error'=>false,'label'=>false, 'class'=>'text_box tiny1','value'=>$misc->splitphone(@$this->data['Notary']['fax'], 6, 4)));?>
	</p>
	</div>
	<div class="form_block ">
	<p><label class="form_label">Languages</label>
	<?php echo $form->input('Notary.languages',array('id'=>'Languages','label'=>false,'class'=>'select_box nobg','options'=>$langoptions,'multiple'=>'true', 'size'=>'5','empty'=>'N/A','selected' => $selectedLang)); ?><span class="mandatory">[ To select multiple languages: push the CTRL button when clicking additional languages ]</p>
</div>
<?php __($html->tag('h3', 'Document Delivery Address'));?>
<div class="form_block required">
	<p><label class="form_label">Street Address<span class="mandatory">*</span></label>
<?php __($form->input('Notary.dd_address', array('id'=>'DocumentAddress','error'=>false,'label'=>false,'class'=>'text_box')));?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">City<span class="mandatory">*</span></label>
	<?php __($form->input('Notary.dd_city', array('id'=>'DocumentCity','error'=>false,'label'=>false,'class'=>'text_box')));?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">State<span class="mandatory">*</span></label>
	<?php __($form->input('Notary.dd_state', array('id'=>'DocumentState','error'=>false,'label'=>false,'class'=>'select_box','options'=>$states)));?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">Zip Code<span class="mandatory">*</span></label>
	<?php __($form->input('Notary.dd_zip', array('id'=>'DocumentZipcode','error'=>false,'label'=>false,'class'=>'text_box')));?></p>
</div>
<div class="form_block required">
    <label class="log_label"></label>
	<p><input type="checkbox" value="1" id="terms" onchange='showvals()' name="data[User][terms]">
	Click if Payment Address is the same as Document Delivery Address</p>
</div>
<?php __($html->tag('h3', 'Payment Address'));?>
<div class="form_block required">
	<p><label class="form_label">Street Address<span class="mandatory">*</span></label>
<?php __($form->input('Notary.p_address', array('id'=>'PaymentAddress','error'=>false,'label'=>false,'class'=>'text_box')));?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">City<span class="mandatory">*</span></label>
	<?php __($form->input('Notary.p_city', array('id'=>'PaymentCity','error'=>false,'label'=>false,'class'=>'text_box')));?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">State<span class="mandatory">*</span></label>
	<?php __($form->input('Notary.p_state', array('id'=>'PaymentState','error'=>false,'label'=>false,'class'=>'select_box','options'=>$states)));?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">Zip Code<span class="mandatory">*</span></label>
	<?php __($form->input('Notary.p_zip', array('id'=>'PaymentZipcode','error'=>false,'label'=>false,'class'=>'text_box')));?></p>
</div>
<div class="form_block  ">
	<p><label class="form_label">Twitter</label>
	<?php __($form->input('Notary.twitter', array('id'=>'Twitterid','error'=>false,'label'=>false,'class'=>'text_box')));?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">Commission<span class="mandatory">*</span></label>
	<?php __($form->input('Notary.commission', array('id'=>'Commission','error'=>false,'label'=>false,'class'=>'text_box')));?></p>
</div>
<div class="form_block required">
	<p><label class="form_label">Expiration<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.expiration',array('id'=>'Expiration','label'=>false,'class'=>'text_box','type'=>'text','readonly'=>true,'value'=> $counter->formatdate('nsdate',$this->data['Notary']['expiration'])));?></p>
</div>	
<div class="form_block">
	<p><label class="form_label">What year did you receive your notary license?</label>
<?php __($form->input('Notary.year', array('id'=>'Year','error'=>false,'label'=>false,'class'=>'text_box')));?></p>
</div>
<div id="upload_container_zip">
<?php
	$zip = explode("|",$this->data['Notary']['zipcode']);
	$total = count($zip);
	for($i=1;$i<=$total;$i++){
?>
		<div class="form_block" id="divrowzip<?php __($i); ?>" style="margin-bottom:3px;">
			<p class="" style="margin-right:10px;width:180px;">
			<label>Zip Code Covered<?php __($i); ?><span class="mandatory">*</span></label></p>
			<?php echo $form->input('Notary.zipcode', array('id'=>'Zipcode'.$i,'label'=>false,'value'=>$zip[$i-1],'name'=>"data[Notary][zipcode][]",'class'=>'text_box','error'=>false,'label'=>false)); ?><?php if($i>1) { ?><div class="float_divs"><p><a href="javascript:void(0)" onclick="javascript:delete_row_zip('<?php __($i); ?>')" class="delete_btn" title="Remove">Remove</a></p></div><?php } ?>
		</div>	
<?php
	}
?>
</div>
<div style="display:block;" id="fileid" class="addtracks"><p><a href="javascript:void(0)" onclick="javascript:add_rows_zipusr();" id='addMore' class="fright">Add another Zip Code Covered</a></p>
	<input type="hidden" id="upload_count_zip" name="upload_count_zip" value="<?php echo $total;?>"/>
</div>
<?php echo $form->hidden('Notaryid',array('name'=>'data[Notary][id]','value'=>$this->data['Notary']['id'])); ?>
<div class="form_block ">
	<p><label class="form_label">Notify via</label>
<?php echo $form->input('Notary.notify', array('class'=>'select_box','error'=>false, 'label'=>false, 'div'=>false, 'options'=>$notifyoptions,'empty'=>'--Select--')); ?></p>
</div>
<div class="form_block ">
	<p><label class="form_label">Laser Printer</label>
<?php echo $form->input('Notary.print', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$ynoptions, 'empty'=>'--Select--')); ?></p>
</div>
<div class="form_block ">
	<p><label class="form_label">E-signing</label>
<?php echo $form->input('Notary.esigning', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$ynoptions, 'empty'=>'--Select--')); ?></p>
</div>
<div class="form_block ">
	<p><label class="form_label">Wireless Card</label>
<?php echo $form->input('Notary.wireless_card', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$ynoptions, 'empty'=>'--Select--')); ?></p>
</div>
<div class="form_block ">
	<p><label class="form_label">Are you an attorney/work with attorney?</label>
<?php echo $form->input('Notary.work_with', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$ynoptions, 'empty'=>'--Select--')); ?></p>
</div>
<script>$("#DayPhone").keydown(function(e){var keycode=e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#DayPhone").val();test = test.replace('-','').replace('-','');$("#DayPhone").val(test);}});$("#EveningPhone").keydown(function(e){var keycode=e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#EveningPhone").val();test = test.replace('-','').replace('-','');$("#EveningPhone").val(test);}});$("#CellPhone").keydown(function(e){var keycode=e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#CellPhone").val();test = test.replace('-','').replace('-','');$("#CellPhone").val(test);}});$("#Fax").keydown(function(e){var keycode=e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test = $("#Fax").val();test = test.replace('-','').replace('-','');$("#Fax").val(test);}});</script>