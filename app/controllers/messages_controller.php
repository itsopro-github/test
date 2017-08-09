<?php
class MessagesController extends AppController {

	var $name = 'Messages';

	function index() {
		$user_data = $this->_checkPermission();
		$this->paginate = array('fields'=>array('Message.id','Message.subject','Message.notified','Message.created'),'recursive'=>-1,'limit'=>'10','order'=>'Message.created DESC','conditions' => array('Message.trashed'=>'0000-00-00 00:00:00','Message.to_id' =>$user_data['User']['id']));
		$this->set('messages', $this->paginate());
	}

	/* formerly view	*/
	function details($id = null) {
		$user_data = $this->_checkPermission();
		if (!$id) {
			$this->Session->setFlash('Invalid message', 'error',array('display'=>'warning'));
			$this->redirect(array('action' => 'index'));
			exit();
		}
		$message = $this->Message->find('first',array('fields'=>array('Message.id','Message.subject','Message.body','Message.notified','Message.created'),'recursive'=>-1,'conditions'=>array('Message.id'=>$id,'Message.trashed'=>'0000-00-00 00:00:00','Message.to_id'=>$user_data['User']['id'])));
		/* restrict the user from reading other's messages	*/
		if (!$message) {
			$this->Session->setFlash('The message details cannot be displayed', 'error',array('display'=>'warning'));
			$this->redirect(array('action' => 'index'));
			exit();
		}
		/* mark the message as read	*/
		$this->Message->id = $id;
		$this->Message->saveField('notified',date('Y-m-d H:i:s'));
		$this->set('message',$message);
	}

	function add() {
		$user_data = $this->_checkPermission();
		if (!empty($this->data)) {
			$this->data['Message']['user_id'] = $user_data['User']['id'];
			$this->data['Message']['to_id'] = '1';//Notary user can send message only to Administrator
			$this->data['Message']['ipaddress'] = $_SERVER['REMOTE_ADDR'];
			$this->Message->create();
			if ($this->Message->save($this->data)) {
				$this->Session->setFlash('The message has been sent','error',array('display'=>'success'));
				$this->redirect(array('action' => 'index','type'=>'notaries'));
				exit();
			} else {
				$this->Session->setFlash('The message could not be sent. Please, try again.','error',array('display'=>'error'));
			}
		}
	}

	function delete($id = null) {
		$user_data = $this->_checkPermission();
		if (!$id) {
			$this->Session->setFlash('Invalid id for message','error',array('display'=>'warning'));
			$this->redirect(array('action'=>'index'));
			exit();
		}
		if ($this->Message->delete($id)) {
			$this->Session->setFlash('Message trashed', 'error',array('display'=>'success'));
			$this->redirect(array('action'=>'index'));
			exit();
		}
		$this->Session->setFlash('Message was not trashed', 'error',array('display'=>'error'));
		$this->redirect(array('action' => 'index'));
		exit();
	}
	
	function admin_index() {
	 	$admin_data = $this->Session->read('WBSWAdmin');
		$admin_id = $admin_data['Admin']['id'];
		/*for search*/
		if(!empty($this->params['named']['s'])) {
			if(isset($_SESSION['search'])) unset($_SESSION['search']);
			
			if(!empty($this->params['trashed']))
				$this->redirect(array('action'=>'index','trashed'=>$this->params['trashed']));
			elseif(!empty($this->params['sent']))
				$this->redirect(array('action'=>'index','sent'=>$this->params['sent']));
			else
				$this->redirect(array('action'=>'index'));
				
			exit();
		}
		
		if(isset($_SESSION['search']['condition']) and !empty($_SESSION['search']['condition'])) {
			$condition[] = array(implode(' AND ', @$_SESSION['search']['condition']));
		}
		/* listing the inbox,sent and trashed msgs		*/
		if(!empty($this->params['trashed'])) {
			$condition[] = array('Message.trashed <>'=>'0000-00-00 00:00:00');
		} elseif(!empty($this->params['sent'])) {
			$condition[] = array('Message.trashed'=>'0000-00-00 00:00:00','Message.user_id'=>'1');
		} else {
			$condition[] = array('Message.trashed'=>'0000-00-00 00:00:00','Message.user_id <>'=>'1');
		}

		$this->paginate = array('conditions'=>@$condition,'recursive'=>0,'order'=>'Message.created DESC','fields'=>array('Message.id','Message.user_id','Message.to_id','Message.subject','Message.notified','Message.created','Message.trashed'));
		/*for search*/
		
		$this->set('messages', $this->paginate());				
		$this->set('adminfo', $this->Session->read('WBSWAdmin'));		
  $users =	$this->Message->User->find('list', array('recursive'=>0,'fields' => array('Notary.user_id','Notary.first_name'),'conditions' => array('User.id <>' => $admin_id,'User.type'=>'N')));
		$users[$this->Session->read('WBSWAdmin.Admin.id')] =$this->Session->read('WBSWAdmin.Admin.name');    
	 	$this->set('useroptions',$users);	
	}

