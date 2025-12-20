<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
class StudentexamresultController extends AppController
{
	

	
	
	//initialize component
	public function initialize(){
        parent::initialize();
       	$this->loadModel('Studentexamresult');
       	$this->loadModel('Exams');
       	$this->loadModel('Examtypes');
       	$this->loadModel('Classes');
       	$this->loadModel('Students');
       	$this->loadModel('Classections');
       	$this->loadModel('Sections');
       	$this->loadModel('Examdetails');
       	$this->loadModel('Subjects');
       	$this->loadModel('Guardians');
       	$this->loadModel('Address');
       	
       
    	}
    public function beforeFilter(Event $event)
    {    
	  $this->loadModel('Studentexamresult');
       	$this->loadModel('Exams');
       	$this->loadModel('Examtypes');
       	$this->loadModel('Classes');
       	$this->loadModel('Students');
       	$this->loadModel('Classections');
       	$this->loadModel('Sections');
       	$this->loadModel('Examdetails');
       	$this->loadModel('Subjects');
       	$this->loadModel('Guardians');
       	$this->loadModel('Address');
       		$this->loadModel('Users');
        parent::beforeFilter($event);
	
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['result']);
    }

public function calculateHolidays($start_date, $end_date, $month)
{
    $total_days = 0;
    $start_num_days = 0;
    $start_num_days = 0;
    $start_str = strtotime($start_date);
    $end_str = strtotime($end_date);
    
    $start_year = date('Y',$start_str);
    $end_year = date('Y',$end_str); 
    $start_month = date('m',$start_str); 
    $end_month = date('m',$end_str);
    $start_day = date('d',$start_str);
    $end_day = date('d',$end_str);
    
    $start_num_days_month = cal_days_in_month(CAL_GREGORIAN, $start_month, $start_year);
    $end_num_days_month = cal_days_in_month(CAL_GREGORIAN, $end_month, $end_year);

    if($start_month!=$end_month)
    {
		if($start_month==$month)
		{
		   $end_date = $start_year.'-'.$start_month.'-'.$start_num_days_month;
		   $sundays = $this->findSundays($start_date, $end_date);
		   $total_days = ($start_num_days_month - $start_day)-$sundays; 
		}
		if($start_month < $month)
		{
		   $start_date = $start_year.'-'.$end_month.'-01';
		   $sundays = $this->findSundays($start_date, $end_date);
		   $total_days = ($end_day - 0)-$sundays;
		}
	}
	else
	{
		   $days_str = $end_str - $start_str;
		   $days = number_format(($days_str) / 86400 + 1);
		$sundays = $this->findSundays($start_date, $end_date);
		  $total_days = $days-$sundays;
	}	 
	 
	//echo $total_days;
    //$total_days = $start_num_days+$end_num_days; 
    return $total_days;
}
public function findSundays($start_date, $end_date)
{
    //echo $start_date.'=>'.$end_date;
    $startDate = new DateTime($start_date);
    $endDate = new DateTime($end_date);
    $sundays = array();
    while ($startDate <= $endDate) {
        if ($startDate->format('w') == 0) {
            $sundays[] = $startDate->format('Y-m-d');
        }
        $startDate->modify('+1 day');
    }
    return count($sundays);
}

