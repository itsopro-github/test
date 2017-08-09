<?php
class HistoryFeesController extends AppController {

	var $name = 'HistoryFees';

	function index() {
		$this->HistoryFee->recursive = 0;
		$this->set('historyFees', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid history fee', true));
			$this->redirect(array('action' => 'index'));
			exit();
		}
		$this->set('historyFee', $this->HistoryFee->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->HistoryFee->create();
			if ($this->HistoryFee->save($this->data)) {
				$this->Session->setFlash(__('The history fee has been saved', true));
				$this->redirect(array('action' => 'index'));
				exit();
			} else {
				$this->Session->setFlash(__('The history fee could not be saved. Please, try again.', true));
			}
		}
		$users = $this->HistoryFee->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid history fee', true));
			$this->redirect(array('action' => 'index'));
			exit();
		}
		if (!empty($this->data)) {
			if ($this->HistoryFee->save($this->data)) {
				$this->Session->setFlash(__('The history fee has been saved', true));
				$this->redirect(array('action' => 'index'));
				exit();
			} else {
				$this->Session->setFlash(__('The history fee could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->HistoryFee->read(null, $id);
		}
		$users = $this->HistoryFee->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for history fee', true));
			$this->redirect(array('action'=>'index'));
			exit();
		}
		if ($this->HistoryFee->delete($id)) {
			$this->Session->setFlash(__('History fee deleted', true));
			$this->redirect(array('action'=>'index'));
			exit();
		}
		$this->Session->setFlash(__('History fee was not deleted', true));
		$this->redirect(array('action' => 'index'));
		exit();
	}
	function admin_index() {
		$this->HistoryFee->recursive = 0;
		$this->set('historyFees', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid history fee', true));
			$this->redirect(array('action' => 'index'));
			exit();
		}
		$this->set('historyFee', $this->HistoryFee->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->HistoryFee->create();
			if ($this->HistoryFee->save($this->data)) {
				$this->Session->setFlash(__('The history fee has been saved', true));
				$this->redirect(array('action' => 'index'));
				exit();
			} else {
				$this->Session->setFlash(__('The history fee could not be saved. Please, try again.', true));
			}
		}
		$users = $this->HistoryFee->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid history fee', true));
			$this->redirect(array('action' => 'index'));
			exit();
		}
		if (!empty($this->data)) {
			if ($this->HistoryFee->save($this->data)) {
				$this->Session->setFlash(__('The history fee has been saved', true));
				$this->redirect(array('action' => 'index'));
				exit();
			} else {
				$this->Session->setFlash(__('The history fee could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->HistoryFee->read(null, $id);
		}
		$users = $this->HistoryFee->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for history fee', true));
			$this->redirect(array('action'=>'index'));
			exit();
		}
		if ($this->HistoryFee->delete($id)) {
			$this->Session->setFlash(__('History fee deleted', true));
			$this->redirect(array('action'=>'index'));
			exit();
		}
		$this->Session->setFlash(__('History fee was not deleted', true));
		$this->redirect(array('action' => 'index'));
		exit();
	}
}
?>