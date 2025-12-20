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
include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';
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
        $this->loadModel('Primarycentral');
              $this->loadModel('ClasstimeTabs');
              $this->loadModel('ExamSubjects'); 
              	$this->loadModel('Classteachers');
              	$this->loadModel('Coactivitysubject');
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
       	  $this->loadModel('Primarycentral');
       		$this->loadModel('Users');
        parent::beforeFilter($event);
	 
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['result','printfile','getHTML','resultterm2','resultall','resultallixx','resultallcam','resultallcamnine','resultallscience','resultall2','resultallixx2','resultallcam2','resultallcamnine2','resultallcamten2','resultallscience2']);
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

public function printfile()
{
		$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
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

    	
    	
   public function addcsv($id=null,$sid=null,$clid=null,$subjec=null){

    		$this->loadModel('Users');
    		$this->loadModel('Exams');
    		$this->loadModel('Sections');
    		$this->loadModel('Classections');
    		$this->loadModel('Studentexamresult');
			$year=$this->Users->find('all')->where(['Users.role_id' => '1'])->first();

$academic_year=$year['academic_year']; 
			
		$this->viewBuilder()->layout('admin');
		$this->set('exid',$id);
		    $examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id' => $id])->order(['Exams.id' => 'asc'])->first()->toarray();
		    
		    
    $class_id=$clid;
    $e_type_id=$examtypes['e_type_id'];
    $resultuploadlast_date=$examtypes['resultuploadlast_date'];
		
		
		$this->set('resultuploadlast_date',$resultuploadlast_date);
$this->set('class_id',$class_id);
$this->set('e_type_id',$e_type_id);
$this->set('sectionid',$sid);

$sections=$this->Sections->find('all')->where(['Sections.id' =>$sid])->first();

$sectionname=$sections['title']; 

if($_GET['query']){
	
	    $this->set('query',1);
	
	
}


$Subject=$this->Subjects->find('all')->select(['name'])->where(['Subjects.id' =>$subjec])->first();

$Subjectname=$Subject['name']; 

 if(($clid=='3' || $clid=='4' || $clid=='6') && ($subjec=='1')){
					
						$Subjectname = "Maths";
					
					}
	
 $this->set('subjectname',$Subjectname);
    $this->set('subjec',$subjec);
  $examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id' => $id])->order(['Exams.id' => 'asc'])->first()->toarray();
  
  $classess=$this->Classes->find('all')->where(['Classes.id' =>$clid])->first();

$classesname=$classess['title']; 
  
  $this->set('classname', $classesname);
				$this->set('examname', $examtypes['Examtypes']['examname']);
			 	$this->set('sectionname', $sectionname);
				$this->set('acedamicyear', $examtypes['acedamicyear']);

    $e_type_id=$examtypes['e_type_id'];
    $this->set('class_id',$class_id);
$this->set('e_type_id',$e_type_id);









		
	
	




$subjectclasses_data = $this->Sections->find('all')->where(['id' =>$sid])->first()->toarray();
$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.class_id' => $clid,'Students.section_id' => $sid,'Students.status'=>'Y','Students.acedmicyear' => $examtypes['acedamicyear']])->order(['Students.fname' => 'ASC','Students.middlename' => 'ASC','Students.lname' => 'ASC'])->toarray();
		
$student_data1 = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$clid,'Studentexamresult.sect_id' =>$sid,'Students.acedmicyear'=>$examtypes['acedamicyear'],'Students.status'=>'Y','Studentexamresult.exam_id'=>$id])->group(['Studentexamresult.stud_id'])->order(['Students.fname' => 'ASC','Students.middlename' => 'ASC','Students.lname' => 'ASC'])->toarray();

		
		$this->set('studentsda',$student_data1);
		$this->set('students',$student_data);
				$this->set('classname', $student_data[0]['class']['title']);
				$this->set('examid', $id);
				
				if($subjec){
				$this->set('subjec', $subjec);
				
					$subjj=$this->Subjects->find('all')->where(['Subjects.id'=>$subjec])->first();
	
	
	
	 if(($clid=='3' || $clid=='4' || $clid=='6') && ($subjec=='1')){
					
						$subjj['name'] = "Maths";
					$this->set('subjecname', $subjj['name']);
					
					}else{
						
		$this->set('subjecname', $subjj['name']);
		
	}
	}
							$this->set('section', $sid);
				$this->set('examname', $examtypes['Examtypes']['examname']);
				$this->set('sectionname', $subjectclasses_data['title']);
				$this->set('acedamicyear', $examtypes['acedamicyear']);








 if($this->request->is('post') || $this->request->is('put'))
   {
	   
	   
       

 	if($this->data['file']['type'] == 'application/csv' || 'application/vnd.ms-excel' || 'text/csv')
 	{
	
	$filename=$this->request->data['file']['name'];    
	
	
	
    $item=$this->request->data['file']['tmp_name']; 
    $exid=$this->request->data['exid']; 
     $subj=$this->request->data['subj'];  
    if($this->request->data['query']=='1'){
    $query=$this->request->data['query']; 
    
}else{
	$query='0';
	
	}
    $sect_id=$this->request->data['sect_id']; 
    $class_id=$this->request->data['class_id']; 
    $examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id' => $exid])->order(['Exams.id' => 'asc'])->first()->toArray();

    $e_type_id=$examtypes['e_type_id'];
    
      $mkr1=rand(1,13000000);
                  $Subject=$this->Subjects->find('all')->select(['name'])->where(['Subjects.id'=>$subj])->first();

$Subjectname=$Subject['name']; 		                        
		                        
		                        
		               	 if(($class_id=='3' || $class_id=='4' || $class_id=='6') && ($Subjectname=='Mathematics')){
							 $Subjectname = "Maths";
						 }
$subjectclasses_datas = $this->ExamSubjects->find('all')->where(['class_id'=>$class_id,'exprint' =>$Subjectname])->first();

$subjss=$subjectclasses_datas['id']; 

                        $filename=$mkr1.$filenam;
		                    if(move_uploaded_file($item,"excel_file/".$filename)){
		                        

		$see=$this->csv($filename,$exid,$sect_id,$class_id,$query,$subjss,$subj);
		

	
		if(is_object($see)){
			
			
			}else if(is_array($see)){
				
			
		$this->csv2($filename,$exid,$sect_id,$class_id,$query,$subjss,$subj);
	}

		
		}
	$directory = WWW_ROOT . 'excel_file/'.$filename;
		   
unlink($directory);
	
		 $directory2 = WWW_ROOT . 'excel_file/'.$mkr1;
unlink($directory2);
$roleid=$this->request->session()->read('Auth.User.role_id');
if($roleid=='3'){
$this->redirect(array('action'=>'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj.'?query=1'));	
} else
{
$this->redirect(array('action'=>'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj.'?query=1'));	
}
	
	}
	
	else
	{
		$this->Session->setFlash(__('File type must be csv only'), 'flash/Error');
	}	


    }
}	



public function csv($filename,$exid,$sect_id,$class_id,$query,$subj,$subj1) {

	$this->loadModel('Studentexamresult');
	
		$this->loadModel('ExamSubjects');
				$this->loadModel('Subjects');
						$this->loadModel('ClasstimeTabs');
							$this->loadModel('Classections');
          $documents = $this->Studentexamresult->newEntity();
        //$filename = TMP . 'uploads' . DS . $filename;
         $filename=WWW_ROOT.'excel_file/' . $filename; 

        // open the file
        $handle = fopen($filename, "r") or die ("Nothing");
 
        // read the 1st row as headings
        $header = fgetcsv($handle);

         
        // create a message container
        $return = array(
            'messages' => array(),
            'errors' => array(),
        );
 
 
 $empid= $this->request->session()->read('Auth.User.tech_id');


 $role_id=$this->request->session()->read('Auth.User.role_id');
 if($role_id=='3'){

$csec = $this->ClasstimeTabs->find('all')->contain(['Classections'])->where(['FIND_IN_SET(\''. $empid .'\',ClasstimeTabs.employee_id)','Classections.class_id'=>$class_id,'Classections.section_id'=>$sect_id])->toarray();

foreach ($csec as $key => $value)
{
	$empo=explode(',',$value['employee_id']);
		$subjects=explode(',',$value['subject_id']);
		
		foreach($empo as $j=>$t){
			
			foreach($subjects as $sj=>$st){
				
				if($j==$sj && $t==$empid){
			
				
					$csec = $this->Subjects->find('all')->where(['id'=>$st])->first();
					
					if(($class_id=="11" || $class_id=="10" ) && ($st=="66" || $st=="67" || $st=="68")){
						
						$sb[] = str_replace(' ', '', "Science");
						
					}else if(($class_id=="11" || $class_id=="10")  && ($st=="65" || $st=="70" || $st=="71")){
						
						$sb[] = str_replace(' ', '', "Social Science");
						
					}else if(($class_id=='3' || $class_id=='4' || $class_id=='6') && ($st=='1')){
					
						$sb[] = "Maths";
					
					}else{
					$sb[] = str_replace(' ', '', $csec['name']);
					
				}
				}
				
			}	
			
		}
	

}


$tech_id=$this->request->session()->read('Auth.User.tech_id');
	
		
$sss=array_unique($sb);
 
 
}
 
 
 $std_result_status = $this->Studentexamresult->find('all')->where(['Studentexamresult.exam_id' =>$exid,'Studentexamresult.class_id' =>$class_id,'Studentexamresult.sect_id' =>$sect_id])->first();

 
 $role_id=$this->request->session()->read('Auth.User.role_id');
 if($std_result_status['id']){
	  $conn = ConnectionManager::get('default'); 
    if($role_id=='3'){
		 $tech_id=$this->request->session()->read('Auth.User.tech_id');
		

		
	}else{
		

}
	 
	 
 }
if(sizeof($header)==1){
        $field = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $header[0]);

$header = explode(",",$field);

}


 $this->request->data=0;


        $con=0;
        while (($row = fgetcsv($handle)) !== FALSE) {
    
            $data = array();
            if(sizeof($row)==1){
   $row = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $row[0]);
	 			$row = explode(",",$row);
			}
            // for each header field

            foreach ($header as $k=>$head) {
		
  if (strpos($head,'-')!==false) {
                    $h = explode('-',$head);
                  $data['Exam'][]=$h[0];
                   $data['Subject'][][$h[1]]=(isset($row[$k])) ? $row[$k] : ',';
                   

                }else{
                    $data[$head]=(isset($row[$k])) ? $row[$k] : ',';
                    
                    
               $this->request->data[$head]=(isset($row[$k])) ? $row[$k] : ',';

		   }
		  

            }
       
       
         if($data['SrNo']=='' ||  $data['Name']=='' ||  $data['Class']=='' ||  $data['Section']==''){

			  $this->Flash->error(__('Please Make Sure That Student Information are Correct ????'), 'flash/error');

        fclose($handle);

  
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);
			 
		 }	
         $classes_data = $this->Classes->find('all')->where(['title' =>$data['Class']])->first();
$classid=$classes_data['id'];
$section_data = $this->Sections->find('all')->where(['title' =>$data['Section']])->first();
$sectionid=$section_data['id'];
 $stddat = $this->Students->find('all')->where(['Students.enroll'=>trim($data['SrNo']),'Students.class_id'=>$classid,'Students.section_id' =>$sectionid,'Students.status'=>'Y'])->first();

 if($stddat['id']==''){
	 
	 
	 $conn = ConnectionManager::get('default'); 
  
$tech_id=$this->request->session()->read('Auth.User.tech_id');
	   $this->Flash->error(__('Please Make Sure That Student Information are Correct ????'), 'flash/error');

        fclose($handle);

  
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);
	 
 }

         $examtypess = $this->Examtypes->find('all')->where(['FIND_IN_SET(\''. $class_id .'\',class_id)','Examtypes.name IN'=>$data['Exam']])->order(['Examtypes.id' => 'asc'])->first();    	  
         
  
      $examt = $this->Exams->find('all')->where(['Exams.id' =>$exid])->order(['Exams.id' => 'asc'])->first();    	  
    $etypeidd=explode(',',$examt['e_type_id']);
    

    

          if(!in_array($examtypess['id'],$etypeidd)){
          
          $conn = ConnectionManager::get('default'); 
   
          $this->Flash->error(__('Please Make Sure That Inserted Exam Heading Are Same as Sample File ???'), 'flash/error');
 // close the file

fclose($handle);
  
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);         

}


  	  
  $conn = ConnectionManager::get('default');
     $peopleTable = TableRegistry::get ('Studentexamresult');
$oquery = $peopleTable->query();

$subject=0;

$subject=$data['Subject'];


$fgh=0; 
$examdetails = $this->Examdetails->find('all')->contain(['ExamSubjects'])->where(['Examdetails.exam_id'=>$exid])->order(['Examdetails.id'=>'asc'])->toarray();


foreach ($data['Exam'] as $key =>$value) 
{
foreach($subject as $id=>$smarks){
if($key==$id){
	
	$idsss=key($smarks); 
	$fghsss = explode('(',$idsss);
$smarksss=array_values($smarks);


$subjectclasses_data = $this->ExamSubjects->find('all')->where(['class_id'=>$class_id,'subject'=>$fghsss[0]])->first();
$examt = $this->Exams->find('all')->where(['Exams.id' =>$exid])->order(['Exams.id' => 'asc'])->first();    


  $examtypesss = $this->Examtypes->find('all')->where(['Examtypes.name' =>$value,'FIND_IN_SET(\''. $class_id .'\',class_id)'])->order(['Examtypes.id' => 'asc'])->first();   

   	  
if($examt['termf']=='1' || $examt['termf']=='2'){
						if($class_id=='12' || $class_id=='13' || $class_id=='15' || $class_id=='17' || $class_id=='20'  || $class_id=='22'){
							if($examtypesss['id']=='32'){
								 
								 
								 
								 
								 $examtypesss['maxnumber']=$subjectclasses_data['practicalmarks'];
								
							}else{
								 
							if($examtypesss['id']=='31'){
								 
								 $examtypesss['maxnumber']=$subjectclasses_data['theorymarks'];
									
								}else{
									
										 $examtypesss['maxnumber']=$examtypesss['maxnumber'];
									
								}
									
								
							}
						}else{
							
							
							if($fghsss[0]=="ComputerScience" && $class_id=='11' && $examt['termf']=='2'){
									 $examtypesss['maxnumber']='80';
									 
								 }else{
									 
									  $examtypesss['maxnumber']=$examtypesss['maxnumber'];
									 
								 }
							
						}
						
					}else{
									 $examtypesss['maxnumber']=$examtypesss['maxnumber'];
							
						}
$smarksss[0]=trim($smarksss[0]);


	if($smarksss[0]=="A"){
	
	}else if($smarksss[0]=="N"){


	
}else if($smarksss[0]=='0'){ 


        }else if($examtypesss['maxnumber']<$smarksss[0] || $smarksss[0]<'0'){ 

$this->Flash->error(__('Please Check Inserted Marks In File (Kindly Uploaded Marks Cannot Be Negative or Exceed Maximum Marks) !!!'), 'flash/error');

fclose($handle);

return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);
 
        }
        
       
	}
     
  	  }
}


foreach($subject as $ids=>$markss){
$idss=key($markss); 
	$fghs = explode('(',$idss);

	if(!in_array($fghs[0],$sss)){
		
	$tech_id=$this->request->session()->read('Auth.User.tech_id');

	$this->Flash->error(__('Use Correct Login Id For Upload CSV !!!'), 'flash/error');
 // close the file
       fclose($handle);
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);  
		
	}
	
$subjectclasses_datas = $this->ExamSubjects->find('all')->where(['class_id'=>$class_id,'subject' =>$fghs[0]])->first();
if($subjectclasses_datas['id']=="28" || $subjectclasses_datas['id']=="29" 
|| $subjectclasses_datas['id']=="37" || 
$subjectclasses_datas['id']=="38"){
	
	if($con=='0'){
		
		$subh=$subjectclasses_datas['id'];
	
 }
}

}



