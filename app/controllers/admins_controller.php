<?php
class AdminsController extends AppController {

	var $name = 'Admins';
	var $uses = array('Admin','Order','Contentpage');

	/**
	* Before admin Controller Action
	*/
	function beforeFilter() {
		//parent::beforeFilter();
	}
	
	/**********************
	* Logs in a Admin User
	***********************/
	function admin_login() {
		$this->beforeFilter();
		$this->layout = 'adminlogin';
		// redirect admin if already logged in
		if($this->Session->check('WBSWAdmin')) {
			$this->Session->delete('WBSWAdmin');
		}
		if(!empty($this->data)) {
			// set the form data to enable validation
			$this->Admin->set($this->data);
			// check if the data validates
			$result = $this->check_admin_data($this->data);
			if($result !== false ) {
				$result['Admin']['logintime'] = date('Y-m-d H:i:s');
				$this->Session->write('WBSWAdmin',$result);
				$this->Session->setFlash('You have successfully logged in','error',array('display'=>'success'));
				$this->redirect(array('controller'=>'admins','action'=>'dashboard'));
			} else {
				$this->Session->setFlash('Either your username or password is incorrect.', 'error', array('display'=>'error'));
			}
		}
	}

	/***********************
	* Checks Admin data is valid before allowing access to system
	* @param array $data
	* @return boolean|array
	***********************/
	function check_admin_data($data) {
		// init
		$return = FALSE;
		// find admin with passed username
		$conditions = array('Admin.username'=>$data['Admin']['username'],'Admin.status'=>'1');
		$admin = $this->Admin->find('first',array('conditions'=>$conditions));
		// not found
		if(!empty($admin)) {
			$salt = Configure::read('Security.salt');
			// check password
			if($admin['Admin']['password'] == md5($data['Admin']['password'].$salt)) {
				$return = $admin;
			}
		}
		return $return;
	}
	
	/********************
	* Logs out a Admin User
	**********************/
	function admin_logout() {
		$admin_data = $this->Session->read('WBSWAdmin');
		if($admin_data) {
			$this->Admin->id = $admin_data['Admin']['id'];
			$this->Admin->saveField('lastlogin',$admin_data['Admin']['logintime']);
			$this->Session->delete('WBSWAdmin');
			$this->Session->setFlash('You have successfully logged out','error', array('display'=>'info'));
		}
		$this->redirect(array('action'=>'login'));
		exit;
	}
	
