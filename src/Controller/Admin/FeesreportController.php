<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

class FeesreportController extends AppController
{
    public function initialize()
    {
        ini_set('max_execution_time', 1600);
        parent::initialize();
        $this->loadModel('Enquires');
        $this->loadModel('Classfee');
        $this->loadModel('Classes');
        $this->loadModel('Modes');
        $this->loadModel('Followup');
        $this->loadModel('Students');
        $this->loadModel('DropOutStudent');
        $this->loadModel('Sections');
        $this->loadModel('Employees');
        $this->loadModel('Departments');
        $this->loadModel('Studentfees');
        $this->loadModel('Classections');
        $this->loadModel('Cities');
        $this->loadModel('States');
        $this->loadModel('Country');
        $this->loadModel('Department');
        $this->loadModel('Designations');
        $this->loadModel('Transportfees');
        $this->loadModel('Locations');
        $this->loadModel('Transports');
        $this->loadModel('StudentTransfees');
        $this->loadModel('Hostels');
        $this->loadModel('StudentHostalfees');
        $this->loadModel('BookStatus');
        $this->loadModel('BookCategory');
        $this->loadModel('Guardians');
        $this->loadModel('Studattends');
        $this->loadModel('Events');
        $this->loadModel('Shift');
        $this->loadModel('EmployeeAttendance');
        $this->loadModel('Users');
        $this->loadModel('Feesheads');
        $this->loadModel('DiscountCategory');
        $this->loadModel('Houses');
        $this->loadModel('Smsdelivery');
        $this->loadModel('Smsmanager');
        $this->loadModel('Studentshistory');
        $this->loadModel('Sms');
        $this->loadModel('ExamSubjects');
        $this->loadModel('Transportfees');

        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['po_pdf']);

