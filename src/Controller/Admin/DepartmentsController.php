<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;


class DepartmentsController extends AppController
{
	//initialize component
	public function initialize(){
        parent::initialize();
       	$this->loadModel('Departments');
    	}
	
	public function index(){ 
		$this->viewBuilder()->layout('admin');
		//show data in listing
		$classes_data = $this->Departments->find('all')->order(['id' => 'ASC']);
		//$this->paginate($service_data);
		$this->set('classes',$classes_data);
	}
	public function add($id=null){ 
		$this->viewBuilder()->layout('admin');
		if(isset($id) && !empty($id)){
			//using for edit
		     $classes = $this->Departments->get($id);

		}else{
			//using for new entry
			$classes = $this->Departments->newEntity();
			$statusquery = $this->Departments->find('all')->where(['Departments.status' => 'Y'])->count();
			if($statusquery < 8){
			
			$this->request->data['status'] = 'Y';
			}else{
			
				$this->request->data['status'] = 'N';
			}
		}
		if ($this->request->is(['post', 'put'])) {
				// save all data in database
				$classes = $this->Departments->patchEntity($classes, $this->request->data);
				if ($this->Departments->save($classes)) {
					$this->Flash->success(__('Your Departments has been saved.'));
					return $this->redirect(['action' => 'index']);	
				  }else{ 
					//validation error
					if($classes->errors()){
					          $error_msg = [];
						foreach( $classes->errors() as $errors){
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
		$this->set('classes', $classes);
}


	public function sort(){
	$this->viewBuilder()->layout('admin');
	$id = $this->request->data[id];
	if(isset($id) && !empty($id)){
			//using for edit
		     $classes = $this->Departments->get($id);
		}else{
			//using for new entry
			$classes = $this->Departments->newEntity();
		}
	if($this->request->is(['post', 'put'])) {
      $classes->sort = $this->request->data['sort'];
	  if ($this->Departments->save($classes)) {
			echo $classes['sort'];		
		}else{  
			echo 'wrong'; 	
		}
	}	
	die;
	}

	//view functionality
	public function view($id){    

		$this->viewBuilder()->layout('admin');
		$classes = $this->Departments->get($id);
		$this->set(compact('classes'));

	}


	//delete functionality
	public function delete($id){
		$classes = $this->Departments->get($id);
	    if ($this->Departments->delete($classes)) {
		$this->Flash->success(__('The Departments with id: {0} has been deleted.', h($id)));
		return $this->redirect(['action' => 'index']);
	    }

	}

	//status update functionality
	public function status($id,$status){

		$statusquery = $this->Departments->find('all')->where(['Departments.status' => 'Y'])->count();
		if(isset($id) && !empty($id)){
		if($status =='N' ){
				$status = 'Y';
			//status update
				$classes = $this->Departments->get($id);
				$classes->status = $status;
				if ($this->Departments->save($classes)) {
					$this->Flash->success(__('Your Departments status has been updated.'));
					return $this->redirect(['action' => 'index']);	
				}
		}else{
			if($statusquery < 8 ){
				$status = 'N';
			//status update
			$classes = $this->Departments->get($id);
			$classes->status = $status;
			if ($this->Departments->save($classes)) {
				$this->Flash->success(__('Your Departments status has been updated.'));
				return $this->redirect(['action' => 'index']);	
			}
			}else{
				$this->Flash->error(__('8 Entries all ready activate. Please deactivate one of activate'));
				return $this->redirect(['action' => 'index']);	
	 			}
			}

		}
		
	}
}
