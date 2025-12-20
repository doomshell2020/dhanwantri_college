<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use App\Controller\Admin\ReportController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
class StudentfeesController extends AppController
{
	//initialize component
	public function initialize(){
		
	
		
        parent::initialize();
       	$this->loadModel('Studentfees');
       	$this->loadModel('Classes');
       	$this->loadModel('Classections');
       	$this->loadModel('Subjects');
       	$this->loadModel('Subjectclass');
       	$this->loadModel('Feesheads');
       	$this->loadModel('Sections');
       	$this->loadModel('Students');
       	$this->loadModel('Classfee');
       	$this->loadModel('Banks');
       	$this->loadModel('Transportfees');
       	$this->loadModel('StudentTransfees');
       	$this->loadModel('StudentHostalfees');
       	$this->loadModel('Banks');
       	$this->loadModel('Hostels');
       	$this->loadModel('Previousduefees');
       	$this->loadModel('Sitesettings');
       	$this->loadModel('Users');
       	$this->loadModel('Studentfeepending');
       	$this->loadModel('Houses');
       	$this->loadModel('Enquires');
       	$this->loadModel('Applicant');
       	$this->loadModel('Studentshistory');
       	$this->loadModel('DropOutStudent');
       	
       		$this->loadModel('DiscountCategory');
       		
       		       
    	}
    	
    	
    	
    	public function rollbackscomplete(){
     $this->autoRender = false;
	$studentfees = $this->Studentfees->find('all')->where(['Studentfees.acedmicyear'=>'2019-20','Studentfees.type'=>'Fee','Studentfees.recipetno !='=>0,'Studentfees.status'=>'Y'])->toarray();
	foreach($studentfees as $studentfees){
	$quarter=$studentfees['quarter'];
	$student_id=$studentfees['student_id'];
	$acedmicyear=$studentfees['acedmicyear'];
	$feesid=$studentfees['id'];
	$deposite_amt=(int)$studentfees['deposite_amt'];


	$aee=unserialize($quarter);
	
$amoutpay=0;
	foreach($aee as $kru=>$amtr){  
		
$amoutpay +=(int)$amtr;
	}

	if($studentfees['lfine']!=''){ 
		
		$total=(int)$studentfees['lfine']+(int)$amoutpay;
		
		}else{
			$total=(int)$amoutpay;
			
		}
		
		
		$studentfeependings= $this->Studentfeepending->find('all')->where(['r_id'=>$feesid,'s_id'=>$student_id])->first();
	//pr($studentfeependings); die;
	if($studentfeependings['id']){
		
		if($studentfeependings['amt']>0){
			
			
		$net=(int)$total-(int)$studentfeependings['amt'];

	}else if($studentfeependings['amt']<0){
		$studentfeependings['amt']=abs($studentfeependings['amt']);
		$net=(int)$total+(int)$studentfeependings['amt'];
		
		
	}
		
	}else{
		
		$net=(int)$total;
	}
	
	if($studentfees['discount']!='0.00' || $studentfees['discount']!='0'  ){ 
		$net=(int)$net-(int)$studentfees['discount'];
		
	}else{
		$net=(int)$net;
		
	}
	
	if($studentfees['addtionaldiscount']!='0'  ){ 
		$net=(int)$net-(int)$studentfees['addtionaldiscount'];
		
	}else{
		$net=(int)$net;
		
	}

	if($net==$deposite_amt){
		
	}else{

		if($studentfees['id']){
			echo $studentfees['recipetno'].'/'.$net.'/'.$deposite_amt.'<br>';
		}
		
		
		
	
	
		
		
	}
}
		
	}
    	
    public function viewsibling($id=null){
	

		   $stdnt=$this->Students->find('all')->where(['Students.id'=>$id])->first();
		   $fathername=$stdnt['fathername'];
		   $mothername=$stdnt['mothername'];
		   $student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.fathername'=>$fathername,'Students.mothername'=>$mothername,'Students.id NOT IN'=>$id,'Students.status'=>'Y'])->toarray();
		   $this->set('students',$student_data);
		   
		
	}
    	
    	public function previousduefees($id=null){ 
	
		$this->viewBuilder()->layout('admin');
		if(isset($id) && !empty($id)){
			//using for edit
			$previousduefees = $this->Previousduefees->get($id);

		}else{
			//using for new entry
			$previousduefees = $this->Previousduefees->newEntity();
		}
		if ($this->request->is(['post', 'put'])) {
			
  	//	pr($this->request->data); die;
				
				// save all data in database
				$acedmicyear=$this->request->data['acedmicyear'];
				$stid=$this->request->data['student_id'];
				$previousduefees = $this->Previousduefees->patchEntity($previousduefees, $this->request->data);
					//pr($previousduefees); die;
				if ($this->Previousduefees->save($previousduefees)) {
			 $conn = ConnectionManager::get('default');
$conn->execute("UPDATE `students` SET `due_fees` = '0' WHERE `id`='".$stid."'");
					$this->Flash->success(__('Previous Due Fees has been saved.'));
				return $this->redirect(['action' => 'index/'.$stid.'/'.$acedmicyear.'/?id=pduefee']);	
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

		$this->set('previousduefees', $previousduefees);
	}
    	
    	
    	
    	public function studentfeeindex($id=null,$academic_year=null){ 
	
		$this->viewBuilder()->layout('admin');
			
	$feesheadstotal = $this->Feesheads->find('all', [
			'keyField' => 'id',
			'valueField' => 'name'
			])->where(['status' => 'Y','type IN'=>['3','0']])->order(['name' => 'ASC'])->toArray();
		$this->set('feesheadstotal',$feesheadstotal);
	
	
	$discountCategorylist = $this->DiscountCategory->find('all', [
			'keyField' => 'id',
			'valueField' => 'name'
			])->where(['status' => 'Y','type'=>'0'])->order(['id' => 'ASC'])->toArray();
		$this->set('discountCategorylist',$discountCategorylist);
		//show data in listing
		if($_GET['id']){
		
				$this->set('selectid',$_GET['id']);
		 }
		 
		 

		 if($this->request->session()->read('paydatef')){
			 $paydatef=$this->request->session()->read('paydatef'); 
			
			$ids2s=$this->request->session()->read('reciptnof');
				$this->set('paydatef',$paydatef);
			if($ids2s!='0'){
			 $reciptnof=$ids2s+1;
		
				$this->set('reciptnof',$reciptnof);
				
				}
		  }
		//echo $this->request->session()->read('openfess_recipt'); die;
		 	
		   $stdnt= $this->Students->get($id);
		   $discount_fees=$stdnt->dis_fees;
		   $dis_hostel=$stdnt->dis_hostel;
		   $dis_transport=$stdnt->dis_transport;
		   $classid=$stdnt->class_id;
		   $academic_year=$academic_year;
		  
		   	$alldata = $this->Classfee->find('all')->contain(['Feesheads'])->where(['class_id' =>$classid,'academic_year' =>$academic_year])->toarray();
	$personalduefees=$this->Previousduefees->find('all')->where(['Previousduefees.student_id' =>$id])->first();	  
	$Sitesettings=$this->Sitesettings->find('all')->where(['Sitesettings.print' =>'1'])->first();	  
		$this->set('Sitesettings',$Sitesettings);
			$this->set('personalduefees',$personalduefees);
	$this->set('alldata',$alldata);
	$this->set('id',$id);
	$this->set('academic_year',$academic_year);
		 
		   if(!empty($discount_fees))
		   {
		$this->set('discount_fees', $discount_fees);
	}
	else
	{
		$discount_fees='0';
	$this->set('discount_fees',$discount_fees);	
		
	}
	 if(!empty($dis_hostel))
		   {
		$this->set('dis_hostel', $dis_hostel);
	}
	else
	{
		$dis_hostel='0';
	$this->set('dis_hostel',$dis_hostel);	
		
	}
	 if(!empty($dis_transport))
		   {
		$this->set('dis_transport', $dis_transport);
	}
	else
	{
		$dis_transport='0';
	$this->set('dis_transport',$dis_transport);	
		
	}
	
	
	
	
		$feeheads = $this->Feesheads->find('all')->where(['Feesheads.status' => 'Y'])->toarray();
	$this->set('feeheads',$feeheads);
	
		$feeheadstype = $this->Feesheads->find('all')->where(['Feesheads.type' => '2'])->toarray();
	$this->set('feeheadstype',$feeheadstype);
		 $classfeesss = $this->Classfee->find('all')->contain(['Classes','Feesheads'])->group('Classfee.academic_year')->group('Classfee.class_id')->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => $this->Classfee->find()->func()->sum('Classfee.qu1_fees'), 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),'Classes.title','Classfee.academic_year','Classfee.id','Classfee.qu1_date','Feesheads.name','Classfee.qu2_date','Classfee.qu3_date','Classfee.qu4_date','Classfee.status','Classfee.class_id'])->toarray();
$this->set('classfeesss', $classfeesss);
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
	
	$sectionslist = $this->Sections->find('list', [
    'keyField' => 'id',
    'valueField' => 'title'
])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist',$sectionslist);
		$this->set('id',$id);
$banks = $this->Banks->find('list', ['keyField' => 'id',
    'valueField' => 'name'])->where(['Banks.status' => 'Y'])->order(['Banks.id' => 'asc'])->toArray();
	$this->set('banks', $banks);
	
$rolepresent=$this->request->session()->read('Auth.User.role_id');
		if($rolepresent=='1'){ 
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' => $id,'Students.status'=>'Y'])->first();
	$this->set('students',$student_data);
	
}else if($rolepresent=='5'){ 
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' => $id,'Students.board_id' =>'1','Students.status'=>'Y'])->first();
	$this->set('students',$student_data);
	
}else if($rolepresent=='8'){ 
	
	$boards=['2','3'];
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' => $id,'Students.board_id IN' =>$boards,'Students.status'=>'Y'])->first();
	$this->set('students',$student_data);
	
}

		$acedmicyear=$academic_year;
		$this->set('academic_year',$academic_year);
		$acedmiclassid=$student_data['class_id'];
				$this->set('academic_class',$acedmiclassid);
				$is_transport=$student_data['is_transport'];
				$is_hostel=$student_data['is_hostel'];
		
		$this->set('is_transport',$is_transport);
		$this->set('is_hostel',$is_hostel);
	
		$transportloc_id=$student_data['transportloc_id'];
			$this->set('transportloc_id',$transportloc_id);
			
			$hostal_id=$student_data['h_id'];
			$this->set('hostal_id',$hostal_id);
			
				$this->set('id',$id);
		$transportfeess = $this->Transportfees->find('all')->where(['Transportfees.loc_id' => $transportloc_id,'Transportfees.academic_year' => $acedmicyear])->toarray();
			$this->set('transportfeess',$transportfeess);
			
				$hostalfeess = $this->Hostels->find('all')->where(['Hostels.id' => 
				$hostal_id,'Hostels.academicyear' => $acedmicyear])->toarray();
			$this->set('hostalfeess',$hostalfeess);  
			
			
		$student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id,'Studentfees.refrencepending'=>'0','Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->toarray();
		$this->set('studentfees',$student_datas);
		
			
		$student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id,'Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y','Studentfees.deposite_amt !='=>'0'])->toarray();
		$this->set('studentfeesk',$student_datask);
		
	
		$student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $id,'Studentfeepending.status' => 'N'])->toarray();
		$this->set('student_feepending',$student_feepending);
		
				
		$student_datash = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id,'Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->group(['Studentfees.created'])->toarray();
		$this->set('stduefee',$student_datash);
		
			$student_trans = $this->StudentTransfees->find('all')->where(['StudentTransfees.student_id' => $id,'StudentTransfees.acedmicyear' => $acedmicyear])->toarray();
		$this->set('studenttransfee',$student_trans);
			$student_hostal = $this->StudentHostalfees->find('all')->where(['StudentHostalfees.student_id' => $id,'StudentHostalfees.student_id' => $id])->toarray();
		$this->set('studenthostalfee',$student_hostal);
			$classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->where(['Classfee.fee_h_id IN' => ['2','9'],'Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid])->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),'Classes.title','Classfee.academic_year','Classfee.id','Classfee.status','Classfee.class_id'
])->toarray();


			$this->set('classfee',$classfee);
			$fid=['7','3','4','9'];
			$sfee = 
			$this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid,'Classfee.fee_h_id IN' => $fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
				$this->set('preclassfee',$sfee);
	

	
	}
    	
    	public function paynow(){ 
$this->viewBuilder()->layout('admin');
		$user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$rolepresentyear=$user['academic_year'];
		
			$this->set(compact('rolepresentyear'));
	
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
		
	
	
		
		
		if($rolepresent=='1'){ 
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status'=>'Y'])->order(['Students.id'=>'DESC','Students.fname' => 'ASC'])->toarray();
		$this->set('students',$student_data);
	
}else if($rolepresent=='5'){ 
	
		$student_data = 
		$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status'=>'Y','Students.board_id'=>'1'])->order(['Students.id'=>'DESC','Students.fname' => 'ASC'])->limit(20)->toarray();
		$this->set('students',$student_data);
	
}else if($rolepresent=='8'){ 
	$bordid=['2','3'];
	$student_data = 
	$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status'=>'Y','Students.board_id IN'=>$bordid])->order(['Students.id'=>'DESC','Students.fname' => 'ASC'])->limit(20)->toarray();
		$this->set('students',$student_data);
	
}
		//get data from paricular id
			
		}
    	
	public function index($id=null,$academic_year=null){ 
	
		$this->viewBuilder()->layout('admin');
			
	$feesheadstotal = $this->Feesheads->find('all', [
			'keyField' => 'id',
			'valueField' => 'name'
			])->where(['status' => 'Y','type IN'=>['3','0'],'sort !=' => '0'])->order(['name' => 'ASC'])->toArray();
		$this->set('feesheadstotal',$feesheadstotal);
		
	//$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

//$academic_year=$users['academic_year'];
	
	$discountCategorylist = $this->DiscountCategory->find('all', [
			'keyField' => 'id',
			'valueField' => 'name'
			])->where(['status' => 'Y','type !='=>'1'])->order(['id' => 'ASC'])->toArray();
		$this->set('discountCategorylist',$discountCategorylist);
		//show data in listing
		if($_GET['id']){
		
				$this->set('selectid',$_GET['id']);
		 }
		 
		 

		 if($this->request->session()->read('paydatef')){
			 $paydatef=$this->request->session()->read('paydatef'); 
			
			$ids2s=$this->request->session()->read('reciptnof');
				$this->set('paydatef',$paydatef);
			if($ids2s!='0'){
			 $reciptnof=$ids2s+1;
		
				$this->set('reciptnof',$reciptnof);
				
				}
		  }
		  
		  
		  $this->set(compact('id'));	
		  $this->set(compact('academic_year'));	
		  	
		
	
	 
		   $stdnt= $this->Students->get($id);
		   $discount_fees=$stdnt->dis_fees;
		   $dis_hostel=$stdnt->dis_hostel;
		   $dis_transport=$stdnt->dis_transport;
		   $classid=$stdnt->class_id;
		   $academic_year=$academic_year;
		  
		   	$alldata = $this->Classfee->find('all')->contain(['Feesheads'])->where(['class_id' =>$classid,'academic_year' =>$academic_year])->toarray();
	$personalduefees=$this->Previousduefees->find('all')->where(['Previousduefees.student_id' =>$id])->first();	  
	$Sitesettings=$this->Sitesettings->find('all')->where(['Sitesettings.print' =>'1'])->first();	  
		$this->set('Sitesettings',$Sitesettings);
			$this->set('personalduefees',$personalduefees);
	$this->set('alldata',$alldata);
	$this->set('id',$id);
	$this->set('academic_year',$academic_year);
		 
		   if(!empty($discount_fees))
		   {
		$this->set('discount_fees', $discount_fees);
	}
	else
	{
		$discount_fees='0';
	$this->set('discount_fees',$discount_fees);	
		
	}
	 if(!empty($dis_hostel))
		   {
		$this->set('dis_hostel', $dis_hostel);
	}
	else
	{
		$dis_hostel='0';
	$this->set('dis_hostel',$dis_hostel);	
		
	}
	 if(!empty($dis_transport))
		   {
		$this->set('dis_transport', $dis_transport);
	}
	else
	{
		$dis_transport='0';
	$this->set('dis_transport',$dis_transport);	
		
	}
	
	
	  $stdntddf=$this->Students->find('all')->where(['Students.id'=>$id])->first();
		   $fathernamefffg=$stdntddf['fathername'];
		   $mothernamefffg=$stdntddf['mothername'];
		   $student_dataftf = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.fathername'=>$fathernamefffg,'Students.mothername'=>$mothernamefffg,'Students.id NOT IN'=>$id,'Students.status'=>'Y'])->toarray();
		   $this->set('student_dataftf',$student_dataftf);
	
		$feeheads = $this->Feesheads->find('all')->where(['Feesheads.status' => 'Y'])->toarray();
	$this->set('feeheads',$feeheads);
	
		$feeheadstype = $this->Feesheads->find('all')->where(['Feesheads.type' => '2'])->toarray();
	$this->set('feeheadstype',$feeheadstype);
		 $classfeesss = $this->Classfee->find('all')->contain(['Classes','Feesheads'])->group('Classfee.academic_year')->group('Classfee.class_id')->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => $this->Classfee->find()->func()->sum('Classfee.qu1_fees'), 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),'Classes.title','Classfee.academic_year','Classfee.id','Classfee.qu1_date','Feesheads.name','Classfee.qu2_date','Classfee.qu3_date','Classfee.qu4_date','Classfee.status','Classfee.class_id'])->toarray();
