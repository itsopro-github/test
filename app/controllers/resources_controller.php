<?php
class ResourcesController extends AppController {

	var $name = 'Resources';
	var $components = array('Upload');

	/********************************
	*	Only permission to Notaries
	*********************************/
	function index() {
		$userdata = $this->_checkPermission();
		if ($userdata['User']['type']=='C') {
			$this->Session->setFlash('You are not allowed to view this page', 'error',array('display'=>'warning'));
			$this->redirect(array('controller'=>'users','action'=>'myaccount','type'=>'clients'));
		}
		$resources = $this->Resource->find('all', array('fields'=>array('Resource.id','Resource.title','Resource.resourcefile','Resource.description','Resource.category','Resource.helplink'),'recursive'=>-1,'order'=>array('Resource.category'),'conditions'=>array('Resource.status'=>'1')));
		$this->set('resources', $resources);
		$this->set('resourcescategory',$this->resourceCategory());
		$this->loadModel('Contentpage');
		$contents = $this->Contentpage->find('first', array('callbacks'=>false,'fields'=>array('Contentpage.pagetitle','Contentpage.metakey','Contentpage.metadesc','Contentpage.content'),'conditions'=>array('Contentpage.status'=>'1','Contentpage.id'=>35)));
		$this->set('contentpage', $contents);
	}

	function admin_index() {
		if(!empty($this->params['named']['s'])) {
			if(isset($_SESSION['search'])) unset($_SESSION['search']);
			$this->redirect(array('action' => 'index'));
		}
		if(isset($_SESSION['search']['condition']) and !empty($_SESSION['search']['condition'])) {
			$condition = array(implode(' AND ', @$_SESSION['search']['condition']));
		}
		$this->paginate = array('conditions'=>@$condition,'recursive'=>0,'order'=>'Resource.created DESC','fields'=>array('Resource.id','Resource.title','Resource.addedby','Resource.category','Resource.status','Resource.created','Resource.helplink'));
		$this->set('resources', $this->paginate());
		$this->set('statusoptions',$this->_statusOptions());
		$this->set('resourcescategory',$this->resourceCategory());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid resource has been selected', 'error',array('display'=>'warning'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('resource', $this->Resource->read(null, $id));
		$this->set('statusoptions',$this->_statusOptions());
		$this->set('resourcescategory',$this->resourceCategory());

	}

