<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use MyClass\MyClass;
use MyClass\Exception;

include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

class StudentsController extends AppController
{	
	public $helpers = ['CakeJs.Js'];
	
	

	public  function _setPassword($password)
	{
		return (new DefaultPasswordHasher)->hash($password);
	}

	public function initialize(){
		parent::initialize();
		$this->loadModel('PayrollDepartments');
		$this->loadModel('SitesettingsDetails');
		$this->loadModel('Users');
		$this->loadModel('Sections');
		$this->loadModel('Classes');
		$this->loadModel('Documentcategory');
		$this->loadModel('Houses');
		$this->loadModel('Documents');
		$this->loadModel('Address');
		$this->loadModel('Country');
		$this->loadModel('States');
		$this->loadModel('Cities');
		$this->loadModel('Guardians');
		$this->loadModel('Employees');
		$this->loadModel('Subjectclass');
		$this->loadModel('Subjects');
		$this->loadModel('Hostels');
		$this->loadModel('Hostelrooms');
		$this->loadModel('Transports');
		$this->loadModel('Transportfees');
		$this->loadModel('locations');
		$this->loadModel('Classections');
		$this->loadModel('Studentshistory');
		$this->loadModel('Guardianscategory');
		$this->loadModel('Studentexamresult');
		$this->loadModel('Exams');
		$this->loadModel('Examtypes');
		$this->loadModel('IssueBook');
		$this->loadModel('Enquires');
		$this->loadModel('Applicant');
		$this->loadModel('Studentfees');
		$this->loadModel('Studentfeepending'); 
		$this->loadModel('Classfee');
		$this->loadModel('DiscountCategory');
		$this->loadModel('DropOutStudent');
		$this->loadModel('Disabilitys');
		$this->loadModel('Smsmanager');
		$this->loadModel('Smsdelivery');
		$this->loadModel('AdmissionClasses');
		$this->loadModel('Students');
		$this->loadModel('Studattends');
		$this->loadModel('Board');
	
		
		
		require_once 'Firebase.php';
		require_once 'Push.php'; 
	}
	
	
	public function sendsmsall(){
		$this->autoRender=false;
	if ($this->request->is(['post', 'put'])) {

	$mesg=$this->request->data['message'];
	$category=$this->request->data['category'];
$smstemp = $this->Smsmanager->find('all')->select(['id'])->where(['category'=>$category])->order(['id' => 'ASC'])->first();
$smstemp_id=$smstemp['id']; 

$rolepresent=$this->request->session()->read('Auth.User.role_id');					
if($rolepresent=='1'){ 
	
$baord=array('1','2','3');
}else if($rolepresent=='5'){
$baord=array('1');
}else  if($rolepresent=='8'){
	
$baord=array('2','3');
}

	$students =$this->Students->find('all')->select(['sms_mobile','id','token'])->where(['Students.board_id IN' =>$baord,'Students.status' =>'Y'])->order(['Students.class_id ASC'])->toarray();
$romsm=sizeof($students);





if($mesg){
	
	
		$connsssks = ConnectionManager::get('default');
	
$mesg1=addslashes($mesg);
				 $connsssks->execute("INSERT INTO 
				`sms_deliveries`(`sms_temp_id`, `message`, `total students`,`status`) VALUES 
				('".$smstemp_id."','".$mesg1."','".$romsm."','Y')");
				
				
		$smsdelivery = $this->Smsdelivery->find('all')->select(['id'])->order(['id' => 'DESC'])->first();
		foreach($students as $s=>$students){
			$result='';			
		
		$mobile=$students['sms_mobile'];							
	//$mobile='9694027991';
	$result=$this->file_get_contents_curl('http://alerts.prioritysms.com/api/web2sms.php?workingkey=Afb7ede974e22367003ac66f8514bd152&to='.$mobile.'&sender=SNSKAR&message='.urlencode($mesg));
	
			
	
	if($result=="Invalid Input Data"){
	$connsssks1 = ConnectionManager::get('default');
		date_default_timezone_set('Asia/Kolkata');
		$date=date('Y-m-d H:i:s');

				 $connsssks1->execute("INSERT INTO 
				`sms_deliveries_details`(`stud_id`,`smsmobile`, `sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES 
				('".$students['id']."','".$students['sms_mobile']."','".$smsdelivery['id']."','".$smstemp_id."','".$date."','N')");
			
	}else if($result=="Invalid Mobile Numbers"){
			$connsssks2 = ConnectionManager::get('default');
		date_default_timezone_set('Asia/Kolkata');
		$date=date('Y-m-d H:i:s');

				 $connsssks2->execute("INSERT INTO 
				`sms_deliveries_details`(`stud_id`, `smsmobile`,`sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES 
				('".$students['id']."','".$students['sms_mobile']."','".$smsdelivery['id']."','".$smstemp_id."','".$date."','N')");
		
	}else if($result=="Insufficient credits"){
		
			$connsssks3 = ConnectionManager::get('default');
		date_default_timezone_set('Asia/Kolkata');
		$date=date('Y-m-d H:i:s');

				 $connsssks3->execute("INSERT INTO 
				`sms_deliveries_details`(`stud_id`, `smsmobile`,`sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES 
				('".$students['id']."','".$students['sms_mobile']."','".$smsdelivery['id']."','".$smstemp_id."','".$date."','N')");
				
				
			$this->Flash->error(__('Insufficient credits, Please Contact to Web Administrator !!!!.'));
		return $this->redirect(['action' => 'index']);
		
	}else{
		
		
		$connsssks = ConnectionManager::get('default');
		date_default_timezone_set('Asia/Kolkata');
		$date=date('Y-m-d H:i:s');

				 $connsssks->execute("INSERT INTO 
				`sms_deliveries_details`(`stud_id`, `smsmobile`, `sms_deliv_id`, `sms_temp_id`,`created`) VALUES 
				('".$students['id']."','".$students['sms_mobile']."','".$smsdelivery['id']."','".$smstemp_id."','".$date."')");
	
	
					}
					
					
					$_POST['title']='Sanskar Campus';
					$_POST['body']=$mesg;
			
					$push = null; 
					$push = new \Push(
					$_POST['title'],
					$_POST['body']		
					);
					
					$mPushNotification = $push->getPush();
			
					$firebase = new \Firebase(); 
					
					$_POST['data']=["route"=>"Notice Board"];
					
					$firebase->send($toke, $mPushNotification,$_POST['data']);
	
	

					
				}
				
					$this->Flash->success(__('Send SMS to All Student sucessfully.'));
					return $this->redirect(['action' => 'index']);
				

	}
	
}

}
	
	public function defaultersendsms(){
		$this->autoRender=false;
	if ($this->request->is(['post', 'put'])) {

	$mesg=$this->request->data['message'];
	$category=$this->request->data['category'];
$smstemp = $this->Smsmanager->find('all')->select(['id'])->where(['category'=>$category])->order(['id' => 'ASC'])->first();
$smstemp_id=$smstemp['id']; 

$romsm=sizeof($this->request->data['p_id']);

$rolepresent=$this->request->session()->read('Auth.User.role_id');					
if($rolepresent=='1'){ 
	
$baord=array('1','2','3');
}else if($rolepresent=='5'){
$baord=array('1');
}else  if($rolepresent=='8'){
	
$baord=array('2','3');
}



if($mesg){
	
	
		$connsssks = ConnectionManager::get('default');
	
$mesg1=addslashes($mesg);
				 $connsssks->execute("INSERT INTO 
				`sms_deliveries`(`sms_temp_id`, `message`, `total students`,`status`) VALUES 
				('".$smstemp_id."','".$mesg1."','".$romsm."','Y')");
				
				 $toke=array();
		$smsdelivery = $this->Smsdelivery->find('all')->select(['id'])->order(['id' => 'DESC'])->first();
		for($is=0;$is<$romsm;$is++){
			$result='';			
		$students =$this->Students->find('all')->select(['sms_mobile','id','token'])->where(['Students.enroll' =>$this->request->data['p_id'][$is],'Students.board_id IN' =>$baord,'Students.status' =>'Y'])->order(['Students.id DESC'])->first();
		$mobile=$students['sms_mobile'];							
	//$mobile='9694027991';
	$result=$this->file_get_contents_curl('http://alerts.prioritysms.com/api/web2sms.php?workingkey=Afb7ede974e22367003ac66f8514bd152&to='.$mobile.'&sender=SNSKAR&message='.urlencode($mesg));
	
			
	
	if($result=="Invalid Input Data"){
	$connsssks1 = ConnectionManager::get('default');
		date_default_timezone_set('Asia/Kolkata');
		$date=date('Y-m-d H:i:s');

				 $connsssks1->execute("INSERT INTO 
				`sms_deliveries_details`(`stud_id`,`smsmobile`, `sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES 
				('".$students['id']."','".$students['sms_mobile']."','".$smsdelivery['id']."','".$smstemp_id."','".$date."','N')");
			
	}else if($result=="Invalid Mobile Numbers"){
			$connsssks2 = ConnectionManager::get('default');
		date_default_timezone_set('Asia/Kolkata');
		$date=date('Y-m-d H:i:s');

				 $connsssks2->execute("INSERT INTO 
				`sms_deliveries_details`(`stud_id`, `smsmobile`,`sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES 
				('".$students['id']."','".$students['sms_mobile']."','".$smsdelivery['id']."','".$smstemp_id."','".$date."','N')");
		
	}else if($result=="Insufficient credits"){
		
			$connsssks3 = ConnectionManager::get('default');
		date_default_timezone_set('Asia/Kolkata');
		$date=date('Y-m-d H:i:s');

				 $connsssks3->execute("INSERT INTO 
				`sms_deliveries_details`(`stud_id`, `smsmobile`,`sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES 
				('".$students['id']."','".$students['sms_mobile']."','".$smsdelivery['id']."','".$smstemp_id."','".$date."','N')");
				
				
			$this->Flash->error(__('Insufficient credits, Please Contact to Web Administrator !!!!.'));
		return $this->redirect(['action' => 'index']);
		
	}else{
		
		
		$connsssks = ConnectionManager::get('default');
		date_default_timezone_set('Asia/Kolkata');
		$date=date('Y-m-d H:i:s');

				 $connsssks->execute("INSERT INTO 
				`sms_deliveries_details`(`stud_id`, `smsmobile`, `sms_deliv_id`, `sms_temp_id`,`created`) VALUES 
				('".$students['id']."','".$students['sms_mobile']."','".$smsdelivery['id']."','".$smstemp_id."','".$date."')");
	
	
					}
					
			


 $toke[]= $students['token'];
	


					
				}
				
				
					$_POST['title']='Sanskar Campus';
		$_POST['body']=$mesg;

		$push = null; 
		$push = new \Push(
		$_POST['title'],
		$_POST['body']		
		);
		
		$mPushNotification = $push->getPush();

		$firebase = new \Firebase(); 
		
		$_POST['data']=["route"=>"Notice Board"];
		
		$firebase->send($toke, $mPushNotification,$_POST['data']);
				
					$this->Flash->success(__('Send SMS to Student sucessfully.'));
					return $this->redirect(['action' => 'index']);
				

	}
	
}

}


	public function findlname(){
		$data = array();
		
		 $request = mysqli_real_escape_string($this->request->data["query"]);  $data[] ="Kumar";  echo json_encode($data); die;
		
	}
	
	
	public function addmission_recipt($id){ 
	$this->loadModel('Boards');
	$this->loadModel('Users');
	$this->loadModel('Students');
	$this->loadModel('Feesheads');
$classes_data = $this->Students->find('all')->order(['Students.id' => 
'DESC'])->contain(['Classes'])->where(['Students.id'=>$id,'Students.status'=>'Y'])->first()->toarray();
//pr($classes_data); die;
$this->set('students',$classes_data);
 $user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$acedmicyear=$user['academic_year'];
		
$this->set('acedmicyear',$acedmicyear);
$rt=$classes_data['board_id'];


if($rt=='1'){
	
	$nj=$this->Feesheads->find('all')->where(['Feesheads.id'=>'7'])->first()->toarray();

$this->set('admissionfee',$nj['cbse_fee']);


$njde=$this->Feesheads->find('all')->where(['Feesheads.id'=>'3'])->first()->toarray();

$this->set('devlopfee',$njde['cbse_fee']);

$njcaution=$this->Feesheads->find('all')->where(['Feesheads.id'=>'4'])->first()->toarray();

$this->set('cautionfee',$njcaution['cbse_fee']);


	
}else if($rt=='2'){
	
	$nj=$this->Feesheads->find('all')->where(['Feesheads.id'=>'7'])->first()->toarray();

$this->set('admissionfee',$nj['cambridge_fee']);


$njde=$this->Feesheads->find('all')->where(['Feesheads.id'=>'3'])->first()->toarray();

$this->set('devlopfee',$njde['cambridge_fee']);

$njcaution=$this->Feesheads->find('all')->where(['Feesheads.id'=>'4'])->first()->toarray();

$this->set('cautionfee',$njcaution['cbse_fee']);
	
}else if($rt=='3'){
	
	$nj=$this->Feesheads->find('all')->where(['Feesheads.id'=>'7'])->first()->toarray();

$this->set('admissionfee',$nj['ibdp_fee']);

$njde=$this->Feesheads->find('all')->where(['Feesheads.id'=>'3'])->first()->toarray();

$this->set('devlopfee',$njde['ibdp_fee']);

$njcaution=$this->Feesheads->find('all')->where(['Feesheads.id'=>'4'])->first()->toarray();

$this->set('cautionfee',$njcaution['cbse_fee']);
	
}


$brhy = $this->Boards->find('all')->order(['Boards.id' => 'DESC'])->where(['Boards.id'=>$rt])->first()->toarray();

$this->set('brd',$brhy);

}
	public function discount($id = null){
	
	
$discountCategorylist = $this->DiscountCategory->find('all', [
			'keyField' => 'discount',
			'valueField' => 'name'
			])->where(['status' => 'Y','type'=>'0'])->order(['id' => 'ASC'])->toArray();
		$this->set('discountCategorylist',$discountCategorylist);
		if(isset($id) && !empty($id)){
			$this->set('ids',$id); 
			$discount = $this->Students->get($id); 
			$acedemic=$discount->acedmicyear;
			$h_id=$discount->h_id;
			$discountcategory_id=$discount->discountcategory;
			$this->set('acedemic', $acedemic);  
			$this->set('h_id', $h_id);  
			$this->set('discountcategory', $discountcategory_id);  
		}
		else {
			$discount = $this->Students->newEntity();
		}	
		if ($this->request->is(['post', 'put'])) {

			$this->request->data['is_discount']=1;
			
			$dcategory=$this->request->data['discountcategory'];
 		//pr($this->request->data); die;
				// save all data in database
				$this->request->data['discountcategory']=$dcategory;
				
			$discount = $this->Students->patchEntity($discount, $this->request->data);
			if ($this->Students->save($discount)) {
				$this->Flash->success(__('Discount Added Successfully.'));
				return $this->redirect(['controller' => 'studentfees','action' => 'view']);	
			}

		}
		$this->set('discount', $discount);   


	}

public function applicant_recipt_delete($id){ 
	$this->loadModel('Boards');
	$this->loadModel('Applicant');
	$this->loadModel('Students');
	$this->loadModel('Users');
	
	
	
	

$classes_data = $this->Applicant->find('all')->where(['Applicant.id'=>$id])->first();


$student_data = $this->Students->find('all')->where(['Students.formno' =>$classes_data['sno'],'Students.status'=>'Y'])->first();

if($student_data['id']){

	$this->Flash->error(__("Form no is already associated with Admission."));
return $this->redirect(['action' => 'approvedprospect']);

}else{


  $conn = ConnectionManager::get('default');
 

$conn->execute("DELETE FROM applicants WHERE id='".$id."'");
$this->Flash->success(__("Register Student has been delete sucessfully."));

return $this->redirect(['action' => 'approvedprospect']);
}



die;
//pr($classes_data); die;

}

//status update functionality
	public function applicant_status($id,$status){
		
		
		if(isset($id) && !empty($id)){
		if($status == 'Y'){
			
			  $status = 'Y';
			//status update
				$enquires = $this->Applicant->get($id);
						    $conn = ConnectionManager::get('default'); 
                  
                     $formno=$enquires->sno;
                $recipietno=$enquires->recipietno;
              $conn->execute("update student_feeallocations set status='$status' where recipetno='$recipietno' and formno='$formno'"); 
				
				$enquires->status_c = $status;
				if ($this->Applicant->save($enquires)) {
					$this->Flash->success(__('Your Applicant status has been Deactivated.'));
					return $this->redirect(['controller'=>'report','action' => 'prospect']);	
				}
		}else{
				$status = 'N';
			//status update
			$enquires = $this->Applicant->get($id);
			
			 $conn = ConnectionManager::get('default'); 
                  
                     $formno=$enquires->sno;
                $recipietno=$enquires->recipietno;
              $conn->execute("update student_feeallocations set status='$status' where recipetno='$recipietno' and formno='$formno'"); 
		
			$enquires->status_c = $status;
			if ($this->Applicant->save($enquires)) {
				
				$this->Flash->success(__('Your Applicant status has been Activated.'));
				return $this->redirect(['controller'=>'report','action' => 'prospect']);	
			}
			
			}
		}

	}



	public function applicant_recipt($id){ 
	$this->loadModel('Boards');
	$this->loadModel('Applicant');
	$this->loadModel('Feesheads');
	$this->loadModel('Users');
	$this->sitesetting('receipt');
$classes_data = $this->Applicant->find('all')->contain(['Enquires'])->order(['Applicant.id' => 'DESC'])->where(['Applicant.id'=>$id])->first();

//pr($classes_data); die;



$this->set('recipt',$classes_data);

$discountCategorylist = $this->DiscountCategory->find('all', [
			'keyField' => 'discount',
			'valueField' => 'name'
			])->where(['status' => 'Y','type'=>'0'])->order(['id' => 'ASC'])->toArray();
		$this->set('discountCategorylist',$discountCategorylist);

$cid=$classes_data['class_id'];








$clas = $this->Classes->find('all')->select(['title'])->where(['Classes.id' =>$cid])->first();
$this->set('clas',$clas);
$rt=$classes_data['enquire']['mode1_id'];

$user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$acedmicyear=$user['academic_year'];
		
$this->set('acedmicyear',$acedmicyear);



if($rt=='1'){
	
	$nj=$this->Feesheads->find('all')->where(['Feesheads.id'=>'8'])->first()->toarray();

$this->set('regisfee',$nj['cbse_fee']);




	
}else if($rt=='2'){
	
	$nj=$this->Feesheads->find('all')->where(['Feesheads.id'=>'8'])->first()->toarray();

$this->set('regisfee',$nj['cambridge_fee']);


	
}else if($rt=='3'){
	
	$nj=$this->Feesheads->find('all')->where(['Feesheads.id'=>'8'])->first()->toarray();

$this->set('regisfee',$nj['ibdp_fee']);

	
}







$brhy = $this->Boards->find('all')->order(['Boards.id' => 'DESC'])->where(['Boards.id'=>$rt])->first();

$this->set('brd',$brhy);

}


	public function approvedprospect(){
		$this->loadModel('Boards');
		$this->loadModel('Applicant');
		$this->viewBuilder()->layout('admin');
		
			$rolepresent=$this->request->session()->read('Auth.User.role_id');					
if($rolepresent=='1'){ 
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='5'){ 
	
	
		$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id <=' =>'22'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='8'){ 
	
	
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id >=' =>'23'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}


        
if($rolepresent=='1'){ 
		$brhy = $this->Boards->find('list', ['keyField' =>'id','valueField' => 'name'])->toArray();

$this->set('bord',$brhy);

}else if($rolepresent=='5'){
	
	$brhy = $this->Boards->find('list', ['keyField' =>'id','valueField' => 'name'])->where(['Boards.id' =>'1'])->toArray();

$this->set('bord',$brhy);
	
	
}else if($rolepresent=='8'){
	
	$brhy = $this->Boards->find('list', ['keyField' =>'id','valueField' => 'name'])->where(['Boards.id IN' =>['2','3']])->toArray();

$this->set('bord',$brhy);
	
	
} 
		
		
		
		
		
		$rolepresent=$this->request->session()->read('Auth.User.role_id');
	if($rolepresent=='5'){ 

	
	$t_enquiry = $this->Applicant->find('all')->where(['Applicant.status' =>'Y','Enquires.class_id <='=>'22'])->contain(['Enquires'])->toarray();
		
		$this->set(compact('t_enquiry'));

}else if($rolepresent=='8'){ 

		$t_enquiry = $this->Applicant->find('all')->where(['Applicant.status' =>'Y','Enquires.class_id >='=>'23'])->contain(['Enquires'])->toarray();
		
		$this->set(compact('t_enquiry'));
	
}else{
	
		$t_enquiry = $this->Applicant->find('all')->where(['Applicant.status' =>'Y'])->contain(['Enquires'])->toarray();
		
		$this->set(compact('t_enquiry'));

}
	}

	public function rejectprospect(){
		$this->loadModel('Boards');
		$this->loadModel('Applicant');
		$this->viewBuilder()->layout('admin');
		
					$rolepresent=$this->request->session()->read('Auth.User.role_id');					
if($rolepresent=='1'){ 
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.id' => 'asc'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='5'){ 
	
	
		$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id <=' =>'22'])->order(['Classes.id' => 'asc'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='8'){ 
	
	
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id >=' =>'23'])->order(['Classes.id' => 'asc'])->toArray();
	$this->set('classes', $classes);
	
}


if($rolepresent=='1'){ 
		$brhy = $this->Boards->find('list', ['keyField' =>'id','valueField' => 'name'])->toArray();

$this->set('bord',$brhy);

}else if($rolepresent=='5'){
	
	$brhy = $this->Boards->find('list', ['keyField' =>'id','valueField' => 'name'])->where(['Boards.id' =>'1'])->toArray();

$this->set('bord',$brhy);
	
	
}else if($rolepresent=='8'){
	
	$brhy = $this->Boards->find('list', ['keyField' =>'id','valueField' => 'name'])->where(['Boards.id IN' =>['2','3']])->toArray();

$this->set('bord',$brhy);
	
	
} 
		

	if($rolepresent=='5'){ 

	
	$rej_appli = $this->Applicant->find('all')->where(['Applicant.status_r' =>'Y','Enquires.class_id <='=>'22'])->contain(['Enquires'])->toarray();
		
		$this->set(compact('rej_appli'));
		
		


}else if($rolepresent=='8'){ 

		$rej_appli = $this->Applicant->find('all')->where(['Applicant.status_r' =>'Y','Enquires.class_id >='=>'23'])->contain(['Enquires'])->toarray();
		
		$this->set(compact('rej_appli'));
		

	
}else{
	
		
		$rej_appli = $this->Applicant->find('all')->where(['Applicant.status_r' =>'Y'])->contain(['Enquires'])->toarray();
		
		$this->set(compact('rej_appli'));

}
		
		
		
		
		
		
		
		
		
		
		
		
	}

public function prosapproval(){
//pr($this->request->data);die;
$romm=sizeof($this->request->data['p_id']);
	for($i=0;$i<$romm;$i++)
	{
		   			$conn = ConnectionManager::get('default');
					$pros=$this->request->data['p_id'][$i];
					$st="Y";
					$st1="N";
					$detail1='UPDATE `applicants` SET `status` ="'.$st.'",`status_r` ="'.$st1.'" WHERE `applicants`.`sno` = "'.$pros.'"';
				//	echo $detail1; die;
						$results2 = $conn->execute($detail1);
					}

return $this->redirect(['action' => 'approvedprospect']);
}
public function findacdemicbck(){
	$query=$this->request->data['query'];
	$rolepresent=$this->request->session()->read('Auth.User.role_id');

if($rolepresent=='5'){ 

	if($query=='1'){ 
		 $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	
		  	
		  	
			$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
		  $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' =>'1'])->first();
		  
		  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' =>'1','Enquires.class_id <='=>'22'])->contain(['Enquires'])->first();
		  	  
		  	 // $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']); 
		  	
	  $c = $student_datasmaxss['amount'];
	  
  }
  
  
  if($query=='2'){ 
	
	
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
	$boardzs=['2','3'];
	
		$student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		
		
			$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
			$student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs])->first();
			
					  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs,'Enquires.class_id >='=>'23'])->contain(['Enquires'])->first();
		  	//  $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']);	
		
	  $c = $student_datasmaxss['amount'];
}
$recipietno=$c+1;
}else if($rolepresent=='8'){ 

	if($query=='2'){ 
		 $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	
		  	
		  	
			$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
		  $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' =>'1'])->first();
		  
		  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' =>'1','Enquires.class_id <='=>'22'])->contain(['Enquires'])->first();
		  	  
		  	 // $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']); 
		  	
	  $c = $student_datasmaxss['amount'];
	  
  }
  
  
  if($query=='1'){ 
	
	
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
	$boardzs=['2','3'];
	
		$student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		
		
			$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
			$student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs])->first();
			
					  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs,'Enquires.class_id >='=>'23'])->contain(['Enquires'])->first();
		  	//  $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']);	
		
	  $c = $student_datasmaxss['amount'];
}
$recipietno=$c+1;
}

echo $recipietno; die;
}

	public function applicant_add(){
		
		$this->loadModel('Applicant');
		$this->loadModel('Enquires');
		$this->loadModel('Feesheads');
		$this->loadModel('Studentfees');
		$this->loadModel('Guardians');
$this->viewBuilder()->layout('admin');

$rolepresent=$this->request->session()->read('Auth.User.role_id');

$acd= $this->academicyear();
				$this->set(compact('acd'));
				$rolepresentyear= $this->currentacademicyear();
				$this->set(compact('rolepresentyear'));
if($rolepresent=='1'){ 
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
		 $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	
		  	
			$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
		  	
		  	
		  $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' =>'1'])->first();
		  
		  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' =>'1','Enquires.class_id <='=>'22'])->contain(['Enquires'])->first();
		  	  
		 //   $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']); 
		   $c = $student_datasmaxss['amount'];
		  	
}else if($rolepresent=='5'){ 
		 $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	
		  	
		  	
			$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
		  $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' =>'1'])->first();
		  
		  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' =>'1','Enquires.class_id <='=>'22'])->contain(['Enquires'])->first();
		  	  
		  	 // $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']); 
		  	
	  $c = $student_datasmaxss['amount'];
	
		$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='8'){ 
	
	
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
	$boardzs=['2','3'];
	
		$student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		
		
			$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
			$student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs])->first();
			
					  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs,'Enquires.class_id >='=>'23'])->contain(['Enquires'])->first();
		  	//  $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']);	
		
	  $c = $student_datasmaxss['amount'];
}
$recipietno=$c+1;
$this->set('recipietno', $recipietno);
if($this->request->is('post')){
	

 $fomno=$this->request->data['sno'];
 $category=$this->request->data['category'];

 $bord = $this->Enquires->find('all')->where(['Enquires.formno' =>$fomno])->select(['mode1_id'])->first();
 $bid=$bord['mode1_id'];
 
 $fees=$this->Feesheads->find('all')->where(['Feesheads.id' =>'8'])->first();
 // pr($fees); die;
  $cbse=$fees['cbse_fee'];
    $camb=$fees['cambridge_fee'];
      $ibd=$fees['ibdp_fee'];
 if($category=="Migration"){
	if($this->request->data['class_id']<=22){
		$this->request->data['reg_fee']=$cbse;
		
		
	}else if($this->request->data['class_id']=='26' || $this->request->data['class_id']=='27'){
		$this->request->data['reg_fee']=$ibd;
	}else{
		  	$this->request->data['reg_fee']=$camb;
		
	}
	
}else{
// pr($bid); die;
 
    if($this->request->data['class_id']<=22){
		$this->request->data['reg_fee']=$cbse;
		
		
	}else if($this->request->data['class_id']=='26' || $this->request->data['class_id']=='27'){
		$this->request->data['reg_fee']=$ibd;
	}else{
		  	$this->request->data['reg_fee']=$camb;
		
	}

}
 $gallery=$this->request->data['image'];
 $filename=$gallery['name'];
  $ext=  end(explode('.', $filename));
					  $name = md5(time($filename));
					  $imagename=trim($name.'stu.'.$ext," ");
					  
					    if(move_uploaded_file($gallery['tmp_name'],"stu/". $imagename))

						{
							
							$this->request->data['image']=$imagename;
						      
					       }
					      
					 	 //pr($this->request->data); die;

			  
	

	$rtf=explode('/',$this->request->data['dob']);
	
$this->request->data['dob']=$rtf[2].'-'.$rtf[1].'-'.$rtf[0];
$this->request->data['created']=date('Y-m-d');
   $rolepresentss=$this->request->session()->read('Auth.User.role_id');
   
   if($category=="Migration"){
	   
	 $this->request->data['recipietno']=$this->request->data['recipietno']; 
   }else{ 
		 if($rolepresentss=='5'){ 
	 $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	
		  	
		  	
			$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
		  $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' =>'1'])->first();
		  
		  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' =>'1','Enquires.class_id <='=>'22'])->contain(['Enquires'])->first();
		  	  
		  	//  $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']); 
		  	  $c = $student_datasmaxss['amount'];
	
}else if($rolepresentss=='8'){ 
	
	$boardzs=['2','3'];
	
		$student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		
		
			$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
		
			$student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs])->first();
			
					  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs,'Enquires.class_id >='=>'23'])->contain(['Enquires'])->first();
		  	//  $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']);	
		  $c = $student_datasmaxss['amount'];
		
		  
	
}

$this->request->data['recipietno']=$c+1;

}
	 
  $Applicant = $this->Applicant->newEntity();

$Applicant = $this->Applicant->patchEntity($Applicant, $this->request->data);

