<?php
class SigninghistoriesController extends AppController {
	
	var $name = 'Signinghistories';
	var $uses = array('Signinghistory','Order','Invoice','Orderstatus','Client','Assignment','Notary','ClientFee','NotaryFee','reactivateFees');

	function index() {
		$this->layout=null;
		if(empty($this->params['id'])) {
			$this->Session->setFlash('Invalid order selected.', 'error', 'error');
			$this->redirect(array('controller'=>'orders','action' => 'index'));
		}
		$this->paginate = array('fields'=>array('Client.first_name','Notary.first_name','Client.last_name','Notary.last_name','Orderstatus.status','Signinghistory.order_id', 'Signinghistory.user_id','Signinghistory.orderstatus_id','Signinghistory.notes','Signinghistory.appointment_time','Signinghistory.added_by','Signinghistory.created'),'conditions'=>array('Signinghistory.order_id'=>$this->params['id'],'Signinghistory.status'=>'1'));
		$this->set('title_for_layout', 'Signings History');
		$this->set('signinghistories', $this->paginate());
	}
	
	function add() {
		$userdata = $this->_checkPermission();
		$this->layout = null;
		if(empty($this->data)) {
			if(isset($this->params['id']) && $this->params['id']<>"") {
				$id = $this->params['id'];
			} else {
				$id = $this->params['named']['id'];
			}
			if (empty($id)) {
				$this->Session->setFlash('The signing is not valid.','error',array('display'=>'warning'));
				$this->redirect(array('controller'=>'orders','action'=>'index'));
			}
			$this->set('Orderid', $id);
			$cond = array('Order.id'=>$id);
			
			if($userdata['User']['type']=='C') {$cond = array('Order.id'=>$id, 'Order.user_id'=>$userdata['User']['id']);}
			$orderdetails = $this->Order->find('first', array('fields'=>array('Order.id','Order.user_id','Order.orderstatus_id','Order.first_name','Order.last_name', 'Order.date_signing', 'Order.file','Orderstatus.status','Order.sa_city','Order.sa_state','Order.sa_zipcode'),'conditions'=>$cond));
			$this->set('Orderstatusid', $orderdetails['Order']['orderstatus_id']);
			if($orderdetails['Order']['orderstatus_id']==4) {
				//find the signing history apnt time and set it.
				$takeapttime = $this->Signinghistory->find('first',array('order'=>'Signinghistory.created DESC','fields'=>array('Signinghistory.appointment_time'),'conditions'=>array('Signinghistory.order_id'=>$id, 'Signinghistory.orderstatus_id'=>4)));
				$this->set('crntapttime', $takeapttime['Signinghistory']['appointment_time']);
			}
			
			if (empty($this->data) and empty($orderdetails)) {
				$this->Session->setFlash('The signing is not valid.','error',array('display'=>'warning'));
				$this->redirect(array('controller'=>'orders','action'=>'index'));
			}
			if($userdata['User']['type']=='N') {$arrstat = array('3','4','5','7'); } else { $arrstat = array('3','4','5','7','6','10');}
			$this->set('Orderstatus', $this->Orderstatus->find('list',array('recursive'=>0,'fields' => array('Orderstatus.id','Orderstatus.status'),'conditions' => array('Orderstatus.id' => $arrstat))));
			$this->set('order', $orderdetails);
		}
		if(!empty($this->data)) {
			if($this->data['Signinghistory']['orderstatus_id'] == "") {
				$this->data['Signinghistory']['orderstatus_id'] = $this->data['Signinghistory']['cur_orderstatus_id'];
			}
			
			$this->Signinghistory->create();
			$this->data['Signinghistory']['added_by'] = $userdata['User']['type'];
			if($userdata['User']['type'] == 'N') {
				$this->data['Signinghistory']['status'] = '0';
			}
			$this->data['Signinghistory']['user_id'] = $userdata['User']['id'];
			if($this->data['Signinghistory']['orderstatus_id'] == '4' or $this->data['Signinghistory']['orderstatus_id'] == '7' ) {
				if($userdata['User']['type'] == 'N') {
				 //SCHEDULED or SIGNING COMPLETED status changes should automatically update for notary.
					$this->data['Signinghistory']['status'] = '1';
				}
				unset($this->Signinghistory->validate['notes']);		
			}
			if($this->data['Signinghistory']['orderstatus_id'] != '4') {
				$this->data['Signinghistory']['appointment_time'] = "";
				unset($this->Signinghistory->validate['appointment_time']);		
			}
			if ($this->Signinghistory->save($this->data)) {
				$odetails = $this->Order->find('first',array('fields'=>array('Order.id','Order.user_id','Order.cell_phone','Order.pa_street_address','Order.pa_state','Order.pa_city','Order.pa_zipcode','Order.sa_state','Order.sa_city','Order.sa_zipcode','Order.file','Order.first_name','Order.last_name','Order.addtnl_emails'),'conditions'=>array('Order.id'=>$this->data['Signinghistory']['order_id'])));
				$cdetails = $this->Client->find('first',array('fields'=>array('Client.id','Client.user_id','Client.first_name','Client.last_name','Client.email','Client.company','Client.fees'),'conditions'=>array('Client.user_id'=>$odetails['Order']['user_id'])));
				$assgdetails = $this->Assignment->find('first',array('fields'=>array('Assignment.user_id'),'conditions'=>array('Assignment.order_id'=>$this->data['Signinghistory']['order_id'])));
				$ndetails = $this->Notary->find('first',array('fields'=>array('Notary.id','Notary.first_name','Notary.last_name','Notary.email'),'conditions'=>array('Notary.user_id'=>$assgdetails['Assignment']['user_id'])));
				$currorderstatus = $this->Orderstatus->find('first',array('recursive'=>0,'fields' => array('Orderstatus.id','Orderstatus.status'),'conditions' => array('Orderstatus.id' => $this->data['Signinghistory']['orderstatus_id'])));
				
				/****************************************************
				 *						START						*
				 * 													*
			 	 * 		SEND MAILS TO CLIENT, NOTARY, ADMIN			*
				 *													*				 														 * 													*
				 ****************************************************/
				if($this->data['Signinghistory']['orderstatus_id']=='3') {

					if($userdata['User']['type']=='C') 
					{
						/* Send the notification mail to ADMIN */
						$orderresult['mailorderstatus'] = '32';	
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>Configure::read('clientupdate'),'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - UNSCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
						
						/* Send the notification mail to NOTARY */
						$orderresult['mailorderstatus'] = '31';
						$orderresult['salutation'] = $ndetails['Notary']['first_name'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - UNSCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));				
					}
					
					/* Send the notification mail to ADDITIONAL EMAILS */
					if($odetails['Order']['addtnl_emails'] != '')
					{
						$orderresult['mailorderstatus'] = '31';	
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$odetails['Order']['addtnl_emails'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - UNSCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
					
				}
				
				if($this->data['Signinghistory']['orderstatus_id']=='4') {
					if($userdata['User']['type']=='C') {
						/* Send the notification mail to NOTARY */
						$orderresult['mailorderstatus'] = '41';
						$orderresult['salutation'] = $ndetails['Notary']['first_name'];
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$orderresult['scheduleddate'] = date(Configure::read('nsdate'));
						$orderresult['scheduledtime'] = $this->data['Signinghistory']['appointment_time'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
					if($userdata['User']['type']=='N') {
						/* Send the notification mail to CLIENT */
						$orderresult['mailorderstatus'] = '42';
						$orderresult['salutation'] = $cdetails['Client']['first_name'];
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$orderresult['scheduleddate'] = date(Configure::read('nsdate'));
						$orderresult['scheduledtime'] = $this->data['Signinghistory']['appointment_time'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
					
					/* Send the notification mail to ADDITIONAL EMAILS */
					if($odetails['Order']['addtnl_emails'] != '')
					{
						$orderresult['mailorderstatus'] = '42';
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$orderresult['scheduleddate'] = date(Configure::read('nsdate'));
						$orderresult['scheduledtime'] = $this->data['Signinghistory']['appointment_time'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$odetails['Order']['addtnl_emails'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
						
				}
				
				if($this->data['Signinghistory']['orderstatus_id']=='5') {
					if($userdata['User']['type']=='C') {					
						/* Send the notification mail to NOTARY */
						$orderresult['mailorderstatus'] = '51';
						$orderresult['salutation'] = $ndetails['Notary']['first_name'];
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - NO SIGN: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
						
						/* Send the notification mail to ADMIN */
						$orderresult['mailorderstatus'] = '53';
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>Configure::read('clientupdate'),'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - NO SIGN: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
					
					/* Send the notification mail to ADDITIONAL EMAILS */
					if($odetails['Order']['addtnl_emails'] != '')
					{
						$orderresult['mailorderstatus'] = '51';	
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$odetails['Order']['addtnl_emails'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - NO SIGN: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
					
				}
				
				
				if($this->data['Signinghistory']['orderstatus_id']=='6') {
					if($userdata['User']['type']=='C') {
						/* Send the notification mail to NOTARY */
						$orderresult['mailorderstatus'] = '62';
						$orderresult['salutation'] = $ndetails['Notary']['first_name'];
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - PENDING: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
					/* Send the notification mail to ADMIN */
					$orderresult['mailorderstatus'] = '63';
					$orderresult['salutation'] = '';
					$orderresult['Order'] = $odetails['Order'];
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>Configure::read('clientupdate'),'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - PENDING: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					
					if($odetails['Order']['addtnl_emails'] != '')
					{
						$orderresult['salutation'] = '';
						
					}
					
					/* Send the notification mail to ADDITIONAL EMAILS */
					if($odetails['Order']['addtnl_emails'] != '')
					{
						$orderresult['mailorderstatus'] = '63';	
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$odetails['Order']['addtnl_emails'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - PENDING: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
					
				}
				
				if($this->data['Signinghistory']['orderstatus_id']=='7') {
					if($userdata['User']['type']=='N') {
						/* Send the notification mail to CLIENT */
						$orderresult['mailorderstatus'] = '71';
						$orderresult['salutation'] = $cdetails['Client']['first_name'];
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['shipping'] = $this->_getShippingCarrier($this->data['Signinghistory']['track_shipping_info'], $this->data['Signinghistory']['tracking_no']);
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SIGNING COMPLETED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
						
						$orderresult['mailorderstatus'] = '73';
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['shipping'] = $this->_getShippingCarrier($this->data['Signinghistory']['track_shipping_info'], $this->data['Signinghistory']['tracking_no']);
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>Configure::read('notaryupdate'),'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SIGNING COMPLETED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
					if($userdata['User']['type']=='C') {
						/* Send the notification mail to NOTARY */
						$orderresult['mailorderstatus'] = '72';
						$orderresult['salutation'] = $ndetails['Notary']['first_name'];
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['shipping'] = $this->_getShippingCarrier($this->data['Signinghistory']['track_shipping_info'], $this->data['Signinghistory']['tracking_no']);
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SIGNING COMPLETED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
						
						$orderresult['mailorderstatus'] = '73';
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['shipping'] = $this->_getShippingCarrier($this->data['Signinghistory']['track_shipping_info'], $this->data['Signinghistory']['tracking_no']);
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>Configure::read('clientupdate'),'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SIGNING COMPLETED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
					
					
					/* Send the notification mail to ADDITIONAL EMAILS */
					if($odetails['Order']['addtnl_emails'] != '')
					{
						$orderresult['mailorderstatus'] = '71';	
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$orderresult['shipping'] = $this->_getShippingCarrier($this->data['Signinghistory']['track_shipping_info'], $this->data['Signinghistory']['tracking_no']);
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$odetails['Order']['addtnl_emails'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SIGNING COMPLETED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
				}
				
				if($this->data['Signinghistory']['orderstatus_id']=='10') {					
					/* Send the notification mail to NOTARY */
					$orderresult['mailorderstatus'] = '102';
					$orderresult['salutation'] = $ndetails['Notary']['first_name'];
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$orderresult['Order'] = $odetails['Order'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - CANCELED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					
					/* Send the notification mail to ADMIN */
					$orderresult['mailorderstatus'] = '103';
					$orderresult['salutation'] = '';
					$orderresult['Order'] = $odetails['Order'];
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>Configure::read('clientupdate'),'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - CANCELED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));

					
					/* Send the notification mail to ADDITIONAL EMAILS */
					if($odetails['Order']['addtnl_emails'] != '')
					{
						$orderresult['mailorderstatus'] = '102';	
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$odetails['Order']['addtnl_emails'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - CANCELED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
				}
				
				
				/****************************************************
				 *					THE END							*
				 * 													*
			 	 * 		SEND MAILS TO CLIENT, NOTARY, ADMIN			*
				 *													*				 														 * 													*
				 ****************************************************/
				if($this->data['Signinghistory']['orderstatus_id'] == '7' &&  $this->data['Signinghistory']['tracking_no']<>"") {
			 		$this->data['Signinghistory']['orderstatus_id'] = 8;
					$this->data['Invoice']['order_id'] = $this->data['Signinghistory']['order_id'];
					$this->data['Invoice']['totalfees'] = $cdetails['Client']['fees'];
					$this->data['Invoice']['status'] = 0;
					unset($this->Invoice->validate['totalfees']);
					unset($this->Invoice->validate['invoicedoc']);
					$this->Invoice->create();
					$this->Invoice->save($this->data);
				 	//Update shipping info in orders table if status is completed
					if(isset($this->data['Signinghistory']['track_shipping_info']) and $this->data['Signinghistory']['track_shipping_info']<>"") {
						//update the orders table
						$data = array('Order'=>array('id'=>$this->data['Signinghistory']['order_id'],'track_shipping_info'=>$this->data['Signinghistory']['track_shipping_info'],'tracking_no'=>@$this->data['Signinghistory']['tracking_no'],'orderstatus_id'=>$this->data['Signinghistory']['orderstatus_id'], 'statusdate'=>date('Y-m-d H:i:s')));
						$this->Order->save($data, false, array('track_shipping_info', 'tracking_no', 'orderstatus_id', 'statusdate'));
					}
				} else {
					if($userdata['User']['type'] =='N' and (in_array($this->data['Signinghistory']['orderstatus_id'], array('3', '5')))) {
						//Nothing to do, the status remain the same until the admin appproves the status
					} else {
						//update the orders table
						$data = array('Order'=>array('id'=>$this->data['Signinghistory']['order_id'], 'orderstatus_id'=>$this->data['Signinghistory']['orderstatus_id'], 'statusdate'=>date('Y-m-d H:i:s')));
						$this->Order->save($data, false, array('orderstatus_id', 'statusdate'));
					}
				}
			
				$oid = $this->params['data']['Signinghistory']['order_id'];
				$oname = Inflector::slug($odetails['Order']['first_name'].' '.$odetails['Order']['last_name']);
				if($userdata['User']['type']=='C') {
					$this->Session->setFlash('The status has been changed.', 'error',array('display'=>'success'));
					$this->redirect(array('controller'=>'signinghistories', 'action'=>'blankpage'));
				} else {
					$this->Session->setFlash('The status has been changed.', 'error',array('display'=>'success'));
					$this->redirect(array('controller'=>'signinghistories', 'action'=>'blank_page', 'id'=>$oid, 'oname'=>$oname));
				}
				exit();
			} else {
				$this->Session->setFlash('The status could not be changed. Please, try again.', 'error', array('display'=>'error'));
				$this->set('error_messages', $this->Signinghistory->validationErrors);
			}
		}
		$this->set('title_for_layout', 'Change Signing Status');
		$this->set('shipoptions', $this->_shipoptions());
	}
	
	function blankpage() {
		$this->layout='';
	}
	
	function blank_page() {
		$this->layout='';
		$this->set('id', $this->params['named']['id']);
		$this->set('oname', $this->params['named']['oname']);
	}
		
	function admin_index() {
		if(isset($_SESSION['search']['condition']) and !empty($_SESSION['search']['condition'])) {
			$condition[] = array(implode(' AND ', @$_SESSION['search']['condition']));
		}
		if(empty($this->params['named']['id'])) {
			$this->Session->setFlash('Invalid order selected', 'error', 'error');
			$this->redirect(array('controller'=>'orders','action' => 'index'));
		}
		$this->paginate = array('order'=>'Signinghistory.created DESC','fields'=>array('Client.first_name','Notary.first_name','Client.last_name','Notary.last_name','Orderstatus.status','Signinghistory.order_id', 'Signinghistory.user_id','Signinghistory.status','Signinghistory.orderstatus_id','Signinghistory.notes','Signinghistory.added_by','Signinghistory.appointment_time'),'conditions'=>array('Signinghistory.order_id'=>$this->params['named']['id']));
		$this->set('title_for_layout', 'Signings History');
		$this->set('signinghistories', $this->paginate());
	
	}

	function admin_add() {
		$admin_data = $this->Session->read('WBSWAdmin');
		$admin_id = $admin_data['Admin']['id'];
		if (empty($this->data)) {
			$id = $this->params['named']['id'];
			if (empty($this->data) and empty($id)) {
				$this->Session->setFlash('The Signing is not valid.','error',array('display'=>'warning'));
				$this->redirect(array('action'=>'index'));
				exit;
			}
			$this->set('Orderid', $id);
			$orderdetails = $this->Order->find('first', array('fields'=>array('Order.id','Order.user_id','Order.orderstatus_id','Order.first_name','Order.last_name','Order.email','Order.date_signing','Order.file','Orderstatus.status','Order.sa_city','Order.sa_state','Order.sa_zipcode'),'conditions'=>array('Order.id'=>$id)));
			if (empty($this->data) and empty($orderdetails)) {
				$this->Session->setFlash('The Signing is not valid.','error',array('display'=>'warning'));
				$this->redirect(array('action'=>'index'));
				exit;
			}
		}
		if(!empty($this->data)) {
			$this->Signinghistory->create();
			/******************************************************************************
			*	Since admin changes status
			* 	If it is added from Admin, there is no need for approval 'Approved'	
			****************************************************************************/
			$this->data['Signinghistory']['added_by'] = 'A';
			$this->data['Signinghistory']['user_id'] = $admin_id;
			$this->data['Signinghistory']['status'] = '1';
			
			if($this->data['Signinghistory']['orderstatus_id'] == '4' or $this->data['Signinghistory']['orderstatus_id'] == '7' or $this->data['Signinghistory']['orderstatus_id'] == '2' ) {
				unset($this->Signinghistory->validate['notes']);
			}
			if($this->data['Signinghistory']['orderstatus_id'] != '4') {
				$this->data['Signinghistory']['appointment_time']='';
				unset($this->Signinghistory->validate['appointment_time']);
			}
			
			/*
			if($this->data['Signinghistory']['orderstatus_id'] == '7') { //Signing completed
				$orderstatus = $this->Signinghistory->find('first', array('recursive'=>0, 'fields'=>array('Signinghistory.appointment_time'),'conditions'=>array('Signinghistory.order_id'=>$this->data['Signinghistory']['order_id'],'Signinghistory.orderstatus_id'=>'4')));
				if($orderstatus['Signinghistory']['appointment_time'] <> "") {
					$this->data['Signinghistory']['appointment_time'] = $orderstatus['Signinghistory']['appointment_time'];
				} else {
					$this->data['Signinghistory']['appointment_time'] = "";
				}
			}
			*/
			if ($this->Signinghistory->save($this->data)) {
				$orderstatus = $this->Orderstatus->find('first',array('recursive'=>0,'fields'=>array('Orderstatus.id','Orderstatus.status'),'conditions'=>array('Orderstatus.id'=>$this->data['Signinghistory']['orderstatus_id'])));
				$odetails = $this->Order->find('first',array('recursive'=>-1,'fields'=>array('Order.id','Order.user_id','Order.pa_street_address','Order.pa_state','Order.pa_city','Order.pa_zipcode','Order.file','Order.date_signing','Order.first_name','Order.last_name','Order.sa_street_address','Order.sa_state','Order.sa_city','Order.sa_zipcode','Order.home_phone','Order.work_phone','Order.cell_phone', 'Order.addtnl_emails'),'conditions'=>array('Order.id'=>$this->data['Signinghistory']['order_id'])));
				$cdetails = $this->Client->find('first',array('fields'=>array('Client.id','Client.user_id','Client.first_name','Client.last_name','Client.email', 'Client.fees'),'conditions'=>array('Client.user_id'=>$odetails['Order']['user_id'])));
				$assgdetails = $this->Assignment->find('first',array('fields'=>array('Assignment.user_id'),'conditions'=>array('Assignment.order_id'=>$this->data['Signinghistory']['order_id'])));
				$ndetails = $this->Notary->find('first',array('fields'=>array('Notary.id','Notary.first_name','Notary.last_name','Notary.email'),'conditions'=>array('Notary.user_id'=>$assgdetails['Assignment']['user_id'])));
				
				/****************************************************
				*					START							*
				* 													*
			 	* 		SEND MAILS TO CLIENT, NOTARY, ADMIN			*
				*													*				 														* 													*
				****************************************************/
				
				if($this->data['Signinghistory']['orderstatus_id'] == '3') {
					$orderresult['salutation'] = $cdetails['Client']['first_name'];
					$orderresult['mailorderstatus'] = '3';
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$orderresult['Order'] = $odetails['Order'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'', 'subject'=>Configure::read('sitename').' - UNSCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'sendas'=>'html'));
						
					/* Send the notification mail to NOTARY */
					$orderresult['salutation'] = $ndetails['Notary']['first_name'];
					$orderresult['mailorderstatus'] = '31';
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$orderresult['Order'] = $odetails['Order'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'], 'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - UNSCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'sendas'=>'html'));
				
					/* Send the notification mail to ADDITIONAL EMAILS */
					if($odetails['Order']['addtnl_emails'] != '')
					{
						$orderresult['mailorderstatus'] = '3';	
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$odetails['Order']['addtnl_emails'], 'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - UNSCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'sendas'=>'html'));				
					}
				
				}
				
				if($this->data['Signinghistory']['orderstatus_id']=='4') {
					/* Send the notification mail to NOTARY */
					$orderresult['mailorderstatus'] = '41';
					$orderresult['salutation'] = $ndetails['Notary']['first_name'];
					$orderresult['Order'] = $odetails['Order'];
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$orderresult['scheduleddate'] = date(Configure::read('nsdate'));
					$orderresult['scheduledtime'] = $this->data['Signinghistory']['appointment_time'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));

					/* Send the notification mail to CLIENT */
					$orderresult['mailorderstatus'] = '42';
					$orderresult['salutation'] = $cdetails['Client']['first_name'];
					$orderresult['Order'] = $odetails['Order'];
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$orderresult['scheduleddate'] = date(Configure::read('nsdate'));
					$orderresult['scheduledtime'] = $this->data['Signinghistory']['appointment_time'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					
					/* Send the notification mail to ADDITIONAL EMAILS */
					if($odetails['Order']['addtnl_emails'] != '')
					{
						$orderresult['mailorderstatus'] = '42';
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$orderresult['scheduleddate'] = date(Configure::read('nsdate'));
						$orderresult['scheduledtime'] = $this->data['Signinghistory']['appointment_time'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$odetails['Order']['addtnl_emails'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));					
					}
				}
				
				if($this->data['Signinghistory']['orderstatus_id']=='5') {
					/* Send the notification mail to NOTARY */
					$orderresult['mailorderstatus'] = '51';
					$orderresult['salutation'] = $ndetails['Notary']['first_name'];
					$orderresult['Order'] = $odetails['Order'];
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - NO SIGN: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));

					/* Send the notification mail to CLIENT */
					$orderresult['mailorderstatus'] = '52';
					$orderresult['salutation'] = $cdetails['Client']['first_name'];
					$orderresult['Order'] = $odetails['Order'];
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - NO SIGN: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
				
					/* Send the notification mail to ADDITIONAL EMAILS */
					if($odetails['Order']['addtnl_emails'] != '')
					{
						$orderresult['mailorderstatus'] = '52';	
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$odetails['Order']['addtnl_emails'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - NO SIGN: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
				
					}
				}
				
				if($this->data['Signinghistory']['orderstatus_id']=='6') {
					/* Send the notification mail to CLIENT */
					$orderresult['mailorderstatus'] = '61';
					$orderresult['salutation'] = $cdetails['Client']['first_name'];
					$orderresult['Order'] = $odetails['Order'];
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - PENDING: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));

					/* Send the notification mail to NOTARY */
					$orderresult['mailorderstatus'] = '62';
					$orderresult['salutation'] = $ndetails['Notary']['first_name'];
					$orderresult['Order'] = $odetails['Order'];
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - PENDING: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					
					/* Send the notification mail to ADDITIONAL EMAILS */
					if($odetails['Order']['addtnl_emails'] != '')
					{
						$orderresult['mailorderstatus'] = '61';	
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$odetails['Order']['addtnl_emails'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - PENDING: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					
					}
				}
				
				if($this->data['Signinghistory']['orderstatus_id']=='7') {
					/* Send the notification mail to CLIENT */
					$orderresult['mailorderstatus'] = '71';
					$orderresult['salutation'] = $cdetails['Client']['first_name'];
					$orderresult['Order'] = $odetails['Order'];
					$orderresult['shipping'] = $this->_getShippingCarrier($this->data['Signinghistory']['track_shipping_info'], $this->data['Signinghistory']['tracking_no']);
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SIGNING COMPLETED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));

					/* Send the notification mail to NOTARY */
					$orderresult['mailorderstatus'] = '72';
					$orderresult['salutation'] = $ndetails['Notary']['first_name'];
					$orderresult['Order'] = $odetails['Order'];
					$orderresult['shipping'] = $this->_getShippingCarrier($this->data['Signinghistory']['track_shipping_info'], $this->data['Signinghistory']['tracking_no']);
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SIGNING COMPLETED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					
					/* Send the notification mail to ADDITIONAL EMAILS */
					if($odetails['Order']['addtnl_emails'] != '')
					{
						$orderresult['mailorderstatus'] = '71';	
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['shipping'] = $this->_getShippingCarrier($this->data['Signinghistory']['track_shipping_info'], $this->data['Signinghistory']['tracking_no']);
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$odetails['Order']['addtnl_emails'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SIGNING COMPLETED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
				
					}
				}
				
				if($this->data['Signinghistory']['orderstatus_id']=='10') {
					/* Send the notification mail to CLIENT */
					$orderresult['mailorderstatus'] = '101';
					$orderresult['salutation'] = $cdetails['Client']['first_name'];
					$orderresult['Order'] = $odetails['Order'];
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - CANCELED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));

					/* Send the notification mail to NOTARY */
					$orderresult['mailorderstatus'] = '102';
					$orderresult['salutation'] = $ndetails['Notary']['first_name'];
					$orderresult['Order'] = $odetails['Order'];
					$orderresult['notes'] = $this->data['Signinghistory']['notes'];
					$this->set('orderdata', $orderresult);
					$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - CANCELED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					
					/* Send the notification mail to ADDITIONAL EMAILS */
					if($odetails['Order']['addtnl_emails'] != '')
					{
						$orderresult['mailorderstatus'] = '101';	
						$orderresult['salutation'] = '';
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$odetails['Order']['addtnl_emails'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - CANCELED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					
					}
				}
				
				/****************************************************
				*					END								*
				* 													*
			 	* 		SEND MAILS TO CLIENT, NOTARY, ADMIN			*
				*													*				 														* 													*
				****************************************************/
				
				if($this->data['Signinghistory']['orderstatus_id'] == '7' &&  $this->data['Signinghistory']['tracking_no']<>"") {
			 		$this->data['Signinghistory']['orderstatus_id'] = 8;
					$this->data['Invoice']['order_id'] = $this->data['Signinghistory']['order_id'];
					$this->data['Invoice']['totalfees'] = $cdetails['Client']['fees'];
					$this->data['Invoice']['status'] = 0;
					unset($this->Invoice->validate['totalfees']);
					unset($this->Invoice->validate['invoicedoc']);
					$this->Invoice->create();
					$this->Invoice->save($this->data);
				 	//Update shipping info in orders table if status is completed
					if(isset($this->data['Signinghistory']['track_shipping_info']) and $this->data['Signinghistory']['track_shipping_info']<>"") {
						//update the orders table
						$data = array('Order'=>array('id'=>$this->data['Signinghistory']['order_id'],'track_shipping_info'=>$this->data['Signinghistory']['track_shipping_info'],'tracking_no'=>@$this->data['Signinghistory']['tracking_no'],'orderstatus_id'=>$this->data['Signinghistory']['orderstatus_id'], 'statusdate'=>date('Y-m-d H:i:s')));
						$this->Order->save($data, false, array('track_shipping_info', 'tracking_no', 'orderstatus_id', 'statusdate'));
					}
				} else {
					//update the orders table
					$data = array('Order'=>array('id'=>$this->data['Signinghistory']['order_id'], 'orderstatus_id'=>$this->data['Signinghistory']['orderstatus_id'], 'statusdate'=>date('Y-m-d H:i:s')));
					$this->Order->save($data, false, array('orderstatus_id', 'statusdate'));
				}
				
				$this->Session->setFlash('The status has been changed.', 'error', array('display'=>'success'));
				if(isset($this->data['Signinghistory']['tracking_no']) and $this->data['Signinghistory']['tracking_no']<>"") {
					$this->redirect(array('controller'=>'orders', 'action'=>'index'));
					exit;
				}
				$this->redirect(array('controller'=>'orders', 'action'=>'view', $this->data['Signinghistory']['order_id']));
				exit;
			} else {
				$this->Session->setFlash('Notes is mandatory, the status could not be changed. Please, try again.', 'error', array('display'=>'error'));
				$this->redirect(array('controller'=>'orders', 'action'=>'view', $this->data['Signinghistory']['order_id'], '#'=>'statusdiv'));
				exit;
			}
		}
	}
	
	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid signinghistory selected for deletion', 'error',array('display'=>'warning'));
			$this->redirect(array('controller'=>'orders','action'=>'view', @$this->params['pass']['1']));
		}
		if ($this->Signinghistory->delete($id)) {
			$this->Session->setFlash('Signing history deleted successfully', 'error',array('display'=>'success'));
			$this->redirect(array('controller'=>'orders','action'=>'view', @$this->params['pass']['1']));
		}
		$this->Session->setFlash('Signinghistory was not deleted', 'error',array('display'=>'error'));
		$this->redirect(array('controller'=>'orders','action'=>'view', @$this->params['pass']['1']));
	}
	
	function admin_search() {
		if(isset($_SESSION['search'])) unset($_SESSION['search']);
		$search_condition = array();
		$search_params = array();
		if(!empty($this->data)) {			
			if(isset($this->data['Signinghistory']['orderstatus_id']) and trim($this->data['Signinghistory']['orderstatus_id'])!='') {
			$search_condition[] = " Signinghistory.orderstatus_id ='" . $this->data['Signinghistory']['orderstatus_id'] ."'";
			$search_params['orderstatus_id'] = $this->data['Signinghistory']['orderstatus_id'];
			}
		}
		$_SESSION['search']['condition'] = $search_condition;
		$_SESSION['search']['params'] = $search_params;
		$this->redirect(array('controller'=>'Signinghistories','action'=>'index'));
	}
	
	function admin_clear () {
		/* Unset the session for new criteria */
		$this->__clearsearch();
	}
	
	function changestatus($id = null) {
		$this->layout=null;
		if(!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid order history selected.', 'error',array('display'=>'warning'));
			$this->redirect(array('controller'=>'orders', 'action'=>'view', $this->data['Signinghistory']['order_id'], 'admin'=>true));
    		exit;
		}
		if (!empty($this->data)) {
			$data = array('Signinghistory' => array('id' => $this->data['Signinghistory']['id'], 'notes' => $this->data['Signinghistory']['notes'], 'status' => $this->data['Signinghistory']['status']));
	       	if($this->Signinghistory->save($data, false, array('status','notes'))) {
	       		//mail is sent if status is made to Active and sent mail is checked
	       		if($this->data['Signinghistory']['mail']==1 and $this->data['Signinghistory']['status']==1) {
	       			$odetails = $this->Order->find('first',array('fields'=>array('Order.id','Order.user_id','Order.cell_phone','Order.pa_street_address','Order.pa_state','Order.pa_city','Order.pa_zipcode','Order.sa_state','Order.sa_city','Order.sa_zipcode','Order.file','Order.first_name','Order.last_name'),'conditions'=>array('Order.id'=>$this->data['Signinghistory']['order_id'])));
					$cdetails = $this->Client->find('first',array('fields'=>array('Client.id','Client.user_id','Client.first_name','Client.last_name','Client.email','Client.company'),'conditions'=>array('Client.user_id'=>$odetails['Order']['user_id'])));
					$assgdetails = $this->Assignment->find('first',array('fields'=>array('Assignment.user_id'),'conditions'=>array('Assignment.order_id'=>$this->data['Signinghistory']['order_id'])));
					$ndetails = $this->Notary->find('first',array('fields'=>array('Notary.id','Notary.first_name','Notary.last_name','Notary.email'),'conditions'=>array('Notary.user_id'=>$assgdetails['Assignment']['user_id'])));
					$currorderstatus = $this->Orderstatus->find('first',array('recursive'=>0,'fields' => array('Orderstatus.id','Orderstatus.status'),'conditions' => array('Orderstatus.id' => $this->data['Signinghistory']['orderstatus_id'])));
					
					/****************************************************
					*					START							*
					* 													*
				 	* 		SEND MAILS TO CLIENT, NOTARY, ADMIN			*
					*													*
					* 													*
					****************************************************/
					
					if($this->data['Signinghistory']['orderstatus_id'] == '3') {
						/* Send the notification mail to CLIENT */
						$orderresult['salutation'] = $cdetails['Client']['first_name'];
						$orderresult['mailorderstatus'] = '3';
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$orderresult['Order'] = $odetails['Order'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'', 'subject'=>Configure::read('sitename').' - UNSCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'sendas'=>'html'));
					}
					
					if($this->data['Signinghistory']['orderstatus_id']=='4') {
							/* Send the notification mail to NOTARY */
							$orderresult['mailorderstatus'] = '41';
							$orderresult['salutation'] = $ndetails['Notary']['first_name'];
							$orderresult['Order'] = $odetails['Order'];
							$orderresult['notes'] = $this->data['Signinghistory']['notes'];
							if(@$this->data['Signinghistory']['appointment_date']=='') {
								$orderresult['scheduleddate'] = date(Configure::read('nsdate'));
							} else {
								$orderresult['scheduleddate'] = $this->data['Signinghistory']['appointment_date'];
							}
							$orderresult['scheduledtime'] = $this->data['Signinghistory']['appointment_time'];
							$this->set('orderdata', $orderresult);
							$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
	
							/* Send the notification mail to CLIENT */
							$orderresult['mailorderstatus'] = '42';
							$orderresult['salutation'] = $cdetails['Client']['first_name'];
							$orderresult['Order'] = $odetails['Order'];
							$orderresult['notes'] = $this->data['Signinghistory']['notes'];
							if(@$this->data['Signinghistory']['appointment_date']=='') {
								$orderresult['scheduleddate'] = date(Configure::read('nsdate'));
							} else {
								$orderresult['scheduleddate'] = $this->data['Signinghistory']['appointment_date'];
							}
							$orderresult['scheduledtime'] = $this->data['Signinghistory']['appointment_time'];
							$this->set('orderdata', $orderresult);
							$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SCHEDULED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
					
					if($this->data['Signinghistory']['orderstatus_id']=='5') {
							/* Send the notification mail to CLIENT */
							$orderresult['mailorderstatus'] = '52';
							$orderresult['salutation'] = $cdetails['Client']['first_name'];
							$orderresult['Order'] = $odetails['Order'];
							$orderresult['notes'] = $this->data['Signinghistory']['notes'];
							$this->set('orderdata', $orderresult);
							$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - NO SIGN: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}

					if($this->data['Signinghistory']['orderstatus_id']=='6') {
						/* Send the notification mail to CLIENT */
						$orderresult['mailorderstatus'] = '61';
						$orderresult['salutation'] = $cdetails['Client']['first_name'];
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - PENDING: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
	
						/* Send the notification mail to NOTARY */
						$orderresult['mailorderstatus'] = '62';
						$orderresult['salutation'] = $ndetails['Notary']['first_name'];
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - PENDING: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}

					if($this->data['Signinghistory']['orderstatus_id']=='7') {
						/* Send the notification mail to CLIENT */
						$orderresult['mailorderstatus'] = '71';
						$orderresult['salutation'] = $cdetails['Client']['first_name'];
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['shipping'] = $this->_getShippingCarrier($this->data['Signinghistory']['track_shipping_info'], $this->data['Signinghistory']['tracking_no']);
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SIGNING COMPLETED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));

						/* Send the notification mail to NOTARY */
						$orderresult['mailorderstatus'] = '72';
						$orderresult['salutation'] = $ndetails['Notary']['first_name'];
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['shipping'] = $this->_getShippingCarrier($this->data['Signinghistory']['track_shipping_info'], $this->data['Signinghistory']['tracking_no']);
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - SIGNING COMPLETED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
					
					if($this->data['Signinghistory']['orderstatus_id']=='10') {
						/* Send the notification mail to CLIENT */
						$orderresult['mailorderstatus'] = '101';
						$orderresult['salutation'] = $cdetails['Client']['first_name'];
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$cdetails['Client']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - CANCELED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
	
						/* Send the notification mail to NOTARY */
						$orderresult['mailorderstatus'] = '102';
						$orderresult['salutation'] = $ndetails['Notary']['first_name'];
						$orderresult['Order'] = $odetails['Order'];
						$orderresult['notes'] = $this->data['Signinghistory']['notes'];
						$this->set('orderdata', $orderresult);
						$this->_sendNewMail(array('to'=>$ndetails['Notary']['email'],'cc'=>'','bcc'=>'','subject'=>Configure::read('sitename').' - CANCELED: '.$odetails['Order']['first_name']." ".$odetails['Order']['last_name'].' in '.$odetails['Order']['sa_city'].', '.$odetails['Order']['sa_state'].' '.$odetails['Order']['sa_zipcode'],'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
					}
					
					/****************************************************
					*					END								*
					* 													*
				 	* 		SEND MAILS TO CLIENT, NOTARY, ADMIN			*
					*													*				 														* 													*
					****************************************************/
	       		}
	       		
	       		if($this->data['Signinghistory']['orderstatus_id'] == '7' &&  $this->data['Signinghistory']['tracking_no']<>"") {
			 		$this->data['Signinghistory']['orderstatus_id'] = 8;
					$this->data['Invoice']['order_id'] = $this->data['Signinghistory']['order_id'];
					$this->data['Invoice']['totalfees'] = $cdetails['Client']['fees'];
					$this->data['Invoice']['status'] = 0;
					unset($this->Invoice->validate['totalfees']);
					unset($this->Invoice->validate['invoicedoc']);
					$this->Invoice->create();
					$this->Invoice->save($this->data);
				 	//Update shipping info in orders table if status is completed
					if(isset($this->data['Signinghistory']['track_shipping_info']) and $this->data['Signinghistory']['track_shipping_info']<>"") {
						//update the orders table
						$data = array('Order'=>array('id'=>$this->data['Signinghistory']['order_id'],'track_shipping_info'=>$this->data['Signinghistory']['track_shipping_info'],'tracking_no'=>@$this->data['Signinghistory']['tracking_no'],'orderstatus_id'=>$this->data['Signinghistory']['orderstatus_id'], 'statusdate'=>date('Y-m-d H:i:s')));
						$this->Order->save($data, false, array('track_shipping_info', 'tracking_no', 'orderstatus_id', 'statusdate'));
					}
				} else {
					//update the orders table
					$data = array('Order'=>array('id'=>$this->data['Signinghistory']['order_id'], 'orderstatus_id'=>$this->data['Signinghistory']['orderstatus_id'], 'statusdate'=>date('Y-m-d H:i:s')));
					$this->Order->save($data, false, array('orderstatus_id', 'statusdate'));
				}
       			$this->Session->setFlash('Order history updated successfully.', 'error',array('display'=>'success'));
		    	$this->redirect(array('controller'=>'orders', 'action'=>'view', $this->data['Signinghistory']['order_id'], 'admin'=>true));
      			exit;
	  		} else {
	  			$this->Session->setFlash('The order history could not be updated. Please, try again.','error',array('display'=>'warning'));
		     	$this->redirect(array('controller'=>'orders', 'action'=>'view', $this->data['Signinghistory']['order_id'], 'admin'=>true));
		     	exit;
			}
		}
		if(empty($this->data)) {
			$this->data = $this->Signinghistory->read(null, $id);
		}
		$this->set('statusOptions', $this->_statusOptions());
	}
	
	function admin_reactivate($id = null) {
		$admin_data = $this->Session->read('WBSWAdmin');
		$admin_id = $admin_data['Admin']['id'];
		$this->layout=null;
		if (!$id) {
			$this->Session->setFlash('Invalid order.','error',array('display'=>'error'));
			$this->redirect(array('controller'=>'orders','action'=>'view', $id));
			exit();
		} else {
			$status ='1';
			$data = array('Order'=>array('id'=>$id,'orderstatus_id'=>$status, 'statusdate'=>date('Y-m-d H:i:s')));
			$this->Order->save($data, false, array('orderstatus_id', 'statusdate'));
			// since admin changes status
			$this->data['Signinghistory']['added_by'] = 'A';
			$this->data['Signinghistory']['user_id'] = $admin_id;
			$this->data['Signinghistory']['order_id'] = $id;
			/*	If it is added from Admin, there is no need for approval 'Approved'	*/
			$this->data['Signinghistory']['orderstatus_id'] = '1';
			unset($this->Signinghistory->validate['notes']);
			unset($this->Signinghistory->validate['appointment_time']);
			$clientdetails = $this->ClientFee->find('all', array('fields'=>array('ClientFee.order_id', 'ClientFee.fee_type', 'ClientFee.fees'),'contain'=>array('Client'),'conditions'=>array('ClientFee.order_id'=>$id)));
			$notarydetails = $this->NotaryFee->find('all', array('fields'=>array('NotaryFee.order_id', 'NotaryFee.fee_type', 'NotaryFee.fees'),'contain'=>array('Notary'),'conditions'=>array('NotaryFee.order_id'=>$id)));
			if((!empty($clientdetails)) || (!empty($notarydetails))) {
				$this->data['reactivateFees']['order_id'] = $id;
				$det = $this->reactivateFees->save($this->data);	
			}
			$rid = $this->reactivateFees->id;
			if(!empty($clientdetails)) {
		   		foreach($clientdetails as $key => $val) {
		  			$k=++$key;
			  		$data = array('reactivateFees' => array('id' => $rid, 'client_fee'.$k => $val['ClientFee']['fees']));
			       	$this->reactivateFees->save( $data, false, array('client_fee'.$k) );
		  	 	}
			}
			if(!empty($notarydetails)) {
		   		foreach($notarydetails as $keys => $vals) {
					$j=++$keys;  			
				 	$datas = array('reactivateFees' => array('id' => $rid, 'notary_fee'.$j => $vals['NotaryFee']['fees']));
					$this->reactivateFees->save( $datas, false, array('notary_fee'.$j) );
			   	}
			}
			$save = $this->Signinghistory->save($this->data); 
			if($save) {
				$this->Session->setFlash('The order has been reactivated','error',array('display'=>'success'));
				$this->redirect(array('controller'=>'orders','action'=>'view', $id));
				exit();
			} else{
				$this->Session->setFlash('The order could not be reactivated. Please, try again.','error',array('display'=>'error'));
				$this->redirect(array('controller'=>'orders','action'=>'view', $id));
				exit();
			}
		}
	}
	
	function _getShippingCarrier($shipinfo, $trackingno) {
		if ($shipinfo=='F') {
			$trackingno = 'Tracking # ['.$this->_shipoptions($shipinfo).'] <a href="'.Configure::read('fedextracking').$trackingno.'" target="_blank">'. $trackingno .'</a>';
		} elseif ($shipinfo=='U') {
			$trackingno = 'Tracking # ['.$this->_shipoptions($shipinfo).'] <a href="'.Configure::read('upstracking').$trackingno.'" target="_blank">'. $trackingno .'</a>';
		} elseif ($shipinfo=='D') {
			$trackingno = 'Tracking # ['.$this->_shipoptions($shipinfo).'] <a href="'.Configure::read('dhltracking').'" target="_blank">'. $trackingno .'</a>';
		} elseif ($shipinfo=='G') {
			$trackingno = 'Tracking # ['.$this->_shipoptions($shipinfo).'] <a href="'.Configure::read('gsotracking').'" target="_blank">'. $trackingno .'</a>';
		} elseif ($shipinfo=='E') {
			$trackingno = 'Tracking # ['.$this->_shipoptions($shipinfo).'] <a href="'.Configure::read('overniteexpress').'" target="_blank">'. $trackingno .'</a>';
		} else {
			$trackingno = 'Tracking # ['.$this->_shipoptions($shipinfo).'] '.$trackingno;
		}
		return $trackingno;
	}
}
?>