$this->set('classfeesss', $classfeesss);
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
	
	$sectionslist = $this->Sections->find('list', [
    'keyField' => 'id',
    'valueField' => 'title'
])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist',$sectionslist);
		$this->set('id',$id);
$banks = $this->Banks->find('list', ['keyField' => 'id',
    'valueField' => 'name'])->where(['Banks.status' => 'Y'])->order(['Banks.id' => 'asc'])->toArray();
	$this->set('banks', $banks);
	
$rolepresent=$this->request->session()->read('Auth.User.role_id');
		if($rolepresent=='1'){ 
			
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' => $id,'Students.status'=>'Y'])->first();
	$this->set('students',$student_data);
	
}else if($rolepresent=='5'){ 


	$student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
	
			$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
		
		$student_datasmaxssss = $this->Studentfees->find('all')->contain(['Students'])->select(['cheque_no','ref_no','bank'])->where(['Students.board_id' =>'1','Students.status' =>'Y'])->order(['Studentfees.id DESC'])->first();  	
		
		$this->set('student_datasmaxssss',$student_datasmaxssss['cheque_no']);
		$this->set('student_datasmref_no',$student_datasmaxssss['ref_no']);
		$this->set('student_databank',$student_datasmaxssss['bank']);
		  $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' =>'1'])->first();
		 
		  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' =>'1','Enquires.class_id <='=>'22'])->contain(['Enquires'])->first();
		  	  
		  	  $c = $student_datasmaxss['amount'];
		  	  
		  	  
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' => $id,'Students.board_id' =>'1'])->first();
	$this->set('students',$student_data);
	
}else if($rolepresent=='8'){ 
	
	$boards=['2','3'];
	
		  		
		  	$boardzs=['2','3'];
	
		$student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		
			$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
		$student_datasmaxssss = $this->Studentfees->find('all')->contain(['Students'])->select(['cheque_no','ref_no','bank'])->where(['Students.board_id IN' =>$boardzs,'Students.status'=>'Y'])->order(['Studentfees.id DESC'])->first();  	
		
		$this->set('student_datasmaxssss',$student_datasmaxssss['cheque_no']);
			$this->set('student_datasmref_no',$student_datasmaxssss['ref_no']);
			$this->set('student_databank',$student_datasmaxssss['bank']);
			$student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs])->first();
			
					  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs,'Enquires.class_id >='=>'23'])->contain(['Enquires'])->first();
		  	  $c = $student_datasmaxss['amount'];
		  		
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' => $id,'Students.board_id IN' =>$boards])->first();
	$this->set('students',$student_data);
	
}


	

$student_datasm=$c+1;


$this->set('student_datasm',$student_datasm);






		$acedmicyear=$academic_year;
		$this->set('academic_year',$academic_year);
		$acedmiclassid=$student_data['class_id'];
				$this->set('academic_class',$acedmiclassid);
				$is_transport=$student_data['is_transport'];
				$is_hostel=$student_data['is_hostel'];
		
		$this->set('is_transport',$is_transport);
		$this->set('is_hostel',$is_hostel);
	
		$transportloc_id=$student_data['transportloc_id'];
			$this->set('transportloc_id',$transportloc_id);
			
			$hostal_id=$student_data['h_id'];
			$this->set('hostal_id',$hostal_id);
			
				$this->set('id',$id);
		$transportfeess = $this->Transportfees->find('all')->where(['Transportfees.loc_id' =>$transportloc_id,'Transportfees.academic_year' => $acedmicyear])->toarray();
			$this->set('transportfeess',$transportfeess);
			
				$hostalfeess = $this->Hostels->find('all')->where(['Hostels.id' => 
				$hostal_id,'Hostels.academicyear' => $acedmicyear])->toarray();
			$this->set('hostalfeess',$hostalfeess);  
			
			
			
			
				$studentold = $this->Students->find('all')->where(['Students.id' =>$id,'Students.acedmicyear' =>$acedmicyear])->first();
		$oldenrool=$studentold['oldenroll']; 
			if($oldenrool){
				
				
			if($rolepresent=='5'){ 
					$boardzs=['2','3'];
		$studsentold = $this->Students->find('all')->where(['Students.enroll'=>$oldenrool,'Students.board_id IN' =>$boardzs])->first();
			 
			
			}else if($rolepresent=='8'){ 
				
					$studsentold = $this->Students->find('all')->where(['Students.enroll'=>$oldenrool,'Students.board_id' =>'1'])->first();	
			}
			$ols=$studsentold['id'];	
		$student_datas3s = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$ols,'Studentfees.refrencepending'=>'0','Studentfees.status' =>'Y','Studentfees.acedmicyear' =>$acedmicyear])->toarray();
	$student_datas31s = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$ols,'Studentfees.refrencepending'=>'0','Studentfees.status' =>'Y','Studentfees.recipetno' =>0])->toarray();
if(isset($student_datas31s)){
$student_datas3s=array_merge($student_datas31s,$student_datas3s);

}
		$this->set('studentfees2s',$student_datas3s);	
		

			}
			
		$student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$id,'Studentfees.refrencepending'=>'0','Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->toarray();
		$this->set('studentfees',$student_datas);
		$student_datas2 = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$id,'Studentfees.refrencepending'=>'0','Studentfees.status' =>'Y'])->toarray();
		$this->set('studentfees2',$student_datas2);
			
		$student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$id,'Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y','Studentfees.deposite_amt !='=>'0','Studentfees.recipetno !='=>'0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
		$this->set('studentfeesk',$student_datask);
		
		
		$student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$id,'Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y','Studentfees.deposite_amt !='=>'0','Studentfees.recipetno !='=>'0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
		$this->set('studentfeesk',$student_datask);
		
	 $student_feepending=$this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' =>$id,'Studentfeepending.status' => 'N'])->toarray();
		$this->set('student_feepending',$student_feepending);
		
				
		$student_datash = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$id,'Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->group(['Studentfees.created'])->toarray();
		$this->set('stduefee',$student_datash);
		
			$student_trans = $this->StudentTransfees->find('all')->where(['StudentTransfees.student_id' =>$id,'StudentTransfees.acedmicyear' => $acedmicyear])->toarray();
		$this->set('studenttransfee',$student_trans);
			$student_hostal = $this->StudentHostalfees->find('all')->where(['StudentHostalfees.student_id' =>$id,'StudentHostalfees.student_id' => $id])->toarray();
		$this->set('studenthostalfee',$student_hostal);
			$classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->where(['Classfee.fee_h_id IN' => ['2','9'],'Classfee.academic_year' =>$acedmicyear,'Classfee.class_id' =>$acedmiclassid])->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' =>$this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),'Classes.title','Classfee.academic_year','Classfee.id','Classfee.status','Classfee.class_id'
])->toarray();


			$this->set('classfee',$classfee);
			$fid=['7','3','4','9'];
			$sfee = 
			$this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid,'Classfee.fee_h_id IN' => $fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
				$this->set('preclassfee',$sfee);
	

	
	}
	public function history($id=null,$academic_year=null){ 
	
		$this->viewBuilder()->layout('admin');
			
	$feesheadstotal = $this->Feesheads->find('all', [
			'keyField' => 'id',
			'valueField' => 'name'
			])->where(['status' => 'Y','type IN'=>['3','0'],'sort !=' => '0'])->order(['name' => 'ASC'])->toArray();
		$this->set('feesheadstotal',$feesheadstotal);
		
	
	
	$discountCategorylist = $this->DiscountCategory->find('all', [
			'keyField' => 'id',
			'valueField' => 'name'
			])->where(['status' => 'Y','type !='=>'1'])->order(['id' => 'ASC'])->toArray();
		$this->set('discountCategorylist',$discountCategorylist);

		if($_GET['id']){
		
				$this->set('selectid',$_GET['id']);
		 }
		 
		 

		 if($this->request->session()->read('paydatef')){
			 $paydatef=$this->request->session()->read('paydatef'); 
			
			$ids2s=$this->request->session()->read('reciptnof');
				$this->set('paydatef',$paydatef);
			if($ids2s!='0'){
			 $reciptnof=$ids2s+1;
		
				$this->set('reciptnof',$reciptnof);
				
				}
		  }
		  
		  
		  $this->set(compact('id'));	
		  $this->set(compact('academic_year'));	
		  	
		
	
	 $stdnt = $this->Studentshistory->find('all')->contain(['Classes','Sections'])->where(['Studentshistory.stud_id' =>$id,'Studentshistory.acedmicyear'=>$academic_year])->first();
	 $stdntcurrent = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$id])->first();
			$this->set('acedmicyears',$stdntcurrent['acedmicyear']);
			
			
		   $discount_fees=$stdnt->dis_fees;
		   $dis_hostel=$stdnt->dis_hostel;
		   $dis_transport=$stdnt->dis_transport;
		   $classid=$stdnt->class_id;
		   $academic_year=$academic_year;
		  
		   	$alldata = $this->Classfee->find('all')->contain(['Feesheads'])->where(['class_id' =>$classid,'academic_year' =>$academic_year])->toarray();
	$personalduefees=$this->Previousduefees->find('all')->where(['Previousduefees.student_id' =>$id])->first();	  
	$Sitesettings=$this->Sitesettings->find('all')->where(['Sitesettings.print' =>'1'])->first();	  
		$this->set('Sitesettings',$Sitesettings);
			$this->set('personalduefees',$personalduefees);
	$this->set('alldata',$alldata);
	$this->set('id',$id);
	
	
	$this->set('academic_year',$academic_year);
		 
		   if(!empty($discount_fees))
		   {
		$this->set('discount_fees', $discount_fees);
	}
	else
	{
		$discount_fees='0';
	$this->set('discount_fees',$discount_fees);	
		
	}
	 if(!empty($dis_hostel))
		   {
		$this->set('dis_hostel', $dis_hostel);
	}
	else
	{
		$dis_hostel='0';
	$this->set('dis_hostel',$dis_hostel);	
		
	}
	 if(!empty($dis_transport))
		   {
		$this->set('dis_transport', $dis_transport);
	}
	else
	{
		$dis_transport='0';
	$this->set('dis_transport',$dis_transport);	
		
	}
	
	
	
	
		$feeheads = $this->Feesheads->find('all')->where(['Feesheads.status' => 'Y'])->toarray();
	$this->set('feeheads',$feeheads);
	
	$feeheadstype = $this->Feesheads->find('all')->where(['Feesheads.type' => '2'])->toarray();
	$this->set('feeheadstype',$feeheadstype);
		 $classfeesss = $this->Classfee->find('all')->contain(['Classes','Feesheads'])->group('Classfee.academic_year')->group('Classfee.class_id')->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => $this->Classfee->find()->func()->sum('Classfee.qu1_fees'), 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),'Classes.title','Classfee.academic_year','Classfee.id','Classfee.qu1_date','Feesheads.name','Classfee.qu2_date','Classfee.qu3_date','Classfee.qu4_date','Classfee.status','Classfee.class_id'])->toarray();
$this->set('classfeesss', $classfeesss);
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
	
$sectionslist = $this->Sections->find('list', [
    'keyField' => 'id',
    'valueField' => 'title'
])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist',$sectionslist);
		$this->set('id',$id);
$banks = $this->Banks->find('list', ['keyField' => 'id',
    'valueField' => 'name'])->where(['Banks.status' => 'Y'])->order(['Banks.id' => 'asc'])->toArray();
	$this->set('banks', $banks);
	
$rolepresent=$this->request->session()->read('Auth.User.role_id');
		if($rolepresent=='1'){ 
			
		$student_data = $this->Studentshistory->find('all')->contain(['Classes','Sections'])->where(['Studentshistory.stud_id' => $id,'Students.status'=>'Y'])->first();
	$this->set('students',$student_data);
	
}else if($rolepresent=='5'){ 


	$student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
			$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
		
		$student_datasmaxssss = $this->Studentfees->find('all')->contain(['Students'])->select(['cheque_no','ref_no','bank'])->where(['Students.board_id' =>'1','Students.status' =>'Y'])->order(['Studentfees.id DESC'])->first();  	
		
		$this->set('student_datasmaxssss',$student_datasmaxssss['cheque_no']);
		$this->set('student_datasmref_no',$student_datasmaxssss['ref_no']);
		$this->set('student_databank',$student_datasmaxssss['bank']);
		  $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' =>'1'])->first();
		  
		  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' =>'1','Enquires.class_id <='=>'22'])->contain(['Enquires'])->first();
		  	  
		  	
		  	    $c = $student_datasmaxss['amount'];
		  	  
		$student_data = $this->Studentshistory->find('all')->contain(['Classes','Sections'])->where(['Studentshistory.stud_id' => $id,'Studentshistory.status'=>'Y'])->first();
	$this->set('students',$student_data);
	
}else if($rolepresent=='8'){ 
	
	$boards=['2','3'];
	
		  		
		  	$boardzs=['2','3'];
	
		$student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
			$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
		$student_datasmaxssss = $this->Studentfees->find('all')->contain(['Students'])->select(['cheque_no','ref_no','bank'])->where(['Students.board_id IN' =>$boardzs,'Students.status'=>'Y'])->order(['Studentfees.id DESC'])->first();  	
		
		$this->set('student_datasmaxssss',$student_datasmaxssss['cheque_no']);
			$this->set('student_datasmref_no',$student_datasmaxssss['ref_no']);
			$this->set('student_databank',$student_datasmaxssss['bank']);
			$student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs])->first();
			
					  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs,'Enquires.class_id >='=>'23'])->contain(['Enquires'])->first();
		  $c = $student_datasmaxss['amount'];
		  		
		$student_data = $this->Studentshistory->find('all')->contain(['Classes','Sections'])->where(['Studentshistory.stud_id' => $id,'Studentshistory.status'=>'Y'])->first();
	$this->set('students',$student_data);
	
}


	

$student_datasm=$c+1;