	function admin_view($id = null) {
	 	$admin_data = $this->Session->read('WBSWAdmin');
		$admin_id = $admin_data['Admin']['id'];
		if (!$id) {
			$this->Session->setFlash(__('Invalid message', true));
			$this->redirect(array('action' => 'index'));
			exit();
		}	
		
		$records =$this->Message->read(null, $id);	
		$this->set('message', $records);				
		
		if ($records['Message']['to_id']==$admin_id){
 		 	$this->Message->id = $id;
 		 	$this->Message->saveField('notified',date('Y-m-d H:i:s'));
		}
		$this->set('adminfo', $admin_data);		
	}

	function admin_add() {
		$admin_data = $this->Session->read('WBSWAdmin');
		$admin_id = $admin_data['Admin']['id'];
		if (!empty($this->data)) {
			$this->data['Message']['user_id'] = $admin_id;
			$this->data['Message']['ipaddress'] = $_SERVER['REMOTE_ADDR'];
			$this->Message->create();			
			if ($this->Message->save($this->data)) {
				$this->Session->setFlash('The message has been sent','error',array('display'=>'success'));
				$this->redirect(array('action'=>'index'));
				exit();
			} else {
				$this->Session->setFlash('The message could not be sent. Please, try again.','error',array('display'=>'error'));
				$this->set('error_messages',$this->Message->validationErrors);
			}
		}
		$from = $admin_data['Admin']['name'];
		$users = $this->Message->User->find('multiplelist', array('recursive'=>0,'conditions'=>array('User.id <>'=>$admin_id,'User.type'=>'N'),'fields'=>array('Notary.user_id','Notary.first_name'),'separator'=>' '));
		$this->set('fromname',$from);
		$this->set('toidoptions',$users);
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid message selected for deletion', 'error',array('display'=>'warning'));
			$this->redirect(array('action'=>'index'));
			exit();
		}
		$this->Message->id = $id;
		if ($this->Message->saveField('trashed',date('Y-m-d H:i:s'))) {
			$this->Session->setFlash('Message sent to trash successfully', 'error',array('display'=>'success'));
			$this->redirect(array('action'=>'index'));
			exit();
		}
		$this->Session->setFlash('Message was not sent to trash', 'error',array('display'=>'error'));
		$this->redirect(array('action' => 'index'));
		exit();
	}
	
	function admin_search () {
		/* Unset the session for new search */
		if(isset($_SESSION['search'])) unset($_SESSION['search']);
		$search_condition = array();
		$search_params = array();
		
		if(!empty($this->data)) {
			if(isset($this->data['Message']['to_id']) and trim($this->data['Message']['to_id'])!='') {
				$search_condition[] = " Message.to_id = " . $this->data['Message']['to_id'] . "";
				$search_params['to_id'] = $this->data['Message']['to_id'];
			}
			if(isset($this->data['Message']['subject']) and trim($this->data['Message']['subject'])!='') {
				$search_condition[] = " Message.subject LIKE '%" . $this->data['Message']['subject'] . "%'";
				$search_params['subject'] = $this->data['Message']['subject'];
			}
		}
		$_SESSION['search']['condition'] = $search_condition;
		$_SESSION['search']['params'] = $search_params;
		if(!empty($this->params['named']['sent']) or isset($this->data['Message']['to_id'])!='')
			$this->redirect(array('action'=>'index','sent'=>'sent'));
		elseif(!empty($this->params['named']['trashed']))
			$this->redirect(array('action'=>'index','trashed'=>$this->params['named']['trashed']));
		else 
		 	$this->redirect(array('action'=>'index'));
		
		exit();
	}
	
	function admin_clear () {
		/* Clear the session for new search */
		$this->__clearsearch();
	}
}
?>