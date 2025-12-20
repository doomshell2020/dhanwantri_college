<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;


class FeesheadsController extends AppController
{
	//initialize component
	public function initialize()
	{
		parent::initialize();
		$this->loadModel(' Feesheads');
	}

	public function index($id = null)
	{
		$this->viewBuilder()->layout('admin');
		//show data in listing
		$r = array('2', '3', '0');
		
		$feesheadss = $this->Feesheads->find('all')->where(['type IN' => $r])->order(['id' => 'ASC'])->toarray();

		if (isset($id) && !empty($id)) {
			$feesheads = $this->Feesheads->get($id);
		}else{
			$feesheads = $this->Feesheads->newEntity();
		}
		$this->paginate($service_data);
		//pr($locations); die;
		$this->set('ids', $id);
		$this->set('feesheadss', $feesheadss);

		if ($this->request->is(['post', 'put'])) {

			if (isset($id) && !empty($id)) {
				$feeshessadss = $this->Feesheads->find('all')->where(['id' => $id])->order(['id' => 'ASC'])->first();
				$this->request->data['name'] = $this->request->data['name'];
			} else {
				$feescount = $this->Feesheads->find('all')->where(['Feesheads.name' => trim($this->request->data['name']), 'FIND_IN_SET  (\'' . trim($this->request->data['name']) . '\',Feesheads.name)'])->count();
				if ($feescount != 0) {
					$this->Flash->error(__('Fees heads already exist.'));
					return $this->redirect(['action' => 'index']);
				}
				$findsort = $this->Feesheads->find('all')->where(['type' => '3'])->order(['sort' => 'DESC'])->first();
				$this->request->data['sort'] = $findsort['sort'] + 1;
			}

			$feesheads = $this->Feesheads->patchEntity($feesheads, $this->request->data);
			if ($this->Feesheads->save($feesheads)) {
				$this->Flash->success(__('Fees heads has been saved.'));
				return $this->redirect(['action' => 'index']);
			}
		}

		$this->set('feesheads', $feesheads);
	}
	/*	public function add($id=null){ 
		$this->viewBuilder()->layout('admin');
		if(isset($id) && !empty($id)){
			//using for edit
Banks		     $locations = $this->Locations->get($id);

		}else{
			//using for new entry
			$locations = $this->Locations->newEntity();
			$statusquery = $this->Locations->find('all')->where(['Locations.status' =>'Y'])->count();
			if($statusquery < 8){
			
			$this->request->data['status'] = '1';
			}else{
			
				$this->request->data['status'] = '0';
			}
		}
		if ($this->request->is(['post', 'put'])) {
			
  	//	pr($this->request->data); die;
				
				// save all data in database
				$locations = $this->Locations->patchEntity($locations, $this->request->data);
					//pr($locations); die;
				if ($this->Locations->save($locations)) {
					$this->Flash->success(__('Locations has been saved.'));
					return $this->redirect(['action' => 'index']);	
				  }else{ //pr($classes->errors());
					//validation error
					if($locations->errors()){
					          $error_msg = [];
						foreach( $locations->errors() as $errors){
						    if(is_array($errors)){
							foreach($errors as $error){
							    $error_msg[]    =   $error;
							}
						    }else{
							$error_msg[]    =   $errors;
						    }
						}
					if(!empty($error_msg)){
					    $this->Flash->error(
						__("Please fix the following error(s): ".implode("\n \r", $error_msg))
					    );
					}
				    }

				}
			
                }

		$this->set('locations', $locations);
	}
*/

	public function sort()
	{
		$this->viewBuilder()->layout('admin');
		$id = $this->request->data['id'];
		if (isset($id) && !empty($id)) {
			//using for edit
			$classes = $this->Feesheads->get($id);
		} else {
			//using for new entry
			$classes = $this->Feesheads->newEntity();
		}

		if ($this->request->is(['post', 'put'])) {

			//$this->request->data = $this->request->data['sort']; 
			$classes->sort = $this->request->data['sort'];

			if ($this->Feesheads->save($classes)) {
				echo $classes['sort'];
			} else {
				echo 'wrong';
			}
		}
		die;
	}
	//view functionality
	public function view($id)
	{
		$this->viewBuilder()->layout('admin');
		$classes = $this->Feesheads->get($id);
		$this->set(compact('classes'));
	}
	//delete functionality
	public function delete($id)
	{
		//$this->request->allowMethod(['post', 'delete']);
		$classes = $this->Feesheads->get($id);
		//delete pariticular entry
		try {
			if ($this->Feesheads->delete($classes)) {
				$this->Flash->success(__(' Feesheads with id: {0} has been deleted.', h($id)));
				return $this->redirect(['action' => 'index']);
			}
		} catch (\PDOException $e) {
			//  $error = 'The item you are trying to delete is associated with other records';
			$this->Flash->error(__(' You can not delete this record because it is used in another table.'));
			$this->set('error', $error);
			//$this->Session->setFlash(__(' Lader all ready exists), 'flash/Error');
			return $this->redirect(['action' => 'index']);
		}
	}
	//status update functionality
	public function status($id, $status)
	{

		$statusquery = $this->Feesheads->find('all')->where(['Feesheads.status' => 'Y'])->count();
		if (isset($id) && !empty($id)) {
			if ($status == 'Y') {

				$status = 'N';
				//status update
				$classes = $this->Feesheads->get($id);
				$classes->status = $status;
				if ($this->Feesheads->save($classes)) {
					$this->Flash->success(__(' Fees head status has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {
				if ($statusquery < 8) {
					$status = 1;
					//status update
					$classes = $this->Feesheads->get($id);
					$classes->status = $status;
					if ($this->Feesheads->save($classes)) {
						$this->Flash->success(__('Fees head status has been updated.'));
						return $this->redirect(['action' => 'index']);
					}
				} else {
					$this->Flash->error(__('8 Entries all ready activate. Please deactivate one of activate'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}
}
