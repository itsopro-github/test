<?php
if($order['Order']['shipping_info']=='F') {
	$tracking =	'<a href="'.Configure::read('fedextracking').$order['Order']['tracking'].'" target="_blank">'. $order['Order']['tracking'] .'</a>';
} elseif($order['Order']['shipping_info']=='U') {
	$tracking =	'<a href="'.Configure::read('upstracking').$order['Order']['tracking'].'" target="_blank">'. $order['Order']['tracking'] .'</a>';
} elseif($order['Order']['shipping_info']=='D') {
	$tracking =	'<a href="'.Configure::read('dhltracking').'" target="_blank">'. $order['Order']['tracking'] .'</a>';
} elseif($order['Order']['shipping_info']=='G') {
	$tracking =	'<a href="'.Configure::read('gsotracking').'" target="_blank">'. $order['Order']['tracking'] .'</a>';
} elseif($order['Order']['shipping_info']=='E') {
	$tracking =	'<a href="'.Configure::read('overniteexpress').'" target="_blank">'. $order['Order']['tracking'] .'</a>';
} else {
	$tracking =	$order['Order']['tracking'];
}

if($order['Order']['track_shipping_info']=='F') {
	$trackingno = '<a href="'.Configure::read('fedextracking').$order['Order']['tracking_no'].'" target="_blank">'. $order['Order']['tracking_no'] .'</a>';
} elseif($order['Order']['track_shipping_info']=='U') {
	$trackingno = '<a href="'.Configure::read('upstracking').$order['Order']['tracking_no'].'" target="_blank">'. $order['Order']['tracking_no'] .'</a>';
} elseif($order['Order']['track_shipping_info']=='D') {
	$trackingno = '<a href="'.Configure::read('dhltracking').'" target="_blank">'. $order['Order']['tracking_no'] .'</a>';
} elseif($order['Order']['track_shipping_info']=='G') {
	$trackingno = '<a href="'.Configure::read('gsotracking').'" target="_blank">'. $order['Order']['tracking_no'] .'</a>';
} elseif($order['Order']['track_shipping_info']=='E') {
	$trackingno = '<a href="'.Configure::read('overniteexpress').'" target="_blank">'. $order['Order']['tracking_no'] .'</a>';
} else {
	$trackingno = $order['Order']['tracking_no'];
}
if($usersession['User']['type'] == 'C') { 
?>
<style>
.dispblck{
display:block;
}
.dispnone{
display:none;
}
</style>
<div class="orders index">	
	<div class="block">
		<div class="titler1">
			<div class="title1actions fleft">
			<div><h3 class="fleft">Signing Status</h3></div>
		</div>
		<?php if(in_array($order['Order']['orderstatus_id'], array('2','3','4','5','7'))) { ?>
		<div class="title1actions fleft">
			<div id="upddiv" ><h3 class="fleft"><?php __($html->link('Change Status', 'javascript:void();',array('onclick'=>"loadBlocks('cstatdiv','upddiv');$('#ssdiv').show();")));?></h3></div>
		</div>
		<?php } ?>
		<div id="ssdiv" style="display:none;" class="titleactions" ><span style="float: left; padding-left: 5px;font-size:13px;">Current Status of Signing. Update Below</span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Current Status'); ?></th>
					<td><?php __($order['Orderstatus']['status']); ?></td>
				</tr>
			</table>
		</div>
			<div id="cstatdiv" style="display:none;">
		<div class="titler">
			<div class="title1actions fleft"><h3 class="fleft"><?php __($html->link('Change Status', '#upddiv',array('onclick'=>"hideBlocks('upddiv','cstatdiv');$('#ssdiv').hide();")));?></h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">Update Progress of Signing Below.</span></div>
		</div>
		<div class="fieldblock"><iframe frameborder="0" src="<?php __(Configure::read('WEB_URL')); ?>signings/changestatus/<?php echo $order['Order']['id'];?>-<?php echo $order['Order']['first_name'].' '.$order['Order']['last_name'];?>" width="100%" height="625px;" ></iframe></div>
		</div>
		<div id="shisdiv" style="display:block;">
			<div class="titler1">
				<div class="title1actions fleft">
					<div><h3 class="fleft">Signing History</h3></div>
				</div>
				<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">Chronological Record of all Status Updates.</span></div>
			</div>
			<div class="fieldblock">
				<div class="signinghistories index">
					<div class="block" style="background:white;">
<?php
	if($signinghistories) {	
?>
	<table cellpadding="0" cellspacing="0" class="tablelist">			
		<thead>
			<th width="1%">No</th>
			<th width="5%">Appointment</th>
			<th width="64%">Notes</th>
			<th width="14%">Sender</th>
			<th width="16%">Created</th>
		</thead>
<?php
$j = 0;
foreach ($signinghistories as $signinghistory):
	$class = null;
	$assignee = "";
	if ($j++ % 2 == 0) {$class = ' class="altrow"';}
	if($signinghistory['Orderstatus']['status']=='ASSIGNED') {
		$currentassignee = $misc->getsender('NN', $signinghistory['Signinghistory']['id']);
		$assignee = ' [ <span style="color: #FC770A;">'.$currentassignee.'</span> ]';
	}
?>

	<tr <?php __($class);?>>
		<td><?php __($counter->counters($j));?></td>
		<td><?php if($signinghistory['Orderstatus']['status']=="SCHEDULED" || $signinghistory['Orderstatus']['status']=="SIGNING COMPLETED"){ __($signinghistory['Signinghistory']['appointment_time']);}else{ echo " "; }  ?>&nbsp;</td>
		<td><?php __($signinghistory['Orderstatus']['status'].$assignee.' : '.nl2br($signinghistory['Signinghistory']['notes'])); ?>
<?php
			if($signinghistory['Signinghistory']['orderstatus_id']>='7'){ 
				echo "<br />[ Tracking #: ".$misc->gettracking($signinghistory['Signinghistory']['order_id'], true)." ]";
			}
?>
		</td>
		<td><?php echo $misc->getsender($signinghistory['Signinghistory']['added_by'],$signinghistory['Signinghistory']['user_id']); ?></td>
		<td><?php __($counter->formatdate('nsdatetimemeridiem',$signinghistory['Signinghistory']['created'])); ?></td>
	</tr>
<?php 
endforeach;
?>		
	</table>
<?php
} else {
	__($this->element('nobox', array('displaytext'=>'No status updates found')));		
}
?></div></div>
</div>
		</div>
		
		<div class="titler1">
			<div class="title1actions fleft">
			<div><h3 class="fleft">Borrower’s Information</h3></div>
		</div>
		<div class="title1actions fleft">
			<div id="sgnreqdiv"><h3 class="fleft"><?php __($html->link('Signing Requirements', '#sreqdiv',array('onclick'=>"loadBlocks('sreqdiv','sgnreqdiv');checkdivs1();")));?></h3></div>
		</div>
		
		<div class="title1actions fleft">
			<div  id="ddidiv" ><h3 class="fleft"><?php __($html->link('Document Delivery Info', '#ddinfodiv',array('onclick'=>"loadBlocks('ddinfodiv','ddidiv');checkdivs1();")));?></h3></div>
		</div>
	<?php	if($usersession['User']['type'] == 'C') { 
if(!empty($assign)){ ?>
		<div class="title1actions fleft">
			<div id="nidiv" ><h3 class="fleft"><?php __($html->link('Notary Info', '#ntrydiv',array('onclick'=>"loadBlocks('ntrydiv','nidiv');checkdivs1();")));?>
			</h3></div>
		</div>
		
		<?php }
	} ?>
		<div id="bidiv" style="display:none;"  class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">Borrower’s Contact Info</span></div>
		</div>
		<div class="fieldblock">
			<p>
<?php
				if($usersession['User']['type'] == 'C' && $order['Order']['orderstatus_id']<>'6' && $order['Order']['orderstatus_id']<>'9' && $order['Order']['orderstatus_id']<>'10') {
?>
					<div style="color:#1F3F66;">
						<?php __($html->link('<div class="maedit"><p>'.$html->image('btn_edit.png', array('alt'=>'Click to Edit Info Below','title'=>'Click to Edit Info Below')).'Click to Edit Info Below</p></div>', array('controller'=>'orders','action'=>'edit','borrower'=>Inflector::slug(low($order['Order']['first_name'].' '.$order['Order']['last_name'])),'id'=>$order['Order']['id']), array('escape'=>false)));?>
					</div>
<?php
				}
?>
			</p>
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Borrower'); ?></th>
					<td colspan="3"><?php __($order['Order']['first_name'].' '.$order['Order']['last_name']); ?></td>	
				</tr>
				<tr>
					<th><?php __('E-mail Address'); ?></th>
					<td colspan="3"><?php echo $order['Order']['email']; ?></td>
				</tr>
				<tr>
					<th><?php __('Home Phone'); ?></th>
					<td><?php __($counter->tousphone($order['Order']['home_phone'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Cell Phone'); ?></th>
					<td><?php __($counter->tousphone($order['Order']['cell_phone'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Work Phone'); ?></th>
					<td><?php __($counter->tousphone($order['Order']['work_phone'])); ?></td>	
				</tr>
				<tr>
					<th><?php __('Alternative Phone'); ?></th>
					<td><?php __($counter->tousphone($order['Order']['alternative_phone'])); ?></td>
				</tr>
			</table>
		</div>
			<div id="sreqdiv" style="display:none;">
		<div class="titler">
			<div class="title1actions fleft"><h3 class="fleft"><?php __($html->link('Signing Requirements', '#sgnreqdiv',array('onclick'=>"hideBlocks('sgnreqdiv','sreqdiv');checkdivs1();")));?></h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">IMPORTANT! Info to Properly Conduct Signing.</span></div>
		</div>
		<div class="fieldblock">
			<p>
			<?php if($usersession['User']['type'] == 'C' && $order['Order']['orderstatus_id']<>'6' && $order['Order']['orderstatus_id']<>'9' && $order['Order']['orderstatus_id']<>'10') { ?>
				<div style="color:#1F3F66;">
					<?php __($html->link('<div class="maedit"><p>'.$html->image('btn_edit.png', array('alt'=>'Click to Edit Info Below','title'=>'Click to Edit Info Below')).'Click to Edit Info Below</p></div>', array('controller'=>'orders','action'=>'edit','borrower'=>Inflector::slug(low($order['Order']['first_name'].' '.$order['Order']['last_name'])),'id'=>$order['Order']['id']), array('escape'=>false)));?>
				</div>
			<?php } ?>
			</p>
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Specific Signing Instructions'); ?></th>
					<td colspan="3"><?php echo nl2br($order['Order']['signing_instrn']); ?></td>
				</tr>
				<tr>
					<th><?php __('Additional Notes'); ?></th>
					<td colspan="3"><?php echo nl2br($order['Order']['addtnl_notes']); ?></td>
				</tr>
				<?php if($usersession['User']['type'] == 'C') { ?>
				<tr>
					<th><?php __('Additional Notification E-mails'); ?></th>
					<td colspan="3"><?php echo nl2br($order['Order']['addtnl_emails']); ?></td>
				</tr>
				<?php }?>
			</table>
		</div></div>
<div id="ddinfodiv" style="display:none;">
		<div class="titler">
			<div class="title1actions fleft"><h3 class="fleft"><?php __($html->link('Document Delivery Info', '#ddidiv',array('onclick'=>"hideBlocks('ddidiv','ddinfodiv');checkdivs1();")));?></h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">The Type of Docs and How Docs will be Sent to Notary.</span></div>
		</div>
		<div class="fieldblock">
			<table id="eDocsTable" cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('New Request / Re-sign'); ?></th>
					<td><?php __($docinfooptions[$order['Order']['doc_info']]); ?></td>
				</tr>
				<tr>
					<th><?php __('Type of Loan Docs'); ?></th>
					<td><?php __($doc_typesoptions[$order['Order']['doc_type']]);  ?></td>
				</tr>
				<tr class='docDelivery'>
					<th><?php __('Delivery of Docs'); ?></th>
					<td><?php __($doctypeoptions[$order['Order']['doc_submit']]); ?></td>
				</tr>
<?php 
	if($order['Order']['doc_submit']=='E'){
		if(!empty($orderedocs)){
			foreach ($orderedocs as $key=>$orderedoc):
?>
			<tr class="document">
				<th><?php echo @$pdftypeoptions[$orderedoc['OrderEdocs']['ptype']]; ?></th>
				<td><?php __($html->link('Download '.$orderedoc['OrderEdocs']['edocfile'], array('controller'=>'orders', 'action'=>'download','id'=>$this->params['id'],'borrower'=>$this->params['borrower'],'filename'=>$orderedoc['OrderEdocs']['edocfile']))); ?> [<a href="javascript:removeEdoc(<?php echo $orderedoc['OrderEdocs']['id'] ?>)">Remove</a>]</td>
			</tr>
<?php 
			endforeach;
		}
?>

<?php ///////////////////////////////////////////////////// ?>




<script>
	function refreshEDocs(docs)
	{
		$("#eDocsTable tr.document").remove();

		for(var i = 0 ; i < docs.length; i++)
		{
			var item = docs[i];
			var pType = item.order_edocs.ptype == 'C' ?	'Escrow docs' : item.order_edocs.ptype == 'L' ? 'Loan Docs' : 'MISC';
			$('#eDocsTable tr.docDelivery').after(
			'<tr class="document">' +
				'<th>' + pType + '</th>' +
				'<td><a href="' + window.location.pathname + "/" + item.order_edocs.edocfile + '">Download ' + item.order_edocs.edocfile + '</a> [<a href="javascript:removeEdoc(' + item.order_edocs.id + ')">Remove</a>]</td>' +
			'</tr>'  
			);
		}
	}
	
	function resetEDocsAddArea()
	{
		$("#upload_container").empty();
		
		$("#upload_container").html(' \
			<div class="repeat_divouter" id="divrow1"> \
				<div class="float_div1">1</div> \
				<div class="float_div"> \
					<select name="data[OrderEdocs][ptype][]" class="sel_inner_inputs" id="ptype1"> \
						<option value="">--Select--</option> \
						<option value="C">Escrow docs</option> \
						<option value="L">Loan Docs</option> \
						<option value="M">MISC</option> \
					</select> \
				</div> \
				<div id="edocf" class="float_div4"><input type="file" name="data[OrderEdocs][edocfile][]" id="EDOC1" class="inner_input "></div> \
			</div> \
		')
	}
	
	function removeEdoc(id)
	{
		$.ajax({
			url: "/signings/fileinfo/remove-doc/" + id,
			success: function(data){
				refreshEDocs($.parseJSON(data));
			}
		});
	}
	
	function uploadDocs()
	{
		var data = new FormData(jQuery('#addeDocsForm')[0]);
		
		$.ajax({
			url: '/signings/fileinfo/add-docs',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			success: function(data){			
				resetEDocsAddArea();
				refreshEDocs($.parseJSON(data));
			}
		});

	}
	
	$( document ).ajaxStart(function() {
		$( ".ajaxspinner" ).show();
	});
	
	$( document ).ajaxComplete(function() {
		$( ".ajaxspinner" ).hide();
	});
	
</script>

	<tr>
		<td colspan="4">
			<form id="addeDocsForm" enctype="multipart/form-data" method="post" target="_blank" action="/signings/fileinfo/add-docs" accept-charset="utf-8">
				<strong>Add More Files</strong>
				<div id="edoc" style="display: block;">	
					<div class="table_row_data">
						<div class="repeat_divouter" style="width:100%">
							<div class="float_div1"><label>Nr</label></div>
							<div class="float_div"><label>Type</label></div>
							<div class="float_div6">
								<label class="biglabel">Upload EDOC<span class="mandatory">*</span><br><span class="mandatory">[ Max upload limit: 5 Mb, Recommended file types are 'pdf','doc','docx' ]</span><br>Need to convert your document to PDF? Click&gt;&gt; <a href="http://www.primopdf.com" class="fright" target="_blank">Convert to PDF</a></label>
							</div>
						</div>
						<div id="upload_container">
							<div class="repeat_divouter" id="divrow1">
								<div class="float_div1">1</div>
								<div class="float_div">
									<select name="data[OrderEdocs][ptype][]" class="sel_inner_inputs" id="ptype1">
										<option value="">--Select--</option>
										<option value="C">Escrow docs</option>
										<option value="L">Loan Docs</option>
										<option value="M">MISC</option>
									</select>
								</div>
								<div id="edocf" class="float_div4"><input type="file" name="data[OrderEdocs][edocfile][]" id="EDOC1" class="inner_input "></div>
							</div>
						</div>
						<div style="display:block;" id="fileid" class="addtracks">
							<p><a href="javascript:void(0)" onclick="javascript: add_row();" id="addMore" class="fright">+ Add another doc</a></p>
							<input type="hidden" id="upload_count" name="upload_count" value="1">
							<input type="hidden" id="order_id" name="order_id" value="<?php echo $this->params['id'] ?>">
						</div>
						<div style="overflow:hidden;">
							<div style="float:left;"><input type="button" onclick="uploadDocs()" value="Upload Docs" /></div>
							<div style="float:left;margin-left:10px;display:none;" class="ajaxspinner"><img src="/img/ajax-loader.gif" alt="ajax spinner" style="margin:0"></div>
						</div>
					</div>
				</div>
			</form>
		</td>
	</tr>
			
			
			
			
<?php ///////////////////////////////////////////////////// ?>			
			
			
			
			
			
			
<?php 

	} elseif($order['Order']['doc_submit']=='P') { 
?>
			<tr>
				<th><?php __('Pick Up Address'); ?></th>
				<td colspan="3"><?php __($order['Order']['pickup_address']); ?>, <?__($order['Order']['pickup_city']);?>, <?__($order['Order']['pickup_state']);?>, <?__($order['Order']['pickup_zip']);?></td>
			</tr>
<?php 
	} else {
		if($order['Order']['shipping_info']) {
?>
			<tr>
				<th><?php __('Shipping info'); ?></th>
				<td><?php __($shipoptions[$order['Order']['shipping_info']]); ?></td>
			</tr>
<?php
		}
	}
	if($tracking && $order['Order']['doc_submit']=='O') {
?>
			<tr>
				<th><?php __('Tracking #'); ?></th>
				<td><?php __($tracking)?></td>
			</tr>
<?php
	}
	if($trackingno && $order['Order']['orderstatus_id']>='7'){
?>
			<tr>
				<th><?php __('Tracking # (after Signing Completed)'); ?></th>
				<td><?php __($trackingno); ?></td>
			</tr>
<?php
	}
?>
			</table>
		</div>
	</div>
<?php
//No need to show notary his details
if($usersession['User']['type'] == 'C') { 
	if(!empty($assign)) {
?>
		<div id="ntrydiv" style="display:none;">
		<div class="titler">
			<div class="title1actions fleft"><h3 class="fleft"><?php __($html->link('Notary Info', '#nidiv',array('onclick'=>"hideBlocks('nidiv','ntrydiv');checkdivs1();")));?></h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;"></span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Name'); ?></th>
					<td><?php __($assign[0]['User']['Notary']['first_name']." ".$assign[0]['User']['Notary']['last_name']); ?></td>
				</tr>
				<tr>
					<th><?php __('E-mail Address'); ?></th>
					<td><?php __($assign[0]['User']['Notary']['email']); ?></td>
				</tr>
				<tr>
					<th><?php __('Cell Phone'); ?></th>
					<td><?php __($counter->tousphone($assign[0]['User']['Notary']['cell_phone'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Day Phone'); ?></th>
					<td><?php __($counter->tousphone($assign[0]['User']['Notary']['day_phone'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Evening phone'); ?></th>
					<td><?php __($counter->tousphone($assign[0]['User']['Notary']['evening_phone'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Fax'); ?></th>
					<td><?php __($counter->tousphone($assign[0]['User']['Notary']['fax'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Commision'); ?></th>
					<td><?php echo  $assign[0]['User']['Notary']['commission']; ?></td>
				</tr>
				<tr>
					<th><?php __('Expiration'); ?></th>
					<td><?php echo $counter->formatdate('nsdate',$assign[0]['User']['Notary']['expiration']); ?></td>
				</tr>
				<tr>
					<th><?php __('Document Delivery Address'); ?></th>
					<td><?php echo $assign[0]['User']['Notary']['dd_address'].", ".$assign[0]['User']['Notary']['dd_city'].", ".$assign[0]['User']['Notary']['dd_state'].", ".$assign[0]['User']['Notary']['dd_zip']; ?></td>
				</tr>
			</table>
		</div>
		</div>
<?php 
	}
} 
?>
		<div id="sdetdiv" style="display:block;">
			<div class="titler1">
				<div class="title1actions fleft">
					<div><h3 class="fleft">Signing Location</h3></div>
				</div>
			<div class="title1actions fleft">
				<div id="creqdiv" ><h3 class="fleft"><?php __($html->link('Client Requirements', '#crdiv',array('onclick'=>"loadBlocks('crdiv','creqdiv');checkdivs2();")));?></h3></div>
			</div>
			<div class="title1actions fleft">
				<div id="prordet" ><h3 class="fleft"><?php __($html->link('Property Details', '#pdetdiv',array('onclick'=>"loadBlocks('pdetdiv','prordet');checkdivs2();")));?></h3></div>
			</div>
			<div class="title1actions fleft">
				<div id="rsidiv" ><h3 class="fleft"><?php __($html->link('Return Shipping Info', '#rsdiv',array('onclick'=>"loadBlocks('rsdiv','rsidiv');checkdivs2();")));?>
				</h3></div>
			</div>
			<div id="slocdiv" style="display:none;"  class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">Address of Signing</span></div>
	
		</div>
		<div class="fieldblock">
			<p>
<?php 
				if($usersession['User']['type'] == 'C' && $order['Order']['orderstatus_id']<>'6' && $order['Order']['orderstatus_id']<>'9' && $order['Order']['orderstatus_id']<>'10') { ?>
					<div style="color:#1F3F66;">
						<?php __($html->link('<div class="maedit"><p>'.$html->image('btn_edit.png', array('alt'=>'Click to Edit Info Below','title'=>'Click to Edit Info Below')).'Click to Edit Info Below</p></div>', array('controller'=>'orders','action'=>'edit','borrower'=>Inflector::slug(low($order['Order']['first_name'].' '.$order['Order']['last_name'])),'id'=>$order['Order']['id']), array('escape'=>false)));?>
					</div>
<?php
				}
?>
			</p>
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('File Number'); ?></th>
					<td><?php echo $order['Order']['file']; ?></td>
				</tr>
				<tr>
					<th><?php __('Date of Signing'); ?></th>
					<td><?php echo $counter->formatdate('nsdate', $order['Order']['date_signing']); ?></td>
				</tr>
				<tr>
					<th><?php __('Address'); ?></th>
					<td><?php echo $order['Order']['sa_street_address']; ?>, <?php echo $order['Order']['sa_city']; ?>, <?php echo $order['Order']['sa_state']; ?>, <?php echo $order['Order']['sa_zipcode']; ?></td>
				</tr>
<?php
				if(!empty($assign) && $usersession['User']['type'] == 'N') {
					$naddress = preg_replace('/[\r\n]+/', "", $assign[0]['User']['Notary']['dd_address']);
					$saddress = preg_replace('/[\r\n]+/', "", $order['Order']['sa_street_address']);
?>
				<tr>
					<th></th>
					<td><a onclick="mapup('<?=str_replace('#', '%23',$naddress)?>,<?=str_replace('#', '%23',$assign[0]['User']['Notary']['dd_city'])?>,<?=str_replace('#', '%23',$assign[0]['User']['Notary']['dd_state'])?>,<?=$assign[0]['User']['Notary']['dd_zip']?>','<?=str_replace('#', '%23',$saddress)?>,<?=str_replace('#', '%23',$order['Order']['sa_city'])?>,<?=str_replace('#', '%23',$order['Order']['sa_state'])?>,<?=$order['Order']['sa_zipcode']?>');" ><img src="<?=Configure::read('IMAGE_PATH')?>directn.png" title="Google Map from Notary’s Document Delivery Address to Borrower’s Signing Address" /></a></td>
				</tr>
<?php
				}
?>
			</table>
		</div></div>
		<div id="crdiv" style="display:none;">
		<div class="titler">
			<div class="title1actions fleft"><h3 class="fleft"><?php __($html->link('Client Requirements', '#creqdiv',array('onclick'=>"hideBlocks('creqdiv','crdiv');checkdivs2();")));?></h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">IMPORTANT! Info to Properly Conduct Signing.</span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Client Requirements'); ?></th>
					<td  colspan="3">
<?php
						if(!empty($creqs)){
							foreach ($creqs as $key=>$creq):
								__(($key + 1).'. '.$creq['ClientRequirements']['requirements'].'<br />');
							endforeach;
						}
?>
					</td>
				</tr>
			</table>
		</div>
		</div>
		<div id="pdetdiv" style="display:none;">
		<div class="titler">
			<div class="title1actions fleft"><h3 class="fleft"><?php __($html->link('Property Address', '#prordet',array('onclick'=>"hideBlocks('prordet','pdetdiv');checkdivs2();")));?></h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">Address for Property of Loan Document.</span></div>
		</div>
		<div class="fieldblock">
			<p>
<?php
					if($usersession['User']['type'] == 'C' && $order['Order']['orderstatus_id'] <> '6' && $order['Order']['orderstatus_id'] <> '9' && $order['Order']['orderstatus_id'] <> '10') {	?>
					<div style="color:#1F3F66;">
						<?php __($html->link('<div class="maedit"><p>'.$html->image('btn_edit.png', array('alt'=>'Click to Edit Info Below','title'=>'Click to Edit Info Below')).'Click to Edit Info Below</p></div>', array('controller'=>'orders','action'=>'edit','borrower'=>Inflector::slug(low($order['Order']['first_name'].' '.$order['Order']['last_name'])),'id'=>$order['Order']['id']), array('escape'=>false)));?>
					</div>
<?php
					}
?>
			</p>
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Address'); ?></th>
					<td><?php __($order['Order']['pa_street_address']); ?>, <?php __($order['Order']['pa_city']); ?>, <?php __($order['Order']['pa_state']); ?>, <?php __($order['Order']['pa_zipcode']); ?></td>
				</tr>
			</table>
		</div>
		</div>
		<div id="rsdiv" style="display:none;">
			<div class="titler">
			<div class="title1actions fleft"><h3 class="fleft"><?php __($html->link('Return Shipping Info', '#rsidiv',array('onclick'=>"hideBlocks('rsidiv','rsdiv');checkdivs2();")));?></h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">Completed Docs Will Be Sent to the Address Below.</span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>   	    	 
					<th width="40%"><?php __('Name'); ?></th>
					<td><?php __($clientdetails['Client']['first_name'].' '.$clientdetails['Client']['last_name']); ?></td>
				</tr>
				<tr>
					<th><?php __('Company / Division'); ?></th>
					<td><?php __($clientdetails['Client']['company'].' / '.$clientdetails['Client']['division']); ?></td>
				</tr>
				<tr>
				<th><?php __('Shipping Carrier'); ?></th>
					<td colspan="3"><?php __($doc_scroptions[$clientdetails['Client']['shipping_carrier']]); ?></td>
				</tr>
				<tr>
				<th><?php __('Shipping Account #'); ?></th>
					<td colspan="3"><?php __($clientdetails['Client']['shipping_account']); ?></td>
				</tr>
				<tr>   	    	 
					<th><?php __('Shipping Address'); ?></th>
					<td colspan="3"><?php __($clientdetails['Client']['of_street_address']); ?>, <?php __($clientdetails['Client']['of_city']); ?>, <?php __($clientdetails['Client']['of_state']); ?>, <?php __($clientdetails['Client']['of_zip']); ?></td>
				</tr>
			</table>
		</div>
			</div>
<?php	if($usersession['User']['type'] == 'N') { ?>
		<div class="titler">
			<div class="title"><h3 class="fleft">Fee Notes</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;"></span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Fee'); ?></th>
					<td colspan="3"><?php __(Configure::read('currency').$order['Order']['fee_total']); ?></td>
				</tr>
				<tr>   	    	 
					<th><?php __('Notes'); ?></th>
					<td colspan="3"><?php __(nl2br($order['Assignment']['details'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Date'); ?></th>
					<td colspan="3"><?php __($counter->formatdate('nsdatetimemeridiem',$order['Assignment']['created'])); ?></td>
				</tr>
			</table>
		</div>
<?php } ?>	
<?php	if($usersession['User']['type'] == 'C') { ?>
		<div class="titler">
			<div class="title"><h3 class="fleft">Fee Notes</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;"></span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Fee'); ?></th>
					<td colspan="3"><?php __(Configure::read('currency').$order['Order']['cfee_total']); ?></td>
				</tr>
				<tr>   	    	 
					<th><?php __('Fee Notes'); ?></th>
					<td colspan="3"><?php __(nl2br($order['Order']['cfee_notes'])); ?></td>
				</tr>
				
			</table>
		</div>
<?php } ?>	
	<?php	//No need to show client his details
	if($usersession['User']['type'] == 'N') { ?>
		<div class="titler">
			<div class="title"><h3 class="fleft">Client Details</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;"></span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Company'); ?></th>
					<td><?php __($clientdetails['Client']['company']); ?></td>	
				</tr>
				<tr>
					<th><?php __('Name'); ?></th>
					<td><?php __($clientdetails['Client']['first_name']." ".$clientdetails['Client']['last_name']); ?></td>
				</tr>
<?php if($usersession['User']['type'] == 'C') { ?>
				<tr>
					<th><?php __('E-mail Address'); ?></th>
					<td><?php __($clientdetails['Client']['email']); ?></td>
				</tr>
				<tr>
					<th><?php __('Work Phone'); ?></th>
					<td><?php __($counter->tousphone($clientdetails['Client']['company_phone'])); ?></td>
				</tr>
<?php }?>
			
			</table>
		</div>
<?php } ?>
	</div>
	<div class="back"><?php __($html->link('Back to Current Signings', array('controller'=>'orders','action'=>'index','type'=>($usersession['User']['type']=='N' ? 'notaries':'clients')))); ?></div>
</div>
<?php
	} else {
?>
<div class="orders index">	
	<div class="block">
		<div class="titler">
			<div class="title"><h3 class="fleft">Signing Status</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">Current Status of Signing. Update Below.</span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Current Status'); ?></th>
					<td><?php __($order['Orderstatus']['status']); ?></td>
				</tr>
			</table>
		</div>
		<div class="titler">
			<div class="title"><h3 class="fleft">Signing Requirements</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">IMPORTANT! Info to Properly Conduct Signing.</span>
			<?php if($usersession['User']['type'] == 'C' && $order['Order']['orderstatus_id']<>'6' && $order['Order']['orderstatus_id']<>'9' && $order['Order']['orderstatus_id']<>'10') { ?>
				<div style="color:#1F3F66;">
					<?php __($html->link('<div class="maedit"><p>'.$html->image('btn_edit.png', array('alt'=>'Click to Edit Info Below','title'=>'Click to Edit Info Below')).'Click to Edit Info Below</p></div>', array('controller'=>'orders','action'=>'edit','borrower'=>Inflector::slug(low($order['Order']['first_name'].' '.$order['Order']['last_name'])),'id'=>$order['Order']['id']), array('escape'=>false)));?>
				</div>
			<?php } ?>
			</div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Specific Signing Instructions'); ?></th>
					<td colspan="3"><?php echo nl2br($order['Order']['signing_instrn']); ?></td>
				</tr>
				<tr>
					<th><?php __('Additional Notes'); ?></th>
					<td colspan="3"><?php echo nl2br($order['Order']['addtnl_notes']); ?></td>
				</tr>
				<?php if($usersession['User']['type'] == 'C') { ?>
				<tr>
					<th><?php __('Additional Notification E-mails'); ?></th>
					<td colspan="3"><?php echo nl2br($order['Order']['addtnl_emails']); ?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
		<div class="titler">
			<div class="title"><h3 class="fleft">Client Requirements</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">IMPORTANT! Info to Properly Conduct Signing.</span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Client Requirements'); ?></th>
					<td  colspan="3">
<?php
					if(!empty($creqs)){
						foreach ($creqs as $key=>$creq):
							__(($key + 1).'. '.$creq['ClientRequirements']['requirements'].'<br />');
						endforeach;
					}
?>
					</td>
				</tr>
			</table>
		</div>
		<div id="cstatdiv" style="display:block;">
		<div class="titler">
			<div class="title1actions fleft"><h3 class="fleft"><?php __($html->link('Change Status', '#upddiv'));?></h3></div>
			<div class="titleactions"><span style="float:left;padding-left:5px;">Update Progress of Signing Below.</span></div>
		</div>
		<div class="fieldblock"><iframe frameborder="0" src="<?php __(Configure::read('WEB_URL')); ?>signings/changestatus/<?php echo $order['Order']['id'];?>-<?php echo $order['Order']['first_name'].' '.$order['Order']['last_name'];?>" width="100%" height="625px;" ></iframe></div>
		</div>
		<div id="shisdiv" style="display:block;">
			<div class="titler1">
				<div class="title1actions fleft">
					<div><h3 class="fleft">Signing History</h3></div>
				</div>
				<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">Chronological Record of all Status Updates.</span></div>
			</div>
		<div class="fieldblock">
		<div class="signinghistories index">
			<div class="block" style="background:white;">
		<?php
if($signinghistories) {	
?>
	<table cellpadding="0" cellspacing="0" class="tablelist">			
		<thead>
			<th width="1%">No</th>
			<th width="5%">Appointment</th>
			<th width="64%">Notes</th>
			<th width="14%">Sender</th>
			<th width="16%">Created</th>
		</thead>
<?php
$j = 0;
foreach ($signinghistories as $signinghistory):
	$class = null;
	if ($j++ % 2 == 0) {$class = ' class="altrow"';}
?>

	<tr <?php __($class);?>>
		<td><?php __($counter->counters($j)); ?></td>
		<td><?php if($signinghistory['Orderstatus']['status']=="SCHEDULED" || $signinghistory['Orderstatus']['status']=="SIGNING COMPLETED"){ __($signinghistory['Signinghistory']['appointment_time']);}else{ echo " "; }  ?>&nbsp;</td>
		<td><?php __($signinghistory['Orderstatus']['status'].': '.nl2br($signinghistory['Signinghistory']['notes'])); ?>
<?php
			if($signinghistory['Signinghistory']['orderstatus_id']>='7'){ 
				echo "<br />[ Tracking #: ".$misc->gettracking($signinghistory['Signinghistory']['order_id'], true)." ]";
			}
?>		
		</td>
		<td><?php echo $misc->getsender($signinghistory['Signinghistory']['added_by'],$signinghistory['Signinghistory']['user_id']); ?></td>
		<td><?php __($counter->formatdate('nsdatetimemeridiem',$signinghistory['Signinghistory']['created'])); ?></td>
	</tr>
<?php 
endforeach;
?>		
	</table>
<?php
} else {
	__($this->element('nobox', array('displaytext'=>'No status updates found')));		
}
?>
		</div>
		</div>
		</div>
		</div>
		<div class="titler">
			<div class="title"><h3 class="fleft">Borrower’s Information</h3></div>
			<div class="titleactions"><span style="float:left;padding-left:5px;">Borrower’s Contact Info.</span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
				<th width="40%"><?php __('Borrower'); ?></th>
				<td colspan="3"><?php __($order['Order']['first_name'].' '.$order['Order']['last_name']); ?></td>	
			</tr>
			<tr>
				<th><?php __('E-mail Address'); ?></th>
				<td colspan="3"><?php echo $order['Order']['email']; ?></td>
			</tr>
			<tr>
				<th><?php __('Home Phone'); ?></th>
				<td><?php __($counter->tousphone($order['Order']['home_phone'])); ?></td>
			</tr>
			<tr>
				<th><?php __('Cell Phone'); ?></th>
				<td><?php __($counter->tousphone($order['Order']['cell_phone'])); ?></td>
			</tr>
			<tr>
				<th><?php __('Work Phone'); ?></th>
				<td><?php __($counter->tousphone($order['Order']['work_phone'])); ?></td>	
			</tr>
			<tr>
				<th><?php __('Alternative Phone'); ?></th>
				<td><?php __($counter->tousphone($order['Order']['alternative_phone'])); ?></td>
			</tr>
			</table>
		</div>
		
		<div class="titler">
			<div class="title"><h3 class="fleft">Signing Location</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">Address of Signing.</span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('File Number'); ?></th>
					<td><?php echo $order['Order']['file']; ?></td>
				</tr>
				<tr>
					<th><?php __('Date of Signing'); ?></th>
					<td><?php echo $counter->formatdate('nsdate',$order['Order']['date_signing']); ?></td>
				</tr>
				<tr>
					<th><?php __('Signing Address'); ?></th>
					<td><?php echo $order['Order']['sa_street_address']; ?>, <?php echo $order['Order']['sa_city']; ?>, <?php echo $order['Order']['sa_state']; ?>, <?php echo $order['Order']['sa_zipcode']; ?></td>
				</tr>
<?php	
			if(!empty($assign) && $usersession['User']['type'] == 'N'){
				$naddress= preg_replace('/[\r\n]+/', "", $assign[0]['User']['Notary']['dd_address']);
				$saddress=preg_replace('/[\r\n]+/', "",$order['Order']['sa_street_address']); 
?>
				<tr>
					<th></th>
					<td><a onclick="mapup('<?=str_replace('#', '%23',$naddress);?>,<?=str_replace('#', '%23',$assign[0]['User']['Notary']['dd_city'])?>,<?=str_replace('#', '%23',$assign[0]['User']['Notary']['dd_state'])?>,<?=$assign[0]['User']['Notary']['dd_zip']?>','<?=str_replace('#', '%23',$saddress)?>,<?=str_replace('#', '%23',$order['Order']['sa_city'])?>,<?=str_replace('#', '%23',$order['Order']['sa_state'])?>,<?=$order['Order']['sa_zipcode']?>');" ><img src="<?=Configure::read('IMAGE_PATH')?>directn.png" title="Google Map from Notary’s Document Delivery Address to Borrower’s Signing Address" /></a></td>
				</tr>
<?php
			}
?>
			</table>
		</div>
		
		<div class="titler">
			<div class="title"><h3 class="fleft">Property Address</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">Address of Property for Loan Docs.</span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
				<th width="40%"><?php __('Property Address'); ?></th>
				<td><?php __($order['Order']['pa_street_address']); ?>, <?php __($order['Order']['pa_city']); ?>, <?php __($order['Order']['pa_state']); ?>, <?php __($order['Order']['pa_zipcode']); ?></td>
			</tr>
			</table>
		</div>
		
		<div class="titler">
			<div class="title"><h3 class="fleft">Document Delivery Information to Notary</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">The Type of Docs and Docs will be Sent to You.</span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('New Request / Re-sign'); ?></th>
					<td colspan="3"><?php __($docinfooptions[$order['Order']['doc_info']]); ?></td>
				</tr>
				<tr>
					<th><?php __('Type of Loan Docs'); ?></th>
					<td><?php __($doc_typesoptions[$order['Order']['doc_type']]);  ?></td>
				</tr>
				<tr>
					<th><?php __('Delivery of Docs'); ?></th>
					<td><?php __($doctypeoptions[$order['Order']['doc_submit']]);  ?></td>
				</tr>
<?php 
	if($order['Order']['doc_submit']=='E'){
		if(!empty($orderedocs)){
			foreach ($orderedocs as $key=>$orderedoc):
?>
			<tr>
				<th><?php __('E-Document '.++$key); ?></th>
				<td><?php __($html->link('Download '.$orderedoc['OrderEdocs']['edocfile'], array('controller'=>'orders', 'action'=>'download','id'=>$this->params['id'],'borrower'=>$this->params['borrower'],'filename'=>$orderedoc['OrderEdocs']['edocfile']))); ?> [ <?php echo @$pdftypeoptions[$orderedoc['OrderEdocs']['ptype']]; ?> ]</td>
			</tr>
<?php 
			endforeach;
		}
	} else if($order['Order']['doc_submit']=='P') { 
?>
			<tr>
				<th><?php __('Pick Up Address'); ?></th>
				<td colspan="3"><?php __($order['Order']['pickup_address']); ?>, <?php __($order['Order']['pickup_city']);?>, <?php __($order['Order']['pickup_state']);?>, <?php __($order['Order']['pickup_zip']);?></td>
			</tr>
<?php 
	} else {
		if($order['Order']['shipping_info']){
	
?>
			<tr>
				<th><?php __('Shipping info'); ?></th>
				<td><?php __($shipoptions[$order['Order']['shipping_info']]); ?></td>
			</tr>
<?php

		}
	} 
	if($tracking and $order['Order']['doc_submit'] == 'O') { 
?>
			<tr>
				<th><?php __('Tracking #'); ?></th>
				<td><?php __($tracking)?></td>
			</tr>
<?php
	}
	if($trackingno && $order['Order']['orderstatus_id']>='7') {
?>
			<tr>
				<th><?php __('Tracking # (after Signing Completed)'); ?></th>
				<td colspan="3"><?php __($trackingno)?></td>
			</tr>
<?php
	}
?>
			</table>
		</div>
			<div class="titler">
			<div class="title"><h3 class="fleft">Return Shipping Info</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;">Please Return Completed Docs to the Address Below.</span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>   	    	 
					<th width="40%"><?php __('Name'); ?></th>
					<td><?php __($clientdetails['Client']['first_name'].' '.$clientdetails['Client']['last_name']); ?></td>
				</tr>
				<tr>
					<th><?php __('Company / Division'); ?></th>
					<td><?php __($clientdetails['Client']['company'].' / '.$clientdetails['Client']['division']); ?></td>
				</tr>
				<tr>
				<th><?php __('Shipping Carrier'); ?></th>
					<td colspan="3"><?php __($doc_scroptions[$clientdetails['Client']['shipping_carrier']]); ?></td>
				</tr>
				<tr>
				<th><?php __('Shipping Account #'); ?></th>
					<td colspan="3"><?php __($clientdetails['Client']['shipping_account']); ?></td>
				</tr>
				<tr>   	    	 
					<th><?php __('Shipping Address'); ?></th>
					<td colspan="3"><?php __($clientdetails['Client']['of_street_address']); ?>, <?php __($clientdetails['Client']['of_city']); ?>, <?php __($clientdetails['Client']['of_state']); ?>, <?php __($clientdetails['Client']['of_zip']); ?></td>
				</tr>
			</table>
		</div>
<?php	if($usersession['User']['type'] == 'N') { ?>
		<div class="titler">
			<div class="title"><h3 class="fleft">Fee Notes</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;"></span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Fee'); ?></th>
					<td colspan="3"><?php  __(Configure::read('currency').$order['Order']['fee_total']); ?></td>
				</tr>
				<tr>   	    	 
					<th><?php __('Notes'); ?></th>
					<td colspan="3"><?php __(nl2br($order['Assignment']['details'])); ?></td>
				</tr>
				<tr>
					<th><?php __('Date'); ?></th>
					<td colspan="3"><?php __($counter->formatdate('nsdatetimemeridiem',$order['Assignment']['created'])); ?></td>
				</tr>
			</table>
		</div>
<?php } ?>	
<?php	if($usersession['User']['type'] == 'C') { ?>
		<div class="titler">
			<div class="title"><h3 class="fleft">Fee Notes</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;"></span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Fee'); ?></th>
					<td colspan="3"><?php __(Configure::read('currency').$order['Order']['cfee_total']); ?></td>
				</tr>
				<tr>   	    	 
					<th><?php __('Fee Notes'); ?></th>
					<td colspan="3"><?php __(nl2br($order['Order']['cfee_notes'])); ?></td>
				</tr>
				
			</table>
		</div>
<?php } ?>	
	<?php	//No need to show client his details
	if($usersession['User']['type'] == 'N') { ?>
		<div class="titler">
			<div class="title"><h3 class="fleft">Client Details</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;"></span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Company'); ?></th>
					<td><?php __($clientdetails['Client']['company']); ?></td>	
				</tr>
				<tr>
					<th><?php __('Name'); ?></th>
					<td><?php __($clientdetails['Client']['first_name']." ".$clientdetails['Client']['last_name']); ?></td>
				</tr>
				<?php if($usersession['User']['type'] == 'C') { ?>
				<tr>
					<th><?php __('E-mail Address'); ?></th>
					<td><?php __($clientdetails['Client']['email']); ?></td>
				</tr>
				<tr>
					<th><?php __('Contact'); ?></th>
					<td><?php __($clientdetails['Client']['company_phone']); ?></td>
				</tr>
				<?php }?>
			</table>
		</div>
<?php }
 //No need to show notary his details
if($usersession['User']['type'] == 'C') { 
if(!empty($assign)){ ?>
		<div class="titler">
			<div class="title"><h3 class="fleft">Notary details</h3></div>
			<div class="titleactions"><span style="float: left; padding-left: 5px;font-size:13px;"></span></div>
		</div>
		<div class="fieldblock">
			<table cellpadding="0" cellspacing="0" class="tableview">
				<tr>
					<th width="40%"><?php __('Name'); ?></th>
					<td><?php __($assign[0]['User']['Notary']['first_name']." ".$assign[0]['User']['Notary']['last_name']); ?></td>
				</tr>
				<tr>
					<th><?php __('E-mail Address'); ?></th>
					<td><?php __($assign[0]['User']['Notary']['email']); ?></td>
				</tr>
				<tr>
					<th><?php __('Contact'); ?></th>
					<td><?php __($assign[0]['User']['Notary']['cell_phone']); ?></td>
				</tr>
				<tr>
					<th><?php __('Document Delivery Address'); ?></th>
					<td><?php __($assign[0]['User']['Notary']['dd_address']); ?></td>
				</tr>
			</table>
		</div>
<?php }
} ?>
	</div>
	<div class="back"><?php __($html->link('Back to Current Signings', array('controller'=>'orders','action'=>'index','type'=>($usersession['User']['type']=='N' ? 'notaries':'clients')))); ?></div>
</div>
<?php }?>
<script>
function checkdivs1(){
if(($('#sreqdiv').css('display') != 'none') && ($('#ddinfodiv').css('display') != 'none') && ($('#ntrydiv').css('display') != 'none')) {
	  $('#bidiv').show();
}else{
	$('#bidiv').hide();
}
}
function checkdivs2(){
if(($('#crdiv').css('display') != 'none') && ($('#pdetdiv').css('display') != 'none') && ($('#rsdiv').css('display') != 'none')) {
	  $('#slocdiv').show();
}else{
	$('#slocdiv').hide();
}
}
function mapup(zip1,zip2){window.open("<?php echo Configure::read('WEB_URL')?>map.php?zip1="+zip1+"&zip2="+zip2,"mywindow","location=0,status=0,scrollbars=0,width=800,height=500");}
</script>
