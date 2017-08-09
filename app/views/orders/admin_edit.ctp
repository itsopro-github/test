<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php e($javascript->link('ui.datepicker')); ?>
<script type="text/javascript">$(function(){$('#DateOfSigning').datepicker({});});</script>
<?php
$estyle = $pstyle = $sstyle = $tstyle = $otstyle = "";
if ($this->data['Order']['doc_submit']=='E') {
	$estyle="display: block";
	$pstyle="display: none";
	$ostyle="display: none";
} else if($this->data['Order']['doc_submit']=='P') {
	$estyle="display: none";
	$pstyle="display: block";
	$ostyle="display: none";
} else {
	$estyle="display: none";
	$pstyle="display: none";
	$ostyle="display: block";
}
if(isset($this->data['Order']['orderstatus_id'])=='7') {
	$otstyle="display: block";
} else {
	$otstyle="display: none";
}
$html->addCrumb('Orders', array('controller'=>'orders','action'=>'index'));
$html->addCrumb($this->data['Order']['first_name'], array());
?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header"><h1 class="fleft">Edit Order [<?php __($this->data['Order']['first_name']); ?>]</h1>
			<ul>
				<li><?php __($html->link('Submit changes', '#',array('onclick'=>'$("#editOrderFrm").submit();'))); ?></li>
				<li><?php __($html->link(__('View this Order', true), array('controller'=>'orders','action'=>'view',$this->data['Order']['id']))); ?></li>
				<?php if(in_array($this->data['Order']['orderstatus_id'], array(6,9,10))) { ?>
					<li><?php __($html->link(__('List Archive', true), array('controller'=>'orders','action'=>'index','status'=>'archived','param'=>'s:n'))); ?></li>
				<?php }else{?>
				<li><?php __($html->link(__('Back to All Orders', true), array('controller'=>'orders','action'=>'index'))); ?></li>
				<?php } ?>
	       </ul>
       	</div>
		<div class="block_content">
	 		<?php __($form->create('Order',array('url'=>array('controller'=>'orders','action'=>'edit'),'type'=>'file','id'=>'editOrderFrm','name'=>'editOrderFrm'))); ?>
	       	<?php __($form->input('id'));?>
	       	<table class="formtable">
	       		<tr><th>Personal Details</th></tr>
				<tr><th colspan="4"><hr /></th></tr>
				<tr>
					<td width="25%"><label>First name<span class="mandatory">*</span></label></td>
					<td width="25%"><?php __($form->input('first_name',array('error'=>false,'label'=>false,'id'=>'FirstName','class'=>'text'))); ?></td>
					<td width="25%"><label class="form_label">Last name<span class="mandatory">*</span></label></td>
					<td width="25%"><?php __($form->input('last_name',array('error'=>false,'label'=>false,'id'=>'LastName','class'=>'text'))); ?></td>
				</tr>
				<tr>
					<td><label class="form_label">Home phone<span class="mandatory">*</span></label></td>
					<td>
						<?php __($form->input('home_phone1',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'HomePhone1','class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Order']['home_phone'], 0, 3)))); ?>
						<?php __($form->input('home_phone2',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'HomePhone2','class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Order']['home_phone'], 3, 3)))); ?>
						<?php __($form->input('home_phone3',array('maxlength'=>'4','error'=>false,'label'=>false,'id'=>'HomePhone3','class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Order']['home_phone'], 6, 4)))); ?>
					</td>
					<td><label class="form_label">Work phone</label></td>
					<td>
						<?php __($form->input('work_phone1',array('maxlength'=>'3','label'=>false,'error'=>false,'id'=>'WorkPhone1','class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Order']['work_phone'], 0, 3)))); ?>
						<?php __($form->input('work_phone2',array('maxlength'=>'3','label'=>false,'error'=>false,'id'=>'WorkPhone2','class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Order']['work_phone'], 3, 3)))); ?>
						<?php __($form->input('work_phone3',array('maxlength'=>'4','label'=>false,'error'=>false,'id'=>'WorkPhone3','class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Order']['work_phone'], 6, 4)))); ?>
					</td>
				</tr>
				<tr>
					<td><label class="form_label">Cell phone</label></td>
					<td>
						<?php __($form->input('cell_phone1',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'CellPhone1','class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Order']['cell_phone'], 0, 3)))); ?>
						<?php __($form->input('cell_phone2',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'CellPhone2','class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Order']['cell_phone'], 3, 3)))); ?>
						<?php __($form->input('cell_phone3',array('maxlength'=>'4','error'=>false,'label'=>false,'id'=>'CellPhone3','class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Order']['cell_phone'], 6, 4)))); ?>
					</td>
					<td><label class="form_label">Alternative phone</label></td>
					<td>
						<?php __($form->input('alternative_phone1',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'AlternativePhone1','class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Order']['alternative_phone'], 0, 3)))); ?>
						<?php __($form->input('alternative_phone2',array('maxlength'=>'3','error'=>false,'label'=>false,'id'=>'AlternativePhone2','class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Order']['alternative_phone'], 3, 3)))); ?>
						<?php __($form->input('alternative_phone3',array('maxlength'=>'4','error'=>false,'label'=>false,'id'=>'AlternativePhone3','class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Order']['alternative_phone'], 6, 4)))); ?>
					</td>
				</tr>
				<tr>
					<td><label class="form_label">E-mail address</label></td>
					<td><?php __($form->input('email',array('error'=>false,'label'=>false,'id'=>'EmailAddress','class'=>'text'))); ?></td>
					<td><label class="form_label">Date of signing<span class="mandatory">*</span></label></td>
					<td><?php  __($form->input('date_signing',array('error'=>false,'label'=>false,'id'=>'DateOfSigning','class'=>'text','type'=>'text','readonly'=>true,'value'=> $counter->formatdate('nsdate',$this->data['Order']['date_signing'])))); ?></td>
				</tr>
				<tr>
					<td><label class="form_label">File number<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('file',array('error'=>false,'label'=>false,'id'=>'File','class'=>'text'))); ?></td>	
