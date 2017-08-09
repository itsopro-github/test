<?php
class ClientFeesController extends AppController {

	var $name = 'ClientFees';
    var $uses = array('ClientFee','Order');  
    
	function index() {
		$this->ClientFee->recursive = 0;
		$this->set('ClientFees', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Client fee', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ClientFee', $this->ClientFee->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ClientFee->create();
			if ($this->ClientFee->save($this->data)) {
				$this->Session->setFlash(__('The Client fee has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Client fee could not be saved. Please, try again.', true));
			}
		}
		
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Client fee', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ClientFee->save($this->data)) {
				$this->Session->setFlash(__('The Client fee has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Client fee could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ClientFee->read(null, $id);
		}
		
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Client fee', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ClientFee->delete($id)) {
			$this->Session->setFlash(__('Client fee deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Client fee was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->ClientFee->recursive = 0;
		$this->set('ClientFees', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Client fee', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ClientFee', $this->ClientFee->read(null, $id));
	}

	function admin_add() {		
		if (!empty($this->data)) {			
			$totcnt = count($this->data['ClientFees']['fees']);
			$total = 0;
			for($i=0;$i<$totcnt;$i++){
				$this->ClientFee->create();
				$total = $total + $this->data['ClientFees']['fees'][$i];
				$nfees['ClientFee']['fees'] = $this->data['ClientFees']['fees'][$i];
				$nfees['ClientFee']['fee_type'] = $this->data['ClientFees']['fee_type'][$i];
				$nfees['ClientFee']['order_id'] = $this->data['ClientFees']['order_id'];
				$this->ClientFee->save($nfees);				
			}
			//update order			
			$data = array(
				'Order' => array(
				'id' => $this->data['ClientFees']['order_id'],
				'cfee_total' => $total)
			);			
			$this->Order->save( $data, false, array('cfee_total'));			
			$data = array(
				'Order' => array(
				'id' => $this->data['ClientFees']['order_id'],
				'cfee_notes' => $this->data['Order']['cfee_notes'])
			);			
			$this->Order->save($data, false, array('cfee_notes'));					
			$this->redirect(array('controller'=>'orders','action'=>'view', $this->data['ClientFees']['order_id']));
			exit();
		}
	}

	function admin_edit($id = null) {
		if (!empty($this->data)) {			
			$totcnt = count($this->data['ClientFees']['fees']);
			$total = 0;
			for($i=0;$i<$totcnt;$i++){
				//$this->ClientFee->create();
				$total = $total + $this->data['ClientFees']['fees'][$i];
				$nfees['ClientFee']['fees'] = $this->data['ClientFees']['fees'][$i];
				$nfees['ClientFee']['id'] = $this->data['ClientFees']['id'][$i];
				$nfees['ClientFee']['fee_type'] = $this->data['ClientFees']['fee_type'][$i];
				$nfees['ClientFee']['order_id'] = $this->data['ClientFees']['order_id'];
				$this->ClientFee->save($nfees);
				
			}
			//update order			
			$data = array(
				'Order' => array(
				'id' => $this->data['ClientFees']['order_id'],
				'cfee_total' => $total)
			);			
			$this->Order->save( $data, false, array('cfee_total'));			
			$data = array(
				'Order' => array(
				'id' => $this->data['ClientFees']['order_id'],
				'cfee_notes' => $this->data['Order']['cfee_notes'])
			);			
			$this->Order->save($data, false, array('cfee_notes'));						
			$this->Session->setFlash('Client fee saved successfully','error',array('display'=>'success'));
			$this->redirect(array('controller'=>'orders','action'=>'view',$this->data['ClientFees']['order_id']));
			exit();
		}
		if (empty($this->data)) {
			$this->data = $this->ClientFee->read(null, $id);
		}		
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Client fee', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ClientFee->delete($id)) {
			$this->Session->setFlash(__('Client fee deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Client fee was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>