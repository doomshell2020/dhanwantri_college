<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;


class ModesController extends AppController
{
	//initialize component
	public function initialize(){
        parent::initialize();
       	$this->loadModel('Modes');
    	}
	
	public function index($id=null){ 
		$this->viewBuilder()->layout('admin');
		//show data in listing
		$modes = $this->Modes->find('all')->order(['id' => 'DESC'])->toarray();
		$this->paginate($service_data);
		//pr($modes); die;
		$this->set('modes',$modes);
	$modess = $this->Modes->newEntity();
	$this->set('modess',$modess);
	}
	
public function add($id=null){ 
		$this->viewBuilder()->layout('admin');
		if(isset($id) && !empty($id)){
			//using for edit
	 $modes = $this->Modes->get($id);

		}else{
			//using for new entry
			$modes = $this->Modes->newEntity();
	
		}
		if ($this->request->is(['post', 'put'])) {
			
  	//	pr($this->request->data); die;
				
				// save all data in database
				$modes = $this->Modes->patchEntity($modes, $this->request->data);
					//pr($locations); die;
				if ($this->Modes->save($modes)) {
					$this->Flash->success(__('Modes has been saved.'));
					return $this->redirect(['action' => 'index']);	
				  }else{ //pr($classes->errors());
					//validation error
					if($modes->errors()){
					          $error_msg = [];
						foreach( $modes->errors() as $errors){
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

		$this->set('modes', $modes);
	}

	public function sort(){
	$this->viewBuilder()->layout('admin');
	$id = $this->request->data[id];
	if(isset($id) && !empty($id)){
			//using for edit
		     $modes = $this->Modes->get($id);
		
		}else{
			//using for new entry
			$modes = $this->Modes->newEntity();
		}
	
	if($this->request->is(['post', 'put'])) {
	
		//$this->request->data = $this->request->data['sort']; 
               $modes->sort = $this->request->data['sort'];

		if ($this->Modes->save($modes)) {
			echo $modes['sort'];		
		}else{  
			echo 'wrong'; 
				
		}
	}	
	die;
	}
	//view functionality
	public function view($id){    
		$this->viewBuilder()->layout('admin');
		//get data from paricular id
		$modes = $this->Locations->get($id);
		$this->set(compact('modes'));
	    }
	//delete functionality
	public function delete($id){
	    //$this->request->allowMethod(['post', 'delete']);
		$modes = $this->Modes->get($id);
		//delete pariticular entry
			try { 
	    if ($this->Modes->delete($modes)) {
		$this->Flash->success(__(' Mode with id: {0} has been deleted.', h($id)));
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
	public function status($id,$status){
		if(isset($id) && !empty($id)){
		if($status == 'Y' ){
			
				$status = 'N';
			//status update
				$modes = $this->Modes->get($id);
				$modes->status = $status;
				if ($this->Modes->save($modes)) {
					$this->Flash->success(__(' Mode status has been updated.'));
					return $this->redirect(['action' => 'index']);	
				}
		}else
		{
				$status ='Y';
			//status update
			$modes = $this->Modes->get($id);
			$modes->status = $status;
			if ($this->Modes->save($modes)) {
				$this->Flash->success(__('Mode status has been updated.'));
				return $this->redirect(['action' => 'index']);	
			}
			
			}
		}

	}
		
}
