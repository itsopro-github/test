<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php echo $html->css(array('jquery-ui-1.7.2.custom')); ?>
<?php e($javascript->link('jquery-ui-1.7.2.custom.min')); ?>
<div class="index">
	<div class="block">
		<p></p>
		<?php __($form->create('Order',array('type'=>'file','id'=>'editOrderFrm','url'=>array('controller'=>'orders','action'=>'edit', 'id'=>'', 'borrower'=>'')))); ?>
		<div class="titler">
			<div class="title"><h3 class="fleft"><?php __('Borrower Information'); ?></h3></div>
			<div class="titleactions"><span></span></div>
		</div>
		<div class="fieldblock">
			<div class="form_block required"><p><label class="form_label">First Name<span class="mandatory">*</span></label><?php __($form->input('first_name',array('error'=>false,'label'=>false,'id'=>'FirstName','class'=>'text_box'))); ?></p></div>
			<div class="form_block required"><p><label class="form_label">Last Name<span class="mandatory">*</span></label><?php __($form->input('last_name',array('error'=>false,'label'=>false,'id'=>'LastName','class'=>'text_box'))); ?></p></div>
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
			<div class="form_block "><p><label class="form_label">Cell Phone</label>
			<?php __($form->input('cell_phone1',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'CellPhone1','class'=>'text_box1 tiny1 fleft','value'=>$misc->splitphone(@$this->data['Order']['cell_phone'], 0, 3)))); ?>
			<?php __($form->input('cell_phone2',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'CellPhone2','class'=>'text_box1 tiny1 fleft','value'=>$misc->splitphone(@$this->data['Order']['cell_phone'], 3, 3)))); ?>
			<?php __($form->input('cell_phone3',array('maxlength'=>'4','error'=>false,'label'=>false,'id'=>'CellPhone3','class'=>'text_box1 tiny1','value'=>$misc->splitphone(@$this->data['Order']['cell_phone'], 6, 4)))); ?>
			</p></div>
			<div class="form_block "><p><label class="form_label">Alternative Phone</label>
			<?php __($form->input('alternative_phone1',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'AlternativePhone1','class'=>'text_box1 tiny1 fleft','value'=>$misc->splitphone(@$this->data['Order']['alternative_phone'], 0, 3)))); ?>
			<?php __($form->input('alternative_phone2',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'AlternativePhone2','class'=>'text_box1 tiny1 fleft','value'=>$misc->splitphone(@$this->data['Order']['alternative_phone'], 3, 3)))); ?>
			<?php __($form->input('alternative_phone3',array('maxlength'=>'4','error'=>false,'label'=>false,'id'=>'AlternativePhone3','class'=>'text_box1 tiny1','value'=>$misc->splitphone(@$this->data['Order']['alternative_phone'], 6, 4)))); ?>
			</p></div>
			<div class="form_block"><p><label class="form_label">E-mail Address</label><?php __($form->input('email',array('error'=>false,'label'=>false,'id'=>'E-mailAddress','class'=>'text_box'))); ?></p></div>
		</div>
		<div class="titler">
			<div class="title"><h3 class="fleft"><?php __('Signing Instructions & Additional Notes'); ?></h3></div>
			<div class="titleactions"><span style="float:left;padding-left:5px;"></span></div>
		</div>
		<div class="fieldblock">
			<div class="form_block "><p><label class="form_label">Specific Signing Instructions</label>
			<?php __($form->input('Order.signing_instrn',array('cols'=>'76','rows'=>'5','error'=>false,'label'=>false,'id'=>'signing_instrn','class'=>'text_area','escape' => false,'value'=>@$order['Order']['signing_instrn']))); ?></p></div> 
			<div class="form_block "><p><label class="form_label">Additional Notes</label>
			<?php __($form->input('Order.addtnl_notes',array('cols'=>'76','rows'=>'5','error'=>false,'label'=>false,'id'=>'addtnl_notes','class'=>'text_area','escape' => false,'value'=>@$order['Order']['addtnl_notes']))); ?>
			</p></div> 
			<div class="form_block "><p><label class="form_label">Additional Notification E-mail addresses [ E-mail addresses separated by commas ]</label>
			<?php __($form->input('Order.addtnl_emails',array('cols'=>'76','rows'=>'5','error'=>false,'label'=>false,'id'=>'addtnl_emails','class'=>'text_area','escape' => false,'value'=>@$order['Order']['addtnl_emails']))); ?></p></div>
		</div>
		<div class="titler">
			<div class="title"><h3 class="fleft"><?php __('Signing Address'); ?></h3></div>
			<div class="titleactions"><span style="float:left;padding-left:5px;">Address of Signing</span></div>
		</div>
		<div class="fieldblock">
			<div class="form_block required"><p><label class="form_label">Street Address<span class="mandatory">*</span></label><?php __($form->input('sa_street_address',array('error'=>false,'label'=>false,'id'=>'SigningStreetAddress','class'=>'text_box'))); ?></p></div> 
			<div class="form_block required"><p><label class="form_label">City<span class="mandatory">*</span></label><?php __($form->input('sa_city',array('error'=>false,'label'=>false,'id'=>'SigningCity','class'=>'text_box'))); ?></p></div>	
			<div class="form_block required"><p><label class="form_label">State<span class="mandatory">*</span></label><?php __($form->input('sa_state',array('error'=>false,'label'=>false,'id'=>'SigningState','class'=>'select_box','options'=>$states))); ?></p></div> 	
			<div class="form_block required"><p><label class="form_label">Zip Code<span class="mandatory">*</span></label><?php __($form->input('sa_zipcode',array('error'=>false,'label'=>false,'id'=>'SigningZipCode','class'=>'text_box'))); ?></p></div>
			<div class="form_block required">
    			<label class="log_label"></label><p><input type="checkbox" value="1" id="terms" onchange='showval()'>Click if Property Address is same as Signing Address</p>
    		</div>
    	</div>
    	<div class="titler">
			<div class="title"><h3 class="fleft"><?php __('Property Address'); ?></h3></div>
			<div class="titleactions"><span style="float:left;padding-left:5px;">Address of property for loan docs</span></div>
		</div>
		<div class="fieldblock">
			<div class="form_block required"><p><label class="form_label">Street Address<span class="mandatory">*</span></label><?php __($form->input('pa_street_address',array('error'=>false,'label'=>false,'id'=>'PropertyStreetAddress','class'=>'text_box'))); ?></p></div> 
			<div class="form_block required"><p><label class="form_label">City<span class="mandatory">*</span></label><?php __($form->input('pa_city',array('error'=>false,'label'=>false,'id'=>'PropertyCity','class'=>'text_box'))); ?></p></div>	
			<div class="form_block required"><p><label class="form_label">State<span class="mandatory">*</span></label><?php __($form->input('pa_state',array('error'=>false,'label'=>false,'id'=>'PropertyState','class'=>'select_box','options'=>$states))); ?></p></div> 	
			<div class="form_block required"><p><label class="form_label">Zip Code<span class="mandatory">*</span></label><?php __($form->input('pa_zipcode',array('error'=>false,'label'=>false,'id'=>'PropertyZipCode','class'=>'text_box'))); ?></p></div>