<?php
				if($admindata['Admin']['type']!='E'){
?>
					<td><label class="form_label">Owned by</label></td>
					<td>
<?php
					if(isset($this->data['Order']['orderstatus_id'])=='1') {
					__($form->input('attended_by',array('error'=>false,'label'=>false,'id'=>'AttendedBy','class'=>'select_box','options'=>$adminList,'empty'=>'--Select Owner--'))); ?></td>
<?php
					} else {
						__($form->input('attended_by',array('error'=>false,'label'=>false,'id'=>'AttendedBy','class'=>'select_box','options'=>$adminList))); ?></td>
<?php
					}
				}
?>
				</tr>
				<tr>
					<td><label class="form_label">Client<span class="mandatory">*</span></label></td>
					<td><?php echo $form->input('user_id', array('id'=>'Client', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$clientList,'empty'=>'--Select--')); ?></td>	
				</tr>
				<tr><th colspan='4'>Signing Instructions & Additional Notes</th></tr>
				<tr>
					<td><label class="form_label">Specific signing instructions</label></td>
					<td colspan="3"><?php __($form->input('signing_instrn',array('error'=>false,'label'=>false,'id'=>'Specific_Signing_Instructions','class'=>'text', 'rows'=>'6', 'div'=>false,'escape' => false, 'style'=>'width:97%')));?></td>
				</tr>
				<tr>	
					<td><label class="form_label">Additional notes</label></td>
					<td colspan="3"><?php __($form->input('addtnl_notes',array('error'=>false,'label'=>false,'id'=>'Additional_Notes','class'=>'text', 'rows'=>'6', 'div'=>false, 'escape' => false,'style'=>'width:97%'))); ?></td>
				</tr>
				<tr>
					<td><label class="form_label">Additional notification e-mail addresses</label></td>
					<td colspan="3"><?php __($form->input('addtnl_emails',array('error'=>false,'escape' => false,'label'=>false,'id'=>'Additional_Notification_Emails','class'=>'text', 'rows'=>'1', 'style'=>'width:97%', 'div'=>false))); ?><br /><span class="mandatory">[ E-mail addresses should be separated by commas ]</span></td>
				</tr>
				<tr>
					<th>Signing Address</th>
				</tr>
				<tr>
					<th colspan="4"><hr /></th></tr>
				<tr>
					<td><label class="form_label">Street address<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('sa_street_address',array('error'=>false,'label'=>false,'id'=>'SigningStreetAddress','class'=>'text'))); ?></td>
					<td><label class="form_label">City<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('sa_city',array('error'=>false,'label'=>false,'id'=>'SigningCity','class'=>'text'))); ?></td>
				</tr>
				<tr>
					<td><label class="form_label">State<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('sa_state',array('error'=>false,'label'=>false,'id'=>'SigningState','class'=>'select_box','options'=>$states, 'empty'=>'Select'))); ?></td>
					<td><label class="form_label">Zip code<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('sa_zipcode',array('error'=>false,'label'=>false,'id'=>'SigningZipCode','class'=>'text'))); ?></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="3"><p><input type="checkbox" value="1" id="terms" onchange='showval()' name="data[User][terms]">Click if Property Address is the same as Signing Address</p></td>
				</tr>
				<tr><th>Property Address</th></tr>
				<tr><th colspan="4"><hr /></th></tr>
				<tr>
					<td><label class="form_label">Street address<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('pa_street_address',array('error'=>false,'label'=>false,'id'=>'PropertyStreetAddress','class'=>'text'))); ?></td>
					<td><label class="form_label">City<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('pa_city',array('error'=>false,'label'=>false,'id'=>'PropertyCity','class'=>'text'))); ?></td>
				</tr>
				<tr>
					<td><label class="form_label">State<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('pa_state',array('error'=>false,'label'=>false,'id'=>'PropertyState','class'=>'select_box','options'=>$states,'empty'=>'Select'))); ?></td>
					<td><label class="form_label">Zip code<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('pa_zipcode',array('error'=>false,'label'=>false,'id'=>'PropertyZipCode','class'=>'text'))); ?></td>
				</tr>
				<tr><th colspan="4">Document Delivery Information</th></tr>
				<tr><th colspan="4"><hr /></th></tr>
				<tr>
					<td width="25%"><label>Is it a new request or re-sign?<span class="mandatory">*</span></label></td>
					<td width="25%"><?php echo $form->input('doc_info', array('class'=>'select_box', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$docinfooptions,'empty'=>'Select')); ?></td>
					<td width="25%"><label>What type of loan document?<span class="mandatory">*</span></label></td>
					<td width="25%"><div class=" required"><?php echo $form->input('doc_type', array('id'=>'Documenttype', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$doc_typesoptions,'empty'=>'Select')); ?></div></td>
				</tr>
				<tr>
					<td><label class="form_label">How will you send the loan documents?<span class="mandatory">*</span></label></td>
					<td><div  class=" required"><?php echo $form->input('doc_submit', array('id'=>'DocumentDeliveryReceipt', 'error'=>false, 'label'=>false,'onchange'=>'showdiv()', 'div'=>false,'class'=>'select_box','options'=>$doctypeoptions,'empty'=>'Select')); ?></div></td>
				</tr>
				<tr>
					<td colspan="4">
						<div id="edoc" style="<?=$estyle?>">
							<table>
								<tr>
									<th>EDOCS</th>
								</tr>
								<tr>
									<th colspan="4"><hr /></th>
								</tr>
								<tr>
									<td>
										<div>	
											<div class="table_row_data">
												<div id="upload_container" >
													<div class="repeat_divouter">
														<div class="float_div1"><label><b>Sl No</b></label></div>
														<div class="float_div"><label><b>Type</b></label></div>
														<div class="float_div4" style="width: auto !important;"><label class="biglabel"><b>Upload EDOC</b><span class="mandatory">* [ Max upload limit: 5 Mb, Recommended file types are 'pdf','doc','docx' ]</span></label></div>
													</div>
