<?php
class ClientRequirementsController extends AppController {

	var $name = 'ClientRequirements';

	function index() {
		$this->ClientRequirement->recursive = 0;
		$this->set('clientRequirements', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid client requirement', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('clientRequirement', $this->ClientRequirement->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ClientRequirement->create();
			if ($this->ClientRequirement->save($this->data)) {
				$this->Session->setFlash(__('The client requirement has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client requirement could not be saved. Please, try again.', true));
			}
		}
		$users = $this->ClientRequirement->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid client requirement', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ClientRequirement->save($this->data)) {
				$this->Session->setFlash(__('The client requirement has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client requirement could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ClientRequirement->read(null, $id);
		}
		$users = $this->ClientRequirement->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for client requirement', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ClientRequirement->delete($id)) {
			$this->Session->setFlash(__('Client requirement deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Client requirement was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->ClientRequirement->recursive = 0;
		$this->set('clientRequirements', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid client requirement', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('clientRequirement', $this->ClientRequirement->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->ClientRequirement->create();
			if ($this->ClientRequirement->save($this->data)) {
				$this->Session->setFlash(__('The client requirement has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client requirement could not be saved. Please, try again.', true));
			}
		}
		$users = $this->ClientRequirement->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid client requirement', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ClientRequirement->save($this->data)) {
				$this->Session->setFlash(__('The client requirement has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client requirement could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ClientRequirement->read(null, $id);
		}
		$users = $this->ClientRequirement->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete() {
		$id = $this->params['pass'][0];
		$red_id = $this->params['pass'][1];
		if (!$id) {
			$this->Session->setFlash('Invalid id for client requirement','error',array('display'=>'error'));
			$this->redirect(array('controller'=>'users','action'=>'edit','type'=>'clients','id'=>$red_id));
			exit;
		}
		if ($this->ClientRequirement->delete($id)) {
			$this->Session->setFlash('Client requirement deleted', 'error', array('display' => 'success'));
			$this->redirect(array('controller'=>'users','action'=>'edit','type'=>'clients','id'=>$red_id));
			exit;
		}
		$this->Session->setFlash('Client requirement was not deleted','error',array('display'=>'error'));
		$this->redirect(array('controller'=>'users','action'=>'edit','type'=>'clients','id'=>$red_id));
		exit;
	}
}
?>