$result= $this->Applicant->save($Applicant);
if ($this->Applicant->save($Applicant)) {
	
	
	 $peopleTableshh = TableRegistry::get ('Studentfees');
$oQueryshh = $peopleTableshh->query ();

if($this->request->data['class_id']<=22){
	 $stidd='6342';
		
		
	}else if($this->request->data['class_id']=='26' || $this->request->data['class_id']=='27'){
		$stidd='333333'; 
	}else{
		  $stidd='333333'; 
		
	}


	
$str2='a:1:{s:16:"Registration Fee";d:'.$this->request->data['reg_fee'].';}';
 $oQueryshh->insert (['student_id','paydate','quarter','mode','formno','type','recipetno','bank','cheque_no','addtionaldiscount','deposite_amt','fee','ref_no','discount','status','acedmicyear','discountcategory','remarks'])
        ->values ([
        'student_id' =>$stidd,'paydate' => date('Y-m-d',strtotime($this->request->data['created'])),'quarter'=>$str2,'mode'=>'CASH','formno'=>$this->request->data['sno'],'type'=>'Registration','recipetno'=>$this->request->data['recipietno'],'bank'=>'','cheque_no'=>'0','addtionaldiscount'=>'0.00','deposite_amt'=>$this->request->data['reg_fee'],'fee'=>$this->request->data['reg_fee'],'ref_no'=>'0','discount'=>'0.00','status'=>'Y','acedmicyear'=>$this->request->data['acedmicyear'],'discountcategory'=>'','remarks'=>'Registration Fee']); 
        $oQueryshh->execute ();
	$id = $result->id;
	
	
	$Applicant = $this->Guardians->newEntity();
$this->request->data['applicant_id']=$id;
$Applicant = $this->Guardians->patchEntity($Applicant, $this->request->data);

$this->Guardians->save($Applicant);

 
	$this->request->session()->delete('openreg_recipt');
					$this->request->session()->write('openreg_recipt', $id);
	return $this->redirect(['controller' => 'Report','action' => 'prospect']);

	}
}
	}
	
	
	
	public function applicant_edit($id){
		
		$this->loadModel('Applicant');
		$this->loadModel('Enquires');
		$this->loadModel('Feesheads');
		$this->loadModel('Studentfees');
$this->viewBuilder()->layout('admin');
$acd= $this->academicyear();
				$this->set(compact('acd'));
$rolepresent=$this->request->session()->read('Auth.User.role_id');




if($rolepresent=='1'){ 
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
		
		  	
}else if($rolepresent=='5'){ 
		
		$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='8'){ 
	
	
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
	
	
}

	if(isset($id) && !empty($id)){
			//using for edit
		     $applicant = $this->Applicant->get($id);
		     $guardians = $this->Guardians->find('all')->where(['Guardians.applicant_id'=>$id])->order(['Guardians.id' => 'DESC'])->first();
		     		     $this->set('guardians', $guardians);
		     $gid=$guardians['id'];
		     if($guardians){
		     $guardian = $this->Guardians->get($gid);
		 }
//pr($bord); die;
		     
		     $this->set('ids', $id);
                // pr($classes); die;
		}
$this->set('applicant', $applicant);
if($this->request->is('post')  || $this->request->is('put')){
if($this->request->data['category']=="Migration"){
	
	if($this->request->data['class_id']<=22){
	
	 $mode1_id='1';
		
		
	}else if($this->request->data['class_id']=='26' || $this->request->data['class_id']=='27'){
			 $mode1_id='3';
	}else{
		$mode1_id='2';
		
	}
	$class=$this->request->data['class_id'];
	$sno=$this->request->data['sno'];
	 $conn = ConnectionManager::get('default'); 

                     $conn->execute("update enquires set mode1_id='$mode1_id',class_id='$class' where formno='$sno'"); 
	
}
					      
					 
$rtf=explode('/',$this->request->data['dob']);
$this->request->data['dob']=$rtf[2].'-'.$rtf[1].'-'.$rtf[0];
//$this->request->data['created']=date('Y-m-d');
$Applicant = $this->Applicant->patchEntity($applicant, $this->request->data);




$result= $this->Applicant->save($applicant);
if ($result) {
	$id = $result->id;
	 if($guardian){
	$Guardians = $this->Guardians->patchEntity($guardian, $this->request->data);
	$this->Guardians->save($Guardians);
}else{
$guardian = $this->Guardians->newEntity();
$this->request->data['applicant_id']=$id;
		$Guardians = $this->Guardians->patchEntity($guardian, $this->request->data);
	$this->Guardians->save($Guardians);
}
	
	
	$this->request->session()->delete('openreg_recipt');
					$this->request->session()->write('openreg_recipt', $id);
	return $this->redirect(['controller' => 'Report','action' => 'prospect']);

	}
}
	}
	
	

	public function tasksearch(){
						$this->loadModel('Applicant');	
						$this->loadModel('Enquires');
						$this->loadModel('Users');
						
						$radioValue=$this->request->data['radioValue'];
						$prosuper=$this->request->data['fetch'];
						//pr($prosuper); die;
					
						$userTable = TableRegistry::get('Applicant');
			$exists = $userTable->exists(['sno' => $prosuper]);
						if($exists){
							echo 1; die;
						}else{
						
						$rolepresent=$this->request->session()->read('Auth.User.role_id');

//~ if($radioValue=='NORMAL'){
if($rolepresent=='5'){ 
 $mode1_id=('1'); 
  }else if($rolepresent=='8'){ 
  
   $mode1_id=('2,3'); 
   
   }else{ 
   
    $mode1_id=('1,2,3');  
    }
							
	//~ }else if($radioValue=='Migration'){
		//~ if($rolepresent=='5'){ 
   //~ $mode1_id=('2,3');
  //~ }else if($rolepresent=='8'){ 
  
 
    //~ $mode1_id=('1'); 
   
   //~ }
		
	//~ }	
			
		$user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$rolepresent=$user['academic_year'];
					//	$rolepresent=$this->request->session()->read('Auth.User.academic_year');

						//$companyrcd=$this->Enquires->find('all')->where($pii)->toarray();
						$conn = ConnectionManager::get('default');
						$detail="SELECT * FROM `enquires` WHERE formno ='$prosuper' AND status='Y' AND mode1_id IN ($mode1_id)";

						$results = $conn->execute($detail)->fetchAll('assoc');
						
						
							$conn = ConnectionManager::get('default');
							$feesub=$results[0]["fee_submittedby"];
							$mob=$results[0]["mobile"];
						$details="SELECT * FROM `applicants` WHERE f_name ='$feesub' AND f_phone ='$mob'";

						$resultss = $conn->execute($details)->fetchAll('assoc');
						
						
						$d=explode(' ',$results[0]['s_name']);
						
						if($d[0]==''){
							$d[0]='';
							
						}else if($d[1]==''){
							$d[1]='';
							
						}else if($d[2]==''){
							$d[2]='';
							
						}
						if(empty($results)){
							echo 0; die;
						}else if($results){
						
							echo $d[0].','.$results[0]['class_id'].','.$results[0]['mobile'],','.$results[0]['fee_submittedby'],','.$results[0]['fee_submittedby'],','.$d[1],','.$resultss[0]['mother_tounge'],','.$resultss[0]['f_qualification'],','.$resultss[0]['f_occupation'],','.$resultss[0]['m_name'],','.$resultss[0]['m_qualification'],','.$resultss[0]['m_occupation'],','.$resultss[0]['m_phone'],','.$resultss[0]['m_qualification'],','.$resultss[0]['pob'],','.$d[2],','.$results[0]['acedmicyear'];  die;
						}else if($resultss){
							
											echo $resultss[0]['fname'].','.$results[0]['class_id'].','.$results[0]['mobile'],','.$results[0]['fee_submittedby'],','.$results[0]['fee_submittedby'],','.$resultss[0]['middlename '],','.$resultss[0]['mother_tounge'],','.$resultss[0]['f_qualification'],','.$resultss[0]['f_occupation'],','.$resultss[0]['m_name'],','.$resultss[0]['m_qualification'],','.$resultss[0]['m_occupation'],','.$resultss[0]['m_phone'],','.$resultss[0]['m_qualification'],','.$resultss[0]['pob'],','.$resultss[0]['lname '],','.$resultss[0]['acedmicyear'];  die;
							
							
						}
						}
								
						}

public function findsections(){
$this->loadModel('Applicant');
$bid=$this->request->data['id'];
$fieln=$this->request->data['fieln'];
$bord = $this->Applicant->find('all')->where(['Applicant.sno'=>$bid])->order(['Applicant.id' => 'DESC'])->first();
//pr($bord); die;
$string =$bord[$fieln]; 
echo $string; die;

						}
public function findphoneno(){
$this->loadModel('Applicant');
$bid=$this->request->data['id'];
$fieln=$this->request->data['fieln'];
$bord = $this->Applicant->find('all')->where(['Applicant.sno'=>$bid])->order(['Applicant.id' => 'DESC'])->first();
//pr($bord); die;
$string =$bord[$fieln]; 

if($string){
echo $string; die;

}else{
	
	echo 0; die;
	
}

						}
						
						public function findphonenos(){
$this->loadModel('Applicant');
$bid=$this->request->data['id'];
$bsid=$this->request->data['bid'];
$fieln=$this->request->data['fieln'];
$bord = $this->Students->find('all')->where(['Students.id'=>$bid,'Students.board_id'=>$bsid])->order(['Students.id' => 'DESC'])->first();
//pr($bord); die;
$string =$bord[$fieln]; 

if($string){
echo $string; die;

}else{
	
	echo 0; die;
	
}

						}
						
						public function findfeesubmittedby(){
							
				$bid=$this->request->data['id'];
$fieln=$this->request->data['fieln'];
	$bord = $this->Students->find('all')->where(['Students.id'=>$bid,'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->first();
if($fieln=="f_sub"){
	$string=$bord['fathername'];

}elseif($fieln=="m_sub"){
	$string=$bord['mothername'];
}else{
		$string=$bord['fee_submittedby'];
	
}

if($string){
echo $string; die;

}else{
	
	echo 0; die;
	
}
							
						}
public function findboard(){
$this->loadModel('Students');
$bid=$this->request->data['id'];
$bord = $this->Students->find('all')->select(['enroll'])->where(['Students.board_id'=>$bid,'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->first();
//pr($bord); die;
$string =$bord['enroll']; 
//echo $string; die;
$number = preg_replace("/[^0-9]/", '', $string);
$f=$number+1;
if($bid==3){

echo $f; die;
}else if($bid==1){
	echo $f; die;
}else{
	echo $f; die;
}
						}
						
						
						
public function studentsearch2(){
					$this->loadModel('Enquires');
						$this->loadModel('Students');
						$prosuper=$this->request->data['fetch'];
						$board=$this->request->data['board'];
						
						 $user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$rolepresent=$user['academic_year'];
						
					
$rolepresent=$this->request->session()->read('Auth.User.role_id');


if($rolepresent=='5'){ 
 $mode1_id=['1']; 
  }else if($rolepresent=='8'){ 
  
   $mode1_id=['2','3']; 
   
   }else{ 
   
    $mode1_id=['1','2','3'];  
    }
			if($board=='1'){		
$bord = $this->Students->find('all')->where(['Students.board_id 
in'=>'1','Students.enroll'=>$prosuper,'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->first();
			$bord['image']=$prosuper.".JPG";			
				}else if($board=='2' || $board=='3'){
					
$bord = $this->Students->find('all')->where(['Students.board_id IN'=>['2','3'],'Students.enroll'=>$prosuper,'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->first();
		
		 if($board=='2'){
		$bord['image']="CAM".$prosuper.".JPG";			
		
	}else{
		
	$bord['image']="IB".$prosuper.".JPG";			
	}	
					
					
				}		
if($bord['id']){

							echo  SITE_URL .'webroot/stu/'. 
							$bord['image'].','.$bord['fname'].','.$bord['middlename'].','.$bord['lname'].','.$bord['class_id'].','.$date.','.$bord['fathername'].','.$bord['mothername'].','.$bord['mobile'].','.$results[0]['acedmicyear'].','.$board.','.$bord['sms_mobile'].','.$bord['section_id'].','.$bord['section_id'].','.$bord['h_id'].','.$bord['h_id'].','.$bord['class_id'].','.$bord['class_id'].','.$bord['gender'].','.date('Y-m-d',strtotime($bord['dob'])).','.$bord['mother_tounge'].','.$bord['f_qualification'].','.$bord['f_occupation'].','.$bord['m_qualification'].','.$bord['m_occupation'].','.$bord['m_phone'].','.$bord['f_phone'].'&'.$bord['address'];  die;
						}else{
							
							echo 0; die;
							
						}	
							
							
						
								
						}						

public function studentsearch(){
					$this->loadModel('Enquires');
						$this->loadModel('Applicant');
						$prosuper=$this->request->data['fetch'];
						$min=0;
						$min2=0;
						$a='';
						$b='';
						 $user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$rolepresent=$user['academic_year'];
						
						//$companyrcd=$this->Enquires->find('all')->where($pii)->toarray();
						$conn = ConnectionManager::get('default');
						$detail="SELECT * FROM `applicants` WHERE sno = '$prosuper'";

						$results = $conn->execute($detail)->fetchAll('assoc');
						//pr($results); die;
$rolepresent=$this->request->session()->read('Auth.User.role_id');


if($rolepresent=='5'){ 
 $mode1_id=['1']; 
  }else if($rolepresent=='8'){ 
  
   $mode1_id=['2','3']; 
   
   }else{ 
   
    $mode1_id=['1','2','3'];  
    }
					
						
						if(empty($results)){
							echo 0; die;
						}else if($results[0]['image']==''){
							$id=$results[0]['sno'];
	$enqiur1 = $this->Enquires->find('all')->select(['mode1_id'])->where(['Enquires.formno'=>$id,'Enquires.mode1_id IN'=>$mode1_id])->first();
	if($enqiur1['mode1_id']){
						
							$date=$results[0]['dob'];
							$fee_submittedby=$results[0]['fee_submittedby'];
							$bord=$enqiur1['mode1_id'];

						$gh=date('Y,m,d', strtotime($date));
							$articles = TableRegistry::get('Students');
						$studentsection = $articles->find('all')->group('Students.section_id')->select(['tocoun' =>  $articles->find()->func()->count('Students.id'),'Students.section_id'])->where(['Students.class_id'=>$results[0]['class_id'],'Students.status'=>'Y'])->toarray(); 
					//	pr( $studentsection); die;
						foreach($studentsection as $kl=>$iyu){
								 $numbers[] = $iyu['tocoun'];
							}
						
							$min = min($numbers);
						
						

foreach($studentsection as $j=>$h){
	
	if($h['tocoun']==$min){
		$a=$h['section_id'];
		
	}
	
	
}



$classes = $this->Classes->find('all')->select(['id', 'title'])->where(['id' => $results[0]['class_id']])->order(['title' => 'ASC'])->toArray();
	$sections = $this->Sections->find('all')->select(['id', 'title'])->where(['id' => $a])->order(['title' => 'ASC'])->toArray();
		
		
		$studentsectionhid = $articles->find('all')->group('Students.h_id')->select(['tocouns' =>  $articles->find()->func()->count('Students.id'),'Students.h_id'])->where(['Students.class_id'=>$results[0]['class_id'],'Students.section_id'=>$sections[0]['id'],'Students.status'=>'Y'])->toarray();
								foreach($studentsectionhid as $kl=>$iyu){
								 $numberss[] = $iyu['tocouns'];
							}
							//	pr($studentsectionhid);
								
								 $min2 = min($numberss);
						
					

foreach($studentsectionhid as $s=>$k){
	
	if($k['tocouns']==$min2){
		$b=$k['h_id'];
		
	}
	
	
}



	$houses = $this->Houses->find('all')->select(['id', 'name'])->where(['id' => $b])->order(['id' => 'ASC'])->toArray();
		
		

							echo  
							'r'.','.$results[0]['fname'].','.$results[0]['middlename'].','.$results[0]['lname'].','.$results[0]['class_id'].','.$date.','.$results[0]['f_name'].','.$results[0]['m_name'].','.$results[0]['f_phone'].','.$results[0]['acedmicyear'].','.$bord.','.$results[0]['f_phone'].','.$sections[0]['id'].','.$sections[0]['title'].','.$houses[0]['id'].','.$houses[0]['name'].','.$classes[0]['id'].','.$classes[0]['title'].','.$results[0]['gender'].','.$results[0]['mother_tounge'].','.$results[0]['f_qualification'].','.$results[0]['f_occupation'].','.$results[0]['m_qualification'].','.$results[0]['m_occupation'].','.$results[0]['m_phone'].','.$results[0]['f_phone'];  die;
}else{


echo '0'; die;
}
						}else{
							//pr($results);  die;
							$id=$results[0]['sno'];
						$enqiur1 = $this->Enquires->find('all')->select(['mode1_id'])->where(['Enquires.formno'=>$id,'Enquires.mode1_id IN'=>$mode1_id])->first();
						
						if($enqiur1['mode1_id']){
						
						//pr($enqiur1); die;
							$articles = TableRegistry::get('Students');
						$studentsection = $articles->find('all')->group('Students.section_id')->select(['tocoun' =>  $articles->find()->func()->count('Students.id'),'Students.section_id'])->where(['Students.class_id'=>$results[0]['class_id'],'Students.status'=>'Y'])->toarray();
								foreach($studentsection as $kl=>$iyu){
								 $numbers[] = $iyu['tocoun'];
							}
								
						
				
							$min = min($numbers);
						
					

foreach($studentsection as $j=>$h){
	
	if($h['tocoun']==$min){
		$a=$h['section_id'];
		
	}
	
	
}
$classes = $this->Classes->find('all')->select(['id', 'title'])->where(['id' => $results[0]['class_id']])->order(['title' => 'ASC'])->toArray();
	
$sections = $this->Sections->find('all')->select(['id', 'title'])->where(['id' => $a])->order(['title' => 'ASC'])->toArray();
		
		
		$studentsectionhid = $articles->find('all')->group('Students.h_id')->select(['tocouns' =>  $articles->find()->func()->count('Students.id'),'Students.h_id'])->where(['Students.class_id'=>$results[0]['class_id'],'Students.section_id'=>$sections[0]['id'],'Students.status'=>'Y'])->toarray();
									foreach($studentsectionhid as $kl=>$iyu){
								 $numberss[] = $iyu['tocouns'];
							}
								
								
								$min2 = min($numberss);
						
					

foreach($studentsectionhid as $s=>$k){
	
	if($k['tocouns']==$min2){
		$b=$k['h_id'];
		
	}
	
	
}




	$houses = $this->Houses->find('all')->select(['id', 'name'])->where(['id' => $b])->order(['id' => 'ASC'])->toArray();
								$fee_submittedby=$results[0]['fee_submittedby'];
							$date=$results[0]['dob'];
							$bord=$enqiur1['mode1_id'];

						$gh=date('Y,m,d', strtotime($date));
						


							echo  SITE_URL .'webroot/stu/'. $results[0]['image'].','.$results[0]['fname'].','.$results[0]['middlename'].','.$results[0]['lname'].','.$results[0]['class_id'].','.$date.','.$results[0]['f_name'].','.$results[0]['m_name'].','.$results[0]['f_phone'].','.$results[0]['acedmicyear'].','.$bord.','.$results[0]['f_phone'].','.$sections[0]['id'].','.$sections[0]['title'].','.$houses[0]['id'].','.$houses[0]['name'].','.$classes[0]['id'].','.$classes[0]['title'].','.$results[0]['gender'].','.$results[0]['mother_tounge'].','.$results[0]['f_qualification'].','.$results[0]['f_occupation'].','.$results[0]['m_qualification'].','.$results[0]['m_occupation'].','.$results[0]['m_phone'].','.$results[0]['f_phone'];  die;
							
							
							}else{


echo '0'; die;
}
						}
						
								
						}

						public function formsearch(){
							$this->loadModel('Applicant');
						$this->loadModel('Enquires');
						$juop=$this->request->data['fetch'];
						
						

						//$companyrcd=$this->Enquires->find('all')->where($pii)->toarray();
						$conn = ConnectionManager::get('default');
						$detail="SELECT * FROM `applicants` WHERE sno LIKE '$juop%' AND `status`='Y'";

						$results = $conn->execute($detail)->fetchAll('assoc');
						
						
						//pr($results); die;
						
							if(count($results)>0){
						foreach($results as $value){ //pr($value);die;
				
					
						 echo '<li onclick="cllbckp('."'".$value['sno']."'".','."'".$value['sno']."'".')"><a href="#">'.$value['sno'].'</a></li>';
						}
						
					}else{
						
						
					}
						die;	
						}


						public function ser1(){
							
						$this->loadModel('Enquires');
						$pro=$this->request->data['fetch'];
						
						$enqiur = $this->Enquires->find('all')->select(['s_name', 'class_id'])->order(['Enquires.id' => 'DESC'])->where(['Enquires.id'=>$pro])->toarray();
						echo $enqiur[0]['s_name'].','.$enqiur[0]['class_id'] ; die;
						

							
						}

						public function ser2(){
							
						$this->loadModel('Applicant');
						$pro1=$this->request->data['fetch'];
						
						$enqiur = $this->Applicant->find('all')->order(['Applicant.id' => 'DESC'])->where(['Applicant.sno'=>$pro1])->first()->toarray();
						//pr($enqiur); die;
					$hi=explode(' ',$enqiur['name']);
					
						echo  ($hi['0']).','.$enqiur['class_id'] ; die;
						
						

							
						}


	public function approveprospectsearch(){
		$this->loadModel('Applicant');
		$conn = ConnectionManager::get('default');
		//pr($this->request->data); die;
		$from=date('Y-m-d',strtotime($this->request->data['from']));
		$to=date('Y-m-d',strtotime($this->request->data['to'].'+1 days'));
		$bid=$this->request->data['b_id'];
		$class_id=$this->request->data['class_id'];
		$name=$this->request->data['name'];
		
$apk=array();

		if(!empty($from) && $from!='1970-01-01 00:00:00')
{
$stts=array('Enquires.created >=' =>$from);
$apk[]=$stts;
}
 

if(!empty($to) && $to!='1970-01-01 24:00:00')
{
$stst=array('Enquires.created <=' =>$to);
$apk[]=$stst;
} 

if(!empty($class_id))
{
$pii=array('Enquires.class_id'=>$class_id);
$apk[]=$pii;
}

if(!empty($bid))
{
$pii=array('Enquires.mode1_id'=>$bid);
$apk[]=$pii;
}

if(!empty($name))
{
$pii=array('Enquires.s_name LIKE'=>'%'.$name.'%');
$apk[]=$pii;
}

$classes_data = $this->Applicant->find('all')->order(['Applicant.id' => 'DESC'])->contain(['Enquires'])->where($apk)->toarray();
  //pr($classes_data); die;
$this->set('t_enquiry',$classes_data);
	}

	


	public function rejectprospectsearch(){
		$this->loadModel('Applicant');
		$conn = ConnectionManager::get('default');
		//pr($this->request->data); die;
		$from=date('Y-m-d',strtotime($this->request->data['from']));
		$to=date('Y-m-d',strtotime($this->request->data['to'].'+1 days'));
		$bid=$this->request->data['b_id'];
		$class_id=$this->request->data['class_id'];
		$name=$this->request->data['name'];
		
$apk=array();

		if(!empty($from) && $from!='1970-01-01 00:00:00')
{
$stts=array('Enquires.created >=' =>$from);
$apk[]=$stts;
}
 

if(!empty($to) && $to!='1970-01-01 24:00:00')
{
$stst=array('Enquires.created <=' =>$to);
$apk[]=$stst;
} 

if(!empty($class_id))
{
$pii=array('Enquires.class_id'=>$class_id);
$apk[]=$pii;
}

if(!empty($bid))
{
$pii=array('Enquires.mode1_id'=>$bid);
$apk[]=$pii;
}

if(!empty($name))
{
$pii=array('Enquires.s_name LIKE'=>'%'.$name.'%');
$apk[]=$pii;
}

$classes_data = $this->Applicant->find('all')->order(['Applicant.id' => 'DESC'])->contain(['Enquires'])->where($apk)->toarray();
  //pr($classes_data); die;
$this->set('t_enquiry',$classes_data);
	}

	




 public function interactionupdate(){
//pr($this->request->data); die;
$this->loadModel('Interaction');
$romm=sizeof($this->request->data['p_id']);
for($i=0;$i<$romm;$i++){
	$conn = ConnectionManager::get('default');
$y1="Y";
$pros=$this->request->data['p_id'][$i];
$detail='UPDATE `prospect_interactions` SET `status` ="'.$y1.'" WHERE `prospect_interactions`.`enquiry_id` = "'.$pros.'"';

						$results = $conn->execute($detail);

}
return $this->redirect(['action' => 'approvedprospect']);
}


 //-----------------------------------------------------------------------------------------------------------------
    public function registration_pdf($id=null)
    {
    	$this->loadModel('Interaction');
    	
    	$prospectus_data = $this->Interaction->find('all')->contain(['Enquires'])->where(['Interaction.id'=>$id])->order(['Interaction.id' => 'DESC'])->first()->toarray();
		//pr($prospectus_data); die;
		$this->set(compact('prospectus_data'));
		
		
		
    }
	


	
	public function dup_mobile(){ 
		$mobile=$this->request->data['mobile'];
		echo  $Employees =$this->Students->find('all')->where(['Students.mobile' =>$mobile,'Students.status'=>'Y'])->count();
		die;

	}		
	public function edit_dup_mobile(){ 
		$mobile=$this->request->data['mobile'];
		$e_id=$this->request->data['e_id'];
		echo  $Employees =$this->Students->find('all')->where(['Students.mobile' =>$mobile,'Students.id' =>$e_id,'Students.status'=>'Y'])->count();
		die;

	}		
	
	public function genratecard($id = null){
		$this->viewBuilder()->layout('admin');
		
		$classes = $this->Classections->find('list', [
			'keyField' => 'Classes.id',
			'valueField' => 'Classes.title'
			])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.id' => 'asc'])->toArray();
		$this->set('classes', $classes);


		$sectionslist = $this->Sections->find('list', [
			'keyField' => 'id',
			'valueField' => 'title'
			])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist',$sectionslist);
		
		
		$session = $this->request->session();
		$classs=$session->read('class');			
		$idss=$session->read('ids');			




		if($idss){

			$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id IN' => $idss,'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->toarray();
			$this->set('students',$student_data);
		}
		if($classs){
			$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.class_id' => $classs,'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->toarray();
			$this->set('students',$student_data);
		}





		
	}
	
	

	public function promote($id = null,$sec=null,$yeard=null){
		$conn = ConnectionManager::get('default');
		if($yeard){
			$yeard=$yeard; 

			$this->set('yeard', $yeard);


			$class=$id;
			$this->set('class', $id);


			$section=$sec; 
			$this->set('section', $sec);


			$detail="SELECT Students.id,Students.enroll,Students.fname,Students.category,Students.middlename,Students.lname,Students.sms_mobile,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id    WHERE  1=1 ";

			$cond = ' ';
			if(!empty($yeard))
			{

				$cond.=" AND Students.acedmicyear LIKE '".$yeard."%' ";
			}


			if(!empty($class))
			{

				$cond.=" AND Students.class_id LIKE '".$class."' ";


			}





			if(!empty($section))
			{

				$cond.=" AND Students.section_id LIKE '".$section."' ";


			}

			if(!empty($enroll))
			{

				$cond.=" AND Students.enroll LIKE '".$enroll."' ";


			}

			if(!empty($fname))
			{

				$cond.=" AND UPPER(Students.fname) LIKE '".strtoupper($fname)."%' ";


			}
			
		
         $cond.=" AND Students.status='Y'";
         $cond.=" AND Students.is_promote='0'";

			$detail = $detail.$cond;
			$SQL = $detail." ORDER BY Students.id DESC";  

			$results = $conn->execute( $SQL )->fetchAll('assoc');

			$this->set('students', $results);

		}
		
		$this->viewBuilder()->layout('admin');
		
	$rolepresent=$this->request->session()->read('Auth.User.role_id');
if($rolepresent=='1'){ 
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='5'){ 
	
	
		$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id <=' =>'22'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='8'){ 
	
	
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id >=' =>'23'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}

		$sectionslist = $this->Sections->find('list', [
			'keyField' => 'id',
			'valueField' => 'title'
			])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist',$sectionslist);
		

		
		
	}
	public function assign_transport($id = null){

		if(isset($id) && !empty($id)){
			$this->set('ids',$id);  
			$Transport = $this->Students->get($id);
			$academic=$Transport->acedmicyear;
			$this->set('acedemic', $academic);  
			$transport=$this->Transportfees->find('list', ['keyField' => 'id','valueField' => 'loc_id'])->where(['Transportfees.status'=>'Y','Transportfees.academic_year'=>$academic])->toArray();
//pr($transport); die;
/*
pr($transport); die;
 $res=array();
 foreach($transport as $key=>$value)
{
	$cur_arr=explode(',',$value);
	foreach($cur_arr as $key=>$value){
		$res[]=$value;
	}
	
}  */
$this->set(compact('transport'));
//pr($res);die;
}
else {
	$Transport = $this->Students->newEntity();
}
if ($this->request->is(['post', 'put'])) {



	$this->request->data['is_transport']=1;
 		//pr($this->request->data); die;
				// save all data in database
	$Transport = $this->Students->patchEntity($Transport, $this->request->data);
	if ($this->Students->save($Transport)) {
		$this->Flash->success(__('Transport Assign Successfully.'));
		return $this->redirect(['action' => 'index']);	
	}

}
$this->set('Transport', $Transport);    


}

public function find_vechical($id = null){
	$id=$this->request->data['id'];
//echo $id; 
	$vechical=$this->Transports->find('list', ['keyField' => 'id','valueField' => 'vechical_no'])->where(['FIND_IN_SET(\''. $id .'\',Transports.route)'])->toArray();
	foreach($vechical as $number)
	{ 
  	echo "<option value=".$number.">".$number."</option>";
	}
	die;
}  




public function assign_hostel($id = null){
	if(isset($id) && !empty($id)){

		$students = $this->Students->get($id);
		$this->set('ids',$id);
		$gender=$students->gender;
		if($gender=="Female")
		{
			$hostel=$this->Hostels->find('list', ['keyField' => 'id','valueField' => 'name'])->where(['Hostels.type' =>1,'Hostels.status'=>'Y'])->toArray();
			$this->set(compact('hostel'));
		}
		else
		{
			$hostel=$this->Hostels->find('list', ['keyField' => 'id','valueField' => 'name'])->where(['Hostels.type' =>0,'Hostels.status'=>'Y'])->toArray();
			$this->set(compact('hostel')); 		      
		}



	}else{

		$students = $this->Students->newEntity();

	}
	if ($this->request->is(['post', 'put'])) {

//	pr($this->request->data); die;

		$hostelid=$students->h_id;
		if(!empty($hostelid))
		{
			$roomcapacity =$this->Hostelrooms->find('list', ['keyField' => 'id','valueField' =>'capacity'])->where(['Hostelrooms.h_id' => $hostelid,'Hostelrooms.status' =>'Y'])->toArray();

			$studentassinrooms= $this->Students->find('all')->where(['Students.is_hostel' =>1,'Students.room_no' =>$this->request->data['room_no'],'Students.status'=>'Y'])->count();
			$roomcap=implode("",$roomcapacity);

			if($studentassinrooms >=$roomcap)
			{

				$this->Flash->error(__('Selected Rooms Is Booked '));
				return $this->redirect(['action' => 'index']);		

			}
			else{

				$this->request->data['is_hostel']=1;

				// save all data in database
				$students = $this->Students->patchEntity($students, $this->request->data);
				if ($this->Students->save($students)) {
					$this->Flash->success(__('Assign Hostel SuccessFully.'));
					return $this->redirect(['action' => 'index']);	
				}				
			}	
		}
		else
		{		

			$this->request->data['is_hostel']=1;
 	//	pr($this->request->data); die;
				// save all data in database
			$students = $this->Students->patchEntity($students, $this->request->data);
			if ($this->Students->save($students)) {
				$this->Flash->success(__('Assign Hostel SuccessFully.'));
				return $this->redirect(['action' => 'index']);	
			}

		}
	}
	$this->set('students', $students);
	
}

public function find_rooms(){
	$this->viewBuilder()->layout('admin');
	$id=$this->request->data['id'];
	$ids=$this->request->data['ids'];
	$hostelcapacity =$this->Hostelrooms->find('list', ['keyField' => 'id','valueField' =>'capacity'])->where(['Hostelrooms.h_id' => $id,'Hostelrooms.status' =>'Y'])->toArray();
	$studentassinrooms= $this->Students->find('all')->where(['Students.is_hostel' =>1,'Students.room_no' =>$ids,'Students.status'=>'Y'])->count();

	foreach($hostelcapacity as $key=>$value)
	{
		if( $studentassinrooms >= $value )	
		{
			echo "1";

		}
		else
		{
			echo "0";  
		}

	}
	die;
}

public function find_roomslength(){
	$this->viewBuilder()->layout('admin');
	$id=$this->request->data['hostel'];     
	$hostelrom =$this->Hostelrooms->find('list', ['keyField' => 'id','valueField' =>'room_no'])->where(['Hostelrooms.h_id' => $id,'Hostelrooms.status' =>'Y'])->toArray();

	echo "<option value=''>Select Room</option>";

	foreach($hostelrom as $key=>$value)
	{
		for($i=1; $i<=$value; $i++)
		{

			echo "<option value=".$i." >".$i."</option>";

		}

	}
	die;
}


public function addsubject($id = null){
	$complete_student= $this->Students->get($id);
	$class_id  = $complete_student->class_id;
	if($class_id==26 || $class_id==27)
	{
			$ibsub1=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjects.is_group'=>1,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

			$ibsub2=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjects.is_group'=>2,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

			$ibsub3=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjects.is_group'=>3,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

			$ibsub4=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjects.is_group'=>4,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

			$ibsub5=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjects.is_group'=>5,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

			$ibsub6=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjects.is_group'=>6,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();
			$this->set(compact('ibsub1','ibsub2','ibsub3','ibsub4','ibsub5','ibsub6'));
	//pr($ibsub); die;
	



	}
  //pr($class_id); die;
	$select  = $complete_student->comp_sid;
	//pr($select); die;
	$this->set('class_id', $class_id);
	if(!empty($select))
	{
		$this->set('selected', $select);
	}

	$select1  = $complete_student->opt_sid;
	//pr($select1); die;

	if(!empty($select1))
	{
		$this->set('select1', $select1);
	}

	$com=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjectclass.is_optional'=>0,'Subjectclass.is_result2'=>1,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();
	//pr($com); die;
	$this->set(compact('com'));

// pr($com); die;
	$option=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjectclass.is_optional'=>1,'Subjectclass.is_result2'=>1,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

	$this->set(compact('option'));




	if(isset($id) && !empty($id)){

		$students = $this->Students->get($id);
	}else{

		$students = $this->Students->newEntity();

	}

		//  $this->set('students', $students);

	if ($this->request->is(['post', 'put'])) {
		//pr($this->request->data); die;
		$comp=implode(",",$this->request->data['comp_sid']);
		$opt_sid=implode(",",$this->request->data['opt_sid']);
		$this->request->data['comp_sid']=$comp;
		$this->request->data['opt_sid']=$opt_sid;
		$students = $this->Students->patchEntity($students, $this->request->data);
	// pr($students); die;
		if ($this->Students->save($students)) {
			$this->Flash->success(__('Student Subject has been saved.'));
			return $this->redirect(['action' => 'view/'.$id.'?id=history']);	
		}	
		


	}
 //$this->set('comp_sid',array('4'=>'hindi'));

}

public function find_username($username = null){

	$username=$this->request->data['username'];
	$students = $this->Students->find('all')->where(['Students.username' =>$username])->toArray();
	echo $students[0]['id'];
	die;
}

	//for students chack mail



	// for change email





public function pdf_view($schedule_id = null){

	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$schedule_id,'Students.status'=>'Y'])->first()->toarray();
	$this->set(compact('students'));
	$classessss =$this->Guardians->find()->where(['Guardians.user_id' => $schedule_id])->first();
		//pr($classessss); die;
	$this->set(compact('classessss'));
	$doc_img = $this->Documents->find('all')->contain(['Documentcategory'])->where(['Documents.type' =>0,'Documents.user_id' =>$schedule_id])->order(['Documents.id' => 'DESC'])->toarray();

	
	$this->set(compact('doc_img'));
	$address = $this->Address->find('all')->contain(['CurCountry','PerCountry','CurStates','PerStates','CurStates','PerStates','CurCity','PerCity'])->where(['Address.type' =>0,'Address.user_id' =>$schedule_id])->first();

	$this->set(compact('address'));
	$studentshistory = $this->Studentshistory->find('all')->contain(['Classes','Sections'])->where(['Studentshistory.stud_id' =>$schedule_id])->toarray();
	$this->set(compact('studentshistory'));
	

		//	pr($address); die;	



}




public function change_email($id=null){
	

	$name=$this->Students->find()->where(['Students.id' => $id,'Students.status'=>'Y'])->first()->toarray();
	//pr($name); die;
	$this->set('name',$name);
	if(isset($id) && !empty($id)){

		$students = $this->Students->get($id);
	}
	else{

		$students = $this->Students->newEntity();
	}
	$this->set('students', $students);
	if ($this->request->is(['post', 'put'])) {
		$students = $this->Students->patchEntity($students, $this->request->data);
			//	pr($classes); die;
		$email=$this->request->data['username'];
		$ids=$students->id;
		$conn = ConnectionManager::get('default');
		$detail='UPDATE `students` SET `username` ="'.$email.'" WHERE `students`.`id` = '.$ids;

		$results = $conn->execute( $detail );
		$this->Flash->success(__('Your Personal Information  has been saved.'));

		return $this->redirect(['action' => 'view/'.$ids]);	

     //  pr($classes);
	}

}


	// show all data in listing with pagination
public function index($id=null,$section=null){ 

	$this->viewBuilder()->layout('admin');
		//show all data in listing page
$user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$rolepresentyear=$user['academic_year'];
		
			$this->set(compact('rolepresentyear'));

	$sections = $this->Sections->find('all')->select(['id', 'title'])->where(['status' => 1])->order(['title' => 'ASC'])->toArray();

$rolepresent=$this->request->session()->read('Auth.User.role_id');



if($rolepresent=='1'){ 
	
		$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();


	

	
}else if($rolepresent=='5'){ 
	
	
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id <=' =>'22'])->order(['Classes.sort' => 'ASC'])->toArray();


	
	

	
}else if($rolepresent=='8'){ 
	
	



	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id >=' =>'23'])->order(['Classes.sort' => 'ASC'])->toArray();




	
}else if($rolepresent=='7'){ 
	
	
	
	
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();




	
	
}else if($rolepresent=='15'){ 
	
	
	
	
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();




	
	
}





	$houses = $this->Houses->find('all')->select(['id', 'name'])->where(['status' => 1])->order(['id' => 'ASC'])->toArray();
	$this->set(compact('sections','classes','houses'));

	if($id){ 
		
		
		
		
		
if($rolepresent=='1'){ 
		$student_data = 
		$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.class_id' =>$id,'Students.section_id' =>$section,'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);

}else if($rolepresent=='5'){
	$student_data = 
	$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.class_id' =>$id,'Students.board_id IN' =>['1'],'Students.section_id' =>$section,'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);

	
}else if($rolepresent=='8'){
	
	
	
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.class_id' =>$id,'Students.board_id IN' =>['2','3'],'Students.section_id' =>$section,'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);
	
}else if($rolepresent=='7'){
	
	
	
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.class_id' =>$id,'Students.board_id IN' =>['1','2','3'],'Students.section_id' =>$section,'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);
	
}else if($rolepresent=='15'){
	
	
	
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.class_id' =>$id,'Students.board_id IN' =>['1','2','3'],'Students.section_id' =>$section,'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);
	
} 
  
		
		
		
		
		
		
		
		

	}else{
		
				
if($rolepresent=='1'){ 
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);

}else if($rolepresent=='5'){
	$student_data = 
	$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.board_id IN' =>['1'],'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);

	
}else if($rolepresent=='8'){
	
	
	
		$student_data = 
		$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.board_id IN' =>['2','3'],'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);
	
} else if($rolepresent=='7'){
	
	
	
		$student_data = 
		$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.board_id IN' =>['1','2','3'],'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);
	
}else if($rolepresent=='15'){
	
	
	
		$student_data = 
		$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.board_id IN' =>['1','2','3'],'Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);
	
}
		
		
		
	}
	
	
	
	
	
	
	
	
	
	
}
	// create view functionality
