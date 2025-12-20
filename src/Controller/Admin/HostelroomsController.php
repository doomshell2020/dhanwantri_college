<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;

class HostelroomsController extends AppController
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
		$hostelrooms = $this->Hostelrooms->find('all')->contain(['Hostels'])->order(['Hostelrooms.id' => 'Desc'])->toarray();
		$this->paginate($service_data);
		//pr($hostelrooms); die;
		$this->set('hostelrooms',$hostelrooms);
	
	
	}
	
		public function add($id=null){ 
		$this->viewBuilder()->layout('admin');
		 $h_name=$this->Hostels->find('list', ['keyField' => 'id','valueField' => 'name'])->where(['Hostels.status'=>'Y'])->order(['name' => 'ASC'])->toArray();
		// pr($h_name); die;
         $this->set(compact('h_name'));
		if(isset($id) && !empty($id)){
			
        $hostelrooms = $this->Hostelrooms->get($id);
		}else{
			
			$hostelrooms = $this->Hostelrooms->newEntity();
		}
		if ($this->request->is(['post', 'put'])) {
			

						$classfeeexits = $this->Hostelrooms->find('all')->order(['id' => 'ASC'])->where(['Hostelrooms.h_id' =>$this->request->data['h_id'],'Hostelrooms.type' =>$this->request->data['type']])->first();
				// save all data in databas
				
				
					if($classfeeexits['id'] && $id==""){
						
					$this->Flash->error(__('Hostel name already assign with this type.'));
					return $this->redirect(['action' => 'index']);		
						
						
					}else{
				$hostelrooms = $this->Hostelrooms->patchEntity($hostelrooms, $this->request->data);
					//pr($hostels); die;
				if ($this->Hostelrooms->save($hostelrooms)) {
					$this->Flash->success(__('Rooms has been saved.'));
					return $this->redirect(['action' => 'index']);	
				  }else{ //pr($classes->errors());
					//validation error
					if($hostelrooms->errors()){
					          $error_msg = [];
						foreach( $hostelrooms->errors() as $errors){
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
                }

		$this->set('hostelrooms', $hostelrooms);
	}

	public function sort(){
	$this->viewBuilder()->layout('admin');
	$id = $this->request->data[id];
	if(isset($id) && !empty($id)){
			//using for edit
		     $classes = $this->Hostelrooms->get($id);
		
		}else{
			//using for new entry
			$classes = $this->Hostelrooms->newEntity();
		}
	
	if($this->request->is(['post', 'put'])) {
	
		//$this->request->data = $this->request->data['sort']; 
               $classes->sort = $this->request->data['sort'];

		if ($this->Hostelrooms->save($classes)) {
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
		//get data from paricular id
		$classes = $this->Hostelrooms->get($id);
		$this->set(compact('classes'));
	    }
	//delete functionality
	public function delete($id){
	    //$this->request->allowMethod(['post', 'delete']);
		$classes = $this->Hostelrooms->get($id);
		//delete pariticular entry
	    if ($this->Hostelrooms->delete($classes)) {
		$this->Flash->success(__('Rooms with id: {0} has been deleted.', h($id)));
		return $this->redirect(['action' => 'index']);
	    }
	}
	//status update functionality
	public function status($id=null,$status=null,$h_id=null){

		if(isset($id) && !empty($id)){
		if($status == 'Y' ){
		//echo $h_id; die;
				$status = 'N';
		       $conn = ConnectionManager::get('default'); 
                     $conn->execute("update hostels set status='$status' where id='$h_id'"); 
				$classes = $this->Hostelrooms->get($id);
				$classes->status = $status;
				if ($this->Hostelrooms->save($classes)) {
					$this->Flash->success(__('Rooms status has been updated.'));
					return $this->redirect(['action' => 'index']);	
				}
		}else{
				$status = 'Y';
			//status update
			   $conn = ConnectionManager::get('default'); 
                     $conn->execute("update hostels set status='$status' where id='$h_id'"); 
			$classes = $this->Hostelrooms->get($id);
			$classes->status = $status;
			if ($this->Hostelrooms->save($classes)) {
				$this->Flash->success(__('Rooms status has been updated.'));
				return $this->redirect(['action' => 'index']);	
			}
			
			}
		}

	}
	
		public function find_type(){
			$this->viewBuilder()->layout('admin');
                 $id=$this->request->data['id'];
		$statelist =$this->Hostels->find('list', ['keyField' => 'id','valueField' => 'type'])->where(['Hostels.id' => $id,'Hostels.status' =>'Y'])->toArray();
	foreach( $statelist as $value)
	{

		if($value=="0")
		
		{
			echo "Boys";
			}else
			
			{
				echo "Girls"; 
	}
	
}
die;
		}
		
	}
