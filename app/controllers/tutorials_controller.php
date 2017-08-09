<?php
class TutorialsController extends AppController {

	var $name = 'Tutorials';
	var $components = array('Upload');

	function index() {
		$userdata = $this->_checkPermission();
		$vtutorials = $this->Tutorial->find('all', array('fields'=>array('Tutorial.id','Tutorial.title','Tutorial.tutorialfile','Tutorial.description','Tutorial.category', 'Tutorial.created'),'recursive'=>-1,'conditions'=>array('Tutorial.category'=>$userdata['User']['type'],'Tutorial.status'=>'1')));
		$this->set('tutorials', $vtutorials);
		
		$this->loadModel('Contentpage');
		$contents = $this->Contentpage->find('first', array('callbacks'=>false,'fields'=>array('Contentpage.pagetitle','Contentpage.metakey','Contentpage.metadesc','Contentpage.content'),'conditions'=>array('Contentpage.status'=>'1','Contentpage.id'=>36)));
		$this->set('contentpage', $contents);
	}

	function view_noneed($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid tutorial', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('tutorials', $this->Tutorial->read(null, $id));
		
	}

	function admin_index() {
		if(!empty($this->params['named']['s'])) {
			if(isset($_SESSION['search'])) unset($_SESSION['search']);
			$this->redirect(array('action' => 'index'));
		}
		if(isset($_SESSION['search']['condition']) and !empty($_SESSION['search']['condition'])) {
			$condition = array(implode(' AND ', @$_SESSION['search']['condition']));
		}
		$this->paginate = array('conditions'=>@$condition,'recursive'=>0,'order'=>'Tutorial.created DESC','fields'=>array('Tutorial.id','Tutorial.title','Tutorial.addedby','Tutorial.category','Tutorial.status','Tutorial.created'));
		$this->set('tutorials', $this->paginate());
		$this->set('statusoptions',$this->_statusOptions());
		$this->set('useroptions',$this->whichtypeuser());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid tutorial', 'error',array('display'=>'warning'));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('tutorial', $this->Tutorial->read(null, $id));
		$this->set('statusoptions',$this->_statusOptions());
		$this->set('useroptions',$this->whichtypeuser());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$admin_data = $this->Session->read('WBSWAdmin');
			$this->data['Tutorial']['addedby'] = $admin_data['Admin']['name'];
			$this->data['Tutorial']['tutorialfile'] = $this->_uploadFile($this->data['Tutorial']['tutorialfile']);
			$this->Tutorial->create();
			if ($this->Tutorial->save($this->data)) {
				$this->Session->setFlash('The tutorial has been saved', 'error',array('display'=>'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				if(!empty($this->data['Tutorial']['tutorialfile'])) {
					$this->_remuploadedfile($this->data['Tutorial']['tutorialfile']);
				}
				$this->Session->setFlash('The tutorial could not be saved. Please, try again.', 'error',array('display'=>'error'));
				$this->set('error_messages', $this->Tutorial->validationErrors);
			}
		}
		$this->set('statusoptions',$this->_statusOptions());
		$this->set('useroptions',$this->whichtypeuser());
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid tutorial selected for modification', 'error',array('display'=>'warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if(!empty($this->data['Tutorial']['tutorialfile']['name'])) {
				$this->data['Tutorial']['tutorialfile'] = $this->_uploadFile($this->data['Tutorial']['tutorialfile']);
			} else {
				$this->data['Tutorial']['tutorialfile'] = $this->data['Tutorial']['tutorial'];
			}
			if ($this->Tutorial->save($this->data)) {
				$this->Session->setFlash('The tutorial has been saved', 'error',array('display'=>'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				if(!empty($this->data['Tutorial']['tutorialfile'])) {
					$this->_remuploadedfile($this->data['Tutorial']['tutorialfile']);
				}
				$this->Session->setFlash('The tutorial could not be saved. Please, try again.', 'error',array('display'=>'error'));
				$this->set('error_messages', $this->Tutorial->validationErrors);
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Tutorial->read(null, $id);
		}
		$this->set('statusoptions',$this->_statusOptions());
		$this->set('useroptions',$this->whichtypeuser());
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid tutorial selected for deletion', 'error',array('display'=>'warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Tutorial->delete($id)) {
			$this->Session->setFlash('Tutorial deleted successfully', 'error',array('display'=>'success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('Tutorial was not deleted', 'error',array('display'=>'error'));
		$this->redirect(array('action'=>'index'));
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
			if(isset($this->data['Tutorial']['title']) and trim($this->data['Tutorial']['title'])!='') {
				$search_condition[] = " Tutorial.title LIKE '%" . $this->data['Tutorial']['title'] . "%' ";
				$search_params['title'] = $this->data['Tutorial']['title'];
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
		$real_destination = realpath('').'/'.Configure::read('TUTORIAL_PATH');
		$allowed = array('flv', 'FLV', 'MP4', 'mp4', 'MP3', 'mp3', 'AAC', 'aac');
		if(isset($filename) != "") {
			$result = $this->Upload->upload($filename, $real_destination, null, null, $allowed);
			return $this->Upload->result;
		} else {
			return '';
		}
	}
	
	function _remuploadedfile($filename) {
		$real_destination = realpath('').'/'.Configure::read('TUTORIAL_PATH');
		unlink($real_destination."/".$filename);
	}
}
?>