$this->set('student_datasm',$student_datasm);






		$acedmicyear=$academic_year;
		$this->set('academic_year',$academic_year);
		$acedmiclassid=$student_data['class_id'];
				$this->set('academic_class',$acedmiclassid);
				$is_transport=$student_data['is_transport'];
				$is_hostel=$student_data['is_hostel'];
		
		$this->set('is_transport',$is_transport);
		$this->set('is_hostel',$is_hostel);
	
		$transportloc_id=$student_data['transportloc_id'];
			$this->set('transportloc_id',$transportloc_id);
			
			$hostal_id=$student_data['h_id'];
			$this->set('hostal_id',$hostal_id);
			
				$this->set('id',$id);
		$transportfeess = $this->Transportfees->find('all')->where(['Transportfees.loc_id' => $transportloc_id,'Transportfees.academic_year' =>$acedmicyear])->toarray();
			$this->set('transportfeess',$transportfeess);
			
				$hostalfeess = $this->Hostels->find('all')->where(['Hostels.id' => 
				$hostal_id,'Hostels.academicyear' => $acedmicyear])->toarray();
			$this->set('hostalfeess',$hostalfeess);  
			
			
		$student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id,'Studentfees.refrencepending'=>'0','Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->toarray();
		
		
		$this->set('studentfees',$student_datas);
		
			
		$student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id,'Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y','Studentfees.deposite_amt !='=>'0','Studentfees.recipetno !='=>'0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
		$this->set('studentfeesk',$student_datask);
		
	
		$student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $id,'Studentfeepending.status' => 'N'])->toarray();
		$this->set('student_feepending',$student_feepending);
		
				
		$student_datash = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id,'Studentfees.acedmicyear' => $acedmicyear,'Studentfees.status' =>'Y'])->group(['Studentfees.created'])->toarray();
		$this->set('stduefee',$student_datash);
		
			$student_trans = $this->StudentTransfees->find('all')->where(['StudentTransfees.student_id' => $id,'StudentTransfees.acedmicyear' => $acedmicyear])->toarray();
		$this->set('studenttransfee',$student_trans);
			$student_hostal = $this->StudentHostalfees->find('all')->where(['StudentHostalfees.student_id' => $id,'StudentHostalfees.student_id' => $id])->toarray();
		$this->set('studenthostalfee',$student_hostal);
			$classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->where(['Classfee.fee_h_id IN' => ['2','9'],'Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid])->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),'Classes.title','Classfee.academic_year','Classfee.id','Classfee.status','Classfee.class_id'
])->toarray();


			$this->set('classfee',$classfee);
			$fid=['7','3','4','9'];
			$sfee = 
			$this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear,'Classfee.class_id' => $acedmiclassid,'Classfee.fee_h_id IN' => $fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
				$this->set('preclassfee',$sfee);
	

	
	}
	 public function printscaution($idf=null,$acedemic=null){

	$this->viewBuilder()->layout('ajax');
	$this->sitesetting('receipt');
	$this->response->type('pdf');
	$student_datas = $this->Studentfees->find('all')->where(['Studentfees.id' => $idf,'Studentfees.acedmicyear' =>$acedemic])->first();

$id=$student_datas['student_id'];


	$quater=["Caution Money"];
	
	
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$id,'Students.acedmicyear' =>$acedemic])->first();
	$this->set(compact('students'));
	if(empty($students)){
		$students = $this->DropOutStudent->find('all')->contain(['Classes','Sections'])->where(['DropOutStudent.s_id' =>$id,'DropOutStudent.acedmicyear' =>$acedemic,'DropOutStudent.status'=>'Y'])->first();
		
	
	$this->set(compact('students'));
		
	}
if($_GET['gid']){
	$gid=1;
	
}else{
	
	$gid=2;
}
$this->set(compact('gid'));

	$student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id,'Studentfees.acedmicyear' =>$acedemic,'Studentfees.id' => $idf])->first();
	
		$this->set('studentfees',$student_datas);
		



}
	 public function printscautionhistory($idf=null,$acedemic=null){

	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');

	$student_datas = $this->Studentfees->find('all')->where(['Studentfees.id' => $idf,'Studentfees.acedmicyear' =>$acedemic])->first();

$id=$student_datas['student_id'];

if($_GET['gid']){
	$gid=1;
	
}else{
	
	$gid=2;
}
$this->set(compact('gid'));

	$quater=["Caution Money"];
	//~ $stdnt= $this->Students->get($id);
		   //~ $discount_fees=$stdnt->dis_fees;
		   //~ if(!empty($discount_fees))
		   //~ {
		//~ //$this->set('discount_fees', $discount_fees);
	//~ }
	//~ else
	//~ {
		//~ $discount_fees='0';
	//~ //$this->set('discount_fees',$discount_fees);	
	//~ }
	
	
	$students = $this->Studentshistory->find('all')->contain(['Classes','Sections'])->where(['Studentshistory.stud_id' =>$id,'Studentshistory.acedmicyear' =>$acedemic,'Studentshistory.status'=>'Y'])->first();
	$this->set(compact('students'));
	


	$student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id,'Studentfees.acedmicyear' =>$acedemic,'Studentfees.id' => $idf])->first();
	
		$this->set('studentfees',$student_datas);
		



}
	 public function printsadmission($idf=null,$acedemic=null){

	$this->viewBuilder()->layout('ajax');
	$this->sitesetting('receipt');
	$this->response->type('pdf');
		$ert=base64_decode ($quater);	
		
$student_datas = $this->Studentfees->find('all')->where(['Studentfees.id' => $idf,'Studentfees.acedmicyear' =>$acedemic])->first();

$id=$student_datas['student_id'];

if($_GET['gid']){
	$gid=1;
	
}else{
	
	$gid=2;
}

	$this->set(compact('gid'));
	$quater=[$ert];
	
	
	
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$id,'Students.acedmicyear' =>$acedemic])->first();
	$this->set(compact('students'));
	
if(empty($students)){
		$students = $this->DropOutStudent->find('all')->contain(['Classes','Sections'])->where(['DropOutStudent.s_id' =>$id,'DropOutStudent.acedmicyear' =>$acedemic,'DropOutStudent.status'=>'Y'])->first();
		
	
	$this->set(compact('students'));
		
	}

	$student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id,'Studentfees.acedmicyear' =>$acedemic,'Studentfees.id' => $idf])->first();

		$this->set('studentfees',$student_datas);
		



}
	 public function printsadmissionhistory($idf=null,$acedemic=null){

	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
		$ert=base64_decode ($quater);	
$student_datas = $this->Studentfees->find('all')->where(['Studentfees.id' => $idf,'Studentfees.acedmicyear' =>$acedemic])->first();

$id=$student_datas['student_id'];


if($_GET['gid']){
	$gid=1;
	
}else{
	
	$gid=2;
}
$this->set(compact('gid'));
//~ $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

//~ $acedemic=$users['academic_year'];
	$quater=[$ert];
	
	
	$students = $this->Studentshistory->find('all')->contain(['Classes','Sections'])->where(['Studentshistory.stud_id' =>$id,'Studentshistory.acedmicyear' =>$acedemic,'Studentshistory.status'=>'Y'])->first();
	$this->set(compact('students'));
	
	
	if(empty($students)){
		$students = $this->DropOutStudent->find('all')->contain(['Classes','Sections'])->where(['DropOutStudent.s_id' =>$id,'DropOutStudent.acedmicyear' =>$acedemic,'DropOutStudent.status'=>'Y'])->first();
		
	
	$this->set(compact('students'));
		
	}


	$student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id,'Studentfees.acedmicyear' =>$acedemic,'Studentfees.id' => $idf])->first();

		$this->set('studentfees',$student_datas);
		



}
	 public function prints($id = null,$quater = null,$idf=null,$acedemic=null){

	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	$stdnt= $this->Students->get($id);
		   $discount_fees=$stdnt->dis_fees;
		   if(!empty($discount_fees))
		   {
		//$this->set('discount_fees', $discount_fees);
	}
	else
	{
		$discount_fees='0';
	//$this->set('discount_fees',$discount_fees);	
	}
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$id,'Students.acedmicyear' =>$acedemic,'Students.status'=>'Y'])->first()->toarray();
	$this->set(compact('students'));
	
	
	$fid=['1','2'];
$feeheads = $this->Feesheads->find('all')->where(['Feesheads.type IN' => $fid])->toarray();
	$this->set('feeheads',$feeheads);
	

$quater=$quater;	
	

	$student_datasj = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id,'Studentfees.acedmicyear' => $acedemic])->first();
	
	$student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id,'Studentfees.acedmicyear' => $acedemic,'Studentfees.created' =>$student_datasj['created']])->toarray();

		$this->set('studentfees',$student_datas);
		



}

 public function printsquater($id = null,$quater = null,$acedemic=null){

	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	$stdnt= $this->Students->get($id);
		   $discount_fees=$stdnt->dis_fees;
		   if(!empty($discount_fees))
		   {
		//$this->set('discount_fees', $discount_fees);
	}
	else
	{
		$discount_fees='0';
	//$this->set('discount_fees',$discount_fees);	
	}
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$id,'Students.acedmicyear' =>$acedemic,'Students.status'=>'Y'])->first()->toarray();
	$this->set(compact('students'));
	
	
	$fid=['1','2'];
$feeheads = $this->Feesheads->find('all')->where(['Feesheads.type IN' => $fid])->toarray();
	$this->set('feeheads',$feeheads);
	
	if($quater=="Quater1"){
$quater=["Miscellaneous Fee","Quater1","Quater2","Quater3","Quater4"];
}else if($quater=="Quater2"){
$quater=["Quater2","Quater3","Quater4"];
}else if($quater=="Quater3"){
$quater=["Quater3","Quater4"];
}else if($quater=="Quater4"){
$quater=["Quater4"];
}else if($quater=="Miscellaneous Fee"){
$quater=["Quater1","Miscellaneous Fee"];
}else{
$quater=$quater;	
	
}



	$student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id,'Studentfees.acedmicyear' => $acedemic])->toarray();
	//pr($student_datas); die;
		$this->set('studentfees',$student_datas);
		



}

	 public function dueprints($id = null){

	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	$stdnt=$this->Previousduefees->find('all')->where(['Previousduefees.student_id' =>$id])->contain(['Students','Banks'])->first();	  
	//pr($stdnt); die;
	$this->set('stdnt',$stdnt);
		



}


	 public function printstransport($id = null,$quater = null,$acedemic=null){

	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	$stdnt= $this->Students->get($id);
		   $discount_fees=$stdnt->dis_fees;
		   $transportloc=$stdnt->transportloc_id;
		   if(!empty($discount_fees))
		   {
	//	$this->set('discount_fees', $discount_fees);
	}
	else
	{
		$discount_fees='0';
//	$this->set('discount_fees',$discount_fees);	
	}
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$id,'Students.acedmicyear' =>$acedemic,'Students.status'=>'Y'])->first()->toarray();
	$this->set(compact('students'));