	function admin_add() {
		if (!empty($this->data)) { 
			
			$this->Resource->create();
	
			
			$admin_data = $this->Session->read('WBSWAdmin');
			$this->data['Resource']['addedby'] = $admin_data['Admin']['name'];
			
			if($this->data['Resource']['resourcefile']['name']!='') {
				$this->data['Resource']['resourcefile'] = $this->_uploadFile($this->data['Resource']['resourcefile']);
				
				if($this->data['Resource']['resourcefile']==1) {
					$this->Session->setFlash('Please upload a valid file.', 'error',array('display'=>'error'));
					$this->redirect(array('action' => 'index'));
				    exit;
				}
				if(empty($this->data['Resource']['resourcefile'])) {
					$this->Session->setFlash('Unable to upload the file.', 'error',array('display'=>'error'));
				}
			}else {
				$this->data['Resource']['resourcefile'] = $this->data['Resource']['resourcefile']['name'];
				
			}
			
			if ($this->Resource->save($this->data)) {
				$this->Session->setFlash('The resource has been saved', 'error',array('display'=>'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash('The resource could not be saved. Please, try again.', 'error',array('display'=>'error'));
				$this->set('error_messages', $this->Resource->validationErrors);
			}
		}
		$this->set('statusoptions',$this->_statusOptions());
		$this->set('resourcescategory',$this->resourceCategory());

	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid resource has been selected', 'error',array('display'=>'warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			if(!empty($this->data['Resource']['resourcefile']['name'])) {
				$this->data['Resource']['resourcefile']  = $this->_uploadFile($this->data['Resource']['resourcefile'] );
			} else {
				$this->data['Resource']['resourcefile']  = $this->data['Resource']['resource'] ;
			}
			
			/*if($this->data['Resource']['resourcefile']['name']!='') {
				
				$this->data['Resource']['resourcefile'] = $this->_uploadFile($this->data['Resource']['resourcefile']);
				if($this->data['Resource']['resourcefile']==1) {
					$this->Session->setFlash('Please upload a valid file.', 'error',array('display'=>'error'));
					$this->redirect($this->referer());
				    exit;
				}
				if(empty($this->data['Resource']['resourcefile'])) {
					$this->Session->setFlash('Unable to upload the file.', 'error',array('display'=>'error'));
				}
			} else {
				$this->data['Resource']['resourcefile'] = $this->data['Resource']['resource']['name'];
				
			}*/
			
			if ($this->Resource->save($this->data)) {
				$this->Session->setFlash('The resource has been saved', 'error',array('display'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The resource could not be saved. Please, try again.', 'error',array('display'=>'error'));
				$this->set('error_messages', $this->Resource->validationErrors);
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Resource->read(null, $id);
		}
		$this->set('statusoptions',$this->_statusOptions());
		$this->set('resourcescategory',$this->resourceCategory());
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid resource has been selected', 'error',array('display'=>'warning'));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Resource->delete($id)) {
			$this->Session->setFlash('The resource has been deleted', 'error',array('display'=>'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('The resource is not deleted', 'error',array('display'=>'error'));
		$this->redirect(array('action' => 'index'));
	}
	
	/**************************
	*	Admin Search
	***************************/
	function admin_search () {
		/* Unset the session for new criteria */
		if(isset($_SESSION['search'])) unset($_SESSION['search']);
		$search_condition = array();
		$search_params = array();
		
		if(!empty($this->data)) {
			if(isset($this->data['Resource']['title']) and trim($this->data['Resource']['title'])!='') {
				$search_condition[] = " Resource.title LIKE '%" . $this->data['Resource']['title'] . "%' ";
				$search_params['title'] = $this->data['Resource']['title'];
			}
			if(isset($this->data['Resource']['category']) and trim($this->data['Resource']['category'])!='') {
				$search_condition[] = " Resource.category = ". $this->data['Resource']['category'];
				$search_params['category'] = $this->data['Resource']['category'];
			}
			if(isset($this->data['Resource']['status']) and trim($this->data['Resource']['status'])!='') {
				$search_condition[] = " Resource.status = '".$this->data['Resource']['status']."'";
				$search_params['status'] = $this->data['Resource']['status'];
			}
		}
		$_SESSION['search']['condition'] = $search_condition;
		$_SESSION['search']['params'] = $search_params;
		
		$this->redirect(array('action'=>'index'));
	}
	
	function admin_clear () {
		/* Clear the session for new search */
		$this->__clearsearch();
	}

	
	function _uploadFile($filename) {
		
		$real_destination = realpath('').'/'.Configure::read('RESOURCE_PATH') ; 
		
		$allowed = array('pdf');
		if(isset($filename) != "") {
			
			$result = $this->Upload->upload($filename, $real_destination, null, null, $allowed);
		
			if($result=='1'){
				return $result;
			}else{
			return $this->Upload->result;
			}
		} else {
			return '';
		}
	}
		

	function _remuploadedfile($filename) {
		$real_destination = realpath('').'/'.Configure::read('RESOURCE_PATH');
		unlink($real_destination."/".$filename);
	}
	
		/*	Downloads invoice */
	function download($doc=null) {
		$this->layout = null;
		$userdata = $this->_checkPermission();
		
		if(!empty($doc)) {
			$this->_downloadfile(getcwd().'/'.Configure::read('RESOURCE_PATH').$doc);
			exit;
		} else {
			$this->Session->setFlash('Invalid download attempt.','error',array('display'=>'error'));
			$this->redirect(array('controller'=>'invoices','action' =>'index'));
			exit();
		}
	}
}
?>