public function view($id){    
	$this->viewBuilder()->layout('admin');
		//get all data particular id
	$this->set('ids',$id);
	if($_GET['id']){
		
		$this->set('selectid',$_GET['id']);
	}
 
		//$userid=$this->request->session()->read('Auth.User.id');
	$doc_img = $this->Documents->find('all')->contain(['Documentcategory'])->where(['Documents.type' =>0,'Documents.user_id' =>$id])->order(['Documents.id' => 'DESC']);
	$this->set(compact('doc_img'));
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$id,'Students.status'=>'Y'])->first();
	$this->set(compact('students'));
		//pr($students); die;
	$Studentsall = $this->Students->get($id);
	$Studentsal=$Studentsall->comp_sid;
	if(!empty($Studentsal))
	{  
		$v=explode(",",$Studentsal);	
		$subjects=$this->Subjects->find('all')->where(['Subjects.id IN'=>$v])->toarray();
		$this->set(compact('subjects'));
	}
	$Studentsals=$Studentsall->opt_sid;
	if(!empty($Studentsals))
	{
		$vr=explode(",",$Studentsals);	
		$subjectss=$this->Subjects->find('all')->where(['Subjects.id IN'=>$vr])->toarray();
		$this->set(compact('subjectss'));
	}
	
	
	
	
	
	
	
	
		//pr($classessss); die;
	$classessss =$this->Guardians->find()->where(['Guardians.user_id' => $id,'Guardians.type' =>'0'])->first();
		//pr($classessss); die;
	$this->set(compact('classessss'));
	$address = $this->Address->find('all')->contain(['CurCountry','PerCountry','CurStates','PerStates','CurStates','PerStates','CurCity','PerCity'])->where(['Address.type' =>0,'Address.user_id' =>$id])->first();
	$this->set(compact('address')); 
	
	$studentshistory = $this->Studentshistory->find('all')->contain(['Classes','Sections'])->where(['Studentshistory.stud_id' =>$id])->toarray();
	$this->set(compact('studentshistory'));
	
	
	
	$studentold = $this->Students->find('all')->where(['Students.id' =>$id,'Students.oldenroll !=' =>'0'])->first();
			$oldenrool=$studentold['oldenroll'];

			if($oldenrool){
			$studsentold = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.enroll' =>$oldenrool])->toarray();
	$this->set(compact('studsentold'));	
		   
			}
}

public function dropview($id){    
	$this->viewBuilder()->layout('admin');
		//get all data particular id
	$this->set('ids',$id);
	if($_GET['id']){
		
		$this->set('selectid',$_GET['id']);
	}
 
		//$userid=$this->request->session()->read('Auth.User.id');
	
	$students = $this->DropOutStudent->find('all')->contain(['Classes','Sections'])->where(['DropOutStudent.id' =>$id])->first();
	$this->set(compact('students'));

	$doc_img = $this->Documents->find('all')->contain(['Documentcategory'])->where(['Documents.type' =>0,'Documents.user_id' =>$students['s_id']])->order(['Documents.id' => 'DESC'])->toarray();
$this->set(compact('doc_img'));

	$Studentsall = $this->DropOutStudent->get($id);
	$Studentsal=$Studentsall->comp_sid;
	if(!empty($Studentsal))
	{  
		$v=explode(",",$Studentsal);	
		$subjects=$this->Subjects->find('all')->where(['Subjects.id IN'=>$v])->toarray();
		$this->set(compact('subjects'));
	}
	$Studentsals=$Studentsall->opt_sid;
	if(!empty($Studentsals))
	{
		$vr=explode(",",$Studentsals);	
		$subjectss=$this->Subjects->find('all')->where(['Subjects.id IN'=>$vr])->toarray();
		$this->set(compact('subjectss'));
	}
	
	
	
	

	
	
	
	
		//pr($classessss); die;
	$classessss =$this->Guardians->find()->where(['Guardians.user_id' => $id,'Guardians.type' =>'0'])->first();
		//pr($classessss); die;
	$this->set(compact('classessss'));
	$address = $this->Address->find('all')->contain(['CurCountry','PerCountry','CurStates','PerStates','CurStates','PerStates','CurCity','PerCity'])->where(['Address.type' =>0,'Address.user_id' =>$id])->first();
	$this->set(compact('address')); 
	
	$studentshistory = $this->Studentshistory->find('all')->contain(['Classes','Sections'])->where(['Studentshistory.stud_id' =>$id])->toarray();
	$this->set(compact('studentshistory'));
	
	
	
	$studentold = $this->DropOutStudent->find('all')->where(['DropOutStudent.id' =>$id,'DropOutStudent.oldenroll !=' =>'0'])->first();
			$oldenrool=$studentold['oldenroll'];

			if($oldenrool){
			$studsentold = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.enroll' =>$oldenrool])->toarray();
	$this->set(compact('studsentold'));	
		   
			}
}
	// create delete functionality