foreach ($data['Exam'] as $key =>$value) 
{
foreach($subject as $id=>$marks){
	
	if($key==$id){
$idsss=key($marks); 
	$fgh = explode('(',$idsss);
	$smarsksss=array_values($marks);
	$smarsksss[0]=trim($smarsksss[0]);
	if($smarsksss[0]=="A"){
		$smarsksss[0]=$smarsksss[0];
	}else if($smarsksss[0]=="N"){
		$smarsksss[0]=$smarsksss[0];
	}else if($smarsksss[0]=="0"){
		$smarsksss[0]=$smarsksss[0];
	}else{
		$smarsksss[0]=round($smarsksss[0]);
		
	}

	if(!in_array($fgh[0],$sss)){
		
		$tech_id=$this->request->session()->read('Auth.User.tech_id');
	
		$this->Flash->error(__('Use Correct Login Id For Upload File !!!'), 'flash/error');
 // close the file
        fclose($handle);
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);
		
	}
	
		$subjectclasses_data = $this->ExamSubjects->find('all')->where(['class_id'=>$class_id,'subject'=>$fgh[0]])->first();

		$examdetails = $this->Examdetails->find('all')->contain(['ExamSubjects'])->where(['Examdetails.class_id' =>$class_id,'Examdetails.exam_id' =>$exid,'Examdetails.subject_id'=>$subjectclasses_data['id']])->order(['Examdetails.id' => 'asc'])->first();

$classes_data = $this->Classes->find('all')->where(['title' =>$data['Class']])->first();
$classid=$classes_data['id'];
$section_data=$this->Sections->find('all')->where(['title' =>$data['Section']])->first();
$sectionid=$section_data['id'];

if($examdetails['id']==""){


$this->Flash->error(__('Please Check Inserted Subject In Uploaded File !!!'), 'flash/error');
 // close the file
        fclose($handle);


				$tech_id=$this->request->session()->read('Auth.User.tech_id');
	
		
	
 
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);



}else{

if($classid==$class_id && $sectionid==$sect_id){

$tech_id=$this->request->session()->read('Auth.User.tech_id');

if($tech_id==''){
	
	$this->Flash->error(__('Please Check Login From Correct ID !!!)'), 'flash/error');
 // close the file
        fclose($handle);
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);
}else{
	
	
$students_data = $this->Students->find('all')->where(['enroll' =>trim($data['SrNo']),'class_id' =>$class_id,'section_id' =>$sect_id,'status'=>'Y'])->first();
	$exs = $this->Examtypes->find('all')->where(['Examtypes.name'=>$value,'FIND_IN_SET(\''. $class_id .'\',class_id)'])->order(['Examtypes.id' => 'asc'])->first(); 
	
	
if($students_data['id']){


}else{
$this->Flash->error(__('Please Check Inserted Students Marks Entry Infromation Correct ???'), 'flash/error');
 // close the file
 

        fclose($handle);
        	
	return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);	


}

}
		}else{
		
	$this->Flash->error(__('Please Check Inserted Class or Section !!!'), 'flash/error');
 // close the file
        fclose($handle);
        	
	return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);	
		}
		
		}

	
	} }  }
	

         
	$con++;   
        }
        
        if($d){
      // $this->Flash->success(__('File Uploaded Successfully !!!'), 'flash/sucess');	
      }
        // close the file
        fclose($handle);

        // return the messages
        
    
        return $return;

         }
         





	public function csv2($filename,$exid,$sect_id,$class_id,$query,$subj,$subj1) {

	$this->loadModel('Studentexamresult');
	
		$this->loadModel('ExamSubjects');
				$this->loadModel('Subjects');
						$this->loadModel('ClasstimeTabs');
							$this->loadModel('Classections');
          $documents = $this->Studentexamresult->newEntity();
        //$filename = TMP . 'uploads' . DS . $filename;
         $filename=WWW_ROOT.'excel_file/' . $filename; 

        // open the file
        $handle = fopen($filename, "r") or die ("Nothing");
 
        // read the 1st row as headings
        $header = fgetcsv($handle);

         
        // create a message container
        $return = array(
            'messages' => array(),
            'errors' => array(),
        );
 
 
 $empid= $this->request->session()->read('Auth.User.tech_id');


 $role_id=$this->request->session()->read('Auth.User.role_id');
 if($role_id=='3'){

$csec = $this->ClasstimeTabs->find('all')->contain(['Classections'])->where(['FIND_IN_SET(\''. $empid .'\',ClasstimeTabs.employee_id)','Classections.class_id'=>$class_id,'Classections.section_id'=>$sect_id])->toarray();

foreach ($csec as $key => $value)
{
	$empo=explode(',',$value['employee_id']);
		$subjects=explode(',',$value['subject_id']);
		
		foreach($empo as $j=>$t){
			
			foreach($subjects as $sj=>$st){
				
				if($j==$sj && $t==$empid){
			
				
					$csec = $this->Subjects->find('all')->where(['id'=>$st])->first();
					
					if(($class_id=="11" || $class_id=="10" ) && ($st=="66" || $st=="67" || $st=="68")){
						
						$sb[] = str_replace(' ', '', "Science");
						
					}else if(($class_id=="11" || $class_id=="10")  && ($st=="65" || $st=="70" || $st=="71")){
						
						$sb[] = str_replace(' ', '', "Social Science");
						
					}else if(($class_id=='3' || $class_id=='4' || $class_id=='6') && ($st=='1')){
					
						$sb[] = "Maths";
					
					}else{
					$sb[] = str_replace(' ', '', $csec['name']);
					
				}
				}
				
			}	
			
		}
	

}


$tech_id=$this->request->session()->read('Auth.User.tech_id');
	
		
$sss=array_unique($sb);
 
 
}
 
 
 $std_result_status = $this->Studentexamresult->find('all')->where(['Studentexamresult.exam_id' =>$exid,'Studentexamresult.class_id' =>$class_id,'Studentexamresult.sect_id' =>$sect_id])->first();

 
 $role_id=$this->request->session()->read('Auth.User.role_id');
 if($std_result_status['id']){
	  $conn = ConnectionManager::get('default'); 
    if($role_id=='3'){
		 $tech_id=$this->request->session()->read('Auth.User.tech_id');
		
	$conn->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND teach_id='".$tech_id."' AND sect_id='".$sect_id."' AND subject_id='".$subj."'"); 	
	
	$connl = ConnectionManager::get('default'); 
	 $connl->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND sect_id='".$sect_id."' AND coordinator_id !='0' AND subject_id='".$subj."'"); 
		
	}else{
		
    $conn->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND sect_id='".$sect_id."' AND subject_id='".$subj."'"); 
}
	 
	 
 }
if(sizeof($header)==1){
        $field = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $header[0]);

$header = explode(",",$field);

}


 $this->request->data=0;


        $con=0;
        while (($row = fgetcsv($handle)) !== FALSE) {
    
            $data = array();
            if(sizeof($row)==1){
   $row = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $row[0]);
	 			$row = explode(",",$row);
			}
            // for each header field

            foreach ($header as $k=>$head) {
		
  if (strpos($head,'-')!==false) {
                    $h = explode('-',$head);
                  $data['Exam'][]=$h[0];
                   $data['Subject'][][$h[1]]=(isset($row[$k])) ? $row[$k] : ',';
                   

                }else{
                    $data[$head]=(isset($row[$k])) ? $row[$k] : ',';
                    
                    
               $this->request->data[$head]=(isset($row[$k])) ? $row[$k] : ',';

		   }
		  

            }
       
       
         if($data['SrNo']=='' ||  $data['Name']=='' ||  $data['Class']=='' ||  $data['Section']==''){

			  $this->Flash->error(__('Please Make Sure That Student Information are Correct ????'), 'flash/error');

        fclose($handle);

  
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);
			 
		 }	
         $classes_data = $this->Classes->find('all')->where(['title' =>$data['Class']])->first();
$classid=$classes_data['id'];
$section_data = $this->Sections->find('all')->where(['title' =>$data['Section']])->first();
$sectionid=$section_data['id'];
 $stddat = $this->Students->find('all')->where(['Students.enroll'=>trim($data['SrNo']),'Students.class_id'=>$classid,'Students.section_id' =>$sectionid,'Students.status'=>'Y'])->first();

 if($stddat['id']==''){
	 
	 
	 $conn = ConnectionManager::get('default'); 
    if($role_id=='3'){
		 $tech_id=$this->request->session()->read('Auth.User.tech_id');
		
	 $conn->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND teach_id='".$tech_id."' AND sect_id='".$sect_id."' AND subject_id='".$subj."'"); 	
	 
	 	$connl = ConnectionManager::get('default'); 
	 $connl->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND sect_id='".$sect_id."' AND coordinator_id !='0' AND subject_id='".$subj."'"); 
		
	}else{
		
     $conn->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND sect_id='".$sect_id."' AND subject_id='".$subj."'"); 
}
	   $this->Flash->error(__('Please Make Sure That Student Information are Correct ????'), 'flash/error');

        fclose($handle);

  
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);
	 
 }

         $examtypess = $this->Examtypes->find('all')->where(['FIND_IN_SET(\''. $class_id .'\',class_id)','Examtypes.name IN'=>$data['Exam']])->order(['Examtypes.id' => 'asc'])->first();    	  
         
  
      $examt = $this->Exams->find('all')->where(['Exams.id' =>$exid])->order(['Exams.id' => 'asc'])->first();    	  
    $etypeidd=explode(',',$examt['e_type_id']);
    

    

          if(!in_array($examtypess['id'],$etypeidd)){
          
          $conn = ConnectionManager::get('default'); 
    if($role_id=='3'){
		 $tech_id=$this->request->session()->read('Auth.User.tech_id');
		
	 $conn->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND teach_id='".$tech_id."' AND sect_id='".$sect_id."' AND subject_id='".$subj."'"); 	
	 	 	$connl = ConnectionManager::get('default'); 
	 $connl->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND sect_id='".$sect_id."' AND coordinator_id !='0' AND subject_id='".$subj."'"); 
		
	}else{
		
     $conn->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND sect_id='".$sect_id."' AND subject_id='".$subj."'"); 
}
          $this->Flash->error(__('Please Make Sure That Inserted Exam Heading Are Same as Sample File ???'), 'flash/error');
 // close the file
        fclose($handle);

  
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);

}


  	  
            	     $conn = ConnectionManager::get('default');
            	    $peopleTable = TableRegistry::get ('Studentexamresult');
$oquery = $peopleTable->query();

$subject=0;

$subject=$data['Subject'];

//pr($data['Subject']['Hindi(20)']); die;
$fgh=0; 
$examdetails = $this->Examdetails->find('all')->contain(['ExamSubjects'])->where(['Examdetails.exam_id'=>$exid])->order(['Examdetails.id'=>'asc'])->toarray();


foreach ($data['Exam'] as $key =>$value) 
{
foreach($subject as $id=>$smarks){
if($key==$id){
	
	$idsss=key($smarks); 
	$fghsss = explode('(',$idsss);
$smarksss=array_values($smarks);


$subjectclasses_data = $this->ExamSubjects->find('all')->where(['class_id'=>$class_id,'subject'=>$fghsss[0]])->first();
$examt = $this->Exams->find('all')->where(['Exams.id' =>$exid])->order(['Exams.id' => 'asc'])->first();    


  $examtypesss = $this->Examtypes->find('all')->where(['Examtypes.name' =>$value,'FIND_IN_SET(\''. $class_id .'\',class_id)'])->order(['Examtypes.id' => 'asc'])->first();   

   	  
if($examt['termf']=='1' || $examt['termf']=='2'){
						if($class_id=='12' || $class_id=='13' || $class_id=='15' || $class_id=='17' || $class_id=='20'  || $class_id=='22'){
							if($examtypesss['id']=='32'){
								 
								 
								 
								 
								 $examtypesss['maxnumber']=$subjectclasses_data['practicalmarks'];
								
							}else{
								
								if($examtypesss['id']=='31'){
								 
								 $examtypesss['maxnumber']=$subjectclasses_data['theorymarks'];
									
								}else{
									
										 $examtypesss['maxnumber']=$examtypesss['maxnumber'];
									
								}
							}
						}else{
									 $examtypesss['maxnumber']=$examtypesss['maxnumber'];
							
						}
						
					}else{
									 $examtypesss['maxnumber']=$examtypesss['maxnumber'];
							
						}
$smarksss[0]=trim($smarksss[0]);


	if($smarksss[0]=="A"){
	
	}else if($smarksss[0]=="N"){


	
}else if($smarksss[0]=='0'){ 

//~ $this->Flash->error(__('Please Check Inserted Marks In File (Kindly Uploaded Marks Cannot Be Negative or Blank or Exceed Maximum Marks) !!!'), 'flash/error');
 //~ // close the file
        //~ fclose($handle);
 //~ if($role_id=='3'){
		//~ $tech_id=$this->request->session()->read('Auth.User.tech_id');
	 //~ $conn->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND teach_id='".$tech_id."' AND sect_id='".$sect_id."'  AND subject_id='".$subj."'"); 	
		
	//~ }else{
  //~ $oquery="DELETE FROM `studentexamresult` WHERE `studentexamresult`.`class_id` =$class_id AND  `studentexamresult`.`exam_id` =$exid AND `studentexamresult`.`sect_id` =$sect_id  AND `studentexamresult`.`subject_id` =$subj";
  
//~ }
 //~ $results1 = $conn->execute($oquery); 
//~ return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);

//$examtypesss['maxnumber']<$smarksss[0] || 
        }else if($smarksss[0]<'0'){ 
//~ echo $examtypesss['maxnumber']; echo $smarksss[0]; die;
$this->Flash->error(__('Please Check Inserted Marks In File (Kindly Uploaded Marks Cannot Be Negative or Exceed Maximum Marks) !!!'), 'flash/error');
 // close the file
        fclose($handle);
 if($role_id=='3'){
		$tech_id=$this->request->session()->read('Auth.User.tech_id');
	 $conn->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND teach_id='".$tech_id."' AND sect_id='".$sect_id."'  AND subject_id='".$subj."'"); 	
	 	 	$connl = ConnectionManager::get('default'); 
	 $connl->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND sect_id='".$sect_id."' AND coordinator_id !='0' AND subject_id='".$subj."'"); 
		
	}else{
  $oquery="DELETE FROM `studentexamresult` WHERE `studentexamresult`.`class_id` =$class_id AND  `studentexamresult`.`exam_id` =$exid AND `studentexamresult`.`sect_id` =$sect_id   AND `studentexamresult`.`subject_id` =$subj";
  
}
 $results1 = $conn->execute($oquery); 
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);
        }
        
       
	}
     
  	  }
}


foreach($subject as $ids=>$markss){
$idss=key($markss); 
	$fghs = explode('(',$idss);
	
	if(!in_array($fghs[0],$sss)){
		
		$tech_id=$this->request->session()->read('Auth.User.tech_id');
	 $conn->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND teach_id='".$tech_id."' AND sect_id='".$sect_id."'  AND subject_id='".$subj."'"); 	
	 
	 	 	$connl = ConnectionManager::get('default'); 
	 $connl->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND sect_id='".$sect_id."' AND coordinator_id !='0' AND subject_id='".$subj."'"); 
	 
		$results1 = $conn->execute($oquery); 
		$this->Flash->error(__('Use Correct Login Id For Upload CSV !!!'), 'flash/error');
 // close the file
        fclose($handle);
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);
		
	}
	
$subjectclasses_datas = $this->ExamSubjects->find('all')->where(['class_id'=>$class_id,'subject' =>$fghs[0]])->first();
if($subjectclasses_datas['id']=="28" || $subjectclasses_datas['id']=="29" 
|| $subjectclasses_datas['id']=="37" || 
$subjectclasses_datas['id']=="38"){
	
	if($con=='0'){
		
		$subh=$subjectclasses_datas['id'];
	 $conn->execute("DELETE FROM `studentexamresult` WHERE 
	 `studentexamresult`.`class_id` =$class_id AND  
	 `studentexamresult`.`exam_id` =$exid AND  
	 `studentexamresult`.`subject_id` =$subh AND `studentexamresult`.`sect_id` =$sect_id");
	 
	 
	 	 	$connl = ConnectionManager::get('default'); 
	 $connl->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND sect_id='".$sect_id."' AND coordinator_id !='0' AND subject_id='".$subh."'"); 
 }
}

}



