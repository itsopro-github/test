<?php
class OrderdetailsController extends AppController {

	var $name = 'Orderdetails';
	var $helpers = array('N');

	function index() {
		$this->Orderdetail->recursive = 0;
		$this->set('orderdetails', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid orderdetail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('orderdetail', $this->Orderdetail->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Orderdetail->create();
			if ($this->Orderdetail->save($this->data)) {
				$this->Session->setFlash(__('The orderdetail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The orderdetail could not be saved. Please, try again.', true));
			}
		}
		$orders = $this->Orderdetail->Order->find('list');
		$this->set(compact('orders'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid orderdetail', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Orderdetail->save($this->data)) {
				$this->Session->setFlash(__('The orderdetail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The orderdetail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Orderdetail->read(null, $id);
		}
		$orders = $this->Orderdetail->Order->find('list');
		$this->set(compact('orders'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for orderdetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Orderdetail->delete($id)) {
			$this->Session->setFlash(__('Orderdetail deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Orderdetail was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_index() {
		$this->Orderdetail->recursive = 0;
		$this->set('orderdetails', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid orderdetail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('orderdetail', $this->Orderdetail->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Orderdetail->create();
			if ($this->Orderdetail->save($this->data)) {
				$this->Session->setFlash(__('The orderdetail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The orderdetail could not be saved. Please, try again.', true));
			}
		}
		$orders = $this->Orderdetail->Order->find('list');
		$this->set(compact('orders'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid orderdetail', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Orderdetail->save($this->data)) {
				$this->Session->setFlash(__('The orderdetail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The orderdetail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Orderdetail->read(null, $id);
		}
		$orders = $this->Orderdetail->Order->find('list');
		$this->set(compact('orders'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for orderdetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Orderdetail->delete($id)) {
			$this->Session->setFlash(__('Orderdetail deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Orderdetail was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>