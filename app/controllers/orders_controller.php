<?php
class OrdersController extends AppController {
	var $name = 'Orders';
	
	var $components = array('Upload', 'RequestHandler','Twilio', 'Miscellaneous');

	var $uses = array('Order', 'Notary', 'Client', 'TestMsg', 'Assignment', 'Orderdetail', 'OrderEdocs', 'Invoice', 'Orderstatus', 'Signinghistory', 'ClientRequirements', 'NotaryFees', 'ClientFees', 'HistoryOwners', 'Admin', 'reactivateFees');
	
	function index() {
		$userdata = $this->_checkPermission();			
		if($userdata['User']['type']=='C') {
			//If the loggedin user is a notary
			$this->Order->Behaviors->attach('Containable');
			$condition[] = array('Order.tracking_no'=>'','Order.user_id'=>$userdata['User']['id']);			
			if(isset($_SESSION['search']['condition']) and !empty($_SESSION['search']['condition'])) {
				$condition[] = array(implode(' AND ', @$_SESSION['search']['condition']));
			}
						
			$totalcount = $this->Order->find('count', array('conditions' => @$condition));		
   $this->paginate =array('conditions'=>@$condition,'limit'=>$totalcount,'recursive'=>0,'order'=>'Order.created DESC','fields'=>array('distinct(Order.id)','Order.first_name','Order.last_name','Order.file','Order.sa_city','Order.sa_state','Order.orderstatus_id','Orderstatus.status','Order.work_phone','Order.cell_phone','Order.created','Order.sa_zipcode','Order.modified','Order.user_id','Order.addedby','Order.attended_by','Clients.company','Clients.user_id','User.id','Order.tracking_no','Order.tracking','Order.track_shipping_info'));
   $this->set('orders', $this->paginate());
			$allnotaries = $this->Notary->find('superlist', array('fields'=>array('Notary.user_id','Notary.first_name','Notary.last_name'),'separator'=>' '));
			$this->set('notaries', $allnotaries);
			$allowed=array('1','2','3','4','5','7');			
	
	        $orderstatuses = $this->Orderstatus->find('list',array('fields'=>array('id','status'),'conditions'=>array('Orderstatus.id' => $allowed)));
	        $this->set(compact('orderstatuses'));
			
		} elseif($userdata['User']['type']=='N') {
			//If the loggedin user is a notary
			$this->Assignment->Behaviors->attach('Containable');
			$condition[] =array('Assignment.user_id'=>$userdata['User']['id'],'Assignment.status'=>'A');
			if(isset($_SESSION['search']['condition']) and !empty($_SESSION['search']['condition'])) {
			$condition[] = array(implode(' AND ', @$_SESSION['search']['condition']));
			}
			$allowed=array('2','3','4','5','7');			
	
	        $orderstatuses = $this->Orderstatus->find('list',array('fields'=>array('id','status'),'conditions'=>array('Orderstatus.id' => $allowed)));
			$this->set(compact('orderstatuses'));
			
			$totalcount = $this->Assignment->find('count', array('conditions' =>@$condition));
			
			$allassignments = $this->Assignment->find('all',array('contain'=>array('Order'),'limit'=>$totalcount,'fields'=>array('Assignment.details','Assignment.created','Order.id','Order.user_id','Order.orderstatus_id','Order.first_name','Order.last_name','Order.file','Order.sa_state','Order.sa_city','Order.sa_zipcode','Order.tracking','Order.tracking_no','Order.track_shipping_info','Order.created','Order.modified'),'conditions'=>@$condition));
			$this->set('orders', $allassignments);
		}
		
		$this->set('notList',$this->Notary->find('list',array('recursive'=>1,'fields' => array('Notary.user_id', 'Notary.first_name'),'order'=>'Notary.first_name','conditions'=>array('User.status'=>'1'))));
		
		$this->loadModel('Contentpage');
		$contents = $this->Contentpage->find('first', array('callbacks'=>false,'fields'=>array('Contentpage.pagetitle','Contentpage.metakey','Contentpage.metadesc','Contentpage.content'),'conditions'=>array('Contentpage.status'=>'1','Contentpage.id'=>32)));
		$this->set('contentpage', $contents);
		
		$this->set('title_for_layout', 'Current Signings');
		$this->set('states', $this->_stateoptions());
	}

	function view() {
		$userdata = $this->_checkPermission();
		$this->_checkView();
		$id = $this->params['id']; //order id
		if(!$id) {
			$this->Session->setFlash('Invalid order.','error',array('display'=>'warning'));
			$this->redirect(array('action'=>'index'));
			exit;
		} else {
			$cond = array('Order.id'=>$id);
			//if($userdata['User']['type'] == 'C') {
				//$cond = array('Order.id'=>$id, 'Order.user_id'=>$userdata['User']['id']);
				//$creq = $this->ClientRequirements->find('all', array('conditions'=>array('ClientRequirements.user_id'=>$userdata['User']['id'])));
				//$this->set('creqs', $creq);
			//}
			$this->Order->Behaviors->attach('Containable');
			$orderdetails = $this->Order->find('first', array('contain'=>array('Orderstatus','Assignment'=>array('fields'=>array('Assignment.user_id','Assignment.details','Assignment.created'))),'fields'=>array('Order.id','Order.user_id','Order.orderstatus_id','Order.first_name','Order.last_name','Order.home_phone', 'Order.work_phone', 'Order.cell_phone', 'Order.alternative_phone', 'Order.email', 'Order.date_signing', 'Order.file', 'Order.signing_instrn', 'Order.addtnl_notes', 'Order.addtnl_emails', 'Order.sa_street_address', 'Order.sa_state', 'Order.sa_city', 'Order.sa_zipcode', 'Order.pa_street_address', 'Order.pa_state', 'Order.pa_city', 'Order.pa_zipcode', 'Order.doc_info', 'Order.doc_submit', 'Order.doc_type', 'Order.pickup_address', 'Order.pickup_state', 'Order.pickup_city', 'Order.pickup_zip', 'Order.shipping_info', 'Order.tracking', 'Order.tracking_no','Order.track_shipping_info','Order.fee_total', 'Order.agree', 'Order.created','Orderstatus.status', 'Order.cfee_total','Order.cfee_notes'),'conditions'=>$cond));
			/* check hacking attempt, check permission for client and notary login */
			if (!$orderdetails or ($userdata['User']['type'] == 'N' and @$orderdetails['Assignment']['user_id'] != $userdata['User']['id'])) {
				$this->Session->setFlash('Invalid order selected.', 'error', array('display'=>'warning'));
				$this->redirect(array('action'=>'index','type'=>'notaries'));
				exit;
			}
			$this->set('order', $orderdetails);
			if($userdata['User']['type']=='N' and $orderdetails['Order']['agree']=='0') {
				$this->redirect(array('controller'=>'orders', 'action'=>'terms', 'id'=>$this->params['id']));
				exit;
			}
		
			$client = $this->Client->find('first',array('fields'=>array('Client.id','Client.user_id','Client.email','Client.company_phone','Client.of_street_address','Client.shipping_carrier','Client.first_name','Client.last_name','Client.company','Client.division','Client.shipping_account','Client.of_city','Client.of_state','Client.of_zip'),'conditions'=>array('Client.user_id'=>$orderdetails['Order']['user_id'])));
			$this->set('clientdetails', $client);
			
			$creq = $this->ClientRequirements->find('all', array('conditions'=>array('ClientRequirements.user_id'=>$client['Client']['user_id'])));
			$this->set('creqs', $creq);

			$this->Assignment->Behaviors->attach('Containable');
			$assigned_users = $this->Assignment->find('all', array('contain'=>array('User'=>array('Notary'=>array('fields'=>array('Notary.id','Notary.user_id','Notary.email','Notary.cell_phone','Notary.fees','Notary.first_name','Notary.last_name','Notary.dd_address','Notary.dd_city','Notary.dd_state','Notary.dd_zip','Notary.fax','Notary.evening_phone','Notary.day_phone','Notary.expiration','Notary.commission')))),'conditions'=>array('Assignment.order_id'=>$id,'Assignment.status'=>'A') ));
			$oedoc = $this->OrderEdocs->find('all', array('conditions'=>array('OrderEdocs.order_id'=>$id), 'order' => array('OrderEdocs.id asc') ));
			$this->set('orderedocs', $oedoc);
			if($assigned_users){
				foreach($assigned_users as $av) {
					$inarr[] = $av['User']['id'];
				}
			} else {
				$inarr = array();	
			}
				$this->set('assign', $assigned_users);	
		}
		
		$totalcountsh = $this->Signinghistory->find('count', array('conditions' =>array('Signinghistory.order_id'=>$id,'Signinghistory.status'=>'1')));
			
		$allsh = $this->Signinghistory->find('all',array('contain'=>array('Order'),'limit'=>$totalcountsh,'fields'=>array('Client.first_name','Notary.first_name','Client.last_name','Notary.last_name','Orderstatus.status','Signinghistory.order_id', 'Signinghistory.user_id','Signinghistory.orderstatus_id','Signinghistory.notes','Signinghistory.appointment_time','Signinghistory.added_by','Signinghistory.created','Signinghistory.order_id','Signinghistory.id'),'conditions'=>array('Signinghistory.order_id'=>$id,'Signinghistory.status'=>'1'),'order'=>'Signinghistory.created DESC'));
			
		$this->set('signinghistories', $allsh);
		
		$this->set('docinfooptions', $this->_docinfooptions());
		$this->set('doctypeoptions', $this->_doctypeoptions());
		$this->set('pdftypeoptions', $this->_pdftypeoptions());
		$this->set('ynoptions', $this->_ynoptns());
		$this->set('nyoptions', $this->_nyoptns());
		$this->set('shipoptions', $this->_shipoptions());
		$this->set('title_for_layout', $orderdetails['Orderstatus']['status']." : ".$orderdetails['Order']['first_name'].' '.$orderdetails['Order']['last_name']);
		$this->set('doc_typesoptions', $this->_doctypesoptionsslt());
		$this->set('doc_scroptions', $this->_shippingcarrier());
	}
			