<?php 
		$cnt_tottrack = (count($orderedocs) == 0) ? 1 : count($orderedocs)+1;
		if($this->data['Order']['doc_submit']=='E'){
			if(!empty($orderedocs)){
				foreach ($orderedocs as $key=>$orderedoc):
?>
													<div class="repeat_divouter" id="divrow1">
														<div class="float_div1"><?php echo ++$key;?></div>
														<div class="float_div"><?php echo $pdftypeoptions[$orderedoc['OrderEdocs']['ptype']]; ?></div>
														<div id="edocf" class="float_div4"><?php echo $orderedoc['OrderEdocs']['edocfile']; ?></div>
													</div>
<?php 	
				endforeach;
			}
		}  
?>
													<div class="repeat_divouter">
														<div class="float_div1"><?=$cnt_tottrack?></div>
														<div class="float_div"><?php echo $form->input('ptype', array('class'=>'sel_inner_inputs','name'=>'data[OrderEdocs][ptype][]','id'=>'ptype1', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$pdftypeoptions, 'empty'=>'--Select--'));?></div>
														<div id="edocf" class="float_div4"><?php echo $form->file('edocfile', array('label'=>false,'id'=>'EDOC'.$cnt_tottrack,'name'=>'data[OrderEdocs][edocfile][]',"class"=>"inner_input ",'error'=>false)); ?></div>
													</div>
												</div>
												<div style="display:block;" id="fileid" class="addtracks"><p><a href="javascript:void(0)" onclick="javascript: add_row();" id='addMore' class="fright">Add another EDOC</a></p><input type="hidden" id="upload_count" name="upload_count" value="<?php echo $cnt_tottrack;?>"/></div>
											</div>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<div id="pdoc" style="<?=$pstyle?>">
							<table>
								<tr>
									<th>Pick Up Docs</th>
								</tr>
								<tr>
									<th colspan="4"><hr /></th>
								</tr>
								<tr>
									<td width="25%"><label class="form_label">Pick up address<span class="mandatory">*</span></label></td>
									<td width="25%"><div id="puadd" class="form_block required"><?php __($form->input('pickup_address',array('error'=>false,'label'=>false,'id'=>'PickUpAddress','class'=>'text'))); ?></div></td>
									<td width="25%"><label class="form_label">City<span class="mandatory">*</span></label></td>
									<td width="25%"><div id="pucity" class="form_block required"><?php __($form->input('pickup_city',array('error'=>false,'label'=>false,'id'=>'PickUpCity','class'=>'text'))); ?></div></td>
								</tr>
								<tr>
									<td><label class="form_label">State<span class="mandatory">*</span></label></td>
									<td><div id="pustate" class="form_block required"><?php __($form->input('pickup_state',array('error'=>false,'label'=>false,'id'=>'PickUpState','class'=>'select_box','options'=>$states,'empty'=>'Select'))); ?></div></td>
									<td><label class="form_label"> Zip code<span class="mandatory">*</span></label></td>
									<td><div id="puzip" class="form_block required"><?php __($form->input('pickup_zip',array('error'=>false,'label'=>false,'id'=>'PickUpZipCode','class'=>'text'))); ?></div></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<div id="odoc" style="<?=$ostyle?>">
							<table>
								<tr>
									<th>Overnight</th>
								</tr>
								<tr>
									<th colspan="4"><hr /></th>
								</tr>
								<tr>
									<td width="25%"><label class="form_label">Shipping info<span class="mandatory">*</span></label></td>
									<td width="25%"><div id="shpinfo" class="form_block"><?php echo $form->input('shipping_info', array('class'=>'select_box', 'error'=>false,'id'=>'ShippingInfo', 'label'=>false, 'div'=>false, 'options'=>$shipoptions, 'empty'=>'--Select--')); ?></div></td>
									<td width="25%"><label class="form_label">Tracking #<span class="mandatory">*</span></label></td>
									<td width="25%"><div id="track" class="form_block"><?php __($form->input('tracking',array('error'=>false,'label'=>false,'id'=>'Tracking','class'=>'text'))); ?></div></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="4"><hr />
						<?php __($form->submit('Submit', array('div'=>false,'class'=>'submit fleft'))); ?>
						<?php __($html->link('Cancel',array('controller'=>'orders','action'=>'view',$this->data['Order']['id']),array('div'=>false,'class'=>'normalbutton fleft'))); ?>
					</td>
				</tr>
			</table>
		<?php __($form->end());?>
		</div>
	</div>