        require_once 'Firebase.php';
        require_once 'Push.php';
    }

    public function index()
    {
        $this->viewBuilder()->layout('admin');
 
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $academicyear = $users['academic_year'];
        $this->set(compact('academicyear'));
        $sectionslist = $this->Sections->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('sectionslist', $sectionslist);
        $this->set(compact('sectionslist'));
        $classes = $this->Classections->find('list', [
            'keyField' => 'Classes.id',
            'valueField' => 'Classes.title',
        ])->contain(['Classes'])->where(['Classes.status' => '1', 'Classes.board_id' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $this->set('classes', $classes);
    }

    //  public function defaultersearch()
    //  {
    // //     $this->request->session();
    // //     $this->request->write('abc',$this->request->data);
    // //     $year = $this->request->data['acedmicyear'];
    // //     $class = join("','", $this->request->data['class_id']);
    // //     $quater = join("','", $this->request->data['quater']);
    // //     // $session->write('class', $class);
    // //     // if ($class && $year) {
    // //     //     $session->delete('class');
    // //     //     $session->write('class', $class);
    // //     //     $session->delete('academic_year');
    // //     //     $session->write('academic_year', $year);
    // //     //     $session->delete('quater');
    // //     //     $session->write('quater', $quater);
    // //     // } else {
    // //     //     $session->delete('academic_year');
    // //     //     $session->write('academic_year', $year);
    // //     // }
    //  }

    public function defaultersearch()
    {
        $conn = ConnectionManager::get('default');
        $this->loadModel('Students');
        $this->loadModel('Classes');
        $this->loadModel('Sections');

        $this->autoRender = false;
        $academicyear = $this->request->data['acedmicyear'];
        $class_id = $this->request->data['class_id'];
        $section_id = $this->request->data['section_id'];
        $quarter = $this->request->data['quater'];

        $detail = "SELECT Students.id,Students.fname,Students.fathername,Students.board_id,Students.fee_submittedby,Students.sms_mobile,Students.middlename,Students.lname,Students.mobile,Students.discountcategory,Students.acedmicyear,Students.enroll,Students.h_id,Students.class_id,Students.section_id,Students.admissionyear,Students.status,Students.comp_sid,Students.opt_sid,Students.location_id,Classes.title as classtitle ,Classes.sort as csort ,  Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id   WHERE  1=1 ";
        $cond = ' ';
        // pr($class_id);die;

        if (!empty($academicyear)) {

            $cond .= " AND Students.acedmicyear ='" . $academicyear . "'";
            $this->set('academicyear', $academicyear);
        }

        if (!empty($class_id)) {
            $this->set('class_id', $class_id);

            foreach ($class_id as $gg => $rt) {
                $conds[] = "'" . $rt . "'";
            }
            $stuc = implode(',', $conds);
            $cond .= " AND Students.class_id IN(" . $stuc . ")";
        }

        if (!empty($section_id)) {
            $this->set('section_id', $section_id);
            foreach ($section_id as $gsg => $rts) {
                $consds[] = "'" . $rts . "'";
            }
            $stusc = implode(',', $consds);
            $cond .= " AND Students.section_id IN(" . $stusc . ")";
        }

        $cond .= " AND Students.category ='NORMAL'  AND Students.discountcategory !='FREE' AND Students.status ='Y' ORDER BY csort ASC, sectiontitle ASC,Students.fname ASC,Students.middlename ASC ,Students.lname ASC";


        $SQL = $detail . $cond;

        $results = $conn->execute($SQL)->fetchAll('assoc');
        // pr($results); die;

        $this->request->session()->delete('feesreport');
        $this->request->session()->write('feesreport', $results);
// this code for qtr wise show headra
        $this->request->session()->delete('quarters');
        $this->request->session()->write('quarters', $quarter);

    }

    public function feesexcelreport()
    {
        
        $session = $this->request->session();
        $students = $session->read('feesreport');
       
        $quarterss = $session->read('quarters');
     
        $user = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
        $rolepresentyear = $user['academic_year'];

        // $students = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id IN'=>[352]])->order(['Classes.sort' => 'ASC'])->toarray();
        // //   pr($students);exit;

        $this->set('students', $students);
        $quarterone = 0;
        $quartertwo = 0;
        $quarterthree = 0;
        $quarterfour = 0;
        $student_rec  = [];
        $total_q1_data  = [];
        $pendingquater = 0;
        foreach ($students as $value) {
            //  pr($value); die;
       
            $class_id  =  $value['class_id'];
            $classfee = $this->Classfee->find('all')->where(['class_id' => $class_id, 'academic_year' => $rolepresentyear])->toarray();
            // pr($classfee);exit;

            $transport_fees = $this->Transportfees->find('all')->where(['loc_id' => $value['location_id'], 'academic_year' => $rolepresentyear])->first();
            // pr($transport_fees);
            $fee_heads = $this->Feesheads->find('all')->first();

            if ($transport_fees) {
                $transport_fees_total = $transport_fees['quarter1'] + $transport_fees['quarter2'] + $transport_fees['quarter3'] + $transport_fees['quarter4'];
            } else {
                $transport_fees_total = 0;
            }
            // Tution_fees
            $tution_fees = $classfee[0]['qu1_fees'] + $classfee[0]['qu2_fees'] + $classfee[0]['qu3_fees'] + $classfee[0]['qu4_fees'];
            // Admission_fees
            $admission_fees = $classfee[1]['qu1_fees'] + $classfee[1]['qu2_fees'] + $classfee[1]['qu3_fees'] + $classfee[1]['qu4_fees'];

            $caution_fees = $classfee[2]['qu1_fees'] + $classfee[2]['qu2_fees'] + $classfee[2]['qu3_fees'] + $classfee[2]['qu4_fees'];

            $other_fees = $classfee[3]['qu1_fees'] + $classfee[3]['qu2_fees'] + $classfee[3]['qu3_fees'] + $classfee[3]['qu4_fees'];

            $student_rec['enrollno'] = $value['enroll'];
            $student_rec['studentname'] =  ucwords(strtolower($value['fname'] . ' ' . $value['middlename'] . '' . $value['lname']));
            $student_rec['classtitle'] = $value['classtitle'] . "-" . $value['sectiontitle'];
            $student_rec['fathername'] = ucfirst($value['fathername']);
            $student_rec['mobile'] = $value['mobile'];
            $student_fees_record = $this->studentfeesget($value['id'], $rolepresentyear,$classfee);
            // pr($student_fees_record); die;

            if ($rolepresentyear != $value['admissionyear']) {
                if (array_key_exists("Admission Fee", $student_fees_record)) {
                    $student_rec['totalfees'] =  $tution_fees + $caution_fees + $admission_fees;
                } else {

                    $student_rec['totalfees'] =  $tution_fees + $caution_fees;
                }
                $student_rec['totaltransportfees'] =  $transport_fees_total;
                $student_rec['package'] =   $student_rec['totalfees'] + $caution_fees + $transport_fees_total;
                $admission_fee = 'N/A';
                $caution_money_pending =  "N/A";
                $admission_pending = 0;
                $caution_money = 0;
            } else {
                // Admission Fee
                if (array_key_exists("Admission Fee", $student_fees_record)) {
                    $admission_fee = ($student_fees_record['Admission Fee'] == 0) ? 'N/A' : $student_fees_record['Admission Fee'];
                    // $admission_pending =$student_fees_record['Admission Fee'];
                    $admission_feeadd = $admission_fees;
                } else {
                    $admission_feeadd = $admission_fees;
                    $admission_fee = "--";
                }

                // Caution Money
                if (array_key_exists("Caution Money", $student_fees_record)) {
                    $caution_money_pending = ($student_fees_record['Caution Money'] == 0) ? 'N/A' : $student_fees_record['Caution Money'];
                    $caution_money = $student_fees_record['Caution Money'];
                } else {
                    $caution_money = $caution_fees;
                    $caution_money_pending = '--';
                }

                // pr($transport_fees_total);exit;
                $student_rec['totalfees'] =  $tution_fees + $admission_feeadd + $caution_money + $transport_fees_total;
                $student_rec['package'] =    $tution_fees + $admission_feeadd + $caution_money + $transport_fees_total;
                $student_rec['totaltransportfees'] =  $transport_fees_total;
            }
            // pr($student_rec['totalfees']);exit;

            $studentpending = $this->studentpendingfees($value['id']);

            if (array_key_exists("Quater1", $student_fees_record)) {
                $qu1_fees =  $student_fees_record['Quater1'];
                // pr($qu1_fees);
                $qu1pendingfees = 0;
            } else {
                $qu1pendingfees =  $classfee[0]['qu1_fees'];
                $qu1_fees = "--";
            }
            if (array_key_exists("Quater2", $student_fees_record)) {
                $qu2_fees =   $student_fees_record['Quater2'];
                // pr($qu2_fees);
                $qu2pendingfees = 0;
            } else {
                $qu2pendingfees =  $classfee[0]['qu2_fees'];
                $qu2_fees = "--";
            }
            if (array_key_exists("Quater3", $student_fees_record)) {
                $qu3_fees =   $student_fees_record['Quater3'];
                // pr($qu3_fees);
                $qu3pendingfees = 0;
            } else {
                $qu3pendingfees =  $classfee[0]['qu3_fees'];
                $qu3_fees = "--";
            }
            if (array_key_exists("Quater4", $student_fees_record)) {
                $qu4_fees =   $student_fees_record['Quater4'];
                // pr($qu4_fees);exit;
                $qu4pendingfees = 0;
            } else {
                $qu4pendingfees =  $classfee[0]['qu4_fees'];
                $qu4_fees = "--";
            }


            if (array_key_exists("Transport5", $student_fees_record)) {
                $transport1_fees =  $student_fees_record['Transport5'];
                $tranport1pendingfees = 0;
            } else {
                $tranport1pendingfees =  $transport_fees['quarter1'];
                $transport1_fees = "--";
            }
            if (array_key_exists("Transport6", $student_fees_record)) {
                $transport2_fees =   $student_fees_record['Transport6'];
                $tranport2pendingfees = 0;
            } else {
                $tranport2pendingfees =  $transport_fees['quarter2'];
                $transport2_fees = "--";
            }
            if (array_key_exists("Transport7", $student_fees_record)) {
                $transport3_fees =   $student_fees_record['Transport7'];
                $tranport3pendingfees = 0;
            } else {
                $tranport3pendingfees =  $transport_fees['quarter3'];
                $transport3_fees = "--";
            }
            if (array_key_exists("Transport8", $student_fees_record)) {
                $transport4_fees =   $student_fees_record['Transport8'];
                $tranport4pendingfees = 0;
            } else {
                $tranport4pendingfees =  $transport_fees['quarter4'];
                $transport4_fees = "--";
            }

            // pr($admission_fee);exit;
            $student_rec['admissionfee'] =  $admission_fee;
            $student_rec['caution_money'] =   $caution_money_pending;
            $student_rec['qu1_fees'] =   $qu1_fees + $student_fees_record['qtr_discount'];
            $student_rec['qu2_fees'] =   $qu2_fees;
            $student_rec['qu3_fees'] =   $qu3_fees;
            $student_rec['qu4_fees'] =  $qu4_fees;
            $student_rec['qu1_fees_due'] = $classfee[0]['qu1_fees'] - $qu1_fees-$student_fees_record['qtr_discount'];
            $student_rec['qu2_fees_due'] = $classfee[0]['qu2_fees'] - $qu2_fees;
            $student_rec['qu3_fees_due'] = $classfee[0]['qu3_fees'] - $qu3_fees;
            $student_rec['qu4_fees_due'] = $classfee[0]['qu4_fees'] - $qu4_fees;

        // pr($transport_fees['quarter1']); die;


            if ($transport_fees) {

                $student_rec['transport1_fees'] =   $transport1_fees;
                $student_rec['transport2_fees'] =   $transport2_fees;
                $student_rec['transport3_fees'] =   $transport3_fees;
                $student_rec['transport4_fees'] =   $transport4_fees;
                $student_rec['transport1_fees_due'] = $transport_fees['quarter1'] - $transport1_fees;
                $student_rec['transport2_fees_due'] = $transport_fees['quarter2'] - $transport2_fees;
                $student_rec['transport3_fees_due'] = $transport_fees['quarter3'] - $transport3_fees;
                $student_rec['transport4_fees_due'] = $transport_fees['quarter4'] - $transport4_fees;
            } else {
                $student_rec['transport1_fees'] =   '--';
                $student_rec['transport2_fees'] =   '--';
                $student_rec['transport3_fees'] =   '--';
                $student_rec['transport4_fees'] =   '--';
            }

            $transport_pending = $tranport1pendingfees + $tranport2pendingfees + $tranport3pendingfees + $tranport4pendingfees;

            $student_rec['pending_fees'] = $studentpending[0]['sum'] + $qu1pendingfees + $qu2pendingfees + $qu3pendingfees + $qu4pendingfees + $admission_pending + $caution_money + $transport_pending;
            $student_rec['pending_transport_fees'] = $transport_pending;
            $student_rec['total_deposite_amount'] = $student_fees_record['totalDeposite'];
            // pr($student_fees_record);exit;

            if (!empty($student_fees_record['discount'] || $student_fees_record['addtionaldiscount'])) {

                if (!empty($student_fees_record['discount'])) {

                    // $student_rec['discount'] =  $student_fees_record['discount'];
                    $student_rec['discount'] =  $student_fees_record['qtr_discount'];
                } else if (!empty($student_fees_record['addtionaldiscount'])) {

                    // $student_rec['discount'] =  $student_fees_record['addtionaldiscount'];
                    $student_rec['discount'] =  $student_fees_record['addtionaldiscount'];
                }
            } else {
                $student_rec['discount'] = 0;
            }

            foreach ($fee_heads as $val_heads) {
                $student_rec[$val_heads['name']] =   $val_heads['cbse_fee'];
            }

            $student_rec_all[] =  $student_rec;
        //  pr($student_rec_all); die;
        }
      
        // pr($quarterss); die;
        $this->set('student_rec_all', $student_rec_all); 
        $this->set('qtrwise', $quarterss); 
    }

    public function studentpendingfees($student_id = null)
    {
        // pr($student_id);exit;

        $articles = TableRegistry::get('Studentfeepending');
        $query = $articles->find('all');
        return $query->select(['sum' => $query->func()->sum('Studentfeepending.amt')])->where(['Studentfeepending.s_id' => $student_id, 'Studentfeepending.status' => 'N'])->toarray();
    }
    public function studentfeesget($student_id = null, $academic_year = null,$qtr = null)
    {
       
        // $user = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
        // $rolepresentyear = $user['academic_year'];
        $rolepresentyear = $academic_year;
        $studentfeesdetails = $this->Studentfees->find('all')->where(['Studentfees.student_id' =>$student_id, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.acedmicyear' => $rolepresentyear])->toarray();
      
        $alldiscount = 0;
        $allDeposite = 0;
        foreach ($studentfeesdetails as $k => $value) {
            
          
            $quas[] = unserialize($value['quarter']);
        
        
            $alldiscount += $value['discount'];
            $alldiscount += $value['addtionaldiscount'];
            $quas[$k]['deposite_amt'] = $value['deposite_amt'];
        }
        foreach ($quas as $key => $val) {
             
     
            // this is use to find qtr1 discount
            if (array_key_exists("Quater1", $val)) {
                $lst_st_data['qtr_discount'] += $value['discount']; 

                if($val['Quater1']==$qtr[0]['qu1_fees']){
                    $lst_st_data['pending_deposite1'] = $qtr[0]['qu1_fees']-$value['deposite_amt'];
                }

                
            }
            
      


//             $data_keys =  array_keys($val);
           
//             foreach ($data_keys as $valddd) {

                
//                 if ($valddd == 'deposite_amt') {
//                     continue;
//                 }
//                 $lst_st_data[$valddd]   = round($val['deposite_amt'] / (count($data_keys) -1));
// //  pr($lst_st_data[$valddd]);exit;
//                 // $lst_st_data[$valddd]   =  $val[$valddd]/(count($data_keys)-1);
//             }
            $allDeposite += $val['deposite_amt'];
        }
        $lst_st_data['totalDeposite'] = $allDeposite;
        $lst_st_data['discount'] = $alldiscount;
        $discount_cat = ($value['discountcategory'] == '') ? 'Additional Discount' : $value['discountcategory'];
        $lst_st_data['discountcategory']   =  preg_replace('/\s+/', '', $discount_cat);
        //pr($lst_st_data); die;
        return $lst_st_data;
    }
}