	/***********************************************************
	*	Placing an order from logged in client
	************************************************************/
	function addorder() {
		$userdata = $this->_checkPermission();
		if (!empty($this->data)) {

			if(!$this->IsValid())
			{
				$this->Session->setFlash('Human verification failed.','error',array('display'=>'error'));
				$this->redirect(array('action'=>'addorder'));
				exit;
			}
			
			if(!empty($this->data['Order']['document'])){
				$fname = $this->_uploadFile($this->data['Order']['document']);
				$this->data['Order']['document'] = $fname;
			} else {
				unset($this->data['Order']['document']);
			}
			
			$this->data['Order']['user_id'] = $userdata['User']['id'];
		    $this->data['Order']['orderstatus_id'] = '1';
		    $this->data['Order']['addedby'] = '0';
		    $this->data['Order']['home_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['home_phone1'],$this->data['Order']['home_phone2'],$this->data['Order']['home_phone3']));
			$this->data['Order']['work_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['work_phone1'],$this->data['Order']['work_phone2'],$this->data['Order']['work_phone3']));
			$this->data['Order']['cell_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['cell_phone1'],$this->data['Order']['cell_phone2'],$this->data['Order']['cell_phone3']));
			$this->data['Order']['alternative_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['alternative_phone1'],$this->data['Order']['alternative_phone2'],$this->data['Order']['alternative_phone3']));
	 		$this->data['Order']['statusdate'] = date('Y-m-d H:i:s');
	 		if(isset($this->data['Order']['date_signing']) <> ""){
	 			$datefornotification = $this->data['Order']['date_signing'];
				$date = explode("-", $this->data['Order']['date_signing']);
				$this->data['Order']['date_signing'] = $date[2]."-".$date[0]."-".$date[1];
			}
			if ($this->Order->save($this->data)) {	
				$orderid = $this->Order->id;
				/* Uploading the doc */
				$total = count($this->data['OrderEdocs']['edocfile']);
			    for($i=0;$i<$total;$i++) {
					$this->OrderEdocs->create();
				 	$orderedoc['OrderEdocs']['order_id'] = $orderid;
					$orderedoc['OrderEdocs']['ptype'] = $this->data['OrderEdocs']['ptype'][$i];
					$orderedoc['OrderEdocs']['edocfile'] = $this->data['OrderEdocs']['edocfile'][$i];
					
					$doc_destination = realpath('').'/'.Configure::read('EDOC_FILE_PATH') ; 
					if(isset($orderedoc['OrderEdocs']['edocfile']) && $orderedoc['OrderEdocs']['edocfile']!= "") {
						$allowed = array('doc','docx','pdf');
						$result = $this->Upload->upload($orderedoc['OrderEdocs']['edocfile'],$doc_destination,null,null,$allowed);						
						$orderedoc['OrderEdocs']['edocfile'] = $this->Upload->result;
					} else {
						$orderedoc['OrderEdocs']['edocfile'] = '';
					}
					if($orderedoc['OrderEdocs']['edocfile']<>""){
						$this->OrderEdocs->save($orderedoc);
					}
				}
			    
				$this->Signinghistory->create();
				// since client adds order
				$this->data['Signinghistory']['added_by']='C';
				$this->data['Signinghistory']['user_id'] = $userdata['User']['id'];
				$this->data['Signinghistory']['notes'] = " ";
				$this->data['Signinghistory']['orderstatus_id'] = 1;
				$this->data['Signinghistory']['order_id'] = $orderid;
				unset($this->Signinghistory->validate['notes']);
				unset($this->Signinghistory->validate['appointment_time']);	
				$this->Signinghistory->save($this->data);
			    
				$this->Notary->Behaviors->attach('Containable');
				$notarieslist = $this->Notary->find('all', array('contain'=>array('User'),'fields'=>array('Notary.id','Notary.user_id','Notary.email','Notary.notify','Notary.fees','Notary.first_name','Notary.last_name'),'conditions'=>array('OR'=>array('Notary.expiration >= '=>date('Y-m-d'),'Notary.expiration'=>'0000-00-00'),'OR'=>array('Notary.enddate >= '=>date('Y-m-d'),'Notary.enddate'=>'0000-00-00'),'Notary.mistakes <'=>'3','User.status'=>'1','Notary.zipcode LIKE'=>"%".$this->data['Order']['sa_zipcode']."%",'Notary.notify != '=>'T'),'order'=>'Notary.userstatus DESC'));
				$this->set('notaries', $notarieslist);
				/* Send the confirmation mail to NOATRIES */
				if(!empty($notarieslist['0']['Notary']['email'])){
					foreach ($notarieslist as $key => $value ){
						$orderresult['mailorderstatus'] = '10';
						$orderresult['zipcode'] = $this->data['Order']['sa_zipcode'];
						$orderresult['signing_date'] = $this->data['Order']['date_signing'];
						$orderresult['salutation'] = $value['Notary']['first_name'];
						$orderresult['reference'] = $orderid;
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$value['Notary']['email'], 'cc'=>'','bcc'=>'', 'subject'=>Configure::read('sitename').' - New signing available in '.$this->data['Order']['sa_city'].', '.$this->data['Order']['sa_state'], 'replyto' => Configure::read('replyemail'), 'from' => Configure::read('fromemail'), 'layout' => 'email', 'template' => 'orderstatus', 'sendas' => 'html'));
					}
				}
				/* Insert the order details */
				$orderdetails = array('Orderdetail'=>array('order_id'=>$orderid,'user_id'=>$userdata['User']['id'],'details'=>'Order placed to Administrator'));	
				$this->Orderdetail->save($orderdetails);
				/* Send the confirmation mail to CLIENT */
				$orderresult['mailorderstatus'] = '1';
				$orderresult['salutation'] = $userdata['Client']['first_name'];
				$orderresult['Order'] = $this->data['Order'];
				$this->set('orderdata', $orderresult);
				$this->_sendNewMail(array('to'=>$userdata['Client']['email'], 'cc'=>'','bcc'=>'', 'subject'=>Configure::read('sitename').' - New order: '.$this->data['Order']['first_name']." ".$this->data['Order']['last_name'].' in '.$this->data['Order']['sa_city'].', '.$this->data['Order']['sa_state'].' '.$this->data['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'sendas'=>'html'));
				
				/* Send the confirmation mail to ADDITIONAL EMAILS */
				if($this->data['Order']['addtnl_emails'] != '')
				{
					$orderresult['mailorderstatus'] = '11';
					$orderresult['salutation'] = '';
					$orderresult['Order'] = $this->data['Order'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$this->data['Order']['addtnl_emails'], 'cc'=>'','bcc'=>'', 'subject'=>Configure::read('sitename').' - New order: '.$this->data['Order']['first_name']." ".$this->data['Order']['last_name'].' in '.$this->data['Order']['sa_city'].', '.$this->data['Order']['sa_state'].' '.$this->data['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'sendas'=>'html'));
				}
				
				/* Send the confirmation mail to ADMIN */
				$orderresult['mailorderstatus'] = '11';
				$orderresult['salutation'] = Configure::read('sitename');
				$orderresult['Order'] = $this->data['Order'];
				$this->set('orderdata', $orderresult);
				$this->_sendNewMail(array('to'=>Configure::read('infoemail'), 'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - New order: '.$this->data['Order']['first_name']." ".$this->data['Order']['last_name'].' in '.$this->data['Order']['sa_city'].', '.$this->data['Order']['sa_state'].' '.$this->data['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'sendas'=>'html'));
				
				/* Send Order to Quickbooks */
				$clientData = $this->Client->find('first',array('fields'=>array('Client.company','Client.first_name','Client.last_name','Client.email','Client.of_state','Client.of_city','Client.of_zip','Client.of_street_address', 'Client.fees'),'conditions'=>array('Client.user_id'=>$userdata['User']['id'])));
				$this->send_invoice_to_quickbooks($clientData["Client"], $orderid, $this->data['Order']);
				
				$this->Session->setFlash('Your order has been submitted. '.Configure::read('sitename').' will provide notary details shortly.','error',array('display'=>'success'));
				/* Send the TXT MESSAGE to NOTARIES */
		 		$this->__sendTextMessage(array('orderid'=>$orderid, 'zipcode'=>$this->data['Order']['sa_zipcode'], 'signingdate'=>$datefornotification), 'website');
			} else {
				$this->Session->setFlash('The request could not be placed. Please, try again.','error',array('display'=>'error'));
				$this->set('error_messages', $this->Order->validationErrors);
			}
		}
		$this->loadModel('Contentpage');
		$contents = $this->Contentpage->find('first', array('callbacks'=>false,'fields'=>array('Contentpage.pagetitle','Contentpage.metakey','Contentpage.metadesc','Contentpage.content'),'conditions'=>array('Contentpage.status'=>'1','Contentpage.id'=>31)));
		$this->set('contentpage', $contents);
		$this->set('docinfooptions', $this->_docinfooptions());
		$this->set('doctypeoptions', $this->_doctypeoptions());
		$this->set('pdftypeoptions', $this->_pdftypeoptions());
		$this->set('ynoptions', $this->_ynoptns());
		$this->set('nyoptions', $this->_nyoptns());
		$this->set('shipoptions', $this->_shipoptions());
		$this->set('states', $this->_stateoptions());
		$this->set('cnt_tottrack',1);
		$this->set('title_for_layout', 'Request A Notary');
		$this->set('doc_typesoptions', $this->_doctypesoptionsslt());
	}
	
	/***********************************************************
	*	Confirmation after placing order from logged in client
	************************************************************/
	function confirm() {
		$userdata = $this->_checkPermission();
		$this->set('title_for_layout', 'Notary Request Confirmation');
	}
	
	function edit($id = null) {
		$userdata = $this->_checkPermission();
		if(isset($this->params['id']) && $this->params['id'] <> ""){
			$id = $this->params['id'];
		}
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid order selected.','error',array('display'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('Orderid', $id);
		$cond = array('Order.id'=>$id);
		
		if (!empty($this->data)) {					
			$this->data['Order']['home_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['home_phone1'],$this->data['Order']['home_phone2'],$this->data['Order']['home_phone3']));
			$this->data['Order']['work_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['work_phone1'],$this->data['Order']['work_phone2'],$this->data['Order']['work_phone3']));
			$this->data['Order']['cell_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['cell_phone1'],$this->data['Order']['cell_phone2'],$this->data['Order']['cell_phone3']));
			$this->data['Order']['alternative_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['alternative_phone1'],$this->data['Order']['alternative_phone2'],$this->data['Order']['alternative_phone3']));		
			unset($this->Order->validate['file']);	
			unset($this->Order->validate['date_signing']);	
			unset($this->Order->validate['doc_info']);	
			unset($this->Order->validate['doc_submit']);	
			
			$orderdetails = $this->Order->find('first', array('fields'=>array('Order.id','Order.user_id','Order.orderstatus_id','Order.first_name','Order.last_name','Order.date_signing','Order.file','Orderstatus.status','Order.sa_city','Order.sa_state','Order.sa_zipcode'),'conditions'=>$cond));
								
			if ($this->Order->save($this->data['Order'])) {
				$this->set('mailcdata', $orderdetails);
				
				$this->Assignment->Behaviors->attach('Containable');
				$assigneduser = $this->Assignment->find('first', array('contain'=>array('User'=>array('Notary'=>array('fields'=>array('Notary.email')))),'conditions'=>array('Assignment.order_id'=>$id,'Assignment.status'=>'A')));
				$orderresult['mailorderstatus'] = '200';
				$orderresult['salutation'] = '';
				$this->set('orderdata', $orderresult);
				
				$this->_sendNewMail(array('to'=>$assigneduser['User']['Notary']['email'], 'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - Signing information has been modified', 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'sendas'=>'html'));
				
				$this->Session->setFlash('Order saved successfully.','error',array('display'=>'success'));
				$this->redirect(array('controller'=>'orders','action'=>'edit','borrower'=>Inflector::slug($this->data['Order']['first_name'].' '.$this->data['Order']['last_name']),'id'=>$id));
				exit();
			} else {
				$this->Session->setFlash('The order could not be saved. Please, try again.','error',array('display'=>'error'));
				$this->set('error_messages', $this->Order->validationErrors);
			}		
		}
		if(empty($this->data)){
			if($userdata['User']['type']=='C') {
				$cond = array('Order.id'=>$id, 'Order.user_id'=>$userdata['User']['id']);
			}
			$orderdetails = $this->Order->find('first', array('fields'=>array('Order.id','Order.user_id','Order.orderstatus_id','Order.first_name','Order.last_name', 'Order.date_signing', 'Order.file','Orderstatus.status','Order.sa_city','Order.sa_state','Order.sa_zipcode'),'conditions'=>$cond));
			$this->set('order', $orderdetails);
			$this->data = $this->Order->read(null, $id);
		}			
		$this->set('states', $this->_stateoptions());
		$users = $this->Order->User->find('list');
		$this->set(compact('users'));
		$this->set('title_for_layout','Edit the Signing');
	}
	
	/************************************************
	*	Website Signings Search - Archived Signings
	*************************************************/
	function archived() {
		$userdata = $this->_checkPermission();
		/* Unset the session for new criteria */ 
		if(isset($_SESSION['signings'])) unset($_SESSION['signings']);
		$search_condition = array();
		$search_params = array();		
		if(!empty($this->data)) {
			if(isset($this->data['Order']['first_name']) and trim($this->data['Order']['first_name']) != '') {
				$search_condition[] = " Orders.first_name LIKE '%" . $this->data['Order']['first_name'] . "%' ";
				$search_params['first_name'] = $this->data['Order']['first_name'];
			}	
			if(isset($this->data['Order']['last_name']) and trim($this->data['Order']['last_name']) != '') {
				$search_condition[] = " Orders.last_name LIKE '%" . $this->data['Order']['last_name'] . "%' ";
				$search_params['last_name'] = $this->data['Order']['last_name'];
			}	
			if(isset($this->data['Order']['sa_street_address']) and trim($this->data['Order']['sa_street_address']) != '') {
				$search_condition[] = " Orders.sa_street_address LIKE '%" . $this->data['Order']['sa_street_address'] . "%' ";
				$search_params['sa_street_address'] = $this->data['Order']['sa_street_address'];
			}	
			if(isset($this->data['Order']['sa_city']) and trim($this->data['Order']['sa_city']) != '') {
				$search_condition[] = " Orders.sa_city LIKE '%" . $this->data['Order']['sa_city'] . "%' ";
				$search_params['sa_city'] = $this->data['Order']['sa_city'];
			}	
			if(isset($this->data['Order']['sa_state']) and trim($this->data['Order']['sa_state']) != '') {
				$search_condition[] = " Orders.sa_state LIKE '%" . $this->data['Order']['sa_state'] . "%' ";
				$search_params['sa_state'] = $this->data['Order']['sa_state'];
			}	
			if(isset($this->data['Order']['sa_zipcode']) and trim($this->data['Order']['sa_zipcode']) != '') {
				$search_condition[] = " Orders.sa_zipcode LIKE '%" . $this->data['Order']['sa_zipcode'] . "%' ";
				$search_params['sa_zipcode'] = $this->data['Order']['sa_zipcode'];
			}	
			if(isset($this->data['Order']['pa_street_address']) and trim($this->data['Order']['pa_street_address']) != '') {
				$search_condition[] = " Orders.pa_street_address LIKE '%" . $this->data['Order']['pa_street_address'] . "%' ";
				$search_params['pa_street_address'] = $this->data['Order']['pa_street_address'];
			}	
			if(isset($this->data['Order']['pa_city']) and trim($this->data['Order']['pa_city']) != '') {
				$search_condition[] = " Orders.pa_city LIKE '%" . $this->data['Order']['pa_city'] . "%' ";
				$search_params['pa_city'] = $this->data['Order']['pa_city'];
			}
			if(isset($this->data['Order']['pa_state']) and trim($this->data['Order']['pa_state']) != '') {
				$search_condition[] = " Orders.pa_state LIKE '%" . $this->data['Order']['pa_state'] . "%' ";
				$search_params['pa_state'] = $this->data['Order']['pa_state'];
			}	
			if(isset($this->data['Order']['pa_zipcode']) and trim($this->data['Order']['pa_zipcode']) != '') {
				$search_condition[] = " Orders.pa_zipcode LIKE '%" . $this->data['Order']['pa_zipcode'] . "%' ";
				$search_params['pa_zipcode'] = $this->data['Order']['pa_zipcode'];
			}
			if(isset($this->data['Order']['date_signing']) and trim($this->data['Order']['date_signing']) != '') {
				$search_condition[] = " Orders.date_signing ='" . date("Y-m-d",strtotime($this->data['Order']['date_signing'])). "' ";
				$search_params['date_signing'] = $this->data['Order']['date_signing'];
			}	
			if(isset($this->data['Order']['file']) and trim($this->data['Order']['file']) != '') {
				$search_condition[] = " Orders.file LIKE '%" . $this->data['Order']['file'] . "%' ";
				$search_params['file'] = $this->data['Order']['file'];
			}
			
			if(isset($this->data['Notary']['first_name']) and trim($this->data['Notary']['first_name']) != '') {
				$search_condition[] = " Notary.first_name LIKE '%" . $this->data['Notary']['first_name'] . "%' ";
				$search_params['first_name'] = $this->data['Notary']['first_name'];
			}	
			if(isset($this->data['Notary']['last_name']) and trim($this->data['Notary']['last_name']) != '') {
				$search_condition[] = " Notary.last_name LIKE '%" . $this->data['Notary']['last_name'] . "%' ";
				$search_params['last_name'] = $this->data['Notary']['last_name'];
			}		
		

			// check only in pending,closed,cancelled orders by the client
			$search_condition[] = " Orders.orderstatus_id in (6,9,10)  and Orders.user_id=".$userdata['User']['id']."";
			$_SESSION['signings']['condition'] = $search_condition;
			$_SESSION['signings']['params'] = $search_params;
	
			
			$search_condition = implode(" and ",$search_condition);
			 
			$res  = $this->Order->query("SELECT Orders. * , Notary.first_name, Notary.last_name
			FROM orders AS Orders
			LEFT JOIN assignments ON Orders.id = assignments.order_id
			LEFT JOIN users ON assignments.user_id = users.id
			LEFT JOIN notaries AS Notary ON Notary.user_id = users.id
			WHERE ".$search_condition) ;
			
			foreach ($res as $okey=>$order){
				$res[$okey]['Order'] = $order['Orders'];
			}
			$this->set('searchresults', $res);		
		}
		
		$this->set('title_for_layout', 'Archived Signings');
		$allnotaries = $this->Notary->find('superlist', array('fields'=>array('Notary.user_id','Notary.first_name','Notary.last_name'),'separator'=>' '));
		
		$this->set('notaries', $allnotaries);
		
		$this->loadModel('Contentpage');
		$contents = $this->Contentpage->find('first', array('callbacks'=>false,'fields'=>array('Contentpage.pagetitle','Contentpage.metakey','Contentpage.metadesc','Contentpage.content'),'conditions'=>array('Contentpage.status'=>'1','Contentpage.id'=>34)));
		$this->set('contentpage', $contents);
	}
		
	function admin_index() {
		$type = isset($this->params['status'])=='' ? "" : $this->params['status'];
		if($type == 'archived') {
			$archallowed = array('6','9','10');
			$condition[] = array('Order.orderstatus_id' => $archallowed);
			$orderstatuses = $this->Orderstatus->find('list',array('fields'=>array('id','status'),'conditions'=>array('Orderstatus.id' => $archallowed)));
			$arch_flag = '1';
			$this->set('arch_flag', $arch_flag);
		} else {
			$allowed = array('1','2','3','4','5','7');			
			$condition[] = array('Order.orderstatus_id' => $allowed); //'Order.tracking_no'=>'',
			$orderstatuses = $this->Orderstatus->find('list',array('fields'=>array('id','status'),'conditions'=>array('Orderstatus.id' => $allowed)));
			$arch_flag = '0';
			$this->set('arch_flag', $arch_flag);	
	 	}
		if(!empty($this->params['named']['s'])) {
			if(isset($_SESSION['search'])) unset($_SESSION['search']);
			if(!empty($this->params['top']))
				$this->redirect(array('action'=>'index','top'=>$this->params['top']));
			elseif(!empty($this->params['medium']))
				$this->redirect(array('action'=>'index','medium'=>$this->params['medium']));
			elseif(!empty($this->params['low']))
				$this->redirect(array('action'=>'index','low'=>$this->params['low']));
			else
				$this->redirect(array('action'=>'index'));
		}

		if(isset($_SESSION['search']['condition']) and !empty($_SESSION['search']['condition'])) {
			$condition[] = array(implode(' AND ', @$_SESSION['search']['condition']));
		}

		if(!empty($this->params['top'])) {
			$condition[] = array('Order.orderstatus_id'=>array('1','2','3','4','5','7'), 'TIMESTAMPDIFF(MINUTE,Order.statusdate,now()) <'=>45, 'TIMESTAMPDIFF(MINUTE,Order.statusdate,now()) >'=>30);
		} elseif (!empty($this->params['medium'])) {
		 	$condition[] = array('Order.orderstatus_id'=>array('1','2','3','4','5','7'), 'TIMESTAMPDIFF(MINUTE,Order.statusdate,now()) <'=>30, 'TIMESTAMPDIFF(MINUTE,Order.statusdate,now()) >'=>15);
		} elseif (!empty($this->params['low'])) {
		 	$condition[] = array('Order.orderstatus_id'=>array('1','2','3','4','5','7'), 'TIMESTAMPDIFF(MINUTE,Order.statusdate,now()) <='=>15);
		} 

		// todo refine search
		$totalcount = $this->Order->find('count', array('conditions' => array(@$condition)));
		$this->paginate = array('conditions'=>@$condition, 'recursive'=>0, 'limit'=>$totalcount, 'order'=>'Order.created DESC', 'fields'=>array('distinct(Order.id)','Order.first_name','Order.last_name','Order.file','Order.sa_city','Order.sa_state','Order.orderstatus_id','Orderstatus.status','Order.work_phone','Order.cell_phone','Order.created','Order.sa_zipcode','Order.modified','Order.user_id','Order.addedby','Order.attended_by','Order.tracking_no','Order.track_shipping_info','Clients.company','Clients.user_id','User.id'));
		$this->set('orders', $this->paginate());
		
		$this->set('adminList', $this->Admin->find('list',array('recursive'=>1, 'fields' => array('Admin.id', 'Admin.name'), 'order'=>'Admin.name', 'conditions'=>array('Admin.status'=>'1'))));

		$this->set(compact('orderstatuses'));
		$this->set('states', $this->_stateoptions());
	}

	function admin_view($id = null, $assigned = null) {
	    $this->set('assigned',$assigned);
	 	$admin_type = $this->Session->read('WBSWAdmin.Admin.type');
		if (!$id) {
			$this->Session->setFlash('Invalid order.','error',array('display'=>'warning'));
			$this->redirect(array('action'=>'index'));
			exit;
		}
		$this->Order->Behaviors->attach('Containable');
		$orderdetails = $this->Order->find('first',array('contain'=>array('Orderstatus'),'fields'=>array('Order.id','Order.user_id','Orderstatus.status','Order.first_name','Order.last_name','Order.signing_instrn','Order.addtnl_notes','Order.addtnl_emails','Order.home_phone','Order.work_phone','Order.cell_phone','Order.alternative_phone','Order.email','Order.orderstatus_id','Order.date_signing','Order.file', 'Order.sa_street_address', 'Order.sa_state', 'Order.sa_city', 'Order.sa_zipcode', 'Order.pa_street_address', 'Order.pa_state', 'Order.pa_city', 'Order.pa_zipcode', 'Order.doc_info', 'Order.doc_submit', 'Order.doc_type', 'Order.pickup_address', 'Order.shipping_info', 'Order.tracking', 'Order.created', 'Order.modified', 'Order.fee_total', 'Order.fee_notes','Order.doc_type', 'Order.pickup_city', 'Order.pickup_state','Order.pickup_zip','Order.attended_by','Order.addedby','Order.track_shipping_info','Order.tracking_no','Order.cfee_total','Order.cfee_notes'),'conditions'=>array('Order.id'=>$id)));
		$this->set('order', $orderdetails);
		if($orderdetails['Order']['orderstatus_id']==4) {
			//find the signing history apnt time and set it.
			$takeapttime = $this->Signinghistory->find('first',array('order'=>'Signinghistory.created DESC','fields'=>array('Signinghistory.appointment_time'),'conditions'=>array('Signinghistory.order_id'=>$id, 'Signinghistory.orderstatus_id'=>4)));
			$this->set('crntapttime', $takeapttime['Signinghistory']['appointment_time']);
		}
		$client = $this->Client->find('first', array('contain'=>array('User'=>array('Client'=>array('fields'=>array('Client.id','Client.user_id','Client.fees','Client.email','Client.cell_phone','Client.of_street_address','Client.of_city','Client.of_state','Client.of_zip')))),'conditions'=>array('Client.user_id'=>$orderdetails['Order']['user_id'])));
		$this->set('clientdetails', $client);
		
		$creq = $this->ClientRequirements->find('all', array('conditions'=>array('ClientRequirements.user_id'=>$client['User']['id'])));
		$this->set('creqs', $creq);
		
		$nfee = $this->NotaryFees->find('all', array('conditions'=>array('NotaryFees.order_id'=>$id)));
		$this->set('nfee', $nfee);
		$this->set('notfee', $this->_feetypeoptions());
		
		$cfee = $this->ClientFees->find('all', array('conditions'=>array('ClientFees.order_id'=>$id)));
		$this->set('cfee', $cfee);
		$this->set('notfee', $this->_feetypeoptions());

		$this->Assignment->Behaviors->attach('Containable');
		$assigned_users = $this->Assignment->find('all', array('contain'=>array('User'=>array('Notary'=>array('fields'=>array('Notary.id','Notary.user_id','Notary.email','Notary.cell_phone','Notary.fees','Notary.first_name','Notary.last_name','Notary.dd_address','Notary.dd_city','Notary.dd_state','Notary.dd_zip','Notary.fax','Notary.evening_phone','Notary.day_phone','Notary.expiration','Notary.commission')))),'conditions'=>array('Assignment.order_id'=>$id,'Assignment.status'=>'A')));
		$oedoc = $this->OrderEdocs->find('all', array('conditions'=>array('OrderEdocs.order_id'=>$id)));
		$this->set('orderedocs', $oedoc);
		if($assigned_users){
			foreach($assigned_users as $av) {
				$inarr[] = $av['User']['id'];
			}
		} else {
			$inarr = array();	
		}
        if(!empty($inarr) && $orderdetails['Order']['orderstatus_id']=='1'){
			$this->Notary->Behaviors->attach('Containable');
			$notarieslist = $this->Notary->find('all', array('contain'=>array('User'),'fields'=>array('Notary.id','Notary.user_id','Notary.email','Notary.cell_phone','Notary.fees','Notary.first_name','Notary.last_name'),'conditions'=>array('Notary.zipcode LIKE'=>"%".$orderdetails['Order']['sa_zipcode']."%",'Notary.userstatus'=>'P'),'order'=>'RAND()'));
		
			$this->Notary->Behaviors->attach('Containable');
			$notarieslist1 = $this->Notary->find('all', array('contain'=>array('User'),'fields'=>array('Notary.id','Notary.user_id','Notary.email','Notary.cell_phone','Notary.fees','Notary.first_name','Notary.last_name'),'conditions'=>array('Notary.zipcode LIKE'=>"%".$orderdetails['Order']['sa_zipcode']."%", 'Notary.userstatus'=>'B'),'order'=>'RAND()'));
		
			$notarieslist = array_merge($notarieslist,$notarieslist1);
		
			$this->set('notaries', $notarieslist);
		} else {
			$this->Notary->Behaviors->attach('Containable');
			$notarieslist = $this->Notary->find('all', array('contain'=>array('User'),'fields'=>array('Notary.id','Notary.user_id','Notary.email','Notary.cell_phone','Notary.fees','Notary.first_name','Notary.last_name'),'conditions'=>array('Notary.zipcode LIKE'=>"%".$orderdetails['Order']['sa_zipcode']."%", 'NOT'=>array('User.id'=>$inarr),'Notary.userstatus'=>'P'),'order'=>'RAND()'));
			
			$this->Notary->Behaviors->attach('Containable');
			$notarieslist1 = $this->Notary->find('all', array('contain'=>array('User'),'fields'=>array('Notary.id','Notary.user_id','Notary.email','Notary.cell_phone','Notary.fees','Notary.first_name','Notary.last_name'),'conditions'=>array('Notary.zipcode LIKE'=>"%".$orderdetails['Order']['sa_zipcode']."%", 'NOT'=>array('User.id'=>$inarr),'Notary.userstatus'=>'B'),'order'=>'RAND()'));
			
			$notarieslist = array_merge($notarieslist,$notarieslist1);
			$this->set('notaries', $notarieslist);
		}
		

		$this->set('assign', $assigned_users);
		$histories = $this->Signinghistory->find('all',array('order'=>'Signinghistory.created DESC','fields'=>array('Client.first_name','Notary.first_name','Client.last_name','Notary.last_name','Orderstatus.status','Signinghistory.order_id', 'Signinghistory.user_id', 'Signinghistory.id', 'Signinghistory.created','Signinghistory.orderstatus_id','Signinghistory.notes','Signinghistory.status','Signinghistory.added_by','Signinghistory.appointment_time'),'conditions'=>array('Signinghistory.order_id'=>$id)));
		$this->set('signinghistories', $histories);
		
		$rfees = $this->reactivateFees->find('all', array('conditions' =>'reactivateFees.order_id='.$id, 'order' => array('reactivateFees.created DESC')));	
	    $this->set('reactivateFees',$rfees);
		$this->set('Orderstatus', $this->Orderstatus->find('list',array('recursive'=>0,'fields'=>array('Orderstatus.id','Orderstatus.status'),'conditions'=> array('Orderstatus.id' => array('2','3','4','5','6','7','9','10')))));
		$this->set('order', $orderdetails);

		$ownhistory = $this->HistoryOwners->find('all',array('order'=>array('HistoryOwners.created DESC'),'conditions'=>array('HistoryOwners.order_id'=>$id),'fields'=>array('HistoryOwners.id','HistoryOwners.admin_id','HistoryOwners.created')));
		$this->set('history', $ownhistory);
		
		$this->set('statList',$this->Orderstatus->find('list',array('recursive'=>1,'fields' => array('Orderstatus.id', 'Orderstatus.status'),'order'=>'Orderstatus.status')));
		$this->set('docinfooptions', $this->_docinfooptions());
		$this->set('doctypeoptions', $this->_doctypeoptions());
		
		$this->set('pdftypeoptions', $this->_pdftypeoptions());
		$this->set('ynoptions', $this->_ynoptns());
		$this->set('nyoptions', $this->_nyoptns());
		$this->set('shipoptions', $this->_shipoptions());
		$this->set('statusOptions', $this->_statusOptions());
		$this->set('doc_typesoptions', $this->_doctypesoptionsslt());
		
		
		

		$dataSource = ConnectionManager::getDataSource('default');
		$results = $dataSource->query("SELECT id, client_user_id, client_name, edoc_file_name, edoc_file_type, action , action_time FROM  edocs_audit_trail WHERE order_id = " . intval($id));
		$this->set('eDocs_audit_trail', $results);
	}

	function send_invoice_to_quickbooks($clientData, $orderId, $orderData)
	{
		$txnDate = date('Y-m-d', strtotime($orderData["date_signing"] . ' + 10 days'));
		switch($orderData["doc_type"])
		{
			case "S":
				$serviceType = "29";
				break;
			case "O":
				$serviceType = "30";
				break;
			case "T":
				$serviceType = "37";
				break;
			case "R":
				$serviceType = "36";
				break;
			case "P":
				$serviceType = "28";
				break;
			case "E":
				$serviceType = "38";
				break;
			case "F":
				$serviceType = "34";
				break;
			case "M":
				$serviceType = "39";
				break;
			default:
				$serviceType = "0";
				break;
		}
 
		$url = 'https://hooks.zapier.com/hooks/catch/1734225/t17fd4/';		
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/application/json",
				'method'  => 'POST',
				'content' => '{"CompanyName" :  "' . $clientData["company"] . '" , "FullyQualifiedName" : "' .  $clientData["first_name"] . ' ' .  $clientData["last_name"] . '", "GivenName": "' . $clientData["first_name"] . '", "FamilyName": "' . $clientData["last_name"] . '", "BillEmail": "' . $clientData["email"] . '",  "BillStreetAddr" :  "' .  $clientData["of_street_address"] . '" , "BillAddr" : { "PostalCode" : "' . $clientData["of_zip"] . '",  "City": "' . $clientData["of_city"] . '","Country" : "United States", "CountrySubDivisionCode": "' . $clientData["of_state"] . '"}, "ON" : "' . $orderId  . '", "SD" : "' . $orderData["date_signing"] . '", "TY" : "' . $orderData["doc_type"]  . '", "BL" : "' . $orderData["last_name"]  . '", "FN" : "' . $orderData["file"] . '", "CF" : "' . $clientData["fees"] . '", "NotaryService" : "' . $serviceType . '", "Description" : "Notary coordination and signing fee for ' . $orderData["last_name"]  . ' ' . $orderData["file"] . '","CustomerMemo" : "Checks can be sent and payable to\n    1 Hour Signings\n    133 The Promenade N, Suite 405\n    Long Beach, CA  90802", "TxnDate": "' . $txnDate . '" ,"Quantity" : 1,  "Amount" : "' . $clientData["fees"] . '", "Balance" : "' . $clientData["fees"] . '", "Total" : "' . $clientData["fees"] . '" , "AllowOnlineACHPayment" : true, "CurrencyRef" : { "name" : "United States Dollar", "value" : "USD"  } , "SalesTermRef" : 5, "AllowOnlinePayment" : true   , "AllowIPNPayment": true  }'
			)
		);

		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);		
	}
	
	
	
	function admin_add() {
		$admin_data = $this->Session->read('WBSWAdmin');
		$admin_id = $admin_data['Admin']['id'];

		if (!empty($this->data)) {

			$this->Order->create();
			$this->data['Order']['orderstatus_id'] = '1';
			$this->data['Order']['home_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['home_phone1'],$this->data['Order']['home_phone2'],$this->data['Order']['home_phone3']));
			$this->data['Order']['work_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['work_phone1'],$this->data['Order']['work_phone2'],$this->data['Order']['work_phone3']));
			$this->data['Order']['cell_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['cell_phone1'],$this->data['Order']['cell_phone2'],$this->data['Order']['cell_phone3']));
			$this->data['Order']['alternative_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['alternative_phone1'],$this->data['Order']['alternative_phone2'],$this->data['Order']['alternative_phone3']));
			$this->data['Order']['statusdate'] = date('Y-m-d H:i:s');
			if(isset($this->data['Order']['date_signing']) <> ""){
				$datefornotification = $this->data['Order']['date_signing'];
				$date = explode("-", $this->data['Order']['date_signing']);
				$this->data['Order']['date_signing'] = $date[2]."-".$date[0]."-".$date[1];
			}
			
			$this->data['Order']['addedby'] = $admin_id;

			if($this->Order->save($this->data)) {		
				$orderid = $this->Order->id;
				/* Uploading the doc */
				$total = count($this->data['OrderEdocs']['edocfile']);
				for($i=0;$i<$total;$i++) {
					$this->OrderEdocs->create();
					$orderedoc['OrderEdocs']['order_id'] = $orderid;
					$orderedoc['OrderEdocs']['ptype'] = $this->data['OrderEdocs']['ptype'][$i];
					$orderedoc['OrderEdocs']['edocfile'] = $this->data['OrderEdocs']['edocfile'][$i];
					$doc_destination = realpath('').'/'.Configure::read('EDOC_FILE_PATH') ; 
					if(isset($orderedoc['OrderEdocs']['edocfile']) && $orderedoc['OrderEdocs']['edocfile']!= "") {
						$allowed = array('doc','docx','pdf');
						$result = $this->Upload->upload($orderedoc['OrderEdocs']['edocfile'],$doc_destination,null,null,$allowed);
						$orderedoc['OrderEdocs']['edocfile'] = $this->Upload->result;
					} else {
						$orderedoc['OrderEdocs']['edocfile'] = '';
					}
					if($orderedoc['OrderEdocs']['edocfile'] <> ""){
						$this->OrderEdocs->save($orderedoc);
					}
				}

				$this->Signinghistory->create();
				// since admin adds order
				$this->data['Signinghistory']['added_by'] = 'A';
				$this->data['Signinghistory']['user_id'] = $admin_id;
				$this->data['Signinghistory']['notes'] = " ";
				$this->data['Signinghistory']['orderstatus_id'] = 1;
				$this->data['Signinghistory']['order_id'] = $orderid;
				unset($this->Signinghistory->validate['notes']);
				unset($this->Signinghistory->validate['appointment_time']);		
				
				$this->Signinghistory->save($this->data);
				$this->Notary->Behaviors->attach('Containable');
				$notarieslist = $this->Notary->find('all', array('contain'=>array('User'),'fields'=>array('Notary.id','Notary.user_id','Notary.email','Notary.notify','Notary.fees','Notary.first_name','Notary.last_name'),'conditions'=>array('OR'=>array('Notary.expiration >= '=>date('Y-m-d'),'Notary.expiration'=>'0000-00-00'),'OR'=>array('Notary.enddate >= '=>date('Y-m-d'),'Notary.enddate'=>'0000-00-00'),'Notary.mistakes <'=>'3','User.status'=>'1','Notary.zipcode LIKE'=>"%".$this->data['Order']['sa_zipcode']."%",'Notary.notify != '=>'T'),'order'=>'Notary.userstatus DESC'));
				$this->set('notaries', $notarieslist);
				/* Send the confirmation mail to NOTARIES */
				if(!empty($notarieslist['0']['Notary']['email'])) {
					foreach ($notarieslist as $key => $value ) {
						$orderresult['mailorderstatus'] = '10';
						$orderresult['zipcode'] = $this->data['Order']['sa_zipcode'];
						$orderresult['signing_date'] = $this->data['Order']['date_signing'];
						$orderresult['salutation'] = $value['Notary']['first_name'];
						$orderresult['reference'] = $orderid;
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$value['Notary']['email'], 'cc'=>'','bcc'=>'', 'subject'=>Configure::read('sitename').' - New signing available in '.$this->data['Order']['sa_city'].', '.$this->data['Order']['sa_state'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'sendas'=>'html'));
					}
				}

				$userdata = $this->Client->find('first',array('fields'=>array('Client.id','Client.user_id','Client.first_name','Client.last_name','Client.email','Client.company'),'conditions'=>array('Client.user_id'=>$this->data['Order']['user_id'])));
				/* Insert the order details */
				$orderdetails = array('Orderdetail'=>array('order_id'=>$orderid,'user_id'=>$this->data['Order']['user_id'],'details'=>'Order placed to Administrator'));	
				$this->Orderdetail->save($orderdetails);
				/* Send the confirmation mail to CLIENT*/
				$orderresult['mailorderstatus'] = '1';
				$orderresult['salutation'] = $userdata['Client']['first_name'];
				$orderresult['Order'] = $this->data['Order'];
				$this->set('orderdata', $orderresult);
				$this->_sendNewMail(array('to'=>$userdata['Client']['email'], 'cc'=>'','bcc'=>'', 'subject'=>Configure::read('sitename').' - New order: '.$this->data['Order']['first_name']." ".$this->data['Order']['last_name'].' in '.$this->data['Order']['sa_city'].', '.$this->data['Order']['sa_state'].' '.$this->data['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
				
				/* Send the confirmation mail to ADDITIONAL EMAILS */
				if($this->data['Order']['addtnl_emails'] != '')
				{
					$orderresult['mailorderstatus'] = '11';
					$orderresult['salutation'] = '';
					$orderresult['Order'] = $this->data['Order'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$this->data['Order']['addtnl_emails'], 'cc'=>'','bcc'=>'', 'subject'=>Configure::read('sitename').' - New order: '.$this->data['Order']['first_name']." ".$this->data['Order']['last_name'].' in '.$this->data['Order']['sa_city'].', '.$this->data['Order']['sa_state'].' '.$this->data['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'sendas'=>'html'));
				}
				
				/* Send the confirmation mail to ADMIN*/
				$orderresult['mailorderstatus'] = '11';
				$orderresult['salutation'] = Configure::read('sitename');
				$orderresult['Order'] = $this->data['Order'];
				$this->set('orderdata', $orderresult);
				$this->_sendNewMail(array('to'=>Configure::read('infoemail'), 'cc'=>'','bcc'=>'', 'subject'=>Configure::read('sitename').' - New order: '.$this->data['Order']['first_name']." ".$this->data['Order']['last_name'].' in '.$this->data['Order']['sa_city'].', '.$this->data['Order']['sa_state'].' '.$this->data['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'sendas'=>'html'));
				
				/* Send the TXT Message to NOTARY */
		 		$this->__sendTextMessage(array('orderid'=>$orderid, 'zipcode'=>$this->data['Order']['sa_zipcode'], 'signingdate'=>$datefornotification));

				/* Send Order to Quickbooks */
				$clientData = $this->Client->find('first',array('fields'=>array('Client.company','Client.first_name','Client.last_name','Client.email','Client.of_state','Client.of_city','Client.of_zip','Client.of_street_address', 'Client.fees'),'conditions'=>array('Client.user_id'=>$this->data['Order']['user_id'])));
				$this->send_invoice_to_quickbooks($clientData["Client"], $orderid, $this->data['Order']);
							
		 		$this->redirect(array('action'=>'index'));
				
				exit;
			} else { 
				$this->set('error_messages', $this->Order->validationErrors);
				//$this->Session->setFlash('The request could not be placed. Please, try again.','error',array('display'=>'error'));
			}
		}
		$users = $this->Order->User->find('list');
		$this->set(compact('users'));
				
		$this->set('clientList',$this->Client->find('list',array('recursive'=>1,'fields' => array('Client.user_id', 'Client.fullname', 'Client.company'),'order'=>'Client.first_name','conditions'=>array('User.status'=>'1'))));
		
		$this->set('docinfooptions', $this->_docinfooptions());
		$this->set('doctypeoptions', $this->_doctypeoptions());
		$this->set('pdftypeoptions', $this->_pdftypeoptions());
		$this->set('ynoptions', $this->_ynoptns());
		$this->set('nyoptions', $this->_nyoptns());
		$this->set('states', $this->_stateoptions());
		$this->set('shipoptions', $this->_shipoptions());
		$this->set('cnt_tottrack',1);
		$this->set('doc_typesoptions', $this->_doctypesoptionsslt());
	}
	
	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid order.','error',array('display'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			
			if($this->data['Order']['date_signing']<>""){
				$date = explode("-",$this->data['Order']['date_signing']);
				$this->data['Order']['date_signing'] = $date[2]."-".$date[0]."-".$date[1];
			}
			$this->data['Order']['home_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['home_phone1'],$this->data['Order']['home_phone2'],$this->data['Order']['home_phone3']));
			$this->data['Order']['work_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['work_phone1'],$this->data['Order']['work_phone2'],$this->data['Order']['work_phone3']));
			$this->data['Order']['cell_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['cell_phone1'],$this->data['Order']['cell_phone2'],$this->data['Order']['cell_phone3']));
			$this->data['Order']['alternative_phone'] = $this->Miscellaneous->formatphone(array($this->data['Order']['alternative_phone1'],$this->data['Order']['alternative_phone2'],$this->data['Order']['alternative_phone3']));
			
			$order_data = $this->Order->find('first',array('conditions'=>array('Order.id'=>$id), 'recursive'=>-1));
			//upon ownership update, insert prev owner into history
			if(($this->data['Order']['attended_by']<>"") and ($order_data['Order']['attended_by']<>$this->data['Order']['attended_by'])){
				$this->HistoryOwners->create();
				$howners['HistoryOwners']['admin_id'] = $this->data['Order']['attended_by'];
				$howners['HistoryOwners']['order_id'] = $id;
				$this->HistoryOwners->save($howners);
			}

			if ($this->Order->save($this->data)) {
				$orderid = $this->Order->id;
				/* Uploading the doc */
				$total = count($this->data['OrderEdocs']['edocfile']);
				for($i=0;$i<$total;$i++) {
					$this->OrderEdocs->create();
					$orderedoc['OrderEdocs']['order_id'] = $orderid;
					$orderedoc['OrderEdocs']['ptype'] = $this->data['OrderEdocs']['ptype'][$i];
					$orderedoc['OrderEdocs']['edocfile'] = $this->data['OrderEdocs']['edocfile'][$i];
					$doc_destination = realpath('').'/'.Configure::read('EDOC_FILE_PATH') ; 
					if(isset($orderedoc['OrderEdocs']['edocfile']) && $orderedoc['OrderEdocs']['edocfile']!= "") {
						$allowed = array('doc','docx','txt','pdf');
						$result = $this->Upload->upload($orderedoc['OrderEdocs']['edocfile'],$doc_destination,null,null,$allowed);
						$orderedoc['OrderEdocs']['edocfile'] = $this->Upload->result;
					} else {
						$orderedoc['OrderEdocs']['edocfile'] = '';
					}
					if($orderedoc['OrderEdocs']['edocfile']<>""){
						$this->OrderEdocs->save($orderedoc);
						$this->__addAuditTrailAdmin($this->OrderEdocs->id, "A");
					}
				}
				$this->Session->setFlash('Order has been successfully saved.','error',array('display'=>'success'));
				$this->data = "";
			} else {
				$this->set('error_messages', $this->Order->validationErrors);
				$this->Session->setFlash('The order could not be saved. Please, try again.','error',array('display'=>'error'));
			}
		}
		$oedoc = $this->OrderEdocs->find('all', array('conditions'=>array('OrderEdocs.order_id'=>$id)));
		$oedoccnt = $this->OrderEdocs->find('count', array('conditions'=>array('OrderEdocs.order_id'=>$id)));
		$this->set('orderedocs', $oedoc);
		if (empty($this->data)) {
			$admin_data = $this->Session->read('WBSWAdmin');
			$admin_id = $admin_data['Admin']['id'];
			$this->data = $this->Order->find('first',array('conditions'=>array('Order.id'=>$id), 'recursive'=>-1));
			$admindata = $this->Session->read('WBSWAdmin');
			if(($this->data['Order']['attended_by']!="0") and ($admin_id!=$this->data['Order']['attended_by']) and ($admindata['Admin']['type']=='E')){
				$this->Session->setFlash('You do not have permission to edit this request.','error',array('display'=>'warning'));
				$this->redirect(array('action'=>'index'));
				exit;
			}
			//If order is closed, this will not permitted to edit
			if($this->data['Order']['orderstatus_id']=='9') {
				$this->Session->setFlash('Request is already closed.','error',array('display'=>'warning'));
				$this->redirect(array('action'=>'index'));
				exit;
			}
		}
		$this->set('adminList',$this->Admin->find('list',array('recursive'=>1,'fields' => array('Admin.id', 'Admin.name'),'order'=>'Admin.name','conditions'=>array('Admin.status'=>'1'))));
		$this->set('clientList',$this->Client->find('list',array('recursive'=>1,'fields' => array('Client.user_id', 'Client.fullname', 'Client.company'),'order'=>'Client.first_name','conditions'=>array('User.status'=>'1'))));
	
		$users = $this->Order->User->find('list');
		$this->set(compact('users'));
		$this->set('docinfooptions', $this->_docinfooptions());
		$this->set('doctypeoptions', $this->_doctypeoptions());
		$this->set('pdftypeoptions', $this->_pdftypeoptions());
		$this->set('ynoptions', $this->_ynoptns());
		$this->set('nyoptions', $this->_nyoptns());
		$this->set('states', $this->_stateoptions());
		$this->set('shipoptions', $this->_shipoptions());
		$this->set('doc_typesoptions', $this->_doctypesoptionsslt());
	}

	/**************************
	*	Admin Search
	***************************/
	function admin_search() {

		if(isset($this->params['named']['status'])){
		$archived=$this->params['named']['status'];
		}
		/* Unset the session for new criteria */ 
		if(isset($_SESSION['search'])) unset($_SESSION['search']);
		$search_condition = array();
		$search_params = array();		
		if(!empty($this->data)) {
			
			if(isset($this->data['Orders']['name']) and trim($this->data['Orders']['name']) != '') {
				$search_condition[] = " (Order.first_name LIKE '%" . $this->data['Orders']['name'] . "')";
				$search_params['name'] = $this->data['Orders']['name'];
			}	
			if(isset($this->data['Orders']['lname']) and trim($this->data['Orders']['lname']) != '') {
				$search_condition[] = " (Order.last_name LIKE '%" . $this->data['Orders']['lname'] . "')";
				$search_params['lname'] = $this->data['Orders']['lname'];
			}	
			if(isset($this->data['Orders']['sa_city']) and trim($this->data['Orders']['sa_city']) != '') {
				$search_condition[] = " Order.sa_city LIKE '%" . $this->data['Orders']['sa_city'] . "'";
				$search_params['sa_city'] = $this->data['Orders']['sa_city'];
			}	
			if(isset($this->data['Orders']['sa_state']) and trim($this->data['Orders']['sa_state']) != '') {
				$search_condition[] = " Order.sa_state LIKE '%" . $this->data['Orders']['sa_state'] . "'";
				$search_params['sa_state'] = $this->data['Orders']['sa_state'];
			}	
			if(isset($this->data['Orders']['file']) and trim($this->data['Orders']['file']) != '') {
				$search_condition[] = " Order.file LIKE '%" . $this->data['Orders']['file'] . "'";
				$search_params['file'] = $this->data['Orders']['file'];
			}	
			if(isset($this->data['Orders']['sa_zipcode']) and trim($this->data['Orders']['sa_zipcode']) != '') {
				$search_condition[] = " Order.sa_zipcode LIKE '%" . $this->data['Orders']['sa_zipcode'] . "%' ";
				$search_params['sa_zipcode'] = $this->data['Orders']['sa_zipcode'];
			}
			if(isset($this->data['Orders']['orderstatus_id']) and trim($this->data['Orders']['orderstatus_id']) != '') {
				$search_condition[] = " Order.orderstatus_id=" . $this->data['Orders']['orderstatus_id'] . "";
				$search_params['orderstatus_id'] = $this->data['Orders']['orderstatus_id'];
			}	
			
			if(isset($this->data['Orders']['attended_by']) and trim($this->data['Orders']['attended_by']) != '') {
				$search_condition[] = " Order.attended_by=" . $this->data['Orders']['attended_by'] . "";
				$search_params['attended_by'] = $this->data['Orders']['attended_by'];
			}
					
			if(isset($this->data['Orders']['company']) and trim($this->data['Orders']['company']) != '') {
				$search_condition[] = " Clients.company LIKE '%" . $this->data['Orders']['company'] . "%' ";
				$search_params['company'] = $this->data['Orders']['company'];
			}
	
		}
		$_SESSION['search']['condition'] = $search_condition;
		$_SESSION['search']['params'] = $search_params;		
		if(!empty($this->params['named']['top']))
			$this->redirect(array('action'=>'index','top'=>$this->params['named']['top']));
		elseif(!empty($this->params['named']['medium']))
			$this->redirect(array('action'=>'index','medium'=>$this->params['named']['medium']));
		elseif(!empty($this->params['named']['low']))
			$this->redirect(array('action'=>'index','low'=>$this->params['named']['low']));
		else 
		if(isset($archived) && $archived<>""){
		$this->redirect(array('controller'=>'orders','action'=>'index','status'=>'archived'));
		}else{
	 		$this->redirect(array('action'=>'index'));
		}
	}
	
	/**************************
	*	Admin Search
	***************************/
	function admin_generatedreport() {
		/* Unset the session for new criteria */ 
		if(isset($_SESSION['search'])) unset($_SESSION['search']);
		$search_condition = array();
		$search_params = array();	
		$reporttype = (isset($this->data['Orders']['reporttype'])) ? $this->data['Orders']['reporttype'] : 'requests';
		if(!empty($this->data)) {
			if(isset($this->data['Orders']['osearch']) and trim($this->data['Orders']['osearch']) == "7" and $this->data['Orders']['heartype'] == ""){
				$this->Session->setFlash('Please select a value for Hear to view total #','error',array('display'=>'error'));
				$this->redirect(array('controller'=>'orders', 'action'=>'reports', 'type'=>$reporttype));
				exit;
			}
			if(isset($this->data['Orders']['search_type']) and ($this->data['Orders']['search_type'] == "fr")) {
				$title = "Total # of orders received";
				if($this->data['Orders']['orderstatus_id'] == '7') {
					$title = "Total # of COMPLETED signings";
				}
				if($this->data['Orders']['orderstatus_id'] == '5') {
					$title = "Total # of NO SIGNS";
				}
				$search_condition = "";
				if(isset($this->data['Orders']['ohsearch']) and trim($this->data['Orders']['ohsearch']) == '10') {
					if(isset($this->data['Orders']['time1']) and trim($this->data['Orders']['time1']) != '' and isset($this->data['Orders']['time2']) and trim($this->data['Orders']['time2']) != '' and isset($this->data['Orders']['odate']) and trim($this->data['Orders']['odate']) != '') {
						$date = $this->splitdate($this->data['Orders']['odate']);
				        $time1 = date("H:i:s", strtotime($this->data['Orders']['time1']));
				        $time2 = date("H:i:s", strtotime($this->data['Orders']['time2']));
						$datetfrm = $date." ".$time1;
						$datetto = $date." ".$time2;
						$search_condition .= " and o.created BETWEEN '" . $datetfrm . "' AND '" . $datetto . "'";
						$this->set('time1', $this->data['Orders']['odate']." ".$time1);
						$this->set('time2', $this->data['Orders']['odate']." ".$time2);
					}	else{
						$this->Session->setFlash('Please select a  date to view total #','error',array('display'=>'error'));
						$this->redirect(array('controller'=>'orders','action'=>'reports', 'type'=>$reporttype));
						exit;
					}
				}
				
				if(isset($this->data['Orders']['date']) and trim($this->data['Orders']['date']) != ''){
					$date = $this->splitdate($this->data['Orders']['date']);
					$search_condition .= " and o.created LIKE '%" . $date . "%'";
					$this->set('date', $this->data['Orders']['date']);
				}	
	
				if(isset($this->data['Orders']['from_date']) and trim($this->data['Orders']['from_date']) != '' and isset($this->data['Orders']['to_date']) and trim($this->data['Orders']['to_date']) != '') {
					$from = $this->splitdate($this->data['Orders']['from_date']);
					$to = $this->splitdate($this->data['Orders']['to_date']);
					$search_condition .= " and o.created between '" . $from . "' and  '" . $to . "'";
					$this->set('fromdate', $this->data['Orders']['from_date']);
					$this->set('todate',$this->data['Orders']['to_date']);
				}	
			
				if(isset($this->data['Orders']['company']) and trim($this->data['Orders']['company']) != '') {
					$search_condition.= ' and c.company Like "%' . $this->data['Orders']['company'] . '%"';
					$this->set('company', $this->data['Orders']['company']);
				}	
				if(isset($this->data['month']) and ($this->data['month']<>"")){
					$search_condition.= " and MONTH(o.created) = '" . $this->data['month']. "' ";
					$this->set('month',$this->data['month']);
				}
				if(isset($this->data['year']) and ($this->data['year']<>"")){
				 	$search_condition.= " and YEAR(o.created) = '" . $this->data['year'] . "'";
				 	$this->set('year',$this->data['year']);
				}
				if(isset($this->data['Orders']['orderstatus_id']) and trim($this->data['Orders']['orderstatus_id']) != '0') {
					$search_condition.=  " and o.orderstatus_id=" . $this->data['Orders']['orderstatus_id'] . "";
					$search_params['orderstatus_id'] = $this->data['Orders']['orderstatus_id'];
				}	
				$getnum = $this->Order->Query("SELECT o. * , u.id , c.company, c.user_id
											FROM orders o, clients c, users u
											WHERE o.user_id = u.id
											AND u.id = c.user_id ".$search_condition);
				$this->set('orders', $getnum);
			} else {
				if(isset($this->data['Orders']['osearch'])  and trim($this->data['Orders']['osearch'])=="4") {
					$title = "Total # of signings a notary has completed";
					$where = "";
					if(isset($this->data['Orders']['notary'])and trim($this->data['Orders']['notary']) != ''){
						$where = " AND a.user_id='".$this->data['Orders']['notary']."'";
						$this->set('notary',$this->data['Orders']['notary']);
					}
					if(isset($this->data['month']) and trim($this->data['month']) != '') {
						$where .= " AND MONTH(o.created) = '" . $this->data['month']. "'";
						$this->set('month',$this->data['month']);
					}
					if(isset($this->data['year']) and trim($this->data['year']) != '') {
						$where .= " AND YEAR(o.created) = '" . $this->data['year'] . "'";
						$this->set('year',$this->data['year']);
					}
					if(isset($this->data['Orders']['date']) and trim($this->data['Orders']['date']) != '') {
						$date = $this->splitdate($this->data['Orders']['date']);
						$where .= " and o.created LIKE '%" . $date . "%'";
						$this->set('date', $this->data['Orders']['date']);
					}	
					if(isset($this->data['Orders']['from_date']) and trim($this->data['Orders']['from_date']) != '' and isset($this->data['Orders']['to_date']) and trim($this->data['Orders']['to_date']) != ''){
						$from = $this->splitdate($this->data['Orders']['from_date']);
						$to = $this->splitdate($this->data['Orders']['to_date']);
						$where .= " AND o.created between '" . $from . "' and  '" . $to . "'";
						$this->set('fromdate', $this->data['Orders']['from_date']);
						$this->set('todate', $this->data['Orders']['to_date']);
					}
					$getnum = $this->Order->Query("SELECT count( * ) AS Number FROM assignments a, orders o WHERE a.order_id = o.id AND o.orderstatus_id = '7'".$where);					
					if(!empty($getnum)){
						$count=$getnum['0']['0']['Number'];
					}
				}
			
				if(isset($this->data['Orders']['osearch'])  and trim($this->data['Orders']['osearch'])=="5") {
					$title="Total # mistakes specific notaries have completed (per incidents)";
					$this->set('notary',$this->data['Orders']['mistakes']);
					if(isset($this->data['Orders']['mistakes']) and $this->data['Orders']['mistakes']<>""){
						$getmstk = $this->Notary->find('all', array('recursive' =>'-1','fields'=>array('Notary.first_name', 'Notary.last_name', 'Notary.userstatus', 'Notary.user_id', 'Notary.id',  'Notary.created', 'Notary.modified'),'conditions' => array('Notary.mistakes' => $this->data['Orders']['mistakes'])));
					} else {
						$this->Session->setFlash('Please select mistake to view total # ','error',array('display'=>'error'));
						$this->redirect(array('controller'=>'orders','action'=>'reports', 'type'=>$reporttype));
						exit;
					}
					$this->set('getmstk',$getmstk);
				}
				if(isset($this->data['Orders']['osearch'])  and trim($this->data['Orders']['osearch'])=="6") {
					$title = "Number of Notaries";
					$where = "";
					if(isset($this->data['Orders']['notarytype']) and trim($this->data['Orders']['notarytype'])<>"") {		
						$where = " WHERE `userstatus` ='".$this->data['Orders']['notarytype']."'";
						$this->set('notarytype', $this->data['Orders']['notarytype']);
					}
					if(isset($this->data['month']) and $this->data['month'] and $where<>""){
						$where .= " AND MONTH(created) = '" . $this->data['month']. "'";
						$this->set('month', $this->data['month']);
					}
					if(isset($this->data['month']) and $this->data['month'] and $where==""){
						$where .= " WHERE MONTH(created) = '" . $this->data['month']. "'";
						$this->set('month',$this->data['month']);
						
					}
					if(isset($this->data['year']) and $this->data['year'] and $where<>"") {
						$where .= " AND YEAR(created) = '" . $this->data['year'] . "'";
						$this->set('year',$this->data['year']);
					}
					if(isset($this->data['year']) and $this->data['year'] and $where=="") {
						$where .= " WHERE YEAR(created) = '" . $this->data['year'] . "'";
						$this->set('year',$this->data['year']);
					}
					if(isset($this->data['Orders']['from_date']) and trim($this->data['Orders']['from_date']) != '' and isset($this->data['Orders']['to_date']) and trim($this->data['Orders']['to_date']) != ''  and $where<>"") {
						$from = $this->splitdate($this->data['Orders']['from_date']);
						$to = $this->splitdate($this->data['Orders']['to_date']);
						$where .= " AND created between '" . $from . "' and  '" . $to . "'";
					}
					if(isset($this->data['Orders']['from_date']) and trim($this->data['Orders']['from_date']) != '' and isset($this->data['Orders']['to_date']) and trim($this->data['Orders']['to_date']) != ''  and $where=="") {
						$from = $this->splitdate($this->data['Orders']['from_date']);
						$to = $this->splitdate($this->data['Orders']['to_date']);
						$where .= " WHERE created between '" . $from . "' and  '" . $to . "'";
						$this->set('fromdate', $this->data['Orders']['from_date']);
						$this->set('todate', $this->data['Orders']['to_date']);
					}
					
					if(isset($this->data['Orders']['date']) and trim($this->data['Orders']['date']) != '' ) {
						$date = $this->splitdate($this->data['Orders']['date']);
						$where .= " AND created LIKE '%" . $date . "%'";
					}
					if(isset($this->data['Orders']['date']) and trim($this->data['Orders']['date']) != '' ){
						$date = $this->splitdate($this->data['Orders']['date']);
						$where .= " WHERE created LIKE '%" . $date . "%'";
						$this->set('date', $this->data['Orders']['date']);
					}
					$getnum = $this->Order->Query("SELECT count(*)  AS Number FROM `notaries` ".$where);
					if(!empty($getnum)) {
						$count = $getnum['0']['0']['Number'];
					}
				}
				if(isset($this->data['Orders']['osearch'])  and trim($this->data['Orders']['osearch'])=="7"  and ($this->data['Orders']['type']=="C")) {
					$title = "Total # client - how did u hear about us";
					$where = "";
					if(isset($this->data['Orders']['heartype'])and trim($this->data['Orders']['heartype']) != ''){
						$where = " AND c.how_hear='".$this->data['Orders']['heartype']."'";
						$this->set('heartype',$this->data['Orders']['heartype']);
					}
					if(isset($this->data['month']) and trim($this->data['month']) != ''){
						$where .= " AND MONTH(c.created) = '" . $this->data['month']. "'";
						$this->set('month',$this->data['month']);
					}
					if(isset($this->data['year']) and trim($this->data['year']) != ''){
						$where .= " AND YEAR(c.created) = '" . $this->data['year'] . "'";
						$this->set('year',$this->data['year']);
					}
					if(isset($this->data['Orders']['date']) and trim($this->data['Orders']['date']) != ''){
						$date = $this->splitdate($this->data['Orders']['date']);
						$where .= " and c.created LIKE '%" . $date . "%'";
						$this->set('date', $this->data['Orders']['date']);
					}	
					if(isset($this->data['Orders']['from_date']) and trim($this->data['Orders']['from_date']) != '' and isset($this->data['Orders']['to_date']) and trim($this->data['Orders']['to_date']) != ''){
						$from = $this->splitdate($this->data['Orders']['from_date']);
						$to = $this->splitdate($this->data['Orders']['to_date']);
						$where .= " AND c.created between '" . $from . "' and  '" . $to . "'";
						$this->set('fromdate', $this->data['Orders']['from_date']);
						$this->set('todate',$this->data['Orders']['to_date']);
					}
				
					$getnum = $this->Order->Query("SELECT count( * ) AS Number FROM users u, clients c WHERE c.user_id = u.id AND u.status = '1'".$where);
					if(!empty($getnum)){
						$count = $getnum['0']['0']['Number'];
					}
				}
				if(isset($this->data['Orders']['osearch']) and trim($this->data['Orders']['osearch'])=="7" and ($this->data['Orders']['type']=="N")) {
					$title = "Total # notary - how did u hear about us";
					$where = "";
					if(isset($this->data['Orders']['heartype'])and trim($this->data['Orders']['heartype']) != ''){
						$where = " AND c.how_hear='".$this->data['Orders']['heartype']."'";
						$this->set('heartype',$this->data['Orders']['heartype']);
					}
					if(isset($this->data['month']) and trim($this->data['month']) != ''){
						$where .= " AND MONTH(c.created) = '" . $this->data['month']. "'";
						$this->set('month',$this->data['month']);
					}
					if(isset($this->data['year']) and trim($this->data['year']) != ''){
						$where .= " AND YEAR(c.created) = '" . $this->data['year'] . "'";
						$this->set('year',$this->data['year']);
					}
					if(isset($this->data['Orders']['date']) and trim($this->data['Orders']['date']) != '') {
						$date = $this->splitdate($this->data['Orders']['date']);
						$where .= " and c.created LIKE '%" . $date . "%'";
						$this->set('date', $this->data['Orders']['date']);
					}	
					if(isset($this->data['Orders']['from_date']) and trim($this->data['Orders']['from_date']) != '' and isset($this->data['Orders']['to_date']) and trim($this->data['Orders']['to_date']) != ''){
						$from = $this->splitdate($this->data['Orders']['from_date']);
						$to = $this->splitdate($this->data['Orders']['to_date']);
						$where .= " AND c.created between '" . $from . "' and  '" . $to . "'";
						$this->set('fromdate', $this->data['Orders']['from_date']);
						$this->set('todate',$this->data['Orders']['to_date']);
					}
					$getnum = $this->Order->Query("SELECT count( * ) AS Number FROM users u, notaries c WHERE c.user_id = u.id AND u.status = '1'".$where);
					if(!empty($getnum)){
						$count = $getnum['0']['0']['Number'];
					}
				}
				if(isset($this->data['Orders']['osearch']) and trim($this->data['Orders']['osearch']) == "7" and ($this->data['Orders']['type'] == "")) {
					$title = "Total # client and notary - how did u hear about us";
					$where = "";
					$where2 = "";
					if(isset($this->data['Orders']['heartype'])and trim($this->data['Orders']['heartype']) != '') {
						$where = " AND c.how_hear='".$this->data['Orders']['heartype']."'";
						$this->set('heartype',$this->data['Orders']['heartype']);
					}
					if(isset($this->data['month']) and trim($this->data['month']) != '') {
						$where .= " AND MONTH(c.created) = '" . $this->data['month']. "'";
						$this->set('month',$this->data['month']);
					}
					if(isset($this->data['year']) and trim($this->data['year']) != '') {
						$where .= " AND YEAR(c.created) = '" . $this->data['year'] . "'";
						$this->set('year',$this->data['year']);
					}
					if(isset($this->data['Orders']['date']) and trim($this->data['Orders']['date']) != '') {
						$date = $this->splitdate($this->data['Orders']['date']);
						$where .= " and c.created LIKE '%" . $date . "%'";
						$this->set('date', $this->data['Orders']['date']);
					}	
					if(isset($this->data['Orders']['from_date']) and trim($this->data['Orders']['from_date']) != '' and isset($this->data['Orders']['to_date']) and trim($this->data['Orders']['to_date']) != '') {
						$from = $this->splitdate($this->data['Orders']['from_date']);
						$to = $this->splitdate($this->data['Orders']['to_date']);
						$where .= " AND c.created between '" . $from . "' and  '" . $to . "'";
						$this->set('fromdate', $this->data['Orders']['from_date']);
						$this->set('todate',$this->data['Orders']['to_date']);
					}
					$getnum = $this->Order->Query("SELECT count( * ) AS Number FROM users u, clients c WHERE c.user_id = u.id AND u.status = '1'".$where);				
					if(isset($this->data['Orders']['heartype'])and trim($this->data['Orders']['heartype']) != '') {
						$where2 = " AND c.how_hear='".$this->data['Orders']['heartype']."'";
						$this->set('heartype',$this->data['Orders']['heartype']);
					}
					if(isset($this->data['month']) and trim($this->data['month']) != '') {
						$where2 .= " AND MONTH(c.created) = '" . $this->data['month']. "'";
						$this->set('month',$this->data['month']);
					}
					if(isset($this->data['year']) and trim($this->data['year']) != '') {
						$where2 .= " AND YEAR(c.created) = '" . $this->data['year'] . "'";
						$this->set('year',$this->data['year']);
					}
					if(isset($this->data['Orders']['date']) and trim($this->data['Orders']['date']) != '') {
						$date = $this->splitdate($this->data['Orders']['date']);
						$where2 .= " and c.created LIKE '%" . $date . "%'";
						$this->set('date', $this->data['Orders']['date']);
					}	
					if(isset($this->data['Orders']['from_date']) and trim($this->data['Orders']['from_date']) != '' and isset($this->data['Orders']['to_date']) and trim($this->data['Orders']['to_date']) != '') {
						$from = $this->splitdate($this->data['Orders']['from_date']);
						$to = $this->splitdate($this->data['Orders']['to_date']);
						$where2 .= " AND c.created between '" . $from . "' and  '" . $to . "'";
						$this->set('fromdate', $this->data['Orders']['from_date']);
						$this->set('todate',$this->data['Orders']['to_date']);
					}
					$getnum2 = $this->Order->Query("SELECT count( * ) AS Number FROM users u, notaries c WHERE c.user_id = u.id AND u.status = '1'".$where2);
					if(!empty($getnum)){
						$count = $getnum['0']['0']['Number']+$getnum2['0']['0']['Number'];
					}
				}
				if(isset($count)){
					$this->set('resnum', $count);
				}
			}
		}
		$this->set(compact('orderstatuses'));
		$this->set('title', $title);
		$this->set('ntype', $this->_notaryoptions());
		$this->set('monthoptns', $this->_monthoptions());
		$this->set('states', $this->_stateoptions());
		$this->set('houroptions', $this->_hropt());
		$this->set('nmstk', $this->_notarymistake());
		$this->set('notaryoptions', $this->_notaryoptions());
		$this->set('hearoptions', $this->_hearoptions());
	}
	
	/************************
	*  Invoices
	***********************/	
	function admin_invoices() {		
		if(!empty($this->params['named']['s'])) {
			if(isset($_SESSION['search'])) unset($_SESSION['search']);
			$this->redirect(array('action'=>'invoices'));
		}
		if(!empty($this->data)) {
			//$condition 	= 	'Assignment.status = "A"'; 
			$d 			= 	date('Y-m-d', strtotime($this->data['Orders']['date_signing'])); 
			if(isset($this->data['Orders']['first_name']) and !empty($this->data['Orders']['first_name'])) {
				$condition .= ' AND Order.first_name LIKE "%'.$this->data['Orders']['first_name'].'%"';
			}
			if(isset($this->data['Orders']['date_signing']) and !empty($this->data['Orders']['date_signing'])) {
				$condition .= ' AND Order.date_signing LIKE "%'.$d.'%"';
			}
			if(isset($this->data['Orders']['sa_zipcode']) and !empty($this->data['Orders']['sa_zipcode'])) {
				$condition .= ' AND Order.sa_zipcode LIKE "%'.$this->data['Orders']['sa_zipcode'].'%"';
			}
			$assignment = $this->Assignment->find('all', array('conditions'=>@$condition));
			$this->set('assignment', $assignment);
		} else {
			$this->Assignment->Behaviors->attach('Containable');
			//$condition 	= 	'Assignment.status = "A"'; 
			$fields = array('Assignment.id','Assignment.user_id','Assignment.created ','Order.id','Order.first_name','Order.last_name','Order.sa_zipcode','Order.date_signing');
			
			$this->paginate = array('order'=>'Assignment.created DESC','fields'=>$fields);
			$this->set('assignment', $this->paginate('Assignment'));
		}	
	}
	
	/************************
	* Reports
	***********************/	
	function admin_reports() {	
		if(!empty($this->params['named']['s'])) {
			if(isset($_SESSION['search'])) unset($_SESSION['search']);
			$this->redirect(array('action'=>'reports'));
		}
		$this->set('notaryList',$this->Notary->find('list',array('recursive'=>1,'fields' => array('Notary.user_id', 'Notary.first_name', 'Notary.last_name'),'order'=>'Notary.first_name','conditions'=>array())));
		$this->Order->Behaviors->attach('Containable');
		$this->paginate = array('recursive'=>-1,'conditions'=>array('Order.orderstatus_id'=>119),'order'=>'Order.created DESC','fields'=>array('Order.id','Order.first_name','Order.last_name','Order.sa_zipcode','Order.orderstatus_id','Order.date_signing'));
		$this->set('reports', $this->paginate('Order'));
		$this->set('rmainoptions',$this->_rmainoptions());
		$this->set('rsuboptions',$this->_rsuboptions());
		$this->set('ntyoptions',$this->_notaryoptions());
		$this->set('hearoptions', $this->_hearoptions());
		$this->set('hhtype', $this->whichtypeuser());
		$this->set('houroptions', $this->_hropt());
		$this->set('nmstk', $this->_notarymistake());
		$this->set('notaryoptions', $this->_notaryoptions());
	}

	function admin_viewinvoice($id = null) {
		$ord = $this->Order->read(null, $id);
		$this->set('order', $ord);
		$this->set('st', $this->ust);
	}
	
	function admin_print($id = null) {
		$ord = $this->Order->read(null, $id);
		$this->set('order', $ord);
		$this->set('st', $this->ust);
		$this->layout = 'print';		
	}
	
	function _uploadFile($arimage) {
		$real_destination = realpath('').'/'.Configure::read('ORDERS_PATH') ; 
		$allowed = array('txt','doc','docx','pdf','xls');		
		if(isset($arimage) != "") {
			$result = $this->Upload->upload($arimage, $real_destination, null, null, $allowed);
			return $this->Upload->result;
		} else {
			return '';
		}
	}
	
	function terms($id = null,$agree=null) {
		if(isset($this->params['named']['id'])){
			$id=$this->params['named']['id'];
		}
		$cond = array('Order.id'=>$id);
		$this->Order->Behaviors->attach('Containable');
		$orderdetails = $this->Order->find('first', array('contain'=>array('Orderstatus','Assignment'=>array('fields'=>array('Assignment.user_id','Assignment.details','Assignment.created'))),'fields'=>array('Order.id','Order.user_id','Order.orderstatus_id','Order.first_name','Order.last_name','Order.home_phone', 'Order.work_phone', 'Order.cell_phone', 'Order.alternative_phone', 'Order.email', 'Order.date_signing', 'Order.file', 'Order.signing_instrn', 'Order.addtnl_notes', 'Order.addtnl_emails', 'Order.sa_street_address', 'Order.sa_state', 'Order.sa_city', 'Order.sa_zipcode', 'Order.pa_street_address', 'Order.pa_state', 'Order.pa_city', 'Order.pa_zipcode', 'Order.doc_info', 'Order.doc_submit', 'Order.pickup_address', 'Order.shipping_info', 'Order.tracking', 'Order.agree', 'Order.created','Orderstatus.status'),'conditions'=>$cond));	
		$this->set('Orderid',$id);
		$this->set('Orderfn',$orderdetails['Order']['first_name']);
		$this->set('Orderln',$orderdetails['Order']['last_name']);
		if(isset($agree) and $agree<>""){
			$id=$this->params['pass']['0'];
			
			
			if($agree=="yes"){
				//update order tbl agree value
				$data = array('Order' => array(
	                        'id'      => $id,
	                        'agree'   => 1));
	
				$this->Order->save($data, false, array('agree'));
		
				$this->redirect(array('controller'=>'orders','action'=>'view','borrower'=>Inflector::slug($orderdetails['Order']['first_name'].' '.$orderdetails['Order']['last_name']),'id'=>$id));
				exit();
			}else{
				$this->redirect(array('controller'=>'orders','action'=>'index','type'=>'notaries'));
				exit();
			}
		}
		$this->loadModel('Contentpage');
		$this->set('content', $this->Contentpage->find('first', array('fields'=>'content', 'conditions'=>array('id'=>'26', 'status'=>1))));
	
		$this->set('title_for_layout', '');
	}
	
	function download($id=null) {
		$this->layout = null;
		$userdata = $this->_checkPermission();
		$downloadetails = $this->OrderEdocs->find('first', array('recursive'=>-1,'fields'=>array('edocfile'), 'conditions'=>array('OrderEdocs.order_id'=>$this->params['id'],'OrderEdocs.edocfile'=>$this->params['filename'])));
		if($downloadetails) {
			$this->_downloadfile(getcwd().'/'.Configure::read('EDOC_FILE_PATH').$downloadetails['OrderEdocs']['edocfile']);
			exit();
		} 
		$this->Session->setFlash(__('Invalid download attempt.', true));
		$this->redirect(array('controller'=>'orders','action'=>'view','borrower'=>$this->params['borrower'],'id'=>$this->params['id']));
		exit();
	}
	
	function admin_accept_ownership($id=null){		
		$admin_data = $this->Session->read('WBSWAdmin');
		$admin_id = $admin_data['Admin']['id'];
		///update order tbl attended_by value
		$data = array('Order' => array(
                    'id'      => $id,
                    'attended_by' => $admin_id));

		$this->Order->save($data, false, array('attended_by'));
		$this->Session->setFlash('You have successfully accepted the order ownership','error',array('display'=>'success'));
		$this->redirect(array('controller'=>'orders','action'=>'view',$id));
		exit();
	}
	
	function admin_reject_ownership($id=null){
		$admin_data = $this->Session->read('WBSWAdmin');
		$admin_id = $admin_data['Admin']['id'];
		
		$orderdetails = $this->Order->find('first',array('fields'=>array('Order.id','Order.orderstatus_id'),'conditions'=>array('Order.id'=>$id)));

		//upon ownership update, insert prev owner into history
		$this->HistoryOwners->create();
		$hfees['HistoryOwners']['admin_id'] = $admin_id;
		$hfees['HistoryOwners']['order_id'] = $id;
		$this->HistoryOwners->save($hfees);
		
		//update order tbl attended_by value
		$data = array('Order' => array(
                    'id' => $id,
                    'attended_by' => ''));
		$this->Order->save($data, false, array('attended_by'));							
		$this->Session->setFlash('You have successfully rejected the order ownership.','error',array('display'=>'success'));
		$this->redirect(array('controller'=>'orders','action'=>'view',$id));	
	}
	
	/* For ivr */
	function check_assigned($id=null){
		$this->layout = null;		
		$orderdetails = $this->Order->find('first',array('fields'=>array('Order.id','Order.orderstatus_id'),'conditions'=>array('Order.id'=>$id)));
		if($orderdetails) {
			if($orderdetails['Order']['orderstatus_id']>=2) {
				echo 1;
			} else {
				echo 2;
			}
		} else {
			echo 0;
		}
	}
	
	function __sendTextMessage($arpassed, $backpath=null) {
		if(!@$this->params['admin']) {
			$userdata = $this->_checkPermission();
		}
		if($arpassed) {
			$this->loadModel('Msgsetting');
			$notariescnt = $this->Msgsetting->find('first', array('order'=>'Msgsetting.created DESC'));
			$this->Notary->Behaviors->attach('Containable');
			$notarieslistp = $this->Notary->find('all', array('contain'=>array('User'),'fields'=>array('Notary.id','Notary.cell_phone','Notary.first_name','Notary.last_name','User.status','Notary.zipcode'),'order'=>'RAND()','conditions'=>array('OR'=>array('Notary.expiration >= '=>date('Y-m-d'),'Notary.expiration'=>'0000-00-00'),'OR'=>array('Notary.enddate >= '=>date('Y-m-d'),'Notary.enddate'=>'0000-00-00'),'Notary.mistakes <'=>'3','User.status'=>'1','Notary.zipcode LIKE'=>"%".$arpassed['zipcode']."%",'Notary.userstatus'=>array('P'),'Notary.notify != '=>'E')));
			$notarieslistb = $this->Notary->find('all', array('contain'=>array('User'),'fields'=>array('Notary.id','Notary.cell_phone','Notary.first_name','Notary.last_name','User.status','Notary.zipcode'),'order'=>'RAND()','conditions'=>array('OR'=>array('Notary.expiration >= '=>date('Y-m-d'),'Notary.expiration'=>'0000-00-00'),'OR'=>array('Notary.enddate >= '=>date('Y-m-d'),'Notary.enddate'=>'0000-00-00'),'Notary.mistakes <'=>'3','User.status'=>'1','Notary.zipcode LIKE'=>"%".$arpassed['zipcode']."%",'Notary.userstatus'=>array('B'),'Notary.notify != '=>'E')));
			$notarieslist = array_merge($notarieslistp, $notarieslistb);
			if($notarieslist){
				foreach($notarieslist as $key=>$sendmesms) {
					if ($key < $notariescnt['Msgsetting']['notarycount']) {
						$messagedetails[$key]['name'] = $sendmesms['Notary']['first_name']." ".$sendmesms['Notary']['last_name'];
						$messagedetails[$key]['number'] = $sendmesms['Notary']['cell_phone'];
						$messagedetails[$key]['zipcode'] = $arpassed['zipcode'];
						$messagedetails[$key]['date'] = $arpassed['signingdate'];
						$messagedetails[$key]['reforderid'] = $arpassed['orderid'];
					}
				}
			}
			$result = $this->Twilio->sendSMS($messagedetails);
		}
		if($backpath) {
			$this->redirect(array('controller'=>'orders', 'action'=>'index', 'type'=>$this->whichtypeuser($userdata['User']['type'])));
		}
	}

	function search() {
		$userdata = $this->_checkPermission();
		/* Unset the session for new criteria */ 
		if(isset($_SESSION['search'])) unset($_SESSION['search']);
		$search_condition = array();
		$search_params = array();
		if(!empty($this->data)) {
			if(isset($this->data['Orders']['firstname']) and trim($this->data['Orders']['firstname']) != '') {
				$search_condition[] = "(Order.first_name LIKE '%" . $this->data['Orders']['firstname'] . "')";
				$search_params['firstname'] = $this->data['Orders']['firstname'];
			}
			if(isset($this->data['Orders']['lastname']) and trim($this->data['Orders']['lastname']) != '') {
				$search_condition[] = "(Order.last_name LIKE '%" . $this->data['Orders']['lastname'] . "')";
				$search_params['lastname'] = $this->data['Orders']['lastname'];
			}
			if(isset($this->data['Orders']['sa_city']) and trim($this->data['Orders']['sa_city']) != '') {
				$search_condition[] = " Order.sa_city LIKE '%" . $this->data['Orders']['sa_city'] . "'";
				$search_params['sa_city'] = $this->data['Orders']['sa_city'];
			}
			if(isset($this->data['Orders']['sa_state']) and trim($this->data['Orders']['sa_state']) != '') {
				$search_condition[] = " Order.sa_state = '" . $this->data['Orders']['sa_state'] . "'";
				$search_params['sa_state'] = $this->data['Orders']['sa_state'];
			}
			if(isset($this->data['Orders']['file']) and trim($this->data['Orders']['file']) != '') {
				$search_condition[] = " Order.file = '" . $this->data['Orders']['file'] . "'";
				$search_params['file'] = $this->data['Orders']['file'];
			}
			if(isset($this->data['Orders']['orderstatuses']) and trim($this->data['Orders']['orderstatuses']) != '') {
				$search_condition[] = " Order.orderstatus_id = " . $this->data['Orders']['orderstatuses'] . "";
				$search_params['orderstatuses'] = $this->data['Orders']['orderstatuses'];
			}
			if(isset($this->data['Orders']['user_id']) and trim($this->data['Orders']['user_id']) != '') {
				$search_condition[] = " Assignment.user_id = " . $this->data['Orders']['user_id'] . "";
				$search_params['user_id'] = $this->data['Orders']['user_id'];
			}
		}

		$_SESSION['search']['condition'] = $search_condition;
		$_SESSION['search']['params'] = $search_params;
	 	$this->redirect(array('controller'=>'orders', 'action'=>'index', 'type'=>$this->whichtypeuser($userdata['User']['type'])));
	}

	function admin_clear() {
		/* Clear the session for new search */
		$this->__clearsearch();
		
	}
	
	function clear() {
		/* Clear the session for new search */
		$this->__clearsearch();
	}
	
	function splitdate($date, $time=null) {
		$tmp_date = explode('-', $date);
		return $tmp_date[2].'-'.$tmp_date[0].'-'.$tmp_date[1];
   	}

	function remove_edoc($id=null) {
 		$userdata = $this->_checkPermission();
		$doc_destination = realpath('').'/'.Configure::read('EDOC_FILE_PATH') ; 
		if (substr($doc_destination,-1) != '/') { $doc_destination .= '/'; }
		$dataSource = ConnectionManager::getDataSource('default');
		$results = $dataSource->query('SELECT order_id,edocfile FROM order_edocs WHERE id = ' . intval($id));
		$order_id = $results[0]["order_edocs"]["order_id"];
		$fileName = $results[0]["order_edocs"]["edocfile"];
		$this->__addAuditTrail($id, "R");
		$dataSource->execute('DELETE FROM order_edocs WHERE id = ' . intval($id));
		unlink($doc_destination . $fileName);
		$this->autoRender = false; 
		return json_encode($this->__getAlleDocs($order_id)); 
	}
	
	function add_eDocs() {
		$userdata = $this->_checkPermission();
		$this->autoRender = false;
		$doc_destination = realpath('').'/'.Configure::read('EDOC_FILE_PATH') ; 
		$total = count($this->data['OrderEdocs']['edocfile']);
		
		for($i=0;$i<$total;$i++) {
			$this->OrderEdocs->create();
			$orderedoc['OrderEdocs']['order_id'] = $_POST["order_id"];
			$orderedoc['OrderEdocs']['ptype'] = $this->data['OrderEdocs']['ptype'][$i];
			$orderedoc['OrderEdocs']['edocfile'] = $this->data['OrderEdocs']['edocfile'][$i];
						
			if(isset($orderedoc['OrderEdocs']['edocfile']) && $orderedoc['OrderEdocs']['edocfile']!= "") {
				$allowed = array('doc','docx','pdf');
				$result = $this->Upload->upload($orderedoc['OrderEdocs']['edocfile'],$doc_destination,null,null,$allowed);						
				$orderedoc['OrderEdocs']['edocfile'] = $this->Upload->result;
			} else {
				$orderedoc['OrderEdocs']['edocfile'] = '';
			}
			if($orderedoc['OrderEdocs']['edocfile']<>""){
				$this->OrderEdocs->save($orderedoc);
				$this->__addAuditTrail($this->OrderEdocs->id, "A");
			}
		}

		return json_encode($this->__getAlleDocs($_POST["order_id"]));
	}

	function __getAlleDocs($order_id) 
	{	
		$userdata = $this->_checkPermission();
		$dataSource = ConnectionManager::getDataSource('default');
		$results = $dataSource->query('SELECT id, ptype, order_id, edocfile FROM order_edocs WHERE order_id = ' . intval($order_id) . " ORDER BY id desc") ;	
		return $results;
   	}
	
	
	function __addAuditTrail($id, $action) 
	{	
		$userdata = $this->_checkPermission();
		$dataSource = ConnectionManager::getDataSource('default');
		$results = $dataSource->query("SELECT order_id, ptype, edocfile FROM order_edocs WHERE order_edocs.id = " . intval($id)) ;	
		if(count($results) == 1);
		{
		 $dataSource->execute("
			INSERT INTO edocs_audit_trail (client_user_id, client_name, order_id, edoc_file_name, edoc_file_type, action)  
			VALUES ('" . $userdata["Client"]["id"] . "', '" .  $userdata["Client"]["first_name"] . " " . $userdata["Client"]["last_name"]  . "', '" . $results[0]["order_edocs"]["order_id"] . "', '" . $results[0]["order_edocs"]["edocfile"] . "', '" . $results[0]["order_edocs"]["ptype"] . "', '" . $action . "')");
		}
   	}
	
	function __addAuditTrailAdmin($id, $action) 
	{	
		$dataSource = ConnectionManager::getDataSource('default');
		$results = $dataSource->query("SELECT order_id, ptype, edocfile FROM order_edocs WHERE order_edocs.id = " . intval($id)) ;	
		if(count($results) == 1);
		{
		 $dataSource->execute("
			INSERT INTO edocs_audit_trail (client_user_id, client_name, order_id, edoc_file_name, edoc_file_type, action)  
			VALUES ('2', 'Admin User', '" . $results[0]["order_edocs"]["order_id"] . "', '" . $results[0]["order_edocs"]["edocfile"] . "', '" . $results[0]["order_edocs"]["ptype"] . "', '" . $action . "')");
		}
   	}
		
		function isValid() 
		{
			try {

				$url = 'https://www.google.com/recaptcha/api/siteverify';
				$data = ['secret'   => '6LfHCAkUAAAAAM4SbnAXWPqVB3fx4KTyGnB_vPy2',
						 'response' => $_POST['g-recaptcha-response'],
						 'remoteip' => $_SERVER['REMOTE_ADDR']];

				$options = [
					'http' => [
						'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						'method'  => 'POST',
						'content' => http_build_query($data) 
					]
				];

				$context  = stream_context_create($options);
				$result = file_get_contents($url, false, $context);
				return json_decode($result)->success;
			}
			catch (Exception $e) {
				return null;
			}
		}
	}
?>