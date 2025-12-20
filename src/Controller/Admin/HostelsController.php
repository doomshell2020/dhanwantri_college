<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;

class HostelsController extends AppController
{
	//initialize component
	public function initialize(){
        parent::initialize();
       	$this->loadModel('Hostels');
       	$this->loadModel('Hostelrooms');
     
    	}
	
	public function index($id=null){ 
		$this->viewBuilder()->layout('admin');
		//show data in listing
		$hostels = $this->Hostels->find('all')->order(['Hostels.id' => 'Desc'])->toarray();
		$this->paginate($service_data);
	//	pr($hostels); die;
		$this->set('hostels',$hostels);
	
	
	}
	
		public function add($id=null){ 
		$this->viewBuilder()->layout('admin');

		if(isset($id) && !empty($id)){
        $hostels = $this->Hostels->get($id);
		}else{
			$hostels = $this->Hostels->newEntity();
		}
		if ($this->request->is(['post', 'put'])) {
			

		
				// save all data in database
				 $warden_name= ucfirst($this->request->data['wardenname']);
				 $this->request->data['wardenname']=$warden_name;
				 $this->request->data['lastdate']=$this->request->data['lastdate'];
				$hostels = $this->Hostels->patchEntity($hostels, $this->request->data);
				if ($this->Hostels->save($hostels)) {
					$this->Flash->success(__('Hostel has been saved.'));
					return $this->redirect(['action' => 'index']);	
				  }else{ //pr($classes->errors());
					//validation error
					if($Hostels->errors()){
					          $error_msg = [];
						foreach( $Hostels->errors() as $errors){
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
		$this->set('hostels', $hostels);
	}

	public function sort()
	{
	  $this->viewBuilder()->layout('admin');
	  $id = $this->request->data[id];
	  if(isset($id) && !empty($id))
	  {
			//using for edit
		     $classes = $this->Hostels->get($id);
		}else{
			//using for new entry
			$classes = $this->Hostels->newEntity();
		}
	
	    if($this->request->is(['post', 'put'])) {
		//$this->request->data = $this->request->data['sort']; 
               $classes->sort = $this->request->data['sort'];
		if ($this->Hostels->save($classes)) {
			echo $classes['sort'];		
		}else{  
			echo 'wrong'; 	
		}
	  }	
	die;
	}

	//view functionality
	public function view($id)
	{    
		$this->viewBuilder()->layout('admin');
		$classes = $this->Hostels->get($id);
		$this->set(compact('classes'));
	}


	//delete functionality
	public function delete($id){
		$classes = $this->Hostels->get($id);
		//delete pariticular entry
try {
	    if ($this->Hostels->delete($classes)) {
		$this->Flash->success(__(' Hostel with id: {0} has been deleted.', h($id)));
		return $this->redirect(['action' => 'index']);
	    }
} catch (\PDOException $e) {
  //  $error = 'The item you are trying to delete is associated with other records';
    	$this->Flash->error(__('You can not delete this record because it is used in another table.'));
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
				$hostelsroom = $this->Hostelrooms->find('all')->where(['Hostelrooms.h_id'=>$id])->toarray();
				if(count($hostelsroom)> 0)
				{
					  $conn = ConnectionManager::get('default'); 
				  $conn->execute("update hostelrooms set status='$status' where h_id='$id'"); 
		
			}
			//status update
				$classes = $this->Hostels->get($id);
				$classes->status = $status;
				if ($this->Hostels->save($classes)) {
					$this->Flash->success(__(' Hostels status has been updated.'));
					return $this->redirect(['action' => 'index']);	
				}
		}else{
				$status = 'Y';
			//status update
					$hostelsroom = $this->Hostelrooms->find('all')->where(['Hostelrooms.h_id'=>$id])->toarray();
				if(count($hostelsroom)> 0)
				{
					  $conn = ConnectionManager::get('default'); 
				          $conn->execute("update hostelrooms set status='$status' where h_id='$id'"); 
			}
			$classes = $this->Hostels->get($id);
			$classes->status = $status;
			if ($this->Hostels->save($classes)) {
				$this->Flash->success(__('Hostels status has been updated.'));
				return $this->redirect(['action' => 'index']);	
			}
			
			}
		}

	}
		
	}