public function getWorkingDayss($startDate, $endDate)
{
    $begin = strtotime($startDate);
    $end   = strtotime($endDate);
    if ($begin > $end) {
        echo "startdate is in the future! <br />";

        return 0;
    } else {
        $no_days  = 0;
        $weekends = 0;
        while ($begin <= $end) {
            $no_days++; // no of days in the given interval
            $what_day = date("N", $begin);
            if ($what_day > 6) { // 6 and 7 are weekend days
                $weekends++;
            };
            $begin += 86400; // +1 day
        };
        $working_days = $no_days - $weekends;

        return $working_days;
    }
}

    	
    	
    	public function addcsv($id=null,$sid=null) {
			
			
		$this->viewBuilder()->layout('admin');
		$this->set('exid',$id);
		    $examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id' => $id])->order(['Exams.id' => 'asc'])->first()->toArray();
    $class_id=$examtypes['class_id'];
    $e_type_id=$examtypes['e_type_id'];
		
$this->set('class_id',$class_id);
$this->set('e_type_id',$e_type_id);
$this->set('sectionid',$sid);
if($_GET['query']){
	
	    $this->set('query',1);
	
	
}
  $examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id' => $id])->order(['Exams.id' => 'asc'])->first()->toArray();
    $class_id=$examtypes['class_id'];
    $e_type_id=$examtypes['e_type_id'];
    $this->set('class_id',$class_id);
$this->set('e_type_id',$e_type_id);
 if($this->request->is('post') || $this->request->is('put'))
   {
       

 	if($this->data['file']['type'] == 'application/csv' || 'application/vnd.ms-excel' || 'text/csv')
 	{
		
	$filename=$this->request->data['file']['name'];    
	
	
	
    $item=$this->request->data['file']['tmp_name']; 
    $exid=$this->request->data['exid']; 
    if($this->request->data['query']=='1'){
    $query=$this->request->data['query']; 
    
}else{
	$query='0';
	
	}
    $sect_id=$this->request->data['sect_id']; 
    $examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id' => $exid])->order(['Exams.id' => 'asc'])->first()->toArray();
    $class_id=$examtypes['class_id'];
    $e_type_id=$examtypes['e_type_id'];
    
      $mkr1=rand(1,13000000);
                    //   $imagename1=$filename1.'.'.;
                        $filename=$mkr1.$filenam;
		                    if(move_uploaded_file($item,"excel_file/".$filename)){

		$this->csv($filename,$exid,$sect_id,$query);
	

		
		}
	$directory = WWW_ROOT . 'excel_file/'.$filename;
		   
unlink($directory);
	
		 $directory2 = WWW_ROOT . 'excel_file/'.$mkr1;
unlink($directory2);
$roleid=$this->request->session()->read('Auth.User.role_id');
if($roleid=='3'){
$this->redirect(array('action'=>'view/2'));	
} else
{
$this->redirect(array('action'=>'view/'.$class_id.'/'.$e_type_id));	
}
	
	}
	
	else
	{
		$this->Session->setFlash(__('File type must be csv only'), 'flash/Error');
	}	

    }
}	



	public function csv($filename,$exid,$sect_id,$query) {

	$this->loadModel('Studentexamresult');
          $documents = $this->Studentexamresult->newEntity();
        //$filename = TMP . 'uploads' . DS . $filename;
         $filename=SITE_URL.'excel_file/' . $filename; 
       
        // open the file
        $handle = fopen($filename, "r");
 
        // read the 1st row as headings
        $header = fgetcsv($handle);

         
        // create a message container
        $return = array(
            'messages' => array(),
            'errors' => array(),
        );
 


 
 if($query=='1'){
	  $conn = ConnectionManager::get('default'); 
    
     $conn->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND sect_id='".$sect_id."'"); 

	 
	 
 }else{
	 
	 }
if(sizeof($header)==1){
        $field = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $header[0]);

$header = explode(",",$field);

}


 $this->request->data=0;

        // read each data row in the file
        while (($row = fgetcsv($handle)) !== FALSE) {
     
            $data = array();
            if(sizeof($row)==1){
   $row = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $row[0]);
	 			$row = explode(",",$row);
			}
            // for each header field

            foreach ($header as $k=>$head) {
		
  if (strpos($head,'.')!==false) {
                    $h = explode('.',$head);
                  
                   $data[$h[0]][$h[1]]=(isset($row[$k])) ? $row[$k] : ',';
                   

                }else{
                    $data[$head]=(isset($row[$k])) ? $row[$k] : ',';
                    
                    
               $this->request->data[$head]=(isset($row[$k])) ? $row[$k] : ',';

		   }
		  

            }
            	  
            	     $conn = ConnectionManager::get('default');
            	    $peopleTable = TableRegistry::get ('Studentexamresult');
$oquery = $peopleTable->query();

$subject=0;

$subject=$data['Subject'];

//pr($data['Subject']['Hindi(20)']); die;
$fgh=0; 
	$examdetails = $this->Examdetails->find('all')->contain(['Subjects'])->where(['Examdetails.exam_id' => $exid])->order(['Examdetails.id' => 'asc'])->toarray();
foreach ($examdetails as $key => $value) 
{
foreach($subject as $id=>$smarks){
	
if($value['max_marks']<$smarks || $smarks<'0'){ 

$this->Flash->error(__('Please check inserted marks in csv (Marks cannot be negative or exceed maximum marks)'), 'flash/sucess');
 // close the file
        fclose($handle);

  $oquery="DELETE FROM `studentexamresult` WHERE `studentexamresult`.`sect_id` =$sect_id";
 $results1 = $conn->execute($oquery);
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id]);
        }
  	  }
}