public function delete($id){
	$contact = $this->Students->get($id);
	$sections = $this->Documents->find('all')->select(['photo'])->where(['Documents.user_id' =>$id])->toArray();  
	foreach($sections as $img)
	{

		$imglink=$img['photo'];
		unlink('img/'.$imglink);
	}  	
		//delete particular entry
		try { 
	if ($this->Students->delete($contact)) {
	$connssss = ConnectionManager::get('default');
	    	$resultsucessssss = $connssss->execute("DELETE FROM addresses WHERE user_id=$contact");
			
		$this->Flash->success(__('The student with id: {0} has been deleted.', h($id)));
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
public function deletesms($id){
	$contact = $this->Smsmanager->get($id);

		//delete particular entry
		try { 
	if ($this->Smsmanager->delete($contact)) {
	
			
		$this->Flash->success(__('The SMS with id: {0} has been deleted.', h($id)));
		return $this->redirect(['action' => 'smsmanager']);
		
		
	}
	
	} catch (\PDOException $e) {
  //  $error = 'The item you are trying to delete is associated with other records';
    	$this->Flash->error(__('You can not delete this record because it is used in another table.'));
    $this->set('error', $error);
    //$this->Session->setFlash(__(' Lader all ready exists), 'flash/Error');
    return $this->redirect(['action' => 'smsmanager']);	
}
}

public function deletedocument($id){
	$contact = $this->Documents->get($id);
	$sections = $this->Documents->find('all')->select(['photo'])->where(['Documents.id' =>$id])->toArray();  
	$userid=$contact->user_id;
	foreach($sections as $img)
	{

		$imglink=$img['photo'];
		unlink('img/'.$imglink);
	}  	
		//delete particular entry
	if ($this->Documents->delete($contact)) {
		$this->Flash->success(__('The documents with id: {0} has been deleted.', h($id)));
		return $this->redirect(['action' => 'view/'.$userid.'?id=documents']);
	}
}

public function studentdetail(){


}

public function sendsms(){
	$smslist = $this->Smsmanager->find('all')->order(['id' => 'ASC'])->toArray();
		$this->set('smslist',$smslist);
		
		$smscategoryslist = $this->Smsmanager->find('list', [
			'keyField' => 'category',
			'valueField' => 'category'
			])->where(['status' => 'Y','sms_for IN'=>['S','B']])->order(['id' => 'ASC'])->toArray();
		$this->set('smscategoryslist',$smscategoryslist);
	
}

public function find_smstemplate(){
	$cat=$this->request->data['id'];
		$smslist = $this->Smsmanager->find('all')->select(['message'])->where(['category' =>$cat])->order(['id' => 'ASC'])->first();
echo $smslist['message']; die;
		
}


public function file_get_contents_curl($url) 
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	$data = curl_exec($ch);
	curl_close($ch);
	return  $data;
}    
public function send_smsmobile(){
	$mobile=$this->request->data['sid'];
	$messageid=$this->request->data['messageid'];
	
	$cat=$this->request->data['id'];
		$smslist = $this->Smsmanager->find('all')->select(['message'])->where(['category' =>$cat])->order(['id' => 'ASC'])->first();
$mesg=$smslist['message'];
	

	$result=$this->file_get_contents_curl('http://alerts.prioritysms.com/api/web2sms.php?workingkey=Afb7ede974e22367003ac66f8514bd152&to='.$mobile.'&sender=SNSKAR&message='.urlencode($mesg));
	if($result=="Invalid Input Data"){
		
			echo "<b style='color:red;'>Invalid Input Data !!!!</b>"; die;
	}else if($result=="Invalid Mobile Numbers"){
			echo "<b style='color:red;'>Invalid Mobile Numbers !!!!</b>"; die;
		
	}else if($result=="Insufficient credits"){
			echo "<b style='color:red;'>Insufficient credits !!!!</b>"; die;
		
	}else{
	echo "<b style='color:green;'>Send Sucessfully !!!!</b>"; die;
	
	} 

	
}
	public function smsmanager($id=null){ 
		$this->viewBuilder()->layout('admin');
	$smslist = $this->Smsmanager->find('all')->order(['id' => 'ASC'])->toArray();
		$this->set('smslist',$smslist);
		
		
		if(isset($id) && !empty($id)){
			
		   $banks = $this->Smsmanager->get($id);
		   
		  
		}else{
               $banks = $this->Smsmanager->newEntity();
          }		
	if ($this->request->is(['post', 'put'])) {
		
		$bankss = $this->Smsmanager->patchEntity($banks, $this->request->data);
				
				if ($this->Smsmanager->save($bankss)) {
						$this->Flash->success(__('Sms Template has been saved.'));
					return $this->redirect(['action' => 'smsmanager']);	
				
				  }
				  
	}
	$this->set('sms', $banks);
		
	
	}
//add students
public function add($fromnos=null){ 
	$this->set('fromnos',$fromnos);
	$this->viewBuilder()->layout('admin');
	 $this->loadModel('Boards');
	$this->loadModel('Applicant');
	$this->loadModel('Users');
	$this->loadModel('Disabilitys');
	$applicanst = $this->Applicant->find('all')->where(['Applicant.sno' =>$fromnos])->order(['Applicant.id' => 'DESC'])->first();

$disabilityslist = $this->Disabilitys->find('list', [
			'keyField' => 'id',
			'valueField' => 'name'
			])->where(['status' => 'Y'])->order(['id' => 'ASC'])->toArray();
		$this->set('disabilityslist',$disabilityslist);
		$rolepresent=$this->request->session()->read('Auth.User.role_id');
if($rolepresent=='1'){ 
		$brhy = $this->Boards->find('list', ['keyField' =>'id','valueField' => 'name'])->toArray();

$this->set('bord',$brhy);

}else if($rolepresent=='5'){
	$studentsid = $this->Students->find('all')->where(['Students.board_id' =>'1'])->order(['id' => 'DESC'])->first();
	$studentsid23 = $this->Students->find('all')->where(['Students.board_id IN' =>['2','3'],'Students.id !='=>'333333'])->order(['id' => 'DESC'])->first();
	$this->set('studentsid23',$studentsid23);
	$brhy = $this->Boards->find('list', ['keyField' =>'id','valueField' => 'name'])->where(['Boards.id' =>'1'])->toArray();

$this->set('bord',$brhy);
	
	
}else if($rolepresent=='8'){
	$studentsid = $this->Students->find('all')->where(['Students.board_id IN' =>['2','3'],'Students.id !='=>'333333'])->order(['id' => 'DESC'])->first();
	$studentsid23 = $this->Students->find('all')->where(['Students.board_id' =>'1'])->order(['id' => 'DESC'])->first();
	$this->set('studentsid23',$studentsid23);
	$brhy = $this->Boards->find('list', ['keyField' =>'id','valueField' => 'name'])->where(['Boards.id IN' =>['2','3']])->toArray();

$this->set('bord',$brhy);
	
	
} 

 $user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$acedmicyear=$user['next_academic_year'];
	$this->set('acedmicyearfi',$acedmicyear);	
		
	

		$subjectclasses_data = $this->Subjectclass->find('list', [
			'keyField' => 'Classes.id',
			'valueField' => 'Classes.title'
			])->contain(['Classes'])->order(['Classes.id' => 'ASC'])->toarray();
		//$this->paginate($service_data);
		$this->set('classlist',$subjectclasses_data);
		
		
		
		$sections = $this->Sections->find('all')->select(['id', 'title'])->where(['status' => 1])->order(['title' => 'ASC'])->toArray();
		
		
	
if($rolepresent=='1'){ 
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='5'){ 
	
	
		$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id <=' =>'22'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
	
			$classeshg = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id >=' =>'23'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classeshg', $classeshg);
	
}else if($rolepresent=='8'){ 
	
	
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id >=' =>'23'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
	$classeshg = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id <=' =>'22'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classeshg', $classeshg);
	
}


		$houses = $this->Houses->find('all')->select(['id', 'name'])->where(['status' => 1])->order(['id' => 'ASC'])->toArray();
		$this->set(compact('studentsid','sections','houses'));
		$students = $this->Students->newEntity();
		
		if($applicanst){
			  $this->set('applicanst', $applicanst);
		$guardians = $this->Guardians->find('all')->where(['Guardians.applicant_id'=>$applicanst['id']])->order(['Guardians.id' => 'DESC'])->first();
		     		     $this->set('guardians', $guardians);
		     		      $gid=$guardians['id'];
					 }
		    
		     if($guardians){
		     $guardians = $this->Guardians->get($gid);
		 }else{
		$guardians = $this->Guardians->newEntity();
		
	}
		$this->request->data['status'] = 'Y';
	
	if ($this->request->is(['post', 'put'])) {
		
		
		if($this->request->data['class_id']==''){
			$this->request->data['class_id']=$this->request->data['classn_id'];
			
		}
		
		if($this->request->data['category'] =="RTE"){
			 $user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$rolepresentyear=$user['next_academic_year'];
$this->request->data['acedmicyear']=$rolepresentyear;
	}
	
		if($this->request->data['feecat']=='Other'){
			$this->request->data['fee_submittedby']=$this->request->data['fee_submittedby'];
			
		}elseif($this->request->data['feecat']=='Father'){
			$this->request->data['fee_submittedby']=$this->request->data['fathername'];
			
		}elseif($this->request->data['feecat']=='Mother'){
			$this->request->data['fee_submittedby']=$this->request->data['mothername'];
			
		}
		if($this->request->data['file12']['name']!=''){
			$oimg=$this->request->data['file1'];
			if($oimg!=''){

		if(unlink(WWW_ROOT."/stu/".$oimg)){
			$gallery=$this->request->data['file12'];
 $filename=$gallery['name'];
  $ext=  end(explode('.', $filename));
					  $name = md5(time($filename));
					  $imagename=trim($name.'stu.'.$ext," ");
					  
					    if(move_uploaded_file($gallery['tmp_name'],"stu/". $imagename))

						{
							$id=$this->request->data['formno'];
							$this->request->data['file']=$imagename;
							$conn = ConnectionManager::get('default');
						$detail='UPDATE `applicants` SET `image` ="'.$imagename.'" WHERE `applicants`.`sno` = "'.$id.'"';

						$results = $conn->execute($detail);

						      
					       }
			
		}
		
	}else{
		$gallery=$this->request->data['file12'];
 $filename=$gallery['name'];
  $ext=  end(explode('.', $filename));
					  $name = md5(time($filename));
					  $imagename=trim($name.'stu.'.$ext," ");
					  
					    if(move_uploaded_file($gallery['tmp_name'],"stu/". $imagename))

						{
							$id=$this->request->data['formno'];
							$this->request->data['file']=$imagename;
							$conn = ConnectionManager::get('default');
						$detail='UPDATE `applicants` SET `image` ="'.$imagename.'" WHERE `applicants`.`sno` = "'.$id.'"';

						$results = $conn->execute($detail);

						      
					       }
	}
			 

		}else if($this->request->data['file12']['name']==''){
			$this->request->data['file']=$this->request->data['file1'];

		}else{
			$this->request->data['file']='';
		}
		$classsectioncapacity = $this->Classections->find('all')->where(['Classections.class_id' => $this->request->data['class_id'],'Classections.section_id' =>$this->request->data['section_id']])->first();
		$capacity=$classsectioncapacity['capacity'];
	
		$studentexitscapacity = $this->Students->find('all')->where(['Students.class_id' => $this->request->data['class_id'],'Students.section_id' =>$this->request->data['section_id'],'Students.status'=>'Y'])->count();
		
		if($this->request->data['category'] !="Migration"){
		
		$userTable = TableRegistry::get('Students'); 
		$exists = $userTable->exists(['fname' => $this->request->data['fname'],'mobile' => $this->request->data['mobile']]);
		if($this->request->data['category'] !="RTE"){
		$exists2 = $userTable->exists(['formno' => $this->request->data['formno']]);
	}
		
		if($this->request->data['adaharnumber'] !=''){
		$exists3 = $userTable->exists(['adaharnumber' => $this->request->data['adaharnumber']]);
		
	}
		if($exists){

			$this->Flash->error(
				__("Student already exits in  with records!!!")
				);

		}elseif($exists2){

			$this->Flash->error(
				__("Form no. already exits in  records!!!")
				);


		}elseif($exists3){

			$this->Flash->error(
				__("Aadhar no. already exits in  records!!!")
				);


		}else{
			//if($capacity > $studentexitscapacity){
				$this->request->data['fname']=ucfirst($this->request->data['fname']);
				
				
				$rtf=explode('/',$this->request->data['dob']);
	
$this->request->data['dob']=$rtf[2].'-'.$rtf[1].'-'.$rtf[0];
				
				// save all data in database
				if($this->request->data['fathername']){
					$this->request->data['fathername']=$this->request->data['fathername'];

				} if($this->request->data['mothername']){
					$this->request->data['mothername']=$this->request->data['mothername'];
				}

			
				
					 $user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$rolepresent=$user['next_academic_year'];
		$this->request->data['acedmicyear']=$this->request->data['acedmicyear'];
		
		if($this->request->data['admissionyear']==""){
				$this->request->data['admissionyear']=$rolepresent;
			
		}else{
		$this->request->data['admissionyear']=$this->request->data['admissionyear'];
		
	}
	  $this->request->data['admissionclass']=$this->request->data['class_id'];
		//pr($this->request->data); die;
	
		$c_id=$this->request->session()->read('Auth.User.c_id');
		$db=$this->request->session()->read('Auth.User.db');

		// echo $c_id; die;
				$students = $this->Students->patchEntity($students, $this->request->data);
				//pr($students); die;
				if ($this->Students->save($students)) {
					
					
					$result =$this->Students->save($students);	
					$id = $result->id;
					$acedmicyear = $result->acedmicyear;
					$formno = $result->formno;
					
					$conn = ConnectionManager::get('default');
					if($formno){
						$detail='UPDATE `applicants` SET `status` ="Y" WHERE `applicants`.`sno` = "'.$formno.'"';

						$results = $conn->execute($detail);
 					}
						      
					$username = $result->username;
					$fathername = $result->fathername;
					$password = $result->password;
					$password = $result->password;
					$mobile = $result->mobile;
					$board_id = $result->board_id;
					$enroll_id = $result->enroll;
					
					
					
		$userff = $this->Users->newEntity();
		
		if($board_id=='1'){
      	$this->request->data['email']="C".$enroll_id;
      }else if($board_id=='2'){
      	$this->request->data['email']="CAM".$enroll_id;
      }else if($board_id=='3'){
      	 $this->request->data['email']="IB".$enroll_id;
      }
		
				
					$this->request->data['c_id']=$c_id;
					$this->request->data['db']=$db;
					$this->request->data['board']=$this->request->data['board_id'];
					$this->request->data['user_name']=$this->request->data['fname'];
					$this->request->data['mobile']=$mobile;
					$this->request->data['academic_year']=$this->request->data['acedmicyear'];
					$this->request->data['password']=$this->_setPassword($this->request->data['email']);
					$this->request->data['confirm_pass']=$this->request->data['email'];
					$this->request->data['role_id']='2';
					$this->request->data['fkey']='0';
					$this->request->data['latefee']='0';
					$userff = $this->Users->patchEntity($userff, $this->request->data);
					$this->Users->save($userff);
					
					
					
					if($this->request->data['fullname']){
						$this->request->data['user_id']=$id;
				
						$this->request->data['fullname']=$this->request->data['fullname'];
						$this->request->data['relation']=$this->request->data['relation'];
						$this->request->data['qualification']='';
						$this->request->data['occupation']='';
						$this->request->data['total_Income']='';
						$this->request->data['emails']='';
						$this->request->data['address']='';
						$this->request->data['address']='';
						$this->request->data['mobileno']=$this->request->data['mobileno'];;
						$guardians = $this->Guardians->patchEntity($guardians, $this->request->data);
						$this->Guardians->save($guardians);

					}
					
					
	return $this->redirect(['controller' => 'Studentfees','action' => 'index/'.$id.'/'.$acedmicyear]);	
	
				  }else{    //check validation error
				  	if($students->errors()){
				  		$error_msg = [];
				  		foreach( $students->errors() as $errors){
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
			
		}else{
			
			
			$this->request->data['fname']=ucfirst($this->request->data['fname']);
				$this->request->data['dob']=date('Y-m-d',strtotime($this->request->data['dob']));
				// save all data in database
				if($this->request->data['fathername']){
					$this->request->data['fathername']=$this->request->data['fathername'];

				} if($this->request->data['mothername']){
					$this->request->data['mothername']=$this->request->data['mothername'];
				}

				
					 $user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$rolepresent=$user['next_academic_year'];
$this->request->data['acedmicyear']=$this->request->data['acedmicyear'];

	if($this->request->data['admissionyear']==""){
				$this->request->data['admissionyear']=$rolepresent;
			
		}else{
		$this->request->data['admissionyear']=$this->request->data['admissionyear'];
		
	}
	  $this->request->data['admissionclass']=$this->request->data['class_id'];
		
		
		if($this->request->data['board_id']=='1'){
		$student_data = 
		$this->Students->find('all')->where(['Students.enroll'=>$this->request->data['oldenroll'],'Students.board_id'=>'1','Students.status'=>'Y'])->first();
	if($this->request->data['classd_id']=="23" || $this->request->data['classd_id']=="24" || $this->request->data['classd_id']=="25" || $this->request->data['classd_id']=="28" || $this->request->data['classd_id']=="29"){
		
		$this->request->data['board_id']='2';
	}else if($this->request->data['classd_id']=="26" || $this->request->data['classd_id']=="27"){
		$this->request->data['board_id']='3';
		
		
	}

if($student_data){
 $peopleTable = TableRegistry::get ('Students');
$oQuery = $peopleTable->query ();

$oQuery->insert (['fname', 'middlename', 'lname', 'fee_submittedby', 
'board_id','created', 'fathername', 'mothername', 'username', 'password', 'dob', 
'enroll', 'mobile', 'mobile2', 'sms_mobile', 'formno', 'adaharnumber', 
'cast', 'parent_id', 'house_id', 
'class_id','category','section_id','gender', 'photo', 'bloodgroup', 
'religion', 'address', 'city', 'nationality', 'admissionyear', 
'acedmicyear', 'status', 'file', 'comp_sid', 'opt_sid', 'h_id', 
'room_no', 'is_transport', 'transportloc_id', 'v_num', 'dis_fees', 
'dis_transport', 'is_discount', 'discountcategory', 'due_fees', 
'token', 'rf_id', 'is_special','oldenroll','is_lc', 'disability', 'mother_tounge', 'f_qualification', 'f_occupation', 'm_qualification', 'm_occupation', 'f_phone', 'm_phone', 'admissionclass','previous_board']) ->values
(['fname'=>$student_data['fname'], 'middlename'=>$student_data['middlename'],'lname'=>$student_data['lname'],'fee_submittedby'=>$student_data['fee_submittedby'], 'board_id'=>$this->request->data['board_id'],'created'=>$student_data['created'],'fathername'=>$student_data['fathername'],'mothername'=>$student_data['mothername'],'username'=>$student_data['username'],'password'=>$student_data['password'],'dob'=>$student_data['dob'],'enroll'=>$this->request->data['enrolls'], 'mobile'=>$student_data['mobile'],'mobile2'=>$student_data['mobile2'],'sms_mobile'=>$student_data['sms_mobile'], 'formno'=>$student_data['formno'], 'adaharnumber'=>$student_data['adaharnumber'],'cast'=>$student_data['cast'],'parent_id'=>$student_data['parent_id'],'house_id'=>$this->request->data['h_id'],'class_id'=>$this->request->data['classd_id'],'category'=>$student_data['category'],'section_id'=>$this->request->data['section_id'],'gender'=>$student_data['gender'],'photo'=>$student_data['photo'],'bloodgroup'=>$student_data['bloodgroup'],'religion'=>$student_data['religion'],'address'=>$student_data['address'],'city'=>$student_data['city'],'nationality'=>$student_data['nationality'], 'admissionyear'=>$student_data['admissionyear'],'acedmicyear'=>$student_data['acedmicyear'],'status'=>$student_data['status'], 'file'=>$student_data['file'],'comp_sid'=>'', 'opt_sid'=>'','h_id'=>$this->request->data['h_id'], 
'room_no'=>$student_data['room_no'], 'is_transport'=>$student_data['is_transport'], 'transportloc_id'=>$student_data['transportloc_id'], 'v_num'=>$student_data['v_num'], 'dis_fees'=>$student_data['dis_fees'], 'dis_transport'=>$student_data['dis_transport'], 'is_discount'=>$student_data['is_discount'],'discountcategory'=>'','due_fees'=>$student_data['due_fees'], 'token'=>$student_data['token'], 'rf_id'=>$student_data['rf_id'],'is_special'=>$student_data['is_special'],'oldenroll'=>$this->request->data['oldenroll'],'is_lc'=>$student_data['is_lc'], 'disability'=>$student_data['disability'], 'mother_tounge'=>$student_data['mother_tounge'], 'f_qualification'=>$student_data['f_qualification'], 'f_occupation'=>$student_data['f_occupation'], 'm_qualification'=>$student_data['m_qualification'], 'm_occupation'=>$student_data['m_occupation'], 'f_phone'=>$student_data['f_phone'], 'm_phone'=>$student_data['m_phone'], 'admissionclass'=>$student_data['admissionclass'],'previous_board'=>$this->request->data['previous_board']]); 
        
        
    
     $oQuery->execute ();
     
     	$conns = ConnectionManager::get('default'); 

$conns->execute("UPDATE `students` SET category='Migration', status='N' WHERE `id`='".$student_data['id']."'");


$result=$this->Students->find('all')->where(['Students.enroll'=>$this->request->data['enrolls'],'Students.board_id'=>$this->request->data['board_id'],'Students.status'=>'Y'])->first();
	
					$id = $result['id'];
						      
					$username = $result['username'];
					$fathername = $result['fathername'];
					$password = $result['password']; 
				
					$mobile = $result['mobile'];
					$board_id = $result['board_id'];
					$enroll_id = $result['enroll'];
					
					
					
		$userff = $this->Users->newEntity();
		
		if($this->request->data['board_id']=='1'){
      	$this->request->data['email']="C".$enroll_id;
      }else if($this->request->data['board_id']=='2'){
      	$this->request->data['email']="CAM".$enroll_id;
      }else if($this->request->data['board_id']=='3'){
      	 $this->request->data['email']="IB".$enroll_id;
      }
		
				
					$this->request->data['user_name']=$student_data['fname'];
					$this->request->data['mobile']=$mobile;
					$this->request->data['academic_year']=$student_data['acedmicyear'];
					$this->request->data['password']=$this->_setPassword($this->request->data['email']);
					$this->request->data['confirm_pass']=$this->request->data['email'];
					$this->request->data['role_id']='2';
					$this->request->data['fkey']='0';
					$this->request->data['latefee']='0';
					$userff = $this->Users->patchEntity($userff, $this->request->data);
					$this->Users->save($userff);
					
					$this->Flash->success(__('Student Migrated Successfully.'));
					return $this->redirect(['action' => 'index']);	
}else{
	$this->Flash->error(__('Student Enroll not found for Migaration !!!'));
					return $this->redirect(['action' => 'index']);	
	
	
}
	
	}else{
				$student_data = 
				$this->Students->find('all')->where(['Students.enroll'=>$this->request->data['oldenroll'],'Students.board_id IN'=>['2','3'],'Students.status'=>'Y'])->first();
	$this->request->data['board_id']='1';
		if($student_data){
	
 $peopleTable = TableRegistry::get ('Students');
$oQuery = $peopleTable->query ();

$oQuery->insert (['fname', 'middlename', 'lname', 'fee_submittedby', 
'board_id', 'fathername', 'mothername', 'username', 'password', 'dob', 
'enroll', 'mobile', 'mobile2', 'sms_mobile', 'formno', 'adaharnumber', 
'cast', 'parent_id', 'house_id', 
'class_id','category','section_id','gender', 'photo', 'bloodgroup', 
'religion', 'address', 'city', 'nationality', 'admissionyear', 
'acedmicyear', 'status', 'file', 'comp_sid', 'opt_sid', 'h_id', 
'room_no', 'is_transport', 'transportloc_id', 'v_num', 'dis_fees', 
'dis_transport', 'is_discount', 'discountcategory', 'due_fees', 
'token', 'rf_id', 'is_special','oldenroll','is_lc', 'disability', 'mother_tounge', 'f_qualification', 'f_occupation', 'm_qualification', 'm_occupation', 'f_phone', 'm_phone', 'admissionclass']) ->values 
(['fname'=>$student_data['fname'], 'middlename'=>$student_data['middlename'],'lname'=>$student_data['lname'],'fee_submittedby'=>$student_data['fee_submittedby'], 'board_id'=>$this->request->data['board_id'],'fathername'=>$student_data['fathername'],'mothername'=>$student_data['mothername'],'username'=>$student_data['username'],'password'=>$student_data['password'],'dob'=>$student_data['dob'],'enroll'=>$this->request->data['enrolls'], 'mobile'=>$student_data['mobile'],'mobile2'=>$student_data['mobile2'],'sms_mobile'=>$student_data['sms_mobile'], 'formno'=>$student_data['formno'], 'adaharnumber'=>$student_data['adaharnumber'],'cast'=>$student_data['cast'],'parent_id'=>$student_data['parent_id'],'house_id'=>$this->request->data['h_id'],'class_id'=>$this->request->data['classd_id'],'category'=>$student_data['category'],'section_id'=>$this->request->data['section_id'],'gender'=>$student_data['gender'],'photo'=>$student_data['photo'],'bloodgroup'=>$student_data['bloodgroup'],'religion'=>$student_data['religion'],'address'=>$student_data['address'],'city'=>$student_data['city'],'nationality'=>$student_data['nationality'], 'admissionyear'=>$student_data['admissionyear'],'acedmicyear'=>$student_data['acedmicyear'],'status'=>$student_data['status'], 'file'=>$student_data['file'],'comp_sid'=>'', 'opt_sid'=>'','h_id'=>$this->request->data['h_id'], 
'room_no'=>$student_data['room_no'], 'is_transport'=>$student_data['is_transport'], 'transportloc_id'=>$student_data['transportloc_id'], 'v_num'=>$student_data['v_num'], 'dis_fees'=>$student_data['dis_fees'], 'dis_transport'=>$student_data['dis_transport'], 'is_discount'=>$student_data['is_discount'],'discountcategory'=>'','due_fees'=>$student_data['due_fees'], 'token'=>$student_data['token'], 'rf_id'=>$student_data['rf_id'],'is_special'=>$student_data['is_special'],'oldenroll'=>$this->request->data['oldenroll'],'is_lc'=>$student_data['is_lc'], 'disability'=>$student_data['disability'], 'mother_tounge'=>$student_data['mother_tounge'], 'f_qualification'=>$student_data['f_qualification'], 'f_occupation'=>$student_data['f_occupation'], 'm_qualification'=>$student_data['m_qualification'], 'm_occupation'=>$student_data['m_occupation'], 'f_phone'=>$student_data['f_phone'], 'm_phone'=>$student_data['m_phone'], 'admissionclass'=>$student_data['admissionclass']]); 
        
     $oQuery->execute();
     $conns = ConnectionManager::get('default'); 

$conns->execute("UPDATE `students` SET category='Migration',status='N' WHERE 
`id`='".$student_data['id']."'");



$result=$this->Students->find('all')->where(['Students.enroll'=>$this->request->data['enrolls'],'Students.board_id'=>$this->request->data['board_id'],'Students.status'=>'Y'])->first();
	
					$id = $result['id'];
						      
					$username = $result['username'];
					$fathername = $result['fathername'];
					$password = $result['password']; 
				
					$mobile = $result['mobile'];
					$board_id = $result['board_id'];
					$enroll_id = $result['enroll'];
					
					
					
		$userff = $this->Users->newEntity();
		
		if($this->request->data['board_id']=='1'){
      	$this->request->data['email']="C".$enroll_id;
      }else if($this->request->data['board_id']=='2'){
      	$this->request->data['email']="CAM".$enroll_id;
      }else if($this->request->data['board_id']=='3'){
      	 $this->request->data['email']="IB".$enroll_id;
      }
		
				
					$this->request->data['user_name']=$student_data['fname'];
					$this->request->data['mobile']=$mobile;
					$this->request->data['academic_year']=$student_data['acedmicyear'];
					$this->request->data['password']=$this->_setPassword($this->request->data['email']);
					$this->request->data['confirm_pass']=$this->request->data['email'];
					$this->request->data['role_id']='2';
					$this->request->data['fkey']='0';
					$this->request->data['latefee']='0';
					$userff = $this->Users->patchEntity($userff, $this->request->data);
					$this->Users->save($userff);
					
					$this->Flash->success(__('Student Migrated Successfully.'));
					return $this->redirect(['action' => 'index']);	
}else{
	$this->Flash->error(__('Student Enroll not found for Migaration !!!'));
					return $this->redirect(['action' => 'index']);	
	
	
}

		
	}
				
		
			
			
		}
		}

		

	}

//editaddress



	public function  editaddress($id=null){


		

	
				$students = $this->Students->get($id);
		$this->set('students', $students);
$this->set('sid', $id);



		if ($this->request->is(['post', 'put'])) {

$this->request->data['address']=$this->request->data['address'];

$conn = ConnectionManager::get('default');
						$detail='UPDATE `students` SET `address` ="'.$this->request->data['address'].'" WHERE `students`.`id` = "'.$this->request->data['id'].'"';

						$results = $conn->execute($detail);
			
		
			$sid=$this->request->data['id'];

			if ($results) {
				
$this->Flash->success(__('Your Address has been saved.'));
				return $this->redirect(['action' => 'view/'.$sid.'?id=address']);	
			}	
		}
	}

// edit personal detail


public function edit($id=null){

		
$this->viewBuilder()->layout('admin');


$admissionclass = $this->AdmissionClasses->find('list', [
			'keyField' => 'id',
			'valueField' => 'title'
			])->order(['sort' => 'ASC'])->toArray();
			$this->set('admissionclass', $admissionclass);

		$rolepresent=$this->request->session()->read('Auth.User.role_id');	
if($rolepresent=='1'){ 
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='5'){ 
	
	
		$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id <=' =>'22'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	

	
}else if($rolepresent=='8'){ 
	
	
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id >=' =>'23'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	

	
}else if($rolepresent=='15'){ 
	
	
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	

	
}
		
		
		
		
		
		

		$houses = $this->Houses->find('list', [
			'keyField' => 'id',
			'valueField' => 'name'
			])->where(['status' => '1'])->order(['name' => 'ASC'])->toArray();
		$this->set('houses', $houses);

	$sections = $this->Sections->find('list', [
			'keyField' => 'id',
			'valueField' => 'title'
			])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sections', $sections);

$disabilityslist = $this->Disabilitys->find('list', [
			'keyField' => 'id',
			'valueField' => 'name'
			])->where(['status' => 'Y'])->order(['id' => 'ASC'])->toArray();
		$this->set('disabilityslist',$disabilityslist);
		
		
			$discountCategorylist = $this->DiscountCategory->find('list', [
			'keyField' => 'name',
			'valueField' => 'name'
			])->where(['status' => 'Y','type'=>'0'])->order(['id' => 'ASC'])->toArray();
		$this->set('discountCategorylist',$discountCategorylist);
		if(isset($id) && !empty($id)){

			$students = $this->Students->get($id);
			
			if($id){
		$guardians = $this->Guardians->find('all')->where(['Guardians.user_id'=>$id])->order(['Guardians.id' => 'DESC'])->first();
		     		     $this->set('guardians', $guardians);
		     		      $gid=$guardians['id'];
					 }
		    
		     if($guardians){
		     $guardians = $this->Guardians->get($gid);
		 }else{
		$guardians = $this->Guardians->newEntity();
		
	}
			$class_id  = $students->class_id;
			$sid  = $students->id;
			$acedmicyearfi  = $students->acedmicyear;
	$this->set('acedmicyearfi', $acedmicyearfi);
	
  //pr($class_id); die;
	$select  = $students->comp_sid;
	
	$this->set('class_id', $class_id);
	
	if($class_id==12 || $class_id==13 || $class_id==15 || 
          $class_id==17 || $class_id==20 || $class_id==22 || $class_id==25 || $class_id==29 || $class_id==11){ 
	if(!empty($select))
	{
		$this->set('selected', $select);
	}

	$select1  = $students->opt_sid;

	if(!empty($select1))
	{
		$this->set('select1', $select1);
	}

	$com=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjectclass.is_optional'=>0,'Subjectclass.is_result2'=>1,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();
	//pr($com); die;
	$this->set(compact('com'));

// pr($com); die;
	$option=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjectclass.is_optional'=>1,'Subjectclass.is_result2'=>1,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

	$this->set(compact('option'));
}


	if($class_id==26 || $class_id==27)
	{
			$ibsub1=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjects.is_group'=>1,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

			$ibsub2=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjects.is_group'=>2,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

			$ibsub3=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjects.is_group'=>3,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

			$ibsub4=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjects.is_group'=>4,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

			$ibsub5=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjects.is_group'=>5,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

			$ibsub6=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjects.is_group'=>6,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();
			$this->set(compact('ibsub1','ibsub2','ibsub3','ibsub4','ibsub5','ibsub6'));

	



	}



	
		}else{

			$students = $this->Students->newEntity();

		}
		$this->set('students', $students);


		$this->set('sid', $id);

		if ($this->request->is(['post', 'put'])) {

			$comp=implode(",",$this->request->data['comp_sid']);
		$opt_sid=implode(",",$this->request->data['opt_sid']);
		$this->request->data['comp_sid']=$comp;
		$this->request->data['opt_sid']=$opt_sid;
	
 if($students['board_id']=='1'){ 
	 $bordd="";
	 
 }else if($students['board_id']=='2'){ 
	 $bordd="CAM";
 }else if($students['board_id']=='3'){
	 
	 $bordd="IB";
 }
 
 if($this->request->data['file']['name'] !=''){
			
				$directory = WWW_ROOT . 'stu/'.$bordd.$students['enroll'].".JPG";
		   
unlink($directory);
     		
	                	$filename=$this->request->data['file']['name'];
						$item=$this->request->data['file']['tmp_name'];
						$ext=  end(explode('.', $filename));
						$name = md5(time($filename));
						$imagename=$bordd.$students['enroll'].".JPG";
						if(move_uploaded_file($item,"stu/". $imagename))
						{
							$this->request->data['file']=$imagename;
						}
	     
	    
}

			$this->request->data['fname']=$this->request->data['fname'];
			
		
if($this->request->data['f_phone']!="0" || $this->request->data['f_phone']!="2147483647"){
	$this->request->data['f_phone']=$this->request->data['f_phone'];
	
}

if($this->request->data['m_phone']!=0 || $this->request->data['m_phone']!="2147483647"){
	$this->request->data['m_phone']=$this->request->data['m_phone'];
	
}
			if($this->request->data['section_id']!=$students['section_id']){
				
				$conn = ConnectionManager::get('default');
		$detail='UPDATE `studentexamresult` SET `sect_id`="'.$this->request->data['section_id'].'" WHERE `stud_id`="'.$students['id'].'"';

						$results = $conn->execute($detail);
				
			}

$donconst=explode('/',$this->request->data['dob']);
			
			$this->request->data['dob']=$donconst[2]."-".$donconst[1]."-".$donconst[0];
			//$this->request->data['dob']=date('Y-m-d',strtotime($this->request->data['dob']));
		//pr($this->request->data); die;
			
			$studentss = $this->Students->patchEntity($students, $this->request->data);



			if ($this->Students->save($studentss)) {
				
				
				
					if($this->request->data['fullname']){
						$this->request->data['user_id']=$students['id'];
				
						$this->request->data['fullname']=$this->request->data['fullname'];
						$this->request->data['relation']=$this->request->data['relation'];
						$this->request->data['qualification']='';
						$this->request->data['occupation']='';
						$this->request->data['total_Income']='';
						$this->request->data['emails']='';
						$this->request->data['address']='';
						$this->request->data['address']='';
						$this->request->data['mobileno']=$this->request->data['mobileno'];;
						$guardians = $this->Guardians->patchEntity($guardians, $this->request->data);
						$this->Guardians->save($guardians);

					}
				$this->Flash->success(__('Student Information has been updated sucessfully !!'));
				$role_id=$this->request->session()->read('Auth.User.role_id');
				if($role_id=='15'){ 
				return $this->redirect(['controller'=>'students','action' => 'index']);	
				
			}else{
							return $this->redirect(['controller'=>'studentfees','action' => 'view']);	
				
			}
				  }else{    //check validation error
				  	if($studentss->errors()){
				  		$error_msg = [];
				  		foreach( $students->errors() as $errors){
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
// add guardian 





public function editdropout($id=null){

		
$this->viewBuilder()->layout('admin');

$admissionclass = $this->AdmissionClasses->find('list', [
			'keyField' => 'id',
			'valueField' => 'title'
			])->order(['sort' => 'ASC'])->toArray();
			$this->set('admissionclass', $admissionclass);
$classes = $this->Classes->find('list', [
			'keyField' => 'id',
			'valueField' => 'title'
			])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('classes', $classes);

		$houses = $this->Houses->find('list', [
			'keyField' => 'id',
			'valueField' => 'name'
			])->where(['status' => '1'])->order(['name' => 'ASC'])->toArray();
		$this->set('houses', $houses);

	$sections = $this->Sections->find('list', [
			'keyField' => 'id',
			'valueField' => 'title'
			])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sections', $sections);

$disabilityslist = $this->Disabilitys->find('list', [
			'keyField' => 'id',
			'valueField' => 'name'
			])->where(['status' => 'Y'])->order(['id' => 'ASC'])->toArray();
		$this->set('disabilityslist',$disabilityslist);
		
		
			$discountCategorylist = $this->DiscountCategory->find('list', [
			'keyField' => 'name',
			'valueField' => 'name'
			])->where(['status' => 'Y','type'=>'0'])->order(['id' => 'ASC'])->toArray();
		$this->set('discountCategorylist',$discountCategorylist);
		if(isset($id) && !empty($id)){

			$students = $this->DropOutStudent->get($id);
			
			
			$class_id  = $students->class_id;
			$sid  = $students->id;
			$acedmicyearfi  = $students->acedmicyear;
	$this->set('acedmicyearfi', $acedmicyearfi);
	
  //pr($class_id); die;
	$select  = $students->comp_sid;
	//pr($select); die;
	$this->set('class_id', $class_id);
	
	if($class_id==12 || $class_id==13 || $class_id==15 || 
          $class_id==17 || $class_id==20 || $class_id==22){ 
	if(!empty($select))
	{
		$this->set('selected', $select);
	}

	$select1  = $students->opt_sid;
	//pr($select1); die;

	if(!empty($select1))
	{
		$this->set('select1', $select1);
	}

	$com=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjectclass.is_optional'=>0,'Subjectclass.is_result2'=>1,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();
	//pr($com); die;
	$this->set(compact('com'));

// pr($com); die;
	$option=$this->Subjectclass->find('list', ['keyField' => 'Subjects.id','valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' =>$class_id,'Subjectclass.is_optional'=>1,'Subjectclass.is_result2'=>1,'Subjectclass.status'=>'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

	$this->set(compact('option'));
}
	
		}else{

			$students = $this->DropOutStudent->newEntity();

		}
		$this->set('students', $students);


		$this->set('sid', $id);
		
		
		
		
		
		if ($this->request->is(['post', 'put'])) {

			
	
 if($students['board_id']=='1'){ 
	 $bordd="";
	 
 }else if($students['board_id']=='2'){ 
	 $bordd="CAM";
 }else if($students['board_id']=='3'){
	 
	 $bordd="IB";
 }
 
 if($this->request->data['file']['name'] !=''){
			
				$directory = WWW_ROOT . 'stu/'.$bordd.$students['enroll'].".JPG";
		   
unlink($directory);
     		
	                	$filename=$this->request->data['file']['name'];
						$item=$this->request->data['file']['tmp_name'];
						$ext=  end(explode('.', $filename));
						$name = md5(time($filename));
						$imagename=$bordd.$students['enroll'].".JPG";
						if(move_uploaded_file($item,"stu/". $imagename))
						{
							$this->request->data['file']=$imagename;
						}
	     
	    
}

			$this->request->data['fname']=$this->request->data['fname'];
			
		

		
			//$this->request->data['dob']=date('Y-m-d',strtotime($this->request->data['dob']));
		//pr($this->request->data); die;
			
			$studentss = $this->DropOutStudent->patchEntity($students, $this->request->data);



			if ($this->DropOutStudent->save($studentss)) {
				$this->Flash->success(__('DropOutStudent has been updated sucessfully !!'));
				$role_id=$this->request->session()->read('Auth.User.role_id');
				if($role_id=='15'){ 
				return $this->redirect(['controller'=>'students','action' => 'drop']);	
				
			}else{
							return $this->redirect(['controller'=>'students','action' => 'drop']);	
				
			}
				  }else{    //check validation error
				  	
				  }

				}

		

			}
			public function addguardian($id=null){




				if(isset($_GET['id']))
				{
					$this->set('ids', $_GET['id']);
					$students = $this->Students->get($_GET['id']);
					$this->set('fathername', $students->fathername);
					$this->set('mothername', $students->mothername);
				}
				if(isset($id) && !empty($id)){


					$classes = $this->Guardians->get($id);
					$this->set('ids', $classes->user_id);
					$students = $this->Students->get($classes->user_id);
					$this->set('fathername', $students->fathername);
					$this->set('mothername', $students->mothername);
				}else{
					$classes = $this->Guardians->newEntity();
				}
				if ($this->request->is(['post', 'put'])) {

					if(!empty($this->request->data['hide'])){
						$this->request->data['user_id']=$this->request->data['hide'];
					}
					else{

						$students =$this->Guardians->find()->where(['Guardians.id' => $id])->first()->toarray();
						$this->request->data['user_id']=$students['user_id'];
					}
					$userid=$this->request->data['user_id'];
					$fullname=$this->request->data['fullname'];
					$this->request->data['emails']=$this->request->data['email'];
					
					if($this->request->data['relation']=='Father'){ 
						
						$conn = ConnectionManager::get('default');
						$detail='UPDATE `students` SET `fathername` ="'.$fullname.'" WHERE `students`.`id` = "'.$userid.'"';

						$results = $conn->execute($detail);
						
					}
					if($this->request->data['relation']=='Mother'){ 
						
						$conn = ConnectionManager::get('default');
						$detail='UPDATE `students` SET `mothername` ="'.$fullname.'" WHERE `students`.`id` = "'.$userid.'"';

						$results = $conn->execute($detail);
						
					}
					
					$this->request->data['type']='0';
					$classes = $this->Guardians->patchEntity($classes, $this->request->data);
			//	pr($classes); die;
					if ($this->Guardians->save($classes)) {
						$this->Flash->success(__('Guardian has been saved.'));

						return $this->redirect(['action' => 'view/'.$this->request->data['user_id'].'?id=guardians']);	
					}
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
				$this->set('classes', $classes);
			}


public function absentreport(){
	$this->viewBuilder()->layout('admin');
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
	
	$sectionslist = $this->Sections->find('list', [
    'keyField' => 'id',
    'valueField' => 'title'
])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist',$sectionslist);

$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

$acedmic=$users['academic_year'];
$this->set(compact('acedmic'));

}
public function absentwithoutcard($class=null,$section=null){
	$this->viewBuilder()->layout('admin');
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	if($class){
		
		$this->set('classs2', $class);
	}
	
	$sectionslist = $this->Sections->find('list', [
    'keyField' => 'id',
    'valueField' => 'title'
])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist',$sectionslist);

$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

$acedmic=$users['academic_year'];
$this->set(compact('acedmic'));

$connss = ConnectionManager::get('default');
if($class && $section){
				$studentrfidsd=$connss->execute("SELECT * FROM students LEFT JOIN 
				classes ON students.class_id = classes.id WHERE students.rf_id 
				!='0'  AND students.id  NOT IN (SELECT students.id AS studid FROM 
				`attendreports` LEFT JOIN students ON attendreports.rfid = 
				students.rf_id LEFT JOIN classes ON students.class_id = classes.id 
				WHERE DATE(resultdate)='".date('Y-m-d')."' AND students.rf_id !='0' 
				 AND students.status ='Y' GROUP BY attendreports.rfid) AND students.class_id ='".$class."' AND students.section_id ='".$section."' ORDER BY fname ASC,section_id ASC");
			}else{
					$studentrfidsd=$connss->execute("SELECT * FROM students LEFT JOIN classes ON students.class_id = classes.id WHERE students.rf_id !='0'  AND students.id  NOT IN (SELECT students.id AS studid FROM `attendreports` LEFT JOIN students ON attendreports.rfid = students.rf_id LEFT JOIN classes ON students.class_id = classes.id WHERE DATE(resultdate)='".date('Y-m-d')."' AND students.rf_id !='0' AND students.status ='Y' GROUP BY attendreports.rfid) ORDER BY sort ASC,section_id ASC");
				
				
				
			}
				$studentrfidsd=$studentrfidsd->fetchAll('assoc');	
			//pr($studentrfidsd); 
				$this->set(compact('studentrfidsd'));


}

public function classidcardreportmain(){
	$this->viewBuilder()->layout('admin');
	
$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

$acedmic=$users['academic_year'];
$this->set(compact('acedmic'));
$classess = $this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();


	$this->set('classess', $classess);
	
	
	$sectionslist = $this->Sections->find('list', [
    'keyField' => 'id',
    'valueField' => 'title'
])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist',$sectionslist);
		  $articles = TableRegistry::get('Students');
$studentcnt= $articles->find('all')->where(['Students.status'=>'Y','Students.acedmicyear'=>$acedmic])->count();
	
$this->set('studentcnt', $studentcnt);
$connss = ConnectionManager::get('default');

$date=date('Y-m-d');
$this->set('date', $date);

				/* $studentrfidsd=$connss->execute("SELECT * FROM `attendreports` LEFT JOIN students ON attendreports.rfid = students.rf_id 
LEFT JOIN classes ON students.class_id = classes.id  WHERE  
DATE(attendreports.resultdate)='".date('Y-m-d')."' AND students.status 
='Y' GROUP BY attendreports.rfid  ORDER BY classes.sort ASC,students.section_id ASC");
				
				$studentrfidsd=$studentrfidsd->fetchAll('assoc');	
			pr($studentrfidsd); die;
				$this->set(compact('studentrfidsd')); */






}


public function classidcardreport(){
	
	        $rolepresent = $this->request->session()->read('Auth.User.role_id');

   
	$this->viewBuilder()->layout('admin');
	
$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

$acedmic=$users['academic_year'];
$this->set(compact('acedmic'));
$classess = $this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();


	$this->set('classess', $classess);
	
	
	$sectionslist = $this->Sections->find('list', [
    'keyField' => 'id',
    'valueField' => 'title'
])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist',$sectionslist);
		  $articles = TableRegistry::get('Students');
$studentcnt= $articles->find('all')->where(['Students.status'=>'Y','Students.acedmicyear'=>$acedmic])->count();
	
$this->set('studentcnt', $studentcnt);
$connss = ConnectionManager::get('default');

$date=date('Y-m-d');
$this->set('date', $date);

				






}

  public function findrolemenutakeattendence(){ 
      $articles = TableRegistry::get('PermissionModules');
      $ids=$this->request->session()->read('Auth.User.id'); 
    return  $articles->find('all')->where(['PermissionModules.user_id'=>$ids,'PermissionModules.action'=>'classattendance'])->group(['PermissionModules.module'])->order(['PermissionModules.id'=>'ASC'])->first();
      }
public function classattendance(){
	
	$result=$this->findrolemenutakeattendence();
	

	
	if($result['id']==''){
		
		$this->Flash->error(__("You don't have permission to access class attendance module !!"));
							 $this->Auth->logout();
        	return $this->redirect(['controller' => 'logins','action'=>'index']);
	}
	$this->viewBuilder()->layout('admin');
	
$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
 $current_time = date("H.i", time());
            //pr($current_time);die;

            if ($current_time >= $users['attendenceupdate']) {
                $output['canTakeAttendance'] = 0;
            } else {
                $output['canTakeAttendance'] = 1;
            }
      

           		$this->set('output',$output);
           		$this->set('attendenceupdate',$users['attendenceupdate']);
$acedmic=$users['academic_year'];
$this->set(compact('acedmic'));
$classess = $this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();


	$this->set('classess', $classess);
	
	
	$sectionslist = $this->Sections->find('list', [
    'keyField' => 'id',
    'valueField' => 'title'
])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist',$sectionslist);
		  $articles = TableRegistry::get('Students');
$studentcnt= $articles->find('all')->where(['Students.status'=>'Y','Students.acedmicyear'=>$acedmic])->count();
	
$this->set('studentcnt', $studentcnt);
$connss = ConnectionManager::get('default');

$date=date('Y-m-d');
$this->set('date', $date);

				/* $studentrfidsd=$connss->execute("SELECT * FROM `attendreports` LEFT JOIN students ON attendreports.rfid = students.rf_id 
LEFT JOIN classes ON students.class_id = classes.id  WHERE  
DATE(attendreports.resultdate)='".date('Y-m-d')."' AND students.status 
='Y' GROUP BY attendreports.rfid  ORDER BY classes.sort ASC,students.section_id ASC");
				
				$studentrfidsd=$studentrfidsd->fetchAll('assoc');	
			pr($studentrfidsd); die;
				$this->set(compact('studentrfidsd')); */






}
public function classidcard_search(){
	//pr($this->request->data); die; 
	$date=$this->request->data['date'];
	$this->set(compact('date'));
	//pr($date); die;
$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

$acedmic=$users['academic_year'];
$this->set(compact('acedmic'));
$classess = $this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();


	$this->set('classess', $classess);
	
	
	$sectionslist = $this->Sections->find('list', [
    'keyField' => 'id',
    'valueField' => 'title'
])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist',$sectionslist);
		  $articles = TableRegistry::get('Students');
$studentcnt= $articles->find('all')->where(['Students.status'=>'Y','Students.acedmicyear'=>$acedmic])->count();
	
$this->set('studentcnt', $studentcnt);
$connss = ConnectionManager::get('default');

				/* $studentrfidsd=$connss->execute("SELECT * FROM `attendreports` LEFT JOIN students ON attendreports.rfid = students.rf_id 
LEFT JOIN classes ON students.class_id = classes.id  WHERE  
DATE(attendreports.resultdate)='".date('Y-m-d',strtotime($date))."' AND students.status 
='Y' GROUP BY attendreports.rfid  ORDER BY classes.sort ASC,students.section_id ASC");
				
				$studentrfidsd=$studentrfidsd->fetchAll('assoc');	
			//pr($studentrfidsd); die;
				$this->set(compact('studentrfidsd')); */






}
public function presentreport(){
	$this->viewBuilder()->layout('admin');
	
$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

$acedmic=$users['academic_year'];
$this->set(compact('acedmic'));

$connss = ConnectionManager::get('default');

				$studentrfidsd=$connss->execute("SELECT * FROM `attendreports` LEFT JOIN students ON attendreports.rfid = students.rf_id 
LEFT JOIN classes ON students.class_id = classes.id  WHERE  
DATE(attendreports.resultdate)='".date('Y-m-d')."' AND students.status ='Y' GROUP BY attendreports.rfid  ORDER BY sort ASC,section_id ASC");
				
				$studentrfidsd=$studentrfidsd->fetchAll('assoc');	
			//pr($studentrfidsd);
				$this->set(compact('studentrfidsd'));






}

public function searchrfidreport(){
	

	
	
			$datefrom=date('Y-m-d',strtotime($this->request->data['datefrom']));
			$dateto2=date('Y-m-d',strtotime($this->request->data['dateto']));
	
	
			if(!empty($datefrom) && $datefrom!='1970-01-01')
{
	$datefrom23=$datefrom;
}
 

if(!empty($dateto2) && $dateto2!='1970-01-01')
{
	$dateto23=$dateto2;
} 

	
	

	
$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

$acedmic=$users['academic_year'];
$this->set(compact('acedmic'));

$connss = ConnectionManager::get('default');

				$studentrfidsd=$connss->execute("SELECT * FROM `attendreports` LEFT JOIN students ON attendreports.rfid = students.rf_id 
LEFT JOIN classes ON students.class_id = classes.id  WHERE  
DATE(attendreports.resultdate) >='".$datefrom23."' AND DATE(attendreports.resultdate) <='".$dateto23."' AND students.status ='Y' GROUP BY attendreports.rfid  ORDER BY sort ASC,section_id ASC");
				
				$studentrfidsd=$studentrfidsd->fetchAll('assoc');	
			//pr($studentrfidsd);
				$this->set(compact('studentrfidsd'));






}



public function makingidcardreport(){
	
		$this->viewBuilder()->layout('admin');
	
$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

$acedmic=$users['academic_year'];
$this->set(compact('acedmic'));

$connss = ConnectionManager::get('default');

				$studentrfidsd=$connss->execute("SELECT * FROM students 
LEFT JOIN classes ON students.class_id = classes.id  WHERE  rf_id='0' 
AND students.status ='Y' ORDER BY classes.sort ASC,section_id ASC");
				
				$studentrfidsd=$studentrfidsd->fetchAll('assoc');	
			//pr($studentrfidsd);
				$this->set(compact('studentrfidsd'));

	
}




public function searchabsentshow($errt=null)
	{
		
		
		
		
		$this->viewBuilder()->layout('admin');

		
	$eee=explode(',',$errt);

	$da=date('Y-m-d');
	
	$e= explode(',',base64_decode($eee[0]));   $rd= explode(',',base64_decode($eee[1]));

	
$pii=array('Studattends.date'=>$da);
$apk[]=$pii;




if($e && $rd){
	
		$conlns = ConnectionManager::get('default'); 



$conlns->execute("DELETE FROM tmp_allattendence WHERE 1=1"); 
	
}
	
$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
$acedmic=$users['academic_year'];
$pii=array('Studattends.acedemic' => $acedmic);
$pisi=array('Studattends.status' =>'A');
$apk[]=$pii;
$apk[]=$pisi;


		$attendenceentry = $this->Studattends->find('all')->contain(['Students'=>['Classes']])->where($apk)->order(['Classes.sort' => 'ASC'])->toarray();
	
		$romsm=sizeof($attendenceentry);
		
		
		
		for($is=0;$is<$romsm;$is++)
					{
		$connssss = ConnectionManager::get('default');
		

		
				$connssss->execute("INSERT INTO 
				`tmp_allattendence`(`st_id`, `class_id`, `section_id`, 
				`status`, `status_m`, `sort`) VALUES 
				('".$attendenceentry[$is]['student']['id']."','".$attendenceentry[$is]['student']['class_id']."','".$attendenceentry[$is]['student']['section_id']."','".$attendenceentry[$is]['status']."','".$attendenceentry[$is]['status_m']."','".$attendenceentry[$is]['student']['class']['sort']."')");
	
}
		
		

		
		
		$romm=sizeof($e);
		
		for($i=0;$i<$romm;$i++)
					{
						
						
		$connss = ConnectionManager::get('default');
		
		$da=date('Y-m-d');
 $cnt=$this->Studattends->find('all')->where(['Studattends.class_id' =>$e[$i],'Studattends.section_id' =>$rd[$i],'Studattends.date' =>$da])->count();
 
 if($cnt<=0){
				$studentrfidsd=$connss->execute("SELECT 
				students.id,students.class_id,students.section_id,classes.sort FROM `students`, `classes` WHERE students.class_id = 
				classes.id AND students.id 
				NOT IN  (SELECT students.id FROM `attendreports` LEFT JOIN students 
				ON attendreports.rfid = students.rf_id LEFT JOIN classes ON 
				students.class_id = classes.id  WHERE students.rf_id !='0' AND 
				students.status='Y' AND students.class_id ='".$e[$i]."' AND 
				students.section_id ='".$rd[$i]."' AND 
				DATE(attendreports.resultdate)='".date('Y-m-d')."' GROUP BY 
				attendreports.rfid  ORDER BY section_id ASC) AND students.class_id 
				='".$e[$i]."' AND students.section_id ='".$rd[$i]."' ORDER BY 
				classes.sort ASC");
				
				 $attendenceentry2=$studentrfidsd->fetchAll('assoc');	
				 
				 foreach($attendenceentry2 as $f=>$rst){
					$connsssks = ConnectionManager::get('default');
		

				 $connsssks->execute("INSERT INTO 
				`tmp_allattendence`(`st_id`, `class_id`, `section_id`, 
				`status`, `status_m`, `sort`) VALUES 
				('".$rst['id']."','".$rst['class_id']."','".$rst['section_id']."','A','A','".$rst['sort']."')");
	
				 }
				 
				
			 }
				  
				
			 }
			 
			 $allabsent=$connss->execute("SELECT * FROM `tmp_allattendence` ORDER BY 
				sort,section_id ASC");
				
				 $allabsent=$allabsent->fetchAll('assoc');	 
			
	$this->set(compact('allabsent'));
	
	
	
	}
	
	
	public function summaryprospectus($board=null,$m=null){
				$this->viewBuilder()->layout('admin');
		
$date=date('Y-m-d');

if($board=='cbse'){

 $prospectussummary=$this->Enquires->find('all')->where(['DATE(Enquires.created)'=>$date,'Enquires.recipietno !='=>'0','Enquires.mode1_id'=>$m,'Enquires.status'=>'Y'])->order(['Enquires.created'=>'ASC'])->toarray();
 
}else if($board=='int'){
	
	 $prospectussummary=$this->Enquires->find('all')->where(['DATE(Enquires.created)'=>$date,'Enquires.recipietno !='=>'0','Enquires.mode1_id !='=>$m,'Enquires.status'=>'Y'])->order(['Enquires.created'=>'ASC'])->toarray();
}else if($board=='total'){
	
	 $prospectussummary=$this->Enquires->find('all')->where(['DATE(Enquires.created)'=>$date,'Enquires.recipietno !='=>'0','Enquires.status'=>'Y'])->order(['Enquires.created'=>'ASC'])->toarray();
}
	$this->set(compact('prospectussummary'));
	}
	
	
	public function summaryprospectusacedmic($board=null,$acedmic=null){
				$this->viewBuilder()->layout('admin');
		
$date=date('Y-m-d');

$this->set(compact('acedmic'));
if($board=='cbse'){
	
 $prospectussummary=$this->Enquires->find('all')->where(['Enquires.acedmicyear'=>$acedmic,'Enquires.mode1_id'=>'1','Enquires.recipietno !='=>'0','Enquires.status'=>'Y'])->order(['Enquires.created'=>'ASC'])->toarray();
 
}else if($board=='int'){
	
	 $prospectussummary=$this->Enquires->find('all')->where(['Enquires.acedmicyear'=>$acedmic,'Enquires.mode1_id !='=>'1','Enquires.recipietno !='=>'0','Enquires.status'=>'Y'])->order(['Enquires.created'=>'ASC'])->toarray();
}else if($board=='total'){
	
	 $prospectussummary=$this->Enquires->find('all')->where(['Enquires.acedmicyear'=>$acedmic,'Enquires.recipietno !='=>'0','Enquires.status'=>'Y'])->order(['Enquires.created'=>'ASC'])->toarray();
}
	$this->set(compact('prospectussummary'));
	}
	
	public function summaryregistration($board=null,$m=null){
				$this->viewBuilder()->layout('admin');
		
$date=date('Y-m-d');

if($board=='cbse'){

 $registrationsummary=$this->Applicant->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)'=>$date,'Applicant.recipietno !='=>'0','Enquires.mode1_id'=>$m])->order(['Applicant.created'=>'ASC'])->toarray();
 
}else if($board=='int'){
	
 $registrationsummary=$this->Applicant->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)'=>$date,'Applicant.recipietno !='=>'0','Enquires.mode1_id !='=>$m])->order(['Applicant.created'=>'ASC'])->toarray();
}else if($board=='total'){
	
		
 $registrationsummary=$this->Applicant->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)'=>$date,'Applicant.recipietno !='=>'0'])->order(['Applicant.created'=>'ASC'])->toarray();
}
	$this->set(compact('registrationsummary'));
	}
	
	
	public function summaryregistrationacedmic($board=null,$acedmic=null){
				$this->viewBuilder()->layout('admin');
		
$date=date('Y-m-d');

$this->set(compact('acedmic'));
if($board=='cbse'){
	
$registrationsummary=$this->Applicant->find('all')->contain(['Enquires'])->where(['Applicant.acedmicyear'=>$acedmic,'Applicant.recipietno !='=>'0','Applicant.status_c'=>'Y','Enquires.mode1_id'=>'1'])->order(['Applicant.created'=>'ASC'])->toarray();

}else if($board=='int'){
	
	$registrationsummary=$this->Applicant->find('all')->contain(['Enquires'])->where(['Applicant.acedmicyear'=>$acedmic,'Applicant.recipietno !='=>'0','Applicant.status_c'=>'Y','Enquires.mode1_id !='=>'1'])->order(['Applicant.created'=>'ASC'])->toarray();
}else if($board=='total'){
	
$registrationsummary=$this->Applicant->find('all')->contain(['Enquires'])->where(['Applicant.acedmicyear'=>$acedmic,'Applicant.status_c'=>'Y','Applicant.recipietno !='=>'0'])->order(['Applicant.created'=>'ASC'])->toarray();
}
	$this->set(compact('registrationsummary'));
	}	


public function admissionsummary($board=null,$m=null){
				$this->viewBuilder()->layout('admin');
		
$date=date('Y-m-d');

if($board=='cbse'){

 $admissionsummary=$this->Students->find('all')->where(['DATE(Students.created)'=>$date,'Students.status'=>'Y','Students.board_id'=>$m])->order(['Students.created'=>'ASC'])->toarray();
 
}else if($board=='int'){
	
$admissionsummary=$this->Students->find('all')->where(['DATE(Students.created)'=>$date,'Students.status'=>'Y','Students.board_id !='=>$m])->order(['Students.created'=>'ASC'])->toarray();
}else if($board=='total'){
	
$admissionsummary=$this->Students->find('all')->where(['DATE(Students.created)'=>$date,'Students.status'=>'Y'])->order(['Students.created'=>'ASC'])->toarray();
}
	$this->set(compact('admissionsummary'));
	}
	
	
	public function admissionsummaryacedmicold($board=null,$acedmic=null){
				$this->viewBuilder()->layout('admin');
		
$date=date('Y-m-d');

$this->set(compact('acedmic'));
if($board=='cbse'){
	
	
	
	
$admissionsummary=$this->Students->find('all')->where(['Students.admissionyear'=>$acedmic,'Students.board_id'=>'1'])->order(['Students.created'=>'ASC'])->toarray();

$admissionsummary2=$this->DropOutStudent->find('all')->where(['DropOutStudent.admissionyear'=>$acedmic,'DropOutStudent.board_id'=>'1'])->order(['DropOutStudent.created'=>'ASC'])->toarray();

}else if($board=='int'){
	
$admissionsummary=$this->Students->find('all')->where(['Students.admissionyear'=>$acedmic,'Students.board_id !='=>'1'])->order(['Students.created'=>'ASC'])->toarray();

$admissionsummary2=$this->DropOutStudent->find('all')->where(['DropOutStudent.admissionyear'=>$acedmic,'DropOutStudent.board_id !='=>'1'])->order(['DropOutStudent.created'=>'ASC'])->toarray();
}else if($board=='total'){
	
$admissionsummary=$this->Students->find('all')->where(['Students.admissionyear'=>$acedmic])->order(['Students.created'=>'ASC'])->toarray();

$admissionsummary2=$this->DropOutStudent->find('all')->where(['DropOutStudent.admissionyear'=>$acedmic])->order(['DropOutStudent.created'=>'ASC'])->toarray();
}
	$this->set(compact('admissionsummary'));
	$this->set(compact('admissionsummary2'));
	
	}
	
	
	
public function admissionsummaryacedmic($board=null,$acedmic=null){
	$this->viewBuilder()->layout('admin');
	$users = $this->Users->find('all')->where(['Users.id' =>'1'])->first();
    $currentyear=$users['academic_year'];
    $next_academic_year=$users['next_academic_year'];
    $apk=array();
    $apk1=array();;

	
	
if($board=='cbse'){
	
	 $next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){
	

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('Students.board_id' =>1);
$apk[]=$stts;

		$stts=array('Students.status' =>'Y');
$apk[]=$stts;
		
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.created'=>'ASC'])->toarray();
	
}else if($acedmic!=$currentyear){
		
$stts=array('Studentshistory.board_id' =>1);
$apk[]=$stts;

$stts=array('Studentshistory.admissionyear' =>$acedmic);
$apk[]=$stts;

		
$admissionsummary=$this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.created'=>'ASC'])->toarray();
	//pr($admissionsummary); die;
	}else{
		
	

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('Students.board_id' =>1);
$apk[]=$stts;

		$stts=array('Students.status' =>'Y');
$apk[]=$stts;
		
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.created'=>'ASC'])->toarray();
}


$stts=array('DropOutStudent.board_id' => 1);
$apk1[]=$stts;



	
if($acedmic==$currentyear){
	
	$stts=array('DropOutStudent.admissionyear' =>$acedmic);
 $apk1[]=$stts;	
$admissionsummary2=$this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.created'=>'ASC'])->toarray();
		
	
}else{
	
	foreach($admissionsummary as $kk=>$jj){
		
		$idd[]=$jj['student_id'];
		
			
	}
	
	$stts=array('DropOutStudent.s_id NOT IN' =>$idd);
 $apk1[]=$stts;	
 
	$stts=array('DropOutStudent.admissionyear' =>$acedmic);
 $apk1[]=$stts;	
$admissionsummary2=$this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.created'=>'ASC'])->toarray();
		//pr($Classections21); die;
}



if(!empty($admissionsummary2))
{
$registrationsummary=array_merge($admissionsummary,$admissionsummary2);
}
else{
	$registrationsummary=$admissionsummary;
}


//pr($registrationsummary); die;
$this->set(compact('registrationsummary'));

	
	
	
	


}else if($board=='int'){
	

		 $next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){
	
	
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('Students.board_id IN' =>['2','3']);
$apk[]=$stts;
$stts=array('Students.status' =>'Y');
$apk[]=$stts;
				
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();

}else if($acedmic!=$currentyear){
		

$stts=array('Studentshistory.board_id IN' =>['2','3']);
$apk[]=$stts;
$stts=array('Studentshistory.admissionyear' =>$acedmic);
$apk[]=$stts;

		
$admissionsummary=$this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id'=>'ASC'])->toarray();

	}else{
		
	

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('Students.board_id IN' =>['2','3']);
$apk[]=$stts;
$stts=array('Students.status' =>'Y');
$apk[]=$stts;
				
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
}



		

$stts=array('DropOutStudent.board_id IN' =>['2','3']);
$apk1[]=$stts;
$stts=array('DropOutStudent.admissionyear' =>$acedmic);
$apk1[]=$stts;

if($acedmic==$currentyear){
	
		
$admissionsummary2=$this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.id'=>'ASC'])->toarray();
		//pr($Classections21); die;
	
}else{
	
	foreach($admissionsummary as $kk=>$jj){
		
		$idd[]=$jj['student_id'];
		
			
	}
	
	$stts=array('DropOutStudent.s_id NOT IN' =>$idd);
 $apk1[]=$stts;	
 
	$stts=array('DropOutStudent.admissionyear' =>$acedmic);
 $apk1[]=$stts;	
$admissionsummary2=$this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.id'=>'ASC'])->toarray();
		//pr($Classections21); die;
}



if(!empty($admissionsummary2))
{
$registrationsummary=array_merge($admissionsummary,$admissionsummary2);
}
else{
	$registrationsummary=$admissionsummary;
}


//pr($registrationsummary); die;
$this->set(compact('registrationsummary'));

	
	

	
}else if($board=='total'){
	
	 $next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){
	

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;
$stts=array('Students.status' =>'Y');
$apk[]=$stts;
				
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
	
}else if($acedmic!=$currentyear){
		


$stts=array('Studentshistory.admissionyear' =>$acedmic);
$apk[]=$stts;

		
$admissionsummary=$this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id'=>'ASC'])->toarray();

	}else{
		
	

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;
$stts=array('Students.status' =>'Y');
$apk[]=$stts;
				
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
}


		


$stts=array('DropOutStudent.admissionyear' =>$acedmic);
$apk1[]=$stts;

if($acedmic==$currentyear){
	
		
$admissionsummary2=$this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.id'=>'ASC'])->toarray();
		//pr($Classections21); die;
	
}else{
	
	foreach($admissionsummary as $kk=>$jj){
		
		$idd[]=$jj['student_id'];
		
			
	}
	
	$stts=array('DropOutStudent.s_id NOT IN' =>$idd);
 $apk1[]=$stts;	
 
	$stts=array('DropOutStudent.admissionyear' =>$acedmic);
 $apk1[]=$stts;	
$admissionsummary2=$this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.id'=>'ASC'])->toarray();
		//pr($Classections21); die;
}



if(!empty($admissionsummary2))
{
$registrationsummary=array_merge($admissionsummary,$admissionsummary2);
}
else{
	$registrationsummary=$admissionsummary;
}

//pr($registrationsummary); die;
$this->set(compact('registrationsummary'));

	
	

	
}


	

}


	
public function admissionsummaryacedmic2($board=null,$acedmic=null){
	$this->viewBuilder()->layout('admin');
	$users = $this->Users->find('all')->where(['Users.id' =>'1'])->first();
    $currentyear=$users['academic_year'];
    $apk=array();
    $apk1=array();;

	
	
if($board=='cbse'){
	
	 $next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){
	
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('Students.board_id' =>1);
$apk[]=$stts;

		$stts=array('Students.status' =>'Y');
$apk[]=$stts;
		
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.created'=>'ASC'])->toarray();

}elseif($acedmic!=$currentyear){
		
$stts=array('Studentshistory.board_id' =>1);
$apk[]=$stts;

$stts=array('Studentshistory.admissionyear' =>$acedmic);
$apk[]=$stts;

		
$admissionsummary=$this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.created'=>'ASC'])->toarray();
	//pr($admissionsummary); die;
	}else{
		
	

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('Students.board_id' =>1);
$apk[]=$stts;

		$stts=array('Students.status' =>'Y');
$apk[]=$stts;
		
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.created'=>'ASC'])->toarray();
}



	$registrationsummary=$admissionsummary;



//pr($registrationsummary); die;
$this->set(compact('registrationsummary'));

	
	
	
	


}else if($board=='int'){
	

	 $next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){
	
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('Students.board_id' =>1);
$apk[]=$stts;

		$stts=array('Students.status' =>'Y');
$apk[]=$stts;
		
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.created'=>'ASC'])->toarray();

}else if($acedmic!=$currentyear){
		

$stts=array('Studentshistory.board_id IN' =>['2','3']);
$apk[]=$stts;
$stts=array('Studentshistory.admissionyear' =>$acedmic);
$apk[]=$stts;

		
$admissionsummary=$this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id'=>'ASC'])->toarray();

	}else{
		
	

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('Students.board_id IN' =>['2','3']);
$apk[]=$stts;
$stts=array('Students.status' =>'Y');
$apk[]=$stts;
				
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
}



	
	$registrationsummary=$admissionsummary;



//pr($registrationsummary); die;
$this->set(compact('registrationsummary'));

	
	

	
}


	

}



	public function searchabsent($class_id=null,$section_id=null,$date=null)
	{
		$this->viewBuilder()->layout('admin');

			if(!empty($class_id))
{
	if($date==null){
	    		$da=date('Y-m-d');
			}
			else{
				$da=date('Y-m-d',strtotime($date));
			}
	
	//pr($da); die;
	
			$this->set(compact('class_id'));
			$this->set(compact('section_id'));
		
		if(!empty($class_id))
{
$pii=array('Studattends.class_id'=>$class_id);
$apk[]=$pii;
}


		if(!empty($section_id))
{
$pii=array('Studattends.section_id'=>$section_id);
$apk[]=$pii;
}
	
	
$pii=array('Studattends.date'=>$da);
$apk[]=$pii;





	
$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
$acedmic=$users['academic_year'];
$pii=array('Studattends.acedemic' => $acedmic);
$pisi=array('Studattends.status' =>'A');
$apk[]=$pii;
$apk[]=$pisi;

		$attendenceentry = $this->Studattends->find('all')->contain(['Students'])->where($apk)->order(['Students.fname' => 'ASC'])->toarray();
		
		$this->set(compact('attendenceentry'));
		
			$connss = ConnectionManager::get('default');
		
		
		$studentrfsidsd=$connss->execute("SELECT * FROM `students`, `classes` WHERE students.class_id = 
				classes.id AND students.id 
				NOT IN  (SELECT students.id FROM `attendreports` LEFT JOIN students 
				ON attendreports.rfid = students.rf_id LEFT JOIN classes ON 
				students.class_id = classes.id  WHERE students.rf_id !='0' AND 
				students.status='Y' AND students.class_id ='".$class_id."' AND 
				students.section_id ='".$section_id."' AND 
				DATE(attendreports.resultdate)='".date('Y-m-d')."' GROUP BY 
				attendreports.rfid  ORDER BY section_id ASC) AND students.class_id 
				='".$class_id."' AND students.section_id ='".$section_id."' ORDER BY 
				classes.sort ASC");
				
				 $attendenceentry2=$studentrfsidsd->fetchAll('assoc');	
		$this->set(compact('attendenceentry2'));
}


	}


		// search functionality
		public function search(){ 

		//show all data in listing page
		//connection
				$conn = ConnectionManager::get('default');

				$year=$this->request->data['acedmicyear']; 
				$class=join("','",$this->request->data['class_id']); 
				
			
				
				$admission=$this->request->data['admissionyear'];
				$is_promote=$this->request->data['is_promote'];
				$section=join("','",$this->request->data['section_id']); 
				$enroll=$this->request->data['enroll'];
				$fname=$this->request->data['fname']; 
	
				$detail="SELECT Students.id,Students.enroll,Students.sms_mobile,Students.fname,Students.fathername,Students.mothername,Students.middlename,Students.lname,Students.mobile,Students.acedmicyear,Students.class_id,Students.created,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id    WHERE  1=1 ";

				$cond = ' ';
				if(!empty($year))
				{

					$cond.=" AND Students.acedmicyear ='".$year."'";

				}

if(!empty($is_promote))
				{
					if($is_promote=='3'){
		$cond.=" AND Students.oldenroll !='0'";
}else if($is_promote=='2'){
		$cond.=" AND Students.is_promote ='0'";
}else{
					$cond.=" AND Students.is_promote ='".$is_promote."'";
}
				}


				if(!empty($class))
				{

					$cond.=" AND Students.class_id IN ('".$class."')";


				}

			



				if(!empty($section))
				{

					$cond.=" AND Students.section_id IN ('".$section."')";


				}

				if(!empty($enroll))
				{

					$cond.=" AND Students.enroll LIKE '".$enroll."' ";


				}

				if(!empty($fname))
				{

					$cond.=" AND UPPER(Students.fname) LIKE '".strtoupper($fname)."%' ";


				}
			
				$rolepresent=$this->request->session()->read('Auth.User.role_id');
		if($rolepresent=='5'){ 
	  $cond.=" AND Students.board_id LIKE '1'";
	
}else if($rolepresent=='8'){ 
	

		  $cond.=" AND Students.board_id IN (2,3)";
	
}
  $cond.=" AND Students.status ='Y'";
				$detail = $detail.$cond;
				$SQL = $detail." ORDER BY Students.enroll DESC";  

				$results = $conn->execute( $SQL )->fetchAll('assoc');
//pr( $results); die;
				$this->set('students', $results);

			}


			public function savepromotestudent(){

				if($this->request->is(['post', 'put'])){



		

		  	

				
					$alldata = $this->Classfee->find('all')->contain(['Feesheads'])->where(['fee_h_id'=>'2','class_id' =>$this->request->data['class_id'],'academic_year' =>$this->request->data['academicyear']])->first();
			if($alldata['id']){
					$romm=sizeof($this->request->data['stud_id']);
					
					$due=0;
			
					for($i=0;$i<$romm;$i++)
					{
				
$student = $this->Students->get($this->request->data['stud_id'][$i])->toArray();
	    	$student['stud_id'] = $student['id'];
	    	$student['actionhistory']=$this->request->data['action'];
	   

	    	try
	    	{
				
					$userTable = TableRegistry::get('Studentshistory');
			$exists = $userTable->exists(['stud_id' =>$student['stud_id']]);
						if($exists){
							
						}else{
	    	
	    	$studentshistory = $this->Studentshistory->newEntity();
		    	$studentshistory = $this->Studentshistory->patchEntity($studentshistory, $student);
		    $studentshistory['id']='';
		    	$this->Studentshistory->save($studentshistory);

	    			 
	    	
				} 
	    			 
	    			 
					
					  	$peopleTable = TableRegistry::get ('Students');
							 if($this->request->data['class_id']=="23" || $this->request->data['class_id']=="24" || $this->request->data['class_id']=="25" || $this->request->data['class_id']=="28" || $this->request->data['class_id']=="29"){
		
		$this->request->data['board_id']='2';
	}else if($this->request->data['class_id']=="26" || $this->request->data['class_id']=="27"){
		$this->request->data['board_id']='3';
		
		
	}else{
		$this->request->data['board_id']='1';
	}  	

					$oQuery = $peopleTable->query();
					$oQuery->update();
						$oQuery->set (['board_id' =>$this->request->data['board_id'],'class_id' =>$this->request->data['class_id'],'acedmicyear' =>$this->request->data['academicyear'],'section_id'=>$this->request->data['section_id'],'due_fees'=>$this->request->data['duefees'][$i],'is_promote'=>'1'])->where(['id'=>$this->request->data['stud_id'][$i]]);
				

		$oQuery->execute ();

		
						}catch (\PDOException $e) {
							
						}
	    	


					}
					
					
					
					
			

					//~ $classsectionid=$this->request->data['classsectionid'];


					//~ $conn = ConnectionManager::get('default'); 

    //~ // $conn->execute("UPDATE `classections` SET `teacher_id` = '' WHERE `id` ='".$classsectionid."'"); 
					//~ $conn->execute("DELETE FROM classtime_tabs WHERE class_id='".$classsectionid."'"); 






					$this->Flash->success(__('Promoted Student sucessfully.'));
					return $this->redirect(['action' => 'promote']);	
   }else{
	   $this->Flash->error(__('Tution Fee of Selected Academic Year does not exist ,Please be sure !!!!'));
	   
	   $student = $this->Students->get($this->request->data['stud_id'][0])->toArray();
	   
	 
	    	$class = $student['class_id'];
	    	$section = $student['section_id'];
	    	$year = $student['acedmicyear'];
			return $this->redirect(['action' => 'promote/'.$class.'/'.$section.'/'.$year]);	
	   
	   
   }
				}

			}




			public function viewgenratepdf(){
	//$this->viewBuilder()->layout('admin');


				if ($this->request->is(['post', 'put'])) {
					$year=$this->request->data['year']; 
					$this->set('year', $year);
					$class=$this->request->data['class'];
					$print=$this->request->data['print'];
					$this->set('print', $print);
					$session = $this->request->session();
					if($class){



						$session->delete('class'); 
						$session->write('class', $class);

					}
					$ids=$this->request->data['stud_id'];
					if($ids){
						$session->delete('ids'); 
						$session->write('ids', $ids);		
						
					}
					$validdate=$this->request->data['validdate'];
					if($validdate){
						$session->delete('validdate'); 
						$session->write('validdate', $validdate);		
						
					}

					$enroll=$this->request->data['enroll'];


					$this->set('validdate', $validdate);
					$this->viewBuilder()->layout('ajax');
					$this->response->type('pdf');
					$students = $this->Students->find('all')->contain(['Classes','Sections','Address'])->where(['Students.id IN' =>$ids,'Students.status' =>'Y'])->toarray();
					$this->set(compact('students'));




				}


			}
			public function viewgenratepdf2(){
	//$this->viewBuilder()->layout('admin');


				if ($this->request->is(['post', 'put'])) {
					$year=$this->request->data['year']; 
					$this->set('year', $year);
					$class=$this->request->data['class'];
					$ids=$this->request->data['stud_id'];
					$fname=$this->request->data['fname'];
					$enroll=$this->request->data['enroll'];


					$this->viewBuilder()->layout('ajax');
					$this->response->type('pdf');
					$students = 
					$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id IN' =>$ids,'Students.status' =>'Y'])->first()->toarray();
					$this->set(compact('students'));





				}


			}
		public function viewpromotestudent(){

				$this->viewBuilder()->layout('admin');
				$classes = $this->Classections->find('list', [
					'keyField' => 'Classes.id',
					'valueField' => 'Classes.title'
					])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'asc'])->toArray();
				$this->set('classes', $classes);


				$sectionslist = $this->Sections->find('list', [
					'keyField' => 'id',
					'valueField' => 'title'
					])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
				$this->set('sectionslist',$sectionslist);


				if ($this->request->is(['post', 'put'])) {


					$section=$this->request->data['section']; 
					$this->set('sectionid', $section);
					$year=$this->request->data['year']; 
					$this->set('year', $year);
					$class=$this->request->data['class'];
					$this->set('classid', $class);
					$ids=$this->request->data['stud_id'];
				
					foreach($ids as $key=>$sid){
						


					} 

				/*			if($studentc){
								$nid=implode(',',$studentc); 
						$this->Flash->error(__('Student   id: '.$nid.' record  not found in exam result.', h($id)));
		return $this->redirect(['action' => 'promote/'.$class.'/'.$section.'/'.$year]);		
							}
							
							
							if($sdd){
								$nid=implode(',',$sdd);
								
						$this->Flash->error(__('Student   id: '.$nid.' record   found in Issuebook Module.', h($id)));
		return $this->redirect(['action' => 'promote/'.$class.'/'.$section.'/'.$year]);		
	}  */

	$clasectiom =$this->Classections->find('all')->where(['Classections.class_id' => $class,'Classections.section_id' =>$section])->order(['Classections.id DESC'])->first(); 
	$csid=$clasectiom['id'];
	$this->set('csid', $csid);
	$sections =$this->Sections->find('all')->where(['Sections.id' => $section])->order(['Sections.id DESC'])->first();
	$classes =$this->Classes->find()->where(['Classes.id' => $class])->order(['Classes.id DESC'])->first()->toarray();
	$this->set('class', $classes['title']);
	$this->set('section', $sections['title']);
	$action=$this->request->data['action']; 
	$this->set('action', $action);
	$students =$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id IN' => $ids,'Students.status' =>'Y','Students.is_promote' =>'0'])->order(['Sections.id ASC','Students.fname ASC'])->toarray();


	$this->set('students', $students);
	$empteacher =$this->Employees->find()->where(['Employees.designation_id' => '4'])->order(['Employees.id DESC'])->toarray();


	$this->set('empteacher', $empteacher);
}


}

public function findperticularamount($id,$a_year)
{

	return $this->Studentfees->find('all')->select(['id', 'fee','discount','amount'])->where(['Studentfees.student_id' =>$id,'Studentfees.acedmicyear'=>$a_year])->toArray();
} 

public function findamount($id,$a_year)
{
      // pr ($rout); die;
        // Use the HTML helper to output
        // Formatted data:
	$articles = TableRegistry::get('Classfee');

// Start a new query.

	
	return	 $articles->find('all')->contain(['Classes'])->group('Classfee.academic_year')->group('Classfee.class_id')->select(['qu1_fees' =>  $articles->find()->func()->sum('Classfee.qu1_fees'), 'qu2_fees' =>  $articles->find('all')->func()->sum('Classfee.qu2_fees'), 'qu3_fees' =>  $articles->find('all')->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $articles->find('all')->func()->sum('Classfee.qu4_fees'),'Classes.title','Classfee.academic_year','Classfee.id','Classfee.status','Classfee.class_id'
		])->where(['Classfee.class_id' =>$id ,'Classfee.academic_year' =>$a_year  ])->order(['Classfee.id' => 'ASC'])->toArray();
}  


public function findstuduefees($id=null,$year=null){ 
	$articles = TableRegistry::get('Students');
	return	$articles->find('all')->where(['Students.id' => $id,'Students.status' =>'Y'])->select(['due_fees'])->toarray();
}	



public function promotesearch(){
	
	
	
	
	//show all data in listing page
		//connection
	$conn = ConnectionManager::get('default');

	$year=$this->request->data['acedmicyear']; 
	$year=$this->request->data['acedmicyear']; 
	$this->set('year', $year);


	$class=$this->request->data['class_id'];
	$this->set('class', $class);
	$admission=$this->request->data['admissionyear'];

	$section=$this->request->data['section_id']; 
	$this->set('section', $section);
	$enroll=$this->request->data['enroll'];
	$fname=$this->request->data['fname']; 

	$detail="SELECT Students.id,Students.enroll,Students.category,Students.fname,Students.middlename,Students.lname,Students.sms_mobile,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id   WHERE  1=1 ";

	$cond = ' ';
	if(!empty($year))
	{

		$cond.=" AND Students.acedmicyear LIKE '".$year."' ";
	}


	if(!empty($class))
	{

		$cond.=" AND Students.class_id LIKE '".$class."' ";


	}

	


	if(!empty($section))
	{

		$cond.=" AND Students.section_id LIKE '".$section."' ";


	}

	if(!empty($enroll))
	{

		$cond.=" AND Students.enroll LIKE '".$enroll."' ";


	}

	if(!empty($fname))
	{

		$cond.=" AND UPPER(Students.fname) LIKE '".strtoupper($fname)."%' ";


	}
	
	
		$cond.=" AND Students.status='Y'";
		$cond.=" AND Students.is_promote='0'";
	$detail = $detail.$cond;
	$SQL = $detail." ORDER BY Students.section_id, Students.fname ASC";  

	$results = $conn->execute( $SQL )->fetchAll('assoc');

	$this->set('students', $results);
	
	
	
	
	
	
	
	
}

public function genrateidsearch(){
	
	
	
	
	//show all data in listing page
		//connection
	$conn = ConnectionManager::get('default');

	$year=$this->request->data['acedmicyear']; 
	$year=$this->request->data['acedmicyear']; 
	$this->set('year', $year);

	$class=$this->request->data['class_id'];
	$this->set('class', $class);
	$admission=$this->request->data['admissionyear'];

	$section=$this->request->data['section_id']; 
	$this->set('section', $section);
	$enroll=$this->request->data['enroll'];
	$this->set('enroll', $enroll);
	$fname=$this->request->data['fname']; 
	$this->set('fname', $fname);
	$detail="SELECT Students.id,Students.fname,Students.dob,Students.fathername,Students.mobile,Students.address,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id    WHERE  1=1 ";

	$cond = ' ';
	if(!empty($year))
	{

		$cond.=" AND Students.acedmicyear LIKE '".$year."%' ";

	}


	if(!empty($class))
	{

		$cond.=" AND Students.class_id LIKE '".$class."' ";


	}




	if(!empty($section))
	{

		$cond.=" AND Students.section_id LIKE '".$section."%' ";


	}

	if(!empty($enroll))
	{

		$cond.=" AND Students.enroll LIKE '".$enroll."%' ";


	}

	if(!empty($fname))
	{

		$cond.=" AND UPPER(Students.fname) LIKE '".strtoupper($fname)."%' ";


	}
	
	
	$cond.=" AND Students.status='Y'";
	$detail = $detail.$cond;
	$SQL = $detail." ORDER BY Students.id DESC";  

	$results = $conn->execute( $SQL )->fetchAll('assoc');

	$this->set('students', $results);
	
	
	
	
	
	
	
	
}
	//status update functionality
public function status($id,$status){

	$statusquery = $this->Students->find('all')->where(['Students.status' => 'Y'])->count();
	if(isset($id) && !empty($id)){
		if($status == 'Y' ){

			$status = 'N';
			//status update
			$classes = $this->Students->get($id);
			$classes->status = $status;
			if ($this->Students->save($classes)) {
				$this->Flash->success(__('Your students status has been updated.'));
				return $this->redirect(['action' => 'index']);	
			}
		}else{

			$status = 'Y';
			//status update
			$classes = $this->Students->get($id);
			$classes->status = $status;
			if ($this->Students->save($classes)) {
				$this->Flash->success(__('Your students status has been updated.'));
				return $this->redirect(['action' => 'index']);	
			}


		}

	}

}


public function statusdrop($id,$status){
	

	if(isset($id) && !empty($id)){
		

			$status = 'Y';
			//status update
			$classes = $this->DropOutStudent->get($id);
			
			
			$classes->status_tc = $status;
			if ($this->DropOutStudent->save($classes)) {
				$this->Flash->success(__('Drop Out Student Request for Genrate T.C. Or C.C are approved !!!!'));
				return $this->redirect(['action' => 'drop']);	
			}


		

	}
	
}
public function statussms($id,$status){

	$statusquery = $this->Smsmanager->find('all')->where(['Smsmanager.status' => 'Y'])->count();
	if(isset($id) && !empty($id)){
		if($status == 'Y' ){

			$status = 'N';
			//status update
			$classes = $this->Smsmanager->get($id);
			$classes->status = $status;
			if ($this->Smsmanager->save($classes)) {
				$this->Flash->success(__('Your SMS status has been updated.'));
				return $this->redirect(['action' => 'smsmanager']);	
			}
		}else{

			$status = 'Y';
			//status update
			$classes = $this->Smsmanager->get($id);
			$classes->status = $status;
			if ($this->Smsmanager->save($classes)) {
				$this->Flash->success(__('Your SMS status has been updated.'));
				return $this->redirect(['action' => 'smsmanager']);	
			}


		}

	}

}

	//for document status



public function documentstatus($id,$status){

	$statusquery = $this->Documents->find('all')->where(['Documents.status' => 'Y'])->count();
	if(isset($id) && !empty($id)){
		if($status == 'Y' ){

			$status = 'N';
			//status update
			$classes = $this->Documents->get($id);
			$classes->status = $status;
			if ($this->Documents->save($classes)) {
				$this->Flash->success(__('Your document status has been updated.'));
				return $this->redirect(['action' => 'view/'.$classes->user_id.'?id=documents']);	
			}
		}else{

			$status = 'Y';
			//status update
			$classes = $this->Documents->get($id);
			$classes->status = $status;
			if ($this->Documents->save($classes)) {
				$this->Flash->success(__('Your documents status has been updated.'));
				return $this->redirect(['action' => 'view/'.$classes->user_id.'?id=documents']);	
			}


		}

	}

}



public function addocument($id=null){
	if($_GET['ids']){
		$this->set('ids', $_GET['ids']);

	}

	$documentcategory = $this->Documentcategory->find('list', [
		'keyField' => 'id',
		'valueField' => 'categoryname'
		])->where(['Documentcategory.type !=' => 0])->order(['id' => 'DESC'])->toArray();

	$this->set('documentcategory', $documentcategory);

	if(isset($id) && !empty($id)){



		$documents = $this->Documents->get($id);
		$this->set('ids', $documents->user_id);
		$sections = $this->Documents->find()->select(['photo'])->where(['Documents.id' => $id])->order(['id' => 'ASC'])->first()->toArray();
		$rt ='1';

	}else{
		$documents = $this->Documents->newEntity();

		$rt ='0';
	} 
	$this->set('documents', $documents);

	$this->set('rt', $rt);

	if ($this->request->is(['post', 'put'])) {


		$filename=$this->request->data['photo']['name'];
		$item=$this->request->data['photo']['tmp_name'];
		$ext=  end(explode('.', $filename));
		$name = md5(time($filename));
		$imagename=$name.'.'.$ext;

		$this->request->data['created']=date('Y-m-d',strtotime($this->request->data['created']));
                      // pr($imagename); die;

		$this->request->data['type']="0"; 

		if(move_uploaded_file($item,"img/". $imagename))
		{
			$this->request->data['photo']=$imagename;
			$this->request->data['ext']=$ext;
		}
		else
		{
			$this->request->data['photo']=$sections['photo'];
		}


							 // pr($this->request->data); die;
		$documents = $this->Documents->patchEntity($documents, $this->request->data);

		if ($this->Documents->save($documents)) {
			$this->Flash->success(__('Your Documents has been saved.'));
			return $this->redirect(['action' => 'view/'.$this->request->data['user_id'].'?id=documents']);	
		}


	}
}
public function img(){
	$id=$_GET['r'];
	$sections = $this->Documents->find()->select(['photo'])->where(['Documents.id' => $id])->order(['id' => 'ASC'])->first()->toArray();
	$this->set('sections', $sections);
	//pr( $sections); die; 
}

public function studentimage($id=null)
{
	$this->viewBuilder()->layout('admin');
	if(isset($id) && !empty($id)){
		$students = $this->Students->find()->where(['Students.id' 
		=>$id,'Students.status' =>'Y'])->first();
		$this->set(compact('students'));
		$studentss = $this->Students->get($id);

	}
	else{
		$studentss = $this->Students->newEntity();
	} 
	if($this->request->is('post') || $this->request->is('put'))
	{

		if($this->request->data['photo']!="")
		{
			
			
 if($studentss['board_id']=='1'){ 
	 $bordd="";
	 
 }else if($studentss['board_id']=='2'){ 
	 $bordd="CAM";
 }else if($studentss['board_id']=='3'){
	 
	 $bordd="IB";
 }
			
				$directory = WWW_ROOT . 'stu/'.$bordd.$studentss['enroll'].".JPG";
		   
unlink($directory);
     		
	                	$filename=$this->request->data['photo']['name'];
						$item=$this->request->data['photo']['tmp_name'];
						$ext=  end(explode('.', $filename));
						$name = md5(time($filename));
						$imagename=$bordd.$studentss['enroll'].".JPG";
						if(move_uploaded_file($item,"stu/". $imagename))
						{
							$this->request->data['file']=$imagename;
						}
	     
	    
	     
	     	 
						
		}

	

		
		
			$this->Flash->success(__('Profile Picture has been saved.'));
			return $this->redirect(['action' => 'view/'.$studentss['id']]);	
		
	}
}    

     
public function move_images($k='')
{   


if(count($k['name'])==1){
    $filename=$k['name'];
   
					  $ext=  end(explode('.', $filename));
					  $name = md5(time($filename));
					  $imagename=trim($name.$rnd.$i.'.'.$ext," ");
					    if(move_uploaded_file($k['tmp_name'],"trash_image/". $imagename))
						{
						      $kk[]=$imagename;
					       }
					     
}else{

	   foreach($k as $item)
				    { 
					 $filename=$item['name'];
					  $ext=  end(explode('.', $filename));
					  $name = md5(time($filename));
					  $rnd=mt_rand();
					  $imagename=trim($name.$rnd.$i.'.'.$ext," ");
		   // pr($imagename);die;
					    if(move_uploaded_file($item['tmp_name'],"trash_image/". $imagename))
						{
						 $kk[]=$imagename;
					       }
					       $i++;
}
    }

return $kk;
}

public function upload_images($k='',$fkey_id='',$sizeArray='',$path)
{ 
 //echo $k;echo $fkey_id;pr( $sizeArray);echo $path; die;
     require_once(ROOT .DS. "vendor" . DS  . "MyClass" . DS . "MyClass.php");
   $wm = new MyClass();
		    // Set the image
		    $wm->setImage("trash_image/".$k[0]); // you can also set the quality with setImage, you only need to change it with an array: array('file' => 'test.png', 'quality' => 70)
		    
		    // Set the export quality
		    $wm->setQuality(80);
		    
		    
		    // Resize the image
		    $wm->resize(array('type' => 'resize', 'size' => $sizeArray));
		    
		    // Flip it
		    //$wm->flip('horizontal');
		    
		    // Now rotate it 30deg
		    //$wm->rotate(30);
		    
		    // It's time to apply the watermark
		    
		    // Export the file
		    if ( !$wm->generate($path.$k[0]) ) {
			    // handle errors...
			   // print_r($wm->errors);
		    }
	  $conn = ConnectionManager::get('default');
		$detail='UPDATE `kbcti5o3_idsprime`.`students` SET `file` ="'.$k[0].'" WHERE `students`.`id` = '.$fkey_id;
		$results = $conn->execute( $detail );
}


         /*
	public function csv($filename) {

        $documents = $this->Students->newEntity();
        //$filename = TMP . 'uploads' . DS . $filename;
         $filename=SITE_URL.'excel_file/' . $filename; 
      
        // open the file
        $handle = fopen($filename, "r");
         $vis   = fgetcsv($handle);
      pr($vis); die;
         $heada=explode(";",$vis[0]);
         
        // read the 1st row as headings
        $header = fgetcsv($handle);
        
        $headas=explode(";",$header[0]);
 
        // create a message container
        $return = array(
            'messages' => array(),
            'errors' => array(),
        );
               
        // read each data row in the file
        while (($row = $headas) !== FALSE) {
			$k=0;
    //     pr($row); die;
        
 

            foreach ($heada as $hes) {
             //  $data[$hes]=$row[$k++];
               $this->request->data[$hes]=$row[$k++];
           
		} 
              
		     	$this->request->data['file']=$this->request->data['file']['name'];
		       pr($this->request->data); die;
               $documents = $this->Students->patchEntity($documents, $this->request->data);
				pr($documents); die;
              $this->Students->save($documents);
          //  $this->set($data);
		
        }
         
        // close the file
        fclose($handle);

        // return the messages
        return $return;
         }
	*/
    
    //-----------------------------------------------------------------------------------------------------------------
    
    
      public function  restore($id=null){
      
      $dropoutStudent = $this->DropOutStudent->get($id)->toArray();
     
      $admissiondate=date('Y-m-d h:i:s',strtotime($dropoutStudent['admissiondate']));
   $conn = ConnectionManager::get('default');
$detail='INSERT INTO `students`(`id`, `fname`, `middlename`, `lname`, `fee_submittedby`, `board_id`, `fathername`, `mothername`,
 `username`, `password`, `dob`, `enroll`, `mobile`, `mobile2`, `sms_mobile`, `formno`, `adaharnumber`, `cast`, `parent_id`, 
 `house_id`, `class_id`, `category`, `section_id`, `gender`, `photo`, `bloodgroup`, `religion`, `address`, `city`, `nationality`,
  `admissionyear`, `acedmicyear`, `status`, `file`, `comp_sid`, `opt_sid`, `h_id`, `room_no`, `is_transport`, `transportloc_id`, `v_num`, `dis_fees`, `dis_transport`, `is_discount`, `discountcategory`, `due_fees`, `token`, `rf_id`, `height`, `weight`, `is_special`, `is_lc`,`disability`, `mother_tounge`, `f_qualification`, `f_occupation`, `m_qualification`, `m_occupation`, `f_phone`, `m_phone`, `admissionclass`, `created`) VALUES(
 "'.$dropoutStudent['s_id'].'","'.$dropoutStudent['fname'].'","'.$dropoutStudent['middlename'].'","'.$dropoutStudent['lname'].'",
 "'.$dropoutStudent['fee_submittedby'].'","'.$dropoutStudent['board_id'].'","'.$dropoutStudent['fathername'].'","'.$dropoutStudent['mothername'].'","'.$dropoutStudent['username'].'","'.$dropoutStudent['password'].'",
"'.date('Y-m-d',strtotime($dropoutStudent['dob'])).'","'.$dropoutStudent['enroll'].'","'.$dropoutStudent['mobile'].'","'.$dropoutStudent['mobile2'].'","'.$dropoutStudent['sms_mobile'].'","'.$dropoutStudent['formno'].'","'.$dropoutStudent['adaharnumber'].'","'.$dropoutStudent['cast'].'","'.$dropoutStudent['parent_id'].'","'.$dropoutStudent['house_id'].'","'.$dropoutStudent['class_id'].'","'.$dropoutStudent['category'].'","'.$dropoutStudent['section_id'].'","'.$dropoutStudent['gender'].'","'.$dropoutStudent['photo'].'","'.$dropoutStudent['bloodgroup'].'","'.$dropoutStudent['religion'].'","'.$dropoutStudent['address'].'","'.$dropoutStudent['city'].'","'.$dropoutStudent['nationality'].'","'.$dropoutStudent['admissionyear'].'","'.$dropoutStudent['acedmicyear'].'","'.$dropoutStudent['status'].'","'.$dropoutStudent['file'].'","'.$dropoutStudent['comp_sid'].'","'.$dropoutStudent['opt_sid'].'","'.$dropoutStudent['h_id'].'","'.$dropoutStudent['room_no'].'","'.$dropoutStudent['is_transport'].'","'.$dropoutStudent['transportloc_id'].'","'.$dropoutStudent['v_num'].'","'.$dropoutStudent['dis_fees'].'","'.$dropoutStudent['dis_transport'].'","'.$dropoutStudent['is_discount'].'","'.$dropoutStudent['discountcategory'].'","'.$dropoutStudent['due_fees'].'","'.$dropoutStudent['token'].'","'.$dropoutStudent['rf_id'].'","'.$dropoutStudent['height'].'","'.$dropoutStudent['weight'].'","'.$dropoutStudent['is_special'].'","'.$dropoutStudent['is_lc'].'","'.$dropoutStudent['disability'].'","'.$dropoutStudent['mother_tounge'].'","'.$dropoutStudent['f_qualification'].'","'.$dropoutStudent['f_occupation'].'","'.$dropoutStudent['m_qualification'].'","'.$dropoutStudent['m_occupation'].'","'.$dropoutStudent['f_phone'].'","'.$dropoutStudent['m_phone'].'","'.$dropoutStudent['admissionclass'].'","'.$admissiondate.'")';



		$results = $conn->execute( $detail );
		if($results){
		    	$this->DropOutStudent->delete( $this->DropOutStudent->get($id) );
		    	
		    	}
		    	
	    		$this->Flash->success(__('Student Restore Sucessfully!! '));
				return $this->redirect(['action' => 'drop']);
      }
      
       public function view_out($id=null)
    {
		
    		if( !empty($id) )
    			$this->set(compact('id'));
    			
    			
    			
    				$issueBook =$this->IssueBook->find('all')->where(['IssueBook.holder_id' => $id,'IssueBook.holder_type_id' => 'Student','IssueBook.status' =>'Y'])->order(['IssueBook.id DESC'])->toarray(); 
    			
    				$this->set(compact('issueBook'));
    				
    			$student=$this->Students->find('all')->where(['Students.id' =>$id])->first();

$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
$classss = $this->Classes->find('all')->where(['Classes.id'=>$student['class_id']])->first();
$sectionsss = $this->Sections->find('all')->where(['Sections.id'=>$student['section_id']])->first();
           $acedmicyear=$student["acedmicyear"];
		
	  
		 $acedmiclassid=$student["class_id"];
	
	$this->set('academic_year',$student["acedmicyear"]);
	$this->set('enroll',$student["enroll"]);
	$this->set('discountcategory',$student["discountcategory"]);
	$this->set('fname',$student["fname"]);
	$this->set('middlename',$student["middlename"]);
	$this->set('lname',$student["lname"]);
	$this->set('ctitle',$classss["title"]);
	$this->set('class_ids',$student["class_id"]);
	$this->set('comp_sid',$student["comp_sid"]);
	$this->set('opt_sid',$student["opt_sid"]);
	$this->set('stitle',$sectionsss["title"]);
	$this->set('academic_class',$acedmiclassid);
  $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->where(['Classfee.fee_h_id IN' => ['2','9'],'Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid])->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),'Classes.title','Classfee.academic_year','Classfee.id','Classfee.status','Classfee.class_id'
])->toarray();
	$this->set(compact('classfee'));
	$studentfeesk = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$student["id"],'Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->toarray();
	
	$this->set(compact('studentfeesk'));
	$studentfees = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["id"],'Studentfees.refrencepending'=>'0','Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->toarray();
	$this->set(compact('studentfees'));
	$fid=['7','3','4','9'];
			$preclassfee=$this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid,'Classfee.fee_h_id IN' => $fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
			$this->set(compact('preclassfee'));
         
    			$student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $student["id"],'Studentfeepending.status' => 'N'])->toarray();
		$this->set('student_feepending',$student_feepending);
	}
	
	
	
	public function dropsubmit($id=null){
	    
	    
	
    	if($id){
  	$s_id = $id;
	$student = $this->Students->get($s_id)->toArray();
	    	$student['s_id'] = $student['id'];
	    	$student['admissiondate']=$student['created'];
	    	//unset($student['id']);
	    	//unset($student['created']);

	    	try
	    	{
	    		$this->Students->delete( $this->Students->get($s_id));

	    		$drop_out_student = $this->DropOutStudent->newEntity();
	    		$student['dropcreated']=date('Y-m-d h:i:s');
	    		$student['laststudclass']=$student['class_id'];
	    	    unset($student['id']);
		    	$drop_out_student = $this->DropOutStudent->patchEntity($drop_out_student, $student);
		    	$this->DropOutStudent->save($drop_out_student);

	    		$this->Flash->success(__('Now, you can download Transfer and Character certificate for the drop out student having id: '.$s_id.'.'));
				return $this->redirect(['action' => 'drop']);
	    	}
	    	catch(\PDOException $ex)
	    	{
	    		if ($ex->getCode() == 23000)
	    		{
	    			$this->Flash->error( __( "Please clear dues before dropping the student with id: ".$s_id.'.' ) );
	    			return $this->redirect(['action' => 'index']);
	    		}
	    		else
	    		{
	    			$this->Flash->error( __( $ex->getMessage() ) );
	    			return $this->redirect(['action' => 'index']);
	    		}
	    	}    
	    
    	}else if ($this->request->is(['post', 'put'])) {
			
			
			$id=$this->request->data['id']; 
			$remarks_lwt=$this->request->data['remarks_lwt']; 
			
				$s_id = $id;
	    $student = $this->Students->get($s_id)->toArray();
	    	$student['s_id'] = $student['id'];
	    	$student['admissiondate']=$student['created'];
	  

	    	try
	    	{
	    		$this->Students->delete( $this->Students->get($s_id));

	    		$drop_out_student = $this->DropOutStudent->newEntity();
	    		$student['dropcreated']=date('Y-m-d h:i:s');
	    		$student['laststudclass']=$student['class_id'];
	    		$student['remarks_lwt']=$remarks_lwt;
	    	    unset($student['id']);
		    	$drop_out_student = $this->DropOutStudent->patchEntity($drop_out_student, $student);
		    	$this->DropOutStudent->save($drop_out_student);

	    		$this->Flash->success(__('Now, you can download Transfer and Character certificate for the drop out student having id: '.$s_id.'.'));
				return $this->redirect(['action' => 'drop']);
	    	}
	    	catch(\PDOException $ex)
	    	{
	    		if ($ex->getCode() == 23000)
	    		{
	    			$this->Flash->error( __( "Please clear dues before dropping the student with id: ".$s_id.'.' ) );
	    			return $this->redirect(['action' => 'index']);
	    		}
	    		else
	    		{
	    			$this->Flash->error( __( $ex->getMessage() ) );
	    			return $this->redirect(['action' => 'index']);
	    		}
	    	}  
			
			
			}else{
    	    	$this->Flash->error( __("kindly Try Again For DropOut !!!" ) );
    	  return $this->redirect(['action' => 'index']);  
    	    
    	}
	}
	public function gethistoryyearstudentinfo($id=null,$acedemic=null){

$articles = TableRegistry::get('Studentshistory');
return $articles->find('all')->where(['Studentshistory.stud_id' =>$id,'Studentshistory.acedmicyear'=>$acedemic,'Studentshistory.status'=>'Y','Studentshistory.actionhistory'=>'REPEAT'])->order(['Studentshistory.id' =>'DESC'])->first();
	



}
public function gethistoryyearstudentinfo45($id=null){

$articles = TableRegistry::get('Studentshistory');
return $articles->find('all')->where(['Studentshistory.stud_id' =>$id,'Studentshistory.status'=>'Y'])->order(['Studentshistory.id' =>'DESC'])->first();
	



}
    public function findridacademicre($stud_id,$acedmic)
{
       $articles = TableRegistry::get('Studentfees');

// Start a new query.

       return  $articles->find('all')->select(['id'])->where(['Studentfees.student_id'=>$stud_id,'Studentfees.quarter NOT LIKE'=>'%T.C.%','Studentfees.acedmicyear'=>$acedmic])->order(['Studentfees.id' => 'DESC'])->first();
    }
	
	   public function drop_outs($id=null)
    {
    	
    		if( !empty($id) )
    		
    		
    	
    		
    		
    		
    			$studentss=$this->DropOutStudent->find('all')->where(['DropOutStudent.s_id' =>$id])->first();



    	$findstu=$this->findridacademicre($id,$studentss['acedmicyear']);
 
				 			 $detained['id']='';
				 if($findstu['id']==''){	
					 
					 
					 	$detained=$this->gethistoryyearstudentinfo45($id);
					 	
					 	
					}
    		

    		if($detained['id']){  
    			$this->set(compact('id'));
    			
    			
    			
    				$issueBook =$this->IssueBook->find('all')->where(['IssueBook.holder_id'=>$id,'IssueBook.holder_type_id' =>'Student','IssueBook.status' =>'Y'])->order(['IssueBook.id DESC'])->toarray(); 
    			
    				$this->set(compact('issueBook'));
    				
    			$student=$this->Studentshistory->find('all')->where(['Studentshistory.id'=>$detained['id']])->first();


$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

           $acedmicyear=$student['acedmicyear'];
		
	  
		 $acedmiclassid=$student["class_id"];
	$this->set('name',$student['fname']." ".$student['middlename']." ".$student['lname']);
	$this->set('enroll',$student['enroll']);
	$this->set('academic_year',$acedmicyear);
	$this->set('academic_class',$acedmiclassid);
  $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->where(['Classfee.fee_h_id IN' => ['2','9'],'Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid])->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),'Classes.title','Classfee.academic_year','Classfee.id','Classfee.status','Classfee.class_id'
])->toarray();
	$this->set(compact('classfee'));
	$studentfeesk = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$student["stud_id"],'Studentfees.recipetno !=' =>0,'Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->toarray();
	
	$this->set(compact('studentfeesk'));
	$studentfees = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["stud_id"],'Studentfees.refrencepending'=>'0','Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->toarray();
	$this->set(compact('studentfees'));
	$fid=['7','3','4','9'];
			$preclassfee=$this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid,'Classfee.fee_h_id IN' =>$fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
			$this->set(compact('preclassfee'));
         
    			$student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $student["stud_id"],'Studentfeepending.status' => 'N'])->toarray();
		$this->set('student_feepending',$student_feepending);
		
		$studentkk=$this->DropOutStudent->find('all')->where(['DropOutStudent.s_id' =>$id])->first();

        $acedmicyearkk=$studentkk['acedmicyear'];
		
		$studentfeeshj4 = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$studentkk["s_id"],'Studentfees.refrencepending'=>'0','Studentfees.acedmicyear' =>$acedmicyearkk,'Studentfees.status' =>'Y'])->toarray();
	$this->set(compact('studentfeeshj4'));
		
		}else{
			
			
			$this->set(compact('id'));
    			
    			
    			
    				$issueBook =$this->IssueBook->find('all')->where(['IssueBook.holder_id' => $id,'IssueBook.holder_type_id' => 'Student','IssueBook.status' =>'Y'])->order(['IssueBook.id DESC'])->toarray(); 
    			
    				$this->set(compact('issueBook'));
    				
    			$student=$this->DropOutStudent->find('all')->where(['DropOutStudent.s_id' =>$id])->first();


$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

           $acedmicyear=$student['acedmicyear'];
		
	  
		 $acedmiclassid=$student["class_id"];
	$this->set('name',$student['fname']." ".$student['middlename']." ".$student['lname']);
	$this->set('enroll',$student['enroll']);
	$this->set('academic_year',$acedmicyear);
	$this->set('academic_class',$acedmiclassid);
  $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->where(['Classfee.fee_h_id IN' => ['2','9'],'Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid])->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),'Classes.title','Classfee.academic_year','Classfee.id','Classfee.status','Classfee.class_id'
])->toarray();
	$this->set(compact('classfee'));
	$studentfeesk = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$student["s_id"],'Studentfees.recipetno !=' =>0,'Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->toarray();
	
	$this->set(compact('studentfeesk'));
	$studentfees = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["s_id"],'Studentfees.refrencepending'=>'0','Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->toarray();
	$this->set(compact('studentfees'));
	$fid=['7','3','4','9'];
			$preclassfee=$this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid,'Classfee.fee_h_id IN' => $fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
			$this->set(compact('preclassfee'));
         
    			$student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $student["s_id"],'Studentfeepending.status' => 'N'])->toarray();
		$this->set('student_feepending',$student_feepending);
			
			
			
		}
    			
    }
    public function drop_out($id=null)
    {
    	
    	if( !empty($id) )
    		
    		
    	
    		
    		
    		
    			$studentss=$this->Students->find('all')->where(['Students.id' =>$id])->first();



    	$findstu=$this->findridacademicre($id,$studentss['acedmicyear']);
 
				 			 $detained['id']='';
				 if($findstu['id']==''){	
					 
					 
					 	$detained=$this->gethistoryyearstudentinfo45($id);
					 	
					 	
					}
    		

    		if($detained['id']){  
    			$this->set(compact('id'));
    			
    			
    			
    				$issueBook =$this->IssueBook->find('all')->where(['IssueBook.holder_id'=>$id,'IssueBook.holder_type_id' =>'Student','IssueBook.status' =>'Y'])->order(['IssueBook.id DESC'])->toarray(); 
    			
    				$this->set(compact('issueBook'));
    				
    			$student=$this->Studentshistory->find('all')->where(['Studentshistory.id'=>$detained['id']])->first();


$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

           $acedmicyear=$student['acedmicyear'];
		
	  
		 $acedmiclassid=$student["class_id"];
	$this->set('name',$student['fname']." ".$student['middlename']." ".$student['lname']);
	$this->set('enroll',$student['enroll']);
	$this->set('academic_year',$acedmicyear);
	$this->set('academic_class',$acedmiclassid);
  $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->where(['Classfee.fee_h_id IN' => ['2','9'],'Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid])->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),'Classes.title','Classfee.academic_year','Classfee.id','Classfee.status','Classfee.class_id'
])->toarray();
	$this->set(compact('classfee'));
	$studentfeesk = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$student["stud_id"],'Studentfees.recipetno !=' =>0,'Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->toarray();
	
	$this->set(compact('studentfeesk'));
	$studentfees = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["stud_id"],'Studentfees.refrencepending'=>'0','Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->toarray();
	$this->set(compact('studentfees'));
	$fid=['7','3','4','9'];
			$preclassfee=$this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid,'Classfee.fee_h_id IN' =>$fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
			$this->set(compact('preclassfee'));
         
    			$student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $student["stud_id"],'Studentfeepending.status' => 'N'])->toarray();
		$this->set('student_feepending',$student_feepending);
		
		$studentkk=$this->DropOutStudent->find('all')->where(['DropOutStudent.s_id' =>$id])->first();

        $acedmicyearkk=$studentkk['acedmicyear'];
		
		$studentfeeshj4 = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$studentkk["s_id"],'Studentfees.refrencepending'=>'0','Studentfees.acedmicyear' =>$acedmicyearkk,'Studentfees.status' =>'Y'])->toarray();
	$this->set(compact('studentfeeshj4'));
		
		}else{
			
			
			$this->set(compact('id'));
    			
    			
    			
    				$issueBook =$this->IssueBook->find('all')->where(['IssueBook.holder_id' => $id,'IssueBook.holder_type_id' => 'Student','IssueBook.status' =>'Y'])->order(['IssueBook.id DESC'])->toarray(); 
    			
    				$this->set(compact('issueBook'));
    				
    			$student=$this->Students->find('all')->where(['Students.id' =>$id])->first();


$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

           $acedmicyear=$student['acedmicyear'];
		
	  
		 $acedmiclassid=$student["class_id"];
	$this->set('name',$student['fname']." ".$student['middlename']." ".$student['lname']);
	$this->set('enroll',$student['enroll']);
	$this->set('academic_year',$acedmicyear);
	$this->set('academic_class',$acedmiclassid);
  $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->where(['Classfee.fee_h_id IN' => ['2','9'],'Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid])->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),'Classes.title','Classfee.academic_year','Classfee.id','Classfee.status','Classfee.class_id'
])->toarray();
	$this->set(compact('classfee'));
	$studentfeesk = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$student["id"],'Studentfees.recipetno !=' =>0,'Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->toarray();
	
	$this->set(compact('studentfeesk'));
	$studentfees = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["id"],'Studentfees.refrencepending'=>'0','Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->toarray();
	$this->set(compact('studentfees'));
	$fid=['7','3','4','9'];
			$preclassfee=$this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid,'Classfee.fee_h_id IN' => $fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
			$this->set(compact('preclassfee'));
         
    			$student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $student["id"],'Studentfeepending.status' => 'N'])->toarray();
		$this->set('student_feepending',$student_feepending);
			
			
			
		}
    			
    }

    //-----------------------------------------------------------------------------------------------------------------
    public function drop()
    {
    	$this->viewBuilder()->layout('admin');

    	// For custom search form fields
    	$sections = $this->Sections->find('all')->select(['id', 'title'])->where(['status' => 1])->order(['title' => 'ASC'])->toArray();
    	
    	
$rolepresent=$this->request->session()->read('Auth.User.role_id');


if($rolepresent=='1'){ 
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='5'){ 
	
	
		$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id <=' =>'22'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='8'){ 
	
	
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id >=' =>'23'])->order(['Classes.sort' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}

    	// For view listing
    	
    	
    	
    	
    	
    	if($rolepresent=='5'){

		
		$students = $this->DropOutStudent->find('all')->contain(['Classes','Sections'])->where(['board_id IN' =>['1']])->order(['DropOutStudent.dropcreated' => 'DESC'])->toarray();

	
}else if($rolepresent=='8'){
	
	
	
	
		
		$students = $this->DropOutStudent->find('all')->contain(['Classes','Sections'])->where(['board_id IN' =>['2','3']])->order(['DropOutStudent.dropcreated' => 'DESC'])->toarray();
	
}else{


$students = $this->DropOutStudent->find('all')->contain(['Classes','Sections'])->order(['DropOutStudent.dropcreated' =>'DESC'])->toarray();

}
		
		
		$this->set(compact('sections','classes','students'));
		
		 $this->request->session()->delete('conditionlps');
$this->request->session()->write('conditionlps',$students); 
    }
   

    //-----------------------------------------------------------------------------------------------------------------
    
    
    
    
    public function character_certificate_info($id=null)
    {
    	if(!empty($id))
		{
			$student = $this->DropOutStudent->get($id);
			
		
			$this->set(compact('student'));
		}
		
		
		if( $this->request->is( ['post', 'put'] ) )
		{
		
		
			$req_data = $this->request->data;
		
			$req_data['date_issue']=date('Y-m-d');
				$sid=$req_data['s_id'];
				$req_data['date_issue']=date('Y-m-d');
			$student = $this->DropOutStudent->patchEntity($student, $req_data);
			
			if($this->DropOutStudent->save($student))
			{	
				return $this->redirect(['action' => 'character_certificate_pdf/'.$sid]);
			}
			else
			{    
				//check validation error
				if( $student->errors() )
				{
					$error_msg = [];

					foreach( $student->errors() as $errors )
					{
						if( is_array( $errors ) )
						{
							foreach( $errors as $error )
							{
								$error_msg[] = $error;
							}
						}
						else
						{
							$error_msg[]    =   $errors;
						}
					}
					
					if( !empty( $error_msg ) )
					{
						$this->Flash->error( __( "Please fix the following error(s): ".implode( "\n \r", $error_msg ) ) );
					}
				}
			}
		}
		
    
    
    
    }
    public function transfer_certificate_info($id=null, $s_id=null)
    {
    	if(!empty($id))
		{
			$student = $this->DropOutStudent->get($id);
			
			
			$classid=$student['class_id'];
		}
		
			
$classes = $this->Classections->find('all')->select(['id'])->where(['class_id' => $classid])->group(['Classections.class_id'])->toArray();


		$classes = $this->Classections->find('list', [
			'keyField' => 'Classes.id',
			'valueField' => 'Classes.title'
			])->select(['Classections.id','Classections.class_id','Classes.id','Classes.title'])->contain(['Classes'])->where(['Classections.id >' =>$classes[0]['id'],'Classections.class_id NOT IN' =>[$classid]])->group(['Classections.class_id'])->order(['Classes.sort' => 'ASC'])->toArray();
			
			
		$classes2 = $this->Classections->find('list', [
			'keyField' => 'Classes.id',
			'valueField' => 'Classes.title'
			])->select(['Classections.id','Classections.class_id','Classes.id','Classes.title'])->contain(['Classes'])->group(['Classections.class_id'])->order(['Classes.sort' => 'ASC'])->toArray();
			
			
			
		$admissionclass = $this->AdmissionClasses->find('list', [
			'keyField' => 'id',
			'valueField' => 'title'
			])->order(['sort' => 'ASC'])->toArray();
		
	
		
		$this->set(compact('student','classes','classes2','admissionclass'));
		
		if( $this->request->is( ['post', 'put'] ) )
		{
			
		
		
			$req_data = $this->request->data;
				$req_data['tcsubject']=implode(',',$req_data['tcsubject']);
			$req_data['date_issue']=$req_data['date_issue']['year']."-".$req_data['date_issue']['month']."-".$req_data['date_issue']['day'];
			$req_data['date_application']=$req_data['date_application']['year']."-".$req_data['date_application']['month']."-".$req_data['date_application']['day'];
			$req_data['admissiondate']=$req_data['admissiondate']['year']."-".$req_data['admissiondate']['month']."-".$req_data['admissiondate']['day']." 00:00:00";
			
			
			$student = $this->DropOutStudent->patchEntity($student, $req_data);
			
			if( $this->DropOutStudent->save( $student ) )
			{	
				return $this->redirect(['action' => 'transfer_certificate_pdf/'.$s_id]);
			}
			else
			{    
				//check validation error
				if( $student->errors() )
				{
					$error_msg = [];

					foreach( $student->errors() as $errors )
					{
						if( is_array( $errors ) )
						{
							foreach( $errors as $error )
							{
								$error_msg[] = $error;
							}
						}
						else
						{
							$error_msg[]    =   $errors;
						}
					}
					
					if( !empty( $error_msg ) )
					{
						$this->Flash->error( __( "Please fix the following error(s): ".implode( "\n \r", $error_msg ) ) );
					}
				}
			}
		}
    }

    //-----------------------------------------------------------------------------------------------------------------
    public function transfer_certificate_pdf($s_id = null)
    {
        
        $student = $this->Students->find('all')->contain(['DropOutStudent', 'Sections', 'Classes'])
            ->where(['DropOutStudent.s_id' => $s_id])->first();

		$this->set(compact('student'));
		$this->sitesetting('general'); 
        $select = $student['comp_sid'];

        if ($student['laststudclass']) {
            $class_id = $student['laststudclass'];

        } else {
            $class_id = $student['class_id'];
        }

        if ($class_id == 12 || $class_id == 13 || $class_id == 15 ||
            $class_id == 17 || $class_id == 20 || $class_id == 22) {

            if (!empty($select)) {
                $this->set('selected', $select);
            }

            $select1 = $student['opt_sid'];
            //pr($select1); die;

            if (!empty($select1)) {
                $this->set('select1', $select1);
            }

        }

        // pr($student);die;
    }

    //-----------------------------------------------------------------------------------------------------------------
    public function bonafide_certificate_pdf($id = null)
    {
        $student = $this->Students->find('all')->contain(['DropOutStudent', 'Classes', 'Sections'])->where(['DropOutStudent.s_id' => $id])
            ->first();

        $this->set(compact('student'));
		$this->sitesetting('general');
    }

    public function character_certificate_pdf($s_id = null)
    {
		$student = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where(['DropOutStudent.s_id' => $s_id])->first();
	//  $student = $this->DropOutStudent->find('all')->where(['s_id' => $s_id])->first();
        // pr($student); die;
        $this->set(compact('student'));
		$this->sitesetting('general');
    }


    //-----------------------------------------------------------------------------------------------------------------
    public function drop_out_student_search()
    {
		$conn = ConnectionManager::get('default');

		$fathername=$this->request->data['fathername'];
		$class=$this->request->data['class_id'];
		$created=date('Y-m-d',strtotime($this->request->data['created']));
		$section=$this->request->data['section_id']; 
		$enroll=$this->request->data['enroll'];
		$fname=$this->request->data['fname']; 
		$status_tc=$this->request->data['status_tc']; 

		$detail="SELECT DropOutStudent.id,DropOutStudent.created,DropOutStudent.remarks_lwt,DropOutStudent.laststudclass,DropOutStudent.updateacedemic,DropOutStudent.school_lastresult,DropOutStudent.s_id,DropOutStudent.status_tc,DropOutStudent.fathername,DropOutStudent.enroll,DropOutStudent.fname,DropOutStudent.middlename,DropOutStudent.lname,DropOutStudent.mobile,DropOutStudent.acedmicyear,DropOutStudent.class_id,DropOutStudent.sms_mobile,
		DropOutStudent.section_id, DropOutStudent.status,  Classes.title as classtitle , Sections.title as sectiontitle 
		FROM `drop_out_students` DropOutStudent LEFT JOIN classes Classes ON DropOutStudent.`class_id` = Classes.id 
		LEFT JOIN sections Sections ON DropOutStudent.`section_id` = Sections.id WHERE  1=1 ";

		$cond = ' ';
		
		if(!empty($class))
		{
			$cond.=" AND DropOutStudent.class_id LIKE '".$class."'";
		}
if(!empty($created) && $created !='1970-01-01')
		{
			$cond.=" AND DropOutStudent.created LIKE '".$created." %'";
		}
		

		if(!empty($section))
		{
			$cond.=" AND DropOutStudent.section_id LIKE '".$section."'";
		}

		if(!empty($enroll))
		{
			$cond.=" AND DropOutStudent.enroll LIKE '".$enroll."%' ";
		}
		if(!empty($status_tc))
		{
			$cond.=" AND DropOutStudent.status_tc LIKE '".$status_tc."' ";
		}

		if(!empty($fname))
		{
			$cond.=" AND UPPER(DropOutStudent.fname) LIKE '".strtoupper($fname)."%' ";
		}
		if(!empty($fathername))
		{
			$cond.=" AND UPPER(DropOutStudent.fathername) LIKE '".strtoupper($fathername)."'";
		}

		$detail = $detail.$cond;
		$SQL = $detail." ORDER BY DropOutStudent.id DESC";  

		$results = $conn->execute( $SQL )->fetchAll('assoc');

		$this->set('students', $results);
	}
	public function summaryprospectusreport($board=null,$m=null,$date=null){
		$this->viewBuilder()->layout('admin');


		$this->set(compact('date'));

    if($board=='cbse'){

$prospectussummary=$this->Enquires->find('all')->where(['DATE(Enquires.created)'=>$date,'Enquires.recipietno !='=>'0','Enquires.mode1_id'=>$m,'Enquires.status'=>'Y'])->order(['Enquires.created'=>'ASC'])->toarray();

}else if($board=='int'){

$prospectussummary=$this->Enquires->find('all')->where(['DATE(Enquires.created)'=>$date,'Enquires.recipietno !='=>'0','Enquires.mode1_id !='=>$m,'Enquires.status'=>'Y'])->order(['Enquires.created'=>'ASC'])->toarray();
}else if($board=='total'){

$prospectussummary=$this->Enquires->find('all')->where(['DATE(Enquires.created)'=>$date,'Enquires.recipietno !='=>'0','Enquires.status'=>'Y'])->order(['Enquires.created'=>'ASC'])->toarray();
}
$this->set(compact('prospectussummary'));
}
public function findregistrationtudentsdetail($m=null,$date=null){
	$this->viewBuilder()->layout('admin');

$date1=date('Y-m-d');

$this->set(compact('date1'));
$this->loadModel('Applicant');
if($m=='1'){
	$registrationsummary=$this->Applicant->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)'=>$date,'Applicant.recipietno !='=>'0','Applicant.status_c'=>'Y','Enquires.mode1_id'=>$m])->toarray();
//pr($registrationsummary); die;
}else if($m=='2'){

	$registrationsummary=$this->Applicant->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)'=>$date,'Applicant.recipietno !='=>'0','Applicant.status_c'=>'Y','Enquires.mode1_id !='=>1])->toarray();
}
$this->set(compact('registrationsummary'));
}