foreach ($data['Exam'] as $key =>$value) 
{
foreach($subject as $id=>$marks){
	
	if($key==$id){
$idsss=key($marks); 
	$fgh = explode('(',$idsss);
	$smarsksss=array_values($marks);
	$smarsksss[0]=trim($smarsksss[0]);
	if($smarsksss[0]=="A"){
		$smarsksss[0]=$smarsksss[0];
	}else if($smarsksss[0]=="N"){
		$smarsksss[0]=$smarsksss[0];
	}else if($smarsksss[0]=="0"){
		$smarsksss[0]=$smarsksss[0];
	}else{
		$smarsksss[0]=round($smarsksss[0]);
		
	}

	if(!in_array($fgh[0],$sss)){
		
		$tech_id=$this->request->session()->read('Auth.User.tech_id');
	 $conn->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND teach_id='".$tech_id."' AND sect_id='".$sect_id."'  AND subject_id='".$subj."'"); 	
	  	$connl = ConnectionManager::get('default'); 
	 $connl->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND sect_id='".$sect_id."' AND coordinator_id !='0' AND subject_id='".$subj."'"); 
		$results1 = $conn->execute($oquery); 
		$this->Flash->error(__('Use Correct Login Id For Upload File !!!'), 'flash/error');
 // close the file
        fclose($handle);
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);
		
	}
	
		$subjectclasses_data = $this->ExamSubjects->find('all')->where(['class_id'=>$class_id,'subject'=>$fgh[0]])->first();

		$examdetails = $this->Examdetails->find('all')->contain(['ExamSubjects'])->where(['Examdetails.class_id' =>$class_id,'Examdetails.exam_id' =>$exid,'Examdetails.subject_id'=>$subjectclasses_data['id']])->order(['Examdetails.id' => 'asc'])->first();

$classes_data = $this->Classes->find('all')->where(['title' =>$data['Class']])->first();
$classid=$classes_data['id'];
$section_data=$this->Sections->find('all')->where(['title' =>$data['Section']])->first();
$sectionid=$section_data['id'];

if($examdetails['id']==""){



$this->Flash->error(__('Please Check Inserted Subject In Uploaded File !!!'), 'flash/error');
 // close the file
        fclose($handle);

 if($role_id=='3'){
				$tech_id=$this->request->session()->read('Auth.User.tech_id');
	 $conn->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND teach_id='".$tech_id."' AND sect_id='".$sect_id."'   AND subject_id='".$subj."'"); 	
	 
	   	$connl = ConnectionManager::get('default'); 
	 $connl->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND sect_id='".$sect_id."' AND coordinator_id !='0' AND subject_id='".$subj."'"); 
		
	}else{
  $oquery="DELETE FROM `studentexamresult` WHERE `studentexamresult`.`class_id` =$class_id AND  `studentexamresult`.`exam_id` =$exid AND `studentexamresult`.`sect_id` =$sect_id  AND `studentexamresult`.`subject_id` =$subj";
  
}
 $results1 = $conn->execute($oquery);
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);



}else{

if($classid==$class_id && $sectionid==$sect_id){

$tech_id=$this->request->session()->read('Auth.User.tech_id');

if($tech_id==''){
	
	$this->Flash->error(__('Please Check Login From Correct ID !!!)'), 'flash/error');
 // close the file
        fclose($handle);
return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);
}else{
	
	
$students_data = $this->Students->find('all')->where(['enroll' =>trim($data['SrNo']),'class_id' =>$class_id,'section_id' =>$sect_id,'status'=>'Y'])->first();
	$exs = $this->Examtypes->find('all')->where(['Examtypes.name'=>$value,'FIND_IN_SET(\''. $class_id .'\',class_id)'])->order(['Examtypes.id' => 'asc'])->first(); 
	      $examt = $this->Exams->find('all')->where(['Exams.id' =>$exid])->order(['Exams.id' => 'asc'])->first();    
	
if($students_data['id']){
$oquery->insert (['stud_id','exam_id','etype_id','class_id','subject_id','marks','sect_id','teach_id','term'])
        ->values (['stud_id' =>$students_data['id'],'exam_id' =>$exid,'etype_id' =>$exs['id'],'class_id' =>$class_id,'subject_id'=>$subjectclasses_data['id'],'marks'=>$smarsksss[0],'sect_id'=>$sect_id,'teach_id'=>$tech_id,'term'=>$examt['termf']]); 
       


}else{
$this->Flash->error(__('Please Check Inserted Students Marks Entry Infromation Correct ???'), 'flash/error');
 // close the file
  if($role_id=='3'){
		$tech_id=$this->request->session()->read('Auth.User.tech_id');
	 $conn->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND teach_id='".$tech_id."' AND sect_id='".$sect_id."'   AND subject_id='".$subj."'"); 	
	 
	    	$connl = ConnectionManager::get('default'); 
	 $connl->execute("DELETE FROM studentexamresult WHERE exam_id='".$exid."' AND class_id='".$class_id."' AND sect_id='".$sect_id."' AND coordinator_id !='0' AND subject_id='".$subj."'"); 
		
	}else{
  $oquery="DELETE FROM `studentexamresult` WHERE `studentexamresult`.`class_id` =$class_id  AND  `studentexamresult`.`exam_id` =$exid AND `studentexamresult`.`sect_id` =$sect_id  AND `studentexamresult`.`subject_id` =$subj";
  
}
 $results1 = $conn->execute($oquery);
        fclose($handle);
        	
	return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);	


}

}
		}else{
		
	$this->Flash->error(__('Please Check Inserted Class or Section !!!'), 'flash/error');
 // close the file
        fclose($handle);
        	
	return $this->redirect(['action' => 'addcsv/'.$exid.'/'.$sect_id.'/'.$class_id.'/'.$subj1]);	
		}
		
		}

	
	} }  }
	
    $d=$oquery->execute();
         
	$con++;   
        }
        
        if($d){
       $this->Flash->success(__('Changes has been done ,File Uploaded Successfully !!!'), 'flash/sucess');	
      }
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
			
	$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);
	
	}
	




