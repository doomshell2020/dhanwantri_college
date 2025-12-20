<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class StudentfeesController extends AppController
{
  //initialize component

  public function initialize()
  {

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
    $this->loadModel('Locations');
    $this->loadModel('Routemaster');
    $this->loadModel('Transports');
    $this->loadModel('Transportstudentlist');
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
    $this->loadModel('Otherfees');
    $this->loadModel('DiscountCategory');


    // if($_SERVER['HTTP_CF_CONNECTING_IP']=='117.99.160.146'){

    //     }else{
    //      $this->redirect($this->referer());
    //     }

  }

  public function rollbackscomplete()
  {
    $this->autoRender = false;
    $studentfees = $this->Studentfees->find('all')->where(['Studentfees.acedmicyear' => '2019-20', 'Studentfees.type' => 'Fee', 'Studentfees.recipetno !=' => 0, 'Studentfees.status' => 'Y'])->toarray();
    foreach ($studentfees as $studentfees) {
      $quarter = $studentfees['quarter'];
      $student_id = $studentfees['student_id'];
      $acedmicyear = $studentfees['acedmicyear'];
      $feesid = $studentfees['id'];
      $deposite_amt = (int) $studentfees['deposite_amt'];

      $aee = unserialize($quarter);

      $amoutpay = 0;
      foreach ($aee as $kru => $amtr) {

        $amoutpay += (int) $amtr;
      }

      if ($studentfees['lfine'] != '') {

        $total = (int) $studentfees['lfine'] + (int) $amoutpay;
      } else {
        $total = (int) $amoutpay;
      }

      $studentfeependings = $this->Studentfeepending->find('all')->where(['r_id' => $feesid, 's_id' => $student_id])->first();
      //pr($studentfeependings); die;
      if ($studentfeependings['id']) {

        if ($studentfeependings['amt'] > 0) {

          $net = (int) $total - (int) $studentfeependings['amt'];
        } else if ($studentfeependings['amt'] < 0) {
          $studentfeependings['amt'] = abs($studentfeependings['amt']);
          $net = (int) $total + (int) $studentfeependings['amt'];
        }
      } else {

        $net = (int) $total;
      }

      if ($studentfees['discount'] != '0.00' || $studentfees['discount'] != '0') {
        $net = (int) $net - (int) $studentfees['discount'];
      } else {
        $net = (int) $net;
      }

      if ($studentfees['addtionaldiscount'] != '0') {
        $net = (int) $net - (int) $studentfees['addtionaldiscount'];
      } else {
        $net = (int) $net;
      }

      if ($net == $deposite_amt) {
      } else {

        if ($studentfees['id']) {
          echo $studentfees['recipetno'] . '/' . $net . '/' . $deposite_amt . '<br>';
        }
      }
    }
  }

  public function viewsibling($id = null)
  {

    $stdnt = $this->Students->find('all')->where(['Students.id' => $id])->first();
    $fathername = $stdnt['fathername'];
    $mothername = $stdnt['mothername'];
    $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.fathername' => $fathername, 'Students.mothername' => $mothername, 'Students.id NOT IN' => $id, 'Students.status' => 'Y'])->toarray();
    $this->set('students', $student_data);
  }

  public function previousduefees($id = null)
  {

    $this->viewBuilder()->layout('admin');
    if (isset($id) && !empty($id)) {
      //using for edit
      $previousduefees = $this->Previousduefees->get($id);
    } else {
      //using for new entry
      $previousduefees = $this->Previousduefees->newEntity();
    }
    if ($this->request->is(['post', 'put'])) {

      //    pr($this->request->data); die;

      // save all data in database
      $acedmicyear = $this->request->data['acedmicyear'];
      $stid = $this->request->data['student_id'];
      $previousduefees = $this->Previousduefees->patchEntity($previousduefees, $this->request->data);
      //pr($previousduefees); die;
      if ($this->Previousduefees->save($previousduefees)) {
        $conn = ConnectionManager::get('default');
        $conn->execute("UPDATE `students` SET `due_fees` = '0' WHERE `id`='" . $stid . "'");
        $this->Flash->success(__('Previous Due Fees has been saved.'));
        // return $this->redirect(['action' => 'index/' . $stid . '/' . $acedmicyear . '/?id=pduefee']);
        return $this->redirect(['action' => 'view/' . $stid]);
      } else { //pr($classes->errors());
        //validation error
        if ($locations->errors()) {
          $error_msg = [];
          foreach ($locations->errors() as $errors) {
            if (is_array($errors)) {
              foreach ($errors as $error) {
                $error_msg[] = $error;
              }
            } else {
              $error_msg[] = $errors;
            }
          }
          if (!empty($error_msg)) {
            $this->Flash->error(
              __("Please fix the following error(s): " . implode("\n \r", $error_msg))
            );
          }
        }
      }
    }

    $this->set('previousduefees', $previousduefees);
  }

  public function studentfeeindex($id = null, $academic_year = null)
  {

    $this->viewBuilder()->layout('admin');

    $feesheadstotal = $this->Feesheads->find('all', [
      'keyField' => 'id',
      'valueField' => 'name',
    ])->where(['status' => 'Y', 'type IN' => ['3', '0']])->order(['name' => 'ASC'])->toArray();
    $this->set('feesheadstotal', $feesheadstotal);

    $discountCategorylist = $this->DiscountCategory->find('all', [
      'keyField' => 'id',
      'valueField' => 'name',
    ])->where(['status' => 'Y', 'type' => '0'])->order(['id' => 'ASC'])->toArray();
    $this->set('discountCategorylist', $discountCategorylist);
    //show data in listing
    if ($_GET['id']) {

      $this->set('selectid', $_GET['id']);
    }

    if ($this->request->session()->read('paydatef')) {
      $paydatef = $this->request->session()->read('paydatef');

      $ids2s = $this->request->session()->read('reciptnof');
      $this->set('paydatef', $paydatef);
      if ($ids2s != '0') {
        $reciptnof = $ids2s + 1;

        $this->set('reciptnof', $reciptnof);
      }
    }
    //echo $this->request->session()->read('openfess_recipt'); die;

    $stdnt = $this->Students->get($id);
    $discount_fees = $stdnt->dis_fees;
    $dis_hostel = $stdnt->dis_hostel;
    $dis_transport = $stdnt->dis_transport;
    $classid = $stdnt->class_id;
    $academic_year = $academic_year;

    $alldata = $this->Classfee->find('all')->contain(['Feesheads'])->where(['class_id' => $classid, 'academic_year' => $academic_year])->toarray();
    $personalduefees = $this->Previousduefees->find('all')->where(['Previousduefees.student_id' => $id])->first();
    $Sitesettings = $this->Sitesettings->find('all')->where(['Sitesettings.print' => '1'])->first();
    $this->set('Sitesettings', $Sitesettings);
    $this->set('personalduefees', $personalduefees);
    $this->set('alldata', $alldata);
    $this->set('id', $id);
    $this->set('academic_year', $academic_year);

    if (!empty($discount_fees)) {
      $this->set('discount_fees', $discount_fees);
    } else {
      $discount_fees = '0';
      $this->set('discount_fees', $discount_fees);
    }
    if (!empty($dis_hostel)) {
      $this->set('dis_hostel', $dis_hostel);
    } else {
      $dis_hostel = '0';
      $this->set('dis_hostel', $dis_hostel);
    }
    if (!empty($dis_transport)) {
      $this->set('dis_transport', $dis_transport);
    } else {
      $dis_transport = '0';
      $this->set('dis_transport', $dis_transport);
    }

    $feeheads = $this->Feesheads->find('all')->where(['Feesheads.status' => 'Y'])->toarray();
    $this->set('feeheads', $feeheads);

    $feeheadstype = $this->Feesheads->find('all')->where(['Feesheads.type' => '2'])->toarray();
    $this->set('feeheadstype', $feeheadstype);
    $classfeesss = $this->Classfee->find('all')->contain(['Classes', 'Feesheads'])->group('Classfee.academic_year')->group('Classfee.class_id')->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => $this->Classfee->find()->func()->sum('Classfee.qu1_fees'), 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.qu1_date', 'Feesheads.name', 'Classfee.qu2_date', 'Classfee.qu3_date', 'Classfee.qu4_date', 'Classfee.status', 'Classfee.class_id'])->toarray();
    $this->set('classfeesss', $classfeesss);
    $classes = $this->Classections->find('list', [
      'keyField' => 'Classes.id',
      'valueField' => 'Classes.title',
    ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
    $this->set('classes', $classes);

    $sectionslist = $this->Sections->find('list', [
      'keyField' => 'id',
      'valueField' => 'title',
    ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
    $this->set('sectionslist', $sectionslist);
    $this->set('id', $id);
    $banks = $this->Banks->find('list', [
      'keyField' => 'id',
      'valueField' => 'name'
    ])->where(['Banks.status' => 'Y'])->order(['Banks.id' => 'asc'])->toArray();
    $this->set('banks', $banks);

    $rolepresent = $this->request->session()->read('Auth.User.role_id');
    if ($rolepresent == '1' || $rolepresent == '6') {
      $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.status' => 'Y'])->first();
      $this->set('students', $student_data);
    } else if ($rolepresent == '5') {
      $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.status' => 'Y'])->first();
      $this->set('students', $student_data);
    } else if ($rolepresent == '8') {

      $boards = ['2', '3'];
      $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.board_id IN' => $boards, 'Students.status' => 'Y'])->first();
      $this->set('students', $student_data);
    }

    $acedmicyear = $academic_year;
    $this->set('academic_year', $academic_year);
    $acedmiclassid = $student_data['class_id'];
    $this->set('academic_class', $acedmiclassid);
    $is_transport = $student_data['is_transport'];
    $is_hostel = $student_data['is_hostel'];

    $this->set('is_transport', $is_transport);
    $this->set('is_hostel', $is_hostel);

    $transportloc_id = $student_data['transportloc_id'];
    $this->set('transportloc_id', $transportloc_id);

    $hostal_id = $student_data['h_id'];
    $this->set('hostal_id', $hostal_id);

    $this->set('id', $id);
    $transportfeess = $this->Transportfees->find('all')->where(['Transportfees.loc_id' => $transportloc_id, 'Transportfees.academic_year' => $acedmicyear])->toarray();
    $this->set('transportfeess', $transportfeess);

    $hostalfeess = $this->Hostels->find('all')->where([
      'Hostels.id' =>
      $hostal_id,
      'Hostels.academicyear' => $acedmicyear
    ])->toarray();
    $this->set('hostalfeess', $hostalfeess);

    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();
    $this->set('studentfees', $student_datas);

    //$student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y', 'Studentfees.deposite_amt !=' => '0'])->toarray();
    $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();
    $this->set('studentfeesk', $student_datask);

    $student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $id, 'Studentfeepending.status' => 'N'])->toarray();
    $this->set('student_feepending', $student_feepending);

    $student_datash = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->group(['Studentfees.created'])->toarray();
    $this->set('stduefee', $student_datash);

    $student_trans = $this->StudentTransfees->find('all')->where(['StudentTransfees.student_id' => $id, 'StudentTransfees.acedmicyear' => $acedmicyear])->toarray();
    $this->set('studenttransfee', $student_trans);
    $student_hostal = $this->StudentHostalfees->find('all')->where(['StudentHostalfees.student_id' => $id, 'StudentHostalfees.student_id' => $id])->toarray();
    $this->set('studenthostalfee', $student_hostal);
    $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->where(['Classfee.fee_h_id IN' => ['2', '9'], 'Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid])->order(['Classfee.id' => 'ASC'])->select([
      'qu1_fees' => 'Classfee.qu1_fees',
      'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'),
      'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'),
      'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),
      'Classes.title',
      'Classfee.academic_year',
      'Classfee.id',
      'Classfee.status',
      'Classfee.class_id',
    ])->toarray();

    $this->set('classfee', $classfee);
    $fid = ['7', '3', '4', '9'];
    $sfee =
      $this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid, 'Classfee.fee_h_id IN' => $fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
    $this->set('preclassfee', $sfee);
  }

  public function paynow()
  {
    $this->viewBuilder()->layout('admin');
    $user = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
    $rolepresentyear = $user['academic_year'];

    $this->set(compact('rolepresentyear'));

    $rolepresent = $this->request->session()->read('Auth.User.role_id');

    if ($rolepresent == '1' || $rolepresent == '6') {
      $classes = $this->Classections->find('list', [
        'keyField' => 'Classes.id',
        'valueField' => 'Classes.title',
      ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
      $this->set('classes', $classes);
    } else if ($rolepresent == '5') {

      $classes = $this->Classections->find('list', [
        'keyField' => 'Classes.id',
        'valueField' => 'Classes.title',
      ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
      $this->set('classes', $classes);
    } else if ($rolepresent == '8') {

      $classes = $this->Classections->find('list', [
        'keyField' => 'Classes.id',
        'valueField' => 'Classes.title',
      ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
      $this->set('classes', $classes);
    }

    $sectionslist = $this->Sections->find('list', [
      'keyField' => 'id',
      'valueField' => 'title',
    ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
    $this->set('sectionslist', $sectionslist);

    if ($rolepresent == '1' || $rolepresent == '6') {
      $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => 'Y'])->order(['Students.id' => 'DESC', 'Students.fname' => 'ASC'])->toarray();
      $this->set('students', $student_data);
    } else if ($rolepresent == '5') {

      $student_data =
        $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => 'Y'])->order(['Students.id' => 'DESC', 'Students.fname' => 'ASC'])->limit(20)->toarray();
      $this->set('students', $student_data);
    } else if ($rolepresent == '8') {

      $student_data =
        $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => 'Y'])->order(['Students.id' => 'DESC', 'Students.fname' => 'ASC'])->limit(20)->toarray();
      $this->set('students', $student_data);
    }
    //get data from paricular id

  }

  public function findfeeheadsid($name)
  {

    $articles = TableRegistry::get('Feesheads');
    return $articles->find('all')->where(['Feesheads.name' => $name])->first();
  }

  public function findfeeheadsamount($id, $a_year, $feeheads)
  {
    // pr ($rout); die;
    // Use the HTML helper to output
    // Formatted data:
    $articles = TableRegistry::get('Classfee');

    // Start a new query.

    return $articles->find('all')->contain(['Classes'])->group('Classfee.academic_year')->group('Classfee.class_id')->select([
      'qu1_fees' => $articles->find()->func()->sum('Classfee.qu1_fees'),
      'qu2_fees' => $articles->find('all')->func()->sum('Classfee.qu2_fees'),
      'qu3_fees' => $articles->find('all')->func()->sum('Classfee.qu3_fees'),
      'qu4_fees' => $articles->find('all')->func()->sum('Classfee.qu4_fees'),
      'Classes.title',
      'Classfee.academic_year',
      'Classfee.id',
      'Classfee.status',
      'Classfee.class_id',
    ])->where(['Classfee.class_id' => $id, 'Classfee.fee_h_id' => $feeheads, 'Classfee.academic_year' => $a_year])->order(['Classfee.id' => 'ASC'])->toArray();
  }

  public function findpendingssinglefee($id, $acedmicyear)
  {

    $articles = TableRegistry::get('Studentfeepending');
    $query = $articles->find('all');
    return $query->contain(['Studentfees'])->select(['sum' => $query->func()->sum('Studentfeepending.amt')])->where(['Studentfeepending.s_id' => $id, 'Studentfeepending.status' => 'N', 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfeepending.amt >' => '0'])->toarray();
  }

  public function defaultersearchbyidhistory($id = null, $acedmicyear = null)
  {

    $this->autoRender = false;
    $conn = ConnectionManager::get('default');

    $mode = '';
    $quarter = "Quater4";

    $detail = "SELECT 	Studentshistory.id,Studentshistory.stud_id,Studentshistory.fname,Studentshistory.fathername,Studentshistory.board_id,Studentshistory.fee_submittedby,Studentshistory.sms_mobile,Studentshistory.middlename,Studentshistory.lname,Studentshistory.mobile,Studentshistory.discountcategory,Studentshistory.acedmicyear,Studentshistory.enroll,Studentshistory.oldenroll,Studentshistory.h_id,Studentshistory.class_id,Studentshistory.section_id,Studentshistory.admissionyear,Studentshistory.status,  Classes.title as classtitle ,Classes.sort as csort ,  Sections.title as sectiontitle FROM `studentshistory` Studentshistory LEFT JOIN classes Classes ON Studentshistory.`class_id` = Classes.id LEFT JOIN sections Sections ON Studentshistory.`section_id` = Sections.id    WHERE  1=1 ";
    $cond = ' ';

    if (!empty($id)) {

      $cond .= " AND Studentshistory.stud_id ='" . $id . "'";
    }

    if (!empty($acedmicyear)) {

      $cond .= " AND Studentshistory.acedmicyear LIKE '" . $acedmicyear . "' ";
    }

    $cond .= " AND Studentshistory.category ='NORMAL' AND Studentshistory.discountcategory !='FREE' AND Studentshistory.status ='Y' ORDER BY csort ASC, sectiontitle ASC,Studentshistory.fname ASC";

    if (!empty($quarter)) {
      if ($quarter == "Quater1") {
        $quater[] = "Admission Fee";
        $quater[] = "Development Fee";
        $quater[] = "Caution Money";
        $quater[] = "Miscellaneous Fee";
        $quater[] = "Quater1";

        $quaters[] = "Adm. Fee";
        $quaters[] = "Dev. Fee";
        $quaters[] = "Ca. Money";
        $quaters[] = "Misc. Fee";
        $quaters[] = "Quater1";
      } else if ($quarter == "Quater2") {

        $quater[] = "Admission Fee";
        $quater[] = "Development Fee";
        $quater[] = "Caution Money";
        $quater[] = "Miscellaneous Fee";
        $quater[] = "Quater1";
        $quater[] = "Quater2";

        $quaters[] = "Adm. Fee";
        $quaters[] = "Dev. Fee";
        $quaters[] = "Ca. Money";
        $quaters[] = "Misc. Fee";
        $quaters[] = "Quater1";
        $quaters[] = "Quater2";
      } else if ($quarter == "Quater2") {

        $quater[] = "Admission Fee";
        $quater[] = "Development Fee";
        $quater[] = "Caution Money";
        $quater[] = "Miscellaneous Fee";
        $quater[] = "Quater1";
        $quater[] = "Quater2";

        $quaters[] = "Adm. Fee";
        $quaters[] = "Dev. Fee";
        $quaters[] = "Ca. Money";
        $quaters[] = "Misc. Fee";
        $quaters[] = "Quater1";
        $quaters[] = "Quater2";
      } else if ($quarter == "Quater3") {

        $quater[] = "Admission Fee";
        $quater[] = "Development Fee";
        $quater[] = "Caution Money";
        $quater[] = "Miscellaneous Fee";
        $quater[] = "Quater1";
        $quater[] = "Quater2";
        $quater[] = "Quater3";

        $quaters[] = "Adm. Fee";
        $quaters[] = "Dev. Fee";
        $quaters[] = "Ca. Money";
        $quaters[] = "Misc. Fee";
        $quaters[] = "Quater1";
        $quaters[] = "Quater2";
        $quaters[] = "Quater3";
      } else if ($quarter == "Quater4") {

        $quater[] = "Admission Fee";
        $quater[] = "Development Fee";
        $quater[] = "Caution Money";
        $quater[] = "Miscellaneous Fee";
        $quater[] = "Quater1";
        $quater[] = "Quater2";
        $quater[] = "Quater3";
        $quater[] = "Quater4";

        $quaters[] = "Adm. Fee";
        $quaters[] = "Dev. Fee";
        $quaters[] = "Ca. Money";
        $quaters[] = "Misc. Fee";
        $quaters[] = "Quater1";
        $quaters[] = "Quater2";
        $quaters[] = "Quater3";
        $quaters[] = "Quater4";
      }
    } else {

      $quater[] = "Admission Fee";
      $quater[] = "Development Fee";
      $quater[] = "Caution Money";
      $quater[] = "Miscellaneous Fee";
      $quater[] = "Quater1";
      $quater[] = "Quater2";
      $quater[] = "Quater3";
      $quater[] = "Quater4";

      $quaters[] = "Adm. Fee";
      $quaters[] = "Dev. Fee";
      $quaters[] = "Ca. Money";
      $quaters[] = "Misc. Fee";
      $quaters[] = "Quater1";
      $quaters[] = "Quater2";
      $quaters[] = "Quater3";
      $quaters[] = "Quater4";
    }

    $this->set('quaters', $quater);

    $this->set('quatersf', $quaters);

    $SQL = $detail . $cond;

    $results = $conn->execute($SQL)->fetchAll('assoc');

    $academicyear = $acedmicyear;
    $this->set(compact('academicyear'));

    ini_set('max_execution_time', 1600);

    $headerRow2[] = "S.No";
    $headerRow2[] = "Sr.No";
    $headerRow2[] = "Student";
    $headerRow2[] = "Class-Section";
    $headerRow2[] = "Father";
    $headerRow2[] = "Mobile";

    foreach ($quaters as $j => $el) {
      $el = trim($el);

      $headerRow2[] = $el;
    }
    $headerRow2[] = "Previous Dues";
    $headerRow2[] = "(-)Discount Fee";
    $headerRow2[] = "Due Fees";

    $this->set(compact('headerRow2'));

    if (isset($results) && !empty($results)) {
      $fees = 0;

      $counter = 1;
      $feestotalqus = 0;
      $feestotalqus2 = 0;
      $feestotalqus3 = 0;
      $feestotalqus4 = 0;
      $perticular_feestotal = 0;
      $total_discount = 0;
      $total_due_amount = 0;
      $total_dues_amount = 0;

      foreach ($results as $h => $service) {
        $result = array();
        $fedd = 0;

        $result[] = $counter;
        $result[] = $service['enroll'];
        $result[] = "<a  target='_blank' href=" . ADMIN_URL . "studentfees/index/" . $service['id'] . ">" . $service['fname'] . " " . $service['middlename'] . " " . $service['lname'] . "</a>";

        $s_id = $service['class_id'];
        $c_id = $service['section_id'];

        $classssr = $this->Classes->find('all')->select(['id', 'title'])->where(['id' => $s_id])->order(['id' => 'ASC'])->first();

        $sectionssss = $this->Sections->find('all')->select(['id', 'title'])->where(['id' => $c_id])->order(['title' => 'ASC'])->first();

        $result[] = $classssr['title'] . "-" . $sectionssss['title'];
        $result[] = $service['fathername'];
        $result[] = $service['sms_mobile'];

        $studentfees = $this->finddisountstudent($service['stud_id'], $academicyear);

        $studentold = $this->Students->find('all')->where(['Students.id' => $service['stud_id'], 'Students.acedmicyear' => $academicyear])->first();

        $oldenrool = $service['oldenroll'];
        $rolepresents = $service['board_id'];
        if ($oldenrool) {
          $studsentold = $this->Students->find('all')->where(['Students.enroll' => $oldenrool])->first();
          $ols = $studsentold['id'];
          $student_datas3s = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.quarter LIKE' => '%Admission Fee%'])->toarray();

          $student_datas32s = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.quarter LIKE' => '%Caution Money%'])->toarray();

          if (isset($student_datas3s)) {

            $studentfees = array_merge($studentfees, $student_datas3s);
          }

          if (isset($student_datas32s)) {

            $studentfees = array_merge($studentfees, $student_datas32s);
          }

          if ($oldenrool == 1991) {
            $student_datas35s = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.quarter LIKE' => '%Quater1%'])->toarray();

            $studentfees = array_merge($studentfees, $student_datas35s);
          }
        }

        $studentfees2 = $this->finddisountstudent2($service['stud_id']);

        $q1 = 0;
        $q2 = 0;
        $q3 = 0;
        $q4 = 0;
        $resultd = 0;
        $resultd2 = 0;
        $tysd = 0;
        $quas = array();

        foreach ($studentfees as $k => $value) {
          $quas[] = unserialize($value['quarter']);
        }

        $quaf = array();

        foreach ($quas as $h => $vale) {

          $quaf = array_merge($quaf, $vale);
        }
        $rt = array();
        foreach ($quaf as $j => $t) {

          $qua[] = $j;
        }
        $quas2 = array();

        $qua2 = array();
        foreach ($studentfees2 as $k2 => $value2) {
          $quas2[] = unserialize($value2['quarter']);
        }

        $quaf2 = array();

        foreach ($quas2 as $h2 => $vale2) {

          $quaf2 = array_merge($quaf2, $vale2);
        }
        $rt2 = array();
        foreach ($quaf2 as $j2 => $t2) {

          $qua2[] = $j2;
        }

        foreach ($quater as $h => $ty) {

          if (!empty($quaf)) {
            $dff = 0;
            foreach ($quaf as $t => $h) {
              if ($t == $ty) {

                //   echo $h;

                if ($ty == "Admission Fee" && $service['enroll'] <= '6454' && $service['board_id'] == '1') {
                  $result[] = "OLD";
                } else if ($ty == "Development Fee" && $service['enroll'] <= '6454' && $service['board_id'] == '1') {
                  $result[] = "OLD";
                } else if ($ty == "Caution Money" && $service['enroll'] <= '6454' && $service['board_id'] == '1') {
                  $result[] = "OLD";
                } else if ($ty == "Admission Fee" && $service['enroll'] <= '5995' && $service['board_id'] == '1') {
                  $result[] = "OLD";
                } else if ($ty == "Development Fee" && $service['enroll'] <= '5995' && $service['board_id'] == '1') {
                  $result[] = "OLD";
                } else if ($ty == "Caution Money" && $service['enroll'] <= '5995' && $service['board_id'] == '1') {
                  $result[] = "OLD";
                } else {
                  $result[] = "-";
                }
                $dff++;
              } else {
              }
            }
            if ($dff == '0') {

              if ($ty == "Quater1") {

                $ty = "Tution Fee";
              } else if ($ty == "Quater2") {
                $ty = "Tution Fee";
              } else if ($ty == "Quater3") {

                $ty = "Tution Fee";
              } else if ($ty == "Quater4") {

                $ty = "Tution Fee";
              } else if ($ty == "Admission Fee") {

                $ty = "Admission Fee";
              } else if ($ty == "Development Fee") {

                $ty = "Development Fee";
              } else if ($ty == "Caution Money") {

                $ty = "Caution Money";
              } else if ($ty == "Miscellaneous Fee") {

                $ty = "Miscellaneous Fee";
              }

              $feeshead = $this->findfeeheadsid($ty);
              $err = $this->findfeeheadsamount($service['class_id'], $academicyear, $feeshead['id']);

              if ($ty == "Quater1") {

                $result[] = $err[0]['qu1_fees'];
                $q1 += $err[0]['qu1_fees'];
                $fedd += $err[0]['qu1_fees'];
              } else if ($ty == "Quater2") {

                $result[] = $err[0]['qu2_fees'];
                $q2 += $err[0]['qu2_fees'];
                $fedd += $err[0]['qu2_fees'];
              } else if ($ty == "Quater3") {

                $result[] = $err[0]['qu3_fees'];
                $q3 += $err[0]['qu3_fees'];
                $fedd += $err[0]['qu3_fees'];
              } else if ($ty == "Quater4") {

                $result[] = $err[0]['qu4_fees'];
                $q4 += $err[0]['qu4_fees'];
                $fedd += $err[0]['qu4_fees'];
              } else if (($ty == "Admission Fee") && ($service['enroll'] > '6454') && $service['board_id'] == '1') {
                if (!in_array("Admission Fee", $qua2)) {
                  $result[] = $err[0]['qu1_fees'];

                  $fedd += $err[0]['qu1_fees'];
                } else {

                  $result[] = '-';
                }
              } else if ($ty == "Development Fee" && $service['enroll'] > '6454' && $service['board_id'] == '1') {
                if (!in_array("Development Fee", $qua2)) {
                  $result[] = $err[0]['qu1_fees'];

                  $fedd += $err[0]['qu1_fees'];
                } else {
                  $result[] = '-';
                }
              } else if ($ty == "Caution Money" && $service['enroll'] > '6454' && $service['board_id'] == '1') {
                if (!in_array("Caution Money", $qua2)) {
                  $result[] = $err[0]['qu1_fees'];

                  $fedd += $err[0]['qu1_fees'];
                } else {

                  $result[] = '-';
                }
              } else if ($ty == "Admission Fee" && $service['enroll'] > '5995') {

                $result[] = $err[0]['qu1_fees'];

                $fedd += $err[0]['qu1_fees'];
              } else if ($ty == "Development Fee" && $service['enroll'] > '5995') {

                $result[] = $err[0]['qu1_fees'];

                $fedd += $err[0]['qu1_fees'];
              } else if ($ty == "Caution Money" && $service['enroll'] > '5995') {

                $result[] = $err[0]['qu1_fees'];

                $fedd += $err[0]['qu1_fees'];
              } else if ($ty == "Miscellaneous Fee") {

                $result[] = $err[0]['qu1_fees'];

                $fedd += $err[0]['qu1_fees'];
              } else {

                if ($ty == "Admission Fee" && $service['enroll'] <= '6454' && $service['board_id'] == '1') {
                  $result[] = "OLD";
                } else if ($ty == "Development Fee" && $service['enroll'] <= '6454' && $service['board_id'] == '1') {
                  $result[] = "OLD";
                } else if ($ty == "Caution Money" && $service['enroll'] <= '6454' && $service['board_id'] == '1') {
                  $result[] = "OLD";
                } else if ($ty == "Admission Fee" && $service['enroll'] <= '5995' && $service['board_id'] == '1') {
                  $result[] = "OLD";
                } else if ($ty == "Development Fee" && $service['enroll'] <= '5995' && $service['board_id'] == '1') {
                  $result[] = "OLD";
                } else if ($ty == "Caution Money" && $service['enroll'] <= '5995' && $service['board_id'] == '1') {
                  $result[] = "OLD";
                } else if ($ty == "Miscellaneous Fee") {
                  $result[] = $err[0]['qu1_fees'];

                  $fedd += $err[0]['qu1_fees'];
                } else {
                  $result[] = $err[0]['qu1_fees'];
                  $q1 += $err[0]['qu1_fees'];
                  $fedd += $err[0]['qu1_fees'];

                  $resultss[] = $err[0]['qu1_fees'];
                  $tysd++;
                }
              }
            }
          } else {
            if ($ty == "Quater1") {

              $tys = "Tution Fee";
            } else if ($ty == "Quater2") {
              $tys = "Tution Fee";
            } else if ($ty == "Quater3") {

              $tys = "Tution Fee";
            } else if ($ty == "Quater4") {

              $tys = "Tution Fee";
            } else if ($ty == "Admission Fee") {

              $tys = "Admission Fee";
            } else if ($ty == "Development Fee") {

              $tys = "Development Fee";
            } else if ($ty == "Caution Money") {

              $tys = "Caution Money";
            } else if ($ty == "Miscellaneous Fee") {

              $tys = "Miscellaneous Fee";
            }

            $feeshead = $this->findfeeheadsid($tys);
            $err = $this->findfeeheadsamount($service['class_id'], $academicyear, $feeshead['id']);

            if ($ty == "Quater1") {

              $result[] = $err[0]['qu1_fees'];
              $q1 += $err[0]['qu1_fees'];
              $fedd += $err[0]['qu1_fees'];
            } else if ($ty == "Quater2") {

              $result[] = $err[0]['qu2_fees'];
              $q2 += $err[0]['qu2_fees'];
              $fedd += $err[0]['qu2_fees'];
            } else if ($ty == "Quater3") {

              $result[] = $err[0]['qu3_fees'];
              $q3 += $err[0]['qu3_fees'];
              $fedd += $err[0]['qu3_fees'];
            } else if ($ty == "Quater4") {

              $result[] = $err[0]['qu4_fees'];
              $q4 += $err[0]['qu4_fees'];
              $fedd += $err[0]['qu4_fees'];
            } else if (($ty == "Admission Fee") && ($service['enroll'] > '6454') && $service['board_id'] == '1') {
              if (!in_array("Admission Fee", $qua2)) {
                $result[] = $err[0]['qu1_fees'];

                $fedd += $err[0]['qu1_fees'];
              } else {

                $result[] = '-';
              }
            } else if ($ty == "Development Fee" && $service['enroll'] > '6454' && $service['board_id'] == '1') {
              if (!in_array("Development Fee", $qua2)) {
                $result[] = $err[0]['qu1_fees'];

                $fedd += $err[0]['qu1_fees'];
              } else {
                $result[] = '-';
              }
            } else if ($ty == "Caution Money" && $service['enroll'] > '6454' && $service['board_id'] == '1') {
              if (!in_array("Caution Money", $qua2)) {
                $result[] = $err[0]['qu1_fees'];

                $fedd += $err[0]['qu1_fees'];
              } else {

                $result[] = '-';
              }
            } else if ($ty == "Admission Fee" && $service['enroll'] > '5995') {

              $result[] = $err[0]['qu1_fees'];

              $fedd += $err[0]['qu1_fees'];
            } else if ($ty == "Development Fee" && $service['enroll'] > '5995') {

              $result[] = $err[0]['qu1_fees'];

              $fedd += $err[0]['qu1_fees'];
            } else if ($ty == "Caution Money" && $service['enroll'] > '5995') {

              $result[] = $err[0]['qu1_fees'];

              $fedd += $err[0]['qu1_fees'];
            } else if ($ty == "Miscellaneous Fee") {

              $result[] = $err[0]['qu1_fees'];

              $fedd += $err[0]['qu1_fees'];
            } else {

              if ($ty == "Admission Fee" && $service['enroll'] <= '6454' && $service['board_id'] == '1') {
                $result[] = "OLD";
              } else if ($ty == "Development Fee" && $service['enroll'] <= '6454' && $service['board_id'] == '1') {
                $result[] = "OLD";
              } else if ($ty == "Caution Money" && $service['enroll'] <= '6454' && $service['board_id'] == '1') {
                $result[] = "OLD";
              } else if ($ty == "Admission Fee" && $service['enroll'] <= '5995' && $service['board_id'] == '1') {
                $result[] = "OLD";
              } else if ($ty == "Development Fee" && $service['enroll'] <= '5995' && $service['board_id'] == '1') {
                $result[] = "OLD";
              } else if ($ty == "Caution Money" && $service['enroll'] <= '5995' && $service['board_id'] == '1') {
                $result[] = "OLD";
              } else if ($ty == "Miscellaneous Fee") {
                $result[] = $err[0]['qu1_fees'];

                $fedd += $err[0]['qu1_fees'];
              } else {

                $result[] = $err[0]['qu1_fees'];
                $resultss[] = $err[0]['qu1_fees'];
                $q1 += $err[0]['qu1_fees'];
                $fedd += $err[0]['qu1_fees'];
                $tysd++;
              }
            }
          }
        }

        $findpending = $this->findpendingssinglefee($service['stud_id'], $academicyear);

        if ($findpending[0]['sum']) {
          $result[] = $findpending[0]['sum'];
          $fedd += $findpending[0]['sum'];
        } else {
          $result[] = "-";
        }

        if ($service['discountcategory'] != '') {

          $ddf = 0;
          $ddf2 = 0;
          $classes_data = $this->DiscountCategory->find('all')->where(['name' => $service['discountcategory']])->first();
          $whid = unserialize($classes_data['fh_id']);
          $swhid = unserialize($classes_data['discount']); // pr($whid);
          foreach ($whid as $h => $dd) {

            if ($h == "2" && $dd != '0') {
              $ddf = $dd . "%";
            }
          }
          if ($ddf == 0) {
            // pr($whid);
            foreach ($swhid as $hs => $dds) {

              if ($hs == "2" && $dds != '0') {
                $ddf2 = $dds;
              }
            }
          }

          if ($q1 != 0) {

            if ($ddf) {
              $tak = $ddf * $q1 / 100;

              $result[] = "(-)" . floor($tak) . "<br><strong
                 style='color: green;font-size: 12px;'>" . $service['discountcategory'] . "</strong>";

              $fedd -= floor($tak);
            } else {

              if ($tysd != 0) {
                $ddf2 = $ddf2 * $tysd;
              }
              $result[] = "(-)" . floor($ddf2) . "<br><strong
                 style='color: green;font-size: 12px;'>" . $service['discountcategory'] . "</strong>";
              $fedd -= floor($ddf2);
            }
          } else {
            $result[] = '-';
          }
        } else {
          $result[] = '-';
        }

        $findamountmonth = $this->findamountmonth($service['class_id'], $academicyear);
        $findamount3month = $this->findamount3month($service['class_id'], $academicyear);
        $findamount2month = $this->findamount2month($service['class_id'], $academicyear);
        $findamount1month = $this->findamount1month($service['class_id'], $academicyear);
        $findsum = $findamountmonth['qu4_fees'] + $findamount3month['qu3_fees'] + $findamount2month['qu2_fees'] + $findamount1month['qu1_fees'];

        $perticularamounts = $this->findperticularamount($service['stud_id'], $academicyear);
        $paidfeestotal = 0;

        $discount = 0;
        foreach ($perticularamounts as $values) {

          $paidfeestotal += $values['fee'];
        }

        foreach ($perticularamounts as $values) {

          $discount += $values['discount'];
        }

        if ($findsum > $paidfeestotal) {

          $dueamt = $findsum - $paidfeestotal;
          $total_dues_amount += $dueamt;

          if ($discount > 0) {

            // echo $dueamt=$dueamt-$discount;

            if ($fedd != '0') {
              $result[] = "<strong style='color:red'>" . $fedd . "</strong>";
              $total_due_amount += $fedd;
              $ert = 0;
            } else {
              $ert = 1;
              $result[] = "<strong style='color:red'>" . $fedd . "</strong>";
              $total_due_amount += $fedd;
            }
          } else {

            //echo $dueamt;
            if ($fedd != '0') {
              $result[] = "<strong style='color:red'>" . $fedd . "</strong>";
              $total_due_amount += $fedd;
              $ert = 0;
            } else {
              $ert = 1;
              $result[] = "<strong style='color:red'>" . $fedd . "</strong>";
              $total_due_amount += $fedd;
            }
          }
        } else {
          if ($fedd != '0') {
            $result[] = "<strong style='color:red'>" . $fedd . "</strong>";
            $total_due_amount += $fedd;
            $ert = 0;
          } else {

            $result[] = "<strong style='color:red'>" . $fedd . "</strong>";
            $total_due_amount += $fedd;

            $ert = 1;
          }
        }

        if ($mode == '1') {
          $ght = 0;
          if ($q1 != '0') {
            $ght++;
          } else if ($q2 != '0') {
            $ght++;
          } else if ($q3 != '0') {
            $ght++;
          } else if ($q4 != '0') {
            $ght++;
          }
        } else {

          $ght = 1;
        }

        if ($ert != '1') {

          if ($ght > '0') {
            $resultsss[] = $result;
            $counter++;
          }
        }
      }
    }

    if ($total_due_amount) {
      return "<span style='color:red;'>" . $total_due_amount . "*</span>";
    } else {

      return "--";
    }
  }

  public function finddisountstudent2($stid)
  {
    // pr ($rout); die;
    // Use the HTML helper to output
    // Formatted data:
    $articles = TableRegistry::get('Studentfees');

    // Start a new query.
    return $articles->find('all')->where(['Studentfees.student_id' => $stid, 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
  }

  public function findperticularamount($id, $a_year)
  {

    return $this->Studentfees->find('all')->select(['id', 'fee', 'discount', 'deposite_amt', 'lfine'])->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $a_year, 'Studentfees.status' => 'Y'])->toArray();
  }

  public function findamountmonth($id, $a_year)
  {
    // pr ($rout); die;
    // Use the HTML helper to output
    // Formatted data:
    $articles = TableRegistry::get('Classfee');
    $m = date('Y-m-d');
    // Start a new query.

    return $articles->find('all')->contain(['Classes'])->select(['qu4_fees' => $articles->find()->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'DATE(Classfee.qu4_date) <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
  }

  public function findamount3month($id, $a_year)
  {
    // pr ($rout); die;
    // Use the HTML helper to output
    // Formatted data:
    $articles = TableRegistry::get('Classfee');
    $m = date('Y-m-d');
    // Start a new query.

    return $articles->find('all')->contain(['Classes'])->select(['qu3_fees' => $articles->find()->func()->sum('Classfee.qu3_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'DATE(Classfee.qu3_date) <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
  }

  public function findamount2month($id, $a_year)
  {
    // pr ($rout); die;
    // Use the HTML helper to output
    // Formatted data:
    $articles = TableRegistry::get('Classfee');
    $m = date('Y-m-d');
    // Start a new query.

    return $articles->find('all')->contain(['Classes'])->select(['qu2_fees' => $articles->find()->func()->sum('Classfee.qu2_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'DATE(Classfee.qu2_date) <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
  }

  public function findpaidamounts($a_year, $datefrom, $dateto)
  {
    // pr ($rout); die;
    // Use the HTML helper to output
    // Formatted data:
    $articles = TableRegistry::get('Studentfees');

    // Start a new query.
    return $articles->find('all')->contain(['Students'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y', 'Students.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
  }


  public function findamount1month($id, $a_year)
  {
    // pr ($rout); die;
    // Use the HTML helper to output
    // Formatted data:
    $articles = TableRegistry::get('Classfee');
    $m = date('Y-m-d');
    // Start a new query.

    return $articles->find('all')->contain(['Classes'])->select(['qu1_fees' => $articles->find()->func()->sum('Classfee.qu1_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'DATE(Classfee.qu1_date) <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
  }

  public function studentshistoryagain($stud_id)
  {
    // pr ($rout); die;
    // Use the HTML helper to output
    // Formatted data:
    $articles = TableRegistry::get('Studentshistory');

    // Start a new query.

    return $articles->find('all')->contain(['Classes'])->select(['acedmicyear', 'stud_id'])->where(['Studentshistory.stud_id' => $stud_id])->order(['Studentshistory.id' => 'DESC'])->toarray();
  }

  public function finddisountstudent($stid, $a_year)
  {
    // pr ($rout); die;
    // Use the HTML helper to output
    // Formatted data:
    $articles = TableRegistry::get('Studentfees');

    // Start a new query.
    return $articles->find('all')->where(['Studentfees.student_id' => $stid, 'Studentfees.acedmicyear' => $a_year, 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
  }

  public function index($id = null, $academic_year = null)
  {
    $this->viewBuilder()->layout('admin');
    $db = $this->Users->find()->where(['role_id' => 1])->first();
    $this->set(compact('db'));
    $findpendings = $this->studentshistoryagain($id);

    $emotys = array();
    if (!empty($findpendings)) {
      foreach ($findpendings as $kkt => $rtt) {
        //$fetchdetail = $this->defaultersearchbyidhistory($rtt['stud_id'],$rtt['acedmicyear']);
        $fetchdetail = 1;
        if ($fetchdetail == "--") {
          $fetchdetail = '';
        }
        $emotys[] = $fetchdetail . "/" . $rtt['stud_id'] . "/" . $rtt['acedmicyear'];
      }
    }

    $this->set('emotys', $emotys);


    $feesheadstotal = $this->Feesheads->find('all', [
      'keyField' => 'id',
      'valueField' => 'name',
    ])->where(['status' => 'Y', 'type IN' => ['3', '0'], 'sort !=' => '0'])->order(['name' => 'ASC'])->toArray();
    // pr($feesheadstotal);die;
    $this->set('feesheadstotal', $feesheadstotal);

    //$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

    //$academic_year=$users['academic_year'];

    $discountCategorylist = $this->DiscountCategory->find('all', [
      'keyField' => 'id',
      'valueField' => 'name',
    ])->where(['status' => 'Y', 'type !=' => '1'])->order(['id' => 'ASC'])->toArray();
    // pr($discountCategorylist);die;
    $this->set('discountCategorylist', $discountCategorylist);
    //show data in listing
    if (isset($_GET['id'])) {

      $this->set('selectid', $_GET['id']);
    }

    if ($this->request->session()->read('paydatef')) {

      $paydatef = $this->request->session()->read('paydatef');
      $ids2s = $this->request->session()->read('reciptnof');
      $this->set('paydatef', $paydatef);
      if ($ids2s != '0') {
        $reciptnof = $ids2s + 1;

        $this->set('reciptnof', $reciptnof);
      }
    }

    $this->set(compact('id'));
    $this->set(compact('academic_year'));

    $stdnt = $this->Students->get($id);
    $discount_fees = $stdnt->dis_fees;
    $dis_hostel = $stdnt->dis_hostel;
    $dis_transport = $stdnt->dis_transport;
    $classid = $stdnt->class_id;
    $academic_year = $academic_year;

    $alldata = $this->Classfee->find('all')->contain(['Feesheads'])->where(['class_id' => $classid, 'academic_year' => $academic_year])->toarray();
    $personalduefees = $this->Previousduefees->find('all')->where(['Previousduefees.student_id' => $id])->first();
    $Sitesettings = $this->Sitesettings->find('all')->where(['Sitesettings.print' => '1'])->first();
    $this->set('Sitesettings', $Sitesettings);
    $this->set('personalduefees', $personalduefees);
    $this->set('alldata', $alldata);
    $this->set('id', $id);
    $this->set('academic_year', $academic_year);

    if (!empty($discount_fees)) {
      $this->set('discount_fees', $discount_fees);
    } else {
      $discount_fees = '0';
      $this->set('discount_fees', $discount_fees);
    }
    if (!empty($dis_hostel)) {
      $this->set('dis_hostel', $dis_hostel);
    } else {
      $dis_hostel = '0';
      $this->set('dis_hostel', $dis_hostel);
    }
    if (!empty($dis_transport)) {
      $this->set('dis_transport', $dis_transport);
    } else {
      $dis_transport = '0';
      $this->set('dis_transport', $dis_transport);
    }

    $stdntddf = $this->Students->find('all')->where(['Students.id' => $id])->first();
    $fathernamefffg = $stdntddf['fathername'];
    $mothernamefffg = $stdntddf['mothername'];
    $student_dataftf = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.fathername' => $fathernamefffg, 'Students.mothername' => $mothernamefffg, 'Students.id NOT IN' => $id, 'Students.status' => 'Y'])->toarray();
    $this->set('student_dataftf', $student_dataftf);

    $feeheads = $this->Feesheads->find('all')->where(['Feesheads.status' => 'Y'])->toarray();
    $this->set('feeheads', $feeheads);

    $feeheadstype = $this->Feesheads->find('all')->where(['Feesheads.type' => '2'])->toarray();
    $this->set('feeheadstype', $feeheadstype);

    $classfeesss = $this->Classfee->find('all')->contain(['Classes', 'Feesheads'])->group('Classfee.academic_year')->group('Classfee.class_id')->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => $this->Classfee->find()->func()->sum('Classfee.qu1_fees'), 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.qu1_date', 'Feesheads.name', 'Classfee.qu2_date', 'Classfee.qu3_date', 'Classfee.qu4_date', 'Classfee.status', 'Classfee.class_id'])->toarray();
    $this->set('classfeesss', $classfeesss);

    $classes = $this->Classections->find('list', [
      'keyField' => 'Classes.id',
      'valueField' => 'Classes.title',
    ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
    $this->set('classes', $classes);

    $sectionslist = $this->Sections->find('list', [
      'keyField' => 'id',
      'valueField' => 'title',
    ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
    $this->set('sectionslist', $sectionslist);

    $this->set('id', $id);

    $banks = $this->Banks->find('list', [
      'keyField' => 'id',
      'valueField' => 'name'
    ])->where(['Banks.status' => 'Y'])->order(['Banks.id' => 'asc'])->toArray();
    $this->set('banks', $banks);

    $rolepresent = $this->request->session()->read('Auth.User.role_id');

    if ($rolepresent == '1' || $rolepresent == '6' || $rolepresent == '105') {
      $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.status' => 'Y'])->first();
      $this->set('students', $student_data);
    } else if ($rolepresent == '5') {
      $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

      $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
      if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
        $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
      }

      $student_datasmaxssss = $this->Studentfees->find('all')->contain(['Students'])->select(['cheque_no', 'ref_no', 'bank'])->where(['Students.status' => 'Y'])->order(['Studentfees.id DESC'])->first();

      $this->set('student_datasmaxssss', $student_datasmaxssss['cheque_no']);
      $this->set('student_datasmref_no', $student_datasmaxssss['ref_no']);
      $this->set('student_databank', $student_datasmaxssss['bank']);
      $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' => '1'])->first();

      $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' => '1', 'Enquires.class_id <=' => '22'])->contain(['Enquires'])->first();

      $c = $student_datasmaxss['amount'];

      $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id])->first();
      $this->set('students', $student_data);
    }

    $student_datasm = $c + 1;
    $this->set('student_datasm', $student_datasm);
    $acedmicyear = $academic_year;
    $this->set('academic_year', $academic_year);
    $acedmiclassid = $student_data['class_id'];
    $this->set('academic_class', $acedmiclassid);
    $is_transport = $student_data['is_transport'];
    $is_hostel = $student_data['is_hostel'];
    $this->set('is_transport', $is_transport);
    $this->set('is_hostel', $is_hostel);
    $transportloc_id = $student_data['transportloc_id'];
    $this->set('transportloc_id', $transportloc_id);
    $hostal_id = $student_data['h_id'];
    $this->set('hostal_id', $hostal_id);
    $this->set('id', $id);
    $transportfeess = $this->Transportfees->find('all')->where(['Transportfees.loc_id' => $transportloc_id, 'Transportfees.academic_year' => $acedmicyear])->toarray();
    $this->set('transportfeess', $transportfeess);
    $hostalfeess = $this->Hostels->find('all')->where([
      'Hostels.id' =>
      $hostal_id,
      'Hostels.academicyear' => $acedmicyear
    ])->toarray();
    $this->set('hostalfeess', $hostalfeess);
    $studentold = $this->Students->find('all')->where(['Students.id' => $id, 'Students.acedmicyear' => $acedmicyear])->first();
    $oldenrool = $studentold['oldenroll'];
    $studentolds = $this->Students->find('all')->where(['Students.enroll' => $oldenrool, 'Students.acedmicyear' => $acedmicyear])->first();
    $oldenrool = $studentold['oldenroll'];
    $oldenrools = $studentolds['id'];
    if ($oldenrool && $oldenrools) {
      if ($rolepresent == '5') {
        $studsentold = $this->Students->find('all')->where(['Students.enroll' => $oldenrool])->first();
      }
      $ols = $studsentold['id'];
      $student_datas3s = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.acedmicyear' => $acedmicyear])->toarray();

      $student_datas31s = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.acedmicyear !=' => $acedmicyear])->toarray();

      foreach ($student_datas31s as $kss => $valuess) {
        $quaswr[] = unserialize($valuess['quarter']);
      }

      $quafljr = array();

      foreach ($quaswr as $hljr => $valeljr) {

        $quafljr = array_merge($quafljr, $valeljr);
      }
      $rtljr = array();
      foreach ($quafljr as $jljr => $tljr) {
        if ($jljr == "Admission Fee" || $jljr == "Development Fee" || $jljr == "Caution Money") {
          $quarsgh[] = $jljr;
        }
      }

      $this->set('quarsgh', $quarsgh);
      $this->set('studentfees2s', $student_datas3s);

      $studentsacedemics = $this->Studentshistory->find('all')->where(['Studentshistory.stud_id' => $id, 'Studentshistory.status' => 'Y'])->group(['Studentshistory.acedmicyear'])->toarray();
      foreach ($studentsacedemics as $ktt => $itt) {
        $aced[] = $itt['acedmicyear'];
      }

      if (!empty($aced)) {
        $student_datas1 = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear IN' => $aced, 'Studentfees.status' => 'Y'])->toarray();

        $this->set('studentfees1', $student_datas1);
      }
    }

    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();
    $this->set('studentfees', $student_datas);
    $student_datas2 = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->toarray();
    $this->set('studentfees2', $student_datas2);

    // $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y', 'Studentfees.deposite_amt !=' => '0', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
    $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
    if ($id == 4692) {
      $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
    }
    $this->set('studentfeesk', $student_datask);

    $student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $id, 'Studentfeepending.status' => 'N'])->toarray();
    $this->set('student_feepending', $student_feepending);

    $student_datash = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->group(['Studentfees.created'])->toarray();
    $this->set('stduefee', $student_datash);

    $student_trans = $this->StudentTransfees->find('all')->where(['StudentTransfees.student_id' => $id, 'StudentTransfees.acedmicyear' => $acedmicyear])->toarray();
    $this->set('studenttransfee', $student_trans);
    $student_hostal = $this->StudentHostalfees->find('all')->where(['StudentHostalfees.student_id' => $id, 'StudentHostalfees.student_id' => $id])->toarray();
    $this->set('studenthostalfee', $student_hostal);
    $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->where(['Classfee.fee_h_id IN' => ['2', '9'], 'Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid])->order(['Classfee.id' => 'ASC'])->select([
      'qu1_fees' => 'Classfee.qu1_fees',
      'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'),
      'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'),
      'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),
      'Classes.title',
      'Classfee.academic_year',
      'Classfee.id',
      'Classfee.status',
      'Classfee.class_id',
    ])->toarray();

    $this->set('classfee', $classfee);
    $fid = ['7', '3', '4', '9', '71'];
    $sfee = $this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid, 'Classfee.fee_h_id IN' => $fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();

    $this->set('preclassfee', $sfee);
  }

  public function history($id = null, $academic_year = null)
  {

    $this->viewBuilder()->layout('admin');
    $db = $this->Users->find()->where(['role_id' => 1])->first();
    $this->set(compact('db'));
    $feesheadstotal = $this->Feesheads->find('all', [
      'keyField' => 'id',
      'valueField' => 'name',
    ])->where(['status' => 'Y', 'type IN' => ['3', '0'], 'sort !=' => '0'])->order(['name' => 'ASC'])->toArray();
    $this->set('feesheadstotal', $feesheadstotal);

    $discountCategorylist = $this->DiscountCategory->find('all', [
      'keyField' => 'id',
      'valueField' => 'name',
    ])->where(['status' => 'Y', 'type !=' => '1'])->order(['id' => 'ASC'])->toArray();
    $this->set('discountCategorylist', $discountCategorylist);

    if ($_GET['id']) {

      $this->set('selectid', $_GET['id']);
    }

    if ($this->request->session()->read('paydatef')) {
      $paydatef = $this->request->session()->read('paydatef');

      $ids2s = $this->request->session()->read('reciptnof');
      $this->set('paydatef', $paydatef);
      if ($ids2s != '0') {
        $reciptnof = $ids2s + 1;

        $this->set('reciptnof', $reciptnof);
      }
    }

    $this->set(compact('id'));
    $this->set(compact('academic_year'));

    $stdnt = $this->Studentshistory->find('all')->contain(['Classes', 'Sections'])->where(['Studentshistory.stud_id' => $id, 'Studentshistory.acedmicyear' => $academic_year])->first();
    $stdntcurrent = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id])->first();
    $this->set('acedmicyears', $stdntcurrent['acedmicyear']);

    $discount_fees = $stdnt->dis_fees;
    $dis_hostel = $stdnt->dis_hostel;
    $dis_transport = $stdnt->dis_transport;
    $classid = $stdnt->class_id;
    $academic_year = $academic_year;

    $alldata = $this->Classfee->find('all')->contain(['Feesheads'])->where(['class_id' => $classid, 'academic_year' => $academic_year])->toarray();
    $personalduefees = $this->Previousduefees->find('all')->where(['Previousduefees.student_id' => $id])->first();
    $Sitesettings = $this->Sitesettings->find('all')->where(['Sitesettings.print' => '1'])->first();
    $this->set('Sitesettings', $Sitesettings);
    $this->set('personalduefees', $personalduefees);
    $this->set('alldata', $alldata);
    $this->set('id', $id);

    $this->set('academic_year', $academic_year);

    if (!empty($discount_fees)) {
      $this->set('discount_fees', $discount_fees);
    } else {
      $discount_fees = '0';
      $this->set('discount_fees', $discount_fees);
    }
    if (!empty($dis_hostel)) {
      $this->set('dis_hostel', $dis_hostel);
    } else {
      $dis_hostel = '0';
      $this->set('dis_hostel', $dis_hostel);
    }
    if (!empty($dis_transport)) {
      $this->set('dis_transport', $dis_transport);
    } else {
      $dis_transport = '0';
      $this->set('dis_transport', $dis_transport);
    }

    $feeheads = $this->Feesheads->find('all')->where(['Feesheads.status' => 'Y'])->toarray();
    $this->set('feeheads', $feeheads);

    $feeheadstype = $this->Feesheads->find('all')->where(['Feesheads.type' => '2'])->toarray();
    $this->set('feeheadstype', $feeheadstype);
    $classfeesss = $this->Classfee->find('all')->contain(['Classes', 'Feesheads'])->group('Classfee.academic_year')->group('Classfee.class_id')->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => $this->Classfee->find()->func()->sum('Classfee.qu1_fees'), 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.qu1_date', 'Feesheads.name', 'Classfee.qu2_date', 'Classfee.qu3_date', 'Classfee.qu4_date', 'Classfee.status', 'Classfee.class_id'])->toarray();
    $this->set('classfeesss', $classfeesss);
    $classes = $this->Classections->find('list', [
      'keyField' => 'Classes.id',
      'valueField' => 'Classes.title',
    ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
    $this->set('classes', $classes);

    $sectionslist = $this->Sections->find('list', [
      'keyField' => 'id',
      'valueField' => 'title',
    ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
    $this->set('sectionslist', $sectionslist);
    $this->set('id', $id);
    $banks = $this->Banks->find('list', [
      'keyField' => 'id',
      'valueField' => 'name'
    ])->where(['Banks.status' => 'Y'])->order(['Banks.id' => 'asc'])->toArray();
    $this->set('banks', $banks);

    $rolepresent = $this->request->session()->read('Auth.User.role_id');
    if ($rolepresent == '1' || $rolepresent == '6') {

      $student_data = $this->Studentshistory->find('all')->contain(['Classes', 'Sections'])->where(['Studentshistory.stud_id' => $id, 'Students.status' => 'Y', 'Studentshistory.acedmicyear' => $academic_year])->order(['Studentshistory.id DESC'])->first();
      $this->set('students', $student_data);
    } else if ($rolepresent == '5') {

      $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
      $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
      if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
        $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
      }

      $student_datasmaxssss = $this->Studentfees->find('all')->contain(['Students'])->select(['cheque_no', 'ref_no', 'bank'])->where(['Students.status' => 'Y'])->order(['Studentfees.id DESC'])->first();

      $this->set('student_datasmaxssss', $student_datasmaxssss['cheque_no']);
      $this->set('student_datasmref_no', $student_datasmaxssss['ref_no']);
      $this->set('student_databank', $student_datasmaxssss['bank']);
      $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' => '1'])->first();

      $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' => '1', 'Enquires.class_id <=' => '22'])->contain(['Enquires'])->first();

      $c = $student_datasmaxss['amount'];

      $student_data = $this->Studentshistory->find('all')->contain(['Classes', 'Sections'])->where(['Studentshistory.stud_id' => $id, 'Studentshistory.status' => 'Y', 'Studentshistory.acedmicyear' => $academic_year])->order(['Studentshistory.id DESC'])->first();
      $this->set('students', $student_data);
    }

    $studentsacedemic = $this->Studentshistory->find('all')->where(['Studentshistory.stud_id' => $id, 'Studentshistory.status' => 'Y'])->group(['Studentshistory.acedmicyear'])->toarray();
    foreach ($studentsacedemic as $ktt => $itt) {
      $aced[] = $itt['acedmicyear'];
    }

    $student_datasm = $c + 1;

    $this->set('student_datasm', $student_datasm);

    $acedmicyear = $academic_year;
    $this->set('academic_year', $academic_year);
    $acedmiclassid = $student_data['class_id'];
    $this->set('academic_class', $acedmiclassid);
    $is_transport = $student_data['is_transport'];
    $is_hostel = $student_data['is_hostel'];

    $this->set('is_transport', $is_transport);
    $this->set('is_hostel', $is_hostel);

    $transportloc_id = $student_data['transportloc_id'];
    $this->set('transportloc_id', $transportloc_id);

    $hostal_id = $student_data['h_id'];
    $this->set('hostal_id', $hostal_id);

    $this->set('id', $id);
    $transportfeess = $this->Transportfees->find('all')->where(['Transportfees.loc_id' => $transportloc_id, 'Transportfees.academic_year' => $acedmicyear])->toarray();
    $this->set('transportfeess', $transportfeess);

    $hostalfeess = $this->Hostels->find('all')->where([
      'Hostels.id' =>
      $hostal_id,
      'Hostels.academicyear' => $acedmicyear
    ])->toarray();
    $this->set('hostalfeess', $hostalfeess);

    $student_datas1 = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear IN' => $aced, 'Studentfees.status' => 'Y'])->toarray();

    $this->set('studentfees1', $student_datas1);

    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();

    $this->set('studentfees', $student_datas);

    $studentold = $this->Students->find('all')->where(['Students.id' => $id, 'Students.status' => 'Y'])->first();
    $oldenrool = $studentold['oldenroll'];
    if ($oldenrool) {

      if ($rolepresent == '5') {
        $boardzs = ['2', '3'];
        $studsentold = $this->Students->find('all')->where(['Students.enroll' => $oldenrool, 'Students.board_id IN' => $boardzs])->first();
      } else if ($rolepresent == '8') {

        $studsentold = $this->Students->find('all')->where(['Students.enroll' => $oldenrool, 'Students.board_id' => '1'])->first();
      }
      $ols = $studsentold['id'];

      $student_datas3s = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.acedmicyear' => $acedmicyear])->toarray();
      $student_datas31s = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.recipetno' => 0])->toarray();
      if (isset($student_datas31s)) {
        $student_datas3s = array_merge($student_datas31s, $student_datas3s);
      }

      $this->set('student_datas3s', $student_datas3s);
    }

    $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
    $this->set('studentfeesk', $student_datask);

    $student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $id, 'Studentfeepending.status' => 'N'])->toarray();
    $this->set('student_feepending', $student_feepending);

    $student_datash = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->group(['Studentfees.created'])->toarray();
    $this->set('stduefee', $student_datash);

    $student_trans = $this->StudentTransfees->find('all')->where(['StudentTransfees.student_id' => $id, 'StudentTransfees.acedmicyear' => $acedmicyear])->toarray();
    $this->set('studenttransfee', $student_trans);
    $student_hostal = $this->StudentHostalfees->find('all')->where(['StudentHostalfees.student_id' => $id, 'StudentHostalfees.student_id' => $id])->toarray();
    $this->set('studenthostalfee', $student_hostal);
    $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->where(['Classfee.fee_h_id IN' => ['2', '9'], 'Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid])->order(['Classfee.id' => 'ASC'])->select([
      'qu1_fees' => 'Classfee.qu1_fees',
      'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'),
      'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'),
      'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),
      'Classes.title',
      'Classfee.academic_year',
      'Classfee.id',
      'Classfee.status',
      'Classfee.class_id',
    ])->toarray();

    $this->set('classfee', $classfee);
    $fid = ['7', '3', '4', '9'];
    $sfee =
      $this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid, 'Classfee.fee_h_id IN' => $fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
    $this->set('preclassfee', $sfee);
  }

  public function printscaution($idf = null, $acedemic = null)
  {

    $this->viewBuilder()->layout('ajax');
    $this->response->type('pdf');
    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.id' => $idf, 'Studentfees.acedmicyear' => $acedemic])->first();

    $id = $student_datas['student_id'];
    $this->sitesetting('receipt');
    $quater = ["Caution Money"];

    $students = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.acedmicyear' => $acedemic])->first();
    $this->set(compact('students'));
    if (empty($students)) {
      $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where(['DropOutStudent.s_id' => $id, 'DropOutStudent.acedmicyear' => $acedemic, 'DropOutStudent.status' => 'Y'])->first();

      $this->set(compact('students'));
    }
    if ($_GET['gid']) {
      $gid = 1;
    } else {

      $gid = 2;
    }
    $this->set(compact('gid'));

    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedemic, 'Studentfees.id' => $idf])->first();

    $this->set('studentfees', $student_datas);
  }


  // new update also serach from drop out student Rupam 19 Aprl 2025
  public function getstudentname()
  {
    $this->loadModel('Students');
    $this->loadModel('DropOutStudent');
    $this->loadModel('Classes');
    $this->loadModel('Sections');

    // Search term and other params
    $stsearch = trim($this->request->data['fetch']);
    $check = $this->request->data['check'];

    // Query for Students
    $studentsQuery = $this->Students->find('all')
      ->contain(['Classes', 'Sections'])
      ->where(function ($exp, $query) use ($stsearch) {
        if (is_numeric($stsearch)) {
          return $exp->eq('Students.enroll', $stsearch);
        } else {
          return $exp->like('LOWER(Students.st_full_name)', '%' . strtolower($stsearch) . '%');
        }
      })
      ->andWhere(['Students.status' => 'Y'])
      ->select([
        'id',
        'st_full_name',
        'enroll',
        'fathername',
        'acedmicyear',
        'class_title' => 'Classes.title',
        'section_title' => 'Sections.title',
        'dropcreated' => $this->Students->query()->newExpr('NULL') // Use NULL explicitly for Students
      ])
      ->order(['Students.id' => 'DESC', 'Students.st_full_name' => 'ASC']);

    // Query for DropOutStudents
    $dropOutStudentsQuery = $this->DropOutStudent->find('all')
      ->contain(['Classes', 'Sections'])
      ->where(function ($exp, $query) use ($stsearch) {
        if (is_numeric($stsearch)) {
          return $exp->eq('DropOutStudent.enroll', $stsearch);
        } else {
          return $exp->like('LOWER(DropOutStudent.fname)', '%' . strtolower($stsearch) . '%');
        }
      })
      ->andWhere(['DropOutStudent.status' => 'Y'])
      ->select([
        'id' => 'DropOutStudent.s_id',
        'st_full_name' => 'DropOutStudent.fname',
        'enroll',
        'fathername',
        'acedmicyear',
        'class_title' => 'Classes.title',
        'section_title' => 'Sections.title',
        'dropcreated' => 'DropOutStudent.dropcreated' // Get the dropcreated field for identifying DropOutStudents
      ])
      ->order(['DropOutStudent.id' => 'DESC', 'DropOutStudent.fname' => 'ASC']);

    // Perform UNION on both queries
    $query = $studentsQuery->union($dropOutStudentsQuery)->order(['st_full_name' => 'ASC', 'enroll' => 'ASC'])->toArray();

    // Check if there are results
    if (empty($query)) {
      echo '<li><a href="javascript:void(0)" class="list-group-item">We couldn’t find any student</a></li>';
    } else {
      // Process and display results
      foreach ($query as $value) {
        $fullName = ucwords(strtolower($value['st_full_name']));
        $classTitle = $value['class_title'] ?? '';
        $sectionTitle = $value['section_title'] ?? '';
        $fatherName = ucwords(strtolower($value['fathername']));
        $enroll = $value['enroll'];

        // Check if the student is from DropOutStudent query and set background color accordingly
        $bgColor = !empty($value['dropcreated']) ? 'background-color: #ff9393;' : 'background-color: #ffffff;';

        // Output list item with dynamic background color
        echo "<li style='padding: 5px 8px; border: 1px solid #747373; $bgColor' onclick=\"cllbckretail$check('$fullName', '{$value['id']}', '{$value['acedmicyear']}', '$classTitle', '$sectionTitle', '$fatherName', '$enroll')\">
              <a href='javascript:void(0)' style='color: black;'>$fullName ($classTitle-$sectionTitle) ($fatherName) - ($enroll)</a>
            </li>";
      }
    }


    die;
  }

  public function getstudentnameold()
  {
    $this->loadModel('Students');
    $this->loadModel('Classes');
    $this->loadModel('Sections');

    $stsearch = trim($this->request->data['fetch']);
    $check = $this->request->data['check'];
    $checks = $this->request->data['id'];


    // Upgrade code 13-12-2023 Rupam 
    $searchst = $this->Students->find('all')
      ->contain(['Classes', 'Sections'])
      ->where([
        'LOWER(Students.st_full_name) LIKE' => '%' . strtolower($stsearch) . '%',
        'Students.status' => 'Y'
      ])
      ->order(['Students.id' => 'DESC', 'Students.st_full_name' => 'ASC'])
      ->toArray();

    if (empty($searchst)) {
      echo '<li><a href="javascript:void(0)" class="list-group-item">We couldn’t find any student</a></li>';
    } else {
      foreach ($searchst as $value) {

        echo '<li style="padding: 5px 8px; border: 1px solid lightgray;" onclick="cllbckretail' . $check . '(' . "'" . ucwords(strtolower($value['st_full_name'])) . "'" . ',' . "'" . $value['id'] . "'" . ',' . "'" . $value['acedmicyear'] . "'" . ',' . "'" . $value['class']['title'] . "'" . ',' . "'" . $value['section']['title'] . " -(" . $value['batch'] . ")" . "'" . ',' . "'" . ucwords(strtolower($value['fathername'])) . "'" . ',' . "'" . $value['enroll'] . "'" . ')"> 

        <a href="javascript:void(0)" style="color: black;">' . ucwords(strtolower($value['st_full_name'])) . " (" . $value['class']['title'] . "-" . $value['section']['title'] . " -(" . $value['batch'] . ")) (" . ucwords(strtolower($value['fathername'])) . " )" . " - (" . $value['enroll'] . ")" . '</a>
        </li>';
      }
    }
    die;
  }


  public function printscautionhistory($idf = null, $acedemic = null)
  {

    $this->viewBuilder()->layout('ajax');
    $this->response->type('pdf');
    $this->sitesetting('receipt');
    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.id' => $idf, 'Studentfees.acedmicyear' => $acedemic])->first();

    $id = $student_datas['student_id'];

    if ($_GET['gid']) {
      $gid = 1;
    } else {

      $gid = 2;
    }
    $this->set(compact('gid'));

    $quater = ["Caution Money"];
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

    $students = $this->Studentshistory->find('all')->contain(['Classes', 'Sections'])->where(['Studentshistory.stud_id' => $id, 'Studentshistory.acedmicyear' => $acedemic, 'Studentshistory.status' => 'Y'])->first();
    $this->set(compact('students'));

    if (empty($students)) {
      $students = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.acedmicyear' => $acedemic])->first();

      $this->set(compact('students'));
    }

    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedemic, 'Studentfees.id' => $idf])->first();

    $this->set('studentfees', $student_datas);
  }

  public function printsadmissionmonthly($idf = null, $acedemic = null)
  {

    $this->viewBuilder()->layout('ajax');
    $this->response->type('pdf');
    $ert = base64_decode($quater);
    $this->sitesetting('receipt');
    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.id' => $idf, 'Studentfees.acedmicyear' => $acedemic])->first();

    $id = $student_datas['student_id'];

    if ($_GET['gid']) {
      $gid = 1;
    } else {

      $gid = 2;
    }

    $this->set(compact('gid'));
    $quater = [$ert];

    $students = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.acedmicyear' => $acedemic])->first();
    $this->set(compact('students'));

    if (empty($students)) {
      $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where(['DropOutStudent.s_id' => $id, 'DropOutStudent.acedmicyear' => $acedemic, 'DropOutStudent.status' => 'Y'])->first();

      $this->set(compact('students'));
    }

    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedemic, 'Studentfees.id' => $idf])->first();

    $this->set('studentfees', $student_datas);
  }
  public function printsadmissionhistory($idf = null, $acedemic = null)
  {

    $this->viewBuilder()->layout('ajax');
    $this->response->type('pdf');
    $ert = base64_decode($quater);
    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.id' => $idf, 'Studentfees.acedmicyear' => $acedemic])->first();

    $id = $student_datas['student_id'];

    if ($_GET['gid']) {
      $gid = 1;
    } else {

      $gid = 2;
    }
    $this->set(compact('gid'));
    //~ $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

    //~ $acedemic=$users['academic_year'];
    $quater = [$ert];

    $students = $this->Studentshistory->find('all')->contain(['Classes', 'Sections'])->where(['Studentshistory.stud_id' => $id, 'Studentshistory.acedmicyear' => $acedemic, 'Studentshistory.status' => 'Y'])->first();
    $this->set(compact('students'));

    if (empty($students)) {
      $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where(['DropOutStudent.s_id' => $id, 'DropOutStudent.acedmicyear' => $acedemic, 'DropOutStudent.status' => 'Y'])->first();

      $this->set(compact('students'));
    }

    if (empty($students)) {
      $students = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.acedmicyear' => $acedemic])->first();

      $this->set(compact('students'));
    }

    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedemic, 'Studentfees.id' => $idf])->first();

    $this->set('studentfees', $student_datas);
    $this->sitesetting('receipt');
  }
  public function prints($id = null, $quater = null, $idf = null, $acedemic = null)
  {

    $this->viewBuilder()->layout('ajax');
    $this->response->type('pdf');
    $stdnt = $this->Students->get($id);
    $discount_fees = $stdnt->dis_fees;
    if (!empty($discount_fees)) {
      //$this->set('discount_fees', $discount_fees);
    } else {
      $discount_fees = '0';
      //$this->set('discount_fees',$discount_fees);
    }
    $students = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.acedmicyear' => $acedemic, 'Students.status' => 'Y'])->first()->toarray();
    $this->set(compact('students'));

    $fid = ['1', '2'];
    $feeheads = $this->Feesheads->find('all')->where(['Feesheads.type IN' => $fid])->toarray();
    $this->set('feeheads', $feeheads);

    $quater = $quater;

    $student_datasj = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedemic])->first();

    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedemic, 'Studentfees.created' => $student_datasj['created']])->toarray();

    $this->set('studentfees', $student_datas);
  }

  public function printsquater($id = null, $quater = null, $acedemic = null)
  {

    $this->viewBuilder()->layout('ajax');
    $this->response->type('pdf');
    $stdnt = $this->Students->get($id);
    $discount_fees = $stdnt->dis_fees;
    if (!empty($discount_fees)) {
      //$this->set('discount_fees', $discount_fees);
    } else {
      $discount_fees = '0';
      //$this->set('discount_fees',$discount_fees);
    }
    $students = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.acedmicyear' => $acedemic, 'Students.status' => 'Y'])->first()->toarray();
    $this->set(compact('students'));

    $fid = ['1', '2'];
    $feeheads = $this->Feesheads->find('all')->where(['Feesheads.type IN' => $fid])->toarray();
    $this->set('feeheads', $feeheads);

    if ($quater == "Quater1") {
      $quater = ["Miscellaneous Fee", "Quater1", "Quater2", "Quater3", "Quater4"];
    } else if ($quater == "Quater2") {
      $quater = ["Quater2", "Quater3", "Quater4"];
    } else if ($quater == "Quater3") {
      $quater = ["Quater3", "Quater4"];
    } else if ($quater == "Quater4") {
      $quater = ["Quater4"];
    } else if ($quater == "Miscellaneous Fee") {
      $quater = ["Quater1", "Miscellaneous Fee"];
    } else {
      $quater = $quater;
    }

    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedemic])->toarray();
    //pr($student_datas); die;
    $this->set('studentfees', $student_datas);
  }

  public function dueprints($id = null)
  {

    $this->viewBuilder()->layout('ajax');
    $this->response->type('pdf');
    $stdnt = $this->Previousduefees->find('all')->where(['Previousduefees.student_id' => $id])->contain(['Students', 'Banks'])->first();
    //pr($stdnt); die;
    $this->set('stdnt', $stdnt);
  }

  public function printstransport($id = null, $quater = null, $acedemic = null)
  {

    $this->viewBuilder()->layout('ajax');
    $this->response->type('pdf');
    $stdnt = $this->Students->get($id);
    $discount_fees = $stdnt->dis_fees;
    $transportloc = $stdnt->transportloc_id;
    if (!empty($discount_fees)) {
      //    $this->set('discount_fees', $discount_fees);
    } else {
      $discount_fees = '0';
      //    $this->set('discount_fees',$discount_fees);
    }
    $students = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.acedmicyear' => $acedemic, 'Students.status' => 'Y'])->first()->toarray();
    $this->set(compact('students'));
    $feeheads = $this->Transportfees->find('all')->where([
      'Transportfees.loc_id' => $transportloc,
      'Transportfees.academic_year' =>
      $acedemic
    ])->toarray();
    $this->set('feeheads', $feeheads);

    $student_datas = $this->StudentTransfees->find('all')->where(['StudentTransfees.quarter' => $quater, 'StudentTransfees.student_id' => $id, 'StudentTransfees.acedmicyear' => $acedemic])->first()->toarray();

    $this->set('studentfees', $student_datas);
  }

  public function printsreportcard()
  {

    $this->viewBuilder()->layout('ajax');
    $this->response->type('pdf');
  }

  public function printsreportcardvatika()
  {

    $this->viewBuilder()->layout('ajax');
    $this->response->type('pdf');
  }

  public function printshostal()
  {

    $this->viewBuilder()->layout('ajax');
    $this->response->type('pdf');
    //$stdnt= $this->Students->get($id);
    // $discount_fees=$stdnt->dis_fees;

    // if(!empty($discount_fees))
    // {
    //$this->set('discount_fees', $discount_fees);
    //    }
    //    else
    //{
    //$discount_fees='0';
    //$this->set('discount_fees',$discount_fees);
    //}
    //$students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.id' =>$id,'Students.acedmicyear' =>$acedemic])->first()->toarray();
    //$this->set(compact('students'));

    //$student_datas = $this->StudentHostalfees->find('all')->where(['StudentHostalfees.student_id' => $id,'StudentHostalfees.acedmicyear' => $acedemic])->first()->toarray();

    //    $this->set('studentfees',$student_datas);

  }

  public function savedata()
  {

    if ($this->request->is('post') || $this->request->is('put')) {

      $clidd = sizeof($this->request->data['id']);
      $user = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
      $acedemic = $user['academic_year'];

      for ($i = 0; $i < $clidd; $i++) {

        $conns = ConnectionManager::get('default');
        if ($this->request->data['class_id'][$i] != '' && $this->request->data['section_id'][$i] != '' && $this->request->data['sms_mobile'][$i] != '') {

          if ($this->request->data['h_id'][$i] == '') {
            $this->request->data['h_id'][$i] = '0';
          }
          $rty = explode(" ", $this->request->data['name'][$i]);
          if ($rty[2] && $rty[3]) {
            $rty[2] = $rty[2] . " " . $rty[3];
          }
          $conns->execute("UPDATE `students` SET `fname`='" . $rty[0] . "',`middlename`='" . $rty[1] . "',`lname`='" . $rty[2] . "',`fathername`='" . $this->request->data['fathername'][$i] . "',`mothername`='" . $this->request->data['mothername'][$i] . "',`sms_mobile`='" . $this->request->data['sms_mobile'][$i] . "',`class_id`='" . $this->request->data['class_id'][$i] . "',`section_id`='" . $this->request->data['section_id'][$i] . "',`h_id`='" . $this->request->data['h_id'][$i] . "',`house_id`='" . $this->request->data['h_id'][$i] . "' WHERE `id`='" . $this->request->data['id'][$i] . "'");

          $students = $this->Students->find('all')->where(['Students.id' => $this->request->data['id'][$i], 'Students.acedmicyear' => $acedemic])->first();
          if ($this->request->data['section_id'][$i] != $students['section_id'] && $this->request->data['class_id'][$i] == $students['class_id']) {

            $conn = ConnectionManager::get('default');
            $detail = 'UPDATE `studentexamresult` SET `sect_id`="' . $this->request->data['section_id'][$i] . '" WHERE `stud_id`="' . $students['id'] . '"';

            $results = $conn->execute($detail);
          }
        }
      }

      $this->Flash->success(__('Student Information has been Updated successfully.'));

      return $this->redirect(['action' => 'view']);
    }
  }

  public function searchstudentfees()
  {

    $conn = ConnectionManager::get('default');
    $enroll = $this->request->data['enroll'];
    $fname = explode(' ', $this->request->data['name']);
    $fathername = $this->request->data['fathername'];
    $mothername = $this->request->data['mothername'];

    $detail = "SELECT Students.id,Students.enroll,Students.sms_mobile,Students.discountcategory,Students.fathername,Students.mothername,Students.category,Students.h_id,Students.fname,Students.middlename,Students.lname,Students.mobile,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id    WHERE  1=1 ";

    $cond = ' ';

    if (!empty($enroll)) {

      $cond .= " AND Students.enroll ='" . $enroll . "'";
    }
    $rolepresent = $this->request->session()->read('Auth.User.role_id');
    if ($rolepresent == '5') {
      $cond .= " AND Students.board_id LIKE '1'";
    } else if ($rolepresent == '8') {

      $cond .= " AND Students.board_id IN (2,3)";
    }
    if (!empty($mothername)) {

      $cond .= " AND UPPER(Students.mothername) LIKE '" . strtoupper($mothername) . "%' ";
    }

    if (!empty($fathername)) {

      $cond .= " AND UPPER(Students.fathername) LIKE '" . strtoupper($fathername) . "%' ";
    }

    if (!empty($fname[0])) {

      $cond .= " AND  UPPER(Students.fname)  LIKE  '" . strtoupper($fname[0]) . "%'";
    }

    if (!empty($fname[1])) {

      $cond .= " AND   UPPER(Students.middlename)  LIKE  '" . strtoupper($fname[1]) . "%'";
    }

    $detail = $detail . $cond;
    $SQL = $detail . " ORDER BY Classes.sort ASC,Sections.id ASC,Students.fname ASC";

    $studente = $conn->execute($SQL)->fetchAll('assoc');

    if (empty($studente)) {

      $detail2 = "SELECT DropOutStudent.s_id,DropOutStudent.enroll,DropOutStudent.sms_mobile,DropOutStudent.discountcategory,DropOutStudent.fathername,DropOutStudent.mothername,DropOutStudent.category,DropOutStudent.h_id,DropOutStudent.fname,DropOutStudent.middlename,DropOutStudent.lname,DropOutStudent.mobile,DropOutStudent.acedmicyear,DropOutStudent.class_id,DropOutStudent.section_id,DropOutStudent.admissionyear,DropOutStudent.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `drop_out_students` DropOutStudent LEFT JOIN classes Classes ON DropOutStudent.`class_id` = Classes.id LEFT JOIN sections Sections ON DropOutStudent.`section_id` = Sections.id    WHERE  1=1 ";

      $cond = ' ';

      if (!empty($enroll)) {

        $cond .= " AND DropOutStudent.enroll ='" . $enroll . "'";
      }
      $rolepresent = $this->request->session()->read('Auth.User.role_id');
      if ($rolepresent == '5') {
        $cond .= " AND DropOutStudent.board_id LIKE '1'";
      } else if ($rolepresent == '8') {

        $cond .= " AND DropOutStudent.board_id IN (2,3)";
      }
      if (!empty($mothername)) {

        $cond .= " AND UPPER(DropOutStudent.mothername) LIKE '" . strtoupper($mothername) . "%' ";
      }

      if (!empty($fathername)) {

        $cond .= " AND UPPER(DropOutStudent.fathername) LIKE '" . strtoupper($fathername) . "%' ";
      }

      if (!empty($fname[0])) {

        $cond .= " AND  UPPER(DropOutStudent.fname)  LIKE  '" . strtoupper($fname[0]) . "%'";
      }

      if (!empty($fname[1])) {

        $cond .= " AND   UPPER(DropOutStudent.middlename)  LIKE  '" . strtoupper($fname[1]) . "%'";
      }

      $detail2 = $detail2 . $cond;
      $SQL = $detail2 . " ORDER BY Classes.sort ASC,Sections.id ASC,DropOutStudent.fname ASC";

      $studente = $conn->execute($SQL)->fetchAll('assoc');

      $studente[0]['id'] = $studente[0]['s_id'];
    }

    $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

    $acedemic = $users['academic_year'];

    $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $studente[0]['id'], 'Studentfees.status' => 'Y', 'Studentfees.deposite_amt !=' => '0', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
    $i = 0;
    $stu_his = $this->Studentshistory->find('all')->where(['stud_id' => $studente[0]['id']])->toarray();
    $i = 0;
    foreach ($student_datask as $stu) {
      if ($stu['acedmicyear'] == $studente[0]['acedmicyear']) {
        $student_datask[$i]['class'] = $this->classsection($studente[0]['class_id'], $studente[0]['section_id']);
      } else if (!empty($stu_his)) {
        foreach ($stu_his as $val) {

          if ($val['acedmicyear'] == $stu['acedmicyear']) {

            $student_datask[$i]['class'] = $this->classsection($val['class_id'], $val['section_id']);
          }
        }
      }

      $i++;
    }

    $detail = $this->Otherfees->find('all')->where(['s_id' => $studente[0]['enroll']])->order(['id' => 'DESC'])->toarray();
    $this->set('detail', $detail);
    $this->set('studentfeesk', $student_datask);
    $this->set('acedemic', $acedemic);
  }
  public function classsection($class = null, $section = null)
  {

    $class_det = $this->Classes->find()->select('title')->where(['id' => $class])->first();

    $sec_det = $this->Sections->find()->select('title')->where(['id' => $section])->first();
    $det = $class_det->title . "-" . $sec_det->title;

    return $det;
  }
  // search functionality
  public function search()
  {

    //show all data in listing page
    //connection

    // pr($this->request->data);die; 

    $rolepresent = $this->request->session()->read('Auth.User.role_id');

    if ($rolepresent == '1' || $rolepresent == '6') {
      $classes = $this->Classections->find('list', [
        'keyField' => 'Classes.id',
        'valueField' => 'Classes.title',
      ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
      $this->set('classes', $classes);
    } else if ($rolepresent == '5') {

      $classes = $this->Classections->find('list', [
        'keyField' => 'Classes.id',
        'valueField' => 'Classes.title',
      ])->contain(['Classes'])->where(['Classes.status' => '1', 'Classes.board_id' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
      $this->set('classes', $classes);
    } else if ($rolepresent == '8') {

      $classes = $this->Classections->find('list', [
        'keyField' => 'Classes.id',
        'valueField' => 'Classes.title',
      ])->contain(['Classes'])->where(['Classes.status' => '1', 'Classes.board_id IN' => ['2', '3']])->order(['Classections.id' => 'ASC'])->toArray();
      $this->set('classes', $classes);
    }

    $sectionslist = $this->Sections->find('list', [
      'keyField' => 'id',
      'valueField' => 'title',
    ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
    $this->set('sectionslist', $sectionslist);

    $houses = $this->Houses->find('list', [
      'keyField' => 'id',
      'valueField' => 'name',
    ])->where(['status' => '1'])->order(['name' => 'ASC'])->toArray();
    $this->set('houses', $houses);

    $conn = ConnectionManager::get('default');
    $user = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
    $year = $user['academic_year'];

    $class = $this->request->data['class_id'];
    $acedmicyear = $this->request->data['acedmicyear'];
    $section = $this->request->data['section_id'];
    $enroll = $this->request->data['enroll'];
    $fname = explode(' ', $this->request->data['name']);
    $fathername = trim($this->request->data['fathername']);
    $mothername = trim($this->request->data['mothername']);
    $h_id = $this->request->data['h_id'];
    $gender = $this->request->data['gender'];

    $detail = "SELECT Students.id,Students.enroll,Students.sms_mobile,Students.discountcategory,Students.fathername,Students.mothername,Students.category,Students.oldenroll,Students.h_id,Students.fname,Students.middlename,Students.lname,Students.mobile,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id    WHERE  1=1 ";

    $cond = ' ';
    if (!empty($year)) {

      $cond .= " AND Students.acedmicyear LIKE '" . $acedmicyear . "'";
    }

    if (!empty($class)) {

      $cond .= " AND Students.class_id LIKE '" . $class . "'";
    }

    if (!empty($h_id)) {

      $cond .= " AND Students.h_id='" . $h_id . "'";
    }
    if (!empty($gender)) {

      $cond .= " AND Students.gender LIKE '" . $gender . "'";
    }

    if (!empty($section)) {

      $cond .= " AND Students.section_id LIKE '" . $section . "'";
    }

    if (!empty($enroll)) {

      $cond .= " AND Students.enroll LIKE '" . $enroll . "'";
    }
    $rolepresent = $this->request->session()->read('Auth.User.role_id');
    if ($rolepresent == '5') {
      $cond .= " AND Students.board_id LIKE '1'";
    } else if ($rolepresent == '8') {

      $cond .= " AND Students.board_id IN (2,3)";
    }
    if (!empty($mothername)) {

      $cond .= " AND UPPER(Students.mothername) LIKE '" . strtoupper($mothername) . "%' ";
    }

    if (!empty($fathername)) {

      $cond .= " AND UPPER(Students.fathername) LIKE '" . strtoupper($fathername) . "%' ";
    }

    if (!empty($fname[0])) {

      $cond .= " AND  UPPER(Students.fname)  LIKE  '" . strtoupper($fname[0]) . "%'";
    }

    if (!empty($fname[1])) {

      $cond .= " AND   UPPER(Students.middlename)  LIKE  '" . strtoupper($fname[1]) . "%'";
    }

    $cond .= " AND Students.status='Y'";
    $detail = $detail . $cond;
    $SQL = $detail . " ORDER BY Classes.sort ASC,Sections.id ASC,Students.fname ASC";

    $results = $conn->execute($SQL)->fetchAll('assoc');

    $this->set('students', $results);
  }

  // deposite fees search based functinality Live code 26 dec 2023
  // public function depositefees()
  // {
  //   $this->viewBuilder()->layout('ajax');
  //   $this->loadModel('HostelFeesManagement');

  //   $id = $this->request->data['student_id'];
  //   $stdnt = $this->Students->get($id);

  //   $academic_year = $this->request->data['accademic_year'];


  //   $db = $this->Users->find()->where(['role_id' => 1])->first();
  //   $this->set(compact('db'));
  //   $findpendings = $this->studentshistoryagain($id);

  //   // $translocations = $this->Transportfees->find('all')->contain(['Locations'])->order(['Transportfees.id' => 'DESC'])->toarray();       
  //   // pr($transportfeess);die;
  //   $emotys = array();
  //   if (!empty($findpendings)) {
  //     foreach ($findpendings as $kkt => $rtt) {
  //       //$fetchdetail = $this->defaultersearchbyidhistory($rtt['stud_id'],$rtt['acedmicyear']);
  //       $fetchdetail = 1;
  //       if ($fetchdetail == "--") {
  //         $fetchdetail = '';
  //       }
  //       $emotys[] = $fetchdetail . "/" . $rtt['stud_id'] . "/" . $rtt['acedmicyear'];
  //     }
  //   }

  //   $this->set('emotys', $emotys);
  //   // Note: type IN 4 is Previous Year Due where head id is 57,3 is Hostel fees , 12 is Hostel Cation Money id

  //   if ($stdnt['is_hostel']) {
  //     $findHostelFees = $this->HostelFeesManagement->find('all')->where(['id' => $stdnt['is_hostel']])->first();
  //     // pr($findHostelFees['fees_head_id']);exit;

  //     $feesheadstotal = $this->Feesheads->find('all', [
  //       'keyField' => 'id',
  //       'valueField' => 'name',
  //     ])->where([
  //       'status' => 'Y',
  //       'id IN' => [$findHostelFees['fees_head_id'], 12, 57, 58],
  //       // 'type IN' => ['4'],
  //       'sort !=' => '0',
  //     ])->order(['name' => 'ASC'])->toArray();
  //   } else {
  //     $feesheadstotal = $this->Feesheads->find('all', [
  //       'keyField' => 'id',
  //       'valueField' => 'name',
  //     ])->where(['status' => 'Y', 'type IN' => ['4', '0'], 'sort !=' => '0'])->order(['name' => 'ASC'])->toArray();
  //   }


  //   $this->set('feesheadstotal', $feesheadstotal);

  //   //$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
  //   //$academic_year=$users['academic_year'];
  //   $discountCategorylist = $this->DiscountCategory->find('all', [
  //     'keyField' => 'id',
  //     'valueField' => 'name',
  //   ])->where(['status' => 'Y', 'type !=' => '1'])->order(['id' => 'ASC'])->toArray();
  //   $this->set('discountCategorylist', $discountCategorylist);

  //   //show data in listing
  //   if (isset($_GET['id'])) {
  //     $this->set('selectid', $_GET['id']);
  //   }

  //   if ($this->request->session()->read('paydatef')) {

  //     $paydatef = $this->request->session()->read('paydatef');
  //     $ids2s = $this->request->session()->read('reciptnof');
  //     $this->set('paydatef', $paydatef);
  //     if ($ids2s != '0') {
  //       $reciptnof = $ids2s + 1;
  //       $this->set('reciptnof', $reciptnof);
  //     }
  //   }


  //   $this->set(compact('id'));
  //   $this->set(compact('academic_year'));

  //   $discount_fees = $stdnt->dis_fees;
  //   $dis_hostel = $stdnt->dis_hostel;
  //   $dis_transport = $stdnt->dis_transport;
  //   $classid = $stdnt->class_id;
  //   $academic_year = $academic_year;

  //   $alldata = $this->Classfee->find('all')->contain(['Feesheads'])->where(['class_id' => $classid, 'academic_year' => $academic_year])->toarray();
  //   $personalduefees = $this->Previousduefees->find('all')->where(['Previousduefees.student_id' => $id])->first();
  //   $Sitesettings = $this->Sitesettings->find('all')->where(['Sitesettings.print' => '1'])->first();
  //   $Is_special = $this->Sitesettings->find('all')->first();
  //   // pr($Is_special);exit;
  //   $this->set('Is_special', $Is_special);
  //   $this->set('Sitesettings', $Sitesettings);
  //   $this->set('personalduefees', $personalduefees);
  //   $this->set('alldata', $alldata);
  //   $this->set('id', $id);
  //   $this->set('academic_year', $academic_year);

  //   if (!empty($discount_fees)) {
  //     $this->set('discount_fees', $discount_fees);
  //   } else {
  //     $discount_fees = '0';
  //     $this->set('discount_fees', $discount_fees);
  //   }
  //   if (!empty($dis_hostel)) {
  //     $this->set('dis_hostel', $dis_hostel);
  //   } else {
  //     $dis_hostel = '0';
  //     $this->set('dis_hostel', $dis_hostel);
  //   }
  //   if (!empty($dis_transport)) {
  //     $this->set('dis_transport', $dis_transport);
  //   } else {
  //     $dis_transport = '0';
  //     $this->set('dis_transport', $dis_transport);
  //   }

  //   $stdntddf = $this->Students->find('all')->where(['Students.id' => $id])->first();

  //   if ($stdntddf['location_id'] != '' || $stdntddf['bus_number'] != '') {

  //     $transportfees = $this->Transportfees->find('all')->where(['Transportfees.loc_id' => $stdntddf['location_id'], 'Transportfees.academic_year' => $academic_year])->first();

  //     $this->set('transportfees', $transportfees);
  //   } else {
  //     $transportfees = 0;
  //     $this->set('transportfees', $transportfees);
  //   }

  //   $fathernamefffg = $stdntddf['fathername'];
  //   $mothernamefffg = $stdntddf['mothername'];

  //   $student_dataftf = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.fathername' => $fathernamefffg, 'Students.mothername' => $mothernamefffg, 'Students.id NOT IN' => $id, 'Students.status' => 'Y'])->toarray();
  //   $this->set('student_dataftf', $student_dataftf);

  //   $feeheads = $this->Feesheads->find('all')->where(['Feesheads.status' => 'Y'])->toarray();
  //   $this->set('feeheads', $feeheads);

  //   $feeheadstype = $this->Feesheads->find('all')->where(['Feesheads.type' => '2'])->toarray();
  //   $this->set('feeheadstype', $feeheadstype);


  //   $completeFeesheads = $this->Feesheads->find('list', [
  //     'keyField' => 'id',
  //     'valueField' => 'name',
  //   ])->where(['status' => 'Y'])->order(['id' => 'ASC'])->toArray();
  //   // pr($completeFeesheads);exit;
  //   $this->set('completeFeesheads', $completeFeesheads);


  //   $classfeesss = $this->Classfee->find('all')->contain(['Classes', 'Feesheads'])->group('Classfee.academic_year')->group('Classfee.class_id')->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => $this->Classfee->find()->func()->sum('Classfee.qu1_fees'), 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.qu1_date', 'Feesheads.name', 'Classfee.qu2_date', 'Classfee.qu3_date', 'Classfee.qu4_date', 'Classfee.status', 'Classfee.class_id'])->toarray();

  //   // pr($classfeesss);exit;
  //   $this->set('classfeesss', $classfeesss);

  //   $classes = $this->Classections->find('list', [
  //     'keyField' => 'Classes.id',
  //     'valueField' => 'Classes.title',
  //   ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();

  //   $this->set('classes', $classes);

  //   $sectionslist = $this->Sections->find('list', [
  //     'keyField' => 'id',
  //     'valueField' => 'title',
  //   ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();

  //   $this->set('sectionslist', $sectionslist);

  //   $this->set('id', $id);

  //   $banks = $this->Banks->find('list', [
  //     'keyField' => 'id',
  //     'valueField' => 'name'
  //   ])->where(['Banks.status' => 'Y'])->order(['Banks.id' => 'asc'])->toArray();

  //   $this->set('banks', $banks);

  //   $rolepresent = $this->request->session()->read('Auth.User.role_id');
  //   if ($rolepresent == '1' || $rolepresent == '6'  || $rolepresent == '105' || $rolepresent == '5') {

  //     $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.status' => 'Y'])->first();
  //     $this->set('students', $student_data);


  //     $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

  //     $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

  //     if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
  //       $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
  //     }

  //     $student_datasmaxssss = $this->Studentfees->find('all')->contain(['Students'])->select(['cheque_no', 'ref_no', 'bank'])->where(['Students.status' => 'Y'])->order(['Studentfees.id DESC'])->first();

  //     $this->set('student_datasmaxssss', $student_datasmaxssss['cheque_no']);
  //     $this->set('student_datasmref_no', $student_datasmaxssss['ref_no']);
  //     $this->set('student_databank', $student_datasmaxssss['bank']);
  //     // $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' => '1'])->first();

  //     // $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' => '1', 'Enquires.class_id <=' => '22'])->contain(['Enquires'])->first();

  //     $c = $student_datasmaxss['amount'];
  //     // pr($c); die;

  //   }
  //   // pr($student_data);exit;

  //   // if (!empty($student_data['location_id'] == '' || $student_data['bus_number'] == '')) {
  //   // }

  //   $student_datasm = $c + 1;
  //   $this->set('student_datasm', $student_datasm);
  //   $acedmicyear = $academic_year;
  //   $this->set('academic_year', $academic_year);
  //   $acedmiclassid = $student_data['class_id'];
  //   $this->set('academic_class', $acedmiclassid);
  //   $is_transport = $student_data['is_transport'];
  //   $is_hostel = $student_data['is_hostel'];
  //   $this->set('is_transport', $is_transport);
  //   $this->set('is_hostel', $is_hostel);
  //   $transportloc_id = $student_data['transportloc_id'];
  //   $this->set('transportloc_id', $transportloc_id);
  //   $hostal_id = $student_data['h_id'];
  //   $this->set('hostal_id', $hostal_id);
  //   $this->set('id', $id);
  //   $transportfeess = $this->Transportfees->find('all')->where(['Transportfees.loc_id' => $transportloc_id, 'Transportfees.academic_year' => $acedmicyear])->toarray();
  //   // pr($transportfeess);exit;
  //   $this->set('transportfeess', $transportfeess);

  //   $hostalfeess = $this->Hostels->find('all')->where(['Hostels.id' =>
  //   $hostal_id, 'Hostels.academicyear' => $acedmicyear])->toarray();
  //   $this->set('hostalfeess', $hostalfeess);

  //   $studentold = $this->Students->find('all')->where(['Students.id' => $id, 'Students.acedmicyear' => $acedmicyear])->first();
  //   $oldenrool = $studentold['oldenroll'];
  //   $studentolds = $this->Students->find('all')->where(['Students.enroll' => $oldenrool, 'Students.acedmicyear' => $acedmicyear])->first();
  //   $oldenrool = $studentold['oldenroll'];
  //   $oldenrools = $studentolds['id'];

  //   if ($oldenrool && $oldenrools) {
  //     $studsentold = $this->Students->find('all')->where(['Students.enroll' => $oldenrool])->first();
  //     $ols = $studsentold['id'];

  //     $student_datas3s = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.acedmicyear' => $acedmicyear])->toarray();

  //     $student_datas31s = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.acedmicyear !=' => $acedmicyear])->toarray();

  //     foreach ($student_datas31s as $kss => $valuess) {
  //       $quaswr[] = unserialize($valuess['quarter']);
  //     }

  //     $quafljr = array();

  //     foreach ($quaswr as $hljr => $valeljr) {

  //       $quafljr = array_merge($quafljr, $valeljr);
  //     }
  //     $rtljr = array();
  //     foreach ($quafljr as $jljr => $tljr) {
  //       if ($jljr == "Admission Fee" || $jljr == "Development Fee" || $jljr == "Caution Money") {
  //         $quarsgh[] = $jljr;
  //       }
  //     }


  //     $this->set('quarsgh', $quarsgh);
  //     $this->set('studentfees2s', $student_datas3s);

  //     $studentsacedemics = $this->Studentshistory->find('all')->where(['Studentshistory.stud_id' => $id, 'Studentshistory.status' => 'Y'])->group(['Studentshistory.acedmicyear'])->toarray();
  //     foreach ($studentsacedemics as $ktt => $itt) {
  //       $aced[] = $itt['acedmicyear'];
  //     }

  //     if (!empty($aced)) {
  //       $student_datas1 = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear IN' => $aced, 'Studentfees.status' => 'Y'])->toarray();

  //       $this->set('studentfees1', $student_datas1);
  //     }
  //   }

  //   $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();
  //   $this->set('studentfees', $student_datas);
  //   $student_datas2 = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->toarray();
  //   $this->set('studentfees2', $student_datas2);

  //   $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
  //   if ($id == 4692) {
  //     $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
  //   }
  //   $this->set('studentfeesk', $student_datask);

  //   $student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $id, 'Studentfeepending.status' => 'N'])->toarray();
  //   $this->set('student_feepending', $student_feepending);

  //   $student_datash = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->group(['Studentfees.created'])->toarray();
  //   $this->set('stduefee', $student_datash);

  //   $student_trans = $this->StudentTransfees->find('all')->where(['StudentTransfees.student_id' => $id, 'StudentTransfees.acedmicyear' => $acedmicyear])->toarray();
  //   $this->set('studenttransfee', $student_trans);

  //   $student_hostal = $this->StudentHostalfees->find('all')->where(['StudentHostalfees.student_id' => $id, 'StudentHostalfees.student_id' => $id])->toarray();
  //   $this->set('studenthostalfee', $student_hostal);

  //   $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.fee_h_id')->where(['Classfee.fee_h_id IN' => ['2', '6'], 'Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid])->order(['Classfee.id' => 'ASC'])->select([
  //     'qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id',
  //   ])->toarray();


  //   $this->set('classfee', $classfee);
  //   // set here yeatly fees deposite 
  //   // $fid = [1, 5, 7, 8, 10, 11];
  //   // $sfee = $this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid, 'Classfee.fee_h_id IN' => $fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();

  //   $sfee = $this->Classfee->find('all')->contain(['Classes', 'Feesheads'])->where(['Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid, 'Feesheads.type IN' => ['2']])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();

  //   // pr($sfee);
  //   // pr($student_data);die;

  //   $this->set('preclassfee', $sfee);
  // }

  // deposite fees search based functinality Staging code 26 dec 2023
  // public function depositefees()
  // {
  //   $this->viewBuilder()->layout('ajax');
  //   $this->loadModel('HostelFeesManagement');

  //   $id = $this->request->data['student_id'];
  //   $stdnt = $this->Students->get($id);

  //   $academic_year = $this->request->data['accademic_year'];


  //   $db = $this->Users->find()->where(['role_id' => 1])->first();
  //   $this->set(compact('db'));
  //   $findpendings = $this->studentshistoryagain($id);

  //   // $translocations = $this->Transportfees->find('all')->contain(['Locations'])->order(['Transportfees.id' => 'DESC'])->toarray();       
  //   // pr($transportfeess);die;
  //   $emotys = array();
  //   if (!empty($findpendings)) {
  //     foreach ($findpendings as $kkt => $rtt) {
  //       //$fetchdetail = $this->defaultersearchbyidhistory($rtt['stud_id'],$rtt['acedmicyear']);
  //       $fetchdetail = 1;
  //       if ($fetchdetail == "--") {
  //         $fetchdetail = '';
  //       }
  //       $emotys[] = $fetchdetail . "/" . $rtt['stud_id'] . "/" . $rtt['acedmicyear'];
  //     }
  //   }

  //   $this->set('emotys', $emotys);
  //   // Note: type IN 4 is Previous Year Due where head id is 57,3 is Hostel fees , 12 is Hostel Cation Money id

  //   if ($stdnt['is_hostel']) {
  //     $findHostelFees = $this->HostelFeesManagement->find('all')->where(['id' => $stdnt['is_hostel']])->first();
  //     // pr($findHostelFees['fees_head_id']);exit;

  //     $feesheadstotal = $this->Feesheads->find('all', [
  //       'keyField' => 'id',
  //       'valueField' => 'name',
  //     ])->where([
  //       'status' => 'Y',
  //       'id IN' => [$findHostelFees['fees_head_id'], 12, 57, 58],
  //       // 'type IN' => ['4'],
  //       'sort !=' => '0',
  //     ])->order(['name' => 'ASC'])->toArray();
  //   } else {
  //     $feesheadstotal = $this->Feesheads->find('all', [
  //       'keyField' => 'id',
  //       'valueField' => 'name',
  //     ])->where(['status' => 'Y', 'type IN' => ['4', '0'], 'sort !=' => '0'])->order(['name' => 'ASC'])->toArray();
  //   }


  //   $this->set('feesheadstotal', $feesheadstotal);

  //   //$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
  //   //$academic_year=$users['academic_year'];
  //   $discountCategorylist = $this->DiscountCategory->find('all', [
  //     'keyField' => 'id',
  //     'valueField' => 'name',
  //   ])->where(['status' => 'Y', 'type !=' => '1'])->order(['id' => 'ASC'])->toArray();
  //   $this->set('discountCategorylist', $discountCategorylist);

  //   //show data in listing
  //   if (isset($_GET['id'])) {
  //     $this->set('selectid', $_GET['id']);
  //   }

  //   if ($this->request->session()->read('paydatef')) {

  //     $paydatef = $this->request->session()->read('paydatef');
  //     $ids2s = $this->request->session()->read('reciptnof');
  //     $this->set('paydatef', $paydatef);
  //     if ($ids2s != '0') {
  //       $reciptnof = $ids2s + 1;
  //       $this->set('reciptnof', $reciptnof);
  //     }
  //   }


  //   $this->set(compact('id'));
  //   $this->set(compact('academic_year'));

  //   $discount_fees = $stdnt->dis_fees;
  //   $dis_hostel = $stdnt->dis_hostel;
  //   $dis_transport = $stdnt->dis_transport;
  //   $classid = $stdnt->class_id;
  //   $academic_year = $academic_year;

  //   // $alldata = $this->Classfee->find('all')->contain(['Feesheads'])->where(['class_id' => $classid, 'academic_year' => $academic_year])->toarray();
  //   $personalduefees = $this->Previousduefees->find('all')->where(['Previousduefees.student_id' => $id])->first();
  //   $Sitesettings = $this->Sitesettings->find('all')->where(['Sitesettings.print' => '1'])->first();
  //   $Is_special = $this->Sitesettings->find('all')->first();
  //   // pr($Is_special);exit;
  //   $this->set('Is_special', $Is_special);
  //   $this->set('Sitesettings', $Sitesettings);
  //   $this->set('personalduefees', $personalduefees);
  //   // $this->set('alldata', $alldata);
  //   $this->set('id', $id);
  //   $this->set('academic_year', $academic_year);

  //   if (!empty($discount_fees)) {
  //     $this->set('discount_fees', $discount_fees);
  //   } else {
  //     $discount_fees = '0';
  //     $this->set('discount_fees', $discount_fees);
  //   }
  //   if (!empty($dis_hostel)) {
  //     $this->set('dis_hostel', $dis_hostel);
  //   } else {
  //     $dis_hostel = '0';
  //     $this->set('dis_hostel', $dis_hostel);
  //   }
  //   if (!empty($dis_transport)) {
  //     $this->set('dis_transport', $dis_transport);
  //   } else {
  //     $dis_transport = '0';
  //     $this->set('dis_transport', $dis_transport);
  //   }

  //   $stdntddf = $this->Students->find('all')->where(['Students.id' => $id])->first();

  //   if ($stdntddf['location_id'] != '' || $stdntddf['bus_number'] != '' || $stdntddf['is_transport'] == 'Y') {

  //     $transportfees = $this->Transportfees->find('all')->where(['Transportfees.loc_id' => $stdntddf['location_id'], 'Transportfees.academic_year' => $academic_year])->first();

  //     $this->set('transportfees', $transportfees);
  //   } else {
  //     $transportfees = 0;
  //     $this->set('transportfees', $transportfees);
  //   }

  //   $fathernamefffg = $stdntddf['fathername'];
  //   $mothernamefffg = $stdntddf['mothername'];

  //   $student_dataftf = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.fathername' => $fathernamefffg, 'Students.mothername' => $mothernamefffg, 'Students.id NOT IN' => $id, 'Students.status' => 'Y'])->toarray();
  //   $this->set('student_dataftf', $student_dataftf);

  //   $feeheads = $this->Feesheads->find('all')->where(['Feesheads.status' => 'Y'])->toarray();
  //   $this->set('feeheads', $feeheads);

  //   $feeheadstype = $this->Feesheads->find('all')->where(['Feesheads.type' => '2'])->toarray();
  //   $this->set('feeheadstype', $feeheadstype);


  //   $completeFeesheads = $this->Feesheads->find('list', [
  //     'keyField' => 'id',
  //     'valueField' => 'name',
  //   ])->where(['status' => 'Y'])->order(['id' => 'ASC'])->toArray();
  //   // pr($completeFeesheads);exit;
  //   $this->set('completeFeesheads', $completeFeesheads);


  //   // $classfeesss = $this->Classfee->find('all')->contain(['Classes', 'Feesheads'])->group('Classfee.academic_year')->group('Classfee.class_id')->order(['Classfee.id' => 'ASC'])->select(['qu1_fees' => $this->Classfee->find()->func()->sum('Classfee.qu1_fees'), 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.qu1_date', 'Feesheads.name', 'Classfee.qu2_date', 'Classfee.qu3_date', 'Classfee.qu4_date', 'Classfee.status', 'Classfee.class_id'])->toarray();

  //   // // pr($classfeesss);exit;
  //   // $this->set('classfeesss', $classfeesss);

  //   $classes = $this->Classections->find('list', [
  //     'keyField' => 'Classes.id',
  //     'valueField' => 'Classes.title',
  //   ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();

  //   $this->set('classes', $classes);

  //   $sectionslist = $this->Sections->find('list', [
  //     'keyField' => 'id',
  //     'valueField' => 'title',
  //   ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();

  //   $this->set('sectionslist', $sectionslist);

  //   $this->set('id', $id);

  //   $banks = $this->Banks->find('list', [
  //     'keyField' => 'id',
  //     'valueField' => 'name'
  //   ])->where(['Banks.status' => 'Y'])->order(['Banks.id' => 'asc'])->toArray();

  //   $this->set('banks', $banks);

  //   $rolepresent = $this->request->session()->read('Auth.User.role_id');
  //   if ($rolepresent == '1' || $rolepresent == '6'  || $rolepresent == '105' || $rolepresent == '5') {

  //     $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.status' => 'Y'])->first();
  //     $this->set('students', $student_data);


  //     $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

  //     $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

  //     if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
  //       $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
  //     }

  //     $student_datasmaxssss = $this->Studentfees->find('all')->contain(['Students'])->select(['cheque_no', 'ref_no', 'bank'])->where(['Students.status' => 'Y'])->order(['Studentfees.id DESC'])->first();

  //     $this->set('student_datasmaxssss', $student_datasmaxssss['cheque_no']);
  //     $this->set('student_datasmref_no', $student_datasmaxssss['ref_no']);
  //     $this->set('student_databank', $student_datasmaxssss['bank']);
  //     // $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' => '1'])->first();

  //     // $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' => '1', 'Enquires.class_id <=' => '22'])->contain(['Enquires'])->first();

  //     $c = $student_datasmaxss['amount'];
  //     // pr($c); die;

  //   }
  //   // pr($student_data);exit;

  //   // if (!empty($student_data['location_id'] == '' || $student_data['bus_number'] == '')) {
  //   // }

  //   $student_datasm = $c + 1;
  //   $this->set('student_datasm', $student_datasm);
  //   $acedmicyear = $academic_year;
  //   $this->set('academic_year', $academic_year);
  //   $acedmiclassid = $student_data['class_id'];
  //   $this->set('academic_class', $acedmiclassid);
  //   $is_transport = $student_data['is_transport'];
  //   $is_hostel = $student_data['is_hostel'];
  //   $this->set('is_transport', $is_transport);
  //   $this->set('is_hostel', $is_hostel);
  //   $transportloc_id = $student_data['transportloc_id'];
  //   $this->set('transportloc_id', $transportloc_id);
  //   $hostal_id = $student_data['h_id'];
  //   $this->set('hostal_id', $hostal_id);
  //   $this->set('id', $id);
  //   $transportfeess = $this->Transportfees->find('all')->where(['Transportfees.loc_id' => $transportloc_id, 'Transportfees.academic_year' => $acedmicyear])->toarray();
  //   // pr($transportfeess);exit;
  //   $this->set('transportfeess', $transportfeess);

  //   $hostalfeess = $this->Hostels->find('all')->where(['Hostels.id' =>
  //   $hostal_id, 'Hostels.academicyear' => $acedmicyear])->toarray();
  //   $this->set('hostalfeess', $hostalfeess);

  //   $studentold = $this->Students->find('all')->where(['Students.id' => $id, 'Students.acedmicyear' => $acedmicyear])->first();
  //   $oldenrool = $studentold['oldenroll'];
  //   $studentolds = $this->Students->find('all')->where(['Students.enroll' => $oldenrool, 'Students.acedmicyear' => $acedmicyear])->first();
  //   $oldenrool = $studentold['oldenroll'];
  //   $oldenrools = $studentolds['id'];

  //   if ($oldenrool && $oldenrools) {
  //     $studsentold = $this->Students->find('all')->where(['Students.enroll' => $oldenrool])->first();
  //     $ols = $studsentold['id'];

  //     $student_datas3s = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.acedmicyear' => $acedmicyear])->toarray();

  //     $student_datas31s = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.acedmicyear !=' => $acedmicyear])->toarray();

  //     foreach ($student_datas31s as $kss => $valuess) {
  //       $quaswr[] = unserialize($valuess['quarter']);
  //     }

  //     $quafljr = array();

  //     foreach ($quaswr as $hljr => $valeljr) {

  //       $quafljr = array_merge($quafljr, $valeljr);
  //     }
  //     $rtljr = array();
  //     foreach ($quafljr as $jljr => $tljr) {
  //       if ($jljr == "Admission Fee" || $jljr == "Development Fee" || $jljr == "Caution Money") {
  //         $quarsgh[] = $jljr;
  //       }
  //     }


  //     $this->set('quarsgh', $quarsgh);
  //     $this->set('studentfees2s', $student_datas3s);

  //     $studentsacedemics = $this->Studentshistory->find('all')->where(['Studentshistory.stud_id' => $id, 'Studentshistory.status' => 'Y'])->group(['Studentshistory.acedmicyear'])->toarray();
  //     foreach ($studentsacedemics as $ktt => $itt) {
  //       $aced[] = $itt['acedmicyear'];
  //     }

  //     if (!empty($aced)) {
  //       $student_datas1 = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear IN' => $aced, 'Studentfees.status' => 'Y'])->toarray();

  //       $this->set('studentfees1', $student_datas1);
  //     }
  //   }

  //   $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();
  //   $this->set('studentfees', $student_datas);
  //   $student_datas2 = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->toarray();
  //   $this->set('studentfees2', $student_datas2);

  //   $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
  //   if ($id == 4692) {
  //     $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
  //   }
  //   $this->set('studentfeesk', $student_datask);

  //   $student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $id, 'Studentfeepending.status' => 'N'])->toarray();
  //   $this->set('student_feepending', $student_feepending);

  //   $student_datash = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->group(['Studentfees.created'])->toarray();
  //   $this->set('stduefee', $student_datash);

  //   $student_trans = $this->StudentTransfees->find('all')->where(['StudentTransfees.student_id' => $id, 'StudentTransfees.acedmicyear' => $acedmicyear])->toarray();
  //   $this->set('studenttransfee', $student_trans);

  //   $student_hostal = $this->StudentHostalfees->find('all')->where(['StudentHostalfees.student_id' => $id, 'StudentHostalfees.student_id' => $id])->toarray();
  //   $this->set('studenthostalfee', $student_hostal);

  //   // $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.fee_h_id')->where(['Classfee.fee_h_id IN' => [2, 6], 'Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid])->order(['Classfee.fee_h_id' => 'ASC'])->select([
  //   //   'qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id',
  //   // ])->toarray();

  //   $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.fee_h_id')->where(['Classfee.fee_h_id IN' => [2, 6], 'Classfee.academic_year' => $stdntddf['batch'], 'Classfee.class_id' => $acedmiclassid])->order(['Classfee.fee_h_id' => 'ASC'])->select([
  //     'qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id',
  //   ])->toarray();

  //   // pr($stdntddf);
  //   // exit;

  //   $this->set('classfee', $classfee);
  //   // set here yeatly fees deposite 
  //   // $fid = [1, 5, 7, 8, 10, 11];
  //   // $sfee = $this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid, 'Classfee.fee_h_id IN' => $fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();

  //   // $sfee = $this->Classfee->find('all')->contain(['Classes', 'Feesheads'])->where(['Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid, 'Feesheads.type IN' => ['2']])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();

  //   $sfee = $this->Classfee->find('all')->contain(['Classes', 'Feesheads'])->where(['Classfee.academic_year' => $stdntddf['batch'], 'Classfee.class_id' => $acedmiclassid, 'Feesheads.type IN' => ['2']])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();

  //   // pr($sfee);
  //   // pr($student_data);die;

  //   $this->set('preclassfee', $sfee);
  // }


  // This function refine by Rupam 26-12-2023
  public function depositefees()
  {
    $this->viewBuilder()->layout('ajax');
    $this->loadModel('HostelFeesManagement');

    // pr($this->request->data);exit;

    $user = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
    $academic_year = $user['academic_year'];
    $id = $this->request->data['student_id'];
    $stdntddf = $this->Students->find('all')->where(['Students.id' => $id])->first();
    // $stdnt = $this->Students->where(['id' => $id])->first();
    if (empty($stdntddf)) {
      $stdntddf = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where(['DropOutStudent.s_id' => $id])->first();
    }

    $db = $this->Users->find()->where(['role_id' => 1])->first();
    $this->set(compact('db', 'academic_year'));
    $findpendings = $this->studentshistoryagain($id);

    $emotys = array();
    if (!empty($findpendings)) {
      foreach ($findpendings as $kkt => $rtt) {
        //$fetchdetail = $this->defaultersearchbyidhistory($rtt['stud_id'],$rtt['acedmicyear']);
        $fetchdetail = 1;
        if ($fetchdetail == "--") {
          $fetchdetail = '';
        }
        $emotys[] = $fetchdetail . "/" . $rtt['stud_id'] . "/" . $rtt['acedmicyear'];
      }
    }
    $this->set('emotys', $emotys);
    // Note: type IN 4 is Previous Year Due where head id is 57,3 is Hostel fees , 12 is Hostel Cation Money id

    if ($stdntddf['is_hostel']) {

      $findHostelFees = $this->HostelFeesManagement->find('all')->where(['id' => $stdntddf['is_hostel']])->first();
      // pr($findHostelFees['fees_head_id']);exit;

      $feesheadstotal = $this->Feesheads->find('all', [
        'keyField' => 'id',
        'valueField' => 'name',
      ])->where([
        'status' => 'Y',
        'id IN' => [$findHostelFees['fees_head_id'], 12, 57, 58],
        // 'type IN' => ['4'],
        'sort !=' => '0',
      ])->order(['name' => 'ASC'])->toArray();
    } else {
      $feesheadstotal = $this->Feesheads->find('all', [
        'keyField' => 'id',
        'valueField' => 'name',
      ])->where(['status' => 'Y', 'type IN' => ['4', '0'], 'sort !=' => '0'])->order(['name' => 'ASC'])->toArray();
      // pr($feesheadstotal); die;
    }
    $this->set('feesheadstotal', $feesheadstotal);

    $discountCategorylist = $this->DiscountCategory->find('all', [
      'keyField' => 'id',
      'valueField' => 'name',
    ])->where(['status' => 'Y', 'type !=' => '1'])->order(['id' => 'ASC'])->toArray();
    $this->set('discountCategorylist', $discountCategorylist);

    //show data in listing
    if (isset($_GET['id'])) {
      $this->set('selectid', $_GET['id']);
    }

    if ($this->request->session()->read('paydatef')) {

      $paydatef = $this->request->session()->read('paydatef');
      $ids2s = $this->request->session()->read('reciptnof');
      $this->set('paydatef', $paydatef);
      if ($ids2s != '0') {
        $reciptnof = $ids2s + 1;
        $this->set('reciptnof', $reciptnof);
      }
    }


    $discount_fees = $stdntddf->dis_fees;
    $dis_hostel = $stdntddf->dis_hostel;
    $dis_transport = $stdntddf->dis_transport;
    $classid = $stdntddf->class_id;

    $personalduefees = $this->Previousduefees->find('all')->where(['Previousduefees.student_id' => $id])->first();
    $Sitesettings = $this->Sitesettings->find('all')->where(['Sitesettings.print' => '1'])->first();
    $Is_special = $this->Sitesettings->find('all')->first();
    $this->set('Is_special', $Is_special);
    $this->set('Sitesettings', $Sitesettings);
    $this->set('personalduefees', $personalduefees);

    if (!empty($discount_fees)) {
      $this->set('discount_fees', $discount_fees);
    } else {
      $discount_fees = '0';
      $this->set('discount_fees', $discount_fees);
    }
    if (!empty($dis_hostel)) {
      $this->set('dis_hostel', $dis_hostel);
    } else {
      $dis_hostel = '0';
      $this->set('dis_hostel', $dis_hostel);
    }
    if (!empty($dis_transport)) {
      $this->set('dis_transport', $dis_transport);
    } else {
      $dis_transport = '0';
      $this->set('dis_transport', $dis_transport);
    }

    $fathernamefffg = $stdntddf['fathername'];
    $mothernamefffg = $stdntddf['mothername'];

    $student_dataftf = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.fathername' => $fathernamefffg, 'Students.mothername' => $mothernamefffg, 'Students.id NOT IN' => $id, 'Students.status' => 'Y'])->toarray();
    $this->set('student_dataftf', $student_dataftf);

    $completeFeesheads = $this->Feesheads->find('list', [
      'keyField' => 'id',
      'valueField' => 'name',
    ])->where(['status' => 'Y'])->order(['id' => 'ASC'])->toArray();
    $this->set('completeFeesheads', $completeFeesheads);

    $classes = $this->Classections->find('list', [
      'keyField' => 'Classes.id',
      'valueField' => 'Classes.title',
    ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.id' => 'ASC'])->toArray();
    // pr($classes);exit;
    $this->set('classes', $classes);

    $totalSections = $this->Classections->find('all')->where(['class_id' => $stdntddf['class_id']])->count();
    $this->set('totalSections', $totalSections);
    // pr($totalSections); die;

    $banks = $this->Banks->find('list', [
      'keyField' => 'id',
      'valueField' => 'name'
    ])->where(['Banks.status' => 'Y'])->order(['Banks.id' => 'asc'])->toArray();

    $this->set('banks', $banks);

    $rolepresent = $this->request->session()->read('Auth.User.role_id');
    $this->set('rolepresent', $rolepresent);



    if ($rolepresent == 1 || $rolepresent == 6 || $rolepresent == 105 || $rolepresent == 5) {

      $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id])->first();

      if (empty($student_data)) {
        $student_data = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where(['DropOutStudent.s_id' => $id])->first();
      }
      $this->set('students', $student_data);

      $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

      $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

      if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
        $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
      }

      $student_datasmaxssss = $this->Studentfees->find('all')->contain(['Students'])->select(['cheque_no', 'ref_no', 'bank'])->where(['Students.status' => 'Y'])->order(['Studentfees.id DESC'])->first();

      $this->set('student_datasmaxssss', $student_datasmaxssss['cheque_no']);
      $this->set('student_datasmref_no', $student_datasmaxssss['ref_no']);
      $this->set('student_databank', $student_datasmaxssss['bank']);
      $c = $student_datasmaxss['amount'];
    }


    $student_datasm = $c + 1;
    $this->set('student_datasm', $student_datasm);
    $is_transport = $student_data['is_transport'];
    $is_hostel = $student_data['is_hostel'];
    $hostal_id = $student_data['h_id'];
    $this->set('is_transport', $is_transport);
    $this->set('is_hostel', $is_hostel);
    $this->set('hostal_id', $hostal_id);
    $this->set('id', $id);

    $studentold = $this->Students->find('all')->where(['Students.id' => $id, 'Students.acedmicyear' => $academic_year])->first();
    $oldenrool = $studentold['oldenroll'];
    $studentolds = $this->Students->find('all')->where(['Students.enroll' => $oldenrool, 'Students.acedmicyear' => $academic_year])->first();
    $oldenrool = $studentold['oldenroll'];
    $oldenrools = $studentolds['id'];

    if ($oldenrool && $oldenrools) {
      $studsentold = $this->Students->find('all')->where(['Students.enroll' => $oldenrool])->first();
      $ols = $studsentold['id'];

      $student_datas3s = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.acedmicyear' => $academic_year])->toarray();

      $student_datas31s = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.acedmicyear !=' => $academic_year])->toarray();

      foreach ($student_datas31s as $kss => $valuess) {
        $quaswr[] = unserialize($valuess['quarter']);
      }

      $quafljr = array();

      foreach ($quaswr as $hljr => $valeljr) {

        $quafljr = array_merge($quafljr, $valeljr);
      }
      $rtljr = array();
      foreach ($quafljr as $jljr => $tljr) {
        if ($jljr == "Admission Fee" || $jljr == "Development Fee" || $jljr == "Caution Money") {
          $quarsgh[] = $jljr;
        }
      }


      $this->set('quarsgh', $quarsgh);
      $this->set('studentfees2s', $student_datas3s);

      $studentsacedemics = $this->Studentshistory->find('all')->where(['Studentshistory.stud_id' => $id, 'Studentshistory.status' => 'Y'])->group(['Studentshistory.acedmicyear'])->toarray();
      foreach ($studentsacedemics as $ktt => $itt) {
        $aced[] = $itt['acedmicyear'];
      }

      if (!empty($aced)) {
        $student_datas1 = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ols, 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear IN' => $aced, 'Studentfees.status' => 'Y'])->toarray();
        $this->set('studentfees1', $student_datas1);
      }
    }

    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->toarray();
    $student_datas2 = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->toarray();
    $this->set('studentfees', $student_datas);
    $this->set('studentfees2', $student_datas2);

    $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
    if ($id == 4692) {
      $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
    }
    $this->set('studentfeesk', $student_datask);

    $student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $id, 'Studentfeepending.status' => 'N'])->toarray();
    $this->set('student_feepending', $student_feepending);


    $student_hostal = $this->StudentHostalfees->find('all')->where(['StudentHostalfees.student_id' => $id, 'StudentHostalfees.student_id' => $id])->toarray();
    $this->set('studenthostalfee', $student_hostal);

    $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.fee_h_id')->where(['Classfee.fee_h_id IN' => [2, 6], 'Classfee.academic_year' => $stdntddf['batch'], 'Classfee.class_id' => $student_data['class_id']])->order(['Classfee.fee_h_id' => 'ASC'])->select([
      'qu1_fees' => 'Classfee.qu1_fees',
      'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'),
      'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'),
      'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'),
      'Classes.title',
      'Classfee.academic_year',
      'Classfee.id',
      'Classfee.status',
      'Classfee.class_id',
    ])->toarray();
    $this->set('classfee', $classfee);

    $sfee = $this->Classfee->find('all')->contain(['Classes', 'Feesheads'])->where(['Classfee.academic_year' => $stdntddf['batch'], 'Classfee.class_id' => $student_data['class_id'], 'Feesheads.type IN' => ['2']])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
    $this->set('preclassfee', $sfee);
  }






  public function is_transport($student_id = null)
  {
    $sid = $student_id;
    $admin_data = $this->Users->find()->where(['role_id' => 1])->first();
    $academic_year = $admin_data['academic_year'];
    $this->set(compact('academic_year'));

    // In Session data write 
    $session = $this->request->session();
    $session->write('student_id', $sid); //Write
    $session->write('student_accademic', $academic_year); //Write

    $locations = $this->Locations->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Locations.status' => 'Y'])->order(['name' => 'ASC'])->toArray();

    $route = $this->Transports->find('list', ['keyField' => 'vechical_no', 'valueField' => 'vechical_no'])->where(['Transports.status' => 'Y'])->toArray();

    $this->set('route', $route);
    $this->set('sid', $sid);

    if (!empty($sid)) {
      $student_data = $this->Students->find('all')->where(['Students.id' => $student_id])->first();
    }

    $this->set('locations', $locations);

    if ($this->request->is(['post', 'put'])) {

      // pr($this->request->data);

      $student_id = $this->request->data['student_id'];
      $location_id = $this->request->data['location'];
      $busid = $this->request->data['busid'];
      $student_data = $this->Students->find('all')->where(['Students.id' => $student_id])->first();
      // pr($student_data);die;

      if ($student_data['location_id'] == '') {

        $transports_details = $this->Transports->find('all')->where(['Transports.vechical_no' => $busid])->first();

        $totalstrenght = $transports_details['strength'];
        $totaloccupations = $transports_details['occupation'];

        if ($totalstrenght == $totaloccupations) {

          $this->Flash->error(__('Bus Strength has full Please allocate new Vechical for this location then add Student !.'));
          return $this->redirect(['action' => 'view']);
        } else {

          $dataupdate['occupation'] = $totaloccupations + 1;
          // pr($dataupdate);die;
          $update = $this->Transports->patchEntity($transports_details, $dataupdate);
          $this->Transports->save($update);

          // $transportfees = $this->Transportstudentlist->newEntity();
          // $studenlistdata['student_id'] = $sid;
          // $studenlistdata['location_id'] = $location_id;
          // $studenlistdata['location_name'] = 'Testing';
          // $studenlistdata['bus_number'] = $busid;
          // $studenlistdata['academic_year'] = $student_data['acedmicyear'];      

          // $studentlistupdate = $this->Transportstudentlist->patchEntity($transportfees, $studenlistdata);
          // pr($studentlistupdate);die;          

          // $this->Transportstudentlist->save($studentlistupdate);   

        }
      }

      $st_data['location_id'] = $location_id;
      $st_data['bus_number'] = $busid;
      $updatedata = $this->Students->patchEntity($student_data, $st_data);
      $this->Students->save($updatedata);

      $this->Flash->success(__('Student has been Added successfully in Transport.'));
      return $this->redirect(['action' => 'view']);
    }
    $this->set('student_data', $student_data);
  }

  public function is_droptrans($student_id = null, $acedmicyear = null)
  {
    // pr($acedmicyear);die;
    $sid = $student_id;
    $acedmicyear = $acedmicyear;
    $this->set('sid', $sid);
    $this->set('acedmicyear', $acedmicyear);

    if ($this->request->is(['post', 'put'])) {

      // pr($this->request->data);exit;
      $session = $this->request->session();
      $studentId = $this->request->data['student_id'];
      $academicYear = $this->request->data['academic_year'];

      // In Session data write 
      $session->write('student_id', $studentId); //Write
      $session->write('student_accademic', $academicYear); //Write

      // Find the student by ID and academic year
      $student = $this->Students->find('all')->where(['id' => $studentId, 'acedmicyear' => $academicYear])->first();

      if ($student) {

        $student->is_transport = null;
        $student->location_id = null;
        $student->bus_number = null;
        $reason = $this->request->data['reason'];
        $currentTime = date('Y-m-d H:i:s');
        $reasonWithDateTime = "$reason (On: $currentTime)";
        $student->reason = $reasonWithDateTime;
        // pr($student);exit;

        if ($this->Students->save($student)) {
          $this->Flash->success(__('The student has been successfully removed from transport with the given reason.'));
        } else {
          $this->Flash->error(__('Failed to update the student\'s record. Please try again.'));
        }
      } else {
        $this->Flash->error(__('Student not found with the provided ID and academic year.'));
      }

      // $this->Students->save($student);

      // $transports_details = $this->Transports->find('all')->where(['Transports.vechical_no' => $student['bus_number']])->first();
      // $transports_details['occupation'] = $transports_details['occupation'] - 1;
      // $this->Transports->save($transports_details);
      return $this->redirect(['action' => 'view']);
    }
  }

  public function find_bus()
  {

    $loc_id = $this->request->data['id'];
    $route = $this->Routemaster->find('all')->where(['Routemaster.status' => 'Y'])->toArray();
    foreach ($route as $key => $value) {
      $location = explode(",", $value['location_id']);
      if (in_array($loc_id, $location)) {
        $routeid[] = $value['id'];
      }
    }
    if (!empty($routeid)) {
      // foreach ($routeid as $route_id) {
      $transport = $this->Transports->find('all')->where(['route IN' => $routeid, 'status' => 'Y'])->toArray();
    }
    if (empty($transport[0])) {
      echo '<option value="">---Select Bus---</option>';
    } else {
      echo '<option value="">---Select Bus---</option>';
    }

    foreach ($transport as $key => $transport_name) {

      if (!empty($transport_name['id'])) {
        echo '<option value="' . $transport_name['vechical_no'] . '">' . $transport_name['vechical_no'] . '-' . '(' . ucwords($transport_name['driver_name']) . ')' . '</option>';
      }
    }
    die;
  }

  public function find_fees()
  {
    $loc_id = $this->request->data['id'];
    $session = $this->request->data['session'];
    // pr($session);exit;

    $transportfees = $this->Transportfees->find('all')->where(['loc_id' => $loc_id, 'academic_year' => $session])->first();

    // pr($transportfees);die;

    $datas['quarter1'] = $transportfees['quarter1'];
    $datas['quarter2'] = $transportfees['quarter2'];
    $datas['quarter3'] = $transportfees['quarter3'];
    $datas['quarter4'] = $transportfees['quarter4'];

    echo json_encode($datas);
    die;

    // echo $transportfees['quarterly_fee'];die;
  }


  public function searchfeeack()
  {

    //show all data in listing page
    //connection
    $conn = ConnectionManager::get('default');
    $user = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
    $year = $user['academic_year'];

    $class = $this->request->data['class_id'];
    $admission = $this->request->data['admissionyear'];
    $section = $this->request->data['section_id'];
    $enroll = $this->request->data['enroll'];
    $fname = $this->request->data['fname'];

    $detail = "SELECT Students.id,Students.enroll,Students.fathername,Students.h_id,Students.fname,Students.middlename,Students.lname,Students.mobile,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id    WHERE  1=1 ";

    $cond = ' ';
    if (!empty($year)) {

      $cond .= " AND Students.acedmicyear LIKE '" . $year . "%' ";
    }

    if (!empty($class)) {

      $cond .= " AND Students.class_id LIKE '" . $class . "' ";
    }

    if (!empty($section)) {

      $cond .= " AND Students.section_id LIKE '" . $section . "' ";
    }

    if (!empty($enroll)) {

      $cond .= " AND Students.enroll LIKE '" . $enroll . "%' ";
    }
    $rolepresent = $this->request->session()->read('Auth.User.role_id');
    if ($rolepresent == '5') {
      $cond .= " AND Students.board_id LIKE '1'";
    } else if ($rolepresent == '8') {

      $cond .= " AND Students.board_id IN (2,3)";
    }
    if (!empty($fname)) {

      $cond .= " AND UPPER(Students.fname) LIKE '" . strtoupper($fname) . "%' ";
    }
    $cond .= " AND Students.status='Y'";
    $detail = $detail . $cond;
    $SQL = $detail . " ORDER BY Students.id ASC";

    $results = $conn->execute($SQL)->fetchAll('assoc');

    $this->set('students', $results);
  }

  public function edit($id = null)
  {
    $this->viewBuilder()->layout('admin');

    $subjectclasses_data = $this->Subjectclass->find('list', [
      'keyField' => 'Classes.id',
      'valueField' => 'Classes.title',
    ])->contain(['Classes'])->order(['Classes.id' => 'ASC'])->toarray();
    //$this->paginate($service_data);
    $this->set('classlist', $subjectclasses_data);
    $subjectclasses_data = $this->Classfee->find('all')->where(['id' => $id])->first()->toarray();
    $classid = $subjectclasses_data['class_id'];
    $academic_year = $subjectclasses_data['academic_year'];
    //$this->paginate($service_data);
    $alldata = $this->Classfee->find('all')->contain(['Feesheads'])->where(['class_id' => $classid, 'academic_year' => $academic_year])->toarray();

    $this->set('alldata', $alldata);

    $feesheads = $this->Feesheads->find('all')->order(['id' => 'ASC'])->toarray();
    $this->set('feesheads', $feesheads);
    $this->set('id', $id);

    if ($this->request->is(['post', 'put'])) {

      $conn = ConnectionManager::get('default');
      $academic_year = $this->request->data['academic_year'];

      $conn->execute("DELETE FROM class_fee_allocations WHERE academic_year='" . $academic_year . "' AND class_id='" . $this->request->data['class_id'] . "'");

      $peopleTable = TableRegistry::get('Classfee');
      $oQuery = $peopleTable->query();
      $romm = sizeof($this->request->data['qu1_fees']);

      for ($i = 0; $i < $romm; $i++) {
        $oQuery->insert(['class_id', 'academic_year', 'fee_h_id', 'qu1_fees', 'qu2_fees', 'qu3_fees', 'qu4_fees', 'status'])
          ->values([
            'class_id' => $this->request->data['class_id'],
            'academic_year' => $this->request->data['academic_year'],
            'fee_h_id' => $this->request->data['fee_h_id'][$i],
            'qu1_fees' => $this->request->data['qu1_fees'][$i],
            'qu2_fees' => $this->request->data['qu2_fees'][$i],
            'qu3_fees' => $this->request->data['qu3_fees'][$i],
            'qu4_fees' => $this->request->data['qu4_fees'][$i],
            'status' => 'Y'
          ]);
      }

      $d = $oQuery->execute();
      if ($d) {
        $this->Flash->success(__('Class Fee  has been updated Sucessfully.'));
        return $this->redirect(['action' => 'index']);
      } else {

        $this->Flash->success(__('Class Fee  not updated.'));
        return $this->redirect(['action' => 'index']);
      }
    }
  }

  public function finelate()
  {

    $invoicedate = $this->request->data['pos'];
    $role_id = $this->request->session()->read('Auth.User.role_id');

    $userfind = $this->Users->find('all')->where(['role_id' => $role_id])->first();

    $latess = $userfind['latefee'];
    //$invoicedate = strtotime("2018/04/10");
    $TodayDate = strtotime('today');
    if ($TodayDate > $invoicedate && $invoicedate != '0') {
      $timeDiff = abs($TodayDate - $invoicedate);

      $numberDays = $timeDiff / 86400; // 86400 seconds in one day

      $numberDays = intval($numberDays);

      $Interval = $numberDays;
      $Fees = 0;
      for ($i = 1; $i <= $Interval; $i++) {
        $late = $latess;
        $Fees += $late;
      }

      $Fees = number_format($Fees, 2, '.', '');
      echo $Fees;
      die;
      //echo "0"; die;
    } else {

      echo "0";
      die;
    }
  }

  public function finddiscount()
  {

    $ffheads = $this->request->data['ffheads'];
    $amount = $this->request->data['amty'];

    $sevalue = $this->request->data['sevalue'];

    $classes_data = $this->DiscountCategory->find('all')->where(['id' => $sevalue])->order(['id' => 'ASC'])->first();
    $quas = unserialize($classes_data['fh_id']);
    $discounts = '0';
    if ($classes_data['discount'] == '0') {

      foreach ($quas as $j => $t) {

        if ($j == $ffheads) {
          $discounts += $amount / 100 * $t;
        }
      }
    } else if ($classes_data['fh_id'] != '0' && $classes_data['discount'] != '0') {

      foreach ($quas as $j => $t) {

        if ($j == $ffheads) {
          $discounts += $amount / 100 * $t;
        }
      }

      $quasdiscount = unserialize($classes_data['discount']);

      foreach ($quasdiscount as $j => $td) {

        if ($j == $ffheads) {
          $discounts += $td;
        }
      }
    } else {

      $quasdiscount = unserialize($classes_data['discount']);

      foreach ($quasdiscount as $j => $td) {

        if ($j == $ffheads) {
          $discounts += $td;
        }
      }
    }
    echo floor($discounts);
    die;
  }

  public function findotherfees()
  {

    $opt = $this->request->data['opt'];
    $boardst = $this->request->data['boardst'];
    $feesheads = $this->Feesheads->find('all')->where(['id' => $opt])->order(['id' => 'ASC'])->first();
    // pr($feesheads);die;
    if ($boardst == '1') {
      $fee = $feesheads['cbse_fee'];
    } else if ($boardst == '2') {
      $fee = $feesheads['cambridge_fee'];
    } else if ($boardst == '3') {
      $fee = $feesheads['ibdp_fee'];
    }

    if ($fee) {
      $Fees = number_format($fee, 2, '.', '');
      echo $Fees;
      die;
    } else {
      echo "0";
      die;
    }
  }

  public function chequerejected($fees_id, $academic_year, $remarks)
  {

    $id = $fees_id;
    $acedmicyear = $academic_year;
    $remarsks = $remarks;
    if ($id != '') {

      $studentfeepending = $this->Studentfees->find('all')->where(['Studentfees.id' => $id, 'Studentfees.acedmicyear' => $acedmicyear])->first();
      $recipetnoss = $studentfeepending['recipetno'];
      $studid = $studentfeepending['student_id'];
      $quarter = $studentfeepending['quarter'];

      $aee = unserialize($quarter);

      foreach ($aee as $kru => $amtr) {

        $kru = str_replace('"', "", $kru);

        if (ctype_digit($kru) == '1') {

          $studentfeependings = $this->Studentfeepending->find('all')->where(['r_id' => $kru, 'amt LIKE' => $amtr . "%"])->first();
          $srid = $studentfeependings['id'];

          if ($srid) {
            $conn = ConnectionManager::get('default');

            $conn->execute("UPDATE `studentfee_pending` SET `status`='N'  WHERE id='" . $srid . "' AND amt LIKE '" . $amtr . "%' AND s_id='" . $studid . "' AND r_id='" . $kru . "'");
          }
        }
      }

      $conn = ConnectionManager::get('default');
      $conn->execute("DELETE FROM `studentfee_pending` WHERE r_id='" . $id . "'");

      $stcau = $this->Studentfees->find('all')->where(['Studentfees.quarter' => 'a:1:{s:13:"Caution Money";s:1:"0";}', 'Studentfees.deposite_amt' => '0', 'Studentfees.status' => 'Y'])->first();

      if ($stcau['id']) {
        $stii = $stcau['student_id'];
        $conn = ConnectionManager::get('default');
        $conn->execute("UPDATE `student_feeallocations` SET `status`='N', `remarks`='" . $remarsks . "'  WHERE id='" . $stcau['id'] . "' AND  acedmicyear='" . $acedmicyear . "' AND recipetno='" . $recipetnoss . "' AND student_id='" . $stii . "'");
      }

      $conn = ConnectionManager::get('default');
      $conn->execute("UPDATE `student_feeallocations` SET `status`='N', `remarks`='" . $remarsks . "'  WHERE id='" . $id . "' AND  acedmicyear='" . $acedmicyear . "' AND student_id='" . $studid . "'");
      return;
    }
  }

  // public function cancelledstudent()
  // {
  //   if ($this->request->is(['post', 'put'])) {
  //     // pr($this->request->data);exit;
  //     $id = $this->request->data['id'];
  //     $acedmicyear = $this->request->data['academicyear'];
  //     $remarsks = $this->request->data['remarks'];

  //     if ($id != '') {
  //       $studentfeepending = $this->Studentfees->find('all')->where(['Studentfees.id' => $id])->first();
  //       $recipetnoss = $studentfeepending['recipetno'];
  //       $studid = $studentfeepending['student_id'];
  //       $quarter = $studentfeepending['quarter'];
  //       $qtr_name = $studentfeepending['quarter_name'];
  //       // In Session data write 
  //       $session = $this->request->session();
  //       $session->write('student_id', $studid); //Write
  //       $session->write('student_accademic', $acedmicyear); //Write
  //       $aee = unserialize($quarter);


  //       foreach ($aee as $kru => $amtr) {
  //         $kru = str_replace('"', "", $kru);
  //         if (ctype_digit($kru) == '1') {

  //           $studentfeependings = $this->Studentfeepending->find('all')->where(['r_id' => $kru, 's_id' => $studid])->first();
  //           $srid = $studentfeependings['id'];
  //           if ($srid) {
  //             $conn = ConnectionManager::get('default');
  //             $conn->execute("UPDATE `studentfee_pending` SET `status`='N'  WHERE s_id='" . $studid . "' AND r_id='" . $kru . "'");
  //           }
  //         }

  //         if ($kru == $qtr_name) {
  //           $conn = ConnectionManager::get('default');
  //           $conn->execute("UPDATE `student_feeallocations` SET `status`='N', `remarks`='" . $remarsks . "'  WHERE  student_id='" . $studid . "' AND quarter_name='" . $qtr_name . "'");

  //           $connss = ConnectionManager::get('default');
  //           $connss->execute("UPDATE `studentfee_pending` SET `status`='Y'  WHERE s_id='" . $studid . "'");
  //         } else {
  //           $conn = ConnectionManager::get('default');
  //           $conn->execute("UPDATE `student_feeallocations` SET `status`='N', `remarks`='" . $remarsks . "'  WHERE  student_id='" . $studid .  "' AND  recipetno='" . $recipetnoss . "'");
  //         }
  //       }

  //       $conn = ConnectionManager::get('default');
  //       $conn->execute("DELETE FROM `studentfee_pending` WHERE r_id='" . $id . "'");

  //       $stcau = $this->Studentfees->find('all')->where(['Studentfees.quarter' => 'a:1:{s:13:"Caution Money";s:1:"0";}', 'Studentfees.deposite_amt' => '0', 'Studentfees.status' => 'Y'])->first();

  //       if ($stcau['id']) {
  //         $stii = $stcau['student_id'];
  //         $conn = ConnectionManager::get('default');
  //         $conn->execute("UPDATE `student_feeallocations` SET `status`='N', `remarks`='" . $remarsks . "'  WHERE id='" . $stcau['id'] . "' AND  recipetno='" . $recipetnoss . "' AND student_id='" . $stii . "'");
  //       }

  //       if (array_key_exists('Previous Year Due', $aee)) {
  //         $getpreDue = $aee['Previous Year Due'];
  //         $students = $this->Students->get($studentfeepending['student_id']);
  //         $stData['due_fees'] = $getpreDue;
  //         $students = $this->Students->patchEntity($students, $stData);
  //         $result = $this->Students->save($students);
  //       }

  //       $this->Flash->success(__('Student Fee Cancelled Sucessfully!!'));
  //       return $this->redirect(['action' => 'view/']);
  //     }
  //   }
  // }




  // for receipt cancel code refine by Rajesh kumar 22-07-2024
  public function cancelledstudent()
  {
    if ($this->request->is(['post', 'put'])) {
      $id = $this->request->data['id'];
      $acedmicyear = $this->request->data['academicyear'];
      $remarsks = $this->request->data['remarks'];

      if ($id != '') {
        $studentfeepending = $this->Studentfees->find('all')->where(['Studentfees.id' => $id])->first();
        $studid = $studentfeepending['student_id'];
        $quarter = $studentfeepending['quarter'];
        $aee = unserialize($quarter);

        // In Session data write 
        $session = $this->request->session();
        $session->write('student_id', $studid);
        $session->write('student_accademic', $acedmicyear);


        // current receipt for cancel(N)
        $conn = ConnectionManager::get('default');
        $conn->execute("UPDATE `student_feeallocations` SET `status`='N', `remarks`='" . $remarsks . "'  WHERE id='" . $id . "'");

        // current pending receipt for deleting in pending table
        $conn = ConnectionManager::get('default');
        $conn->execute("DELETE FROM `studentfee_pending` WHERE r_id='" . $id . "'");


        foreach ($aee as $kru => $amtr) {
          // for pending fee receipt deposite
          $kru = str_replace('"', "", $kru);
          if (ctype_digit($kru) == '1') {
            // previous recipt of current receipt for activate(N) in pending table
            $studentfeependings2 = $this->Studentfeepending->find('all')->where(['r_id' => $kru, 's_id' => $studid])->first();
            $srid2 = $studentfeependings2['id'];
            if ($srid2) {
              $conn = ConnectionManager::get('default');
              $conn->execute("UPDATE `studentfee_pending` SET `status`='N'  WHERE id='" . $srid2 . "'");
            }
          }
        }


        if (array_key_exists('Previous Year Due', $aee)) {
          $getpreDue = $aee['Previous Year Due'];
          $students = $this->Students->get($studentfeepending['student_id']);
          $stData['due_fees'] = $getpreDue;
          $students = $this->Students->patchEntity($students, $stData);
          $result = $this->Students->save($students);
        }

        $this->Flash->success(__('Student Fee Cancelled Sucessfully!!'));
        return $this->redirect(['action' => 'view/']);
      }
    }
  }
  public function add($id = null, $acedmicyear = null)
  {
    $this->viewBuilder()->layout('admin');
    $user_id = $this->request->session()->read('Auth.User.id');
    $rolepresent = $this->request->session()->read('Auth.User.role_id');
    // pr($rolepresent);exit;

    if ($this->request->is(['post', 'put'])) {
      // pr($this->request->data);exit;

      $quarter_name = '';
      $this->request->data['deposited_by'] = $user_id;
      $student_id = $this->request->data['student_id'];
      $acedmicyear = $this->request->data['acedmicyear'];
      $reqAmount = $this->request->data['amount'];
      $reqAmounts = $this->request->data['amounts'];
      $is_special = $this->request->data['is_special'];

      $commaSeparatedString = !empty($this->request->data['forpreviouseyear']) ? implode(', ', $this->request->data['forpreviouseyear']) : null;

      // to check atleast one fees head deposite
      if ($reqAmount[0] == 0 && $reqAmounts[0] == 0) {
        if ($is_special == 1) {
        } else {
          $this->Flash->error(__("Please choose at least one fees head"));
          return $this->redirect(['action' => 'view/' . $student_id]);
        }
      }

      // In Session data write 
      $session = $this->request->session();
      $session->write('student_id', $student_id); //Write
      $session->write('student_accademic', $acedmicyear); //Write


      // To check student exist or not 
      $students_enroll_check = $this->Students->find('all')->where(['Students.id' => $student_id])->first();
      $this->request->data['board_id'] = $students_enroll_check['board_id'];
      if ($students_enroll_check['enroll'] == '') {

        if ($this->request->data['mode'] == "CHEQUE") {
          $det = $this->Students->get($student_id);
          $enroll_data['cheque_status'] = '';
          $enroll_data['feesmode'] = 'CHEQUE';
          $enroll_data['enroll'] = '';
          $entity = $this->Students->patchEntity($det, $enroll_data);
          $this->Students->save($entity);
        } else {
          $studentsid = $this->Students->find('all')->select(['id', 'enroll', 'fname'])->order(['enroll' => 'DESC'])->first();
          $number = trim($studentsid['enroll']);
          $addst = $number + 1;
          $stdent = $addst;
          $det = $this->Students->get($student_id);
          $enroll_data['feesmode'] = $this->request->data['mode'];
          $enroll_data['enroll'] = $stdent;
          $entity = $this->Students->patchEntity($det, $enroll_data);
          $this->Students->save($entity);
        }
      }


      $userTable2 = TableRegistry::get('Studentfees');
      $exists2 = $userTable2->exists(['token' => $this->request->data['token'], 'student_id' => $this->request->data['student_id']]);

      if ($exists2) {
        $this->redirect(['controller' => 'Studentfees', 'action' => 'index/' . $student_id . '/' . $acedmicyear]);
      } else {

        if (
          $rolepresent == ADMIN ||
          $rolepresent == BRANCH_HEAD ||
          $rolepresent == CENTER_COORDINATOR ||
          $rolepresent == CBSE_FEE_COORDINATOR
        ) {
          // Fetch last receipt number for enrolled students
          $student_datasmaxss = $this->Studentfees->find()
            ->contain(['Students'])
            ->select(['amount' => 'Studentfees.recipetno'])
            ->where([
              'Studentfees.recipetno !=' => '0',
              'Studentfees.board_id' => $students_enroll_check->board_id
            ])
            ->order(['Studentfees.recipetno' => 'DESC'])
            ->first();

          // Fetch last receipt number for dropout students
          $student_datasmaxsseeer = $this->Studentfees->find()
            ->contain(['DropOutStudent'])
            ->select(['amount' => 'Studentfees.recipetno'])
            ->where([
              'DropOutStudent.board_id' => 1,
              'Studentfees.recipetno !=' => '0'
            ])
            ->order(['Studentfees.recipetno' => 'DESC'])
            ->first();

          // Get the higher receipt number between enrolled and dropout students
          $receipt1 = !empty($student_datasmaxss['amount']) ? $student_datasmaxss['amount'] : 0;
          $receipt2 = !empty($student_datasmaxsseeer['amount']) ? $student_datasmaxsseeer['amount'] : 0;

          $lastrecipetno = max($receipt1, $receipt2);
        } else {
          // Handle non-authorized roles
          $this->Flash->error(__('You are not authorized to deposite fee.'));
          return $this->redirect($this->referer());
        }

        if ($this->request->data['recipetno'] != '0') {
          if ($is_special == 1) {
            $this->request->data['recipetno'] = 0;
          } else {
            $this->request->data['recipetno'] = $lastrecipetno + 1;
          }
        }


        if ($this->request->data['fee']) {
          $this->request->data['fee'] = $this->request->data['fee'];
        }

        $peopleTable = TableRegistry::get('Studentfees');
        $oQuery = $peopleTable->query();
        $romm = sizeof($this->request->data['quater']);

        if ($this->request->data['cheque_no'] == "") {
          $this->request->data['cheque_no'] = '0';
        }
        if ($this->request->data['ref_no'] == "") {
          $this->request->data['ref_no'] = '0';
        }
        if ($this->request->data['bank_id'] == "") {
          $this->request->data['bank_id'] = '';
        }
        if ($this->request->data['addtionaldiscount'] == "") {
          $this->request->data['addtionaldiscount'] = '';
        }
        if ($this->request->data['deposite_amt'] == "") {
          $this->request->data['deposite_amt'] = '';
        }
        if ($this->request->data['lfine'] == "") {
          $this->request->data['lfine'] = '0.00';
        }

        $student_data = $this->Students->find('all')->where(['Students.id' => $this->request->data['student_id'], 'Students.status' => 'Y'])->first();
        $this->request->data['payer'] = $student_data['fee_submittedby'];

        $arr = array();
        $arr2 = array();
        $deop = 0;
        $studid = $this->request->data['student_id'];
        $acedmicyear = $this->request->data['acedmicyear'];

        foreach ($this->request->data['quater'] as $k => $try) {
          if ($try != '') {
            $trys = $this->request->data['amount'][$k] ?? '';
            // if ($is_special !== 1 && $trys == 0) {
            // }
            if ($is_special == 1) {
            } else {
              if ($trys == 0) {
                continue;
              }
            }

            if ($trys != '') {
              $sss = ctype_digit($try);
              if ($try == "Collage Caution Money (Refundable)" || $try == "Hostel Caution Money") {
                $arr2[$try] = round($trys);
                $quarter_name = 'Collage Caution Money (Refundable)';
                $amat = round($trys);
              } else if ($sss == '1') {
                $studentfeepending = $this->Feesheads->find('all')->where(['Feesheads.id' => $try])->first();
                $name = $studentfeepending['name'];

                if ($try == "57") {
                  $isUpdateDue = 'Y';
                  $depo_amt = $trys;
                  $students = $this->Students->find('all')->where(['Students.id' => $studid])->select(['due_fees', 'fname', 'id'])->first();
                  if ($students['due_fees'] !== NULL && $students['due_fees'] !== 0) {
                    if ($students['due_fees'] < $trys) {
                      $this->Flash->error(__("Deposited amount doesn't greater than due fee amount Kindly Try Again!!"));
                      return $this->redirect(['action' => 'view/' . $studid]);
                    }
                  }
                }

                if ($trys == '') {
                  $this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
                  return $this->redirect(['action' => 'view/' . $studid]);
                }

                $arr[$name] = round($trys);
              } else {
                if ($trys == '') {
                  $this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
                  return $this->redirect(['action' => 'view/' . $studid]);
                }

                $arr[$try] = round($trys);
              }
            }
          }
        }

        // pr($this->request->data);
        // die;
        // $quarter_name = '';

        // for pending amount
        foreach ($this->request->data['pendid'] as $kk => $tryk) {

          foreach ($this->request->data['amounts'] as $ksk => $trysk) {
            if ($kk == $ksk) {
              $tryk = '"' . $this->request->data['refrencepending'][$ksk] . '"';
              $arr[$tryk] = round($trysk);

              $conn = ConnectionManager::get('default');
              $conn->execute("UPDATE `studentfee_pending` SET `status`='Y'  WHERE id='" . $this->request->data['pendid'][$kk] . "' AND amt='" . $this->request->data['amounts'][$ksk] . "' AND s_id='" . $studid . "'");
              $d = $oQuery->execute();

              $findquarterName = $this->Studentfees->find('all')->select(['quarter_name' => 'Studentfees.quarter_name'])->where(['Studentfees.id ' => $this->request->data['refrencepending'][$ksk]])->order(['Studentfees.recipetno DESC'])->first();
              if ($findquarterName['quarter_name'] != '' && !empty($findquarterName['quarter_name'])) {
                $quarter_name = $findquarterName['quarter_name'];
              }
            }
          }
        }


        // pr($quarter_name);
        // pr($this->request->data);
        // die;

        if ($this->request->data['formno'] == '') {
          $this->request->data['formno'] = '0';
        }
        $str = serialize($arr);


        if ($this->request->data['paydate'] != '') {

          $this->request->session()->delete('paydatef');
          $this->request->session()->write('paydatef', date('d-m-Y', strtotime($this->request->data['paydate'])));

          if ($this->request->data['recipetno'] != '0') {
            $this->request->session()->delete('reciptnof');
            $this->request->session()->write('reciptnof', $this->request->data['recipetno']);
          }

          if ($deop > 0) {
            $this->request->data['fee'] = $this->request->data['fee'];
            $this->request->data['deposite_amt'] = round($this->request->data['deposite_amt']);
          } else {
            $this->request->data['deposite_amt'] = round($this->request->data['deposite_amt']);
            $this->request->data['fee'] = $this->request->data['fee'];
          }

          if ($this->request->data['fee'] == '0') {
            $this->request->data['fee'] = round($this->request->data['deposite_amt']);
          }

          if (!empty($arr)) {

            if ($this->request->data['mode'] == "CASH") {
              $this->request->data['cheque_no'] = '0';
              $this->request->data['ref_no'] = '0';
              $this->request->data['bank_id'] = '';
            }
            if ($this->request->data['mode'] == "CHEQUE") {
              $this->request->data['ref_no'] = '0';
            }
            if ($this->request->data['mode'] == "DD") {
              $this->request->data['ref_no'] = '0';
            }
            if ($this->request->data['mode'] == "NETBANKING") {
              $this->request->data['cheque_no'] = '0';
              $this->request->data['bank_id'] = '';
            }
            if ($this->request->data['mode'] == "Credit Card/Debit Card/UPI") {
              $this->request->data['cheque_no'] = '0';
              $this->request->data['bank_id'] = '';
            }

            // $quarter_name = '';
            if (in_array('Quater1', $this->request->data['quater'])) {
              $quarter_name = 'Quater1';
            } elseif (in_array('Quater2', $this->request->data['quater'])) {
              $quarter_name = 'Quater2';
            } elseif (in_array('Quater3', $this->request->data['quater'])) {
              $quarter_name = 'Quater3';
            } elseif (in_array('Quater4', $this->request->data['quater'])) {
              $quarter_name = 'Quater4';
            } elseif (in_array('Transport1', $this->request->data['quater'])) {
              $quarter_name = 'Transport1';
            } elseif (in_array('Transport2', $this->request->data['quater'])) {
              $quarter_name = 'Transport2';
            } elseif (in_array('Transport3', $this->request->data['quater'])) {
              $quarter_name = 'Transport3';
            } elseif (in_array('Transport4', $this->request->data['quater'])) {
              $quarter_name = 'Transport4';
            } elseif (in_array('Collage Caution Money (Refundable)', $this->request->data['quater'])) {
              $quarter_name = 'Collage Caution Money (Refundable)';
            } elseif (in_array('13', $this->request->data['quater'])) {
              $quarter_name = 'Hostel Charges ( 2 Beded )';
            } elseif (in_array('14', $this->request->data['quater'])) {
              $quarter_name = 'Hostel Charges ( 3 Beded )';
            } elseif (in_array('57', $this->request->data['quater'])) {
              $quarter_name = 'Previous Year Due';
            }

            $oQuery->insert(['token', 'student_id', 'paydate', 'quarter', 'quarter_name', 'mode', 'formno', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'lfine', 'remarks', 'location_id', 'board_id', 'deposited_by', 'previous_due_heads'])
              ->values([
                'token' => $this->request->data['token'],
                'student_id' => $this->request->data['student_id'],
                'paydate' => date('Y-m-d', strtotime($this->request->data['paydate'])),
                'quarter' => $str,
                'quarter_name' => $quarter_name,
                'mode' => $this->request->data['mode'],
                'formno' => $this->request->data['formno'],
                'recipetno' => $this->request->data['recipetno'],
                'bank' => $this->request->data['bank_id'],
                'cheque_no' => $this->request->data['cheque_no'],
                'addtionaldiscount' => $this->request->data['addtionaldiscount'],
                'deposite_amt' => $this->request->data['deposite_amt'],
                'fee' => $this->request->data['fee'],
                'ref_no' => $this->request->data['ref_no'],
                'discount' => $this->request->data['discount'],
                'status' => 'Y',
                'acedmicyear' => $this->request->data['acedmicyear'],
                'discountcategory' => $this->request->data['discountcategorys'],
                'lfine' => $this->request->data['lfine'],
                'remarks' => $this->request->data['remarks'],
                'location_id' => $student_data['location_id'],
                'board_id' => $this->request->data['board_id'],
                'deposited_by' => $this->request->data['deposited_by'],
                'previous_due_heads' => $commaSeparatedString
              ]);
          }
        }



        $d = $oQuery->execute();
        if ($this->request->data['discountcategorys']) {
          $conffn = ConnectionManager::get('default');
          $conffn->execute("UPDATE `students` SET `discountcategory`='" . $this->request->data['discountcategorys'] . "' WHERE id='" . $this->request->data['student_id'] . "'");
        }

        if ($this->request->data['is_special'] == '1') {
          $conffn = ConnectionManager::get('default');
          $conffn->execute("UPDATE `students` SET `is_special`='Y' WHERE id='" . $this->request->data['student_id'] . "'");
        }
        $peopleTables = TableRegistry::get('Studentfeepending');
        $oQuerys = $peopleTables->query();

        $student_data = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

        $rid = $student_data['id'];
        $rquarterid = $student_data['quarter'];
        $recipetno = $student_data['recipetno'];
        if ($this->request->data['lfine'] != '0.00') {
          $amount = $this->request->data['fee'] + $this->request->data['lfine'];
        } else {
          $amount = $this->request->data['fee'];
        }
        $addtionaldiscount = $this->request->data['addtionaldiscount'];

        if ($addtionaldiscount > 0) {
          $remain = $amount - $addtionaldiscount;
        } else {
          $remain = $amount;
        }

        if ($this->request->data['dueextra'] < 0) {
          $netamounts = $this->request->data['dueextra'];
        } else if ($this->request->data['dueextra'] > 0) {
          $netamounts = $this->request->data['dueextra'];
        } else {
          $netamounts = '0';
        }

        if ($netamounts != '0') {
          $oQuerys->insert(['s_id', 'r_id', 'recipetnos', 'amt', 'status', 'deposited_by'])
            ->values([
              's_id' => $this->request->data['student_id'],
              'r_id' => $rid,
              'recipetnos' => $recipetno,
              'amt' => $netamounts,
              'status' => 'N',
              $this->request->data['deposited_by']
            ]);
        }

        $oQuerys->execute();
        $peopleTableshh = TableRegistry::get('Studentfees');
        $oQueryshh = $peopleTableshh->query();

        if (!empty($arr2)) {
          $str2 = serialize($arr2);
          $oQueryshh->insert(['token', 'student_id', 'paydate', 'quarter', 'quarter_name', 'mode', 'formno', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'remarks', 'board_id', 'deposited_by', 'previous_due_heads'])
            ->values([
              'token' => $this->request->data['token'],
              'student_id' => $this->request->data['student_id'],
              'paydate' => date('Y-m-d', strtotime($this->request->data['paydate'])),
              'quarter' => $str2,
              'quarter_name' => $quarter_name,
              'mode' => $this->request->data['mode'],
              'formno' => $this->request->data['formno'],
              'recipetno' => $this->request->data['recipetno'],
              'bank' => $this->request->data['bank_id'],
              'cheque_no' => $this->request->data['cheque_no'],
              'addtionaldiscount' => '0.00',
              'deposite_amt' => $amat,
              'fee' => $amat,
              'ref_no' => $this->request->data['ref_no'],
              'discount' => '0.00',
              'status' => 'Y',
              'acedmicyear' => $this->request->data['acedmicyear'],
              'discountcategory' => $this->request->data['discountcategorys'],
              'remarks' => $this->request->data['remarks'],
              'board_id' => $this->request->data['board_id'],
              'deposited_by' => $this->request->data['deposited_by'],
              'previous_due_heads' => $commaSeparatedString
            ]);
        }

        $oQueryshh->execute();

        $caution = 'a:1:{s:13:"Caution Money";d:5000;}';

        $student_datacautionmoney = $this->Studentfees->find('all')->where(['Studentfees.quarter LIKE' => $caution, 'Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

        $student_datass = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

        $rids = $student_datass['id'];
        $rquarterids = $student_datass['quarter'];
        //$ridcaution=$student_datacautionmoney['id'];
        $studid = $this->request->data['student_id'];
        $acedmicyear = $this->request->data['acedmicyear'];

        if ($this->request->data['studenthistory']) {
          $studenthistory = $this->request->data['studenthistory'];
        }
        // save all data in database

        if ($d) {
          // update here due amount on student table 
          if ($isUpdateDue == "Y") {
            $students = $this->Students->find('all')->where(['Students.id' => $studid])->select(['due_fees', 'fname', 'id'])->first();
            $remain = floatval($students['due_fees']) - floatval($depo_amt);
            $conn = ConnectionManager::get('default');
            $conn->execute("UPDATE `students` SET `due_fees`='" . $remain . "' WHERE  id='" . $studid . "'");
          }

          if (!empty($this->request->data['pendid'])) {
            $this->rollbacks($studid, $this->request->data['recipetno'], $this->request->data['pendid'], $this->request->data['amounts'], $this->request->data['refrencepending']);
          } else {
            $pen = array();
            $amo = array();
            $refrt = array();
            $this->rollbacks($studid, $this->request->data['recipetno'], $pen, $amo, $refrt);
          }

          if ($this->request->data['recipetno'] != '0') {
            $this->request->data['hdfb'] = '1';
            if ($this->request->data['hdfb'] == '1') {
              if ($rquarterids == 'a:1:{s:13:"Caution Money";d:5000;}') {
                $this->request->session()->delete('openfess_recipt3');
                $this->request->session()->delete('openfess_recipt4');
                $this->request->session()->delete('openfess_recipt5');
                if ($studenthistory) {
                  $this->request->session()->write('openfess_recipt3', 'printscautionhistory');
                } else {
                  $this->request->session()->write('openfess_recipt3', 'printscaution');
                }
                $this->request->session()->write('openfess_recipt4', $rids);
                $this->request->session()->write('openfess_recipt5', $acedmicyear);
                //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
                return $this->redirect(['action' => 'view/' . $studid]);
              } else {
                $this->request->session()->delete('openfess_recipt');
                $this->request->session()->delete('openfess_recipt2');
                $this->request->session()->delete('openfess_recipt5');
                if ($studenthistory) {
                  $this->request->session()->write('openfess_recipt', 'printsadmissionhistory');
                } else {
                  $this->request->session()->write('openfess_recipt', 'printsadmission');
                }
                $this->request->session()->write('openfess_recipt2', $rids);
                $this->request->session()->write('openfess_recipt5', $acedmicyear);
                //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
                return $this->redirect(['action' => 'view/' . $studid]);
              }
            } else {
              //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
              return $this->redirect(['action' => 'view/' . $studid]);
            }
          } else {
            //$this->Flash->success(__('Student Fee  Sucessfully!!'));
            // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
            return $this->redirect(['action' => 'view/' . $studid]);
          }
        } else {
          $this->Flash->error(__('Please Try Again For Submit Fees!!!.'));
          // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
          return $this->redirect(['action' => 'view/' . $studid]);
        }
        $studid = $this->request->data['student_id'];
        $acedmicyear = $this->request->data['acedmicyear'];
        //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
        return $this->redirect(['action' => 'view/' . $studid]);
        //return $this->redirect(['action' => 'view']);
      }
    }

    $this->set('classes', $classes);
  }
















  public function addapi($id = null, $acedmicyear = null)
  {

    $this->viewBuilder()->layout('admin');
    $rolepresent = $this->request->session()->read('Auth.User.role_id');


    if ($this->request->is(['post', 'put'])) {
      // pr($this->request->data);
      // die;
      $this->request->data['deposited_by'] = $rolepresent;
      $student_id = $this->request->data['student_id'];
      $acedmicyear = $this->request->data['acedmicyear'];
      $reqAmount = $this->request->data['amount'];
      $reqAmounts = $this->request->data['amounts'];
      // pr($this->request->data);
      // exit;

      if ($reqAmount[0] == 0 && $reqAmounts[0] == 0) {
        $this->Flash->error(__("Please choose at least one fees head"));
        return $this->redirect(['action' => 'view/' . $studid]);
      }
      // In Session data write 
      $session = $this->request->session();
      $session->write('student_id', $student_id); //Write
      $session->write('student_accademic', $acedmicyear); //Write

      $students_enroll_check = $this->Students->find('all')->where(['Students.id' => $student_id])->first();

      $this->request->data['board_id'] = $students_enroll_check['board_id'];

      if ($students_enroll_check['enroll'] == '') {

        if ($this->request->data['mode'] == "CHEQUE") {
          $det = $this->Students->get($student_id);
          $enroll_data['cheque_status'] = '';
          $enroll_data['feesmode'] = 'CHEQUE';
          $enroll_data['enroll'] = '';
          $entity = $this->Students->patchEntity($det, $enroll_data);
          $this->Students->save($entity);
        } else {
          $studentsid = $this->Students->find('all')->select(['id', 'enroll', 'fname'])->order(['enroll' => 'DESC'])->first();
          $number = trim($studentsid['enroll']);
          $addst = $number + 1;
          $stdent = $addst;
          $det = $this->Students->get($student_id);
          $enroll_data['feesmode'] = $this->request->data['mode'];
          $enroll_data['enroll'] = $stdent;
          $entity = $this->Students->patchEntity($det, $enroll_data);
          $this->Students->save($entity);
        }
      }

      $userTable2 = TableRegistry::get('Studentfees');
      $exists2 = $userTable2->exists(['token' => $this->request->data['token'], 'student_id' => $this->request->data['student_id']]);

      if ($exists2) {
        $this->redirect(['controller' => 'Studentfees', 'action' => 'index/' . $student_id . '/' . $acedmicyear]);
      } else {

        if ($rolepresent == ADMIN || $rolepresent == BRANCH_HEAD || $rolepresent == CENTER_COORDINATOR || $rolepresent == CBSE_FEE_COORDINATOR) {

          // $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
          $student_datasmaxss = $this->Studentfees->find('all')
            ->contain(['Students'])
            ->select(['amount' => 'Studentfees.recipetno'])
            ->where(['Studentfees.recipetno !=' => '0', 'Studentfees.board_id' => $students_enroll_check->board_id])
            ->order(['Studentfees.recipetno DESC'])
            ->first();
          // pr($student_datasmaxss);
          // exit;


          $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

          if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
            $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
          }

          $c = $student_datasmaxss['amount'];
        }
        if ($this->request->data['recipetno'] != '0') {
          $this->request->data['recipetno'] = $c + 1;
        }
        // pr($this->request->data);
        // exit;

        if ($this->request->data['fee']) {
          $this->request->data['fee'] = $this->request->data['fee'];
        }

        $peopleTable = TableRegistry::get('Studentfees');
        $oQuery = $peopleTable->query();
        $romm = sizeof($this->request->data['quater']);
        if ($this->request->data['cheque_no'] == "") {
          $this->request->data['cheque_no'] = '0';
        }

        if ($this->request->data['ref_no'] == "") {
          $this->request->data['ref_no'] = '0';
        }
        if ($this->request->data['bank_id'] == "") {
          $this->request->data['bank_id'] = '';
        }
        if ($this->request->data['addtionaldiscount'] == "") {
          $this->request->data['addtionaldiscount'] = '';
        }
        if ($this->request->data['deposite_amt'] == "") {
          $this->request->data['deposite_amt'] = '';
        }
        if ($this->request->data['lfine'] == "") {
          $this->request->data['lfine'] = '0.00';
        }

        $student_data = $this->Students->find('all')->where(['Students.id' => $this->request->data['student_id'], 'Students.status' => 'Y'])->first();
        $this->request->data['payer'] = $student_data['fee_submittedby'];

        $arr = array();
        $arr2 = array();
        $arr3 = array();
        $deop = 0;
        $studid = $this->request->data['student_id'];
        $acedmicyear = $this->request->data['acedmicyear'];

        foreach ($this->request->data['quater'] as $k => $try) {
          // pr($this->request->data);
          if ($try != '') {
            // pr('if');
            $trys = $this->request->data['amount'][$k] ?? '';
            if ($trys == 0) {
              continue;
            }
            if ($trys != '') {
              $sss = ctype_digit($try);
              if ($try == "Collage Caution Money (Refundable)" || $try == "Hostel Caution Money") {
                $arr2[$try] = round($trys);
                $amat = round($trys);
              } else if ($sss == '1') {
                $studentfeepending = $this->Feesheads->find('all')->where(['Feesheads.id' => $try])->first();
                $name = $studentfeepending['name'];

                if ($try == "57") {
                  $isUpdateDue = 'Y';
                  $depo_amt = $trys;
                  $students = $this->Students->find('all')->where(['Students.id' => $studid])->select(['due_fees', 'fname', 'id'])->first();
                  if ($students['due_fees'] !== NULL && $students['due_fees'] !== 0) {
                    if ($students['due_fees'] < $trys) {
                      $this->Flash->error(__("Deposited amount doesn't greater than due fee amount Kindly Try Again!!"));
                      return $this->redirect(['action' => 'view/' . $studid]);
                    }
                  }
                }

                if ($trys == '') {
                  $this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
                  return $this->redirect(['action' => 'view/' . $studid]);
                }

                $arr[$name] = round($trys);
              } else {
                if ($trys == '') {
                  $this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
                  return $this->redirect(['action' => 'view/' . $studid]);
                }

                $arr[$try] = round($trys);
              }
            }
          }
        }
        // exit;

        foreach ($this->request->data['pendid'] as $kk => $tryk) {

          foreach ($this->request->data['amounts'] as $ksk => $trysk) {

            if ($kk == $ksk) {
              $tryk = '"' . $this->request->data['refrencepending'][$ksk] . '"';
              $arr[$tryk] = round($trysk);
              $conn = ConnectionManager::get('default');
              $conn->execute("UPDATE `studentfee_pending` SET `status`='Y'  WHERE id='" . $this->request->data['pendid'][$kk] . "' AND amt='" . $this->request->data['amounts'][$ksk] . "' AND s_id='" . $studid . "'");
              $d = $oQuery->execute();
            }
          }
        }

        if ($this->request->data['formno'] == '') {
          $this->request->data['formno'] = '0';
        }
        $str = serialize($arr);
        // pr($str);
        // exit;

        if ($this->request->data['paydate'] != '') {

          $this->request->session()->delete('paydatef');
          $this->request->session()->write('paydatef', date('d-m-Y', strtotime($this->request->data['paydate'])));

          if ($this->request->data['recipetno'] != '0') {
            $this->request->session()->delete('reciptnof');
            $this->request->session()->write('reciptnof', $this->request->data['recipetno']);
          }

          if ($deop > 0) {

            $this->request->data['fee'] = $this->request->data['fee'];
            $this->request->data['deposite_amt'] = round($this->request->data['deposite_amt']);
          } else {
            $this->request->data['deposite_amt'] = round($this->request->data['deposite_amt']);
            $this->request->data['fee'] = $this->request->data['fee'];
          }

          if ($this->request->data['fee'] == '0') {
            $this->request->data['fee'] = round($this->request->data['deposite_amt']);
          }

          if (!empty($arr)) {

            if ($this->request->data['mode'] == "CASH") {
              $this->request->data['cheque_no'] = '0';
              $this->request->data['ref_no'] = '0';
              $this->request->data['bank_id'] = '';
            }
            if ($this->request->data['mode'] == "CHEQUE") {
              $this->request->data['ref_no'] = '0';
            }
            if ($this->request->data['mode'] == "DD") {
              $this->request->data['ref_no'] = '0';
            }
            if ($this->request->data['mode'] == "NETBANKING") {
              $this->request->data['cheque_no'] = '0';
              $this->request->data['bank_id'] = '';
            }
            if ($this->request->data['mode'] == "Credit Card/Debit Card/UPI") {
              $this->request->data['cheque_no'] = '0';
              $this->request->data['bank_id'] = '';
            }

            $oQuery->insert(['token', 'student_id', 'paydate', 'quarter', 'mode', 'formno', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'lfine', 'remarks', 'location_id', 'board_id', 'deposited_by'])
              ->values([
                'token' => $this->request->data['token'],
                'student_id' => $this->request->data['student_id'],
                'paydate' => date('Y-m-d', strtotime($this->request->data['paydate'])),
                'quarter' => $str,
                'mode' => $this->request->data['mode'],
                'formno' => $this->request->data['formno'],
                'recipetno' => $this->request->data['recipetno'],
                'bank' => $this->request->data['bank_id'],
                'cheque_no' => $this->request->data['cheque_no'],
                'addtionaldiscount' => $this->request->data['addtionaldiscount'],
                'deposite_amt' => $this->request->data['deposite_amt'],
                'fee' => $this->request->data['fee'],
                'ref_no' => $this->request->data['ref_no'],
                'discount' => $this->request->data['discount'],
                'status' => 'Y',
                'acedmicyear' => $this->request->data['acedmicyear'],
                'discountcategory' => $this->request->data['discountcategorys'],
                'lfine' => $this->request->data['lfine'],
                'remarks' => $this->request->data['remarks'],
                'location_id' => $student_data['location_id'],
                'board_id' => $this->request->data['board_id'],
                $this->request->data['deposited_by']
              ]);
          }
        }

        $d = $oQuery->execute();

        if ($this->request->data['discountcategorys']) {
          $conffn = ConnectionManager::get('default');
          $conffn->execute("UPDATE `students` SET `discountcategory`='" . $this->request->data['discountcategorys'] . "' WHERE id='" . $this->request->data['student_id'] . "'");
        }

        if ($this->request->data['is_special'] == '1') {
          $conffn = ConnectionManager::get('default');
          $conffn->execute("UPDATE `students` SET `is_special`='Y' WHERE id='" . $this->request->data['student_id'] . "'");
        }
        $peopleTables = TableRegistry::get('Studentfeepending');
        $oQuerys = $peopleTables->query();

        $student_data = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

        $rid = $student_data['id'];

        $rquarterid = $student_data['quarter'];
        $recipetno = $student_data['recipetno'];
        if ($this->request->data['lfine'] != '0.00') {
          $amount = $this->request->data['fee'] + $this->request->data['lfine'];
        } else {

          $amount = $this->request->data['fee'];
        }
        $addtionaldiscount = $this->request->data['addtionaldiscount'];

        if ($addtionaldiscount > 0) {
          $remain = $amount - $addtionaldiscount;
        } else {
          $remain = $amount;
        }

        if ($this->request->data['dueextra'] < 0) {
          $netamounts = $this->request->data['dueextra'];
        } else if ($this->request->data['dueextra'] > 0) {
          $netamounts = $this->request->data['dueextra'];
        } else {
          $netamounts = '0';
        }

        if ($netamounts != '0') {

          $oQuerys->insert(['s_id', 'r_id', 'recipetnos', 'amt', 'status', 'deposited_by'])
            ->values([
              's_id' => $this->request->data['student_id'],
              'r_id' => $rid,
              'recipetnos' => $recipetno,
              'amt' => $netamounts,
              'status' => 'N',
              $this->request->data['deposited_by']
            ]);
        }

        $oQuerys->execute();

        $peopleTableshh = TableRegistry::get('Studentfees');
        $oQueryshh = $peopleTableshh->query();

        if (!empty($arr2)) {
          $str2 = serialize($arr2);

          $oQueryshh->insert(['token', 'student_id', 'paydate', 'quarter', 'mode', 'formno', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'remarks', 'board_id', 'deposited_by'])
            ->values([
              'token' => $this->request->data['token'],
              'student_id' => $this->request->data['student_id'],
              'paydate' => date('Y-m-d', strtotime($this->request->data['paydate'])),
              'quarter' => $str2,
              'mode' => $this->request->data['mode'],
              'formno' => $this->request->data['formno'],
              'recipetno' => $this->request->data['recipetno'],
              'bank' => $this->request->data['bank_id'],
              'cheque_no' => $this->request->data['cheque_no'],
              'addtionaldiscount' => '0.00',
              'deposite_amt' => $amat,
              'fee' => $amat,
              'ref_no' => $this->request->data['ref_no'],
              'discount' => '0.00',
              'status' => 'Y',
              'acedmicyear' => $this->request->data['acedmicyear'],
              'discountcategory' => $this->request->data['discountcategorys'],
              'remarks' => $this->request->data['remarks'],
              'board_id' => $this->request->data['board_id'],
              $this->request->data['deposited_by']
            ]);
        }

        $oQueryshh->execute();

        $caution = 'a:1:{s:13:"Caution Money";d:5000;}';

        $student_datacautionmoney = $this->Studentfees->find('all')->where(['Studentfees.quarter LIKE' => $caution, 'Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

        $student_datass = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

        $rids = $student_datass['id'];
        $rquarterids = $student_datass['quarter'];
        //$ridcaution=$student_datacautionmoney['id'];
        $studid = $this->request->data['student_id'];
        $acedmicyear = $this->request->data['acedmicyear'];

        if ($this->request->data['studenthistory']) {

          $studenthistory = $this->request->data['studenthistory'];
        }
        // save all data in database

        if ($d) {

          // update here due amount on student table 
          if ($isUpdateDue == "Y") {
            $students = $this->Students->find('all')->where(['Students.id' => $studid])->select(['due_fees', 'fname', 'id'])->first();
            $remain = floatval($students['due_fees']) - floatval($depo_amt);
            $conn = ConnectionManager::get('default');
            $conn->execute("UPDATE `students` SET `due_fees`='" . $remain . "' WHERE  id='" . $studid . "'");
          }

          if (!empty($this->request->data['pendid'])) {
            $this->rollbacks($studid, $this->request->data['recipetno'], $this->request->data['pendid'], $this->request->data['amounts'], $this->request->data['refrencepending']);
          } else {
            $pen = array();
            $amo = array();
            $refrt = array();
            $this->rollbacks($studid, $this->request->data['recipetno'], $pen, $amo, $refrt);
          }

          if ($this->request->data['recipetno'] != '0') {
            $this->request->data['hdfb'] = '1';
            if ($this->request->data['hdfb'] == '1') {

              if ($rquarterids == 'a:1:{s:13:"Caution Money";d:5000;}') {

                $this->request->session()->delete('openfess_recipt3');
                $this->request->session()->delete('openfess_recipt4');
                $this->request->session()->delete('openfess_recipt5');

                if ($studenthistory) {
                  $this->request->session()->write('openfess_recipt3', 'printscautionhistory');
                } else {
                  $this->request->session()->write('openfess_recipt3', 'printscaution');
                }

                $this->request->session()->write('openfess_recipt4', $rids);
                $this->request->session()->write('openfess_recipt5', $acedmicyear);

                //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
                return $this->redirect(['action' => 'view/' . $studid]);
              } else {

                $this->request->session()->delete('openfess_recipt');

                $this->request->session()->delete('openfess_recipt2');
                $this->request->session()->delete('openfess_recipt5');
                if ($studenthistory) {
                  $this->request->session()->write('openfess_recipt', 'printsadmissionhistory');
                } else {
                  $this->request->session()->write('openfess_recipt', 'printsadmission');
                }
                $this->request->session()->write('openfess_recipt2', $rids);
                $this->request->session()->write('openfess_recipt5', $acedmicyear);

                //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
                return $this->redirect(['action' => 'view/' . $studid]);
              }
            } else {
              //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
              return $this->redirect(['action' => 'view/' . $studid]);
            }
          } else {

            //$this->Flash->success(__('Student Fee  Sucessfully!!'));
            // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
            return $this->redirect(['action' => 'view/' . $studid]);
          }
        } else {

          $this->Flash->error(__('Please Try Again For Submit Fees!!!.'));
          // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
          return $this->redirect(['action' => 'view/' . $studid]);
        }

        $studid = $this->request->data['student_id'];
        $acedmicyear = $this->request->data['acedmicyear'];

        //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
        return $this->redirect(['action' => 'view/' . $studid]);
        //return $this->redirect(['action' => 'view']);
      }
    }

    $this->set('classes', $classes);
  }


  // public function add($id = null, $acedmicyear = null)
  // {

  //   $this->viewBuilder()->layout('admin');


  //   if ($this->request->is(['post', 'put'])) {
  //     // pr($this->request->data); die;
  //     $student_id = $this->request->data['student_id'];
  //     $acedmicyear = $this->request->data['acedmicyear'];

  //     // In Session data write 
  //     $session = $this->request->session();
  //     $session->write('student_id', $student_id); //Write
  //     $session->write('student_accademic', $acedmicyear); //Write

  //     $students_enroll_check = $this->Students->find('all')->where(['Students.id' => $student_id])->first();

  //     if ($students_enroll_check['enroll'] == '') {

  //       if ($this->request->data['mode'] == "CHEQUE") {
  //         $det = $this->Students->get($student_id);
  //         $enroll_data['cheque_status'] = '';
  //         $enroll_data['feesmode'] = 'CHEQUE';
  //         $enroll_data['enroll'] = '';
  //         $entity = $this->Students->patchEntity($det, $enroll_data);
  //         $this->Students->save($entity);
  //       } else {
  //         // $studentsid = $this->Students->find('all')->where(['Students.board_id' => '1'])->order(['enroll' => 'DESC'])->first();
  //         $studentsid = $this->Students->find('all')->select(['id', 'enroll', 'fname'])->order(['enroll' => 'DESC'])->first();
  //         $number = trim($studentsid['enroll']);
  //         $addst = $number + 1;
  //         $stdent = $addst;
  //         $det = $this->Students->get($student_id);
  //         $enroll_data['feesmode'] = $this->request->data['mode'];
  //         $enroll_data['enroll'] = $stdent;
  //         $entity = $this->Students->patchEntity($det, $enroll_data);
  //         $this->Students->save($entity);
  //       }
  //     }

  //     $userTable2 = TableRegistry::get('Studentfees');
  //     $exists2 = $userTable2->exists(['token' => $this->request->data['token'], 'student_id' => $this->request->data['student_id']]);

  //     if ($exists2) {
  //       $this->redirect(['controller' => 'Studentfees', 'action' => 'index/' . $student_id . '/' . $acedmicyear]);
  //     } else {
  //       $rolepresent = $this->request->session()->read('Auth.User.role_id');
  //       if ($rolepresent == '5' || $rolepresent == '6' ||  $rolepresent == '105') {

  //         $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

  //         $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

  //         if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
  //           $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
  //         }

  //         $c = $student_datasmaxss['amount'];
  //       }
  //       if ($this->request->data['recipetno'] != '0') {
  //         $this->request->data['recipetno'] = $c + 1;
  //       }

  //       // pr($this->request->data);exit;

  //       if ($this->request->data['fee']) {
  //         $this->request->data['fee'] = $this->request->data['fee'];
  //       }

  //       $peopleTable = TableRegistry::get('Studentfees');
  //       $oQuery = $peopleTable->query();
  //       $romm = sizeof($this->request->data['quater']);
  //       if ($this->request->data['cheque_no'] == "") {
  //         $this->request->data['cheque_no'] = '0';
  //       }

  //       if ($this->request->data['ref_no'] == "") {
  //         $this->request->data['ref_no'] = '0';
  //       }
  //       if ($this->request->data['bank_id'] == "") {
  //         $this->request->data['bank_id'] = '';
  //       }
  //       if ($this->request->data['addtionaldiscount'] == "") {
  //         $this->request->data['addtionaldiscount'] = '';
  //       }
  //       if ($this->request->data['deposite_amt'] == "") {
  //         $this->request->data['deposite_amt'] = '';
  //       }
  //       if ($this->request->data['lfine'] == "") {
  //         $this->request->data['lfine'] = '0.00';
  //       }

  //       $student_data = $this->Students->find('all')->where(['Students.id' => $this->request->data['student_id'], 'Students.status' => 'Y'])->first();
  //       $this->request->data['payer'] = $student_data['fee_submittedby'];

  //       $arr = array();
  //       $arr2 = array();
  //       $arr3 = array();
  //       //pr($this->request->data);die;
  //       $deop = 0;
  //       $studid = $this->request->data['student_id'];

  //       $studentsdare =  $this->Students->find('all')->where(['Students.id' => $studid, 'Students.status' => 'Y'])->first();

  //       $acedmicyear = $this->request->data['acedmicyear'];

  //       foreach ($this->request->data['quater'] as $k => $try) {

  //         if ($try != '') {

  //           foreach ($this->request->data['amount'] as $ks => $trys) {
  //             if ($k == $ks) {

  //               $sss = ctype_digit($try);

  //               if ($try == "Collage Caution Money (Refundable)" || $try == "Hostel Caution Money") {
  //                 if ($trys != '' && $try != '') {
  //                   $arr2[$try] = round($trys);
  //                 }

  //                 $amat = round($trys);
  //               } else if ($sss == '1') {

  //                 $studentfeepending = $this->Feesheads->find('all')->where(['Feesheads.id' => $try])->first();
  //                 $name = $studentfeepending['name'];

  //                 // This condition work for deposite previous year due  57 is the fees head id 
  //                 if ($try == "57") {
  //                   $students = $this->Students->find('all')->where(['Students.id' => $studid])->first();
  //                   if ($students['due_fees'] !== NULL && $students['due_fees'] !== 0) {
  //                     if ($students['due_fees'] >= $trys) {
  //                       $remain = floatval($students['due_fees']) - floatval($trys);
  //                       $conn = ConnectionManager::get('default');

  //                       $conn->execute("UPDATE `students` SET `due_fees`='" . $remain . "' WHERE  id='" . $studid . "'");
  //                     } else {
  //                       $this->Flash->error(__("Deposited amount doesn't greater than due fee amount Kindly Try Again!!"));
  //                       // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
  //                       return $this->redirect(['action' => 'view/' . $studid]);
  //                     }
  //                   }
  //                 }

  //                 $student_data = $this->Students->find('all')->where(['Students.id' => $this->request->data['student_id'], 'Students.status' => 'Y'])->first();
  //                 $board_id = $student_data['board_id'];
  //                 if ($trys != '' && $name != '') {
  //                   if ($trys == '') {
  //                     $this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
  //                     // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
  //                     return $this->redirect(['action' => 'view/' . $studid]);
  //                   } else {

  //                     $arr[$name] = round($trys);
  //                   }
  //                 }

  //                 if ($board_id == '1') {
  //                   $feeg = $studentfeepending['cbse_fee'];
  //                 } else if ($board_id == '2') {

  //                   $feeg = $studentfeepending['cambridge_fee'];
  //                 } else if ($board_id == '3') {
  //                   $feeg = $studentfeepending['ibdp_fee'];
  //                 }
  //               } else {

  //                 if ($trys != '' && $try != '') {

  //                   if ($studentsdare['class_id'] == '26' || $studentsdare['class_id'] == '27') {

  //                     if ($try == "Development Fee" || $try == "Miscellaneous Fee") {
  //                       $arr[$try] = round($trys);
  //                     } else if ($trys == '') {
  //                       $this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
  //                       // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
  //                       return $this->redirect(['action' => 'view/' . $studid]);
  //                     } else {
  //                       $arr[$try] = round($trys);
  //                     }
  //                   } else if ($trys == '') {
  //                     $this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
  //                     // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
  //                     return $this->redirect(['action' => 'view/' . $studid]);
  //                   } else {
  //                     $arr[$try] = round($trys);
  //                   }
  //                 }
  //               }
  //             }
  //           }
  //         }
  //       }

  //       $studid = $this->request->data['student_id'];

  //       foreach ($this->request->data['pendid'] as $kk => $tryk) {

  //         foreach ($this->request->data['amounts'] as $ksk => $trysk) {
  //           if ($kk == $ksk) {

  //             $tryk = '"' . $this->request->data['refrencepending'][$ksk] . '"';
  //             $arr[$tryk] = round($trysk);

  //             $conn = ConnectionManager::get('default');

  //             $conn->execute("UPDATE `studentfee_pending` SET `status`='Y'  WHERE id='" . $this->request->data['pendid'][$kk] . "' AND amt='" . $this->request->data['amounts'][$ksk] . "' AND s_id='" . $studid . "'");
  //             //$conn->execute("DELETE FROM studentfee_pending WHERE id='".$this->request->data['pendid'][$kk]."' AND amt='".$this->request->data['amounts'][$ksk]."' AND s_id='".$studid."'");

  //             $d = $oQuery->execute();
  //           }
  //         }
  //       }

  //       if ($this->request->data['formno'] == '') {
  //         $this->request->data['formno'] = '0';
  //       }

  //       $str = serialize($arr);

  //       if ($this->request->data['paydate'] != '') {
  //         $this->request->session()->delete('paydatef');
  //         $this->request->session()->write('paydatef', date('d-m-Y', strtotime($this->request->data['paydate'])));
  //         if ($this->request->data['recipetno'] != '0') {
  //           $this->request->session()->delete('reciptnof');
  //           $this->request->session()->write('reciptnof', $this->request->data['recipetno']);
  //         }

  //         if ($deop > 0) {

  //           $this->request->data['fee'] = $this->request->data['fee'];
  //           $this->request->data['deposite_amt'] = round($this->request->data['deposite_amt']);
  //         } else {
  //           $this->request->data['deposite_amt'] = round($this->request->data['deposite_amt']);
  //           $this->request->data['fee'] = $this->request->data['fee'];
  //         }

  //         if ($this->request->data['fee'] == '0') {
  //           $this->request->data['fee'] = round($this->request->data['deposite_amt']);
  //         }

  //         if (!empty($arr)) {

  //           if ($this->request->data['mode'] == "CASH") {
  //             $this->request->data['cheque_no'] = '0';
  //             $this->request->data['ref_no'] = '0';
  //             $this->request->data['bank_id'] = '';
  //           }

  //           if ($this->request->data['mode'] == "CHEQUE") {

  //             $this->request->data['ref_no'] = '0';
  //           }

  //           if ($this->request->data['mode'] == "DD") {

  //             $this->request->data['ref_no'] = '0';
  //           }
  //           if ($this->request->data['mode'] == "NETBANKING") {

  //             $this->request->data['cheque_no'] = '0';

  //             $this->request->data['bank_id'] = '';
  //           }

  //           if ($this->request->data['mode'] == "Credit Card/Debit Card/UPI") {

  //             $this->request->data['cheque_no'] = '0';

  //             $this->request->data['bank_id'] = '';
  //           }

  //           $oQuery->insert(['token', 'student_id', 'paydate', 'quarter', 'mode', 'formno', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'lfine', 'remarks', 'location_id'])
  //             ->values([
  //               'token' => $this->request->data['token'],
  //               'student_id' => $this->request->data['student_id'], 'paydate' => date('Y-m-d', strtotime($this->request->data['paydate'])), 'quarter' => $str, 'mode' => $this->request->data['mode'], 'formno' => $this->request->data['formno'], 'recipetno' => $this->request->data['recipetno'], 'bank' => $this->request->data['bank_id'], 'cheque_no' => $this->request->data['cheque_no'], 'addtionaldiscount' => $this->request->data['addtionaldiscount'], 'deposite_amt' => $this->request->data['deposite_amt'], 'fee' => $this->request->data['fee'], 'ref_no' => $this->request->data['ref_no'], 'discount' => $this->request->data['discount'], 'status' => 'Y', 'acedmicyear' => $this->request->data['acedmicyear'], 'discountcategory' => $this->request->data['discountcategorys'], 'lfine' => $this->request->data['lfine'], 'remarks' => $this->request->data['remarks'], 'location_id' => $student_data['location_id']
  //             ]);
  //         }
  //       }

  //       $d = $oQuery->execute();

  //       if ($this->request->data['discountcategorys']) {
  //         $conffn = ConnectionManager::get('default');
  //         $conffn->execute("UPDATE `students` SET `discountcategory`='" . $this->request->data['discountcategorys'] . "' WHERE id='" . $this->request->data['student_id'] . "'");
  //       }

  //       if ($this->request->data['is_special'] == '1') {
  //         $conffn = ConnectionManager::get('default');
  //         $conffn->execute("UPDATE `students` SET `is_special`='Y' WHERE id='" . $this->request->data['student_id'] . "'");
  //       }
  //       $peopleTables = TableRegistry::get('Studentfeepending');
  //       $oQuerys = $peopleTables->query();

  //       $student_data = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

  //       $rid = $student_data['id'];

  //       $rquarterid = $student_data['quarter'];
  //       $recipetno = $student_data['recipetno'];
  //       if ($this->request->data['lfine'] != '0.00') {
  //         $amount = $this->request->data['fee'] + $this->request->data['lfine'];
  //       } else {

  //         $amount = $this->request->data['fee'];
  //       }
  //       $addtionaldiscount = $this->request->data['addtionaldiscount'];
  //       if ($addtionaldiscount > 0) {

  //         $remain = $amount - $addtionaldiscount;
  //       } else {

  //         $remain = $amount;
  //       }

  //       //~ if($remain>$this->request->data['deposite_amt']){

  //       //~ $netamounts=$remain-$this->request->data['deposite_amt'];

  //       //~ }else

  //       if ($this->request->data['dueextra'] < 0) {
  //         $netamounts = $this->request->data['dueextra'];
  //       } else if ($this->request->data['dueextra'] > 0) {
  //         $netamounts = $this->request->data['dueextra'];
  //       } else {
  //         $netamounts = '0';
  //       }

  //       if ($netamounts != '0') {

  //         $oQuerys->insert(['s_id', 'r_id', 'recipetnos', 'amt', 'status'])
  //           ->values([
  //             's_id' => $this->request->data['student_id'], 'r_id' => $rid, 'recipetnos' => $recipetno, 'amt' => $netamounts, 'status' => 'N'
  //           ]);
  //       }

  //       $oQuerys->execute();

  //       $peopleTableshh = TableRegistry::get('Studentfees');
  //       $oQueryshh = $peopleTableshh->query();

  //       if (!empty($arr2)) {
  //         $str2 = serialize($arr2);

  //         $oQueryshh->insert(['token', 'student_id', 'paydate', 'quarter', 'mode', 'formno', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'remarks'])
  //           ->values([
  //             'token' => $this->request->data['token'],
  //             'student_id' => $this->request->data['student_id'], 'paydate' => date('Y-m-d', strtotime($this->request->data['paydate'])), 'quarter' => $str2, 'mode' => $this->request->data['mode'], 'formno' => $this->request->data['formno'], 'recipetno' => $this->request->data['recipetno'], 'bank' => $this->request->data['bank_id'], 'cheque_no' => $this->request->data['cheque_no'], 'addtionaldiscount' => '0.00', 'deposite_amt' => $amat, 'fee' => $amat, 'ref_no' => $this->request->data['ref_no'], 'discount' => '0.00', 'status' => 'Y', 'acedmicyear' => $this->request->data['acedmicyear'], 'discountcategory' => $this->request->data['discountcategorys'], 'remarks' => $this->request->data['remarks']
  //           ]);
  //       }
  //       $oQueryshh->execute();

  //       $caution = 'a:1:{s:13:"Caution Money";d:5000;}';

  //       $student_datacautionmoney = $this->Studentfees->find('all')->where(['Studentfees.quarter LIKE' => $caution, 'Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

  //       $student_datass = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

  //       $rids = $student_datass['id'];
  //       $rquarterids = $student_datass['quarter'];
  //       //$ridcaution=$student_datacautionmoney['id'];
  //       $studid = $this->request->data['student_id'];
  //       $acedmicyear = $this->request->data['acedmicyear'];

  //       if ($this->request->data['studenthistory']) {

  //         $studenthistory = $this->request->data['studenthistory'];
  //       }
  //       // save all data in database

  //       if ($d) {

  //         if (!empty($this->request->data['pendid'])) {
  //           $this->rollbacks($studid, $this->request->data['recipetno'], $this->request->data['pendid'], $this->request->data['amounts'], $this->request->data['refrencepending']);
  //         } else {
  //           $pen = array();
  //           $amo = array();
  //           $refrt = array();
  //           $this->rollbacks($studid, $this->request->data['recipetno'], $pen, $amo, $refrt);
  //         }

  //         if ($this->request->data['recipetno'] != '0') {
  //           $this->request->data['hdfb'] = '1';
  //           if ($this->request->data['hdfb'] == '1') {

  //             if ($rquarterids == 'a:1:{s:13:"Caution Money";d:5000;}') {

  //               $this->request->session()->delete('openfess_recipt3');
  //               $this->request->session()->delete('openfess_recipt4');
  //               $this->request->session()->delete('openfess_recipt5');

  //               if ($studenthistory) {
  //                 $this->request->session()->write('openfess_recipt3', 'printscautionhistory');
  //               } else {
  //                 $this->request->session()->write('openfess_recipt3', 'printscaution');
  //               }

  //               $this->request->session()->write('openfess_recipt4', $rids);
  //               $this->request->session()->write('openfess_recipt5', $acedmicyear);

  //               //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
  //               return $this->redirect(['action' => 'view/' . $studid]);
  //             } else {

  //               $this->request->session()->delete('openfess_recipt');

  //               $this->request->session()->delete('openfess_recipt2');
  //               $this->request->session()->delete('openfess_recipt5');
  //               if ($studenthistory) {
  //                 $this->request->session()->write('openfess_recipt', 'printsadmissionhistory');
  //               } else {
  //                 $this->request->session()->write('openfess_recipt', 'printsadmission');
  //               }
  //               $this->request->session()->write('openfess_recipt2', $rids);
  //               $this->request->session()->write('openfess_recipt5', $acedmicyear);

  //               //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
  //               return $this->redirect(['action' => 'view/' . $studid]);
  //             }
  //           } else {
  //             //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
  //             return $this->redirect(['action' => 'view/' . $studid]);
  //           }
  //         } else {

  //           //$this->Flash->success(__('Student Fee  Sucessfully!!'));
  //           // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
  //           return $this->redirect(['action' => 'view/' . $studid]);
  //         }
  //       } else {

  //         $this->Flash->error(__('Please Try Again For Submit Fees!!!.'));
  //         // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
  //         return $this->redirect(['action' => 'view/' . $studid]);
  //       }

  //       $studid = $this->request->data['student_id'];
  //       $acedmicyear = $this->request->data['acedmicyear'];

  //       //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
  //       return $this->redirect(['action' => 'view/' . $studid]);
  //       //return $this->redirect(['action' => 'view']);
  //     }
  //   }

  //   $this->set('classes', $classes);
  // }

  // Update this function Previou Year due issue 17-08-2023 Rupam 
  public function upgradeAdd($id = null, $acedmicyear = null)
  {

    $this->viewBuilder()->layout('admin');


    if ($this->request->is(['post', 'put'])) {
      // pr($this->request->data); die;
      $student_id = $this->request->data['student_id'];
      $acedmicyear = $this->request->data['acedmicyear'];

      // In Session data write 
      $session = $this->request->session();
      $session->write('student_id', $student_id); //Write
      $session->write('student_accademic', $acedmicyear); //Write

      $students_enroll_check = $this->Students->find('all')->where(['Students.id' => $student_id])->first();

      if ($students_enroll_check['enroll'] == '') {

        if ($this->request->data['mode'] == "CHEQUE") {
          $det = $this->Students->get($student_id);
          $enroll_data['cheque_status'] = '';
          $enroll_data['feesmode'] = 'CHEQUE';
          $enroll_data['enroll'] = '';
          $entity = $this->Students->patchEntity($det, $enroll_data);
          $this->Students->save($entity);
        } else {
          // $studentsid = $this->Students->find('all')->where(['Students.board_id' => '1'])->order(['enroll' => 'DESC'])->first();
          $studentsid = $this->Students->find('all')->select(['id', 'enroll', 'fname'])->order(['enroll' => 'DESC'])->first();
          $number = trim($studentsid['enroll']);
          $addst = $number + 1;
          $stdent = $addst;
          $det = $this->Students->get($student_id);
          $enroll_data['feesmode'] = $this->request->data['mode'];
          $enroll_data['enroll'] = $stdent;
          $entity = $this->Students->patchEntity($det, $enroll_data);
          $this->Students->save($entity);
        }
      }

      $userTable2 = TableRegistry::get('Studentfees');
      $exists2 = $userTable2->exists(['token' => $this->request->data['token'], 'student_id' => $this->request->data['student_id']]);

      if ($exists2) {
        $this->redirect(['controller' => 'Studentfees', 'action' => 'view/' . $student_id . '/' . $acedmicyear]);
      } else {
        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        if ($rolepresent == '5' || $rolepresent == '6' || $rolepresent == '105') {

          $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

          $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

          if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
            $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
          }

          $c = $student_datasmaxss['amount'];
        }
        if ($this->request->data['recipetno'] != '0') {
          $this->request->data['recipetno'] = $c + 1;
        }

        // pr($this->request->data);exit;

        if ($this->request->data['fee']) {
          $this->request->data['fee'] = $this->request->data['fee'];
        }

        $peopleTable = TableRegistry::get('Studentfees');
        $oQuery = $peopleTable->query();
        $romm = sizeof($this->request->data['quater']);
        if ($this->request->data['cheque_no'] == "") {
          $this->request->data['cheque_no'] = '0';
        }

        if ($this->request->data['ref_no'] == "") {
          $this->request->data['ref_no'] = '0';
        }
        if ($this->request->data['bank_id'] == "") {
          $this->request->data['bank_id'] = '';
        }
        if ($this->request->data['addtionaldiscount'] == "") {
          $this->request->data['addtionaldiscount'] = '';
        }
        if ($this->request->data['deposite_amt'] == "") {
          $this->request->data['deposite_amt'] = '';
        }
        if ($this->request->data['lfine'] == "") {
          $this->request->data['lfine'] = '0.00';
        }

        $student_data = $this->Students->find('all')->where(['Students.id' => $this->request->data['student_id'], 'Students.status' => 'Y'])->first();
        $this->request->data['payer'] = $student_data['fee_submittedby'];

        $arr = array();
        $arr2 = array();
        $arr3 = array();
        //pr($this->request->data);die;
        $deop = 0;
        $studid = $this->request->data['student_id'];

        $studentsdare = $this->Students->find('all')->where(['Students.id' => $studid, 'Students.status' => 'Y'])->first();

        $acedmicyear = $this->request->data['acedmicyear'];

        foreach ($this->request->data['quater'] as $k => $try) {

          if ($try != '') {

            foreach ($this->request->data['amount'] as $ks => $trys) {
              if ($k == $ks) {

                $sss = ctype_digit($try);

                if ($try == "Collage Caution Money (Refundable)" || $try == "Hostel Caution Money") {
                  if ($trys != '' && $try != '') {
                    $arr2[$try] = round($trys);
                  }

                  $amat = round($trys);
                } else if ($sss == '1') {

                  $studentfeepending = $this->Feesheads->find('all')->where(['Feesheads.id' => $try])->first();
                  $name = $studentfeepending['name'];

                  // This condition work for deposite previous year due  57 is the fees head id 
                  if ($try == "57") {
                    $students = $this->Students->find('all')->where(['Students.id' => $studid])->first();
                    if ($students['due_fees'] !== NULL && $students['due_fees'] !== 0) {
                      if ($students['due_fees'] >= $trys) {
                        $remain = floatval($students['due_fees']) - floatval($trys);
                        $conn = ConnectionManager::get('default');

                        $conn->execute("UPDATE `students` SET `due_fees`='" . $remain . "' WHERE  id='" . $studid . "'");
                      } else {
                        $this->Flash->error(__("Deposited amount doesn't greater than due fee amount Kindly Try Again!!"));
                        // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
                        return $this->redirect(['action' => 'view/' . $studid]);
                      }
                    }
                  }

                  $student_data = $this->Students->find('all')->where(['Students.id' => $this->request->data['student_id'], 'Students.status' => 'Y'])->first();
                  $board_id = $student_data['board_id'];
                  if ($trys != '' && $name != '') {
                    if ($trys == '') {
                      $this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
                      // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
                      return $this->redirect(['action' => 'view/' . $studid]);
                    } else {

                      $arr[$name] = round($trys);
                    }
                  }

                  if ($board_id == '1') {
                    $feeg = $studentfeepending['cbse_fee'];
                  } else if ($board_id == '2') {

                    $feeg = $studentfeepending['cambridge_fee'];
                  } else if ($board_id == '3') {
                    $feeg = $studentfeepending['ibdp_fee'];
                  }
                } else {

                  if ($trys != '' && $try != '') {

                    if ($trys == '') {
                      $this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
                      // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
                      return $this->redirect(['action' => 'view/' . $studid]);
                    } else {
                      $arr[$try] = round($trys);
                    }
                  }
                }
              }
            }
          }
        }

        $studid = $this->request->data['student_id'];

        foreach ($this->request->data['pendid'] as $kk => $tryk) {

          foreach ($this->request->data['amounts'] as $ksk => $trysk) {
            if ($kk == $ksk) {

              $tryk = '"' . $this->request->data['refrencepending'][$ksk] . '"';
              $arr[$tryk] = round($trysk);

              $conn = ConnectionManager::get('default');

              $conn->execute("UPDATE `studentfee_pending` SET `status`='Y'  WHERE id='" . $this->request->data['pendid'][$kk] . "' AND amt='" . $this->request->data['amounts'][$ksk] . "' AND s_id='" . $studid . "'");
              //$conn->execute("DELETE FROM studentfee_pending WHERE id='".$this->request->data['pendid'][$kk]."' AND amt='".$this->request->data['amounts'][$ksk]."' AND s_id='".$studid."'");

              $d = $oQuery->execute();
            }
          }
        }

        if ($this->request->data['formno'] == '') {
          $this->request->data['formno'] = '0';
        }

        $str = serialize($arr);

        if ($this->request->data['paydate'] != '') {
          $this->request->session()->delete('paydatef');
          $this->request->session()->write('paydatef', date('d-m-Y', strtotime($this->request->data['paydate'])));
          if ($this->request->data['recipetno'] != '0') {
            $this->request->session()->delete('reciptnof');
            $this->request->session()->write('reciptnof', $this->request->data['recipetno']);
          }

          if ($deop > 0) {

            $this->request->data['fee'] = $this->request->data['fee'];
            $this->request->data['deposite_amt'] = round($this->request->data['deposite_amt']);
          } else {
            $this->request->data['deposite_amt'] = round($this->request->data['deposite_amt']);
            $this->request->data['fee'] = $this->request->data['fee'];
          }

          if ($this->request->data['fee'] == '0') {
            $this->request->data['fee'] = round($this->request->data['deposite_amt']);
          }

          if (!empty($arr)) {

            if ($this->request->data['mode'] == "CASH") {
              $this->request->data['cheque_no'] = '0';
              $this->request->data['ref_no'] = '0';
              $this->request->data['bank_id'] = '';
            }

            if ($this->request->data['mode'] == "CHEQUE") {

              $this->request->data['ref_no'] = '0';
            }

            if ($this->request->data['mode'] == "DD") {

              $this->request->data['ref_no'] = '0';
            }
            if ($this->request->data['mode'] == "NETBANKING") {

              $this->request->data['cheque_no'] = '0';

              $this->request->data['bank_id'] = '';
            }

            if ($this->request->data['mode'] == "Credit Card/Debit Card/UPI") {

              $this->request->data['cheque_no'] = '0';

              $this->request->data['bank_id'] = '';
            }

            $oQuery->insert(['token', 'student_id', 'paydate', 'quarter', 'mode', 'formno', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'lfine', 'remarks', 'location_id'])
              ->values([
                'token' => $this->request->data['token'],
                'student_id' => $this->request->data['student_id'],
                'paydate' => date('Y-m-d', strtotime($this->request->data['paydate'])),
                'quarter' => $str,
                'mode' => $this->request->data['mode'],
                'formno' => $this->request->data['formno'],
                'recipetno' => $this->request->data['recipetno'],
                'bank' => $this->request->data['bank_id'],
                'cheque_no' => $this->request->data['cheque_no'],
                'addtionaldiscount' => $this->request->data['addtionaldiscount'],
                'deposite_amt' => $this->request->data['deposite_amt'],
                'fee' => $this->request->data['fee'],
                'ref_no' => $this->request->data['ref_no'],
                'discount' => $this->request->data['discount'],
                'status' => 'Y',
                'acedmicyear' => $this->request->data['acedmicyear'],
                'discountcategory' => $this->request->data['discountcategorys'],
                'lfine' => $this->request->data['lfine'],
                'remarks' => $this->request->data['remarks'],
                'location_id' => $student_data['location_id']
              ]);
          }
        }

        $d = $oQuery->execute();

        if ($this->request->data['discountcategorys']) {
          $conffn = ConnectionManager::get('default');
          $conffn->execute("UPDATE `students` SET `discountcategory`='" . $this->request->data['discountcategorys'] . "' WHERE id='" . $this->request->data['student_id'] . "'");
        }

        if ($this->request->data['is_special'] == '1') {
          $conffn = ConnectionManager::get('default');
          $conffn->execute("UPDATE `students` SET `is_special`='Y' WHERE id='" . $this->request->data['student_id'] . "'");
        }
        $peopleTables = TableRegistry::get('Studentfeepending');
        $oQuerys = $peopleTables->query();

        $student_data = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

        $rid = $student_data['id'];

        $rquarterid = $student_data['quarter'];
        $recipetno = $student_data['recipetno'];
        if ($this->request->data['lfine'] != '0.00') {
          $amount = $this->request->data['fee'] + $this->request->data['lfine'];
        } else {

          $amount = $this->request->data['fee'];
        }
        $addtionaldiscount = $this->request->data['addtionaldiscount'];
        if ($addtionaldiscount > 0) {

          $remain = $amount - $addtionaldiscount;
        } else {

          $remain = $amount;
        }

        //~ if($remain>$this->request->data['deposite_amt']){

        //~ $netamounts=$remain-$this->request->data['deposite_amt'];

        //~ }else

        if ($this->request->data['dueextra'] < 0) {
          $netamounts = $this->request->data['dueextra'];
        } else if ($this->request->data['dueextra'] > 0) {
          $netamounts = $this->request->data['dueextra'];
        } else {
          $netamounts = '0';
        }

        if ($netamounts != '0') {

          $oQuerys->insert(['s_id', 'r_id', 'recipetnos', 'amt', 'status'])
            ->values([
              's_id' => $this->request->data['student_id'],
              'r_id' => $rid,
              'recipetnos' => $recipetno,
              'amt' => $netamounts,
              'status' => 'N'
            ]);
        }

        $oQuerys->execute();

        $peopleTableshh = TableRegistry::get('Studentfees');
        $oQueryshh = $peopleTableshh->query();

        if (!empty($arr2)) {
          $str2 = serialize($arr2);

          $oQueryshh->insert(['token', 'student_id', 'paydate', 'quarter', 'mode', 'formno', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'remarks'])
            ->values([
              'token' => $this->request->data['token'],
              'student_id' => $this->request->data['student_id'],
              'paydate' => date('Y-m-d', strtotime($this->request->data['paydate'])),
              'quarter' => $str2,
              'mode' => $this->request->data['mode'],
              'formno' => $this->request->data['formno'],
              'recipetno' => $this->request->data['recipetno'],
              'bank' => $this->request->data['bank_id'],
              'cheque_no' => $this->request->data['cheque_no'],
              'addtionaldiscount' => '0.00',
              'deposite_amt' => $amat,
              'fee' => $amat,
              'ref_no' => $this->request->data['ref_no'],
              'discount' => '0.00',
              'status' => 'Y',
              'acedmicyear' => $this->request->data['acedmicyear'],
              'discountcategory' => $this->request->data['discountcategorys'],
              'remarks' => $this->request->data['remarks']
            ]);
        }
        $oQueryshh->execute();

        $caution = 'a:1:{s:13:"Caution Money";d:5000;}';

        $student_datacautionmoney = $this->Studentfees->find('all')->where(['Studentfees.quarter LIKE' => $caution, 'Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

        $student_datass = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

        $rids = $student_datass['id'];
        $rquarterids = $student_datass['quarter'];
        //$ridcaution=$student_datacautionmoney['id'];
        $studid = $this->request->data['student_id'];
        $acedmicyear = $this->request->data['acedmicyear'];

        if ($this->request->data['studenthistory']) {

          $studenthistory = $this->request->data['studenthistory'];
        }
        // save all data in database

        if ($d) {

          if (!empty($this->request->data['pendid'])) {
            $this->rollbacks($studid, $this->request->data['recipetno'], $this->request->data['pendid'], $this->request->data['amounts'], $this->request->data['refrencepending']);
          } else {
            $pen = array();
            $amo = array();
            $refrt = array();
            $this->rollbacks($studid, $this->request->data['recipetno'], $pen, $amo, $refrt);
          }

          if ($this->request->data['recipetno'] != '0') {
            $this->request->data['hdfb'] = '1';
            if ($this->request->data['hdfb'] == '1') {

              if ($rquarterids == 'a:1:{s:13:"Caution Money";d:5000;}') {

                $this->request->session()->delete('openfess_recipt3');
                $this->request->session()->delete('openfess_recipt4');
                $this->request->session()->delete('openfess_recipt5');

                if ($studenthistory) {
                  $this->request->session()->write('openfess_recipt3', 'printscautionhistory');
                } else {
                  $this->request->session()->write('openfess_recipt3', 'printscaution');
                }

                $this->request->session()->write('openfess_recipt4', $rids);
                $this->request->session()->write('openfess_recipt5', $acedmicyear);

                //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
                return $this->redirect(['action' => 'view/' . $studid]);
              } else {

                $this->request->session()->delete('openfess_recipt');

                $this->request->session()->delete('openfess_recipt2');
                $this->request->session()->delete('openfess_recipt5');
                if ($studenthistory) {
                  $this->request->session()->write('openfess_recipt', 'printsadmissionhistory');
                } else {
                  $this->request->session()->write('openfess_recipt', 'printsadmission');
                }
                $this->request->session()->write('openfess_recipt2', $rids);
                $this->request->session()->write('openfess_recipt5', $acedmicyear);

                //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
                return $this->redirect(['action' => 'view/' . $studid]);
              }
            } else {
              //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
              return $this->redirect(['action' => 'view/' . $studid]);
            }
          } else {

            //$this->Flash->success(__('Student Fee  Sucessfully!!'));
            // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
            return $this->redirect(['action' => 'view/' . $studid]);
          }
        } else {

          $this->Flash->error(__('Please Try Again For Submit Fees!!!.'));
          // return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);
          return $this->redirect(['action' => 'view/' . $studid]);
        }

        $studid = $this->request->data['student_id'];
        $acedmicyear = $this->request->data['acedmicyear'];

        //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
        return $this->redirect(['action' => 'view/' . $studid]);
        //return $this->redirect(['action' => 'view']);
      }
    }

    $this->set('classes', $classes);
  }


  public function rollbacks($stid = null, $recipet = null, $pendid = null, $amounts = null, $refrencepending = null)
  {

    $studentfees = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $stid, 'Studentfees.recipetno' => $recipet])->first();

    $quarter = $studentfees['quarter'];
    $student_id = $studentfees['student_id'];
    $acedmicyear = $studentfees['acedmicyear'];
    $feesid = $studentfees['id'];
    $deposite_amt = (int) $studentfees['deposite_amt'];

    $aee = unserialize($quarter);

    $amoutpay = 0;
    foreach ($aee as $kru => $amtr) {

      $amoutpay += (int) $amtr;
    }

    if ($studentfees['lfine'] != '') {

      $total = (int) $studentfees['lfine'] + (int) $amoutpay;
    } else {
      $total = (int) $amoutpay;
    }

    $studentfeependings = $this->Studentfeepending->find('all')->where(['r_id' => $feesid, 's_id' => $student_id])->first();
    //pr($studentfeependings); die;
    if ($studentfeependings['id']) {

      if ($studentfeependings['amt'] > 0) {

        $net = (int) $total - (int) $studentfeependings['amt'];
      } else if ($studentfeependings['amt'] < 0) {
        $studentfeependings['amt'] = abs($studentfeependings['amt']);
        $net = (int) $total + (int) $studentfeependings['amt'];
      }
    } else {

      $net = (int) $total;
    }

    if ($studentfees['discount'] != '0.00' || $studentfees['discount'] != '0') {
      $net = (int) $net - (int) $studentfees['discount'];
    } else {
      $net = (int) $net;
    }

    if ($studentfees['addtionaldiscount'] != '0') {
      $net = (int) $net - (int) $studentfees['addtionaldiscount'];
    } else {
      $net = (int) $net;
    }

    if ($net == $deposite_amt) {
    } else {

      if ($studentfees['id']) {
        $this->Studentfees->delete($this->Studentfees->get($studentfees['id']));
      }

      if ($studentfeependings['id']) {

        $this->Studentfeepending->delete($this->Studentfeepending->get($studentfeependings['id']));
      }

      if (!empty($amounts)) {

        foreach ($pendid as $kk => $tryk) {

          foreach ($amounts as $ksk => $trysk) {
            if ($kk == $ksk) {

              $tryk = '"' . $refrencepending[$ksk] . '"';
              $arr[$tryk] = round($trysk);

              $conn = ConnectionManager::get('default');

              $conn->execute("UPDATE `studentfee_pending` SET `status`='N'  WHERE id='" . $pendid[$kk] . "' AND amt='" . $amounts[$ksk] . "' AND s_id='" . $stid . "'");
            }
          }
        }
      }

      $this->Flash->error(__('Transection Failed , Please Try Again !!!'));

      // return $this->redirect(['action' => 'index/' . $stid . '/' . $acedmicyear . '/?id=personal']);
      return $this->redirect(['action' => 'view/' . $stid]);
    }
  }

  public function addhistory($id = null, $acedmicyear = null)
  {

    $this->viewBuilder()->layout('admin');

    if ($id != '') {

      $studentfeepending = $this->Studentfees->find('all')->where(['Studentfees.id' => $id])->first();
      $recipetnoss = $studentfeepending['recipetno'];
      $studid = $studentfeepending['student_id'];
      $quarter = $studentfeepending['quarter'];

      $aee = unserialize($quarter);

      foreach ($aee as $kru => $amtr) {

        $kru = str_replace('"', "", $kru);

        if (ctype_digit($kru) == '1') {

          $studentfeependings = $this->Studentfeepending->find('all')->where(['r_id' => $kru, 'amt LIKE' => $amtr . "%"])->first();
          $srid = $studentfeependings['id'];

          if ($srid) {
            $conn = ConnectionManager::get('default');

            $conn->execute("UPDATE `studentfee_pending` SET `status`='N'  WHERE id='" . $srid . "' AND amt LIKE '" . $amtr . "%' AND s_id='" . $studid . "' AND r_id='" . $kru . "'");
          }
        }
      }

      $conn = ConnectionManager::get('default');
      $conn->execute("DELETE FROM `studentfee_pending` WHERE r_id='" . $id . "'");

      $stcau = $this->Studentfees->find('all')->where(['Studentfees.quarter' => 'a:1:{s:13:"Caution Money";s:1:"0";}', 'Studentfees.deposite_amt' => '0', 'Studentfees.status' => 'Y'])->first();

      if ($stcau['id']) {
        $stii = $stcau['student_id'];
        $conn = ConnectionManager::get('default');
        $conn->execute("UPDATE `student_feeallocations` SET `status`='N'  WHERE id='" . $stcau['id'] . "' AND recipetno='" . $recipetnoss . "' AND student_id='" . $stii . "'");
      }

      $conn = ConnectionManager::get('default');
      $conn->execute("UPDATE `student_feeallocations` SET `status`='N'  WHERE id='" . $id . "' AND student_id='" . $studid . "'");

      $this->Flash->success(__('Student Fee Cancelled Sucessfully!!'));
      return $this->redirect(['action' => 'history/' . $studid . '/' . $acedmicyear . '/?id=personal']);
    }

    if ($this->request->is(['post', 'put'])) {

      $rolepresent = $this->request->session()->read('Auth.User.role_id');
      if ($rolepresent == '5') {

        $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

        $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
        if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
          $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
        }

        $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' => '1'])->first();

        $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' => '1', 'Enquires.class_id <=' => '22'])->contain(['Enquires'])->first();

        //  $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']);
        $c = $student_datasmaxss['amount'];
      } else if ($rolepresent == '8') {

        $boardzs = ['2', '3'];

        $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id IN' => $boardzs, 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

        $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id IN' => $boardzs, 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
        if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
          $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
        }

        $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id IN' => $boardzs])->first();

        $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id IN' => $boardzs, 'Enquires.class_id >=' => '23'])->contain(['Enquires'])->first();
        //  $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']);
        $c = $student_datasmaxss['amount'];
      }

      if ($this->request->data['recipetno'] != '0') {
        $this->request->data['recipetno'] = $c + 1;
      }

      if ($this->request->data['fee']) {
        $this->request->data['fee'] = $this->request->data['fee'];
      }

      $peopleTable = TableRegistry::get('Studentfees');
      $oQuery = $peopleTable->query();
      $romm = sizeof($this->request->data['quater']);
      if ($this->request->data['cheque_no'] == "") {
        $this->request->data['cheque_no'] = '0';
      }

      if ($this->request->data['ref_no'] == "") {
        $this->request->data['ref_no'] = '0';
      }
      if ($this->request->data['bank_id'] == "") {
        $this->request->data['bank_id'] = '';
      }
      if ($this->request->data['addtionaldiscount'] == "") {
        $this->request->data['addtionaldiscount'] = '';
      }
      if ($this->request->data['deposite_amt'] == "") {
        $this->request->data['deposite_amt'] = '';
      }
      if ($this->request->data['lfine'] == "") {
        $this->request->data['lfine'] = '0.00';
      }

      $student_data = $this->Studentshistory->find('all')->where(['Studentshistory.stud_id' => $this->request->data['student_id'], 'Studentshistory.status' => 'Y'])->first();
      $this->request->data['payer'] = $student_data['fee_submittedby'];

      $arr = array();
      $arr2 = array();
      $arr3 = array();
      //pr($this->request->data);die;
      $deop = 0;
      $studid = $this->request->data['student_id'];

      $studentsdare =
        $this->Studentshistory->find('all')->where(['Studentshistory.stud_id' => $studid, 'Studentshistory.status' => 'Y'])->first();

      $acedmicyear = $this->request->data['acedmicyear'];

      foreach ($this->request->data['quater'] as $k => $try) {
        if ($try != '') {

          foreach ($this->request->data['amount'] as $ks => $trys) {
            if ($k == $ks) {

              $sss = ctype_digit($try);

              if ($try == "Caution Money") {

                if ($trys != '' && $try != '') {

                  $arr2[$try] = round($trys);
                }
                $amat = round($trys);
              } else if ($sss == '1') {

                $studentfeepending = $this->Feesheads->find('all')->where(['Feesheads.id' => $try])->first();
                $name = $studentfeepending['name'];
                $student_data = $this->Studentshistory->find('all')->where(['Studentshistory.stud_id' => $this->request->data['student_id'], 'Studentshistory.status' => 'Y'])->first();
                $board_id = $student_data['board_id'];
                if ($trys != '' && $name != '') {
                  if ($trys == '') {
                    $this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
                    return $this->redirect(['action' => 'history/' . $studid . '/' . $acedmicyear . '/?id=personal']);
                  } else {

                    $arr[$name] = round($trys);
                  }
                }

                if ($board_id == '1') {

                  $feeg = $studentfeepending['cbse_fee'];
                } else if ($board_id == '2') {

                  $feeg = $studentfeepending['cambridge_fee'];
                } else if ($board_id == '3') {
                  $feeg = $studentfeepending['ibdp_fee'];
                }
              } else {

                if ($trys != '' && $try != '') {

                  if ($studentsdare['class_id'] == '26' || $studentsdare['class_id'] == '27') {

                    if ($try == "Development Fee" || $try == "Miscellaneous Fee") {

                      $arr[$try] = round($trys);
                    } else if ($trys == '') {
                      $this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
                      return $this->redirect(['action' => 'history/' . $studid . '/' . $acedmicyear . '/?id=personal']);
                    } else {
                      $arr[$try] = round($trys);
                    }
                  } else if ($trys == '') {
                    $this->Flash->error(__("Deposited amount doesn't received Kindly Try Again!!"));
                    return $this->redirect(['action' => 'history/' . $studid . '/' . $acedmicyear . '/?id=personal']);
                  } else {
                    $arr[$try] = round($trys);
                  }
                }
              }
            }
          }
        }
      }

      $studid = $this->request->data['student_id'];

      foreach ($this->request->data['pendid'] as $kk => $tryk) {

        foreach ($this->request->data['amounts'] as $ksk => $trysk) {
          if ($kk == $ksk) {

            $tryk = '"' . $this->request->data['refrencepending'][$ksk] . '"';
            $arr[$tryk] = round($trysk);

            $conn = ConnectionManager::get('default');

            $conn->execute("UPDATE `studentfee_pending` SET `status`='Y'  WHERE id='" . $this->request->data['pendid'][$kk] . "' AND amt='" . $this->request->data['amounts'][$ksk] . "' AND s_id='" . $studid . "'");

            $d = $oQuery->execute();
          }
        }
      }

      if ($this->request->data['formno'] == '') {
        $this->request->data['formno'] = '0';
      }
      $str = serialize($arr);

      if ($this->request->data['paydate'] != '') {
        $this->request->session()->delete('paydatef');
        $this->request->session()->write('paydatef', date('d-m-Y', strtotime($this->request->data['paydate'])));
        if ($this->request->data['recipetno'] != '0') {
          $this->request->session()->delete('reciptnof');
          $this->request->session()->write('reciptnof', $this->request->data['recipetno']);
        }

        if ($deop > 0) {

          $this->request->data['fee'] = $this->request->data['fee'];
          $this->request->data['deposite_amt'] = round($this->request->data['deposite_amt']);
        } else {
          $this->request->data['deposite_amt'] = round($this->request->data['deposite_amt']);
          $this->request->data['fee'] = $this->request->data['fee'];
        }

        if ($this->request->data['fee'] == '0') {
          $this->request->data['fee'] = round($this->request->data['deposite_amt']);
        }

        if (!empty($arr)) {

          if ($this->request->data['mode'] == "CASH") {
            $this->request->data['cheque_no'] = '0';
            $this->request->data['ref_no'] = '0';
            $this->request->data['bank_id'] = '';
          }

          if ($this->request->data['mode'] == "CHEQUE") {

            $this->request->data['ref_no'] = '0';
          }

          if ($this->request->data['mode'] == "DD") {

            $this->request->data['ref_no'] = '0';
          }
          if ($this->request->data['mode'] == "NETBANKING") {

            $this->request->data['cheque_no'] = '0';

            $this->request->data['bank_id'] = '';
          }

          if ($this->request->data['mode'] == "Credit Card/Debit Card/UPI") {

            $this->request->data['cheque_no'] = '0';

            $this->request->data['bank_id'] = '';
          }
          //pr($this->request->data); die;
          $oQuery->insert(['student_id', 'paydate', 'quarter', 'mode', 'formno', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'lfine', 'remarks'])
            ->values([
              'student_id' => $this->request->data['student_id'],
              'paydate' => date('Y-m-d', strtotime($this->request->data['paydate'])),
              'quarter' => $str,
              'mode' => $this->request->data['mode'],
              'formno' => $this->request->data['formno'],
              'recipetno' => $this->request->data['recipetno'],
              'bank' => $this->request->data['bank_id'],
              'cheque_no' => $this->request->data['cheque_no'],
              'addtionaldiscount' => $this->request->data['addtionaldiscount'],
              'deposite_amt' => $this->request->data['deposite_amt'],
              'fee' => $this->request->data['fee'],
              'ref_no' => $this->request->data['ref_no'],
              'discount' => $this->request->data['discount'],
              'status' => 'Y',
              'acedmicyear' => $this->request->data['acedmicyear'],
              'discountcategory' => $this->request->data['discountcategorys'],
              'lfine' => $this->request->data['lfine'],
              'remarks' => $this->request->data['remarks']
            ]);
        }
      }

      $d = $oQuery->execute();

      if ($this->request->data['discountcategorys']) {
        $conffn = ConnectionManager::get('default');
        $conffn->execute("UPDATE `studentshistory` SET `discountcategory`='" . $this->request->data['discountcategorys'] . "' WHERE stud_id='" . $this->request->data['student_id'] . "'");
      }

      if ($this->request->data['is_special'] == '1') {
        $conffn = ConnectionManager::get('default');
        $conffn->execute("UPDATE `studentshistory` SET `is_special`='Y' WHERE stud_id='" . $this->request->data['student_id'] . "'");
      }
      $peopleTables = TableRegistry::get('Studentfeepending');
      $oQuerys = $peopleTables->query();

      $student_data = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

      $rid = $student_data['id'];

      $rquarterid = $student_data['quarter'];
      $recipetno = $student_data['recipetno'];
      if ($this->request->data['lfine'] != '0.00') {
        $amount = $this->request->data['fee'] + $this->request->data['lfine'];
      } else {

        $amount = $this->request->data['fee'];
      }
      $addtionaldiscount = $this->request->data['addtionaldiscount'];
      if ($addtionaldiscount > 0) {

        $remain = $amount - $addtionaldiscount;
      } else {

        $remain = $amount;
      }

      //~ if($remain>$this->request->data['deposite_amt']){

      //~ $netamounts=$remain-$this->request->data['deposite_amt'];

      //~ }else

      if ($this->request->data['dueextra'] < 0) {
        $netamounts = $this->request->data['dueextra'];
      } else if ($this->request->data['dueextra'] > 0) {
        $netamounts = $this->request->data['dueextra'];
      } else {
        $netamounts = '0';
      }

      if ($netamounts != '0') {

        $oQuerys->insert(['s_id', 'r_id', 'recipetnos', 'amt', 'status'])
          ->values([
            's_id' => $this->request->data['student_id'],
            'r_id' => $rid,
            'recipetnos' => $recipetno,
            'amt' => $netamounts,
            'status' => 'N'
          ]);
      }

      $oQuerys->execute();

      $peopleTableshh = TableRegistry::get('Studentfees');
      $oQueryshh = $peopleTableshh->query();

      if (!empty($arr2)) {
        $str2 = serialize($arr2);

        $oQueryshh->insert(['student_id', 'paydate', 'quarter', 'mode', 'formno', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'remarks'])
          ->values([
            'student_id' => $this->request->data['student_id'],
            'paydate' => date('Y-m-d', strtotime($this->request->data['paydate'])),
            'quarter' => $str2,
            'mode' => $this->request->data['mode'],
            'formno' => $this->request->data['formno'],
            'recipetno' => $this->request->data['recipetno'],
            'bank' => $this->request->data['bank_id'],
            'cheque_no' => $this->request->data['cheque_no'],
            'addtionaldiscount' => '0.00',
            'deposite_amt' => $amat,
            'fee' => $amat,
            'ref_no' => $this->request->data['ref_no'],
            'discount' => '0.00',
            'status' => 'Y',
            'acedmicyear' => $this->request->data['acedmicyear'],
            'discountcategory' => $this->request->data['discountcategorys'],
            'remarks' => $this->request->data['remarks']
          ]);
      }
      $oQueryshh->execute();
      $caution = 'a:1:{s:13:"Caution Money";d:5000;}';

      $student_datacautionmoney = $this->Studentfees->find('all')->where(['Studentfees.quarter LIKE' => $caution, 'Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

      $student_datass = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $this->request->data['student_id']])->order(['id' => 'DESC'])->first();

      $rids = $student_datass['id'];
      $rquarterids = $student_datass['quarter'];
      //$ridcaution=$student_datacautionmoney['id'];
      $studid = $this->request->data['student_id'];
      $acedmicyear = $this->request->data['acedmicyear'];

      if ($this->request->data['studenthistory']) {

        $studenthistory = $this->request->data['studenthistory'];

        $stdntcurrent = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $studid])->first();
        if ($stdntcurrent['due_fees']) {

          $remain = $stdntcurrent['due_fees'];

          $resr = $remain - $this->request->data['deposite_amt'];

          $conffn = ConnectionManager::get('default');
          $conffn->execute("UPDATE `students` SET `due_fees`='" . $resr . "' WHERE id='" . $this->request->data['student_id'] . "'");
        }
      }
      // save all data in database

      if ($d) {

        if ($this->request->data['recipetno'] != '0') {

          if ($this->request->data['hdfb'] == '1') {

            if ($rquarterids == 'a:1:{s:13:"Caution Money";d:5000;}') {

              $this->request->session()->delete('openfess_recipt3');
              $this->request->session()->delete('openfess_recipt4');
              $this->request->session()->delete('openfess_recipt5');

              if ($studenthistory) {
                $this->request->session()->write('openfess_recipt3', 'printscautionhistory');
              } else {
                $this->request->session()->write('openfess_recipt3', 'printscaution');
              }

              $this->request->session()->write('openfess_recipt4', $rids);
              $this->request->session()->write('openfess_recipt5', $acedmicyear);

              //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
              return $this->redirect(['action' => 'view/' . $studid]);
            } else {

              $this->request->session()->delete('openfess_recipt');

              $this->request->session()->delete('openfess_recipt2');
              $this->request->session()->delete('openfess_recipt5');
              if ($studenthistory) {
                $this->request->session()->write('openfess_recipt', 'printsadmissionhistory');
              } else {
                $this->request->session()->write('openfess_recipt', 'printsadmission');
              }
              $this->request->session()->write('openfess_recipt2', $rids);
              $this->request->session()->write('openfess_recipt5', $acedmicyear);

              //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
              return $this->redirect(['action' => 'view/' . $studid]);
            }
          } else {

            //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
            return $this->redirect(['action' => 'view/' . $studid]);
          }
        } else {

          //$this->Flash->success(__('Student Fee  Sucessfully!!'));
          return $this->redirect(['action' => 'history/' . $studid . '/' . $acedmicyear . '/?id=personal']);
        }
      } else {

        $this->Flash->error(__('Please Try Again For Submit Fees!!!.'));
        return $this->redirect(['action' => 'history/' . $studid . '/' . $acedmicyear . '/?id=personal']);
      }

      $studid = $this->request->data['student_id'];
      $acedmicyear = $this->request->data['acedmicyear'];

      //$this->Flash->success(__('Student Fee Submitted Sucessfully!!'));
      return $this->redirect(['action' => 'view/' . $studid]);
      //return $this->redirect(['action' => 'view']);

    }

    $this->set('classes', $classes);
  }


  public function updatecautionmoney()
  {

    $peopleTableshh = TableRegistry::get('Studentfees');
    $oQueryshh = $peopleTableshh->query();

    $caution = 'Admission Fee';

    $student_datacautionmoney = $this->Students->find('all')->where(['Students.enroll <=' => 5974, 'Students.status' => 'Y', 'Students.category' => 'Normal', 'Students.board_id IN' => ['1', '2']])->order(['id' => 'DESC'])->toarray();
    $dr = array();

    foreach ($student_datacautionmoney as $k => $ff) {

      $student_datass = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ff['id'], 'Studentfees.status' => 'Y', 'Studentfees.quarter LIKE' => '%' . $caution . '%'])->order(['id' => 'DESC'])->first();
      if ($student_datass['id']) {
      } else {

        $dr[] = $ff['id'];
      }
    }
    pr($dr);
    die;

    if (!empty($dr)) {
      foreach ($dr as $tt => $f) {
        $peopleTableshh = TableRegistry::get('Studentfees');
        $oQueryshh = $peopleTableshh->query();
        $caution = 'a:2:{s:13:"Admission Fee";s:5:"25000";s:15:"Development Fee";s:4:"5000";}';
        $date = '2018-04-01';
        $amat = '30000';
        $oQueryshh->insert(['student_id', 'paydate', 'quarter', 'mode', 'formno', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'remarks'])
          ->values([
            'student_id' => $f,
            'paydate' => date('Y-m-d', strtotime($date)),
            'quarter' => $caution,
            'mode' => 'CASH',
            'formno' => '0',
            'recipetno' => '0',
            'bank' => '',
            'cheque_no' => '',
            'addtionaldiscount' => '0.00',
            'deposite_amt' => $amat,
            'fee' => $amat,
            'ref_no' => '',
            'discount' => '0.00',
            'status' => 'Y',
            'acedmicyear' => '2018-19',
            'discountcategory' => '',
            'remarks' => 'Old Receipt'
          ]);
        $oQueryshh->execute();
      }
    }
  }

  public function updatediscountsss()
  {

    $student_datacautionmoney = $this->Students->find('all')->where(['Students.discountcategory' => '', 'Students.status' => 'Y'])->order(['id' => 'DESC'])->toarray();
    $dr = array();
    $discountcategory = array();

    foreach ($student_datacautionmoney as $k => $ff) {

      $student_datass = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $ff['id'], 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.discountcategory !=' => ''])->order(['paydate' => 'DESC'])->first();
      if ($student_datass['id']) {

        $dr[] = $student_datass['student_id'];
        if ($student_datass['discountcategory']) {
          $discountcategory[] = $student_datass['discountcategory'];
        } else {

          $discountcategory[] = '';
        }
      }
    }

    echo $s;
    die;
    $fgg = 0;
    if (!empty($dr)) {

      $romms = sizeof($dr);
      for ($i = 0; $i < $romms; $i++) {

        $peopleTableshh = TableRegistry::get('Students');
        $oQueryshh = $peopleTableshh->query();

        $oQueryshh->update()
          ->set(['discountcategory' => $discountcategory[$i]])
          ->where(['id' => $dr[$i], 'status' => 'Y'])
          ->execute();

        $fgg++;
      }
      echo $fgg;
      die;
    }
  }

  public function addtransport()
  {

    $this->viewBuilder()->layout('admin');

    if (isset($id) && !empty($id)) {
      //using for edit
      $classes = $this->StudentTransfees->get($id);
    } else {
      //using for new entry
      $classes = $this->StudentTransfees->newEntity();
      $this->request->data['status'] = '1';
    }
    if ($this->request->is(['post', 'put'])) {
      //    pr($this->request->data); die;
      $peopleTable = TableRegistry::get('StudentTransfees');
      $oQuery = $peopleTable->query();
      $romm = sizeof($this->request->data['quater']);
      if ($this->request->data['cheque_no'] == "") {
        $this->request->data['cheque_no'] = '0';
      }
      if ($this->request->data['bank_id'] == "") {
        $this->request->data['bank_id'] = '0';
      }
      for ($i = 0; $i < $romm; $i++) {
        if ($this->request->data['paydate'][$i] != '') {
          $oQuery->insert(['student_id', 'paydate', 'quarter', 'amount', 'mode', 'bank_id', 'cheque_no', 'fee', 'challan_no', 'discount', 'status', 'acedmicyear'])
            ->values([
              'student_id' => $this->request->data['student_id'],
              'paydate' => date('Y-m-d', strtotime($this->request->data['paydate'][$i])),
              'quarter' => $this->request->data['quater'][$i],
              'amount' => $this->request->data['amount'][$i],
              'mode' => $this->request->data['modes'],
              'bank_id' => $this->request->data['bank_id'],
              'cheque_no' => $this->request->data['cheque_no'],
              'fee' => $this->request->data['fee'],
              'challan_no' => $this->request->data['challan_no'],
              'discount' => $this->request->data['discount'],
              'status' => 'Y',
              'acedmicyear' => $this->request->data['acedmicyear']
            ]);
        }
      }

      $d = $oQuery->execute();
      $studid = $this->request->data['student_id'];
      // save all data in database
      $acedmicyear = $this->request->data['acedmicyear'];
      if ($d) {
        $this->Flash->success(__('Student Transport Fee  has been saved.'));
        return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '?id=academic']);
      } else {

        $this->Flash->success(__('Student Transport Fee  not saved.'));
        return $this->redirect(['action' => 'index/' . $studid . '/?id=academic']);
      }
    }

    $this->set('classes', $classes);
  }

  public function addhostal()
  {

    $this->viewBuilder()->layout('admin');

    if (isset($id) && !empty($id)) {
      //using for edit
      $classes = $this->StudentHostalfees->get($id);
    } else {
      //using for new entry
      $classes = $this->StudentHostalfees->newEntity();
      $this->request->data['status'] = '1';
    }
    if ($this->request->is(['post', 'put'])) {
      $acedmicyear = $this->request->data['acedmicyear'];
      if ($this->request->data['paydate'] == "") {
        $this->Flash->error(__('Select one of option.'));
        return $this->redirect(['action' => 'index/' . $this->request->data['student_id'] . '/' . $acedmicyear . '?id=guardians']);
      } else {
        $peopleTable = TableRegistry::get('StudentHostalfees');
        $oQuery = $peopleTable->query();
        $romm = sizeof($this->request->data['modes1']);
        if ($this->request->data['cheque_no'] == "") {
          $this->request->data['cheque_no'] = '0';
        }
        if ($this->request->data['bank_id'] == "") {
          $this->request->data['bank_id'] = '0';
        }
        for ($i = 0; $i < $romm; $i++) {
          $oQuery->insert(['student_id', 'paydate', 'h_id', 'h_name', 'amount', 'mode', 'bank_id', 'cheque_no', 'fee', 'challan_no', 'discount', 'status', 'acedmicyear'])
            ->values([
              'student_id' => $this->request->data['student_id'],
              'paydate' => date('Y-m-d', strtotime($this->request->data['paydate'])),
              'h_id' => $this->request->data['h_id'],
              'h_name' => $this->request->data['h_name'],
              'amount' => $this->request->data['amount'],
              'mode' => $this->request->data['modes1'],
              'bank_id' => $this->request->data['bank_id'],
              'cheque_no' => $this->request->data['cheque_no'],
              'fee' => $this->request->data['fee'],
              'challan_no' => $this->request->data['challan_no'],
              'discount' => $this->request->data['discount'],
              'status' => 'Y',
              'acedmicyear' => $this->request->data['acedmicyear']
            ]);
        }
        $studid = $this->request->data['student_id'];
        $d = $oQuery->execute();
        $acedmicyear = $this->request->data['acedmicyear'];
        // save all data in database

        if ($d) {
          $this->Flash->success(__('Student Hostal Fee  has been saved.'));
          return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '?id=guardians']);
        } else {

          $this->Flash->error(__('Student Hostal Fee  not saved.'));
          return $this->redirect(['action' => 'index/' . $studid . '/?id=guardians']);
        }
      }
    }

    $this->set('classes', $classes);
  }

  public function sort()
  {
    $this->viewBuilder()->layout('admin');
    $id = $this->request->data['id'];
    if (isset($id) && !empty($id)) {
      //using for edit
      $classes = $this->Locations->get($id);
    } else {
      //using for new entry
      $classes = $this->Locations->newEntity();
    }

    if ($this->request->is(['post', 'put'])) {

      //$this->request->data = $this->request->data['sort'];
      $classes->sort = $this->request->data['sort'];

      if ($this->Locations->save($classes)) {
        echo $classes['sort'];
      } else {
        echo 'wrong';
      }
    }
    die;
  }

  public function studentfeeack()
  {

    $this->viewBuilder()->layout('admin');

    $rolepresent = $this->request->session()->read('Auth.User.role_id');

    if ($rolepresent == '1' || $rolepresent == '6') {
      $classes = $this->Classections->find('list', [
        'keyField' => 'Classes.id',
        'valueField' => 'Classes.title',
      ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
      $this->set('classes', $classes);
    } else if ($rolepresent == '5') {

      $classes = $this->Classections->find('list', [
        'keyField' => 'Classes.id',
        'valueField' => 'Classes.title',
      ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
      $this->set('classes', $classes);
    } else if ($rolepresent == '8') {

      $classes = $this->Classections->find('list', [
        'keyField' => 'Classes.id',
        'valueField' => 'Classes.title',
      ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
      $this->set('classes', $classes);
    }

    $sectionslist = $this->Sections->find('list', [
      'keyField' => 'id',
      'valueField' => 'title',
    ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
    $this->set('sectionslist', $sectionslist);

    if ($rolepresent == '1' || $rolepresent == '6') {
      $student_data =
        $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => 'Y'])->order(['Classes.sort' => 'ASC', 'Sections.id' => 'ASC', 'Students.fname' => 'ASC'])->limit(100)->toarray();
      $this->set('students', $student_data);
    } else if ($rolepresent == '5') {

      $student_data =
        $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => 'Y'])->order(['Classes.sort' => 'ASC', 'Sections.id' => 'ASC', 'Students.fname' => 'ASC'])->toarray();
      $this->set('students', $student_data);
    } else if ($rolepresent == '8') {
      $bordid = ['2', '3'];
      $student_data =
        $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.board_id IN' => $bordid, 'Students.status' => 'Y'])->order(['Classes.sort' => 'ASC', 'Sections.id' => 'ASC', 'Students.fname' => 'ASC'])->toarray();
      $this->set('students', $student_data);
    }
    //get data from paricular id
    //$classes = $this->Classfee->get($id);
    //$this->set(compact('classes'));
  }
  //view functionality

  public function studentview($id = null)
  {

    $this->viewBuilder()->layout('admin');
    $user = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
    $rolepresentyear = $user['academic_year'];

    $this->set(compact('rolepresentyear'));

    $rolepresent = $this->request->session()->read('Auth.User.role_id');

    if ($this->request->session()->read('openfess_recipt')) {

      $ids = $this->request->session()->read('openfess_recipt');

      $ids2 = $this->request->session()->read('openfess_recipt2');
      $acedemicdd = $this->request->session()->read('openfess_recipt5');

      $this->set(compact('ids'));
      $this->set(compact('ids2'));
      $this->set(compact('id'));
      $this->set(compact('acedemicdd'));
      $this->set(compact('academic_year'));
      $this->request->session()->delete('openfess_recipt');
      $this->request->session()->delete('openfess_recipt2');
      $this->request->session()->delete('openfess_recipt5');
    }

    if ($this->request->session()->read('openfess_recipt3')) {

      $ids3 = $this->request->session()->read('openfess_recipt3');
      $ids4 = $this->request->session()->read('openfess_recipt4');
      $acedemicdd = $this->request->session()->read('openfess_recipt5');
      $this->set(compact('ids3'));
      $this->set(compact('ids4'));
      $this->set(compact('acedemicdd'));
      $this->request->session()->delete('openfess_recipt3');
      $this->request->session()->delete('openfess_recipt4');
      $this->request->session()->delete('openfess_recipt5');
    }
    if ($rolepresent == '1' || $rolepresent == '6') {
      $classes = $this->Classections->find('list', [
        'keyField' => 'Classes.id',
        'valueField' => 'Classes.title',
      ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
      $this->set('classes', $classes);
    } else if ($rolepresent == '5') {

      $classes = $this->Classections->find('list', [
        'keyField' => 'Classes.id',
        'valueField' => 'Classes.title',
      ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
      $this->set('classes', $classes);
    } else if ($rolepresent == '8') {

      $classes = $this->Classections->find('list', [
        'keyField' => 'Classes.id',
        'valueField' => 'Classes.title',
      ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
      $this->set('classes', $classes);
    }

    $sectionslist = $this->Sections->find('list', [
      'keyField' => 'id',
      'valueField' => 'title',
    ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
    $this->set('sectionslist', $sectionslist);

    if ($rolepresent == '1' || $rolepresent == '6') {
      $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => 'Y'])->order(['Students.id' => 'DESC', 'Students.fname' => 'ASC'])->toarray();
      $this->set('students', $student_data);
    } else if ($rolepresent == '5') {

      $student_data =
        $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => 'Y'])->order(['Students.id' => 'DESC', 'Students.fname' => 'ASC'])->limit(20)->toarray();
      $this->set('students', $student_data);
    } else if ($rolepresent == '8') {
      $student_data =
        $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => 'Y'])->order(['Students.id' => 'DESC', 'Students.fname' => 'ASC'])->limit(20)->toarray();
      $this->set('students', $student_data);
    }
    //get data from paricular id
    //$classes = $this->Classfee->get($id);
    //$this->set(compact('classes'));
  }

  public function view($id = null)
  {
    // pr($id);die;

    $this->viewBuilder()->layout('admin');
    $this->loadModel('Classes');

    $user = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
    $rolepresentyear = $user['academic_year'];
    // pr($rolepresentyear);exit;


    $acd = $this->academicyear();
    $houses = $this->Houses->find('list', [
      'keyField' => 'id',
      'valueField' => 'name',
    ])->where(['status' => '1'])->order(['name' => 'ASC'])->toArray();
    $this->set('houses', $houses);
    $this->set(compact('acd'));

    $this->set(compact('rolepresentyear'));
    $this->set(compact('id'));

    $rolepresent = $this->request->session()->read('Auth.User.role_id');

    if ($this->request->session()->read('openfess_recipt')) {

      $ids = $this->request->session()->read('openfess_recipt');
      $ids2 = $this->request->session()->read('openfess_recipt2');
      $acedemicdd = $this->request->session()->read('openfess_recipt5');

      $this->set(compact('ids'));
      $this->set(compact('ids2'));
      $this->set(compact('id'));
      $this->set(compact('acedemicdd'));
      $this->set(compact('academic_year'));
      $this->request->session()->delete('openfess_recipt');
      $this->request->session()->delete('openfess_recipt2');
      $this->request->session()->delete('openfess_recipt5');
    }

    if ($this->request->session()->read('openfess_recipt3')) {

      $ids3 = $this->request->session()->read('openfess_recipt3');
      $ids4 = $this->request->session()->read('openfess_recipt4');
      $acedemicdd = $this->request->session()->read('openfess_recipt5');
      $this->set(compact('ids3'));
      $this->set(compact('ids4'));
      $this->set(compact('acedemicdd'));
      $this->request->session()->delete('openfess_recipt3');
      $this->request->session()->delete('openfess_recipt4');
      $this->request->session()->delete('openfess_recipt5');
    }

    $sectionslist = $this->Sections->find('list', [
      'keyField' => 'id',
      'valueField' => 'title',
    ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
    $this->set('sectionslist', $sectionslist);

    if ($rolepresent == '1' || $rolepresent == '6' || $rolepresent == '105' || $rolepresent == '5') {
      $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => 'Y'])->order(['Students.id' => 'DESC', 'Students.fname' => 'ASC'])->toArray();
      $this->set('students', $student_data);

      $classes = $this->Classes->find('list', [
        'keyField' => 'id',
        'valueField' => 'title',
      ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();

      $this->set('classes', $classes);
    }
  }
  //delete functionality
  public function delete($id, $academic_year)
  {
    //$this->request->allowMethod(['post', 'delete']);
    $conn = ConnectionManager::get('default');
    $conn->execute("DELETE FROM class_fee_allocations WHERE academic_year='" . $academic_year . "' AND class_id='" . $id . "'");

    $this->Flash->success(__('Class Fee with id: {0} has been deleted.', h($id)));
    return $this->redirect(['action' => 'index']);
  }
  //status update functionality
  public function status($id, $status, $academic_year)
  {

    if (isset($id) && !empty($id)) {
      if ($status == 'Y') {

        $status = 'N';
        //status update
        $conn = ConnectionManager::get('default');
        $conn->execute("UPDATE `class_fee_allocations` SET `status` = 'N' WHERE `academic_year`='" . $academic_year . "' AND `class_fee_allocations`.`class_id` = " . $id);

        $this->Flash->success(__('Class Fee status has been updated.'));
        return $this->redirect(['action' => 'index']);
      } else {
        $conn = ConnectionManager::get('default');
        $conn->execute("UPDATE `class_fee_allocations` SET `status` = 'Y' WHERE `academic_year`='" . $academic_year . "' AND `class_fee_allocations`.`class_id` = " . $id);
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

    $user = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
    $rolepresentyear = $user['academic_year'];
    $acd = $this->academicyear();
    $this->set(compact('acd'));
    $this->set(compact('rolepresentyear'));
    $this->loadModel('Classes');
    $feesheadstotal = $this->Feesheads->find('list', [
      'keyField' => 'name',
      'valueField' => 'name',
    ])->where(['status' => 'Y', 'type IN' => ['3', '0'], 'sort !=' => '0'])->order(['name' => 'ASC'])->toArray();
    $this->set('feesheadstotal', $feesheadstotal);
    $class_id = $this->Classes->find('list', ['keyField' => 'id', 'valueField' => 'title'])->order(['sort' => 'ASC'])->toarray();
    $this->set(compact('class_id'));

    if ($rolepresent == '5' || $rolepresent == '6') {

      $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

      $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
      if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
        $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
      }

      $c = $student_datasmaxss['amount'];
    } else if ($rolepresent == '8') {

      $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

      $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
      if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
        $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
      }

      $c = $student_datasmaxss['amount'];
    }

    $recipietno = $c + 1;
    $this->set('recipietno', $recipietno);
    if ($this->request->is(['post', 'put'])) {
      // pr($this->request->data); die;
      $userTable2 = TableRegistry::get('Studentfees');
      $exists2 = $userTable2->exists(['token' => $this->request->data['token'], 'student_id' => $this->request->data['s_id']]);

      if ($exists2) {
        $this->redirect(['controller' => 'Studentfees', 'action' => 'otherfees']);
      } else {
        if ($rolepresent == '5' || $rolepresent == '6') {

          $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();


          $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
          if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
            $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
          }

          $c = $student_datasmaxss['amount'];
        } else if ($rolepresent == '8') {

          $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

          $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
          if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
            $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
          }

          $c = $student_datasmaxss['amount'];
        }

        $recipietno = $c + 1;
        //         $peopleTableshh = TableRegistry::get('Studentfees');
        //         $oQueryshh = $peopleTableshh->query();
        //         if ($rolepresent == '5' || $rolepresent == '6') {

        //             $stidda = $this->request->data['s_id'];
        //         } else if ($rolepresent == '8') {

        //             $stidd = '333333';
        //         }
        $ofdate = date('Y-m-d', strtotime($this->request->data['paydate']));
        //         $this->request->data['title'] = strtoupper($this->request->data['title']);

        //         //pr($date);die;
        //         $str2 = 'a:1:{s:14:"Other Fees";d:' . $this->request->data['amount'] . ';}';
        //         $mode = strtoupper($this->request->data['mode']);

        // //         $oQueryshh->insert(['student_id', 'paydate', 'quarter', 'mode', 'formno', 'type', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'remarks', 'token'])
        // //             ->values([
        // //                 'student_id' => $$this->request->data['s_id'], 'paydate' => $ofdate, 'quarter' => $str2, 'mode' => $mode, 'formno' => '0', 'type' => 'Other', 'recipetno' => $recipietno, 'bank' => '', 'cheque_no' => '0', 'addtionaldiscount' => '0.00', 'deposite_amt' => $this->request->data['total'], 'fee' => $this->request->data['amount'], 'ref_no' => '0', 'discount' => $this->request->data['discount'], 'status' => 'Y', 'acedmicyear' => $this->request->data['academicyear'], 'discountcategory' => '', 'remarks' => $this->request->data['title'], 'token' => $this->request->data['token']
        // //             ]);
        // //         $oQueryshh->execute();
        // //   echo $oQueryshh; die;


        $this->request->data['title'] = strtoupper($this->request->data['title']);
        $this->request->data['pupilname'] = strtoupper($this->request->data['pupilname']);
        $this->request->data['parentsname'] = strtoupper($this->request->data['parentsname']);

        $other = $this->Otherfees->newEntity();
        $this->request->data['paydate'] = $ofdate;
        $this->request->data['receipt_no'] = $recipietno;
        $otherfee = $this->Otherfees->patchEntity($other, $this->request->data);
        // pr($otherfee); die;
        $save = $this->Otherfees->save($otherfee);
        $id = $save->id;

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
      if (isset($this->request->data['pupilname'])) {
        $fname = explode(' ', $this->request->data['pupilname']);
      }

      $conn = ConnectionManager::get('default');
      //pr($this->request->data); die;;
      //pr($enroll); die;
      if (isset($fname) && !empty($fname)) {
        $cond = '';
        $cond1 = '';
        if (!empty($fname[0])) {

          $cond .= " AND  UPPER(students.fname)  LIKE  '" . strtoupper($fname[0]) . "%'";
          $cond1 .= " AND  UPPER(drop_out_students.fname)  LIKE  '" . strtoupper($fname[0]) . "%'";
        }

        if (!empty($fname[1])) {

          $cond .= " AND   UPPER(students.middlename)  LIKE  '" . strtoupper($fname[1]) . "%'";
          $cond1 .= " AND  UPPER(drop_out_students.middlename)  LIKE  '" . strtoupper($fname[1]) . "%'";
        }
        $query = "SELECT * FROM students WHERE 1=1";
        $query1 = $query . $cond;
        $result1 = $conn->execute($query1)->fetchAll('assoc');
        //pr($result1);
        $querys = "SELECT * FROM  drop_out_students WHERE 1=1";
        $query2 = $querys . $cond1;
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
  public function updatecheque()
  {
    $this->autoRender = false;

    $this->loadModel('Studentfees');
    if ($this->request->is('post')) {

      $id = $this->request->data['id'];
      $cheq = $this->request->data['cheque_no'];
      $bank = $this->request->data['bank'];
      // echo $cheq; die;
      $conn = ConnectionManager::get('default');
      $SQL = "UPDATE `student_feeallocations` SET `cheque_no` = '" . $cheq . "',`bank`= '" . $bank . "' WHERE `student_feeallocations`.`id` = " . $id . ";";
      $conn->execute($SQL)->count();

      echo 1;
    }
  }

  public function updatereceipt()
  {
    $this->autoRender = false;
    $this->loadModel('Studentfees');
    if ($this->request->is('post')) {
      $conn = ConnectionManager::get('default');
      $id = $this->request->data['id'];
      $new_receipt = $this->request->data['new_receipt'];
      $old_form = $this->request->data['old_form'];
      $new_form = $this->request->data['new_form'];
      $date = $this->request->data['date'];
      $receiptExist = $this->Studentfees->exists(['recipetno' => $new_receipt]);
      if ($receiptExist) {
        echo 2;
        die;
      }
      $details = $this->Studentfees->find()->where(['id' => $id])->first();
      if ($details['type'] == 'Registration') {
        $applicant = $this->Applicant->find()->where(['recipietno' => $details['recipetno']])->order(['id' => 'DESC'])->first();
        if (!empty($new_receipt)) {
          $applicant['recipietno'] = $new_receipt;
        }
        if (!empty($new_form)) {
          $ApplicantExist = $this->Applicant->exists(['sno' => $new_form]);
          if ($ApplicantExist) {
            echo 3;
            die;
          }
          $applicant['sno'] = $new_form;
          $enquires = $this->Enquires->find()->where(['formno' => $old_form])->order()->first();
          $enquires['formno'] = $new_form;
          $this->Enquires->save($enquires);
          $SQL2 = "UPDATE `student_feeallocations` SET `formno` = '" . $new_form . "' WHERE `student_feeallocations`.`id` = " . $id . ";";
          $conn->execute($SQL2)->count();
        }
        if (strtotime($applicant['created']) != strtotime($date)) {
          $applicant['created'] = date('Y-m-d', strtotime($date));
          $newDte = date('Y-m-d', strtotime($date));
          $SQL3 = "UPDATE `student_feeallocations` SET `paydate` = '" . $newDte . "' WHERE `student_feeallocations`.`id` = " . $id . ";";
          $conn->execute($SQL3)->count();
        }
        $this->Applicant->save($applicant);
      }
      // echo $cheq; die;
      if (!empty($new_receipt) && $new_receipt != $details['recipetno']) {
        $SQL = "UPDATE `student_feeallocations` SET `recipetno` = '" . $new_receipt . "' WHERE `student_feeallocations`.`id` = " . $id . ";";
        $conn->execute($SQL)->count();
      }

      echo 1;
      die;
    }
  }

  // Deposit cheque 
  public function depositcheque()
  {
    $this->viewBuilder()->layout('admin');
    $this->loadModel('Studentfees');
    $this->loadmodel('Students');
    $studentfees = $this->Studentfees->find('all')->contain(['Students'])->where(['Studentfees.mode' => 'CHEQUE'])->order(['Studentfees.id' => 'DESC'])->toarray();
    $this->set('studentsfees', $studentfees);
    // pr($studentfees);die;

  }
  public function accept_cheque($id, $fees_id)
  {
    $studentsid = $this->Students->find('all')->order(['enroll' => 'DESC'])->first();
    $schooler_number = $studentsid['enroll'] + 1;
    // pr($schooler_number);die;     
    $students_enroll_check = $this->Students->find('all')->where(['Students.id' => $id])->order(['enroll' => 'DESC'])->first();
    if ($students_enroll_check['enroll'] == '') {
      $conn = ConnectionManager::get('default');
      $SQL = "UPDATE `students` SET `enroll` = '" . $schooler_number . "', `cheque_status` ='Y' WHERE `students`.`id` = " . $id . ";";
      $status = $conn->execute($SQL);

      $conn_fees = ConnectionManager::get('default');
      $SQL_fess = "UPDATE `student_feeallocations` SET `cheque_status` ='Y' WHERE `student_feeallocations`.`id` = " . $fees_id . ";";
      $status = $conn_fees->execute($SQL_fess);
    } else {
      $conn_fees = ConnectionManager::get('default');
      $SQL_fess = "UPDATE `student_feeallocations` SET `cheque_status` ='Y' WHERE `student_feeallocations`.`id` = " . $fees_id . ";";
      $status = $conn_fees->execute($SQL_fess);
    }
    return $this->redirect(['action' => 'depositcheque']);
    $this->Flash->success(__('Check accepted Sucessfully!!'));
  }

  public function reject_cheque($id, $fees_id)
  {
    $students_enroll_check = $this->Students->find('all')->where(['Students.id' => $id])->order(['enroll' => 'DESC'])->first();
    // pr($students_enroll_check);exit;

    if ($students_enroll_check['enroll'] == '') {
      $conn = ConnectionManager::get('default');
      $SQL = "UPDATE `students` SET `enroll` = NULL , `cheque_status` ='N' WHERE `students`.`id` = " . $id . ";";
      $status = $conn->execute($SQL);
      $fees_id = $fees_id;
      $academic_year = '2023-24';
      $remarks = 'Bounced cheque';
      $conn_fees = ConnectionManager::get('default');
      $SQL_fess = "UPDATE `student_feeallocations` SET `cheque_status` ='N' , `status` ='N'  WHERE `student_feeallocations`.`id` = " . $fees_id . ";";
      $status = $conn_fees->execute($SQL_fess);
    } else {
      $fees_id = $fees_id;
      // pr($fees_id); die;
      $academic_year = '2023-24';
      $remarks = 'Bounced cheque';
      $conn_fees = ConnectionManager::get('default');
      $SQL_fess = "UPDATE `student_feeallocations` SET `cheque_status` ='N' , `status` ='N' WHERE `student_feeallocations`.`id` = " . $fees_id . ";";
      // pr($SQL_fess); die;
      $status = $conn_fees->execute($SQL_fess);
      // pr($status); die;
    }
    $this->chequerejected($fees_id, $academic_year, $remarks);

    return $this->redirect(['action' => 'depositcheque']);
    $this->Flash->success(__('Check rejected Sucessfully!!'));
  }

  public function printsadmission($idf = null, $acedemic = null)
  {
    return $this->redirect(['action' => 'newprintsadmission/' . $idf . '/' . $acedemic]);

    $this->response->type('pdf');
    $this->viewBuilder()->layout('ajax');

    $this->response->type('pdf');
    $ert = base64_decode($quater);
    $this->sitesetting('receipt');
    $db = $this->Users->find()->where(['role_id' => 1])->first();
    $this->set(compact('db'));
    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.id' => $idf, 'Studentfees.acedmicyear' => $acedemic])->first();

    $id = $student_datas['student_id'];

    if ($_GET['gid']) {
      $gid = 1;
    } else {

      $gid = 2;
    }

    $this->set(compact('gid'));
    $quater = [$ert];

    $students = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.acedmicyear' => $acedemic])->first();
    $this->set(compact('students'));

    if (empty($students)) {
      $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where(['DropOutStudent.s_id' => $id, 'DropOutStudent.acedmicyear' => $acedemic, 'DropOutStudent.status' => 'Y'])->first();

      $this->set(compact('students'));
    }

    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedemic, 'Studentfees.id' => $idf])->first();
    // pr($student_datas);die;

    $this->set('studentfees', $student_datas);
  }

  // public function newprintsadmission($idf = null, $acedemic = null)
  // {

  //   $this->viewBuilder()->layout('ajax');

  //   $this->response->type('pdf');
  //   $ert = base64_decode($quater);
  //   $this->sitesetting('receipt');
  //   $db = $this->Users->find()->where(['role_id' => 1])->first();

  //   $get_managesettings = $this->getmanagesettings($db['db']);
  //   // pr($get_managesettings); die;
  //   $this->set(compact('db'));
  //   $this->set(compact('get_managesettings'));

  //   $student_datas = $this->Studentfees->find('all')->where(['Studentfees.id' => $idf, 'Studentfees.acedmicyear' => $acedemic])->first();

  //   $id = $student_datas['student_id'];

  //   if ($_GET['gid']) {
  //     $gid = 1;
  //   } else {
  //     $gid = 2;
  //   }

  //   $this->set(compact('gid'));
  //   $quater = [$ert];

  //   $students = $this->Students->find('all')->contain(['Classes', 'Sections', 'Boards'])->where(['Students.id' => $id, 'Students.acedmicyear' => $acedemic])->first();
  //   pr($acedemic);exit;
  //   $this->set(compact('students'));

  //   if (empty($students)) {
  //     $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where(['DropOutStudent.s_id' => $id, 'DropOutStudent.acedmicyear' => $acedemic, 'DropOutStudent.status' => 'Y'])->first();

  //     $this->set(compact('students'));
  //   }

  //   $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedemic, 'Studentfees.id' => $idf])->first();
  //   // pr($student_datas);die;

  //   $this->set('studentfees', $student_datas);
  // }

  // updated code 
  public function newprintsadmission($recieptId = null)
  {

    $this->viewBuilder()->layout('ajax');

    $this->response->type('pdf');
    $ert = base64_decode($quater);
    $this->sitesetting('receipt');
    // pr($acedemic); die;/
    $db = $this->Users->find()->where(['role_id' => 1])->first();

    $get_managesettings = $this->getmanagesettings($db['db']);
    $this->set(compact('db', 'get_managesettings'));
    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.id' => $recieptId])->first();
    $student_id = $student_datas['student_id'];
    $quater = [$ert];

    // $students = $this->Students->find('all')->contain(['Classes', 'Sections', 'Boards'])->where(['Students.id' => $student_id, 'Students.acedmicyear' => $acedemic])->first();

    $students = $this->Students->find('all')->contain(['Classes', 'Sections', 'Boards'])->where(['Students.id' => $student_id])->first();
    // pr($students); die;

    if (empty($students)) {
      // $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where(['DropOutStudent.s_id' => $student_id, 'DropOutStudent.acedmicyear' => $acedemic, 'DropOutStudent.status' => 'Y'])->first();

      $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections', 'Boards'])->where(['DropOutStudent.s_id' => $student_id, 'DropOutStudent.status' => 'Y'])->first();
    }
    // pr($students);exit;
    $this->set(compact('students'));

    $student_datas = $this->Studentfees->find('all')->where(['Studentfees.id' => $recieptId])->first();
    $this->set('studentfees', $student_datas);
  }

  public function getmanagesettings($dbname = null)
  {
    $conn = ConnectionManager::get('default');
    $db_name = DB_NAME;
    $find = "SELECT * FROM $db_name.`managesettings` where db_name='$dbname'";
    $run = $conn->execute($find)->fetch('assoc');
    // pr($exicute);die;
    return $run;
  }
}