foreach($subject as $id=>$marks){

	$fgh = explode('(',$id);
		$subjectclasses_data = $this->Subjects->find('all')->where(['name' =>$fgh[0]])->first()->toarray();

		$examdetails = $this->Examdetails->find('all')->contain(['Subjects'])->where(['Examdetails.exam_id' => $exid])->order(['Examdetails.id' => 'asc'])->toarray();



	//pr($submarks);
$oquery->insert (['stud_id','exam_id','subject_id','marks','sect_id'])
        ->values ([
        'stud_id' => $data['Enroll'],'exam_id' => $exid,'subject_id'=>$subjectclasses_data['id'],'marks'=>$marks,'sect_id'=>$sect_id]); 
       

		

	
	}
	
    $d=$oquery->execute();
         
	
        }
       $this->Flash->success(__('Upload Csv Done'), 'flash/sucess');	
      
        // close the file
        fclose($handle);

        // return the messages
        return $return;

         }
	public function index($id=null){ 
	
		$this->viewBuilder()->layout('admin');
		//show data in listing
		if($_GET['id']){
		
				$this->set('selectid',$_GET['id']);
		 }
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
		$this->set('id',$id);
			
	$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);
	
	}
	




public function find_etype(){
	
	$classid=$this->request->data['id']; 
	   	$this->viewBuilder()->layout('admin');
	  
			$examtypes = $this->Exams->find('list', [
    'keyField' => 'Examtypes.id',
    'valueField' => 'Examtypes.name'
])->contain(['Examtypes','Classes'])->where(['Classes.id' => $classid,'Exams.status'=>'Y'])->order(['Examtypes.name' => 'ASC'])->toArray();
	$this->set('examtypes', $examtypes);
	
	
	echo "<option value=''>Select</option>";
		
		foreach($examtypes as $sections=>$value){
			echo "<option value=".$sections.">".$value."</option>";
		} die;
	

	
	
	}
	
	public function export($id=null,$sid=null) {
		 $this->loadModel('User');
		$this->loadModel('Employees');
		$this->loadModel('ClasstimeTabs');
       $sb=array(); $cid=array();
		$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id' => $id])->order(['Examtypes.id' => 'asc'])->first()->toArray();
		$examdetails = $this->Examdetails->find('all')->contain(['Subjects'])->where(['Examdetails.exam_id' => $id])->order(['Examdetails.id' => 'asc'])->toarray();


        $roleid=$this->request->session()->read('Auth.User.role_id');
        if($roleid=='3')
        {
		$uemail=$this->request->session()->read('Auth.User.email');
		$employ =$this->Employees->find('all')->where(['Employees.email' => $uemail])->first();
        $dpid=$employ['id'];

        $ctime=$this->ClasstimeTabs->find('all')->where(['ClasstimeTabs.employee_id' =>$dpid])->toArray();
        foreach($ctime as $key=>$sub)
        {	
        $sb[]=$sub['subject_id'];
        $cid=$sub['class_id'];
        }
       
  $examdetails = $this->Examdetails->find('all')->contain(['Subjects'])->where(['Examdetails.subject_id IN' =>$sb,'Examdetails.class_id IN' =>$cid])->order(['Subjects.id' => 'asc'])->toarray(); 
 pr($examdetails); die;
  foreach($examdetails as $key=>$value){
				
				$var[]= "Subject.".$value->subject->name."(".$value->max_marks.")";
				
				}
        } 
        elseif ($roleid!='3') {
        	foreach($examdetails as $key=>$value){
				
				$var[]= "Subject.".$value->subject->name."(".$value->max_marks.")";
				
				}
        }


			
				
				$name=$examtypes['Examtypes']['name']; 
	 
				$classid=$examtypes['class_id'];
				$acedamicyear=$examtypes['acedamicyear'];
				


		$this->response->download($name.'result.csv');
		$data =  $this->Students->find()->select([
                    'Students.id', 'Students.fname', 'Students.username'])->contain(['Sections','Classes'])->where(['Students.class_id' => $classid,'Students.section_id' => $sid,'Students.acedmicyear' => $acedamicyear,'Students.status' => 'Y'])->toarray();


		$_serialize = 'data';
   		$this->set(compact('data', '_serialize'));
   		$_headers = ['Enroll', 'Name', 'Email'];
 
$_header = array_merge($_headers, $var);

$this->set(compact('data', '_serialize', '_header'));
		$this->viewBuilder()->className('CsvView.Csv');
		return;
	}
	
