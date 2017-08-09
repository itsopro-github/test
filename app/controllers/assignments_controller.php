<?php
class AssignmentsController extends AppController {

	var $name = 'Assignments';

	var $uses = array('Assignment','Orderdetail','Notary','Client','Order','Signinghistory');

	function admin_index() {
		$this->Assignment->recursive = 0;
		$this->set('assignments', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid assignment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('assignment', $this->Assignment->read(null, $id));
	}

	function admin_add() {
		$admin_data = $this->Session->read('WBSWAdmin');
		$admin_id = $admin_data['Admin']['id'];
		if (!empty($this->data)) {
			$orderid = $this->data['Assignment']['order_id'];
			$notaryid = $this->data['Assignment']['user_id'];
			$clientid = $this->data['Assignment']['client_id'];
			$assigned_users = $this->Assignment->find('first', array('contain'=>array('User'=>array('Notary'=>array('fields'=>array('Notary.id','Notary.user_id','Notary.email','Notary.cell_phone','Notary.fees','Notary.first_name','Notary.last_name')))),'conditions'=>array('Assignment.order_id'=>$orderid,'Assignment.status'=>'A')));
			if($assigned_users['Assignment']['id']<>"") {
				$data = array('Assignment'=>array('id'=>$assigned_users['Assignment']['id'],'status'=>'I'));
				$this->Assignment->save($data, false, array('status'));
			}
			
			$this->Signinghistory->create();
			//Since admin changes status
			$this->data['Signinghistory']['added_by'] = 'A';
			$this->data['Signinghistory']['user_id'] = $admin_id;
			/*	If it is added from Admin, there is no need for approval 'Approved'	*/
			$this->data['Signinghistory']['status'] = '1';
			$this->data['Signinghistory']['notes'] = $this->data['Assignment']['details'];
			$this->data['Signinghistory']['orderstatus_id'] = 2;
			$this->data['Signinghistory']['order_id'] = $orderid;
			unset($this->Signinghistory->validate['appointment_time']);	
			unset($this->Signinghistory->validate['notes']);	
			$this->Signinghistory->save($this->data);
			$this->data['Assignment']['signinghistory_id'] = $this->Signinghistory->id;
			$order = $this->Order->find('first',array('conditions'=>array('Order.id'=>$orderid), 'fields'=>array('first_name','last_name','home_phone','work_phone','cell_phone','sa_street_address','sa_state','sa_city','sa_zipcode','pa_street_address','pa_state','pa_city','pa_zipcode','file','attended_by','date_signing', 'addtnl_emails')));
			$notary = $this->Notary->find('first',array('conditions'=>array('Notary.user_id'=>$notaryid), 'fields'=>array('first_name','last_name','email','cell_phone','day_phone','evening_phone','dd_address','dd_city','dd_state','dd_zip')));
			$client = $this->Client->find('first',array('conditions'=>array('User.id'=>$clientid),'fields'=>array('first_name','last_name','email','company')));

			//Update the Order status to 'Assigned'
			$this->Assignment->Order->id = $orderid;
			$this->Assignment->Order->saveField('orderstatus_id', 2);
			$this->Assignment->Order->saveField('statusdate', date('Y-m-d H:i:s'));
			$this->Assignment->create();
			//Insert into assignment table
			if ($this->Assignment->save($this->data)) {
				/* Send the notification mail to CLIENT */
				$clientresult['mailorderstatus'] = '20';
				$clientresult['salutation'] = $client['Client']['first_name'];
				$clientresult['notes'] = $this->data['Assignment']['details'];
				$clientresult['notary'] = $notary;
				$this->set('orderdata', $clientresult);
				$this->_sendNewMail(array('to'=>$client['Client']['email'], 'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - ASSIGNED: '.$order['Order']['first_name'].' '.$order['Order']['last_name'].' in '.$order['Order']['sa_city'].', '.$order['Order']['sa_state'].' '.$order['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));

				/* Send the notification mail to NOTARY */
				$notarydata['mailorderstatus'] = '21';
				$notarydata['salutation'] = $notary['Notary']['first_name'];
				$notarydata['client'] = $client;
				$notarydata['Order'] = $order['Order'];
				$notarydata['notes'] = $this->data['Assignment']['details'];
				$this->set('orderdata', $notarydata);
				$this->_sendNewMail(array('to'=>$notary['Notary']['email'], 'cc'=>'','bcc'=>'', 'subject'=>Configure::read('sitename').' - ASSIGNED: '.$order['Order']['first_name'].' '.$order['Order']['last_name'].' in '.$order['Order']['sa_city'].', '.$order['Order']['sa_state'].' '.$order['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'orderstatus', 'sendas'=>'html'));
				
				/* Send the notification mail to ADDITIONAL EMAILS */
				if($order['Order']['addtnl_emails'] != '')
				{
					$clientresult['mailorderstatus'] = '20';
					$clientresult['salutation'] =  '';
					$clientresult['notes'] = $this->data['Assignment']['details'];
					$clientresult['notary'] = $notary;
					$this->set('orderdata', $clientresult);
					$this->_sendNewMail(array('to'=>$order['Order']['addtnl_emails'], 'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - ASSIGNED: '.$order['Order']['first_name'].' '.$order['Order']['last_name'].' in '.$order['Order']['sa_city'].', '.$order['Order']['sa_state'].' '.$order['Order']['sa_zipcode'], 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'),'layout'=>'email','template'=>'orderstatus','sendas'=>'html'));
				}
				
				$this->Session->setFlash('The new request is successfully assigned to '.$notary['Notary']['first_name']." ".$notary['Notary']['last_name'], 'error', array('display'=>'success'));
				$this->redirect(array('controller'=>'orders','action'=>'view',$orderid.'/yes'));
				exit;
			} else {
				$this->set('error_messages', $this->Assignment->validationErrors);
				$this->Session->setFlash('Unable to assign a notary, Please try again.','error',array('display'=>'error'));
				$this->redirect(array('controller'=>'orders','action'=>'view',$orderid));
				exit;
			}
		}
	}

}
?>