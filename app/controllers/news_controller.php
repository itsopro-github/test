<?php
class NewsController extends AppController {

	var $name = 'News';
	var $components = array('Upload');

	function index() {
		$this->News->recursive = 0;
		$this->set('news', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid news', 'error',array('display'=>'warning'));
			$this->redirect(array('action' => 'index'));
		}
		$newsdetails = $this->News->find('first',array('fields'=>array('News.id','News.title','News.description','News.image'),'conditions'=>array('News.id'=>$id)));
		$this->set('title_for_layout', 'News and Events');
		$this->set('news', $newsdetails);
	}

	function admin_index() {
		if(!empty($this->params['named']['s'])) {
			if(isset($_SESSION['search'])) unset($_SESSION['search']);
			$this->redirect(array('action' => 'index'));
		}
		if(isset($_SESSION['search']['condition']) and !empty($_SESSION['search']['condition'])) {
			$condition = array(implode(' AND ', @$_SESSION['search']['condition']));
		}
		$this->paginate = array('conditions'=>@$condition,'recursive'=>0,'order'=>'News.created DESC','fields'=>array('News.id','News.title','News.addedby','News.status','News.created'));
		$this->set('news', $this->paginate());
		$this->set('statusoptions',$this->_statusOptions());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid news', 'error',array('display'=>'warning'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('news', $this->News->read(null, $id));
		$this->set('statusoptions',$this->_statusOptions());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$admin_data = $this->Session->read('WBSWAdmin');
			$this->data['News']['addedby'] = $admin_data['Admin']['username'];
			$this->data['News']['image'] = $this->_uploadImage($this->data['News']['image']);
			$this->News->create();
			if ($this->News->save($this->data)) {
				$this->Session->setFlash('The news has been saved', 'error',array('display'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				if(!empty($this->data['News']['image'])) {
					$this->_remuploadedimage($this->data['News']['image']);
				}
				$this->Session->setFlash('The news could not be saved. Please, try again.', 'error',array('display'=>'error'));
				$this->set('error_messages', $this->News->validationErrors);
			}
		}
		$this->set('statusoptions',$this->_statusOptions());
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid news selected for modification', 'error',array('display'=>'warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			//$this->data['News']['image'] = $this->_uploadImage($this->data['News']['image']);
				if(!empty($this->data['News']['image']['name'])) {
				//$this->data['News']['image'] = $this->_uploadFile($this->data['News']['image']);
				$this->data['News']['image'] = $this->_uploadImage($this->data['News']['image']);
			} else {
				$this->data['News']['image'] = $this->data['News']['img'];
			}
			if ($this->News->save($this->data)) {
				$this->Session->setFlash('The news has been saved', 'error',array('display'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				if(!empty($this->data['News']['image'])) {
					$this->_remuploadedimage($this->data['News']['image']);
				}
				$this->Session->setFlash('The news could not be saved. Please, try again.', 'error',array('display'=>'error'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->News->read(null, $id);
		}
		$this->set('statusoptions',$this->_statusOptions());		
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid news selected for deletion', 'error',array('display'=>'warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->News->delete($id)) {
			$this->Session->setFlash('News deleted successfully', 'error',array('display'=>'success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('News was not deleted', 'error',array('display'=>'error'));
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
			if(isset($this->data['News']['title']) and trim($this->data['News']['title'])!='') {
				$search_condition[] = " News.title LIKE '%" . $this->data['News']['title'] . "%' ";
				$search_params['title'] = $this->data['News']['title'];
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
	
	function _uploadImage($arimage) {
		$real_destination = realpath('').'/'.Configure::read('NEWS_IMAGE_PATH') ; 
		$thumb_destination=realpath('').'/'.Configure::read('NEWS_THUMB_IMAGE_PATH') ; 
		$allowed = array('jpg','png','jpeg','gif');
		$thumb_rules = array("type"=>"resizedimension","size"=>array('84','86'),"quality"=>100);			
		
		if(isset($arimage) != "") {
			
			
			//$result = $this->Upload->upload($arimage, $real_destination, null, null, $allowed);
			$result = $this->Upload->upload($arimage, $thumb_destination, null, null, $allowed);
			return $this->Upload->result;
		} else {
			return '';
		}
	}
	
	function _remuploadedimage ($imagename) {
		$real_destination = realpath('').'/'.Configure::read('NEWS_IMAGE_PATH') ; 
		$thumb_destination = realpath('').'/'.Configure::read('NEWS_THUMB_IMAGE_PATH') ; 
		
		unlink($real_destination."/".$imagename);
		unlink($thumb_destination."/".$imagename);
	}
}
?>