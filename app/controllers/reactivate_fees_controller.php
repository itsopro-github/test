<?php
class ReactivateFeesController extends AppController {

	var $name = 'ReactivateFees';

	function admin_index() {
		$this->ReactivateFee->recursive = 0;
		$this->set('reactivateFees', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid reactivate fee', true), array('action' => 'index'));
		}
		$this->set('reactivateFee', $this->ReactivateFee->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->ReactivateFee->create();
			if ($this->ReactivateFee->save($this->data)) {
				$this->flash(__('Reactivatefee saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$orders = $this->ReactivateFee->Order->find('list');
		$this->set(compact('orders'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid reactivate fee', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ReactivateFee->save($this->data)) {
				$this->flash(__('The reactivate fee has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ReactivateFee->read(null, $id);
		}
		$orders = $this->ReactivateFee->Order->find('list');
		$this->set(compact('orders'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid reactivate fee', true)), array('action' => 'index'));
		}
		if ($this->ReactivateFee->delete($id)) {
			$this->flash(__('Reactivate fee deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Reactivate fee was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
?>