</div>
<script>
$("#HomePhone").keydown(function(e){
    var keycode =  e.keyCode ? e.keyCode : e.which;
    
     if(keycode == 8){ // backspace
  
     // $("#HomePhone").focus();
     // $("#HomePhone").select();
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

function showval(){document.getElementById('PropertyStreetAddress').value=document.getElementById('SigningStreetAddress').value;document.getElementById('PropertyCity').value=document.getElementById('SigningCity').value;document.getElementById('PropertyState').value=document.getElementById('SigningState').value;document.getElementById('PropertyZipCode').value=document.getElementById('SigningZipCode').value;}function showdiv(){if(document.getElementById('DocumentDeliveryReceipt').value=='E'){document.getElementById('edoc').style.display="block";document.getElementById('pdoc').style.display="none";document.getElementById('odoc').style.display="none";}else if(document.getElementById('DocumentDeliveryReceipt').value=='P'){document.getElementById('edoc').style.display="none";document.getElementById('pdoc').style.display="block";document.getElementById('odoc').style.display="none";}else if(document.getElementById('DocumentDeliveryReceipt').value=='O'){document.getElementById('odoc').style.display="block";document.getElementById('edoc').style.display="none";document.getElementById('pdoc').style.display="none";}}$('#EmailAddress').focusout(function(){var un=$('#EmailAddress').val();$("#Username").val(un);});$('#LastName').focusout(function(){var ln=$('#LastName').val();$("#Password").val(ln);});</script>