public function find_etype(){
	
	$classid=$this->request->data['id']; 
	   	$this->viewBuilder()->layout('admin');
	

		$usersf = $this->Users->find('all')->where(['Users.id' =>'1'])->first();
		// pr($locations); die;
$examtypes = $this->Examtypes->find('list', [
    'keyField' => 'id',
    'valueField' => 'examname'
])->where(['FIND_IN_SET(\''. $classid .'\',class_id)','status'=>'Y','term'=>$usersf['examterm']])->group(['examname'])->order(['sort' => 'ASC'])->toArray();

	echo " <label>Select Exam</label>
	<select name='examtypesi'  required='required' class='form-control'>
	<option value=''>All Exam</option>";
		
		foreach($examtypes as $sections=>$value){
			echo "<option value=".$sections.">".$value."</option>";
		} die;
	

	
	
	}
	
	
	public function findetypeid($name=null,$maxnumber=null,$classid=null){
		
		  $articles = TableRegistry::get('Examtypes');

return  $articles->find('all')->where(['FIND_IN_SET(\''. $classid 
.'\',class_id)','name'=>$name,'maxnumber'=>$maxnumber,'status'=>'Y'])->order(['sort' => 'ASC'])->first();


	}
	public function findexamsubject($name=null,$classid=null){
		
		  $articles = TableRegistry::get('ExamSubjects');

return  $articles->find('all')->where(['exprint'=>$name,'class_id'=>$classid])->order(['sort' => 'ASC'])->first();


	}
	
	
	
	public function totalabsence($id=null,$sid=null,$lid=null,$clasid=null) {
		 $this->loadModel('User');
		   $this->loadModel('Exams');
		$this->loadModel('Employees');
		$this->loadModel('ClasstimeTabs');
		$this->loadModel('Classections');
       
        
       $this->autoRender=false;
  	
	
		
		$conn = ConnectionManager::get('default');
	
 $detail="SELECT Studentexamresult.id AS `Studentexamresult__id`, 
 Studentexamresult.stud_id AS `Studentexamresult__stud_id`, 
 Studentexamresult.exam_id AS `Studentexamresult__exam_id`, 
 Studentexamresult.subject_id AS `Studentexamresult__subject_id`, 
 Studentexamresult.marks AS `Studentexamresult__marks`, 
 Studentexamresult.teach_id AS `Studentexamresult__teach_id`, 
 Studentexamresult.created AS `Studentexamresult__created`, 
 Studentexamresult.sect_id AS `Studentexamresult__sect_id`, 
 Studentexamresult.class_id AS `Studentexamresult__class_id`, 
 Studentexamresult.status AS `Studentexamresult__status`, Students.id 
 AS `Students__id`, Students.fname AS `Students__fname`, 
 Students.middlename AS `Students__middlename`, Students.lname AS 
 `Students__lname`, Students.fee_submittedby AS 
 `Students__fee_submittedby`, Students.board_id AS 
 `Students__board_id`, Students.fathername AS `Students__fathername`, 
 Students.mothername AS `Students__mothername`, Students.username AS 
 `Students__username`, Students.password AS `Students__password`, 
 Students.dob AS `Students__dob`, Students.enroll AS 
 `Students__enroll`, Students.mobile AS `Students__mobile`, 
 Students.mobile2 AS `Students__mobile2`, Students.sms_mobile AS 
 `Students__sms_mobile`, Students.formno AS `Students__formno`, 
 Students.adaharnumber AS `Students__adaharnumber`, Students.cast AS 
 `Students__cast`, Students.parent_id AS `Students__parent_id`, 
 Students.house_id AS `Students__house_id`, Students.class_id AS 
 `Students__class_id`, Students.category AS `Students__category`, 
 Students.section_id AS `Students__section_id`, Students.gender AS 
 `Students__gender`, Students.photo AS `Students__photo`, 
 Students.bloodgroup AS `Students__bloodgroup`, Students.religion AS 
 `Students__religion`, Students.address AS `Students__address`, 
 Students.city AS `Students__city`, Students.nationality AS 
 `Students__nationality`, Students.created AS `Students__created`, 
 Students.admissionyear AS `Students__admissionyear`, 
 Students.acedmicyear AS `Students__acedmicyear`, Students.status AS 
 `Students__status`, Students.file AS `Students__file`, 
 Students.comp_sid AS `Students__comp_sid`, Students.opt_sid AS `Students__opt_sid`, Students.h_id AS `Students__h_id`, Students.room_no AS `Students__room_no`, Students.is_transport AS `Students__is_transport`, Students.transportloc_id AS `Students__transportloc_id`, Students.v_num AS `Students__v_num`, Students.dis_fees AS `Students__dis_fees`, Students.dis_transport AS `Students__dis_transport`, Students.is_discount AS `Students__is_discount`, Students.discountcategory AS `Students__discountcategory`, Students.due_fees AS `Students__due_fees`, Students.token AS `Students__token`, Students.rf_id AS `Students__rf_id` FROM studentexamresult Studentexamresult INNER JOIN students Students ON Students.id = (Studentexamresult.stud_id) WHERE (  Students.status ='Y' AND Studentexamresult.marks ='A') GROUP BY Studentexamresult.`stud_id` ORDER BY Studentexamresult.class_id ASC,Students.fname ASC";
 	
		




   $SQL = $detail;  
   
   

$data = $conn->execute( $SQL )->fetchAll('assoc');




 $delimiter = ",";
    $filename = "members_" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $er=array();
    $fields = array('SrNo', 'Name','Class','Section');
    foreach ($data  as $key){ 
    $subject=$this->findsubjecttoexam($key['Studentexamresult__exam_id'],$key['Studentexamresult__class_id']); 
    $findroleexamtype2=$this->findeexamtsype($key['Studentexamresult__exam_id'],$key['Studentexamresult__sect_id'],$key['Studentexamresult__class_id']);


	   foreach($findroleexamtype2 as $er){  
		   
		   $findetypname=$this->findsubjectstotalssnames2($er['etype_id']);
		   

		foreach($subject as $works){
			
			 
			$var[]=$findetypname['name']."-".$works['exam_subject']['exprint']."-".$findetypname['maxnumber']; 
	
			
				
		} }

}



$var=array_unique($var);

$_header = array_merge($fields, $var);


    fputcsv($f, $_header, $delimiter);
    
    if(isset($data) && !empty($data)){ 
               
                foreach ($data  as $key){
					$vars=array(); 
					$ctitle = $this->Classes->find('all')->where(['Classes.id'=>$key['Studentexamresult__class_id']])->first(); 
						$stitle = $this->Sections->find('all')->where(['Sections.id'=>$key['Studentexamresult__sect_id']])->first(); 
    $lineDatas = array($key['Students__enroll'], 
    $key['Students__fname'],$ctitle['title'],$stitle['title']);
    
foreach($var as $k){
	$fg=explode('-',$k);
	
	$etypeid=$this->findetypeid($fg[0],$fg[2],$key['Studentexamresult__class_id']);
	$examsubjectid=$this->findexamsubject($fg[1],$key['Studentexamresult__class_id']);
	
				
				$findvlues=$this->findsubjectvalue($examsubjectid['id'],$key['Studentexamresult__class_id'],$key['Studentexamresult__exam_id'],$key['Studentexamresult__stud_id'],$key['Studentexamresult__sect_id'],$etypeid['id']); 
				
				if($findvlues['marks']=='A'){
				$vars[]='A';
				
			}else{
					$vars[]='--';
				
			}
			 
		}
		
		 $lineData = array_merge($lineDatas, $vars);
        fputcsv($f, $lineData, $delimiter);
  
	
	}
		
   			}

   		
   		  //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
die;
		

	
}

  public function findsubjectvalue($subject,$cid,$examid,$stud_id,$sect,$typeid)
{
      // pr ($rout); die;
        // Use the HTML helper to output
        // Formatted data:
        $articles = TableRegistry::get('Studentexamresult');

// Start a new query.

return   $articles->find('all')->where(['sect_id' => $sect,'class_id' =>$cid,'stud_id' =>$stud_id,'exam_id' =>$examid,'subject_id' =>$subject,'etype_id' =>$typeid])->first();
    }
	 public function findsubjecttoexam($exid,$classid){
    
      $articles = TableRegistry::get('Studentexamresult');

// Start a new query.

  
         return  $articles->find('all')->contain(['ExamSubjects'])->where(['Studentexamresult.class_id'=>$classid,'Studentexamresult.exam_id' =>$exid])->group(['Studentexamresult.subject_id'])->order(['ExamSubjects.id'=>'ASC'])->toarray();
    
    }
    
	 public function findeexamtsype($exid=null,$section=null,$classid=null){
		
		      $articles = TableRegistry::get('Studentexamresult');

 
    return   $articles->find('all')->contain(['Exams','ExamSubjects'])->where(['Studentexamresult.exam_id'=>$exid,'Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section])->group(['Studentexamresult.etype_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
		
	}
	
	 public function findeexamtsype2($section=null,$classid=null,$term=null){
		
		      $articles = TableRegistry::get('Studentexamresult');

 
    return   $articles->find('all')->contain(['Exams','ExamSubjects'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.term' =>$term])->group(['Studentexamresult.etype_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
		
	}
    
	  public function findsubjectstotalssnames2($id=null)
{
     
        $articles = TableRegistry::get('Examtypes');

return  $articles->find('all')->where(['Examtypes.id' => $id])->select(['name','ename','id','maxnumber','examname'])->order(['Examtypes.id' => 'asc'])->first();


    }
	
	public function export($id=null,$sid=null,$lid=null,$clasid=null,$subjec=null){
		 $this->loadModel('User');
		   $this->loadModel('Exams');
		$this->loadModel('Employees');
		$this->loadModel('ClasstimeTabs');
		$this->loadModel('Classections');
       $sb=array(); $cid=array();
       
       
     
		$examtypes = $this->Exams->find('all')->where(['id' =>$id,'e_type_id IN'=>$lid])->order(['id' => 'asc'])->first();
		
			
		$examdetails = $this->Examdetails->find('all')->contain(['ExamSubjects'])->where(['Examdetails.exam_id' =>$id,'Examdetails.class_id'=>$clasid])->order(['Examdetails.id' => 'asc'])->toarray();
		  $lid=explode(',',$lid);
		
		  if($clasid==10 && $id==37){

			$examtypess = $this->Examtypes->find('all')->where(['Examtypes.id IN' =>$lid])->order(['Examtypes.sort' => 'asc'])->toarray();

		  }else{
		$examtypess = $this->Examtypes->find('all')->where(['Examtypes.id IN' =>$lid])->order(['Examtypes.id' => 'asc'])->toarray();

		  }

        $roleid=$this->request->session()->read('Auth.User.role_id');
        
        if($roleid=='3')
        {
			
			
		$empid= $this->request->session()->read('Auth.User.tech_id');




$csec = $this->ClasstimeTabs->find('all')->contain(['Classections'])->where(['FIND_IN_SET(\''. $empid .'\',ClasstimeTabs.employee_id)','Classections.class_id'=>$clasid,'Classections.section_id'=>$sid])->toarray();

foreach ($csec as $key => $value)
{
	$empo=explode(',',$value['employee_id']);
		$subjects=explode(',',$value['subject_id']);

		foreach($empo as $j=>$t){
	
			foreach($subjects as $sj=>$st){
				if($j==$sj && $t==$empid){
				
				
			
			
					if(($clasid=="11" || $clasid=="10") && ($st=="66" || $st=="67" || $st=="68")){
						if($st==$subjec){
						$sb[] = str_replace(' ', '', "Science");
					}else{
						
							$sb[] = str_replace(' ', '', "Science");
						
					}
					}else if(($clasid=="11" || $clasid=="10") && ($st=="65" || $st=="70" || $st=="71")){
					
						$sb[] = str_replace(' ', '', "Social Science");
					
					}else if(($clasid=='3' || $clasid=='4' || $clasid=='6') && ($st=='1')){
					
						$sb[] = "Maths";
					
					}else{
						if($st==$subjec){
								$csec = $this->Subjects->find('all')->where(['id'=>$st])->first();
					$sb[] = str_replace(' ', '', $csec['name']);
					
				}
					
				}
				}
				
			}
				
			
		}
	

}

$tech_id=$this->request->session()->read('Auth.User.tech_id');
	
		
$sss=array_unique($sb);

if($subjec){
				$csec = $this->Subjects->find('all')->where(['id'=>$subjec])->first();
				$ssss = $csec['name'];
					
				}
if(in_array($ssss,$sss)){
	
	$sss=array();
	$sss[]=$ssss;
	
	
}



  $examdetails = $this->Examdetails->find('all')->contain(['ExamSubjects'])->where(['ExamSubjects.subject IN' =>$sss,'Examdetails.class_id' =>$clasid,'Examdetails.exam_id' =>$id])->order(['ExamSubjects.sort' => 'asc'])->toarray(); 
  


  foreach($examdetails as $key=>$value){
				foreach($examtypess as $g=>$hh){
					
				
					if($examtypes['termf']=='1' || $examtypes['termf']=='2'){
						if($clasid=='12' || $clasid=='13' || $clasid=='15' || $clasid=='17' || $clasid=='20'  || $clasid=='22'){
							
						
							if($hh->id=='32'){
								
									if($value->exam_subject->practicalmarks !=0){
								$var[]= $hh->name."-".$value->exam_subject->subject."(".$value->exam_subject->practicalmarks.")";
								
							}
								
							}else{
								
									if($hh->id=='31'){
									$var[]= $hh->name."-".$value->exam_subject->subject."(".$value->exam_subject->theorymarks.")";
								
							}
							
								if($hh->id=='30'){
									$var[]= $hh->name."-".$value->exam_subject->subject."(".$hh->maxnumber.")";
								
							}
							
							
							
							}
							
						
						}else{
							
							if($value->exam_subject->subject=='ComputerScience' && $value->exam_subject->class_id=='11' && $examtypes['termf']=='2'){
								
									$var[]= $hh->name."-".$value->exam_subject->subject."(80)";
							}else{
									$var[]= $hh->name."-".$value->exam_subject->subject."(".$hh->maxnumber.")";
								
								
								
							}
								
							
						}
						
					}else{
							if($value->exam_subject->subject=='ComputerScience' && $value->exam_subject->class_id=='11' && $examtypes['termf']=='2'){
								
									$var[]= $hh->name."-".$value->exam_subject->subject."(80)";
							}else{
									$var[]= $hh->name."-".$value->exam_subject->subject."(".$hh->maxnumber.")";
								
								
								
							}
						
						
					}
			
				$sunbujet[]=$value->exam_subject->subject;
				$sunbujet1[]=$value->exam_subject->exprint;
				$is_optionals[]=$value->exam_subject->is_optional;
				
				
			}
				}
        } 
        elseif ($roleid!='3') {
        	foreach($examdetails as $key=>$value){
				
				foreach($examtypess as $g=>$hh){
				$var[]= $hh->name."-".$value->exam_subject->subject."(".$hh->maxnumber.")";
								$sunbujet[]=$value->exam_subject->subject;
				}
				
			}
        }



				
				$name=strtolower($examtypess[0]['examname']); 
	
				$classid=$clasid;
	
				
				$acedamicyear=$examtypes[0]['acedamicyear'];
			$names=str_replace(" ","",$name);
$name=$names."-".date('d-m-Y')."-";


  	$classesdd = $this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classes.id' =>$classid,'Sections.id'=>$sid])->order(['Sections.title' => 'ASC'])->first();    
                
	$sunbujet=array_unique($sunbujet);
      if($roleid=='3')
        {
			
		
			$subjty=implode('-',$sunbujet);
$tech_id=$this->request->session()->read('Auth.User.tech_id');

  	$emplo = $this->Employees->find('all')->where(['Employees.id'=>$tech_id])->first();   
  	
  	
		$this->response->download($classesdd['Classes']['title'].'-'.$classesdd['Sections']['title'].'-'.ucwords(strtolower($emplo['fname'])).'-'.ucwords(strtolower($subjty)).'-'.ucwords(strtolower($name)).'result.csv');
		
		
	}else{
			$subjty=implode('-',$sunbujet);
		$this->response->download($classesdd['Classes']['title'].'-'.$classesdd['Sections']['title'].ucwords(strtolower($subjty)).'-'.'-'.ucwords(strtolower($name)).'result.csv');
	
		
	}
		

 $conn = ConnectionManager::get('default');
  
$year=$this->Users->find('all')->where(['Users.role_id' => '1'])->first();

$academic_year=$year['academic_year']; 
$namess=$examtypess['name'];

if($classid=='12' || $classid=='13' || $classid=='15' || $classid=='17' || $classid=='20' || $classid=='22'){
	
	if(in_array('1',$is_optionals)){
		
		
	$subjectt=$this->Subjects->find('all')->where(['Subjects.name IN'=>$sunbujet1])->toarray(); 
$cn=count($subjectt);
	
		
		$detail.="SELECT Students.enroll AS `Students__enroll`,CONCAT(Students.fname, ' ',Students.middlename,' ',Students.lname) AS `Students__fnames`,  Classes.title AS `Classes.title`,Sections.title AS `Sections.title` FROM students Students INNER JOIN sections Sections ON Sections.id = (Students.section_id) INNER JOIN classes Classes ON Classes.id = (Students.class_id) WHERE ";
		
		
		foreach($subjectt as $k=>$sub)
				{
                    $siud=$sub['id'];
                    if($cn!=$k+1){
					$detail.=" Students.class_id='$classid' AND Students.section_id='$sid' AND FIND_IN_SET('$siud', opt_sid) AND Students.acedmicyear='$academic_year'  AND Students.status ='Y' OR ";
				}else{
					$detail.=" Students.class_id='$classid' AND Students.section_id='$sid' AND FIND_IN_SET('$siud', opt_sid) AND Students.acedmicyear='$academic_year'  AND Students.status ='Y'";
					
					
				}	

				}
			
					

			
				
			 

		
	}else{
		
			
	$subjectt=$this->Subjects->find('all')->where(['Subjects.name IN'=>$sunbujet1])->toarray(); 
$cn=count($subjectt);
	
		
		$detail.="SELECT Students.enroll AS `Students__enroll`,CONCAT(Students.fname, ' ',Students.middlename,' ',Students.lname) AS `Students__fnames`,  Classes.title AS `Classes.title`,Sections.title AS `Sections.title` FROM students Students INNER JOIN sections Sections ON Sections.id = (Students.section_id) INNER JOIN classes Classes ON Classes.id = (Students.class_id) WHERE ";
		
		
		foreach($subjectt as $k=>$sub)
				{
                    $siud=$sub['id'];
                    if($cn!=$k+1){
					$detail.=" Students.class_id='$classid' AND Students.section_id='$sid' AND FIND_IN_SET('$siud', comp_sid) AND Students.acedmicyear='$academic_year'  AND Students.status ='Y' OR ";
				}else{
					$detail.=" Students.class_id='$classid' AND Students.section_id='$sid' AND FIND_IN_SET('$siud', comp_sid) AND Students.acedmicyear='$academic_year'  AND Students.status ='Y'";
					
					
				}	

				}
			
					

		
		
		
	}
	
	
	
	
}else if($classid=='11' && $sid=='14'){
	
	if(in_array('1',$is_optionals)){
		
		
	$subjectt=$this->Subjects->find('all')->where(['Subjects.name IN'=>$sunbujet1])->toarray(); 
$cn=count($subjectt);

		
		$detail.="SELECT Students.enroll AS `Students__enroll`,CONCAT(Students.fname, ' ',Students.middlename,' ',Students.lname) AS `Students__fnames`,  Classes.title AS `Classes.title`,Sections.title AS `Sections.title` FROM students Students INNER JOIN sections Sections ON Sections.id = (Students.section_id) INNER JOIN classes Classes ON Classes.id = (Students.class_id) WHERE ";
		
		
		foreach($subjectt as $k=>$sub)
				{
                    $siud=$sub['id'];
                    if($cn!=$k+1){
					$detail.=" Students.class_id='$classid' AND Students.section_id='$sid' AND FIND_IN_SET('$siud', opt_sid) AND Students.acedmicyear='$academic_year'  AND Students.status ='Y' OR ";
				}else{
					$detail.=" Students.class_id='$classid' AND Students.section_id='$sid' AND FIND_IN_SET('$siud', opt_sid) AND Students.acedmicyear='$academic_year'  AND Students.status ='Y'";
					
					
				}	

				}
			
					

			
				
			 

		
	}else{
		
		$detail="SELECT Students.enroll AS `Students__enroll`,CONCAT(Students.fname, ' ',Students.middlename,' ',Students.lname) AS `Students__fnames`,  Classes.title AS `Classes.title`,Sections.title AS `Sections.title` FROM students Students INNER JOIN sections Sections ON Sections.id = (Students.section_id) INNER JOIN classes Classes ON Classes.id = (Students.class_id) WHERE (Students.class_id='$classid'  AND Students.section_id='$sid'  AND Students.acedmicyear='$academic_year'  AND Students.status ='Y')";
		
		
		
	}
	
	
	
	
}else if($classid=='25' || $classid=='29'){
	
	if(in_array('1',$is_optionals)){
		
		
	$subjectt=$this->Subjects->find('all')->where(['Subjects.name IN'=>$sunbujet1])->toarray(); 
	
	
$cn=count($subjectt);
	
		
		$detail.="SELECT Students.enroll AS `Students__enroll`,CONCAT(Students.fname, ' ',Students.middlename,' ',Students.lname) AS `Students__fnames`,  Classes.title AS `Classes.title`,Sections.title AS `Sections.title` FROM students Students INNER JOIN sections Sections ON Sections.id = (Students.section_id) INNER JOIN classes Classes ON Classes.id = (Students.class_id) WHERE ";
		
		
		foreach($subjectt as $k=>$sub)
				{
                    $siud=$sub['id'];
                    if($cn!=$k+1){
					$detail.=" Students.class_id='$classid' AND Students.section_id='$sid' AND FIND_IN_SET('$siud', opt_sid) AND Students.acedmicyear='$academic_year'  AND Students.status ='Y' OR ";
				}else{
					$detail.=" Students.class_id='$classid' AND Students.section_id='$sid' AND FIND_IN_SET('$siud', opt_sid) AND Students.acedmicyear='$academic_year'  AND Students.status ='Y'";
					
					
				}	

				}
			
					

			
				
			 

		
	}else{
		
		$detail="SELECT Students.enroll AS `Students__enroll`,CONCAT(Students.fname, ' ',Students.middlename,' ',Students.lname) AS `Students__fnames`,  Classes.title AS `Classes.title`,Sections.title AS `Sections.title` FROM students Students INNER JOIN sections Sections ON Sections.id = (Students.section_id) INNER JOIN classes Classes ON Classes.id = (Students.class_id) WHERE (Students.class_id='$classid'  AND Students.section_id='$sid'  AND Students.acedmicyear='$academic_year'  AND Students.status ='Y')";
		
		
		
	}
	
	
	
	
}else{
$detail="SELECT Students.enroll AS `Students__enroll`,CONCAT(Students.fname, ' ',Students.middlename,' ',Students.lname) AS `Students__fnames`,  Classes.title AS `Classes.title`,Sections.title AS `Sections.title` FROM students Students INNER JOIN sections Sections ON Sections.id = (Students.section_id) INNER JOIN classes Classes ON Classes.id = (Students.class_id) WHERE (Students.class_id='$classid'  AND Students.section_id='$sid'  AND Students.acedmicyear='$academic_year'  AND Students.status ='Y')";

}
   $SQL = $detail." ORDER BY Students.fname ASC, Students.middlename ASC, Students.lname ASC";  

$data = $conn->execute( $SQL )->fetchAll('assoc');

$data2= array();


foreach($data as $ks=>$vak){
	

	 $stddat = $this->Students->find('all')->where(['Students.enroll'=>trim($vak['Students__enroll']),'Students.class_id'=>$classid,'Students.section_id' =>$sid,'Students.status'=>'Y'])->first();
	 
	 $cnt=1;
       foreach ($var as $k=>$head) {
		
  if (strpos($head,'-')!==false) {
                    $h = explode('-',$head);
                     $fghsss = explode('(',$h[1]);
                   
                    
 $examtypess = $this->Examtypes->find('all')->where(['FIND_IN_SET(\''. $classid .'\',class_id)','Examtypes.name IN'=>$h[0]])->order(['Examtypes.id' => 'asc'])->first();       
 
 $subjectclasses_datas = $this->ExamSubjects->find('all')->where(['class_id'=>$classid,'subject' =>$fghsss[0]])->first();    
                    
    $std_result_status = $this->Studentexamresult->find('all')->where(['Studentexamresult.exam_id' =>$id,'Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$sid,'Studentexamresult.subject_id' =>$subjectclasses_datas['id'],'Studentexamresult.etype_id' =>$examtypess['id'],'Studentexamresult.stud_id' =>$stddat['id']])->first();
    
    $marks=$std_result_status['marks'];
                 
   $data[$ks]['Students__marks'.$cnt++]=$marks;            
                    
	
	
}


	}
	
	
}



$_serialize = 'data';
   		$this->set(compact('data', '_serialize'));
   		$_headers = ['SrNo', 'Name', 'Class','Section'];
 
$_header = array_merge($_headers, $var);

$this->set(compact('data', '_serialize', '_header'));
		$this->viewBuilder()->className('CsvView.Csv');
		return;
	
	}
	
// search functionality
public function search(){ 
	

 $this->loadModel('User');
		$this->loadModel('Employees');
		$this->loadModel('Users');
		 $this->loadModel('ClasstimeTabs');
		 $this->loadModel('Classections');
$class=$this->request->data['class_id'];

$examtypes=$this->request->data['examtypes']; 


$year=$this->Users->find('all')->where(['Users.role_id' => '1'])->first();

$acedamicyear=$year['academic_year']; 

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
	
	
	
	$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['FIND_IN_SET(\''. $class .'\',Exams.class_id)'])->order(['Exams.id' => 'asc'])->toArray();
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
	
	
	public function schoolasticview(){    
		
		$this->viewBuilder()->layout('admin');
		
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
	
	
$examtypei = $this->Exams->find('all')->contain(['Examtypes','Classes'])->order(['Exams.id' => 'asc'])->toArray();
    $this->set('examtypei', $examtypei); 
    	

}
	
	public function view($classid=null,$examtypesi=null){    

    

		$this->loadModel('User');
		$this->loadModel('Employees');
		$this->loadModel('ClasstimeTabs');
		$this->loadModel('Subjects');
		$this->loadModel('Classections');
		$this->loadModel('Exams');
		$this->set('examtypesi', $examtypesi);
		$this->viewBuilder()->layout('admin');

         $uemail=$this->request->session()->read('Auth.User.email');
		$employ =$this->Employees->find('all')->where(['Employees.email' => $uemail])->first();
        $dpid=$employ['id'];


    $cname=$this->Classections->find('list',[
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Sections','Classes'])->where(['FIND_IN_SET(\''. $dpid .'\',Classections.teacher_id)'])->order(['Sections.title' => 'ASC'])->toArray();

     $ctime=$this->ClasstimeTabs->find('all')->where(['ClasstimeTabs.employee_id' =>$dpid])->toArray();


$this->set('cname', $cname);
		if($classid && $examtypesi){
			
		$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.class_id' => $classid,'Exams.e_type_id' =>$examtypesi])->order(['Exams.id' => 'asc'])->toArray();

	$this->set('examtypes', $examtypesi);
	$examtypeses = $this->Exams->find('list', [
    'keyField' => 'Examtypes.id',
    'valueField' => 'Examtypes.name'
])->contain(['Examtypes'])->where(['Exams.status' => 'Y'])->order(['Examtypes.name' => 'ASC'])->toArray();
	
	$this->set('examtypeses', $examtypeses);

		$classes = $this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classections.id' => $classid])->order(['Sections.title' => 'ASC'])->toArray();
          

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
public function searcharea($class,$section){ 
	
	
	$this->viewBuilder()->layout('admin');
		//show all data in listing page

//connection
  $conn = ConnectionManager::get('default');
	


$detail="SELECT Students.id,Students.enroll,Students.fname,Students.middlename,Students.lname,Students.mobile,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id    WHERE  1=1 ";

 $cond = ' ';

 
if(!empty($class))
{
 
    $cond.=" AND Students.class_id LIKE '".$class."%' ";
        

}




  
if(!empty($section))
{
 
    $cond.=" AND Students.section_id LIKE '".$section."%' ";
        

}
  
 $cond.=" AND Students.status ='Y'";


 $detail = $detail.$cond;
   $SQL = $detail." ORDER BY Students.fname ASC";  

$results = $conn->execute( $SQL )->fetchAll('assoc');

	$this->set('students', $results);

	}
	
	
	
	
	public function schoolexamview($classid=null,$examtypes=null){    
		
		$this->viewBuilder()->layout('admin');
		
		    $this->loadModel('Studentexamresult');

    $std_result_status = $this->Studentexamresult->find('list', [
    'keyField' => 'class.id',
    'valueField' => 'class.title'
])->contain(['Classes','Sections'])->where(['Studentexamresult.status' =>'N','Studentexamresult.exam_id' =>'9'])->group(['Studentexamresult.class_id'])->toarray();
		
		$this->set('classes', $std_result_status);	
		
		
		
	
	
    $sectionslist = $this->Studentexamresult->find('list', [
    'keyField' => 'section.id',
    'valueField' => 'section.title'
])->contain(['Classes','Sections'])->where(['Studentexamresult.status' =>'N'])->group(['Studentexamresult.sect_id'])->toarray();
		
	$this->set('sections', $sectionslist);
	
	
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status'=>'Y'])->order(['Students.id' => 'DESC'])->toarray();
		$this->set('students',$student_data);
	

	    }
	    
	    
	        public function resultixx($schedule_id = null,$acedemic=null){
	        
	       

    $this->loadModel('Studentexamresult');

    $std_result_status = $this->Studentexamresult->find('all')->where(['Studentexamresult.stud_id' =>$schedule_id])->first();
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$schedule_id,'Students.status'=>'Y','Students.acedmicyear' =>$acedemic])->first();
	
	
	
	
		$students = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Students.id' =>$schedule_id,'Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->order(['Students.fname' => 'ASC'])->first();
		
		
	$this->set(compact('students'));

		//	pr($address); die;	



}
	
	        public function result($schedule_id = null,$acedemic=null){
	        
	        $url=SITE_URL."mobile/attendenceforweb/".$schedule_id."/".$acedemic;
	        
$html=$this->getHTML($url,10);
$findexp=json_decode($html);

if($findexp->output[0]->total_working_days){
$this->set('totalworkingday',$findexp->output[0]->total_working_days);

}else{

$this->set('totalworkingday','0');

}

if($findexp->output[0]->total_attendence){
$this->set('total_attendence',$findexp->output[0]->total_attendence);

}else{

$this->set('total_attendence','0');
}

    $this->loadModel('Studentexamresult');

    $std_result_status = $this->Studentexamresult->find('all')->where(['Studentexamresult.stud_id' =>$schedule_id])->first();
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$schedule_id,'Students.status'=>'Y','Students.acedmicyear' =>$acedemic])->first();
	
	
	
	
		$students = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Students.id' =>$schedule_id,'Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->order(['Students.fname' => 'ASC'])->first();
		
		
	$this->set(compact('students'));

		//	pr($address); die;	



}



 public function newresult($schedule_id = null,$acedemic=null){
	        
	        $url=SITE_URL."mobile/attendenceforweb/".$schedule_id."/".$acedemic;
	        
$html=$this->getHTML($url,10);
$findexp=json_decode($html);

if($findexp->output[0]->total_working_days){
$this->set('totalworkingday',$findexp->output[0]->total_working_days);

}else{

$this->set('totalworkingday','0');

}

if($findexp->output[0]->total_attendence){
$this->set('total_attendence',$findexp->output[0]->total_attendence);

}else{

$this->set('total_attendence','0');
}

    $this->loadModel('Studentexamresult');

    $std_result_status = $this->Studentexamresult->find('all')->where(['Studentexamresult.stud_id' =>$schedule_id])->first();
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$schedule_id,'Students.status'=>'Y','Students.acedmicyear' =>$acedemic])->first();
	
	
	
	
		$students = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Students.id' =>$schedule_id,'Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->order(['Students.fname' => 'ASC'])->first();
		
		
	$this->set(compact('students'));

		//	pr($address); die;	



} 
	        public function resultscience($schedule_id = null,$acedemic=null){
	        
	        $url=SITE_URL."mobile/attendenceforweb/".$schedule_id."/".$acedemic;
	        
$html=$this->getHTML($url,10);
$findexp=json_decode($html);

if($findexp->output[0]->total_working_days){
$this->set('totalworkingday',$findexp->output[0]->total_working_days);

}else{

$this->set('totalworkingday','0');

}

if($findexp->output[0]->total_attendence){
$this->set('total_attendence',$findexp->output[0]->total_attendence);

}else{

$this->set('total_attendence','0');
}

    $this->loadModel('Studentexamresult');

    $std_result_status = $this->Studentexamresult->find('all')->where(['Studentexamresult.stud_id' =>$schedule_id])->first();
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$schedule_id,'Students.status'=>'Y','Students.acedmicyear' =>$acedemic])->first();
	
	
	
	
		$students = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Students.id' =>$schedule_id,'Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->order(['Students.fname' => 'ASC'])->first();
		
		
	$this->set(compact('students'));

		//	pr($address); die;	



}

public function resultcam($schedule_id = null,$acedemic=null){
	        
	   $url=SITE_URL."mobile/attendenceforweb/".$schedule_id."/".$acedemic;
	        
$html=$this->getHTML($url,10);
$findexp=json_decode($html);

if($findexp->output[0]->total_working_days){
$this->set('totalworkingday',$findexp->output[0]->total_working_days);

}else{

$this->set('totalworkingday','0');

}

if($findexp->output[0]->total_attendence){
$this->set('total_attendence',$findexp->output[0]->total_attendence);

}else{

$this->set('total_attendence','0');
}

    $this->loadModel('Studentexamresult');

    $std_result_status = $this->Studentexamresult->find('all')->where(['Studentexamresult.stud_id' =>$schedule_id])->first();
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$schedule_id,'Students.status'=>'Y','Students.acedmicyear' =>$acedemic])->first();
	
	
	//pr($students); die;
	
		$students = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Students.id' =>$schedule_id,'Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->order(['Students.fname' => 'ASC'])->first();
		
		
	$this->set(compact('students'));

		//	pr($address); die;	    



}


