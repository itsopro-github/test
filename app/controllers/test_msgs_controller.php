<?php
class TestMsgsController extends AppController {

	var $name = 'TestMsgs';

	function index() {
		$this->TestMsg->recursive = 0;
		$this->set('testMsgs', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid test msg', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('testMsg', $this->TestMsg->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->TestMsg->create();
			if ($this->TestMsg->save($this->data)) {
				$this->Session->setFlash(__('The test msg has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The test msg could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid test msg', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->TestMsg->save($this->data)) {
				$this->Session->setFlash(__('The test msg has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The test msg could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TestMsg->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for test msg', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TestMsg->delete($id)) {
			$this->Session->setFlash(__('Test msg deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Test msg was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>