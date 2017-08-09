<?php
class HistoryOwnersController extends AppController {

	var $name = 'HistoryOwners';

	function index() {
		$this->HistoryOwner->recursive = 0;
		$this->set('historyOwners', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid history owner', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('historyOwner', $this->HistoryOwner->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->HistoryOwner->create();
			if ($this->HistoryOwner->save($this->data)) {
				$this->Session->setFlash(__('The history owner has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The history owner could not be saved. Please, try again.', true));
			}
		}
		$admins = $this->HistoryOwner->Admin->find('list');
		$orders = $this->HistoryOwner->Order->find('list');
		$this->set(compact('admins', 'orders'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid history owner', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->HistoryOwner->save($this->data)) {
				$this->Session->setFlash(__('The history owner has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The history owner could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->HistoryOwner->read(null, $id);
		}
		$admins = $this->HistoryOwner->Admin->find('list');
		$orders = $this->HistoryOwner->Order->find('list');
		$this->set(compact('admins', 'orders'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for history owner', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->HistoryOwner->delete($id)) {
			$this->Session->setFlash(__('History owner deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('History owner was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->HistoryOwner->recursive = 0;
		$this->set('historyOwners', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid history owner', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('historyOwner', $this->HistoryOwner->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->HistoryOwner->create();
			if ($this->HistoryOwner->save($this->data)) {
				$this->Session->setFlash(__('The history owner has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The history owner could not be saved. Please, try again.', true));
			}
		}
		$admins = $this->HistoryOwner->Admin->find('list');
		$orders = $this->HistoryOwner->Order->find('list');
		$this->set(compact('admins', 'orders'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid history owner', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->HistoryOwner->save($this->data)) {
				$this->Session->setFlash(__('The history owner has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The history owner could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->HistoryOwner->read(null, $id);
		}
		$admins = $this->HistoryOwner->Admin->find('list');
		$orders = $this->HistoryOwner->Order->find('list');
		$this->set(compact('admins', 'orders'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for history owner', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->HistoryOwner->delete($id)) {
			$this->Session->setFlash(__('History owner deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('History owner was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>