public function findacedemicsummary2($class=null,$acedmic=null,$from=null,$to=null){
	$this->viewBuilder()->layout('admin');
	$users = $this->Users->find('all')->where(['Users.id' =>'1'])->first();
    $currentyear=$users['academic_year'];
    $apk=array();
    $apk1=array();
    
    
    if($class !=0){
    
		


$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
		
		$stts=array('Students.class_id' =>$class);
$apk[]=$stts;

$stts=array('Students.category' =>'Migration');
$apk[]=$stts;

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;
$stts=array('Students.status' =>'N');
$apk[]=$stts;

				 $registrationsummary = $this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
    
    $this->set(compact('registrationsummary'));
    
}else{
	
		$rolepresent=$this->request->session()->read('Auth.User.role_id');


if($rolepresent=='5'){ 
	$stts=array('Students.board_id' =>1);
$apk[]=$stts;

}else{
	
		$stts=array('Students.board_id !=' =>1);
$apk[]=$stts;
}
	
	$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
		
	

$stts=array('Students.category' =>'Migration');
$apk[]=$stts;

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;
$stts=array('Students.status' =>'N');
$apk[]=$stts;


				$registrationsummary = $this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
    
    $this->set(compact('registrationsummary'));
    
	
}
}

public function findacedemicsummary3($class=null,$acedmic=null,$from=null,$to=null){
	$this->viewBuilder()->layout('admin');
	$users = $this->Users->find('all')->where(['Users.id' =>'1'])->first();
    $currentyear=$users['academic_year'];
    $apk=array();
    $apk1=array();
    
    
    if($class !=0){
    
		
			$rolepresent=$this->request->session()->read('Auth.User.role_id');


if($rolepresent=='5'){ 
	$stts=array('Students.board_id !=' =>1);
$apk[]=$stts;

}else{
	
		$stts=array('Students.board_id' =>1);
$apk[]=$stts;
}
		
$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;

$stts=array('Students.category' =>'Migration');
$apk[]=$stts;

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;
$stts=array('Students.status' =>'N');
$apk[]=$stts;

 $articles = TableRegistry::get('Students');
$ddd=$articles->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();

$cnust=array();

foreach($ddd as $k=>$kki){

 $next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){
	
$articles3 = TableRegistry::get('Students')->find('all')->where(['Students.oldenroll'=>$kki['enroll'],'Students.class_id' =>$class,'Students.admissionyear' =>$acedmic])->order(['Students.id'=>'ASC'])->first();
	

}else if($acedmic!=$currentyear){
	
	
	 $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['oldenroll'=>$kki['enroll'],'class_id' =>$class,'admissionyear' =>$acedmic])->order(['id'=>'ASC'])->first();
}else{
		 $articles3 = TableRegistry::get('Students')->find('all')->where(['Students.oldenroll'=>$kki['enroll'],'Students.class_id' =>$class,'Students.admissionyear' =>$acedmic])->order(['Students.id'=>'ASC'])->first();
		 
	 }
		 if($articles3['id']){
			$cnust[]=$articles3['id']; 
		 }else{
				 
		 }
	
}