public function resultcamnine($schedule_id = null,$acedemic=null){
	        
	   $url=SITE_URL."mobile/attendenceforweb/".$schedule_id."/".$acedemic;
	        
$html=$this->getHTML($url,10);
$findexp=json_decode($html);

if($findexp->output[0]->total_working_days){
$this->set('totalworkingday',$findexp->output[0]->total_working_days);

}else{

$this->set('totalworkingday','0');

}

if($findexp->output[0]->total_attendence){
$this->set('total_attendence',$findexp->output[0]->total_attendence);

}else{

$this->set('total_attendence','0');
}

    $this->loadModel('Studentexamresult');

    $std_result_status = $this->Studentexamresult->find('all')->where(['Studentexamresult.stud_id' =>$schedule_id])->first();
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$schedule_id,'Students.status'=>'Y','Students.acedmicyear' =>$acedemic])->first();
	
	
	//pr($students); die;
	
		$students = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Students.id' =>$schedule_id,'Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->order(['Students.fname' => 'ASC'])->first();
		
		
	$this->set(compact('students'));

		//	pr($address); die;	    



}



   public function findacedemicyears()
{
      // pr ($rout); die;
        // Use the HTML helper to output
        // Formatted data:
        $articles = TableRegistry::get('Users');

// Start a new query.

  
         return  $articles->find('all')->where(['Users.role_id' 
         =>'1'])->first();
    }


	        public function resultterm2($schedule_id = null,$acedemic=null){
	        
	        $url=SITE_URL."mobile/attendenceforweb/".$schedule_id."/".$acedemic;
	        
$html=$this->getHTML($url,10);
$findexp=json_decode($html);

if($findexp->output[0]->total_working_days){
$this->set('totalworkingday',$findexp->output[0]->total_working_days);

}else{

$this->set('totalworkingday','0');

}

if($findexp->output[0]->total_attendence){
$this->set('total_attendence',$findexp->output[0]->total_attendence);

}else{

$this->set('total_attendence','0');
}

    $this->loadModel('Studentexamresult');

    $std_result_status = $this->Studentexamresult->find('all')->where(['Studentexamresult.stud_id' =>$schedule_id])->first();
if($std_result_status['status']=='Y')
{}
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$schedule_id,'Students.acedmicyear' =>$acedemic,'Students.status'=>'Y'])->first();
	$this->set(compact('students'));
	$classessss =$this->Guardians->find()->where(['Guardians.user_id' => $schedule_id])->first();
		//pr($classessss); die;
	$this->set(compact('classessss'));

	$address = $this->Address->find('all')->contain(['CurCountry','PerCountry','CurStates','PerStates','CurStates','PerStates','CurCity','PerCity'])->where(['Address.type' =>0,'Address.user_id' =>$schedule_id])->first();

	$this->set(compact('address')); 
		//	pr($address); die;	



}

public function getHTML($url,$timeout)
{
       $ch = curl_init($url); // initialize curl with given url
       curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // set  useragent
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // max. seconds to execute
       curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
       return @curl_exec($ch);
}
 public function resultall($classid = null,$section = null,$acedemic=null,$s_id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');

	
	
		$studentsj = 
		$this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.term' =>'1','Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['Students.enroll' => 'ASC'])->toarray();
		
	$this->set(compact('studentsj','s_id'));
		//	pr($address); die;	



}

 

 public function resultallupdatemarks($classid = null,$section = null,$acedemic=null,$id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('admin');


	
	
		$students = 
		$this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.stud_id' =>$id,'Studentexamresult.term' =>'1','Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->order(['Students.enroll' => 'ASC'])->first();

	$this->set(compact('students'));
	
			if ($this->request->is(['post', 'put'])) {
				   $uid=$this->request->session()->read('Auth.User.id');
     
       
       
foreach($this->request->data['marks'] as $kr=>$item){
		
		 

	 
   $userTable2 = TableRegistry::get('Studentexamresult');
            $exists2 = $userTable2->exists(['id' =>$kr, 'marks' =>$item]);
            if ($exists2) {
				
			}else{
	 $conns = ConnectionManager::get('default');
	 

$conns->execute("UPDATE `studentexamresult` SET `marks`='".$item."',`coordinator_id`='".$uid."' WHERE `id`='".$kr."'");	

	}
		
	}
	
	
	 $this->Flash->success(__('Exam Result has been Updated successfully by Coordinator.'));
                
                   return $this->redirect(['action'=>'resultallupdatemarks/'.$classid.'/'.$section.'/'.$acedemic.'/'.$id]);
			}
		



}


public function resultallupdatemarks2($classid = null,$section = null,$acedemic=null,$id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('admin');


	
	
		$students = 
		$this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.stud_id' =>$id,'Studentexamresult.term' =>'2','Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->order(['Students.enroll' => 'ASC'])->first();

	$this->set(compact('students'));
	
			if ($this->request->is(['post', 'put'])) {
				   $uid=$this->request->session()->read('Auth.User.id');
     
       
       
foreach($this->request->data['marks'] as $kr=>$item){
		
		 

	 
   $userTable2 = TableRegistry::get('Studentexamresult');
            $exists2 = $userTable2->exists(['id' =>$kr, 'marks' =>$item]);
            if ($exists2) {
				
			}else{
	 $conns = ConnectionManager::get('default');
$conns->execute("UPDATE `studentexamresult` SET `marks`='".$item."',`coordinator_id`='".$uid."' WHERE `id`='".$kr."'");	

	}
		
	}
	
	
	 $this->Flash->success(__('Exam Result has been Updated successfully by Coordinator.'));
                
                   return $this->redirect(['action'=>'resultallupdatemarks2/'.$classid.'/'.$section.'/'.$acedemic.'/'.$id]);
			}
		



}


public function resultallupdatemarksixx($classid = null,$section = null,$acedemic=null,$id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('admin');


	
	
		$students = 
		$this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.stud_id' =>$id,'Studentexamresult.term' =>'1','Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->order(['Students.enroll' => 'ASC'])->first();

	$this->set(compact('students'));
	
			if ($this->request->is(['post', 'put'])) {
				   $uid=$this->request->session()->read('Auth.User.id');
     
       
       
foreach($this->request->data['marks'] as $kr=>$item){
		
		 

	 
   $userTable2 = TableRegistry::get('Studentexamresult');
            $exists2 = $userTable2->exists(['id' =>$kr, 'marks' =>$item]);
            if ($exists2) {
				
			}else{
	 $conns = ConnectionManager::get('default');
$conns->execute("UPDATE `studentexamresult` SET `marks`='".$item."',`coordinator_id`='".$uid."' WHERE `id`='".$kr."'");	

	}
		
	}
	
	
	 $this->Flash->success(__('Exam Result has been Updated successfully by Coordinator.'));
                
                   return $this->redirect(['action'=>'resultallupdatemarksixx/'.$classid.'/'.$section.'/'.$acedemic.'/'.$id]);
			}
		



}


public function resultallupdatemarksixx2($classid = null,$section = null,$acedemic=null,$id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('admin');


	
	
		$students = 
		$this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.stud_id' =>$id,'Studentexamresult.term' =>'2','Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->order(['Students.enroll' => 'ASC'])->first();

	$this->set(compact('students'));
	
			if ($this->request->is(['post', 'put'])) {
				   $uid=$this->request->session()->read('Auth.User.id');
     
       
       
foreach($this->request->data['marks'] as $kr=>$item){
		
		 

	 
   $userTable2 = TableRegistry::get('Studentexamresult');
            $exists2 = $userTable2->exists(['id' =>$kr, 'marks' =>$item]);
            if ($exists2) {
				
			}else{
	 $conns = ConnectionManager::get('default');
$conns->execute("UPDATE `studentexamresult` SET `marks`='".$item."',`coordinator_id`='".$uid."' WHERE `id`='".$kr."'");	

	}
		
	}
	
	
	 $this->Flash->success(__('Exam Result has been Updated successfully by Coordinator.'));
                
                   return $this->redirect(['action'=>'resultallupdatemarksixx2/'.$classid.'/'.$section.'/'.$acedemic.'/'.$id]);
			}
		



}

 public function resultall2($classid = null,$section = null,$acedemic=null,$s_id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	
$studentsj = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.term' =>'2','Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['Students.enroll' => 'ASC'])->toarray();
	
	
	//$studentsj = $this->Studentexamresult->find('all')->contain(['DropOutStudent'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.term' =>'2','DropOutStudent.acedmicyear'=>$acedemic,'DropOutStudent.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['DropOutStudent.enroll' => 'ASC'])->toarray();
		
	$this->set(compact('studentsj','s_id'));
			



}


public function resultallscience($classid = null,$section = null,$acedemic=null,$s_id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');

	//$asf=array(333575,333654); 'Students.id IN'=>$asf,
	
		$studentsj =$this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.term' =>'1','Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['Students.enroll' => 'ASC'])->toarray();
	
	$this->set(compact('studentsj','s_id'));
		//	pr($address); die;	



}
public function resultallscience2($classid = null,$section = null,$acedemic=null,$s_id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');


	
		$studentsj = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.term' =>'2','Students.acedmicyear'=>$acedemic,'Students.status'=>'Y','Students.enroll IN'=>[5777,5811,6241,6259,6301,6304,6309,6318,6325,6344]])->group(['Studentexamresult.stud_id'])->order(['Students.enroll' => 'ASC'])->toarray();
		
	$this->set(compact('studentsj','s_id'));
		// pr($studentsj); die;	



}
public function resultallscience3($classid = null,$section = null,$acedemic=null,$s_id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');


	
		$studentsj = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.term' =>'2','Students.acedmicyear'=>$acedemic,'Students.enroll IN'=>[5777,5811,6241,6259,6301,6304,6309,6318,6325,6344],'Students.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['Students.enroll' => 'ASC'])->toarray();
		
	$this->set(compact('studentsj','s_id'));
		// pr($studentsj); die;	



}

 public function resultallcam($classid = null,$section = null,$acedemic=null,$s_id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');

	
	
		$studentsj = 
		$this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.term' =>'1','Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['Students.enroll' => 'ASC'])->toarray();
		
	$this->set(compact('studentsj','s_id'));
		//	pr($address); die;	



}