// search functionality
public function search(){ 
	

 $this->loadModel('User');
		$this->loadModel('Employees');
		 $this->loadModel('ClasstimeTabs');
		 $this->loadModel('Classections');
$class=$this->request->data['class_id'];

$examtypes=$this->request->data['examtypes']; 
$acedamicyear=$this->request->data['acedamicyear']; 

$roleid=$this->request->session()->read('Auth.User.role_id');
$uemail=$this->request->session()->read('Auth.User.email');
$employ =$this->Employees->find('all')->where(['Employees.email' => $uemail])->first();
$dpid=$employ['id'];
    
$csec=$this->ClasstimeTabs->find('all')->contain(['Classes'])->where(['ClasstimeTabs.employee_id' => $dpid])->order(['ClasstimeTabs.id' => 'ASC'])->toArray();
foreach ($csec as $key => $value)
{
$csection=$this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classections.id' => $value['class_id']])->order(['Classections.id' => 'ASC'])->toArray();
$this->set('csection',$csection);
}
  

if($acedamicyear){

		$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.class_id' => $class,'Exams.acedamicyear' => $acedamicyear,'Exams.e_type_id' => $examtypes])->order(['Exams.id' => 'asc'])->toArray();
	$this->set('examtypes', $examtypes); 
}else{
	
	
	$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.class_id' => $class,'Exams.e_type_id' => $examtypes])->order(['Exams.id' => 'asc'])->toArray();
	$this->set('examtypes', $examtypes); 
	}
		$classes = $this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classes.id' => $class])->order(['Sections.title' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
	
	}