if($cnust){
				 $registrationsummary = $this->Students->find('all')->where(['Students.id IN'=>$cnust])->order(['Students.id'=>'ASC'])->toarray();
    }
    $this->set(compact('registrationsummary'));
    
}else{	$rolepresent=$this->request->session()->read('Auth.User.role_id');


if($rolepresent=='5'){ 
	$stts=array('Students.board_id !=' =>1);
$apk[]=$stts;

}else{
	
		$stts=array('Students.board_id' =>1);
$apk[]=$stts;
}
		

$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;

$stts=array('Students.category' =>'Migration');
$apk[]=$stts;

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;
$stts=array('Students.status' =>'N');
$apk[]=$stts;


 $articles = TableRegistry::get('Students');
$ddd=$articles->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();

$cnust=array();

foreach($ddd as $k=>$kki){



		 $articles3 = TableRegistry::get('Students')->find('all')->where(['Students.oldenroll'=>$kki['enroll'],'Students.admissionyear' =>$acedmic])->order(['Students.id'=>'ASC'])->first();
		 if($articles3['id']){
			$cnust[]=$articles3['id']; 
		 }else{
				 
		 }
	
}




				 $registrationsummary = $this->Students->find('all')->where(['Students.id IN'=>$cnust])->order(['Students.id'=>'ASC'])->toarray();
    
   
    $this->set(compact('registrationsummary'));
	
}
}