public function resultallcam2($classid = null,$section = null,$acedemic=null,$s_id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');

	
	
		$studentsj = 
		$this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.term' =>'2','Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['Students.enroll' => 'ASC'])->toarray();
		
	$this->set(compact('studentsj','s_id'));
		//	pr($address); die;	



}

 public function resultallcamnine($classid = null,$section = null,$acedemic=null,$s_id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');

	
	
		$studentsj = 
		$this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Students.acedmicyear'=>$acedemic,'Studentexamresult.term' =>'1','Students.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['Students.enroll' => 'ASC'])->toarray();
		
	$this->set(compact('studentsj','s_id'));
		//	pr($address); die;	



}


 public function resultallcamnine2($classid = null,$section = null,$acedemic=null,$s_id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');

	
	
		$studentsj = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Students.acedmicyear'=>$acedemic,'Studentexamresult.term' =>'2','Students.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['Students.enroll' => 'ASC'])->toarray();
		
	$this->set(compact('studentsj','s_id'));
		//	pr($address); die;	



}
 public function resultallcamten2($classid = null,$section = null,$acedemic=null,$s_id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');

	
	
		$studentsj = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Students.acedmicyear'=>$acedemic,'Studentexamresult.term' =>'2','Students.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['Students.enroll' => 'ASC'])->toarray();
		
	$this->set(compact('studentsj','s_id'));
			//  pr($studentsj); die;	



}
 public function resultallixx($classid = null,$section = null,$acedemic=null,$s_id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 1600);
    
	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');

	
	
		$studentsj = 
		$this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.term' =>'1','Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['Students.enroll' => 'ASC'])->toarray();
		
	$this->set(compact('studentsj','s_id'));
		//	pr($address); die;	



}
 public function resultallixx2($classid = null,$section = null,$acedemic=null,$s_id=null){

    $this->loadModel('Studentexamresult');


        ini_set('max_execution_time', 3200);

	$this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');


	
		$studentsj = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.term' =>'2','Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['Students.enroll' => 'ASC'])->toarray();
		// $studentsj = $this->Studentexamresult->find('all')->contain(['DropOutStudent'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.term' =>'2','DropOutStudent.acedmicyear'=>$acedemic,'DropOutStudent.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['DropOutStudent.enroll' => 'ASC'])->toarray();
		
	$this->set(compact('studentsj','s_id'));
		



}



