<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use MyClass\MyClass;

include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

class StudentsController extends AppController
{
    public $helpers = ['CakeJs.Js'];

    public function setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    public function initialize()
    {
        parent::initialize();

        //load all models
        $this->loadModel('Boards');
        $this->loadModel('Board');
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
        $this->loadModel('Staffattends');
        $this->loadModel('Studentfeepending');
        $this->loadModel('Classfee');
        $this->loadModel('Studattends');
        $this->loadModel('DiscountCategory');
        $this->loadModel('Disabilitys');
        $this->loadModel('Smsmanager');
        $this->loadModel('Smsdelivery');
        $this->loadModel('Smsdeliverydetails');
        $this->loadModel('AdmissionClasses');
        $this->loadModel('Sms');
        $this->loadModel('DropOutStudent');
        $this->loadModel('Sitesettings');
        $this->loadModel('Students');
        $this->loadModel('DropoutApproval');
        $this->loadModel('Feesheads');
        $this->loadModel('CertificatesApproval');
        $this->loadModel('Interaction');
        $this->loadModel('StudentShuffles');
        $this->loadModel('StudentRestores');
        $this->loadModel('AcademicYear');
        $this->loadModel('HostelFeesManagement');


        require_once 'Firebase.php';
        require_once 'Push.php';
        $this->Auth->allow(['transfer_certificate_pdf', 'branch_admissions_index']);
    }

    public function connection($dbs)
    {
        //echo $dbs; die;
        ConnectionManager::config($dbs, [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => MYSQLHOST,
            'username' => MYSQLUESRNAME,
            'password' => MYSQLPASSWORD,
            'database' => $dbs,
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
        ]);
        ConnectionManager::drop('default');
        ConnectionManager::get($dbs);
        \Cake\Datasource\ConnectionManager::alias($dbs, 'default');
    }

    public function parent_logindetails_pdf()
    {

        $this->response->type('pdf');
        $conn = ConnectionManager::get('default');
        $detail = "SELECT Students.id,Students.enroll,Students.password,Students.sms_mobile,Students.category,Students.oldenroll,Students.fname,Students.fathername,Students.mothername,Students.middlename,Students.lname,Students.mobile,Students.acedmicyear,Students.class_id,Students.created,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students Right JOIN classes Classes ON Students.`class_id` = Classes.id Right JOIN sections Sections ON Students.`section_id` = Sections.id WHERE Students.`status`='Y' and Students.board_id='1' and '1'='1'";
        if (!empty($_SESSION['parentlogindata'])) {
            $detail = $detail . $_SESSION['parentlogindata'];
        } else {
            $detail = $detail;
        }
        $SQL = $detail . " ORDER BY Classes.sort ASC";
        $results = $conn->execute($SQL)->fetchAll('assoc');
        $this->set('parentpdf', $results);
    }

    public function fetchuserimagesw($tid = null, $val = null, $filename = null)
    {

        $this->autoRender = false;
        $students = $this->Students->find('all')->select(['enroll', 'id', 'file'])->where(['Students.board_id' => 1, 'Students.class_id IN' => ['17', '20', '22'], 'Students.status' => 'Y'])->order(['Students.class_id ASC'])->toarray();
        $cnt = 1;
        foreach ($students as $item) {
            $filename2 = '/var/www/html/idsprime/webroot/sanskarschools/' . $item['enroll'] . '.JPG';
            if (file_exists($filename2)) {

                $randomStringid = $item['enroll'];
                $data = array();
                $data['type'] = "sanskarimg";
                $data['genrateid'] = $item['enroll'];
                $data['file'] = $item['enroll'] . ".JPG";
                $data['types'] = "image/jpeg";
                $ext = pathinfo($data['file'], PATHINFO_EXTENSION);
                $data['ext'] = $ext;
                $http = new Client();
                $response = $http->post('https://bucket.idsprime.com/Pages/uploadidsprimeuserimages', $data);
                if ($randomStringid) {
                    if (strpos($response->body, '<!DOCTYPE html>') === false && strpos($response->body, 'Invalid') === false) {
                        $conns = ConnectionManager::get('default');
                        $img = $item['enroll'] . ".JPG";
                        $id = $item['id'];
                        $conns->execute("UPDATE `students` SET `file`='" . $img . "' WHERE `id`='" . $id . "'");
                    }
                }
                $cnt++;
            }
        }
        echo $cnt . "done";
        die;
    }

    public function addstaffattendance($id = null)
    {
        $this->viewBuilder()->layout('admin');
        if (isset($id) && !empty($id)) {
            //using for edit
            $classes = $this->Staffattends->get($id);
        } else {
            //using for new entry
            $classes = $this->Staffattends->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {
            // pr($this->request->data);die;
            $timestamp = strtotime($this->request->data['date']);
            $weekofday = date("l", $timestamp);
            // pr($weekofday);die;
            $this->request->data['day'] = $weekofday;
            $conn = ConnectionManager::get('default');
            $peopleTable = TableRegistry::get('Staffattends');
            $oquery = $peopleTable->query();
            $academic = $this->request->data['academic'];
            $attedenceall = $this->Staffattends->find('all')->where(['Staffattends.date' => $this->request->data['date'], 'Staffattends.acedemic' => $academic])->toArray();

            if (!empty($attedenceall)) {

                $dater = $this->request->data['date'];
                $conn = ConnectionManager::get('default');
                $conn->execute("DELETE FROM staffattends WHERE acedemic='" . $academic . "'  AND date='" . $dater . "'");
            }
            $stud_id = sizeof($this->request->data['emp_id']);
            // $remark=$this->request->data['remark'];
            $arrstudentfind = array();
            $coordinator = $this->request->session()->read('Auth.User.id');
            for ($i = 0; $i < $stud_id; $i++) {

                $arrstudentfind[] = $this->request->data['emp_id'][$i];
                $statusm = "A";
                $oquery->insert(['emp_id', 'day', 'date', 'status', 'status_m', 'acedemic', 'coordinator_id'])
                    ->values([
                        'emp_id' => $this->request->data['emp_id'][$i],
                        'day' => $weekofday,
                        'date' => $this->request->data['date'],
                        'status' => 'A',
                        'status_m' => $statusm,
                        'acedemic' => $academic,
                        'coordinator_id' => $coordinator
                    ]);
            }
            $d = $oquery->execute();
            if (empty($arrstudentfind)) {
                $studentsarry = $this->Employees->find('all')->where(['Employees.status' => 'Y'])->order(['Employees.fname' => 'ASC'])->order(['Employees.lname' => 'ASC'])->toarray();
            } else {
                $studentsarry = $this->Employees->find('all')->where(['Employees.status' => 'Y', 'Employees.id NOT IN' => $arrstudentfind])->order(['Employees.fname' => 'ASC'])->order(['Employees.lname' => 'ASC'])->toarray();
            }

            if (isset($studentsarry)) {

                $conns = ConnectionManager::get('default');
                $peopleTables = TableRegistry::get('Staffattends');
                $oquerys = $peopleTables->query();
                foreach ($studentsarry as $jkey => $item) {
                    $statusm = "A";
                    $oquerys->insert(['emp_id', 'day', 'remark', 'date', 'status', 'status_m', 'acedemic', 'coordinator_id'])
                        ->values([
                            'emp_id' => $item['id'],
                            'day' => $weekofday,
                            'remark' => '',
                            'date' => $this->request->data['date'],
                            'status' => 'P',
                            'status_m' => $statusm,
                            'acedemic' => $academic,
                            'coordinator_id' => $coordinator
                        ]);
                }
                $ds = $oquerys->execute();
            }

            $this->Flash->success(__('Your Attendence procedure for selected Employees has been Updated.'));
            return $this->redirect(['controller' => 'students', 'action' => 'staffattendance']);
            //validation error
        }
    }

    public function statusdroprequest($id, $status = null)
    {


        $db = $this->request->session()->read('Auth.User.db');
        $parents_db = explode('_', $db);

        if (!empty($id)) {
            $get_stdata = $this->Students->get($id);
            $this->set('student', $get_stdata);
            $this->set(compact('status'));
        }
        if ($this->request->is(['post', 'put'])) {

            $req_data['request_for_drop'] = 'Y';
            $studentdata = $this->Students->patchEntity($get_stdata, $req_data);
            $savedata = $this->Students->save($studentdata);
            $connection_true = $this->connection($parents_db[0]);
            if (!empty($get_stdata['enroll'])) {
                $find_student = $this->DropoutApproval->find('all')->where(['enroll' => $get_stdata['enroll'], 'school_name' => $db])->first();
            } else {
                $find_student = $this->DropoutApproval->find('all')->where(['DropoutApproval.student_id' => $get_stdata['id'], 'school_name' => $db])->first();
            }
            if (!empty($find_student)) {
                $this->Flash->error(__("You have already send Head Branch request for approval"));
                return $this->redirect(['action' => 'index']);
            } else {
                $dropout_data = $this->DropoutApproval->newEntity();
            }

            $all_data['student_id'] = $get_stdata['id'];
            $all_data['enroll'] = $get_stdata['enroll'];
            $all_data['sname'] = ucwords(strtolower($get_stdata['fname'])) . ' ' . ucwords(strtolower($get_stdata['middlename'])) . ' ' . ucwords(strtolower($get_stdata['lname']));
            $all_data['description'] = ucwords(strtolower($this->request->data['description']));
            $all_data['school_name'] = $db;
            $all_data['section_id'] = $get_stdata['section_id'];
            $all_data['class_id'] = $get_stdata['class_id'];
            $all_data['certificate_type'] = 'Drop';
            $all_data['dob'] = date('Y-m-d', strtotime($get_stdata['dob']));
            $savedropoutdata = $this->DropoutApproval->patchEntity($dropout_data, $all_data);
            pr($all_data);
            die;
            if ($this->DropoutApproval->save($savedropoutdata)) {
                $this->Flash->success(__("Request has been send Head Branch for approval process"));
                return $this->redirect(['action' => 'index']);
            } else {
                //check validation error
                if ($get_stdata->errors()) {
                    $error_msg = [];

                    foreach ($get_stdata->errors() as $errors) {
                        if (is_array($errors)) {
                            foreach ($errors as $error) {
                                $error_msg[] = $error;
                            }
                        } else {
                            $error_msg[] = $errors;
                        }
                    }

                    if (!empty($error_msg)) {
                        $this->Flash->error(__("Please fix the following error(s): " . implode("\n \r", $error_msg)));
                    }
                }
            }
        }
    }

    public function dropout_approval()
    {
        $this->viewBuilder()->layout('admin');
        $student_data = $this->DropoutApproval->find('all')->order(['DropoutApproval.created' => 'DESC'])->toarray();

        $classes = $this->Classes->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $this->set('students', $student_data);
        $this->set('classes', $classes);
    }

    public function search_dropout_approval()
    {

        $datefrom = date('Y-m-d', strtotime($this->request->data['datefrom']));
        $dateto = date('Y-m-d', strtotime($this->request->data['dateto']));
        $school_name = trim($this->request->data['school_name']);
        $student_name = trim($this->request->data['name']);

        $apk = array();

        if (!empty($datefrom) && $datefrom != '1970-01-01') {
            $stts = array('DropoutApproval.created >=' => $datefrom);

            $apk[] = $stts;
        }

        if (!empty($dateto) && $dateto != '1970-01-01') {
            $stst = array('DropoutApproval.created <=' => $dateto);
            $apk[] = $stst;
        }

        if (!empty($student_name) && $student_name != ' ') {
            $pii = array('DropoutApproval.sname LIKE' => '%' . $student_name . '%');
            $apk[] = $pii;
        }

        if (!empty($school_name) && $school_name != ' ') {
            $pii = array('DropoutApproval.school_name LIKE' => '%' . $school_name . '%');
            $apk[] = $pii;
        }

        $approval_data = $this->DropoutApproval->find('all')->where($apk)->order(['DropoutApproval.id' => 'DESC'])->toarray();

        $this->set('students', $approval_data);
    }

    public function fetchuserimages($tid = null, $val = null, $filename = null)
    {
        $this->autoRender = false;
        $students = $this->DropOutStudent->find('all')->select(['enroll', 'id', 'file'])->where(['DropOutStudent.board_id' => 3])->order(['DropOutStudent.class_id ASC'])->toarray();
        $cnt = 1;
        foreach ($students as $item) {

            $filename2 = '/var/www/html/idsprime/webroot/sanskarschools/IB' . $item['enroll'] . '.JPG';

            if (file_exists($filename2)) {

                $randomStringid = $item['enroll'];

                $data = array();

                $data['type'] = "sanskarimg";

                $data['genrateid'] = "IB" . $item['enroll'];

                $data['file'] = "IB" . $item['enroll'] . ".JPG";

                $data['types'] = "image/jpeg";
                $ext = pathinfo($data['file'], PATHINFO_EXTENSION);

                $data['ext'] = $ext;
                $http = new Client();

                $response = $http->post('https://bucket.idsprime.com/Pages/uploadidsprimeuserimages', $data);

                if ($randomStringid) {

                    if (strpos($response->body, '<!DOCTYPE html>') === false && strpos($response->body, 'Invalid') === false) {

                        $conns = ConnectionManager::get('default');
                        $img = "IB" . $item['enroll'] . ".JPG";
                        $id = $item['id'];
                        $conns->execute("UPDATE `drop_out_students` SET `file`='" . $img . "' WHERE `id`='" . $id . "'");
                    }
                }

                $cnt++;
            }
        }

        echo $cnt . "done";
        die;
    }

    // change role id to role name
    public function sendsmsall()
    {
        $this->autoRender = false;
        if ($this->request->is(['post', 'put'])) {

            $mesg = $this->request->data['message'];
            $category = $this->request->data['category'];
            $smstemp = $this->Smsmanager->find('all')->select(['id'])->where(['category' => $category])->order(['id' => 'ASC'])->first();
            $smstemp_id = $smstemp['id'];

            $rolepresent = $this->request->session()->read('Auth.User.role_id');
            // pr($rolepresent); die;
            if ($rolepresent == ADMIN && $rolepresent == CENTER_COORDINATOR) {
                $baord = array('1', '2', '3');
            } elseif ($rolepresent == CBSE_FEE_COORDINATOR) {
                $baord = array('1');
            } elseif ($rolepresent == '8') {
                $baord = array('2', '3');
            }

            $students = $this->Students->find('all')->select(['sms_mobile', 'id', 'token'])->where(['Students.board_id IN' => $baord, 'Students.status' => 'Y'])->order(['Students.class_id ASC'])->toarray();
            // pr($students); die;
            $romsm = sizeof($students);

            if ($mesg) {

                $connsssks = ConnectionManager::get('default');

                $mesg1 = addslashes($mesg);
                $connsssks->execute("INSERT INTO
				`sms_deliveries`(`sms_temp_id`, `message`, `total_students`,`status`) VALUES
				('" . $smstemp_id . "','" . $mesg1 . "','" . $romsm . "','Y')");
                $smsconfig = $this->Sms->find('all')->where(['id' => '1'])->order(['id' => 'ASC'])->first();
                $workingkey = $smsconfig['workingkey'];
                $sender = $smsconfig['sender'];
                $smsdelivery = $this->Smsdelivery->find('all')->select(['id'])->order(['id' => 'DESC'])->first();
                foreach ($students as $s => $students) {
                    $result = '';

                    $mobile = $students['sms_mobile'];
                    //$mobile='9694027991';

                    // $result = $this->file_get_contents_curl('http://alerts.prioritysms.com/api/web2sms.php?workingkey=' . $workingkey . '&to=' . $mobile . '&sender=' . $sender . '&message=' . urlencode($mesg));

                    $result = $this->whatsappmsg($mobile, $mesg);
                    //  pr($result); die;

                    if ($result == "Invalid Input Data") {
                        $connsssks1 = ConnectionManager::get('default');
                        date_default_timezone_set('Asia/Kolkata');
                        $date = date('Y-m-d H:i:s');

                        $connsssks1->execute("INSERT INTO
				`sms_deliveries_details`(`stud_id`,`smsmobile`, `sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES
				('" . $students['id'] . "','" . $students['sms_mobile'] . "','" . $smsdelivery['id'] . "','" . $smstemp_id . "','" . $date . "','N')");
                    } elseif ($result == "Invalid Mobile Numbers") {
                        $connsssks2 = ConnectionManager::get('default');
                        date_default_timezone_set('Asia/Kolkata');
                        $date = date('Y-m-d H:i:s');

                        $connsssks2->execute("INSERT INTO
				`sms_deliveries_details`(`stud_id`, `smsmobile`,`sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES
				('" . $students['id'] . "','" . $students['sms_mobile'] . "','" . $smsdelivery['id'] . "','" . $smstemp_id . "','" . $date . "','N')");
                    } elseif ($result == "Insufficient credits") {

                        $connsssks3 = ConnectionManager::get('default');
                        date_default_timezone_set('Asia/Kolkata');
                        $date = date('Y-m-d H:i:s');

                        $connsssks3->execute("INSERT INTO
				`sms_deliveries_details`(`stud_id`, `smsmobile`,`sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES
				('" . $students['id'] . "','" . $students['sms_mobile'] . "','" . $smsdelivery['id'] . "','" . $smstemp_id . "','" . $date . "','N')");

                        $this->Flash->error(__('Insufficient credits, Please Contact to Web Administrator !!!!.'));
                        return $this->redirect(['action' => 'index']);
                    } else {

                        $connsssks = ConnectionManager::get('default');
                        date_default_timezone_set('Asia/Kolkata');
                        $date = date('Y-m-d H:i:s');

                        $connsssks->execute("INSERT INTO
				`sms_deliveries_details`(`stud_id`, `smsmobile`, `sms_deliv_id`, `sms_temp_id`,`created`) VALUES
				('" . $students['id'] . "','" . $students['sms_mobile'] . "','" . $smsdelivery['id'] . "','" . $smstemp_id . "','" . $date . "')");
                    }
                    $_POST['title'] = 'Sanskar Campus';
                    $_POST['body'] = $mesg;

                    $push = null;
                    $push = new \Push(
                        $_POST['title'],
                        $_POST['body']
                    );

                    $mPushNotification = $push->getPush();

                    $firebase = new \Firebase();

                    $_POST['data'] = ["route" => "Notice Board"];

                    $firebase->send($toke, $mPushNotification, $_POST['data']);
                }

                $this->Flash->success(__('Send SMS to All Student sucessfully.'));
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    // change role id to role name
    public function genrateotp()
    {
        $this->autoRender = false;
        $stuid = $this->request->data['student_id'];

        $student_data1 = $this->Students->find('all')->where(['Students.id' => $stuid])->order(['Students.id' => 'ASC'])->toarray();
        if (!empty($student_data1)) {
            $uid = $this->request->session()->read('Auth.User.id');
            $user = $this->Users->find('all')->where(['Users.id' => $uid, 'role_id IN' => [CBSE_FEE_COORDINATOR, INTERNATIONAL_FEE_COORDINATOR]])->first();
            if (!empty($user)) {
                $mobile = trim($user['mobile']);
                $otp = rand(1001, 9999);
                $success = 0;
                $mesg = "Your One Time Password for Sanskar School Discount Update is " . $otp;

                $smsconfig = $this->Sms->find('all')->where(['id' => '1'])->order(['id' => 'ASC'])->first();
                $workingkey = $smsconfig['workingkey'];
                $sender = $smsconfig['sender'];
                $result = $this->file_get_contents_curl('http://alerts.prioritysms.com/api/web2sms.php?workingkey=' . $workingkey . '&to=' . $mobile . '&sender=' . $sender . '&message=' . urlencode($mesg));

                $conns = ConnectionManager::get('default');
                $conns->execute("UPDATE `users` SET `otp`='" . $otp . "' WHERE `id`='" . $uid . "'");
                echo $result;
                die;
            }
        }
    }
    // change role id to role name
    public function defaultersendsms()
    {
        // pr($this->request->data); die;
        $this->autoRender = false;
        if ($this->request->is(['post', 'put'])) {

            $mesg = $this->request->data['message'];
            $category = $this->request->data['category'];
            $smstemp = $this->Smsmanager->find('all')->select(['id'])->where(['category' => $category])->order(['id' => 'ASC'])->first();
            $smstemp_id = $smstemp['id'];
            $romsm = sizeof($this->request->data['p_id']);
            // pr($romsm); die;/
            //---------------sms count and manage------------------------//

            $dbname = $this->request->session()->read('Auth.User.db');
            $branch = explode("_", $dbname);
            $db = $branch[0];

            if ($db == 'canvas') {
                $connss = ConnectionManager::get('default');
                $query2 = "SELECT * FROM $db.users ";
                $res = $connss->execute($query2)->fetchAll('assoc');
            } else {
                $id = $this->request->session()->read('Auth.User.c_id');
                $res = $this->Users->find('all')->where(['c_id' => $id])->toArray();
            }
            $user_id = $res[0]['c_id'];
            $connss = ConnectionManager::get('default');
            $db_name = DB_NAME;
            $query2 = "SELECT * FROM $db_name.schools where id= $user_id ";
            $resss = $connss->execute($query2)->fetchAll('assoc');
            // pr($resss); die;
            $sent_msg = $resss[0]['msg_count'];
            $clint_id = $resss[0]['id'];
            $total_sent = $sent_msg - $romsm;
            // agere whatsapp api nhi hoto error show code
            if (empty($resss[0]['whatsapp_token'])) {
                $this->Flash->error(__('Kindly contact to administrators.'));
                return $this->redirect(['action' => 'index']);
            }
            if ($sent_msg >= $romsm) {
                $conn = ConnectionManager::get('default');
                $conn->execute("UPDATE $db_name.`schools` SET `msg_count`='$total_sent' WHERE id='$clint_id'");
            }
            //---------------sms count and manage code end------------------------//
            $rolepresent = $this->request->session()->read('Auth.User.role_id');
            if ($rolepresent == ADMIN || $rolepresent == CENTER_COORDINATOR) {
                $baord = array('1', '2', '3');
            } elseif ($rolepresent == CBSE_FEE_COORDINATOR) {
                $baord = array('1');
            } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
                $baord = array('2', '3');
            }
            if ($mesg) {
                $connsssks = ConnectionManager::get('default');
                $mesg1 = addslashes($mesg);
                $connsssks->execute("INSERT INTO
				`sms_deliveries`(`sms_temp_id`, `message`, `total_students`,`status`) VALUES
				('" . $smstemp_id . "','" . $mesg1 . "','" . $romsm . "','Y')");
                $toke = array();
                $smsdelivery = $this->Smsdelivery->find('all')->select(['id'])->order(['id' => 'DESC'])->first();
                // msg low balance count and validate
                if ($sent_msg >= $romsm) {
                    for ($is = 0; $is < $romsm; $is++) {
                        $result = '';
                        $students = $this->Students->find('all')->select(['sms_mobile', 'id'])->where(['Students.enroll' => $this->request->data['p_id'][$is], 'Students.board_id IN' => $baord, 'Students.status' => 'Y'])->order(['Students.id DESC'])->first();
                        $mobile = $students['sms_mobile'];
                        $mobiless = '+91' . $mobile;
                        //$mobile='9636293152';
                        $smsconfig = $this->Sms->find('all')->where(['id' => '1'])->order(['id' => 'ASC'])->first();
                        $workingkey = $smsconfig['workingkey'];
                        $sender = $smsconfig['sender'];
                        // $result = $this->file_get_contents_curl('http://alerts.prioritysms.com/api/web2sms.php?workingkey=' . $workingkey . '&to=' . $mobile . '&sender=' . $sender . '&message=' . urlencode($mesg));
                        $result = $this->whatsappmsg($mobiless, $mesg);
                        // pr($result); die;
                        if ($result == "Invalid Input Data") {
                            $connsssks1 = ConnectionManager::get('default');
                            date_default_timezone_set('Asia/Kolkata');
                            $date = date('Y-m-d H:i:s');
                            $connsssks1->execute("INSERT INTO
				`sms_deliveries_details`(`stud_id`,`smsmobile`, `sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES
				('" . $students['id'] . "','" . $students['sms_mobile'] . "','" . $smsdelivery['id'] . "','" . $smstemp_id . "','" . $date . "','N')");
                        } elseif ($result == "Invalid Mobile Numbers") {
                            $connsssks2 = ConnectionManager::get('default');
                            date_default_timezone_setloadModel('Asia/Kolkata');
                            $date = date('Y-m-d H:i:s');
                            $connsssks2->execute("INSERT INTO
				`sms_deliveries_details`(`stud_id`, `smsmobile`,`sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES
				('" . $students['id'] . "','" . $students['sms_mobile'] . "','" . $smsdelivery['id'] . "','" . $smstemp_id . "','" . $date . "','N')");
                        } elseif ($result == "Insufficient credits") {
                            $connsssks3 = ConnectionManager::get('default');
                            date_default_timezone_set('Asia/Kolkata');
                            $date = date('Y-m-d H:i:s');
                            $connsssks3->execute("INSERT INTO
				`sms_deliveries_details`(`stud_id`, `smsmobile`,`sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES
				('" . $students['id'] . "','" . $students['sms_mobile'] . "','" . $smsdelivery['id'] . "','" . $smstemp_id . "','" . $date . "','N')");
                            $this->Flash->error(__('Insufficient credits,Please Contact to Web Administrator !!!!.'));
                            return $this->redirect(['action' => 'index']);
                        } else {
                            $connsssks = ConnectionManager::get('default');
                            date_default_timezone_set('Asia/Kolkata');
                            $date = date('Y-m-d H:i:s');
                            $connsssks->execute("INSERT INTO
				`sms_deliveries_details`(`stud_id`, `smsmobile`, `sms_deliv_id`, `sms_temp_id`,`created`) VALUES
				('" . $students['id'] . "','" . $students['sms_mobile'] . "','" . $smsdelivery['id'] . "','" . $smstemp_id . "','" . $date . "')");
                        }
                    }
                } else {
                    $this->Flash->error(__('insufficient credits balance please recharge to continue!!.'));
                    return $this->redirect(['action' => 'index']);
                }

                $this->Flash->success(__('Send SMS to Student sucessfully.'));
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    public function findlname()
    {
        $data = array();

        $request = mysqli_real_escape_string($this->request->data["query"]);
        $data[] = "Kumar";
        echo json_encode($data);
        die;
    }

    public function addmission_recipt($id)
    {

        $classes_data = $this->Students->find('all')->order([
            'Students.id' =>
            'DESC'
        ])->contain(['Classes'])->where(['Students.id' => $id, 'Students.status' => 'Y'])->first()->toarray();
        //pr($classes_data); die;
        $this->set('students', $classes_data);
        $user = $this->Users->find('all')->where(['Users.role_id' => ADMIN])->first();
        $acedmicyear = $user['academic_year'];

        $this->set('acedmicyear', $acedmicyear);
        $rt = $classes_data['board_id'];

        if ($rt == '1') {

            $nj = $this->Feesheads->find('all')->where(['Feesheads.id' => '7'])->first()->toarray();

            $this->set('admissionfee', $nj['cbse_fee']);

            $njde = $this->Feesheads->find('all')->where(['Feesheads.id' => '3'])->first()->toarray();

            $this->set('devlopfee', $njde['cbse_fee']);

            $njcaution = $this->Feesheads->find('all')->where(['Feesheads.id' => '4'])->first()->toarray();

            $this->set('cautionfee', $njcaution['cbse_fee']);
        } elseif ($rt == '2') {

            $nj = $this->Feesheads->find('all')->where(['Feesheads.id' => '7'])->first()->toarray();

            $this->set('admissionfee', $nj['cambridge_fee']);

            $njde = $this->Feesheads->find('all')->where(['Feesheads.id' => '3'])->first()->toarray();

            $this->set('devlopfee', $njde['cambridge_fee']);

            $njcaution = $this->Feesheads->find('all')->where(['Feesheads.id' => '4'])->first()->toarray();

            $this->set('cautionfee', $njcaution['cbse_fee']);
        } elseif ($rt == '3') {

            $nj = $this->Feesheads->find('all')->where(['Feesheads.id' => '7'])->first()->toarray();

            $this->set('admissionfee', $nj['ibdp_fee']);

            $njde = $this->Feesheads->find('all')->where(['Feesheads.id' => '3'])->first()->toarray();

            $this->set('devlopfee', $njde['ibdp_fee']);

            $njcaution = $this->Feesheads->find('all')->where(['Feesheads.id' => '4'])->first()->toarray();

            $this->set('cautionfee', $njcaution['cbse_fee']);
        }

        $brhy = $this->Boards->find('all')->order(['Boards.id' => 'DESC'])->where(['Boards.id' => $rt])->first()->toarray();

        $this->set('brd', $brhy);
    }
    // change role id to name 
    public function discount($id = null)
    {
        $discountCategorylist = $this->DiscountCategory->find('all', [
            'keyField' => 'discount',
            'valueField' => 'name',
        ])->where(['status' => 'Y', 'type' => '0'])->order(['id' => 'ASC'])->toArray();
        $this->set('discountCategorylist', $discountCategorylist);

        if (isset($id) && !empty($id)) {
            $this->set('ids', $id);
            $discount = $this->Students->get($id);
            $acedemic = $discount->acedmicyear;
            $h_id = $discount->h_id;
            $discountcategory_id = $discount->discountcategory;
            $this->set('acedemic', $acedemic);
            $this->set('h_id', $h_id);
            $this->set('discountcategory', $discountcategory_id);
        } else {
            $discount = $this->Students->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {

            $uid = $this->request->session()->read('Auth.User.id');

            $userTable2s = TableRegistry::get('Users');
            $exists2s = $userTable2s->exists(['otp' => $this->request->data['otp'], 'id' => $uid, 'role_id IN' => [CBSE_FEE_COORDINATOR, INTERNATIONAL_FEE_COORDINATOR]]);
            if ($exists2s) {
                $this->request->data['is_discount'] = 1;
                $dcategory = $this->request->data['discountcategory'];
                $this->request->data['discountcategory'] = $dcategory;
                $discount = $this->Students->patchEntity($discount, $this->request->data);
                if ($this->Students->save($discount)) {
                    $this->Flash->success(__('Discount Added Successfully.'));
                    return $this->redirect(['controller' => 'studentfees', 'action' => 'view']);
                }
            } else {
                $this->Flash->error(__('Wrong or Mismatch OTP Entered by Coordinator.'));
                return $this->redirect(['controller' => 'studentfees', 'action' => 'view']);
            }
        }
        $this->set('discount', $discount);
    }

    public function applicant_recipt_delete($id)
    {

        $classes_data = $this->Applicant->find('all')->where(['Applicant.id' => $id])->first();
        $student_data = $this->Students->find('all')->where(['Students.formno' => $classes_data['sno'], 'Students.status' => 'Y'])->first();
        if ($student_data['id']) {
            $this->Flash->error(__("Form no is already associated with Admission."));
            return $this->redirect(['action' => 'approvedprospect']);
        } else {
            $conn = ConnectionManager::get('default');
            $conn->execute("DELETE FROM applicants WHERE id='" . $id . "'");
            $this->Flash->success(__("Register Student has been delete sucessfully."));
            return $this->redirect(['action' => 'approvedprospect']);
        }
        die;
    }

    //status update functionality
    public function applicant_status($id, $status)
    {
        if (isset($id) && !empty($id)) {
            if ($status == 'Y') {

                $status = 'Y';
                //status update
                $enquires = $this->Applicant->get($id);
                $conn = ConnectionManager::get('default');
                $formno = $enquires->sno;
                $recipietno = $enquires->recipietno;
                $conn->execute("update student_feeallocations set status='$status' where recipetno='$recipietno' and formno='$formno'");
                $enquires->status_c = $status;
                if ($this->Applicant->save($enquires)) {
                    $this->Flash->success(__('Your Applicant status has been Deactivated.'));
                    return $this->redirect(['controller' => 'report', 'action' => 'prospect']);
                }
            } else {
                $status = 'N';
                //status update
                $enquires = $this->Applicant->get($id);
                $conn = ConnectionManager::get('default');
                $formno = $enquires->sno;
                $recipietno = $enquires->recipietno;
                $conn->execute("update student_feeallocations set status='$status' where recipetno='$recipietno' and formno='$formno'");
                $enquires->status_c = $status;
                if ($this->Applicant->save($enquires)) {
                    $this->Flash->success(__('Your Applicant status has been Activated.'));
                    return $this->redirect(['controller' => 'report', 'action' => 'prospect']);
                }
            }
        }
    }

    // public function applicant_recipt($id = null)
    // {

    //     $classes_data = $this->Applicant->find('all')->contain(['Enquires'])->order(['Applicant.id' => 'DESC'])->where(['Applicant.id' => $id])->first();
    //     pr($classes_data); die;
    //     $this->sitesetting('receipt');

    //     // $board_names = $this->Boards->find('all')->where(['Boards.id' => $classes_data['previous_board']])->first();
    //     // pr($board_names['pro_fees']); die;

    //     // if($board_names['pro_fees']){
    //     //     $this->set('regisfee', $board_names['pro_fees']);
    //     // }


    //     $student_datas = $this->Studentfees->find('all')->where(['Studentfees.recipetno' => $classes_data['recipietno']])->first();
    //     $this->set('studentfees', $student_datas);

    //     $this->set('recipt', $classes_data);

    //     $discountCategorylist = $this->DiscountCategory->find('all', [
    //         'keyField' => 'discount',
    //         'valueField' => 'name',
    //     ])->where(['status' => 'Y', 'type' => '0'])->order(['id' => 'ASC'])->toArray();
    //     $this->set('discountCategorylist', $discountCategorylist);

    //     $cid = $classes_data['class_id'];

    //     $clas = $this->Classes->find('all')->select(['title'])->where(['Classes.id' => $cid])->first();
    //     $this->set('clas', $clas);
    //     $rt = $classes_data['enquire']['mode1_id'];

    //     $user = $this->Users->find('all')->where(['Users.role_id' => ADMIN])->first();
    //     $acedmicyear = $user['academic_year'];
    //     $this->set('acedmicyear', $acedmicyear);




    //     if ($rt == '1'){
    //         $nj = $this->Feesheads->find('all')->where(['Feesheads.id' => '8'])->first()->toarray();
    //         $this->set('regisfee', $nj['cbse_fee']);

    //     } elseif ($rt == '2') {
    //         $nj = $this->Feesheads->find('all')->where(['Feesheads.id' => '8'])->first()->toarray();
    //         $this->set('regisfee', $nj['cambridge_fee']);

    //     } elseif ($rt == '3'){
    //         $nj = $this->Feesheads->find('all')->where(['Feesheads.id' => '8'])->first()->toarray();
    //         $this->set('regisfee', $nj['ibdp_fee']);
    //     } 


    //     $brhy = $this->Boards->find('all')->order(['Boards.id' => 'DESC'])->where(['Boards.id' => $rt])->first();
    //     $this->set('brd', $brhy);
    // }



    public function applicant_recipt($id)
    {
        $classes_data = $this->Applicant->find('all')->contain(['Enquires'])->order(['Applicant.id' => 'DESC'])->where(['Applicant.id' => $id])->first();
        $this->sitesetting('receipt');

        $student_datas = $this->Studentfees->find('all')->where(['Studentfees.recipetno' => $classes_data['recipietno']])->first();
        $this->set('studentfees', $student_datas);
        $this->set('recipt', $classes_data);

        $discountCategorylist = $this->DiscountCategory->find('all', [
            'keyField' => 'discount',
            'valueField' => 'name',
        ])->where(['status' => 'Y', 'type' => '0'])->order(['id' => 'ASC'])->toArray();
        $this->set('discountCategorylist', $discountCategorylist);

        $cid = $classes_data['class_id'];

        $clas = $this->Classes->find('all')->select(['title'])->where(['Classes.id' => $cid])->first();
        $this->set('clas', $clas);
        $rt = $classes_data['enquire']['mode1_id'];

        $user = $this->Users->find('all')->where(['Users.role_id' => ADMIN])->first();
        $acedmicyear = $user['academic_year'];
        $this->set('acedmicyear', $acedmicyear);

        if ($rt == '1') {
            $nj = $this->Feesheads->find('all')->where(['Feesheads.id' => '8'])->first()->toarray();
            $this->set('regisfee', $nj['cbse_fee']);
        } elseif ($rt == '2') {
            $nj = $this->Feesheads->find('all')->where(['Feesheads.id' => '8'])->first()->toarray();
            $this->set('regisfee', $nj['cambridge_fee']);
        } elseif ($rt == '3') {
            $nj = $this->Feesheads->find('all')->where(['Feesheads.id' => '8'])->first()->toarray();
            $this->set('regisfee', $nj['ibdp_fee']);
        }

        $brhy = $this->Boards->find('all')->order(['Boards.id' => 'DESC'])->where(['Boards.id' => $rt])->first();
        $this->set('brd', $brhy);
    }

    // this function used for Approved Registration on prospectus Manager
    public function approvedprospect()
    {
        $this->viewBuilder()->layout('admin');

        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        if ($rolepresent == ADMIN || $rolepresent == CENTER_COORDINATOR) {
            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        } elseif ($rolepresent == CBSE_FEE_COORDINATOR) {

            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {

            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1', 'Classes.board_id IN' => ALL_BOARDS])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        }

        if ($rolepresent == ADMIN || $rolepresent == CENTER_COORDINATOR) {
            $brhy = $this->Boards->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
            $this->set('bord', $brhy);
        } elseif ($rolepresent == CBSE_FEE_COORDINATOR) {
            $brhy = $this->Boards->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
            $this->set('bord', $brhy);
        } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
            $brhy = $this->Boards->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
            $this->set('bord', $brhy);
        }

        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        if ($rolepresent == CBSE_FEE_COORDINATOR || $rolepresent == CENTER_COORDINATOR) {
            $t_enquiry = $this->Applicant->find('all')->where(['Applicant.status' => 'Y', 'Enquires.class_id <=' => '30'])->contain(['Enquires'])->toarray();
            $this->set(compact('t_enquiry'));
        } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
            $t_enquiry = $this->Applicant->find('all')->where(['Applicant.status' => 'Y', 'Enquires.class_id >=' => '23', 'Enquires.p_fees' => ''])->contain(['Enquires'])->toarray();
            $this->set(compact('t_enquiry'));
        } else {
            $t_enquiry = $this->Applicant->find('all')->where(['Applicant.status' => 'Y', 'Enquires.p_fees' => ''])->contain(['Enquires'])->toarray();
            $this->set(compact('t_enquiry'));
        }
    }

    // change role id to role name
    public function rejectprospect()
    {
        $this->viewBuilder()->layout('admin');
        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        if ($rolepresent == ADMIN || $rolepresent == CENTER_COORDINATOR) {
            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.id' => 'asc'])->toArray();
            $this->set('classes', $classes);
        } elseif ($rolepresent == CBSE_FEE_COORDINATOR) {
            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.id' => 'asc'])->toArray();
            $this->set('classes', $classes);
        } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.id' => 'asc'])->toArray();
            $this->set('classes', $classes);
        }

        if ($rolepresent == ADMIN || $rolepresent == CENTER_COORDINATOR) {

            $brhy = $this->Boards->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
            $this->set('bord', $brhy);
        } elseif ($rolepresent == CBSE_FEE_COORDINATOR) {

            $brhy = $this->Boards->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
            $this->set('bord', $brhy);
        } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
            $brhy = $this->Boards->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
            $this->set('bord', $brhy);
        }
        if ($rolepresent == CBSE_FEE_COORDINATOR || $rolepresent == CENTER_COORDINATOR) {

            $rej_appli = $this->Applicant->find('all')->where(['Applicant.status_r' => 'Y', 'Enquires.class_id <=' => '22'])->contain(['Enquires'])->toarray();
            $this->set(compact('rej_appli'));
        } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
            $rej_appli = $this->Applicant->find('all')->where(['Applicant.status_r' => 'Y', 'Enquires.class_id >=' => '23', 'Enquires.p_fees' => ''])->contain(['Enquires'])->toarray();
            $this->set(compact('rej_appli'));
        } else {
            $rej_appli = $this->Applicant->find('all')->where(['Applicant.status_r' => 'Y', 'Enquires.p_fees' => ''])->contain(['Enquires'])->toarray();
            $this->set(compact('rej_appli'));
        }
    }

    public function prosapproval()
    {
        $romm = sizeof($this->request->data['p_id']);
        for ($i = 0; $i < $romm; $i++) {
            $conn = ConnectionManager::get('default');
            $pros = $this->request->data['p_id'][$i];
            $st = "Y";
            $st1 = "N";
            $detail1 = 'UPDATE `applicants` SET `status` ="' . $st . '",`status_r` ="' . $st1 . '" WHERE `applicants`.`sno` = "' . $pros . '"';
            $results2 = $conn->execute($detail1);
        }
        return $this->redirect(['action' => 'approvedprospect']);
    }

    // change role id to role name
    public function findacdemicbck()
    {
        $query = $this->request->data['query'];
        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        if ($rolepresent == CBSE_FEE_COORDINATOR) {
            if ($query == '1') {
                $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

                $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
                if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
                    $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
                }
                $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' => '1'])->first();

                $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' => '1', 'Enquires.class_id <=' => '22'])->contain(['Enquires'])->first();
                $c = $student_datasmaxss['amount'];
            }
            if ($query == '2') {

                $classes = $this->Classections->find('list', [
                    'keyField' => 'Classes.id',
                    'valueField' => 'Classes.title',
                ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
                $this->set('classes', $classes);

                $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

                $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
                if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
                    $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
                }
                $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->first();

                $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.class_id >=' => '23'])->contain(['Enquires'])->first();
                $c = $student_datasmaxss['amount'];
            }
            $recipietno = $c + 1;
        } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
            if ($query == '2') {
                $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

                $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
                if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
                    $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
                }
                $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' => '1'])->first();

                $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' => '1', 'Enquires.class_id <=' => '22'])->contain(['Enquires'])->first();

                $c = $student_datasmaxss['amount'];
            }
            if ($query == '1') {

                $classes = $this->Classections->find('list', [
                    'keyField' => 'Classes.id',
                    'valueField' => 'Classes.title',
                ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
                $this->set('classes', $classes);

                $boardzs = ALL_BOARDS;

                $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

                $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id IN' => $boardzs, 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
                if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
                    $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
                }
                $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id IN' => $boardzs])->first();

                $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id IN' => $boardzs, 'Enquires.class_id >=' => '23'])->contain(['Enquires'])->first();
                $c = $student_datasmaxss['amount'];
            }
            $recipietno = $c + 1;
        }

        echo $recipietno;
        die;
    }

    // change role id to role name
    public function applicant_add()
    {
        $board_name = $this->Board->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $this->set('board_name', $board_name);

        $this->viewBuilder()->layout('admin');

        $formnum = $this->Enquires->find('all')->order(['formno' => 'DESC'])->first();
        $this->set('formnum', $formnum);

        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        $user = $this->Users->find('all')->where(['Users.role_id' => ADMIN])->first();
        $userDb = $user['db'];
        $this->set(compact('userDb'));
        $acd = $this->academicyear();
        $this->set(compact('acd'));
        $rolepresentyear = $this->currentacademicyear();
        $this->set(compact('rolepresentyear'));
        if ($rolepresent == ADMIN || $rolepresent == CENTER_COORDINATOR || $rolepresent == BRANCH_HEAD) {
            $classes = $this->Classes->find('list', [
                'keyField' => 'id',
                'valueField' => 'title',
            ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);

            $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

            $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

            if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
                $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
            }

            $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' => '1'])->first();

            $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' => '1', 'Enquires.class_id <=' => '22'])->contain(['Enquires'])->first();

            $c = $student_datasmaxss['amount'];
        } elseif ($rolepresent == CBSE_FEE_COORDINATOR || $rolepresent == LEAD_COORDINATOR) {

            $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

            $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

            if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
                $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
            }

            $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' => '1'])->first();

            $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' => '1', 'Enquires.class_id <=' => '22'])->contain(['Enquires'])->first();

            $c = max($student_datasmaxss['amount'], $student_datasmaxss2['amount'], $student_datasmaxss3['amount']);

            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {

            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1', 'Classes.board_id IN' => ALL_BOARDS])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);

            $boardzs = ALL_BOARDS;
            $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();


            $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id IN' => $boardzs, 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

            if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
                $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
            }
            $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id IN' => $boardzs])->first();

            $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id IN' => $boardzs, 'Enquires.class_id >=' => '23'])->contain(['Enquires'])->first();
            $c = $student_datasmaxss['amount'];
        }

        $recipietno = $c + 1;
        $this->set('recipietno', $recipietno);

        if ($this->request->is('post')) {

            $fomno = $this->request->data['sno'];
            $category = $this->request->data['category'];


            $fees = $this->Feesheads->find('all')->where(['Feesheads.id' => '8'])->first();
            $cbse = $fees['cbse_fee'];
            $camb = $fees['cambridge_fee'];
            $ibd = $fees['ibdp_fee'];

            $classregfees = $this->Classes->find('all')->where(['Classes.id' => $this->request->data['class_id']])->first();
            if ($classregfees['board_id'] == 1) {
                $this->request->data['reg_fee'] = $cbse;
            } else if ($classregfees['board_id'] == 2) {
                $this->request->data['reg_fee'] = $camb;
            } else if ($classregfees['board_id'] == 3) {
                $this->request->data['reg_fee'] = $ibd;
            }


            $gallery = $this->request->data['image'];
            $filename = $gallery['name'];
            $ext = end(explode('.', $filename));
            $name = md5(time($filename));
            $imagename = trim($name . 'stu.' . $ext, " ");
            if (move_uploaded_file($gallery['tmp_name'], "stu/" . $imagename)) {
                $this->request->data['image'] = $imagename;
            }
            $rtf = explode('/', $this->request->data['dob']);
            $this->request->data['dob'] = $rtf[2] . '-' . $rtf[1] . '-' . $rtf[0];
            $this->request->data['created'] = date('Y-m-d');
            $rolepresentss = $this->request->session()->read('Auth.User.role_id');
            if ($category == "Migration") {
                $this->request->data['recipietno'] = $this->request->data['recipietno'];
            } else {
                if ($rolepresentss == CBSE_FEE_COORDINATOR || $rolepresentss == LEAD_COORDINATOR) {
                    $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Students.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

                    $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
                    if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
                        $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
                    }
                    $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id' => '1'])->first();

                    $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id' => '1', 'Enquires.class_id <=' => '22'])->contain(['Enquires'])->first();
                    $c = $student_datasmaxss['amount'];
                } elseif ($rolepresentss == INTERNATIONAL_FEE_COORDINATOR) {

                    $boardzs = ALL_BOARDS;

                    $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['amount' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();

                    $student_datasmaxsseeer = $this->Studentfees->find('all')->contain(['DropOutStudent'])->select(['amount' => 'Studentfees.recipetno'])->where(['DropOutStudent.board_id IN' => $boardzs, 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.id DESC'])->first();
                    if ($student_datasmaxss['amount'] < $student_datasmaxsseeer['amount']) {
                        $student_datasmaxss['amount'] = $student_datasmaxsseeer['amount'];
                    }

                    $student_datasmaxss2 = $this->Enquires->find('all')->select(['amount' => 'MAX(Enquires.recipietno)'])->where(['Enquires.mode1_id IN' => $boardzs])->first();

                    $student_datasmaxss3 = $this->Applicant->find('all')->select(['amount' => 'MAX(Applicant.recipietno)'])->where(['Enquires.mode1_id IN' => $boardzs, 'Enquires.class_id >=' => '23'])->contain(['Enquires'])->first();
                    $c = $student_datasmaxss['amount'];
                }
                $this->request->data['recipietno'] = $c + 1;
            }

            $getdetailuser = $this->Users->find('all')->where(['Users.id' => '1'])->first();

            if ($getdetailuser['is_prospectskip'] == "Y") {

                $enquires = $this->Enquires->newEntity();

                $sdata['formno'] = $this->request->data['sno'];
                $sdata['recipietno'] = $this->request->data['recipietno'];
                $sdata['s_name'] = $this->request->data['fname'] . " " . $this->request->data['middlename'] . " " . $this->request->data['lname'];
                if ($this->request->data['fee_submittedby'] == "") {

                    $sdata['fee_submittedby'] = $this->request->data['f_name'];
                } else {
                    $sdata['fee_submittedby'] = $this->request->data['fee_submittedby'];
                }

                $sdata['class_id'] = $this->request->data['class_id'];
                $sdata['enquiry_mode'] = '2';
                $sdata['mode1_id'] = '1';
                $sdata['mode_id'] = '22';
                $sdata['mobile'] = $this->request->data['f_phone'];
                $sdata['created'] = date('Y-m-d');
                $sdata['acedmicyear'] = $this->request->data['acedmicyear'];
                if ($this->request->data['modes'] == "Z") {
                    $this->request->data['reg_fee'] = 0;
                    $sdata['recipietno'] = $this->request->data['recipietno'] = 0;
                }
                $enquires = $this->Enquires->patchEntity($enquires, $sdata);
                $result = $this->Enquires->save($enquires);
            }
            $bord = $this->Enquires->find('all')->where(['Enquires.formno' => $fomno])->select(['mode1_id'])->first();
            $bid = $bord['mode1_id'];
            $Applicant = $this->Applicant->newEntity();
            if ($this->request->data['fee_submittedby'] == "") {
                $this->request->data['fee_submittedby'] = $this->request->data['f_name'];
            } else {
                $this->request->data['fee_submittedby'] = $this->request->data['fee_submittedby'];
            }
            $Applicant = $this->Applicant->patchEntity($Applicant, $this->request->data);
            $result = $this->Applicant->save($Applicant);
            if ($this->Applicant->save($Applicant)) {
                $peopleTableshh = TableRegistry::get('Studentfees');
                $oQueryshh = $peopleTableshh->query();
                if ($this->request->data['class_id'] <= 22) {
                    $stidd = '6342';
                } elseif ($this->request->data['class_id'] == '26' || $this->request->data['class_id'] == '27') {
                    $stidd = '333333';
                } else {
                    $stidd = '333333';
                }

                if ($this->request->data['modes'] != "CASH") {
                    $this->request->data['ref_no'] = $this->request->data['ref_no'];
                } else {
                    $this->request->data['ref_no'] = '0';
                }

                $str2 = 'a:1:{s:16:"Registration Fee";d:' . $this->request->data['reg_fee'] . ';}';
                $oQueryshh->insert(['student_id', 'paydate', 'quarter', 'mode', 'formno', 'type', 'recipetno', 'bank', 'cheque_no', 'addtionaldiscount', 'deposite_amt', 'fee', 'ref_no', 'discount', 'status', 'acedmicyear', 'discountcategory', 'remarks'])
                    ->values([
                        'student_id' => $stidd,
                        'paydate' => date('Y-m-d', strtotime($this->request->data['created'])),
                        'quarter' => $str2,
                        'mode' => $this->request->data['modes'],
                        'formno' => $this->request->data['sno'],
                        'type' => 'Registration',
                        'recipetno' => $this->request->data['recipietno'],
                        'bank' => '',
                        'cheque_no' => '0',
                        'addtionaldiscount' => '0.00',
                        'deposite_amt' => '00',
                        'fee' => '00',
                        'ref_no' => $this->request->data['ref_no'],
                        'discount' => '0.00',
                        'status' => 'Y',
                        'acedmicyear' => $this->request->data['acedmicyear'],
                        'discountcategory' => '',
                        'remarks' => 'Registration Fee'
                    ]);
                $oQueryshh->execute();
                $id = $result->id;

                $Applicant = $this->Guardians->newEntity();
                $this->request->data['applicant_id'] = $id;
                $Applicant = $this->Guardians->patchEntity($Applicant, $this->request->data);

                $this->Guardians->save($Applicant);

                $this->request->session()->delete('openreg_recipt');
                $this->request->session()->write('openreg_recipt', $id);
                return $this->redirect(['controller' => 'Report', 'action' => 'prospect']);
            }
        }
    }

    // change role id to role name
    public function applicant_edit($id)
    {

        $this->viewBuilder()->layout('admin');
        $acd = $this->academicyear();
        $this->set(compact('acd'));

        $board_name = $this->Board->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $this->set('board_name', $board_name);


        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        if ($rolepresent == ADMIN || $rolepresent == CENTER_COORDINATOR) {
            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        } elseif ($rolepresent == CBSE_FEE_COORDINATOR || $rolepresent == LEAD_COORDINATOR) {

            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {

            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        }

        if (isset($id) && !empty($id)) {
            //using for edit
            $applicant = $this->Applicant->get($id);
            $guardians = $this->Guardians->find('all')->where(['Guardians.applicant_id' => $id])->order(['Guardians.id' => 'DESC'])->first();
            $this->set('guardians', $guardians);
            $gid = $guardians['id'];
            if ($guardians) {
                $guardian = $this->Guardians->get($gid);
            }
            $this->set('ids', $id);
        }
        $this->set('applicant', $applicant);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->request->data['category'] == "Migration") {
                $mode1_id = '1';
                $class = $this->request->data['class_id'];
                $sno = $this->request->data['sno'];
                $conn = ConnectionManager::get('default');
                $conn->execute("update enquires set mode1_id='$mode1_id',class_id='$class' where formno='$sno'");
            }

            $rtf = explode('/', $this->request->data['dob']);
            $this->request->data['dob'] = $rtf[2] . '-' . $rtf[1] . '-' . $rtf[0];
            //$this->request->data['created']=date('Y-m-d');
            $Applicant = $this->Applicant->patchEntity($applicant, $this->request->data);

            $result = $this->Applicant->save($applicant);
            if ($result) {
                $id = $result->id;
                if ($guardian) {
                    $Guardians = $this->Guardians->patchEntity($guardian, $this->request->data);
                    $this->Guardians->save($Guardians);
                } else {
                    $guardian = $this->Guardians->newEntity();
                    $this->request->data['applicant_id'] = $id;
                    $Guardians = $this->Guardians->patchEntity($guardian, $this->request->data);
                    $this->Guardians->save($Guardians);
                }

                $this->request->session()->delete('openreg_recipt');
                $this->request->session()->write('openreg_recipt', $id);
                return $this->redirect(['controller' => 'Report', 'action' => 'prospect']);
            }
        }
    }

    // change role id to role name
    public function tasksearch()
    {
        // echo "task search function"; die;
        $radioValue = $this->request->data['radioValue'];
        $prosuper = $this->request->data['fetch'];

        $userTable = TableRegistry::get('Applicant');
        $exists = $userTable->exists(['sno' => $prosuper]);
        if ($exists) {
            echo 1;
            die;
        } else {
            $rolepresent = $this->request->session()->read('Auth.User.role_id');
            //~ if($radioValue=='NORMAL'){
            if ($rolepresent == CBSE_FEE_COORDINATOR) {
                $mode1_id = ('1');
            } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {

                $mode1_id = ('2,3');
            } else {

                $mode1_id = ('1,2,3');
            }
            $user = $this->Users->find('all')->where(['Users.role_id IN' => [ADMIN, BRANCH_HEAD]])->first();
            $rolepresent = $user['academic_year'];

            $conn = ConnectionManager::get('default');
            $detail = "SELECT * FROM `enquires` WHERE formno ='$prosuper' AND status='Y' AND mode1_id IN ($mode1_id)";

            $results = $conn->execute($detail)->fetchAll('assoc');
            $conn = ConnectionManager::get('default');
            $feesub = $results[0]["fee_submittedby"];
            $mob = $results[0]["mobile"];
            $details = "SELECT * FROM `applicants` WHERE f_name ='$feesub' AND f_phone ='$mob'";
            $resultss = $conn->execute($details)->fetchAll('assoc');
            $d = explode(' ', $results[0]['s_name']);

            if ($d[0] == '') {
                $d[0] = '';
            } elseif ($d[1] == '') {
                $d[1] = '';
            } elseif ($d[2] == '') {
                $d[2] = '';
            }
            if (empty($results)) {
                echo 0;
                die;
            } elseif ($results) {

                echo $d[0] . ',' . $results[0]['class_id'] . ',' . $results[0]['mobile'], ',' . $results[0]['fee_submittedby'], ',' . $results[0]['fee_submittedby'], ',' . $d[1], ',' . $resultss[0]['mother_tounge'], ',' . $resultss[0]['f_qualification'], ',' . $resultss[0]['f_occupation'], ',' . $resultss[0]['m_name'], ',' . $resultss[0]['m_qualification'], ',' . $resultss[0]['m_occupation'], ',' . $resultss[0]['m_phone'], ',' . $resultss[0]['m_qualification'], ',' . $resultss[0]['pob'], ',' . $d[2], ',' . $results[0]['acedmicyear'];
                die;
            } elseif ($resultss) {
                echo $resultss[0]['fname'] . ',' . $results[0]['class_id'] . ',' . $results[0]['mobile'], ',' . $results[0]['fee_submittedby'], ',' . $results[0]['fee_submittedby'], ',' . $resultss[0]['middlename '], ',' . $resultss[0]['mother_tounge'], ',' . $resultss[0]['f_qualification'], ',' . $resultss[0]['f_occupation'], ',' . $resultss[0]['m_name'], ',' . $resultss[0]['m_qualification'], ',' . $resultss[0]['m_occupation'], ',' . $resultss[0]['m_phone'], ',' . $resultss[0]['m_qualification'], ',' . $resultss[0]['pob'], ',' . $resultss[0]['lname '], ',' . $resultss[0]['acedmicyear'];
                die;
            }
        }
    }

    public function findsections()
    {

        $bid = $this->request->data['id'];
        $fieln = $this->request->data['fieln'];
        $bord = $this->Applicant->find('all')->where(['Applicant.sno' => $bid])->order(['Applicant.id' => 'DESC'])->first();
        //pr($bord); die;
        $string = $bord[$fieln];
        echo $string;
        die;
    }

    public function findphoneno()
    {

        $bid = $this->request->data['id'];
        $fieln = $this->request->data['fieln'];
        $bord = $this->Applicant->find('all')->where(['Applicant.sno' => $bid])->order(['Applicant.id' => 'DESC'])->first();
        //pr($bord); die;
        $string = $bord[$fieln];

        if ($string) {
            echo $string;
            die;
        } else {

            echo 0;
            die;
        }
    }

    public function findphonenos()
    {
        $bid = $this->request->data['id'];
        $bsid = $this->request->data['bid'];
        $fieln = $this->request->data['fieln'];
        $bord = $this->Students->find('all')->where(['Students.id' => $bid, 'Students.board_id' => $bsid])->order(['Students.id' => 'DESC'])->first();
        $string = $bord[$fieln];
        if ($string) {
            echo $string;
            die;
        } else {

            echo 0;
            die;
        }
    }

    public function findfeesubmittedby()
    {

        $bid = $this->request->data['id'];
        $fieln = $this->request->data['fieln'];
        $bord = $this->Students->find('all')->where(['Students.id' => $bid, 'Students.status' => 'Y'])->order(['Students.id' => 'DESC'])->first();
        if ($fieln == "f_sub") {
            $string = $bord['fathername'];
        } elseif ($fieln == "m_sub") {
            $string = $bord['mothername'];
        } else {
            $string = $bord['fee_submittedby'];
        }

        if ($string) {
            echo $string;
            die;
        } else {

            echo 0;
            die;
        }
    }

    public function findboard()
    {
        $bid = $this->request->data['id'];
        $bord = $this->Students->find('all')->select(['enroll'])->where(['Students.board_id' => $bid, 'Students.status' => 'Y'])->order(['Students.id' => 'DESC'])->first();
        //pr($bord); die;
        $string = $bord['enroll'];
        //echo $string; die;
        $number = preg_replace("/[^0-9]/", '', $string);
        $f = $number + 1;
        if ($bid == 3) {

            echo $f;
            die;
        } elseif ($bid == 1) {
            echo $f;
            die;
        } else {
            echo $f;
            die;
        }
    }

    // change role id to role name
    public function studentsearch2()
    {

        $prosuper = $this->request->data['fetch'];
        $board = $this->request->data['board'];


        $user = $this->Users->find('all')->where(['Users.role_id' => ADMIN])->first();
        $rolepresent = $user['academic_year'];
        $db = $user['db'];
        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        if ($board == 1) {

            $bord = $this->Students->find('all')->where(['Students.enroll' => $prosuper, 'Students.status' => 'Y'])->order(['Students.id' => 'DESC'])->first();
            // pr($bord);exit;
            $bord['image'] = $prosuper . ".JPG";

            $classes = $this->Classes->find('all')->select(['id', 'title'])->where(['id' => $bord['class_id']])->order(['title' => 'ASC'])->first();
        } elseif ($board == 2) {

            $bord = $this->Students->find('all')->where(['Students.enroll' => $prosuper, 'Students.status' => 'Y'])->order(['Students.id' => 'DESC'])->first();

            $classes = $this->Classes->find('all')->select(['id', 'title'])->where(['id' => $bord['class_id']])->order(['title' => 'ASC'])->first();

            if ($board == CAMBRIDGE) {
                $bord['image'] = "CAM" . $prosuper . ".JPG";
            } else {

                $bord['image'] = "IB" . $prosuper . ".JPG";
            }
        }

        if ($bord['id']) {

            echo IMAGE_URL . $db . 'img/' . $bord['image'] . ',' . $bord['fname'] . ',' . $bord['middlename'] . ',' . $bord['lname'] . ', ,' . $date . ',' . $bord['fathername'] . ',' . $bord['mothername'] . ',' . $bord['mobile'] . ',' . $results[0]['acedmicyear'] . ',' . $board . ',' . $bord['sms_mobile'] . ',' . $bord['section_id'] . ',' . $bord['section_id'] . ',' . $bord['h_id'] . ',' . $bord['h_id'] . ',' . $classes['id'] . ',' . $classes['title'] . ',' . $bord['gender'] . ',' . date('Y-m-d', strtotime($bord['dob'])) . ',' . $bord['mother_tounge'] . ',' . $bord['f_qualification'] . ',' . $bord['f_occupation'] . ',' . $bord['m_qualification'] . ',' . $bord['m_occupation'] . ',' . $bord['m_phone'] . ',' . $bord['f_phone'] . ',1&' . $bord['address'];
            die;
        } else {
            echo 0;
            die;
        }
    }

    // change role id to role name
    public function studentsearch()
    {

        $prosuper = $this->request->data['fetch'];
        // pr($prosuper);exit;
        $min = 0;
        $min2 = 0;
        $a = '';
        $b = '';
        $user = $this->Users->find('all')->where(['Users.role_id' => ADMIN])->first();
        $rolepresent = $user['academic_year'];
        $conn = ConnectionManager::get('default');
        $detail = "SELECT * FROM `applicants` WHERE sno = '$prosuper'";

        $results = $conn->execute($detail)->fetchAll('assoc');
        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        if ($rolepresent == CBSE_FEE_COORDINATOR) {
            $mode1_id = ['1'];
        } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
            $mode1_id = ['2', '3'];
        } else {
            $mode1_id = ['1', '2', '3'];
        }

        if (empty($results)) {
            echo 0;
            die;
        } elseif ($results[0]['image'] == '') {
            $id = $results[0]['sno'];
            $enqiur1 = $this->Enquires->find('all')->select(['mode1_id'])->where(['Enquires.formno' => $id, 'Enquires.mode1_id IN' => $mode1_id])->first();
            if ($enqiur1['mode1_id']) {

                $date = $results[0]['dob'];
                $fee_submittedby = $results[0]['fee_submittedby'];
                $bord = $enqiur1['mode1_id'];

                $gh = date('Y,m,d', strtotime($date));
                $articles = TableRegistry::get('Students');
                $studentsection = $articles->find('all')->group('Students.section_id')->select(['tocoun' => $articles->find()->func()->count('Students.id'), 'Students.section_id'])->where(['Students.class_id' => $results[0]['class_id'], 'Students.status' => 'Y'])->toarray();
                //    pr( $studentsection); die;
                foreach ($studentsection as $kl => $iyu) {
                    $numbers[] = $iyu['tocoun'];
                }

                $min = min($numbers);

                foreach ($studentsection as $j => $h) {

                    if ($h['tocoun'] == $min) {
                        $a = $h['section_id'];
                    }
                }

                $classes = $this->Classes->find('all')->select(['id', 'title'])->where(['id' => $results[0]['class_id']])->order(['title' => 'ASC'])->toArray();
                $sections = $this->Sections->find('all')->select(['id', 'title'])->where(['id' => $a])->order(['title' => 'ASC'])->toArray();

                $studentsectionhid = $articles->find('all')->group('Students.h_id')->select(['tocouns' => $articles->find()->func()->count('Students.id'), 'Students.h_id'])->where(['Students.class_id' => $results[0]['class_id'], 'Students.section_id' => $sections[0]['id'], 'Students.status' => 'Y'])->toarray();

                foreach ($studentsectionhid as $kl => $iyu) {
                    $numberss[] = $iyu['tocouns'];
                }
                //    pr($studentsectionhid);

                $min2 = min($numberss);

                foreach ($studentsectionhid as $s => $k) {

                    if ($k['tocouns'] == $min2) {
                        $b = $k['h_id'];
                    }
                }

                $houses = $this->Houses->find('all')->select(['id', 'name'])->where(['id' => $b])->order(['id' => 'ASC'])->toArray();

                echo
                'r' . ',' . $results[0]['fname'] . ',' . $results[0]['middlename'] . ',' . $results[0]['lname'] . ',' . $results[0]['class_id'] . ',' . $date . ',' . $results[0]['f_name'] . ',' . $results[0]['m_name'] . ',' . $results[0]['f_phone'] . ',' . $results[0]['acedmicyear'] . ',' . $bord . ',' . $results[0]['f_phone'] . ',' . $sections[0]['id'] . ',' . $sections[0]['title'] . ',' . $houses[0]['id'] . ',' . $houses[0]['name'] . ',' . $classes[0]['id'] . ',' . $classes[0]['title'] . ',' . $results[0]['gender'] . ',' . $results[0]['mother_tounge'] . ',' . $results[0]['f_qualification'] . ',' . $results[0]['f_occupation'] . ',' . $results[0]['m_qualification'] . ',' . $results[0]['m_occupation'] . ',' . $results[0]['m_phone'] . ',' . $results[0]['f_phone'];
                die;
            } else {

                echo '0';
                die;
            }
        } else {
            //pr($results);  die;
            $id = $results[0]['sno'];
            $enqiur1 = $this->Enquires->find('all')->select(['mode1_id'])->where(['Enquires.formno' => $id, 'Enquires.mode1_id IN' => $mode1_id])->first();

            if ($enqiur1['mode1_id']) {

                //pr($enqiur1); die;
                $articles = TableRegistry::get('Students');
                $studentsection = $articles->find('all')->group('Students.section_id')->select(['tocoun' => $articles->find()->func()->count('Students.id'), 'Students.section_id'])->where(['Students.class_id' => $results[0]['class_id'], 'Students.status' => 'Y'])->toarray();
                foreach ($studentsection as $kl => $iyu) {
                    $numbers[] = $iyu['tocoun'];
                }

                $min = min($numbers);

                foreach ($studentsection as $j => $h) {

                    if ($h['tocoun'] == $min) {
                        $a = $h['section_id'];
                    }
                }
                $classes = $this->Classes->find('all')->select(['id', 'title'])->where(['id' => $results[0]['class_id']])->order(['title' => 'ASC'])->toArray();

                $sections = $this->Sections->find('all')->select(['id', 'title'])->where(['id' => $a])->order(['title' => 'ASC'])->toArray();

                $studentsectionhid = $articles->find('all')->group('Students.h_id')->select(['tocouns' => $articles->find()->func()->count('Students.id'), 'Students.h_id'])->where(['Students.class_id' => $results[0]['class_id'], 'Students.section_id' => $sections[0]['id'], 'Students.status' => 'Y'])->toarray();
                foreach ($studentsectionhid as $kl => $iyu) {
                    $numberss[] = $iyu['tocouns'];
                }

                $min2 = min($numberss);

                foreach ($studentsectionhid as $s => $k) {

                    if ($k['tocouns'] == $min2) {
                        $b = $k['h_id'];
                    }
                }

                $houses = $this->Houses->find('all')->select(['id', 'name'])->where(['id' => $b])->order(['id' => 'ASC'])->toArray();
                $fee_submittedby = $results[0]['fee_submittedby'];
                $date = $results[0]['dob'];
                $bord = $enqiur1['mode1_id'];

                $gh = date('Y,m,d', strtotime($date));

                echo SITE_URL . 'webroot/stu/' . $results[0]['image'] . ',' . $results[0]['fname'] . ',' . $results[0]['middlename'] . ',' . $results[0]['lname'] . ',' . $results[0]['class_id'] . ',' . $date . ',' . $results[0]['f_name'] . ',' . $results[0]['m_name'] . ',' . $results[0]['f_phone'] . ',' . $results[0]['acedmicyear'] . ',' . $bord . ',' . $results[0]['f_phone'] . ',' . $sections[0]['id'] . ',' . $sections[0]['title'] . ',' . $houses[0]['id'] . ',' . $houses[0]['name'] . ',' . $classes[0]['id'] . ',' . $classes[0]['title'] . ',' . $results[0]['gender'] . ',' . $results[0]['mother_tounge'] . ',' . $results[0]['f_qualification'] . ',' . $results[0]['f_occupation'] . ',' . $results[0]['m_qualification'] . ',' . $results[0]['m_occupation'] . ',' . $results[0]['m_phone'] . ',' . $results[0]['f_phone'];
                die;
            } else {

                echo '0';
                die;
            }
        }
    }
    // new function created for check form number 
    function checkStudentExist()
    {
        $this->loadModel('Students');
        $fetch = $this->request->data['fetch'];
        $exist = $this->Students->find('all')->where(['enrollment_no' => $fetch])->first();
        if ($exist) {
            echo 1;
        }
        echo 0;
    }

    public function formsearch()
    {

        $juop = $this->request->data['fetch'];

        $conn = ConnectionManager::get('default');
        $detail = "SELECT * FROM `applicants` WHERE sno LIKE '$juop%' AND `status`='Y'";
        $results = $conn->execute($detail)->fetchAll('assoc');
        if (count($results) > 0) {
            foreach ($results as $value) {
                echo '<li onclick="cllbckp(' . "'" . $value['sno'] . "'" . ',' . "'" . $value['sno'] . "'" . ')"><a href="#">' . $value['sno'] . '</a></li>';
            }
        } else {
        }
        die;
    }

    public function ser1()
    {
        $pro = $this->request->data['fetch'];

        $enqiur = $this->Enquires->find('all')->select(['s_name', 'class_id'])->order(['Enquires.id' => 'DESC'])->where(['Enquires.id' => $pro])->toarray();
        echo $enqiur[0]['s_name'] . ',' . $enqiur[0]['class_id'];
        die;
    }

    public function ser2()
    {
        $pro1 = $this->request->data['fetch'];
        $enqiur = $this->Applicant->find('all')->order(['Applicant.id' => 'DESC'])->where(['Applicant.sno' => $pro1])->first()->toarray();
        $hi = explode(' ', $enqiur['name']);
        echo ($hi['0']) . ',' . $enqiur['class_id'];
        die;
    }

    public function approveprospectsearch()
    {
        $conn = ConnectionManager::get('default');
        //pr($this->request->data); die;
        $from = date('Y-m-d', strtotime($this->request->data['from']));
        $to = date('Y-m-d', strtotime($this->request->data['to'] . '+1 days'));
        $bid = $this->request->data['b_id'];
        $class_id = $this->request->data['class_id'];
        $name = $this->request->data['name'];

        $apk = array();

        if (!empty($from) && $from != '1970-01-01 00:00:00') {
            $stts = array('Enquires.created >=' => $from);
            $apk[] = $stts;
        }

        if (!empty($to) && $to != '1970-01-01 24:00:00') {
            $stst = array('Enquires.created <=' => $to);
            $apk[] = $stst;
        }

        if (!empty($class_id)) {
            $pii = array('Enquires.class_id' => $class_id);
            $apk[] = $pii;
        }

        if (!empty($bid)) {
            $pii = array('Enquires.mode1_id' => $bid);
            $apk[] = $pii;
        }

        if (!empty($name)) {
            $pii = array('Enquires.s_name LIKE' => '%' . $name . '%');
            $apk[] = $pii;
        }

        $classes_data = $this->Applicant->find('all')->order(['Applicant.id' => 'DESC'])->contain(['Enquires'])->where($apk)->toarray();
        //pr($classes_data); die;
        $this->set('t_enquiry', $classes_data);
    }

    public function search_approval()
    {

        $datefrom = $this->request->data['datefrom'];
        $dateto = $this->request->data['dateto'];
        $school_name = trim($this->request->data['school_name']);
        $student_name = trim($this->request->data['name']);

        $apk = array();

        if (!empty($datefrom) && $datefrom != '1970-01-01 00:00:00') {
            $stts = array('CertificatesApproval.created >=' => $datefrom);
            $apk[] = $stts;
        }

        if (!empty($dateto) && $dateto != '1970-01-01 24:00:00') {
            $stst = array('CertificatesApproval.created <=' => $dateto);
            $apk[] = $stst;
        }

        if (!empty($schoolname) && $schoolname != '') {
            $stst = array('CertificatesApproval.created <=' => $dateto);
            $apk[] = $stst;
        }

        if (!empty($student_name) && $student_name != '1970-01-01 24:00:00') {
            $pii = array('CertificatesApproval.sname LIKE' => '%' . $student_name . '%');
            $apk[] = $pii;
        }

        if (!empty($school_name) && $school_name != '1970-01-01 24:00:00') {
            $pii = array('CertificatesApproval.school_name LIKE' => '%' . $school_name . '%');
            $apk[] = $pii;
        }


        $approval_data = $this->CertificatesApproval->find('all')->order(['CertificatesApproval.id' => 'DESC'])->where($apk)->toarray();

        $this->set('students', $approval_data);

        // pr($approval_data);die;
    }

    public function rejectprospectsearch()
    {
        $conn = ConnectionManager::get('default');
        //pr($this->request->data); die;
        $from = date('Y-m-d', strtotime($this->request->data['from']));
        $to = date('Y-m-d', strtotime($this->request->data['to'] . '+1 days'));
        $bid = $this->request->data['b_id'];
        $class_id = $this->request->data['class_id'];
        $name = $this->request->data['name'];

        $apk = array();

        if (!empty($from) && $from != '1970-01-01 00:00:00') {
            $stts = array('Enquires.created >=' => $from);
            $apk[] = $stts;
        }

        if (!empty($to) && $to != '1970-01-01 24:00:00') {
            $stst = array('Enquires.created <=' => $to);
            $apk[] = $stst;
        }

        if (!empty($class_id)) {
            $pii = array('Enquires.class_id' => $class_id);
            $apk[] = $pii;
        }

        if (!empty($bid)) {
            $pii = array('Enquires.mode1_id' => $bid);
            $apk[] = $pii;
        }

        if (!empty($name)) {
            $pii = array('Enquires.s_name LIKE' => '%' . $name . '%');
            $apk[] = $pii;
        }

        $classes_data = $this->Applicant->find('all')->order(['Applicant.id' => 'DESC'])->contain(['Enquires'])->where($apk)->toarray();
        //pr($classes_data); die;
        $this->set('t_enquiry', $classes_data);
    }

    public function interactionupdate()
    {
        $romm = sizeof($this->request->data['p_id']);
        for ($i = 0; $i < $romm; $i++) {
            $conn = ConnectionManager::get('default');
            $y1 = "Y";
            $pros = $this->request->data['p_id'][$i];
            $detail = 'UPDATE `prospect_interactions` SET `status` ="' . $y1 . '" WHERE `prospect_interactions`.`enquiry_id` = "' . $pros . '"';

            $results = $conn->execute($detail);
        }
        return $this->redirect(['action' => 'approvedprospect']);
    }

    //-----------------------------------------------------------------------------------------------------------------
    public function registration_pdf($id = null)
    {
        $prospectus_data = $this->Interaction->find('all')->contain(['Enquires'])->where(['Interaction.id' => $id])->order(['Interaction.id' => 'DESC'])->first()->toarray();
        $this->set(compact('prospectus_data'));
    }

    public function dup_mobile()
    {
        $mobile = $this->request->data['mobile'];
        echo $Employees = $this->Students->find('all')->where(['Students.mobile' => $mobile, 'Students.status' => 'Y'])->count();
        die;
    }

    public function edit_dup_mobile()
    {
        $mobile = $this->request->data['mobile'];
        $e_id = $this->request->data['e_id'];
        echo $Employees = $this->Students->find('all')->where(['Students.mobile' => $mobile, 'Students.id' => $e_id, 'Students.status' => 'Y'])->count();
        die;
    }

    public function genratecard($id = null)
    {
        $this->viewBuilder()->layout('admin');
        $classes = $this->Classections->find('list', [
            'keyField' => 'Classes.id',
            'valueField' => 'Classes.title',
        ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.id' => 'asc'])->toArray();
        $this->set('classes', $classes);

        $sectionslist = $this->Sections->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('sectionslist', $sectionslist);

        $session = $this->request->session();
        $classs = $session->read('class');
        $idss = $session->read('ids');

        if ($idss) {

            $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id IN' => $idss, 'Students.status' => 'Y'])->order(['Students.id' => 'DESC'])->toarray();
            $this->set('students', $student_data);
        }
        if ($classs) {
            $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.class_id' => $classs, 'Students.status' => 'Y'])->order(['Students.id' => 'DESC'])->toarray();
            $this->set('students', $student_data);
        }
    }
    // change role id to role name
    public function promote($id = null, $sec = null, $yeard = null)
    {
        $conn = ConnectionManager::get('default');
        // $user = $this->Users->find('all')->where(['Users.role_id' => ADMIN])->first();
        // $rolepresentyear = $user['academic_year'];
        // $acd = $this->academicyear();
        // $this->set(compact('rolepresentyear'));
        // $this->set(compact('acd'));
        // pr($yeard); die;
        if ($yeard) {
            $yeard = $yeard;
            $this->set('yeard', $yeard);
            $class = $id;
            $this->set('class', $id);
            $section = $sec;
            $this->set('section', $sec);
            $detail = "SELECT Students.id,Students.enroll,Students.fname,Students.category,Students.middlename,Students.lname,Students.sms_mobile,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id WHERE 1=1 ";

            $cond = ' ';
            if (!empty($yeard)) {
                $cond .= " AND Students.acedmicyear LIKE '%" . $yeard . "%' ";
            }
            if (!empty($class)) {
                $cond .= " AND Students.class_id LIKE '%" . $class . "' ";
            }
            if (!empty($section)) {
                $cond .= " AND Students.section_id LIKE '%" . $section . "' ";
            }
            if (!empty($enroll)) {
                $cond .= " AND Students.enroll LIKE '%" . $enroll . "' ";
            }
            if (!empty($fname)) {
                $cond .= " AND UPPER(Students.fname) LIKE '%" . strtoupper($fname) . "%' ";
            }
            $cond .= " AND Students.status='Y'";
            $cond .= " AND Students.is_promote='0'";
            $detail = $detail . $cond;
            $SQL = $detail . " ORDER BY Students.id DESC";
            // pr($SQL);
            // exit;
            $results = $conn->execute($SQL)->fetchAll('assoc');
            $this->set('students', $results);
        }
        $this->viewBuilder()->layout('admin');
        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        $classes = $this->Classes->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $this->set('classes', $classes);
        $sectionslist = $this->Sections->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('sectionslist', $sectionslist);
    }

    public function assign_transport($id = null)
    {
        if (isset($id) && !empty($id)) {
            $this->set('ids', $id);
            $Transport = $this->Students->get($id);
            $academic = $Transport->acedmicyear;
            $this->set('acedemic', $academic);
            $transport = $this->Transportfees->find('list', ['keyField' => 'id', 'valueField' => 'loc_id'])->where(['Transportfees.status' => 'Y', 'Transportfees.academic_year' => $academic])->toArray();
            $this->set(compact('transport'));
        } else {
            $Transport = $this->Students->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {

            $this->request->data['is_transport'] = 1;
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

    public function find_vechical($id = null)
    {
        $id = $this->request->data['id'];
        //echo $id;
        $vechical = $this->Transports->find('list', ['keyField' => 'id', 'valueField' => 'vechical_no'])->where(['FIND_IN_SET(\'' . $id . '\',Transports.route)'])->toArray();
        foreach ($vechical as $number) {
            echo "<option value=" . $number . ">" . $number . "</option>";
        }
        die;
    }

    // change role id to role name
    public function assign_hostel($id = null)
    {
        if (isset($id) && !empty($id)) {

            $students = $this->Students->get($id);
            $this->set('ids', $id);
            $gender = $students->gender;
            if ($gender == "Female") {
                $hostel = $this->Hostels->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Hostels.type' => 1, 'Hostels.status' => 'Y'])->toArray();
                $this->set(compact('hostel'));
            } else {
                $hostel = $this->Hostels->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Hostels.type' => 0, 'Hostels.status' => 'Y'])->toArray();
                $this->set(compact('hostel'));
            }
        } else {

            $students = $this->Students->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {

            //    pr($this->request->data); die;

            $hostelid = $students->h_id;
            if (!empty($hostelid)) {
                $roomcapacity = $this->Hostelrooms->find('list', ['keyField' => 'id', 'valueField' => 'capacity'])->where(['Hostelrooms.h_id' => $hostelid, 'Hostelrooms.status' => 'Y'])->toArray();

                $studentassinrooms = $this->Students->find('all')->where(['Students.is_hostel' => 1, 'Students.room_no' => $this->request->data['room_no'], 'Students.status' => 'Y'])->count();
                $roomcap = implode("", $roomcapacity);

                if ($studentassinrooms >= $roomcap) {

                    $this->Flash->error(__('Selected Rooms Is Booked '));
                    return $this->redirect(['action' => 'index']);
                } else {

                    $this->request->data['is_hostel'] = 1;

                    // save all data in database
                    $students = $this->Students->patchEntity($students, $this->request->data);
                    if ($this->Students->save($students)) {
                        $this->Flash->success(__('Assign Hostel SuccessFully.'));
                        return $this->redirect(['action' => 'index']);
                    }
                }
            } else {

                $this->request->data['is_hostel'] = 1;
                //    pr($this->request->data); die;
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

    public function find_rooms()
    {
        $this->viewBuilder()->layout('admin');
        $id = $this->request->data['id'];
        $ids = $this->request->data['ids'];
        $hostelcapacity = $this->Hostelrooms->find('list', ['keyField' => 'id', 'valueField' => 'capacity'])->where(['Hostelrooms.h_id' => $id, 'Hostelrooms.status' => 'Y'])->toArray();
        $studentassinrooms = $this->Students->find('all')->where(['Students.is_hostel' => 1, 'Students.room_no' => $ids, 'Students.status' => 'Y'])->count();

        foreach ($hostelcapacity as $key => $value) {
            if ($studentassinrooms >= $value) {
                echo "1";
            } else {
                echo "0";
            }
        }
        die;
    }

    public function find_roomslength()
    {
        $this->viewBuilder()->layout('admin');
        $id = $this->request->data['hostel'];
        $hostelrom = $this->Hostelrooms->find('list', ['keyField' => 'id', 'valueField' => 'room_no'])->where(['Hostelrooms.h_id' => $id, 'Hostelrooms.status' => 'Y'])->toArray();

        echo "<option value=''>Select Room</option>";

        foreach ($hostelrom as $key => $value) {
            for ($i = 1; $i <= $value; $i++) {

                echo "<option value=" . $i . " >" . $i . "</option>";
            }
        }
        die;
    }

    public function addsubject($id = null)
    {
        $complete_student = $this->Students->get($id);
        $class_id = $complete_student->class_id;
        // pr($class_id);die;
        if ($class_id == 26 || $class_id == 27) {
            // echo 'testing';die;
            $ibsub1 = $this->Subjectclass->find('list', ['keyField' => 'Subjects.id', 'valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' => $class_id, 'Subjects.is_group' => 1, 'Subjectclass.status' => 'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

            $ibsub2 = $this->Subjectclass->find('list', ['keyField' => 'Subjects.id', 'valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' => $class_id, 'Subjects.is_group' => 2, 'Subjectclass.status' => 'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

            $ibsub3 = $this->Subjectclass->find('list', ['keyField' => 'Subjects.id', 'valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' => $class_id, 'Subjects.is_group' => 3, 'Subjectclass.status' => 'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

            $ibsub4 = $this->Subjectclass->find('list', ['keyField' => 'Subjects.id', 'valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' => $class_id, 'Subjects.is_group' => 4, 'Subjectclass.status' => 'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

            $ibsub5 = $this->Subjectclass->find('list', ['keyField' => 'Subjects.id', 'valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' => $class_id, 'Subjects.is_group' => 5, 'Subjectclass.status' => 'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

            $ibsub6 = $this->Subjectclass->find('list', ['keyField' => 'Subjects.id', 'valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' => $class_id, 'Subjects.is_group' => 6, 'Subjectclass.status' => 'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();
            $this->set(compact('ibsub1', 'ibsub2', 'ibsub3', 'ibsub4', 'ibsub5', 'ibsub6'));
            //pr($ibsub); die;

        }
        $select = $complete_student->comp_sid;
        $this->set('class_id', $class_id);
        if (!empty($select)) {
            $this->set('selected', $select);
        }
        $select1 = $complete_student->opt_sid;
        if (!empty($select1)) {
            $this->set('select1', $select1);
        }

        $com = $this->Subjectclass->find('list', ['keyField' => 'Subjects.id', 'valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' => $class_id, 'Subjectclass.is_optional' => 0, 'Subjectclass.is_result2 IN ' => ['Y', '1'], 'Subjectclass.status' => 'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();
        $this->set(compact('com'));
        $option = $this->Subjectclass->find('list', ['keyField' => 'Subjects.id', 'valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' => $class_id, 'Subjectclass.is_optional' => '1', 'Subjectclass.is_result2 IN ' => ['Y', '1'], 'Subjectclass.status' => 'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

        $this->set(compact('option'));
        if (isset($id) && !empty($id)) {
            $students = $this->Students->get($id);
        } else {
            $students = $this->Students->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {

            $comp = implode(",", $this->request->data['comp_sid']);
            $opt_sid = implode(",", $this->request->data['opt_sid']);
            $this->request->data['comp_sid'] = $comp;
            $this->request->data['opt_sid'] = $opt_sid;
            $students = $this->Students->patchEntity($students, $this->request->data);
            // pr($students); die;
            if ($this->Students->save($students)) {
                $this->Flash->success(__('Student Subject has been saved.'));
                return $this->redirect(['action' => 'view/' . $id . '?id=history']);
            }
        }
    }

    public function find_username($username = null)
    {

        $username = $this->request->data['username'];
        $students = $this->Students->find('all')->where(['Students.username' => $username])->toArray();
        echo $students[0]['id'];
        die;
    }

    //for students chack mail

    // for change email

    public function pdf_view($schedule_id = null)
    {

        $this->viewBuilder()->layout('ajax');
        $this->response->type('pdf');
        $students = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $schedule_id, 'Students.status' => 'Y'])->first()->toarray();
        $this->set(compact('students'));
        $classessss = $this->Guardians->find()->where(['Guardians.user_id' => $schedule_id])->first();
        //pr($classessss); die;
        $this->set(compact('classessss'));
        $doc_img = $this->Documents->find('all')->contain(['Documentcategory'])->where(['Documents.type' => 0, 'Documents.user_id' => $schedule_id])->order(['Documents.id' => 'DESC'])->toarray();

        $this->set(compact('doc_img'));
        $address = $this->Address->find('all')->contain(['CurCountry', 'PerCountry', 'CurStates', 'PerStates', 'CurStates', 'PerStates', 'CurCity', 'PerCity'])->where(['Address.type' => 0, 'Address.user_id' => $schedule_id])->first();

        $this->set(compact('address'));
        $studentshistory = $this->Studentshistory->find('all')->contain(['Classes', 'Sections'])->where(['Studentshistory.stud_id' => $schedule_id])->toarray();
        $this->set(compact('studentshistory'));
    }

    public function change_email($id = null)
    {

        $name = $this->Students->find()->where(['Students.id' => $id, 'Students.status' => 'Y'])->first()->toarray();
        $this->set('name', $name);
        if (isset($id) && !empty($id)) {

            $students = $this->Students->get($id);
        } else {

            $students = $this->Students->newEntity();
        }
        $this->set('students', $students);
        if ($this->request->is(['post', 'put'])) {
            $students = $this->Students->patchEntity($students, $this->request->data);
            $email = $this->request->data['username'];
            $ids = $students->id;
            $conn = ConnectionManager::get('default');
            $detail = 'UPDATE `students` SET `username` ="' . $email . '" WHERE `students`.`id` = ' . $ids;
            $results = $conn->execute($detail);
            $this->Flash->success(__('Your Personal Information  has been saved.'));
            return $this->redirect(['action' => 'view/' . $ids]);
        }
    }

    // change role id to role name
    // show all data in listing with pagination
    public function index($id = null, $section = null)
    {
        // pr($id);exit;
        // pr($_SESSION['parentlogindata']);exit;
        $this->viewBuilder()->layout('admin');
        //show all data in listing page
        $user = $this->Users->find('all')->where(['Users.role_id' => 1])->first();
        $get_managesettings = $this->getmanagesettings($user['db']);
        $rolepresentyear = $user['academic_year'];
        $this->set(compact('rolepresentyear'));
        $session = $this->request->session();
        $session->delete('parentlogindata');
        $role_id = $this->request->session()->read('Auth.User.role_id');


        $req_data = $_GET;
        // pr($req_data);exit;
        $conditions = [];
        $batch = $req_data['batch'];
        $class = $req_data['class_id'];
        $admission = $req_data['admissionyear'];
        $is_promote = $req_data['is_promote'];
        $section = $req_data['section_id'];
        $enroll = $req_data['enroll'];
        $transport = $req_data['transport'];
        $hostel = $req_data['hostel'];
        $fname = trim($req_data['fname']);
        $mobile = $req_data['mobile'];
        $mothername = trim($req_data['mothername']);
        $fathername = trim($req_data['fathername']);

        if (!empty($batch)) {
            $conditions['Students.batch'] = $batch;
        }
        if (!empty($class)) {
            $conditions['Students.class_id IN'] = $class;
        }
        if (!empty($section)) {
            $conditions['Students.section_id IN'] = $section;
        }
        if (!empty($enroll)) {
            $conditions['Students.enroll LIKE'] = '%' . trim($enroll) . '%';
        }
        if (!empty($fname)) {
            $conditions['UPPER(Students.fname) LIKE'] = '%' . trim(strtoupper($fname)) . '%';
        }
        if (!empty($mothername)) {
            $conditions['UPPER(Students.mothername) LIKE'] = '%' . trim(strtoupper($mothername)) . '%';
        }
        if (!empty($fathername)) {
            $conditions['UPPER(Students.fathername) LIKE'] = '%' . trim(strtoupper($fathername)) . '%';
        }
        if (!empty($mobile)) {
            $conditions['Students.mobile LIKE'] = '%' . trim($mobile) . '%';
        }
        if ($transport == '1') {
            $conditions['Students.is_transport'] = 'Y';
        }
        if ($hostel == '1') {
            $conditions['Students.is_hostel IS NOT'] = null;
        }
        $conditions['Students.status'] = 'Y';
        // pr($conditions);exit;

        $academic_session = $this->AcademicYear->find('list', ['keyField' => 'academicyear', 'valueField' => 'academicyear'])->order(['AcademicYear.id' => 'DESC'])->toArray();
        // pr($academic_session);exit;
        $this->set('academic_session', $academic_session);


        $sections = $this->Sections->find('all')->select(['id', 'title'])->where(['status' => 1])->order(['id' => 'ASC'])->toArray();
        // pr($get_managesettings);exit;
        // $classes = $this->Classes->find('list', [
        //     'keyField' => 'id',
        //     'valueField' => 'wordsc',
        // ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $classes = $this->Classections->find('list', [
            'keyField' => 'Classes.id',
            'valueField' => 'Classes.wordsc',
        ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();

        $houses = $this->Houses->find('all')->select(['id', 'name'])->where(['status' => 1])->order(['id' => 'ASC'])->toArray();

        $this->set(compact('sections', 'classes', 'houses', 'get_managesettings', 'class', 'section'));

        if ($role_id == ADMIN || $role_id == CENTER_COORDINATOR) {

            $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where([$conditions])->order(['Students.st_full_name' => 'ASC'])->limit(50);
        } elseif ($role_id == CBSE_FEE_COORDINATOR) {
            $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where([$conditions])->order(['Students.st_full_name' => 'ASC'])->limit(50);
        }
        $student_data = $this->paginate($student_data)->toarray();
        $this->set('students', $student_data);
        $this->set('role_id', $role_id);
    }

    public function search()
    {
        $this->loadModel('Students');
        $role_id = $this->request->session()->read('Auth.User.role_id');
        $user = $this->Users->find('all')->where(['Users.role_id' => 1])->first();
        $get_managesettings = $this->getmanagesettings($user['db']);
        $session = $this->request->session();
        $req_data = $_GET;
        // pr($req_data);exit;
        $batch = $req_data['batch'];
        $class = $req_data['class_id'];
        $section = $req_data['section_id'];
        $admission = $req_data['admissionyear'];
        $is_promote = $req_data['is_promote'];
        $enroll = $req_data['enroll'];
        $transport = $req_data['transport'];
        $hostel = $req_data['hostel'];
        $fname = trim($req_data['fname']);
        $mobile = $req_data['mobile'];
        $mothername = trim($req_data['mothername']);
        $fathername = trim($req_data['fathername']);
        // $session->delete('parentlogindata');
        // pr($this->request->data);exit;
        if ($class && $batch) {
            $session->delete('class');
            $session->delete('batch');
            $session->write('class', $class);
            $session->write('batch', $batch);
        } else {
            $session->delete('batch');
            $session->write('batch', $batch);
        }

        $conditions = [];
        if (!empty($batch)) {
            $conditions['Students.batch'] = $batch;
        }
        if (!empty($class)) {
            $conditions['Students.class_id IN'] = $class;
        }
        if (!empty($section)) {
            $conditions['Students.section_id IN'] = $section;
        }
        if (!empty($enroll)) {
            $conditions['Students.enroll LIKE'] = '%' . trim($enroll) . '%';
        }
        if (!empty($fname)) {
            $conditions['UPPER(Students.st_full_name) LIKE'] = '%' . trim(strtoupper($fname)) . '%';
        }
        if (!empty($mothername)) {
            $conditions['UPPER(Students.mothername) LIKE'] = '%' . trim(strtoupper($mothername)) . '%';
        }
        if (!empty($fathername)) {
            $conditions['UPPER(Students.fathername) LIKE'] = '%' . trim(strtoupper($fathername)) . '%';
        }
        if (!empty($mobile)) {
            $conditions['Students.mobile LIKE'] = '%' . trim($mobile) . '%';
        }
        if ($transport == '1') {
            $conditions['Students.is_transport'] = 'Y';
        }
        if ($hostel == '1') {
            $conditions['Students.is_hostel IS NOT'] = null;
        }
        $conditions['Students.status'] = 'Y';

        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        $session->delete('parentlogindata');
        $session->write('parentlogindata', $conditions);
        // $conditions[] = ['Students.status' => 'Y'];
        $query = $this->Students->find()
            ->contain(['Classes', 'Sections'])
            ->where($conditions)
            ->order(['Students.st_full_name' => 'ASC']);
        $students = $this->paginate($query)->toarray();
        // pr($students);exit;
        $this->set('role_id', $role_id);
        $this->set('students', $students);
        $this->set('get_managesettings', $get_managesettings);
    }


    //Download All Student List code updated by sanjay
    function download_students_excel()
    {
        $this->loadModel('Students');
        $data = $_SESSION['parentlogindata'];
        $students = $this->Students->find()
            ->contain(['Classes', 'Sections', 'Boards'])
            ->where($data)
            ->order(['Classes.id' => 'asc', 'Students.st_full_name' => 'ASC'])->toarray();
        // pr($students);
        // exit;
        $this->set('students', $students);
    }


    public function drop_out_student_search()
    {
        // pr($_GET);die;
        $role_id = $this->request->session()->read('Auth.User.role_id');
        $user = $this->Users->find('all')->where(['Users.role_id' => 1])->first();
        $get_managesettings = $this->getmanagesettings($user['db']);
        $session = $this->request->session();
        $req_data = $_GET;

        $conn = ConnectionManager::get('default');
        $batch = $req_data['batch'];
        $fathername = $req_data['fathername'];
        $class = $req_data['class_id'];
        $created = date('Y-m-d', strtotime($req_data['created']));
        $from_date = date('Y-m-d', strtotime($req_data['from_date']));
        $to_date = date('Y-m-d', strtotime($req_data['to_date']));
        $section = $req_data['section_id'];
        $enroll = $req_data['enroll'];
        $fname = $req_data['fname'];
        $status_tc = $req_data['status_tc'];

        $conditions = [];
        if (!empty($batch)) {
            $conditions['DropOutStudent.batch'] = $batch;
        }
        if (!empty($class)) {
            $conditions['DropOutStudent.class_id IN'] = $class;
        }
        if (!empty($section)) {
            $conditions['DropOutStudent.section_id IN'] = $section;
        }
        if (!empty($enroll)) {
            $conditions['DropOutStudent.enroll LIKE'] = '%' . trim($enroll) . '%';
        }
        if (!empty($fname)) {
            $conditions['UPPER(DropOutStudent.fname) LIKE'] = '%' . trim(strtoupper($fname)) . '%';
        }

        if (!empty($fathername)) {
            $conditions['UPPER(DropOutStudent.fathername) LIKE'] = '%' . trim(strtoupper($fathername)) . '%';
        }
        if (!empty($status_tc)) {
            $conditions['DropOutStudent.status_tc LIKE'] = '%' . $status_tc . '%';
        }
        if (!empty($created) && $created != '1970-01-01') {
            $conditions['DropOutStudent.created LIKE'] = '%' . $created . '%';
        }

        // Date Filter Logic
        if (!empty($from_date) && !empty($to_date)) {
            $conditions['DATE(DropOutStudent.created) >='] = $from_date;
            $conditions['DATE(DropOutStudent.created) <='] = $to_date;
        } elseif (!empty($from_date)) {
            $conditions['DATE(DropOutStudent.created) >='] = $from_date;
        } elseif (!empty($to_date)) {
            $conditions['DATE(DropOutStudent.created) <='] = $to_date;
        }

        // pr($conditions);exit;


        $session->delete('parentlogindata');
        $session->write('parentlogindata', $conditions);
        $query = $this->DropOutStudent->find()->contain(['Classes', 'Sections'])->where($conditions)->order(['DropOutStudent.id' => 'DESC']);
        // pr($query);die;
        $students = $this->paginate($query)->toarray();

        // for drop out student fees receipt
        $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $students[0]['s_id'], 'Studentfees.status' => 'Y', 'Studentfees.deposite_amt !=' => '0', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
        $i = 0;
        $stu_his = $this->Studentshistory->find('all')->where(['stud_id' => $students[0]['s_id']])->toarray();
        $i = 0;
        foreach ($student_datask as $stu) {
            if ($stu['acedmicyear'] == $students[0]['acedmicyear']) {
                $student_datask[$i]['class'] = $this->classsection($students[0]['class_id'], $students[0]['section_id']);
            } else if (!empty($stu_his)) {
                foreach ($stu_his as $val) {

                    if ($val['acedmicyear'] == $stu['acedmicyear']) {

                        $student_datask[$i]['class'] = $this->classsection($val['class_id'], $val['section_id']);
                    }
                }
            }

            $i++;
        }
        // $student_data = $this->paginate($student_data)->toarray();
        $this->set('studentfeesk', $student_datask);
        $this->set('students', $students);
    }

    //Download All download_drop_out_students code updated by sanjay
    function download_drop_out_students()
    {
        $this->loadModel('DropOutStudent');
        $conditions = $_SESSION['parentlogindata'];

        // pr($data);exit;
        $students = $this->DropOutStudent->find()->contain(['Classes', 'Sections'])->where($conditions)->order(['DropOutStudent.fname' => 'ASC'])->toarray();
        // pr($students);exit;
        $this->set('students', $students);
    }

    //done 12-05-2023
    // create view functionality
    public function view($id = null)
    {

        $this->loadModel('Exam');
        $this->loadModel('ExamResult');
        $this->viewBuilder()->layout('admin');
        //get all data particular id
        $this->set('ids', $id);
        if ($_GET['id']) {
            $this->set('selectid', $_GET['id']);
        }
        $db = $this->Users->find()->where(['role_id' => ADMIN])->first();
        $this->set(compact('db'));

        $doc_img = $this->Documents->find('all')->contain(['Documentcategory'])->where(['Documents.type' => 0, 'Documents.user_id' => $id])->order(['Documents.id' => 'DESC']);
        $this->set(compact('doc_img'));

        $students = $this->Students->find('all')->where(['Students.id' => $id, 'Students.status' => 'Y'])->first();
        $this->set(compact('students'));

        // $find_result = $this->ExamResult->find('all', ['conditions' => ['ExamResult.student_id' => $studentId, 'subject_id' => $value['id'], 'exam_id' => 0]])->first();


        // commented by ramesh (14-07-2023)
        // $students = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $id, 'Students.status' => 'Y'])->first();
        // $this->set(compact('students'));

        $Studentsall = $this->Students->get($id);
        $Studentsal = $Studentsall->comp_sid;
        if (!empty($Studentsal)) {
            $v = explode(",", $Studentsal);
            $subjects = $this->Subjects->find('all')->where(['Subjects.id IN' => $v])->toarray();
            $this->set(compact('subjects'));
        }
        $Studentsals = $Studentsall->opt_sid;
        if (!empty($Studentsals)) {
            $vr = explode(",", $Studentsals);
            $subjectss = $this->Subjects->find('all')->where(['Subjects.id IN' => $vr])->toarray();
            $this->set(compact('subjectss'));
        }
        $classessss = $this->Guardians->find()->where(['Guardians.user_id' => $id, 'Guardians.type' => '0'])->first();
        $this->set(compact('classessss'));
        // $address = $this->Address->find('all')->contain(['CurCountry', 'PerCountry', 'CurStates', 'PerStates', 'CurStates', 'PerStates', 'CurCity', 'PerCity'])->where(['Address.type' => 0, 'Address.user_id' => $id])->first();
        // $this->set(compact('address'));

        $studentshistory = $this->Studentshistory->find('all')->contain(['Classes', 'Sections'])->where(['Studentshistory.stud_id' => $id])->order(['Studentshistory.acedmicyear' => 'DESC'])->toarray();
        $studentold = $this->Students->find('all')->where(['Students.id' => $id, 'Students.oldenroll !=' => '0'])->first();
        $oldenrool = $studentold['oldenroll'];

        if ($oldenrool) {
            $studsentold = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.enroll' => $oldenrool])->toarray();
            $this->set(compact('studsentold'));
            $studentshistory2 = $this->Studentshistory->find('all')->contain(['Classes', 'Sections'])->where(['Studentshistory.stud_id' => $studsentold[0]['id']])->order(['Studentshistory.acedmicyear' => 'DESC'])->toarray();
            $studentshistory = array_merge($studentshistory, $studentshistory2);
        }
        $this->set(compact('studentshistory'));
    }

    //done 12-05-2023
    public function dropview($id)
    {
        $this->viewBuilder()->layout('admin');

        $this->set('ids', $id);
        if ($_GET['id']) {
            $this->set('selectid', $_GET['id']);
        }

        $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where(['DropOutStudent.id' => $id])->first();
        $this->set(compact('students'));

        $studentshistory = $this->Studentshistory->find('all')->contain(['Classes', 'Sections'])->where(['Studentshistory.stud_id' => $students['s_id']])->order(['Studentshistory.acedmicyear' => 'DESC'])->toarray();

        $doc_img = $this->Documents->find('all')->contain(['Documentcategory'])->where(['Documents.type' => 0, 'Documents.user_id' => $students['s_id']])->order(['Documents.id' => 'DESC'])->toarray();
        $this->set(compact('doc_img'));
        // pr($studentshistory);
        // exit;
        $Studentsall = $this->DropOutStudent->get($id);
        $Studentsal = $Studentsall->comp_sid;
        if (!empty($Studentsal)) {
            $v = explode(",", $Studentsal);
            $subjects = $this->Subjects->find('all')->where(['Subjects.id IN' => $v])->toarray();
            $this->set(compact('subjects'));
        }
        $Studentsals = $Studentsall->opt_sid;
        if (!empty($Studentsals)) {
            $vr = explode(",", $Studentsals);
            $subjectss = $this->Subjects->find('all')->where(['Subjects.id IN' => $vr])->toarray();
            $this->set(compact('subjectss'));
        }

        $classessss = $this->Guardians->find()->where(['Guardians.user_id' => $id, 'Guardians.type' => '0'])->first();
        $this->set(compact('classessss'));

        // $address = $this->Address->find('all')->contain(['CurCountry', 'PerCountry', 'CurStates', 'PerStates', 'CurStates', 'PerStates', 'CurCity', 'PerCity'])->where(['Address.type' => 0, 'Address.user_id' => $id])->first();
        $this->set(compact('address'));

        $studentold = $this->DropOutStudent->find('all')->where(['DropOutStudent.id' => $id, 'DropOutStudent.oldenroll !=' => '0'])->first();
        $oldenrool = $studentold['oldenroll'];

        if ($oldenrool) {
            $studsentold = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.enroll' => $oldenrool])->toarray();
            $this->set(compact('studsentold'));
            $studentshistory2 = $this->Studentshistory->find('all')->contain(['Classes', 'Sections'])->where(['Studentshistory.stud_id' => $studsentold[0]['id']])->order(['Studentshistory.acedmicyear' => 'DESC'])->toarray();
            $studentshistory = array_merge($studentshistory, $studentshistory2);
        }

        $this->set(compact('studentshistory'));
    }

    // create delete functionality
    //done 12-05-2023
    public function delete($id)
    {
        $contact = $this->Students->get($id);
        $sections = $this->Documents->find('all')->select(['photo'])->where(['Documents.user_id' => $id])->toArray();
        foreach ($sections as $img) {
            $imglink = $img['photo'];
            unlink('img/' . $imglink);
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
            $this->Flash->error(__('You can not delete this record because it is used in another table.'));
            $this->set('error', $error);
            return $this->redirect(['action' => 'index']);
        }
    }
    public function deletesms($id)
    {
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
    //done 12-05-2023
    public function deletedocument($id)
    {
        $contact = $this->Documents->get($id);
        $sections = $this->Documents->find('all')->select(['photo'])->where(['Documents.id' => $id])->toArray();
        $userid = $contact->user_id;
        foreach ($sections as $img) {
            $imglink = $img['photo'];
            $file = WWW_ROOT . 'img/' . $imglink;
            unlink($file);
        }
        //delete particular entry
        if ($this->Documents->delete($contact)) {
            $this->Flash->success(__('The documents with id: {0} has been deleted.', ($id)));
            return $this->redirect(['action' => 'view/' . $userid . '?id=documents']);
        }
    }

    public function sendsms()
    {
        // send sms count fatch from main school table
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        $db = $branch[0];

        if ($db == 'canvas') {
            $connss = ConnectionManager::get('default');
            $query2 = "SELECT * FROM $db.users ";
            $res = $connss->execute($query2)->fetchAll('assoc');
        } else {
            $id = $this->request->session()->read('Auth.User.c_id');
            $res = $this->Users->find('all')->where(['c_id' => $id])->toArray();
        }
        $user_id = $res[0]['c_id'];
        $connss = ConnectionManager::get('default');
        $db_name = DB_NAME;
        $query2 = "SELECT * FROM $db_name.schools where id= $user_id ";
        $resss = $connss->execute($query2)->fetchAll('assoc');
        // pr($res); die;
        $this->set('balance', $resss);

        //-------------------------------- code end ---------------//

        $smslist = $this->Smsmanager->find('all')->where(['status' => 'Y'])->order(['id' => 'ASC'])->toArray();
        $this->set('smslist', $smslist);

        $smscategoryslist = $this->Smsmanager->find('list', [
            'keyField' => 'category',
            'valueField' => 'category',
        ])->where(['status' => 'Y', 'sms_for IN' => ['S', 'B']])->order(['id' => 'ASC'])->toArray();
        $this->set('smscategoryslist', $smscategoryslist);
    }

    public function find_smstemplate()
    {
        $cat = $this->request->data['id'];
        $smslist = $this->Smsmanager->find('all')->select(['message'])->where(['category' => $cat])->order(['id' => 'ASC'])->first();
        echo $smslist['message'];
        die;
    }

    public function file_get_contents_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function send_smsmobile()
    {
        $mobile = $this->request->data['sid'];

        $mobiles = explode(',', $mobile);

        //---------------sms count and manage------------------------//
        $cnt = 0;
        for ($i = 0; $i < count($mobiles); $i++) {
            $cnt++;
        }
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        $db = $branch[0];

        if ($db == 'canvas') {
            $connss = ConnectionManager::get('default');
            $query2 = "SELECT * FROM $db.users ";
            $res = $connss->execute($query2)->fetchAll('assoc');
        } else {
            $ids = $this->request->session()->read('Auth.User.c_id');
            $res = $this->Users->find('all')->where(['c_id' => $ids])->toArray();
        }
        $user_id = $res[0]['c_id'];
        $connss = ConnectionManager::get('default');
        $db_name = DB_NAME;
        $query2 = "SELECT * FROM $db_name.schools where id= $user_id ";
        $resss = $connss->execute($query2)->fetchAll('assoc');

        $sent_msg = $resss[0]['msg_count'];
        $clint_id = $resss[0]['id'];
        $total_sent = $sent_msg - $cnt;

        // agere whatsapp api nhi hoto error show code
        if (empty($resss[0]['whatsapp_token'])) {
            echo "<b style='color:red;'>Kindly contact to administrator !!!!</b>";
            die;
        }
        if ($sent_msg >= $cnt) {
            $conn = ConnectionManager::get('default');
            $conn->execute("UPDATE $db_name.`schools` SET `msg_count`='$total_sent' WHERE id='$clint_id'");
        }

        //-------------------------------- code end ---------------//



        $messageid = $this->request->data['messageid'];
        $cat = $this->request->data['id'];

        $smslist = $this->Smsmanager->find('all')->select(['message'])->where(['category' => $cat])->order(['id' => 'ASC'])->first();
        $mesg = $smslist['message'];

        $smsconfig = $this->Sms->find('all')->where(['id' => '1'])->order(['id' => 'ASC'])->first();
        $workingkey = $smsconfig['workingkey'];
        $sender = $smsconfig['sender'];
        //msg less then and validation if

        if ($sent_msg >= $cnt) {
            foreach ($mobiles as $key => $item) {
                $mobilesas = '+91' . $item;
                //pr($item); die;
                // $result = $this->file_get_contents_curl('http://alerts.prioritysms.com/api/web2sms.php?workingkey=' . $workingkey . '&to=' . $item . '&sender=' . $sender . '&message=' . urlencode($mesg));
                // Whatsapp msg Api
                $result = $this->whatsappmsg($mobilesas, $mesg);
                if ($result == "Invalid Input Data") {
                    echo "<b style='color:red;'>Invalid Input Data !!!!</b>";
                    die;
                } elseif ($result == "Invalid Mobile Numbers") {
                    echo "<b style='color:red;'>Invalid Mobile Numbers !!!!</b>";
                    die;
                } elseif ($result == "Insufficient credits") {
                    echo "<b style='color:red;'>Insufficient credits !!!!</b>";
                    die;
                } else {
                }
            } //pr($cnt); 
            echo "<b style='color:green;'>Send Sucessfully to " . $item . " !!!!</b><br>";
            die;
        } else {
            echo "<b style='color:red;'>Insufficient credits !!!!</b>";
            die;
        }
        die;
    }

    public function smsmanager($id = null)
    {
        $this->viewBuilder()->layout('admin');
        //-------------------- Show Whatsapp Message Count-------------------------//
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        $db = $branch[0];
        if ($db == 'canvas') {
            $connss = ConnectionManager::get('default');
            $query2 = "SELECT * FROM $db.users ";
            $res = $connss->execute($query2)->fetchAll('assoc');
        } else {
            $ids = $this->request->session()->read('Auth.User.c_id');
            $res = $this->Users->find('all')->where(['c_id' => $ids])->toArray();
        }
        $user_id = $res[0]['c_id'];
        $connss = ConnectionManager::get('default');
        $db_name = DB_NAME;
        $query2 = "SELECT * FROM $db_name.schools where id= $user_id ";
        $resss = $connss->execute($query2)->fetchAll('assoc');
        $msg_count = $resss[0]['msg_count'];
        $this->set('msg_count', $msg_count);
        $smslist = $this->Smsmanager->find('all')->where(['Smsmanager.status' => 'Y'])->order(['id' => 'ASC'])->toArray();
        $this->set('smslist', $smslist);
        if (isset($id) && !empty($id)) {
            $banks = $this->Smsmanager->get($id);
        } else {
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
    public function add($fromnos = null)
    {

        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        $user = $this->Users->find('all')->where(['Users.role_id IN' => [ADMIN, BRANCH_HEAD]])->first();
        $userDb = $user['db'];
        $this->set('academic_year', $user['academic_year']);
        $this->set(compact('userDb'));

        $batch = $this->AcademicYear->find('list', ['keyField' => 'academicyear', 'valueField' => 'academicyear'])->order(['AcademicYear.id' => 'DESC'])->limit(3)->toArray();
        $this->set('batch', $batch);

        $board_names = $this->Board->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        // pr($board_names); die;
        $this->set('board_names', $board_names);

        // $course_name = $this->Board->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        // $this->set('course_name', $course_name);

        $applicanst = $this->Applicant->find('all')->where(['Applicant.sno' => $fromnos])->order(['Applicant.id' => 'DESC'])->first();
        $this->set('fromnos', $fromnos);
        $this->viewBuilder()->layout('admin');



        $boards = $this->Boards->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $studentsid = $this->Students->find('all')->order(['enroll' => 'DESC'])->first();
        $this->set('studentsid', $studentsid);
        $this->set('bord', $boards);


        if ($rolepresent == ADMIN || $rolepresent == BRANCH_HEAD || $rolepresent == CENTER_COORDINATOR || $rolepresent == CBSE_FEE_COORDINATOR) {
            //use for form number +1
            $studentslast_insert = $this->Students->find('all')->order(['formno' => 'DESC'])->first();
            $this->set('studentslast_insert', $studentslast_insert);
        }

        $user = $this->Users->find('all')->where(['Users.role_id' => ADMIN])->first();
        //this is use to check enroll with fee ya without fee
        $enroll_without_fees = $user['enroll_without_fees'];
        $acedmicyear = $user['academic_year'];
        $this->set('acedmicyearfi', $acedmicyear);
        $this->set('enroll_without_fees', $enroll_without_fees);

        $course = $this->Classes->find('list', [
            'keyField' => 'id',
            'valueField' => 'wordsc',
        ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $this->set('course', $course);


        $sections = $this->Sections->find('list')->select(['id', 'title'])->where(['status' => 1])->order(['title' => 'ASC'])->toArray();

        if ($rolepresent == ADMIN || $rolepresent == CENTER_COORDINATOR) {
            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        }

        $houses = $this->Houses->find('all')->select(['id', 'name'])->where(['status' => 1])->order(['id' => 'ASC'])->toArray();
        $this->set(compact('sections', 'houses'));


        $students = $this->Students->newEntity();
        $guardians = $this->Guardians->newEntity();

        if ($this->request->is(['post', 'put'])) {

            $authorizedRoles = [ADMIN, BRANCH_HEAD, CENTER_COORDINATOR, CBSE_FEE_COORDINATOR];
            if (in_array($rolepresent, $authorizedRoles)) {
            } else {
                $this->Flash->error(__('You are not authorized at this location.'));
                return $this->redirect($this->referer());
            }


            if ($this->request->data['date_of_joining']) {
                $this->request->data['date_of_joining'] = date('Y-m-d H:i:s', strtotime($this->request->data['date_of_joining']));
            }

            if ($this->request->data['applocation_form_date']) {
                $this->request->data['applocation_form_date'] = $this->request->data['applocation_form_date'];
            }

            $this->request->data['ruhs_rnc_rpmc_enroll'] = trim($this->request->data['ruhs_rnc_rpmc_enroll']);
            $this->request->data['hindiname'] = trim($this->request->data['hindiname']);

            if ($this->request->data['feecat'] == 'Other') {
                $this->request->data['fee_submittedby'] = $this->request->data['fee_submittedby'];
            } elseif ($this->request->data['feecat'] == 'Father') {
                $this->request->data['fee_submittedby'] = $this->request->data['fathername'];
            } elseif ($this->request->data['feecat'] == 'Mother') {
                $this->request->data['fee_submittedby'] = $this->request->data['mothername'];
            }

            if ($this->request->data['file12']['name'] != '') {
                $oimg = $this->request->data['file12'];
                if ($oimg != '') {

                    if ($this->request->data['file12']['tmp_name']) {
                        $db = $this->request->session()->read('Auth.User.db');
                        $directory = WWW_ROOT . $db . "_image/student/" . $studentss['file'];
                        unlink($directory);
                        $ext = pathinfo($this->request->data['file12']['name'], PATHINFO_EXTENSION);
                        $filename = uniqid() . "." . $ext;
                        // $path = WWW_ROOT . $db . "_image/student/" . $filename;
                        $path = WWW_ROOT . "student/" . $filename;
                        // pr( $path);exit;

                        // pr( $path);exit;
                        if (move_uploaded_file($this->request->data['file12']['tmp_name'], $path));
                        $this->request->data['file'] = $filename;
                    }
                }
            }

            if ($this->request->data['category'] != "Migration") {

                $user = $this->Users->find('all')->where(['Users.role_id' => ADMIN])->first();
                $userTable = TableRegistry::get('Students');
                $exists = $userTable->exists(['fname' => $this->request->data['fname'], 'mobile' => $this->request->data['mobile']]);

                if ($this->request->data['adaharnumber'] != '') {
                    $exists3 = $userTable->exists(['adaharnumber' => $this->request->data['adaharnumber']]);
                }

                if ($exists) {
                    $this->Flash->error(
                        __("Student already exits in  with records!!!")
                    );
                } elseif ($exists2) {
                    $this->Flash->error(
                        __("Form no. already exits in  records!!!")
                    );
                } elseif ($exists3) {
                    $this->Flash->error(
                        __("Aadhar no. already exits in  records!!!")
                    );
                } else {

                    // Capitalize and remove spaces from first name, middle name, and last name
                    $this->request->data['fname'] = ucfirst(preg_replace('/\s+/', '', $this->request->data['fname']));
                    $this->request->data['middlename'] = ucfirst(preg_replace('/\s+/', '', $this->request->data['middlename']));
                    $this->request->data['lname'] = ucfirst(preg_replace('/\s+/', '', $this->request->data['lname']));

                    // Construct st_full_name based on the presence of first name, middle name, and last name
                    $st_full_name = $this->request->data['fname'];
                    if (!empty($this->request->data['middlename'])) {
                        $st_full_name .= ' ' . $this->request->data['middlename'];
                    }
                    if (!empty($this->request->data['lname'])) {
                        $st_full_name .= ' ' . $this->request->data['lname'];
                    }
                    $this->request->data['st_full_name'] = $st_full_name;

                    $this->request->data['dob'] = date('Y-m-d', strtotime($this->request->data['dob']));
                    $this->request->data['fathername'] = $this->request->data['fathername'];
                    $this->request->data['mothername'] = $this->request->data['mothername'];

                    $rolepresent = $user['academic_year'];
                    $this->request->data['acedmicyear'] = ACADEMIC_YEAR;
                    $this->request->data['session'] = ACADEMIC_YEAR;
                    $this->request->data['category'] = $this->request->data['cast'];
                    if ($this->request->data['cast'] == 'Others') {
                        $this->request->data['cast'] = $this->request->data['other_cast_text'];
                    }

                    // Find board based on class id 
                    $findBoardId = $this->Classes->find('all')->where(['id' => $this->request->data['class_id']])->select('board_id')->first();
                    $this->request->data['admissionyear'] = $rolepresent;
                    $this->request->data['admissionclass'] = $this->request->data['class_id'];


                    //This data for School_ERP Users Table
                    $mob = $this->request->data['mobile'];
                    $enrosll = "DW" . rand(1231, 7879);
                    $cdate = date('Y-m-d H:i:s');
                    $database_name = $user['db'];
                    $accedmic_year = $this->request->data['admissionyear'];
                    $Bord = (!empty($findBoardId['board_id'])) ? $findBoardId['board_id'] : 1;
                    $this->request->data['board_id'] = $Bord;
                    $students = $this->Students->patchEntity($students, $this->request->data);
                    // pr($cdate);exit;
                    if ($result = $this->Students->save($students)) {
                        $username = $result['st_full_name'];
                        // return $this->redirect(['controller' => 'Studentfees', 'action' => 'view/' . $id . '/' . $acedmicyear]);
                        $ids = $result->id;
                        $curr_year = ACADEMIC_YEAR;
                        //Insert Data in School_ERP Users Table
                        $conn = ConnectionManager::get('default');
                        $db_name = DB_NAME;
                        $inserts = "INSERT INTO $db_name.`users` (`user_name`,`c_id`,`academic_year`, `email`,`student_id`, `password`, `confirm_pass`, `created`,  `role_id`, `db`,`board`,`mobile`) VALUES ('$username','2','$curr_year','$enrosll', '$ids','$2y$10$.vwir1Fyl5EkpHbNfEYFl.vU7raO0gFMuM.QnwVqpLM77Mjlot1Zm','12345', '$cdate',2,'$database_name','$Bord','$mob')";
                        $exicute = $conn->execute($inserts);
                        $id = $result->id;
                        $acedmicyear = $result->acedmicyear;
                        $formno = $result->formno;
                        // form data show in form number
                        // if ($formno) {
                        //     $conn = ConnectionManager::get('default');
                        //     $detail = 'UPDATE `applicants` SET `status` ="Y" WHERE `applicants`.`sno` = "' . $formno . '"';
                        //     $results = $conn->execute($detail);
                        // }
                        // $username = $result->username;
                        $userff = $this->Users->newEntity();
                        $fathername = $result->fathername;
                        $password = $result->password;
                        $password = $result->password;
                        $mobile = $result->mobile;
                        $board_id = $result->board_id;
                        $enroll_id = $result->enroll;
                        if ($board_id == 1) {
                            $this->request->data['email'] = "DP" . $enroll_id;
                        } elseif ($board_id == 2) {
                            $this->request->data['email'] = "DM" . $enroll_id;
                        } elseif ($board_id == 3) {
                            $this->request->data['email'] = "DPT" . $enroll_id;
                        }
                        $this->request->data['user_name'] = $username;
                        $this->request->data['mobile'] = $mobile;
                        $this->request->data['academic_year'] = ACADEMIC_YEAR;
                        $this->request->data['password'] = $this->setPassword($this->request->data['email']);
                        $this->request->data['confirm_pass'] = $this->request->data['email'];
                        $this->request->data['board'] = $Bord;
                        $this->request->data['role_id'] = '2';
                        $this->request->data['fkey'] = '0';
                        $this->request->data['latefee'] = '0';
                        $this->request->data['student_id'] = $id;
                        $this->request->data['db'] = $user['db'];
                        $this->request->data['c_id'] = $user['c_id'];
                        $userff = $this->Users->patchEntity($userff, $this->request->data);
                        $this->Users->save($userff);

                        // student_id,student_accademic
                        $this->request->session()->write('student_id', $id);
                        $this->request->session()->write('student_accademic', ACADEMIC_YEAR);
                        // return $this->redirect(['controller' => 'Studentfees', 'action' => 'view/' . $id . '/' . $acedmicyear]);
                        return $this->redirect(['controller' => 'Studentfees', 'action' => 'view']);
                    } else { //check validation error
                        if ($students->errors()) {
                            $error_msg = [];
                            foreach ($students->errors() as $errors) {
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
            } else {
                // echo 'else';die;
                $this->request->data['fname'] = ucfirst(preg_replace('/\s+/', '', $this->request->data['fname']));
                $this->request->data['dob'] = date('Y-m-d', strtotime($this->request->data['dob']));
                // save all data in database
                if ($this->request->data['fathername']) {
                    $this->request->data['fathername'] = $this->request->data['fathername'];
                }
                if ($this->request->data['mothername']) {
                    $this->request->data['mothername'] = $this->request->data['mothername'];
                }
                $user = $this->Users->find('all')->where(['Users.role_id' => ADMIN])->first();
                $rolepresent = $user['academic_year'];
                $this->request->data['acedmicyear'] = ACADEMIC_YEAR;
                if ($this->request->data['admissionyear'] == "") {
                    $this->request->data['admissionyear'] = $rolepresent;
                } else {
                    $this->request->data['admissionyear'] = $this->request->data['admissionyear'];
                }
                $this->request->data['admissionclass'] = $this->request->data['class_id'];
                //class base board find
                $classes_base_board = $this->Classes->find('all')->where(['Classes.status' => '1', 'id' => $this->request->data['classd_id']])->order(['Classes.sort' => 'ASC'])->first();
                $this->request->data['board_id'] = $classes_base_board['board_id'];

                if ($this->request->data['board_id']) {
                    $student_data = $this->Students->find('all')->where(['Students.enroll' => $this->request->data['oldenroll'], 'Students.board_id' => $this->request->data['board_id'], 'Students.status' => 'Y'])->first();
                    // pr($this->request->data['oldenroll']);exit;

                    if ($student_data) {
                        $peopleTable = TableRegistry::get('Students');
                        $oQuery = $peopleTable->query();
                        $oQuery->insert([
                            'fname',
                            'middlename',
                            'lname',
                            'fee_submittedby',
                            'board_id',
                            'created',
                            'fathername',
                            'mothername',
                            'username',
                            'password',
                            'dob',
                            'enroll',
                            'mobile',
                            'mobile2',
                            'sms_mobile',
                            'formno',
                            'adaharnumber',
                            'cast',
                            'parent_id',
                            'house_id',
                            'class_id',
                            'category',
                            'section_id',
                            'gender',
                            'photo',
                            'bloodgroup',
                            'religion',
                            'address',
                            'city',
                            'nationality',
                            'admissionyear',
                            'acedmicyear',
                            'status',
                            'file',
                            'comp_sid',
                            'opt_sid',
                            'h_id',
                            'room_no',
                            'is_transport',
                            'transportloc_id',
                            'v_num',
                            'dis_fees',
                            'dis_transport',
                            'is_discount',
                            'discountcategory',
                            'due_fees',
                            'token',
                            'rf_id',
                            'is_special',
                            'oldenroll',
                            'is_lc',
                            'disability',
                            'mother_tounge',
                            'f_qualification',
                            'f_occupation',
                            'm_qualification',
                            'm_occupation',
                            'f_phone',
                            'm_phone',
                            'admissionclass',
                            'previous_board'
                        ])->values([
                            'fname' => $student_data['fname'],
                            'middlename' => $student_data['middlename'],
                            'lname' => $student_data['lname'],
                            'fee_submittedby' => $student_data['fee_submittedby'],
                            'board_id' => $this->request->data['board_id'],
                            'created' => $student_data['created'],
                            'fathername' => $student_data['fathername'],
                            'mothername' => $student_data['mothername'],
                            'username' => $student_data['username'],
                            'password' => $student_data['password'],
                            'dob' => $student_data['dob'],
                            'enroll' => $this->request->data['enroll'],
                            'mobile' => $student_data['mobile'],
                            'mobile2' => $student_data['mobile2'],
                            'sms_mobile' => $student_data['sms_mobile'],
                            'formno' => $student_data['formno'],
                            'adaharnumber' => $student_data['adaharnumber'],
                            'cast' => $student_data['cast'],
                            'parent_id' => $student_data['parent_id'],
                            'house_id' => $this->request->data['h_id'],
                            'class_id' => $this->request->data['classd_id'],
                            'category' => $student_data['category'],
                            'section_id' => $this->request->data['section_id'],
                            'gender' => $student_data['gender'],
                            'photo' => $student_data['photo'],
                            'bloodgroup' => $student_data['bloodgroup'],
                            'religion' => $student_data['religion'],
                            'address' => $student_data['address'],
                            'city' => $student_data['city'],
                            'nationality' => $student_data['nationality'],
                            'admissionyear' => $student_data['admissionyear'],
                            'acedmicyear' => $student_data['acedmicyear'],
                            'status' => $student_data['status'],
                            'file' => $student_data['file'],
                            'comp_sid' => '',
                            'opt_sid' => '',
                            'h_id' => $this->request->data['h_id'],
                            'room_no' => $student_data['room_no'],
                            'is_transport' => $student_data['is_transport'],
                            'transportloc_id' => $student_data['transportloc_id'],
                            'v_num' => $student_data['v_num'],
                            'dis_fees' => $student_data['dis_fees'],
                            'dis_transport' => $student_data['dis_transport'],
                            'is_discount' => $student_data['is_discount'],
                            'discountcategory' => '',
                            'due_fees' => $student_data['due_fees'],
                            'token' => $student_data['token'],
                            'rf_id' => $student_data['rf_id'],
                            'is_special' => $student_data['is_special'],
                            'oldenroll' => $this->request->data['oldenroll'],
                            'is_lc' => $student_data['is_lc'],
                            'disability' => $student_data['disability'],
                            'mother_tounge' => $student_data['mother_tounge'],
                            'f_qualification' => $student_data['f_qualification'],
                            'f_occupation' => $student_data['f_occupation'],
                            'm_qualification' => $student_data['m_qualification'],
                            'm_occupation' => $student_data['m_occupation'],
                            'f_phone' => $student_data['f_phone'],
                            'm_phone' => $student_data['m_phone'],
                            'admissionclass' => $student_data['admissionclass'],
                            'previous_board' => $this->request->data['previous_board']
                        ]);
                        $oQuery->execute();
                        $conns = ConnectionManager::get('default');
                        $conns->execute("UPDATE `students` SET category='Migration', status='N' WHERE `id`='" . $student_data['id'] . "'");
                        $result = $this->Students->find('all')->where(['Students.enroll' => $this->request->data['enrolls'], 'Students.board_id' => $this->request->data['board_id'], 'Students.status' => 'Y'])->first();
                        $id = $result['id'];
                        $username = $result['username'];
                        $fathername = $result['fathername'];
                        $password = $result['password'];
                        $mobile = $result['mobile'];
                        $board_id = $result['board_id'];
                        $enroll_id = $result['enroll'];
                        $userff = $this->Users->newEntity();
                        if ($this->request->data['board_id'] == 1) {
                            $this->request->data['email'] = "DP" . $enroll_id;
                        } elseif ($this->request->data['board_id'] == 2) {
                            $this->request->data['email'] = "DM" . $enroll_id;
                        } elseif ($this->request->data['board_id'] == 3) {
                            $this->request->data['email'] = "DPT" . $enroll_id;
                        }
                        $this->request->data['user_name'] = $student_data['fname'];
                        $this->request->data['mobile'] = $mobile;
                        $this->request->data['academic_year'] = ACADEMIC_YEAR;
                        $this->request->data['password'] = $this->setPassword($this->request->data['email']);
                        $this->request->data['confirm_pass'] = $this->request->data['email'];
                        $this->request->data['role_id'] = '2';
                        $this->request->data['fkey'] = '0';
                        $this->request->data['latefee'] = '0';
                        $this->request->data['student_id'] = $id;
                        $this->request->data['db'] = $user['db'];
                        $this->request->data['c_id'] = $user['c_id'];
                        $userff = $this->Users->patchEntity($userff, $this->request->data);

                        $this->Users->save($userff);
                        $this->Flash->success(__('Student Migrated Successfully.'));
                        return $this->redirect(['action' => 'index']);
                    } else {
                        $this->Flash->error(__('Student Enroll not found for Migaration !!!'));
                        return $this->redirect(['action' => 'index']);
                    }
                }
            }
        }
    }

    // edit personal detail
    //change role id to role name
    public function edit($id = null)
    {
        // pr($this->request->data);exit;
        $this->viewBuilder()->layout('admin');

        $courses = $this->Classections->find('list', [
            'keyField' => 'Classes.id',
            'valueField' => 'Classes.title',
        ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $this->set('course', $courses);


        $sections = $this->Sections->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('sections', $sections);


        $academic_session = $this->AcademicYear->find('list', ['keyField' => 'academicyear', 'valueField' => 'academicyear'])->order(['AcademicYear.id' => 'DESC'])->toArray();
        $this->set('academic_session', $academic_session);

        $board_names = $this->Board->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $this->set('board_names', $board_names);


        $db = $this->Users->find()->where(['role_id' => 1])->first();
        $this->set(compact('db'));

        // $admissionclass = $this->AdmissionClasses->find('list', [
        //     'keyField' => 'id',
        //     'valueField' => 'title',
        // ])->order(['sort' => 'ASC'])->toArray();
        // $this->set('admissionclass', $admissionclass);

        // $rolepresent = $this->request->session()->read('Auth.User.role_id');
        // if ($rolepresent == 1 || $rolepresent == 6) {
        //     $classes = $this->Classections->find('list', [
        //         'keyField' => 'Classes.id',
        //         'valueField' => 'Classes.title',
        //     ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        //     $this->set('classes', $classes);
        // }


        if (isset($id) && !empty($id)) {
            $students = $this->Students->get($id);
            $class_id = $students->class_id;
            $sid = $students->id;
            $acedmicyearfi = $students->acedmicyear;
            $this->set('acedmicyearfi', $acedmicyearfi);
            $select = $students->comp_sid;
            $this->set('class_id', $class_id);
        }

        $this->set('sid', $id);
        $this->set('students', $students);


        if ($this->request->is(['post', 'put'])) {

            // pr($this->request->data);
            // exit;
            $this->request->data['fname'] = trim($this->request->data['fname']);
            $this->request->data['middlename'] = trim($this->request->data['middlename']);
            $this->request->data['lname'] = trim($this->request->data['lname']);

            if ($this->request->data['feecat'] == 'Other') {
                $this->request->data['fee_submittedby'] = $this->request->data['fee_submittedby'];
            } elseif ($this->request->data['feecat'] == 'Father') {
                $this->request->data['fee_submittedby'] = $this->request->data['fathername'];
            } elseif ($this->request->data['feecat'] == 'Mother') {
                $this->request->data['fee_submittedby'] = $this->request->data['mothername'];
            }

            if ($this->request->data['date_of_joining']) {
                $this->request->data['date_of_joining'] = date('Y-m-d H:i:s', strtotime($this->request->data['date_of_joining']));
            }

            if ($this->request->data['applocation_form_date']) {
                $this->request->data['applocation_form_date'] = $this->request->data['applocation_form_date'];
            }
            // $comp = implode(",", $this->request->data['comp_sid']);
            // $opt_sid = implode(",", $this->request->data['opt_sid']);
            // $this->request->data['comp_sid'] = $comp;
            // $this->request->data['opt_sid'] = $opt_sid;

            $this->request->data['dob'] = $this->request->data['dob'];

            if ($students['board_id'] == 1) {
                $bordd = "DP";
            } elseif ($students['board_id'] == 2) {
                $bordd = "DM";
            } elseif ($students['board_id'] == 3) {
                $bordd = "DPT";
            }

            // Student Profile Image 
            if ($this->request->data['file12']['name'] != '') {
                unlink(WWW_ROOT . "student/" . $students['file']);
                $ext = pathinfo($this->request->data['file12']['name'], PATHINFO_EXTENSION);
                $filename = $this->request->data['fname'] . '_' . uniqid() . "." . $ext;
                // $path = WWW_ROOT . $db['db'] . "_image/student/" . $filename;
                $path = WWW_ROOT . "student/" . $filename;
                move_uploaded_file($this->request->data['file12']['tmp_name'], $path);
                $this->request->data['file'] = $filename;
            } else {
                $this->request->data['file'] = $students['file'];
            }
            // pr($this->request->data);exit;

            $this->request->data['ruhs_rnc_rpmc_enroll'] = trim($this->request->data['ruhs_rnc_rpmc_enroll']);
            $this->request->data['hindiname'] = trim($this->request->data['hindiname']);
            $this->request->data['f_phone'] = $this->request->data['f_phone'];
            $this->request->data['m_phone'] = $this->request->data['m_phone'];
            $this->request->data['feecatss'] = $this->request->data['feecatss'];

            $this->request->data['category'] = $this->request->data['cast'];
            if ($this->request->data['cast'] == 'Others') {
                $this->request->data['cast'] = $this->request->data['other_cast_text'];
            }

            // Construct st_full_name based on the presence of first name, middle name, and last name
            $st_full_name = $this->request->data['fname'];
            if (!empty($this->request->data['middlename'])) {
                $st_full_name .= ' ' . $this->request->data['middlename'];
            }
            if (!empty($this->request->data['lname'])) {
                $st_full_name .= ' ' . $this->request->data['lname'];
            }
            $this->request->data['st_full_name'] = $st_full_name;


            $this->request->data['dob'] = date('Y-m-d', strtotime($this->request->data['dob']));
            // Old Name
            $prev = $this->request->data['oldname'];
            $full_name = $this->request->data['fname'];
            $middlename = $this->request->data['middlename'];
            $lname = $this->request->data['lname'];
            $addname = strtolower(($full_name . '' . $middlename . '' . $lname));
            $old = str_replace(' ', '', $prev);
            $oldlower = strtolower($old);
            $allname = str_replace(' ', '', $addname);
            $result = strcmp($oldlower, $allname);
            if ($result == 0) {
            } else {
                $this->request->data['old_name'] = $prev;
            }
            // pr($this->request->data);exit;
            $studentss = $this->Students->patchEntity($students, $this->request->data);
            //This data for School_ERP Users Table
            $fnames = $this->request->data['st_full_name'];
            $mob = $this->request->data['mobile'];
            $enrosll = "C" . rand(1231, 7879);
            $cdate = date('Y-m-d H:i:s');
            $st_id = $students['id'];
            $database = $this->request->session()->read('Auth.User.db');
            $conn = ConnectionManager::get('default');
            $db_name = DB_NAME;
            $find = "SELECT * FROM $db_name.`users` where student_id=$st_id and db='$database'";
            $run = $conn->execute($find);
            if ($run) {
                $conn = ConnectionManager::get('default');
                $update = "UPDATE $db_name.`users` SET `user_name`='$fnames', `mobile`='$mob' WHERE `student_id`='$st_id' and `db`='$database'";
                $exicute = $conn->execute($update);
            } else {
                //Insert Data in School_ERP Users Table
                $curr_year = ACADEMIC_YEAR;
                $databasess = $this->request->session()->read('Auth.User.db');
                $conn = ConnectionManager::get('default');
                $inserts = "INSERT INTO $db_name.`users` (`user_name`,`c_id`,`academic_year`, `email`,`student_id`, `password`, `confirm_pass`, `created`, `role_id`, `db`,`board`,`mobile`) VALUES
                ('$fnames','2','$curr_year','$enrosll', '$ids','$2y$10$.vwir1Fyl5EkpHbNfEYFl.vU7raO0gFMuM.QnwVqpLM77Mjlot1Zm','12345', '$cdate', 2,'$databasess','1','$mob')";
                $exicute = $conn->execute($inserts);
                $this->Flash->success(__('User insert schoolerp database'));
            }
            if ($this->Students->save($studentss)) {
                if ($this->request->data['fullname']) {
                    $this->request->data['user_id'] = $students['id'];
                    $this->request->data['fullname'] = $this->request->data['fullname'];
                    $this->request->data['relation'] = $this->request->data['relation'];
                    $this->request->data['mobileno'] = $this->request->data['mobileno'];
                    $guardians = $this->Guardians->patchEntity($guardians, $this->request->data);
                    $this->Guardians->save($guardians);
                }
                $this->Flash->success(__('Student Information has been updated sucessfully !!'));
                $role_id = $this->request->session()->read('Auth.User.role_id');
                if ($role_id == LEAD_COORDINATOR) {
                    return $this->redirect(['controller' => 'students', 'action' => 'index']);
                } else {
                    return $this->redirect($this->referer());
                    // return $this->redirect(['controller' => 'studentfees', 'action' => 'view']);
                }
            } else {
                if ($studentss->errors()) {
                    $error_msg = [];
                    foreach ($students->errors() as $errors) {
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
    }


    //editaddress
    public function editaddress($id = null)
    {
        $students = $this->Students->get($id);
        $this->set('students', $students);
        $this->set('sid', $id);

        if ($this->request->is(['post', 'put'])) {
            $this->request->data['address'] = $this->request->data['address'];
            $conn = ConnectionManager::get('default');
            $detail = 'UPDATE `students` SET `address` ="' . $this->request->data['address'] . '" WHERE `students`.`id` = "' . $this->request->data['id'] . '"';
            $results = $conn->execute($detail);
            $sid = $this->request->data['id'];
            if ($results) {
                $this->Flash->success(__('Your Address has been saved.'));
                return $this->redirect(['action' => 'view/' . $sid . '?id=address']);
            }
        }
    }

    // add guardian
    // done 12-05-2023
    //change role id to role name
    public function editdropout($id = null)
    {

        $this->viewBuilder()->layout('admin');

        // $admissionclass = $this->AdmissionClasses->find('list', [
        //     'keyField' => 'id',
        //     'valueField' => 'title',
        // ])->order(['sort' => 'ASC'])->toArray();
        // $this->set('admissionclass', $admissionclass);
        $classes = $this->Classes->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('classes', $classes);

        // $houses = $this->Houses->find('list', [
        //     'keyField' => 'id',
        //     'valueField' => 'name',
        // ])->where(['status' => '1'])->order(['name' => 'ASC'])->toArray();
        // $this->set('houses', $houses);

        $sections = $this->Sections->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('sections', $sections);


        // $disabilityslist = $this->Disabilitys->find('list', [
        //     'keyField' => 'id',
        //     'valueField' => 'name',
        // ])->where(['status' => 'Y'])->order(['id' => 'ASC'])->toArray();
        // $this->set('disabilityslist', $disabilityslist);


        $discountCategorylist = $this->DiscountCategory->find('list', [
            'keyField' => 'name',
            'valueField' => 'name',
        ])->where(['status' => 'Y', 'type' => '0'])->order(['id' => 'ASC'])->toArray();
        $this->set('discountCategorylist', $discountCategorylist);
        if (isset($id) && !empty($id)) {

            $students = $this->DropOutStudent->get($id);
            $class_id = $students->class_id;
            $sid = $students->id;
            $acedmicyearfi = $students->acedmicyear;
            $this->set('acedmicyearfi', $acedmicyearfi);
            $select = $students->comp_sid;
            $this->set('class_id', $class_id);

            $class_detail = $this->Classes->find('all')->where(['id' => $class_id])->first();

            if (in_array($class_detail['class_no'], ["11", "12"])) {
                if (!empty($select)) {
                    $this->set('selected', $select);
                }
                $select1 = $students->opt_sid;
                if (!empty($select1)) {
                    $this->set('select1', $select1);
                }
                $com = $this->Subjectclass->find('list', ['keyField' => 'Subjects.id', 'valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' => $class_id, 'Subjectclass.is_optional' => 0, 'Subjectclass.is_result2' => 'Y', 'Subjectclass.status' => 'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();
                $this->set(compact('com'));

                $option = $this->Subjectclass->find('list', ['keyField' => 'Subjects.id', 'valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' => $class_id, 'Subjectclass.is_optional' => 1, 'Subjectclass.is_result2' => 'Y', 'Subjectclass.status' => 'Y'])->contain(['Subjects'])->order(['name' => 'ASC'])->toArray();

                $this->set(compact('option'));
            }
        }
        $this->set('students', $students);

        $this->set('sid', $id);

        if ($this->request->is(['post', 'put'])) {

            if ($students['board_id'] == 1) {
                $bordd = "DP";
            } elseif ($students['board_id'] == 2) {
                $bordd = "DM";
            } elseif ($students['board_id'] == 3) {
                $bordd = "DPT";
            }
            if ($this->request->data['file']['name'] != '') {
                $db = $this->request->session()->read('Auth.User.db');
                $filePath = WWW_ROOT . $db . '_image/student/' . $student[''] . '';
                unlink($filePath);
                $filename = $this->request->data['file']['name'];
                $item = $this->request->data['file']['tmp_name'];
                $ext = end(explode('.', $filename));
                $name = md5(time($filename));
                $imagename = $bordd . $students['enroll'] . ".JPG";
                $file_path = $filePath . $imagename;
                if (move_uploaded_file($item, $file_path)) {
                    $this->request->data['file'] = $imagename;
                }
            }
            $this->request->data['fname'] = $this->request->data['fname'];
            $this->request->data['dob'] = date('Y-m-d', strtotime($this->request->data['dob']));
            $studentss = $this->DropOutStudent->patchEntity($students, $this->request->data);
            if ($this->DropOutStudent->save($studentss)) {
                $this->Flash->success(__('DropOutStudent has been updated sucessfully !!'));
                $role_id = $this->request->session()->read('Auth.User.role_id');
                if ($role_id == LEAD_COORDINATOR) {
                    return $this->redirect(['controller' => 'students', 'action' => 'drop']);
                } else {
                    return $this->redirect(['controller' => 'students', 'action' => 'drop']);
                }
            } else { /*for error show.*/
                $this->Flash->error(__('DropOutStudent Not Be Updated'));
            }
        }
    }

    public function addguardian($id = null)
    {

        if (isset($_GET['id'])) {
            $this->set('ids', $_GET['id']);
            $students = $this->Students->get($_GET['id']);
            $this->set('fathername', $students->fathername);
            $this->set('mothername', $students->mothername);
        }
        if (isset($id) && !empty($id)) {
            $classes = $this->Guardians->get($id);
            $this->set('ids', $classes->user_id);
            $students = $this->Students->get($classes->user_id);
            $this->set('fathername', $students->fathername);
            $this->set('mothername', $students->mothername);
        } else {
            $classes = $this->Guardians->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {

            if (!empty($this->request->data['hide'])) {
                $this->request->data['user_id'] = $this->request->data['hide'];
            } else {
                $students = $this->Guardians->find()->where(['Guardians.id' => $id])->first()->toarray();
                $this->request->data['user_id'] = $students['user_id'];
            }
            $userid = $this->request->data['user_id'];
            $fullname = $this->request->data['fullname'];
            $this->request->data['emails'] = $this->request->data['email'];
            if ($this->request->data['relation'] == 'Father') {
                $conn = ConnectionManager::get('default');
                $detail = 'UPDATE `students` SET `fathername` ="' . $fullname . '" WHERE `students`.`id` = "' . $userid . '"';
                $results = $conn->execute($detail);
            }
            if ($this->request->data['relation'] == 'Mother') {
                $conn = ConnectionManager::get('default');
                $detail = 'UPDATE `students` SET `mothername` ="' . $fullname . '" WHERE `students`.`id` = "' . $userid . '"';
                $results = $conn->execute($detail);
            }

            $this->request->data['type'] = '0';
            $classes = $this->Guardians->patchEntity($classes, $this->request->data);
            //    pr($classes); die;
            if ($this->Guardians->save($classes)) {
                $this->Flash->success(__('Guardian has been saved.'));

                return $this->redirect(['action' => 'view/' . $this->request->data['user_id'] . '?id=guardians']);
            }
        } else {
            //validation error
            if ($classes->errors()) {
                $error_msg = [];
                foreach ($classes->errors() as $errors) {
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
        $this->set('classes', $classes);
    }

    public function absentreport()
    {
        $this->viewBuilder()->layout('admin');
        $classes = $this->Classections->find('list', [
            'keyField' => 'Classes.id',
            'valueField' => 'Classes.title',
        ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $this->set('classes', $classes);

        $sectionslist = $this->Sections->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('sectionslist', $sectionslist);

        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

        $acedmic = $users['academic_year'];
        $this->set(compact('acedmic'));
    }

    public function absentwithoutcard($class = null, $section = null)
    {
        $this->viewBuilder()->layout('admin');
        $classes = $this->Classections->find('list', [
            'keyField' => 'Classes.id',
            'valueField' => 'Classes.title',
        ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $this->set('classes', $classes);
        if ($class) {

            $this->set('classs2', $class);
        }

        $sectionslist = $this->Sections->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('sectionslist', $sectionslist);

        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

        $acedmic = $users['academic_year'];
        $this->set(compact('acedmic'));

        $connss = ConnectionManager::get('default');
        if ($class && $section) {
            $studentrfidsd = $connss->execute("SELECT * FROM students LEFT JOIN
				classes ON students.class_id = classes.id WHERE students.rf_id
				!='0'  AND students.id  NOT IN (SELECT students.id AS studid FROM
				`attendreports` LEFT JOIN students ON attendreports.rfid =
				students.rf_id LEFT JOIN classes ON students.class_id = classes.id
				WHERE DATE(resultdate)='" . date('Y-m-d') . "' AND students.rf_id !='0'
				 AND students.status ='Y' GROUP BY attendreports.rfid) AND students.class_id ='" . $class . "' AND students.section_id ='" . $section . "' ORDER BY fname ASC,section_id ASC");
        } else {
            $studentrfidsd = $connss->execute("SELECT * FROM students LEFT JOIN classes ON students.class_id = classes.id WHERE students.rf_id !='0'  AND students.id  NOT IN (SELECT students.id AS studid FROM `attendreports` LEFT JOIN students ON attendreports.rfid = students.rf_id LEFT JOIN classes ON students.class_id = classes.id WHERE DATE(resultdate)='" . date('Y-m-d') . "' AND students.rf_id !='0' AND students.status ='Y' GROUP BY attendreports.rfid) ORDER BY sort ASC,section_id ASC");
        }
        $studentrfidsd = $studentrfidsd->fetchAll('assoc');
        //pr($studentrfidsd);
        $this->set(compact('studentrfidsd'));
    }

    public function classidcardreportmain()
    {
        $this->viewBuilder()->layout('admin');

        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

        $acedmic = $users['academic_year'];
        $this->set(compact('acedmic'));
        $classess = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();

        $this->set('classess', $classess);

        $sectionslist = $this->Sections->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('sectionslist', $sectionslist);
        $articles = TableRegistry::get('Students');
        $studentcnt = $articles->find('all')->where(['Students.status' => 'Y', 'Students.acedmicyear' => $acedmic])->count();

        $this->set('studentcnt', $studentcnt);
        $connss = ConnectionManager::get('default');

        $date = date('Y-m-d');
        $this->set('date', $date);
    }

    public function classidcardreport()
    {
        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        $this->viewBuilder()->layout('admin');
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $acedmic = $users['academic_year'];
        $this->set(compact('acedmic'));
        $classess = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $this->set('classess', $classess);
        $sectionslist = $this->Sections->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('sectionslist', $sectionslist);
        $articles = TableRegistry::get('Students');
        $studentcnt = $articles->find('all')->where(['Students.status' => 'Y', 'Students.acedmicyear' => $acedmic])->count();
        $this->set('studentcnt', $studentcnt);
        $connss = ConnectionManager::get('default');
        $date = date('Y-m-d');
        $this->set('date', $date);
    }

    public function findrolemenutakeattendence()
    {
        $articles = TableRegistry::get('PermissionModules');
        $ids = $this->request->session()->read('Auth.User.id');
        return $articles->find('all')->where(['PermissionModules.user_id' => $ids, 'PermissionModules.action' => 'classattendance'])->group(['PermissionModules.module'])->order(['PermissionModules.id' => 'ASC'])->first();
    }

    public function staffattendance()
    {

        $atime = $this->Users->find('all')->select(['attendenceupdate'])->where(['role_id' => ADMIN])->first();
        $current_time = date("H.i", time());
        //pr($current_time);die;

        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $acedmi = $users['academic_year'];

        $studentsarry = $this->Employees->find('all')->where(['Employees.status' => 'Y'])->order(['Employees.fname' => 'ASC'])->order(['Employees.lname' => 'ASC'])->toarray();
        $this->set(compact('studentsarry'));

        $this->set('academic', $acedmi);
        $this->set('academics', $acedmi);

        $rt = date('Y-m-d');
        $timestamp = strtotime($rt);
        $weekofday = date("l", $timestamp);
        $this->set('weekofday', $weekofday);

        $attedenceall = $this->Staffattends->find('all')->contain(['Employees'])->where(['Staffattends.date' => $rt, 'Staffattends.acedemic' => $acedmi])->order(['Staffattends.id' => 'ASC'])->toArray();

        $this->set('attedenceall', $attedenceall);
        $this->viewBuilder()->layout('admin');
    }


    public function classattendance()
    {

        $result = $this->findrolemenutakeattendence();

        if ($result['id'] == '') {
            $this->Flash->error(__("You don't have permission to access class attendance module !!"));
            $this->Auth->logout();
            return $this->redirect(['controller' => 'logins', 'action' => 'index']);
        }
        $this->viewBuilder()->layout('admin');
        $users = $this->Users->find('all')->where(['Users.role_id IN' => [ADMIN, CENTER_COORDINATOR]])->first();
        $current_time = date("H.i", time());
        // pr($users);die;
        if ($current_time >= $users['attendenceupdate']) {
            $output['canTakeAttendance'] = 0;
        } else {
            $output['canTakeAttendance'] = 1;
        }
        $this->set('output', $output);
        $this->set('attendenceupdate', $users['attendenceupdate']);
        $acedmic = $users['academic_year'];
        $this->set(compact('acedmic'));
        $classess = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classes.status' => 'Y'])->order(['Classes.sort' => 'ASC'])->toArray();
        // pr($classess);die;
        $this->set('classess', $classess);
        $sectionslist = $this->Sections->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('sectionslist', $sectionslist);
        $articles = TableRegistry::get('Students');
        // pr($acedmic);die;
        $studentcnt = $articles->find('all')->where(['Students.status' => 'Y', 'Students.acedmicyear' => $acedmic])->count();
        $this->set('studentcnt', $studentcnt);
        $connss = ConnectionManager::get('default');
        $date = date('Y-m-d');
        $this->set('date', $date);
    }
    //role id to role name
    public function searchattendence()
    {

        $result = $this->findrolemenutakeattendence();
        if ($result['id'] == '') {
            $this->Flash->error(__("You don't have permission to access class attendance module !!"));
            $this->Auth->logout();
            return $this->redirect(['controller' => 'logins', 'action' => 'index']);
        }
        $users = $this->Users->find('all')->where(['Users.role_id IN' => [ADMIN, CENTER_COORDINATOR]])->first();
        $current_time = date("H.i", time());
        if ($current_time >= $users['attendenceupdate']) {
            $output['canTakeAttendance'] = 0;
        } else {
            $output['canTakeAttendance'] = 1;
        }
        $this->set('output', $output);
        $this->set('attendenceupdate', $users['attendenceupdate']);
        $acedmic = $users['academic_year'];
        $this->set(compact('acedmic'));
        $classess = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $this->set('classess', $classess);
        $sectionslist = $this->Sections->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('sectionslist', $sectionslist);
        $articles = TableRegistry::get('Students');
        $studentcnt = $articles->find('all')->where(['Students.status' => 'Y', 'Students.acedmicyear' => $acedmic])->count();
        $this->set('studentcnt', $studentcnt);
        $connss = ConnectionManager::get('default');
        $datetype = date('Y-m-d', strtotime($this->request->data['date']));
        if ($datetype == '1970-01-01') {
            $dates = date('Y-m-d');
        } else {
            $dates = date('Y-m-d', strtotime($this->request->data['date']));
        }
        $this->set('date', $dates);
    }
    //role id to role name
    public function searchstaffattend()
    {

        $senddate = $this->request->data;
        $atime = $this->Users->find('all')->select(['attendenceupdate'])->where(['role_id' => ADMIN])->first();
        $current_time = date("H.i", time());
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $acedmi = $users['academic_year'];
        $studentsarry = $this->Employees->find('all')->where(['Employees.status' => 'Y'])->order(['Employees.fname' => 'ASC'])->order(['Employees.lname' => 'ASC'])->toarray();
        $this->set(compact('studentsarry'));
        $this->set('academic', $acedmi);
        $this->set('academics', $acedmi);
        $rt = date("Y-m-d", strtotime($senddate['selectdate']));
        $this->set('dates', $rt);
        $timestamp = strtotime($rt);
        $weekofday = date("l", $timestamp);
        $this->set('weekofday', $weekofday);
        $attedenceall = $this->Staffattends->find('all')->contain(['Employees'])->where(['Staffattends.date' => $rt, 'Staffattends.acedemic' => $acedmi])->order(['Staffattends.id' => 'ASC'])->toArray();
        $this->set('attedenceall', $attedenceall);
    }

    public function classidcard_search()
    {
        //pr($this->request->data); die;
        $date = $this->request->data['date'];
        $this->set(compact('date'));
        //pr($date); die;
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

        $acedmic = $users['academic_year'];
        $this->set(compact('acedmic'));
        $classess = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();

        $this->set('classess', $classess);

        $sectionslist = $this->Sections->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('sectionslist', $sectionslist);
        $articles = TableRegistry::get('Students');
        $studentcnt = $articles->find('all')->where(['Students.status' => 'Y', 'Students.acedmicyear' => $acedmic])->count();

        $this->set('studentcnt', $studentcnt);
        $connss = ConnectionManager::get('default');
    }

    public function presentreport()
    {
        $this->viewBuilder()->layout('admin');
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $acedmic = $users['academic_year'];
        $this->set(compact('acedmic'));

        $connss = ConnectionManager::get('default');
        $studentrfidsd = $connss->execute("SELECT * FROM `attendreports` LEFT JOIN students ON attendreports.rfid = students.rf_id
        LEFT JOIN classes ON students.class_id = classes.id  WHERE
        DATE(attendreports.resultdate)='" . date('Y-m-d') . "' AND students.status ='Y' GROUP BY attendreports.rfid  ORDER BY sort ASC,section_id ASC");
        $studentrfidsd = $studentrfidsd->fetchAll('assoc');
        $this->set(compact('studentrfidsd'));
    }

    public function searchrfidreport()
    {

        $datefrom = date('Y-m-d', strtotime($this->request->data['datefrom']));
        $dateto2 = date('Y-m-d', strtotime($this->request->data['dateto']));
        if (!empty($datefrom) && $datefrom != '1970-01-01') {
            $datefrom23 = $datefrom;
        }
        if (!empty($dateto2) && $dateto2 != '1970-01-01') {
            $dateto23 = $dateto2;
        }
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $acedmic = $users['academic_year'];
        $this->set(compact('acedmic'));
        $connss = ConnectionManager::get('default');
        $studentrfidsd = $connss->execute("SELECT * FROM `attendreports` LEFT JOIN students ON attendreports.rfid = students.rf_id
        LEFT JOIN classes ON students.class_id = classes.id  WHERE DATE(attendreports.resultdate) >='" . $datefrom23 . "' AND DATE(attendreports.resultdate) <='" . $dateto23 . "' AND students.status ='Y' GROUP BY attendreports.rfid  ORDER BY sort ASC,section_id ASC");
        $studentrfidsd = $studentrfidsd->fetchAll('assoc');
        $this->set(compact('studentrfidsd'));
    }

    public function makingidcardreport()
    {

        $this->viewBuilder()->layout('admin');
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $acedmic = $users['academic_year'];
        $this->set(compact('acedmic'));
        $connss = ConnectionManager::get('default');
        $studentrfidsd = $connss->execute("SELECT * FROM students LEFT JOIN classes ON students.class_id = classes.id  WHERE  rf_id='0' AND students.status ='Y' ORDER BY classes.sort ASC,section_id ASC");
        $studentrfidsd = $studentrfidsd->fetchAll('assoc');
        $this->set(compact('studentrfidsd'));
    }

    public function searchabsentshow($errt = null)
    {

        $this->viewBuilder()->layout('admin');
        $eee = explode(',', $errt);
        $da = date('Y-m-d');
        $e = explode(',', base64_decode($eee[0]));
        $rd = explode(',', base64_decode($eee[1]));
        $pii = array('Studattends.date' => $da);
        $apk[] = $pii;
        if ($e && $rd) {
            $conlns = ConnectionManager::get('default');
            $conlns->execute("DELETE FROM tmp_allattendence WHERE 1=1");
        }
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $acedmic = $users['academic_year'];
        $pii = array('Studattends.acedemic' => $acedmic);
        $pisi = array('Studattends.status' => 'A');
        $apk[] = $pii;
        $apk[] = $pisi;
        $attendenceentry = $this->Studattends->find('all')->contain(['Students' => ['Classes']])->where($apk)->order(['Classes.sort' => 'ASC'])->toarray();
        $romsm = sizeof($attendenceentry);
        for ($is = 0; $is < $romsm; $is++) {
            $connssss = ConnectionManager::get('default');
            $connssss->execute("INSERT INTO
				`tmp_allattendence`(`st_id`, `class_id`, `section_id`,
				`status`, `status_m`, `sort`) VALUES
				('" . $attendenceentry[$is]['student']['id'] . "','" . $attendenceentry[$is]['student']['class_id'] . "','" . $attendenceentry[$is]['student']['section_id'] . "','" . $attendenceentry[$is]['status'] . "','" . $attendenceentry[$is]['status_m'] . "','" . $attendenceentry[$is]['student']['class']['sort'] . "')");
        }

        $romm = sizeof($e);

        for ($i = 0; $i < $romm; $i++) {

            $connss = ConnectionManager::get('default');

            $da = date('Y-m-d');
            $cnt = $this->Studattends->find('all')->where(['Studattends.class_id' => $e[$i], 'Studattends.section_id' => $rd[$i], 'Studattends.date' => $da])->count();

            if ($cnt <= 0) {
                $studentrfidsd = $connss->execute("SELECT
				students.id,students.class_id,students.section_id,classes.sort FROM `students`, `classes` WHERE students.class_id =
				classes.id AND students.id
				NOT IN  (SELECT students.id FROM `attendreports` LEFT JOIN students
				ON attendreports.rfid = students.rf_id LEFT JOIN classes ON
				students.class_id = classes.id  WHERE students.rf_id !='0' AND
				students.status='Y' AND students.class_id ='" . $e[$i] . "' AND
				students.section_id ='" . $rd[$i] . "' AND
				DATE(attendreports.resultdate)='" . date('Y-m-d') . "' GROUP BY
				attendreports.rfid  ORDER BY section_id ASC) AND students.class_id
				='" . $e[$i] . "' AND students.section_id ='" . $rd[$i] . "' ORDER BY
				classes.sort ASC");
                $attendenceentry2 = $studentrfidsd->fetchAll('assoc');
                foreach ($attendenceentry2 as $f => $rst) {
                    $connsssks = ConnectionManager::get('default');
                    $connsssks->execute("INSERT INTO
				`tmp_allattendence`(`st_id`, `class_id`, `section_id`,
				`status`, `status_m`, `sort`) VALUES
				('" . $rst['id'] . "','" . $rst['class_id'] . "','" . $rst['section_id'] . "','A','A','" . $rst['sort'] . "')");
                }
            }
        }
        $allabsent = $connss->execute("SELECT * FROM `tmp_allattendence` ORDER BY
				sort,section_id ASC");
        $allabsent = $allabsent->fetchAll('assoc');
        $this->set(compact('allabsent'));
    }

    public function summaryprospectus($board = null, $m = null)
    {
        $this->viewBuilder()->layout('admin');
        $date = date('Y-m-d');
        if ($board == 'cbse') {
            $prospectussummary = $this->Enquires->find('all')->where(['DATE(Enquires.created)' => $date, 'Enquires.recipietno !=' => '0', 'Enquires.mode1_id' => $m, 'Enquires.status' => 'Y'])->order(['Enquires.created' => 'ASC'])->toarray();
        } elseif ($board == 'int') {
            $prospectussummary = $this->Enquires->find('all')->where(['DATE(Enquires.created)' => $date, 'Enquires.recipietno !=' => '0', 'Enquires.mode1_id !=' => $m, 'Enquires.status' => 'Y'])->order(['Enquires.created' => 'ASC'])->toarray();
        } elseif ($board == 'total') {
            $prospectussummary = $this->Enquires->find('all')->where(['DATE(Enquires.created)' => $date, 'Enquires.recipietno !=' => '0', 'Enquires.status' => 'Y'])->order(['Enquires.created' => 'ASC'])->toarray();
        }
        $this->set(compact('prospectussummary'));
    }

    public function summaryprospectusacedmic($board = null, $acedmic = null)
    {
        $this->viewBuilder()->layout('admin');
        $date = date('Y-m-d');
        $this->set(compact('acedmic'));
        if ($board == 'cbse') {
            $prospectussummary = $this->Enquires->find('all')->where(['Enquires.acedmicyear' => $acedmic, 'Enquires.mode1_id' => '1', 'Enquires.recipietno !=' => '0', 'Enquires.status' => 'Y'])->order(['Enquires.created' => 'ASC'])->toarray();
        } elseif ($board == 'int') {
            $prospectussummary = $this->Enquires->find('all')->where(['Enquires.acedmicyear' => $acedmic, 'Enquires.mode1_id !=' => '1', 'Enquires.recipietno !=' => '0', 'Enquires.status' => 'Y'])->order(['Enquires.created' => 'ASC'])->toarray();
        } elseif ($board == 'total') {
            $prospectussummary = $this->Enquires->find('all')->where(['Enquires.acedmicyear' => $acedmic, 'Enquires.recipietno !=' => '0', 'Enquires.status' => 'Y'])->order(['Enquires.created' => 'ASC'])->toarray();
        }
        $this->set(compact('prospectussummary'));
    }

    public function summaryregistration($board = null, $m = null)
    {
        $this->viewBuilder()->layout('admin');

        $date = date('Y-m-d');

        if ($board == 'cbse') {

            $registrationsummary = $this->Applicant->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.recipietno !=' => '0', 'Enquires.mode1_id' => $m])->order(['Applicant.created' => 'ASC'])->toarray();
        } elseif ($board == 'int') {

            $registrationsummary = $this->Applicant->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.recipietno !=' => '0', 'Enquires.mode1_id !=' => $m])->order(['Applicant.created' => 'ASC'])->toarray();
        } elseif ($board == 'total') {

            $registrationsummary = $this->Applicant->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.recipietno !=' => '0'])->order(['Applicant.created' => 'ASC'])->toarray();
        }
        $this->set(compact('registrationsummary'));
    }

    public function summaryregistrationacedmic($board = null, $acedmic = null)
    {
        $this->viewBuilder()->layout('admin');
        $date = date('Y-m-d');
        $this->set(compact('acedmic'));
        if ($board == 'cbse') {
            $registrationsummary = $this->Applicant->find('all')->contain(['Enquires'])->where(['Applicant.acedmicyear' => $acedmic, 'Applicant.recipietno !=' => '0', 'Applicant.status_c' => 'Y', 'Enquires.mode1_id' => '1', 'Enquires.status' => 'Y'])->order(['Applicant.created' => 'ASC'])->toarray();
        } elseif ($board == 'int') {
            $registrationsummary = $this->Applicant->find('all')->contain(['Enquires'])->where(['Applicant.acedmicyear' => $acedmic, 'Applicant.recipietno !=' => '0', 'Applicant.status_c' => 'Y', 'Enquires.mode1_id !=' => '1', 'Enquires.status' => 'Y'])->order(['Applicant.created' => 'ASC'])->toarray();
        } elseif ($board == 'total') {
            $registrationsummary = $this->Applicant->find('all')->contain(['Enquires'])->where(['Applicant.acedmicyear' => $acedmic, 'Applicant.status_c' => 'Y', 'Applicant.recipietno !=' => '0', 'Enquires.status' => 'Y'])->order(['Applicant.created' => 'ASC'])->toarray();
        }
        $this->set(compact('registrationsummary'));
    }

    public function admissionsummary($board = null, $m = null)
    {
        $this->viewBuilder()->layout('admin');
        $date = date('Y-m-d');
        if ($board == 'cbse') {
            $admissionsummary = $this->Students->find('all')->where(['DATE(Students.created)' => $date, 'Students.status' => 'Y', 'Students.board_id' => $m])->order(['Students.created' => 'ASC'])->toarray();
        } elseif ($board == 'int') {
            $admissionsummary = $this->Students->find('all')->where(['DATE(Students.created)' => $date, 'Students.status' => 'Y', 'Students.board_id !=' => $m])->order(['Students.created' => 'ASC'])->toarray();
        } elseif ($board == 'total') {
            $admissionsummary = $this->Students->find('all')->where(['DATE(Students.created)' => $date, 'Students.status' => 'Y'])->order(['Students.created' => 'ASC'])->toarray();
        }
        $this->set(compact('admissionsummary'));
    }

    public function admissionsummaryacedmicold($board = null, $acedmic = null)
    {
        $this->viewBuilder()->layout('admin');
        $date = date('Y-m-d');
        $this->set(compact('acedmic'));
        if ($board == 'cbse') {
            $admissionsummary = $this->Students->find('all')->where(['Students.admissionyear' => $acedmic, 'Students.board_id' => '1'])->order(['Students.created' => 'ASC'])->toarray();
            $admissionsummary2 = $this->DropOutStudent->find('all')->where(['DropOutStudent.admissionyear' => $acedmic, 'DropOutStudent.board_id' => '1'])->order(['DropOutStudent.created' => 'ASC'])->toarray();
        } elseif ($board == 'int') {
            $admissionsummary = $this->Students->find('all')->where(['Students.admissionyear' => $acedmic, 'Students.board_id !=' => '1'])->order(['Students.created' => 'ASC'])->toarray();
            $admissionsummary2 = $this->DropOutStudent->find('all')->where(['DropOutStudent.admissionyear' => $acedmic, 'DropOutStudent.board_id !=' => '1'])->order(['DropOutStudent.created' => 'ASC'])->toarray();
        } elseif ($board == 'total') {
            $admissionsummary = $this->Students->find('all')->where(['Students.admissionyear' => $acedmic])->order(['Students.created' => 'ASC'])->toarray();
            $admissionsummary2 = $this->DropOutStudent->find('all')->where(['DropOutStudent.admissionyear' => $acedmic])->order(['DropOutStudent.created' => 'ASC'])->toarray();
        }
        $this->set(compact('admissionsummary'));
        $this->set(compact('admissionsummary2'));
    }

    public function admissionsummaryacedmic($board = null, $acedmic = null, $classcollection = null)
    {
        $this->viewBuilder()->layout('admin');
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $currentyear = $users['academic_year'];
        $next_academic_year = $users['next_academic_year'];
        $apk = array();
        $apk1 = array();
        if ($classcollection) {
            $classs = base64_decode($classcollection);
            $css = explode(',', $classs);
            if ($board == 'cbse') {
                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                    $stts = array('Students.class_id IN' => $css);
                    $apk[] = $stts;
                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('Studentshistory.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.class_id IN' => $css);
                    $apk[] = $stts;
                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.created' => 'ASC'])->toarray();
                    //pr($admissionsummary); die;
                } else {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                    $stts = array('Students.class_id IN' => $css);
                    $apk[] = $stts;
                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
                }

                $stts = array('DropOutStudent.board_id' => 1);
                $apk1[] = $stts;
                $stts = array('DropOutStudent.laststudclass IN' => $css);
                $apk1[] = $stts;
                if ($acedmic == $currentyear) {

                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk1[] = $stts;

                    $stts = array('DropOutStudent.laststudclass IN' => $css);
                    $apk1[] = $stts;

                    $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.created' => 'ASC'])->toarray();
                } else {

                    foreach ($admissionsummary as $kk => $jj) {

                        $idd[] = $jj['student_id'];
                    }

                    $stts = array('DropOutStudent.s_id NOT IN' => $idd);
                    $apk1[] = $stts;
                    $stts = array('DropOutStudent.laststudclass IN' => $css);
                    $apk1[] = $stts;
                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk1[] = $stts;
                    $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.created' => 'ASC'])->toarray();
                    //pr($Classections21); die;
                }

                if (!empty($admissionsummary2)) {
                    $registrationsummary = array_merge($admissionsummary, $admissionsummary2);
                } else {
                    $registrationsummary = $admissionsummary;
                }

                //pr($registrationsummary); die;
                $this->set(compact('registrationsummary'));
            } elseif ($board == 'int') {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                    $stts = array('Students.class_id IN' => $css);
                    $apk[] = $stts;
                    $stts = array('Students.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;
                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('Studentshistory.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;
                    $stts = array('Studentshistory.class_id IN' => $css);
                    $apk[] = $stts;
                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->toarray();
                } else {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                    $stts = array('Students.class_id IN' => $css);
                    $apk[] = $stts;
                    $stts = array('Students.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;
                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                }

                $stts = array('DropOutStudent.board_id IN' => ALL_BOARDS);
                $apk1[] = $stts;
                $stts = array('DropOutStudent.admissionyear' => $acedmic);
                $apk1[] = $stts;
                $stts = array('DropOutStudent.laststudclass IN' => $css);
                $apk1[] = $stts;

                if ($acedmic == $currentyear) {

                    $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.id' => 'ASC'])->toarray();
                    //pr($Classections21); die;

                } else {

                    foreach ($admissionsummary as $kk => $jj) {

                        $idd[] = $jj['student_id'];
                    }

                    $stts = array('DropOutStudent.s_id NOT IN' => $idd);
                    $apk1[] = $stts;
                    $stts = array('DropOutStudent.laststudclass IN' => $css);
                    $apk1[] = $stts;
                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk1[] = $stts;
                    $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.id' => 'ASC'])->toarray();
                    //pr($Classections21); die;
                }

                if (!empty($admissionsummary2)) {
                    $registrationsummary = array_merge($admissionsummary, $admissionsummary2);
                } else {
                    $registrationsummary = $admissionsummary;
                }

                //pr($registrationsummary); die;
                $this->set(compact('registrationsummary'));
            } elseif ($board == 'total') {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                    $stts = array('Students.class_id IN' => $css);
                    $apk[] = $stts;
                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;
                    $stts = array('Studentshistory.class_id IN' => $css);
                    $apk[] = $stts;

                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->toarray();
                } else {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                    $stts = array('Students.class_id IN' => $css);
                    $apk[] = $stts;
                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                }

                $stts = array('DropOutStudent.admissionyear' => $acedmic);
                $apk1[] = $stts;
                $stts = array('DropOutStudent.laststudclass IN' => $css);
                $apk1[] = $stts;

                if ($acedmic == $currentyear) {

                    $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.id' => 'ASC'])->toarray();
                    //pr($Classections21); die;

                } else {

                    foreach ($admissionsummary as $kk => $jj) {

                        $idd[] = $jj['student_id'];
                    }

                    $stts = array('DropOutStudent.s_id NOT IN' => $idd);
                    $apk1[] = $stts;
                    $stts = array('DropOutStudent.laststudclass IN' => $css);
                    $apk1[] = $stts;
                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk1[] = $stts;
                    $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.id' => 'ASC'])->toarray();
                    //pr($Classections21); die;
                }

                if (!empty($admissionsummary2)) {
                    $registrationsummary = array_merge($admissionsummary, $admissionsummary2);
                } else {
                    $registrationsummary = $admissionsummary;
                }

                //pr($registrationsummary); die;
                $this->set(compact('registrationsummary'));
            }
        } else {
            if ($board == 'cbse') {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('Studentshistory.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.created' => 'ASC'])->toarray();
                    //pr($admissionsummary); die;
                } else {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
                }

                $stts = array('DropOutStudent.board_id' => 1);
                $apk1[] = $stts;

                if ($acedmic == $currentyear) {

                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk1[] = $stts;
                    $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.created' => 'ASC'])->toarray();
                } else {

                    foreach ($admissionsummary as $kk => $jj) {

                        $idd[] = $jj['student_id'];
                    }

                    $stts = array('DropOutStudent.s_id NOT IN' => $idd);
                    $apk1[] = $stts;

                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk1[] = $stts;
                    $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.created' => 'ASC'])->toarray();
                    //pr($Classections21); die;
                }

                if (!empty($admissionsummary2)) {
                    $registrationsummary = array_merge($admissionsummary, $admissionsummary2);
                } else {
                    $registrationsummary = $admissionsummary;
                }

                //pr($registrationsummary); die;
                $this->set(compact('registrationsummary'));
            } elseif ($board == 'int') {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;
                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('Studentshistory.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;
                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->toarray();
                } else {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;
                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                }

                $stts = array('DropOutStudent.board_id IN' => ALL_BOARDS);
                $apk1[] = $stts;
                $stts = array('DropOutStudent.admissionyear' => $acedmic);
                $apk1[] = $stts;

                if ($acedmic == $currentyear) {

                    $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.id' => 'ASC'])->toarray();
                    //pr($Classections21); die;

                } else {

                    foreach ($admissionsummary as $kk => $jj) {

                        $idd[] = $jj['student_id'];
                    }

                    $stts = array('DropOutStudent.s_id NOT IN' => $idd);
                    $apk1[] = $stts;

                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk1[] = $stts;
                    $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.id' => 'ASC'])->toarray();
                    //pr($Classections21); die;
                }

                if (!empty($admissionsummary2)) {
                    $registrationsummary = array_merge($admissionsummary, $admissionsummary2);
                } else {
                    $registrationsummary = $admissionsummary;
                }

                //pr($registrationsummary); die;
                $this->set(compact('registrationsummary'));
            } elseif ($board == 'total') {
                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {
                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;
                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {
                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;
                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->toarray();
                } else {
                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;
                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                }
                $stts = array('DropOutStudent.admissionyear' => $acedmic);
                $apk1[] = $stts;
                if ($acedmic == $currentyear) {
                    $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.id' => 'ASC'])->toarray();
                } else {
                    foreach ($admissionsummary as $kk => $jj) {

                        $idd[] = $jj['student_id'];
                    }
                    $stts = array('DropOutStudent.s_id NOT IN' => $idd);
                    $apk1[] = $stts;

                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk1[] = $stts;
                    $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.id' => 'ASC'])->toarray();
                }
                if (!empty($admissionsummary2)) {
                    $registrationsummary = array_merge($admissionsummary, $admissionsummary2);
                } else {
                    $registrationsummary = $admissionsummary;
                }
                $this->set(compact('registrationsummary'));
            }
        }
    }

    public function admissionsummaryacedmic2($board = null, $acedmic = null, $classcollection = null)
    {
        $this->viewBuilder()->layout('admin');
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $currentyear = $users['academic_year'];
        $apk = array();
        $apk1 = array();
        if ($classcollection) {

            $classs = base64_decode($classcollection);

            $css = explode(',', $classs);

            if ($board == 'cbse') {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                    $stts = array('Students.class_id IN' => $css);
                    $apk[] = $stts;

                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('Studentshistory.board_id' => 1);
                    $apk[] = $stts;
                    $stts = array('Studentshistory.class_id IN' => $css);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.created' => 'ASC'])->toarray();
                    //pr($admissionsummary); die;
                } else {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;
                    $stts = array('Students.class_id IN' => $css);
                    $apk[] = $stts;

                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
                }

                $registrationsummary = $admissionsummary;

                //pr($registrationsummary); die;
                $this->set(compact('registrationsummary'));
            } elseif ($board == 'int') {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                    $stts = array('Students.class_id IN' => $css);
                    $apk[] = $stts;
                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('Studentshistory.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;
                    $stts = array('Studentshistory.class_id IN' => $css);
                    $apk[] = $stts;
                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->toarray();
                } else {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                    $stts = array('Students.class_id IN' => $css);
                    $apk[] = $stts;
                    $stts = array('Students.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;
                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                }

                $registrationsummary = $admissionsummary;

                //pr($registrationsummary); die;
                $this->set(compact('registrationsummary'));
            }
        } else {
            if ($board == 'cbse') {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('Studentshistory.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.created' => 'ASC'])->toarray();
                    //pr($admissionsummary); die;
                } else {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
                }

                $registrationsummary = $admissionsummary;

                //pr($registrationsummary); die;
                $this->set(compact('registrationsummary'));
            } elseif ($board == 'int') {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('Studentshistory.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;
                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->toarray();
                } else {

                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;
                    $stts = array('Students.status' => 'Y');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                }

                $registrationsummary = $admissionsummary;

                //pr($registrationsummary); die;
                $this->set(compact('registrationsummary'));
            }
        }
    }

    public function searchabsent($class_id = null, $section_id = null, $date = null)
    {
        $this->viewBuilder()->layout('admin');

        if (!empty($class_id)) {
            if ($date == null) {
                $da = date('Y-m-d');
            } else {
                $da = date('Y-m-d', strtotime($date));
            }

            //pr($da); die;

            $this->set(compact('class_id'));
            $this->set(compact('section_id'));

            if (!empty($class_id)) {
                $pii = array('Studattends.class_id' => $class_id);
                $apk[] = $pii;
            }

            if (!empty($section_id)) {
                $pii = array('Studattends.section_id' => $section_id);
                $apk[] = $pii;
            }

            $pii = array('Studattends.date' => $da);
            $apk[] = $pii;

            $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
            $acedmic = $users['academic_year'];
            $pii = array('Studattends.acedemic' => $acedmic);
            $pisi = array('Studattends.status' => 'A');
            $apk[] = $pii;
            $apk[] = $pisi;

            $attendenceentry = $this->Studattends->find('all')->contain(['Students'])->where($apk)->order(['Students.fname' => 'ASC'])->toarray();
            // pr($attendenceentry);

            $this->set(compact('attendenceentry'));

            $connss = ConnectionManager::get('default');

            $studentrfsidsd = $connss->execute("SELECT * FROM `students`, `classes` WHERE students.class_id =
				classes.id AND students.id
				NOT IN  (SELECT students.id FROM `attendreports` LEFT JOIN students
				ON attendreports.rfid = students.rf_id LEFT JOIN classes ON
				students.class_id = classes.id  WHERE students.rf_id !='0' AND
				students.status='Y' AND students.class_id ='" . $class_id . "' AND
				students.section_id ='" . $section_id . "' AND
				DATE(attendreports.resultdate)='" . date('Y-m-d') . "' GROUP BY
				attendreports.rfid  ORDER BY section_id ASC) AND students.class_id
				='" . $class_id . "' AND students.section_id ='" . $section_id . "' ORDER BY
				classes.sort ASC");

            $attendenceentry2 = $studentrfsidsd->fetchAll('assoc');
            $this->set(compact('attendenceentry2'));
        }
    }

    // search functionality
    // public function search()
    // {
    //     //show all data in listing page
    //     //connection

    //     $conn = ConnectionManager::get('default');
    //     $batch = $this->request->data['batch'];
    //     $class = join("','", $this->request->data['class_id']);
    //     $session = $this->request->session();
    //     $session->delete('parentlogindata');

    //     // pr($this->request->data);
    //     if ($class && $year) {
    //         $session->delete('class');
    //         $session->delete('batch');
    //         $session->write('class', $class);
    //         $session->write('batch', $batch);
    //     } else {
    //         $session->delete('batch');
    //         $session->write('batch', $batch);
    //     }
    //     $admission = $this->request->data['admissionyear'];
    //     $is_promote = $this->request->data['is_promote'];
    //     $section = join("','", $this->request->data['section_id']);
    //     $enroll = $this->request->data['enroll'];
    //     $fname = trim($this->request->data['fname']);
    //     $mobile = $this->request->data['mobile'];
    //     $mothername = trim($this->request->data['mothername']);
    //     $fathername = trim($this->request->data['fathername']);
    //     // pr($this->request->data);exit;
    //     // pr($fname);die;  
    //     $detail = "SELECT Students.id,Students.enroll,Students.sms_mobile,Students.category,Students.oldenroll,Students.fname,Students.fathername,Students.mothername,Students.middlename,Students.lname,Students.is_transport,Students.mobile,Students.acedmicyear,Students.class_id,Students.created,Students.section_id,Students.batch,Students.admissionyear,Students.status,Students.request_for_drop,Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id WHERE  1=1 ";
    //     $cond = '';
    //     if (!empty($batch)) {
    //         $cond .= " AND Students.batch ='" . $batch . "'";
    //     }
    //     if (!empty($class)) {
    //         $cond .= " AND Students.class_id IN ('" . $class . "')";
    //     }
    //     if (!empty($section)) {
    //         $cond .= " AND Students.section_id IN ('" . $section . "')";
    //     }
    //     if (!empty($enroll)) {
    //         $cond .= " AND Students.enroll LIKE '%" . trim($enroll) . "%' ";
    //     }
    //     if (!empty($fname)) {
    //         $cond .= " AND UPPER(Students.fname) LIKE '%" . trim(strtoupper($fname)) . "%' ";
    //     }
    //     if (!empty($mothername)) {
    //         $cond .= " AND UPPER(Students.mothername) LIKE '%" . trim(strtoupper($mothername)) . "%' ";
    //     }
    //     if (!empty($fathername)) {
    //         $cond .= " AND UPPER(Students.fathername) LIKE '%" . trim(strtoupper($fathername)) . "%' ";
    //     }
    //     if (!empty($mobile)) {
    //         $cond .= " AND Students.mobile LIKE '%" . trim($mobile) . "%' ";
    //     }

    //     $rolepresent = $this->request->session()->read('Auth.User.role_id');

    //     // if ($rolepresent == CBSE_FEE_COORDINATOR) {
    //     //     $cond .= " AND Students.board_id LIKE CBSE ";
    //     // } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {

    //     //     $cond .= " AND Students.board_id IN (CAMBRIDGE,IB)";
    //     // }
    //     $session->delete('parentlogindata');
    //     $session->write('parentlogindata', $cond);
    //     $cond .= " AND Students.status ='Y'";
    //     $detail = $detail . $cond;
    //     $SQL = $detail . " ORDER BY Students.enroll DESC";

    //     $results = $conn->execute($SQL)->fetchAll('assoc');
    //     //pr( $results); die;
    //     $this->set('students', $results);
    // }

    // updated function by Rupam 20-12-2023 
    public function savepromotestudent()
    {
        if ($this->request->is(['post', 'put'])) {
            $classId = $this->request->data['class_id'];
            $academicYear = $this->request->data['academicyear'];
            // pr($this->request->data);exit;

            $classfeeData = $this->Classfee
                ->find()
                ->contain(['Feesheads'])
                ->where([
                    'Classfee.fee_h_id' => '2',
                    'Classfee.class_id' => $classId,
                    'Classfee.academic_year' => $academicYear
                ])
                ->first();

            if ($classfeeData) {

                try {
                    $connection = ConnectionManager::get('default');
                    $connection->begin();

                    $studentsIds = $this->request->data['stud_id'];
                    foreach ($studentsIds as $studentId) {

                        $student = $this->Students->get($studentId)->toArray();
                        $student['stud_id'] = $student['id'];
                        $student['actionhistory'] = $this->request->data['action'];

                        // Check if the record already exists in Studentshistory
                        $userTable = TableRegistry::get('Studentshistory');
                        $exists = $userTable->exists(['stud_id' => $student['stud_id'], 'acedmicyear' => $academicYear]);
                        if (!$exists) {
                            $studentsHistory = $userTable->newEntity();
                            $studentsHistory = $userTable->patchEntity($studentsHistory, $student);
                            $studentsHistory['id'] = null;
                            $userTable->save($studentsHistory);
                        }
                        $get_stdata = $this->Students->get($studentId);
                        // $userData['board_id'] = $this->request->data['board_id'];
                        $userData['class_id'] = $classId;
                        $userData['acedmicyear'] = $academicYear;
                        $userData['section_id'] = $this->request->data['section_id'];
                        // $userData['due_fees'] = $this->request->data['duefees'];
                        $userData['is_promote'] = '1';
                        $students = $this->Students->patchEntity($get_stdata, $userData);

                        // Update Students table
                        $result = $this->Students->save($students);

                        if (!$result) {
                            throw new \Exception('Error saving student data');
                        }
                    }
                    $connection->commit();
                    $this->Flash->success(__('Promoted Student sucessfully.'));
                    return $this->redirect(['action' => 'promote']);
                } catch (\Throwable $th) {
                    if (isset($connection) && $connection->inTransaction()) {
                        $connection->rollback();
                    }

                    $errorMessage = $th->getMessage();
                    $this->Flash->error(__('An error occurred: {0}. Changes rolled back.', $errorMessage));
                    $this->log($th, 'error');
                    return $this->redirect(['action' => 'promote']);
                }
            } else {
                $this->Flash->error(__('Tuition Fee of the selected Academic Year does not exist. Please make sure.'));
                $studentId = $this->request->data['stud_id'][0];
                $student = $this->Students->get($studentId)->toArray();
                $class = $student['class_id'];
                $section = $student['section_id'];
                $year = $student['acedmicyear'];
                return $this->redirect(['action' => 'promote', $class, $section, $year]);
            }
        }
    }



    // public function savepromotestudent()
    // {

    //     if ($this->request->is(['post', 'put'])) {

    //         // pr($this->request->data);
    //         $alldata = $this->Classfee->find('all')->contain(['Feesheads'])->where(['Classfee.fee_h_id' => '2', 'Classfee.class_id' => $this->request->data['class_id'], 'Classfee.academic_year' => $this->request->data['academicyear']])->first();


    //         if ($alldata['id']) {
    //             $romm = sizeof($this->request->data['stud_id']);
    //             $due = 0;
    //             for ($i = 0; $i < $romm; $i++) {
    //                 $student = $this->Students->get($this->request->data['stud_id'][$i])->toArray();
    //                 $student['stud_id'] = $student['id'];
    //                 $student['actionhistory'] = $this->request->data['action'];
    //                 try {
    //                     $userTable = TableRegistry::get('Studentshistory');
    //                     $exists = $userTable->exists(['stud_id' => $student['stud_id'], 'acedmicyear' => $this->request->data['academicyear']]);
    //                     if ($exists) {
    //                     } else {
    //                         $studentshistory = $this->Studentshistory->newEntity();
    //                         $studentshistory = $this->Studentshistory->patchEntity($studentshistory, $student);
    //                         $studentshistory['id'] = '';
    //                         $this->Studentshistory->save($studentshistory);
    //                     }
    //                     $peopleTable = TableRegistry::get('Students');
    //                     //for dynamic class base board id
    //                     $classes_base_board = $this->Classes->find('all')->where(['Classes.status' => '1', 'id' => $this->request->data['class_id']])->order(['Classes.sort' => 'ASC'])->first();

    //                     $this->request->data['board_id'] = $classes_base_board['board_id'];
    //                     $oQuery = $peopleTable->query();
    //                     $oQuery->update();
    //                     $oQuery->set(['board_id' => $this->request->data['board_id'], 'class_id' => $this->request->data['class_id'], 'acedmicyear' => $this->request->data['academicyear'], 'section_id' => $this->request->data['section_id'], 'due_fees' => $this->request->data['duefees'][$i], 'is_promote' => '1'])->where(['id' => $this->request->data['stud_id'][$i]]);

    //                     $oQuery->execute();
    //                 } catch (\PDOException $e) {
    //                 }
    //             }

    //             $this->Flash->success(__('Promoted Student sucessfully.'));
    //             return $this->redirect(['action' => 'promote']);
    //         } else {
    //             $this->Flash->error(__('Tution Fee of Selected Academic Year does not exist ,Please be sure !!!!'));
    //             $student = $this->Students->get($this->request->data['stud_id'][0])->toArray();
    //             $class = $student['class_id'];
    //             $section = $student['section_id'];
    //             $year = $student['acedmicyear'];
    //             return $this->redirect(['action' => 'promote/' . $class . '/' . $section . '/' . $year]);
    //         }
    //     }
    // }

    public function viewgenratepdf()
    {

        if ($this->request->is(['post', 'put'])) {
            $year = $this->request->data['year'];
            $this->set('year', $year);
            $class = $this->request->data['class'];
            $print = $this->request->data['print'];
            $this->set('print', $print);
            $session = $this->request->session();
            if ($class) {
                $session->delete('class');
                $session->write('class', $class);
            }
            $ids = $this->request->data['stud_id'];
            if ($ids) {
                $session->delete('ids');
                $session->write('ids', $ids);
            }
            $validdate = $this->request->data['validdate'];
            if ($validdate) {
                $session->delete('validdate');
                $session->write('validdate', $validdate);
            }

            $enroll = $this->request->data['enroll'];

            $this->set('validdate', $validdate);
            $this->viewBuilder()->layout('ajax');
            $this->response->type('pdf');
            $students = $this->Students->find('all')->contain(['Classes', 'Sections', 'Address'])->where(['Students.id IN' => $ids, 'Students.status' => 'Y'])->toarray();
            $this->set(compact('students'));
        }
    }

    public function viewgenratepdf2()
    {

        if ($this->request->is(['post', 'put'])) {
            $year = $this->request->data['year'];
            $this->set('year', $year);
            $class = $this->request->data['class'];
            $ids = $this->request->data['stud_id'];
            $fname = $this->request->data['fname'];
            $enroll = $this->request->data['enroll'];
            $this->viewBuilder()->layout('ajax');
            $this->response->type('pdf');
            $students =
                $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id IN' => $ids, 'Students.status' => 'Y'])->first()->toarray();
            $this->set(compact('students'));
        }
    }

    //refine done
    public function viewpromotestudent()
    {
        $this->viewBuilder()->layout('admin');
        $classes = $this->Classections->find('list', [
            'keyField' => 'Classes.id',
            'valueField' => 'Classes.title',
        ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'asc'])->toArray();
        $this->set('classes', $classes);

        $sectionslist = $this->Sections->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
        $this->set('sectionslist', $sectionslist);

        if ($this->request->is(['post', 'put'])) {

            // pr($this->request->data);exit;
            $section = $this->request->data['section'];
            $year = $this->request->data['year'];
            $class = $this->request->data['class'];
            $ids = $this->request->data['stud_id'];
            $clasectiom = $this->Classections->find('all')->where(['Classections.class_id' => $class, 'Classections.section_id' => $section])->order(['Classections.id DESC'])->first();
            $csid = $clasectiom['id'];

            $sections = $this->Sections->find('all')->where(['Sections.id' => $section])->order(['Sections.id DESC'])->first();
            $this->set('section', $sections['title']);

            $classes = $this->Classes->find()->where(['Classes.id' => $class])->order(['Classes.id DESC'])->first()->toarray();
            $this->set('class', $classes['title']);

            $action = $this->request->data['action'];
            // pr($action); die;
            $this->set('action', $action);

            $students = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id IN' => $ids, 'Students.status' => 'Y', 'Students.is_promote' => '0'])->order(['Sections.id ASC', 'Students.fname ASC'])->toarray();


            $this->set('students', $students);
            $this->set('sectionid', $section);
            $this->set('year', $year);
            $this->set('classid', $class);
            $this->set('csid', $csid);

            // $empteacher = $this->Employees->find()->where(['Employees.designation_id' => '4'])->order(['Employees.id DESC'])->toarray();
            // $this->set('empteacher', $empteacher);
        }
    }

    public function findperticularamount($id, $a_year)
    {

        return $this->Studentfees->find('all')->select(['id', 'fee', 'discount', 'amount'])->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $a_year])->toArray();
    }

    public function findamount($id, $a_year)
    {

        $articles = TableRegistry::get('Classfee');
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
        ])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year])->order(['Classfee.id' => 'ASC'])->toArray();
    }

    public function findstuduefees($id = null, $year = null)
    {
        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.id' => $id, 'Students.status' => 'Y'])->select(['due_fees'])->toarray();
    }

    // we have remove umwanted code and conditions
    // public function promotesearch()
    // {
    //     //show all data in listing page
    //     //connection
    //     $conn = ConnectionManager::get('default');
    //     $year = $this->request->data['acedmicyear'];
    //     $this->set('year', $year);
    //     $class = $this->request->data['class_id'];
    //     $this->set('class', $class);
    //     $admission = $this->request->data['admissionyear'];
    //     $section = $this->request->data['section_id'];
    //     $this->set('section', $section);
    //     $enroll = $this->request->data['enroll'];
    //     $fname = $this->request->data['fname'];
    //     $detail = "SELECT Students.id,Students.enroll,Students.category,Students.st_full_name,Students.fname,Students.middlename,Students.lname,Students.sms_mobile,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id   WHERE  1=1 ";

    //     $cond = ' ';
    //     if (!empty($year)) {
    //         $cond .= " AND Students.acedmicyear LIKE '" . $year . "' ";
    //     }
    //     if (!empty($class)) {
    //         $cond .= " AND Students.class_id LIKE '" . $class . "' ";
    //     }
    //     if (!empty($section)) {
    //         $cond .= " AND Students.section_id LIKE '" . $section . "' ";
    //     }
    //     if (!empty($enroll)) {
    //         $cond .= " AND Students.enroll LIKE '" . $enroll . "' ";
    //     }
    //     if (!empty($fname)) {
    //         $cond .= " AND UPPER(Students.fname) LIKE '" . strtoupper($fname) . "%' ";
    //     }
    //     $cond .= " AND Students.status='Y'";
    //     $cond .= " AND Students.is_promote='0'";
    //     $detail = $detail . $cond;
    //     $SQL = $detail . " ORDER BY Students.section_id, Students.fname ASC";
    //     $results = $conn->execute($SQL)->fetchAll('assoc');
    //     $this->set('students', $results);
    // }

    // Update this function by Rupam 20-12-2023 
    public function promotesearch()
    {
        $year = $this->request->data['acedmicyear'];
        $class = $this->request->data['class_id'];
        $section = $this->request->data['section_id'];
        $enroll = $this->request->data['enroll'];
        $fname = $this->request->data['fname'];
        $batch = $this->request->data['batch'];

        $conditions = [
            'Students.status' => 'Y',
            'Students.is_promote' => '0',
        ];

        if (!empty($batch)) {
            $conditions['Students.batch LIKE'] = $batch;
        }
        if (!empty($year)) {
            $conditions['Students.acedmicyear LIKE'] = $year;
        }
        if (!empty($class)) {
            $conditions['Students.class_id LIKE'] = $class;
        }
        if (!empty($section)) {
            $conditions['Students.section_id LIKE'] = $section;
        }
        if (!empty($enroll)) {
            $conditions['Students.enroll LIKE'] = $enroll;
        }
        if (!empty($fname)) {
            $conditions['UPPER(Students.fname) LIKE'] = strtoupper($fname) . '%';
        }

        $students = $this->Students
            ->find()
            ->contain(['Classes', 'Sections'])
            ->select([
                'Students.id',
                'Students.enroll',
                'Students.category',
                'Students.fathername',
                'Students.st_full_name',
                'Students.fname',
                'Students.middlename',
                'Students.lname',
                'Students.sms_mobile',
                'Students.mobile',
                'Students.acedmicyear',
                'Students.class_id',
                'Students.section_id',
                'Students.admissionyear',
                'Students.status',
                'Students.due_fees',
                'Sections.title',
                'Classes.title'
            ])
            ->where($conditions)
            ->order(['Students.section_id', 'Students.fname' => 'ASC'])
            ->toArray();

        $this->set(compact('year', 'class', 'section', 'students'));
    }


    public function genrateidsearch()
    {

        //show all data in listing page
        //connection
        $conn = ConnectionManager::get('default');

        $year = $this->request->data['acedmicyear'];
        $year = $this->request->data['acedmicyear'];
        $this->set('year', $year);

        $class = $this->request->data['class_id'];
        $this->set('class', $class);
        $admission = $this->request->data['admissionyear'];

        $section = $this->request->data['section_id'];
        $this->set('section', $section);
        $enroll = $this->request->data['enroll'];
        $this->set('enroll', $enroll);
        $fname = $this->request->data['fname'];
        $this->set('fname', $fname);
        $detail = "SELECT Students.id,Students.fname,Students.dob,Students.fathername,Students.mobile,Students.address,Students.acedmicyear,Students.class_id,Students.section_id,Students.admissionyear,Students.status,  Classes.title as classtitle , Sections.title as sectiontitle FROM `students` Students LEFT JOIN classes Classes ON Students.`class_id` = Classes.id LEFT JOIN sections Sections ON Students.`section_id` = Sections.id    WHERE  1=1 ";

        $cond = ' ';
        if (!empty($year)) {

            $cond .= " AND Students.acedmicyear LIKE '" . $year . "%' ";
        }

        if (!empty($class)) {

            $cond .= " AND Students.class_id LIKE '" . $class . "' ";
        }

        if (!empty($section)) {

            $cond .= " AND Students.section_id LIKE '" . $section . "%' ";
        }

        if (!empty($enroll)) {

            $cond .= " AND Students.enroll LIKE '" . $enroll . "%' ";
        }

        if (!empty($fname)) {

            $cond .= " AND UPPER(Students.fname) LIKE '" . strtoupper($fname) . "%' ";
        }

        $cond .= " AND Students.status='Y'";
        $detail = $detail . $cond;
        $SQL = $detail . " ORDER BY Students.id DESC";

        $results = $conn->execute($SQL)->fetchAll('assoc');

        $this->set('students', $results);
    }
    //status update functionality
    //refine done
    public function status($id, $status)
    {

        $statusquery = $this->Students->find('all')->where(['Students.status' => 'Y'])->count();
        if (isset($id) && !empty($id)) {
            if ($status == 'Y') {
                $status = 'N';
                $classes = $this->Students->get($id);
                $classes->status = $status;
                if ($this->Students->save($classes)) {
                    $this->Flash->success(__('Your students status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $status = 'Y';
                $classes = $this->Students->get($id);
                $classes->status = $status;
                if ($this->Students->save($classes)) {
                    $this->Flash->success(__('Your students status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }
    //refine done
    public function statusdrop($id, $status)
    {
        if (isset($id) && !empty($id)) {
            $status = 'Y';
            $classes = $this->DropOutStudent->get($id);
            $classes->status_tc = $status;
            if ($this->DropOutStudent->save($classes)) {
                $this->Flash->success(__('Drop Out Student Request for Genrate T.C. Or C.C are approved !!!!'));
                return $this->redirect(['action' => 'drop']);
            }
        }
    }
    public function statussms($id, $status)
    {

        $statusquery = $this->Smsmanager->find('all')->where(['Smsmanager.status' => 'Y'])->count();
        if (isset($id) && !empty($id)) {
            if ($status == 'Y') {

                $status = 'N';
                //status update
                $classes = $this->Smsmanager->get($id);
                $classes->status = $status;
                if ($this->Smsmanager->save($classes)) {
                    $this->Flash->success(__('Your SMS status has been updated.'));
                    return $this->redirect(['action' => 'smsmanager']);
                }
            } else {

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
    //refine done
    public function documentstatus($id, $status)
    {
        $statusquery = $this->Documents->find('all')->where(['Documents.status' => 'Y'])->count();
        if (isset($id) && !empty($id)) {
            if ($status == 'Y') {
                $status = 'N';
                $classes = $this->Documents->get($id);
                $classes->status = $status;
                if ($this->Documents->save($classes)) {
                    $this->Flash->success(__('Your document status has been updated.'));
                    return $this->redirect(['action' => 'view/' . $classes->user_id . '?id=documents']);
                }
            } else {
                $status = 'Y';
                $classes = $this->Documents->get($id);
                $classes->status = $status;
                if ($this->Documents->save($classes)) {
                    $this->Flash->success(__('Your documents status has been updated.'));
                    return $this->redirect(['action' => 'view/' . $classes->user_id . '?id=documents']);
                }
            }
        }
    }

    public function addocument($id = null)
    {
        if ($_GET['ids']) {
            $this->set('ids', $_GET['ids']);
        }

        $addeddocument = $this->Documents->find('all')->where(['user_id' => $_GET['ids']])->select(['doccat_id'])->toarray();
        if (empty($addeddocument) && !empty($id)) {
            $getDocum = $this->Documents->find('all')
                ->where(['id' => $id])
                ->select(['user_id', 'doccat_id'])
                ->first();
            $this->set('selectDocument', $getDocum['doccat_id']);

            $addeddocument = $this->Documents->find('all')
                ->where([
                    'user_id' => $getDocum['user_id'],
                    'id !=' => $id
                ])
                ->select(['doccat_id', 'id'])
                ->toArray();
        }
        if (count($addeddocument) > 0) {
            foreach ($addeddocument as $key => $value) {
                $docCateIds[] = $value['doccat_id'];
            }
            $documentcategory = $this->Documentcategory->find('list', [
                'keyField' => 'id',
                'valueField' => 'categoryname',
            ])->where(['id NOT IN' => $docCateIds])->order(['id' => 'ASC'])->toArray();
        } else {
            $documentcategory = $this->Documentcategory->find('list', [
                'keyField' => 'id',
                'valueField' => 'categoryname',
            ])->order(['id' => 'ASC'])->toArray();
        }
        $this->set('documentcategory', $documentcategory);

        if (isset($id) && !empty($id)) {
            $documents = $this->Documents->get($id);
            $this->set('ids', $documents->user_id);
            $sections = $this->Documents->find()->select(['doccat_id', 'user_id', 'photo'])->where(['Documents.id' => $id])->order(['id' => 'ASC'])->first();
            $rt = '1';
        } else {
            $documents = $this->Documents->newEntity();
            $rt = '0';
        }

        $this->set('documents', $documents);
        $this->set('rt', $rt);



        if ($this->request->is(['post', 'put'])) {
            $doc_count = $this->Documents->find('all')->where(['Documents.doccat_id' => $this->request->data['doccat_id'], 'Documents.user_id' => $this->request->data['user_id']])->count();
            // same documents not save in database
            if (empty($id)) {
                if ($doc_count > 0) {
                    $this->Flash->error('This document already uploaded');
                    return $this->redirect(['action' => 'view/' . $this->request->data['user_id'] . '?id=documents']);
                }
            }

            if ($this->request->data['photo']['name'] != '' && !empty($this->request->data['photo']['name'])) {
                $oimg = $this->request->data['photo'];
                if ($oimg != '') {
                    if ($this->request->data['photo']['tmp_name']) {
                        $directory = WWW_ROOT . 'img/';
                        $ext = pathinfo($this->request->data['photo']['name'], PATHINFO_EXTENSION);
                        $filename = md5(time()) . "." . $ext;
                        $path = WWW_ROOT . "img/" . $filename;

                        if (move_uploaded_file($this->request->data['photo']['tmp_name'], $path));
                        $file = WWW_ROOT . 'img/' . $sections['photo'];
                        unlink($file);
                        $this->request->data['photo'] = $filename;
                        $this->request->data['ext'] = $ext;
                    }
                }
            } else {
                $this->request->data['photo'] = $sections['photo'];
            }
            $this->request->data['created'] = date('Y-m-d', strtotime($this->request->data['created']));
            $this->request->data['type'] = "0";

            $documents = $this->Documents->patchEntity($documents, $this->request->data);
            if ($this->Documents->save($documents)) {
                $this->Flash->success(__('Your Documents has been saved.'));
                return $this->redirect(['action' => 'view/' . $this->request->data['user_id'] . '?id=documents']);
            }
        }
    }
    public function img()
    {
        $id = $_GET['r'];
        $sections = $this->Documents->find()->select(['photo'])->where(['Documents.id' => $id])->order(['id' => 'ASC'])->first();
        $this->set('sections', $sections);
    }

    public function addcsv()
    {
        $this->viewBuilder()->layout('admin');
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->data['file']['type'] == 'application/csv' || 'application/vnd.ms-excel' || ' text/csv') {
                $filenam = $this->request->data['file']['name'];
                $mkr1 = rand(1, 13000000);
                $filename = $mkr1 . $filenam;
                $item = $this->request->data['file']['tmp_name'];
                if (move_uploaded_file($item, "excel_file/" . $filename)) {
                    $this->csv($filename);
                }
                $directory = WWW_ROOT . 'excel_file/' . $filename;
                unlink($directory);
                $directory2 = WWW_ROOT . 'excel_file/' . $mkr1;
                unlink($directory2);
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__(' File type must be csv only'), 'flash/Error');
            }
        }
    }

    public function csv($filename)
    {

        $documents = $this->Students->newEntity();
        $filename = SITE_URL . 'excel_file/' . $filename;
        // open the file
        $handle = fopen($filename, "r");
        // read the 1st row as headings
        $header = fgetcsv($handle);
        // create a message container
        $return = array(
            'messages' => array(),
            'errors' => array(),
        );
        // Remove any invalid or hidden characters
        if (sizeof($header) == 1) {
            $field = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $header[0]);
            $header = explode(",", $field);
        }
        // read each data row in the file
        while (($row = fgetcsv($handle)) !== false) {
            //   pr($row); die;
            $data = array();
            if (sizeof($row) == 1) {
                $row = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $row[0]);
                $row = explode(",", $row);
            }
            // for each header field
            foreach ($header as $k => $head) {
                $data[$head] = (isset($row[$k])) ? $row[$k] : ',';
                $this->request->data[$head] = (isset($row[$k])) ? $row[$k] : ',';
                if ($head == 'section_id') {
                    $classes = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Sections.title' => $this->request->data['section_id']])->order(['Classes.id' => 'asc'])->first();
                }
                if ($head == 'class_id') {
                    $classesname = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classes.title' => $this->request->data['class_id']])->order(['Classes.sort' => 'ASC'])->first();
                }
            }
            $this->request->data['section_id'] = $classes['section_id'];
            $this->request->data['class_id'] = $classesname['class_id'];
            if ($this->request->data['section_id'] == '' || $this->request->data['class_id'] == '') {
                $this->request->data['section_id'] = $classes['section_id'];
                $this->request->data['class_id'] = $classesname['class_id'];
                $this->Flash->error(__('Class or Section does not validate.'), 'flash/sucess');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->success(__('Import Students has been saved.'), 'flash/sucess');
            }
        }
        $this->request->data['file'] = $this->request->data['file']['name'];
        $documents = $this->Students->patchEntity($documents, $this->request->data);
        $this->Students->save($documents);
        $this->set($data);
        fclose($handle);
        return $return;
    }
    //refine done
    public function studentimage($id = null)
    {
        $db = $this->Auth->User('db');
        $this->viewBuilder()->layout('admin');
        if (isset($id) && !empty($id)) {
            $students = $this->Students->find()->where(['Students.id' => $id, 'Students.status' => 'Y'])->first();
            $this->set(compact('students'));
            $studentss = $this->Students->get($id);
        } else {
            $studentss = $this->Students->newEntity();
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->request->data['photo'] != "") {
                if ($this->request->data['photo']['tmp_name']) {
                    $db = $this->request->session()->read('Auth.User.db');
                    // $directory = WWW_ROOT . $db . "_image/student/" . $studentss['file'];
                    $directory = WWW_ROOT . "student/" . $studentss['file'];
                    unlink($directory);
                    $ext = pathinfo($this->request->data['photo']['name'], PATHINFO_EXTENSION);
                    $filename = uniqid() . "." . $ext;
                    // $path = WWW_ROOT . $db . "_image/student/" . $filename;
                    $path = WWW_ROOT . "student/" . $filename;
                    if (move_uploaded_file($this->request->data['photo']['tmp_name'], $path));
                    $this->request->data['file'] = $filename;
                }
                $stu_pic = $this->Students->patchEntity($studentss, $this->request->data);
                if ($this->Students->save($stu_pic)) {
                    $this->Flash->success(__('Profile Picture has been saved.'));
                    return $this->redirect(['action' => 'view/' . $studentss['id']]);
                }
            }
        }
    }



    //refine done
    public function dropsubmit($id = null)
    {
        if ($id) {

            $s_id = $id;
            $student = $this->Students->get($s_id)->toArray();
            $student['s_id'] = $student['id'];
            $student['admissiondate'] = $student['created'];
            $student['updateacedemic'] = $student['acedmicyear'];
            try {
                $this->Students->delete($this->Students->get($s_id));
                $studUser = $this->Users->find('all')->where(['student_id' => $student['id']])->first();
                $this->Users->delete($studUser);
                $drop_out_student = $this->DropOutStudent->newEntity();
                $student['dropcreated'] = date('Y-m-d H:i:s');
                $student['laststudclass'] = $student['class_id'];
                unset($student['id']);
                $drop_out_student = $this->DropOutStudent->patchEntity($drop_out_student, $student);
                $this->DropOutStudent->save($drop_out_student);
                $this->Flash->success(__('Now, you can download Transfer and Character certificate for the drop out student having id: ' . $s_id . '.'));
                return $this->redirect(['action' => 'drop']);
            } catch (\PDOException $ex) {
                if ($ex->getCode() == 23000) {
                    $this->Flash->error(__("Please clear dues before dropping the student with id: " . $s_id . '.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__($ex->getMessage()));
                    return $this->redirect(['action' => 'index']);
                }
            }
        } elseif ($this->request->is(['post', 'put'])) {

            $s_id = $this->request->data['id'];
            $remarks_lwt = $this->request->data['remarks_lwt'];
            $student = $this->Students->get($s_id)->toArray();
            $student['s_id'] = $student['id'];
            $student['admissiondate'] = $student['created'];
            try {
                $this->Students->delete($this->Students->get($s_id));
                $drop_out_student = $this->DropOutStudent->newEntity();
                $student['dropcreated'] = date('Y-m-d H:i:s');
                $student['laststudclass'] = $student['class_id'];
                $student['remarks_lwt'] = $remarks_lwt;
                unset($student['id']);
                $drop_out_student = $this->DropOutStudent->patchEntity($drop_out_student, $student);

                $this->DropOutStudent->save($drop_out_student);
                $this->Flash->success(__('Student named ' . $student['fname'] . ' ' . $student['middlename'] . ' ' . $student['lname'] . ' has been dropped successfully.'));

                return $this->redirect(['action' => 'drop']);
            } catch (\PDOException $ex) {
                // if ($ex->getCode() == 23000) {
                //     $this->Flash->error(__("Please clear dues before dropping the student with id: " . $s_id . '.'));
                //     return $this->redirect(['action' => 'index']);
                // } else {
                $this->Flash->error(__($ex->getMessage() . ' Please try again!'));
                return $this->redirect(['action' => 'index']);
                // }
            }
        } else {
            $this->Flash->error(__("kindly Try Again For DropOut !!!"));
            return $this->redirect(['action' => 'index']);
        }
    }



    public function restore($id)
    {

        $userId = $this->request->session()->read('Auth.User.id');
        $dropoutStudent = $this->DropOutStudent->get($id)->toArray();


        try {
            $s_id = $this->request->data['id'];
            $dropoutStudent['id'] = $dropoutStudent['s_id'];
            $dropoutStudent['admissiondate'] = date('Y-m-d H:i:s', strtotime($dropoutStudent['admissiondate']));
            $drop_out_student = $this->Students->newEntity();
            $drop_out_student = $this->Students->patchEntity($drop_out_student, $dropoutStudent);
            $this->Students->save($drop_out_student);

            $this->DropOutStudent->delete($this->DropOutStudent->get($id));
            $newRestore = $this->StudentRestores->newEntity();
            $newRestore['student_id'] = $dropoutStudent['s_id'];
            $newRestore['user_id'] = $userId;
            $this->StudentRestores->save($newRestore);

            $this->Flash->success(__('Student Restore Sucessfully!! '));
            return $this->redirect(['action' => 'drop']);
        } catch (\PDOException $ex) {
            $this->Flash->error(__($ex->getMessage() . ' Please try again!'));
            return $this->redirect(['action' => 'index']);
            // }
        }
    }

    //-----------------------------------------------------------------------------------------------------------------
    //refine code
    // public function restore($id = null)
    // {
    //     $userId = $this->request->session()->read('Auth.User.id');
    //     $dropoutStudent = $this->DropOutStudent->get($id)->toArray();
    //     $admissiondate = date('Y-m-d H:i:s', strtotime($dropoutStudent['admissiondate']));
    //     $conn = ConnectionManager::get('default');
    //     $detail = 'INSERT INTO `students`(`id`, `fname`, `middlename`, `lname`, `fee_submittedby`, `board_id`, `fathername`, `mothername`,`username`, `password`, `dob`, `enroll`, `mobile`, `mobile2`, `sms_mobile`, `formno`, `adaharnumber`, `cast`, `parent_id`,`house_id`, `class_id`, `category`, `section_id`, `gender`, `photo`, `bloodgroup`, `religion`, `address`, `city`, `nationality`,`admissionyear`, `acedmicyear`, `status`, `file`, `comp_sid`, `opt_sid`, `h_id`, `room_no`, `is_transport`, `transportloc_id`, `v_num`, `dis_fees`, `dis_transport`, `is_discount`, `discountcategory`, `due_fees`, `token`, `rf_id`, `height`, `weight`, `is_special`, `is_lc`,`disability`, `mother_tounge`, `f_qualification`, `f_occupation`, `m_qualification`, `m_occupation`, `f_phone`, `m_phone`, `admissionclass`, `created`) VALUES("' . $dropoutStudent['s_id'] . '","' . $dropoutStudent['fname'] . '","' . $dropoutStudent['middlename'] . '","' . $dropoutStudent['lname'] . '","' . $dropoutStudent['fee_submittedby'] . '","' . $dropoutStudent['board_id'] . '","' . $dropoutStudent['fathername'] . '","' . $dropoutStudent['mothername'] . '","' . $dropoutStudent['username'] . '","' . $dropoutStudent['password'] . '","' . date('Y-m-d', strtotime($dropoutStudent['dob'])) . '","' . $dropoutStudent['enroll'] . '","' . $dropoutStudent['mobile'] . '","' . $dropoutStudent['mobile2'] . '","' . $dropoutStudent['sms_mobile'] . '","' . $dropoutStudent['formno'] . '","' . $dropoutStudent['adaharnumber'] . '","' . $dropoutStudent['cast'] . '","' . $dropoutStudent['parent_id'] . '","' . $dropoutStudent['house_id'] . '","' . $dropoutStudent['class_id'] . '","' . $dropoutStudent['category'] . '","' . $dropoutStudent['section_id'] . '","' . $dropoutStudent['gender'] . '","' . $dropoutStudent['photo'] . '","' . $dropoutStudent['bloodgroup'] . '","' . $dropoutStudent['religion'] . '","' . $dropoutStudent['address'] . '","' . $dropoutStudent['city'] . '","' . $dropoutStudent['nationality'] . '","' . $dropoutStudent['admissionyear'] . '","' . $dropoutStudent['acedmicyear'] . '","' . $dropoutStudent['status'] . '","' . $dropoutStudent['file'] . '","' . $dropoutStudent['comp_sid'] . '","' . $dropoutStudent['opt_sid'] . '","' . $dropoutStudent['h_id'] . '","' . $dropoutStudent['room_no'] . '","' . $dropoutStudent['is_transport'] . '","' . $dropoutStudent['transportloc_id'] . '","' . $dropoutStudent['v_num'] . '","' . $dropoutStudent['dis_fees'] . '","' . $dropoutStudent['dis_transport'] . '","' . $dropoutStudent['is_discount'] . '","' . $dropoutStudent['discountcategory'] . '","' . $dropoutStudent['due_fees'] . '","' . $dropoutStudent['token'] . '","' . $dropoutStudent['rf_id'] . '","' . $dropoutStudent['height'] . '","' . $dropoutStudent['weight'] . '","' . $dropoutStudent['is_special'] . '","' . $dropoutStudent['is_lc'] . '","' . $dropoutStudent['disability'] . '","' . $dropoutStudent['mother_tounge'] . '","' . $dropoutStudent['f_qualification'] . '","' . $dropoutStudent['f_occupation'] . '","' . $dropoutStudent['m_qualification'] . '","' . $dropoutStudent['m_occupation'] . '","' . $dropoutStudent['f_phone'] . '","' . $dropoutStudent['m_phone'] . '","' . $dropoutStudent['admissionclass'] . '","' . $admissiondate . '")';
    //     $results = $conn->execute($detail);
    //     if ($results) {
    //         $this->DropOutStudent->delete($this->DropOutStudent->get($id));
    //         $newRestore = $this->StudentRestores->newEntity();
    //         $newRestore['student_id'] = $dropoutStudent['s_id'];
    //         $newRestore['user_id'] = $userId;
    //         $this->StudentRestores->save($newRestore);
    //     }
    //     $this->Flash->success(__('Student Restore Sucessfully!! '));
    //     return $this->redirect(['action' => 'drop']);
    // }



    public function view_out($id = null)
    {
        if (!empty($id)) {
            $this->set(compact('id'));
        }
        $issueBook = $this->IssueBook->find('all')->where(['IssueBook.holder_id' => $id, 'IssueBook.holder_type_id' => 'Student', 'IssueBook.status' => 'Y'])->order(['IssueBook.id DESC'])->toarray();
        $this->set(compact('issueBook'));
        $student = $this->Students->find('all')->where(['Students.id' => $id])->first();
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $classss = $this->Classes->find('all')->where(['Classes.id' => $student['class_id']])->first();
        $sectionsss = $this->Sections->find('all')->where(['Sections.id' => $student['section_id']])->first();
        $acedmicyear = $student["acedmicyear"];
        $acedmiclassid = $student["class_id"];
        $this->set('academic_year', $student["acedmicyear"]);
        $this->set('enroll', $student["enroll"]);
        $this->set('discountcategory', $student["discountcategory"]);
        $this->set('fname', $student["fname"]);
        $this->set('middlename', $student["middlename"]);
        $this->set('lname', $student["lname"]);
        $this->set('ctitle', $classss["title"]);
        $this->set('class_ids', $student["class_id"]);
        $this->set('comp_sid', $student["comp_sid"]);
        $this->set('opt_sid', $student["opt_sid"]);
        $this->set('stitle', $sectionsss["title"]);
        $this->set('academic_class', $acedmiclassid);
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
        $this->set(compact('classfee'));
        $studentfeesk = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["id"], 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();

        $this->set(compact('studentfeesk'));
        $studentfees = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["id"], 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();
        $this->set(compact('studentfees'));
        $fid = ['7', '3', '4', '9'];
        $preclassfee = $this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid, 'Classfee.fee_h_id IN' => $fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
        $this->set(compact('preclassfee'));
        $student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $student["id"], 'Studentfeepending.status' => 'N'])->toarray();
        $this->set('student_feepending', $student_feepending);
    }
    // //refine done
    // public function dropsubmit($id = null)
    // {
    //     if ($id) {
    //         pr($this->request->data);
    //         exit;
    //         $s_id = $id;
    //         $student = $this->Students->get($s_id)->toArray();
    //         $student['s_id'] = $student['id'];
    //         $student['admissiondate'] = $student['created'];
    //         $student['updateacedemic'] = $student['acedmicyear'];
    //         try {
    //             $this->Students->delete($this->Students->get($s_id));
    //             $studUser = $this->Users->find('all')->where(['student_id' => $student['id']])->first();
    //             $this->Users->delete($studUser);
    //             $drop_out_student = $this->DropOutStudent->newEntity();
    //             $student['dropcreated'] = date('Y-m-d H:i:s');
    //             $student['laststudclass'] = $student['class_id'];
    //             unset($student['id']);
    //             $drop_out_student = $this->DropOutStudent->patchEntity($drop_out_student, $student);
    //             $this->DropOutStudent->save($drop_out_student);
    //             $this->Flash->success(__('Now, you can download Transfer and Character certificate for the drop out student having id: ' . $s_id . '.'));
    //             return $this->redirect(['action' => 'drop']);
    //         } catch (\PDOException $ex) {
    //             if ($ex->getCode() == 23000) {
    //                 $this->Flash->error(__("Please clear dues before dropping the student with id: " . $s_id . '.'));
    //                 return $this->redirect(['action' => 'index']);
    //             } else {
    //                 $this->Flash->error(__($ex->getMessage()));
    //                 return $this->redirect(['action' => 'index']);
    //             }
    //         }
    //     } elseif ($this->request->is(['post', 'put'])) {

    //         $s_id = $this->request->data['id'];
    //         $remarks_lwt = $this->request->data['remarks_lwt'];
    //         $student = $this->Students->get($s_id)->toArray();
    //         $student['s_id'] = $student['id'];
    //         $student['admissiondate'] = $student['created'];
    //         try {
    //             $this->Students->delete($this->Students->get($s_id));
    //             $drop_out_student = $this->DropOutStudent->newEntity();
    //             $student['dropcreated'] = date('Y-m-d H:i:s');
    //             $student['laststudclass'] = $student['class_id'];
    //             $student['remarks_lwt'] = $remarks_lwt;
    //             unset($student['id']);
    //             $drop_out_student = $this->DropOutStudent->patchEntity($drop_out_student, $student);
    //             // pr($drop_out_student);
    //             // exit;
    //             $this->DropOutStudent->save($drop_out_student);
    //             $this->Flash->success(__('Student named ' . $student['fname'] . ' ' . $student['middlename'] . ' ' . $student['lname'] . ' has been dropped successfully.'));

    //             return $this->redirect(['action' => 'drop']);
    //         } catch (\PDOException $ex) {
    //             // if ($ex->getCode() == 23000) {
    //             //     $this->Flash->error(__("Please clear dues before dropping the student with id: " . $s_id . '.'));
    //             //     return $this->redirect(['action' => 'index']);
    //             // } else {
    //             $this->Flash->error(__($ex->getMessage() . ' Please try again!'));
    //             return $this->redirect(['action' => 'index']);
    //             // }
    //         }
    //     } else {
    //         $this->Flash->error(__("kindly Try Again For DropOut !!!"));
    //         return $this->redirect(['action' => 'index']);
    //     }
    // }


    public function gethistoryyearstudentinfo($id = null, $acedemic = null)
    {
        $articles = TableRegistry::get('Studentshistory');
        return $articles->find('all')->where(['Studentshistory.stud_id' => $id, 'Studentshistory.acedmicyear' => $acedemic, 'Studentshistory.status' => 'Y', 'Studentshistory.actionhistory' => 'REPEAT'])->order(['Studentshistory.id' => 'DESC'])->first();
    }

    public function gethistoryyearstudentinfo45($id = null)
    {
        $articles = TableRegistry::get('Studentshistory');
        return $articles->find('all')->where(['Studentshistory.stud_id' => $id, 'Studentshistory.status' => 'Y'])->order(['Studentshistory.id' => 'DESC'])->first();
    }

    public function findridacademicre($stud_id, $acedmic)
    {
        $articles = TableRegistry::get('Studentfees');
        // Start a new query.
        return $articles->find('all')->select(['id'])->where(['Studentfees.student_id' => $stud_id, 'Studentfees.quarter NOT LIKE' => '%T.C.%', 'Studentfees.acedmicyear' => $acedmic])->order(['Studentfees.id' => 'DESC'])->first();
    }

    public function drop_outs($id = null)
    {
        if (!empty($id)) {
            $studentss = $this->DropOutStudent->find('all')->where(['DropOutStudent.s_id' => $id])->first();
        }
        $findstu = $this->findridacademicre($id, $studentss['acedmicyear']);
        $detained['id'] = '';
        if ($findstu['id'] == '') {
            $detained = $this->gethistoryyearstudentinfo45($id);
        }
        if ($detained['id']) {
            $this->set(compact('id'));
            $student = $this->Studentshistory->find('all')->where(['Studentshistory.id' => $detained['id']])->first();
            $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
            $acedmicyear = $student['acedmicyear'];
            $acedmiclassid = $student["class_id"];
            $this->set('name', $student['fname'] . " " . $student['middlename'] . " " . $student['lname']);
            $this->set('enroll', $student['enroll']);
            $this->set('academic_year', $acedmicyear);
            $this->set('academic_class', $acedmiclassid);
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
            $this->set(compact('classfee'));
            $studentfeesk = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["stud_id"], 'Studentfees.recipetno !=' => 0, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();

            $this->set(compact('studentfeesk'));
            $studentfees = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["stud_id"], 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();
            $this->set(compact('studentfees'));
            $fid = ['7', '3', '4', '9'];
            $preclassfee = $this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid, 'Classfee.fee_h_id IN' => $fid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
            $this->set(compact('preclassfee'));

            $student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $student["stud_id"], 'Studentfeepending.status' => 'N'])->toarray();
            $this->set('student_feepending', $student_feepending);

            $studentkk = $this->DropOutStudent->find('all')->where(['DropOutStudent.s_id' => $id])->first();
            $acedmicyearkk = $studentkk['acedmicyear'];
            $studentfeeshj4 = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $studentkk["s_id"], 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $acedmicyearkk, 'Studentfees.status' => 'Y'])->toarray();
            $this->set(compact('studentfeeshj4'));
        } else {
            $this->set(compact('id'));
            $student = $this->DropOutStudent->find('all')->where(['DropOutStudent.s_id' => $id])->first();
            $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
            $acedmicyear = $student['acedmicyear'];
            $acedmiclassid = $student["class_id"];
            $this->set('name', $student['fname'] . " " . $student['middlename'] . " " . $student['lname']);
            $this->set('enroll', $student['enroll']);
            $this->set('academic_year', $acedmicyear);
            $this->set('academic_class', $acedmiclassid);
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
            $this->set(compact('classfee'));
            $studentfeesk = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["s_id"], 'Studentfees.recipetno !=' => 0, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();
            $this->set(compact('studentfeesk'));

            $studentfees = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["s_id"], 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();
            $this->set(compact('studentfees'));

            $fees_head_id = ['7', '3', '4', '9'];
            $preclassfee = $this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid, 'Classfee.fee_h_id IN' => $fees_head_id])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
            $this->set(compact('preclassfee'));

            $student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $student["s_id"], 'Studentfeepending.status' => 'N'])->toarray();
            $this->set('student_feepending', $student_feepending);
        }
    }

    public function dropoutwithrefund($id)
    {
        $student = $this->Students->find('all')->where(['Students.id' => $id])->first();
        $this->set('id', $id);

        $this->set('name', $student['fname'] . " " . $student['middlename'] . " " . $student['lname']);
        $this->set('enroll', $student['enroll']);
        $this->set('student', $student);
    }

    public function dropwithrefund()
    {
        $this->loadModel('Studentfees');

        if ($this->request->is(['post', 'put'])) {

            // pr($this->request->data);
            // exit;

            $s_id = $this->request->data['studentId'];
            $remarks_lwt = trim($this->request->data['remarks_lwt']);
            $ref_no = trim($this->request->data['ref_no']);
            $payment_mode = $this->request->data['payment_mode'];
            $refund_fee_amount = $this->request->data['refund_fee_amount'];
            $total_deposited_amount = $this->request->data['total_deposited_amount'];
            $totalDifferance = (int) ($total_deposited_amount - $refund_fee_amount);
            $student = $this->Students->get($s_id)->toArray();

            try {
                // Step 1: Get all active deposits
                $studentDeposits = $this->Studentfees->find('all')
                    ->where(['student_id' => $s_id, 'status' => 'Y'])
                    ->toArray();

                $student_datasmaxss = $this->Studentfees->find('all')->contain(['Students'])->select(['last_reciept_number' => 'Studentfees.recipetno'])->where(['Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno DESC'])->first();
                // Step 2: Cancel all deposit receipts
                $this->Studentfees->updateAll(
                    ['status' => 'N'],
                    ['student_id' => $s_id]
                );

                // Step 3: Add refund entry (negative amount)

                $refundData['student_id'] = $s_id;
                $refundData['section_id'] = $student['section_id'];
                $refundData['ref_no'] = $ref_no;
                $refundData['recipetno'] = $student_datasmaxss['last_reciept_number'] + 1;
                $refundData['token'] = substr(bin2hex(random_bytes(7)), 0, 13);
                $refundData['quarter'] = serialize([
                    'Initial Deposit' => (int) $total_deposited_amount,
                    'File Charges'    => (int) $totalDifferance,  // Add the fine charge here
                    'Total Refund'    => (int) -abs($refund_fee_amount)  // Total refund after fine
                ]);
                $refundData['board_id'] = $student['board_id'];
                $refundData['mode'] = $payment_mode;
                $refundData['fee'] = $refund_fee_amount;
                $refundData['amount'] = $totalDifferance;
                $refundData['deposite_amt'] = $totalDifferance;
                $refundData['quarter_name'] = 'Refund';
                $refundData['acedmicyear'] = $student['acedmicyear'];
                $refundData['remarks'] = 'Processed refund of ' . (intval($refund_fee_amount) == $refund_fee_amount ? number_format($refund_fee_amount, 0) : number_format($refund_fee_amount, 2)) .
                    ' via ' . strtoupper($payment_mode) .
                    ' against total deposited amount ' . (intval($total_deposited_amount) == $total_deposited_amount ? number_format($total_deposited_amount, 0) : number_format($total_deposited_amount, 2)) .
                    '. Fine charged: ' . (intval($totalDifferance) == $totalDifferance ? number_format($totalDifferance, 0) : number_format($totalDifferance, 2)) .
                    ' due to dropout. Remarks: ' . $remarks_lwt;
                $refundData['created'] = date('Y-m-d H:i:s');
                $refundData['paydate'] = date('Y-m-d');
                // pr($refundData);exit;

                $refundEntity = $this->Studentfees->newEntity();
                $refundEntity = $this->Studentfees->patchEntity($refundEntity, $refundData);
                $this->Studentfees->save($refundEntity);

                // Step 4: Move student to DropOutStudent table
                $student['s_id'] = $student['id'];
                $student['admissiondate'] = $student['created'];
                $student['dropcreated'] = date('Y-m-d H:i:s');
                $student['laststudclass'] = $student['class_id'];
                $student['remarks_lwt'] = $remarks_lwt;
                $student['total_deposite_amount'] = $total_deposited_amount;
                $student['total_refund_amount'] = $refund_fee_amount;

                unset($student['id']); // make it a new entry

                $drop_out_student = $this->DropOutStudent->newEntity();
                $drop_out_student = $this->DropOutStudent->patchEntity($drop_out_student, $student);
                $this->DropOutStudent->save($drop_out_student);

                // Step 5: Delete original student
                $this->Students->deleteAll(['id' => $s_id]);

                $this->Flash->success(__('Student ' . $student['fname'] . ' ' . $student['middlename'] . ' ' . $student['lname'] . ' has been dropped successfully.'));
                return $this->redirect(['action' => 'drop']);
            } catch (\PDOException $ex) {
                $this->Flash->error(__('Error: ' . $ex->getMessage() . ' Please try again!'));
                return $this->redirect($this->referer()); // go back if error
            }
        } else {
            $this->Flash->error(__("Kindly try again for DropOut!"));
            return $this->redirect($this->referer());
        }
    }


    public function drop_out($id = null)
    {

        if (!empty($id)) {
            $student = $this->Students->find('all')->where(['Students.id' => $id])->first();
        }

        $findstu = $this->findridacademicre($id, $student['acedmicyear']);

        if ($findstu['id'] == '') {
            $detained = $this->gethistoryyearstudentinfo45($id);
        }

        // pr($detained);exit;
        if ($detained['id']) {

            $this->set(compact('id'));

            $student = $this->Studentshistory->find('all')->where(['Studentshistory.id' => $detained['id']])->first();
            $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();

            $acedmicyear = $student['acedmicyear'];
            $acedmiclassid = $student["class_id"];

            $this->set('name', $student['fname'] . " " . $student['middlename'] . " " . $student['lname']);
            $this->set('enroll', $student['enroll']);
            $this->set('academic_year', $acedmicyear);
            $this->set('academic_class', $acedmiclassid);

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

            $this->set(compact('classfee'));
            $studentfeesk = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["stud_id"], 'Studentfees.recipetno !=' => 0, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();
            $this->set(compact('studentfeesk'));

            $studentfees = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["stud_id"], 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();
            $this->set(compact('studentfees'));

            $fees_head_id = ['7', '3', '4', '9'];
            $preclassfee = $this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid, 'Classfee.fee_h_id IN' => $fees_head_id])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
            $this->set(compact('preclassfee'));

            $student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $student["stud_id"], 'Studentfeepending.status' => 'N'])->toarray();
            $this->set('student_feepending', $student_feepending);

            $studentkk = $this->DropOutStudent->find('all')->where(['DropOutStudent.s_id' => $id])->first();
            $acedmicyearkk = $studentkk['acedmicyear'];

            $studentfeeshj4 = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $studentkk["s_id"], 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $acedmicyearkk, 'Studentfees.status' => 'Y'])->toarray();

            $this->set(compact('studentfeeshj4'));
        } else {

            $this->set(compact('id'));

            $student = $this->Students->find('all')->where(['Students.id' => $id])->first();
            // pr($student);
            // exit;
            $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
            $acedmicyear = $student['acedmicyear'];
            $acedmiclassid = $student["class_id"];

            $this->set('name', $student['fname'] . " " . $student['middlename'] . " " . $student['lname']);
            $this->set('enroll', $student['enroll']);
            $this->set('academic_year', $acedmicyear);
            $this->set('academic_class', $acedmiclassid);
            $this->set('student', $student);

            // $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->where(['Classfee.fee_h_id IN' => ['2', '9'], 'Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid])->order(['Classfee.id' => 'ASC'])->select([
            //     'qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' => $this->Classfee->find()->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find()->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find()->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id',
            // ])->toarray();
            // $this->set(compact('classfee'));

            // $studentfeesk = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["id"], 'Studentfees.recipetno !=' => 0, 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();

            // $this->set(compact('studentfeesk'));
            // $studentfees = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student["id"], 'Studentfees.refrencepending' => '0', 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfees.status' => 'Y'])->toarray();
            // $this->set(compact('studentfees'));

            // $fees_head_id = ['7', '3', '4', '9'];
            // $preclassfee = $this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $acedmicyear, 'Classfee.class_id' => $acedmiclassid, 'Classfee.fee_h_id IN' => $fees_head_id])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
            // $this->set(compact('preclassfee'));

            // $student_feepending = $this->Studentfeepending->find('all')->where(['Studentfeepending.s_id' => $student["id"], 'Studentfeepending.status' => 'N'])->toarray();
            // $this->set('student_feepending', $student_feepending);
        }
    }

    function hostel_fee_enable_disable($id = null)
    {

        $this->loadModel('HostelFeesManagement');
        $this->set(compact('id'));

        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        if (!empty($id)) {
            $student = $this->Students->find('all')->where(['Students.id' => $id])->first();
        }

        $findstu = $this->findridacademicre($id, $student['acedmicyear']);

        if ($findstu['id'] == '') {
            $detained = $this->gethistoryyearstudentinfo45($id);
        }

        $getHostalData = $this->HostelFeesManagement->find('all')
            ->where(['student_id' => $id, 'checkout_date IS NOT' => null])
            ->toArray();

        $asignHostel = $this->HostelFeesManagement->find('all')
            ->where(['student_id' => $id, 'checkout_date IS' => null])
            ->order(['HostelFeesManagement.id' => 'DESC'])
            ->first();
        $this->set('getHostalData', $getHostalData);
        $this->set('asignHostel', $asignHostel);

        $acedmicyear = $student['acedmicyear'];
        $acedmiclassid = $student["class_id"];
        $this->set('name', $student['fname'] . " " . $student['middlename'] . " " . $student['lname']);
        $this->set('enroll', $student['enroll']);
        $this->set('academic_year', $acedmicyear);
        $this->set('academic_class', $acedmiclassid);

        $hostalFeesHeads = $this->Feesheads->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->where(['type IN' => ['3'], 'id NOT IN' => [57, 12, 6]])->order(['sort' => 'ASC'])->toArray();
        $this->set('hostalFeesHeads', $hostalFeesHeads);

        if ($this->request->is(['post', 'put'])) {
            $formData = $this->request->data;
            // pr($formData);exit;

            if ($formData['submit'] == 'Check Out') {
                $editData = $this->HostelFeesManagement->get($formData['data_id']);
                if ($editData) {

                    $editData->checkout_date = date('Y-m-d');
                    $findstudent = $this->Students->get($editData->student_id);
                    $findstudent->is_hostel = null;
                    $this->Students->save($findstudent);
                    if ($this->HostelFeesManagement->save($editData)) {
                        $this->Flash->success(__('Check Out Successfully.'));
                    } else {
                        $this->Flash->error(__('Something Went Wrong Try Again.'));
                    }
                }
            } else {
                // pr($this->request->data);
                // echo "check in"; die;
                $req_data = [
                    'fees_head_id' => $formData['fees_head_id'],
                    'fee_head_name' => $formData['fee_head_name'],
                    'amount' => $formData['amount'],
                    'student_id' => $formData['studentId'],
                    'remarks' => $formData['remarks_lwt'],
                    'checkin_date' => date('Y-m-d'),
                ];

                // pr($req_data);exit;

                $newhostelDetails = $this->HostelFeesManagement->newEntity($req_data);
                if ($save = $this->HostelFeesManagement->save($newhostelDetails)) {
                    $findstudent = $this->Students->get($newhostelDetails->student_id);
                    $findstudent->is_hostel = $save['id'];
                    if ($this->Students->save($findstudent)) {
                        $this->Flash->success(__('Hostel Assign Successfully.'));
                    } else {
                        $this->Flash->error(__('Hostel Not Assign Something Error.'));
                    }
                }
            }
            return $this->redirect($this->referer());
        }
    }

    function find_hostal_fee()
    {
        $this->autoRender = false;
        $feeHeadId = $this->request->data['id'];
        $hostalFeeDetails = $this->Feesheads->find('all')->where(['id' => $feeHeadId])->first();
        if (!empty($hostalFeeDetails)) {
            echo $hostalFeeDetails['cbse_fee'];
        } else {
            echo 0;
        }
        // die;
    }

    //-----------------------------------------------------------------------------------------------------------------
    // role id to role name
    // public function drop()
    // {
    //     $this->viewBuilder()->layout('admin');
    //     $sitesettingdetail = $this->Sitesettings->find('all')->first();
    //     // For custom search form fields
    //     $sections = $this->Sections->find('all')->select(['id', 'title'])->where(['status' => 1])->order(['title' => 'ASC'])->toArray();
    //     $rolepresent = $this->request->session()->read('Auth.User.role_id');
    //     $db = $this->request->session()->read('Auth.User.db');
    //     if ($rolepresent == ADMIN || $rolepresent == CENTER_COORDINATOR || $rolepresent == BRANCH_HEAD) {
    //         $classes = $this->Classes->find('list', [
    //             'keyField' => 'id',
    //             'valueField' => 'title',
    //         ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
    //         $this->set('classes', $classes);
    //     } elseif ($rolepresent == CBSE_FEE_COORDINATOR) {
    //         $classes = $this->Classections->find('list', [
    //             'keyField' => 'Classes.id',
    //             'valueField' => 'Classes.title',
    //         ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
    //         $this->set('classes', $classes);
    //     } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
    //         $classes = $this->Classections->find('list', [
    //             'keyField' => 'Classes.id',
    //             'valueField' => 'Classes.title',
    //         ])->contain(['Classes'])->where(['Classes.status' => '1', 'Classes.board_id IN' => ALL_BOARDS])->order(['Classes.sort' => 'ASC'])->toArray();
    //         $this->set('classes', $classes);
    //     }
    //     // For view listing
    //     if ($rolepresent == CBSE_FEE_COORDINATOR) {
    //         $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->order(['DropOutStudent.dropcreated' => 'DESC'])->toarray();
    //     } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
    //         $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->order(['DropOutStudent.dropcreated' => 'DESC'])->toarray();
    //     } else {
    //         $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->order(['DropOutStudent.dropcreated' => 'DESC'])->toarray();
    //     }
    //     // pr($students); die;
    //     $get_managesettings = $this->getmanagesettings($db);
    //     $this->set(compact('sections', 'classes', 'students', 'sitesettingdetail', 'db', 'get_managesettings'));
    //     $this->request->session()->delete('conditionlps');
    //     $this->request->session()->write('conditionlps', $students);

    //     // for drop out student fees receipt
    //     // $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $students[0]['s_id'], 'Studentfees.status' => 'Y', 'Studentfees.deposite_amt !=' => '0', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
    //     // $i = 0;
    //     // $stu_his = $this->Studentshistory->find('all')->where(['stud_id' => $students[0]['s_id']])->toarray();
    //     // $i = 0;
    //     // foreach ($student_datask as $stu) {
    //     //     if ($stu['acedmicyear'] == $students[0]['acedmicyear']) {
    //     //         $student_datask[$i]['class'] = $this->classsection($students[0]['class_id'], $students[0]['section_id']);
    //     //     } else if (!empty($stu_his)) {
    //     //         foreach ($stu_his as $val) {

    //     //             if ($val['acedmicyear'] == $stu['acedmicyear']) {

    //     //                 $student_datask[$i]['class'] = $this->classsection($val['class_id'], $val['section_id']);
    //     //             }
    //     //         }
    //     //     }

    //     //     $i++;
    //     // }
    //     // $this->set('studentfeesk', $student_datask);
    // }



    public function drop()
    {
        $this->viewBuilder()->layout('admin');
        $sitesettingdetail = $this->Sitesettings->find('all')->first();
        // For custom search form fields


        $role_id = $this->request->session()->read('Auth.User.role_id');
        $user = $this->Users->find('all')->where(['Users.role_id' => 1])->first();
        $get_managesettings = $this->getmanagesettings($user['db']);
        $session = $this->request->session();
        $req_data = $_GET;
        $conn = ConnectionManager::get('default');
        $batch = $req_data['batch'];
        $fathername = $req_data['fathername'];
        $class = $req_data['class_id'];
        $created = date('Y-m-d', strtotime($req_data['created']));
        $section = $req_data['section_id'];
        $enroll = $req_data['enroll'];
        $fname = $req_data['fname'];
        $status_tc = $req_data['status_tc'];

        $conditions = [];
        if (!empty($batch)) {
            $conditions['DropOutStudent.batch'] = $batch;
        }
        if (!empty($class)) {
            $conditions['DropOutStudent.class_id IN'] = $class;
        }
        if (!empty($section)) {
            $conditions['DropOutStudent.section_id IN'] = $section;
        }
        if (!empty($enroll)) {
            $conditions['DropOutStudent.enroll LIKE'] = '%' . trim($enroll) . '%';
        }
        if (!empty($fname)) {
            $conditions['UPPER(DropOutStudent.fname) LIKE'] = '%' . trim(strtoupper($fname)) . '%';
        }

        if (!empty($fathername)) {
            $conditions['UPPER(DropOutStudent.fathername) LIKE'] = '%' . trim(strtoupper($fathername)) . '%';
        }
        if (!empty($status_tc)) {
            $conditions['DropOutStudent.status_tc LIKE'] = '%' . $status_tc . '%';
        }
        if (!empty($created) && $created != '1970-01-01') {
            $conditions['DropOutStudent.created LIKE'] = '%' . $created . '%';
        }
        $academic_session = $this->AcademicYear->find('list', ['keyField' => 'academicyear', 'valueField' => 'academicyear'])->order(['AcademicYear.id' => 'DESC'])->toArray();
        // pr($academic_session);exit;
        $this->set('academic_session', $academic_session);


        $session->delete('parentlogindata');
        $session->write('parentlogindata', $conditions);
        $query = $this->DropOutStudent->find()->contain(['Classes', 'Sections'])->where($conditions)->order(['DropOutStudent.id' => 'DESC']);



        $sections = $this->Sections->find('all')->select(['id', 'title'])->where(['status' => 1])->order(['title' => 'ASC'])->toArray();
        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        $db = $this->request->session()->read('Auth.User.db');
        if ($rolepresent == ADMIN || $rolepresent == CENTER_COORDINATOR || $rolepresent == BRANCH_HEAD) {
            $classes = $this->Classes->find('list', [
                'keyField' => 'id',
                'valueField' => 'title',
            ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        } elseif ($rolepresent == CBSE_FEE_COORDINATOR) {
            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1', 'Classes.board_id IN' => ALL_BOARDS])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        }
        // For view listing
        if (!empty($conditions)) {
            if ($rolepresent == CBSE_FEE_COORDINATOR) {
                $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where([$conditions])->order(['DropOutStudent.dropcreated' => 'DESC']);
            } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
                $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where([$conditions])->order(['DropOutStudent.dropcreated' => 'DESC']);
            } else {
                $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where([$conditions])->order(['DropOutStudent.dropcreated' => 'DESC']);
            }
        } else {
            if ($rolepresent == CBSE_FEE_COORDINATOR) {
                $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->order(['DropOutStudent.dropcreated' => 'DESC']);
            } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
                $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->order(['DropOutStudent.dropcreated' => 'DESC']);
            } else {
                $students = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->order(['DropOutStudent.dropcreated' => 'DESC']);
            }
        }

        // pr($students); die;
        $students = $this->paginate($query)->toarray();

        $get_managesettings = $this->getmanagesettings($db);
        $this->set(compact('sections', 'classes', 'students', 'sitesettingdetail', 'db', 'get_managesettings'));
        $this->request->session()->delete('conditionlps');
        $this->request->session()->write('conditionlps', $students);

        // for drop out student fees receipt
        // $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $students[0]['s_id'], 'Studentfees.status' => 'Y', 'Studentfees.deposite_amt !=' => '0', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
        // $i = 0;
        // $stu_his = $this->Studentshistory->find('all')->where(['stud_id' => $students[0]['s_id']])->toarray();
        // $i = 0;
        // foreach ($student_datask as $stu) {
        //     if ($stu['acedmicyear'] == $students[0]['acedmicyear']) {
        //         $student_datask[$i]['class'] = $this->classsection($students[0]['class_id'], $students[0]['section_id']);
        //     } else if (!empty($stu_his)) {
        //         foreach ($stu_his as $val) {

        //             if ($val['acedmicyear'] == $stu['acedmicyear']) {

        //                 $student_datask[$i]['class'] = $this->classsection($val['class_id'], $val['section_id']);
        //             }
        //         }
        //     }

        //     $i++;
        // }
        // $this->set('studentfeesk', $student_datask);
    }






    //-----------------------------------------------------------------------------------------------------------------
    // date_issue_bon
    // date_issue_char
    public function character_certificate_info($id = null)
    {
        if (!empty($id)) {
            $student = $this->DropOutStudent->get($id);
            $this->set(compact('student'));
        }
        if ($this->request->is(['post', 'put'])) {
            $req_data = $this->request->data;
            $sid = $req_data['s_id'];
            $req_data['date_issue_char'] = date('Y-m-d');
            $student = $this->DropOutStudent->patchEntity($student, $req_data);
            if ($this->DropOutStudent->save($student)) {
                return $this->redirect(['action' => 'character_certificate_pdf/' . $sid]);
            } else {
                //check validation error
                if ($student->errors()) {
                    $error_msg = [];
                    foreach ($student->errors() as $errors) {
                        if (is_array($errors)) {
                            foreach ($errors as $error) {
                                $error_msg[] = $error;
                            }
                        } else {
                            $error_msg[] = $errors;
                        }
                    }
                    if (!empty($error_msg)) {
                        $this->Flash->error(__("Please fix the following error(s): " . implode("\n \r", $error_msg)));
                    }
                }
            }
        }
    }
    // approvel for canvas main branch 
    public function tc_approval($id = null)
    {
        $db = $this->request->session()->read('Auth.User.db');
        if (!empty($id)) {
            $student = $this->DropOutStudent->get($id);
            $this->set(compact('student'));
        }
        if ($this->request->is(['post', 'put'])) {
            $connection_true = $this->connection("canvas");
            $req_data['request_status'] = 'Y';
            $students = $this->DropOutStudent->patchEntity($student, $req_data);
            $this->DropOutStudent->save($students);
            $fullname = $student['fname'] . ' ' . $student['middlename'] . ' ' . $student['lname'];
            $find_student = $this->CertificatesApproval->find('all')->where(['CertificatesApproval.sname' => $full_name, 'CertificatesApproval.enroll' => $student['enroll']])->first();
            if (!empty($find_student)) {
                $this->Flash->error(__("You have already send Head Branch request for approval"));
                return $this->redirect(['action' => 'drop']);
            } else {
                $req_data = $this->CertificatesApproval->newEntity();
            }
            $all_data['description'] = $this->request->data['description'];
            $all_data['enroll'] = $student['enroll'];
            $all_data['class_id'] = $student['class_id'];
            $all_data['section_id'] = $student['section_id'];
            $all_data['dob'] = date('Y-m-d', strtotime($student['dob']));
            $all_data['sname'] = $student['fname'] . ' ' . $student['middlename'] . ' ' . $student['lname'];
            $all_data['school_name'] = $db;
            $student = $this->CertificatesApproval->patchEntity($req_data, $all_data);
            if ($this->CertificatesApproval->save($student)) {
                $this->Flash->success(__("Request has been send Head Branch for approval process"));
                return $this->redirect(['action' => 'drop']);
            } else {
                //check validation error
                if ($student->errors()) {
                    $error_msg = [];
                    foreach ($student->errors() as $errors) {
                        if (is_array($errors)) {
                            foreach ($errors as $error) {
                                $error_msg[] = $error;
                            }
                        } else {
                            $error_msg[] = $errors;
                        }
                    }
                    if (!empty($error_msg)) {
                        $this->Flash->error(__("Please fix the following error(s): " . implode("\n \r", $error_msg)));
                    }
                }
            }
        }
    }

    // approvel for palaceschool
    public function no_objection_approval($id = null)
    {
        $db = $this->request->session()->read('Auth.User.db');
        if (!empty($id)) {
            $student = $this->DropOutStudent->get($id);
            $this->set(compact('student'));
        }
        if ($this->request->is(['post', 'put'])) {
            $req_data = $this->request->data;
            $student['reason'] = ucwords(strtolower($req_data['reason']));
            $student['from_date'] = $req_data['from_date'];
            $student['to_date'] = $req_data['to_date'];
            if ($this->DropOutStudent->save($student)) {
                $this->Flash->success(__("Details has been submit You can Download Certificate"));
                return $this->redirect(['action' => 'drop']);
            } else {
                //check validation error
                if ($student->errors()) {
                    $error_msg = [];

                    foreach ($student->errors() as $errors) {
                        if (is_array($errors)) {
                            foreach ($errors as $error) {
                                $error_msg[] = $error;
                            }
                        } else {
                            $error_msg[] = $errors;
                        }
                    }

                    if (!empty($error_msg)) {
                        $this->Flash->error(__("Please fix the following error(s): " . implode("\n \r", $error_msg)));
                    }
                }
            }
        }
    }
    // refine done
    public function certification_approval()
    {
        $this->viewBuilder()->layout('admin');
        $student_data = $this->CertificatesApproval->find('all')->order(['CertificatesApproval.created' => 'DESC'])->toarray();
        $classes = $this->Classes->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $this->set('students', $student_data);
        $this->set('classes', $classes);
    }

    // refine done
    public function Approval($id)
    {
        $certificate_details = $this->CertificatesApproval->get($id);
        $req_data['status'] = 'Y';
        $students = $this->CertificatesApproval->patchEntity($certificate_details, $req_data);
        $check = $this->CertificatesApproval->save($students);
        if (!empty($check['id'])) {
            $this->connection(trim($check['school_name']));
            $db = trim($check['school_name']);
            $enroll = trim($check['enroll']);
            $conn = ConnectionManager::get('default');
            $Dropst_update = "UPDATE $db.`drop_out_students` SET `status_tc`='Y' WHERE `enroll`='$enroll'";
            $conn->execute($Dropst_update);
            $this->Flash->success(__("Approval Accepted"));
            return $this->redirect(['action' => 'certification_approval']);
        } else {
            $this->Flash->error(__("Something Error Please Try Some time !"));
            return $this->redirect(['action' => 'certification_approval']);
        }
    }
    // refine done
    public function drop_out_approval($id)
    {
        $certificate_details = $this->DropoutApproval->get($id);
        $req_data['status'] = 'Y';
        $students = $this->DropoutApproval->patchEntity($certificate_details, $req_data);;
        if ($this->DropoutApproval->save($students)) {
            $this->connection(trim($certificate_details['school_name']));
            $db = trim($certificate_details['school_name']);
            $student_id = trim($certificate_details['student_id']);
            $conn = ConnectionManager::get('default');
            $Dropst_update = "UPDATE $db.`students` SET `request_for_drop`='accepted' WHERE `id`='$student_id'";
            $conn->execute($Dropst_update);
            $this->Flash->success(__("Approval Accepted For " . $certificate_details['sname'] . ' where School ' . ucfirst($certificate_details['school_name'])));
            return $this->redirect(['action' => 'dropout_approval']);
        } else {
            $this->Flash->error(__("Something Error Please Try Some time !"));
            return $this->redirect(['action' => 'dropout_approval']);
        }
    }
    // role id to role name
    // refine done
    public function transfer_certificate_info($id = null, $s_id = null)
    {
        if (!empty($id)) {
            $student = $this->DropOutStudent->get($id);
            $classid = $student['class_id'];
        }
        $user = $this->Users->find('all')->where(['Users.role_id' => ADMIN])->first();
        $rolepresentyear = $user['academic_year'];
        $acd = $this->academicyear();

        $db = $user['db'];
        $this->set(compact('rolepresentyear', 'tc_exists'));
        $this->set(compact('acd'));
        $this->set(compact('db'));
        $classes = $this->Classections->find('all')->select(['id'])->where(['class_id' => $classid])->group(['Classections.class_id'])->toArray();

        $classes = $this->Classections->find('list', [
            'keyField' => 'Classes.id',
            'valueField' => 'Classes.title',
        ])->select(['Classections.id', 'Classections.class_id', 'Classes.id', 'Classes.title'])->contain(['Classes'])->where(['Classections.id >' => $classes[0]['id'], 'Classections.class_id NOT IN' => [$classid]])->group(['Classections.class_id'])->order(['Classes.sort' => 'ASC'])->toArray();

        $classes2 = $this->Classections->find('list', [
            'keyField' => 'Classes.id',
            'valueField' => 'Classes.title',
        ])->select(['Classections.id', 'Classections.class_id', 'Classes.id', 'Classes.title'])->contain(['Classes'])->group(['Classections.class_id'])->order(['Classes.sort' => 'ASC'])->toArray();

        $admissionclass = $this->AdmissionClasses->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->order(['sort' => 'ASC'])->toArray();
        $this->set(compact('student', 'classes', 'classes2', 'admissionclass'));
        if ($this->request->is(['post', 'put'])) {
            $req_data = $this->request->data;
            $req_data['tcsubject'] = implode(',', $req_data['tcsubject']);
            $req_data['date_issue'] = $req_data['date_issue']['year'] . "-" . $req_data['date_issue']['month'] . "-" . $req_data['date_issue']['day'];
            $req_data['date_application'] = $req_data['date_application']['year'] . "-" . $req_data['date_application']['month'] . "-" . $req_data['date_application']['day'];
            $req_data['admissiondate'] = $req_data['admissiondate']['year'] . "-" . $req_data['admissiondate']['month'] . "-" . $req_data['admissiondate']['day'] . " 00:00:00";
            $student = $this->DropOutStudent->patchEntity($student, $req_data);
            if ($this->DropOutStudent->save($student)) {
                return $this->redirect(['action' => 'transfer_certificate_pdf/' . $s_id]);
            } else {
                //check validation error
                if ($student->errors()) {
                    $error_msg = [];
                    foreach ($student->errors() as $errors) {
                        if (is_array($errors)) {
                            foreach ($errors as $error) {
                                $error_msg[] = $error;
                            }
                        } else {
                            $error_msg[] = $errors;
                        }
                    }
                    if (!empty($error_msg)) {
                        $this->Flash->error(__("Please fix the following error(s): " . implode("\n \r", $error_msg)));
                    }
                }
            }
        }
    }

    //-----------------------------------------------------------------------------------------------------------------
    // role id to role name
    // refine done
    public function transfer_certificate_pdf($s_id = null)
    {
        $this->sitesetting('tc');
        $student = $this->DropOutStudent->find('all')->contain(['Sections', 'Classes'])
            ->where(['DropOutStudent.s_id' => $s_id])->first()->toArray();
        $this->set(compact('student'));
        $user = $this->Users->find('all')->where(['Users.role_id' => ADMIN])->first();
        $dobWords = $this->dob(date('Y-m-d', strtotime($student['dob'])));
        $this->set(compact('dobWords'));
        $db = $user['db'];
        $this->set('db');
        $select = $student['comp_sid'];
        if ($student['laststudclass']) {
            $class_id = $student['laststudclass'];
        } else {
            $class_id = $student['class_id'];
        }
        $class_detail = $this->Classes->find('all')->where(['id' => $class_id])->first();
        if (in_array($class_detail['class_no'], ["11", "12"])) {
            if (!empty($select)) {
                $this->set('selected', $select);
            }
            $select1 = $student['opt_sid'];
            if (!empty($select1)) {
                $this->set('select1', $select1);
            }
        }
        $adminUser = $this->Users->find()->where(['role_id' => ADMIN])->first();
        if (!empty($adminUser['tc_template'])) {
            $this->render($adminUser['tc_template']);
        }
    }

    public function dob($date = null)
    {
        function numberTowords($num)
        {

            $ones = array(
                0 => "ZERO",
                1 => "ONE",
                2 => "TWO",
                3 => "THREE",
                4 => "FOUR",
                5 => "FIVE",
                6 => "SIX",
                7 => "SEVEN",
                8 => "EIGHT",
                9 => "NINE",
                10 => "TEN",
                11 => "ELEVEN",
                12 => "TWELVE",
                13 => "THIRTEEN",
                14 => "FOURTEEN",
                15 => "FIFTEEN",
                16 => "SIXTEEN",
                17 => "SEVENTEEN",
                18 => "EIGHTEEN",
                19 => "NINETEEN",
                "014" => "FOURTEEN",
            );
            $tens = array(
                0 => "ZERO",
                1 => "TEN",
                2 => "TWENTY",
                3 => "THIRTY",
                4 => "FORTY",
                5 => "FIFTY",
                6 => "SIXTY",
                7 => "SEVENTY",
                8 => "EIGHTY",
                9 => "NINETY",
            );
            $hundreds = array(
                "HUNDRED",
                "THOUSAND",
                "MILLION",
                "BILLION",
                "TRILLION",
                "QUARDRILLION",
            ); /* limit t quadrillion */
            $num = number_format($num, 2, ".", ",");
            $num_arr = explode(".", $num);
            $wholenum = $num_arr[0];
            $decnum = $num_arr[1];
            $whole_arr = array_reverse(explode(",", $wholenum));
            krsort($whole_arr, 1);
            $rettxt = "";
            foreach ($whole_arr as $key => $i) {
                while (substr($i, 0, 1) == "0") {
                    $i = substr($i, 1, 5);
                }
                if ($i < 20) {
                    /* echo "getting:".$i; */
                    $rettxt .= $ones[$i];
                } elseif ($i < 100) {
                    if (substr($i, 0, 1) != "0") {
                        $rettxt .= $tens[substr($i, 0, 1)];
                    }
                    if (substr($i, 1, 1) != "0") {
                        $rettxt .= " " . $ones[substr($i, 1, 1)];
                    }
                } else {
                    if (substr($i, 0, 1) != "0") {
                        $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                    }
                    if (substr($i, 1, 1) != "0") {
                        $rettxt .= " " . $tens[substr($i, 1, 1)];
                    }
                    if (substr($i, 2, 1) != "0") {
                        $rettxt .= " " . $ones[substr($i, 2, 1)];
                    }
                }
                if ($key > 0) {
                    $rettxt .= " " . $hundreds[$key] . " ";
                }
            }
            if ($decnum > 0) {
                $rettxt .= " and ";
                if ($decnum < 20) {
                    $rettxt .= $ones[$decnum];
                } elseif ($decnum < 100) {
                    $rettxt .= $tens[substr($decnum, 0, 1)];
                    $rettxt .= " " . $ones[substr($decnum, 1, 1)];
                }
            }
            return $rettxt;
        }
        $birth_date = $date;
        $new_birth_date = explode('-', $birth_date);
        $year = $new_birth_date[0];
        $month = $new_birth_date[1];
        $day = $new_birth_date[2];
        $birth_day = numberTowords($day);
        $birth_year = numberTowords($year);
        $monthNum = $month;
        $dateObj = new \DateTime;
        $dateObj = $dateObj->createFromFormat('!m', $monthNum); //Convert the number into month name
        $monthName = strtoupper($dateObj->format('F'));
        return $birth_day . ' ' . $monthName . ' ' . $birth_year;
    }

    //-----------------------------------------------------------------------------------------------------------------
    //refine done
    public function bonafide_certificate_pdf($id = null)
    {
        $this->sitesetting('general');
        $student = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where(['DropOutStudent.id' => $id])->first()->toArray();
        $dbname = $this->request->session()->read('Auth.User.db');
        $this->set(compact('student', 'dbname'));
    }

    public function no_objection_certificate_pdf($id = null)
    {
        $this->sitesetting('general');
        $student = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where(['DropOutStudent.id' => $id])->first()->toArray();
        $dbname = $this->request->session()->read('Auth.User.db');
        $this->set(compact('student', 'dbname'));
    }

    // role id to role name and refine code done
    public function character_certificate_pdf($s_id = null)
    {
        $this->sitesetting('general');
        $student = $this->DropOutStudent->find('all')->contain(['Classes', 'Sections'])->where(['DropOutStudent.s_id' => $s_id])->first()->toArray();
        $this->set(compact('student'));
        $user = $this->Users->find('all')->where(['Users.role_id' => ADMIN])->first();
        $db = $user['db'];
        if ($db == "kidsclub") {
            $this->render('kidsclub_chararacter_cert_pdf');
        }
    }

    //-----------------------------------------------------------------------------------------------------------------
    // refine done
    // public function drop_out_student_search()
    // {
    //     $req_data = $_GET;
    //     $conn = ConnectionManager::get('default');
    //     $fathername = $req_data['fathername'];
    //     $class = $req_data['class_id'];
    //     $created = date('Y-m-d', strtotime($req_data['created']));
    //     $section = $req_data['section_id'];
    //     $enroll = $req_data['enroll'];
    //     $fname = $req_data['fname'];
    //     $status_tc = $req_data['status_tc'];

    //     $detail = "SELECT DropOutStudent.id,DropOutStudent.created,DropOutStudent.remarks_lwt,DropOutStudent.laststudclass,DropOutStudent.updateacedemic,DropOutStudent.school_lastresult,DropOutStudent.s_id,DropOutStudent.status_tc,DropOutStudent.fathername,DropOutStudent.enroll,DropOutStudent.fname,DropOutStudent.middlename,DropOutStudent.lname,DropOutStudent.mobile,DropOutStudent.acedmicyear,DropOutStudent.class_id,DropOutStudent.sms_mobile,
    // 	DropOutStudent.section_id, DropOutStudent.status,  Classes.title as classtitle , Sections.title as sectiontitle
    // 	FROM `drop_out_students` DropOutStudent LEFT JOIN classes Classes ON DropOutStudent.`class_id` = Classes.id
    // 	LEFT JOIN sections Sections ON DropOutStudent.`section_id` = Sections.id WHERE  1=1 ";

    //     $cond = ' ';

    //     if (!empty($class)) {
    //         $cond .= " AND DropOutStudent.class_id LIKE '" . $class . "'";
    //     }
    //     if (!empty($created) && $created != '1970-01-01') {
    //         $cond .= " AND DropOutStudent.created LIKE '" . $created . " %'";
    //     }

    //     if (!empty($section)) {
    //         $cond .= " AND DropOutStudent.section_id LIKE '" . $section . "'";
    //     }

    //     if (!empty($enroll)) {
    //         $cond .= " AND DropOutStudent.enroll LIKE '%" . $enroll . "%' ";
    //     }
    //     if (!empty($status_tc)) {
    //         $cond .= " AND DropOutStudent.status_tc LIKE '%" . $status_tc . "' ";
    //     }

    //     if (!empty($fname)) {
    //         $cond .= " AND UPPER(DropOutStudent.fname) LIKE '%" . strtoupper($fname) . "%' ";
    //     }
    //     if (!empty($fathername)) {
    //         $cond .= " AND UPPER(DropOutStudent.fathername) LIKE '%" . strtoupper($fathername) . "%'";
    //     }
    //     $detail = $detail . $cond;
    //     $SQL = $detail . " ORDER BY DropOutStudent.id DESC";
    //     $results = $conn->execute($SQL)->fetchAll('assoc');

    //     // for drop out student fees receipt
    //     $student_datask = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $results[0]['s_id'], 'Studentfees.status' => 'Y', 'Studentfees.deposite_amt !=' => '0', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
    //     $i = 0;
    //     $stu_his = $this->Studentshistory->find('all')->where(['stud_id' => $results[0]['s_id']])->toarray();
    //     $i = 0;
    //     foreach ($student_datask as $stu) {
    //         if ($stu['acedmicyear'] == $results[0]['acedmicyear']) {
    //             $student_datask[$i]['class'] = $this->classsection($results[0]['class_id'], $results[0]['section_id']);
    //         } else if (!empty($stu_his)) {
    //             foreach ($stu_his as $val) {

    //                 if ($val['acedmicyear'] == $stu['acedmicyear']) {

    //                     $student_datask[$i]['class'] = $this->classsection($val['class_id'], $val['section_id']);
    //                 }
    //             }
    //         }

    //         $i++;
    //     }
    //     // $student_data = $this->paginate($student_data)->toarray();
    //     $this->set('studentfeesk', $student_datask);
    //     $this->set('students', $results);
    // }


    public function classsection($class = null, $section = null)
    {

        $class_det = $this->Classes->find()->select('title')->where(['id' => $class])->first();

        $sec_det = $this->Sections->find()->select('title')->where(['id' => $section])->first();
        $det = $class_det->title . "-" . $sec_det->title;

        return $det;
    }


    public function summaryprospectusreport($board = null, $m = null, $date = null)
    {
        $this->viewBuilder()->layout('admin');
        $this->set(compact('date'));
        if ($board == 'cbse') {
            $prospectussummary = $this->Enquires->find('all')->where(['DATE(Enquires.created)' => $date, 'Enquires.recipietno !=' => '0', 'Enquires.mode1_id' => $m, 'Enquires.status' => 'Y'])->order(['Enquires.created' => 'ASC'])->toarray();
        } elseif ($board == 'int') {

            $prospectussummary = $this->Enquires->find('all')->where(['DATE(Enquires.created)' => $date, 'Enquires.recipietno !=' => '0', 'Enquires.mode1_id !=' => $m, 'Enquires.status' => 'Y'])->order(['Enquires.created' => 'ASC'])->toarray();
        } elseif ($board == 'total') {

            $prospectussummary = $this->Enquires->find('all')->where(['DATE(Enquires.created)' => $date, 'Enquires.recipietno !=' => '0', 'Enquires.status' => 'Y'])->order(['Enquires.created' => 'ASC'])->toarray();
        }
        $this->set(compact('prospectussummary'));
    }

    public function findregistrationtudentsdetail($m = null, $date = null)
    {
        $this->viewBuilder()->layout('admin');
        $date1 = date('Y-m-d');
        $this->set(compact('date1'));
        if ($m == '1') {
            $registrationsummary = $this->Applicant->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.recipietno !=' => '0', 'Applicant.status_c' => 'Y', 'Enquires.mode1_id' => $m])->toarray();
            //pr($registrationsummary); die;
        } elseif ($m == '2') {

            $registrationsummary = $this->Applicant->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.recipietno !=' => '0', 'Applicant.status_c' => 'Y', 'Enquires.mode1_id !=' => 1])->toarray();
        }
        $this->set(compact('registrationsummary'));
    }
    // role id to role name
    public function findacedemicsummary2($class = null, $acedmic = null, $from = null, $to = null, $classcollection = null)
    {
        $this->viewBuilder()->layout('admin');
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $currentyear = $users['academic_year'];
        $apk = array();
        $apk1 = array();
        if ($classcollection) {
            $classs = base64_decode($classcollection);
            $css = explode(',', $classs);
            $stts = array('Students.created >=' => $from);
            $apk[] = $stts;
            $stts = array('Students.created <=' => $to);
            $apk[] = $stts;
            $stts = array('Students.class_id IN' => $css);
            $apk[] = $stts;
            $stts = array('Students.category' => 'Migration');
            $apk[] = $stts;
            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;
            $stts = array('Students.status' => 'N');
            $apk[] = $stts;

            $registrationsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();

            $this->set(compact('registrationsummary'));
        } elseif ($class != 0) {

            $stts = array('Students.created >=' => $from);
            $apk[] = $stts;

            $stts = array('Students.created <=' => $to);
            $apk[] = $stts;

            $stts = array('Students.class_id' => $class);
            $apk[] = $stts;

            $stts = array('Students.category' => 'Migration');
            $apk[] = $stts;

            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;
            $stts = array('Students.status' => 'N');
            $apk[] = $stts;

            $registrationsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();

            $this->set(compact('registrationsummary'));
        } else {

            $rolepresent = $this->request->session()->read('Auth.User.role_id');

            // if ($rolepresent == CBSE_FEE_COORDINATOR) {
            //     $stts = array('Students.board_id' => CBSE);
            //     $apk[] = $stts;
            // } else {
            //     $stts = array('Students.board_id !=' => CBSE);
            //     $apk[] = $stts;
            // }

            $stts = array('Students.created >=' => $from);
            $apk[] = $stts;

            $stts = array('Students.created <=' => $to);
            $apk[] = $stts;

            $stts = array('Students.category' => 'Migration');
            $apk[] = $stts;

            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;
            $stts = array('Students.status' => 'N');
            $apk[] = $stts;

            $registrationsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();

            $this->set(compact('registrationsummary'));
        }
    }
    // role id to role name
    public function findacedemicsummary3($class = null, $acedmic = null, $from = null, $to = null, $classcollection = null)
    {
        $this->viewBuilder()->layout('admin');
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $currentyear = $users['academic_year'];
        $apk = array();
        $apk1 = array();
        if ($classcollection) {

            $classs = base64_decode($classcollection);

            $css = explode(',', $classs);

            $rolepresent = $this->request->session()->read('Auth.User.role_id');

            if ($rolepresent == CBSE_FEE_COORDINATOR) {
                $stts = array('Students.board_id !=' => 1);
                $apk[] = $stts;
            } else {

                $stts = array('Students.board_id' => 1);
                $apk[] = $stts;
            }

            $stts = array('Students.created >=' => $from);
            $apk[] = $stts;

            $stts = array('Students.created <=' => $to);
            $apk[] = $stts;

            $stts = array('Students.category' => 'Migration');
            $apk[] = $stts;

            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;
            $stts = array('Students.status' => 'N');
            $apk[] = $stts;

            $articles = TableRegistry::get('Students');
            $ddd = $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();

            $cnust = array();

            foreach ($ddd as $k => $kki) {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $articles3 = TableRegistry::get('Students')->find('all')->where(['Students.oldenroll' => $kki['enroll'], 'Students.class_id IN' => $css, 'Students.admissionyear' => $acedmic])->order(['Students.id' => 'ASC'])->first();
                } elseif ($acedmic != $currentyear) {

                    $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['oldenroll' => $kki['enroll'], 'class_id IN' => $css, 'admissionyear' => $acedmic])->order(['id' => 'ASC'])->first();
                } else {
                    $articles3 = TableRegistry::get('Students')->find('all')->where(['Students.oldenroll' => $kki['enroll'], 'Students.class_id IN' => $css, 'Students.admissionyear' => $acedmic])->order(['Students.id' => 'ASC'])->first();
                }
                if ($articles3['id']) {
                    $cnust[] = $articles3['id'];
                } else {
                }
            }

            if ($cnust) {
                $registrationsummary = $this->Students->find('all')->where(['Students.id IN' => $cnust])->order(['Students.id' => 'ASC'])->toarray();
            }
            $this->set(compact('registrationsummary'));
        } elseif ($class != 0) {

            $rolepresent = $this->request->session()->read('Auth.User.role_id');

            if ($rolepresent == CBSE_FEE_COORDINATOR) {
                $stts = array('Students.board_id !=' => 1);
                $apk[] = $stts;
            } else {

                $stts = array('Students.board_id' => 1);
                $apk[] = $stts;
            }

            $stts = array('Students.created >=' => $from);
            $apk[] = $stts;

            $stts = array('Students.created <=' => $to);
            $apk[] = $stts;

            $stts = array('Students.category' => 'Migration');
            $apk[] = $stts;

            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;
            $stts = array('Students.status' => 'N');
            $apk[] = $stts;

            $articles = TableRegistry::get('Students');
            $ddd = $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();

            $cnust = array();

            foreach ($ddd as $k => $kki) {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $articles3 = TableRegistry::get('Students')->find('all')->where(['Students.oldenroll' => $kki['enroll'], 'Students.class_id' => $class, 'Students.admissionyear' => $acedmic])->order(['Students.id' => 'ASC'])->first();
                } elseif ($acedmic != $currentyear) {

                    $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['oldenroll' => $kki['enroll'], 'class_id' => $class, 'admissionyear' => $acedmic])->order(['id' => 'ASC'])->first();
                } else {
                    $articles3 = TableRegistry::get('Students')->find('all')->where(['Students.oldenroll' => $kki['enroll'], 'Students.class_id' => $class, 'Students.admissionyear' => $acedmic])->order(['Students.id' => 'ASC'])->first();
                }
                if ($articles3['id']) {
                    $cnust[] = $articles3['id'];
                } else {
                }
            }

            if ($cnust) {
                $registrationsummary = $this->Students->find('all')->where(['Students.id IN' => $cnust])->order(['Students.id' => 'ASC'])->toarray();
            }
            $this->set(compact('registrationsummary'));
        } else {
            $rolepresent = $this->request->session()->read('Auth.User.role_id');

            // if ($rolepresent == CBSE_FEE_COORDINATOR) {
            //     $stts = array('Students.board_id !=' => CBSE);
            //     $apk[] = $stts;
            // } else {

            //     $stts = array('Students.board_id' => CBSE);
            //     $apk[] = $stts;
            // }

            $stts = array('Students.created >=' => $from);
            $apk[] = $stts;

            $stts = array('Students.created <=' => $to);
            $apk[] = $stts;

            $stts = array('Students.category' => 'Migration');
            $apk[] = $stts;

            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;
            $stts = array('Students.status' => 'N');
            $apk[] = $stts;

            $articles = TableRegistry::get('Students');
            $ddd = $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();

            $cnust = array();

            foreach ($ddd as $k => $kki) {

                $articles3 = TableRegistry::get('Students')->find('all')->where(['Students.oldenroll' => $kki['enroll'], 'Students.admissionyear' => $acedmic])->order(['Students.id' => 'ASC'])->first();
                if ($articles3['id']) {
                    $cnust[] = $articles3['id'];
                } else {
                }
            }

            $registrationsummary = $this->Students->find('all')->where(['Students.id IN' => $cnust])->order(['Students.id' => 'ASC'])->toarray();

            $this->set(compact('registrationsummary'));
        }
    }
    // role id to role name
    public function findacedemicsummary($class = null, $acedmic = null, $from = null, $to = null, $classcollection = null)
    {
        $this->viewBuilder()->layout('admin');
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $currentyear = $users['academic_year'];
        $apk = array();
        $apk1 = array();
        if ($classcollection) {

            $classs = base64_decode($classcollection);

            $css = explode(',', $classs);

            $next_academic_year = $users['next_academic_year'];
            if ($currentyear == $acedmic) {

                $stts = array('Students.created >=' => $from);
                $apk[] = $stts;

                $stts = array('Students.created <=' => $to);
                $apk[] = $stts;
                $stts = array('Students.class_id IN' => $css);
                $apk[] = $stts;

                $stts = array('Students.admissionyear' => $acedmic);
                $apk[] = $stts;

                $stts = array('Students.category !=' => 'RTE');
                $apk[] = $stts;

                $stts = array('Students.oldenroll' => '0');
                $apk[] = $stts;

                $admissionsummary = $this->Students->find('all')->where($apk)->order(['DATE(Students.created)' => 'ASC'])->toarray();
            } elseif ($acedmic != $currentyear) {

                $stts = array('Studentshistory.created >=' => $from);
                $apk[] = $stts;

                $stts = array('Studentshistory.created <=' => $to);
                $apk[] = $stts;

                $stts = array('Students.class_id IN' => $css);
                $apk[] = $stts;

                $stts = array('Studentshistory.admissionyear' => $acedmic);
                $apk[] = $stts;

                $stts = array('Studentshistory.category !=' => 'RTE');
                $apk[] = $stts;

                $stts = array('Studentshistory.oldenroll' => '0');
                $apk[] = $stts;

                $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['DATE(Studentshistory.created)' => 'ASC'])->toarray();
            } else {

                $stts = array('Students.created >=' => $from);
                $apk[] = $stts;

                $stts = array('Students.created <=' => $to);
                $apk[] = $stts;
                $stts = array('Students.class_id IN' => $css);
                $apk[] = $stts;

                $stts = array('Students.admissionyear' => $acedmic);
                $apk[] = $stts;

                $stts = array('Students.category !=' => 'RTE');
                $apk[] = $stts;

                $stts = array('Students.oldenroll' => '0');
                $apk[] = $stts;

                $admissionsummary = $this->Students->find('all')->where($apk)->order(['DATE(Students.created)' => 'ASC'])->toarray();
            }

            $registrationsummary = $admissionsummary;

            $this->set(compact('registrationsummary'));
        } elseif ($class != 0) {

            $next_academic_year = $users['next_academic_year'];
            if ($currentyear == $acedmic) {

                $stts = array('Students.created >=' => $from);
                $apk[] = $stts;

                $stts = array('Students.created <=' => $to);
                $apk[] = $stts;
                $stts = array('Students.class_id' => $class);
                $apk[] = $stts;

                $stts = array('Students.admissionyear' => $acedmic);
                $apk[] = $stts;

                $stts = array('Students.category !=' => 'RTE');
                $apk[] = $stts;

                $stts = array('Students.oldenroll' => '0');
                $apk[] = $stts;

                $admissionsummary = $this->Students->find('all')->where($apk)->order(['DATE(Students.created)' => 'ASC'])->toarray();
            } elseif ($acedmic != $currentyear) {

                $stts = array('Studentshistory.created >=' => $from);
                $apk[] = $stts;

                $stts = array('Studentshistory.created <=' => $to);
                $apk[] = $stts;

                $stts = array('Studentshistory.class_id' => $class);
                $apk[] = $stts;

                $stts = array('Studentshistory.admissionyear' => $acedmic);
                $apk[] = $stts;

                $stts = array('Studentshistory.category !=' => 'RTE');
                $apk[] = $stts;

                $stts = array('Studentshistory.oldenroll' => '0');
                $apk[] = $stts;

                $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['DATE(Studentshistory.created)' => 'ASC'])->toarray();
            } else {

                $stts = array('Students.created >=' => $from);
                $apk[] = $stts;

                $stts = array('Students.created <=' => $to);
                $apk[] = $stts;
                $stts = array('Students.class_id' => $class);
                $apk[] = $stts;

                $stts = array('Students.admissionyear' => $acedmic);
                $apk[] = $stts;

                $stts = array('Students.category !=' => 'RTE');
                $apk[] = $stts;

                $stts = array('Students.oldenroll' => '0');
                $apk[] = $stts;

                $admissionsummary = $this->Students->find('all')->where($apk)->order(['DATE(Students.created)' => 'ASC'])->toarray();
            }

            $registrationsummary = $admissionsummary;

            $this->set(compact('registrationsummary'));
        } else {
            $rolepresent = $this->request->session()->read('Auth.User.role_id');

            if ($rolepresent == CBSE_FEE_COORDINATOR) {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('Students.created >=' => $from);
                    $apk[] = $stts;

                    $stts = array('Students.created <=' => $to);
                    $apk[] = $stts;
                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Students.category !=' => 'RTE');
                    $apk[] = $stts;

                    $stts = array('Students.oldenroll' => '0');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('Studentshistory.created >=' => $from);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.created <=' => $to);
                    $apk[] = $stts;
                    $stts = array('Studentshistory.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.category !=' => 'RTE');
                    $apk[] = $stts;

                    $stts = array('Studentshistory.oldenroll' => '0');
                    $apk[] = $stts;

                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->toarray();
                } else {

                    $stts = array('Students.created >=' => $from);
                    $apk[] = $stts;

                    $stts = array('Students.created <=' => $to);
                    $apk[] = $stts;
                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Students.category !=' => 'RTE');
                    $apk[] = $stts;

                    $stts = array('Students.oldenroll' => '0');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                }

                $registrationsummary = $admissionsummary;

                $this->set(compact('registrationsummary'));
            } elseif ($rolepresent == '8') {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('Students.created >=' => $from);
                    $apk[] = $stts;

                    $stts = array('Students.created <=' => $to);
                    $apk[] = $stts;
                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.category !=' => 'RTE');
                    $apk[] = $stts;

                    $stts = array('Students.oldenroll' => '0');
                    $apk[] = $stts;

                    $stts = array('Students.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('Studentshistory.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;
                    $stts = array('Studentshistory.created >=' => $from);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.created <=' => $to);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.category !=' => 'RTE');
                    $apk[] = $stts;

                    $stts = array('Studentshistory.oldenroll' => '0');
                    $apk[] = $stts;

                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->toarray();
                } else {

                    $stts = array('Students.created >=' => $from);
                    $apk[] = $stts;

                    $stts = array('Students.created <=' => $to);
                    $apk[] = $stts;
                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.category !=' => 'RTE');
                    $apk[] = $stts;

                    $stts = array('Students.oldenroll' => '0');
                    $apk[] = $stts;

                    $stts = array('Students.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                }

                $registrationsummary = $admissionsummary;

                $this->set(compact('registrationsummary'));
            }
        }
    }
    // role id to role name
    public function findacedemicsummaryrte($class = null, $acedmic = null, $from = null, $to = null, $classcollection = null)
    {
        $this->viewBuilder()->layout('admin');
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $currentyear = $users['academic_year'];
        $apk = array();
        $apk1 = array();
        if ($classcollection) {

            $classs = base64_decode($classcollection);

            $css = explode(',', $classs);

            $next_academic_year = $users['next_academic_year'];
            if ($currentyear == $acedmic) {

                $stts = array('Students.created >=' => $from);
                $apk[] = $stts;

                $stts = array('Students.created <=' => $to);
                $apk[] = $stts;
                $stts = array('Students.class_id IN' => $css);
                $apk[] = $stts;

                $stts = array('Students.admissionyear' => $acedmic);
                $apk[] = $stts;

                $stts = array('Students.category' => 'RTE');
                $apk[] = $stts;

                $stts = array('Students.oldenroll' => '0');
                $apk[] = $stts;

                $admissionsummary = $this->Students->find('all')->where($apk)->order(['DATE(Students.created)' => 'ASC'])->toarray();
            } elseif ($acedmic != $currentyear) {

                $stts = array('Studentshistory.created >=' => $from);
                $apk[] = $stts;

                $stts = array('Studentshistory.created <=' => $to);
                $apk[] = $stts;

                $stts = array('Students.class_id IN' => $css);
                $apk[] = $stts;

                $stts = array('Studentshistory.admissionyear' => $acedmic);
                $apk[] = $stts;

                $stts = array('Studentshistory.category' => 'RTE');
                $apk[] = $stts;

                $stts = array('Studentshistory.oldenroll' => '0');
                $apk[] = $stts;

                $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['DATE(Studentshistory.created)' => 'ASC'])->toarray();
            } else {

                $stts = array('Students.created >=' => $from);
                $apk[] = $stts;

                $stts = array('Students.created <=' => $to);
                $apk[] = $stts;
                $stts = array('Students.class_id IN' => $css);
                $apk[] = $stts;

                $stts = array('Students.admissionyear' => $acedmic);
                $apk[] = $stts;

                $stts = array('Students.category' => 'RTE');
                $apk[] = $stts;

                $stts = array('Students.oldenroll' => '0');
                $apk[] = $stts;

                $admissionsummary = $this->Students->find('all')->where($apk)->order(['DATE(Students.created)' => 'ASC'])->toarray();
            }

            $registrationsummary = $admissionsummary;

            $this->set(compact('registrationsummary'));
        } elseif ($class != 0) {

            $next_academic_year = $users['next_academic_year'];
            if ($currentyear == $acedmic) {

                $stts = array('Students.created >=' => $from);
                $apk[] = $stts;

                $stts = array('Students.created <=' => $to);
                $apk[] = $stts;
                $stts = array('Students.class_id' => $class);
                $apk[] = $stts;

                $stts = array('Students.admissionyear' => $acedmic);
                $apk[] = $stts;

                $stts = array('Students.category' => 'RTE');
                $apk[] = $stts;

                $stts = array('Students.oldenroll' => '0');
                $apk[] = $stts;

                $admissionsummary = $this->Students->find('all')->where($apk)->order(['DATE(Students.created)' => 'ASC'])->toarray();
            } elseif ($acedmic != $currentyear) {

                $stts = array('Studentshistory.created >=' => $from);
                $apk[] = $stts;

                $stts = array('Studentshistory.created <=' => $to);
                $apk[] = $stts;

                $stts = array('Studentshistory.class_id' => $class);
                $apk[] = $stts;

                $stts = array('Studentshistory.admissionyear' => $acedmic);
                $apk[] = $stts;

                $stts = array('Studentshistory.category' => 'RTE');
                $apk[] = $stts;

                $stts = array('Studentshistory.oldenroll' => '0');
                $apk[] = $stts;

                $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['DATE(Studentshistory.created)' => 'ASC'])->toarray();
            } else {

                $stts = array('Students.created >=' => $from);
                $apk[] = $stts;

                $stts = array('Students.created <=' => $to);
                $apk[] = $stts;
                $stts = array('Students.class_id' => $class);
                $apk[] = $stts;

                $stts = array('Students.admissionyear' => $acedmic);
                $apk[] = $stts;

                $stts = array('Students.category' => 'RTE');
                $apk[] = $stts;

                $stts = array('Students.oldenroll' => '0');
                $apk[] = $stts;

                $admissionsummary = $this->Students->find('all')->where($apk)->order(['DATE(Students.created)' => 'ASC'])->toarray();
            }

            $registrationsummary = $admissionsummary;

            $this->set(compact('registrationsummary'));
        } else {
            $rolepresent = $this->request->session()->read('Auth.User.role_id');

            if ($rolepresent == CBSE_FEE_COORDINATOR) {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('Students.created >=' => $from);
                    $apk[] = $stts;

                    $stts = array('Students.created <=' => $to);
                    $apk[] = $stts;
                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Students.category' => 'RTE');
                    $apk[] = $stts;

                    $stts = array('Students.oldenroll' => '0');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('Studentshistory.created >=' => $from);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.created <=' => $to);
                    $apk[] = $stts;
                    $stts = array('Studentshistory.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.category' => 'RTE');
                    $apk[] = $stts;

                    $stts = array('Studentshistory.oldenroll' => '0');
                    $apk[] = $stts;

                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->toarray();
                } else {

                    $stts = array('Students.created >=' => $from);
                    $apk[] = $stts;

                    $stts = array('Students.created <=' => $to);
                    $apk[] = $stts;
                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('Students.category' => 'RTE');
                    $apk[] = $stts;

                    $stts = array('Students.oldenroll' => '0');
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                }

                $registrationsummary = $admissionsummary;

                $this->set(compact('registrationsummary'));
            } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('Students.created >=' => $from);
                    $apk[] = $stts;

                    $stts = array('Students.created <=' => $to);
                    $apk[] = $stts;
                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.category' => 'RTE');
                    $apk[] = $stts;

                    $stts = array('Students.oldenroll' => '0');
                    $apk[] = $stts;

                    $stts = array('Students.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('Studentshistory.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;
                    $stts = array('Studentshistory.created >=' => $from);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.created <=' => $to);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Studentshistory.category' => 'RTE');
                    $apk[] = $stts;

                    $stts = array('Studentshistory.oldenroll' => '0');
                    $apk[] = $stts;

                    $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->toarray();
                } else {

                    $stts = array('Students.created >=' => $from);
                    $apk[] = $stts;

                    $stts = array('Students.created <=' => $to);
                    $apk[] = $stts;
                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('Students.category' => 'RTE');
                    $apk[] = $stts;

                    $stts = array('Students.oldenroll' => '0');
                    $apk[] = $stts;

                    $stts = array('Students.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;

                    $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();
                }

                $registrationsummary = $admissionsummary;

                $this->set(compact('registrationsummary'));
            }
        }
    }
    // role id to role name
    public function findacedemicsummarydrop($class = null, $acedmic = null, $from = null, $to = null, $classcollection = null)
    {
        $this->viewBuilder()->layout('admin');
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $currentyear = $users['academic_year'];
        $apk = array();
        $apk1 = array();

        if ($classcollection) {

            $classs = base64_decode($classcollection);

            $css = explode(',', $classs);

            if ($acedmic != $currentyear) {

                $stts = array('DropOutStudent.admissiondate >=' => $from);
                $apk[] = $stts;

                $stts = array('DropOutStudent.admissiondate <=' => $to);
                $apk[] = $stts;

                $stts = array('DropOutStudent.laststudclass IN' => $css);
                $apk[] = $stts;

                $stts = array('DropOutStudent.admissionyear' => $acedmic);
                $apk[] = $stts;

                $articles = TableRegistry::get('DropOutStudent');
                $ddd = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();

                foreach ($ddd as $k => $kki) {

                    $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['Studentshistory.stud_id' => $kki['s_id']])->order(['Studentshistory.id' => 'ASC'])->first();
                    if ($articles3['id']) {
                    } else {
                        $cnust[] = $kki['s_id'];
                    }
                }

                $admissionsummary = $this->DropOutStudent->find('all')->where(['DropOutStudent.s_id IN' => $cnust])->order(['DATE(DropOutStudent.admissiondate)' => 'ASC'])->toarray();
            } else {

                $stts = array('DropOutStudent.admissiondate >=' => $from);
                $apk[] = $stts;

                $stts = array('DropOutStudent.admissiondate <=' => $to);
                $apk[] = $stts;

                $stts = array('DropOutStudent.laststudclass IN' => $css);
                $apk[] = $stts;

                $stts = array('DropOutStudent.admissionyear' => $acedmic);
                $apk[] = $stts;

                $articles = TableRegistry::get('DropOutStudent');
                $admissionsummary = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();
            }

            $registrationsummary = $admissionsummary;

            $this->set(compact('registrationsummary'));
        } elseif ($class != 0) {

            if ($acedmic != $currentyear) {

                $stts = array('DropOutStudent.admissiondate >=' => $from);
                $apk[] = $stts;

                $stts = array('DropOutStudent.admissiondate <=' => $to);
                $apk[] = $stts;

                $stts = array('DropOutStudent.laststudclass' => $class);
                $apk[] = $stts;

                $stts = array('DropOutStudent.admissionyear' => $acedmic);
                $apk[] = $stts;

                $articles = TableRegistry::get('DropOutStudent');
                $ddd = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();

                foreach ($ddd as $k => $kki) {

                    $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['Studentshistory.stud_id' => $kki['s_id']])->order(['Studentshistory.id' => 'ASC'])->first();
                    if ($articles3['id']) {
                    } else {
                        $cnust[] = $kki['s_id'];
                    }
                }

                $admissionsummary = $this->DropOutStudent->find('all')->where(['DropOutStudent.s_id IN' => $cnust])->order(['DATE(DropOutStudent.admissiondate)' => 'ASC'])->toarray();
            } else {

                $stts = array('DropOutStudent.admissiondate >=' => $from);
                $apk[] = $stts;

                $stts = array('DropOutStudent.admissiondate <=' => $to);
                $apk[] = $stts;

                $stts = array('DropOutStudent.laststudclass' => $class);
                $apk[] = $stts;

                $stts = array('DropOutStudent.admissionyear' => $acedmic);
                $apk[] = $stts;

                $articles = TableRegistry::get('DropOutStudent');
                $admissionsummary = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();
            }

            $registrationsummary = $admissionsummary;

            $this->set(compact('registrationsummary'));
        } else {
            $rolepresent = $this->request->session()->read('Auth.User.role_id');

            if ($rolepresent == CBSE_FEE_COORDINATOR) {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('DropOutStudent.admissiondate >=' => $from);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.admissiondate <=' => $to);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $articles = TableRegistry::get('DropOutStudent');
                    $admissionsummary = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('DropOutStudent.admissiondate >=' => $from);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.admissiondate <=' => $to);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.board_id' => 1);
                    $apk[] = $stts;
                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $articles = TableRegistry::get('DropOutStudent');
                    $ddd = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();

                    foreach ($ddd as $k => $kki) {

                        $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['Studentshistory.stud_id' => $kki['s_id']])->order(['Studentshistory.id' => 'ASC'])->first();
                        if ($articles3['id']) {
                        } else {
                            $cnust[] = $kki['s_id'];
                        }
                    }

                    $admissionsummary = $this->DropOutStudent->find('all')->where(['DropOutStudent.s_id IN' => $cnust])->order(['DATE(DropOutStudent.admissiondate)' => 'ASC'])->toarray();
                } else {

                    $stts = array('DropOutStudent.admissiondate >=' => $from);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.admissiondate <=' => $to);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.board_id' => 1);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $articles = TableRegistry::get('DropOutStudent');
                    $admissionsummary = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();
                }

                $registrationsummary = $admissionsummary;

                $this->set(compact('registrationsummary'));
            } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {

                $next_academic_year = $users['next_academic_year'];
                if ($currentyear == $acedmic) {

                    $stts = array('DropOutStudent.admissiondate >=' => $from);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.admissiondate <=' => $to);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;

                    $articles = TableRegistry::get('DropOutStudent');
                    $admissionsummary = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();
                } elseif ($acedmic != $currentyear) {

                    $stts = array('DropOutStudent.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.admissiondate >=' => $from);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.admissiondate <=' => $to);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $articles = TableRegistry::get('DropOutStudent');
                    $ddd = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();

                    foreach ($ddd as $k => $kki) {

                        $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['Studentshistory.stud_id' => $kki['s_id']])->order(['Studentshistory.id' => 'ASC'])->first();
                        if ($articles3['id']) {
                        } else {
                            $cnust[] = $kki['s_id'];
                        }
                    }

                    $admissionsummary = $this->DropOutStudent->find('all')->where(['DropOutStudent.s_id IN' => $cnust])->order(['DATE(DropOutStudent.admissiondate)' => 'ASC'])->toarray();
                } else {

                    $stts = array('DropOutStudent.admissiondate >=' => $from);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.admissiondate <=' => $to);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk[] = $stts;

                    $stts = array('DropOutStudent.board_id IN' => ALL_BOARDS);
                    $apk[] = $stts;

                    $articles = TableRegistry::get('DropOutStudent');
                    $admissionsummary = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();
                }

                $registrationsummary = $admissionsummary;

                $this->set(compact('registrationsummary'));
            }
        }
    }

    public function findacedemicstudentsdetail($board = null, $acedmic = null, $date = null)
    {
        $this->viewBuilder()->layout('admin');
        $date1 = date('Y-m-d');
        $this->set(compact('date1'));
        $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
        $currentyear = $users['academic_year'];

        if ($board == 'cbse') {

            if ($acedmic > $currentyear && $acedmic != '1') {

                $stts = array('DATE(Students.created)' => $date);
                $apk[] = $stts;
                $stts = array('Students.admissionyear' => $acedmic);
                $apk[] = $stts;
                $stts = array('Students.board_id' => 1);
                $apk[] = $stts;

                $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
            } elseif ($acedmic != $currentyear && $acedmic != '1') {

                $stts = array('DATE(Studentshistory.created)' => $date);
                $apk[] = $stts;
                $stts = array('Studentshistory.admissionyear' => $acedmic);
                $apk[] = $stts;
                $stts = array('Studentshistory.board_id' => 1);
                $apk[] = $stts;

                $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.created' => 'ASC'])->toarray();
            } else {

                $stts = array('DATE(Students.created)' => $date);
                $apk[] = $stts;
                $stts = array('Students.status' => 'Y');
                $apk[] = $stts;
                if ($acedmic != '1') {
                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                }
                $stts = array('Students.board_id' => 1);
                $apk[] = $stts;

                $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
            }

            if ($acedmic > $currentyear && $acedmic != '1') {

                foreach ($admissionsummary as $kk => $jj) {

                    $idd[] = $jj['student_id'];
                }
                $stts = array('DATE(DropOutStudent.admissiondate)' => $date);
                $apk1[] = $stts;
                if (!empty($idd)) {
                    $stts = array('DropOutStudent.s_id NOT IN' => $idd);
                    $apk1[] = $stts;
                }
                $stts = array('DropOutStudent.board_id' => 1);
                $apk1[] = $stts;
                if ($acedmic != '1') {
                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk1[] = $stts;
                }
                $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.admissiondate' => 'ASC'])->toarray();
            } elseif ($acedmic == $currentyear && $acedmic != '1') {

                $stts = array('DATE(DropOutStudent.admissiondate)' => $date);
                $apk1[] = $stts;
                $stts = array('DropOutStudent.admissionyear' => $acedmic);
                $apk1[] = $stts;

                $stts = array('DropOutStudent.board_id' => 1);
                $apk1[] = $stts;

                $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.admissiondate' => 'ASC'])->toarray();
            } else {
                foreach ($admissionsummary as $kk => $jj) {

                    $idd[] = $jj['student_id'];
                }
                $stts = array('DATE(DropOutStudent.admissiondate)' => $date);
                $apk1[] = $stts;
                if (!empty($idd)) {
                    $stts = array('DropOutStudent.s_id NOT IN' => $idd);
                    $apk1[] = $stts;
                }
                $stts = array('DropOutStudent.board_id' => 1);
                $apk1[] = $stts;
                if ($acedmic != '1') {
                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk1[] = $stts;
                }
                $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.admissiondate' => 'ASC'])->toarray();
            }

            if (!empty($admissionsummary2)) {
                $registrationsummary = array_merge($admissionsummary, $admissionsummary2);
            } else {
                $registrationsummary = $admissionsummary;
            }

            $this->set(compact('registrationsummary'));
        } elseif ($board == 'int') {

            if ($acedmic > $currentyear && $acedmic != '1') {

                $stts = array('Students.status' => 'Y');
                $apk[] = $stts;

                $stts = array('DATE(Students.created)' => $date);
                $apk[] = $stts;
                if ($acedmic != '1') {
                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                }
                $stts = array('Students.board_id !=' => 1);
                $apk[] = $stts;

                $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
            } elseif ($acedmic != $currentyear && $acedmic != '1') {
                $stts = array('DATE(Studentshistory.created)' => $date);
                $apk[] = $stts;

                if ($acedmic != '1') {
                    $stts = array('Studentshistory.admissionyear' => $acedmic);
                    $apk[] = $stts;
                }
                $stts = array('Studentshistory.board_id !=' => 1);
                $apk[] = $stts;

                $admissionsummary = $this->Studentshistory->find('all')->where($apk)->order(['Studentshistory.created' => 'ASC'])->toarray();
                //pr($admissionsummary); die;
            } else {
                $stts = array('Students.status' => 'Y');
                $apk[] = $stts;

                $stts = array('DATE(Students.created)' => $date);
                $apk[] = $stts;
                if ($acedmic != '1') {
                    $stts = array('Students.admissionyear' => $acedmic);
                    $apk[] = $stts;
                }
                $stts = array('Students.board_id !=' => 1);
                $apk[] = $stts;

                $admissionsummary = $this->Students->find('all')->where($apk)->order(['Students.created' => 'ASC'])->toarray();
            }

            if ($acedmic > $currentyear && $acedmic != '1') {
                foreach ($admissionsummary as $kk => $jj) {

                    $idd[] = $jj['student_id'];
                }

                $stts = array('DATE(DropOutStudent.admissiondate)' => $date);
                $apk1[] = $stts;
                if (!empty($idd)) {
                    $stts = array('DropOutStudent.s_id NOT IN' => $idd);
                    $apk1[] = $stts;
                }
                $stts = array('DropOutStudent.board_id !=' => 1);
                $apk1[] = $stts;
                if ($acedmic != '1') {
                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk1[] = $stts;
                }
                $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.admissiondate' => 'ASC'])->toarray();
            } elseif ($acedmic == $currentyear && $acedmic != '1') {

                $stts = array('DATE(DropOutStudent.admissiondate)' => $date);
                $apk1[] = $stts;
                if ($acedmic != '1') {
                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk1[] = $stts;
                }

                $stts = array('DropOutStudent.board_id !=' => 1);
                $apk1[] = $stts;
                $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.admissiondate' => 'ASC'])->toarray();
                //pr($Classections21); die;

            } else {
                foreach ($admissionsummary as $kk => $jj) {

                    $idd[] = $jj['student_id'];
                }

                $stts = array('DATE(DropOutStudent.admissiondate)' => $date);
                $apk1[] = $stts;
                if (!empty($idd)) {
                    $stts = array('DropOutStudent.s_id NOT IN' => $idd);
                    $apk1[] = $stts;
                }
                $stts = array('DropOutStudent.board_id !=' => 1);
                $apk1[] = $stts;
                if ($acedmic != '1') {
                    $stts = array('DropOutStudent.admissionyear' => $acedmic);
                    $apk1[] = $stts;
                }
                $admissionsummary2 = $this->DropOutStudent->find('all')->where($apk1)->order(['DropOutStudent.admissiondate' => 'ASC'])->toarray();
            }

            if (!empty($admissionsummary2)) {
                $registrationsummary = array_merge($admissionsummary, $admissionsummary2);
            } else {
                $registrationsummary = $admissionsummary;
            }
            //pr($registrationsummary); die;
            $this->set(compact('registrationsummary'));
        }

        $this->set(compact('registrationsummary'));
    }

    public function shuffle()
    {
        $this->viewBuilder()->layout('admin');
        if ($this->request->is(['post'])) {
            $userId = $this->request->session()->read('Auth.User.id');
            $student1 = $this->Students->find()->where(['id' => $this->request->data['fromId']])->first();
            $student2 = $this->Students->find()->where(['id' => $this->request->data['toId']])->first();
            if (empty($student1) || empty($student2)) {
                $this->Flash->error('Invalid Data');
                return $this->redirect(['action' => 'shuffle']);
            }
            $newShuffle = $this->StudentShuffles->newEntity();
            $newShuffle['from_student_id'] = $student1['id'];
            $newShuffle['from_enroll'] = $student1['enroll'];
            $newShuffle['to_student_id'] = $student2['id'];
            $newShuffle['to_enroll'] = $student2['enroll'];
            $newShuffle['user_id'] = $userId;
            if ($this->StudentShuffles->save($newShuffle)) {
                $student1['enroll'] = $newShuffle['to_enroll'];
                $student2['enroll'] = $newShuffle['from_enroll'];
                $this->Students->save($student1);
                $this->Students->save($student2);
                $this->Flash->success(_('Enroll Number Shuffled Successfully'));
                return $this->redirect(['action' => 'shuffle']);
            } else {
                $this->Flash->error('Please Try after SomeTime');
                return $this->redirect(['action' => 'shuffle']);
            }
        }
    }

    public function enroll_search()
    {
        $this->autoRender = false;
        $students = $this->Students->find()->contain(['Classes', 'Sections'])->where(['enroll' => $this->request->data['enroll']])->first();
        if (empty($students)) {
            $response['success'] = false;
            $this->response->type('application/json');
            $this->response->body(json_encode($response));
            return $this->response;
        }
        $student['id'] = $students['id'];
        $student['name'] = $students['full_name'];
        $student['class'] = $students['class']['title'];
        $student['section'] = $students['section']['title'];
        $student['enroll'] = $students['enroll'];
        $response['success'] = true;
        $response['student'] = $student;
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
    }

    // search base admission data excel get
    // Academic year is static
    public function branch_admissions()
    {
        $b_name = $_SESSION['branch_name'];
        $cond = $_SESSION['admissiondata'];
        $curr_years = ACADEMIC_YEAR;
        if ($b_name) {
            $this->connection($b_name);
            $conect_new = ConnectionManager::get('default');
            $student_count = "SELECT Students.enroll,Students.fname,Students.fathername,Students.mothername,Students.middlename,Students.lname,Students.f_phone,Students.m_phone,Class.title as classtitle,Section.title as sectiontitle,Students.created FROM students Students LEFT JOIN classes Class ON Students.`class_id` = Class.id LEFT JOIN sections Section ON Students.`section_id` = Section.id where Students.`acedmicyear`= '$curr_years' and Students.`status` = 'Y' ";
            $detail = $student_count . $cond . " ORDER BY Class.`sort` ASC";
            $rinstall = $conect_new->execute($detail)->fetchAll('assoc');
            $stu_count = $rinstall;
            foreach ($stu_count as $values) {
                $student_data[] = [
                    'scholar_no' => $values['enroll'],
                    'name' => ucfirst($values['fname']) . ' ' . $values['middlename'] . ' ' . $values['lname'],
                    'fname' => $values['fathername'],
                    'mname' => $values['mothername'],
                    'admission_date' => $values['created'],
                    'class' => $values['classtitle'],
                    'section' => $values['sectiontitle'],
                    'f_mobile' => $values['f_phone'],
                    'm_mobile' => $values['m_phone'],
                    'branch_name' => $b_name
                ];
            }
        } else {
            $dbname = $this->request->session()->read('Auth.User.franchise_db');
            $branch = explode(",", $dbname);
            if (empty($branch)) {
                foreach ($branch as $value) {  //pr($value); die;
                    $conect_new = ConnectionManager::get('default');
                    $student_count = "SELECT Students.enroll,Students.fname,Students.fathername,Students.mothername,Students.middlename,Students.lname,Students.f_phone,Students.m_phone,Class.title as classtitle,Section.title as sectiontitle,Students.created FROM students Students LEFT JOIN classes Class ON Students.`class_id` = Class.id LEFT JOIN sections Section ON Students.`section_id` = Section.id where Students.`acedmicyear`= '$curr_years' and Students.`status` = 'Y' ";
                    if (!empty($_SESSION['admissiondata'])) {
                        $student_count = $student_count . $_SESSION['admissiondata'] . " ORDER BY Class.`sort` ASC";
                    } else {
                        $student_count = $student_count . " ORDER BY Class.`sort` ASC";
                    }
                    $rinstall = $conect_new->execute($student_count)->fetchAll('assoc');
                    $stu_count = $rinstall;
                    foreach ($stu_count as $values) {
                        //  pr($values); die;
                        $student_data[] = [
                            'scholar_no' => $values['enroll'],
                            'name' => ucfirst($values['fname']) . ' ' . $values['middlename'] . ' ' . $values['lname'],
                            'fname' => $values['fathername'],
                            'mname' => $values['mothername'],
                            'admission_date' => $values['created'],
                            'class' => $values['classtitle'],
                            'section' => $values['sectiontitle'],
                            'f_mobile' => $values['f_phone'],
                            'm_mobile' => $values['m_phone']
                        ];
                    }
                }
            } else {
                foreach ($branch as $value) {
                    $this->connection($value);
                    $conect_new = ConnectionManager::get('default');
                    $student_count = "SELECT Students.enroll,Students.fname,Students.fathername,Students.mothername,Students.middlename,Students.lname,Students.f_phone,Students.m_phone,Class.title as classtitle,Section.title as sectiontitle,Students.created FROM students Students LEFT JOIN classes Class ON Students.`class_id` = Class.id LEFT JOIN sections Section ON Students.`section_id` = Section.id where Students.`acedmicyear`= '$curr_years' and Students.`status` = 'Y' ";
                    if (!empty($_SESSION['admissiondata'])) {
                        $student_count = $student_count . $cond . " ORDER BY Class.`sort` ASC";
                    } else {
                        $student_count = $student_count . " ORDER BY Class.`sort` ASC";;
                    }
                    $rinstall = $conect_new->execute($student_count)->fetchAll('assoc');
                    $stu_count = $rinstall;
                    foreach ($stu_count as $values) {
                        $student_data[] = [
                            'scholar_no' => $values['enroll'],
                            'name' => ucfirst($values['fname']) . ' ' . $values['middlename'] . ' ' . $values['lname'],
                            'fname' => $values['fathername'],
                            'mname' => $values['mothername'],
                            'admission_date' => $values['created'],
                            'class' => $values['classtitle'],
                            'section' => $values['sectiontitle'],
                            'f_mobile' => $values['f_phone'],
                            'm_mobile' => $values['m_phone'],
                            'branch_name' => $value
                        ];
                    }
                }
            }
        }
        // pr($student_data); die;
        $this->set(compact('student_data'));
    }
    // Academic year is static
    public function branch_admissions_index()
    {
        $this->viewBuilder()->layout('admin');
        $dbname = $this->request->session()->read('Auth.User.franchise_db');
        $branch = explode(",", $dbname);
        $this->set('branch', $branch);
    }

    // search base admission data get
    // Academic year is static
    function search_admission_data()
    {
        $cond = '';
        $datefrom = date('Y-m-d', strtotime($this->request->data['datefrom']));
        $dateto = date('Y-m-d', strtotime($this->request->data['dateto']));

        if ($datefrom != "1970-01-01" && !empty($datefrom) && $dateto != "1970-01-01" && !empty($dateto)) {
            $cond .= "AND Date(Students.created)   >='" . $datefrom . "' AND Date(Students.created)  <='" . $dateto . "'";
        }
        //session start
        $session = $this->request->session();
        $branch_name = $this->request->data['branch_name'];
        $session->delete('admissiondata');
        if ($datefrom && $dateto) {
            $session->delete('class');
            $session->write('class', $class);
        }
        //session end
        //if start 
        if (!empty($branch_name)) {
            $currnt_years = ACADEMIC_YEAR;
            $this->connection($branch_name);
            $conect_new = ConnectionManager::get('default');
            $student_count = "SELECT Students.enroll,Students.fname,Students.fathername,Students.mothername,Students.middlename,Students.lname,Students.f_phone,Students.m_phone,Class.title as classtitle,Section.title as sectiontitle,Students.created FROM students Students LEFT JOIN classes Class ON Students.`class_id` = Class.id LEFT JOIN sections Section ON Students.`section_id` = Section.id where Students.`acedmicyear`= '$currnt_years' and Students.`status` = 'Y' ";

            $detail = $student_count . $cond;
            $rinstall = $conect_new->execute($detail)->fetchAll('assoc');
            foreach ($rinstall as $values) {

                $student_data[] = [
                    'scholar_no' => $values['enroll'],
                    'name' => ucfirst($values['fname']) . ' ' . $values['middlename'] . ' ' . $values['lname'],
                    'fname' => $values['fathername'],
                    'mname' => $values['mothername'],
                    'admission_date' => $values['created'],
                    'class' => $values['classtitle'],
                    'section' => $values['sectiontitle'],
                    'f_mobile' => $values['f_phone'],
                    'm_mobile' => $values['m_phone'],
                    'branch_name' => $branch_name
                ];
            }
        } else {

            $dbname = $this->request->session()->read('Auth.User.franchise_db');
            if (empty($dbname)) {
                $currnts_years = ACADEMIC_YEAR;
                $conn = ConnectionManager::get('default');
                $this->set(compact('student_data'));
                $student_count = "SELECT Students.enroll,Students.fname,Students.fathername,Students.mothername,Students.middlename,Students.lname,Students.f_phone,Students.m_phone,Class.title as classtitle,Section.title as sectiontitle,Students.created FROM students Students LEFT JOIN classes Class ON Students.`class_id` = Class.id LEFT JOIN sections Section ON Students.`section_id` = Section.id where Students.`acedmicyear`= '$currnts_years' and Students.`status` = 'Y' ";

                $cond = '';
                if ($datefrom && $dateto) {
                    $cond .= "AND Date(Students.created)   >='" . $datefrom . "' AND Date(Students.created)  <='" . $dateto . "'";
                }
                $detail = $student_count . $cond . " ORDER BY Class.`sort` ASC";
                $rinstall = $conn->execute($detail)->fetchAll('assoc');
                $stu_count = $rinstall;

                foreach ($stu_count as $values) {

                    $student_data[] = [
                        'scholar_no' => $values['enroll'],
                        'name' => ucfirst($values['fname']) . ' ' . $values['middlename'] . ' ' . $values['lname'],
                        'fname' => $values['fathername'],
                        'mname' => $values['mothername'],
                        'admission_date' => $values['created'],
                        'class' => $values['classtitle'],
                        'section' => $values['sectiontitle'],
                        'f_mobile' => $values['f_phone'],
                        'm_mobile' => $values['m_phone'],
                    ];
                }
            } else {
                $currnts_years = ACADEMIC_YEAR;
                $branch = explode(",", $dbname);
                foreach ($branch as $value) {
                    $this->connection($value);
                    $conect_new = ConnectionManager::get('default');
                    $this->set(compact('student_data'));
                    $student_count = "SELECT Students.enroll,Students.fname,Students.fathername,Students.mothername,Students.middlename,Students.lname,Students.f_phone,Students.m_phone,Class.title as classtitle,Section.title as sectiontitle,Students.created FROM students Students LEFT JOIN classes Class ON Students.`class_id` = Class.id LEFT JOIN sections Section ON Students.`section_id` = Section.id where Students.`acedmicyear`= '$currnts_years' and Students.`status` = 'Y' ";
                    $cond = '';
                    if ($datefrom && $dateto) {
                        $cond .= "AND Date(Students.created)   >='" . $datefrom . "' AND Date(Students.created)  <='" . $dateto . "'";
                    }
                    $detail = $student_count . $cond . " ORDER BY Class.`sort` ASC";
                    $rinstall = $conect_new->execute($detail)->fetchAll('assoc');
                    $stu_count = $rinstall;
                    foreach ($stu_count as $values) {
                        $student_data[] = [
                            'scholar_no' => $values['enroll'],
                            'name' => ucfirst($values['fname']) . ' ' . $values['middlename'] . ' ' . $values['lname'],
                            'fname' => $values['fathername'],
                            'mname' => $values['mothername'],
                            'admission_date' => $values['created'],
                            'class' => $values['classtitle'],
                            'section' => $values['sectiontitle'],
                            'f_mobile' => $values['f_phone'],
                            'm_mobile' => $values['m_phone'],
                            'branch_name' => $value
                        ];
                    }
                }
            }
        }

        $this->set(compact('student_data'));
        $session->delete('admissiondata');
        $session->delete('branch_name');

        $session->write('admissiondata', $cond);
        $session->write('branch_name', $branch_name);
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

    public function update_table_fields()
    {
        $this->autoRender = false;
        $students = $this->Students->find()->toArray();

        foreach ($students as $student) {
            $update = $this->Students->get($student['id']);
            $update->dobb = date("Y-m-d", strtotime($student['dob']));
            $this->Students->save($update);
        }
        echo "Updated";
    }

    // Start Rakesh Code 

    public function exceldownloadbackstudent($course_id = null, $section_id = null)
    {
        $this->loadModel('ExamResult');
        $course_id = $_GET['course'];
        $section_id = $_GET['section'];

        // Subquery to get student IDs
        $studentIdsSubquery = $this->ExamResult->find()
            ->select(['student_id'])
            ->distinct(['student_id'])
            ->where(['exam_id' => 0, 'course_id' => $course_id, 'year' => $section_id]);

        // Main query to get student details using the subquery
        $findStudent = $this->Students->find('all')
            ->where([
                'Students.id IN' => $studentIdsSubquery
            ])
            ->order(['id' => 'ASC'])
            ->toArray();
        // pr($findStudent); die;
        if (count($findStudent) == 0) {
            $this->Flash->error(__('This course or Year/Semester Student Not Found'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('findStudent'));
        $this->viewBuilder()->layout('admin');
    }

    // end Rakesh Code 




    // sanjay code start
    public function studentpendingfeedetails()
    {
        $this->viewBuilder()->layout('admin');

        $academic_session = $this->AcademicYear->find('list', ['keyField' => 'academicyear', 'valueField' => 'academicyear'])->order(['AcademicYear.id' => 'DESC'])->toArray();
        $sections = $this->Sections->find('all')->select(['id', 'title'])->where(['status' => 1])->order(['title' => 'ASC'])->toArray();
        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        if ($rolepresent == ADMIN || $rolepresent == CENTER_COORDINATOR || $rolepresent == BRANCH_HEAD) {
            $classes = $this->Classes->find('list', [
                'keyField' => 'id',
                'valueField' => 'title',
            ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        } elseif ($rolepresent == CBSE_FEE_COORDINATOR) {
            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        } elseif ($rolepresent == INTERNATIONAL_FEE_COORDINATOR) {
            $classes = $this->Classections->find('list', [
                'keyField' => 'Classes.id',
                'valueField' => 'Classes.title',
            ])->contain(['Classes'])->where(['Classes.status' => '1', 'Classes.board_id IN' => ALL_BOARDS])->order(['Classes.sort' => 'ASC'])->toArray();
            $this->set('classes', $classes);
        }
        $this->set(compact('sections', 'classes', 'academic_session'));


        $orderby['Students.section_id'] = 'ASC';
        $orderby['Classes.title'] = 'ASC';
        $orderby['Students.st_full_name'] = 'ASC';

        $req_data = $_GET;
        $conditions = [];
        $batch = $req_data['batch'];
        $class = $req_data['class_id'];
        $fname = trim($req_data['fname']);
        $no_dues = $req_data['no_dues'];

        if (!empty($batch)) {
            $conditions['Students.batch'] = $batch;
        }
        if (!empty($class)) {
            $conditions['Students.class_id IN'] = $class;
        }
        if (!empty($fname)) {
            $conditions['UPPER(Students.fname) LIKE'] = '%' . trim(strtoupper($fname)) . '%';
        }

        if (!empty($conditions)) {
            $students_query = $this->Students->find('all')->contain(['Classes', 'Sections'])->where([$conditions, 'Students.status' => 'Y'])->order($orderby)->toarray();

            if ($no_dues == 1) {
                foreach ($students_query as $value) {
                    $students[] = $value;
                }
            } else {
                foreach ($students_query as $value) {
                    $getFeesDetails = $this->getstudenttotalfeesdetails($value);
                    $section1 = $value['section_id'];
                    if ($section1 == 1) {
                        $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'];
                        $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'];
                        $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'];
                    } elseif ($section1 == 2) {
                        $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'];
                        $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'];
                        $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'];
                    } elseif ($section1 == 3) {
                        $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'];
                        $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'];
                        $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'];
                    } else {
                        $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['4th_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'] + $getFeesDetails['4th_year_transport_fees'];
                        $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['4th_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'] + $getFeesDetails['4th_year_students_transport_deposite'];
                        $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'] + $getFeesDetails['4th_year_students_discount'];
                    }
                    $total_balance = $total_batch_fee - $total_batch_paid_fee - $getFeesDetails['discount'];
                    if ($total_balance > 0) {
                        $students[] = $value;
                    }
                }
            }

            $paginatedData = $this->paginateArray($students, 50);
            $this->set('students', $paginatedData['data']);
            $this->set('paging', $paginatedData['paging']);
        } else {
            $students_details = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => 'Y'])->order($orderby)->toarray();
            foreach ($students_details as $value) {
                $getFeesDetails = $this->getstudenttotalfeesdetails($value);
                $section1 = $value['section_id'];
                if ($section1 == 1) {
                    $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'];
                    $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'];
                    $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'];
                } elseif ($section1 == 2) {
                    $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'];
                    $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'];
                    $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'];
                } elseif ($section1 == 3) {
                    $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'];
                    $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'];
                    $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'];
                } else {
                    $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['4th_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'] + $getFeesDetails['4th_year_transport_fees'];
                    $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['4th_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'] + $getFeesDetails['4th_year_students_transport_deposite'];
                    $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'] + $getFeesDetails['4th_year_students_discount'];
                }
                $total_balance = $total_batch_fee - $total_batch_paid_fee - $getFeesDetails['discount'];
                if ($total_balance > 0) {
                    $students[] = $value;
                }
            }
            $paginatedData = $this->paginateArray($students, 50);
            $this->set('students', $paginatedData['data']);
            $this->set('paging', $paginatedData['paging']);
        }
    }




    public function searchstudentpendingfeedetails()
    {
        // Retrieving $conditions data from session
        $req_data = $_GET;
        $conditions = [];
        $batch = $req_data['batch'];
        $class = $req_data['class_id'];
        $fname = trim($req_data['fname']);
        $no_dues = $req_data['no_dues'];

        if (!empty($batch)) {
            $conditions['Students.batch'] = $batch;
        }
        if (!empty($class)) {
            $conditions['Students.class_id IN'] = $class;
        }
        if (!empty($fname)) {
            $conditions['UPPER(Students.fname) LIKE'] = '%' . trim(strtoupper($fname)) . '%';
        }

        $conditions['Students.status'] = 'Y';
        $orderby['Students.section_id'] = 'ASC';
        $orderby['Classes.title'] = 'ASC';
        $orderby['Students.st_full_name'] = 'ASC';
        $students_details = $this->Students->find('all')->contain(['Classes', 'Sections'])->where($conditions)->order($orderby)->toArray();

        $feesection['no_dues'] = $no_dues;
        $this->request->Session()->write('search_conditions', $conditions);
        $this->request->Session()->write('feesection', $feesection);

        // for check due fee is 0 or not
        $students = [];
        if ($no_dues == 1) {
            foreach ($students_details as $value) {
                $students[] = $value;
            }
        } else {
            foreach ($students_details as $value) {
                $getFeesDetails = $this->getstudenttotalfeesdetails($value);
                $section1 = $value['section_id'];

                if ($section1 == 1) {
                    $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'];
                    $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'];
                    $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'];
                } elseif ($section1 == 2) {
                    $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'];
                    $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'];
                    $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'];
                } elseif ($section1 == 3) {
                    $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'];
                    $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'];
                    $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'];
                } else {
                    $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['4th_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'] + $getFeesDetails['4th_year_transport_fees'];
                    $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['4th_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'] + $getFeesDetails['4th_year_students_transport_deposite'];
                    $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'] + $getFeesDetails['4th_year_students_discount'];
                }

                $total_balance = $total_batch_fee - $total_batch_paid_fee - $getFeesDetails['discount'];
                if ($total_balance > 0) {
                    $students[] = $value;
                }
            }
        }
        $paginatedData = $this->paginateArray($students, 50);
        $this->set('students', $paginatedData['data']);
        $this->set('paging', $paginatedData['paging']);
        // $this->set(compact('students','no_dues'));
    }



    //student data export in excel
    public function excelexportpendingfees2()
    {
        $conditions1 = $this->request->Session()->read('search_conditions');
        $feesection = $this->request->Session()->read('feesection');
        $this->request->Session()->delete('search_conditions');
        $this->request->Session()->delete('feesection');

        $orderby['Students.section_id'] = 'ASC';
        $orderby['Classes.title'] = 'ASC';
        $orderby['Students.st_full_name'] = 'ASC';
        $students_details = $this->Students->find('all')->contain(['Classes', 'Sections'])->where([$conditions1, 'Students.status' => 'Y'])->order($orderby)->toarray();
        $this->set(compact('students_details'));
        $no_dues = $feesection['no_dues'];
        $this->set(compact('no_dues'));
    }


    public function printdatahtml()
    {
        $this->viewBuilder()->layout('newadmin');
        $this->sitesetting('print');
        $this->loadModel('Students');
        $data = $_SESSION['parentlogindata'];
        $students = $this->Students->find()
            ->contain(['Classes', 'Sections', 'Boards'])
            ->where($data)
            ->order(['Classes.id' => 'asc', 'Students.st_full_name' => 'ASC'])->toarray();
        $this->set('students', $students);
    }


    // for html print of pending fee
    public function exportpendingfeesinhtml()
    {
        $this->viewBuilder()->layout('newadmin');
        $this->sitesetting('print');
        $conditions1 = $this->request->Session()->read('search_conditions');
        $feesection = $this->request->Session()->read('feesection');
        $this->request->Session()->delete('search_conditions');
        $this->request->Session()->delete('feesection');

        $orderby['Students.section_id'] = 'ASC';
        $orderby['Classes.title'] = 'ASC';
        $orderby['Students.st_full_name'] = 'ASC';
        $students_details = $this->Students->find('all')->contain(['Classes', 'Sections'])->where([$conditions1, 'Students.status' => 'Y'])->order($orderby)->toarray();
        $this->set('students', $students_details);
        $no_dues = $feesection['no_dues'];
        $this->set(compact('no_dues'));
    }



    // for get pending fee datails by rajesh kumar 26-06-2024
    public function getstudenttotalfeesdetails($students_details)
    {
        $classfee_articles = TableRegistry::get('Classfee');
        $Studentfees_articles = TableRegistry::get('Studentfees');

        // ******************Fees Deposite start************************
        //other all fees 
        $studentfeesother = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.status' => 'Y'])->andWhere(['OR' => ['Studentfees.quarter_name IS' => null, 'Studentfees.quarter_name' => '']])->first();
        $studentfeescaution = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Collage Caution Money (Refundable)', 'Studentfees.status' => 'Y'])->first();
        $studentfeesother['total'] = $studentfeesother['sum'] + $studentfeescaution['sum'];
        // for quarter1 deposite fees
        $studentfeesquarter1 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Quater1', 'Studentfees.status' => 'Y'])->first();
        // for quarter2 deposite fees
        $studentfeesquarter2 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Quater2', 'Studentfees.status' => 'Y'])->first();
        // for quarter3 deposite fees
        $studentfeesquarter3 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Quater3', 'Studentfees.status' => 'Y'])->first();
        // for quarter4 deposite fees
        $studentfeesquarter4 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Quater4', 'Studentfees.status' => 'Y'])->first();
        // for transport1 deposite fees
        $studentfeestransport1 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Transport1', 'Studentfees.status' => 'Y'])->first();
        // for transport2 deposite fees
        $studentfeestransport2 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Transport2', 'Studentfees.status' => 'Y'])->first();
        // for transport3 deposite fees
        $studentfeestransport3 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Transport3', 'Studentfees.status' => 'Y'])->first();
        // for transport4 deposite fees
        $studentfeestransport4 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Transport4', 'Studentfees.status' => 'Y'])->first();
        // for previous year due deposite
        $studentfeesprevious = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Previous Year Due', 'Studentfees.status' => 'Y'])->first();


        // total fess of each quarter
        //quarter1
        $student_rec['1st_year_students_fee_deposite'] = $studentfeesquarter1['sum'] + $studentfeesother['total'];
        $student_rec['1st_year_students_fee_deposite'] = $student_rec['1st_year_students_fee_deposite'] > 0 ? $student_rec['1st_year_students_fee_deposite'] : 0;
        //quarter2
        $student_rec['2nd_year_students_fee_deposite'] = $studentfeesquarter2['sum'] > 0 ? $studentfeesquarter2['sum'] : 0;
        //quarter3
        $student_rec['3rd_year_students_fee_deposite'] = $studentfeesquarter3['sum'] > 0 ? $studentfeesquarter3['sum'] : 0;
        //quarter4
        $student_rec['4th_year_students_fee_deposite'] = $studentfeesquarter4['sum'] > 0 ? $studentfeesquarter4['sum'] : 0;


        if ($students_details['is_transport'] == 'Y') {
            //transport1
            $student_rec['1st_year_students_transport_deposite'] = $studentfeestransport1['sum'] > 0 ? $studentfeestransport1['sum'] : 0;
            //transport2
            $student_rec['2nd_year_students_transport_deposite'] = $studentfeestransport2['sum'] > 0 ? $studentfeestransport2['sum'] : 0;
            //transport3
            $student_rec['3rd_year_students_transport_deposite'] = $studentfeestransport3['sum'] > 0 ? $studentfeestransport3['sum'] : 0;
            //transport4
            $student_rec['4th_year_students_transport_deposite'] = $studentfeestransport4['sum'] > 0 ? $studentfeestransport4['sum'] : 0;
        } else {
            $student_rec['1st_year_students_transport_deposite'] = 'NA';
            $student_rec['2nd_year_students_transport_deposite'] = 'NA';
            $student_rec['3rd_year_students_transport_deposite'] = 'NA';
            $student_rec['4th_year_students_transport_deposite'] = 'NA';
        }
        //previous_year
        $student_rec['previous_year_students_fee_deposite'] = $studentfeesprevious['sum'] > 0 ? $studentfeesprevious['sum'] : 0;

        // for discount
        // quarter1 discount
        $studentDiscountQuarter1 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.addtionaldiscount')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->andWhere(['Studentfees.quarter_name IN' => ['', 'Collage Caution Money (Refundable)', 'Previous Year Due', 'Quater1', 'Transport1']])->first();
        $student_rec['1st_year_students_discount'] = $studentDiscountQuarter1['sum'] > 0 ? $studentDiscountQuarter1['sum'] : 0;
        // quarter2 discount
        $studentDiscountQuarter2 = $Studentfees_articles->find('all')
            ->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.addtionaldiscount')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->andWhere(['Studentfees.quarter_name IN' => ['Quater2', 'Transport2']])->first();
        $student_rec['2nd_year_students_discount'] = $studentDiscountQuarter2['sum'] > 0 ? $studentDiscountQuarter2['sum'] : 0;
        // quarter3 discount
        $studentDiscountQuarter3 = $Studentfees_articles->find('all')
            ->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.addtionaldiscount')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->andWhere(['Studentfees.quarter_name IN' => ['Quater3', 'Transport3']])->first();
        $student_rec['3rd_year_students_discount'] = $studentDiscountQuarter3['sum'] > 0 ? $studentDiscountQuarter3['sum'] : 0;
        // quarter4 discount
        $studentDiscountQuarter4 = $Studentfees_articles->find('all')
            ->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.addtionaldiscount')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->andWhere(['Studentfees.quarter_name IN' => ['Quater4', 'Transport4']])->first();
        $student_rec['4th_year_students_discount'] = $studentDiscountQuarter4['sum'] > 0 ? $studentDiscountQuarter4['sum'] : 0;
        // pr($student_rec);die;


        $studentfeesdetails = $Studentfees_articles->find('all')->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->andWhere(['Studentfees.quarter_name NOT IN' => ['Hostel Charges ( 2 Beded )', 'Hostel Charges ( 3 Beded )']])->toarray();
        $student_rec['discount'] = 0;
        foreach ($studentfeesdetails as $k => $value) {
            $student_rec['discount'] += $value['discount'];
            $student_rec['discount'] += $value['addtionaldiscount'];
        }
        // **********************Fees Deposite end********************


        // **********************Total of  Course Fees Start ********************

        // for tution fee
        $classfee = $classfee_articles->find('all')->contain(['Feesheads'])->where(['Classfee.class_id' => $students_details['class_id'], 'Classfee.academic_year' => $students_details['batch'], 'Feesheads.type IN' => [1]])->order(['Feesheads.type' => 'asc'])->toarray();
        // total of head which include in quarter1
        $addmissiontimehead = $classfee_articles->find('all')->contain(['Feesheads'])->where(['Classfee.class_id' => $students_details['class_id'], 'Classfee.academic_year' => $students_details['batch'], 'Feesheads.type IN' => [2]])->order(['Feesheads.type' => 'asc'])->toarray();
        //for transport fee
        $transporthead = $classfee_articles->find('all')->contain(['Feesheads'])->where(['Classfee.class_id' => $students_details['class_id'], 'Classfee.academic_year' => $students_details['batch'], 'Feesheads.type IN' => [3]])->order(['Feesheads.type' => 'asc'])->toarray();

        // to check special case
        if ($students_details['is_special'] == 'Y') {
            $studentfeesdetails = $Studentfees_articles->find('all')->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.recipetno' => '0', 'Studentfees.status' => 'Y'])->toarray();
            $fessHeads = [];
            foreach ($studentfeesdetails as $k => $value) {
                $quas = unserialize($value['quarter']);
                foreach ($quas as $key => $val) {
                    if (!empty($key) && !in_array($key, $fessHeads)) {
                        $fessHeads[] = $key;
                    }
                }
            }
        }


        //quarter1
        if (!in_array('Quater1', $fessHeads)) {
            $tution_fees = $classfee[0]['qu1_fees'];
        }
        // all fee head which incude in quarter1
        if (!in_array($addmissiontimehead['0']['feeshead']['name'], $fessHeads)) {
            $admission_fees = $addmissiontimehead[0]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['1']['feeshead']['name'], $fessHeads)) {
            $collage_caution_fees = $addmissiontimehead[1]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['2']['feeshead']['name'], $fessHeads)) {
            $Uniform = $addmissiontimehead[2]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['3']['feeshead']['name'], $fessHeads)) {
            $Books = $addmissiontimehead[3]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['4']['feeshead']['name'], $fessHeads)) {
            $pocketArticles = $addmissiontimehead[4]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['5']['feeshead']['name'], $fessHeads)) {
            $libraryFees = $addmissiontimehead[5]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['6']['feeshead']['name'], $fessHeads)) {
            $enrollmentFees = $addmissiontimehead[6]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['7']['feeshead']['name'], $fessHeads)) {
            $healthInsurance = $addmissiontimehead[7]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['8']['feeshead']['name'], $fessHeads)) {
            $idCard = $addmissiontimehead[8]['qu1_fees'];
        }

        // quarter1 courese total fee
        $student_rec['1st_year_total_fees'] = $tution_fees + $admission_fees + $collage_caution_fees + $Uniform + $Books + $pocketArticles + $libraryFees + $enrollmentFees + $healthInsurance + $idCard;
        $student_rec['1st_year_total_fees'] = $student_rec['1st_year_total_fees'] > 0 ? $student_rec['1st_year_total_fees'] : 'NA';

        // quarter2 courese total fee
        if (!in_array('Quater2', $fessHeads)) {
            $student_rec['2nd_year_total_fees'] = $classfee[0]['qu2_fees'] > 0 ? $classfee[0]['qu2_fees'] : 'NA';
        } else {
            $student_rec['2nd_year_total_fees'] = 'NA';
        }
        // quarter3 courese total fee
        if (!in_array('Quater3', $fessHeads)) {
            $student_rec['3rd_year_total_fees'] = $classfee[0]['qu3_fees'] > 0 ? $classfee[0]['qu3_fees'] : 'NA';
        } else {
            $student_rec['3rd_year_total_fees'] = 'NA';
        }
        // quarter4 courese total fee
        if (!in_array('Quater4', $fessHeads)) {
            $student_rec['4th_year_total_fees'] = $classfee[0]['qu4_fees'] > 0 ? $classfee[0]['qu4_fees'] : 'NA';
        } else {
            $student_rec['4th_year_total_fees'] = 'NA';
        }

        //for transport
        if ($students_details['is_transport'] == 'Y') {
            //transport1 total course fee
            if (!in_array('Transport1', $fessHeads)) {
                $transport_fees1 = $transporthead[0]['qu1_fees'];
                $student_rec['1st_year_transport_fees'] = $transport_fees1 > 0 ? $transport_fees1 : 'NA';
            } else {
                $student_rec['1st_year_transport_fees'] = 'NA';
            }
            //transport2 total course fee
            if (!in_array('Transport2', $fessHeads)) {
                $transport_fees2 = $transporthead[0]['qu2_fees'];
                $student_rec['2nd_year_transport_fees'] = $transport_fees2 > 0 ? $transport_fees2 : 'NA';
            } else {
                $student_rec['2nd_year_transport_fees'] = 'NA';
            }
            //transport3 total course fee
            if (!in_array('Transport3', $fessHeads)) {
                $transport_fees3 = $transporthead[0]['qu3_fees'];
                $student_rec['3rd_year_transport_fees'] = $transport_fees3 > 0 ? $transport_fees3 : 'NA';
            } else {
                $student_rec['3rd_year_transport_fees'] = 'NA';
            }
            //transport4 total course fee
            if (!in_array('Transport4', $fessHeads)) {
                $transport_fees4 = $transporthead[0]['qu4_fees'];
                $student_rec['4th_year_transport_fees'] = $transport_fees4 > 0 ? $transport_fees4 : 'NA';
            } else {
                $student_rec['4th_year_transport_fees'] = 'NA';
            }
        } else {
            $student_rec['1st_year_transport_fees'] = 'NA';
            $student_rec['2nd_year_transport_fees'] = 'NA';
            $student_rec['3rd_year_transport_fees'] = 'NA';
            $student_rec['4th_year_transport_fees'] = 'NA';
        }

        // for total courese previous year fee
        $studentfeesprevioustot = $Studentfees_articles->find('all')->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter LIKE' => '%Previous Year Due%', 'Studentfees.status' => 'Y'])->first();
        $quas = unserialize($studentfeesprevioustot['quarter']);
        $student_rec['previous_year'] = $quas['Previous Year Due'] + $students_details['due_fees'];
        $student_rec['previous_year'] = $student_rec['previous_year'] > 0 ? $student_rec['previous_year'] : 0;
        return $student_rec;
    }


    // for custom pagenation by lokesh sir
    private function paginateArray($data, $limit)
    {
        $page = $this->request->query('page') ?? 1;
        $total = count($data);
        $pages = ceil($total / $limit);
        $offset = ($page - 1) * $limit;

        $paginatedData = array_slice($data, $offset, $limit);
        return [
            'data' => $paginatedData,
            'paging' => [
                'page' => $page,
                'total' => $total,
                'pages' => $pages,
                'limit' => $limit,
                'prev' => $page > 1 ? $page - 1 : null,
                'next' => $page < $pages ? $page + 1 : null,
            ]
        ];
    }


    public function resultinfo($id = null)
    {
        if ($_GET['ids']) {
            $this->set('students_id', $_GET['ids']);
        }
    }
}
