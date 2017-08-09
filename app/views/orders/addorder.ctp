<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php e($javascript->link('ui.datepicker')); ?>
<script type="text/javascript">$(function() {$('#DateOfSigning').datepicker();});</script>
<script src='https://www.google.com/recaptcha/api.js'></script>

<div class="index">
	<div><?php __($html->clean(nl2br($contentpage['Contentpage']['content']))); ?></div>
	<?php __($form->create('Order',array('url'=>array('controller'=>'orders','action'=>'addorder', 'type'=>'client'),'type'=>'file','id'=>'placeOrderFrm'))); ?>
	<div>
		<div class="titler">
			<div class="title"><h3 class="fleft"><?php __('Borrower Information'); ?></h3></div>
			<div class="titleactions"><span></span></div>
		</div>
		<div class="fieldblock">
			<div class="form_block required"><p><label class="form_label">First Name<span class="mandatory">*</span></label><?php __($form->input('first_name',array('error'=>false,'label'=>false,'id'=>'FirstName','class'=>'text_box1'))); ?></p></div>
			<div class="form_block required"><p><label class="form_label">Last Name<span class="mandatory">*</span></label><?php __($form->input('last_name',array('error'=>false,'label'=>false,'id'=>'LastName','class'=>'text_box1'))); ?></p></div>
			<div class="form_block required"><p><label class="form_label">Home Phone<span class="mandatory">*</span></label>
			<?php __($form->input('home_phone1',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'HomePhone1','class'=>'text_box1 tiny1 fleft','value'=>$misc->splitphone(@$this->data['Order']['home_phone'], 0, 3)))); ?>
			<?php __($form->input('home_phone2',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'HomePhone2','class'=>'text_box1 tiny1 fleft','value'=>$misc->splitphone(@$this->data['Order']['home_phone'], 3, 3)))); ?>
			<?php __($form->input('home_phone3',array('maxlength'=>'4','error'=>false,'label'=>false,'id'=>'HomePhone3','class'=>'text_box1 tiny1','value'=>$misc->splitphone(@$this->data['Order']['home_phone'], 6, 4)))); ?>
			</p></div>
			<div class="form_block"><p><label class="form_label">Work Phone</label>
			<?php __($form->input('work_phone1',array('maxlength'=>'3','label'=>false,'error'=>false,'id'=>'WorkPhone1','class'=>'text_box1 tiny1 fleft','value'=>$misc->splitphone(@$this->data['Order']['work_phone'], 0, 3)))); ?>
			<?php __($form->input('work_phone2',array('maxlength'=>'3','label'=>false,'error'=>false,'id'=>'WorkPhone2','class'=>'text_box1 tiny1 fleft','value'=>$misc->splitphone(@$this->data['Order']['work_phone'], 3, 3)))); ?>
			<?php __($form->input('work_phone3',array('maxlength'=>'4','label'=>false,'error'=>false,'id'=>'WorkPhone3','class'=>'text_box1 tiny1','value'=>$misc->splitphone(@$this->data['Order']['work_phone'], 6, 4)))); ?>
			</p></div>
			<div class="form_block"><p><label class="form_label">Cell Phone</label>
			<?php __($form->input('cell_phone1',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'CellPhone1','class'=>'text_box1 tiny1 fleft','value'=>$misc->splitphone(@$this->data['Order']['cell_phone'], 0, 3)))); ?>
			<?php __($form->input('cell_phone2',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'CellPhone2','class'=>'text_box1 tiny1 fleft','value'=>$misc->splitphone(@$this->data['Order']['cell_phone'], 3, 3)))); ?>
			<?php __($form->input('cell_phone3',array('maxlength'=>'4','error'=>false,'label'=>false,'id'=>'CellPhone3','class'=>'text_box1 tiny1','value'=>$misc->splitphone(@$this->data['Order']['cell_phone'], 6, 4)))); ?>
			</p></div>
			<div class="form_block"><p><label class="form_label">Alternative Phone</label>
			<?php __($form->input('alternative_phone1',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'AlternativePhone1','class'=>'text_box1 tiny1 fleft','value'=>$misc->splitphone(@$this->data['Order']['alternative_phone'], 0, 3)))); ?>
			<?php __($form->input('alternative_phone2',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'AlternativePhone2','class'=>'text_box1 tiny1 fleft','value'=>$misc->splitphone(@$this->data['Order']['alternative_phone'], 3, 3)))); ?>
			<?php __($form->input('alternative_phone3',array('maxlength'=>'4','error'=>false,'label'=>false,'id'=>'AlternativePhone3','class'=>'text_box1 tiny1','value'=>$misc->splitphone(@$this->data['Order']['alternative_phone'], 6, 4)))); ?>
			</p></div>
			<div class="form_block"><p><label class="form_label">E-mail Address</label><?php __($form->input('email',array('error'=>false,'label'=>false,'id'=>'E-mailAddress','class'=>'text_box1'))); ?></p></div>
		</div>
		<div class="titler">
			<div class="title"><h3 class="fleft"><?php __('Signing Location'); ?></h3></div>
			<div class="titleactions"><span style="float:left;padding-left:5px;">Address of Signing</span></div>
		</div>
		<div class="fieldblock">
			<div class="form_block required"><p><label class="form_label">Street Address<span class="mandatory">*</span></label><?php __($form->input('sa_street_address',array('error'=>false,'label'=>false,'id'=>'SigningStreetAddress','class'=>'text_box1'))); ?></p></div> 
			<div class="form_block required"><p><label class="form_label">City<span class="mandatory">*</span></label><?php __($form->input('sa_city',array('error'=>false,'label'=>false,'id'=>'SigningCity','class'=>'text_box1'))); ?></p></div>	
			<div class="form_block required"><p><label class="form_label">State<span class="mandatory">*</span></label><?php __($form->input('sa_state',array('error'=>false,'label'=>false,'id'=>'SigningState','class'=>'select_box1','options'=>$states))); ?></p></div> 	
			<div class="form_block required"><p><label class="form_label">Zip Code<span class="mandatory">*</span></label><?php __($form->input('sa_zipcode',array('error'=>false,'label'=>false,'id'=>'SigningZipCode','class'=>'text_box1'))); ?></p></div>
			<div class="form_block required">
   				<label class="log_label"></label>
				<p><input type="checkbox" value="1" id="terms" onchange='showval()'>Click if Property Address is same as Signing Address</p>
			</div>
		</div>
		<div class="titler">
		<div class="title"><h3 class="fleft"><?php __('Property Address'); ?></h3></div>
		<div class="titleactions"><span style="float:left;padding-left:5px;">Address of property for loan docs</span></div>
		</div>
		<div class="fieldblock">
			<div class="form_block required"><p><label class="form_label">Street Address<span class="mandatory">*</span></label><?php __($form->input('pa_street_address',array('error'=>false,'label'=>false,'id'=>'PropertyStreetAddress','class'=>'text_box1'))); ?></p></div> 
			<div class="form_block required"><p><label class="form_label">City<span class="mandatory">*</span></label><?php __($form->input('pa_city',array('error'=>false,'label'=>false,'id'=>'PropertyCity','class'=>'text_box1'))); ?></p></div>	
		<div class="form_block required"><p><label class="form_label">State<span class="mandatory">*</span></label><?php __($form->input('pa_state',array('error'=>false,'label'=>false,'id'=>'PropertyState','class'=>'select_box1','options'=>$states))); ?></p></div> 	
		<div class="form_block required"><p><label class="form_label">Zip Code<span class="mandatory">*</span></label><?php __($form->input('pa_zipcode',array('error'=>false,'label'=>false,'id'=>'PropertyZipCode','class'=>'text_box1'))); ?></p></div>
		
	</div>
		<div class="titler">
		<div class="title"><h3 class="fleft"><?php __('Signing Info & Instructions'); ?></h3></div>
		<div class="titleactions"><span></span></div>
		</div>
	<div class="fieldblock">
		<div class="form_block "><p><label class="form_label">Specific Signing Instructions</label><?php __($form->input('signing_instrn',array('error'=>false,'escape' => false,'label'=>false,'id'=>'Specific_Signing_Instructions','class'=>'text_area'))); ?></p></div> 
		<div class="form_block "><p><label class="form_label">Additional Notes</label><?php __($form->input('addtnl_notes',array('error'=>false,'escape' => false,'label'=>false,'id'=>'Additional_Notes','class'=>'text_area'))); ?></p></div> 
		<div class="form_block "><p><label class="form_label">Additional Notification E-mail Addresses <span class="mandatory">[ E-mail addresses - separated by commas ]</span></label><?php __($form->input('addtnl_emails',array('error'=>false,'escape' => false,'label'=>false,'id'=>'Additional_Notification_Emails','class'=>'text_area'))); ?></p></div> 
		</div>
		<div class="titler">
		<div class="title"><h3 class="fleft"><?php __('Loan Document Details'); ?></h3></div>
		<div class="titleactions"><span></span></div>
		</div>
		<div class="fieldblock">
		<div class="form_block required"><p><label class="form_label">Date of Signing<span class="mandatory">*</span></label><?php __($form->input('date_signing',array('error'=>false,'label'=>false,'id'=>'DateOfSigning','class'=>'text_box1','type'=>'text','readonly'=>true, 'value'=>$counter->formatdate('nsdate',$this->data['Order']['date_signing'])))); ?></p></div>
		<div class="form_block required"><p><label class="form_label">File Number<span class="mandatory">*</span></label>
		<?php __($form->input('file',array('error'=>false,'label'=>false,'id'=>'File','class'=>'text_box1'))); ?></p></div>
		
		<div class="form_block required"><p><label class="form_label">Is it a New Request or Re-sign?<span class="mandatory">*</span></label><?php echo $form->input('doc_info', array('class'=>'select_box1', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$docinfooptions,'empty'=>'Select')); ?> </p></div>
	<div class="form_block required"><p><label class="form_label">What type of Loan Document?<span class="mandatory">*</span></label><?php echo $form->input('doc_type', array('id'=>'Documenttype', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box1','options'=>$doc_typesoptions,'empty'=>'Select')); ?></p></div>
				
		<div class="form_block required"><p><label class="form_label">How will you send the Loan Documents?<span class="mandatory">*</span></label><?php echo $form->input('doc_submit', array('class'=>'select_box1','id'=>'DocumentDeliveryReceipt', 'error'=>false, 'label'=>false,'onchange'=>'showdiv()', 'div'=>false, 'options'=>$doctypeoptions,'empty'=>'Select')); ?></p></div>
		
	<div id="edoc" style="display: none;">	
		<div class="table_row_data">
			<div class="repeat_divouter">
				<div class="float_div1"><label>No</label></div>
				<div class="float_div"><label>Type</label></div>
				<div class="float_div6">
					<label class="biglabel">Upload EDOC<span class="mandatory">*</span><br /><span class="mandatory">[ Max upload limit: 5 Mb, Recommended file types are 'pdf','doc','docx' ]</span><br />Need to convert your document to PDF? Click>> <a href="http://www.primopdf.com" class="fright" target="_blank">Convert to PDF</a></label>
				</div>
			</div>
			<div id="upload_container" >
				<div class="repeat_divouter" id="divrow1">
					<div class="float_div1">1</div>
					<div class="float_div"><?php echo $form->input('ptype', array('class'=>'sel_inner_inputs','name'=>'data[OrderEdocs][ptype][]','id'=>'ptype1', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$pdftypeoptions, 'empty'=>'--Select--'));?></div>
					<div id="edocf" class="float_div4"><?php echo $form->file('edocfile', array('label'=>false,'id'=>'EDOC1','name'=>'data[OrderEdocs][edocfile][]',"class"=>"inner_input ",'error'=>false)); ?></div>
				</div>
			</div>
			<div style="display:block;" id="fileid" class="addtracks">
				<p><a href="javascript:void(0)" onclick="javascript: add_row();" id='addMore' class="fright">+ Add another doc</a></p><input type="hidden" id="upload_count" name="upload_count" value="<?php echo $cnt_tottrack;?>" /></div>
			</div>
		</div>
		<div id="pdoc" style="display:none;">
			<div class="table_row_data">
				<div class="repeat_divouters">	
					<p><label class="form_label">Pick Up Address<span class="mandatory">*</span></label><div id="puadd" class="form_block required"><?php __($form->input('pickup_address',array('error'=>false,'label'=>false,'id'=>'PickUpAddress','class'=>'text_box1'))); ?></div></p>
			<p><label class="form_label">Pick Up City<span class="mandatory">*</span></label><div id="pucity" class="form_block required"><?php __($form->input('pickup_city',array('error'=>false,'label'=>false,'id'=>'PickUpCity','class'=>'text_box1'))); ?></div></p>
			<p><label class="form_label">Pick Up State<span class="mandatory">*</span></label><div id="pustate" class="form_block required"><?php __($form->input('pickup_state',array('error'=>false,'label'=>false,'id'=>'PickUpState','class'=>'text_box1','class'=>'select_box1','options'=>$states,'empty'=>'Select'))); ?></div></p>
			<p><label class="form_label">Pick Up Zip Code<span class="mandatory">*</span></label><div id="puzip" class="form_block required"><?php __($form->input('pickup_zipcode',array('error'=>false,'label'=>false,'id'=>'PickUpZipcode','class'=>'text_box1'))); ?></div></p></div>
			</div>
		</div>
	</div>
</div>
<div id="odoc" style="display: none;">
	<div>	
		<div class="table_row_data">
			<div class="repeat_divouter">
				<div class="float_div3"><label>Shipping Info<span class="mandatory">*</span></label></div>
				<div class="floatdiv3" ><label>Tracking #<span class="mandatory">*</span></label></div>
			</div>
			<div id="upload_container" >
				<div class="repeat_divouter" id="divrow1">
					<div id='ShipInfo'>
						<div id="shpinfo" class="float_div3 required"><?php echo $form->input('shipping_info', array('class'=>'select_box1', 'error'=>false,'id'=>'ShippingInfo', 'label'=>false, 'div'=>false, 'options'=>$shipoptions)); ?></div>
					</div>
					<div id='trackInfo'>
						<div id="track" class="floatdiv3" ><?php __($form->input('tracking',array('error'=>false,'div'=>false,'label'=>false,'id'=>'Tracking','class'=>'text'))); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div>
	<div>	
		<div class="table_row_data">
			
				<div class="repeat_divouter" id="divrow1">
<div class="g-recaptcha" data-sitekey="6LfHCAkUAAAAABTygBoxhzsGWHuOVriuDjQZWPMP"></div>
				</div>
		</div>
	</div>
</div>


<?php 
	__($form->submit('Submit', array('div'=>false,'class'=>'submitbtn fleft')));
	__($html->link('Cancel',array('controller'=>'users','action'=>'myaccount', 'type'=>low($counter->usertypes($usersession['User']['type']))),array('div'=>false,'class'=>'normalbutton fleft')));
	__($form->end()); 
?>
</div>
<script>
$("#HomePhone").keydown(function(e){var keycode =  e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#HomePhone").val();test = test.replace('-','').replace('-','');$("#HomePhone").val(test);}});$("#WorkPhone").keydown(function(e){var keycode =  e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#WorkPhone").val();test = test.replace('-','').replace('-','');$("#WorkPhone").val(test);}});$("#CellPhone").keydown(function(e){var keycode =  e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#CellPhone").val();test = test.replace('-','').replace('-','');$("#CellPhone").val(test);}});$("#AlternativePhone").keydown(function(e){var keycode =  e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#AlternativePhone").val();test = test.replace('-','').replace('-','');$("#AlternativePhone").val(test);}});function showval(){document.getElementById('PropertyStreetAddress').value=document.getElementById('SigningStreetAddress').value;document.getElementById('PropertyCity').value=document.getElementById('SigningCity').value;document.getElementById('PropertyState').value=document.getElementById('SigningState').value;document.getElementById('PropertyZipCode').value=document.getElementById('SigningZipCode').value;}function showdiv(){if(document.getElementById('DocumentDeliveryReceipt').value=='E'){document.getElementById('edoc').style.display="block";document.getElementById('pdoc').style.display="none";document.getElementById('odoc').style.display="none";}else if(document.getElementById('DocumentDeliveryReceipt').value=='P'){document.getElementById('edoc').style.display="none";document.getElementById('pdoc').style.display="block";document.getElementById('odoc').style.display="none";}else if(document.getElementById('DocumentDeliveryReceipt').value=='O'){document.getElementById('odoc').style.display="block";document.getElementById('edoc').style.display="none";document.getElementById('pdoc').style.display="none";}}</script>