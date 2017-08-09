<?php
class PaymentsController extends AppController {

	var $name = 'Payments';

	function index() {
		$this->Payment->recursive = 0;
		$this->set('payments', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid payment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('payment', $this->Payment->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Payment->create();
			if ($this->Payment->save($this->data)) {
				$this->Session->setFlash(__('The payment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The payment could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Payment->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid payment', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Payment->save($this->data)) {
				$this->Session->setFlash(__('The payment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The payment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Payment->read(null, $id);
		}
		$users = $this->Payment->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for payment', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Payment->delete($id)) {
			$this->Session->setFlash(__('Payment deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Payment was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Payment->recursive = 0;
		$this->set('payments', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid payment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('payment', $this->Payment->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Payment->create();
			if ($this->Payment->save($this->data)) {
				$this->Session->setFlash(__('The payment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The payment could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Payment->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid payment', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Payment->save($this->data)) {
				$this->Session->setFlash(__('The payment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The payment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Payment->read(null, $id);
		}
		$users = $this->Payment->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for payment', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Payment->delete($id)) {
			$this->Session->setFlash(__('Payment deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Payment was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>