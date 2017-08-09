<?php
class ContentpagesController extends AppController {

	var $name = 'Contentpages';

	var $helpers = array('Fck'); 
	
	function view() {
		pr($this->params);exit;
		if(!$this->params['name']) {
			$this->Session->setFlash('Sorry, an invalid page is selected','error',array('display'=>'warning'));
		}
		$contents = $this->Contentpage->find('first', array('callbacks'=>false,'fields'=>array('Contentpage.pagetitle','Contentpage.metakey','Contentpage.metadesc','Contentpage.content'),'conditions'=>array('Contentpage.status'=>'1','Contentpage.actionname'=>$this->params['name'])));
		if(!$contents) {
			$this->Session->setFlash('Sorry, an invalid page is selected','error',array('display'=>'warning'));
		}
		$this->set('title_for_layout', $contents['Contentpage']['pagetitle']);
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
		$this->paginate = array('conditions'=>@$condition,'recursive'=>0,'order'=>'Contentpage.created DESC','fields'=>array('Contentpage.id','Contentpage.name','Contentpage.pagetitle','Contentpage.status','Contentpage.created'));
		$this->set('contentpages', $this->paginate());
		$this->set('statusoptions', $this->_statusOptions());
	}

	function admin_view($id = null) {
		if(!$id) {
			$this->Session->setFlash(__('Invalid content page', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('contentpage', $this->Contentpage->read(null, $id));
		$this->set('statusoptions', $this->_statusOptions());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Contentpage->create();
			if ($this->Contentpage->save($this->data)) {
				$this->Session->setFlash('The contentpage has been saved', 'error',array('display'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The contentpage could not be saved. Please, try again.', 'error',array('display'=>'error'));
				$this->set('error_messages', $this->Contentpage->validationErrors);
			}
		}
		$this->set('statusoptions', $this->_statusOptions());
		$controllernames = $this->__getControllers();
		$this->set(compact('controllernames'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid content page', 'error',array('display'=>'warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Contentpage->save($this->data)) {
				$this->Session->setFlash('The content page has been saved', 'error',array('display'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The content page could not be saved. Please, try again.', 'error',array('display'=>'error'));
				$this->set('error_messages', $this->Contentpage->validationErrors);	
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Contentpage->read(null, $id);
		}
		$this->set('statusoptions', $this->_statusOptions());
		$controllernames = $this->__getControllers();
		$this->set(compact('controllernames'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for content page', 'error',array('display'=>'warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Contentpage->delete($id)) {
			$this->Session->setFlash('Content page deleted successfully', 'error',array('display'=>'success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('Content page was not deleted', 'error',array('display'=>'error'));
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
			if(isset($this->data['Contentpage']['name']) and trim($this->data['Contentpage']['name'])!='') {
				$search_condition[] = " Contentpage.name LIKE '%" . $this->data['Contentpage']['name'] . "%' ";
				$search_params['name'] = $this->data['Contentpage']['name'];
			}
			if(isset($this->data['Contentpage']['pagetitle']) and trim($this->data['Contentpage']['pagetitle'])!='') {
				$search_condition[] = " Contentpage.pagetitle LIKE '%" . $this->data['Contentpage']['pagetitle'] . "%' ";
				$search_params['pagetitle'] = $this->data['Contentpage']['pagetitle'];
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
}
?>