$feeheads = $this->Transportfees->find('all')->where(['Transportfees.loc_id' => $transportloc,'Transportfees.academic_year' => 
$acedemic])->toarray();
	$this->set('feeheads',$feeheads);

	$student_datas = $this->StudentTransfees->find('all')->where(['StudentTransfees.quarter' => $quater,'StudentTransfees.student_id' => $id,'StudentTransfees.acedmicyear' => $acedemic])->first()->toarray();
	
		$this->set('studentfees',$student_datas);
		



}
	
	
	public function printsreportcard(){

	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	
}
	
		public function printsreportcardvatika(){

	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	
}
	
	 public function printshostal(){

	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	//$stdnt= $this->Students->get($id);
		  // $discount_fees=$stdnt->dis_fees;
		
		  // if(!empty($discount_fees))
		  // {
		//$this->set('discount_fees', $discount_fees);
//	}
//	else
	//{
		//$discount_fees='0';
	//$this->set('discount_fees',$discount_fees);	
	//}
	//$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$id,'Students.acedmicyear' =>$acedemic])->first()->toarray();
	//$this->set(compact('students'));


	//$student_datas = $this->StudentHostalfees->find('all')->where(['StudentHostalfees.student_id' => $id,'StudentHostalfees.acedmicyear' => $acedemic])->first()->toarray();
	
	//	$this->set('studentfees',$student_datas);
		



}
	
	
	
	public function savedata(){
		
	 	 if($this->request->is('post') || $this->request->is('put'))
   {


       $clidd=sizeof($this->request->data['id']);
     	 $user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$acedemic=$user['academic_year'];  
       
   	for($i=0;$i<$clidd;$i++){
		
		 
	 $conns = ConnectionManager::get('default'); 
if($this->request->data['class_id'][$i] !='' && $this->request->data['section_id'][$i] !='' && $this->request->data['sms_mobile'][$i] !=''){
	
	if($this->request->data['h_id'][$i]==''){
		$this->request->data['h_id'][$i]='0';
		
	}
	$rty=explode(" ",$this->request->data['name'][$i]);
	if($rty[2] && $rty[3]){
	$rty[2]=$rty[2]." ".$rty[3];
		
	}
$conns->execute("UPDATE `students` SET `fname`='".$rty[0]."',`middlename`='".$rty[1]."',`lname`='".$rty[2]."',`fathername`='".$this->request->data['fathername'][$i]."',`mothername`='".$this->request->data['mothername'][$i]."',`sms_mobile`='".$this->request->data['sms_mobile'][$i]."',`class_id`='".$this->request->data['class_id'][$i]."',`section_id`='".$this->request->data['section_id'][$i]."',`h_id`='".$this->request->data['h_id'][$i]."',`house_id`='".$this->request->data['h_id'][$i]."' WHERE `id`='".$this->request->data['id'][$i]."'");


$students = $this->Students->find('all')->where(['Students.id'=>$this->request->data['id'][$i],'Students.acedmicyear'=>$acedemic])->first();
if($this->request->data['section_id'][$i]!=$students['section_id'] && $this->request->data['class_id'][$i]==$students['class_id']){
				
				$conn = ConnectionManager::get('default');
		$detail='UPDATE `studentexamresult` SET `sect_id`="'.$this->request->data['section_id'][$i].'" WHERE `stud_id`="'.$students['id'].'"';

						$results = $conn->execute($detail);
				
			}
		}
		
	}
	
	
	 $this->Flash->success(__('Student Information has been Updated successfully.'));
                
                   return $this->redirect(['action'=>'view']);
   
   }
		
	}
	
	
	public function searchstudentfees(){
		
		
		
	  $conn = ConnectionManager::get('default');
$enroll=$this->request->data['enroll'];
$fname=explode(' ',$this->request->data['name']); 
$fathername=$this->request->data['fathername']; 
$mothername=$this->request->data['mothername']; 

$detail="SELECT Students.id,Students.enroll,Students.sms_mobile,Students.discountcategory,Students.fathername,Students.mothername,Students.category,Students.h_id,Students.fname,Students.middlename,Students.lname,Students.mobile,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id    WHERE  1=1 ";

 $cond = ' ';

 

if(!empty($enroll))
{
 
    $cond.=" AND Students.enroll ='".$enroll."'";
        

}
$rolepresent=$this->request->session()->read('Auth.User.role_id');
		if($rolepresent=='5'){ 
	  $cond.=" AND Students.board_id LIKE '1'";
	
}else if($rolepresent=='8'){ 
	

		  $cond.=" AND Students.board_id IN (2,3)";
	
}
if(!empty($mothername))
{
 
    $cond.=" AND UPPER(Students.mothername) LIKE '".strtoupper($mothername)."%' ";
        

}

if(!empty($fathername))
{
 
    $cond.=" AND UPPER(Students.fathername) LIKE '".strtoupper($fathername)."%' ";
        

}

if(!empty($fname[0]))
		{
		
			$cond.=" AND  UPPER(Students.fname)  LIKE  '".strtoupper($fname[0])."%'";
			
		}
		
		if(!empty($fname[1]))
		{
		
			$cond.=" AND   UPPER(Students.middlename)  LIKE  '".strtoupper($fname[1])."%'";
			
		}


 $detail = $detail.$cond;
   $SQL = $detail." ORDER BY Classes.sort ASC,Sections.id ASC,Students.fname ASC";  

$studente = $conn->execute( $SQL )->fetchAll('assoc');






if(empty($studente)){

	
	
$detail2="SELECT DropOutStudent.s_id,DropOutStudent.enroll,DropOutStudent.sms_mobile,DropOutStudent.discountcategory,DropOutStudent.fathername,DropOutStudent.mothername,DropOutStudent.category,DropOutStudent.h_id,DropOutStudent.fname,DropOutStudent.middlename,DropOutStudent.lname,DropOutStudent.mobile,DropOutStudent.acedmicyear,DropOutStudent.class_id,DropOutStudent.section_id,DropOutStudent.admissionyear,DropOutStudent.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `drop_out_students` DropOutStudent LEFT JOIN classes Classes ON DropOutStudent.`class_id` = Classes.id LEFT JOIN sections Sections ON DropOutStudent.`section_id` = Sections.id    WHERE  1=1 ";

 $cond = ' ';

 

if(!empty($enroll))
{
 
    $cond.=" AND DropOutStudent.enroll ='".$enroll."'";
        

}
$rolepresent=$this->request->session()->read('Auth.User.role_id');
		if($rolepresent=='5'){ 
	  $cond.=" AND DropOutStudent.board_id LIKE '1'";
	
}else if($rolepresent=='8'){ 
	

		  $cond.=" AND DropOutStudent.board_id IN (2,3)";
	
}
if(!empty($mothername))
{
 
    $cond.=" AND UPPER(DropOutStudent.mothername) LIKE '".strtoupper($mothername)."%' ";
        

}

if(!empty($fathername))
{
 
    $cond.=" AND UPPER(DropOutStudent.fathername) LIKE '".strtoupper($fathername)."%' ";
        

}

if(!empty($fname[0]))
		{
		
			$cond.=" AND  UPPER(DropOutStudent.fname)  LIKE  '".strtoupper($fname[0])."%'";
			
		}
		
		if(!empty($fname[1]))
		{
		
			$cond.=" AND   UPPER(DropOutStudent.middlename)  LIKE  '".strtoupper($fname[1])."%'";
			
		}


 $detail2 = $detail2.$cond;
   $SQL = $detail2." ORDER BY Classes.sort ASC,Sections.id ASC,DropOutStudent.fname ASC";  

$studente = $conn->execute( $SQL )->fetchAll('assoc');

	
	$studente[0]['id']=$studente[0]['s_id'];
	
	
	
	
		
	}

$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

$acedemic=$users['academic_year'];

$student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$studente[0]['id'],'Studentfees.status' =>'Y','Studentfees.deposite_amt !='=>'0','Studentfees.recipetno !='=>'0'])->order(['Studentfees.recipetno' => 'ASC'])->group('Studentfees.acedmicyear')->toarray();
$i=0;
$stu_his=$this->Studentshistory->find('all')->where(['stud_id'=>$studente[0]['id']])->toarray();
$i=0;
foreach($student_datask as $stu){
	if($stu['acedmicyear']==$studente[0]['acedmicyear'])
	{
$student_datask[$i]['class']=$this->classsection($studente[0]['class_id'],$studente[0]['section_id']);

	}
	else if(!empty($stu_his)){
		foreach($stu_his as $val){
		
		if($val['acedmicyear']==$stu['acedmicyear'])
		{
			
			$student_datask[$i]['class']=$this->classsection($val['class_id'],$val['section_id']);
		
		}
		}
	}

$i++;
}

	$this->set('studentfeesk',$student_datask);
	$this->set('acedemic',$acedemic);
		
	
}
public function classsection($class=null,$section=null)
{
	
$class_det=$this->Classes->find()->select('title')->where(['id'=>$class])->first();

$sec_det=$this->Sections->find()->select('title')->where(['id'=>$section])->first();
$det=$class_det->title."-".$sec_det->title;

return $det;
}
// search functionality
public function search(){ 
	
		//show all data in listing page
//connection


	
$rolepresent=$this->request->session()->read('Auth.User.role_id');


if($rolepresent=='1'){ 
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='5'){ 
	
	
		$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id <=' =>'22'])->order(['Classections.id' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='8'){ 
	
	
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id >=' =>'23'])->order(['Classections.id' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}
	
	
	
	$sectionslist = $this->Sections->find('list', [
    'keyField' => 'id',
    'valueField' => 'title'
])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist',$sectionslist);
		
	$houses = $this->Houses->find('list', [
			'keyField' => 'id',
			'valueField' => 'name'
			])->where(['status' => '1'])->order(['name' => 'ASC'])->toArray();
		$this->set('houses', $houses);




  $conn = ConnectionManager::get('default');
	 $user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$year=$user['academic_year'];

$class=$this->request->data['class_id'];
$acedmicyear=$this->request->data['acedmicyear'];
$section=$this->request->data['section_id']; 
$enroll=$this->request->data['enroll'];
$fname=explode(' ',$this->request->data['name']); 
$fathername=$this->request->data['fathername']; 
$mothername=$this->request->data['mothername']; 

$detail="SELECT Students.id,Students.enroll,Students.sms_mobile,Students.discountcategory,Students.fathername,Students.mothername,Students.category,Students.h_id,Students.fname,Students.middlename,Students.lname,Students.mobile,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id    WHERE  1=1 ";

 $cond = ' ';
if(!empty($year))
{
 
$cond.=" AND Students.acedmicyear LIKE '".$acedmicyear."'";

}
 
 
if(!empty($class))
{
 
    $cond.=" AND Students.class_id LIKE '".$class."'";
        

}




  
if(!empty($section))
{
 
    $cond.=" AND Students.section_id LIKE '".$section."'";
        

}
  
if(!empty($enroll))
{
 
    $cond.=" AND Students.enroll LIKE '".$enroll."'";
        

}
$rolepresent=$this->request->session()->read('Auth.User.role_id');
		if($rolepresent=='5'){ 
	  $cond.=" AND Students.board_id LIKE '1'";
	
}else if($rolepresent=='8'){ 
	

		  $cond.=" AND Students.board_id IN (2,3)";
	
}
if(!empty($mothername))
{
 
    $cond.=" AND UPPER(Students.mothername) LIKE '".strtoupper($mothername)."%' ";
        

}

if(!empty($fathername))
{
 
    $cond.=" AND UPPER(Students.fathername) LIKE '".strtoupper($fathername)."%' ";
        

}

if(!empty($fname[0]))
		{
		
			$cond.=" AND  UPPER(Students.fname)  LIKE  '".strtoupper($fname[0])."%'";
			
		}
		
		if(!empty($fname[1]))
		{
		
			$cond.=" AND   UPPER(Students.middlename)  LIKE  '".strtoupper($fname[1])."%'";
			
		}

  $cond.=" AND Students.status='Y'";
 $detail = $detail.$cond;
   $SQL = $detail." ORDER BY Classes.sort ASC,Sections.id ASC,Students.fname ASC";  

$results = $conn->execute( $SQL )->fetchAll('assoc');

	$this->set('students', $results);

	}
	
	
	
	
	
public function searchfeeack(){ 
	
		//show all data in listing page
//connection
  $conn = ConnectionManager::get('default');
	 $user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$year=$user['academic_year'];

$class=$this->request->data['class_id'];
$admission=$this->request->data['admissionyear'];
$section=$this->request->data['section_id']; 
$enroll=$this->request->data['enroll'];
$fname=$this->request->data['fname']; 

$detail="SELECT Students.id,Students.enroll,Students.fathername,Students.h_id,Students.fname,Students.middlename,Students.lname,Students.mobile,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id    WHERE  1=1 ";

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
 
    $cond.=" AND Students.section_id LIKE '".$section."' ";
        

}
  
if(!empty($enroll))
{
 
    $cond.=" AND Students.enroll LIKE '".$enroll."%' ";
        

}
$rolepresent=$this->request->session()->read('Auth.User.role_id');
		if($rolepresent=='5'){ 
	  $cond.=" AND Students.board_id LIKE '1'";
	
}else if($rolepresent=='8'){ 
	

		  $cond.=" AND Students.board_id IN (2,3)";
	
}
if(!empty($fname))
{
 
    $cond.=" AND UPPER(Students.fname) LIKE '".strtoupper($fname)."%' ";
        

}
 $cond.=" AND Students.status='Y'";
 $detail = $detail.$cond;
   $SQL = $detail." ORDER BY Students.id ASC";  

$results = $conn->execute( $SQL )->fetchAll('assoc');

	$this->set('students', $results);

	}
	
	public function edit($id=null){
			$this->viewBuilder()->layout('admin');
		
			$subjectclasses_data = $this->Subjectclass->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->order(['Classes.id' => 'ASC'])->toarray();
		//$this->paginate($service_data);
		$this->set('classlist',$subjectclasses_data);
		$subjectclasses_data = $this->Classfee->find('all')->where(['id' =>$id])->first()->toarray();
			$classid=$subjectclasses_data['class_id']; 
			$academic_year=$subjectclasses_data['academic_year']; 
		//$this->paginate($service_data);
	$alldata = $this->Classfee->find('all')->contain(['Feesheads'])->where(['class_id' =>$classid,'academic_year' =>$academic_year])->toarray();
			
	$this->set('alldata',$alldata);
				
					$feesheads = $this->Feesheads->find('all')->order(['id' => 'ASC'])->toarray();
			$this->set('feesheads',$feesheads);
			$this->set('id',$id);
		
				if ($this->request->is(['post', 'put'])) {
			
					
				
  $conn = ConnectionManager::get('default');
  $academic_year=$this->request->data['academic_year'];

$conn->execute("DELETE FROM class_fee_allocations WHERE academic_year='".$academic_year."' AND class_id='".$this->request->data['class_id']."'");

				
 $peopleTable = TableRegistry::get ('Classfee');
$oQuery = $peopleTable->query ();
$romm=sizeof($this->request->data['qu1_fees']);

				for($i=0;$i<$romm;$i++)
				{
    $oQuery->insert (['class_id','academic_year','fee_h_id','qu1_fees','qu2_fees','qu3_fees','qu4_fees','status'])
        ->values ([
        'class_id' => $this->request->data['class_id'],'academic_year' => $this->request->data['academic_year'],'fee_h_id'=>$this->request->data['fee_h_id'][$i],'qu1_fees'=>$this->request->data['qu1_fees'][$i],'qu2_fees'=>$this->request->data['qu2_fees'][$i],'qu3_fees'=>$this->request->data['qu3_fees'][$i],'qu4_fees'=>$this->request->data['qu4_fees'][$i],'status'=>'Y']); 
        
        
        
        
 
}

     $d=$oQuery->execute ();
					if ($d) {
					$this->Flash->success(__('Class Fee  has been updated Sucessfully.'));
					return $this->redirect(['action' => 'index']);	
				  }else{
				
	$this->Flash->success(__('Class Fee  not updated.'));
					return $this->redirect(['action' => 'index']);	
				}
				}
		
		
		}
		
		public function finelate(){
			
			
			$invoicedate=$this->request->data['pos'];
			$role_id= $this->request->session()->read('Auth.User.role_id');
			
		$userfind=$this->Users->find('all')->where(['role_id'=>$role_id])->first();
		
		
		$latess=$userfind['latefee'];
			//$invoicedate = strtotime("2018/04/10");
       $TodayDate = strtotime('today');
if($TodayDate>$invoicedate && $invoicedate!='0'){
       $timeDiff = abs($TodayDate - $invoicedate);

       $numberDays = $timeDiff/86400;  // 86400 seconds in one day

       $numberDays = intval($numberDays);

        
      $Interval = $numberDays;
$Fees=0;
              for($i=1;$i<=$Interval;$i++){
   $late = $latess;
             $Fees+= $late;
               }
        
       $Fees = number_format($Fees, 2, '.', '');
   echo $Fees; die;
    //echo "0"; die;
}else{
	
	echo "0"; die;
	
}
			
		}
		
		
		
			public function finddiscount(){
				
			  $ffheads=$this->request->data['ffheads'];
			  $amount=$this->request->data['amty'];
			  
			 
			$sevalue=$this->request->data['sevalue'];
		
		$classes_data = $this->DiscountCategory->find('all')->where(['id' =>$sevalue])->order(['id' => 'ASC'])->first();
		$quas= unserialize($classes_data['fh_id']);
		$discounts='0';
	if($classes_data['discount']=='0'){
	
		
	
		foreach($quas as $j=>$t){
					
				if($j==$ffheads){
				   $discounts +=$amount/100*$t;
      
					
				}
				
				}
				}else if($classes_data['fh_id']!='0' && $classes_data['discount']!='0'){
				
				foreach($quas as $j=>$t){
					
				if($j==$ffheads){
				   $discounts +=$amount/100*$t;
      
					
				}
				
				}
				
				$quasdiscount= unserialize($classes_data['discount']);
				
				foreach($quasdiscount as $j=>$td){
					
				if($j==$ffheads){
				   $discounts +=$td;
      
					
				}
				
				}
				
				
				}else{
				
				$quasdiscount= unserialize($classes_data['discount']);
				
				foreach($quasdiscount as $j=>$td){
					
				if($j==$ffheads){
				   $discounts +=$td;
      
					
				}
				
				}
				
				
				
				}
			echo floor($discounts); die;

		}
		
			


				
			
		public function findotherfees(){
			
			
			$opt=$this->request->data['opt'];
			$boardst=$this->request->data['boardst'];
			$feesheads = $this->Feesheads->find('all')->where(['id' => $opt])->order(['id' => 'ASC'])->first();
		if($boardst=='1'){
			
			$fee=$feesheads['cbse_fee'];
			
		}else if($boardst=='2'){
			
			$fee=$feesheads['cambridge_fee'];
		}else if($boardst=='3'){
			$fee=$feesheads['ibdp_fee'];
			
			
		}
		
			

if($fee){
      
       $Fees = number_format($fee, 2, '.', '');
       echo $Fees; die;
}else{
	
	echo "0"; die;
	
}
			
		}
		public function cancelledstudent(){
			
				if ($this->request->is(['post', 'put'])) {	
			$id=$this->request->data['id'];
			$acedmicyear=$this->request->data['academicyear'];
			$remarsks=$this->request->data['remarks'];
			if($id!=''){
	
		$studentfeepending = $this->Studentfees->find('all')->where(['Studentfees.id'=>$id,'Studentfees.acedmicyear'=>$acedmicyear])->first();
	$recipetnoss=$studentfeepending['recipetno'];
	$studid=$studentfeepending['student_id'];
	$quarter=$studentfeepending['quarter'];


	$aee=unserialize($quarter);
	

	foreach($aee as $kru=>$amtr){  
		
	 $kru=str_replace('"', "", $kru);

 if(ctype_digit($kru)=='1'){

	
$studentfeependings= $this->Studentfeepending->find('all')->where(['r_id'=>$kru,'amt LIKE'=>$amtr."%"])->first();
$srid=$studentfeependings['id'];


	if($srid){
		 $conn = ConnectionManager::get('default');
 
  
 $conn->execute("UPDATE `studentfee_pending` SET `status`='N'  WHERE id='".$srid."' AND amt LIKE '".$amtr."%' AND s_id='".$studid."' AND r_id='".$kru."'");

}

	}
	}
	

	 
	$conn = ConnectionManager::get('default');
$conn->execute("DELETE FROM `studentfee_pending` WHERE r_id='".$id."'");

$stcau=$this->Studentfees->find('all')->where(['Studentfees.quarter'=>'a:1:{s:13:"Caution Money";s:1:"0";}','Studentfees.deposite_amt'=>'0','Studentfees.status'=>'Y'])->first();


if($stcau['id']){
$stii=$stcau['student_id'];
$conn = ConnectionManager::get('default');
 $conn->execute("UPDATE `student_feeallocations` SET `status`='N', `remarks`='".$remarsks."'  WHERE id='".$stcau['id']."' AND  acedmicyear='".$acedmicyear."' AND recipetno='".$recipetnoss."' AND student_id='".$stii."'");
 
 
}

	 $conn = ConnectionManager::get('default');
 $conn->execute("UPDATE `student_feeallocations` SET `status`='N', `remarks`='".$remarsks."'  WHERE id='".$id."' AND  acedmicyear='".$acedmicyear."' AND student_id='".$studid."'");

	$this->Flash->success(__('Student Fee Cancelled Sucessfully!!'));
					return $this->redirect(['action' => 'index/'.$studid.'/'.$acedmicyear.'/?id=personal']);	
					
	

}
		}
			
		}
	public function add($id=null,$acedmicyear=null){ 
	
		$this->viewBuilder()->layout('admin');
		

		

			
		if ($this->request->is(['post', 'put'])) {
			$student_id=$this->request->data['student_id'];
			$acedmicyear=$this->request->data['acedmicyear'];
			$userTable2 = TableRegistry::get('Studentfees');
			$exists2 = $userTable2->exists(['token'=>$this->request->data['token'],'student_id'=>$this->request->data['student_id']]);
				if($exists2){
			     $this->redirect(['controller'=>'Studentfees','action'=>'index/'.$student_id.'/'.$acedmicyear]);		
				}
				else{

	$rolepresent=$this->request->session()->read('Auth.User.role_id');
		 if($rolepresent=='5'){ 
			 
			 
		
		$student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	
		  	
		  	$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
		  		
		  $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' =>'1'])->first();
		  
		  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' =>'1','Enquires.class_id <='=>'22'])->contain(['Enquires'])->first();
		  	  
		  	//  $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']);
		  	    $c = $student_datasmaxss['amount'];
}else if($rolepresent=='8'){ 
	
	$boardzs=['2','3'];

			$student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		
			
		  	$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id IN' =>$boardzs,'Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
		
			$student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs])->first();
			
					  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id IN' =>$boardzs,'Enquires.class_id >='=>'23'])->contain(['Enquires'])->first();
		  //	  $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']);
		    $c = $student_datasmaxss['amount'];
	
}
if($this->request->data['recipetno'] !='0'){
$this->request->data['recipetno']=$c+1;

}

if($this->request->data['fee']){
$this->request->data['fee']=$this->request->data['fee'];
	
}


 $peopleTable = TableRegistry::get ('Studentfees');
$oQuery = $peopleTable->query ();
$romm=sizeof($this->request->data['quater']);
if($this->request->data['cheque_no']==""){
	$this->request->data['cheque_no']='0';
	
	}
	
	if($this->request->data['ref_no']==""){
	$this->request->data['ref_no']='0';
	
	}
	if($this->request->data['bank_id']==""){
	$this->request->data['bank_id']='';
	
	}
	if($this->request->data['addtionaldiscount']==""){
	$this->request->data['addtionaldiscount']='';
	
	}
	if($this->request->data['deposite_amt']==""){
	$this->request->data['deposite_amt']='';
	
	}
	if($this->request->data['lfine']==""){
	$this->request->data['lfine']='0.00';
	
	}
	
	
			$student_data = 
			$this->Students->find('all')->where(['Students.id'=>$this->request->data['student_id'],'Students.status'=>'Y'])->first();
	$this->request->data['payer']=$student_data['fee_submittedby'];
	

	
$arr=array();
$arr2=array();
$arr3=array();
	//pr($this->request->data);die;
	$deop=0;
	 $studid=$this->request->data['student_id'];
	 
	 		$studentsdare= 
	 		$this->Students->find('all')->where(['Students.id'=>$studid,'Students.status'=>'Y'])->first();
	 		
	 $acedmicyear=$this->request->data['acedmicyear'];







	foreach($this->request->data['quater'] as $k=>$try){
		if($try !=''){
			
		
			
		foreach($this->request->data['amount'] as $ks=>$trys){	
			if($k==$ks){
				
				$sss=ctype_digit($try);
				
		
			if($try=="Caution Money"){
				
					
			if($trys!='' && $try!=''){
				
						$arr2[$try]=round($trys);
						
						}
		$amat=round($trys);
		
	}else if($sss=='1'){
				
					
				$studentfeepending = $this->Feesheads->find('all')->where(['Feesheads.id'=>$try])->first();
	$name=$studentfeepending['name'];
			$student_data = $this->Students->find('all')->where(['Students.id' 
			=>$this->request->data['student_id'],'Students.status'=>'Y'])->first();
$board_id=$student_data['board_id'];
				if($trys!=''  && $name!=''){
					if($trys==''){
						$this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
					return $this->redirect(['action' => 'index/'.$studid.'/'.$acedmicyear.'/?id=personal']);	
						
					}else{
					
						$arr[$name]=round($trys);
					}	
						}
		
		if($board_id=='1'){
			
		$feeg=$studentfeepending['cbse_fee'];
		}else if($board_id=='2'){
			
			$feeg=$studentfeepending['cambridge_fee'];
		}else if($board_id=='3'){
			$feeg=$studentfeepending['ibdp_fee'];
			
			
		}

		
	}else{
		
		
	if($trys!='' && $try!=''){
		
		if($studentsdare['class_id']=='26' || $studentsdare['class_id']=='27'){
		
			if($try=="Development Fee" || $try=="Miscellaneous Fee"){
				
						$arr[$try]=round($trys);	
		}else if($trys==''){
			$this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
					return $this->redirect(['action' => 'index/'.$studid.'/'.$acedmicyear.'/?id=personal']);		
			
			
		}else{
		$arr[$try]=round($trys);	
			
		}
				
			
		}else if($trys==''){
			$this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
					return $this->redirect(['action' => 'index/'.$studid.'/'.$acedmicyear.'/?id=personal']);		
			
			
		}else{
		$arr[$try]=round($trys);	
			
		}
		
		}
		
	}
	}
		
		
	}
	
	
}
	}

	 $studid=$this->request->data['student_id'];

	foreach($this->request->data['pendid'] as $kk=>$tryk){
		
		foreach($this->request->data['amounts'] as $ksk=>$trysk){	
			if($kk==$ksk){

$tryk='"'.$this->request->data['refrencepending'][$ksk].'"';
$arr[$tryk]=round($trysk);

 $conn = ConnectionManager::get('default');
 

 $conn->execute("UPDATE `studentfee_pending` SET `status`='Y'  WHERE id='".$this->request->data['pendid'][$kk]."' AND amt='".$this->request->data['amounts'][$ksk]."' AND s_id='".$studid."'");
//$conn->execute("DELETE FROM studentfee_pending WHERE id='".$this->request->data['pendid'][$kk]."' AND amt='".$this->request->data['amounts'][$ksk]."' AND s_id='".$studid."'");



 $d=$oQuery->execute();
}
}

}



if($this->request->data['formno']==''){
			$this->request->data['formno']='0';
			
			}
	 $str = serialize($arr);
	 

		 
	 
		if($this->request->data['paydate']!=''){
		$this->request->session()->delete('paydatef');
					$this->request->session()->write('paydatef', date('d-m-Y',strtotime($this->request->data['paydate'])));
				if($this->request->data['recipetno']!='0'){	
					$this->request->session()->delete('reciptnof');
					$this->request->session()->write('reciptnof', $this->request->data['recipetno']);
					
					}
		
			if($deop>0){ 
				
				
				$this->request->data['fee']=$this->request->data['fee'];
				$this->request->data['deposite_amt']=round($this->request->data['deposite_amt']);
			}else{
				$this->request->data['deposite_amt']=round($this->request->data['deposite_amt']);
				$this->request->data['fee']=$this->request->data['fee'];
				
			}
			
			if($this->request->data['fee']=='0'){
			$this->request->data['fee']=round($this->request->data['deposite_amt']);
			
			}
			
			if(!empty($arr)){
			
		if($this->request->data['mode']=="CASH"){
			$this->request->data['cheque_no']='0';
			$this->request->data['ref_no']='0';
			$this->request->data['bank_id']='';
		}
		
		if($this->request->data['mode']=="CHEQUE"){
		
			$this->request->data['ref_no']='0';
			
		}
		
		if($this->request->data['mode']=="DD"){
		
			$this->request->data['ref_no']='0';
			
		}
		if($this->request->data['mode']=="NETBANKING"){
		
				$this->request->data['cheque_no']='0';
			
			$this->request->data['bank_id']='';;
			
		}
		
		if($this->request->data['mode']=="CREDIT CARD/DEBIT CARD"){
		
				$this->request->data['cheque_no']='0';
			
			$this->request->data['bank_id']='';;
			
		}
			//pr($this->request->data); die;
    $oQuery->insert (['token','student_id','paydate','quarter','mode','formno','recipetno','bank','cheque_no','addtionaldiscount','deposite_amt','fee','ref_no','discount','status','acedmicyear','discountcategory','lfine','remarks'])
        ->values (['token'=>$this->request->data['token'],
        'student_id' => $this->request->data['student_id'],'paydate' => date('Y-m-d',strtotime($this->request->data['paydate'])),'quarter'=>$str,'mode'=>$this->request->data['mode'],'formno'=>$this->request->data['formno'],'recipetno'=>$this->request->data['recipetno'],'bank'=>$this->request->data['bank_id'],'cheque_no'=>$this->request->data['cheque_no'],'addtionaldiscount'=>$this->request->data['addtionaldiscount'],'deposite_amt'=>$this->request->data['deposite_amt'],'fee'=>$this->request->data['fee'],'ref_no'=>$this->request->data['ref_no'],'discount'=>$this->request->data['discount'],'status'=>'Y','acedmicyear'=>$this->request->data['acedmicyear'],'discountcategory'=>$this->request->data['discountcategorys'],'lfine'=>$this->request->data['lfine'],'remarks'=>$this->request->data['remarks']]); 
	}
	}

     $d=$oQuery->execute ();
     
     if($this->request->data['discountcategorys']){
     $conffn = ConnectionManager::get('default');
$conffn->execute("UPDATE `students` SET `discountcategory`='".$this->request->data['discountcategorys']."' WHERE id='".$this->request->data['student_id']."'");


}


if($this->request->data['is_special']=='1'){
     $conffn = ConnectionManager::get('default');
$conffn->execute("UPDATE `students` SET `is_special`='Y' WHERE id='".$this->request->data['student_id']."'");


}
     $peopleTables = TableRegistry::get ('Studentfeepending');
$oQuerys = $peopleTables->query ();

$student_data=$this->Studentfees->find('all')->where(['Studentfees.student_id'=>$this->request->data['student_id']])->order(['id' => 'DESC'])->first();



	$rid=$student_data['id'];
	
	$rquarterid=$student_data['quarter'];
$recipetno=$student_data['recipetno'];
if($this->request->data['lfine']!='0.00'){
		$amount=$this->request->data['fee']+$this->request->data['lfine'];
				}else{
					
				$amount=$this->request->data['fee'];	
				}	
							$addtionaldiscount=$this->request->data['addtionaldiscount'];
						if($addtionaldiscount>0){
						
							$remain=$amount-$addtionaldiscount;
						
						
						}else{
			
						
							$remain=$amount;
							
						
						
					} 
					
					//~ if($remain>$this->request->data['deposite_amt']){
						
				//~ $netamounts=$remain-$this->request->data['deposite_amt'];
			
					
				//~ }else 
				
				if($this->request->data['dueextra']<0){
				$netamounts=$this->request->data['dueextra'];
				
				}else if($this->request->data['dueextra']>0){
				$netamounts=$this->request->data['dueextra'];
				
				}else{
					$netamounts='0';
					
				}
					
		if($netamounts!='0'){
			
    $oQuerys->insert (['s_id','r_id','recipetnos','amt','status'])
        ->values ([
        's_id' => $this->request->data['student_id'],'r_id' => $rid,'recipetnos' => $recipetno,'amt'=>$netamounts,'status'=>'N']); 
        
	}

     $oQuerys->execute ();
     
       $peopleTableshh = TableRegistry::get ('Studentfees');
$oQueryshh = $peopleTableshh->query ();



if(!empty($arr2)){
		$str2 = serialize($arr2); 
		
		  $oQueryshh->insert (['token','student_id','paydate','quarter','mode','formno','recipetno','bank','cheque_no','addtionaldiscount','deposite_amt','fee','ref_no','discount','status','acedmicyear','discountcategory','remarks'])
        ->values (['token'=>$this->request->data['token'],
        'student_id' => $this->request->data['student_id'],'paydate' => date('Y-m-d',strtotime($this->request->data['paydate'])),'quarter'=>$str2,'mode'=>$this->request->data['mode'],'formno'=>$this->request->data['formno'],'recipetno'=>$this->request->data['recipetno'],'bank'=>$this->request->data['bank_id'],'cheque_no'=>$this->request->data['cheque_no'],'addtionaldiscount'=>'0.00','deposite_amt'=>$amat,'fee'=>$amat,'ref_no'=>$this->request->data['ref_no'],'discount'=>'0.00','status'=>'Y','acedmicyear'=>$this->request->data['acedmicyear'],'discountcategory'=>$this->request->data['discountcategorys'],'remarks'=>$this->request->data['remarks']]); 
        
	}
$oQueryshh->execute ();
$caution='a:1:{s:13:"Caution Money";d:5000;}';


$student_datacautionmoney=$this->Studentfees->find('all')->where(['Studentfees.quarter LIKE'=>$caution,'Studentfees.student_id'=>$this->request->data['student_id']])->order(['id' => 'DESC'])->first();

$student_datass=$this->Studentfees->find('all')->where(['Studentfees.student_id'=>$this->request->data['student_id']])->order(['id' => 'DESC'])->first();



	$rids=$student_datass['id'];
	$rquarterids=$student_datass['quarter'];
	//$ridcaution=$student_datacautionmoney['id'];
			$studid=$this->request->data['student_id'];
			$acedmicyear=$this->request->data['acedmicyear'];
			
			if($this->request->data['studenthistory']){
				
				
			$studenthistory=$this->request->data['studenthistory'];
			
		}
				// save all data in database

				if ($d) {
					
					if(!empty($this->request->data['pendid'])){
			$this->rollbacks($studid,$this->request->data['recipetno'],$this->request->data['pendid'],$this->request->data['amounts'],$this->request->data['refrencepending']);
			
		}else{
			$pen=array();
			$amo=array();
			$refrt=array();
				$this->rollbacks($studid,$this->request->data['recipetno'],$pen,$amo,$refrt);
			
		}
					
				
						if($this->request->data['recipetno'] !='0'){
	$this->request->data['hdfb']='1';
					if($this->request->data['hdfb']=='1'){
						
			
			
				if($rquarterids=='a:1:{s:13:"Caution Money";d:5000;}'){
						
		
					
					$this->request->session()->delete('openfess_recipt3');
							$this->request->session()->delete('openfess_recipt4');
							$this->request->session()->delete('openfess_recipt5');
							
							if($studenthistory){
									$this->request->session()->write('openfess_recipt3', 'printscautionhistory');
							}else{
									$this->request->session()->write('openfess_recipt3', 'printscaution');
							}
						
							$this->request->session()->write('openfess_recipt4', $rids);
							$this->request->session()->write('openfess_recipt5', $acedmicyear);
						
							
			//$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
				return $this->redirect(['action' => 'view/'.$studid]);	
					}else {
					
					$this->request->session()->delete('openfess_recipt');
					
					$this->request->session()->delete('openfess_recipt2');
						$this->request->session()->delete('openfess_recipt5');
						if($studenthistory){
					$this->request->session()->write('openfess_recipt', 'printsadmissionhistory');
			}else{
				$this->request->session()->write('openfess_recipt', 'printsadmission');
				
			}
					$this->request->session()->write('openfess_recipt2', $rids);
					$this->request->session()->write('openfess_recipt5', $acedmicyear);
					
					//$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
					return $this->redirect(['action' => 'view/'.$studid]);		
					}
					
				
		
				}else{
					
				//$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
			return $this->redirect(['action' => 'view/'.$studid]);	

					
				}
				}else{
					
				//$this->Flash->success(__('Student Fee  Sucessfully!!'));
			return $this->redirect(['action' => 'index/'.$studid.'/'.$acedmicyear.'/?id=personal']);	

					
				}
				
					
					
				  }else{
				
	$this->Flash->error(__('Please Try Again For Submit Fees!!!.'));
			return $this->redirect(['action' => 'index/'.$studid.'/'.$acedmicyear.'/?id=personal']);		
				}
			
				
				
			
			
			
			
			$studid=$this->request->data['student_id'];
			$acedmicyear=$this->request->data['acedmicyear'];




					
				//$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
				return $this->redirect(['action' => 'view/'.$studid]);	
					//return $this->redirect(['action' => 'view']);
				}	
				
                }

		$this->set('classes', $classes);
	}

	public function rollbacks($stid=null,$recipet=null,$pendid=null,$amounts=null,$refrencepending=null){

	$studentfees = $this->Studentfees->find('all')->where(['Studentfees.student_id'=>$stid,'Studentfees.recipetno'=>$recipet])->first();
	
	$quarter=$studentfees['quarter'];
	$student_id=$studentfees['student_id'];
	$acedmicyear=$studentfees['acedmicyear'];
	$feesid=$studentfees['id'];
	$deposite_amt=(int)$studentfees['deposite_amt'];


	$aee=unserialize($quarter);
	
$amoutpay=0;
	foreach($aee as $kru=>$amtr){  
		
$amoutpay +=(int)$amtr;
	}

	if($studentfees['lfine']!=''){ 
		
		$total=(int)$studentfees['lfine']+(int)$amoutpay;
		
		}else{
			$total=(int)$amoutpay;
			
		}
		
		
		$studentfeependings= $this->Studentfeepending->find('all')->where(['r_id'=>$feesid,'s_id'=>$student_id])->first();
	//pr($studentfeependings); die;
	if($studentfeependings['id']){
		
		if($studentfeependings['amt']>0){
			
			
		$net=(int)$total-(int)$studentfeependings['amt'];

	}else if($studentfeependings['amt']<0){
		$studentfeependings['amt']=abs($studentfeependings['amt']);
		$net=(int)$total+(int)$studentfeependings['amt'];
		
		
	}
		
	}else{
		
		$net=(int)$total;
	}
	
	if($studentfees['discount']!='0.00' || $studentfees['discount']!='0'  ){ 
		$net=(int)$net-(int)$studentfees['discount'];
		
	}else{
		$net=(int)$net;
		
	}
	
	if($studentfees['addtionaldiscount']!='0'  ){ 
		$net=(int)$net-(int)$studentfees['addtionaldiscount'];
		
	}else{
		$net=(int)$net;
		
	}

	if($net==$deposite_amt){
		
	}else{

		if($studentfees['id']){
			$this->Studentfees->delete( $this->Studentfees->get($studentfees['id']));
		}
		
		if($studentfeependings['id']){
			
	
			$this->Studentfeepending->delete( $this->Studentfeepending->get($studentfeependings['id']));
		}
		
		if(!empty($amounts)){
		
	foreach($pendid as $kk=>$tryk){
		
		foreach($amounts as $ksk=>$trysk){	
			if($kk==$ksk){

$tryk='"'.$refrencepending[$ksk].'"';
$arr[$tryk]=round($trysk);

 $conn = ConnectionManager::get('default');
 

 $conn->execute("UPDATE `studentfee_pending` SET `status`='N'  WHERE id='".$pendid[$kk]."' AND amt='".$amounts[$ksk]."' AND s_id='".$stid."'");




}
}

}

}
		
		$this->Flash->error(__('Transection Failed , Please Try Again !!!'));
		
		return $this->redirect(['action' => 'index/'.$stid.'/'.$acedmicyear.'/?id=personal']);	
		
		
	}

		
	}
	
	public function addhistory($id=null,$acedmicyear=null){ 
	
		$this->viewBuilder()->layout('admin');
		

		if($id!=''){
	
		$studentfeepending = $this->Studentfees->find('all')->where(['Studentfees.id'=>$id,'Studentfees.acedmicyear'=>$acedmicyear])->first();
	$recipetnoss=$studentfeepending['recipetno'];
	$studid=$studentfeepending['student_id'];
	$quarter=$studentfeepending['quarter'];


	$aee=unserialize($quarter);
	

	foreach($aee as $kru=>$amtr){  
		
	 $kru=str_replace('"', "", $kru);

 if(ctype_digit($kru)=='1'){

	
$studentfeependings= $this->Studentfeepending->find('all')->where(['r_id'=>$kru,'amt LIKE'=>$amtr."%"])->first();
$srid=$studentfeependings['id'];


	if($srid){
		 $conn = ConnectionManager::get('default');
 
  
 $conn->execute("UPDATE `studentfee_pending` SET `status`='N'  WHERE id='".$srid."' AND amt LIKE '".$amtr."%' AND s_id='".$studid."' AND r_id='".$kru."'");

}

	}
	}
	

	 
	$conn = ConnectionManager::get('default');
$conn->execute("DELETE FROM `studentfee_pending` WHERE r_id='".$id."'");

$stcau=$this->Studentfees->find('all')->where(['Studentfees.quarter'=>'a:1:{s:13:"Caution Money";s:1:"0";}','Studentfees.deposite_amt'=>'0','Studentfees.status'=>'Y'])->first();


if($stcau['id']){
$stii=$stcau['student_id'];
$conn = ConnectionManager::get('default');
 $conn->execute("UPDATE `student_feeallocations` SET `status`='N'  WHERE id='".$stcau['id']."' AND  acedmicyear='".$acedmicyear."' AND recipetno='".$recipetnoss."' AND student_id='".$stii."'");
 
 
}

	 $conn = ConnectionManager::get('default');
 $conn->execute("UPDATE `student_feeallocations` SET `status`='N'  WHERE id='".$id."' AND  acedmicyear='".$acedmicyear."' AND student_id='".$studid."'");

	$this->Flash->success(__('Student Fee Cancelled Sucessfully!!'));
					return $this->redirect(['action' => 'history/'.$studid.'/'.$acedmicyear.'/?id=personal']);	
					
	

}

			
		if ($this->request->is(['post', 'put'])) {

	$rolepresent=$this->request->session()->read('Auth.User.role_id');
		 if($rolepresent=='5'){ 
			 
			
		
		$student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		
		
		$student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' =>'1','Studentfees.recipetno !='=>'0'])->order(['Studentfees.id DESC'])->first();
		  	if($student_datasmaxss['amount']<$student_datasmaxsseeer['amount']){
				$student_datasmaxss['amount']=$student_datasmaxsseeer['amount'];
				
			}
		  		
		  $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' =>'1'])->first();
		  
		  	  $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' =>'1','Enquires.class_id <='=>'22'])->contain(['Enquires'])->first();
		  	  
		  	//  $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']);
		  	    $c = $student_datasmaxss['amount'];
}else if($rolepresent=='8'){ 
	
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
if($this->request->data['recipetno'] !='0'){
$this->request->data['recipetno']=$c+1;

}

if($this->request->data['fee']){
$this->request->data['fee']=$this->request->data['fee'];
	
}


 $peopleTable = TableRegistry::get ('Studentfees');
$oQuery = $peopleTable->query ();
$romm=sizeof($this->request->data['quater']);
if($this->request->data['cheque_no']==""){
	$this->request->data['cheque_no']='0';
	
	}
	
	if($this->request->data['ref_no']==""){
	$this->request->data['ref_no']='0';
	
	}
	if($this->request->data['bank_id']==""){
	$this->request->data['bank_id']='';
	
	}
	if($this->request->data['addtionaldiscount']==""){
	$this->request->data['addtionaldiscount']='';
	
	}
	if($this->request->data['deposite_amt']==""){
	$this->request->data['deposite_amt']='';
	
	}
	if($this->request->data['lfine']==""){
	$this->request->data['lfine']='0.00';
	
	}
	
	
			$student_data =$this->Studentshistory->find('all')->where(['Studentshistory.stud_id'=>$this->request->data['student_id'],'Studentshistory.status'=>'Y'])->first();
	$this->request->data['payer']=$student_data['fee_submittedby'];
	

	
$arr=array();
$arr2=array();
$arr3=array();
	//pr($this->request->data);die;
	$deop=0;
	 $studid=$this->request->data['student_id'];
	 
	 		$studentsdare= 
	 		$this->Studentshistory->find('all')->where(['Studentshistory.stud_id'=>$studid,'Studentshistory.status'=>'Y'])->first();
	 		
	 $acedmicyear=$this->request->data['acedmicyear'];







	foreach($this->request->data['quater'] as $k=>$try){
		if($try !=''){
			
		
			
		foreach($this->request->data['amount'] as $ks=>$trys){	
			if($k==$ks){
				
				$sss=ctype_digit($try);
				
		
			if($try=="Caution Money"){
				
					
			if($trys!='' && $try!=''){
				
						$arr2[$try]=round($trys);
						
						}
		$amat=round($trys);
		
	}else if($sss=='1'){
				
					
				$studentfeepending = $this->Feesheads->find('all')->where(['Feesheads.id'=>$try])->first();
	$name=$studentfeepending['name'];
			$student_data = $this->Studentshistory->find('all')->where(['Studentshistory.stud_id' 
			=>$this->request->data['student_id'],'Studentshistory.status'=>'Y'])->first();
$board_id=$student_data['board_id'];
				if($trys!=''  && $name!=''){
					if($trys==''){
						$this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
					return $this->redirect(['action' => 'history/'.$studid.'/'.$acedmicyear.'/?id=personal']);	
						
					}else{
					
						$arr[$name]=round($trys);
					}	
						}
		
		if($board_id=='1'){
			
		$feeg=$studentfeepending['cbse_fee'];
		}else if($board_id=='2'){
			
			$feeg=$studentfeepending['cambridge_fee'];
		}else if($board_id=='3'){
			$feeg=$studentfeepending['ibdp_fee'];
			
			
		}

		
	}else{
		
		
	if($trys!='' && $try!=''){
		
		if($studentsdare['class_id']=='26' || $studentsdare['class_id']=='27'){
		
			if($try=="Development Fee" || $try=="Miscellaneous Fee"){
				
						$arr[$try]=round($trys);	
		}else if($trys==''){
			$this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
					return $this->redirect(['action' => 'history/'.$studid.'/'.$acedmicyear.'/?id=personal']);		
			
			
		}else{
		$arr[$try]=round($trys);	
			
		}
				
			
		}else if($trys==''){
			$this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
					return $this->redirect(['action' => 'history/'.$studid.'/'.$acedmicyear.'/?id=personal']);		
			
			
		}else{
		$arr[$try]=round($trys);	
			
		}
		
		}
		
	}
	}
		
		
	}
	
	
}
	}

	 $studid=$this->request->data['student_id'];

	foreach($this->request->data['pendid'] as $kk=>$tryk){
		
		foreach($this->request->data['amounts'] as $ksk=>$trysk){	
			if($kk==$ksk){

$tryk='"'.$this->request->data['refrencepending'][$ksk].'"';
$arr[$tryk]=round($trysk);

 $conn = ConnectionManager::get('default');
 

 $conn->execute("UPDATE `studentfee_pending` SET `status`='Y'  WHERE id='".$this->request->data['pendid'][$kk]."' AND amt='".$this->request->data['amounts'][$ksk]."' AND s_id='".$studid."'");




 $d=$oQuery->execute();
}
}

}



if($this->request->data['formno']==''){
			$this->request->data['formno']='0';
			
			}
	 $str = serialize($arr);
	 

		 
	 
		if($this->request->data['paydate']!=''){
		$this->request->session()->delete('paydatef');
					$this->request->session()->write('paydatef', date('d-m-Y',strtotime($this->request->data['paydate'])));
				if($this->request->data['recipetno']!='0'){	
					$this->request->session()->delete('reciptnof');
					$this->request->session()->write('reciptnof', $this->request->data['recipetno']);
					
					}
		
			if($deop>0){ 
				
				
				$this->request->data['fee']=$this->request->data['fee'];
				$this->request->data['deposite_amt']=round($this->request->data['deposite_amt']);
			}else{
				$this->request->data['deposite_amt']=round($this->request->data['deposite_amt']);
				$this->request->data['fee']=$this->request->data['fee'];
				
			}
			
			if($this->request->data['fee']=='0'){
			$this->request->data['fee']=round($this->request->data['deposite_amt']);
			
			}
			
			if(!empty($arr)){
			
		if($this->request->data['mode']=="CASH"){
			$this->request->data['cheque_no']='0';
			$this->request->data['ref_no']='0';
			$this->request->data['bank_id']='';
		}
		
		if($this->request->data['mode']=="CHEQUE"){
		
			$this->request->data['ref_no']='0';
			
		}
		
		if($this->request->data['mode']=="DD"){
		
			$this->request->data['ref_no']='0';
			
		}
		if($this->request->data['mode']=="NETBANKING"){
		
				$this->request->data['cheque_no']='0';
			
			$this->request->data['bank_id']='';;
			
		}
		
		if($this->request->data['mode']=="CREDIT CARD/DEBIT CARD"){
		
				$this->request->data['cheque_no']='0';
			
			$this->request->data['bank_id']='';;
			
		}
			//pr($this->request->data); die;
    $oQuery->insert (['student_id','paydate','quarter','mode','formno','recipetno','bank','cheque_no','addtionaldiscount','deposite_amt','fee','ref_no','discount','status','acedmicyear','discountcategory','lfine','remarks'])
        ->values ([
        'student_id' => $this->request->data['student_id'],'paydate' => date('Y-m-d',strtotime($this->request->data['paydate'])),'quarter'=>$str,'mode'=>$this->request->data['mode'],'formno'=>$this->request->data['formno'],'recipetno'=>$this->request->data['recipetno'],'bank'=>$this->request->data['bank_id'],'cheque_no'=>$this->request->data['cheque_no'],'addtionaldiscount'=>$this->request->data['addtionaldiscount'],'deposite_amt'=>$this->request->data['deposite_amt'],'fee'=>$this->request->data['fee'],'ref_no'=>$this->request->data['ref_no'],'discount'=>$this->request->data['discount'],'status'=>'Y','acedmicyear'=>$this->request->data['acedmicyear'],'discountcategory'=>$this->request->data['discountcategorys'],'lfine'=>$this->request->data['lfine'],'remarks'=>$this->request->data['remarks']]); 
	}
	}

     $d=$oQuery->execute ();
     
     if($this->request->data['discountcategorys']){
     $conffn = ConnectionManager::get('default');
$conffn->execute("UPDATE `studentshistory` SET `discountcategory`='".$this->request->data['discountcategorys']."' WHERE stud_id='".$this->request->data['student_id']."'");


}


if($this->request->data['is_special']=='1'){
     $conffn = ConnectionManager::get('default');
$conffn->execute("UPDATE `studentshistory` SET `is_special`='Y' WHERE stud_id='".$this->request->data['student_id']."'");


}
     $peopleTables = TableRegistry::get ('Studentfeepending');
$oQuerys = $peopleTables->query ();

$student_data=$this->Studentfees->find('all')->where(['Studentfees.student_id'=>$this->request->data['student_id']])->order(['id' => 'DESC'])->first();



	$rid=$student_data['id'];
	
	$rquarterid=$student_data['quarter'];
$recipetno=$student_data['recipetno'];
if($this->request->data['lfine']!='0.00'){
		$amount=$this->request->data['fee']+$this->request->data['lfine'];
				}else{
					
				$amount=$this->request->data['fee'];	
				}	
							$addtionaldiscount=$this->request->data['addtionaldiscount'];
						if($addtionaldiscount>0){
						
							$remain=$amount-$addtionaldiscount;
						
						
						}else{
			
						
							$remain=$amount;
							
						
						
					} 
					
					//~ if($remain>$this->request->data['deposite_amt']){
						
				//~ $netamounts=$remain-$this->request->data['deposite_amt'];
			
					
				//~ }else 
				
				if($this->request->data['dueextra']<0){
				$netamounts=$this->request->data['dueextra'];
				
				}else if($this->request->data['dueextra']>0){
				$netamounts=$this->request->data['dueextra'];
				
				}else{
					$netamounts='0';
					
				}
					
		if($netamounts!='0'){
			
    $oQuerys->insert (['s_id','r_id','recipetnos','amt','status'])
        ->values ([
        's_id' => $this->request->data['student_id'],'r_id' => $rid,'recipetnos' => $recipetno,'amt'=>$netamounts,'status'=>'N']); 
        
	}

     $oQuerys->execute ();
     
       $peopleTableshh = TableRegistry::get ('Studentfees');
$oQueryshh = $peopleTableshh->query ();



if(!empty($arr2)){
		$str2 = serialize($arr2); 
		
		  $oQueryshh->insert (['student_id','paydate','quarter','mode','formno','recipetno','bank','cheque_no','addtionaldiscount','deposite_amt','fee','ref_no','discount','status','acedmicyear','discountcategory','remarks'])
        ->values ([
        'student_id' => $this->request->data['student_id'],'paydate' => date('Y-m-d',strtotime($this->request->data['paydate'])),'quarter'=>$str2,'mode'=>$this->request->data['mode'],'formno'=>$this->request->data['formno'],'recipetno'=>$this->request->data['recipetno'],'bank'=>$this->request->data['bank_id'],'cheque_no'=>$this->request->data['cheque_no'],'addtionaldiscount'=>'0.00','deposite_amt'=>$amat,'fee'=>$amat,'ref_no'=>$this->request->data['ref_no'],'discount'=>'0.00','status'=>'Y','acedmicyear'=>$this->request->data['acedmicyear'],'discountcategory'=>$this->request->data['discountcategorys'],'remarks'=>$this->request->data['remarks']]); 
        
	}
$oQueryshh->execute ();
$caution='a:1:{s:13:"Caution Money";d:5000;}';


$student_datacautionmoney=$this->Studentfees->find('all')->where(['Studentfees.quarter LIKE'=>$caution,'Studentfees.student_id'=>$this->request->data['student_id']])->order(['id' => 'DESC'])->first();

$student_datass=$this->Studentfees->find('all')->where(['Studentfees.student_id'=>$this->request->data['student_id']])->order(['id' => 'DESC'])->first();



	$rids=$student_datass['id'];
	$rquarterids=$student_datass['quarter'];
	//$ridcaution=$student_datacautionmoney['id'];
			$studid=$this->request->data['student_id'];
			$acedmicyear=$this->request->data['acedmicyear'];
			
			if($this->request->data['studenthistory']){
				
				
			$studenthistory=$this->request->data['studenthistory'];
			
			 
	 $stdntcurrent = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$studid])->first();
	 if($stdntcurrent['due_fees']){
		 
$remain = $stdntcurrent['due_fees'];

$resr=$remain-$this->request->data['deposite_amt'];	
	
	
	  $conffn = ConnectionManager::get('default');
$conffn->execute("UPDATE `students` SET `due_fees`='".$resr."' WHERE id='".$this->request->data['student_id']."'");

		
	}
		}
				// save all data in database

				if ($d) {
					
					
					
				
						if($this->request->data['recipetno'] !='0'){
	
					if($this->request->data['hdfb']=='1'){
						
			
			
				if($rquarterids=='a:1:{s:13:"Caution Money";d:5000;}'){
						
		
					
					$this->request->session()->delete('openfess_recipt3');
							$this->request->session()->delete('openfess_recipt4');
							$this->request->session()->delete('openfess_recipt5');
							
							if($studenthistory){
									$this->request->session()->write('openfess_recipt3', 'printscautionhistory');
							}else{
									$this->request->session()->write('openfess_recipt3', 'printscaution');
							}
						
							$this->request->session()->write('openfess_recipt4', $rids);
							$this->request->session()->write('openfess_recipt5', $acedmicyear);
						
							
			//$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
				return $this->redirect(['action' => 'view/'.$studid]);	
					}else {
					
					$this->request->session()->delete('openfess_recipt');
					
					$this->request->session()->delete('openfess_recipt2');
						$this->request->session()->delete('openfess_recipt5');
						if($studenthistory){
					$this->request->session()->write('openfess_recipt', 'printsadmissionhistory');
			}else{
				$this->request->session()->write('openfess_recipt', 'printsadmission');
				
			}
					$this->request->session()->write('openfess_recipt2', $rids);
					$this->request->session()->write('openfess_recipt5', $acedmicyear);
					
					//$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
					return $this->redirect(['action' => 'view/'.$studid]);		
					}
					
				
		
				}else{
					
				//$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
			return $this->redirect(['action' => 'view/'.$studid]);	

					
				}
				}else{
					
				//$this->Flash->success(__('Student Fee  Sucessfully!!'));
	return $this->redirect(['action' => 'history/'.$studid.'/'.$acedmicyear.'/?id=personal']);		

					
				}
				
					
					
				  }else{
				
	$this->Flash->error(__('Please Try Again For Submit Fees!!!.'));
			return $this->redirect(['action' => 'history/'.$studid.'/'.$acedmicyear.'/?id=personal']);		
				}
			
				
				
			
			
			
			
			$studid=$this->request->data['student_id'];
			$acedmicyear=$this->request->data['acedmicyear'];




					
				//$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
				return $this->redirect(['action' => 'view/'.$studid]);	
					//return $this->redirect(['action' => 'view']);
					
				
                }

		$this->set('classes', $classes);
	}
		public function updatecautionmoney(){
		
		   $peopleTableshh = TableRegistry::get ('Studentfees');
$oQueryshh = $peopleTableshh->query ();

$caution='Admission Fee';

$student_datacautionmoney=$this->Students->find('all')->where(['Students.enroll <='=>5974,'Students.status'=>'Y','Students.category'=>'Normal','Students.board_id IN'=>['1','2']])->order(['id' => 'DESC'])->toarray();
$dr=array();

foreach($student_datacautionmoney as $k=>$ff){
	
	$student_datass=$this->Studentfees->find('all')->where(['Studentfees.student_id'=>$ff['id'],'Studentfees.status'=>'Y','Studentfees.quarter LIKE'=>'%'.$caution.'%'])->order(['id' => 'DESC'])->first();
	if($student_datass['id']){
		
		
	}else{
		
		$dr[]=$ff['id'];
	}
	
}
pr($dr); die;




if(!empty($dr)){
	  foreach($dr as $tt=>$f){
       $peopleTableshh = TableRegistry::get ('Studentfees');
$oQueryshh = $peopleTableshh->query ();
$caution='a:2:{s:13:"Admission Fee";s:5:"25000";s:15:"Development Fee";s:4:"5000";}';
		$date='2018-04-01';
		$amat='30000';
		  $oQueryshh->insert (['student_id','paydate','quarter','mode','formno','recipetno','bank','cheque_no','addtionaldiscount','deposite_amt','fee','ref_no','discount','status','acedmicyear','discountcategory','remarks'])
        ->values ([
        'student_id' =>$f,'paydate' => date('Y-m-d',strtotime($date)),'quarter'=>$caution,'mode'=>'CASH','formno'=>'0','recipetno'=>'0','bank'=>'','cheque_no'=>'','addtionaldiscount'=>'0.00','deposite_amt'=>$amat,'fee'=>$amat,'ref_no'=>'','discount'=>'0.00','status'=>'Y','acedmicyear'=>'2018-19','discountcategory'=>'','remarks'=>'Old Receipt']); 
        $oQueryshh->execute ();
   }     
	}


	}
	
	
	public function updatediscountsss(){
		



$student_datacautionmoney=$this->Students->find('all')->where(['Students.discountcategory'=>'','Students.status'=>'Y'])->order(['id' => 'DESC'])->toarray();
$dr=array();
$discountcategory=array();

foreach($student_datacautionmoney as $k=>$ff){
	
	$student_datass=$this->Studentfees->find('all')->where(['Studentfees.student_id'=>$ff['id'],'Studentfees.status'=>'Y','Studentfees.recipetno !='=>'0','Studentfees.discountcategory !='=>''])->order(['paydate' => 'DESC'])->first();
	if($student_datass['id']){
		
		$dr[]=$student_datass['student_id'];
		if($student_datass['discountcategory']){
		$discountcategory[]=$student_datass['discountcategory'];
		
	}else{
		
			
		
		$discountcategory[]='';
		
	}
}
}


echo $s; die;
$fgg=0;
if(!empty($dr)){
	
	
	$romms=sizeof($dr);
	for($i=0;$i<$romms;$i++)
	{
	
       $peopleTableshh = TableRegistry::get ('Students');
$oQueryshh = $peopleTableshh->query ();

	$oQueryshh->update()
                    ->set(['discountcategory'=>$discountcategory[$i]])
                    ->where(['id'=>$dr[$i],'status'=>'Y'])
                    ->execute();
                    
                    $fgg++;
      
	   
	}
echo $fgg; die;

	}
	
}
	
	
	public function addtransport(){
		
			$this->viewBuilder()->layout('admin');
		
		if(isset($id) && !empty($id)){
			//using for edit
		     $classes = $this->StudentTransfees->get($id);

		}else{
			//using for new entry
			$classes = $this->StudentTransfees->newEntity();
				$this->request->data['status'] = '1';
		}
		if ($this->request->is(['post', 'put'])) {
	//	pr($this->request->data); die;
 $peopleTable = TableRegistry::get ('StudentTransfees');
$oQuery = $peopleTable->query ();
$romm=sizeof($this->request->data['quater']);
if($this->request->data['cheque_no']==""){
	$this->request->data['cheque_no']='0';
	
	}
	if($this->request->data['bank_id']==""){
	$this->request->data['bank_id']='0';
	
	}
				for($i=0;$i<$romm;$i++)
				{
					if($this->request->data['paydate'][$i] != ''){
    $oQuery->insert (['student_id','paydate','quarter','amount','mode','bank_id','cheque_no','fee','challan_no','discount','status','acedmicyear'])
        ->values ([
        'student_id' => $this->request->data['student_id'],'paydate' =>date('Y-m-d',strtotime($this->request->data['paydate'][$i])),'quarter'=>$this->request->data['quater'][$i],'amount'=>$this->request->data['amount'][$i],'mode'=>$this->request->data['modes'],'bank_id'=>$this->request->data['bank_id'],'cheque_no'=>$this->request->data['cheque_no'],'fee'=>$this->request->data['fee'],'challan_no'=>$this->request->data['challan_no'],'discount'=>$this->request->data['discount'],'status'=>'Y','acedmicyear'=>$this->request->data['acedmicyear']]); 
        
        
	}
        
 
}

     $d=$oQuery->execute ();
		$studid=$this->request->data['student_id'];
				// save all data in database
					$acedmicyear=$this->request->data['acedmicyear'];
				if ($d) {
					$this->Flash->success(__('Student Transport Fee  has been saved.'));
						return $this->redirect(['action' => 'index/'.$studid.'/'.$acedmicyear.'?id=academic']);		
				  }else{
				
	$this->Flash->success(__('Student Transport Fee  not saved.'));
						return $this->redirect(['action' => 'index/'.$studid.'/?id=academic']);	
				}
			
                }

		$this->set('classes', $classes);
		
		
		}




