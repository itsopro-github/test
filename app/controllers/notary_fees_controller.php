<?php
class NotaryFeesController extends AppController {

	var $name = 'NotaryFees';
    var $uses = array('NotaryFee','Order');  
    
	function index() {
		$this->NotaryFee->recursive = 0;
		$this->set('NotaryFees', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid notary fee', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('NotaryFee', $this->NotaryFee->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->NotaryFee->create();
			if ($this->NotaryFee->save($this->data)) {
				$this->Session->setFlash(__('The notary fee has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The notary fee could not be saved. Please, try again.', true));
			}
		}
		
	}

	function edit($id = null) {
	
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid notary fee', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->NotaryFee->save($this->data)) {
				$this->Session->setFlash(__('The notary fee has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The notary fee could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->NotaryFee->read(null, $id);
		}
		
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for notary fee', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->NotaryFee->delete($id)) {
			$this->Session->setFlash(__('notary fee deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('notary fee was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->NotaryFee->recursive = 0;
		$this->set('NotaryFees', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid notary fee', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('NotaryFee', $this->NotaryFee->read(null, $id));
	}

	function admin_add() {		
		if (!empty($this->data)) {			
			$totcnt = count($this->data['NotaryFees']['fees']);
			$total = 0;
			for($i=0;$i<$totcnt;$i++){
				$this->NotaryFee->create();
				$total = $total + $this->data['NotaryFees']['fees'][$i];
				$nfees['NotaryFee']['fees'] = $this->data['NotaryFees']['fees'][$i];
				$nfees['NotaryFee']['fee_type'] = $this->data['NotaryFees']['fee_type'][$i];
				$nfees['NotaryFee']['order_id'] = $this->data['NotaryFees']['order_id'];
				$this->NotaryFee->save($nfees);
				
			}
			//update order			
			$data = array(
				'Order' => array(
				'id' => $this->data['NotaryFees']['order_id'],
				'fee_total' => $total)
			);
			
			$this->Order->save( $data, false, array('fee_total'));				
			$data = array(
				'Order' => array(
				'id' => $this->data['NotaryFees']['order_id'],
				'fee_notes' => $this->data['Order']['fee_notes'])
			);				
			$this->Order->save($data, false, array('fee_notes') );						
			$this->redirect(array('controller'=>'orders','action'=>'view', $this->data['NotaryFees']['order_id']));
			exit();			
		}		
	}

	function admin_edit($id = null) {
		if (!empty($this->data)) {			
			$totcnt = count($this->data['NotaryFees']['fees']);
			$total = 0;
			for($i=0;$i<$totcnt;$i++){
				$total = $total + $this->data['NotaryFees']['fees'][$i];
				$nfees['NotaryFee']['fees'] = $this->data['NotaryFees']['fees'][$i];
				$nfees['NotaryFee']['id'] = $this->data['NotaryFees']['id'][$i];
				$nfees['NotaryFee']['fee_type'] = $this->data['NotaryFees']['fee_type'][$i];
				$nfees['NotaryFee']['order_id'] = $this->data['NotaryFees']['order_id'];
				$this->NotaryFee->save($nfees);
			}
			$data = array(
				'Order' => array(
				'id' => $this->data['NotaryFees']['order_id'],
				'fee_total' => $total)
			);			
			$this->Order->save( $data, false, array('fee_total') );			
			$data = array(
				'Order' => array(
				'id' => $this->data['NotaryFees']['order_id'],
				'fee_notes' => $this->data['Order']['fee_notes'])
			);			
			$this->Order->save($data, false, array('fee_notes'));						
			$this->Session->setFlash('Notary fee saved successfully.','error',array('display'=>'success'));
			$this->redirect(array('controller'=>'orders','action'=>'view',$this->data['NotaryFees']['order_id']));
			exit();			
		}		
		if (empty($this->data)) {
			$this->data = $this->NotaryFee->read(null, $id);
		}		
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for notary fee.', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->NotaryFee->delete($id)) {
			$this->Session->setFlash(__('Notary fee deleted.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Notary fee is not deleted.', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>