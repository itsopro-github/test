<?php
class InvoicesController extends AppController {

	var $name = 'Invoices';
	var $components = array('Upload');
	var $uses = array( 'Invoice','Order','Signinghistory');

	function index() {
		$userdata = $this->_checkPermission();
		// check only in completed orders by the client
		$this->paginate = array('recursive'=>0,'contain'=>array('Order','User'),'fields'=>array('Order.id','Order.orderstatus_id','Order.user_id','Order.file','Order.first_name','Order.last_name','Invoice.id','Invoice.created','Invoice.status','Invoice.order_id','Invoice.totalfees','Invoice.invoicedoc'),'conditions'=>array('Order.orderstatus_id'=>'8','Order.user_id'=>$userdata['User']['id']),'order'=>array('Invoice.created DESC'));
		$this->set('invoices', $this->paginate());
		$this->set('paidoptions', $this->_paidoptions());
		$this->loadModel('Contentpage');
		$contents = $this->Contentpage->find('first', array('callbacks'=>false,'fields'=>array('Contentpage.pagetitle','Contentpage.metakey','Contentpage.metadesc','Contentpage.content'),'conditions'=>array('Contentpage.status'=>'1','Contentpage.id'=>33)));
		$this->set('contentpage', $contents);
	}
		
	function admin_index() {
		if(!empty($this->params['named']['s'])) {
			if(isset($_SESSION['search'])) unset($_SESSION['search']);
			$this->redirect(array('action'=>'index'));
			exit();
		}
		if(isset($_SESSION['search']['condition']) and !empty($_SESSION['search']['condition'])) {
			$condition[] = array(implode(' AND ', @$_SESSION['search']['condition']));
		}
		$condition[] = array('Order.orderstatus_id'=>'8');
		$this->paginate = (array('order'=>array('Invoice.created DESC'),'conditions'=>@$condition,'order'=>'Invoice.created DESC','fields'=>array('Order.id','Order.id','Order.user_id','Order.file','Order.first_name','Order.last_name','Invoice.id','Invoice.created','Invoice.status','Invoice.order_id','Invoice.totalfees','Invoice.status')));
		$this->set('invoices', $this->paginate());
		$this->set('paidoptions', $this->_paidoptions());
	}
	
	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid invoice selected','error',array('display'=>'error'));
			$this->redirect(array('action' => 'index'));
			exit();
		}
		
		$invoicedetails = $this->Invoice->find('first',array('fields'=>array('Invoice.id','Invoice.order_id','Invoice.modified','Invoice.invoicedoc','Invoice.status','Invoice.comments','Invoice.created','Invoice.paiddate','Invoice.totalfees','Order.id', 'Order.orderstatus_id', 'Order.first_name', 'Order.last_name','Order.file','Order.user_id'),'conditions'=>array('Invoice.id'=>$id)));
		
		if (!$invoicedetails) {
			$this->Session->setFlash('Invalid invoice selected','error',array('display'=>'error'));
			$this->redirect(array('action' => 'index'));
			exit();
		}
		$this->set('invoice', $invoicedetails);
		$this->set('paidoptions', $this->_paidoptions());

	}
	
	function admin_add() {
		$id = $this->params['named']['id'];
		if(empty($this->data)) {
			//check if already raised the invoice 
			$invoiceexists = $this->Invoice->find('first', array('fields'=>array('Invoice.id'), 'conditions' => array('Invoice.order_id'=>$id)));
			if($invoiceexists['Invoice']['id']!=""){
				$this->Session->setFlash('Already raised the invoice for this order','error',array('display'=>'warning'));
		     	$this->redirect(array('controller'=>'invoices','action' => 'index'));
		     	exit();
			}
			
			$ordercompleted = $this->Order->find('first', array('recursive'=>-1,'conditions'=>array('Order.orderstatus_id'=>7,'Order.id'=>$id)));
			//check Order signing is complete
			 if(empty($ordercompleted)){
				$this->Session->setFlash('Signing status is invalid. Cannot raise invoice','error',array('display'=>'error'));
		     	$this->redirect(array('controller'=>'orders','action' => 'index'));
		     	exit();
			}
			
			$this->set('track_shipno',$ordercompleted['Order']['track_shipping_info']);
			$this->set('track_no',$ordercompleted['Order']['tracking_no']);
		}

		if (!empty($this->data)) {
		    if($this->data['Invoice']['oid']==""){
				$this->Session->setFlash('Invalid order. Cannot raise invoice', 'error',array('display'=>'error'));
				$this->redirect(array('controller'=>'orders','action' => 'index'));
				exit();
			}
	
			$this->set('track_shipno',$this->data['Invoice']['track_shipno']);
			$this->set('track_no',$this->data['Invoice']['track_no']);
			$this->Invoice->create();
			$this->data['Invoice']['order_id'] = $this->data['Invoice']['oid'];
			$this->data['Invoice']['invoicedoc'] = $this->data['Invoice']['invoicedoc'];
			
			if($this->data['Invoice']['paiddate']<>""){
				$date = explode("-",$this->data['Invoice']['paiddate']);
				$this->data['Invoice']['paiddate'] = $date[2]."-".$date[0]."-".$date[1];
			}
			
			$doc_destination = realpath('').'/'.Configure::read('INVOICE_FILE_PATH') ; 
			
			if(isset($this->data['Invoice']['invoicedoc']) != "") {
				$allowed = array('pdf');	
				$result = $this->Upload->upload($this->data['Invoice']['invoicedoc'],$doc_destination,null,null,$allowed);
				$this->data['Invoice']['invoicedoc'] = $this->Upload->result;
			} else {
				$this->data['Invoice']['invoicedoc'] = $invoiceexists['Invoice']['invoicedoc'];
			}
			
			if ($this->Invoice->save($this->data)) {
				$ordercompleted = $this->Order->find('first', array('recursive'=>-1,'conditions'=>array('Order.orderstatus_id'=>7,'Order.id'=>$id)));
				$userdata = $this->Miscellaneous->getClientEmail($this->data['Invoice']['order_id']);
				if(isset($this->data['Invoice']['track_no']) and ($this->data['Invoice']['track_no']<>"")) {
					if($this->data['Invoice']['track_shipno']=='F'){
						$tracking=	'<a href="'.Configure::read('fedextracking').$this->data['Invoice']['track_no'].'" target="_blank">'.$this->data['Invoice']['track_no'] .'</a>';
					} elseif($this->data['Invoice']['track_shipno']=='U') {
						$tracking =	'<a href="'.Configure::read('upstracking').$this->data['Invoice']['track_no'].'"  target="_blank">'. $this->data['Invoice']['track_no'] .'</a>';
					} elseif($this->data['Invoice']['track_shipno']=='D'){
						$tracking =	'<a href="'.Configure::read('dhltracking').'"  target="_blank">'. $this->data['Invoice']['track_no'] .'</a>';
					} elseif($this->data['Invoice']['track_shipno']=='G'){
						$tracking =	'<a href="'.Configure::read('gsotracking').'"  target="_blank">'. $this->data['Invoice']['track_no'] .'</a>';
					} elseif($this->data['Invoice']['track_shipno']=='E'){
						$tracking=	'<a href="'.Configure::read('overniteexpress').'"  target="_blank">'. $this->data['Invoice']['track_no'] .'</a>';
					} else {
						$tracking=	$this->data['Invoice']['track_no'];
					} 
					$orderresult['autotrack'] = $tracking;
				} else{
					$orderresult['autotrack'] = " ";
				}
				/* Send the confirmation mail*/
				if(!empty($this->data['Invoice']['invoicedoc'])) {
					/* Send the confirmation mail*/
					$orderresult['mailorderstatus'] = '8';
					$orderresult['salutation'] = $userdata['first_name'];
					$orderresult['notes'] = $this->data['Invoice']['comments'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$userdata['email'], 'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - INVOICE: '.$ordercompleted['Order']['first_name'].' '.$ordercompleted['Order']['last_name'].' in '.$ordercompleted['Order']['sa_city'].', '.$ordercompleted['Order']['sa_state'].' '.$ordercompleted['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'filePaths'=>realpath('').'/'.Configure::read('INVOICE_FILE_PATH'), 'attachments'=>$this->data['Invoice']['invoicedoc'], 'sendas'=>'html'));
				}
				/* update the history */
				if(!empty($this->data['Invoice']['paiddate']) and !empty($this->data['Invoice']['invoicedoc'])) {
					$this->__updatehistory($id);
				}
				
				/* Redirect to index page */
				$this->Session->setFlash('The invoice has been saved', 'error',array('display'=>'success'));
				$this->redirect(array('action'=>'index'));
				exit();
			} else {
				$this->Session->setFlash('The invoice could not be saved. Please, try again.', 'error',array('display'=>'error'));
				$this->set('error_messages', $this->Invoice->validationErrors);
			}
		}
		$this->set('paidoptions', $this->_paidoptions());
		$this->set('invoid', $id);
	}
		
	function admin_edit($id = null) {
		if($id == ""  && isset($this->params['named']['id']) <> ""){
			$id = $this->params['named']['id'];
		} 
		$invoicedetails = $this->Invoice->find('first',array('fields'=>array('Invoice.id','Invoice.order_id','Invoice.modified','Invoice.invoicedoc','Invoice.status','Invoice.comments','Invoice.created','Invoice.paiddate','Invoice.totalfees','Order.id', 'Order.orderstatus_id', 'Order.first_name', 'Order.last_name','Order.file','Order.user_id'),'conditions'=>array('Invoice.id'=>$id)));
		$this->set('invoice',$invoicedetails);
		if(empty($this->data)) {
			$ordercompleted = $this->Order->find('first', array('recursive'=>-1,'conditions'=>array('Order.orderstatus_id'=>8,'Order.id'=>$invoicedetails['Order']['id'])));
			$this->set('track_shipno',$ordercompleted['Order']['track_shipping_info']);
			$this->set('track_no',$ordercompleted['Order']['tracking_no']);
		}
		if (!empty($this->data)) {
	 		if($this->data['Invoice']['oid']==""){
				$this->Session->setFlash('Invalid order. Cannot raise invoice.', 'error',array('display'=>'error'));
				$this->redirect(array('controller'=>'orders','action' => 'index'));
				exit();
			}
			$this->set('track_shipno', $this->data['Invoice']['track_shipno']);
			$this->set('track_no', $this->data['Invoice']['track_no']);
			$this->data['Invoice']['id'] = $this->data['Invoice']['oid'];
			$this->data['Invoice']['order_id'] = $this->data['Invoice']['odrid'];
		
			if($this->data['Invoice']['paiddate']<>""){
				$date = explode("-",$this->data['Invoice']['paiddate']);
				$this->data['Invoice']['paiddate'] = $date[2]."-".$date[0]."-".$date[1];
			}
			
			$doc_destination = realpath('').'/'.Configure::read('INVOICE_FILE_PATH'); 
			
			if(!empty($this->data['Invoice']['invoicedoc']['name'])) {
				$allowed = array('pdf');
				$result = $this->Upload->upload($this->data['Invoice']['invoicedoc'], $doc_destination, null, null, $allowed);
				$this->data['Invoice']['invoicedoc'] = $this->Upload->result;
			} else {
				$noinvoicethistime = true;
				$this->data['Invoice']['invoicedoc'] = $invoicedetails['Invoice']['invoicedoc'];
			}
			if ($this->Invoice->save($this->data)) {
				$ordercompleted = $this->Order->find('first', array('recursive'=>-1,'conditions'=>array('Order.orderstatus_id'=>8, 'Order.id'=>$invoicedetails['Order']['id'])));
				$userdata = $this->Miscellaneous->getClientEmail($this->data['Invoice']['order_id']);
				if(isset($this->data['Invoice']['track_no']) and ($this->data['Invoice']['track_no']<>"")) {
					if($this->data['Invoice']['track_shipno']=='F'){
						$tracking=	'<a href="'.Configure::read('fedextracking').$this->data['Invoice']['track_no'].'" target="_blank">'.$this->data['Invoice']['track_no'] .'</a>';
					} elseif($this->data['Invoice']['track_shipno']=='U') {
						$tracking =	'<a href="'.Configure::read('upstracking').$this->data['Invoice']['track_no'].'" target="_blank">'. $this->data['Invoice']['track_no'] .'</a>';
					} elseif($this->data['Invoice']['track_shipno']=='D') {
						$tracking =	'<a href="'.Configure::read('dhltracking').'" target="_blank">'. $this->data['Invoice']['track_no'] .'</a>';
					} elseif($this->data['Invoice']['track_shipno']=='G') {
						$tracking =	'<a href="'.Configure::read('gsotracking').'" target="_blank">'. $this->data['Invoice']['track_no'] .'</a>';
					} elseif($this->data['Invoice']['track_shipno']=='E') {
						$tracking =	'<a href="'.Configure::read('overniteexpress').'" target="_blank">'. $this->data['Invoice']['track_no'] .'</a>';
					} else {
						$tracking =	$this->data['Invoice']['track_no'];
					}
					$orderresult['autotrack'] = $tracking;
				} else {
					$orderresult['autotrack'] = " ";
				}
				if(!empty($this->data['Invoice']['invoicedoc']) and !$noinvoicethistime) {
					/* Send the confirmation mail*/
					$orderresult['mailorderstatus'] = '8';
					$orderresult['salutation'] = $userdata['first_name'];
					$orderresult['notes'] = $this->data['Invoice']['comments'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$userdata['email'], 'bcc'=>'', 'subject'=>Configure::read('sitename').' - INVOICE: '.$ordercompleted['Order']['first_name'].' '.$ordercompleted['Order']['last_name'].' in '.$ordercompleted['Order']['sa_city'].', '.$ordercompleted['Order']['sa_state'].' '.$ordercompleted['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'filePaths'=>realpath('').'/'.Configure::read('INVOICE_FILE_PATH'), 'attachments'=>$this->data['Invoice']['invoicedoc'], 'sendas'=>'html'));
				}
				/* update the history */
				if(!empty($this->data['Invoice']['paiddate']) and $this->data['Invoice']['status'] == 1) {
					$this->__updatehistory($invoicedetails['Order']['id']);
				}
				/* Redirect to index page */
				$this->Session->setFlash('The invoice has been saved', 'error',array('display'=>'success'));
				$this->redirect(array('action'=>'index'));
				exit();
			} else {
				$this->Session->setFlash('The invoice could not be saved. Please, try again.', 'error',array('display'=>'error'));
				$this->set('error_messages', $this->Invoice->validationErrors);
			}
		}
		$this->set('paidoptions', $this->_paidoptions());
		$this->set('invoid', $invoicedetails['Invoice']['id']);
		$this->set('invodrid',$invoicedetails['Order']['id']);
	}
	
	function admin_search() {
		/* Unset the session for new criteria */ 
		if(isset($_SESSION['search'])) unset($_SESSION['search']);
		$search_condition = array();
		$search_params = array();		
		if(!empty($this->data)) {
			if(isset($this->data['Order']['first_name']) and trim($this->data['Order']['first_name'])!='') {
				$search_condition[] = "Order.first_name LIKE '%" . $this->data['Order']['first_name'] . "%' ";
				$search_params['first_name'] = $this->data['Order']['first_name'];
			}
			
			if(isset($this->data['month']) and ($this->data['month']<>"")){
				$search_condition[]  =" MONTH(Invoice.created) = '" . $this->data['month'] . "' ";
				$search_params['month'] = $this->data['month'];
			}
			
			if(isset($this->data['year']) and ($this->data['year']<>"")){
			 	$search_condition[]  =" YEAR(Invoice.created) = '" . $this->data['year'] . "'";
			 	$search_params['year'] = $this->data['year'];
			}
			
			if(isset($this->data['Invoice']['status']) and trim($this->data['Invoice']['status']) != '') {
				$search_condition[] = " Invoice.status ='" . $this->data['Invoice']['status'] ."'";
				$search_params['status'] = $this->data['Invoice']['status'];
			}	
		
		}
		$_SESSION['search']['condition'] = $search_condition;
		$_SESSION['search']['params'] = $search_params;		
		
 		$this->redirect(array(action=>'index'));
 		exit();
	}
	
	function admin_clear() {
		/* Unset the session for new criteria */
		$this->__clearsearch();
	}
	
	function __updatehistory($orderid) {
		if($orderid) {
			$admin_data = $this->Session->read('WBSWAdmin');
			$this->loadModel('Signinghistory');
			$this->Signinghistory->create();
			$this->data['Signinghistory']['order_id'] = $orderid;
			$this->data['Signinghistory']['user_id'] = $admin_data['Admin']['id'];
			$this->data['Signinghistory']['orderstatus_id'] = '9';
			$this->data['Signinghistory']['status'] = '1';
			$this->data['Signinghistory']['added_by'] = 'A';
			
			unset($this->Signinghistory->validate['notes']);
			unset($this->Signinghistory->validate['appointment_time']);
			$this->Signinghistory->save($this->data);
			
			/* Update the status to CLOSED */
			$this->loadModel('Order');
			$data = array('Order'=>array('id' => $orderid, 'orderstatus_id' => '9', 'statusdate'=>date('Y-m-d H:i:s')));
		    $this->Order->save($data, false, array('orderstatus_id', 'statusdate'));
		}		
	}
	
	/*	Downloads invoice */
	function download($doc=null) {
		$this->layout = null;
		$userdata = $this->_checkPermission();
		if(!empty($doc)) {
			$this->_downloadfile(getcwd().'/'.Configure::read('INVOICE_FILE_PATH').$doc);
			exit;
		} else {
			$model_for_myaccount = ($usersession['Client']['id'] == '') ? 'notaries' : 'clients';
			$this->Session->setFlash(Configure::read('sitename').' is working to get this INVOICE to you. We will send the INVOICE via email and notify you when it is available online.','error',array('display'=>'info'));
			$this->redirect(array('controller'=>'invoices','action'=>'index','type'=>$model_for_myaccount));
			exit();
		}
	}
	
	/*	Export to csv*/
	function admin_export(){
	 	if(!empty($this->data['Invoice']['chkb'])){
	 		$invIds = implode(",",$this->data['Invoice']['chkb']); 
	       	$invoiceIds ="(".$invIds.")";
	       	$conditions = array("Invoice.id IN $invoiceIds");
		  	$invoices = $this->Invoice->find('all', array('fields'=>array('Invoice.id','Invoice.created','Invoice.status','Invoice.totalfees','Invoice.order_id','Invoice.invoicedoc','Invoice.comments','Invoice.paiddate','Order.id','Order.user_id','Order.orderstatus_id','Order.first_name','Order.last_name','Order.file'),'conditions' => $conditions));
	 		$this->exportintocsv($invoices);
	 	} else {
	 		$this->Session->setFlash('Please select the invoices to be exported','error',array('display'=>'warning'));
 			$this->redirect(array('controller'=>'invoices','action' =>'index'));
			exit();
	 	}
	 }
	 

}
?>