public function findacedemicsummary($class=null,$acedmic=null,$from=null,$to=null){
	$this->viewBuilder()->layout('admin');
	$users = $this->Users->find('all')->where(['Users.id' =>'1'])->first();
    $currentyear=$users['academic_year'];
    $apk=array();
    $apk1=array();
	if($class !=0){

 $next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){

		$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
		$stts=array('Students.class_id' =>$class);
$apk[]=$stts;

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Students.category !=' =>'RTE');
$apk[]=$stts;

$stts=array('Students.oldenroll' =>'0');
$apk[]=$stts;


				
$admissionsummary=$this->Students->find('all')->where($apk)->order(['DATE(Students.created)'=>'ASC'])->toarray();

}else if($acedmic!=$currentyear){
		
		
$stts=array('Studentshistory.created >=' =>$from);
$apk[]=$stts;

$stts=array('Studentshistory.created <=' =>$to);
$apk[]=$stts;

$stts=array('Studentshistory.class_id' =>$class);
$apk[]=$stts;

$stts=array('Studentshistory.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Studentshistory.category !=' =>'RTE');
$apk[]=$stts;

$stts=array('Studentshistory.oldenroll' =>'0');
$apk[]=$stts;
		
$admissionsummary=$this->Studentshistory->find('all')->where($apk)->order(['DATE(Studentshistory.created)'=>'ASC'])->toarray();
	
	}else{
		
		$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
		$stts=array('Students.class_id' =>$class);
$apk[]=$stts;

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Students.category !=' =>'RTE');
$apk[]=$stts;

$stts=array('Students.oldenroll' =>'0');
$apk[]=$stts;


				
$admissionsummary=$this->Students->find('all')->where($apk)->order(['DATE(Students.created)'=>'ASC'])->toarray();
}


$registrationsummary=$admissionsummary;


$this->set(compact('registrationsummary'));

}else{
	$rolepresent=$this->request->session()->read('Auth.User.role_id');	
	
if($rolepresent=='5'){
	
	$next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){
	
	
	
$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('Students.board_id' =>1);
$apk[]=$stts;


$stts=array('Students.category !=' =>'RTE');
$apk[]=$stts;

$stts=array('Students.oldenroll' =>'0');
$apk[]=$stts;

		
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
	
}else if($acedmic!=$currentyear){
		
			
		
$stts=array('Studentshistory.created >=' =>$from);
$apk[]=$stts;

$stts=array('Studentshistory.created <=' =>$to);
$apk[]=$stts;
$stts=array('Studentshistory.board_id' =>1);
$apk[]=$stts;

$stts=array('Studentshistory.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Studentshistory.category !=' =>'RTE');
$apk[]=$stts;

$stts=array('Studentshistory.oldenroll' =>'0');
$apk[]=$stts;

		
$admissionsummary=$this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id'=>'ASC'])->toarray();

	}else{
		
	
$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('Students.board_id' =>1);
$apk[]=$stts;


$stts=array('Students.category !=' =>'RTE');
$apk[]=$stts;

$stts=array('Students.oldenroll' =>'0');
$apk[]=$stts;

		
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
}
	
	$registrationsummary=$admissionsummary;

$this->set(compact('registrationsummary'));

}else if($rolepresent=='8'){
	

	$next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){
	
	
$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Students.category !=' =>'RTE');
$apk[]=$stts;

$stts=array('Students.oldenroll' =>'0');
$apk[]=$stts;

$stts=array('Students.board_id IN' =>['2','3']);
$apk[]=$stts;
				
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
	
}else if($acedmic!=$currentyear){
		

$stts=array('Studentshistory.board_id IN' =>['2','3']);
$apk[]=$stts;
$stts=array('Studentshistory.created >=' =>$from);
$apk[]=$stts;

$stts=array('Studentshistory.created <=' =>$to);
$apk[]=$stts;

$stts=array('Studentshistory.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Studentshistory.category !=' =>'RTE');
$apk[]=$stts;

$stts=array('Studentshistory.oldenroll' =>'0');
$apk[]=$stts;

		
$admissionsummary=$this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id'=>'ASC'])->toarray();

	}else{
		
	

$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Students.category !=' =>'RTE');
$apk[]=$stts;

$stts=array('Students.oldenroll' =>'0');
$apk[]=$stts;

$stts=array('Students.board_id IN' =>['2','3']);
$apk[]=$stts;
				
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
}