<?php 
		echo $form->input('id');
		__($form->submit('Submit', array('div'=>false,'class'=>'submitbtn fleft')));
		__($html->link('Cancel',array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($this->data['Order']['first_name'].' '.$this->data['Order']['last_name']),'id'=>$this->data['Order']['id']),array('div'=>false,'class'=>'normalbutton fleft')));
		__($form->end()); 
?>
		</div>
	</div>
</div>
<script>
$("#HomePhone").keydown(function(e){
    var keycode =  e.keyCode ? e.keyCode : e.which;
    
     if(keycode == 8){
     var test= $("#HomePhone").val();
	test = test.replace('-','').replace('-','');
	$("#HomePhone").val(test);


    }
});
$("#WorkPhone").keydown(function(e){
    var keycode =  e.keyCode ? e.keyCode : e.which;
    
     if(keycode == 8){ // backspace
  
    
     var test= $("#WorkPhone").val();
	test = test.replace('-','').replace('-','');
	$("#WorkPhone").val(test);


    }
});
$("#CellPhone").keydown(function(e){
    var keycode =  e.keyCode ? e.keyCode : e.which;
    
     if(keycode == 8){ // backspace
  
    
     var test= $("#CellPhone").val();
	test = test.replace('-','').replace('-','');
	$("#CellPhone").val(test);


    }
});
$("#AlternativePhone").keydown(function(e){
    var keycode =  e.keyCode ? e.keyCode : e.which;
    
     if(keycode == 8){ // backspace
  
    
     var test= $("#AlternativePhone").val();
	test = test.replace('-','').replace('-','');
	$("#AlternativePhone").val(test);


    }
});
function showval(){document.getElementById('PropertyStreetAddress').value=document.getElementById('SigningStreetAddress').value;document.getElementById('PropertyCity').value=document.getElementById('SigningCity').value;document.getElementById('PropertyState').value=document.getElementById('SigningState').value;document.getElementById('PropertyZipCode').value=document.getElementById('SigningZipCode').value;}</script>