public function coschoolsearch(){
	
	

$class=$this->request->data['class_id'];
$term=$this->request->data['term'];
$this->set('term', $term);

$acedamicyear=$this->request->data['acedamicyear']; 

if($acedamicyear){

		$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.class_id' => $class,'Exams.acedamicyear' => $acedamicyear])->order(['Exams.id' => 'asc'])->toArray();
	$this->set('examtypes', $examtypes); 
}else{
	
	
	$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.class_id' => $class])->order(['Exams.id' => 'asc'])->toArray();
	$this->set('examtypes', $examtypes); 
	}
		$classes = $this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classes.id' => $class])->order(['Sections.title' => 'ASC'])->toArray();
	$this->set('classes', $classes);
	
	
	
	
	
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
	public function add($id=null){ 
	
		$this->viewBuilder()->layout('admin');
		
			$subjectclasses_data = $this->Subjectclass->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->order(['Classes.id' => 'ASC'])->toarray();
		//$this->paginate($service_data);
		$this->set('classlist',$subjectclasses_data);
		
				
					$feesheads = $this->Feesheads->find('all')->order(['id' => 'ASC'])->toarray();
			$this->set('feesheads',$feesheads);
		if(isset($id) && !empty($id)){
			//using for edit
		     $classes = $this->Studentfees->get($id);

		}else{
			//using for new entry
			$classes = $this->Studentfees->newEntity();
				$this->request->data['status'] = '1';
		}
		if ($this->request->is(['post', 'put'])) {
		
 $peopleTable = TableRegistry::get ('Studentfees');
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
    $oQuery->insert (['student_id','paydate','quarter','amount','mode','bank_id','cheque_no','status'])
        ->values ([
        'student_id' => $this->request->data['student_id'],'paydate' => $this->request->data['paydate'][$i],'quarter'=>$this->request->data['quater'][$i],'amount'=>$this->request->data['amount'][$i],'mode'=>$this->request->data['mode'],'bank_id'=>$this->request->data['bank_id'],'cheque_no'=>$this->request->data['cheque_no'],'status'=>'Y']); 
        
        
        
        
 
}

     $d=$oQuery->execute ();
			$studid=$this->request->data['student_id'];
				// save all data in database
			
				if ($d) {
					$this->Flash->success(__('Student Fee  has been saved.'));
					return $this->redirect(['action' => 'index/'.$studid.'/?id=personal']);	
				  }else{
				
	$this->Flash->success(__('Student Fee  not saved.'));
			return $this->redirect(['action' => 'index/'.$studid.'/?id=personal']);		
				}
			
                }

		$this->set('classes', $classes);
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
    $oQuery->insert (['student_id','paydate','quarter','amount','mode','bank_id','cheque_no','status'])
        ->values ([
        'student_id' => $this->request->data['student_id'],'paydate' => $this->request->data['paydate'][$i],'quarter'=>$this->request->data['quater'][$i],'amount'=>$this->request->data['amount'][$i],'mode'=>$this->request->data['modes'],'bank_id'=>$this->request->data['bank_id'],'cheque_no'=>$this->request->data['cheque_no'],'status'=>'Y']); 
        
        
        
        
 
}

     $d=$oQuery->execute ();
		$studid=$this->request->data['student_id'];
				// save all data in database
			
				if ($d) {
					$this->Flash->success(__('Student Transport Fee  has been saved.'));
						return $this->redirect(['action' => 'index/'.$studid.'/?id=academic']);		
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
		if($this->request->data['paydate']==""){
				$this->Flash->error(__('Selsect one of option.'));
					return $this->redirect(['action' => 'index/'.$this->request->data['student_id'].'/?id=guardians']);	
			
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
    $oQuery->insert (['student_id','paydate','h_id','h_name','amount','mode','bank_id','cheque_no','status'])
        ->values ([
        'student_id' => $this->request->data['student_id'],'paydate' => $this->request->data['paydate'],'h_id'=>$this->request->data['h_id'],'h_name'=>$this->request->data['h_name'],'amount'=>$this->request->data['amount'],'mode'=>$this->request->data['modes1'],'bank_id'=>$this->request->data['bank_id'],'cheque_no'=>$this->request->data['cheque_no'],'status'=>'Y']); 
        
        
        
        
 
}
$studid=$this->request->data['student_id'];
     $d=$oQuery->execute ();
		
				// save all data in database
			
				if ($d) {
					$this->Flash->success(__('Student Hostal Fee  has been saved.'));
					return $this->redirect(['action' => 'index/'.$studid.'/?id=guardians']);	
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
	//view functionality
	
	
	public function schoolasticview($classid=null,$sect_id=null,$acedmicyear=null,$term=null){    
		
		$this->viewBuilder()->layout('admin');
		if($classid && $sect_id){
			
			
			
		$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.class_id' => $classid,'Exams.acedamicyear' => $acedmicyear])->order(['Exams.id' => 'asc'])->toArray();
	$this->set('examtypes', $examtypes); 

		$classess = $this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classes.id' => $classid])->order(['Sections.title' => 'ASC'])->toArray();
	$this->set('classesss', $classess);
			
		$classes = $this->Exams->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->order(['Classes.id' => 'asc'])->toArray();
	$this->set('classes', $classes);	
			
			
			
	
	$this->set('classid', $classid);
	$this->set('term', $term);
		
			
			
		}else{
				$classes = $this->Exams->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->order(['Classes.id' => 'asc'])->toArray();
	$this->set('classes', $classes);

		$examtypes = $this->Exams->find('list', [
    'keyField' => 'Examtypes.id',
    'valueField' => 'Examtypes.name'
])->contain(['Examtypes'])->where(['Examtypes.status' => 'Y'])->order(['Examtypes.id' => 'asc'])->toArray();
	$this->set('examtypes', $examtypes);
	
}



	    }
	
	public function view($classid=null,$examtypes=null){    

		$this->loadModel('User');
		$this->loadModel('Employees');
		$this->loadModel('ClasstimeTabs');
		$this->loadModel('Subjects');
		$this->loadModel('Classes');
		$this->loadModel('Exams');
		
		$this->viewBuilder()->layout('admin');

         $uemail=$this->request->session()->read('Auth.User.email');
		$employ =$this->Employees->find('all')->where(['Employees.email' => $uemail])->first();
        $dpid=$employ['id'];

     $ctime=$this->ClasstimeTabs->find('all')->where(['ClasstimeTabs.employee_id' =>$dpid])->toArray();
     
foreach ($ctime as $key => $value) {

$cname=$this->Classes->find('list')->where(['Classes.id' =>$value['class_id']])->order(['Classes.id' => 'asc'])->toArray();

  $subname =$this->Subjects->find('all')->where(['Subjects.id' =>$value['subject_id']])->first();

$this->set('cname', $cname);
 $sname=$subname['name'];	
  $this->set('sname', $sname);
}

		if($classid && $examtypes){
			
		$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.class_id' => $classid,'Exams.e_type_id' => $examtypes])->order(['Exams.id' => 'asc'])->toArray();

	$this->set('examtypes', $examtypes);
	$examtypeses = $this->Exams->find('list', [
    'keyField' => 'Examtypes.id',
    'valueField' => 'Examtypes.name'
])->contain(['Examtypes'])->where(['Exams.status' => 'Y'])->order(['Examtypes.name' => 'ASC'])->toArray();
	
	$this->set('examtypeses', $examtypeses);

		$classes = $this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classes.id' => $classid])->order(['Sections.title' => 'ASC'])->toArray();
          

			$classeses = $this->Exams->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->order(['Classes.id' => 'asc'])->toArray();
	$this->set('classeses', $classeses);
	$this->set('classes', $classes);
	$this->set('classid', $classid);
		
			
			
		}else{
				$classes = $this->Exams->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->order(['Classes.id' => 'asc'])->toArray();
	$this->set('classes', $classes);

		$examtypes = $this->Exams->find('list', [
    'keyField' => 'Examtypes.id',
    'valueField' => 'Examtypes.name'
])->contain(['Examtypes'])->where(['Exams.status' => 'Y'])->order(['Examtypes.name' => 'ASC'])->toArray();
	$this->set('examtypes', $examtypes);
	
}



	    }

	    
	    
	    
// search functionality
public function searcharea(){ 
	
		//show all data in listing page
//connection
  $conn = ConnectionManager::get('default');
	
$year=$this->request->data['acedmicyear']; 
$class=$this->request->data['class_id'];
$admission=$this->request->data['admissionyear'];
$section=$this->request->data['section_id']; 
$enroll=$this->request->data['enroll'];
$fname=$this->request->data['fname']; 

$detail="SELECT Students.id,Students.fname,Students.mobile,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id    WHERE  1=1 ";

 $cond = ' ';
if(!empty($year))
{
 
$cond.=" AND Students.acedmicyear LIKE '".$year."%' ";

}
 
 
if(!empty($class))
{
 
    $cond.=" AND Students.class_id LIKE '".$class."%' ";
        

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

 $detail = $detail.$cond;
   $SQL = $detail." ORDER BY Students.id DESC";  

$results = $conn->execute( $SQL )->fetchAll('assoc');

	$this->set('students', $results);

	}
	public function schoolexamview($classid=null,$examtypes=null){    
		
		$this->viewBuilder()->layout('admin');
		
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
		
	
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);
		//get data from paricular id
		//$classes = $this->Classfee->get($id);
		//$this->set(compact('classes'));

	    }
	    
	    
	    public function viewresult($id=null,$section=null,$sectionresult=null){
			
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
		
	
	
			$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id' => $id])->order(['Examtypes.id' => 'asc'])->first()->toArray();
	
    $class_id=$examtypes['class_id'];
    $e_type_id=$examtypes['e_type_id'];
		
$this->set('class_id',$class_id);
$this->set('e_type_id',$e_type_id);
				$subjectclasses_data = $this->Sections->find('all')->where(['id' =>$section])->first()->toarray();
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.class_id' => $examtypes['Classes']['id'],'Students.section_id' => $section,'Students.acedmicyear' => $examtypes['acedamicyear']])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);
				$this->set('classname', $examtypes['Classes']['title']);
				$this->set('examid', $id);
							$this->set('section', $section);
				$this->set('examname', $examtypes['Examtypes']['name']);
				$this->set('sectionname', $subjectclasses_data['title']);
				$this->set('acedamicyear', $examtypes['acedamicyear']);
			
			}
			
			
			public function subjectmarks($exid=null,$sid=null,$section=null){
				
			
				$studentexamresult = $this->Studentexamresult->find('all')->contain(['Exams','Subjects'])->where(['Studentexamresult.exam_id' => $exid,'Studentexamresult.stud_id' => $sid,'Studentexamresult.sect_id' => $section])->order(['Studentexamresult.id' => 'asc']);
				$this->set('studentexamresult', $studentexamresult);
				
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
}