$registrationsummary=$admissionsummary;


$this->set(compact('registrationsummary'));


	
}

}


}


public function findacedemicsummaryrte($class=null,$acedmic=null,$from=null,$to=null){
	$this->viewBuilder()->layout('admin');
	$users = $this->Users->find('all')->where(['Users.id' =>'1'])->first();
    $currentyear=$users['academic_year'];
    $apk=array();
    $apk1=array();
	if($class !=0){
		
		
		
	$next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){
	
		$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
		$stts=array('Students.class_id' =>$class);
$apk[]=$stts;

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Students.category' =>'RTE');
$apk[]=$stts;

$stts=array('Students.oldenroll' =>'0');
$apk[]=$stts;


				
$admissionsummary=$this->Students->find('all')->where($apk)->order(['DATE(Students.created)'=>'ASC'])->toarray();

}else if($acedmic!=$currentyear){
		
		
$stts=array('Studentshistory.created >=' =>$from);
$apk[]=$stts;

$stts=array('Studentshistory.created <=' =>$to);
$apk[]=$stts;

$stts=array('Studentshistory.class_id' =>$class);
$apk[]=$stts;

$stts=array('Studentshistory.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Studentshistory.category' =>'RTE');
$apk[]=$stts;

$stts=array('Studentshistory.oldenroll' =>'0');
$apk[]=$stts;
		
$admissionsummary=$this->Studentshistory->find('all')->where($apk)->order(['DATE(Studentshistory.created)'=>'ASC'])->toarray();
	
	}else{
		
		$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
		$stts=array('Students.class_id' =>$class);
$apk[]=$stts;

$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Students.category' =>'RTE');
$apk[]=$stts;

$stts=array('Students.oldenroll' =>'0');
$apk[]=$stts;


				
$admissionsummary=$this->Students->find('all')->where($apk)->order(['DATE(Students.created)'=>'ASC'])->toarray();
}


$registrationsummary=$admissionsummary;


$this->set(compact('registrationsummary'));

}else{
	$rolepresent=$this->request->session()->read('Auth.User.role_id');	
	
if($rolepresent=='5'){
	
		
	$next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){
	
$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('Students.board_id' =>1);
$apk[]=$stts;


$stts=array('Students.category' =>'RTE');
$apk[]=$stts;

$stts=array('Students.oldenroll' =>'0');
$apk[]=$stts;

		
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
	
	
}else if($acedmic!=$currentyear){
		
			
		
$stts=array('Studentshistory.created >=' =>$from);
$apk[]=$stts;

$stts=array('Studentshistory.created <=' =>$to);
$apk[]=$stts;
$stts=array('Studentshistory.board_id' =>1);
$apk[]=$stts;

$stts=array('Studentshistory.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Studentshistory.category' =>'RTE');
$apk[]=$stts;

$stts=array('Studentshistory.oldenroll' =>'0');
$apk[]=$stts;

		
$admissionsummary=$this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id'=>'ASC'])->toarray();

	}else{
		
	
$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('Students.board_id' =>1);
$apk[]=$stts;


$stts=array('Students.category' =>'RTE');
$apk[]=$stts;

$stts=array('Students.oldenroll' =>'0');
$apk[]=$stts;

		
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
}
	
	$registrationsummary=$admissionsummary;

$this->set(compact('registrationsummary'));

}else if($rolepresent=='8'){
	$next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){

$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Students.category' =>'RTE');
$apk[]=$stts;

$stts=array('Students.oldenroll' =>'0');
$apk[]=$stts;

$stts=array('Students.board_id IN' =>['2','3']);
$apk[]=$stts;
				
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
}else if($acedmic!=$currentyear){
		

$stts=array('Studentshistory.board_id IN' =>['2','3']);
$apk[]=$stts;
$stts=array('Studentshistory.created >=' =>$from);
$apk[]=$stts;

$stts=array('Studentshistory.created <=' =>$to);
$apk[]=$stts;

$stts=array('Studentshistory.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Studentshistory.category' =>'RTE');
$apk[]=$stts;

$stts=array('Studentshistory.oldenroll' =>'0');
$apk[]=$stts;

		
$admissionsummary=$this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id'=>'ASC'])->toarray();

	}else{
		
	

$stts=array('Students.created >=' =>$from);
$apk[]=$stts;

$stts=array('Students.created <=' =>$to);
$apk[]=$stts;
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;


$stts=array('Students.category' =>'RTE');
$apk[]=$stts;

$stts=array('Students.oldenroll' =>'0');
$apk[]=$stts;

$stts=array('Students.board_id IN' =>['2','3']);
$apk[]=$stts;
				
	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.id'=>'ASC'])->toarray();
}

$registrationsummary=$admissionsummary;


$this->set(compact('registrationsummary'));


	
}

}


}

public function findacedemicsummarydrop($class=null,$acedmic=null,$from=null,$to=null){
	$this->viewBuilder()->layout('admin');
	$users = $this->Users->find('all')->where(['Users.id' =>'1'])->first();
    $currentyear=$users['academic_year'];
    $apk=array();
    $apk1=array();
	if($class !=0){

if($acedmic!=$currentyear){
		
		
		
		$stts=array('DropOutStudent.admissiondate >=' =>$from);
$apk[]=$stts;

$stts=array('DropOutStudent.admissiondate <=' =>$to);
$apk[]=$stts;

$stts=array('DropOutStudent.laststudclass' =>$class);
$apk[]=$stts;

$stts=array('DropOutStudent.admissionyear' =>$acedmic);
$apk[]=$stts;


 $articles = TableRegistry::get('DropOutStudent');
$ddd=$articles->find('all')->where($apk)->order(['DropOutStudent.id'=>'ASC'])->toarray();




foreach($ddd as $k=>$kki){
	
		 $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['Studentshistory.stud_id'=>$kki['s_id']])->order(['Studentshistory.id'=>'ASC'])->first();
		 if($articles3['id']){
	
		 }else{
						$cnust[]=$kki['s_id'];  
		 }
	
}



		
$admissionsummary=$this->DropOutStudent->find('all')->where(['DropOutStudent.s_id IN'=>$cnust])->order(['DATE(DropOutStudent.admissiondate)'=>'ASC'])->toarray();
	
	}else{	
		
		
		$stts=array('DropOutStudent.admissiondate >=' =>$from);
$apk[]=$stts;

$stts=array('DropOutStudent.admissiondate <=' =>$to);
$apk[]=$stts;

$stts=array('DropOutStudent.laststudclass' =>$class);
$apk[]=$stts;

$stts=array('DropOutStudent.admissionyear' =>$acedmic);
$apk[]=$stts;


 $articles = TableRegistry::get('DropOutStudent');
$admissionsummary=$articles->find('all')->where($apk)->order(['DropOutStudent.id'=>'ASC'])->toarray();


}


$registrationsummary=$admissionsummary;


$this->set(compact('registrationsummary'));

}else{
	$rolepresent=$this->request->session()->read('Auth.User.role_id');	
	
if($rolepresent=='5'){
	
	$next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){
	
	
		
		$stts=array('DropOutStudent.admissiondate >=' =>$from);
$apk[]=$stts;

$stts=array('DropOutStudent.admissiondate <=' =>$to);
$apk[]=$stts;

$stts=array('DropOutStudent.board_id' =>1);
$apk[]=$stts;

$stts=array('DropOutStudent.admissionyear' =>$acedmic);
$apk[]=$stts;


 $articles = TableRegistry::get('DropOutStudent');
$admissionsummary=$articles->find('all')->where($apk)->order(['DropOutStudent.id'=>'ASC'])->toarray();
}else if($acedmic!=$currentyear){
		
		
		
		$stts=array('DropOutStudent.admissiondate >=' =>$from);
$apk[]=$stts;

$stts=array('DropOutStudent.admissiondate <=' =>$to);
$apk[]=$stts;

$stts=array('DropOutStudent.board_id' =>1);
$apk[]=$stts;
$stts=array('DropOutStudent.admissionyear' =>$acedmic);
$apk[]=$stts;


 $articles = TableRegistry::get('DropOutStudent');
$ddd=$articles->find('all')->where($apk)->order(['DropOutStudent.id'=>'ASC'])->toarray();




foreach($ddd as $k=>$kki){
	
		 $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['Studentshistory.stud_id'=>$kki['s_id']])->order(['Studentshistory.id'=>'ASC'])->first();
		 if($articles3['id']){
	
		 }else{
						$cnust[]=$kki['s_id'];  
		 }
	
}



		
$admissionsummary=$this->DropOutStudent->find('all')->where(['DropOutStudent.s_id IN'=>$cnust])->order(['DATE(DropOutStudent.admissiondate)'=>'ASC'])->toarray();

	}else{
		
	
		
		$stts=array('DropOutStudent.admissiondate >=' =>$from);
$apk[]=$stts;

$stts=array('DropOutStudent.admissiondate <=' =>$to);
$apk[]=$stts;

$stts=array('DropOutStudent.board_id' =>1);
$apk[]=$stts;

$stts=array('DropOutStudent.admissionyear' =>$acedmic);
$apk[]=$stts;


 $articles = TableRegistry::get('DropOutStudent');
$admissionsummary=$articles->find('all')->where($apk)->order(['DropOutStudent.id'=>'ASC'])->toarray();
}
	
	$registrationsummary=$admissionsummary;

$this->set(compact('registrationsummary'));

}else if($rolepresent=='8'){
	
	$next_academic_year=$users['next_academic_year'];
if($next_academic_year==$acedmic){
	
		$stts=array('DropOutStudent.admissiondate >=' =>$from);
$apk[]=$stts;

$stts=array('DropOutStudent.admissiondate <=' =>$to);
$apk[]=$stts;

$stts=array('DropOutStudent.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('DropOutStudent.board_id IN' =>['2','3']);
$apk[]=$stts;

 $articles = TableRegistry::get('DropOutStudent');
$admissionsummary=$articles->find('all')->where($apk)->order(['DropOutStudent.id'=>'ASC'])->toarray();
	
}else if($acedmic!=$currentyear){
		

$stts=array('DropOutStudent.board_id IN' =>['2','3']);
$apk[]=$stts;

$stts=array('DropOutStudent.admissiondate >=' =>$from);
$apk[]=$stts;

$stts=array('DropOutStudent.admissiondate <=' =>$to);
$apk[]=$stts;


$stts=array('DropOutStudent.admissionyear' =>$acedmic);
$apk[]=$stts;


 $articles = TableRegistry::get('DropOutStudent');
$ddd=$articles->find('all')->where($apk)->order(['DropOutStudent.id'=>'ASC'])->toarray();




foreach($ddd as $k=>$kki){
	
		 $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['Studentshistory.stud_id'=>$kki['s_id']])->order(['Studentshistory.id'=>'ASC'])->first();
		 if($articles3['id']){
	
		 }else{
						$cnust[]=$kki['s_id'];  
		 }
	
}

$admissionsummary=$this->DropOutStudent->find('all')->where(['DropOutStudent.s_id IN'=>$cnust])->order(['DATE(DropOutStudent.admissiondate)'=>'ASC'])->toarray();

	}else{
		
	

		
		$stts=array('DropOutStudent.admissiondate >=' =>$from);
$apk[]=$stts;

$stts=array('DropOutStudent.admissiondate <=' =>$to);
$apk[]=$stts;

$stts=array('DropOutStudent.admissionyear' =>$acedmic);
$apk[]=$stts;

$stts=array('DropOutStudent.board_id IN' =>['2','3']);
$apk[]=$stts;

 $articles = TableRegistry::get('DropOutStudent');
$admissionsummary=$articles->find('all')->where($apk)->order(['DropOutStudent.id'=>'ASC'])->toarray();


				
	

}

$registrationsummary=$admissionsummary;


$this->set(compact('registrationsummary'));


	
}

}


}

	
public function findacedemicstudentsdetail($board=null,$acedmic=null,$date=null){
		$this->viewBuilder()->layout('admin');

$date1=date('Y-m-d');

$this->set(compact('date1'));
$this->loadModel('Students');
$users = $this->Users->find('all')->where(['Users.id' =>'1'])->first();
    $currentyear=$users['academic_year'];
            
if($board=='cbse'){

if($acedmic > $currentyear && $acedmic!='1'){
	
$stts=array('DATE(Students.created)' =>$date);
$apk[]=$stts;
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;
$stts=array('Students.board_id' =>1);
$apk[]=$stts;

	
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.created'=>'ASC'])->toarray();

	}else if($acedmic!=$currentyear && $acedmic!='1'){
	
$stts=array('DATE(Studentshistory.created)' =>$date);
$apk[]=$stts;
$stts=array('Studentshistory.admissionyear' =>$acedmic);
$apk[]=$stts;
$stts=array('Studentshistory.board_id' =>1);
$apk[]=$stts;

	
$admissionsummary=$this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.created'=>'ASC'])->toarray();

	}else{
		
$stts=array('DATE(Students.created)' =>$date);
$apk[]=$stts;	
	$stts=array('Students.status' =>'Y');
$apk[]=$stts;	
if($acedmic!='1'){
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;
}
$stts=array('Students.board_id' =>1);
$apk[]=$stts;
				
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.created'=>'ASC'])->toarray();


}

if($acedmic > $currentyear && $acedmic!='1'){
	
foreach($admissionsummary as $kk=>$jj){
		
		$idd[]=$jj['student_id'];
		
			
	}
		$stts=array('DATE(DropOutStudent.admissiondate)' =>$date);
$apk1[]=$stts;
	if(!empty($idd)){
	$stts=array('DropOutStudent.s_id NOT IN' =>$idd);
 $apk1[]=$stts;	
}
 $stts=array('DropOutStudent.board_id' =>1);
 $apk1[]=$stts;
 if($acedmic!='1'){
	$stts=array('DropOutStudent.admissionyear' =>$acedmic);
 $apk1[]=$stts;	
}
$admissionsummary2=$this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.admissiondate'=>'ASC'])->toarray();
	



}else if($acedmic==$currentyear  && $acedmic!='1'){
	
	$stts=array('DATE(DropOutStudent.admissiondate)' =>$date);
$apk1[]=$stts;
	$stts=array('DropOutStudent.admissionyear' =>$acedmic);
 $apk1[]=$stts;
		
			$stts=array('DropOutStudent.board_id' =>1);
 $apk1[]=$stts;
		
$admissionsummary2=$this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.admissiondate'=>'ASC'])->toarray();
	
	
}else{
	foreach($admissionsummary as $kk=>$jj){
		
		$idd[]=$jj['student_id'];
		
			
	}
		$stts=array('DATE(DropOutStudent.admissiondate)' =>$date);
$apk1[]=$stts;
	if(!empty($idd)){
	$stts=array('DropOutStudent.s_id NOT IN' =>$idd);
 $apk1[]=$stts;	
}
 $stts=array('DropOutStudent.board_id' =>1);
 $apk1[]=$stts;
 if($acedmic!='1'){
	$stts=array('DropOutStudent.admissionyear' =>$acedmic);
 $apk1[]=$stts;	
}
$admissionsummary2=$this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.admissiondate'=>'ASC'])->toarray();
	
}



if(!empty($admissionsummary2))
{
$registrationsummary=array_merge($admissionsummary,$admissionsummary2);
}
else{
	$registrationsummary=$admissionsummary;
}

$this->set(compact('registrationsummary')); 
}else if($board=='int'){
	
   if($acedmic > $currentyear && $acedmic!='1'){ 
	   
	   		$stts=array('Students.status' =>'Y');
$apk[]=$stts;	
		
	$stts=array('DATE(Students.created)' =>$date);
$apk[]=$stts;
if($acedmic!='1'){
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

}
$stts=array('Students.board_id !=' =>1);
$apk[]=$stts;
				
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.created'=>'ASC'])->toarray();

}else if($acedmic!=$currentyear  && $acedmic!='1'){
	$stts=array('DATE(Studentshistory.created)' =>$date);
$apk[]=$stts;

 if($acedmic!='1'){
$stts=array('Studentshistory.admissionyear' =>$acedmic);
$apk[]=$stts;

}
$stts=array('Studentshistory.board_id !=' =>1);
$apk[]=$stts;

		
$admissionsummary=$this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.created'=>'ASC'])->toarray();
	//pr($admissionsummary); die;
	}else{
	$stts=array('Students.status' =>'Y');
$apk[]=$stts;	
		
	$stts=array('DATE(Students.created)' =>$date);
$apk[]=$stts;
if($acedmic!='1'){
$stts=array('Students.admissionyear' =>$acedmic);
$apk[]=$stts;

}
$stts=array('Students.board_id !=' =>1);
$apk[]=$stts;
				
$admissionsummary=$this->Students->find('all')->where($apk)->order(['Students.created'=>'ASC'])->toarray();
}

		


 if($acedmic > $currentyear && $acedmic!='1'){ 
foreach($admissionsummary as $kk=>$jj){
		
		$idd[]=$jj['student_id'];
		
			
	}
	
			$stts=array('DATE(DropOutStudent.admissiondate)' =>$date);
$apk1[]=$stts;
	if(!empty($idd)){
	$stts=array('DropOutStudent.s_id NOT IN' =>$idd);
 $apk1[]=$stts;	
}
 	$stts=array('DropOutStudent.board_id !=' =>1);
$apk1[]=$stts;
if($acedmic!='1'){
	$stts=array('DropOutStudent.admissionyear' =>$acedmic);
 $apk1[]=$stts;	
 
}
$admissionsummary2=$this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.admissiondate'=>'ASC'])->toarray();
	
}else if($acedmic==$currentyear  && $acedmic!='1'){
	
		$stts=array('DATE(DropOutStudent.admissiondate)' =>$date);
$apk1[]=$stts;
if($acedmic!='1'){
	$stts=array('DropOutStudent.admissionyear' =>$acedmic);
 $apk1[]=$stts;
}
		
		$stts=array('DropOutStudent.board_id !=' =>1);
$apk1[]=$stts;
$admissionsummary2=$this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.admissiondate'=>'ASC'])->toarray();
		//pr($Classections21); die;
	
}else{
	foreach($admissionsummary as $kk=>$jj){
		
		$idd[]=$jj['student_id'];
		
			
	}
	
			$stts=array('DATE(DropOutStudent.admissiondate)' =>$date);
$apk1[]=$stts;
	if(!empty($idd)){
	$stts=array('DropOutStudent.s_id NOT IN' =>$idd);
 $apk1[]=$stts;	
}
 	$stts=array('DropOutStudent.board_id !=' =>1);
$apk1[]=$stts;
if($acedmic!='1'){
	$stts=array('DropOutStudent.admissionyear' =>$acedmic);
 $apk1[]=$stts;	
 
}
$admissionsummary2=$this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.admissiondate'=>'ASC'])->toarray();
	
}



if(!empty($admissionsummary2))
{
$registrationsummary=array_merge($admissionsummary,$admissionsummary2);
}
else{
	$registrationsummary=$admissionsummary;
}
//pr($registrationsummary); die;
$this->set(compact('registrationsummary')); 

}


$this->set(compact('registrationsummary'));
}

// public function icons(){
// 	$this->loadModel('Permissions');
// 	$this->loadModel('PermissionModules');
// 	$per=$this->PermissionModules->find('all')->where(['featured'=>1])->group(['module','controller','action'])->toarray();
// 	// pr($per); die;
// 	foreach($per as $value){
// 		$data=[];
// 		$data['module']=$value['module'];
// 		$data['menu']=$value['menu'];
// 		$data['controller']=$value['controller'];
// 		$data['action']=$value['action'];
// 		$data['short_name']=$value['short_name'];
// 	  $icons=$this->Permissions->newEntity();
// 	  $patch=$this->Permissions->patchEntity($icons,$data);
// 	  $this->Permissions->save($patch);
	  
// 	}

	
// }
public function importstudents()
{
    $this->viewBuilder()->layout('admin');
}
public function import()
{
	$this->loadModel('Employeesalary');
	$this->loadModel('Employees');
$this->autoRender=false;
	if ($this->request->is(['post'])) {

		try {

			//pr($this->request->data); die;

			if ($this->request->data['file']['tmp_name']) {
				$empexcel = $this->request->data['file'];
				$excel_array = $this->studentExcelData($empexcel['tmp_name']);
				 if($excel_array=="null"){
		
					$this->Flash->error(__('Please Fill Mandatory Fields'));
					$this->set('error', $error);
					return $this->redirect(['action' => 'importstudents']);
				 }
				 if(!empty($excel_array['message'])){
		
					$this->Flash->error(__($excel_array['message']));
					$this->set('error', $error);
					return $this->redirect(['action' => 'importstudents']);
				 }
				foreach ($excel_array as $refer_data) {
					try{
					$refer_data['created'] = date('Y-m-d 00:00:00', \PHPExcel_Shared_Date::ExcelToPHP($refer_data['created']));
					$refer_data['dob'] =date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($refer_data['dob']));
						$emp = $this->Students->newEntity();
						$emp = $this->Students->patchEntity($emp, $refer_data);
						$emp = $this->Students->save($emp);
					}catch(\PDOException $e){
						$this->Flash->error(__('Students updation Failed'.$error));
						$this->set('error', $error);
						return $this->redirect(['action' => 'importstudents']);
					}
				}
				
				$this->Flash->success(__('Students list  has been saved.'));
				return $this->redirect(['action' => 'importstudents']);
			}
			$this->Flash->error(__('Students  has not been saved.'));
			return $this->redirect(['action' => 'importstudents']);

		} catch (\PDOException $e) {

			$this->Flash->error(__('Students updation Failed'.$error));
			$this->set('error', $error);
			return $this->redirect(['action' => 'importstudents']);
		}

	}	
}
public function studentExcelData($inputfilename)
{
	if ($_POST) {
		try {
			$objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
		} catch (Exception $e) {
			die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
		}
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestDataRow();
		$highestColumn = $sheet->getHighestDataColumn();
		
		$c = 0;

		$firstrow = 1;
		$firstsop = $sheet->rangeToArray('A' . $firstrow . ':' . $highestColumn . $firstrow, null, true, false);
			  
		for ($row = 2; $row <= $highestRow; $row++) {
			$exceldata = array();
			$filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
			$colB = $objPHPExcel->getActiveSheet()->getCell('A' . $row)->getValue();
			if ($colB == null || $colB == '') {
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $objPHPExcel->getActiveSheet()->getCell('A' . ($row - 1))->getValue());

			}
			
			$val[]=$exceldata['fname'] = $filesop[0][1];
			$exceldata['middlename'] = $filesop[0][2];
			$val[]=$exceldata['lname'] = $filesop[0][3];
			$val[]=$exceldata['fee_submittedby'] = $filesop[0][4];
			$val[]=$exceldata['fathername'] = $filesop[0][5];
			$val[]=$exceldata['mothername'] = $filesop[0][6];
			$exceldata['username'] = $filesop[0][7];
			$val[]=$exceldata['dob'] = $filesop[0][8];
			$val[]=$exceldata['enroll'] = $filesop[0][9];
			$val[]=$exceldata['mobile'] = $filesop[0][10];
			$val[]=$exceldata['sms_mobile'] = $filesop[0][11];
			$exceldata['formno'] = $filesop[0][12];
			$exceldata['adaharnumber'] = $filesop[0][13];
			$exceldata['cast'] = $filesop[0][14];
			$exceldata['house_id'] = $this->Houses->find('all')->select(['id'])->where(['name'=>$filesop[0][15]])->first()->id;;
			$val[]=$exceldata['class_id'] = $this->Classes->find('all')->select(['id'])->where(['title'=>$filesop[0][16]])->first()->id;
			$exceldata['category'] = $filesop[0][17];
			$val[]=$exceldata['section_id']= $this->Sections->find('all')->select(['id'])->where(['title'=>$filesop[0][18]])->first()->id;
			$val[]=$exceldata['board_id'] = $this->Board->find('all')->select(['id'])->where(['name'=>$filesop[0][19]])->first()->id;
			$val[]=$exceldata['gender'] = $filesop[0][20];
			$exceldata['photo'] = $filesop[0][21];
			$exceldata['bloodgroup'] = $filesop[0][22];
			$exceldata['religion'] = $filesop[0][23];
			$val[]=$exceldata['address'] = $filesop[0][24];
			$val[]=$exceldata['city'] = $filesop[0][25];
			$exceldata['nationality'] = $filesop[0][26];
			$exceldata['created'] = $filesop[0][27];
			$exceldata['acedmicyear'] = $filesop[0][28];
			$exceldata['admissionyear'] = $filesop[0][29];
			$exceldata['status'] = $filesop[0][30];
			$exceldata['is_transport'] = $filesop[0][31];
			$exceldata['transportloc_id'] = $filesop[0][32];
			$exceldata['v_num'] = $filesop[0][33];
			$exceldata['discountcategory'] = $filesop[0][34];
			$exceldata['due_fees'] = $filesop[0][35];
			$exceldata['height'] = $filesop[0][36];
			$exceldata['weight'] = $filesop[0][37];
			$exceldata['is_special'] = $filesop[0][38];
			$exceldata['disability'] = $filesop[0][39];
			$exceldata['admissionclass'] = $filesop[0][40];
			$exceldata['mother_tounge'] = $filesop[0][41];
			$exceldata['f_qualification'] = $filesop[0][42];
			$exceldata['f_occupation'] = $filesop[0][43];
			$exceldata['m_qualification'] = $filesop[0][44];
			$exceldata['m_occupation'] = $filesop[0][45];
			$val[]=$exceldata['f_phone'] = $filesop[0][46];
			$exceldata['m_phone'] = $filesop[0][47];
			$sum = 0;
			$sum = $exceldata['pfdeduction'] + $exceldata['esideduction'];
			$exceldata['netpay'] = $filesop[0][19] - $sum;
		  
		  if(in_array('', array_map('trim',$val))){
			//  pr($val); die;
			  $ret="null";
			  return $ret;
		  }
			$csv_data[] = $exceldata;

		}
		return $csv_data;
	}

}

}
