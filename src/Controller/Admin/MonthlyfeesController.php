<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

class MonthlyfeesController extends AppController
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
    public function index($id = null, $academic_year = null)
    {
        $this->viewBuilder()->layout('admin');
        $db = $this->Users->find()->where(['role_id' => 1])->first();
        $this->set(compact('db'));
        $discountCategorylist = $this->DiscountCategory->find('all', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->where(['status' => 'Y', 'type !=' => '1'])->order(['id' => 'ASC'])->toArray();
        $this->set('discountCategorylist', $discountCategorylist);

        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        if ($rolepresent == '1') {

            $student = $this->Students->find('all')->contain(['Houses', 'Classes', 'Sections'])->where(['Students.id' => $id, 'Students.status' => 'Y'])->first();
            $this->set('students', $student_data);

        } else if ($rolepresent == '5') {
            $student = $this->Students->find('all')->contain(['Houses', 'Classes', 'Sections'])->where(['Students.id' => $id, 'Students.board_id' => '1'])->first();
            $this->set('students', $student_data);
        } else if ($rolepresent == '8') {
            $boards = ['2', '3'];
            $student = $this->Students->find('all')->contain(['Houses', 'Classes', 'Sections'])->where(['Students.id' => $id, 'Students.board_id IN' => $boards])->first();
        }
        $fathername = $student['fathername'];
        $mothername = $student['mothername'];
        $siblings = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.fathername' => $fathername, 'Students.mothername' => $mothername, 'Students.id NOT IN' => $id, 'Students.status' => 'Y'])->toarray();
        // Excluding special fees
        $notSpecialFees = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $academic_year, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0'])->toarray();
        //Student Paid Fees
        $studentfees = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $academic_year, 'Studentfees.status' => 'Y'])->toarray();
        $studentPaidHeads = [];
        foreach ($studentfees as $studentfee) {
            $studentPaidHeads = array_merge($studentPaidHeads, unserialize($studentfee['quarter']));
        }
        //Class Fee Structure
        $classFees = $this->Classfee->find('all')->contain(['Feesheads'])->where(['class_id' => $student['class_id'], 'board_id' => $student['board_id'], 'academic_year' => $academic_year])->order(['Classfee.id' => 'DESC'])->toarray();
        //Student Discount Applicable
        if ($student['is_discount'] == 1 && !empty($student['discountcategory'])) {
            $discountCategory = $student['discountcategory'];
            $discountHeads = $this->DiscountCategory->find('all')->where(['name' => $student['discountcategory']])->first();
            $feesHeadDiscount = unserialize($discountHeads['fh_id']);
            $fixedDiscount = unserialize($discountHeads['discount']);
            $studentDiscount = [];
            foreach ($feesHeadDiscount as $headId => $discount) {
                $feeHeadName = $this->Feesheads->find()->where(['id' => $headId])->first()->name;
                $feehHeadFees = $this->Classfee->find('all')->contain(['Feesheads'])->where(['Classfee.class_id' => $student['class_id'], 'Classfee.board_id' => $student['board_id'], 'Classfee.academic_year' => $academic_year, 'Feesheads.id' => $headId])->first()->qu1_fees;
                if ($discount != '0') {
                    $studentDiscount[$feeHeadName] = $feehHeadFees * $discount / 100;
                } else if (!empty($fixedDiscount[$headId])) {
                    $studentDiscount[$feeHeadName] = $fixedDiscount[$headId];
                } else {
                    $studentDiscount[$feeHeadName] = 0;
                }
            }
        }

        // Student Pending Fees
        $studentFeePendings = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $id, 'Studentfeepending.status' => 'N'])->toarray();

        // Fees Head list
        $feeHeads = $this->Feesheads->find('all', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->where(['status' => 'Y', 'type IN' => ['3', '0'], 'sort !=' => '0'])->order(['name' => 'ASC'])->toArray();

        //Practical Fees
        $practicalFee = "";
        if ($student['class_id'] == 12 || $student['class_id'] == 13 || $student['class_id'] == 15 || $student['class_id'] == 17 || $student['class_id'] == 20 || $student['class_id'] == 22 || $student['class_id'] == 26 || $student['class_id'] == 27) {
            $practicalFee = $this->Feesheads->find('all')->where(['id' => 5])->first();
            if ($student['board_id'] == '1') {
                $practicalFee = $practicalFee['cbse_fee'];
            } else if ($student['board_id' == '2']) {
                $practicalFee = $practicalFee['cambridge_fee'];
            } else if ($student['board_id' == '3']) {
                $practicalFee = $practicalFee['ibdp_fee'];
            }
        }

        //Per Day fine
        $perDayFine = $this->Users->find()->where(['role_id' => 1])->first()->latefee;
        $this->set(compact('student', 'siblings', 'academic_year', 'studentfees', 'classFees', 'id', 'studentPaidHeads', 'studentDiscount', 'studentFeePendings', 'discountCategory', 'feeHeads', 'practicalFee', 'perDayFine'));

    }

    public function cancelledstudent()
    {

        if ($this->request->is(['post', 'put'])) {
            $id = $this->request->data['id'];
            $acedmicyear = $this->request->data['academicyear'];
            $remarsks = $this->request->data['remarks'];
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

                $this->Flash->success(__('Student Fee Cancelled Sucessfully!!'));
                return $this->redirect(['action' => 'index/' . $studid . '/' . $acedmicyear . '/?id=personal']);

            }
        }

    }

    public function save_fee(){
        $studentsall = $this->Students->find('all')->where(['Students.status' =>'Y'])->order(['Students.id' => 'ASC'])->toarray();
        $conn = ConnectionManager::get('default');
foreach($studentsall as $key=>$item){

  $str2 = "a:1:{s:13:\"Admission Fee\";s:4:\"6000\";}";
  $conn->execute("INSERT INTO  `student_feeallocations`(`student_id`,`recipetno`,`formno`,`type`,`paydate`,`quarter`,`mode`,`bank`,
    `cheque_no`,`created`,`is_discount`,`fee`,`discountcategory`,`discount`,`addtionaldiscount`,`deposite_amt`,`ref_no`,`refrencepending`,
    `status`,`remarks`,`acedmicyear`,`lfine`,`token`) VALUES ('".$item['id']."', '0', '0', 'Fee', '2020-05-02', '$str2', 'CASH', '', '', '2020-05-12 17:59:09', '0', '6000', '', '', '0', '6000', '0', '0', 'Y', '', '2020-21', '0', '5eba968805f6f')");

   
}

echo "done"; die;
    }
    public function add()
    {
        if ($this->request->is('post')) {
            $amount = "";
            $exists2 = $this->Studentfees->exists(['token' => $this->request->data['token'], 'student_id' => $this->request->data['student_id']]);
            if ($exists2) {
                $this->redirect(['controller' => 'Monthlyfees', 'action' => 'index/' . $student_id . '/' . $acedmicyear]);
            }
            $maxReceiptNum = $this->Studentfees->find('all')->select(['num' => 'MAX(Studentfees.recipetno)'])->first();
            if (!empty($this->request->data['is_special']) && $this->request->data['is_special'] == '1') {
                $specialFees = $this->request->data['special'];
                if (!empty($specialFees)) {
                    $data = $this->Studentfees->newEntity();
                    $data['student_id'] = $this->request->data['student_id'];
                    $data['recipetno'] = 0;
                    $data['formno'] = 0;
                    $data['type'] = 'Fee';
                    $data['paydate'] = date('Y-m-d', strtotime($this->request->data['paydate']));
                    $data['quarter'] = serialize($specialFees);
                    $data['mode'] = 'CASH';
                    $data['bank'] = '';
                    $data['cheque_no'] = '';
                    $data['fee'] = array_sum($specialFees);
                    $data['discountcategory'] = '';
                    $data['discount'] = '';
                    $data['addtionaldiscount'] = 0;
                    $data['deposite_amt'] = array_sum($specialFees);
                    $data['ref_no'] = 0;
                    $data['refrencepending'] = 0;
                    $data['remarks'] = $this->request->data['remarks'];
                    $data['cheque_no'] = '';
                    $data['lfine'] = 0;
                    $data['acedmicyear'] = $this->request->data['acedmicyear'];
                    $data['token'] = $this->request->data['token'];
                    if ($fees = $this->Studentfees->save($data)) {
                        $this->request->session()->write('openfess_recipt', 'printsadmission');
                        $this->request->session()->write('openfess_recipt2', $fees['id']);
                        $this->request->session()->write('openfess_recipt5', $this->request->data['acedmicyear']);
                        return $this->redirect(['controller' => 'Studentfees', 'action' => 'view/' . $this->request->data['student_id']]);
                    }
                } else {
                    $this->Flash->error(__('Please remove atleast one head for special Entry'));
                    return $this->redirect($this->referer());
                }
            }

            if (!empty($this->request->data['amount'])) {
                $amount = $this->request->data['amount'];
            }
            if (!empty($this->request->data['pending'])) {
                $ref = '"' . $this->request->data['pending']['reference_id'] . '"';
                $amount[$ref] = $this->request->data['pending']['amount'];
                $feePending = $this->Studentfeepending->find('all')->where(['id' => $this->request->data['pending']['id']])->first();
                if (!empty($feePending)) {
                    $feePending->status = 'Y';
                    $this->Studentfeepending->save($feePending);
                }
            }
            if (!empty($this->request->data['otherfee'])) {
                foreach ($this->request->data['otherfee'] as $otherfee) {
                    $name = $this->Feesheads->find()->where(['id' => $otherfee[0]])->first()->name;
                    $amount[$name] = $otherfee[1];
                }
            }

            $data = $this->Studentfees->newEntity();
            $data['student_id'] = $this->request->data['student_id'];
            $data['recipetno'] = $maxReceiptNum + 1;
            $data['formno'] = 0;
            $data['type'] = 'Fee';
            $data['paydate'] = date('Y-m-d', strtotime($this->request->data['paydate']));
            $data['quarter'] = serialize($amount);
            $data['mode'] = $this->request->data['mode'];
            $data['bank'] = $this->request->data['mode'];
            $data['cheque_no'] = $this->request->data['cheque_no'];
            $data['fee'] = array_sum($amount);
            $data['discountcategory'] = $this->request->data['discountcategorys'];
            $data['discount'] = $this->request->data['discount'];
            $data['addtionaldiscount'] = $this->request->data['addtionaldiscount'];
            $data['deposite_amt'] = $this->request->data['deposite_amt'];
            $data['ref_no'] = $this->request->data['ref_no'];
            $data['refrencepending'] = 0;
            $data['remarks'] = $this->request->data['remarks'];
            $data['cheque_no'] = $this->request->data['bank_id'];
            $data['lfine'] = $this->request->data['lfine'];
            $data['acedmicyear'] = $this->request->data['acedmicyear'];
            $data['token'] = $this->request->data['token'];
            if ($fees = $this->Studentfees->save($data)) {
                if (!empty($this->request->data['dueextra']) && $this->request->data['dueextra'] != '0') {
                    $newPending = $this->Studentfeepending->newEntity();
                    $newPending['s_id'] = $this->request->data['student_id'];
                    $newPending['r_id'] = $fees['id'];
                    $newPending['amt'] = $this->request->data['dueextra'];
                    $newPending['status'] = 'N';
                    $this->Studentfeepending->save($newPending);
                }
                $this->request->session()->write('openfess_recipt', 'printsadmission');
                $this->request->session()->write('openfess_recipt2', $fees['id']);
                $this->request->session()->write('openfess_recipt5', $this->request->data['acedmicyear']);
                return $this->redirect(['controller' => 'Studentfees', 'action' => 'view/' . $this->request->data['student_id']]);
            } else {
                $this->Flash->error(__('Error'));
                return $this->redirect($this->referer());
            }
        }
    }
}