public function genratecard($class,$sections,$term){



$year=$this->Users->find('all')->where(['Users.role_id' => '1'])->first();

$academic_year=$year['academic_year']; 

$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.class_id' =>$class,'Students.section_id' =>$sections,'Students.acedmicyear' =>$academic_year,'Students.status'=>'Y'])->toarray();

foreach($students as $ggg=>$rrr){

if($term=="Term1"){
$url=ADMIN_URL."studentexamresult/result/".$rrr['id']."/".$academic_year;


}else{


$url=ADMIN_URL."studentexamresult/resultterm2/".$rrr['id']."/".$academic_year;

}
     $img = file_get_contents($url);
     $allow = ['pdf']; 
    
            if($img!='')
            {
             // get image data from $url
           $url_info = pathinfo($url);
           // if allowed extension
           if($url_info['dirname']) {
           
         
        
          // $filenames=$url_info['basename'];
           //$exts=  end(explode('.', $filenames));
          // $names = md5(time($filenames))."1";
          
          $exts="pdf";
           $excel_file_names = $rrr['enroll'].'('.$rrr['class']['title'].'-'.$rrr['section']['title'].'-'.$term.').'.$exts;
           
            $directory = WWW_ROOT . 'excel_file/student/'.$excel_file_names;
		   
unlink($directory);
	
	
           $save_to = WWW_ROOT.'excel_file/student/'. $excel_file_names;  // add image with the same name in 'imgs/' folder
           
           
          
           if(file_put_contents($save_to, $img)) {
            $array["partnerlogo_image"]=$excel_file_names;
           }
           
   }
 }
 //echo "s";
 }
 

if($term=="Term1"){
$urls=ADMIN_URL."studentexamresult/resultall/".$class."/".$sections."/".$academic_year;
}else{

$urls=ADMIN_URL."studentexamresult/resultallterm2/".$class."/".$sections."/".$academic_year;


}



 






   
     
     
         $ch = curl_init();
    $timeout = 51000;
    curl_setopt($ch, CURLOPT_URL, $urls);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    
      $extss="pdf";
        $excel_file_namess = $students[0]['class']['title'].'-'.$students[0]['section']['title'].'-'.$term.'.'.$extss;
           $directorys = WWW_ROOT . 'excel_file/student/'.$excel_file_namess;
		   
unlink($directorys);
           $save_tos = WWW_ROOT.'excel_file/student/'. $excel_file_namess;  // add image with the same name in 'imgs/' folder
           
         
          
           if(file_put_contents($save_tos, $data)) {
            $s=$excel_file_namess;
           }
           
   
 
 


		
	$this->Flash->success(__('Exam Result Genrated Sucessfully !!'));
					return $this->redirect(['action' => 'examcontrolview']);	




}
public function  findsubjectopt($classid=null,$sectionid=null){
		$empid= $this->request->session()->read('Auth.User.tech_id');
 $articles = TableRegistry::get('ClasstimeTabs');
$csec = $articles->find('all')->contain(['Classections'])->where(['FIND_IN_SET(\''. $empid .'\',ClasstimeTabs.employee_id)','Classections.class_id'=>$classid,'Classections.section_id'=>$sectionid])->toarray();
$sb=array();
foreach ($csec as $key => $value)
{
	$empo=explode(',',$value['employee_id']);
		$subjects=explode(',',$value['subject_id']);
		
		foreach($empo as $j=>$t){
			
			foreach($subjects as $sj=>$st){
				
				if($j==$sj && $t==$empid){
			
					 $articless = TableRegistry::get('Subjects');
			
					$csec = $articless->find('all')->where(['id'=>$st])->first();
					if($st=="66" || $st=="67" || $st=="68"){
						
					$sb[]=$csec['id'];
						
					}else if($st=="65" || $st=="70" || $st=="71"){
						
					$sb[] =$csec['id'];
					
						
					}
				}
				
			}	
			
		}
	

}


$sb=array_unique($sb);
	return $sb;	
		
		
	}
	
	  public function fsubjectonlyteachersbysubject($section=null,$classid=null,$rh=null){ 
      $articles = TableRegistry::get('Studentexamresult');
  
   // return   $articles->find('all')->contain(['Exams','ExamSubjects'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.subject_id' =>$rh])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
  $articles = TableRegistry::get('ExamSubjects');
  return   $articles->find('all')->where(['class_id' =>$classid,'id' =>$rh])->order(['sort' => 'ASC'])->toArray();
      }
      
       public function fsubjectonly($section=null,$classid=null){ 
      $articles = TableRegistry::get('Studentexamresult');
      
   // return   $articles->find('all')->contain(['Exams','ExamSubjects'])->where(['Studentexamresult.class_id'=>$classid,'Studentexamresult.sect_id'=>$section])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.subject_id' => 'asc'])->toarray();
   
     $articles = TableRegistry::get('ExamSubjects');
  return   $articles->find('all')->where(['class_id' =>$classid])->order(['sort' => 'ASC'])->toArray();

      }
          public function fsubjectmarks($sid=null,$section=null,$classid=null,$rs=null){ 
      $articles = TableRegistry::get('Studentexamresult');
    return   $articles->find('all')->contain(['Exams','ExamSubjects'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.stud_id' =>$sid,'Studentexamresult.etype_id' =>$rs,'Studentexamresult.sect_id' =>$section])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.id' => 'asc']);

      }
       public function fsubjectmarks1($sid=null,$section=null,$classid=null,$rs=null,$sub=null,$term=null){ 
      $articles = TableRegistry::get('Studentexamresult');
    return   $articles->find('all')->contain(['Exams','ExamSubjects'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.stud_id' =>$sid,'Studentexamresult.etype_id' =>$rs,'Studentexamresult.term' =>$term,'Studentexamresult.subject_id' =>$sub])->first();

      }

public function exportresult($id=null,$section=null,$classid=null,$term=null){

	$this->loadModel('Students');
	$this->loadModel('Sections');
	$connss = ConnectionManager::get('default');
	
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
		
	
	
	$examtypes =$this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id' => $id])->order(['Examtypes.sort' => 'asc'])->first();
	
    $class_id=$classid;
    $e_type_id=$examtypes['e_type_id'];
		

$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id' => $id])->order(['Examtypes.sort' => 'asc'])->first()->toArray();


				$subjectclasses_data = $this->Sections->find('all')->where(['id' =>$section])->first()->toarray();
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.class_id' => $classid,'Students.section_id' => $section,'Students.acedmicyear' => $examtypes['acedamicyear'],'Students.status'=>'Y'])->order(['Students.fname' => 'ASC'])->toarray();
		
			$student_data1 = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.term' =>$term,'Students.acedmicyear'=>$examtypes['acedamicyear'],'Students.status'=>'Y'])->group(['Studentexamresult.stud_id'])->order(['Students.fname' => 'ASC'])->toarray();
		
		$this->set('studentsda',$student_data1);
		
	
		$this->set('students',$student_data);
				$this->set('classname', $student_data[0]['class']['title']);
				$this->set('examid', $id);
 $examid=$id;
				$classname=$student_data[0]['class']['title'];
			$examname=$examtypes['Examtypes']['examname'];
			
				$sectionname=$subjectclasses_data['title'];
				$acedamicyear=$examtypes['acedamicyear'];
		
			
if($student_data1)
{


$colNames = array_keys();
$headerRow1[]="";
$headerRow1[]="";
$headerRow1[]="";


$headerRow2[]="S.No.";
$headerRow2[]="Sch. No.";
$headerRow2[]="Student Name";

$st=$this->findsubjectopt($class_id,$section);
			
				if(in_array("65",$st) || in_array("70",$st) || in_array("71",$st)){
					
			if($class_id=="10"){
						$rh='29';
						$studentsubject=$this->fsubjectonlyteachersbysubject($section,$class_id,$rh);
						
						
						
						
					}
					
					
					if($class_id=="11"){
						$rh='38';
							$studentsubject=$this->fsubjectonlyteachersbysubject($section,$class_id,$rh);
					
						
					}
				}else if(in_array("66",$st) || in_array("67",$st) || in_array("68",$st)){
					if($class_id=="10"){
						$rh='28';
						$studentsubject=$this->fsubjectonlyteachersbysubject($section,$class_id,$rh);
					
					}
					
					
					if($class_id=="11"){
						$rh='37';
							$studentsubject=$this->fsubjectonlyteachersbysubject($section,$class_id,$rh);
					
						
					}
					
				}else{
$studentsubject=$this->fsubjectonly($section,$class_id);
}


$findroleexamtype=$this->findeexamtsype2($section,$class_id,$term);

   if(isset($studentsubject) && !empty($studentsubject)){ 
	 
	 foreach($studentsubject as $works){
	     	$headerRow1[]=$works['exprint'];
	     	
	     	if($class_id!='23'){
				if($class_id!='24'){
			
				 if($class_id!='25'){
					  if($class_id!='10'){
						  if($class_id!='11'){
							  
							  if($term=='1'){
	     	$headerRow1[]='';
	     	
		}
						 if($term=='2'){
	     	$headerRow1[]='';
	   /*sushil*/  		$headerRow1[]='';
	     	
		}
	     	
		} } }  }
		
	}
			if($class_id!='12'){
				if($class_id!='13'){
					if($class_id!='15'){
						if($class_id!='17'){
							if($class_id!='20'){
								if($class_id!='22'){
									 if($term=='1'){
	     	$headerRow1[]='';
	     	
		}
			
		}
		
	}
	
}

}

}

}

 if($term=='1'){
	     	$headerRow1[]='';
	     	$headerRow1[]='';
	     	
		}
		
		 if($term=='2'){
	     	$headerRow1[]='';
	     	$headerRow1[]='';
	     		$headerRow1[]='';
	     	
	     	
		}
	     	
		
	   foreach($findroleexamtype as $er){  
		   
		   $findetypname=$this->findsubjectstotalssnames2($er['etype_id']);
	   			$headerRow2[]=$findetypname['ename'];
			
		}
		  /*sushil*/    $headerRow2[]="Total";
	} 
	
}
      

   $roleid=$this->request->session()->read('Auth.User.role_id');


$output.= implode("\t", $headerRow1)."\n";
$output.= implode("\t", $headerRow2)."\n";
$counter=1;



    if(isset($student_data) && !empty($student_data)){ 
    foreach($student_data1 as $work){
    $result=array();
$result[]=$counter++;
$result[]=$work['student']['enroll'];
  $result[]=ucwords(strtolower($work['student']['fname']))." ".ucwords(strtolower($work['student']['middlename']))." ".ucwords(strtolower($work['student']['lname']));
      
 
     if(isset($studentsubject) && !empty($studentsubject)){
         
	 foreach($studentsubject as $works){
		 
		 $fff=0; 
	   foreach($findroleexamtype as $er){  
		   $newmarks=$this->fsubjectmarks1($work['student']['id'],$section,$class_id,$er['etype_id'],$works['id'],$term);
		   
		   
	if($newmarks['marks']!=''){
			  if($er['etype_id']=="1"){ 
		
					
					if($newmarks['marks']!='0' && $newmarks['marks']!='A' ){ 
					
					$weighted=$newmarks['marks']/2;  
					
					$result[]=round($weighted);
					$fff +=round($weighted);
					
					
					 }else{
						
					$result[]=$newmarks['marks'];
						$fff +=$newmarks['marks']; 
						
						} 
		
		}else{
					 $result[]=$newmarks['marks'];
			$fff +=$newmarks['marks']; 
			
		}
		
	}else{
			 $result[]='-';
		
		
	}
	      
		}
		/*sushil*/ $result[]=$fff;
	} 
	}
       
        
          
         $output .=  implode("\t", $result)."\n";
          } }
          
         
//echo $output; die;
if($classname && $sectionname){
$filename = 
"Consolidate_Excel"."-".$classname."-".$sectionname."-".date("d-m-Y").".xls";

}else{
	
	$filename = "Consolidate_Excel.".date("d-m-Y").".xls";
}
//print_r($output); die;
header('Content-type: application/xls');
header('Content-Disposition: attachment; filename='.$filename);
echo $output;
die;

}
$this->Flash->error(__('No Exam Entry Found in Class !!!!'));
$this->redirect(array('action' => 'examcontrolview2'));	
	
	
	
}




 public function exportresultpdf($id=null,$section=null,$classid=null,$subjec=null){
		 $this->viewBuilder()->layout('ajax');
	$this->response->type('pdf');
	
	
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
		
	
	
			$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id' => $id])->order(['Examtypes.sort' => 'asc'])->first()->toArray();
	
    $class_id=$classid;
    $e_type_id=$examtypes['e_type_id'];
		
$this->set('class_id',$class_id);
$this->set('e_type_id',$e_type_id);

$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id' => $id])->order(['Examtypes.sort' => 'asc'])->first()->toArray();


				$subjectclasses_data = $this->Sections->find('all')->where(['id' =>$section])->first()->toarray();
		$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.class_id' => $classid,'Students.section_id' => $section,'Students.acedmicyear' => $examtypes['acedamicyear'],'Students.status'=>'Y'])->order(['Students.fname' => 'ASC'])->toarray();
		
			$student_data1 = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Students.acedmicyear'=>$examtypes['acedamicyear'],'Students.status'=>'Y','Studentexamresult.exam_id'=>$id])->group(['Studentexamresult.stud_id'])->order(['Students.fname' => 'ASC'])->toarray();
		
		$this->set('studentsda',$student_data1);
		
	
		$this->set('students',$student_data);
				$this->set('classname', $student_data[0]['class']['title']);
				$this->set('examid', $id);
	if($subjec){
				$this->set('subjec', $subjec);
				
					$subjj=$this->Subjects->find('all')->where(['Subjects.id'=>$subjec])->first();
	 if(($classid=='3' || $classid=='4' || $classid=='6') && ($subjec=='1')){
					
						$subjj['name'] = "Maths";
					$this->set('subjecname', $subjj['name']);
					
					}else{
		$this->set('subjecname', $subjj['name']);
	}
		
		
	}
							$this->set('section', $section);
				$this->set('examname', $examtypes['Examtypes']['examname']);
				$this->set('sectionname', $subjectclasses_data['title']);
				$this->set('acedamicyear', $examtypes['acedamicyear']);
		 
	 }
	    public function viewresult($id=null,$section=null,$classid=null,$subjec=null){
			
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
		
	
	
			$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id'=>$id])->order(['Examtypes.sort' => 'asc'])->first()->toArray();
	
    $class_id=$classid;
    $e_type_id=$examtypes['e_type_id'];
		
$this->set('class_id',$class_id);
$this->set('e_type_id',$e_type_id);

$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.id' => $id])->order(['Examtypes.sort' => 'asc'])->first()->toArray();


$subjectclasses_data = $this->Sections->find('all')->where(['id' =>$section])->first()->toarray();
$student_data = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.class_id' => $classid,'Students.section_id' => $section,'Students.status'=>'Y','Students.acedmicyear' => $examtypes['acedamicyear']])->order(['Students.fname' => 'ASC'])->toarray();
		
$student_data1 = $this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Students.acedmicyear'=>$examtypes['acedamicyear'],'Students.status'=>'Y','Studentexamresult.exam_id'=>$id])->group(['Studentexamresult.stud_id'])->order(['Students.fname' => 'ASC'])->toarray();
		
		$this->set('studentsda',$student_data1);
		$this->set('students',$student_data);
				$this->set('classname', $student_data[0]['class']['title']);
				$this->set('examid', $id);
				
				if($subjec){
				$this->set('subjec', $subjec);
				
					$subjj=$this->Subjects->find('all')->where(['Subjects.id'=>$subjec])->first();
	
		$this->set('subjecname', $subjj['name']);
		
		
		
	}
							$this->set('section', $section);
				$this->set('examname', $examtypes['Examtypes']['examname']);
				$this->set('sectionname', $subjectclasses_data['title']);
				$this->set('acedamicyear', $examtypes['acedamicyear']);
			
			}
			
			
			public function subjectmarks($exid=null,$sid=null,$section=null,$classid=null){
				
			
				$studentexamresult = $this->Studentexamresult->find('all')->contain(['Exams','Subjects'])->where(['Studentexamresult.exam_id' => $exid,'Studentexamresult.class_id' => $classid,'Studentexamresult.stud_id' => $sid,'Studentexamresult.sect_id' => $section])->order(['Studentexamresult.id' => 'asc']);
				$this->set('studentexamresult', $studentexamresult);
$this->set('classid', $classid);
				
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


	public function save_finalize($exam_id=null,$sect_id=null,$status=null)
	{


		$this->loadModel('Studentexamresult');

		
              
    $statusquery = $this->Studentexamresult->find('all')->where(['Studentexamresult.status' => 'N','Studentexamresult.stud_id' =>$value])->count();
	
		if(isset($exam_id) && !empty($exam_id)){

		if($status == 'Y' ){
			
				
			//status update

				
				
$users = TableRegistry::get('Studentexamresult'); 
$query = $users->query();
 $query->update() ->set(['status' => 'Y']) ->where(['exam_id' => $exam_id,'sect_id'=>$sect_id]) ->execute();
				


					$this->Flash->success(__('Your Result has been Saved & Finalize Successfully'));
					return $this->redirect(['action' => 'viewresult/'.$exam_id.'/'.$sect_id]);	
		

	}
		
	}
	

}

public function drop_result($exam_id=null,$sect_id=null,$status=null)
	{

//pr($exam_id); pr($sect_id); pr($status); die;
		$this->loadModel('Studentexamresult');

		
              
    $statusquery = $this->Studentexamresult->find('all')->where(['Studentexamresult.status' => 'Y','Studentexamresult.stud_id' =>$value])->count();
	
		if(isset($exam_id) && !empty($exam_id)){
	
		if($status == 'N' ){
			
	
			//status update

				
				
$users = TableRegistry::get('Studentexamresult'); 
$query = $users->query();
 $query->update() ->set(['status' => 'N']) ->where(['exam_id' => $exam_id,'sect_id'=>$sect_id]) ->execute();
				


    $this->Flash->success(__('Result Droped Successfully'));
    return $this->redirect(['action' => 'viewresult/'.$exam_id.'/'.$sect_id]);	
		

	}
		
	}
	

}


public function retestprocess($classs=null,$section=null,$examid=null){



$this->viewBuilder()->layout('admin');
$conn = ConnectionManager::get('default');

 
 
 $detail="SELECT Studentexamresult.id AS `Studentexamresult__id`, Studentexamresult.stud_id AS `Studentexamresult__stud_id`, Studentexamresult.exam_id AS `Studentexamresult__exam_id`, Studentexamresult.subject_id AS `Studentexamresult__subject_id`, Studentexamresult.marks AS `Studentexamresult__marks`, Studentexamresult.teach_id AS `Studentexamresult__teach_id`, Studentexamresult.created AS `Studentexamresult__created`, Studentexamresult.sect_id AS `Studentexamresult__sect_id`, Studentexamresult.class_id AS `Studentexamresult__class_id`, Studentexamresult.status AS `Studentexamresult__status`, Students.id AS `Students__id`, Students.fname AS `Students__fname`, Students.middlename AS `Students__middlename`, Students.lname AS `Students__lname`, Students.fee_submittedby AS `Students__fee_submittedby`, Students.board_id AS `Students__board_id`, Students.fathername AS `Students__fathername`, Students.mothername AS `Students__mothername`, Students.username AS `Students__username`, Students.password AS `Students__password`, Students.dob AS `Students__dob`, Students.enroll AS `Students__enroll`, Students.mobile AS `Students__mobile`, Students.mobile2 AS `Students__mobile2`, Students.sms_mobile AS `Students__sms_mobile`, Students.formno AS `Students__formno`, Students.adaharnumber AS `Students__adaharnumber`, Students.cast AS `Students__cast`, Students.parent_id AS `Students__parent_id`, Students.house_id AS `Students__house_id`, Students.class_id AS `Students__class_id`, Students.category AS `Students__category`, Students.section_id AS `Students__section_id`, Students.gender AS `Students__gender`, Students.photo AS `Students__photo`, Students.bloodgroup AS `Students__bloodgroup`, Students.religion AS `Students__religion`, Students.address AS `Students__address`, Students.city AS `Students__city`, Students.nationality AS `Students__nationality`, Students.created AS `Students__created`, Students.admissionyear AS `Students__admissionyear`, Students.acedmicyear AS `Students__acedmicyear`, Students.status AS `Students__status`, Students.file AS `Students__file`, Students.comp_sid AS `Students__comp_sid`, Students.opt_sid AS `Students__opt_sid`, Students.h_id AS `Students__h_id`, Students.room_no AS `Students__room_no`, Students.is_transport AS `Students__is_transport`, Students.transportloc_id AS `Students__transportloc_id`, Students.v_num AS `Students__v_num`, Students.dis_fees AS `Students__dis_fees`, Students.dis_transport AS `Students__dis_transport`, Students.is_discount AS `Students__is_discount`, Students.discountcategory AS `Students__discountcategory`, Students.due_fees AS `Students__due_fees`, Students.token AS `Students__token`, Students.rf_id AS `Students__rf_id` FROM studentexamresult Studentexamresult INNER JOIN students Students ON Students.id = (Studentexamresult.stud_id) WHERE (Studentexamresult.exam_id ='".$examid."' AND Studentexamresult.sect_id ='".$section."' AND Students.status ='Y' AND Studentexamresult.class_id ='".$classs."' AND Studentexamresult.marks ='A') GROUP BY Studentexamresult.`stud_id` ORDER BY Students.fname ASC";
 	

   $SQL = $detail;

$std_result_status = $conn->execute( $SQL )->fetchAll('assoc');



 	$this->set('examretest', $std_result_status);
 	
 	
 	 if($this->request->is('post') || $this->request->is('put'))
   {
// pr($this->request->data); die;
   $uid=$this->request->session()->read('Auth.User.id');
       $clidd=sizeof($this->request->data['id']);
       
       
   	for($i=0;$i<$clidd;$i++){
		
		 
	 $conns = ConnectionManager::get('default');
if($this->request->data['marks'][$i] !='' && $this->request->data['id'][$i] !=''){
$conns->execute("UPDATE `studentexamresult` SET `marks`='".$this->request->data['marks'][$i]."',`coordinator_id`='".$uid."' WHERE `id`='".$this->request->data['id'][$i]."'");	
}else{
	    //~ $statusquery = $this->Studentexamresult->find('all')->where(['Studentexamresult.exam_id' =>$this->request->data['exam_id'],'Studentexamresult.etype_id' =>$this->request->data['etype_id'][$i],'Studentexamresult.subject_id' =>$this->request->data['subject_id'][$i],'Studentexamresult.sect_id' =>$this->request->data['sect_id'],'Studentexamresult.class_id' =>$this->request->data['class_id']])->first();
	    
	    //~ if($statusquery['teach_id']!=''){
			
			//~ $teachid=$statusquery['teach_id'];
		//~ }else{
			
			//~ $teachid=$uid;	
		//~ }
		
		
//	$conns->execute("INSERT INTO `studentexamresult`(`stud_id`, `exam_id`, `etype_id`, `subject_id`, `marks`, `teach_id`, `coordinator_id`, `sect_id`, `class_id`, `status`) VALUES ('".$this->request->data['stud_id'][$i]."','".$this->request->data['exam_id']."','".$this->request->data['etype_id'][$i]."','".$this->request->data['subject_id'][$i]."','".$this->request->data['marks'][$i]."','".$teachid."','".$uid."','".$this->request->data['sect_id']."','".$this->request->data['class_id']."','N')");	
	
}
		
		
	}
	
	
	 $this->Flash->success(__('Your Exam Result has been Updated successfully.'));
                
                   return $this->redirect(['action'=>'examcontrolview']);
   
   }


}


public function examcontrolterm($classid=null,$examtypes=null){

		$this->viewBuilder()->layout('admin');

		if($classid && $examtypes){
			
		$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.class_id' => $classid,'Exams.e_type_id' => $examtypes])->order(['Exams.sort' => 'asc'])->toArray();
	$this->set('examtypes', $examtypes);
	$examtypeses = $this->Exams->find('list', [
    'keyField' => 'Examtypes.id',
    'valueField' => 'Examtypes.name'
])->contain(['Examtypes'])->where(['Exams.status' => 'Y'])->order(['Examtypes.sort' => 'ASC'])->toArray();
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
				
 $empid= $this->request->session()->read('Auth.User.tech_id');






$csec = $this->ClasstimeTabs->find('all')->contain(['Classections'])->where(['FIND_IN_SET(\''. $empid .'\',ClasstimeTabs.employee_id)'])->toarray();

foreach ($csec as $key => $value)
{
	$empo=explode(',',$value['employee_id']);
		$subjects=explode(',',$value['subject_id']);
		
		foreach($empo as $j=>$t){
			
			foreach($subjects as $sj=>$st){
				
				if($j==$sj && $t==$empid){
					
				
			
					
			
					$csec = $this->Subjects->find('all')->where(['id'=>$st])->first();
					if($value['classection']['class_id']=="11" || $value['classection']['class_id']=="10"  && ($st=="66" || $st=="67" || $st=="68")){
						
					$sb[]=$csec['id'];
						$classids[] =$value['classection']['class_id'];
					}else if($value['classection']['class_id']=="11" || $value['classection']['class_id']=="10"  && ($st=="65" || $st=="70" || $st=="71")){
						
					$sb[] =$csec['id'];
					$classids[]=$value['classection']['class_id'];
						
					}
				}
				
			}	
			
		}
	

}


$sb=array_unique($sb);


$this->set('classids', $classids);
$this->set('sb', $sb);

$gssh=array('1','2','3');


$csec = $this->ClasstimeTabs->find('all')->Contain(['Subjects'])->where(['Subjects.id IN'=>$gssh,'FIND_IN_SET(\''. $empid .'\',ClasstimeTabs.employee_id)'])->toarray();


foreach ($csec as $key => $value)
{
	
	$gh=array('18','19','1','2');
$csection=$this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classes.id NOT IN'=>$gh,'Classections.id'=>$value['class_id']])->order(['Classections.id'=>'ASC'])->first();
$classs[]=$csection['class_id'];
$sections[]=$csection['section_id'];
$classsectionsid[]=$csection['id'];
}




$this->set('classsectionsid', $classsectionsid);
$this->set('classess', $classs);


$examtypei = $this->Exams->find('all')->contain(['Classes'])->order(['Exams.sort' => 'DESC'])->toArray();
    $this->set('examtypei', $examtypei); 
    
    
    
$examtypesterm1 = $this->Examtypes->find('all')->where(['term' => '1'])->count();



	$this->set('examtypesterm1', $examtypesterm1); 
	$examtypesterm2 = $this->Examtypes->find('all')->where(['term' => '2'])->count();



	$this->set('examtypesterm2', $examtypesterm2); 

$examtypes = $this->Exams->find('list', [
    'keyField' => 'Examtypes.id',
    'valueField' => 'Examtypes.name'])->contain(['Examtypes','Classes'])->order(['Exams.sort' => 'asc'])->toArray();



	$this->set('examtypesi', $examtypes); 





    
    
		
	
	
}
 $empid= $this->request->session()->read('Auth.User.tech_id');
 
$classteachers = $this->Classteachers->find('all')->contain(['Classes','Employees','Sections'])->where(['Classteachers.teach_id' =>$empid,'Classteachers.teacher_type' =>'1'])->order(['Classes.sort' => 'ASC'])->first();
	$this->set('classteachers', $classteachers);
	$useracedemic = $this->Users->find('all')->select(['academic_year'])->where(['role_id' => '1'])->first();
	$this->set('useracedemic', $useracedemic);


	$this->set('examtypesterm2', $examtypesterm2); 
}

public function examcontrolviewsubject($classid=null,$examtypes=null){

		$this->viewBuilder()->layout('admin');

		if($classid && $examtypes){
			
		$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['Exams.class_id' => $classid,'Exams.e_type_id' => $examtypes])->order(['Exams.sort' => 'asc'])->toArray();
	$this->set('examtypes', $examtypes);
	$examtypeses = $this->Exams->find('list', [
    'keyField' => 'Examtypes.id',
    'valueField' => 'Examtypes.name'
])->contain(['Examtypes'])->where(['Exams.status' => 'Y'])->order(['Examtypes.sort' => 'ASC'])->toArray();
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
				
 $empid= $this->request->session()->read('Auth.User.tech_id');






$csec = $this->ClasstimeTabs->find('all')->contain(['Classections'])->where(['FIND_IN_SET(\''. $empid .'\',ClasstimeTabs.employee_id)'])->toarray();
// pr($csec); die;
foreach ($csec as $key => $value)
{
	$empo=explode(',',$value['employee_id']);
		$subjects=explode(',',$value['subject_id']);
		
		foreach($empo as $j=>$t){
			
			foreach($subjects as $sj=>$st){
				
				if($j==$sj && $t==$empid){
					
			
					$csec = $this->Subjects->find('all')->where(['id'=>$st])->first();
					if($value['classection']['class_id']=="11" || $value['classection']['class_id']=="10"  && ($st=="66" || $st=="67" || $st=="68")){
						
					$sb[]=$csec['id'];
						$classids[] =$value['classection']['class_id'];
					}else if($value['classection']['class_id']=="11" || $value['classection']['class_id']=="10"  && ($st=="65" || $st=="70" || $st=="71")){
						
					$sb[] =$csec['id'];
					$classids[]=$value['classection']['class_id'];
						
					}
				}
				
			}	
			
		}
	

}


$sb=array_unique($sb);


$this->set('classids', $classids);
$this->set('sb', $sb);




$csec = $this->ClasstimeTabs->find('all')->where(['FIND_IN_SET(\''. $empid .'\',ClasstimeTabs.employee_id)'])->toarray();


foreach ($csec as $key => $value)
{
	
	$gh=array('18','19','1','2','3','4','6','26','27');
$csection=$this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classes.id NOT IN'=>$gh,'Classections.id'=>$value['class_id']])->order(['Classections.id'=>'ASC'])->first();
if(!empty($csection['class_id'])){
$classs[]=$csection['class_id'];
$sections[]=$csection['section_id'];
$classsectionsid[]=$csection['id'];
}
}



$this->set('classsectionsid', $classsectionsid);
$this->set('classess', $classs);


$examtypei = $this->Exams->find('all')->contain(['Classes'])->order(['Exams.sort' => 'DESC'])->toArray();
    $this->set('examtypei', $examtypei); 
    
    
    
$examtypesterm1 = $this->Examtypes->find('all')->where(['term' => '1'])->count();



	$this->set('examtypesterm1', $examtypesterm1); 
	$examtypesterm2 = $this->Examtypes->find('all')->where(['term' => '2'])->count();



	$this->set('examtypesterm2', $examtypesterm2); 

$examtypes = $this->Exams->find('list', [
    'keyField' => 'Examtypes.id',
    'valueField' => 'Examtypes.name'])->contain(['Examtypes','Classes'])->order(['Exams.sort' => 'asc'])->toArray();



	$this->set('examtypesi', $examtypes); 





    
    
		
	
	
}
 $empid= $this->request->session()->read('Auth.User.tech_id');
 
$classteachers = $this->Classteachers->find('all')->contain(['Classes','Employees','Sections'])->where(['Classteachers.teach_id' =>$empid,'Classteachers.teacher_type' =>'1'])->order(['Classes.sort' => 'ASC'])->first();
	$this->set('classteachers', $classteachers);
	$useracedemic = $this->Users->find('all')->select(['academic_year'])->where(['role_id' => '1'])->first();
	$this->set('useracedemic', $useracedemic);


	$this->set('examtypesterm2', $examtypesterm2); 
}

public function examcontrolview2($classid=null,$examtypes=null){

		$this->viewBuilder()->layout('admin');

		if($classid && $examtypes){
			
		$examtypes = $this->Exams->find('all')->contain(['Classes'])->where(['Exams.class_id' => $classid,'Exams.e_type_id' => $examtypes])->order(['Exams.sort' => 'asc'])->toArray();
	$this->set('examtypes', $examtypes);
	$examtypeses = $this->Exams->find('list', [
    'keyField' => 'Examtypes.id',
    'valueField' => 'Examtypes.name'
])->contain(['Examtypes'])->where(['Exams.status' => 'Y'])->order(['Examtypes.sort' => 'ASC'])->toArray();
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
				


$examtypesterm1 = $this->Examtypes->find('all')->where(['term' => '1'])->count();



	$this->set('examtypesterm1', $examtypesterm1); 
	
	
	$examtypesterm1ss = $this->Exams->find('all')->where(['FIND_IN_SET(\''. $classid .'\',Exams.class_id)'])->count();



	$this->set('examtypesterm1ss', $examtypesterm1ss); 
	$examtypesterm2 = $this->Examtypes->find('all')->where(['term' => '2'])->count();



	$this->set('examtypesterm2', $examtypesterm2); 



    
 $examtypess=$this->Examtypes->find('list', ['keyField' => 'id','valueField' => 'examname'])->where(['Examtypes.status' =>'Y','Examtypes.status2' =>'Y'])->order(['sort' => 'ASC'])->group(['examname'])->toArray();
		// pr($locations); die;



	$this->set('examtypesi', $examtypess); 

	$rolepresent=$this->request->session()->read('Auth.User.role_id');     
	$usersf = $this->Users->find('all')->where(['Users.id' =>'1'])->first();
	
	if($rolepresent=='4'){
		
		$clid=['18','19','1','2','3','4','6','23','24','25'];
		$examtypei = $this->Exams->find('all')->contain(['Classes'])->where(['Classes.id NOT IN'=>$clid,'Exams.termf'=>$usersf['examterm']])->order(['Classes.sort' => 'asc'])->toArray();

$examtypei2 = $this->Exams->find('all')->contain(['Classes'])->where(['Classes.id NOT IN'=>$clid,'Exams.termf'=>$usersf['examterm']])->order(['Classes.sort' => 'asc'])->toArray();
   $this->set('examtypei', $examtypei); 
    $this->set('examtypei2', $examtypei2); 
	}else if($rolepresent=='13'){
			$clid=['18','19','1','2','3','4','6','7','8','9','10','11','12','13','15','17','20','22','26','27'];
			$examtypei = $this->Exams->find('all')->contain(['Classes'])->where(['Classes.id NOT IN'=>$clid,'Exams.termf'=>$usersf['examterm']])->order(['Classes.sort' => 'asc'])->toArray();
$examtypei2 = $this->Exams->find('all')->contain(['Classes'])->where(['Classes.id NOT IN'=>$clid,'Exams.termf'=>$usersf['examterm']])->order(['Classes.sort' => 'asc'])->toArray();

    $this->set('examtypei', $examtypei); 
		  $this->set('examtypei2', $examtypei2); 
	}else if($rolepresent=='1'){
		$examtypei = $this->Exams->find('all')->contain(['Classes'])->where(['Exams.termf'=>$usersf['examterm']])->order(['Exams.sort' => 'asc'])->toArray();


    $this->set('examtypei', $examtypei); 
		
	}


    
    
		$classess = $this->Exams->find('list', [
    'keyField' => 'Exams.id',
    'valueField' => 'Exams.class_id'
])->order(['Exams.sort' => 'asc'])->toArray();
	$this->set('classess', $classess);
	
	
}


}
public function examnewstudents($classid=null,$sectionid=null,$examtypesid=null){

		$this->viewBuilder()->layout('admin');

		if($classid && $examtypesid){
			
		$examtypes = $this->Exams->find('all')->contain(['Classes'])->where(['FIND_IN_SET(\''. $classid .'\',Exams.class_id)','Exams.id' =>$examtypesid])->order(['Exams.sort' => 'asc'])->toArray();
		
	$this->set('examtypes', $examtypes);
	
	$examtypeses = $this->Exams->find('list', [
    'keyField' => 'Examtypes.id',
    'valueField' => 'Examtypes.name'
])->contain(['Examtypes'])->where(['Exams.status' => 'Y'])->order(['Examtypes.sort' => 'ASC'])->toArray();
	$this->set('examtypeses', $examtypeses);
	
	      $articles = TableRegistry::get('Students');
$totalstudents=$articles->find('all')->select('id')->where(['section_id' =>$sectionid,'class_id' =>$classid,'status' =>'Y'])->toarray();

  $articles = TableRegistry::get('Studentexamresult');

$totalstudentsexamresults=$articles->find('all')->select('stud_id')->where(['sect_id' =>$sectionid,'class_id' =>$classid,'exam_id'=>$examtypesid])->group(['stud_id'])->toarray();

    $as=count($totalstudents); 
    $as2=count($totalstudentsexamresults);  
               if($as2 < $as){
				 
				   $art=array();
				   foreach($totalstudentsexamresults as $gh=>$sid){
				   $art[]=$sid['stud_id'];
				   }
			   }
			 
			if(!empty($art)){

$students=$this->Students->find('all')->contain(['Classes','Sections'])->where(['Classes.id' =>$classid,'Sections.id' =>$sectionid,'Students.id NOT IN' =>$art])->order(['Students.id' => 'ASC'])->toArray();
$this->set('students', $students);


}else{
	$students=$this->Students->find('all')->contain(['Classes','Sections'])->where(['Classes.id' =>$classid,'Sections.id' =>$sectionid])->order(['Students.id' => 'ASC'])->toArray();
$this->set('students', $students);
	
}


	
			
		$classes = $this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classes.id' => $classid])->order(['Sections.title' => 'ASC'])->toArray();
			$classeses = $this->Exams->find('list', [
    'keyField' => 'Classes.id',
    'valueField' => 'Classes.title'
])->contain(['Classes'])->order(['Classes.id' => 'asc'])->toArray();
	$this->set('classeses', $classeses);
	$this->set('classes', $classes);
	$this->set('classid', $classid);
		
			
			
		}


}
public function examnewstudentsdetail($studentid=null,$classid=null,$sectionid=null,$examtypesid=null){

		$this->viewBuilder()->layout('admin');

		if($classid && $examtypesid){
			
		$examtypes = $this->Exams->find('all')->contain(['Classes'])->where(['FIND_IN_SET(\''. $classid .'\',Exams.class_id)','Exams.id' =>$examtypesid])->order(['Exams.sort' => 'asc'])->toArray();
		
	$this->set('examtypes', $examtypes);
	
	$examtypeses = $this->Exams->find('list', [
    'keyField' => 'Examtypes.id',
    'valueField' => 'Examtypes.name'
])->contain(['Examtypes'])->where(['Exams.status' => 'Y'])->order(['Examtypes.sort' => 'ASC'])->toArray();
	$this->set('examtypeses', $examtypeses);
	


$students=$this->Students->find('all')->contain(['Classes','Sections'])->where(['Classes.id' =>$classid,'Sections.id' =>$sectionid,'Students.id' =>$studentid])->order(['Students.id' => 'ASC'])->toArray();
$this->set('students', $students);




	$clid=['12','13','15','17','20','22','26','27'];
	if(in_array($students[0]['class']['id'],$clid)){
	$subjectss=$students[0]['comp_sid']; 
	$subjectssopt=$students[0]['opt_sid']; 

$subjects=explode(',',$subjectss);

		
	foreach($subjects as $sj=>$st){
			
				
					$csec = $this->Subjects->find('all')->where(['id'=>$st])->first();
					$sb[] = str_replace(' ', '', $csec['name']);
					
				
					
				}
	
		
$sss=array_unique($sb);

$subjectssopts=explode(',',$subjectssopt);

		
	foreach($subjectssopts as $sjs=>$sts){
			
				
					$csecs = $this->Subjects->find('all')->where(['id'=>$sts])->first();
					$sbs[] = str_replace(' ', '', $csecs['name']);
					
				
					
				}
	
		
$sss2=array_unique($sbs);
$ssstotal=array();
$ssstotal=array_merge($sss,$sss2);

$this->set('ssstotal', $ssstotal);


}



			
		}
		
		
 if($this->request->is('post') || $this->request->is('put')){
 $uid=$this->request->session()->read('Auth.User.id');
       $clidd=sizeof($this->request->data['subject_id']);
    //   pr($this->request->data); die;
       
   	for($i=0;$i<$clidd;$i++){
		
		 
	 $conns = ConnectionManager::get('default');

     $teachid=$uid;	
		
	$conns->execute("INSERT INTO `studentexamresult`(`stud_id`, `term`, `exam_id`, `etype_id`, `subject_id`, `marks`, `teach_id`, `coordinator_id`, `sect_id`, `class_id`, `status`) VALUES ('".$this->request->data['stud_id']."','".$this->request->data['term'][$i]."','".$this->request->data['exam_id']."','".$this->request->data['etype_id'][$i]."','".$this->request->data['subject_id'][$i]."','".$this->request->data['subjecresult'][$i]."','".$teachid."','".$uid."','".$this->request->data['sect_id']."','".$this->request->data['class_id']."','N')");	
	
	
	}
	
	 $this->Flash->success(__('Your Exam Result has been Updated successfully.'));
                
                   return $this->redirect(['action'=>'examcontrolview']);

}


}

	public function examcontrolview($classid=null,$examtypes=null){

		$this->viewBuilder()->layout('admin');

		if($classid && $examtypes){
			
		$examtypes = $this->Exams->find('all')->contain(['Classes'])->where(['Exams.class_id' => $classid,'Exams.e_type_id' => $examtypes])->order(['Exams.sort' => 'asc'])->toArray();
	$this->set('examtypes', $examtypes);
	$examtypeses = $this->Exams->find('list', [
    'keyField' => 'Examtypes.id',
    'valueField' => 'Examtypes.name'
])->contain(['Examtypes'])->where(['Exams.status' => 'Y'])->order(['Examtypes.sort' => 'ASC'])->toArray();
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
				


$examtypesterm1 = $this->Examtypes->find('all')->where(['term' => '1'])->count();



	$this->set('examtypesterm1', $examtypesterm1); 
	$examtypesterm2 = $this->Examtypes->find('all')->where(['term' => '2'])->count();



	$this->set('examtypesterm2', $examtypesterm2); 



    
 $examtypess=$this->Examtypes->find('list', ['keyField' => 'id','valueField' => 'examname'])->where(['Examtypes.status' =>'Y','Examtypes.status2' =>'Y'])->order(['sort' => 'ASC'])->group(['examname'])->toArray();
		// pr($locations); die;



	$this->set('examtypesi', $examtypess); 

	$rolepresent=$this->request->session()->read('Auth.User.role_id');     
			$usersf = $this->Users->find('all')->where(['Users.id' =>'1'])->first();
	if($rolepresent=='4'){
		

		
		$clid=['18','19','1','2','3','4','6','23','24','25'];
		$examtypei = $this->Exams->find('all')->contain(['Classes'])->where(['Classes.id NOT IN'=>$clid,'Exams.termf'=>$usersf['examterm']])->order(['Classes.sort' => 'asc'])->toArray();


    $this->set('examtypei', $examtypei); 
	}else if($rolepresent=='13'){
			$clid=['18','19','1','2','3','4','6','7','8','9','10','11','12','13','15','17','20','22','26','27'];
			$examtypei = $this->Exams->find('all')->contain(['Classes'])->where(['Classes.id NOT IN'=>$clid,'Exams.termf'=>$usersf['examterm']])->order(['Classes.sort' => 'asc'])->toArray();


    $this->set('examtypei', $examtypei); 
		
	}else if($rolepresent=='1'){
		$examtypei = $this->Exams->find('all')->contain(['Classes'])->order(['Classes.sort' => 'asc'])->toArray();


    $this->set('examtypei', $examtypei); 
		
	}


    
    
		$classess = $this->Exams->find('list', [
    'keyField' => 'Exams.id',
    'valueField' => 'Exams.class_id'
])->order(['Exams.sort' => 'asc'])->toArray();
	$this->set('classess', $classess);
	
	
}


}
public function searchresult(){


$class=$this->request->data['class_id'];

$examtypes=$this->request->data['examtypesi']; 

		
$examtypesterm1 = $this->Examtypes->find('all')->where(['term' => '1'])->count();



	$this->set('examtypesterm1', $examtypesterm1); 
	$examtypesterm2 = $this->Examtypes->find('all')->where(['term' => '2'])->count();



	$this->set('examtypesterm2', $examtypesterm2); 
if($examtypes){
$examtypes = $this->Exams->find('all')->contain(['Classes'])->where(['FIND_IN_SET(\''. $class .'\',Exams.class_id)','FIND_IN_SET(\''. $examtypes .'\',Exams.e_type_id)'])->order(['Exams.sort' => 'asc'])->toArray();

}else{

$examtypes = $this->Exams->find('all')->contain(['Examtypes','Classes'])->where(['FIND_IN_SET(\''. $class .'\',Exams.class_id)'])->order(['Exams.sort' => 'asc'])->toArray();

}


	$this->set('examtypes', $examtypes); 

		$classes = $this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classes.id' => $class])->order(['Sections.title' => 'ASC'])->toArray();
	$this->set('classes', $classes);		
		

}
public function resultallupdatemarksscience($classid = null,$section = null,$acedemic=null,$id=null){

	$this->loadModel('Studentexamresult');


			ini_set('max_execution_time', 1600);
	
$this->viewBuilder()->layout('admin');




	$students = 
	$this->Studentexamresult->find('all')->contain(['Students'])->where(['Studentexamresult.class_id' =>$classid,'Studentexamresult.sect_id' =>$section,'Studentexamresult.stud_id' =>$id,'Studentexamresult.term' =>'1','Students.acedmicyear'=>$acedemic,'Students.status'=>'Y'])->order(['Students.enroll' => 'ASC'])->first();

$this->set(compact('students'));

		if ($this->request->is(['post', 'put'])) {
				 $uid=$this->request->session()->read('Auth.User.id');
	 
		 
		 
foreach($this->request->data['marks'] as $kr=>$item){
	
	 

 
 $userTable2 = TableRegistry::get('Studentexamresult');
					$exists2 = $userTable2->exists(['id' =>$kr, 'marks' =>$item]);
					if ($exists2) {
			
		}else{
 $conns = ConnectionManager::get('default');

$conns->execute("UPDATE `studentexamresult` SET `marks`='".$item."',`coordinator_id`='".$uid."' WHERE `id`='".$kr."'");	

}
	
}


 $this->Flash->success(__('Exam Result has been Updated successfully by Coordinator.'));
							
								 return $this->redirect(['action'=>'resultallupdatemarksscience/'.$classid.'/'.$section.'/'.$acedemic.'/'.$id]);
		}
	



}

}