	function admin_settings($id=null) {
		parent::beforeFilter();
		$admin_data = $this->Session->read('WBSWAdmin');
		if (!empty($this->data)) {
			$this->data['Admin']['id'] = $admin_data['Admin']['id'];
			$salt = Configure::read('Security.salt');
        	$this->data['Admin']['currentpassword'] = md5($this->data['Admin']['currentpassword'].$salt);
			if($admin_data['Admin']['password'] == $this->data['Admin']['currentpassword']) {
				unset($this->Admin->validate['type']);
			
				if ($this->Admin->save($this->data)) {
					$this->Session->setFlash('The Settings has been changed successfully.','error',array('display'=>'success'));
					$this->redirect(array('action'=>'settings'));
				} else {
					$this->set('error_messages', $this->Admin->validationErrors);
					$this->Session->setFlash('The Settings could not be saved. Please, try again.','error',array('display'=>'error'));
				}
			} else {
				$this->set('error_messages', array('mismatch'=>'Please enter the current password'));
				$this->Session->setFlash('The Settings could not be saved. Please, try again.','error',array('display'=>'error'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Admin->read(null, $admin_data['Admin']['id']);
		}
	}
	
	function admin_edit($id=null) {
		$this->_checkAdmin('S');
		parent::beforeFilter();
		if ((!$id && empty($this->data)) or $id == 1) {
			$this->Session->setFlash('Invalid user selected for modification.', 'error',array('display'=>'warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			unset($this->Admin->validate['password']);
			unset($this->Admin->validate['confirmpassword']);
			if(isset($this->data['Admin']['password']) && $this->data['Admin']['password']<>""){
				$salt = Configure::read('Security.salt');
				$this->data['Admin']['password'] = md5($this->data['Admin']['password'].$salt);
			}
			if ($this->Admin->save($this->data)) {
				$this->Session->setFlash('The user has been saved', 'error',array('display'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->set('error_messages', $this->Admin->validationErrors);
				$this->Session->setFlash('The user could not be saved. Please, try again.', 'error',array('display'=>'error'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Admin->read(null, $id);
		}
		$this->set('statusoptions',$this->_statusOptions());
		$this->set('admintypeoptions',$this->_admintypeOptions());
	}

	function admin_add() {
		
		parent::beforeFilter();
		$this->_checkAdmin('S');
		if (!empty($this->data)) {
			
				$validatuname = (@$this->data['Admin']['username'] != '') ? @$this->data['Admin']['username'] : @$this->data['Admin']['username'];	
				if(!empty($validatuname)) {
				$user_exists = $this->Admin->find('count',array('conditions'=>array('Admin.username'=>$validatuname)));	
				
				if ($user_exists) {
					$this->Session->setFlash('The username  already exist.','error',array('display'=>'error'));
					$this->redirect(array('action' => 'index'));
					exit();
				}
			}
			
			$this->Admin->create();
			if ($this->Admin->save($this->data)) {
				$this->Session->setFlash('The user has been saved','error',array('display'=>'success'));
				$this->redirect(array('action'=>'index'));
				//exit;
			} else {
				$this->set('error_messages', $this->Admin->validationErrors);
				$this->Session->setFlash('The user could not be saved. Please, try again.','error',array('display'=>'error'));
			}
		}
		$this->set('statusoptions',$this->_statusOptions());
		$this->set('admintypeoptions',$this->_admintypeOptions());
	}
	
	function admin_delete($id = null) {
		$this->_checkAdmin('S');
		if (!$id) {
			$this->Session->setFlash('Invalid user selected for deletion', 'error',array('display'=>'warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Admin->delete($id)) {
			$this->Session->setFlash('User deleted successfully', 'error',array('display'=>'success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('User was not deleted', 'error',array('display'=>'error'));
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_index() {
		$this->_checkAdmin('S');
		parent::beforeFilter();
		if(!empty($this->params['named']['s'])) {
			if(isset($_SESSION['search'])) unset($_SESSION['search']);
			$this->redirect(array('action' => 'index'));
		}
		$condition[] = array('Admin.type != '=>'S');
		if(isset($_SESSION['search']['condition']) and !empty($_SESSION['search']['condition'])) {
			$condition = array(implode(' AND ', @$_SESSION['search']['condition']));
		}
		$this->paginate = array('conditions'=>@$condition,'recursive'=>0,'order'=>'Admin.created DESC','fields'=>array('Admin.id','Admin.name','Admin.username','Admin.status','Admin.type','Admin.created'));
		$this->set('admin', $this->paginate());
		$this->set('statusoptions',$this->_statusOptions());
		$this->set('admintypeoptions',$this->_admintypeOptions());
	}
	
	function admin_dashboard(){
		$this->_checkAdmin();
		$this->set('loggedindata', $this->Session->read('WBSWAdmin'));
		$this->layout = 'admin';
		$ordercount = $this->Order->find('all', array('recursive'=>-1, 'conditions'=>array('Order.orderstatus_id'=>'1', 'TIMESTAMPDIFF(MINUTE,statusdate,now()) <='=>'60'), 'fields'=>'TIMESTAMPDIFF(MINUTE,statusdate,now()) AS timeleft'));
		$this->set('ordercount', $ordercount);

		$this->loadModel('Msgsetting');
		$notariescnt = $this->Msgsetting->find('first', array('order'=>'Msgsetting.created DESC'));
		$this->set('notariescnt', $notariescnt);
	}
	
	function admin_notary() {
		$this->_checkAdmin('S');
		$admindata = $this->Session->read('WBSWAdmin');
		$this->layout = null;
		if($this->data) {
			$this->loadModel('Msgsetting');
			$this->data['Msgsetting']['notarycount'] = $this->data['Admin']['notarycount'];
			$this->data['Msgsetting']['lastupdated'] = $admindata['Admin']['name'];
			$this->Msgsetting->save($this->data);
			$this->Session->setFlash('The number is updated successfully.','error', array('display'=>'success'));
			$this->redirect(array('action'=>'dashboard'));
			exit;
		}
	}
	
	function admin_search() {
		$this->_checkAdmin('S');
		if(isset($_SESSION['search'])) unset($_SESSION['search']);
		$search_condition = array();
		$search_params = array();
       
		if(!empty($this->data)) {			
			if(isset($this->data['admins']['username']) and trim($this->data['admins']['username'])!='') {
				$search_condition[] = " Admin.username LIKE '%" . $this->data['admins']['username'] . "%' ";
				$search_params['username'] = $this->data['admins']['username'];
			}
			if(isset($this->data['admins']['name']) and trim($this->data['admins']['name'])!='') {
				$search_condition[] = " Admin.name LIKE '%" . $this->data['admins']['name'] . "%' ";
				$search_params['name'] = $this->data['admins']['name'];
			}
			if(isset($this->data['admins']['type']) and trim($this->data['admins']['type'])!='') {
				$search_condition[] = " Admin.type ='" . $this->data['admins']['type'] ."'";
				$search_params['type'] = $this->data['admins']['type'];
			}
			if(isset($this->data['admins']['status']) and trim($this->data['admins']['status'])!='') {
				$search_condition[] = " Admin.status ='" . $this->data['admins']['status'] ."'";
				$search_params['status'] = $this->data['admins']['status'];
			}
		}
		$_SESSION['search']['condition'] = $search_condition;
		$_SESSION['search']['params'] = $search_params;
		$this->redirect(array('action'=>'index'));
	}
	
	function admin_clear () {
		$this->_checkAdmin('S');
		/* Unset the session for new criteria */
		$this->__clearsearch();
	}
	
	function admin_help () {
		$this->_checkAdmin();
		$this->layout = 'admin';
		$this->set('helptext', $this->Contentpage->find('first', array('fields'=>array('Contentpage.content'),'conditions'=>array('Contentpage.controllername'=>'contentpages', 'Contentpage.actionname'=>'help'))));
	}

}
?>