public function addhostal(){
	
	
	
	
	$this->viewBuilder()->layout('admin');
		
		if(isset($id) && !empty($id)){
			//using for edit
		     $classes = $this->StudentHostalfees->get($id);

		}else{
			//using for new entry
			$classes = $this->StudentHostalfees->newEntity();
				$this->request->data['status'] = '1';
		}
		if ($this->request->is(['post', 'put'])) {
		$acedmicyear=$this->request->data['acedmicyear'];
		if($this->request->data['paydate']==""){
				$this->Flash->error(__('Select one of option.'));
					return $this->redirect(['action' => 'index/'.$this->request->data['student_id'].'/'.$acedmicyear.'?id=guardians']);	
			
			}else{
 $peopleTable = TableRegistry::get ('StudentHostalfees');
$oQuery = $peopleTable->query ();
$romm=sizeof($this->request->data['modes1']);
if($this->request->data['cheque_no']==""){
	$this->request->data['cheque_no']='0';
	
	}
	if($this->request->data['bank_id']==""){
	$this->request->data['bank_id']='0';
	
	}
				for($i=0;$i<$romm;$i++)
				{
    $oQuery->insert (['student_id','paydate','h_id','h_name','amount','mode','bank_id','cheque_no','fee','challan_no','discount','status','acedmicyear'])
        ->values ([
        'student_id' => $this->request->data['student_id'],'paydate' => date('Y-m-d',strtotime($this->request->data['paydate'])),'h_id'=>$this->request->data['h_id'],'h_name'=>$this->request->data['h_name'],'amount'=>$this->request->data['amount'],'mode'=>$this->request->data['modes1'],'bank_id'=>$this->request->data['bank_id'],'cheque_no'=>$this->request->data['cheque_no'],'fee'=>$this->request->data['fee'],'challan_no'=>$this->request->data['challan_no'],'discount'=>$this->request->data['discount'],'status'=>'Y','acedmicyear'=>$this->request->data['acedmicyear']]); 
        
        
        
        
 
}
$studid=$this->request->data['student_id'];
     $d=$oQuery->execute ();
				$acedmicyear=$this->request->data['acedmicyear'];
				// save all data in database
			
				if ($d) {
					$this->Flash->success(__('Student Hostal Fee  has been saved.'));
					return $this->redirect(['action' => 'index/'.$studid.'/'.$acedmicyear.'?id=guardians']);	
				  }else{
				
	$this->Flash->error(__('Student Hostal Fee  not saved.'));
					return $this->redirect(['action' => 'index/'.$studid.'/?id=guardians']);	
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
		     $classes = $this->Locations->get($id);
		
		}else{
			//using for new entry
			$classes = $this->Locations->newEntity();
		}
	
	if($this->request->is(['post', 'put'])) {
	
		//$this->request->data = $this->request->data['sort']; 
               $classes->sort = $this->request->data['sort'];

		if ($this->Locations->save($classes)) {
			echo $classes['sort'];		
		}else{  
			echo 'wrong'; 
				
		}
	}	
	die;
	}
	
	
	
	public function studentfeeack(){    
		
		$this->viewBuilder()->layout('admin');
		
	

$rolepresent=$this->request->session()->read('Auth.User.role_id');


if($rolepresent=='1'){ 
	$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='5'){ 
	
	
		$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id <=' =>'22'])->order(['Classections.id' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}else if($rolepresent=='8'){ 
	
	
			$classes = $this->Classections->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->where(['Classes.status' => '1','Classes.id >=' =>'23'])->order(['Classections.id' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
}
	
	
	$sectionslist = $this->Sections->find('list', [
    'keyField' => 'id',
    'valueField' => 'title'
])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist',$sectionslist);
		
	
	
		
		
		if($rolepresent=='1'){ 
		$student_data = 
		$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status'=>'Y'])->order(['Classes.sort' => 'ASC','Sections.id' => 'ASC','Students.fname' => 'ASC'])->limit(100)->toarray();
		$this->set('students',$student_data);
	
}else if($rolepresent=='5'){ 
	
		$student_data = 
		$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.board_id'=>'1','Students.status'=>'Y'])->order(['Classes.sort' => 'ASC','Sections.id' => 'ASC','Students.fname' => 'ASC'])->toarray();
		$this->set('students',$student_data);
	
}else if($rolepresent=='8'){ 
	$bordid=['2','3'];
	$student_data = 
	$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.board_id IN'=>$bordid,'Students.status'=>'Y'])->order(['Classes.sort' => 'ASC','Sections.id' => 'ASC','Students.fname' => 'ASC'])->toarray();
		$this->set('students',$student_data);
	
}
		//get data from paricular id
		//$classes = $this->Classfee->get($id);
		//$this->set(compact('classes'));
	    }
	//view functionality
	
	
	
	public function studentview($id=null){    
		
		$this->viewBuilder()->layout('admin');
		$user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$rolepresentyear=$user['academic_year'];
		
		$this->set(compact('rolepresentyear'));
	
$rolepresent=$this->request->session()->read('Auth.User.role_id');

if($this->request->session()->read('openfess_recipt')){
	
	$ids=$this->request->session()->read('openfess_recipt'); 
			
	$ids2=$this->request->session()->read('openfess_recipt2');
	$acedemicdd=$this->request->session()->read('openfess_recipt5');
			
        $this->set(compact('ids'));
		$this->set(compact('ids2'));
		$this->set(compact('id'));
		$this->set(compact('acedemicdd'));
		$this->set(compact('academic_year'));
		$this->request->session()->delete('openfess_recipt');
		$this->request->session()->delete('openfess_recipt2');
		$this->request->session()->delete('openfess_recipt5');
		
	}
	
	 	if($this->request->session()->read('openfess_recipt3')){
					
			
			
			$ids3=$this->request->session()->read('openfess_recipt3');
			$ids4=$this->request->session()->read('openfess_recipt4');
				 $acedemicdd=$this->request->session()->read('openfess_recipt5');
						$this->set(compact('ids3'));
						$this->set(compact('ids4'));
						$this->set(compact('acedemicdd'));
						$this->request->session()->delete('openfess_recipt3');
						$this->request->session()->delete('openfess_recipt4');
						$this->request->session()->delete('openfess_recipt5');
	
		}
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
		
	
	
		
		
		if($rolepresent=='1'){ 
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status'=>'Y'])->order(['Students.id'=>'DESC','Students.fname' => 'ASC'])->toarray();
		$this->set('students',$student_data);
	
}else if($rolepresent=='5'){ 
	
		$student_data = 
		$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status'=>'Y','Students.board_id'=>'1'])->order(['Students.id'=>'DESC','Students.fname' => 'ASC'])->limit(20)->toarray();
		$this->set('students',$student_data);
	
}else if($rolepresent=='8'){ 
	$bordid=['2','3'];
	$student_data = 
	$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status'=>'Y','Students.board_id IN'=>$bordid])->order(['Students.id'=>'DESC','Students.fname' => 'ASC'])->limit(20)->toarray();
		$this->set('students',$student_data);
	
}
		//get data from paricular id
		//$classes = $this->Classfee->get($id);
		//$this->set(compact('classes'));
	    }
	
	
	
	public function view($id=null){    
		
		$this->viewBuilder()->layout('admin');
		$user=$this->Users->find('all')->where(['Users.role_id' =>'1'])->first();
		$rolepresentyear=$user['academic_year'];
		 $acd= $this->academicyear();
        
        $this->set(compact('acd'));

		
			$this->set(compact('rolepresentyear'));
	
$rolepresent=$this->request->session()->read('Auth.User.role_id');

if($this->request->session()->read('openfess_recipt')){
	
	

			
			  $ids=$this->request->session()->read('openfess_recipt'); 
			
			 $ids2=$this->request->session()->read('openfess_recipt2');
			 $acedemicdd=$this->request->session()->read('openfess_recipt5');
			


		$this->set(compact('ids'));
		$this->set(compact('ids2'));
		$this->set(compact('id'));
		$this->set(compact('acedemicdd'));
		$this->set(compact('academic_year'));
		$this->request->session()->delete('openfess_recipt');
		$this->request->session()->delete('openfess_recipt2');
		$this->request->session()->delete('openfess_recipt5');
		
	}
	
	 	if($this->request->session()->read('openfess_recipt3')){
					
			
			
			$ids3=$this->request->session()->read('openfess_recipt3');
			$ids4=$this->request->session()->read('openfess_recipt4');
				 $acedemicdd=$this->request->session()->read('openfess_recipt5');
						$this->set(compact('ids3'));
						$this->set(compact('ids4'));
						$this->set(compact('acedemicdd'));
						$this->request->session()->delete('openfess_recipt3');
						$this->request->session()->delete('openfess_recipt4');
						$this->request->session()->delete('openfess_recipt5');
	
		}
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
		
	
	
		
		
		if($rolepresent=='1'){ 
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status'=>'Y'])->order(['Students.id'=>'DESC','Students.fname' => 'ASC'])->toarray();
		$this->set('students',$student_data);
	
}else if($rolepresent=='5'){ 
	
		$student_data = 
		$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status'=>'Y','Students.board_id'=>'1'])->order(['Students.id'=>'DESC','Students.fname' => 'ASC'])->limit(20)->toarray();
		$this->set('students',$student_data);
	
}else if($rolepresent=='8'){ 
	$bordid=['2','3'];
	$student_data = 
	$this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status'=>'Y','Students.board_id IN'=>$bordid])->order(['Students.id'=>'DESC','Students.fname' => 'ASC'])->limit(20)->toarray();
		$this->set('students',$student_data);
	
}
		
	    }
	//delete functionality
	public function delete($id,$academic_year){
	    //$this->request->allowMethod(['post', 'delete']);
  $conn = ConnectionManager::get('default');
$conn->execute("DELETE FROM class_fee_allocations WHERE academic_year='".$academic_year."' AND class_id='".$id."'");
	 
		$this->Flash->success(__('Class Fee with id: {0} has been deleted.', h($id)));
		return $this->redirect(['action' => 'index']);
	    
	}
	//status update functionality
	public function status($id,$status,$academic_year){

	
		if(isset($id) && !empty($id)){
		if($status == 'Y' ){
			
				$status = 'N';
			//status update
			  $conn = ConnectionManager::get('default');
$conn->execute("UPDATE `class_fee_allocations` SET `status` = 'N' WHERE `academic_year`='".$academic_year."' AND `class_fee_allocations`.`class_id` = ".$id);
			
				
					$this->Flash->success(__('Class Fee status has been updated.'));
					return $this->redirect(['action' => 'index']);	
				
		}else{
						  $conn = ConnectionManager::get('default');
$conn->execute("UPDATE `class_fee_allocations` SET `status` = 'Y' WHERE `academic_year`='".$academic_year."' AND `class_fee_allocations`.`class_id` = ".$id);
	$this->Flash->success(__('Class Fee status has been updated.'));
					return $this->redirect(['action' => 'index']);	
		}

	}
		
	}
	public function otherfees()
    {
        $this->viewBuilder()->Layout('admin');
        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        $this->loadModel('Otherfees');
        $this->loadModel('Studentfees');
        $this->loadModel('Classes');
        $feesheadstotal = $this->Feesheads->find('list', [
            'keyField' => 'name',
            'valueField' => 'name',
        ])->where(['status' => 'Y', 'type IN' => ['3', '0'], 'sort !=' => '0'])->order(['name' => 'ASC'])->toArray();
        $this->set('feesheadstotal', $feesheadstotal);
        $class_id = $this->Classes->find('list', ['keyField' => 'id', 'valueField' => 'title'])->order(['sort' => 'ASC'])->toarray();
        $this->set(compact('class_id'));

        if ($rolepresent == '5') {

            $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

            $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
            if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
                $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];

            }

            $c = $student_datasmaxss['amount'];

        } else if ($rolepresent == '8') {

            $boardzs = ['2', '3'];

            $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id IN' => $boardzs, 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

            $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id IN' => $boardzs, 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
            if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
                $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];

            }

            $c = $student_datasmaxss['amount'];

        }

        $recipietno = $c + 1;
        $this->set('recipietno', $recipietno);
        if ($this->request->is(['post', 'put'])) {

            $userTable2 = TableRegistry::get('Studentfees');
            $exists2 = $userTable2->exists(['token' => $this->request->data['token'], 'student_id' => $this->request->data['student_id']]);
            if ($exists2) {
                $this->redirect(['controller' => 'Studentfees', 'action' => 'otherfees']);
            } else {
                //pr($this->request->data);die;
                if ($rolepresent == '5') {

                    $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

                    $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
                    if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
                        $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];

                    }

                    $c = $student_datasmaxss['amount'];

                } else if ($rolepresent == '8') {

                    $boardzs = ['2', '3'];

                    $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id IN' => $boardzs, 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

                    $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id IN' => $boardzs, 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
                    if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
                        $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];

                    }

                    $c = $student_datasmaxss['amount'];

                }

                $recipietno = $c + 1;
                $peopleTableshh = TableRegistry::get('Studentfees');
                $oQueryshh = $peopleTableshh->query();
                if ($rolepresent == '5') {

                    $stidd = '6342';
                } else if ($rolepresent == '8') {

                    $stidd = '333333';
                }
                $ofdate = date('Y-m-d', strtotime($this->request->data['paydate']));
                $this->request->data['title'] = strtoupper($this->request->data['title']);

                //pr($date);die;
                $str2 = 'a:1:{s:14:"Other Fees";d:' . $this->request->data['amount'] . ';}';
                $mode = strtoupper($this->request->data['mode']);
                $oQueryshh->insert(['student_id', 'paydate', 'quarter', 'mode', 'formno', 'type', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'remarks', 'token'])
                    ->values([
                        'student_id' => $stidd, 'paydate' => $ofdate, 'quarter' => $str2, 'mode' => $mode, 'formno' => '0', 'type' => 'Other', 'recipetno' => $recipietno, 'bank' => '', 'cheque_no' => '0', 'addtionaldiscount' => '0.00', 'deposite_amt' => $this->request->data['total'], 'fee' => $this->request->data['amount'], 'ref_no' => '0', 'discount' => $this->request->data['discount'], 'status' => 'Y', 'acedmicyear' => $this->request->data['academicyear'], 'discountcategory' => '', 'remarks' => $this->request->data['title'], 'token' => $this->request->data['token']]);
                $oQueryshh->execute();
                $this->request->data['title'] = strtoupper($this->request->data['title']);
                $this->request->data['pupilname'] = strtoupper($this->request->data['pupilname']);
                $this->request->data['parentsname'] = strtoupper($this->request->data['parentsname']);

                $other = $this->Otherfees->newEntity();
                $this->request->data['paydate'] = $ofdate;
                $this->request->data['receipt_no'] = $recipietno;
                $otherfee = $this->Otherfees->patchEntity($other, $this->request->data);
                $save = $this->Otherfees->save($otherfee);
                $id = $save->id;
                //echo $id; die;
                $this->request->session()->write('open_recipt', $id);

                return $this->redirect(['action' => 'otherfees']);

            }
        }

        $oid = $this->request->session()->read('open_recipt');

        $this->set(compact('oid'));
        $this->request->session()->delete('open_recipt');
        $detail = $this->Otherfees->find('all')->where(['status' => 'Y'])->order(['id' => 'DESC'])->toarray();
        //pr($detail);die;
        $acadyr = $this->Otherfees->find('list', ['keyField' => 'academicyear', 'valueField' => 'academicyear'])->group(['academicyear'])->toarray();
        $this->set(compact('acadyr'));

        $this->set(compact('detail'));

    }

    public function otherfees_receipt($id = null)
    {
        $this->viewBuilder()->Layout('admin');
        $this->loadModel('Otherfees');
        $recipt = $this->Otherfees->get($id);
		$this->set(compact('recipt'));
		$this->sitesetting('receipt');
    }
    
    public function otherfees_delete()
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $id = $this->request->data['id'];
            $reason = $this->request->data['reasonforcancelling'];
            $this->loadModel('Otherfees');
            $this->loadModel('Studentfees');
            $fee = $this->Otherfees->get($id);
            $fee->status = 'N';
            $feeall = $this->Studentfees->find('all')->where(['recipetno' => $fee['receipt_no']])->first();
            $q1 = $this->Otherfees->patchEntity($fee, $this->request->data);
            if ($this->Otherfees->save($q1)) {
                $feeall->status = 'N';

                if ($this->Studentfees->save($feeall)) {
                    return $this->redirect(['action' => 'otherfees']);
                    $this->Flash->success(__('Fee Cancelled Sucessfully!!'));
                }
            }
        }

    }
    public function otherfee_select()
    {
        if ($this->request->is('post')) {
            $name = $this->request->data['pupilname'];
            $enroll = $this->request->data['s_id'];
            $mob = $this->request->data['mobile_no'];
            if(isset($this->request->data['pupilname'])){
            $fname = explode(' ', $this->request->data['pupilname']);
		     }

            $conn = ConnectionManager::get('default');
            //pr($this->request->data); die;;
            //pr($enroll); die;
            if (isset($fname) && !empty($fname)) {
				$cond='';
				$cond1='';
				 if (!empty($fname[0])) {

            $cond .= " AND  UPPER(students.fname)  LIKE  '" . strtoupper($fname[0]) . "%'";
            $cond1 .= " AND  UPPER(drop_out_students.fname)  LIKE  '" . strtoupper($fname[0]) . "%'";
        }

        if (!empty($fname[1])) {

            $cond .= " AND   UPPER(students.middlename)  LIKE  '" . strtoupper($fname[1]) . "%'";
          $cond1 .= " AND  UPPER(drop_out_students.middlename)  LIKE  '" . strtoupper($fname[1]) . "%'";
        }
                $query = "SELECT * FROM students WHERE 1=1";
                $query1=$query.$cond;
                $result1 = $conn->execute($query1)->fetchAll('assoc');
                //pr($result1);
                $querys = "SELECT * FROM  drop_out_students WHERE 1=1";
                $query2=$querys.$cond1;
                $result2 = $conn->execute($query2)->fetchAll('assoc');
                //pr($result2); die;
                $result = array_merge($result1, $result2);
                $this->set(compact('result'));
            } else if (isset($enroll) && !empty($enroll)) {
				//pr($enroll); die;
                $query1 = "SELECT * FROM students WHERE UPPER(students.enroll) ='" . $enroll . "'";
                $result1 = $conn->execute($query1)->fetchAll('assoc');
                //pr($result1); die;
                $query2 = "SELECT * FROM  drop_out_students WHERE enroll='" . $enroll . "'";
                $result2 = $conn->execute($query2)->fetchAll('assoc');
                //pr($result2); die;
                $result = array_merge($result1, $result2);
                $this->set(compact('result'));

            } else if (isset($mob) && !empty($mob)) {
                $query1 = "SELECT * FROM students WHERE UPPER(students.sms_mobile) ='" . $mob . "'";
                $result1 = $conn->execute($query1)->fetchAll('assoc');
                //pr($result1);
                $query2 = "SELECT * FROM  drop_out_students WHERE sms_mobile='" . $mob . "'";
                $result2 = $conn->execute($query2)->fetchAll('assoc');
                //pr($result2); die;
                $result = array_merge($result1, $result2);
                $this->set(compact('result'));

            }
            //pr($result); die;
        }

    }
    public function updatecheque(){
		$this->autoRender=false;
		
		$this->loadModel('Studentfees');
		if($this->request->is('post'))
		{
			
			$id=$this->request->data['id'];
			$cheq=$this->request->data['cheque_no'];
			$bank=$this->request->data['bank'];
			// echo $cheq; die;
			 $conn = ConnectionManager::get('default');
			 $SQL="UPDATE `student_feeallocations` SET `cheque_no` = '".$cheq."',`bank`= '".$bank."' WHERE `student_feeallocations`.`id` = ".$id.";";
			 $conn->execute($SQL)->count();
			 
			echo 1; 
		}
			
	}
}